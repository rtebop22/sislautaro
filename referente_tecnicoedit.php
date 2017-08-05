<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "referente_tecnicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$referente_tecnico_edit = NULL; // Initialize page object first

class creferente_tecnico_edit extends creferente_tecnico {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'referente_tecnico';

	// Page object name
	var $PageObjName = 'referente_tecnico_edit';

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

		// Table object (referente_tecnico)
		if (!isset($GLOBALS["referente_tecnico"]) || get_class($GLOBALS["referente_tecnico"]) == "creferente_tecnico") {
			$GLOBALS["referente_tecnico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referente_tecnico"];
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
			define("EW_TABLE_NAME", 'referente_tecnico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("referente_tecnicolist.php"));
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
		$this->Apellido_Nombre->SetVisibility();
		$this->DniRte->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Fecha_Ingreso->SetVisibility();
		$this->Titulo->SetVisibility();
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
		if (@$_GET["DniRte"] <> "") {
			$this->DniRte->setQueryStringValue($_GET["DniRte"]);
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
		if ($this->DniRte->CurrentValue == "") {
			$this->Page_Terminate("referente_tecnicolist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("referente_tecnicolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "referente_tecnicolist.php")
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
		if (!$this->Apellido_Nombre->FldIsDetailKey) {
			$this->Apellido_Nombre->setFormValue($objForm->GetValue("x_Apellido_Nombre"));
		}
		if (!$this->DniRte->FldIsDetailKey) {
			$this->DniRte->setFormValue($objForm->GetValue("x_DniRte"));
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
		if (!$this->Fecha_Ingreso->FldIsDetailKey) {
			$this->Fecha_Ingreso->setFormValue($objForm->GetValue("x_Fecha_Ingreso"));
			$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		}
		if (!$this->Titulo->FldIsDetailKey) {
			$this->Titulo->setFormValue($objForm->GetValue("x_Titulo"));
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
		$this->LoadRow();
		$this->Apellido_Nombre->CurrentValue = $this->Apellido_Nombre->FormValue;
		$this->DniRte->CurrentValue = $this->DniRte->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono->CurrentValue = $this->Telefono->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Mail->CurrentValue = $this->Mail->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Fecha_Ingreso->CurrentValue = $this->Fecha_Ingreso->FormValue;
		$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		$this->Titulo->CurrentValue = $this->Titulo->FormValue;
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
		$this->Apellido_Nombre->setDbValue($rs->fields('Apellido_Nombre'));
		$this->DniRte->setDbValue($rs->fields('DniRte'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Fecha_Ingreso->setDbValue($rs->fields('Fecha_Ingreso'));
		$this->Titulo->setDbValue($rs->fields('Titulo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apellido_Nombre->DbValue = $row['Apellido_Nombre'];
		$this->DniRte->DbValue = $row['DniRte'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Celular->DbValue = $row['Celular'];
		$this->Mail->DbValue = $row['Mail'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Fecha_Ingreso->DbValue = $row['Fecha_Ingreso'];
		$this->Titulo->DbValue = $row['Titulo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Apellido_Nombre
		// DniRte
		// Domicilio
		// Telefono
		// Celular
		// Mail
		// Id_Turno
		// Fecha_Ingreso
		// Titulo
		// Usuario
		// Fecha_Actualizacion
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// DniRte
		$this->DniRte->ViewValue = $this->DniRte->CurrentValue;
		$this->DniRte->ViewCustomAttributes = "";

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

		// Fecha_Ingreso
		$this->Fecha_Ingreso->ViewValue = $this->Fecha_Ingreso->CurrentValue;
		$this->Fecha_Ingreso->ViewValue = ew_FormatDateTime($this->Fecha_Ingreso->ViewValue, 2);
		$this->Fecha_Ingreso->ViewCustomAttributes = "";

		// Titulo
		$this->Titulo->ViewValue = $this->Titulo->CurrentValue;
		$this->Titulo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";
			$this->DniRte->TooltipValue = "";

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

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";
			$this->Fecha_Ingreso->TooltipValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";
			$this->Titulo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = $this->DniRte->CurrentValue;
			$this->DniRte->ViewCustomAttributes = "";

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

			// Fecha_Ingreso
			$this->Fecha_Ingreso->EditAttrs["class"] = "form-control";
			$this->Fecha_Ingreso->EditCustomAttributes = "";
			$this->Fecha_Ingreso->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Ingreso->CurrentValue, 2));
			$this->Fecha_Ingreso->PlaceHolder = ew_RemoveHtml($this->Fecha_Ingreso->FldCaption());

			// Titulo
			$this->Titulo->EditAttrs["class"] = "form-control";
			$this->Titulo->EditCustomAttributes = "";
			$this->Titulo->EditValue = ew_HtmlEncode($this->Titulo->CurrentValue);
			$this->Titulo->PlaceHolder = ew_RemoveHtml($this->Titulo->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";

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

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";

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
		if (!$this->Apellido_Nombre->FldIsDetailKey && !is_null($this->Apellido_Nombre->FormValue) && $this->Apellido_Nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellido_Nombre->FldCaption(), $this->Apellido_Nombre->ReqErrMsg));
		}
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
		if (!$this->Mail->FldIsDetailKey && !is_null($this->Mail->FormValue) && $this->Mail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Mail->FldCaption(), $this->Mail->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->Mail->FormValue)) {
			ew_AddMessage($gsFormError, $this->Mail->FldErrMsg());
		}
		if (!$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Fecha_Ingreso->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Ingreso->FldErrMsg());
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

			// Apellido_Nombre
			$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, $this->Apellido_Nombre->ReadOnly);

			// DniRte
			// Domicilio

			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly);

			// Telefono
			$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, $this->Telefono->ReadOnly);

			// Celular
			$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, $this->Celular->ReadOnly);

			// Mail
			$this->Mail->SetDbValueDef($rsnew, $this->Mail->CurrentValue, NULL, $this->Mail->ReadOnly);

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly);

			// Fecha_Ingreso
			$this->Fecha_Ingreso->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2), NULL, $this->Fecha_Ingreso->ReadOnly);

			// Titulo
			$this->Titulo->SetDbValueDef($rsnew, $this->Titulo->CurrentValue, NULL, $this->Titulo->ReadOnly);

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("referente_tecnicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['DniRte'];

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
if (!isset($referente_tecnico_edit)) $referente_tecnico_edit = new creferente_tecnico_edit();

// Page init
$referente_tecnico_edit->Page_Init();

// Page main
$referente_tecnico_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = freferente_tecnicoedit = new ew_Form("freferente_tecnicoedit", "edit");

// Validate form
freferente_tecnicoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellido_Nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Apellido_Nombre->FldCaption(), $referente_tecnico->Apellido_Nombre->ReqErrMsg)) ?>");
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
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Mail->FldCaption(), $referente_tecnico->Mail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Mail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Id_Turno->FldCaption(), $referente_tecnico->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Ingreso");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Fecha_Ingreso->FldErrMsg()) ?>");

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
freferente_tecnicoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicoedit.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicoedit.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$referente_tecnico_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $referente_tecnico_edit->ShowPageHeader(); ?>
<?php
$referente_tecnico_edit->ShowMessage();
?>
<form name="freferente_tecnicoedit" id="freferente_tecnicoedit" class="<?php echo $referente_tecnico_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referente_tecnico_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referente_tecnico_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referente_tecnico">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($referente_tecnico_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($referente_tecnico->getCurrentMasterTable() == "dato_establecimiento") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $referente_tecnico->Cue->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<div id="r_Apellido_Nombre" class="form-group">
		<label id="elh_referente_tecnico_Apellido_Nombre" for="x_Apellido_Nombre" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Apellido_Nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Apellido_Nombre->CellAttributes() ?>>
<span id="el_referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" data-page="1" name="x_Apellido_Nombre" id="x_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Apellido_Nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
	<div id="r_DniRte" class="form-group">
		<label id="elh_referente_tecnico_DniRte" for="x_DniRte" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->DniRte->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->DniRte->CellAttributes() ?>>
<span id="el_referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->DniRte->EditValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" data-page="1" name="x_DniRte" id="x_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->CurrentValue) ?>">
<?php echo $referente_tecnico->DniRte->CustomMsg ?></div></div>
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
		<label id="elh_referente_tecnico_Mail" for="x_Mail" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Mail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
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
<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
	<div id="r_Fecha_Ingreso" class="form-group">
		<label id="elh_referente_tecnico_Fecha_Ingreso" for="x_Fecha_Ingreso" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Fecha_Ingreso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Fecha_Ingreso->CellAttributes() ?>>
<span id="el_referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-page="1" data-format="2" name="x_Fecha_Ingreso" id="x_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicoedit", "x_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<?php echo $referente_tecnico->Fecha_Ingreso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
	<div id="r_Titulo" class="form-group">
		<label id="elh_referente_tecnico_Titulo" for="x_Titulo" class="col-sm-2 control-label ewLabel"><?php echo $referente_tecnico->Titulo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Titulo->CellAttributes() ?>>
<span id="el_referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" data-page="1" name="x_Titulo" id="x_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Titulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$referente_tecnico_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $referente_tecnico_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freferente_tecnicoedit.Init();
</script>
<?php
$referente_tecnico_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$referente_tecnico_edit->Page_Terminate();
?>
