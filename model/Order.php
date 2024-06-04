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

    public function toJSON() {
        $data = ['id' => $this->id, 'number' => $this->number, 'orderDate' => $this->orderDate, 'deliveryDate' => $this->deliveryDate, 'status' => $this->status, 'clientId' => $this->clientId];
        return $data;
    }

    public function validate() {
        // Verifica se os campos não estão vazios
        if (empty($this->number) || empty($this->orderDate) || 
            empty($this->deliveryDate) || empty($this->status) || 
            empty($this->clientId)) {
            return false; // Dados inválidos
        }

        // Se todas as validações passarem
        return true; // Dados válidos
    }
}
?>
