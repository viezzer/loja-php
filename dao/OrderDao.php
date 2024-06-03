<?php
interface OrderDao {

    public function insert($order);
    public function update(&$order);
    public function getByClientName($client_name);
    public function getByNumber($number);
    public function getAll();
}
?>