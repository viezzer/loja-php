<?php
session_start(); // Start session to initialize $_SESSION superglobal

include_once "dao/PostgresDaoFactory.php";

if (!isset($_SESSION['user_id'])) {
    // Redirect user if user_id is not set in session
    header('Location: login.php');
    exit();
}

// Check if product_id and quantity are set
if (!isset($_POST['product_id'], $_POST['quantity'])) {
    header('Location: produtos.php');
    exit();
}

$id = $_GET['id'];

// Obtém os detalhes do produto pelo ID
$productDao = $factory->getProductDao();
$product = $productDao->getById($id);

// Verifica se o produto existe
if (!$product) {
    header('Location: produtos.php');
    exit();
}

// Obtém o fornecedor e o estoque do produto
$supplier = $product->getSupplier();
$stock = $product->getStock();

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/400" class="img-fluid rounded" alt="Imagem do Produto">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4"><?php echo $product->getName()?></h2>
            <p class="text-muted mb-3">Fornecedor: <?php echo $supplier->getName()?></p>
            <p class="text-muted mb-3">Em Estoque: <?php echo $stock->getQuantity()?></p>
            <h3 class="text-danger mb-4"><?php echo $stock->getPrice()?> R$</h3>
            <div class="row">
                <form action="insere_carrinho.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantity" class="form-control" value="1" min="1">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Adicionar ao Carrinho</button>
                </form>
            </div>
            <hr>
        </div>
    </div>
</div>

<?php
// Inclui o rodapé do layout
include_once "layout/layout_footer.php";
?>
