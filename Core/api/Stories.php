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
		

		public function get_file($mongo_file_id = '') {
			$grid = $this->db->getGridFS();
			$image = $grid->findOne($mongo_file_id);
			header('Content-type: image/jpeg');
			echo $image->getBytes();
			exit;
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
		* Delete story.
		* @param string $story_id 
		* @return boolian on success
		*
		*/		
		public function delete_story($story_id) {
			
		}
		
		function get_states () {
			$res = array();
			foreach($this->db->states->find() as $v) {
				$res[$v['short_name']] = $v['long_name'];
			}
			return $res;
		}
	}