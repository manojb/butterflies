<?php 
	ini_set('display_errors',1);
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

	switch ($action) {
		case "insert_story" : 
			$data = $_POST['data'];
			$data['story_description'] = str_replace("\n","<br>",$data['story_description']);
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$data['action'] = 'check_profanity';
			$profanity = check_profanity($data);
			if(isset($profanity['error']) && $profanity['error'] == 'yes') {
				$error = "The text entered may not contain profanity. Please update the highlighted areas";
				$profanity = (object)$profanity;
			} else {
				$data['action'] = 'create_story';
				$result = get_json($data);
				if($result->error) {
					$error = $result->error;
				} else {
					$story_id = $result->story_id;
					header("Location:".HOMEURL."/thank-you.php?id=".$story_id);
					exit;
				}
			}
			break;
	}
	
	
	/*
	*
	* @Call rest api
	* @param $array
	* @Output Jason object to array
	*
	*/
	function get_json($data) {
		$content = http_build_query($data);
		$ch = curl_init(APIURL.'?'.$content);
		#curl_setopt($ch, CURLOPT_POST, 1);
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
		$response = array();
		if(($response = curl_exec($ch)) === false) {
			$return_data['error'] = 'Unknown error';
		} else {
			$return_data = json_decode($response);
		}
		curl_close($ch);
		return (object)$return_data;
	}
	
	/*
	*
	* @Call rest api
	* @param null
	* @Output State array
	*
	*/
	function state_dropdown() {
		$jason_data = file_get_contents(APIURL."?action=get_states");
		return json_decode($jason_data); 
	}
	
	/*
	* @Wrap Text
	*/
	function chicos_wrap_text($text,$position=115) {
		$length = strlen($text);
		$str = substr($text, 0, $position); 
		if($length > $position)
			$str .= '...';
		return $str;
	}

	/*
	*
	* @Check Profanity
	* @param $_POST array
	* @Output Error or Profanity field
	*
	*/
	function check_profanity($req_vars) {
		global $profanity_words;
		$records = array();
		$records['error'] = 'no';
		if(empty($profanity_words)) {
			$url = 'http://www.wdyl.com/profanity?q=%s';
			if($req_vars['story_title']) {
				$f_url = sprintf($url,urlencode($req_vars['story_title']));
				$jsondata = file_get_contents($f_url);
				$result = json_decode($jsondata);
				if($result->response == 'true') {
					$records['story_title'] = 1;
					$records['error'] = 'yes';
				}
			}
			if($req_vars['story_description']) {
				$f_url = sprintf($url,urlencode($req_vars['story_description']));
				$jsondata = file_get_contents($f_url);
				$result = json_decode($jsondata);
				if($result->response == 'true') {
					$records['story_description'] = 1;
					$records['error'] = 'yes';
				}
			}
			if($req_vars['first_name']) {
				$f_url = sprintf($url,urlencode($req_vars['first_name']));
				$jsondata = file_get_contents($f_url);
				$result = json_decode($jsondata);
				if($result->response == 'true') {
					$records['first_name'] = 1;
					$records['error'] = 'yes';
				}
			}
			
		} else {
			if($req_vars['story_title']) {
				if(in_array(strtolower($req_vars['story_title']),$profanity_words)) {
					$records['story_title'] = 1;
					$records['error'] = 'yes';
				}
			}
			if($req_vars['story_description']) {
				if(in_array(strtolower($req_vars['story_description']),$profanity_words)) {
					$records['story_description'] = 1;
					$records['error'] = 'yes';
				}
			}
			if($req_vars['first_name']) {
				if(in_array(strtolower($req_vars['first_name']),$profanity_words)) {
					$records['first_name'] = 1;
					$records['error'] = 'yes';
				}
			}
		}
		return $records;
	}
?>