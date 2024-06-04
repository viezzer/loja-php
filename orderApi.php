<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getOrderDao();

$request_method = $_SERVER["REQUEST_METHOD"];
	
switch ($request_method) {
    case 'GET':
        // Busca todos os pedidos ou um pedido específico pelo ID
        $order_number = intval(@$_GET["order_number"]);
        $client_name = @$_GET['client_name'];
        $orders = $dao->getAllBySearchedInputsJSON($client_name, $order_number);
        if ($orders != null) {
            // var_dump($orders);
            echo json_encode($orders);
            http_response_code(200); // 200 OK
        } else {
            http_response_code(404); // 404 Not Found
        }
        
        break;
        
    case 'POST':
        try {
            // Insere um novo pedido
            $data = json_decode(file_get_contents('php://input'), true);
            $order = new Order(null, $data["number"], $data["order_date"], 
                            $data["delivery_date"], $data["status"], $data["client_id"]);

            // Chama o método validate() para verificar a validade dos dados
            if ($order->validate()) {
                // Se a validação for bem-sucedida, insere o pedido
                $dao->insert($order);
                http_response_code(201); // 201 Created
            } else {
                http_response_code(400); // 400 Bad Request
                echo json_encode(array("message" => "Dados fornecidos são inválidos."));
            }

        } catch (Exception $e)  {
            // Se a validação falhar, retorna um erro
            http_response_code(400); // 400 Bad Request
            echo json_encode(array("message" => $e->getMessage()));
        }
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
