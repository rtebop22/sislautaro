<?php

// Global variable for table object
$detalle_atencion = NULL;

//
// Table class for detalle_atencion
//
class cdetalle_atencion extends cTable {
	var $Id_Atencion;
	var $NroSerie;
	var $Id_Detalle_Atencion;
	var $Id_Tipo_Falla;
	var $Id_Problema;
	var $Descripcion_Problema;
	var $Id_Tipo_Sol_Problem;
	var $Id_Estado_Atenc;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'detalle_atencion';
		$this->TableName = 'detalle_atencion';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`detalle_atencion`";
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

		// Id_Atencion
		$this->Id_Atencion = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Atencion', 'Id_Atencion', '`Id_Atencion`', '`Id_Atencion`', 3, -1, FALSE, '`Id_Atencion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Id_Atencion->Sortable = TRUE; // Allow sort
		$this->Id_Atencion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Atencion'] = &$this->Id_Atencion;

		// NroSerie
		$this->NroSerie = new cField('detalle_atencion', 'detalle_atencion', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Detalle_Atencion', 'Id_Detalle_Atencion', '`Id_Detalle_Atencion`', '`Id_Detalle_Atencion`', 3, -1, FALSE, '`Id_Detalle_Atencion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Id_Detalle_Atencion->Sortable = TRUE; // Allow sort
		$this->Id_Detalle_Atencion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Detalle_Atencion'] = &$this->Id_Detalle_Atencion;

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Tipo_Falla', 'Id_Tipo_Falla', '`Id_Tipo_Falla`', '`Id_Tipo_Falla`', 3, -1, FALSE, '`Id_Tipo_Falla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Falla->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Falla->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Falla->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Tipo_Falla'] = &$this->Id_Tipo_Falla;

		// Id_Problema
		$this->Id_Problema = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Problema', 'Id_Problema', '`Id_Problema`', '`Id_Problema`', 3, -1, FALSE, '`Id_Problema`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Problema->Sortable = TRUE; // Allow sort
		$this->Id_Problema->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Problema->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Problema->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Problema'] = &$this->Id_Problema;

		// Descripcion_Problema
		$this->Descripcion_Problema = new cField('detalle_atencion', 'detalle_atencion', 'x_Descripcion_Problema', 'Descripcion_Problema', '`Descripcion_Problema`', '`Descripcion_Problema`', 201, -1, FALSE, '`Descripcion_Problema`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Descripcion_Problema->Sortable = TRUE; // Allow sort
		$this->fields['Descripcion_Problema'] = &$this->Descripcion_Problema;

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Tipo_Sol_Problem', 'Id_Tipo_Sol_Problem', '`Id_Tipo_Sol_Problem`', '`Id_Tipo_Sol_Problem`', 3, -1, FALSE, '`Id_Tipo_Sol_Problem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Sol_Problem->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Sol_Problem->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Sol_Problem->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Tipo_Sol_Problem'] = &$this->Id_Tipo_Sol_Problem;

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc = new cField('detalle_atencion', 'detalle_atencion', 'x_Id_Estado_Atenc', 'Id_Estado_Atenc', '`Id_Estado_Atenc`', '`Id_Estado_Atenc`', 3, -1, FALSE, '`Id_Estado_Atenc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Atenc->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Atenc->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Atenc->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Estado_Atenc'] = &$this->Id_Estado_Atenc;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('detalle_atencion', 'detalle_atencion', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;
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
			if ($this->NroSerie->getSessionValue() <> "")
				$sMasterFilter .= " AND `NroSerie`=" . ew_QuotedValue($this->NroSerie->getSessionValue(), EW_DATATYPE_STRING, "DB");
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
			if ($this->NroSerie->getSessionValue() <> "")
				$sDetailFilter .= " AND `NroSerie`=" . ew_QuotedValue($this->NroSerie->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_atencion_equipos() {
		return "`Id_Atencion`=@Id_Atencion@ AND `NroSerie`='@NroSerie@'";
	}

	// Detail filter
	function SqlDetailFilter_atencion_equipos() {
		return "`Id_Atencion`=@Id_Atencion@ AND `NroSerie`='@NroSerie@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`detalle_atencion`";
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
			if (array_key_exists('NroSerie', $rs))
				ew_AddFilter($where, ew_QuotedName('NroSerie', $this->DBID) . '=' . ew_QuotedValue($rs['NroSerie'], $this->NroSerie->FldDataType, $this->DBID));
			if (array_key_exists('Id_Detalle_Atencion', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Detalle_Atencion', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Detalle_Atencion'], $this->Id_Detalle_Atencion->FldDataType, $this->DBID));
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
		return "`Id_Atencion` = @Id_Atencion@ AND `NroSerie` = '@NroSerie@' AND `Id_Detalle_Atencion` = @Id_Detalle_Atencion@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Atencion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->Id_Detalle_Atencion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Detalle_Atencion@", ew_AdjustSql($this->Id_Detalle_Atencion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "detalle_atencionlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "detalle_atencionlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("detalle_atencionview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("detalle_atencionview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "detalle_atencionadd.php?" . $this->UrlParm($parm);
		else
			$url = "detalle_atencionadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("detalle_atencionedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("detalle_atencionadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("detalle_atenciondelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "atencion_equipos" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
			$url .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Atencion:" . ew_VarToJson($this->Id_Atencion->CurrentValue, "number", "'");
		$json .= ",NroSerie:" . ew_VarToJson($this->NroSerie->CurrentValue, "string", "'");
		$json .= ",Id_Detalle_Atencion:" . ew_VarToJson($this->Id_Detalle_Atencion->CurrentValue, "number", "'");
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
		if (!is_null($this->NroSerie->CurrentValue)) {
			$sUrl .= "&NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Id_Detalle_Atencion->CurrentValue)) {
			$sUrl .= "&Id_Detalle_Atencion=" . urlencode($this->Id_Detalle_Atencion->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Id_Atencion"]))
				$arKey[] = ew_StripSlashes($_POST["Id_Atencion"]);
			elseif (isset($_GET["Id_Atencion"]))
				$arKey[] = ew_StripSlashes($_GET["Id_Atencion"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["NroSerie"]))
				$arKey[] = ew_StripSlashes($_POST["NroSerie"]);
			elseif (isset($_GET["NroSerie"]))
				$arKey[] = ew_StripSlashes($_GET["NroSerie"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["Id_Detalle_Atencion"]))
				$arKey[] = ew_StripSlashes($_POST["Id_Detalle_Atencion"]);
			elseif (isset($_GET["Id_Detalle_Atencion"]))
				$arKey[] = ew_StripSlashes($_GET["Id_Detalle_Atencion"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 3)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // Id_Atencion
					continue;
				if (!is_numeric($key[2])) // Id_Detalle_Atencion
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
			$this->Id_Atencion->CurrentValue = $key[0];
			$this->NroSerie->CurrentValue = $key[1];
			$this->Id_Detalle_Atencion->CurrentValue = $key[2];
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
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Id_Detalle_Atencion->setDbValue($rs->fields('Id_Detalle_Atencion'));
		$this->Id_Tipo_Falla->setDbValue($rs->fields('Id_Tipo_Falla'));
		$this->Id_Problema->setDbValue($rs->fields('Id_Problema'));
		$this->Descripcion_Problema->setDbValue($rs->fields('Descripcion_Problema'));
		$this->Id_Tipo_Sol_Problem->setDbValue($rs->fields('Id_Tipo_Sol_Problem'));
		$this->Id_Estado_Atenc->setDbValue($rs->fields('Id_Estado_Atenc'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Atencion
		// NroSerie
		// Id_Detalle_Atencion
		// Id_Tipo_Falla
		// Id_Problema
		// Descripcion_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Fecha_Actualizacion
		// Id_Atencion

		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->ViewValue = $this->Id_Detalle_Atencion->CurrentValue;
		$this->Id_Detalle_Atencion->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		if (strval($this->Id_Tipo_Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Id_Tipo_Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Falla->ViewValue = NULL;
		}
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		if (strval($this->Id_Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Id_Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Problema->ViewValue = $this->Id_Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
			}
		} else {
			$this->Id_Problema->ViewValue = NULL;
		}
		$this->Id_Problema->ViewCustomAttributes = "";

		// Descripcion_Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		if (strval($this->Id_Tipo_Sol_Problem->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Tipo_Sol_Problem->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Sol_Problem->ViewValue = NULL;
		}
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		if (strval($this->Id_Estado_Atenc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Estado_Atenc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Atenc->ViewValue = NULL;
		}
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Atencion
		$this->Id_Atencion->LinkCustomAttributes = "";
		$this->Id_Atencion->HrefValue = "";
		$this->Id_Atencion->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->LinkCustomAttributes = "";
		$this->Id_Detalle_Atencion->HrefValue = "";
		$this->Id_Detalle_Atencion->TooltipValue = "";

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->LinkCustomAttributes = "";
		$this->Id_Tipo_Falla->HrefValue = "";
		$this->Id_Tipo_Falla->TooltipValue = "";

		// Id_Problema
		$this->Id_Problema->LinkCustomAttributes = "";
		$this->Id_Problema->HrefValue = "";
		$this->Id_Problema->TooltipValue = "";

		// Descripcion_Problema
		$this->Descripcion_Problema->LinkCustomAttributes = "";
		$this->Descripcion_Problema->HrefValue = "";
		$this->Descripcion_Problema->TooltipValue = "";

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
		$this->Id_Tipo_Sol_Problem->HrefValue = "";
		$this->Id_Tipo_Sol_Problem->TooltipValue = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->LinkCustomAttributes = "";
		$this->Id_Estado_Atenc->HrefValue = "";
		$this->Id_Estado_Atenc->TooltipValue = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->LinkCustomAttributes = "";
		$this->Fecha_Actualizacion->HrefValue = "";
		$this->Fecha_Actualizacion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Atencion
		$this->Id_Atencion->EditAttrs["class"] = "form-control";
		$this->Id_Atencion->EditCustomAttributes = "";
		if ($this->Id_Atencion->getSessionValue() <> "") {
			$this->Id_Atencion->CurrentValue = $this->Id_Atencion->getSessionValue();
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";
		} else {
		}

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		if ($this->NroSerie->getSessionValue() <> "") {
			$this->NroSerie->CurrentValue = $this->NroSerie->getSessionValue();
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";
		} else {
		}

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->EditAttrs["class"] = "form-control";
		$this->Id_Detalle_Atencion->EditCustomAttributes = "";

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Falla->EditCustomAttributes = "";

		// Id_Problema
		$this->Id_Problema->EditAttrs["class"] = "form-control";
		$this->Id_Problema->EditCustomAttributes = "";

		// Descripcion_Problema
		$this->Descripcion_Problema->EditAttrs["class"] = "form-control";
		$this->Descripcion_Problema->EditCustomAttributes = "";
		$this->Descripcion_Problema->EditValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->PlaceHolder = ew_RemoveHtml($this->Descripcion_Problema->FldCaption());

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Sol_Problem->EditCustomAttributes = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Atenc->EditCustomAttributes = "";

		// Fecha_Actualizacion
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
					if ($this->Id_Atencion->Exportable) $Doc->ExportCaption($this->Id_Atencion);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportCaption($this->Id_Tipo_Falla);
					if ($this->Id_Problema->Exportable) $Doc->ExportCaption($this->Id_Problema);
					if ($this->Descripcion_Problema->Exportable) $Doc->ExportCaption($this->Descripcion_Problema);
					if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportCaption($this->Id_Tipo_Sol_Problem);
					if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportCaption($this->Id_Estado_Atenc);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->Id_Atencion->Exportable) $Doc->ExportCaption($this->Id_Atencion);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Id_Detalle_Atencion->Exportable) $Doc->ExportCaption($this->Id_Detalle_Atencion);
					if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportCaption($this->Id_Tipo_Falla);
					if ($this->Id_Problema->Exportable) $Doc->ExportCaption($this->Id_Problema);
					if ($this->Descripcion_Problema->Exportable) $Doc->ExportCaption($this->Descripcion_Problema);
					if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportCaption($this->Id_Tipo_Sol_Problem);
					if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportCaption($this->Id_Estado_Atenc);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
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
						if ($this->Id_Atencion->Exportable) $Doc->ExportField($this->Id_Atencion);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportField($this->Id_Tipo_Falla);
						if ($this->Id_Problema->Exportable) $Doc->ExportField($this->Id_Problema);
						if ($this->Descripcion_Problema->Exportable) $Doc->ExportField($this->Descripcion_Problema);
						if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportField($this->Id_Tipo_Sol_Problem);
						if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportField($this->Id_Estado_Atenc);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->Id_Atencion->Exportable) $Doc->ExportField($this->Id_Atencion);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Id_Detalle_Atencion->Exportable) $Doc->ExportField($this->Id_Detalle_Atencion);
						if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportField($this->Id_Tipo_Falla);
						if ($this->Id_Problema->Exportable) $Doc->ExportField($this->Id_Problema);
						if ($this->Descripcion_Problema->Exportable) $Doc->ExportField($this->Descripcion_Problema);
						if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportField($this->Id_Tipo_Sol_Problem);
						if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportField($this->Id_Estado_Atenc);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
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

	$Id_Atencion=$rsnew["Id_Atencion"];
	$Estado=$rsnew["Id_Estado_Atenc"];
	$Serie=$rsnew["NroSerie"];
	$usuario=CurrentUserName();
	$Fecha=ew_CurrentDate();
	$Observacion=$rsnew["Descripcion_Problema"];
	if ($Estado==1){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=2, Id_Sit_Estado=2, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando retiro para Servicio Técnico', '$Fecha' ,'$Serie')");
	$Consulta3 = ew_Execute("INSERT INTO Atencion_Para_St (Id_Atencion, NroSerie, Id_Tipo_Retiro, Nro_Tiket) VALUES ($Id_Atencion,'$Serie', 1 ,'PENDIENTE')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando retiro P/Servicio Tecnico', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==2){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=2, Id_Sit_Estado=2, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra en Servicio Tecnico Externo', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Servicio Tecnico Externo', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==3){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra REPARADO, Esperando el retiro por el titular', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Solucionado, Esperando retiro del Titular', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==4){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra en Espera de Reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En espera de solución', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==5){
	$sql = ew_ExecuteRow("SELECT NroMac FROM Equipos WHERE NroSerie='$Serie'");
	$SN="EE183CE07CFBD86BF819";
	$Id_Hardware=$sql["NroMac"];
	$Tipo_Paquete=1;
	if ($Id_Hardware==""){
	$Id_Hardware="PENDIENTE";
	}
	$Marca_Arranque="PENDIENTE";
	$consultaServer = ew_ExecuteRow("SELECT Nro_Serie FROM Servidor_Escolar Limit 1");
	$Nro_Serie=$consultaServer["Nro_Serie"];
	$consultaRte = ew_ExecuteRow("SELECT Mail, DniRte, Apellido_Nombre FROM Referente_Tecnico Limit 1");
	$mail=$consultaRte["Mail"];
	$DniRte=$consultaRte["DniRte"];
	$Apellido_Nombre=$consultaRte["Apellido_Nombre"];
	$CargaPaquete = ew_Execute("INSERT INTO Paquetes_Provision (Fecha_Actualizacion, Usuario, SN, Id_Hardware, Marca_Arranque, Id_Tipo_Extraccion, Email_Solicitante, Id_Estado_Paquete, Id_Motivo, Serie_Netbook, Dni, Apellido_Nombre_Solicitante, Id_Tipo_Paquete, Serie_Server) VALUES ('$Fecha' ,'$usuario','$SN','$Id_Hardware', '$Marca_Arranque',1,'$mail',1,1,'$Serie',$DniRte, '$Apellido_Nombre', $Tipo_Paquete, '$Nro_Serie')");
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando Paquete de Provisión', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando Paquete de Provisión', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==6){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando un cargador por falla o perdida', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando Cargador/Batería', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==7){
	$sql = ew_ExecuteRow("SELECT Dni FROM Personas WHERE NroSerie='$Serie'");
	$Dni=$sql["Dni"];
	$Sql2 = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Dni=$Dni");
	$Prestamo=$Sql2["Id_Estado_Prestamo"];
	if ($Prestamo==1){
	echo '<script language="javascript">alert("EL ALUMNO ACTUAL POSEE UN PRESTAMO EN CURSO, VERIFIQUE LOS PRESTAMOS ACTIVOS ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo fue retirado funcionando por el titular, finalizó la atención', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Retirado por el Titular', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	$EstadoAnterior=$rsold["Id_Estado_Atenc"];
	if ($EstadoAnterior==5){
	$ActPaquete = ew_Execute("UPDATE Paquetes_Provision SET Id_Estado_Paquete=4, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Serie_Netbook='$Serie'");
	}
	return TRUE;
	}
	}elseif ($Estado==8){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('Equipo en reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Reparación', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return ;
	}else{
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('Equipo en reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Reparación', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {
	$Id_Atencion=$rsold["Id_Atencion"];
	$Estado=$rsnew["Id_Estado_Atenc"];
	$Serie=$rsold["NroSerie"];
	$usuario=CurrentUserName();
	$Fecha=ew_CurrentDate();
	$Observacion=$rsnew["Descripcion_Problema"];
	if ($Estado==1){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=2, Id_Sit_Estado=2, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando retiro para Servicio Técnico', '$Fecha' ,'$Serie')");
	$Consulta3 = ew_Execute("INSERT INTO Atencion_Para_St (Id_Atencion, NroSerie, Id_Tipo_Retiro, Nro_Tiket) VALUES ($Id_Atencion,'$Serie', 1 ,'PENDIENTE')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando retiro P/Servicio Tecnico', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==2){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=2, Id_Sit_Estado=2, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra en Servicio Tecnico Externo', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Servicio Tecnico Externo', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==3){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra REPARADO, Esperando el retiro por el titular', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Solucionado, Esperando retiro del Titular', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==4){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra en Espera de Reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En espera de solución', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==5){
	$sql = ew_ExecuteRow("SELECT NroMac FROM Equipos WHERE NroSerie='$Serie'");
	$SN="EE183CE07CFBD86BF819";
	$Id_Hardware=$sql["NroMac"];
	$Tipo_Paquete=1;
	if ($Id_Hardware==""){
	$Id_Hardware="PENDIENTE";
	}
	$Marca_Arranque="PENDIENTE";
	$consultaServer = ew_ExecuteRow("SELECT Nro_Serie FROM Servidor_Escolar Limit 1");
	$Nro_Serie=$consultaServer["Nro_Serie"];
	$consultaRte = ew_ExecuteRow("SELECT Mail, DniRte, Apellido_Nombre FROM Referente_Tecnico Limit 1");
	$mail=$consultaRte["Mail"];
	$DniRte=$consultaRte["DniRte"];
	$Apellido_Nombre=$consultaRte["Apellido_Nombre"];
	$CargaPaquete = ew_Execute("INSERT INTO Paquetes_Provision (Fecha_Actualizacion, Usuario, SN, Id_Hardware, Marca_Arranque, Id_Tipo_Extraccion, Email_Solicitante, Id_Estado_Paquete, Id_Motivo, Serie_Netbook, Dni, Apellido_Nombre_Solicitante, Id_Tipo_Paquete, Serie_Server) VALUES ('$Fecha' ,'$usuario','$SN','$Id_Hardware', '$Marca_Arranque',1,'$mail',1,1,'$Serie',$DniRte, '$Apellido_Nombre', $Tipo_Paquete, '$Nro_Serie')");
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando Paquete de Provisión', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando Paquete de Provisión', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}elseif ($Estado==6){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando un cargador por falla o perdida', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Esperando Cargador/Batería', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	$EstadoAnterior=$rsold["Id_Estado_Atenc"];
	if ($EstadoAnterior==5){
	$ActPaquete = ew_Execute("UPDATE Paquetes_Provision SET Id_Estado_Paquete=4, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Serie_Netbook='$Serie'");
	}
	return TRUE;
	}elseif ($Estado==7){
	$sql = ew_ExecuteRow("SELECT Dni FROM Personas WHERE NroSerie='$Serie'");
	$Dni=$sql["Dni"];
	$Sql2 = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Dni=$Dni");
	$Prestamo=$Sql2["Id_Estado_Prestamo"];
	if ($Prestamo==1){
	echo '<script language="javascript">alert("EL ALUMNO ACTUAL POSEE UN PRESTAMO EN CURSO, VERIFIQUE LOS PRESTAMOS ACTIVOS ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo fue retirado funcionando por el titular, finalizó la atención', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('Retirado por el Titular', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	$EstadoAnterior=$rsold["Id_Estado_Atenc"];
	if ($EstadoAnterior==5){
	$ActPaquete = ew_Execute("UPDATE Paquetes_Provision SET Id_Estado_Paquete=4, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Serie_Netbook='$Serie'");
	}
	return TRUE;
	}
	}elseif ($Estado==8){
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('Equipo en reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Reparación', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return ;
	}else{
	$Consulta1 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=12, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('Equipo en reparación', '$Fecha' ,'$Serie')");
	$Consulta4 = ew_Execute("INSERT INTO Historial_Atencion (Detalle, Fecha_Actualizacion, NroSerie, Usuario, Id_Atencion) VALUES ('En Reparación', '$Fecha' ,'$Serie','$usuario',$Id_Atencion)");
	return TRUE;
	}
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
