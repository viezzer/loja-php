<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getOrderDao();

$request_method = $_SERVER["REQUEST_METHOD"];
	
switch ($request_method) {
    // Busca todos os pedidos ou um pedido específico
    case 'GET':
        $order_number = intval(@$_GET["order_number"]);
        $client_name = @$_GET['client_name'];
        // var_dump($order_number, $client_name);
        if(isset($order_number) && $order_number>0) {
            $order = $dao->getOrderByNumber($order_number);
            echo $order;
            http_response_code(200); // 200 OK
            exit;
        } else {
            $orders = $dao->getAllBySearchedInputs($client_name, $order_number);
            // var_dump($orders);
            // exit();
            if ($orders != null) {
                // var_dump($orders);
                echo json_encode($orders);
                http_response_code(200); // 200 OK
                exit();
            } else {
                http_response_code(404); // 404 Not Found
            }
        }
        
        break;
        
    case 'POST':
        // Insere um novo pedido
        try {
            // obtem json
            $data = json_decode(file_get_contents('php://input'), true);

            // valida se foi recebido id do cliente
            if(!isset($data["client_id"])) {
                http_response_code(400); // 400 Bad Request
                echo json_encode(array("message" => "Nenhum id de cliente fornecido."));
                
                exit();
            }
            // define variáveis para criar pedido
            $order_date = date('Y-m-d'); // Data atual no formato 'yyyy-mm-dd'
            $delivery_date = date('Y-m-d', strtotime($order_date. ' + 5 days')); // Data de entrega 5 dias à frente
            $status = 'NOVO';
            //cria objeto do pedido
            $order = new Order(null, null, $order_date, $delivery_date, $status, $data["client_id"], null);
            // var_dump($order);
            // exit;
            // Chama o método validate() para verificar a validade dos dados
            if (!$order->validate()) {
                http_response_code(400); // 400 Bad Request
                echo json_encode(array("message" => "Dados inválidos."));
                exit();
            } 
            // Se a validação for bem-sucedida, insere o pedido
            $dao->insert($order);
            http_response_code(201); // 201 Created
        } catch (Exception $e)  {
            // Se a validação falhar, retorna um erro
            http_response_code(400); // 400 Bad Request
            echo json_encode(array("message" => "Dados fornecidos são inválidos.", "error" => $e));
            // echo json_encode(array("message" => $e->getMessage()));
        }
        break;
        
    case 'PUT':
        // Atualiza um pedido existente
        // if (!empty($_GET["id"])) {
        //     $id = intval($_GET["id"]);
        //     $order = $dao->getById($id);
        //     if ($order != null) {
        //         $data = json_decode(file_get_contents('php://input'), true);
        //         $order->setNumber($data["number"]);
        //         $order->setOrderDate($data["order_date"]);
        //         $order->setDeliveryDate($data["delivery_date"]);
        //         $order->setStatus($data["status"]);
        //         $order->setClientId($data["client_id"]);
        //         $dao->update($order);
        //         http_response_code(200); // 200 OK
        //     } else {
        //         http_response_code(404); // 404 Not Found
        //     }
        // }
        break;
        
    case 'DELETE':
        // Remove um pedido existente pelo ID
        // if (!empty($_GET["id"])) {
        //     $id = intval($_GET["id"]);
        //     $dao->removeById($id);
        //     http_response_code(204); // 204 No Content
        // }
        break;
        
    default:
        // Método de requisição inválido
        http_response_code(405); // 405 Method Not Allowed
        break;
}
?>
