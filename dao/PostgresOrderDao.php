<?php

include_once('OrderDao.php');
include_once('PostgresDao.php');
include_once(realpath('model/Order.php'));

class PostgresOrderDao extends PostgresDao implements OrderDao {

    private $table_name = 'orders';
    
    public function insert($order) {
        $query = "INSERT INTO " . $this->table_name . 
        " (number, order_date, delivery_date, status, client_id) VALUES" .
        " (:number, :order_date, :delivery_date, :status, :client_id)";

        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindValue(":number", $order->getNumber());
        $stmt->bindValue(":order_date", $order->getOrderDate());
        $stmt->bindValue(":delivery_date", $order->getDeliveryDate());
        $stmt->bindValue(":status", $order->getStatus());
        $stmt->bindValue(":client_id", $order->getClientId());

        if($stmt->execute()){
            return true;
        }else{
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

    public function getById($id) {
        $order = null;

        $query = "SELECT
                    id, number, order_date, delivery_date, status, client_id
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $order = new Order($row['id'], $row['number'], $row['order_date'], $row['delivery_date'], $row['status'], $row['client_id']);
        } 
     
        return $order;
    }

    public function getByNumber($number) {
        $order = null;

        $query = "SELECT
                    id, number, order_date, delivery_date, status, client_id
                FROM
                    " . $this->table_name . "
                WHERE
                    number = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $number);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $order = new Order($row['id'], $row['number'], $row['order_date'], $row['delivery_date'], $row['status'], $row['client_id']);
        } 
     
        return $order;
    }

    public function getAll() {
        $orders = array();

        $query = "SELECT
                    id, number, order_date, delivery_date, status, client_id
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $order = new Order($row['id'], $row['number'], $row['order_date'], $row['delivery_date'], $row['status'], $row['client_id']);
            $orders[] = $order;
        }
        
        return $orders;
    }

    public function getAllBySearchedInputs($search_client_id, $search_number) {
        $orders = array();

        $query = "SELECT id, number, order_date, delivery_date, status, client_id	
                    FROM ".$this->table_name." 
                    WHERE true";
        // verifica se input do id foi preenchido
        if(!empty($search_client_id)) {
            $query.= " AND id = $search_client_id";
        }
        // verifica se input do número foi preenchido
        if(!empty($search_number)) {
            $query.= " AND number LIKE '%$search_number%'";
        }
        // ordena por id crescente
        $query.= " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order = new Order(
                $row['id'],
                $row['number'],
                $row['order_date'],
                $row['delivery_date'],
                $row['status'],
                $row['client_id']
            );
    
            $orders[] = $order;
        }
        
        return $orders;
    }

    public function getAllBySearchedInputsJSON($client_name, $order_number) {
        $orders = array();

        $query = "SELECT o.id, o.number, o.order_date, o.delivery_date, o.status, o.client_id	
            FROM ".$this->table_name." as o 
            JOIN users as u ON o.client_id = u.id
            WHERE true";
        // verifica se input do id foi preenchido
        if(!empty($client_name)) {
            $query.= " AND u.name LIKE '%$client_name%'";
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
            $order = new Order(
                $row['id'],
                $row['number'],
                $row['order_date'],
                $row['delivery_date'],
                $row['status'],
                $row['client_id']
            );
    
            $orders[] = $order->toJSON();
        }
        
        if(sizeof($orders)>0) {
            return json_encode($orders);
        }
        return null;
    }
}
?>
