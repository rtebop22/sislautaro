<?php

// Global variable for table object
$tutores = NULL;

//
// Table class for tutores
//
class ctutores extends cTable {
	var $Dni_Tutor;
	var $Apellidos_Nombres;
	var $Edad;
	var $Domicilio;
	var $Tel_Contacto;
	var $Fecha_Nac;
	var $Cuil;
	var $MasHijos;
	var $Id_Estado_Civil;
	var $Id_Sexo;
	var $Id_Relacion;
	var $Id_Ocupacion;
	var $Lugar_Nacimiento;
	var $Id_Provincia;
	var $Id_Departamento;
	var $Id_Localidad;
	var $Fecha_Actualizacion;
	var $User_Actualiz;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tutores';
		$this->TableName = 'tutores';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tutores`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Dni_Tutor
		$this->Dni_Tutor = new cField('tutores', 'tutores', 'x_Dni_Tutor', 'Dni_Tutor', '`Dni_Tutor`', '`Dni_Tutor`', 3, -1, FALSE, '`Dni_Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Tutor->Sortable = TRUE; // Allow sort
		$this->Dni_Tutor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni_Tutor'] = &$this->Dni_Tutor;

		// Apellidos_Nombres
		$this->Apellidos_Nombres = new cField('tutores', 'tutores', 'x_Apellidos_Nombres', 'Apellidos_Nombres', '`Apellidos_Nombres`', '`Apellidos_Nombres`', 201, -1, FALSE, '`Apellidos_Nombres`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apellidos_Nombres->Sortable = TRUE; // Allow sort
		$this->fields['Apellidos_Nombres'] = &$this->Apellidos_Nombres;

		// Edad
		$this->Edad = new cField('tutores', 'tutores', 'x_Edad', 'Edad', '`Edad`', '`Edad`', 200, -1, FALSE, '`Edad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Edad->Sortable = TRUE; // Allow sort
		$this->fields['Edad'] = &$this->Edad;

		// Domicilio
		$this->Domicilio = new cField('tutores', 'tutores', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Tel_Contacto
		$this->Tel_Contacto = new cField('tutores', 'tutores', 'x_Tel_Contacto', 'Tel_Contacto', '`Tel_Contacto`', '`Tel_Contacto`', 200, -1, FALSE, '`Tel_Contacto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Contacto->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Contacto'] = &$this->Tel_Contacto;

		// Fecha_Nac
		$this->Fecha_Nac = new cField('tutores', 'tutores', 'x_Fecha_Nac', 'Fecha_Nac', '`Fecha_Nac`', 'DATE_FORMAT(`Fecha_Nac`, \'\')', 133, 7, FALSE, '`Fecha_Nac`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Nac->Sortable = TRUE; // Allow sort
		$this->Fecha_Nac->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Nac'] = &$this->Fecha_Nac;

		// Cuil
		$this->Cuil = new cField('tutores', 'tutores', 'x_Cuil', 'Cuil', '`Cuil`', '`Cuil`', 200, -1, FALSE, '`Cuil`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil->Sortable = TRUE; // Allow sort
		$this->fields['Cuil'] = &$this->Cuil;

		// MasHijos
		$this->MasHijos = new cField('tutores', 'tutores', 'x_MasHijos', 'MasHijos', '`MasHijos`', '`MasHijos`', 200, -1, FALSE, '`MasHijos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->MasHijos->Sortable = TRUE; // Allow sort
		$this->MasHijos->OptionCount = 2;
		$this->fields['MasHijos'] = &$this->MasHijos;

		// Id_Estado_Civil
		$this->Id_Estado_Civil = new cField('tutores', 'tutores', 'x_Id_Estado_Civil', 'Id_Estado_Civil', '`Id_Estado_Civil`', '`Id_Estado_Civil`', 3, -1, FALSE, '`Id_Estado_Civil`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Civil->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Civil->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Civil->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado_Civil->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado_Civil'] = &$this->Id_Estado_Civil;

		// Id_Sexo
		$this->Id_Sexo = new cField('tutores', 'tutores', 'x_Id_Sexo', 'Id_Sexo', '`Id_Sexo`', '`Id_Sexo`', 3, -1, FALSE, '`Id_Sexo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Sexo->Sortable = TRUE; // Allow sort
		$this->Id_Sexo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Sexo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Sexo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Sexo'] = &$this->Id_Sexo;

		// Id_Relacion
		$this->Id_Relacion = new cField('tutores', 'tutores', 'x_Id_Relacion', 'Id_Relacion', '`Id_Relacion`', '`Id_Relacion`', 3, -1, FALSE, '`Id_Relacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Relacion->Sortable = TRUE; // Allow sort
		$this->Id_Relacion->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Relacion->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Relacion'] = &$this->Id_Relacion;

		// Id_Ocupacion
		$this->Id_Ocupacion = new cField('tutores', 'tutores', 'x_Id_Ocupacion', 'Id_Ocupacion', '`Id_Ocupacion`', '`Id_Ocupacion`', 3, -1, FALSE, '`Id_Ocupacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Ocupacion->Sortable = TRUE; // Allow sort
		$this->fields['Id_Ocupacion'] = &$this->Id_Ocupacion;

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento = new cField('tutores', 'tutores', 'x_Lugar_Nacimiento', 'Lugar_Nacimiento', '`Lugar_Nacimiento`', '`Lugar_Nacimiento`', 200, -1, FALSE, '`Lugar_Nacimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Lugar_Nacimiento->Sortable = TRUE; // Allow sort
		$this->fields['Lugar_Nacimiento'] = &$this->Lugar_Nacimiento;

		// Id_Provincia
		$this->Id_Provincia = new cField('tutores', 'tutores', 'x_Id_Provincia', 'Id_Provincia', '`Id_Provincia`', '`Id_Provincia`', 3, -1, FALSE, '`Id_Provincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Provincia->Sortable = TRUE; // Allow sort
		$this->Id_Provincia->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Provincia->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Provincia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Provincia'] = &$this->Id_Provincia;

		// Id_Departamento
		$this->Id_Departamento = new cField('tutores', 'tutores', 'x_Id_Departamento', 'Id_Departamento', '`Id_Departamento`', '`Id_Departamento`', 3, -1, FALSE, '`Id_Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Departamento->Sortable = TRUE; // Allow sort
		$this->Id_Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Departamento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Departamento'] = &$this->Id_Departamento;

		// Id_Localidad
		$this->Id_Localidad = new cField('tutores', 'tutores', 'x_Id_Localidad', 'Id_Localidad', '`Id_Localidad`', '`Id_Localidad`', 3, -1, FALSE, '`Id_Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Localidad->Sortable = TRUE; // Allow sort
		$this->Id_Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Localidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Localidad'] = &$this->Id_Localidad;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('tutores', 'tutores', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', '`Fecha_Actualizacion`', 200, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;

		// User_Actualiz
		$this->User_Actualiz = new cField('tutores', 'tutores', 'x_User_Actualiz', 'User_Actualiz', '`User_Actualiz`', '`User_Actualiz`', 200, -1, FALSE, '`User_Actualiz`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->User_Actualiz->Sortable = TRUE; // Allow sort
		$this->fields['User_Actualiz'] = &$this->User_Actualiz;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "personas") {
			if ($this->Dni_Tutor->getSessionValue() <> "")
				$sMasterFilter .= "`Dni_Tutor`=" . ew_QuotedValue($this->Dni_Tutor->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "personas") {
			if ($this->Dni_Tutor->getSessionValue() <> "")
				$sDetailFilter .= "`Dni_Tutor`=" . ew_QuotedValue($this->Dni_Tutor->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_personas() {
		return "`Dni_Tutor`=@Dni_Tutor@";
	}

	// Detail filter
	function SqlDetailFilter_personas() {
		return "`Dni_Tutor`=@Dni_Tutor@";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "observacion_tutor") {
			$sDetailUrl = $GLOBALS["observacion_tutor"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Dni_Tutor=" . urlencode($this->Dni_Tutor->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tutoreslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tutores`";
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
			if (array_key_exists('Dni_Tutor', $rs))
				ew_AddFilter($where, ew_QuotedName('Dni_Tutor', $this->DBID) . '=' . ew_QuotedValue($rs['Dni_Tutor'], $this->Dni_Tutor->FldDataType, $this->DBID));
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

		// Cascade delete detail table 'observacion_tutor'
		if (!isset($GLOBALS["observacion_tutor"])) $GLOBALS["observacion_tutor"] = new cobservacion_tutor();
		$rscascade = $GLOBALS["observacion_tutor"]->LoadRs("`Dni_Tutor` = " . ew_QuotedValue($rs['Dni_Tutor'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["observacion_tutor"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Dni_Tutor` = @Dni_Tutor@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "tutoreslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tutoreslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tutoresview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tutoresview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tutoresadd.php?" . $this->UrlParm($parm);
		else
			$url = "tutoresadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tutoresedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tutoresedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tutoresadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tutoresadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tutoresdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "personas" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Dni_Tutor=" . urlencode($this->Dni_Tutor->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Dni_Tutor:" . ew_VarToJson($this->Dni_Tutor->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Dni_Tutor->CurrentValue)) {
			$sUrl .= "Dni_Tutor=" . urlencode($this->Dni_Tutor->CurrentValue);
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
			if ($isPost && isset($_POST["Dni_Tutor"]))
				$arKeys[] = ew_StripSlashes($_POST["Dni_Tutor"]);
			elseif (isset($_GET["Dni_Tutor"]))
				$arKeys[] = ew_StripSlashes($_GET["Dni_Tutor"]);
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
			$this->Dni_Tutor->CurrentValue = $key;
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
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Contacto->setDbValue($rs->fields('Tel_Contacto'));
		$this->Fecha_Nac->setDbValue($rs->fields('Fecha_Nac'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->MasHijos->setDbValue($rs->fields('MasHijos'));
		$this->Id_Estado_Civil->setDbValue($rs->fields('Id_Estado_Civil'));
		$this->Id_Sexo->setDbValue($rs->fields('Id_Sexo'));
		$this->Id_Relacion->setDbValue($rs->fields('Id_Relacion'));
		$this->Id_Ocupacion->setDbValue($rs->fields('Id_Ocupacion'));
		$this->Lugar_Nacimiento->setDbValue($rs->fields('Lugar_Nacimiento'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->User_Actualiz->setDbValue($rs->fields('User_Actualiz'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Dni_Tutor
		// Apellidos_Nombres
		// Edad
		// Domicilio
		// Tel_Contacto
		// Fecha_Nac
		// Cuil
		// MasHijos
		// Id_Estado_Civil
		// Id_Sexo
		// Id_Relacion
		// Id_Ocupacion
		// Lugar_Nacimiento
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// User_Actualiz
		// Dni_Tutor

		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Edad
		$this->Edad->ViewValue = $this->Edad->CurrentValue;
		$this->Edad->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Contacto
		$this->Tel_Contacto->ViewValue = $this->Tel_Contacto->CurrentValue;
		$this->Tel_Contacto->ViewCustomAttributes = "";

		// Fecha_Nac
		$this->Fecha_Nac->ViewValue = $this->Fecha_Nac->CurrentValue;
		$this->Fecha_Nac->ViewValue = ew_FormatDateTime($this->Fecha_Nac->ViewValue, 7);
		$this->Fecha_Nac->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// MasHijos
		if (strval($this->MasHijos->CurrentValue) <> "") {
			$this->MasHijos->ViewValue = $this->MasHijos->OptionCaption($this->MasHijos->CurrentValue);
		} else {
			$this->MasHijos->ViewValue = NULL;
		}
		$this->MasHijos->ViewCustomAttributes = "";

		// Id_Estado_Civil
		if (strval($this->Id_Estado_Civil->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Civil`" . ew_SearchString("=", $this->Id_Estado_Civil->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Civil`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_civil`";
		$sWhereWrk = "";
		$this->Id_Estado_Civil->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->CurrentValue;
			}
		} else {
			$this->Id_Estado_Civil->ViewValue = NULL;
		}
		$this->Id_Estado_Civil->ViewCustomAttributes = "";

		// Id_Sexo
		if (strval($this->Id_Sexo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sexo`" . ew_SearchString("=", $this->Id_Sexo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sexo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sexo_personas`";
		$sWhereWrk = "";
		$this->Id_Sexo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->CurrentValue;
			}
		} else {
			$this->Id_Sexo->ViewValue = NULL;
		}
		$this->Id_Sexo->ViewCustomAttributes = "";

		// Id_Relacion
		if (strval($this->Id_Relacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
		$sWhereWrk = "";
		$this->Id_Relacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->CurrentValue;
			}
		} else {
			$this->Id_Relacion->ViewValue = NULL;
		}
		$this->Id_Relacion->ViewCustomAttributes = "";

		// Id_Ocupacion
		$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->CurrentValue;
		if (strval($this->Id_Ocupacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ocupacion`" . ew_SearchString("=", $this->Id_Ocupacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
		$sWhereWrk = "";
		$this->Id_Ocupacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->CurrentValue;
			}
		} else {
			$this->Id_Ocupacion->ViewValue = NULL;
		}
		$this->Id_Ocupacion->ViewCustomAttributes = "";

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->ViewValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// User_Actualiz
		$this->User_Actualiz->ViewValue = $this->User_Actualiz->CurrentValue;
		$this->User_Actualiz->ViewCustomAttributes = "";

		// Dni_Tutor
		$this->Dni_Tutor->LinkCustomAttributes = "";
		$this->Dni_Tutor->HrefValue = "";
		$this->Dni_Tutor->TooltipValue = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->LinkCustomAttributes = "";
		$this->Apellidos_Nombres->HrefValue = "";
		$this->Apellidos_Nombres->TooltipValue = "";

		// Edad
		$this->Edad->LinkCustomAttributes = "";
		$this->Edad->HrefValue = "";
		$this->Edad->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Tel_Contacto
		$this->Tel_Contacto->LinkCustomAttributes = "";
		$this->Tel_Contacto->HrefValue = "";
		$this->Tel_Contacto->TooltipValue = "";

		// Fecha_Nac
		$this->Fecha_Nac->LinkCustomAttributes = "";
		$this->Fecha_Nac->HrefValue = "";
		$this->Fecha_Nac->TooltipValue = "";

		// Cuil
		$this->Cuil->LinkCustomAttributes = "";
		$this->Cuil->HrefValue = "";
		$this->Cuil->TooltipValue = "";

		// MasHijos
		$this->MasHijos->LinkCustomAttributes = "";
		$this->MasHijos->HrefValue = "";
		$this->MasHijos->TooltipValue = "";

		// Id_Estado_Civil
		$this->Id_Estado_Civil->LinkCustomAttributes = "";
		$this->Id_Estado_Civil->HrefValue = "";
		$this->Id_Estado_Civil->TooltipValue = "";

		// Id_Sexo
		$this->Id_Sexo->LinkCustomAttributes = "";
		$this->Id_Sexo->HrefValue = "";
		$this->Id_Sexo->TooltipValue = "";

		// Id_Relacion
		$this->Id_Relacion->LinkCustomAttributes = "";
		$this->Id_Relacion->HrefValue = "";
		$this->Id_Relacion->TooltipValue = "";

		// Id_Ocupacion
		$this->Id_Ocupacion->LinkCustomAttributes = "";
		$this->Id_Ocupacion->HrefValue = "";
		$this->Id_Ocupacion->TooltipValue = "";

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->LinkCustomAttributes = "";
		$this->Lugar_Nacimiento->HrefValue = "";
		$this->Lugar_Nacimiento->TooltipValue = "";

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

		// User_Actualiz
		$this->User_Actualiz->LinkCustomAttributes = "";
		$this->User_Actualiz->HrefValue = "";
		$this->User_Actualiz->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Dni_Tutor
		$this->Dni_Tutor->EditAttrs["class"] = "form-control";
		$this->Dni_Tutor->EditCustomAttributes = "";
		$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
		$this->Apellidos_Nombres->EditCustomAttributes = "";
		$this->Apellidos_Nombres->EditValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

		// Edad
		$this->Edad->EditAttrs["class"] = "form-control";
		$this->Edad->EditCustomAttributes = "";
		$this->Edad->EditValue = $this->Edad->CurrentValue;
		$this->Edad->PlaceHolder = ew_RemoveHtml($this->Edad->FldCaption());

		// Domicilio
		$this->Domicilio->EditAttrs["class"] = "form-control";
		$this->Domicilio->EditCustomAttributes = "";
		$this->Domicilio->EditValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

		// Tel_Contacto
		$this->Tel_Contacto->EditAttrs["class"] = "form-control";
		$this->Tel_Contacto->EditCustomAttributes = "";
		$this->Tel_Contacto->EditValue = $this->Tel_Contacto->CurrentValue;
		$this->Tel_Contacto->PlaceHolder = ew_RemoveHtml($this->Tel_Contacto->FldCaption());

		// Fecha_Nac
		$this->Fecha_Nac->EditAttrs["class"] = "form-control";
		$this->Fecha_Nac->EditCustomAttributes = "";
		$this->Fecha_Nac->EditValue = ew_FormatDateTime($this->Fecha_Nac->CurrentValue, 7);
		$this->Fecha_Nac->PlaceHolder = ew_RemoveHtml($this->Fecha_Nac->FldCaption());

		// Cuil
		$this->Cuil->EditAttrs["class"] = "form-control";
		$this->Cuil->EditCustomAttributes = "";
		$this->Cuil->EditValue = $this->Cuil->CurrentValue;
		$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

		// MasHijos
		$this->MasHijos->EditCustomAttributes = "";
		$this->MasHijos->EditValue = $this->MasHijos->Options(FALSE);

		// Id_Estado_Civil
		$this->Id_Estado_Civil->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Civil->EditCustomAttributes = "";

		// Id_Sexo
		$this->Id_Sexo->EditAttrs["class"] = "form-control";
		$this->Id_Sexo->EditCustomAttributes = "";

		// Id_Relacion
		$this->Id_Relacion->EditAttrs["class"] = "form-control";
		$this->Id_Relacion->EditCustomAttributes = "";

		// Id_Ocupacion
		$this->Id_Ocupacion->EditAttrs["class"] = "form-control";
		$this->Id_Ocupacion->EditCustomAttributes = "";
		$this->Id_Ocupacion->EditValue = $this->Id_Ocupacion->CurrentValue;
		$this->Id_Ocupacion->PlaceHolder = ew_RemoveHtml($this->Id_Ocupacion->FldCaption());

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->EditAttrs["class"] = "form-control";
		$this->Lugar_Nacimiento->EditCustomAttributes = "";
		$this->Lugar_Nacimiento->EditValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->PlaceHolder = ew_RemoveHtml($this->Lugar_Nacimiento->FldCaption());

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
		// User_Actualiz
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
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Apellidos_Nombres->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres);
					if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Contacto->Exportable) $Doc->ExportCaption($this->Tel_Contacto);
					if ($this->Fecha_Nac->Exportable) $Doc->ExportCaption($this->Fecha_Nac);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->MasHijos->Exportable) $Doc->ExportCaption($this->MasHijos);
					if ($this->Id_Estado_Civil->Exportable) $Doc->ExportCaption($this->Id_Estado_Civil);
					if ($this->Id_Sexo->Exportable) $Doc->ExportCaption($this->Id_Sexo);
					if ($this->Id_Relacion->Exportable) $Doc->ExportCaption($this->Id_Relacion);
					if ($this->Id_Ocupacion->Exportable) $Doc->ExportCaption($this->Id_Ocupacion);
					if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportCaption($this->Lugar_Nacimiento);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->User_Actualiz->Exportable) $Doc->ExportCaption($this->User_Actualiz);
				} else {
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Contacto->Exportable) $Doc->ExportCaption($this->Tel_Contacto);
					if ($this->Fecha_Nac->Exportable) $Doc->ExportCaption($this->Fecha_Nac);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->MasHijos->Exportable) $Doc->ExportCaption($this->MasHijos);
					if ($this->Id_Estado_Civil->Exportable) $Doc->ExportCaption($this->Id_Estado_Civil);
					if ($this->Id_Sexo->Exportable) $Doc->ExportCaption($this->Id_Sexo);
					if ($this->Id_Relacion->Exportable) $Doc->ExportCaption($this->Id_Relacion);
					if ($this->Id_Ocupacion->Exportable) $Doc->ExportCaption($this->Id_Ocupacion);
					if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportCaption($this->Lugar_Nacimiento);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->User_Actualiz->Exportable) $Doc->ExportCaption($this->User_Actualiz);
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
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Apellidos_Nombres->Exportable) $Doc->ExportField($this->Apellidos_Nombres);
						if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Contacto->Exportable) $Doc->ExportField($this->Tel_Contacto);
						if ($this->Fecha_Nac->Exportable) $Doc->ExportField($this->Fecha_Nac);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->MasHijos->Exportable) $Doc->ExportField($this->MasHijos);
						if ($this->Id_Estado_Civil->Exportable) $Doc->ExportField($this->Id_Estado_Civil);
						if ($this->Id_Sexo->Exportable) $Doc->ExportField($this->Id_Sexo);
						if ($this->Id_Relacion->Exportable) $Doc->ExportField($this->Id_Relacion);
						if ($this->Id_Ocupacion->Exportable) $Doc->ExportField($this->Id_Ocupacion);
						if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportField($this->Lugar_Nacimiento);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->User_Actualiz->Exportable) $Doc->ExportField($this->User_Actualiz);
					} else {
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Contacto->Exportable) $Doc->ExportField($this->Tel_Contacto);
						if ($this->Fecha_Nac->Exportable) $Doc->ExportField($this->Fecha_Nac);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->MasHijos->Exportable) $Doc->ExportField($this->MasHijos);
						if ($this->Id_Estado_Civil->Exportable) $Doc->ExportField($this->Id_Estado_Civil);
						if ($this->Id_Sexo->Exportable) $Doc->ExportField($this->Id_Sexo);
						if ($this->Id_Relacion->Exportable) $Doc->ExportField($this->Id_Relacion);
						if ($this->Id_Ocupacion->Exportable) $Doc->ExportField($this->Id_Ocupacion);
						if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportField($this->Lugar_Nacimiento);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->User_Actualiz->Exportable) $Doc->ExportField($this->User_Actualiz);
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
