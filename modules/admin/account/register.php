<?php addStyle('modules/admin/account/style.css'); ?>
<div class='heading'>
	<h1>Register.</h1>
</div>
<div class='content'>
	<?php if($user['securityLevel'] < 2){
echo "	<div id='signupForm'>
			<form method='post' action='/admin/account/create'>
				<fieldset>
					<table class='input-form'>
						<tr class='full-name'>
							<th>
								<label for='user_name'>Full name</label>
							</th>
							<td class='col-field'>
								<input type='text' tabindex='1' size='20' name='newuser[name]' maxlength='20' id='user_name' class='text_field' autocomplete='off' value='" . $newuser['name'] . "'>
							</td>
							<td class='col-help'>
								<div class='label-box info' style='display: none;'>
									Enter the persons first and last name
								</div>
								<div class='label-box good' style='display: none;'>
									Ok
								</div>";
								if(isset($errorMessage['name'])){
									echo "<div class='label-box error'>" . $errorMessage['name'] . "</div>";
								}
echo "						</td>
						</tr>
						<tr>
							<th></th>
							<td colspan='2'>
								<span class='field-desc'>
									
								</span>
							</td>
						</tr>
						<tr class='screen-name'>
							<th>
								<label for='user_screen_name'>Username</label>
							</th>
							<td class='col-field'>
								<input type='text' tabindex='2' size='15' name='newuser[username]' maxlength='15' id='user_screen_name' class='text_field' autocomplete='off' value='" . $newuser['username'] . "'>
							</td>
							<td class='col-help'>
								<div class='label-box info' style='display: none;'>
									<span id='screen_name_info'>Pick a unique username</span>
									<span style='display: none;' id='avail_screenname_check_indicator'>
										<img src='https://s3.amazonaws.com/twitter_production/a/1284676327/images/indicator_arrows_circle.gif' alt='Indicator_arrows_circle'>
										Checking availability...
									</span>
								</div>
								<div class='label-box good' style='display: none;'>
									Ok
								</div>";
								if(isset($errorMessage['username'])){
									echo "<div class='label-box error'>" . $errorMessage['username'] . "</div>";
								}
echo "						</td>
						</tr>
						<tr>
							<th></th>
							<td colspan='2'>
								<span class='field-desc'>
									
								</span>
							</td>
						</tr>
						<tr class='email'>
							<th>
								<label for='user_email'>Email</label>
							</th>
							<td class='col-field'>
								<input type='text' tabindex='4' size='30' name='newuser[email]' id='user_email' class='text_field' autocomplete='off'  value='" . $newuser['email'] . "'>
							</td>
							<td class='col-help'>
								<div class='label-box info' style='display: none;'>
									<span id='email_info'>We'll email a temp password</span>
									<span style='display: none;' id='avail_email_check_indicator'>
										Checking availability...
									</span>
								</div>
								<div class='label-box good' style='display: none;'>
									Ok
								</div>
								<div class='label-box error' ";
								if(isset($errorMessage['email'])){
									echo "style='display:block'";
								}
								echo ">";
								if(isset($errorMessage['email'])){
									echo $errorMessage['email']; 
								}
echo "							</div>
							</td>
						</tr>
						<tr>
							<th></th>
							<td colspan='2'>
								<span class='field-desc'>
									
								</span>
							</td>
						</tr>
						<tr class='securityLevel'>
							<th>
								<label for='user_email'>Security Level</label>
							</th>
							<td class='col-field'>
								<select name='newuser[security]' id='security' class='select_field'>
									" . securityOptions() . "
								</select>
							</td>
							<td class='col-help'>";
								if(isset($errorMessage['security'])){
									echo "<div class='label-box error'>" . $errorMessage['security'] . "</div>";
								}
echo "						</td>
						</tr>
						<tr>
							<th></th>
							<td colspan='2'>
								<input type='submit' tabindex='7' id='user_create_submit' class='btn btn-m' alt='Create Users Account.' value='Create Users Account' />
							</td>
						</tr>
					</table>
				</fieldset>
			</form>
		</div>
	</div>";
	include('vendors/passwordStrength/index.php'); 
	addScript('modules/admin/account/script.js'); 


	}else{
		echo "<div>You do not have access to create users.</div></div>";
	}
	
	function securityOptions(){
		global $connect;
		global $user;
		$returnInfo = "";
		if($user['securityLevel'] == 0){
			$findLevels = "SELECT * FROM securitylevels WHERE id >= '" . $user[securityLevel] . "' ORDER BY id ASC";
		}else{
			$findLevels = "SELECT * FROM securitylevels WHERE id > '" . $user[securityLevel] . "' ORDER BY id ASC";
		}
		$getLevels = @mysqli_query($connect, $findLevels) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getLevels)){
			extract($row);
			$returnInfo .= "<option value='$id'>$name</option>";
		}
		return $returnInfo;
	}
?>