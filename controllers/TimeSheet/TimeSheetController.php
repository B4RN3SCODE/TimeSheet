<?php
class TimeSheetController extends TSController {
    public function __construct() {
        if(isset($_SESSION["User"])) {
            $this->User = $_SESSION["User"];
        }
    }
    public function index() {
        if($this->_view = "admin" && $this->_action = "addclient") {
            $this->_viewProcessor->_tplData["addclient"] = $_POST;
        }
        $this->_viewProcessor->display();
    }

    public function AddClient() {
        foreach($_POST as $key => $value) {
            $$key = $value;
        }
        if(empty($name) || empty($street) || empty($state) || empty($zip) || empty($contact) || empty($phone)) {
            $GLOBALS["APP"]["MSG"]["ERROR"] = 'Please fill out all fields.<script>$(document).ready(function() { $("button[data-target=\'#modal-newclient\']").click(); });</script>';
        }
        return $this->Redirect("timesheet","admin");
    }
    public function AddProject() {
        if(!isset($_POST["clientId"]) || empty($_POST["clientId"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"] = "Missing client id, please try again.";
        } else if(!isset($_POST["name"]) || empty($_POST["name"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"] = "Missing new project name, please try again.";
        } else if(!isset($_POST["rate"]) || empty($_POST["rate"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"] = "Missing rate, please try again.";
        }
        if(isset($GLOBALS["APP"]["MSG"]["ERROR"])) return $this->Redirect("TimeSheet","Admin");
        $Project = new Project();
        $Project->setClientId($_POST["clientId"]);
        $Project->setUserId($this->User->getId());
        $Project->setTitle(trim($_POST["name"]));
        $Project->setDateCreated(time());
        $Project->setRate(trim($_POST["rate"]));
        if($Project->save()) {
            $GLOBALS["APP"]["MSG"]["SUCCESS"] = "Project added.";
        } else {
            $GLOBALS["APP"]["MSG"]["ERROR"] = "Something went wrong. Unable to create new project.<br />" . $Project->GetDBError();
        }
        $this->Redirect("TimeSheet","Admin");
    }
}
?>
