<?php
$page_title = "Fornecedores";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura fornecedores
$dao = $factory->getSupplierDao();
$suppliers = $dao->getAllWithAddress();

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
                        'supplier_updated' => 'Fornecedor atualizado.',
                        'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                        'database_error' => 'Erro no servidor.',
                        'address_update_error' => 'Erro ao atualizar endereço.',
                        'supplier_update_error' => 'Erro ao atualizar Fornecedor.'
                    ];

                    // Verifica se a chave 'msg' existe no array de mensagens de erro
                    if (array_key_exists($msg, $messages)) {
                        // Exibe a mensagem de erro
                        echo '<div class="alert alert-succsess" role="alert">' . $messages[$msg] . '</div>';
                    } else {
                        // Mensagem de erro padrão caso o código de erro não seja reconhecido
                        echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
                    }
                }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <a class="btn btn-success btn-sm" href="novo_fornecedor.php">Novo Fornecedor</a>
        </div>
    </div>
    <!-- listagem de fornecedores -->
    <div class="row">
        <div class="col">
            <legend>Lista de fornecedores</legend>
            <?php
                if($suppliers) {
                    echo '<table class="table table-hover table-striped table-bordered table-responsive">';
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
