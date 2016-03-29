<?php 


class ExternalContentType extends DataObject {
	
	private static $singular_name = 'Content Type';
	private static $plural_name = 'Content Types';
	
	private static $db = array(
		'Name' => 'Varchar',
		'ContentIsPlaintext' => 'Boolean', // 0 is html, 1 is plaintext
	);
	
	private static $has_many = array(
		'Contents' => 'ExternalContent',
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