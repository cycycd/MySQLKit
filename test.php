<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:34
 */
require_once("MySQLKit.php");
$handler=new MySQLKit();
echo $handler->setHost("localhost")
    ->setUser("donate_adm")
    ->setPass("donate123")
    ->apply();
$handler->setDB("donate_db");
print_r($handler->sql_search("select * from donate_data"));
//testsadasd