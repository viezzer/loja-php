<?php

include_once('OrderDao.php');
include_once('OrderItemsDao.php');
include_once('ProductDao.php');
include_once('PostgresDao.php');
include_once(realpath('model/Order.php'));

class PostgresOrderItemsDao extends PostgresDao implements OrderItemsDao {

    private $table_name = 'order_items';

    public function getItemsByOrderNumber($orderNumber) {
        
    }

}