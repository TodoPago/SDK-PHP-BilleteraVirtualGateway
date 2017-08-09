<?php
namespace TodoPago;

class Credentials extends Client\Rest {

	public function __construct($endpoint, $header) {
		parent::__construct("Credentials", $endpoint, $header);
	}

	public function get(\TodoPago\Data\User $data){
		$this->url = $this->endpoint . "api/" . $this->service;

		$response = $this->getClient($data->getData(), "POST", array("Content-Type: application/json", "Accept: application/json"));

		if($response == null) {
			throw new \TodoPago\Exception\ConnectionException("Error de conexion");
		}

		if($response["Credentials"]["resultado"]["codigoResultado"] != 0) {
			throw new \TodoPago\Exception\ResponseException($response["Credentials"]["resultado"]["mensajeResultado"],$response["Credentials"]["resultado"]["codigoResultado"]);
		}

		$data->setMerchant($response["Credentials"]["merchantId"]);
		$data->setApikey($response["Credentials"]["APIKey"]);

		return $data;
	}
}
