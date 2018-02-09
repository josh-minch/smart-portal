<?php

	/**
	* Make sure you started your sessions!
	* You need to include su.inc.php to make SimpleUsers Work
	* After that, create an instance of SimpleUsers and you're all set!
	*/

	session_start();
	require_once(dirname(__FILE__)."/simpleusers/su.inc.php");

	$SimpleUsers = new SimpleUsers();

	// Login from post data
	if( isset($_POST["username"]) )
	{

		// Attempt to login the user - if credentials are valid, it returns the users id, otherwise (bool)false.
		$res = $SimpleUsers->loginUser($_POST["username"], $_POST["password"]);
		if(!$res)
			$error = "You supplied the wrong credentials.";
		else
		{
				header("Location: home.php");
				exit;
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
	<h1>Smart Portal</h1>
	<h2>Login</h2>
	<div class="wrapper">
		<?php if( isset($error) ): ?>
		<p><?php echo $error; ?></p>
		<?php endif; ?>
		<form method="post" action="">
			<div class="form-group">
				<label for="username">Username:<sup>*</sup></label><br />
				<input type="text" name="username" id="username" class="form-control"/>
			</div>    
            <div class="form-group">
				<label for="password">Password:<sup>*</sup></label><br />
				<input type="password" name="password" id="password" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="submit" value="Login" />
		
			</div>
		</form>
	</div>
</body>
</html>
