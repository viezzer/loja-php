<?php
class Address {
    
    private $id;
    private $street;
    private $number;
    private $complement;
    private $neighborhood;
    private $zip_code;
    private $city;
    private $state;

    public function __construct($id, $street, $number, $complement, $neighborhood, $zip_code, $city, $state)
    {
        $this->id = $id;
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->zip_code = $zip_code;
        $this->city = $city;
        $this->state = $state;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getStreet() { return $this->street; }
    public function getNumber() { return $this->number; }
    public function getComplement() { return $this->complement; }
    public function getNeighborhood() { return $this->neighborhood; }
    public function getZipCode() { return $this->zip_code; }
    public function getCity() { return $this->city; }
    public function getState() { return $this->state; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setStreet($street) { $this->street = $street; }
    public function setNumber($number) { $this->number = $number; }
    public function setComplement($complement) { $this->complement = $complement; }
    public function setNeighborhood($neighborhood) { $this->neighborhood = $neighborhood; }
    public function setZipCode($zip_code) { $this->zip_code = $zip_code; }
    public function setCity($city) { $this->city = $city; }
    public function setState($state) { $this->state = $state; }
}
