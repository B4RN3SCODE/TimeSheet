<?php
/*
 * UserController
 * Controller for the user module
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
class UserController extends TSController {

	public function index() {
		if($this->_view == "edit") {
			$userData = $this->getUserData(1);// for testing... replace with $_SESSION["User"]->getUserId() when ready
			$this->_viewProcessor->_tplData = $userData;
		}
		$this->_viewProcessor->display();
	}

	public function getUserData($userid=0) {
		if($userid < 1) {
			return false;
		}

		return $this->_serviceAdapter->getUserData($userid);
	}
}
?>
