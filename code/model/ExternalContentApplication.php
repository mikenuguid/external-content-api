<?php 


class ExternalContentApplication extends DataObject {
	
	private static $singular_name = 'Application';
	private static $plural_name = 'Applications';
	
	private static $db = array(
		'Name' => 'Varchar',	
	);
	
	private static $has_many = array(
		'Areas' => 'ExternalContentArea',
	);

	public function requireDefaultRecords() {
		parent::requireDefaultRecords();

		//we need to create a group for Permissions check to work correctly
		// check if one is created already
		$readers = $this->findOrMakeExternalContentGroup(array(
			'Title' => 'External content API readers',
			'Description' => 'Controls view access to external content API'
		));

		if($readers && $readers->ID) {
			Permission::grant($readers->ID, 'VIEW_EXTERNAL_CONTENT_API');

			$editors = $this->findOrMakeExternalContentGroup(array(
				'Title' => 'External content API editors',
				'Description' => 'Controls editor access to external content API'
			));

			if($editors && $editors->ID) {
				Permission::grant($editors->ID, 'VIEW_EXTERNAL_CONTENT_API');
				Permission::grant($editors->ID, 'CMS_ACCESS_ExternalContentAdmin');
				$editors->HtmlEditorConfig = 'external-content-api';
				$editors->write();
				$readers->Groups()->add($editors);
			}
		}


	}

	private function findOrMakeExternalContentGroup(array $attributes) {
		$group = Group::get()->find('Title', $attributes['Title']);
		if(!($group && $group->ID)) {

			//create one with a specific title
			$group = Group::create()->update($attributes);

			//save its ID if successfully written
			$groupID = $group->write();

			//display the ID in the build logs
			if($groupID) {
				DB::alteration_message(sprintf("External content API group \'%s\'created (ID: %d)", 
					$group->Title,
					$group->ID
				));	
			}
		}
		return $group;
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