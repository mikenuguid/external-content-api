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
		$group = Group::get()->find('Title', 'External content API users');
		if(!($group && $group->ID)) {

			//create one with a specific title
			$group = Group::create()->update(array(
				'Title' => 'External content API users',
				'Description' => 'Controls access to external content API'
			));

			//save its ID if successfully written
			$groupID = $group->write();

			//display the ID in the build logs
			if($groupID) {
				DB::alteration_message(sprintf("External content API group created with ID #%d", $groupID));	
			}
			
		}
	}
	
}