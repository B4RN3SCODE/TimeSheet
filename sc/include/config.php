<?php
/********************************************
 * CONFIG
 *
 * Configuration file for the application
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 *******************************************/
/**		General		**/
define("STR_EMP", "");

/**		DB		**/
if(strpos($_SERVER["HTTP_HOST"],"barnescode") === false) {
	define("DB_HOST", "localhost");
} else {
	define("DB_HOST", "bctimesheet.db");
}
define("DB_USER", "scuser");
define("DB_PASS", "ZXxVANtsSP2q4SJ6");
define("DB_NAME", "SnakeCharmer");

/**		MISC	**/
?>