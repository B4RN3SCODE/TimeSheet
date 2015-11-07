<?php
/*
 * home view for timesheet module
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
class home extends TSView
{
    public function display() {
        $this->setOptions(array());
        $this->_viewTpl = "home";
        $LineItems = new LineItemArray();
        $TimeSheetSettings = new TimeSheetSettings($_SESSION["User"]->getId());
        $Projects = new ProjectArray();

        if(!isset($_POST["client"]) && !isset($_POST["project"])) {
            $project = $TimeSheetSettings->getDefaultProject();
            $client = $TimeSheetSettings->getDefaultClient();
        } else if(isset($_POST["project"])) {
            $project = $_POST["project"];
            if(isset($_POST["client"])) {
                $client = $_POST["client"];
            } else {
                $Project = new Project($project);
                $client = $Project->getClientId();
            }
        } else if(isset($_POST["client"])) {
            $client = $_POST["client"];
        }
        $this->_tplData["MyClients"] = $_SESSION["User"]->GetClientProjectArray($client,$project);
        $this->_tplData["LineItems"] = $LineItems->LoadLineItems($project);
        $this->_tplData["ActiveProject"] = $Projects->LoadActiveProjects();
        $this->_tplData["Submitted"] = TimeSheetSubmit::Submitted($_SESSION["User"]->getId(),$_SESSION["CurrentBillingPeriod"]["StartDate"],$_SESSION["CurrentBillingPeriod"]["EndDate"]);
        foreach((new TimeSheetPeriodArray())->load()->getArray() as $TimeSheetPeriod) {
            $StartDate = $TimeSheetPeriod->getCycleStart();
            $EndDate = $TimeSheetPeriod->getCycleEnd();
            $label = ($StartDate == $_SESSION["CurrentBillingPeriod"]["StartDate"])
              ? "Current Cycle"
              :(new DateTime($StartDate))->format("m/d/Y") . " to " . (new DateTime($EndDate))->format("m/d/Y");
            $this->_tplData["BillingPeriod"] = array($TimeSheetPeriod->getId() => $label);
        }
        $vwData = $this->LoadView();
    }
}

function bs() {
    $BillingPeriod = array();
    $TimeSheetPeriodArray = new TimeSheetPeriodArray();
    $TimeSheetPeriodArray->load();
    foreach($TimeSheetPeriodArray as $TimeSheetPeriod) {
        $StartDate = $TimeSheetPeriod->getCycleStart();
        $EndDate = $TimeSheetPeriod->getCycleEnd();
        $value = strtotime($StartDate) . "-" . strtotime($EndDate);
        $label = ($StartDate == $_SESSION["CurrentBillingPeriod"]["StartDate"])
          ? "Current Cycle"
          :(new DateTime($StartDate))->format("m/d/Y") . " to " . (new DateTime($EndDate))->format("m/d/Y");
        $BillingPeriod[] = array("value"=>$value,"label"=>$label);
    }
}/*
                      $start_date = $_SESSION["CurrentBillingPeriod"]["StartDate"];
                      $end_date = $_SESSION["CurrentBillingPeriod"]["EndDate"];
                      ?>
<option value="<?php echo strtotime($start_date) . "-" . strtotime($end_date);?>">Current Cycle</option>
<?php
$previousArr = array();
$new_start_date = date_sub(new DateTime($start_date),new DateInterval("P16W"))->format("Y-m-d");
$daterange = new DatePeriod(new DateTime($new_start_date), new DateInterval('P2W'), new DateTime($start_date));
foreach($daterange as $date) {
    $end_date = clone($date);
    $end_date = $end_date->modify("+13 days")->format("m/d/Y");
    $date = $date->format("m/d/Y");
    $previousArr[] = array("value"=>strtotime($date) . "-" . strtotime($end_date),"label"=>$date . " to " . $end_date);
}
$previousArr = array_reverse($previousArr);
foreach($previousArr as $option) { ?>
    <option value="<?php echo $option["value"]; ?>"><?php echo $option["label"]; ?></option><?
} ?>
} }*/