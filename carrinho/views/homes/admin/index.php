<?php

	require_once("../../../app/User.php");
	
	$user = new User();
	
	$user->acessar("home admin");

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Home</title>
	</head>
	<body>
		<div class="container">
			<h1>Home admin</h1>
		</div>
	</body>
</html>




