<?php
$page_title = "Fornecedore";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura fornecedores
if(!isset($_GET['id'])) {
    echo 'id não encontrado';
}

$dao = $factory->getSupplierDao();
$supplier = $dao->getById($_GET['id']);

?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <a class="btn btn-success btn-sm" href="novo_fornecedor.php">Novo Fornecedor</a>
        </div>
    </div>
    <!-- listagem de fornecedores -->
    <div class="row">
        <div class="col">
            <?php var_dump($supplier); ?>
        </div>
    </div >
</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
