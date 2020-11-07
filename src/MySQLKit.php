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

    /**
     * get area
     */
    public static function getInstance(): self
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getLink()
    {
        return $this->SQL_LINK;
    }
    public function getConnectStatus()
    {
        if ($this->SQL_LINK != null && mysqli_get_connection_stats($this->SQL_LINK)) {
            return true;
        } else {
            return false;
        }
    }
    function getTable($name): Table
    {
        if ($this->searchExist("show tables like '$name'")) {
            //get table information
            $table_struct = $this->search("desc $name");
            $table = new Table($name, false);
            $table->initStruct($table_struct);
            $table->setLink($this->SQL_LINK);
            return $table;
        } else {
            return new Table();
        }
    }

    /**
     * set area
     */
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
    public function setHUP($host, $user, $pass)
    {
        $this->setHost($host)->setUser($user)->setPass($pass);
        return $this;
    }

    //close old connect start new connect
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

    function createTable(Table $table): bool
    {
        if (!$this->checkDBExist()) {
            return false;
        }
        return $this->execute((string)$table);
    }

    /**
     * warning: use this function carefully
     * @param $tableName
     * @return bool
     */
    function deleteTable($tableName):bool
    {
        return $this->execute("drop table if exists ".$tableName);
    }

    /**
     * @deprecated deprecated function & replace with connect()
     * */
    public function update()
    {
        $this->connect();
    }

    public function checkDBExist(): bool
    {
        $res = $this->searchSingle("select database()");
        return !empty($res[0]);
    }
}
