<?php 


class ExternalContentType extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar',
	);
	
	private static $has_many = array(
		'Contents' => 'ExternalContent',
	);
	
}