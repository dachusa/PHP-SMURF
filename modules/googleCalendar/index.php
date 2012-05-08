<?php
	addStyle('modules/googleCalendar/style.css');
	
	if(isset($url[1])){
		include('modules/googleCalendar/eventDetail.php');
	}else{
		include('modules/googleCalendar/smallCalendar.php');
	}
	addScript('modules/googleCalendar/script.js'); 
?>