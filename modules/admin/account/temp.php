<?php addStyle('modules/admin/account/style.css'); ?>
<?php
	if(isset($_POST['user']) || is_array($_POST['user'])){
		include("modules/admin/account/updateTemp.php");
	}
?>
<div class="heading">
	<h1>Change your temporary password.</h1>
</div>
<div class="content">
	<div id="signupForm" class="tempForm">
		<form method="post" action="/admin/account/temp">
			<input type="hidden" value="<?php getUserName(); ?>" id="user_screen_name" name="user[username]" />
			<fieldset>
				<table class="input-form">
					<tr class="password">
						<th>
							<label for="user_password">Password</label>
						</th>
						<td class="col-field">
							<input type="password" tabindex="3" size="30" name="user[password]" id="user_password" class="text_field" autocomplete="off">
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
							<input type="password" tabindex="3" size="30" name="user[passwordConfirm]" id="user_passwordConfirm" class="text_field" autocomplete="off">
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
					<tr>
						<th></th>
						<td colspan="2">
							<input type="submit" disabled="disabled" tabindex="7" id="password_change_submit" class="btn btn-m" alt="Change Password" value="Change Password" />
						</td>
					</tr>
				</table>
				<div class="clearFix"></div>
				<p class="error">
					<?php print $errorMessage; ?>
				</p>
			</fieldset>
		</form>
	</div>
</div>
<?php include('vendors/passwordStrength/index.php'); ?>
<?php addScript('modules/admin/account/script.js'); ?>
<?php 
	function getUserName(){
		print $_SESSION[user][username];
	}
?>