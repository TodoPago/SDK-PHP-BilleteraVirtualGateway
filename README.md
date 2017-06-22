<a name="inicio"></a>
Todo Pago - módulo SDK-PHP para conexión con gateway de pago
=======

+ [Instalación](#instalacion)
 	+ [Versiones de php soportadas](#Versionesdephpsoportadas)
 	+ [Generalidades](#general)
+ [Uso](#uso)
    + [Inicializar la clase correspondiente al conector (TodoPago\Connector)](#initconector)
    + [Ambientes](#test)
    + [Billetera Virtual para Gateways](#bvg)
      + [Diagrama de Secuencia](#bvg-uml)
      + [Discover](#bvg-discover)
      + [Transaction](#bvg-transaction)
      + [Formulario Billetera](#bvg-form)
      + [Notificación Push](#bvg-push)
      + [Obtener Credenciales](#credenciales)

<a name="instalacion"></a>
## Instalación
Se recomienda realizar la instalación a través de Composer.

```php
composer require todopago/php-sdk-billetera-virtual-gateway
```
Luego de la instalacion se debe incluir el archivo vendor/autoload.php en el proyecto.

También se puede descargar la última versión del SDK desde el botón Download ZIP del branch master.
Una vez descargado y descomprimido, debe incluirse el archivo autoload.php que se encuentra en la carpeta /TodoPago/lib/vendor como librería dentro del proyecto.


<a name="Versionesdephpsoportadas"></a>
#### 1. Versiones de php soportadas
La versi&oacute;n implementada de la SDK, esta testeada para la version PHP 5.3 en adelante.

<a name="general"></a>
#### 2. Generalidades
Esta versión soporta únicamente pago en moneda nacional argentina (CURRENCYCODE = 32).

[<sub>Volver a inicio</sub>](#inicio)
<br>

<a name="test"></a>
#### Ambientes

El SDK-PHP permite trabajar con los ambiente de Developers y de Producción de Todo Pago.<br>
El ambiente se debe instanciar como se indica a continuacion.

```php
$mode = "test";//identificador de entorno obligatorio, la otra opcion es prod
$http_header = array('Authorization'=>'TODOPAGO 912EC803B2CE40E4A541068D495AB570');//authorization key del ambiente requerido

$connector = new TodoPago\Connector($http_header, $mode);
```

Puede consultar los datos de prueba en la [web de TodoPago](https://developers.todopago.com.ar/site/datos-de-prueba).

[<sub>Volver a inicio</sub>](#inicio)
<br>

<a name="uso"></a>
## Uso
<a name="initconector"></a>
### Inicializar la clase correspondiente al conector (TodoPago\Connector).

- Crear un array con los http headers (API Keys) suministrados por Todo Pago
```php
$http_header = array('Authorization'=>'TODOPAGO 912EC803B2CE49E4A541068D495AB570');
```

- Crear una instancia de la clase TodoPago\Connector
```php
$connector = new TodoPago\Connector($http_header, $mode); // $mode: "test" para developers, "prod" para producción
```

<a name="bvg"></a>
## Billetera Virtual para Gateways

La Billetera Virtual para Gateways es la versión de Todo Pago para los comercios que permite utilizar los servicios de la billetera TodoPago dentro de los e-commerce, respetando y manteniendo sus respectivas promociones con bancos, marcas y números de comercio (métodos de adquirencia). Manteniendo su Gateway de pago actual, y utilizando BVG para la selección del medio de pago y la tokenización de la información para mayor seguridad en las transacciones.

<a name="bvg-uml"></a>
### Diagrama de secuencia

![Diagrama de Secuencia BSA](http://www.plantuml.com/plantuml/png/ZL9BJiCm4Dtd5BDi5roW2oJw0I7ngMWlC3ZJOd0zaUq4XJknuWYz67Q-JY65bUNHlFVcpHiKZWqib2JjACdGE2baXjh1DPj3hj187fGNV20ZJehppTNWVuEEth5C4XHE5lxJAJGlN5nsJ323bP9xWWptQ42mhlXwQAlO0JpOTtZSXfMNT0YFcQzhif1MD0oJfRI22pBJdYYm1jnG-ubinjhZjcXUoQ654kQe1TiafG4srczzpE0-9-iC0f-CSDPgQ3v-wQvtLAVskTB5yHE156ISofG33dEVdFp0ccYoDQXje64z7N4P1iN_cRgZmkU8yH48Gm4JLIA3VJM0UIzrRob2H6s_xl1PAaME38voRqYH28l6DgzJqjxpaegSLE6JvJVIthZNu7BW83BVtAp7hVqTLcVezrr3Eo_jORVD8wTaoERAOHMKgXEErjwI_CpvLk_yS1ZX6pXCrhbzUM0dTsKJRoJznsMUdwOZYMirnpS0)

Para acceder al servicio, los vendedores podrán adherirse en el sitio exclusivo de Botón o a través de su ejecutivo comercial. En estos procesos se generará el usuario y clave para este servicio.

<a name="bvg-discover"></a>
### Discover
El método **discover** permite conocer los medios de pago disponibles

 ```php
$rta = $connector->billeteraVirtualGateway()->discover();
```

Se devuelve un objecto **TodoPago\BilleteraVirtualGateway\Discover**, que implementa las interfaces de *Iterable* y *ArrayAccess* con una coleción de **TodoPago\BilleteraVirtualGateway\PaymentMethods** conteniendo la información de cada medio de pago disponible.
Por cada medio de pago veremos lo siguiente:

Campo       | Descripción           | Tipo de dato | Ejemplo
------------|-----------------------|--------------|--------
id          | Id del medio de pago  | numérico     | 42
nombre      | Marca de la tarjeta   | string       | "VISA"
tipo        | Tipo de medio de pago | string       | "Crédito"
idBanco     | Id del banco          | numérico     | 10
nombreBanco | Nombre del banco      | string       | "Banco Ciudad"

Ejemplo de respuesta:

```
    object(TodoPago\BilleteraVirtualGateway\PaymentMethod)#8 (5) {
      ["id":protected]=>
      string(2) "42"
      ["nombre":protected]=>
      string(4) "VISA"
      ["tipo":protected]=>
      string(8) "Crédito"
      ["idBanco":protected]=>
      NULL
      ["nombreBanco":protected]=>
      NULL
    }
```

[<sub>Volver a inicio</sub>](#inicio)
<br>

<a name="bvgtransaction"></a>
### Transaction
El método **transaction** permite registrar una transacción.

Se debe instanciar un objeto **TodoPago\BilleteraVirtualGateway\Transaction** con los datos de la misma, el mismo será devuelto con los datos de la respuesta del servicio.

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

Ejemplo de respuesta:

```
	array(5) {
	  ["transactionid"]=>
	  string(36) "f9878b59-5ce6-408b-ace6-02ccc2d16ecb"
	  ["publicRequestKey"]=>
	  string(36) "b6f492ea-b829-43c0-a8f6-5af95ae93001"
	  ["requestKey"]=>
	  string(36) "9ca41afb-48d0-4268-a9c5-5904d9f207a4"
	  ["url_HibridFormResuorces"]=>
	  string(28) "www.google.com.ar/Formulario"
	  ["channel"]=>
	  string(2) "11"
	}

```

#### Datos de referencia

<table>
<tr><th>Nombre del campo</th><th>Required/Optional</th><th>Data Type</th><th>Comentarios</th></tr>
<tr><td>security</td><td>Required</td><td>String</td><td>Campo de autorización que deberá contener el valor del api key de la cuenta del vendedor (Merchant)</td></tr>
<tr><td>operationDatetime</td><td>Required</td><td>String</td><td>Fecha Hora de la invocación en Formato yyyyMMddHHmmssSSS</td></tr>
<tr><td>remoteIpAddress</td><td>Required</td><td>String</td><td>IP desde la cual se envía el requerimiento</td></tr>
<tr><td>merchant</td><td>Required</td><td>String</td><td>ID de cuenta del vendedor</td></tr>
<tr><td>operationType</td><td>Optional</td><td>String</td><td>Valor fijo definido para esta operatoria de integración</td></tr>
<tr><td>operationID</td><td>Required</td><td>String</td><td>ID de la operación en el eCommerce</td></tr>
<tr><td>currencyCode</td><td>Required</td><td>String</td><td>Valor fijo 32</td></tr>
<tr><td>concept</td><td>Optional</td><td>String</td><td>Especifica el concepto de la operación</td></tr>
<tr><td>amount</td><td>Required</td><td>String</td><td>Formato 999999999,99</td></tr>
<tr><td>availablePaymentMethods</td><td>Optional</td><td>Array</td><td>Array de Strings obtenidos desde el servicio de descubrimiento de medios de pago. Lista de ids de Medios de Pago habilitados para la transacción. Si no se envía están habilitados todos los Medios de Pago del usuario.</td></tr>
<tr><td>availableBanks</td><td>Optional</td><td>Array</td><td>Array de Strings obtenidos desde el servicio de descubrimiento de medios de pago. Lista de ids de Bancos habilitados para la transacción. Si no se envía están habilitados todos los bancos del usuario.</td></tr>
<tr><td>buyerPreselection</td><td>Optional</td><td>BuyerPreselection</td><td>Preselección de pago del usuario</td></tr>
<tr><td>sdk</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>sdkversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>lenguageversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>pluginversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>ecommercename</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>ecommerceversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
<tr><td>cmsversion</td><td>Optional</td><td>String</td><td>Parámetro de versión de API</td></tr>
</table>
<br>
<strong>BuyerPreselection</strong>
<br>
<table>
<tr><th>Nombre del campo</th><th>Data Type</th><th>Comentarios</th></tr>
<tr><td>paymentMethodId</td><td>String</td><td>Id del medio de pago seleccionado</td></tr>
<tr><td>bankId</td><td>String</td><td>Id del banco seleccionado</td></tr>
</table>

[<sub>Volver a inicio</sub>](#inicio)


<a name="bvg-form"></a>
### Formulario Billetera
Para abrir el formulario se debe agregar un archivo javascript provisto por TodoPago e instanciar la API Javascript tal cual se muestra en el ejemplo correspondiente.

[Ver ejemplo](resources/form_hibrido-ejemplo/index.html)

[<sub>Volver a inicio</sub>](#inicio)


<a name="bvg-push"></a>
### Notificación Push
El método **pushnotify** permite registrar la finalización de una transacción.

Se debe instanciar un objeto **TodoPago\BilleteraVirtualGateway\PushNotify** con los datos de la misma, el mismo será devuelto con los datos de la respuesta del servicio.

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

Ejemplo de respuesta:

```
	array(2) {
	  ["statusCode"]=>
	  string(2) "-1"
	  ["statusMessage"]=>
	  string(2) "OK"
	}

```

#### Datos de referencia

<table>
<tr><th>Nombre del campo</th><th>Required/Optional</th><th>Data Type</th><th>Comentarios</th></tr>
<tr><td>Security</td><td>Required</td><td>String</td><td>Authorization que deberá contener el valor del api key de la cuenta del vendedor (Merchant). Este dato viaja en el Header HTTP</td></tr>
<tr><td>Merchant</td><td>Required</td><td>String</td><td>ID de cuenta del comercio</td></tr>
<tr><td>RemoteIpAddress</td><td>Optional</td><td>String</td><td>IP desde la cual se envía el requerimiento</td></tr>
<tr><td>PublicRequestKey</td><td>Required</td><td>String</td><td>publicRequestKey de la transacción creada. Ejemplo: 710268a7-7688-c8bf-68c9-430107e6b9da</td></tr>
<tr><td>OperationName</td><td>Required</td><td>String</td><td>Valor que describe la operación a realizar, debe ser fijo entre los siguientes valores: “Compra”, “Devolucion” o “Anulacion”</td></tr>
<tr><td>ResultCodeMedioPago</td><td>Optional</td><td>String</td><td>Código de respuesta de la operación propocionado por el medio de pago</td></tr>
<tr><td>ResultCodeGateway</td><td>Optional</td><td>String</td><td>Código de respuesta de la operación propocionado por el gateway</td></tr>
<tr><td>idGateway</td><td>Optional</td><td>String</td><td>Id del Gateway que procesó el pago. Si envían el resultCodeGateway, es obligatorio que envíen este campo</td></tr>
<tr><td>ResultMessage</td><td>Optional</td><td>String</td><td>Detalle de respuesta de la operación.</td></tr>
<tr><td>OperationDatetime</td><td>Required</td><td>String</td><td>Fecha Hora de la operación en el comercio en Formato yyyyMMddHHmmssMMM</td></tr>
<tr><td>TicketNumber</td><td>Optional</td><td>String</td><td>Numero de ticket generado</td></tr>
<tr><td>CodigoAutorizacion</td><td>Optional</td><td>String</td><td>Codigo de autorización de la operación</td></tr>
<tr><td>CurrencyCode</td><td>Required</td><td>String</td><td>Valor fijo 32</td></tr>
<tr><td>OperationID</td><td>Required</td><td>String</td><td>ID de la operación en el eCommerce</td></tr>
<tr><td>Amount</td><td>Required</td><td>String</td><td>Formato 999999999,99</td></tr>
<tr><td>FacilitiesPayment</td><td>Required</td><td>String</td><td>Formato 99</td></tr>
<tr><td>Concept</td><td>Optional</td><td>String</td><td>Especifica el concepto de la operación dentro del ecommerce</td></tr>
<tr><td>PublicTokenizationField</td><td>Required</td><td>String</td><td></td></tr>
<tr><td>CredentialMask</td><td>Optional</td><td>String</td><td></td></tr>
</table>

[<sub>Volver a inicio</sub>](#inicio)
<br>

<a name="credenciales"></a>
### Obtener credenciales
El SDK permite obtener las credenciales "Authentification", "MerchandId" y "Security" de la cuenta de Todo Pago, ingresando el usuario y contraseña.<br>
Esta funcionalidad es útil para obtener los parámetros de configuración dentro de la implementación.

- Crear una instancia de la clase User:
```php

$http_header = array();

$connector = new TodoPago\Connector($http_header, "test");//instanciar SDK

$datosUsuario = array(
	"user" => "usuario@todopago.com.ar",
	"password" => "contraseña"
);

$credenciales = new TodoPago\Data\User($datosUsuario);
```

Tambien se puede pasar los datos de usuario de la siguiente manera:

```php
$credenciales = new TodoPago\Data\User("usuario@todopago.com.ar", "contraseña");
```

```php
$credenciales = new TodoPago\Data\User();
$credenciales->setUser("usuario@todopago.com.ar");
$credenciales->setPassword("contraseña");
```

- Obtener respuesta de servicio:
```php
$rta = $connector->getCredentials($credenciales);
$rta->getMerchant();
$rta->getApikey();
```
**Observación**: El Security se obtiene a partir de apiKey, eliminando TODOPAGO de este último.

[<sub>Volver a inicio</sub>](#inicio)
