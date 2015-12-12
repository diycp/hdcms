<?php namespace hdphp\qq;

use hdphp\qq\org\QC;

class Qq
{

    private $Qc;

    //构造函数
    public function __construct()
    {

        $this->Qc = new QC;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->Qc, $method), $args);
    }
}