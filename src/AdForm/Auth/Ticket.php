<?php

namespace Digitouch\AdForm\Auth;

class Ticket implements TicketInterface
{
    /**
     * @param string $code
     */
    private $code;

    /**
     * @param \DateTime $created
     */
    private $created;

    public function __construct($code, \DateTime $created = null)
    {
        $this->code = $code;
        $this->created = !empty($created) ? $created : new \DateTime('now');
        
    }

    public function __toString()
    {
        return $this->code;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Check if Ticket is valid
     *
     * @return bool
     */
    public function isValid()
    {
        $this->created->add(new \DateInterval('PT1H'));
        return $this->created > new \DateTime('now');
    }

}