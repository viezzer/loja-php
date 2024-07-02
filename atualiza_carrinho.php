<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];

    // Atualiza a quantidade do produto no carrinho na sessão
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $productId) {
            $item['quantity'] = $newQuantity;
            break;
        }
    }

    // Retorna uma resposta de sucesso (opcional)
    echo json_encode(['success' => true]);
}
?>
