FB.init({appId: FBAPPID, status: true, cookie: true});
function postToFeed(url,image1,title,caption1,message) {
	var obj = {
		method: 'feed',
		link: url,
		picture: image1,
		name: title,
		caption: caption1,
		description: message
	};

	function callback(response) {
		//document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
		return true; 
	}
	FB.ui(obj, callback);
}
