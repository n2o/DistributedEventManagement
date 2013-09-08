jQuery(document).ready(function($) {

	/* helper functions */
	/**
	 * @desc Get a query variable's value from the url
	 * url must be of the form http://example.com/abc/xyz/?name=val&name1=val2..
	 */

	function get_var_in_url(url,name) {
	    var urla=url.split("?");
	    var qvars=urla[1].split("&");//so we hav an array of name=val,name=val
	    for(var i=0;i<qvars.length;i++){
	        var qv=qvars[i].split("=");
	        if(qv[0]==name)
	            return qv[1];
	      }
	}
	/* end helper functions */

	$('#s2_submit_reset_request').live('click', function() {
		var user = $('input#pue_rr_current_user').val();
		var key = $('input#pue_rr_license_key').val();
		var reason = $('textarea#pue_request_reason').val();
		var nonce = $('#_wpnonce_pue_request_form').val();
		var cur_div = $('#site_license_button_'+key);
		var pue_referrer = $('#pue_referrer_in_form').text();
		var already_have_warning = $('#reset_warning').text();

		if ( '' == reason || null == reason ) {
 			$('textarea#pue_request_reason').attr('style', 'border-color: red');
 			if ( null == already_have_warning  || '' == already_have_warning ) {
 				$('textarea#pue_request_reason').after('<span id="reset_warning" style="color: red">You must include a reason for your license key reset request. Thanks!</span>');
	 			} else {
	 				$('#reset_warning').text('No, really, we\'re serious, we need the reason :)');
	 			}
 		} else {

			$.post(ajaxurl, {
				action: 'pue_request_reset_form_submit',
				user: user,
				key: key,
				reason: reason,
				pue_referrer: pue_referrer,
				nonce: nonce
			},
			function(response){
				var resp = JSON.parse(response);
				$('#pue_request_reset_form_container').html(resp);
				$.colorbox.resize();
			});

		}
		return false;
	});

	$('.sup-update-button').live('click', function() {
		var sup_id = $(this).attr('id').replace('sup-update-time_', '');
		var rem_time = $('input#sup-time-rem_'+sup_id).val();
		var user_id = $('#sup_displayed_user_id').text();
		var nonce = $('#pue_time_edit_nonce_'+sup_id).text();
		var cur_item = $('#support-item-'+sup_id);
		$('#pue_support_msg').fadeOut().hide();

		$.post(ajaxurl, {
			action: 'pue_s2_support_time_submit',
			user_id: user_id,
			rem_time: rem_time,
			sup_id: sup_id,
			nonce: nonce
		},
		function(response) {
			var resp = JSON.parse(response);
			if ( resp.success ) {
				$('#pue_support_msg', cur_item).fadeIn().attr('class', 'success').show().text(resp.msg);
			} else {
				$('#pue_support_msg', cur_item).fadeIn().attr('class', 'error').show().text(resp.msg);
			}
		});
		return false;
	});

	$('.sup-item-done-button').live('click', function() {
		var sup_id = $(this).attr('id').replace('sup-item-done-','');
		var user_id = $('#sup_displayed_user_id').text();
		var nonce = $('#pue_time_edit_nonce_'+sup_id).text();
		var cur_item = $('#support-item-'+sup_id);
		var support_total = $('#support-item-total-remaining-'+sup_id).text();
		$('#pue_support_msg').fadeOut().hide();

		$.post(ajaxurl, {
			action: 'pue_s2_support_item_done',
			user_id: user_id,
			sup_id: sup_id,
			sup_tot: support_total,
			nonce: nonce
		},
		function(response) {
			var resp = JSON.parse(response);
			if ( resp.success ) {
				$('.support-item-total-remaining', cur_item).text(resp.total);
				$('#pue_support_msg', cur_item).fadeIn().attr('class', 'success').show().text(resp.msg);
				if ( resp.total === 0 ) {
					$('.sup-item-done-button', cur_item).fadeOut().hide();
				}
				
			} else {
				$('#pue_support_msg', cur_item).fadeIn().attr('class', 'error').show().text(resp.msg);
			}
		});
		
	});

	$('.pue-s2member-prerelease-toggle-container').on('click', '#pue-s2member-prerelease-toggle', function () {
		$('#pue-s2member-prerelease-optin-message').dialog({
			resizable: false,
			height: 'auto',
			maxWidth: 500,
			modal: true,
			dialogClass: "optin-dialog",
			buttons: [{
				text: "I Agree - Sign me Up!",
				click: function() {
					var user_id = $('#pue-s2member-prerelease-toggle-user-id').text();
					$('.ui-button').hide();
					$('.prc-ajax-loader').show();
					$.post(ajaxurl, {
						action: 'pue_s2_pr_optin',
						user_id: user_id
					},
					function (response) {
						console.log(response);
						var resp = JSON.parse(response);
						if ( resp.success ) {
							/*$( this ).dialog( 'close' );*/
							window.location.reload();
						} else {
							$('.ajax-loader').hide();
							$('.pue-s2-optin-dialog').text(resp.error.msg);
						}
					});
				}
			}]
		});
	});
});