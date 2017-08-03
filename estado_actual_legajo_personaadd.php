<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "estado_actual_legajo_personainfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$estado_actual_legajo_persona_add = NULL; // Initialize page object first

class cestado_actual_legajo_persona_add extends cestado_actual_legajo_persona {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'estado_actual_legajo_persona';

	// Page object name
	var $PageObjName = 'estado_actual_legajo_persona_add';

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (estado_actual_legajo_persona)
		if (!isset($GLOBALS["estado_actual_legajo_persona"]) || get_class($GLOBALS["estado_actual_legajo_persona"]) == "cestado_actual_legajo_persona") {
			$GLOBALS["estado_actual_legajo_persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_actual_legajo_persona"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_actual_legajo_persona', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("estado_actual_legajo_personalist.php"));
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
		$this->Matricula->SetVisibility();
		$this->Certificado_Pase->SetVisibility();
		$this->Tiene_DNI->SetVisibility();
		$this->Certificado_Medico->SetVisibility();
		$this->Posee_Autorizacion->SetVisibility();
		$this->Cooperadora->SetVisibility();
		$this->Archivos_Varios->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $estado_actual_legajo_persona;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_actual_legajo_persona);
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
	var $MultiPages; // Multi pages object

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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Dni"] != "") {
				$this->Dni->setQueryStringValue($_GET["Dni"]);
				$this->setKey("Dni", $this->Dni->CurrentValue); // Set up key
			} else {
				$this->setKey("Dni", ""); // Clear key
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
					$this->Page_Terminate("estado_actual_legajo_personalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "estado_actual_legajo_personalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "estado_actual_legajo_personaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
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
		$this->Archivos_Varios->Upload->Index = $objForm->Index;
		$this->Archivos_Varios->Upload->UploadFile();
		$this->Archivos_Varios->CurrentValue = $this->Archivos_Varios->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Matricula->CurrentValue = 'SI';
		$this->Certificado_Pase->CurrentValue = 'SI';
		$this->Tiene_DNI->CurrentValue = 'SI';
		$this->Certificado_Medico->CurrentValue = 'SI';
		$this->Posee_Autorizacion->CurrentValue = 'SI';
		$this->Cooperadora->CurrentValue = 'SI';
		$this->Archivos_Varios->Upload->DbValue = NULL;
		$this->Archivos_Varios->OldValue = $this->Archivos_Varios->Upload->DbValue;
		$this->Archivos_Varios->CurrentValue = NULL; // Clear file related field
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Matricula->FldIsDetailKey) {
			$this->Matricula->setFormValue($objForm->GetValue("x_Matricula"));
		}
		if (!$this->Certificado_Pase->FldIsDetailKey) {
			$this->Certificado_Pase->setFormValue($objForm->GetValue("x_Certificado_Pase"));
		}
		if (!$this->Tiene_DNI->FldIsDetailKey) {
			$this->Tiene_DNI->setFormValue($objForm->GetValue("x_Tiene_DNI"));
		}
		if (!$this->Certificado_Medico->FldIsDetailKey) {
			$this->Certificado_Medico->setFormValue($objForm->GetValue("x_Certificado_Medico"));
		}
		if (!$this->Posee_Autorizacion->FldIsDetailKey) {
			$this->Posee_Autorizacion->setFormValue($objForm->GetValue("x_Posee_Autorizacion"));
		}
		if (!$this->Cooperadora->FldIsDetailKey) {
			$this->Cooperadora->setFormValue($objForm->GetValue("x_Cooperadora"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		if (!$this->Dni->FldIsDetailKey)
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Matricula->CurrentValue = $this->Matricula->FormValue;
		$this->Certificado_Pase->CurrentValue = $this->Certificado_Pase->FormValue;
		$this->Tiene_DNI->CurrentValue = $this->Tiene_DNI->FormValue;
		$this->Certificado_Medico->CurrentValue = $this->Certificado_Medico->FormValue;
		$this->Posee_Autorizacion->CurrentValue = $this->Posee_Autorizacion->FormValue;
		$this->Cooperadora->CurrentValue = $this->Cooperadora->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Matricula->setDbValue($rs->fields('Matricula'));
		$this->Certificado_Pase->setDbValue($rs->fields('Certificado_Pase'));
		$this->Tiene_DNI->setDbValue($rs->fields('Tiene_DNI'));
		$this->Certificado_Medico->setDbValue($rs->fields('Certificado_Medico'));
		$this->Posee_Autorizacion->setDbValue($rs->fields('Posee_Autorizacion'));
		$this->Cooperadora->setDbValue($rs->fields('Cooperadora'));
		$this->Archivos_Varios->Upload->DbValue = $rs->fields('Archivos Varios');
		$this->Archivos_Varios->CurrentValue = $this->Archivos_Varios->Upload->DbValue;
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dni->DbValue = $row['Dni'];
		$this->Matricula->DbValue = $row['Matricula'];
		$this->Certificado_Pase->DbValue = $row['Certificado_Pase'];
		$this->Tiene_DNI->DbValue = $row['Tiene_DNI'];
		$this->Certificado_Medico->DbValue = $row['Certificado_Medico'];
		$this->Posee_Autorizacion->DbValue = $row['Posee_Autorizacion'];
		$this->Cooperadora->DbValue = $row['Cooperadora'];
		$this->Archivos_Varios->Upload->DbValue = $row['Archivos Varios'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Dni")) <> "")
			$this->Dni->CurrentValue = $this->getKey("Dni"); // Dni
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
		// Dni
		// Matricula
		// Certificado_Pase
		// Tiene_DNI
		// Certificado_Medico
		// Posee_Autorizacion
		// Cooperadora
		// Archivos Varios
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Matricula
		if (strval($this->Matricula->CurrentValue) <> "") {
			$this->Matricula->ViewValue = $this->Matricula->OptionCaption($this->Matricula->CurrentValue);
		} else {
			$this->Matricula->ViewValue = NULL;
		}
		$this->Matricula->ViewCustomAttributes = "";

		// Certificado_Pase
		if (strval($this->Certificado_Pase->CurrentValue) <> "") {
			$this->Certificado_Pase->ViewValue = $this->Certificado_Pase->OptionCaption($this->Certificado_Pase->CurrentValue);
		} else {
			$this->Certificado_Pase->ViewValue = NULL;
		}
		$this->Certificado_Pase->ViewCustomAttributes = "";

		// Tiene_DNI
		if (strval($this->Tiene_DNI->CurrentValue) <> "") {
			$this->Tiene_DNI->ViewValue = $this->Tiene_DNI->OptionCaption($this->Tiene_DNI->CurrentValue);
		} else {
			$this->Tiene_DNI->ViewValue = NULL;
		}
		$this->Tiene_DNI->ViewCustomAttributes = "";

		// Certificado_Medico
		if (strval($this->Certificado_Medico->CurrentValue) <> "") {
			$this->Certificado_Medico->ViewValue = $this->Certificado_Medico->OptionCaption($this->Certificado_Medico->CurrentValue);
		} else {
			$this->Certificado_Medico->ViewValue = NULL;
		}
		$this->Certificado_Medico->ViewCustomAttributes = "";

		// Posee_Autorizacion
		if (strval($this->Posee_Autorizacion->CurrentValue) <> "") {
			$this->Posee_Autorizacion->ViewValue = $this->Posee_Autorizacion->OptionCaption($this->Posee_Autorizacion->CurrentValue);
		} else {
			$this->Posee_Autorizacion->ViewValue = NULL;
		}
		$this->Posee_Autorizacion->ViewCustomAttributes = "";

		// Cooperadora
		if (strval($this->Cooperadora->CurrentValue) <> "") {
			$this->Cooperadora->ViewValue = $this->Cooperadora->OptionCaption($this->Cooperadora->CurrentValue);
		} else {
			$this->Cooperadora->ViewValue = NULL;
		}
		$this->Cooperadora->ViewCustomAttributes = "";

		// Archivos Varios
		$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
		if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
			$this->Archivos_Varios->ImageAlt = $this->Archivos_Varios->FldAlt();
			$this->Archivos_Varios->ViewValue = $this->Archivos_Varios->Upload->DbValue;
		} else {
			$this->Archivos_Varios->ViewValue = "";
		}
		$this->Archivos_Varios->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Matricula
			$this->Matricula->LinkCustomAttributes = "";
			$this->Matricula->HrefValue = "";
			$this->Matricula->TooltipValue = "";

			// Certificado_Pase
			$this->Certificado_Pase->LinkCustomAttributes = "";
			$this->Certificado_Pase->HrefValue = "";
			$this->Certificado_Pase->TooltipValue = "";

			// Tiene_DNI
			$this->Tiene_DNI->LinkCustomAttributes = "";
			$this->Tiene_DNI->HrefValue = "";
			$this->Tiene_DNI->TooltipValue = "";

			// Certificado_Medico
			$this->Certificado_Medico->LinkCustomAttributes = "";
			$this->Certificado_Medico->HrefValue = "";
			$this->Certificado_Medico->TooltipValue = "";

			// Posee_Autorizacion
			$this->Posee_Autorizacion->LinkCustomAttributes = "";
			$this->Posee_Autorizacion->HrefValue = "";
			$this->Posee_Autorizacion->TooltipValue = "";

			// Cooperadora
			$this->Cooperadora->LinkCustomAttributes = "";
			$this->Cooperadora->HrefValue = "";
			$this->Cooperadora->TooltipValue = "";

			// Archivos Varios
			$this->Archivos_Varios->LinkCustomAttributes = "";
			$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
			if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
				$this->Archivos_Varios->HrefValue = "%u"; // Add prefix/suffix
				$this->Archivos_Varios->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos_Varios->HrefValue = ew_ConvertFullUrl($this->Archivos_Varios->HrefValue);
			} else {
				$this->Archivos_Varios->HrefValue = "";
			}
			$this->Archivos_Varios->HrefValue2 = $this->Archivos_Varios->UploadPath . $this->Archivos_Varios->Upload->DbValue;
			$this->Archivos_Varios->TooltipValue = "";
			if ($this->Archivos_Varios->UseColorbox) {
				if (ew_Empty($this->Archivos_Varios->TooltipValue))
					$this->Archivos_Varios->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Archivos_Varios->LinkAttrs["data-rel"] = "estado_actual_legajo_persona_x_Archivos_Varios";
				ew_AppendClass($this->Archivos_Varios->LinkAttrs["class"], "ewLightbox");
			}

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Matricula
			$this->Matricula->EditCustomAttributes = "";
			$this->Matricula->EditValue = $this->Matricula->Options(FALSE);

			// Certificado_Pase
			$this->Certificado_Pase->EditCustomAttributes = "";
			$this->Certificado_Pase->EditValue = $this->Certificado_Pase->Options(FALSE);

			// Tiene_DNI
			$this->Tiene_DNI->EditCustomAttributes = "";
			$this->Tiene_DNI->EditValue = $this->Tiene_DNI->Options(FALSE);

			// Certificado_Medico
			$this->Certificado_Medico->EditCustomAttributes = "";
			$this->Certificado_Medico->EditValue = $this->Certificado_Medico->Options(FALSE);

			// Posee_Autorizacion
			$this->Posee_Autorizacion->EditCustomAttributes = "";
			$this->Posee_Autorizacion->EditValue = $this->Posee_Autorizacion->Options(FALSE);

			// Cooperadora
			$this->Cooperadora->EditCustomAttributes = "";
			$this->Cooperadora->EditValue = $this->Cooperadora->Options(FALSE);

			// Archivos Varios
			$this->Archivos_Varios->EditAttrs["class"] = "form-control";
			$this->Archivos_Varios->EditCustomAttributes = "";
			$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
			if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
				$this->Archivos_Varios->ImageAlt = $this->Archivos_Varios->FldAlt();
				$this->Archivos_Varios->EditValue = $this->Archivos_Varios->Upload->DbValue;
			} else {
				$this->Archivos_Varios->EditValue = "";
			}
			if (!ew_Empty($this->Archivos_Varios->CurrentValue))
				$this->Archivos_Varios->Upload->FileName = $this->Archivos_Varios->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->Archivos_Varios);

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Matricula

			$this->Matricula->LinkCustomAttributes = "";
			$this->Matricula->HrefValue = "";

			// Certificado_Pase
			$this->Certificado_Pase->LinkCustomAttributes = "";
			$this->Certificado_Pase->HrefValue = "";

			// Tiene_DNI
			$this->Tiene_DNI->LinkCustomAttributes = "";
			$this->Tiene_DNI->HrefValue = "";

			// Certificado_Medico
			$this->Certificado_Medico->LinkCustomAttributes = "";
			$this->Certificado_Medico->HrefValue = "";

			// Posee_Autorizacion
			$this->Posee_Autorizacion->LinkCustomAttributes = "";
			$this->Posee_Autorizacion->HrefValue = "";

			// Cooperadora
			$this->Cooperadora->LinkCustomAttributes = "";
			$this->Cooperadora->HrefValue = "";

			// Archivos Varios
			$this->Archivos_Varios->LinkCustomAttributes = "";
			$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
			if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
				$this->Archivos_Varios->HrefValue = "%u"; // Add prefix/suffix
				$this->Archivos_Varios->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos_Varios->HrefValue = ew_ConvertFullUrl($this->Archivos_Varios->HrefValue);
			} else {
				$this->Archivos_Varios->HrefValue = "";
			}
			$this->Archivos_Varios->HrefValue2 = $this->Archivos_Varios->UploadPath . $this->Archivos_Varios->Upload->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
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

		// Check referential integrity for master table 'personas'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_personas();
		if ($this->Dni->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["personas"])) $GLOBALS["personas"] = new cpersonas();
			$rsmaster = $GLOBALS["personas"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "personas", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->Archivos_Varios->OldUploadPath = 'ArchivosLegajoPersonas';
			$this->Archivos_Varios->UploadPath = $this->Archivos_Varios->OldUploadPath;
		}
		$rsnew = array();

		// Matricula
		$this->Matricula->SetDbValueDef($rsnew, $this->Matricula->CurrentValue, NULL, FALSE);

		// Certificado_Pase
		$this->Certificado_Pase->SetDbValueDef($rsnew, $this->Certificado_Pase->CurrentValue, NULL, FALSE);

		// Tiene_DNI
		$this->Tiene_DNI->SetDbValueDef($rsnew, $this->Tiene_DNI->CurrentValue, NULL, FALSE);

		// Certificado_Medico
		$this->Certificado_Medico->SetDbValueDef($rsnew, $this->Certificado_Medico->CurrentValue, NULL, FALSE);

		// Posee_Autorizacion
		$this->Posee_Autorizacion->SetDbValueDef($rsnew, $this->Posee_Autorizacion->CurrentValue, NULL, FALSE);

		// Cooperadora
		$this->Cooperadora->SetDbValueDef($rsnew, $this->Cooperadora->CurrentValue, NULL, FALSE);

		// Archivos Varios
		if ($this->Archivos_Varios->Visible && !$this->Archivos_Varios->Upload->KeepFile) {
			$this->Archivos_Varios->Upload->DbValue = ""; // No need to delete old file
			if ($this->Archivos_Varios->Upload->FileName == "") {
				$rsnew['Archivos Varios'] = NULL;
			} else {
				$rsnew['Archivos Varios'] = $this->Archivos_Varios->Upload->FileName;
			}
		}

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Dni
		if ($this->Dni->getSessionValue() <> "") {
			$rsnew['Dni'] = $this->Dni->getSessionValue();
		}
		if ($this->Archivos_Varios->Visible && !$this->Archivos_Varios->Upload->KeepFile) {
			$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Archivos_Varios->Upload->DbValue);
			if (!ew_Empty($this->Archivos_Varios->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Archivos_Varios->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->Archivos_Varios->Upload->Index < 0) ? $this->Archivos_Varios->FldVar : substr($this->Archivos_Varios->FldVar, 0, 1) . $this->Archivos_Varios->Upload->Index . substr($this->Archivos_Varios->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->Archivos_Varios->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Archivos_Varios->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->Archivos_Varios->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Archivos_Varios->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->Archivos_Varios->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Archivos_Varios->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->Archivos_Varios->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['Archivos Varios'] = $this->Archivos_Varios->Upload->FileName;
			} else {
				$NewFiles = array();
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Dni']) == "") {
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
				if ($this->Archivos_Varios->Visible && !$this->Archivos_Varios->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Archivos_Varios->Upload->DbValue);
					if (!ew_Empty($this->Archivos_Varios->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Archivos_Varios->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Archivos Varios']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->Archivos_Varios->Upload->Index < 0) ? $this->Archivos_Varios->FldVar : substr($this->Archivos_Varios->FldVar, 0, 1) . $this->Archivos_Varios->Upload->Index . substr($this->Archivos_Varios->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->Archivos_Varios->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->Archivos_Varios->Upload->SaveToFile($this->Archivos_Varios->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
					$FileCount = count($OldFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
							@unlink(ew_UploadPathEx(TRUE, $this->Archivos_Varios->OldUploadPath) . $OldFiles[$i]);
					}
				}
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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}

		// Archivos Varios
		ew_CleanUploadTempPath($this->Archivos_Varios, $this->Archivos_Varios->Upload->Index);
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Dni"] <> "") {
					$GLOBALS["personas"]->Dni->setQueryStringValue($_GET["fk_Dni"]);
					$this->Dni->setQueryStringValue($GLOBALS["personas"]->Dni->QueryStringValue);
					$this->Dni->setSessionValue($this->Dni->QueryStringValue);
					if (!is_numeric($GLOBALS["personas"]->Dni->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Dni"] <> "") {
					$GLOBALS["personas"]->Dni->setFormValue($_POST["fk_Dni"]);
					$this->Dni->setFormValue($GLOBALS["personas"]->Dni->FormValue);
					$this->Dni->setSessionValue($this->Dni->FormValue);
					if (!is_numeric($GLOBALS["personas"]->Dni->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "personas") {
				if ($this->Dni->CurrentValue == "") $this->Dni->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_actual_legajo_personalist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$this->MultiPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
		$table = 'estado_actual_legajo_persona';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'estado_actual_legajo_persona';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dni'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
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
if (!isset($estado_actual_legajo_persona_add)) $estado_actual_legajo_persona_add = new cestado_actual_legajo_persona_add();

// Page init
$estado_actual_legajo_persona_add->Page_Init();

// Page main
$estado_actual_legajo_persona_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_actual_legajo_persona_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = festado_actual_legajo_personaadd = new ew_Form("festado_actual_legajo_personaadd", "add");

// Validate form
festado_actual_legajo_personaadd.Validate = function() {
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
festado_actual_legajo_personaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_actual_legajo_personaadd.ValidateRequired = true;
<?php } else { ?>
festado_actual_legajo_personaadd.ValidateRequired = false; 
<?php } ?>

// Multi-Page
festado_actual_legajo_personaadd.MultiPage = new ew_MultiPage("festado_actual_legajo_personaadd");

// Dynamic selection lists
festado_actual_legajo_personaadd.Lists["x_Matricula"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Matricula"].Options = <?php echo json_encode($estado_actual_legajo_persona->Matricula->Options()) ?>;
festado_actual_legajo_personaadd.Lists["x_Certificado_Pase"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Certificado_Pase"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Pase->Options()) ?>;
festado_actual_legajo_personaadd.Lists["x_Tiene_DNI"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Tiene_DNI"].Options = <?php echo json_encode($estado_actual_legajo_persona->Tiene_DNI->Options()) ?>;
festado_actual_legajo_personaadd.Lists["x_Certificado_Medico"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Certificado_Medico"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Medico->Options()) ?>;
festado_actual_legajo_personaadd.Lists["x_Posee_Autorizacion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Posee_Autorizacion"].Options = <?php echo json_encode($estado_actual_legajo_persona->Posee_Autorizacion->Options()) ?>;
festado_actual_legajo_personaadd.Lists["x_Cooperadora"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaadd.Lists["x_Cooperadora"].Options = <?php echo json_encode($estado_actual_legajo_persona->Cooperadora->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$estado_actual_legajo_persona_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estado_actual_legajo_persona_add->ShowPageHeader(); ?>
<?php
$estado_actual_legajo_persona_add->ShowMessage();
?>
<form name="festado_actual_legajo_personaadd" id="festado_actual_legajo_personaadd" class="<?php echo $estado_actual_legajo_persona_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_actual_legajo_persona_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_actual_legajo_persona_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_actual_legajo_persona">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($estado_actual_legajo_persona_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($estado_actual_legajo_persona->getCurrentMasterTable() == "personas") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_Dni" value="<?php echo $estado_actual_legajo_persona->Dni->getSessionValue() ?>">
<?php } ?>
<div class="ewMultiPage">
<div class="panel-group" id="estado_actual_legajo_persona_add">
	<div class="panel panel-default<?php echo $estado_actual_legajo_persona_add->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#estado_actual_legajo_persona_add" href="#tab_estado_actual_legajo_persona1"><?php echo $estado_actual_legajo_persona->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $estado_actual_legajo_persona_add->MultiPages->PageStyle("1") ?>" id="tab_estado_actual_legajo_persona1">
			<div class="panel-body">
<div>
<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
	<div id="r_Matricula" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Matricula" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Matricula->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Matricula->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Matricula">
<div id="tp_x_Matricula" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" name="x_Matricula" id="x_Matricula" value="{value}"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>></div>
<div id="dsl_x_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Matricula->RadioButtonListHtml(FALSE, "x_Matricula", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Matricula->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
	<div id="r_Certificado_Pase" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Certificado_Pase" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Certificado_Pase->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Certificado_Pase->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Certificado_Pase">
<div id="tp_x_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Pase" id="x_Certificado_Pase" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->RadioButtonListHtml(FALSE, "x_Certificado_Pase", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
	<div id="r_Tiene_DNI" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Tiene_DNI" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Tiene_DNI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Tiene_DNI->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Tiene_DNI">
<div id="tp_x_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_DNI" id="x_Tiene_DNI" value="{value}"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->RadioButtonListHtml(FALSE, "x_Tiene_DNI", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
	<div id="r_Certificado_Medico" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Certificado_Medico" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Certificado_Medico->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Certificado_Medico->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Certificado_Medico">
<div id="tp_x_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Medico" id="x_Certificado_Medico" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->RadioButtonListHtml(FALSE, "x_Certificado_Medico", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
	<div id="r_Posee_Autorizacion" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Posee_Autorizacion" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Posee_Autorizacion">
<div id="tp_x_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x_Posee_Autorizacion" id="x_Posee_Autorizacion" value="{value}"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x_Posee_Autorizacion", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
	<div id="r_Cooperadora" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Cooperadora" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Cooperadora->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Cooperadora->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Cooperadora">
<div id="tp_x_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-page="1" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x_Cooperadora" id="x_Cooperadora" value="{value}"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Cooperadora->RadioButtonListHtml(FALSE, "x_Cooperadora", 1) ?>
</div></div>
</span>
<?php echo $estado_actual_legajo_persona->Cooperadora->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $estado_actual_legajo_persona_add->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#estado_actual_legajo_persona_add" href="#tab_estado_actual_legajo_persona2"><?php echo $estado_actual_legajo_persona->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $estado_actual_legajo_persona_add->MultiPages->PageStyle("2") ?>" id="tab_estado_actual_legajo_persona2">
			<div class="panel-body">
<div>
<?php if ($estado_actual_legajo_persona->Archivos_Varios->Visible) { // Archivos Varios ?>
	<div id="r_Archivos_Varios" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Archivos_Varios" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Archivos_Varios->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Archivos_Varios->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Archivos_Varios">
<div id="fd_x_Archivos_Varios">
<span title="<?php echo $estado_actual_legajo_persona->Archivos_Varios->FldTitle() ? $estado_actual_legajo_persona->Archivos_Varios->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($estado_actual_legajo_persona->Archivos_Varios->ReadOnly || $estado_actual_legajo_persona->Archivos_Varios->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="estado_actual_legajo_persona" data-field="x_Archivos_Varios" data-page="2" name="x_Archivos_Varios" id="x_Archivos_Varios" multiple="multiple"<?php echo $estado_actual_legajo_persona->Archivos_Varios->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Archivos_Varios" id= "fn_x_Archivos_Varios" value="<?php echo $estado_actual_legajo_persona->Archivos_Varios->Upload->FileName ?>">
<input type="hidden" name="fa_x_Archivos_Varios" id= "fa_x_Archivos_Varios" value="0">
<input type="hidden" name="fs_x_Archivos_Varios" id= "fs_x_Archivos_Varios" value="65535">
<input type="hidden" name="fx_x_Archivos_Varios" id= "fx_x_Archivos_Varios" value="<?php echo $estado_actual_legajo_persona->Archivos_Varios->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Archivos_Varios" id= "fm_x_Archivos_Varios" value="<?php echo $estado_actual_legajo_persona->Archivos_Varios->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Archivos_Varios" id= "fc_x_Archivos_Varios" value="<?php echo $estado_actual_legajo_persona->Archivos_Varios->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Archivos_Varios" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $estado_actual_legajo_persona->Archivos_Varios->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if (strval($estado_actual_legajo_persona->Dni->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Dni" id="x_Dni" value="<?php echo ew_HtmlEncode(strval($estado_actual_legajo_persona->Dni->getSessionValue())) ?>">
<?php } ?>
<?php if (!$estado_actual_legajo_persona_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $estado_actual_legajo_persona_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festado_actual_legajo_personaadd.Init();
</script>
<?php
$estado_actual_legajo_persona_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_actual_legajo_persona_add->Page_Terminate();
?>
