<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "atencion_para_stinfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$atencion_para_st_add = NULL; // Initialize page object first

class catencion_para_st_add extends catencion_para_st {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'atencion_para_st';

	// Page object name
	var $PageObjName = 'atencion_para_st_add';

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

		// Table object (atencion_para_st)
		if (!isset($GLOBALS["atencion_para_st"]) || get_class($GLOBALS["atencion_para_st"]) == "catencion_para_st") {
			$GLOBALS["atencion_para_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["atencion_para_st"];
		}

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'atencion_para_st', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("atencion_para_stlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Nro_Tiket->SetVisibility();
		$this->Id_Tipo_Retiro->SetVisibility();
		$this->Fecha_Retiro->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Devolucion->SetVisibility();

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
		global $EW_EXPORT, $atencion_para_st;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($atencion_para_st);
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
			if (@$_GET["Id_Atencion"] != "") {
				$this->Id_Atencion->setQueryStringValue($_GET["Id_Atencion"]);
				$this->setKey("Id_Atencion", $this->Id_Atencion->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Atencion", ""); // Clear key
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
					$this->Page_Terminate("atencion_para_stlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "atencion_para_stlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "atencion_para_stview.php")
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
		$this->Nro_Tiket->CurrentValue = NULL;
		$this->Nro_Tiket->OldValue = $this->Nro_Tiket->CurrentValue;
		$this->Id_Tipo_Retiro->CurrentValue = 3;
		$this->Fecha_Retiro->CurrentValue = NULL;
		$this->Fecha_Retiro->OldValue = $this->Fecha_Retiro->CurrentValue;
		$this->Observacion->CurrentValue = NULL;
		$this->Observacion->OldValue = $this->Observacion->CurrentValue;
		$this->Fecha_Devolucion->CurrentValue = NULL;
		$this->Fecha_Devolucion->OldValue = $this->Fecha_Devolucion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nro_Tiket->FldIsDetailKey) {
			$this->Nro_Tiket->setFormValue($objForm->GetValue("x_Nro_Tiket"));
		}
		if (!$this->Id_Tipo_Retiro->FldIsDetailKey) {
			$this->Id_Tipo_Retiro->setFormValue($objForm->GetValue("x_Id_Tipo_Retiro"));
		}
		if (!$this->Fecha_Retiro->FldIsDetailKey) {
			$this->Fecha_Retiro->setFormValue($objForm->GetValue("x_Fecha_Retiro"));
		}
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		if (!$this->Fecha_Devolucion->FldIsDetailKey) {
			$this->Fecha_Devolucion->setFormValue($objForm->GetValue("x_Fecha_Devolucion"));
		}
		if (!$this->Id_Atencion->FldIsDetailKey)
			$this->Id_Atencion->setFormValue($objForm->GetValue("x_Id_Atencion"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Atencion->CurrentValue = $this->Id_Atencion->FormValue;
		$this->Nro_Tiket->CurrentValue = $this->Nro_Tiket->FormValue;
		$this->Id_Tipo_Retiro->CurrentValue = $this->Id_Tipo_Retiro->FormValue;
		$this->Fecha_Retiro->CurrentValue = $this->Fecha_Retiro->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Fecha_Devolucion->CurrentValue = $this->Fecha_Devolucion->FormValue;
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
		$this->Nro_Tiket->setDbValue($rs->fields('Nro_Tiket'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
		$this->Fecha_Retiro->setDbValue($rs->fields('Fecha_Retiro'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Devolucion->setDbValue($rs->fields('Fecha_Devolucion'));
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Nro_Tiket->DbValue = $row['Nro_Tiket'];
		$this->Id_Tipo_Retiro->DbValue = $row['Id_Tipo_Retiro'];
		$this->Fecha_Retiro->DbValue = $row['Fecha_Retiro'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Devolucion->DbValue = $row['Fecha_Devolucion'];
		$this->Id_Atencion->DbValue = $row['Id_Atencion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Atencion")) <> "")
			$this->Id_Atencion->CurrentValue = $this->getKey("Id_Atencion"); // Id_Atencion
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
		// Nro_Tiket
		// Id_Tipo_Retiro
		// Fecha_Retiro
		// Observacion
		// Fecha_Devolucion
		// Id_Atencion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nro_Tiket
		$this->Nro_Tiket->ViewValue = $this->Nro_Tiket->CurrentValue;
		$this->Nro_Tiket->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Retiro->ViewValue = NULL;
		}
		$this->Id_Tipo_Retiro->ViewCustomAttributes = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->ViewValue = $this->Fecha_Retiro->CurrentValue;
		$this->Fecha_Retiro->ViewValue = ew_FormatDateTime($this->Fecha_Retiro->ViewValue, 7);
		$this->Fecha_Retiro->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->ViewValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->ViewValue = ew_FormatDateTime($this->Fecha_Devolucion->ViewValue, 7);
		$this->Fecha_Devolucion->ViewCustomAttributes = "";

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";
			$this->Nro_Tiket->TooltipValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";
			$this->Id_Tipo_Retiro->TooltipValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";
			$this->Fecha_Retiro->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
			$this->Fecha_Devolucion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nro_Tiket
			$this->Nro_Tiket->EditAttrs["class"] = "form-control";
			$this->Nro_Tiket->EditCustomAttributes = "";
			$this->Nro_Tiket->EditValue = ew_HtmlEncode($this->Nro_Tiket->CurrentValue);
			$this->Nro_Tiket->PlaceHolder = ew_RemoveHtml($this->Nro_Tiket->FldCaption());

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Retiro->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Retiro->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;

			// Fecha_Retiro
			$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
			$this->Fecha_Retiro->EditCustomAttributes = "";
			$this->Fecha_Retiro->EditValue = ew_HtmlEncode($this->Fecha_Retiro->CurrentValue);
			$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode($this->Fecha_Devolucion->CurrentValue);
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

			// Add refer script
			// Nro_Tiket

			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
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
		if (!ew_CheckInteger($this->Nro_Tiket->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nro_Tiket->FldErrMsg());
		}
		if (!$this->Id_Tipo_Retiro->FldIsDetailKey && !is_null($this->Id_Tipo_Retiro->FormValue) && $this->Id_Tipo_Retiro->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Retiro->FldCaption(), $this->Id_Tipo_Retiro->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Retiro->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Retiro->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Devolucion->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Devolucion->FldErrMsg());
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

		// Check referential integrity for master table 'atencion_equipos'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_atencion_equipos();
		if ($this->Id_Atencion->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["atencion_equipos"])) $GLOBALS["atencion_equipos"] = new catencion_equipos();
			$rsmaster = $GLOBALS["atencion_equipos"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "atencion_equipos", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Nro_Tiket
		$this->Nro_Tiket->SetDbValueDef($rsnew, $this->Nro_Tiket->CurrentValue, NULL, FALSE);

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->SetDbValueDef($rsnew, $this->Id_Tipo_Retiro->CurrentValue, 0, FALSE);

		// Fecha_Retiro
		$this->Fecha_Retiro->SetDbValueDef($rsnew, $this->Fecha_Retiro->CurrentValue, NULL, FALSE);

		// Observacion
		$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, FALSE);

		// Fecha_Devolucion
		$this->Fecha_Devolucion->SetDbValueDef($rsnew, $this->Fecha_Devolucion->CurrentValue, NULL, FALSE);

		// Id_Atencion
		if ($this->Id_Atencion->getSessionValue() <> "") {
			$rsnew['Id_Atencion'] = $this->Id_Atencion->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Id_Atencion']) == "") {
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
			if ($sMasterTblVar == "atencion_equipos") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Id_Atencion"] <> "") {
					$GLOBALS["atencion_equipos"]->Id_Atencion->setQueryStringValue($_GET["fk_Id_Atencion"]);
					$this->Id_Atencion->setQueryStringValue($GLOBALS["atencion_equipos"]->Id_Atencion->QueryStringValue);
					$this->Id_Atencion->setSessionValue($this->Id_Atencion->QueryStringValue);
					if (!is_numeric($GLOBALS["atencion_equipos"]->Id_Atencion->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "atencion_equipos") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Id_Atencion"] <> "") {
					$GLOBALS["atencion_equipos"]->Id_Atencion->setFormValue($_POST["fk_Id_Atencion"]);
					$this->Id_Atencion->setFormValue($GLOBALS["atencion_equipos"]->Id_Atencion->FormValue);
					$this->Id_Atencion->setSessionValue($this->Id_Atencion->FormValue);
					if (!is_numeric($GLOBALS["atencion_equipos"]->Id_Atencion->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "atencion_equipos") {
				if ($this->Id_Atencion->CurrentValue == "") $this->Id_Atencion->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("atencion_para_stlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Tipo_Retiro":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Retiro` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Retiro` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
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
		$table = 'atencion_para_st';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'atencion_para_st';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];

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
if (!isset($atencion_para_st_add)) $atencion_para_st_add = new catencion_para_st_add();

// Page init
$atencion_para_st_add->Page_Init();

// Page main
$atencion_para_st_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_para_st_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fatencion_para_stadd = new ew_Form("fatencion_para_stadd", "add");

// Validate form
fatencion_para_stadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nro_Tiket");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Nro_Tiket->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Retiro");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->Id_Tipo_Retiro->FldCaption(), $atencion_para_st->Id_Tipo_Retiro->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Retiro");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Retiro->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Devolucion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Devolucion->FldErrMsg()) ?>");

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
fatencion_para_stadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_para_stadd.ValidateRequired = true;
<?php } else { ?>
fatencion_para_stadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_para_stadd.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$atencion_para_st_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $atencion_para_st_add->ShowPageHeader(); ?>
<?php
$atencion_para_st_add->ShowMessage();
?>
<form name="fatencion_para_stadd" id="fatencion_para_stadd" class="<?php echo $atencion_para_st_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($atencion_para_st_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $atencion_para_st_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="atencion_para_st">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($atencion_para_st_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($atencion_para_st->getCurrentMasterTable() == "atencion_equipos") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="atencion_equipos">
<input type="hidden" name="fk_Id_Atencion" value="<?php echo $atencion_para_st->Id_Atencion->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
	<div id="r_Nro_Tiket" class="form-group">
		<label id="elh_atencion_para_st_Nro_Tiket" for="x_Nro_Tiket" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Nro_Tiket->CellAttributes() ?>>
<span id="el_atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" data-page="1" name="x_Nro_Tiket" id="x_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<?php echo $atencion_para_st->Nro_Tiket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
	<div id="r_Id_Tipo_Retiro" class="form-group">
		<label id="elh_atencion_para_st_Id_Tipo_Retiro" for="x_Id_Tipo_Retiro" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Id_Tipo_Retiro->CellAttributes() ?>>
<span id="el_atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-page="1" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Retiro" name="x_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Retiro" id="s_x_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<?php echo $atencion_para_st->Id_Tipo_Retiro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
	<div id="r_Fecha_Retiro" class="form-group">
		<label id="elh_atencion_para_st_Fecha_Retiro" for="x_Fecha_Retiro" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Fecha_Retiro->CellAttributes() ?>>
<span id="el_atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-page="1" name="x_Fecha_Retiro" id="x_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stadd", "x_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<?php echo $atencion_para_st->Fecha_Retiro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label id="elh_atencion_para_st_Observacion" for="x_Observacion" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Observacion->CellAttributes() ?>>
<span id="el_atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" data-page="1" name="x_Observacion" id="x_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<?php echo $atencion_para_st->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
	<div id="r_Fecha_Devolucion" class="form-group">
		<label id="elh_atencion_para_st_Fecha_Devolucion" for="x_Fecha_Devolucion" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Fecha_Devolucion->CellAttributes() ?>>
<span id="el_atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-page="1" name="x_Fecha_Devolucion" id="x_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stadd", "x_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php echo $atencion_para_st->Fecha_Devolucion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($atencion_para_st->Id_Atencion->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Id_Atencion" id="x_Id_Atencion" value="<?php echo ew_HtmlEncode(strval($atencion_para_st->Id_Atencion->getSessionValue())) ?>">
<?php } ?>
<?php if (!$atencion_para_st_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $atencion_para_st_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fatencion_para_stadd.Init();
</script>
<?php
$atencion_para_st_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$atencion_para_st_add->Page_Terminate();
?>
