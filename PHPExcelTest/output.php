<?php
chdir("..");
require_once "classes/PHPExcel.php";
include_once "include/app/glob.php";
include_once "include/functions.php";
include_once "include/app/initialize.php";
include_once "PHPExcelTest/Styles.php";
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
function ApplyStyle(PHPExcel_Worksheet $sheet, $colStartChar, $colEndChar = null, $rowStart,$rowEnd = null,array $style) {
	if($colEndChar == null) $colEndChar = $colStartChar;
	if($rowEnd == null) $rowEnd = $rowStart;
	$sheet->getStyle("{$colStartChar}{$rowStart}:{$colEndChar}{$rowEnd}")->applyFromArray($style);
}

$FormatCells = array("Hours" => array(), "Travel" => array());
$Totals = array();


$TSApp = new TSApp();
$TSApp->SessionActivate();

$User = $_SESSION["User"];
$_SESSION["CurrentBillingPeriod"] = base::GetBillingCycle();
$data = $User->LoadAllEntriesByPeriod($_SESSION["CurrentBillingPeriod"]["Period"],$User->getId());
$objPHPExcel = new PHPExcel();
$objPHPExcel->createSheet(1);

$Sheets["Totals"] = $objPHPExcel->getSheet(0);
$Sheets["Summary"] = $objPHPExcel->getSheet(1);

$table = array();

foreach($Sheets as $title => $sheet) {
	$sheet->setTitle($title);
}

SetActiveSheetByName($objPHPExcel, "Totals");

$col = 1; $row = 1;
$Sheets["Totals"]->setCellValueByColumnAndRow($col++,$row,"Employee");
$Sheets["Totals"]->setCellValueByColumnAndRow($col--,$row++,$User->GetName());
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,++$row,"Start Date");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"End Date");

foreach($data as $periodId => $periodData) {
	$Totals[$periodId] = array();
	$col = 1;
	$Sheets["Totals"]->setCellValueByColumnAndRow($col,++$row,"Pay Period");
	$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,format_date($periodData["CycleStart"]));
	$Sheets["Totals"]->getCellByColumnAndRow($col,$row)->getStyle()->applyFromArray($styles["text-left"]);
	$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,format_date($periodData["CycleEnd"]));
	SetActiveSheetByName($objPHPExcel, "Summary");
	$col = 1; $row = 1;
	$Sheets["Summary"]->setCellValueByColumnAndRow($col,$row,"Employee");
	$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$User->GetName());
	foreach($periodData["Client"] as $clientId => $clientData) {
		$col = 1;
		$Totals[$periodId][$clientId] = array();
		$colStartChar = $Sheets["Summary"]->setCellValueByColumnAndRow($col,++$row,"Client",true)->getColumn();
		$colEndChar = $Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$clientData["Name"],true)->getColumn();
		ApplyStyle($Sheets["Summary"],$colStartChar,$colEndChar,$row,null,$styles["font-bold"]);
		foreach($clientData["Project"] as $projectId => $projectData) {
			$Totals[$periodId][$clientId][$projectId] = array("Client"=>$clientData["Name"],"Project"=>$projectData["Name"],"Hours"=>0,"Travel"=>0);
			$col = 1;
			$row += 2;
			$Sheets["Summary"]->setCellValueByColumnAndRow($col,$row,"Project",true);
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Name"]);
			$col = 1;
			$colStartChar = $Sheets["Summary"]->setCellValueByColumnAndRow($col,++$row,"Date",true)->getColumn();
			$table[$objPHPExcel->getActiveSheetIndex()]["start"][] = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Description");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Hours");
			$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Travel");
			$colEndChar = $Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,"Billable",true)->getColumn();
			ApplyStyle($Sheets["Summary"],$colStartChar,$colEndChar,$row,null,$styles["font-italic"]);
			foreach($projectData["Entry"] as $entryId => $entryData) {
				$Totals[$periodId][$clientId][$projectId]["Hours"] += $entryData['Hours'];
				$Totals[$periodId][$clientId][$projectId]["Travel"] += $entryData['Travel'];
				$col = 1;
				$Sheets["Summary"]->setCellValueByColumnAndRow($col,++$row,format_date($entryData['Date']));
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Description']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Hours']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,$entryData['Travel']);
				$Sheets["Summary"]->setCellValueByColumnAndRow(++$col,$row,($entryData['Billable'] == 1) ? "Yes" : "No");
			}
			$table[$objPHPExcel->getActiveSheetIndex()]["end"][] = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
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
$offset = 6;
$col = 1; $row = $offset;
$table[$objPHPExcel->getActiveSheetIndex()]["start"][] = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
$Sheets["Totals"]->setCellValueByColumnAndRow($col,$row,"Client");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Project");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Hours");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"Travel");
$Sheets["Totals"]->getStyle('B6:E6')->applyFromArray($styles["font-bold"]);
$project_count = 0;
foreach($Totals as $periodId => $periodData) {
	foreach($periodData as $clientId => $clientData) {
		foreach($clientData as $projectId => $projectData) {
			$project_count++;
			$col = 1;
			$Sheets["Totals"]->setCellValueByColumnAndRow($col,++$row,$projectData["Client"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Project"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Hours"]);
			$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,$projectData["Travel"]);
		}
	}
}

$from = $offset + 1;
$to = $offset + $project_count;

$col = 1;

$Sheets["Totals"]->setCellValueByColumnAndRow($col++,++$row,"Totals");
$Sheets["Totals"]->mergeCellsByColumnAndRow($col - 1, $row,$col, $row);

$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"=SUM(D$from:D$to)");
$Sheets["Totals"]->setCellValueByColumnAndRow(++$col,$row,"=SUM(E$from:E$to)");

$table[$objPHPExcel->getActiveSheetIndex()]["end"][] = PHPExcel_Cell::stringFromColumnIndex($col) . $row;

// Apply borders around all tables that we captured
foreach($table as $sheetIndex => $data) {
	for($i = 0; $i < count($data["start"]); $i++) {
		$CellCoordinate = $data["start"][$i] . ":" . $data["end"][$i];
		$objPHPExcel->setActiveSheetIndex($sheetIndex)->getStyle($CellCoordinate)->applyFromArray($styles["table"]);
	}
}

// Autosize
foreach($Sheets as $Name => $sheet) {
	SetActiveSheetByName($objPHPExcel,$Name);
	foreach (range('B', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
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

PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007")->save("php://output");

die();
$file = outdir . time() . ".xlsx";
PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($file);