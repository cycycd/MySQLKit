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
        //print_r($singleRow);
    }

    /**
     * Row constructor.
     * @param string $row
     */


    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getNullable()
    {
        return $this->nullable;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function getExtra()
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