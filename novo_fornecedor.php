<?php
$page_title = "Cadastro de fornecedor";
// layout do cabeçalho
include_once(realpath("layout/layout_header.php"));
 ?>
<div class="container py-4">
    <?php
        // Verifica se a variável 'error' está presente na URL
        if (isset($_GET['error'])) {
            $error = $_GET['error'];

            // Mensagem de erro correspondente ao valor da variável 'error'
            $error_messages = [
                'empty' => 'Por favor, preencha todos os campos.',
                'invalid_email' => 'E-mail inválido.',
                'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.'
                // Adicione mais mensagens de erro conforme necessário
            ];

            // Verifica se a chave 'error' existe no array de mensagens de erro
            if (array_key_exists($error, $error_messages)) {
                // Exibe a mensagem de erro
                echo '<div class="alert alert-warning" role="alert">' . $error_messages[$error] . '</div>';
            } else {
                // Mensagem de erro padrão caso o código de erro não seja reconhecido
                echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
            }
        }
    ?>
    <form action="insere_fornecedor.php" method="post">
        <legend>Cadastro de Fornecedor</legend>
        <div class="row g-3 mb-3">
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
                <input type="text" class="form-control" id="inputStreet" >
            </div>
            <div class="col-lg-4">
                <label for="inputNeighborhood" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="inputNeighborhood">
            </div>
            <div class="col-lg-3">
                <label for="inputNumber" class="form-label">Numero</label>
                <input type="number" class="form-control" id="inputNumber" name="number">
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
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
<?php
// layout do rodapé
include_once(realpath("layout/layout_footer.php"));
?>


