<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;


class DataExportResultTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $responseBody;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "DataExportResult": {
    "DataExportStatus": "Done",
    "DataExportResultUrl": "http://reports.adform.com/File/?id=1234&authTicket=eyJ0eXAiOiJKV1QiLCJ",
    "DataExportFinishTime": "2016-12-22T02:58:17"
  }
}
JSON;

        $responseSize = strlen($this->responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $this->responseBody);
        $stubClient->method('sendData')
             ->willReturn($response);

        $stubTicket = $this->createMock(TicketInterface::class);

        $this->service = new \Digitouch\AdForm\Service\Reporting\DataExportResult($stubClient, $stubTicket, ['DataExportName'=>'FakeExport']);
    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = $this->service;
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\DataExportResult::class, $service);
        $res = $service->getResponse()->fetch();
        $this->assertEquals($res, json_decode($this->responseBody)->DataExportResult);
        $this->assertEquals($res->DataExportResultUrl, "http://reports.adform.com/File/?id=1234&authTicket=eyJ0eXAiOiJKV1QiLCJ");
    }

    /**
     * @test
     * @expectedException Digitouch\AdForm\Exception\MissingParamsException
     * @expectedExceptionMessage Missing Parameters: DataExportName
     */
    public function serviceWillReturnExcpetionIfParamsAreWrong()
    {
        $stubClient = $this->createMock(HttpClient::class);
        $stubTicket = $this->createMock(TicketInterface::class);
        $service = new \Digitouch\AdForm\Service\Reporting\DataExportResult($stubClient, $stubTicket, []);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\DataExportResult::class, $service);
    }
}
