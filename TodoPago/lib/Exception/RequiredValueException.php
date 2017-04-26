<?php

namespace TodoPago\Exception;

class RequiredValueException extends \TodoPago\Exception\TodoPagoException {
	
	public function __construct($field) {
		$message = "Campo: " . $field . " es requerido.";
		$code = 99976;
		parent::__construct($message, $code);
	}
}