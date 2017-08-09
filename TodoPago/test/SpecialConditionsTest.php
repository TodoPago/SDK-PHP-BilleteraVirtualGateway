<?php

namespace TodoPago;
{
    function function_exists($function)
    {
        if ($function === 'mb_convert_encoding') {
            return false;
        }
        return \function_exists($function);
    }
}


namespace TodoPago\Test;

require_once('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class SpecialConditionsTest extends TestCase {

    private $clientMock;

    use \phpmock\phpunit\PHPMock;

    /**
     * @expectedException \TodoPago\Exception\InvalidEndpointException    
     */    
    public function testBadEndpoint() {
       $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"bad");

    }   

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateInteger() {
        $ret = \TodoPago\Data\Validate::integer(1);
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::integer("A");        
    }

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateIp() {
        $ret = \TodoPago\Data\Validate::ip("127.0.0.1");
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::ip("::1"); 
    }    

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateAmount() {
        $ret = \TodoPago\Data\Validate::amount("10,99");
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::amount("10.99");         
        
    }

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateDatetime() {
        $ret = \TodoPago\Data\Validate::datetime("20170510180000");
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::datetime("2017A510180000");      
    }

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateCollection() {
        $ret = \TodoPago\Data\Validate::collection(array());
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::collection("");    
    }

    /**
     * @expectedException \TodoPago\Exception\Data\InvalidFieldException    
     */
    public function testValidateCharacters() {
        $ret = \TodoPago\Data\Validate::characters("TEST");
        $this->assertTrue($ret);

        $ret = \TodoPago\Data\Validate::characters("TEST&?=","campo"); 
    }
}