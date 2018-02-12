<?php

	/**
	* Make sure you started your'e sessions!
	* You need to include su.inc.php to make SimpleUsers Work
	* After that, create an instance of SimpleUsers and your'e all set!
	*/

	session_start();
	require_once(dirname(__FILE__)."/simpleusers/su.inc.php");

	$SimpleUsers = new SimpleUsers();

	// If the user is logged in, the value is (bool)true - otherwise (bool)false.
	if( !$SimpleUsers->logged_in )
	{
		header("Location: login.php");
		exit;

	// Check if the user is admin.
	}elseif( $SimpleUsers->userdata["userId"] !== 1){
		$message = "Access denied";
		echo "<script type='text/javascript'>";
		echo "alert('$message');";
		echo "window.location.href = 'home.php';";
		echo "</script>";
		exit;
	}
	
	// Validation of input
	if( isset($_POST["username"]) )
	{
		if( empty($_POST["username"]) || empty($_POST["password"]) )
			$error = "You have to choose a username and a password";
    else
    {
    	// Both fields have input - now try to create the user.
    	// If $res is (bool)false, the username is already taken.
    	// Otherwise, the user has been added, and we can redirect to some other page.
			$res = $SimpleUsers->createUser($_POST["username"], $_POST["password"]);

			if(!$res)
				$error = "Username already taken.";
			else
			{
					header("Location: users.php");
					exit;
			}
		}

	} // Validation end

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<style type="text/css">
		body{ font: 14px sans-serif; padding: 20px;}
		.wrapper{ width: 300px;}
	</style>
</head>
<body>
	<div>
		<p><a href="home.php" class="btn btn-primary">Home</a>
		<a href="modules.php" class="btn btn-primary">Modules</a> 
		<a href="users.php" class="btn btn-default">Users (admin only)</a>
		<a href="logout.php" class="btn btn-danger">Logout</a></p>
	</div>
	<h2>Register new user</h1>
	<div class="wrapper">

		<?php if( isset($error) ): ?>
		<p>
			<?php echo $error; ?>
		</p>
		<?php endif; ?>

		<form method="post" action="">
			<div class="form-group">
				<label for="username">Username:</label><br />
				<input type="text" name="username" id="username" class="form-control"/>
			</div>
			
            <div class="form-group">
				<label for="password">Password:</label><br />
				<input type="text" name="password" id="password" class="form-control"/>
			</div>
            <div class="form-group">
				<input type="submit" class="btn btn-primary name="submit" value="Register" />
			</div>

		</form>
	</div>
</body>
</html>