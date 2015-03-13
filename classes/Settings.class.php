<?php 
defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
class Settings{
	
	/**  
	 * Default settings
	 * @var array
	 */
	private $_defaultSettings = array(
			'HideWP' => array(
					'permalinks' => array(
							'author'				=> 'profiles',
							'search'				=> 'search',
							'category'				=> 'niche',
							'tag'					=> 'label'
					),
					'redirectTheme' => 'contents',
					'redirectThemeStyle' => 'bootstrap.min.css',
					'redirectChildTheme' => 'contents-ext',
					'redirectChildThemeStyle' => 'bootstrap-ext.min.css',
					'redirectDirs' => array(
						'wp-content/plugins' 	=> 'modules',
						'wp-content/uploads' 	=> 'media',
						'wp-includes'			=> 'assets',
						'wp-admin'				=> 'administrator',
					),
					'redirectFiles' => array(
						'wp-login.php'				=> 'user.php',
						'wp-comments-post.php'		=> 'comment.php',
						'wp-admin/admin-ajax.php'	=> 'ajax.php'
					),
					'queries' => array(
						'p' 		=> 'article',
						'author' 	=> 'user',
						's' 		=> 'query',
						'paged'		=> 'page',
						'cat'		=> 'niche',
						'page_id'	=> 'pid',
						'page_name'	=> 'pname',
						'tag'		=> 'label',
					),
					'hiddenFiles' => array(
						'readme.html',
						'license.txt'
					),
					'metas' => array(
						'generator' => ''
					),
					'minifycss' => 'enabled',
					'directPHP' => array(),
					'plugins' => array(),
					'otherFiles' => array(),
					'otherDirs' => array(),
					'regexInSource' => array(),
					'regexInClasses' => array(),
					'regexInIds' => array(),
					'regexInJS' => array(),
					'regexInCSS' => array(),
					'removeHTMLComments' => 'enabled',
					'settings' => array()
			),
			'Firewall' => array(
					'SQLi' => array(
						'GET' => array(
								'union([^a]*a)+ll([^s]*s)+elect',
								'union([^s]*s)+elect',
								'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|drop|update|benchmark).*'
						),
						'POST' => array(),
						'COOKIE' => array(
								'union([^a]*a)+ll([^s]*s)+elect',
								'union([^s]*s)+elect',
						),
						'settings' => array(
								'GET' => 'enabled',
								'POST' => 'disabled',
								'COOKIE' => 'enabled'
						),
						'exceptions' => array(
								'GET' => array(),
								'POST' => array(),
								'COOKIE' => array()
						)
					),
					'XSS' => array(
						'GET' => array(
								'(<|%3C)([^s]*s)+cript.*(>|%3E)',
								'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
								'(<|%3C)([^o]*o)+bject.*(>|%3E)',
								'(<|%3C)([^i]*i)+frame.*(>|%3E)'
						),
						'POST' => array(),
						'settings' => array(
								'GET' => 'enabled',
								'POST' => 'disabled'
						),
						'exceptions' => array(
								'GET' => array(),
								'POST' => array()
						)
					),
					'Path' => array(
						'GET' => array(
								'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
						),
						'POST' => array(),
						'COOKIE' => array(),
						'settings' => array(
								'GET' => 'enabled',
								'POST' => 'disabled',
								'COOKIE' => 'disabled'
						),
						'exceptions' => array(
								'GET' => array(),
								'POST' => array(),
								'COOKIE' => array()
						)
					),
					'File' => array(
						'POST' => array(
								'content' => array(),
								'extension' => array()
						),
						'settings' => array(
								'POST' => 'disabled',
						),
						'exceptions' => array(
								'POST' => array()
						)
					),
					'IP' => array(
						'Whitelist' => array(),
						'Blacklist' => array(),
						'AutoBlacklistMaxAttempts' => 10,
						'CountryLoginWhitelist' => array(),
						'CountryBlacklist' => array()
					),
					'commentSpamBlocker' => 'enabled',
					'settings' => array(
						'presets' => array(
							'SQLi' => 1,
							'XSS' => 1,
							'Path' => 0,
							'File' => 0
						)
					)
			),
			'CodeScanner' => array(
				'scheduled' => 'none',
				'autoQuarantine' => 'enabled',
			),
			'Modules' => array(
					'HideWP' => 'enabled',
					'Firewall' => 'enabled'
			),
			'GlobalSettings' => array(
				'Notifications' => array(
					'email' => 'enabled',
					'pushover' => 'disabled',
					'NotificationEmail' => '',
					'NotificationPushoverToken' => '',
					'NotificationPushoverUser' => '',
					'NotificationPushoverSound' => 'pushover',
					'EmailNotifications' => array(
							'Login' => 'enabled',
							'Firewall' => 'enabled',
							'CodeScanner' => 'enabled'
					),
					'PushNotifications' => array(
							'Login' => 'disabled',
							'Firewall' => 'disabled',
							'CodeScanner' => 'disabled',
					)
				),
				'sq'	=> ''
			)			
	);
	
	/**
	 * Contains pre-configured setting variations for firewall
	 * @var array
	 */
	private $_firewallPresets = array(
		'SQLi' => array(
			array(
				'GET' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|drop|update|benchmark).*'
				),
				'POST' => array(),
				'COOKIE' => array(),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'disabled',
						'COOKIE' => 'disabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			),
			array(
				'GET' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|drop|update|benchmark).*'
				),
				'POST' => array(),
				'COOKIE' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'disabled',
						'COOKIE' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			),
			array(
				'GET' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|drop|update|benchmark).*'
				),
				'POST' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|drop|update|benchmark).*'
				),
				'COOKIE' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00)(.*)?([^a-zA-Z]+)(/\*|union|select|benchmark).*'
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled',
						'COOKIE' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			),
			array(
				'GET' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|insert|cast|set|declare|drop|update|md5|benchmark).*',
						'(,|\(|--|/\*|#|%23)'
				),
				'POST' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\*|union|select|insert|cast|set|declare|drop|update|md5|benchmark).*',
						'(,|\(|--|/\*|#|%23)'
				),
				'COOKIE' => array(
						'union([^a]*a)+ll([^s]*s)+elect',
						'union([^s]*s)+elect',
						'(;|<|>|\'|"|\)|%0A|%0D|%22|%27|%3C|%3E|%00)(.*)?([^a-zA-Z]+)(/\*|union|select|insert|cast|declare|drop|update|md5|benchmark).*',
						'(\(|--|/\*|#|%23)'
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled',
						'COOKIE' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(
							'wp-admin/load-styles.php',
							'wp-admin/load-scripts.php'
						),
						'POST' => array(),
						'COOKIE' => array()
				)
			)
		),
		'XSS' => array(
			array(
				'GET' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
				),
				'POST' => array(),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'disabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array()
				)
			),
			array(
				'GET' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
						'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
						'(<|%3C)([^o]*o)+bject.*(>|%3E)',
						'(<|%3C)([^i]*i)+frame.*(>|%3E)'
				),
				'POST' => array(),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'disabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array()
				)
			),
			array(
				'GET' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
						'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
						'(<|%3C)([^o]*o)+bject.*(>|%3E)',
						'(<|%3C)([^i]*i)+frame.*(>|%3E)'
				),
				'POST' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
						'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
						'(<|%3C)([^o]*o)+bject.*(>|%3E)',
						'(<|%3C)([^i]*i)+frame.*(>|%3E)'
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array()
				)
			),
			array(
				'GET' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
						'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
						'(<|%3C)([^o]*o)+bject.*(>|%3E)',
						'(<|%3C)([^i]*i)+frame.*(>|%3E)',
						'(\(|\)|;)'
				),
				'POST' => array(
						'(<|%3C)([^s]*s)+cript.*(>|%3E)',
						'(<|%3C)([^e]*e)+mbed.*(>|%3E)',
						'(<|%3C)([^o]*o)+bject.*(>|%3E)',
						'(<|%3C)([^i]*i)+frame.*(>|%3E)'
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array()
				)
			)
		),
		'Path' => array(
			array(
				'GET' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'POST' => array(),
				'COOKIE' => array(),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'disabled',
						'COOKIE' => 'disabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			),
			array(
				'GET' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'POST' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'COOKIE' => array(),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled',
						'COOKIE' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			),
			array(
				'GET' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'POST' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'COOKIE' => array(
						'(\.\.\/|\.\.\\|%2e%2e%2f|%2e%2e\/|\.\.%2f|%2e%2e%5c)'
				),
				'settings' => array(
						'GET' => 'enabled',
						'POST' => 'enabled',
						'COOKIE' => 'enabled'
				),
				'exceptions' => array(
						'GET' => array(),
						'POST' => array(),
						'COOKIE' => array()
				)
			)
		),
		'File' => array(
			array(
				'POST' => array(
						'content' => array(),
						'extension' => array()
				),
				'settings' => array(
						'POST' => 'disabled',
				),
				'exceptions' => array(
						'POST' => array()
				)
			),
			array(
				'POST' => array(
						'content' => array(
								'<\?(php)?(.*)((shell_)exec|system|passthru|eval)',
								'^#!/usr/bin/php$'
						),
						'extension' => array(
								'htaccess',
								'php',
								'php3',
								'php4',
								'php5',
								'py',
								'pl',
								'cgi'
						)
				),
				'settings' => array(
						'POST' => 'enabled',
				),
				'exceptions' => array(
						'POST' => array()
				)
			),
			array(
				'POST' => array(
						'content' => array(
								'<\?(php)?(.*)((shell_|pcntl_)?exec|system|passthru|proc_open||eval|assert|ob_start|array_diff_uassoc|array_filter|array_diff_ukey|array_intersect_uassoc|array_intersect_ukey|array_map|array_reduce|array_udiff_assoc|array_udiff_uassoc|array_udiff|array_uintersect_assoc|array_uintersect_uassoc|array_uintersect|array_walk_recursive|array_walk|assert_options|uasort|uksort|usort|preg_replace_callback|spl_autoload_register|iterator_apply|call_user_func|call_user_func_array|register_shutdown_function|register_tick_function|set_error_handler|set_exception_handler|session_set_save_handler|sqlite_create_aggregate|sqlite_create_function|extract|phpinfo|proc_open|popen|show_source|highlight_file|phpinfo|posix_mkfifo|posix_getlogin|posix_ttyname|getenv|get_current_user|proc_get_status|get_cfg_var|getcwd|getlastmo|getmygid|getmyinode|getmypid|getmyuid)',
								'^#!/usr/bin/php$'
						),
						'extension' => array(
								'htaccess',
								'php',
								'php3',
								'php4',
								'php5',
								'py',
								'pl',
								'cgi'
						)
				),
				'settings' => array(
						'POST' => 'enabled',
				),
				'exceptions' => array(
						'POST' => array()
				)
			),
			array(
				'POST' => array(
						'content' => array(
								'<\?',
								'^#!/usr/bin/php$'
						),
						'extension' => array(
								'htaccess',
								'php',
								'php3',
								'php4',
								'php5',
								'py',
								'pl',
								'cgi'
						)
				),
				'settings' => array(
						'POST' => 'enabled',
				),
				'exceptions' => array(
						'POST' => array()
				)
			)
		)
	);
	
	public $JSMessages = array(
		'ARE_YOU_SURE' => 'Are you sure?'
	);
	
	/**
	 * If settings are modified it is true otherwise false;
	 * @var unknown
	 */
	public $isModified = false;
	
	/**
	 * Contains settings error messages
	 * @var string
	 */
	public $errorMessage = '';
	
	/**
	 * Contains settings error code
	 * @var integer
	 */
	public $errorCode = '';
	
	/**
	 * Error field id
	 * @var string
	 */
	public $errorField = '';
	
	public function __construct(){
		SwiftSecurity::ClassInclude('SettingsException');
			
		//Set default notification e-mail address
		$this->_defaultSettings['GlobalSettings']['Notifications']['NotificationEmail'] = get_option('admin_email');
		
		//Set plugin dir rewrites if not set
		if (!function_exists('get_plugins')){
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugins = get_plugins();
		foreach ((array)$plugins as $key=>$value){
				$pluginDir 		= dirname($key);
				//If plugin is single file
				if ($pluginDir == '.'){
					continue;
				}
				$this->_defaultSettings['HideWP']['plugins'][$pluginDir] = (empty($this->_defaultSettings['HideWP']['plugins'][$pluginDir]) ? str_shuffle(strtolower($pluginDir)) : $this->_defaultSettings['HideWP']['plugins'][$pluginDir]);
		}
		
		//Add ajax handler
		add_action('wp_ajax_SwiftSecurityFirewallAjaxHandler', array($this, 'SwiftSecurityFirewallAjaxHandler'));
	}
	
	/**
	 * Ajax handler to load firewall presets
	 */
	public function SwiftSecurityFirewallAjaxHandler(){
		//Check wp-nonce
		check_ajax_referer( 'swiftsecurity', 'wp-nonce' );
		
		//Define settings templates to prevent malicious file include
		$presets = array(
			'SQLi' => 'SQLi.preset',
			'XSS' => 'XSS.preset',
			'Path' => 'Path.preset',
			'File' => 'File.preset',								
		);
		
		if (isset($_POST['selected'])){
			$settings = $this->_firewallPresets[$_POST['set']][$_POST['selected']];
		}
		else{
			$GlobalSettings = $this->GetSettings();
			$settings = $GlobalSettings['Firewall'][$_POST['set']];
		}
		
		include_once SWIFTSECURITY_PLUGIN_DIR . '/templates/firewall-presets/'.$presets[$_POST['set']].'.php';
		
		//Print report
		wp_die();
	}
	
	/**
	 * Get settings, if there aren't any settings it returns the default settings.
	 * @return array
	 */
	public function GetSettings(){		
		$settings = $this->SettingsBackwardCompatibility($this->FixCorruptedSettings(get_option('swiftsecurity_lite_plugin_options', $this->_defaultSettings)));
		
		//Set Regex in CSS for child themes
		if (is_child_theme() && $settings['HideWP']['regexInCSS']['((\.\./)*)/'.get_template().'/'] != '/'.$settings['HideWP']['redirectTheme'].'/'){
				$settings['HideWP']['regexInCSS']['((\.\./)*)/'.get_template().'/'] = '/'.$settings['HideWP']['redirectTheme'].'/';
		}
		
		//Plugin compatibility
		$settings = $this->PluginCompatibility($settings);
		
		return $settings;
	}
	
	/**
	 * Save the settings
	 */
	public function SaveSettings($settings){
		
		$currentSettings = $this->GetSettings();
						
		/*Hide Wordpress*/
		if ($_POST['swift-security-settings-save'] == 'HideWP'){
			$usedKeys = array();
			$usedValues = array();
			
			/*
			 * Quick Presets
			 * @todo turned off in 1.0 because of plugin version differences
			 */
			
			//Woocommerce
			if ($settings['HideWP']['QuickPreset'] == 'WooCommerce'){
				$settings['HideWP']['regexInSource']['woocommerce'] = $settings['HideWP']['plugins']['woocommerce'];
				$settings['HideWP']['regexInClasses']['woocommerce'] = $settings['HideWP']['plugins']['woocommerce'];
				$settings['HideWP']['regexInClasses']['woocommerce-page'] = $settings['HideWP']['plugins']['woocommerce'].'-page';
				$settings['HideWP']['regexInIds']['woocommerce'] = $settings['HideWP']['plugins']['woocommerce'];
				$settings['HideWP']['regexInJS']['woocommerce'] = $settings['HideWP']['plugins']['woocommerce'];
				
				$settings['HideWP']['otherFiles']['modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/css/woocommerce-layout.css'] = 'modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/css/layout.css';
				$settings['HideWP']['otherFiles']['modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/css/woocommerce-smallscreen.css'] = 'modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/css/smallscreen.css';
				$settings['HideWP']['otherFiles']['modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/js/frontend/woocommerce.min.js'] = 'modules/'.$settings['HideWP']['plugins']['woocommerce'].'/assets/js/frontend/'.$settings['HideWP']['plugins']['woocommerce'].'.min.js';
			}
			else if ($settings['HideWP']['QuickPreset'] == 'bbPress'){
				$settings['HideWP']['regexInSource']['bbpress'] = $settings['HideWP']['plugins']['bbpress'];
				$settings['HideWP']['regexInClasses']['bbpress'] = $settings['HideWP']['plugins']['bbpress'];
				$settings['HideWP']['regexInIds']['bbpress'] = $settings['HideWP']['plugins']['bbpress'];
				$settings['HideWP']['regexInJS']['bbpress'] = $settings['HideWP']['plugins']['bbpress'];
				
				$settings['HideWP']['otherFiles']['modules/'.$settings['HideWP']['plugins']['bbpress'].'/templates/default/css/bbpress.css'] = 'modules/'.$settings['HideWP']['plugins']['bbpress'].'/forum/css/main.css';
			}
			else if ($settings['HideWP']['QuickPreset'] == 'BuddyPress'){
				$settings['HideWP']['regexInSource']['buddypress'] = $settings['HideWP']['plugins']['buddypress'];
				$settings['HideWP']['regexInClasses']['buddypress'] = $settings['HideWP']['plugins']['buddypress'];
				$settings['HideWP']['regexInIds']['buddypress'] = $settings['HideWP']['plugins']['buddypress'];
				$settings['HideWP']['regexInJS']['buddypress'] = $settings['HideWP']['plugins']['buddypress'];
								
				$settings['HideWP']['otherFiles']['modules/'.$settings['HideWP']['plugins']['buddypress'].'/bp-templates/bp-legacy/css/buddypress.min.css'] = 'modules/'.$settings['HideWP']['plugins']['buddypress'].'/social/main.min.css';
			}
			
			/*
			 * Field checking
			 */
			
			//Theme directory
			$settings['HideWP']['redirectTheme'] = (empty($settings['HideWP']['redirectTheme']) ? get_template() : $settings['HideWP']['redirectTheme']);
			$usedKeys[get_template()] = true;
			$usedValues[$settings['HideWP']['redirectTheme']] = true; 
			
			//Theme style
			$settings['HideWP']['redirectThemeStyle'] = (empty($settings['HideWP']['redirectThemeStyle']) ? 'style.css' : $settings['HideWP']['redirectThemeStyle']);
			$usedKeys[get_template() . '/style.css'] = true;
			$usedValues[$settings['HideWP']['redirectThemeStyle']] = true;
				
			//Remove empty hidden files inputs
			$settings['HideWP']['hiddenFiles'] = swift_remove_empty_elements_deep($settings['HideWP']['hiddenFiles']);
			
			//If value empty set the key as value
			foreach ((array)$settings['HideWP']['permalinks'] as $key=>$value){
				if (empty($value)){
					$settings['HideWP']['permalinks'][$key] = $key;
				}
				
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
						'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}
			
			//If value empty set the key as value
			foreach ((array)$settings['HideWP']['redirectDirs'] as $key=>$value){
				if (empty($value)){
					$settings['HideWP']['redirectDirs'][$key] = $key;
				}
				
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
						'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}
			
			//If value empty set the key as value
			foreach ((array)$settings['HideWP']['redirectFiles'] as $key=>$value){
				if (empty($value)){
					$settings['HideWP']['redirectFiles'][$key] = $key;
				}
				
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
						'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}
			
			//If value empty set the key as value
			foreach ((array)$settings['HideWP']['plugins'] as $key=>$value){
				if (empty($value)){
					$settings['HideWP']['plugins'][$key] = $key;
				}
			
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
						'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}
			
			//If value empty set the key as value
			foreach ((array)$settings['HideWP']['queries'] as $key=>$value){
				if (empty($value)){
					$settings['HideWP']['queries'][$key] = $key;
				}
			}
			
			foreach ((array)$settings['HideWP']['otherFiles'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['otherFiles'][$key]);
					continue;
				}
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
						'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}
			
			foreach ((array)$settings['HideWP']['otherDirs'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['otherDirs'][$key]);
					continue;
				}
				//Check for duplicated key or values
				if (isset($usedKeys[$key]) || isset($usedValues[$value])){
					throw new SettingsException(array(
							'message' => __('Error! Duplicated value:', 'SwiftSecurity') . ' ' . $value
					));
				}
				$usedKeys[$key] = true;
				$usedValues[$value] = true;
			}

			foreach ((array)$settings['HideWP']['regexInSource'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['regexInSource'][$key]);
					continue;
				}
			}
			
			foreach ((array)$settings['HideWP']['regexInClasses'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['regexInClasses'][$key]);
					continue;
				}
			}
			
			foreach ((array)$settings['HideWP']['regexInIds'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['regexInIds'][$key]);
					continue;
				}
			}
			
			foreach ((array)$settings['HideWP']['regexInJS'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['regexInJS'][$key]);
					continue;
				}
			}
			
			foreach ((array)$settings['HideWP']['regexInCSS'] as $key=>$value){
				//Remove unnecessary empty fields
				if ($key == '0' || (int)$key > 0 || empty($value)){
					unset($settings['HideWP']['regexInCSS'][$key]);
					continue;
				}
			}
			
			/*
			 * Check permalink conflicts
			 */
			foreach ($usedValues as $key=>$value){
				$term = term_exists($key);
				if ($term !== 0 && $term !== null) {
					throw new SettingsException(array(
							'message' => __('Error! This slug is not available:', 'SwiftSecurity') . ' ' . $key
					));
				}
			}
			
			/*
			 * Check existing file conflict
			 */
			foreach ($usedValues as $key=>$value){
				if (file_exists(ABSPATH . $key)) {
					throw new SettingsException(array(
							'message' => __('Error! This slug is not available:', 'SwiftSecurity') . ' ' . $key
					));
				}
			}
			
			//Compatibility check
			if (SwiftSecurity::CompatibilityCheck('HideWP') == false || SwiftSecurity::CompatibilityCheck('htaccess') == false){
				$settings['Modules']['HideWP'] = 'disabled';
			}
						
			//Update the settings
			$currentSettings['HideWP'] = $settings['HideWP'];
				
			//Enable/disable the module
			$currentSettings['Modules']['HideWP'] = (isset($settings['Modules']['HideWP']) ? $settings['Modules']['HideWP'] : 'disabled');
		}
		
		/*Firewall*/
		else if ($_POST['swift-security-settings-save'] == 'Firewall'){
			
			/*Set the presets*/
			
			//SQL injection settings
			$settings['Firewall']['settings']['presets']['SQLi'] = $settings['Firewall']['Preset']['SQLi'];
			//XSS settings
			$settings['Firewall']['settings']['presets']['XSS'] = $settings['Firewall']['Preset']['XSS'];
			//Path manipulation settings
			$settings['Firewall']['settings']['presets']['Path'] = $settings['Firewall']['Preset']['Path'];
			//File upload settings
			$settings['Firewall']['settings']['presets']['File'] = $settings['Firewall']['Preset']['File'];
			
			//Check CURL is enabled and ignore POST settings if not
			try{
				SwiftSecurity::CompatibilityCheck('Firewall');
			}
			catch (SettingsException $e){
				$settings['Firewall']['SQLi']['settings']['POST'] = 'disabled';
				$settings['Firewall']['XSS']['settings']['POST'] = 'disabled';
				$settings['Firewall']['Path']['settings']['POST'] = 'disabled';
				$settings['Firewall']['File']['settings']['POST'] = 'disabled';
				
				$GLOBALS['SwiftSecurityMessage']['message'] = $e->getMessage();
				$GLOBALS['SwiftSecurityMessage']['type'] = 'sft-notification-error';
				SwiftSecurity::AdminNotice();
			}
			
			//Check htaccess again
			SwiftSecurity::CompatibilityCheck('htaccess');
			
			//Remove empty fields
			$settings['Firewall'] = swift_remove_empty_elements_deep($settings['Firewall']);

			//Parse blacklist textarea
			if (isset($settings['Firewall']['IP']['Blacklist'])){
				$settings['Firewall']['IP']['Blacklist'] = swift_remove_empty_elements_deep(explode("\n",$settings['Firewall']['IP']['Blacklist']));
			} 

			//Update the settings
			$currentSettings['Firewall'] = $settings['Firewall'];
				
			//Enable/disable the module
			$currentSettings['Modules']['Firewall'] = (isset($settings['Modules']['Firewall']) ? $settings['Modules']['Firewall'] : 'disabled');
		}
		
		/*Code Scanner*/
		else if ($_POST['swift-security-settings-save'] == 'CodeScanner'){
			//Update the settings
			$currentSettings['CodeScanner'] = $settings['CodeScanner'];
						
			wp_clear_scheduled_hook('SwiftSecurityStartScheduledScan');
			if ($settings['CodeScanner']['settings']['scheduled'] != 'none'){
				wp_schedule_event( time(), $settings['CodeScanner']['settings']['scheduled'], 'SwiftSecurityStartScheduledScan');
			}
		}
		
		/*General Settings*/
		else if ($_POST['swift-security-settings-save'] == 'General'){
			//Checkings
			$settings['GlobalSettings']['Notifications'] = swift_remove_empty_elements_deep($settings['GlobalSettings']['Notifications']);
			
			if (isset($settings['GlobalSettings']['Notifications']['PushNotifications']) && !empty($settings['GlobalSettings']['Notifications']['PushNotifications']) && empty($settings['GlobalSettings']['Notifications']['NotificationPushoverToken'])) {
				throw new SettingsException(array(
						'message' => __('Error! Please set your Pushover Application Key', 'SwiftSecurity')
				));
			}
			
			if (isset($settings['GlobalSettings']['Notifications']['PushNotifications']) && !empty($settings['GlobalSettings']['Notifications']['PushNotifications']) && empty($settings['GlobalSettings']['Notifications']['NotificationPushoverUser'])) {
				throw new SettingsException(array(
						'message' => __('Error! Please set your Pushover User Key', 'SwiftSecurity')
				));
			}
			
			//Update the settings
			$currentSettings['GlobalSettings']['Notifications'] = $settings['GlobalSettings']['Notifications'];
			
		}
		
		/*Default Settings*/
		else if ($_POST['swift-security-settings-save'] == 'RestoreDefault'){
			//Update the settings
			$currentSettings[$_POST['module']] = $this->_defaultSettings[$_POST['module']];
		}
		
		//Update settings
		update_option('swiftsecurity_lite_plugin_options', $currentSettings);
		
		//Set isModified
		$this->isModified = true;		
	}
	
	/**
	 * Handle export/import plugin settings 
	 */
	public function ExIm(){
		if ($_POST['swift-security-exim'] == 'export-settings'){
			$settings = json_encode($this->GetSettings());
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="swiftsecurity-settings.json"');
			header('Content-Length: ' . strlen($settings));
			echo $settings;
			die;
		}
		else if ($_POST['swift-security-exim'] == 'import-settings'){
			$settings = ((isset($_FILES['swiftsecurity-import-settings']['tmp_name']) && !empty($_FILES['swiftsecurity-import-settings']['tmp_name'])) ? file_get_contents($_FILES['swiftsecurity-import-settings']['tmp_name']) : '');
			/*Checkings*/ 
			
			if (strlen($settings) == 0){
				throw new SettingsException(array(
						'message' => __('Imported file is empty', 'SwiftSecurity')
				));
			}
			//Create array from imported json
			$SettingsArray = json_decode($settings, true);
			if (!is_array($SettingsArray)){
				throw new SettingsException(array(
						'message' => __('Imported file is corrupted', 'SwiftSecurity')
				));
			}
			
			//Check mandantory settings field are present
			$HideWPConsistence = array_diff_key_recursive(swift_remove_empty_elements_deep($this->_defaultSettings['HideWP']), $SettingsArray['HideWP']);
			if (!empty($HideWPConsistence) || empty($SettingsArray['GlobalSettings']['sq'])){
				throw new SettingsException(array(
						'message' => __('Imported settings are not consistent', 'SwiftSecurity')
				));
			}
			
			//Save imported settings 
			update_option('swiftsecurity_lite_plugin_options', $SettingsArray);
			
			//Set isModified
			$this->isModified = true;
		}
	}
	
	/**
	 * Fix missing settings options
	 */
	public function SettingsBackwardCompatibility($settings){
		/*
		 * Add AutoBlacklistMaxAttempts if it is not set
		 * @since 1.0.2
		 */
		if (!isset($settings['Firewall']['IP']['AutoBlacklistMaxAttempts'])){
			$settings['Firewall']['IP']['AutoBlacklistMaxAttempts'] = 10;
		}
		
		/*
		 * Add child theme support
		 * @since 1.0.6
		 */	
		if (!isset($settings['HideWP']['redirectChildTheme'])){
			$settings['HideWP']['redirectChildTheme'] = 'contents-ext';
		}
		if (!isset($settings['HideWP']['redirectChildThemeStyle'])){
			$settings['HideWP']['redirectChildThemeStyle'] = 'bootstrap-ext.min.css';
		}
		
		/*
		 * Add notifications array
		 * @since 1.0.6
		 */
		if (!isset($settings['GlobalSettings']['Notifications'])){
			$settings['GlobalSettings']['Notifications'] = array(
					'NotificationEmail' => get_option('admin_email'),
					'NotificationPushoverToken' => '',
					'NotificationPushoverUser' => '',
					'NotificationPushoverSound' => 'pushover',
					'EmailNotifications' => array(
							'Login' => 'enabled',
							'Firewall' => 'enabled',
							'CodeScanner' => 'enabled'
					),
					'PushNotifications' => array(
							'Login' => 'disabled',
							'Firewall' => 'disabled',
							'CodeScanner' => 'disabled'
					)
				);
		}
		
		return $settings;
	}
	
	/**
	 * Custom rules for plugin compatibility to improve one-click activation
	 * @param array $settings
	 * @return array
	 */
	public function PluginCompatibility($settings){
		$active_plugins = get_option('active_plugins');
		
		/* TinyMCE */
		if (file_exists(ABSPATH . 'wp-includes/js/tinymce/wp-tinymce.php') && (is_array($settings['HideWP']['directPHP']) && !in_array($settings['HideWP']['redirectDirs']['wp-includes'] . '/js/tinymce/wp-tinymce.php', $settings['HideWP']['directPHP']))){
			$settings['HideWP']['directPHP'][] = $settings['HideWP']['redirectDirs']['wp-includes'] . '/js/tinymce/wp-tinymce.php';
		}
		
		return $settings;
	}
	
	/**
	 * If settings are corrupted returns the default settings, otherwise returns the current settings
	 * @param array $settings
	 * @return array
	 * @todo improve checkings
	 * @todo alert messages
	 */
	public function FixCorruptedSettings($settings){
		//If settings missing
		if (!is_array($settings)){
			$settings = $this->_defaultSettings;
		}
	
		//Generate random secure query if it is emtpy
		if (empty($settings['GlobalSettings']['sq'])){
			$settings['GlobalSettings']['sq'] = 'sq_' . md5(mt_rand(0,1000000000));
		}
	
		//Fix corrupted Hide Wordpress settings
		if (!isset($settings['HideWP']) || !is_array($settings['HideWP'])){
			$settings['HideWP'] = $this->_defaultSettings['HideWP'];
		}
	
		//Fix corrupted Firewall settings
		if (!isset($settings['Firewall']) || !is_array($settings['Firewall'])){
			$settings['Firewall'] = $this->_defaultSettings['Firewall'];
		}
	
		//Fix corrupted modules settings
		if (!isset($settings['Modules']) || !is_array($settings['Modules'])){
			$settings['Modules'] = $this->_defaultSettings['Modules'];
		}
	
		//Fix corrupted global settings
		if (!isset($settings['GlobalSettings']) || !is_array($settings['GlobalSettings'])){
			$settings['GlobalSettings'] = $this->_defaultSettings['GlobalSettings'];
		}
	
		return $settings;
	}
}

?>