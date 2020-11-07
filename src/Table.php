<?php

namespace cycycd\MySQLKit;
require_once "Row.php";

class Table
{
    use MySQLKitCore;
    private $writable;
    private $SQL_LINK;

    //sql code
    private $DBName;
    private $tableName;
    private $limit;
    private $rowList;

    /**
     * Table constructor.
     * @param $name
     * @param bool $writable
     */
    public function __construct($name, $writable = true)
    {
        $this->rowList = Array();
        $this->writable = $writable;
        $this->tableName = $name;
    }
    public function append(string $row): Table
    {
        if ($this->writable) {
            array_push($this->rowList, $row);
        }
        return $this;
    }

    private function count()
    {
        return count($this->rowList);
    }

    /**
     * work for type-cast
     */
    public function __toString()
    {
        if (!empty($this->tableName) && !empty($this->rowList)) {
            return "create table if not exists " . $this->tableName . "("
                . implode(",", $this->rowList) . ")";
        }
    }

    public function initStruct(array $table_struct): void
    {
        $count = count($table_struct);
        for ($i = 0; $i < $count; $i++) {
            array_push($this->rowList, new Row($table_struct[$i]));
        }
    }

    /**
     * set area
     */
    public function setLink($SQL_LINK): void
    {
        $this->SQL_LINK = $SQL_LINK;
    }
    public function setDBName($DBName): Table
    {
        $this->DBName = $DBName;
        return $this;
    }
    function setTableName($tableName): self
    {
        if ($this->writable) {
            $this->tableName = $tableName;
        }
        return $this;
    }

    /**
     * get area
     */

    function getTableName()
    {
        return $this->tableName;
    }

    /**
     * limit area
     */
    private function clearLimit()
    {
        $this->limit = "";
    }

    public function limit(string $limit)
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * curd area
     */
    public function queryData(...$key)
    {
        //only effect once curd
        $fieldArea = "";
        if (empty($key) || in_array('*', $key)) {
            $fieldArea = "*";
        } else {
            $fieldArea = implode(",", $key);
        }
        $curd_code="SELECT ".$fieldArea." FROM $this->tableName ".(empty($this->limit)?"":" where ".$this->limit);
        $this->clearLimit();
        echo $curd_code;
        return $this->search($curd_code);
    }
    public function insertData()
    {
        //TO-DO
        //$curd_code="INSERT INTO ".$this->tableName
    }
}
