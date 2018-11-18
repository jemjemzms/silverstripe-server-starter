<?php

class SETransactions extends DataObject {

	private static $singular_name = "Transaction";
	private static $plural_name = "Transactions";

	private static $db = array(
        'Name' => 'Varchar(250)',
        'Type' => 'Enum(array("Income","Expense"))',
        'Display' => 'Boolean',
        'Archive' => 'Boolean',
        'Reference' => 'Varchar(250)',
        'Date' => 'Date',
        'Amount' => 'Currency',
        'Notes' => 'Text'
	);
	
	private static $has_one = array(
        "Accounts" => "SEAccounts",
        "Category" => "SECategory",
    	"Record" => "SERecord"
	);
  
}
