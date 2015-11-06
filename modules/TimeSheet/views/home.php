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
        $CycleStart = $_SESSION["CurrentBillingPeriod"]["StartDate"];
        $CycleEnd = $_SESSION["CurrentBillingPeriod"]["EndDate"];
        $this->_tplData["Submitted"] = TimeSheetSubmit::Submitted($_SESSION["User"]->getId(),$_SESSION["CurrentBillingPeriod"]["StartDate"],$_SESSION["CurrentBillingPeriod"]["EndDate"]); //$TimeSheet->CheckSubmitted($CycleStart,$CycleEnd);
        $vwData = $this->LoadView();
    }
}