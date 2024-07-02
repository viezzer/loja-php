<?php

class ShoppingCart {

    private $id;
    private $user_id;
    private $product_id;
    private $quantity;
    private $price;

    public function __construct( $id, $user_id, $product_id, $quantity, $price)
    {
        $this->id=$id;
        $this->login=$user_id;
        $this->password=$product_id;
        $this->name=$quantity;
        $this->role=$price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
?>