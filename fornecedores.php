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
                        echo "<th scope='row'><a href='fornecedor.php?id={$supplier->getId()}'>{$supplier->getId()}</a></th>";
                        echo "<td>{$supplier->getName()}</td>";
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
