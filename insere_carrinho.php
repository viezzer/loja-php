<?php
// Include necessary files
include_once "fachada.php";
session_start();

// Check if product_id and quantity are set
if (!isset($_POST['product_id'], $_POST['quantity'])) {
    header('Location: carrinho.php');
    exit();
}

// Retrieve product_id and quantity from POST data
$product_id = $_POST['product_id'];
$quantity = intval($_POST['quantity']); // Ensure quantity is an integer

// Validate inputs (basic validation example)
if ($quantity <= 0) {
    // Handle invalid quantity (redirect or error message)
    header('Location: carrinho.php');
    exit();
}

// Instantiate ShoppingCart object
// Assuming you have a ShoppingCart class defined similar to the provided one
$shoppingCart = new ShoppingCart(null, $_SESSION['user_id'], $product_id, $quantity, null);

// Example DAO usage (you need to implement this)
$shoppingCartDao = $factory->getShoppingCartDao();
$success = $shoppingCartDao->insert($shoppingCart);

// Check if insertion was successful
if ($success) {
    // Redirect to cart or product page
    header('Location: carrinho.php');
    exit();
}?>
