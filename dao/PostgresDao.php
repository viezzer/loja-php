<?php
abstract class PostgresDAO {

    protected $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
} 
?>