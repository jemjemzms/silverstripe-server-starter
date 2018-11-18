<?php

namespace Serverstarter\Members;

/**
 * Members constants
 *
 * @category Serverstarter
 * @package  Members
 *
 * @author   Jed Diaz
 * @since    11 November 2018
 */
class Members_Constants
{
    /**
     * HTTP Request for fetching contents
     *
     * @var string
     */
    const GET = 'GET';

    /**
     * HTTP Request for adding contents
     *
     * @var string
     */
    const POST = 'POST';

    /**
     * HTTP Request for updating contents
     *
     * @var string
     */
    const PUT = 'PUT';

    /**
     * HTTP Request for deleting contents
     *
     * @var string
     */
    const DELETE = 'DELETE';
    
    /**
     * Used for 'No Result' as a constant
     *
     * @var string
     */
    const NO_RESULT = 'No Result.';
    
    /**
     * Used for 'bad request' as a constant
     *
     * @var string
     */
    const BAD_REQUEST = 'Bad Request';
    
    /**
     * Member ID
     *
     * @var string
     */
    const ID = 'ID';
    
    /**
     * Member Record ID
     *
     * @var string
     */
    const RECORD_ID = 'RecordID';
    
}