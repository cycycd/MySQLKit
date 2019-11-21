<?php
namespace MySQLKit;
class Table
{
    private $writable=true;
    private $name;
    private $SQL_LINK;//TODO
    private $rowList=array();
    function setName($name): self
    {
        if($this->writable)
        {
            $this->name=$name;
        }
        //array_push($this->rowList,new Table());
        return $this;
    }
    function getName()
    {
        return $this->name;
    }
    /**
     * @param bool $writable
     */
    public function setWritable(bool $writable): void
    {
        $this->writable = $writable;
    }
    public function append(string $row):Table
    {
        array_push($this->rowList,$row);
        return $this;
    }
    public function count()
    {
        return count($this->rowList);
    }
    //auto toString
    public function __toString()
    {
        // TODO: Implement __toString() method.
        $sql_code="create table if not exists ".$this->name."("
            .implode(",",$this->rowList).")";
        return $sql_code;
    }
    //main Class toString
    public function toString()
    {
        if(!empty($this->name)&&!empty($this->rowList))
        {
            $sql_code="create table if not exists ".$this->name."("
                .implode(",",$this->rowList).")";
            return $sql_code;
        }
    }
}

