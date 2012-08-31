<?php include 'header.php'?>
<?php 
	if(!empty($_POST['data'])) extract($_POST['data']);
	$card_type = isset($card_type) ? $card_type : '';
	$state = isset($state) ? $state : '';
?>
	<h1>Create Your Message
		<span class="heading-butterfly"></span>
	</h1>
	<a href="index.php" class="read-all-message">Read All Messages &gt;</a>
	
	<form action="" name="story_submit_form" method="post" enctype="multipart/form-data" class="form-wrapper">
		<div class="error-message" <?php if(isset($error)) echo "style='display:block;'"?>><?php echo (isset($error) ? $error : '')?></div>
		<!-- 
			<div class="error-message">Please complete the missing information.</div>
			<div class="error-message">The text entered may not contain profanity. Please update the highlighted areas.</div>
		-->

		<label class="frmlabel card_type_label">SELECT YOUR BUTTERFLY *</label>
		<span class="required">* Required</span>
		
		<div class="buterfly-radio-wrapper" id="card_type_div">
			<label>
				<img src="images/butterfly1.jpg">
				<input type="radio" name="data[card_type]" value="butterfly1.jpg" <?php if($card_type == 'butterfly1.jpg') echo "checked='checked'";?> />
			</label>
			<label>
				<img src="images/butterfly2.jpg">
				<input type="radio" name="data[card_type]" value="butterfly2.jpg" <?php if($card_type == 'butterfly2.jpg') echo "checked='checked'";?> />
			</label>
			<label>
				<img src="images/butterfly3.jpg">
				<input type="radio" name="data[card_type]" value="butterfly3.jpg" <?php if($card_type == 'butterfly3.jpg') echo "checked='checked'";?> />
			</label>
			<label>
				<img src="images/butterfly4.jpg">
				<input type="radio" name="data[card_type]" value="butterfly4.jpg" <?php if($card_type == 'butterfly4.jpg') echo "checked='checked'";?> />
			</label>
			<label>
				<img src="images/butterfly5.jpg">
				<input type="radio" name="data[card_type]" value="butterfly5.jpg" <?php if($card_type == 'butterfly5.jpg') echo "checked='checked'";?> />
			</label>
		</div>
		
		<!-- <br>
		<div class="information_label">YOUR INFORMATION</div>
		<br> -->
		
		<div class="field-wrapper" id="story_title_div">
			<label class="frmlabel<?php echo (isset($profanity->story_title) && $profanity->story_title == '1') ? ' error' : '';?>">Message Title *</label>
			<span class="limit-text">Limit 25 Charecters</span>
			<input type="text" name="data[story_title]" id="s_title" value="<?php echo isset($story_title) ? $story_title : '';?>" maxlength=25 class="<?php echo (isset($profanity->story_title) && $profanity->story_title == '1') ? 'error' : '';?>" />
		</div>
		
		<div class="field-wrapper" id="story_description_div">
			<label class="frmlabel<?php echo (isset($profanity->story_description) && $profanity->story_description == '1') ? ' error' : '';?>">Your Message *</label>
			<span class="limit-text">Limit 1000 Charecters</span>
			<textarea name="data[story_description]" id="s_description" class="<?php echo (isset($profanity->story_description) && $profanity->story_description == '1') ? 'error' : '';?>" onkeyup="limitChar(this);"><?php echo isset($story_description) ? $story_description : '';?></textarea>
		</div>		

		<div class="field-wrapper field-wrapper-half" id="first_name_div">
			<label class="frmlabel<?php echo (isset($profanity->first_name) && $profanity->first_name == '1') ? ' error' : '';?>">Your First Name</label>
			<span class="limit-text">Limit 25 Charecters</span>
			<input type="text" name="data[first_name]" id="first_name" value="<?php echo isset($first_name) ? $first_name : '';?>" maxlength=25 class="<?php echo (isset($profanity->first_name) && $profanity->first_name == '1') ? 'error' : '';?>">
			<span class="anonymous">Leaving this space blank will sign your message 'Annonmyous'</span>
		</div>
		
		<div class="field-wrapper field-wrapper-select" id="state_div">
			<label class="frmlabel">Your State</label>
			<select name="data[state]" id="state_id">	
				<option value=''>Choose</option>
				<?php foreach(state_dropdown() as $k=>$v) : ?>
					<option value='<?php echo $k?>' <?php if($state == $k) echo "selected='selected'";?>><?php echo $v?></option>
				<?php endforeach?>
			</select>
		</div>
		
		<div class="form-button-wrapper">
			<a href="javascript:void(0)" class="btnlight" id="btnpreview">Preview &gt;</a>
			<a href="javascript:void(0)" class="btndark goright" onclick="formValidate();">Set Your Message Free &gt;</a>
		</div>
		<div class="sep"></div>
		<input type="hidden" name="action" value="insert_story">
	</form>	
	
	<div class="help-wrapper">
		<h2>How You Can Help</h2>
		<p>Together with caring customers like you, Chico's and our sister brands, White House Black Market, Soma Intimates, and Boston Proper have donated over $2,000,000 to LBBC since 2004, helping to bring support to more than 350,000 women diagnosed with breast cancer. Below, find our special collections created in honor of breast cancer awareness month.</p>	
		<a href="chicos-fas-support.php" class="btndark" >How To Donate &gt;</a>
	</div>
	
	<!-- Preview pop up window start -->
	<div id="overlay"></div>
	<div class="popup" id="preview-butterfly">
		<a href="javascript:void(0)" class="popup-close"></a>
		<div class="top"></div>
		<div class="content">
			<div>
				<a href="javascript:void(0)" id="popup-edit">Edit</a>
				<div id="preview-butterfly-image">
					<img src="images/butterfly3.jpg" alt="">
				</div>
				<div id="preview-butterfly-title">
					Vestibulum Interdum Magna
				</div>
				<div id="preview-butterfly-message">
					<p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Morbi commodo, ipsum sed pharetra gravida, orci magna rhoncus neque, id pulvinar odio lorem non turpis. Nullam sit amet enim. Suspendisse id velit vitae ligula volutpat condimentum. Aliquam erat volutpat. Sed quis velit. Nulla facilisi. Nulla libero. Vivamus pharetra posuere sapien. Nam consectetuer. Sed aliquam, nunc eget euismod ullamcorper, lectus nunc ullamcorper orci, fermentum bibendum enim nibh eget ipsum. Donec porttitor ligula eu dolor. Maecenas vitae nulla consequat libero cursus venenatis. Nam magna enim, accumsan eu, blandit sed, blandit a, eros.</p>
					<p>Quisque facilisis erat a dui. Nam malesuada ornare dolor. Cras gravida, diam sit amet rhoncus ornare, erat elit consectetuer erat, id egestas pede nibh eget odio. Proin tincidunt, velit vel porta elementum, magna diam molestie sapien, non aliquet massa pede eu diam. Aliquam iaculis. Fusce et ipsum et nulla tristique facilisis. Donec eget sem sit amet ligula viverra gravida.</p>
				</div>
				<div id="preview-butterfly-person-state">
					- <span>Anonymous</span><label>, MI</label>
				</div>
			</div>
		</div>
		<div class="bottom"></div>
	</div> 	<!-- Preview pop up window end -->

<?php include 'footer.php'?>