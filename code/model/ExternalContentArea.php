<?php 


class ExternalContentArea extends DataObject {
	
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