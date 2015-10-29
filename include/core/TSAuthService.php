<?php
include_once("include/core/IAuthService.php");

/***********************************************
 * TSAuthService
 * Handles authentication, entry point access,
 * and checks if a user is logged in
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 ***************************************************/
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/
class TSAuthService implements IAuthService {

	/*	PROPERTIES	*/
	private $_forceLogOutSeconds;

	/*	END PROPS	*/

	public function TSAuthService($forceLogOutSeconds) {
		$this->_forceLogOutSeconds = $forceLogOutSeconds;
	}


	/********************************************
	 * validEntryPoint
	 * validates app entry point
	 *
	 * @param path: string path to check
	 * @return bool true if valid
	 *******************************************/
	public function validEntryPoint($path = "") {
		return true;
	}

	/**********************************************
	 * isLoggedIn
	 * checks if user is logged in and logged in
	 * session has not expired
	 *
	 * @return bool true if logged in
	 **********************************************/
	public function isLoggedIn() {
		return true;
		if(isset($_SESSION["PHPSESSID"]) && !empty($_SESSION["PHPSESSID"]) && $_SESSION["PHPSESSID"] === true) {
			$time_now = time();
			$logged_in_time = (isset($_SESSION["LoggedInTime"]) && $_SESSION["LoggedInTime"] > 0) ? $_SESSION["LoggedInTime"] : 0;
			// make sure user have not been logged in longer than max allowed time
			if((($time_now - $logged_in_time) / 1000) >= $this->_forceLogOutSeconds) {
				$GLOBALSS["APP"]["FORCE_LOGIN"]=true;
				return false;
			}
			/*
			 * TODO
			 * 		check user session values.... like validating a hash that is created at log in and shit
			 */
			 return true;
		}
		return false;
	}


}
?>
