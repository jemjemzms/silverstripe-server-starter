<?php

class SEBudget extends DataObject {

	private static $singular_name = "Budget";
	private static $plural_name = "Budgets";

	private static $db = array(
      'Month' => 'Varchar(4)',
      'Year' => 'Int(4)',
      'Amount' => 'Currency'
	);

	private static $has_one = array(
      "Category" => "SECategory",
	  "Record" => "SERecord"
	);
  
}
