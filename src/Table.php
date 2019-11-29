<?php

namespace cycycd\MySQLKit;
require_once "Row.php";
class Table
{
    use MySQLKitCore;
    private $DBName;
    private $tableName;
    private $rowList;
    private $writable;
    private $SQL_LINK;

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
        $this->tableName = $tableName;
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

    public function count()
    {
        return count($this->rowList);
    }

    /**
     * work for type-cast
     */
    public function __toString()
    {
        if (!empty($this->tableName) && !empty($this->rowList)) {
            $sql_code = "create table if not exists " . $this->tableName . "("
                . implode(",", $this->rowList) . ")";
            return $sql_code;
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
        if(in_array('*',$key))
        {
            $result=$this->search("SELECT * FROM $this->tableName");
            return $result;
        }
        return $this->search("SELECT ".implode(",",$key)." FROM $this->tableName");
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

}
