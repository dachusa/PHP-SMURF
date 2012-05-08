<?php addStyle('modules/admin/account/style.css'); ?>
<div class="heading">
	<h1>Users</h1>
</div>
<div class="content">
	<?php if($user['securityLevel'] < 2){
	echo "<table class='usersTable'>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Security Level</th>
				<th>Temp Password</th>
				<th>Last Login</th>
				<th></th>
			</tr>";
		$securityLevels=array();
		$findLevels = "SELECT * FROM securitylevels ORDER BY id ASC";
		$getLevels = @mysqli_query($connect, $findLevels) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getLevels)){
			extract($row);
			$securityLevels[]=$name;
		}
	
		$findUsers = "SELECT * FROM users WHERE securityLevel >= '" .$user["securityLevel"] ."'";
		$getUsers = @mysqli_query($connect, $findUsers) or die('query error: ' . mysqli_error($connect));
		$count=1;
		while($row = mysqli_fetch_array($getUsers)){
			extract($row);
			$class = ($count%2) ? "odd" : "even";
			print "<tr  class='$class'>";
				print "<td class=\"name\">$name</td>";
				print "<td class=\"username\">$username</td>";
				print "<td class=\"email\">$email</td>";
				print "<td class=\"securityLevel\">$securityLevels[$securityLevel]</td>";
				print "<td class=\"temp\">";
					print ($temp == 1) ? "Yes" : "No";
				print "</td>";
				$formattedDate = date("m/d/Y h:i a", strtotime($lastLogin));
				$formattedDate = ($formattedDate == "11/30/1999 12:00 am") ? "-" : $formattedDate;
				print "<td class=\"lastLogin\">$formattedDate</td>";
				print "<td class=\"edit\"><a href=\"/admin/account/settings/$userID\">Edit</a></td>";
			print "</tr>";
			$count++;
		}
	echo "</table>";
	}else{
		echo "<div>You do not have access to modify users.</div>";
	}
	?>
</div> 