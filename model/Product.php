<?php
class Product {
    
    private $id;
    private $name;
    private $description;
    private $supplier;
    private $stock;
    private $image;

    public function __construct($id, $name, $description, $supplier, $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->supplier = $supplier;
        $this->stock = $stock;
        $this->image = '';
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getSupplier() { return $this->supplier; }
    public function getStock() { return $this->stock; }
    public function getImage() { return $this->image; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setSupplier($supplier) { $this->supplier = $supplier; }
    public function setStock($stock) { $this->stock = $stock; }
    public function setImage($image) { $this->image = $image; }
}