<?php

// Global variable for table object
$personas = NULL;

//
// Table class for personas
//
class cpersonas extends cTable {
	var $Apellidos_Nombres;
	var $Dni;
	var $Cuil;
	var $Edad;
	var $Domicilio;
	var $Tel_Contacto;
	var $Fecha_Nac;
	var $Lugar_Nacimiento;
	var $Cod_Postal;
	var $Repitente;
	var $Id_Estado_Civil;
	var $Id_Provincia;
	var $Id_Departamento;
	var $Id_Localidad;
	var $Id_Sexo;
	var $Id_Cargo;
	var $Id_Estado;
	var $Id_Curso;
	var $Id_Division;
	var $Id_Turno;
	var $Dni_Tutor;
	var $NroSerie;
	var $User_Actualiz;
	var $Fecha_Actualizacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'personas';
		$this->TableName = 'personas';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`personas`";
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
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Apellidos_Nombres
		$this->Apellidos_Nombres = new cField('personas', 'personas', 'x_Apellidos_Nombres', 'Apellidos_Nombres', '`Apellidos_Nombres`', '`Apellidos_Nombres`', 201, -1, FALSE, '`Apellidos_Nombres`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apellidos_Nombres->Sortable = TRUE; // Allow sort
		$this->fields['Apellidos_Nombres'] = &$this->Apellidos_Nombres;

		// Dni
		$this->Dni = new cField('personas', 'personas', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Cuil
		$this->Cuil = new cField('personas', 'personas', 'x_Cuil', 'Cuil', '`Cuil`', '`Cuil`', 200, -1, FALSE, '`Cuil`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil->Sortable = TRUE; // Allow sort
		$this->fields['Cuil'] = &$this->Cuil;

		// Edad
		$this->Edad = new cField('personas', 'personas', 'x_Edad', 'Edad', '`Edad`', '`Edad`', 200, -1, FALSE, '`Edad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Edad->Sortable = TRUE; // Allow sort
		$this->fields['Edad'] = &$this->Edad;

		// Domicilio
		$this->Domicilio = new cField('personas', 'personas', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Tel_Contacto
		$this->Tel_Contacto = new cField('personas', 'personas', 'x_Tel_Contacto', 'Tel_Contacto', '`Tel_Contacto`', '`Tel_Contacto`', 200, -1, FALSE, '`Tel_Contacto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Contacto->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Contacto'] = &$this->Tel_Contacto;

		// Fecha_Nac
		$this->Fecha_Nac = new cField('personas', 'personas', 'x_Fecha_Nac', 'Fecha_Nac', '`Fecha_Nac`', '`Fecha_Nac`', 200, 7, FALSE, '`Fecha_Nac`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Nac->Sortable = TRUE; // Allow sort
		$this->Fecha_Nac->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Nac'] = &$this->Fecha_Nac;

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento = new cField('personas', 'personas', 'x_Lugar_Nacimiento', 'Lugar_Nacimiento', '`Lugar_Nacimiento`', '`Lugar_Nacimiento`', 200, -1, FALSE, '`Lugar_Nacimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Lugar_Nacimiento->Sortable = TRUE; // Allow sort
		$this->fields['Lugar_Nacimiento'] = &$this->Lugar_Nacimiento;

		// Cod_Postal
		$this->Cod_Postal = new cField('personas', 'personas', 'x_Cod_Postal', 'Cod_Postal', '`Cod_Postal`', '`Cod_Postal`', 200, -1, FALSE, '`Cod_Postal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cod_Postal->Sortable = TRUE; // Allow sort
		$this->Cod_Postal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cod_Postal'] = &$this->Cod_Postal;

		// Repitente
		$this->Repitente = new cField('personas', 'personas', 'x_Repitente', 'Repitente', '`Repitente`', '`Repitente`', 200, -1, FALSE, '`Repitente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Repitente->Sortable = TRUE; // Allow sort
		$this->Repitente->OptionCount = 2;
		$this->fields['Repitente'] = &$this->Repitente;

		// Id_Estado_Civil
		$this->Id_Estado_Civil = new cField('personas', 'personas', 'x_Id_Estado_Civil', 'Id_Estado_Civil', '`Id_Estado_Civil`', '`Id_Estado_Civil`', 3, -1, FALSE, '`Id_Estado_Civil`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Civil->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Civil->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Civil->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado_Civil->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado_Civil'] = &$this->Id_Estado_Civil;

		// Id_Provincia
		$this->Id_Provincia = new cField('personas', 'personas', 'x_Id_Provincia', 'Id_Provincia', '`Id_Provincia`', '`Id_Provincia`', 3, -1, FALSE, '`Id_Provincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Provincia->Sortable = TRUE; // Allow sort
		$this->Id_Provincia->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Provincia->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Provincia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Provincia'] = &$this->Id_Provincia;

		// Id_Departamento
		$this->Id_Departamento = new cField('personas', 'personas', 'x_Id_Departamento', 'Id_Departamento', '`Id_Departamento`', '`Id_Departamento`', 3, -1, FALSE, '`Id_Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Departamento->Sortable = TRUE; // Allow sort
		$this->Id_Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Departamento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Departamento'] = &$this->Id_Departamento;

		// Id_Localidad
		$this->Id_Localidad = new cField('personas', 'personas', 'x_Id_Localidad', 'Id_Localidad', '`Id_Localidad`', '`Id_Localidad`', 3, -1, FALSE, '`Id_Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Localidad->Sortable = TRUE; // Allow sort
		$this->Id_Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Localidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Localidad'] = &$this->Id_Localidad;

		// Id_Sexo
		$this->Id_Sexo = new cField('personas', 'personas', 'x_Id_Sexo', 'Id_Sexo', '`Id_Sexo`', '`Id_Sexo`', 3, -1, FALSE, '`Id_Sexo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Sexo->Sortable = TRUE; // Allow sort
		$this->Id_Sexo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Sexo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Sexo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Sexo'] = &$this->Id_Sexo;

		// Id_Cargo
		$this->Id_Cargo = new cField('personas', 'personas', 'x_Id_Cargo', 'Id_Cargo', '`Id_Cargo`', '`Id_Cargo`', 3, -1, FALSE, '`Id_Cargo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Cargo->Sortable = TRUE; // Allow sort
		$this->Id_Cargo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Cargo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Cargo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Cargo'] = &$this->Id_Cargo;

		// Id_Estado
		$this->Id_Estado = new cField('personas', 'personas', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado->Sortable = TRUE; // Allow sort
		$this->Id_Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// Id_Curso
		$this->Id_Curso = new cField('personas', 'personas', 'x_Id_Curso', 'Id_Curso', '`Id_Curso`', '`Id_Curso`', 3, -1, FALSE, '`Id_Curso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Curso->Sortable = TRUE; // Allow sort
		$this->Id_Curso->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Curso->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Curso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Curso'] = &$this->Id_Curso;

		// Id_Division
		$this->Id_Division = new cField('personas', 'personas', 'x_Id_Division', 'Id_Division', '`Id_Division`', '`Id_Division`', 3, -1, FALSE, '`Id_Division`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Division->Sortable = TRUE; // Allow sort
		$this->Id_Division->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Division->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Division->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Division'] = &$this->Id_Division;

		// Id_Turno
		$this->Id_Turno = new cField('personas', 'personas', 'x_Id_Turno', 'Id_Turno', '`Id_Turno`', '`Id_Turno`', 3, -1, FALSE, '`Id_Turno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Turno->Sortable = TRUE; // Allow sort
		$this->Id_Turno->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Turno->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Turno->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Turno'] = &$this->Id_Turno;

		// Dni_Tutor
		$this->Dni_Tutor = new cField('personas', 'personas', 'x_Dni_Tutor', 'Dni_Tutor', '`Dni_Tutor`', '`Dni_Tutor`', 3, -1, FALSE, '`Dni_Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Dni_Tutor'] = &$this->Dni_Tutor;

		// NroSerie
		$this->NroSerie = new cField('personas', 'personas', 'x_NroSerie', 'NroSerie', '`NroSerie`', '`NroSerie`', 200, -1, FALSE, '`NroSerie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NroSerie->Sortable = TRUE; // Allow sort
		$this->fields['NroSerie'] = &$this->NroSerie;

		// User_Actualiz
		$this->User_Actualiz = new cField('personas', 'personas', 'x_User_Actualiz', 'User_Actualiz', '`User_Actualiz`', '`User_Actualiz`', 200, -1, FALSE, '`User_Actualiz`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->User_Actualiz->Sortable = TRUE; // Allow sort
		$this->fields['User_Actualiz'] = &$this->User_Actualiz;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('personas', 'personas', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', '`Fecha_Actualizacion`', 200, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
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
		if ($this->getCurrentDetailTable() == "estado_actual_legajo_persona") {
			$sDetailUrl = $GLOBALS["estado_actual_legajo_persona"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Dni=" . urlencode($this->Dni->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "materias_adeudadas") {
			$sDetailUrl = $GLOBALS["materias_adeudadas"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Dni=" . urlencode($this->Dni->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "observacion_persona") {
			$sDetailUrl = $GLOBALS["observacion_persona"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Dni=" . urlencode($this->Dni->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "equipos") {
			$sDetailUrl = $GLOBALS["equipos"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_NroSerie=" . urlencode($this->NroSerie->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "tutores") {
			$sDetailUrl = $GLOBALS["tutores"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Dni_Tutor=" . urlencode($this->Dni_Tutor->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "personaslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`personas`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Id_Curso` ASC,`Id_Division` ASC,`Apellidos_Nombres` ASC";
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
			return "personaslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "personaslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("personasview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("personasview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "personasadd.php?" . $this->UrlParm($parm);
		else
			$url = "personasadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("personasedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("personasedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("personasadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("personasadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("personasdelete.php", $this->UrlParm());
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
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Contacto->setDbValue($rs->fields('Tel_Contacto'));
		$this->Fecha_Nac->setDbValue($rs->fields('Fecha_Nac'));
		$this->Lugar_Nacimiento->setDbValue($rs->fields('Lugar_Nacimiento'));
		$this->Cod_Postal->setDbValue($rs->fields('Cod_Postal'));
		$this->Repitente->setDbValue($rs->fields('Repitente'));
		$this->Id_Estado_Civil->setDbValue($rs->fields('Id_Estado_Civil'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Id_Sexo->setDbValue($rs->fields('Id_Sexo'));
		$this->Id_Cargo->setDbValue($rs->fields('Id_Cargo'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Curso->setDbValue($rs->fields('Id_Curso'));
		$this->Id_Division->setDbValue($rs->fields('Id_Division'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->User_Actualiz->setDbValue($rs->fields('User_Actualiz'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Apellidos_Nombres
		// Dni
		// Cuil
		// Edad
		// Domicilio
		// Tel_Contacto
		// Fecha_Nac
		// Lugar_Nacimiento
		// Cod_Postal
		// Repitente
		// Id_Estado_Civil
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Id_Sexo
		// Id_Cargo
		// Id_Estado
		// Id_Curso
		// Id_Division
		// Id_Turno
		// Dni_Tutor
		// NroSerie
		// User_Actualiz
		// Fecha_Actualizacion
		// Apellidos_Nombres

		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

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

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->ViewValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->ViewCustomAttributes = "";

		// Cod_Postal
		$this->Cod_Postal->ViewValue = $this->Cod_Postal->CurrentValue;
		$this->Cod_Postal->ViewCustomAttributes = "";

		// Repitente
		if (strval($this->Repitente->CurrentValue) <> "") {
			$this->Repitente->ViewValue = $this->Repitente->OptionCaption($this->Repitente->CurrentValue);
		} else {
			$this->Repitente->ViewValue = NULL;
		}
		$this->Repitente->ViewCustomAttributes = "";

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

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
		$sWhereWrk = "";
		$this->Id_Cargo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->CurrentValue;
			}
		} else {
			$this->Id_Cargo->ViewValue = NULL;
		}
		$this->Id_Cargo->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado->ViewValue = $this->Id_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// Id_Curso
		if (strval($this->Id_Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Id_Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Curso->ViewValue = $this->Id_Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Curso->ViewValue = $this->Id_Curso->CurrentValue;
			}
		} else {
			$this->Id_Curso->ViewValue = NULL;
		}
		$this->Id_Curso->ViewCustomAttributes = "";

		// Id_Division
		if (strval($this->Id_Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Id_Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Division->ViewValue = $this->Id_Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Division->ViewValue = $this->Id_Division->CurrentValue;
			}
		} else {
			$this->Id_Division->ViewValue = NULL;
		}
		$this->Id_Division->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

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

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array();
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

		// User_Actualiz
		$this->User_Actualiz->ViewValue = $this->User_Actualiz->CurrentValue;
		$this->User_Actualiz->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->LinkCustomAttributes = "";
		$this->Apellidos_Nombres->HrefValue = "";
		$this->Apellidos_Nombres->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Cuil
		$this->Cuil->LinkCustomAttributes = "";
		$this->Cuil->HrefValue = "";
		$this->Cuil->TooltipValue = "";

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

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->LinkCustomAttributes = "";
		$this->Lugar_Nacimiento->HrefValue = "";
		$this->Lugar_Nacimiento->TooltipValue = "";

		// Cod_Postal
		$this->Cod_Postal->LinkCustomAttributes = "";
		$this->Cod_Postal->HrefValue = "";
		$this->Cod_Postal->TooltipValue = "";

		// Repitente
		$this->Repitente->LinkCustomAttributes = "";
		$this->Repitente->HrefValue = "";
		$this->Repitente->TooltipValue = "";

		// Id_Estado_Civil
		$this->Id_Estado_Civil->LinkCustomAttributes = "";
		$this->Id_Estado_Civil->HrefValue = "";
		$this->Id_Estado_Civil->TooltipValue = "";

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

		// Id_Sexo
		$this->Id_Sexo->LinkCustomAttributes = "";
		$this->Id_Sexo->HrefValue = "";
		$this->Id_Sexo->TooltipValue = "";

		// Id_Cargo
		$this->Id_Cargo->LinkCustomAttributes = "";
		$this->Id_Cargo->HrefValue = "";
		$this->Id_Cargo->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// Id_Curso
		$this->Id_Curso->LinkCustomAttributes = "";
		$this->Id_Curso->HrefValue = "";
		$this->Id_Curso->TooltipValue = "";

		// Id_Division
		$this->Id_Division->LinkCustomAttributes = "";
		$this->Id_Division->HrefValue = "";
		$this->Id_Division->TooltipValue = "";

		// Id_Turno
		$this->Id_Turno->LinkCustomAttributes = "";
		$this->Id_Turno->HrefValue = "";
		$this->Id_Turno->TooltipValue = "";

		// Dni_Tutor
		$this->Dni_Tutor->LinkCustomAttributes = "";
		$this->Dni_Tutor->HrefValue = "";
		$this->Dni_Tutor->TooltipValue = "";

		// NroSerie
		$this->NroSerie->LinkCustomAttributes = "";
		$this->NroSerie->HrefValue = "";
		$this->NroSerie->TooltipValue = "";

		// User_Actualiz
		$this->User_Actualiz->LinkCustomAttributes = "";
		$this->User_Actualiz->HrefValue = "";
		$this->User_Actualiz->TooltipValue = "";

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

		// Apellidos_Nombres
		$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
		$this->Apellidos_Nombres->EditCustomAttributes = "";
		$this->Apellidos_Nombres->EditValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

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
		$this->Fecha_Nac->EditValue = $this->Fecha_Nac->CurrentValue;
		$this->Fecha_Nac->PlaceHolder = ew_RemoveHtml($this->Fecha_Nac->FldCaption());

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->EditAttrs["class"] = "form-control";
		$this->Lugar_Nacimiento->EditCustomAttributes = "";
		$this->Lugar_Nacimiento->EditValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->PlaceHolder = ew_RemoveHtml($this->Lugar_Nacimiento->FldCaption());

		// Cod_Postal
		$this->Cod_Postal->EditAttrs["class"] = "form-control";
		$this->Cod_Postal->EditCustomAttributes = "";
		$this->Cod_Postal->EditValue = $this->Cod_Postal->CurrentValue;
		$this->Cod_Postal->PlaceHolder = ew_RemoveHtml($this->Cod_Postal->FldCaption());

		// Repitente
		$this->Repitente->EditCustomAttributes = "";
		$this->Repitente->EditValue = $this->Repitente->Options(FALSE);

		// Id_Estado_Civil
		$this->Id_Estado_Civil->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Civil->EditCustomAttributes = "";

		// Id_Provincia
		$this->Id_Provincia->EditAttrs["class"] = "form-control";
		$this->Id_Provincia->EditCustomAttributes = "";

		// Id_Departamento
		$this->Id_Departamento->EditAttrs["class"] = "form-control";
		$this->Id_Departamento->EditCustomAttributes = "";

		// Id_Localidad
		$this->Id_Localidad->EditAttrs["class"] = "form-control";
		$this->Id_Localidad->EditCustomAttributes = "";

		// Id_Sexo
		$this->Id_Sexo->EditAttrs["class"] = "form-control";
		$this->Id_Sexo->EditCustomAttributes = "";

		// Id_Cargo
		$this->Id_Cargo->EditAttrs["class"] = "form-control";
		$this->Id_Cargo->EditCustomAttributes = "";

		// Id_Estado
		$this->Id_Estado->EditAttrs["class"] = "form-control";
		$this->Id_Estado->EditCustomAttributes = "";

		// Id_Curso
		$this->Id_Curso->EditAttrs["class"] = "form-control";
		$this->Id_Curso->EditCustomAttributes = "";

		// Id_Division
		$this->Id_Division->EditAttrs["class"] = "form-control";
		$this->Id_Division->EditCustomAttributes = "";

		// Id_Turno
		$this->Id_Turno->EditAttrs["class"] = "form-control";
		$this->Id_Turno->EditCustomAttributes = "";

		// Dni_Tutor
		$this->Dni_Tutor->EditAttrs["class"] = "form-control";
		$this->Dni_Tutor->EditCustomAttributes = "";
		$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

		// NroSerie
		$this->NroSerie->EditAttrs["class"] = "form-control";
		$this->NroSerie->EditCustomAttributes = "";
		$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

		// User_Actualiz
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
					if ($this->Apellidos_Nombres->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Contacto->Exportable) $Doc->ExportCaption($this->Tel_Contacto);
					if ($this->Fecha_Nac->Exportable) $Doc->ExportCaption($this->Fecha_Nac);
					if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportCaption($this->Lugar_Nacimiento);
					if ($this->Cod_Postal->Exportable) $Doc->ExportCaption($this->Cod_Postal);
					if ($this->Repitente->Exportable) $Doc->ExportCaption($this->Repitente);
					if ($this->Id_Estado_Civil->Exportable) $Doc->ExportCaption($this->Id_Estado_Civil);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Id_Sexo->Exportable) $Doc->ExportCaption($this->Id_Sexo);
					if ($this->Id_Cargo->Exportable) $Doc->ExportCaption($this->Id_Cargo);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Curso->Exportable) $Doc->ExportCaption($this->Id_Curso);
					if ($this->Id_Division->Exportable) $Doc->ExportCaption($this->Id_Division);
					if ($this->Id_Turno->Exportable) $Doc->ExportCaption($this->Id_Turno);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
					if ($this->User_Actualiz->Exportable) $Doc->ExportCaption($this->User_Actualiz);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
				} else {
					if ($this->Apellidos_Nombres->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Cuil->Exportable) $Doc->ExportCaption($this->Cuil);
					if ($this->Edad->Exportable) $Doc->ExportCaption($this->Edad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Contacto->Exportable) $Doc->ExportCaption($this->Tel_Contacto);
					if ($this->Fecha_Nac->Exportable) $Doc->ExportCaption($this->Fecha_Nac);
					if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportCaption($this->Lugar_Nacimiento);
					if ($this->Cod_Postal->Exportable) $Doc->ExportCaption($this->Cod_Postal);
					if ($this->Repitente->Exportable) $Doc->ExportCaption($this->Repitente);
					if ($this->Id_Estado_Civil->Exportable) $Doc->ExportCaption($this->Id_Estado_Civil);
					if ($this->Id_Provincia->Exportable) $Doc->ExportCaption($this->Id_Provincia);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Id_Sexo->Exportable) $Doc->ExportCaption($this->Id_Sexo);
					if ($this->Id_Cargo->Exportable) $Doc->ExportCaption($this->Id_Cargo);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Curso->Exportable) $Doc->ExportCaption($this->Id_Curso);
					if ($this->Id_Division->Exportable) $Doc->ExportCaption($this->Id_Division);
					if ($this->Id_Turno->Exportable) $Doc->ExportCaption($this->Id_Turno);
					if ($this->Dni_Tutor->Exportable) $Doc->ExportCaption($this->Dni_Tutor);
					if ($this->NroSerie->Exportable) $Doc->ExportCaption($this->NroSerie);
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
						if ($this->Apellidos_Nombres->Exportable) $Doc->ExportField($this->Apellidos_Nombres);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Contacto->Exportable) $Doc->ExportField($this->Tel_Contacto);
						if ($this->Fecha_Nac->Exportable) $Doc->ExportField($this->Fecha_Nac);
						if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportField($this->Lugar_Nacimiento);
						if ($this->Cod_Postal->Exportable) $Doc->ExportField($this->Cod_Postal);
						if ($this->Repitente->Exportable) $Doc->ExportField($this->Repitente);
						if ($this->Id_Estado_Civil->Exportable) $Doc->ExportField($this->Id_Estado_Civil);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Id_Sexo->Exportable) $Doc->ExportField($this->Id_Sexo);
						if ($this->Id_Cargo->Exportable) $Doc->ExportField($this->Id_Cargo);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Curso->Exportable) $Doc->ExportField($this->Id_Curso);
						if ($this->Id_Division->Exportable) $Doc->ExportField($this->Id_Division);
						if ($this->Id_Turno->Exportable) $Doc->ExportField($this->Id_Turno);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
						if ($this->User_Actualiz->Exportable) $Doc->ExportField($this->User_Actualiz);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
					} else {
						if ($this->Apellidos_Nombres->Exportable) $Doc->ExportField($this->Apellidos_Nombres);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Cuil->Exportable) $Doc->ExportField($this->Cuil);
						if ($this->Edad->Exportable) $Doc->ExportField($this->Edad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Contacto->Exportable) $Doc->ExportField($this->Tel_Contacto);
						if ($this->Fecha_Nac->Exportable) $Doc->ExportField($this->Fecha_Nac);
						if ($this->Lugar_Nacimiento->Exportable) $Doc->ExportField($this->Lugar_Nacimiento);
						if ($this->Cod_Postal->Exportable) $Doc->ExportField($this->Cod_Postal);
						if ($this->Repitente->Exportable) $Doc->ExportField($this->Repitente);
						if ($this->Id_Estado_Civil->Exportable) $Doc->ExportField($this->Id_Estado_Civil);
						if ($this->Id_Provincia->Exportable) $Doc->ExportField($this->Id_Provincia);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Id_Sexo->Exportable) $Doc->ExportField($this->Id_Sexo);
						if ($this->Id_Cargo->Exportable) $Doc->ExportField($this->Id_Cargo);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Curso->Exportable) $Doc->ExportField($this->Id_Curso);
						if ($this->Id_Division->Exportable) $Doc->ExportField($this->Id_Division);
						if ($this->Id_Turno->Exportable) $Doc->ExportField($this->Id_Turno);
						if ($this->Dni_Tutor->Exportable) $Doc->ExportField($this->Dni_Tutor);
						if ($this->NroSerie->Exportable) $Doc->ExportField($this->NroSerie);
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
