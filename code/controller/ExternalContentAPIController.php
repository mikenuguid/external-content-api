<?php 


class ExternalContentAPIController extends Controller {
	
	private static $allowed_actions = array(
		'ExternalContent',
	);
	
	public function ExternalContent(SS_HTTPRequest $request){
		$data = ExternalContent::get();
		// TODO: filtering
		
		$format = $request->getVar('format');
		if($format == 'xml') return $this->toXML($data);
		if($format == 'json') return $this->toJSON($data);
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