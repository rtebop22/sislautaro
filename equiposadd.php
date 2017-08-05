<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "equiposinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "observacion_equipogridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$equipos_add = NULL; // Initialize page object first

class cequipos_add extends cequipos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'equipos';

	// Page object name
	var $PageObjName = 'equipos_add';

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

		// Table object (equipos)
		if (!isset($GLOBALS["equipos"]) || get_class($GLOBALS["equipos"]) == "cequipos") {
			$GLOBALS["equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["equipos"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'equipos', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("equiposlist.php"));
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
		$this->NroSerie->SetVisibility();
		$this->NroMac->SetVisibility();
		$this->SpecialNumber->SetVisibility();
		$this->Id_Ubicacion->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Sit_Estado->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_Ano->SetVisibility();
		$this->Tiene_Cargador->SetVisibility();
		$this->Id_Tipo_Equipo->SetVisibility();
		$this->Usuario->SetVisibility();
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

			// Process auto fill for detail table 'observacion_equipo'
			if (@$_POST["grid"] == "fobservacion_equipogrid") {
				if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;
				$GLOBALS["observacion_equipo_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $equipos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($equipos);
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
			if (@$_GET["NroSerie"] != "") {
				$this->NroSerie->setQueryStringValue($_GET["NroSerie"]);
				$this->setKey("NroSerie", $this->NroSerie->CurrentValue); // Set up key
			} else {
				$this->setKey("NroSerie", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("equiposlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "equiposlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "equiposview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->NroMac->CurrentValue = NULL;
		$this->NroMac->OldValue = $this->NroMac->CurrentValue;
		$this->SpecialNumber->CurrentValue = NULL;
		$this->SpecialNumber->OldValue = $this->SpecialNumber->CurrentValue;
		$this->Id_Ubicacion->CurrentValue = 1;
		$this->Id_Estado->CurrentValue = 1;
		$this->Id_Sit_Estado->CurrentValue = 1;
		$this->Id_Marca->CurrentValue = NULL;
		$this->Id_Marca->OldValue = $this->Id_Marca->CurrentValue;
		$this->Id_Modelo->CurrentValue = NULL;
		$this->Id_Modelo->OldValue = $this->Id_Modelo->CurrentValue;
		$this->Id_Ano->CurrentValue = NULL;
		$this->Id_Ano->OldValue = $this->Id_Ano->CurrentValue;
		$this->Tiene_Cargador->CurrentValue = 'SI';
		$this->Id_Tipo_Equipo->CurrentValue = 1;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		if (!$this->NroMac->FldIsDetailKey) {
			$this->NroMac->setFormValue($objForm->GetValue("x_NroMac"));
		}
		if (!$this->SpecialNumber->FldIsDetailKey) {
			$this->SpecialNumber->setFormValue($objForm->GetValue("x_SpecialNumber"));
		}
		if (!$this->Id_Ubicacion->FldIsDetailKey) {
			$this->Id_Ubicacion->setFormValue($objForm->GetValue("x_Id_Ubicacion"));
		}
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		if (!$this->Id_Sit_Estado->FldIsDetailKey) {
			$this->Id_Sit_Estado->setFormValue($objForm->GetValue("x_Id_Sit_Estado"));
		}
		if (!$this->Id_Marca->FldIsDetailKey) {
			$this->Id_Marca->setFormValue($objForm->GetValue("x_Id_Marca"));
		}
		if (!$this->Id_Modelo->FldIsDetailKey) {
			$this->Id_Modelo->setFormValue($objForm->GetValue("x_Id_Modelo"));
		}
		if (!$this->Id_Ano->FldIsDetailKey) {
			$this->Id_Ano->setFormValue($objForm->GetValue("x_Id_Ano"));
		}
		if (!$this->Tiene_Cargador->FldIsDetailKey) {
			$this->Tiene_Cargador->setFormValue($objForm->GetValue("x_Tiene_Cargador"));
		}
		if (!$this->Id_Tipo_Equipo->FldIsDetailKey) {
			$this->Id_Tipo_Equipo->setFormValue($objForm->GetValue("x_Id_Tipo_Equipo"));
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
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->NroMac->CurrentValue = $this->NroMac->FormValue;
		$this->SpecialNumber->CurrentValue = $this->SpecialNumber->FormValue;
		$this->Id_Ubicacion->CurrentValue = $this->Id_Ubicacion->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Id_Sit_Estado->CurrentValue = $this->Id_Sit_Estado->FormValue;
		$this->Id_Marca->CurrentValue = $this->Id_Marca->FormValue;
		$this->Id_Modelo->CurrentValue = $this->Id_Modelo->FormValue;
		$this->Id_Ano->CurrentValue = $this->Id_Ano->FormValue;
		$this->Tiene_Cargador->CurrentValue = $this->Tiene_Cargador->FormValue;
		$this->Id_Tipo_Equipo->CurrentValue = $this->Id_Tipo_Equipo->FormValue;
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
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->NroMac->setDbValue($rs->fields('NroMac'));
		$this->SpecialNumber->setDbValue($rs->fields('SpecialNumber'));
		$this->Id_Ubicacion->setDbValue($rs->fields('Id_Ubicacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Sit_Estado->setDbValue($rs->fields('Id_Sit_Estado'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_Ano->setDbValue($rs->fields('Id_Ano'));
		$this->Tiene_Cargador->setDbValue($rs->fields('Tiene_Cargador'));
		$this->Id_Tipo_Equipo->setDbValue($rs->fields('Id_Tipo_Equipo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->NroMac->DbValue = $row['NroMac'];
		$this->SpecialNumber->DbValue = $row['SpecialNumber'];
		$this->Id_Ubicacion->DbValue = $row['Id_Ubicacion'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Sit_Estado->DbValue = $row['Id_Sit_Estado'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_Ano->DbValue = $row['Id_Ano'];
		$this->Tiene_Cargador->DbValue = $row['Tiene_Cargador'];
		$this->Id_Tipo_Equipo->DbValue = $row['Id_Tipo_Equipo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("NroSerie")) <> "")
			$this->NroSerie->CurrentValue = $this->getKey("NroSerie"); // NroSerie
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
		// NroSerie
		// NroMac
		// SpecialNumber
		// Id_Ubicacion
		// Id_Estado
		// Id_Sit_Estado
		// Id_Marca
		// Id_Modelo
		// Id_Ano
		// Tiene_Cargador
		// Id_Tipo_Equipo
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->ViewValue = $this->NroMac->CurrentValue;
		$this->NroMac->ViewCustomAttributes = "";

		// SpecialNumber
		$this->SpecialNumber->ViewValue = $this->SpecialNumber->CurrentValue;
		$this->SpecialNumber->ViewCustomAttributes = "";

		// Id_Ubicacion
		if (strval($this->Id_Ubicacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
		$sWhereWrk = "";
		$this->Id_Ubicacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->CurrentValue;
			}
		} else {
			$this->Id_Ubicacion->ViewValue = NULL;
		}
		$this->Id_Ubicacion->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Id_Sit_Estado
		if (strval($this->Id_Sit_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
		$sWhereWrk = "";
		$this->Id_Sit_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->CurrentValue;
			}
		} else {
			$this->Id_Sit_Estado->ViewValue = NULL;
		}
		$this->Id_Sit_Estado->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
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

		// Id_Ano
		if (strval($this->Id_Ano->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
		$sWhereWrk = "";
		$this->Id_Ano->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ano->ViewValue = $this->Id_Ano->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ano->ViewValue = $this->Id_Ano->CurrentValue;
			}
		} else {
			$this->Id_Ano->ViewValue = NULL;
		}
		$this->Id_Ano->ViewCustomAttributes = "";

		// Tiene_Cargador
		if (strval($this->Tiene_Cargador->CurrentValue) <> "") {
			$this->Tiene_Cargador->ViewValue = $this->Tiene_Cargador->OptionCaption($this->Tiene_Cargador->CurrentValue);
		} else {
			$this->Tiene_Cargador->ViewValue = NULL;
		}
		$this->Tiene_Cargador->ViewCustomAttributes = "";

		// Id_Tipo_Equipo
		if (strval($this->Id_Tipo_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
		$sWhereWrk = "";
		$this->Id_Tipo_Equipo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Equipo->ViewValue = NULL;
		}
		$this->Id_Tipo_Equipo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewValue = ew_FormatDateTime($this->Usuario->ViewValue, 7);
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";
			$this->NroMac->TooltipValue = "";

			// SpecialNumber
			$this->SpecialNumber->LinkCustomAttributes = "";
			$this->SpecialNumber->HrefValue = "";
			$this->SpecialNumber->TooltipValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";
			$this->Id_Ubicacion->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";
			$this->Id_Sit_Estado->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";
			$this->Id_Ano->TooltipValue = "";

			// Tiene_Cargador
			$this->Tiene_Cargador->LinkCustomAttributes = "";
			$this->Tiene_Cargador->HrefValue = "";
			$this->Tiene_Cargador->TooltipValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";
			$this->Id_Tipo_Equipo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			if ($this->NroSerie->getSessionValue() <> "") {
				$this->NroSerie->CurrentValue = $this->NroSerie->getSessionValue();
			$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewCustomAttributes = "";
			} else {
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());
			}

			// NroMac
			$this->NroMac->EditAttrs["class"] = "form-control";
			$this->NroMac->EditCustomAttributes = "";
			$this->NroMac->EditValue = ew_HtmlEncode($this->NroMac->CurrentValue);
			$this->NroMac->PlaceHolder = ew_RemoveHtml($this->NroMac->FldCaption());

			// SpecialNumber
			$this->SpecialNumber->EditAttrs["class"] = "form-control";
			$this->SpecialNumber->EditCustomAttributes = "";
			$this->SpecialNumber->EditValue = ew_HtmlEncode($this->SpecialNumber->CurrentValue);
			$this->SpecialNumber->PlaceHolder = ew_RemoveHtml($this->SpecialNumber->FldCaption());

			// Id_Ubicacion
			$this->Id_Ubicacion->EditAttrs["class"] = "form-control";
			$this->Id_Ubicacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ubicacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ubicacion->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Sit_Estado
			$this->Id_Sit_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Sit_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sit_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sit_Estado->EditValue = $arwrk;

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Marca` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_Ano
			$this->Id_Ano->EditAttrs["class"] = "form-control";
			$this->Id_Ano->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ano->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ano->EditValue = $arwrk;

			// Tiene_Cargador
			$this->Tiene_Cargador->EditCustomAttributes = "";
			$this->Tiene_Cargador->EditValue = $this->Tiene_Cargador->Options(FALSE);

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Equipo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Equipo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_equipo`";
			$sWhereWrk = "";
			$this->Id_Tipo_Equipo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Equipo->EditValue = $arwrk;

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// NroSerie

			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";

			// SpecialNumber
			$this->SpecialNumber->LinkCustomAttributes = "";
			$this->SpecialNumber->HrefValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";

			// Tiene_Cargador
			$this->Tiene_Cargador->LinkCustomAttributes = "";
			$this->Tiene_Cargador->HrefValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";

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
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Id_Ubicacion->FldIsDetailKey && !is_null($this->Id_Ubicacion->FormValue) && $this->Id_Ubicacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ubicacion->FldCaption(), $this->Id_Ubicacion->ReqErrMsg));
		}
		if (!$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
		}
		if (!$this->Id_Sit_Estado->FldIsDetailKey && !is_null($this->Id_Sit_Estado->FormValue) && $this->Id_Sit_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Sit_Estado->FldCaption(), $this->Id_Sit_Estado->ReqErrMsg));
		}
		if (!$this->Id_Marca->FldIsDetailKey && !is_null($this->Id_Marca->FormValue) && $this->Id_Marca->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Marca->FldCaption(), $this->Id_Marca->ReqErrMsg));
		}
		if (!$this->Id_Modelo->FldIsDetailKey && !is_null($this->Id_Modelo->FormValue) && $this->Id_Modelo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Modelo->FldCaption(), $this->Id_Modelo->ReqErrMsg));
		}
		if (!$this->Id_Ano->FldIsDetailKey && !is_null($this->Id_Ano->FormValue) && $this->Id_Ano->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ano->FldCaption(), $this->Id_Ano->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("observacion_equipo", $DetailTblVar) && $GLOBALS["observacion_equipo"]->DetailAdd) {
			if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid(); // get detail page object
			$GLOBALS["observacion_equipo_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// NroMac
		$this->NroMac->SetDbValueDef($rsnew, $this->NroMac->CurrentValue, NULL, FALSE);

		// SpecialNumber
		$this->SpecialNumber->SetDbValueDef($rsnew, $this->SpecialNumber->CurrentValue, NULL, FALSE);

		// Id_Ubicacion
		$this->Id_Ubicacion->SetDbValueDef($rsnew, $this->Id_Ubicacion->CurrentValue, 0, strval($this->Id_Ubicacion->CurrentValue) == "");

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, strval($this->Id_Estado->CurrentValue) == "");

		// Id_Sit_Estado
		$this->Id_Sit_Estado->SetDbValueDef($rsnew, $this->Id_Sit_Estado->CurrentValue, 0, strval($this->Id_Sit_Estado->CurrentValue) == "");

		// Id_Marca
		$this->Id_Marca->SetDbValueDef($rsnew, $this->Id_Marca->CurrentValue, 0, strval($this->Id_Marca->CurrentValue) == "");

		// Id_Modelo
		$this->Id_Modelo->SetDbValueDef($rsnew, $this->Id_Modelo->CurrentValue, 0, strval($this->Id_Modelo->CurrentValue) == "");

		// Id_Ano
		$this->Id_Ano->SetDbValueDef($rsnew, $this->Id_Ano->CurrentValue, 0, FALSE);

		// Tiene_Cargador
		$this->Tiene_Cargador->SetDbValueDef($rsnew, $this->Tiene_Cargador->CurrentValue, NULL, FALSE);

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->SetDbValueDef($rsnew, $this->Id_Tipo_Equipo->CurrentValue, NULL, strval($this->Id_Tipo_Equipo->CurrentValue) == "");

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['NroSerie']) == "") {
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("observacion_equipo", $DetailTblVar) && $GLOBALS["observacion_equipo"]->DetailAdd) {
				$GLOBALS["observacion_equipo"]->NroSerie->setSessionValue($this->NroSerie->CurrentValue); // Set master key
				if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "observacion_equipo"); // Load user level of detail table
				$AddRow = $GLOBALS["observacion_equipo_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["observacion_equipo"]->NroSerie->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setQueryStringValue($_GET["fk_NroSerie"]);
					$this->NroSerie->setQueryStringValue($GLOBALS["personas"]->NroSerie->QueryStringValue);
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
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setFormValue($_POST["fk_NroSerie"]);
					$this->NroSerie->setFormValue($GLOBALS["personas"]->NroSerie->FormValue);
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
			if ($sMasterTblVar <> "personas") {
				if ($this->NroSerie->CurrentValue == "") $this->NroSerie->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("observacion_equipo", $DetailTblVar)) {
				if (!isset($GLOBALS["observacion_equipo_grid"]))
					$GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;
				if ($GLOBALS["observacion_equipo_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["observacion_equipo_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["observacion_equipo_grid"]->CurrentMode = "add";
					$GLOBALS["observacion_equipo_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["observacion_equipo_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["observacion_equipo_grid"]->setStartRecordNumber(1);
					$GLOBALS["observacion_equipo_grid"]->NroSerie->FldIsDetailKey = TRUE;
					$GLOBALS["observacion_equipo_grid"]->NroSerie->CurrentValue = $this->NroSerie->CurrentValue;
					$GLOBALS["observacion_equipo_grid"]->NroSerie->setSessionValue($GLOBALS["observacion_equipo_grid"]->NroSerie->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("equiposlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Ubicacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ubicacion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ubicacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Sit_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Sit_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Sit_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Marca":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Marca` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Marca` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modelo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modelo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
			$sWhereWrk = "{filter}";
			$this->Id_Modelo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modelo` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Marca` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Ano":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ano` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ano` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Equipo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Equipo` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
			$sWhereWrk = "";
			$this->Id_Tipo_Equipo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Equipo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
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
		$table = 'equipos';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

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
if (!isset($equipos_add)) $equipos_add = new cequipos_add();

// Page init
$equipos_add->Page_Init();

// Page main
$equipos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equipos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fequiposadd = new ew_Form("fequiposadd", "add");

// Validate form
fequiposadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->NroSerie->FldCaption(), $equipos->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ubicacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ubicacion->FldCaption(), $equipos->Id_Ubicacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Estado->FldCaption(), $equipos->Id_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Sit_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Sit_Estado->FldCaption(), $equipos->Id_Sit_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Marca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Marca->FldCaption(), $equipos->Id_Marca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Modelo->FldCaption(), $equipos->Id_Modelo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ano");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ano->FldCaption(), $equipos->Id_Ano->ReqErrMsg)) ?>");

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
fequiposadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fequiposadd.ValidateRequired = true;
<?php } else { ?>
fequiposadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fequiposadd.Lists["x_Id_Ubicacion"] = {"LinkField":"x_Id_Ubicacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ubicacion_equipo"};
fequiposadd.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo"};
fequiposadd.Lists["x_Id_Sit_Estado"] = {"LinkField":"x_Id_Sit_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};
fequiposadd.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Modelo"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca"};
fequiposadd.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":["x_Id_Marca"],"ChildFields":[],"FilterFields":["x_Id_Marca"],"Options":[],"Template":"","LinkTable":"modelo"};
fequiposadd.Lists["x_Id_Ano"] = {"LinkField":"x_Id_Ano","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ano_entrega"};
fequiposadd.Lists["x_Tiene_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fequiposadd.Lists["x_Tiene_Cargador"].Options = <?php echo json_encode($equipos->Tiene_Cargador->Options()) ?>;
fequiposadd.Lists["x_Id_Tipo_Equipo"] = {"LinkField":"x_Id_Tipo_Equipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_equipo"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$equipos_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $equipos_add->ShowPageHeader(); ?>
<?php
$equipos_add->ShowMessage();
?>
<form name="fequiposadd" id="fequiposadd" class="<?php echo $equipos_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($equipos_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $equipos_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="equipos">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($equipos_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($equipos->getCurrentMasterTable() == "personas") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_NroSerie" value="<?php echo $equipos->NroSerie->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_equipos_NroSerie" for="x_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $equipos->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->NroSerie->CellAttributes() ?>>
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el_equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_NroSerie" name="x_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el_equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $equipos->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
	<div id="r_NroMac" class="form-group">
		<label id="elh_equipos_NroMac" for="x_NroMac" class="col-sm-2 control-label ewLabel"><?php echo $equipos->NroMac->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->NroMac->CellAttributes() ?>>
<span id="el_equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x_NroMac" id="x_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<?php echo $equipos->NroMac->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->SpecialNumber->Visible) { // SpecialNumber ?>
	<div id="r_SpecialNumber" class="form-group">
		<label id="elh_equipos_SpecialNumber" for="x_SpecialNumber" class="col-sm-2 control-label ewLabel"><?php echo $equipos->SpecialNumber->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->SpecialNumber->CellAttributes() ?>>
<span id="el_equipos_SpecialNumber">
<input type="text" data-table="equipos" data-field="x_SpecialNumber" name="x_SpecialNumber" id="x_SpecialNumber" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($equipos->SpecialNumber->getPlaceHolder()) ?>" value="<?php echo $equipos->SpecialNumber->EditValue ?>"<?php echo $equipos->SpecialNumber->EditAttributes() ?>>
</span>
<?php echo $equipos->SpecialNumber->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
	<div id="r_Id_Ubicacion" class="form-group">
		<label id="elh_equipos_Id_Ubicacion" for="x_Id_Ubicacion" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Ubicacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<span id="el_equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Ubicacion" name="x_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x_Id_Ubicacion" id="s_x_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Ubicacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label id="elh_equipos_Id_Estado" for="x_Id_Estado" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
	<div id="r_Id_Sit_Estado" class="form-group">
		<label id="elh_equipos_Id_Sit_Estado" for="x_Id_Sit_Estado" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Sit_Estado" name="x_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Sit_Estado" id="s_x_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Sit_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
	<div id="r_Id_Marca" class="form-group">
		<label id="elh_equipos_Id_Marca" for="x_Id_Marca" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Marca->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<span id="el_equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x_Id_Marca" name="x_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x_Id_Marca") ?>
</select>
<input type="hidden" name="s_x_Id_Marca" id="s_x_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Marca->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
	<div id="r_Id_Modelo" class="form-group">
		<label id="elh_equipos_Id_Modelo" for="x_Id_Modelo" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Modelo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<span id="el_equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modelo" name="x_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x_Id_Modelo" id="s_x_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Modelo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
	<div id="r_Id_Ano" class="form-group">
		<label id="elh_equipos_Id_Ano" for="x_Id_Ano" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Ano->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<span id="el_equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x_Id_Ano" name="x_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x_Id_Ano") ?>
</select>
<input type="hidden" name="s_x_Id_Ano" id="s_x_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Ano->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Tiene_Cargador->Visible) { // Tiene_Cargador ?>
	<div id="r_Tiene_Cargador" class="form-group">
		<label id="elh_equipos_Tiene_Cargador" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Tiene_Cargador->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Tiene_Cargador->CellAttributes() ?>>
<span id="el_equipos_Tiene_Cargador">
<div id="tp_x_Tiene_Cargador" class="ewTemplate"><input type="radio" data-table="equipos" data-field="x_Tiene_Cargador" data-value-separator="<?php echo $equipos->Tiene_Cargador->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_Cargador" id="x_Tiene_Cargador" value="{value}"<?php echo $equipos->Tiene_Cargador->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_Cargador" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $equipos->Tiene_Cargador->RadioButtonListHtml(FALSE, "x_Tiene_Cargador") ?>
</div></div>
</span>
<?php echo $equipos->Tiene_Cargador->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
	<div id="r_Id_Tipo_Equipo" class="form-group">
		<label id="elh_equipos_Id_Tipo_Equipo" for="x_Id_Tipo_Equipo" class="col-sm-2 control-label ewLabel"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Tipo_Equipo->CellAttributes() ?>>
<span id="el_equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Equipo" name="x_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Equipo" id="s_x_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Tipo_Equipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("observacion_equipo", explode(",", $equipos->getCurrentDetailTable())) && $observacion_equipo->DetailAdd) {
?>
<?php if ($equipos->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("observacion_equipo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "observacion_equipogrid.php" ?>
<?php } ?>
<?php if (!$equipos_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $equipos_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fequiposadd.Init();
</script>
<?php
$equipos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$equipos_add->Page_Terminate();
?>
