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
        $client = isset($_POST["client"]) ? $_POST["client"] : -1;
        $project = isset($_POST["project"]) ? $_POST["project"] : -1;
        $this->_tplData["MyClients"] = $_SESSION["User"]->GetClientProjectArray($client,$project);
        $vwData = $this->LoadView();
    }
}