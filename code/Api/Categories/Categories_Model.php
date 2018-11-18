<?php

namespace Serverstarter\Categories;

use \SECategory;

/**
 * Map Categories
 *
 * @category Serverstarter
 * @package  Controller
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */
class Categories_Model
{
    /**
     * Category ID
     *
     * @var integer
     */
    public $id;
    
    /**
     * Category values
     *
     * @var array
     */
    public $models;
    
    /**
     * Category vo
     *
     * @var object
     */
    public $vo;
    
    /**
     * Token and Record ID or/and Category ID
     *
     * @var array
     */
    public $params;
    
    /**
     * Category Table
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
        $this->dataObject = new SECategory();
        $this->vo = new Categories_Vo();
    }

    /**
     * Insert new Categories
     *
     * @var integer
     */
    public function write()
    {
        foreach ($this->vo as $key => $value) {
            // Remove ID from loop
            if ($key == Categories_Constants::ID) {
                continue;
            }
            
            if (
                isset($this->dataObject->$key) &&
                isset($this->models[$key])
            ){
                $this->dataObject->$key = $this->models[$key];
            }
        }
        
        $id = $this->dataObject->write();
        
        return $id ? ['success' => true, 'id' => $id] : ['success' => false];
    }

    /**
     * Update a specific Category
     *
     * @var integer
     */
    public function update()
    {
        foreach ($this->vo as $key => $value) {
            
            if (
                isset($this->dataObject->$key)
            ){
                // Remove RecordID from loop
                if ($key == Categories_Constants::RECORD_ID) {
                    continue;
                }
                
                if ($key == Categories_Constants::ID) {
                    $this->dataObject->$key = $this->params[$key];
                } else {
                    $this->dataObject->$key = $this->models[$key];
                }
            }
            
        }

        $id = $this->dataObject->write();
        
        return $id ? ['success' => true, 'id' => $id] : ['success' => false];
    }
    
    /**
     * Fetch a specific Category from a specific RecordID
     *
     * @var \JsonSerializable
     */
    public function fetch()
    {
        $result = $this->dataObject->get()->filter([
            Categories_Constants::RECORD_ID => $this->params[Categories_Constants::RECORD_ID], 
            Categories_Constants::ID => $this->params[Categories_Constants::ID]      
        ])->toNestedArray();
        
        if (count($result) > 0) {
            return $result;
        }
        
        return '';
    }
    
    /**
     * Fetch all categories from a specific RecordID
     *
     * @var \JsonSerializable
     */
    public function fetchAll()
    {
        $recordId = $this->params[Categories_Constants::RECORD_ID];
        
        $result = $this->dataObject->get()->filter(Categories_Constants::RECORD_ID, $recordId)->toNestedArray();
        
        if (count($result) > 0) {
            return $result;
        }
        
        return '';
    }
    
    /**
     * Delete single ID
     *
     * @var void
     */
    public function delete()
    {

        $this->dataObject->ID = $this->models[Categories_Constants::ID];
        $this->dataObject->delete();

        return $this->models[Categories_Constants::ID] ? ['success' => true, 'id' => 
            $this->models[Categories_Constants::ID]] : ['success' => false];
    }
}