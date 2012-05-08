<h2>Event Details</h2>
<?php
	$eventID = $url[1];
	//feed url
	$feedBaseSecure  = "";
	$eventURL = $feedBaseSecure ."full/". $eventID."?singleevents=true";
	$xmlFeed = simplexml_load_file($eventURL); 

	if(count($xmlFeed)>1){
		$event["title"] = $xmlFeed["title"];
		$event["description"] = $xmlFeed["content"];
	$event = $xmlFeed[0]->children('http://schemas.google.com/g/2005');
	print_r($event)l
	exit;
		
		
		foreach ($xmlFeed->entry as $item) {			
			$event = $item->children('http://schemas.google.com/g/2005');
			if ($event->eventStatus->attributes()->value == $confirmed) {
				$eventID = $item->id;
				$eventID = str_replace($feedBase,"",$eventID);
				$eventID = str_replace("full/","",$eventID);
				
				$shortTitle = $item->title;
				$shortentedLength = 20;
				
				if(strlen($shortTitle) > $shortentedLength){
					$shortTitle = substr($shortTitle, 0, $shortentedLength-3) . "...";
				}
				
				$startTime = '';
				$endTime = '';
				if ( $event->when ) {
					$startTime = $event->when->attributes()->startTime;
					$endTime = $event->when->attributes()->endTime;
				} elseif ( $event->recurrence ) {
					$startTime = $event->recurrence->when->attributes()->startTime; 
					$endTime = $event->recurrence->when->attributes()->endTime; 
				} 
				
				$dateToDisplay = date("m/d/Y", strtotime($startTime));
				
				$dateTimeToDisplay["start"] = date("m/d/Y h:i A", strtotime($startTime));
						
				if($endTime != ''){
					$dateTimeToDisplay["end"] =  date("m/d/Y h:i A", strtotime($endTime));
				}
				// Google Calendar API's support of timezones is buggy
				$dateTimeToDisplay["timezone"] = " MT";
				
				$location = $event->where->attributes()->valueString;
				
				$description = $item->content;
				
				?>
				<div class="event">
					<div class="eventAbrevTitle"><a href="/events/<?php print $eventID; ?>"><?php print $shortTitle; ?></a></div>
					<div class="eventDate"><?php print $dateToDisplay; ?></div>
					<div class="eventDetails">
						<div class="eventTitle"><?php print $item->title; ?></div>
						<div class="eventDateTime">
							<?php
								if(isset($dateTimeToDisplay["end"])){
							?>
								<ul>
									<li>
										<span class="heading">Start:</span>
							<?php
								}
							
								print $dateTimeToDisplay["start"];
								if(isset($dateTimeToDisplay["end"])){
							?>
									</li>
									<li>
										<span class="heading">End:</span>
							<?php
									print $dateTimeToDisplay["end"];	
								}
								print $dateTimeToDisplay["timezone"];
								if(isset($dateTimeToDisplay["end"])){
								?>
									</li>
								</ul>
								<?php
								}
							?>
						</div>
						<?php if(isset($location)&&$location!=""){?>
						<div class="eventLocation">
							<span class="heading">Location:</span>
							<?php print $location;?>
						</div>
						<?}?>
						<?php if(isset($description)&&$description!=""){?>
						<div class="eventDescription">
							<span class="heading">Description:</span>
							<?php print $description; ?>
						</div>
						<?}?>
						<div class="clearFix"></div>
					</div>
					<div class="clearFix"></div>
				</div>
		<?php
			}
		} 
	}else{
?>
	Event not found.
<?php
	}
?>