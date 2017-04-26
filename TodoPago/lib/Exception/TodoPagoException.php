<?php
namespace TodoPago\Exception;

class TodoPagoException extends \Exception {
	protected $data;
	
	public function __construct($message,  $code = 0, $data = null, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
		$this->data = $data;
	}
	
	public function getData() {
		return $this->data;
	}
}
