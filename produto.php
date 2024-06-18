<?php
$page_title = "Cadastro de Produto";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
if(!isset($_GET['id'])) {
    header('Location: produtos.php');
}
$edit = 'disabled';
if(isset($_GET['edit'])) {
    $edit = $_GET['edit'];
}
// procura fornecedores
$supplierDao = $factory->getSupplierDao();
$suppliers = $supplierDao->getSuppliersOptionList();

$productDao = $factory->getProductDao();
$product = $productDao->getById($_GET['id']);
$supplier = $product->getSupplier();
$stock = $product->getStock();

?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <?php
                echo "<a class='btn btn-secondary btn-sm' href='produtos.php'>Voltar</a>";
                if($edit=='disabled') {
                    echo "<a href='?id={$_GET['id']}&edit=' class='btn btn-primary btn-sm mx-2'>Editar</a>";
                } else {
                    echo "<a href='excluir_produto.php?id={$_GET['id']}' class='btn btn-danger btn-sm mx-2'>Excluir</a>";
                }
            ?>
        </div>
    </div>
    <!-- listagem de produtos -->
    <div class="row">
        <div class="col">
            <?php
                // Verifica se a variável 'msg' está presente na URL
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];

                    // Mensagem de erro correspondente ao valor da variável 'msg'
                    $messages = [
                        'empty' => 'Por favor, preencha todos os campos.',
                        'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                        'database_error' => 'Erro no servidor.',
                        'stock_update_error' => 'Erro ao atualizar estoque.',
                        'product_update_error' => 'Erro ao atualizar Produto.'
                    ];

                    // Verifica se a chave 'msg' existe no array de mensagens de erro
                    if (array_key_exists($msg, $messages)) {
                        // Exibe a mensagem de erro
                        echo '<div class="alert alert-warning" role="alert">' . $messages[$msg] . '</div>';
                    } else {
                        // Mensagem de erro padrão caso o código de erro não seja reconhecido
                        echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
                    }
                }
                echo '
                <form action="atualiza_produto.php" method="post" enctype="multipart/form-data">
                    <legend>Cadastro de Produto</legend>
                    <input type="hidden" value="'.$product->getId().'" name="id">
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="name" value="'.$product->getName().'" '.$edit.'>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputDescription" class="form-label">Descrição</label>
                            <textarea class="form-control" id="inputDescription" name="description" '.$edit.'>'.$product->getDescription().'</textarea>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputSupplier" class="form-label">Fornecedor</label>';
                            echo "<select class='form-select' id='inputSupplier' name='supplier_id' $edit>";
                            echo "<option value='{$supplier->getId()}'>{$supplier->getName()}</option>";
                                foreach($suppliers as $sup) {
                                    echo "<option value='{$sup->getId()}'>{$sup->getName()}</option>";
                                };
                            echo '</select>';
                        echo '</div>
                        <div class="col-lg-6">
                            <label for="inputQuantity" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="inputQuantity" name="quantity" value="'.$stock->getQuantity().'" '.$edit.'>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputPrice" class="form-label">Preço</label>
                            <input type="text" class="form-control" id="inputPrice" name="price" value="'.$stock->getPrice().'" '.$edit.'>
                        </div>';
                    if($edit!='disabled') {
                        echo '<div class="col-lg-6">
                                <label for="inputImage" class="form-label">Imagem</label>
                                <input type="file" class="form-control" id="inputImage" name="image" accept="image/*" '.$edit.'>
                            </div>';
                    }
                    if($product->getImage()){
                        echo '<div class="col-lg-7">
                            <label class="form-label">Imagem do Produto</label><br>
                            <img height="150px" src="data:image/png;base64,' . $product->getImage() . '" class="rounded float-left" alt="Imagem do produto">
                        </div>';
                    }
                    echo '</div>';
                    if($edit!='disabled') {
                        echo '<button type="submit" class="btn btn-success">Salvar</button>';
                    }
                    echo '</form>';
            ?>
        </div>
    </div >
</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
