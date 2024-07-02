<?php
session_start();


$config = require_once('./dao/db_config.php');


extract($config);

try {

    $db = new PDO("pgsql:host=$host;port=$port;dbname=$db_name", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (!empty($_SESSION['cart'])) {

        $order_date = date('Y-m-d');


        $stmt = $db->prepare("INSERT INTO orders (order_date, status, client_id) VALUES (:order_date, 'NOVO', :client_id)");


        $client_id = $_SESSION['user_id']; 

        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':client_id', $client_id);
        

        if ($stmt->execute()) {

            $order_id = $db->lastInsertId('orders_id_seq');


            $stmtItems = $db->prepare("INSERT INTO order_items (quantity, price, order_id, product_id) VALUES (:quantity, :price, :order_id, :product_id)");


            foreach ($_SESSION['cart'] as $item) {
                $stmtItems->bindParam(':quantity', $item['quantity']);
                $stmtItems->bindParam(':price', $item['price']);
                $stmtItems->bindParam(':order_id', $order_id);
                $stmtItems->bindParam(':product_id', $item['id']);
                $stmtItems->execute();
            }


            unset($_SESSION['cart']);


            header('Location: sucesso.php');
            exit;
        } else {

            echo "Erro ao finalizar a compra. Por favor, tente novamente.";
        }
    } else {

        echo "Seu carrinho está vazio. Adicione itens antes de finalizar a compra.";
    }
} catch (PDOException $e) {

    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
}
?>
