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

	private $User;

	/**
	 * UserController constructor
	 */
	public function __construct() {
		// you dont need to instantuate a user here !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// because during the login process, one is created and stored in the session !!!!!!!!!!!!
		// THEREFORE you will always be able to get a user object, cux you have to be logged in !!
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if(isset($_SESSION["User"])) {
			$this->User = $_SESSION["User"];
		}
	}

	public function index() {
		// you dont need to check for login because when TSApp boots up it checks that EVERY REQUEST
		switch($this->_view) {
			case "edit":
				$userData = $this->getUserData($_SESSION["User"]->getId());
				$this->_viewProcessor->_tplData = $userData;
				break;
			case "logout":
				$this->Redirect("user","index","logout");
				break;
			case "index":
				if(is_logged_in())
					$this->Redirect("user","edit");
				break;
			default:
				break;
		}
		$this->_viewProcessor->display();
	}

	public function getUserData($userid=0) {
		if($userid < 1) {
			return false;
		}
		return $this->_serviceAdapter->getUserData($userid);
	}

	/**
	 * Log a user into the application.
	 * @param null $username
	 * @param null $password
	 * @return bool
	 */
	public function Login() {
		$username = isset($_REQUEST["email"]) ? $_REQUEST["email"] : null;
		$password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : null;

		if($username == null || $password == null) {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Invalid username or password";
			$this->Redirect("user","index");
			return false;
		} else {
			$this->User = new User();
			$this->User->LoadByEmail($username);
		}
		if(password_verify($password, $this->User->getPassword())) {
			if($this->User->getActive()) {
				$this->User->setOnline(1);
				$_SESSION["User"] = $this->User;
				$_SESSION["PHPSESSID"] = true;
				$_SESSION["LoggedInTime"] = time();
				$GLOBALS["APP"]["FORCE_LOGIN"] = false;
			} else {
				$GLOBALS["APP"]["MSG"]["ERROR"] = "Your account has been disabled";
				return $this->Redirect("user","login");
			}
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Invalid username or password";
			$this->Redirect("user","index");
			return false;
		}
		// Redirect after successful login to timesheet home
		header('Location: http://' . $_SERVER["HTTP_HOST"] . '/');
	}

	/**
	 * Log the current user out.
	 */
	public function Logout() {
		// you dont need to check for login because when TSApp boots up it checks that EVERY REQUEST
		if(!is_null($this->User = $_SESSION["User"])) {
			$this->User->setOnline(0);
			$this->User->save();
		}
		$GLOBALS["APP"]["INSTANCE"]->SessionTerminate();
		$GLOBALS["APP"]["MSG"]["ERROR"] = "You have been logged out!";
		$this->Redirect("user","index");
	}

	/**
	 * Change the current signed on users password.
	 * @param $oldpassword
	 * @param $newpassword
	 */
	public function ChangePassword($oldpassword,$newpassword) {
		if(!isset($_SESSION["User"])) {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Please login";
			return false;
		}
		$this->User = $_SESSION["User"];
		if(password_verify($oldpassword, $this->User->getPassword())) {
			$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
			$this->User->setPassword($newpassword);
			if($this->User->save()) {
				return true;
			} else {
				$GLOBALS["APP"]["MSG"]["ERROR"] = "There was a problem changing your password, please try again.";
				return false;
			}
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Please enter your old password.";
			return false;
		}
	}

	/**
	 * Adds a new user to the database.
	 * @param null $User
	 * @return bool
	 */
	public function AddUser($User = null) {
		if($User === null) { return false; }
		$User->setPassword(password_hash($User->getPassword(),PASSWORD_DEFAULT));
		return $User->save();
	}
}
?>
