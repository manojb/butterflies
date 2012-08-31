function formValidate() {
	var s_title 		= $.trim($("#s_title").val());
	var s_description 	= $("#s_description").val();
	var first_name 		= $("#first_name").val();
	var state_id 		= $("#state_id").val();
	var card_type 		= '';
	var error = false;
	
	//Reset error class for first name
	$("#first_name_div label").attr('class','frmlabel');
	$("#first_name_div input").attr('class','');

	//Card type check
	var radio_obj = document.story_submit_form["data[card_type]"];
	for(var i=0; i<radio_obj.length; i++) {
		if(radio_obj[i].checked)
			card_type = radio_obj[i].value;
	}
	if(card_type == '') {
		$("#card_type_div").attr('class','buterfly-radio-wrapper error');
		error = true;
	} else {
		$("#card_type_div").attr('class','buterfly-radio-wrapper');
	}
	
	//Story title check
	if(s_title == '') {
		$("#story_title_div label").attr('class','frmlabel error');
		$("#story_title_div input").attr('class','error');
		error = true;
	} else {
		$("#story_title_div label").attr('class','frmlabel');
		$("#story_title_div input").attr('class','');
	}

	//Story description check
	if(s_description == '') {
		$("#story_description_div label").attr('class','frmlabel error');
		$("#story_description_div textarea").attr('class','error');
		error = true;
	} else {
		$("#story_description_div label").attr('class','frmlabel');
		$("#story_description_div textarea").attr('class','');
	}
	if(error) {
		$(".error-message").show().html("Please complete the missing information.");
		return false;
	} else {
		document.story_submit_form.submit();
	}
}

function limitChar(obj) {
	var total_char = obj.value.length;
	if(total_char >= 1000) {
		obj.value = obj.value.substring(0,1000);
	}
}