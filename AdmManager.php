<?php
/**
 * Created by PhpStorm.
 * User: cycycd
 * Date: 2018/9/12
 * Time: 16:25
 */
class AdmManager
{
    private $SQL_LINK;
    private $connect_status;
    private $user,$pass,$host;
    //must use root account

    /**
     * TO-DO
     * @param $host string localhost
     * @param $name string sql username
     * @param $pass string sql pass
     */
    public function __construct($host,$name,$pass)
    {

        if (func_num_args()==3) {
            $this->SQL_LINK = mysqli_connect($host, $name, $pass);
            if($this->SQL_LINK)
            {
                $this->connect_status = true;
            }
            else
            {
                $this->connect_status = false;
            }
        }
    }
    /**
     * @param $user
     * @param $pass
     * @param $host
     * @return AdmManager
     * create admin on mysql
     *
     */
    public function create($user,$pass,$host)
    {
        mysqli_query($this->SQL_LINK, "CREATE USER '$user'@'$host' IDENTIFIED BY '$pass'");
        $this->user=$user;
        $this->pass=$pass;
        $this->host=$host;
        return $this;
    }
    public function getConnectStatus()
    {
        return $this->connect_status;
    }

    /**
     * give permission to account
     * @param $permission /what u need add
     * @param $db_name
     * @param $table_name
     */
    public function setPermission($permission,$db_name,$table_name)
    {
        mysqli_query($this->SQL_LINK,"GRANT $permission ON $db_name.$table_name TO '$this->user'@'$this->host'");
    }
}