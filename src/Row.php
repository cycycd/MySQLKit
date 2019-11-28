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
     * @param string $row
     */
    public function __construct(string $row)
    {
        $rowArray=explode(" ",$row);

    }

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

}