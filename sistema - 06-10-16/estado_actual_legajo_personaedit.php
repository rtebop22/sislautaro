<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "estado_actual_legajo_personainfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$estado_actual_legajo_persona_edit = NULL; // Initialize page object first

class cestado_actual_legajo_persona_edit extends cestado_actual_legajo_persona {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'estado_actual_legajo_persona';

	// Page object name
	var $PageObjName = 'estado_actual_legajo_persona_edit';

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

		// Table object (estado_actual_legajo_persona)
		if (!isset($GLOBALS["estado_actual_legajo_persona"]) || get_class($GLOBALS["estado_actual_legajo_persona"]) == "cestado_actual_legajo_persona") {
			$GLOBALS["estado_actual_legajo_persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_actual_legajo_persona"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_actual_legajo_persona', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("estado_actual_legajo_personalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
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
		if (@$_GET["Dni"] <> "") {
			$this->Dni->setQueryStringValue($_GET["Dni"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Dni->CurrentValue == "") {
			$this->Page_Terminate("estado_actual_legajo_personalist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("estado_actual_legajo_personalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "estado_actual_legajo_personalist.php")
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
		if (!$this->Dni->FldIsDetailKey)
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Matricula->CurrentValue = $this->Matricula->FormValue;
		$this->Certificado_Pase->CurrentValue = $this->Certificado_Pase->FormValue;
		$this->Tiene_DNI->CurrentValue = $this->Tiene_DNI->FormValue;
		$this->Certificado_Medico->CurrentValue = $this->Certificado_Medico->FormValue;
		$this->Posee_Autorizacion->CurrentValue = $this->Posee_Autorizacion->FormValue;
		$this->Cooperadora->CurrentValue = $this->Cooperadora->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Matricula
			$this->Matricula->EditAttrs["class"] = "form-control";
			$this->Matricula->EditCustomAttributes = "";
			$this->Matricula->EditValue = $this->Matricula->Options(TRUE);

			// Certificado_Pase
			$this->Certificado_Pase->EditAttrs["class"] = "form-control";
			$this->Certificado_Pase->EditCustomAttributes = "";
			$this->Certificado_Pase->EditValue = $this->Certificado_Pase->Options(TRUE);

			// Tiene_DNI
			$this->Tiene_DNI->EditAttrs["class"] = "form-control";
			$this->Tiene_DNI->EditCustomAttributes = "";
			$this->Tiene_DNI->EditValue = $this->Tiene_DNI->Options(TRUE);

			// Certificado_Medico
			$this->Certificado_Medico->EditAttrs["class"] = "form-control";
			$this->Certificado_Medico->EditCustomAttributes = "";
			$this->Certificado_Medico->EditValue = $this->Certificado_Medico->Options(TRUE);

			// Posee_Autorizacion
			$this->Posee_Autorizacion->EditAttrs["class"] = "form-control";
			$this->Posee_Autorizacion->EditCustomAttributes = "";
			$this->Posee_Autorizacion->EditValue = $this->Posee_Autorizacion->Options(TRUE);

			// Cooperadora
			$this->Cooperadora->EditAttrs["class"] = "form-control";
			$this->Cooperadora->EditCustomAttributes = "";
			$this->Cooperadora->EditValue = $this->Cooperadora->Options(TRUE);

			// Edit refer script
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
			$rsnew = array();

			// Matricula
			$this->Matricula->SetDbValueDef($rsnew, $this->Matricula->CurrentValue, NULL, $this->Matricula->ReadOnly);

			// Certificado_Pase
			$this->Certificado_Pase->SetDbValueDef($rsnew, $this->Certificado_Pase->CurrentValue, NULL, $this->Certificado_Pase->ReadOnly);

			// Tiene_DNI
			$this->Tiene_DNI->SetDbValueDef($rsnew, $this->Tiene_DNI->CurrentValue, NULL, $this->Tiene_DNI->ReadOnly);

			// Certificado_Medico
			$this->Certificado_Medico->SetDbValueDef($rsnew, $this->Certificado_Medico->CurrentValue, NULL, $this->Certificado_Medico->ReadOnly);

			// Posee_Autorizacion
			$this->Posee_Autorizacion->SetDbValueDef($rsnew, $this->Posee_Autorizacion->CurrentValue, NULL, $this->Posee_Autorizacion->ReadOnly);

			// Cooperadora
			$this->Cooperadora->SetDbValueDef($rsnew, $this->Cooperadora->CurrentValue, NULL, $this->Cooperadora->ReadOnly);

			// Check referential integrity for master table 'personas'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_personas();
			$KeyValue = isset($rsnew['Dni']) ? $rsnew['Dni'] : $rsold['Dni'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@Dni@", ew_AdjustSql($KeyValue), $sMasterFilter);
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
				$rs->Close();
				return FALSE;
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
			$this->setSessionWhere($this->GetDetailFilter());

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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($estado_actual_legajo_persona_edit)) $estado_actual_legajo_persona_edit = new cestado_actual_legajo_persona_edit();

// Page init
$estado_actual_legajo_persona_edit->Page_Init();

// Page main
$estado_actual_legajo_persona_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_actual_legajo_persona_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = festado_actual_legajo_personaedit = new ew_Form("festado_actual_legajo_personaedit", "edit");

// Validate form
festado_actual_legajo_personaedit.Validate = function() {
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
festado_actual_legajo_personaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_actual_legajo_personaedit.ValidateRequired = true;
<?php } else { ?>
festado_actual_legajo_personaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_actual_legajo_personaedit.Lists["x_Matricula"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Matricula"].Options = <?php echo json_encode($estado_actual_legajo_persona->Matricula->Options()) ?>;
festado_actual_legajo_personaedit.Lists["x_Certificado_Pase"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Certificado_Pase"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Pase->Options()) ?>;
festado_actual_legajo_personaedit.Lists["x_Tiene_DNI"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Tiene_DNI"].Options = <?php echo json_encode($estado_actual_legajo_persona->Tiene_DNI->Options()) ?>;
festado_actual_legajo_personaedit.Lists["x_Certificado_Medico"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Certificado_Medico"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Medico->Options()) ?>;
festado_actual_legajo_personaedit.Lists["x_Posee_Autorizacion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Posee_Autorizacion"].Options = <?php echo json_encode($estado_actual_legajo_persona->Posee_Autorizacion->Options()) ?>;
festado_actual_legajo_personaedit.Lists["x_Cooperadora"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personaedit.Lists["x_Cooperadora"].Options = <?php echo json_encode($estado_actual_legajo_persona->Cooperadora->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$estado_actual_legajo_persona_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estado_actual_legajo_persona_edit->ShowPageHeader(); ?>
<?php
$estado_actual_legajo_persona_edit->ShowMessage();
?>
<form name="festado_actual_legajo_personaedit" id="festado_actual_legajo_personaedit" class="<?php echo $estado_actual_legajo_persona_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_actual_legajo_persona_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_actual_legajo_persona_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_actual_legajo_persona">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($estado_actual_legajo_persona_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($estado_actual_legajo_persona->getCurrentMasterTable() == "personas") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_Dni" value="<?php echo $estado_actual_legajo_persona->Dni->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
	<div id="r_Matricula" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Matricula" for="x_Matricula" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Matricula->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Matricula->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Matricula">
<select data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" id="x_Matricula" name="x_Matricula"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Matricula->SelectOptionListHtml("x_Matricula") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Matricula->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
	<div id="r_Certificado_Pase" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Certificado_Pase" for="x_Certificado_Pase" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Certificado_Pase->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Certificado_Pase->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Certificado_Pase">
<select data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" id="x_Certificado_Pase" name="x_Certificado_Pase"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->SelectOptionListHtml("x_Certificado_Pase") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
	<div id="r_Tiene_DNI" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Tiene_DNI" for="x_Tiene_DNI" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Tiene_DNI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Tiene_DNI->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Tiene_DNI">
<select data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" id="x_Tiene_DNI" name="x_Tiene_DNI"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->SelectOptionListHtml("x_Tiene_DNI") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
	<div id="r_Certificado_Medico" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Certificado_Medico" for="x_Certificado_Medico" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Certificado_Medico->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Certificado_Medico->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Certificado_Medico">
<select data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" id="x_Certificado_Medico" name="x_Certificado_Medico"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->SelectOptionListHtml("x_Certificado_Medico") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
	<div id="r_Posee_Autorizacion" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Posee_Autorizacion" for="x_Posee_Autorizacion" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Posee_Autorizacion">
<select data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" id="x_Posee_Autorizacion" name="x_Posee_Autorizacion"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->SelectOptionListHtml("x_Posee_Autorizacion") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
	<div id="r_Cooperadora" class="form-group">
		<label id="elh_estado_actual_legajo_persona_Cooperadora" for="x_Cooperadora" class="col-sm-2 control-label ewLabel"><?php echo $estado_actual_legajo_persona->Cooperadora->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $estado_actual_legajo_persona->Cooperadora->CellAttributes() ?>>
<span id="el_estado_actual_legajo_persona_Cooperadora">
<select data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" id="x_Cooperadora" name="x_Cooperadora"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>>
<?php echo $estado_actual_legajo_persona->Cooperadora->SelectOptionListHtml("x_Cooperadora") ?>
</select>
</span>
<?php echo $estado_actual_legajo_persona->Cooperadora->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="estado_actual_legajo_persona" data-field="x_Dni" name="x_Dni" id="x_Dni" value="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Dni->CurrentValue) ?>">
<?php if (!$estado_actual_legajo_persona_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $estado_actual_legajo_persona_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festado_actual_legajo_personaedit.Init();
</script>
<?php
$estado_actual_legajo_persona_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_actual_legajo_persona_edit->Page_Terminate();
?>
