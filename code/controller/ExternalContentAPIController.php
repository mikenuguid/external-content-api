<?php 
class ExternalContentAPIController extends Controller{

	private static $realm = 'NZTA External content API';
	
	private static $allowed_actions = array(
		'ExternalContent',
	);

	public function init() {
		parent::init();
		$realm = $this->config()->get('realm');
		BasicAuth::requireLogin($realm);
		if(!Permission::check("VIEW_EXTERNAL_CONTENT_API")) Security::permissionFailure();
	}
	
	public function ExternalContent(SS_HTTPRequest $request){
		$data = ExternalContent::get();
		// TODO: filtering

		$format = $request->getVar('format');
		$formatter = DataFormatter::for_extension($format);
		if(!$formatter) $formatter = new XMLDataFormatter(); // default to XML
		return $formatter->convertDataObjectSet($data);
	}
}