<?php addStyle("modules/admin/news/style.css"); ?>
<div class="heading">
	<h1>News/Press Releases Admin</h1>
</div>
<div class="content">
	<form method="post" action="/admin/news" class="articlesForm">
		<div>
			<select name="newsArticles" size="10" class="newsArticlesList">
				<?php 
					getNewsTitleOptions();
				?>
			</select>
			<p>
				<input type="button" value="Edit Article" class="editArticleBtn" />
				<input type="button" value="Delete Article" class="deleteArticleBtn"/>
			</p>
		</div>
	</form>
	<hr/>
	<form method="post" action="/admin/news" class="articleForm">
		<input type="hidden" name="news[id]" id="news[id]"/>
		<p>
			<input type="button" value="New Article" class="newArticleBtn" />
		</p>
		<p class="newsTitle">
			<label for="news[title]">Title</label>
			<input type="text" name="news[title]" id="news[title]" />
		</p>
		<p class="newsCategory">
			<label for="news[category]">Category</label>
			<select name="news[category]" id="news[category]">
				<?php 
					getCategoryOptions();
				?>
			</select>
		</p>
		<p class="newsBody">
			<label for="news[body]">Body</label>
			<?php 
				tinyMCEBox("news[body]");
			?>
			<p><a href="javascript:void 0;" class="photoInserter">Insert News Photo</a></p>
		</p>
		<p class="newsStartTime">
			<label for="news[startTime]">Start Date/Time</label>
			<input type="text" name="news[startTime]" id="news[startTime]" class="datetimepicker"/>
		</p>
		<p class="">
			<label for="news[leavePosted]">Leave Posted</label>
			<input type="checkbox" name="news[leavePosted]" id="news[leavePosted]" checked="checked" class="leavePosted" />
		</p>
		<p class="newsEndTime">
			<label for="news[endTime]">End Date/Time</label>
			<input type="text" name="news[endTime]" id="news[endTime]" class="datetimepicker"/>
		</p>
		<p class="newsActive">
			<label for="news[active]">Active</label>
			<input type="checkbox" name="news[active]" id="news[active]" checked="checked"/>
		</p>
		<p>
			<input type="button" value="Add Article" class="submitBtn"/>
		</p>
	</form>
	<div class="photoHandler">
		<div class="newPhoto">
			<form id="photoUpload" action='/modules/admin/news/photoUpload.php' method='post' enctype='multipart/form-data'>
				<h3>Upload a new Photo</h3>
				<p>
					<label for='file'>Photo:</label>
					<input type='file' name='file' id='file' />
				</p>
				<p>
					<input type='submit' value='Upload and Insert Photo' />
				</p>
			</form>
		</div>
		<hr/>
		<div class="oldPhoto">
			<h3>Use an old photo</h3>
			<p>
				<select name="newsImages" size="10" class="newsImages">
					<?php 
						getNewsImages();
					?>
				</select>
			</p>
			<p>
				<span style="float:left"><input type="button" value="Insert Photo" class="insertPhotoBtn"></span>
				<span class="small" style="float:right"><a href="javascript:$('.photoHandler').slideUp();void 0;">[close]</a></span>
			</p>
		</div>
		<div class="clearFix"></div>
	</div>
</div>
<?php 
	addScript("modules/admin/news/script.js"); 
	addScript("scripts/jquery.form.js"); 
?>
<?php
	function getCategoryOptions(){
		global $connect;		
		$findCategories = "SELECT * FROM newscategories";
		$getCategories = @mysqli_query($connect, $findCategories) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getCategories)){
			extract($row);
			print "<option value=\"$newscategoriesid\">$categoryname</option>";
		}
	}
	function getNewsTitleOptions(){
		global $connect;		
		$findCategories = "SELECT newsitemsid, title FROM newsitems ORDER BY starttime DESC";
		$getCategories = @mysqli_query($connect, $findCategories) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getCategories)){
			extract($row);
			print "<option value=\"$newsitemsid\">$title</option>";
		}
	}
	function getNewsImages(){
		$images = array();	
		$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
		$path = $rootpath ."images/news/";
		if($handle = opendir($path)){
			/* This is the correct way to loop over the directory. */
			while (false !== ($image = readdir($handle))) {
				if($image!="."&&$image!=".."){
					$images[] = array(filemtime($path.$image),$image);
				}
			}
			rsort($images);
			$count = sizeof($images);	
			for ($i = 0; $i<$count; $i++) {
				print "<option value=\"/images/news/".$images[$i][1]."\">".$images[$i][1]."</option>";
			}
		}
	}
?>