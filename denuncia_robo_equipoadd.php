<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "denuncia_robo_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$denuncia_robo_equipo_add = NULL; // Initialize page object first

class cdenuncia_robo_equipo_add extends cdenuncia_robo_equipo {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'denuncia_robo_equipo';

	// Page object name
	var $PageObjName = 'denuncia_robo_equipo_add';

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

		// Table object (denuncia_robo_equipo)
		if (!isset($GLOBALS["denuncia_robo_equipo"]) || get_class($GLOBALS["denuncia_robo_equipo"]) == "cdenuncia_robo_equipo") {
			$GLOBALS["denuncia_robo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["denuncia_robo_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'denuncia_robo_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("denuncia_robo_equipolist.php"));
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
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Quien_Denuncia->SetVisibility();
		$this->DetalleDenuncia->SetVisibility();
		$this->Fecha_Denuncia->SetVisibility();
		$this->Id_Estado_Den->SetVisibility();
		$this->Ruta_Archivo->SetVisibility();
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
			if (@$_GET["IdDenuncia"] != "") {
				$this->IdDenuncia->setQueryStringValue($_GET["IdDenuncia"]);
				$this->setKey("IdDenuncia", $this->IdDenuncia->CurrentValue); // Set up key
			} else {
				$this->setKey("IdDenuncia", ""); // Clear key
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
					$this->Page_Terminate("denuncia_robo_equipolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "denuncia_robo_equipolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "denuncia_robo_equipoview.php")
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
		$this->Ruta_Archivo->Upload->Index = $objForm->Index;
		$this->Ruta_Archivo->Upload->UploadFile();
		$this->Ruta_Archivo->CurrentValue = $this->Ruta_Archivo->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Dni_Tutor->CurrentValue = NULL;
		$this->Dni_Tutor->OldValue = $this->Dni_Tutor->CurrentValue;
		$this->Quien_Denuncia->CurrentValue = NULL;
		$this->Quien_Denuncia->OldValue = $this->Quien_Denuncia->CurrentValue;
		$this->DetalleDenuncia->CurrentValue = NULL;
		$this->DetalleDenuncia->OldValue = $this->DetalleDenuncia->CurrentValue;
		$this->Fecha_Denuncia->CurrentValue = NULL;
		$this->Fecha_Denuncia->OldValue = $this->Fecha_Denuncia->CurrentValue;
		$this->Id_Estado_Den->CurrentValue = 1;
		$this->Ruta_Archivo->Upload->DbValue = NULL;
		$this->Ruta_Archivo->OldValue = $this->Ruta_Archivo->Upload->DbValue;
		$this->Ruta_Archivo->CurrentValue = NULL; // Clear file related field
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
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
			$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 7);
		}
		if (!$this->Id_Estado_Den->FldIsDetailKey) {
			$this->Id_Estado_Den->setFormValue($objForm->GetValue("x_Id_Estado_Den"));
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Quien_Denuncia->CurrentValue = $this->Quien_Denuncia->FormValue;
		$this->DetalleDenuncia->CurrentValue = $this->DetalleDenuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = $this->Fecha_Denuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 7);
		$this->Id_Estado_Den->CurrentValue = $this->Id_Estado_Den->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Quien_Denuncia->setDbValue($rs->fields('Quien_Denuncia'));
		$this->DetalleDenuncia->setDbValue($rs->fields('DetalleDenuncia'));
		$this->Fecha_Denuncia->setDbValue($rs->fields('Fecha_Denuncia'));
		$this->Id_Estado_Den->setDbValue($rs->fields('Id_Estado_Den'));
		$this->Ruta_Archivo->Upload->DbValue = $rs->fields('Ruta_Archivo');
		$this->Ruta_Archivo->CurrentValue = $this->Ruta_Archivo->Upload->DbValue;
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IdDenuncia->DbValue = $row['IdDenuncia'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Quien_Denuncia->DbValue = $row['Quien_Denuncia'];
		$this->DetalleDenuncia->DbValue = $row['DetalleDenuncia'];
		$this->Fecha_Denuncia->DbValue = $row['Fecha_Denuncia'];
		$this->Id_Estado_Den->DbValue = $row['Id_Estado_Den'];
		$this->Ruta_Archivo->Upload->DbValue = $row['Ruta_Archivo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IdDenuncia")) <> "")
			$this->IdDenuncia->CurrentValue = $this->getKey("IdDenuncia"); // IdDenuncia
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
		// IdDenuncia
		// Dni
		// NroSerie
		// Dni_Tutor
		// Quien_Denuncia
		// DetalleDenuncia
		// Fecha_Denuncia
		// Id_Estado_Den
		// Ruta_Archivo
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IdDenuncia
		$this->IdDenuncia->ViewValue = $this->IdDenuncia->CurrentValue;
		$this->IdDenuncia->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		if (strval($this->Dni->CurrentValue) <> "") {
			$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni->ViewValue = $this->Dni->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni->ViewValue = $this->Dni->CurrentValue;
			}
		} else {
			$this->Dni->ViewValue = NULL;
		}
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
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

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		if (strval($this->Dni_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			}
		} else {
			$this->Dni_Tutor->ViewValue = NULL;
		}
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Quien_Denuncia
		$this->Quien_Denuncia->ViewValue = $this->Quien_Denuncia->CurrentValue;
		$this->Quien_Denuncia->ViewCustomAttributes = "";

		// DetalleDenuncia
		$this->DetalleDenuncia->ViewValue = $this->DetalleDenuncia->CurrentValue;
		$this->DetalleDenuncia->ViewCustomAttributes = "";

		// Fecha_Denuncia
		$this->Fecha_Denuncia->ViewValue = $this->Fecha_Denuncia->CurrentValue;
		$this->Fecha_Denuncia->ViewValue = ew_FormatDateTime($this->Fecha_Denuncia->ViewValue, 7);
		$this->Fecha_Denuncia->ViewCustomAttributes = "";

		// Id_Estado_Den
		if (strval($this->Id_Estado_Den->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Den`" . ew_SearchString("=", $this->Id_Estado_Den->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Den`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_denuncia`";
		$sWhereWrk = "";
		$this->Id_Estado_Den->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Den, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Den->ViewValue = $this->Id_Estado_Den->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Den->ViewValue = $this->Id_Estado_Den->CurrentValue;
			}
		} else {
			$this->Id_Estado_Den->ViewValue = NULL;
		}
		$this->Id_Estado_Den->ViewCustomAttributes = "";

		// Ruta_Archivo
		$this->Ruta_Archivo->UploadPath = 'ArchivosDenuncia';
		if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
			$this->Ruta_Archivo->ImageAlt = $this->Ruta_Archivo->FldAlt();
			$this->Ruta_Archivo->ViewValue = $this->Ruta_Archivo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo->ViewValue = "";
		}
		$this->Ruta_Archivo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

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

			// Ruta_Archivo
			$this->Ruta_Archivo->LinkCustomAttributes = "";
			$this->Ruta_Archivo->UploadPath = 'ArchivosDenuncia';
			if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
				$this->Ruta_Archivo->HrefValue = "%u"; // Add prefix/suffix
				$this->Ruta_Archivo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Ruta_Archivo->HrefValue = ew_ConvertFullUrl($this->Ruta_Archivo->HrefValue);
			} else {
				$this->Ruta_Archivo->HrefValue = "";
			}
			$this->Ruta_Archivo->HrefValue2 = $this->Ruta_Archivo->UploadPath . $this->Ruta_Archivo->Upload->DbValue;
			$this->Ruta_Archivo->TooltipValue = "";
			if ($this->Ruta_Archivo->UseColorbox) {
				if (ew_Empty($this->Ruta_Archivo->TooltipValue))
					$this->Ruta_Archivo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Ruta_Archivo->LinkAttrs["data-rel"] = "denuncia_robo_equipo_x_Ruta_Archivo";
				ew_AppendClass($this->Ruta_Archivo->LinkAttrs["class"], "ewLightbox");
			}

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			if (strval($this->Dni->CurrentValue) <> "") {
				$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni->EditValue = $this->Dni->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
				}
			} else {
				$this->Dni->EditValue = NULL;
			}
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
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

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			if (strval($this->Dni_Tutor->CurrentValue) <> "") {
				$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni_Tutor->EditValue = $this->Dni_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
				}
			} else {
				$this->Dni_Tutor->EditValue = NULL;
			}
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
			$this->Fecha_Denuncia->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Denuncia->CurrentValue, 7));
			$this->Fecha_Denuncia->PlaceHolder = ew_RemoveHtml($this->Fecha_Denuncia->FldCaption());

			// Id_Estado_Den
			$this->Id_Estado_Den->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Den->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Den->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Den`" . ew_SearchString("=", $this->Id_Estado_Den->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Den`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_denuncia`";
			$sWhereWrk = "";
			$this->Id_Estado_Den->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Den, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Den->EditValue = $arwrk;

			// Ruta_Archivo
			$this->Ruta_Archivo->EditAttrs["class"] = "form-control";
			$this->Ruta_Archivo->EditCustomAttributes = "";
			$this->Ruta_Archivo->UploadPath = 'ArchivosDenuncia';
			if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
				$this->Ruta_Archivo->ImageAlt = $this->Ruta_Archivo->FldAlt();
				$this->Ruta_Archivo->EditValue = $this->Ruta_Archivo->Upload->DbValue;
			} else {
				$this->Ruta_Archivo->EditValue = "";
			}
			if (!ew_Empty($this->Ruta_Archivo->CurrentValue))
				$this->Ruta_Archivo->Upload->FileName = $this->Ruta_Archivo->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->Ruta_Archivo);

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Dni

			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

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

			// Ruta_Archivo
			$this->Ruta_Archivo->LinkCustomAttributes = "";
			$this->Ruta_Archivo->UploadPath = 'ArchivosDenuncia';
			if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
				$this->Ruta_Archivo->HrefValue = "%u"; // Add prefix/suffix
				$this->Ruta_Archivo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Ruta_Archivo->HrefValue = ew_ConvertFullUrl($this->Ruta_Archivo->HrefValue);
			} else {
				$this->Ruta_Archivo->HrefValue = "";
			}
			$this->Ruta_Archivo->HrefValue2 = $this->Ruta_Archivo->UploadPath . $this->Ruta_Archivo->Upload->DbValue;

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
		if (!$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
		}
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni_Tutor->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni_Tutor->FldErrMsg());
		}
		if (!$this->DetalleDenuncia->FldIsDetailKey && !is_null($this->DetalleDenuncia->FormValue) && $this->DetalleDenuncia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DetalleDenuncia->FldCaption(), $this->DetalleDenuncia->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Denuncia->FormValue)) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->Ruta_Archivo->OldUploadPath = 'ArchivosDenuncia';
			$this->Ruta_Archivo->UploadPath = $this->Ruta_Archivo->OldUploadPath;
		}
		$rsnew = array();

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Dni_Tutor
		$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, FALSE);

		// Quien_Denuncia
		$this->Quien_Denuncia->SetDbValueDef($rsnew, $this->Quien_Denuncia->CurrentValue, NULL, FALSE);

		// DetalleDenuncia
		$this->DetalleDenuncia->SetDbValueDef($rsnew, $this->DetalleDenuncia->CurrentValue, NULL, FALSE);

		// Fecha_Denuncia
		$this->Fecha_Denuncia->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 7), NULL, FALSE);

		// Id_Estado_Den
		$this->Id_Estado_Den->SetDbValueDef($rsnew, $this->Id_Estado_Den->CurrentValue, 0, FALSE);

		// Ruta_Archivo
		if ($this->Ruta_Archivo->Visible && !$this->Ruta_Archivo->Upload->KeepFile) {
			$this->Ruta_Archivo->Upload->DbValue = ""; // No need to delete old file
			if ($this->Ruta_Archivo->Upload->FileName == "") {
				$rsnew['Ruta_Archivo'] = NULL;
			} else {
				$rsnew['Ruta_Archivo'] = $this->Ruta_Archivo->Upload->FileName;
			}
		}

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;
		if ($this->Ruta_Archivo->Visible && !$this->Ruta_Archivo->Upload->KeepFile) {
			$this->Ruta_Archivo->UploadPath = 'ArchivosDenuncia';
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo->Upload->DbValue);
			if (!ew_Empty($this->Ruta_Archivo->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->Ruta_Archivo->Upload->Index < 0) ? $this->Ruta_Archivo->FldVar : substr($this->Ruta_Archivo->FldVar, 0, 1) . $this->Ruta_Archivo->Upload->Index . substr($this->Ruta_Archivo->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->Ruta_Archivo->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Ruta_Archivo->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->Ruta_Archivo->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Ruta_Archivo->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->Ruta_Archivo->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Ruta_Archivo->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->Ruta_Archivo->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['Ruta_Archivo'] = $this->Ruta_Archivo->Upload->FileName;
			} else {
				$NewFiles = array();
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->IdDenuncia->setDbValue($conn->Insert_ID());
				$rsnew['IdDenuncia'] = $this->IdDenuncia->DbValue;
				if ($this->Ruta_Archivo->Visible && !$this->Ruta_Archivo->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo->Upload->DbValue);
					if (!ew_Empty($this->Ruta_Archivo->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Ruta_Archivo']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->Ruta_Archivo->Upload->Index < 0) ? $this->Ruta_Archivo->FldVar : substr($this->Ruta_Archivo->FldVar, 0, 1) . $this->Ruta_Archivo->Upload->Index . substr($this->Ruta_Archivo->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->Ruta_Archivo->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->Ruta_Archivo->Upload->SaveToFile($this->Ruta_Archivo->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
					$FileCount = count($OldFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
							@unlink(ew_UploadPathEx(TRUE, $this->Ruta_Archivo->OldUploadPath) . $OldFiles[$i]);
					}
				}
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

		// Ruta_Archivo
		ew_CleanUploadTempPath($this->Ruta_Archivo, $this->Ruta_Archivo->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("denuncia_robo_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$this->MultiPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Dni":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni_Tutor` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Den":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Den` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_denuncia`";
			$sWhereWrk = "";
			$this->Id_Estado_Den->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Den` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Den, $sWhereWrk); // Call Lookup selecting
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
		case "x_Dni":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni) . "',`Dni`) LIKE '{query_value}%'";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld` FROM `tutores`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni_Tutor) . "',`Dni_Tutor`) LIKE '{query_value}%'";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'denuncia_robo_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'denuncia_robo_equipo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['IdDenuncia'];

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
if (!isset($denuncia_robo_equipo_add)) $denuncia_robo_equipo_add = new cdenuncia_robo_equipo_add();

// Page init
$denuncia_robo_equipo_add->Page_Init();

// Page main
$denuncia_robo_equipo_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$denuncia_robo_equipo_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdenuncia_robo_equipoadd = new ew_Form("fdenuncia_robo_equipoadd", "add");

// Validate form
fdenuncia_robo_equipoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni->FldCaption(), $denuncia_robo_equipo->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->NroSerie->FldCaption(), $denuncia_robo_equipo->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni_Tutor->FldCaption(), $denuncia_robo_equipo->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_DetalleDenuncia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->DetalleDenuncia->FldCaption(), $denuncia_robo_equipo->DetalleDenuncia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Denuncia");
			if (elm && !ew_CheckEuroDate(elm.value))
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
fdenuncia_robo_equipoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdenuncia_robo_equipoadd.ValidateRequired = true;
<?php } else { ?>
fdenuncia_robo_equipoadd.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fdenuncia_robo_equipoadd.MultiPage = new ew_MultiPage("fdenuncia_robo_equipoadd");

// Dynamic selection lists
fdenuncia_robo_equipoadd.Lists["x_Dni"] = {"LinkField":"x_Dni","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","x_Dni","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fdenuncia_robo_equipoadd.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fdenuncia_robo_equipoadd.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fdenuncia_robo_equipoadd.Lists["x_Id_Estado_Den"] = {"LinkField":"x_Id_Estado_Den","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_denuncia"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$denuncia_robo_equipo_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $denuncia_robo_equipo_add->ShowPageHeader(); ?>
<?php
$denuncia_robo_equipo_add->ShowMessage();
?>
<form name="fdenuncia_robo_equipoadd" id="fdenuncia_robo_equipoadd" class="<?php echo $denuncia_robo_equipo_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($denuncia_robo_equipo_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $denuncia_robo_equipo_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="denuncia_robo_equipo">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($denuncia_robo_equipo_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ewMultiPage">
<div class="panel-group" id="denuncia_robo_equipo_add">
	<div class="panel panel-default<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#denuncia_robo_equipo_add" href="#tab_denuncia_robo_equipo1"><?php echo $denuncia_robo_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("1") ?>" id="tab_denuncia_robo_equipo1">
			<div class="panel-body">
<div>
<?php if ($denuncia_robo_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label id="elh_denuncia_robo_equipo_Dni" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni">
<?php $denuncia_robo_equipo->Dni->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$denuncia_robo_equipo->Dni->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni"><?php echo (strval($denuncia_robo_equipo->Dni->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $denuncia_robo_equipo->Dni->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($denuncia_robo_equipo->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="denuncia_robo_equipo" data-field="x_Dni" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $denuncia_robo_equipo->Dni->DisplayValueSeparatorAttribute() ?>" name="x_Dni" id="x_Dni" value="<?php echo $denuncia_robo_equipo->Dni->CurrentValue ?>"<?php echo $denuncia_robo_equipo->Dni->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "personas")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $denuncia_robo_equipo->Dni->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Dni',url:'personasaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Dni"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $denuncia_robo_equipo->Dni->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_Dni" id="s_x_Dni" value="<?php echo $denuncia_robo_equipo->Dni->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Dni" id="ln_x_Dni" value="x_NroSerie,x_Dni_Tutor">
</span>
<?php echo $denuncia_robo_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_denuncia_robo_equipo_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->NroSerie->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($denuncia_robo_equipo->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $denuncia_robo_equipo->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($denuncia_robo_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="denuncia_robo_equipo" data-field="x_NroSerie" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $denuncia_robo_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $denuncia_robo_equipo->NroSerie->CurrentValue ?>"<?php echo $denuncia_robo_equipo->NroSerie->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $denuncia_robo_equipo->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $denuncia_robo_equipo->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $denuncia_robo_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
<?php echo $denuncia_robo_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label id="elh_denuncia_robo_equipo_Dni_Tutor" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni_Tutor"><?php echo (strval($denuncia_robo_equipo->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $denuncia_robo_equipo->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($denuncia_robo_equipo->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="denuncia_robo_equipo" data-field="x_Dni_Tutor" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $denuncia_robo_equipo->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo $denuncia_robo_equipo->Dni_Tutor->CurrentValue ?>"<?php echo $denuncia_robo_equipo->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_Dni_Tutor" id="s_x_Dni_Tutor" value="<?php echo $denuncia_robo_equipo->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php echo $denuncia_robo_equipo->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#denuncia_robo_equipo_add" href="#tab_denuncia_robo_equipo2"><?php echo $denuncia_robo_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("2") ?>" id="tab_denuncia_robo_equipo2">
			<div class="panel-body">
<div>
<?php if ($denuncia_robo_equipo->Quien_Denuncia->Visible) { // Quien_Denuncia ?>
	<div id="r_Quien_Denuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_Quien_Denuncia" for="x_Quien_Denuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Quien_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Quien_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Quien_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Quien_Denuncia" data-page="2" name="x_Quien_Denuncia" id="x_Quien_Denuncia" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Quien_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Quien_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->DetalleDenuncia->Visible) { // DetalleDenuncia ?>
	<div id="r_DetalleDenuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_DetalleDenuncia" for="x_DetalleDenuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->DetalleDenuncia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->DetalleDenuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_DetalleDenuncia">
<textarea data-table="denuncia_robo_equipo" data-field="x_DetalleDenuncia" data-page="2" name="x_DetalleDenuncia" id="x_DetalleDenuncia" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->DetalleDenuncia->getPlaceHolder()) ?>"<?php echo $denuncia_robo_equipo->DetalleDenuncia->EditAttributes() ?>><?php echo $denuncia_robo_equipo->DetalleDenuncia->EditValue ?></textarea>
</span>
<?php echo $denuncia_robo_equipo->DetalleDenuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Fecha_Denuncia->Visible) { // Fecha_Denuncia ?>
	<div id="r_Fecha_Denuncia" class="form-group">
		<label id="elh_denuncia_robo_equipo_Fecha_Denuncia" for="x_Fecha_Denuncia" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Fecha_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Fecha_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Fecha_Denuncia" data-page="2" data-format="7" name="x_Fecha_Denuncia" id="x_Fecha_Denuncia" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Fecha_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditAttributes() ?>>
<?php if (!$denuncia_robo_equipo->Fecha_Denuncia->ReadOnly && !$denuncia_robo_equipo->Fecha_Denuncia->Disabled && !isset($denuncia_robo_equipo->Fecha_Denuncia->EditAttrs["readonly"]) && !isset($denuncia_robo_equipo->Fecha_Denuncia->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdenuncia_robo_equipoadd", "x_Fecha_Denuncia", 7);
</script>
<?php } ?>
</span>
<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Id_Estado_Den->Visible) { // Id_Estado_Den ?>
	<div id="r_Id_Estado_Den" class="form-group">
		<label id="elh_denuncia_robo_equipo_Id_Estado_Den" for="x_Id_Estado_Den" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Id_Estado_Den->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Id_Estado_Den->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Id_Estado_Den">
<select data-table="denuncia_robo_equipo" data-field="x_Id_Estado_Den" data-page="2" data-value-separator="<?php echo $denuncia_robo_equipo->Id_Estado_Den->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Den" name="x_Id_Estado_Den"<?php echo $denuncia_robo_equipo->Id_Estado_Den->EditAttributes() ?>>
<?php echo $denuncia_robo_equipo->Id_Estado_Den->SelectOptionListHtml("x_Id_Estado_Den") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Den" id="s_x_Id_Estado_Den" value="<?php echo $denuncia_robo_equipo->Id_Estado_Den->LookupFilterQuery() ?>">
</span>
<?php echo $denuncia_robo_equipo->Id_Estado_Den->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#denuncia_robo_equipo_add" href="#tab_denuncia_robo_equipo3"><?php echo $denuncia_robo_equipo->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $denuncia_robo_equipo_add->MultiPages->PageStyle("3") ?>" id="tab_denuncia_robo_equipo3">
			<div class="panel-body">
<div>
<?php if ($denuncia_robo_equipo->Ruta_Archivo->Visible) { // Ruta_Archivo ?>
	<div id="r_Ruta_Archivo" class="form-group">
		<label id="elh_denuncia_robo_equipo_Ruta_Archivo" class="col-sm-2 control-label ewLabel"><?php echo $denuncia_robo_equipo->Ruta_Archivo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Ruta_Archivo->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Ruta_Archivo">
<div id="fd_x_Ruta_Archivo">
<span title="<?php echo $denuncia_robo_equipo->Ruta_Archivo->FldTitle() ? $denuncia_robo_equipo->Ruta_Archivo->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($denuncia_robo_equipo->Ruta_Archivo->ReadOnly || $denuncia_robo_equipo->Ruta_Archivo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="denuncia_robo_equipo" data-field="x_Ruta_Archivo" data-page="3" name="x_Ruta_Archivo" id="x_Ruta_Archivo" multiple="multiple"<?php echo $denuncia_robo_equipo->Ruta_Archivo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Ruta_Archivo" id= "fn_x_Ruta_Archivo" value="<?php echo $denuncia_robo_equipo->Ruta_Archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Ruta_Archivo" id= "fa_x_Ruta_Archivo" value="0">
<input type="hidden" name="fs_x_Ruta_Archivo" id= "fs_x_Ruta_Archivo" value="500">
<input type="hidden" name="fx_x_Ruta_Archivo" id= "fx_x_Ruta_Archivo" value="<?php echo $denuncia_robo_equipo->Ruta_Archivo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Ruta_Archivo" id= "fm_x_Ruta_Archivo" value="<?php echo $denuncia_robo_equipo->Ruta_Archivo->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Ruta_Archivo" id= "fc_x_Ruta_Archivo" value="<?php echo $denuncia_robo_equipo->Ruta_Archivo->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Ruta_Archivo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $denuncia_robo_equipo->Ruta_Archivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if (!$denuncia_robo_equipo_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $denuncia_robo_equipo_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdenuncia_robo_equipoadd.Init();
</script>
<?php
$denuncia_robo_equipo_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$denuncia_robo_equipo_add->Page_Terminate();
?>
