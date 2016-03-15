<?php 
class ExternalContentAPIController extends Controller {

	private static $realm = 'NZTA External content API';
	
	private static $allowed_actions = array(
		'ExternalContent',
	);

	public function init() {
		parent::init();
		$realm = $this->config()->get('realm');
		$this->member = BasicAuth::requireLogin($realm);
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