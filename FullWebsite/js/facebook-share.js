FB.init({appId: FBAPPID, status: true, cookie: true});
function postToFeed(mid) {
	var title = document.getElementById("h_story_title").value;
	var image1 = document.getElementById("h_story_image").value;
	var message = document.getElementById("h_story_description").value;
	var url = document.getElementById("h_story_url").value;
	var caption1 = "";
	//alert(url+" , "+image1+" , "+title+" , "+caption1+" , "+message);
	var obj = {
		method: 'feed',
		link: url,
		picture: image1,
		name: title,
		caption: caption1,
		description: message
	};

	function callback(response) {
		//alert("Post ID: " + response['post_id']);
		var url = apiurl+"?action=track_share&field=facebook_share&story_id="+mid;
		$.get(url,function(msg){
			//alert(msg);
		});	
		return true; 
	}
	FB.ui(obj, callback);
}

function postToFeedAll(mid) {
	//alert(url+" , "+image1+" , "+title+" , "+caption1+" , "+message);
	var c_url = apiurl+"?action=get_stories&id="+mid;
	$.get(c_url,function(jobj){
		var obj = {
			method: 'feed',
			link: homeurl+"?id="+mid,
			picture: apiurl+"?action=butterflyimage&id="+jobj.card_type,
			name: jobj.story_title,
			caption: "",
			description: jobj.story_description
		};

		function callback(response) {
			//alert("Post ID: " + response['post_id']);
			var url = apiurl+"?action=track_share&field=facebook_share&story_id="+mid;
			$.get(url,function(msg){
				//alert(msg);
			});	
			return true; 
		}
		FB.ui(obj, callback);
	},"json");
}
