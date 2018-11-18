<?php

class SERecord extends DataObject {

	private static $singular_name = 'Record';
	private static $plural_name = 'Records';

	private static $db = array(
      'Name' => 'Varchar(250)'
	);
	
	private static $many_many = array(
	    "Members" => "Member"
	);
  
}
