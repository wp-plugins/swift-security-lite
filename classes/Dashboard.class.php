<?php 

/**
 * Manage plugin's dashboard templates
 *
 */
class Dashboard{
	
	/**
	 * Load the selected admin template
	 */
	public static function LoadTemplate(){
		//Get the settings
		SwiftSecurity::ClassInclude('Settings');
		$SettingsObject = new Settings();
		$settings = $SettingsObject->GetSettings();
		
		foreach ($SettingsObject->JSMessages as $key=>$value){
			$JSMessages[$key] = __($value, 'SwiftSecurity');
		}
		 
		
		//Get template based on GET[page] value
		switch($_GET['page']){
			case 'SwiftSecurity':
				$template = 'plugin-dashboard';
				break;
			case 'SwiftSecurityGeneralSettings':
					$template = 'general-settings';
					break;
			case 'SwiftSecurityHideWP':
				$template = 'hide-wp-settings';
				break;
			case 'SwiftSecurityFirewall':
				if (isset($_GET['option']) && $_GET['option'] == 'Log'){
					//Show the logs template
					$template = 'firewall-logs';
				}
				else{
					//Show the main template
					$template = 'firewall-settings';
				}
				break;
			case 'SwiftSecurityCodeScanner':
				if (isset($_GET['option']) && $_GET['option'] == 'Settings'){
					//Show the settings template
					$template = 'wp-scanner-settings';
				}
				else{
					$template = 'wp-scanner-dashboard';
				}
				break;				
		}
		
		//Enqueue general scripts
		wp_enqueue_script('nouislider-script',  SWIFTSECURITY_PLUGIN_URL . '/js/jquery.nouislider.all.min.js', array('jquery'));
		wp_enqueue_script('b64-script',  SWIFTSECURITY_PLUGIN_URL . '/js/Base64.js', array('jquery'));
		wp_enqueue_script('settings-script',  SWIFTSECURITY_PLUGIN_URL . '/js/Settings.js', array('jquery'));
		wp_localize_script('settings-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'wp_nonce' => wp_create_nonce('swiftsecurity'), 'SwiftsecurityMessages' => json_encode($JSMessages)));
				
		include_once SWIFTSECURITY_PLUGIN_DIR . '/templates/'.$template.'.php';
	}
	
}

?>