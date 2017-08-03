<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detalle_atencioninfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detalle_atencion_add = NULL; // Initialize page object first

class cdetalle_atencion_add extends cdetalle_atencion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'detalle_atencion';

	// Page object name
	var $PageObjName = 'detalle_atencion_add';

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

		// Table object (detalle_atencion)
		if (!isset($GLOBALS["detalle_atencion"]) || get_class($GLOBALS["detalle_atencion"]) == "cdetalle_atencion") {
			$GLOBALS["detalle_atencion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_atencion"];
		}

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_atencion', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("detalle_atencionlist.php"));
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
		$this->Id_Tipo_Falla->SetVisibility();
		$this->Id_Problema->SetVisibility();
		$this->Descripcion_Problema->SetVisibility();
		$this->Id_Tipo_Sol_Problem->SetVisibility();
		$this->Id_Estado_Atenc->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

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
		global $EW_EXPORT, $detalle_atencion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detalle_atencion);
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
			if (@$_GET["NroSerie"] != "") {
				$this->NroSerie->setQueryStringValue($_GET["NroSerie"]);
				$this->setKey("NroSerie", $this->NroSerie->CurrentValue); // Set up key
			} else {
				$this->setKey("NroSerie", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["Id_Detalle_Atencion"] != "") {
				$this->Id_Detalle_Atencion->setQueryStringValue($_GET["Id_Detalle_Atencion"]);
				$this->setKey("Id_Detalle_Atencion", $this->Id_Detalle_Atencion->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Detalle_Atencion", ""); // Clear key
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
					$this->Page_Terminate("detalle_atencionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "detalle_atencionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "detalle_atencionview.php")
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
		$this->Id_Tipo_Falla->CurrentValue = 2;
		$this->Id_Problema->CurrentValue = 2;
		$this->Descripcion_Problema->CurrentValue = NULL;
		$this->Descripcion_Problema->OldValue = $this->Descripcion_Problema->CurrentValue;
		$this->Id_Tipo_Sol_Problem->CurrentValue = 1;
		$this->Id_Estado_Atenc->CurrentValue = 4;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Tipo_Falla->FldIsDetailKey) {
			$this->Id_Tipo_Falla->setFormValue($objForm->GetValue("x_Id_Tipo_Falla"));
		}
		if (!$this->Id_Problema->FldIsDetailKey) {
			$this->Id_Problema->setFormValue($objForm->GetValue("x_Id_Problema"));
		}
		if (!$this->Descripcion_Problema->FldIsDetailKey) {
			$this->Descripcion_Problema->setFormValue($objForm->GetValue("x_Descripcion_Problema"));
		}
		if (!$this->Id_Tipo_Sol_Problem->FldIsDetailKey) {
			$this->Id_Tipo_Sol_Problem->setFormValue($objForm->GetValue("x_Id_Tipo_Sol_Problem"));
		}
		if (!$this->Id_Estado_Atenc->FldIsDetailKey) {
			$this->Id_Estado_Atenc->setFormValue($objForm->GetValue("x_Id_Estado_Atenc"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		if (!$this->Id_Atencion->FldIsDetailKey)
			$this->Id_Atencion->setFormValue($objForm->GetValue("x_Id_Atencion"));
		if (!$this->NroSerie->FldIsDetailKey)
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Atencion->CurrentValue = $this->Id_Atencion->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Id_Tipo_Falla->CurrentValue = $this->Id_Tipo_Falla->FormValue;
		$this->Id_Problema->CurrentValue = $this->Id_Problema->FormValue;
		$this->Descripcion_Problema->CurrentValue = $this->Descripcion_Problema->FormValue;
		$this->Id_Tipo_Sol_Problem->CurrentValue = $this->Id_Tipo_Sol_Problem->FormValue;
		$this->Id_Estado_Atenc->CurrentValue = $this->Id_Estado_Atenc->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Id_Detalle_Atencion->setDbValue($rs->fields('Id_Detalle_Atencion'));
		$this->Id_Tipo_Falla->setDbValue($rs->fields('Id_Tipo_Falla'));
		$this->Id_Problema->setDbValue($rs->fields('Id_Problema'));
		$this->Descripcion_Problema->setDbValue($rs->fields('Descripcion_Problema'));
		$this->Id_Tipo_Sol_Problem->setDbValue($rs->fields('Id_Tipo_Sol_Problem'));
		$this->Id_Estado_Atenc->setDbValue($rs->fields('Id_Estado_Atenc'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Atencion->DbValue = $row['Id_Atencion'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Id_Detalle_Atencion->DbValue = $row['Id_Detalle_Atencion'];
		$this->Id_Tipo_Falla->DbValue = $row['Id_Tipo_Falla'];
		$this->Id_Problema->DbValue = $row['Id_Problema'];
		$this->Descripcion_Problema->DbValue = $row['Descripcion_Problema'];
		$this->Id_Tipo_Sol_Problem->DbValue = $row['Id_Tipo_Sol_Problem'];
		$this->Id_Estado_Atenc->DbValue = $row['Id_Estado_Atenc'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Atencion")) <> "")
			$this->Id_Atencion->CurrentValue = $this->getKey("Id_Atencion"); // Id_Atencion
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("NroSerie")) <> "")
			$this->NroSerie->CurrentValue = $this->getKey("NroSerie"); // NroSerie
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("Id_Detalle_Atencion")) <> "")
			$this->Id_Detalle_Atencion->CurrentValue = $this->getKey("Id_Detalle_Atencion"); // Id_Detalle_Atencion
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
		// Id_Atencion
		// NroSerie
		// Id_Detalle_Atencion
		// Id_Tipo_Falla
		// Id_Problema
		// Descripcion_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->ViewValue = $this->Id_Detalle_Atencion->CurrentValue;
		$this->Id_Detalle_Atencion->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		if (strval($this->Id_Tipo_Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Id_Tipo_Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Falla->ViewValue = NULL;
		}
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		if (strval($this->Id_Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Id_Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Problema->ViewValue = $this->Id_Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
			}
		} else {
			$this->Id_Problema->ViewValue = NULL;
		}
		$this->Id_Problema->ViewCustomAttributes = "";

		// Descripcion_Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		if (strval($this->Id_Tipo_Sol_Problem->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Tipo_Sol_Problem->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Sol_Problem->ViewValue = NULL;
		}
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		if (strval($this->Id_Estado_Atenc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Estado_Atenc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Atenc->ViewValue = NULL;
		}
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->LinkCustomAttributes = "";
			$this->Id_Tipo_Falla->HrefValue = "";
			$this->Id_Tipo_Falla->TooltipValue = "";

			// Id_Problema
			$this->Id_Problema->LinkCustomAttributes = "";
			$this->Id_Problema->HrefValue = "";
			$this->Id_Problema->TooltipValue = "";

			// Descripcion_Problema
			$this->Descripcion_Problema->LinkCustomAttributes = "";
			$this->Descripcion_Problema->HrefValue = "";
			$this->Descripcion_Problema->TooltipValue = "";

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->HrefValue = "";
			$this->Id_Tipo_Sol_Problem->TooltipValue = "";

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->LinkCustomAttributes = "";
			$this->Id_Estado_Atenc->HrefValue = "";
			$this->Id_Estado_Atenc->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Falla->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Falla->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Id_Tipo_Falla->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Falla->EditValue = $arwrk;

			// Id_Problema
			$this->Id_Problema->EditAttrs["class"] = "form-control";
			$this->Id_Problema->EditCustomAttributes = "";
			if (trim(strval($this->Id_Problema->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `problema`";
			$sWhereWrk = "";
			$this->Id_Problema->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Problema->EditValue = $arwrk;

			// Descripcion_Problema
			$this->Descripcion_Problema->EditAttrs["class"] = "form-control";
			$this->Descripcion_Problema->EditCustomAttributes = "";
			$this->Descripcion_Problema->EditValue = ew_HtmlEncode($this->Descripcion_Problema->CurrentValue);
			$this->Descripcion_Problema->PlaceHolder = ew_RemoveHtml($this->Descripcion_Problema->FldCaption());

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Sol_Problem->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Sol_Problem->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Tipo_Sol_Problem->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Sol_Problem->EditValue = $arwrk;

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Atenc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Atenc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Estado_Atenc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Atenc->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Add refer script
			// Id_Tipo_Falla

			$this->Id_Tipo_Falla->LinkCustomAttributes = "";
			$this->Id_Tipo_Falla->HrefValue = "";

			// Id_Problema
			$this->Id_Problema->LinkCustomAttributes = "";
			$this->Id_Problema->HrefValue = "";

			// Descripcion_Problema
			$this->Descripcion_Problema->LinkCustomAttributes = "";
			$this->Descripcion_Problema->HrefValue = "";

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->HrefValue = "";

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->LinkCustomAttributes = "";
			$this->Id_Estado_Atenc->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
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
		if (!$this->Id_Tipo_Falla->FldIsDetailKey && !is_null($this->Id_Tipo_Falla->FormValue) && $this->Id_Tipo_Falla->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Falla->FldCaption(), $this->Id_Tipo_Falla->ReqErrMsg));
		}
		if (!$this->Id_Problema->FldIsDetailKey && !is_null($this->Id_Problema->FormValue) && $this->Id_Problema->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Problema->FldCaption(), $this->Id_Problema->ReqErrMsg));
		}
		if (!$this->Descripcion_Problema->FldIsDetailKey && !is_null($this->Descripcion_Problema->FormValue) && $this->Descripcion_Problema->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Descripcion_Problema->FldCaption(), $this->Descripcion_Problema->ReqErrMsg));
		}
		if (!$this->Id_Tipo_Sol_Problem->FldIsDetailKey && !is_null($this->Id_Tipo_Sol_Problem->FormValue) && $this->Id_Tipo_Sol_Problem->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Sol_Problem->FldCaption(), $this->Id_Tipo_Sol_Problem->ReqErrMsg));
		}
		if (!$this->Id_Estado_Atenc->FldIsDetailKey && !is_null($this->Id_Estado_Atenc->FormValue) && $this->Id_Estado_Atenc->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Atenc->FldCaption(), $this->Id_Estado_Atenc->ReqErrMsg));
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
		if ($this->NroSerie->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->getSessionValue(), "DB"), $sMasterFilter);
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

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->SetDbValueDef($rsnew, $this->Id_Tipo_Falla->CurrentValue, 0, FALSE);

		// Id_Problema
		$this->Id_Problema->SetDbValueDef($rsnew, $this->Id_Problema->CurrentValue, 0, FALSE);

		// Descripcion_Problema
		$this->Descripcion_Problema->SetDbValueDef($rsnew, $this->Descripcion_Problema->CurrentValue, NULL, FALSE);

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->SetDbValueDef($rsnew, $this->Id_Tipo_Sol_Problem->CurrentValue, 0, FALSE);

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->SetDbValueDef($rsnew, $this->Id_Estado_Atenc->CurrentValue, 0, FALSE);

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Id_Atencion
		if ($this->Id_Atencion->getSessionValue() <> "") {
			$rsnew['Id_Atencion'] = $this->Id_Atencion->getSessionValue();
		}

		// NroSerie
		if ($this->NroSerie->getSessionValue() <> "") {
			$rsnew['NroSerie'] = $this->NroSerie->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Id_Atencion']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['NroSerie']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Id_Detalle_Atencion->setDbValue($conn->Insert_ID());
				$rsnew['Id_Detalle_Atencion'] = $this->Id_Detalle_Atencion->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detalle_atencionlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Tipo_Falla":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Falla` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Id_Tipo_Falla->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Falla` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Problema":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Problema` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
			$sWhereWrk = "";
			$this->Id_Problema->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Problema` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Sol_Problem":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Tipo_Sol_Problem->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Sol_Problem` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Atenc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Atenc` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Estado_Atenc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Atenc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
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
		$table = 'detalle_atencion';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'detalle_atencion';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Detalle_Atencion'];

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
if (!isset($detalle_atencion_add)) $detalle_atencion_add = new cdetalle_atencion_add();

// Page init
$detalle_atencion_add->Page_Init();

// Page main
$detalle_atencion_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_atencion_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdetalle_atencionadd = new ew_Form("fdetalle_atencionadd", "add");

// Validate form
fdetalle_atencionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Tipo_Falla");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Tipo_Falla->FldCaption(), $detalle_atencion->Id_Tipo_Falla->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Problema");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Problema->FldCaption(), $detalle_atencion->Id_Problema->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Descripcion_Problema");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Descripcion_Problema->FldCaption(), $detalle_atencion->Descripcion_Problema->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Sol_Problem");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption(), $detalle_atencion->Id_Tipo_Sol_Problem->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Atenc");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Estado_Atenc->FldCaption(), $detalle_atencion->Id_Estado_Atenc->ReqErrMsg)) ?>");

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
fdetalle_atencionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_atencionadd.ValidateRequired = true;
<?php } else { ?>
fdetalle_atencionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_atencionadd.Lists["x_Id_Tipo_Falla"] = {"LinkField":"x_Id_Tipo_Falla","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_falla"};
fdetalle_atencionadd.Lists["x_Id_Problema"] = {"LinkField":"x_Id_Problema","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
fdetalle_atencionadd.Lists["x_Id_Tipo_Sol_Problem"] = {"LinkField":"x_Id_Tipo_Sol_Problem","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_solucion_problema"};
fdetalle_atencionadd.Lists["x_Id_Estado_Atenc"] = {"LinkField":"x_Id_Estado_Atenc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_actual_solucion_problema"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detalle_atencion_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detalle_atencion_add->ShowPageHeader(); ?>
<?php
$detalle_atencion_add->ShowMessage();
?>
<form name="fdetalle_atencionadd" id="fdetalle_atencionadd" class="<?php echo $detalle_atencion_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_atencion_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_atencion_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_atencion">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($detalle_atencion_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($detalle_atencion->getCurrentMasterTable() == "atencion_equipos") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="atencion_equipos">
<input type="hidden" name="fk_Id_Atencion" value="<?php echo $detalle_atencion->Id_Atencion->getSessionValue() ?>">
<input type="hidden" name="fk_NroSerie" value="<?php echo $detalle_atencion->NroSerie->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
	<div id="r_Id_Tipo_Falla" class="form-group">
		<label id="elh_detalle_atencion_Id_Tipo_Falla" for="x_Id_Tipo_Falla" class="col-sm-2 control-label ewLabel"><?php echo $detalle_atencion->Id_Tipo_Falla->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_atencion->Id_Tipo_Falla->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Tipo_Falla">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Falla->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Falla" name="x_Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->SelectOptionListHtml("x_Id_Tipo_Falla") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Falla" id="s_x_Id_Tipo_Falla" value="<?php echo $detalle_atencion->Id_Tipo_Falla->LookupFilterQuery() ?>">
</span>
<?php echo $detalle_atencion->Id_Tipo_Falla->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
	<div id="r_Id_Problema" class="form-group">
		<label id="elh_detalle_atencion_Id_Problema" for="x_Id_Problema" class="col-sm-2 control-label ewLabel"><?php echo $detalle_atencion->Id_Problema->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_atencion->Id_Problema->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Problema">
<select data-table="detalle_atencion" data-field="x_Id_Problema" data-value-separator="<?php echo $detalle_atencion->Id_Problema->DisplayValueSeparatorAttribute() ?>" id="x_Id_Problema" name="x_Id_Problema"<?php echo $detalle_atencion->Id_Problema->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->SelectOptionListHtml("x_Id_Problema") ?>
</select>
<input type="hidden" name="s_x_Id_Problema" id="s_x_Id_Problema" value="<?php echo $detalle_atencion->Id_Problema->LookupFilterQuery() ?>">
</span>
<?php echo $detalle_atencion->Id_Problema->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
	<div id="r_Descripcion_Problema" class="form-group">
		<label id="elh_detalle_atencion_Descripcion_Problema" for="x_Descripcion_Problema" class="col-sm-2 control-label ewLabel"><?php echo $detalle_atencion->Descripcion_Problema->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_atencion->Descripcion_Problema->CellAttributes() ?>>
<span id="el_detalle_atencion_Descripcion_Problema">
<input type="text" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x_Descripcion_Problema" id="x_Descripcion_Problema" maxlength="400" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Descripcion_Problema->EditValue ?>"<?php echo $detalle_atencion->Descripcion_Problema->EditAttributes() ?>>
</span>
<?php echo $detalle_atencion->Descripcion_Problema->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
	<div id="r_Id_Tipo_Sol_Problem" class="form-group">
		<label id="elh_detalle_atencion_Id_Tipo_Sol_Problem" for="x_Id_Tipo_Sol_Problem" class="col-sm-2 control-label ewLabel"><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Tipo_Sol_Problem">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Sol_Problem" name="x_Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->SelectOptionListHtml("x_Id_Tipo_Sol_Problem") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Sol_Problem" id="s_x_Id_Tipo_Sol_Problem" value="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->LookupFilterQuery() ?>">
</span>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
	<div id="r_Id_Estado_Atenc" class="form-group">
		<label id="elh_detalle_atencion_Id_Estado_Atenc" for="x_Id_Estado_Atenc" class="col-sm-2 control-label ewLabel"><?php echo $detalle_atencion->Id_Estado_Atenc->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_atencion->Id_Estado_Atenc->CellAttributes() ?>>
<span id="el_detalle_atencion_Id_Estado_Atenc">
<select data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" data-value-separator="<?php echo $detalle_atencion->Id_Estado_Atenc->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Atenc" name="x_Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->SelectOptionListHtml("x_Id_Estado_Atenc") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Atenc" id="s_x_Id_Estado_Atenc" value="<?php echo $detalle_atencion->Id_Estado_Atenc->LookupFilterQuery() ?>">
</span>
<?php echo $detalle_atencion->Id_Estado_Atenc->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($detalle_atencion->Id_Atencion->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Id_Atencion" id="x_Id_Atencion" value="<?php echo ew_HtmlEncode(strval($detalle_atencion->Id_Atencion->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detalle_atencion->NroSerie->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_NroSerie" id="x_NroSerie" value="<?php echo ew_HtmlEncode(strval($detalle_atencion->NroSerie->getSessionValue())) ?>">
<?php } ?>
<?php if (!$detalle_atencion_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $detalle_atencion_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdetalle_atencionadd.Init();
</script>
<?php
$detalle_atencion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detalle_atencion_add->Page_Terminate();
?>
