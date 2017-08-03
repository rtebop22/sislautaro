<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "titulares2Dequipos2Dtutoresinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$titulares2Dequipos2Dtutores_view = NULL; // Initialize page object first

class ctitulares2Dequipos2Dtutores_view extends ctitulares2Dequipos2Dtutores {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'titulares-equipos-tutores';

	// Page object name
	var $PageObjName = 'titulares2Dequipos2Dtutores_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (titulares2Dequipos2Dtutores)
		if (!isset($GLOBALS["titulares2Dequipos2Dtutores"]) || get_class($GLOBALS["titulares2Dequipos2Dtutores"]) == "ctitulares2Dequipos2Dtutores") {
			$GLOBALS["titulares2Dequipos2Dtutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["titulares2Dequipos2Dtutores"];
		}
		$KeyUrl = "";
		if (@$_GET["Dni"] <> "") {
			$this->RecKey["Dni"] = $_GET["Dni"];
			$KeyUrl .= "&amp;Dni=" . urlencode($this->RecKey["Dni"]);
		}
		if (@$_GET["Dni_Tutor"] <> "") {
			$this->RecKey["Dni_Tutor"] = $_GET["Dni_Tutor"];
			$KeyUrl .= "&amp;Dni_Tutor=" . urlencode($this->RecKey["Dni_Tutor"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'titulares-equipos-tutores', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("titulares2Dequipos2Dtutoreslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["Dni"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Dni"]);
		}
		if (@$_GET["Dni_Tutor"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Dni_Tutor"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
		$this->Apelldio_y_Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Equipo_Asignado->SetVisibility();
		$this->Apellido_y_Nombre_Tutor->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Cuil_Tutor->SetVisibility();

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
		global $EW_EXPORT, $titulares2Dequipos2Dtutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($titulares2Dequipos2Dtutores);
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["Dni"] <> "") {
				$this->Dni->setQueryStringValue($_GET["Dni"]);
				$this->RecKey["Dni"] = $this->Dni->QueryStringValue;
			} elseif (@$_POST["Dni"] <> "") {
				$this->Dni->setFormValue($_POST["Dni"]);
				$this->RecKey["Dni"] = $this->Dni->FormValue;
			} else {
				$sReturnUrl = "titulares2Dequipos2Dtutoreslist.php"; // Return to list
			}
			if (@$_GET["Dni_Tutor"] <> "") {
				$this->Dni_Tutor->setQueryStringValue($_GET["Dni_Tutor"]);
				$this->RecKey["Dni_Tutor"] = $this->Dni_Tutor->QueryStringValue;
			} elseif (@$_POST["Dni_Tutor"] <> "") {
				$this->Dni_Tutor->setFormValue($_POST["Dni_Tutor"]);
				$this->RecKey["Dni_Tutor"] = $this->Dni_Tutor->FormValue;
			} else {
				$sReturnUrl = "titulares2Dequipos2Dtutoreslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "titulares2Dequipos2Dtutoreslist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "titulares2Dequipos2Dtutoreslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->Apelldio_y_Nombre_Titular->setDbValue($rs->fields('Apelldio y Nombre Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Equipo_Asignado->setDbValue($rs->fields('Equipo Asignado'));
		$this->Apellido_y_Nombre_Tutor->setDbValue($rs->fields('Apellido y Nombre Tutor'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni Tutor'));
		$this->Cuil_Tutor->setDbValue($rs->fields('Cuil Tutor'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apelldio_y_Nombre_Titular->DbValue = $row['Apelldio y Nombre Titular'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->Equipo_Asignado->DbValue = $row['Equipo Asignado'];
		$this->Apellido_y_Nombre_Tutor->DbValue = $row['Apellido y Nombre Tutor'];
		$this->Dni_Tutor->DbValue = $row['Dni Tutor'];
		$this->Cuil_Tutor->DbValue = $row['Cuil Tutor'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Apelldio y Nombre Titular
		// Dni
		// Cuil
		// Equipo Asignado
		// Apellido y Nombre Tutor
		// Dni Tutor
		// Cuil Tutor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->ViewValue = $this->Apelldio_y_Nombre_Titular->CurrentValue;
		$this->Apelldio_y_Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Equipo Asignado
		$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
		if (strval($this->Equipo_Asignado->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Equipo_Asignado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
			}
		} else {
			$this->Equipo_Asignado->ViewValue = NULL;
		}
		$this->Equipo_Asignado->ViewCustomAttributes = "";

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->ViewValue = $this->Apellido_y_Nombre_Tutor->CurrentValue;
		$this->Apellido_y_Nombre_Tutor->ViewCustomAttributes = "";

		// Dni Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Cuil Tutor
		$this->Cuil_Tutor->ViewValue = $this->Cuil_Tutor->CurrentValue;
		$this->Cuil_Tutor->ViewCustomAttributes = "";

			// Apelldio y Nombre Titular
			$this->Apelldio_y_Nombre_Titular->LinkCustomAttributes = "";
			$this->Apelldio_y_Nombre_Titular->HrefValue = "";
			$this->Apelldio_y_Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Equipo Asignado
			$this->Equipo_Asignado->LinkCustomAttributes = "";
			$this->Equipo_Asignado->HrefValue = "";
			$this->Equipo_Asignado->TooltipValue = "";

			// Apellido y Nombre Tutor
			$this->Apellido_y_Nombre_Tutor->LinkCustomAttributes = "";
			$this->Apellido_y_Nombre_Tutor->HrefValue = "";
			$this->Apellido_y_Nombre_Tutor->TooltipValue = "";

			// Dni Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Cuil Tutor
			$this->Cuil_Tutor->LinkCustomAttributes = "";
			$this->Cuil_Tutor->HrefValue = "";
			$this->Cuil_Tutor->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_titulares2Dequipos2Dtutores\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_titulares2Dequipos2Dtutores',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftitulares2Dequipos2Dtutoresview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("titulares2Dequipos2Dtutoreslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($titulares2Dequipos2Dtutores_view)) $titulares2Dequipos2Dtutores_view = new ctitulares2Dequipos2Dtutores_view();

// Page init
$titulares2Dequipos2Dtutores_view->Page_Init();

// Page main
$titulares2Dequipos2Dtutores_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$titulares2Dequipos2Dtutores_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ftitulares2Dequipos2Dtutoresview = new ew_Form("ftitulares2Dequipos2Dtutoresview", "view");

// Form_CustomValidate event
ftitulares2Dequipos2Dtutoresview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftitulares2Dequipos2Dtutoresview.ValidateRequired = true;
<?php } else { ?>
ftitulares2Dequipos2Dtutoresview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
ftitulares2Dequipos2Dtutoresview.MultiPage = new ew_MultiPage("ftitulares2Dequipos2Dtutoresview");

// Dynamic selection lists
ftitulares2Dequipos2Dtutoresview.Lists["x_Equipo_Asignado"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$titulares2Dequipos2Dtutores_view->IsModal) { ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $titulares2Dequipos2Dtutores_view->ExportOptions->Render("body") ?>
<?php
	foreach ($titulares2Dequipos2Dtutores_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$titulares2Dequipos2Dtutores_view->IsModal) { ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $titulares2Dequipos2Dtutores_view->ShowPageHeader(); ?>
<?php
$titulares2Dequipos2Dtutores_view->ShowMessage();
?>
<form name="ftitulares2Dequipos2Dtutoresview" id="ftitulares2Dequipos2Dtutoresview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($titulares2Dequipos2Dtutores_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $titulares2Dequipos2Dtutores_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="titulares2Dequipos2Dtutores">
<?php if ($titulares2Dequipos2Dtutores_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<div class="ewMultiPage">
<div class="panel-group" id="titulares2Dequipos2Dtutores_view">
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
	<div class="panel panel-default<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#titulares2Dequipos2Dtutores_view" href="#tab_titulares2Dequipos2Dtutores1"><?php echo $titulares2Dequipos2Dtutores->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("1") ?>" id="tab_titulares2Dequipos2Dtutores1">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->Visible) { // Apelldio y Nombre Titular ?>
	<tr id="r_Apelldio_y_Nombre_Titular">
		<td><span id="elh_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular"><?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->FldCaption() ?></span></td>
		<td data-name="Apelldio_y_Nombre_Titular"<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular" data-page="1">
<span<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Dni->Visible) { // Dni ?>
	<tr id="r_Dni">
		<td><span id="elh_titulares2Dequipos2Dtutores_Dni"><?php echo $titulares2Dequipos2Dtutores->Dni->FldCaption() ?></span></td>
		<td data-name="Dni"<?php echo $titulares2Dequipos2Dtutores->Dni->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Dni" data-page="1">
<span<?php echo $titulares2Dequipos2Dtutores->Dni->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Dni->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Cuil->Visible) { // Cuil ?>
	<tr id="r_Cuil">
		<td><span id="elh_titulares2Dequipos2Dtutores_Cuil"><?php echo $titulares2Dequipos2Dtutores->Cuil->FldCaption() ?></span></td>
		<td data-name="Cuil"<?php echo $titulares2Dequipos2Dtutores->Cuil->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Cuil" data-page="1">
<span<?php echo $titulares2Dequipos2Dtutores->Cuil->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Cuil->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
	<div class="panel panel-default<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#titulares2Dequipos2Dtutores_view" href="#tab_titulares2Dequipos2Dtutores2"><?php echo $titulares2Dequipos2Dtutores->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("2") ?>" id="tab_titulares2Dequipos2Dtutores2">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($titulares2Dequipos2Dtutores->Equipo_Asignado->Visible) { // Equipo Asignado ?>
	<tr id="r_Equipo_Asignado">
		<td><span id="elh_titulares2Dequipos2Dtutores_Equipo_Asignado"><?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->FldCaption() ?></span></td>
		<td data-name="Equipo_Asignado"<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Equipo_Asignado" data-page="2">
<span<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
	<div class="panel panel-default<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#titulares2Dequipos2Dtutores_view" href="#tab_titulares2Dequipos2Dtutores3"><?php echo $titulares2Dequipos2Dtutores->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $titulares2Dequipos2Dtutores_view->MultiPages->PageStyle("3") ?>" id="tab_titulares2Dequipos2Dtutores3">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->Visible) { // Apellido y Nombre Tutor ?>
	<tr id="r_Apellido_y_Nombre_Tutor">
		<td><span id="elh_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor"><?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->FldCaption() ?></span></td>
		<td data-name="Apellido_y_Nombre_Tutor"<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor" data-page="3">
<span<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Dni_Tutor->Visible) { // Dni Tutor ?>
	<tr id="r_Dni_Tutor">
		<td><span id="elh_titulares2Dequipos2Dtutores_Dni_Tutor"><?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->FldCaption() ?></span></td>
		<td data-name="Dni_Tutor"<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Dni_Tutor" data-page="3">
<span<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Cuil_Tutor->Visible) { // Cuil Tutor ?>
	<tr id="r_Cuil_Tutor">
		<td><span id="elh_titulares2Dequipos2Dtutores_Cuil_Tutor"><?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->FldCaption() ?></span></td>
		<td data-name="Cuil_Tutor"<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->CellAttributes() ?>>
<span id="el_titulares2Dequipos2Dtutores_Cuil_Tutor" data-page="3">
<span<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">
ftitulares2Dequipos2Dtutoresview.Init();
</script>
<?php } ?>
<?php
$titulares2Dequipos2Dtutores_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$titulares2Dequipos2Dtutores_view->Page_Terminate();
?>
