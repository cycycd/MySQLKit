<?php


namespace cycycd\MySQLKit;


class Row{
    private $field;
    private $type;
    private $nullable;
    private $key;
    private $default;
    private $extra;

    /**
     * Row constructor.
     * @param $singleRow
     */
    public function __construct($singleRow)
    {
        $this->field=$singleRow[0];
        $this->type=$singleRow[1];
        $this->nullable=$singleRow[2];
        $this->key=$singleRow[3];
        $this->default=$singleRow[4];
        $this->extra=$singleRow[5];
    }

    /**
     * @return mixed
     */
    public function getField():string
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getNullable():string
    {
        return $this->nullable;
    }

    /**
     * @return mixed
     */
    public function getKey():string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getDefault():string
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function getExtra():string
    {
        return $this->extra;
    }

    public function __toString()
    {
        $row=$this->field." "
            .$this->type." "
            .($this->nullable=="NO"?"NOT NULL ":" ")
            .($this->key=="PRI"?"PRIMARY KEY ":" ")
            .(!empty($this->default)?"DEFAULT $this->default ":" ")
            .$this->extra;
        return $row;
    }

}