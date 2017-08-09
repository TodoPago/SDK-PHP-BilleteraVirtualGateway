<?php

namespace TodoPago\Test;

require_once('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class SdkUtilsTest extends TestCase {

    use \phpmock\phpunit\PHPMock;


    public function testProd() {

        $curl_exec = $this->getFunctionMock("TodoPago\\Client", "curl_exec");
        $curl_exec->expects($this->any())->willReturn(CredentialsDataProvider::getCredentialsOkResponse());

        $curl_getinfo = $this->getFunctionMock("TodoPago\\Client", "curl_getinfo");
        $curl_getinfo->expects($this->any())->willReturn(200);

        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"prod");

        $params = CredentialsDataProvider::getCredentialsOptions();
        $response = $sdk->credentials()->get($params);

        $this->assertInstanceOf(\TodoPago\Data\User::class, $response);
        $this->assertNotEmpty($response->getMerchant());
        $this->assertNotEmpty($response->getApikey());
    } 

    public function testBilleteraVirtualGateway() {
        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"test");
        $response = $sdk->billeteraVirtualGateway();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway::class, $response);
    }    
  
}