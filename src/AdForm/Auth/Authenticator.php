<?php

namespace Digitouch\AdForm\Auth;

use Digitouch\AdForm\Client\ClientInterface;

class Authenticator
{
    /**
     * @param Client $client
     */
    private $client;

    /**
     * @param string $username
     */
    private $username;
    
    /**
     * @param string $password
     */
    private $password;

    /**
     * @param TicketInterface $code
     */
    private $ticket;

    /**
     * @param boolean $expired
     */
    private $expired;


    public function __construct(ClientInterface $client, $username, $password)
    {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
        $this->expired = false;
        $this->login();

    }

    public function login()
    {
        $options = [
            'json' => ['Username' => $this->username, 'Password' => $this->password]
        ];

        $response = $this->client->sendData('POST', 'Security/Login', $options);
        $json = json_decode($response->getBody()->getContents(), true);
        
        $this->ticket = new Ticket($json['Ticket']);

    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function isExpired()
    {
        return is_null($this->ticket) || !$this->ticket->isValid();
    }

    public function expire()
    {
        $this->ticket = null;
    }

}