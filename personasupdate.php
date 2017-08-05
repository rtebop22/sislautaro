<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "estado_actual_legajo_personagridcls.php" ?>
<?php include_once "materias_adeudadasgridcls.php" ?>
<?php include_once "observacion_personagridcls.php" ?>
<?php include_once "equiposgridcls.php" ?>
<?php include_once "tutoresgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$personas_update = NULL; // Initialize page object first

class cpersonas_update extends cpersonas {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'personas';

	// Page object name
	var $PageObjName = 'personas_update';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = FALSE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = TRUE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (personas)
		if (!isset($GLOBALS["personas"]) || get_class($GLOBALS["personas"]) == "cpersonas") {
			$GLOBALS["personas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personas"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personas', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("personaslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Foto->SetVisibility();
		$this->Apellidos_Nombres->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Edad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Tel_Contacto->SetVisibility();
		$this->Fecha_Nac->SetVisibility();
		$this->Lugar_Nacimiento->SetVisibility();
		$this->Cod_Postal->SetVisibility();
		$this->Repitente->SetVisibility();
		$this->Id_Estado_Civil->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Id_Sexo->SetVisibility();
		$this->Id_Cargo->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Curso->SetVisibility();
		$this->Id_Division->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'estado_actual_legajo_persona'
			if (@$_POST["grid"] == "festado_actual_legajo_personagrid") {
				if (!isset($GLOBALS["estado_actual_legajo_persona_grid"])) $GLOBALS["estado_actual_legajo_persona_grid"] = new cestado_actual_legajo_persona_grid;
				$GLOBALS["estado_actual_legajo_persona_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'materias_adeudadas'
			if (@$_POST["grid"] == "fmaterias_adeudadasgrid") {
				if (!isset($GLOBALS["materias_adeudadas_grid"])) $GLOBALS["materias_adeudadas_grid"] = new cmaterias_adeudadas_grid;
				$GLOBALS["materias_adeudadas_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'observacion_persona'
			if (@$_POST["grid"] == "fobservacion_personagrid") {
				if (!isset($GLOBALS["observacion_persona_grid"])) $GLOBALS["observacion_persona_grid"] = new cobservacion_persona_grid;
				$GLOBALS["observacion_persona_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'equipos'
			if (@$_POST["grid"] == "fequiposgrid") {
				if (!isset($GLOBALS["equipos_grid"])) $GLOBALS["equipos_grid"] = new cequipos_grid;
				$GLOBALS["equipos_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'tutores'
			if (@$_POST["grid"] == "ftutoresgrid") {
				if (!isset($GLOBALS["tutores_grid"])) $GLOBALS["tutores_grid"] = new ctutores_grid;
				$GLOBALS["tutores_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $personas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($personas);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("personaslist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Apellidos_Nombres->setDbValue($this->Recordset->fields('Apellidos_Nombres'));
					$this->Dni->setDbValue($this->Recordset->fields('Dni'));
					$this->Cuil->setDbValue($this->Recordset->fields('Cuil'));
					$this->Edad->setDbValue($this->Recordset->fields('Edad'));
					$this->Domicilio->setDbValue($this->Recordset->fields('Domicilio'));
					$this->Tel_Contacto->setDbValue($this->Recordset->fields('Tel_Contacto'));
					$this->Fecha_Nac->setDbValue($this->Recordset->fields('Fecha_Nac'));
					$this->Lugar_Nacimiento->setDbValue($this->Recordset->fields('Lugar_Nacimiento'));
					$this->Cod_Postal->setDbValue($this->Recordset->fields('Cod_Postal'));
					$this->Repitente->setDbValue($this->Recordset->fields('Repitente'));
					$this->Id_Estado_Civil->setDbValue($this->Recordset->fields('Id_Estado_Civil'));
					$this->Id_Provincia->setDbValue($this->Recordset->fields('Id_Provincia'));
					$this->Id_Departamento->setDbValue($this->Recordset->fields('Id_Departamento'));
					$this->Id_Localidad->setDbValue($this->Recordset->fields('Id_Localidad'));
					$this->Id_Sexo->setDbValue($this->Recordset->fields('Id_Sexo'));
					$this->Id_Cargo->setDbValue($this->Recordset->fields('Id_Cargo'));
					$this->Id_Estado->setDbValue($this->Recordset->fields('Id_Estado'));
					$this->Id_Curso->setDbValue($this->Recordset->fields('Id_Curso'));
					$this->Id_Division->setDbValue($this->Recordset->fields('Id_Division'));
					$this->Id_Turno->setDbValue($this->Recordset->fields('Id_Turno'));
					$this->Dni_Tutor->setDbValue($this->Recordset->fields('Dni_Tutor'));
					$this->NroSerie->setDbValue($this->Recordset->fields('NroSerie'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
				} else {
					if (!ew_CompareValue($this->Apellidos_Nombres->DbValue, $this->Recordset->fields('Apellidos_Nombres')))
						$this->Apellidos_Nombres->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni->DbValue, $this->Recordset->fields('Dni')))
						$this->Dni->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cuil->DbValue, $this->Recordset->fields('Cuil')))
						$this->Cuil->CurrentValue = NULL;
					if (!ew_CompareValue($this->Edad->DbValue, $this->Recordset->fields('Edad')))
						$this->Edad->CurrentValue = NULL;
					if (!ew_CompareValue($this->Domicilio->DbValue, $this->Recordset->fields('Domicilio')))
						$this->Domicilio->CurrentValue = NULL;
					if (!ew_CompareValue($this->Tel_Contacto->DbValue, $this->Recordset->fields('Tel_Contacto')))
						$this->Tel_Contacto->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Nac->DbValue, $this->Recordset->fields('Fecha_Nac')))
						$this->Fecha_Nac->CurrentValue = NULL;
					if (!ew_CompareValue($this->Lugar_Nacimiento->DbValue, $this->Recordset->fields('Lugar_Nacimiento')))
						$this->Lugar_Nacimiento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cod_Postal->DbValue, $this->Recordset->fields('Cod_Postal')))
						$this->Cod_Postal->CurrentValue = NULL;
					if (!ew_CompareValue($this->Repitente->DbValue, $this->Recordset->fields('Repitente')))
						$this->Repitente->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado_Civil->DbValue, $this->Recordset->fields('Id_Estado_Civil')))
						$this->Id_Estado_Civil->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Provincia->DbValue, $this->Recordset->fields('Id_Provincia')))
						$this->Id_Provincia->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Departamento->DbValue, $this->Recordset->fields('Id_Departamento')))
						$this->Id_Departamento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Localidad->DbValue, $this->Recordset->fields('Id_Localidad')))
						$this->Id_Localidad->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Sexo->DbValue, $this->Recordset->fields('Id_Sexo')))
						$this->Id_Sexo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Cargo->DbValue, $this->Recordset->fields('Id_Cargo')))
						$this->Id_Cargo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado->DbValue, $this->Recordset->fields('Id_Estado')))
						$this->Id_Estado->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Curso->DbValue, $this->Recordset->fields('Id_Curso')))
						$this->Id_Curso->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Division->DbValue, $this->Recordset->fields('Id_Division')))
						$this->Id_Division->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Turno->DbValue, $this->Recordset->fields('Id_Turno')))
						$this->Id_Turno->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni_Tutor->DbValue, $this->Recordset->fields('Dni_Tutor')))
						$this->Dni_Tutor->CurrentValue = NULL;
					if (!ew_CompareValue($this->NroSerie->DbValue, $this->Recordset->fields('NroSerie')))
						$this->NroSerie->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario->DbValue, $this->Recordset->fields('Usuario')))
						$this->Usuario->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Actualizacion->DbValue, $this->Recordset->fields('Fecha_Actualizacion')))
						$this->Fecha_Actualizacion->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Dni->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->Foto->Upload->Index = $objForm->Index;
		$this->Foto->Upload->UploadFile();
		$this->Foto->CurrentValue = $this->Foto->Upload->FileName;
		$this->Foto->MultiUpdate = $objForm->GetValue("u_Foto");
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Apellidos_Nombres->FldIsDetailKey) {
			$this->Apellidos_Nombres->setFormValue($objForm->GetValue("x_Apellidos_Nombres"));
		}
		$this->Apellidos_Nombres->MultiUpdate = $objForm->GetValue("u_Apellidos_Nombres");
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->MultiUpdate = $objForm->GetValue("u_Dni");
		if (!$this->Cuil->FldIsDetailKey) {
			$this->Cuil->setFormValue($objForm->GetValue("x_Cuil"));
		}
		$this->Cuil->MultiUpdate = $objForm->GetValue("u_Cuil");
		if (!$this->Edad->FldIsDetailKey) {
			$this->Edad->setFormValue($objForm->GetValue("x_Edad"));
		}
		$this->Edad->MultiUpdate = $objForm->GetValue("u_Edad");
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		$this->Domicilio->MultiUpdate = $objForm->GetValue("u_Domicilio");
		if (!$this->Tel_Contacto->FldIsDetailKey) {
			$this->Tel_Contacto->setFormValue($objForm->GetValue("x_Tel_Contacto"));
		}
		$this->Tel_Contacto->MultiUpdate = $objForm->GetValue("u_Tel_Contacto");
		if (!$this->Fecha_Nac->FldIsDetailKey) {
			$this->Fecha_Nac->setFormValue($objForm->GetValue("x_Fecha_Nac"));
		}
		$this->Fecha_Nac->MultiUpdate = $objForm->GetValue("u_Fecha_Nac");
		if (!$this->Lugar_Nacimiento->FldIsDetailKey) {
			$this->Lugar_Nacimiento->setFormValue($objForm->GetValue("x_Lugar_Nacimiento"));
		}
		$this->Lugar_Nacimiento->MultiUpdate = $objForm->GetValue("u_Lugar_Nacimiento");
		if (!$this->Cod_Postal->FldIsDetailKey) {
			$this->Cod_Postal->setFormValue($objForm->GetValue("x_Cod_Postal"));
		}
		$this->Cod_Postal->MultiUpdate = $objForm->GetValue("u_Cod_Postal");
		if (!$this->Repitente->FldIsDetailKey) {
			$this->Repitente->setFormValue($objForm->GetValue("x_Repitente"));
		}
		$this->Repitente->MultiUpdate = $objForm->GetValue("u_Repitente");
		if (!$this->Id_Estado_Civil->FldIsDetailKey) {
			$this->Id_Estado_Civil->setFormValue($objForm->GetValue("x_Id_Estado_Civil"));
		}
		$this->Id_Estado_Civil->MultiUpdate = $objForm->GetValue("u_Id_Estado_Civil");
		if (!$this->Id_Provincia->FldIsDetailKey) {
			$this->Id_Provincia->setFormValue($objForm->GetValue("x_Id_Provincia"));
		}
		$this->Id_Provincia->MultiUpdate = $objForm->GetValue("u_Id_Provincia");
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->MultiUpdate = $objForm->GetValue("u_Id_Departamento");
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->MultiUpdate = $objForm->GetValue("u_Id_Localidad");
		if (!$this->Id_Sexo->FldIsDetailKey) {
			$this->Id_Sexo->setFormValue($objForm->GetValue("x_Id_Sexo"));
		}
		$this->Id_Sexo->MultiUpdate = $objForm->GetValue("u_Id_Sexo");
		if (!$this->Id_Cargo->FldIsDetailKey) {
			$this->Id_Cargo->setFormValue($objForm->GetValue("x_Id_Cargo"));
		}
		$this->Id_Cargo->MultiUpdate = $objForm->GetValue("u_Id_Cargo");
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		$this->Id_Estado->MultiUpdate = $objForm->GetValue("u_Id_Estado");
		if (!$this->Id_Curso->FldIsDetailKey) {
			$this->Id_Curso->setFormValue($objForm->GetValue("x_Id_Curso"));
		}
		$this->Id_Curso->MultiUpdate = $objForm->GetValue("u_Id_Curso");
		if (!$this->Id_Division->FldIsDetailKey) {
			$this->Id_Division->setFormValue($objForm->GetValue("x_Id_Division"));
		}
		$this->Id_Division->MultiUpdate = $objForm->GetValue("u_Id_Division");
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
		}
		$this->Id_Turno->MultiUpdate = $objForm->GetValue("u_Id_Turno");
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		$this->Dni_Tutor->MultiUpdate = $objForm->GetValue("u_Dni_Tutor");
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->MultiUpdate = $objForm->GetValue("u_NroSerie");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Apellidos_Nombres->CurrentValue = $this->Apellidos_Nombres->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Cuil->CurrentValue = $this->Cuil->FormValue;
		$this->Edad->CurrentValue = $this->Edad->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Tel_Contacto->CurrentValue = $this->Tel_Contacto->FormValue;
		$this->Fecha_Nac->CurrentValue = $this->Fecha_Nac->FormValue;
		$this->Lugar_Nacimiento->CurrentValue = $this->Lugar_Nacimiento->FormValue;
		$this->Cod_Postal->CurrentValue = $this->Cod_Postal->FormValue;
		$this->Repitente->CurrentValue = $this->Repitente->FormValue;
		$this->Id_Estado_Civil->CurrentValue = $this->Id_Estado_Civil->FormValue;
		$this->Id_Provincia->CurrentValue = $this->Id_Provincia->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Id_Sexo->CurrentValue = $this->Id_Sexo->FormValue;
		$this->Id_Cargo->CurrentValue = $this->Id_Cargo->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Id_Curso->CurrentValue = $this->Id_Curso->FormValue;
		$this->Id_Division->CurrentValue = $this->Id_Division->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
		$this->Foto->CurrentValue = $this->Foto->Upload->DbValue;
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
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Foto->Upload->DbValue = $row['Foto'];
		$this->Apellidos_Nombres->DbValue = $row['Apellidos_Nombres'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->Edad->DbValue = $row['Edad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Tel_Contacto->DbValue = $row['Tel_Contacto'];
		$this->Fecha_Nac->DbValue = $row['Fecha_Nac'];
		$this->Lugar_Nacimiento->DbValue = $row['Lugar_Nacimiento'];
		$this->Cod_Postal->DbValue = $row['Cod_Postal'];
		$this->Repitente->DbValue = $row['Repitente'];
		$this->Id_Estado_Civil->DbValue = $row['Id_Estado_Civil'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Id_Sexo->DbValue = $row['Id_Sexo'];
		$this->Id_Cargo->DbValue = $row['Id_Cargo'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Curso->DbValue = $row['Id_Curso'];
		$this->Id_Division->DbValue = $row['Id_Division'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Foto
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
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Foto
		$this->Foto->UploadPath = 'FotosPersonas';
		if (!ew_Empty($this->Foto->Upload->DbValue)) {
			$this->Foto->ImageWidth = 100;
			$this->Foto->ImageHeight = 100;
			$this->Foto->ImageAlt = $this->Foto->FldAlt();
			$this->Foto->ViewValue = $this->Foto->Upload->DbValue;
		} else {
			$this->Foto->ViewValue = "";
		}
		$this->Foto->ViewCustomAttributes = "";

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

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Foto
			$this->Foto->LinkCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->HrefValue = ew_GetFileUploadUrl($this->Foto, $this->Foto->Upload->DbValue); // Add prefix/suffix
				$this->Foto->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
			} else {
				$this->Foto->HrefValue = "";
			}
			$this->Foto->HrefValue2 = $this->Foto->UploadPath . $this->Foto->Upload->DbValue;
			$this->Foto->TooltipValue = "";
			if ($this->Foto->UseColorbox) {
				if (ew_Empty($this->Foto->TooltipValue))
					$this->Foto->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Foto->LinkAttrs["data-rel"] = "personas_x_Foto";
				ew_AppendClass($this->Foto->LinkAttrs["class"], "ewLightbox");
			}

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

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Foto
			$this->Foto->EditAttrs["class"] = "form-control";
			$this->Foto->EditCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->ImageWidth = 100;
				$this->Foto->ImageHeight = 100;
				$this->Foto->ImageAlt = $this->Foto->FldAlt();
				$this->Foto->EditValue = $this->Foto->Upload->DbValue;
			} else {
				$this->Foto->EditValue = "";
			}
			if (!ew_Empty($this->Foto->CurrentValue))
				$this->Foto->Upload->FileName = $this->Foto->CurrentValue;

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = $this->Dni->CurrentValue;
			$this->Dni->ViewCustomAttributes = "";

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Edad
			$this->Edad->EditAttrs["class"] = "form-control";
			$this->Edad->EditCustomAttributes = "";
			$this->Edad->EditValue = ew_HtmlEncode($this->Edad->CurrentValue);
			$this->Edad->PlaceHolder = ew_RemoveHtml($this->Edad->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Tel_Contacto
			$this->Tel_Contacto->EditAttrs["class"] = "form-control";
			$this->Tel_Contacto->EditCustomAttributes = "";
			$this->Tel_Contacto->EditValue = ew_HtmlEncode($this->Tel_Contacto->CurrentValue);
			$this->Tel_Contacto->PlaceHolder = ew_RemoveHtml($this->Tel_Contacto->FldCaption());

			// Fecha_Nac
			$this->Fecha_Nac->EditAttrs["class"] = "form-control";
			$this->Fecha_Nac->EditCustomAttributes = "";
			$this->Fecha_Nac->EditValue = ew_HtmlEncode($this->Fecha_Nac->CurrentValue);
			$this->Fecha_Nac->PlaceHolder = ew_RemoveHtml($this->Fecha_Nac->FldCaption());

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->EditAttrs["class"] = "form-control";
			$this->Lugar_Nacimiento->EditCustomAttributes = "";
			$this->Lugar_Nacimiento->EditValue = ew_HtmlEncode($this->Lugar_Nacimiento->CurrentValue);
			$this->Lugar_Nacimiento->PlaceHolder = ew_RemoveHtml($this->Lugar_Nacimiento->FldCaption());

			// Cod_Postal
			$this->Cod_Postal->EditAttrs["class"] = "form-control";
			$this->Cod_Postal->EditCustomAttributes = "";
			$this->Cod_Postal->EditValue = ew_HtmlEncode($this->Cod_Postal->CurrentValue);
			$this->Cod_Postal->PlaceHolder = ew_RemoveHtml($this->Cod_Postal->FldCaption());

			// Repitente
			$this->Repitente->EditCustomAttributes = "";
			$this->Repitente->EditValue = $this->Repitente->Options(FALSE);

			// Id_Estado_Civil
			$this->Id_Estado_Civil->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Civil->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Civil->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Civil`" . ew_SearchString("=", $this->Id_Estado_Civil->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Civil`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_civil`";
			$sWhereWrk = "";
			$this->Id_Estado_Civil->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Civil->EditValue = $arwrk;

			// Id_Provincia
			$this->Id_Provincia->EditAttrs["class"] = "form-control";
			$this->Id_Provincia->EditCustomAttributes = "";
			if (trim(strval($this->Id_Provincia->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Provincia->EditValue = $arwrk;

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Id_Sexo
			$this->Id_Sexo->EditAttrs["class"] = "form-control";
			$this->Id_Sexo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sexo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sexo`" . ew_SearchString("=", $this->Id_Sexo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sexo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sexo_personas`";
			$sWhereWrk = "";
			$this->Id_Sexo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sexo->EditValue = $arwrk;

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Curso
			$this->Id_Curso->EditAttrs["class"] = "form-control";
			$this->Id_Curso->EditCustomAttributes = "";
			if (trim(strval($this->Id_Curso->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Curso->EditValue = $arwrk;

			// Id_Division
			$this->Id_Division->EditAttrs["class"] = "form-control";
			$this->Id_Division->EditCustomAttributes = "";
			if (trim(strval($this->Id_Division->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Division->EditValue = $arwrk;

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni_Tutor->EditValue = $this->Dni_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
				}
			} else {
				$this->Dni_Tutor->EditValue = NULL;
			}
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Foto

			$this->Foto->LinkCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->HrefValue = ew_GetFileUploadUrl($this->Foto, $this->Foto->Upload->DbValue); // Add prefix/suffix
				$this->Foto->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
			} else {
				$this->Foto->HrefValue = "";
			}
			$this->Foto->HrefValue2 = $this->Foto->UploadPath . $this->Foto->Upload->DbValue;

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// Edad
			$this->Edad->LinkCustomAttributes = "";
			$this->Edad->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Tel_Contacto
			$this->Tel_Contacto->LinkCustomAttributes = "";
			$this->Tel_Contacto->HrefValue = "";

			// Fecha_Nac
			$this->Fecha_Nac->LinkCustomAttributes = "";
			$this->Fecha_Nac->HrefValue = "";

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->LinkCustomAttributes = "";
			$this->Lugar_Nacimiento->HrefValue = "";

			// Cod_Postal
			$this->Cod_Postal->LinkCustomAttributes = "";
			$this->Cod_Postal->HrefValue = "";

			// Repitente
			$this->Repitente->LinkCustomAttributes = "";
			$this->Repitente->HrefValue = "";

			// Id_Estado_Civil
			$this->Id_Estado_Civil->LinkCustomAttributes = "";
			$this->Id_Estado_Civil->HrefValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Id_Sexo
			$this->Id_Sexo->LinkCustomAttributes = "";
			$this->Id_Sexo->HrefValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->Foto->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Apellidos_Nombres->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cuil->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Edad->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Domicilio->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Tel_Contacto->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Nac->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Lugar_Nacimiento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cod_Postal->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Repitente->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado_Civil->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Provincia->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Departamento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Localidad->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Sexo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Cargo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Curso->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Division->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Turno->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni_Tutor->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->NroSerie->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Apellidos_Nombres->MultiUpdate <> "" && !$this->Apellidos_Nombres->FldIsDetailKey && !is_null($this->Apellidos_Nombres->FormValue) && $this->Apellidos_Nombres->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellidos_Nombres->FldCaption(), $this->Apellidos_Nombres->ReqErrMsg));
		}
		if ($this->Dni->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
			}
		}
		if ($this->Fecha_Nac->MultiUpdate <> "") {
			if (!ew_CheckEuroDate($this->Fecha_Nac->FormValue)) {
				ew_AddMessage($gsFormError, $this->Fecha_Nac->FldErrMsg());
			}
		}
		if ($this->Cod_Postal->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cod_Postal->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cod_Postal->FldErrMsg());
			}
		}
		if ($this->Id_Estado_Civil->MultiUpdate <> "" && !$this->Id_Estado_Civil->FldIsDetailKey && !is_null($this->Id_Estado_Civil->FormValue) && $this->Id_Estado_Civil->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Civil->FldCaption(), $this->Id_Estado_Civil->ReqErrMsg));
		}
		if ($this->Id_Provincia->MultiUpdate <> "" && !$this->Id_Provincia->FldIsDetailKey && !is_null($this->Id_Provincia->FormValue) && $this->Id_Provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Provincia->FldCaption(), $this->Id_Provincia->ReqErrMsg));
		}
		if ($this->Id_Departamento->MultiUpdate <> "" && !$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if ($this->Id_Localidad->MultiUpdate <> "" && !$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}
		if ($this->Id_Sexo->MultiUpdate <> "" && !$this->Id_Sexo->FldIsDetailKey && !is_null($this->Id_Sexo->FormValue) && $this->Id_Sexo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Sexo->FldCaption(), $this->Id_Sexo->ReqErrMsg));
		}
		if ($this->Id_Cargo->MultiUpdate <> "" && !$this->Id_Cargo->FldIsDetailKey && !is_null($this->Id_Cargo->FormValue) && $this->Id_Cargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Cargo->FldCaption(), $this->Id_Cargo->ReqErrMsg));
		}
		if ($this->Id_Estado->MultiUpdate <> "" && !$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
		}
		if ($this->Id_Curso->MultiUpdate <> "" && !$this->Id_Curso->FldIsDetailKey && !is_null($this->Id_Curso->FormValue) && $this->Id_Curso->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Curso->FldCaption(), $this->Id_Curso->ReqErrMsg));
		}
		if ($this->Id_Division->MultiUpdate <> "" && !$this->Id_Division->FldIsDetailKey && !is_null($this->Id_Division->FormValue) && $this->Id_Division->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Division->FldCaption(), $this->Id_Division->ReqErrMsg));
		}
		if ($this->Id_Turno->MultiUpdate <> "" && !$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if ($this->Dni_Tutor->MultiUpdate <> "" && !$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->Foto->OldUploadPath = 'FotosPersonas';
			$this->Foto->UploadPath = $this->Foto->OldUploadPath;
			$rsnew = array();

			// Foto
			if ($this->Foto->Visible && !$this->Foto->ReadOnly && strval($this->Foto->MultiUpdate) == "1" && !$this->Foto->Upload->KeepFile) {
				$this->Foto->Upload->DbValue = $rsold['Foto']; // Get original value
				if ($this->Foto->Upload->FileName == "") {
					$rsnew['Foto'] = NULL;
				} else {
					$rsnew['Foto'] = $this->Foto->Upload->FileName;
				}
				$this->Foto->ImageWidth = 200; // Resize width
				$this->Foto->ImageHeight = 200; // Resize height
			}

			// Apellidos_Nombres
			$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, $this->Apellidos_Nombres->ReadOnly || $this->Apellidos_Nombres->MultiUpdate <> "1");

			// Dni
			// Cuil

			$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, $this->Cuil->ReadOnly || $this->Cuil->MultiUpdate <> "1");

			// Edad
			$this->Edad->SetDbValueDef($rsnew, $this->Edad->CurrentValue, NULL, $this->Edad->ReadOnly || $this->Edad->MultiUpdate <> "1");

			// Domicilio
			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly || $this->Domicilio->MultiUpdate <> "1");

			// Tel_Contacto
			$this->Tel_Contacto->SetDbValueDef($rsnew, $this->Tel_Contacto->CurrentValue, NULL, $this->Tel_Contacto->ReadOnly || $this->Tel_Contacto->MultiUpdate <> "1");

			// Fecha_Nac
			$this->Fecha_Nac->SetDbValueDef($rsnew, $this->Fecha_Nac->CurrentValue, NULL, $this->Fecha_Nac->ReadOnly || $this->Fecha_Nac->MultiUpdate <> "1");

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->SetDbValueDef($rsnew, $this->Lugar_Nacimiento->CurrentValue, NULL, $this->Lugar_Nacimiento->ReadOnly || $this->Lugar_Nacimiento->MultiUpdate <> "1");

			// Cod_Postal
			$this->Cod_Postal->SetDbValueDef($rsnew, $this->Cod_Postal->CurrentValue, NULL, $this->Cod_Postal->ReadOnly || $this->Cod_Postal->MultiUpdate <> "1");

			// Repitente
			$this->Repitente->SetDbValueDef($rsnew, $this->Repitente->CurrentValue, NULL, $this->Repitente->ReadOnly || $this->Repitente->MultiUpdate <> "1");

			// Id_Estado_Civil
			$this->Id_Estado_Civil->SetDbValueDef($rsnew, $this->Id_Estado_Civil->CurrentValue, 0, $this->Id_Estado_Civil->ReadOnly || $this->Id_Estado_Civil->MultiUpdate <> "1");

			// Id_Provincia
			$this->Id_Provincia->SetDbValueDef($rsnew, $this->Id_Provincia->CurrentValue, 0, $this->Id_Provincia->ReadOnly || $this->Id_Provincia->MultiUpdate <> "1");

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly || $this->Id_Departamento->MultiUpdate <> "1");

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly || $this->Id_Localidad->MultiUpdate <> "1");

			// Id_Sexo
			$this->Id_Sexo->SetDbValueDef($rsnew, $this->Id_Sexo->CurrentValue, 0, $this->Id_Sexo->ReadOnly || $this->Id_Sexo->MultiUpdate <> "1");

			// Id_Cargo
			$this->Id_Cargo->SetDbValueDef($rsnew, $this->Id_Cargo->CurrentValue, 0, $this->Id_Cargo->ReadOnly || $this->Id_Cargo->MultiUpdate <> "1");

			// Id_Estado
			$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, $this->Id_Estado->ReadOnly || $this->Id_Estado->MultiUpdate <> "1");

			// Id_Curso
			$this->Id_Curso->SetDbValueDef($rsnew, $this->Id_Curso->CurrentValue, 0, $this->Id_Curso->ReadOnly || $this->Id_Curso->MultiUpdate <> "1");

			// Id_Division
			$this->Id_Division->SetDbValueDef($rsnew, $this->Id_Division->CurrentValue, 0, $this->Id_Division->ReadOnly || $this->Id_Division->MultiUpdate <> "1");

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly || $this->Id_Turno->MultiUpdate <> "1");

			// Dni_Tutor
			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly || $this->Dni_Tutor->MultiUpdate <> "1");

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, NULL, $this->NroSerie->ReadOnly || $this->NroSerie->MultiUpdate <> "1");

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;
			if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
				$this->Foto->UploadPath = 'FotosPersonas';
				if (!ew_Empty($this->Foto->Upload->Value) && $this->UpdateCount == 1) {
					if ($this->Foto->Upload->FileName == $this->Foto->Upload->DbValue) { // Overwrite if same file name
						$this->Foto->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['Foto'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Foto->UploadPath), $rsnew['Foto']); // Get new file name
					}
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
						if (!ew_Empty($this->Foto->Upload->Value) && $this->UpdateCount == 1) {
							$this->Foto->Upload->Resize($this->Foto->ImageWidth, $this->Foto->ImageHeight);
							$this->Foto->Upload->SaveToFile($this->Foto->UploadPath, $rsnew['Foto'], TRUE);
						}
						if ($this->Foto->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->Foto->OldUploadPath) . $this->Foto->Upload->DbValue);
					}
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();

		// Foto
		ew_CleanUploadTempPath($this->Foto, $this->Foto->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("personaslist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Estado_Civil":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Civil` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_civil`";
			$sWhereWrk = "";
			$this->Id_Estado_Civil->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Civil` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Provincia":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Provincia` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Provincia` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "{filter}";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Provincia` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Localidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Localidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->Id_Localidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Localidad` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Departamento` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Sexo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Sexo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sexo_personas`";
			$sWhereWrk = "";
			$this->Id_Sexo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Sexo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Cargo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Cargo` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Cargo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Curso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Curso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Division` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Division` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni_Tutor` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld` FROM `tutores`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni_Tutor) . "',`Dni_Tutor`) LIKE '{query_value}%'";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'personas';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'personas';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($personas_update)) $personas_update = new cpersonas_update();

// Page init
$personas_update->Page_Init();

// Page main
$personas_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personas_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fpersonasupdate = new ew_Form("fpersonasupdate", "update");

// Validate form
fpersonasupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Apellidos_Nombres");
			uelm = this.GetElements("u" + infix + "_Apellidos_Nombres");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Apellidos_Nombres->FldCaption(), $personas->Apellidos_Nombres->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Nac");
			uelm = this.GetElements("u" + infix + "_Fecha_Nac");
			if (uelm && uelm.checked && elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Fecha_Nac->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cod_Postal");
			uelm = this.GetElements("u" + infix + "_Cod_Postal");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Cod_Postal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Civil");
			uelm = this.GetElements("u" + infix + "_Id_Estado_Civil");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Estado_Civil->FldCaption(), $personas->Id_Estado_Civil->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Provincia");
			uelm = this.GetElements("u" + infix + "_Id_Provincia");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Provincia->FldCaption(), $personas->Id_Provincia->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			uelm = this.GetElements("u" + infix + "_Id_Departamento");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Departamento->FldCaption(), $personas->Id_Departamento->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			uelm = this.GetElements("u" + infix + "_Id_Localidad");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Localidad->FldCaption(), $personas->Id_Localidad->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Sexo");
			uelm = this.GetElements("u" + infix + "_Id_Sexo");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Sexo->FldCaption(), $personas->Id_Sexo->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Cargo");
			uelm = this.GetElements("u" + infix + "_Id_Cargo");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Cargo->FldCaption(), $personas->Id_Cargo->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Estado");
			uelm = this.GetElements("u" + infix + "_Id_Estado");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Estado->FldCaption(), $personas->Id_Estado->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Curso");
			uelm = this.GetElements("u" + infix + "_Id_Curso");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Curso->FldCaption(), $personas->Id_Curso->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Division");
			uelm = this.GetElements("u" + infix + "_Id_Division");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Division->FldCaption(), $personas->Id_Division->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Turno");
			uelm = this.GetElements("u" + infix + "_Id_Turno");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Turno->FldCaption(), $personas->Id_Turno->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			uelm = this.GetElements("u" + infix + "_Dni_Tutor");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Dni_Tutor->FldCaption(), $personas->Dni_Tutor->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpersonasupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonasupdate.ValidateRequired = true;
<?php } else { ?>
fpersonasupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonasupdate.Lists["x_Repitente"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonasupdate.Lists["x_Repitente"].Options = <?php echo json_encode($personas->Repitente->Options()) ?>;
fpersonasupdate.Lists["x_Id_Estado_Civil"] = {"LinkField":"x_Id_Estado_Civil","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_civil"};
fpersonasupdate.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
fpersonasupdate.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
fpersonasupdate.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};
fpersonasupdate.Lists["x_Id_Sexo"] = {"LinkField":"x_Id_Sexo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sexo_personas"};
fpersonasupdate.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_persona"};
fpersonasupdate.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_persona"};
fpersonasupdate.Lists["x_Id_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
fpersonasupdate.Lists["x_Id_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
fpersonasupdate.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
fpersonasupdate.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fpersonasupdate.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$personas_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $personas_update->ShowPageHeader(); ?>
<?php
$personas_update->ShowMessage();
?>
<form name="fpersonasupdate" id="fpersonasupdate" class="<?php echo $personas_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personas_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personas_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personas">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($personas_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($personas_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_personasupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($personas->Foto->Visible) { // Foto ?>
	<div id="r_Foto" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Foto" id="u_Foto" value="1"<?php echo ($personas->Foto->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Foto->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Foto->CellAttributes() ?>>
<span id="el_personas_Foto">
<div id="fd_x_Foto">
<span title="<?php echo $personas->Foto->FldTitle() ? $personas->Foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personas->Foto->ReadOnly || $personas->Foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personas" data-field="x_Foto" name="x_Foto" id="x_Foto"<?php echo $personas->Foto->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Foto" id= "fn_x_Foto" value="<?php echo $personas->Foto->Upload->FileName ?>">
<?php if (@$_POST["fa_x_Foto"] == "0") { ?>
<input type="hidden" name="fa_x_Foto" id= "fa_x_Foto" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_Foto" id= "fa_x_Foto" value="1">
<?php } ?>
<input type="hidden" name="fs_x_Foto" id= "fs_x_Foto" value="65535">
<input type="hidden" name="fx_x_Foto" id= "fx_x_Foto" value="<?php echo $personas->Foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Foto" id= "fm_x_Foto" value="<?php echo $personas->Foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $personas->Foto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<div id="r_Apellidos_Nombres" class="form-group">
		<label for="x_Apellidos_Nombres" class="col-sm-2 control-label">
<input type="checkbox" name="u_Apellidos_Nombres" id="u_Apellidos_Nombres" value="1"<?php echo ($personas->Apellidos_Nombres->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Apellidos_Nombres->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Apellidos_Nombres->CellAttributes() ?>>
<span id="el_personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x_Apellidos_Nombres" id="x_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php echo $personas->Apellidos_Nombres->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Cuil->Visible) { // Cuil ?>
	<div id="r_Cuil" class="form-group">
		<label for="x_Cuil" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cuil" id="u_Cuil" value="1"<?php echo ($personas->Cuil->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Cuil->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Cuil->CellAttributes() ?>>
<span id="el_personas_Cuil">
<input type="text" data-table="personas" data-field="x_Cuil" name="x_Cuil" id="x_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($personas->Cuil->getPlaceHolder()) ?>" value="<?php echo $personas->Cuil->EditValue ?>"<?php echo $personas->Cuil->EditAttributes() ?>>
</span>
<?php echo $personas->Cuil->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Edad->Visible) { // Edad ?>
	<div id="r_Edad" class="form-group">
		<label for="x_Edad" class="col-sm-2 control-label">
<input type="checkbox" name="u_Edad" id="u_Edad" value="1"<?php echo ($personas->Edad->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Edad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Edad->CellAttributes() ?>>
<span id="el_personas_Edad">
<input type="text" data-table="personas" data-field="x_Edad" name="x_Edad" id="x_Edad" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personas->Edad->getPlaceHolder()) ?>" value="<?php echo $personas->Edad->EditValue ?>"<?php echo $personas->Edad->EditAttributes() ?>>
</span>
<?php echo $personas->Edad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="col-sm-2 control-label">
<input type="checkbox" name="u_Domicilio" id="u_Domicilio" value="1"<?php echo ($personas->Domicilio->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Domicilio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Domicilio->CellAttributes() ?>>
<span id="el_personas_Domicilio">
<input type="text" data-table="personas" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($personas->Domicilio->getPlaceHolder()) ?>" value="<?php echo $personas->Domicilio->EditValue ?>"<?php echo $personas->Domicilio->EditAttributes() ?>>
</span>
<?php echo $personas->Domicilio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Tel_Contacto->Visible) { // Tel_Contacto ?>
	<div id="r_Tel_Contacto" class="form-group">
		<label for="x_Tel_Contacto" class="col-sm-2 control-label">
<input type="checkbox" name="u_Tel_Contacto" id="u_Tel_Contacto" value="1"<?php echo ($personas->Tel_Contacto->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Tel_Contacto->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Tel_Contacto->CellAttributes() ?>>
<span id="el_personas_Tel_Contacto">
<input type="text" data-table="personas" data-field="x_Tel_Contacto" name="x_Tel_Contacto" id="x_Tel_Contacto" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personas->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $personas->Tel_Contacto->EditValue ?>"<?php echo $personas->Tel_Contacto->EditAttributes() ?>>
</span>
<?php echo $personas->Tel_Contacto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Fecha_Nac->Visible) { // Fecha_Nac ?>
	<div id="r_Fecha_Nac" class="form-group">
		<label for="x_Fecha_Nac" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Nac" id="u_Fecha_Nac" value="1"<?php echo ($personas->Fecha_Nac->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Fecha_Nac->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Fecha_Nac->CellAttributes() ?>>
<span id="el_personas_Fecha_Nac">
<input type="text" data-table="personas" data-field="x_Fecha_Nac" name="x_Fecha_Nac" id="x_Fecha_Nac" size="30" maxlength="18" placeholder="<?php echo ew_HtmlEncode($personas->Fecha_Nac->getPlaceHolder()) ?>" value="<?php echo $personas->Fecha_Nac->EditValue ?>"<?php echo $personas->Fecha_Nac->EditAttributes() ?>>
<?php if (!$personas->Fecha_Nac->ReadOnly && !$personas->Fecha_Nac->Disabled && !isset($personas->Fecha_Nac->EditAttrs["readonly"]) && !isset($personas->Fecha_Nac->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpersonasupdate", "x_Fecha_Nac", 7);
</script>
<?php } ?>
</span>
<?php echo $personas->Fecha_Nac->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Lugar_Nacimiento->Visible) { // Lugar_Nacimiento ?>
	<div id="r_Lugar_Nacimiento" class="form-group">
		<label for="x_Lugar_Nacimiento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Lugar_Nacimiento" id="u_Lugar_Nacimiento" value="1"<?php echo ($personas->Lugar_Nacimiento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Lugar_Nacimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Lugar_Nacimiento->CellAttributes() ?>>
<span id="el_personas_Lugar_Nacimiento">
<input type="text" data-table="personas" data-field="x_Lugar_Nacimiento" name="x_Lugar_Nacimiento" id="x_Lugar_Nacimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Lugar_Nacimiento->getPlaceHolder()) ?>" value="<?php echo $personas->Lugar_Nacimiento->EditValue ?>"<?php echo $personas->Lugar_Nacimiento->EditAttributes() ?>>
</span>
<?php echo $personas->Lugar_Nacimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Cod_Postal->Visible) { // Cod_Postal ?>
	<div id="r_Cod_Postal" class="form-group">
		<label for="x_Cod_Postal" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cod_Postal" id="u_Cod_Postal" value="1"<?php echo ($personas->Cod_Postal->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Cod_Postal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Cod_Postal->CellAttributes() ?>>
<span id="el_personas_Cod_Postal">
<input type="text" data-table="personas" data-field="x_Cod_Postal" name="x_Cod_Postal" id="x_Cod_Postal" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($personas->Cod_Postal->getPlaceHolder()) ?>" value="<?php echo $personas->Cod_Postal->EditValue ?>"<?php echo $personas->Cod_Postal->EditAttributes() ?>>
</span>
<?php echo $personas->Cod_Postal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Repitente->Visible) { // Repitente ?>
	<div id="r_Repitente" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Repitente" id="u_Repitente" value="1"<?php echo ($personas->Repitente->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Repitente->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Repitente->CellAttributes() ?>>
<span id="el_personas_Repitente">
<div id="tp_x_Repitente" class="ewTemplate"><input type="radio" data-table="personas" data-field="x_Repitente" data-value-separator="<?php echo $personas->Repitente->DisplayValueSeparatorAttribute() ?>" name="x_Repitente" id="x_Repitente" value="{value}"<?php echo $personas->Repitente->EditAttributes() ?>></div>
<div id="dsl_x_Repitente" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $personas->Repitente->RadioButtonListHtml(FALSE, "x_Repitente") ?>
</div></div>
</span>
<?php echo $personas->Repitente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Estado_Civil->Visible) { // Id_Estado_Civil ?>
	<div id="r_Id_Estado_Civil" class="form-group">
		<label for="x_Id_Estado_Civil" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado_Civil" id="u_Id_Estado_Civil" value="1"<?php echo ($personas->Id_Estado_Civil->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Estado_Civil->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Estado_Civil->CellAttributes() ?>>
<span id="el_personas_Id_Estado_Civil">
<select data-table="personas" data-field="x_Id_Estado_Civil" data-value-separator="<?php echo $personas->Id_Estado_Civil->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Civil" name="x_Id_Estado_Civil"<?php echo $personas->Id_Estado_Civil->EditAttributes() ?>>
<?php echo $personas->Id_Estado_Civil->SelectOptionListHtml("x_Id_Estado_Civil") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Civil" id="s_x_Id_Estado_Civil" value="<?php echo $personas->Id_Estado_Civil->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Estado_Civil->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Provincia->Visible) { // Id_Provincia ?>
	<div id="r_Id_Provincia" class="form-group">
		<label for="x_Id_Provincia" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Provincia" id="u_Id_Provincia" value="1"<?php echo ($personas->Id_Provincia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Provincia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Provincia->CellAttributes() ?>>
<span id="el_personas_Id_Provincia">
<?php $personas->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$personas->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="personas" data-field="x_Id_Provincia" data-value-separator="<?php echo $personas->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x_Id_Provincia" name="x_Id_Provincia"<?php echo $personas->Id_Provincia->EditAttributes() ?>>
<?php echo $personas->Id_Provincia->SelectOptionListHtml("x_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x_Id_Provincia" id="s_x_Id_Provincia" value="<?php echo $personas->Id_Provincia->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Departamento" id="u_Id_Departamento" value="1"<?php echo ($personas->Id_Departamento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Departamento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Departamento->CellAttributes() ?>>
<span id="el_personas_Id_Departamento">
<?php $personas->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$personas->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="personas" data-field="x_Id_Departamento" data-value-separator="<?php echo $personas->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $personas->Id_Departamento->EditAttributes() ?>>
<?php echo $personas->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $personas->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Departamento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Localidad" id="u_Id_Localidad" value="1"<?php echo ($personas->Id_Localidad->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Localidad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Localidad->CellAttributes() ?>>
<span id="el_personas_Id_Localidad">
<select data-table="personas" data-field="x_Id_Localidad" data-value-separator="<?php echo $personas->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $personas->Id_Localidad->EditAttributes() ?>>
<?php echo $personas->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $personas->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Localidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Sexo->Visible) { // Id_Sexo ?>
	<div id="r_Id_Sexo" class="form-group">
		<label for="x_Id_Sexo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Sexo" id="u_Id_Sexo" value="1"<?php echo ($personas->Id_Sexo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Sexo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Sexo->CellAttributes() ?>>
<span id="el_personas_Id_Sexo">
<select data-table="personas" data-field="x_Id_Sexo" data-value-separator="<?php echo $personas->Id_Sexo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Sexo" name="x_Id_Sexo"<?php echo $personas->Id_Sexo->EditAttributes() ?>>
<?php echo $personas->Id_Sexo->SelectOptionListHtml("x_Id_Sexo") ?>
</select>
<input type="hidden" name="s_x_Id_Sexo" id="s_x_Id_Sexo" value="<?php echo $personas->Id_Sexo->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
	<div id="r_Id_Cargo" class="form-group">
		<label for="x_Id_Cargo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Cargo" id="u_Id_Cargo" value="1"<?php echo ($personas->Id_Cargo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Cargo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Cargo->CellAttributes() ?>>
<span id="el_personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Cargo" name="x_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x_Id_Cargo" id="s_x_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Cargo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label for="x_Id_Estado" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado" id="u_Id_Estado" value="1"<?php echo ($personas->Id_Estado->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Estado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Estado->CellAttributes() ?>>
<span id="el_personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
	<div id="r_Id_Curso" class="form-group">
		<label for="x_Id_Curso" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Curso" id="u_Id_Curso" value="1"<?php echo ($personas->Id_Curso->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Curso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Curso->CellAttributes() ?>>
<span id="el_personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x_Id_Curso" name="x_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x_Id_Curso") ?>
</select>
<input type="hidden" name="s_x_Id_Curso" id="s_x_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Curso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
	<div id="r_Id_Division" class="form-group">
		<label for="x_Id_Division" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Division" id="u_Id_Division" value="1"<?php echo ($personas->Id_Division->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Division->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Division->CellAttributes() ?>>
<span id="el_personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x_Id_Division" name="x_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x_Id_Division") ?>
</select>
<input type="hidden" name="s_x_Id_Division" id="s_x_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Division->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label for="x_Id_Turno" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Turno" id="u_Id_Turno" value="1"<?php echo ($personas->Id_Turno->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Id_Turno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Id_Turno->CellAttributes() ?>>
<span id="el_personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Id_Turno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni_Tutor" id="u_Dni_Tutor" value="1"<?php echo ($personas->Dni_Tutor->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Dni_Tutor->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Dni_Tutor->CellAttributes() ?>>
<span id="el_personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x_Dni_Tutor" id="s_x_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php echo $personas->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_NroSerie" id="u_NroSerie" value="1"<?php echo ($personas->NroSerie->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->NroSerie->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->NroSerie->CellAttributes() ?>>
<span id="el_personas_NroSerie">
<?php
$wrkonchange = trim(" " . @$personas->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$personas->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x_NroSerie" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_NroSerie" id="sv_x_NroSerie" value="<?php echo $personas->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NroSerie" id="q_x_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpersonasupdate.CreateAutoSuggest({"id":"x_NroSerie","forceSelect":true});
</script>
</span>
<?php echo $personas->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="col-sm-2 control-label">
<input type="checkbox" name="u_Usuario" id="u_Usuario" value="1"<?php echo ($personas->Usuario->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Usuario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Usuario->CellAttributes() ?>>
<?php echo $personas->Usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Actualizacion" id="u_Fecha_Actualizacion" value="1"<?php echo ($personas->Fecha_Actualizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $personas->Fecha_Actualizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->Fecha_Actualizacion->CellAttributes() ?>>
<?php echo $personas->Fecha_Actualizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$personas_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $personas_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fpersonasupdate.Init();
</script>
<?php
$personas_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personas_update->Page_Terminate();
?>
