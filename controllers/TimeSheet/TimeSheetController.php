<?php
class TimeSheetController extends TSController {
    public function index() {
        if($this->_view == "admin") {
            $Users = new UserArray();
            $Users->load();
            $tplData = array("Users"=>$Users->getArray());
            $this->_viewProcessor->_tplData = $tplData;
        }
        $this->_viewProcessor->display();
    }
}
?>
