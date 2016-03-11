<?php 


class ExternalContent extends DataObject {
	
	private static $db = array(
		'Content' => 'HTMLText',	
	);
	
	private static $has_one = array(
		'Type' => 'ExternalContentType',	
	);
	
	private static $many_many = array(
		'Pages'	=> 'ExternalContentPage',
	);
	
}