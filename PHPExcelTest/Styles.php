<?
//https://docs.typo3.org/typo3cms/extensions/phpexcel_library/1.7.4/manual.html#_Toc237519971
$styles = array(
	"text-left" => array(
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'shrinkToFit' => true),
	),
	"text-center" => array(
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	),
	"text-right" => array(
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
	),
	"font-bold" => array(
		'font' => array(
			'bold' => true, 'color' => array('rgb' => '000000'), 'size' => 11, 'name' => 'Verdana'
		)
	),
	"font-italic" => array(
	'font' => array(
		'italic' => true, 'color' => array('rgb' => '000000'), 'size' => 11, 'name' => 'Verdana'
		)
	),
	"table" => array(
		'borders' => array(
			'inside' => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
				'color' => array('rgb' => '000000'),
			),
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,
				'color' => array('rgb' => '000000'),
			),
		),
	),
	"border-outline" => array(
		'borders' => array(

		),
	),
);

$styleArray = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => 'FF0000'),
		'size'  => 15,
		'name'  => 'Verdana'
	));