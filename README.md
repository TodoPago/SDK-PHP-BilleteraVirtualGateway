## Integracion de BSA con Decidir

Este documento explicará como integrar BSA con Decidir utilizando PHP.
El siguiente diagrama explica el flujo de la implementación.


### Diagrama de secuencia
![Diagrama de secuencia](https://raw.githubusercontent.com/guillermoluced/docbsadec/master/img/bsa-decidir-secuence.png)

Etapas de integración BSA con Decidir
+ [Servicio Discover](#discover)
+ [Servicio Transaction](#transaction)
+ [Formulario TP de pago](#formtp)
+ [Solicitud de Token de Pago para BSA en Decidir](#tokendecidir)
+ [Ejecución del Pago para BSA en Decidir](#pagodecidir)
+ [Notificacion Push](#pushnotification)

####  Requerimientos
Tanto Todopago como Decidir tienen disponible una SDK de PHP que permite utilizar los servicios requeridos. Se pueden obtener desde:
+ Todopago SDK: https://github.com/TodoPago/SDK-PHP-BilleteraVirtualGateway
+ Decidir SDK: https://github.com/decidir/sdk-php-v2

Para operar en Todopago es necesario tener credenciales de Todopago, Nro. de Comercio (Merchant ID) y Credenciales (API Keys). 
Por parte de Decidir es necesario tener dada de alta una tienda y obtener las credenciales "Publickey" y Privatekey.

<a name="discover"></a>
### Servicio Discover
La SDK cuenta con un método para consultar los medios de pago disponibles para realizar un pago.

####  Ejemplo de implementación
```C#
	$rta = $connector->billeteraVirtualGateway()->discover();```
####  Respuesta

```php
object(TodoPago\BilleteraVirtualGateway\PaymentMethod) (5) {
      ["idMedioPago"]=>
      string(2) "42"
      ["nombre"]=>
      string(4) "VISA"
      ["tipoMedioPago"]=>
      string(8) "Crédito"
      ["idBanco"]=>
      string(4) "52"
      ["nombreBanco"]=>
      string(100) "BANCO BICA"
    }
```
<a name="idmediopago"></a>
<a name="nombreBanco"></a>
El campo **idMedioPago**,  sera utilizado al momento de momento de llamar al servicio [Transaction](#transaction) en el campo **paymentMethodId** del Request.
El **nombreBanco** sera requerido en **bankId** del Request del servicio [Transaction](#transaction).


<a name="transaction"></a>
### Servicio Transaction
El primer paso es registrar una transaccion con el servicio [Transaction](#https://github.com/TodoPago/SDK-PHP-BilleteraVirtualGateway#bvg-transaction) del  SDK de Todopago. Este requiere el Merchant y API Key de Todopago.





<table>
<tr><th>Nombre del campo</th><th>Required/Optional</th><th>Data Type</th><th>Comentarios</th></tr>
<tr><td>merchant</td><td>Required</td><td>String</td><td>ID de cuenta del vendedor. Ejemplo: 75087</td></tr>
<tr><td>security</td><td>Required</td><td>String</td><td>Authorization que deberá contener el valor del api key de la cuenta del vendedor. Ejemplo: TODOPAGO 3560b2f82b0f4860b8360dcd693058a9</td></tr>
<tr><td>operationDatetime</td><td>Required</td><td>String</td><td>Fecha Hora de la invocacion en Formato yyyyMMddHHmmssSSS</td></tr>
<tr><td>remoteIpAddress</td><td>Required</td><td>String</td><td>IP desde la cual se envía el requerimiento</td></tr>
<tr><td>operationType</td><td>Optional</td><td>String</td><td>Valor fijo definido para esta operatoria de integración</td></tr>
<tr><td>operationID</td><td>Required</td><td>String</td><td>ID de la operación en el eCommerce</td></tr>
<tr><td>currencyCode</td><td>Required</td><td>String</td><td>Valor fijo 32</td></tr>
<tr><td>concept</td><td>Optional</td><td>String</td><td>Especifica el concepto de la operación</td></tr>
<tr><td>amount</td><td>Required</td><td>String</td><td>Formato 999999999,99</td></tr>
<tr><td> availablePaymentMethods  </td><td>Optional</td><td>Array</td><td>Este campo se obtiene campo idMedioPago del request del servicio Discover. Si no se envía están habilitados todos los Medios de Pago del usuario.</td></tr>
<tr><td>availableBanks</td><td>Optional</td><td>Array</td><td>Este campo se obtiene campo idBanco del request del servicio Discover. Si no se envía están habilitados todos los bancos del usuario. Ejemplo: 42</td></tr>
<tr><td>buyerPreselection</td><td>Optional</td><td>BuyerPreselection</td><td>Preselección de pago del usuario. Ejemplo: 1</td></tr>
<tr><td>sdk</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>sdkversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>lenguageversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>pluginversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>ecommercename</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>ecommerceversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>cmsversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
</table>



####  Ejemplo de implementacion
```php
 $generalData = array(
 "merchant" => 1,
 "security" => "PRISMA 86333EFD8AD0C71CEA3BF06D7BDEF90D",
 "operationDatetime" => "201604251556134",
 "remoteIpAddress" => "192.168.11.87",
 "channel" => "BVTP"
);
$operationData = array(
 "operationType" => "Compra",
 "operationID" => "1234",
 "currencyCode" => "032",
 "concept" => "compra",
 "amount" => "999,99",
 "buyerPreselection" => array("paymentMethodId" => 42),
 "availablePaymentMethods" => array("1","42"),
 "availableBanks" => array(),
);
$technicalData = array(
 "sdk"=>"Java",
 "sdkversion"=>"2.0",
 "lenguageversion"=>"1.8",
 "pluginversion"=>"2.1",
 "ecommercename"=>"Bla",
 "ecommerceversion"=>"3.1",
 "cmsversion"=>"2.4"
);
$tr = new \TodoPago\BilleteraVirtualGateway\Transactions($generalData,$operationData,$technicalData);
$tr = $connector->billeteraVirtualGateway()->transactions($tr);
$respuesta = $tr->getResponse();
```
Este servicio requiere los siguientes atributos de la respuesta servicio Discover:
+ [idMedioPago](#idmediopago) para el campo "availablePaymentMethods.add('1')"
+ [nombreBanco](#nombreBanco) para el campo "availablePaymentMethods.Add('42')"

####  Respuesta

La respuesta tiene el atributo **publicRequestKey**, este requerido en el formulario de Todopago.
<a name="publicRequestKey"></a>
```php
array(5) {
["transactionid"]=>
	  string(36) "f9878b59-5ce6-408b-ace6-02ccc2d16ecb"
	  ["merchantId"]=>
	  string(36) "75087"
	  ["channel"]=>
	  string(2) "1"
}
```
<a name="formtp"></a>
### Formulario TP de pago

Luego de Transaction se debe utilizar formulario provisto por Todopago, este se puede implementar como se indica en el ejemplo. 
Para funcionar requiere ingresar en el atributo "publicKey" el **publicRequestKey** que respondió el servicio "Transaction".

Campo       | Descripción           | Tipo de dato | Ejemplo
------------|-----------------------|--------------|--------
publicKey   | requestpublickey del request del servicio Transaction  | String | 066aee1a-c36b-45f2-b827-d20a0d807284

#### Endpoints:
+ Ambientes de pruebas: https://forms.integration.todopago.com.ar/resources/TPBSAForm.js
+ Ambiente Produccion: https://forms.todopago.com.ar/resources/TPBSAForm.min.js

####  Ejemplo de implementacion
```html

<html>
    <head>
        <title>Formulario de pago TP</title>
        <meta charset="UTF-8">
        <script src="https://forms.integration.todopago.com.ar/resources/TPBSAForm.js"></script>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script type="text/javascript">
        </script>
    </head>
	<body>
	    <script>
		var success = function(data) {
		    console.log(data);
		};
		var error = function(data) {
		    console.log(data);
		};
		var validation = function(data) {
		    console.log(data);
		}
		window.TPFORMAPI.hybridForm.initBSA({
		    publicKey: "requestpublickey",
		    merchantAccountId: "merchant",
		    callbackCustomSuccessFunction: "success",
		    callbackCustomErrorFunction: "error",
		    callbackValidationErrorFunction: "validation"
		});
	    </script>
	</body>
</html>
```
El formulario requiere obligatoriamente ingresar en el campo **publicKey** dentro del "window.TPFORMAPI.hybridForm.initBSA", el atributo [publicRequestKey](#publicRequestKey) que devuelve request del servicio [Transaction](#transaction).

Al cargar el formulario se mostrara una ventana de Login para ingresar el usuario de billetera.

![login](https://raw.githubusercontent.com/guillermoluced/docbsadec/master/img/login-formulario-tp.png)

Luego de loguearse el formulario mostrara la lista de medios de pago habilitados.

![formulario](https://raw.githubusercontent.com/guillermoluced/docbsadec/master/img/formulario-bsa_medios_pago.png)

####  Respuesta
Si la compra fue aprobada el formulario devolverá un JSON con la siguiente estructura.
<a name="formularioresponse"></a>
```html
{
"ResultCode":1,
"ResultMessage":"El medio de pago se selecciono correctamente",
"Action":"accion"
"SessionId":"DB37611F-6510-2423-1223-1C4F76F04A0D",
"IdCuenta":"41703",
"Token":"4507991692027787",
"MerchantAccountId": "46523",
"BankId":"17",
"CardNumberBin": 450799,
"FourLastDigitsOfCardNumber":"7783",
"PaymentMethodID":"42",
"SecurityCodeCheck": "false",
"SelectorClaveFlag": "1",
"TokenDate": "20180427",
"TokenizationFlag": "false",
"DatosAdicionales": {
	"tipoDocumento": "DNI",
	"numeroDocumento": "45998745",
	"generoCuentaCompradora": "M",
	"nombre": "Comprador",
	"apellido": "BSA",
  	"permiteObtenerMP": false
},
"VOLATILE_ENCRYPTED_DATA": "YRfrWggICAggsF0nR6ViuAgWsPr5ouR5knIbPtkN+yntd7G6FzN/Xb8zt6+QHnoxmpTraKphZVHvxA=="
"BSA":true
} 
```
Los atributos **Token** y **VOLATILE_ENCRYPTED_DATA** serán requeridos por el siguiente servicio [payment de Decidir](#tokendecidir).

<a name="tokendecidir"></a>
###  Solicitud de Token de Pago para BSA en Decidir

Para implementar los servicios de Decidir en PHP se deberá descargar la ultima versión del SDK [SDK PHP Decidir](https://github.com/decidir/sdk-php-v2). Ademas es necesario tener disponibles las claves publicas y privadas provistas por Decidir.
Luego de importar el SDK en el proyecto e instanciar el SDK, se debe llamar a este servicio para obtener el token de pago de Decidir.

Campo       | Descripción           | Tipo de dato | Ejemplo
------------|-----------------------|--------------|--------
public_token| Campo String que se obtiene en la respuesta del formulario de pago de Todopago ("Token":"4507991692027787")| String     | 4507994025297787
volatile_encrypted_data| Este se obtiene en la respuesta del formulario de pago de Todopago ("VOLATILE_ENCRYPTED_DATA": "YRfrWggICAggsF0nR6ViuAgWsPr5ouR5knIbPtkN+yntd7G6FzN/Xb8zt6+QHnoxmpTraKphZVHvxA==")| String     | YRfrWggICAggsF0nR6ViuAgWsPr5ouR5knIbPtkN+yntd7G6FzN/Xb8zt6+QHnoxmpTraKphZVHvxA==
public_request_key| Este se obtiene a partir del publicRequestKey, en la respuesta del servicio Transaction (publicRequestKey = "0e6d1f45-a85e-480f-a98f-5f18cf881b9b")| String | publicRequestKey
flag_security_code|  | String     | 0
flag_tokenization|  | String     | 0
flag_selector_key|  | String     | 1
flag_pei| Se define si PEI esta habilitado | String | 1
card_holder_name| Nombre del titular de la tarjeta | String | "Pepe"
card_holder_identification.type| tipo de identificacion | String | "dni"
card_holder_identification.number| Numero de identificacion | String | "23968498"
fraud_detection.device_unique_identifier | Numero unico de identificacion | String | "12345"

#### Ejemplo de implementacion
```php
$data = array(
 "public_token" => "45079912",
 "volatile_encrypted_data" => "12341231",
 "public_request_key" => "12345678",
 "ip_address" => "1.14.1.1",
 "issue_date" => "201607040857364",
 "flag_security_code" => "1",
 "flag_tokenization" => "0",
 "flag_selector_key" => "1",
 "flag_pei" => "1",
 "card_holder_name" => "Pedro",
 "card_holder_identification" => array("type" => "dni","number" => "31145654"),
 "fraud_detection" => array("device_unique_identifier" =>"12345")
 );
$response = $connector->cardToken()->bsaToken($data);
print_r($response)
```
Este servicio requiere los siguientes atributos de la respuesta del Formulario de pago Todopago y del servicio Transaction:
+ [Token](#formularioresponse) para el campo "availablePaymentMethods.add('1')"
+ [VOLATILE_ENCRYPTED_DATA](#formularioresponse) para el campo "tokensData.volatile_encrypted_data"
+ [publicRequestKey](#publicRequestKey) para el campo "tokensData.public_request_key"
<a name="tokenresponse"></a>
#### Respuesta:
```C#
{
	{
	   "id": "708fe42a-c8f9-4468-8029-6d06dc3fca9a",
	   "status": "active",
	   "card_number_length": 16,
	   "date_created": "2019-01-11T12:12Z",
	   "bin": "450799",
	   "last_four_digits": "4905",
	   "security_code_length": 0,
	   "expiration_month": 8,
	   "expiration_year": 19,
	   "date_due": "2019-01-11T14:42Z",
	   "cardholder": {
	       "identification": {
	           "type": "dni",
	           "number": "33222444"
	       },
	       "name": "Comprador"
	   }
	}
}
```
El servicio [Decidir Payment](#pagodecidir) requiere el token devuelto en el Request en el campo **id** :"708fe42a-c8f9-4468-8029-6d06dc3fca9a".

<a name="pagodecidir"></a>
### Ejecución del Pago para BSA en Decidir

Luego de generar el Token de pago con el servicio anterior se deberá ejecutar la solicitud de pago de la siguiente manera. Ingresando en "token" el **token** de pago previamente generado en el servicio anterior.

*Aclaracion* : amount es un campo double el cual debería tener solo dos dígitos decimales.

|Campo | Descripcion  | Oblig | Restricciones  |Ejemplo   |
| ------------ | ------------ | ------------ | ------------ | ------------ |
|id  | id usuario que esta haciendo uso del sitio, pertenece al campo customer (ver ejemplo)  |Condicional, si no se enviar el Merchant este campo no se envia  |Sin validacion   | user_id: "marcos",  |
|email  | email del usuario que esta haciendo uso del sitio (se utiliza para tokenizacion), pertenece al campo customer(ver ejemplo)  |Condicional   |Sin validacion   | email: "user@mail.com",  |
|ip_address  | IP del comercio | Condicional |Sin validacion   | ip_address: "192.168.100.2",  |
|site_transaction_id   | nro de operacion  |SI   | Alfanumerico de hasta 39 caracteres  | "prueba 1"  |
| site_id  |Site relacionado a otro site, este mismo no requiere del uso de la apikey ya que para el pago se utiliza la apikey del site al que se encuentra asociado.   | NO  | Se debe encontrar configurado en la tabla site_merchant como merchant_id del site_id  | 28464385  |
| token  | token generado en el servicio token de Decidir, se puede obtener desde el campo id de la respuesta. Ejemplo: "id" : "708fe42a-c8f9-4468-8029-6d06dc3fca9a"  |SI   |Alfanumerico de hasta 36 caracteres. No se podra ingresar un token utilizado para un  pago generado anteriormente.   | ""  |
| payment_method_id  | id del medio de pago  |SI  |El id debe coincidir con el medio de pago de tarjeta ingresada.Se valida que sean los primeros 6 digitos de la tarjeta ingresada al generar el token.    | payment_method_id: 1,  |
|bin   |primeros 6 numeros de la tarjeta   |SI |Importe minimo = 1 ($0.01)  |bin: "456578"  |
|amount  |importe del pago   |  SI| Importe Maximo = 9223372036854775807 ($92233720368547758.07) |amount=20000  |
|currency   |moneda   | SI|Valor permitido: ARS   | ARS  |
|installments   |cuotas del pago   | SI|"Valor minimo = 1 Valor maximo = 99"     |  installments: 1 |
|payment_type   |forma de pago   | SI| Valor permitido: single / distributed
|"single"   |
|establishment_name   |nombre de comercio |Condicional   | Alfanumerico de hasta 25 caracteres |  "Nombre establecimiento"  |

#### Ejemplo:

```php
  
$bsa_data = array("public_token" => "45079912",
 "volatile_encrypted_data" => "12341231",
 "public_request_key" => "12345678",
 "ip_address" => "1.14.1.1",
 "issue_date" => "201607040857364",
 "flag_security_code" => "1",
 "flag_tokenization" => "0",
 "flag_selector_key" => "1",
 "flag_pei" => "1",
 "card_holder_name" => "Pedro",
 "card_holder_identification" => array("type" => "dni","number" => "311345654"),
 "fraud_detection" => array("device_unique_identifier" => "12345")
 );
$data = array(
 "site_transaction_id" => "160218_19",
 "payment_mode" => "bsa",
 "card_token_bsa" => $bsa_data,
 "customer" => array("id" => "108", "email" => "email@mail.com"),
 "payment_method_id" => 1,
 "amount" => 12.00,
 "bin" => "450799",
 "currency" => "ARS",
 "installments" => 1,
 "description" => "prueba",
 "payment_type" => "single",
 "sub_payments" => array()
);
$response = $connector->payment()->ExecutePayment($data);
print_r($response);
```
Este servicio requiere el siguiente atributo de la respuesta del servicio [Token](#tokendecidir) de Decidir:
+ [id](#tokenresponse) para el campo "payment.token"

<a name="pagodecidirresponse"></a>
#### Respuesta:
```C#
{
    "id": 1391404,
    "site_transaction_id": "110119_02",
    "payment_method_id": 1,
    "card_brand": "Visa",
    "amount": 2000,
    "currency": "ars",
    "status": "approved",
    "status_details": {
        "ticket": "5746",
        "card_authorization_code": "151936",
        "address_validation_code": "VTE0011",
        "error": null
    },
    "date": "2019-01-11T12:19Z",
    "customer": {
        "id": "user",
        "email": "user@mail.com"
    },
    "bin": "450799",
    "installments": 1,
    "first_installment_expiration_date": null,
    "payment_type": "single",
    "sub_payments": [],
    "site_id": "00030118",
    "fraud_detection": {
        "status": null
    },
    "aggregate_data": null,
    "establishment_name": "prueba desa soft",
    "spv": null,
    "confirmed": null,
    "pan": null,
    "customer_token": "f2931755d7e472d2c553eef9026717a9cb3bb91185c6e44f6c02f8ac46b9659e",
    "card_data": "/tokens/1391404"
}
```
Los datos necesarios para el siguiente servicio [Notification Push](#pushnotification) son **status**, **ticket**, **authorization**.

<a name="pushnotification"></a>
### Notification Push

Registra la fiscalización de una transacción. El método retorna el objeto NotificationPushBVG con el resultado de la notificación. Para funcionar requiere los siguientes campo:
<table>
<tr><th>Nombre del campo</th><th>Required/Optional</th><th>Data Type</th><th>Comentarios</th></tr>
<tr><td>Security</td><td>Required</td><td>String</td><td>Authorization que deberá contener el valor del api key de la cuenta del vendedor (Merchant). Este dato viaja en el Header HTTP.
Ejemplo: TODOPAGO 3560b2f82b0f4860b8360dcd693058a9 </td></tr>
<tr><td>Merchant</td><td>Required</td><td>String</td><td>ID de cuenta del comercio de Todopago</td></tr>
<tr><td>RemoteIpAddress</td><td>Optional</td><td>String</td><td>IP desde la cual se envía el requerimiento</td></tr>
<tr><td>PublicRequestKey</td><td>Required</td><td>String</td><td>El publicRequestKey se obtiene en la respuesta del servicio Transaction. Ejemplo:  publicRequestKey: 710268a7-7688-c8bf-68c9-430107e6b9da</td></tr>
<tr><td>OperationName</td><td>Required</td><td>String</td><td>Valor que describe la operación a realizar, debe ser fijo entre los siguientes valores: “Compra”, “Devolucion” o “Anulacion”</td></tr>
<tr><td>ResultCodeMedioPago</td><td>Optional</td><td>String</td><td>Código de respuesta de la operación propocionado por el medio de pago</td></tr>
<tr><td>ResultCodeGateway</td><td>Optional</td><td>String</td><td>Código de respuesta de la operación propocionado por el gateway</td></tr>
<tr><td>idGateway</td><td>Optional</td><td>String</td><td>Id del Gateway que procesó el pago. Si envían el resultCodeGateway, es obligatorio que envíen este campo. Ejemplo: 8</td></tr>
<tr><td>ResultMessage</td><td>Optional</td><td>String</td><td>Detalle de respuesta de la operación.</td></tr>
<tr><td>OperationDatetime</td><td>Required</td><td>String</td><td>Fecha Hora de la operación en el comercio en Formato yyyyMMddHHmmssMMM</td></tr>
<tr><td>TicketNumber</td><td>Optional</td><td>String</td><td>Numero de ticket generado, este valor se obtiene desde la respuesta del servicio de pago de Decidir</td></tr>
<tr><td>CodigoAutorizacion</td><td>Optional</td><td>String</td><td>Codigo de autorización de la operación, se obtiene desde la respuesta del servicio de pago de Decidir </td></tr>
<tr><td>CurrencyCode</td><td>Required</td><td>String</td><td>Valor fijo 32</td></tr>
<tr><td>OperationID</td><td>Required</td><td>String</td><td>ID de la operación en el eCommerce</td></tr>
<tr><td>Amount</td><td>Required</td><td>String</td><td>Formato 999999999,99</td></tr>
<tr><td>FacilitiesPayment</td><td>Required</td><td>String</td><td>Formato 99</td></tr>
<tr><td>Concept</td><td>Optional</td><td>String</td><td>Especifica el concepto de la operación dentro del ecommerce</td></tr>
<tr><td>PublicTokenizationField</td><td>Required</td><td>String</td><td>4507991692027787, este valor se obtiene en la respuesta del formulario de pago de Todopago</td></tr>
<tr><td>CredentialMask</td><td>Optional</td><td>String</td><td>4507XXXXXXXX4905,  corresponsde a los primeros cuatro numeros de la tarjeta seguido por 8 X y los ultimos cuatro numeros de la tarjeta</td></tr>
</table>


#### Ejemplo:

```php
$generalData = array(
 "merchant" => 1,
 "security" => "PRISMA 86333EFD8AD0C71CEA3BF06D7BDEF90D",
 "operationName" => "Compra",
 "publicRequestKey" => "c748b257-6f35-425a-9802-9455118092ba",
 "remoteIpAddress" => "192.168.11.87"
);
$operationData = array(
 "resultCodeMedioPago" => -1,
 "resultCodeGateway" => -1,
 "idGateway" => 8,
 "resultMessage" => "APROBADA",
 "operationDatetime" => "201607040857364",
 "ticketNumber" => "1231122",
 "codigoAutorizacion" => "45007799",
 "currencyCode" => "032",
 "operationID" => "1234",
 "concept" => "compra",
 "amount" => "200.12",
 "facilitiesPayment" => "03"
);
$tokenizationData = array(
 "publicTokenizationField"=>"sydguyt3e862t76ierh76487638rhkh7",
 "credentialMask"=>"450799XXXXXX4905"
);
$push = new \TodoPago\BilleteraVirtualGateway\PushNotify($generalData,$operationData,$tokenizationData);
$push = $connector->billeteraVirtualGateway()->pushnotify($push);
$respuesta = $push->getResponse();
```
Este servicio requiere los siguientes atributos de la respuesta del servico Transaction, Formulario de pag Todopago y servicio Payment de Decidir2:
+ [publicRequestKey](#publicRequestKey) para el campo "generalData.Add(ElementNames.BVG_PUBLIC_REQUEST_KEY,"")"
+ [Token](#formularioresponse) para el campo "tokenizationData.Add(ElementNames.BVG_PUBLIC_TOKENIZATION_FIELD. "")"
+ [ticket](#pagodecidirresponse) para el campo "operationData.Add(ElementNames.BVG_TICKET_MUNBER, "")"
+ [status](#pagodecidirresponse) para el campo "operationData.Add(ElementNames.BVG_RESULT_MESSAGE, "")"
+ [authorization](#pagodecidirresponse) para el campo "operationData.Add(ElementNames.BVG_CODIGO_AUTORIZATION, "")"

#### Respuesta:
```php
array {
  ["statusCode"] => -1,
  ["statusMessage"] => OK 
}
```


