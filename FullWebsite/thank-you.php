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
		$image 			= isset($story_content->card_type) ? HOMEURL."/images/".$story_content->card_type : '';
		$url			= HOMEURL."?id=".$_GET['id'];
	?>
	<div class="share-message-thankyou-wrapper">
		<span class="share-message-text">Share this Message On:</span>
		<span class="social-button-wrapper">
			<a href="#" class="facebook" title="Facebook" target="_blank" onclick="postToFeed('<?php echo addslashes($url)?>','<?php echo addslashes($image)?>','<?php echo addslashes($title)?>','','<?php echo addslashes($description)?>'); return false;"></a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo $title?> - <?php echo HOMEURL?>?id=<?php echo $_GET['id']?>" target="_blank" class="twitter" title="Twitter"></a>
			<a href="#" class="pinterest" title="Pinterest"></a>
			<a href="#" class="googleplus" title="Google +"></a>
			
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
									<?php echo chicos_wrap_text($story_content->story_description,90);?>
									<?php if(strlen($story_content->story_description) > 90) : ?>
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
<?php include 'footer.php'?>