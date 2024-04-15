<?php

include_once('AddressDao.php');
include_once('PostgresDao.php');
// include_once(realpath('model/Address.php'));

class PostgresAddressDao extends PostgresDao implements AddressDao {

    private $table_name = 'addresses';
    
    public function insert($address) {

        $query = "INSERT INTO " . $this->table_name . 
        " (street, number, complement, neighborhood, zip_code, city, state) VALUES" .
        " (:street, :number, :complement, :neighborhood, :zip_code, :city, :state)";

        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindValue(":street", $address->getStreet());
        $stmt->bindValue(":number", $address->getNumber());
        $stmt->bindValue(":complement", $address->getComplement());
        $stmt->bindValue(":neighborhood", $address->getNeighborhood());
        $stmt->bindValue(":zip_code", $address->getZipCode());
        $stmt->bindValue(":city", $address->getCity());
        $stmt->bindValue(":state", $address->getState());

        if($stmt->execute()){
            return $this->conn->lastInsertId();
        } else {
            return null;
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

    public function remove($address) {
        return $this->removeById($address->getId());
    }

    public function update(&$address) {

        $query = "UPDATE " . $this->table_name . 
        " SET street = :street, number = :number, complement = :complement, neighborhood = :neighborhood, zip_code = :zip_code, city = :city, state = :state" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":street", $address->getStreet());
        $stmt->bindValue(":number", $address->getNumber());
        $stmt->bindValue(":complement", $address->getComplement());
        $stmt->bindValue(":neighborhood", $address->getNeighborhood());
        $stmt->bindValue(":zip_code", $address->getZipCode());
        $stmt->bindValue(":city", $address->getCity());
        $stmt->bindValue(":state", $address->getState());
        $stmt->bindValue(':id', $address->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function getById($id) {
        
        $address = null;

        $query = "SELECT
                    id, street, number, complement, neighborhood, zip_code, city, state
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
            $address = new Address($row['id'], $row['street'], $row['number'], $row['complement'], $row['neighborhood'], $row['zip_code'], $row['city'], $row['state']);
        } 
     
        return $address;
    }

    public function getByZipCode($zip_code) {

        $address = null;

        $query = "SELECT
                    id, street, number, complement, neighborhood, zip_code, city, state
                FROM
                    " . $this->table_name . "
                WHERE
                    zip_code = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $zip_code);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $address = new Address($row['id'], $row['street'], $row['number'], $row['complement'], $row['neighborhood'], $row['zip_code'], $row['city'], $row['state']);
        } 
     
        return $address;
    }

    public function getAll() {

        $addresses = array();

        $query = "SELECT
                    id, street, number, complement, neighborhood, zip_code, city, state
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $addresses[] = new Address($id, $street, $number, $complement, $neighborhood, $zip_code, $city, $state);
        }
        
        return $addresses;
    }
}
?>
