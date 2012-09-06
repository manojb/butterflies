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
				<select id="sort_option" onchange="loadWallMessage(1,'sortsearch');">
					<option value="-1">Newest-Oldest</option>
					<option value="1">Oldest-Newest</option>
				</select>
			</div>
			
			<div class="wall-search-wrapper">
				<form id="search_form" name="search_form" action="javascript:void(0);">
					<span id="search_error_span"></span>
					<input type="text" value="Name Search" id="search_string" onblur="resetText(this,'Name Search');" onfocus="emptyText(this,'Name Search');"/>
					<button class="btndark-black btngo" type="button" onclick="searchWallMessage();">GO</button>
				</form>
			</div>
			
			<div class="wall-post-wrapper">
				<?php #echo $stories_C['total_records'];?>
				<?php #foreach($stories_C['data'] as $s) : ?><?php #print_r($s);?><?php #endforeach?>
				<input type="hidden" value="<?php echo $stories_C['total_records'];?>" name="total_records" id="total_records">
				<input type="hidden" value="" name="search_text_for_sort" id="search_text_for_sort">
				<div id="wallcol1"></div>
				<div id="wallcol2"></div>
				<div id="wallcol3"></div>
			</div><!-- wall-post-wrapper -->
			
		</div><!-- dv-wall-post ends -->
	<?php else : ?>
		<div id="wall-first-post-wrapper">
			<span>Be the first to share a message!</span>
			<a href="submit-story.php" class="btndark-black" >Create Your Message &gt;</a>
		</div>
	<?php endif?>

	<div id="overlay"></div>
	<?php if(isset($_GET['id']) && $_GET['id'] != '') : ?>
		<?php $_GET['id'] = rtrim($_GET['id'],"?");?>
		<?php include "unique-card.php";?>
	<?php endif?>
	
	<input type="hidden" id="story_id_to_share" value="<?php echo (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : ''?>">
	
	<?php include 'script.php'?> <!-- Include common scripts for all page -->
	
	<?php if(isset($_GET['id']) && $_GET['id'] != '') : ?>
		<script type="text/javascript">
			showUniquePopUp();
		</script>
	<?php endif?>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
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
			loadWallMessage(0,'nosearch');
		});
		
		twttr.events.bind('tweet', function(event) {
			var story_id_to_share = document.getElementById("story_id_to_share").value;
			var url = apiurl+"?action=track_share&field=twitter_share&story_id="+story_id_to_share;
			$.get(url,function(msg){
				//alert(msg);
			});
		});
	</script>
<?php include 'footer.php'?>