<?php
	function tinyMCEBox($name){
		?>		
		<div>
			<textarea id="<?php print $name;?>" name="<?php print $name;?>" rows="15" cols="80" style="width: 80%" class="tinymce">
			</textarea>
		</div>
		<?php
		require_once('vendors/tinyMCE/initialize.php');
	}
?>