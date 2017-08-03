<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "atencion_para_stinfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$atencion_para_st_edit = NULL; // Initialize page object first

class catencion_para_st_edit extends catencion_para_st {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'atencion_para_st';

	// Page object name
	var $PageObjName = 'atencion_para_st_edit';

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

		// Table object (atencion_para_st)
		if (!isset($GLOBALS["atencion_para_st"]) || get_class($GLOBALS["atencion_para_st"]) == "catencion_para_st") {
			$GLOBALS["atencion_para_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["atencion_para_st"];
		}

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'atencion_para_st', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("atencion_para_stlist.php"));
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
		$this->Nro_Tiket->SetVisibility();
		$this->Id_Tipo_Retiro->SetVisibility();
		$this->Referencia_Tipo_Retiro->SetVisibility();
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
		if (@$_GET["Id_Atencion"] <> "") {
			$this->Id_Atencion->setQueryStringValue($_GET["Id_Atencion"]);
		}
		if (@$_GET["NroSerie"] <> "") {
			$this->NroSerie->setQueryStringValue($_GET["NroSerie"]);
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
		if ($this->Id_Atencion->CurrentValue == "") {
			$this->Page_Terminate("atencion_para_stlist.php"); // Invalid key, return to list
		}
		if ($this->NroSerie->CurrentValue == "") {
			$this->Page_Terminate("atencion_para_stlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("atencion_para_stlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "atencion_para_stlist.php")
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
		if (!$this->Nro_Tiket->FldIsDetailKey) {
			$this->Nro_Tiket->setFormValue($objForm->GetValue("x_Nro_Tiket"));
		}
		if (!$this->Id_Tipo_Retiro->FldIsDetailKey) {
			$this->Id_Tipo_Retiro->setFormValue($objForm->GetValue("x_Id_Tipo_Retiro"));
		}
		if (!$this->Referencia_Tipo_Retiro->FldIsDetailKey) {
			$this->Referencia_Tipo_Retiro->setFormValue($objForm->GetValue("x_Referencia_Tipo_Retiro"));
		}
		if (!$this->Fecha_Retiro->FldIsDetailKey) {
			$this->Fecha_Retiro->setFormValue($objForm->GetValue("x_Fecha_Retiro"));
			$this->Fecha_Retiro->CurrentValue = ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7);
		}
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		if (!$this->Fecha_Devolucion->FldIsDetailKey) {
			$this->Fecha_Devolucion->setFormValue($objForm->GetValue("x_Fecha_Devolucion"));
			$this->Fecha_Devolucion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7);
		}
		if (!$this->Id_Atencion->FldIsDetailKey)
			$this->Id_Atencion->setFormValue($objForm->GetValue("x_Id_Atencion"));
		if (!$this->NroSerie->FldIsDetailKey)
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Atencion->CurrentValue = $this->Id_Atencion->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Nro_Tiket->CurrentValue = $this->Nro_Tiket->FormValue;
		$this->Id_Tipo_Retiro->CurrentValue = $this->Id_Tipo_Retiro->FormValue;
		$this->Referencia_Tipo_Retiro->CurrentValue = $this->Referencia_Tipo_Retiro->FormValue;
		$this->Fecha_Retiro->CurrentValue = $this->Fecha_Retiro->FormValue;
		$this->Fecha_Retiro->CurrentValue = ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7);
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Fecha_Devolucion->CurrentValue = $this->Fecha_Devolucion->FormValue;
		$this->Fecha_Devolucion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7);
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
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Nro_Tiket->setDbValue($rs->fields('Nro_Tiket'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
		$this->Referencia_Tipo_Retiro->setDbValue($rs->fields('Referencia_Tipo_Retiro'));
		$this->Fecha_Retiro->setDbValue($rs->fields('Fecha_Retiro'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Devolucion->setDbValue($rs->fields('Fecha_Devolucion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Atencion->DbValue = $row['Id_Atencion'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Nro_Tiket->DbValue = $row['Nro_Tiket'];
		$this->Id_Tipo_Retiro->DbValue = $row['Id_Tipo_Retiro'];
		$this->Referencia_Tipo_Retiro->DbValue = $row['Referencia_Tipo_Retiro'];
		$this->Fecha_Retiro->DbValue = $row['Fecha_Retiro'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Devolucion->DbValue = $row['Fecha_Devolucion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Atencion
		// NroSerie
		// Nro_Tiket
		// Id_Tipo_Retiro
		// Referencia_Tipo_Retiro
		// Fecha_Retiro
		// Observacion
		// Fecha_Devolucion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

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
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->ViewValue = $this->Referencia_Tipo_Retiro->CurrentValue;
		$this->Referencia_Tipo_Retiro->ViewCustomAttributes = "";

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

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";
			$this->Nro_Tiket->TooltipValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";
			$this->Id_Tipo_Retiro->TooltipValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";
			$this->Referencia_Tipo_Retiro->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Referencia_Tipo_Retiro->EditCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->EditValue = ew_HtmlEncode($this->Referencia_Tipo_Retiro->CurrentValue);
			$this->Referencia_Tipo_Retiro->PlaceHolder = ew_RemoveHtml($this->Referencia_Tipo_Retiro->FldCaption());

			// Fecha_Retiro
			$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
			$this->Fecha_Retiro->EditCustomAttributes = "";
			$this->Fecha_Retiro->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Retiro->CurrentValue, 7));
			$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Devolucion->CurrentValue, 7));
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

			// Edit refer script
			// Nro_Tiket

			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";

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
		if (!$this->Nro_Tiket->FldIsDetailKey && !is_null($this->Nro_Tiket->FormValue) && $this->Nro_Tiket->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nro_Tiket->FldCaption(), $this->Nro_Tiket->ReqErrMsg));
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

			// Nro_Tiket
			$this->Nro_Tiket->SetDbValueDef($rsnew, $this->Nro_Tiket->CurrentValue, NULL, $this->Nro_Tiket->ReadOnly);

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->SetDbValueDef($rsnew, $this->Id_Tipo_Retiro->CurrentValue, 0, $this->Id_Tipo_Retiro->ReadOnly);

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->SetDbValueDef($rsnew, $this->Referencia_Tipo_Retiro->CurrentValue, NULL, $this->Referencia_Tipo_Retiro->ReadOnly);

			// Fecha_Retiro
			$this->Fecha_Retiro->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7), NULL, $this->Fecha_Retiro->ReadOnly);

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly);

			// Fecha_Devolucion
			$this->Fecha_Devolucion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7), NULL, $this->Fecha_Devolucion->ReadOnly);

			// Check referential integrity for master table 'atencion_equipos'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_atencion_equipos();
			$KeyValue = isset($rsnew['Id_Atencion']) ? $rsnew['Id_Atencion'] : $rsold['Id_Atencion'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@Id_Atencion@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['NroSerie']) ? $rsnew['NroSerie'] : $rsold['NroSerie'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@NroSerie@", ew_AdjustSql($KeyValue), $sMasterFilter);
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
				if (@$_GET["fk_NroSerie"] <> "") {
					$GLOBALS["atencion_equipos"]->NroSerie->setQueryStringValue($_GET["fk_NroSerie"]);
					$this->NroSerie->setQueryStringValue($GLOBALS["atencion_equipos"]->NroSerie->QueryStringValue);
					$this->NroSerie->setSessionValue($this->NroSerie->QueryStringValue);
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
				if (@$_POST["fk_NroSerie"] <> "") {
					$GLOBALS["atencion_equipos"]->NroSerie->setFormValue($_POST["fk_NroSerie"]);
					$this->NroSerie->setFormValue($GLOBALS["atencion_equipos"]->NroSerie->FormValue);
					$this->NroSerie->setSessionValue($this->NroSerie->FormValue);
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
			if ($sMasterTblVar <> "atencion_equipos") {
				if ($this->Id_Atencion->CurrentValue == "") $this->Id_Atencion->setSessionValue("");
				if ($this->NroSerie->CurrentValue == "") $this->NroSerie->setSessionValue("");
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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'atencion_para_st';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Id_Atencion'];
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NroSerie'];

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
if (!isset($atencion_para_st_edit)) $atencion_para_st_edit = new catencion_para_st_edit();

// Page init
$atencion_para_st_edit->Page_Init();

// Page main
$atencion_para_st_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_para_st_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fatencion_para_stedit = new ew_Form("fatencion_para_stedit", "edit");

// Validate form
fatencion_para_stedit.Validate = function() {
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
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->Nro_Tiket->FldCaption(), $atencion_para_st->Nro_Tiket->ReqErrMsg)) ?>");
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
fatencion_para_stedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_para_stedit.ValidateRequired = true;
<?php } else { ?>
fatencion_para_stedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_para_stedit.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$atencion_para_st_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $atencion_para_st_edit->ShowPageHeader(); ?>
<?php
$atencion_para_st_edit->ShowMessage();
?>
<form name="fatencion_para_stedit" id="fatencion_para_stedit" class="<?php echo $atencion_para_st_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($atencion_para_st_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $atencion_para_st_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="atencion_para_st">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($atencion_para_st_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($atencion_para_st->getCurrentMasterTable() == "atencion_equipos") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="atencion_equipos">
<input type="hidden" name="fk_Id_Atencion" value="<?php echo $atencion_para_st->Id_Atencion->getSessionValue() ?>">
<input type="hidden" name="fk_NroSerie" value="<?php echo $atencion_para_st->NroSerie->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
	<div id="r_Nro_Tiket" class="form-group">
		<label id="elh_atencion_para_st_Nro_Tiket" for="x_Nro_Tiket" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
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
<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
	<div id="r_Referencia_Tipo_Retiro" class="form-group">
		<label id="elh_atencion_para_st_Referencia_Tipo_Retiro" for="x_Referencia_Tipo_Retiro" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Referencia_Tipo_Retiro->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Referencia_Tipo_Retiro->CellAttributes() ?>>
<span id="el_atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" data-page="1" name="x_Referencia_Tipo_Retiro" id="x_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
<?php echo $atencion_para_st->Referencia_Tipo_Retiro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
	<div id="r_Fecha_Retiro" class="form-group">
		<label id="elh_atencion_para_st_Fecha_Retiro" for="x_Fecha_Retiro" class="col-sm-2 control-label ewLabel"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $atencion_para_st->Fecha_Retiro->CellAttributes() ?>>
<span id="el_atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-page="1" data-format="7" name="x_Fecha_Retiro" id="x_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stedit", "x_Fecha_Retiro", 7);
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
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-page="1" data-format="7" name="x_Fecha_Devolucion" id="x_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stedit", "x_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php echo $atencion_para_st->Fecha_Devolucion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x_Id_Atencion" id="x_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->CurrentValue) ?>">
<?php if (!$atencion_para_st_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $atencion_para_st_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fatencion_para_stedit.Init();
</script>
<?php
$atencion_para_st_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$atencion_para_st_edit->Page_Terminate();
?>
