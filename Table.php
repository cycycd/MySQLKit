<?php
namespace MySQLKit;
class Table
{
    private $writable=true;
    private $name;
    private $SQL_LINK;
    private $rowList=array();
    function setName($name): void
    {
        if($this->writable)
        {
            $this->name=$name;
        }
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


}

