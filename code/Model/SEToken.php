<?php

class SEToken extends DataObject {

	private static $singular_name = 'Token';
	private static $plural_name = 'Tokens';

	private static $db = array(
	  'Token' => 'Varchar(60)'
	);
	
	private static $has_one = array(
	    "Member" => "Member"
	);
  
}
