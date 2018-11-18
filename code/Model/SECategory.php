<?php

class SECategory extends DataObject {

	private static $singular_name = 'Category';
	private static $plural_name = 'Categories';

	private static $db = array(
      'Name' => 'Varchar(250)',
      'Type' => 'Enum(array("Income","Expense"))',
      'Description' => 'Text',
      'Color' => 'Varchar(250)'
	);

	private static $has_one = array(
	    "Record" => "SERecord"
	);
	
	private static $has_many = array(
		"Transactions" => "SETransactions"
	);
	
}
