<?php
require_once '../Classes/PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load("../Examples/06largescale.xlsx");
// redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="myfile.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>