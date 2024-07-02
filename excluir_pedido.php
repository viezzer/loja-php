<?php
include_once "fachada.php";

if(isset($_GET['id'])) {
    $orderDao = $factory->getOrderDao();
    if(!$orderDao->removeById($_GET['id'])) {
        header("Location: pedidos.php?msg=order_delete_error");
    }
    header("Location: pedidos.php?msg=order_deleted");
}
?>