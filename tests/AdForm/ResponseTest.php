<?php

namespace Digitouch\Tests\AdForm;

use Digitouch\AdForm\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function fetchWillReturnCorrectVar()
    {
        // Create a mock
        $response = <<<JSON
{
  "Advertisers": [
    {
      "Id": 1234,
      "AgencyId": 2442,
      "Name": "Advertiser1",
      "TimeZoneName": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"
    },
    {
      "Id": 1235,
      "AgencyId": 2442,
      "Name": "Advertiser2",
      "TimeZoneName": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"
    }
  ]
}
JSON;
        $response = new Response(json_decode($response), "Advertisers");
        
        $this->assertEquals($response->fetch()[0]->Id, 1234);
        $this->assertEquals($response->fetch()[1]->Name, "Advertiser2");
    }

    /**
     * @expectedException Digitouch\AdForm\Exception\Response\UnauthorizedDimensionOrMetricException
     * @expectedExceptionMessage Dimension(s) or metric(s) are unauthorized: fake-metric.
     */
    public function testUnauthorizedDimensionOrMetric()
    {
        // Create a mock
        $response = <<<JSON
{
  "reason": "unauthorizedDimensionOrMetric",
  "message": "Dimension(s) or metric(s) are unauthorized: fake-metric.",
  "params": {
    "restrictions": "fake-matric"
  }
}
JSON;
        $response = new Response(json_decode($response), "fake-var");
        $response->fetch();        
    }

    /**
     * @expectedException Digitouch\AdForm\Exception\Response\UnauthorizedException
     * @expectedExceptionMessage You are not authorized to use this service
     */
    public function testUnauthorized()
    {
        // Create a mock
        $response = <<<JSON
{
  "reason": "unauthorized",
  "message": "You are not authorized to use this service"
}
JSON;
        $response = new Response(json_decode($response), "fake-var");
        $response->fetch();        
    }

    /**
     * @expectedException Digitouch\AdForm\Exception\Response\TicketInvalidException
     * @expectedExceptionMessage Ticket is invalid
     */
    public function testTicketInvalid()
    {
        // Create a mock
        $response = <<<JSON
{
  "ErrorCode": null,
  "Message": "Ticket is invalid",
  "Details": null
}
JSON;
        $response = new Response(json_decode($response), "fake-var");
        $response->fetch();        
    }

    /**
     * @expectedException Digitouch\AdForm\Exception\Response\TicketMissingException
     * @expectedExceptionMessage Ticket header is missing
     */
    public function testTicketMissing()
    {
        // Create a mock
        $response = <<<JSON
{
  "ErrorCode": null,
  "Message": "Ticket header is missing",
  "Details": null
}
JSON;
        $response = new Response(json_decode($response), "fake-var");
        $response->fetch();        
    }

}