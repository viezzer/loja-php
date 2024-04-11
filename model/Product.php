<?php
class Product {
    
    private $id;
    private $name;
    private $description;
    private $supplier_id;
    // private $image;

    public function __construct($id, $name, $description, $supplier_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->supplier_id = $supplier_id;
        // $this->image = $image;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    // public function getImage() { return $this->image; }
    public function getSupplierId() { return $this->supplier_id; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    // public function setImage($image) { $this->image = $image; }
    public function setSupplierId($supplier_id) { $this->supplier_id = $supplier_id; }
}