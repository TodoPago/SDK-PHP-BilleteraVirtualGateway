<?php

namespace TodoPago\Exception\Data;

class InvalidFieldException extends \Exception {
    
    protected $field;
    
    public function __construct($field = null, $code = 0, $format = null, $previous = null) {
        if($field == null) {
            $message = "El campo es inválido.";
        } else {
            $message = "El campo " . $field . " es inválido.";
        }

        if($format != null) {
            $message = $message . " El formato esperado es: " . $format;
        }

        parent::__construct($message, $code, $previous);
    }
    
}