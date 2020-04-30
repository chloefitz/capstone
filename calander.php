<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<?php
function build_calander($month, $year){
	//first of all we'll creat an array containing names of all days in a week.
	$daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday', 'Friday', 'Saturday');
	
	//Then we'll get the frist day of the month that is in the argumnets of this function
	$firstDayOfMonth = mktime(0,0,0,$month, 1,$year);
	
	//now get the number of days this month contains
	$numberDays = date('t', $firstDayOfMonth);
	
	//getting some information about the first day of thois month
	$dateComponents = getdate($firstDayOfMonth);
	
	//getting the name of the month
	$monthName = $dateComponents['month'];
	
	//getting the index value 0-6 of the first day of this month
	$dayOfWeek = $dateComponents['wday'];
	
	//gettting the current date
	$dateToday = date('Y-m-d');
	
	//create HTML table
	$calander="<table class='table table-bordered'>";
	$calander.="<center><h2>$monthName $year</h2>";
	
	$calander.="<a class='btn btn-xs btn-primary'href='?month=".date('m',mktime(0,0,0, $month-1,1,$year)).
	"&year=".date('Y',mktime(0,0,0, $month-1,1,$year))."'>Previous Month</a>";
	
	$calander.="<a class='btn btn-xs btn-primary'href='?month=".date('m').
	"&year=".date('Y')."'>Current Month</a>";
	
	$calander.="<a class='btn btn-xs btn-primary'href='?month=".date('m',mktime(0,0,0, $month+1,1,$year)).
	"&year=".date('Y',mktime(0,0,0, $month+1,1,$year))."'>Next Month</a></center><br>";
	
	
	
	$calander.="<tr>";
	
	//create a calander headers
	foreach($daysOfWeek as $day){
		$calander.="<th class='header'>$day</th>";
	}
	$currentDay = 1;
	$calander.="</tr><tr>";
	
	//The variable $dayOfWeek will make sure that must be only 7 columns on our table
	
	if($dayOfWeek >0){
		for($k = 0;$k < $dayOfWeek; $k++){
			$calander.= "<td class='empty'></td>";
		}
	}
	
	
	
	//getting the day number
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	
	while($currentDay <= $numberDays){
		
		//if seven coloumn(saturday) reached start a new row
		if($dayOfWeek == 7){
			$dayOfWeek = 0;
			$calander.="</tr><tr>";
		}
		
		
		$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		$date = "$year-$month-$currentDayRel";
		
		$dayname = strtolower(date('l', strtotime($date)));
		$eventNum = 0;
		
		$today = $date==date('Y-m-d')?"today":"";
		if($date<date('Y-m-d')){
			$calander.="<td class='booked'><h4>$currentDay</h4><button class=''>N/A</button>";
		}else{
			$calander.="<td class='$today'><h4>$currentDay</h4><a href='http://localhost/Capstone/request/request_v3.php?date=".$date."'class='btn btn-success btn-sx'>Book</a>";
		}
		
		//if($dateToday == $date){
		//	$calander.="<td class='today'rel='$date'><h4>$currentDay</h4>";
		//	
		//}else{
		//	$calander.="<td class'' rel='$date'><h4>$currentDay</h4>";
		//}
		
		//$calander.="<td><h4>$currentDay</h4>";
		
		$calander.="</td>";
		
		//incrementing the counters
		$currentDay++;
		$dayOfWeek++;
	}
	//completing the row of the last week in month necessary
	if($dayOfWeek != 7){
		$remainingDays = 7 - $dayOfWeek;
		for($i = 0; $i<$remainingDays; $i++){
			$calander.= "<td></td>";
		}
	}
	
	$calander.= "</tr>";
	$calander.= "</table>";
	
	echo $calander;
}

?>

<html>
<head>
	<meta name="viewport"content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<style>
		table{
			table-layout:fixed;
		}
		td{
			width:33%;
		}
		.today{
			background:yellow;
		}
		.booked{
			background: #F4F3F1;
		}
		
	</style>
	<title>Untitled</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-mid-12">
				<?php
				$dateComponents = getdate();
				$month = $dateComponents['mon'];
				$year = $dateComponents['year'];
				echo build_calander($month,$year);
				
				?>
			</div>
		</div>
	</div>


</body>
</html>
