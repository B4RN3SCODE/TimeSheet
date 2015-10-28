<?php
/***************************************************
 * TSView
 *
 * Renders basic HTML shit
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
class TSView {

	public $PageTitle;

	public $CssHrefs = array();

	public $JsSrcs = array();

	public $MetaTags = array();

	public $ViewTpl;

	public $HtmlHead;

	public $TplData;

	public $DisplayOptions = array();

	public static $DEFAULT_OPTIONS = array("head" => true, "foot" => true);


	public function TSView() {
		$this->PageTitle = STR_EMP;
		$this->CssHrefs = array();
		$this->JsSrcs = array();
		$this->MetaTags = array();
		$this->HtmlHead = "";
		$this->TplData = "";
		$this->DisplayOptions = self::$DEFAULT_OPTIONS;

	}

	public function ViewExists() {
		return file_exists($this->ViewTpl);
	}

	public function BuildHead() {
		if(!is_null($this->MetaTags) && !empty($this->MetaTags) && count($this->MetaTags) > 0) {
			foreach($this->MetaTags as $meta)
				$this->HtmlHead .= "<meta property=\"{$meta["property"]}\" content=\"{$meta["content"]}\" />";
		}
		if(!is_null($this->JsSrcs) && !empty($this->JsSrcs) && count($this->JsSrcs) > 0) {
			foreach($this->JsSrcs as $src)
				$this->HtmlHead .= "<script type=\"text/javascript\" src=\"{$src}\"></script>\n";
		}
		if(!is_null($this->CssHrefs) && !empty($this->CssHrefs) && count($this->CssHrefs) > 0) {
			foreach($this->CssHrefs as $href)
				$this->HtmlHead .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"${href}\">";
		}
	}

	public function SetUp() {
		return true;
	}


	public function SetOptions($opts = array()) {
		if(count($opts) < 1)
			$this->DisplayOptions = self::$DEFAULT_OPTIONS;
		else {
			foreach($opts as $key => $val) {
				if(!array_key_exists($key, self::$DEFAULT_OPTIONS))
					continue;

				$this->DisplayOptions[$key] = $val;
			}
		}
		return (count($this->DisplayOptions) == count(self::$DEFAULT_OPTIONS));
	}

}
?>
