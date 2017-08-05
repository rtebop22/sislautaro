<?php

// Global variable for table object
$titulares2Dequipos2Dtutores = NULL;

//
// Table class for titulares-equipos-tutores
//
class ctitulares2Dequipos2Dtutores extends cTable {
	var $Apelldio_y_Nombre_Titular;
	var $Dni;
	var $Cuil;
	var $Equipo_Asignado;
	var $Apellido_y_Nombre_Tutor;
	var $Dni_Tutor;
	var $Cuil_Tutor;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'titulares2Dequipos2Dtutores';
		$this->TableName = 'titulares-equipos-tutores';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`titulares-equipos-tutores`";
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

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Apelldio_y_Nombre_Titular', 'Apelldio y Nombre Titular', '`Apelldio y Nombre Titular`', '`Apelldio y Nombre Titular`', 201, -1, FALSE, '`Apelldio y Nombre Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apelldio_y_Nombre_Titular->Sortable = TRUE; // Allow sort
		$this->fields['Apelldio y Nombre Titular'] = &$this->Apelldio_y_Nombre_Titular;

		// Dni
		$this->Dni = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Cuil
		$this->Cuil = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Cuil', 'Cuil', '`Cuil`', '`Cuil`', 200, -1, FALSE, '`Cuil`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil->Sortable = TRUE; // Allow sort
		$this->fields['Cuil'] = &$this->Cuil;

		// Equipo Asignado
		$this->Equipo_Asignado = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Equipo_Asignado', 'Equipo Asignado', '`Equipo Asignado`', '`Equipo Asignado`', 200, -1, FALSE, '`Equipo Asignado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Equipo_Asignado->Sortable = TRUE; // Allow sort
		$this->fields['Equipo Asignado'] = &$this->Equipo_Asignado;

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Apellido_y_Nombre_Tutor', 'Apellido y Nombre Tutor', '`Apellido y Nombre Tutor`', '`Apellido y Nombre Tutor`', 201, -1, FALSE, '`Apellido y Nombre Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apellido_y_Nombre_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Apellido y Nombre Tutor'] = &$this->Apellido_y_Nombre_Tutor;

		// Dni Tutor
		$this->Dni_Tutor = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Dni_Tutor', 'Dni Tutor', '`Dni Tutor`', '`Dni Tutor`', 3, -1, FALSE, '`Dni Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Tutor->Sortable = TRUE; // Allow sort
		$this->Dni_Tutor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni Tutor'] = &$this->Dni_Tutor;

		// Cuil Tutor
		$this->Cuil_Tutor = new cField('titulares2Dequipos2Dtutores', 'titulares-equipos-tutores', 'x_Cuil_Tutor', 'Cuil Tutor', '`Cuil Tutor`', '`Cuil Tutor`', 200, -1, FALSE, '`Cuil Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Cuil Tutor'] = &$this->Cuil_Tutor;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`titulares-equipos-tutores`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Apelldio y Nombre Titular` ASC";
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
			if (array_key_exists('Dni Tutor', $rs))
				ew_AddFilter($where, ew_QuotedName('Dni Tutor', $this->DBID) . '=' . ew_QuotedValue($rs['Dni Tutor'], $this->Dni_Tutor->FldDataType, $this->DBID));
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
		return "`Dni` = @Dni@ AND `Dni Tutor` = @Dni_Tutor@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Dni->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->Dni_Tutor->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Dni_Tutor@", ew_AdjustSql($this->Dni_Tutor->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "titulares2Dequipos2Dtutoreslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "titulares2Dequipos2Dtutoreslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("titulares2Dequipos2Dtutoresview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("titulares2Dequipos2Dtutoresview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "titulares2Dequipos2Dtutoresadd.php?" . $this->UrlParm($parm);
		else
			$url = "titulares2Dequipos2Dtutoresadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("titulares2Dequipos2Dtutoresedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("titulares2Dequipos2Dtutoresadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("titulares2Dequipos2Dtutoresdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Dni:" . ew_VarToJson($this->Dni->CurrentValue, "number", "'");
		$json .= ",Dni_Tutor:" . ew_VarToJson($this->Dni_Tutor->CurrentValue, "number", "'");
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
		if (!is_null($this->Dni_Tutor->CurrentValue)) {
			$sUrl .= "&Dni_Tutor=" . urlencode($this->Dni_Tutor->CurrentValue);
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
			if ($isPost && isset($_POST["Dni"]))
				$arKey[] = ew_StripSlashes($_POST["Dni"]);
			elseif (isset($_GET["Dni"]))
				$arKey[] = ew_StripSlashes($_GET["Dni"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["Dni_Tutor"]))
				$arKey[] = ew_StripSlashes($_POST["Dni_Tutor"]);
			elseif (isset($_GET["Dni_Tutor"]))
				$arKey[] = ew_StripSlashes($_GET["Dni_Tutor"]);
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
				if (!is_numeric($key[0])) // Dni
					continue;
				if (!is_numeric($key[1])) // Dni Tutor
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
			$this->Dni->CurrentValue = $key[0];
			$this->Dni_Tutor->CurrentValue = $key[1];
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
		$this->Apelldio_y_Nombre_Titular->setDbValue($rs->fields('Apelldio y Nombre Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Equipo_Asignado->setDbValue($rs->fields('Equipo Asignado'));
		$this->Apellido_y_Nombre_Tutor->setDbValue($rs->fields('Apellido y Nombre Tutor'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni Tutor'));
		$this->Cuil_Tutor->setDbValue($rs->fields('Cuil Tutor'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Apelldio y Nombre Titular
		// Dni
		// Cuil
		// Equipo Asignado
		// Apellido y Nombre Tutor
		// Dni Tutor
		// Cuil Tutor
		// Apelldio y Nombre Titular

		$this->Apelldio_y_Nombre_Titular->ViewValue = $this->Apelldio_y_Nombre_Titular->CurrentValue;
		$this->Apelldio_y_Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Equipo Asignado
		$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
		if (strval($this->Equipo_Asignado->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Equipo_Asignado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
			}
		} else {
			$this->Equipo_Asignado->ViewValue = NULL;
		}
		$this->Equipo_Asignado->ViewCustomAttributes = "";

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->ViewValue = $this->Apellido_y_Nombre_Tutor->CurrentValue;
		$this->Apellido_y_Nombre_Tutor->ViewCustomAttributes = "";

		// Dni Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Cuil Tutor
		$this->Cuil_Tutor->ViewValue = $this->Cuil_Tutor->CurrentValue;
		$this->Cuil_Tutor->ViewCustomAttributes = "";

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->LinkCustomAttributes = "";
		$this->Apelldio_y_Nombre_Titular->HrefValue = "";
		$this->Apelldio_y_Nombre_Titular->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Cuil
		$this->Cuil->LinkCustomAttributes = "";
		$this->Cuil->HrefValue = "";
		$this->Cuil->TooltipValue = "";

		// Equipo Asignado
		$this->Equipo_Asignado->LinkCustomAttributes = "";
		$this->Equipo_Asignado->HrefValue = "";
		$this->Equipo_Asignado->TooltipValue = "";

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->LinkCustomAttributes = "";
		$this->Apellido_y_Nombre_Tutor->HrefValue = "";
		$this->Apellido_y_Nombre_Tutor->TooltipValue = "";

		// Dni Tutor
		$this->Dni_Tutor->LinkCustomAttributes = "";
		$this->Dni_Tutor->HrefValue = "";
		$this->Dni_Tutor->TooltipValue = "";

		// Cuil Tutor
		$this->Cuil_Tutor->LinkCustomAttributes = "";
		$this->Cuil_Tutor->HrefValue = "";
		$this->Cuil_Tutor->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->EditAttrs["class"] = "form-control";
		$this->Apelldio_y_Nombre_Titular->EditCustomAttributes = "";
		$this->Apelldio_y_Nombre_Titular->EditValue = $this->Apelldio_y_Nombre_Titular->CurrentValue;
		$this->Apelldio_y_Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Apelldio_y_Nombre_Titular->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->EditAttrs["class"] = "form-control";
		$this->Cuil->EditCustomAttributes = "";
		$this->Cuil->EditValue = $this->Cuil->CurrentValue;
		$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

		// Equipo Asignado
		$this->Equipo_Asignado->EditAttrs["class"] = "form-control";
		$this->Equipo_Asignado->EditCustomAttributes = "";
		$this->Equipo_Asignado->EditValue = $this->Equipo_Asignado->CurrentValue;
		$this->Equipo_Asignado->PlaceHolder = ew_RemoveHtml($this->Equipo_Asignado->FldCaption());

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->EditAttrs["class"] = "form-control";
		$this->Apellido_y_Nombre_Tutor->EditCustomAttributes = "";
		$this->Apellido_y_Nombre_Tutor->EditValue = $this->Apellido_y_Nombre_Tutor->CurrentValue;
		$this->Apellido_y_Nombre_Tutor->PlaceHolder = ew_RemoveHtml($this->Apellido_y_Nombre_Tutor->FldCaption());

		// Dni Tutor
		$this->Dni_Tutor->EditAttrs["class"] = "form-control";
		$this->Dni_Tutor->EditCustomAttributes = "";
		$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Cuil Tutor
		$this->Cuil_Tutor->EditAttrs["class"] = "form-control";
		$this->Cuil_Tutor->EditCustomAttributes = "";
		$this->Cuil_Tutor->EditValue = $this->Cuil_Tutor->CurrentValue;
		$this->Cuil_Tutor->PlaceHolder = ew_RemoveHtml($this->Cuil_Tutor->FldCaption());

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
					if ($this->Apelldio_y_Nombre_Titular->Exportable) $Doc->ExportCaption($this->Apelldio_y_Nombre_Titular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->Equipo_Asignado->Exportable) $Doc->ExportCaption($this->Equipo_Asignado);
					if ($this->Apellido_y_Nombre_Tutor->Exportable) $Doc->ExportCaption($this->Apellido_y_Nombre_Tutor);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Cuil_Tutor->Exportable) $Doc->ExportCaption($this->Cuil_Tutor);
				} else {
					if ($this->Apelldio_y_Nombre_Titular->Exportable) $Doc->ExportCaption($this->Apelldio_y_Nombre_Titular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->Equipo_Asignado->Exportable) $Doc->ExportCaption($this->Equipo_Asignado);
					if ($this->Apellido_y_Nombre_Tutor->Exportable) $Doc->ExportCaption($this->Apellido_y_Nombre_Tutor);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Cuil_Tutor->Exportable) $Doc->ExportCaption($this->Cuil_Tutor);
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
						if ($this->Apelldio_y_Nombre_Titular->Exportable) $Doc->ExportField($this->Apelldio_y_Nombre_Titular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->Equipo_Asignado->Exportable) $Doc->ExportField($this->Equipo_Asignado);
						if ($this->Apellido_y_Nombre_Tutor->Exportable) $Doc->ExportField($this->Apellido_y_Nombre_Tutor);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Cuil_Tutor->Exportable) $Doc->ExportField($this->Cuil_Tutor);
					} else {
						if ($this->Apelldio_y_Nombre_Titular->Exportable) $Doc->ExportField($this->Apelldio_y_Nombre_Titular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->Equipo_Asignado->Exportable) $Doc->ExportField($this->Equipo_Asignado);
						if ($this->Apellido_y_Nombre_Tutor->Exportable) $Doc->ExportField($this->Apellido_y_Nombre_Tutor);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Cuil_Tutor->Exportable) $Doc->ExportField($this->Cuil_Tutor);
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
