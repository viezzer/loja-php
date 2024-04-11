<?php
$page_title = "Autenticação Obrigatória";

// layout do cabeçalho
include_once "layout/layout_header.php";
?>
<div class="container py-4">
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
