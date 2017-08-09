<?php

namespace TodoPago\Exception;

class InvalidEndpointException extends \TodoPago\Exception\TodoPagoException {
	
	public function __construct($data) {
		$message = "Endpoint no valido: " . $data;
		$code = 77778;
		parent::__construct($message, $code);
	}
}