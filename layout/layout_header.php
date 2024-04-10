<!DOCTYPE HTML>

<html lang=pt-br>

<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<!-- <link rel="stylesheet" type="text/css" href="libs/css/custom2.css"> -->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
	<header>
		<h1><?=$page_title?></h1>
		<div class="pull-right" id="login_info">
		<?php	
		include_once(realpath('comum.php'));
		
		if ( is_session_started() === FALSE ) {
			session_start();
		}	
		
		if(isset($_SESSION["user_name"])) {
			// Informações de login
			echo "<span>Você está logado como " . $_SESSION["user_name"];		
			echo "<a href='executa_logout.php'> Logout </a></span>";
		} else {
			echo "<span><a href='login.php'> Efetuar Login </a></span>";
		}
		?>	
		</div>
	</header>

