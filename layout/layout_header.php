<!DOCTYPE HTML>

<html lang=pt-br>

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $page_title; ?></title>
	<!-- <link rel="stylesheet" type="text/css" href="libs/css/custom2.css"> -->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Aliexpress</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php	
			include_once(realpath('comum.php'));
			
			if ( is_session_started() === FALSE ) {
				session_start();
			}	
			
			if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] == 'admin') {
				// Informações de login
				echo "<li class='nav-item dropdown'>
						<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
						{$_SESSION['user_name']}
						</a>
						<ul class='dropdown-menu'>
							<li><a class='dropdown-item' href='usuarios.php'>Usuários</a></li>
							<li><a class='dropdown-item' href='fornecedores.php'>Fornecedores</a></li>
							<li><a class='dropdown-item' href='produtos.php'>Produtos</a></li>
							<li><a class='dropdown-item' href='executa_logout.php'>Logout</a></li>
						</ul>
					</li>";
			} else if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == 'client') {
				echo "<li class='nav-item dropdown'>
						<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
						{$_SESSION['user_name']}
						</a>
						<ul class='dropdown-menu'>
							<li><a class='dropdown-item' href='carrinho.php'>Carrinho</a></li>
							<li><a class='dropdown-item' href='pedidos_cliente.php'>Meus Pedidos</a></li>
							<li><a class='dropdown-item' href='executa_logout.php'>Logout</a></li>
						</ul>
					</li>";
					
			} else {
				echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
			}
		?>
      </ul>
      <!-- <form class="d-flex" role="procurar">
        <input class="form-control me-2" type="procurar" placeholder="Procurar" aria-label="Procurar">
        <button class="btn btn-outline-success" type="submit">Procurar</button>
      </form> -->
    </div>
  </div>
</nav>