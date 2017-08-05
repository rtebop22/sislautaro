<?php

// Global variable for table object
$todas_atenciones = NULL;

//
// Table class for todas_atenciones
//
class ctodas_atenciones extends cTable {
	var $NB0_Atencion;
	var $Serie_Equipo;
	var $Fecha_Entrada;
	var $Nombre_Titular;
	var $Dni;
	var $Descripcion_Problema;
	var $Id_Tipo_Falla;
	var $Id_Problema;
	var $Id_Tipo_Sol_Problem;
	var $Id_Estado_Atenc;
	var $Usuario_que_cargo;
	var $Ultima_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'todas_atenciones';
		$this->TableName = 'todas_atenciones';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`todas_atenciones`";
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

		// N° Atencion
		$this->NB0_Atencion = new cField('todas_atenciones', 'todas_atenciones', 'x_NB0_Atencion', 'N° Atencion', '`N° Atencion`', '`N° Atencion`', 3, -1, FALSE, '`N° Atencion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->NB0_Atencion->Sortable = TRUE; // Allow sort
		$this->NB0_Atencion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['N° Atencion'] = &$this->NB0_Atencion;

		// Serie Equipo
		$this->Serie_Equipo = new cField('todas_atenciones', 'todas_atenciones', 'x_Serie_Equipo', 'Serie Equipo', '`Serie Equipo`', '`Serie Equipo`', 200, -1, FALSE, '`Serie Equipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Equipo->Sortable = TRUE; // Allow sort
		$this->fields['Serie Equipo'] = &$this->Serie_Equipo;

		// Fecha Entrada
		$this->Fecha_Entrada = new cField('todas_atenciones', 'todas_atenciones', 'x_Fecha_Entrada', 'Fecha Entrada', '`Fecha Entrada`', 'DATE_FORMAT(`Fecha Entrada`, \'\')', 133, 0, FALSE, '`Fecha Entrada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Entrada->Sortable = TRUE; // Allow sort
		$this->Fecha_Entrada->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Fecha Entrada'] = &$this->Fecha_Entrada;

		// Nombre Titular
		$this->Nombre_Titular = new cField('todas_atenciones', 'todas_atenciones', 'x_Nombre_Titular', 'Nombre Titular', '`Nombre Titular`', '`Nombre Titular`', 201, -1, FALSE, '`Nombre Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Nombre_Titular->Sortable = TRUE; // Allow sort
		$this->fields['Nombre Titular'] = &$this->Nombre_Titular;

		// Dni
		$this->Dni = new cField('todas_atenciones', 'todas_atenciones', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Descripcion Problema
		$this->Descripcion_Problema = new cField('todas_atenciones', 'todas_atenciones', 'x_Descripcion_Problema', 'Descripcion Problema', '`Descripcion Problema`', '`Descripcion Problema`', 201, -1, FALSE, '`Descripcion Problema`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Descripcion_Problema->Sortable = TRUE; // Allow sort
		$this->fields['Descripcion Problema'] = &$this->Descripcion_Problema;

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla = new cField('todas_atenciones', 'todas_atenciones', 'x_Id_Tipo_Falla', 'Id_Tipo_Falla', '`Id_Tipo_Falla`', '`Id_Tipo_Falla`', 3, -1, FALSE, '`Id_Tipo_Falla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Falla->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Falla->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Falla->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Tipo_Falla'] = &$this->Id_Tipo_Falla;

		// Id_Problema
		$this->Id_Problema = new cField('todas_atenciones', 'todas_atenciones', 'x_Id_Problema', 'Id_Problema', '`Id_Problema`', '`Id_Problema`', 3, -1, FALSE, '`Id_Problema`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Problema->Sortable = TRUE; // Allow sort
		$this->Id_Problema->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Problema->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Problema'] = &$this->Id_Problema;

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem = new cField('todas_atenciones', 'todas_atenciones', 'x_Id_Tipo_Sol_Problem', 'Id_Tipo_Sol_Problem', '`Id_Tipo_Sol_Problem`', '`Id_Tipo_Sol_Problem`', 3, -1, FALSE, '`Id_Tipo_Sol_Problem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Sol_Problem->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Sol_Problem->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Sol_Problem->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Tipo_Sol_Problem'] = &$this->Id_Tipo_Sol_Problem;

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc = new cField('todas_atenciones', 'todas_atenciones', 'x_Id_Estado_Atenc', 'Id_Estado_Atenc', '`Id_Estado_Atenc`', '`Id_Estado_Atenc`', 3, -1, FALSE, '`Id_Estado_Atenc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Atenc->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Atenc->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Atenc->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Estado_Atenc'] = &$this->Id_Estado_Atenc;

		// Usuario que cargo
		$this->Usuario_que_cargo = new cField('todas_atenciones', 'todas_atenciones', 'x_Usuario_que_cargo', 'Usuario que cargo', '`Usuario que cargo`', '`Usuario que cargo`', 200, -1, FALSE, '`Usuario que cargo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Usuario_que_cargo->Sortable = TRUE; // Allow sort
		$this->fields['Usuario que cargo'] = &$this->Usuario_que_cargo;

		// Ultima Actualizacion
		$this->Ultima_Actualizacion = new cField('todas_atenciones', 'todas_atenciones', 'x_Ultima_Actualizacion', 'Ultima Actualizacion', '`Ultima Actualizacion`', 'DATE_FORMAT(`Ultima Actualizacion`, \'\')', 133, 0, FALSE, '`Ultima Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Ultima_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Ultima_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Ultima Actualizacion'] = &$this->Ultima_Actualizacion;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`todas_atenciones`";
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
			if (array_key_exists('N° Atencion', $rs))
				ew_AddFilter($where, ew_QuotedName('N° Atencion', $this->DBID) . '=' . ew_QuotedValue($rs['N° Atencion'], $this->NB0_Atencion->FldDataType, $this->DBID));
			if (array_key_exists('Serie Equipo', $rs))
				ew_AddFilter($where, ew_QuotedName('Serie Equipo', $this->DBID) . '=' . ew_QuotedValue($rs['Serie Equipo'], $this->Serie_Equipo->FldDataType, $this->DBID));
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
		return "`N° Atencion` = @NB0_Atencion@ AND `Serie Equipo` = '@Serie_Equipo@' AND `Dni` = @Dni@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->NB0_Atencion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@NB0_Atencion@", ew_AdjustSql($this->NB0_Atencion->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@Serie_Equipo@", ew_AdjustSql($this->Serie_Equipo->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
		$json .= "NB0_Atencion:" . ew_VarToJson($this->NB0_Atencion->CurrentValue, "number", "'");
		$json .= ",Serie_Equipo:" . ew_VarToJson($this->Serie_Equipo->CurrentValue, "string", "'");
		$json .= ",Dni:" . ew_VarToJson($this->Dni->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->NB0_Atencion->CurrentValue)) {
			$sUrl .= "NB0_Atencion=" . urlencode($this->NB0_Atencion->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Serie_Equipo->CurrentValue)) {
			$sUrl .= "&Serie_Equipo=" . urlencode($this->Serie_Equipo->CurrentValue);
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
			if ($isPost && isset($_POST["NB0_Atencion"]))
				$arKey[] = ew_StripSlashes($_POST["NB0_Atencion"]);
			elseif (isset($_GET["NB0_Atencion"]))
				$arKey[] = ew_StripSlashes($_GET["NB0_Atencion"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["Serie_Equipo"]))
				$arKey[] = ew_StripSlashes($_POST["Serie_Equipo"]);
			elseif (isset($_GET["Serie_Equipo"]))
				$arKey[] = ew_StripSlashes($_GET["Serie_Equipo"]);
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
				if (!is_array($key) || count($key) <> 3)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // N° Atencion
					continue;
				if (!is_numeric($key[2])) // Dni
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
			$this->NB0_Atencion->CurrentValue = $key[0];
			$this->Serie_Equipo->CurrentValue = $key[1];
			$this->Dni->CurrentValue = $key[2];
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
		$this->NB0_Atencion->setDbValue($rs->fields('N° Atencion'));
		$this->Serie_Equipo->setDbValue($rs->fields('Serie Equipo'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha Entrada'));
		$this->Nombre_Titular->setDbValue($rs->fields('Nombre Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Descripcion_Problema->setDbValue($rs->fields('Descripcion Problema'));
		$this->Id_Tipo_Falla->setDbValue($rs->fields('Id_Tipo_Falla'));
		$this->Id_Problema->setDbValue($rs->fields('Id_Problema'));
		$this->Id_Tipo_Sol_Problem->setDbValue($rs->fields('Id_Tipo_Sol_Problem'));
		$this->Id_Estado_Atenc->setDbValue($rs->fields('Id_Estado_Atenc'));
		$this->Usuario_que_cargo->setDbValue($rs->fields('Usuario que cargo'));
		$this->Ultima_Actualizacion->setDbValue($rs->fields('Ultima Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// N° Atencion
		// Serie Equipo
		// Fecha Entrada
		// Nombre Titular
		// Dni
		// Descripcion Problema
		// Id_Tipo_Falla
		// Id_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Usuario que cargo
		// Ultima Actualizacion
		// N° Atencion

		$this->NB0_Atencion->ViewValue = $this->NB0_Atencion->CurrentValue;
		$this->NB0_Atencion->ViewCustomAttributes = "";

		// Serie Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 0);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Nombre Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Descripcion Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		if (strval($this->Id_Tipo_Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Id_Tipo_Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Falla->ViewValue = NULL;
		}
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		if (strval($this->Id_Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Id_Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Problema->ViewValue = $this->Id_Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
			}
		} else {
			$this->Id_Problema->ViewValue = NULL;
		}
		$this->Id_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		if (strval($this->Id_Tipo_Sol_Problem->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Tipo_Sol_Problem->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Sol_Problem->ViewValue = NULL;
		}
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		if (strval($this->Id_Estado_Atenc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Estado_Atenc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Atenc->ViewValue = NULL;
		}
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Usuario que cargo
		$this->Usuario_que_cargo->ViewValue = $this->Usuario_que_cargo->CurrentValue;
		$this->Usuario_que_cargo->ViewCustomAttributes = "";

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 0);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

		// N° Atencion
		$this->NB0_Atencion->LinkCustomAttributes = "";
		$this->NB0_Atencion->HrefValue = "";
		$this->NB0_Atencion->TooltipValue = "";

		// Serie Equipo
		$this->Serie_Equipo->LinkCustomAttributes = "";
		$this->Serie_Equipo->HrefValue = "";
		$this->Serie_Equipo->TooltipValue = "";

		// Fecha Entrada
		$this->Fecha_Entrada->LinkCustomAttributes = "";
		$this->Fecha_Entrada->HrefValue = "";
		$this->Fecha_Entrada->TooltipValue = "";

		// Nombre Titular
		$this->Nombre_Titular->LinkCustomAttributes = "";
		$this->Nombre_Titular->HrefValue = "";
		$this->Nombre_Titular->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Descripcion Problema
		$this->Descripcion_Problema->LinkCustomAttributes = "";
		$this->Descripcion_Problema->HrefValue = "";
		$this->Descripcion_Problema->TooltipValue = "";

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->LinkCustomAttributes = "";
		$this->Id_Tipo_Falla->HrefValue = "";
		$this->Id_Tipo_Falla->TooltipValue = "";

		// Id_Problema
		$this->Id_Problema->LinkCustomAttributes = "";
		$this->Id_Problema->HrefValue = "";
		$this->Id_Problema->TooltipValue = "";

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
		$this->Id_Tipo_Sol_Problem->HrefValue = "";
		$this->Id_Tipo_Sol_Problem->TooltipValue = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->LinkCustomAttributes = "";
		$this->Id_Estado_Atenc->HrefValue = "";
		$this->Id_Estado_Atenc->TooltipValue = "";

		// Usuario que cargo
		$this->Usuario_que_cargo->LinkCustomAttributes = "";
		$this->Usuario_que_cargo->HrefValue = "";
		$this->Usuario_que_cargo->TooltipValue = "";

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->LinkCustomAttributes = "";
		$this->Ultima_Actualizacion->HrefValue = "";
		$this->Ultima_Actualizacion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// N° Atencion
		$this->NB0_Atencion->EditAttrs["class"] = "form-control";
		$this->NB0_Atencion->EditCustomAttributes = "";
		$this->NB0_Atencion->EditValue = $this->NB0_Atencion->CurrentValue;
		$this->NB0_Atencion->ViewCustomAttributes = "";

		// Serie Equipo
		$this->Serie_Equipo->EditAttrs["class"] = "form-control";
		$this->Serie_Equipo->EditCustomAttributes = "";
		$this->Serie_Equipo->EditValue = $this->Serie_Equipo->CurrentValue;
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
		$this->Fecha_Entrada->EditCustomAttributes = "";
		$this->Fecha_Entrada->EditValue = ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 8);
		$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

		// Nombre Titular
		$this->Nombre_Titular->EditAttrs["class"] = "form-control";
		$this->Nombre_Titular->EditCustomAttributes = "";
		$this->Nombre_Titular->EditValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Nombre_Titular->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Descripcion Problema
		$this->Descripcion_Problema->EditAttrs["class"] = "form-control";
		$this->Descripcion_Problema->EditCustomAttributes = "";
		$this->Descripcion_Problema->EditValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->PlaceHolder = ew_RemoveHtml($this->Descripcion_Problema->FldCaption());

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Falla->EditCustomAttributes = "";

		// Id_Problema
		$this->Id_Problema->EditAttrs["class"] = "form-control";
		$this->Id_Problema->EditCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Sol_Problem->EditCustomAttributes = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Atenc->EditCustomAttributes = "";

		// Usuario que cargo
		$this->Usuario_que_cargo->EditAttrs["class"] = "form-control";
		$this->Usuario_que_cargo->EditCustomAttributes = "";
		$this->Usuario_que_cargo->EditValue = $this->Usuario_que_cargo->CurrentValue;
		$this->Usuario_que_cargo->PlaceHolder = ew_RemoveHtml($this->Usuario_que_cargo->FldCaption());

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->EditAttrs["class"] = "form-control";
		$this->Ultima_Actualizacion->EditCustomAttributes = "";
		$this->Ultima_Actualizacion->EditValue = ew_FormatDateTime($this->Ultima_Actualizacion->CurrentValue, 8);
		$this->Ultima_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Ultima_Actualizacion->FldCaption());

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
					if ($this->NB0_Atencion->Exportable) $Doc->ExportCaption($this->NB0_Atencion);
					if ($this->Serie_Equipo->Exportable) $Doc->ExportCaption($this->Serie_Equipo);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Nombre_Titular->Exportable) $Doc->ExportCaption($this->Nombre_Titular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Descripcion_Problema->Exportable) $Doc->ExportCaption($this->Descripcion_Problema);
					if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportCaption($this->Id_Tipo_Falla);
					if ($this->Id_Problema->Exportable) $Doc->ExportCaption($this->Id_Problema);
					if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportCaption($this->Id_Tipo_Sol_Problem);
					if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportCaption($this->Id_Estado_Atenc);
					if ($this->Usuario_que_cargo->Exportable) $Doc->ExportCaption($this->Usuario_que_cargo);
					if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportCaption($this->Ultima_Actualizacion);
				} else {
					if ($this->NB0_Atencion->Exportable) $Doc->ExportCaption($this->NB0_Atencion);
					if ($this->Serie_Equipo->Exportable) $Doc->ExportCaption($this->Serie_Equipo);
					if ($this->Fecha_Entrada->Exportable) $Doc->ExportCaption($this->Fecha_Entrada);
					if ($this->Nombre_Titular->Exportable) $Doc->ExportCaption($this->Nombre_Titular);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Descripcion_Problema->Exportable) $Doc->ExportCaption($this->Descripcion_Problema);
					if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportCaption($this->Id_Tipo_Falla);
					if ($this->Id_Problema->Exportable) $Doc->ExportCaption($this->Id_Problema);
					if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportCaption($this->Id_Tipo_Sol_Problem);
					if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportCaption($this->Id_Estado_Atenc);
					if ($this->Usuario_que_cargo->Exportable) $Doc->ExportCaption($this->Usuario_que_cargo);
					if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportCaption($this->Ultima_Actualizacion);
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
						if ($this->NB0_Atencion->Exportable) $Doc->ExportField($this->NB0_Atencion);
						if ($this->Serie_Equipo->Exportable) $Doc->ExportField($this->Serie_Equipo);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Nombre_Titular->Exportable) $Doc->ExportField($this->Nombre_Titular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Descripcion_Problema->Exportable) $Doc->ExportField($this->Descripcion_Problema);
						if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportField($this->Id_Tipo_Falla);
						if ($this->Id_Problema->Exportable) $Doc->ExportField($this->Id_Problema);
						if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportField($this->Id_Tipo_Sol_Problem);
						if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportField($this->Id_Estado_Atenc);
						if ($this->Usuario_que_cargo->Exportable) $Doc->ExportField($this->Usuario_que_cargo);
						if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportField($this->Ultima_Actualizacion);
					} else {
						if ($this->NB0_Atencion->Exportable) $Doc->ExportField($this->NB0_Atencion);
						if ($this->Serie_Equipo->Exportable) $Doc->ExportField($this->Serie_Equipo);
						if ($this->Fecha_Entrada->Exportable) $Doc->ExportField($this->Fecha_Entrada);
						if ($this->Nombre_Titular->Exportable) $Doc->ExportField($this->Nombre_Titular);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Descripcion_Problema->Exportable) $Doc->ExportField($this->Descripcion_Problema);
						if ($this->Id_Tipo_Falla->Exportable) $Doc->ExportField($this->Id_Tipo_Falla);
						if ($this->Id_Problema->Exportable) $Doc->ExportField($this->Id_Problema);
						if ($this->Id_Tipo_Sol_Problem->Exportable) $Doc->ExportField($this->Id_Tipo_Sol_Problem);
						if ($this->Id_Estado_Atenc->Exportable) $Doc->ExportField($this->Id_Estado_Atenc);
						if ($this->Usuario_que_cargo->Exportable) $Doc->ExportField($this->Usuario_que_cargo);
						if ($this->Ultima_Actualizacion->Exportable) $Doc->ExportField($this->Ultima_Actualizacion);
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
