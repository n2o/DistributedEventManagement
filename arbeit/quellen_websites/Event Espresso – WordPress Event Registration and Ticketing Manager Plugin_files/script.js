/**
 * js class for handling various pm actions.
 * 
 **/
var pue_BB_pm_helper = {
	compose: function(resp) {
		var j = jQuery;
		var context, viewing, parent_id;

		if ( typeof resp == 'object' ) {
			parent_id = ( resp.msg_id == undefined  || !resp.msg_id ) ? 0 : resp.msg_id;
			context = resp.context;
			viewing = resp.viewing;
		} else {
			parent_id = ( resp==undefined || !resp ) ? 0 : resp;
		}
		
		if ( context == undefined || !context ) context = false;
		if ( viewing == undefined || !viewing ) viewing = false;

		j('#compose-message-dialog').dialog({
			modal: true,
			closeText: 'close',
			minWidth: 400,
			open: function(){
				j.post( AJAX_URL, {
				action : 'load_compose_form',
				parent_id : parent_id,
				context : context
				},
				function(response) {
					/*console.log(response);*/
					j(response).appendTo('#display-compose-form');
					if ( j('#recipient').length > 0 )
						j('#recipient').autoSuggest(data);
					/**
					 * ajax for sending messages
					 **/
					j('#send-form').submit(function(e) {
						e.preventDefault();
						if ( parent_id == 0 ) 
							j('<input type="hidden" name="recipient" value="' + j('.as-values').val() + '" />').appendTo(j(this));
						var send_data = j('#send-form').serialize();
						var num_messages = j('.number-messages').text();
						send_data += '&action=pue_bb_pm_send&cookie='+encodeURIComponent(document.cookie)+'&number_messages='+num_messages;
						send_data += '&parent_id='+parent_id;
						j.post( AJAX_URL,  send_data,
						function(response){
							/*console.log(response);/**/
							var resp = JSON.parse(response);
							if ( !resp.errmsg ) {
								j('.pue-bb-pm-sent').html(resp.html);
								j('#compose-container').remove();
								j('table>tbody', '#pue-bb-pm-outbox-form').prepend(resp.outrow);
								j('.number-messages').text(resp.num_message);
							} else {
								j('.pue-bb-pm-sent').html(resp.errmsg);
							}
						});
					});
				});
			},
			close: function() {
				if ( viewing )
					pue_BB_pm_helper.loadbox(context);
			}
		});
	},

	read: function(resp) {
		var j = jQuery;
		var this_row;
		var oldreadnum = parseFloat(j('.readnumber').text());
		var totalmsg = resp.msg_id.length;
		var newreadnum = oldreadnum - totalmsg;
		j('.readnumber').text(newreadnum);
		for ( var i=0; i < resp.msg_id.length; i++ ) {
			this_row = j('#pue-bb-pm-row-'+resp.msg_id[i]);
			if ( !resp.err_msg ) {
				j('.pue-bb-pm-read', this_row).remove();
				j('.subject', this_row).css({'font-weight' : 'normal' });
				j('input', this_row).prop("checked", false);
			}
		}
	},

	delete: function(resp) {
		var j = jQuery;
		var this_row;
		var oldtotalnum = parseFloat(j('.pmnumber', '#tab'+resp.context).text());
		var removedmsg = resp.msg_id.length;
		var newtotalnum = oldtotalnum - removedmsg;
		j('.pmnumber', '#tab'+resp.context).text(newtotalnum);
		if ( resp.viewing == 'false' || !resp.viewing ) {
			for ( var i=0; i < resp.msg_id.length; i++ ) {
				this_row = j('#pue-bb-pm-row-'+resp.msg_id[i]);
				j(this_row).css({'background-color':'red'}).fadeOut('slow');
			}
		} else if ( resp.viewing == 'true' ) {
			this_row = j('.message-container', '#tab'+resp.context);
			j(this_row).css({'background-color' : 'red'}).fadeOut('slow');
			var disp_message = ( !resp.err_msg ) ? resp.status : resp.err_msg;
			this.loadbox(resp.context);
			j('.status_message', '#tab'+resp.context).html(disp_message);
		}
	},

	view: function(resp) {
		var j = jQuery;
		var context = resp.context;
		if ( !resp.err_msg )
			j('#tab'+context).html(resp.html);
	},

	inbox: function(resp) {
		var j = jQuery;
		var context = resp.context;
		j('#tab'+context).html(resp.html);
	},

	outbox: function(resp) {
		var j = jQuery;
		var context = resp.context;
		j('#tab'+context).html(resp.html);
	},

	reply: function(resp) {
		var j = jQuery;
		if ( j('.pue-bb-pm-sent').length > 0 )
			j('.pue-bb-pm-sent').remove();
		if ( j('#compose-container').length > 0 ) 
			j('#display-compose-form').empty();
		this.compose(resp);
	},

	loadbox: function(boxtype) {
		var context = boxtype;
		var viewing = false;
		var action = 'pue_bb_pm_'+boxtype+'_action';
		var j = jQuery;
		j.post( AJAX_URL, {
			type : boxtype,
			context : context,
			viewing : viewing,
			action : action
		},
		function(response) {
			var resp = JSON.parse(response);
			(boxtype == 'inbox') ? pue_BB_pm_helper.inbox(resp) : pue_BB_pm_helper.outbox(resp);
		});
	}  
}

jQuery(document).ready(function($) {
	//this has to be moved to whatever function loads the compose form.
	/*$('#recipient').autoSuggest(data);*/

	$('.compose-message-button').click( function(e){
		e.preventDefault();
		if ( $('.pue-bb-pm-sent').length > 0 )
			$('.pue-bb-pm-sent').remove();
		if ( $('#compose-container').length > 0 ) {
			$('#display-compose-form').empty();
		}
		pue_BB_pm_helper.compose();
	});

	/* this is the actions handler */
	$('.pue-bb-pm-action').live('click', function(e) {
		e.preventDefault();
		var reference = $(this).attr('href').split('_');
		var type = reference[0].replace('#','');
		var msg_id = reference[1];
		var context = reference[2];
		var viewing = ( reference.length == 4 ) ? true : false 
		var nonce = $('#pue_bb_pm_'+type+'_nonce_'+msg_id).text();
		var action = 'pue_bb_pm_'+type+'_action';

		$.post( AJAX_URL, {
			context : context,
			nonce : nonce,
			msg_id : msg_id,
			viewing: viewing,
			action : action
		},
		function(response) {
			/*console.log(response);*/
			var resp = JSON.parse(response);
			var disp_message = ( !resp.err_msg ) ? resp.status : resp.err_msg;
			$('.status_message', '#tab'+context).html(disp_message)
			/* use our helper object for the related type */
			pue_BB_pm_helper[type](resp); 
		});
		return false;
	});

	if (  $('.tabs-puebbpm').length > 0 )
		$('.tabs-puebbpm').tabs();

	/* handle bulk actions */
	$('form.inbox-outbox-form').submit(function(e) {
		e.preventDefault();
		var msg_id = new Array();
		var thisform = $('form.inbox-outbox-form');
		var context = $('input[name="page"]', this).val();
		var nonce = $('#pue_bb_pm-bulk-action_'+context).val();
		var action = 'pue_bb_pm_bulk_action';
		var type = (context == 'inbox') ? $('select option:selected').val() : $('input[name="action_outbox"]').val();

		//let's get the values for the checked boxes and add them to the array
		$('input[type="checkbox"]:checked', thisform ).each( function(i) {
			msg_id[i] = $(this).val();
		});

		//k let's post and get the response
		$.post( AJAX_URL, {
			'context': context,
			'nonce': nonce,
			'msg_id': msg_id,
			'action': action,
			'type': type
		},
		function(response) {
			/*console.log(response);/**/
			var resp = JSON.parse(response);
			var disp_message = ( !resp.err_msg ) ? resp.status : resp.err_msg;
			$('.status_message').html(disp_message);
			/* use our helper object for the related type */
			pue_BB_pm_helper[type](resp);
		}); 
	});

});
