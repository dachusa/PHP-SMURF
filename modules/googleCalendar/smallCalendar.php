<div id="allCadCalendar">
	<div class="calendarHead">
		<div class="calendarTitle">Upcoming Events</div>
		<div class="miniNote" title="Hover over events to see more details">(hover)</div>
		<div class="clearFix"></div>
	</div>
	<ul class="events">
	<?php 
		$confirmed = 'http://schemas.google.com/g/2005#event.confirmed';
		
		$currentDateTime = date("Y-m-d\Th:i:sP", time());
		$threeMonthsInSeconds = 60 * 60 * 24 * 28 * 3;
		$threeMonthsFromToday = date("Y-m-d\Th:i:sP", time() + $threeMonthsInSeconds);

		//Feed URLS
		$feedBase  = "";
		$feedBaseSecure  = "";
		
		
		$feed = $feedBaseSecure 
			. "full?orderby=starttime&sortorder=ascending&singleevents=true&"
			. "start-min=" . $currentDateTime . "&"
			. "start-max=" . $threeMonthsFromToday;
			
		$xmlFeed = simplexml_load_file($feed); 

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
				<li class="event">
					<!--<div class="eventAbrevTitle"><a href="/events/<?php print $eventID; ?>"><?php print $shortTitle; ?></a></div>-->
					<div class="eventAbrevTitle"><?php print $shortTitle; ?></div>
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
				</li>
		<?php
			}
		} 
	?>
	</ul>
	<div class="note">
		Please <a href="/contactus">contact us</a> if you have any questions about our upcoming events.
	</div>
</div>