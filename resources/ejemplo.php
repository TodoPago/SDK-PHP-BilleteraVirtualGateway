<?php
//importo archivo con SDK
include_once dirname(__FILE__)."/../vendor/autoload.php";
use TodoPago\Connector as Sdk;

$http_header = array('Authorization'=>'TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE');
$connector = new Sdk($http_header, "test");

$operationid = rand(1,10000000);

// BSA

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
	"availablePaymentMethods" => array("1","42"),
	"availableBanks" => array("11")
);

$technicalData = array(
	"pluginversion"=>"2.1",
	"ecommercename"=>"Bla",
	"ecommerceversion"=>"3.1",
	"cmsversion"=>"2.4"
);

$tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
$rta = $connector->billeteraVirtualGateway()->transactions($tr);
var_dump($rta);

$rta = $connector->billeteraVirtualGateway()->discover();
var_dump($rta);


$generalData = array(
	"merchant" => 41702,
	"security" => "TODOPAGO 8A891C0676A25FBF052D1C2FFBC82DEE",
	"operationName" => "Compra",
	"publicRequestKey" => "3fc8dcee-dd46-40f2-a178-0f74f01221eb",
	"remoteIpAddress" => "192.168.11.87"
);

$operationData = array(
	"resultCodeMedioPago" => -1,
	"resultCodeGateway" => -1,
	"idGateway" => 8,
	"resultMessage" => "APROBADA",
	"operationDatetime" => "20170704085736",
	"ticketNumber" => "1231122",
	"codigoAutorizacion" => "45007799",
	"currencyCode" => "032",
	"operationID" => "1234",
	"concept" => "compra",
	"amount" => "20,12",
	"facilitiesPayment" => "03"
);

$tokenizationData = array(
	"publicTokenizationField"=>"4444444444444444",
	"credentialMask"=>"4510XXXXX00001"
);

$pn = new \TodoPago\BilleteraVirtualGateway\PushNotify($generalData,$operationData,$tokenizationData);
$rta = $connector->billeteraVirtualGateway()->pushnotify($pn);
var_dump($rta);

// get Credentials
$u1 = new TodoPago\Data\User();
$u1->setUser("usuario@mail.com");
$u1->setPassword("Password");

//ejecuto los métodos
$rta = $connector->getCredentials($u1);
var_dump($rta);

