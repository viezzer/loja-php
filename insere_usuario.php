<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['login'], $_POST['password'], $_POST['name'])) {
    $login = @$_POST["login"];
    $password = @$_POST["password"];
    $name = @$_POST["name"];

    // Validações adicionais
    if (empty($login) || empty($password) || empty($name)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        header("Location: novo_usuario.php?error=empty");
        exit;
    }

    // Exemplo de validação de tamanho mínimo de senha
    if (strlen($password) < 3) {
        // Se a senha for muito curta, redireciona com um erro
        header("Location: novo_usuario.php?error=password_short");
        exit;
    }
    
    // //criptografa a senha
    $password = md5($_POST["password"]);
    // Cria o objeto usuário e insere no banco de dados
    $user = new User(null,$login,$password,$name);
    $dao = $factory->getUserDao();
    $dao->insert($user);
    
    // Redireciona para a página de login
    header("Location: login.php");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: novo_usuario.php?error=missing_fields");
    exit;
}

?>