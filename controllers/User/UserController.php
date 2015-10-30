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
        if(isset($_SESSION["User"])) {
            $this->User = $_SESSION["User"];
        } else {
            $this->User = new User();
            $_SESSION["User"] = $this->User;
        }
    }

	public function index() {
		if($this->_view == "edit") {
        if(is_logged_in()) {
            $userData = $this->getUserData($_SESSION["User"]->getId());// for testing... replace with $_SESSION["User"]->getUserId() when ready
            $this->_viewProcessor->_tplData = $userData;
        } else {
          $GLOBALS["APP"]["FORCE_LOGIN"] = true;
        }
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
echo "<pre>";
debug_print_backtrace();
echo "</pre>";
		$username = isset($_REQUEST["email"]) ? $_REQUEST["email"] : null;
		$password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : null;

      if($username == null || $password == null) {// || !$this->User->LoadByEmail($username)) {
          $GLOBALS["APP"]["ERROR"] = "Invalid username or password";
          return false;
      } else {
          $this->User = new User();
          $this->User->LoadByEmail($username);
      }
      if(password_verify($password, $this->User->getPassword())) {
          $this->User->setOnline(1);
          $this->User->save();
          $_SESSION["User"] = $this->User;
          return true;
      } else {
          $GLOBALS["APP"]["ERROR"] = "Invalid username or password";
          unset($_SESSION["User"]);
          return false;
      }
      $this->index();
    }

	/**
	 * Log the current user out.
	 */
	public function Logout() {
		if(is_logged_in()) {
			$this->User = $_SESSION["User"];
			$this->User->setOnline(0);
			$this->User->save();
			$GLOBALS["APP"]["INSTANCE"]->SessionTerminate();
		}
		return true;
	}

	/**
	 * Change the current signed on users password.
	 * @param $oldpassword
	 * @param $newpassword
	 */
	public function ChangePassword($oldpassword,$newpassword) {
		if(!isset($_SESSION["User"])) {
			$GLOBALS["ERROR"] = "Please login";
			return false;
		}
		$this->User = $_SESSION["User"];
		if(password_verify($oldpassword, $this->User->getPassword())) {
			$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
			$this->User->setPassword($newpassword);
			if($this->User->save()) {
				return true;
			} else {
				$GLOBALS["ERROR"] = "There was a problem changing your password, please try again.";
				return false;
			}
		} else {
			$GLOBALS["ERROR"] = "Please enter your old password.";
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
