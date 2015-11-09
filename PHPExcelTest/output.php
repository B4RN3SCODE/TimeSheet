<?php
chdir("..");
require_once "classes/PHPExcel.php";
include_once "include/app/glob.php";
include_once "include/functions.php";
include_once "include/app/initialize.php";
define("outdir",dirname(__FILE__) . "/../tmp/");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

function pre(array $arr) {
	echo "<pre>";
	print_r($arr);
	echo "<pre>";
}
function format_date($date) {
	global $objPHPExcel, $col, $row, $FormatCells;
	$FormatCells["mm/dd/yyyy"][] = array("sheet"=>$objPHPExcel->getActiveSheet()->getTitle(),"col"=>$col,"row"=>$row);
	return PHPExcel_Shared_Date::PHPToExcel(strtotime($date));
}
function SetActiveSheetByName(PHPExcel $vPHPExcel, $Name) {
	foreach($vPHPExcel->getAllSheets() as $index => $sheet) {
		if($sheet->getTitle() == $Name) {
			$vPHPExcel->setActiveSheetIndex($index);
			return;
		}
	}
}

$FormatCells = array("Hours" => array(), "Travel" => array());
$Totals = array();


$TSApp = new TSApp();
$TSApp->SessionActivate();

$User = new User();
$data = $User->LoadAllEntriesByPeriod(1,2);
$objPHPExcel = new PHPExcel();
$objPHPExcel->createSheet(1);

$Sheets["Totals"] = $objPHPExcel->getSheet(0);
$Sheets["Summary"] = $objPHPExcel->getSheet(1);

foreach($Sheets as $title => $sheet) {
	$sheet->setTitle($title);
}

SetActiveSheetByName($objPHPExcel, "Totals");

$col = 0;
$row = 1;
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Start Date");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"End Date");

foreach($data as $periodId => $periodData) {
	$Totals[$periodId] = array();
	$col = 0;
	$Sheets["Totals"]->setCellValueByColumnAndRow($col,++$row,"Pay Period");
	$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,format_date($periodData["CycleStart"]));
	$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,format_date($periodData["CycleEnd"]));
	SetActiveSheetByName($objPHPExcel, "Summary");
	foreach($periodData["Client"] as $clientId => $clientData) {
		$Totals[$periodId][$clientId] = array();
		$col = 0;
		$Sheets["Summary"]->setCellValueByColumnAndRow($col,$row,"Client");
		$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$clientData["Name"]);
		foreach($clientData["Project"] as $projectId => $projectData) {
			$Totals[$periodId][$clientId][$projectId] = array("Client"=>$clientData["Name"],"Project"=>$projectData["Name"],"Hours"=>0,"Travel"=>0);
			$col = 0;
			$row += 2;
			$Sheets["Summary"]->setCellValueByColumnAndRow($col,$row,"Project");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Name"]);
			$col = 0;
			$Sheets["Summary"]->setCellValueByColumnAndRow($col,++$row,"Date");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Description");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Hours");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Travel");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Billable");
			foreach($projectData["Entry"] as $entryId => $entryData) {
				$Totals[$periodId][$clientId][$projectId]["Hours"] += $entryData['Hours'];
				$Totals[$periodId][$clientId][$projectId]["Travel"] += $entryData['Travel'];
				$col = 0;
				$Sheets["Summary"]->setCellValueByColumnAndRow($col,++$row,format_date($entryData['Date']));
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Description']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Hours']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Travel']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,($entryData['Billable'] == 1) ? "Yes" : "No");
			}
		}
		$row += 2;
	}
	$row += 2;
}
// Format all cells in the array.
foreach($FormatCells as $format => $locations) {
	foreach($locations as $loc) {
		$Sheets[$loc["sheet"]]->getStyleByColumnAndRow($loc["col"], $loc["row"])->getNumberFormat()->setFormatCode($format);
	}
}

SetActiveSheetByName($objPHPExcel, "Totals");

$col = 0; $row = 3;
$Sheets["Totals"]->setCellValueByColumnAndRow($col,$row,"Client");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Project");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Hours");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Travel");
$project_count = 0;
foreach($Totals as $periodId => $periodData) {
	foreach($periodData as $clientId => $clientData) {
		foreach($clientData as $projectId => $projectData) {
			$project_count++;
			$col = 0;
			$Sheets["Totals"]->setCellValueByColumnAndRow($col,++$row,$projectData["Client"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Project"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Hours"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Travel"]);
		}
	}
}
$from = 4;
$to = 3 + $project_count;
$Sheets["Totals"]->setCellValue("A" . (5 + $project_count),"Totals");
$Sheets["Totals"]->setCellValue("C" . (5 + $project_count),"=SUM(C$from:C$to)");
$Sheets["Totals"]->setCellValue("D" . (5 + $project_count),"=SUM(D$from:D$to)");

foreach($Sheets as $Name => $sheet) {
	SetActiveSheetByName($objPHPExcel,$Name);
	foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
		$objPHPExcel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
	}
}

$objPHPExcel->setActiveSheetIndex(0);

$file = time();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$file.xlsx\"");
header("Cache-Control: max-age=0");

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
$objWriter->save("php://output");

die();
$file = outdir . time() . ".xlsx";
echo $file;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($file);