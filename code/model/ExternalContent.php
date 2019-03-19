<?php 


class ExternalContent extends DataObject {
	
	private static $singular_name = 'Content';
	private static $plural_name = 'Content items';
	
	private static $db = array(
		'ExternalID' => 'Varchar',
		'Content' => 'HTMLText',	
	);
	
	
	private static $has_one = array(
		'Type' => 'ExternalContentType',	
	);
	
	private static $many_many = array(
		'Pages'	=> 'ExternalContentPage',
	);

	private static $indexes = array(
		'ExternalIDIndex' => array(
			'type' => 'index', 
			'value' => '"ExternalID"'
		)
	);

	private static $searchable_fields = array(
		'ExternalID',
		'Type.Name' => array('title' => 'Content Type'),
		'Pages.AppName' => array('title' => 'Application')
	);
	
	
	/**
	 * Combine summary fields with field labels
	 * @var array
	 */
	private static $summary_fields = array(
		'ExternalID' => 'External ID',
		'ContentSummary' => 'Content',
		'Type.Name' => 'Content type'
	);

	/**
	 * Strip HTML from content summary
	 */
	public function ContentSummary(){
		return $this->obj('Content')->Summary(10);
	}
	
	public function IsPlaintext(){
		if(!$this->Type()) return false; // default to html
		return $this->Type()->ContentIsPlaintext;
	}

	public function canView($member = null) {
		return Permission::check('VIEW_EXTERNAL_CONTENT_API');;
	}
	public function canEdit($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}
	public function canDelete($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}
	public function canCreate($member = null) {
		return Permission::check('CMS_ACCESS_ExternalContentAdmin');
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$contentField = null;
		if($this->IsPlaintext()){
			$contentField = TextareaField::create('Content', 'Content', $this->Content);
			$contentField->setDescription('This editor accepts plain text only due to the Content Type selected');
		}else{
			$contentField = HtmlEditorField::create('Content', 'Content', $this->Content, 'external-content-api');
		}
		$fields->replaceField('Content', $contentField);
		
		return $fields;
	}
	
	protected function onBeforeWrite(){
		parent::onBeforeWrite();
		if($this->IsPlaintext()){
			$this->Content = $this->cleanupPlaintext($this->Content);
		}
	}
	
	protected function cleanupPlaintext($raw){
		$r = strip_tags($raw);
		$r = trim(preg_replace('/\s+/', ' ', $r)); // remove newlines
		return $r;
	}
	
}
