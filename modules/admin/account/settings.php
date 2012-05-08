<?php addStyle('modules/admin/account/style.css'); ?>
<?php
	if(isset($_POST['edituser']) || is_array($_POST['edituser'])){
		include("modules/admin/account/updateUser.php");
	}
	$editOther=false;
	if(isset($url[3])&&$url[3]!="" && $user["securityLevel"]<2){
		$findUser = "SELECT userID, name, username, email, securityLevel FROM users WHERE userID= $url[3] AND securityLevel >= $user[securityLevel] AND  sGUID <> '$_SESSION[session_id]'";
		$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
		if($row = mysqli_fetch_array($getUser)) {
			$edituser=$row;
			$editOther=true;
		}
	}
	if(!$editOther){
		$findUser = "SELECT name, username, email FROM users WHERE sGUID = '$_SESSION[session_id]'";
		$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
		if($row = mysqli_fetch_array($getUser)) {
			$edituser=$row;
		}
	}
?>
<div class="heading">
	<h1><?php print ($editOther) ? "$edituser[name]'s" : "My";?> Account.</h1>
</div>
<div class="content">
	<div id="signupForm">
		<form method="post" action="/admin/account/settings<?php print ($editOther) ? "/$edituser[userID]" : "";?>">
			<fieldset>
				<?php print ($editOther) ? "<input type=\"hidden\" value=\"$edituser[userID]\" name=\"edituser[id]\"" : "";?>
				<table class="input-form">
					<tr class="full-name">
						<th>
							<label for="user_name">Full name</label>
						</th>
						<td class="col-field">
							<input type="text" tabindex="1" size="20" name="edituser[name]" maxlength="20" id="user_name" class="text_field" autocomplete="off" value="<?php print $edituser["name"];?>">
						</td>
						<td class="col-help">
							<div class="label-box info" style="display: none;">
								Enter the persons first and last name
							</div>
							<div class="label-box good" style="display: none;">
								Ok
							</div>
							<div class="label-box error" <?php if(isset($errorMessage["name"])){?> style="display:block" <?php } ?>>
								<?php if(isset($errorMessage["name"])){?>
									<?php print $errorMessage["name"]; ?>
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<th></th>
						<td colspan="2">
							<span class="field-desc">
								
							</span>
						</td>
					</tr>
					<tr class="screen-name">
						<th>
							<label for="user_screen_name">Username</label>
						</th>
						<td class="col-field">
							<input type="text" tabindex="2" size="15" name="edituser[username]" maxlength="15" id="user_screen_name" class="text_field" autocomplete="off" value="<?php print $edituser["username"];?>">
						</td>
						<td class="col-help">
							<div class="label-box info" style="display: none;">
								<span id="screen_name_info">Pick a unique username</span>
								<span style="display: none;" id="avail_screenname_check_indicator">
									<img src="https://s3.amazonaws.com/twitter_production/a/1284676327/images/indicator_arrows_circle.gif" alt="Indicator_arrows_circle">
									Checking availability...
								</span>
							</div>
							<div class="label-box good" style="display: none;">
								Ok
							</div>
							<div class="label-box error" <?php if(isset($errorMessage["username"])){?> style="display:block" <?php } ?>>
								<?php if(isset($errorMessage["username"])){?>
									<?php print $errorMessage["username"]; ?>
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<th></th>
						<td colspan="2">
							<span class="field-desc">
								
							</span>
						</td>
					</tr>
					<?php if(!$editOther){ ?>
					<tr class="password">
						<th>
							<label for="user_password">Password</label>
						</th>
						<td class="col-field">
							<input type="password" tabindex="3" size="30" name="edituser[password]" id="user_password" class="text_field" autocomplete="off">
						</td>
						<td class="col-help">
							<div class="label-box password-meter" style="display: none;">
								<span class="pstrength-text">Too short</span>
							</div>
							<div class="label-box error" <?php if(isset($errorMessage["password"])){?> style="display:block" <?php } ?>>
								<?php if(isset($errorMessage["password"])){?>
									<?php print $errorMessage["password"]; ?>
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<label for="user_passwordConfirm">Password Confirm</label>
						</th>
						<td class="col-field">
							<input type="password" tabindex="3" size="30" name="edituser[passwordConfirm]" id="user_passwordConfirm" class="text_field" autocomplete="off">
						</td>
						<td class="col-help">
							<div class="label-box password-confirm" style="display: none;">
								<span class="pconfirm-text">Passwords do not match</span>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<span class="field-desc">
								Password must be at least 8 characters long and must not be the same as your username.
							</span>
						</td>
					</tr>
					<?php }else{ ?>
					<tr>
						<th>
							<label for="user_passwordReset">Reset Password</label>
						</th>
						<td class="col-field">
							<input type="submit" name ="edituser[reset]" id="user_passwordReset" class="btn btn-m" alt="Reset Password" value="Reset Password" />
						</td>
						<td class="col-help">
							<div class="label-box password-confirm" style="display: none;">
								<span class="pconfirm-text">Passwords do not match</span>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<span class="field-desc">
								A temporary password will be emailed to the user.
							</span>
						</td>
					</tr>
					<?php } ?>
					<tr class="email">
						<th>
							<label for="user_email">Email</label>
						</th>
						<td class="col-field">
							<input type="text" tabindex="4" size="30" name="edituser[email]" id="user_email" class="text_field" autocomplete="off"  value="<?php print $edituser["email"];?>">
						</td>
						<td class="col-help">
							<div class="label-box info" style="display: none;">
								<span id="email_info">Make sure its valid</span>
								<span style="display: none;" id="avail_email_check_indicator">
									Checking availability...
								</span>
							</div>
							<div class="label-box good" style="display: none;">
								Ok
							</div>
							<div class="label-box error" <?php if(isset($errorMessage["email"])){?> style="display:block" <?php } ?>>
								<?php if(isset($errorMessage["email"])){?>
									<?php print $errorMessage["email"]; ?>
								<?php }?>
							</div>
						</td>
					</tr>
					<?php if($editOther){ ?>
					<tr class="securityLevel">
						<th>
							<label for="user_email">Security Level</label>
						</th>
						<td class="col-field">
							<select name="edituser[security]" id="security" class="select_field">
								<?php securityOptions($edituser[securityLevel]);?>
							</select>
						</td>
						<td class="col-help">
							<?php if(isset($errorMessage["security"])){?>
								<div class="label-box error"><?php print $errorMessage["security"]; ?></div>
							<?php }?>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th></th>
						<td colspan="2">
							<span class="field-desc">
								
							</span>
						</td>
					</tr>
					<tr>
						<th></th>
						<td colspan="2">
							<?php if($editOther){ ?>
							<input type="submit" name ="edituser[delete]"  tabindex="7" id="user_delete_submit" class="btn btn-m" alt="Delete Account." value="Delete Account"/>
							<?php }	?>
							<input type="submit" name ="edituser[update]" tabindex="7" id="user_update_submit" class="btn btn-m" alt="Update Account." value="Update Account" />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
</div>
<?php include('vendors/passwordStrength/index.php'); ?>
<?php addScript('modules/admin/account/script.js'); ?>
<?php
	function securityOptions($securityLevel){
		global $connect;
		$findLevels = "SELECT * FROM securitylevels WHERE id >= $securityLevel ORDER BY id ASC";
		$getLevels = @mysqli_query($connect, $findLevels) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getLevels)){
			extract($row);
			print "<option value=\"$id\"";
			if($id==$securityLevel){
				print " selected=\"selected\"";
			}
			print ">$name</option>";
		}
	}
?>