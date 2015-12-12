<?php
	$user = "root";
	$pass = "userofeclubiitp#2014";
	if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER']!=$user) || ($_SERVER['PHP_AUTH_PW']!=$pass))
	{
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="identify yourself"');
		exit('you must enter a valid username and password');
	}
	else{
		require_once('function.php');
		if(isset($_POST['submitEvent'])){
			$day = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$title = $_POST['title'];
			$desc = $_POST['desc'];
			$val = addEvent($day, $month, $year, $title, $desc);
			if($val == 1){
				echo 'Added successfully';
			}
			else{
				echo 'Error. Try again';
			}
		}
		else{
?>
<html>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		Day: <br/><input type="text" name="day" required/><br/>
		Month: <br/><input type="text" name="month" required/><br/>
		Year: <br/><input type="text" name="year" required/><br/>
		Event Title: <br/><input type="text" name="title" required/><br/>
		Event Description: <br/><textarea rows="5" cols="100" name="desc"></textarea><br/>
		<input type="submit" name="submitEvent" value="SUBMIT" />
	</form>
</html>
<?php
		}
	}
?>