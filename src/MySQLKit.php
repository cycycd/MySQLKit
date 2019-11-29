<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:21
 */
//cancel the error reporting
//error_reporting(E_ALL^E_NOTICE^E_WARNING);
namespace cycycd\MySQLKit;

class MySQLKit
{
    use MySQLKitCore;
    private $HOST, $USER, $PASS;
    private static $instance;

    /**
     * MySQLHandler constructor.
     */
    private function __construct()
    {
        //cancel construct
    }

    private function __clone()
    {
        //cancel clone method
    }

    //Singleton Pattern
    public static function getInstance(): self
    {
        new Table("sss");
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**@deprecated replace by getInstance()
     * @return mixed
     */
    public function getLink()
    {
        return $this->SQL_LINK;
    }
    //mean like function name
    public function getConnectStatus()
    {
        if ($this->SQL_LINK!=null&&mysqli_get_connection_stats($this->SQL_LINK)) {
            return true;
        } else {
            return false;
        }
    }

    //only use after connect
    public function setDB($db_name)
    {
        if ($this->SQL_LINK == null || !$this->getConnectStatus()) {
            return false;
        }
        $result = mysqli_select_db($this->SQL_LINK, $db_name);
        return $result;
    }

    public function setHost($HOST)
    {
        $this->HOST = $HOST;
        return $this;
    }

    public function setUser($USER)
    {
        $this->USER = $USER;
        return $this;
    }
    public function setPass($PASS)
    {
        $this->PASS = $PASS;
        return $this;
    }
    //setHost+setUser+setPass
    public function setHUP($host, $user, $pass)
    {
        $this->setHost($host)->setUser($user)->setPass($pass);
        return $this;
    }
    //dis old connect start new connect
    public function connect()
    {
        if ($this->SQL_LINK != null) {
            mysqli_close($this->SQL_LINK);
        }
        $this->SQL_LINK = mysqli_connect($this->HOST, $this->USER, $this->PASS);
        if ($this->SQL_LINK) {
            //default utf-8
            mysqli_query($this->SQL_LINK, "set names utf8");
        }
        return $this;
    }


    /**
     * @param $DBName
     * @param bool $setThis
     * @return bool
     */
    function createDB($DBName, $setThis = true)
    {
        $SQL_CODE = "CREATE DATABASE if not exists " . $DBName;
        $res = mysqli_query($this->SQL_LINK, $SQL_CODE);
        if ($setThis) {
            $this->setDB($DBName);
        }
        return $res;
    }
    function createTable(Table $table)
    {
        return $this->execute((string)$table);
    }
    function getTable($name):Table
    {
        if($this->searchExist("show tables like '$name'"))
        {
            $table_struct=$this->search("desc $name");
            $table=new Table($name,false);
            $table->initStruct($table_struct);
            $table->setLink($this->SQL_LINK);
            return $table;
        }
        else
        {
            return null;
        }
        //TODO
    }
    /**
     * @deprecated deprecated function replace with connect()
     * */
    public function update()
    {
        $this->connect();
    }
}
