$(function(){
	if($('#overlay').length > 0){
		$('#overlay').css('opacity',0);	
	}
	$('#btnpreview').click(function(){
		getPreviewContent();									
		$('#preview-butterfly').fadeIn('slow');
		showOverlay();	
	});
	
	$('.popup-close').click(function(){
		$(this).parent().fadeOut('slow');
		$('#overlay').fadeOut(750);
	});
	
	$('#popup-edit').click(function(){
	 	$('#preview-butterfly').fadeOut('slow');
		$('#overlay').fadeOut(750);							
	});
});// end of $ function

function showPreview(){
	showOverlay();	
}

function showOverlay(){
	$('#overlay').show().animate({'opacity': 0.6}, 750)	;
}



function getPreviewContent(){
	var s_title 		= $.trim($("#s_title").val());
	var s_description 	= $.trim($("#s_description").val());
	var first_name 		= $.trim($("#first_name").val());
	var state_id 		= $("#state_id").val();
	var card_type 		= '';
	if(first_name == '')
		first_name = 'Annonmyous';
	if(state_id != '')	
		state_id = ', '+state_id;
		
	var radio_obj = document.story_submit_form["data[card_type]"];
	for(var i=0; i<radio_obj.length; i++) {
		if(radio_obj[i].checked)
			card_type = radio_obj[i].value;
	}
	$("#preview-butterfly-image img").attr('src',$("#bf_"+card_type).attr('src'));
	$("#preview-butterfly-title").html(s_title);
	$("#preview-butterfly-message").html(s_description);
	$("#preview-butterfly-person-state span").html(first_name);
	$("#preview-butterfly-person-state label").html(state_id);
}

function readMore(showid,hideid) {
	$("#"+hideid).hide();
	$("#"+showid).slideDown('slow');
}

function hideMessage(hideid,showid) {
	$("#"+hideid).slideUp('slow');
	$("#"+showid).show();
}


