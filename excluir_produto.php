<?php
include_once "fachada.php";

if(isset($_GET['id'])) {
    $productDao = $factory->getUserDao();
    if(!$productDao->removeById($_GET['id'])) {
        header("Location: produtos.php?msg=product_delete_error");
    }
    header("Location: produtos.php?msg=product_deleted");
} else {
    echo 'sem id';
}