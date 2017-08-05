<?php

// Global variable for table object
$datosestablecimiento = NULL;

//
// Table class for datosestablecimiento
//
class cdatosestablecimiento extends cTable {
	var $CUE;
	var $Sigla;
	var $Establecimiento;
	var $Id_Departamento;
	var $Id_Localidad;
	var $Domicilio;
	var $Telefono;
	var $Mail;
	var $Nro_Matricula;
	var $Cantidad_Aulas;
	var $Comparte_Edificio;
	var $Cantidad_Turnos;
	var $Geolocalizacion;
	var $Id_Tipo_Esc;
	var $Universo;
	var $Tiene_Programa;
	var $Sector;
	var $Cantidad_Netbook_Conig;
	var $Nro_Cuise;
	var $Id_Nivel;
	var $Id_Jornada;
	var $Tipo_Zona;
	var $Id_Estado_Esc;
	var $Id_Zona;
	var $Cantidad_Netbook_Actuales;
	var $Fecha_Actualizacion;
	var $Usuario;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'datosestablecimiento';
		$this->TableName = 'datosestablecimiento';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`datosestablecimiento`";
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
		$this->CUE = new cField('datosestablecimiento', 'datosestablecimiento', 'x_CUE', 'CUE', '`CUE`', '`CUE`', 200, -1, FALSE, '`CUE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CUE->Sortable = TRUE; // Allow sort
		$this->fields['CUE'] = &$this->CUE;

		// Sigla
		$this->Sigla = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Sigla', 'Sigla', '`Sigla`', '`Sigla`', 200, -1, FALSE, '`Sigla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sigla->Sortable = TRUE; // Allow sort
		$this->fields['Sigla'] = &$this->Sigla;

		// Establecimiento
		$this->Establecimiento = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Establecimiento', 'Establecimiento', '`Establecimiento`', '`Establecimiento`', 200, -1, FALSE, '`Establecimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Establecimiento->Sortable = TRUE; // Allow sort
		$this->fields['Establecimiento'] = &$this->Establecimiento;

		// Id_Departamento
		$this->Id_Departamento = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Departamento', 'Id_Departamento', '`Id_Departamento`', '`Id_Departamento`', 3, -1, FALSE, '`Id_Departamento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Departamento->Sortable = TRUE; // Allow sort
		$this->Id_Departamento->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Departamento->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Departamento'] = &$this->Id_Departamento;

		// Id_Localidad
		$this->Id_Localidad = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Localidad', 'Id_Localidad', '`Id_Localidad`', '`Id_Localidad`', 3, -1, FALSE, '`Id_Localidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Localidad->Sortable = TRUE; // Allow sort
		$this->Id_Localidad->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Localidad->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Localidad'] = &$this->Id_Localidad;

		// Domicilio
		$this->Domicilio = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Telefono
		$this->Telefono = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Telefono', 'Telefono', '`Telefono`', '`Telefono`', 200, -1, FALSE, '`Telefono`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Telefono->Sortable = TRUE; // Allow sort
		$this->fields['Telefono'] = &$this->Telefono;

		// Mail
		$this->Mail = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Mail', 'Mail', '`Mail`', '`Mail`', 200, -1, FALSE, '`Mail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Mail->Sortable = TRUE; // Allow sort
		$this->fields['Mail'] = &$this->Mail;

		// Nro Matricula
		$this->Nro_Matricula = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Nro_Matricula', 'Nro Matricula', '`Nro Matricula`', '`Nro Matricula`', 3, -1, FALSE, '`Nro Matricula`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Matricula->Sortable = TRUE; // Allow sort
		$this->Nro_Matricula->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Nro Matricula'] = &$this->Nro_Matricula;

		// Cantidad Aulas
		$this->Cantidad_Aulas = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Cantidad_Aulas', 'Cantidad Aulas', '`Cantidad Aulas`', '`Cantidad Aulas`', 3, -1, FALSE, '`Cantidad Aulas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Aulas->Sortable = TRUE; // Allow sort
		$this->Cantidad_Aulas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad Aulas'] = &$this->Cantidad_Aulas;

		// Comparte Edificio
		$this->Comparte_Edificio = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Comparte_Edificio', 'Comparte Edificio', '`Comparte Edificio`', '`Comparte Edificio`', 200, -1, FALSE, '`Comparte Edificio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Comparte_Edificio->Sortable = TRUE; // Allow sort
		$this->Comparte_Edificio->OptionCount = 2;
		$this->Comparte_Edificio->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Comparte Edificio'] = &$this->Comparte_Edificio;

		// Cantidad_Turnos
		$this->Cantidad_Turnos = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Cantidad_Turnos', 'Cantidad_Turnos', '`Cantidad_Turnos`', '`Cantidad_Turnos`', 3, -1, FALSE, '`Cantidad_Turnos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Turnos->Sortable = TRUE; // Allow sort
		$this->Cantidad_Turnos->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Turnos'] = &$this->Cantidad_Turnos;

		// Geolocalizacion
		$this->Geolocalizacion = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Geolocalizacion', 'Geolocalizacion', '`Geolocalizacion`', '`Geolocalizacion`', 201, -1, FALSE, '`Geolocalizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Geolocalizacion->Sortable = TRUE; // Allow sort
		$this->fields['Geolocalizacion'] = &$this->Geolocalizacion;

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Tipo_Esc', 'Id_Tipo_Esc', '`Id_Tipo_Esc`', '`Id_Tipo_Esc`', 200, -1, FALSE, '`Id_Tipo_Esc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Id_Tipo_Esc->Sortable = TRUE; // Allow sort
		$this->fields['Id_Tipo_Esc'] = &$this->Id_Tipo_Esc;

		// Universo
		$this->Universo = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Universo', 'Universo', '`Universo`', '`Universo`', 200, -1, FALSE, '`Universo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Universo->Sortable = TRUE; // Allow sort
		$this->fields['Universo'] = &$this->Universo;

		// Tiene_Programa
		$this->Tiene_Programa = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Tiene_Programa', 'Tiene_Programa', '`Tiene_Programa`', '`Tiene_Programa`', 200, -1, FALSE, '`Tiene_Programa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tiene_Programa->Sortable = TRUE; // Allow sort
		$this->fields['Tiene_Programa'] = &$this->Tiene_Programa;

		// Sector
		$this->Sector = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Sector', 'Sector', '`Sector`', '`Sector`', 200, -1, FALSE, '`Sector`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sector->Sortable = TRUE; // Allow sort
		$this->fields['Sector'] = &$this->Sector;

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Cantidad_Netbook_Conig', 'Cantidad_Netbook_Conig', '`Cantidad_Netbook_Conig`', '`Cantidad_Netbook_Conig`', 3, -1, FALSE, '`Cantidad_Netbook_Conig`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Netbook_Conig->Sortable = TRUE; // Allow sort
		$this->Cantidad_Netbook_Conig->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Netbook_Conig'] = &$this->Cantidad_Netbook_Conig;

		// Nro_Cuise
		$this->Nro_Cuise = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Nro_Cuise', 'Nro_Cuise', '`Nro_Cuise`', '`Nro_Cuise`', 3, -1, FALSE, '`Nro_Cuise`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nro_Cuise->Sortable = TRUE; // Allow sort
		$this->Nro_Cuise->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Nro_Cuise'] = &$this->Nro_Cuise;

		// Id_Nivel
		$this->Id_Nivel = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Nivel', 'Id_Nivel', '`Id_Nivel`', '`Id_Nivel`', 201, -1, FALSE, '`Id_Nivel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Id_Nivel->Sortable = TRUE; // Allow sort
		$this->fields['Id_Nivel'] = &$this->Id_Nivel;

		// Id_Jornada
		$this->Id_Jornada = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Jornada', 'Id_Jornada', '`Id_Jornada`', '`Id_Jornada`', 201, -1, FALSE, '`Id_Jornada`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Id_Jornada->Sortable = TRUE; // Allow sort
		$this->fields['Id_Jornada'] = &$this->Id_Jornada;

		// Tipo_Zona
		$this->Tipo_Zona = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Tipo_Zona', 'Tipo_Zona', '`Tipo_Zona`', '`Tipo_Zona`', 200, -1, FALSE, '`Tipo_Zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tipo_Zona->Sortable = TRUE; // Allow sort
		$this->fields['Tipo_Zona'] = &$this->Tipo_Zona;

		// Id_Estado_Esc
		$this->Id_Estado_Esc = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Estado_Esc', 'Id_Estado_Esc', '`Id_Estado_Esc`', '`Id_Estado_Esc`', 3, -1, FALSE, '`Id_Estado_Esc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Esc->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Esc->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Esc->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado_Esc->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado_Esc'] = &$this->Id_Estado_Esc;

		// Id_Zona
		$this->Id_Zona = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Id_Zona', 'Id_Zona', '`Id_Zona`', '`Id_Zona`', 3, -1, FALSE, '`Id_Zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Zona->Sortable = TRUE; // Allow sort
		$this->Id_Zona->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Zona->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Zona->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Zona'] = &$this->Id_Zona;

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Cantidad_Netbook_Actuales', 'Cantidad_Netbook_Actuales', '`Cantidad_Netbook_Actuales`', '`Cantidad_Netbook_Actuales`', 3, -1, FALSE, '`Cantidad_Netbook_Actuales`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cantidad_Netbook_Actuales->Sortable = TRUE; // Allow sort
		$this->Cantidad_Netbook_Actuales->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cantidad_Netbook_Actuales'] = &$this->Cantidad_Netbook_Actuales;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Fecha_Actualizacion', 'Fecha_Actualizacion', '`Fecha_Actualizacion`', 'DATE_FORMAT(`Fecha_Actualizacion`, \'\')', 133, 7, FALSE, '`Fecha_Actualizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Actualizacion->Sortable = TRUE; // Allow sort
		$this->Fecha_Actualizacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion;

		// Usuario
		$this->Usuario = new cField('datosestablecimiento', 'datosestablecimiento', 'x_Usuario', 'Usuario', '`Usuario`', '`Usuario`', 200, -1, FALSE, '`Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Usuario->Sortable = TRUE; // Allow sort
		$this->fields['Usuario'] = &$this->Usuario;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`datosestablecimiento`";
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
		return "`CUE` = '@CUE@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@CUE@", ew_AdjustSql($this->CUE->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "datosestablecimientolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "datosestablecimientolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("datosestablecimientoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("datosestablecimientoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "datosestablecimientoadd.php?" . $this->UrlParm($parm);
		else
			$url = "datosestablecimientoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("datosestablecimientoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("datosestablecimientoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("datosestablecimientodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "CUE:" . ew_VarToJson($this->CUE->CurrentValue, "string", "'");
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
			if ($isPost && isset($_POST["CUE"]))
				$arKeys[] = ew_StripSlashes($_POST["CUE"]);
			elseif (isset($_GET["CUE"]))
				$arKeys[] = ew_StripSlashes($_GET["CUE"]);
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
			$this->CUE->CurrentValue = $key;
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
		$this->Establecimiento->setDbValue($rs->fields('Establecimiento'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Nro_Matricula->setDbValue($rs->fields('Nro Matricula'));
		$this->Cantidad_Aulas->setDbValue($rs->fields('Cantidad Aulas'));
		$this->Comparte_Edificio->setDbValue($rs->fields('Comparte Edificio'));
		$this->Cantidad_Turnos->setDbValue($rs->fields('Cantidad_Turnos'));
		$this->Geolocalizacion->setDbValue($rs->fields('Geolocalizacion'));
		$this->Id_Tipo_Esc->setDbValue($rs->fields('Id_Tipo_Esc'));
		$this->Universo->setDbValue($rs->fields('Universo'));
		$this->Tiene_Programa->setDbValue($rs->fields('Tiene_Programa'));
		$this->Sector->setDbValue($rs->fields('Sector'));
		$this->Cantidad_Netbook_Conig->setDbValue($rs->fields('Cantidad_Netbook_Conig'));
		$this->Nro_Cuise->setDbValue($rs->fields('Nro_Cuise'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Jornada->setDbValue($rs->fields('Id_Jornada'));
		$this->Tipo_Zona->setDbValue($rs->fields('Tipo_Zona'));
		$this->Id_Estado_Esc->setDbValue($rs->fields('Id_Estado_Esc'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Cantidad_Netbook_Actuales->setDbValue($rs->fields('Cantidad_Netbook_Actuales'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CUE
		// Sigla
		// Establecimiento
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono
		// Mail
		// Nro Matricula
		// Cantidad Aulas
		// Comparte Edificio
		// Cantidad_Turnos
		// Geolocalizacion
		// Id_Tipo_Esc
		// Universo
		// Tiene_Programa
		// Sector
		// Cantidad_Netbook_Conig
		// Nro_Cuise
		// Id_Nivel
		// Id_Jornada
		// Tipo_Zona
		// Id_Estado_Esc
		// Id_Zona
		// Cantidad_Netbook_Actuales
		// Fecha_Actualizacion
		// Usuario
		// CUE

		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->ViewValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
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
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
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

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Nro Matricula
		$this->Nro_Matricula->ViewValue = $this->Nro_Matricula->CurrentValue;
		$this->Nro_Matricula->ViewCustomAttributes = "";

		// Cantidad Aulas
		$this->Cantidad_Aulas->ViewValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Aulas->ViewCustomAttributes = "";

		// Comparte Edificio
		if (strval($this->Comparte_Edificio->CurrentValue) <> "") {
			$this->Comparte_Edificio->ViewValue = $this->Comparte_Edificio->OptionCaption($this->Comparte_Edificio->CurrentValue);
		} else {
			$this->Comparte_Edificio->ViewValue = NULL;
		}
		$this->Comparte_Edificio->ViewCustomAttributes = "";

		// Cantidad_Turnos
		$this->Cantidad_Turnos->ViewValue = $this->Cantidad_Turnos->CurrentValue;
		$this->Cantidad_Turnos->ViewCustomAttributes = "";

		// Geolocalizacion
		$this->Geolocalizacion->ViewValue = $this->Geolocalizacion->CurrentValue;
		$this->Geolocalizacion->ViewCustomAttributes = "";

		// Id_Tipo_Esc
		if (strval($this->Id_Tipo_Esc->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_escuela`";
		$sWhereWrk = "";
		$this->Id_Tipo_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tipo_Esc->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Tipo_Esc->ViewValue .= $this->Id_Tipo_Esc->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Tipo_Esc->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Esc->ViewValue = $this->Id_Tipo_Esc->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Esc->ViewValue = NULL;
		}
		$this->Id_Tipo_Esc->ViewCustomAttributes = "";

		// Universo
		$this->Universo->ViewValue = $this->Universo->CurrentValue;
		$this->Universo->ViewCustomAttributes = "";

		// Tiene_Programa
		$this->Tiene_Programa->ViewValue = $this->Tiene_Programa->CurrentValue;
		$this->Tiene_Programa->ViewCustomAttributes = "";

		// Sector
		$this->Sector->ViewValue = $this->Sector->CurrentValue;
		$this->Sector->ViewCustomAttributes = "";

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->ViewValue = $this->Cantidad_Netbook_Conig->CurrentValue;
		$this->Cantidad_Netbook_Conig->ViewCustomAttributes = "";

		// Nro_Cuise
		$this->Nro_Cuise->ViewValue = $this->Nro_Cuise->CurrentValue;
		$this->Nro_Cuise->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Nivel->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Nivel`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Nivel->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Nivel->ViewValue .= $this->Id_Nivel->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Nivel->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Jornada
		if (strval($this->Id_Jornada->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Jornada->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Jornada`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Jornada`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_jornada`";
		$sWhereWrk = "";
		$this->Id_Jornada->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Jornada, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Jornada->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Jornada->ViewValue .= $this->Id_Jornada->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Jornada->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Jornada->ViewValue = $this->Id_Jornada->CurrentValue;
			}
		} else {
			$this->Id_Jornada->ViewValue = NULL;
		}
		$this->Id_Jornada->ViewCustomAttributes = "";

		// Tipo_Zona
		$this->Tipo_Zona->ViewValue = $this->Tipo_Zona->CurrentValue;
		$this->Tipo_Zona->ViewCustomAttributes = "";

		// Id_Estado_Esc
		if (strval($this->Id_Estado_Esc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Estado_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Esc->ViewValue = NULL;
		}
		$this->Id_Estado_Esc->ViewCustomAttributes = "";

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

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->ViewValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Cantidad_Netbook_Actuales->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// CUE
		$this->CUE->LinkCustomAttributes = "";
		$this->CUE->HrefValue = "";
		$this->CUE->TooltipValue = "";

		// Sigla
		$this->Sigla->LinkCustomAttributes = "";
		$this->Sigla->HrefValue = "";
		$this->Sigla->TooltipValue = "";

		// Establecimiento
		$this->Establecimiento->LinkCustomAttributes = "";
		$this->Establecimiento->HrefValue = "";
		$this->Establecimiento->TooltipValue = "";

		// Id_Departamento
		$this->Id_Departamento->LinkCustomAttributes = "";
		$this->Id_Departamento->HrefValue = "";
		$this->Id_Departamento->TooltipValue = "";

		// Id_Localidad
		$this->Id_Localidad->LinkCustomAttributes = "";
		$this->Id_Localidad->HrefValue = "";
		$this->Id_Localidad->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Telefono
		$this->Telefono->LinkCustomAttributes = "";
		$this->Telefono->HrefValue = "";
		$this->Telefono->TooltipValue = "";

		// Mail
		$this->Mail->LinkCustomAttributes = "";
		$this->Mail->HrefValue = "";
		$this->Mail->TooltipValue = "";

		// Nro Matricula
		$this->Nro_Matricula->LinkCustomAttributes = "";
		$this->Nro_Matricula->HrefValue = "";
		$this->Nro_Matricula->TooltipValue = "";

		// Cantidad Aulas
		$this->Cantidad_Aulas->LinkCustomAttributes = "";
		$this->Cantidad_Aulas->HrefValue = "";
		$this->Cantidad_Aulas->TooltipValue = "";

		// Comparte Edificio
		$this->Comparte_Edificio->LinkCustomAttributes = "";
		$this->Comparte_Edificio->HrefValue = "";
		$this->Comparte_Edificio->TooltipValue = "";

		// Cantidad_Turnos
		$this->Cantidad_Turnos->LinkCustomAttributes = "";
		$this->Cantidad_Turnos->HrefValue = "";
		$this->Cantidad_Turnos->TooltipValue = "";

		// Geolocalizacion
		$this->Geolocalizacion->LinkCustomAttributes = "";
		$this->Geolocalizacion->HrefValue = "";
		$this->Geolocalizacion->TooltipValue = "";

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc->LinkCustomAttributes = "";
		$this->Id_Tipo_Esc->HrefValue = "";
		$this->Id_Tipo_Esc->TooltipValue = "";

		// Universo
		$this->Universo->LinkCustomAttributes = "";
		$this->Universo->HrefValue = "";
		$this->Universo->TooltipValue = "";

		// Tiene_Programa
		$this->Tiene_Programa->LinkCustomAttributes = "";
		$this->Tiene_Programa->HrefValue = "";
		$this->Tiene_Programa->TooltipValue = "";

		// Sector
		$this->Sector->LinkCustomAttributes = "";
		$this->Sector->HrefValue = "";
		$this->Sector->TooltipValue = "";

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->LinkCustomAttributes = "";
		$this->Cantidad_Netbook_Conig->HrefValue = "";
		$this->Cantidad_Netbook_Conig->TooltipValue = "";

		// Nro_Cuise
		$this->Nro_Cuise->LinkCustomAttributes = "";
		$this->Nro_Cuise->HrefValue = "";
		$this->Nro_Cuise->TooltipValue = "";

		// Id_Nivel
		$this->Id_Nivel->LinkCustomAttributes = "";
		$this->Id_Nivel->HrefValue = "";
		$this->Id_Nivel->TooltipValue = "";

		// Id_Jornada
		$this->Id_Jornada->LinkCustomAttributes = "";
		$this->Id_Jornada->HrefValue = "";
		$this->Id_Jornada->TooltipValue = "";

		// Tipo_Zona
		$this->Tipo_Zona->LinkCustomAttributes = "";
		$this->Tipo_Zona->HrefValue = "";
		$this->Tipo_Zona->TooltipValue = "";

		// Id_Estado_Esc
		$this->Id_Estado_Esc->LinkCustomAttributes = "";
		$this->Id_Estado_Esc->HrefValue = "";
		$this->Id_Estado_Esc->TooltipValue = "";

		// Id_Zona
		$this->Id_Zona->LinkCustomAttributes = "";
		$this->Id_Zona->HrefValue = "";
		$this->Id_Zona->TooltipValue = "";

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
		$this->Cantidad_Netbook_Actuales->HrefValue = "";
		$this->Cantidad_Netbook_Actuales->TooltipValue = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->LinkCustomAttributes = "";
		$this->Fecha_Actualizacion->HrefValue = "";
		$this->Fecha_Actualizacion->TooltipValue = "";

		// Usuario
		$this->Usuario->LinkCustomAttributes = "";
		$this->Usuario->HrefValue = "";
		$this->Usuario->TooltipValue = "";

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

		// Establecimiento
		$this->Establecimiento->EditAttrs["class"] = "form-control";
		$this->Establecimiento->EditCustomAttributes = "";
		$this->Establecimiento->EditValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->PlaceHolder = ew_RemoveHtml($this->Establecimiento->FldCaption());

		// Id_Departamento
		$this->Id_Departamento->EditAttrs["class"] = "form-control";
		$this->Id_Departamento->EditCustomAttributes = "";

		// Id_Localidad
		$this->Id_Localidad->EditAttrs["class"] = "form-control";
		$this->Id_Localidad->EditCustomAttributes = "";

		// Domicilio
		$this->Domicilio->EditAttrs["class"] = "form-control";
		$this->Domicilio->EditCustomAttributes = "";
		$this->Domicilio->EditValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

		// Telefono
		$this->Telefono->EditAttrs["class"] = "form-control";
		$this->Telefono->EditCustomAttributes = "";
		$this->Telefono->EditValue = $this->Telefono->CurrentValue;
		$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

		// Mail
		$this->Mail->EditAttrs["class"] = "form-control";
		$this->Mail->EditCustomAttributes = "";
		$this->Mail->EditValue = $this->Mail->CurrentValue;
		$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

		// Nro Matricula
		$this->Nro_Matricula->EditAttrs["class"] = "form-control";
		$this->Nro_Matricula->EditCustomAttributes = "";
		$this->Nro_Matricula->EditValue = $this->Nro_Matricula->CurrentValue;
		$this->Nro_Matricula->PlaceHolder = ew_RemoveHtml($this->Nro_Matricula->FldCaption());

		// Cantidad Aulas
		$this->Cantidad_Aulas->EditAttrs["class"] = "form-control";
		$this->Cantidad_Aulas->EditCustomAttributes = "";
		$this->Cantidad_Aulas->EditValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Aulas->PlaceHolder = ew_RemoveHtml($this->Cantidad_Aulas->FldCaption());

		// Comparte Edificio
		$this->Comparte_Edificio->EditCustomAttributes = "";
		$this->Comparte_Edificio->EditValue = $this->Comparte_Edificio->Options(FALSE);

		// Cantidad_Turnos
		$this->Cantidad_Turnos->EditAttrs["class"] = "form-control";
		$this->Cantidad_Turnos->EditCustomAttributes = "";
		$this->Cantidad_Turnos->EditValue = $this->Cantidad_Turnos->CurrentValue;
		$this->Cantidad_Turnos->PlaceHolder = ew_RemoveHtml($this->Cantidad_Turnos->FldCaption());

		// Geolocalizacion
		$this->Geolocalizacion->EditAttrs["class"] = "form-control";
		$this->Geolocalizacion->EditCustomAttributes = "";
		$this->Geolocalizacion->EditValue = $this->Geolocalizacion->CurrentValue;
		$this->Geolocalizacion->PlaceHolder = ew_RemoveHtml($this->Geolocalizacion->FldCaption());

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc->EditCustomAttributes = "";

		// Universo
		$this->Universo->EditAttrs["class"] = "form-control";
		$this->Universo->EditCustomAttributes = "";
		$this->Universo->EditValue = $this->Universo->CurrentValue;
		$this->Universo->PlaceHolder = ew_RemoveHtml($this->Universo->FldCaption());

		// Tiene_Programa
		$this->Tiene_Programa->EditAttrs["class"] = "form-control";
		$this->Tiene_Programa->EditCustomAttributes = "";
		$this->Tiene_Programa->EditValue = $this->Tiene_Programa->CurrentValue;
		$this->Tiene_Programa->PlaceHolder = ew_RemoveHtml($this->Tiene_Programa->FldCaption());

		// Sector
		$this->Sector->EditAttrs["class"] = "form-control";
		$this->Sector->EditCustomAttributes = "";
		$this->Sector->EditValue = $this->Sector->CurrentValue;
		$this->Sector->PlaceHolder = ew_RemoveHtml($this->Sector->FldCaption());

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->EditAttrs["class"] = "form-control";
		$this->Cantidad_Netbook_Conig->EditCustomAttributes = "";
		$this->Cantidad_Netbook_Conig->EditValue = $this->Cantidad_Netbook_Conig->CurrentValue;
		$this->Cantidad_Netbook_Conig->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Conig->FldCaption());

		// Nro_Cuise
		$this->Nro_Cuise->EditAttrs["class"] = "form-control";
		$this->Nro_Cuise->EditCustomAttributes = "";
		$this->Nro_Cuise->EditValue = $this->Nro_Cuise->CurrentValue;
		$this->Nro_Cuise->PlaceHolder = ew_RemoveHtml($this->Nro_Cuise->FldCaption());

		// Id_Nivel
		$this->Id_Nivel->EditCustomAttributes = "";

		// Id_Jornada
		$this->Id_Jornada->EditCustomAttributes = "";

		// Tipo_Zona
		$this->Tipo_Zona->EditAttrs["class"] = "form-control";
		$this->Tipo_Zona->EditCustomAttributes = "";
		$this->Tipo_Zona->EditValue = $this->Tipo_Zona->CurrentValue;
		$this->Tipo_Zona->PlaceHolder = ew_RemoveHtml($this->Tipo_Zona->FldCaption());

		// Id_Estado_Esc
		$this->Id_Estado_Esc->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Esc->EditCustomAttributes = "";

		// Id_Zona
		$this->Id_Zona->EditAttrs["class"] = "form-control";
		$this->Id_Zona->EditCustomAttributes = "";

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->EditAttrs["class"] = "form-control";
		$this->Cantidad_Netbook_Actuales->EditCustomAttributes = "";
		$this->Cantidad_Netbook_Actuales->EditValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Cantidad_Netbook_Actuales->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Actuales->FldCaption());

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
		$this->Fecha_Actualizacion->EditCustomAttributes = "";
		$this->Fecha_Actualizacion->EditValue = ew_FormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		$this->Fecha_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualizacion->FldCaption());

		// Usuario
		$this->Usuario->EditAttrs["class"] = "form-control";
		$this->Usuario->EditCustomAttributes = "";
		$this->Usuario->EditValue = $this->Usuario->CurrentValue;
		$this->Usuario->PlaceHolder = ew_RemoveHtml($this->Usuario->FldCaption());

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
					if ($this->Establecimiento->Exportable) $Doc->ExportCaption($this->Establecimiento);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Telefono->Exportable) $Doc->ExportCaption($this->Telefono);
					if ($this->Mail->Exportable) $Doc->ExportCaption($this->Mail);
					if ($this->Nro_Matricula->Exportable) $Doc->ExportCaption($this->Nro_Matricula);
					if ($this->Cantidad_Aulas->Exportable) $Doc->ExportCaption($this->Cantidad_Aulas);
					if ($this->Comparte_Edificio->Exportable) $Doc->ExportCaption($this->Comparte_Edificio);
					if ($this->Cantidad_Turnos->Exportable) $Doc->ExportCaption($this->Cantidad_Turnos);
					if ($this->Geolocalizacion->Exportable) $Doc->ExportCaption($this->Geolocalizacion);
					if ($this->Id_Tipo_Esc->Exportable) $Doc->ExportCaption($this->Id_Tipo_Esc);
					if ($this->Universo->Exportable) $Doc->ExportCaption($this->Universo);
					if ($this->Tiene_Programa->Exportable) $Doc->ExportCaption($this->Tiene_Programa);
					if ($this->Sector->Exportable) $Doc->ExportCaption($this->Sector);
					if ($this->Cantidad_Netbook_Conig->Exportable) $Doc->ExportCaption($this->Cantidad_Netbook_Conig);
					if ($this->Nro_Cuise->Exportable) $Doc->ExportCaption($this->Nro_Cuise);
					if ($this->Id_Nivel->Exportable) $Doc->ExportCaption($this->Id_Nivel);
					if ($this->Id_Jornada->Exportable) $Doc->ExportCaption($this->Id_Jornada);
					if ($this->Tipo_Zona->Exportable) $Doc->ExportCaption($this->Tipo_Zona);
					if ($this->Id_Estado_Esc->Exportable) $Doc->ExportCaption($this->Id_Estado_Esc);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->Cantidad_Netbook_Actuales->Exportable) $Doc->ExportCaption($this->Cantidad_Netbook_Actuales);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
				} else {
					if ($this->CUE->Exportable) $Doc->ExportCaption($this->CUE);
					if ($this->Sigla->Exportable) $Doc->ExportCaption($this->Sigla);
					if ($this->Establecimiento->Exportable) $Doc->ExportCaption($this->Establecimiento);
					if ($this->Id_Departamento->Exportable) $Doc->ExportCaption($this->Id_Departamento);
					if ($this->Id_Localidad->Exportable) $Doc->ExportCaption($this->Id_Localidad);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Telefono->Exportable) $Doc->ExportCaption($this->Telefono);
					if ($this->Mail->Exportable) $Doc->ExportCaption($this->Mail);
					if ($this->Nro_Matricula->Exportable) $Doc->ExportCaption($this->Nro_Matricula);
					if ($this->Cantidad_Aulas->Exportable) $Doc->ExportCaption($this->Cantidad_Aulas);
					if ($this->Comparte_Edificio->Exportable) $Doc->ExportCaption($this->Comparte_Edificio);
					if ($this->Cantidad_Turnos->Exportable) $Doc->ExportCaption($this->Cantidad_Turnos);
					if ($this->Id_Tipo_Esc->Exportable) $Doc->ExportCaption($this->Id_Tipo_Esc);
					if ($this->Universo->Exportable) $Doc->ExportCaption($this->Universo);
					if ($this->Tiene_Programa->Exportable) $Doc->ExportCaption($this->Tiene_Programa);
					if ($this->Sector->Exportable) $Doc->ExportCaption($this->Sector);
					if ($this->Cantidad_Netbook_Conig->Exportable) $Doc->ExportCaption($this->Cantidad_Netbook_Conig);
					if ($this->Nro_Cuise->Exportable) $Doc->ExportCaption($this->Nro_Cuise);
					if ($this->Tipo_Zona->Exportable) $Doc->ExportCaption($this->Tipo_Zona);
					if ($this->Id_Estado_Esc->Exportable) $Doc->ExportCaption($this->Id_Estado_Esc);
					if ($this->Id_Zona->Exportable) $Doc->ExportCaption($this->Id_Zona);
					if ($this->Cantidad_Netbook_Actuales->Exportable) $Doc->ExportCaption($this->Cantidad_Netbook_Actuales);
					if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportCaption($this->Fecha_Actualizacion);
					if ($this->Usuario->Exportable) $Doc->ExportCaption($this->Usuario);
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
						if ($this->Establecimiento->Exportable) $Doc->ExportField($this->Establecimiento);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Telefono->Exportable) $Doc->ExportField($this->Telefono);
						if ($this->Mail->Exportable) $Doc->ExportField($this->Mail);
						if ($this->Nro_Matricula->Exportable) $Doc->ExportField($this->Nro_Matricula);
						if ($this->Cantidad_Aulas->Exportable) $Doc->ExportField($this->Cantidad_Aulas);
						if ($this->Comparte_Edificio->Exportable) $Doc->ExportField($this->Comparte_Edificio);
						if ($this->Cantidad_Turnos->Exportable) $Doc->ExportField($this->Cantidad_Turnos);
						if ($this->Geolocalizacion->Exportable) $Doc->ExportField($this->Geolocalizacion);
						if ($this->Id_Tipo_Esc->Exportable) $Doc->ExportField($this->Id_Tipo_Esc);
						if ($this->Universo->Exportable) $Doc->ExportField($this->Universo);
						if ($this->Tiene_Programa->Exportable) $Doc->ExportField($this->Tiene_Programa);
						if ($this->Sector->Exportable) $Doc->ExportField($this->Sector);
						if ($this->Cantidad_Netbook_Conig->Exportable) $Doc->ExportField($this->Cantidad_Netbook_Conig);
						if ($this->Nro_Cuise->Exportable) $Doc->ExportField($this->Nro_Cuise);
						if ($this->Id_Nivel->Exportable) $Doc->ExportField($this->Id_Nivel);
						if ($this->Id_Jornada->Exportable) $Doc->ExportField($this->Id_Jornada);
						if ($this->Tipo_Zona->Exportable) $Doc->ExportField($this->Tipo_Zona);
						if ($this->Id_Estado_Esc->Exportable) $Doc->ExportField($this->Id_Estado_Esc);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->Cantidad_Netbook_Actuales->Exportable) $Doc->ExportField($this->Cantidad_Netbook_Actuales);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
					} else {
						if ($this->CUE->Exportable) $Doc->ExportField($this->CUE);
						if ($this->Sigla->Exportable) $Doc->ExportField($this->Sigla);
						if ($this->Establecimiento->Exportable) $Doc->ExportField($this->Establecimiento);
						if ($this->Id_Departamento->Exportable) $Doc->ExportField($this->Id_Departamento);
						if ($this->Id_Localidad->Exportable) $Doc->ExportField($this->Id_Localidad);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Telefono->Exportable) $Doc->ExportField($this->Telefono);
						if ($this->Mail->Exportable) $Doc->ExportField($this->Mail);
						if ($this->Nro_Matricula->Exportable) $Doc->ExportField($this->Nro_Matricula);
						if ($this->Cantidad_Aulas->Exportable) $Doc->ExportField($this->Cantidad_Aulas);
						if ($this->Comparte_Edificio->Exportable) $Doc->ExportField($this->Comparte_Edificio);
						if ($this->Cantidad_Turnos->Exportable) $Doc->ExportField($this->Cantidad_Turnos);
						if ($this->Id_Tipo_Esc->Exportable) $Doc->ExportField($this->Id_Tipo_Esc);
						if ($this->Universo->Exportable) $Doc->ExportField($this->Universo);
						if ($this->Tiene_Programa->Exportable) $Doc->ExportField($this->Tiene_Programa);
						if ($this->Sector->Exportable) $Doc->ExportField($this->Sector);
						if ($this->Cantidad_Netbook_Conig->Exportable) $Doc->ExportField($this->Cantidad_Netbook_Conig);
						if ($this->Nro_Cuise->Exportable) $Doc->ExportField($this->Nro_Cuise);
						if ($this->Tipo_Zona->Exportable) $Doc->ExportField($this->Tipo_Zona);
						if ($this->Id_Estado_Esc->Exportable) $Doc->ExportField($this->Id_Estado_Esc);
						if ($this->Id_Zona->Exportable) $Doc->ExportField($this->Id_Zona);
						if ($this->Cantidad_Netbook_Actuales->Exportable) $Doc->ExportField($this->Cantidad_Netbook_Actuales);
						if ($this->Fecha_Actualizacion->Exportable) $Doc->ExportField($this->Fecha_Actualizacion);
						if ($this->Usuario->Exportable) $Doc->ExportField($this->Usuario);
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
