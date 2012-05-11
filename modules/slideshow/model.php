<?php
	class SlideObject{
		public $id;
		public $slideshowID;
		public $imageName;
		public $link;
		public $rank;
		
		public function __construct($slideID, $slideshowID, $imageName, $link, $rank)  
		{  
			$this->id = $slideID;
			$this->slideshowID = $slideshowID;
			$this->imageName = $imageName;
			$this->link = $link;
			$this->rank = $rank;
		}  
	}
	
	class SlideShowObject{
		public $id;
		public $title;
		public $width;
		public $height;
		public $seconds;
		public $slides;
		
		public function __construct($slideshowID, $title, $width, $height, $seconds, $slides)  
		{  
			$this->id = $slideshowID;
			$this->title = $title;
			$this->width = $width;
			$this->height = $height;
			$this->seconds = $seconds;
			$this->slides = $slides;
		}  
	}
	
	class SlideShow{
	
		function GetSlideShowByID($id){
			$sqlCommand = 
				"SELECT slideshowID, title, width, height, seconds FROM slideshows WHERE slideshowID = :slideshowID";
			$sqlParameters = Array(":slideshowID"=>$id);
			$slideshows = DB::Query($sqlCommand, $sqlParameters);
					
			foreach($slideshows as $slideshow){
				$slideshow['slides'] = self::GetSlidesBySlideShowID($slideshow['slideshowID']);
				return self::ArrayToSlideShowObject($slideshow);
			}
			
			return null;
		}
		
		function GetSlidesBySlideShowID($id){
			$sqlCommand = 
				"SELECT slideID, slideshowID, imageName, link, rank FROM slides WHERE slideshowID = :slideshowID ORDER BY rank";
			$sqlParameters = Array(":slideshowID"=>$id);
			$slides = DB::Query($sqlCommand, $sqlParameters);
			
			$slidesObject = Array();
			foreach($slides as $slide){
				$slidesObject[] = self::ArrayToSlideObject($slide);
			}
			return $slidesObject;
		}
		
		private function ArrayToSlideObject($slideArray){			
			return new SlideObject(
				$slideArray['slideID'],
				$slideArray['slideshowID'],
				$slideArray['imageName'],
				$slideArray['link'],
				$slideArray['rank']
			);
		}
		private function ArrayToSlideShowObject($slideShowArray){			
			return new SlideShowObject(
				$slideShowArray['slideshowID'],
				$slideShowArray['title'],
				$slideShowArray['width'],
				$slideShowArray['height'],
				$slideShowArray['seconds'],
				$slideShowArray['slides']
			);
		}
	}
?>