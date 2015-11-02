<?php
class TimeSheetController extends TSController {
    public function __construct() {
        if(isset($_SESSION["User"])) {
            $this->User = $_SESSION["User"];
        }
    }
    public function index() {
        $this->_viewProcessor->display();
    }
}
?>
