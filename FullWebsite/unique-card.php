<div class="popup" id="unique-card-popup">
	<a href="javascript:void(0)" class="popup-close"></a>
	<div class="top"></div>
	<div class="content">
		<div>
			<?php 
				$card_data_json = file_get_contents(APIURL.'?action=get_stories&id='.$_GET['id']);
				$card_data 		= json_decode($card_data_json);
				$uc_title 		= isset($card_data->story_title) ? $card_data->story_title : '';
				$uc_description = isset($card_data->story_description) ? $card_data->story_description : '';
				$uc_image 		= isset($card_data->card_type) ? APIURL."?action=butterflyimage&id=".$card_data->card_type : '';
				$uc_url			= HOMEURL."?id=".$_GET['id'];
				$uc_fname 		= (isset($card_data->first_name) && $card_data->first_name != '') ? $card_data->first_name : 'Anonymous';
				$uc_state		= (isset($card_data->state) && $card_data->state != '') ? ', '.$card_data->state : '';

				$wrap_desc = '';
				$string_count = (int)strlen($uc_title.$uc_url) + 8;
				if($string_count < 140) {
					$wrap_length = 140 - $string_count;
					$wrap_desc = chicos_wrap_text($uc_description,$wrap_length);
				}
			?>
			
			<!-- story hidden data -->
			<input type="hidden" id="h_story_title" value="<?php echo addslashes($uc_title)?>">
			<input type="hidden" id="h_story_url" value="<?php echo addslashes($uc_url)?>">
			<input type="hidden" id="h_story_image" value="<?php echo addslashes($uc_image)?>">
			<input type="hidden" id="h_story_description" value="<?php echo addslashes($uc_description)?>">

			<div id="preview-butterfly-image">
				<img src="<?php echo $uc_image ?>" alt="">
			</div>
			<div id="preview-butterfly-title">
				<?php echo $uc_title?>
			</div>
			<div id="preview-butterfly-message">
				<?php echo $uc_description?>
			</div>
			<div id="preview-butterfly-person-state">
				- <span><?php echo $uc_fname?></span><label><?php echo $uc_state?></label>
			</div>
		</div>
	</div>
	<div class="bottom"></div>
	<div class="unique-share-message-wrapper">
		<div class="unique-card-left">
			<span class="unique-card-message-text">Share this Message On:</span>
									
			<span class="social-button-wrapper">
				<a href="javascript:void(0);" class="facebook" title="Facebook" target="_blank" onclick="postToFeed('<?php echo $_GET['id']?>'); return false;"></a>
				
				<a href="https://twitter.com/intent/tweet?text=<?php echo $uc_title?> - <?php echo $wrap_desc?> <?php echo $uc_url?>" target="_blank" class="twitter" title="Twitter"></a>
				
				<a  class="pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($uc_url)?>?&media=<?php echo urlencode($uc_image)?>&description=<?php echo urlencode($uc_title)?> - <?php echo urlencode($uc_description)?>" count-layout="none" target="_blank"></a>

				<a title="Google +" class="googleplus" href="javascript:void(0);"></a>
			</span>
		</div>
		
		<div class="unique-card-right">
			<a href="<?php echo HOMEURL?>" class="btndark-black goright" id="btn-read-message">Read All Messages &gt;</a>
		</div>
	</div>
</div>