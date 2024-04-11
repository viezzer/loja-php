<?php
$page_title = "Fornecedores";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura usuarios
$dao = $factory->getSupplierDao();
$suppliers = $dao->getAll();

?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <!-- Modal Trigger -->
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#newSupplierModal">
                Novo Fornecedor
            </button>
            <!-- Modal -->
            <div class="modal fade" id="newSupplierModal" tabindex="-1" aria-labelledby="newSupplierModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="newSupplierModal">Novo Fornecedor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
                if($suppliers) {
                    echo '<table class="table table-striped table-bordered table-responsive">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th scope="col">ID</th>';
                                echo '<th scope="col">Nome</th>';
                                echo '<th scope="col">E-mail</th>';
                            echo '</tr>';
                        echo '</thead>';
                    echo '<tbody>';
                    foreach($suppliers as $supplier) {
                        echo '<tr>';
                        echo "<th scope='row'>{$supplier->getId()}</th>";
                        echo "<td>{$supplier->getName()}</td>";
                        echo "<td>{$supplier->getEmail()}</td>";
                        echo '</tr>';
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
