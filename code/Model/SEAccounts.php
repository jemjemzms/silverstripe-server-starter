<?php

class SEAccounts extends DataObject {

	private static $singular_name = 'Category';
	private static $plural_name = 'Categories';

	private static $db = array(
      'Name' => 'Varchar(250)',
      'Description' => 'Text',
      'Balance' => 'Currency',
      'AccountNumber' => 'Varchar(100)'
	);
	
	private static $has_one = array(
	    "Record" => "SERecord"
	);

	private static $has_many = array(
		"Transactions" => "SETransactions"
	);
  
}
