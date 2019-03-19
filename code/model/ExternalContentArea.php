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

	private static $indexes = array(
		'IndexName' => array(
			'type' => 'index', 
			'value' => '"Name"'
		)
	);

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		//update AppName field
		$pages = $this->Pages();
		foreach ($pages as $page){
			if(!$page->Area()->ApplicationID){
				$page->AppName = 'N/A';
			}else{
				$page->AppName = $this->Application()->Name;
				$page->write();
			}
		}
	}

	public function canView($member = null) {
		return Permission::check('VIEW_EXTERNAL_CONTENT_API');;
	}
	public function canEdit($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}
	public function canDelete($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}
	public function canCreate($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}

}
