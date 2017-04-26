<?php
namespace TodoPago\Data;

abstract class AbstractData {
	
	private $field_required = array();
	private $field_optional = array();
	
	protected $response;

	public function __construct(array $data) {
		foreach($this->field_required as $field => $options) {
			if(isset($options["original"])) {
				if(!array_key_exists($options["original"],$data))
					throw new \TodoPago\Exception\RequiredValueException($options["name"]);
				$this->$field = $data[$options["original"]];
				unset($data[$options["original"]]);				
			} else {
				if(!array_key_exists($field,$data))
					throw new \TodoPago\Exception\RequiredValueException($options["name"]);
				$this->$field = $data[$field];
				unset($data[$field]);
			}
		}
		
		foreach($this->field_optional as $field => $options) {
			if(isset($options["original"])) {
				if(array_key_exists($options["original"],$data)) {
					$this->$field 	= $data[$options["original"]];
					unset($data[$options["original"]]);
				}			
			} else {
				if(array_key_exists($field,$data)) {
					$this->$field 	= $data[$field];
					unset($data[$field]);
				}
			}
		}
		
		if(count($data) > 0)
			throw new \TodoPago\Exception\TodoPagoException("Campos adicionales a los esperados: ". implode(", ",array_keys($data)), 99976, $this);
	}
	
	private function sanitizeValue($string){
		$string = htmlspecialchars_decode($string);
		$string = strip_tags($string);
		$re = "/\\[(.*?)\\]|<(.*?)\\>/i"; 
		$subst = "";
		$string = preg_replace($re, $subst, $string);
		$string = preg_replace('/[\x00-\x1f]/','',$string);
		$string = preg_replace('/[\xc2-\xdf][\x80-\xbf]/','',$string);
		$replace = array("\n","\r",'\n','\r','&nbsp;','&','<','>');
		$string = str_replace($replace, '', $string);
		return $string;	
	}

	protected function getXmlData() {
		$output = "";
		foreach(array_merge($this->field_required, $this->field_optional) as $field => $options) {
			if(isset($options["xml"])) {
				if($this->$field != null) {
					if(strpos($this->$field,"#") === false) {
						$value = substr($this->$field, 0, 254);
					}
					$output .= '<'.$options["xml"].'>'.$this->sanitizeValue($this->$field).'</'.$options["xml"].'>';
				}
			}
		}
		return $output;
	}
	
	public function toArray() {
		$result = array();
		foreach(array_merge($this->field_required, $this->field_optional) as $field => $options) {
			if(isset($options["xml"]))
				if($this->$field != null)
					$result[$options["xml"]] = $this->$field;
		}
		return $result;
	}
	
	protected function getRequiredFields() {
		return $this->field_required;
	}
	
	protected function getOptionalFields() {
		return $this->field_optional;
	}

	protected function setRequiredFields($data) {
		$this->field_required = array_merge($data, $this->field_required);
	}
	
	protected function setOptionalFields($data) {
		$this->field_optional = array_merge($data, $this->field_optional);
	}

	public function setResponse(\TodoPago\Data\AbstractData $response) {
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}
}
