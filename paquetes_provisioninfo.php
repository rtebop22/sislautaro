<?php

// Global variable for table object
$paquetes_provision = NULL;

//
// Table class for paquetes_provision
//
class cpaquetes_provision extends cTable {
	var $NroPedido;
	var $Serie_Netbook;
	var $Id_Hardware;
	var $SN;
	var $Marca_Arranque;
	var $Serie_Server;
	var $Id_Motivo;
	var $Id_Tipo_Extraccion;
	var $Id_Estado_Paquete;
	var $Id_Tipo_Paquete;
	var $Apellido_Nombre_Solicitante;
	var $Dni;
	var $Email_Solicitante;
	var $Usuario;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'paquetes_provision';
		$this->TableName = 'paquetes_provision';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`paquetes_provision`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// NroPedido
		$this->NroPedido = new cField('paquetes_provision', 'paquetes_provision', 'x_NroPedido', 'NroPedido', '`NroPedido`', '`NroPedido`', 3, -1, FALSE, '`NroPedido`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroPedido->Sortable = TRUE; // Allow sort
		$this->fields['NroPedido'] = &$this->NroPedido;

		// Serie_Netbook
		$this->Serie_Netbook = new cField('paquetes_provision', 'paquetes_provision', 'x_Serie_Netbook', 'Serie_Netbook', '`Serie_Netbook`', '`Serie_Netbook`', 200, -1, FALSE, '`Serie_Netbook`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Netbook->Sortable = TRUE; // Allow sort
		$this->fields['Serie_Netbook'] = &$this->Serie_Netbook;

		// Id_Hardware
		$this->Id_Hardware = new cField('paquetes_provision', 'paquetes_provision', 'x_Id_Hardware', 'Id_Hardware', '`Id_Hardware`', '`Id_Hardware`', 200, -1, FALSE, '`Id_Hardware`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Hardware->Sortable = TRUE; // Allow sort
		$this->fields['Id_Hardware'] = &$this->Id_Hardware;

		// SN
		$this->SN = new cField('paquetes_provision', 'paquetes_provision', 'x_SN', 'SN', '`SN`', '`SN`', 200, -1, FALSE, '`SN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SN->Sortable = TRUE; // Allow sort
		$this->fields['SN'] = &$this->SN;

		// Marca_Arranque
		$this->Marca_Arranque = new cField('paquetes_provision', 'paquetes_provision', 'x_Marca_Arranque', 'Marca_Arranque', '`Marca_Arranque`', '`Marca_Arranque`', 200, -1, FALSE, '`Marca_Arranque`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Marca_Arranque->Sortable = TRUE; // Allow sort
		$this->fields['Marca_Arranque'] = &$this->Marca_Arranque;

		// Serie_Server
		$this->Serie_Server = new cField('paquetes_provision', 'paquetes_provision', 'x_Serie_Server', 'Serie_Server', '`Serie_Server`', '`Serie_Server`', 200, -1, FALSE, '`Serie_Server`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Server->Sortable = TRUE; // Allow sort
		$this->fields['Serie_Server'] = &$this->Serie_Server;

		// Id_Motivo
		$this->Id_Motivo = new cField('paquetes_provision', 'paquetes_provision', 'x_Id_Motivo', 'Id_Motivo', '`Id_Motivo`', '`Id_Motivo`', 3, -1, FALSE, '`Id_Motivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Motivo->Sortable = TRUE; // Allow sort
		$this->Id_Motivo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Motivo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Motivo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Motivo'] = &$this->Id_Motivo;

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion = new cField('paquetes_provision', 'paquetes_provision', 'x_Id_Tipo_Extraccion', 'Id_Tipo_Extraccion', '`Id_Tipo_Extraccion`', '`Id_Tipo_Extraccion`', 3, -1, FALSE, '`Id_Tipo_Extraccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Extraccion->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Extraccion->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Extraccion->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Tipo_Extraccion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tipo_Extraccion'] = &$this->Id_Tipo_Extraccion;

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete = new cField('paquetes_provision', 'paquetes_provision', 'x_Id_Estado_Paquete', 'Id_Estado_Paquete', '`Id_Estado_Paquete`', '`Id_Estado_Paquete`', 3, -1, FALSE, '`Id_Estado_Paquete`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Paquete->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Paquete->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Paquete->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado_Paquete->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado_Paquete'] = &$this->Id_Estado_Paquete;

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete = new cField('paquetes_provision', 'paquetes_provision', 'x_Id_Tipo_Paquete', 'Id_Tipo_Paquete', '`Id_Tipo_Paquete`', '`Id_Tipo_Paquete`', 3, -1, FALSE, '`Id_Tipo_Paquete`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Tipo_Paquete->Sortable = TRUE; // Allow sort
		$this->Id_Tipo_Paquete->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Tipo_Paquete->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Tipo_Paquete->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Tipo_Paquete'] = &$this->Id_Tipo_Paquete;

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante = new cField('paquetes_provision', 'paquetes_provision', 'x_Apellido_Nombre_Solicitante', 'Apellido_Nombre_Solicitante', '`Apellido_Nombre_Solicitante`', '`Apellido_Nombre_Solicitante`', 200, -1, FALSE, '`Apellido_Nombre_Solicitante`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apellido_Nombre_Solicitante->Sortable = TRUE; // Allow sort
		$this->fields['Apellido_Nombre_Solicitante'] = &$this->Apellido_Nombre_Solicitante;

		// Dni
		$this->Dni = new cField('paquetes_provision', 'paquetes_provision', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Email_Solicitante
		$this->Email_Solicitante = new cField('paquetes_provision', 'paquetes_provision', 'x_Email_Solicitante', 'Email_Solicitante', '`Email_Solicitante`', '`Email_Solicitante`', 200, -1, FALSE, '`Email_Solicitante`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Email_Solicitante->Sortable = TRUE; // Allow sort
		$this->fields['Email_Solicitante'] = &$this->Email_Solicitante;

		// Usuario
		$this->Usuario = new cField('paquetes_provision', 'paquetes_provision', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('paquetes_provision', 'paquetes_provision', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`paquetes_provision`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`NroPedido` DESC";
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
			if (array_key_exists('NroPedido', $rs))
				ew_AddFilter($where, ew_QuotedName('NroPedido', $this->DBID) . '=' . ew_QuotedValue($rs['NroPedido'], $this->NroPedido->FldDataType, $this->DBID));
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
		return "`NroPedido` = @NroPedido@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->NroPedido->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@NroPedido@", ew_AdjustSql($this->NroPedido->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "paquetes_provisionlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "paquetes_provisionlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("paquetes_provisionview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("paquetes_provisionview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "paquetes_provisionadd.php?" . $this->UrlParm($parm);
		else
			$url = "paquetes_provisionadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("paquetes_provisionedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("paquetes_provisionadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("paquetes_provisiondelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "NroPedido:" . ew_VarToJson($this->NroPedido->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->NroPedido->CurrentValue)) {
			$sUrl .= "NroPedido=" . urlencode($this->NroPedido->CurrentValue);
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
			if ($isPost && isset($_POST["NroPedido"]))
				$arKeys[] = ew_StripSlashes($_POST["NroPedido"]);
			elseif (isset($_GET["NroPedido"]))
				$arKeys[] = ew_StripSlashes($_GET["NroPedido"]);
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
			$this->NroPedido->CurrentValue = $key;
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
		$this->NroPedido->setDbValue($rs->fields('NroPedido'));
		$this->Serie_Netbook->setDbValue($rs->fields('Serie_Netbook'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Serie_Server->setDbValue($rs->fields('Serie_Server'));
		$this->Id_Motivo->setDbValue($rs->fields('Id_Motivo'));
		$this->Id_Tipo_Extraccion->setDbValue($rs->fields('Id_Tipo_Extraccion'));
		$this->Id_Estado_Paquete->setDbValue($rs->fields('Id_Estado_Paquete'));
		$this->Id_Tipo_Paquete->setDbValue($rs->fields('Id_Tipo_Paquete'));
		$this->Apellido_Nombre_Solicitante->setDbValue($rs->fields('Apellido_Nombre_Solicitante'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Email_Solicitante->setDbValue($rs->fields('Email_Solicitante'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// NroPedido
		// Serie_Netbook
		// Id_Hardware
		// SN
		// Marca_Arranque
		// Serie_Server
		// Id_Motivo
		// Id_Tipo_Extraccion
		// Id_Estado_Paquete
		// Id_Tipo_Paquete
		// Apellido_Nombre_Solicitante
		// Dni
		// Email_Solicitante
		// Usuario
		// Fecha_Actualizacion
		// NroPedido

		$this->NroPedido->ViewValue = $this->NroPedido->CurrentValue;
		$this->NroPedido->ViewCustomAttributes = "";

		// Serie_Netbook
		$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
		if (strval($this->Serie_Netbook->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
			}
		} else {
			$this->Serie_Netbook->ViewValue = NULL;
		}
		$this->Serie_Netbook->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		if (strval($this->Id_Hardware->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Id_Hardware->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
			}
		} else {
			$this->Id_Hardware->ViewValue = NULL;
		}
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Serie_Server
		$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
		if (strval($this->Serie_Server->CurrentValue) <> "") {
			$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
		$sWhereWrk = "";
		$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Server->ViewValue = $this->Serie_Server->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
			}
		} else {
			$this->Serie_Server->ViewValue = NULL;
		}
		$this->Serie_Server->ViewCustomAttributes = "";

		// Id_Motivo
		if (strval($this->Id_Motivo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Id_Motivo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->CurrentValue;
			}
		} else {
			$this->Id_Motivo->ViewValue = NULL;
		}
		$this->Id_Motivo->ViewCustomAttributes = "";

		// Id_Tipo_Extraccion
		if (strval($this->Id_Tipo_Extraccion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->Id_Tipo_Extraccion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Extraccion->ViewValue = NULL;
		}
		$this->Id_Tipo_Extraccion->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		if (strval($this->Id_Estado_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
		$sWhereWrk = "";
		$this->Id_Estado_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Estado_Paquete->ViewValue = NULL;
		}
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// Id_Tipo_Paquete
		if (strval($this->Id_Tipo_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
		$sWhereWrk = "";
		$this->Id_Tipo_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Paquete->ViewValue = NULL;
		}
		$this->Id_Tipo_Paquete->ViewCustomAttributes = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
			$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
		$sWhereWrk = "";
		$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
			}
		} else {
			$this->Apellido_Nombre_Solicitante->ViewValue = NULL;
		}
		$this->Apellido_Nombre_Solicitante->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Email_Solicitante
		$this->Email_Solicitante->ViewValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// NroPedido
		$this->NroPedido->LinkCustomAttributes = "";
		$this->NroPedido->HrefValue = "";
		$this->NroPedido->TooltipValue = "";

		// Serie_Netbook
		$this->Serie_Netbook->LinkCustomAttributes = "";
		$this->Serie_Netbook->HrefValue = "";
		$this->Serie_Netbook->TooltipValue = "";

		// Id_Hardware
		$this->Id_Hardware->LinkCustomAttributes = "";
		$this->Id_Hardware->HrefValue = "";
		$this->Id_Hardware->TooltipValue = "";

		// SN
		$this->SN->LinkCustomAttributes = "";
		$this->SN->HrefValue = "";
		$this->SN->TooltipValue = "";

		// Marca_Arranque
		$this->Marca_Arranque->LinkCustomAttributes = "";
		$this->Marca_Arranque->HrefValue = "";
		$this->Marca_Arranque->TooltipValue = "";

		// Serie_Server
		$this->Serie_Server->LinkCustomAttributes = "";
		$this->Serie_Server->HrefValue = "";
		$this->Serie_Server->TooltipValue = "";

		// Id_Motivo
		$this->Id_Motivo->LinkCustomAttributes = "";
		$this->Id_Motivo->HrefValue = "";
		$this->Id_Motivo->TooltipValue = "";

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
		$this->Id_Tipo_Extraccion->HrefValue = "";
		$this->Id_Tipo_Extraccion->TooltipValue = "";

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->LinkCustomAttributes = "";
		$this->Id_Estado_Paquete->HrefValue = "";
		$this->Id_Estado_Paquete->TooltipValue = "";

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
		$this->Id_Tipo_Paquete->HrefValue = "";
		$this->Id_Tipo_Paquete->TooltipValue = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
		$this->Apellido_Nombre_Solicitante->HrefValue = "";
		$this->Apellido_Nombre_Solicitante->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Email_Solicitante
		$this->Email_Solicitante->LinkCustomAttributes = "";
		$this->Email_Solicitante->HrefValue = "";
		$this->Email_Solicitante->TooltipValue = "";

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

		// NroPedido
		$this->NroPedido->EditAttrs["class"] = "form-control";
		$this->NroPedido->EditCustomAttributes = "";
		$this->NroPedido->EditValue = $this->NroPedido->CurrentValue;
		$this->NroPedido->ViewCustomAttributes = "";

		// Serie_Netbook
		$this->Serie_Netbook->EditAttrs["class"] = "form-control";
		$this->Serie_Netbook->EditCustomAttributes = "";
		$this->Serie_Netbook->EditValue = $this->Serie_Netbook->CurrentValue;
		$this->Serie_Netbook->PlaceHolder = ew_RemoveHtml($this->Serie_Netbook->FldCaption());

		// Id_Hardware
		$this->Id_Hardware->EditAttrs["class"] = "form-control";
		$this->Id_Hardware->EditCustomAttributes = "";
		$this->Id_Hardware->EditValue = $this->Id_Hardware->CurrentValue;
		$this->Id_Hardware->PlaceHolder = ew_RemoveHtml($this->Id_Hardware->FldCaption());

		// SN
		$this->SN->EditAttrs["class"] = "form-control";
		$this->SN->EditCustomAttributes = "";
		$this->SN->EditValue = $this->SN->CurrentValue;
		$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

		// Marca_Arranque
		$this->Marca_Arranque->EditAttrs["class"] = "form-control";
		$this->Marca_Arranque->EditCustomAttributes = "";
		$this->Marca_Arranque->EditValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

		// Serie_Server
		$this->Serie_Server->EditAttrs["class"] = "form-control";
		$this->Serie_Server->EditCustomAttributes = "";
		$this->Serie_Server->EditValue = $this->Serie_Server->CurrentValue;
		$this->Serie_Server->PlaceHolder = ew_RemoveHtml($this->Serie_Server->FldCaption());

		// Id_Motivo
		$this->Id_Motivo->EditAttrs["class"] = "form-control";
		$this->Id_Motivo->EditCustomAttributes = "";

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Extraccion->EditCustomAttributes = "";

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Paquete->EditCustomAttributes = "";

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->EditAttrs["class"] = "form-control";
		$this->Id_Tipo_Paquete->EditCustomAttributes = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->EditAttrs["class"] = "form-control";
		$this->Apellido_Nombre_Solicitante->EditCustomAttributes = "";
		$this->Apellido_Nombre_Solicitante->EditValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		$this->Apellido_Nombre_Solicitante->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre_Solicitante->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

		// Email_Solicitante
		$this->Email_Solicitante->EditAttrs["class"] = "form-control";
		$this->Email_Solicitante->EditCustomAttributes = "";
		$this->Email_Solicitante->EditValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->PlaceHolder = ew_RemoveHtml($this->Email_Solicitante->FldCaption());

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
					if ($this->Serie_Netbook->Exportable) $Doc->ExportCaption($this->Serie_Netbook);
					if ($this->Id_Hardware->Exportable) $Doc->ExportCaption($this->Id_Hardware);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Marca_Arranque->Exportable) $Doc->ExportCaption($this->Marca_Arranque);
					if ($this->Serie_Server->Exportable) $Doc->ExportCaption($this->Serie_Server);
					if ($this->Id_Motivo->Exportable) $Doc->ExportCaption($this->Id_Motivo);
					if ($this->Id_Tipo_Extraccion->Exportable) $Doc->ExportCaption($this->Id_Tipo_Extraccion);
					if ($this->Id_Estado_Paquete->Exportable) $Doc->ExportCaption($this->Id_Estado_Paquete);
					if ($this->Id_Tipo_Paquete->Exportable) $Doc->ExportCaption($this->Id_Tipo_Paquete);
					if ($this->Apellido_Nombre_Solicitante->Exportable) $Doc->ExportCaption($this->Apellido_Nombre_Solicitante);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Email_Solicitante->Exportable) $Doc->ExportCaption($this->Email_Solicitante);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->NroPedido->Exportable) $Doc->ExportCaption($this->NroPedido);
					if ($this->Serie_Netbook->Exportable) $Doc->ExportCaption($this->Serie_Netbook);
					if ($this->Id_Hardware->Exportable) $Doc->ExportCaption($this->Id_Hardware);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Marca_Arranque->Exportable) $Doc->ExportCaption($this->Marca_Arranque);
					if ($this->Serie_Server->Exportable) $Doc->ExportCaption($this->Serie_Server);
					if ($this->Id_Motivo->Exportable) $Doc->ExportCaption($this->Id_Motivo);
					if ($this->Id_Tipo_Extraccion->Exportable) $Doc->ExportCaption($this->Id_Tipo_Extraccion);
					if ($this->Id_Estado_Paquete->Exportable) $Doc->ExportCaption($this->Id_Estado_Paquete);
					if ($this->Id_Tipo_Paquete->Exportable) $Doc->ExportCaption($this->Id_Tipo_Paquete);
					if ($this->Apellido_Nombre_Solicitante->Exportable) $Doc->ExportCaption($this->Apellido_Nombre_Solicitante);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Email_Solicitante->Exportable) $Doc->ExportCaption($this->Email_Solicitante);
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
						if ($this->Serie_Netbook->Exportable) $Doc->ExportField($this->Serie_Netbook);
						if ($this->Id_Hardware->Exportable) $Doc->ExportField($this->Id_Hardware);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Marca_Arranque->Exportable) $Doc->ExportField($this->Marca_Arranque);
						if ($this->Serie_Server->Exportable) $Doc->ExportField($this->Serie_Server);
						if ($this->Id_Motivo->Exportable) $Doc->ExportField($this->Id_Motivo);
						if ($this->Id_Tipo_Extraccion->Exportable) $Doc->ExportField($this->Id_Tipo_Extraccion);
						if ($this->Id_Estado_Paquete->Exportable) $Doc->ExportField($this->Id_Estado_Paquete);
						if ($this->Id_Tipo_Paquete->Exportable) $Doc->ExportField($this->Id_Tipo_Paquete);
						if ($this->Apellido_Nombre_Solicitante->Exportable) $Doc->ExportField($this->Apellido_Nombre_Solicitante);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Email_Solicitante->Exportable) $Doc->ExportField($this->Email_Solicitante);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->NroPedido->Exportable) $Doc->ExportField($this->NroPedido);
						if ($this->Serie_Netbook->Exportable) $Doc->ExportField($this->Serie_Netbook);
						if ($this->Id_Hardware->Exportable) $Doc->ExportField($this->Id_Hardware);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Marca_Arranque->Exportable) $Doc->ExportField($this->Marca_Arranque);
						if ($this->Serie_Server->Exportable) $Doc->ExportField($this->Serie_Server);
						if ($this->Id_Motivo->Exportable) $Doc->ExportField($this->Id_Motivo);
						if ($this->Id_Tipo_Extraccion->Exportable) $Doc->ExportField($this->Id_Tipo_Extraccion);
						if ($this->Id_Estado_Paquete->Exportable) $Doc->ExportField($this->Id_Estado_Paquete);
						if ($this->Id_Tipo_Paquete->Exportable) $Doc->ExportField($this->Id_Tipo_Paquete);
						if ($this->Apellido_Nombre_Solicitante->Exportable) $Doc->ExportField($this->Apellido_Nombre_Solicitante);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Email_Solicitante->Exportable) $Doc->ExportField($this->Email_Solicitante);
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
		if (preg_match('/^x(\d)*_Serie_Netbook$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `NroMac` AS FIELD0, `SpecialNumber` AS FIELD1 FROM `equipos`";
			$sWhereWrk = "(`NroSerie` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Id_Hardware->setDbValue($rs->fields[0]);
					$this->SN->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Id_Hardware->AutoFillOriginalValue) ? $this->Id_Hardware->CurrentValue : $this->Id_Hardware->EditValue;
					$ar[] = ($this->SN->AutoFillOriginalValue) ? $this->SN->CurrentValue : $this->SN->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Apellido_Nombre_Solicitante$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Mail` AS FIELD0, `DniRte` AS FIELD1 FROM `referente_tecnico`";
			$sWhereWrk = "(`Apellido_Nombre` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Email_Solicitante->setDbValue($rs->fields[0]);
					$this->Dni->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Email_Solicitante->AutoFillOriginalValue) ? $this->Email_Solicitante->CurrentValue : $this->Email_Solicitante->EditValue;
					$ar[] = ($this->Dni->AutoFillOriginalValue) ? $this->Dni->CurrentValue : $this->Dni->EditValue;
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
