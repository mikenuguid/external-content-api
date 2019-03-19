<?php
class ExternalContentExportButton extends GridFieldExportButton {
	
	public function generateExportFileData($gridField) {

		//Remove GridFieldPaginator as we're going to export the entire list.
		$gridField->getConfig()->removeComponentsByType('GridFieldPaginator');

		$listOfContent = $gridField->getManipulatedList();

		foreach($gridField->getConfig()->getComponents() as $component){
			if($component instanceof GridFieldFilterHeader || $component instanceof GridFieldSortableHeader) {
				$listOfContent = $component->getManipulatedData($gridField, $listOfContent);
			}
		}

		$row = array();

		//header row
		$headers = array(
			'Application',
			'Area',
			'PageName',
			'PageUrl',
			'ContentID',
			'Content',
			'Type',
		);

		//PHP doesn't let you output CSV directly to a variable; it expects a file handle
		//Rather than use the filesystem, dump to the output buffer
		//ob_get_clean will dump it to a string that can be returned
		$csvOut = fopen('php://output', 'w');
		ob_start();

		//native function generates all the tricky formatting for us
		fputcsv($csvOut, array_values($headers));

		//data rows
		foreach($listOfContent as $content) {

			$contentPages = $content->Pages();
			foreach($contentPages as $page) {
				$row['Application'] = $page->Area() && $page->Area()->Application()
						? $page->Area()->Application()->Name
						: '';

				$row['Area'] = $page->Area() ? $page->Area()->Name : '';
				$row['PageName'] = $page->Name;
				$row['PageUrl'] = $page->URL;
				$row['ContentID'] = $content->ExternalID;

				$bodyContent = str_replace(array("\r", "\n"), "\n", $content->Content);
				$row['Body'] = $bodyContent;

				$row['Type'] = $content->Type() ? $content->Type()->Name : '';

				//dump CSV row to output buffer
				fputcsv($csvOut, $row);

			}
		}

		//close the handle and dump the output buffer to a string
		fclose($csvOut);
		$csv = ob_get_clean();
		return $csv;
	}
}
