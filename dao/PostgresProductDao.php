<?php

include_once('ProductDao.php');
include_once('StockDao.php');
include_once('PostgresDao.php');
include_once('PostgresStockDao.php');
include_once('model/Product.php');
include_once('model/Stock.php');

class PostgresProductDao extends PostgresDao implements ProductDao {

    private $table_name = 'products';

    public function insert($product) {
        $supplier = $product->getSupplier();
        // Inicia a transação
        $this->conn->beginTransaction();

        try {
            // Primeiro, insere o produto
            $query = "INSERT INTO " . $this->table_name .
            " (name, description, supplier_id) VALUES" .
            " (:name, :description, :supplier_id)";
            
            $stmt = $this->conn->prepare($query);
            
            // bind values
            $stmt->bindValue(":name", $product->getName());
            $stmt->bindValue(":description", $product->getDescription());
            $stmt->bindValue(":supplier_id", $supplier->getId());

            
            // Se tudo ocorrer bem, insere estoque para o produto
            if ($stmt->execute()) {
                // Get the ID of the last inserted row
                $product_id = $this->conn->lastInsertId();
                $stock = new Stock(null,0,0,$product_id);
                
                $stockDao = new PostgresStockDao($this->conn);
                $success = $stockDao->insert($stock);
                if($success){
                    $this->conn->commit();
                    return true;
                }
                // Em caso de falha, rollback da transação
                throw new Exception("Falha ao inserir o estoque.");
            } else {
                // Em caso de falha, rollback da transação
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // Em caso de exceção, rollback da transação
            $this->conn->rollBack();
            return false;
        }

    }

    public function removeById($id) {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove($product) {
        return $this->removeById($product->getId());
    }

    public function update(&$product) {
        $stock = $product->getStock();
        $supplier = $product->getSupplier();

        $this->conn->beginTransaction();
        //atualiza informações do produto
        try {
            $query = "UPDATE " . $this->table_name .
                " SET name = :name, description = :description, supplier_id = :supplier_id" .
                " WHERE id = :id";
    
            $stmt = $this->conn->prepare($query);
    
            // bind parameters
            $stmt->bindValue(":name", $product->getName());
            $stmt->bindValue(":description", $product->getDescription());
            $stmt->bindValue(":supplier_id", $supplier->getId());
            $stmt->bindValue(":id", $product->getId());
    
            // se produto atualizar, atuliazar estoque
            if ($stmt->execute()) {
                $stockDao = new PostgresStockDao($this->conn);
                $stockWithId = $stockDao->getByProductId($product->getId());
                $stockWithId->setQuantity($stock->getQuantity());
                $stockWithId->setPrice($stock->getPrice());
                // var_dump($stockWithId);
                // exit;
                $success = $stockDao->update($stockWithId);
                if($success){
                    $this->conn->commit();
                    return true;
                }
                // Em caso de falha, rollback da transação
                throw new Exception("Falha ao inserir o estoque.");
            }else {
                // Em caso de falha, rollback da transação
                $this->conn->rollBack();
                throw new Exception("Falha ao inserir o produto.");
            }
        }catch(Exception $e) {
            // Em caso de exceção, rollback da transação
            $this->conn->rollBack();
            var_dump($e);
            exit;
            return false;
        }
    }

    public function getById($id) {

        $product = null;

        $query = "SELECT p.id, p.name , p.description, s.price, s.quantity, sup.id as sup_id, sup.name as sup_name" .
                 " FROM " . $this->table_name ." as p 
                 LEFT JOIN stocks as s ON s.product_id=p.id 
                 JOIN suppliers as sup ON sup.id=p.supplier_id 
                 WHERE p.id = ? 
                 LIMIT 1 
                 OFFSET 0";
                 

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $supplier = new Supplier($row['sup_id'],$row['sup_name'],null,null,null,null);
            $stock = new Stock(null,$row['quantity'], $row['price'],$row['id']);
            $product = new Product($row['id'], $row['name'], $row['description'], $supplier, $stock);
        }

        return $product;
    }

    public function getByName($name) {

        $product = null;

        $query = "SELECT id, name, description, price, quantity" .
                 " FROM " . $this->table_name .
                 " WHERE name = ? LIMIT 1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $product = new Product($row['id'], $row['name'], $row['description'], $row['price'], $row['quantity']);
        }

        return $product;
    }

    public function getAll() {

        $products = array();

        $query = "SELECT
                    p.id AS id,
                    p.name AS name,
                    p.description AS description,
                    s.quantity AS quantity,
                    s.price AS price,
                    sup.name AS supplier_name
                FROM $this->table_name p 
                LEFT JOIN stocks s ON p.id = s.product_id
                JOIN suppliers sup ON p.supplier_id = sup.id;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $supplier = new Supplier(null,$supplier_name,null,null,null,null);
            $stock = new Stock(null,$quantity,$price,$id);
            $products[] = new Product($id, $name, $description,$supplier,$stock);
        }

        return $products;
    }

    public function getAllBySearchedInputs($search_id, $search_name) {
        $products = array();

        $query = "SELECT
                    p.id AS id,
                    p.name AS name,
                    p.description AS description,
                    s.quantity AS quantity,
                    s.price AS price,
                    sup.name AS supplier_name
                FROM
                    $this->table_name p
                JOIN
                    stocks s ON p.id = s.product_id
                JOIN
                    suppliers sup ON p.supplier_id = sup.id 
                WHERE true";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND p.id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND p.name LIKE '%$search_name%'";
            // print_r($query);
            // exit;
        }
        //ordena por id crescente
        $query.= " ORDER BY p.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $supplier = new Supplier(null,$supplier_name,null,null,null,null);
            $stock = new Stock(null,$quantity,$price,$id);
            $products[] = new Product($id, $name, $description,$supplier,$stock);
        }

        return $products;
    }

}
?>
