<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

require __DIR__ . '/../Header.php';

$inputFileName = __DIR__ . '/sampleData/example1.csv';
$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
$spreadsheet = IOFactory::load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
// var_dump($sheetData);
//print_r($sheetData);
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
