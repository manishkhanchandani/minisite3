<?php
class calendar {
	public function GetQueryString(){
		$queryString_rsView = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (strstr($param, "Y") == false && 
				strstr($param, "M") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString_rsView = "&" . htmlentities(implode("&", $newParams));
		  }
		}
		$queryString_rsView .= "&pageNum_rsView=".$_GET['pageNum_rsView'];
		return $queryString_rsView;
    }
	public function createCal($Y='', $M='') {
		//Don't edit any lines shown below
		if($Y && $M) {
			$time = mktime(0,0,0,$M,date('d'),$Y);
		} else {
			$time = time();
			$Y = date('Y', $time);
			$M = date('n', $time);
		}
		$next = $this->nextMonth($Y, $M);
		$prev = $this->prevMonth($Y, $M);
		$today = getdate($time);
		
		$mon = $today['mon']; //month
		$year = $today['year']; //this year
		$day = $today['mday']; //this day
		
		$monnn = $today['month']; //month as string
		//echo $monnn;
		
		$day1 = $day-1;
		
		$my_time= mktime(0,0,0,$mon,1,$year);
		$start_mon = date('d', $my_time); //Month starting date
		$start_day = date('D', $my_time); //Month starting Day
		//echo $start_mon;
		//echo $start_day;
		$start_daynum = date('w', $my_time);
		
		$daysIM = $this->DayInMonth($mon,$year); //Number of days in this month
		$qs = $this->GetQueryString();
		$cal = '
				<div id="calendar_wrap">
					<table summary="Calendar">
						<caption>
						'.$monnn.' '.$year.'
						</caption>
						<thead>
							<tr>
								<th abbr="Sunday" scope="col" title="Sunday">S</th>
								<th abbr="Monday" scope="col" title="Monday">M</th>
								<th abbr="Tuesday" scope="col" title="Tuesday">T</th>
								<th abbr="Wednesday" scope="col" title="Wednesday">W</th>
								<th abbr="Thursday" scope="col" title="Thursday">T</th>
								<th abbr="Friday" scope="col" title="Friday">F</th>
								<th abbr="Saturday" scope="col" title="Saturday">S</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td abbr="February" colspan="3" id="prev"><a href="'.$_SERVER['PHP_SELF'].'?M='.$prev['prevMonth'].'&Y='.$prev['prevYear'].$qs.'" title="">&laquo; '.$prev['month'].'</a></td>
								<td class="pad">&nbsp;</td>
								<td abbr="April" colspan="3" id="next"><a href="'.$_SERVER['PHP_SELF'].'?M='.$next['nextMonth'].'&Y='.$next['nextYear'].$qs.'" title="">'.$next['month'].' &raquo;</a></td>
							</tr>
						</tfoot>
						<tbody>';
						$dd = 0;
						$daye = 1;
						$cal .= '<tr>';
						while($dd < $start_daynum) {
							$cal .= '<td>&nbsp;</td>';
							$dd = $dd+1;
						}
						while($dd < 7) {
							if($daye == $day) {
								$cal .= '<td id="today"><a href="javascript:;" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
								$dd++;
							} else {
								$cal .= '<td><a href="javascript:;" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
								$dd++;
							}
						}
						$cal .= '</tr>';

						while($daye < $daysIM) {
							$cal .= '<tr>';
							$dd = 0;
							while($dd<7) {
								if($daye <= $daysIM) {
									if($daye == $day) {
										$cal .= '<td id="today"><a href="javascript:;" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
										$dd++;
									} else {
										$cal .= '<td><a href="javascript:;" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
										$dd++;
									};
								} else {
									$cal .= '<td>&nbsp;</td>';
									$dd++;
								}

							}
							$cal .= '</tr>';
						}
						$cal .= '
						</tbody>
					</table>
				</div>';
		echo $cal;
	}
	
	
	public function createCalbk($Y='', $M='') {
		//Don't edit any lines shown below
		if($Y && $M) {
			$time = mktime(0,0,0,$M,date('d'),$Y);
		} else {
			$time = time();
			$Y = date('Y', $time);
			$M = date('n', $time);
		}
		$next = $this->nextMonth($Y, $M);
		$prev = $this->prevMonth($Y, $M);
		$today = getdate($time);
		
		$mon = $today['mon']; //month
		$year = $today['year']; //this year
		$day = $today['mday']; //this day
		
		$monnn = $today['month']; //month as string
		//echo $monnn;
		
		$day1 = $day-1;
		
		$my_time= mktime(0,0,0,$mon,1,$year);
		$start_mon = date('d', $my_time); //Month starting date
		$start_day = date('D', $my_time); //Month starting Day
		//echo $start_mon;
		//echo $start_day;
		$start_daynum = date('w', $my_time);
		
		$daysIM = $this->DayInMonth($mon,$year); //Number of days in this month
		$qs = $this->GetQueryString();
		$cal = '
				<div id="calendar_wrap"><table width="290" border="1" cellpadding="10" cellspacing="0" bordercolor="#E5E5E5" class="calendar" summary="Calendar">
						<caption>
						'.$monnn.' '.$year.'</caption>
						<thead>
							<tr bgcolor="#F2F2F2">
								<th title="Sunday" scope="col" abbr="Sunday"><span class="style16">S</span></th>
								<th title="Monday" scope="col" abbr="Monday"><span class="style16">M</span></th>
								<th title="Tuesday" scope="col" abbr="Tuesday"><span class="style16">T</span></th>
								<th title="Wednesday" scope="col" abbr="Wednesday"><span class="style16">W</span></th>
								<th title="Thursday" scope="col" abbr="Thursday"><span class="style16">T</span></th>
								<th title="Friday" scope="col" abbr="Friday"><span class="style16">F</span></th>
								<th title="Saturday" scope="col" abbr="Saturday"><span class="style16">S</span></th>
							</tr>
						</thead>
						<tfoot>
							<tr class="calendar">
								<td abbr="'.$prev['month'].'" colspan="3" id="prev"><a href="'.$_SERVER['PHP_SELF'].'?M='.$prev['prevMonth'].'&Y='.$prev['prevYear'].$qs.'" title="">&laquo; '.$prev['month'].'</a></td>
								<td class="pad">&nbsp;</td>
								<td abbr="'.$next['month'].'" colspan="3" id="next"><a href="'.$_SERVER['PHP_SELF'].'?M='.$next['nextMonth'].'&Y='.$next['nextYear'].$qs.'" title="">'.$next['month'].' &raquo;</a></td>
							</tr>
						</tfoot>						
						<tbody>';
						$dd = 0;
						$daye = 1;
						$cal .= '<tr class="calendar">';
						while($dd < $start_daynum) {
							$cal .= '<td class="date">&nbsp;</td>';
							$dd = $dd+1;
						}
						while($dd < 7) {
							if($daye == $day) {
								$cal .= '<td><a href="javascript:;" class="date" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
								$dd++;
							} else {
								$cal .= '<td><a href="javascript:;" class="date" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
								$dd++;
							}
						}
						$cal .= '</tr>';

						while($daye < $daysIM) {
							$cal .= '<tr>';
							$dd = 0;
							while($dd<7) {
								if($daye <= $daysIM) {
									if($daye == $day) {
										$cal .= '<td><a href="javascript:;" class="date" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
										$dd++;
									} else {
										$cal .= '<td><a href="javascript:;" class="date" onClick="eventCal(\''.$Y.'\',\''.$M.'\',\''.$daye.'\');">'.$daye++.'</a></td>';
										$dd++;
									};
								} else {
									$cal .= '<td>&nbsp;</td>';
									$dd++;
								}

							}
							$cal .= '</tr>';
						}
						$cal .= '
						</tbody>
					</table>
				</div>';
		echo $cal;
	}
	
	public function DayInMonth($month, $year) {
	   $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	   if ($month != 2)
	   {
			return $daysInMonth[$month - 1];
		}
		else
		{
		return (checkdate($month, 29, $year)) ? 29 : 28;
		}
	}
	
	public function months($k) {
		$arr = array(1=>'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		return $arr[$k];
	}
	public function nextMonth($Y, $M) {
		$arr['nextMonth'] = $M+1;
		$arr['nextYear'] = $Y;
		if($arr['nextMonth']>12) {
			$arr['nextMonth'] = 1;
			$arr['nextYear'] = $arr['nextYear']+1;
		}
		$arr['month'] = $this->months($arr['nextMonth']);
		return $arr;
	}
	public function prevMonth($Y, $M) {
		$arr['prevMonth'] = $M-1;
		$arr['prevYear'] = $Y;
		if($arr['prevMonth']<1) {
			$arr['prevMonth'] = 12;
			$arr['prevYear'] = $arr['prevYear']-1;
		}
		$arr['month'] = $this->months($arr['prevMonth']);
		return $arr;
	}
}
?>
<?php 
// usage
//$cal = new calendar;
//$cal->createCal($_GET['Y'],$_GET['M']);
?>