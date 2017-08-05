<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "novedadesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$novedades_add = NULL; // Initialize page object first

class cnovedades_add extends cnovedades {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'novedades';

	// Page object name
	var $PageObjName = 'novedades_add';

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

		// Table object (novedades)
		if (!isset($GLOBALS["novedades"]) || get_class($GLOBALS["novedades"]) == "cnovedades") {
			$GLOBALS["novedades"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["novedades"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'novedades', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("novedadeslist.php"));
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
		$this->Detalle->SetVisibility();
		$this->Archivos->SetVisibility();
		$this->Links->SetVisibility();
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
		global $EW_EXPORT, $novedades;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($novedades);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id_Novedad"] != "") {
				$this->Id_Novedad->setQueryStringValue($_GET["Id_Novedad"]);
				$this->setKey("Id_Novedad", $this->Id_Novedad->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Novedad", ""); // Clear key
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
					$this->Page_Terminate("novedadeslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "novedadeslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "novedadesview.php")
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
		$this->Archivos->Upload->Index = $objForm->Index;
		$this->Archivos->Upload->UploadFile();
		$this->Archivos->CurrentValue = $this->Archivos->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Detalle->CurrentValue = NULL;
		$this->Detalle->OldValue = $this->Detalle->CurrentValue;
		$this->Archivos->Upload->DbValue = NULL;
		$this->Archivos->OldValue = $this->Archivos->Upload->DbValue;
		$this->Archivos->CurrentValue = NULL; // Clear file related field
		$this->Links->CurrentValue = NULL;
		$this->Links->OldValue = $this->Links->CurrentValue;
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
		if (!$this->Detalle->FldIsDetailKey) {
			$this->Detalle->setFormValue($objForm->GetValue("x_Detalle"));
		}
		if (!$this->Links->FldIsDetailKey) {
			$this->Links->setFormValue($objForm->GetValue("x_Links"));
		}
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		}
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Detalle->CurrentValue = $this->Detalle->FormValue;
		$this->Links->CurrentValue = $this->Links->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
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
		$this->Id_Novedad->setDbValue($rs->fields('Id_Novedad'));
		$this->Detalle->setDbValue($rs->fields('Detalle'));
		$this->Archivos->Upload->DbValue = $rs->fields('Archivos');
		$this->Archivos->CurrentValue = $this->Archivos->Upload->DbValue;
		$this->Links->setDbValue($rs->fields('Links'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Novedad->DbValue = $row['Id_Novedad'];
		$this->Detalle->DbValue = $row['Detalle'];
		$this->Archivos->Upload->DbValue = $row['Archivos'];
		$this->Links->DbValue = $row['Links'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Novedad")) <> "")
			$this->Id_Novedad->CurrentValue = $this->getKey("Id_Novedad"); // Id_Novedad
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
		// Id_Novedad
		// Detalle
		// Archivos
		// Links
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Novedad
		$this->Id_Novedad->ViewValue = $this->Id_Novedad->CurrentValue;
		$this->Id_Novedad->ViewCustomAttributes = "";

		// Detalle
		$this->Detalle->ViewValue = $this->Detalle->CurrentValue;
		$this->Detalle->ViewCustomAttributes = "";

		// Archivos
		$this->Archivos->UploadPath = 'ArchivosNovedades';
		if (!ew_Empty($this->Archivos->Upload->DbValue)) {
			$this->Archivos->ImageAlt = $this->Archivos->FldAlt();
			$this->Archivos->ViewValue = $this->Archivos->Upload->DbValue;
		} else {
			$this->Archivos->ViewValue = "";
		}
		$this->Archivos->ViewCustomAttributes = "";

		// Links
		$this->Links->ViewValue = $this->Links->CurrentValue;
		$this->Links->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Detalle
			$this->Detalle->LinkCustomAttributes = "";
			$this->Detalle->HrefValue = "";
			$this->Detalle->TooltipValue = "";

			// Archivos
			$this->Archivos->LinkCustomAttributes = "";
			$this->Archivos->UploadPath = 'ArchivosNovedades';
			if (!ew_Empty($this->Archivos->Upload->DbValue)) {
				$this->Archivos->HrefValue = ew_GetFileUploadUrl($this->Archivos, $this->Archivos->Upload->DbValue); // Add prefix/suffix
				$this->Archivos->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos->HrefValue = ew_ConvertFullUrl($this->Archivos->HrefValue);
			} else {
				$this->Archivos->HrefValue = "";
			}
			$this->Archivos->HrefValue2 = $this->Archivos->UploadPath . $this->Archivos->Upload->DbValue;
			$this->Archivos->TooltipValue = "";
			if ($this->Archivos->UseColorbox) {
				if (ew_Empty($this->Archivos->TooltipValue))
					$this->Archivos->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Archivos->LinkAttrs["data-rel"] = "novedades_x_Archivos";
				ew_AppendClass($this->Archivos->LinkAttrs["class"], "ewLightbox");
			}

			// Links
			$this->Links->LinkCustomAttributes = "";
			if (!ew_Empty($this->Links->CurrentValue)) {
				$this->Links->HrefValue = "http://" . $this->Links->CurrentValue; // Add prefix/suffix
				$this->Links->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Links->HrefValue = ew_ConvertFullUrl($this->Links->HrefValue);
			} else {
				$this->Links->HrefValue = "";
			}
			$this->Links->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Detalle
			$this->Detalle->EditAttrs["class"] = "form-control";
			$this->Detalle->EditCustomAttributes = "";
			$this->Detalle->EditValue = ew_HtmlEncode($this->Detalle->CurrentValue);
			$this->Detalle->PlaceHolder = ew_RemoveHtml($this->Detalle->FldCaption());

			// Archivos
			$this->Archivos->EditAttrs["class"] = "form-control";
			$this->Archivos->EditCustomAttributes = "";
			$this->Archivos->UploadPath = 'ArchivosNovedades';
			if (!ew_Empty($this->Archivos->Upload->DbValue)) {
				$this->Archivos->ImageAlt = $this->Archivos->FldAlt();
				$this->Archivos->EditValue = $this->Archivos->Upload->DbValue;
			} else {
				$this->Archivos->EditValue = "";
			}
			if (!ew_Empty($this->Archivos->CurrentValue))
				$this->Archivos->Upload->FileName = $this->Archivos->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->Archivos);

			// Links
			$this->Links->EditAttrs["class"] = "form-control";
			$this->Links->EditCustomAttributes = "";
			$this->Links->EditValue = ew_HtmlEncode($this->Links->CurrentValue);
			$this->Links->PlaceHolder = ew_RemoveHtml($this->Links->FldCaption());

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Detalle

			$this->Detalle->LinkCustomAttributes = "";
			$this->Detalle->HrefValue = "";

			// Archivos
			$this->Archivos->LinkCustomAttributes = "";
			$this->Archivos->UploadPath = 'ArchivosNovedades';
			if (!ew_Empty($this->Archivos->Upload->DbValue)) {
				$this->Archivos->HrefValue = ew_GetFileUploadUrl($this->Archivos, $this->Archivos->Upload->DbValue); // Add prefix/suffix
				$this->Archivos->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos->HrefValue = ew_ConvertFullUrl($this->Archivos->HrefValue);
			} else {
				$this->Archivos->HrefValue = "";
			}
			$this->Archivos->HrefValue2 = $this->Archivos->UploadPath . $this->Archivos->Upload->DbValue;

			// Links
			$this->Links->LinkCustomAttributes = "";
			if (!ew_Empty($this->Links->CurrentValue)) {
				$this->Links->HrefValue = "http://" . $this->Links->CurrentValue; // Add prefix/suffix
				$this->Links->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Links->HrefValue = ew_ConvertFullUrl($this->Links->HrefValue);
			} else {
				$this->Links->HrefValue = "";
			}

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
			$this->Archivos->OldUploadPath = 'ArchivosNovedades';
			$this->Archivos->UploadPath = $this->Archivos->OldUploadPath;
		}
		$rsnew = array();

		// Detalle
		$this->Detalle->SetDbValueDef($rsnew, $this->Detalle->CurrentValue, NULL, FALSE);

		// Archivos
		if ($this->Archivos->Visible && !$this->Archivos->Upload->KeepFile) {
			$this->Archivos->Upload->DbValue = ""; // No need to delete old file
			if ($this->Archivos->Upload->FileName == "") {
				$rsnew['Archivos'] = NULL;
			} else {
				$rsnew['Archivos'] = $this->Archivos->Upload->FileName;
			}
			$this->Archivos->ImageWidth = 900; // Resize width
			$this->Archivos->ImageHeight = 230; // Resize height
		}

		// Links
		$this->Links->SetDbValueDef($rsnew, $this->Links->CurrentValue, NULL, FALSE);

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;
		if ($this->Archivos->Visible && !$this->Archivos->Upload->KeepFile) {
			$this->Archivos->UploadPath = 'ArchivosNovedades';
			if (!ew_Empty($this->Archivos->Upload->Value)) {
				if ($this->Archivos->Upload->FileName == $this->Archivos->Upload->DbValue) { // Overwrite if same file name
					$this->Archivos->Upload->DbValue = ""; // No need to delete any more
				} else {
					$rsnew['Archivos'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Archivos->UploadPath), $rsnew['Archivos']); // Get new file name
				}
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
				$this->Id_Novedad->setDbValue($conn->Insert_ID());
				$rsnew['Id_Novedad'] = $this->Id_Novedad->DbValue;
				if ($this->Archivos->Visible && !$this->Archivos->Upload->KeepFile) {
					if (!ew_Empty($this->Archivos->Upload->Value)) {
						$this->Archivos->Upload->Resize($this->Archivos->ImageWidth, $this->Archivos->ImageHeight);
						$this->Archivos->Upload->SaveToFile($this->Archivos->UploadPath, $rsnew['Archivos'], TRUE);
					}
					if ($this->Archivos->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->Archivos->OldUploadPath) . $this->Archivos->Upload->DbValue);
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

		// Archivos
		ew_CleanUploadTempPath($this->Archivos, $this->Archivos->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("novedadeslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
		$table = 'novedades';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'novedades';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Novedad'];

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
if (!isset($novedades_add)) $novedades_add = new cnovedades_add();

// Page init
$novedades_add->Page_Init();

// Page main
$novedades_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$novedades_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fnovedadesadd = new ew_Form("fnovedadesadd", "add");

// Validate form
fnovedadesadd.Validate = function() {
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
fnovedadesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnovedadesadd.ValidateRequired = true;
<?php } else { ?>
fnovedadesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$novedades_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $novedades_add->ShowPageHeader(); ?>
<?php
$novedades_add->ShowMessage();
?>
<form name="fnovedadesadd" id="fnovedadesadd" class="<?php echo $novedades_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($novedades_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $novedades_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="novedades">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($novedades_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($novedades->Detalle->Visible) { // Detalle ?>
	<div id="r_Detalle" class="form-group">
		<label id="elh_novedades_Detalle" for="x_Detalle" class="col-sm-2 control-label ewLabel"><?php echo $novedades->Detalle->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $novedades->Detalle->CellAttributes() ?>>
<span id="el_novedades_Detalle">
<textarea data-table="novedades" data-field="x_Detalle" name="x_Detalle" id="x_Detalle" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($novedades->Detalle->getPlaceHolder()) ?>"<?php echo $novedades->Detalle->EditAttributes() ?>><?php echo $novedades->Detalle->EditValue ?></textarea>
</span>
<?php echo $novedades->Detalle->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($novedades->Archivos->Visible) { // Archivos ?>
	<div id="r_Archivos" class="form-group">
		<label id="elh_novedades_Archivos" class="col-sm-2 control-label ewLabel"><?php echo $novedades->Archivos->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $novedades->Archivos->CellAttributes() ?>>
<span id="el_novedades_Archivos">
<div id="fd_x_Archivos">
<span title="<?php echo $novedades->Archivos->FldTitle() ? $novedades->Archivos->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($novedades->Archivos->ReadOnly || $novedades->Archivos->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="novedades" data-field="x_Archivos" name="x_Archivos" id="x_Archivos"<?php echo $novedades->Archivos->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Archivos" id= "fn_x_Archivos" value="<?php echo $novedades->Archivos->Upload->FileName ?>">
<input type="hidden" name="fa_x_Archivos" id= "fa_x_Archivos" value="0">
<input type="hidden" name="fs_x_Archivos" id= "fs_x_Archivos" value="65535">
<input type="hidden" name="fx_x_Archivos" id= "fx_x_Archivos" value="<?php echo $novedades->Archivos->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Archivos" id= "fm_x_Archivos" value="<?php echo $novedades->Archivos->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Archivos" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $novedades->Archivos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($novedades->Links->Visible) { // Links ?>
	<div id="r_Links" class="form-group">
		<label id="elh_novedades_Links" for="x_Links" class="col-sm-2 control-label ewLabel"><?php echo $novedades->Links->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $novedades->Links->CellAttributes() ?>>
<span id="el_novedades_Links">
<input type="text" data-table="novedades" data-field="x_Links" name="x_Links" id="x_Links" placeholder="<?php echo ew_HtmlEncode($novedades->Links->getPlaceHolder()) ?>" value="<?php echo $novedades->Links->EditValue ?>"<?php echo $novedades->Links->EditAttributes() ?>>
</span>
<?php echo $novedades->Links->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$novedades_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $novedades_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fnovedadesadd.Init();
</script>
<?php
$novedades_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$novedades_add->Page_Terminate();
?>
