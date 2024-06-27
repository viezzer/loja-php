<?php

include_once('OrderDao.php');
include_once('PostgresDao.php');
include_once(realpath('model/Order.php'));

class PostgresOrderDao extends PostgresDao implements OrderDao {

    private $table_name = 'orders';
    
    public function insert($order) {
        // validar estoque de cada item do pedido
        $items = $order->getItems();
        $result = $this->verificarSaldoEstoque($items);
        // se não existe estoque envia mensagem de qual item não possui estoque
        if ($result!==true) {
            http_response_code(400);
            echo $result;
            exit;
        } 
        try {
                
            // se existe estoque insere pedido
            $this->conn->beginTransaction();
            // remove saldo do estoque
            $this->removeSaldoEstoque($items);

            $query = "INSERT INTO " . $this->table_name . 
            " (order_date, delivery_date, status, client_id) VALUES" .
            " (:order_date, :delivery_date, :status, :client_id) RETURNING id";
            
            $stmt = $this->conn->prepare($query);
            
            // bind values
            $stmt->bindValue(":order_date", $order->getOrderDate());
            $stmt->bindValue(":delivery_date", $order->getDeliveryDate());
            $stmt->bindValue(":status", $order->getStatus());
            $stmt->bindValue(":client_id", $order->getClient()->getId());
            $stmt->execute();

            // Obter o ID do pedido inserido
            $orderId = $stmt->fetchColumn();

            // Inserir itens do pedido
            $queryItem = "INSERT INTO order_items (quantity, price, order_id, product_id) 
                        VALUES (:quantity, :price, :order_id, :product_id)";
            $stmtItem = $this->conn->prepare($queryItem);

            foreach ($items as $item) {
                $stmtItem->bindValue(":quantity", $item['quantity']);
                $stmtItem->bindValue(":price", $item['price']);
                $stmtItem->bindValue(":order_id", $orderId);
                $stmtItem->bindValue(":product_id", $item['product_id']);
                $stmtItem->execute();
            }

            // Confirmar a transação
            $this->conn->commit();

            http_response_code(201);
            echo json_encode(array("message"=>"Pedido e itens inseridos com sucesso!"));
            exit;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            http_response_code(400);
            return "Erro ao inserir pedido e itens: " . $e->getMessage();
        }
    }

    public function removeSaldoEstoque($items) {
        try {
            foreach ($items as $item) {
                $query = "UPDATE stocks SET quantity = quantity - :quantity WHERE product_id = :product_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindValue(':product_id', $item['product_id'], PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    throw new Exception("Erro ao atualizar o saldo do produto ID " . $item['product_id']);
                }
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao remover saldo do estoque: " . $e->getMessage());
        }
    }

    public function verificarSaldoEstoque($items) {
        try {
            // Iterar sobre os itens
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $quantidade_desejada = $item['quantity'];
                // Consulta para obter o saldo do produto no estoque
                $stmt = $this->conn->prepare("
                    SELECT s.quantity, p.name 
                    FROM stocks s
                    JOIN products p ON s.product_id = p.id
                    WHERE s.product_id = :product_id"
                );
                $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->execute();

                // Verificar se o produto foi encontrado no estoque
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $quantidade_estoque = $result['quantity'];
                    $product_name = $result['name'];
                    // Verificar se há saldo suficiente
                    if ($quantidade_estoque < $quantidade_desejada && $quantidade_estoque>0) {
                        // Não há saldo suficiente, retorna mensagem personalizada
                        return "O produto '$product_name' possui apenas $quantidade_estoque unidades.";
                    } else {
                        return "O produto '$product_name' não possui estoque.";
                    }
                } else {
                    // Produto não encontrado no estoque
                    return "O produto com ID $product_id não foi encontrado no estoque.";
                }
            }

            // Se todos os itens tiverem saldo suficiente
            return true;
        } catch (PDOException $e) {
            // Em caso de erro, exibir mensagem
            echo 'Erro: ' . $e->getMessage();
            return false;
        }
    }


    public function removeById($id) {
        $query = "DELETE FROM " . $this->table_name . 
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(':id', $id);

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($order) {
        return $this->removeById($order->getId());
    }

    public function update(&$order) {
        $query = "UPDATE " . $this->table_name . 
        " SET number = :number, order_date = :order_date, delivery_date = :delivery_date, status = :status, client_id = :client_id" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":number", $order->getNumber());
        $stmt->bindValue(":order_date", $order->getOrderDate());
        $stmt->bindValue(":delivery_date", $order->getDeliveryDate());
        $stmt->bindValue(":status", $order->getStatus());
        $stmt->bindValue(":client_id", $order->getClientId());
        $stmt->bindValue(':id', $order->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    // public function getById($id) {
    //     $order = null;

    //     $query = "SELECT
    //                 id, number, order_date, delivery_date, status, client_id
    //             FROM
    //                 " . $this->table_name . "
    //             WHERE
    //                 id = ?
    //             LIMIT
    //                 1 OFFSET 0";
     
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(1, $id);
    //     $stmt->execute();
     
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if($row) {
    //         $order = new Order($row['id'], $row['number'], $row['order_date'], $row['delivery_date'], $row['status'], $row['client_id']);
    //     } 
     
    //     return $order;
    // }

    public function getOrderByNumber($order_number) {
        $query = "
            SELECT
                o.id AS order_id,
                o.number AS order_number,
                o.order_date,
                o.delivery_date,
                o.status,
                o.client_id,
                u.name AS client_name,
                oi.id AS item_id,
                oi.quantity,
                oi.price,
                oi.product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.image AS product_image,
                p.supplier_id AS product_supplier_id
            FROM
                orders AS o
            JOIN
                users AS u ON o.client_id = u.id
            LEFT JOIN
                order_items AS oi ON o.id = oi.order_id
            LEFT JOIN
                products AS p ON oi.product_id = p.id
            WHERE
                o.number = :order_number;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_number', $order_number, PDO::PARAM_INT);
        $stmt->execute();

        $order = null;
        $items = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order = new Order(
                $row['order_id'],
                $row['order_number'],
                $row['order_date'],
                $row['delivery_date'],
                $row['status'],
                null,
                null
            );
            $client = new User(null,null,null,$row['client_name'],null);
            $order->setClient($client);
            if ($row['item_id'] !== null) {
                $item = [
                    'item_id' => $row['item_id'],
                    'product_name' => $row['product_name'],
                    'product_description' => $row['product_description'],
                    'product_image' => $row['product_image'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'product_id' => $row['product_id']
                ];
                $items[] = $item;
            }
        }

        if ($order !== null) {
            $order->setItems($items);
            return json_encode($order->toJSON());
        }

        return null;
    }

    // public function getAll() {
    //     $orders = array();

    //     $query = "SELECT
    //                 id, number, order_date, delivery_date, status, client_id
    //             FROM
    //                 " . $this->table_name . 
    //                 " ORDER BY id ASC";
     
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //         $order = new Order($row['id'], $row['number'], $row['order_date'], $row['delivery_date'], $row['status'], $row['client_id']);
    //         $orders[] = $order;
    //     }
        
    //     return $orders;
    // }

    // public function getAllBySearchedInputs($search_client_id, $search_number) {
    //     $orders = array();

    //     $query = "SELECT id, number, order_date, delivery_date, status, client_id	
    //                 FROM ".$this->table_name." 
    //                 WHERE true";
    //     // verifica se input do id foi preenchido
    //     if(!empty($search_client_id)) {
    //         $query.= " AND id = $search_client_id";
    //     }
    //     // verifica se input do número foi preenchido
    //     if(!empty($search_number)) {
    //         $query.= " AND number LIKE '%$search_number%'";
    //     }
    //     // ordena por id crescente
    //     $query.= " ORDER BY id ASC";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
        
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $order = new Order(
    //             $row['id'],
    //             $row['number'],
    //             $row['order_date'],
    //             $row['delivery_date'],
    //             $row['status'],
    //             $row['client_id']
    //         );
    
    //         $orders[] = $order;
    //     }
        
    //     return $orders;
    // }

    public function getAllBySearchedInputs($client_name, $order_number) {
        $orders = array();
    
        $query = "SELECT o.id, o.number, o.order_date, o.delivery_date, o.status, u.name AS client_name	
            FROM ".$this->table_name." as o 
            JOIN users as u ON o.client_id = u.id
            WHERE true";
        
        // verifica se input do id foi preenchido
        if(!empty($client_name)) {
            $query.= " AND UPPER(u.name) LIKE UPPER('%$client_name%')";
        } 
        // verifica se input do número foi preenchido
        if(!empty($order_number)) {
            $query.= " AND o.number = $order_number";
        }
        // ordena por id crescente
        $query.= " ORDER BY o.number ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order_id = $row['id'];
            
            // Busca itens do pedido
            $item_query = "SELECT oi.quantity, oi.price, p.name AS product_name
                           FROM order_items as oi
                           JOIN products as p ON oi.product_id = p.id
                           WHERE oi.order_id = :order_id";
            
            $item_stmt = $this->conn->prepare($item_query);
            $item_stmt->bindParam(':order_id', $order_id);
            $item_stmt->execute();
            
            $items = array();
            while ($item_row = $item_stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[] = array(
                    'product_name' => $item_row['product_name'],
                    'quantity' => $item_row['quantity'],
                    'price' => $item_row['price']
                );
            }
    
            // Cria o objeto Order com os itens
            $order = new Order(
                $row['id'],
                $row['number'],
                $row['order_date'],
                $row['delivery_date'],
                $row['status'],
                null,
                $items // Adiciona os itens ao pedido
            );
            
            $client = new User(null, null, null, $row['client_name'], null);
            $order->setClient($client);
    
            $orders[] = $order->toJSON();
        }
    
        if (sizeof($orders) > 0) {
            return json_encode($orders);
        }
        return null;
    }
    

}
?>
