<?php
$page_title = "Cadastro de Produto";
// layout do cabeçalho
include_once(realpath("layout/layout_header.php"));
include_once "fachada.php";

// Recupera todos os fornecedores para o campo de seleção
$dao = $factory->getSupplierDao();
$suppliers = $dao->getSuppliersOptionList();
?>

<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <a href='produtos.php' class='btn btn-sm btn-secondary'>Voltar</a>
        </div>
    </div>
    <?php
    // Verifica se a variável 'msg' está presente na URL
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];

        // Mensagem de erro correspondente ao valor da variável 'msg'
        $messages = [
            'empty' => 'Por favor, preencha todos os campos.',
            'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
            'database_error' => 'Erro no servidor.',
            'supplier_not_found' => 'Fornecedor não encontrado'
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
    <form action="insere_produto.php" method="post">
        <legend>Cadastro de Produto</legend>
        <div class="row g-3 mb-3">
            <div class="col-lg-6">
                <label for="inputName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="inputName" name="name" required>
            </div>
            <div class="col-lg-6">
                <label for="inputDescription" class="form-label">Descrição</label>
                <textarea class="form-control" id="inputDescription" name="description" rows="3" required></textarea>
            </div>
            <div class="col-lg-6">
                <label for="inputSupplier" class="form-label">Fornecedor</label>
                <select class="form-control" id="inputSupplier" name="supplier_id" required>
                    <option value="">Selecione o fornecedor</option>
                    <?php foreach ($suppliers as $supplier) : ?>
                        <option value="<?php echo $supplier->getId(); ?>"><?php echo $supplier->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

<?php
// layout do rodapé
include_once(realpath("layout/layout_footer.php"));
?>
