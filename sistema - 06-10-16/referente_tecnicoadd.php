<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "referente_tecnicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$referente_tecnico_add = NULL; // Initialize page object first

class creferente_tecnico_add extends creferente_tecnico {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'referente_tecnico';

	// Page object name
	var $PageObjName = 'referente_tecnico_add';

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

		// Table object (referente_tecnico)
		if (!isset($GLOBALS["referente_tecnico"]) || get_class($GLOBALS["referente_tecnico"]) == "creferente_tecnico") {
			$GLOBALS["referente_tecnico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referente_tecnico"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'referente_tecnico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("referente_tecnicolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->DniRte->SetVisibility();
		$this->Apelldio_Nombre->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Id_Turno->SetVisibility();
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
		global $EW_EXPORT, $referente_tecnico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($referente_tecnico);
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
			if (@$_GET["DniRte"] != "") {
				$this->DniRte->setQueryStringValue($_GET["DniRte"]);
				$this->setKey("DniRte", $this->DniRte->CurrentValue); // Set up key
			} else {
				$this->setKey("DniRte", ""); // Clear key
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
					$this->Page_Terminate("referente_tecnicolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "referente_tecnicolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "referente_tecnicoview.php")
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
		$this->DniRte->CurrentValue = NULL;
		$this->DniRte->OldValue = $this->DniRte->CurrentValue;
		$this->Apelldio_Nombre->CurrentValue = NULL;
		$this->Apelldio_Nombre->OldValue = $this->Apelldio_Nombre->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Telefono->CurrentValue = NULL;
		$this->Telefono->OldValue = $this->Telefono->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Mail->CurrentValue = NULL;
		$this->Mail->OldValue = $this->Mail->CurrentValue;
		$this->Id_Turno->CurrentValue = NULL;
		$this->Id_Turno->OldValue = $this->Id_Turno->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->DniRte->FldIsDetailKey) {
			$this->DniRte->setFormValue($objForm->GetValue("x_DniRte"));
		}
		if (!$this->Apelldio_Nombre->FldIsDetailKey) {
			$this->Apelldio_Nombre->setFormValue($objForm->GetValue("x_Apelldio_Nombre"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Telefono->FldIsDetailKey) {
			$this->Telefono->setFormValue($objForm->GetValue("x_Telefono"));
		}
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		if (!$this->Mail->FldIsDetailKey) {
			$this->Mail->setFormValue($objForm->GetValue("x_Mail"));
		}
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
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
		$this->LoadOldRecord();
		$this->DniRte->CurrentValue = $this->DniRte->FormValue;
		$this->Apelldio_Nombre->CurrentValue = $this->Apelldio_Nombre->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono->CurrentValue = $this->Telefono->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Mail->CurrentValue = $this->Mail->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
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
		$this->DniRte->setDbValue($rs->fields('DniRte'));
		$this->Apelldio_Nombre->setDbValue($rs->fields('Apelldio_Nombre'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->DniRte->DbValue = $row['DniRte'];
		$this->Apelldio_Nombre->DbValue = $row['Apelldio_Nombre'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Celular->DbValue = $row['Celular'];
		$this->Mail->DbValue = $row['Mail'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("DniRte")) <> "")
			$this->DniRte->CurrentValue = $this->getKey("DniRte"); // DniRte
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
		// DniRte
		// Apelldio_Nombre
		// Domicilio
		// Telefono
		// Celular
		// Mail
		// Id_Turno
		// Fecha_Actualizacion
		// Usuario
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// DniRte
		$this->DniRte->ViewValue = $this->DniRte->CurrentValue;
		$this->DniRte->ViewCustomAttributes = "";

		// Apelldio_Nombre
		$this->Apelldio_Nombre->ViewValue = $this->Apelldio_Nombre->CurrentValue;
		$this->Apelldio_Nombre->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";
			$this->DniRte->TooltipValue = "";

			// Apelldio_Nombre
			$this->Apelldio_Nombre->LinkCustomAttributes = "";
			$this->Apelldio_Nombre->HrefValue = "";
			$this->Apelldio_Nombre->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";
			$this->Mail->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = ew_HtmlEncode($this->DniRte->CurrentValue);
			$this->DniRte->PlaceHolder = ew_RemoveHtml($this->DniRte->FldCaption());

			// Apelldio_Nombre
			$this->Apelldio_Nombre->EditAttrs["class"] = "form-control";
			$this->Apelldio_Nombre->EditCustomAttributes = "";
			$this->Apelldio_Nombre->EditValue = ew_HtmlEncode($this->Apelldio_Nombre->CurrentValue);
			$this->Apelldio_Nombre->PlaceHolder = ew_RemoveHtml($this->Apelldio_Nombre->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono
			$this->Telefono->EditAttrs["class"] = "form-control";
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->CurrentValue);
			$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

			// Celular
			$this->Celular->EditAttrs["class"] = "form-control";
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);
			$this->Celular->PlaceHolder = ew_RemoveHtml($this->Celular->FldCaption());

			// Mail
			$this->Mail->EditAttrs["class"] = "form-control";
			$this->Mail->EditCustomAttributes = "";
			$this->Mail->EditValue = ew_HtmlEncode($this->Mail->CurrentValue);
			$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// DniRte

			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";

			// Apelldio_Nombre
			$this->Apelldio_Nombre->LinkCustomAttributes = "";
			$this->Apelldio_Nombre->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

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
		if (!$this->DniRte->FldIsDetailKey && !is_null($this->DniRte->FormValue) && $this->DniRte->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DniRte->FldCaption(), $this->DniRte->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->DniRte->FormValue)) {
			ew_AddMessage($gsFormError, $this->DniRte->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Telefono->FormValue)) {
			ew_AddMessage($gsFormError, $this->Telefono->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Celular->FormValue)) {
			ew_AddMessage($gsFormError, $this->Celular->FldErrMsg());
		}
		if (!ew_CheckEmail($this->Mail->FormValue)) {
			ew_AddMessage($gsFormError, $this->Mail->FldErrMsg());
		}
		if (!$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
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

		// Check referential integrity for master table 'dato_establecimiento'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_dato_establecimiento();
		if ($this->Cue->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["dato_establecimiento"])) $GLOBALS["dato_establecimiento"] = new cdato_establecimiento();
			$rsmaster = $GLOBALS["dato_establecimiento"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "dato_establecimiento", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// DniRte
		$this->DniRte->SetDbValueDef($rsnew, $this->DniRte->CurrentValue, 0, FALSE);

		// Apelldio_Nombre
		$this->Apelldio_Nombre->SetDbValueDef($rsnew, $this->Apelldio_Nombre->CurrentValue, NULL, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Telefono
		$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Mail
		$this->Mail->SetDbValueDef($rsnew, $this->Mail->CurrentValue, NULL, FALSE);

		// Id_Turno
		$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, FALSE);

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Cue
		if ($this->Cue->getSessionValue() <> "") {
			$rsnew['Cue'] = $this->Cue->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['DniRte']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("referente_tecnicolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
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
		$table = 'referente_tecnico';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['DniRte'];

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
if (!isset($referente_tecnico_add)) $referente_tecnico_add = new creferente_tecnico_add();

// Page init
$referente_tecnico_add->Page_Init();

// Page main
$referente_tecnico_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = freferente_tecnicoadd = new ew_Form("freferente_tecnicoadd", "add");

// Validate form
freferente_tecnicoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->DniRte->FldCaption(), $referente_tecnico->DniRte->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->DniRte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Telefono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Celular");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Celular->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Mail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Id_Turno->FldCaption(), $referente_tecnico->Id_Turno->ReqErrMsg)) ?>");

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
freferente_tecnicoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicoadd.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicoadd.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$referente_tecnico_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $referente_tecnico_add->ShowPageHeader(); ?>
<?php
$referente_tecnico_add->ShowMessage();
?>
<form name="freferente_tecnicoadd" id="freferente_tecnicoadd" class="<?php echo $referente_tecnico_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referente_tecnico_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referente_tecnico_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referente_tecnico">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($referente_tecnico_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($referente_tecnico->getCurrentMasterTable() == "dato_establecimiento") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $referente_tecnico->Cue->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
	<div id="r_DniRte" class="form-group">
		<label id="elh_referente_tecnico_DniRte" for="x_DniRte" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->DniRte->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->DniRte->CellAttributes() ?>>
<span id="el_referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" data-page="1" name="x_DniRte" id="x_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->DniRte->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Apelldio_Nombre->Visible) { // Apelldio_Nombre ?>
	<div id="r_Apelldio_Nombre" class="form-group">
		<label id="elh_referente_tecnico_Apelldio_Nombre" for="x_Apelldio_Nombre" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Apelldio_Nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Apelldio_Nombre->CellAttributes() ?>>
<span id="el_referente_tecnico_Apelldio_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" data-page="1" name="x_Apelldio_Nombre" id="x_Apelldio_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apelldio_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apelldio_Nombre->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Apelldio_Nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label id="elh_referente_tecnico_Domicilio" for="x_Domicilio" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Domicilio->CellAttributes() ?>>
<span id="el_referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" data-page="1" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Domicilio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
	<div id="r_Telefono" class="form-group">
		<label id="elh_referente_tecnico_Telefono" for="x_Telefono" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Telefono->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Telefono->CellAttributes() ?>>
<span id="el_referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" data-page="1" name="x_Telefono" id="x_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Telefono->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
	<div id="r_Celular" class="form-group">
		<label id="elh_referente_tecnico_Celular" for="x_Celular" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Celular->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Celular->CellAttributes() ?>>
<span id="el_referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" data-page="1" name="x_Celular" id="x_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Celular->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
	<div id="r_Mail" class="form-group">
		<label id="elh_referente_tecnico_Mail" for="x_Mail" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Mail->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Mail->CellAttributes() ?>>
<span id="el_referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" data-page="1" name="x_Mail" id="x_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Mail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label id="elh_referente_tecnico_Id_Turno" for="x_Id_Turno" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Id_Turno->CellAttributes() ?>>
<span id="el_referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-page="1" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php echo $referente_tecnico->Id_Turno->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($referente_tecnico->Cue->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Cue" id="x_Cue" value="<?php echo ew_HtmlEncode(strval($referente_tecnico->Cue->getSessionValue())) ?>">
<?php } ?>
<?php if (!$referente_tecnico_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $referente_tecnico_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freferente_tecnicoadd.Init();
</script>
<?php
$referente_tecnico_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$referente_tecnico_add->Page_Terminate();
?>
