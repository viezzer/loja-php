<?php
$page_title = "Carrinho de Compras";
include_once "layout/layout_header.php";
// Inclua seu arquivo fachada.php aqui se necessário
?>

<div class="container mt-5">
    <h2 class="mb-4">Carrinho de Compras</h2>
    
    <div class="row">
        <div class="col-md-8">
            <?php
            // Verifica se existe algo no carrinho na sessão
            if (!empty($_SESSION['cart'])) {
                // Loop pelos itens do carrinho
                foreach ($_SESSION['cart'] as $item) {
            ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="https://via.placeholder.com/300" alt="Imagem do Produto" class="img-fluid rounded-start">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text text-muted">Preço: <?php echo $item['price']; ?> R$</p>
                                <div class="input-group mb-3" style="max-width: 150px;">
                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control text-center" value="<?php echo $item['quantity']; ?>">
                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                </div>
                                <form method="post" action="remover_do_carrinho.php">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger">Remover <i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                } // Fim do loop foreach
            } else {
                // Caso o carrinho esteja vazio
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                          Seu carrinho está vazio. <a href="index.php" class="alert-link">Adicione itens agora!</a>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            ?>
        </div>
        
        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="col-md-4">
            <div class="card position-sticky top-0">
                <div class="card-body">
                    <h5 class="card-title">Resumo do Carrinho</h5>
                    <ul class="list-group mb-3">
                        <?php
                        // Calculando o total e contando itens
                        $total_items = 0;
                        $total_price = 0;
                        
                        foreach ($_SESSION['cart'] as $item) {
                            $total_items += $item['quantity'];
                            $total_price += $item['price'] * $item['quantity'];
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (<?php echo $total_items; ?> itens)</span>
                            <strong><?php echo number_format($total_price, 2); ?> R$</strong>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Finalizar Compra</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
