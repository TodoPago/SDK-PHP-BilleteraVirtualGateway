<?php

namespace TodoPago\Test;

require_once('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase {

    use \phpmock\phpunit\PHPMock;

    public function testTransactionsClassComplete() {

        $tr = TransactionsDataProvider::getTransactionsOptions();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());
        $this->assertArrayHasKey("availablePaymentMethods",$tr->getOperationData());
        $this->assertArrayHasKey("availableBanks",$tr->getOperationData());
        $this->assertArrayHasKey("buyerPreselection",$tr->getOperationData());


        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }

    public function testTransactionsClassMinimum() {

        $tr = TransactionsDataProvider::getTransactionsOptions2();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());

        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }

    public function testTransactionsClassWithoutRestricts() {

        $tr = TransactionsDataProvider::getTransactionsOptions3();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());
        $this->assertArrayHasKey("buyerPreselection",$tr->getOperationData());


        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }

    public function testTransactionsClassWithBuyerPreselectionComplete() {

        $tr = TransactionsDataProvider::getTransactionsOptions4();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());
        $this->assertArrayHasKey("buyerPreselection",$tr->getOperationData());


        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }


    public function testTransactionsClassWithLimitPaymentMethod() {

        $tr = TransactionsDataProvider::getTransactionsOptions5();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());
        $this->assertArrayHasKey("availablePaymentMethods",$tr->getOperationData());

        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }

    public function testTransactionsClassWithLimitBanks() {

        $tr = TransactionsDataProvider::getTransactionsOptions6();
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        
        $this->assertTrue(is_array($tr->getGeneralData()));
        $this->assertArrayHasKey("merchant",$tr->getGeneralData());
        $this->assertArrayHasKey("security",$tr->getGeneralData());
        $this->assertArrayHasKey("operationDatetime",$tr->getGeneralData());
        $this->assertArrayHasKey("remoteIpAddress",$tr->getGeneralData());

        $this->assertTrue(is_array($tr->getOperationData()));
        $this->assertArrayHasKey("operationType",$tr->getOperationData());
        $this->assertArrayHasKey("operationID",$tr->getOperationData());
        $this->assertArrayHasKey("currencyCode",$tr->getOperationData());
        $this->assertArrayHasKey("concept",$tr->getOperationData());
        $this->assertArrayHasKey("amount",$tr->getOperationData());
        $this->assertArrayHasKey("availableBanks",$tr->getOperationData());

        $this->assertTrue(is_array($tr->getTechnicalData()));
        $this->assertArrayHasKey("pluginversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommercename",$tr->getTechnicalData());
        $this->assertArrayHasKey("ecommerceversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("cmsversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdk",$tr->getTechnicalData());
        $this->assertArrayHasKey("sdkversion",$tr->getTechnicalData());
        $this->assertArrayHasKey("lenguageversion",$tr->getTechnicalData());        

        $this->assertTrue(is_array($tr->getData()));
        $this->assertArrayHasKey("generalData",$tr->getData());
        $this->assertArrayHasKey("operationData",$tr->getData());
        $this->assertArrayHasKey("technicalData",$tr->getData());
    }    

    /**
     * @expectedException \TodoPago\Exception\Data\EmptyFieldException    
     */
    public function testTransactionsClassRequiredGeneralField() {
        $tr = TransactionsDataProvider::getTransactionsOptionsFail1();
        $resp = $tr->getData();
    }

    /**
     * @expectedException \TodoPago\Exception\Data\EmptyFieldException    
     */
    public function testTransactionsClassRequiredOperationField() {
        $tr = TransactionsDataProvider::getTransactionsOptionsFail2();
        $resp = $tr->getData();
    }    

    public function testTransactionsOk() {
        $curl_exec = $this->getFunctionMock("TodoPago\\Client", "curl_exec");
        $curl_exec->expects($this->any())->willReturn(TransactionsDataProvider::getTransactionsOkResponse());

        $curl_getinfo = $this->getFunctionMock("TodoPago\\Client", "curl_getinfo");
        $curl_getinfo->expects($this->any())->willReturn(200);

        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"test");

        $tr = TransactionsDataProvider::getTransactionsOptions();
        $response = $sdk->billeteraVirtualGateway()->transactions($tr);

        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $tr);
        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Transactions::class, $response);
        $this->assertTrue(is_array($tr->getResponse()));
        $this->assertArrayHasKey("publicRequestKey",$tr->getResponse());
        $this->assertArrayHasKey("merchantId",$tr->getResponse());
        $this->assertArrayHasKey("channel",$tr->getResponse());
    }


    /**
     * @expectedException \TodoPago\Exception\ResponseException    
     */
    public function testTransactions702() {
        $curl_exec = $this->getFunctionMock("TodoPago\\Client", "curl_exec");
        $curl_exec->expects($this->any())->willReturn(TransactionsDataProvider::getTransactions702Response());

        $curl_getinfo = $this->getFunctionMock("TodoPago\\Client", "curl_getinfo");
        $curl_getinfo->expects($this->any())->willReturn(200);

        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"test");

        $tr = TransactionsDataProvider::getTransactionsOptions();
        $response = $sdk->billeteraVirtualGateway()->transactions($tr);
    }  

    /**
     * @expectedException \TodoPago\Exception\ResponseException    
     */
    public function testTransactionsFail() {
        $curl_exec = $this->getFunctionMock("TodoPago\\Client", "curl_exec");
        $curl_exec->expects($this->any())->willReturn(TransactionsDataProvider::getTransactionsFailResponse());

        $curl_getinfo = $this->getFunctionMock("TodoPago\\Client", "curl_getinfo");
        $curl_getinfo->expects($this->any())->willReturn(400);

        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"test");

        $tr = TransactionsDataProvider::getTransactionsOptions();
        $response = $sdk->billeteraVirtualGateway()->transactions($tr);
    } 
}
