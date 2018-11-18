<?php

namespace Serverstarter\Util;

/**
 * Auth Util
 *
 * Class containing utilities for authentication
 *
 * @category Serverstarter
 * @package  Util
 *
 * @author   Jed Diaz
 * @since    30 October 2018
 */

use \DB;
use \SEToken;

class Auth
{
    public static function getMember($params)
    {
        if (isset($params['AuthToken']) && !empty($params['AuthToken'])){
            $authToken = $params['AuthToken'];
            $member = SEToken::get()->filter(array('Token'=>$authToken))->first();
            
            if (!empty($member)) {
                return $member;
            }
            
            return false;
        }
    }
    
    public static function checkAuthToken($params)
    {
        if (isset($params['AuthToken']) && !empty($params['AuthToken'])){
            $authToken = $params['AuthToken'];
            $member = SEToken::get()->filter(array('Token'=>$authToken))->first();
            
            if (!empty($member)) {
                return true;    
            } 
            
            return false;
        }
    }
    
    public static function Authenticate($data)
    {
        $userPassword = '';
        $response = [];
        $response['success'] = FALSE;
        $params = $data['params'];

        if (!empty($params)) {
            $email    = $params['Email'];
            $password = $params['Password'];
            
            $result = DB::query("SELECT `PasswordEncryption`, `Salt` FROM `Member` WHERE Email = '".$email."'")->first();
 
            if (!empty($result)){
                $e = \PasswordEncryptor::create_for_algorithm($result['PasswordEncryption']);
                $userPassword = $e->encrypt($password, $result['Salt']);
             
                $memberId = DB::query("SELECT `ID` FROM `Member` WHERE Email = '".$email."' AND `Password` = '".$userPassword."'")->value();
                
                if (!empty($memberId)) {
                    $token = self::generateToken($memberId);
                    $response['token'] = $token;
                    $response['success'] = TRUE;
                } 
            }
        }
        
        return Format::array2json($response);
    }
    
    public static function Logout($token)
    { 
        $response = [];
        $response['success'] = FALSE;
        
        if (!empty($token)) {
            $member = SEToken::get()->filter(array('Token'=>$token))->first();
  
            if (isset($member->Token) && !empty($member->Token)){
                $member->delete();
                $response['success'] = TRUE;
            }
        }
        
        return Format::array2json($response);
    }
    
    public static function generateToken($memberId)
    {
        $randomToken = sha1(rand());
        $token = new SEToken();
        $token->Token = $randomToken;
        $token->MemberID = $memberId;
        $id = $token->write();
        
        return ($id) ? $randomToken : '';
    }
    
    public static function CheckToken($token){
        $response = [];
        $response['success'] = FALSE;
        
        if (!empty($token)) {
            $member = SEToken::get()->filter(array('Token'=>$token))->first();
            
            if (isset($member->Token) && !empty($member->Token)){
                $response['success'] = TRUE;
            }
        }
        
        return Format::array2json($response);
    }
}