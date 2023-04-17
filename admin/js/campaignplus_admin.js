jQuery(document).ready(function(){

	jQuery(document).on('click', '#btn_compaign_activate', function(event){
        var txt_compaign_key = jQuery(document).find('#txt_compaign_key').val();
		event.preventDefault();

		var params = { "action" : 'campaign_admin_ajax_activate_store', 'txt_compaign_key':txt_compaign_key };
		Compaign_RequestHandler(params);
	});


	jQuery(document).on('click', '#btn_compaign_create_group', function(event){
		var for_attr = jQuery(this).attr('for');
        var group_name = $(`#${for_attr}_group_name`).val();

		var params = { "action" : 'campaign_admin_ajax_create_group', 'group_name':group_name };
		Compaign_RequestHandler(params);
		event.preventDefault();
    });  




	jQuery(document).on('click', '#btn_compaign_force_sync_contact', function(event){
		var params = { "action" : 'campaign_admin_ajax_force_contact_sync'};
		Compaign_RequestHandler(params);
		event.preventDefault();
    });  




	jQuery(document).on('click', '.enabled_settings', function(event){
		var req_for = jQuery(this).attr('data-id');
		var status = jQuery(this).prop('checked');
		var params = { "action" : 'campaign_admin_settings_update','req_for':req_for, 'status':status};
		Compaign_RequestHandler(params);
    }); 

	
 
 
	function Compaign_RequestHandler(params = ''){
		if(params != ''){
			jQuery.ajax({
				type:"POST", 
				url:my_ajax_object.ajax_url,
				data: params,
				success:function(response){
					console.log(response);  return false; 

					const res_obj = JSON.parse(response);
					toastr.options.timeOut = 2000;
					if(res_obj.status == 1){
						toastr.success(res_obj.message);
					}else{
						toastr.error(res_obj.message);
					}
					console.log(res_obj);
				},
				error: function (textStatus, errorThrown) {
					console.log('errorThrown', errorThrown);
					console.log('textStatus', textStatus);
				}
			});
		}else{
			toastr.options.timeOut = 2000;
			toastr.danger('Invalid paramiters');
		}

	}
});