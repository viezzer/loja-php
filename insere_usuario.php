<?php
include_once "fachada.php";

$login = @$_POST["login"];
$password = @$_POST["password"];
$name = @$_POST["name"];

$user = new User(null,$login,$password,$name);
$dao = $factory->getUserDao();
$dao->insert($user);

header("Location: login.php");
exit;

?>