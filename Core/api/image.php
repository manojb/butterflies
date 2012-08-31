<?php 
try {
  // get GridFS files collection
  $grid = $story->db->getGridFS();
  
  // retrieve file from collection
  $file = $grid->findOne(array('_id' => new MongoId($req_vars['id'])));

  // send headers and file data
  header('Content-Type: image/jpeg');
  echo $file->getBytes(); 
} catch (MongoConnectionException $e) {
  echo 'Error connecting to MongoDB server';
} catch (MongoException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>