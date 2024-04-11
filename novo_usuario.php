<?php
$page_title = "Inserção de Usuário";
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
                'password_short' => 'A senha deve ter pelo menos 3 caracteres.',
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
    <form action="insere_usuario.php" method="post">
    <legend>Cadastro de usuário</legend>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </form>
</div>
<?php
// layout do rodapé
include_once(realpath("layout/layout_footer.php"));
?>


