<?php 
class ExternalContentAPIController extends Controller{

	private static $realm = 'External Content API';
	
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
		$format = $request->getVar('format');
		$formatter = DataFormatter::for_extension($format);
		if(!$formatter) $formatter = new XMLDataFormatter(); // default to XML
		return $formatter->convertDataObjectSet($this->getData($request));
	}
	
	/**
	 * @return DataList of ExternalContent
	 */
	protected function getData(SS_HTTPRequest $request){
		$r = ExternalContent::get();
		
		$applicationName = $request->getVar('applicationName');
		$areaName = $request->getVar('areaName');
		$pageName = $request->getVar('pageName');
		
		if($applicationName) $r = $r->filter(array('Pages.Area.Application.Name:ExactMatch' => $applicationName));
		if($areaName) $r = $r->filter(array('Pages.Area.Name:ExactMatch' => $areaName));
		if($pageName) $r = $r->filter(array('Pages.Name:ExactMatch' => $pageName));
		
		return $r;
		
	}
	
}