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
// detects what db connection credentials to use
if(strpos($_SERVER["HTTP_HOST"],"barnescode") === false) {
	define("DB_HOST", "localhost");
} else {
	define("DB_HOST", "bctimesheet.db");
}
define("DB_USER", "tsuser");
define("DB_PASS", "12wsxcWSXC21");
define("DB_NAME", "TimeSheet");

/**		MISC	**/
define("DEFAULT_SESSION_TIME", 3600);
?>
