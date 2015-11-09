<?php

require_once "../classes/PHPExcel.php";
//include_once "include/app/glob.php";
//include_once "include/functions.php";
//include_once "include/app/initialize.php";
define("outdir",dirname(__FILE__) . "/../tmp/");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

//$TSApp = new TSApp();
//$TSApp->SessionActivate();

// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
//$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
//->setLastModifiedBy("Maarten Balliauw")
//->setTitle("PHPExcel Test Document")
//->setSubject("PHPExcel Test Document")
//->setDescription("Test document for PHPExcel, generated using PHP classes.")
//->setKeywords("office PHPExcel php")
//->setCategory("Test result file");


// Add some data
//echo date('H:i:s') , " Add some data" , EOL;

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Hello')
->setCellValue('B2', 'world!')
->setCellValue('C1', 'Hello')
->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', 'Miscellaneous glyphs')
->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');


$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);


// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="smdb.xlsx"');
//header('Cache-Control: max-age=0');
$file = outdir . time() . ".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($file);
//$objWriter->save('./file.xls');
