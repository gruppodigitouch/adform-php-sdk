<?php

namespace Digitouch\Tests\AdForm\User;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;


class UsersTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $responseBody;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "Users": [
    {
      "Id": 5173,
      "FullName": "Admin DigiTouch",
      "Initials": "AD",
      "Username": "ALA-dtit"
    }
  ]
}
JSON;
    
        $responseSize = strlen($this->responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $this->responseBody);
        // Configure the stub.
        $stubClient->method('sendData')
             ->willReturn($response);

        $stubTicket = $this->createMock(TicketInterface::class);

        $this->service = new \Digitouch\AdForm\Service\User\Users($stubClient, $stubTicket);

    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = $this->service;
        $this->assertInstanceOf(\Digitouch\AdForm\Service\User\Users::class, $service);
        $this->assertEquals($service->getResponse()->fetch(), json_decode($this->responseBody)->Users);
    }

}