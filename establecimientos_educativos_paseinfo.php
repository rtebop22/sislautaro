<?php

// Global variable for table object
$establecimientos_educativos_pase = NULL;

//
// Table class for establecimientos_educativos_pase
//
class cestablecimientos_educativos_pase extends cTable {
	var $Cue_Establecimiento;
	var $Nombre_Establecimiento;
	var $Nombre_Directivo;
	var $Cuil_Directivo;
	var $Nombre_Rte;
	var $Tel_Rte;
	var $Email_Rte;
	var $Nro_Serie_Server_Escolar;
	var $Contacto_Establecimiento;
	var $Domicilio_Escuela;
	var $Id_Provincia;
	var $Id_Departamento;
	var $Id_Localidad;
	var $Fecha_Actualizacion;
	var $Usuario;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'establecimientos_educativos_pase';
		$this->TableName = 'establecimientos_educativos_pase';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`establecimientos_educativos_pase`";
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

		// Cue_Establecimiento
		$this->Cue_Establecimiento = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Cue_Establecimiento', 'Cue_Establecimiento', '`Cue_Establecimiento`', '`Cue_Establecimiento`', 3, -1, FALSE, '`Cue_Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cue_Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Cue_Establecimiento'] = &$this->Cue_Establecimiento;

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Nombre_Establecimiento', 'Nombre_Establecimiento', '`Nombre_Establecimiento`', '`Nombre_Establecimiento`', 200, -1, FALSE, '`Nombre_Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Establecimiento'] = &$this->Nombre_Establecimiento;

		// Nombre_Directivo
		$this->Nombre_Directivo = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Nombre_Directivo', 'Nombre_Directivo', '`Nombre_Directivo`', '`Nombre_Directivo`', 200, -1, FALSE, '`Nombre_Directivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Directivo->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Directivo'] = &$this->Nombre_Directivo;

		// Cuil_Directivo
		$this->Cuil_Directivo = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Cuil_Directivo', 'Cuil_Directivo', '`Cuil_Directivo`', '`Cuil_Directivo`', 200, -1, FALSE, '`Cuil_Directivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil_Directivo->Sortable = TRUE; // Allow sort
		$this->fields['Cuil_Directivo'] = &$this->Cuil_Directivo;

		// Nombre_Rte
		$this->Nombre_Rte = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Nombre_Rte', 'Nombre_Rte', '`Nombre_Rte`', '`Nombre_Rte`', 200, -1, FALSE, '`Nombre_Rte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Rte->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Rte'] = &$this->Nombre_Rte;

		// Tel_Rte
		$this->Tel_Rte = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Tel_Rte', 'Tel_Rte', '`Tel_Rte`', '`Tel_Rte`', 200, -1, FALSE, '`Tel_Rte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Rte->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Rte'] = &$this->Tel_Rte;

		// Email_Rte
		$this->Email_Rte = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Email_Rte', 'Email_Rte', '`Email_Rte`', '`Email_Rte`', 200, -1, FALSE, '`Email_Rte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Email_Rte->Sortable = TRUE; // Allow sort
		$this->Email_Rte->FldDefaultErrMsg = $Language->Phrase("IncorrectEmail");
		$this->fields['Email_Rte'] = &$this->Email_Rte;

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Nro_Serie_Server_Escolar', 'Nro_Serie_Server_Escolar', '`Nro_Serie_Server_Escolar`', '`Nro_Serie_Server_Escolar`', 200, -1, FALSE, '`Nro_Serie_Server_Escolar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Serie_Server_Escolar->Sortable = TRUE; // Allow sort
		$this->fields['Nro_Serie_Server_Escolar'] = &$this->Nro_Serie_Server_Escolar;

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Contacto_Establecimiento', 'Contacto_Establecimiento', '`Contacto_Establecimiento`', '`Contacto_Establecimiento`', 200, -1, FALSE, '`Contacto_Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Contacto_Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Contacto_Establecimiento'] = &$this->Contacto_Establecimiento;

		// Domicilio_Escuela
		$this->Domicilio_Escuela = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Domicilio_Escuela', 'Domicilio_Escuela', '`Domicilio_Escuela`', '`Domicilio_Escuela`', 200, -1, FALSE, '`Domicilio_Escuela`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio_Escuela->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio_Escuela'] = &$this->Domicilio_Escuela;

		// Id_Provincia
		$this->Id_Provincia = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Id_Provincia', 'Id_Provincia', '`Id_Provincia`', '`Id_Provincia`', 3, -1, FALSE, '`Id_Provincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Provincia->Sortable = TRUE; // Allow sort
		$this->Id_Provincia->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Provincia->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Provincia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Provincia'] = &$this->Id_Provincia;

		// Id_Departamento
		$this->Id_Departamento = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Id_Departamento', 'Id_Departamento', '`Id_Departamento`', '`Id_Departamento`', 3, -1, FALSE, '`Id_Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Departamento->Sortable = TRUE; // Allow sort
		$this->Id_Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Departamento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Departamento'] = &$this->Id_Departamento;

		// Id_Localidad
		$this->Id_Localidad = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Id_Localidad', 'Id_Localidad', '`Id_Localidad`', '`Id_Localidad`', 3, -1, FALSE, '`Id_Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Localidad->Sortable = TRUE; // Allow sort
		$this->Id_Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Localidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Localidad'] = &$this->Id_Localidad;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 0, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;

		// Usuario
		$this->Usuario = new cField('establecimientos_educativos_pase', 'establecimientos_educativos_pase', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`establecimientos_educativos_pase`";
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
			if (array_key_exists('Cue_Establecimiento', $rs))
				ew_AddFilter($where, ew_QuotedName('Cue_Establecimiento', $this->DBID) . '=' . ew_QuotedValue($rs['Cue_Establecimiento'], $this->Cue_Establecimiento->FldDataType, $this->DBID));
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
		return "`Cue_Establecimiento` = @Cue_Establecimiento@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Cue_Establecimiento->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Cue_Establecimiento@", ew_AdjustSql($this->Cue_Establecimiento->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "establecimientos_educativos_paselist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "establecimientos_educativos_paselist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("establecimientos_educativos_paseview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("establecimientos_educativos_paseview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "establecimientos_educativos_paseadd.php?" . $this->UrlParm($parm);
		else
			$url = "establecimientos_educativos_paseadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("establecimientos_educativos_paseedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("establecimientos_educativos_paseadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("establecimientos_educativos_pasedelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Cue_Establecimiento:" . ew_VarToJson($this->Cue_Establecimiento->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Cue_Establecimiento->CurrentValue)) {
			$sUrl .= "Cue_Establecimiento=" . urlencode($this->Cue_Establecimiento->CurrentValue);
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
			if ($isPost && isset($_POST["Cue_Establecimiento"]))
				$arKeys[] = ew_StripSlashes($_POST["Cue_Establecimiento"]);
			elseif (isset($_GET["Cue_Establecimiento"]))
				$arKeys[] = ew_StripSlashes($_GET["Cue_Establecimiento"]);
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
			$this->Cue_Establecimiento->CurrentValue = $key;
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
		$this->Cue_Establecimiento->setDbValue($rs->fields('Cue_Establecimiento'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Nombre_Directivo->setDbValue($rs->fields('Nombre_Directivo'));
		$this->Cuil_Directivo->setDbValue($rs->fields('Cuil_Directivo'));
		$this->Nombre_Rte->setDbValue($rs->fields('Nombre_Rte'));
		$this->Tel_Rte->setDbValue($rs->fields('Tel_Rte'));
		$this->Email_Rte->setDbValue($rs->fields('Email_Rte'));
		$this->Nro_Serie_Server_Escolar->setDbValue($rs->fields('Nro_Serie_Server_Escolar'));
		$this->Contacto_Establecimiento->setDbValue($rs->fields('Contacto_Establecimiento'));
		$this->Domicilio_Escuela->setDbValue($rs->fields('Domicilio_Escuela'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Cue_Establecimiento
		// Nombre_Establecimiento
		// Nombre_Directivo

		$this->Nombre_Directivo->CellCssStyle = "white-space: nowrap;";

		// Cuil_Directivo
		$this->Cuil_Directivo->CellCssStyle = "white-space: nowrap;";

		// Nombre_Rte
		// Tel_Rte
		// Email_Rte
		// Nro_Serie_Server_Escolar
		// Contacto_Establecimiento
		// Domicilio_Escuela
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// Usuario
		// Cue_Establecimiento

		$this->Cue_Establecimiento->ViewValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Cue_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Directivo
		$this->Nombre_Directivo->ViewValue = $this->Nombre_Directivo->CurrentValue;
		$this->Nombre_Directivo->ViewCustomAttributes = "";

		// Cuil_Directivo
		$this->Cuil_Directivo->ViewValue = $this->Cuil_Directivo->CurrentValue;
		$this->Cuil_Directivo->ViewCustomAttributes = "";

		// Nombre_Rte
		$this->Nombre_Rte->ViewValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->ViewCustomAttributes = "";

		// Tel_Rte
		$this->Tel_Rte->ViewValue = $this->Tel_Rte->CurrentValue;
		$this->Tel_Rte->ViewCustomAttributes = "";

		// Email_Rte
		$this->Email_Rte->ViewValue = $this->Email_Rte->CurrentValue;
		$this->Email_Rte->ViewCustomAttributes = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->ViewValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->ViewCustomAttributes = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->ViewValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->ViewCustomAttributes = "";

		// Domicilio_Escuela
		$this->Domicilio_Escuela->ViewValue = $this->Domicilio_Escuela->CurrentValue;
		$this->Domicilio_Escuela->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->CurrentValue;
			}
		} else {
			$this->Id_Provincia->ViewValue = NULL;
		}
		$this->Id_Provincia->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Cue_Establecimiento
		$this->Cue_Establecimiento->LinkCustomAttributes = "";
		$this->Cue_Establecimiento->HrefValue = "";
		$this->Cue_Establecimiento->TooltipValue = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->LinkCustomAttributes = "";
		$this->Nombre_Establecimiento->HrefValue = "";
		$this->Nombre_Establecimiento->TooltipValue = "";

		// Nombre_Directivo
		$this->Nombre_Directivo->LinkCustomAttributes = "";
		$this->Nombre_Directivo->HrefValue = "";
		$this->Nombre_Directivo->TooltipValue = "";

		// Cuil_Directivo
		$this->Cuil_Directivo->LinkCustomAttributes = "";
		$this->Cuil_Directivo->HrefValue = "";
		$this->Cuil_Directivo->TooltipValue = "";

		// Nombre_Rte
		$this->Nombre_Rte->LinkCustomAttributes = "";
		$this->Nombre_Rte->HrefValue = "";
		$this->Nombre_Rte->TooltipValue = "";

		// Tel_Rte
		$this->Tel_Rte->LinkCustomAttributes = "";
		$this->Tel_Rte->HrefValue = "";
		$this->Tel_Rte->TooltipValue = "";

		// Email_Rte
		$this->Email_Rte->LinkCustomAttributes = "";
		$this->Email_Rte->HrefValue = "";
		$this->Email_Rte->TooltipValue = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
		$this->Nro_Serie_Server_Escolar->HrefValue = "";
		$this->Nro_Serie_Server_Escolar->TooltipValue = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->LinkCustomAttributes = "";
		$this->Contacto_Establecimiento->HrefValue = "";
		$this->Contacto_Establecimiento->TooltipValue = "";

		// Domicilio_Escuela
		$this->Domicilio_Escuela->LinkCustomAttributes = "";
		$this->Domicilio_Escuela->HrefValue = "";
		$this->Domicilio_Escuela->TooltipValue = "";

		// Id_Provincia
		$this->Id_Provincia->LinkCustomAttributes = "";
		$this->Id_Provincia->HrefValue = "";
		$this->Id_Provincia->TooltipValue = "";

		// Id_Departamento
		$this->Id_Departamento->LinkCustomAttributes = "";
		$this->Id_Departamento->HrefValue = "";
		$this->Id_Departamento->TooltipValue = "";

		// Id_Localidad
		$this->Id_Localidad->LinkCustomAttributes = "";
		$this->Id_Localidad->HrefValue = "";
		$this->Id_Localidad->TooltipValue = "";

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

		// Cue_Establecimiento
		$this->Cue_Establecimiento->EditAttrs["class"] = "form-control";
		$this->Cue_Establecimiento->EditCustomAttributes = "";
		$this->Cue_Establecimiento->EditValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Cue_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
		$this->Nombre_Establecimiento->EditCustomAttributes = "";
		$this->Nombre_Establecimiento->EditValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

		// Nombre_Directivo
		$this->Nombre_Directivo->EditAttrs["class"] = "form-control";
		$this->Nombre_Directivo->EditCustomAttributes = "";
		$this->Nombre_Directivo->EditValue = $this->Nombre_Directivo->CurrentValue;
		$this->Nombre_Directivo->PlaceHolder = ew_RemoveHtml($this->Nombre_Directivo->FldCaption());

		// Cuil_Directivo
		$this->Cuil_Directivo->EditAttrs["class"] = "form-control";
		$this->Cuil_Directivo->EditCustomAttributes = "";
		$this->Cuil_Directivo->EditValue = $this->Cuil_Directivo->CurrentValue;
		$this->Cuil_Directivo->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo->FldCaption());

		// Nombre_Rte
		$this->Nombre_Rte->EditAttrs["class"] = "form-control";
		$this->Nombre_Rte->EditCustomAttributes = "";
		$this->Nombre_Rte->EditValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->PlaceHolder = ew_RemoveHtml($this->Nombre_Rte->FldCaption());

		// Tel_Rte
		$this->Tel_Rte->EditAttrs["class"] = "form-control";
		$this->Tel_Rte->EditCustomAttributes = "";
		$this->Tel_Rte->EditValue = $this->Tel_Rte->CurrentValue;
		$this->Tel_Rte->PlaceHolder = ew_RemoveHtml($this->Tel_Rte->FldCaption());

		// Email_Rte
		$this->Email_Rte->EditAttrs["class"] = "form-control";
		$this->Email_Rte->EditCustomAttributes = "";
		$this->Email_Rte->EditValue = $this->Email_Rte->CurrentValue;
		$this->Email_Rte->PlaceHolder = ew_RemoveHtml($this->Email_Rte->FldCaption());

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->EditAttrs["class"] = "form-control";
		$this->Nro_Serie_Server_Escolar->EditCustomAttributes = "";
		$this->Nro_Serie_Server_Escolar->EditValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->PlaceHolder = ew_RemoveHtml($this->Nro_Serie_Server_Escolar->FldCaption());

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->EditAttrs["class"] = "form-control";
		$this->Contacto_Establecimiento->EditCustomAttributes = "";
		$this->Contacto_Establecimiento->EditValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Contacto_Establecimiento->FldCaption());

		// Domicilio_Escuela
		$this->Domicilio_Escuela->EditAttrs["class"] = "form-control";
		$this->Domicilio_Escuela->EditCustomAttributes = "";
		$this->Domicilio_Escuela->EditValue = $this->Domicilio_Escuela->CurrentValue;
		$this->Domicilio_Escuela->PlaceHolder = ew_RemoveHtml($this->Domicilio_Escuela->FldCaption());

		// Id_Provincia
		$this->Id_Provincia->EditAttrs["class"] = "form-control";
		$this->Id_Provincia->EditCustomAttributes = "";

		// Id_Departamento
		$this->Id_Departamento->EditAttrs["class"] = "form-control";
		$this->Id_Departamento->EditCustomAttributes = "";

		// Id_Localidad
		$this->Id_Localidad->EditAttrs["class"] = "form-control";
		$this->Id_Localidad->EditCustomAttributes = "";

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
					if ($this->Cue_Establecimiento->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento);
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Nombre_Directivo->Exportable) $Doc->ExportCaption($this->Nombre_Directivo);
					if ($this->Cuil_Directivo->Exportable) $Doc->ExportCaption($this->Cuil_Directivo);
					if ($this->Nombre_Rte->Exportable) $Doc->ExportCaption($this->Nombre_Rte);
					if ($this->Tel_Rte->Exportable) $Doc->ExportCaption($this->Tel_Rte);
					if ($this->Email_Rte->Exportable) $Doc->ExportCaption($this->Email_Rte);
					if ($this->Nro_Serie_Server_Escolar->Exportable) $Doc->ExportCaption($this->Nro_Serie_Server_Escolar);
					if ($this->Contacto_Establecimiento->Exportable) $Doc->ExportCaption($this->Contacto_Establecimiento);
					if ($this->Domicilio_Escuela->Exportable) $Doc->ExportCaption($this->Domicilio_Escuela);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
				} else {
					if ($this->Cue_Establecimiento->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento);
					if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportCaption($this->Nombre_Establecimiento);
					if ($this->Nombre_Directivo->Exportable) $Doc->ExportCaption($this->Nombre_Directivo);
					if ($this->Cuil_Directivo->Exportable) $Doc->ExportCaption($this->Cuil_Directivo);
					if ($this->Nombre_Rte->Exportable) $Doc->ExportCaption($this->Nombre_Rte);
					if ($this->Tel_Rte->Exportable) $Doc->ExportCaption($this->Tel_Rte);
					if ($this->Email_Rte->Exportable) $Doc->ExportCaption($this->Email_Rte);
					if ($this->Nro_Serie_Server_Escolar->Exportable) $Doc->ExportCaption($this->Nro_Serie_Server_Escolar);
					if ($this->Contacto_Establecimiento->Exportable) $Doc->ExportCaption($this->Contacto_Establecimiento);
					if ($this->Domicilio_Escuela->Exportable) $Doc->ExportCaption($this->Domicilio_Escuela);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
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
						if ($this->Cue_Establecimiento->Exportable) $Doc->ExportField($this->Cue_Establecimiento);
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Nombre_Directivo->Exportable) $Doc->ExportField($this->Nombre_Directivo);
						if ($this->Cuil_Directivo->Exportable) $Doc->ExportField($this->Cuil_Directivo);
						if ($this->Nombre_Rte->Exportable) $Doc->ExportField($this->Nombre_Rte);
						if ($this->Tel_Rte->Exportable) $Doc->ExportField($this->Tel_Rte);
						if ($this->Email_Rte->Exportable) $Doc->ExportField($this->Email_Rte);
						if ($this->Nro_Serie_Server_Escolar->Exportable) $Doc->ExportField($this->Nro_Serie_Server_Escolar);
						if ($this->Contacto_Establecimiento->Exportable) $Doc->ExportField($this->Contacto_Establecimiento);
						if ($this->Domicilio_Escuela->Exportable) $Doc->ExportField($this->Domicilio_Escuela);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
					} else {
						if ($this->Cue_Establecimiento->Exportable) $Doc->ExportField($this->Cue_Establecimiento);
						if ($this->Nombre_Establecimiento->Exportable) $Doc->ExportField($this->Nombre_Establecimiento);
						if ($this->Nombre_Directivo->Exportable) $Doc->ExportField($this->Nombre_Directivo);
						if ($this->Cuil_Directivo->Exportable) $Doc->ExportField($this->Cuil_Directivo);
						if ($this->Nombre_Rte->Exportable) $Doc->ExportField($this->Nombre_Rte);
						if ($this->Tel_Rte->Exportable) $Doc->ExportField($this->Tel_Rte);
						if ($this->Email_Rte->Exportable) $Doc->ExportField($this->Email_Rte);
						if ($this->Nro_Serie_Server_Escolar->Exportable) $Doc->ExportField($this->Nro_Serie_Server_Escolar);
						if ($this->Contacto_Establecimiento->Exportable) $Doc->ExportField($this->Contacto_Establecimiento);
						if ($this->Domicilio_Escuela->Exportable) $Doc->ExportField($this->Domicilio_Escuela);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
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
