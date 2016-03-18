<?php
class ExternalContentExportButton extends GridFieldExportButton {
	
	public function generateExportFileData($gridField) {
		$separator = $this->csvSeparator;
		$fileData = '';
		$listOfContent = ExternalContent::get();

		$row = array();

		//headers
		$headers = array(
			'Application',
			'Area',
			'PageName',
			'PageURL',
			'ExternalID',
			'Content',
			'Type',
		);
		$fileData .= "\"" . implode("\"{$separator}\"", array_values($headers)) . "\"";
		$fileData .= "\n";

		//data
		foreach($listOfContent as $content) {

			$contentPages = $content->Pages();
			foreach($contentPages as $page) {
				$row['Application'] = $this->wrapQuotes(
					$page->Area() && $page->Area()->Application()
						? $page->Area()->Application()->Name
						: ''
					);
				$row['Area'] = $this->wrapQuotes($page->Area() ? $page->Area()->Name : '');
				$row['PageName'] = $this->wrapQuotes($page->Name);
				$row['PageURL'] = $this->wrapQuotes($page->URL);
				$row['ExternalID'] = $this->wrapQuotes($content->ExternalID);

				$bodyContent = str_replace(array("\r", "\n"), "\n", $content->Content);
				$row['Body'] = $this->wrapQuotes($bodyContent);

				$row['Type'] = $this->wrapQuotes($content->Type() ? $content->Type()->Name : '');
				$fileData .= implode($separator, $row);
				$fileData .= "\n";
			}
		}

		return $fileData;
	}

	private function wrapQuotes($value) {
		return '"' . str_replace('"', '""', $value) . '"';
	}
}