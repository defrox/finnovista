jQuery(document).ready(function(){
	var plug_path = clone_main_obj.plugin_url;
	jQuery('#make_clone_btn').click(function(){
			
		var menu_id = jQuery('#all_menu_items').val();
	
		var new_name = jQuery('#clone_menu_name').val();
		
		if(menu_id == ''){
			alert("Please select existing menu to be clone!");
			return false;
		}else if(new_name == ''){
			alert("Please enter menu name");
			return false;
		}else{
			jQuery(this).attr('disabled','disabled');
			jQuery(".wrap.main-wrap").css("background-color","#CCC");

			jQuery(".wrap.main-wrap").append('<div class="module_holder"><div class="module_item"><img src="'+plug_path+'/image/loader.gif"></div></div>');

			jQuery.ajax({
				url:ajaxurl,
				type:'POST',
				data:{
					action:'make_clone',
					new_name:new_name,
					menu_id:menu_id
				},
				success:function(response){
					 jQuery('#make_clone_btn').attr("disabled", false); 
					
					if(response){
						var str = 'Cheers Menu Clone Successfully, Edit Menu <a href="nav-menus.php?action=edit&menu='+response+'" target="_blank" title="+new_name+" >here</a>';
						jQuery('#response').html(str);
						jQuery("#all_menu_items").val(jQuery("#all_menu_items option:first").val());
						jQuery("#clone_menu_name").val("");
						jQuery(".module_holder").html("");
						jQuery(".wrap.main-wrap").css("background-color","#F1F1F1");						
					}
				},
				 error: function(errorThrown){
					console.log(errorThrown);
				}
			})

		}
		
	});

});