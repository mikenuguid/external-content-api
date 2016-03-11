<?php 


class ExternalContentPage extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar',
		'URL' => 'Varchar',
	);
	
	private static $has_one = array(
			'Area' => 'ExternalContentArea',
	);
	
	private static $belongs_many_many = array(
		'Contents' => 'ExternalContent',
	);
	
}