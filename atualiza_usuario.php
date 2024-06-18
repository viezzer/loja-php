<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['id'],$_POST['name'], $_POST['login'], $_POST['user_role'])) {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $login = $_POST["login"];
    $role = $_POST["user_role"];

    // Validações adicionais
    if (empty($id) || empty($name) || empty($login) || empty($role)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        header("Location: usuario.php?msg=empty&id={$id}&edit=");
        exit;
    }
    
    // Cria o objeto usuario e atualiza no banco de dados
    $user = new User($id, $login, null, $name,$role);
    $userDao = $factory->getUserDao();
    
    // Atualiza o usuario
    if (!$userDao->update($user)) {
        header("Location: usuario.php?msg=user_update_error&id={$id}&edit=");
        exit;
    }
    
    // Redireciona para a página de listagem de usuarioes
    header("Location: usuarios.php?msg=user_updated");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: usuario.php?msg=missing_fields&id={$_POST['id']}&edit=");
    exit;
}

?>
