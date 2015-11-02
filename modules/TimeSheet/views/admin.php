<?php
/*
 * admin view for timesheet module
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
class admin extends TSView
{
    public function display() {
        // Load all users
        $Users = new UserArray();
        $Users->load();
        // Load all clients
        $Clients = new ClientArray();
        // Set template data
        $this->_tplData["Clients"] = $Clients->LoadClientWithProjects();
        $this->_tplData["Users"] = $Users->getArray();
        if(isset($_POST["clientId"]) && !empty($_POST["clientId"])) {
            foreach($this->_tplData["Clients"] as $cid => $values) {
                if($cid == $_POST["clientId"]) {
                    $this->_tplData["SearchText"] = $values["Name"];
                }
            }
        } else {
            $this->_tplData["SearchText"] = "";
        }
        $this->setOptions(array());
        $this->_viewTpl = "admin";
        $vwData = $this->LoadView();
    }
}