<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "servidor_escolarinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$servidor_escolar_edit = NULL; // Initialize page object first

class cservidor_escolar_edit extends cservidor_escolar {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'servidor_escolar';

	// Page object name
	var $PageObjName = 'servidor_escolar_edit';

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

		// Table object (servidor_escolar)
		if (!isset($GLOBALS["servidor_escolar"]) || get_class($GLOBALS["servidor_escolar"]) == "cservidor_escolar") {
			$GLOBALS["servidor_escolar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["servidor_escolar"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'servidor_escolar', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("servidor_escolarlist.php"));
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
		$this->Nro_Serie->SetVisibility();
		$this->SN->SetVisibility();
		$this->Cant_Net_Asoc->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_SO->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->User_Server->SetVisibility();
		$this->Pass_Server->SetVisibility();
		$this->User_TdServer->SetVisibility();
		$this->Pass_TdServer->SetVisibility();
		$this->Cue->SetVisibility();
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
		global $EW_EXPORT, $servidor_escolar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($servidor_escolar);
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
		if (@$_GET["Cue"] <> "") {
			$this->Cue->setQueryStringValue($_GET["Cue"]);
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
		if ($this->Cue->CurrentValue == "") {
			$this->Page_Terminate("servidor_escolarlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("servidor_escolarlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "servidor_escolarlist.php")
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
		if (!$this->Nro_Serie->FldIsDetailKey) {
			$this->Nro_Serie->setFormValue($objForm->GetValue("x_Nro_Serie"));
		}
		if (!$this->SN->FldIsDetailKey) {
			$this->SN->setFormValue($objForm->GetValue("x_SN"));
		}
		if (!$this->Cant_Net_Asoc->FldIsDetailKey) {
			$this->Cant_Net_Asoc->setFormValue($objForm->GetValue("x_Cant_Net_Asoc"));
		}
		if (!$this->Id_Marca->FldIsDetailKey) {
			$this->Id_Marca->setFormValue($objForm->GetValue("x_Id_Marca"));
		}
		if (!$this->Id_Modelo->FldIsDetailKey) {
			$this->Id_Modelo->setFormValue($objForm->GetValue("x_Id_Modelo"));
		}
		if (!$this->Id_SO->FldIsDetailKey) {
			$this->Id_SO->setFormValue($objForm->GetValue("x_Id_SO"));
		}
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		if (!$this->User_Server->FldIsDetailKey) {
			$this->User_Server->setFormValue($objForm->GetValue("x_User_Server"));
		}
		if (!$this->Pass_Server->FldIsDetailKey) {
			$this->Pass_Server->setFormValue($objForm->GetValue("x_Pass_Server"));
		}
		if (!$this->User_TdServer->FldIsDetailKey) {
			$this->User_TdServer->setFormValue($objForm->GetValue("x_User_TdServer"));
		}
		if (!$this->Pass_TdServer->FldIsDetailKey) {
			$this->Pass_TdServer->setFormValue($objForm->GetValue("x_Pass_TdServer"));
		}
		if (!$this->Cue->FldIsDetailKey) {
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
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
		$this->Nro_Serie->CurrentValue = $this->Nro_Serie->FormValue;
		$this->SN->CurrentValue = $this->SN->FormValue;
		$this->Cant_Net_Asoc->CurrentValue = $this->Cant_Net_Asoc->FormValue;
		$this->Id_Marca->CurrentValue = $this->Id_Marca->FormValue;
		$this->Id_Modelo->CurrentValue = $this->Id_Modelo->FormValue;
		$this->Id_SO->CurrentValue = $this->Id_SO->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->User_Server->CurrentValue = $this->User_Server->FormValue;
		$this->Pass_Server->CurrentValue = $this->Pass_Server->FormValue;
		$this->User_TdServer->CurrentValue = $this->User_TdServer->FormValue;
		$this->Pass_TdServer->CurrentValue = $this->Pass_TdServer->FormValue;
		$this->Cue->CurrentValue = $this->Cue->FormValue;
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
		$this->Nro_Serie->setDbValue($rs->fields('Nro_Serie'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Cant_Net_Asoc->setDbValue($rs->fields('Cant_Net_Asoc'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_SO->setDbValue($rs->fields('Id_SO'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->User_Server->setDbValue($rs->fields('User_Server'));
		$this->Pass_Server->setDbValue($rs->fields('Pass_Server'));
		$this->User_TdServer->setDbValue($rs->fields('User_TdServer'));
		$this->Pass_TdServer->setDbValue($rs->fields('Pass_TdServer'));
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Nro_Serie->DbValue = $row['Nro_Serie'];
		$this->SN->DbValue = $row['SN'];
		$this->Cant_Net_Asoc->DbValue = $row['Cant_Net_Asoc'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_SO->DbValue = $row['Id_SO'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->User_Server->DbValue = $row['User_Server'];
		$this->Pass_Server->DbValue = $row['Pass_Server'];
		$this->User_TdServer->DbValue = $row['User_TdServer'];
		$this->Pass_TdServer->DbValue = $row['Pass_TdServer'];
		$this->Cue->DbValue = $row['Cue'];
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
		// Nro_Serie
		// SN
		// Cant_Net_Asoc
		// Id_Marca
		// Id_Modelo
		// Id_SO
		// Id_Estado
		// User_Server
		// Pass_Server
		// User_TdServer
		// Pass_TdServer
		// Cue
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nro_Serie
		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->ViewValue = $this->Cant_Net_Asoc->CurrentValue;
		$this->Cant_Net_Asoc->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Marca->ViewValue = $this->Id_Marca->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Marca->ViewValue = $this->Id_Marca->CurrentValue;
			}
		} else {
			$this->Id_Marca->ViewValue = NULL;
		}
		$this->Id_Marca->ViewCustomAttributes = "";

		// Id_Modelo
		if (strval($this->Id_Modelo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
		$sWhereWrk = "";
		$this->Id_Modelo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->CurrentValue;
			}
		} else {
			$this->Id_Modelo->ViewValue = NULL;
		}
		$this->Id_Modelo->ViewCustomAttributes = "";

		// Id_SO
		if (strval($this->Id_SO->CurrentValue) <> "") {
			$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
		$sWhereWrk = "";
		$this->Id_SO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_SO->ViewValue = $this->Id_SO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_SO->ViewValue = $this->Id_SO->CurrentValue;
			}
		} else {
			$this->Id_SO->ViewValue = NULL;
		}
		$this->Id_SO->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
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

		// User_Server
		$this->User_Server->ViewValue = $this->User_Server->CurrentValue;
		$this->User_Server->ViewCustomAttributes = "";

		// Pass_Server
		$this->Pass_Server->ViewValue = $this->Pass_Server->CurrentValue;
		$this->Pass_Server->ViewCustomAttributes = "";

		// User_TdServer
		$this->User_TdServer->ViewValue = $this->User_TdServer->CurrentValue;
		$this->User_TdServer->ViewCustomAttributes = "";

		// Pass_TdServer
		$this->Pass_TdServer->ViewValue = $this->Pass_TdServer->CurrentValue;
		$this->Pass_TdServer->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Nro_Serie
			$this->Nro_Serie->LinkCustomAttributes = "";
			$this->Nro_Serie->HrefValue = "";
			$this->Nro_Serie->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->LinkCustomAttributes = "";
			$this->Cant_Net_Asoc->HrefValue = "";
			$this->Cant_Net_Asoc->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_SO
			$this->Id_SO->LinkCustomAttributes = "";
			$this->Id_SO->HrefValue = "";
			$this->Id_SO->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// User_Server
			$this->User_Server->LinkCustomAttributes = "";
			$this->User_Server->HrefValue = "";
			$this->User_Server->TooltipValue = "";

			// Pass_Server
			$this->Pass_Server->LinkCustomAttributes = "";
			$this->Pass_Server->HrefValue = "";
			$this->Pass_Server->TooltipValue = "";

			// User_TdServer
			$this->User_TdServer->LinkCustomAttributes = "";
			$this->User_TdServer->HrefValue = "";
			$this->User_TdServer->TooltipValue = "";

			// Pass_TdServer
			$this->Pass_TdServer->LinkCustomAttributes = "";
			$this->Pass_TdServer->HrefValue = "";
			$this->Pass_TdServer->TooltipValue = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Nro_Serie
			$this->Nro_Serie->EditAttrs["class"] = "form-control";
			$this->Nro_Serie->EditCustomAttributes = "";
			$this->Nro_Serie->EditValue = ew_HtmlEncode($this->Nro_Serie->CurrentValue);
			$this->Nro_Serie->PlaceHolder = ew_RemoveHtml($this->Nro_Serie->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->CurrentValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->EditAttrs["class"] = "form-control";
			$this->Cant_Net_Asoc->EditCustomAttributes = "";
			$this->Cant_Net_Asoc->EditValue = ew_HtmlEncode($this->Cant_Net_Asoc->CurrentValue);
			$this->Cant_Net_Asoc->PlaceHolder = ew_RemoveHtml($this->Cant_Net_Asoc->FldCaption());

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca_server`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Marca->EditValue = $arwrk;

			// Id_Modelo
			$this->Id_Modelo->EditAttrs["class"] = "form-control";
			$this->Id_Modelo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modelo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo_server`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_SO
			$this->Id_SO->EditAttrs["class"] = "form-control";
			$this->Id_SO->EditCustomAttributes = "";
			if (trim(strval($this->Id_SO->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `so_server`";
			$sWhereWrk = "";
			$this->Id_SO->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_SO->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_server`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// User_Server
			$this->User_Server->EditAttrs["class"] = "form-control";
			$this->User_Server->EditCustomAttributes = "";
			$this->User_Server->EditValue = ew_HtmlEncode($this->User_Server->CurrentValue);
			$this->User_Server->PlaceHolder = ew_RemoveHtml($this->User_Server->FldCaption());

			// Pass_Server
			$this->Pass_Server->EditAttrs["class"] = "form-control";
			$this->Pass_Server->EditCustomAttributes = "";
			$this->Pass_Server->EditValue = ew_HtmlEncode($this->Pass_Server->CurrentValue);
			$this->Pass_Server->PlaceHolder = ew_RemoveHtml($this->Pass_Server->FldCaption());

			// User_TdServer
			$this->User_TdServer->EditAttrs["class"] = "form-control";
			$this->User_TdServer->EditCustomAttributes = "";
			$this->User_TdServer->EditValue = ew_HtmlEncode($this->User_TdServer->CurrentValue);
			$this->User_TdServer->PlaceHolder = ew_RemoveHtml($this->User_TdServer->FldCaption());

			// Pass_TdServer
			$this->Pass_TdServer->EditAttrs["class"] = "form-control";
			$this->Pass_TdServer->EditCustomAttributes = "";
			$this->Pass_TdServer->EditValue = ew_HtmlEncode($this->Pass_TdServer->CurrentValue);
			$this->Pass_TdServer->PlaceHolder = ew_RemoveHtml($this->Pass_TdServer->FldCaption());

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			if ($this->Cue->getSessionValue() <> "") {
				$this->Cue->CurrentValue = $this->Cue->getSessionValue();
			$this->Cue->ViewValue = $this->Cue->CurrentValue;
			$this->Cue->ViewCustomAttributes = "";
			} else {
			}

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Nro_Serie

			$this->Nro_Serie->LinkCustomAttributes = "";
			$this->Nro_Serie->HrefValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->LinkCustomAttributes = "";
			$this->Cant_Net_Asoc->HrefValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";

			// Id_SO
			$this->Id_SO->LinkCustomAttributes = "";
			$this->Id_SO->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// User_Server
			$this->User_Server->LinkCustomAttributes = "";
			$this->User_Server->HrefValue = "";

			// Pass_Server
			$this->Pass_Server->LinkCustomAttributes = "";
			$this->Pass_Server->HrefValue = "";

			// User_TdServer
			$this->User_TdServer->LinkCustomAttributes = "";
			$this->User_TdServer->HrefValue = "";

			// Pass_TdServer
			$this->Pass_TdServer->LinkCustomAttributes = "";
			$this->Pass_TdServer->HrefValue = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

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
		if (!$this->Nro_Serie->FldIsDetailKey && !is_null($this->Nro_Serie->FormValue) && $this->Nro_Serie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nro_Serie->FldCaption(), $this->Nro_Serie->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Cant_Net_Asoc->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cant_Net_Asoc->FldErrMsg());
		}
		if (!$this->Id_Marca->FldIsDetailKey && !is_null($this->Id_Marca->FormValue) && $this->Id_Marca->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Marca->FldCaption(), $this->Id_Marca->ReqErrMsg));
		}
		if (!$this->Id_Modelo->FldIsDetailKey && !is_null($this->Id_Modelo->FormValue) && $this->Id_Modelo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Modelo->FldCaption(), $this->Id_Modelo->ReqErrMsg));
		}
		if (!$this->Id_SO->FldIsDetailKey && !is_null($this->Id_SO->FormValue) && $this->Id_SO->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_SO->FldCaption(), $this->Id_SO->ReqErrMsg));
		}
		if (!$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
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

			// Nro_Serie
			$this->Nro_Serie->SetDbValueDef($rsnew, $this->Nro_Serie->CurrentValue, "", $this->Nro_Serie->ReadOnly);

			// SN
			$this->SN->SetDbValueDef($rsnew, $this->SN->CurrentValue, NULL, $this->SN->ReadOnly);

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->SetDbValueDef($rsnew, $this->Cant_Net_Asoc->CurrentValue, NULL, $this->Cant_Net_Asoc->ReadOnly);

			// Id_Marca
			$this->Id_Marca->SetDbValueDef($rsnew, $this->Id_Marca->CurrentValue, 0, $this->Id_Marca->ReadOnly);

			// Id_Modelo
			$this->Id_Modelo->SetDbValueDef($rsnew, $this->Id_Modelo->CurrentValue, 0, $this->Id_Modelo->ReadOnly);

			// Id_SO
			$this->Id_SO->SetDbValueDef($rsnew, $this->Id_SO->CurrentValue, 0, $this->Id_SO->ReadOnly);

			// Id_Estado
			$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, $this->Id_Estado->ReadOnly);

			// User_Server
			$this->User_Server->SetDbValueDef($rsnew, $this->User_Server->CurrentValue, NULL, $this->User_Server->ReadOnly);

			// Pass_Server
			$this->Pass_Server->SetDbValueDef($rsnew, $this->Pass_Server->CurrentValue, NULL, $this->Pass_Server->ReadOnly);

			// User_TdServer
			$this->User_TdServer->SetDbValueDef($rsnew, $this->User_TdServer->CurrentValue, NULL, $this->User_TdServer->ReadOnly);

			// Pass_TdServer
			$this->Pass_TdServer->SetDbValueDef($rsnew, $this->Pass_TdServer->CurrentValue, NULL, $this->Pass_TdServer->ReadOnly);

			// Cue
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setQueryStringValue($_GET["fk_Cue"]);
					$this->Cue->setQueryStringValue($GLOBALS["dato_establecimiento"]->Cue->QueryStringValue);
					$this->Cue->setSessionValue($this->Cue->QueryStringValue);
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setFormValue($_POST["fk_Cue"]);
					$this->Cue->setFormValue($GLOBALS["dato_establecimiento"]->Cue->FormValue);
					$this->Cue->setSessionValue($this->Cue->FormValue);
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
			if ($sMasterTblVar <> "dato_establecimiento") {
				if ($this->Cue->CurrentValue == "") $this->Cue->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("servidor_escolarlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Marca":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Marca` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Marca` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modelo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modelo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modelo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_SO":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_SO` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
			$sWhereWrk = "";
			$this->Id_SO->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_SO` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
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
		$table = 'servidor_escolar';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'servidor_escolar';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

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
if (!isset($servidor_escolar_edit)) $servidor_escolar_edit = new cservidor_escolar_edit();

// Page init
$servidor_escolar_edit->Page_Init();

// Page main
$servidor_escolar_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$servidor_escolar_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fservidor_escolaredit = new ew_Form("fservidor_escolaredit", "edit");

// Validate form
fservidor_escolaredit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nro_Serie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Nro_Serie->FldCaption(), $servidor_escolar->Nro_Serie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cant_Net_Asoc");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($servidor_escolar->Cant_Net_Asoc->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Marca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Marca->FldCaption(), $servidor_escolar->Id_Marca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Modelo->FldCaption(), $servidor_escolar->Id_Modelo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_SO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_SO->FldCaption(), $servidor_escolar->Id_SO->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Estado->FldCaption(), $servidor_escolar->Id_Estado->ReqErrMsg)) ?>");

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
fservidor_escolaredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservidor_escolaredit.ValidateRequired = true;
<?php } else { ?>
fservidor_escolaredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fservidor_escolaredit.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca_server"};
fservidor_escolaredit.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo_server"};
fservidor_escolaredit.Lists["x_Id_SO"] = {"LinkField":"x_Id_SO","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"so_server"};
fservidor_escolaredit.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_server"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$servidor_escolar_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $servidor_escolar_edit->ShowPageHeader(); ?>
<?php
$servidor_escolar_edit->ShowMessage();
?>
<form name="fservidor_escolaredit" id="fservidor_escolaredit" class="<?php echo $servidor_escolar_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($servidor_escolar_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $servidor_escolar_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="servidor_escolar">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($servidor_escolar_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($servidor_escolar->getCurrentMasterTable() == "dato_establecimiento") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $servidor_escolar->Cue->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
	<div id="r_Nro_Serie" class="form-group">
		<label id="elh_servidor_escolar_Nro_Serie" for="x_Nro_Serie" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Nro_Serie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Nro_Serie->CellAttributes() ?>>
<span id="el_servidor_escolar_Nro_Serie">
<input type="text" data-table="servidor_escolar" data-field="x_Nro_Serie" data-page="1" name="x_Nro_Serie" id="x_Nro_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Nro_Serie->EditValue ?>"<?php echo $servidor_escolar->Nro_Serie->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->Nro_Serie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->SN->Visible) { // SN ?>
	<div id="r_SN" class="form-group">
		<label id="elh_servidor_escolar_SN" for="x_SN" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->SN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->SN->CellAttributes() ?>>
<span id="el_servidor_escolar_SN">
<input type="text" data-table="servidor_escolar" data-field="x_SN" data-page="1" name="x_SN" id="x_SN" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->SN->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->SN->EditValue ?>"<?php echo $servidor_escolar->SN->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->SN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
	<div id="r_Cant_Net_Asoc" class="form-group">
		<label id="elh_servidor_escolar_Cant_Net_Asoc" for="x_Cant_Net_Asoc" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Cant_Net_Asoc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Cant_Net_Asoc->CellAttributes() ?>>
<span id="el_servidor_escolar_Cant_Net_Asoc">
<input type="text" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" data-page="1" name="x_Cant_Net_Asoc" id="x_Cant_Net_Asoc" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cant_Net_Asoc->EditValue ?>"<?php echo $servidor_escolar->Cant_Net_Asoc->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->Cant_Net_Asoc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
	<div id="r_Id_Marca" class="form-group">
		<label id="elh_servidor_escolar_Id_Marca" for="x_Id_Marca" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Id_Marca->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Id_Marca->CellAttributes() ?>>
<span id="el_servidor_escolar_Id_Marca">
<select data-table="servidor_escolar" data-field="x_Id_Marca" data-page="1" data-value-separator="<?php echo $servidor_escolar->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x_Id_Marca" name="x_Id_Marca"<?php echo $servidor_escolar->Id_Marca->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->SelectOptionListHtml("x_Id_Marca") ?>
</select>
<input type="hidden" name="s_x_Id_Marca" id="s_x_Id_Marca" value="<?php echo $servidor_escolar->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php echo $servidor_escolar->Id_Marca->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
	<div id="r_Id_Modelo" class="form-group">
		<label id="elh_servidor_escolar_Id_Modelo" for="x_Id_Modelo" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Id_Modelo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Id_Modelo->CellAttributes() ?>>
<span id="el_servidor_escolar_Id_Modelo">
<select data-table="servidor_escolar" data-field="x_Id_Modelo" data-page="1" data-value-separator="<?php echo $servidor_escolar->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modelo" name="x_Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->SelectOptionListHtml("x_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x_Id_Modelo" id="s_x_Id_Modelo" value="<?php echo $servidor_escolar->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php echo $servidor_escolar->Id_Modelo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
	<div id="r_Id_SO" class="form-group">
		<label id="elh_servidor_escolar_Id_SO" for="x_Id_SO" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Id_SO->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Id_SO->CellAttributes() ?>>
<span id="el_servidor_escolar_Id_SO">
<select data-table="servidor_escolar" data-field="x_Id_SO" data-page="1" data-value-separator="<?php echo $servidor_escolar->Id_SO->DisplayValueSeparatorAttribute() ?>" id="x_Id_SO" name="x_Id_SO"<?php echo $servidor_escolar->Id_SO->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->SelectOptionListHtml("x_Id_SO") ?>
</select>
<input type="hidden" name="s_x_Id_SO" id="s_x_Id_SO" value="<?php echo $servidor_escolar->Id_SO->LookupFilterQuery() ?>">
</span>
<?php echo $servidor_escolar->Id_SO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label id="elh_servidor_escolar_Id_Estado" for="x_Id_Estado" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Id_Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Id_Estado->CellAttributes() ?>>
<span id="el_servidor_escolar_Id_Estado">
<select data-table="servidor_escolar" data-field="x_Id_Estado" data-page="1" data-value-separator="<?php echo $servidor_escolar->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $servidor_escolar->Id_Estado->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $servidor_escolar->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $servidor_escolar->Id_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
	<div id="r_User_Server" class="form-group">
		<label id="elh_servidor_escolar_User_Server" for="x_User_Server" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->User_Server->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->User_Server->CellAttributes() ?>>
<span id="el_servidor_escolar_User_Server">
<input type="text" data-table="servidor_escolar" data-field="x_User_Server" data-page="1" name="x_User_Server" id="x_User_Server" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_Server->EditValue ?>"<?php echo $servidor_escolar->User_Server->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->User_Server->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Pass_Server->Visible) { // Pass_Server ?>
	<div id="r_Pass_Server" class="form-group">
		<label id="elh_servidor_escolar_Pass_Server" for="x_Pass_Server" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Pass_Server->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Pass_Server->CellAttributes() ?>>
<span id="el_servidor_escolar_Pass_Server">
<input type="text" data-table="servidor_escolar" data-field="x_Pass_Server" data-page="1" name="x_Pass_Server" id="x_Pass_Server" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Pass_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Pass_Server->EditValue ?>"<?php echo $servidor_escolar->Pass_Server->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->Pass_Server->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
	<div id="r_User_TdServer" class="form-group">
		<label id="elh_servidor_escolar_User_TdServer" for="x_User_TdServer" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->User_TdServer->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->User_TdServer->CellAttributes() ?>>
<span id="el_servidor_escolar_User_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_User_TdServer" data-page="1" name="x_User_TdServer" id="x_User_TdServer" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_TdServer->EditValue ?>"<?php echo $servidor_escolar->User_TdServer->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->User_TdServer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Pass_TdServer->Visible) { // Pass_TdServer ?>
	<div id="r_Pass_TdServer" class="form-group">
		<label id="elh_servidor_escolar_Pass_TdServer" for="x_Pass_TdServer" class="col-sm-2 control-label ewLabel"><?php echo $servidor_escolar->Pass_TdServer->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $servidor_escolar->Pass_TdServer->CellAttributes() ?>>
<span id="el_servidor_escolar_Pass_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_Pass_TdServer" data-page="1" name="x_Pass_TdServer" id="x_Pass_TdServer" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Pass_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Pass_TdServer->EditValue ?>"<?php echo $servidor_escolar->Pass_TdServer->EditAttributes() ?>>
</span>
<?php echo $servidor_escolar->Pass_TdServer->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if ($servidor_escolar->Cue->getSessionValue() <> "") { ?>
<input type="hidden" id="x_Cue" name="x_Cue" value="<?php echo ew_HtmlEncode($servidor_escolar->Cue->CurrentValue) ?>">
<?php } else { ?>
<span id="el_servidor_escolar_Cue">
<input type="hidden" data-table="servidor_escolar" data-field="x_Cue" data-page="1" name="x_Cue" id="x_Cue" value="<?php echo ew_HtmlEncode($servidor_escolar->Cue->CurrentValue) ?>">
</span>
<?php } ?>
<?php if (!$servidor_escolar_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $servidor_escolar_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fservidor_escolaredit.Init();
</script>
<?php
$servidor_escolar_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$servidor_escolar_edit->Page_Terminate();
?>
