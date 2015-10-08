<?php
/***************************************************
 * TSView
 *
 * Renders basic HTML shit
 *
 * @author			CT Technologies
 * @contact			b4rn3scode@gmail.com
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


	public function TSView($title = "", $css = array(), $js = array(), $tpl = STR_EMP) {
		$this->PageTitle = $title;
		$this->CssHrefs = $css;
		$this->JsSrcs = $js;
		$this->MetaTags = array();
		$this->ViewTpl = $tpl;
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

	public function LoadView($once = true, $listData = null) {
		if(!$this->ViewExists()) {
			$errStr = "Tried to load a view template that does not exist: Path '{$this->ViewTpl}'";
			throw new Exception($errStr);
		} else {
			if(!isset($this->PageTitle) || !FTBase::StringHasValue($this->PageTitle))
				$this->PageTitle = "FastTimes - Where the fastest sites are found";

			$PAGETITLE = $this->PageTitle;
			$HTMLHEAD = $this->HtmlHead;
			if($this->DisplayOptions["head"])
				include_once("Views/head.php");

			$listData = (!empty($listData)) ? $listData : array();
			$TPLDATA = $this->TplData;

			if($once)
				include_once($this->ViewTpl);
			else
				include($this->ViewTpl);

			if($this->DisplayOptions["foot"])
				include_once("Views/foot.php");

		}
	}

	public function ParseTemplate($tpl, $extract_vars) {
		$buffer = file_get_contents($tpl);
		foreach($extract_vars as $k => $v) {
			$buffer = str_replace("%{$k}%", $v, $buffer);
		}
		$this->TplData = $buffer;
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
