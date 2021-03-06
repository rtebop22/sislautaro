<?php

// Global variable for table object
$dato_establecimiento = NULL;

//
// Table class for dato_establecimiento
//
class cdato_establecimiento extends cTable {
	var $Cue;
	var $Nombre_Establecimiento;
	var $Id_Departamento;
	var $Id_Localidad;
	var $Domicilio;
	var $Telefono_Escuela;
	var $Mail_Escuela;
	var $Matricula_Actual;
	var $Usuario;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'dato_establecimiento';
		$this->TableName = 'dato_establecimiento';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`dato_establecimiento`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Cue
		$this->Cue = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Cue', 'Cue', '`Cue`', '`Cue`', 200, -1, FALSE, '`Cue`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cue->Sortable = TRUE; // Allow sort
		$this->fields['Cue'] = &$this->Cue;

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Nombre_Establecimiento', 'Nombre_Establecimiento', '`Nombre_Establecimiento`', '`Nombre_Establecimiento`', 200, -1, FALSE, '`Nombre_Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Establecimiento'] = &$this->Nombre_Establecimiento;

		// Id_Departamento
		$this->Id_Departamento = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Id_Departamento', 'Id_Departamento', '`Id_Departamento`', '`Id_Departamento`', 3, -1, FALSE, '`Id_Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Departamento->Sortable = TRUE; // Allow sort
		$this->Id_Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Departamento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Departamento'] = &$this->Id_Departamento;

		// Id_Localidad
		$this->Id_Localidad = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Id_Localidad', 'Id_Localidad', '`Id_Localidad`', '`Id_Localidad`', 3, -1, FALSE, '`Id_Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Localidad->Sortable = TRUE; // Allow sort
		$this->Id_Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Localidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Localidad'] = &$this->Id_Localidad;

		// Domicilio
		$this->Domicilio = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Telefono_Escuela
		$this->Telefono_Escuela = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Telefono_Escuela', 'Telefono_Escuela', '`Telefono_Escuela`', '`Telefono_Escuela`', 3, -1, FALSE, '`Telefono_Escuela`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Telefono_Escuela->Sortable = TRUE; // Allow sort
		$this->fields['Telefono_Escuela'] = &$this->Telefono_Escuela;

		// Mail_Escuela
		$this->Mail_Escuela = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Mail_Escuela', 'Mail_Escuela', '`Mail_Escuela`', '`Mail_Escuela`', 200, -1, FALSE, '`Mail_Escuela`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Mail_Escuela->Sortable = TRUE; // Allow sort
		$this->fields['Mail_Escuela'] = &$this->Mail_Escuela;

		// Matricula_Actual
		$this->Matricula_Actual = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Matricula_Actual', 'Matricula_Actual', '`Matricula_Actual`', '`Matricula_Actual`', 3, -1, FALSE, '`Matricula_Actual`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Matricula_Actual->Sortable = TRUE; // Allow sort
		$this->Matricula_Actual->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Matricula_Actual'] = &$this->Matricula_Actual;

		// Usuario
		$this->Usuario = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('dato_establecimiento', 'dato_establecimiento', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
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
		if ($this->getCurrentDetailTable() == "autoridades_escolares") {
			$sDetailUrl = $GLOBALS["autoridades_escolares"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Cue=" . urlencode($this->Cue->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "referente_tecnico") {
			$sDetailUrl = $GLOBALS["referente_tecnico"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Cue=" . urlencode($this->Cue->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "piso_tecnologico") {
			$sDetailUrl = $GLOBALS["piso_tecnologico"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Cue=" . urlencode($this->Cue->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "servidor_escolar") {
			$sDetailUrl = $GLOBALS["servidor_escolar"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Cue=" . urlencode($this->Cue->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "dato_establecimientolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`dato_establecimiento`";
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
			return "dato_establecimientolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "dato_establecimientolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dato_establecimientoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dato_establecimientoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "dato_establecimientoadd.php?" . $this->UrlParm($parm);
		else
			$url = "dato_establecimientoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dato_establecimientoedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dato_establecimientoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("dato_establecimientoadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dato_establecimientoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("dato_establecimientodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono_Escuela->setDbValue($rs->fields('Telefono_Escuela'));
		$this->Mail_Escuela->setDbValue($rs->fields('Mail_Escuela'));
		$this->Matricula_Actual->setDbValue($rs->fields('Matricula_Actual'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Cue
		// Nombre_Establecimiento
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono_Escuela
		// Mail_Escuela
		// Matricula_Actual
		// Usuario
		// Fecha_Actualizacion
		// Cue

		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->CurrentValue;
			}
		} else {
			$this->Id_Departamento->ViewValue = NULL;
		}
		$this->Id_Departamento->ViewCustomAttributes = "";

		// Id_Localidad
		if (strval($this->Id_Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Id_Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->CurrentValue;
			}
		} else {
			$this->Id_Localidad->ViewValue = NULL;
		}
		$this->Id_Localidad->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono_Escuela
		$this->Telefono_Escuela->ViewValue = $this->Telefono_Escuela->CurrentValue;
		$this->Telefono_Escuela->ViewCustomAttributes = "";

		// Mail_Escuela
		$this->Mail_Escuela->ViewValue = $this->Mail_Escuela->CurrentValue;
		$this->Mail_Escuela->ViewCustomAttributes = "";

		// Matricula_Actual
		$this->Matricula_Actual->ViewValue = $this->Matricula_Actual->CurrentValue;
		$this->Matricula_Actual->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->LinkCustomAttributes = "";
		$this->Cue->HrefValue = "";
		$this->Cue->TooltipValue = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->LinkCustomAttributes = "";
		$this->Nombre_Establecimiento->HrefValue = "";
		$this->Nombre_Establecimiento->TooltipValue = "";

		// Id_Departamento
		$this->Id_Departamento->LinkCustomAttributes = "";
		$this->Id_Departamento->HrefValue = "";
		$this->Id_Departamento->TooltipValue = "";

		// Id_Localidad
		$this->Id_Localidad->LinkCustomAttributes = "";
		$this->Id_Localidad->HrefValue = "";
		$this->Id_Localidad->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Telefono_Escuela
		$this->Telefono_Escuela->LinkCustomAttributes = "";
		$this->Telefono_Escuela->HrefValue = "";
		$this->Telefono_Escuela->TooltipValue = "";

		// Mail_Escuela
		$this->Mail_Escuela->LinkCustomAttributes = "";
		$this->Mail_Escuela->HrefValue = "";
		$this->Mail_Escuela->TooltipValue = "";

		// Matricula_Actual
		$this->Matricula_Actual->LinkCustomAttributes = "";
		$this->Matricula_Actual->HrefValue = "";
		$this->Matricula_Actual->TooltipValue = "";

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

		// Cue
		$this->Cue->EditAttrs["class"] = "form-control";
		$this->Cue->EditCustomAttributes = "";
		$this->Cue->EditValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
		$this->Nombre_Establecimiento->EditCustomAttributes = "";
		$this->Nombre_Establecimiento->EditValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

		// Id_Departamento
		$this->Id_Departamento->EditAttrs["class"] = "form-control";
		$this->Id_Departamento->EditCustomAttributes = "";

		// Id_Localidad
		$this->Id_Localidad->EditAttrs["class"] = "form-control";
		$this->Id_Localidad->EditCustomAttributes = "";

		// Domicilio
		$this->Domicilio->EditAttrs["class"] = "form-control";
		$this->Domicilio->EditCustomAttributes = "";
		$this->Domicilio->EditValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

		// Telefono_Escuela
		$this->Telefono_Escuela->EditAttrs["class"] = "form-control";
		$this->Telefono_Escuela->EditCustomAttributes = "";
		$this->Telefono_Escuela->EditValue = $this->Telefono_Escuela->CurrentValue;
		$this->Telefono_Escuela->PlaceHolder = ew_RemoveHtml($this->Telefono_Escuela->FldCaption());

		// Mail_Escuela
		$this->Mail_Escuela->EditAttrs["class"] = "form-control";
		$this->Mail_Escuela->EditCustomAttributes = "";
		$this->Mail_Escuela->EditValue = $this->Mail_Escuela->CurrentValue;
		$this->Mail_Escuela->PlaceHolder = ew_RemoveHtml($this->Mail_Escuela->FldCaption());

		// Matricula_Actual
		$this->Matricula_Actual->EditAttrs["class"] = "form-control";
		$this->Matricula_Actual->EditCustomAttributes = "";
		$this->Matricula_Actual->EditValue = $this->Matricula_Actual->CurrentValue;
		$this->Matricula_Actual->PlaceHolder = ew_RemoveHtml($this->Matricula_Actual->FldCaption());

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
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Telefono_Escuela->Exportable) $Doc->ExportCaption($this->Telefono_Escuela);
					if ($this->Mail_Escuela->Exportable) $Doc->ExportCaption($this->Mail_Escuela);
					if ($this->Matricula_Actual->Exportable) $Doc->ExportCaption($this->Matricula_Actual);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Telefono_Escuela->Exportable) $Doc->ExportCaption($this->Telefono_Escuela);
					if ($this->Mail_Escuela->Exportable) $Doc->ExportCaption($this->Mail_Escuela);
					if ($this->Matricula_Actual->Exportable) $Doc->ExportCaption($this->Matricula_Actual);
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
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Telefono_Escuela->Exportable) $Doc->ExportField($this->Telefono_Escuela);
						if ($this->Mail_Escuela->Exportable) $Doc->ExportField($this->Mail_Escuela);
						if ($this->Matricula_Actual->Exportable) $Doc->ExportField($this->Matricula_Actual);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Telefono_Escuela->Exportable) $Doc->ExportField($this->Telefono_Escuela);
						if ($this->Mail_Escuela->Exportable) $Doc->ExportField($this->Mail_Escuela);
						if ($this->Matricula_Actual->Exportable) $Doc->ExportField($this->Matricula_Actual);
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
