<?php
class Supplier {
    
    private $id;
    private $name;
    private $description;
    private $phone;
    private $email;
    private $address_id;

    public function __construct($id, $name, $description, $phone, $email, $address_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->phone = $phone;
        $this->email = $email;
        $this->address_id = $address_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPhone() { return $this->phone; }
    public function getEmail() { return $this->email; }
    public function getAddressId() { return $this->address_id; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setEmail($email) { $this->email = $email; }
    public function setAddressId($address_id) { $this->address_id = $address_id; }
}
