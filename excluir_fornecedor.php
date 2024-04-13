<?php
include_once "fachada.php";

if(isset($_GET['id'])) {
    $supplierDao = $factory->getSupplierDao();
    if(!$supplierDao->removeById($_GET['id'])) {
        header("Location: fornecedores.php?msg=supplier_delete_error");
    }
    header("Location: fornecedores.php?msg=supplier_deleted");
} else {
    echo 'sem id';
}