<?php if(isset($url[2]) && $url[2]=="action"){
	include("modules/admin/training/action.php");
	exit;
}?>
<?php addStyle("modules/admin/training/style.css"); ?>
<?php addVendor('tinyMCE'); ?>
<div class="heading">
	<h1>Training Admin</h1>
</div>
<div class="content">
	<form method="post" action="/admin/training" class="trainingForm">
		<div>
			<select name="training" size="10" class="trainingList">
				<?php 
					getTraining();
				?>
			</select>
			<p>
				<input type="button" value="Edit Training" class="editTrainingBtn" />
				<input type="button" value="Delete Training" class="deleteTrainingBtn"/>
			</p>
		</div>
	</form>
	<hr/>
	<form method="post" action="/admin/training" class="trainingForm">
		<input type="hidden" name="training[id]" id="training[id]"/>
		<p>
			<input type="button" value="New Training" class="newTrainingBtn" />
		</p>
		<p class="trainingName">
			<label for="training[title]">Title</label>
			<input type="text" name="training[title]" id="training[title]" />
		</p>
		<p class="trainingBody">
			<label for="training[description]">Description</label>
			<?php 
				tinyMCEBox("training[description]");
			?>
		</p>
		<p class="trainingDuration">
			<label for="training[duration]">Duration</label>
			<input type="text" name="training[duration]" id="training[duration]" />
		</p>
		<p class="trainingActive">
			<label for="training[active]">Active</label>
			<input type="checkbox" name="training[active]" id="training[active]" checked="checked"/>
		</p>
		<p>
			<input type="button" value="Add Training" class="submitBtn"/>
		</p>
	</form>
</div>
<?php 
	addScript("modules/admin/training/script.js"); 
	addScript("scripts/jquery.form.js"); 
?>
<?php
	
	function getTraining(){
		global $connect;		
		$findTraining = "SELECT id, title FROM training ORDER BY title";
		$getTraining = @mysqli_query($connect, $findTraining) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getTraining)){
			extract($row);
			print "<option value=\"$id\">$title</option>";
		}
	}
?>