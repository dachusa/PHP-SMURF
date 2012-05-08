<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
            "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>IDMT<?php print ($title!="") ? " | $title" : "" ; ?></title>
		<?php
			common::addStyle('styles/reset.css');
			common::addStyle('styles/jquery-ui.custom.css');
			common::addStyle('styles/idmt.css');
		?>
		<?php 
			common::addBaseScript("scripts/jquery.js");
			common::addBaseScript("scripts/jquery-ui.js");
			common::addBaseScript("scripts/jquery.watermark.js");
			common::addBaseScript("scripts/idmt.js");
		?>
	</head>
	<body>
		<div class="wrapper">
			<div class="masthead">
				<img src="/images/bsuLogo.png" alt="Boise State University" />
				<div class="search">
					<input type="text" name="search" />
					<input type="button" name="searchBtn" value="Search" />
				</div>
			</div>
			<div class="header">
				<div class="logo">
				</div>
				<div class="login">
					<form action="/login" method="post">
						<input type="text" name="user[username]" value="username" />
						<input type="text" name="user[password]" value="password" />
						<input type="submit" name="loginSubmitBtn" value="login" />
					</form>
				</div>
			</div>
			<div class="menu">
				<ul class="nav">
					<?php 
						common::printListItemLink('Home', '/');
						common::printListItemLink('Newsletters', '/');
						common::printListItemLink('Follow-up Opportunity', '/');
						common::printListItemLink('Parents/Community', '/');
						common::printListItemLink('FAQ', '/');
						common::printListItemLink('About Us', '/'); 
					?>
				</ul>
			</div>
			<div class="page">