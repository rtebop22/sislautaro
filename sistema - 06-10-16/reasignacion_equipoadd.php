<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "reasignacion_equipoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$reasignacion_equipo_add = NULL; // Initialize page object first

class creasignacion_equipo_add extends creasignacion_equipo {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'reasignacion_equipo';

	// Page object name
	var $PageObjName = 'reasignacion_equipo_add';

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

		// Table object (reasignacion_equipo)
		if (!isset($GLOBALS["reasignacion_equipo"]) || get_class($GLOBALS["reasignacion_equipo"]) == "creasignacion_equipo") {
			$GLOBALS["reasignacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reasignacion_equipo"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reasignacion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("reasignacion_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Reasignacion->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Reasignacion->SetVisibility();
		$this->Id_Motivo_Reasig->SetVisibility();

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
		global $EW_EXPORT, $reasignacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($reasignacion_equipo);
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
			if (@$_GET["Id_Reasignacion"] != "") {
				$this->Id_Reasignacion->setQueryStringValue($_GET["Id_Reasignacion"]);
				$this->setKey("Id_Reasignacion", $this->Id_Reasignacion->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Reasignacion", ""); // Clear key
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
					$this->Page_Terminate("reasignacion_equipolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "reasignacion_equipolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "reasignacion_equipoview.php")
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
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Reasignacion->CurrentValue = NULL;
		$this->Id_Reasignacion->OldValue = $this->Id_Reasignacion->CurrentValue;
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Observacion->CurrentValue = NULL;
		$this->Observacion->OldValue = $this->Observacion->CurrentValue;
		$this->Fecha_Reasignacion->CurrentValue = NULL;
		$this->Fecha_Reasignacion->OldValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Id_Motivo_Reasig->CurrentValue = NULL;
		$this->Id_Motivo_Reasig->OldValue = $this->Id_Motivo_Reasig->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Reasignacion->FldIsDetailKey) {
			$this->Id_Reasignacion->setFormValue($objForm->GetValue("x_Id_Reasignacion"));
		}
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		if (!$this->Fecha_Reasignacion->FldIsDetailKey) {
			$this->Fecha_Reasignacion->setFormValue($objForm->GetValue("x_Fecha_Reasignacion"));
		}
		if (!$this->Id_Motivo_Reasig->FldIsDetailKey) {
			$this->Id_Motivo_Reasig->setFormValue($objForm->GetValue("x_Id_Motivo_Reasig"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Reasignacion->CurrentValue = $this->Id_Reasignacion->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Fecha_Reasignacion->CurrentValue = $this->Fecha_Reasignacion->FormValue;
		$this->Id_Motivo_Reasig->CurrentValue = $this->Id_Motivo_Reasig->FormValue;
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
		$this->Id_Reasignacion->setDbValue($rs->fields('Id_Reasignacion'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Reasignacion->setDbValue($rs->fields('Fecha_Reasignacion'));
		$this->Id_Motivo_Reasig->setDbValue($rs->fields('Id_Motivo_Reasig'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Reasignacion->DbValue = $row['Id_Reasignacion'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Reasignacion->DbValue = $row['Fecha_Reasignacion'];
		$this->Id_Motivo_Reasig->DbValue = $row['Id_Motivo_Reasig'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Reasignacion")) <> "")
			$this->Id_Reasignacion->CurrentValue = $this->getKey("Id_Reasignacion"); // Id_Reasignacion
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
		// Id_Reasignacion
		// Dni
		// NroSerie
		// Observacion
		// Fecha_Reasignacion
		// Id_Motivo_Reasig

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Reasignacion
		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

			// Id_Reasignacion
			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";
			$this->Id_Reasignacion->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";
			$this->Fecha_Reasignacion->TooltipValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
			$this->Id_Motivo_Reasig->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Reasignacion
			$this->Id_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Id_Reasignacion->EditCustomAttributes = "";
			$this->Id_Reasignacion->EditValue = ew_HtmlEncode($this->Id_Reasignacion->CurrentValue);
			$this->Id_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Id_Reasignacion->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Reasignacion->EditCustomAttributes = "";
			$this->Fecha_Reasignacion->EditValue = ew_HtmlEncode($this->Fecha_Reasignacion->CurrentValue);
			$this->Fecha_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Reasignacion->FldCaption());

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Reasig->EditCustomAttributes = "";
			$this->Id_Motivo_Reasig->EditValue = ew_HtmlEncode($this->Id_Motivo_Reasig->CurrentValue);
			$this->Id_Motivo_Reasig->PlaceHolder = ew_RemoveHtml($this->Id_Motivo_Reasig->FldCaption());

			// Add refer script
			// Id_Reasignacion

			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
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
		if (!$this->Id_Reasignacion->FldIsDetailKey && !is_null($this->Id_Reasignacion->FormValue) && $this->Id_Reasignacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Reasignacion->FldCaption(), $this->Id_Reasignacion->ReqErrMsg));
		}
		if (!$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
		}
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Id_Motivo_Reasig->FldIsDetailKey && !is_null($this->Id_Motivo_Reasig->FormValue) && $this->Id_Motivo_Reasig->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo_Reasig->FldCaption(), $this->Id_Motivo_Reasig->ReqErrMsg));
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Id_Reasignacion
		$this->Id_Reasignacion->SetDbValueDef($rsnew, $this->Id_Reasignacion->CurrentValue, "", FALSE);

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Observacion
		$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, FALSE);

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->SetDbValueDef($rsnew, $this->Fecha_Reasignacion->CurrentValue, NULL, FALSE);

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->SetDbValueDef($rsnew, $this->Id_Motivo_Reasig->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Id_Reasignacion']) == "") {
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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reasignacion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
		$table = 'reasignacion_equipo';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'reasignacion_equipo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Reasignacion'];

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
if (!isset($reasignacion_equipo_add)) $reasignacion_equipo_add = new creasignacion_equipo_add();

// Page init
$reasignacion_equipo_add->Page_Init();

// Page main
$reasignacion_equipo_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reasignacion_equipo_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = freasignacion_equipoadd = new ew_Form("freasignacion_equipoadd", "add");

// Validate form
freasignacion_equipoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Reasignacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Id_Reasignacion->FldCaption(), $reasignacion_equipo->Id_Reasignacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Dni->FldCaption(), $reasignacion_equipo->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->NroSerie->FldCaption(), $reasignacion_equipo->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo_Reasig");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Id_Motivo_Reasig->FldCaption(), $reasignacion_equipo->Id_Motivo_Reasig->ReqErrMsg)) ?>");

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
freasignacion_equipoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freasignacion_equipoadd.ValidateRequired = true;
<?php } else { ?>
freasignacion_equipoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$reasignacion_equipo_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reasignacion_equipo_add->ShowPageHeader(); ?>
<?php
$reasignacion_equipo_add->ShowMessage();
?>
<form name="freasignacion_equipoadd" id="freasignacion_equipoadd" class="<?php echo $reasignacion_equipo_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($reasignacion_equipo_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $reasignacion_equipo_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reasignacion_equipo">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($reasignacion_equipo_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($reasignacion_equipo->Id_Reasignacion->Visible) { // Id_Reasignacion ?>
	<div id="r_Id_Reasignacion" class="form-group">
		<label id="elh_reasignacion_equipo_Id_Reasignacion" for="x_Id_Reasignacion" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->Id_Reasignacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Id_Reasignacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Id_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Id_Reasignacion" name="x_Id_Reasignacion" id="x_Id_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Id_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Id_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Id_Reasignacion->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Id_Reasignacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label id="elh_reasignacion_equipo_Dni" for="x_Dni" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->Dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Dni->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Dni">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni->EditValue ?>"<?php echo $reasignacion_equipo->Dni->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_reasignacion_equipo_NroSerie" for="x_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->NroSerie->CellAttributes() ?>>
<span id="el_reasignacion_equipo_NroSerie">
<input type="text" data-table="reasignacion_equipo" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->NroSerie->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->NroSerie->EditValue ?>"<?php echo $reasignacion_equipo->NroSerie->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label id="elh_reasignacion_equipo_Observacion" for="x_Observacion" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Observacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Observacion">
<textarea data-table="reasignacion_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Observacion->getPlaceHolder()) ?>"<?php echo $reasignacion_equipo->Observacion->EditAttributes() ?>><?php echo $reasignacion_equipo->Observacion->EditValue ?></textarea>
</span>
<?php echo $reasignacion_equipo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Reasignacion->Visible) { // Fecha_Reasignacion ?>
	<div id="r_Fecha_Reasignacion" class="form-group">
		<label id="elh_reasignacion_equipo_Fecha_Reasignacion" for="x_Fecha_Reasignacion" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->Fecha_Reasignacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Fecha_Reasignacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Fecha_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Fecha_Reasignacion" name="x_Fecha_Reasignacion" id="x_Fecha_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Fecha_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Fecha_Reasignacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Id_Motivo_Reasig->Visible) { // Id_Motivo_Reasig ?>
	<div id="r_Id_Motivo_Reasig" class="form-group">
		<label id="elh_reasignacion_equipo_Id_Motivo_Reasig" for="x_Id_Motivo_Reasig" class="col-sm-2 control-label ewLabel"><?php echo $reasignacion_equipo->Id_Motivo_Reasig->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Id_Motivo_Reasig">
<input type="text" data-table="reasignacion_equipo" data-field="x_Id_Motivo_Reasig" name="x_Id_Motivo_Reasig" id="x_Id_Motivo_Reasig" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Id_Motivo_Reasig->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditValue ?>"<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$reasignacion_equipo_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $reasignacion_equipo_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freasignacion_equipoadd.Init();
</script>
<?php
$reasignacion_equipo_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$reasignacion_equipo_add->Page_Terminate();
?>
