<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getOrderDao();

$request_method = $_SERVER["REQUEST_METHOD"];
	
switch ($request_method) {
    // Busca todos os pedidos ou um pedido específico pelo seu número
    case 'GET':
        $order_number = intval(@$_GET["order_number"]);
        $client_name = @$_GET['client_name'];
        // se existe order_number, procura o pedido com o número informado
        if(isset($order_number) && $order_number>0) {
            $order = $dao->getOrderByNumber($order_number);
            echo json_encode($order);
            http_response_code(200); // 200 OK
            exit;
        } else {
            // busca todos pedidos com base nos fitros
            $orders = $dao->getAllBySearchedInputs($client_name, $order_number);
            if ($orders != null) {
                // var_dump($orders);
                echo json_encode($orders);
                http_response_code(200); // 200 OK
                exit;
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
            // valida se foi recebido id do cliente e os itens do pedido
            if(!isset($data["client_id"])) {
                http_response_code(400); // 400 Bad Request
                echo json_encode(array("message" => "Nenhum id de cliente fornecido."));
                exit;
            }
            if(!isset($data['items'])) {
                http_response_code(400);
                echo json_encode(array("message" => "Nenhum item fornecido."));
            }

            //cria objeto do pedido
            $order = new Order(null, null, null, null, null, null, null);
            // cria objeto cliente
            $client = new User($data["client_id"],null,null,null,null);
            //insere cliente e itens no objeto pedido
            $order->setClient($client);
            $order->setItems($data['items']);
            // var_dump($order);
            // exit;
            // Chama o método validate() para validar os dados
            if (!$order->validate()) {
                http_response_code(400); // 400 Bad Request
                echo json_encode(array("message" => "Dados inválidos."));
                exit;
            } 
            // Se a validação for bem-sucedida, insere o pedido
            try {
                $dao->insert($order);
                http_response_code(201); // 201 Created
                
            } catch( Exception $e) {
                echo $e->getMessage();
            }
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
