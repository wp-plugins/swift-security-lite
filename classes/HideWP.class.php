<?php

/**
 * Hide wordpress from non-logged in users
 * It change the plugins, upload, template directories and some WP specific files (eg: wp-login.php)
 * Prevent to access php files directly (eg /wp-config.php)
 * Change queries (?p=1, ?cat=2, etc...)
 * Cleans the <head> tag (remove rss links, shortlinks, etc...)
 * Replace custom strings in html source
 * Custom rewrite rules
 * Change classnames and ids in HTML, JS, and CSS source
 */
class HideWp {
	
	/**
	 * Define the module name
	 * @var string
	 */
	public $moduleName = 'HideWP';
	
	/**
	 * Create the HideWP object
	 */
	public function __construct($settings){
		//Get the settings
		$this->_settings		= $settings['HideWP'];
		$this->_globalSettings	= $settings['GlobalSettings'];
		
		if ($settings['Modules']['HideWP'] == 'enabled'){
			$this->Init();
		}
		
		//Set WP_ADMIN because POST Proxy loose it
		if (!defined('WP_ADMIN') && preg_match('~^/'.$this->_settings['redirectDirs']['wp-admin'] . '/admin.php~',$_SERVER['REQUEST_URI'])){
			define ('WP_ADMIN', true);
		}
	}
	
	/**
	 * Initialize Hide Wordpress
	 */
	public function Init(){
		//Set secure query cookie for logged-in user
		add_action('wp_login', array($this, 'CreateSqCookie'));
		
		//Reset secure query cookie
		add_action('wp_logout', array($this, 'ResetSqCookie'));

		//Replace admin login/logout urls
		if (isset($this->_settings['redirectDirs']['wp-admin'])){
			add_filter('admin_url', array($this, 'ReplaceAdminUrl'));
		}
		
		//Replace login/logout urls
		if (isset($this->_settings['redirectFiles']['wp-login.php'])){
			$filters = array(
					'login_url',
					'logout_url',
					'register_url',
					'wp_redirect',
					'retrieve_password_message'
			);
			add_filters($filters, array($this, 'ReplaceLoginUrl'));
			
			add_filter('lostpassword_url', array($this,'ReplaceLostpasswordUrl'));
			
			add_action('wp_logout', array($this, 'RedirectLogout'));
		}
		
		//Include cookie sets to handle folder overrides
		$this->SetConstants();
		add_action('set_auth_cookie', array('SwiftSecurity','SwiftSecuritySetAuthCookie'));
		add_action('clear_auth_cookie', array('SwiftSecurity','SwiftSecurityClearAuthCookies'));

		//Replace post url for login forms
		add_action('init', array($this, 'ReplaceLoginContent'), 0);		
	} 
	
	/**
	 * Destroy all redirects and rewrites
	 * It is using when turn off the module
	 */
	public function Destroy(){
		//Set secure query cookie for logged-in user
		remove_action('wp_login', array($this, 'CreateSqCookie'));
		
		//Reset secure query cookie
		remove_action('wp_logout', array($this, 'ResetSqCookie'));
		
		//Replace admin login/logout urls
		if (isset($this->_settings['redirectDirs']['wp-admin'])){
			remove_filter('admin_url', array($this, 'ReplaceAdminUrl'));
		}
		
		//Replace login/logout urls
		if (isset($this->_settings['redirectFiles']['wp-login.php'])){
			$filters = array(
					'login_url',
					'logout_url',
					'register_url',
					'wp_redirect',
					'retrieve_password_message'					
			);
			remove_filters($filters, array($this, 'ReplaceLoginUrl'));
				
			remove_filter('lostpassword_url', array($this,'ReplaceLostpasswordUrl'));
				
			remove_action('wp_logout', array($this, 'RedirectLogout'));
		}
		
		//Include cookie sets to handle folder overrides
		remove_action('set_auth_cookie', array('SwiftSecurity','SwiftSecuritySetAuthCookie'));
		remove_action('clear_auth_cookie', array('SwiftSecurity','SwiftSecurityClearAuthCookies'));
		
		//Replace post url for login forms
		remove_action('login_head', array($this, 'ReplaceLoginContent'), 0);
	}
		
	/**
	 * Replace admin URL
	 * @param string $path
	 * @param string $scheme
	 * @return string
	 */
	public function ReplaceAdminUrl($path = '', $scheme = 'admin' ) {
		return preg_replace('~wp-admin~', $this->_settings['redirectDirs']['wp-admin'] ,$path);
	}
	
	/**
	 * Replace login (and logout) URL
	 * @param string $path
	 * @return string
	 */
	public function ReplaceLoginUrl($path = '') {
		$path = preg_replace('~wp-login\.php~', $this->_settings['redirectFiles']['wp-login.php'] ,htmlspecialchars_decode($path));
		//Add redirect to for register_url
		parse_str(parse_url($path, PHP_URL_QUERY),$QueryStrings);
		if (isset($QueryStrings['action']) && $QueryStrings['action'] == 'register'){
			$QueryStrings['redirect_to'] = home_url() . '/' . $this->_settings['redirectFiles']['wp-login.php'] . '?checkemail=registered';
		}
		return home_url(parse_url($path, PHP_URL_PATH) . (count($QueryStrings) > 0 ? '?'.http_build_query($QueryStrings) : ''));
	}
	
	/**
	 * Replace lost password URL
	 * @param string $path
	 * @param string $redirect
	 */
	public function ReplaceLostpasswordUrl($path = '', $redirect = '') {
		$redirect = preg_replace('~wp-login\.php~', $this->_settings['redirectFiles']['wp-login.php'] ,$redirect);
		return preg_replace('~wp-login\.php~', $this->_settings['redirectFiles']['wp-login.php'] ,$path);
	}
	
	/**
	 * Redirect to rewrited login url instead of wp-login.php 
	 * @param string $path
	 * @return string
	 */
	public function RedirectLogout() {
		wp_redirect(get_option('home') . '/' . SWIFT_LOGIN_URL);
		exit;
	}
	
	/**
	 * Set the new constants (like PLUGINS_COOKIE_PATH, ADMIN_COOKIEPATH, etc...)
	 */
	public function SetConstants(){		
		if (!defined('SQ')){
			define('SQ', $this->_globalSettings['sq']);
		}
		
		//Admin URL
		if (!defined('SWIFT_ADMIN_URL')){
			$admin_url = (isset($this->_settings['redirectDirs']['wp-admin']) ? $this->_settings['redirectDirs']['wp-admin'] : 'wp-admin');
			define('SWIFT_ADMIN_URL', $admin_url);
		}
		
		//Login URL
		if (!defined('SWIFT_LOGIN_URL')){
			$login_url = (isset($this->_settings['redirectFiles']['wp-login.php']) ? $this->_settings['redirectFiles']['wp-login.php'] : 'wp-login.php');
			define('SWIFT_LOGIN_URL', $login_url);
		}
		
		//Admin cookie path
		if (!defined('SWIFT_ADMIN_COOKIEPATH')){
			$admin_cookie_path = (isset($this->_settings['redirectDirs']['wp-admin']) ? SITECOOKIEPATH . $this->_settings['redirectDirs']['wp-admin'] : ADMIN_COOKIEPATH);
			define('SWIFT_ADMIN_COOKIEPATH', $admin_cookie_path);
		}
	}
	

	/**
	 * Start output buffering to replace values in login page content
	 * Calls ReplaceLoginContentCallback
	 */
	public function ReplaceLoginContent(){
			ob_start(array(&$this,"ReplaceLoginContentCallback"));
	}
		
	/**
	 * Replace post action for login page
	 * @param string $buffer
	 * @return string
	 */
	public function ReplaceLoginContentCallback($buffer) {
		if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ){
			$buffer = str_replace('wp-login.php', $this->_settings['redirectFiles']['wp-login.php'], $buffer);
			$buffer = str_replace('wp-admin', $this->_settings['redirectDirs']['wp-admin'], $buffer);
		}
			return $buffer;
	}

	/**
	 * Replace string in URL
	 * @param string $buffer
	 * @return string
	 */
	public function ReplaceString($buffer) {
		$buffer = str_replace('wp-login.php', $this->_settings['redirectFiles']['wp-login.php'], $buffer);
		return $buffer;
	}
	
	
	/**
	 * Build rewrite rules for .htaccess
	 */
	public function GetHtaccess(){
		$DirectoryRules = '';
		$Directory404 = '';
		$FileRules = '';
		$File404 = '';
		
		$SitePath = parse_url(site_url(),PHP_URL_PATH);
				
		//Admin URL without trailing slash
		$FileRules .= 'RewriteRule "^'.$this->_settings['redirectDirs']['wp-admin'] . '$" ' . $this->_settings['redirectDirs']['wp-admin'] . '/ [R=301,L]'.PHP_EOL;
		
		$DirectoryRules .= 'RewriteRule "^'.$this->_settings['redirectDirs']['wp-admin'].'/(.*)" wp-admin/$1?'.$this->_globalSettings['sq'].' [L,QSA]'.PHP_EOL;
		
		$Directory404 .= 'RewriteCond %{QUERY_STRING} !'.$this->_globalSettings['sq'].''.PHP_EOL;
		$Directory404 .= 'RewriteCond %{HTTP_COOKIE} !'.$this->_globalSettings['sq'].'=([0-9abcdef]+) [NC]'.PHP_EOL;
		$Directory404 .= 'RewriteRule "^wp-admin" - [R=404,L]'.PHP_EOL;
		
		$FileRules .= 'RewriteRule "^'.$this->_settings['redirectFiles']['wp-login.php'].'" wp-login.php?'.$this->_globalSettings['sq'].' [L,QSA]'.PHP_EOL;
		
		$File404 .= 'RewriteCond %{QUERY_STRING} !'.$this->_globalSettings['sq'].PHP_EOL;
		$File404 .= 'RewriteCond %{HTTP_COOKIE} !'.$this->_globalSettings['sq'].'=([0-9abcdef]+) [NC]'.PHP_EOL;
		$File404 .= 'RewriteRule "wp-login.php$"  - [R=404,L]'.PHP_EOL;
					
		$htaccess  = '<IfModule mod_rewrite.c>'.PHP_EOL;
		$htaccess .= 'RewriteEngine On'.PHP_EOL;
		$htaccess .= 'RewriteBase '.$SitePath.'/'.PHP_EOL.PHP_EOL;
		$htaccess .= $File404.PHP_EOL;
		$htaccess .= $FileRules.PHP_EOL;
		$htaccess .= $Directory404.PHP_EOL;
		$htaccess .= $DirectoryRules.PHP_EOL;
		$htaccess .= '</IfModule>'.PHP_EOL;
		return $htaccess;
	}
	
	/**
	 * Create Secure Query authentication cookie
	 * If this cookie is set all WP files and folders are accessable (eg: wp-login, wp-content/, etc...)
	 */
	public function CreateSqCookie(){
		setcookie($this->_globalSettings['sq'], md5(mt_rand(0,10000000000)),0,'/');
	}
	
	/**
	 * Reset secure query cookie
	 */
	public function ResetSqCookie(){
		setcookie($this->_globalSettings['sq']);
	}
		
}



?>