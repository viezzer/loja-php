<?php
$page_title = "Loja";
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";

$limit = 9; // Número de itens por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$dao = $factory->getProductDao();

$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : null;

$products = $dao->getAllHomePage($search_name, $limit, $offset);

$total_items = $dao->countAll(null, $search_name);
$total_pages = ceil($total_items / $limit);

?>
<div class='container'>
    <!-- Jumbotron -->
    <div class="jumbotron jumbotron-fluid my-3">
        <div class="container">
            <h1 class="display-4">Bem-vindo à Sua Loja Online</h1>
            <p class="lead">A melhor seleção de produtos para você.</p>
			<form class="row g-3" action="" method="GET">
				<div class="col-11">
					<input type="text" class="form-control form-control-sm mb-2" id='search_name' name='search_name' placeholder="<?php echo (isset($_GET['search_name']) && $_GET['search_name']) ? $_GET['search_name'] : 'Buscar produtos por nome ou descrição' ?>">
				</div>
				<div class="col-1">
					<button type='submit' class='btn btn-sm btn-primary '>Pesquisar</button>
				</div>
			</form>
		</div>
    </div>

    <!-- Conteúdo da Página -->
    <div class="container">
        <?php
        if($products){
            echo "<div class='row'>";
            $count = 0;
            foreach ($products as $product) {
                if ($count > 0 && $count % 3 == 0) {
                    echo "</div><div class='row'>";
                }
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
						<?php
							if(!empty($product->getImage())){
								echo "<img height='300px' src='data:image/png;base64,". $product->getImage(). "' class='card-img-top rounded' alt='". $product->getName() ."'>";
							
							}else {
								echo "<img height='300px' src='https://via.placeholder.com/300' class='card-img-top rounded' alt='without image'> ";

							}
						?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product->getName(); ?></h5>
                            <p class="card-text text-truncate"><?php echo $product->getDescription(); ?></p>
                            <a href="#" class="btn btn-primary">Ver Detalhes</a>
                            <?php if (($product->getStock()) && ($product->getStock()->getQuantity() <= 0)){ ?>
                                <img src="static/out-of-stock.png" alt="Out of Stock Icon" height="20">
								<span class="text-secondary fs-6">Indisponível</span>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            }
            echo "</div>";
        } else {
            echo "<div class='alert alert-info'>Nenhum produto encontrado.</div>";
        }
        ?>

        <!-- Paginação -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                if ($total_pages > 1) {
                    // Botão para a primeira página
                    echo '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">';
                    echo '<a class="page-link" href="?page=1&search_name=' . $search_name . '">Primeira</a>';
                    echo '</li>';

                    // Botões de páginas numeradas
                    $start_page = max(1, $page - 1);
                    $end_page = min($total_pages, $page + 1);

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                        echo '<a class="page-link" href="?page=' . $i . '&search_name=' . $search_name . '">' . $i . '</a>';
                        echo '</li>';
                    }

                    // Botão para a última página
                    echo '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $total_pages . '&search_name=' . $search_name . '">Última (' . $total_pages . ')</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

    </div>
</div>

<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>


