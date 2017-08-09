<?php

namespace TodoPago\Test;

require_once('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class DiscoverTest extends TestCase {

    use \phpmock\phpunit\PHPMock;

    public function testDiscoverOk() {

        $sdk = new \TodoPago\Connector(array("Authorization" => "TODOPAGO ABCDEF1234567890"),"test");
        $response = $sdk->billeteraVirtualGateway()->discover();

        $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\Discover::class, $response);

        $pm = $response[0];
        $this->assertEquals("1", $pm->getId());
        $this->assertEquals("AMEX", $pm->getNombre());
        $this->assertEquals("52", $pm->getIdBanco());
        $this->assertEquals("BANCO BICA", $pm->getNombreBanco());
        $this->assertEquals("Crédito", $pm->getTipoMedioPago());

        foreach($response as $pm) {
            $this->assertInstanceOf(\TodoPago\BilleteraVirtualGateway\PaymentMethod::class, $pm);
        }

        $this->assertTrue(is_array($response->getPaymentMethods()));
    } 

    public function testDiscoverClass() {
        $disc = new \TodoPago\BilleteraVirtualGateway\Discover();

        $this->assertEmpty($disc->getPaymentMethods());

        $disc["test"] = new \TodoPago\BilleteraVirtualGateway\PaymentMethod(array("idMedioPago" => 1, "nombre" => "test", "idBanco" => 1, "nombreBanco" => "test", "tipoMedioPago" => "test"));

        $this->assertEquals(1, count($disc->getPaymentMethods()));

        $disc[] = new \TodoPago\BilleteraVirtualGateway\PaymentMethod(array("idMedioPago" => 2, "nombre" => "test", "idBanco" => 2, "nombreBanco" => "test", "tipoMedioPago" => "test"));

        $this->assertTrue(isset($disc["test"]));

        unset($disc["test"]);

        $this->assertFalse(isset($disc["test"]));

    }

   
}
