<?php
namespace TodoPago\BilleteraVirtualGateway;

class Transactions {

	protected $generalData = array();
	protected $operationData = array();
	protected $technicalData = array();
	protected $response = array();

	private $generalDataKeys = array("merchant","security","operationDatetime","remoteIpAddress");
	private $operationDataKeys = array("operationType","operationID","currencyCode","concept","amount","availablePaymentMethods","availableBanks","buyerPreselection");
	private $technicalDataKeys = array("pluginversion","ecommercename","ecommerceversion","cmsversion");
	private $responseKeys = array("publicRequestKey","merchantId","channel");

	public function __construct($generalData, $operationData, $technicalData) {
		$this->setGeneralData($generalData);
		$this->setOperationData($operationData);
		$this->setTechnicalData($technicalData);
	}

	public function setGeneralData($generalData) {
		foreach($generalData as $key => $value) {
			if(in_array($key, $this->generalDataKeys) && !empty($generalData[$key])) {
				\TodoPago\Data\Validate::characters($value, $key);
				if($key == "merchant")
					\TodoPago\Data\Validate::integer($value, "merchant");
				if($key == "operationDatetime")
					\TodoPago\Data\Validate::datetime($value, "operationDatetime");
				if($key == "remoteIpAddress")
					\TodoPago\Data\Validate::ip($value, "remoteIpAddress");
				$this->generalData[$key] = $value;
				unset($this->generalDataKeys[array_search($key,$this->generalDataKeys)]);
			}
		}

		$this->generalData["channel"] = "BSA";
	}

	public function setOperationData($operationData) {
		foreach($operationData as $key => $value) {
			if(in_array($key, $this->operationDataKeys) && !empty($operationData[$key])) {
				if($key == "buyerPreselection") {

					if(isset($value["paymentMethodId"]))
						\TodoPago\Data\Validate::integer($value["paymentMethodId"], "buyerPreselection['paymentMethodId']");
					if(isset($value["bankId"]))
						\TodoPago\Data\Validate::integer($value["bankId"], "buyerPreselection['bankId']");

					$this->operationData[$key] = $value;
				} else if($key == "availablePaymentMethods") {
					\TodoPago\Data\Validate::collection($value, "availablePaymentMethods");
					foreach($value as $data) {
						\TodoPago\Data\Validate::integer($data, "availablePaymentMethods[$data]");
					}

					$this->operationData[$key] = $value;
				} else if($key == "availableBanks") {
					\TodoPago\Data\Validate::collection($value, "availableBanks");
					foreach($value as $data) {
						\TodoPago\Data\Validate::integer($data, "availableBanks[$data]");
					}

					$this->operationData[$key] = $value;
				} else {
					if($key == "amount")
						\TodoPago\Data\Validate::amount($value, $key);

					\TodoPago\Data\Validate::characters($value, $key);
					$this->operationData[$key] = $value;
				}
				unset($this->operationDataKeys[array_search($key,$this->operationDataKeys)]);
			}
		}

		foreach($this->operationDataKeys as $key) {
			if(in_array($key,array("availablePaymentMethods","availableBanks","buyerPreselection","concept","operationType"))) {
				unset($this->operationDataKeys[array_search($key,$this->operationDataKeys)]);
			}
		}
	}

	public function setTechnicalData($technicalData) {
		foreach($technicalData as $key => $value) {
			if(in_array($key, $this->technicalDataKeys) && !empty($technicalData[$key])) {
				\TodoPago\Data\Validate::characters($value, $key);
				$this->technicalData[$key] = $value;
				unset($this->technicalDataKeys[array_search($key,$this->technicalDataKeys)]);
			}
		}

		$this->technicalData["sdk"] = "PHP";
		$this->technicalData["sdkversion"] = TODOPAGO_BILLETERAVIRTUALGATEWAY_VERSION;
		$this->technicalData["lenguageversion"] = phpversion();
	}

	public function getGeneralData() {
		return $this->generalData;
	}

	public function getOperationData() {
		return $this->operationData;
	}

	public function getTechnicalData() {
		return $this->technicalData;
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

		return array(
			"generalData" => $this->generalData,
			"operationData" => $this->operationData,
			"technicalData" => $this->technicalData
		);
	}
}
