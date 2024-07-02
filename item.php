<?php
$page_title = "Produto";
include_once "layout/layout_header.php";
include_once "fachada.php";

// Verifica se o formulário foi enviado e se 'add_to_cart' está definido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Validação mínima
    $id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($id && $quantity > 0) {
        // Busca detalhes do produto no banco de dados usando $id
        $productDao = $factory->getProductDao();
        $product = $productDao->getById($id);

        if ($product) {
            // Verifica se o produto já está no carrinho
            $item_found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    // Se encontrado, aumenta apenas a quantidade
                    $item['quantity'] += $quantity;
                    $item_found = true;
                    break;
                }
            }

            // Se não encontrado, adiciona o novo item ao carrinho
            if (!$item_found) {
                $cart_item = array(
                    'id' => $id,
                    'name' => $product->getName(),
                    'price' => $product->getStock()->getPrice(),
                    'quantity' => $quantity
                );
                $_SESSION['cart'][] = $cart_item;
            }

            // Redireciona para a página do carrinho
            header('Location: carrinho.php');
            exit;
        }
    }
}

// Obtém o ID do produto da query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    // Tratar caso o ID não seja fornecido corretamente
    header('Location: index.php');
    exit;
}

// Busca informações do produto usando $id
$productDao = $factory->getProductDao();
$product = $productDao->getById($id);
if (!$product) {
    // Caso o produto não seja encontrado
    header('Location: index.php');
    exit;
}

$supplier = $product->getSupplier();
$stock = $product->getStock();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/400" class="img-fluid rounded" alt="Imagem do Produto">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4"><?php echo htmlspecialchars($product->getName()) ?></h2>
            <p class="text-muted mb-3">Fornecedor: <?php echo htmlspecialchars($supplier->getName()) ?></p>
            <p class="text-muted mb-3">Em Estoque: <?php echo $stock->getQuantity() ?></p>
            <h3 class="text-danger mb-4"><?php echo $stock->getPrice() ?> R$</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="hidden" name="product_id" value="<?php echo $id ?>">
                    <input type="number" id="quantidade" name="quantity" class="form-control" value="1" min="1">
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg">Adicionar ao Carrinho</button>
            </form>
            <hr>
        </div>
    </div>
</div>

<?php
// Layout do rodapé
include_once "layout/layout_footer.php";
?>
