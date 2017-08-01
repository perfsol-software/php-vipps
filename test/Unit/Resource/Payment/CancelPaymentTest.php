<?php

namespace Vipps\Tests\Unit\Resource\Payment;

use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Vipps\Model\Payment\RequestCancelPayment;
use Vipps\Model\Payment\ResponseCancelPayment;
use Vipps\Resource\Payment\CancelPayment;
use Vipps\Resource\HttpMethod;

class CancelPaymentTest extends PaymentResourceBaseTestBase
{

    /**
     * @var \Vipps\Resource\Payment\CancelPayment
     */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->resource = $this->getMockBuilder(CancelPayment::class)
            ->setConstructorArgs([$this->vipps, 'test_subscription_key', 'test_order_id', new RequestCancelPayment()])
            ->disallowMockingUnknownTypes()
            ->setMethods(['makeCall'])
            ->getMock();

        $this->resource
            ->expects($this->any())
            ->method('makeCall')
            ->will($this->returnValue(new Response(200, [], stream_for(json_encode([])))));
    }

    /**
     * @covers \Vipps\Resource\Payment\CancelPayment::getBody()
     * @covers \Vipps\Resource\Payment\CancelPayment::__construct()
     */
    public function testBody()
    {
        $this->assertNotEmpty($this->resource->getBody());
        // Valid JSON.
        $this->assertNotNull(json_decode($this->resource->getBody()));
    }

    /**
     * @covers \Vipps\Resource\Payment\CancelPayment::getMethod()
     */
    public function testMethod()
    {
        $this->assertEquals(HttpMethod::PUT, $this->resource->getMethod());
    }

    /**
     * @covers \Vipps\Resource\Payment\CancelPayment::getPath()
     */
    public function testPath()
    {
        $this->assertEquals('/Ecomm/v1/payments/test_order_id/cancel', $this->resource->getPath());
    }

    /**
     * @covers \Vipps\Resource\Payment\CancelPayment::call()
     */
    public function testCall()
    {
        $this->assertInstanceOf(ResponseCancelPayment::class, $response = $this->resource->call());
        $this->assertEquals(new ResponseCancelPayment(), $response);
    }
}
