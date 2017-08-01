<?php

namespace Vipps\Tests\Unit\Resource\Payment;

use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Vipps\Model\Payment\ResponseGetPaymentDetails;
use Vipps\Resource\Payment\GetPaymentDetails;
use Vipps\Resource\HttpMethod;

class GetPaymentDetailsTest extends PaymentResourceBaseTestBase
{

    /**
     * @var \Vipps\Resource\Payment\GetPaymentDetails
     */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->resource = $this->getMockBuilder(GetPaymentDetails::class)
            ->setConstructorArgs([
                $this->vipps,
                'test_subscription_key',
                'test_merchant_serial_number',
                'test_order_id'
            ])
            ->disallowMockingUnknownTypes()
            ->setMethods(['makeCall'])
            ->getMock();

        $this->resource
            ->expects($this->any())
            ->method('makeCall')
            ->will($this->returnValue(new Response(200, [], stream_for(json_encode([])))));
    }

    /**
     * @covers \Vipps\Resource\Payment\GetPaymentDetails::getBody()
     * @covers \Vipps\Resource\Payment\GetPaymentDetails::__construct()
     */
    public function testBody()
    {
        $this->assertEmpty($this->resource->getBody());
    }

    /**
     * @covers \Vipps\Resource\Payment\GetPaymentDetails::getMethod()
     */
    public function testMethod()
    {
        $this->assertEquals(HttpMethod::GET, $this->resource->getMethod());
    }

    /**
     * @covers \Vipps\Resource\Payment\GetPaymentDetails::getPath()
     */
    public function testPath()
    {
        $this->assertEquals(
            '/Ecomm/v1/payments/test_order_id/serialNumber/test_merchant_serial_number/details',
            $this->resource->getPath()
        );
    }

    /**
     * @covers \Vipps\Resource\Payment\GetPaymentDetails::call()
     */
    public function testCall()
    {
        $this->assertInstanceOf(ResponseGetPaymentDetails::class, $response = $this->resource->call());
        $this->assertEquals(new ResponseGetPaymentDetails(), $response);
    }
}
