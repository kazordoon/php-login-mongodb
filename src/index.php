<?php
	session_start();

	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName'])) {
		header('Location: login.php');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Home</title>
	<link rel="stylesheet" href="public/css/styles.css" />
</head>
<body>
	<div class="container">
		<h1>Hi <?php echo $_SESSION['userName']; ?></h1>
		<p><a href="logout.php">Log out</a></p>
	</div>
</body>
</html>