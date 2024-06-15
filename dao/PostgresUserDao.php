<?php

include_once('UserDao.php');
include_once('PostgresDao.php');
include_once(realpath('model/User.php'));

class PostgresUserDao extends PostgresDao implements UserDao {

    private $table_name = 'users';
    
    public function insert($user) {
        // tem que verificar se o login do usuário já não existe
        if($this->getByLogin($user->getLogin())!=null) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . 
        " (login, password, name, role) VALUES" .
        " (:login, :password, :name, :role)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        var_dump($user);
        $stmt->bindValue(":login", $user->getLogin());
        $stmt->bindValue(":password", $user->getPassword());
        $stmt->bindValue(":name", $user->getName());
        $stmt->bindValue(":role", $user->getRole());

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

    public function remove($user) {
        return removeById($user->getId());
    }

    public function update(&$user) {

        $query = "UPDATE " . $this->table_name . 
        " SET login = :login, password = :password, name = :name" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":login", $user->getLogin());
        $stmt->bindValue(":password", md5($user->getPassword()));
        $stmt->bindValue(":name", $user->getName());
        $stmt->bindValue(':id', $user->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function getById($id) {
        
        $user = null;

        $query = "SELECT
                    id, login, name, password, role
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
            $user = new User($row['id'],$row['login'], $row['password'], $row['name'], $row['role']);
        } 
     
        return $user;
    }

    public function getByLogin($login) {

        $user = null;

        $query = "SELECT
                    id, login, name, password, role
                FROM
                    " . $this->table_name . "
                WHERE
                    login = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $login);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $user = new User($row['id'],$row['login'], $row['password'], $row['name'], $row['role']);
        } 
     
        return $user;
    }

    /*
    public function getAll() {

        $query = "SELECT
                    id, login, senha, nome
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }
    */

    public function getAll($search_id, $search_name, $limit, $offset) {

        $users = array();

        $query = "SELECT id, 
                    login, 
                    password, 
                    name, 
                    role
                FROM " . $this->table_name ."
                where true";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND name LIKE '%$search_name%'";
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
            $users[] = new User($id,$login,$password,$name,$role);
        }
        
        return $users;
    }

    public function countAll($search_id, $search_name) {
        $query = "SELECT COUNT(*) AS total FROM $this->table_name WHERE true ";

        // verifica se input do id foi preenchido
        if(!empty($search_id)) {
            $query.= " AND id = $search_id";
        }
        // verifica se input do nome foi preenchido
        if(!empty($search_name)) {
            $query.= " AND name LIKE '%$search_name%'";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
?>