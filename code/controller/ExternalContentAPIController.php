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
	
}