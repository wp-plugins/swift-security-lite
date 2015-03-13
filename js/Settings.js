//Set messages object
try{
	window.SwiftsecurityMessages = JSON.parse(ajax_object.SwiftsecurityMessages);
}
catch (e){
	window.SwiftsecurityMessages = {};
}

function disable_pro_functions(){
	//Disable unavailable functions
	jQuery('.ss-disabled input, .ss-disabled select, .ss-disabled button, .ss-disabled textarea, .ss-disabled a').each(function(){
		jQuery(this).prop('disabled',true);
	});
	
	jQuery('.ss-disabled a .remove-input').each(function(){
		jQuery(this).removeClass('remove-input');
	});
}

jQuery(function(){	
	
	//Disable unavailable functions
	disable_pro_functions();
	
	//Confirmation for restore defaults
	jQuery(document).on('click','.restore-defaults',function(){
 	 	if (confirm(SwiftsecurityMessages['ARE_YOU_SURE'])){
 	 		return true;
 	 	}
 	 	return false;
	});
	
	//Select all for ss-multiple selects
 	jQuery(document).on('click','.select-all',function(e){
 	 	e.preventDefault();
 	 	jQuery(this).parent().find('.ss-cblist input[type=checkbox]').each(function(){
 	 		jQuery(this).prop('checked', 'true');
 	 	});
 	});
 	
 	//Unselect all for ss-multiple selects
 	jQuery(document).on('click','.deselect-all',function(e){
 	 	e.preventDefault();
 	 	jQuery(this).parent().find('.ss-cblist input[type=checkbox]').each(function(){
 	 		jQuery(this).removeProp('checked');
 	 	});
 	});
	
	// Firewall logs
	jQuery('#swift-security-log tbody tr').click(function(){
		jQuery(this).next().toggleClass('hidden-row colored-row');
		jQuery(this).toggleClass('colored-row');
	});
	
	//Load current settings
	jQuery('.firewall-settings').each(function(){
		var set = jQuery(this).attr('data-set');
		jQuery.post(ajax_object.ajax_url, {'action': 'SwiftSecurityFirewallAjaxHandler', 'set' : set, 'wp-nonce': ajax_object.wp_nonce}, function(response){
			jQuery('#' + set + '-settings').empty().append(response);
			
			//Disable unavailable functions
			disable_pro_functions();

		})
	})
	
	//
	// Slider for security presets
	//
	
	jQuery(function(){
		jQuery('.fw-slider').each(function(){
			var slider = jQuery(this);
			jQuery(this).noUiSlider({
				start: [ slider.attr('data-current') ],
				step: 1,
				range: {
					'min': parseInt(slider.attr('data-min')),
					'max': parseInt(slider.attr('data-max'))
				},	
			});
		
			jQuery(this).Link('lower').to(jQuery('#preset-value-' + jQuery(this).attr('data-set')), null, wNumb({
				decimals: 0
			}));
		});
	});

	//
	// Open/Hide all function
	//
	jQuery('.swift-security-row > h4, .custom-settings > h4').click(function(){
		jQuery(this).parent().toggleClass('opened');
	});
	
	jQuery('.swift-security-row > .pro-version-container, .custom-settings > .pro-version-container').click(function(){
		jQuery(this).parent().toggleClass('opened');
	});
	
	//
	// Toggle button function
	//
	jQuery('.open-hide').click(function(e){
		e.preventDefault();
		jQuery('.swift-security-row').toggleClass('opened');
		if(jQuery('.swift-security-row.opened').length === 0) {
			jQuery(this).text('Open All');
		} else {
			jQuery(this).text('Hide All');
		}
	});
	
	
	jQuery(document).on('focus','.input-sample',function(){
		if(jQuery(this).parent().prev().find('.cloned').val() == ''){
			jQuery(this).parent().prev().find('.cloned').focus();
			return false;
		}
	 	var clone = jQuery(this).parent().clone();
	 	jQuery(clone).removeClass('sample-container');
	 	jQuery(clone).find('input').attr('name', jQuery(this).attr('data-name'));
	 	jQuery(clone).find('.input-sample').removeAttr('data-name');
	 	jQuery(clone).find('.input-sample').addClass('cloned');
	 	jQuery(clone).find('.input-sample').removeClass('input-sample');
	 	jQuery(clone).insertBefore(jQuery(this).parent());
	 	jQuery(clone).find('input:first').focus();
	});

 	jQuery(document).on('focus','.input-sample-kv',function(){
		if(jQuery(this).parent().prev().find('.cloned-kv-key').val() == '' || jQuery(this).parent().prev().find('.cloned-kv-value').val() == ''){
			jQuery(this).parent().prev().find('.cloned-kv-key').focus();
			return false;
		}
 	 	var clone = jQuery(this).parent().clone();
 	 	jQuery(clone).removeClass('sample-container');
 	 	jQuery(clone).find('.input-sample-kv-key').addClass('cloned-kv-key');
 	 	jQuery(clone).find('.input-sample-kv-value').addClass('cloned-kv-value');
 	 	jQuery(clone).find('.input-sample-kv').removeClass('input-sample-kv');
 	 	jQuery(clone).insertBefore(jQuery(this).parent());
 	 	jQuery(clone).find('.input-sample-kv-key').focus();
 	});

 	jQuery(document).on('keyup','.input-sample-kv-key',function(){
 	 	jQuery(this).parent().find('.input-sample-kv-value').attr('name',jQuery(this).parent().find('.input-sample-kv-value').attr('name').replace(/settings\[(.*)\]\[(.*)\]\[(.*)\]/,'settings[$1][$2][' + jQuery(this).val() + ']'));
 	});
 	
 	jQuery(document).on('click','.generate-plugin-name',function(e){
 	 	e.preventDefault();
 	 	jQuery(this).parent().find('input').val(jQuery(this).attr('data-plugindir').shuffle());
 	});
 	
 	jQuery(document).on('click','.quick-preset',function(e){
 		e.preventDefault();
 		jQuery("#QuickPreset").val(jQuery(this).attr('data-plugin'));
 		jQuery("button[name='swift-security-settings-save']").click();
 	});
 	
 	jQuery(document).on('click','.remove-input',function(e){
 	 	e.preventDefault();
 	 	jQuery(this).parent().remove();
 	});

 	jQuery(document).on('change','.fw-slider',function(){
 		var value = parseInt(jQuery(this).val());
 		var set = jQuery(this).attr('data-set');
 		jQuery.post(ajax_object.ajax_url, {'action': 'SwiftSecurityFirewallAjaxHandler', 'set' : set, 'selected': value, 'wp-nonce': ajax_object.wp_nonce}, function(response){
			jQuery('#' + set + '-settings').empty().append(response);
			
			//Disable unavailable functions
			disable_pro_functions();
		})
 	});

 	
 	String.prototype.shuffle = function () {
 	    var a = this.split(""),
 	        n = a.length;

 	    for(var i = n - 1; i > 0; i--) {
 	        var j = Math.floor(Math.random() * (i + 1));
 	        var tmp = a[i];
 	        a[i] = a[j];
 	        a[j] = tmp;
 	    }
 	    return a.join("");
 	}
});