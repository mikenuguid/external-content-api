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
	
	
	public function canView($member = null){ return $this->canAccess($member); }
	public function canEdit($member = null) { return $this->canAccess($member); }
	public function canDelete($member = null) { return $this->canAccess($member); }
	public function canCreate($member = null) { return $this->canAccess($member); }
	protected function canAccess($member = null){
		return Permission::checkMember($member, 'VIEW_EXTERNAL_CONTENT_API') !== false;
	}
	
}