<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getOrderDao();

$request_method = $_SERVER["REQUEST_METHOD"];
	
switch ($request_method) {
    case 'GET':
        // Busca todos os pedidos ou um pedido específico pelo ID
        $number = intval(@$_GET["searched_number"]);
        $client_id = @$_GET['searched_client_id'];
        $orders = $dao->getAllBySearchedInputsJSON($client_id, $number);
        if ($orders != null) {
            // var_dump($orders);
            echo json_encode($orders);
            http_response_code(200); // 200 OK
        } else {
            http_response_code(404); // 404 Not Found
        }
        
        break;
        
    case 'POST':
        // Insere um novo pedido
        $data = json_decode(file_get_contents('php://input'), true);
        $number = $data["number"];
        $orderDate = $data["order_date"];
        $deliveryDate = $data["delivery_date"];
        $status = $data["status"];
        $clientId = $data["client_id"];
        $order = new Order(null, $number, $orderDate, $deliveryDate, $status, $clientId);
        $dao->insert($order);
        http_response_code(201); // 201 Created
        break;
        
    case 'PUT':
        // Atualiza um pedido existente
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $order = $dao->getById($id);
            if ($order != null) {
                $data = json_decode(file_get_contents('php://input'), true);
                $order->setNumber($data["number"]);
                $order->setOrderDate($data["order_date"]);
                $order->setDeliveryDate($data["delivery_date"]);
                $order->setStatus($data["status"]);
                $order->setClientId($data["client_id"]);
                $dao->update($order);
                http_response_code(200); // 200 OK
            } else {
                http_response_code(404); // 404 Not Found
            }
        }
        break;
        
    case 'DELETE':
        // Remove um pedido existente pelo ID
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $dao->removeById($id);
            http_response_code(204); // 204 No Content
        }
        break;
        
    default:
        // Método de requisição inválido
        http_response_code(405); // 405 Method Not Allowed
        break;
}
?>
