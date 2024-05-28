<?php
class User {
    
    private $id;
    private $login;
    private $password;
    private $name;
    private $role;

    public function __construct( $id, $login, $password, $name, $role)
    {
        $this->id=$id;
        $this->login=$login;
        $this->password=$password;
        $this->name=$name;
        $this->role=$role;
    }

    public function getId() { return $this->id; }
    public function setId($id) {$this->id = $id;}

    public function getLogin() { return $this->login; }
    public function setLogin($login) {$this->login = $login;}

    public function getName() { return $this->name; }
    public function setName($name) {$this->name = $name;}

    public function getPassword() { return $this->password; }
    public function setPassword($password) {$this->password = $password;}

    public function getRole() { return $this->role; }
    public function setRole($role) {$this->role = $role;}
}
?>