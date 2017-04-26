<?php
namespace TodoPago\BilleteraVirtualGateway;

class Discover implements \ArrayAccess, \IteratorAggregate {

    private $container = array();

    public function __construct() {

    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function getIterator() {
        return new \ArrayIterator($this->container);
    }

	public function add(\TodoPago\BilleteraVirtualGateway\PaymentMethod $mp) {
		$this->container[] = $mp;
	}

	public function getPaymentMethods() {
		return $this->container;
	}
}
