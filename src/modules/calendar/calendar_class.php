<?php
class myCalendar{

	private $now;
	private $event = array();
	public $title;
	public $date;
	
	/***************************/
	/* set date 	           */
	/***************************/
	public function setDate($value = null){
		
		if($value){
			$this->now = getdate(strtotime($value));
		}else{
			$this->now = getdate();
		}
		
	}
	
	/***************************/
	/* title    		       */
	/***************************/	
	public function title() {
		
		$value = array("Mån", "Tis", "Ons", "Tor", "Fre", "Lör", "Sön");
		
		//title
		foreach ($value as $output) {
			$this->title .= "<div class='col-calendar'><div class='wrap-col'>".$output."</div></div>";
		}

		return $this->title;

	}

	/***************************/
	/* event 	         	   */
	/***************************/	
	public function addEvent($html, $eventStart, $eventEnd = null){
		
		static $htmlCount = 0;
		
		$startDate = strtotime($eventStart);
		
		if($eventEnd) {
			$endDate = strtotime($eventEnd);
		}else{
			$endDate = $startDate;
		}
		
		do {
			$tDate = getdate($startDate);
			$startDate += 86400;
			
			$this->event[$tDate['year']][$tDate['mon']][$tDate['mday']][$htmlCount] = $html;
		} while($startDate < $endDate + "1");

		$htmlCount++;
	}

	/* clear events */
	public function clearEvent(){
		$this->event = array(); 
	}


	public function getEvent() {
		
			
		
	}
	
	/***************************/
	/* get Calendar  	       */
	/***************************/
	public function getDate(){
		
		$wday = date('N', mktime(0, 0, 0, $this->now['mon'], 1, $this->now['year'])) - date('N', strtotime("monday")) % 7;
		
		$no_days = cal_days_in_month(CAL_GREGORIAN, $this->now['mon'], $this->now['year']);
		
		$wday = ($wday + 7) % 7;

		if($wday == 7){
			$wday = 0;
		}else{
			$this->date .= str_repeat('<div class="col-calendar"><div class="wrap-col boxCalendarDisable">&nbsp;</div></div>', $wday);
		}

		//datum div
		$count = $wday + 1;
		
		for($i = 1; $i <= $no_days; $i++) {
			
			//dateToday
			if($i == $this->now['mday'] && $this->now['mon'] == date('n') && $this->now['year'] == date('Y')){
				$dateToday = "calendarDateToday";
			}else{
				$dateToday = "";
			}
			
			//date xxxx-xx-xx
			$dateTime = date('Y-m-d', mktime(0, 0, 0, $this->now['mon'], $i, $this->now['year']));	
				
			//dateEvent
			$dHtml_arr = false;
				
			if(isset($this->event[$this->now['year']][$this->now['mon']][$i])){
				$dHtml_arr = $this->event[$this->now['year']][$this->now['mon']][$i];
			}
					
			if(is_array($dHtml_arr)){
				foreach($dHtml_arr as $dHtml){
					$dateEvent = "calendarDateEvent";
				}
			}else{
				$dateEvent = "";
			}
			
			//dateOld
			if (date("Y-m-d") > $dateTime){
				$dateOld = "calendarDateOld";
			}else{
				$dateOld = "";
			}
				
			

			//Datum link
			$this->date .= 
			'<div class="col-calendar">
				<div class="wrap-col boxCalendar '. $dateToday . $dateEvent . $dateOld .'">
					<input type="hidden" value="'. $dateTime .'">'.$i.'
				</div>
			</div>';
				

			//tomma dagar
			if( $count > 6 ) {
				$this->date .= "<div>".($i != $count ? '</div>' : '');
				$count = 0;
			}
				
			$count++;
		}

		$this->date .= ($count != 1 ? str_repeat('<div class="col-calendar"><div class="wrap-col boxCalendarDisable">&nbsp;</div></div>', 8 - $count) : '') . "";
		
		return $this->date;

	}
	
	/***************************/
	/* array rotate            */
	/***************************/
	private function array_rotate(&$data, $steps){
		
		$count = count($data);
		
		if($steps < 0){
			$steps = $count + $steps;
		}
		
		$steps = $steps % $count;
		
		for($i = 0; $i < $steps; $i++){
			array_push($data, array_shift($data));
		}

	}

} ?>