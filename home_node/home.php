<?php

	/**
	* Make sure you started your'e sessions!
	* You need to include su.inc.php to make SimpleUsers Work
	* After that, create an instance of SimpleUsers and your'e all set!
	*/

	session_start();
	require_once(dirname(__FILE__)."/simpleusers/su.inc.php");

	$SimpleUsers = new SimpleUsers();

	// This is a simple way of validating if a user is logged in or not.
	// If the user is logged in, the value is (bool)true - otherwise (bool)false.
	if( !$SimpleUsers->logged_in )
	{
		header("Location: login.php");
		exit;
	}

	// If the user is logged in, we can safely proceed.
	$users = $SimpleUsers->getUsers();

	// read values from data.txt
	$lines = file("simpleusers/data.txt");
//	$file = fopen("/simpleusers/data.txt");
//	fclose($file);

	// Send POST command to script
	if(isset($_POST['laser'])){
		$message = $SimpleUsers->script('lase', NULL);
    }
	if(isset($_POST['buzzer'])){
		$message = $SimpleUsers->script('buz', NULL);
    }	
	if(isset($_POST['up'])){
		$message = $SimpleUsers->script('y_servo', '5');
    }
	if(isset($_POST['down'])){
		$message = $SimpleUsers->script('y_servo', '-5');
    }
	if(isset($_POST['left'])){
		$message = $SimpleUsers->script('x_servo', '5');
    }
	if(isset($_POST['right'])){
		$message = $SimpleUsers->script('x_servo', '-5');
    }	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<style type="text/css">
		body{ font: 14px sans-serif; padding: 20px;}
	</style>
</head>
<body>
	<div>
		<p><a href="home.php" class="btn btn-default">Home</a>
		<a href="modules.php" class="btn btn-primary">Modules</a> 
		<a href="users.php" class="btn btn-primary">Users (admin only)</a>
		<a href="logout.php" class="btn btn-danger">Logout</a></p>
	</div>
	<div>
		<img src=/simpleusers/video.php border=0></a>
	</div>
	<div>
		<br>
		<form action="home.php" method="post">
			<input type="submit" name="buzzer" value="Buzzer" />
			<input type="submit" name="laser" value="Laser" />
			<input type="submit" name="up" value="Up" />
			<input type="submit" name="down" value="Down" />
			<input type="submit" name="left" value="Left" />
			<input type="submit" name="right" value="Right" />
			<br>
			<?php if(isset($message)){ echo $message;}?> 
			<br>
		</form>
		<br>
		<?php echo $lines[0]; 
			echo "<br>";
			echo $lines[1];
		?>
	</div>
</body>
</html>