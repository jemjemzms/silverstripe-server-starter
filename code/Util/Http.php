<?php

namespace Serverstarter\Util;

/**
 * HTTP Util
 *
 * Class containing utilities for http
 *
 * @category Serverstarter
 * @package  Util
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */
class Http
{
    public static function getMethod($request)
    {
        
        if ($request->isGET()) {
            return 'GET';
        }
        
        if ($request->isPUT()) {
            return 'PUT';
        }
        
        if ($request->isPOST()) {
            return 'POST';
        }
        
        if ($request->isDELETE()) {
            return 'DELETE';
        }
        
        return 'OPTIONS';
        
    }
    
    public static function setHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        
        return '';
    }
}