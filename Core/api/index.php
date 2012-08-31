<?php 
	include "common.php";
	include "API.php";
	include "Stories.php";
	/*
	* @Process Rest Request
	*/
	$data = RestUtils::processRequest();
	$req_vars = $data->getRequestVars();
	$story = new Stories();
	$jason_data = '';
	ob_start();
	switch($data->getMethod())
	{
		case "get_config" :
			if(isset($_GET['u']) && $_GET['u'] == 'cadmin' && isset($_GET['p']) && $_GET['p'] == 'w0rdp455') { 
				echo json_encode($CONFIG);
			} else {
				foreach($CONFIG as $k=>$v) {
					if($k == 'WEBHOMEDIR' || $k == 'MOBILEHOMEDIR' || $k == 'PROFANITY') continue;
					$CONFIG[$k] = '';
				}
				echo json_encode($CONFIG);
			}
			break;
		case 'get_stories':
			$story_list = $story->get_stories($req_vars);
			echo json_encode($story_list);
			break;

		case 'get_stories_cursor':
			$story_cursor = $story->get_stories_cursor();
			echo json_encode($story_cursor);
			break;

		case 'get_states':
			$states_list = $story->get_states();
			echo json_encode($states_list);
			break;

		case 'create_story':
			unset($req_vars['action']);
			$story_data = $req_vars;
			if(isset($story_data['id']) && $story_data['id'] > 0) {
				$story->update_story($story_data['id'],$story_data);
			} else {
				$story_data = $story->create_story($story_data);
			}
			echo json_encode($story_data);
			break;		
			
		case 'check_profanity':
			$records = array();
			$records['error'] = 'no';
			if(empty($story->profanity_words)) {
				$url = 'http://www.wdyl.com/profanity?q=%s';
				if($req_vars['story_title']) {
					$f_url = sprintf($url,$req_vars['story_title']);
					$jsondata = file_get_contents($f_url);
					$result = json_decode($jsondata);
					if($result->response == 'true') {
						$records['story_title'] = 1;
						$records['error'] = 'yes';
					}
				}
				if($req_vars['story_description']) {
					$f_url = sprintf($url,$req_vars['story_description']);
					$jsondata = file_get_contents($f_url);
					$result = json_decode($jsondata);
					if($result->response == 'true') {
						$records['story_description'] = 1;
						$records['error'] = 'yes';
					}
				}
				if($req_vars['first_name']) {
					$f_url = sprintf($url,$req_vars['first_name']);
					$jsondata = file_get_contents($f_url);
					$result = json_decode($jsondata);
					if($result->response == 'true') {
						$records['first_name'] = 1;
						$records['error'] = 'yes';
					}
				}
				
			} else {
				if($req_vars['story_title']) {
					if(in_array($req_vars['story_title'],$story->profanity_words)) {
						$records['story_title'] = 1;
						$records['error'] = 'yes';
					}
				}
				if($req_vars['story_description']) {
					if(in_array($req_vars['story_description'],$story->profanity_words)) {
						$records['story_description'] = 1;
						$records['error'] = 'yes';
					}
				}
				if($req_vars['first_name']) {
					if(in_array($req_vars['first_name'],$story->profanity_words)) {
						$records['first_name'] = 1;
						$records['error'] = 'yes';
					}
				}
			}
			echo json_encode($records);
			break;
	}
	$jason_data = ob_get_contents();
	ob_end_clean();
	echo $jason_data;
	exit;
?>