<?php

/**
 * Created by PhpStorm.
 * User: chris
 * Date: 10/29/15
 * Time: 2:50 PM
 */
class login extends TSView
{
    public function display() {
        $this->setOptions(array());
        $this->_viewTpl = "login";
        $vwData = $this->LoadView();
    }
}