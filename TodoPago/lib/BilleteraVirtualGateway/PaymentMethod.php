<?php

namespace TodoPago\BilleteraVirtualGateway;

class PaymentMethod {
	protected $id;
	protected $nombre;
	protected $tipo;
	protected $idBanco;
	protected $nombreBanco;

	public function __construct($data) {
		$this->id = $data["idMedioPago"];
		$this->nombre = $data["nombre"];
		$this->tipo = $data["tipoMedioPago"];
		$this->idBanco = $data["idBanco"];
		$this->nombreBanco = $data["nombreBanco"];
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getIdBanco(){
		return $this->idBanco;
	}

	public function setIdBanco($idBanco){
		$this->idBanco = $idBanco;
	}

	public function getNombreBanco(){
		return $this->nombreBanco;
	}

	public function setNombreBanco($nombreBanco){
		$this->nombreBanco = $nombreBanco;
	}
}
