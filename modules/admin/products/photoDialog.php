<div class="photoHandler">
	<div class="closeUpload"><a href="#">[close]</a></div>
	<div class="newPhoto">
		<form id="photoUpload" action='/modules/admin/products/photoUpload.php' method='post' enctype='multipart/form-data'>
			<h3>Upload a new Photo</h3>
			<p>
				<label for='file'>Photo:</label>
				<input type='file' name='file' id='file' />
			</p>
			<p>
				<input type='submit' value='Upload Photo' />
			</p>
		</form>
	</div>
</div>