<?php

namespace cycycd\MySQLKit;
require_once "Row.php";
class Table
{
    private $name;
    private $rowList;
    /**
     * Table constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    public function append(string $row): Table
    {
        array_push($this->rowList, $row);
        return $this;
    }

    public function count()
    {
        return count($this->rowList);
    }
    /**
     * @deprecated type-cast will call __toSting function
     */
    public function toString()
    {
        if (!empty($this->name) && !empty($this->rowList)) {
            $sql_code = "create table if not exists " . $this->name . "("
                . implode(",", $this->rowList) . ")";
            return $sql_code;
        }
    }
}
