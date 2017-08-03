<?php

// Global variable for table object
$usuarios = NULL;

//
// Table class for usuarios
//
class cusuarios extends cTable {
	var $NombreTitular;
	var $Dni;
	var $Nombre;
	var $Password;
	var $Nivel_Usuario;
	var $Curso;
	var $Turno;
	var $Division;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'usuarios';
		$this->TableName = 'usuarios';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`usuarios`";
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

		// NombreTitular
		$this->NombreTitular = new cField('usuarios', 'usuarios', 'x_NombreTitular', 'NombreTitular', '`NombreTitular`', '`NombreTitular`', 200, -1, FALSE, '`NombreTitular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NombreTitular->Sortable = TRUE; // Allow sort
		$this->fields['NombreTitular'] = &$this->NombreTitular;

		// Dni
		$this->Dni = new cField('usuarios', 'usuarios', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Nombre
		$this->Nombre = new cField('usuarios', 'usuarios', 'x_Nombre', 'Nombre', '`Nombre`', '`Nombre`', 200, -1, FALSE, '`Nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre->Sortable = TRUE; // Allow sort
		$this->fields['Nombre'] = &$this->Nombre;

		// Password
		$this->Password = new cField('usuarios', 'usuarios', 'x_Password', 'Password', '`Password`', '`Password`', 200, -1, FALSE, '`Password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password->Sortable = TRUE; // Allow sort
		$this->fields['Password'] = &$this->Password;

		// Nivel_Usuario
		$this->Nivel_Usuario = new cField('usuarios', 'usuarios', 'x_Nivel_Usuario', 'Nivel_Usuario', '`Nivel_Usuario`', '`Nivel_Usuario`', 3, -1, FALSE, '`Nivel_Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Nivel_Usuario->Sortable = TRUE; // Allow sort
		$this->Nivel_Usuario->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Nivel_Usuario->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Nivel_Usuario->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Nivel_Usuario'] = &$this->Nivel_Usuario;

		// Curso
		$this->Curso = new cField('usuarios', 'usuarios', 'x_Curso', 'Curso', '`Curso`', '`Curso`', 3, -1, FALSE, '`Curso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Curso->Sortable = TRUE; // Allow sort
		$this->Curso->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Curso->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Curso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Curso'] = &$this->Curso;

		// Turno
		$this->Turno = new cField('usuarios', 'usuarios', 'x_Turno', 'Turno', '`Turno`', '`Turno`', 3, -1, FALSE, '`Turno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Turno->Sortable = TRUE; // Allow sort
		$this->Turno->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Turno->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Turno->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Turno'] = &$this->Turno;

		// Division
		$this->Division = new cField('usuarios', 'usuarios', 'x_Division', 'Division', '`Division`', '`Division`', 3, -1, FALSE, '`Division`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Division->Sortable = TRUE; // Allow sort
		$this->Division->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Division->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Division->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Division'] = &$this->Division;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`usuarios`";
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
		global $Security;

		// Add User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password') {
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('Nombre', $rs))
				ew_AddFilter($where, ew_QuotedName('Nombre', $this->DBID) . '=' . ew_QuotedValue($rs['Nombre'], $this->Nombre->FldDataType, $this->DBID));
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
		return "`Nombre` = '@Nombre@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@Nombre@", ew_AdjustSql($this->Nombre->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "usuarioslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "usuarioslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usuariosview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usuariosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usuariosadd.php?" . $this->UrlParm($parm);
		else
			$url = "usuariosadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("usuariosedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("usuariosadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usuariosdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Nombre:" . ew_VarToJson($this->Nombre->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Nombre->CurrentValue)) {
			$sUrl .= "Nombre=" . urlencode($this->Nombre->CurrentValue);
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
			if ($isPost && isset($_POST["Nombre"]))
				$arKeys[] = ew_StripSlashes($_POST["Nombre"]);
			elseif (isset($_GET["Nombre"]))
				$arKeys[] = ew_StripSlashes($_GET["Nombre"]);
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
			$this->Nombre->CurrentValue = $key;
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
		$this->NombreTitular->setDbValue($rs->fields('NombreTitular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->Nivel_Usuario->setDbValue($rs->fields('Nivel_Usuario'));
		$this->Curso->setDbValue($rs->fields('Curso'));
		$this->Turno->setDbValue($rs->fields('Turno'));
		$this->Division->setDbValue($rs->fields('Division'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// NombreTitular
		// Dni
		// Nombre
		// Password
		// Nivel_Usuario
		// Curso
		// Turno
		// Division
		// NombreTitular

		$this->NombreTitular->ViewValue = $this->NombreTitular->CurrentValue;
		if (strval($this->NombreTitular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->NombreTitular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NombreTitular->ViewValue = $this->NombreTitular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NombreTitular->ViewValue = $this->NombreTitular->CurrentValue;
			}
		} else {
			$this->NombreTitular->ViewValue = NULL;
		}
		$this->NombreTitular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Nombre
		$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
		$this->Nombre->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

		// Nivel_Usuario
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->Nivel_Usuario->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Nivel_Usuario->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->Nivel_Usuario->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nivel_Usuario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nivel_Usuario->ViewValue = $this->Nivel_Usuario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nivel_Usuario->ViewValue = $this->Nivel_Usuario->CurrentValue;
			}
		} else {
			$this->Nivel_Usuario->ViewValue = NULL;
		}
		} else {
			$this->Nivel_Usuario->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->Nivel_Usuario->ViewCustomAttributes = "";

		// Curso
		if (strval($this->Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Curso->ViewValue = $this->Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Curso->ViewValue = $this->Curso->CurrentValue;
			}
		} else {
			$this->Curso->ViewValue = NULL;
		}
		$this->Curso->ViewCustomAttributes = "";

		// Turno
		if (strval($this->Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Turno->ViewValue = $this->Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Turno->ViewValue = $this->Turno->CurrentValue;
			}
		} else {
			$this->Turno->ViewValue = NULL;
		}
		$this->Turno->ViewCustomAttributes = "";

		// Division
		if (strval($this->Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Division->ViewValue = $this->Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Division->ViewValue = $this->Division->CurrentValue;
			}
		} else {
			$this->Division->ViewValue = NULL;
		}
		$this->Division->ViewCustomAttributes = "";

		// NombreTitular
		$this->NombreTitular->LinkCustomAttributes = "";
		$this->NombreTitular->HrefValue = "";
		$this->NombreTitular->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Nombre
		$this->Nombre->LinkCustomAttributes = "";
		$this->Nombre->HrefValue = "";
		$this->Nombre->TooltipValue = "";

		// Password
		$this->Password->LinkCustomAttributes = "";
		$this->Password->HrefValue = "";
		$this->Password->TooltipValue = "";

		// Nivel_Usuario
		$this->Nivel_Usuario->LinkCustomAttributes = "";
		$this->Nivel_Usuario->HrefValue = "";
		$this->Nivel_Usuario->TooltipValue = "";

		// Curso
		$this->Curso->LinkCustomAttributes = "";
		$this->Curso->HrefValue = "";
		$this->Curso->TooltipValue = "";

		// Turno
		$this->Turno->LinkCustomAttributes = "";
		$this->Turno->HrefValue = "";
		$this->Turno->TooltipValue = "";

		// Division
		$this->Division->LinkCustomAttributes = "";
		$this->Division->HrefValue = "";
		$this->Division->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// NombreTitular
		$this->NombreTitular->EditAttrs["class"] = "form-control";
		$this->NombreTitular->EditCustomAttributes = "";
		$this->NombreTitular->EditValue = $this->NombreTitular->CurrentValue;
		$this->NombreTitular->PlaceHolder = ew_RemoveHtml($this->NombreTitular->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

		// Nombre
		$this->Nombre->EditAttrs["class"] = "form-control";
		$this->Nombre->EditCustomAttributes = "";
		$this->Nombre->EditValue = $this->Nombre->CurrentValue;
		$this->Nombre->ViewCustomAttributes = "";

		// Password
		$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
		$this->Password->EditCustomAttributes = "";
		$this->Password->EditValue = $this->Password->CurrentValue;
		$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

		// Nivel_Usuario
		$this->Nivel_Usuario->EditAttrs["class"] = "form-control";
		$this->Nivel_Usuario->EditCustomAttributes = "";
		if (!$Security->CanAdmin()) { // System admin
			$this->Nivel_Usuario->EditValue = $Language->Phrase("PasswordMask");
		} else {
		}

		// Curso
		$this->Curso->EditAttrs["class"] = "form-control";
		$this->Curso->EditCustomAttributes = "";

		// Turno
		$this->Turno->EditAttrs["class"] = "form-control";
		$this->Turno->EditCustomAttributes = "";

		// Division
		$this->Division->EditAttrs["class"] = "form-control";
		$this->Division->EditCustomAttributes = "";

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
					if ($this->NombreTitular->Exportable) $Doc->ExportCaption($this->NombreTitular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
					if ($this->Password->Exportable) $Doc->ExportCaption($this->Password);
					if ($this->Nivel_Usuario->Exportable) $Doc->ExportCaption($this->Nivel_Usuario);
					if ($this->Curso->Exportable) $Doc->ExportCaption($this->Curso);
					if ($this->Turno->Exportable) $Doc->ExportCaption($this->Turno);
					if ($this->Division->Exportable) $Doc->ExportCaption($this->Division);
				} else {
					if ($this->NombreTitular->Exportable) $Doc->ExportCaption($this->NombreTitular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Nombre->Exportable) $Doc->ExportCaption($this->Nombre);
					if ($this->Password->Exportable) $Doc->ExportCaption($this->Password);
					if ($this->Nivel_Usuario->Exportable) $Doc->ExportCaption($this->Nivel_Usuario);
					if ($this->Curso->Exportable) $Doc->ExportCaption($this->Curso);
					if ($this->Turno->Exportable) $Doc->ExportCaption($this->Turno);
					if ($this->Division->Exportable) $Doc->ExportCaption($this->Division);
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
						if ($this->NombreTitular->Exportable) $Doc->ExportField($this->NombreTitular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
						if ($this->Password->Exportable) $Doc->ExportField($this->Password);
						if ($this->Nivel_Usuario->Exportable) $Doc->ExportField($this->Nivel_Usuario);
						if ($this->Curso->Exportable) $Doc->ExportField($this->Curso);
						if ($this->Turno->Exportable) $Doc->ExportField($this->Turno);
						if ($this->Division->Exportable) $Doc->ExportField($this->Division);
					} else {
						if ($this->NombreTitular->Exportable) $Doc->ExportField($this->NombreTitular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Nombre->Exportable) $Doc->ExportField($this->Nombre);
						if ($this->Password->Exportable) $Doc->ExportField($this->Password);
						if ($this->Nivel_Usuario->Exportable) $Doc->ExportField($this->Nivel_Usuario);
						if ($this->Curso->Exportable) $Doc->ExportField($this->Curso);
						if ($this->Turno->Exportable) $Doc->ExportField($this->Turno);
						if ($this->Division->Exportable) $Doc->ExportField($this->Division);
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

	// User ID filter
	function UserIDFilter($userid) {
		$sUserIDFilter = '`Nombre` = ' . ew_QuotedValue($userid, EW_DATATYPE_STRING, EW_USER_TABLE_DBID);
		return $sUserIDFilter;
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`Nombre` IN (' . $sFilterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $UserTableConn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `usuarios`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $UserTableConn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType, EW_USER_TABLE_DBID);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_NombreTitular$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Dni` AS FIELD0, `Id_Curso` AS FIELD1, `Id_Turno` AS FIELD2, `Id_Division` AS FIELD3 FROM `personas`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_MEMO, $this->DBID) . ")";
			$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Dni->setDbValue($rs->fields[0]);
					$this->Curso->setDbValue($rs->fields[1]);
					$this->Turno->setDbValue($rs->fields[2]);
					$this->Division->setDbValue($rs->fields[3]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Dni->AutoFillOriginalValue) ? $this->Dni->CurrentValue : $this->Dni->EditValue;
					$ar[] = $this->Curso->CurrentValue;
					$ar[] = $this->Turno->CurrentValue;
					$ar[] = $this->Division->CurrentValue;
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
