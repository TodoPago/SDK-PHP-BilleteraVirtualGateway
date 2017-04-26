<?php
namespace TodoPago\Client;

 abstract class Base {
	protected $service = "";
	protected $endpoint = "";
	protected $header_http = "";
	
	protected $proxy;
	protected $conn_settings;
	
	const TODOPAGO_ENDPOINT_TENANT = "t/1.1/";
	
	public function __construct($service, $endpoint, $header) {
		$this->service = $service;
		$this->endpoint = $endpoint;
		$this->header_http = $header;
	}
	
	protected abstract function getClient();
	
 }