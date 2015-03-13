<?php
	defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
	$charset = strtolower(get_bloginfo('charset'));
	header ('Content-type: text/html; charset='.$charset);
	include_once (get_404_template());die;
?>