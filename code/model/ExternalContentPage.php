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

	private static $indexes = array(
		'IndexName' => array(
			'type' => 'index', 
			'value' => '"Name"'
		)
	);
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