<?php

// Global variable for table object
$datosextrasescuela = NULL;

//
// Table class for datosextrasescuela
//
class cdatosextrasescuela extends cTable {
	var $Cue;
	var $Sigla;
	var $Id_Zona;
	var $Usuario_Conig;
	var $Password_Conig;
	var $Tiene_Internet;
	var $Servicio_Internet;
	var $Estado_Internet;
	var $Quien_Paga;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'datosextrasescuela';
		$this->TableName = 'datosextrasescuela';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`datosextrasescuela`";
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
		$this->Cue = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Cue', 'Cue', '`Cue`', '`Cue`', 200, -1, FALSE, '`Cue`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Cue->Sortable = TRUE; // Allow sort
		$this->fields['Cue'] = &$this->Cue;

		// Sigla
		$this->Sigla = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Sigla', 'Sigla', '`Sigla`', '`Sigla`', 200, -1, FALSE, '`Sigla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sigla->Sortable = TRUE; // Allow sort
		$this->fields['Sigla'] = &$this->Sigla;

		// Id_Zona
		$this->Id_Zona = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Id_Zona', 'Id_Zona', '`Id_Zona`', '`Id_Zona`', 3, -1, FALSE, '`Id_Zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Zona->Sortable = TRUE; // Allow sort
		$this->Id_Zona->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Zona->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Zona'] = &$this->Id_Zona;

		// Usuario_Conig
		$this->Usuario_Conig = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Usuario_Conig', 'Usuario_Conig', '`Usuario_Conig`', '`Usuario_Conig`', 200, -1, FALSE, '`Usuario_Conig`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Usuario_Conig->Sortable = TRUE; // Allow sort
		$this->fields['Usuario_Conig'] = &$this->Usuario_Conig;

		// Password_Conig
		$this->Password_Conig = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Password_Conig', 'Password_Conig', '`Password_Conig`', '`Password_Conig`', 200, -1, FALSE, '`Password_Conig`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password_Conig->Sortable = TRUE; // Allow sort
		$this->fields['Password_Conig'] = &$this->Password_Conig;

		// Tiene_Internet
		$this->Tiene_Internet = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Tiene_Internet', 'Tiene_Internet', '`Tiene_Internet`', '`Tiene_Internet`', 200, -1, FALSE, '`Tiene_Internet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tiene_Internet->Sortable = TRUE; // Allow sort
		$this->fields['Tiene_Internet'] = &$this->Tiene_Internet;

		// Servicio_Internet
		$this->Servicio_Internet = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Servicio_Internet', 'Servicio_Internet', '`Servicio_Internet`', '`Servicio_Internet`', 200, -1, FALSE, '`Servicio_Internet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Servicio_Internet->Sortable = TRUE; // Allow sort
		$this->fields['Servicio_Internet'] = &$this->Servicio_Internet;

		// Estado_Internet
		$this->Estado_Internet = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Estado_Internet', 'Estado_Internet', '`Estado_Internet`', '`Estado_Internet`', 3, -1, FALSE, '`Estado_Internet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado_Internet->Sortable = TRUE; // Allow sort
		$this->Estado_Internet->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado_Internet->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Estado_Internet->OptionCount = 2;
		$this->fields['Estado_Internet'] = &$this->Estado_Internet;

		// Quien_Paga
		$this->Quien_Paga = new cField('datosextrasescuela', 'datosextrasescuela', 'x_Quien_Paga', 'Quien_Paga', '`Quien_Paga`', '`Quien_Paga`', 200, -1, FALSE, '`Quien_Paga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Quien_Paga->Sortable = TRUE; // Allow sort
		$this->fields['Quien_Paga'] = &$this->Quien_Paga;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`datosextrasescuela`";
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
			return "datosextrasescuelalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "datosextrasescuelalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("datosextrasescuelaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("datosextrasescuelaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "datosextrasescuelaadd.php?" . $this->UrlParm($parm);
		else
			$url = "datosextrasescuelaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("datosextrasescuelaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("datosextrasescuelaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("datosextrasescueladelete.php", $this->UrlParm());
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
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Usuario_Conig->setDbValue($rs->fields('Usuario_Conig'));
		$this->Password_Conig->setDbValue($rs->fields('Password_Conig'));
		$this->Tiene_Internet->setDbValue($rs->fields('Tiene_Internet'));
		$this->Servicio_Internet->setDbValue($rs->fields('Servicio_Internet'));
		$this->Estado_Internet->setDbValue($rs->fields('Estado_Internet'));
		$this->Quien_Paga->setDbValue($rs->fields('Quien_Paga'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Cue
		// Sigla
		// Id_Zona
		// Usuario_Conig
		// Password_Conig
		// Tiene_Internet
		// Servicio_Internet
		// Estado_Internet
		// Quien_Paga
		// Cue

		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Id_Zona
		if (strval($this->Id_Zona->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
		$sWhereWrk = "";
		$this->Id_Zona->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Zona->ViewValue = $this->Id_Zona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Zona->ViewValue = $this->Id_Zona->CurrentValue;
			}
		} else {
			$this->Id_Zona->ViewValue = NULL;
		}
		$this->Id_Zona->ViewCustomAttributes = "";

		// Usuario_Conig
		$this->Usuario_Conig->ViewValue = $this->Usuario_Conig->CurrentValue;
		$this->Usuario_Conig->ViewCustomAttributes = "";

		// Password_Conig
		$this->Password_Conig->ViewValue = $this->Password_Conig->CurrentValue;
		$this->Password_Conig->ViewCustomAttributes = "";

		// Tiene_Internet
		$this->Tiene_Internet->ViewValue = $this->Tiene_Internet->CurrentValue;
		$this->Tiene_Internet->ViewCustomAttributes = "";

		// Servicio_Internet
		$this->Servicio_Internet->ViewValue = $this->Servicio_Internet->CurrentValue;
		$this->Servicio_Internet->ViewCustomAttributes = "";

		// Estado_Internet
		if (strval($this->Estado_Internet->CurrentValue) <> "") {
			$this->Estado_Internet->ViewValue = $this->Estado_Internet->OptionCaption($this->Estado_Internet->CurrentValue);
		} else {
			$this->Estado_Internet->ViewValue = NULL;
		}
		$this->Estado_Internet->ViewCustomAttributes = "";

		// Quien_Paga
		$this->Quien_Paga->ViewValue = $this->Quien_Paga->CurrentValue;
		$this->Quien_Paga->ViewCustomAttributes = "";

		// Cue
		$this->Cue->LinkCustomAttributes = "";
		$this->Cue->HrefValue = "";
		$this->Cue->TooltipValue = "";

		// Sigla
		$this->Sigla->LinkCustomAttributes = "";
		$this->Sigla->HrefValue = "";
		$this->Sigla->TooltipValue = "";

		// Id_Zona
		$this->Id_Zona->LinkCustomAttributes = "";
		$this->Id_Zona->HrefValue = "";
		$this->Id_Zona->TooltipValue = "";

		// Usuario_Conig
		$this->Usuario_Conig->LinkCustomAttributes = "";
		$this->Usuario_Conig->HrefValue = "";
		$this->Usuario_Conig->TooltipValue = "";

		// Password_Conig
		$this->Password_Conig->LinkCustomAttributes = "";
		$this->Password_Conig->HrefValue = "";
		$this->Password_Conig->TooltipValue = "";

		// Tiene_Internet
		$this->Tiene_Internet->LinkCustomAttributes = "";
		$this->Tiene_Internet->HrefValue = "";
		$this->Tiene_Internet->TooltipValue = "";

		// Servicio_Internet
		$this->Servicio_Internet->LinkCustomAttributes = "";
		$this->Servicio_Internet->HrefValue = "";
		$this->Servicio_Internet->TooltipValue = "";

		// Estado_Internet
		$this->Estado_Internet->LinkCustomAttributes = "";
		$this->Estado_Internet->HrefValue = "";
		$this->Estado_Internet->TooltipValue = "";

		// Quien_Paga
		$this->Quien_Paga->LinkCustomAttributes = "";
		$this->Quien_Paga->HrefValue = "";
		$this->Quien_Paga->TooltipValue = "";

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

		// Sigla
		$this->Sigla->EditAttrs["class"] = "form-control";
		$this->Sigla->EditCustomAttributes = "";
		$this->Sigla->EditValue = $this->Sigla->CurrentValue;
		$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

		// Id_Zona
		$this->Id_Zona->EditAttrs["class"] = "form-control";
		$this->Id_Zona->EditCustomAttributes = "";

		// Usuario_Conig
		$this->Usuario_Conig->EditAttrs["class"] = "form-control";
		$this->Usuario_Conig->EditCustomAttributes = "";
		$this->Usuario_Conig->EditValue = $this->Usuario_Conig->CurrentValue;
		$this->Usuario_Conig->PlaceHolder = ew_RemoveHtml($this->Usuario_Conig->FldCaption());

		// Password_Conig
		$this->Password_Conig->EditAttrs["class"] = "form-control";
		$this->Password_Conig->EditCustomAttributes = "";
		$this->Password_Conig->EditValue = $this->Password_Conig->CurrentValue;
		$this->Password_Conig->PlaceHolder = ew_RemoveHtml($this->Password_Conig->FldCaption());

		// Tiene_Internet
		$this->Tiene_Internet->EditAttrs["class"] = "form-control";
		$this->Tiene_Internet->EditCustomAttributes = "";
		$this->Tiene_Internet->EditValue = $this->Tiene_Internet->CurrentValue;
		$this->Tiene_Internet->PlaceHolder = ew_RemoveHtml($this->Tiene_Internet->FldCaption());

		// Servicio_Internet
		$this->Servicio_Internet->EditAttrs["class"] = "form-control";
		$this->Servicio_Internet->EditCustomAttributes = "";
		$this->Servicio_Internet->EditValue = $this->Servicio_Internet->CurrentValue;
		$this->Servicio_Internet->PlaceHolder = ew_RemoveHtml($this->Servicio_Internet->FldCaption());

		// Estado_Internet
		$this->Estado_Internet->EditAttrs["class"] = "form-control";
		$this->Estado_Internet->EditCustomAttributes = "";
		$this->Estado_Internet->EditValue = $this->Estado_Internet->Options(TRUE);

		// Quien_Paga
		$this->Quien_Paga->EditAttrs["class"] = "form-control";
		$this->Quien_Paga->EditCustomAttributes = "";
		$this->Quien_Paga->EditValue = $this->Quien_Paga->CurrentValue;
		$this->Quien_Paga->PlaceHolder = ew_RemoveHtml($this->Quien_Paga->FldCaption());

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
					if ($this->Sigla->Exportable) $Doc->ExportCaption($this->Sigla);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->Usuario_Conig->Exportable) $Doc->ExportCaption($this->Usuario_Conig);
					if ($this->Password_Conig->Exportable) $Doc->ExportCaption($this->Password_Conig);
					if ($this->Tiene_Internet->Exportable) $Doc->ExportCaption($this->Tiene_Internet);
					if ($this->Servicio_Internet->Exportable) $Doc->ExportCaption($this->Servicio_Internet);
					if ($this->Estado_Internet->Exportable) $Doc->ExportCaption($this->Estado_Internet);
					if ($this->Quien_Paga->Exportable) $Doc->ExportCaption($this->Quien_Paga);
				} else {
					if ($this->Cue->Exportable) $Doc->ExportCaption($this->Cue);
					if ($this->Sigla->Exportable) $Doc->ExportCaption($this->Sigla);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->Usuario_Conig->Exportable) $Doc->ExportCaption($this->Usuario_Conig);
					if ($this->Password_Conig->Exportable) $Doc->ExportCaption($this->Password_Conig);
					if ($this->Tiene_Internet->Exportable) $Doc->ExportCaption($this->Tiene_Internet);
					if ($this->Servicio_Internet->Exportable) $Doc->ExportCaption($this->Servicio_Internet);
					if ($this->Estado_Internet->Exportable) $Doc->ExportCaption($this->Estado_Internet);
					if ($this->Quien_Paga->Exportable) $Doc->ExportCaption($this->Quien_Paga);
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
						if ($this->Sigla->Exportable) $Doc->ExportField($this->Sigla);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->Usuario_Conig->Exportable) $Doc->ExportField($this->Usuario_Conig);
						if ($this->Password_Conig->Exportable) $Doc->ExportField($this->Password_Conig);
						if ($this->Tiene_Internet->Exportable) $Doc->ExportField($this->Tiene_Internet);
						if ($this->Servicio_Internet->Exportable) $Doc->ExportField($this->Servicio_Internet);
						if ($this->Estado_Internet->Exportable) $Doc->ExportField($this->Estado_Internet);
						if ($this->Quien_Paga->Exportable) $Doc->ExportField($this->Quien_Paga);
					} else {
						if ($this->Cue->Exportable) $Doc->ExportField($this->Cue);
						if ($this->Sigla->Exportable) $Doc->ExportField($this->Sigla);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->Usuario_Conig->Exportable) $Doc->ExportField($this->Usuario_Conig);
						if ($this->Password_Conig->Exportable) $Doc->ExportField($this->Password_Conig);
						if ($this->Tiene_Internet->Exportable) $Doc->ExportField($this->Tiene_Internet);
						if ($this->Servicio_Internet->Exportable) $Doc->ExportField($this->Servicio_Internet);
						if ($this->Estado_Internet->Exportable) $Doc->ExportField($this->Estado_Internet);
						if ($this->Quien_Paga->Exportable) $Doc->ExportField($this->Quien_Paga);
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
