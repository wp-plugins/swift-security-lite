<?php 
/**
 * Firewall object
 * Block, log suspicious requests and send notifications
 *
 */
class Firewall{
	
	/**
	 * The name of the module
	 * @var string
	 */
	public $moduleName = 'Firewall';
	
	/**
	 * WP Session object
	 * @var WP_Session
	 */
	public $wp_session;
	
	/**
	 * Contains logging extra data (eg: attack type)
	 * @var array
	 */
	public $logData = array();
	
	/**
	 * Regural expression to filter GET requests
	 * @var string
	 */
	private $_SQLi = array();
	
	/**
	 * Regural expression to filter POST requests
	 * @var string
	 */
	private $_XSS = array();
	
	/**
	 * Regural expression to filter cookies
	 * @var string
	 */
	private $_Path = array();
	
	/**
	 * File injection filters
	 * @var array
	 */
	private $_File = array();
	
	/**
	 * Module settings
	 * @var array
	 */
	private $_settings = array();
	
	/**
	 * Plugin settings
	 * @var array
	 */
	private $_globalSettings = array();
	
	/**
	 * Create the firewall object
	 */
	public function __construct($settings){
		$this->_SQLi 			= (isset($settings['Firewall']['SQLi']) ? $settings['Firewall']['SQLi'] : array());
		$this->_XSS	 			= (isset($settings['Firewall']['XSS']) ? $settings['Firewall']['XSS'] : array());
		$this->_Path 			= (isset($settings['Firewall']['Path']) ? $settings['Firewall']['Path'] : array());
		$this->_settings		= (isset($settings['Firewall']['settings']) ? $settings['Firewall']['settings'] : array());
		$this->_globalSettings	= (isset($settings['GlobalSettings']) ? $settings['GlobalSettings'] : array());

		include_once SWIFTSECURITY_PLUGIN_DIR . '/helpers/wp-session-manager/wp-session-manager.php';
		$this->wp_session = WP_Session::get_instance();
						
		//Notification on login
		add_action('wp_login',  array($this, 'LogAuth'));
		
		//Notification failed login attempts
		add_action('wp_login_failed', array($this, 'LogFailedAuth'));
		
	}
	
	/**
	 * Return with the requested regexp string
	 * @param string $group (SQLi, XSS, Path, etc...) default is SQLi
	 * @param string $type (GET, POST, COOKIE)
	 * @return array 
	 */
	public function GetRegexp($group = 'SQLi', $type = 'POST'){
		$group = '_' . $group;
		$settings = $this->$group;
		if (isset($settings['settings'][$type]) && $settings['settings'][$type]== 'enabled'){
			return $settings[$type];
		}
		else{
			return array();		
		}
	}
	
	/**
	 * Build rewrite rules for .htaccess
	 */
	public function GetHtaccess(){
		$getSQLiRrewrites = '';
		$getXSSRrewrites = '';
		$getPathRrewrites = '';
		$SitePath = parse_url(site_url(),PHP_URL_PATH);
		
		//Build the GET exceptions 
		if (isset($this->_SQLi['exceptions']['GET'])){
			for ($i=0;$i<count($this->_SQLi['exceptions']['GET']);$i++){
				$getSQLiRrewrites .= 'RewriteCond %{REQUEST_URI} !'. $this->_SQLi['exceptions']['GET'][$i]. ' [NC]' . PHP_EOL;
			}
		}
		if (isset($this->_XSS['exceptions']['GET'])){
			for ($i=0;$i<count($this->_XSS['exceptions']['GET']);$i++){
				$getXSSRrewrites .= 'RewriteCond %{REQUEST_URI} !'. $this->_XSS['exceptions']['GET'][$i] . ' [NC]' . PHP_EOL;
			}
		}
		if (isset($this->_Path['exceptions']['GET'])){
			for ($i=0;$i<count($this->_Path['exceptions']['GET']);$i++){
				$getPathRrewrites .= 'RewriteCond %{REQUEST_URI} !'. $this->_Path['exceptions']['GET'][$i] . ' [NC]' . PHP_EOL;
			}
		}
		
		//Build GET rewrite regexp
		if (isset($this->_SQLi['GET'])){
			for ($i=0;$i<count($this->_SQLi['GET']);$i++){
				$ending = ($i < count($this->_SQLi['GET'])-1 ? ' [NC,OR]' : ' [NC]');
				$getSQLiRrewrites .= 'RewriteCond %{THE_REQUEST} ' . $this->_SQLi['GET'][$i] . $ending . PHP_EOL;
			}
		}
		if (isset($this->_XSS['GET'])){
			for ($i=0;$i<count($this->_XSS['GET']);$i++){
				$ending = ($i < count($this->_XSS['GET'])-1 ? ' [NC,OR]' : ' [NC]');
				$getXSSRrewrites .= 'RewriteCond %{THE_REQUEST} ' . $this->_XSS['GET'][$i] . $ending . PHP_EOL;
			}
		}
		if (isset($this->_Path['GET'])){
			for ($i=0;$i<count($this->_Path['GET']);$i++){
				$ending = ($i < count($this->_Path['GET'])-1 ? ' [NC,OR]' : ' [NC]');
				$getPathRrewrites .= 'RewriteCond %{THE_REQUEST} ' . $this->_Path['GET'][$i] . $ending . PHP_EOL;
			}
		}

		//Build the COOKIE exceptions
		if (isset($this->_SQLi['exceptions']['COOKIE'])){
			for ($i=0;$i<count($this->_SQLi['exceptions']['COOKIE']);$i++){
				$cookieSQLiRrewrites .= 'RewriteCond %{REQUEST_URI} !'. $this->_SQLi['exceptions']['COOKIE'][$i] . ' [NC]' . PHP_EOL;
			}
		}
		if (isset($this->_Path['exceptions']['COOKIE'])){
			for ($i=0;$i<count($this->_Path['exceptions']['COOKIE']);$i++){
				$cookiePathRrewrites .= 'RewriteCond %{REQUEST_URI} !'. $this->_Path['exceptions']['COOKIE'][$i] . ' [NC]' . PHP_EOL;
			}
		}
				
		$htaccess  = '<IfModule mod_rewrite.c>'.PHP_EOL;
		$htaccess .= 'RewriteEngine On'.PHP_EOL;
		$htaccess  .= 'RewriteBase '.$SitePath.'/'.PHP_EOL;
				
		//Add get rewrites if not empty
		if (!empty($getSQLiRrewrites) && $this->_SQLi['settings']['GET'] == 'enabled'){
			$htaccess  .= $getSQLiRrewrites;
			$htaccess  .= 'RewriteCond %{QUERY_STRING} !SwiftSecurity=firewall [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteCond %{REQUEST_URI} !^/index.php$ [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteRule (.*) index.php?SwiftSecurity=firewall&attempt=SQLi&channel=GET [L]'.PHP_EOL.PHP_EOL;
		}
		if (!empty($getXSSRrewrites) && $this->_XSS['settings']['GET'] == 'enabled'){
			$htaccess  .= $getXSSRrewrites;
			$htaccess  .= 'RewriteCond %{QUERY_STRING} !SwiftSecurity=firewall [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteCond %{REQUEST_URI} !^/index.php$ [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteRule (.*) index.php?SwiftSecurity=firewall&attempt=XSS&channel=GET [L]'.PHP_EOL.PHP_EOL;
		}
		if (!empty($getPathRrewrites) && $this->_Path['settings']['GET'] == 'enabled'){
			$htaccess  .= $getPathRrewrites;
			$htaccess  .= 'RewriteCond %{QUERY_STRING} !SwiftSecurity=firewall [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteCond %{REQUEST_URI} !^/index.php$ [NC]'.PHP_EOL;
			$htaccess  .= 'RewriteRule (.*) index.php?SwiftSecurity=firewall&attempt=Path&channel=GET [L]'.PHP_EOL.PHP_EOL;
		}
				
		$htaccess .= '</IfModule>'.PHP_EOL;
		
		return $htaccess;
	}
	
	/**
	 * Show the requested forbidden template
	 */
	public function Forbidden(){
		header("HTTP/1.1 403 Unauthorized");
		SwiftSecurity::FileInclude('403');		
		die;
	}
	
	/**
	 * Log the attack attempts
	 * @todo refactor this function because it designed only security events not login events
	 */
	public function Log($title = 'Blocked attack attempt', $autolog = true){
		SwiftSecurity::ClassInclude('SecurityLogObject');
		
		//Log the possible attack attempt
		$LogEntry = new SecurityLogObject($this->LogData, $this->_globalSettings, $this->_IP, $autolog); 
		
		//Prevent PHP notice
		$this->LogData['isLoginEvent'] = (!isset($this->LogData['isLoginEvent']) ? false : $this->LogData['isLoginEvent']);
		
		//Send email notification
		//Check event type and notification settings
		if (($this->_globalSettings['Notifications']['EmailNotifications']['Firewall'] == 'enabled' && !$this->LogData['isLoginEvent']) || ($this->_globalSettings['Notifications']['EmailNotifications']['Login'] == 'enabled' && $this->LogData['isLoginEvent'])){
			SwiftSecurity::SendEmailNotification(
				$this->_globalSettings['Notifications']['NotificationEmail'],
				__($title),
				$LogEntry->GetNotificationForEmail()
			);
		}
	}
	
	/**
	 * Log and notify on successful authentication
	 */
	public function LogAuth($user_login, $user = null){
		$this->LogData = array(
				'attempt'		=> 'Login',
				'channel'		=> $user_login,
				'hard'			=> false,
				'isLoginEvent'	=> true
		);
		$this->Log('Successful login', true, false);
	}
	
	/**
	 * Log and notify on failed authentication
	 */
	public function LogFailedAuth($user_login){
		$this->LogData = array(
				'attempt'	=> 'FailedLogin',
				'channel'	=> $user_login,
				'isLoginEvent'	=> true
		);
		$this->Log('Failed login');
	}
	
}

?>