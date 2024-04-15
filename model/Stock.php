<?php
class Stock {
    
    private $id;
    private $quantity;
    private $price;
    private $product;

    public function __construct($id, $quantity, $price, $product)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->product = $product;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getQuantity() { return $this->quantity; }
    public function getPrice() { return $this->price; }
    public function getProductId() { return $this->product; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setPrice($price) { $this->price = $price; }
    public function setProductId($product) { $this->product = $product; }
}
