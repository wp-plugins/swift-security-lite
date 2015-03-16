<?php 
/**
 * Plugin Name: Swift Security Lite
 * Plugin URI: http://swiftsecurity.swte.ch
 * Description: Hide the fact that you are using WordPress, enable a well-configurable, secure firewall, run scheduled code scans
 * Version: 1.2.6
 * Author: SWTE
 * Author URI: http://swte.ch
 **/
 
class SwiftSecurity{
	
	private $InfoMessages = array(
	  'Did you know that you can completely hide WordPress with Swift Security PRO version?',
	  'Did you know that the Swift Security PRO version can filter POST requests and malicious file uploads as well?',
	  'Did you know that Swift Security PRO version has 7/24 support?',
	  'If you are using Swift Security PRO nobody can figure it out that you are using WordPress',
	  'Did you know that Swift Security PRO has a built in Code Scanner?',
	  'Did you know that Swift Security PRO has a comment spam blocker without captcha?',
	  'Did you know that Swift Security PRO is compatible with child themes?'
	);

	/**
	 * Htaccess rewrites and settings
	 * @var string
	 */
	private $_htaccess = array();
	
	/**
	 * Wordpress version
	 * @var string
	 */
	private $_version;
	
	/**
	 * Create the SwiftSecurity object
	 */
	public function __construct(){
		//Set version
		$this->_version = get_bloginfo('version');
		
		//Set localization
		add_action( 'plugins_loaded', array($this, 'LoadTextDomain') );		
		
		//Set the plugin-wide constants
		$this->SetConstants();
		
		//Set Environment info
		$this->environment = SwiftSecurity::CheckEnvironment();
		
		//Get active plugins
		$this->ActivePlugins = get_option('active_plugins',array());
		
		//Include general functions
		SwiftSecurity::FileInclude('functions');
		
		//Include Dashboard class
		SwiftSecurity::ClassInclude('Dashboard');
		
		//Create settings instance
		SwiftSecurity::ClassInclude('Settings');
		$this->SettingsObject = new Settings();
				
		//Get settings
		$this->settings = $this->SettingsObject->GetSettings();
		
		//Flush rewrites on switch theme
		add_action('switch_theme', array( $this, 'ThemeSwitched'));

		//Load modules
		$this->LoadModules();
		
		if (is_admin()) {
			//Hook for activate plugin
			register_activation_hook( __FILE__, array( $this, 'Activate' ) );
			
			//Hook for deactivate plugin
			register_deactivation_hook( __FILE__, array( $this, 'Deactivate' ) );
	
			//Create the admin menu
			add_action( 'admin_menu', array( $this, 'AdminMenu' ) );
			
			//Plugin action links
			add_filter('plugin_action_links', array($this, 'ActionLinks'), 10, 2);
						
			//Save settings modifications
			if (isset($_POST['swift-security-settings-save'])){
				try {
					//Save settings
					$settings = (isset($_POST['settings']) ? $_POST['settings'] : array());
					$this->SettingsObject->SaveSettings($settings);
					//Get settings
					$this->settings = $this->SettingsObject->GetSettings();
					
					$GLOBALS['SwiftSecurityMessage']['message'] = __('Settings saved. Don`t forget to clear cache if you are using cache','SwiftSecurity');
					$GLOBALS['SwiftSecurityMessage']['type'] = 'sft-notification-success';
					add_action('admin_notices', array('SwiftSecurity','AdminNotice'));
						
				} catch (SettingsException $e) {
					$GLOBALS['SwiftSecurityMessage']['message'] = $e->getMessage();
					$GLOBALS['SwiftSecurityMessage']['type'] = 'sft-notification-error';
					add_action('admin_notices', array('SwiftSecurity','AdminNotice'));
				}
			}
			
			//Cookie management, empty cache, rewrites and redirect after modify modules
			if ($this->SettingsObject->isModified){
				//Do the changes
				add_action('init', array($this, 'Modified'));
								
				//Empty htaccess and reload modules to regenerate htaccess
				$this->_htaccess = array();
				$this->LoadModules();
				
				//Update htaccess
				$this->FlushHtaccess();
			}
			
			//Enqueue plugin's custom styles
			add_action('init', array($this, 'EnqueueAssets'));
			
			add_action('admin_notices', array('SwiftSecurity','ShowPermanentMessage'));
			if (mt_rand(0,100) > 70){
				add_action('admin_notices', array($this,'InfoMessage'));
			}
		}
		
		//Parse SwiftSecurtity requests
		add_action('parse_request', array($this, 'ParseRequest'));
			
		//Add query vars
		add_filter('query_vars', array($this,'WPQueryVars'));
				
		//Set plugins order
		add_action('init',array($this,'SetPluginsOrder'));
		add_action('wp_footer',array($this,'SetPluginsOrder'));
		
		//Load 3rd party plugin conflict patches
		$this->ThirdPartyCompatibility();
	}
		
	/**
	 * Load requested modules 
	 */
	public function LoadModules(){
		//Destroy Hide Wordpress if it is already loaded
		if (isset($this->HideWP)){
			$this->HideWP->Destroy();
		}
		
		//Initialize the Hide Wordpress module
		if ($this->settings['Modules']['HideWP'] == 'enabled'){
			SwiftSecurity::ClassInclude('HideWP');
			$this->HideWP = new HideWP($this->settings);
			$this->AddHtaccess($this->HideWP);
		}
		
		////Initialize the Firewall module
		if ($this->settings['Modules']['Firewall'] == 'enabled'){
			SwiftSecurity::ClassInclude('Firewall');
			$this->Firewall = new Firewall($this->settings, $this->wp_session);
			$this->AddHtaccess($this->Firewall);
		}		
	}
	
	/**
	 * Set the plugin-wide constants
	 */
	public function SetConstants(){
		//Plugin directory
		if (!defined('SWIFTSECURITY_PLUGIN_DIR')){
			define('SWIFTSECURITY_PLUGIN_DIR', dirname(__FILE__));
		}
		
		//Plugin URL
		if (!defined('SWIFTSECURITY_PLUGIN_URL')){
			define('SWIFTSECURITY_PLUGIN_URL', plugins_url('', __FILE__ ));
		}
		
		//Version key
		if (!defined('SWIFTSECURITY_VERSION_KEY')){
			define('SWIFTSECURITY_VERSION_KEY', 'swiftsecurity_version');
		}
		
		//Version number
		if (!defined('SWIFTSECURITY_VERSION_NUM')){
			define('SWIFTSECURITY_VERSION_NUM', '1.2.6');
		}
		
		//Version number
		if (!defined('SWIFTSECURITY_SUPPORT_EMAIL')){
			define('SWIFTSECURITY_SUPPORT_EMAIL', 'support@swte.ch');
		}
		
		//Version number
		if (!defined('SWIFTSECURITY_UPGRADE_PRO')){
			define('SWIFTSECURITY_UPGRADE_PRO', 'http://bit.ly/166mtTK');
		}
	}
	
	/**
	 * Activate the plugin, add redirection rules to .htaccess 
	 */
	public function Activate() {
		/* 
		 * Modify the htaccess
		 */
		
		//Check the .htaccess is writable
		SwiftSecurity::CompatibilityCheck('htaccess', true);
		
		//Check the compatibility for Hide Woddpress
		try {
			SwiftSecurity::CompatibilityCheck('HideWP');
		}
		catch(SettingsException $e){
			$this->settings['Modules']['HideWP'] = 'disabled';
		}
			
		update_option('swiftsecurity_lite_plugin_options', $this->settings);
		
		//Do the changes
		$this->Modified();
		
		//Flush .htaccess settings
		$this->FlushHtaccess();
		
		//Set the version
		update_option(SWIFTSECURITY_VERSION_KEY, SWIFTSECURITY_VERSION_NUM);
		
	}
	 
	/**
	 * Deactivate the plugin, and calls RemoveHtaccess to remove .htaccess modifications
	 */
	public function Deactivate() {
		//Check the .htaccess is writable
		SwiftSecurity::CompatibilityCheck('htaccess', true);
		
		//Change permalinks to default and destroy Hide Wordpress module
		if (isset($this->HideWP)){
			$this->HideWP->Destroy();
		}
		
		//Remove SwiftSecurity settings from .htaccess
		$this->RemoveHtaccess();
		
		//Remove options
		delete_option('swiftsecurity_cdn_cache');
		delete_option('swiftsecurity_log');
		delete_option('swiftsecurity_dismissable_messages');
		delete_option('swiftsecurity_wpscan');
	}
	
	/**
	 * Run if settings changed, and at plugin activation
	 */
	public function Modified(){
		if ($this->settings['Modules']['HideWP'] == 'enabled'){
			$this->HideWP->ResetSqCookie();
			$this->HideWP->CreateSqCookie();
		}
		else{
			//Change permalinks to default
			if (!isset($this->HideWP)){
				SwiftSecurity::ClassInclude('HideWP');
				$this->HideWP = new HideWP($this->settings);
			}
			$this->HideWP->Destroy();
		}
	}
	
	/**
	 * Modify the plugin-wide htaccess settings
	 * @param SwiftSecurityModul $modulObject
	 */
	public function AddHtaccess($modulObject){
		$startPadding = '###SwSc/'.$modulObject->moduleName.'###'.PHP_EOL;
		$endPadding = PHP_EOL.'###END SwSc/'.$modulObject->moduleName.'###'.PHP_EOL;
		$this->_htaccess[$modulObject->moduleName] =  $startPadding . $modulObject->GetHtaccess() . $endPadding;
	}
	
	
	/**
	 * Flush htaccess rewrite rules
	 */
	public function FlushHtaccess(){
		$this->RemoveHtaccess();
		
		$Options = '';
		$ErrorDucument = '';
		$SitePath = parse_url(site_url(),PHP_URL_PATH);
		
		$htaccess = file_get_contents(ABSPATH . '.htaccess');
		
		//Error document handling (we set the index.php to handle 404 if there isn't set a specific 404 page)
		if (!preg_match('~ErrorDocument(\s*)404~',$htaccess)){
			$ErrorDucument .= 'ErrorDocument 404 '.$SitePath.'/index.php?SwiftSecurity=404'.PHP_EOL;
		}
		if (!preg_match('~ErrorDocument(\s*)403~',$htaccess)){
			$ErrorDucument .= 'ErrorDocument 403 '.$SitePath.'/index.php?SwiftSecurity=403'.PHP_EOL;
		}
		//Turn off directory listing
		if (!preg_match('~Options -Indexes~',$htaccess)){
			$Options .= 'Options -Indexes'.PHP_EOL;
		}
		
		$htaccess ='######BEGIN SwiftSecurity######'.PHP_EOL.@$ErrorDucument.@$Options.PHP_EOL.implode(PHP_EOL, (array)$this->_htaccess).PHP_EOL.'######END SwiftSecurity######' . PHP_EOL . PHP_EOL . $htaccess;
		file_put_contents(ABSPATH . '.htaccess', $htaccess);
		
		//Check htaccess is working
		$response = wp_remote_get(home_url(),array('timeout' => 60));
		if (is_wp_error($response)){
			$this->RevertSettings('900 (' . $response->get_error_message() .')');
		}
		else if (!preg_match('~(2|3)([0-9]){2}~',$response['response']['code'])){
			$this->RevertSettings($response['response']['code']);
		}
		
	}
	
	/**
	 * Remove the plugin redirection rules from .htaccess
	 */
	public function RemoveHtaccess() {
		$htaccess = file_get_contents(ABSPATH . '.htaccess');
		$htaccess = preg_replace("~######BEGIN SwiftSecurity######(.*)######END SwiftSecurity######(\s*)?~s",'',$htaccess);
		file_put_contents(ABSPATH . '.htaccess', $htaccess);
	}
	
	/**
	 * Turn off the modules and remove Swift Security lines from htaccess
	 */
	public function RevertSettings($code){
		//Turn off modules
		$this->settings['Modules']['HideWP'] = 'disabled';
		$this->settings['Modules']['Firewall'] = 'disabled';
		
		//Update settings
		update_option('swiftsecurity_lite_plugin_options', $this->settings);
		$this->settings = $this->SettingsObject->GetSettings();
		
		//Empty htaccess and reload modules to regenerate htaccess
		$this->_htaccess = array();
		$this->LoadModules();
		
		//Update htaccess
		$this->FlushHtaccess();
		
		$GLOBALS['SwiftSecurityMessage']['message'] = __('Error! There is some misconfiguration in the settings. Please check the settings and try again. If the problem persists, please contact us: ' . SWIFTSECURITY_SUPPORT_EMAIL . '. Error code: ', 'SwiftSecurity') . $code;
		$GLOBALS['SwiftSecurityMessage']['type'] = 'sft-notification-error';
		add_action('admin_notices', array('SwiftSecurity','AdminNotice'));
	}
	
	/**
	 * Regenerate and reflush htaccess after theme switch
	 */
	public function ThemeSwitched(){
		//Get settings
		$this->settings = $this->SettingsObject->GetSettings();
		
		//Empty htaccess and reload modules to regenerate htaccess
		$this->_htaccess = array();
		$this->LoadModules();
		
		//Update htaccess
		$this->FlushHtaccess();
	}
	
	/**
	 * Show error messages
	 * @param string $message
	 * @param integer $errno
	 */
	public static function ShowError($message, $errno) {
		if(isset($_GET['action']) && $_GET['action'] == 'error_scrape') {
			echo '<strong>' . $message . '</strong>';
			exit;
		} else {
			trigger_error($message, $errno);
		}
	
	}
	
	/**
	 * Process plugin requests
	 */
	public function ParseRequest($wp) {
		if (array_key_exists('SwiftSecurity', $wp->query_vars)) {
			SwiftSecurity::FileInclude($wp->query_vars['SwiftSecurity']);
		}
	}
	
	/**
	 * Add plugin query vars to WP query vars
	 */
	public function WPQueryVars($vars) {
		$vars[] = 'SwiftSecurity';
		$vars[] = 'attempt';
		$vars[] = 'channel';
		return $vars;
	}
	
	/**
	 * Create the admin setting page
	 */
	public function AdminMenu() {	
		//Create admin menu
		add_menu_page( 'Swift Security Options', 'Swift Security', 'manage_options', 'SwiftSecurity', array('Dashboard', 'LoadTemplate'),  plugins_url('images/icon.png', __FILE__));
		
		//Dashboard
		add_submenu_page( 'SwiftSecurity', 'Dashboard', 'Dashboard', 'manage_options', 'SwiftSecurity',  array('Dashboard', 'LoadTemplate'));
		
		//Create HideWordpress submenu
		add_submenu_page( 'SwiftSecurity', 'Hide WordPress', 'Hide WordPress', 'manage_options', 'SwiftSecurityHideWP',  array('Dashboard', 'LoadTemplate'));

		//Create Firewall submenu
		add_submenu_page( 'SwiftSecurity', 'Firewall', 'Firewall', 'manage_options', 'SwiftSecurityFirewall',  array('Dashboard', 'LoadTemplate'));

		//Create CodeScanner submenu
		add_submenu_page( 'SwiftSecurity', 'Code Scanner', 'Code Scanner', 'manage_options', 'SwiftSecurityCodeScanner',  array('Dashboard', 'LoadTemplate'));

		//Create General Settings submenu
		add_submenu_page( 'SwiftSecurity', 'General Settings', 'General Settings', 'manage_options', 'SwiftSecurityGeneralSettings',  array('Dashboard', 'LoadTemplate'));		
		
	}
	
	/**
	 * Action links for plugin settings page
	 * @param string links
	 * @param string $file
	 * @return string
	 */
	public function ActionLinks($links, $file) {
		$this_plugin = plugin_basename(__FILE__);
	
		if ($file == $this_plugin) {
			$settings_link = '<a href="' . admin_url('admin.php?page=SwiftSecurity') . '">'.__('Settings','SwiftSecurity').'</a>';
			$upgrade_link = '<a href="' . SWIFTSECURITY_UPGRADE_PRO . '">'.__('Upgrade PRO','SwiftSecurity').'</a>';
			array_unshift($links, $settings_link);
		}
	
		return $links;
	}
	
	/**
	 * Localization
	 */
	public function LoadTextDomain(){
		load_plugin_textdomain( 'SwiftSecurity', false, dirname(plugin_basename( __FILE__ )) . '/languages' );
	}
	
	/**
	 * Enqueue assets
	 */
	public function EnqueueAssets(){
		$cssFile = (file_exists(SWIFTSECURITY_PLUGIN_DIR . '/css/style_v'.$this->_version.'.css') ? 'style_v'.$this->_version.'.css' : 'style.css');
		wp_enqueue_style('swiftsecurity-style', plugins_url('css/' . $cssFile, __FILE__));
		wp_enqueue_style('nouislider-style', plugins_url('css/jquery.nouislider.css', __FILE__));
	}
	
	/**
	 * Patches and overwrites to fix compatibility issues with other plugins and themes
	 */
	public function ThirdPartyCompatibility(){
		//Aqua Resizer
		SwiftSecurity::FixInclude('aq_resizer');
	
		//Load modified get_resized_image function if Coworker theme in use
		if (get_template() == 'coworker'){
			SwiftSecurity::FixInclude('coworker');
		}
	}
	
	/**
	 * Set Swift Security to load first
	 */
	public function SetPluginsOrder(){
		//Force to load Swift Security before all other plugins
		$plugin_path = basename(dirname(__FILE__)) . "/SwiftSecutity.php";
		$key = array_search($plugin_path, $this->ActivePlugins);
		if ($key > 0) {
			array_splice($this->ActivePlugins, $key, 1);
			array_unshift($this->ActivePlugins, $plugin_path);
			update_option('ActivePlugins', $this->ActivePlugins);
		}
	}
	
	/**
	 * Send e-mail notifications
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 */
	public static function SendEmailNotification($to, $subject, $message){
		//Attach logo image
		add_action('phpmailer_init', array('SwiftSecurity', 'AddEmbeddedImage'));
		
		//Set wp_mail to send HTML e-mails
		add_filter( 'wp_mail_content_type', array('SwiftSecurity','SetMailContentType'));
	
		wp_mail($to, $subject, $message);
	}
	
	/**
	 * Add embedded image to email notifications
	 */
	public static function AddEmbeddedImage(){
		global $phpmailer;
		if (is_object($phpmailer)){
			$phpmailer->SMTPKeepAlive = true;
			$phpmailer->AddEmbeddedImage(SWIFTSECURITY_PLUGIN_DIR . '/images/mail-logo.png', 'swiftsecurity-logo', 'mail-logo.png');
		}
	}
	
	/**
	 * Set content-type to text/html for email notifications
	 * @param string $content_type
	 * @return string
	 */
	public static function SetMailContentType($content_type = ''){
		return 'text/html';
	}
	
	/**
	 * Include files from include path
	 * @param string $inc included file name without .inc.php
	 */
	public static function FileInclude($inc){
		include_once SWIFTSECURITY_PLUGIN_DIR . '/includes/' . $inc . '.inc.php';
	}
	
	/**
	 * Include class files from classes path
	 * @param string $class included file name without .class.php
	 */
	public static function ClassInclude($class){
		include_once SWIFTSECURITY_PLUGIN_DIR . '/classes/' . $class . '.class.php';
	}
	
	
	/**
	 * Include overwrites to fix compatibility issues with other plugins and themes
	 * @param string $fix included file name without .fix.php
	 */
	public static function FixInclude($fix){
		include_once SWIFTSECURITY_PLUGIN_DIR . '/compatibility/' . $fix . '.fix.php';
	}
	
	
	/**
	 * Show custom admin notices
	 */
	public static function AdminNotice(){
		echo '<div class="'.$GLOBALS['SwiftSecurityMessage']['type'].'">'.$GLOBALS['SwiftSecurityMessage']['message'].'</div>';
	}
	
	/**
	 * Show info messages
	 */
	public function InfoMessage(){
		$message = __($this->InfoMessages[mt_rand(0,count($this->InfoMessages)-1)],'SwiftSecurity');
		echo '<div class="sft-notification-info">'.$message.' <a href="'.SWIFTSECURITY_UPGRADE_PRO.'" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div>';
	}
	
	/**
	 * Compatibility checks
	 * @param string $module
	 * @param boolean $hard
	 * @return boolean
	 */
	public static function CompatibilityCheck($module = '', $hard = false){
		$compatible = true;
		$environment = SwiftSecurity::CheckEnvironment();
			
		//Check Hide Wordpress compatibility
		if ($module == 'HideWP'){
			//This version is not works with multisite
			if (is_multisite()){
				$message = __('The Hide Wordpress module does not work with multisite', 'SwiftSecurity');
				$compatible = false;
			}
				
			//This version is working with Apache only
			if (!preg_match('~(apache|litespeed)~i', $environment['ServerSoftware'])){
				$message = __('The Hide Wordpress module working only with Apache webserver', 'SwiftSecurity');
				$compatible = false;
			}
		}
	
		//Check Firewall compatibility
		if ($module == 'Firewall'){
			//This version is not works with multisite
			if (!function_exists('curl_version')){
				$message = __('CURL extension is not enabled. You can\'t use the POST filtering' , 'SwiftSecurity');
				$compatible = false;
			}
		}
		
		//Check Firewall compatibility
		if ($module == 'CodeScanner'){
			//This version is not works with multisite
			if (ini_get('safe_mode')){
				$message = __('Can\'t run scheduled scans in PHP safe mode' , 'SwiftSecurity');
				$compatible = false;
			}
		}
	
		//Check is htaccess writable or not
		if ($module == 'htaccess'){
			if ((file_exists(ABSPATH . '.htaccess') && !is_writable(ABSPATH . '.htaccess')) || (!file_exists(ABSPATH . '.htaccess') && !is_writable(ABSPATH))){
				$message = __('The '.ABSPATH.'.htaccess file is not writable for WordPress. Please change the permissions.','SwiftSecurity');
				$compatible = false;
			}
		}
	
		if ($compatible == false){
			if ($hard == false){
				throw new SettingsException(array(
						'message' => $message
				));
			}
			else{
				SwiftSecurity::ShowError($message,E_USER_ERROR);
			}
		}
	
		return $compatible;
	}
	
	/**
	 * Set authentication cookie
	 * @param string $auth_cookie
	 * @param string $expire
	 * @param string $expiration
	 * @param string $user_id
	 * @param string $scheme
	 */
	public static function SwiftSecuritySetAuthCookie($auth_cookie, $expire = 0, $expiration = 0 , $user_id = '', $scheme = ''){
		if (class_exists('WP_Session_Tokens')){
			$manager = WP_Session_Tokens::get_instance( $user_id );
			$token = $manager->create( $expiration );
		}
		
		$secure = is_ssl();
		
		if ( $secure ) {
			$auth_cookie_name = SECURE_AUTH_COOKIE;
			$scheme = 'secure_auth';
		} else {
			$auth_cookie_name = AUTH_COOKIE;
			$scheme = 'auth';
		}
		
		setcookie($auth_cookie_name, $auth_cookie, $expire, SWIFT_PLUGINS_COOKIE_PATH, COOKIE_DOMAIN, false, true);
		setcookie($auth_cookie_name, $auth_cookie, $expire, SWIFT_ADMIN_COOKIEPATH, COOKIE_DOMAIN, false, true);
	}
	
	/**
	 * Clear authentication and logged in cookies
	 */
	public static function SwiftSecurityClearAuthCookies(){
		setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, SWIFT_ADMIN_COOKIEPATH,   COOKIE_DOMAIN );
		setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, SWIFT_ADMIN_COOKIEPATH,   COOKIE_DOMAIN );
		setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, SWIFT_PLUGINS_COOKIE_PATH, COOKIE_DOMAIN );
		setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, SWIFT_PLUGINS_COOKIE_PATH, COOKIE_DOMAIN );
	}
	
	
	/**
	 * Show dismissable messages
	 */
	public static function ShowPermanentMessage(){
		$messages = get_option('swiftsecurity_dismissable_messages',array());
		foreach ((array)$messages as $message){
			if (!$message['read']){
				echo '<div class="sft-notification-'.$message['type'].'">'.$message['message'].'</div>';
			}
		}
	}
	
	/**
	 * Set a permanent message for admin
	 * @param string $key 
	 * @param string $message
	 * @param string $type
	 * @param boolean $dismissable (default is true)
	 */
	public static function SetPermanentMessage($key, $message, $type, $dismissable = true){
		$messages = get_option('swiftsecurity_dismissable_messages');
		if (!isset($messages[$key])){
			$messages[$key]['message'] = $message;
			$messages[$key]['type'] = $type;
			$messages[$key]['dismissable'] = $dismissable;
			$messages[$key]['read'] = false;
			update_option('swiftsecurity_dismissable_messages', $messages);
		}
	}
	
	/**
	 * Remove a permanent message 
	 * @param string $key
	 */
	public static function RemovePermanentMessage($key){
		$messages = get_option('swiftsecurity_dismissable_messages');
		if (isset($messages[$key])){
			unset($messages[$key]);
			update_option('swiftsecurity_dismissable_messages', $messages);
		}
	}
	
	/**
	 * Check the environment 
	 * @return array
	 */
	public static function CheckEnvironment(){
		$environment['ServerSoftware'] = $_SERVER['SERVER_SOFTWARE'];
		$environment['ManagedHosting'] = null;
		
		if (function_exists('get_mu_plugins')){
			$mu_plugins = get_mu_plugins();
			if (isset($mu_plugins['mu-plugin.php']) && preg_match('~WP Engine~i',$mu_plugins['mu-plugin.php']['Name'])){
				$environment['ManagedHosting'] = 'WPEngine';
			}
		}
		
		return $environment;
	}
		
}
defined('ABSPATH') or die("KEEP CALM AND CARRY ON");

$SwiftSecurity = new SwiftSecurity();

?>
