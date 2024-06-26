<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['login'], $_POST['password'], $_POST['name'])) {
    $login = @$_POST["login"];
    $password = @$_POST["password"];
    $name = @$_POST["name"];
    $role = @$_POST['role'];
    if(!isset($role)) {
        $role = 'client';
    }
    // Validações adicionais
    if (empty($login) || empty($password) || empty($name) || empty($role)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        header("Location: novo_usuario.php?error=empty");
        exit;
    }

    if (strlen($password) < 3) {
        // Se a senha for muito curta, redireciona com um erro
        header("Location: novo_usuario.php?error=password_short");
        exit;
    }

    $dao = $factory->getUserDao();
    if($dao->getByLogin($login)) {
        // Se ja existe usuário com este login, redireciona para o formulário
        header("Location: novo_usuario.php?error=login_already_in_use");
        exit;
    }

    
    
    // //criptografa a senha
    $password = md5($_POST["password"]);
    // Cria o objeto usuário e insere no banco de dados
    $user = new User(null,$login,$password,$name,$role);

    if($dao->insert($user)) {
        if($_SESSION['user_role'] == 'admin') {
            header("Location: usuarios.php");
            exit;
        }
        // Redireciona para a página de login
        header("Location: login.php");
        exit;

    }
    echo 'redirecionar para página de cadastro com mensagem de erro que login ja existe';

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: novo_usuario.php?error=missing_fields");
    exit;
}

?>