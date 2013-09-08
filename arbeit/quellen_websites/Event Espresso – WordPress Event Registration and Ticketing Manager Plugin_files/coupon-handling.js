jQuery(document).ready(function($) {
	
	function trim(str, chars) {
		return ltrim(rtrim(str,chars), chars);
	}
  
	function ltrim(str, chars) {
		return str.replace(new RegExp("^[" + chars + "|\\s]+", "g"), "");
	}


	function rtrim(str, chars) {
		return str.replace(new RegExp("[" + chars + "|\\s]+$", "g"), "");
	}

	function is_array(input){
		return typeof(input)=='object'&&(input instanceof Array);
	}

	function coupon_check(type) {
		var coupon_code_in = $('[name="pue_s2_custom_coupon_code"]').val();
		var original_price = $('.pue-orig-price').text();
		var submit_price_in;

		if ( 'paypal' == type ) {
			submit_price_in = $('[name="a3"]').val();
			if ( !submit_price_in)
				submit_price_in = $('[name="amount"]').val();
		} else if ( 'authnet' == type ) {
			submit_price_in = $('#calc_ra').text();
		}

		$.post(ajaxurl, {
			action: 'pue_s2_custom_coupon_code_handler',
			coupon_code:coupon_code_in,
			product_slug: $('#package_slug').text(),
			submit_price:submit_price_in
		},
		function (response){
			/*console.log(response);/**/
			var resp = JSON.parse(response);
			if ( resp.coupon_error ) {
				$('#coupon-response-error').html(resp.msg).show();
				return false;
			} else {
				$('#coupon-response').html(resp.msg).show();
			}
			$('#coupon-value').text(resp.coupon_value);
			if ( !resp.coupon_error )  {
				$('#coupon-response-error').hide();
				$('#pue-s2custom-coupon-checkout-coupon').remove();
			}

			$('[name="pue_s2_custom_coupon_code"]').val('');
			var saved_message = ' (saved $'+resp.coupon_value+' with a coupon)';
			if ('paypal' == type) {
				$('[name="a3"]').val(resp.submit_price);
				$('[name="amount"]').val(resp.submit_price);
				$('#coupon-code').text(resp.coupon_code);
			} else if ( 'authnet' == type ) {
				$('#calc_ra').text(resp.submit_price);
				var item_name = $('#calc_item_name').text();
				$('#calc_item_name').text(item_name+saved_message);
				$('#coupon-code').text(resp.coupon_code);
			}

			$('#coupon-usage').text(resp.coupon_usage);
			if ( resp.submit_price != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();

			$('#total_value_amt').text('$'+resp.submit_price);
		});
		return false;
	}

	/*$('#pue-s2-purchase-form').submit( function(e) {*/
	$('.submit-button', '#pue-s2-purchase-form').live( 'click', function() {
		var submit_price_in = $('[name="a3"]').val();
		if ( !submit_price_in)
			submit_price_in = $('[name="amount"]').val();

		var rr_in = $('#h_c_rr').text();
		var rp_in = $('#h_c_rp').text();
		var rt_in = $('#h_c_rt').text();
		var level_in = $('#h_c_level').text();
		var level_type_in = $('#h_c_level_type').text();
		
		$('span','.submit-button').text('...Processing');
		$(this).removeClass('.submit-button');

		//let's make sure coupon codes and product ids are included
		var cur_custom = $('input[name="custom"]').val();
		var coupon_code = $('#coupon-code').text();
		var coupon_value = $('#coupon-value').text();
		var coupon_usage = $('#coupon-usage').text();
		var product_id = $('#package_id').text();
		if ( coupon_code !== null ) {
			var new_custom = cur_custom+'|cc#'+coupon_code+'#'+coupon_usage+'#'+coupon_value+'|pid#'+product_id;
			$('input[name="custom"]').val(new_custom);
		}
		/*console.log(new_custom);*/
		
		$.post(ajaxurl, {
                action: 'pue_s2_custom_submit_handler',
                submit_price:submit_price_in,
                package_slug:$('#package_slug').text(),
                addon_slugs:$('#addon_slugs').text(),
                coupon_value:coupon_value,
                custom_value:$('[name="custom"]').val(),
                rr: rr_in,
                rp: rp_in,
                rt: rt_in,
                level: level_in,
                level_type: level_type_in
			},
          function (response){
			console.log(response);/**/
              /*parse the response/**/
              var resp=JSON.parse(response);
              if ( !resp.valid ) {
				var msg = "It seems something went wrong. If you are having problems with your purchase please contact support.";
				$('#pue-s2custom-response-section').html(msg);
				$('#pue-s2custom-package-description').remove();
				$('#pue-s2custom-site-license-option').remove();
				$('#pue-s2custom-support-option').remove();
				$('#pue-s2custom-addons-option').remove();
				$('#pue-s2custom-coupon-section').remove();
				$('#pue-s2custom-package-total').remove();
				$('#submit-area').fadeOut();
			} else {
				$('[name="item_number"]').val(resp.new_item_num);
				$('#pue-s2-purchase-form').submit();
			}
		});
	});

	/* If the enter key is pressed when the coupon field is selected.  Let's submit the coupon code (not the form!)*/
	$('*', '#pue-s2-purchase-form').keypress(function(e) {
        if (e.keyCode == 13)
        {
			return false;
        }
    });

	$('*', '#s2member-pro-authnet-checkout-form').keypress(function(e) {
        if (e.keyCode == 13)
        {
			return false;
        }
	});
	
	$('#apply-coupon', '#pue-s2-purchase-form').live('click', function() {
		coupon_check('paypal');
	});

	$('#apply-coupon', '#s2member-pro-authnet-checkout-form').live('click', function() {
		coupon_check('authnet');
	});

	$('input:checkbox', '#pue-s2-purchase-form').live('click', function() {
		var original_price = $('.pue-orig-price').text();
		var cur_val_item = $(this).val();
		var type = $(this).attr('class').replace('_check','');
		var coupon_code = $('#coupon-code').text();
		var cur_val = $('#'+type+'_price_value_'+cur_val_item).text();
		cur_val = parseFloat(cur_val);
		var submit_price_in = $('[name="a3"]').val();
		if ( !submit_price_in)
			submit_price_in = $('[name="amount"]').val();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var has_item = $('#has_'+type+'_item').text();
		var ccapsarr = new Array();
		cur_sup_id = ( type == 'support' ) ? cur_val_item : 0;
		cur_val_item = ( type == 'support' ) ? 'support_access' : cur_val_item;
		var new_sup_push = '%%';
		var addon_text = ( type == 'support' ) ? $('#addon_text-'+cur_sup_id).text() : $('#addon_text-'+cur_val_item).text();
		var addon_upsell_display_container = $('.custom', '.value');
		//init vars for display
		var addon_upsell_display;
		var key;
		var count;

		/* let's record new support items for future reference! */
		if ( type == 'support' ) {
		var new_sup_get = $('#new_sup_items').text();
			if ( new_sup_get ) {
				var new_sup_stuffing = new_sup_get.split(',');
				key = $.inArray(cur_sup_id, new_sup_stuffing);
				if ( key == - 1 && $(this).prop("checked") )
					new_sup_stuffing.push(cur_sup_id);
				else if  ( key != -1 && !($(this).prop("checked") ) )
					new_sup_stuffing.splice(key,1);
					new_sup_push = trim(new_sup_stuffing.join(','),',');
			}
			$('#new_sup_items').text(new_sup_push);
		}
		
		if ($(this).prop("checked")) {
			submit_price_in = parseFloat(submit_price_in) + cur_val;
			addon_upsell_display_container.show();
			add_upsell_display = '<li id="c-addon-display-text-'+cur_val_item+'">'+addon_text+'</li>';
			$(add_upsell_display).appendTo('#custom-addons-list');
			if ( !ccaps ) {
				ccaps = new Array(cur_val_item);
			} else {
				ccaps = ccaps.split(',');
				key = $.inArray( cur_val_item, ccaps );
				if ( key == -1 ) {
					count = ccaps.length;
					ccaps[count] = cur_val_item;
				}
			}
			ccaps = ccaps.join(',');
			$('#addon_slugs').text(ccaps);
		} else {
			$('#c-addon-display-text-'+cur_val_item).remove();
			submit_price_in = submit_price_in - cur_val;
			ccapsarr = ccaps.split(',');
			key = $.inArray(cur_val_item, ccapsarr);
			if ( key != -1 && !has_item && new_sup_push == '%%' )
				ccapsarr.splice(key,1);
			ccaps = ccapsarr.join(',');
			ccaps = trim(ccaps,',');
			$('#addon_slugs').text(ccaps);
		}

		if ( $('li', '#custom-addons-list').length < 1)
				addon_upsell_display_container.fadeOut();
		submit_price_in = submit_price_in.toFixed(2);

		$('[name="a3"]').val(submit_price_in);
		$('[name="amount"]').val(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);


		/*setup new name=item_number value*/
		/*rc: don't think I need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = trim(new_item_number,':');
		$('[name="item_number"]').val(new_item_number);*/

		/*let's handle if this is a support item because we'll need to add a custom value for it */
		/*setup custom value in form*/
		if ( type == 'support' ) {
			var domain = $('#this_domain').text();
			var cur_custom = $('[name="custom"]').val();
			var cur_cust_split = cur_custom.split('|');
			var new_chk_split = new Array();


			/*let's take care of removing/modifying existing custom item that matches*/
			var incr = 0;
			if  ( !is_array(cur_cust_split) && $(this).prop("checked") ) {
				/*alert('here');/**/
				cur_custom = cur_custom + '|' + 'sup#'+cur_sup_id+'#1';
			} else if ( $(this).prop("checked") &&
				is_array(cur_cust_split) ) {
				count = cur_cust_split.length;
				new_chk_split = cur_cust_split;
				new_chk_split[count] = 'sup#'+cur_sup_id+'#1';
			} else {
				$.each(cur_cust_split, function (ind, val) {
					var cur_sup_split = val.split('#');
					if ( cur_sup_split[1] == cur_sup_id ) {
						incr++;
						return;
						}
					
					new_chk_split[ind-incr] = val;
				});
			}
			cur_cust_join_a = new_chk_split.join('|');
			cur_cust_join = trim(cur_cust_join_a, '|');

			$('[name="custom"]').val(cur_cust_join);
		}

	});

	$('input#pue_s2_upsell_site_license', '#pue-s2-purchase-form').keyup( function() {
		var original_price = $('.pue-orig-price').text();
		var submit_price_in = $('[name="a3"]').val();
		if ( !submit_price_in)
			submit_price_in = $('[name="amount"]').val();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var ccapsarr = new Array();
		var cur_lic_num = ($('#current_number_licenses').text()) ? $('#current_number_licenses').text() : 0;
		var sl_val = parseFloat($('#site-license-value').text());
		var cur_val_item = parseFloat($(this).val().replace('/\D/',''));
		cur_val_item = (!cur_val_item) ? 0 : cur_val_item;
		var cur_val = cur_val_item * sl_val ;
		var t_tot = parseFloat($('#temp_total_holder').text());
		var count = '';
		submit_price_in = (submit_price_in - t_tot + cur_val).toFixed(2);
		t_tot = cur_val.toFixed(2);
		var key;
		
		/* let's assign the new values in their places */
		$('[name="a3"]').val(submit_price_in);
		$('[name="amount"]').val(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);
		$('#temp_total_holder').text(t_tot);

		/*setup new name=item_number value (if needed)*/
		if ( !ccaps ) {
			ccapsarr = new Array('site_license');
		} else {
			ccapsarr = ccaps.split(',');
			count = ccapsarr.length;
			key = $.inArray('site_license', ccapsarr);
			if ( key == -1 && t_tot > 0 )
				ccapsarr[count] = 'site_license';
		}
		
		if ( cur_val_item === 0 ) {
			count = ccapsarr.length;
			key = $.inArray('site_license', ccapsarr);
			if ( key != -1 && cur_lic_num === 0 ) {
				ccapsarr.splice(key,1);
			}
		}

		ccaps = ccapsarr.join(',');
		ccaps = trim(ccaps,',');
		$('#addon_slugs').text(ccaps);

		/* rc: don't think I'll need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = rtrim(new_item_number,':');
		$('[name="item_number"]').val(new_item_number);*/

		/*setup custom value in form*/
		var domain = $('#this_domain').text();
		var cur_custom = $('[name="custom"]').val();
		var n_lic_num = parseFloat(cur_lic_num) + cur_val_item;
		var new_cust_split = new Array();
		var incr = 0;
		var sl_exists = false;

		var cur_cust_split = cur_custom.split('|');
		$.each(cur_cust_split, function (ind, val) {
			var cur_lic_split = val.split('#');

			if ( cur_lic_split[0] == 'sl' && cur_val_item === 0 && cur_lic_num !== 0 ) {
				new_cust_split[ind] = 'sl#'+cur_lic_num;
				sl_exists = true;
				return;
			}
			
			if ( cur_lic_split[0] == 'sl' && cur_val_item === 0 ) {
				incr++;
				sl_exists = true;
				return;
			}

			if ( cur_lic_split[0] == 'sl' ) {
				new_cust_split[ind] = 'sl#'+n_lic_num;
				sl_exists = true;
				return;
			}

			new_cust_split[ind-incr] = val;
		});

		count = new_cust_split.length;
		if ( !sl_exists && cur_lic_num !== cur_val_item && n_lic_num !== 0 )
			new_cust_split[count] = 'sl#'+n_lic_num;/**/
		cur_cust_join = new_cust_split.join('|');
		cur_cust_join = trim(cur_cust_join, '|');

		$('[name="custom"]').val(cur_cust_join);

		/*display new site_license_number*/
		$('.site-license-number').text(n_lic_num);
		var orig_site_text = $('.orig-site-num-text').text();
		if ( n_lic_num > 1 && parseFloat(cur_lic_num) === 1 ) $('.site-license-pl-text').text(orig_site_text+'s');
		else $('.site-license-pl-text').text(orig_site_text);

	});/**/

	$('input.support_num', '#pue-s2-purchase-form').keyup( function() {
		var original_price = $('.pue-orig-price').text();
		var submit_price_in = $('[name="a3"]').val();
		if ( !submit_price_in)
			submit_price_in = $('[name="amount"]').val();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var ccapsarr = new Array();
		var cur_sup_id = $(this).attr('id').replace('support_num_', '');
		var cur_sup_slug = $('#support_slug_'+cur_sup_id).text();
		var cur_sup_inc = false;
		var cur_val_item = parseFloat($(this).val().replace('/\D/',''));
		cur_val_item = (!cur_val_item) ? 0 : cur_val_item;
		var key;
		var new_sup_push;
		var count;
		
		/* let's check and see if this support type is included with this package */
		var cur_sup_get = $('#has_support_item').text();
		if ( cur_sup_get ) {
			var cur_sup_stuffing = cur_sup_get.split(',');
			key = $.inArray(cur_sup_id, cur_sup_stuffing);
			if ( key == -1 )
				cur_sup_inc = false;
			else
				cur_sup_inc = true;
		}

		/* let's record new support items for future reference! */
		var new_sup_get = $('#new_sup_items').text();
		if ( new_sup_get ) {
			var new_sup_stuffing = new_sup_get.split(',');
			key = $.inArray(cur_sup_id, new_sup_stuffing);
			if ( key == - 1 && cur_val_item !== 0 )
				new_sup_stuffing.push(cur_sup_id);
			else if  ( key != -1 && cur_val_item === 0 )
				new_sup_stuffing.splice(key,1);
			new_sup_push = trim(new_sup_stuffing.join(','),',');
		}

		var cur_item_num = $('#support_num_amt_'+cur_sup_id).text();
		cur_item_num = (!cur_item_num) ? 0 : cur_item_num;
		var sp_val = parseFloat($('#support_price_value_'+cur_sup_id).text());
		var cur_val = cur_val_item * sp_val;
		var t_tot = parseFloat($('#temp_s_total_holder_'+cur_sup_id).text());

		submit_price_in = (submit_price_in - t_tot + cur_val).toFixed(2);
		t_tot = cur_val.toFixed(2);
		
		/* let's assign the new values in their places */
		$('[name="a3"]').val(submit_price_in);
		$('[name="amount"]').val(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);
		$('#temp_s_total_holder_'+cur_sup_id).text(t_tot);
		$('#new_sup_items').text(new_sup_push);

		/*setup new name=item_number value (if needed)*/
		if ( !ccaps ) {
			ccapsarr = new Array('support_access');
		} else {
			ccapsarr = ccaps.split(',');
			count = ccapsarr.length;
			key = $.inArray('support_access', ccapsarr);
			if ( key == -1 && t_tot > 0 )
				ccapsarr[count] = 'support_access';
		}
		
		if ( cur_val_item === 0 ) {
			count = ccapsarr.length;
			key = $.inArray('support_access', ccapsarr);
			if ( key != -1 && !cur_sup_inc && new_sup_push == '%%' ) {
				ccapsarr.splice(key,1);
			}
		}

		ccaps = ccapsarr.join(',');
		ccaps = trim(ccaps,',');
		$('#addon_slugs').text(ccaps);

		/* rc: don't think I need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = rtrim(new_item_number,':');
		$('[name="item_number"]').val(new_item_number);*/

		/*setup custom value in form*/
		var domain = $('#this_domain').text();
		var n_sup_num = parseFloat(cur_item_num) + cur_val_item;
		var cur_custom = $('[name="custom"]').val();
		var cur_cust_split = cur_custom.split('|');
		var new_sup_split = new Array();

		/*let's take care of removing/modifying existing custom item that matches*/
		var incr = 0;
		$.each(cur_cust_split, function (ind, val) {
			var cur_sup_split = val.split('#');
			if ( cur_sup_split[1] == cur_sup_id && cur_sup_inc ) {
				new_sup_split[ind] =  'sup#'+cur_sup_split[1]+'#'+n_sup_num;
				return;
			}

			if ( cur_sup_split[1] == cur_sup_id && cur_item_num === 0) {
				incr++;
				return;
				}
			
			new_sup_split[ind-incr] = val;
		});

		count = new_sup_split.length;
		if ( cur_item_num != n_sup_num && !cur_sup_inc )
			new_sup_split[count] = 'sup#'+cur_sup_id+'#'+n_sup_num;
		cur_cust_join_a = new_sup_split.join('|');
		cur_cust_join = trim(cur_cust_join_a, '|');

		$('[name="custom"]').val(cur_cust_join);
	});

	/*TODO make sure an alert pops up if a coupon code is entered and there are options for upsells.  Coupon Code only gets applied ONCE to a total, so if people want it applied to the upsell (i.e. the code is a percentage) then they will want to wait until they've selected all their upsell options.*/

	/**
	 * BELOW IS HANDLING AUTHNET FORMS
	 * TODO - a lot of duplicate code.  I need to abstract this and make the thumbprint smaller by moving the duplicate code to objects/and/or a single .js file loaded depending on the gateway.
	 **/
	$('input:checkbox', '#s2member-pro-authnet-checkout-form').live('click', function() {
		var original_price = $('.pue-orig-price').text();
		var cur_val_item = $(this).val();
		var type = $(this).attr('class').replace('_check','');
		var cur_val = $('#'+type+'_price_value_'+cur_val_item).text();
		cur_val = parseFloat(cur_val);
		var submit_price_in = $('#calc_ra').text();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var has_item = $('#has_'+type+'_item').text();
		var ccapsarr = new Array();
		cur_sup_id = ( type == 'support' ) ? cur_val_item : 0;
		cur_val_item = ( type == 'support' ) ? 'support_access' : cur_val_item;
		var new_sup_push = '%%';
		var addon_text = ( type == 'support' ) ? $('#addon_text-'+cur_sup_id).text() : $('#addon_text-'+cur_val_item).text();
		var addon_upsell_display_container = $('.custom', '.value');
		//init vars for display
		var addon_upsell_display;
		var key;
		var count;

		/* let's record new support items for future reference! */
		if ( type == 'support' ) {
		var new_sup_get = $('#new_sup_items').text();
			if ( new_sup_get ) {
				var new_sup_stuffing = new_sup_get.split(',');
				key = $.inArray(cur_sup_id, new_sup_stuffing);
				if ( key == - 1 && $(this).prop("checked") )
					new_sup_stuffing.push(cur_sup_id);
				else if  ( key != -1 && !($(this).prop("checked") ) )
					new_sup_stuffing.splice(key,1);
					new_sup_push = trim(new_sup_stuffing.join(','),',');
			}
			$('#new_sup_items').text(new_sup_push);
		}
		
		if ($(this).prop("checked")) {
			submit_price_in = parseFloat(submit_price_in) + cur_val;
			addon_upsell_display_container.show();
			add_upsell_display = '<li id="c-addon-display-text-'+cur_val_item+'">'+addon_text+'</li>';
			$(add_upsell_display).appendTo('#custom-addons-list');
			if ( !ccaps ) {
				ccaps = new Array(cur_val_item);
			} else {
				ccaps = ccaps.split(',');
				key = $.inArray( cur_val_item, ccaps );
				if ( key == -1 ) {
					count = ccaps.length;
					ccaps[count] = cur_val_item;
				}
			}
			ccaps = ccaps.join(',');
			$('#addon_slugs').text(ccaps);
		} else {
			$('#c-addon-display-text-'+cur_val_item).remove();
			submit_price_in = submit_price_in - cur_val;
			ccapsarr = ccaps.split(',');
			key = $.inArray(cur_val_item, ccapsarr);
			if ( key != -1 && !has_item && new_sup_push == '%%' )
				ccapsarr.splice(key,1);
			ccaps = ccapsarr.join(',');
			ccaps = trim(ccaps,',');
			$('#addon_slugs').text(ccaps);
		}

		if ( $('li', '#custom-addons-list').length < 1)
				addon_upsell_display_container.fadeOut();

		submit_price_in = submit_price_in.toFixed(2);

		$('#calc_ra').text(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);


		/*setup new name=item_number value*/
		/* rc: don't think I need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = trim(new_item_number,':');
		$('#calc_item_number').text(new_item_number);*/

		/*let's handle if this is a support item because we'll need to add a custom value for it */
		/*setup custom value in form*/
		if ( type == 'support' ) {
			var domain = $('#this_domain').text();
			var cur_custom = $('#calc_custom').text();
			var cur_cust_split = cur_custom.split('|');
			var new_chk_split = new Array();


			/*let's take care of removing/modifying existing custom item that matches*/
			var incr = 0;
			if  ( !is_array(cur_cust_split) && $(this).prop("checked") ) {
				/*alert('here');/**/
				cur_custom = cur_custom + '|' + 'sup#'+cur_sup_id+'#1';
			} else if ( $(this).prop("checked") &&
				is_array(cur_cust_split) ) {
				count = cur_cust_split.length;
				new_chk_split = cur_cust_split;
				new_chk_split[count] = 'sup#'+cur_sup_id+'#1';
			} else {
				$.each(cur_cust_split, function (ind, val) {
					var cur_sup_split = val.split('#');
					if ( cur_sup_split[1] == cur_sup_id ) {
						incr++;
						return;
						}
					
					new_chk_split[ind-incr] = val;
				});
			}
			cur_cust_join_a = new_chk_split.join('|');
			cur_cust_join = trim(cur_cust_join_a, '|');

			$('#calc_custom').text(cur_cust_join);
		}

	});

	$('input#pue_s2_upsell_site_license', '#s2member-pro-authnet-checkout-form').live('keyup', function() {
		var original_price = $('.pue-orig-price').text();
		var submit_price_in = $('#calc_ra').text();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var ccapsarr = new Array();
		var cur_lic_num = ($('#current_number_licenses').text()) ? $('#current_number_licenses').text() : 0;
		var sl_val = parseFloat($('#site-license-value').text());
		var cur_val_item = parseFloat($(this).val().replace('/\D/',''));
		cur_val_item = (!cur_val_item) ? 0 : cur_val_item;
		var cur_val = cur_val_item * sl_val ;
		var t_tot = parseFloat($('#temp_total_holder').text());
		var count = '';
		submit_price_in = (submit_price_in - t_tot + cur_val).toFixed(2);
		t_tot = cur_val.toFixed(2);
		var key;
		
		/* let's assign the new values in their places */
		$('#calc_ra').text(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);
		$('#temp_total_holder').text(t_tot);

		/*setup new name=item_number value (if needed)*/
		if ( !ccaps ) {
			ccapsarr = new Array('site_license');
		} else {
			ccapsarr = ccaps.split(',');
			count = ccapsarr.length;
			key = $.inArray('site_license', ccapsarr);
			if ( key == -1 && t_tot > 0 )
				ccapsarr[count] = 'site_license';
		}
		
		if ( cur_val_item === 0 ) {
			count = ccapsarr.length;
			key = $.inArray('site_license', ccapsarr);
			if ( key != -1 && cur_lic_num === 0 ) {
				ccapsarr.splice(key,1);
			}
		}

		ccaps = ccapsarr.join(',');
		ccaps = trim(ccaps,',');
		$('#addon_slugs').text(ccaps);

		/* rc: don't think I need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = rtrim(new_item_number,':');
		$('#calc_item_number').text(new_item_number);*/

		/*setup custom value in form*/
		var domain = $('#this_domain').text();
		var cur_custom = $('#calc_custom').text();
		var n_lic_num = parseFloat(cur_lic_num) + cur_val_item;
		var new_cust_split = new Array();
		var incr = 0;
		var sl_exists = false;

		var cur_cust_split = cur_custom.split('|');
		$.each(cur_cust_split, function (ind, val) {
			var cur_lic_split = val.split('#');

			if ( cur_lic_split[0] == 'sl' && cur_val_item === 0 && cur_lic_num !== 0 ) {
				new_cust_split[ind] = 'sl#'+cur_lic_num;
				sl_exists = true;
				return;
			}
			
			if ( cur_lic_split[0] == 'sl' && cur_val_item === 0 ) {
				incr++;
				sl_exists = true;
				return;
			}

			if ( cur_lic_split[0] == 'sl' ) {
				new_cust_split[ind] = 'sl#'+n_lic_num;
				sl_exists = true;
				return;
			}

			new_cust_split[ind-incr] = val;
		});

		count = new_cust_split.length;
		if ( !sl_exists && cur_lic_num !== cur_val_item && n_lic_num !== 0 )
			new_cust_split[count] = 'sl#'+n_lic_num;/**/
		cur_cust_join = new_cust_split.join('|');
		cur_cust_join = trim(cur_cust_join, '|');

		$('#calc_custom').text(cur_cust_join);

		/*display new site_license_number*/
		$('.site-license-number').text(n_lic_num);
		var orig_site_text = $('.orig-site-num-text').text();
		if ( n_lic_num > 1 && parseFloat(cur_lic_num) === 1 ) $('.site-license-pl-text').text(orig_site_text+'s');
		else $('.site-license-pl-text').text(orig_site_text);

	});/**/

	$('input.support_num', 'form#s2member-pro-authnet-checkout-form').live('keyup', function() {
		var original_price = $('.pue-orig-price').text();
		var submit_price_in = $('#calc_ra').text();
		var ccaps = $('#addon_slugs').text();
		var rr = $('#h_c_rr').text();
		var rt = $('#h_c_rt').text();
		var level = $('#h_c_level').text();
		var rp = $('#h_c_rp').text();
		var ccapsarr = new Array();
		var cur_sup_id = $(this).attr('id').replace('support_num_', '');
		var cur_sup_slug = $('#support_slug_'+cur_sup_id).text();
		var cur_sup_inc = false;
		var cur_val_item = parseFloat($(this).val().replace('/\D/',''));
		cur_val_item = (!cur_val_item) ? 0 : cur_val_item;
		var key;
		var new_sup_push;
		var count;
		
		/* let's check and see if this support type is included with this package */
		var cur_sup_get = $('#has_support_item').text();
		if ( cur_sup_get ) {
			var cur_sup_stuffing = cur_sup_get.split(',');
			key = $.inArray(cur_sup_id, cur_sup_stuffing);
			if ( key == -1 )
				cur_sup_inc = false;
			else
				cur_sup_inc = true;
		}

		/* let's record new support items for future reference! */
		var new_sup_get = $('#new_sup_items').text();
		if ( new_sup_get ) {
			var new_sup_stuffing = new_sup_get.split(',');
			key = $.inArray(cur_sup_id, new_sup_stuffing);
			if ( key == - 1 && cur_val_item !== 0 )
				new_sup_stuffing.push(cur_sup_id);
			else if  ( key != -1 && cur_val_item === 0 )
				new_sup_stuffing.splice(key,1);
			new_sup_push = trim(new_sup_stuffing.join(','),',');
		}

		var cur_item_num = $('#support_num_amt_'+cur_sup_id).text();
		cur_item_num = (!cur_item_num) ? 0 : cur_item_num;
		var sp_val = parseFloat($('#support_price_value_'+cur_sup_id).text());
		var cur_val = cur_val_item * sp_val;
		var t_tot = parseFloat($('#temp_s_total_holder_'+cur_sup_id).text());

		submit_price_in = (submit_price_in - t_tot + cur_val).toFixed(2);
		t_tot = cur_val.toFixed(2);
		
		/* let's assign the new values in their places */
		$('#calc_ra').text(submit_price_in);
		if ( submit_price_in != original_price )
				$('.pue-new-price').show();
			else
				$('.pue-new-price').hide();
		$('#total_value_amt').text('$'+submit_price_in);
		$('#temp_s_total_holder_'+cur_sup_id).text(t_tot);
		$('#new_sup_items').text(new_sup_push);

		/*setup new name=item_number value (if needed)*/
		if ( !ccaps ) {
			ccapsarr = new Array('support_access');
		} else {
			ccapsarr = ccaps.split(',');
			count = ccapsarr.length;
			key = $.inArray('support_access', ccapsarr);
			if ( key == -1 && t_tot > 0 )
				ccapsarr[count] = 'support_access';
		}
		
		if ( cur_val_item === 0 ) {
			count = ccapsarr.length;
			key = $.inArray('support_access', ccapsarr);
			if ( key != -1 && !cur_sup_inc && new_sup_push == '%%' ) {
				ccapsarr.splice(key,1);
			}
		}

		ccaps = ccapsarr.join(',');
		ccaps = trim(ccaps,',');
		$('#addon_slugs').text(ccaps);

		/* rc: don't think I need this now /**/
		/*var new_item_number = (rr === "BN" && rt !== "L") ? level+':'+ccaps+':'+rp+' '+rt : level+':'+ccaps;
		new_item_number = rtrim(new_item_number,':');
		$('#calc_item_number').text(new_item_number);*/

		/*setup custom value in form*/
		var domain = $('#this_domain').text();
		var n_sup_num = parseFloat(cur_item_num) + cur_val_item;
		var cur_custom = $('#calc_custom').text();
		var cur_cust_split = cur_custom.split('|');
		var new_sup_split = new Array();

		/*let's take care of removing/modifying existing custom item that matches*/
		var incr = 0;
		$.each(cur_cust_split, function (ind, val) {
			var cur_sup_split = val.split('#');
			if ( cur_sup_split[1] == cur_sup_id && cur_sup_inc ) {
				new_sup_split[ind] =  'sup#'+cur_sup_split[1]+'#'+n_sup_num;
				return;
			}

			if ( cur_sup_split[1] == cur_sup_id && cur_item_num === 0) {
				incr++;
				return;
				}
			
			new_sup_split[ind-incr] = val;
		});

		count = new_sup_split.length;
		if ( cur_item_num != n_sup_num && !cur_sup_inc )
			new_sup_split[count] = 'sup#'+cur_sup_id+'#'+n_sup_num;
		cur_cust_join_a = new_sup_split.join('|');
		cur_cust_join = trim(cur_cust_join_a, '|');

		$('#calc_custom').text(cur_cust_join);
	});


	$('form#s2member-pro-authnet-checkout-form').on('focus', 'input', function() {
		$('.button-container').addClass('submit-button');
		$('span','.submit-button').text('Checkout Now');
	});



	$('.submit-button', 'form#s2member-pro-authnet-checkout-form').live( 'click', function() {
		var custom_in = $('#calc_custom').text();
		var item_number_in = $('#calc_item_number').text();
		var rr_in = $('#calc_rr').text();
		var rrt_in = $('#calc_rrt').text();
		var rra_in = $('#calc_rra').text();
		var ra_in = $('#calc_ra').text();
		var rp_in = $('#calc_rp').text();
		var rt_in = $('#calc_rt').text();
		var modify = $('#calc_modify').text();
		var level_type_in = $('#h_c_level_type').text();
		var card_type = $('input[name="s2member_pro_authnet_checkout[card_type]"][type=radio]:checked').val();
		var get_card_num = $('input#s2member-pro-authnet-checkout-card-number').val();
		var card_number = get_card_num.substr(get_card_num.length - 4); /* we're only getting the last four digits of the card# */
		var street_address = $('input#s2member-pro-authnet-checkout-street').val();
		var city = $('input#s2member-pro-authnet-checkout-city').val();
		var state = $('input#s2member-pro-authnet-checkout-state').val();
		var country = $('select#s2member-pro-authnet-checkout-country option:checked').val();
		var zip = $('input#s2member-pro-authnet-checkout-zip').val();


		$('span','.submit-button').text('...Processing');
		$(this).removeClass('submit-button');

		
		//window.setTimeout(redisplaybutton, 10000); //formerly 5000

		//let's make sure coupon codes and product ids are included
		var cur_custom = custom_in;
		var coupon_code = $('#coupon-code').text();
		var coupon_usage = $('#coupon-usage').text();
		var coupon_value = $('#coupon-value').text();
		var product_id = $('#package_id').text();
		if ( coupon_code !== null ) {
			var new_custom = cur_custom+'|cc#'+coupon_code+'#'+coupon_usage+'#'+coupon_value+'|pid#'+product_id;
			custom_in = new_custom;
		}
		
		$.post(ajaxurl, {
                action: 'pue_s2_authnet_custom_submit_handler',
                custom: custom_in,
                submit_price: ra_in,
                package_slug: $('#package_slug').text(),
                addon_slugs: $('#addon_slugs').text(),
                custom_value: custom_in,
                item_number: item_number_in,
                rr: rr_in,
                rrt: rrt_in,
                rra: rra_in,
                ra: ra_in,
                rp: rp_in,
                rt: rt_in,
                modify: modify,
                success: $('#success_return').text(),
                coupon_value: coupon_value,
                level:$('#h_c_level').text(),
                ccaps:$('#addon_slugs').text(),
                item_name:$('#calc_item_name').text(),
                level_type: level_type_in,
                card_type: card_type,
                card_number: card_number,
                street_address: street_address,
                city: city,
                state: state,
                country: country,
                zip: zip
			},
          function (response){
			console.log(response);
              /*parse the response/**/
              var resp=JSON.parse(response);
              if ( !resp.valid ) {
				var msg = "It seems something went wrong. If you are having problems with your purchase please contact support.";
				$('#pue-s2custom-response-section').html(msg);
				$('#s2member-pro-authnet-checkout-form').fadeOut().remove();
			} else {
				$('#s2member-pro-authnet-checkout-attr').val(resp.encrypted);
				$('#s2member-pro-authnet-checkout-form').submit();
			}
		});
		return;
	});

});