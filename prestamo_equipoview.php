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

$prestamo_equipo_view = NULL; // Initialize page object first

class cprestamo_equipo_view extends cprestamo_equipo {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'prestamo_equipo';

	// Page object name
	var $PageObjName = 'prestamo_equipo_view';

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
	var $AuditTrailOnAdd = FALSE;
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
		$KeyUrl = "";
		if (@$_GET["Id_Prestamo"] <> "") {
			$this->RecKey["Id_Prestamo"] = $_GET["Id_Prestamo"];
			$KeyUrl .= "&amp;Id_Prestamo=" . urlencode($this->RecKey["Id_Prestamo"]);
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
				$this->Page_Terminate(ew_GetUrl("prestamo_equipolist.php"));
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
		if (@$_GET["Id_Prestamo"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Id_Prestamo"]);
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
		$this->Id_Prestamo->SetVisibility();
		$this->Id_Prestamo->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
		$this->Id_Estado_Devol->SetVisibility();
		$this->Devuelve_Cargador->SetVisibility();

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
			if (@$_GET["Id_Prestamo"] <> "") {
				$this->Id_Prestamo->setQueryStringValue($_GET["Id_Prestamo"]);
				$this->RecKey["Id_Prestamo"] = $this->Id_Prestamo->QueryStringValue;
			} elseif (@$_POST["Id_Prestamo"] <> "") {
				$this->Id_Prestamo->setFormValue($_POST["Id_Prestamo"]);
				$this->RecKey["Id_Prestamo"] = $this->Id_Prestamo->FormValue;
			} else {
				$sReturnUrl = "prestamo_equipolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "prestamo_equipolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "prestamo_equipolist.php"; // Not page request, return to list
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

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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

			// Id_Prestamo
			$this->Id_Prestamo->LinkCustomAttributes = "";
			$this->Id_Prestamo->HrefValue = "";
			$this->Id_Prestamo->TooltipValue = "";

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

			// Id_Estado_Devol
			$this->Id_Estado_Devol->LinkCustomAttributes = "";
			$this->Id_Estado_Devol->HrefValue = "";
			$this->Id_Estado_Devol->TooltipValue = "";

			// Devuelve_Cargador
			$this->Devuelve_Cargador->LinkCustomAttributes = "";
			$this->Devuelve_Cargador->HrefValue = "";
			$this->Devuelve_Cargador->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_prestamo_equipo\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_prestamo_equipo',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fprestamo_equipoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("prestamo_equipolist.php"), "", $this->TableVar, TRUE);
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'prestamo_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
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
if (!isset($prestamo_equipo_view)) $prestamo_equipo_view = new cprestamo_equipo_view();

// Page init
$prestamo_equipo_view->Page_Init();

// Page main
$prestamo_equipo_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$prestamo_equipo_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($prestamo_equipo->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fprestamo_equipoview = new ew_Form("fprestamo_equipoview", "view");

// Form_CustomValidate event
fprestamo_equipoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprestamo_equipoview.ValidateRequired = true;
<?php } else { ?>
fprestamo_equipoview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fprestamo_equipoview.MultiPage = new ew_MultiPage("fprestamo_equipoview");

// Dynamic selection lists
fprestamo_equipoview.Lists["x_Apellidos_Nombres_Beneficiario"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"lista_espera_prestamo"};
fprestamo_equipoview.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fprestamo_equipoview.Lists["x_Id_Motivo_Prestamo"] = {"LinkField":"x_Id_Motivo_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_prestamo_equipo"};
fprestamo_equipoview.Lists["x_Prestamo_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprestamo_equipoview.Lists["x_Prestamo_Cargador"].Options = <?php echo json_encode($prestamo_equipo->Prestamo_Cargador->Options()) ?>;
fprestamo_equipoview.Lists["x_Id_Estado_Prestamo"] = {"LinkField":"x_Id_Estado_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_prestamo_equipo"};
fprestamo_equipoview.Lists["x_Id_Estado_Devol"] = {"LinkField":"x_Id_Estado_Devol","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_devolucion_prestamo"};
fprestamo_equipoview.Lists["x_Devuelve_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprestamo_equipoview.Lists["x_Devuelve_Cargador"].Options = <?php echo json_encode($prestamo_equipo->Devuelve_Cargador->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$prestamo_equipo_view->IsModal) { ?>
<?php if ($prestamo_equipo->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $prestamo_equipo_view->ExportOptions->Render("body") ?>
<?php
	foreach ($prestamo_equipo_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$prestamo_equipo_view->IsModal) { ?>
<?php if ($prestamo_equipo->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $prestamo_equipo_view->ShowPageHeader(); ?>
<?php
$prestamo_equipo_view->ShowMessage();
?>
<form name="fprestamo_equipoview" id="fprestamo_equipoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($prestamo_equipo_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $prestamo_equipo_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="prestamo_equipo">
<?php if ($prestamo_equipo_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
<div class="ewMultiPage">
<div class="panel-group" id="prestamo_equipo_view">
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $prestamo_equipo_view->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#prestamo_equipo_view" href="#tab_prestamo_equipo1"><?php echo $prestamo_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $prestamo_equipo_view->MultiPages->PageStyle("1") ?>" id="tab_prestamo_equipo1">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($prestamo_equipo->Id_Prestamo->Visible) { // Id_Prestamo ?>
	<tr id="r_Id_Prestamo">
		<td><span id="elh_prestamo_equipo_Id_Prestamo"><?php echo $prestamo_equipo->Id_Prestamo->FldCaption() ?></span></td>
		<td data-name="Id_Prestamo"<?php echo $prestamo_equipo->Id_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Prestamo" data-page="1">
<span<?php echo $prestamo_equipo->Id_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Prestamo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Apellidos_Nombres_Beneficiario->Visible) { // Apellidos_Nombres_Beneficiario ?>
	<tr id="r_Apellidos_Nombres_Beneficiario">
		<td><span id="elh_prestamo_equipo_Apellidos_Nombres_Beneficiario"><?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?></span></td>
		<td data-name="Apellidos_Nombres_Beneficiario"<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CellAttributes() ?>>
<span id="el_prestamo_equipo_Apellidos_Nombres_Beneficiario" data-page="1">
<span<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Dni->Visible) { // Dni ?>
	<tr id="r_Dni">
		<td><span id="elh_prestamo_equipo_Dni"><?php echo $prestamo_equipo->Dni->FldCaption() ?></span></td>
		<td data-name="Dni"<?php echo $prestamo_equipo->Dni->CellAttributes() ?>>
<span id="el_prestamo_equipo_Dni" data-page="1">
<span<?php echo $prestamo_equipo->Dni->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Dni->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->NroSerie->Visible) { // NroSerie ?>
	<tr id="r_NroSerie">
		<td><span id="elh_prestamo_equipo_NroSerie"><?php echo $prestamo_equipo->NroSerie->FldCaption() ?></span></td>
		<td data-name="NroSerie"<?php echo $prestamo_equipo->NroSerie->CellAttributes() ?>>
<span id="el_prestamo_equipo_NroSerie" data-page="1">
<span<?php echo $prestamo_equipo->NroSerie->ViewAttributes() ?>>
<?php echo $prestamo_equipo->NroSerie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Usuario->Visible) { // Usuario ?>
	<tr id="r_Usuario">
		<td><span id="elh_prestamo_equipo_Usuario"><?php echo $prestamo_equipo->Usuario->FldCaption() ?></span></td>
		<td data-name="Usuario"<?php echo $prestamo_equipo->Usuario->CellAttributes() ?>>
<span id="el_prestamo_equipo_Usuario" data-page="1">
<span<?php echo $prestamo_equipo->Usuario->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<tr id="r_Fecha_Actualizacion">
		<td><span id="elh_prestamo_equipo_Fecha_Actualizacion"><?php echo $prestamo_equipo->Fecha_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Actualizacion"<?php echo $prestamo_equipo->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_prestamo_equipo_Fecha_Actualizacion" data-page="1">
<span<?php echo $prestamo_equipo->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Fecha_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($prestamo_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $prestamo_equipo_view->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#prestamo_equipo_view" href="#tab_prestamo_equipo2"><?php echo $prestamo_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $prestamo_equipo_view->MultiPages->PageStyle("2") ?>" id="tab_prestamo_equipo2">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($prestamo_equipo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
	<tr id="r_Id_Motivo_Prestamo">
		<td><span id="elh_prestamo_equipo_Id_Motivo_Prestamo"><?php echo $prestamo_equipo->Id_Motivo_Prestamo->FldCaption() ?></span></td>
		<td data-name="Id_Motivo_Prestamo"<?php echo $prestamo_equipo->Id_Motivo_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Motivo_Prestamo" data-page="2">
<span<?php echo $prestamo_equipo->Id_Motivo_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Motivo_Prestamo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Fecha_Prestamo->Visible) { // Fecha_Prestamo ?>
	<tr id="r_Fecha_Prestamo">
		<td><span id="elh_prestamo_equipo_Fecha_Prestamo"><?php echo $prestamo_equipo->Fecha_Prestamo->FldCaption() ?></span></td>
		<td data-name="Fecha_Prestamo"<?php echo $prestamo_equipo->Fecha_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Fecha_Prestamo" data-page="2">
<span<?php echo $prestamo_equipo->Fecha_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Fecha_Prestamo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Observacion->Visible) { // Observacion ?>
	<tr id="r_Observacion">
		<td><span id="elh_prestamo_equipo_Observacion"><?php echo $prestamo_equipo->Observacion->FldCaption() ?></span></td>
		<td data-name="Observacion"<?php echo $prestamo_equipo->Observacion->CellAttributes() ?>>
<span id="el_prestamo_equipo_Observacion" data-page="2">
<span<?php echo $prestamo_equipo->Observacion->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Observacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Prestamo_Cargador->Visible) { // Prestamo_Cargador ?>
	<tr id="r_Prestamo_Cargador">
		<td><span id="elh_prestamo_equipo_Prestamo_Cargador"><?php echo $prestamo_equipo->Prestamo_Cargador->FldCaption() ?></span></td>
		<td data-name="Prestamo_Cargador"<?php echo $prestamo_equipo->Prestamo_Cargador->CellAttributes() ?>>
<span id="el_prestamo_equipo_Prestamo_Cargador" data-page="2">
<span<?php echo $prestamo_equipo->Prestamo_Cargador->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Prestamo_Cargador->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Prestamo->Visible) { // Id_Estado_Prestamo ?>
	<tr id="r_Id_Estado_Prestamo">
		<td><span id="elh_prestamo_equipo_Id_Estado_Prestamo"><?php echo $prestamo_equipo->Id_Estado_Prestamo->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Prestamo"<?php echo $prestamo_equipo->Id_Estado_Prestamo->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Estado_Prestamo" data-page="2">
<span<?php echo $prestamo_equipo->Id_Estado_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Prestamo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($prestamo_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $prestamo_equipo_view->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#prestamo_equipo_view" href="#tab_prestamo_equipo3"><?php echo $prestamo_equipo->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $prestamo_equipo_view->MultiPages->PageStyle("3") ?>" id="tab_prestamo_equipo3">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($prestamo_equipo->Id_Estado_Devol->Visible) { // Id_Estado_Devol ?>
	<tr id="r_Id_Estado_Devol">
		<td><span id="elh_prestamo_equipo_Id_Estado_Devol"><?php echo $prestamo_equipo->Id_Estado_Devol->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Devol"<?php echo $prestamo_equipo->Id_Estado_Devol->CellAttributes() ?>>
<span id="el_prestamo_equipo_Id_Estado_Devol" data-page="3">
<span<?php echo $prestamo_equipo->Id_Estado_Devol->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Devol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($prestamo_equipo->Devuelve_Cargador->Visible) { // Devuelve_Cargador ?>
	<tr id="r_Devuelve_Cargador">
		<td><span id="elh_prestamo_equipo_Devuelve_Cargador"><?php echo $prestamo_equipo->Devuelve_Cargador->FldCaption() ?></span></td>
		<td data-name="Devuelve_Cargador"<?php echo $prestamo_equipo->Devuelve_Cargador->CellAttributes() ?>>
<span id="el_prestamo_equipo_Devuelve_Cargador" data-page="3">
<span<?php echo $prestamo_equipo->Devuelve_Cargador->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Devuelve_Cargador->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($prestamo_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<div class="breadcrumb ewBreadcrumbs">
<a href="actas/Prestamo.php?IdPrestamo=<?php echo $prestamo_equipo->Id_Prestamo->ViewValue?>" class="Estilo1">Constancia de Prestamo</a>&nbsp;&nbsp; 
</div>
<div class="breadcrumb ewBreadcrumbs">
<a href="actas/Devolucion-Prestamo.php?IdPrestamo=<?php echo $prestamo_equipo->Id_Prestamo->ViewValue?>" class="Estilo1">Constancia Devolucion Prestamo</a></div>

<?php if ($prestamo_equipo->Export == "") { ?>
<script type="text/javascript">
fprestamo_equipoview.Init();
</script>
<?php } ?>
<?php
$prestamo_equipo_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($prestamo_equipo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$prestamo_equipo_view->Page_Terminate();
?>
