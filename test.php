<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:34
 */
require_once("TableKit.php");
$tablekit=new TableKit();
$tablekit->setName("testtable");
$tablekit->addElement("id char(20) primary key")
    ->addElement("name char(1)");
$str=$tablekit->get();
echo $str;