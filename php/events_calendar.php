<?php
	require_once 'function.php';
	$month = $_GET['month'];
	$year = $_GET['year'];
	getEventsForCalendar($month, $year);
?>