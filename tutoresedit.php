<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tutoresinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "observacion_tutorgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tutores_edit = NULL; // Initialize page object first

class ctutores_edit extends ctutores {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'tutores';

	// Page object name
	var $PageObjName = 'tutores_edit';

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

		// Table object (tutores)
		if (!isset($GLOBALS["tutores"]) || get_class($GLOBALS["tutores"]) == "ctutores") {
			$GLOBALS["tutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tutores"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tutores', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tutoreslist.php"));
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
		$this->Dni_Tutor->SetVisibility();
		$this->Apellidos_Nombres->SetVisibility();
		$this->Edad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Tel_Contacto->SetVisibility();
		$this->Fecha_Nac->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->MasHijos->SetVisibility();
		$this->Id_Estado_Civil->SetVisibility();
		$this->Id_Sexo->SetVisibility();
		$this->Id_Relacion->SetVisibility();
		$this->Id_Ocupacion->SetVisibility();
		$this->Lugar_Nacimiento->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

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

			// Process auto fill for detail table 'observacion_tutor'
			if (@$_POST["grid"] == "fobservacion_tutorgrid") {
				if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid;
				$GLOBALS["observacion_tutor_grid"]->Page_Init();
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
		global $EW_EXPORT, $tutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tutores);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["Dni_Tutor"] <> "") {
			$this->Dni_Tutor->setQueryStringValue($_GET["Dni_Tutor"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Dni_Tutor->CurrentValue == "") {
			$this->Page_Terminate("tutoreslist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tutoreslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tutoreslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		if (!$this->Apellidos_Nombres->FldIsDetailKey) {
			$this->Apellidos_Nombres->setFormValue($objForm->GetValue("x_Apellidos_Nombres"));
		}
		if (!$this->Edad->FldIsDetailKey) {
			$this->Edad->setFormValue($objForm->GetValue("x_Edad"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Tel_Contacto->FldIsDetailKey) {
			$this->Tel_Contacto->setFormValue($objForm->GetValue("x_Tel_Contacto"));
		}
		if (!$this->Fecha_Nac->FldIsDetailKey) {
			$this->Fecha_Nac->setFormValue($objForm->GetValue("x_Fecha_Nac"));
			$this->Fecha_Nac->CurrentValue = ew_UnFormatDateTime($this->Fecha_Nac->CurrentValue, 7);
		}
		if (!$this->Cuil->FldIsDetailKey) {
			$this->Cuil->setFormValue($objForm->GetValue("x_Cuil"));
		}
		if (!$this->MasHijos->FldIsDetailKey) {
			$this->MasHijos->setFormValue($objForm->GetValue("x_MasHijos"));
		}
		if (!$this->Id_Estado_Civil->FldIsDetailKey) {
			$this->Id_Estado_Civil->setFormValue($objForm->GetValue("x_Id_Estado_Civil"));
		}
		if (!$this->Id_Sexo->FldIsDetailKey) {
			$this->Id_Sexo->setFormValue($objForm->GetValue("x_Id_Sexo"));
		}
		if (!$this->Id_Relacion->FldIsDetailKey) {
			$this->Id_Relacion->setFormValue($objForm->GetValue("x_Id_Relacion"));
		}
		if (!$this->Id_Ocupacion->FldIsDetailKey) {
			$this->Id_Ocupacion->setFormValue($objForm->GetValue("x_Id_Ocupacion"));
		}
		if (!$this->Lugar_Nacimiento->FldIsDetailKey) {
			$this->Lugar_Nacimiento->setFormValue($objForm->GetValue("x_Lugar_Nacimiento"));
		}
		if (!$this->Id_Provincia->FldIsDetailKey) {
			$this->Id_Provincia->setFormValue($objForm->GetValue("x_Id_Provincia"));
		}
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Apellidos_Nombres->CurrentValue = $this->Apellidos_Nombres->FormValue;
		$this->Edad->CurrentValue = $this->Edad->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Tel_Contacto->CurrentValue = $this->Tel_Contacto->FormValue;
		$this->Fecha_Nac->CurrentValue = $this->Fecha_Nac->FormValue;
		$this->Fecha_Nac->CurrentValue = ew_UnFormatDateTime($this->Fecha_Nac->CurrentValue, 7);
		$this->Cuil->CurrentValue = $this->Cuil->FormValue;
		$this->MasHijos->CurrentValue = $this->MasHijos->FormValue;
		$this->Id_Estado_Civil->CurrentValue = $this->Id_Estado_Civil->FormValue;
		$this->Id_Sexo->CurrentValue = $this->Id_Sexo->FormValue;
		$this->Id_Relacion->CurrentValue = $this->Id_Relacion->FormValue;
		$this->Id_Ocupacion->CurrentValue = $this->Id_Ocupacion->FormValue;
		$this->Lugar_Nacimiento->CurrentValue = $this->Lugar_Nacimiento->FormValue;
		$this->Id_Provincia->CurrentValue = $this->Id_Provincia->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
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
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Apellidos_Nombres->DbValue = $row['Apellidos_Nombres'];
		$this->Edad->DbValue = $row['Edad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Tel_Contacto->DbValue = $row['Tel_Contacto'];
		$this->Fecha_Nac->DbValue = $row['Fecha_Nac'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->MasHijos->DbValue = $row['MasHijos'];
		$this->Id_Estado_Civil->DbValue = $row['Id_Estado_Civil'];
		$this->Id_Sexo->DbValue = $row['Id_Sexo'];
		$this->Id_Relacion->DbValue = $row['Id_Relacion'];
		$this->Id_Ocupacion->DbValue = $row['Id_Ocupacion'];
		$this->Lugar_Nacimiento->DbValue = $row['Lugar_Nacimiento'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		$sSqlWrk .= " ORDER BY `Desripcion` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

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

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
			$this->Dni_Tutor->ViewCustomAttributes = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

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
			$this->Fecha_Nac->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Nac->CurrentValue, 7));
			$this->Fecha_Nac->PlaceHolder = ew_RemoveHtml($this->Fecha_Nac->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// MasHijos
			$this->MasHijos->EditCustomAttributes = "";
			$this->MasHijos->EditValue = $this->MasHijos->Options(FALSE);

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

			// Id_Relacion
			$this->Id_Relacion->EditAttrs["class"] = "form-control";
			$this->Id_Relacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Relacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Desripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Relacion->EditValue = $arwrk;

			// Id_Ocupacion
			$this->Id_Ocupacion->EditAttrs["class"] = "form-control";
			$this->Id_Ocupacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ocupacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ocupacion`" . ew_SearchString("=", $this->Id_Ocupacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ocupacion_tutor`";
			$sWhereWrk = "";
			$this->Id_Ocupacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ocupacion->EditValue = $arwrk;

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->EditAttrs["class"] = "form-control";
			$this->Lugar_Nacimiento->EditCustomAttributes = "";
			$this->Lugar_Nacimiento->EditValue = ew_HtmlEncode($this->Lugar_Nacimiento->CurrentValue);
			$this->Lugar_Nacimiento->PlaceHolder = ew_RemoveHtml($this->Lugar_Nacimiento->FldCaption());

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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Dni_Tutor

			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

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

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// MasHijos
			$this->MasHijos->LinkCustomAttributes = "";
			$this->MasHijos->HrefValue = "";

			// Id_Estado_Civil
			$this->Id_Estado_Civil->LinkCustomAttributes = "";
			$this->Id_Estado_Civil->HrefValue = "";

			// Id_Sexo
			$this->Id_Sexo->LinkCustomAttributes = "";
			$this->Id_Sexo->HrefValue = "";

			// Id_Relacion
			$this->Id_Relacion->LinkCustomAttributes = "";
			$this->Id_Relacion->HrefValue = "";

			// Id_Ocupacion
			$this->Id_Ocupacion->LinkCustomAttributes = "";
			$this->Id_Ocupacion->HrefValue = "";

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->LinkCustomAttributes = "";
			$this->Lugar_Nacimiento->HrefValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

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
		if (!$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni_Tutor->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni_Tutor->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Edad->FormValue)) {
			ew_AddMessage($gsFormError, $this->Edad->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Tel_Contacto->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tel_Contacto->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Nac->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Nac->FldErrMsg());
		}
		if (!$this->Id_Estado_Civil->FldIsDetailKey && !is_null($this->Id_Estado_Civil->FormValue) && $this->Id_Estado_Civil->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Civil->FldCaption(), $this->Id_Estado_Civil->ReqErrMsg));
		}
		if (!$this->Id_Sexo->FldIsDetailKey && !is_null($this->Id_Sexo->FormValue) && $this->Id_Sexo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Sexo->FldCaption(), $this->Id_Sexo->ReqErrMsg));
		}
		if (!$this->Id_Relacion->FldIsDetailKey && !is_null($this->Id_Relacion->FormValue) && $this->Id_Relacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Relacion->FldCaption(), $this->Id_Relacion->ReqErrMsg));
		}
		if (!$this->Id_Ocupacion->FldIsDetailKey && !is_null($this->Id_Ocupacion->FormValue) && $this->Id_Ocupacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ocupacion->FldCaption(), $this->Id_Ocupacion->ReqErrMsg));
		}
		if (!$this->Id_Provincia->FldIsDetailKey && !is_null($this->Id_Provincia->FormValue) && $this->Id_Provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Provincia->FldCaption(), $this->Id_Provincia->ReqErrMsg));
		}
		if (!$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if (!$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("observacion_tutor", $DetailTblVar) && $GLOBALS["observacion_tutor"]->DetailEdit) {
			if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid(); // get detail page object
			$GLOBALS["observacion_tutor_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Dni_Tutor
			// Apellidos_Nombres

			$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, $this->Apellidos_Nombres->ReadOnly);

			// Edad
			$this->Edad->SetDbValueDef($rsnew, $this->Edad->CurrentValue, NULL, $this->Edad->ReadOnly);

			// Domicilio
			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly);

			// Tel_Contacto
			$this->Tel_Contacto->SetDbValueDef($rsnew, $this->Tel_Contacto->CurrentValue, NULL, $this->Tel_Contacto->ReadOnly);

			// Fecha_Nac
			$this->Fecha_Nac->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Nac->CurrentValue, 7), NULL, $this->Fecha_Nac->ReadOnly);

			// Cuil
			$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, $this->Cuil->ReadOnly);

			// MasHijos
			$this->MasHijos->SetDbValueDef($rsnew, $this->MasHijos->CurrentValue, NULL, $this->MasHijos->ReadOnly);

			// Id_Estado_Civil
			$this->Id_Estado_Civil->SetDbValueDef($rsnew, $this->Id_Estado_Civil->CurrentValue, 0, $this->Id_Estado_Civil->ReadOnly);

			// Id_Sexo
			$this->Id_Sexo->SetDbValueDef($rsnew, $this->Id_Sexo->CurrentValue, 0, $this->Id_Sexo->ReadOnly);

			// Id_Relacion
			$this->Id_Relacion->SetDbValueDef($rsnew, $this->Id_Relacion->CurrentValue, 0, $this->Id_Relacion->ReadOnly);

			// Id_Ocupacion
			$this->Id_Ocupacion->SetDbValueDef($rsnew, $this->Id_Ocupacion->CurrentValue, 0, $this->Id_Ocupacion->ReadOnly);

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->SetDbValueDef($rsnew, $this->Lugar_Nacimiento->CurrentValue, NULL, $this->Lugar_Nacimiento->ReadOnly);

			// Id_Provincia
			$this->Id_Provincia->SetDbValueDef($rsnew, $this->Id_Provincia->CurrentValue, 0, $this->Id_Provincia->ReadOnly);

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly);

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly);

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

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
				}

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("observacion_tutor", $DetailTblVar) && $GLOBALS["observacion_tutor"]->DetailEdit) {
						if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "observacion_tutor"); // Load user level of detail table
						$EditRow = $GLOBALS["observacion_tutor_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
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
		return $EditRow;
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
				if (@$_GET["fk_Dni_Tutor"] <> "") {
					$GLOBALS["personas"]->Dni_Tutor->setQueryStringValue($_GET["fk_Dni_Tutor"]);
					$this->Dni_Tutor->setQueryStringValue($GLOBALS["personas"]->Dni_Tutor->QueryStringValue);
					$this->Dni_Tutor->setSessionValue($this->Dni_Tutor->QueryStringValue);
					if (!is_numeric($GLOBALS["personas"]->Dni_Tutor->QueryStringValue)) $bValidMaster = FALSE;
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
				if (@$_POST["fk_Dni_Tutor"] <> "") {
					$GLOBALS["personas"]->Dni_Tutor->setFormValue($_POST["fk_Dni_Tutor"]);
					$this->Dni_Tutor->setFormValue($GLOBALS["personas"]->Dni_Tutor->FormValue);
					$this->Dni_Tutor->setSessionValue($this->Dni_Tutor->FormValue);
					if (!is_numeric($GLOBALS["personas"]->Dni_Tutor->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "personas") {
				if ($this->Dni_Tutor->CurrentValue == "") $this->Dni_Tutor->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (in_array("observacion_tutor", $DetailTblVar)) {
				if (!isset($GLOBALS["observacion_tutor_grid"]))
					$GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid;
				if ($GLOBALS["observacion_tutor_grid"]->DetailEdit) {
					$GLOBALS["observacion_tutor_grid"]->CurrentMode = "edit";
					$GLOBALS["observacion_tutor_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["observacion_tutor_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["observacion_tutor_grid"]->setStartRecordNumber(1);
					$GLOBALS["observacion_tutor_grid"]->Dni_Tutor->FldIsDetailKey = TRUE;
					$GLOBALS["observacion_tutor_grid"]->Dni_Tutor->CurrentValue = $this->Dni_Tutor->CurrentValue;
					$GLOBALS["observacion_tutor_grid"]->Dni_Tutor->setSessionValue($GLOBALS["observacion_tutor_grid"]->Dni_Tutor->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tutoreslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
		case "x_Id_Relacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Relacion` AS `LinkFld`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Relacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Desripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Ocupacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ocupacion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
			$sWhereWrk = "";
			$this->Id_Ocupacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ocupacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$table = 'tutores';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tutores';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni_Tutor'];

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
if (!isset($tutores_edit)) $tutores_edit = new ctutores_edit();

// Page init
$tutores_edit->Page_Init();

// Page main
$tutores_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tutores_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftutoresedit = new ew_Form("ftutoresedit", "edit");

// Validate form
ftutoresedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Dni_Tutor->FldCaption(), $tutores->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Edad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Edad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tel_Contacto");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Tel_Contacto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Nac");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Fecha_Nac->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Civil");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Estado_Civil->FldCaption(), $tutores->Id_Estado_Civil->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Sexo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Sexo->FldCaption(), $tutores->Id_Sexo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Relacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Relacion->FldCaption(), $tutores->Id_Relacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ocupacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Ocupacion->FldCaption(), $tutores->Id_Ocupacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Provincia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Provincia->FldCaption(), $tutores->Id_Provincia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Departamento->FldCaption(), $tutores->Id_Departamento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Localidad->FldCaption(), $tutores->Id_Localidad->ReqErrMsg)) ?>");

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
ftutoresedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftutoresedit.ValidateRequired = true;
<?php } else { ?>
ftutoresedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftutoresedit.Lists["x_MasHijos"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftutoresedit.Lists["x_MasHijos"].Options = <?php echo json_encode($tutores->MasHijos->Options()) ?>;
ftutoresedit.Lists["x_Id_Estado_Civil"] = {"LinkField":"x_Id_Estado_Civil","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_civil"};
ftutoresedit.Lists["x_Id_Sexo"] = {"LinkField":"x_Id_Sexo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sexo_personas"};
ftutoresedit.Lists["x_Id_Relacion"] = {"LinkField":"x_Id_Relacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Desripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_relacion_alumno_tutor"};
ftutoresedit.Lists["x_Id_Ocupacion"] = {"LinkField":"x_Id_Ocupacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ocupacion_tutor"};
ftutoresedit.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
ftutoresedit.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
ftutoresedit.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tutores_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tutores_edit->ShowPageHeader(); ?>
<?php
$tutores_edit->ShowMessage();
?>
<form name="ftutoresedit" id="ftutoresedit" class="<?php echo $tutores_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tutores_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tutores_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tutores">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tutores_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($tutores->getCurrentMasterTable() == "personas") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_Dni_Tutor" value="<?php echo $tutores->Dni_Tutor->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label id="elh_tutores_Dni_Tutor" for="x_Dni_Tutor" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Dni_Tutor->CellAttributes() ?>>
<span id="el_tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php echo $tutores->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<div id="r_Apellidos_Nombres" class="form-group">
		<label id="elh_tutores_Apellidos_Nombres" for="x_Apellidos_Nombres" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Apellidos_Nombres->CellAttributes() ?>>
<span id="el_tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x_Apellidos_Nombres" id="x_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php echo $tutores->Apellidos_Nombres->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Edad->Visible) { // Edad ?>
	<div id="r_Edad" class="form-group">
		<label id="elh_tutores_Edad" for="x_Edad" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Edad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Edad->CellAttributes() ?>>
<span id="el_tutores_Edad">
<input type="text" data-table="tutores" data-field="x_Edad" name="x_Edad" id="x_Edad" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($tutores->Edad->getPlaceHolder()) ?>" value="<?php echo $tutores->Edad->EditValue ?>"<?php echo $tutores->Edad->EditAttributes() ?>>
</span>
<?php echo $tutores->Edad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label id="elh_tutores_Domicilio" for="x_Domicilio" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Domicilio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Domicilio->CellAttributes() ?>>
<span id="el_tutores_Domicilio">
<input type="text" data-table="tutores" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Domicilio->getPlaceHolder()) ?>" value="<?php echo $tutores->Domicilio->EditValue ?>"<?php echo $tutores->Domicilio->EditAttributes() ?>>
</span>
<?php echo $tutores->Domicilio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
	<div id="r_Tel_Contacto" class="form-group">
		<label id="elh_tutores_Tel_Contacto" for="x_Tel_Contacto" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Tel_Contacto->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Tel_Contacto->CellAttributes() ?>>
<span id="el_tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x_Tel_Contacto" id="x_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<?php echo $tutores->Tel_Contacto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Fecha_Nac->Visible) { // Fecha_Nac ?>
	<div id="r_Fecha_Nac" class="form-group">
		<label id="elh_tutores_Fecha_Nac" for="x_Fecha_Nac" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Fecha_Nac->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Fecha_Nac->CellAttributes() ?>>
<span id="el_tutores_Fecha_Nac">
<input type="text" data-table="tutores" data-field="x_Fecha_Nac" data-format="7" name="x_Fecha_Nac" id="x_Fecha_Nac" placeholder="<?php echo ew_HtmlEncode($tutores->Fecha_Nac->getPlaceHolder()) ?>" value="<?php echo $tutores->Fecha_Nac->EditValue ?>"<?php echo $tutores->Fecha_Nac->EditAttributes() ?>>
<?php if (!$tutores->Fecha_Nac->ReadOnly && !$tutores->Fecha_Nac->Disabled && !isset($tutores->Fecha_Nac->EditAttrs["readonly"]) && !isset($tutores->Fecha_Nac->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftutoresedit", "x_Fecha_Nac", 7);
</script>
<?php } ?>
</span>
<?php echo $tutores->Fecha_Nac->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Cuil->Visible) { // Cuil ?>
	<div id="r_Cuil" class="form-group">
		<label id="elh_tutores_Cuil" for="x_Cuil" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Cuil->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Cuil->CellAttributes() ?>>
<span id="el_tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x_Cuil" id="x_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<?php echo $tutores->Cuil->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->MasHijos->Visible) { // MasHijos ?>
	<div id="r_MasHijos" class="form-group">
		<label id="elh_tutores_MasHijos" class="col-sm-2 control-label ewLabel"><?php echo $tutores->MasHijos->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->MasHijos->CellAttributes() ?>>
<span id="el_tutores_MasHijos">
<div id="tp_x_MasHijos" class="ewTemplate"><input type="radio" data-table="tutores" data-field="x_MasHijos" data-value-separator="<?php echo $tutores->MasHijos->DisplayValueSeparatorAttribute() ?>" name="x_MasHijos" id="x_MasHijos" value="{value}"<?php echo $tutores->MasHijos->EditAttributes() ?>></div>
<div id="dsl_x_MasHijos" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tutores->MasHijos->RadioButtonListHtml(FALSE, "x_MasHijos") ?>
</div></div>
</span>
<?php echo $tutores->MasHijos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Estado_Civil->Visible) { // Id_Estado_Civil ?>
	<div id="r_Id_Estado_Civil" class="form-group">
		<label id="elh_tutores_Id_Estado_Civil" for="x_Id_Estado_Civil" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Estado_Civil->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Estado_Civil->CellAttributes() ?>>
<span id="el_tutores_Id_Estado_Civil">
<select data-table="tutores" data-field="x_Id_Estado_Civil" data-value-separator="<?php echo $tutores->Id_Estado_Civil->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Civil" name="x_Id_Estado_Civil"<?php echo $tutores->Id_Estado_Civil->EditAttributes() ?>>
<?php echo $tutores->Id_Estado_Civil->SelectOptionListHtml("x_Id_Estado_Civil") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Civil" id="s_x_Id_Estado_Civil" value="<?php echo $tutores->Id_Estado_Civil->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Estado_Civil->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Sexo->Visible) { // Id_Sexo ?>
	<div id="r_Id_Sexo" class="form-group">
		<label id="elh_tutores_Id_Sexo" for="x_Id_Sexo" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Sexo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Sexo->CellAttributes() ?>>
<span id="el_tutores_Id_Sexo">
<select data-table="tutores" data-field="x_Id_Sexo" data-value-separator="<?php echo $tutores->Id_Sexo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Sexo" name="x_Id_Sexo"<?php echo $tutores->Id_Sexo->EditAttributes() ?>>
<?php echo $tutores->Id_Sexo->SelectOptionListHtml("x_Id_Sexo") ?>
</select>
<input type="hidden" name="s_x_Id_Sexo" id="s_x_Id_Sexo" value="<?php echo $tutores->Id_Sexo->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
	<div id="r_Id_Relacion" class="form-group">
		<label id="elh_tutores_Id_Relacion" for="x_Id_Relacion" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Relacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Relacion->CellAttributes() ?>>
<span id="el_tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Relacion" name="x_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x_Id_Relacion" id="s_x_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Relacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Ocupacion->Visible) { // Id_Ocupacion ?>
	<div id="r_Id_Ocupacion" class="form-group">
		<label id="elh_tutores_Id_Ocupacion" for="x_Id_Ocupacion" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Ocupacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Ocupacion->CellAttributes() ?>>
<span id="el_tutores_Id_Ocupacion">
<select data-table="tutores" data-field="x_Id_Ocupacion" data-value-separator="<?php echo $tutores->Id_Ocupacion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Ocupacion" name="x_Id_Ocupacion"<?php echo $tutores->Id_Ocupacion->EditAttributes() ?>>
<?php echo $tutores->Id_Ocupacion->SelectOptionListHtml("x_Id_Ocupacion") ?>
</select>
<input type="hidden" name="s_x_Id_Ocupacion" id="s_x_Id_Ocupacion" value="<?php echo $tutores->Id_Ocupacion->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Ocupacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Lugar_Nacimiento->Visible) { // Lugar_Nacimiento ?>
	<div id="r_Lugar_Nacimiento" class="form-group">
		<label id="elh_tutores_Lugar_Nacimiento" for="x_Lugar_Nacimiento" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Lugar_Nacimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Lugar_Nacimiento->CellAttributes() ?>>
<span id="el_tutores_Lugar_Nacimiento">
<input type="text" data-table="tutores" data-field="x_Lugar_Nacimiento" name="x_Lugar_Nacimiento" id="x_Lugar_Nacimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tutores->Lugar_Nacimiento->getPlaceHolder()) ?>" value="<?php echo $tutores->Lugar_Nacimiento->EditValue ?>"<?php echo $tutores->Lugar_Nacimiento->EditAttributes() ?>>
</span>
<?php echo $tutores->Lugar_Nacimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Provincia->Visible) { // Id_Provincia ?>
	<div id="r_Id_Provincia" class="form-group">
		<label id="elh_tutores_Id_Provincia" for="x_Id_Provincia" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Provincia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Provincia->CellAttributes() ?>>
<span id="el_tutores_Id_Provincia">
<?php $tutores->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$tutores->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="tutores" data-field="x_Id_Provincia" data-value-separator="<?php echo $tutores->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x_Id_Provincia" name="x_Id_Provincia"<?php echo $tutores->Id_Provincia->EditAttributes() ?>>
<?php echo $tutores->Id_Provincia->SelectOptionListHtml("x_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x_Id_Provincia" id="s_x_Id_Provincia" value="<?php echo $tutores->Id_Provincia->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label id="elh_tutores_Id_Departamento" for="x_Id_Departamento" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Departamento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Departamento->CellAttributes() ?>>
<span id="el_tutores_Id_Departamento">
<?php $tutores->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$tutores->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="tutores" data-field="x_Id_Departamento" data-value-separator="<?php echo $tutores->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $tutores->Id_Departamento->EditAttributes() ?>>
<?php echo $tutores->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $tutores->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Departamento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label id="elh_tutores_Id_Localidad" for="x_Id_Localidad" class="col-sm-2 control-label ewLabel"><?php echo $tutores->Id_Localidad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tutores->Id_Localidad->CellAttributes() ?>>
<span id="el_tutores_Id_Localidad">
<select data-table="tutores" data-field="x_Id_Localidad" data-value-separator="<?php echo $tutores->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $tutores->Id_Localidad->EditAttributes() ?>>
<?php echo $tutores->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $tutores->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php echo $tutores->Id_Localidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("observacion_tutor", explode(",", $tutores->getCurrentDetailTable())) && $observacion_tutor->DetailEdit) {
?>
<?php if ($tutores->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("observacion_tutor", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "observacion_tutorgrid.php" ?>
<?php } ?>
<?php if (!$tutores_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tutores_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftutoresedit.Init();
</script>
<?php
$tutores_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tutores_edit->Page_Terminate();
?>
