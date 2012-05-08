<?php 
	if(isset($_POST["login"])){
		include("modules/admin/account/verify.php");
	}
?>
<?php addStyle('modules/admin/account/style.css'); ?>
<div class="heading">
	<h1>Login.</h1>
</div>
<div class="content">
	<fieldset id="loginBox">
		<form action="" method="post">
			<?php if(isset($_COOKIE['source'])){?>
			<input type="hidden" name="login[source]" value="<?=$_COOKIE['source']?>"/>
			<?php }?>
			<p>
				<label for="username">Username</label>
				<input type="text" name="login[username]" id="username" title="Username" tabindex="1"/>
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="login[password]" id="password" title="Password" tabindex="2"/>
			</p>
			<p>
				<input type="submit" name="submit" value="Sign In" tabindex="3" title="Sign In"/>
			</p>
			<div class="clearFix"></div>
			<p class="error">
				<?php print $errorMessage; ?>
			</p>
			<?php
				/*
				<p>
					<a href="/forgotPassword">Forgot your password?</a>
				</p>
				<p>
					<a href="/forgotUsername">Forgot your username?</a>
				</p>
				*/
			?>
		</form>
	</fieldset>
</div>