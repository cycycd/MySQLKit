<?php
class TableKit{
    private $strings="create table if not exists ";
    private $tableName;
    private $body="";
    function setName($name)
    {
        $this->tableName=$name;
        return $this;
    }
    function addElement($element)
    {
        if(!empty($this->body))
        {
            $this->body.=",\n";
        }
        $this->body.=$element;
        return $this;
    }
    function get()
    {
        $this->strings.=$this->tableName;
        $this->strings.="(\n";
        $this->strings.=$this->body;
        $this->strings.="\n)";
        return $this->strings;
    }
}