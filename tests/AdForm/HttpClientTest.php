<?php

namespace Digitouch\Tests\AdForm;

use Digitouch\AdForm\Client\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Exception\RequestException;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new HttpClient;
    }

    /**
     * @test
     */
    public function clientWillReturnInstanceOfGuzzleClient()
    {
        $this->assertInstanceOf(GuzzleClient::class, $this->client->getGuzzle());
    }

    /**
     * @expectedException GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessage {"message": "Ticket is invalid"}
     */
    public function testSendDataNoHeader()
    {
        // Create a mock
        $mock = new MockHandler([
            new RequestException('{"message": "Ticket is invalid"}', new Request('GET', 'DataExport/DataExportsList')),
            new Response(200, ['X-Foo' => 'Bar']),
        ]);

        $handler = HandlerStack::create($mock);

        $options = ['headers' => [], 'handler' => $handler];
        $response = $this->client->sendData('GET', 'DataExport/DataExportsList', $options);
    }

    public function testSendData()
    {

        // Create a mock
        $responseBody = <<<JSON
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
        $responseSize = strlen($responseBody);
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => $responseSize], $responseBody),
        ]);
        $handler = HandlerStack::create($mock);

        $options = [
            'handler' => $handler,
            'query' => ['Names' => 'Advertiser1']
        ];

        $response = $this->client->sendData('GET', 'Advertiser/Advertisers', $options);
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals($json['Advertisers'][0]['Id'], 1234);
        $this->assertEquals($json['Advertisers'][1]['Name'], 'Advertiser2');

    }

}