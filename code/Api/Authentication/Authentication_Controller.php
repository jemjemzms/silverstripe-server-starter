<?php

use Serverstarter\Util\Auth;
use Serverstarter\Util\Http;
use Serverstarter\Authentication\Authentication_Constants;

/**
 * Authentication Class
 *
 * @category Serverstarter
 * @package  Controller
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */
class Authentication_Controller extends Page_Controller {

    /**
     * Methods that are allowed
     *
     * @var array
     */
	private static $allowed_actions = [
	    'controlRequest',
	    'checkToken',
	];

	/**
	 * Map url to method
	 *
	 * @var object
	 */
	private static $url_handlers = array(
	    'action/$AuthToken' => 'controlRequest',
	    'check/$AuthToken' => 'checkToken',
	);
	
	/**
	 * Storage for constants class
	 *
	 * @var object
	 */
	protected $constant;
	
	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    $this->constant = new Authentication_Constants();
	}
	
	/**
	 * Handle HTTP ajax request
	 *
	 * @return integer or null
	 */
	public function controlRequest(SS_HTTPRequest $request) 
	{	
	    HTTP::setHeaders();

	    $constant = $this->constant;
	    $method = Http::getMethod($request);

	    switch ($method) {
	        case $constant::GET:
	            $authToken = $request->param('AuthToken');
	            return Auth::Logout($authToken);
	            
	            break;
	        case $constant::POST:
	            $details = Convert::json2array($request->getBody());
	            return Auth::Authenticate($details);
	            
	            break;
	        case $constant::OPTIONS:
	            return '';
	            break;
	        default:
	            return $this->httpError(400, $constant::BAD_REQUEST);
	    }
	    
	}
	
	/**
	 * Check Token request
	 *
	 * @return string
	 */
	public function checkToken(SS_HTTPRequest $request)
	{
	    HTTP::setHeaders();

        $authToken = $request->param('AuthToken');

        return Auth::CheckToken($authToken);
	}

}
