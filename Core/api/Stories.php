<?php 
	require_once "MongoUtil.php";
	class Stories {		
		var $db;
		var $hostname;
		var $username;
		var $password;
		var $dbname;
		var $profanity_words;
		
		function __construct() {
			$this->setGloablConfig();
			try {
				$con = new Mongo($this->hostname);
				$this->db = $con->{$this->dbname};
			} catch (MongoConnectionException $e) {
				$error_data['error'] = "Error: DB Connection Error\n";
				echo json_encode($error_data);
				exit;
			} catch (MongoException $e) {
				$error_data['error'] = 'Error: ' . $e->getMessage();
				echo json_encode($error_data);
				exit;
			}
		}
		
		function setGloablConfig() {
			global $CONFIG;
			$this->hostname 	= $CONFIG['MONGODHOST'];
			$this->username 	= $CONFIG['USERNAME'];
			$this->password 	= $CONFIG['PASSWORD'];
			$this->dbname	 	= $CONFIG['MONGODBNAME'];
			$this->profanity_words = $CONFIG['PROFANITY'];
		}
		
		/**
		*
		* Get total no of stories.
		* @param string $name 
		*
		*/		
		public function total_stories_by_name($str='') {
			$res = array();
			$res['total_records'] = $this->db->stories->find(array('first_name'=>new MongoRegex("/".$str."/i")))->count();
			return $res;
		}
		
		/**
		*
		* Get story list.
		* @param array $param data 
		* @return array
		*
		*/		
		public function get_stories($args='') {
			if(isset($args['id'])) {
				return $this->db->stories->findOne(array('_id' => new MongoId($args['id'])));
			} else {
				$res = array();
				$res['total_records'] 	= $this->db->stories->count();
				foreach($this->db->stories->find() as $v) {
					$row[] = $v;
				}
				$res['data'] = $row;
				return $res;
			}
		}
		
		/*
		*
		* @ Return story html to set in wall page to replace loader image
		*
		*/
		function get_stories_html($req_vars) {
			$jason_array = '';
			$session_limit = $req_vars['st_limit'];
			$st_limit = $req_vars['st_limit'];
			//array($req_vars['search_by'] => $req_vars['search_string'])
			if((int)($st_limit) == 0) {
				if(isset($req_vars['search_option']) && ($req_vars['search_option'] == 'search')) {
					$story_cursor = $this->db->stories->find(array('first_name' => new MongoRegex("/".$req_vars['search_string']."/i")))->sort(array($req_vars['order_by'] => (int)$req_vars['order']))->limit((int)$req_vars['limit']);
				} else {
					$story_cursor = $this->db->stories->find()->sort(array($req_vars['order_by'] => (int)$req_vars['order']))->limit((int)$req_vars['limit']);
				}
			} else {
				if(isset($req_vars['search_option']) && ($req_vars['search_option'] == 'search')) {
					$story_cursor = $this->db->stories->find(array('first_name' => new MongoRegex("/".$req_vars['search_string']."/i")))->sort(array($req_vars['order_by'] => (int)$req_vars['order']))->limit($req_vars['limit'])->skip((int)($st_limit));
				} else {
					$story_cursor = $this->db->stories->find()->sort(array($req_vars['order_by'] => (int)$req_vars['order']))->limit($req_vars['limit'])->skip((int)($st_limit));
				}
			}
			
			foreach($story_cursor as $k=>$v) {
			//foreach($this->db->stories->find() as $k=>$v) {
				$title 			= isset($v['story_title']) ? $v['story_title'] : '';
				$description 	= isset($v['story_description']) ? $v['story_description'] : '';
				$image 			= trim($req_vars['apiurl'],'/')."/?action=butterflyimage&id=".$v['card_type'];
				$name 			= (isset($v['first_name']) && $v['first_name'] != '') ? $v['first_name'] : 'Anonymous';
				$state 			= (isset($v['state']) && $v['state'] != '') ? ', '.$v['state'] : '';
				$url 			= trim($req_vars['homeurl'],'/')."/?id=".$v['_id'];
				
				$wrap_desc = '';
				$string_count = (int)strlen($title.$url) + 8;
				if($string_count < 140) {
					$wrap_length = 140 - $string_count;
					$wrap_desc = $this->wrap_text($description,$wrap_length);
				}

				$jason_array[$k]['id']	= 'item-'.$session_limit;
				$jason_array[$k]['html'] = "<div class='top'></div><div class='content'><div><div class='image-wrapper'><img src='$image' alt='' /></div><h3 class='title'>$title</h3><div id='summary".$session_limit."'><div class='message'><p>".$this->wrap_text($description);
				
				if(strlen($description) > 115)
					$jason_array[$k]['html'] .= " <a href='javascript:void(0);'  onclick='readMoreWall(\"fullview".$session_limit."\",\"summary".$session_limit."\");'>Read More &gt;</a>";
				
				$jason_array[$k]['html'] .= "</p></div><div class='person-state'> - <span>$name</span><label>$state</label></div></div><div id='fullview".$session_limit."' class='fullview'><div class='message'><p>$description<span><a href='javascript:void(0);' onclick='hideMessageWall(\"fullview".$session_limit."\",\"summary".$session_limit."\");'>Hide Message</a></span></p></div><div class='person-state'> - <span>$name</span><label>$state</label></div><div class='share-message'><span class='wallpost-share-message-text'>Share this Message On:</span><span class='social-button-wrapper'><a title='Facebook' class='facebook' href='javascript:void(0);' target='_blank' onclick='postToFeedAll(\"".$v['_id']."\"); return false;'></a> <a title='Twitter' class='twitter' onclick='document.getElementById(\"story_id_to_share\").value = \"".$v['_id']."\";' href='https://twitter.com/intent/tweet?text=".$title." - ".$wrap_desc." ".$url."' target='_blank'></a> <a class='pinterest' href='http://pinterest.com/pin/create/button/?url=".urlencode($url)."?&media=".urlencode($image)."&description=".urlencode($title)." - ".urlencode($description)."' count-layout='none' target='_blank'></a> <a title='Google +' class='googleplus' href='javascript:void(0);'></a></span></div></div></div></div><div class='bottom'></div>";
				$session_limit++;
			}
			return $jason_array;
		}
		
		/**
		*
		* Creates a new story.
		* @param array $story_data 
		* @return id if the new story was successfully created
		*
		*/		
		public function create_story($data) {
			$data['date_creation'] 		= new MongoDate();
			$data['date_modification'] 	= new MongoDate();		
			try {
				$res = $this->db->stories->insert($data);
			} catch(MongoCursorException $e) {
				$result['error'] = 'Document not inserted due to some unknown error';
			}
			$result['data'] = $data;
			$result['story_id'] = (string)$data['_id'];
			if($res == 1) {
				$result['error'] = '';
			} else {
				$result['error'] = 'Document not inserted due to some unknown error';
			}
			return $result;
		}

		/**
		*
		* Update story.
		* @param array $story_data 
		* @return id if the new story was successfully created
		*
		*/		
		public function update_story($id,$data) {
			$data['date_modification'] 	= new MongoDate();
			return $this->db->stories->update(
				array('_id' => new MongoId($id)),
				array('$set' => $data)
			);
		}

		/**
		*
		* Track Social Media Shares.
		* @param array = action, option , story_id
		* @return boolean
		*
		*/		
		public function track_share($req_vars) {
			$data['date_modification'] 	= new MongoDate();
			$this->db->stories->update(
				array('_id' => new MongoId($req_vars['story_id'])),
				array('$inc' => array($req_vars['field'] => 1)), 
				array("upsert" => true)
			);
			return $this->db->stories->findOne(array('_id' => new MongoId($req_vars['story_id'])));
		}

		/*
		* @Wrap Text
		*/
		function wrap_text($text,$position=115) {
			$length = strlen($text);
			$str = substr($text, 0, $position); 
			if($length > $position)
				$str .= '...';
			return $str;
		}

		
		function get_states () {
			$res = array();
			foreach($this->db->states->find() as $v) {
				$res[$v['short_name']] = $v['long_name'];
			}
			return $res;
		}
	}