<?php
defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
global $wp;

//Get the settings
$SettingsObject = new Settings();
$settings = $SettingsObject->GetSettings();

//Create Firewall object
$Firewall = new Firewall($settings);


//If the request type is POST proxy the request
if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
	SwiftSecurity::ClassInclude('Proxy');
	$Proxy = new Proxy($settings, $Firewall);
	$Proxy->Proxy();
}
//Any other call is a possible attack attempt, so log and block it
else{
	$Firewall->LogData = array(
		'attempt'	=> $wp->query_vars['attempt'],
		'channel'	=> $wp->query_vars['channel']
	);
	$Firewall->Log();
	$Firewall->Forbidden();
}
