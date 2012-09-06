<?php include 'header.php'?>
	<h1>Thank You 
		<span class="heading-butterfly"></span>
	</h1>

	<a href="index.php" class="read-all-message">Read All Messages &gt;</a>

	<div class="thankyou-wrapper">
		<p>Your message has been posted and can be read here on our site. To set your message free into the world, please share it...and invite your friends and loved ones to create and share their own.</p>
		
		<a href="submit-story.php" class="btndark-black goleft" >Create Another Message &gt;</a>
		<a href="chicos-fas-support.php" class="btndark-black goright" >How To Donate &gt;</a>
	</div>

	<?php 
		$stories 		= file_get_contents(APIURL.'?action=get_stories&id='.$_GET['id']);
		$story_content 	= json_decode($stories);
		$title 			= isset($story_content->story_title) ? $story_content->story_title : '';
		$description 	= isset($story_content->story_description) ? $story_content->story_description : '';
		$image 			= isset($story_content->card_type) ? APIURL."?action=butterflyimage&id=".$story_content->card_type : '';
		$url			= HOMEURL."?id=".$_GET['id'];
		
		$wrap_desc = '';
		$string_count = (int)strlen($title.$url) + 8;
		if($string_count < 140) {
			$wrap_length = 140 - $string_count;
			$wrap_desc = chicos_wrap_text($description,$wrap_length);
		}
	?>
	<div class="share-message-thankyou-wrapper">
		<span class="share-message-text">Share this Message On:</span>
		<span class="social-button-wrapper">
		
			<!-- story hidden data -->
			<input type="hidden" id="story_id_to_share" value="<?php echo (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : ''?>">
			
			<input type="hidden" id="h_story_title" value="<?php echo addslashes($title)?>">
			<input type="hidden" id="h_story_url" value="<?php echo addslashes($url)?>">
			<input type="hidden" id="h_story_image" value="<?php echo addslashes($image)?>">
			<input type="hidden" id="h_story_description" value="<?php echo addslashes($description)?>">
			
			<a href="javascript:void(0);" class="facebook" title="Facebook" target="_blank" onclick="postToFeed('<?php echo $_GET['id']?>'); return false;"></a>

			<a href="https://twitter.com/intent/tweet?text=<?php echo $title?> - <?php echo $wrap_desc?> <?php echo $url?>" target="_blank" class="twitter" title="Twitter"></a>

			<a  class="pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($url)?>?&media=<?php echo urlencode($image)?>&description=<?php echo urlencode($title)?> - <?php echo urlencode($description)?>" count-layout="none" target="_blank"></a>
			
			<a href="https://m.google.com/app/plus/x/?v=compose&content=<?php echo urlencode($title)?> - <?php echo urlencode($description)?> <?php echo urlencode($url)?>" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=<?php echo urlencode($title)?> - <?php echo urlencode($description)?> <?php echo urlencode($url)?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;" onstartinteraction="startInteraction" onendinteraction="endInteraction" class="googleplus" rel="nofollow"></a>
			
			<!-- <a href="https://plusone.google.com/_/+1/confirm?hl=en&url=209.239.120.86/dev/chicos_fas_lbbc/FullWebsite/&title=text text&description=est desc&content=test content" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" onstartinteraction="startInteraction" onendinteraction="endInteraction"><img src="http://localhost/practice/mongotest/image.php" alt="Share on Google+"/></a>


			<!-- Google+ Share Button: http://pleer.co.uk/wordpress/plugins/google-plus-share-button/ --
			<a href="javascript:(function(){var w=480;var h=380;var x=Number((window.screen.width-w)/2);var y=Number((window.screen.height-h)/2);window.open('https://plusone.google.com/_/+1/confirm?hl=en&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');})();">Share G+</a>		-->		
			
		</span>
		
		<div class="thankyou-wrapper-content">
			<div class="thankyou-wrapper-content-top"></div>
			<div class="thankyou-wrapper-content-middle">
				<div>
					<div class="thankyou-wrapper-image">
						<img src="<?php echo $image?>" alt="">
					</div>
					<div class="thankyou-wrapper-title"><?php echo $title?></div>
					<div class="thankyou-wrapper-message">
							<?php if(isset($story_content->story_description)) : ?>
								<p id="read_more_p">
									<?php echo chicos_wrap_text($story_content->story_description,115);?>
									<?php if(strlen($story_content->story_description) > 115) : ?>
										<a href="#" onclick="readMore('read_hide_p','read_more_p');">Read More &gt;</a>
									<?php endif?>
								</p>
								<p id="read_hide_p" style="display:none;">
									<?php echo $story_content->story_description?>
									<a href="#" onclick="hideMessage('read_hide_p','read_more_p');">Hide Message &gt;</a>
								</p>
							<?php endif?>
						
					</div>
					<div class="thankyou-wrapper-message-person-state">
						- <span><?php echo (isset($story_content->first_name) && $story_content->first_name != '') ? $story_content->first_name : 'Anonymous'?></span><label><?php echo (isset($story_content->state) && $story_content->state != '') ? ', '.$story_content->state : ''?></label>
					</div>
				</div>
			</div>
			<div class="thankyou-wrapper-content-bottom"></div>
		</div>
	</div>

	<?php include 'script.php'?>
	
	<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
	<script type="text/javascript">
		twttr.events.bind('tweet', function(event) {
			var story_id_to_share = document.getElementById("story_id_to_share").value;
			var url = apiurl+"?action=track_share&field=twitter_share&story_id="+story_id_to_share;
			//alert(story_id_to_share);
			$.get(url,function(msg){
				//alert(msg);
			});
		});
	</script>

<?php include 'footer.php'?>