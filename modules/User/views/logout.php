<?php
/*
 * logout view for user module
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
class logout extends TSView
{
    public function display() {
        $this->setOptions(array());
        $this->_viewTpl = "logout";
        $vwData = $this->LoadView();
    }
}