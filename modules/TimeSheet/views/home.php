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
        $client = isset($_POST["client"]) ? $_POST["client"] : $TimeSheetSettings->getDefaultClient();
        $project = isset($_POST["project"]) ? $_POST["project"] : $TimeSheetSettings->getDefaultProject();
        $this->_tplData["MyClients"] = $_SESSION["User"]->GetClientProjectArray($client,$project);
        $this->_tplData["LineItems"] = $LineItems->LoadLineItems($project);
        $this->_tplData["ActiveProject"] = $Projects->LoadActiveProjects();
        $vwData = $this->LoadView();
    }
}