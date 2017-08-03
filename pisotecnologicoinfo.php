<?php

// Global variable for table object
$pisotecnologico = NULL;

//
// Table class for pisotecnologico
//
class cpisotecnologico extends cTable {
	var $CUE;
	var $Establecimiento;
	var $Departamneto;
	var $Localidad;
	var $Tiene_Switch;
	var $Estado_Switch;
	var $Cant__Ap;
	var $Estado_Ap;
	var $_25_Estado_Ap;
	var $Tiene_UPS;
	var $Estado_Ups;
	var $Cableado;
	var $Estado_Cableado;
	var $_25_Estado_Cableado;
	var $_25_Func__Piso;
	var $Ultima_Actualizacion;
	var $Marca_Modelo_Serie_Ups;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pisotecnologico';
		$this->TableName = 'pisotecnologico';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`pisotecnologico`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// CUE
		$this->CUE = new cField('pisotecnologico', 'pisotecnologico', 'x_CUE', 'CUE', '`CUE`', '`CUE`', 200, -1, FALSE, '`CUE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->CUE->Sortable = FALSE; // Allow sort
		$this->fields['CUE'] = &$this->CUE;

		// Establecimiento
		$this->Establecimiento = new cField('pisotecnologico', 'pisotecnologico', 'x_Establecimiento', 'Establecimiento', '`Establecimiento`', '`Establecimiento`', 200, -1, FALSE, '`Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Establecimiento'] = &$this->Establecimiento;

		// Departamneto
		$this->Departamneto = new cField('pisotecnologico', 'pisotecnologico', 'x_Departamneto', 'Departamneto', '`Departamneto`', '`Departamneto`', 200, -1, FALSE, '`Departamneto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Departamneto->Sortable = TRUE; // Allow sort
		$this->fields['Departamneto'] = &$this->Departamneto;

		// Localidad
		$this->Localidad = new cField('pisotecnologico', 'pisotecnologico', 'x_Localidad', 'Localidad', '`Localidad`', '`Localidad`', 200, -1, FALSE, '`Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Localidad->Sortable = TRUE; // Allow sort
		$this->fields['Localidad'] = &$this->Localidad;

		// Tiene Switch
		$this->Tiene_Switch = new cField('pisotecnologico', 'pisotecnologico', 'x_Tiene_Switch', 'Tiene Switch', '`Tiene Switch`', '`Tiene Switch`', 200, -1, FALSE, '`Tiene Switch`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Tiene_Switch->Sortable = TRUE; // Allow sort
		$this->Tiene_Switch->OptionCount = 2;
		$this->Tiene_Switch->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Tiene_Switch->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Tiene_Switch->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Tiene_Switch->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Tiene Switch'] = &$this->Tiene_Switch;

		// Estado Switch
		$this->Estado_Switch = new cField('pisotecnologico', 'pisotecnologico', 'x_Estado_Switch', 'Estado Switch', '`Estado Switch`', '`Estado Switch`', 3, -1, FALSE, '`Estado Switch`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Switch->Sortable = TRUE; // Allow sort
		$this->Estado_Switch->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Switch->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Switch->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Switch->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Switch->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Switch->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Switch->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado Switch'] = &$this->Estado_Switch;

		// Cant. Ap
		$this->Cant__Ap = new cField('pisotecnologico', 'pisotecnologico', 'x_Cant__Ap', 'Cant. Ap', '`Cant. Ap`', '`Cant. Ap`', 3, -1, FALSE, '`Cant. Ap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cant__Ap->Sortable = TRUE; // Allow sort
		$this->Cant__Ap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cant. Ap'] = &$this->Cant__Ap;

		// Estado Ap
		$this->Estado_Ap = new cField('pisotecnologico', 'pisotecnologico', 'x_Estado_Ap', 'Estado Ap', '`Estado Ap`', '`Estado Ap`', 3, -1, FALSE, '`Estado Ap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Ap->Sortable = TRUE; // Allow sort
		$this->Estado_Ap->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Ap->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Ap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Ap->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Ap->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Ap->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Ap->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado Ap'] = &$this->Estado_Ap;

		// % Estado Ap
		$this->_25_Estado_Ap = new cField('pisotecnologico', 'pisotecnologico', 'x__25_Estado_Ap', '% Estado Ap', '`% Estado Ap`', '`% Estado Ap`', 3, -1, FALSE, '`% Estado Ap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_25_Estado_Ap->Sortable = TRUE; // Allow sort
		$this->_25_Estado_Ap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['% Estado Ap'] = &$this->_25_Estado_Ap;

		// Tiene UPS
		$this->Tiene_UPS = new cField('pisotecnologico', 'pisotecnologico', 'x_Tiene_UPS', 'Tiene UPS', '`Tiene UPS`', '`Tiene UPS`', 200, -1, FALSE, '`Tiene UPS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Tiene_UPS->Sortable = TRUE; // Allow sort
		$this->Tiene_UPS->OptionCount = 2;
		$this->Tiene_UPS->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Tiene_UPS->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Tiene_UPS->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Tiene_UPS->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Tiene UPS'] = &$this->Tiene_UPS;

		// Estado Ups
		$this->Estado_Ups = new cField('pisotecnologico', 'pisotecnologico', 'x_Estado_Ups', 'Estado Ups', '`Estado Ups`', '`Estado Ups`', 3, -1, FALSE, '`Estado Ups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Ups->Sortable = TRUE; // Allow sort
		$this->Estado_Ups->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Ups->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Ups->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Ups->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Ups->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Ups->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Ups->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado Ups'] = &$this->Estado_Ups;

		// Cableado
		$this->Cableado = new cField('pisotecnologico', 'pisotecnologico', 'x_Cableado', 'Cableado', '`Cableado`', '`Cableado`', 200, -1, FALSE, '`Cableado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Cableado->Sortable = TRUE; // Allow sort
		$this->Cableado->OptionCount = 2;
		$this->Cableado->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Cableado->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Cableado->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Cableado->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Cableado'] = &$this->Cableado;

		// Estado Cableado
		$this->Estado_Cableado = new cField('pisotecnologico', 'pisotecnologico', 'x_Estado_Cableado', 'Estado Cableado', '`Estado Cableado`', '`Estado Cableado`', 3, -1, FALSE, '`Estado Cableado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Cableado->Sortable = TRUE; // Allow sort
		$this->Estado_Cableado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Cableado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Cableado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Cableado->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Cableado->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Cableado->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Cableado->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado Cableado'] = &$this->Estado_Cableado;

		// % Estado Cableado
		$this->_25_Estado_Cableado = new cField('pisotecnologico', 'pisotecnologico', 'x__25_Estado_Cableado', '% Estado Cableado', '`% Estado Cableado`', '`% Estado Cableado`', 3, -1, FALSE, '`% Estado Cableado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_25_Estado_Cableado->Sortable = TRUE; // Allow sort
		$this->_25_Estado_Cableado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['% Estado Cableado'] = &$this->_25_Estado_Cableado;

		// % Func. Piso
		$this->_25_Func__Piso = new cField('pisotecnologico', 'pisotecnologico', 'x__25_Func__Piso', '% Func. Piso', '`% Func. Piso`', '`% Func. Piso`', 3, -1, FALSE, '`% Func. Piso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_25_Func__Piso->Sortable = TRUE; // Allow sort
		$this->_25_Func__Piso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['% Func. Piso'] = &$this->_25_Func__Piso;

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion = new cField('pisotecnologico', 'pisotecnologico', 'x_Ultima_Actualizacion', 'Ultima_Actualizacion', '`Ultima_Actualizacion`', 'DATE_FORMAT(`Ultima_Actualizacion`, \'\')', 133, 7, FALSE, '`Ultima_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Ultima_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Ultima_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Ultima_Actualizacion'] = &$this->Ultima_Actualizacion;

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups = new cField('pisotecnologico', 'pisotecnologico', 'x_Marca_Modelo_Serie_Ups', 'Marca_Modelo_Serie_Ups', '`Marca_Modelo_Serie_Ups`', '`Marca_Modelo_Serie_Ups`', 201, -1, FALSE, '`Marca_Modelo_Serie_Ups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Marca_Modelo_Serie_Ups->Sortable = TRUE; // Allow sort
		$this->fields['Marca_Modelo_Serie_Ups'] = &$this->Marca_Modelo_Serie_Ups;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pisotecnologico`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "pisotecnologicolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pisotecnologicolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pisotecnologicoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pisotecnologicoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pisotecnologicoadd.php?" . $this->UrlParm($parm);
		else
			$url = "pisotecnologicoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pisotecnologicoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pisotecnologicoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pisotecnologicodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Establecimiento->setDbValue($rs->fields('Establecimiento'));
		$this->Departamneto->setDbValue($rs->fields('Departamneto'));
		$this->Localidad->setDbValue($rs->fields('Localidad'));
		$this->Tiene_Switch->setDbValue($rs->fields('Tiene Switch'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado Switch'));
		$this->Cant__Ap->setDbValue($rs->fields('Cant. Ap'));
		$this->Estado_Ap->setDbValue($rs->fields('Estado Ap'));
		$this->_25_Estado_Ap->setDbValue($rs->fields('% Estado Ap'));
		$this->Tiene_UPS->setDbValue($rs->fields('Tiene UPS'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado Cableado'));
		$this->_25_Estado_Cableado->setDbValue($rs->fields('% Estado Cableado'));
		$this->_25_Func__Piso->setDbValue($rs->fields('% Func. Piso'));
		$this->Ultima_Actualizacion->setDbValue($rs->fields('Ultima_Actualizacion'));
		$this->Marca_Modelo_Serie_Ups->setDbValue($rs->fields('Marca_Modelo_Serie_Ups'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CUE

		$this->CUE->CellCssStyle = "white-space: nowrap;";

		// Establecimiento
		// Departamneto
		// Localidad
		// Tiene Switch
		// Estado Switch
		// Cant. Ap
		// Estado Ap
		// % Estado Ap
		// Tiene UPS
		// Estado Ups
		// Cableado
		// Estado Cableado
		// % Estado Cableado
		// % Func. Piso
		// Ultima_Actualizacion
		// Marca_Modelo_Serie_Ups
		// CUE

		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->ViewValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->ViewCustomAttributes = "";

		// Departamneto
		$this->Departamneto->ViewValue = $this->Departamneto->CurrentValue;
		$this->Departamneto->ViewCustomAttributes = "";

		// Localidad
		$this->Localidad->ViewValue = $this->Localidad->CurrentValue;
		$this->Localidad->ViewCustomAttributes = "";

		// Tiene Switch
		if (strval($this->Tiene_Switch->CurrentValue) <> "") {
			$this->Tiene_Switch->ViewValue = $this->Tiene_Switch->OptionCaption($this->Tiene_Switch->CurrentValue);
		} else {
			$this->Tiene_Switch->ViewValue = NULL;
		}
		$this->Tiene_Switch->ViewCustomAttributes = "";

		// Estado Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->CurrentValue;
			}
		} else {
			$this->Estado_Switch->ViewValue = NULL;
		}
		$this->Estado_Switch->ViewCustomAttributes = "";

		// Cant. Ap
		$this->Cant__Ap->ViewValue = $this->Cant__Ap->CurrentValue;
		$this->Cant__Ap->ViewCustomAttributes = "";

		// Estado Ap
		if (strval($this->Estado_Ap->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ap->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ap->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ap, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->CurrentValue;
			}
		} else {
			$this->Estado_Ap->ViewValue = NULL;
		}
		$this->Estado_Ap->ViewCustomAttributes = "";

		// % Estado Ap
		$this->_25_Estado_Ap->ViewValue = $this->_25_Estado_Ap->CurrentValue;
		$this->_25_Estado_Ap->ViewCustomAttributes = "";

		// Tiene UPS
		if (strval($this->Tiene_UPS->CurrentValue) <> "") {
			$this->Tiene_UPS->ViewValue = $this->Tiene_UPS->OptionCaption($this->Tiene_UPS->CurrentValue);
		} else {
			$this->Tiene_UPS->ViewValue = NULL;
		}
		$this->Tiene_UPS->ViewCustomAttributes = "";

		// Estado Ups
		if (strval($this->Estado_Ups->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ups->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->CurrentValue;
			}
		} else {
			$this->Estado_Ups->ViewValue = NULL;
		}
		$this->Estado_Ups->ViewCustomAttributes = "";

		// Cableado
		if (strval($this->Cableado->CurrentValue) <> "") {
			$this->Cableado->ViewValue = $this->Cableado->OptionCaption($this->Cableado->CurrentValue);
		} else {
			$this->Cableado->ViewValue = NULL;
		}
		$this->Cableado->ViewCustomAttributes = "";

		// Estado Cableado
		if (strval($this->Estado_Cableado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Cableado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->CurrentValue;
			}
		} else {
			$this->Estado_Cableado->ViewValue = NULL;
		}
		$this->Estado_Cableado->ViewCustomAttributes = "";

		// % Estado Cableado
		$this->_25_Estado_Cableado->ViewValue = $this->_25_Estado_Cableado->CurrentValue;
		$this->_25_Estado_Cableado->ViewCustomAttributes = "";

		// % Func. Piso
		$this->_25_Func__Piso->ViewValue = $this->_25_Func__Piso->CurrentValue;
		$this->_25_Func__Piso->ViewCustomAttributes = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 7);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->ViewValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->ViewCustomAttributes = "";

		// CUE
		$this->CUE->LinkCustomAttributes = "";
		$this->CUE->HrefValue = "";
		$this->CUE->TooltipValue = "";

		// Establecimiento
		$this->Establecimiento->LinkCustomAttributes = "";
		$this->Establecimiento->HrefValue = "";
		$this->Establecimiento->TooltipValue = "";

		// Departamneto
		$this->Departamneto->LinkCustomAttributes = "";
		$this->Departamneto->HrefValue = "";
		$this->Departamneto->TooltipValue = "";

		// Localidad
		$this->Localidad->LinkCustomAttributes = "";
		$this->Localidad->HrefValue = "";
		$this->Localidad->TooltipValue = "";

		// Tiene Switch
		$this->Tiene_Switch->LinkCustomAttributes = "";
		$this->Tiene_Switch->HrefValue = "";
		$this->Tiene_Switch->TooltipValue = "";

		// Estado Switch
		$this->Estado_Switch->LinkCustomAttributes = "";
		$this->Estado_Switch->HrefValue = "";
		$this->Estado_Switch->TooltipValue = "";

		// Cant. Ap
		$this->Cant__Ap->LinkCustomAttributes = "";
		$this->Cant__Ap->HrefValue = "";
		$this->Cant__Ap->TooltipValue = "";

		// Estado Ap
		$this->Estado_Ap->LinkCustomAttributes = "";
		$this->Estado_Ap->HrefValue = "";
		$this->Estado_Ap->TooltipValue = "";

		// % Estado Ap
		$this->_25_Estado_Ap->LinkCustomAttributes = "";
		$this->_25_Estado_Ap->HrefValue = "";
		$this->_25_Estado_Ap->TooltipValue = "";

		// Tiene UPS
		$this->Tiene_UPS->LinkCustomAttributes = "";
		$this->Tiene_UPS->HrefValue = "";
		$this->Tiene_UPS->TooltipValue = "";

		// Estado Ups
		$this->Estado_Ups->LinkCustomAttributes = "";
		$this->Estado_Ups->HrefValue = "";
		$this->Estado_Ups->TooltipValue = "";

		// Cableado
		$this->Cableado->LinkCustomAttributes = "";
		$this->Cableado->HrefValue = "";
		$this->Cableado->TooltipValue = "";

		// Estado Cableado
		$this->Estado_Cableado->LinkCustomAttributes = "";
		$this->Estado_Cableado->HrefValue = "";
		$this->Estado_Cableado->TooltipValue = "";

		// % Estado Cableado
		$this->_25_Estado_Cableado->LinkCustomAttributes = "";
		$this->_25_Estado_Cableado->HrefValue = "";
		$this->_25_Estado_Cableado->TooltipValue = "";

		// % Func. Piso
		$this->_25_Func__Piso->LinkCustomAttributes = "";
		$this->_25_Func__Piso->HrefValue = "";
		$this->_25_Func__Piso->TooltipValue = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->LinkCustomAttributes = "";
		$this->Ultima_Actualizacion->HrefValue = "";
		$this->Ultima_Actualizacion->TooltipValue = "";

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
		$this->Marca_Modelo_Serie_Ups->HrefValue = "";
		$this->Marca_Modelo_Serie_Ups->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// CUE
		$this->CUE->EditAttrs["class"] = "form-control";
		$this->CUE->EditCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->EditAttrs["class"] = "form-control";
		$this->Establecimiento->EditCustomAttributes = "";
		$this->Establecimiento->EditValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->PlaceHolder = ew_RemoveHtml($this->Establecimiento->FldCaption());

		// Departamneto
		$this->Departamneto->EditAttrs["class"] = "form-control";
		$this->Departamneto->EditCustomAttributes = "";
		$this->Departamneto->EditValue = $this->Departamneto->CurrentValue;
		$this->Departamneto->PlaceHolder = ew_RemoveHtml($this->Departamneto->FldCaption());

		// Localidad
		$this->Localidad->EditAttrs["class"] = "form-control";
		$this->Localidad->EditCustomAttributes = "";
		$this->Localidad->EditValue = $this->Localidad->CurrentValue;
		$this->Localidad->PlaceHolder = ew_RemoveHtml($this->Localidad->FldCaption());

		// Tiene Switch
		$this->Tiene_Switch->EditCustomAttributes = "";
		$this->Tiene_Switch->EditValue = $this->Tiene_Switch->Options(FALSE);

		// Estado Switch
		$this->Estado_Switch->EditAttrs["class"] = "form-control";
		$this->Estado_Switch->EditCustomAttributes = "";

		// Cant. Ap
		$this->Cant__Ap->EditAttrs["class"] = "form-control";
		$this->Cant__Ap->EditCustomAttributes = "";
		$this->Cant__Ap->EditValue = $this->Cant__Ap->CurrentValue;
		$this->Cant__Ap->PlaceHolder = ew_RemoveHtml($this->Cant__Ap->FldCaption());

		// Estado Ap
		$this->Estado_Ap->EditAttrs["class"] = "form-control";
		$this->Estado_Ap->EditCustomAttributes = "";

		// % Estado Ap
		$this->_25_Estado_Ap->EditAttrs["class"] = "form-control";
		$this->_25_Estado_Ap->EditCustomAttributes = "";
		$this->_25_Estado_Ap->EditValue = $this->_25_Estado_Ap->CurrentValue;
		$this->_25_Estado_Ap->PlaceHolder = ew_RemoveHtml($this->_25_Estado_Ap->FldCaption());

		// Tiene UPS
		$this->Tiene_UPS->EditCustomAttributes = "";
		$this->Tiene_UPS->EditValue = $this->Tiene_UPS->Options(FALSE);

		// Estado Ups
		$this->Estado_Ups->EditAttrs["class"] = "form-control";
		$this->Estado_Ups->EditCustomAttributes = "";

		// Cableado
		$this->Cableado->EditCustomAttributes = "";
		$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

		// Estado Cableado
		$this->Estado_Cableado->EditAttrs["class"] = "form-control";
		$this->Estado_Cableado->EditCustomAttributes = "";

		// % Estado Cableado
		$this->_25_Estado_Cableado->EditAttrs["class"] = "form-control";
		$this->_25_Estado_Cableado->EditCustomAttributes = "";
		$this->_25_Estado_Cableado->EditValue = $this->_25_Estado_Cableado->CurrentValue;
		$this->_25_Estado_Cableado->PlaceHolder = ew_RemoveHtml($this->_25_Estado_Cableado->FldCaption());

		// % Func. Piso
		$this->_25_Func__Piso->EditAttrs["class"] = "form-control";
		$this->_25_Func__Piso->EditCustomAttributes = "";
		$this->_25_Func__Piso->EditValue = $this->_25_Func__Piso->CurrentValue;
		$this->_25_Func__Piso->PlaceHolder = ew_RemoveHtml($this->_25_Func__Piso->FldCaption());

		// Ultima_Actualizacion
		// Marca_Modelo_Serie_Ups

		$this->Marca_Modelo_Serie_Ups->EditAttrs["class"] = "form-control";
		$this->Marca_Modelo_Serie_Ups->EditCustomAttributes = "";
		$this->Marca_Modelo_Serie_Ups->EditValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->PlaceHolder = ew_RemoveHtml($this->Marca_Modelo_Serie_Ups->FldCaption());

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
					if ($this->Establecimiento->Exportable) $Doc->ExportCaption($this->Establecimiento);
					if ($this->Departamneto->Exportable) $Doc->ExportCaption($this->Departamneto);
					if ($this->Localidad->Exportable) $Doc->ExportCaption($this->Localidad);
					if ($this->Tiene_Switch->Exportable) $Doc->ExportCaption($this->Tiene_Switch);
					if ($this->Estado_Switch->Exportable) $Doc->ExportCaption($this->Estado_Switch);
					if ($this->Cant__Ap->Exportable) $Doc->ExportCaption($this->Cant__Ap);
					if ($this->Estado_Ap->Exportable) $Doc->ExportCaption($this->Estado_Ap);
					if ($this->_25_Estado_Ap->Exportable) $Doc->ExportCaption($this->_25_Estado_Ap);
					if ($this->Tiene_UPS->Exportable) $Doc->ExportCaption($this->Tiene_UPS);
					if ($this->Estado_Ups->Exportable) $Doc->ExportCaption($this->Estado_Ups);
					if ($this->Cableado->Exportable) $Doc->ExportCaption($this->Cableado);
					if ($this->Estado_Cableado->Exportable) $Doc->ExportCaption($this->Estado_Cableado);
					if ($this->_25_Estado_Cableado->Exportable) $Doc->ExportCaption($this->_25_Estado_Cableado);
					if ($this->_25_Func__Piso->Exportable) $Doc->ExportCaption($this->_25_Func__Piso);
					if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportCaption($this->Ultima_Actualizacion);
					if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportCaption($this->Marca_Modelo_Serie_Ups);
				} else {
					if ($this->Establecimiento->Exportable) $Doc->ExportCaption($this->Establecimiento);
					if ($this->Departamneto->Exportable) $Doc->ExportCaption($this->Departamneto);
					if ($this->Localidad->Exportable) $Doc->ExportCaption($this->Localidad);
					if ($this->Tiene_Switch->Exportable) $Doc->ExportCaption($this->Tiene_Switch);
					if ($this->Estado_Switch->Exportable) $Doc->ExportCaption($this->Estado_Switch);
					if ($this->Cant__Ap->Exportable) $Doc->ExportCaption($this->Cant__Ap);
					if ($this->Estado_Ap->Exportable) $Doc->ExportCaption($this->Estado_Ap);
					if ($this->_25_Estado_Ap->Exportable) $Doc->ExportCaption($this->_25_Estado_Ap);
					if ($this->Tiene_UPS->Exportable) $Doc->ExportCaption($this->Tiene_UPS);
					if ($this->Estado_Ups->Exportable) $Doc->ExportCaption($this->Estado_Ups);
					if ($this->Cableado->Exportable) $Doc->ExportCaption($this->Cableado);
					if ($this->Estado_Cableado->Exportable) $Doc->ExportCaption($this->Estado_Cableado);
					if ($this->_25_Estado_Cableado->Exportable) $Doc->ExportCaption($this->_25_Estado_Cableado);
					if ($this->_25_Func__Piso->Exportable) $Doc->ExportCaption($this->_25_Func__Piso);
					if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportCaption($this->Ultima_Actualizacion);
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
						if ($this->Establecimiento->Exportable) $Doc->ExportField($this->Establecimiento);
						if ($this->Departamneto->Exportable) $Doc->ExportField($this->Departamneto);
						if ($this->Localidad->Exportable) $Doc->ExportField($this->Localidad);
						if ($this->Tiene_Switch->Exportable) $Doc->ExportField($this->Tiene_Switch);
						if ($this->Estado_Switch->Exportable) $Doc->ExportField($this->Estado_Switch);
						if ($this->Cant__Ap->Exportable) $Doc->ExportField($this->Cant__Ap);
						if ($this->Estado_Ap->Exportable) $Doc->ExportField($this->Estado_Ap);
						if ($this->_25_Estado_Ap->Exportable) $Doc->ExportField($this->_25_Estado_Ap);
						if ($this->Tiene_UPS->Exportable) $Doc->ExportField($this->Tiene_UPS);
						if ($this->Estado_Ups->Exportable) $Doc->ExportField($this->Estado_Ups);
						if ($this->Cableado->Exportable) $Doc->ExportField($this->Cableado);
						if ($this->Estado_Cableado->Exportable) $Doc->ExportField($this->Estado_Cableado);
						if ($this->_25_Estado_Cableado->Exportable) $Doc->ExportField($this->_25_Estado_Cableado);
						if ($this->_25_Func__Piso->Exportable) $Doc->ExportField($this->_25_Func__Piso);
						if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportField($this->Ultima_Actualizacion);
						if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportField($this->Marca_Modelo_Serie_Ups);
					} else {
						if ($this->Establecimiento->Exportable) $Doc->ExportField($this->Establecimiento);
						if ($this->Departamneto->Exportable) $Doc->ExportField($this->Departamneto);
						if ($this->Localidad->Exportable) $Doc->ExportField($this->Localidad);
						if ($this->Tiene_Switch->Exportable) $Doc->ExportField($this->Tiene_Switch);
						if ($this->Estado_Switch->Exportable) $Doc->ExportField($this->Estado_Switch);
						if ($this->Cant__Ap->Exportable) $Doc->ExportField($this->Cant__Ap);
						if ($this->Estado_Ap->Exportable) $Doc->ExportField($this->Estado_Ap);
						if ($this->_25_Estado_Ap->Exportable) $Doc->ExportField($this->_25_Estado_Ap);
						if ($this->Tiene_UPS->Exportable) $Doc->ExportField($this->Tiene_UPS);
						if ($this->Estado_Ups->Exportable) $Doc->ExportField($this->Estado_Ups);
						if ($this->Cableado->Exportable) $Doc->ExportField($this->Cableado);
						if ($this->Estado_Cableado->Exportable) $Doc->ExportField($this->Estado_Cableado);
						if ($this->_25_Estado_Cableado->Exportable) $Doc->ExportField($this->_25_Estado_Cableado);
						if ($this->_25_Func__Piso->Exportable) $Doc->ExportField($this->_25_Func__Piso);
						if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportField($this->Ultima_Actualizacion);
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
