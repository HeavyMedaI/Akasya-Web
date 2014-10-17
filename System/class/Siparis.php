<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 17.10.2014
 * Time: 15:38
 */

class Siparis {

    private $Data;

    public function __construct(Array $_DATA){

         $this->Data = @$_DATA;

    }

    public function isDomain(){

         if(@$this->Data["type"]=="domain"){

             return TRUE;

         }

        return FALSE;

    }

    public function isHosting(){

        if(@$this->Data["type"]=="hosting"){

            return TRUE;

        }

        return FALSE;

    }

    public function Name(){

         return @$this->Data["name"];

    }

    public function Surname(){

        return @$this->Data["surname"];

    }

    public function Phone(){

        return @$this->Data["phone"];

    }

    public function Mail(){

        return @$this->Data["mail"];

    }

    public function Domain(){

        return @$this->Data["domain"];

    }

    public function Plan(){

        return @$this->Data["plan"];

    }

    public function Price(){

        return @$this->Data["price"];

    }


}

?>