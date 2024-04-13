<?php
$page_title = "Produtos";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura produtos
$dao = $factory->getProductDao();
//verifica se existe inputs de pesquisa
if(isset($_GET['search_id']) || isset($_GET['search_name'])) {
    $products = $dao->getAllBySearchedInputs($_GET['search_id'], $_GET['search_name']);
} else {
    $products = $dao->getAll();
}
?>
<div class="container py-4">
    <!-- Banner de alerta -->
    <div class="row">
        <div class="col">
            <?php
            // Verifica se a variável 'msg' está presente na URL
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];

                // Mensagem de erro correspondente ao valor da variável 'msg'
                $messages = [
                    'product_created' => 'Produto cadastrado.',
                    'product_deleted' => 'Produto deletado.',
                    'product_updated' => 'Produto atualizado.',
                    'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                    'database_error' => 'Erro no servidor.',
                    'product_update_error' => 'Erro ao atualizar produto.',
                    'product_delete_error' => 'Erro ao deletar produto'
                ];

                // Verifica se a chave 'msg' existe no array de mensagens de erro
                if (array_key_exists($msg, $messages)) {
                    // Exibe a mensagem de erro
                    if($msg=='product_created' || $msg=='product_updated'){
                        echo '<div class="alert alert-success" role="alert">' . $messages[$msg] . '</div>';
                        
                    } else {
                        echo '<div class="alert alert-warning" role="alert">' . $messages[$msg] . '</div>';
                    }
                } else {
                    // Mensagem de erro padrão caso o código de erro não seja reconhecido
                    echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
                }
            }
            ?>
        </div>
    </div>
    <!-- botões -->
    <div class="row mb-3">
        <div class="col-md-6">
            <a class="btn btn-success btn-sm mb-2" href="novo_produto.php">Novo Produto</a>
        </div>
        <div class="col-md-6">
            <form action="produtos.php" method="get">
                <div class="row">
                    <div class="col-lg-2 mb-2">
                        <button type='submit' class='btn btn-sm btn-primary '>Pesquisar</button>
                    </div>
                    <div class="col-lg-7">
                        <input type="text" class="form-control form-control-sm mb-2" id='search_name' name='search_name' placeholder="Nome">
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm mb-2" id='search_id' name='search_id' placeholder="ID">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- listagem de produtos -->
    <div class="row">
        <div class="col">
            <legend>Lista de produtos</legend>
            <?php
            if($products) {
                echo '<table class="table table-striped table-bordered table-responsive">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">ID</th>';
                echo '<th scope="col">Nome</th>';
                echo '<th scope="col">Quantidade em Estoque</th>';
                echo '<th scope="col">Preço</th>';
                echo '<th scope="col">Fornecedor</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach($products as $product) {
                    $supplier = $product->getSupplier();
                    $stock = $product->getStock();
                    echo '<tr>';
                    echo "<th scope='row'>{$product->getId()}</th>";
                    echo "<td><a href='produto.php?id={$product->getId()}'>{$product->getName()}</a></td>";
                    echo "<td>{$stock->getQuantity()}</td>";
                    echo "<td>R$ {$stock->getPrice()}</td>";
                    echo "<td>{$supplier->getName()}</td>";
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Nenhum produto encontrado';
            }
            ?>
        </div>
    </div>
</div >
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
