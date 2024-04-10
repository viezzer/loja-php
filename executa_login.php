<?php 
// Métodos de acesso ao banco de dados 
require "fachada.php"; 
 
// Inicia sessão 
session_start();

// Recupera o login 
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE; 
// Recupera a senha, a criptografando em MD5 
$password = isset($_POST["password"]) ? md5(trim($_POST["password"])) : FALSE; 
#$password = isset($_POST["password"]) ? trim($_POST["password"]) : FALSE; 

// Usuário não forneceu a password ou o login 
if(!$login || !$password) 
{ 
    echo "login = " . $login . " / senha = " . $password . "<br>";
    echo "Você deve digitar sua senha e login!<br>"; 
    echo "<a href='login.php'>Efetuar Login</a>";
    exit; 
}  

$dao = $factory->getUserDao();
$user = $dao->getByLogin($login);

var_dump($user);

$problems = FALSE;
if($user) {
    // Agora verifica a senha 
    if(!strcmp($password, $user->getPassword()))
    { 
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário 
        $_SESSION["user_id"]= $user->getId(); 
        $_SESSION["user_name"] = stripslashes($user->getName()); 
        //$_SESSION["permissao"]= $dados["postar"]; 
        header("Location: index.php"); 
        exit; 
    } else {
        $problems = TRUE; 
    }
} else {
    $problems = TRUE; 
}

if($problems==TRUE) {
    header("Location: index.php"); 
    exit; 
}
?>
