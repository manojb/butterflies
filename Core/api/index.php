<?php 
	//ini_set('display_errors',1);
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
					if($k == 'PROFANITY') continue;
					$CONFIG[$k] = '';
				}
				echo json_encode($CONFIG);
			}
			break;
		case 'get_stories':
			$story_list = $story->get_stories($req_vars);
			echo json_encode($story_list);
			break;
		
		case 'get_stories_array':
			$story_list = $story->get_stories($req_vars);
			echo "<pre>";
			print_r($story_list);
			echo "</pre>";
			break;

		case 'total_stories_by_name':
			$story_list = $story->total_stories_by_name($req_vars['search_string']);
			echo json_encode($story_list);
			break;

		case 'stories_ajax_html':
			$story_html = $story->get_stories_html($req_vars);
			echo json_encode($story_html);
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
		
		/*
		* @Get butterfly images
		*/
		case 'get_butterfly_ids' :
			$file_ids = array();
			// get GridFS files collection
			$grid = $story->db->getGridFS();
			foreach($grid->find(array('i_type' => 'butterfly'),array("_id"))->sort(array('order' => 1)) as $v) {
				$file_ids[] = $v->file;
			}
			echo json_encode($file_ids);
			break;
		
		//Butterfly images
		case "butterflyimage" :
			include "image.php";
			break;
			
		/*
		*
		* @Track clicks , social media share		
		*/
		case "track_share" :
			$res = $story->track_share($req_vars);
			echo json_encode($res);
			break;
	}
	$jason_data = ob_get_contents();
	ob_end_clean();
	echo $jason_data;
	exit;
?>