<?php
require_once "src/MySQLKit.php";
require_once "src/Table.php";
use cycycd\MySQLKit\MySQLKit;

$sql = MySQLKit::getInstance();
$sql->setHUP("localhost", "root", "")->connect();
$sql->setDB("test_db");

$sql->getTable("test_table");

