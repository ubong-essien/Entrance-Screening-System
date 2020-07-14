<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

require __DIR__ . '/../Header.php';

$inputFileType = 'Xls';
$inputFileName = __DIR__ . '/sampleData/example1.xls';

$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);
$reader = IOFactory::createReader($inputFileType);
$helper->log('Turning Formatting off for Load');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);

$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
// var_dump($sheetData);
$heads = "<table><tr>";
foreach($sheetData as $key => $value){
	// echo $value['A']." ".$value['A']." ".$value['A']." ".$value['A'];
	foreach($value as $key1 => $val){
		 $heads.= "<td>$val</td>";
	}
	$heads.="</tr>";
	//exit;
}
$heads.="</table>";
echo $heads;
