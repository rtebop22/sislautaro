<?php

// Global variable for table object
$reasignacion_equipo = NULL;

//
// Table class for reasignacion_equipo
//
class creasignacion_equipo extends cTable {
	var $Id_Reasignacion;
	var $Titular_Original;
	var $Dni;
	var $NroSerie;
	var $Nuevo_Titular;
	var $Dni_Nuevo_Tit;
	var $Id_Motivo_Reasig;
	var $Observacion;
	var $Fecha_Reasignacion;
	var $Usuario;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'reasignacion_equipo';
		$this->TableName = 'reasignacion_equipo';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`reasignacion_equipo`";
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

		// Id_Reasignacion
		$this->Id_Reasignacion = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Id_Reasignacion', 'Id_Reasignacion', '`Id_Reasignacion`', '`Id_Reasignacion`', 3, -1, FALSE, '`Id_Reasignacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Reasignacion->Sortable = TRUE; // Allow sort
		$this->fields['Id_Reasignacion'] = &$this->Id_Reasignacion;

		// Titular_Original
		$this->Titular_Original = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Titular_Original', 'Titular_Original', '`Titular_Original`', '`Titular_Original`', 200, -1, FALSE, '`Titular_Original`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Titular_Original->Sortable = TRUE; // Allow sort
		$this->fields['Titular_Original'] = &$this->Titular_Original;

		// Dni
		$this->Dni = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// NroSerie
		$this->NroSerie = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// Nuevo_Titular
		$this->Nuevo_Titular = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Nuevo_Titular', 'Nuevo_Titular', '`Nuevo_Titular`', '`Nuevo_Titular`', 200, -1, FALSE, '`Nuevo_Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nuevo_Titular->Sortable = TRUE; // Allow sort
		$this->fields['Nuevo_Titular'] = &$this->Nuevo_Titular;

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Dni_Nuevo_Tit', 'Dni_Nuevo_Tit', '`Dni_Nuevo_Tit`', '`Dni_Nuevo_Tit`', 3, -1, FALSE, '`Dni_Nuevo_Tit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Nuevo_Tit->Sortable = TRUE; // Allow sort
		$this->Dni_Nuevo_Tit->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni_Nuevo_Tit'] = &$this->Dni_Nuevo_Tit;

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Id_Motivo_Reasig', 'Id_Motivo_Reasig', '`Id_Motivo_Reasig`', '`Id_Motivo_Reasig`', 3, -1, FALSE, '`Id_Motivo_Reasig`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Motivo_Reasig->Sortable = TRUE; // Allow sort
		$this->Id_Motivo_Reasig->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Motivo_Reasig->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Motivo_Reasig'] = &$this->Id_Motivo_Reasig;

		// Observacion
		$this->Observacion = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Observacion', 'Observacion', '`Observacion`', '`Observacion`', 201, -1, FALSE, '`Observacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Observacion->Sortable = TRUE; // Allow sort
		$this->fields['Observacion'] = &$this->Observacion;

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Fecha_Reasignacion', 'Fecha_Reasignacion', '`Fecha_Reasignacion`', 'DATE_FORMAT(`Fecha_Reasignacion`, \'\')', 133, 7, FALSE, '`Fecha_Reasignacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Reasignacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Reasignacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Reasignacion'] = &$this->Fecha_Reasignacion;

		// Usuario
		$this->Usuario = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('reasignacion_equipo', 'reasignacion_equipo', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 0, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`reasignacion_equipo`";
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
			if (array_key_exists('Id_Reasignacion', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Reasignacion', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Reasignacion'], $this->Id_Reasignacion->FldDataType, $this->DBID));
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
		return "`Id_Reasignacion` = @Id_Reasignacion@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Reasignacion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Reasignacion@", ew_AdjustSql($this->Id_Reasignacion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "reasignacion_equipolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "reasignacion_equipolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("reasignacion_equipoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("reasignacion_equipoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "reasignacion_equipoadd.php?" . $this->UrlParm($parm);
		else
			$url = "reasignacion_equipoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("reasignacion_equipoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("reasignacion_equipoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("reasignacion_equipodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Reasignacion:" . ew_VarToJson($this->Id_Reasignacion->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Reasignacion->CurrentValue)) {
			$sUrl .= "Id_Reasignacion=" . urlencode($this->Id_Reasignacion->CurrentValue);
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
			if ($isPost && isset($_POST["Id_Reasignacion"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Reasignacion"]);
			elseif (isset($_GET["Id_Reasignacion"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Reasignacion"]);
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
			$this->Id_Reasignacion->CurrentValue = $key;
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
		$this->Id_Reasignacion->setDbValue($rs->fields('Id_Reasignacion'));
		$this->Titular_Original->setDbValue($rs->fields('Titular_Original'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Nuevo_Titular->setDbValue($rs->fields('Nuevo_Titular'));
		$this->Dni_Nuevo_Tit->setDbValue($rs->fields('Dni_Nuevo_Tit'));
		$this->Id_Motivo_Reasig->setDbValue($rs->fields('Id_Motivo_Reasig'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Reasignacion->setDbValue($rs->fields('Fecha_Reasignacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Reasignacion
		// Titular_Original
		// Dni
		// NroSerie
		// Nuevo_Titular
		// Dni_Nuevo_Tit
		// Id_Motivo_Reasig
		// Observacion
		// Fecha_Reasignacion
		// Usuario
		// Fecha_Actualizacion
		// Id_Reasignacion

		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Titular_Original
		$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
		if (strval($this->Titular_Original->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Titular_Original->ViewValue = $this->Titular_Original->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
			}
		} else {
			$this->Titular_Original->ViewValue = NULL;
		}
		$this->Titular_Original->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
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

		// Nuevo_Titular
		$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
		if (strval($this->Nuevo_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`NroSerie`='0'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
			}
		} else {
			$this->Nuevo_Titular->ViewValue = NULL;
		}
		$this->Nuevo_Titular->ViewCustomAttributes = "";

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->ViewValue = $this->Dni_Nuevo_Tit->CurrentValue;
		$this->Dni_Nuevo_Tit->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		if (strval($this->Id_Motivo_Reasig->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
		$sWhereWrk = "";
		$this->Id_Motivo_Reasig->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Reasig->ViewValue = NULL;
		}
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewValue = ew_FormatDateTime($this->Fecha_Reasignacion->ViewValue, 7);
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Reasignacion
		$this->Id_Reasignacion->LinkCustomAttributes = "";
		$this->Id_Reasignacion->HrefValue = "";
		$this->Id_Reasignacion->TooltipValue = "";

		// Titular_Original
		$this->Titular_Original->LinkCustomAttributes = "";
		$this->Titular_Original->HrefValue = "";
		$this->Titular_Original->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// Nuevo_Titular
		$this->Nuevo_Titular->LinkCustomAttributes = "";
		$this->Nuevo_Titular->HrefValue = "";
		$this->Nuevo_Titular->TooltipValue = "";

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->LinkCustomAttributes = "";
		$this->Dni_Nuevo_Tit->HrefValue = "";
		$this->Dni_Nuevo_Tit->TooltipValue = "";

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
		$this->Id_Motivo_Reasig->HrefValue = "";
		$this->Id_Motivo_Reasig->TooltipValue = "";

		// Observacion
		$this->Observacion->LinkCustomAttributes = "";
		$this->Observacion->HrefValue = "";
		$this->Observacion->TooltipValue = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->LinkCustomAttributes = "";
		$this->Fecha_Reasignacion->HrefValue = "";
		$this->Fecha_Reasignacion->TooltipValue = "";

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

		// Id_Reasignacion
		$this->Id_Reasignacion->EditAttrs["class"] = "form-control";
		$this->Id_Reasignacion->EditCustomAttributes = "";
		$this->Id_Reasignacion->EditValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Titular_Original
		$this->Titular_Original->EditAttrs["class"] = "form-control";
		$this->Titular_Original->EditCustomAttributes = "";
		$this->Titular_Original->EditValue = $this->Titular_Original->CurrentValue;
		$this->Titular_Original->PlaceHolder = ew_RemoveHtml($this->Titular_Original->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

		// Nuevo_Titular
		$this->Nuevo_Titular->EditAttrs["class"] = "form-control";
		$this->Nuevo_Titular->EditCustomAttributes = "";
		$this->Nuevo_Titular->EditValue = $this->Nuevo_Titular->CurrentValue;
		$this->Nuevo_Titular->PlaceHolder = ew_RemoveHtml($this->Nuevo_Titular->FldCaption());

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->EditAttrs["class"] = "form-control";
		$this->Dni_Nuevo_Tit->EditCustomAttributes = "";
		$this->Dni_Nuevo_Tit->EditValue = $this->Dni_Nuevo_Tit->CurrentValue;
		$this->Dni_Nuevo_Tit->PlaceHolder = ew_RemoveHtml($this->Dni_Nuevo_Tit->FldCaption());

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->EditAttrs["class"] = "form-control";
		$this->Id_Motivo_Reasig->EditCustomAttributes = "";

		// Observacion
		$this->Observacion->EditAttrs["class"] = "form-control";
		$this->Observacion->EditCustomAttributes = "";
		$this->Observacion->EditValue = $this->Observacion->CurrentValue;
		$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->EditAttrs["class"] = "form-control";
		$this->Fecha_Reasignacion->EditCustomAttributes = "";
		$this->Fecha_Reasignacion->EditValue = ew_FormatDateTime($this->Fecha_Reasignacion->CurrentValue, 7);
		$this->Fecha_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Reasignacion->FldCaption());

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
					if ($this->Id_Reasignacion->Exportable) $Doc->ExportCaption($this->Id_Reasignacion);
					if ($this->Titular_Original->Exportable) $Doc->ExportCaption($this->Titular_Original);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Nuevo_Titular->Exportable) $Doc->ExportCaption($this->Nuevo_Titular);
					if ($this->Dni_Nuevo_Tit->Exportable) $Doc->ExportCaption($this->Dni_Nuevo_Tit);
					if ($this->Id_Motivo_Reasig->Exportable) $Doc->ExportCaption($this->Id_Motivo_Reasig);
					if ($this->Observacion->Exportable) $Doc->ExportCaption($this->Observacion);
					if ($this->Fecha_Reasignacion->Exportable) $Doc->ExportCaption($this->Fecha_Reasignacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->Id_Reasignacion->Exportable) $Doc->ExportCaption($this->Id_Reasignacion);
					if ($this->Titular_Original->Exportable) $Doc->ExportCaption($this->Titular_Original);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Nuevo_Titular->Exportable) $Doc->ExportCaption($this->Nuevo_Titular);
					if ($this->Dni_Nuevo_Tit->Exportable) $Doc->ExportCaption($this->Dni_Nuevo_Tit);
					if ($this->Id_Motivo_Reasig->Exportable) $Doc->ExportCaption($this->Id_Motivo_Reasig);
					if ($this->Fecha_Reasignacion->Exportable) $Doc->ExportCaption($this->Fecha_Reasignacion);
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
						if ($this->Id_Reasignacion->Exportable) $Doc->ExportField($this->Id_Reasignacion);
						if ($this->Titular_Original->Exportable) $Doc->ExportField($this->Titular_Original);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Nuevo_Titular->Exportable) $Doc->ExportField($this->Nuevo_Titular);
						if ($this->Dni_Nuevo_Tit->Exportable) $Doc->ExportField($this->Dni_Nuevo_Tit);
						if ($this->Id_Motivo_Reasig->Exportable) $Doc->ExportField($this->Id_Motivo_Reasig);
						if ($this->Observacion->Exportable) $Doc->ExportField($this->Observacion);
						if ($this->Fecha_Reasignacion->Exportable) $Doc->ExportField($this->Fecha_Reasignacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->Id_Reasignacion->Exportable) $Doc->ExportField($this->Id_Reasignacion);
						if ($this->Titular_Original->Exportable) $Doc->ExportField($this->Titular_Original);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Nuevo_Titular->Exportable) $Doc->ExportField($this->Nuevo_Titular);
						if ($this->Dni_Nuevo_Tit->Exportable) $Doc->ExportField($this->Dni_Nuevo_Tit);
						if ($this->Id_Motivo_Reasig->Exportable) $Doc->ExportField($this->Id_Motivo_Reasig);
						if ($this->Fecha_Reasignacion->Exportable) $Doc->ExportField($this->Fecha_Reasignacion);
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
		if (preg_match('/^x(\d)*_Titular_Original$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Dni` AS FIELD0, `NroSerie` AS FIELD1 FROM `personas`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_MEMO, $this->DBID) . ")";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Dni->setDbValue($rs->fields[0]);
					$this->NroSerie->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Dni->AutoFillOriginalValue) ? $this->Dni->CurrentValue : $this->Dni->EditValue;
					$ar[] = ($this->NroSerie->AutoFillOriginalValue) ? $this->NroSerie->CurrentValue : $this->NroSerie->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Nuevo_Titular$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Dni` AS FIELD0 FROM `personas`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_MEMO, $this->DBID) . ")";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Dni_Nuevo_Tit->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Dni_Nuevo_Tit->AutoFillOriginalValue) ? $this->Dni_Nuevo_Tit->CurrentValue : $this->Dni_Nuevo_Tit->EditValue;
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
	$DniTitOrig=$rsnew["Dni"];
	$DniNuevoTit=$rsnew["Dni_Nuevo_Tit"];
	$Fecha=ew_CurrentDate();
	$Serie=$rsnew["NroSerie"];
	$usuario=CurrentUserName();
	$consulta = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Dni=$DniNuevoTit");
	$Estado=$consulta["Id_Estado_Prestamo"];
	if ($Estado==1){
	echo '<script language="javascript">alert("EL ALUMNO ACTUAL POSEE UN PRESTAMO EN CURSO, VERIFIQUE LOS PRESTAMOS ACTIVOS ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
		$consultaReasig = ew_ExecuteRow("SELECT * FROM Reasignacion_Equipo WHERE Dni_Nuevo_Tit=$DniNuevoTit and NroSerie='$Serie'");
		$ExisteReasig=$consultaReasig["Id_Reasignacion"];
		if ($ExisteReasig==""){
			$consultaEquipo = ew_ExecuteRow("SELECT NroSerie FROM Personas WHERE Dni=$DniNuevoTit");
			$TieneEquipo=$consultaEquipo["NroSerie"];
			if ($TieneEquipo=="" or $TieneEquipo=="0"){
			$titular=$rsnew["Titular_Original"];
			$nuevoTitular=$rsnew["Nuevo_Titular"];
			$sql1 = ew_Execute("UPDATE Personas SET NroSerie='$Serie', Fecha_Actualizacion='$Fecha', Usuario='$usuario' WHERE Dni=$DniNuevoTit");
			$sql2 = ew_Execute("UPDATE Personas SET NroSerie='0', Fecha_Actualizacion='$Fecha', Usuario='$usuario' WHERE Dni=$DniTitOrig");
			$sql3 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo actual cuyo Titutal era: $titular DNI N° $Dni ha sido reasignado al alumno: $nuevoTitular Dni N° $DniNuevoTit', '$Fecha' ,'$Serie')");
			$sql4 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
			return TRUE;
			}else{
				echo '<script language="javascript">alert("EL ALUMNO ACTUAL YA TIENE UN EQUIPO ASIGNADO ACTUALMENTE, REALICE LA MODIFICACIÓN ANTES DE CONTINUAR");</script>';
				return FALSE;}}
		else{
		echo '<script language="javascript">alert("YA EXISTE UNA REASIGNACION CON EL NUEVO TITULAR Y EL EQUIPO A REASIGNAR");</script>';
		return FALSE;}
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
