<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:34
 */
require_once("MySQLKit.php");
$handler=MySQLKit::getInstance("localhost","root","");
$res=$handler->search("show databases");
print_r($res);
//testsadasd