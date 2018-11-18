<?php

namespace Serverstarter\Members;

use \Member;

/**
 * Map Members
 *
 * @category Serverstarter
 * @package  Controller
 *
 * @author   Jed Diaz
 * @since    11 November 2018
 */
class Members_Model
{
    /**
     * Member ID
     *
     * @var integer
     */
    public $id;
    
    /**
     * Member values
     *
     * @var array
     */
    public $models;
    
    /**
     * Member vo
     *
     * @var object
     */
    public $vo;
    
    /**
     * Token and Record ID or/and Member ID
     *
     * @var array
     */
    public $params;
    
    /**
     * Member Table
     *
     * @var object
     */
    protected $dataObject;
    
    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dataObject = new Member();
        $this->vo = new Members_Vo();
    }

    /**
     * Add new Members
     *
     * @var integer
     */
    public function write()
    {
        foreach ($this->vo as $key => $value) {
            // Remove ID from loop
            if ($key == Members_Constants::ID) {
                continue;
            }
            
            if (
                isset($this->dataObject->$key) &&
                isset($this->models[$key])
            ){
                $this->dataObject->$key = $this->models[$key];
            }
        }
        
        return $this->dataObject->write();
    }

    /**
     * Update a specific Member
     *
     * @var integer
     */
    public function update()
    {
        foreach ($this->vo as $key => $value) {
            
            if (
                isset($this->dataObject->$key)
            ){  
                if ($key == Members_Constants::ID) {
                    $this->dataObject->$key = $this->params[$key];
                } else {
                    $this->dataObject->$key = $this->models[$key];
                }
            }
            
        }
        
        return $this->dataObject->write();
    }
    
    /**
     * Fetch a specific Member from a specific RecordID
     *
     * @var \JsonSerializable
     */
    public function fetch()
    {
        $result = $this->dataObject->get()->filter([
            Members_Constants::ID => $this->id
        ])->toNestedArray(); 
        
        
        if (count($result) > 0) {
            
            $result = array_shift($result);
            
            $Member = [];
            $Member['ID']        = $result['ID'];
            $Member['FirstName'] = $result['FirstName'];
            $Member['Surname']   = $result['Surname'];
            $Member['Email']     = $result['Email'];
            
            return $Member;
        }
        
        return '';
    }
    
    /**
     * Fetch all Members
     *
     * @var \JsonSerializable
     */
    public function fetchAll()
    {
        $result = $this->dataObject->get()->toNestedArray();
        
        if (count($result) > 0) {
            return $result;
        }
        
        return '';
    }
    
    /**
     * Delete single or multiple IDs
     *
     * @var void
     */
    public function delete()
    {
        foreach($this->models as $item) {
            
            $this->dataObject->ID = $item[Members_Constants::ID];
            $this->dataObject->delete();
            
        }
        
        return '';
    }
}