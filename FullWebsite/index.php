<?php include 'header.php'?>
<a href="<?php echo HOMEURL?>/submit-story.php">here</a>
<h2>Home/Wall Page</h2>
<pre>
<?php 
	$stories = file_get_contents(APIURL.'?action=get_stories');
	$stories_C = json_decode($stories,1);
	/*echo $stories_C['total_records'];
	foreach($stories_C['data'] as $s) {
		print_r($s);
	}*/
	echo '<h1>Comming Soon</h1>';
?>
<?php include 'footer.php'?>