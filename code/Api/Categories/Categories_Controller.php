<?php

use Serverstarter\Util\Auth;
use Serverstarter\Util\Http;
use Serverstarter\Util\Format;
use Serverstarter\Categories\Categories_Model;
use Serverstarter\Categories\Categories_Constants;

/**
 * Handle Categories
 *
 * @category Serverstarter
 * @package  Controller
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */
class Categories_Controller extends Page_Controller {
    
    /**
     * Methods that are allowed
     *
     * @var array
     */
	private static $allowed_actions = [
	    'controlRequest',
	];

	/**
	 * Map url to method
	 *
	 * @var object
	 */
	private static $url_handlers = array(
	    'action/$AuthToken/$RecordID/$ID' => 'controlRequest',
	);
	
	/**
	 * Storage for model class
	 *
	 * @var object
	 */
	protected $mapper;
	
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
	    $this->mapper = new Categories_Model();
	    $this->constant = new Categories_Constants();
	}
	
	/**
	 * Handle HTTP ajax request
	 *
	 * @return integer or null
	 */
	public function controlRequest(SS_HTTPRequest $request) 
	{	 
	    //HTTP::setHeaders();
	    $this->response->addHeader("Access-Control-Allow-Origin", "*");
	    $this->response->addHeader("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
	    $this->response->addHeader("X-Robots-Tag", "noindex");
	    $this->response->addHeader('Content-Type', 'application/json');
	    
	    $constant = $this->constant;
	    $validAccess = Auth::checkAuthToken($request->allParams());
	    
	    if ($validAccess) {
	        $method = Http::getMethod($this->getRequest());
	    
    	    if (!empty($method)) {
    	        
    	        // Instantiate the mapper class
    	        $params = $request->allParams();
    	        $this->mapper->params = $params;
    	        $this->mapper->models = Format::json2array($request->getBody());
    	        
    	        switch ($method) {
    	            case $constant::GET:

    	                if (isset($params[$constant::ID])) {
    	                    $response = $this->mapper->fetch();
    	                } else {
    	                    $response = $this->mapper->fetchAll();
    	                }
    	                
    	                break;
    	            case $constant::POST:
    	                
    	                $bodyParams = Format::json2array($request->getBody());
    	                
    	                switch ($bodyParams['ACTION']) {
    	                    case 'insert':
    	                        $response = $this->mapper->write();
    	                        break;
    	                    case 'update';
    	                        $response = $this->mapper->update();
    	                        break;
    	                    case 'delete';
    	                        $response = $this->mapper->delete();
    	                        break;
    	                }
    	                
    	                break;
    	            default:
                        return '';
    	        }  
    	        

    	        return ($response) ? Format::array2json($response) : $this->httpError(204, $constant::NO_RESULT);
    	        
    	    }
	    }
	    
	    return $this->httpError(400, $constant::BAD_REQUEST);
	}

}
