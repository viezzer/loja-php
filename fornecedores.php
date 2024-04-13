<?php
$page_title = "Fornecedores";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura fornecedores
$dao = $factory->getSupplierDao();
//verifica se existe inps de pesquisa
if(isset($_GET['search_id']) || isset($_GET['search_name'])) {

    $suppliers = $dao->getAllBySearchedInputs($_GET['search_id'], $_GET['search_name']);
} else {
    $suppliers = $dao->getAllWithAddress();
}
?>
<div class="container py-4">
    <div class="row">
        <div class="col">
        <?php
                // Verifica se a variável 'msg' está presente na URL
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];

                    // Mensagem de erro correspondente ao valor da variável 'msg'
                    $messages = [
                        'supplier_deleted' => 'Fornecedor deletado.',
                        'supplier_updated' => 'Fornecedor atualizado.',
                        'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                        'database_error' => 'Erro no servidor.',
                        'address_update_error' => 'Erro ao atualizar endereço.',
                        'supplier_update_error' => 'Erro ao atualizar Fornecedor.',
                        'supplier_delete_error' => 'Erro ao deletar fornecedor'
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
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <a class="btn btn-success btn-sm mb-2" href="novo_fornecedor.php">Novo Fornecedor</a>
        </div>
        <div class="col-md-6">
            <form action="fornecedores.php" method="get">
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
    <!-- listagem de fornecedores -->
    <div class="row">
        <div class="col">
            <legend>Lista de fornecedores</legend>
            <?php
                if($suppliers) {
                    echo '<div class="table-responsive-lg">';
                    echo '<table class="table table-hover table-striped table-bordered">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th scope="col">ID</th>';
                                echo '<th scope="col">Nome</th>';
                                echo '<th scope="col">E-mail</th>';
                                echo '<th scope="col">Telefone</th>';
                                echo '<th scope="col">Cidade</th>';
                                echo '<th scope="col">Estado</th>';
                                echo '<th scope="col">CEP</th>';
                            echo '</tr>';
                        echo '</thead>';
                    echo '<tbody>';
                    foreach($suppliers as $supplier) {
                        $address = $supplier->getAddress();
                        // echo "<a href='fornecedor.php?id={$supplier->getId()}'>";
                        echo '<tr>';
                        echo "<th scope='row'>{$supplier->getId()}</th>";
                        echo "<td><a href='fornecedor.php?id={$supplier->getId()}'>{$supplier->getName()}</a></td>";
                        echo "<td>{$supplier->getEmail()}</td>";
                        echo "<td>{$supplier->getPhone()}</td>";
                        echo "<td>{$address->getCity()}</td>";
                        echo "<td>{$address->getState()}</td>";
                        echo "<td>{$address->getZipCode()}</td>";
                        echo '</tr>';
                        // echo '</a>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo 'Nenhum fornecedor encontrado';
                }
            ?>
        </div>
    </div >
</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
