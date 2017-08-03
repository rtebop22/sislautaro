<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "prestamo_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$prestamo_equipo_add = NULL; // Initialize page object first

class cprestamo_equipo_add extends cprestamo_equipo {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'prestamo_equipo';

	// Page object name
	var $PageObjName = 'prestamo_equipo_add';

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

		// Table object (prestamo_equipo)
		if (!isset($GLOBALS["prestamo_equipo"]) || get_class($GLOBALS["prestamo_equipo"]) == "cprestamo_equipo") {
			$GLOBALS["prestamo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["prestamo_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'prestamo_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("prestamo_equipolist.php"));
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
		$this->Apellidos_Nombres_Beneficiario->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Id_Motivo_Prestamo->SetVisibility();
		$this->Fecha_Prestamo->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Prestamo_Cargador->SetVisibility();
		$this->Id_Estado_Prestamo->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $prestamo_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($prestamo_equipo);
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
	var $MultiPages; // Multi pages object

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
			if (@$_GET["Id_Prestamo"] != "") {
				$this->Id_Prestamo->setQueryStringValue($_GET["Id_Prestamo"]);
				$this->setKey("Id_Prestamo", $this->Id_Prestamo->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Prestamo", ""); // Clear key
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
					$this->Page_Terminate("prestamo_equipolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->GetViewUrl();
					if (ew_GetPageName($sReturnUrl) == "prestamo_equipolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "prestamo_equipoview.php")
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
		$this->Apellidos_Nombres_Beneficiario->CurrentValue = NULL;
		$this->Apellidos_Nombres_Beneficiario->OldValue = $this->Apellidos_Nombres_Beneficiario->CurrentValue;
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Id_Motivo_Prestamo->CurrentValue = 1;
		$this->Fecha_Prestamo->CurrentValue = ew_CurrentDate();
		$this->Observacion->CurrentValue = NULL;
		$this->Observacion->OldValue = $this->Observacion->CurrentValue;
		$this->Prestamo_Cargador->CurrentValue = 'NO';
		$this->Id_Estado_Prestamo->CurrentValue = 1;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Apellidos_Nombres_Beneficiario->FldIsDetailKey) {
			$this->Apellidos_Nombres_Beneficiario->setFormValue($objForm->GetValue("x_Apellidos_Nombres_Beneficiario"));
		}
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		if (!$this->Id_Motivo_Prestamo->FldIsDetailKey) {
			$this->Id_Motivo_Prestamo->setFormValue($objForm->GetValue("x_Id_Motivo_Prestamo"));
		}
		if (!$this->Fecha_Prestamo->FldIsDetailKey) {
			$this->Fecha_Prestamo->setFormValue($objForm->GetValue("x_Fecha_Prestamo"));
			$this->Fecha_Prestamo->CurrentValue = ew_UnFormatDateTime($this->Fecha_Prestamo->CurrentValue, 7);
		}
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		if (!$this->Prestamo_Cargador->FldIsDetailKey) {
			$this->Prestamo_Cargador->setFormValue($objForm->GetValue("x_Prestamo_Cargador"));
		}
		if (!$this->Id_Estado_Prestamo->FldIsDetailKey) {
			$this->Id_Estado_Prestamo->setFormValue($objForm->GetValue("x_Id_Estado_Prestamo"));
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Apellidos_Nombres_Beneficiario->CurrentValue = $this->Apellidos_Nombres_Beneficiario->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Id_Motivo_Prestamo->CurrentValue = $this->Id_Motivo_Prestamo->FormValue;
		$this->Fecha_Prestamo->CurrentValue = $this->Fecha_Prestamo->FormValue;
		$this->Fecha_Prestamo->CurrentValue = ew_UnFormatDateTime($this->Fecha_Prestamo->CurrentValue, 7);
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Prestamo_Cargador->CurrentValue = $this->Prestamo_Cargador->FormValue;
		$this->Id_Estado_Prestamo->CurrentValue = $this->Id_Estado_Prestamo->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
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
		$this->Id_Prestamo->setDbValue($rs->fields('Id_Prestamo'));
		$this->Apellidos_Nombres_Beneficiario->setDbValue($rs->fields('Apellidos_Nombres_Beneficiario'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Id_Motivo_Prestamo->setDbValue($rs->fields('Id_Motivo_Prestamo'));
		$this->Fecha_Prestamo->setDbValue($rs->fields('Fecha_Prestamo'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Prestamo_Cargador->setDbValue($rs->fields('Prestamo_Cargador'));
		$this->Id_Estado_Prestamo->setDbValue($rs->fields('Id_Estado_Prestamo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Id_Estado_Devol->setDbValue($rs->fields('Id_Estado_Devol'));
		$this->Devuelve_Cargador->setDbValue($rs->fields('Devuelve_Cargador'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Prestamo->DbValue = $row['Id_Prestamo'];
		$this->Apellidos_Nombres_Beneficiario->DbValue = $row['Apellidos_Nombres_Beneficiario'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Id_Motivo_Prestamo->DbValue = $row['Id_Motivo_Prestamo'];
		$this->Fecha_Prestamo->DbValue = $row['Fecha_Prestamo'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Prestamo_Cargador->DbValue = $row['Prestamo_Cargador'];
		$this->Id_Estado_Prestamo->DbValue = $row['Id_Estado_Prestamo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Id_Estado_Devol->DbValue = $row['Id_Estado_Devol'];
		$this->Devuelve_Cargador->DbValue = $row['Devuelve_Cargador'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Prestamo")) <> "")
			$this->Id_Prestamo->CurrentValue = $this->getKey("Id_Prestamo"); // Id_Prestamo
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
		// Id_Prestamo
		// Apellidos_Nombres_Beneficiario
		// Dni
		// NroSerie
		// Id_Motivo_Prestamo
		// Fecha_Prestamo
		// Observacion
		// Prestamo_Cargador
		// Id_Estado_Prestamo
		// Usuario
		// Fecha_Actualizacion
		// Id_Estado_Devol
		// Devuelve_Cargador

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Prestamo
		$this->Id_Prestamo->ViewValue = $this->Id_Prestamo->CurrentValue;
		$this->Id_Prestamo->ViewCustomAttributes = "";

		// Apellidos_Nombres_Beneficiario
		if (strval($this->Apellidos_Nombres_Beneficiario->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
		$sWhereWrk = "";
		$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`Id_Estado_Espera`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->CurrentValue;
			}
		} else {
			$this->Apellidos_Nombres_Beneficiario->ViewValue = NULL;
		}
		$this->Apellidos_Nombres_Beneficiario->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		$lookuptblfilter = "`Id_Sit_Estado`='3'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// Id_Motivo_Prestamo
		if (strval($this->Id_Motivo_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Motivo_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Prestamo->ViewValue = NULL;
		}
		$this->Id_Motivo_Prestamo->ViewCustomAttributes = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->ViewValue = $this->Fecha_Prestamo->CurrentValue;
		$this->Fecha_Prestamo->ViewValue = ew_FormatDateTime($this->Fecha_Prestamo->ViewValue, 7);
		$this->Fecha_Prestamo->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Prestamo_Cargador
		if (strval($this->Prestamo_Cargador->CurrentValue) <> "") {
			$this->Prestamo_Cargador->ViewValue = $this->Prestamo_Cargador->OptionCaption($this->Prestamo_Cargador->CurrentValue);
		} else {
			$this->Prestamo_Cargador->ViewValue = NULL;
		}
		$this->Prestamo_Cargador->ViewCustomAttributes = "";

		// Id_Estado_Prestamo
		if (strval($this->Id_Estado_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Estado_Prestamo->ViewValue = NULL;
		}
		$this->Id_Estado_Prestamo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Estado_Devol
		if (strval($this->Id_Estado_Devol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_devolucion_prestamo`";
		$sWhereWrk = "";
		$this->Id_Estado_Devol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->CurrentValue;
			}
		} else {
			$this->Id_Estado_Devol->ViewValue = NULL;
		}
		$this->Id_Estado_Devol->ViewCustomAttributes = "";

		// Devuelve_Cargador
		if (strval($this->Devuelve_Cargador->CurrentValue) <> "") {
			$this->Devuelve_Cargador->ViewValue = $this->Devuelve_Cargador->OptionCaption($this->Devuelve_Cargador->CurrentValue);
		} else {
			$this->Devuelve_Cargador->ViewValue = NULL;
		}
		$this->Devuelve_Cargador->ViewCustomAttributes = "";

			// Apellidos_Nombres_Beneficiario
			$this->Apellidos_Nombres_Beneficiario->LinkCustomAttributes = "";
			$this->Apellidos_Nombres_Beneficiario->HrefValue = "";
			$this->Apellidos_Nombres_Beneficiario->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";
			$this->Id_Motivo_Prestamo->TooltipValue = "";

			// Fecha_Prestamo
			$this->Fecha_Prestamo->LinkCustomAttributes = "";
			$this->Fecha_Prestamo->HrefValue = "";
			$this->Fecha_Prestamo->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Prestamo_Cargador
			$this->Prestamo_Cargador->LinkCustomAttributes = "";
			$this->Prestamo_Cargador->HrefValue = "";
			$this->Prestamo_Cargador->TooltipValue = "";

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->LinkCustomAttributes = "";
			$this->Id_Estado_Prestamo->HrefValue = "";
			$this->Id_Estado_Prestamo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Apellidos_Nombres_Beneficiario
			$this->Apellidos_Nombres_Beneficiario->EditCustomAttributes = "";
			if (trim(strval($this->Apellidos_Nombres_Beneficiario->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lista_espera_prestamo`";
			$sWhereWrk = "";
			$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado_Espera`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
			} else {
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Apellidos_Nombres_Beneficiario->EditValue = $arwrk;

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditCustomAttributes = "";
			if (trim(strval($this->NroSerie->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$lookuptblfilter = "`Id_Sit_Estado`='3'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
			} else {
				$this->NroSerie->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->NroSerie->EditValue = $arwrk;

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Prestamo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo_Prestamo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo_Prestamo->EditValue = $arwrk;

			// Fecha_Prestamo
			$this->Fecha_Prestamo->EditAttrs["class"] = "form-control";
			$this->Fecha_Prestamo->EditCustomAttributes = "";
			$this->Fecha_Prestamo->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Prestamo->CurrentValue, 7));
			$this->Fecha_Prestamo->PlaceHolder = ew_RemoveHtml($this->Fecha_Prestamo->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Prestamo_Cargador
			$this->Prestamo_Cargador->EditCustomAttributes = "";
			$this->Prestamo_Cargador->EditValue = $this->Prestamo_Cargador->Options(FALSE);

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Prestamo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Prestamo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado_Prestamo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Prestamo->EditValue = $arwrk;

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Apellidos_Nombres_Beneficiario

			$this->Apellidos_Nombres_Beneficiario->LinkCustomAttributes = "";
			$this->Apellidos_Nombres_Beneficiario->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";

			// Fecha_Prestamo
			$this->Fecha_Prestamo->LinkCustomAttributes = "";
			$this->Fecha_Prestamo->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Prestamo_Cargador
			$this->Prestamo_Cargador->LinkCustomAttributes = "";
			$this->Prestamo_Cargador->HrefValue = "";

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->LinkCustomAttributes = "";
			$this->Id_Estado_Prestamo->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

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
		if (!$this->Apellidos_Nombres_Beneficiario->FldIsDetailKey && !is_null($this->Apellidos_Nombres_Beneficiario->FormValue) && $this->Apellidos_Nombres_Beneficiario->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellidos_Nombres_Beneficiario->FldCaption(), $this->Apellidos_Nombres_Beneficiario->ReqErrMsg));
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
		if (!$this->Id_Motivo_Prestamo->FldIsDetailKey && !is_null($this->Id_Motivo_Prestamo->FormValue) && $this->Id_Motivo_Prestamo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo_Prestamo->FldCaption(), $this->Id_Motivo_Prestamo->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Prestamo->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Prestamo->FldErrMsg());
		}
		if (!$this->Id_Estado_Prestamo->FldIsDetailKey && !is_null($this->Id_Estado_Prestamo->FormValue) && $this->Id_Estado_Prestamo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Prestamo->FldCaption(), $this->Id_Estado_Prestamo->ReqErrMsg));
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

		// Apellidos_Nombres_Beneficiario
		$this->Apellidos_Nombres_Beneficiario->SetDbValueDef($rsnew, $this->Apellidos_Nombres_Beneficiario->CurrentValue, NULL, FALSE);

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Id_Motivo_Prestamo
		$this->Id_Motivo_Prestamo->SetDbValueDef($rsnew, $this->Id_Motivo_Prestamo->CurrentValue, 0, FALSE);

		// Fecha_Prestamo
		$this->Fecha_Prestamo->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Prestamo->CurrentValue, 7), NULL, FALSE);

		// Observacion
		$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, FALSE);

		// Prestamo_Cargador
		$this->Prestamo_Cargador->SetDbValueDef($rsnew, $this->Prestamo_Cargador->CurrentValue, NULL, FALSE);

		// Id_Estado_Prestamo
		$this->Id_Estado_Prestamo->SetDbValueDef($rsnew, $this->Id_Estado_Prestamo->CurrentValue, 0, FALSE);

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Id_Prestamo->setDbValue($conn->Insert_ID());
				$rsnew['Id_Prestamo'] = $this->Id_Prestamo->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("prestamo_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$this->MultiPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Apellidos_Nombres_Beneficiario":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
			$sWhereWrk = "{filter}";
			$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado_Espera`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$lookuptblfilter = "`Id_Sit_Estado`='3'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo_Prestamo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo_Prestamo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Prestamo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Prestamo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado_Prestamo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Prestamo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
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
		$table = 'prestamo_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'prestamo_equipo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Prestamo'];

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
if (!isset($prestamo_equipo_add)) $prestamo_equipo_add = new cprestamo_equipo_add();

// Page init
$prestamo_equipo_add->Page_Init();

// Page main
$prestamo_equipo_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$prestamo_equipo_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fprestamo_equipoadd = new ew_Form("fprestamo_equipoadd", "add");

// Validate form
fprestamo_equipoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellidos_Nombres_Beneficiario");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption(), $prestamo_equipo->Apellidos_Nombres_Beneficiario->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $prestamo_equipo->Dni->FldCaption(), $prestamo_equipo->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($prestamo_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $prestamo_equipo->NroSerie->FldCaption(), $prestamo_equipo->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo_Prestamo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $prestamo_equipo->Id_Motivo_Prestamo->FldCaption(), $prestamo_equipo->Id_Motivo_Prestamo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Prestamo");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($prestamo_equipo->Fecha_Prestamo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Prestamo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $prestamo_equipo->Id_Estado_Prestamo->FldCaption(), $prestamo_equipo->Id_Estado_Prestamo->ReqErrMsg)) ?>");

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
fprestamo_equipoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprestamo_equipoadd.ValidateRequired = true;
<?php } else { ?>
fprestamo_equipoadd.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fprestamo_equipoadd.MultiPage = new ew_MultiPage("fprestamo_equipoadd");

// Dynamic selection lists
fprestamo_equipoadd.Lists["x_Apellidos_Nombres_Beneficiario"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"lista_espera_prestamo"};
fprestamo_equipoadd.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fprestamo_equipoadd.Lists["x_Id_Motivo_Prestamo"] = {"LinkField":"x_Id_Motivo_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_prestamo_equipo"};
fprestamo_equipoadd.Lists["x_Prestamo_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprestamo_equipoadd.Lists["x_Prestamo_Cargador"].Options = <?php echo json_encode($prestamo_equipo->Prestamo_Cargador->Options()) ?>;
fprestamo_equipoadd.Lists["x_Id_Estado_Prestamo"] = {"LinkField":"x_Id_Estado_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_prestamo_equipo"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$prestamo_equipo_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $prestamo_equipo_add->ShowPageHeader(); ?>
<?php
$prestamo_equipo_add->ShowMessage();
?>
<form name="fprestamo_equipoadd" id="fprestamo_equipoadd" class="<?php echo $prestamo_equipo_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($prestamo_equipo_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $prestamo_equipo_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="prestamo_equipo">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($prestamo_equipo_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ewMultiPage">
<div class="panel-group" id="prestamo_equipo_add">
	<div class="panel panel-default<?php echo $prestamo_equipo_add->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#prestamo_equipo_add" href="#tab_prestamo_equipo1"><?php echo $prestamo_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $prestamo_equipo_add->MultiPages->PageStyle("1") ?>" id="tab_prestamo_equipo1">
			<div class="panel-body">
<div>
<?php if ($prestamo_equipo->Apellidos_Nombres_Beneficiario->Visible) { // Apellidos_Nombres_Beneficiario ?>
	<div id="r_Apellidos_Nombres_Beneficiario" class="form-group">
		<label id="elh_prestamo_equipo_Apellidos_Nombres_Beneficiario" for="x_Apellidos_Nombres_Beneficiario" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CellAttributes() ?>>
<span id="el_prestamo_equipo_Apellidos_Nombres_Beneficiario">
<?php $prestamo_equipo->Apellidos_Nombres_Beneficiario->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$prestamo_equipo->Apellidos_Nombres_Beneficiario->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Apellidos_Nombres_Beneficiario"><?php echo (strval($prestamo_equipo->Apellidos_Nombres_Beneficiario->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $prestamo_equipo->Apellidos_Nombres_Beneficiario->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Apellidos_Nombres_Beneficiario',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="prestamo_equipo" data-field="x_Apellidos_Nombres_Beneficiario" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->DisplayValueSeparatorAttribute() ?>" name="x_Apellidos_Nombres_Beneficiario" id="x_Apellidos_Nombres_Beneficiario" value="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CurrentValue ?>"<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "lista_espera_prestamo")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Apellidos_Nombres_Beneficiario',url:'lista_espera_prestamoaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Apellidos_Nombres_Beneficiario"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_Apellidos_Nombres_Beneficiario" id="s_x_Apellidos_Nombres_Beneficiario" value="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Apellidos_Nombres_Beneficiario" id="ln_x_Apellidos_Nombres_Beneficiario" value="x_Dni,x_Id_Motivo_Prestamo,x_Observacion">
</span>
<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label id="elh_prestamo_equipo_Dni" for="x_Dni" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Dni->CellAttributes() ?>>
<span id="el_prestamo_equipo_Dni">
<input type="text" data-table="prestamo_equipo" data-field="x_Dni" data-page="1" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Dni->EditValue ?>"<?php echo $prestamo_equipo->Dni->EditAttributes() ?>>
</span>
<?php echo $prestamo_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_prestamo_equipo_NroSerie" for="x_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->NroSerie->CellAttributes() ?>>
<span id="el_prestamo_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($prestamo_equipo->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $prestamo_equipo->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($prestamo_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="prestamo_equipo" data-field="x_NroSerie" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $prestamo_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $prestamo_equipo->NroSerie->CurrentValue ?>"<?php echo $prestamo_equipo->NroSerie->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $prestamo_equipo->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $prestamo_equipo->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $prestamo_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
<?php echo $prestamo_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $prestamo_equipo_add->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#prestamo_equipo_add" href="#tab_prestamo_equipo2"><?php echo $prestamo_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $prestamo_equipo_add->MultiPages->PageStyle("2") ?>" id="tab_prestamo_equipo2">
			<div class="panel-body">
<div>
<?php if ($prestamo_equipo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
	<div id="r_Id_Motivo_Prestamo" class="form-group">
		<label id="elh_prestamo_equipo_Id_Motivo_Prestamo" for="x_Id_Motivo_Prestamo" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Id_Motivo_Prestamo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Id_Motivo_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Motivo_Prestamo">
<select data-table="prestamo_equipo" data-field="x_Id_Motivo_Prestamo" data-page="2" data-value-separator="<?php echo $prestamo_equipo->Id_Motivo_Prestamo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo_Prestamo" name="x_Id_Motivo_Prestamo"<?php echo $prestamo_equipo->Id_Motivo_Prestamo->EditAttributes() ?>>
<?php echo $prestamo_equipo->Id_Motivo_Prestamo->SelectOptionListHtml("x_Id_Motivo_Prestamo") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo_Prestamo" id="s_x_Id_Motivo_Prestamo" value="<?php echo $prestamo_equipo->Id_Motivo_Prestamo->LookupFilterQuery() ?>">
</span>
<?php echo $prestamo_equipo->Id_Motivo_Prestamo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Fecha_Prestamo->Visible) { // Fecha_Prestamo ?>
	<div id="r_Fecha_Prestamo" class="form-group">
		<label id="elh_prestamo_equipo_Fecha_Prestamo" for="x_Fecha_Prestamo" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Fecha_Prestamo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Fecha_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Fecha_Prestamo">
<input type="text" data-table="prestamo_equipo" data-field="x_Fecha_Prestamo" data-page="2" data-format="7" name="x_Fecha_Prestamo" id="x_Fecha_Prestamo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Fecha_Prestamo->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Fecha_Prestamo->EditValue ?>"<?php echo $prestamo_equipo->Fecha_Prestamo->EditAttributes() ?>>
<?php if (!$prestamo_equipo->Fecha_Prestamo->ReadOnly && !$prestamo_equipo->Fecha_Prestamo->Disabled && !isset($prestamo_equipo->Fecha_Prestamo->EditAttrs["readonly"]) && !isset($prestamo_equipo->Fecha_Prestamo->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fprestamo_equipoadd", "x_Fecha_Prestamo", 7);
</script>
<?php } ?>
</span>
<?php echo $prestamo_equipo->Fecha_Prestamo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label id="elh_prestamo_equipo_Observacion" for="x_Observacion" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Observacion->CellAttributes() ?>>
<span id="el_prestamo_equipo_Observacion">
<textarea data-table="prestamo_equipo" data-field="x_Observacion" data-page="2" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Observacion->getPlaceHolder()) ?>"<?php echo $prestamo_equipo->Observacion->EditAttributes() ?>><?php echo $prestamo_equipo->Observacion->EditValue ?></textarea>
</span>
<?php echo $prestamo_equipo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Prestamo_Cargador->Visible) { // Prestamo_Cargador ?>
	<div id="r_Prestamo_Cargador" class="form-group">
		<label id="elh_prestamo_equipo_Prestamo_Cargador" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Prestamo_Cargador->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Prestamo_Cargador->CellAttributes() ?>>
<span id="el_prestamo_equipo_Prestamo_Cargador">
<div id="tp_x_Prestamo_Cargador" class="ewTemplate"><input type="radio" data-table="prestamo_equipo" data-field="x_Prestamo_Cargador" data-page="2" data-value-separator="<?php echo $prestamo_equipo->Prestamo_Cargador->DisplayValueSeparatorAttribute() ?>" name="x_Prestamo_Cargador" id="x_Prestamo_Cargador" value="{value}"<?php echo $prestamo_equipo->Prestamo_Cargador->EditAttributes() ?>></div>
<div id="dsl_x_Prestamo_Cargador" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $prestamo_equipo->Prestamo_Cargador->RadioButtonListHtml(FALSE, "x_Prestamo_Cargador", 2) ?>
</div></div>
</span>
<?php echo $prestamo_equipo->Prestamo_Cargador->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Prestamo->Visible) { // Id_Estado_Prestamo ?>
	<div id="r_Id_Estado_Prestamo" class="form-group">
		<label id="elh_prestamo_equipo_Id_Estado_Prestamo" for="x_Id_Estado_Prestamo" class="col-sm-2 control-label ewLabel"><?php echo $prestamo_equipo->Id_Estado_Prestamo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $prestamo_equipo->Id_Estado_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Estado_Prestamo">
<select data-table="prestamo_equipo" data-field="x_Id_Estado_Prestamo" data-page="2" data-value-separator="<?php echo $prestamo_equipo->Id_Estado_Prestamo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Prestamo" name="x_Id_Estado_Prestamo"<?php echo $prestamo_equipo->Id_Estado_Prestamo->EditAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Prestamo->SelectOptionListHtml("x_Id_Estado_Prestamo") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Prestamo" id="s_x_Id_Estado_Prestamo" value="<?php echo $prestamo_equipo->Id_Estado_Prestamo->LookupFilterQuery() ?>">
</span>
<?php echo $prestamo_equipo->Id_Estado_Prestamo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if (!$prestamo_equipo_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $prestamo_equipo_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fprestamo_equipoadd.Init();
</script>
<?php
$prestamo_equipo_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$prestamo_equipo_add->Page_Terminate();
?>
