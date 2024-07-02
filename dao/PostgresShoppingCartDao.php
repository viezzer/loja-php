<?php
include_once('model/ShoppingCart.php');

class PostgresShoppingCartDao extends PostgresDao {

    private $table_name = 'shopping_cart';

    public function insert($cart_item) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Insert the cart item
            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity, price) " .
                     "VALUES (:user_id, :product_id, :quantity, :price)";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind values
            $stmt->bindValue(":user_id", $cart_item->getUserId());
            $stmt->bindValue(":product_id", $cart_item->getProductId());
            $stmt->bindValue(":quantity", $cart_item->getQuantity());
            $stmt->bindValue(":price", $cart_item->getPrice());

            // Execute query
            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // Rollback transaction on exception
            $this->conn->rollBack();
            return false;
        }
    }

    public function update($cart_item) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Update the cart item
            $query = "UPDATE " . $this->table_name . 
                     " SET quantity = :quantity, price = :price " . 
                     " WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            $stmt->bindValue(":quantity", $cart_item->getQuantity());
            $stmt->bindValue(":price", $cart_item->getPrice());
            $stmt->bindValue(":id", $cart_item->getId());

            // Execute query
            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // Rollback transaction on exception
            $this->conn->rollBack();
            return false;
        }
    }

    public function delete($id) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Delete the cart item by ID
            $query = "DELETE FROM " . $this->table_name .
                     " WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            $stmt->bindValue(":id", $id);

            // Execute query
            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // Rollback transaction on exception
            $this->conn->rollBack();
            return false;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new ShoppingCart(
                $row['id'],
                $row['user_id'],
                $row['product_id'],
                $row['quantity'],
                $row['price']
            );
        }

        return null;
    }

    public function getByUserId($user_id) {
        $carts = array();
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $carts[] = new ShoppingCart(
                $row['id'],
                $row['user_id'],
                $row['product_id'],
                $row['quantity'],
                $row['price']
            );
        }

        return $carts;
    }

    public function clearCartByUserId($user_id) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Clear cart items for a user
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":user_id", $user_id);

            // Execute query
            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // Rollback transaction on exception
            $this->conn->rollBack();
            return false;
        }
    }
}
?>
