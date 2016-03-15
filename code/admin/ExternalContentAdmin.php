<?php 


class ExternalContentAdmin extends ModelAdmin {
	
	private static $managed_models = array(
		'ExternalContentApplication',
		'ExternalContentArea',
		'ExternalContentPage',
		'ExternalContent',
		'ExternalContentType',
	);
	
	private static $url_segment = 'external-content';
	
	private static $menu_title = 'External Content';
	
	
	
	
	
	public function getEditForm($id = null, $fields = null){
		// add ability to search
		
		$form = parent::getEditForm($id, $fields);
		$gridFieldName = $this->sanitiseClassName($this->modelClass);
		$gridField = $form->Fields()->fieldByName($gridFieldName);
		$gridField->getConfig()->addComponent(new GridFieldFilterHeader()); 
		return $form;
	}
	
}