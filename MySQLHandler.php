<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/10
 * Time: 12:21
 */
//cancel the error reporting
error_reporting(E_ALL^E_NOTICE^E_WARNING);
class MySQLHandler
{
    private $HOST, $USER, $PASS;
    private $SQL_LINK;
    private $connect_status;

    /**
     * MySQLHandler constructor.
     */
    public function __construct()
    {
        if(func_num_args()==0)
        {
            $this->connect_status = false;
        }
        elseif (func_num_args()==3)
        {
            $args = func_get_args();
            $this->SQL_LINK = mysqli_connect($args[0], $args[1], $args[2]);
            if($this->SQL_LINK)
            {
                $this->HOST = $args[0];
                $this->USER = $args[1];
                $this->PASS = $args[2];
                //default utf-8
                mysqli_query($this->SQL_LINK, "set names utf8");
                $this->connect_status = true;
            }
            else
            {
                $this->connect_status = false;
            }
        }
    }
    /**
     * @return bool
     */
    public function getConnectStatus()
    {
        return $this->connect_status;
    }

    public function setDB($db_name)
    {
        $result = mysqli_select_db($this->SQL_LINK, $db_name);
        return $result;
    }

    /**
     * @param mixed $HOST
     * @return MySQLHandler
     */
    public function setHost($HOST)
    {
        $this->HOST = $HOST;
        return $this;
    }

    /**
     * @param mixed $USER
     * @return MySQLHandler
     */
    public function setUser($USER)
    {
        $this->USER = $USER;
        return $this;
    }

    /**
     * @param mixed $PASS
     * @return MySQLHandler
     */
    public function setPass($PASS)
    {
        $this->PASS = $PASS;
        return $this;
    }

    /**
     * commit the changed link param
     * @return bool
     */
    public function connect()
    {
        $this->SQL_LINK = mysqli_connect($this->HOST, $this->USER, $this->PASS);
        if($this->SQL_LINK)
        {
            //default utf-8
            mysqli_query($this->SQL_LINK, "set names utf8");
            return $this->connect_status = true;
        }
        else
        {
            return $this->connect_status = false;
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
}