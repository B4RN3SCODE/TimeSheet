<?php
class TimeSheetController extends TSController {
    public function __construct() {
        if(isset($_SESSION["User"])) {
            $this->User = $_SESSION["User"];
        }
    }
    public function index() {
        if($this->_view = "admin" && ($this->_action = "addclient" || $this->_action = "updateclient")) {
            if(isset($_POST))
                $this->_viewProcessor->_tplData["addclient"] = $_POST;
        }
        $this->_viewProcessor->display();
    }

    public function AddClient() {
        foreach($_POST as $key => $value) {
            $$key = $value;
        }
        if(empty($Name)) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = 'Please enter the clients name.<script>$(document).ready(function() { $("button[data-target=\'#modal-newclient\']").click(); });</script>';
        } else {
            $Client = new Client();
            foreach($_POST as $key => $val) {
                $func = "set$key";
                $Client->$func($val);
            }
            if($Client->save()) {
                $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Project added.";
                unset($_POST);
            } else {
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "Something went wrong while trying to add a new client. Please try again.";
            }
        }
        return $this->Redirect("timesheet","admin");
    }

    public function AddEntry() {
        if(!isset($_POST)) return $this->Redirect("timesheet","home");
        foreach($_POST as $key => $value)
            $$key = $value;
        if($client == -1 || $project == -1) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Please select both a Client and a Project";
            $this->_viewProcessor->_tplData = $_POST;
            return $this->_viewProcessor->display();
        }
        $columns = array("EntryDate","Hours","Travel","Description","Billable");
        $ValidEntries = 0;

        for($index = 0; $index < count($EntryDate); $index++) {
            // Make sure we have valid input
            if(empty($Description[$index]) || strlen(trim($Description[$index])) < 1) {
                $_POST["Error"]["Description"][$index] = true;
                $_POST["Error"][$index] = true;
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "You must enter a description of the task.";
            }
            if($Hours[$index] < 0 || !is_numberic($Hours[$index])) {
                $_POST["Error"]["Hours"][$index] = true;
                $_POST["Error"][$index] = true;
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "Please enter a positive numeric value for Hours.";
            }
            if($Travel[$index] < 0 || !is_numeric($Travel[$index])) {
                $_POST["Error"]["Travel"][$index] = true;
                $_POST["Error"][$index] = true;
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "Please enter a positive numeric value for Travel.";
            }
            // Check for a valid date.
            try {
                $tmpDate = new DateTime($EntryDate[$index]);
            } catch(Exception $ex) {
                $_POST["Error"]["EntryDate"][$index] = true;
                $_POST["Error"][$index] = true;
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "Please enter a valid date. Example: " . date("m/d/Y",time());
            } finally {
                unset($tmpDate);
            }
            if(isset($_POST["Error"][$index]) && $_POST["Error"][$index] == true) continue;
            // Enter the data into a new LineItem object
            $LineItem = new LineItem();
            $LineItem->setUserId($this->User->getId());
            $LineItem->setClientId($client);
            $LineItem->setProjectId($project);
            $LineItem->setDescription($Description[$index]);
            $LineItem->setEntryDate($EntryDate[$index]);
            $LineItem->setHours($Hours[$index]);
            $LineItem->setTravel($Travel[$index]);
            $LineItem->setBillable(isset($_POST["Billable"][$index]) ? 1 : 0);
            // Try to save the entry
            if($LineItem->save()) {
                $ValidEntries++;
                $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Successfully added $ValidEntries entries";
                foreach($columns as $key)
                    unset($_POST[$key][$index]);
            } else {
                $_POST["Error"][$index] = true;
                $GLOBALS["APP"]["MSG"]["ERROR"][] = "Make sure you have filled out all fields correctly.<br />" . $LineItem->GetDBError();
            }
            unset($LineItem);
        }
        $this->Redirect("TimeSheet","Home");
    }

    public function AddProject() {
        if(!isset($_POST["clientId"]) || empty($_POST["clientId"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing client id, please try again.";
        } else if(!isset($_POST["name"]) || empty($_POST["name"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing new project name, please try again.";
        } else if(!isset($_POST["rate"]) || empty($_POST["rate"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing rate, please try again.";
        }
        if(isset($GLOBALS["APP"]["MSG"]["ERROR"])) return $this->Redirect("TimeSheet","Admin");
        $Project = new Project();
        $Project->setClientId($_POST["clientId"]);
        $Project->setUserId($this->User->getId());
        $Project->setTitle(trim($_POST["name"]));
        $Project->setDateCreated(time());
        $Project->setRate(trim($_POST["rate"]));
        if($Project->save()) {
            $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Project added.";
        } else {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Something went wrong. Unable to create new project.<br />" . $Project->GetDBError();
        }
        $this->Redirect("TimeSheet","Admin");
    }

    public function AddProjectToMyList() {
        if(isset($_POST["ProjectId"]) && !empty($_POST["ProjectId"])) $ProjectId = $_POST["ProjectId"];
        $UserProjects = new UserProjects();
        $UserProjects->setUserId($this->User->getId());
        $UserProjects->setProjectId($ProjectId);
        if($UserProjects->save()) {
            $this->EncodeAndSendJSON(array("Status" => "Project added to your list!"));
        } else {
            $this->EncodeAndSendJSON(array("Status" => "Error: " . $UserProjects->GetDBError()));
        }
    }

    public function DeleteProject() {
        if(!isset($_POST["id"]) || empty($_POST["id"])) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing project id.";
        }
        $Project = new Project($_POST["id"]);
        $Project->setActive(false);
        if($Project->save()) {
            $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Project removed. If this was an accident contact an administrator to restore it.";
        } else {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Something went wrong. Unable to update project.<br />" . $Project->GetDBError();
        }
        $this->Redirect("TimeSheet","Admin");
    }

    public function RemoveProjectFromMyList() {
        if(!isset($_POST["ProjectId"]) || empty($_POST["ProjectId"])) {
            $this->EncodeAndSendJSON(array("Status" => "Missing project id"));
            die();
        }
        $UserProjects = new UserProjects($_POST["ProjectId"]);
        if($UserProjects->delete()) {
            $this->EncodeAndSendJSON(array("Status" => "Project removed from your list!"));
        } else {
            $this->EncodeAndSendJSON(array("Status" => "Error: " . $UserProjects->GetDBError()));
        }
    }

    public function UpdateClient() {
        $Client = new Client($_POST["id"]);
        foreach($_POST as $key => $val) {
            $func = "set$key";
            $Client->$func($val);
        }
        if($Client->save()) {
            $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Client updated.";
        } else {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Something went wrong. Unable to update client.<br />" . $Client->GetDBError();
        }
        unset($_POST);
        $this->Redirect("TimeSheet","Admin");
    }

    public function UpdateProject() {
        foreach($_POST as $key => $value) $$key = $value;
        if(!isset($Title) || empty($Title)) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing project title.";
        } else if(!isset($Rate) || empty($Rate)) {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Missing rate.";
        }
        if(isset($GLOBALS["APP"]["MSG"]["ERROR"])) return $this->Redirect("TimeSheet","Admin");
        $Project = new Project($id);
        $Project->setDescription(trim($Description));
        $Project->setTitle(trim($Title));
        $Project->setRate($Rate);
        $Project->setInternalReference($InternalReference);
        $Project->setCustomerReference($CustomerReference);
        if($Project->save()) {
            $GLOBALS["APP"]["MSG"]["SUCCESS"][] = "Project updated.";
        } else {
            $GLOBALS["APP"]["MSG"]["ERROR"][] = "Something went wrong. Unable to update project.<br />" . $Project->GetDBError();
        }
        $this->Redirect("TimeSheet","Admin");
    }

    public function GetClientById() {
        if(!isset($_POST["ClientId"]) || empty($_POST["ClientId"])) {
            die();
        }
        $Client = new Client($_POST["ClientId"]);
        $this->EncodeAndSendJSON($Client->toArray());
    }

    public function GetProjectById() {
        if(!isset($_POST["ProjectId"]) || empty($_POST["ProjectId"])) {
            die();
        }
        $Project = new Project($_POST["ProjectId"]);
        $this->EncodeAndSendJSON($Project->toArray());
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
