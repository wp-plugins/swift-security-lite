<?php 
$FirewallPresetLevels = array(
	'SQLi' => array(
		__('Basic','SwiftSecurity'),
		__('Moderate','SwiftSecurity'),
		__('Normal','SwiftSecurity'),
		__('High','SwiftSecurity')
	),
	'XSS' => array(
			__('Basic','SwiftSecurity'),
			__('Moderate','SwiftSecurity'),
			__('Normal','SwiftSecurity'),
			__('High','SwiftSecurity')
	),
	'Path' => array(
			__('Basic','SwiftSecurity'),
			__('Normal','SwiftSecurity'),
			__('High','SwiftSecurity')
	),
	'File' => array(
			__('None','SwiftSecurity'),
			__('Basic','SwiftSecurity'),
			__('Normal','SwiftSecurity'),
			__('High','SwiftSecurity')
	)
)
?>
<?php defined('ABSPATH') or die("KEEP CALM AND CARRY ON");?>
<h2>Swift Security - <?php _e('Dashboard','SwiftSecurity');?></h2>
<!-- Hide Wordpress -->
<div id="swift-security-items">
	<div class="swift-security-db <?php echo ($settings['Modules']['HideWP'] == 'enabled' ? 'enabled' : 'disabled')?>">
		<div class="status-indicator"><?php echo ($settings['Modules']['HideWP'] == 'enabled' ? 'on' : 'off')?></div>
		<h3><?php _e('Hide Wordpress','SwiftSecurity');?></h3>
		<?php _e('This module hides the fact that you are using Wordpress. It prevents script kiddies to find some known vulnerability of your site.', 'SwiftSecurtiy');?>
		<div class="button-container">
			<a href="<?php menu_page_url( 'SwiftSecurityHideWP', true);?>" class="sft-btn"><?php _e('Settings','SwiftSecurity');?></a>
		</div>
	</div>
	
	<!-- Firewall -->
	<div class="swift-security-db <?php echo ($settings['Modules']['Firewall'] == 'enabled' ? 'enabled' : 'disabled')?>">
		<div class="status-indicator"><?php echo ($settings['Modules']['Firewall'] == 'enabled' ? 'on' : 'off')?></div>
		<h3><?php _e('Firewall','SwiftSecurity');?></h3>
		<?php _e('This module blocks SQL injection and XSS attempts. It prevent script kiddies to exploit some vulnerability on your site. You can set IP filters to make your site more secure.','SwiftSecurity');?>
		<div class="button-container">
			<a href="<?php menu_page_url( 'SwiftSecurityFirewall', true);?>" class="sft-btn"><?php _e('Settings','SwiftSecurity');?></a>
			<a href="<?php menu_page_url( 'SwiftSecurityFirewall', true);?>&option=Log" class="sft-btn sft-btn-green"><?php _e('See Logs','SwiftSecurity');?></a>
		</div>
	</div>
	
	<!-- Code Scanner -->
	<div id="code-scanner" class="swift-security-db">
		<h3><?php _e('Code Scanner','SwiftSecurity');?></h3>
		<?php _e('Scan your site and report suspicious files or code snippets. You can put suspicious files in quarantine, and you can set scheduled scans for better security.','SwiftSecurity');?>
		<div class="button-container">
			<a href="<?php menu_page_url( 'SwiftSecurityCodeScanner', true);?>&option=Settings" class="sft-btn"><?php _e('Settings','SwiftSecurity');?></a>
			<a href="<?php menu_page_url( 'SwiftSecurityCodeScanner', true);?>" class="sft-btn btn-green"><?php _e('Scan now!','SwiftSecurity');?></a>
		</div>
	</div>
	
	<!-- General -->
	<div id="general-settings" class="swift-security-db">
		<h3><?php _e('General Information','SwiftSecurity');?></h3>
		<div class="swift-security-cols">
			<div>
				<strong><?php _e('Admin URL:','SwiftSecurity');?></strong> <?php echo admin_url()?><br>
				<?php if (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] != 'none') :?>
				<strong><?php _e('Scheduled scans:','SwiftSecurity');?></strong> <?php echo ucfirst($settings['CodeScanner']['settings']['scheduled']);?><br>
				<?php endif;?>	
				<strong><?php _e('Notification e-mail:','SwiftSecurity');?></strong> <?php echo $settings['GlobalSettings']['Notifications']['NotificationEmail']?><br>
				<a href="<?php menu_page_url( 'SwiftSecurityGeneralSettings', true);?>" class="sft-btn btn-sm btn-gray">Settings</a>
			</div>
			<div>
				<h4><?php _e('Firewall','SwiftSecurity');?></h4>
				<p>
					<strong><?php _e('SQL injection filter:','SwiftSecurity');?></strong> <?php echo (isset($settings['Firewall']['settings']['presets']['SQLi']) ? $FirewallPresetLevels['SQLi'][(int)$settings['Firewall']['settings']['presets']['SQLi']] : 'N/A');?><br>
					<strong><?php _e('XSS filter:','SwiftSecurity');?></strong> <?php echo (isset($settings['Firewall']['settings']['presets']['XSS']) ? $FirewallPresetLevels['XSS'][(int)$settings['Firewall']['settings']['presets']['XSS']] : 'N/A');?><br>
					<strong><?php _e('File path manipulation filter:','SwiftSecurity');?></strong> <?php echo (isset($settings['Firewall']['settings']['presets']['Path']) ? $FirewallPresetLevels['Path'][(int)$settings['Firewall']['settings']['presets']['Path']] : 'N/A');?><br>
					<strong><?php _e('File upload filter:','SwiftSecurity');?></strong> <?php echo (isset($settings['Firewall']['settings']['presets']['File']) ? $FirewallPresetLevels['File'][(int)$settings['Firewall']['settings']['presets']['File']] : 'N/A'	);?>
				</p>
			</div>
		</div>
	</div>
</div>