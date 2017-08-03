<?php

// Global variable for table object
$atencion_para_st = NULL;

//
// Table class for atencion_para_st
//
class catencion_para_st extends cTable {
	var $Nro_Tiket;
	var $Id_Tipo_Retiro;
	var $Fecha_Retiro;
	var $Observacion;
	var $Fecha_Devolucion;
	var $Id_Atencion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'atencion_para_st';
		$this->TableName = 'atencion_para_st';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`atencion_para_st`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Nro_Tiket
		$this->Nro_Tiket = new cField('atencion_para_st', 'atencion_para_st', 'x_Nro_Tiket', 'Nro_Tiket', '`Nro_Tiket`', '`Nro_Tiket`', 3, -1, FALSE, '`Nro_Tiket`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Tiket->Sortable = TRUE; // Allow sort
		$this->Nro_Tiket->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Nro_Tiket'] = &$this->Nro_Tiket;

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro = new cField('atencion_para_st', 'atencion_para_st', 'x_Id_Tipo_Retiro', 'Id_Tipo_Retiro', '`Id_Tipo_Retiro`', '`Id_Tipo_Retiro`', 3, -1, FALSE, '`Id_Tipo_Retiro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Retiro->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Retiro->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Retiro->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Tipo_Retiro->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tipo_Retiro'] = &$this->Id_Tipo_Retiro;

		// Fecha_Retiro
		$this->Fecha_Retiro = new cField('atencion_para_st', 'atencion_para_st', 'x_Fecha_Retiro', 'Fecha_Retiro', '`Fecha_Retiro`', '`Fecha_Retiro`', 200, 7, FALSE, '`Fecha_Retiro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Retiro->Sortable = TRUE; // Allow sort
		$this->Fecha_Retiro->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Retiro'] = &$this->Fecha_Retiro;

		// Observacion
		$this->Observacion = new cField('atencion_para_st', 'atencion_para_st', 'x_Observacion', 'Observacion', '`Observacion`', '`Observacion`', 201, -1, FALSE, '`Observacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Observacion->Sortable = TRUE; // Allow sort
		$this->fields['Observacion'] = &$this->Observacion;

		// Fecha_Devolucion
		$this->Fecha_Devolucion = new cField('atencion_para_st', 'atencion_para_st', 'x_Fecha_Devolucion', 'Fecha_Devolucion', '`Fecha_Devolucion`', '`Fecha_Devolucion`', 200, 7, FALSE, '`Fecha_Devolucion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Devolucion->Sortable = TRUE; // Allow sort
		$this->Fecha_Devolucion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Devolucion'] = &$this->Fecha_Devolucion;

		// Id_Atencion
		$this->Id_Atencion = new cField('atencion_para_st', 'atencion_para_st', 'x_Id_Atencion', 'Id_Atencion', '`Id_Atencion`', '`Id_Atencion`', 3, -1, FALSE, '`Id_Atencion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Id_Atencion->Sortable = TRUE; // Allow sort
		$this->Id_Atencion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Atencion'] = &$this->Id_Atencion;
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
		if ($this->getCurrentMasterTable() == "atencion_equipos") {
			if ($this->Id_Atencion->getSessionValue() <> "")
				$sMasterFilter .= "`Id_Atencion`=" . ew_QuotedValue($this->Id_Atencion->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "atencion_equipos") {
			if ($this->Id_Atencion->getSessionValue() <> "")
				$sDetailFilter .= "`Id_Atencion`=" . ew_QuotedValue($this->Id_Atencion->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_atencion_equipos() {
		return "`Id_Atencion`=@Id_Atencion@";
	}

	// Detail filter
	function SqlDetailFilter_atencion_equipos() {
		return "`Id_Atencion`=@Id_Atencion@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`atencion_para_st`";
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
			if (array_key_exists('Id_Atencion', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Atencion', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Atencion'], $this->Id_Atencion->FldDataType, $this->DBID));
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
		return "`Id_Atencion` = @Id_Atencion@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Atencion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "atencion_para_stlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "atencion_para_stlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("atencion_para_stview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("atencion_para_stview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "atencion_para_stadd.php?" . $this->UrlParm($parm);
		else
			$url = "atencion_para_stadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("atencion_para_stedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("atencion_para_stadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("atencion_para_stdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "atencion_equipos" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Atencion:" . ew_VarToJson($this->Id_Atencion->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Atencion->CurrentValue)) {
			$sUrl .= "Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
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
			if ($isPost && isset($_POST["Id_Atencion"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Atencion"]);
			elseif (isset($_GET["Id_Atencion"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Atencion"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
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
			$this->Id_Atencion->CurrentValue = $key;
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
		$this->Nro_Tiket->setDbValue($rs->fields('Nro_Tiket'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
		$this->Fecha_Retiro->setDbValue($rs->fields('Fecha_Retiro'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Devolucion->setDbValue($rs->fields('Fecha_Devolucion'));
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Nro_Tiket
		// Id_Tipo_Retiro
		// Fecha_Retiro
		// Observacion
		// Fecha_Devolucion
		// Id_Atencion
		// Nro_Tiket

		$this->Nro_Tiket->ViewValue = $this->Nro_Tiket->CurrentValue;
		$this->Nro_Tiket->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Retiro->ViewValue = NULL;
		}
		$this->Id_Tipo_Retiro->ViewCustomAttributes = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->ViewValue = $this->Fecha_Retiro->CurrentValue;
		$this->Fecha_Retiro->ViewValue = ew_FormatDateTime($this->Fecha_Retiro->ViewValue, 7);
		$this->Fecha_Retiro->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->ViewValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->ViewValue = ew_FormatDateTime($this->Fecha_Devolucion->ViewValue, 7);
		$this->Fecha_Devolucion->ViewCustomAttributes = "";

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// Nro_Tiket
		$this->Nro_Tiket->LinkCustomAttributes = "";
		$this->Nro_Tiket->HrefValue = "";
		$this->Nro_Tiket->TooltipValue = "";

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
		$this->Id_Tipo_Retiro->HrefValue = "";
		$this->Id_Tipo_Retiro->TooltipValue = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->LinkCustomAttributes = "";
		$this->Fecha_Retiro->HrefValue = "";
		$this->Fecha_Retiro->TooltipValue = "";

		// Observacion
		$this->Observacion->LinkCustomAttributes = "";
		$this->Observacion->HrefValue = "";
		$this->Observacion->TooltipValue = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->LinkCustomAttributes = "";
		$this->Fecha_Devolucion->HrefValue = "";
		$this->Fecha_Devolucion->TooltipValue = "";

		// Id_Atencion
		$this->Id_Atencion->LinkCustomAttributes = "";
		$this->Id_Atencion->HrefValue = "";
		$this->Id_Atencion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Nro_Tiket
		$this->Nro_Tiket->EditAttrs["class"] = "form-control";
		$this->Nro_Tiket->EditCustomAttributes = "";
		$this->Nro_Tiket->EditValue = $this->Nro_Tiket->CurrentValue;
		$this->Nro_Tiket->PlaceHolder = ew_RemoveHtml($this->Nro_Tiket->FldCaption());

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Retiro->EditCustomAttributes = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
		$this->Fecha_Retiro->EditCustomAttributes = "";
		$this->Fecha_Retiro->EditValue = $this->Fecha_Retiro->CurrentValue;
		$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

		// Observacion
		$this->Observacion->EditAttrs["class"] = "form-control";
		$this->Observacion->EditCustomAttributes = "";
		$this->Observacion->EditValue = $this->Observacion->CurrentValue;
		$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

		// Fecha_Devolucion
		$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
		$this->Fecha_Devolucion->EditCustomAttributes = "";
		$this->Fecha_Devolucion->EditValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

		// Id_Atencion
		$this->Id_Atencion->EditAttrs["class"] = "form-control";
		$this->Id_Atencion->EditCustomAttributes = "";
		if ($this->Id_Atencion->getSessionValue() <> "") {
			$this->Id_Atencion->CurrentValue = $this->Id_Atencion->getSessionValue();
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";
		} else {
		}

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
					if ($this->Nro_Tiket->Exportable) $Doc->ExportCaption($this->Nro_Tiket);
					if ($this->Id_Tipo_Retiro->Exportable) $Doc->ExportCaption($this->Id_Tipo_Retiro);
					if ($this->Fecha_Retiro->Exportable) $Doc->ExportCaption($this->Fecha_Retiro);
					if ($this->Observacion->Exportable) $Doc->ExportCaption($this->Observacion);
					if ($this->Fecha_Devolucion->Exportable) $Doc->ExportCaption($this->Fecha_Devolucion);
				} else {
					if ($this->Nro_Tiket->Exportable) $Doc->ExportCaption($this->Nro_Tiket);
					if ($this->Id_Tipo_Retiro->Exportable) $Doc->ExportCaption($this->Id_Tipo_Retiro);
					if ($this->Fecha_Retiro->Exportable) $Doc->ExportCaption($this->Fecha_Retiro);
					if ($this->Fecha_Devolucion->Exportable) $Doc->ExportCaption($this->Fecha_Devolucion);
					if ($this->Id_Atencion->Exportable) $Doc->ExportCaption($this->Id_Atencion);
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
						if ($this->Nro_Tiket->Exportable) $Doc->ExportField($this->Nro_Tiket);
						if ($this->Id_Tipo_Retiro->Exportable) $Doc->ExportField($this->Id_Tipo_Retiro);
						if ($this->Fecha_Retiro->Exportable) $Doc->ExportField($this->Fecha_Retiro);
						if ($this->Observacion->Exportable) $Doc->ExportField($this->Observacion);
						if ($this->Fecha_Devolucion->Exportable) $Doc->ExportField($this->Fecha_Devolucion);
					} else {
						if ($this->Nro_Tiket->Exportable) $Doc->ExportField($this->Nro_Tiket);
						if ($this->Id_Tipo_Retiro->Exportable) $Doc->ExportField($this->Id_Tipo_Retiro);
						if ($this->Fecha_Retiro->Exportable) $Doc->ExportField($this->Fecha_Retiro);
						if ($this->Fecha_Devolucion->Exportable) $Doc->ExportField($this->Fecha_Devolucion);
						if ($this->Id_Atencion->Exportable) $Doc->ExportField($this->Id_Atencion);
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
