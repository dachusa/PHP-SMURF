<?php 
	if(!isset($_GET["print"])){
		Common::AddStyle('modules/slideshow/style.css');
	?>
		<div id='slideShow'>
		<?php
			$imgDir = "/modules/slideshow/images";
			$rowNum = 0;
			$selectSlides = "SELECT * FROM slideshow ORDER BY slideshow.order";			
			$slides = DB::Query($selectSlides);
			if(sizeOf($slides) > 0){?>
				<div class="slides">
					<ul>
						<?php
						foreach($slides as $slide){
							extract($slide);
							$rowNum++;
							echo "<li class='slide' id='slide$rowNum' rel='$rowNum'><a href='$link'><img src='$imgDir/$imageName' alt='$imageName'></a></li>";
						}
						?>
					</ul>
				</div>
				<div id='slideNav'>
					<ul>
						<?php
						for($i = 1; $i <= $rowNum; $i++){
							echo "<li class='slideLink'><a href='#' rel='slide$i'>$i</a></li>";
						}
						?>
					</ul>
				</div>
				<?php
			}
		?>
		</div>
		<div class='clearFix'></div>
		<?php	
		Common::AddScript('modules/slideshow/script.js');
	}
?>