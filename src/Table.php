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

    function setTableName($tableName): self
    {
        if ($this->writable) {
            $this->tableName = $tableName;
        }
        return $this;
    }

    function getTableName()
    {
        return $this->tableName;
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

    public function initStruct($table_struct): void
    {
        $count = count($table_struct);
        for ($i = 0; $i < $count; $i++) {
            array_push($this->rowList, new Row($table_struct[$i]));
        }
    }

    public function setLink($SQL_LINK): void
    {
        $this->SQL_LINK = $SQL_LINK;
    }

    /**
     * @param $key array field name
     * @return array
     */
    public function getValue(...$key)
    {
        $this->clearLimit();
        $fieldArea = "";
        $limitArea="";
        if (empty($key) || in_array('*', $key)) {
            $fieldArea = "*";
        } else {
            $fieldArea = implode(",", $key);
        }
        if(!empty($this->limit))
        {
            $limitArea="WHERE ".$this->limit;
        }
        return $this->search("SELECT ".$fieldArea." FROM $this->tableName ".$limitArea);
    }

    private function clearLimit()
    {
        $this->limit = "";
    }

    /**
     * @param mixed $DBName
     * @return Table
     */
    public function setDBName($DBName): Table
    {
        $this->DBName = $DBName;
        return $this;
    }

    public function limit(string $limit)
    {
        $this->limit = $limit;
    }
}
