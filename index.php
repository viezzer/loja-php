<?php
$page_title = "Loja";
// layout do cabeçalho
include_once "layout/layout_header.php";
 ?>
	<div class='container'>
		<!-- Jumbotron -->
		<div class="jumbotron jumbotron-fluid my-3">
			<div class="container">
				<h1 class="display-4">Bem-vindo à Sua Loja Online</h1>
				<p class="lead">A melhor seleção de produtos para você.</p>
				<a class="btn btn-primary btn-lg" href="#" role="button">Ver Produtos</a>
			</div>
		</div>

    <!-- Conteúdo da Página -->
    <div class="container">
			<div class="row">
				<div class="col-md-4 mb-4">
					<div class="card">
						<img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Produto 1</h5>
							<p class="card-text">Descrição breve do Produto 1.</p>
							<a href="#" class="btn btn-primary">Ver Detalhes</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card">
						<img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Produto 2</h5>
							<p class="card-text">Descrição breve do Produto 2.</p>
							<a href="#" class="btn btn-primary">Ver Detalhes</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card">
						<img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Produto 3</h5>
							<p class="card-text">Descrição breve do Produto 3.</p>
							<a href="#" class="btn btn-primary">Ver Detalhes</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>


