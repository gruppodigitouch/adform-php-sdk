<?php

namespace Digitouch\Tests\AdForm;

use Digitouch\AdForm\Auth\Ticket;
use Digitouch\AdForm\Auth\TicketInterface;

class TicketTest extends \PHPUnit_Framework_TestCase
{

    private $ticket;

    public function setUp()
    {
        $this->ticket = new Ticket('fake-code');
    }

    /**
     * @test
     */
    public function ticketWillBeInstanceOfTicketInterface()
    {
        $this->assertInstanceOf(TicketInterface::class, $this->ticket);
    }

    /**
     * @test
     */
    public function testGetCode()
    {
        $this->assertEquals('fake-code', $this->ticket->getCode());
    }

    /**
     * @test
     */
    public function testIsValid()
    {
        $this->assertTrue($this->ticket->isValid());

        $ticket = new Ticket('fake-code', new \DateTime('-1 hour'));
        $this->assertFalse($ticket->isValid());
    }

}