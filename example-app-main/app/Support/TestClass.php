<?php 
namespace App\Support;

class TestClass{
    protected $value =0;

    public function increase(){
        return ++$this->value;
    }
}
?>