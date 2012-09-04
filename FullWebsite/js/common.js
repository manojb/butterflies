$(function(){
	if($('#overlay').length > 0){
		$('#overlay').css('opacity',0);	
	}
	$('#btnpreview').click(function(){
	  makeHCenter('preview-butterfly');										
		getPreviewContent();									
		$('#preview-butterfly').fadeIn('slow');
		showOverlay();	
	});
	
	$('.popup-close').click(function(){
		$(this).parent().fadeOut('slow');
		$('#overlay').fadeOut(750);
	});
	
	$('#popup-edit').click(function(){
		 makeHCenter('preview-butterfly');									
	 	$('#preview-butterfly').fadeOut('slow');
		$('#overlay').fadeOut(750);							
	});
	
	$('.terms').click(function(){
		showTerms();					   
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
	var s_description 	= $.trim($("#s_description").val()).replace(/\n/g,"<br>");
	//var s_description 	= $.trim($("#s_description").val()).replace("\n",String.fromCharCode(13));
	//var s_description 	= $.trim($("#s_description").val());
	var first_name 		= $.trim($("#first_name").val());
	var state_id 		= $("#state_id").val();
	var card_type 		= '';
	if(first_name == '')
		first_name = 'Annonmyous';
	if(state_id != '')	
		state_id = ', '+state_id;
		
	var radio_obj = document.story_submit_form["data[card_type]"];
	for(var i=0; i<radio_obj.length; i++) {
		if(radio_obj[i].checked) {
			card_type = radio_obj[i].value;
			$("#preview-butterfly-image img").attr('src',$("#bf_"+card_type).attr('src'));
		}
	}
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
	$("#"+showid).slideDown('slow')
}

function readMoreWall(showid,hideid) {
	//alert("fullview_div : "+fullview_div+" summerydiv : "+summerydiv);
	if(fullview_div != '') $("#"+summerydiv).show();
	if(summerydiv != '') $("#"+fullview_div).hide();
		
	fullview_div = showid;
	summerydiv = hideid;
	$("#"+hideid).hide();
	$("#"+showid).slideDown('slow');
}

function hideMessageWall(hideid,showid) {
	fullview_div = "";
	summerydiv = "";
	$("#"+hideid).slideUp('slow');
	$("#"+showid).slideDown('slow');
}

/*
* @Load wall during home page load or sorting record or search by name
*/
function loadWallMessage(reset_option,search_option) {
	var total_records = $("#total_records").val();
	if(parseInt(reset_option) == 1 ) {
		$("#wallcol1").html('');
		$("#wallcol2").html('');
		$("#wallcol3").html('');
		
	}
	var st_limit = 0;
	var ed_limit = 6;
	total_records = parseInt(total_records);
	if(total_records > 0) {
		if(ed_limit > total_records) {
			ed_limit = total_records;
		}
		//alert("total_records + st_limit + ed_limit :: " +  total_records +' : '+ st_limit +' : '+ ed_limit);		
		createCookie('c_limit',6);
		for(var i = parseInt(st_limit); i < parseInt(ed_limit); i++) {
			var div_ch 		= (i%3);
			var div_html 	= '<div class="wallpost" id="item-'+i+'"><div class="loader"></div></div>';
			switch(div_ch) {
				case 0 :
					$("#wallcol1").append(div_html);
					break;
				case 1 :
					$("#wallcol2").append(div_html);
					break;
				case 2 :
					$("#wallcol3").append(div_html);
					break;
			}
		}
		loadContent (st_limit,ed_limit,6,search_option);
	}
}


/*
* @Search wall message by story title
*/
function searchWallMessage () {
	var total_records = $("#total_records").val();
	var search_string = $("#search_string").val();
	$("#search_string").attr('class',"");
	$("#search_error_span").attr('class',"");
	$("#search_error_span").html("");
	$.post(apiurl,{action : 'total_stories_by_name', search_string : search_string},function(json_obj_count) {
		if(json_obj_count){
			total_records = json_obj_count.total_records;
			if(parseInt(total_records) > 0 ) {
				//alert(total_records);
				$("#total_records").val(total_records);			
				$("#search_text_for_sort").val(search_string);			
				loadWallMessage(1,'search');
			} else {
				//alert("No records found - " + total_records);
				$("#search_string").attr('class','error');
				$("#search_error_span").attr('class','error');
				$("#search_error_span").html("Sorry. \""+search_string+"\" was not found");
			}
		}
	},"json");
}


/*
* @Ajax call + Fill the content into blank loader divs 
*/
function loadContent (st_limit,ed_limit,limit,search_option) {
	var order = $("#sort_option").val();
	if(search_option == 'sortsearch') {
		var search_string = $("#search_text_for_sort").val();
		if(search_string != '') {
			search_option = 'search';
		}
	} else {
		var search_string = $("#search_string").val();
	}
		
	createCookie('loop_limit',ed_limit);
	$.post(apiurl,{action : 'stories_ajax_html', order_by:'_id',order:order,search_option:search_option, search_string : search_string,st_limit : st_limit, ed_limit:ed_limit, limit:limit,apiurl:apiurl},function(html) {
		if(html){
			$.each(html, function(i, json_obj) {
				$("#"+json_obj.id).html(json_obj.html).fadeIn('slow');
				//setTimeout(function(){$("#" + val.id).hide().html(val.html).fadeIn('slow')},3000);
			});
		}else{
			$('div.end_loader').html('<h1>No more posts to show.</h1>');
		}
	},"json");
}

/*
* @Create cookie
*/		
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

/*
* @Get cookie
*/		
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

/*
* @Delete cookie
*/		
function eraseCookie(name) {
	createCookie(name,"",-1);
}



function makeHCenter(objId){
var halfHeight = parseInt($('#'+objId).height()/2);	
$('#'+objId).css('margin-top','-'+halfHeight+'px');
return;
}
function showTerms(){
 makeHCenter('terms');
 $('#terms').fadeIn('slow');	
 showOverlay();
}