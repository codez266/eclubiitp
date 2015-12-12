<?php
	function getEventsForCalendar($month, $year){
		require_once('db.php');
		$q = "SELECT * FROM events_calendar WHERE `month`=$month AND `year`=$year";
		$res = mysqli_query($dbc, $q) or die('Error in querying');
		echo "[";
		while($ar = mysqli_fetch_array($res)){
			unset($ar['0']);
			unset($ar['1']);
			unset($ar['2']);
			unset($ar['3']);
			unset($ar['4']);
			unset($ar['5']);
			$json = json_encode($ar);
			echo $json.',';
		}
		echo "]";
	}
	function addEvent($day, $month, $year, $title, $desc){
		require_once('db.php');
		$q = "INSERT INTO events_calendar(day,month,year,title,description) VALUES($day, $month, $year, '$title', '$desc')";
		$res = mysqli_query($dbc, $q) or die('Error in querying');
		if($res)
			return 1;
		else
			return 0;
	}
?>