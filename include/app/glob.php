<?php
/**********************************************
 * GLOBs
 * Global variables
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 *******************************************/
$GLOBALS["STARTDATE"] = new DateTime("2015-10-19");
$GLOBALS["ENDDATE"] = new DateTime();
$GLOBALS["APP"] = array(
	"INSTANCE"	=>	null,
	"FORCE_LOGIN"	=>	null,
  "MSG" => array(
    "ERROR"	=>	null,
    "SUCCESS" => null,
    "INFO" => null,
  ),
	"MODULE_MAP"	=>	array(
		"ajax" => "Ajax",
		"timesheet"	=>	"TimeSheet",
		"user"		=>	"User",
	),
	"NAVIGATION"	=>	array(
		"timesheet"	=>	array("Home"=>"Home","Summary"=>"Summary","Admin"=>"Admin"),
		"user"		=>	array("Home"=>"Home","Admin"=>"Admin"),
	),
);
?>
