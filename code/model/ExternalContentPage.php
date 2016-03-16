<?php 


class ExternalContentPage extends DataObject {
	
	private static $singular_name = 'Page';
	private static $plural_name = 'Pages';
	
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
	
	
	
	public function canView($member = null){ return $this->canAccess($member); }
	public function canEdit($member = null) { return $this->canAccess($member); }
	public function canDelete($member = null) { return $this->canAccess($member); }
	public function canCreate($member = null) { return $this->canAccess($member); }
	protected function canAccess($member = null){
		return Permission::checkMember($member, 'VIEW_EXTERNAL_CONTENT_API') !== false;
	}
	
}