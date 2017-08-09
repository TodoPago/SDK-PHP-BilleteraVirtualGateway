<?php

namespace TodoPago\Test;

class TransactionsDataProvider {

    public static function getTransactionsOptionsFail1() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "buyerPreselection" => array("paymentMethodId" => 42),
          "availablePaymentMethods" => array(1,42),
          "availableBanks" => array(1)
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptionsFail2() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "concept" => "compra",
          "amount" => "10,99",
          "buyerPreselection" => array("paymentMethodId" => 42),
          "availablePaymentMethods" => array(1,42),
          "availableBanks" => array(1)
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }    

    public static function getTransactionsOptions() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "buyerPreselection" => array("paymentMethodId" => 42),
          "availablePaymentMethods" => array(1,42),
          "availableBanks" => array(1)
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptions2() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptions3() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "buyerPreselection" => array("paymentMethodId" => 42),
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptions4() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "buyerPreselection" => array("paymentMethodId" => 42, "bankId" => 1),
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptions5() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "availablePaymentMethods" => array(1,42),          
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }

    public static function getTransactionsOptions6() {

        $generalData = array(
          "merchant" => 41702,
          "security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
          "operationDatetime" => "20160425155613",
          "remoteIpAddress" => "192.168.11.87",
          "channel" => "BVTP"
        );

        $operationData = array(
          "operationType" => "Compra",
          "operationID" => "1234",
          "currencyCode" => "032",
          "concept" => "compra",
          "amount" => "10,99",
          "availableBanks" => array(1)
        );

        $technicalData = array(
          "pluginversion"=>"2.1",
          "ecommercename"=>"Bla",
          "ecommerceversion"=>"3.1",
          "cmsversion"=>"2.4"
        );

        $tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
        return $tr;   
    }


    public static function getTransactionsOkResponse() {
        return '{
  "publicRequestKey": "1c960451-dbd4-4e1d-be6d-5b4a3f101740",
  "merchantId": "41702",
  "channel": "11"
}';

    }

    public static function getTransactions702Response() {
      return '{
  "errorCode": "702",
  "errorMessage": "Cuenta de vendedor invalida",
  "channel": "11"
}';
    }

    public static function getTransactionsFailResponse() {
      return '{
  "errorCode": "703",
  "errorMessage": "Dato inválido",
  "channel": "11"
}';
    } 
}
