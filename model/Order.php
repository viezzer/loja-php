<?php

class Order {
    private $id;
    private $number;
    private $orderDate;
    private $deliveryDate;
    private $status;
    private $clientId;

    // Construtor
    public function __construct($id, $number, $orderDate, $deliveryDate, $status, $clientId) {
        $this->id = $id;
        $this->number = $number;
        $this->orderDate = $orderDate;
        $this->deliveryDate = $deliveryDate;
        $this->status = $status;
        $this->clientId = $clientId;
    }

    // Getters
    public function getId() {return $this->id;}

    public function getNumber() {return $this->number;}

    public function getOrderDate() {return $this->orderDate;}

    public function getDeliveryDate() {return $this->deliveryDate;}

    public function getStatus() {return $this->status;}

    public function getClientId() {return $this->clientId;}

    // Setters
    public function setId($id) {$this->id = $id;}

    public function setNumber($number) {$this->number = $number;}

    public function setOrderDate($orderDate) {$this->orderDate = $orderDate;}

    public function setDeliveryDate($deliveryDate) {$this->deliveryDate = $deliveryDate;}

    public function setStatus($status) {$this->status = $status;}

    public function setClientId($clientId) {$this->clientId = $clientId;}
}
?>
