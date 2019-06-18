<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:21
 */
//cancel the error reporting
//error_reporting(E_ALL^E_NOTICE^E_WARNING);
class MySQLKit
{
    private $HOST, $USER, $PASS,$DBName;
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

    //单例模式
    public static function getInstance($host,$user,$password):MySQLKit
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance=new self();
            self::$instance->setHost($host)->setUser($user)->setPass($password)->connect();
        }
        return self::$instance;
    }

    public function getLink()
    {
        return $this->SQL_LINK;
    }

    public function getConnectStatus()
    {
        if(mysqli_get_connection_stats($this->SQL_LINK))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //only use after connect
    public function setDB($db_name)
    {
        $this->DBName=$db_name;
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

    public function connect()
    {
        $this->SQL_LINK = mysqli_connect($this->HOST, $this->USER, $this->PASS);
        if($this->SQL_LINK)
        {
            //default utf-8
            mysqli_query($this->SQL_LINK, "set names utf8");
        }
    }

    /**
     * search table and return first data
     * @param $sql_code
     * @return array|null
     */
    function sql_search_once($sql_code)
    {
        $raw = mysqli_query($this->SQL_LINK,$sql_code);
        $result=mysqli_fetch_array($raw);
        return $result;
    }

    /**
     * search table and return all data
     * @param $sql_code
     * @return array
     */
    function sql_search($sql_code)
    {
        $i=0;
        $raw = mysqli_query($this->SQL_LINK,$sql_code);
        $result_all=array(array());
        if(mysqli_num_rows($raw))
        {
            while($result=mysqli_fetch_array($raw))
            {
                $result_all[$i]=$result;
                $i++;
            }
        }
        return $result_all;
    }
    function exists($sql_code)
    {
        $res=$this->sql_search_once($sql_code);
        if(empty($res))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    function createDB($DBName,$setThis=true)
    {
        $SQL_CODE="CREATE DATABASE if not exists ".$DBName." CHARACTER SET 'utf8'COLLATE 'utf8_general_ci';";
        $res=mysqli_query($this->SQL_LINK,$SQL_CODE);
        if($setThis)
        {
            $this->setDB($DBName);
        }
        return $res;
    }
    function exec($sql_code)
    {
        return mysqli_query($this->SQL_LINK,$sql_code);
    }
}