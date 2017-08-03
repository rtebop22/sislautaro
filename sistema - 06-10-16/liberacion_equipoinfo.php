<?php

// Global variable for table object
$liberacion_equipo = NULL;

//
// Table class for liberacion_equipo
//
class cliberacion_equipo extends cTable {
	var $Dni;
	var $NroSerie;
	var $Dni_Tutor;
	var $Fecha_Finalizacion;
	var $Observacion;
	var $Id_Modalidad;
	var $Id_Nivel;
	var $Id_Autoridad;
	var $Fecha_Liberacion;
	var $Ruta_Archivo_Copia_Titulo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'liberacion_equipo';
		$this->TableName = 'liberacion_equipo';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`liberacion_equipo`";
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
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Dni
		$this->Dni = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// NroSerie
		$this->NroSerie = new cField('liberacion_equipo', 'liberacion_equipo', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// Dni_Tutor
		$this->Dni_Tutor = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Dni_Tutor', 'Dni_Tutor', '`Dni_Tutor`', '`Dni_Tutor`', 3, -1, FALSE, '`Dni_Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Dni_Tutor'] = &$this->Dni_Tutor;

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Fecha_Finalizacion', 'Fecha_Finalizacion', '`Fecha_Finalizacion`', '`Fecha_Finalizacion`', 200, 7, FALSE, '`Fecha_Finalizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Finalizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Finalizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Finalizacion'] = &$this->Fecha_Finalizacion;

		// Observacion
		$this->Observacion = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Observacion', 'Observacion', '`Observacion`', '`Observacion`', 201, -1, FALSE, '`Observacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Observacion->Sortable = TRUE; // Allow sort
		$this->fields['Observacion'] = &$this->Observacion;

		// Id_Modalidad
		$this->Id_Modalidad = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Id_Modalidad', 'Id_Modalidad', '`Id_Modalidad`', '`Id_Modalidad`', 3, -1, FALSE, '`Id_Modalidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Modalidad->Sortable = TRUE; // Allow sort
		$this->Id_Modalidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Modalidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Modalidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Modalidad'] = &$this->Id_Modalidad;

		// Id_Nivel
		$this->Id_Nivel = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Id_Nivel', 'Id_Nivel', '`Id_Nivel`', '`Id_Nivel`', 3, -1, FALSE, '`Id_Nivel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Nivel->Sortable = TRUE; // Allow sort
		$this->Id_Nivel->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Nivel->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Nivel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Nivel'] = &$this->Id_Nivel;

		// Id_Autoridad
		$this->Id_Autoridad = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Id_Autoridad', 'Id_Autoridad', '`Id_Autoridad`', '`Id_Autoridad`', 3, -1, FALSE, '`Id_Autoridad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Autoridad->Sortable = TRUE; // Allow sort
		$this->Id_Autoridad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Autoridad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Autoridad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Autoridad'] = &$this->Id_Autoridad;

		// Fecha_Liberacion
		$this->Fecha_Liberacion = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Fecha_Liberacion', 'Fecha_Liberacion', '`Fecha_Liberacion`', '`Fecha_Liberacion`', 200, 7, FALSE, '`Fecha_Liberacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Liberacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Liberacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Liberacion'] = &$this->Fecha_Liberacion;

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo = new cField('liberacion_equipo', 'liberacion_equipo', 'x_Ruta_Archivo_Copia_Titulo', 'Ruta_Archivo_Copia_Titulo', '`Ruta_Archivo_Copia_Titulo`', '`Ruta_Archivo_Copia_Titulo`', 200, -1, TRUE, '`Ruta_Archivo_Copia_Titulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->Ruta_Archivo_Copia_Titulo->Sortable = TRUE; // Allow sort
		$this->Ruta_Archivo_Copia_Titulo->UploadMultiple = TRUE;
		$this->Ruta_Archivo_Copia_Titulo->Upload->UploadMultiple = TRUE;
		$this->Ruta_Archivo_Copia_Titulo->UploadMaxFileCount = 0;
		$this->fields['Ruta_Archivo_Copia_Titulo'] = &$this->Ruta_Archivo_Copia_Titulo;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`liberacion_equipo`";
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
			if (array_key_exists('Dni', $rs))
				ew_AddFilter($where, ew_QuotedName('Dni', $this->DBID) . '=' . ew_QuotedValue($rs['Dni'], $this->Dni->FldDataType, $this->DBID));
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
		return "`Dni` = @Dni@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Dni->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "liberacion_equipolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "liberacion_equipolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("liberacion_equipoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("liberacion_equipoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "liberacion_equipoadd.php?" . $this->UrlParm($parm);
		else
			$url = "liberacion_equipoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("liberacion_equipoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("liberacion_equipoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("liberacion_equipodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Dni:" . ew_VarToJson($this->Dni->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Dni->CurrentValue)) {
			$sUrl .= "Dni=" . urlencode($this->Dni->CurrentValue);
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
			if ($isPost && isset($_POST["Dni"]))
				$arKeys[] = ew_StripSlashes($_POST["Dni"]);
			elseif (isset($_GET["Dni"]))
				$arKeys[] = ew_StripSlashes($_GET["Dni"]);
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
			$this->Dni->CurrentValue = $key;
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Fecha_Finalizacion->setDbValue($rs->fields('Fecha_Finalizacion'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Id_Modalidad->setDbValue($rs->fields('Id_Modalidad'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Autoridad->setDbValue($rs->fields('Id_Autoridad'));
		$this->Fecha_Liberacion->setDbValue($rs->fields('Fecha_Liberacion'));
		$this->Ruta_Archivo_Copia_Titulo->Upload->DbValue = $rs->fields('Ruta_Archivo_Copia_Titulo');
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Dni
		// NroSerie
		// Dni_Tutor
		// Fecha_Finalizacion
		// Observacion
		// Id_Modalidad
		// Id_Nivel
		// Id_Autoridad
		// Fecha_Liberacion
		// Ruta_Archivo_Copia_Titulo
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

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		if (strval($this->Dni_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			}
		} else {
			$this->Dni_Tutor->ViewValue = NULL;
		}
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->ViewValue = $this->Fecha_Finalizacion->CurrentValue;
		$this->Fecha_Finalizacion->ViewValue = ew_FormatDateTime($this->Fecha_Finalizacion->ViewValue, 7);
		$this->Fecha_Finalizacion->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Modalidad
		if (strval($this->Id_Modalidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modalidad`" . ew_SearchString("=", $this->Id_Modalidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modalidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modalidad_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Modalidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->CurrentValue;
			}
		} else {
			$this->Id_Modalidad->ViewValue = NULL;
		}
		$this->Id_Modalidad->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Nivel`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Autoridad
		if (strval($this->Id_Autoridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
		$sWhereWrk = "";
		$this->Id_Autoridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
			}
		} else {
			$this->Id_Autoridad->ViewValue = NULL;
		}
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Fecha_Liberacion
		$this->Fecha_Liberacion->ViewValue = $this->Fecha_Liberacion->CurrentValue;
		$this->Fecha_Liberacion->ViewValue = ew_FormatDateTime($this->Fecha_Liberacion->ViewValue, 7);
		$this->Fecha_Liberacion->ViewCustomAttributes = "";

		// Ruta_Archivo_Copia_Titulo
		if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->DbValue)) {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = "";
		}
		$this->Ruta_Archivo_Copia_Titulo->ViewCustomAttributes = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// Dni_Tutor
		$this->Dni_Tutor->LinkCustomAttributes = "";
		$this->Dni_Tutor->HrefValue = "";
		$this->Dni_Tutor->TooltipValue = "";

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->LinkCustomAttributes = "";
		$this->Fecha_Finalizacion->HrefValue = "";
		$this->Fecha_Finalizacion->TooltipValue = "";

		// Observacion
		$this->Observacion->LinkCustomAttributes = "";
		$this->Observacion->HrefValue = "";
		$this->Observacion->TooltipValue = "";

		// Id_Modalidad
		$this->Id_Modalidad->LinkCustomAttributes = "";
		$this->Id_Modalidad->HrefValue = "";
		$this->Id_Modalidad->TooltipValue = "";

		// Id_Nivel
		$this->Id_Nivel->LinkCustomAttributes = "";
		$this->Id_Nivel->HrefValue = "";
		$this->Id_Nivel->TooltipValue = "";

		// Id_Autoridad
		$this->Id_Autoridad->LinkCustomAttributes = "";
		$this->Id_Autoridad->HrefValue = "";
		$this->Id_Autoridad->TooltipValue = "";

		// Fecha_Liberacion
		$this->Fecha_Liberacion->LinkCustomAttributes = "";
		$this->Fecha_Liberacion->HrefValue = "";
		$this->Fecha_Liberacion->TooltipValue = "";

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo->LinkCustomAttributes = "";
		$this->Ruta_Archivo_Copia_Titulo->HrefValue = "";
		$this->Ruta_Archivo_Copia_Titulo->HrefValue2 = $this->Ruta_Archivo_Copia_Titulo->UploadPath . $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		$this->Ruta_Archivo_Copia_Titulo->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
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
				$this->Dni->EditValue = $this->Dni->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni->EditValue = $this->Dni->CurrentValue;
			}
		} else {
			$this->Dni->EditValue = NULL;
		}
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

		// Dni_Tutor
		$this->Dni_Tutor->EditAttrs["class"] = "form-control";
		$this->Dni_Tutor->EditCustomAttributes = "";
		$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->EditAttrs["class"] = "form-control";
		$this->Fecha_Finalizacion->EditCustomAttributes = "";
		$this->Fecha_Finalizacion->EditValue = $this->Fecha_Finalizacion->CurrentValue;
		$this->Fecha_Finalizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Finalizacion->FldCaption());

		// Observacion
		$this->Observacion->EditAttrs["class"] = "form-control";
		$this->Observacion->EditCustomAttributes = "";
		$this->Observacion->EditValue = $this->Observacion->CurrentValue;
		$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

		// Id_Modalidad
		$this->Id_Modalidad->EditAttrs["class"] = "form-control";
		$this->Id_Modalidad->EditCustomAttributes = "";

		// Id_Nivel
		$this->Id_Nivel->EditAttrs["class"] = "form-control";
		$this->Id_Nivel->EditCustomAttributes = "";

		// Id_Autoridad
		$this->Id_Autoridad->EditAttrs["class"] = "form-control";
		$this->Id_Autoridad->EditCustomAttributes = "";

		// Fecha_Liberacion
		$this->Fecha_Liberacion->EditAttrs["class"] = "form-control";
		$this->Fecha_Liberacion->EditCustomAttributes = "";
		$this->Fecha_Liberacion->EditValue = $this->Fecha_Liberacion->CurrentValue;
		$this->Fecha_Liberacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Liberacion->FldCaption());

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo->EditAttrs["class"] = "form-control";
		$this->Ruta_Archivo_Copia_Titulo->EditCustomAttributes = "";
		if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->DbValue)) {
			$this->Ruta_Archivo_Copia_Titulo->EditValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo_Copia_Titulo->EditValue = "";
		}
		if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->CurrentValue))
			$this->Ruta_Archivo_Copia_Titulo->Upload->FileName = $this->Ruta_Archivo_Copia_Titulo->CurrentValue;

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
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Fecha_Finalizacion->Exportable) $Doc->ExportCaption($this->Fecha_Finalizacion);
					if ($this->Observacion->Exportable) $Doc->ExportCaption($this->Observacion);
					if ($this->Id_Modalidad->Exportable) $Doc->ExportCaption($this->Id_Modalidad);
					if ($this->Id_Nivel->Exportable) $Doc->ExportCaption($this->Id_Nivel);
					if ($this->Id_Autoridad->Exportable) $Doc->ExportCaption($this->Id_Autoridad);
					if ($this->Fecha_Liberacion->Exportable) $Doc->ExportCaption($this->Fecha_Liberacion);
					if ($this->Ruta_Archivo_Copia_Titulo->Exportable) $Doc->ExportCaption($this->Ruta_Archivo_Copia_Titulo);
				} else {
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Fecha_Finalizacion->Exportable) $Doc->ExportCaption($this->Fecha_Finalizacion);
					if ($this->Id_Modalidad->Exportable) $Doc->ExportCaption($this->Id_Modalidad);
					if ($this->Id_Nivel->Exportable) $Doc->ExportCaption($this->Id_Nivel);
					if ($this->Id_Autoridad->Exportable) $Doc->ExportCaption($this->Id_Autoridad);
					if ($this->Fecha_Liberacion->Exportable) $Doc->ExportCaption($this->Fecha_Liberacion);
					if ($this->Ruta_Archivo_Copia_Titulo->Exportable) $Doc->ExportCaption($this->Ruta_Archivo_Copia_Titulo);
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
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Fecha_Finalizacion->Exportable) $Doc->ExportField($this->Fecha_Finalizacion);
						if ($this->Observacion->Exportable) $Doc->ExportField($this->Observacion);
						if ($this->Id_Modalidad->Exportable) $Doc->ExportField($this->Id_Modalidad);
						if ($this->Id_Nivel->Exportable) $Doc->ExportField($this->Id_Nivel);
						if ($this->Id_Autoridad->Exportable) $Doc->ExportField($this->Id_Autoridad);
						if ($this->Fecha_Liberacion->Exportable) $Doc->ExportField($this->Fecha_Liberacion);
						if ($this->Ruta_Archivo_Copia_Titulo->Exportable) $Doc->ExportField($this->Ruta_Archivo_Copia_Titulo);
					} else {
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Fecha_Finalizacion->Exportable) $Doc->ExportField($this->Fecha_Finalizacion);
						if ($this->Id_Modalidad->Exportable) $Doc->ExportField($this->Id_Modalidad);
						if ($this->Id_Nivel->Exportable) $Doc->ExportField($this->Id_Nivel);
						if ($this->Id_Autoridad->Exportable) $Doc->ExportField($this->Id_Autoridad);
						if ($this->Fecha_Liberacion->Exportable) $Doc->ExportField($this->Fecha_Liberacion);
						if ($this->Ruta_Archivo_Copia_Titulo->Exportable) $Doc->ExportField($this->Ruta_Archivo_Copia_Titulo);
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
			$sSqlWrk = "SELECT `NroSerie` AS FIELD0, `Dni_Tutor` AS FIELD1 FROM `personas`";
			$sWhereWrk = "(`Dni` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->NroSerie->setDbValue($rs->fields[0]);
					$this->Dni_Tutor->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->NroSerie->AutoFillOriginalValue) ? $this->NroSerie->CurrentValue : $this->NroSerie->EditValue;
					$ar[] = ($this->Dni_Tutor->AutoFillOriginalValue) ? $this->Dni_Tutor->CurrentValue : $this->Dni_Tutor->EditValue;
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

	// Update record
	$Dni=$rsnew["Dni"];
	$Serie=$rsnew["NroSerie"];

	// NOTE: Modify your SQL here, replace the table name, field name and field values
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=4 WHERE Dni=$Dni");
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=1, Id_Sit_Estado=11 WHERE NroSerie='$Serie'");
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
