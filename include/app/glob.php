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

$GLOBALS["APP"] = array(
	"INSTANCE"	=>	null,
	"FORCE_LOGIN"	=>	null,
  "MSG" => array(
    "ERROR"	=>	null,
    "SUCCESS" => null,
    "INFO" => null,
  ),
	"MODULE_MAP"	=>	array(
		"timesheet"	=>	"TimeSheet",
		"user"		=>	"User",
	),
	"NAVIGATION"	=>	array(
		"timesheet"	=>	array("Home"=>"Home","Admin"=>"Admin"),
		"user"		=>	array("Home"=>"Home"),
	),
);
?>
