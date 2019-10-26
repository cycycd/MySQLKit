<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:34
 */
require_once("TableKit.php");
//$sql=MySQLKit::getInstance();
//$sql->update();
$tableKit=new TableKit();
$tableKit->setName("testtable")
    ->addElement("id char(20) primary key")
    ->addElement("name char(1)");
$str=$tableKit->get();
echo $str;