function spp_delete_image() {
	jQuery('#spp_del').val(jQuery(this).attr('data-id'));
	spp_save_settings();
	jQuery('#spp_del').val('');
}
function spp_save_settings(e) {
	if('undefined' !== typeof e){
		e.preventDefault();
	};
	jQuery('#spp_settings_wrap').html(sppSettings.beginImages + sppSettings.spinner);
	var $el = jQuery(this);
	$el.html(sppSettings.spinner + sppSettings.messages.settings.init);
	$el.prop('disabled', true);
	var data2 = jQuery('#spp_settings_frm').serialize();
	jQuery.ajax({
		type: 'POST',
		url: sppSettings.ajaxUrl,
		data: data2 + '&action=spp_save_settings',
		cache: false
	}).done(function (response) {
		jQuery('#spp_settings_wrap').html(response);
		$el.html(sppSettings.messages.settings.done);
		jQuery('.spp_figure .dashicons-no').bind('click', spp_delete_image);
		setTimeout(function () {
			$el.html(sppSettings.messages.settings.ready);
			$el.prop('disabled', false);
		}, 3000);
		jQuery('#spp_images_list').val('');
	});
}
function spp_assess_counter($el) {
	var val = $el.val();
	if(val.indexOf('#NO') < 0) {
		jQuery('#spp_start_counter').attr('disabled', 'disabled');
		jQuery('#spp_title_prefix_counter').hide();
	} else {
		jQuery('#spp_title_prefix_counter').show();
		jQuery('#spp_start_counter').removeAttr('disabled');
	}
}
jQuery(document).ready(function () {
	jQuery('#spp_date_type').on('change', function() {
		var val = jQuery(this).val();
		jQuery('#spp_random_date_text0').hide();
		jQuery('#spp_random_date_text1').hide();
		jQuery('#spp_random_date_text2').hide();
		jQuery('#spp_random_date_text3').hide();
		jQuery('#spp_random_date_text' + val ).show();
		if( 3 == jQuery(this).val()) {
			jQuery('#spp_specific_date_wrap').show();
		} else {
			jQuery('#spp_specific_date_wrap').hide();
			jQuery('#spp_specific_date').val('');
			jQuery('#spp_specific_status').val('');
		}
	});
	jQuery('#spp_title_prefix').on('focusin focusout change', function() {
		spp_assess_counter(jQuery(this));
	});
	jQuery('#spp_save').on('click', spp_save_settings);
	jQuery('.spp_figure .dashicons-no').on('click', spp_delete_image);
	jQuery('#spp_execute').on('click', function (e) {
		e.preventDefault();
		jQuery('#spp_populate_wrap').html(sppSettings.spinner);
		var $el = jQuery(this);
		$el.html(sppSettings.spinnerDark + sppSettings.messages.populate.init);
		$el.prop('disabled', true);
		var data2 = jQuery('#spp_settings_frm').serialize();
		jQuery.ajax({
			type: 'POST',
			url: sppSettings.ajaxUrl,
			data: data2 + '&action=spp_populate',
			cache: false
		}).done(function (response) {
			jQuery('#spp_populate_wrap').html(response);
			$el.html(sppSettings.messages.populate.done);
			setTimeout(function () {
				$el.html(sppSettings.messages.populate.ready);
				$el.prop('disabled', false);
			}, 3000);
		});
	});
});
