<?php 


class ExternalContentApplication extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar',	
	);
	
	private static $has_many = array(
		'Areas' => 'ExternalContentArea',
	);
	
}