<?php

include_once('DaoFactory.php');
include_once('PostgresUserDao.php');
include_once('PostgresSupplierDao.php');
include_once('PostgresAddressDao.php');
include_once('PostgresProductDao.php');
include_once('PostgresOrderDao.php');
include_once('PostgresShoppingCartDao.php');

class PostgresDaofactory extends DaoFactory {

    // specify your own database credentials
    private $config;
    public $conn;

    public function __construct() {
        $this->config = include('db_config.php');
    }
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("pgsql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['db_name']}", $this->config['username'], $this->config['password']);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function getUserDao() {
        return new PostgresUserDao($this->getConnection());
    }

    public function getSupplierDao() {
        return new PostgresSupplierDao($this->getConnection());
    }

    public function getAddressDao() {
        return new PostgresAddressDao($this->getConnection());
    }

    public function getShoppingCartDao() {
        return new PostgresShoppingCartDao($this->getConnection());
    }

    public function getProductDao() {
        return new PostgresProductDao($this->getConnection());
    }
    public function getStockDao() {
        return new PostgresStockDao($this->getConnection());
    }
    public function getOrderDao() {
        return new PostgresOrderDao($this->getConnection());
    }
}
?>