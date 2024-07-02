<?php
include_once "fachada.php";

if(isset($_GET['id'])) {
    $item_id = $_GET['id']; 
    $orderDao = $factory->getOrderDao();

    try {
        $result = $orderDao->setFinished($item_id);
        if ($result) {
            echo "Status do item atualizado para 'Entregue' com sucesso!";

            header("Location: pedidos_cliente.php");
            exit(); 
        } else {
            echo "Nenhum item encontrado com o ID especificado.";
        }
    } catch (Exception $e) {
        echo "Erro ao atualizar status do item: " . $e->getMessage();
    }
} else {
    echo "ID do item não especificado.";
}
?>
