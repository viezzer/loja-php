<?php
include_once "fachada.php";

if(isset($_GET['id'])) {
    $userDao = $factory->getUserDao();
    if(!$userDao->removeById($_GET['id'])) {
        header("Location: usuarios.php?msg=user_delete_error");
    }
    header("Location: usuarios.php?msg=user_deleted");
} else {
    echo 'sem id';
}