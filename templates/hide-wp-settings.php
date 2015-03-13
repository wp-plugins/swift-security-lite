<?php 
defined('ABSPATH') or die("KEEP CALM AND CARRY ON");
$plugins = get_plugins();
?>
 <form id="HideWPForm" method="post" class="ss-base64-armored">
	<div class="onoffswitch">
	    <input type="checkbox" name="settings[Modules][HideWP]" class="onoffswitch-checkbox" id="HideWP" value="enabled" <?php echo ($settings['Modules']['HideWP'] == 'enabled' ? 'checked="checked"' : '')?>>
	    <label class="onoffswitch-label" for="HideWP">
		    <span class="onoffswitch-inner"></span>
		    <span class="onoffswitch-switch"></span>
	    </label>
    </div>
	<h2>Swift Security - <?php _e('Hide WordPress', 'SwiftSecurity');?></h2>
	
	<button class="sft-btn open-hide btn-sm"><?php _e('Open All', 'SwiftSecurity');?></button>
	
	<section class="swift-security-row">
	  	<h4><?php _e('Admin URLs','SwiftSecurity');?></h4>
	 	<div>
	   		<label>
	 			<?php _e('Login url', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-login.php" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectFiles][wp-login.php]" value="<?php echo $settings['HideWP']['redirectFiles']['wp-login.php']?>">
	 		<span class="small"><?php _e('e.g.: user.php, login.php, login etc...', 'SwiftSecurity');?></span>
	 	</div>	
	 	<div>
	   		<label>
	 			<?php _e('Admin path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-admin" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectDirs][wp-admin]" value="<?php echo $settings['HideWP']['redirectDirs']['wp-admin']?>">
	 		<span class="small"><?php _e('e.g.: admin, administrator, manager, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	</section>
	
	<section class="swift-security-row ss-disabled">
		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	  	<h4><?php _e('Main files and directories','SwiftSecurity');?></h4>
	  	<div>
	 		<label>
	 			<?php _e('Template path', 'SwiftSecurity');?>
		 		<span class="tooltip-icon" data-tooltip="<?php _e('The active theme\'s path. Eg:','SwiftSecurity');?> (wp-content/themes/<?php echo get_template(); ?>)" data-tooltip-position="right">?</span>
	 		</label>		
	 		<input type="text" name="settings[HideWP][redirectTheme]" value="<?php echo $settings['HideWP']['redirectTheme']?>">
	 		<span class="small"><?php _e('e.g.: templates, theme, dir, etc...', 'SwiftSecurity');?></span>
	 	</div>
	 	<div>
	 		<label>
	 			<?php _e('Style filename', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('The active theme\'s style.css','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectThemeStyle]" value="<?php echo $settings['HideWP']['redirectThemeStyle']?>">
	 		<span class="small"><?php _e('e.g.: bootstrap.min.css, main.css, etc...', 'SwiftSecurity');?></span>
	 	</div>
	  	<div>
	 		<label>
	 			<?php _e('Child template path', 'SwiftSecurity');?>
		 		<span class="tooltip-icon" data-tooltip="<?php _e('The active child theme\'s path. Eg:','SwiftSecurity');?> (wp-content/themes/<?php echo get_stylesheet(); ?>)" data-tooltip-position="right">?</span>
	 		</label>		
	 		<input type="text" name="settings[HideWP][redirectChildTheme]" value="<?php echo $settings['HideWP']['redirectChildTheme']?>">
	 		<span class="small"><?php _e('e.g.: templates, theme, dir, etc...', 'SwiftSecurity');?></span>
	 	</div>
	 	<div>
	 		<label>
	 			<?php _e('Child template style filename', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('The active clild theme\'s style.css','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectChildThemeStyle]" value="<?php echo $settings['HideWP']['redirectChildThemeStyle']?>">
	 		<span class="small"><?php _e('e.g.: bootstrap.min.css, main.css, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	 	<div>
	   		<label>
	 			<?php _e('Plugin path', 'SwiftSecurity');?> 
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-content/plugins/" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectDirs][wp-content/plugins]" value="<?php echo $settings['HideWP']['redirectDirs']['wp-content/plugins']?>">
	 		<span class="small"><?php _e('e.g.: modules, apps, etc...', 'SwiftSecurity');?></span>
	 	</div>	 
	 	<div>
	    	<label>
	 			<?php _e('Upload path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-content/uploads/" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectDirs][wp-content/uploads]" value="<?php echo $settings['HideWP']['redirectDirs']['wp-content/uploads']?>">
	 		<span class="small"><?php _e('e.g.: files, upload, media, etc...', 'SwiftSecurity');?></span>
	 	</div>	 
	 	<div>
	 		<label>
	 			<?php _e('Include path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-includes/" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectDirs][wp-includes]" value="<?php echo $settings['HideWP']['redirectDirs']['wp-includes']?>">
	 		<span class="small"><?php _e('e.g.: assets, inc, libary, etc...', 'SwiftSecurity');?></span>
	 	</div>
	 	<div>
	   		<label>
	 			<?php _e('Login url', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-login.php" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectFiles][wp-login.php]" value="<?php echo $settings['HideWP']['redirectFiles']['wp-login.php']?>">
	 		<span class="small"><?php _e('e.g.: user.php, login.php, login etc...', 'SwiftSecurity');?></span>
	 	</div>	
	 	<div>
	   		<label>
	 			<?php _e('Admin path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-admin" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectDirs][wp-admin]" value="<?php echo $settings['HideWP']['redirectDirs']['wp-admin']?>">
	 		<span class="small"><?php _e('e.g.: admin, administrator, manager, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	</section>
	
	<section class="swift-security-row ss-disabled">
		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4><?php _e('Ajax files', 'SwiftSecurity');?></h4>
	 	<div>
	   		<label>
	 			<?php _e('Post comment', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-comments-post.php" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectFiles][wp-comments-post.php]" value="<?php echo $settings['HideWP']['redirectFiles']['wp-comments-post.php']?>">
	 		<span class="small"><?php _e('e.g.: comment.php, userpost.php, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	 	<div>
	    	<label>
	 			<?php _e('Admin ajax', 'SwiftSecurity');?> 
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original:','SwiftSecurity');?> wp-admin/admin-ajax.php" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][redirectFiles][wp-admin/admin-ajax.php]" value="<?php echo $settings['HideWP']['redirectFiles']['wp-admin/admin-ajax.php']?>">
	 		<span class="small"><?php _e('e.g.: ajax, or ajax.php, etc...', 'SwiftSecurity');?></span>
	 	</div>
	</section>
	
	<section class="swift-security-row ss-disabled">
		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	  	<h4><?php _e('Other paths and slugs', 'SwiftSecurity');?></h4>
	 	<div>
	 		<label>
	 			<?php _e('Author path', 'SwiftSecurity');?> 
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: author/username','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][permalinks][author]" value="<?php echo $settings['HideWP']['permalinks']['author']?>">
	 		<span class="small"><?php _e('e.g.: profile, user, etc...', 'SwiftSecurity');?></span>
	 	</div>	 		 	
	 	<div>
	 		<label>
	 			<?php _e('Author query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?author=1','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][author]" value="<?php echo $settings['HideWP']['queries']['author']?>">
	 		<span class="small"><?php _e('e.g.: user, profile, etc...', 'SwiftSecurity');?></span>
	 	</div>
	 	<div>
	 		<label>
	 			<?php _e('Post query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?p=1','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][p]" value="<?php echo $settings['HideWP']['queries']['p']?>">
	 		<span class="small"><?php _e('e.g.: article, post, etc...', 'SwiftSecurity');?></span>
	 	</div>
	 	<div>
	 		<label>
	 			<?php _e('Paged query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?paged=1','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][paged]" value="<?php echo $settings['HideWP']['queries']['paged']?>">
	 		<span class="small"><?php _e('e.g.: page, pg, etc...', 'SwiftSecurity');?></span>
	 	</div>	
	 	<div>
	    	<label>
	 			<?php _e('Category path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: category/something','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][permalinks][category]" value="<?php echo $settings['HideWP']['permalinks']['category']?>">
	 		<span class="small"><?php _e('e.g.: niche, topics, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	 	<div>
	 		<label>
	 			<?php _e('Category query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?cat=something','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][cat]" value="<?php echo $settings['HideWP']['queries']['cat']?>">
	 		<span class="small"><?php _e('e.g.: niche, topics, etc...', 'SwiftSecurity');?></span>
	 	</div>	
	 	<div>
	 		<label>
	 			<?php _e('Page id query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?page_id=123','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 			
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][page_id]" value="<?php echo $settings['HideWP']['queries']['page_id']?>">
	 			<span class="small"><?php _e('e.g.: pid, pageid, etc...', 'SwiftSecurity');?></span>
	 	</div>	 		 	
	 	<div>
	 		<label>
	 			<?php _e('Page name query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?page_name=about_us','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][page_name]" value="<?php echo $settings['HideWP']['queries']['page_name']?>">
	 		<span class="small"><?php _e('e.g.: subpage, pname, etc...', 'SwiftSecurity');?></span>
	 	</div>	 
	 	<div>
	   		<label>
	 			<?php _e('Search path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: search/keyword','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][permalinks][search]" value="<?php echo $settings['HideWP']['permalinks']['search']?>">
	 		<span class="small"><?php _e('e.g.: find', 'SwiftSecurity');?></span>
	 	</div>	 	
	 	<div>
	 		<label>
	 			<?php _e('Search query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?s=keyword','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][s]" value="<?php echo $settings['HideWP']['queries']['s']?>">
	 		<span class="small"><?php _e('e.g.: q, query, search, etc...', 'SwiftSecurity');?></span>
	 	</div>	
	 	<div>
	   		<label>
	 			<?php _e('Tag path', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: tag/something','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][permalinks][tag]" value="<?php echo $settings['HideWP']['permalinks']['tag']?>">
	 		<span class="small"><?php _e('e.g.: label, etc...', 'SwiftSecurity');?></span>
	 	</div>	 	
	 	<div>
	 		<label>
	 			<?php _e('Category query', 'SwiftSecurity');?>
	 			<span class="tooltip-icon" data-tooltip="<?php _e('Original: ?tag=something','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 		</label>
	 		<input type="text" name="settings[HideWP][queries][tag]" value="<?php echo $settings['HideWP']['queries']['tag']?>">
	 		<span class="small"><?php _e('e.g.: label, lab, l, etc...', 'SwiftSecurity');?></span>
	 	</div>
	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Hide plugins', 'SwiftSecurity');?>
	 	 	<span class="tooltip-icon" data-tooltip="<?php _e('You can rename any installed plugin, so nobody can tell what plugins you are using. It can be useful to prevent script kiddies from exploiting some known vulnerability, but keep in mind that you shouldn\'t use vulnerable plugins!','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 	</h4>
	 	<?php foreach ((array)$plugins as $key=>$value):
	 		$pluginDir 		= dirname($key);	 	
	 		if ($pluginDir == '.'){continue;}
	 	?>
	 	<div>
	 		<label>
				<?php echo $value['Name']?>
	 		</label>
	 		<input type="text" name="settings[HideWP][plugins][<?php echo $pluginDir?>]" value="<?php echo (empty($settings['HideWP']['plugins'][$pluginDir]) ? str_shuffle(strtolower($pluginDir)) : $settings['HideWP']['plugins'][$pluginDir]);?>">
			<button class="generate-plugin-name sft-btn btn-sm btn-gray" data-plugindir="<?php echo strtolower($pluginDir);?>">Generate name</button>
			<span class="small"><?php _e('Original: ', 'SwiftSecurity');?> <?php echo $pluginDir;?></span>
	 	</div>
	 	<?php if ($value['Name'] == "WooCommerce" && false): //turned off in version 1.0 ?>
	 	<div>
			<button class="quick-preset sft-btn btn-sm btn-gray" data-plugin="<?php echo $value['Name']?>"><?php _e('Completly hide WooCommerce', 'SwiftSecurity');?></button>
			<span class="tooltip-icon" data-tooltip="<?php _e('You can rename every JS variables, HTML ids and CSS class names which is related to WooCommerce','SwiftSecurity');?>" data-tooltip-position="right">?</span>
		</div>
		<?php elseif ($value['Name'] == "bbPress" && false): //turned off in version 1.0 @see Settings ?>
	 	<div>
			<button class="quick-preset sft-btn btn-sm btn-gray" data-plugin="<?php echo $value['Name']?>"><?php _e('Completly hide bbPress', 'SwiftSecurity');?></button>
			<span class="tooltip-icon" data-tooltip="<?php _e('You can rename every JS variables, HTML ids and CSS class names which is related to bbPress','SwiftSecurity');?>" data-tooltip-position="right">?</span>
		</div>
		<?php elseif ($value['Name'] == "BuddyPress" && false): //turned off in version 1.0 @see Settings ?>
	 	<div>
			<button class="quick-preset sft-btn btn-sm btn-gray" data-plugin="<?php echo $value['Name']?>"><?php _e('Completly hide bbPress', 'SwiftSecurity');?></button>
			<span class="tooltip-icon" data-tooltip="<?php _e('You can rename every JS variables, HTML ids and CSS class names which is related to BuddyPress','SwiftSecurity');?>" data-tooltip-position="right">?</span>
		</div>			
		<?php endif;?>		
	 	<?php endforeach;?>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Wordpress meta tags', 'SwiftSecurity');?>
			<span class="tooltip-icon" data-tooltip="<?php _e('You can remove Wordpress meta tags from the source, such as &lt;meta name=&quot;generator&quot;&gt;','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	<div>
	 		 <label>
	 			<?php _e('Generator', 'SwiftSecurity');?>
	 		</label>
	 		<input type="text" name="settings[HideWP][metas][generator]" value="<?php echo $settings['HideWP']['metas']['generator']?>">
	 		<span class="small"><?php _e('e.g.: UniqueEngine, Joomla, or leave it blank to remove it', 'SwiftSecurity');?></span>
	 	</div>
 	</section>
 	
 	 <section class="swift-security-row ss-disabled">
 	 	<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Minify CSS', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('You can minify all css, and remove the comments from it','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	 <div>
		 	<div class="onoffswitch-sm">
			    <input type="checkbox" name="settings[HideWP][minifycss]" class="onoffswitch-checkbox-sm" id="onoff-sm-minifycss" value="enabled" <?php echo ((isset($settings['HideWP']['minifycss']) && $settings['HideWP']['minifycss'] == 'enabled') ? 'checked="checked"' : '')?>>
			    <label class="onoffswitch-label-sm" for="onoff-sm-minifycss">
				    <span class="onoffswitch-inner-sm"></span>
				    <span class="onoffswitch-switch-sm"></span>
			    </label>
		    </div>
			<label><?php _e('Minify CSS files and remove comments from it', 'SwiftSecurity');?></label>
		</div>
 	</section>

    <section class="swift-security-row ss-disabled">
    	<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Minify Javascript', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('You can minify all javascript files, and remove the comments from it','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	 <div>
		 	<div class="onoffswitch-sm">
			    <input type="checkbox" name="settings[HideWP][minifyjs]" class="onoffswitch-checkbox-sm" id="onoff-sm-minifyjs" value="enabled" <?php echo ((isset($settings['HideWP']['minifyjs']) && $settings['HideWP']['minifyjs'] == 'enabled') ? 'checked="checked"' : '')?>>
			    <label class="onoffswitch-label-sm" for="onoff-sm-minifyjs">
				    <span class="onoffswitch-inner-sm"></span>
				    <span class="onoffswitch-switch-sm"></span>
			    </label>
		    </div>
			<label><?php _e('Minify JS files and remove comments from it', 'SwiftSecurity');?></label>
		</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Remove HTML comments', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('Remove Wordpress- and plugin generated comments from HTML (except the [if] statements)','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	 <div>
		 	<div class="onoffswitch-sm">
			    <input type="checkbox" name="settings[HideWP][removeHTMLComments]" class="onoffswitch-checkbox-sm" id="onoff-sm-removehtmlcomments" value="enabled" <?php echo ((isset($settings['HideWP']['removeHTMLComments']) && $settings['HideWP']['removeHTMLComments'] == 'enabled') ? 'checked="checked"' : '')?>>
			    <label class="onoffswitch-label-sm" for="onoff-sm-removehtmlcomments">
				    <span class="onoffswitch-inner-sm"></span>
				    <span class="onoffswitch-switch-sm"></span>
			    </label>
		    </div>
			<label><?php _e('Remove HTML comments from source', 'SwiftSecurity');?></label>
		</div>
 	</section>
 	
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Hide files', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('You can hide any files from your visitors. It can be useful to hide some Wordpress specific files like readme.html or licence.txt','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['hiddenFiles'])):?>
	 		<?php foreach ((array)$settings['HideWP']['hiddenFiles'] as $hiddenFile) : ?>
	 		<?php if (!empty($hiddenFile)) :?>
	 		<div>
	 			<input type="text" name="settings[HideWP][hiddenFiles][]" value="<?php echo $hiddenFile;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		<div class="sample-container">
	 			<input type="text" class="input-sample" data-name="settings[HideWP][hiddenFiles][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Direct PHP exceptions', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('Hide Wordpress module is blocking every direct php request by default. You can set up some exception if you need it','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['directPHP'])):?>
	 		<?php foreach ((array)$settings['HideWP']['directPHP'] as $directPHP) : ?>
	 		<?php if (!empty($directPHP)) :?>
	 		<div>
	 			<?php echo site_url()?>/<input type="text" name="settings[HideWP][directPHP][]" value="<?php echo $directPHP;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		<div class="sample-container">
	 			<?php echo site_url()?>/<input type="text" class="input-sample" data-name="settings[HideWP][directPHP][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div> 	
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Rename any files', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('You can rename any files to what you want','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['otherFiles'])):?>
	 		<?php foreach ((array)$settings['HideWP']['otherFiles'] as $key=>$value) : ?>
	 		<?php if (!empty($key) && !empty($value)) :?>
	 		<div>
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-key" value="<?php echo $key;?>">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-value" name="settings[HideWP][otherFiles][<?php echo $key;?>]" value="<?php echo $value;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][otherFiles][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Rename any directory', 'SwiftSecurity');?>
	 		<span class="tooltip-icon" data-tooltip="<?php _e('You can rename any directory to what you want','SwiftSecurity');?>" data-tooltip-position="right">?</span>
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['otherDirs'])):?>
	 		<?php foreach ((array)$settings['HideWP']['otherDirs'] as $key=>$value) : ?>
	 		<?php if (!empty($key) && !empty($value)) :?>
	 		<div>
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-key" value="<?php echo $key;?>">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-value" name="settings[HideWP][otherDirs][<?php echo $key;?>]" value="<?php echo $value;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<?php echo site_url()?>/<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][otherDirs][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
 	<h4>
 		<?php _e('Change CSS class names', 'SwiftSecurity');?>
	 	<span class="tooltip-icon" data-tooltip="<?php _e('You can change any CSS class name in the HTML source and CSS files as well. You can use case sensitive regular expressions','SwiftSecurity');?>" data-tooltip-position="right">?</span> 		
 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['regexInClasses'])) :?>
	 		<?php foreach ((array)$settings['HideWP']['regexInClasses'] as $key=>$value) : ?>
	 		<?php if (!empty($key) && !empty($value)) :?>
	 		<div>
	 			<input type="text" class="input-sample-kv-key" value="<?php echo $key;?>">
	 			<input type="text" class="input-sample-kv-value" name="settings[HideWP][regexInClasses][<?php echo $key;?>]" value="<?php echo $value;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][regexInClasses][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
 	<h4>
 		<?php _e('Change HTML ids', 'SwiftSecurity');?>
	 	<span class="tooltip-icon" data-tooltip="<?php _e('You can change any HTML id in the source and JS files as well. You can use case sensitive regural expressions','SwiftSecurity');?>" data-tooltip-position="right">?</span> 		
 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['regexInIds'])):?>
	 		<?php foreach ((array)$settings['HideWP']['regexInIds'] as $key=>$value) : ?>
	 		<?php if (!empty($key) && !empty($value)) :?>
	 		<div>
	 			<input type="text" class="input-sample-kv-key" value="<?php echo $key;?>">
	 			<input type="text" class="input-sample-kv-value" name="settings[HideWP][regexInIds][<?php echo $key;?>]" value="<?php echo $value;?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][regexInIds][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Regular expression in source', 'SwiftSecurity');?>
		 	<span class="tooltip-icon" data-tooltip="<?php _e('You can change any text in the HTML source. You can use case sensitive regural expressions','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['regexInSource'])):?>
	 		<?php foreach ((array)$settings['HideWP']['regexInSource'] as $key=>$value) : ?>
	 		<?php if (!empty($key)) :?>
	 		<div>
	 			<input type="text" class="input-sample-kv-key" value="<?php swiftsecurity_safe_echo($key);?>">
	 			<input type="text" class="input-sample-kv-value" name="settings[HideWP][regexInSource][<?php swiftsecurity_safe_echo($key);?>]" value="<?php swiftsecurity_safe_echo($value);?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][regexInSource][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Regular expression in javascript', 'SwiftSecurity');?>
		 	<span class="tooltip-icon" data-tooltip="<?php _e('You can change any text (eg variables) in the javascript source. You can use case sensitive regural expressions','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['regexInJS'])):?>
	 		<?php foreach ((array)$settings['HideWP']['regexInJS'] as $key=>$value) : ?>
	 		<?php if (!empty($key)) :?>
	 		<div>
	 			<input type="text" class="input-sample-kv-key" value="<?php swiftsecurity_safe_echo($key);?>">
	 			<input type="text" class="input-sample-kv-value" name="settings[HideWP][regexInJS][<?php swiftsecurity_safe_echo($key);?>]" value="<?php swiftsecurity_safe_echo($value);?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][regexInJS][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	
 	<section class="swift-security-row ss-disabled">
 		<div class="pro-version-container"><div class="pro-version-text">This option is available in pro version<br/><a href="<?php echo SWIFTSECURITY_UPGRADE_PRO;?>" target="_blank" class="sft-btn btn-green btn-sm">Buy now!</a></div></div>
	 	<h4>
	 		<?php _e('Regular expression in CSS', 'SwiftSecurity');?>
		 	<span class="tooltip-icon" data-tooltip="<?php _e('You can change any text (import URLs) in the CSS source. You can use case sensitive regural expressions','SwiftSecurity');?>" data-tooltip-position="right">?</span>	 		
	 	</h4>
	 	<div>
	 		<?php if (isset($settings['HideWP']['regexInCSS'])) :?>
	 		<?php foreach ((array)$settings['HideWP']['regexInCSS'] as $key=>$value) : ?>
	 		<?php if (!empty($key)) :?>
	 		<div>
	 			<input type="text" class="input-sample-kv-key" value="<?php swiftsecurity_safe_echo($key);?>">
	 			<input type="text" class="input-sample-kv-value" name="settings[HideWP][regexInCSS][<?php swiftsecurity_safe_echo($key);?>]" value="<?php swiftsecurity_safe_echo($value);?>">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 		<?php endif;?>
	 		<?php endforeach;?>
	 		<?php endif;?>
	 		 <div class="sample-container">
	 			<input type="text" class="input-sample-kv-key input-sample-kv">
	 			<input type="text" class="input-sample-kv-value input-sample-kv" name="settings[HideWP][regexInCSS][]">
	 			<a href="#" class="remove-input close-icon"></a>
	 		</div>
	 	</div>
 	</section>
 	<input type="hidden" name="sq" value="<?php echo $settings['GlobalSettings']['sq']?>">
 	<input type="hidden" name="module" value="HideWP">
 	<input type="hidden" name="settings[HideWP][QuickPreset]" id="QuickPreset" value="">
 	<button name="swift-security-settings-save" value="HideWP" class="sft-btn btn-green"><?php _e('Save settings', 'SwiftSecurity');?></button>
 	<button name="swift-security-settings-save" class="sft-btn btn-gray restore-defaults" value="RestoreDefault"><?php _e('Restore defaults', 'SwiftSecurity');?></button>
 </form>