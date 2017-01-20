<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class AdvertisersTest extends \PHPUnit_Framework_TestCase
{
    private $stubClient;
    private $stubTicket;
    private $responseBody;
    private $responseBodySingle;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "Advertisers": [
    {
      "Id": 1234,
      "AgencyId": 9999,
      "Name": "Advertiser1",
      "TimeZoneName": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"
    },
    {
      "Id": 1235,
      "AgencyId": 9999,
      "Name": "Advertiser2",
      "TimeZoneName": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"
    }
  ]
}
JSON;

        // Create a mock
        $this->responseBodySingle = <<<JSON
{
  "Advertisers": [
    {
      "Id": 1234,
      "AgencyId": 9999,
      "Name": "Advertiser1",
      "TimeZoneName": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"
    }
  ]
}
JSON;

        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => strlen($this->responseBody)], $this->responseBody),
            new Response(200, ['Content-Length' => strlen($this->responseBodySingle)], $this->responseBodySingle),
        ]);
        $handler = HandlerStack::create($mock);

        $this->stubClient = new HttpClient(['handler' => $handler]);
        $this->stubTicket = $this->createMock(TicketInterface::class);

    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = new \Digitouch\AdForm\Service\Advertiser\Advertisers($this->stubClient, $this->stubTicket);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Advertiser\Advertisers::class, $service);
        $res = $service->getResponse()->fetch();
        $this->assertEquals($res, json_decode($this->responseBody)->Advertisers);
        $this->assertEquals($res[0]->Id, 1234);
        $this->assertEquals($res[1]->Name, 'Advertiser2');

        $serviceSingle = new \Digitouch\AdForm\Service\Advertiser\Advertisers($this->stubClient, $this->stubTicket, ['Names' => 'Advertiser1']);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Advertiser\Advertisers::class, $serviceSingle);
        $resSingle = $serviceSingle->getResponse()->fetch();
        $this->assertEquals($resSingle, json_decode($this->responseBodySingle)->Advertisers);
        $this->assertEquals($resSingle[0]->Name, 'Advertiser1');
    }


}
