<?php
namespace TodoPago;

class BilleteraVirtualGateway extends Client\Rest {

	public function __construct($endpoint, $header) {
		parent::__construct("BilleteraVirtualGateway", $endpoint, $header);
	}

	public function transactions(\TodoPago\BilleteraVirtualGateway\Transactions $data){
		$this->url = $this->endpoint . "ms/tx/v1/bsa";

		$response = $this->getClient($data->getData(), "POST", array("Content-Type: application/json"));
		$data->setResponse($response);
		return $data;
	}

	public function discover() {
		$this->url = $this->endpoint . "bsa/discover/api/BSA/paymentMethod/discover";
		$response = $this->getClient(array(), "GET", array("Content-Type: application/json"));

		$discover = new \TodoPago\BilleteraVirtualGateway\Discover();
		foreach($response as $mp) {
			$discover->add(new \TodoPago\BilleteraVirtualGateway\PaymentMethod($mp));
		}

		return $discover;
	}

	public function pushnotify(\TodoPago\BilleteraVirtualGateway\PushNotify $data){
		$prk = $data->getGeneralData()["publicRequestKey"];
		$this->url = $this->endpoint . "ms/tx/v1/bsa/" . $prk;

		$response = $this->getClient($data->getData(), "PUT", array("Content-Type: application/json"));
		$data->setResponse($response);
		return $data;
	}
}
