<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "liberacion_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$liberacion_equipo_edit = NULL; // Initialize page object first

class cliberacion_equipo_edit extends cliberacion_equipo {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'liberacion_equipo';

	// Page object name
	var $PageObjName = 'liberacion_equipo_edit';

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

		// Table object (liberacion_equipo)
		if (!isset($GLOBALS["liberacion_equipo"]) || get_class($GLOBALS["liberacion_equipo"]) == "cliberacion_equipo") {
			$GLOBALS["liberacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["liberacion_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'liberacion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("liberacion_equipolist.php"));
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
		$this->Fecha_Finalizacion->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Id_Modalidad->SetVisibility();
		$this->Id_Nivel->SetVisibility();
		$this->Id_Autoridad->SetVisibility();
		$this->Fecha_Liberacion->SetVisibility();
		$this->Ruta_Archivo_Copia_Titulo->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

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
		global $EW_EXPORT, $liberacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($liberacion_equipo);
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

		// Load key from QueryString
		if (@$_GET["Dni"] <> "") {
			$this->Dni->setQueryStringValue($_GET["Dni"]);
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
		if ($this->Dni->CurrentValue == "") {
			$this->Page_Terminate("liberacion_equipolist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("liberacion_equipolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->GetViewUrl();
				if (ew_GetPageName($sReturnUrl) == "liberacion_equipolist.php")
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
		$this->Ruta_Archivo_Copia_Titulo->Upload->Index = $objForm->Index;
		$this->Ruta_Archivo_Copia_Titulo->Upload->UploadFile();
		$this->Ruta_Archivo_Copia_Titulo->CurrentValue = $this->Ruta_Archivo_Copia_Titulo->Upload->FileName;
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
		if (!$this->Fecha_Finalizacion->FldIsDetailKey) {
			$this->Fecha_Finalizacion->setFormValue($objForm->GetValue("x_Fecha_Finalizacion"));
		}
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		if (!$this->Id_Modalidad->FldIsDetailKey) {
			$this->Id_Modalidad->setFormValue($objForm->GetValue("x_Id_Modalidad"));
		}
		if (!$this->Id_Nivel->FldIsDetailKey) {
			$this->Id_Nivel->setFormValue($objForm->GetValue("x_Id_Nivel"));
		}
		if (!$this->Id_Autoridad->FldIsDetailKey) {
			$this->Id_Autoridad->setFormValue($objForm->GetValue("x_Id_Autoridad"));
		}
		if (!$this->Fecha_Liberacion->FldIsDetailKey) {
			$this->Fecha_Liberacion->setFormValue($objForm->GetValue("x_Fecha_Liberacion"));
			$this->Fecha_Liberacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Liberacion->CurrentValue, 7);
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
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Fecha_Finalizacion->CurrentValue = $this->Fecha_Finalizacion->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Id_Modalidad->CurrentValue = $this->Id_Modalidad->FormValue;
		$this->Id_Nivel->CurrentValue = $this->Id_Nivel->FormValue;
		$this->Id_Autoridad->CurrentValue = $this->Id_Autoridad->FormValue;
		$this->Fecha_Liberacion->CurrentValue = $this->Fecha_Liberacion->FormValue;
		$this->Fecha_Liberacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Liberacion->CurrentValue, 7);
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Fecha_Finalizacion->setDbValue($rs->fields('Fecha_Finalizacion'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Id_Modalidad->setDbValue($rs->fields('Id_Modalidad'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Autoridad->setDbValue($rs->fields('Id_Autoridad'));
		$this->Fecha_Liberacion->setDbValue($rs->fields('Fecha_Liberacion'));
		$this->Ruta_Archivo_Copia_Titulo->Upload->DbValue = $rs->fields('Ruta_Archivo_Copia_Titulo');
		$this->Ruta_Archivo_Copia_Titulo->CurrentValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Fecha_Finalizacion->DbValue = $row['Fecha_Finalizacion'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Id_Modalidad->DbValue = $row['Id_Modalidad'];
		$this->Id_Nivel->DbValue = $row['Id_Nivel'];
		$this->Id_Autoridad->DbValue = $row['Id_Autoridad'];
		$this->Fecha_Liberacion->DbValue = $row['Fecha_Liberacion'];
		$this->Ruta_Archivo_Copia_Titulo->Upload->DbValue = $row['Ruta_Archivo_Copia_Titulo'];
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
		// Dni
		// NroSerie
		// Dni_Tutor
		// Fecha_Finalizacion
		// Observacion
		// Id_Modalidad
		// Id_Nivel
		// Id_Autoridad
		// Fecha_Liberacion
		// Ruta_Archivo_Copia_Titulo
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->ViewValue = $this->Fecha_Finalizacion->CurrentValue;
		$this->Fecha_Finalizacion->ViewValue = ew_FormatDateTime($this->Fecha_Finalizacion->ViewValue, 7);
		$this->Fecha_Finalizacion->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Modalidad
		if (strval($this->Id_Modalidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modalidad`" . ew_SearchString("=", $this->Id_Modalidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modalidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modalidad_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Modalidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->CurrentValue;
			}
		} else {
			$this->Id_Modalidad->ViewValue = NULL;
		}
		$this->Id_Modalidad->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Nivel`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Autoridad
		if (strval($this->Id_Autoridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
		$sWhereWrk = "";
		$this->Id_Autoridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
			}
		} else {
			$this->Id_Autoridad->ViewValue = NULL;
		}
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Fecha_Liberacion
		$this->Fecha_Liberacion->ViewValue = $this->Fecha_Liberacion->CurrentValue;
		$this->Fecha_Liberacion->ViewValue = ew_FormatDateTime($this->Fecha_Liberacion->ViewValue, 7);
		$this->Fecha_Liberacion->ViewCustomAttributes = "";

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo->UploadPath = 'ArchivosLiberacion';
		if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->DbValue)) {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = "";
		}
		$this->Ruta_Archivo_Copia_Titulo->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

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

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->LinkCustomAttributes = "";
			$this->Fecha_Finalizacion->HrefValue = "";
			$this->Fecha_Finalizacion->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Id_Modalidad
			$this->Id_Modalidad->LinkCustomAttributes = "";
			$this->Id_Modalidad->HrefValue = "";
			$this->Id_Modalidad->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// Id_Autoridad
			$this->Id_Autoridad->LinkCustomAttributes = "";
			$this->Id_Autoridad->HrefValue = "";
			$this->Id_Autoridad->TooltipValue = "";

			// Fecha_Liberacion
			$this->Fecha_Liberacion->LinkCustomAttributes = "";
			$this->Fecha_Liberacion->HrefValue = "";
			$this->Fecha_Liberacion->TooltipValue = "";

			// Ruta_Archivo_Copia_Titulo
			$this->Ruta_Archivo_Copia_Titulo->LinkCustomAttributes = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue2 = $this->Ruta_Archivo_Copia_Titulo->UploadPath . $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
			$this->Ruta_Archivo_Copia_Titulo->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = $this->Dni->CurrentValue;
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
					$this->Dni->EditValue = $this->Dni->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni->EditValue = $this->Dni->CurrentValue;
				}
			} else {
				$this->Dni->EditValue = NULL;
			}
			$this->Dni->ViewCustomAttributes = "";

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

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Finalizacion->EditCustomAttributes = "";
			$this->Fecha_Finalizacion->EditValue = ew_HtmlEncode($this->Fecha_Finalizacion->CurrentValue);
			$this->Fecha_Finalizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Finalizacion->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Modalidad
			$this->Id_Modalidad->EditAttrs["class"] = "form-control";
			$this->Id_Modalidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modalidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modalidad`" . ew_SearchString("=", $this->Id_Modalidad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modalidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modalidad_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Modalidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modalidad->EditValue = $arwrk;

			// Id_Nivel
			$this->Id_Nivel->EditAttrs["class"] = "form-control";
			$this->Id_Nivel->EditCustomAttributes = "";
			if (trim(strval($this->Id_Nivel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Nivel`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Nivel->EditValue = $arwrk;

			// Id_Autoridad
			$this->Id_Autoridad->EditAttrs["class"] = "form-control";
			$this->Id_Autoridad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Autoridad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Autoridad->EditValue = $arwrk;

			// Fecha_Liberacion
			$this->Fecha_Liberacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Liberacion->EditCustomAttributes = "";
			$this->Fecha_Liberacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Liberacion->CurrentValue, 7));
			$this->Fecha_Liberacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Liberacion->FldCaption());

			// Ruta_Archivo_Copia_Titulo
			$this->Ruta_Archivo_Copia_Titulo->EditAttrs["class"] = "form-control";
			$this->Ruta_Archivo_Copia_Titulo->EditCustomAttributes = "";
			$this->Ruta_Archivo_Copia_Titulo->UploadPath = 'ArchivosLiberacion';
			if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->DbValue)) {
				$this->Ruta_Archivo_Copia_Titulo->EditValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
			} else {
				$this->Ruta_Archivo_Copia_Titulo->EditValue = "";
			}
			if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->CurrentValue))
				$this->Ruta_Archivo_Copia_Titulo->Upload->FileName = $this->Ruta_Archivo_Copia_Titulo->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->Ruta_Archivo_Copia_Titulo);

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Dni

			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->LinkCustomAttributes = "";
			$this->Fecha_Finalizacion->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Id_Modalidad
			$this->Id_Modalidad->LinkCustomAttributes = "";
			$this->Id_Modalidad->HrefValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";

			// Id_Autoridad
			$this->Id_Autoridad->LinkCustomAttributes = "";
			$this->Id_Autoridad->HrefValue = "";

			// Fecha_Liberacion
			$this->Fecha_Liberacion->LinkCustomAttributes = "";
			$this->Fecha_Liberacion->HrefValue = "";

			// Ruta_Archivo_Copia_Titulo
			$this->Ruta_Archivo_Copia_Titulo->LinkCustomAttributes = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue2 = $this->Ruta_Archivo_Copia_Titulo->UploadPath . $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;

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
		if (!$this->Fecha_Finalizacion->FldIsDetailKey && !is_null($this->Fecha_Finalizacion->FormValue) && $this->Fecha_Finalizacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Fecha_Finalizacion->FldCaption(), $this->Fecha_Finalizacion->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Finalizacion->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Finalizacion->FldErrMsg());
		}
		if (!$this->Id_Modalidad->FldIsDetailKey && !is_null($this->Id_Modalidad->FormValue) && $this->Id_Modalidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Modalidad->FldCaption(), $this->Id_Modalidad->ReqErrMsg));
		}
		if (!$this->Id_Nivel->FldIsDetailKey && !is_null($this->Id_Nivel->FormValue) && $this->Id_Nivel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Nivel->FldCaption(), $this->Id_Nivel->ReqErrMsg));
		}
		if (!$this->Id_Autoridad->FldIsDetailKey && !is_null($this->Id_Autoridad->FormValue) && $this->Id_Autoridad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Autoridad->FldCaption(), $this->Id_Autoridad->ReqErrMsg));
		}
		if (!$this->Fecha_Liberacion->FldIsDetailKey && !is_null($this->Fecha_Liberacion->FormValue) && $this->Fecha_Liberacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Fecha_Liberacion->FldCaption(), $this->Fecha_Liberacion->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Liberacion->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Liberacion->FldErrMsg());
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
			$this->Ruta_Archivo_Copia_Titulo->OldUploadPath = 'ArchivosLiberacion';
			$this->Ruta_Archivo_Copia_Titulo->UploadPath = $this->Ruta_Archivo_Copia_Titulo->OldUploadPath;
			$rsnew = array();

			// Dni
			// NroSerie

			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly);

			// Dni_Tutor
			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly);

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->SetDbValueDef($rsnew, $this->Fecha_Finalizacion->CurrentValue, NULL, $this->Fecha_Finalizacion->ReadOnly);

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly);

			// Id_Modalidad
			$this->Id_Modalidad->SetDbValueDef($rsnew, $this->Id_Modalidad->CurrentValue, 0, $this->Id_Modalidad->ReadOnly);

			// Id_Nivel
			$this->Id_Nivel->SetDbValueDef($rsnew, $this->Id_Nivel->CurrentValue, 0, $this->Id_Nivel->ReadOnly);

			// Id_Autoridad
			$this->Id_Autoridad->SetDbValueDef($rsnew, $this->Id_Autoridad->CurrentValue, 0, $this->Id_Autoridad->ReadOnly);

			// Fecha_Liberacion
			$this->Fecha_Liberacion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Liberacion->CurrentValue, 7), NULL, $this->Fecha_Liberacion->ReadOnly);

			// Ruta_Archivo_Copia_Titulo
			if ($this->Ruta_Archivo_Copia_Titulo->Visible && !$this->Ruta_Archivo_Copia_Titulo->ReadOnly && !$this->Ruta_Archivo_Copia_Titulo->Upload->KeepFile) {
				$this->Ruta_Archivo_Copia_Titulo->Upload->DbValue = $rsold['Ruta_Archivo_Copia_Titulo']; // Get original value
				if ($this->Ruta_Archivo_Copia_Titulo->Upload->FileName == "") {
					$rsnew['Ruta_Archivo_Copia_Titulo'] = NULL;
				} else {
					$rsnew['Ruta_Archivo_Copia_Titulo'] = $this->Ruta_Archivo_Copia_Titulo->Upload->FileName;
				}
			}

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;
			if ($this->Ruta_Archivo_Copia_Titulo->Visible && !$this->Ruta_Archivo_Copia_Titulo->Upload->KeepFile) {
				$this->Ruta_Archivo_Copia_Titulo->UploadPath = 'ArchivosLiberacion';
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue);
				if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->FileName)) {
					$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo_Copia_Titulo->Upload->FileName);
					$FileCount = count($NewFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						$fldvar = ($this->Ruta_Archivo_Copia_Titulo->Upload->Index < 0) ? $this->Ruta_Archivo_Copia_Titulo->FldVar : substr($this->Ruta_Archivo_Copia_Titulo->FldVar, 0, 1) . $this->Ruta_Archivo_Copia_Titulo->Upload->Index . substr($this->Ruta_Archivo_Copia_Titulo->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->Ruta_Archivo_Copia_Titulo->TblVar) . EW_PATH_DELIMITER . $file)) {
								if (!in_array($file, $OldFiles)) {
									$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Ruta_Archivo_Copia_Titulo->UploadPath), $file); // Get new file name
									if ($file1 <> $file) { // Rename temp file
										while (file_exists(ew_UploadTempPath($fldvar, $this->Ruta_Archivo_Copia_Titulo->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
											$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Ruta_Archivo_Copia_Titulo->UploadPath), $file1, TRUE); // Use indexed name
										rename(ew_UploadTempPath($fldvar, $this->Ruta_Archivo_Copia_Titulo->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Ruta_Archivo_Copia_Titulo->TblVar) . EW_PATH_DELIMITER . $file1);
										$NewFiles[$i] = $file1;
									}
								}
							}
						}
					}
					$this->Ruta_Archivo_Copia_Titulo->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$rsnew['Ruta_Archivo_Copia_Titulo'] = $this->Ruta_Archivo_Copia_Titulo->Upload->FileName;
				} else {
					$NewFiles = array();
				}
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
					if ($this->Ruta_Archivo_Copia_Titulo->Visible && !$this->Ruta_Archivo_Copia_Titulo->Upload->KeepFile) {
						$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue);
						if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->FileName)) {
							$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Ruta_Archivo_Copia_Titulo->Upload->FileName);
							$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Ruta_Archivo_Copia_Titulo']);
							$FileCount = count($NewFiles);
							for ($i = 0; $i < $FileCount; $i++) {
								$fldvar = ($this->Ruta_Archivo_Copia_Titulo->Upload->Index < 0) ? $this->Ruta_Archivo_Copia_Titulo->FldVar : substr($this->Ruta_Archivo_Copia_Titulo->FldVar, 0, 1) . $this->Ruta_Archivo_Copia_Titulo->Upload->Index . substr($this->Ruta_Archivo_Copia_Titulo->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->Ruta_Archivo_Copia_Titulo->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
									if (file_exists($file)) {
										$this->Ruta_Archivo_Copia_Titulo->Upload->SaveToFile($this->Ruta_Archivo_Copia_Titulo->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$FileCount = count($OldFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink(ew_UploadPathEx(TRUE, $this->Ruta_Archivo_Copia_Titulo->OldUploadPath) . $OldFiles[$i]);
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

		// Ruta_Archivo_Copia_Titulo
		ew_CleanUploadTempPath($this->Ruta_Archivo_Copia_Titulo, $this->Ruta_Archivo_Copia_Titulo->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("liberacion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
		case "x_Id_Modalidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modalidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modalidad_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Modalidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modalidad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Nivel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Nivel` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Nivel` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Autoridad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Autoridad` AS `LinkFld`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Autoridad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
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
		$table = 'liberacion_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'liberacion_equipo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni'];

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
if (!isset($liberacion_equipo_edit)) $liberacion_equipo_edit = new cliberacion_equipo_edit();

// Page init
$liberacion_equipo_edit->Page_Init();

// Page main
$liberacion_equipo_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$liberacion_equipo_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fliberacion_equipoedit = new ew_Form("fliberacion_equipoedit", "edit");

// Validate form
fliberacion_equipoedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Dni->FldCaption(), $liberacion_equipo->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->NroSerie->FldCaption(), $liberacion_equipo->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Dni_Tutor->FldCaption(), $liberacion_equipo->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Finalizacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Fecha_Finalizacion->FldCaption(), $liberacion_equipo->Fecha_Finalizacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Finalizacion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Fecha_Finalizacion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modalidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Id_Modalidad->FldCaption(), $liberacion_equipo->Id_Modalidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Nivel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Id_Nivel->FldCaption(), $liberacion_equipo->Id_Nivel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Autoridad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Id_Autoridad->FldCaption(), $liberacion_equipo->Id_Autoridad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Liberacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $liberacion_equipo->Fecha_Liberacion->FldCaption(), $liberacion_equipo->Fecha_Liberacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Liberacion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Fecha_Liberacion->FldErrMsg()) ?>");

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
fliberacion_equipoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fliberacion_equipoedit.ValidateRequired = true;
<?php } else { ?>
fliberacion_equipoedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fliberacion_equipoedit.MultiPage = new ew_MultiPage("fliberacion_equipoedit");

// Dynamic selection lists
fliberacion_equipoedit.Lists["x_Dni"] = {"LinkField":"x_Dni","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","x_Dni","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fliberacion_equipoedit.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fliberacion_equipoedit.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fliberacion_equipoedit.Lists["x_Id_Modalidad"] = {"LinkField":"x_Id_Modalidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modalidad_establecimiento"};
fliberacion_equipoedit.Lists["x_Id_Nivel"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fliberacion_equipoedit.Lists["x_Id_Autoridad"] = {"LinkField":"x_Id_Autoridad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"autoridades_escolares"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$liberacion_equipo_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $liberacion_equipo_edit->ShowPageHeader(); ?>
<?php
$liberacion_equipo_edit->ShowMessage();
?>
<form name="fliberacion_equipoedit" id="fliberacion_equipoedit" class="<?php echo $liberacion_equipo_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($liberacion_equipo_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $liberacion_equipo_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="liberacion_equipo">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($liberacion_equipo_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ewMultiPage">
<div class="panel-group" id="liberacion_equipo_edit">
	<div class="panel panel-default<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_edit" href="#tab_liberacion_equipo1"><?php echo $liberacion_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("1") ?>" id="tab_liberacion_equipo1">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label id="elh_liberacion_equipo_Dni" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Dni->CellAttributes() ?>>
<span id="el_liberacion_equipo_Dni">
<span<?php echo $liberacion_equipo->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $liberacion_equipo->Dni->EditValue ?></p></span>
</span>
<input type="hidden" data-table="liberacion_equipo" data-field="x_Dni" data-page="1" name="x_Dni" id="x_Dni" value="<?php echo ew_HtmlEncode($liberacion_equipo->Dni->CurrentValue) ?>">
<?php echo $liberacion_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label id="elh_liberacion_equipo_NroSerie" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->NroSerie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->NroSerie->CellAttributes() ?>>
<span id="el_liberacion_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($liberacion_equipo->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $liberacion_equipo->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($liberacion_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="liberacion_equipo" data-field="x_NroSerie" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $liberacion_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $liberacion_equipo->NroSerie->CurrentValue ?>"<?php echo $liberacion_equipo->NroSerie->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $liberacion_equipo->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $liberacion_equipo->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $liberacion_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
<?php echo $liberacion_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label id="elh_liberacion_equipo_Dni_Tutor" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el_liberacion_equipo_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni_Tutor"><?php echo (strval($liberacion_equipo->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $liberacion_equipo->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($liberacion_equipo->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="liberacion_equipo" data-field="x_Dni_Tutor" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $liberacion_equipo->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo $liberacion_equipo->Dni_Tutor->CurrentValue ?>"<?php echo $liberacion_equipo->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $liberacion_equipo->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $liberacion_equipo->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x_Dni_Tutor" id="s_x_Dni_Tutor" value="<?php echo $liberacion_equipo->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php echo $liberacion_equipo->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Autoridad->Visible) { // Id_Autoridad ?>
	<div id="r_Id_Autoridad" class="form-group">
		<label id="elh_liberacion_equipo_Id_Autoridad" for="x_Id_Autoridad" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Id_Autoridad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Id_Autoridad->CellAttributes() ?>>
<span id="el_liberacion_equipo_Id_Autoridad">
<select data-table="liberacion_equipo" data-field="x_Id_Autoridad" data-page="1" data-value-separator="<?php echo $liberacion_equipo->Id_Autoridad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Autoridad" name="x_Id_Autoridad"<?php echo $liberacion_equipo->Id_Autoridad->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Autoridad->SelectOptionListHtml("x_Id_Autoridad") ?>
</select>
<input type="hidden" name="s_x_Id_Autoridad" id="s_x_Id_Autoridad" value="<?php echo $liberacion_equipo->Id_Autoridad->LookupFilterQuery() ?>">
</span>
<?php echo $liberacion_equipo->Id_Autoridad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Fecha_Liberacion->Visible) { // Fecha_Liberacion ?>
	<div id="r_Fecha_Liberacion" class="form-group">
		<label id="elh_liberacion_equipo_Fecha_Liberacion" for="x_Fecha_Liberacion" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Fecha_Liberacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Fecha_Liberacion->CellAttributes() ?>>
<span id="el_liberacion_equipo_Fecha_Liberacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Fecha_Liberacion" data-page="1" data-format="7" name="x_Fecha_Liberacion" id="x_Fecha_Liberacion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Fecha_Liberacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Fecha_Liberacion->EditValue ?>"<?php echo $liberacion_equipo->Fecha_Liberacion->EditAttributes() ?>>
<?php if (!$liberacion_equipo->Fecha_Liberacion->ReadOnly && !$liberacion_equipo->Fecha_Liberacion->Disabled && !isset($liberacion_equipo->Fecha_Liberacion->EditAttrs["readonly"]) && !isset($liberacion_equipo->Fecha_Liberacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fliberacion_equipoedit", "x_Fecha_Liberacion", 7);
</script>
<?php } ?>
</span>
<?php echo $liberacion_equipo->Fecha_Liberacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_edit" href="#tab_liberacion_equipo2"><?php echo $liberacion_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("2") ?>" id="tab_liberacion_equipo2">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Fecha_Finalizacion->Visible) { // Fecha_Finalizacion ?>
	<div id="r_Fecha_Finalizacion" class="form-group">
		<label id="elh_liberacion_equipo_Fecha_Finalizacion" for="x_Fecha_Finalizacion" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Fecha_Finalizacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Fecha_Finalizacion->CellAttributes() ?>>
<span id="el_liberacion_equipo_Fecha_Finalizacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Fecha_Finalizacion" data-page="2" name="x_Fecha_Finalizacion" id="x_Fecha_Finalizacion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Fecha_Finalizacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Fecha_Finalizacion->EditValue ?>"<?php echo $liberacion_equipo->Fecha_Finalizacion->EditAttributes() ?>>
<?php if (!$liberacion_equipo->Fecha_Finalizacion->ReadOnly && !$liberacion_equipo->Fecha_Finalizacion->Disabled && !isset($liberacion_equipo->Fecha_Finalizacion->EditAttrs["readonly"]) && !isset($liberacion_equipo->Fecha_Finalizacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fliberacion_equipoedit", "x_Fecha_Finalizacion", 7);
</script>
<?php } ?>
</span>
<?php echo $liberacion_equipo->Fecha_Finalizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label id="elh_liberacion_equipo_Observacion" for="x_Observacion" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Observacion->CellAttributes() ?>>
<span id="el_liberacion_equipo_Observacion">
<textarea data-table="liberacion_equipo" data-field="x_Observacion" data-page="2" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Observacion->getPlaceHolder()) ?>"<?php echo $liberacion_equipo->Observacion->EditAttributes() ?>><?php echo $liberacion_equipo->Observacion->EditValue ?></textarea>
</span>
<?php echo $liberacion_equipo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Modalidad->Visible) { // Id_Modalidad ?>
	<div id="r_Id_Modalidad" class="form-group">
		<label id="elh_liberacion_equipo_Id_Modalidad" for="x_Id_Modalidad" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Id_Modalidad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Id_Modalidad->CellAttributes() ?>>
<span id="el_liberacion_equipo_Id_Modalidad">
<select data-table="liberacion_equipo" data-field="x_Id_Modalidad" data-page="2" data-value-separator="<?php echo $liberacion_equipo->Id_Modalidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modalidad" name="x_Id_Modalidad"<?php echo $liberacion_equipo->Id_Modalidad->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Modalidad->SelectOptionListHtml("x_Id_Modalidad") ?>
</select>
<input type="hidden" name="s_x_Id_Modalidad" id="s_x_Id_Modalidad" value="<?php echo $liberacion_equipo->Id_Modalidad->LookupFilterQuery() ?>">
</span>
<?php echo $liberacion_equipo->Id_Modalidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Nivel->Visible) { // Id_Nivel ?>
	<div id="r_Id_Nivel" class="form-group">
		<label id="elh_liberacion_equipo_Id_Nivel" for="x_Id_Nivel" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Id_Nivel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Id_Nivel->CellAttributes() ?>>
<span id="el_liberacion_equipo_Id_Nivel">
<select data-table="liberacion_equipo" data-field="x_Id_Nivel" data-page="2" data-value-separator="<?php echo $liberacion_equipo->Id_Nivel->DisplayValueSeparatorAttribute() ?>" id="x_Id_Nivel" name="x_Id_Nivel"<?php echo $liberacion_equipo->Id_Nivel->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Nivel->SelectOptionListHtml("x_Id_Nivel") ?>
</select>
<input type="hidden" name="s_x_Id_Nivel" id="s_x_Id_Nivel" value="<?php echo $liberacion_equipo->Id_Nivel->LookupFilterQuery() ?>">
</span>
<?php echo $liberacion_equipo->Id_Nivel->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_edit" href="#tab_liberacion_equipo3"><?php echo $liberacion_equipo->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_edit->MultiPages->PageStyle("3") ?>" id="tab_liberacion_equipo3">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Ruta_Archivo_Copia_Titulo->Visible) { // Ruta_Archivo_Copia_Titulo ?>
	<div id="r_Ruta_Archivo_Copia_Titulo" class="form-group">
		<label id="elh_liberacion_equipo_Ruta_Archivo_Copia_Titulo" class="col-sm-2 control-label ewLabel"><?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->CellAttributes() ?>>
<span id="el_liberacion_equipo_Ruta_Archivo_Copia_Titulo">
<div id="fd_x_Ruta_Archivo_Copia_Titulo">
<span title="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->FldTitle() ? $liberacion_equipo->Ruta_Archivo_Copia_Titulo->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($liberacion_equipo->Ruta_Archivo_Copia_Titulo->ReadOnly || $liberacion_equipo->Ruta_Archivo_Copia_Titulo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="liberacion_equipo" data-field="x_Ruta_Archivo_Copia_Titulo" data-page="3" name="x_Ruta_Archivo_Copia_Titulo" id="x_Ruta_Archivo_Copia_Titulo" multiple="multiple"<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Ruta_Archivo_Copia_Titulo" id= "fn_x_Ruta_Archivo_Copia_Titulo" value="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->Upload->FileName ?>">
<?php if (@$_POST["fa_x_Ruta_Archivo_Copia_Titulo"] == "0") { ?>
<input type="hidden" name="fa_x_Ruta_Archivo_Copia_Titulo" id= "fa_x_Ruta_Archivo_Copia_Titulo" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_Ruta_Archivo_Copia_Titulo" id= "fa_x_Ruta_Archivo_Copia_Titulo" value="1">
<?php } ?>
<input type="hidden" name="fs_x_Ruta_Archivo_Copia_Titulo" id= "fs_x_Ruta_Archivo_Copia_Titulo" value="65535">
<input type="hidden" name="fx_x_Ruta_Archivo_Copia_Titulo" id= "fx_x_Ruta_Archivo_Copia_Titulo" value="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Ruta_Archivo_Copia_Titulo" id= "fm_x_Ruta_Archivo_Copia_Titulo" value="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Ruta_Archivo_Copia_Titulo" id= "fc_x_Ruta_Archivo_Copia_Titulo" value="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Ruta_Archivo_Copia_Titulo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if (!$liberacion_equipo_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $liberacion_equipo_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fliberacion_equipoedit.Init();
</script>
<?php
$liberacion_equipo_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$liberacion_equipo_edit->Page_Terminate();
?>
