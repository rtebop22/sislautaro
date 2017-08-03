<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "piso_tecnologicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$piso_tecnologico_add = NULL; // Initialize page object first

class cpiso_tecnologico_add extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_add';

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

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'piso_tecnologico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("piso_tecnologicolist.php"));
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
		$this->Switch->SetVisibility();
		$this->Bocas_Switch->SetVisibility();
		$this->Estado_Switch->SetVisibility();
		$this->Cantidad_Ap->SetVisibility();
		$this->Cantidad_Ap_Func->SetVisibility();
		$this->Ups->SetVisibility();
		$this->Estado_Ups->SetVisibility();
		$this->Marca_Modelo_Serie_Ups->SetVisibility();
		$this->Cableado->SetVisibility();
		$this->Estado_Cableado->SetVisibility();
		$this->Porcent_Estado_Cab->SetVisibility();
		$this->Porcent_Func_Piso->SetVisibility();
		$this->Plano_Escuela->SetVisibility();
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
		global $EW_EXPORT, $piso_tecnologico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($piso_tecnologico);
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
			if (@$_GET["Cue"] != "") {
				$this->Cue->setQueryStringValue($_GET["Cue"]);
				$this->setKey("Cue", $this->Cue->CurrentValue); // Set up key
			} else {
				$this->setKey("Cue", ""); // Clear key
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
					$this->Page_Terminate("piso_tecnologicolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "piso_tecnologicolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "piso_tecnologicoview.php")
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
		$this->Plano_Escuela->Upload->Index = $objForm->Index;
		$this->Plano_Escuela->Upload->UploadFile();
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Switch->CurrentValue = 'Si';
		$this->Bocas_Switch->CurrentValue = NULL;
		$this->Bocas_Switch->OldValue = $this->Bocas_Switch->CurrentValue;
		$this->Estado_Switch->CurrentValue = NULL;
		$this->Estado_Switch->OldValue = $this->Estado_Switch->CurrentValue;
		$this->Cantidad_Ap->CurrentValue = NULL;
		$this->Cantidad_Ap->OldValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap_Func->CurrentValue = NULL;
		$this->Cantidad_Ap_Func->OldValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Ups->CurrentValue = NULL;
		$this->Ups->OldValue = $this->Ups->CurrentValue;
		$this->Estado_Ups->CurrentValue = NULL;
		$this->Estado_Ups->OldValue = $this->Estado_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->CurrentValue = NULL;
		$this->Marca_Modelo_Serie_Ups->OldValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Cableado->CurrentValue = 'Si';
		$this->Estado_Cableado->CurrentValue = NULL;
		$this->Estado_Cableado->OldValue = $this->Estado_Cableado->CurrentValue;
		$this->Porcent_Estado_Cab->CurrentValue = NULL;
		$this->Porcent_Estado_Cab->OldValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Func_Piso->CurrentValue = NULL;
		$this->Porcent_Func_Piso->OldValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Plano_Escuela->Upload->DbValue = NULL;
		$this->Plano_Escuela->OldValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Plano_Escuela->CurrentValue = NULL; // Clear file related field
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Switch->FldIsDetailKey) {
			$this->Switch->setFormValue($objForm->GetValue("x_Switch"));
		}
		if (!$this->Bocas_Switch->FldIsDetailKey) {
			$this->Bocas_Switch->setFormValue($objForm->GetValue("x_Bocas_Switch"));
		}
		if (!$this->Estado_Switch->FldIsDetailKey) {
			$this->Estado_Switch->setFormValue($objForm->GetValue("x_Estado_Switch"));
		}
		if (!$this->Cantidad_Ap->FldIsDetailKey) {
			$this->Cantidad_Ap->setFormValue($objForm->GetValue("x_Cantidad_Ap"));
		}
		if (!$this->Cantidad_Ap_Func->FldIsDetailKey) {
			$this->Cantidad_Ap_Func->setFormValue($objForm->GetValue("x_Cantidad_Ap_Func"));
		}
		if (!$this->Ups->FldIsDetailKey) {
			$this->Ups->setFormValue($objForm->GetValue("x_Ups"));
		}
		if (!$this->Estado_Ups->FldIsDetailKey) {
			$this->Estado_Ups->setFormValue($objForm->GetValue("x_Estado_Ups"));
		}
		if (!$this->Marca_Modelo_Serie_Ups->FldIsDetailKey) {
			$this->Marca_Modelo_Serie_Ups->setFormValue($objForm->GetValue("x_Marca_Modelo_Serie_Ups"));
		}
		if (!$this->Cableado->FldIsDetailKey) {
			$this->Cableado->setFormValue($objForm->GetValue("x_Cableado"));
		}
		if (!$this->Estado_Cableado->FldIsDetailKey) {
			$this->Estado_Cableado->setFormValue($objForm->GetValue("x_Estado_Cableado"));
		}
		if (!$this->Porcent_Estado_Cab->FldIsDetailKey) {
			$this->Porcent_Estado_Cab->setFormValue($objForm->GetValue("x_Porcent_Estado_Cab"));
		}
		if (!$this->Porcent_Func_Piso->FldIsDetailKey) {
			$this->Porcent_Func_Piso->setFormValue($objForm->GetValue("x_Porcent_Func_Piso"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		if (!$this->Cue->FldIsDetailKey)
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Switch->CurrentValue = $this->Switch->FormValue;
		$this->Bocas_Switch->CurrentValue = $this->Bocas_Switch->FormValue;
		$this->Estado_Switch->CurrentValue = $this->Estado_Switch->FormValue;
		$this->Cantidad_Ap->CurrentValue = $this->Cantidad_Ap->FormValue;
		$this->Cantidad_Ap_Func->CurrentValue = $this->Cantidad_Ap_Func->FormValue;
		$this->Ups->CurrentValue = $this->Ups->FormValue;
		$this->Estado_Ups->CurrentValue = $this->Estado_Ups->FormValue;
		$this->Marca_Modelo_Serie_Ups->CurrentValue = $this->Marca_Modelo_Serie_Ups->FormValue;
		$this->Cableado->CurrentValue = $this->Cableado->FormValue;
		$this->Estado_Cableado->CurrentValue = $this->Estado_Cableado->FormValue;
		$this->Porcent_Estado_Cab->CurrentValue = $this->Porcent_Estado_Cab->FormValue;
		$this->Porcent_Func_Piso->CurrentValue = $this->Porcent_Func_Piso->FormValue;
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
		$this->Switch->setDbValue($rs->fields('Switch'));
		$this->Bocas_Switch->setDbValue($rs->fields('Bocas_Switch'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado_Switch'));
		$this->Cantidad_Ap->setDbValue($rs->fields('Cantidad_Ap'));
		$this->Cantidad_Ap_Func->setDbValue($rs->fields('Cantidad_Ap_Func'));
		$this->Ups->setDbValue($rs->fields('Ups'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado_Ups'));
		$this->Marca_Modelo_Serie_Ups->setDbValue($rs->fields('Marca_Modelo_Serie_Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado_Cableado'));
		$this->Porcent_Estado_Cab->setDbValue($rs->fields('Porcent_Estado_Cab'));
		$this->Porcent_Func_Piso->setDbValue($rs->fields('Porcent_Func_Piso'));
		$this->Plano_Escuela->Upload->DbValue = $rs->fields('Plano_Escuela');
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Switch->DbValue = $row['Switch'];
		$this->Bocas_Switch->DbValue = $row['Bocas_Switch'];
		$this->Estado_Switch->DbValue = $row['Estado_Switch'];
		$this->Cantidad_Ap->DbValue = $row['Cantidad_Ap'];
		$this->Cantidad_Ap_Func->DbValue = $row['Cantidad_Ap_Func'];
		$this->Ups->DbValue = $row['Ups'];
		$this->Estado_Ups->DbValue = $row['Estado_Ups'];
		$this->Marca_Modelo_Serie_Ups->DbValue = $row['Marca_Modelo_Serie_Ups'];
		$this->Cableado->DbValue = $row['Cableado'];
		$this->Estado_Cableado->DbValue = $row['Estado_Cableado'];
		$this->Porcent_Estado_Cab->DbValue = $row['Porcent_Estado_Cab'];
		$this->Porcent_Func_Piso->DbValue = $row['Porcent_Func_Piso'];
		$this->Plano_Escuela->Upload->DbValue = $row['Plano_Escuela'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Cue")) <> "")
			$this->Cue->CurrentValue = $this->getKey("Cue"); // Cue
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
		// Switch
		// Bocas_Switch
		// Estado_Switch
		// Cantidad_Ap
		// Cantidad_Ap_Func
		// Ups
		// Estado_Ups
		// Marca_Modelo_Serie_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Porcent_Func_Piso
		// Plano_Escuela
		// Fecha_Actualizacion
		// Usuario
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Bocas_Switch
		$this->Bocas_Switch->ViewValue = $this->Bocas_Switch->CurrentValue;
		$this->Bocas_Switch->ViewCustomAttributes = "";

		// Estado_Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->CurrentValue;
			}
		} else {
			$this->Estado_Switch->ViewValue = NULL;
		}
		$this->Estado_Switch->ViewCustomAttributes = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->ViewValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->ViewCustomAttributes = "";

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->ViewValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Cantidad_Ap_Func->ViewCustomAttributes = "";

		// Ups
		if (strval($this->Ups->CurrentValue) <> "") {
			$this->Ups->ViewValue = $this->Ups->OptionCaption($this->Ups->CurrentValue);
		} else {
			$this->Ups->ViewValue = NULL;
		}
		$this->Ups->ViewCustomAttributes = "";

		// Estado_Ups
		if (strval($this->Estado_Ups->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ups->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->CurrentValue;
			}
		} else {
			$this->Estado_Ups->ViewValue = NULL;
		}
		$this->Estado_Ups->ViewCustomAttributes = "";

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->ViewValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->ViewCustomAttributes = "";

		// Cableado
		if (strval($this->Cableado->CurrentValue) <> "") {
			$this->Cableado->ViewValue = $this->Cableado->OptionCaption($this->Cableado->CurrentValue);
		} else {
			$this->Cableado->ViewValue = NULL;
		}
		$this->Cableado->ViewCustomAttributes = "";

		// Estado_Cableado
		if (strval($this->Estado_Cableado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Cableado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->CurrentValue;
			}
		} else {
			$this->Estado_Cableado->ViewValue = NULL;
		}
		$this->Estado_Cableado->ViewCustomAttributes = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->ViewValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->ViewCustomAttributes = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Plano_Escuela
		if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
			$this->Plano_Escuela->ViewValue = $this->Plano_Escuela->Upload->DbValue;
		} else {
			$this->Plano_Escuela->ViewValue = "";
		}
		$this->Plano_Escuela->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Switch
			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";
			$this->Switch->TooltipValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";
			$this->Bocas_Switch->TooltipValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";
			$this->Estado_Switch->TooltipValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";
			$this->Cantidad_Ap->TooltipValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";
			$this->Cantidad_Ap_Func->TooltipValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";
			$this->Ups->TooltipValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";
			$this->Estado_Ups->TooltipValue = "";

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->HrefValue = "";
			$this->Marca_Modelo_Serie_Ups->TooltipValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";
			$this->Cableado->TooltipValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";
			$this->Estado_Cableado->TooltipValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";
			$this->Porcent_Estado_Cab->TooltipValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";
			$this->Porcent_Func_Piso->TooltipValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;
			$this->Plano_Escuela->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Switch
			$this->Switch->EditCustomAttributes = "";
			$this->Switch->EditValue = $this->Switch->Options(FALSE);

			// Bocas_Switch
			$this->Bocas_Switch->EditAttrs["class"] = "form-control";
			$this->Bocas_Switch->EditCustomAttributes = "";
			$this->Bocas_Switch->EditValue = ew_HtmlEncode($this->Bocas_Switch->CurrentValue);
			$this->Bocas_Switch->PlaceHolder = ew_RemoveHtml($this->Bocas_Switch->FldCaption());

			// Estado_Switch
			$this->Estado_Switch->EditAttrs["class"] = "form-control";
			$this->Estado_Switch->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Switch->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Switch->EditValue = $arwrk;

			// Cantidad_Ap
			$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap->EditCustomAttributes = "";
			$this->Cantidad_Ap->EditValue = ew_HtmlEncode($this->Cantidad_Ap->CurrentValue);
			$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap_Func->EditCustomAttributes = "";
			$this->Cantidad_Ap_Func->EditValue = ew_HtmlEncode($this->Cantidad_Ap_Func->CurrentValue);
			$this->Cantidad_Ap_Func->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap_Func->FldCaption());

			// Ups
			$this->Ups->EditCustomAttributes = "";
			$this->Ups->EditValue = $this->Ups->Options(FALSE);

			// Estado_Ups
			$this->Estado_Ups->EditAttrs["class"] = "form-control";
			$this->Estado_Ups->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ups->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ups->EditValue = $arwrk;

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->EditAttrs["class"] = "form-control";
			$this->Marca_Modelo_Serie_Ups->EditCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->EditValue = ew_HtmlEncode($this->Marca_Modelo_Serie_Ups->CurrentValue);
			$this->Marca_Modelo_Serie_Ups->PlaceHolder = ew_RemoveHtml($this->Marca_Modelo_Serie_Ups->FldCaption());

			// Cableado
			$this->Cableado->EditCustomAttributes = "";
			$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

			// Estado_Cableado
			$this->Estado_Cableado->EditAttrs["class"] = "form-control";
			$this->Estado_Cableado->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Cableado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Cableado->EditValue = $arwrk;

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Cab->EditCustomAttributes = "";
			$this->Porcent_Estado_Cab->EditValue = ew_HtmlEncode($this->Porcent_Estado_Cab->CurrentValue);
			$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
			$this->Porcent_Func_Piso->EditCustomAttributes = "";
			$this->Porcent_Func_Piso->EditValue = ew_HtmlEncode($this->Porcent_Func_Piso->CurrentValue);
			$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());

			// Plano_Escuela
			$this->Plano_Escuela->EditAttrs["class"] = "form-control";
			$this->Plano_Escuela->EditCustomAttributes = "";
			if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
				$this->Plano_Escuela->EditValue = $this->Plano_Escuela->Upload->DbValue;
			} else {
				$this->Plano_Escuela->EditValue = "";
			}
			if (!ew_Empty($this->Plano_Escuela->CurrentValue))
				$this->Plano_Escuela->Upload->FileName = $this->Plano_Escuela->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->Plano_Escuela);

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Switch

			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->HrefValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;

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
		if ($this->Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Switch->FldCaption(), $this->Switch->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Bocas_Switch->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bocas_Switch->FldErrMsg());
		}
		if (!$this->Estado_Switch->FldIsDetailKey && !is_null($this->Estado_Switch->FormValue) && $this->Estado_Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Switch->FldCaption(), $this->Estado_Switch->ReqErrMsg));
		}
		if (!$this->Cantidad_Ap->FldIsDetailKey && !is_null($this->Cantidad_Ap->FormValue) && $this->Cantidad_Ap->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cantidad_Ap->FldCaption(), $this->Cantidad_Ap->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Cantidad_Ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Ap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Ap_Func->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Ap_Func->FldErrMsg());
		}
		if ($this->Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Ups->FldCaption(), $this->Ups->ReqErrMsg));
		}
		if (!$this->Estado_Ups->FldIsDetailKey && !is_null($this->Estado_Ups->FormValue) && $this->Estado_Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Ups->FldCaption(), $this->Estado_Ups->ReqErrMsg));
		}
		if ($this->Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cableado->FldCaption(), $this->Cableado->ReqErrMsg));
		}
		if (!$this->Estado_Cableado->FldIsDetailKey && !is_null($this->Estado_Cableado->FormValue) && $this->Estado_Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Cableado->FldCaption(), $this->Estado_Cableado->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Porcent_Estado_Cab->FormValue)) {
			ew_AddMessage($gsFormError, $this->Porcent_Estado_Cab->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Porcent_Func_Piso->FormValue)) {
			ew_AddMessage($gsFormError, $this->Porcent_Func_Piso->FldErrMsg());
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

		// Switch
		$this->Switch->SetDbValueDef($rsnew, $this->Switch->CurrentValue, NULL, FALSE);

		// Bocas_Switch
		$this->Bocas_Switch->SetDbValueDef($rsnew, $this->Bocas_Switch->CurrentValue, NULL, FALSE);

		// Estado_Switch
		$this->Estado_Switch->SetDbValueDef($rsnew, $this->Estado_Switch->CurrentValue, NULL, FALSE);

		// Cantidad_Ap
		$this->Cantidad_Ap->SetDbValueDef($rsnew, $this->Cantidad_Ap->CurrentValue, NULL, FALSE);

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->SetDbValueDef($rsnew, $this->Cantidad_Ap_Func->CurrentValue, NULL, FALSE);

		// Ups
		$this->Ups->SetDbValueDef($rsnew, $this->Ups->CurrentValue, NULL, FALSE);

		// Estado_Ups
		$this->Estado_Ups->SetDbValueDef($rsnew, $this->Estado_Ups->CurrentValue, NULL, FALSE);

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->SetDbValueDef($rsnew, $this->Marca_Modelo_Serie_Ups->CurrentValue, NULL, FALSE);

		// Cableado
		$this->Cableado->SetDbValueDef($rsnew, $this->Cableado->CurrentValue, NULL, FALSE);

		// Estado_Cableado
		$this->Estado_Cableado->SetDbValueDef($rsnew, $this->Estado_Cableado->CurrentValue, NULL, FALSE);

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->SetDbValueDef($rsnew, $this->Porcent_Estado_Cab->CurrentValue, NULL, FALSE);

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->SetDbValueDef($rsnew, $this->Porcent_Func_Piso->CurrentValue, NULL, FALSE);

		// Plano_Escuela
		if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
			$this->Plano_Escuela->Upload->DbValue = ""; // No need to delete old file
			if ($this->Plano_Escuela->Upload->FileName == "") {
				$rsnew['Plano_Escuela'] = NULL;
			} else {
				$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
			}
		}

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
		if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
			if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->Plano_Escuela->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
			} else {
				$NewFiles = array();
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Cue']) == "") {
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
				if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
					if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Plano_Escuela']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->Plano_Escuela->Upload->SaveToFile($this->Plano_Escuela->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
					$FileCount = count($OldFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
							@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
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

		// Plano_Escuela
		ew_CleanUploadTempPath($this->Plano_Escuela, $this->Plano_Escuela->Upload->Index);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("piso_tecnologicolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Estado_Switch":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Ups":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Cableado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
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
		$table = 'piso_tecnologico';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'piso_tecnologico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

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
if (!isset($piso_tecnologico_add)) $piso_tecnologico_add = new cpiso_tecnologico_add();

// Page init
$piso_tecnologico_add->Page_Init();

// Page main
$piso_tecnologico_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpiso_tecnologicoadd = new ew_Form("fpiso_tecnologicoadd", "add");

// Validate form
fpiso_tecnologicoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Switch->FldCaption(), $piso_tecnologico->Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bocas_Switch");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Bocas_Switch->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Switch->FldCaption(), $piso_tecnologico->Estado_Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cantidad_Ap->FldCaption(), $piso_tecnologico->Cantidad_Ap->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap_Func");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap_Func->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Ups->FldCaption(), $piso_tecnologico->Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Ups->FldCaption(), $piso_tecnologico->Estado_Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cableado->FldCaption(), $piso_tecnologico->Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Cableado->FldCaption(), $piso_tecnologico->Estado_Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Estado_Cab");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Cab->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Func_Piso");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Func_Piso->FldErrMsg()) ?>");

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
fpiso_tecnologicoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicoadd.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicoadd.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoadd.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicoadd.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoadd.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoadd.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicoadd.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoadd.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoadd.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicoadd.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$piso_tecnologico_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $piso_tecnologico_add->ShowPageHeader(); ?>
<?php
$piso_tecnologico_add->ShowMessage();
?>
<form name="fpiso_tecnologicoadd" id="fpiso_tecnologicoadd" class="<?php echo $piso_tecnologico_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($piso_tecnologico_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($piso_tecnologico->getCurrentMasterTable() == "dato_establecimiento") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $piso_tecnologico->Cue->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<div id="r_Switch" class="form-group">
		<label id="elh_piso_tecnologico_Switch" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Switch->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Switch">
<div id="tp_x_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x_Switch" id="x_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x_Switch", 1) ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
	<div id="r_Bocas_Switch" class="form-group">
		<label id="elh_piso_tecnologico_Bocas_Switch" for="x_Bocas_Switch" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Bocas_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" data-page="1" name="x_Bocas_Switch" id="x_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Bocas_Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<div id="r_Estado_Switch" class="form-group">
		<label id="elh_piso_tecnologico_Estado_Switch" for="x_Estado_Switch" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Switch" name="x_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x_Estado_Switch" id="s_x_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<div id="r_Cantidad_Ap" class="form-group">
		<label id="elh_piso_tecnologico_Cantidad_Ap" for="x_Cantidad_Ap" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" data-page="1" name="x_Cantidad_Ap" id="x_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Cantidad_Ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
	<div id="r_Cantidad_Ap_Func" class="form-group">
		<label id="elh_piso_tecnologico_Cantidad_Ap_Func" for="x_Cantidad_Ap_Func" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cantidad_Ap_Func->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" data-page="1" name="x_Cantidad_Ap_Func" id="x_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Cantidad_Ap_Func->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<div id="r_Ups" class="form-group">
		<label id="elh_piso_tecnologico_Ups" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Ups->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Ups">
<div id="tp_x_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x_Ups" id="x_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x_Ups", 1) ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<div id="r_Estado_Ups" class="form-group">
		<label id="elh_piso_tecnologico_Estado_Ups" for="x_Estado_Ups" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Ups" name="x_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x_Estado_Ups" id="s_x_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Marca_Modelo_Serie_Ups->Visible) { // Marca_Modelo_Serie_Ups ?>
	<div id="r_Marca_Modelo_Serie_Ups" class="form-group">
		<label id="elh_piso_tecnologico_Marca_Modelo_Serie_Ups" for="x_Marca_Modelo_Serie_Ups" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Marca_Modelo_Serie_Ups">
<input type="text" data-table="piso_tecnologico" data-field="x_Marca_Modelo_Serie_Ups" data-page="1" name="x_Marca_Modelo_Serie_Ups" id="x_Marca_Modelo_Serie_Ups" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Marca_Modelo_Serie_Ups->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->EditValue ?>"<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<div id="r_Cableado" class="form-group">
		<label id="elh_piso_tecnologico_Cableado" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Cableado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cableado">
<div id="tp_x_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x_Cableado" id="x_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x_Cableado", 1) ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Cableado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<div id="r_Estado_Cableado" class="form-group">
		<label id="elh_piso_tecnologico_Estado_Cableado" for="x_Estado_Cableado" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-page="1" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Cableado" name="x_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x_Estado_Cableado" id="s_x_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Cableado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<div id="r_Porcent_Estado_Cab" class="form-group">
		<label id="elh_piso_tecnologico_Porcent_Estado_Cab" for="x_Porcent_Estado_Cab" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" data-page="1" name="x_Porcent_Estado_Cab" id="x_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<div id="r_Porcent_Func_Piso" class="form-group">
		<label id="elh_piso_tecnologico_Porcent_Func_Piso" for="x_Porcent_Func_Piso" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" data-page="1" name="x_Porcent_Func_Piso" id="x_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Porcent_Func_Piso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<div id="r_Plano_Escuela" class="form-group">
		<label id="elh_piso_tecnologico_Plano_Escuela" class="col-sm-2 control-label ewLabel"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<span id="el_piso_tecnologico_Plano_Escuela">
<div id="fd_x_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" data-page="1" name="x_Plano_Escuela" id="x_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Plano_Escuela" id= "fn_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x_Plano_Escuela" id= "fa_x_Plano_Escuela" value="0">
<input type="hidden" name="fs_x_Plano_Escuela" id= "fs_x_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x_Plano_Escuela" id= "fx_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Plano_Escuela" id= "fm_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Plano_Escuela" id= "fc_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $piso_tecnologico->Plano_Escuela->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($piso_tecnologico->Cue->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_Cue" id="x_Cue" value="<?php echo ew_HtmlEncode(strval($piso_tecnologico->Cue->getSessionValue())) ?>">
<?php } ?>
<?php if (!$piso_tecnologico_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $piso_tecnologico_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpiso_tecnologicoadd.Init();
</script>
<?php
$piso_tecnologico_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_add->Page_Terminate();
?>
