<?php

include_once('SupplierDao.php');
include_once('PostgresDao.php');
include_once('model/Supplier.php');
// include_once(realpath('model/Address.php'));

class PostgresSupplierDao extends PostgresDao implements SupplierDao {

    private $table_name = 'suppliers';
    
    public function insert($supplier) {

        // Inicia a transação
        $this->conn->beginTransaction(); 

        try {
            // Primeiro, insere o endereço
            $addressDao = new PostgresAddressDao($this->conn);
            $address_id = $addressDao->insert($supplier->getAddress());

            if ($address_id === false) {
                throw new Exception("Falha ao inserir o endereço.");
            }

            // Com o ID do endereço obtido, insere o fornecedor
            $query = "INSERT INTO " . $this->table_name . 
            " (name, description, phone, email, address_id) VALUES" .
            " (:name, :description, :phone, :email, :address_id)";

            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindValue(":name", $supplier->getName());
            $stmt->bindValue(":description", $supplier->getDescription());
            $stmt->bindValue(":phone", $supplier->getPhone());
            $stmt->bindValue(":email", $supplier->getEmail());
            $stmt->bindValue(":address_id", $address_id);

            if($stmt->execute()){
                // Se tudo ocorrer bem, commita a transação
                $this->conn->commit();
                return true;
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
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($supplier) {
        return $this->removeById($supplier->getId());
    }

    public function update(&$supplier) {

        $query = "UPDATE " . $this->table_name . 
        " SET name = :name, description = :description, phone = :phone, email = :email, address_id = :address_id" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":name", $supplier->getName());
        $stmt->bindParam(":description", $supplier->getDescription());
        $stmt->bindParam(":phone", $supplier->getPhone());
        $stmt->bindParam(":email", $supplier->getEmail());
        $stmt->bindParam(":address_id", $supplier->getAddressId());
        $stmt->bindParam(':id', $supplier->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function getById($id) {
        
        $supplier = null;

        $query = "SELECT
                    id, name, description, phone, email, address_id
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $supplier = new Supplier($row['id'], $row['name'], $row['description'], $row['phone'], $row['email'], $row['address_id']);
        } 
     
        return $supplier;
    }

    public function getByName($name) {

        $supplier = null;

        $query = "SELECT
                    id, name, description, phone, email, address_id
                FROM
                    " . $this->table_name . "
                WHERE
                    name = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $supplier = new Supplier($row['id'], $row['name'], $row['description'], $row['phone'], $row['email'], $row['address_id']);
        } 
     
        return $supplier;
    }

    public function getAll() {

        $suppliers = array();

        $query = "SELECT
                    id, name, description, phone, email, address_id
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $suppliers[] = new Supplier($id, $name, $description, $phone, $email, $address_id);
        }
        
        return $suppliers;
    }

    public function getAllWithAddress() {

        $suppliers = array();

        $query = "SELECT s.id, s.name, s.description, s.phone, s.email, a.street, a.number, a.complement, a.neighborhood, a.zip_code, a.city,a.state	
                    FROM ".$this->table_name." as s
                    JOIN addresses as a ON a.id=s.address_id 
                    ORDER BY s.id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $address = new Address(
                null,
                $row['street'],
                $row['number'],
                $row['complement'],
                $row['neighborhood'],
                $row['zip_code'],
                $row['city'],
                $row['state']
            );
            // var_dump($address);
            // exit;
            $supplier = new Supplier(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['phone'],
                $row['email'],
                $address
            );
    
            $suppliers[] = $supplier;
        }
        
        return $suppliers;
    }
}
?>
