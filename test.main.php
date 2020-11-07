<?php
require_once "src/MySQLKit.php";
require_once "src/Table.php";
use cycycd\MySQLKit\MySQLKit;
$sql=MySQLKit::getInstance();
$sql->setHUP("localhost","root","");
$sql->connect();
$sql->setDB("test_db");
$table=$sql->getTable("test_table");
print_r($table->limit("id<2")->queryData("id","name"));
