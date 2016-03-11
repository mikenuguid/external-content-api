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
	
}