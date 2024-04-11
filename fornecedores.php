<?php
$page_title = "Fornecedores";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura fornecedores
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
            <div class="modal fade modal-lg" id="newSupplierModal" tabindex="-1" aria-labelledby="newSupplierModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method='post'>
                            <!-- Cabecalho do modal -->
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="newSupplierModal">Cadastro de Fornecedor</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Corpo do modal -->
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label for="inputName" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="inputName" name='name'>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" name="email">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control" aria-label="Descrição" name='descricao'></textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputPhone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control" id="inputPhone" name='phone'>
                                    </div>
                                    <h1 class="modal-title fs-5" id="newSupplierModal">Endereço</h1>
                                    <div class="col-lg-5">
                                        <label for="inputStreet" class="form-label">Rua</label>
                                        <input type="text" class="form-control" id="inputStreet" placeholder="1234 Main St" name="street">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="inputNeighborhood" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="inputNeighborhood" placeholder="1234 Main St" name="neighborhood">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="inputNumber" class="form-label">Numero</label>
                                        <input type="number" class="form-control" id="inputNumber" placeholder="Apartment, studio, or floor" name="number">
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="inputCity" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="inputCity" name="city">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="inputState" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="inputState" name="state">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="inputZip" class="form-label">Código postal</label>
                                        <input type="text" class="form-control" id="inputZip" name="zip_code">
                                    </div>
                                </div>
                            </div>
                            <!-- Rodapé do modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- listagem de fornecedores -->
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
