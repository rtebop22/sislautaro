<?php

// Global variable for table object
$equipos = NULL;

//
// Table class for equipos
//
class cequipos extends cTable {
	var $NroSerie;
	var $NroMac;
	var $SpecialNumber;
	var $Id_Ubicacion;
	var $Id_Estado;
	var $Id_Sit_Estado;
	var $Id_Marca;
	var $Id_Modelo;
	var $Id_Ano;
	var $Tiene_Cargador;
	var $Id_Tipo_Equipo;
	var $Usuario;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'equipos';
		$this->TableName = 'equipos';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`equipos`";
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

		// NroSerie
		$this->NroSerie = new cField('equipos', 'equipos', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// NroMac
		$this->NroMac = new cField('equipos', 'equipos', 'x_NroMac', 'NroMac', '`NroMac`', '`NroMac`', 200, -1, FALSE, '`NroMac`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroMac->Sortable = TRUE; // Allow sort
		$this->fields['NroMac'] = &$this->NroMac;

		// SpecialNumber
		$this->SpecialNumber = new cField('equipos', 'equipos', 'x_SpecialNumber', 'SpecialNumber', '`SpecialNumber`', '`SpecialNumber`', 200, -1, FALSE, '`SpecialNumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SpecialNumber->Sortable = TRUE; // Allow sort
		$this->fields['SpecialNumber'] = &$this->SpecialNumber;

		// Id_Ubicacion
		$this->Id_Ubicacion = new cField('equipos', 'equipos', 'x_Id_Ubicacion', 'Id_Ubicacion', '`Id_Ubicacion`', '`Id_Ubicacion`', 3, -1, FALSE, '`Id_Ubicacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Ubicacion->Sortable = TRUE; // Allow sort
		$this->Id_Ubicacion->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Ubicacion->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Ubicacion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Ubicacion'] = &$this->Id_Ubicacion;

		// Id_Estado
		$this->Id_Estado = new cField('equipos', 'equipos', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado->Sortable = TRUE; // Allow sort
		$this->Id_Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// Id_Sit_Estado
		$this->Id_Sit_Estado = new cField('equipos', 'equipos', 'x_Id_Sit_Estado', 'Id_Sit_Estado', '`Id_Sit_Estado`', '`Id_Sit_Estado`', 3, -1, FALSE, '`Id_Sit_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Sit_Estado->Sortable = TRUE; // Allow sort
		$this->Id_Sit_Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Sit_Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Sit_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Sit_Estado'] = &$this->Id_Sit_Estado;

		// Id_Marca
		$this->Id_Marca = new cField('equipos', 'equipos', 'x_Id_Marca', 'Id_Marca', '`Id_Marca`', '`Id_Marca`', 3, -1, FALSE, '`Id_Marca`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Marca->Sortable = TRUE; // Allow sort
		$this->Id_Marca->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Marca->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Marca->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Marca'] = &$this->Id_Marca;

		// Id_Modelo
		$this->Id_Modelo = new cField('equipos', 'equipos', 'x_Id_Modelo', 'Id_Modelo', '`Id_Modelo`', '`Id_Modelo`', 3, -1, FALSE, '`Id_Modelo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Modelo->Sortable = TRUE; // Allow sort
		$this->Id_Modelo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Modelo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Modelo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Modelo'] = &$this->Id_Modelo;

		// Id_Ano
		$this->Id_Ano = new cField('equipos', 'equipos', 'x_Id_Ano', 'Id_Ano', '`Id_Ano`', '`Id_Ano`', 3, -1, FALSE, '`Id_Ano`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Ano->Sortable = TRUE; // Allow sort
		$this->Id_Ano->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Ano->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Ano->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Ano'] = &$this->Id_Ano;

		// Tiene_Cargador
		$this->Tiene_Cargador = new cField('equipos', 'equipos', 'x_Tiene_Cargador', 'Tiene_Cargador', '`Tiene_Cargador`', '`Tiene_Cargador`', 200, -1, FALSE, '`Tiene_Cargador`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Tiene_Cargador->Sortable = TRUE; // Allow sort
		$this->Tiene_Cargador->OptionCount = 3;
		$this->fields['Tiene_Cargador'] = &$this->Tiene_Cargador;

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo = new cField('equipos', 'equipos', 'x_Id_Tipo_Equipo', 'Id_Tipo_Equipo', '`Id_Tipo_Equipo`', '`Id_Tipo_Equipo`', 3, -1, FALSE, '`Id_Tipo_Equipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Equipo->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Equipo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Equipo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Tipo_Equipo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tipo_Equipo'] = &$this->Id_Tipo_Equipo;

		// Usuario
		$this->Usuario = new cField('equipos', 'equipos', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, 7, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('equipos', 'equipos', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
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
		if ($this->getCurrentMasterTable() == "personas") {
			if ($this->NroSerie->getSessionValue() <> "")
				$sMasterFilter .= "`NroSerie`=" . ew_QuotedValue($this->NroSerie->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "personas") {
			if ($this->NroSerie->getSessionValue() <> "")
				$sDetailFilter .= "`NroSerie`=" . ew_QuotedValue($this->NroSerie->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_personas() {
		return "`NroSerie`='@NroSerie@'";
	}

	// Detail filter
	function SqlDetailFilter_personas() {
		return "`NroSerie`='@NroSerie@'";
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
		if ($this->getCurrentDetailTable() == "observacion_equipo") {
			$sDetailUrl = $GLOBALS["observacion_equipo"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "equiposlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`equipos`";
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

		// Cascade Update detail table 'observacion_equipo'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['NroSerie']) && $rsold['NroSerie'] <> $rs['NroSerie'])) { // Update detail field 'NroSerie'
			$bCascadeUpdate = TRUE;
			$rscascade['NroSerie'] = $rs['NroSerie']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["observacion_equipo"])) $GLOBALS["observacion_equipo"] = new cobservacion_equipo();
			$rswrk = $GLOBALS["observacion_equipo"]->LoadRs("`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$GLOBALS["observacion_equipo"]->Update($rscascade, "`NroSerie` = " . ew_QuotedValue($rsold['NroSerie'], EW_DATATYPE_STRING, 'DB'), $rswrk->fields);
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

		// Cascade delete detail table 'observacion_equipo'
		if (!isset($GLOBALS["observacion_equipo"])) $GLOBALS["observacion_equipo"] = new cobservacion_equipo();
		$rscascade = $GLOBALS["observacion_equipo"]->LoadRs("`NroSerie` = " . ew_QuotedValue($rs['NroSerie'], EW_DATATYPE_STRING, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["observacion_equipo"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`NroSerie` = '@NroSerie@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "equiposlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "equiposlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("equiposview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("equiposview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "equiposadd.php?" . $this->UrlParm($parm);
		else
			$url = "equiposadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("equiposedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("equiposedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("equiposadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("equiposadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("equiposdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "personas" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "NroSerie:" . ew_VarToJson($this->NroSerie->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->NroSerie->CurrentValue)) {
			$sUrl .= "NroSerie=" . urlencode($this->NroSerie->CurrentValue);
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
			if ($isPost && isset($_POST["NroSerie"]))
				$arKeys[] = ew_StripSlashes($_POST["NroSerie"]);
			elseif (isset($_GET["NroSerie"]))
				$arKeys[] = ew_StripSlashes($_GET["NroSerie"]);
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
			$this->NroSerie->CurrentValue = $key;
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
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->NroMac->setDbValue($rs->fields('NroMac'));
		$this->SpecialNumber->setDbValue($rs->fields('SpecialNumber'));
		$this->Id_Ubicacion->setDbValue($rs->fields('Id_Ubicacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Sit_Estado->setDbValue($rs->fields('Id_Sit_Estado'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_Ano->setDbValue($rs->fields('Id_Ano'));
		$this->Tiene_Cargador->setDbValue($rs->fields('Tiene_Cargador'));
		$this->Id_Tipo_Equipo->setDbValue($rs->fields('Id_Tipo_Equipo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// NroSerie
		// NroMac
		// SpecialNumber
		// Id_Ubicacion
		// Id_Estado
		// Id_Sit_Estado
		// Id_Marca
		// Id_Modelo
		// Id_Ano
		// Tiene_Cargador
		// Id_Tipo_Equipo
		// Usuario
		// Fecha_Actualizacion
		// NroSerie

		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->ViewValue = $this->NroMac->CurrentValue;
		$this->NroMac->ViewCustomAttributes = "";

		// SpecialNumber
		$this->SpecialNumber->ViewValue = $this->SpecialNumber->CurrentValue;
		$this->SpecialNumber->ViewCustomAttributes = "";

		// Id_Ubicacion
		if (strval($this->Id_Ubicacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
		$sWhereWrk = "";
		$this->Id_Ubicacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->CurrentValue;
			}
		} else {
			$this->Id_Ubicacion->ViewValue = NULL;
		}
		$this->Id_Ubicacion->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Id_Sit_Estado
		if (strval($this->Id_Sit_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
		$sWhereWrk = "";
		$this->Id_Sit_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->CurrentValue;
			}
		} else {
			$this->Id_Sit_Estado->ViewValue = NULL;
		}
		$this->Id_Sit_Estado->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
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

		// Id_Ano
		if (strval($this->Id_Ano->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
		$sWhereWrk = "";
		$this->Id_Ano->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ano->ViewValue = $this->Id_Ano->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ano->ViewValue = $this->Id_Ano->CurrentValue;
			}
		} else {
			$this->Id_Ano->ViewValue = NULL;
		}
		$this->Id_Ano->ViewCustomAttributes = "";

		// Tiene_Cargador
		if (strval($this->Tiene_Cargador->CurrentValue) <> "") {
			$this->Tiene_Cargador->ViewValue = $this->Tiene_Cargador->OptionCaption($this->Tiene_Cargador->CurrentValue);
		} else {
			$this->Tiene_Cargador->ViewValue = NULL;
		}
		$this->Tiene_Cargador->ViewCustomAttributes = "";

		// Id_Tipo_Equipo
		if (strval($this->Id_Tipo_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
		$sWhereWrk = "";
		$this->Id_Tipo_Equipo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Equipo->ViewValue = NULL;
		}
		$this->Id_Tipo_Equipo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewValue = ew_FormatDateTime($this->Usuario->ViewValue, 7);
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// NroMac
		$this->NroMac->LinkCustomAttributes = "";
		$this->NroMac->HrefValue = "";
		$this->NroMac->TooltipValue = "";

		// SpecialNumber
		$this->SpecialNumber->LinkCustomAttributes = "";
		$this->SpecialNumber->HrefValue = "";
		$this->SpecialNumber->TooltipValue = "";

		// Id_Ubicacion
		$this->Id_Ubicacion->LinkCustomAttributes = "";
		$this->Id_Ubicacion->HrefValue = "";
		$this->Id_Ubicacion->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// Id_Sit_Estado
		$this->Id_Sit_Estado->LinkCustomAttributes = "";
		$this->Id_Sit_Estado->HrefValue = "";
		$this->Id_Sit_Estado->TooltipValue = "";

		// Id_Marca
		$this->Id_Marca->LinkCustomAttributes = "";
		$this->Id_Marca->HrefValue = "";
		$this->Id_Marca->TooltipValue = "";

		// Id_Modelo
		$this->Id_Modelo->LinkCustomAttributes = "";
		$this->Id_Modelo->HrefValue = "";
		$this->Id_Modelo->TooltipValue = "";

		// Id_Ano
		$this->Id_Ano->LinkCustomAttributes = "";
		$this->Id_Ano->HrefValue = "";
		$this->Id_Ano->TooltipValue = "";

		// Tiene_Cargador
		$this->Tiene_Cargador->LinkCustomAttributes = "";
		$this->Tiene_Cargador->HrefValue = "";
		$this->Tiene_Cargador->TooltipValue = "";

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
		$this->Id_Tipo_Equipo->HrefValue = "";
		$this->Id_Tipo_Equipo->TooltipValue = "";

		// Usuario
		$this->Usuario->LinkCustomAttributes = "";
		$this->Usuario->HrefValue = "";
		$this->Usuario->TooltipValue = "";

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

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->EditAttrs["class"] = "form-control";
		$this->NroMac->EditCustomAttributes = "";
		$this->NroMac->EditValue = $this->NroMac->CurrentValue;
		$this->NroMac->PlaceHolder = ew_RemoveHtml($this->NroMac->FldCaption());

		// SpecialNumber
		$this->SpecialNumber->EditAttrs["class"] = "form-control";
		$this->SpecialNumber->EditCustomAttributes = "";
		$this->SpecialNumber->EditValue = $this->SpecialNumber->CurrentValue;
		$this->SpecialNumber->PlaceHolder = ew_RemoveHtml($this->SpecialNumber->FldCaption());

		// Id_Ubicacion
		$this->Id_Ubicacion->EditAttrs["class"] = "form-control";
		$this->Id_Ubicacion->EditCustomAttributes = "";

		// Id_Estado
		$this->Id_Estado->EditAttrs["class"] = "form-control";
		$this->Id_Estado->EditCustomAttributes = "";

		// Id_Sit_Estado
		$this->Id_Sit_Estado->EditAttrs["class"] = "form-control";
		$this->Id_Sit_Estado->EditCustomAttributes = "";

		// Id_Marca
		$this->Id_Marca->EditAttrs["class"] = "form-control";
		$this->Id_Marca->EditCustomAttributes = "";

		// Id_Modelo
		$this->Id_Modelo->EditAttrs["class"] = "form-control";
		$this->Id_Modelo->EditCustomAttributes = "";

		// Id_Ano
		$this->Id_Ano->EditAttrs["class"] = "form-control";
		$this->Id_Ano->EditCustomAttributes = "";

		// Tiene_Cargador
		$this->Tiene_Cargador->EditCustomAttributes = "";
		$this->Tiene_Cargador->EditValue = $this->Tiene_Cargador->Options(FALSE);

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Equipo->EditCustomAttributes = "";

		// Usuario
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
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->NroMac->Exportable) $Doc->ExportCaption($this->NroMac);
					if ($this->SpecialNumber->Exportable) $Doc->ExportCaption($this->SpecialNumber);
					if ($this->Id_Ubicacion->Exportable) $Doc->ExportCaption($this->Id_Ubicacion);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Sit_Estado->Exportable) $Doc->ExportCaption($this->Id_Sit_Estado);
					if ($this->Id_Marca->Exportable) $Doc->ExportCaption($this->Id_Marca);
					if ($this->Id_Modelo->Exportable) $Doc->ExportCaption($this->Id_Modelo);
					if ($this->Id_Ano->Exportable) $Doc->ExportCaption($this->Id_Ano);
					if ($this->Tiene_Cargador->Exportable) $Doc->ExportCaption($this->Tiene_Cargador);
					if ($this->Id_Tipo_Equipo->Exportable) $Doc->ExportCaption($this->Id_Tipo_Equipo);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->NroMac->Exportable) $Doc->ExportCaption($this->NroMac);
					if ($this->SpecialNumber->Exportable) $Doc->ExportCaption($this->SpecialNumber);
					if ($this->Id_Ubicacion->Exportable) $Doc->ExportCaption($this->Id_Ubicacion);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Sit_Estado->Exportable) $Doc->ExportCaption($this->Id_Sit_Estado);
					if ($this->Id_Marca->Exportable) $Doc->ExportCaption($this->Id_Marca);
					if ($this->Id_Modelo->Exportable) $Doc->ExportCaption($this->Id_Modelo);
					if ($this->Id_Ano->Exportable) $Doc->ExportCaption($this->Id_Ano);
					if ($this->Tiene_Cargador->Exportable) $Doc->ExportCaption($this->Tiene_Cargador);
					if ($this->Id_Tipo_Equipo->Exportable) $Doc->ExportCaption($this->Id_Tipo_Equipo);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
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
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->NroMac->Exportable) $Doc->ExportField($this->NroMac);
						if ($this->SpecialNumber->Exportable) $Doc->ExportField($this->SpecialNumber);
						if ($this->Id_Ubicacion->Exportable) $Doc->ExportField($this->Id_Ubicacion);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Sit_Estado->Exportable) $Doc->ExportField($this->Id_Sit_Estado);
						if ($this->Id_Marca->Exportable) $Doc->ExportField($this->Id_Marca);
						if ($this->Id_Modelo->Exportable) $Doc->ExportField($this->Id_Modelo);
						if ($this->Id_Ano->Exportable) $Doc->ExportField($this->Id_Ano);
						if ($this->Tiene_Cargador->Exportable) $Doc->ExportField($this->Tiene_Cargador);
						if ($this->Id_Tipo_Equipo->Exportable) $Doc->ExportField($this->Id_Tipo_Equipo);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->NroMac->Exportable) $Doc->ExportField($this->NroMac);
						if ($this->SpecialNumber->Exportable) $Doc->ExportField($this->SpecialNumber);
						if ($this->Id_Ubicacion->Exportable) $Doc->ExportField($this->Id_Ubicacion);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Sit_Estado->Exportable) $Doc->ExportField($this->Id_Sit_Estado);
						if ($this->Id_Marca->Exportable) $Doc->ExportField($this->Id_Marca);
						if ($this->Id_Modelo->Exportable) $Doc->ExportField($this->Id_Modelo);
						if ($this->Id_Ano->Exportable) $Doc->ExportField($this->Id_Ano);
						if ($this->Tiene_Cargador->Exportable) $Doc->ExportField($this->Tiene_Cargador);
						if ($this->Id_Tipo_Equipo->Exportable) $Doc->ExportField($this->Id_Tipo_Equipo);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
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
