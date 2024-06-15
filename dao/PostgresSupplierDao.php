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

            if ($address_id === null) {
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
        $address = $supplier->getAddress();
        $query = "UPDATE " . $this->table_name . 
        " SET name = :name, description = :description, phone = :phone, email = :email, address_id = :address_id" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":name", $supplier->getName());
        $stmt->bindValue(":description", $supplier->getDescription());
        $stmt->bindValue(":phone", $supplier->getPhone());
        $stmt->bindValue(":email", $supplier->getEmail());
        $stmt->bindValue(":address_id", $address->getId());
        $stmt->bindValue(':id', $supplier->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function getById($id) {
        
        $supplier = null;

        $query = "SELECT s.id, s.name, s.description, s.phone, s.email, a.id as aid, a.street, a.number, a.complement, a.neighborhood, a.zip_code, a.city,a.state	
                    FROM ".$this->table_name." as s
                    JOIN addresses as a ON a.id=s.address_id 
                    WHERE s.id = ?
                    LIMIT 1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $address = new Address(
                $row['aid'],
                $row['street'],
                $row['number'],
                $row['complement'],
                $row['neighborhood'],
                $row['zip_code'],
                $row['city'],
                $row['state']
            );
            $supplier = new Supplier($row['id'], $row['name'], $row['description'], $row['phone'], $row['email'], $address);
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

    public function getSuppliersOptionList() {

            $suppliers = array();
    
            $query = "SELECT
                        id, name
                    FROM
                        " . $this->table_name . 
                        " ORDER BY name ASC";
         
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $suppliers[] = new Supplier($id, $name, null, null, null, null);
            }
            
            return $suppliers;
            }

    public function getAll($search_id, $search_name, $limit, $offset) {
        $suppliers = array();

        $query = "SELECT id, 
                    name,
                    description, 
                    phone, 
                    email, 
                    address_id
                FROM " . $this->table_name ."
                where true";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND upper(name) LIKE upper('%$search_name%')";
        }
        //ordena por id crescente
        $query.= " ORDER BY id ASC";     
        $query.= " LIMIT :limit OFFSET :offset;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $suppliers[] = new Supplier($id, $name, $description, $phone, $email, $address_id);
        }
        
        return $suppliers;
    }

    public function getAllWithAddress($search_id, $search_name, $limit, $offset) {

        $suppliers = array();

        $query = "SELECT s.id, 
                    s.name,
                    s.description, 
                    s.phone, 
                    s.email, 
                    s.address_id,
                    a.street,
                    a.number,
                    a.complement,
                    a.neighborhood,
                    a.zip_code,
                    a.city,
                    a.state
                FROM " . $this->table_name . " s
                JOIN addresses a ON a.id=s.address_id
                where true";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND upper(s.name) LIKE upper('%$search_name%')";
        }
        //ordena por id crescente
        $query.= " ORDER BY id ASC";     
        $query.= " LIMIT :limit OFFSET :offset;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $address = new Address(null, $row['street'], $row['number'], $row['complement'], $row['neighborhood'], $row['zip_code'], $row['city'], $row['state'] );
            $supplier = new Supplier($row['id'], $row['name'], $row['description'], $row['phone'], $row['email'], $address );
    
            $suppliers[] = $supplier;
        }
        
        return $suppliers;
    }

    public function countAll($search_id, $search_name) {
        $query = "SELECT COUNT(*) AS total FROM $this->table_name WHERE true ";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND upper(name) LIKE upper('%$search_name%')";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

}
?>
