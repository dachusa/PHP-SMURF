<?php
	class Module{
		function initModule($pathToModule){
			//Include Module Style
			if(file_exists($pathToModule."style.css")){
				Common::AddStyle($pathToModule."style.css");
			}

			//Include Module Script
			if(file_exists($pathToModule."script.js")){
				Common::AddScript($pathToModule."script.js");
			}
		}
	}
?>