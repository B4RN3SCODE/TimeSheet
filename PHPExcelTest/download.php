<?php
/**
 * Created by PhpStorm.
 * User: schaefec
 * Date: 5/6
 * Time: 19:25
 */
    $file = (isset($_GET['f']) && !is_null($_GET['f'])) ? $_GET['f'] : ''; //die('Error, no file specified!');
    if(file_exists($file)) {
        require_once '../Classes/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        // redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    } else {
        function myFilesize($filename) {
            $size = filesize($filename);
            $unit = array('b','kb','mb','gb', 'tb', 'pb');
            $count = 0;
            while($size >= 1024) {
                $size = ($size / 1024);
                $count++;
            }
            return number_format($size) . ' ' . strtoupper($unit[$count]);
        }
        $dir = basename(__DIR__);
        $html = <<<BEGIN
<html>
<head>
<style>
    .th { padding-right: 25px; }
    td.th:first-child { padding-left: 15px; }
    .text-center { text-align: center; }
    .text-right { text-align: right; padding-right: 25px; }</style>
</head>
<body>
<h1>Excel 2007 Files in {$dir}</h1>
<div>
    <table>
        <tr>
            <td class="th">Filename</td>
            <td class="th">File Size</td>
            <td>Download</td>
        </tr>

BEGIN;
        echo $html;
        foreach(glob('*.xlsx') as $filename) {
            $filesize = myFilesize($filename);
            $html = <<<ROW
        <tr>
            <td><li>${filename}</li></td>
            <td class="text-right">{$filesize}</td>
            <td class="text-center"><a href="download.php?f={$filename}">Link</a></td>
        </tr>

ROW;
            echo $html;
        }
        $html = <<<END
    </table>
</div>
</body>
</html>
END;
echo $html;
    }
?>