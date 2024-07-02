<?php
session_start();

// Verifica se o product_id foi enviado via POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Verifica se o carrinho existe na sessão e não está vazio
    if (!empty($_SESSION['cart'])) {
        // Procura pelo item com o product_id especificado e o remove
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $product_id) {
                // Remove o item do carrinho
                unset($_SESSION['cart'][$index]);
                // Mensagem de sucesso (opcional)
                $_SESSION['success_message'] = "Item removido do carrinho com sucesso.";
            }
        }
    }
}

// Redireciona de volta para a página do carrinho
header('Location: carrinho.php');
exit;
?>
