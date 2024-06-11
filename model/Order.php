<?php

class Order {
    private $id;
    private $number;
    private $orderDate;
    private $deliveryDate;
    private $status;
    private $client;
    private $items;

    // Construtor
    public function __construct($id, $number, $orderDate, $deliveryDate, $status, $client, $items) {
        $this->id = $id;
        $this->number = $number;
        $this->orderDate = $orderDate;
        $this->deliveryDate = $deliveryDate;
        $this->status = $status;
        $this->client = $client;
        $this->items = $items;
    }

    // Getters
    public function getId() {return $this->id;}

    public function getNumber() {return $this->number;}

    public function getOrderDate() {return $this->orderDate;}

    public function getDeliveryDate() {return $this->deliveryDate;}

    public function getStatus() {return $this->status;}

    public function getClient() {return $this->client;}
    
    public function getItems() {return $this->items;}
    // Setters
    public function setId($id) {$this->id = $id;}

    public function setNumber($number) {$this->number = $number;}

    public function setOrderDate($orderDate) {$this->orderDate = $orderDate;}

    public function setDeliveryDate($deliveryDate) {$this->deliveryDate = $deliveryDate;}

    public function setStatus($status) {$this->status = $status;}

    public function setClient($client) {$this->client = $client;}
    
    public function setItems($items) {$this->items = $items;}

    public function setItem($item) {$this->items[] = $item;}

    public function toJSON() {
        $data = [
            'id' => $this->id,
            'number' => $this->number,
            'orderDate' => $this->orderDate,
            'deliveryDate' => $this->deliveryDate,
            'status' => $this->status,
            'client_name' => $this->client->getName(),
            'items' => $this->items

        ];
        return $data;
    }

    public function validate() {
        // Verifica se os campos não estão vazios
        if (empty($this->orderDate) || 
            empty($this->deliveryDate) || 
            empty($this->status) || 
            empty($this->client)) {
            return false; // Dados inválidos
        }

        // Se todas as validações passarem
        return true; // Dados válidos
    }
}
?>
