<?php
namespace cycycd\MySQLKit;
trait MySQLKitCore
{
    private $SQL_LINK;
    /**
     * search table and return all data
     * @param $sql_code
     * @return array
     */
    function query($sql_code)
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
    /**
     * search table and return first data
     * @param $sql_code
     * @return array|null
     */
    function querySingle($sql_code)
    {
        $raw = mysqli_query($this->SQL_LINK, $sql_code);
        $result = mysqli_fetch_array($raw);
        return $result;
    }
    function queryExist($sql_code)
    {
        $res = $this->querySingle($sql_code);
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
}