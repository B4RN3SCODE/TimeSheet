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

	/**
	 * UserController constructor
	 */
	public function __construct() {
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
			case "index":
				case "home":
				if(is_logged_in())
					$this->Redirect("user","edit");
				break;
			case "logout":
				$this->Redirect("user","index","logout");
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
		if(!is_null($this->User)) {
			$this->User->setOnline(0);
			$this->User->save();
		}
		$GLOBALS["APP"]["INSTANCE"]->SessionTerminate();
		$GLOBALS["APP"]["MSG"]["ERROR"] = "You have been logged out!";
		$this->Redirect("user","login");
	}

	/**
	 * Change the current signed on users password.
	 * @param $oldpassword
	 * @param $newpassword
	 */
	public function ChangePassword() {
		$oldpassword = $_POST["old-pw"];
		$newpassword = ($_POST["new-pw"] == $_POST["cfm-pw"]) ? $_POST["new-pw"] : "";
		if($newpassword == "") {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Passwords do not match.";
			return $this->Redirect("User","ChangePassword");
		}
		if(password_verify($oldpassword, $this->User->getPassword())) {
			$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
			$this->User->setPassword($newpassword);
			if($this->User->save()) {
				$GLOBALS["APP"]["MSG"]["SUCCESS"] = "Password changed successfully.";
				return $this->Redirect("User","Edit");
			} else {
				$GLOBALS["APP"]["MSG"]["ERROR"] = "There was a problem changing your password, please try again.";
				return false;
			}
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Incorrect password.";
			return $this->Redirect("User","ChangePassword");
		}
	}

	/**
	 * Adds a new user to the database.
	 * @param null $User
	 * @return bool
	 */
	public function AddUser() {
		if(isset($_POST["email"]) && strlen(trim($_POST["email"])) > 0) {
			if(isset($_POST["password"]) && strlen(trim($_POST["password"])) > 0 ) {
				if(isset($_POST["fname"]) && strlen(trim($_POST["fname"])) > 0) {
					if(isset($_POST["lname"]) && strlen(trim($_POST["lname"])) > 0) {
						$User = new User();
						$User->PrepNewUser();
						$User->setFirstName($_POST["fname"]);
						$User->setLastName($_POST["lname"]);
						$User->setEmail(trim($_POST["email"]));
						$User->setPassword(password_hash($_POST["password"],PASSWORD_DEFAULT));
						if($User->save()) {
							$GLOBALS["APP"]["MSG"]["INFO"] = "User account created successfully.";
						} else {
							$GLOBALS["APP"]["MSG"]["ERROR"] = "There was a problem creating a new user.<br />" . $this->User->GetDBError();
						}
					} else {
						$GLOBALS["APP"]["MSG"]["ERROR"] = "Please provide a last name.";
					}
				} else {
					$GLOBALS["APP"]["MSG"]["ERROR"] = "Please provide a first name.";
				}
			} else {
				$GLOBALS["APP"]["MSG"]["ERROR"] = "Please enter a password.";
			}
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "Please enter an email address.";
		}
		return $this->Redirect("user","admin");
	}

	public function Update() {
		$this->User->setFirstName($_POST["first-name"]);
		$this->User->setLastName($_POST["last-name"]);
		$this->User->setEmail($_POST["email"]);
		$this->User->setPhone($_POST["phone"]);
		if($this->User->save()) {
			$GLOBALS["APP"]["MSG"]["SUCCESS"] = "Your profile information has been updated.";
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "There was a problem updating your profile.<br />" . $this->User->GetDBError();
		}
		$this->Redirect("user","edit");
	}

	public function UpdateDefault() {
		if(!isset($_POST["default-client"])) {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "<strong>Uh oh! </strong>There was a problem updating your settings. Please try again.";
			return $this->Redirect("user","edit");
		}
		if(!isset($_POST["default-project"])) {
			$_POST["default-project"] = 0;
		}
		$TimeSheetSettings = new TimeSheetSettings($this->User->getId());
		$TimeSheetSettings->setUserId($this->User->getId());
		$TimeSheetSettings->setDefaultClient($_POST["default-client"]);
		$TimeSheetSettings->setDefaultProject($_POST["default-project"]);
		if($TimeSheetSettings->save()) {
			$GLOBALS["APP"]["MSG"]["SUCCESS"] = "Your settings updated.";
		} else {
			$GLOBALS["APP"]["MSG"]["ERROR"] = "There was a problem updating your settings.<br />" . $TimeSheetSettings->GetDBError();
		}
		return $this->Redirect("user","edit");
	}

	public function GetProjectsByClient() {
		$ReturnArray = array();
		if(isset($_POST["ClientId"]) && $_POST["ClientId"] != 0) {
			$ProjectArray = new ProjectArray();
			foreach ($ProjectArray->LoadProjectsByClientId($_POST["ClientId"]) as $id => $values) {
				$ReturnArray[$id] = $values["Name"];
			}
		}
		$this->EncodeAndSendJSON($ReturnArray);
	}
}
?>
