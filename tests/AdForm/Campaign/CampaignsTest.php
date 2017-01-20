<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class CampaignsTest extends \PHPUnit_Framework_TestCase
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
  "campaigns": [
    {
      "id": 4321,
      "code": "fk-it-4321",
      "client": "FakeClient"
    },
    {
      "id": 1234,
      "code": "fk-it-1234",
      "client": "FakeClient2"
    }
  ]
}
JSON;

        // Create a mock
        $this->responseBodySingle = <<<JSON
{"campaigns": [{"id": 5678,"code": "fk-it-5678"}]}
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
        $service = new \Digitouch\AdForm\Service\Campaign\Campaigns($this->stubClient, $this->stubTicket);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Campaign\Campaigns::class, $service);
        $res = $service->getResponse()->fetch();
        $this->assertEquals($res, json_decode($this->responseBody)->campaigns);
        $this->assertEquals($res[0]->id, 4321);
        $this->assertEquals($res[1]->client, 'FakeClient2');

        $serviceSingle = new \Digitouch\AdForm\Service\Campaign\Campaigns($this->stubClient, $this->stubTicket, ['client' => 5678]);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Campaign\Campaigns::class, $serviceSingle);
        $resSingle = $serviceSingle->getResponse()->fetch();
        $this->assertEquals($resSingle, json_decode($this->responseBodySingle)->campaigns);
        $this->assertEquals($resSingle[0]->id, 5678);
    }

}
