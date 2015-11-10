<?

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
	"border-thin" => array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000'),
			),
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