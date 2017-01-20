<?php

namespace Digitouch\Tests\AdForm\Auth;

use Digitouch\AdForm\Client\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


class AuthtenticatorTest extends \PHPUnit_Framework_TestCase
{
    private $auth;

    public function setUp()
    {

        // Create a mock
        $responseBody = <<<JSON
{
  "Ticket": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIs"
}
JSON;

        $responseSize = strlen($responseBody);
        $stubClient = $this->createMock(ClientInterface::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $responseBody);
        // Configure the stub.
        $stubClient->method('sendData')
             ->willReturn($response);

        $this->auth = new \Digitouch\AdForm\Auth\Authenticator($stubClient, 'fake-username', 'fake-login');

    }

    /**
     * @test
     */
    public function authenticatorWillReturnCreateValidTicketObject()
    {
        $auth = $this->auth;
        $this->assertInstanceOf(\Digitouch\AdForm\Auth\Authenticator::class, $auth);
        $this->assertNotEmpty($auth->getTicket());
        $this->assertInstanceOf(\Digitouch\AdForm\Auth\TicketInterface::class, $auth->getTicket());
        $this->assertEquals($auth->getTicket(), 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIs');
    }


    /**
     * @test
     */
    public function authenticatorWillExpire()
    {
        $auth = $this->auth;
        $auth->expire();
        $this->assertEquals($auth->isExpired(), true);
    }
}

