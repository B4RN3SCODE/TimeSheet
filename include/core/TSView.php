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

	public $_pageTitle;

	public $_cssHrefs = array();

	public $_jsSrcs = array();

	public $_metaTags = array();

	public $_viewTpl;

	public $_htmlHead;

	public $_tplData;

	public $_displayOptions = array();

	public static $DEFAULT_OPTIONS = array("head" => true, "nav" => true, "foot" => true);


	public function TSView() {
		$this->_pageTitle = STR_EMP;
		$this->_cssHrefs = array();
		$this->_jsSrcs = array();
		$this->_metaTags = array();
		$this->_htmlHead = "";
		$this->_tplData = "";
		$this->_displayOptions = self::$DEFAULT_OPTIONS;

	}

	public function ViewExists($pth = STR_EMP) {
		if(TSApp::StringHasValue($pth)) {
			return file_exists($pth);
		}
		return file_exists($this->_viewTpl);
	}

	public function BuildHead() {
		if(!is_null($this->_metaTags) && !empty($this->_metaTags) && count($this->_metaTags) > 0) {
			foreach($this->_metaTags as $meta)
				$this->_htmlHead .= "<meta property=\"{$meta["property"]}\" content=\"{$meta["content"]}\" />";
		}
		if(!is_null($this->_jsSrcs) && !empty($this->_jsSrcs) && count($this->_jsSrcs) > 0) {
			foreach($this->_jsSrcs as $src)
				$this->_htmlHead .= "<script type=\"text/javascript\" src=\"{$src}\"></script>\n";
		}
		if(!is_null($this->_cssHrefs) && !empty($this->_cssHrefs) && count($this->_cssHrefs) > 0) {
			foreach($this->_cssHrefs as $href)
				$this->_htmlHead .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"${href}\">";
		}
	}

	public function SetUp() {
		return true;
	}

	public function LoadView($listData = null) {
		$tmp = strtolower($GLOBALS["APP"]["INSTANCE"]->_controller->_module);
		$str_pth = "modules/{$GLOBALS["APP"]["MODULE_MAP"][$tmp]}/views/templates/{$this->_viewTpl}.php";

		if(!$this->ViewExists($str_pth)) {
			$errStr = "Tried to load a view template that does not exist: Path '{$this->_viewTpl}'";
			throw new Exception($errStr);
		} else {

			if(!isset($this->_pageTitle) || !TSApp::StringHasValue($this->_pageTitle))
				$this->_pageTitle = "TimeSheet Management Software | Presented by Arbor Solutions, INC.";


			$PAGETITLE = $this->_pageTitle;
			$HTMLHEAD = $this->_htmlHead;


			if($this->_displayOptions["head"])
				include_once("views/head.php");
			if($this->_displayOptions["nav"])
				include_once("views/nav.php");


			$listData = (!empty($listData)) ? $listData : array();
			$TPLDATA = $this->_tplData;

			$FORCELOGIN = (isset($GLOBALS["APP"]["FORCE_LOGIN"]) && $GLOBALS["APP"]["FORCE_LOGIN"]===true);

			if(TSApp::StringHasValue($this->_viewTpl)) {
				include_once($str_pth);
			}

			if($this->_displayOptions["foot"])
				include_once("views/foot.php");


//            echo "<pre>";
//            print_r(base::stack_trace());
//            echo "</pre>";

			$viewData = ob_get_contents();
			return $viewData;
			ob_end_clean();



            /**
             * [file] => /opt/lampp/htdocs/TimeSheet/modules/User/views/index.php
             * [line] => 19
             * [function] => LoadView
             * [class] => TSView
             * [object] => index Object
             */

        }
	}


	public function setOptions($opts = array()) {
		if(count($opts) < 1)
			$this->_displayOptions = self::$DEFAULT_OPTIONS;
		else {
			foreach($opts as $key => $val) {
				if(!array_key_exists($key, self::$DEFAULT_OPTIONS))
					continue;

				$this->_displayOptions[$key] = $val;
			}
		}
		return (count($this->_displayOptions) == count(self::$DEFAULT_OPTIONS));
	}

	public function LoadTimeSheetDefaults() {
		$ClientArray = new ClientArray();
		$ClientArray->load();
		foreach($ClientArray->getArray() as $Client) {
			$this->_tplData["Clients"][$Client->getId()] = $Client->getName();
		}
		$TSsettings = new TimeSheetSettings();
		if($TSsettings->load($_SESSION["User"]->getId())) {
			$DefaultClient = $TSsettings->getDefaultClient();
			$DefaultProject = $TSsettings->getDefaultProject();
		} else {
			$DefaultClient = 0;
			$DefaultProject = 0;
		}
		$this->_tplData["DefaultClient"] = $DefaultClient;
		$this->_tplData["DefaultProject"] = $DefaultProject;
		if(isset($DefaultClient)) {
			$ProjectArray = new ProjectArray();
			if($Projects = $ProjectArray->LoadByClientId($DefaultClient)) {
				foreach ($Projects as $id => $vals) {
					$this->_tplData["Projects"][$id] = $vals["Name"];
				}
			}
		} else {
			$this->_tplData["Projects"] = null;
		}
	}

}
?>
