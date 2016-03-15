<?php 
class ExternalContentAPIController extends Controller implements PermissionProvider {

	private static $realm = 'NZTA External content API';
	
	private static $allowed_actions = array(
		'ExternalContent',
	);

	public function init() {
		parent::init();
		$realm = $this->config()->get('realm');
		$member = BasicAuth::requireLogin($realm);
		if(!Permission::check($member, "VIEW_EXTERNAL_CONTENT_API")) Security::permissionFailure();
		$this->member = $member;
	}
	
	public function ExternalContent(SS_HTTPRequest $request){
		$data = ExternalContent::get();
		// TODO: filtering

		$format = $request->getVar('format');
		
		if($format == 'json') return $this->toJSON($data);

		//default to XML output
		return $this->toXML($data);
	}
	
	protected function toXML(SS_List $objects){
		$formatter = new XMLDataFormatter();
		return $formatter->convertDataObjectSet($objects);
	}
	
	protected function toJSON(SS_List $objects){
		$formatter = new JSONDataFormatter();
		return $formatter->convertDataObjectSet($objects);
	}

	public function providePermissions() {
		return array(
			'VIEW_EXTERNAL_CONTENT_API' => 'Ability to view and use the external content API'
		);
	}	
}