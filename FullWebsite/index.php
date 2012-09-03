<?php include 'header.php'?>
	<script type="text/javascript">	
		var summerydiv = '';
		var fullview_div = '';
		var apiurl = "<?php echo APIURL?>/";
	</script>
	<h1>Transform
		<span class="heading-butterfly-blue"></span>
	</h1>
	
	<div class="wallintro-wrapper">
		<p>Living Beyond Breast Cancer is about how we find treatment. It's about transforming the experience of diagnosis into one of finding support, expertise, community...and learning from those who have faced cancer themselves, and flown beyond it. We invite you to help the transformation continue by giving flight to a message of inspiration, thanks, and love.</p>		
		<a href="submit-story.php" class="btndark-black goleft" >Create Your Message &gt;</a>
		<a href="javascript:void(0)" class="btndark-black goright" >How To Donate &gt;</a>
	</div>
	
	<div class="living-message-wrapper">
		<h3>Living Beyond Breast Cancer</h3>
		<p>Is a national, non-profit organization dedicated to empowering all women affected by breast cancer to live as long as possible with the best quality of life. To learn more about Living Beyond Breast Cancer</p>
		<a href="http://www.lbbc.org" target="_blank" >Visit www.lbbc.org</a>
	</div>
	<div class="sep"></div>
	
	<?php 
		$stories = file_get_contents(APIURL.'?action=get_stories');
		$stories_C = json_decode($stories,1);
	?>

	<?php if(isset($stories_C['total_records']) && ($stories_C['total_records'] > 0)) : ?>
		<div class="wall-content-wrapper" id="dv-wall-post">
		
			<div class="wall-sortby-wrapper">
				<label>Sort By:</label>
				<select id="sort_option" onchange="loadWallMessage(1);">
					<option value="-1">Newest-Oldest</option>
					<option value="1">Oldest-Newest</option>
				</select>
			</div>
			
			<div class="wall-search-wrapper">
				<form id="search_form" name="search_form">
					<span class="error">Sorry. "Name" was not found</span>
					<input type="text" value="Name Search" class="error" id="search_string"/>
					<button class="btndark-black btngo" type="button" onclick="searchWallMessage();">GO</button>
				</form>
			</div>
			
			<div class="wall-post-wrapper">
				<?php #echo $stories_C['total_records'];?>
				<?php #foreach($stories_C['data'] as $s) : ?><?php #print_r($s);?><?php #endforeach?>
				<input type="hidden" value="<?php echo $stories_C['total_records'];?>" name="total_records" id="total_records">
				<div id="wallcol1"></div>
				<div id="wallcol2"></div>
				<div id="wallcol3"></div>
			</div><!-- wall-post-wrapper -->
			
		</div><!-- dv-wall-post ends -->
		<div ='end_loader'></div>
	<?php else : ?>
		<div id="wall-first-post-wrapper">
			<span>Be the first to share a message!</span>
			<a href="submit-story.php" class="btndark-black" >Create Your Message &gt;</a>
		</div>
	<?php endif?>

<?php include 'footer.php'?>


<script type="text/javascript">
	//var total_records = '<?php echo (isset($stories_C['total_records']) && ($stories_C['total_records'] > 0)) ? $stories_C['total_records'] : 0;?>';
	$(window).scroll(function() {
		var total_records = $("#total_records").val();
		var scroll_top = $(window).scrollTop();
		var doc_height = $(document).height();
		var win_height = $(window).height();
		scroll_top = scroll_top - 1 + 2;
		//alert('STOP : ' + scroll_top + ' = ' + (doc_height - win_height) + ' :: Dheight : '+ doc_height + ' - ' + win_height + ' :');
		if(scroll_top >= doc_height - win_height) {
			var st_limit = parseInt(readCookie('c_limit'));
			var ed_limit = parseInt(st_limit) + 3;
			if(ed_limit > total_records) {
				ed_limit = total_records;
			}

			for(var i = parseInt(st_limit); i < parseInt(ed_limit); i++) {
				var div_ch 		= (i%3);
				var div_html 	= '<div class="wallpost" id="item-'+i+'"><div class="loader"></div></div>';
				switch(div_ch) {
					case 0 :
						$("#wallcol1").append(div_html);
						break;
					case 1 :
						$("#wallcol2").append(div_html);
						break;
					case 2 :
						$("#wallcol3").append(div_html);
						break;
				}
			}
			createCookie('c_limit',ed_limit);
			
			var loop_st_limit = parseInt(readCookie('loop_limit'));
			var loop_ed_limit = parseInt(loop_st_limit) + 3;
			if(loop_ed_limit > total_records) {
				loop_ed_limit = total_records;
			}
			loadContent (loop_st_limit,loop_ed_limit,3);
		}
	});
	
	//load message on document ready	
	$(document).ready(function(){
		loadWallMessage(0);
	});
</script>