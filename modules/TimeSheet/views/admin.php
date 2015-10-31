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
        $this->_tplData = array("Clients" => $Clients->LoadClientWithProjects(), "Users" => $Users->getArray());
        $this->setOptions(array());
        $this->_viewTpl = "admin";
        $vwData = $this->LoadView();
    }
}