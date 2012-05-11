<style type="text/css">
	.homeContent{
		width:100%;
	}
	.homeContent .leftContent{
		float:left;
		width:600px;
	}
	.homeContent .rightContent{
		float:left;
		width:300px;
		padding:10px 10px 10px 20px;
	}
</style>
<div class="homeContent">
	<div class="leftContent">
	<?php
		SlideShow::DisplaySlideShow(1);
	?>
	</div>
	<div class="rightContent">
	<?php
		print $page->pageContent;
	?>
	</div>
	<div class="clear"></div>
</div>