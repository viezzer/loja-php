<?php
class Supplier {
    
    private $id;
    private $name;
    private $description;
    private $phone;
    private $email;
    private $address;

    public function __construct($id, $name, $description, $phone, $email, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPhone() { return $this->phone; }
    public function getEmail() { return $this->email; }
    public function getAddress() { return $this->address; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setEmail($email) { $this->email = $email; }
    public function setAddress($address) { $this->address = $address; }
}
