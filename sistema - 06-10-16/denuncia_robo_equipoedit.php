<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "denuncia_robo_equipoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$denuncia_robo_equipo_edit = NULL; // Initialize page object first

class cdenuncia_robo_equipo_edit extends cdenuncia_robo_equipo {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'denuncia_robo_equipo';

	// Page object name
	var $PageObjName = 'denuncia_robo_equipo_edit';

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

		// Table object (denuncia_robo_equipo)
		if (!isset($GLOBALS["denuncia_robo_equipo"]) || get_class($GLOBALS["denuncia_robo_equipo"]) == "cdenuncia_robo_equipo") {
			$GLOBALS["denuncia_robo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["denuncia_robo_equipo"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'denuncia_robo_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("denuncia_robo_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IdDenuncia->SetVisibility();
		$this->IdDenuncia->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->NroSerie->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Quien_Denuncia->SetVisibility();
		$this->DetalleDenuncia->SetVisibility();
		$this->Fecha_Denuncia->SetVisibility();
		$this->Id_Estado_Den->SetVisibility();

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
		global $EW_EXPORT, $denuncia_robo_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($denuncia_robo_equipo);
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
		if (@$_GET["IdDenuncia"] <> "") {
			$this->IdDenuncia->setQueryStringValue($_GET["IdDenuncia"]);
		}

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
		if ($this->IdDenuncia->CurrentValue == "") {
			$this->Page_Terminate("denuncia_robo_equipolist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("denuncia_robo_equipolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "denuncia_robo_equipolist.php")
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
		if (!$this->IdDenuncia->FldIsDetailKey)
			$this->IdDenuncia->setFormValue($objForm->GetValue("x_IdDenuncia"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		if (!$this->Quien_Denuncia->FldIsDetailKey) {
			$this->Quien_Denuncia->setFormValue($objForm->GetValue("x_Quien_Denuncia"));
		}
		if (!$this->DetalleDenuncia->FldIsDetailKey) {
			$this->DetalleDenuncia->setFormValue($objForm->GetValue("x_DetalleDenuncia"));
		}
		if (!$this->Fecha_Denuncia->FldIsDetailKey) {
			$this->Fecha_Denuncia->setFormValue($objForm->GetValue("x_Fecha_Denuncia"));
			$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0);
		}
		if (!$this->Id_Estado_Den->FldIsDetailKey) {
			$this->Id_Estado_Den->setFormValue($objForm->GetValue("x_Id_Estado_Den"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->IdDenuncia->CurrentValue = $this->IdDenuncia->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Quien_Denuncia->CurrentValue = $this->Quien_Denuncia->FormValue;
		$this->DetalleDenuncia->CurrentValue = $this->DetalleDenuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = $this->Fecha_Denuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0);
		$this->Id_Estado_Den->CurrentValue = $this->Id_Estado_Den->FormValue;
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
		$this->IdDenuncia->setDbValue($rs->fields('IdDenuncia'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Quien_Denuncia->setDbValue($rs->fields('Quien_Denuncia'));
		$this->DetalleDenuncia->setDbValue($rs->fields('DetalleDenuncia'));
		$this->Fecha_Denuncia->setDbValue($rs->fields('Fecha_Denuncia'));
		$this->Id_Estado_Den->setDbValue($rs->fields('Id_Estado_Den'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IdDenuncia->DbValue = $row['IdDenuncia'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Quien_Denuncia->DbValue = $row['Quien_Denuncia'];
		$this->DetalleDenuncia->DbValue = $row['DetalleDenuncia'];
		$this->Fecha_Denuncia->DbValue = $row['Fecha_Denuncia'];
		$this->Id_Estado_Den->DbValue = $row['Id_Estado_Den'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IdDenuncia
		// NroSerie
		// Dni
		// Dni_Tutor
		// Quien_Denuncia
		// DetalleDenuncia
		// Fecha_Denuncia
		// Id_Estado_Den

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IdDenuncia
		$this->IdDenuncia->ViewValue = $this->IdDenuncia->CurrentValue;
		$this->IdDenuncia->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Quien_Denuncia
		$this->Quien_Denuncia->ViewValue = $this->Quien_Denuncia->CurrentValue;
		$this->Quien_Denuncia->ViewCustomAttributes = "";

		// DetalleDenuncia
		$this->DetalleDenuncia->ViewValue = $this->DetalleDenuncia->CurrentValue;
		$this->DetalleDenuncia->ViewCustomAttributes = "";

		// Fecha_Denuncia
		$this->Fecha_Denuncia->ViewValue = $this->Fecha_Denuncia->CurrentValue;
		$this->Fecha_Denuncia->ViewValue = ew_FormatDateTime($this->Fecha_Denuncia->ViewValue, 0);
		$this->Fecha_Denuncia->ViewCustomAttributes = "";

		// Id_Estado_Den
		$this->Id_Estado_Den->ViewValue = $this->Id_Estado_Den->CurrentValue;
		$this->Id_Estado_Den->ViewCustomAttributes = "";

			// IdDenuncia
			$this->IdDenuncia->LinkCustomAttributes = "";
			$this->IdDenuncia->HrefValue = "";
			$this->IdDenuncia->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Quien_Denuncia
			$this->Quien_Denuncia->LinkCustomAttributes = "";
			$this->Quien_Denuncia->HrefValue = "";
			$this->Quien_Denuncia->TooltipValue = "";

			// DetalleDenuncia
			$this->DetalleDenuncia->LinkCustomAttributes = "";
			$this->DetalleDenuncia->HrefValue = "";
			$this->DetalleDenuncia->TooltipValue = "";

			// Fecha_Denuncia
			$this->Fecha_Denuncia->LinkCustomAttributes = "";
			$this->Fecha_Denuncia->HrefValue = "";
			$this->Fecha_Denuncia->TooltipValue = "";

			// Id_Estado_Den
			$this->Id_Estado_Den->LinkCustomAttributes = "";
			$this->Id_Estado_Den->HrefValue = "";
			$this->Id_Estado_Den->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// IdDenuncia
			$this->IdDenuncia->EditAttrs["class"] = "form-control";
			$this->IdDenuncia->EditCustomAttributes = "";

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// Quien_Denuncia
			$this->Quien_Denuncia->EditAttrs["class"] = "form-control";
			$this->Quien_Denuncia->EditCustomAttributes = "";
			$this->Quien_Denuncia->EditValue = ew_HtmlEncode($this->Quien_Denuncia->CurrentValue);
			$this->Quien_Denuncia->PlaceHolder = ew_RemoveHtml($this->Quien_Denuncia->FldCaption());

			// DetalleDenuncia
			$this->DetalleDenuncia->EditAttrs["class"] = "form-control";
			$this->DetalleDenuncia->EditCustomAttributes = "";
			$this->DetalleDenuncia->EditValue = ew_HtmlEncode($this->DetalleDenuncia->CurrentValue);
			$this->DetalleDenuncia->PlaceHolder = ew_RemoveHtml($this->DetalleDenuncia->FldCaption());

			// Fecha_Denuncia
			$this->Fecha_Denuncia->EditAttrs["class"] = "form-control";
			$this->Fecha_Denuncia->EditCustomAttributes = "";
			$this->Fecha_Denuncia->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Denuncia->CurrentValue, 8));
			$this->Fecha_Denuncia->PlaceHolder = ew_RemoveHtml($this->Fecha_Denuncia->FldCaption());

			// Id_Estado_Den
			$this->Id_Estado_Den->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Den->EditCustomAttributes = "";
			$this->Id_Estado_Den->EditValue = ew_HtmlEncode($this->Id_Estado_Den->CurrentValue);
			$this->Id_Estado_Den->PlaceHolder = ew_RemoveHtml($this->Id_Estado_Den->FldCaption());

			// Edit refer script
			// IdDenuncia

			$this->IdDenuncia->LinkCustomAttributes = "";
			$this->IdDenuncia->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Quien_Denuncia
			$this->Quien_Denuncia->LinkCustomAttributes = "";
			$this->Quien_Denuncia->HrefValue = "";

			// DetalleDenuncia
			$this->DetalleDenuncia->LinkCustomAttributes = "";
			$this->DetalleDenuncia->HrefValue = "";

			// Fecha_Denuncia
			$this->Fecha_Denuncia->LinkCustomAttributes = "";
			$this->Fecha_Denuncia->HrefValue = "";

			// Id_Estado_Den
			$this->Id_Estado_Den->LinkCustomAttributes = "";
			$this->Id_Estado_Den->HrefValue = "";
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
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
		}
		if (!$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni_Tutor->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni_Tutor->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->Fecha_Denuncia->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Denuncia->FldErrMsg());
		}
		if (!$this->Id_Estado_Den->FldIsDetailKey && !is_null($this->Id_Estado_Den->FormValue) && $this->Id_Estado_Den->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Den->FldCaption(), $this->Id_Estado_Den->ReqErrMsg));
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
			$rsnew = array();

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly);

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, $this->Dni->ReadOnly);

			// Dni_Tutor
			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly);

			// Quien_Denuncia
			$this->Quien_Denuncia->SetDbValueDef($rsnew, $this->Quien_Denuncia->CurrentValue, NULL, $this->Quien_Denuncia->ReadOnly);

			// DetalleDenuncia
			$this->DetalleDenuncia->SetDbValueDef($rsnew, $this->DetalleDenuncia->CurrentValue, NULL, $this->DetalleDenuncia->ReadOnly);

			// Fecha_Denuncia
			$this->Fecha_Denuncia->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0), NULL, $this->Fecha_Denuncia->ReadOnly);

			// Id_Estado_Den
			$this->Id_Estado_Den->SetDbValueDef($rsnew, $this->Id_Estado_Den->CurrentValue, 0, $this->Id_Estado_Den->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("denuncia_robo_equipolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($denuncia_robo_equipo_edit)) $denuncia_robo_equipo_edit = new cdenuncia_robo_equipo_edit();

// Page init
$denuncia_robo_equipo_edit->Page_Init();

// Page main
$denuncia_robo_equipo_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$denuncia_robo_equipo_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdenuncia_robo_equipoedit = new ew_Form("fdenuncia_robo_equipoedit", "edit");

// Validate form
fdenuncia_robo_equipoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->NroSerie->FldCaption(), $denuncia_robo_equipo->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni->FldCaption(), $denuncia_robo_equipo->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni_Tutor->FldCaption(), $denuncia_robo_equipo->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Denuncia");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Fecha_Denuncia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Den");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Id_Estado_Den->FldCaption(), $denuncia_robo_equipo->Id_Estado_Den->ReqErrMsg)) ?>");

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
fdenuncia_robo_equipoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdenuncia_robo_equipoedit.ValidateRequired = true;
<?php } else { ?>
fdenuncia_robo_equipoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$denuncia_robo_equipo_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $denuncia_robo_equipo_edit->ShowPageHeader(); ?>
<?php
$denuncia_robo_equipo_edit->ShowMessage();
?>
<form name="fdenuncia_robo_equipoedit" id="fdenuncia_robo_equipoedit" class="<?php echo $denuncia_robo_equipo_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($denuncia_robo_equipo_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $denuncia_robo_equipo_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="denuncia_robo_equipo">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($denuncia_robo_equipo_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($denuncia_robo_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_denuncia_robo_equipo_NroSerie" for="x_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->NroSerie->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_NroSerie">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->NroSerie->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->NroSerie->EditValue ?>"<?php echo $denuncia_robo_equipo->NroSerie->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label id="elh_denuncia_robo_equipo_Dni" for="x_Dni" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Dni->EditValue ?>"<?php echo $denuncia_robo_equipo->Dni->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label id="elh_denuncia_robo_equipo_Dni_Tutor" for="x_Dni_Tutor" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni_Tutor">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Dni_Tutor" name="x_Dni_Tutor" id="x_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Dni_Tutor->EditValue ?>"<?php echo $denuncia_robo_equipo->Dni_Tutor->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Quien_Denuncia->Visible) { // Quien_Denuncia ?>
	<div id="r_Quien_Denuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_Quien_Denuncia" for="x_Quien_Denuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Quien_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Quien_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Quien_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Quien_Denuncia" name="x_Quien_Denuncia" id="x_Quien_Denuncia" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Quien_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Quien_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->DetalleDenuncia->Visible) { // DetalleDenuncia ?>
	<div id="r_DetalleDenuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_DetalleDenuncia" for="x_DetalleDenuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->DetalleDenuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->DetalleDenuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_DetalleDenuncia">
<textarea data-table="denuncia_robo_equipo" data-field="x_DetalleDenuncia" name="x_DetalleDenuncia" id="x_DetalleDenuncia" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->DetalleDenuncia->getPlaceHolder()) ?>"<?php echo $denuncia_robo_equipo->DetalleDenuncia->EditAttributes() ?>><?php echo $denuncia_robo_equipo->DetalleDenuncia->EditValue ?></textarea>
</span>
<?php echo $denuncia_robo_equipo->DetalleDenuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Fecha_Denuncia->Visible) { // Fecha_Denuncia ?>
	<div id="r_Fecha_Denuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_Fecha_Denuncia" for="x_Fecha_Denuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Fecha_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Fecha_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Fecha_Denuncia" name="x_Fecha_Denuncia" id="x_Fecha_Denuncia" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Fecha_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Id_Estado_Den->Visible) { // Id_Estado_Den ?>
	<div id="r_Id_Estado_Den" class="form-group">
		<label id="elh_denuncia_robo_equipo_Id_Estado_Den" for="x_Id_Estado_Den" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Id_Estado_Den->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Id_Estado_Den->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Id_Estado_Den">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Id_Estado_Den" name="x_Id_Estado_Den" id="x_Id_Estado_Den" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Id_Estado_Den->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Id_Estado_Den->EditValue ?>"<?php echo $denuncia_robo_equipo->Id_Estado_Den->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Id_Estado_Den->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<span id="el_denuncia_robo_equipo_IdDenuncia">
<input type="hidden" data-table="denuncia_robo_equipo" data-field="x_IdDenuncia" name="x_IdDenuncia" id="x_IdDenuncia" value="<?php echo ew_HtmlEncode($denuncia_robo_equipo->IdDenuncia->CurrentValue) ?>">
</span>
<?php if (!$denuncia_robo_equipo_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $denuncia_robo_equipo_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdenuncia_robo_equipoedit.Init();
</script>
<?php
$denuncia_robo_equipo_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$denuncia_robo_equipo_edit->Page_Terminate();
?>
