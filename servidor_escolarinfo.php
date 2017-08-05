<?php

// Global variable for table object
$servidor_escolar = NULL;

//
// Table class for servidor_escolar
//
class cservidor_escolar extends cTable {
	var $Nro_Serie;
	var $SN;
	var $Cant_Net_Asoc;
	var $Id_Marca;
	var $Id_Modelo;
	var $Id_SO;
	var $Id_Estado;
	var $User_Server;
	var $Pass_Server;
	var $User_TdServer;
	var $Pass_TdServer;
	var $Cue;
	var $Fecha_Actualizacion;
	var $Usuario;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'servidor_escolar';
		$this->TableName = 'servidor_escolar';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`servidor_escolar`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Nro_Serie
		$this->Nro_Serie = new cField('servidor_escolar', 'servidor_escolar', 'x_Nro_Serie', 'Nro_Serie', '`Nro_Serie`', '`Nro_Serie`', 200, -1, FALSE, '`Nro_Serie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Serie->Sortable = TRUE; // Allow sort
		$this->fields['Nro_Serie'] = &$this->Nro_Serie;

		// SN
		$this->SN = new cField('servidor_escolar', 'servidor_escolar', 'x_SN', 'SN', '`SN`', '`SN`', 200, -1, FALSE, '`SN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SN->Sortable = TRUE; // Allow sort
		$this->fields['SN'] = &$this->SN;

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc = new cField('servidor_escolar', 'servidor_escolar', 'x_Cant_Net_Asoc', 'Cant_Net_Asoc', '`Cant_Net_Asoc`', '`Cant_Net_Asoc`', 3, -1, FALSE, '`Cant_Net_Asoc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cant_Net_Asoc->Sortable = TRUE; // Allow sort
		$this->Cant_Net_Asoc->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cant_Net_Asoc'] = &$this->Cant_Net_Asoc;

		// Id_Marca
		$this->Id_Marca = new cField('servidor_escolar', 'servidor_escolar', 'x_Id_Marca', 'Id_Marca', '`Id_Marca`', '`Id_Marca`', 3, -1, FALSE, '`Id_Marca`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Marca->Sortable = TRUE; // Allow sort
		$this->Id_Marca->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Marca->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Marca->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Marca'] = &$this->Id_Marca;

		// Id_Modelo
		$this->Id_Modelo = new cField('servidor_escolar', 'servidor_escolar', 'x_Id_Modelo', 'Id_Modelo', '`Id_Modelo`', '`Id_Modelo`', 3, -1, FALSE, '`Id_Modelo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Modelo->Sortable = TRUE; // Allow sort
		$this->Id_Modelo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Modelo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Modelo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Modelo'] = &$this->Id_Modelo;

		// Id_SO
		$this->Id_SO = new cField('servidor_escolar', 'servidor_escolar', 'x_Id_SO', 'Id_SO', '`Id_SO`', '`Id_SO`', 3, -1, FALSE, '`Id_SO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_SO->Sortable = TRUE; // Allow sort
		$this->Id_SO->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_SO->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_SO->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_SO'] = &$this->Id_SO;

		// Id_Estado
		$this->Id_Estado = new cField('servidor_escolar', 'servidor_escolar', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado->Sortable = TRUE; // Allow sort
		$this->Id_Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// User_Server
		$this->User_Server = new cField('servidor_escolar', 'servidor_escolar', 'x_User_Server', 'User_Server', '`User_Server`', '`User_Server`', 200, -1, FALSE, '`User_Server`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->User_Server->Sortable = TRUE; // Allow sort
		$this->fields['User_Server'] = &$this->User_Server;

		// Pass_Server
		$this->Pass_Server = new cField('servidor_escolar', 'servidor_escolar', 'x_Pass_Server', 'Pass_Server', '`Pass_Server`', '`Pass_Server`', 200, -1, FALSE, '`Pass_Server`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pass_Server->Sortable = TRUE; // Allow sort
		$this->fields['Pass_Server'] = &$this->Pass_Server;

		// User_TdServer
		$this->User_TdServer = new cField('servidor_escolar', 'servidor_escolar', 'x_User_TdServer', 'User_TdServer', '`User_TdServer`', '`User_TdServer`', 200, -1, FALSE, '`User_TdServer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->User_TdServer->Sortable = TRUE; // Allow sort
		$this->fields['User_TdServer'] = &$this->User_TdServer;

		// Pass_TdServer
		$this->Pass_TdServer = new cField('servidor_escolar', 'servidor_escolar', 'x_Pass_TdServer', 'Pass_TdServer', '`Pass_TdServer`', '`Pass_TdServer`', 200, -1, FALSE, '`Pass_TdServer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pass_TdServer->Sortable = TRUE; // Allow sort
		$this->fields['Pass_TdServer'] = &$this->Pass_TdServer;

		// Cue
		$this->Cue = new cField('servidor_escolar', 'servidor_escolar', 'x_Cue', 'Cue', '`Cue`', '`Cue`', 200, -1, FALSE, '`Cue`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Cue->Sortable = TRUE; // Allow sort
		$this->fields['Cue'] = &$this->Cue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('servidor_escolar', 'servidor_escolar', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;

		// Usuario
		$this->Usuario = new cField('servidor_escolar', 'servidor_escolar', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "dato_establecimiento") {
			if ($this->Cue->getSessionValue() <> "")
				$sMasterFilter .= "`Cue`=" . ew_QuotedValue($this->Cue->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "dato_establecimiento") {
			if ($this->Cue->getSessionValue() <> "")
				$sDetailFilter .= "`Cue`=" . ew_QuotedValue($this->Cue->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_dato_establecimiento() {
		return "`Cue`='@Cue@'";
	}

	// Detail filter
	function SqlDetailFilter_dato_establecimiento() {
		return "`Cue`='@Cue@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`servidor_escolar`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Cue', $rs))
				ew_AddFilter($where, ew_QuotedName('Cue', $this->DBID) . '=' . ew_QuotedValue($rs['Cue'], $this->Cue->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Cue` = '@Cue@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "servidor_escolarlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "servidor_escolarlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("servidor_escolarview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("servidor_escolarview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "servidor_escolaradd.php?" . $this->UrlParm($parm);
		else
			$url = "servidor_escolaradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("servidor_escolaredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("servidor_escolaradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("servidor_escolardelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "dato_establecimiento" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Cue=" . urlencode($this->Cue->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Cue:" . ew_VarToJson($this->Cue->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Cue->CurrentValue)) {
			$sUrl .= "Cue=" . urlencode($this->Cue->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Cue"]))
				$arKeys[] = ew_StripSlashes($_POST["Cue"]);
			elseif (isset($_GET["Cue"]))
				$arKeys[] = ew_StripSlashes($_GET["Cue"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Cue->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->Nro_Serie->setDbValue($rs->fields('Nro_Serie'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Cant_Net_Asoc->setDbValue($rs->fields('Cant_Net_Asoc'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_SO->setDbValue($rs->fields('Id_SO'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->User_Server->setDbValue($rs->fields('User_Server'));
		$this->Pass_Server->setDbValue($rs->fields('Pass_Server'));
		$this->User_TdServer->setDbValue($rs->fields('User_TdServer'));
		$this->Pass_TdServer->setDbValue($rs->fields('Pass_TdServer'));
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Nro_Serie
		// SN
		// Cant_Net_Asoc
		// Id_Marca
		// Id_Modelo
		// Id_SO
		// Id_Estado
		// User_Server
		// Pass_Server
		// User_TdServer
		// Pass_TdServer
		// Cue
		// Fecha_Actualizacion
		// Usuario
		// Nro_Serie

		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->ViewValue = $this->Cant_Net_Asoc->CurrentValue;
		$this->Cant_Net_Asoc->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Marca->ViewValue = $this->Id_Marca->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Marca->ViewValue = $this->Id_Marca->CurrentValue;
			}
		} else {
			$this->Id_Marca->ViewValue = NULL;
		}
		$this->Id_Marca->ViewCustomAttributes = "";

		// Id_Modelo
		if (strval($this->Id_Modelo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
		$sWhereWrk = "";
		$this->Id_Modelo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->CurrentValue;
			}
		} else {
			$this->Id_Modelo->ViewValue = NULL;
		}
		$this->Id_Modelo->ViewCustomAttributes = "";

		// Id_SO
		if (strval($this->Id_SO->CurrentValue) <> "") {
			$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
		$sWhereWrk = "";
		$this->Id_SO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_SO->ViewValue = $this->Id_SO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_SO->ViewValue = $this->Id_SO->CurrentValue;
			}
		} else {
			$this->Id_SO->ViewValue = NULL;
		}
		$this->Id_SO->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado->ViewValue = $this->Id_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// User_Server
		$this->User_Server->ViewValue = $this->User_Server->CurrentValue;
		$this->User_Server->ViewCustomAttributes = "";

		// Pass_Server
		$this->Pass_Server->ViewValue = $this->Pass_Server->CurrentValue;
		$this->Pass_Server->ViewCustomAttributes = "";

		// User_TdServer
		$this->User_TdServer->ViewValue = $this->User_TdServer->CurrentValue;
		$this->User_TdServer->ViewCustomAttributes = "";

		// Pass_TdServer
		$this->Pass_TdServer->ViewValue = $this->Pass_TdServer->CurrentValue;
		$this->Pass_TdServer->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Nro_Serie
		$this->Nro_Serie->LinkCustomAttributes = "";
		$this->Nro_Serie->HrefValue = "";
		$this->Nro_Serie->TooltipValue = "";

		// SN
		$this->SN->LinkCustomAttributes = "";
		$this->SN->HrefValue = "";
		$this->SN->TooltipValue = "";

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->LinkCustomAttributes = "";
		$this->Cant_Net_Asoc->HrefValue = "";
		$this->Cant_Net_Asoc->TooltipValue = "";

		// Id_Marca
		$this->Id_Marca->LinkCustomAttributes = "";
		$this->Id_Marca->HrefValue = "";
		$this->Id_Marca->TooltipValue = "";

		// Id_Modelo
		$this->Id_Modelo->LinkCustomAttributes = "";
		$this->Id_Modelo->HrefValue = "";
		$this->Id_Modelo->TooltipValue = "";

		// Id_SO
		$this->Id_SO->LinkCustomAttributes = "";
		$this->Id_SO->HrefValue = "";
		$this->Id_SO->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// User_Server
		$this->User_Server->LinkCustomAttributes = "";
		$this->User_Server->HrefValue = "";
		$this->User_Server->TooltipValue = "";

		// Pass_Server
		$this->Pass_Server->LinkCustomAttributes = "";
		$this->Pass_Server->HrefValue = "";
		$this->Pass_Server->TooltipValue = "";

		// User_TdServer
		$this->User_TdServer->LinkCustomAttributes = "";
		$this->User_TdServer->HrefValue = "";
		$this->User_TdServer->TooltipValue = "";

		// Pass_TdServer
		$this->Pass_TdServer->LinkCustomAttributes = "";
		$this->Pass_TdServer->HrefValue = "";
		$this->Pass_TdServer->TooltipValue = "";

		// Cue
		$this->Cue->LinkCustomAttributes = "";
		$this->Cue->HrefValue = "";
		$this->Cue->TooltipValue = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->LinkCustomAttributes = "";
		$this->Fecha_Actualizacion->HrefValue = "";
		$this->Fecha_Actualizacion->TooltipValue = "";

		// Usuario
		$this->Usuario->LinkCustomAttributes = "";
		$this->Usuario->HrefValue = "";
		$this->Usuario->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Nro_Serie
		$this->Nro_Serie->EditAttrs["class"] = "form-control";
		$this->Nro_Serie->EditCustomAttributes = "";
		$this->Nro_Serie->EditValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->PlaceHolder = ew_RemoveHtml($this->Nro_Serie->FldCaption());

		// SN
		$this->SN->EditAttrs["class"] = "form-control";
		$this->SN->EditCustomAttributes = "";
		$this->SN->EditValue = $this->SN->CurrentValue;
		$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->EditAttrs["class"] = "form-control";
		$this->Cant_Net_Asoc->EditCustomAttributes = "";
		$this->Cant_Net_Asoc->EditValue = $this->Cant_Net_Asoc->CurrentValue;
		$this->Cant_Net_Asoc->PlaceHolder = ew_RemoveHtml($this->Cant_Net_Asoc->FldCaption());

		// Id_Marca
		$this->Id_Marca->EditAttrs["class"] = "form-control";
		$this->Id_Marca->EditCustomAttributes = "";

		// Id_Modelo
		$this->Id_Modelo->EditAttrs["class"] = "form-control";
		$this->Id_Modelo->EditCustomAttributes = "";

		// Id_SO
		$this->Id_SO->EditAttrs["class"] = "form-control";
		$this->Id_SO->EditCustomAttributes = "";

		// Id_Estado
		$this->Id_Estado->EditAttrs["class"] = "form-control";
		$this->Id_Estado->EditCustomAttributes = "";

		// User_Server
		$this->User_Server->EditAttrs["class"] = "form-control";
		$this->User_Server->EditCustomAttributes = "";
		$this->User_Server->EditValue = $this->User_Server->CurrentValue;
		$this->User_Server->PlaceHolder = ew_RemoveHtml($this->User_Server->FldCaption());

		// Pass_Server
		$this->Pass_Server->EditAttrs["class"] = "form-control";
		$this->Pass_Server->EditCustomAttributes = "";
		$this->Pass_Server->EditValue = $this->Pass_Server->CurrentValue;
		$this->Pass_Server->PlaceHolder = ew_RemoveHtml($this->Pass_Server->FldCaption());

		// User_TdServer
		$this->User_TdServer->EditAttrs["class"] = "form-control";
		$this->User_TdServer->EditCustomAttributes = "";
		$this->User_TdServer->EditValue = $this->User_TdServer->CurrentValue;
		$this->User_TdServer->PlaceHolder = ew_RemoveHtml($this->User_TdServer->FldCaption());

		// Pass_TdServer
		$this->Pass_TdServer->EditAttrs["class"] = "form-control";
		$this->Pass_TdServer->EditCustomAttributes = "";
		$this->Pass_TdServer->EditValue = $this->Pass_TdServer->CurrentValue;
		$this->Pass_TdServer->PlaceHolder = ew_RemoveHtml($this->Pass_TdServer->FldCaption());

		// Cue
		$this->Cue->EditAttrs["class"] = "form-control";
		$this->Cue->EditCustomAttributes = "";
		if ($this->Cue->getSessionValue() <> "") {
			$this->Cue->CurrentValue = $this->Cue->getSessionValue();
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";
		} else {
		}

		// Fecha_Actualizacion
		// Usuario
		// Call Row Rendered event

		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Nro_Serie->Exportable) $Doc->ExportCaption($this->Nro_Serie);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Cant_Net_Asoc->Exportable) $Doc->ExportCaption($this->Cant_Net_Asoc);
					if ($this->Id_Marca->Exportable) $Doc->ExportCaption($this->Id_Marca);
					if ($this->Id_Modelo->Exportable) $Doc->ExportCaption($this->Id_Modelo);
					if ($this->Id_SO->Exportable) $Doc->ExportCaption($this->Id_SO);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->User_Server->Exportable) $Doc->ExportCaption($this->User_Server);
					if ($this->Pass_Server->Exportable) $Doc->ExportCaption($this->Pass_Server);
					if ($this->User_TdServer->Exportable) $Doc->ExportCaption($this->User_TdServer);
					if ($this->Pass_TdServer->Exportable) $Doc->ExportCaption($this->Pass_TdServer);
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
				} else {
					if ($this->Nro_Serie->Exportable) $Doc->ExportCaption($this->Nro_Serie);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Cant_Net_Asoc->Exportable) $Doc->ExportCaption($this->Cant_Net_Asoc);
					if ($this->Id_Marca->Exportable) $Doc->ExportCaption($this->Id_Marca);
					if ($this->Id_Modelo->Exportable) $Doc->ExportCaption($this->Id_Modelo);
					if ($this->Id_SO->Exportable) $Doc->ExportCaption($this->Id_SO);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->User_Server->Exportable) $Doc->ExportCaption($this->User_Server);
					if ($this->Pass_Server->Exportable) $Doc->ExportCaption($this->Pass_Server);
					if ($this->User_TdServer->Exportable) $Doc->ExportCaption($this->User_TdServer);
					if ($this->Pass_TdServer->Exportable) $Doc->ExportCaption($this->Pass_TdServer);
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Nro_Serie->Exportable) $Doc->ExportField($this->Nro_Serie);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Cant_Net_Asoc->Exportable) $Doc->ExportField($this->Cant_Net_Asoc);
						if ($this->Id_Marca->Exportable) $Doc->ExportField($this->Id_Marca);
						if ($this->Id_Modelo->Exportable) $Doc->ExportField($this->Id_Modelo);
						if ($this->Id_SO->Exportable) $Doc->ExportField($this->Id_SO);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->User_Server->Exportable) $Doc->ExportField($this->User_Server);
						if ($this->Pass_Server->Exportable) $Doc->ExportField($this->Pass_Server);
						if ($this->User_TdServer->Exportable) $Doc->ExportField($this->User_TdServer);
						if ($this->Pass_TdServer->Exportable) $Doc->ExportField($this->Pass_TdServer);
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
					} else {
						if ($this->Nro_Serie->Exportable) $Doc->ExportField($this->Nro_Serie);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Cant_Net_Asoc->Exportable) $Doc->ExportField($this->Cant_Net_Asoc);
						if ($this->Id_Marca->Exportable) $Doc->ExportField($this->Id_Marca);
						if ($this->Id_Modelo->Exportable) $Doc->ExportField($this->Id_Modelo);
						if ($this->Id_SO->Exportable) $Doc->ExportField($this->Id_SO);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->User_Server->Exportable) $Doc->ExportField($this->User_Server);
						if ($this->Pass_Server->Exportable) $Doc->ExportField($this->Pass_Server);
						if ($this->User_TdServer->Exportable) $Doc->ExportField($this->User_TdServer);
						if ($this->Pass_TdServer->Exportable) $Doc->ExportField($this->Pass_TdServer);
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
