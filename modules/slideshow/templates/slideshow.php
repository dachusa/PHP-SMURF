<div id='slideShow'>
<?php
	if($slideshow!=null && sizeOf($slideshow->slides) > 0){?>
		<style type="text/css">
			#slideShow, .slides{
				width:<?php echo $slideshow->width;?>px;
				height:<?php echo $slideshow->height;?>px;
		</style>
		<div class="slides">
			<ul>
				<?php
					$rowNum = 1;
					foreach($slideshow->slides as $slide){
						echo "<li class='slide' id='slide$rowNum' rel='$rowNum'><a href='$slide->link'><img src='$imgDir/$slide->imageName' alt='$slide->imageName'></a></li>";
						$rowNum++;
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
		<script type="text/javascript">
			var slideShowTimeoutInSeconds = <?php echo $slideshow->seconds; ?>; 
		</script>
		<?php
	}
?>
</div>
<div class='clearFix'></div>