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
	
	// Check for admin
	}elseif( $SimpleUsers->userdata["userId"] !== 1){
		$message = "Access denied";
		echo "<script type='text/javascript'>";
		echo "alert('$message');";
		echo "window.location.href = 'home.php';";
		echo "</script>";
		exit;
	}

	// If the user is logged in, we can safely proceed.
	$users = $SimpleUsers->getUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Users Administration</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<style type="text/css">
		body{ font: 14px sans-serif; padding: 20px;}
		* {	margin: 0px; padding: 0px; }
		table
		{
			font-family: Calibri, Verdana, "Sans Serif";
			width: 800px;
			margin: 0px auto;
			border: 2px solid black;
			float: left;
		}

		th, td
		{
			padding: 3px;
			border: 2px solid black;
		}

		.right
		{
			text-align: right;
		}


  </style>

</head>
<body>
	<div>
		<p><a href="home.php" class="btn btn-primary">Home</a>
		<a href="modules.php" class="btn btn-primary">Modules</a> 
		<a href="users.php" class="btn btn-default">Users (admin only)</a>
		<a href="logout.php" class="btn btn-danger">Logout</a></p>
	</div>

	<table>
		<thead>
			<tr>
				<th>Username</th>
				<th>Last activity</th>
				<th>Created</th>
				<th></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4" class="right">
					<a href="newuser.php">Create new user</a>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach( $users as $user ): ?>
			<tr>
				<td><?php echo $user["uUsername"]; ?></td>
				<td class="right"><?php echo $user["uActivity"]; ?></td>
				<td class="right"><?php echo $user["uCreated"]; ?></td>
				<td class="right"><a href="deleteuser.php?userId=<?php echo $user["userId"]; ?>">Delete</a> | <a href="changepassword.php?userId=<?php echo $user["userId"]; ?>">Change password</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</body>
</html>