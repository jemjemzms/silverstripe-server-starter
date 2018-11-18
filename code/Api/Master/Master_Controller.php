<?php

use Serverstarter\Util\Auth;
use Serverstarter\Util\Http;
use Serverstarter\Util\Format;
use Serverstarter\Categories\Categories_Model; 
use Serverstarter\Members\Members_Model;
use Serverstarter\Master\Master_Constants;

/**
 * Handle Master Records
 *
 * @category Serverstarter
 * @package  Controller
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */
class Master_Controller extends Page_Controller {
    
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
	    'action/$AuthToken/$RecordID' => 'controlRequest',
	);
	
	/**
	 * Storage for category model
	 *
	 * @var object
	 */
	protected $categories;
	
	/**
	 * Storage for members model
	 *
	 * @var object
	 */
	protected $member;
	
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
	    $this->categories = new Categories_Model();
	    $this->member = new Members_Model();
	    $this->constant = new Master_Constants();
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
    	        
     	        // Define the parameters
    	        $params = $request->allParams();
    	        $body   = Format::json2array($request->getBody());
    	        	        
    	        switch ($method) {
    	            case $constant::GET:
         
    	                $items = array();
    	                $items['member']     = $this->fetchMember($params, $body);
    	                $items['categories'] = $this->fetchCategories($params, $body);
    	                $items['success']    = true;

    	                return Format::array2json($items);
    	                
    	                break;
    	                
    	            default:
                        return '';
    	        }

    	        return $this->httpError(204, $constant::NO_RESULT);
    	        
    	    }
	    }
	    
	    return $this->httpError(400, $constant::BAD_REQUEST);
	}
	
	/**
	 * Fetch all categories of a record
	 *
	 * @return object
	 */
	public function fetchCategories($params, $body)
	{
	    $this->categories->params = $params;
	    $this->categories->models = $body;
	    
	    return $this->categories->fetchAll();
	}
	
	/**
	 * Fetch all members of a record
	 *
	 * @return object
	 */
	public function fetchMember($params, $body)
	{
	    $member = Auth::getMember($params);
	    
	    $this->member->id = $member->MemberID;
	    $this->member->params = $params;
	    $this->member->models = $body;
	    
	    return $this->member->fetch();
	}

}