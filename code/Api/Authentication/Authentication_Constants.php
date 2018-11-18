<?php

namespace Serverstarter\Authentication;

/**
 * Authentication constants
 *
 * @category Serverstarter
 * @package  Categories
 *
 * @author   Jed Diaz
 * @since    31 October 2018
 */
class Authentication_Constants
{
    
    /**
     * HTTP Request for logging out users
     *
     * @var string
     */
    const GET = 'GET';
    
    /**
     * HTTP Request for logging in users
     *
     * @var string
     */
    const POST = 'POST';
    
    /**
     * HTTP Request for logging in users
     *
     * @var string
     */
    const OPTIONS = 'OPTIONS';

    /**
     * Used for 'bad request' as a constant
     *
     * @var string
     */
    const BAD_REQUEST = 'Bad Request';
    
}