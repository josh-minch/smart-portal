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
</body>
</html>