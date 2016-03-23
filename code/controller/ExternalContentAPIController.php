<?php 
class ExternalContentAPIController extends Controller{

	private static $realm = 'External Content API';
	
	private static $allowed_actions = array(
		'ExternalContent',
	);

	public function init() {
		parent::init();
		$realm = $this->config()->get('realm');
		$member = BasicAuth::requireLogin($realm);
		if(!Permission::checkMember($member, "VIEW_EXTERNAL_CONTENT_API")) Security::permissionFailure();
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

		$filterOptions = array();
		if($applicationName) {
			$filterOptions['Pages.Area.Application.Name:ExactMatch'] = $applicationName;
		}

		if($areaName) {
			$filterOptions['Pages.Area.Name:ExactMatch'] = $areaName;
		}

		if($pageName) {
			$filterOptions['Pages.Name:ExactMatch'] = $pageName;
		}

		return $r->filter($filterOptions);
	}
}