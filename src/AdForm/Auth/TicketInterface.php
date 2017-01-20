<?php

namespace Digitouch\AdForm\Auth;

interface TicketInterface
{
    /**
     * __toString
     *
     * @return string
     */
    public function __toString();

    /**
     * Get code
     *
     * @return string
     */
    public function getCode();


    /**
     * Check if Ticket is valid
     *
     * @return bool
     */
    public function isValid();

}