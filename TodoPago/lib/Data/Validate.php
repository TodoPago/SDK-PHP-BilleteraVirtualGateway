<?php

namespace TodoPago\Data;

class Validate {

    public static function collection($value, $field = null) {
        if(!is_array($value))
            throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977, "array");

        return true;            
    }

    public static function integer($value, $field = null) {
        if(!is_integer($value))
            throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977, "integer");

        return true;
    }

    public static function datetime($value,$field = null) {
        if(\DateTime::createFromFormat("YmdHis",$value) == false)
            throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977, "datetime - YmdHis");

        return true;            
    }

    public static function ip($value,$field = null) {
        if(filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false)
            throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977, "ip");

        return true;            
    }

    public static function amount($value,$field = null) {
        if(!preg_match("/^(\d)+((\,)(\d){2})?$/", $value)) 
            throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977, "monto - XXXX,XX");

        return true;  
    }

    public static function characters($value, $field = null) {
        $chars = array("?","=","&","/","'",'"',"\\",":","#",";");
        foreach($chars as $c) {
            if(strpos($value,$c) !== false) {
                throw new \TodoPago\Exception\Data\InvalidFieldException($field, 99977);
            }
        }
        return true;
    }
    
}