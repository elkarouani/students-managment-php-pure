<?php session_start(); 
	$name = "";
	if (isset($_SESSION['name'])) {
		$name = $_SESSION['name'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css/custom.css">
</head>
<body>
	<nav class="navbar navbar-inverse" style="border-radius: 0">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Admin interface</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php if ($_GET['page'] === '1'): ?>
						<li class="active"><a href="adminInterface.php?page=1">Users</a></li>
						<li><a href="adminInterface.php?page=2">cources</a></li>
					<?php endif ?>
					<?php if ($_GET['page'] === '2'): ?>
						<li><a href="adminInterface.php?page=1">Users</a></li>
						<li class="active"><a href="adminInterface.php?page=2">cources</a></li>
					<?php endif ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Bonjour <?= $name ?> </a></li>
					<li><a href="Signout.php">Se deconnecter</a></li>
				</ul>
			</div>
		</div>
	</nav>
