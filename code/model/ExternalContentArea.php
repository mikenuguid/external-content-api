<?php 


class ExternalContentArea extends DataObject {
	
	private static $singular_name = 'Area';
	private static $plural_name = 'Areas';
	
	private static $db = array(
		'Name' => 'Varchar',
	);
	
	private static $has_one = array(
		'Application' => 'ExternalContentApplication',	
	);
	
	private static $has_many = array(
		'Pages' => 'ExternalContentPage',
	);
	
}