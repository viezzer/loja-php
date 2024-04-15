<?php

include_once('StockDao.php');
include_once('PostgresDao.php');
include_once('model/Stock.php');

class PostgresStockDao extends PostgresDao implements StockDao {

    private $table_name = 'stocks';

    public function insert($stock) {
        $query = "INSERT INTO " . $this->table_name .
            " (quantity, price, product_id) VALUES" .
            " (:quantity, :price, :product_id)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindValue(":quantity", $stock->getQuantity());
        $stmt->bindValue(":price", $stock->getPrice());
        $stmt->bindValue(":product_id", $stock->getProductId());

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function removeById($id) {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove($stock) {
        return $this->removeById($stock->getId());
    }

    public function update(&$stock) {
        $query = "UPDATE " . $this->table_name .
            " SET quantity = :quantity, price = :price" .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindValue(":quantity", $stock->getQuantity());
        $stmt->bindValue(":price", $stock->getPrice());
        $stmt->bindValue(':id', $stock->getId());

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getById($id) {
        $query = "SELECT id, quantity, price, product_id" .
            " FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);

        // Execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $stock = new Stock($row['id'], $row['quantity'], $row['price'], $row['product_id']);
            return $stock;
        }

        return null;
    }

    public function getByProductId($product_id) {
        $query = "SELECT id, quantity, price, product_id" .
            " FROM " . $this->table_name .
            " WHERE product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindValue(':product_id', $product_id);

        // Execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $stock = new Stock($row['id'], $row['quantity'], $row['price'], null);
            return $stock;
        }

        return null;
    }

    public function getAll() {
        $stocks = array();

        $query = "SELECT id, quantity, price, product_id" .
            " FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $stock = new Stock($id, $quantity, $price, $product_id);
            $stocks[] = $stock;
        }

        return $stocks;
    }
}
?>
