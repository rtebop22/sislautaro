<?php

// Global variable for table object
$pase_establecimiento = NULL;

//
// Table class for pase_establecimiento
//
class cpase_establecimiento extends cTable {
	var $Id_Pase;
	var $Serie_Equipo;
	var $Id_Hardware;
	var $SN;
	var $Modelo_Net;
	var $Marca_Arranque;
	var $Nombre_Titular;
	var $Dni_Titular;
	var $Cuil_Titular;
	var $Nombre_Tutor;
	var $DniTutor;
	var $Domicilio;
	var $Tel_Tutor;
	var $CelTutor;
	var $Cue_Establecimiento_Alta;
	var $Escuela_Alta;
	var $Directivo_Alta;
	var $Cuil_Directivo_Alta;
	var $Dpto_Esc_alta;
	var $Localidad_Esc_Alta;
	var $Domicilio_Esc_Alta;
	var $Rte_Alta;
	var $Tel_Rte_Alta;
	var $Email_Rte_Alta;
	var $Serie_Server_Alta;
	var $Cue_Establecimiento_Baja;
	var $Escuela_Baja;
	var $Directivo_Baja;
	var $Cuil_Directivo_Baja;
	var $Dpto_Esc_Baja;
	var $Localidad_Esc_Baja;
	var $Domicilio_Esc_Baja;
	var $Rte_Baja;
	var $Tel_Rte_Baja;
	var $Email_Rte_Baja;
	var $Serie_Server_Baja;
	var $Fecha_Pase;
	var $Id_Estado_Pase;
	var $Ruta_Archivo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pase_establecimiento';
		$this->TableName = 'pase_establecimiento';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pase_establecimiento`";
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

		// Id_Pase
		$this->Id_Pase = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Id_Pase', 'Id_Pase', '`Id_Pase`', '`Id_Pase`', 3, -1, FALSE, '`Id_Pase`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Pase->Sortable = TRUE; // Allow sort
		$this->Id_Pase->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Pase'] = &$this->Id_Pase;

		// Serie_Equipo
		$this->Serie_Equipo = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Serie_Equipo', 'Serie_Equipo', '`Serie_Equipo`', '`Serie_Equipo`', 200, -1, FALSE, '`Serie_Equipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Equipo->Sortable = TRUE; // Allow sort
		$this->fields['Serie_Equipo'] = &$this->Serie_Equipo;

		// Id_Hardware
		$this->Id_Hardware = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Id_Hardware', 'Id_Hardware', '`Id_Hardware`', '`Id_Hardware`', 200, -1, FALSE, '`Id_Hardware`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Hardware->Sortable = TRUE; // Allow sort
		$this->fields['Id_Hardware'] = &$this->Id_Hardware;

		// SN
		$this->SN = new cField('pase_establecimiento', 'pase_establecimiento', 'x_SN', 'SN', '`SN`', '`SN`', 200, -1, FALSE, '`SN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SN->Sortable = TRUE; // Allow sort
		$this->fields['SN'] = &$this->SN;

		// Modelo_Net
		$this->Modelo_Net = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Modelo_Net', 'Modelo_Net', '`Modelo_Net`', '`Modelo_Net`', 200, -1, FALSE, '`Modelo_Net`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Modelo_Net->Sortable = TRUE; // Allow sort
		$this->Modelo_Net->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Modelo_Net->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Modelo_Net->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Modelo_Net'] = &$this->Modelo_Net;

		// Marca_Arranque
		$this->Marca_Arranque = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Marca_Arranque', 'Marca_Arranque', '`Marca_Arranque`', '`Marca_Arranque`', 200, -1, FALSE, '`Marca_Arranque`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Marca_Arranque->Sortable = TRUE; // Allow sort
		$this->fields['Marca_Arranque'] = &$this->Marca_Arranque;

		// Nombre_Titular
		$this->Nombre_Titular = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Nombre_Titular', 'Nombre_Titular', '`Nombre_Titular`', '`Nombre_Titular`', 200, -1, FALSE, '`Nombre_Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Titular->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Titular'] = &$this->Nombre_Titular;

		// Dni_Titular
		$this->Dni_Titular = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Dni_Titular', 'Dni_Titular', '`Dni_Titular`', '`Dni_Titular`', 3, -1, FALSE, '`Dni_Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni_Titular->Sortable = TRUE; // Allow sort
		$this->Dni_Titular->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni_Titular'] = &$this->Dni_Titular;

		// Cuil_Titular
		$this->Cuil_Titular = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Cuil_Titular', 'Cuil_Titular', '`Cuil_Titular`', '`Cuil_Titular`', 200, -1, FALSE, '`Cuil_Titular`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil_Titular->Sortable = TRUE; // Allow sort
		$this->fields['Cuil_Titular'] = &$this->Cuil_Titular;

		// Nombre_Tutor
		$this->Nombre_Tutor = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Nombre_Tutor', 'Nombre_Tutor', '`Nombre_Tutor`', '`Nombre_Tutor`', 200, -1, FALSE, '`Nombre_Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nombre_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Nombre_Tutor'] = &$this->Nombre_Tutor;

		// DniTutor
		$this->DniTutor = new cField('pase_establecimiento', 'pase_establecimiento', 'x_DniTutor', 'DniTutor', '`DniTutor`', '`DniTutor`', 3, -1, FALSE, '`DniTutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DniTutor->Sortable = TRUE; // Allow sort
		$this->DniTutor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['DniTutor'] = &$this->DniTutor;

		// Domicilio
		$this->Domicilio = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Domicilio', 'Domicilio', '`Domicilio`', '`Domicilio`', 200, -1, FALSE, '`Domicilio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio'] = &$this->Domicilio;

		// Tel_Tutor
		$this->Tel_Tutor = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Tel_Tutor', 'Tel_Tutor', '`Tel_Tutor`', '`Tel_Tutor`', 200, -1, FALSE, '`Tel_Tutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Tutor->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Tutor'] = &$this->Tel_Tutor;

		// CelTutor
		$this->CelTutor = new cField('pase_establecimiento', 'pase_establecimiento', 'x_CelTutor', 'CelTutor', '`CelTutor`', '`CelTutor`', 200, -1, FALSE, '`CelTutor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CelTutor->Sortable = TRUE; // Allow sort
		$this->fields['CelTutor'] = &$this->CelTutor;

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Cue_Establecimiento_Alta', 'Cue_Establecimiento_Alta', '`Cue_Establecimiento_Alta`', '`Cue_Establecimiento_Alta`', 200, -1, FALSE, '`Cue_Establecimiento_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cue_Establecimiento_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Cue_Establecimiento_Alta'] = &$this->Cue_Establecimiento_Alta;

		// Escuela_Alta
		$this->Escuela_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Escuela_Alta', 'Escuela_Alta', '`Escuela_Alta`', '`Escuela_Alta`', 200, -1, FALSE, '`Escuela_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Escuela_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Escuela_Alta'] = &$this->Escuela_Alta;

		// Directivo_Alta
		$this->Directivo_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Directivo_Alta', 'Directivo_Alta', '`Directivo_Alta`', '`Directivo_Alta`', 200, -1, FALSE, '`Directivo_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Directivo_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Directivo_Alta'] = &$this->Directivo_Alta;

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Cuil_Directivo_Alta', 'Cuil_Directivo_Alta', '`Cuil_Directivo_Alta`', '`Cuil_Directivo_Alta`', 200, -1, FALSE, '`Cuil_Directivo_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil_Directivo_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Cuil_Directivo_Alta'] = &$this->Cuil_Directivo_Alta;

		// Dpto_Esc_alta
		$this->Dpto_Esc_alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Dpto_Esc_alta', 'Dpto_Esc_alta', '`Dpto_Esc_alta`', '`Dpto_Esc_alta`', 200, -1, FALSE, '`Dpto_Esc_alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Dpto_Esc_alta->Sortable = TRUE; // Allow sort
		$this->Dpto_Esc_alta->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Dpto_Esc_alta->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Dpto_Esc_alta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dpto_Esc_alta'] = &$this->Dpto_Esc_alta;

		// Localidad_Esc_Alta
		$this->Localidad_Esc_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Localidad_Esc_Alta', 'Localidad_Esc_Alta', '`Localidad_Esc_Alta`', '`Localidad_Esc_Alta`', 200, -1, FALSE, '`Localidad_Esc_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Localidad_Esc_Alta->Sortable = TRUE; // Allow sort
		$this->Localidad_Esc_Alta->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Localidad_Esc_Alta->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Localidad_Esc_Alta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Localidad_Esc_Alta'] = &$this->Localidad_Esc_Alta;

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Domicilio_Esc_Alta', 'Domicilio_Esc_Alta', '`Domicilio_Esc_Alta`', '`Domicilio_Esc_Alta`', 200, -1, FALSE, '`Domicilio_Esc_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio_Esc_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio_Esc_Alta'] = &$this->Domicilio_Esc_Alta;

		// Rte_Alta
		$this->Rte_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Rte_Alta', 'Rte_Alta', '`Rte_Alta`', '`Rte_Alta`', 200, -1, FALSE, '`Rte_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Rte_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Rte_Alta'] = &$this->Rte_Alta;

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Tel_Rte_Alta', 'Tel_Rte_Alta', '`Tel_Rte_Alta`', '`Tel_Rte_Alta`', 200, -1, FALSE, '`Tel_Rte_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Rte_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Rte_Alta'] = &$this->Tel_Rte_Alta;

		// Email_Rte_Alta
		$this->Email_Rte_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Email_Rte_Alta', 'Email_Rte_Alta', '`Email_Rte_Alta`', '`Email_Rte_Alta`', 200, -1, FALSE, '`Email_Rte_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Email_Rte_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Email_Rte_Alta'] = &$this->Email_Rte_Alta;

		// Serie_Server_Alta
		$this->Serie_Server_Alta = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Serie_Server_Alta', 'Serie_Server_Alta', '`Serie_Server_Alta`', '`Serie_Server_Alta`', 200, -1, FALSE, '`Serie_Server_Alta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Server_Alta->Sortable = TRUE; // Allow sort
		$this->fields['Serie_Server_Alta'] = &$this->Serie_Server_Alta;

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Cue_Establecimiento_Baja', 'Cue_Establecimiento_Baja', '`Cue_Establecimiento_Baja`', '`Cue_Establecimiento_Baja`', 200, -1, FALSE, '`Cue_Establecimiento_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cue_Establecimiento_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Cue_Establecimiento_Baja'] = &$this->Cue_Establecimiento_Baja;

		// Escuela_Baja
		$this->Escuela_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Escuela_Baja', 'Escuela_Baja', '`Escuela_Baja`', '`Escuela_Baja`', 200, -1, FALSE, '`Escuela_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Escuela_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Escuela_Baja'] = &$this->Escuela_Baja;

		// Directivo_Baja
		$this->Directivo_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Directivo_Baja', 'Directivo_Baja', '`Directivo_Baja`', '`Directivo_Baja`', 200, -1, FALSE, '`Directivo_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Directivo_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Directivo_Baja'] = &$this->Directivo_Baja;

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Cuil_Directivo_Baja', 'Cuil_Directivo_Baja', '`Cuil_Directivo_Baja`', '`Cuil_Directivo_Baja`', 200, -1, FALSE, '`Cuil_Directivo_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cuil_Directivo_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Cuil_Directivo_Baja'] = &$this->Cuil_Directivo_Baja;

		// Dpto_Esc_Baja
		$this->Dpto_Esc_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Dpto_Esc_Baja', 'Dpto_Esc_Baja', '`Dpto_Esc_Baja`', '`Dpto_Esc_Baja`', 200, -1, FALSE, '`Dpto_Esc_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Dpto_Esc_Baja->Sortable = TRUE; // Allow sort
		$this->Dpto_Esc_Baja->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Dpto_Esc_Baja->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Dpto_Esc_Baja->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dpto_Esc_Baja'] = &$this->Dpto_Esc_Baja;

		// Localidad_Esc_Baja
		$this->Localidad_Esc_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Localidad_Esc_Baja', 'Localidad_Esc_Baja', '`Localidad_Esc_Baja`', '`Localidad_Esc_Baja`', 200, -1, FALSE, '`Localidad_Esc_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Localidad_Esc_Baja->Sortable = TRUE; // Allow sort
		$this->Localidad_Esc_Baja->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Localidad_Esc_Baja->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Localidad_Esc_Baja->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Localidad_Esc_Baja'] = &$this->Localidad_Esc_Baja;

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Domicilio_Esc_Baja', 'Domicilio_Esc_Baja', '`Domicilio_Esc_Baja`', '`Domicilio_Esc_Baja`', 200, -1, FALSE, '`Domicilio_Esc_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Domicilio_Esc_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Domicilio_Esc_Baja'] = &$this->Domicilio_Esc_Baja;

		// Rte_Baja
		$this->Rte_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Rte_Baja', 'Rte_Baja', '`Rte_Baja`', '`Rte_Baja`', 200, -1, FALSE, '`Rte_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Rte_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Rte_Baja'] = &$this->Rte_Baja;

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Tel_Rte_Baja', 'Tel_Rte_Baja', '`Tel_Rte_Baja`', '`Tel_Rte_Baja`', 200, -1, FALSE, '`Tel_Rte_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tel_Rte_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Tel_Rte_Baja'] = &$this->Tel_Rte_Baja;

		// Email_Rte_Baja
		$this->Email_Rte_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Email_Rte_Baja', 'Email_Rte_Baja', '`Email_Rte_Baja`', '`Email_Rte_Baja`', 200, -1, FALSE, '`Email_Rte_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Email_Rte_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Email_Rte_Baja'] = &$this->Email_Rte_Baja;

		// Serie_Server_Baja
		$this->Serie_Server_Baja = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Serie_Server_Baja', 'Serie_Server_Baja', '`Serie_Server_Baja`', '`Serie_Server_Baja`', 200, -1, FALSE, '`Serie_Server_Baja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Serie_Server_Baja->Sortable = TRUE; // Allow sort
		$this->fields['Serie_Server_Baja'] = &$this->Serie_Server_Baja;

		// Fecha_Pase
		$this->Fecha_Pase = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Fecha_Pase', 'Fecha_Pase', '`Fecha_Pase`', 'DATE_FORMAT(`Fecha_Pase`, \'\')', 133, 7, FALSE, '`Fecha_Pase`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Fecha_Pase->Sortable = TRUE; // Allow sort
		$this->Fecha_Pase->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha_Pase'] = &$this->Fecha_Pase;

		// Id_Estado_Pase
		$this->Id_Estado_Pase = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Id_Estado_Pase', 'Id_Estado_Pase', '`Id_Estado_Pase`', '`Id_Estado_Pase`', 3, -1, FALSE, '`Id_Estado_Pase`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado_Pase->Sortable = TRUE; // Allow sort
		$this->Id_Estado_Pase->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado_Pase->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Estado_Pase'] = &$this->Id_Estado_Pase;

		// Ruta_Archivo
		$this->Ruta_Archivo = new cField('pase_establecimiento', 'pase_establecimiento', 'x_Ruta_Archivo', 'Ruta_Archivo', '`Ruta_Archivo`', '`Ruta_Archivo`', 201, -1, TRUE, '`Ruta_Archivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->Ruta_Archivo->Sortable = TRUE; // Allow sort
		$this->Ruta_Archivo->UploadMultiple = TRUE;
		$this->Ruta_Archivo->Upload->UploadMultiple = TRUE;
		$this->Ruta_Archivo->UploadMaxFileCount = 0;
		$this->fields['Ruta_Archivo'] = &$this->Ruta_Archivo;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pase_establecimiento`";
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
			if (array_key_exists('Id_Pase', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Pase', $this->DBID) . '=' . ew_QuotedValue($rs['Id_Pase'], $this->Id_Pase->FldDataType, $this->DBID));
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
		return "`Id_Pase` = @Id_Pase@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Pase->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Pase@", ew_AdjustSql($this->Id_Pase->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "pase_establecimientolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pase_establecimientolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pase_establecimientoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pase_establecimientoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pase_establecimientoadd.php?" . $this->UrlParm($parm);
		else
			$url = "pase_establecimientoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pase_establecimientoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pase_establecimientoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pase_establecimientodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Id_Pase:" . ew_VarToJson($this->Id_Pase->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Pase->CurrentValue)) {
			$sUrl .= "Id_Pase=" . urlencode($this->Id_Pase->CurrentValue);
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
			if ($isPost && isset($_POST["Id_Pase"]))
				$arKeys[] = ew_StripSlashes($_POST["Id_Pase"]);
			elseif (isset($_GET["Id_Pase"]))
				$arKeys[] = ew_StripSlashes($_GET["Id_Pase"]);
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
			$this->Id_Pase->CurrentValue = $key;
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
		$this->Id_Pase->setDbValue($rs->fields('Id_Pase'));
		$this->Serie_Equipo->setDbValue($rs->fields('Serie_Equipo'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Modelo_Net->setDbValue($rs->fields('Modelo_Net'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Nombre_Titular->setDbValue($rs->fields('Nombre_Titular'));
		$this->Dni_Titular->setDbValue($rs->fields('Dni_Titular'));
		$this->Cuil_Titular->setDbValue($rs->fields('Cuil_Titular'));
		$this->Nombre_Tutor->setDbValue($rs->fields('Nombre_Tutor'));
		$this->DniTutor->setDbValue($rs->fields('DniTutor'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Tutor->setDbValue($rs->fields('Tel_Tutor'));
		$this->CelTutor->setDbValue($rs->fields('CelTutor'));
		$this->Cue_Establecimiento_Alta->setDbValue($rs->fields('Cue_Establecimiento_Alta'));
		$this->Escuela_Alta->setDbValue($rs->fields('Escuela_Alta'));
		$this->Directivo_Alta->setDbValue($rs->fields('Directivo_Alta'));
		$this->Cuil_Directivo_Alta->setDbValue($rs->fields('Cuil_Directivo_Alta'));
		$this->Dpto_Esc_alta->setDbValue($rs->fields('Dpto_Esc_alta'));
		$this->Localidad_Esc_Alta->setDbValue($rs->fields('Localidad_Esc_Alta'));
		$this->Domicilio_Esc_Alta->setDbValue($rs->fields('Domicilio_Esc_Alta'));
		$this->Rte_Alta->setDbValue($rs->fields('Rte_Alta'));
		$this->Tel_Rte_Alta->setDbValue($rs->fields('Tel_Rte_Alta'));
		$this->Email_Rte_Alta->setDbValue($rs->fields('Email_Rte_Alta'));
		$this->Serie_Server_Alta->setDbValue($rs->fields('Serie_Server_Alta'));
		$this->Cue_Establecimiento_Baja->setDbValue($rs->fields('Cue_Establecimiento_Baja'));
		$this->Escuela_Baja->setDbValue($rs->fields('Escuela_Baja'));
		$this->Directivo_Baja->setDbValue($rs->fields('Directivo_Baja'));
		$this->Cuil_Directivo_Baja->setDbValue($rs->fields('Cuil_Directivo_Baja'));
		$this->Dpto_Esc_Baja->setDbValue($rs->fields('Dpto_Esc_Baja'));
		$this->Localidad_Esc_Baja->setDbValue($rs->fields('Localidad_Esc_Baja'));
		$this->Domicilio_Esc_Baja->setDbValue($rs->fields('Domicilio_Esc_Baja'));
		$this->Rte_Baja->setDbValue($rs->fields('Rte_Baja'));
		$this->Tel_Rte_Baja->setDbValue($rs->fields('Tel_Rte_Baja'));
		$this->Email_Rte_Baja->setDbValue($rs->fields('Email_Rte_Baja'));
		$this->Serie_Server_Baja->setDbValue($rs->fields('Serie_Server_Baja'));
		$this->Fecha_Pase->setDbValue($rs->fields('Fecha_Pase'));
		$this->Id_Estado_Pase->setDbValue($rs->fields('Id_Estado_Pase'));
		$this->Ruta_Archivo->Upload->DbValue = $rs->fields('Ruta_Archivo');
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Pase
		// Serie_Equipo
		// Id_Hardware
		// SN
		// Modelo_Net
		// Marca_Arranque
		// Nombre_Titular
		// Dni_Titular
		// Cuil_Titular
		// Nombre_Tutor
		// DniTutor
		// Domicilio
		// Tel_Tutor
		// CelTutor
		// Cue_Establecimiento_Alta
		// Escuela_Alta
		// Directivo_Alta
		// Cuil_Directivo_Alta
		// Dpto_Esc_alta
		// Localidad_Esc_Alta
		// Domicilio_Esc_Alta
		// Rte_Alta
		// Tel_Rte_Alta
		// Email_Rte_Alta
		// Serie_Server_Alta
		// Cue_Establecimiento_Baja
		// Escuela_Baja
		// Directivo_Baja
		// Cuil_Directivo_Baja
		// Dpto_Esc_Baja
		// Localidad_Esc_Baja
		// Domicilio_Esc_Baja
		// Rte_Baja
		// Tel_Rte_Baja
		// Email_Rte_Baja
		// Serie_Server_Baja
		// Fecha_Pase
		// Id_Estado_Pase
		// Ruta_Archivo
		// Id_Pase

		$this->Id_Pase->ViewValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

		// Serie_Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		if (strval($this->Serie_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Equipo->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
			}
		} else {
			$this->Serie_Equipo->ViewValue = NULL;
		}
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Modelo_Net
		if (strval($this->Modelo_Net->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Modelo_Net->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
		$sWhereWrk = "";
		$this->Modelo_Net->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Modelo_Net, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->CurrentValue;
			}
		} else {
			$this->Modelo_Net->ViewValue = NULL;
		}
		$this->Modelo_Net->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Nombre_Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		if (strval($this->Nombre_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
			}
		} else {
			$this->Nombre_Titular->ViewValue = NULL;
		}
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni_Titular
		$this->Dni_Titular->ViewValue = $this->Dni_Titular->CurrentValue;
		$this->Dni_Titular->ViewCustomAttributes = "";

		// Cuil_Titular
		$this->Cuil_Titular->ViewValue = $this->Cuil_Titular->CurrentValue;
		$this->Cuil_Titular->ViewCustomAttributes = "";

		// Nombre_Tutor
		$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
		if (strval($this->Nombre_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Tutor->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
			}
		} else {
			$this->Nombre_Tutor->ViewValue = NULL;
		}
		$this->Nombre_Tutor->ViewCustomAttributes = "";

		// DniTutor
		$this->DniTutor->ViewValue = $this->DniTutor->CurrentValue;
		$this->DniTutor->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Tutor
		$this->Tel_Tutor->ViewValue = $this->Tel_Tutor->CurrentValue;
		$this->Tel_Tutor->ViewCustomAttributes = "";

		// CelTutor
		$this->CelTutor->ViewValue = $this->CelTutor->CurrentValue;
		$this->CelTutor->ViewCustomAttributes = "";

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
		if (strval($this->Cue_Establecimiento_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Alta->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Alta->ViewCustomAttributes = "";

		// Escuela_Alta
		$this->Escuela_Alta->ViewValue = $this->Escuela_Alta->CurrentValue;
		$this->Escuela_Alta->ViewCustomAttributes = "";

		// Directivo_Alta
		$this->Directivo_Alta->ViewValue = $this->Directivo_Alta->CurrentValue;
		$this->Directivo_Alta->ViewCustomAttributes = "";

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->ViewValue = $this->Cuil_Directivo_Alta->CurrentValue;
		$this->Cuil_Directivo_Alta->ViewCustomAttributes = "";

		// Dpto_Esc_alta
		if (strval($this->Dpto_Esc_alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_alta->ViewValue = NULL;
		}
		$this->Dpto_Esc_alta->ViewCustomAttributes = "";

		// Localidad_Esc_Alta
		if (strval($this->Localidad_Esc_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Alta->ViewValue = NULL;
		}
		$this->Localidad_Esc_Alta->ViewCustomAttributes = "";

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->ViewValue = $this->Domicilio_Esc_Alta->CurrentValue;
		$this->Domicilio_Esc_Alta->ViewCustomAttributes = "";

		// Rte_Alta
		$this->Rte_Alta->ViewValue = $this->Rte_Alta->CurrentValue;
		$this->Rte_Alta->ViewCustomAttributes = "";

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->ViewValue = $this->Tel_Rte_Alta->CurrentValue;
		$this->Tel_Rte_Alta->ViewCustomAttributes = "";

		// Email_Rte_Alta
		$this->Email_Rte_Alta->ViewValue = $this->Email_Rte_Alta->CurrentValue;
		$this->Email_Rte_Alta->ViewCustomAttributes = "";

		// Serie_Server_Alta
		$this->Serie_Server_Alta->ViewValue = $this->Serie_Server_Alta->CurrentValue;
		$this->Serie_Server_Alta->ViewCustomAttributes = "";

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
		if (strval($this->Cue_Establecimiento_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Baja->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Baja->ViewCustomAttributes = "";

		// Escuela_Baja
		$this->Escuela_Baja->ViewValue = $this->Escuela_Baja->CurrentValue;
		$this->Escuela_Baja->ViewCustomAttributes = "";

		// Directivo_Baja
		$this->Directivo_Baja->ViewValue = $this->Directivo_Baja->CurrentValue;
		$this->Directivo_Baja->ViewCustomAttributes = "";

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->ViewValue = $this->Cuil_Directivo_Baja->CurrentValue;
		$this->Cuil_Directivo_Baja->ViewCustomAttributes = "";

		// Dpto_Esc_Baja
		if (strval($this->Dpto_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_Baja->ViewValue = NULL;
		}
		$this->Dpto_Esc_Baja->ViewCustomAttributes = "";

		// Localidad_Esc_Baja
		if (strval($this->Localidad_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Baja->ViewValue = NULL;
		}
		$this->Localidad_Esc_Baja->ViewCustomAttributes = "";

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->ViewValue = $this->Domicilio_Esc_Baja->CurrentValue;
		$this->Domicilio_Esc_Baja->ViewCustomAttributes = "";

		// Rte_Baja
		$this->Rte_Baja->ViewValue = $this->Rte_Baja->CurrentValue;
		$this->Rte_Baja->ViewCustomAttributes = "";

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->ViewValue = $this->Tel_Rte_Baja->CurrentValue;
		$this->Tel_Rte_Baja->ViewCustomAttributes = "";

		// Email_Rte_Baja
		$this->Email_Rte_Baja->ViewValue = $this->Email_Rte_Baja->CurrentValue;
		$this->Email_Rte_Baja->ViewCustomAttributes = "";

		// Serie_Server_Baja
		$this->Serie_Server_Baja->ViewValue = $this->Serie_Server_Baja->CurrentValue;
		$this->Serie_Server_Baja->ViewCustomAttributes = "";

		// Fecha_Pase
		$this->Fecha_Pase->ViewValue = $this->Fecha_Pase->CurrentValue;
		$this->Fecha_Pase->ViewValue = ew_FormatDateTime($this->Fecha_Pase->ViewValue, 7);
		$this->Fecha_Pase->ViewCustomAttributes = "";

		// Id_Estado_Pase
		if (strval($this->Id_Estado_Pase->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
		$sWhereWrk = "";
		$this->Id_Estado_Pase->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->CurrentValue;
			}
		} else {
			$this->Id_Estado_Pase->ViewValue = NULL;
		}
		$this->Id_Estado_Pase->ViewCustomAttributes = "";

		// Ruta_Archivo
		$this->Ruta_Archivo->UploadPath = 'ArchivosPase';
		if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
			$this->Ruta_Archivo->ViewValue = $this->Ruta_Archivo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo->ViewValue = "";
		}
		$this->Ruta_Archivo->ViewCustomAttributes = "";

		// Id_Pase
		$this->Id_Pase->LinkCustomAttributes = "";
		$this->Id_Pase->HrefValue = "";
		$this->Id_Pase->TooltipValue = "";

		// Serie_Equipo
		$this->Serie_Equipo->LinkCustomAttributes = "";
		$this->Serie_Equipo->HrefValue = "";
		$this->Serie_Equipo->TooltipValue = "";

		// Id_Hardware
		$this->Id_Hardware->LinkCustomAttributes = "";
		$this->Id_Hardware->HrefValue = "";
		$this->Id_Hardware->TooltipValue = "";

		// SN
		$this->SN->LinkCustomAttributes = "";
		$this->SN->HrefValue = "";
		$this->SN->TooltipValue = "";

		// Modelo_Net
		$this->Modelo_Net->LinkCustomAttributes = "";
		$this->Modelo_Net->HrefValue = "";
		$this->Modelo_Net->TooltipValue = "";

		// Marca_Arranque
		$this->Marca_Arranque->LinkCustomAttributes = "";
		$this->Marca_Arranque->HrefValue = "";
		$this->Marca_Arranque->TooltipValue = "";

		// Nombre_Titular
		$this->Nombre_Titular->LinkCustomAttributes = "";
		$this->Nombre_Titular->HrefValue = "";
		$this->Nombre_Titular->TooltipValue = "";

		// Dni_Titular
		$this->Dni_Titular->LinkCustomAttributes = "";
		$this->Dni_Titular->HrefValue = "";
		$this->Dni_Titular->TooltipValue = "";

		// Cuil_Titular
		$this->Cuil_Titular->LinkCustomAttributes = "";
		$this->Cuil_Titular->HrefValue = "";
		$this->Cuil_Titular->TooltipValue = "";

		// Nombre_Tutor
		$this->Nombre_Tutor->LinkCustomAttributes = "";
		$this->Nombre_Tutor->HrefValue = "";
		$this->Nombre_Tutor->TooltipValue = "";

		// DniTutor
		$this->DniTutor->LinkCustomAttributes = "";
		$this->DniTutor->HrefValue = "";
		$this->DniTutor->TooltipValue = "";

		// Domicilio
		$this->Domicilio->LinkCustomAttributes = "";
		$this->Domicilio->HrefValue = "";
		$this->Domicilio->TooltipValue = "";

		// Tel_Tutor
		$this->Tel_Tutor->LinkCustomAttributes = "";
		$this->Tel_Tutor->HrefValue = "";
		$this->Tel_Tutor->TooltipValue = "";

		// CelTutor
		$this->CelTutor->LinkCustomAttributes = "";
		$this->CelTutor->HrefValue = "";
		$this->CelTutor->TooltipValue = "";

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
		$this->Cue_Establecimiento_Alta->HrefValue = "";
		$this->Cue_Establecimiento_Alta->TooltipValue = "";

		// Escuela_Alta
		$this->Escuela_Alta->LinkCustomAttributes = "";
		$this->Escuela_Alta->HrefValue = "";
		$this->Escuela_Alta->TooltipValue = "";

		// Directivo_Alta
		$this->Directivo_Alta->LinkCustomAttributes = "";
		$this->Directivo_Alta->HrefValue = "";
		$this->Directivo_Alta->TooltipValue = "";

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->LinkCustomAttributes = "";
		$this->Cuil_Directivo_Alta->HrefValue = "";
		$this->Cuil_Directivo_Alta->TooltipValue = "";

		// Dpto_Esc_alta
		$this->Dpto_Esc_alta->LinkCustomAttributes = "";
		$this->Dpto_Esc_alta->HrefValue = "";
		$this->Dpto_Esc_alta->TooltipValue = "";

		// Localidad_Esc_Alta
		$this->Localidad_Esc_Alta->LinkCustomAttributes = "";
		$this->Localidad_Esc_Alta->HrefValue = "";
		$this->Localidad_Esc_Alta->TooltipValue = "";

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->LinkCustomAttributes = "";
		$this->Domicilio_Esc_Alta->HrefValue = "";
		$this->Domicilio_Esc_Alta->TooltipValue = "";

		// Rte_Alta
		$this->Rte_Alta->LinkCustomAttributes = "";
		$this->Rte_Alta->HrefValue = "";
		$this->Rte_Alta->TooltipValue = "";

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->LinkCustomAttributes = "";
		$this->Tel_Rte_Alta->HrefValue = "";
		$this->Tel_Rte_Alta->TooltipValue = "";

		// Email_Rte_Alta
		$this->Email_Rte_Alta->LinkCustomAttributes = "";
		$this->Email_Rte_Alta->HrefValue = "";
		$this->Email_Rte_Alta->TooltipValue = "";

		// Serie_Server_Alta
		$this->Serie_Server_Alta->LinkCustomAttributes = "";
		$this->Serie_Server_Alta->HrefValue = "";
		$this->Serie_Server_Alta->TooltipValue = "";

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
		$this->Cue_Establecimiento_Baja->HrefValue = "";
		$this->Cue_Establecimiento_Baja->TooltipValue = "";

		// Escuela_Baja
		$this->Escuela_Baja->LinkCustomAttributes = "";
		$this->Escuela_Baja->HrefValue = "";
		$this->Escuela_Baja->TooltipValue = "";

		// Directivo_Baja
		$this->Directivo_Baja->LinkCustomAttributes = "";
		$this->Directivo_Baja->HrefValue = "";
		$this->Directivo_Baja->TooltipValue = "";

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->LinkCustomAttributes = "";
		$this->Cuil_Directivo_Baja->HrefValue = "";
		$this->Cuil_Directivo_Baja->TooltipValue = "";

		// Dpto_Esc_Baja
		$this->Dpto_Esc_Baja->LinkCustomAttributes = "";
		$this->Dpto_Esc_Baja->HrefValue = "";
		$this->Dpto_Esc_Baja->TooltipValue = "";

		// Localidad_Esc_Baja
		$this->Localidad_Esc_Baja->LinkCustomAttributes = "";
		$this->Localidad_Esc_Baja->HrefValue = "";
		$this->Localidad_Esc_Baja->TooltipValue = "";

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->LinkCustomAttributes = "";
		$this->Domicilio_Esc_Baja->HrefValue = "";
		$this->Domicilio_Esc_Baja->TooltipValue = "";

		// Rte_Baja
		$this->Rte_Baja->LinkCustomAttributes = "";
		$this->Rte_Baja->HrefValue = "";
		$this->Rte_Baja->TooltipValue = "";

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->LinkCustomAttributes = "";
		$this->Tel_Rte_Baja->HrefValue = "";
		$this->Tel_Rte_Baja->TooltipValue = "";

		// Email_Rte_Baja
		$this->Email_Rte_Baja->LinkCustomAttributes = "";
		$this->Email_Rte_Baja->HrefValue = "";
		$this->Email_Rte_Baja->TooltipValue = "";

		// Serie_Server_Baja
		$this->Serie_Server_Baja->LinkCustomAttributes = "";
		$this->Serie_Server_Baja->HrefValue = "";
		$this->Serie_Server_Baja->TooltipValue = "";

		// Fecha_Pase
		$this->Fecha_Pase->LinkCustomAttributes = "";
		$this->Fecha_Pase->HrefValue = "";
		$this->Fecha_Pase->TooltipValue = "";

		// Id_Estado_Pase
		$this->Id_Estado_Pase->LinkCustomAttributes = "";
		$this->Id_Estado_Pase->HrefValue = "";
		$this->Id_Estado_Pase->TooltipValue = "";

		// Ruta_Archivo
		$this->Ruta_Archivo->LinkCustomAttributes = "";
		$this->Ruta_Archivo->HrefValue = "";
		$this->Ruta_Archivo->HrefValue2 = $this->Ruta_Archivo->UploadPath . $this->Ruta_Archivo->Upload->DbValue;
		$this->Ruta_Archivo->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Pase
		$this->Id_Pase->EditAttrs["class"] = "form-control";
		$this->Id_Pase->EditCustomAttributes = "";
		$this->Id_Pase->EditValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

		// Serie_Equipo
		$this->Serie_Equipo->EditAttrs["class"] = "form-control";
		$this->Serie_Equipo->EditCustomAttributes = "";
		$this->Serie_Equipo->EditValue = $this->Serie_Equipo->CurrentValue;
		$this->Serie_Equipo->PlaceHolder = ew_RemoveHtml($this->Serie_Equipo->FldCaption());

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

		// Modelo_Net
		$this->Modelo_Net->EditAttrs["class"] = "form-control";
		$this->Modelo_Net->EditCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->EditAttrs["class"] = "form-control";
		$this->Marca_Arranque->EditCustomAttributes = "";
		$this->Marca_Arranque->EditValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

		// Nombre_Titular
		$this->Nombre_Titular->EditAttrs["class"] = "form-control";
		$this->Nombre_Titular->EditCustomAttributes = "";
		$this->Nombre_Titular->EditValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Nombre_Titular->FldCaption());

		// Dni_Titular
		$this->Dni_Titular->EditAttrs["class"] = "form-control";
		$this->Dni_Titular->EditCustomAttributes = "";
		$this->Dni_Titular->EditValue = $this->Dni_Titular->CurrentValue;
		$this->Dni_Titular->PlaceHolder = ew_RemoveHtml($this->Dni_Titular->FldCaption());

		// Cuil_Titular
		$this->Cuil_Titular->EditAttrs["class"] = "form-control";
		$this->Cuil_Titular->EditCustomAttributes = "";
		$this->Cuil_Titular->EditValue = $this->Cuil_Titular->CurrentValue;
		$this->Cuil_Titular->PlaceHolder = ew_RemoveHtml($this->Cuil_Titular->FldCaption());

		// Nombre_Tutor
		$this->Nombre_Tutor->EditAttrs["class"] = "form-control";
		$this->Nombre_Tutor->EditCustomAttributes = "";
		$this->Nombre_Tutor->EditValue = $this->Nombre_Tutor->CurrentValue;
		$this->Nombre_Tutor->PlaceHolder = ew_RemoveHtml($this->Nombre_Tutor->FldCaption());

		// DniTutor
		$this->DniTutor->EditAttrs["class"] = "form-control";
		$this->DniTutor->EditCustomAttributes = "";
		$this->DniTutor->EditValue = $this->DniTutor->CurrentValue;
		$this->DniTutor->PlaceHolder = ew_RemoveHtml($this->DniTutor->FldCaption());

		// Domicilio
		$this->Domicilio->EditAttrs["class"] = "form-control";
		$this->Domicilio->EditCustomAttributes = "";
		$this->Domicilio->EditValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

		// Tel_Tutor
		$this->Tel_Tutor->EditAttrs["class"] = "form-control";
		$this->Tel_Tutor->EditCustomAttributes = "";
		$this->Tel_Tutor->EditValue = $this->Tel_Tutor->CurrentValue;
		$this->Tel_Tutor->PlaceHolder = ew_RemoveHtml($this->Tel_Tutor->FldCaption());

		// CelTutor
		$this->CelTutor->EditAttrs["class"] = "form-control";
		$this->CelTutor->EditCustomAttributes = "";
		$this->CelTutor->EditValue = $this->CelTutor->CurrentValue;
		$this->CelTutor->PlaceHolder = ew_RemoveHtml($this->CelTutor->FldCaption());

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->EditAttrs["class"] = "form-control";
		$this->Cue_Establecimiento_Alta->EditCustomAttributes = "";
		$this->Cue_Establecimiento_Alta->EditValue = $this->Cue_Establecimiento_Alta->CurrentValue;
		$this->Cue_Establecimiento_Alta->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento_Alta->FldCaption());

		// Escuela_Alta
		$this->Escuela_Alta->EditAttrs["class"] = "form-control";
		$this->Escuela_Alta->EditCustomAttributes = "";
		$this->Escuela_Alta->EditValue = $this->Escuela_Alta->CurrentValue;
		$this->Escuela_Alta->PlaceHolder = ew_RemoveHtml($this->Escuela_Alta->FldCaption());

		// Directivo_Alta
		$this->Directivo_Alta->EditAttrs["class"] = "form-control";
		$this->Directivo_Alta->EditCustomAttributes = "";
		$this->Directivo_Alta->EditValue = $this->Directivo_Alta->CurrentValue;
		$this->Directivo_Alta->PlaceHolder = ew_RemoveHtml($this->Directivo_Alta->FldCaption());

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->EditAttrs["class"] = "form-control";
		$this->Cuil_Directivo_Alta->EditCustomAttributes = "";
		$this->Cuil_Directivo_Alta->EditValue = $this->Cuil_Directivo_Alta->CurrentValue;
		$this->Cuil_Directivo_Alta->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo_Alta->FldCaption());

		// Dpto_Esc_alta
		$this->Dpto_Esc_alta->EditAttrs["class"] = "form-control";
		$this->Dpto_Esc_alta->EditCustomAttributes = "";

		// Localidad_Esc_Alta
		$this->Localidad_Esc_Alta->EditAttrs["class"] = "form-control";
		$this->Localidad_Esc_Alta->EditCustomAttributes = "";

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->EditAttrs["class"] = "form-control";
		$this->Domicilio_Esc_Alta->EditCustomAttributes = "";
		$this->Domicilio_Esc_Alta->EditValue = $this->Domicilio_Esc_Alta->CurrentValue;
		$this->Domicilio_Esc_Alta->PlaceHolder = ew_RemoveHtml($this->Domicilio_Esc_Alta->FldCaption());

		// Rte_Alta
		$this->Rte_Alta->EditAttrs["class"] = "form-control";
		$this->Rte_Alta->EditCustomAttributes = "";
		$this->Rte_Alta->EditValue = $this->Rte_Alta->CurrentValue;
		$this->Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Rte_Alta->FldCaption());

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->EditAttrs["class"] = "form-control";
		$this->Tel_Rte_Alta->EditCustomAttributes = "";
		$this->Tel_Rte_Alta->EditValue = $this->Tel_Rte_Alta->CurrentValue;
		$this->Tel_Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Tel_Rte_Alta->FldCaption());

		// Email_Rte_Alta
		$this->Email_Rte_Alta->EditAttrs["class"] = "form-control";
		$this->Email_Rte_Alta->EditCustomAttributes = "";
		$this->Email_Rte_Alta->EditValue = $this->Email_Rte_Alta->CurrentValue;
		$this->Email_Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Email_Rte_Alta->FldCaption());

		// Serie_Server_Alta
		$this->Serie_Server_Alta->EditAttrs["class"] = "form-control";
		$this->Serie_Server_Alta->EditCustomAttributes = "";
		$this->Serie_Server_Alta->EditValue = $this->Serie_Server_Alta->CurrentValue;
		$this->Serie_Server_Alta->PlaceHolder = ew_RemoveHtml($this->Serie_Server_Alta->FldCaption());

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->EditAttrs["class"] = "form-control";
		$this->Cue_Establecimiento_Baja->EditCustomAttributes = "";
		$this->Cue_Establecimiento_Baja->EditValue = $this->Cue_Establecimiento_Baja->CurrentValue;
		$this->Cue_Establecimiento_Baja->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento_Baja->FldCaption());

		// Escuela_Baja
		$this->Escuela_Baja->EditAttrs["class"] = "form-control";
		$this->Escuela_Baja->EditCustomAttributes = "";
		$this->Escuela_Baja->EditValue = $this->Escuela_Baja->CurrentValue;
		$this->Escuela_Baja->PlaceHolder = ew_RemoveHtml($this->Escuela_Baja->FldCaption());

		// Directivo_Baja
		$this->Directivo_Baja->EditAttrs["class"] = "form-control";
		$this->Directivo_Baja->EditCustomAttributes = "";
		$this->Directivo_Baja->EditValue = $this->Directivo_Baja->CurrentValue;
		$this->Directivo_Baja->PlaceHolder = ew_RemoveHtml($this->Directivo_Baja->FldCaption());

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->EditAttrs["class"] = "form-control";
		$this->Cuil_Directivo_Baja->EditCustomAttributes = "";
		$this->Cuil_Directivo_Baja->EditValue = $this->Cuil_Directivo_Baja->CurrentValue;
		$this->Cuil_Directivo_Baja->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo_Baja->FldCaption());

		// Dpto_Esc_Baja
		$this->Dpto_Esc_Baja->EditAttrs["class"] = "form-control";
		$this->Dpto_Esc_Baja->EditCustomAttributes = "";

		// Localidad_Esc_Baja
		$this->Localidad_Esc_Baja->EditAttrs["class"] = "form-control";
		$this->Localidad_Esc_Baja->EditCustomAttributes = "";

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->EditAttrs["class"] = "form-control";
		$this->Domicilio_Esc_Baja->EditCustomAttributes = "";
		$this->Domicilio_Esc_Baja->EditValue = $this->Domicilio_Esc_Baja->CurrentValue;
		$this->Domicilio_Esc_Baja->PlaceHolder = ew_RemoveHtml($this->Domicilio_Esc_Baja->FldCaption());

		// Rte_Baja
		$this->Rte_Baja->EditAttrs["class"] = "form-control";
		$this->Rte_Baja->EditCustomAttributes = "";
		$this->Rte_Baja->EditValue = $this->Rte_Baja->CurrentValue;
		$this->Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Rte_Baja->FldCaption());

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->EditAttrs["class"] = "form-control";
		$this->Tel_Rte_Baja->EditCustomAttributes = "";
		$this->Tel_Rte_Baja->EditValue = $this->Tel_Rte_Baja->CurrentValue;
		$this->Tel_Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Tel_Rte_Baja->FldCaption());

		// Email_Rte_Baja
		$this->Email_Rte_Baja->EditAttrs["class"] = "form-control";
		$this->Email_Rte_Baja->EditCustomAttributes = "";
		$this->Email_Rte_Baja->EditValue = $this->Email_Rte_Baja->CurrentValue;
		$this->Email_Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Email_Rte_Baja->FldCaption());

		// Serie_Server_Baja
		$this->Serie_Server_Baja->EditAttrs["class"] = "form-control";
		$this->Serie_Server_Baja->EditCustomAttributes = "";
		$this->Serie_Server_Baja->EditValue = $this->Serie_Server_Baja->CurrentValue;
		$this->Serie_Server_Baja->PlaceHolder = ew_RemoveHtml($this->Serie_Server_Baja->FldCaption());

		// Fecha_Pase
		$this->Fecha_Pase->EditAttrs["class"] = "form-control";
		$this->Fecha_Pase->EditCustomAttributes = "";
		$this->Fecha_Pase->EditValue = ew_FormatDateTime($this->Fecha_Pase->CurrentValue, 7);
		$this->Fecha_Pase->PlaceHolder = ew_RemoveHtml($this->Fecha_Pase->FldCaption());

		// Id_Estado_Pase
		$this->Id_Estado_Pase->EditAttrs["class"] = "form-control";
		$this->Id_Estado_Pase->EditCustomAttributes = "";

		// Ruta_Archivo
		$this->Ruta_Archivo->EditAttrs["class"] = "form-control";
		$this->Ruta_Archivo->EditCustomAttributes = "";
		$this->Ruta_Archivo->UploadPath = 'ArchivosPase';
		if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
			$this->Ruta_Archivo->EditValue = $this->Ruta_Archivo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo->EditValue = "";
		}
		if (!ew_Empty($this->Ruta_Archivo->CurrentValue))
			$this->Ruta_Archivo->Upload->FileName = $this->Ruta_Archivo->CurrentValue;

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
					if ($this->Id_Pase->Exportable) $Doc->ExportCaption($this->Id_Pase);
					if ($this->Serie_Equipo->Exportable) $Doc->ExportCaption($this->Serie_Equipo);
					if ($this->Id_Hardware->Exportable) $Doc->ExportCaption($this->Id_Hardware);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Modelo_Net->Exportable) $Doc->ExportCaption($this->Modelo_Net);
					if ($this->Marca_Arranque->Exportable) $Doc->ExportCaption($this->Marca_Arranque);
					if ($this->Nombre_Titular->Exportable) $Doc->ExportCaption($this->Nombre_Titular);
					if ($this->Dni_Titular->Exportable) $Doc->ExportCaption($this->Dni_Titular);
					if ($this->Cuil_Titular->Exportable) $Doc->ExportCaption($this->Cuil_Titular);
					if ($this->Nombre_Tutor->Exportable) $Doc->ExportCaption($this->Nombre_Tutor);
					if ($this->DniTutor->Exportable) $Doc->ExportCaption($this->DniTutor);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Tutor->Exportable) $Doc->ExportCaption($this->Tel_Tutor);
					if ($this->CelTutor->Exportable) $Doc->ExportCaption($this->CelTutor);
					if ($this->Cue_Establecimiento_Alta->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento_Alta);
					if ($this->Escuela_Alta->Exportable) $Doc->ExportCaption($this->Escuela_Alta);
					if ($this->Directivo_Alta->Exportable) $Doc->ExportCaption($this->Directivo_Alta);
					if ($this->Cuil_Directivo_Alta->Exportable) $Doc->ExportCaption($this->Cuil_Directivo_Alta);
					if ($this->Dpto_Esc_alta->Exportable) $Doc->ExportCaption($this->Dpto_Esc_alta);
					if ($this->Localidad_Esc_Alta->Exportable) $Doc->ExportCaption($this->Localidad_Esc_Alta);
					if ($this->Domicilio_Esc_Alta->Exportable) $Doc->ExportCaption($this->Domicilio_Esc_Alta);
					if ($this->Rte_Alta->Exportable) $Doc->ExportCaption($this->Rte_Alta);
					if ($this->Tel_Rte_Alta->Exportable) $Doc->ExportCaption($this->Tel_Rte_Alta);
					if ($this->Email_Rte_Alta->Exportable) $Doc->ExportCaption($this->Email_Rte_Alta);
					if ($this->Serie_Server_Alta->Exportable) $Doc->ExportCaption($this->Serie_Server_Alta);
					if ($this->Cue_Establecimiento_Baja->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento_Baja);
					if ($this->Escuela_Baja->Exportable) $Doc->ExportCaption($this->Escuela_Baja);
					if ($this->Directivo_Baja->Exportable) $Doc->ExportCaption($this->Directivo_Baja);
					if ($this->Cuil_Directivo_Baja->Exportable) $Doc->ExportCaption($this->Cuil_Directivo_Baja);
					if ($this->Dpto_Esc_Baja->Exportable) $Doc->ExportCaption($this->Dpto_Esc_Baja);
					if ($this->Localidad_Esc_Baja->Exportable) $Doc->ExportCaption($this->Localidad_Esc_Baja);
					if ($this->Domicilio_Esc_Baja->Exportable) $Doc->ExportCaption($this->Domicilio_Esc_Baja);
					if ($this->Rte_Baja->Exportable) $Doc->ExportCaption($this->Rte_Baja);
					if ($this->Tel_Rte_Baja->Exportable) $Doc->ExportCaption($this->Tel_Rte_Baja);
					if ($this->Email_Rte_Baja->Exportable) $Doc->ExportCaption($this->Email_Rte_Baja);
					if ($this->Serie_Server_Baja->Exportable) $Doc->ExportCaption($this->Serie_Server_Baja);
					if ($this->Fecha_Pase->Exportable) $Doc->ExportCaption($this->Fecha_Pase);
					if ($this->Id_Estado_Pase->Exportable) $Doc->ExportCaption($this->Id_Estado_Pase);
					if ($this->Ruta_Archivo->Exportable) $Doc->ExportCaption($this->Ruta_Archivo);
				} else {
					if ($this->Serie_Equipo->Exportable) $Doc->ExportCaption($this->Serie_Equipo);
					if ($this->Id_Hardware->Exportable) $Doc->ExportCaption($this->Id_Hardware);
					if ($this->SN->Exportable) $Doc->ExportCaption($this->SN);
					if ($this->Modelo_Net->Exportable) $Doc->ExportCaption($this->Modelo_Net);
					if ($this->Marca_Arranque->Exportable) $Doc->ExportCaption($this->Marca_Arranque);
					if ($this->Nombre_Titular->Exportable) $Doc->ExportCaption($this->Nombre_Titular);
					if ($this->Dni_Titular->Exportable) $Doc->ExportCaption($this->Dni_Titular);
					if ($this->Cuil_Titular->Exportable) $Doc->ExportCaption($this->Cuil_Titular);
					if ($this->Nombre_Tutor->Exportable) $Doc->ExportCaption($this->Nombre_Tutor);
					if ($this->DniTutor->Exportable) $Doc->ExportCaption($this->DniTutor);
					if ($this->Domicilio->Exportable) $Doc->ExportCaption($this->Domicilio);
					if ($this->Tel_Tutor->Exportable) $Doc->ExportCaption($this->Tel_Tutor);
					if ($this->CelTutor->Exportable) $Doc->ExportCaption($this->CelTutor);
					if ($this->Cue_Establecimiento_Alta->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento_Alta);
					if ($this->Escuela_Alta->Exportable) $Doc->ExportCaption($this->Escuela_Alta);
					if ($this->Directivo_Alta->Exportable) $Doc->ExportCaption($this->Directivo_Alta);
					if ($this->Cuil_Directivo_Alta->Exportable) $Doc->ExportCaption($this->Cuil_Directivo_Alta);
					if ($this->Dpto_Esc_alta->Exportable) $Doc->ExportCaption($this->Dpto_Esc_alta);
					if ($this->Localidad_Esc_Alta->Exportable) $Doc->ExportCaption($this->Localidad_Esc_Alta);
					if ($this->Domicilio_Esc_Alta->Exportable) $Doc->ExportCaption($this->Domicilio_Esc_Alta);
					if ($this->Rte_Alta->Exportable) $Doc->ExportCaption($this->Rte_Alta);
					if ($this->Tel_Rte_Alta->Exportable) $Doc->ExportCaption($this->Tel_Rte_Alta);
					if ($this->Email_Rte_Alta->Exportable) $Doc->ExportCaption($this->Email_Rte_Alta);
					if ($this->Serie_Server_Alta->Exportable) $Doc->ExportCaption($this->Serie_Server_Alta);
					if ($this->Cue_Establecimiento_Baja->Exportable) $Doc->ExportCaption($this->Cue_Establecimiento_Baja);
					if ($this->Escuela_Baja->Exportable) $Doc->ExportCaption($this->Escuela_Baja);
					if ($this->Directivo_Baja->Exportable) $Doc->ExportCaption($this->Directivo_Baja);
					if ($this->Cuil_Directivo_Baja->Exportable) $Doc->ExportCaption($this->Cuil_Directivo_Baja);
					if ($this->Dpto_Esc_Baja->Exportable) $Doc->ExportCaption($this->Dpto_Esc_Baja);
					if ($this->Localidad_Esc_Baja->Exportable) $Doc->ExportCaption($this->Localidad_Esc_Baja);
					if ($this->Domicilio_Esc_Baja->Exportable) $Doc->ExportCaption($this->Domicilio_Esc_Baja);
					if ($this->Rte_Baja->Exportable) $Doc->ExportCaption($this->Rte_Baja);
					if ($this->Tel_Rte_Baja->Exportable) $Doc->ExportCaption($this->Tel_Rte_Baja);
					if ($this->Email_Rte_Baja->Exportable) $Doc->ExportCaption($this->Email_Rte_Baja);
					if ($this->Serie_Server_Baja->Exportable) $Doc->ExportCaption($this->Serie_Server_Baja);
					if ($this->Fecha_Pase->Exportable) $Doc->ExportCaption($this->Fecha_Pase);
					if ($this->Id_Estado_Pase->Exportable) $Doc->ExportCaption($this->Id_Estado_Pase);
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
						if ($this->Id_Pase->Exportable) $Doc->ExportField($this->Id_Pase);
						if ($this->Serie_Equipo->Exportable) $Doc->ExportField($this->Serie_Equipo);
						if ($this->Id_Hardware->Exportable) $Doc->ExportField($this->Id_Hardware);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Modelo_Net->Exportable) $Doc->ExportField($this->Modelo_Net);
						if ($this->Marca_Arranque->Exportable) $Doc->ExportField($this->Marca_Arranque);
						if ($this->Nombre_Titular->Exportable) $Doc->ExportField($this->Nombre_Titular);
						if ($this->Dni_Titular->Exportable) $Doc->ExportField($this->Dni_Titular);
						if ($this->Cuil_Titular->Exportable) $Doc->ExportField($this->Cuil_Titular);
						if ($this->Nombre_Tutor->Exportable) $Doc->ExportField($this->Nombre_Tutor);
						if ($this->DniTutor->Exportable) $Doc->ExportField($this->DniTutor);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Tutor->Exportable) $Doc->ExportField($this->Tel_Tutor);
						if ($this->CelTutor->Exportable) $Doc->ExportField($this->CelTutor);
						if ($this->Cue_Establecimiento_Alta->Exportable) $Doc->ExportField($this->Cue_Establecimiento_Alta);
						if ($this->Escuela_Alta->Exportable) $Doc->ExportField($this->Escuela_Alta);
						if ($this->Directivo_Alta->Exportable) $Doc->ExportField($this->Directivo_Alta);
						if ($this->Cuil_Directivo_Alta->Exportable) $Doc->ExportField($this->Cuil_Directivo_Alta);
						if ($this->Dpto_Esc_alta->Exportable) $Doc->ExportField($this->Dpto_Esc_alta);
						if ($this->Localidad_Esc_Alta->Exportable) $Doc->ExportField($this->Localidad_Esc_Alta);
						if ($this->Domicilio_Esc_Alta->Exportable) $Doc->ExportField($this->Domicilio_Esc_Alta);
						if ($this->Rte_Alta->Exportable) $Doc->ExportField($this->Rte_Alta);
						if ($this->Tel_Rte_Alta->Exportable) $Doc->ExportField($this->Tel_Rte_Alta);
						if ($this->Email_Rte_Alta->Exportable) $Doc->ExportField($this->Email_Rte_Alta);
						if ($this->Serie_Server_Alta->Exportable) $Doc->ExportField($this->Serie_Server_Alta);
						if ($this->Cue_Establecimiento_Baja->Exportable) $Doc->ExportField($this->Cue_Establecimiento_Baja);
						if ($this->Escuela_Baja->Exportable) $Doc->ExportField($this->Escuela_Baja);
						if ($this->Directivo_Baja->Exportable) $Doc->ExportField($this->Directivo_Baja);
						if ($this->Cuil_Directivo_Baja->Exportable) $Doc->ExportField($this->Cuil_Directivo_Baja);
						if ($this->Dpto_Esc_Baja->Exportable) $Doc->ExportField($this->Dpto_Esc_Baja);
						if ($this->Localidad_Esc_Baja->Exportable) $Doc->ExportField($this->Localidad_Esc_Baja);
						if ($this->Domicilio_Esc_Baja->Exportable) $Doc->ExportField($this->Domicilio_Esc_Baja);
						if ($this->Rte_Baja->Exportable) $Doc->ExportField($this->Rte_Baja);
						if ($this->Tel_Rte_Baja->Exportable) $Doc->ExportField($this->Tel_Rte_Baja);
						if ($this->Email_Rte_Baja->Exportable) $Doc->ExportField($this->Email_Rte_Baja);
						if ($this->Serie_Server_Baja->Exportable) $Doc->ExportField($this->Serie_Server_Baja);
						if ($this->Fecha_Pase->Exportable) $Doc->ExportField($this->Fecha_Pase);
						if ($this->Id_Estado_Pase->Exportable) $Doc->ExportField($this->Id_Estado_Pase);
						if ($this->Ruta_Archivo->Exportable) $Doc->ExportField($this->Ruta_Archivo);
					} else {
						if ($this->Serie_Equipo->Exportable) $Doc->ExportField($this->Serie_Equipo);
						if ($this->Id_Hardware->Exportable) $Doc->ExportField($this->Id_Hardware);
						if ($this->SN->Exportable) $Doc->ExportField($this->SN);
						if ($this->Modelo_Net->Exportable) $Doc->ExportField($this->Modelo_Net);
						if ($this->Marca_Arranque->Exportable) $Doc->ExportField($this->Marca_Arranque);
						if ($this->Nombre_Titular->Exportable) $Doc->ExportField($this->Nombre_Titular);
						if ($this->Dni_Titular->Exportable) $Doc->ExportField($this->Dni_Titular);
						if ($this->Cuil_Titular->Exportable) $Doc->ExportField($this->Cuil_Titular);
						if ($this->Nombre_Tutor->Exportable) $Doc->ExportField($this->Nombre_Tutor);
						if ($this->DniTutor->Exportable) $Doc->ExportField($this->DniTutor);
						if ($this->Domicilio->Exportable) $Doc->ExportField($this->Domicilio);
						if ($this->Tel_Tutor->Exportable) $Doc->ExportField($this->Tel_Tutor);
						if ($this->CelTutor->Exportable) $Doc->ExportField($this->CelTutor);
						if ($this->Cue_Establecimiento_Alta->Exportable) $Doc->ExportField($this->Cue_Establecimiento_Alta);
						if ($this->Escuela_Alta->Exportable) $Doc->ExportField($this->Escuela_Alta);
						if ($this->Directivo_Alta->Exportable) $Doc->ExportField($this->Directivo_Alta);
						if ($this->Cuil_Directivo_Alta->Exportable) $Doc->ExportField($this->Cuil_Directivo_Alta);
						if ($this->Dpto_Esc_alta->Exportable) $Doc->ExportField($this->Dpto_Esc_alta);
						if ($this->Localidad_Esc_Alta->Exportable) $Doc->ExportField($this->Localidad_Esc_Alta);
						if ($this->Domicilio_Esc_Alta->Exportable) $Doc->ExportField($this->Domicilio_Esc_Alta);
						if ($this->Rte_Alta->Exportable) $Doc->ExportField($this->Rte_Alta);
						if ($this->Tel_Rte_Alta->Exportable) $Doc->ExportField($this->Tel_Rte_Alta);
						if ($this->Email_Rte_Alta->Exportable) $Doc->ExportField($this->Email_Rte_Alta);
						if ($this->Serie_Server_Alta->Exportable) $Doc->ExportField($this->Serie_Server_Alta);
						if ($this->Cue_Establecimiento_Baja->Exportable) $Doc->ExportField($this->Cue_Establecimiento_Baja);
						if ($this->Escuela_Baja->Exportable) $Doc->ExportField($this->Escuela_Baja);
						if ($this->Directivo_Baja->Exportable) $Doc->ExportField($this->Directivo_Baja);
						if ($this->Cuil_Directivo_Baja->Exportable) $Doc->ExportField($this->Cuil_Directivo_Baja);
						if ($this->Dpto_Esc_Baja->Exportable) $Doc->ExportField($this->Dpto_Esc_Baja);
						if ($this->Localidad_Esc_Baja->Exportable) $Doc->ExportField($this->Localidad_Esc_Baja);
						if ($this->Domicilio_Esc_Baja->Exportable) $Doc->ExportField($this->Domicilio_Esc_Baja);
						if ($this->Rte_Baja->Exportable) $Doc->ExportField($this->Rte_Baja);
						if ($this->Tel_Rte_Baja->Exportable) $Doc->ExportField($this->Tel_Rte_Baja);
						if ($this->Email_Rte_Baja->Exportable) $Doc->ExportField($this->Email_Rte_Baja);
						if ($this->Serie_Server_Baja->Exportable) $Doc->ExportField($this->Serie_Server_Baja);
						if ($this->Fecha_Pase->Exportable) $Doc->ExportField($this->Fecha_Pase);
						if ($this->Id_Estado_Pase->Exportable) $Doc->ExportField($this->Id_Estado_Pase);
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
		if (preg_match('/^x(\d)*_Serie_Equipo$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `NroMac` AS FIELD0, `SpecialNumber` AS FIELD1, `Id_Modelo` AS FIELD2 FROM `equipos`";
			$sWhereWrk = "(`NroSerie` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
			$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Id_Hardware->setDbValue($rs->fields[0]);
					$this->SN->setDbValue($rs->fields[1]);
					$this->Modelo_Net->setDbValue($rs->fields[2]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Id_Hardware->AutoFillOriginalValue) ? $this->Id_Hardware->CurrentValue : $this->Id_Hardware->EditValue;
					$ar[] = ($this->SN->AutoFillOriginalValue) ? $this->SN->CurrentValue : $this->SN->EditValue;
					$ar[] = $this->Modelo_Net->CurrentValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Nombre_Titular$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `NroSerie` AS FIELD0, `Dni` AS FIELD1, `Cuil` AS FIELD2 FROM `personas`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_MEMO, $this->DBID) . ")";
			$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Serie_Equipo->setDbValue($rs->fields[0]);
					$this->Dni_Titular->setDbValue($rs->fields[1]);
					$this->Cuil_Titular->setDbValue($rs->fields[2]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Serie_Equipo->AutoFillOriginalValue) ? $this->Serie_Equipo->CurrentValue : $this->Serie_Equipo->EditValue;
					$ar[] = ($this->Dni_Titular->AutoFillOriginalValue) ? $this->Dni_Titular->CurrentValue : $this->Dni_Titular->EditValue;
					$ar[] = ($this->Cuil_Titular->AutoFillOriginalValue) ? $this->Cuil_Titular->CurrentValue : $this->Cuil_Titular->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Nombre_Tutor$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Dni_Tutor` AS FIELD0, `Domicilio` AS FIELD1, `Tel_Contacto` AS FIELD2, `Tel_Contacto` AS FIELD3 FROM `tutores`";
			$sWhereWrk = "(`Apellidos_Nombres` = " . ew_QuotedValue($val, EW_DATATYPE_MEMO, $this->DBID) . ")";
			$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->DniTutor->setDbValue($rs->fields[0]);
					$this->Domicilio->setDbValue($rs->fields[1]);
					$this->Tel_Tutor->setDbValue($rs->fields[2]);
					$this->CelTutor->setDbValue($rs->fields[3]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->DniTutor->AutoFillOriginalValue) ? $this->DniTutor->CurrentValue : $this->DniTutor->EditValue;
					$ar[] = ($this->Domicilio->AutoFillOriginalValue) ? $this->Domicilio->CurrentValue : $this->Domicilio->EditValue;
					$ar[] = ($this->Tel_Tutor->AutoFillOriginalValue) ? $this->Tel_Tutor->CurrentValue : $this->Tel_Tutor->EditValue;
					$ar[] = ($this->CelTutor->AutoFillOriginalValue) ? $this->CelTutor->CurrentValue : $this->CelTutor->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Cue_Establecimiento_Alta$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Nombre_Establecimiento` AS FIELD0, `Nombre_Directivo` AS FIELD1, `Cuil_Directivo` AS FIELD2, `Id_Departamento` AS FIELD3, `Id_Localidad` AS FIELD4, `Domicilio_Escuela` AS FIELD5, `Nombre_Rte` AS FIELD6, `Email_Rte` AS FIELD7, `Nro_Serie_Server_Escolar` AS FIELD8 FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "(`Cue_Establecimiento` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Escuela_Alta->setDbValue($rs->fields[0]);
					$this->Directivo_Alta->setDbValue($rs->fields[1]);
					$this->Cuil_Directivo_Alta->setDbValue($rs->fields[2]);
					$this->Dpto_Esc_alta->setDbValue($rs->fields[3]);
					$this->Localidad_Esc_Alta->setDbValue($rs->fields[4]);
					$this->Domicilio_Esc_Alta->setDbValue($rs->fields[5]);
					$this->Rte_Alta->setDbValue($rs->fields[6]);
					$this->Email_Rte_Alta->setDbValue($rs->fields[7]);
					$this->Serie_Server_Alta->setDbValue($rs->fields[8]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Escuela_Alta->AutoFillOriginalValue) ? $this->Escuela_Alta->CurrentValue : $this->Escuela_Alta->EditValue;
					$ar[] = ($this->Directivo_Alta->AutoFillOriginalValue) ? $this->Directivo_Alta->CurrentValue : $this->Directivo_Alta->EditValue;
					$ar[] = ($this->Cuil_Directivo_Alta->AutoFillOriginalValue) ? $this->Cuil_Directivo_Alta->CurrentValue : $this->Cuil_Directivo_Alta->EditValue;
					$ar[] = $this->Dpto_Esc_alta->CurrentValue;
					$ar[] = $this->Localidad_Esc_Alta->CurrentValue;
					$ar[] = ($this->Domicilio_Esc_Alta->AutoFillOriginalValue) ? $this->Domicilio_Esc_Alta->CurrentValue : $this->Domicilio_Esc_Alta->EditValue;
					$ar[] = ($this->Rte_Alta->AutoFillOriginalValue) ? $this->Rte_Alta->CurrentValue : $this->Rte_Alta->EditValue;
					$ar[] = ($this->Email_Rte_Alta->AutoFillOriginalValue) ? $this->Email_Rte_Alta->CurrentValue : $this->Email_Rte_Alta->EditValue;
					$ar[] = ($this->Serie_Server_Alta->AutoFillOriginalValue) ? $this->Serie_Server_Alta->CurrentValue : $this->Serie_Server_Alta->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_Cue_Establecimiento_Baja$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `Nombre_Establecimiento` AS FIELD0, `Nombre_Directivo` AS FIELD1, `Cuil_Directivo` AS FIELD2, `Id_Departamento` AS FIELD3, `Id_Localidad` AS FIELD4, `Domicilio_Escuela` AS FIELD5, `Nombre_Rte` AS FIELD6, `Tel_Rte` AS FIELD7, `Email_Rte` AS FIELD8, `Nro_Serie_Server_Escolar` AS FIELD9 FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "(`Cue_Establecimiento` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Escuela_Baja->setDbValue($rs->fields[0]);
					$this->Directivo_Baja->setDbValue($rs->fields[1]);
					$this->Cuil_Directivo_Baja->setDbValue($rs->fields[2]);
					$this->Dpto_Esc_Baja->setDbValue($rs->fields[3]);
					$this->Localidad_Esc_Baja->setDbValue($rs->fields[4]);
					$this->Domicilio_Esc_Baja->setDbValue($rs->fields[5]);
					$this->Rte_Baja->setDbValue($rs->fields[6]);
					$this->Tel_Rte_Baja->setDbValue($rs->fields[7]);
					$this->Email_Rte_Baja->setDbValue($rs->fields[8]);
					$this->Serie_Server_Baja->setDbValue($rs->fields[9]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Escuela_Baja->AutoFillOriginalValue) ? $this->Escuela_Baja->CurrentValue : $this->Escuela_Baja->EditValue;
					$ar[] = ($this->Directivo_Baja->AutoFillOriginalValue) ? $this->Directivo_Baja->CurrentValue : $this->Directivo_Baja->EditValue;
					$ar[] = ($this->Cuil_Directivo_Baja->AutoFillOriginalValue) ? $this->Cuil_Directivo_Baja->CurrentValue : $this->Cuil_Directivo_Baja->EditValue;
					$ar[] = $this->Dpto_Esc_Baja->CurrentValue;
					$ar[] = $this->Localidad_Esc_Baja->CurrentValue;
					$ar[] = ($this->Domicilio_Esc_Baja->AutoFillOriginalValue) ? $this->Domicilio_Esc_Baja->CurrentValue : $this->Domicilio_Esc_Baja->EditValue;
					$ar[] = ($this->Rte_Baja->AutoFillOriginalValue) ? $this->Rte_Baja->CurrentValue : $this->Rte_Baja->EditValue;
					$ar[] = ($this->Tel_Rte_Baja->AutoFillOriginalValue) ? $this->Tel_Rte_Baja->CurrentValue : $this->Tel_Rte_Baja->EditValue;
					$ar[] = ($this->Email_Rte_Baja->AutoFillOriginalValue) ? $this->Email_Rte_Baja->CurrentValue : $this->Email_Rte_Baja->EditValue;
					$ar[] = ($this->Serie_Server_Baja->AutoFillOriginalValue) ? $this->Serie_Server_Baja->CurrentValue : $this->Serie_Server_Baja->EditValue;
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
	$Dni=$rsnew["Dni_Titular"];
	$Fecha=ew_CurrentDate();
	$Serie=$rsnew["Serie_Equipo"];
	$Id_Hardware=$rsnew["Id_Hardware"];
	$SN=$rsnew["SN"];
	$Marca_Arranque=$rsnew["Marca_Arranque"];
	$usuario=CurrentUserName();
	$CueAlta=$rsnew["Cue_Establecimiento_Alta"];
	$CueBaja=$rsnew["Cue_Establecimiento_Baja"];
	$consultaEscuela = ew_ExecuteRow("SELECT Cue FROM Dato_Establecimiento");
	$MiCue=$consultaEscuela["Cue"];
	$consulta = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Dni=$Dni");
	$Estado=$consulta["Id_Estado_Prestamo"];
	$EstadoPase=$rsnew["Id_Estado_Pase"];
	if ($CueAlta==$CueBaja){
	echo '<script language="javascript">alert("EL CUE DE LA ESCUELA RESPONSABLE DEL ALTA NO PUEDE SER IGUAL AL DE LA ESCUELA RESPONSABLE DE LA BAJA");</script>';
	return FALSE;
	}else{
	if ($Estado==1){
	echo '<script language="javascript">alert("EL ALUMNO ACTUAL POSEE UN PRESTAMO EN CURSO, VERIFIQUE LOS PRESTAMOS ACTIVOS ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
	if ($CueAlta==$MiCue){
	if ($EstadoPase==3){
	$consultaServer = ew_ExecuteRow("SELECT Nro_Serie FROM Servidor_Escolar Limit 1");
	$Nro_Serie=$consultaServer["Nro_Serie"];
	$consultaRte = ew_ExecuteRow("SELECT Mail, DniRte, Apellido_Nombre FROM Referente_Tecnico Limit 1");
	$mail=$consultaRte["Mail"];
	$DniRte=$consultaRte["DniRte"];
	$Apellido_Nombre=$consultaRte["Apellido_Nombre"];
	$Tipo_Paquete=1;
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando Paquete de Provisión', '$Fecha' ,'$Serie')");
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$CargaPaquete = ew_Execute("INSERT INTO Paquetes_Provision (Fecha_Actualizacion, Usuario, SN, Id_Hardware, Marca_Arranque, Id_Tipo_Extraccion, Email_Solicitante, Id_Estado_Paquete, Id_Motivo, Serie_Netbook, Dni, Apellido_Nombre_Solicitante, Id_Tipo_Paquete, Serie_Server) VALUES ('$Fecha' ,'$usuario','$SN','$Id_Hardware', '$Marca_Arranque',1,'$mail',1,2,'$Serie',$DniRte, '$Apellido_Nombre', $Tipo_Paquete, '$Nro_Serie')");
	return TRUE;
	}else{
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=2, Id_Sit_Estado=8, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra pendiente de transferencia por pase', '$Fecha' ,'$Serie')");
	return TRUE;
	}
	}else{

	//$Observacion=$rsnew["DetalleDenuncia"];
	// NOTE: Modify your SQL here, replace the table name, field name and field values

	if ($EstadoPase==3){
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=1, Id_Sit_Estado=9, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=9, Id_Curso=9, Id_Division=0, Id_Turno_0, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se fue por pase a otra escuela', '$Fecha' ,'$Serie')");
	return TRUE;
	}else
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=2, Id_Sit_Estado=8, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=10, Id_Curso=9, Id_Division=0, Id_Turno_0, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra pendiente de transferencia por pase', '$Fecha' ,'$Serie')");
	return TRUE;
	}
	}
	}
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {
	$Dni=$rsnew["Dni_Titular"];
	$Fecha=ew_CurrentDate();
	$Serie=$rsnew["Serie_Equipo"];
	$Id_Hardware=$rsnew["Id_Hardware"];
	$SN=$rsnew["SN"];
	$Marca_Arranque=$rsnew["Marca_Arranque"];
	$usuario=CurrentUserName();
	$CueAlta=$rsnew["Cue_Establecimiento_Alta"];
	$CueBaja=$rsnew["Cue_Establecimiento_Baja"];
	$consultaEscuela = ew_ExecuteRow("SELECT Cue FROM Dato_Establecimiento");
	$MiCue=$consultaEscuela["Cue"];
	$consulta = ew_ExecuteRow("SELECT * FROM Prestamo_Equipo WHERE Dni=$Dni");
	$Estado=$consulta["Id_Estado_Prestamo"];
	$EstadoPase=$rsnew["Id_Estado_Pase"];
	if ($CueAlta==$CueBaja){
	echo '<script language="javascript">alert("EL CUE DE LA ESCUELA RESPONSABLE DEL ALTA NO PUEDE SER IGUAL AL DE LA ESCUELA RESPONSABLE DE LA BAJA");</script>';
	return FALSE;
	}else{
	if ($Estado==1){
	echo '<script language="javascript">alert("EL ALUMNO ACTUAL POSEE UN PRESTAMO EN CURSO, VERIFIQUE LOS PRESTAMOS ACTIVOS ANTES DE CONTINUAR");</script>';
	return FALSE;
	}else{
	if ($CueAlta==$MiCue){
	if ($EstadoPase==3){
	$consultaServer = ew_ExecuteRow("SELECT Nro_Serie FROM Servidor_Escolar Limit 1");
	$Nro_Serie=$consultaServer["Nro_Serie"];
	$consultaRte = ew_ExecuteRow("SELECT Mail, DniRte, Apellido_Nombre FROM Referente_Tecnico Limit 1");
	$mail=$consultaRte["Mail"];
	$DniRte=$consultaRte["DniRte"];
	$Apellido_Nombre=$consultaRte["Apellido_Nombre"];
	$Tipo_Paquete=1;
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra Esperando Paquete de Provisión', '$Fecha' ,'$Serie')");
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=1, Id_Sit_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$CargaPaquete = ew_Execute("INSERT INTO Paquetes_Provision (Fecha_Actualizacion, Usuario, SN, Id_Hardware, Marca_Arranque, Id_Tipo_Extraccion, Email_Solicitante, Id_Estado_Paquete, Id_Motivo, Serie_Netbook, Dni, Apellido_Nombre_Solicitante, Id_Tipo_Paquete, Serie_Server) VALUES ('$Fecha' ,'$usuario','$SN','$Id_Hardware', '$Marca_Arranque',1,'$mail',1,2,'$Serie',$DniRte, '$Apellido_Nombre', $Tipo_Paquete, '$Nro_Serie')");
	return TRUE;
	}else{
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=2, Id_Sit_Estado=8, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=1, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra pendiente de transferencia por pase', '$Fecha' ,'$Serie')");
	return TRUE;
	}
	}else{

	//$Observacion=$rsnew["DetalleDenuncia"];
	// NOTE: Modify your SQL here, replace the table name, field name and field values

	if ($EstadoPase==3){
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=2, Id_Estado=1, Id_Sit_Estado=9, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=9, Id_Curso=9, Id_Division=11, Id_Turno=4, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se fue por pase a otra escuela', '$Fecha' ,'$Serie')");
	return TRUE;
	}else
	$MyResult2 = ew_Execute("UPDATE Equipos SET Id_Ubicacion=1, Id_Estado=2, Id_Sit_Estado=8, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE NroSerie='$Serie'");
	$MyResult = ew_Execute("UPDATE Personas SET Id_Estado=10, Id_Curso=9, Id_Division=11, Id_Turno=4, Fecha_Actualizacion='$Fecha',Usuario='$usuario' WHERE Dni=$Dni");
	$Consulta2 = ew_Execute("INSERT INTO Observacion_Equipo (Detalle, Fecha_Actualizacion, NroSerie) VALUES ('El equipo se encuentra pendiente de transferencia por pase', '$Fecha' ,'$Serie')");
	return TRUE;
	}
	}
	}
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
