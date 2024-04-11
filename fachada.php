<?php

// include_once('model/User.php');
include_once('dao/UserDao.php');
include_once('dao/SupplierDao.php');
include_once('dao/DaoFactory.php');
include_once('dao/PostgresDaoFactory.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$factory = new PostgresDaofactory();

?>