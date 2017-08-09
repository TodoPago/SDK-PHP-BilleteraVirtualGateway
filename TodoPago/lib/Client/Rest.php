<?php
namespace TodoPago\Client;

 class Rest extends Base {
	
	protected $url = "";
	
	protected function getClient($data = array(), $method = "GET", $headers = array()){
		if(empty($this->url))
			throw new \TodoPago\Exception\TodoPagoException("Rest url inválida",0);
		return $this->doRest($data, $method, $headers);
	}
	
	protected function setUrl($operation , $params) {
		$parameters = "";
		foreach($params as $key => $value) {
				$parameters .= "/". $key ."/". $value;
		}
		$this->url = $this->endpoint . static::TODOPAGO_ENDPOINT_TENANT . "api/" . $this->service . "/" . $operation . $parameters;
	}
	
	protected function doRest($data, $method, $headers){
		$curl = curl_init($this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		
		$conn_headers = array_filter(explode("\r\n",$this->header_http));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($conn_headers,$headers));

		if($method == "POST") {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
		}

		if($method == "PUT") {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
		}

		$result = curl_exec($curl);
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		if($http_status != 200 && $http_status != 201) {

			$res = json_decode($result,true);
			if(isset($res["statusCode"])) {
				throw new \TodoPago\Exception\ResponseException($res["statusMessage"], $res["statusCode"], $res);
			} else if(isset($res["errorCode"])) {
				throw new \TodoPago\Exception\ResponseException($res["errorMessage"], $res["errorCode"], $res);
			} else { 
				throw new \TodoPago\Exception\ResponseException($res["error"], $res["status"], $res);
			}
		}
		$ret = json_decode($result,true);
		if( json_last_error() === JSON_ERROR_NONE ) {
			return $ret;
		}
		return json_decode(json_encode(simplexml_load_string($result)), true);
	}
 }
