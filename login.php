<?php
$page_title = "Autenticação Obrigatória";

// layout do cabeçalho
include_once "layout/layout_header.php";
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
                        'invalid_credentials' => 'Credenciais inválidas.',
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
    <form action="executa_login.php" method="POST" role="form">
        <legend>Informe seu login e sua senha para entrar ou <a href="novo_usuario.php">crie uma conta</a></legend>
        <div class="mb-3 ">
            <label for="login" class='form-label'>Login</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Informe o Login">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Informe a senha">
        </div>  
        <button type="submit" class="btn btn-primary">OK</button>
    </form>
</div >
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
