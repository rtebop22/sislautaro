<?php

// Global variable for table object
$atencion_equipos = NULL;

//
// Table class for atencion_equipos
//
class catencion_equipos extends cTable {
	var $Id_Atencion;
	var $Dni;
	var $NroSerie;
	var $Fecha_Entrada;
	var $Id_Prioridad;
	var $Usuario;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'atencion_equipos';
		$this->TableName = 'atencion_equipos';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`atencion_equipos`";
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
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Id_Atencion
		$this->Id_Atencion = new cField('atencion_equipos', 'atencion_equipos', 'x_Id_Atencion', 'Id_Atencion', '`Id_Atencion`', '`Id_Atencion`', 3, -1, FALSE, '`Id_Atencion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Id_Atencion->Sortable = TRUE; // Allow sort
		$this->Id_Atencion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Atencion'] = &$this->Id_Atencion;

		// Dni
		$this->Dni = new cField('atencion_equipos', 'atencion_equipos', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// NroSerie
		$this->NroSerie = new cField('atencion_equipos', 'atencion_equipos', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// Fecha_Entrada
		$this->Fecha_Entrada = new cField('atencion_equipos', 'atencion_equipos', 'x_Fecha_Entrada', 'Fecha_Entrada', '`Fecha_Entrada`', 'DATE_FORMAT(`Fecha_Entrada`, \'\')', 133, 7, FALSE, '`Fecha_Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Entrada->Sortable = TRUE; // Allow sort
		$this->Fecha_Entrada->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Entrada'] = &$this->Fecha_Entrada;

		// Id_Prioridad
		$this->Id_Prioridad = new cField('atencion_equipos', 'atencion_equipos', 'x_Id_Prioridad', 'Id_Prioridad', '`Id_Prioridad`', '`Id_Prioridad`', 3, -1, FALSE, '`Id_Prioridad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Prioridad->Sortable = TRUE; // Allow sort
		$this->Id_Prioridad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Prioridad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Prioridad'] = &$this->Id_Prioridad;

		// Usuario
		$this->Usuario = new cField('atencion_equipos', 'atencion_equipos', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "detalle_atencion") {
			$sDetailUrl = $GLOBALS["detalle_atencion"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
			$sDetailUrl .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "atencion_para_st") {
			$sDetailUrl = $GLOBALS["atencion_para_st"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
			$sDetailUrl .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "historial_atencion") {
			$sDetailUrl = $GLOBALS["historial_atencion"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Id_Atencion=" . urlencode($this->Id_Atencion->CurrentValue);
			$sDetailUrl .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "atencion_equiposlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`atencion_equipos`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Id_Atencion` DESC";
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

		// Cascade Update detail table 'detalle_atencion'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['Id_Atencion']) && $rsold['Id_Atencion'] <> $rs['Id_Atencion'])) { // Update detail field 'Id_Atencion'
			$bCascadeUpdate = TRUE;
			$rscascade['Id_Atencion'] = $rs['Id_Atencion']; 
		}
		if (!is_null($rsold) && (isset($rs['NroSerie']) && $rsold['NroSerie'] <> $rs['NroSerie'])) { // Update detail field 'NroSerie'
			$bCascadeUpdate = TRUE;
			$rscascade['NroSerie'] = $rs['NroSerie']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["detalle_atencion"])) $GLOBALS["detalle_atencion"] = new cdetalle_atencion();
			$rswrk = $GLOBALS["detalle_atencion"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$GLOBALS["detalle_atencion"]->Update($rscascade, "`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB'), $rswrk->fields);
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 'atencion_para_st'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['Id_Atencion']) && $rsold['Id_Atencion'] <> $rs['Id_Atencion'])) { // Update detail field 'Id_Atencion'
			$bCascadeUpdate = TRUE;
			$rscascade['Id_Atencion'] = $rs['Id_Atencion']; 
		}
		if (!is_null($rsold) && (isset($rs['NroSerie']) && $rsold['NroSerie'] <> $rs['NroSerie'])) { // Update detail field 'NroSerie'
			$bCascadeUpdate = TRUE;
			$rscascade['NroSerie'] = $rs['NroSerie']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["atencion_para_st"])) $GLOBALS["atencion_para_st"] = new catencion_para_st();
			$rswrk = $GLOBALS["atencion_para_st"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$GLOBALS["atencion_para_st"]->Update($rscascade, "`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB'), $rswrk->fields);
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 'historial_atencion'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['Id_Atencion']) && $rsold['Id_Atencion'] <> $rs['Id_Atencion'])) { // Update detail field 'Id_Atencion'
			$bCascadeUpdate = TRUE;
			$rscascade['Id_Atencion'] = $rs['Id_Atencion']; 
		}
		if (!is_null($rsold) && (isset($rs['NroSerie']) && $rsold['NroSerie'] <> $rs['NroSerie'])) { // Update detail field 'NroSerie'
			$bCascadeUpdate = TRUE;
			$rscascade['NroSerie'] = $rs['NroSerie']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["historial_atencion"])) $GLOBALS["historial_atencion"] = new chistorial_atencion();
			$rswrk = $GLOBALS["historial_atencion"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$GLOBALS["historial_atencion"]->Update($rscascade, "`Id_Atencion` = " . ew_QuotedValue($rsold['Id_Atencion'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB'), $rswrk->fields);
				$rswrk->MoveNext();
			}
		}
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

		// Cascade delete detail table 'detalle_atencion'
		if (!isset($GLOBALS["detalle_atencion"])) $GLOBALS["detalle_atencion"] = new cdetalle_atencion();
		$rscascade = $GLOBALS["detalle_atencion"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rs['Id_Atencion'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`NroSerie` = " . ew_QuotedValue($rs['NroSerie'], EW_DATATYPE_STRING, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["detalle_atencion"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}

		// Cascade delete detail table 'atencion_para_st'
		if (!isset($GLOBALS["atencion_para_st"])) $GLOBALS["atencion_para_st"] = new catencion_para_st();
		$rscascade = $GLOBALS["atencion_para_st"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rs['Id_Atencion'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`NroSerie` = " . ew_QuotedValue($rs['NroSerie'], EW_DATATYPE_STRING, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["atencion_para_st"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}

		// Cascade delete detail table 'historial_atencion'
		if (!isset($GLOBALS["historial_atencion"])) $GLOBALS["historial_atencion"] = new chistorial_atencion();
		$rscascade = $GLOBALS["historial_atencion"]->LoadRs("`Id_Atencion` = " . ew_QuotedValue($rs['Id_Atencion'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`NroSerie` = " . ew_QuotedValue($rs['NroSerie'], EW_DATATYPE_STRING, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["historial_atencion"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Id_Atencion` = @Id_Atencion@ AND `NroSerie` = '@NroSerie@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Atencion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "atencion_equiposlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "atencion_equiposlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("atencion_equiposview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("atencion_equiposview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "atencion_equiposadd.php?" . $this->UrlParm($parm);
		else
			$url = "atencion_equiposadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("atencion_equiposedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("atencion_equiposedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("atencion_equiposadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("atencion_equiposadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("atencion_equiposdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Atencion:" . ew_VarToJson($this->Id_Atencion->CurrentValue, "number", "'");
		$json .= ",NroSerie:" . ew_VarToJson($this->NroSerie->CurrentValue, "string", "'");
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
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // Id_Atencion
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha_Entrada'));
		$this->Id_Prioridad->setDbValue($rs->fields('Id_Prioridad'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Atencion
		// Dni
		// NroSerie
		// Fecha_Entrada
		// Id_Prioridad
		// Usuario
		// Id_Atencion

		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		if (strval($this->Dni->CurrentValue) <> "") {
			$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni->ViewValue = $this->Dni->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni->ViewValue = $this->Dni->CurrentValue;
			}
		} else {
			$this->Dni->ViewValue = NULL;
		}
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			}
		} else {
			$this->NroSerie->ViewValue = NULL;
		}
		$this->NroSerie->ViewCustomAttributes = "";

		// Fecha_Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 7);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Id_Prioridad
		if (strval($this->Id_Prioridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Prioridad`" . ew_SearchString("=", $this->Id_Prioridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Prioridad`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_prioridad_atencion`";
		$sWhereWrk = "";
		$this->Id_Prioridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Prioridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Prioridad->ViewValue = $this->Id_Prioridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Prioridad->ViewValue = $this->Id_Prioridad->CurrentValue;
			}
		} else {
			$this->Id_Prioridad->ViewValue = NULL;
		}
		$this->Id_Prioridad->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Id_Atencion
		$this->Id_Atencion->LinkCustomAttributes = "";
		$this->Id_Atencion->HrefValue = "";
		$this->Id_Atencion->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// Fecha_Entrada
		$this->Fecha_Entrada->LinkCustomAttributes = "";
		$this->Fecha_Entrada->HrefValue = "";
		$this->Fecha_Entrada->TooltipValue = "";

		// Id_Prioridad
		$this->Id_Prioridad->LinkCustomAttributes = "";
		$this->Id_Prioridad->HrefValue = "";
		$this->Id_Prioridad->TooltipValue = "";

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

		// Id_Atencion
		$this->Id_Atencion->EditAttrs["class"] = "form-control";
		$this->Id_Atencion->EditCustomAttributes = "";
		$this->Id_Atencion->EditValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
			}
		} else {
			$this->NroSerie->EditValue = NULL;
		}
		$this->NroSerie->ViewCustomAttributes = "";

		// Fecha_Entrada
		$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
		$this->Fecha_Entrada->EditCustomAttributes = "";
		$this->Fecha_Entrada->EditValue = ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 7);
		$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

		// Id_Prioridad
		$this->Id_Prioridad->EditAttrs["class"] = "form-control";
		$this->Id_Prioridad->EditCustomAttributes = "";

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
					if ($this->Id_Atencion->Exportable) $Doc->ExportCaption($this->Id_Atencion);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Id_Prioridad->Exportable) $Doc->ExportCaption($this->Id_Prioridad);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
				} else {
					if ($this->Id_Atencion->Exportable) $Doc->ExportCaption($this->Id_Atencion);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Id_Prioridad->Exportable) $Doc->ExportCaption($this->Id_Prioridad);
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
						if ($this->Id_Atencion->Exportable) $Doc->ExportField($this->Id_Atencion);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Id_Prioridad->Exportable) $Doc->ExportField($this->Id_Prioridad);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
					} else {
						if ($this->Id_Atencion->Exportable) $Doc->ExportField($this->Id_Atencion);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Id_Prioridad->Exportable) $Doc->ExportField($this->Id_Prioridad);
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
		if (preg_match('/^x(\d)*_Dni$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `NroSerie` AS FIELD0 FROM `personas`";
			$sWhereWrk = "(`Dni` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->NroSerie->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->NroSerie->AutoFillOriginalValue) ? $this->NroSerie->CurrentValue : $this->NroSerie->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

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
