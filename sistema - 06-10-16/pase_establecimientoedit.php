<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pase_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pase_establecimiento_edit = NULL; // Initialize page object first

class cpase_establecimiento_edit extends cpase_establecimiento {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pase_establecimiento';

	// Page object name
	var $PageObjName = 'pase_establecimiento_edit';

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

		// Table object (pase_establecimiento)
		if (!isset($GLOBALS["pase_establecimiento"]) || get_class($GLOBALS["pase_establecimiento"]) == "cpase_establecimiento") {
			$GLOBALS["pase_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pase_establecimiento"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pase_establecimiento', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pase_establecimientolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Pase->SetVisibility();
		$this->Id_Pase->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->NroSerie->SetVisibility();
		$this->Cue_Establecimiento_Alta->SetVisibility();
		$this->Cue_Establecimiento_Baja->SetVisibility();
		$this->Fecha_Pase->SetVisibility();
		$this->Id_Estado_Pase->SetVisibility();

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
		global $EW_EXPORT, $pase_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pase_establecimiento);
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
		if (@$_GET["Id_Pase"] <> "") {
			$this->Id_Pase->setQueryStringValue($_GET["Id_Pase"]);
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
		if ($this->Id_Pase->CurrentValue == "") {
			$this->Page_Terminate("pase_establecimientolist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("pase_establecimientolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "pase_establecimientolist.php")
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
		if (!$this->Id_Pase->FldIsDetailKey)
			$this->Id_Pase->setFormValue($objForm->GetValue("x_Id_Pase"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		if (!$this->Cue_Establecimiento_Alta->FldIsDetailKey) {
			$this->Cue_Establecimiento_Alta->setFormValue($objForm->GetValue("x_Cue_Establecimiento_Alta"));
		}
		if (!$this->Cue_Establecimiento_Baja->FldIsDetailKey) {
			$this->Cue_Establecimiento_Baja->setFormValue($objForm->GetValue("x_Cue_Establecimiento_Baja"));
		}
		if (!$this->Fecha_Pase->FldIsDetailKey) {
			$this->Fecha_Pase->setFormValue($objForm->GetValue("x_Fecha_Pase"));
			$this->Fecha_Pase->CurrentValue = ew_UnFormatDateTime($this->Fecha_Pase->CurrentValue, 0);
		}
		if (!$this->Id_Estado_Pase->FldIsDetailKey) {
			$this->Id_Estado_Pase->setFormValue($objForm->GetValue("x_Id_Estado_Pase"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Pase->CurrentValue = $this->Id_Pase->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Cue_Establecimiento_Alta->CurrentValue = $this->Cue_Establecimiento_Alta->FormValue;
		$this->Cue_Establecimiento_Baja->CurrentValue = $this->Cue_Establecimiento_Baja->FormValue;
		$this->Fecha_Pase->CurrentValue = $this->Fecha_Pase->FormValue;
		$this->Fecha_Pase->CurrentValue = ew_UnFormatDateTime($this->Fecha_Pase->CurrentValue, 0);
		$this->Id_Estado_Pase->CurrentValue = $this->Id_Estado_Pase->FormValue;
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
		$this->Id_Pase->setDbValue($rs->fields('Id_Pase'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Cue_Establecimiento_Alta->setDbValue($rs->fields('Cue_Establecimiento_Alta'));
		$this->Cue_Establecimiento_Baja->setDbValue($rs->fields('Cue_Establecimiento_Baja'));
		$this->Fecha_Pase->setDbValue($rs->fields('Fecha_Pase'));
		$this->Id_Estado_Pase->setDbValue($rs->fields('Id_Estado_Pase'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Pase->DbValue = $row['Id_Pase'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Cue_Establecimiento_Alta->DbValue = $row['Cue_Establecimiento_Alta'];
		$this->Cue_Establecimiento_Baja->DbValue = $row['Cue_Establecimiento_Baja'];
		$this->Fecha_Pase->DbValue = $row['Fecha_Pase'];
		$this->Id_Estado_Pase->DbValue = $row['Id_Estado_Pase'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Pase
		// NroSerie
		// Cue_Establecimiento_Alta
		// Cue_Establecimiento_Baja
		// Fecha_Pase
		// Id_Estado_Pase

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Pase
		$this->Id_Pase->ViewValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

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

		// Cue_Establecimiento_Alta
		if (strval($this->Cue_Establecimiento_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_STRING, "");
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

		// Cue_Establecimiento_Baja
		if (strval($this->Cue_Establecimiento_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_STRING, "");
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

		// Fecha_Pase
		$this->Fecha_Pase->ViewValue = $this->Fecha_Pase->CurrentValue;
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

			// Id_Pase
			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";
			$this->Id_Pase->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";
			$this->Cue_Establecimiento_Alta->TooltipValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";
			$this->Cue_Establecimiento_Baja->TooltipValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";
			$this->Fecha_Pase->TooltipValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
			$this->Id_Estado_Pase->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Pase
			$this->Id_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Pase->EditCustomAttributes = "";
			$this->Id_Pase->EditValue = $this->Id_Pase->CurrentValue;
			$this->Id_Pase->ViewCustomAttributes = "";

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

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Alta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Alta->EditValue = $arwrk;

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Baja->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Baja->EditValue = $arwrk;

			// Fecha_Pase
			$this->Fecha_Pase->EditAttrs["class"] = "form-control";
			$this->Fecha_Pase->EditCustomAttributes = "";
			$this->Fecha_Pase->EditValue = ew_HtmlEncode($this->Fecha_Pase->CurrentValue);
			$this->Fecha_Pase->PlaceHolder = ew_RemoveHtml($this->Fecha_Pase->FldCaption());

			// Id_Estado_Pase
			$this->Id_Estado_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Pase->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Pase->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Pase->EditValue = $arwrk;

			// Edit refer script
			// Id_Pase

			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
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
		if (!ew_CheckDateDef($this->Fecha_Pase->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Pase->FldErrMsg());
		}
		if (!$this->Id_Estado_Pase->FldIsDetailKey && !is_null($this->Id_Estado_Pase->FormValue) && $this->Id_Estado_Pase->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Pase->FldCaption(), $this->Id_Estado_Pase->ReqErrMsg));
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

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Alta->CurrentValue, NULL, $this->Cue_Establecimiento_Alta->ReadOnly);

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Baja->CurrentValue, NULL, $this->Cue_Establecimiento_Baja->ReadOnly);

			// Fecha_Pase
			$this->Fecha_Pase->SetDbValueDef($rsnew, $this->Fecha_Pase->CurrentValue, NULL, $this->Fecha_Pase->ReadOnly);

			// Id_Estado_Pase
			$this->Id_Estado_Pase->SetDbValueDef($rsnew, $this->Id_Estado_Pase->CurrentValue, 0, $this->Id_Estado_Pase->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pase_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
		case "x_Cue_Establecimiento_Alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Pase":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Pase` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Pase` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
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
if (!isset($pase_establecimiento_edit)) $pase_establecimiento_edit = new cpase_establecimiento_edit();

// Page init
$pase_establecimiento_edit->Page_Init();

// Page main
$pase_establecimiento_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pase_establecimiento_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpase_establecimientoedit = new ew_Form("fpase_establecimientoedit", "edit");

// Validate form
fpase_establecimientoedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pase_establecimiento->NroSerie->FldCaption(), $pase_establecimiento->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Pase");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->Fecha_Pase->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Pase");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pase_establecimiento->Id_Estado_Pase->FldCaption(), $pase_establecimiento->Id_Estado_Pase->ReqErrMsg)) ?>");

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
fpase_establecimientoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpase_establecimientoedit.ValidateRequired = true;
<?php } else { ?>
fpase_establecimientoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpase_establecimientoedit.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpase_establecimientoedit.Lists["x_Cue_Establecimiento_Alta"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientoedit.Lists["x_Cue_Establecimiento_Baja"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientoedit.Lists["x_Id_Estado_Pase"] = {"LinkField":"x_Id_Estado_Pase","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_pase"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pase_establecimiento_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pase_establecimiento_edit->ShowPageHeader(); ?>
<?php
$pase_establecimiento_edit->ShowMessage();
?>
<form name="fpase_establecimientoedit" id="fpase_establecimientoedit" class="<?php echo $pase_establecimiento_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pase_establecimiento_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pase_establecimiento_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pase_establecimiento">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($pase_establecimiento_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
	<div id="r_Id_Pase" class="form-group">
		<label id="elh_pase_establecimiento_Id_Pase" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->Id_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Id_Pase">
<span<?php echo $pase_establecimiento->Id_Pase->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pase_establecimiento->Id_Pase->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Pase" name="x_Id_Pase" id="x_Id_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Pase->CurrentValue) ?>">
<?php echo $pase_establecimiento->Id_Pase->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_pase_establecimiento_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->NroSerie->CellAttributes() ?>>
<span id="el_pase_establecimiento_NroSerie">
<?php
$wrkonchange = trim(" " . @$pase_establecimiento->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pase_establecimiento->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x_NroSerie" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_NroSerie" id="sv_x_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>"<?php echo $pase_establecimiento->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" data-value-separator="<?php echo $pase_establecimiento->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NroSerie" id="q_x_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpase_establecimientoedit.CreateAutoSuggest({"id":"x_NroSerie","forceSelect":false});
</script>
</span>
<?php echo $pase_establecimiento->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
	<div id="r_Cue_Establecimiento_Alta" class="form-group">
		<label id="elh_pase_establecimiento_Cue_Establecimiento_Alta" for="x_Cue_Establecimiento_Alta" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cue_Establecimiento_Alta">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Cue_Establecimiento_Alta"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Alta->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Alta->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Alta->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Cue_Establecimiento_Alta',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->DisplayValueSeparatorAttribute() ?>" name="x_Cue_Establecimiento_Alta" id="x_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->EditAttributes() ?>>
<input type="hidden" name="s_x_Cue_Establecimiento_Alta" id="s_x_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->LookupFilterQuery() ?>">
</span>
<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
	<div id="r_Cue_Establecimiento_Baja" class="form-group">
		<label id="elh_pase_establecimiento_Cue_Establecimiento_Baja" for="x_Cue_Establecimiento_Baja" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cue_Establecimiento_Baja">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Cue_Establecimiento_Baja"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Baja->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Baja->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Baja->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Cue_Establecimiento_Baja',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->DisplayValueSeparatorAttribute() ?>" name="x_Cue_Establecimiento_Baja" id="x_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->EditAttributes() ?>>
<input type="hidden" name="s_x_Cue_Establecimiento_Baja" id="s_x_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->LookupFilterQuery() ?>">
</span>
<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
	<div id="r_Fecha_Pase" class="form-group">
		<label id="elh_pase_establecimiento_Fecha_Pase" for="x_Fecha_Pase" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->Fecha_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Fecha_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="x_Fecha_Pase" id="x_Fecha_Pase" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Fecha_Pase->EditValue ?>"<?php echo $pase_establecimiento->Fecha_Pase->EditAttributes() ?>>
<?php if (!$pase_establecimiento->Fecha_Pase->ReadOnly && !$pase_establecimiento->Fecha_Pase->Disabled && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["readonly"]) && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpase_establecimientoedit", "x_Fecha_Pase", 0);
</script>
<?php } ?>
</span>
<?php echo $pase_establecimiento->Fecha_Pase->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
	<div id="r_Id_Estado_Pase" class="form-group">
		<label id="elh_pase_establecimiento_Id_Estado_Pase" for="x_Id_Estado_Pase" class="col-sm-2 control-label ewLabel"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pase_establecimiento->Id_Estado_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Id_Estado_Pase">
<select data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" data-value-separator="<?php echo $pase_establecimiento->Id_Estado_Pase->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Pase" name="x_Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->EditAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->SelectOptionListHtml("x_Id_Estado_Pase") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Pase" id="s_x_Id_Estado_Pase" value="<?php echo $pase_establecimiento->Id_Estado_Pase->LookupFilterQuery() ?>">
</span>
<?php echo $pase_establecimiento->Id_Estado_Pase->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pase_establecimiento_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pase_establecimiento_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpase_establecimientoedit.Init();
</script>
<?php
$pase_establecimiento_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pase_establecimiento_edit->Page_Terminate();
?>
