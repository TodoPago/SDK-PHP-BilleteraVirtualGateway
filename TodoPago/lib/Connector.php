<?php
namespace TodoPago;

define('TODOPAGO_BILLETERAVIRTUALGATEWAY_VERSION','1.0.0');
define('TODOPAGO_BILLETERAVIRTUALGATEWAY_ENDPOINT_TEST','https://developers.todopago.com.ar/');
define('TODOPAGO_BILLETERAVIRTUALGATEWAY_ENDPOINT_PROD','https://apis.todopago.com.ar/');

class Connector
{
	private $host = NULL;
	private $port = NULL;
	private $user = NULL;
	private $pass = NULL;
	private $connection_timeout = NULL;
	private $local_cert = NULL;
	private $end_point = NULL;

	private $billeteraVirtualGateway = NULL;
	private $credentials = NULL;

	public function __construct($header_http_array, $mode = "test"){
		if($mode == "test") {
			$this->end_point = TODOPAGO_BILLETERAVIRTUALGATEWAY_ENDPOINT_TEST;
		} elseif ($mode == "prod") {
			$this->end_point = TODOPAGO_BILLETERAVIRTUALGATEWAY_ENDPOINT_PROD;
		}

		$this->header_http = $this->getHeaderHttp($header_http_array);

		$this->billeteraVirtualGateway = new \TodoPago\BilleteraVirtualGateway($this->end_point, $this->header_http);
		$this->credentials = new \TodoPago\Credentials($this->end_point, $this->header_http);
	}

	private function getHeaderHttp($header_http_array){
		$header = "";
		if(is_array($header_http_array)) {
			foreach($header_http_array as $key=>$value){
				$header .= "$key: $value\r\n";
			}

		}
		return $header;
	}
	/*
	* configuraciones
	/

	/**
	* Setea parametros en caso de utilizar proxy
	* ejemplo:
	* $todopago->setProxyParameters('199.0.1.33', '80', 'usuario','contrasenya');
	*/
	public function setProxyParameters($host = null, $port = null, $user = null, $pass = null){
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->pass = $pass;
	}

	/**
	* Setea time out (deaulft=NULL)
	* ejemplo:
	* $todopago->setConnectionTimeout(1000);
	*/
	public function setConnectionTimeout($connection_timeout){
		$this->connection_timeout = $connection_timeout;
	}

	/**
	* Setea ruta del certificado .pem (deaulft=NULL)
	* ejemplo:
	* $todopago->setLocalCert('c:/miscertificados/decidir.pem');
	*/
	public function setLocalCert($local_cert){
		$this->local_cert= file_get_contents($local_cert);
	}

	public function getCredentials(Data\User $user) {
		return $this->credentials()->get($user);
	}

	public function billeteraVirtualGateway() {
		return $this->billeteraVirtualGateway;
	}

	public function credentials() {
		return $this->credentials;
        }
}

