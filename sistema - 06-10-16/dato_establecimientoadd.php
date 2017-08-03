<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "autoridades_escolaresgridcls.php" ?>
<?php include_once "referente_tecnicogridcls.php" ?>
<?php include_once "piso_tecnologicogridcls.php" ?>
<?php include_once "servidor_escolargridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dato_establecimiento_add = NULL; // Initialize page object first

class cdato_establecimiento_add extends cdato_establecimiento {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'dato_establecimiento';

	// Page object name
	var $PageObjName = 'dato_establecimiento_add';

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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = FALSE;
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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS["dato_establecimiento"]) || get_class($GLOBALS["dato_establecimiento"]) == "cdato_establecimiento") {
			$GLOBALS["dato_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dato_establecimiento"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dato_establecimiento', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("dato_establecimientolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Cue->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono_Escuela->SetVisibility();
		$this->Mail_Escuela->SetVisibility();
		$this->Matricula_Actual->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

		// Set up detail page object
		$this->SetupDetailPages();

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

			// Process auto fill for detail table 'autoridades_escolares'
			if (@$_POST["grid"] == "fautoridades_escolaresgrid") {
				if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
				$GLOBALS["autoridades_escolares_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'referente_tecnico'
			if (@$_POST["grid"] == "freferente_tecnicogrid") {
				if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
				$GLOBALS["referente_tecnico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'piso_tecnologico'
			if (@$_POST["grid"] == "fpiso_tecnologicogrid") {
				if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
				$GLOBALS["piso_tecnologico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'servidor_escolar'
			if (@$_POST["grid"] == "fservidor_escolargrid") {
				if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
				$GLOBALS["servidor_escolar_grid"]->Page_Init();
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
		global $EW_EXPORT, $dato_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dato_establecimiento);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;
	var $DetailPages; // Detail pages object

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Cue"] != "") {
				$this->Cue->setQueryStringValue($_GET["Cue"]);
				$this->setKey("Cue", $this->Cue->CurrentValue); // Set up key
			} else {
				$this->setKey("Cue", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("dato_establecimientolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "dato_establecimientolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "dato_establecimientoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Cue->CurrentValue = NULL;
		$this->Cue->OldValue = $this->Cue->CurrentValue;
		$this->Nombre_Establecimiento->CurrentValue = NULL;
		$this->Nombre_Establecimiento->OldValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Id_Departamento->CurrentValue = NULL;
		$this->Id_Departamento->OldValue = $this->Id_Departamento->CurrentValue;
		$this->Id_Localidad->CurrentValue = NULL;
		$this->Id_Localidad->OldValue = $this->Id_Localidad->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Telefono_Escuela->CurrentValue = NULL;
		$this->Telefono_Escuela->OldValue = $this->Telefono_Escuela->CurrentValue;
		$this->Mail_Escuela->CurrentValue = NULL;
		$this->Mail_Escuela->OldValue = $this->Mail_Escuela->CurrentValue;
		$this->Matricula_Actual->CurrentValue = NULL;
		$this->Matricula_Actual->OldValue = $this->Matricula_Actual->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Cue->FldIsDetailKey) {
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
		}
		if (!$this->Nombre_Establecimiento->FldIsDetailKey) {
			$this->Nombre_Establecimiento->setFormValue($objForm->GetValue("x_Nombre_Establecimiento"));
		}
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Telefono_Escuela->FldIsDetailKey) {
			$this->Telefono_Escuela->setFormValue($objForm->GetValue("x_Telefono_Escuela"));
		}
		if (!$this->Mail_Escuela->FldIsDetailKey) {
			$this->Mail_Escuela->setFormValue($objForm->GetValue("x_Mail_Escuela"));
		}
		if (!$this->Matricula_Actual->FldIsDetailKey) {
			$this->Matricula_Actual->setFormValue($objForm->GetValue("x_Matricula_Actual"));
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Nombre_Establecimiento->CurrentValue = $this->Nombre_Establecimiento->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono_Escuela->CurrentValue = $this->Telefono_Escuela->FormValue;
		$this->Mail_Escuela->CurrentValue = $this->Mail_Escuela->FormValue;
		$this->Matricula_Actual->CurrentValue = $this->Matricula_Actual->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono_Escuela->setDbValue($rs->fields('Telefono_Escuela'));
		$this->Mail_Escuela->setDbValue($rs->fields('Mail_Escuela'));
		$this->Matricula_Actual->setDbValue($rs->fields('Matricula_Actual'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono_Escuela->DbValue = $row['Telefono_Escuela'];
		$this->Mail_Escuela->DbValue = $row['Mail_Escuela'];
		$this->Matricula_Actual->DbValue = $row['Matricula_Actual'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Cue")) <> "")
			$this->Cue->CurrentValue = $this->getKey("Cue"); // Cue
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Cue
		// Nombre_Establecimiento
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono_Escuela
		// Mail_Escuela
		// Matricula_Actual
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

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

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono_Escuela
		$this->Telefono_Escuela->ViewValue = $this->Telefono_Escuela->CurrentValue;
		$this->Telefono_Escuela->ViewCustomAttributes = "";

		// Mail_Escuela
		$this->Mail_Escuela->ViewValue = $this->Mail_Escuela->CurrentValue;
		$this->Mail_Escuela->ViewCustomAttributes = "";

		// Matricula_Actual
		$this->Matricula_Actual->ViewValue = $this->Matricula_Actual->CurrentValue;
		$this->Matricula_Actual->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

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

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";
			$this->Telefono_Escuela->TooltipValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";
			$this->Mail_Escuela->TooltipValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";
			$this->Matricula_Actual->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->CurrentValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
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

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono_Escuela
			$this->Telefono_Escuela->EditAttrs["class"] = "form-control";
			$this->Telefono_Escuela->EditCustomAttributes = "";
			$this->Telefono_Escuela->EditValue = ew_HtmlEncode($this->Telefono_Escuela->CurrentValue);
			$this->Telefono_Escuela->PlaceHolder = ew_RemoveHtml($this->Telefono_Escuela->FldCaption());

			// Mail_Escuela
			$this->Mail_Escuela->EditAttrs["class"] = "form-control";
			$this->Mail_Escuela->EditCustomAttributes = "";
			$this->Mail_Escuela->EditValue = ew_HtmlEncode($this->Mail_Escuela->CurrentValue);
			$this->Mail_Escuela->PlaceHolder = ew_RemoveHtml($this->Mail_Escuela->FldCaption());

			// Matricula_Actual
			$this->Matricula_Actual->EditAttrs["class"] = "form-control";
			$this->Matricula_Actual->EditCustomAttributes = "";
			$this->Matricula_Actual->EditValue = ew_HtmlEncode($this->Matricula_Actual->CurrentValue);
			$this->Matricula_Actual->PlaceHolder = ew_RemoveHtml($this->Matricula_Actual->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";

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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Cue->FldIsDetailKey && !is_null($this->Cue->FormValue) && $this->Cue->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cue->FldCaption(), $this->Cue->ReqErrMsg));
		}
		if (!$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if (!$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Matricula_Actual->FormValue)) {
			ew_AddMessage($gsFormError, $this->Matricula_Actual->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("autoridades_escolares", $DetailTblVar) && $GLOBALS["autoridades_escolares"]->DetailAdd) {
			if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid(); // get detail page object
			$GLOBALS["autoridades_escolares_grid"]->ValidateGridForm();
		}
		if (in_array("referente_tecnico", $DetailTblVar) && $GLOBALS["referente_tecnico"]->DetailAdd) {
			if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid(); // get detail page object
			$GLOBALS["referente_tecnico_grid"]->ValidateGridForm();
		}
		if (in_array("piso_tecnologico", $DetailTblVar) && $GLOBALS["piso_tecnologico"]->DetailAdd) {
			if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid(); // get detail page object
			$GLOBALS["piso_tecnologico_grid"]->ValidateGridForm();
		}
		if (in_array("servidor_escolar", $DetailTblVar) && $GLOBALS["servidor_escolar"]->DetailAdd) {
			if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid(); // get detail page object
			$GLOBALS["servidor_escolar_grid"]->ValidateGridForm();
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Cue
		$this->Cue->SetDbValueDef($rsnew, $this->Cue->CurrentValue, "", FALSE);

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, FALSE);

		// Id_Departamento
		$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, FALSE);

		// Id_Localidad
		$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Telefono_Escuela
		$this->Telefono_Escuela->SetDbValueDef($rsnew, $this->Telefono_Escuela->CurrentValue, NULL, FALSE);

		// Mail_Escuela
		$this->Mail_Escuela->SetDbValueDef($rsnew, $this->Mail_Escuela->CurrentValue, NULL, FALSE);

		// Matricula_Actual
		$this->Matricula_Actual->SetDbValueDef($rsnew, $this->Matricula_Actual->CurrentValue, NULL, FALSE);

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Cue']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("autoridades_escolares", $DetailTblVar) && $GLOBALS["autoridades_escolares"]->DetailAdd) {
				$GLOBALS["autoridades_escolares"]->Cue->setSessionValue($this->Cue->CurrentValue); // Set master key
				if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid(); // Get detail page object
				$AddRow = $GLOBALS["autoridades_escolares_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["autoridades_escolares"]->Cue->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("referente_tecnico", $DetailTblVar) && $GLOBALS["referente_tecnico"]->DetailAdd) {
				$GLOBALS["referente_tecnico"]->Cue->setSessionValue($this->Cue->CurrentValue); // Set master key
				if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid(); // Get detail page object
				$AddRow = $GLOBALS["referente_tecnico_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["referente_tecnico"]->Cue->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("piso_tecnologico", $DetailTblVar) && $GLOBALS["piso_tecnologico"]->DetailAdd) {
				$GLOBALS["piso_tecnologico"]->Cue->setSessionValue($this->Cue->CurrentValue); // Set master key
				if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid(); // Get detail page object
				$AddRow = $GLOBALS["piso_tecnologico_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["piso_tecnologico"]->Cue->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("servidor_escolar", $DetailTblVar) && $GLOBALS["servidor_escolar"]->DetailAdd) {
				$GLOBALS["servidor_escolar"]->Cue->setSessionValue($this->Cue->CurrentValue); // Set master key
				if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid(); // Get detail page object
				$AddRow = $GLOBALS["servidor_escolar_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["servidor_escolar"]->Cue->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("autoridades_escolares", $DetailTblVar)) {
				if (!isset($GLOBALS["autoridades_escolares_grid"]))
					$GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
				if ($GLOBALS["autoridades_escolares_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["autoridades_escolares_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["autoridades_escolares_grid"]->CurrentMode = "add";
					$GLOBALS["autoridades_escolares_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["autoridades_escolares_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["autoridades_escolares_grid"]->setStartRecordNumber(1);
					$GLOBALS["autoridades_escolares_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["autoridades_escolares_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["autoridades_escolares_grid"]->Cue->setSessionValue($GLOBALS["autoridades_escolares_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("referente_tecnico", $DetailTblVar)) {
				if (!isset($GLOBALS["referente_tecnico_grid"]))
					$GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
				if ($GLOBALS["referente_tecnico_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["referente_tecnico_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["referente_tecnico_grid"]->CurrentMode = "add";
					$GLOBALS["referente_tecnico_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["referente_tecnico_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["referente_tecnico_grid"]->setStartRecordNumber(1);
					$GLOBALS["referente_tecnico_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["referente_tecnico_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["referente_tecnico_grid"]->Cue->setSessionValue($GLOBALS["referente_tecnico_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("piso_tecnologico", $DetailTblVar)) {
				if (!isset($GLOBALS["piso_tecnologico_grid"]))
					$GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
				if ($GLOBALS["piso_tecnologico_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["piso_tecnologico_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["piso_tecnologico_grid"]->CurrentMode = "add";
					$GLOBALS["piso_tecnologico_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["piso_tecnologico_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["piso_tecnologico_grid"]->setStartRecordNumber(1);
					$GLOBALS["piso_tecnologico_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["piso_tecnologico_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["piso_tecnologico_grid"]->Cue->setSessionValue($GLOBALS["piso_tecnologico_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("servidor_escolar", $DetailTblVar)) {
				if (!isset($GLOBALS["servidor_escolar_grid"]))
					$GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
				if ($GLOBALS["servidor_escolar_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["servidor_escolar_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["servidor_escolar_grid"]->CurrentMode = "add";
					$GLOBALS["servidor_escolar_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["servidor_escolar_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["servidor_escolar_grid"]->setStartRecordNumber(1);
					$GLOBALS["servidor_escolar_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["servidor_escolar_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["servidor_escolar_grid"]->Cue->setSessionValue($GLOBALS["servidor_escolar_grid"]->Cue->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dato_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up detail pages
	function SetupDetailPages() {
		$pages = new cSubPages();
		$pages->Add('autoridades_escolares');
		$pages->Add('referente_tecnico');
		$pages->Add('piso_tecnologico');
		$pages->Add('servidor_escolar');
		$this->DetailPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "");
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
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'dato_establecimiento';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
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
if (!isset($dato_establecimiento_add)) $dato_establecimiento_add = new cdato_establecimiento_add();

// Page init
$dato_establecimiento_add->Page_Init();

// Page main
$dato_establecimiento_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dato_establecimiento_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdato_establecimientoadd = new ew_Form("fdato_establecimientoadd", "add");

// Validate form
fdato_establecimientoadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Cue");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Cue->FldCaption(), $dato_establecimiento->Cue->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Departamento->FldCaption(), $dato_establecimiento->Id_Departamento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Localidad->FldCaption(), $dato_establecimiento->Id_Localidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Matricula_Actual");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Matricula_Actual->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdato_establecimientoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdato_establecimientoadd.ValidateRequired = true;
<?php } else { ?>
fdato_establecimientoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdato_establecimientoadd.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdato_establecimientoadd.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$dato_establecimiento_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $dato_establecimiento_add->ShowPageHeader(); ?>
<?php
$dato_establecimiento_add->ShowMessage();
?>
<form name="fdato_establecimientoadd" id="fdato_establecimientoadd" class="<?php echo $dato_establecimiento_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($dato_establecimiento_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
	<div id="r_Cue" class="form-group">
		<label id="elh_dato_establecimiento_Cue" for="x_Cue" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Cue->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Cue->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cue">
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" data-page="1" name="x_Cue" id="x_Cue" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Cue->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<div id="r_Nombre_Establecimiento" class="form-group">
		<label id="elh_dato_establecimiento_Nombre_Establecimiento" for="x_Nombre_Establecimiento" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Nombre_Establecimiento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" data-page="1" name="x_Nombre_Establecimiento" id="x_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Nombre_Establecimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label id="elh_dato_establecimiento_Id_Departamento" for="x_Id_Departamento" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-page="1" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Departamento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label id="elh_dato_establecimiento_Id_Localidad" for="x_Id_Localidad" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-page="1" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Localidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label id="elh_dato_establecimiento_Domicilio" for="x_Domicilio" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Domicilio->CellAttributes() ?>>
<span id="el_dato_establecimiento_Domicilio">
<input type="text" data-table="dato_establecimiento" data-field="x_Domicilio" data-page="1" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Domicilio->EditValue ?>"<?php echo $dato_establecimiento->Domicilio->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Domicilio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
	<div id="r_Telefono_Escuela" class="form-group">
		<label id="elh_dato_establecimiento_Telefono_Escuela" for="x_Telefono_Escuela" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Telefono_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Telefono_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" data-page="1" name="x_Telefono_Escuela" id="x_Telefono_Escuela" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Telefono_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Telefono_Escuela->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Telefono_Escuela->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
	<div id="r_Mail_Escuela" class="form-group">
		<label id="elh_dato_establecimiento_Mail_Escuela" for="x_Mail_Escuela" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Mail_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Mail_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Mail_Escuela" data-page="1" name="x_Mail_Escuela" id="x_Mail_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Mail_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Mail_Escuela->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Mail_Escuela->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
	<div id="r_Matricula_Actual" class="form-group">
		<label id="elh_dato_establecimiento_Matricula_Actual" for="x_Matricula_Actual" class="col-sm-2 control-label ewLabel"><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Matricula_Actual->CellAttributes() ?>>
<span id="el_dato_establecimiento_Matricula_Actual">
<input type="text" data-table="dato_establecimiento" data-field="x_Matricula_Actual" data-page="1" name="x_Matricula_Actual" id="x_Matricula_Actual" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Matricula_Actual->EditValue ?>"<?php echo $dato_establecimiento->Matricula_Actual->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Matricula_Actual->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if ($dato_establecimiento->getCurrentDetailTable() <> "") { ?>
<?php
	$FirstActiveDetailTable = $dato_establecimiento_add->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages">
<div class="panel-group" id="dato_establecimiento_add_details">
<?php
	if (in_array("autoridades_escolares", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $autoridades_escolares->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "autoridades_escolares") {
			$FirstActiveDetailTable = "autoridades_escolares";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_add->DetailPages->PageStyle("autoridades_escolares") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_add_details" href="#tab_autoridades_escolares"><?php echo $Language->TablePhrase("autoridades_escolares", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_add->DetailPages->PageStyle("autoridades_escolares") ?>" id="tab_autoridades_escolares">
			<div class="panel-body">
<?php include_once "autoridades_escolaresgrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("referente_tecnico", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $referente_tecnico->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "referente_tecnico") {
			$FirstActiveDetailTable = "referente_tecnico";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_add->DetailPages->PageStyle("referente_tecnico") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_add_details" href="#tab_referente_tecnico"><?php echo $Language->TablePhrase("referente_tecnico", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_add->DetailPages->PageStyle("referente_tecnico") ?>" id="tab_referente_tecnico">
			<div class="panel-body">
<?php include_once "referente_tecnicogrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("piso_tecnologico", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $piso_tecnologico->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "piso_tecnologico") {
			$FirstActiveDetailTable = "piso_tecnologico";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_add->DetailPages->PageStyle("piso_tecnologico") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_add_details" href="#tab_piso_tecnologico"><?php echo $Language->TablePhrase("piso_tecnologico", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_add->DetailPages->PageStyle("piso_tecnologico") ?>" id="tab_piso_tecnologico">
			<div class="panel-body">
<?php include_once "piso_tecnologicogrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("servidor_escolar", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $servidor_escolar->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "servidor_escolar") {
			$FirstActiveDetailTable = "servidor_escolar";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_add->DetailPages->PageStyle("servidor_escolar") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_add_details" href="#tab_servidor_escolar"><?php echo $Language->TablePhrase("servidor_escolar", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_add->DetailPages->PageStyle("servidor_escolar") ?>" id="tab_servidor_escolar">
			<div class="panel-body">
<?php include_once "servidor_escolargrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if (!$dato_establecimiento_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dato_establecimiento_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdato_establecimientoadd.Init();
</script>
<?php
$dato_establecimiento_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dato_establecimiento_add->Page_Terminate();
?>
