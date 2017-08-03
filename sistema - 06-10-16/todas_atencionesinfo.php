<?php

// Global variable for table object
$todas_atenciones = NULL;

//
// Table class for todas atenciones
//
class ctodas_atenciones extends cTable {
	var $Nro_Atenc_;
	var $Item;
	var $CUE;
	var $Escuela;
	var $Nro_Serie;
	var $Titular;
	var $Dni;
	var $Curso;
	var $Division;
	var $Fecha_Entrada;
	var $Falla;
	var $Problema;
	var $Solucion;
	var $Estado;
	var $Fecha_Actualiz_;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'todas_atenciones';
		$this->TableName = 'todas atenciones';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`todas atenciones`";
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

		// Nro Atenc.
		$this->Nro_Atenc_ = new cField('todas_atenciones', 'todas atenciones', 'x_Nro_Atenc_', 'Nro Atenc.', '`Nro Atenc.`', '`Nro Atenc.`', 3, -1, FALSE, '`Nro Atenc.`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Nro_Atenc_->Sortable = TRUE; // Allow sort
		$this->Nro_Atenc_->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Nro Atenc.'] = &$this->Nro_Atenc_;

		// Item
		$this->Item = new cField('todas_atenciones', 'todas atenciones', 'x_Item', 'Item', '`Item`', '`Item`', 3, -1, FALSE, '`Item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Item->Sortable = TRUE; // Allow sort
		$this->Item->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Item'] = &$this->Item;

		// CUE
		$this->CUE = new cField('todas_atenciones', 'todas atenciones', 'x_CUE', 'CUE', '`CUE`', '`CUE`', 200, -1, FALSE, '`CUE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CUE->Sortable = TRUE; // Allow sort
		$this->fields['CUE'] = &$this->CUE;

		// Escuela
		$this->Escuela = new cField('todas_atenciones', 'todas atenciones', 'x_Escuela', 'Escuela', '`Escuela`', '`Escuela`', 200, -1, FALSE, '`Escuela`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Escuela->Sortable = TRUE; // Allow sort
		$this->fields['Escuela'] = &$this->Escuela;

		// Nro Serie
		$this->Nro_Serie = new cField('todas_atenciones', 'todas atenciones', 'x_Nro_Serie', 'Nro Serie', '`Nro Serie`', '`Nro Serie`', 200, -1, FALSE, '`Nro Serie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Serie->Sortable = TRUE; // Allow sort
		$this->fields['Nro Serie'] = &$this->Nro_Serie;

		// Titular
		$this->Titular = new cField('todas_atenciones', 'todas atenciones', 'x_Titular', 'Titular', '`Titular`', '`Titular`', 201, -1, FALSE, '`Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Titular->Sortable = TRUE; // Allow sort
		$this->fields['Titular'] = &$this->Titular;

		// Dni
		$this->Dni = new cField('todas_atenciones', 'todas atenciones', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Curso
		$this->Curso = new cField('todas_atenciones', 'todas atenciones', 'x_Curso', 'Curso', '`Curso`', '`Curso`', 200, -1, FALSE, '`Curso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Curso->Sortable = TRUE; // Allow sort
		$this->fields['Curso'] = &$this->Curso;

		// Division
		$this->Division = new cField('todas_atenciones', 'todas atenciones', 'x_Division', 'Division', '`Division`', '`Division`', 200, -1, FALSE, '`Division`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Division->Sortable = TRUE; // Allow sort
		$this->fields['Division'] = &$this->Division;

		// Fecha Entrada
		$this->Fecha_Entrada = new cField('todas_atenciones', 'todas atenciones', 'x_Fecha_Entrada', 'Fecha Entrada', '`Fecha Entrada`', 'DATE_FORMAT(`Fecha Entrada`, \'\')', 133, 0, FALSE, '`Fecha Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Entrada->Sortable = TRUE; // Allow sort
		$this->Fecha_Entrada->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Fecha Entrada'] = &$this->Fecha_Entrada;

		// Falla
		$this->Falla = new cField('todas_atenciones', 'todas atenciones', 'x_Falla', 'Falla', '`Falla`', '`Falla`', 200, -1, FALSE, '`Falla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Falla->Sortable = TRUE; // Allow sort
		$this->Falla->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Falla->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Falla'] = &$this->Falla;

		// Problema
		$this->Problema = new cField('todas_atenciones', 'todas atenciones', 'x_Problema', 'Problema', '`Problema`', '`Problema`', 200, -1, FALSE, '`Problema`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Problema->Sortable = TRUE; // Allow sort
		$this->Problema->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Problema->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Problema'] = &$this->Problema;

		// Solucion
		$this->Solucion = new cField('todas_atenciones', 'todas atenciones', 'x_Solucion', 'Solucion', '`Solucion`', '`Solucion`', 200, -1, FALSE, '`Solucion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Solucion->Sortable = TRUE; // Allow sort
		$this->Solucion->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Solucion->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Solucion'] = &$this->Solucion;

		// Estado
		$this->Estado = new cField('todas_atenciones', 'todas atenciones', 'x_Estado', 'Estado', '`Estado`', '`Estado`', 200, -1, FALSE, '`Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Estado->Sortable = TRUE; // Allow sort
		$this->Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Estado'] = &$this->Estado;

		// Fecha Actualiz.
		$this->Fecha_Actualiz_ = new cField('todas_atenciones', 'todas atenciones', 'x_Fecha_Actualiz_', 'Fecha Actualiz.', '`Fecha Actualiz.`', 'DATE_FORMAT(`Fecha Actualiz.`, \'\')', 133, -1, FALSE, '`Fecha Actualiz.`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Actualiz_->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualiz_->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Fecha Actualiz.'] = &$this->Fecha_Actualiz_;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`todas atenciones`";
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
			if (array_key_exists('Nro Atenc.', $rs))
				ew_AddFilter($where, ew_QuotedName('Nro Atenc.', $this->DBID) . '=' . ew_QuotedValue($rs['Nro Atenc.'], $this->Nro_Atenc_->FldDataType, $this->DBID));
			if (array_key_exists('Item', $rs))
				ew_AddFilter($where, ew_QuotedName('Item', $this->DBID) . '=' . ew_QuotedValue($rs['Item'], $this->Item->FldDataType, $this->DBID));
			if (array_key_exists('CUE', $rs))
				ew_AddFilter($where, ew_QuotedName('CUE', $this->DBID) . '=' . ew_QuotedValue($rs['CUE'], $this->CUE->FldDataType, $this->DBID));
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
		return "`Nro Atenc.` = @Nro_Atenc_@ AND `Item` = @Item@ AND `CUE` = '@CUE@' AND `Dni` = @Dni@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Nro_Atenc_->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Nro_Atenc_@", ew_AdjustSql($this->Nro_Atenc_->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->Item->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Item@", ew_AdjustSql($this->Item->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@CUE@", ew_AdjustSql($this->CUE->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "todas_atencioneslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "todas_atencioneslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("todas_atencionesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("todas_atencionesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "todas_atencionesadd.php?" . $this->UrlParm($parm);
		else
			$url = "todas_atencionesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("todas_atencionesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("todas_atencionesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("todas_atencionesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Nro_Atenc_:" . ew_VarToJson($this->Nro_Atenc_->CurrentValue, "number", "'");
		$json .= ",Item:" . ew_VarToJson($this->Item->CurrentValue, "number", "'");
		$json .= ",CUE:" . ew_VarToJson($this->CUE->CurrentValue, "string", "'");
		$json .= ",Dni:" . ew_VarToJson($this->Dni->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Nro_Atenc_->CurrentValue)) {
			$sUrl .= "Nro_Atenc_=" . urlencode($this->Nro_Atenc_->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Item->CurrentValue)) {
			$sUrl .= "&Item=" . urlencode($this->Item->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->CUE->CurrentValue)) {
			$sUrl .= "&CUE=" . urlencode($this->CUE->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Dni->CurrentValue)) {
			$sUrl .= "&Dni=" . urlencode($this->Dni->CurrentValue);
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
			if ($isPost && isset($_POST["Nro_Atenc_"]))
				$arKey[] = ew_StripSlashes($_POST["Nro_Atenc_"]);
			elseif (isset($_GET["Nro_Atenc_"]))
				$arKey[] = ew_StripSlashes($_GET["Nro_Atenc_"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["Item"]))
				$arKey[] = ew_StripSlashes($_POST["Item"]);
			elseif (isset($_GET["Item"]))
				$arKey[] = ew_StripSlashes($_GET["Item"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["CUE"]))
				$arKey[] = ew_StripSlashes($_POST["CUE"]);
			elseif (isset($_GET["CUE"]))
				$arKey[] = ew_StripSlashes($_GET["CUE"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["Dni"]))
				$arKey[] = ew_StripSlashes($_POST["Dni"]);
			elseif (isset($_GET["Dni"]))
				$arKey[] = ew_StripSlashes($_GET["Dni"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 4)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // Nro Atenc.
					continue;
				if (!is_numeric($key[1])) // Item
					continue;
				if (!is_numeric($key[3])) // Dni
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
			$this->Nro_Atenc_->CurrentValue = $key[0];
			$this->Item->CurrentValue = $key[1];
			$this->CUE->CurrentValue = $key[2];
			$this->Dni->CurrentValue = $key[3];
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
		$this->Nro_Atenc_->setDbValue($rs->fields('Nro Atenc.'));
		$this->Item->setDbValue($rs->fields('Item'));
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Escuela->setDbValue($rs->fields('Escuela'));
		$this->Nro_Serie->setDbValue($rs->fields('Nro Serie'));
		$this->Titular->setDbValue($rs->fields('Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Curso->setDbValue($rs->fields('Curso'));
		$this->Division->setDbValue($rs->fields('Division'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha Entrada'));
		$this->Falla->setDbValue($rs->fields('Falla'));
		$this->Problema->setDbValue($rs->fields('Problema'));
		$this->Solucion->setDbValue($rs->fields('Solucion'));
		$this->Estado->setDbValue($rs->fields('Estado'));
		$this->Fecha_Actualiz_->setDbValue($rs->fields('Fecha Actualiz.'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Nro Atenc.
		// Item
		// CUE
		// Escuela
		// Nro Serie
		// Titular
		// Dni
		// Curso
		// Division
		// Fecha Entrada
		// Falla
		// Problema
		// Solucion
		// Estado
		// Fecha Actualiz.
		// Nro Atenc.

		$this->Nro_Atenc_->ViewValue = $this->Nro_Atenc_->CurrentValue;
		$this->Nro_Atenc_->ViewCustomAttributes = "";

		// Item
		$this->Item->ViewValue = $this->Item->CurrentValue;
		$this->Item->ViewCustomAttributes = "";

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Escuela
		$this->Escuela->ViewValue = $this->Escuela->CurrentValue;
		$this->Escuela->ViewCustomAttributes = "";

		// Nro Serie
		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		if (strval($this->Nro_Serie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Nro_Serie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nro_Serie->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nro_Serie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nro_Serie->ViewValue = $this->Nro_Serie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
			}
		} else {
			$this->Nro_Serie->ViewValue = NULL;
		}
		$this->Nro_Serie->ViewCustomAttributes = "";

		// Titular
		$this->Titular->ViewValue = $this->Titular->CurrentValue;
		$this->Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Curso
		$this->Curso->ViewValue = $this->Curso->CurrentValue;
		$this->Curso->ViewCustomAttributes = "";

		// Division
		$this->Division->ViewValue = $this->Division->CurrentValue;
		$this->Division->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 0);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Falla
		if (strval($this->Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Falla->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Falla->ViewValue = $this->Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Falla->ViewValue = $this->Falla->CurrentValue;
			}
		} else {
			$this->Falla->ViewValue = NULL;
		}
		$this->Falla->ViewCustomAttributes = "";

		// Problema
		if (strval($this->Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Problema->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Problema->ViewValue = $this->Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Problema->ViewValue = $this->Problema->CurrentValue;
			}
		} else {
			$this->Problema->ViewValue = NULL;
		}
		$this->Problema->ViewCustomAttributes = "";

		// Solucion
		if (strval($this->Solucion->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Solucion->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Solucion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Solucion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Solucion->ViewValue = $this->Solucion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Solucion->ViewValue = $this->Solucion->CurrentValue;
			}
		} else {
			$this->Solucion->ViewValue = NULL;
		}
		$this->Solucion->ViewCustomAttributes = "";

		// Estado
		if (strval($this->Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Estado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado->ViewValue = $this->Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado->ViewValue = $this->Estado->CurrentValue;
			}
		} else {
			$this->Estado->ViewValue = NULL;
		}
		$this->Estado->ViewCustomAttributes = "";

		// Fecha Actualiz.
		$this->Fecha_Actualiz_->ViewValue = $this->Fecha_Actualiz_->CurrentValue;
		$this->Fecha_Actualiz_->ViewCustomAttributes = "";

		// Nro Atenc.
		$this->Nro_Atenc_->LinkCustomAttributes = "";
		$this->Nro_Atenc_->HrefValue = "";
		$this->Nro_Atenc_->TooltipValue = "";

		// Item
		$this->Item->LinkCustomAttributes = "";
		$this->Item->HrefValue = "";
		$this->Item->TooltipValue = "";

		// CUE
		$this->CUE->LinkCustomAttributes = "";
		$this->CUE->HrefValue = "";
		$this->CUE->TooltipValue = "";

		// Escuela
		$this->Escuela->LinkCustomAttributes = "";
		$this->Escuela->HrefValue = "";
		$this->Escuela->TooltipValue = "";

		// Nro Serie
		$this->Nro_Serie->LinkCustomAttributes = "";
		$this->Nro_Serie->HrefValue = "";
		$this->Nro_Serie->TooltipValue = "";

		// Titular
		$this->Titular->LinkCustomAttributes = "";
		$this->Titular->HrefValue = "";
		$this->Titular->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Curso
		$this->Curso->LinkCustomAttributes = "";
		$this->Curso->HrefValue = "";
		$this->Curso->TooltipValue = "";

		// Division
		$this->Division->LinkCustomAttributes = "";
		$this->Division->HrefValue = "";
		$this->Division->TooltipValue = "";

		// Fecha Entrada
		$this->Fecha_Entrada->LinkCustomAttributes = "";
		$this->Fecha_Entrada->HrefValue = "";
		$this->Fecha_Entrada->TooltipValue = "";

		// Falla
		$this->Falla->LinkCustomAttributes = "";
		$this->Falla->HrefValue = "";
		$this->Falla->TooltipValue = "";

		// Problema
		$this->Problema->LinkCustomAttributes = "";
		$this->Problema->HrefValue = "";
		$this->Problema->TooltipValue = "";

		// Solucion
		$this->Solucion->LinkCustomAttributes = "";
		$this->Solucion->HrefValue = "";
		$this->Solucion->TooltipValue = "";

		// Estado
		$this->Estado->LinkCustomAttributes = "";
		$this->Estado->HrefValue = "";
		$this->Estado->TooltipValue = "";

		// Fecha Actualiz.
		$this->Fecha_Actualiz_->LinkCustomAttributes = "";
		$this->Fecha_Actualiz_->HrefValue = "";
		$this->Fecha_Actualiz_->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Nro Atenc.
		$this->Nro_Atenc_->EditAttrs["class"] = "form-control";
		$this->Nro_Atenc_->EditCustomAttributes = "";
		$this->Nro_Atenc_->EditValue = $this->Nro_Atenc_->CurrentValue;
		$this->Nro_Atenc_->ViewCustomAttributes = "";

		// Item
		$this->Item->EditAttrs["class"] = "form-control";
		$this->Item->EditCustomAttributes = "";
		$this->Item->EditValue = $this->Item->CurrentValue;
		$this->Item->ViewCustomAttributes = "";

		// CUE
		$this->CUE->EditAttrs["class"] = "form-control";
		$this->CUE->EditCustomAttributes = "";
		$this->CUE->EditValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Escuela
		$this->Escuela->EditAttrs["class"] = "form-control";
		$this->Escuela->EditCustomAttributes = "";
		$this->Escuela->EditValue = $this->Escuela->CurrentValue;
		$this->Escuela->PlaceHolder = ew_RemoveHtml($this->Escuela->FldCaption());

		// Nro Serie
		$this->Nro_Serie->EditAttrs["class"] = "form-control";
		$this->Nro_Serie->EditCustomAttributes = "";
		$this->Nro_Serie->EditValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->PlaceHolder = ew_RemoveHtml($this->Nro_Serie->FldCaption());

		// Titular
		$this->Titular->EditAttrs["class"] = "form-control";
		$this->Titular->EditCustomAttributes = "";
		$this->Titular->EditValue = $this->Titular->CurrentValue;
		$this->Titular->PlaceHolder = ew_RemoveHtml($this->Titular->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Curso
		$this->Curso->EditAttrs["class"] = "form-control";
		$this->Curso->EditCustomAttributes = "";
		$this->Curso->EditValue = $this->Curso->CurrentValue;
		$this->Curso->PlaceHolder = ew_RemoveHtml($this->Curso->FldCaption());

		// Division
		$this->Division->EditAttrs["class"] = "form-control";
		$this->Division->EditCustomAttributes = "";
		$this->Division->EditValue = $this->Division->CurrentValue;
		$this->Division->PlaceHolder = ew_RemoveHtml($this->Division->FldCaption());

		// Fecha Entrada
		$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
		$this->Fecha_Entrada->EditCustomAttributes = "";
		$this->Fecha_Entrada->EditValue = ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 8);
		$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

		// Falla
		$this->Falla->EditAttrs["class"] = "form-control";
		$this->Falla->EditCustomAttributes = "";

		// Problema
		$this->Problema->EditAttrs["class"] = "form-control";
		$this->Problema->EditCustomAttributes = "";

		// Solucion
		$this->Solucion->EditAttrs["class"] = "form-control";
		$this->Solucion->EditCustomAttributes = "";

		// Estado
		$this->Estado->EditAttrs["class"] = "form-control";
		$this->Estado->EditCustomAttributes = "";

		// Fecha Actualiz.
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
					if ($this->Nro_Atenc_->Exportable) $Doc->ExportCaption($this->Nro_Atenc_);
					if ($this->Item->Exportable) $Doc->ExportCaption($this->Item);
					if ($this->CUE->Exportable) $Doc->ExportCaption($this->CUE);
					if ($this->Escuela->Exportable) $Doc->ExportCaption($this->Escuela);
					if ($this->Nro_Serie->Exportable) $Doc->ExportCaption($this->Nro_Serie);
					if ($this->Titular->Exportable) $Doc->ExportCaption($this->Titular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Curso->Exportable) $Doc->ExportCaption($this->Curso);
					if ($this->Division->Exportable) $Doc->ExportCaption($this->Division);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Falla->Exportable) $Doc->ExportCaption($this->Falla);
					if ($this->Problema->Exportable) $Doc->ExportCaption($this->Problema);
					if ($this->Solucion->Exportable) $Doc->ExportCaption($this->Solucion);
					if ($this->Estado->Exportable) $Doc->ExportCaption($this->Estado);
					if ($this->Fecha_Actualiz_->Exportable) $Doc->ExportCaption($this->Fecha_Actualiz_);
				} else {
					if ($this->Nro_Atenc_->Exportable) $Doc->ExportCaption($this->Nro_Atenc_);
					if ($this->Item->Exportable) $Doc->ExportCaption($this->Item);
					if ($this->CUE->Exportable) $Doc->ExportCaption($this->CUE);
					if ($this->Escuela->Exportable) $Doc->ExportCaption($this->Escuela);
					if ($this->Nro_Serie->Exportable) $Doc->ExportCaption($this->Nro_Serie);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Curso->Exportable) $Doc->ExportCaption($this->Curso);
					if ($this->Division->Exportable) $Doc->ExportCaption($this->Division);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Falla->Exportable) $Doc->ExportCaption($this->Falla);
					if ($this->Problema->Exportable) $Doc->ExportCaption($this->Problema);
					if ($this->Solucion->Exportable) $Doc->ExportCaption($this->Solucion);
					if ($this->Estado->Exportable) $Doc->ExportCaption($this->Estado);
					if ($this->Fecha_Actualiz_->Exportable) $Doc->ExportCaption($this->Fecha_Actualiz_);
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
						if ($this->Nro_Atenc_->Exportable) $Doc->ExportField($this->Nro_Atenc_);
						if ($this->Item->Exportable) $Doc->ExportField($this->Item);
						if ($this->CUE->Exportable) $Doc->ExportField($this->CUE);
						if ($this->Escuela->Exportable) $Doc->ExportField($this->Escuela);
						if ($this->Nro_Serie->Exportable) $Doc->ExportField($this->Nro_Serie);
						if ($this->Titular->Exportable) $Doc->ExportField($this->Titular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Curso->Exportable) $Doc->ExportField($this->Curso);
						if ($this->Division->Exportable) $Doc->ExportField($this->Division);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Falla->Exportable) $Doc->ExportField($this->Falla);
						if ($this->Problema->Exportable) $Doc->ExportField($this->Problema);
						if ($this->Solucion->Exportable) $Doc->ExportField($this->Solucion);
						if ($this->Estado->Exportable) $Doc->ExportField($this->Estado);
						if ($this->Fecha_Actualiz_->Exportable) $Doc->ExportField($this->Fecha_Actualiz_);
					} else {
						if ($this->Nro_Atenc_->Exportable) $Doc->ExportField($this->Nro_Atenc_);
						if ($this->Item->Exportable) $Doc->ExportField($this->Item);
						if ($this->CUE->Exportable) $Doc->ExportField($this->CUE);
						if ($this->Escuela->Exportable) $Doc->ExportField($this->Escuela);
						if ($this->Nro_Serie->Exportable) $Doc->ExportField($this->Nro_Serie);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Curso->Exportable) $Doc->ExportField($this->Curso);
						if ($this->Division->Exportable) $Doc->ExportField($this->Division);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Falla->Exportable) $Doc->ExportField($this->Falla);
						if ($this->Problema->Exportable) $Doc->ExportField($this->Problema);
						if ($this->Solucion->Exportable) $Doc->ExportField($this->Solucion);
						if ($this->Estado->Exportable) $Doc->ExportField($this->Estado);
						if ($this->Fecha_Actualiz_->Exportable) $Doc->ExportField($this->Fecha_Actualiz_);
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
