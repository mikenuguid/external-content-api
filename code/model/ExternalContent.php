<?php 


class ExternalContent extends DataObject {
	
	private static $singular_name = 'Content';
	private static $plural_name = 'Content items';
	
	private static $db = array(
		'ExternalID' => 'Varchar',
		'Content' => 'HTMLText',	
	);
	
	
	private static $has_one = array(
		'Type' => 'ExternalContentType',	
	);
	
	private static $many_many = array(
		'Pages'	=> 'ExternalContentPage',
	);
	
	
	private static $summary_fields = array(
		'TypeName',
		'ExternalID',
		'Content',
	);
	
	private static $field_labels = array(
		'TypeName' => 'Content Type',
	);
	
	
	public function TypeName(){
		if($this->Type()){
			return $this->Type()->Name;
		}
	}
	
}