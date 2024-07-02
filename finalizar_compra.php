<?php
session_start();

// Include database configuration
$config = require_once('./dao/db_config.php');
extract($config);

try {
    // Connect to the database
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$db_name", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the cart is not empty
    if (!empty($_SESSION['cart'])) {
        // Get the current order date
        $order_date = date('Y-m-d');
        
        // Insert order into orders table
        $stmt = $db->prepare("INSERT INTO orders (order_date, status, client_id) VALUES (:order_date, 'NOVO', :client_id)");
        $client_id = $_SESSION['user_id']; // Assuming 'user_id' is stored in session
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':client_id', $client_id);
        
        // Execute the insert query
        if ($stmt->execute()) {
            // Retrieve the generated order ID
            $order_id = $db->lastInsertId('orders_id_seq');
            
            // Prepare statement for inserting order items
            $stmtItems = $db->prepare("INSERT INTO order_items (quantity, price, order_id, product_id) VALUES (:quantity, :price, :order_id, :product_id)");
            
            // Iterate through each item in the cart
            foreach ($_SESSION['cart'] as $item) {
                $stmtItems->bindParam(':quantity', $item['quantity']);
                $stmtItems->bindParam(':price', $item['price']);
                $stmtItems->bindParam(':order_id', $order_id);
                $stmtItems->bindParam(':product_id', $item['id']);
                
                // Execute the insert statement for each item
                if ($stmtItems->execute()) {
                    // Update product stock quantity in stocks table
                    $stmtUpdateStock = $db->prepare("UPDATE stocks SET quantity = quantity - :quantity WHERE product_id = :product_id");
                    $stmtUpdateStock->bindParam(':quantity', $item['quantity']);
                    $stmtUpdateStock->bindParam(':product_id', $item['id']);
                    $stmtUpdateStock->execute();
                } else {
                    // Handle error if item insertion fails
                    echo "Erro ao inserir itens do pedido. Por favor, tente novamente.";
                }
            }
            
            // Clear the cart after successful purchase
            unset($_SESSION['cart']);
            
            // Redirect to success page
            header('Location: sucesso.php');
            exit;
        } else {
            // Handle error if order insertion fails
            echo "Erro ao finalizar a compra. Por favor, tente novamente.";
        }
    } else {
        // Handle case where cart is empty
        echo "Seu carrinho está vazio. Adicione itens antes de finalizar a compra.";
    }
} catch (PDOException $e) {
    // Handle database connection error
    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
}
?>
