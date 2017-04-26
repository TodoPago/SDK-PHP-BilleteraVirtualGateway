<?php
namespace TodoPago\Data;

class Response extends \TodoPago\Data\AbstractData {
	
	protected $StatusCode;
	protected $StatusMessage;
	protected $Payload;
	
	protected $ResponseValid = false;
	
	public function __construct(array $data) {
		$this->setRequiredFields(array(
			"StatusCode" => array(
				"name" => "StatusCode"
			),
			"StatusMessage" => array(
				"name" => "StatusMessage"
			), 
		));
		
		$this->setOptionalFields(array(
			"Payload" => array(
				"name" => "Payload"
			), 				
		));
		
		parent::__construct($data);
		
		$this->ResponseValid = ($this->StatusCode == -1);
		
		if(!$this->ResponseValid)
			throw new \TodoPago\Exception\ResponseException($this->StatusMessage, $this->StatusCode, $this);
	}
	
	public function getStatusCode(){
		return $this->StatusCode;
	}

	public function getStatusMessage(){
		return $this->StatusMessage;
	}

	public function getPayload(){
		return $this->Payload;
	}

}