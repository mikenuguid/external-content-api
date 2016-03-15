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
		'ExternalID',
		'ContentSummary',
		'TypeName',
	);
	
	private static $field_labels = array(
		'TypeName' => 'Content Type',
		'ContentSummary' => 'Content',
	);
	
	
	private static $casting = array(
		'Content' => 'HTMLText',
	);
	
	
	
	public function ContentSummary(){
		// surely there's a better way of doing this?
		$content = new HTMLText();
		$content->setValue($this->Content);
		/* @var $content HTMLText */
		return $content->Summary(10);
	}
	
	public function TypeName(){
		if($this->Type()){
			return $this->Type()->Name;
		}
	}
	
	
	
	
	public function canView($member = null) {
		// FIXME: proper permission check
		return true;
	}
	
}