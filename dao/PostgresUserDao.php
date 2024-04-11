<?php

include_once('UserDao.php');
include_once('PostgresDao.php');
include_once(realpath('model/User.php'));

class PostgresUserDao extends PostgresDao implements UserDao {

    private $table_name = 'users';
    
    public function insert($user) {

        $query = "INSERT INTO " . $this->table_name . 
        " (login, password, name) VALUES" .
        " (:login, :password, :name)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        var_dump($user);
        $stmt->bindValue(":login", $user->getLogin());
        $stmt->bindValue(":password", md5($user->getPassword()));
        $stmt->bindValue(":name", $user->getName());

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
        $stmt->bindParam(':id', $id);

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
        $stmt->bindParam(":login", $user->getLogin());
        $stmt->bindParam(":password", md5($user->getPassword()));
        $stmt->bindParam(":name", $user->getName());
        $stmt->bindParam(':id', $user->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function getById($id) {
        
        $user = null;

        $query = "SELECT
                    id, login, name, password
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
            $user = new User($row['id'],$row['login'], $row['name'], $row['password']);
        } 
     
        return $user;
    }

    public function getByLogin($login) {

        $user = null;

        $query = "SELECT
                    id, login, name, password
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
            $user = new User($row['id'],$row['login'], $row['password'], $row['name']);
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

    public function getAll() {

        $users = array();

        $query = "SELECT
                    id, login, password, name
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $users[] = new User($id,$login,$password,$name);
        }
        
        return $users;
    }
}
?>