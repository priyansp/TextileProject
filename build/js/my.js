$(document).ready(function(){
	$('form').submit(function(e){
		var select_tags=$(this).find('select');
		var error=false;
		for(index in select_tags){
			if(select_tags[index].value==='not_selected'){		
				error=true;
				$(select_tags[index]).addClass('select_errored');
				$(select_tags[index]).next().css({"display": "block"});
				$(select_tags[index]).parent().addClass("has-error");
			}
		}
		if(error){
			e.preventDefault();
		}
	});

	$("body").on("change","select",function(){
		var form=$(this).parents("form").get(0);
		var select_tags=$(form).find('select');
		$(select_tags).parent().removeClass("has-error");
		$(select_tags).removeClass('select_errored');
		$(form).find('.select_list_error').css({"display": "none"});
	});	
});