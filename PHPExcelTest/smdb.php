<?php
/**
 * Created by PhpStorm.
 * User: schaefec
 * Date: 5/6
 * Time: 21:54
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

require_once('../../Beginner/Database/dbMSSQL.php');
$fetchType = SQLSRV_FETCH_NUMERIC;
$db = new dbMSSQL('localhost','loguser','loguser','SMDBDev');
$db->connect();
$db->execute_query("SELECT * FROM AccountActivity.LogView");
$time = microtime(true);
$aa = $db->toArray($fetchType);
$cols = $db->colNames();
/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$row_offset = 1;
for($i = 0; $i < count($cols); $i++) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i,$row_offset,$cols[$i]);
}
$row_offset++;
for ($i = 0; $i < count($aa); $i++) {
    $colCount = ($fetchType == SQLSRV_FETCH_BOTH) ? count($aa[$i]) / 2 : count($aa[$i]);
    for ($j = 0; $j < $colCount; $j++) {
        $value = $aa[$i][$j];
        if ($value instanceof DateTime) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $row_offset, date('m/d/y', $value->getTimestamp()));
        } elseif($cols[$j] == 'Prob %') {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j,$row_offset,$value . '%');
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $row_offset, $value);
        }
    }
    $row_offset++;
}
$objPHPExcel->getActiveSheet()->getStyle('K2:K'.$i)->getNumberFormat()->setFormatCode('#,##0');
$objPHPExcel->getActiveSheet()->getStyle('L2:L'.$i)->getNumberFormat()->setFormatCode('$#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('M2:M'.$i)->getNumberFormat()->setFormatCode('#,##0');
$objPHPExcel->getActiveSheet()->getStyle('P2:P'.$i)->getNumberFormat()->setFormatCode('#%');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="smdb.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');