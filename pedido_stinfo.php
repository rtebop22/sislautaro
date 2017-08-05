<?php

// Global variable for table object
$pedido_st = NULL;

//
// Table class for pedido_st
//
class cpedido_st extends cTable {
	var $CUE;
	var $Sigla;
	var $Id_Zona;
	var $DEPARTAMENTO;
	var $LOCALIDAD;
	var $SERIE_NETBOOK;
	var $NB0_TIKET;
	var $PROBLEMA;
	var $Id_Tipo_Retiro;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pedido_st';
		$this->TableName = 'pedido_st';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`pedido_st`";
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

		// CUE
		$this->CUE = new cField('pedido_st', 'pedido_st', 'x_CUE', 'CUE', '`CUE`', '`CUE`', 200, -1, FALSE, '`CUE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CUE->Sortable = TRUE; // Allow sort
		$this->fields['CUE'] = &$this->CUE;

		// Sigla
		$this->Sigla = new cField('pedido_st', 'pedido_st', 'x_Sigla', 'Sigla', '`Sigla`', '`Sigla`', 200, -1, FALSE, '`Sigla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sigla->Sortable = TRUE; // Allow sort
		$this->fields['Sigla'] = &$this->Sigla;

		// Id_Zona
		$this->Id_Zona = new cField('pedido_st', 'pedido_st', 'x_Id_Zona', 'Id_Zona', '`Id_Zona`', '`Id_Zona`', 3, -1, FALSE, '`Id_Zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Zona->Sortable = TRUE; // Allow sort
		$this->Id_Zona->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Zona->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Zona->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Zona'] = &$this->Id_Zona;

		// DEPARTAMENTO
		$this->DEPARTAMENTO = new cField('pedido_st', 'pedido_st', 'x_DEPARTAMENTO', 'DEPARTAMENTO', '`DEPARTAMENTO`', '`DEPARTAMENTO`', 200, -1, FALSE, '`DEPARTAMENTO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->DEPARTAMENTO->Sortable = TRUE; // Allow sort
		$this->DEPARTAMENTO->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->DEPARTAMENTO->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['DEPARTAMENTO'] = &$this->DEPARTAMENTO;

		// LOCALIDAD
		$this->LOCALIDAD = new cField('pedido_st', 'pedido_st', 'x_LOCALIDAD', 'LOCALIDAD', '`LOCALIDAD`', '`LOCALIDAD`', 200, -1, FALSE, '`LOCALIDAD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LOCALIDAD->Sortable = TRUE; // Allow sort
		$this->fields['LOCALIDAD'] = &$this->LOCALIDAD;

		// SERIE NETBOOK
		$this->SERIE_NETBOOK = new cField('pedido_st', 'pedido_st', 'x_SERIE_NETBOOK', 'SERIE NETBOOK', '`SERIE NETBOOK`', '`SERIE NETBOOK`', 200, -1, FALSE, '`SERIE NETBOOK`', FALSE, FALSE, FALSE, 'IMAGE', 'TEXT');
		$this->SERIE_NETBOOK->Sortable = TRUE; // Allow sort
		$this->fields['SERIE NETBOOK'] = &$this->SERIE_NETBOOK;

		// N° TIKET
		$this->NB0_TIKET = new cField('pedido_st', 'pedido_st', 'x_NB0_TIKET', 'N° TIKET', '`N° TIKET`', '`N° TIKET`', 200, -1, FALSE, '`N° TIKET`', FALSE, FALSE, FALSE, 'IMAGE', 'TEXT');
		$this->NB0_TIKET->Sortable = TRUE; // Allow sort
		$this->fields['N° TIKET'] = &$this->NB0_TIKET;

		// PROBLEMA
		$this->PROBLEMA = new cField('pedido_st', 'pedido_st', 'x_PROBLEMA', 'PROBLEMA', '`PROBLEMA`', '`PROBLEMA`', 200, -1, FALSE, '`PROBLEMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PROBLEMA->Sortable = TRUE; // Allow sort
		$this->fields['PROBLEMA'] = &$this->PROBLEMA;

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro = new cField('pedido_st', 'pedido_st', 'x_Id_Tipo_Retiro', 'Id_Tipo_Retiro', '`Id_Tipo_Retiro`', '`Id_Tipo_Retiro`', 3, -1, FALSE, '`Id_Tipo_Retiro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Retiro->Sortable = FALSE; // Allow sort
		$this->Id_Tipo_Retiro->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Retiro->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Tipo_Retiro->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tipo_Retiro'] = &$this->Id_Tipo_Retiro;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pedido_st`";
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
			if (array_key_exists('CUE', $rs))
				ew_AddFilter($where, ew_QuotedName('CUE', $this->DBID) . '=' . ew_QuotedValue($rs['CUE'], $this->CUE->FldDataType, $this->DBID));
			if (array_key_exists('SERIE NETBOOK', $rs))
				ew_AddFilter($where, ew_QuotedName('SERIE NETBOOK', $this->DBID) . '=' . ew_QuotedValue($rs['SERIE NETBOOK'], $this->SERIE_NETBOOK->FldDataType, $this->DBID));
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
		return "`CUE` = '@CUE@' AND `SERIE NETBOOK` = '@SERIE_NETBOOK@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@CUE@", ew_AdjustSql($this->CUE->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@SERIE_NETBOOK@", ew_AdjustSql($this->SERIE_NETBOOK->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "pedido_stlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pedido_stlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pedido_stview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pedido_stview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pedido_stadd.php?" . $this->UrlParm($parm);
		else
			$url = "pedido_stadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pedido_stedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pedido_stadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pedido_stdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "CUE:" . ew_VarToJson($this->CUE->CurrentValue, "string", "'");
		$json .= ",SERIE_NETBOOK:" . ew_VarToJson($this->SERIE_NETBOOK->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->CUE->CurrentValue)) {
			$sUrl .= "CUE=" . urlencode($this->CUE->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->SERIE_NETBOOK->CurrentValue)) {
			$sUrl .= "&SERIE_NETBOOK=" . urlencode($this->SERIE_NETBOOK->CurrentValue);
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
			if ($isPost && isset($_POST["CUE"]))
				$arKey[] = ew_StripSlashes($_POST["CUE"]);
			elseif (isset($_GET["CUE"]))
				$arKey[] = ew_StripSlashes($_GET["CUE"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["SERIE_NETBOOK"]))
				$arKey[] = ew_StripSlashes($_POST["SERIE_NETBOOK"]);
			elseif (isset($_GET["SERIE_NETBOOK"]))
				$arKey[] = ew_StripSlashes($_GET["SERIE_NETBOOK"]);
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
			$this->CUE->CurrentValue = $key[0];
			$this->SERIE_NETBOOK->CurrentValue = $key[1];
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
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->DEPARTAMENTO->setDbValue($rs->fields('DEPARTAMENTO'));
		$this->LOCALIDAD->setDbValue($rs->fields('LOCALIDAD'));
		$this->SERIE_NETBOOK->setDbValue($rs->fields('SERIE NETBOOK'));
		$this->NB0_TIKET->setDbValue($rs->fields('N° TIKET'));
		$this->PROBLEMA->setDbValue($rs->fields('PROBLEMA'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CUE
		// Sigla
		// Id_Zona
		// DEPARTAMENTO
		// LOCALIDAD
		// SERIE NETBOOK
		// N° TIKET
		// PROBLEMA
		// Id_Tipo_Retiro

		$this->Id_Tipo_Retiro->CellCssStyle = "white-space: nowrap;";

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

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

		// DEPARTAMENTO
		if (strval($this->DEPARTAMENTO->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->DEPARTAMENTO->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->DEPARTAMENTO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DEPARTAMENTO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->CurrentValue;
			}
		} else {
			$this->DEPARTAMENTO->ViewValue = NULL;
		}
		$this->DEPARTAMENTO->ViewCustomAttributes = "";

		// LOCALIDAD
		$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
		if (strval($this->LOCALIDAD->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->LOCALIDAD->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->LOCALIDAD->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
			}
		} else {
			$this->LOCALIDAD->ViewValue = NULL;
		}
		$this->LOCALIDAD->ViewCustomAttributes = "";

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->CurrentValue;
		$this->SERIE_NETBOOK->ImageAlt = $this->SERIE_NETBOOK->FldAlt();
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// N° TIKET
		$this->NB0_TIKET->ViewValue = $this->NB0_TIKET->CurrentValue;
		$this->NB0_TIKET->ImageAlt = $this->NB0_TIKET->FldAlt();
		$this->NB0_TIKET->ViewCustomAttributes = "";

		// PROBLEMA
		$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
		if (strval($this->PROBLEMA->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->PROBLEMA->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->PROBLEMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
			}
		} else {
			$this->PROBLEMA->ViewValue = NULL;
		}
		$this->PROBLEMA->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Retiro->ViewValue = NULL;
		}
		$this->Id_Tipo_Retiro->ViewCustomAttributes = "";

		// CUE
		$this->CUE->LinkCustomAttributes = "";
		$this->CUE->HrefValue = "";
		$this->CUE->TooltipValue = "";

		// Sigla
		$this->Sigla->LinkCustomAttributes = "";
		$this->Sigla->HrefValue = "";
		$this->Sigla->TooltipValue = "";

		// Id_Zona
		$this->Id_Zona->LinkCustomAttributes = "";
		$this->Id_Zona->HrefValue = "";
		$this->Id_Zona->TooltipValue = "";

		// DEPARTAMENTO
		$this->DEPARTAMENTO->LinkCustomAttributes = "";
		$this->DEPARTAMENTO->HrefValue = "";
		$this->DEPARTAMENTO->TooltipValue = "";

		// LOCALIDAD
		$this->LOCALIDAD->LinkCustomAttributes = "";
		$this->LOCALIDAD->HrefValue = "";
		$this->LOCALIDAD->TooltipValue = "";

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->LinkCustomAttributes = "";
		$this->SERIE_NETBOOK->HrefValue = "";
		$this->SERIE_NETBOOK->TooltipValue = "";

		// N° TIKET
		$this->NB0_TIKET->LinkCustomAttributes = "";
		$this->NB0_TIKET->HrefValue = "";
		$this->NB0_TIKET->TooltipValue = "";

		// PROBLEMA
		$this->PROBLEMA->LinkCustomAttributes = "";
		$this->PROBLEMA->HrefValue = "";
		$this->PROBLEMA->TooltipValue = "";

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
		$this->Id_Tipo_Retiro->HrefValue = "";
		$this->Id_Tipo_Retiro->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// CUE
		$this->CUE->EditAttrs["class"] = "form-control";
		$this->CUE->EditCustomAttributes = "";
		$this->CUE->EditValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->EditAttrs["class"] = "form-control";
		$this->Sigla->EditCustomAttributes = "";
		$this->Sigla->EditValue = $this->Sigla->CurrentValue;
		$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

		// Id_Zona
		$this->Id_Zona->EditAttrs["class"] = "form-control";
		$this->Id_Zona->EditCustomAttributes = "";

		// DEPARTAMENTO
		$this->DEPARTAMENTO->EditAttrs["class"] = "form-control";
		$this->DEPARTAMENTO->EditCustomAttributes = "";

		// LOCALIDAD
		$this->LOCALIDAD->EditAttrs["class"] = "form-control";
		$this->LOCALIDAD->EditCustomAttributes = "";
		$this->LOCALIDAD->EditValue = $this->LOCALIDAD->CurrentValue;
		$this->LOCALIDAD->PlaceHolder = ew_RemoveHtml($this->LOCALIDAD->FldCaption());

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->EditAttrs["class"] = "form-control";
		$this->SERIE_NETBOOK->EditCustomAttributes = "";
		$this->SERIE_NETBOOK->EditValue = $this->SERIE_NETBOOK->CurrentValue;
		$this->SERIE_NETBOOK->ImageAlt = $this->SERIE_NETBOOK->FldAlt();
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// N° TIKET
		$this->NB0_TIKET->EditAttrs["class"] = "form-control";
		$this->NB0_TIKET->EditCustomAttributes = "";
		$this->NB0_TIKET->EditValue = $this->NB0_TIKET->CurrentValue;
		$this->NB0_TIKET->PlaceHolder = ew_RemoveHtml($this->NB0_TIKET->FldCaption());

		// PROBLEMA
		$this->PROBLEMA->EditAttrs["class"] = "form-control";
		$this->PROBLEMA->EditCustomAttributes = "";
		$this->PROBLEMA->EditValue = $this->PROBLEMA->CurrentValue;
		$this->PROBLEMA->PlaceHolder = ew_RemoveHtml($this->PROBLEMA->FldCaption());

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Retiro->EditCustomAttributes = "";

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
					if ($this->CUE->Exportable) $Doc->ExportCaption($this->CUE);
					if ($this->Sigla->Exportable) $Doc->ExportCaption($this->Sigla);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->DEPARTAMENTO->Exportable) $Doc->ExportCaption($this->DEPARTAMENTO);
					if ($this->LOCALIDAD->Exportable) $Doc->ExportCaption($this->LOCALIDAD);
					if ($this->SERIE_NETBOOK->Exportable) $Doc->ExportCaption($this->SERIE_NETBOOK);
					if ($this->NB0_TIKET->Exportable) $Doc->ExportCaption($this->NB0_TIKET);
					if ($this->PROBLEMA->Exportable) $Doc->ExportCaption($this->PROBLEMA);
				} else {
					if ($this->CUE->Exportable) $Doc->ExportCaption($this->CUE);
					if ($this->Sigla->Exportable) $Doc->ExportCaption($this->Sigla);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->DEPARTAMENTO->Exportable) $Doc->ExportCaption($this->DEPARTAMENTO);
					if ($this->LOCALIDAD->Exportable) $Doc->ExportCaption($this->LOCALIDAD);
					if ($this->SERIE_NETBOOK->Exportable) $Doc->ExportCaption($this->SERIE_NETBOOK);
					if ($this->NB0_TIKET->Exportable) $Doc->ExportCaption($this->NB0_TIKET);
					if ($this->PROBLEMA->Exportable) $Doc->ExportCaption($this->PROBLEMA);
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
						if ($this->CUE->Exportable) $Doc->ExportField($this->CUE);
						if ($this->Sigla->Exportable) $Doc->ExportField($this->Sigla);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->DEPARTAMENTO->Exportable) $Doc->ExportField($this->DEPARTAMENTO);
						if ($this->LOCALIDAD->Exportable) $Doc->ExportField($this->LOCALIDAD);
						if ($this->SERIE_NETBOOK->Exportable) $Doc->ExportField($this->SERIE_NETBOOK);
						if ($this->NB0_TIKET->Exportable) $Doc->ExportField($this->NB0_TIKET);
						if ($this->PROBLEMA->Exportable) $Doc->ExportField($this->PROBLEMA);
					} else {
						if ($this->CUE->Exportable) $Doc->ExportField($this->CUE);
						if ($this->Sigla->Exportable) $Doc->ExportField($this->Sigla);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->DEPARTAMENTO->Exportable) $Doc->ExportField($this->DEPARTAMENTO);
						if ($this->LOCALIDAD->Exportable) $Doc->ExportField($this->LOCALIDAD);
						if ($this->SERIE_NETBOOK->Exportable) $Doc->ExportField($this->SERIE_NETBOOK);
						if ($this->NB0_TIKET->Exportable) $Doc->ExportField($this->NB0_TIKET);
						if ($this->PROBLEMA->Exportable) $Doc->ExportField($this->PROBLEMA);
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
