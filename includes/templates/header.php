<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
            "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>PHP SMURF<?php echo ($page->title!="") ? " | ".$page->title : "" ; ?></title>
		<?php
			Common::AddStyle('styles/reset.css');
			Common::AddStyle('styles/jquery-ui.custom.css');
			Common::AddStyle('styles/smurf.css');
		?>
		<?php 
			Common::AddBaseScript("scripts/jquery.js");
			Common::AddBaseScript("scripts/jquery-ui.js");
			Common::AddBaseScript("scripts/jquery.watermark.js");
			Common::AddBaseScript("scripts/smurf.js");
		?>
	</head>
	<body>
		<div class="wrapper">
			