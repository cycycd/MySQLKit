<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:21
 */
//cancel the error reporting
//error_reporting(E_ALL^E_NOTICE^E_WARNING);
namespace MySQLKit;
class MySQLKit
{
    private $HOST, $USER, $PASS;
    private $SQL_LINK;
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
    public static function getInstance(): MySQLKit
    {
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
        if (mysqli_get_connection_stats($this->SQL_LINK)) {
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
    }
    /**
     * search table and return first data
     * @param $sql_code
     * @return array|null
     */
    function searchSingle($sql_code)
    {
        $raw = mysqli_query($this->SQL_LINK, $sql_code);
        $result = mysqli_fetch_array($raw);
        return $result;
    }
    /**
     * search table and return all data
     * @param $sql_code
     * @return array
     */
    //return result array
    function search($sql_code)
    {
        $i = 0;
        $raw = mysqli_query($this->SQL_LINK, $sql_code);
        $result_all = array();
        if (mysqli_num_rows($raw)) {
            while ($result = mysqli_fetch_array($raw)) {
                $result_all[$i] = $result;
                $i++;
            }
        }
        return $result_all;
    }

    function searchExist($sql_code)
    {
        $res = $this->searchSingle($sql_code);
        if (empty($res)) {
            return false;
        } else {
            return true;
        }
    }
    // only execute and return flag, such as delete update and so on
    function execute($sql_code)
    {
        return mysqli_query($this->SQL_LINK, $sql_code);
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
        //TODO
    }
    function getTable($name):Table
    {
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
