<?php 


class ExternalContentApplication extends DataObject {
	
	private static $singular_name = 'Application';
	private static $plural_name = 'Applications';
	
	private static $db = array(
		'Name' => 'Varchar',	
	);
	
	private static $has_many = array(
		'Areas' => 'ExternalContentArea',
	);
	
}