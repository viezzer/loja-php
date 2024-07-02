<?php
$page_title = "Produto";
include_once "layout/layout_header.php";
include_once "fachada.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Assuming you have a session started already
    session_start();

    // Retrieve product ID and quantity from POST
    $id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details from database based on $id (similar to how you fetched in your existing code)
    $productDao = $factory->getProductDao();
    $product = $productDao->getById($id);

    // Create an array to store product details
    $cart_item = array(
        'id' => $id,
        'name' => $product->getName(),
        'price' => $product->getStock()->getPrice(),
        'quantity' => $quantity
    );

    // Initialize the session cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add the item to the session cart
    $_SESSION['cart'][] = $cart_item;

    // Optionally, you can redirect to another page after adding to cart
    header('Location: carrinho.php');
    // exit();
}

$id = $_GET['id'];

$supplierDao = $factory->getSupplierDao();
$suppliers = $supplierDao->getSuppliersOptionList();

$productDao = $factory->getProductDao();
$product = $productDao->getById($id);
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
            <form method="post" action="">
                <div class="row">
                    <label for="quantidade">Quantidade:</label>
                    <input type="hidden" name="product_id" value="<?php echo $id ?>">
                    <input type="number" id="quantidade" name="quantity" class="form-control" value="1" min="1">
                    <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg">Adicionar ao Carrinho</button>
                </div>
            </form>
            <hr>
        </div>
    </div>
</div>

<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
