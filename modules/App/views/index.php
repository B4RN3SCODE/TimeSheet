<?php
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/
class index extends TSView {
	public function display() {
		$this->setOptions(array());
		$vwData = $this->LoadView();
	}
}
?>
