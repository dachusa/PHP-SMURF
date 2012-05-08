<div class="heading">
	<h1>Admin Panel</h1>
</div>
<div class="content">
	<ul class="adminPanel">
	<?php
		if($user[securityLevel] <= 1){
			echo "<li><a href='/admin/account'>Manage Users</a></li>";
		}
		$findAllowedPages = "SELECT * FROM adminswitchboard WHERE showOnAdminPanel = 1 AND adminSecurity >= $user[securityLevel] AND adminSecurity <= 3 ORDER BY adminPageName ASC";
		$getAllowedPages = @mysqli_query($connect, $findAllowedPages) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getAllowedPages)){
			extract($row);
			echo "<li><a href='/admin/$adminShortURL'>$adminPageName</a></li>";
		}	
	?>
	</ul>
</div>
