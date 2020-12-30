<?php

namespace cycycd\MySQLKit;
require_once "Row.php";

class Table
{
    private $writable;
    private $SQLInstance;

    //sql code
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

    public function initStruct(array $table_struct): Table
    {
        $count = count($table_struct);
        for ($i = 0; $i < $count; $i++) {
            array_push($this->rowList, new Row($table_struct[$i]));
        }
        return $this;
    }

    /**
     * set area
     */
    public function setInstance(MySQLKit $SQLInstance): void
    {
        $this->SQLInstance=$SQLInstance;
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
        return $this->query($curd_code);
    }
    public function insertData()
    {
        //TO-DO
        //$curd_code="INSERT INTO ".$this->tableName
    }
}
