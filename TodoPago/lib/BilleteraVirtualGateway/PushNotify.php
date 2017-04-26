<?php
namespace TodoPago\BilleteraVirtualGateway;

class PushNotify {

	protected $generalData = array();
	protected $operationData = array();
	protected $tokenizationData = array();
	protected $response = array();

	private $generalDataKeys = array("merchant","security","publicRequestKey","remoteIpAddress","operationName");
	private $operationDataKeys = array("resultCodeMedioPago","resultCodeGateway","idGateway", "resultMessage", "operationDatetime","ticketNumber", "codigoAutorizacion", "currencyCode","operationID", "concept", "amount","facilitiesPayment");
	private $tokenizationDataKeys = array("publicTokenizationField","credentialMask");
	private $responseKeys = array("statusCode","statusMessage");

	public function __construct($generalData, $operationData, $tokenizationData) {
		$this->setGeneralData($generalData);
		$this->setOperationData($operationData);
		$this->setTokenizationData($tokenizationData);
	}

	public function setGeneralData($generalData) {
		foreach($generalData as $key => $value) {
			if(in_array($key, $this->generalDataKeys) && !empty($generalData[$key])) {
				$this->generalData[$key] = $value;
				unset($this->generalDataKeys[array_search($key,$this->generalDataKeys)]);
			}
		}

		foreach($this->generalDataKeys as $key) {
			if(in_array($key,array("remoteIpAddress"))) {
				unset($this->generalDataKeys[array_search($key,$this->generalDataKeys)]);
			}
		}
	}

	public function setOperationData($operationData) {
		foreach($operationData as $key => $value) {
			if(in_array($key, $this->operationDataKeys) && !empty($operationData[$key])) {
				$this->operationData[$key] = $value;
				unset($this->operationDataKeys[array_search($key,$this->operationDataKeys)]);
			}
		}

		foreach($this->operationDataKeys as $key) {
			if(in_array($key,array("resultCodeMedioPago","resultCodeGateway","idGateway","resultMessage","ticketNumber","codigoAutorizacion","concept"))) {
				unset($this->operationDataKeys[array_search($key,$this->operationDataKeys)]);
			}
		}
	}

	public function setTokenizationData($tokenizationData) {
		foreach($tokenizationData as $key => $value) {
			if(in_array($key, $this->tokenizationDataKeys) && !empty($tokenizationData[$key])) {
				$this->tokenizationData[$key] = $value;
				unset($this->tokenizationDataKeys[array_search($key,$this->tokenizationDataKeys)]);
			}
		}

		foreach($this->tokenizationDataKeys as $key) {
			if(in_array($key,array("credentialMask"))) {
				unset($this->tokenizationDataKeys[array_search($key,$this->tokenizationDataKeys)]);
			}
		}
	}

	public function getGeneralData() {
		return $this->generalData;
	}

	public function getOperationData() {
		return $this->operationData;
	}

	public function getTokenizationData() {
		return $this->tokenizationData;
	}

	public function getResponse() {
		return $this->response;
	}

	public function setResponse($response) {
		if(isset($response["errorCode"])) {
			throw new \TodoPago\Exception\ResponseException($response["errorMessage"],$response["errorCode"]);
		} else {
			foreach($response as $key => $value) {
				if(in_array($key, $this->responseKeys)) {
					$this->response[$key] = $value;
					unset($this->responseKeys[array_search($key,$this->responseKeys)]);
				}
			}
		}
	}

	public function getData() {
		if(!empty($this->generalDataKeys)) {
			throw new \TodoPago\Exception\Data\EmptyFieldException('generalData["'.array_pop($this->generalDataKeys).'"]');
		}

		if(!empty($this->operationDataKeys)) {
			throw new \TodoPago\Exception\Data\EmptyFieldException('operationData["'.array_pop($this->operationDataKeys).'"]');
		}

		if(!empty($this->tokenizationDataKeys)) {
			throw new \TodoPago\Exception\Data\EmptyFieldException('tokenizationData["'.array_pop($this->tokenizationDataKeys).'"]');
		}

		return array(
			"generalData" => $this->generalData,
			"operationData" => $this->operationData,
			"tokenizationData" => $this->tokenizationData
		);
	}
}
