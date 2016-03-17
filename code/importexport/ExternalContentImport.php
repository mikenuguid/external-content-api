<?php
class ExternalContentImport extends CsvBulkLoader {
//Tolling,Account,account.resendpin,/account/resend-pin,IT-233,"<p>To have your PIN emailed to you, please enter your username, account holder number, or toll account ID below.</p>"
//


	public function processRecord($record, $columnMap, &$results, $preview = false) {
//		debug::dump([$record, $columnMap, $results, $preview]); 
            // [Application] => Tolling
            // [Area] => Account
            // [PageName] => account.resendpin
            // [PageUrl] => /account/resend-pin
            // [ContentID] => IT-233
            // [Content] => 
            // 		
		$applicationName = isset($record['Application']) ? $record['Application'] : null;
		$areaName = isset($record['Area']) ? $record['Area'] : null;
		$pageName = isset($record['PageName']) ? $record['PageName'] : null;
		$pageUrl = isset($record['PageUrl']) ? $record['PageUrl'] : null;
		$contentExternalID = isset($record['ContentID']) ? $record['ContentID'] : null;
		$contentContent = isset($record['Content']) ? $record['Content'] : null;

		$application = $this->findOrMake('ExternalContentApplication', $applicationName);
		if($application && !$application->ID) {
			$application->write();
		}
		$area = $this->findOrMake('ExternalContentArea', $areaName);
		if($area && !$area->ID) {
			$area->ApplicationID = $application->ID;
			$area->write();
		}

		$contentPage = $this->findOrMake('ExternalContentPage', $pageName);
		if($contentPage && !$contentPage->ID) {
			$contentPage->URL = Convert::raw2sql($pageUrl);
			$contentPage->AreaID = $area->ID;
			$contentPage->write();
		}

		$c = $this->findOrMake('ExternalContent', $contentExternalID, 'ExternalID');

		if($c) {
			if($c->ID) {
				$results->addUpdated($c, 'content record skipped');
			} else {
				$c->Content = $this->deWordify($contentContent);
				$c->write();
				$results->addCreated($c, 'content record created');
			}

			$c->Pages()->add($contentPage);
		}

		return $c;		
	}

	/**
	 * Create a new dataobject, or find one matching the specified key and name
	 * If the dataobject is new, it will set the $key to the given $name
	 * This function will not write to the database, it will just return existing objects,
	 * or newly created ones that haven't been written yet.
	 * @param  [string] $dataObject [description]
	 * @param  [string] $data       [description]
	 * @param  string $nameKey    [description]
	 * @return [DataObject]             [description]
	 */
	private function findOrMake($dataObject, $name, $key = 'Name') {
		if(!class_exists($dataObject)) return null;

		$do = $dataObject::create();

		if($dataObject && $key && $name) {
			$key = Convert::raw2sql($key);
			$name = Convert::raw2sql($name);
			$do = $dataObject::get()->find($key, $name);
			if(!($do && $do->ID)) {
				$do = $dataObject::create();
				$do->$key = $name;
			}
		}
		return $do;
	}

	/**
	 * Convert "smart" Microsoft Word characters to standard ASCI
	 * @param   $content string that contains Word generated characters
	 * @return string
	 */
	private function deWordify($content) {
		$search = 
			array(chr(145), //‘ msword single quote
			chr(146), //’  msword single quote
			chr(147), //“  msword double quote
			chr(148), //”  msword double quote
			chr(151) // msword emdash
		); 

		$replace = array("'", 
			"'", 
			'"', 
			'"', 
			'-'
		); 

    	return str_replace($search, $replace, $content);
	}

}