<?php
$page_title = "Produto";
include_once "layout/layout_header.php";
include_once "fachada.php";
if(!isset($_GET['id'])) {
    header('Location: produtos.php');
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
            <div class="row">
                <div class="col-auto mb-4">
                    <button type="button" class="btn btn-primary btn-lg">Comprar Agora</button>
                </div>
                <div class="col-auto mb-4">
                    <button type="button" class="btn btn-outline-primary btn-lg">Adicionar ao Carrinho</button>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>


<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
