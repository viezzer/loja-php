<?php
$page_title = "Inserção de Usuário";
// layout do cabeçalho
include_once(realpath("layout/layout_header.php"));
 ?>
<div class="container py-4">
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


