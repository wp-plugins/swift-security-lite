<?php defined('ABSPATH') or die("KEEP CALM AND CARRY ON");?>
<?php 
	try{
		SwiftSecurity::CompatibilityCheck('CodeScanner');
	}
	catch (SettingsException $e){
		$GLOBALS['SwiftSecurityMessage']['message'] = $e->getMessage();
		$GLOBALS['SwiftSecurityMessage']['type'] = 'update-nag';
		SwiftSecurity::AdminNotice();
	}
?>
<h2>Swift Security - <?php _e('Code Scanner Settings', 'SwiftSecurity'); ?>  (only in PRO version <a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank">Buy now!</a>)</h2>
<form id="CodeScannerForm" method="post">
	<div class="ss-disabled">
 		<h4>Scheduled scan</h4>
 		
	 	<div class="additional-settings">
			<label><?php _e('Run scheduled scans', 'SwiftSecurity'); ?></label>
			<select name="settings[CodeScanner][settings][scheduled]">
				<option value="none" <?php echo (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] == 'none' ? 'selected="selected"' : '')?>>Off</option>
				<option value="hourly" <?php echo (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] == 'hourly' ? 'selected="selected"' : '')?>>Hourly</option>
				<option value="daily" <?php echo (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] == 'daily' ? 'selected="selected"' : '')?>>Daily</option>
				<option value="weekly" <?php echo (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] == 'weekly' ? 'selected="selected"' : '')?>>Weekly</option>
				<option value="monthly" <?php echo (isset($settings['CodeScanner']['settings']['scheduled']) && $settings['CodeScanner']['settings']['scheduled'] == 'monthly' ? 'selected="selected"' : '')?>>Monthly</option>					
			</select>
		</div>
		
		<div class="additional-settings">
			<div class="onoffswitch-sm">
			    <input type="checkbox" name="settings[CodeScanner][settings][autoQuarantine]" class="onoffswitch-checkbox-sm" id="onoff-sm-quarantine" value="enabled" <?php echo (isset($settings['CodeScanner']['settings']['autoQuarantine']) && $settings['CodeScanner']['settings']['autoQuarantine'] == 'enabled' ? 'checked="checked"' : '')?>>
			    <label class="onoffswitch-label-sm" for="onoff-sm-quarantine">
				    <span class="onoffswitch-inner-sm"></span>
				    <span class="onoffswitch-switch-sm"></span>
			    </label>
		    </div>
			<label for="onoff-sm-quarantine"><?php _e('Automatic quarantine', 'SwiftSecurity'); ?></label>
		</div>
		
 	</div>
 	
 	<input type="hidden" name="sq" value="<?php echo $settings['GlobalSettings']['sq']?>">
 	<input type="hidden" name="module" value="CodeScanner">
 	<br>
 	<div class="button-container ss-disabled">
 		<button name="swift-security-settings-save" class="sft-btn btn-green" value="CodeScanner"><?php _e('Save settings', 'SwiftSecurity'); ?></button>
 		<a href="<?php menu_page_url( 'SwiftSecurityCodeScanner', true);?>" class="sft-btn"><?php _e('Scan now','SwiftSecurity');?></a>
 		<button name="swift-security-settings-save" class="sft-btn btn-gray restore-defaults" value="RestoreDefault"><?php _e('Restore defaults', 'SwiftSecurity');?></button>
 	</div>
 </form>