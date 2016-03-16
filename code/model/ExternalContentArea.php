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
	
	
	public function canView($member = null){ return $this->canAccess($member); }
	public function canEdit($member = null) { return $this->canAccess($member); }
	public function canDelete($member = null) { return $this->canAccess($member); }
	public function canCreate($member = null) { return $this->canAccess($member); }
	protected function canAccess($member = null){
		return Permission::checkMember($member, 'VIEW_EXTERNAL_CONTENT_API') !== false;
	}
	
}