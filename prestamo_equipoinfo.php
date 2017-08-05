<?php

// Global variable for table object
$prestamo_equipo = NULL;

//
// Table class for prestamo_equipo
//
class cprestamo_equipo extends cTable {
	var $Id_Prestamo;
	var $Apellidos_Nombres_Beneficiario;
	var $Dni;
	var $NroSerie;
	var $Id_Motivo_Prestamo;
	var $Fecha_Prestamo;
	var $Observacion;
	var $Prestamo_Cargador;
	var $Id_Estado_Prestamo;
	var $Usuario;
	var $Fecha_Actualizacion;
	var $Id_Estado_Devol;
	var $Devuelve_Cargador;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'prestamo_equipo';
		$this->TableName = 'prestamo_equipo';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`prestamo_equipo`";
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

		// Id_Prestamo
		$this->Id_Prestamo = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Id_Prestamo', 'Id_Prestamo', '`Id_Prestamo`', '`Id_Prestamo`', 3, -1, FALSE, '`Id_Prestamo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Id_Prestamo->Sortable = TRUE; // Allow sort
		$this->Id_Prestamo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Prestamo'] = &$this->Id_Prestamo;

		// Apellidos_Nombres_Beneficiario
		$this->Apellidos_Nombres_Beneficiario = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Apellidos_Nombres_Beneficiario', 'Apellidos_Nombres_Beneficiario', '`Apellidos_Nombres_Beneficiario`', '`Apellidos_Nombres_Beneficiario`', 200, -1, FALSE, '`Apellidos_Nombres_Beneficiario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Apellidos_Nombres_Beneficiario->Sortable = TRUE; // Allow sort
		$this->Apellidos_Nombres_Beneficiario->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Apellidos_Nombres_Beneficiario->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Apellidos_Nombres_Beneficiario'] = &$this->Apellidos_Nombres_Beneficiario;

		// Dni
		$this->Dni = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// NroSerie
		$this->NroSerie = new cField('prestamo_equipo', 'prestamo_equipo', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->NroSerie->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->NroSerie->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['NroSerie'] = &$this->NroSerie;

		// Id_Motivo_Prestamo
		$this->Id_Motivo_Prestamo = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Id_Motivo_Prestamo', 'Id_Motivo_Prestamo', '`Id_Motivo_Prestamo`', '`Id_Motivo_Prestamo`', 3, -1, FALSE, '`Id_Motivo_Prestamo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Motivo_Prestamo->Sortable = TRUE; // Allow sort
		$this->Id_Motivo_Prestamo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Motivo_Prestamo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Motivo_Prestamo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Motivo_Prestamo'] = &$this->Id_Motivo_Prestamo;

		// Fecha_Prestamo
		$this->Fecha_Prestamo = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Fecha_Prestamo', 'Fecha_Prestamo', '`Fecha_Prestamo`', 'DATE_FORMAT(`Fecha_Prestamo`, \'\')', 133, 7, FALSE, '`Fecha_Prestamo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Prestamo->Sortable = TRUE; // Allow sort
		$this->Fecha_Prestamo->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Prestamo'] = &$this->Fecha_Prestamo;

		// Observacion
		$this->Observacion = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Observacion', 'Observacion', '`Observacion`', '`Observacion`', 201, -1, FALSE, '`Observacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Observacion->Sortable = TRUE; // Allow sort
		$this->fields['Observacion'] = &$this->Observacion;

		// Prestamo_Cargador
		$this->Prestamo_Cargador = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Prestamo_Cargador', 'Prestamo_Cargador', '`Prestamo_Cargador`', '`Prestamo_Cargador`', 200, -1, FALSE, '`Prestamo_Cargador`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Prestamo_Cargador->Sortable = TRUE; // Allow sort
		$this->Prestamo_Cargador->OptionCount = 2;
		$this->fields['Prestamo_Cargador'] = &$this->Prestamo_Cargador;

		// Id_Estado_Prestamo
		$this->Id_Estado_Prestamo = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Id_Estado_Prestamo', 'Id_Estado_Prestamo', '`Id_Estado_Prestamo`', '`Id_Estado_Prestamo`', 3, -1, FALSE, '`Id_Estado_Prestamo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Prestamo->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Prestamo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Prestamo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Estado_Prestamo'] = &$this->Id_Estado_Prestamo;

		// Usuario
		$this->Usuario = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;

		// Id_Estado_Devol
		$this->Id_Estado_Devol = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Id_Estado_Devol', 'Id_Estado_Devol', '`Id_Estado_Devol`', '`Id_Estado_Devol`', 3, -1, FALSE, '`Id_Estado_Devol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Devol->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Devol->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Devol->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Estado_Devol'] = &$this->Id_Estado_Devol;

		// Devuelve_Cargador
		$this->Devuelve_Cargador = new cField('prestamo_equipo', 'prestamo_equipo', 'x_Devuelve_Cargador', 'Devuelve_Cargador', '`Devuelve_Cargador`', '`Devuelve_Cargador`', 200, -1, FALSE, '`Devuelve_Cargador`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Devuelve_Cargador->Sortable = TRUE; // Allow sort
		$this->Devuelve_Cargador->OptionCount = 3;
		$this->fields['Devuelve_Cargador'] = &$this->Devuelve_Cargador;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`prestamo_equipo`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Id_Prestamo` DESC";
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
			if (array_key_exists('Id_Prestamo', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Prestamo', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Prestamo'], $this->Id_Prestamo->FldDataType, $this->DBID));
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
		return "`Id_Prestamo` = @Id_Prestamo@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Prestamo->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Prestamo@", ew_AdjustSql($this->Id_Prestamo->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "prestamo_equipolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "prestamo_equipolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("prestamo_equipoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("prestamo_equipoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "prestamo_equipoadd.php?" . $this->UrlParm($parm);
		else
			$url = "prestamo_equipoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("prestamo_equipoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("prestamo_equipoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("prestamo_equipodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Prestamo:" . ew_VarToJson($this->Id_Prestamo->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Prestamo->CurrentValue)) {
			$sUrl .= "Id_Prestamo=" . urlencode($this->Id_Prestamo->CurrentValue);
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
			if ($isPost && isset($_POST["Id_Prestamo"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Prestamo"]);
			elseif (isset($_GET["Id_Prestamo"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Prestamo"]);
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
			$this->Id_Prestamo->CurrentValue = $key;
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
		$this->Id_Prestamo->setDbValue($rs->fields('Id_Prestamo'));
		$this->Apellidos_Nombres_Beneficiario->setDbValue($rs->fields('Apellidos_Nombres_Beneficiario'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Id_Motivo_Prestamo->setDbValue($rs->fields('Id_Motivo_Prestamo'));
		$this->Fecha_Prestamo->setDbValue($rs->fields('Fecha_Prestamo'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Prestamo_Cargador->setDbValue($rs->fields('Prestamo_Cargador'));
		$this->Id_Estado_Prestamo->setDbValue($rs->fields('Id_Estado_Prestamo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Id_Estado_Devol->setDbValue($rs->fields('Id_Estado_Devol'));
		$this->Devuelve_Cargador->setDbValue($rs->fields('Devuelve_Cargador'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Prestamo
		// Apellidos_Nombres_Beneficiario
		// Dni
		// NroSerie
		// Id_Motivo_Prestamo
		// Fecha_Prestamo
		// Observacion
		// Prestamo_Cargador
		// Id_Estado_Prestamo
		// Usuario
		// Fecha_Actualizacion
		// Id_Estado_Devol
		// Devuelve_Cargador
		// Id_Prestamo

		$this->Id_Prestamo->ViewValue = $this->Id_Prestamo->CurrentValue;
		$this->Id_Prestamo->ViewCustomAttributes = "";

		// Apellidos_Nombres_Beneficiario
		if (strval($this->Apellidos_Nombres_Beneficiario->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
		$sWhereWrk = "";
		$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`Id_Estado_Espera`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->CurrentValue;
			}
		} else {
			$this->Apellidos_Nombres_Beneficiario->ViewValue = NULL;
		}
		$this->Apellidos_Nombres_Beneficiario->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		$lookuptblfilter = "`Id_Sit_Estado`='3'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// Id_Motivo_Prestamo
		if (strval($this->Id_Motivo_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Motivo_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Prestamo->ViewValue = NULL;
		}
		$this->Id_Motivo_Prestamo->ViewCustomAttributes = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->ViewValue = $this->Fecha_Prestamo->CurrentValue;
		$this->Fecha_Prestamo->ViewValue = ew_FormatDateTime($this->Fecha_Prestamo->ViewValue, 7);
		$this->Fecha_Prestamo->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Prestamo_Cargador
		if (strval($this->Prestamo_Cargador->CurrentValue) <> "") {
			$this->Prestamo_Cargador->ViewValue = $this->Prestamo_Cargador->OptionCaption($this->Prestamo_Cargador->CurrentValue);
		} else {
			$this->Prestamo_Cargador->ViewValue = NULL;
		}
		$this->Prestamo_Cargador->ViewCustomAttributes = "";

		// Id_Estado_Prestamo
		if (strval($this->Id_Estado_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Estado_Prestamo->ViewValue = NULL;
		}
		$this->Id_Estado_Prestamo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Estado_Devol
		if (strval($this->Id_Estado_Devol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_devolucion_prestamo`";
		$sWhereWrk = "";
		$this->Id_Estado_Devol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->CurrentValue;
			}
		} else {
			$this->Id_Estado_Devol->ViewValue = NULL;
		}
		$this->Id_Estado_Devol->ViewCustomAttributes = "";

		// Devuelve_Cargador
		if (strval($this->Devuelve_Cargador->CurrentValue) <> "") {
			$this->Devuelve_Cargador->ViewValue = $this->Devuelve_Cargador->OptionCaption($this->Devuelve_Cargador->CurrentValue);
		} else {
			$this->Devuelve_Cargador->ViewValue = NULL;
		}
		$this->Devuelve_Cargador->ViewCustomAttributes = "";

		// Id_Prestamo
		$this->Id_Prestamo->LinkCustomAttributes = "";
		$this->Id_Prestamo->HrefValue = "";
		$this->Id_Prestamo->TooltipValue = "";

		// Apellidos_Nombres_Beneficiario
		$this->Apellidos_Nombres_Beneficiario->LinkCustomAttributes = "";
		$this->Apellidos_Nombres_Beneficiario->HrefValue = "";
		$this->Apellidos_Nombres_Beneficiario->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// Id_Motivo_Prestamo
		$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
		$this->Id_Motivo_Prestamo->HrefValue = "";
		$this->Id_Motivo_Prestamo->TooltipValue = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->LinkCustomAttributes = "";
		$this->Fecha_Prestamo->HrefValue = "";
		$this->Fecha_Prestamo->TooltipValue = "";

		// Observacion
		$this->Observacion->LinkCustomAttributes = "";
		$this->Observacion->HrefValue = "";
		$this->Observacion->TooltipValue = "";

		// Prestamo_Cargador
		$this->Prestamo_Cargador->LinkCustomAttributes = "";
		$this->Prestamo_Cargador->HrefValue = "";
		$this->Prestamo_Cargador->TooltipValue = "";

		// Id_Estado_Prestamo
		$this->Id_Estado_Prestamo->LinkCustomAttributes = "";
		$this->Id_Estado_Prestamo->HrefValue = "";
		$this->Id_Estado_Prestamo->TooltipValue = "";

		// Usuario
		$this->Usuario->LinkCustomAttributes = "";
		$this->Usuario->HrefValue = "";
		$this->Usuario->TooltipValue = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->LinkCustomAttributes = "";
		$this->Fecha_Actualizacion->HrefValue = "";
		$this->Fecha_Actualizacion->TooltipValue = "";

		// Id_Estado_Devol
		$this->Id_Estado_Devol->LinkCustomAttributes = "";
		$this->Id_Estado_Devol->HrefValue = "";
		$this->Id_Estado_Devol->TooltipValue = "";

		// Devuelve_Cargador
		$this->Devuelve_Cargador->LinkCustomAttributes = "";
		$this->Devuelve_Cargador->HrefValue = "";
		$this->Devuelve_Cargador->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Prestamo
		$this->Id_Prestamo->EditAttrs["class"] = "form-control";
		$this->Id_Prestamo->EditCustomAttributes = "";

		// Apellidos_Nombres_Beneficiario
		$this->Apellidos_Nombres_Beneficiario->EditAttrs["class"] = "form-control";
		$this->Apellidos_Nombres_Beneficiario->EditCustomAttributes = "";

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";

		// Id_Motivo_Prestamo
		$this->Id_Motivo_Prestamo->EditAttrs["class"] = "form-control";
		$this->Id_Motivo_Prestamo->EditCustomAttributes = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->EditAttrs["class"] = "form-control";
		$this->Fecha_Prestamo->EditCustomAttributes = "";
		$this->Fecha_Prestamo->EditValue = ew_FormatDateTime($this->Fecha_Prestamo->CurrentValue, 7);
		$this->Fecha_Prestamo->PlaceHolder = ew_RemoveHtml($this->Fecha_Prestamo->FldCaption());

		// Observacion
		$this->Observacion->EditAttrs["class"] = "form-control";
		$this->Observacion->EditCustomAttributes = "";
		$this->Observacion->EditValue = $this->Observacion->CurrentValue;
		$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

		// Prestamo_Cargador
		$this->Prestamo_Cargador->EditCustomAttributes = "";
		$this->Prestamo_Cargador->EditValue = $this->Prestamo_Cargador->Options(FALSE);

		// Id_Estado_Prestamo
		$this->Id_Estado_Prestamo->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Prestamo->EditCustomAttributes = "";

		// Usuario
		// Fecha_Actualizacion
		// Id_Estado_Devol

		$this->Id_Estado_Devol->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Devol->EditCustomAttributes = "";

		// Devuelve_Cargador
		$this->Devuelve_Cargador->EditCustomAttributes = "";
		$this->Devuelve_Cargador->EditValue = $this->Devuelve_Cargador->Options(FALSE);

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
					if ($this->Id_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Prestamo);
					if ($this->Apellidos_Nombres_Beneficiario->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres_Beneficiario);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Id_Motivo_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Motivo_Prestamo);
					if ($this->Fecha_Prestamo->Exportable) $Doc->ExportCaption($this->Fecha_Prestamo);
					if ($this->Observacion->Exportable) $Doc->ExportCaption($this->Observacion);
					if ($this->Prestamo_Cargador->Exportable) $Doc->ExportCaption($this->Prestamo_Cargador);
					if ($this->Id_Estado_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Estado_Prestamo);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Id_Estado_Devol->Exportable) $Doc->ExportCaption($this->Id_Estado_Devol);
					if ($this->Devuelve_Cargador->Exportable) $Doc->ExportCaption($this->Devuelve_Cargador);
				} else {
					if ($this->Id_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Prestamo);
					if ($this->Apellidos_Nombres_Beneficiario->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres_Beneficiario);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Id_Motivo_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Motivo_Prestamo);
					if ($this->Fecha_Prestamo->Exportable) $Doc->ExportCaption($this->Fecha_Prestamo);
					if ($this->Observacion->Exportable) $Doc->ExportCaption($this->Observacion);
					if ($this->Prestamo_Cargador->Exportable) $Doc->ExportCaption($this->Prestamo_Cargador);
					if ($this->Id_Estado_Prestamo->Exportable) $Doc->ExportCaption($this->Id_Estado_Prestamo);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Id_Estado_Devol->Exportable) $Doc->ExportCaption($this->Id_Estado_Devol);
					if ($this->Devuelve_Cargador->Exportable) $Doc->ExportCaption($this->Devuelve_Cargador);
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
						if ($this->Id_Prestamo->Exportable) $Doc->ExportField($this->Id_Prestamo);
						if ($this->Apellidos_Nombres_Beneficiario->Exportable) $Doc->ExportField($this->Apellidos_Nombres_Beneficiario);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Id_Motivo_Prestamo->Exportable) $Doc->ExportField($this->Id_Motivo_Prestamo);
						if ($this->Fecha_Prestamo->Exportable) $Doc->ExportField($this->Fecha_Prestamo);
						if ($this->Observacion->Exportable) $Doc->ExportField($this->Observacion);
						if ($this->Prestamo_Cargador->Exportable) $Doc->ExportField($this->Prestamo_Cargador);
						if ($this->Id_Estado_Prestamo->Exportable) $Doc->ExportField($this->Id_Estado_Prestamo);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Id_Estado_Devol->Exportable) $Doc->ExportField($this->Id_Estado_Devol);
						if ($this->Devuelve_Cargador->Exportable) $Doc->ExportField($this->Devuelve_Cargador);
					} else {
						if ($this->Id_Prestamo->Exportable) $Doc->ExportField($this->Id_Prestamo);
						if ($this->Apellidos_Nombres_Beneficiario->Exportable) $Doc->ExportField($this->Apellidos_Nombres_Beneficiario);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Id_Motivo_Prestamo->Exportable) $Doc->ExportField($this->Id_Motivo_Prestamo);
						if ($this->Fecha_Prestamo->Exportable) $Doc->ExportField($this->Fecha_Prestamo);
						if ($this->Observacion->Exportable) $Doc->ExportField($this->Observacion);
						if ($this->Prestamo_Cargador->Exportable) $Doc->ExportField($this->Prestamo_Cargador);
						if ($this->Id_Estado_Prestamo->Exportable) $Doc->ExportField($this->Id_Estado_Prestamo);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Id_Estado_Devol->Exportable) $Doc->ExportField($this->Id_Estado_Devol);
						if ($this->Devuelve_Cargador->Exportable) $Doc->ExportField($this->Devuelve_Cargador);
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
		if (preg_match('/^x(\d)*_Apellidos_Nombres_Beneficiario$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Dni` AS FIELD0, `Id_Motivo_Prestamo` AS FIELD1, `Observacion` AS FIELD2 FROM `lista_espera_prestamo`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado_Espera`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Dni->setDbValue($rs->fields[0]);
					$this->Id_Motivo_Prestamo->setDbValue($rs->fields[1]);
					$this->Observacion->setDbValue($rs->fields[2]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Dni->AutoFillOriginalValue) ? $this->Dni->CurrentValue : $this->Dni->EditValue;
					$ar[] = $this->Id_Motivo_Prestamo->CurrentValue;
					$ar[] = ($this->Observacion->AutoFillOriginalValue) ? $this->Observacion->CurrentValue : $this->Observacion->EditValue;
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

	$Dni=$rsnew["Dni"];
	$Serie=$rsnew["NroSerie"];
	$Fecha=ew_CurrentDate();
	$Usuario= CurrentUserName();

	// Get a record as associative array
	// NOTE: Modify your SQL here, replace the table name, field name and the condition

	$consulta = ew_ExecuteRow("SELECT Id_Estado_Prestamo FROM Prestamo_Equipo WHERE Dni=$Dni and Id_Estado_Prestamo='1' order by Id_Prestamo Desc");
	$Estado=$consulta["Id_Estado_Prestamo"];

	//echo '<script language="javascript">alert(',$Estado,');</script>';
	if ($Estado==1){
	echo '<script language="javascript">alert("El beneficiario ingresado ya tiene un prestamo activo");</script>';
	return FALSE;
	}else{
	$MyResult = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=13, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se le presto al alumno con Dni N° $Dni', '$Fecha' ,'$Serie')");
	$MyResult3 = ew_Execute("UPDATE Lista_Espera_Prestamo SET Id_Estado_Espera=2, Fecha_Actualizacion='$Fecha', Usuario='$Usuario' WHERE Dni='$Dni'");
	return TRUE;
	}
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

	$Fecha=ew_CurrentDate();
	$Usuario=CurrentUserName();
	$IdPrestamo=$rsold["Id_Prestamo"];
	$consulta = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Id_Prestamo=$IdPrestamo");
	$Dni=$consulta["Dni"];
	$Serie=$consulta["NroSerie"];
	$Estado=$rsnew["Id_Estado_Prestamo"];
	$EstadoDevolucion=$rsnew["Id_Estado_Devol"];

	//echo '<script language="javascript">alert(',$EstadoDevolucion,');</script>';
	if ($Estado==2){
	if ($EstadoDevolucion==1){
	$MyResult = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=3 WHERE NroSerie='$Serie'");
	$MyResult2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El alumno con Dni N° $Dni devolvió el equipo Funcionando', '$Fecha' ,'$Serie')");
	return TRUE;
	}elseif ($EstadoDevolucion==3){
	echo '<script language="javascript">alert("MODIFIQUE LOS DATOS DE LA DEVOLUCIÓN ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
	$MyResult = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=4 WHERE NroSerie='$Serie'");
	$MyResult2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El alumno con Dni N° $Dni devolvió el equipo Dañado', '$Fecha' ,'$Serie')");
	return TRUE;
	}
	}else{
	$MyResult = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=13, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
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
