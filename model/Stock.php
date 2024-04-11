<?php
class Stock {
    
    private $id;
    private $quantity;
    private $price;
    private $product_id;

    public function __construct($id, $quantity, $price, $product_id)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->product_id = $product_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getQuantity() { return $this->quantity; }
    public function getPrice() { return $this->price; }
    public function getProductId() { return $this->product_id; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setPrice($price) { $this->price = $price; }
    public function setProductId($product_id) { $this->product_id = $product_id; }
}
