<?php
$page_title = "Fornecedore";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura fornecedores
if(!isset($_GET['id'])) {
    header('Location: fornecedores.php');
}
$edit = 'disabled';
if(isset($_GET['edit'])) {
    $edit = $_GET['edit'];
}

$dao = $factory->getSupplierDao();
$supplier = $dao->getById($_GET['id']);
$address = $supplier->getAddress();

?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <?php
                echo "<a class='btn btn-secondary btn-sm' href='fornecedores.php'>Voltar</a>";
                if($edit=='disabled') {
                    echo "<a href='?id={$_GET['id']}&edit= ' class='btn btn-primary btn-sm mx-2'>Editar</a>";
                } else {
                    echo "<a href='excluir_fornecedor.php?id={$_GET['id']}' class='btn btn-danger btn-sm mx-2'>Excluir</a>";
                }
            ?>
        </div>
    </div>
    <!-- listagem de fornecedores -->
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
                        'address_update_error' => 'Erro ao atualizar endereço.',
                        'supplier_update_error' => 'Erro ao atualizar Fornecedor.'
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
                <form action="atualiza_fornecedor.php" method="post">
                    <legend>Cadastro de fornecedor</legend>
                    <input type="hidden" value="'.$supplier->getId().'" name="id">
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="name" value="'.$supplier->getName().'" '.$edit.'>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" value="'.$supplier->getEmail().'" '.$edit.'>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" aria-label="Descrição" name="description" '.$edit.'>'.$supplier->getDescription().'</textarea>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputPhone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="inputPhone" name="phone" value="'.$supplier->getPhone().'" '.$edit.'>
                        </div>
                        <h1 class="modal-title fs-5" id="newSupplierModal">Endereço</h1>
                        <input type="hidden" value="'.$address->getId().'" name="address_id">
                        <div class="col-lg-5">
                            <label for="inputStreet" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="inputStreet" name="street" value="'.$address->getStreet().'" '.$edit.'>
                        </div>
                        <div class="col-lg-4">
                            <label for="inputNeighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="inputNeighborhood" name="neighborhood" value="'.$address->getNeighborhood().'" '.$edit.'>
                        </div>
                        <div class="col-lg-3">
                            <label for="inputNumber" class="form-label">Numero</label>
                            <input type="number" class="form-control" id="inputNumber" name="number" value="'.$address->getNumber().'" '.$edit.'>
                        </div>
                        <div class="col-lg-5">
                            <label for="inputCity" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="inputCity" name="city" value="'.$address->getCity().'" '.$edit.'>
                        </div>
                        <div class="col-lg-4">
                            <label for="inputState" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="inputState" name="state" value="'.$address->getState().'" '.$edit.'>
                        </div>
                        <div class="col-lg-3">
                            <label for="inputZip" class="form-label">Código postal</label>
                            <input type="text" class="form-control" id="inputZip" name="zip_code" value="'.$address->getZipCode().'" '.$edit.'>
                        </div>
                        <div class="col">
                            <label for="inputComplement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="inputComplement" name="complement" value="'.$address->getComplement().'" '.$edit.'>
                        </div>
                    </div>';
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
