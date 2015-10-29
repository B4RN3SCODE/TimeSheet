<?php
/*
 * login view for timesheet module
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
class login extends TSView
{
    public function display() {
        $this->setOptions(array());
        $this->_viewTpl = "login";
        $vwData = $this->LoadView();
    }
}