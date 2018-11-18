<?php

namespace Serverstarter\Util;

/**
 * Format Util
 *
 * Class containing data formatter
 *
 * @category Serverstarter
 * @package  Util
 *
 * @author   Jed Diaz
 * @since    11 November 2018
 */
class Format
{
    public static function json2array($items)
    {
        $convertedItems = $items ? \Convert::json2array($items) : '';
        
        return $convertedItems;
    }
    
    public static function array2json($items)
    {

        $convertedItems = $items ? \Convert::array2json($items) : '';
        
        return $convertedItems;
        
    }
}