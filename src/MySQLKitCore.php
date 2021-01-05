<?php
namespace cycycd\MySQLKit;
class MySQLKitCore
{
    protected $SQL_LINK;
    /**
     * search table and return all data
     * @param $sql_code
     * @return array
     */
    function query($sql_code): array
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
    function querySingle($sql_code): ?array
    {
        $raw = mysqli_query($this->SQL_LINK, $sql_code);
        return mysqli_fetch_array($raw);
    }
    function queryExist($sql_code): bool
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
    function setLink($link)
    {
        $this->SQL_LINK=$link;
    }
    function getLink($link)
    {
        return $this->SQL_LINK;
    }
}