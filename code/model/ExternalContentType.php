<?php 


class ExternalContentType extends DataObject {
	
	private static $singular_name = 'Content Type';
	private static $plural_name = 'Content Types';
	
	private static $db = array(
		'Name' => 'Varchar',
	);
	
	private static $has_many = array(
		'Contents' => 'ExternalContent',
	);
	
}