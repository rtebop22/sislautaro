<?php

// Global variable for table object
$datospiso = NULL;

//
// Table class for datospiso
//
class cdatospiso extends cTable {
	var $Cue;
	var $Nombre_Establecimiento;
	var $Departamento;
	var $Localidad;
	var $Switch;
	var $Cantidad_Swich;
	var $Estado_Switch;
	var $Cantidad_Ap;
	var $Estado_Ap;
	var $Cantidad_Ap_Func;
	var $Ups;
	var $Estado_Ups;
	var $Cableado;
	var $Estado_Cableado;
	var $Porcent_Estado_Cab;
	var $Porcent_Func_Piso;
	var $Marca_Modelo_Serie_Ups;
	var $Ultima_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'datospiso';
		$this->TableName = 'datospiso';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`datospiso`";
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

		// Cue
		$this->Cue = new cField('datospiso', 'datospiso', 'x_Cue', 'Cue', '`Cue`', '`Cue`', 200, -1, FALSE, '`Cue`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Cue->Sortable = TRUE; // Allow sort
		$this->fields['Cue'] = &$this->Cue;

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento = new cField('datospiso', 'datospiso', 'x_Nombre_Establecimiento', 'Nombre_Establecimiento', '`Nombre_Establecimiento`', '`Nombre_Establecimiento`', 200, -1, FALSE, '`Nombre_Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Establecimiento'] = &$this->Nombre_Establecimiento;

		// Departamento
		$this->Departamento = new cField('datospiso', 'datospiso', 'x_Departamento', 'Departamento', '`Departamento`', '`Departamento`', 200, -1, FALSE, '`Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Departamento->Sortable = TRUE; // Allow sort
		$this->Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Departamento'] = &$this->Departamento;

		// Localidad
		$this->Localidad = new cField('datospiso', 'datospiso', 'x_Localidad', 'Localidad', '`Localidad`', '`Localidad`', 200, -1, FALSE, '`Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Localidad->Sortable = TRUE; // Allow sort
		$this->Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Localidad'] = &$this->Localidad;

		// Switch
		$this->Switch = new cField('datospiso', 'datospiso', 'x_Switch', 'Switch', '`Switch`', '`Switch`', 200, -1, FALSE, '`Switch`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Switch->Sortable = TRUE; // Allow sort
		$this->Switch->OptionCount = 2;
		$this->Switch->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Switch->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Switch->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Switch->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Switch'] = &$this->Switch;

		// Cantidad_Swich
		$this->Cantidad_Swich = new cField('datospiso', 'datospiso', 'x_Cantidad_Swich', 'Cantidad_Swich', '`Cantidad_Swich`', '`Cantidad_Swich`', 3, -1, FALSE, '`Cantidad_Swich`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Swich->Sortable = TRUE; // Allow sort
		$this->Cantidad_Swich->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Swich'] = &$this->Cantidad_Swich;

		// Estado_Switch
		$this->Estado_Switch = new cField('datospiso', 'datospiso', 'x_Estado_Switch', 'Estado_Switch', '`Estado_Switch`', '`Estado_Switch`', 3, -1, FALSE, '`Estado_Switch`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Switch->Sortable = TRUE; // Allow sort
		$this->Estado_Switch->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Switch->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Switch->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Switch->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Switch->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Switch->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Switch->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado_Switch'] = &$this->Estado_Switch;

		// Cantidad_Ap
		$this->Cantidad_Ap = new cField('datospiso', 'datospiso', 'x_Cantidad_Ap', 'Cantidad_Ap', '`Cantidad_Ap`', '`Cantidad_Ap`', 3, -1, FALSE, '`Cantidad_Ap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Ap->Sortable = TRUE; // Allow sort
		$this->Cantidad_Ap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Ap'] = &$this->Cantidad_Ap;

		// Estado_Ap
		$this->Estado_Ap = new cField('datospiso', 'datospiso', 'x_Estado_Ap', 'Estado_Ap', '`Estado_Ap`', '`Estado_Ap`', 3, -1, FALSE, '`Estado_Ap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Ap->Sortable = TRUE; // Allow sort
		$this->Estado_Ap->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Ap->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Ap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Ap->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Ap->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Ap->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Ap->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado_Ap'] = &$this->Estado_Ap;

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func = new cField('datospiso', 'datospiso', 'x_Cantidad_Ap_Func', 'Cantidad_Ap_Func', '`Cantidad_Ap_Func`', '`Cantidad_Ap_Func`', 3, -1, FALSE, '`Cantidad_Ap_Func`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Ap_Func->Sortable = TRUE; // Allow sort
		$this->Cantidad_Ap_Func->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Ap_Func'] = &$this->Cantidad_Ap_Func;

		// Ups
		$this->Ups = new cField('datospiso', 'datospiso', 'x_Ups', 'Ups', '`Ups`', '`Ups`', 200, -1, FALSE, '`Ups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Ups->Sortable = TRUE; // Allow sort
		$this->Ups->OptionCount = 2;
		$this->Ups->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Ups->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Ups->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Ups->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Ups'] = &$this->Ups;

		// Estado_Ups
		$this->Estado_Ups = new cField('datospiso', 'datospiso', 'x_Estado_Ups', 'Estado_Ups', '`Estado_Ups`', '`Estado_Ups`', 3, -1, FALSE, '`Estado_Ups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Ups->Sortable = TRUE; // Allow sort
		$this->Estado_Ups->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Ups->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Ups->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Ups->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Ups->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Ups->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Ups->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado_Ups'] = &$this->Estado_Ups;

		// Cableado
		$this->Cableado = new cField('datospiso', 'datospiso', 'x_Cableado', 'Cableado', '`Cableado`', '`Cableado`', 200, -1, FALSE, '`Cableado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Cableado->Sortable = TRUE; // Allow sort
		$this->Cableado->OptionCount = 2;
		$this->Cableado->AdvancedSearch->SearchValueDefault = 'Si';
		$this->Cableado->AdvancedSearch->SearchOperatorDefault = "LIKE";
		$this->Cableado->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Cableado->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Cableado'] = &$this->Cableado;

		// Estado_Cableado
		$this->Estado_Cableado = new cField('datospiso', 'datospiso', 'x_Estado_Cableado', 'Estado_Cableado', '`Estado_Cableado`', '`Estado_Cableado`', 3, -1, FALSE, '`Estado_Cableado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Cableado->Sortable = TRUE; // Allow sort
		$this->Estado_Cableado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Cableado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Cableado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->Estado_Cableado->AdvancedSearch->SearchValueDefault = 1;
		$this->Estado_Cableado->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Estado_Cableado->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Estado_Cableado->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Estado_Cableado'] = &$this->Estado_Cableado;

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab = new cField('datospiso', 'datospiso', 'x_Porcent_Estado_Cab', 'Porcent_Estado_Cab', '`Porcent_Estado_Cab`', '`Porcent_Estado_Cab`', 3, -1, FALSE, '`Porcent_Estado_Cab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Porcent_Estado_Cab->Sortable = TRUE; // Allow sort
		$this->Porcent_Estado_Cab->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Porcent_Estado_Cab'] = &$this->Porcent_Estado_Cab;

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso = new cField('datospiso', 'datospiso', 'x_Porcent_Func_Piso', 'Porcent_Func_Piso', '`Porcent_Func_Piso`', '`Porcent_Func_Piso`', 3, -1, FALSE, '`Porcent_Func_Piso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Porcent_Func_Piso->Sortable = TRUE; // Allow sort
		$this->Porcent_Func_Piso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Porcent_Func_Piso'] = &$this->Porcent_Func_Piso;

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups = new cField('datospiso', 'datospiso', 'x_Marca_Modelo_Serie_Ups', 'Marca_Modelo_Serie_Ups', '`Marca_Modelo_Serie_Ups`', '`Marca_Modelo_Serie_Ups`', 201, -1, FALSE, '`Marca_Modelo_Serie_Ups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Marca_Modelo_Serie_Ups->Sortable = TRUE; // Allow sort
		$this->fields['Marca_Modelo_Serie_Ups'] = &$this->Marca_Modelo_Serie_Ups;

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion = new cField('datospiso', 'datospiso', 'x_Ultima_Actualizacion', 'Ultima_Actualizacion', '`Ultima_Actualizacion`', 'DATE_FORMAT(`Ultima_Actualizacion`, \'\')', 133, 7, FALSE, '`Ultima_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Ultima_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Ultima_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Ultima_Actualizacion'] = &$this->Ultima_Actualizacion;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`datospiso`";
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
			return "datospisolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "datospisolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("datospisoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("datospisoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "datospisoadd.php?" . $this->UrlParm($parm);
		else
			$url = "datospisoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("datospisoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("datospisoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("datospisodelete.php", $this->UrlParm());
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Departamento->setDbValue($rs->fields('Departamento'));
		$this->Localidad->setDbValue($rs->fields('Localidad'));
		$this->Switch->setDbValue($rs->fields('Switch'));
		$this->Cantidad_Swich->setDbValue($rs->fields('Cantidad_Swich'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado_Switch'));
		$this->Cantidad_Ap->setDbValue($rs->fields('Cantidad_Ap'));
		$this->Estado_Ap->setDbValue($rs->fields('Estado_Ap'));
		$this->Cantidad_Ap_Func->setDbValue($rs->fields('Cantidad_Ap_Func'));
		$this->Ups->setDbValue($rs->fields('Ups'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado_Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado_Cableado'));
		$this->Porcent_Estado_Cab->setDbValue($rs->fields('Porcent_Estado_Cab'));
		$this->Porcent_Func_Piso->setDbValue($rs->fields('Porcent_Func_Piso'));
		$this->Marca_Modelo_Serie_Ups->setDbValue($rs->fields('Marca_Modelo_Serie_Ups'));
		$this->Ultima_Actualizacion->setDbValue($rs->fields('Ultima_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Cue
		// Nombre_Establecimiento
		// Departamento
		// Localidad
		// Switch
		// Cantidad_Swich
		// Estado_Switch
		// Cantidad_Ap
		// Estado_Ap
		// Cantidad_Ap_Func
		// Ups
		// Estado_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Porcent_Func_Piso
		// Marca_Modelo_Serie_Ups
		// Ultima_Actualizacion
		// Cue

		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Departamento
		if (strval($this->Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Departamento->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Departamento->ViewValue = $this->Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Departamento->ViewValue = $this->Departamento->CurrentValue;
			}
		} else {
			$this->Departamento->ViewValue = NULL;
		}
		$this->Departamento->ViewCustomAttributes = "";

		// Localidad
		if (strval($this->Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad->ViewValue = $this->Localidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad->ViewValue = $this->Localidad->CurrentValue;
			}
		} else {
			$this->Localidad->ViewValue = NULL;
		}
		$this->Localidad->ViewCustomAttributes = "";

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Cantidad_Swich
		$this->Cantidad_Swich->ViewValue = $this->Cantidad_Swich->CurrentValue;
		$this->Cantidad_Swich->ViewCustomAttributes = "";

		// Estado_Switch
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

		// Cantidad_Ap
		$this->Cantidad_Ap->ViewValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->ViewCustomAttributes = "";

		// Estado_Ap
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

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->ViewValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Cantidad_Ap_Func->ViewCustomAttributes = "";

		// Ups
		if (strval($this->Ups->CurrentValue) <> "") {
			$this->Ups->ViewValue = $this->Ups->OptionCaption($this->Ups->CurrentValue);
		} else {
			$this->Ups->ViewValue = NULL;
		}
		$this->Ups->ViewCustomAttributes = "";

		// Estado_Ups
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

		// Estado_Cableado
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

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->ViewValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->ViewCustomAttributes = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->ViewValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->ViewCustomAttributes = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 7);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->LinkCustomAttributes = "";
		$this->Cue->HrefValue = "";
		$this->Cue->TooltipValue = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->LinkCustomAttributes = "";
		$this->Nombre_Establecimiento->HrefValue = "";
		$this->Nombre_Establecimiento->TooltipValue = "";

		// Departamento
		$this->Departamento->LinkCustomAttributes = "";
		$this->Departamento->HrefValue = "";
		$this->Departamento->TooltipValue = "";

		// Localidad
		$this->Localidad->LinkCustomAttributes = "";
		$this->Localidad->HrefValue = "";
		$this->Localidad->TooltipValue = "";

		// Switch
		$this->Switch->LinkCustomAttributes = "";
		$this->Switch->HrefValue = "";
		$this->Switch->TooltipValue = "";

		// Cantidad_Swich
		$this->Cantidad_Swich->LinkCustomAttributes = "";
		$this->Cantidad_Swich->HrefValue = "";
		$this->Cantidad_Swich->TooltipValue = "";

		// Estado_Switch
		$this->Estado_Switch->LinkCustomAttributes = "";
		$this->Estado_Switch->HrefValue = "";
		$this->Estado_Switch->TooltipValue = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->LinkCustomAttributes = "";
		$this->Cantidad_Ap->HrefValue = "";
		$this->Cantidad_Ap->TooltipValue = "";

		// Estado_Ap
		$this->Estado_Ap->LinkCustomAttributes = "";
		$this->Estado_Ap->HrefValue = "";
		$this->Estado_Ap->TooltipValue = "";

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
		$this->Cantidad_Ap_Func->HrefValue = "";
		$this->Cantidad_Ap_Func->TooltipValue = "";

		// Ups
		$this->Ups->LinkCustomAttributes = "";
		$this->Ups->HrefValue = "";
		$this->Ups->TooltipValue = "";

		// Estado_Ups
		$this->Estado_Ups->LinkCustomAttributes = "";
		$this->Estado_Ups->HrefValue = "";
		$this->Estado_Ups->TooltipValue = "";

		// Cableado
		$this->Cableado->LinkCustomAttributes = "";
		$this->Cableado->HrefValue = "";
		$this->Cableado->TooltipValue = "";

		// Estado_Cableado
		$this->Estado_Cableado->LinkCustomAttributes = "";
		$this->Estado_Cableado->HrefValue = "";
		$this->Estado_Cableado->TooltipValue = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
		$this->Porcent_Estado_Cab->HrefValue = "";
		$this->Porcent_Estado_Cab->TooltipValue = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->LinkCustomAttributes = "";
		$this->Porcent_Func_Piso->HrefValue = "";
		$this->Porcent_Func_Piso->TooltipValue = "";

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
		$this->Marca_Modelo_Serie_Ups->HrefValue = "";
		$this->Marca_Modelo_Serie_Ups->TooltipValue = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->LinkCustomAttributes = "";
		$this->Ultima_Actualizacion->HrefValue = "";
		$this->Ultima_Actualizacion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Cue
		$this->Cue->EditAttrs["class"] = "form-control";
		$this->Cue->EditCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
		$this->Nombre_Establecimiento->EditCustomAttributes = "";
		$this->Nombre_Establecimiento->EditValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

		// Departamento
		$this->Departamento->EditAttrs["class"] = "form-control";
		$this->Departamento->EditCustomAttributes = "";

		// Localidad
		$this->Localidad->EditAttrs["class"] = "form-control";
		$this->Localidad->EditCustomAttributes = "";

		// Switch
		$this->Switch->EditCustomAttributes = "";
		$this->Switch->EditValue = $this->Switch->Options(FALSE);

		// Cantidad_Swich
		$this->Cantidad_Swich->EditAttrs["class"] = "form-control";
		$this->Cantidad_Swich->EditCustomAttributes = "";
		$this->Cantidad_Swich->EditValue = $this->Cantidad_Swich->CurrentValue;
		$this->Cantidad_Swich->PlaceHolder = ew_RemoveHtml($this->Cantidad_Swich->FldCaption());

		// Estado_Switch
		$this->Estado_Switch->EditAttrs["class"] = "form-control";
		$this->Estado_Switch->EditCustomAttributes = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
		$this->Cantidad_Ap->EditCustomAttributes = "";
		$this->Cantidad_Ap->EditValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

		// Estado_Ap
		$this->Estado_Ap->EditAttrs["class"] = "form-control";
		$this->Estado_Ap->EditCustomAttributes = "";

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->EditAttrs["class"] = "form-control";
		$this->Cantidad_Ap_Func->EditCustomAttributes = "";
		$this->Cantidad_Ap_Func->EditValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Cantidad_Ap_Func->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap_Func->FldCaption());

		// Ups
		$this->Ups->EditCustomAttributes = "";
		$this->Ups->EditValue = $this->Ups->Options(FALSE);

		// Estado_Ups
		$this->Estado_Ups->EditAttrs["class"] = "form-control";
		$this->Estado_Ups->EditCustomAttributes = "";

		// Cableado
		$this->Cableado->EditCustomAttributes = "";
		$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

		// Estado_Cableado
		$this->Estado_Cableado->EditAttrs["class"] = "form-control";
		$this->Estado_Cableado->EditCustomAttributes = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
		$this->Porcent_Estado_Cab->EditCustomAttributes = "";
		$this->Porcent_Estado_Cab->EditValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
		$this->Porcent_Func_Piso->EditCustomAttributes = "";
		$this->Porcent_Func_Piso->EditValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->EditAttrs["class"] = "form-control";
		$this->Marca_Modelo_Serie_Ups->EditCustomAttributes = "";
		$this->Marca_Modelo_Serie_Ups->EditValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->PlaceHolder = ew_RemoveHtml($this->Marca_Modelo_Serie_Ups->FldCaption());

		// Ultima_Actualizacion
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
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Departamento->Exportable) $Doc->ExportCaption($this->Departamento);
					if ($this->Localidad->Exportable) $Doc->ExportCaption($this->Localidad);
					if ($this->Switch->Exportable) $Doc->ExportCaption($this->Switch);
					if ($this->Cantidad_Swich->Exportable) $Doc->ExportCaption($this->Cantidad_Swich);
					if ($this->Estado_Switch->Exportable) $Doc->ExportCaption($this->Estado_Switch);
					if ($this->Cantidad_Ap->Exportable) $Doc->ExportCaption($this->Cantidad_Ap);
					if ($this->Estado_Ap->Exportable) $Doc->ExportCaption($this->Estado_Ap);
					if ($this->Cantidad_Ap_Func->Exportable) $Doc->ExportCaption($this->Cantidad_Ap_Func);
					if ($this->Ups->Exportable) $Doc->ExportCaption($this->Ups);
					if ($this->Estado_Ups->Exportable) $Doc->ExportCaption($this->Estado_Ups);
					if ($this->Cableado->Exportable) $Doc->ExportCaption($this->Cableado);
					if ($this->Estado_Cableado->Exportable) $Doc->ExportCaption($this->Estado_Cableado);
					if ($this->Porcent_Estado_Cab->Exportable) $Doc->ExportCaption($this->Porcent_Estado_Cab);
					if ($this->Porcent_Func_Piso->Exportable) $Doc->ExportCaption($this->Porcent_Func_Piso);
					if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportCaption($this->Marca_Modelo_Serie_Ups);
					if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportCaption($this->Ultima_Actualizacion);
				} else {
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Departamento->Exportable) $Doc->ExportCaption($this->Departamento);
					if ($this->Localidad->Exportable) $Doc->ExportCaption($this->Localidad);
					if ($this->Switch->Exportable) $Doc->ExportCaption($this->Switch);
					if ($this->Cantidad_Swich->Exportable) $Doc->ExportCaption($this->Cantidad_Swich);
					if ($this->Estado_Switch->Exportable) $Doc->ExportCaption($this->Estado_Switch);
					if ($this->Cantidad_Ap->Exportable) $Doc->ExportCaption($this->Cantidad_Ap);
					if ($this->Estado_Ap->Exportable) $Doc->ExportCaption($this->Estado_Ap);
					if ($this->Cantidad_Ap_Func->Exportable) $Doc->ExportCaption($this->Cantidad_Ap_Func);
					if ($this->Ups->Exportable) $Doc->ExportCaption($this->Ups);
					if ($this->Estado_Ups->Exportable) $Doc->ExportCaption($this->Estado_Ups);
					if ($this->Cableado->Exportable) $Doc->ExportCaption($this->Cableado);
					if ($this->Estado_Cableado->Exportable) $Doc->ExportCaption($this->Estado_Cableado);
					if ($this->Porcent_Estado_Cab->Exportable) $Doc->ExportCaption($this->Porcent_Estado_Cab);
					if ($this->Porcent_Func_Piso->Exportable) $Doc->ExportCaption($this->Porcent_Func_Piso);
					if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportCaption($this->Marca_Modelo_Serie_Ups);
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
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Departamento->Exportable) $Doc->ExportField($this->Departamento);
						if ($this->Localidad->Exportable) $Doc->ExportField($this->Localidad);
						if ($this->Switch->Exportable) $Doc->ExportField($this->Switch);
						if ($this->Cantidad_Swich->Exportable) $Doc->ExportField($this->Cantidad_Swich);
						if ($this->Estado_Switch->Exportable) $Doc->ExportField($this->Estado_Switch);
						if ($this->Cantidad_Ap->Exportable) $Doc->ExportField($this->Cantidad_Ap);
						if ($this->Estado_Ap->Exportable) $Doc->ExportField($this->Estado_Ap);
						if ($this->Cantidad_Ap_Func->Exportable) $Doc->ExportField($this->Cantidad_Ap_Func);
						if ($this->Ups->Exportable) $Doc->ExportField($this->Ups);
						if ($this->Estado_Ups->Exportable) $Doc->ExportField($this->Estado_Ups);
						if ($this->Cableado->Exportable) $Doc->ExportField($this->Cableado);
						if ($this->Estado_Cableado->Exportable) $Doc->ExportField($this->Estado_Cableado);
						if ($this->Porcent_Estado_Cab->Exportable) $Doc->ExportField($this->Porcent_Estado_Cab);
						if ($this->Porcent_Func_Piso->Exportable) $Doc->ExportField($this->Porcent_Func_Piso);
						if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportField($this->Marca_Modelo_Serie_Ups);
						if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportField($this->Ultima_Actualizacion);
					} else {
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Departamento->Exportable) $Doc->ExportField($this->Departamento);
						if ($this->Localidad->Exportable) $Doc->ExportField($this->Localidad);
						if ($this->Switch->Exportable) $Doc->ExportField($this->Switch);
						if ($this->Cantidad_Swich->Exportable) $Doc->ExportField($this->Cantidad_Swich);
						if ($this->Estado_Switch->Exportable) $Doc->ExportField($this->Estado_Switch);
						if ($this->Cantidad_Ap->Exportable) $Doc->ExportField($this->Cantidad_Ap);
						if ($this->Estado_Ap->Exportable) $Doc->ExportField($this->Estado_Ap);
						if ($this->Cantidad_Ap_Func->Exportable) $Doc->ExportField($this->Cantidad_Ap_Func);
						if ($this->Ups->Exportable) $Doc->ExportField($this->Ups);
						if ($this->Estado_Ups->Exportable) $Doc->ExportField($this->Estado_Ups);
						if ($this->Cableado->Exportable) $Doc->ExportField($this->Cableado);
						if ($this->Estado_Cableado->Exportable) $Doc->ExportField($this->Estado_Cableado);
						if ($this->Porcent_Estado_Cab->Exportable) $Doc->ExportField($this->Porcent_Estado_Cab);
						if ($this->Porcent_Func_Piso->Exportable) $Doc->ExportField($this->Porcent_Func_Piso);
						if ($this->Marca_Modelo_Serie_Ups->Exportable) $Doc->ExportField($this->Marca_Modelo_Serie_Ups);
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
