<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "reasignacion_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$reasignacion_equipo_view = NULL; // Initialize page object first

class creasignacion_equipo_view extends creasignacion_equipo {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'reasignacion_equipo';

	// Page object name
	var $PageObjName = 'reasignacion_equipo_view';

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

		// Table object (reasignacion_equipo)
		if (!isset($GLOBALS["reasignacion_equipo"]) || get_class($GLOBALS["reasignacion_equipo"]) == "creasignacion_equipo") {
			$GLOBALS["reasignacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reasignacion_equipo"];
		}
		$KeyUrl = "";
		if (@$_GET["Id_Reasignacion"] <> "") {
			$this->RecKey["Id_Reasignacion"] = $_GET["Id_Reasignacion"];
			$KeyUrl .= "&amp;Id_Reasignacion=" . urlencode($this->RecKey["Id_Reasignacion"]);
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
			define("EW_TABLE_NAME", 'reasignacion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("reasignacion_equipolist.php"));
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
		if (@$_GET["Id_Reasignacion"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Id_Reasignacion"]);
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
		$this->Id_Reasignacion->SetVisibility();
		$this->Id_Reasignacion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Titular_Original->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Nuevo_Titular->SetVisibility();
		$this->Dni_Nuevo_Tit->SetVisibility();
		$this->Id_Motivo_Reasig->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Reasignacion->SetVisibility();
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
		global $EW_EXPORT, $reasignacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($reasignacion_equipo);
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
			if (@$_GET["Id_Reasignacion"] <> "") {
				$this->Id_Reasignacion->setQueryStringValue($_GET["Id_Reasignacion"]);
				$this->RecKey["Id_Reasignacion"] = $this->Id_Reasignacion->QueryStringValue;
			} elseif (@$_POST["Id_Reasignacion"] <> "") {
				$this->Id_Reasignacion->setFormValue($_POST["Id_Reasignacion"]);
				$this->RecKey["Id_Reasignacion"] = $this->Id_Reasignacion->FormValue;
			} else {
				$sReturnUrl = "reasignacion_equipolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "reasignacion_equipolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "reasignacion_equipolist.php"; // Not page request, return to list
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
		$this->Id_Reasignacion->setDbValue($rs->fields('Id_Reasignacion'));
		$this->Titular_Original->setDbValue($rs->fields('Titular_Original'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Nuevo_Titular->setDbValue($rs->fields('Nuevo_Titular'));
		$this->Dni_Nuevo_Tit->setDbValue($rs->fields('Dni_Nuevo_Tit'));
		$this->Id_Motivo_Reasig->setDbValue($rs->fields('Id_Motivo_Reasig'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Reasignacion->setDbValue($rs->fields('Fecha_Reasignacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Reasignacion->DbValue = $row['Id_Reasignacion'];
		$this->Titular_Original->DbValue = $row['Titular_Original'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Nuevo_Titular->DbValue = $row['Nuevo_Titular'];
		$this->Dni_Nuevo_Tit->DbValue = $row['Dni_Nuevo_Tit'];
		$this->Id_Motivo_Reasig->DbValue = $row['Id_Motivo_Reasig'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Reasignacion->DbValue = $row['Fecha_Reasignacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
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
		// Id_Reasignacion
		// Titular_Original
		// Dni
		// NroSerie
		// Nuevo_Titular
		// Dni_Nuevo_Tit
		// Id_Motivo_Reasig
		// Observacion
		// Fecha_Reasignacion
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Reasignacion
		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Titular_Original
		$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
		if (strval($this->Titular_Original->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Titular_Original->ViewValue = $this->Titular_Original->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
			}
		} else {
			$this->Titular_Original->ViewValue = NULL;
		}
		$this->Titular_Original->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
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

		// Nuevo_Titular
		$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
		if (strval($this->Nuevo_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`NroSerie`='0'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
			}
		} else {
			$this->Nuevo_Titular->ViewValue = NULL;
		}
		$this->Nuevo_Titular->ViewCustomAttributes = "";

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->ViewValue = $this->Dni_Nuevo_Tit->CurrentValue;
		$this->Dni_Nuevo_Tit->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		if (strval($this->Id_Motivo_Reasig->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
		$sWhereWrk = "";
		$this->Id_Motivo_Reasig->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Reasig->ViewValue = NULL;
		}
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewValue = ew_FormatDateTime($this->Fecha_Reasignacion->ViewValue, 7);
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Id_Reasignacion
			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";
			$this->Id_Reasignacion->TooltipValue = "";

			// Titular_Original
			$this->Titular_Original->LinkCustomAttributes = "";
			$this->Titular_Original->HrefValue = "";
			$this->Titular_Original->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Nuevo_Titular
			$this->Nuevo_Titular->LinkCustomAttributes = "";
			$this->Nuevo_Titular->HrefValue = "";
			$this->Nuevo_Titular->TooltipValue = "";

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->LinkCustomAttributes = "";
			$this->Dni_Nuevo_Tit->HrefValue = "";
			$this->Dni_Nuevo_Tit->TooltipValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
			$this->Id_Motivo_Reasig->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";
			$this->Fecha_Reasignacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_reasignacion_equipo\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_reasignacion_equipo',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.freasignacion_equipoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reasignacion_equipolist.php"), "", $this->TableVar, TRUE);
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
		$pages->Add(4);
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
		$table = 'reasignacion_equipo';
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
if (!isset($reasignacion_equipo_view)) $reasignacion_equipo_view = new creasignacion_equipo_view();

// Page init
$reasignacion_equipo_view->Page_Init();

// Page main
$reasignacion_equipo_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reasignacion_equipo_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = freasignacion_equipoview = new ew_Form("freasignacion_equipoview", "view");

// Form_CustomValidate event
freasignacion_equipoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freasignacion_equipoview.ValidateRequired = true;
<?php } else { ?>
freasignacion_equipoview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
freasignacion_equipoview.MultiPage = new ew_MultiPage("freasignacion_equipoview");

// Dynamic selection lists
freasignacion_equipoview.Lists["x_Titular_Original"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equipoview.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
freasignacion_equipoview.Lists["x_Nuevo_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equipoview.Lists["x_Id_Motivo_Reasig"] = {"LinkField":"x_Id_Motivo_Reasig","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_reasignacion"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$reasignacion_equipo_view->IsModal) { ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $reasignacion_equipo_view->ExportOptions->Render("body") ?>
<?php
	foreach ($reasignacion_equipo_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$reasignacion_equipo_view->IsModal) { ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reasignacion_equipo_view->ShowPageHeader(); ?>
<?php
$reasignacion_equipo_view->ShowMessage();
?>
<form name="freasignacion_equipoview" id="freasignacion_equipoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($reasignacion_equipo_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $reasignacion_equipo_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reasignacion_equipo">
<?php if ($reasignacion_equipo_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<div class="ewMultiPage">
<div class="panel-group" id="reasignacion_equipo_view">
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#reasignacion_equipo_view" href="#tab_reasignacion_equipo1"><?php echo $reasignacion_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("1") ?>" id="tab_reasignacion_equipo1">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($reasignacion_equipo->Id_Reasignacion->Visible) { // Id_Reasignacion ?>
	<tr id="r_Id_Reasignacion">
		<td><span id="elh_reasignacion_equipo_Id_Reasignacion"><?php echo $reasignacion_equipo->Id_Reasignacion->FldCaption() ?></span></td>
		<td data-name="Id_Reasignacion"<?php echo $reasignacion_equipo->Id_Reasignacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Id_Reasignacion" data-page="1">
<span<?php echo $reasignacion_equipo->Id_Reasignacion->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Id_Reasignacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Titular_Original->Visible) { // Titular_Original ?>
	<tr id="r_Titular_Original">
		<td><span id="elh_reasignacion_equipo_Titular_Original"><?php echo $reasignacion_equipo->Titular_Original->FldCaption() ?></span></td>
		<td data-name="Titular_Original"<?php echo $reasignacion_equipo->Titular_Original->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Titular_Original" data-page="1">
<span<?php echo $reasignacion_equipo->Titular_Original->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Titular_Original->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Dni->Visible) { // Dni ?>
	<tr id="r_Dni">
		<td><span id="elh_reasignacion_equipo_Dni"><?php echo $reasignacion_equipo->Dni->FldCaption() ?></span></td>
		<td data-name="Dni"<?php echo $reasignacion_equipo->Dni->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Dni" data-page="1">
<span<?php echo $reasignacion_equipo->Dni->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Dni->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Usuario->Visible) { // Usuario ?>
	<tr id="r_Usuario">
		<td><span id="elh_reasignacion_equipo_Usuario"><?php echo $reasignacion_equipo->Usuario->FldCaption() ?></span></td>
		<td data-name="Usuario"<?php echo $reasignacion_equipo->Usuario->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Usuario" data-page="1">
<span<?php echo $reasignacion_equipo->Usuario->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<tr id="r_Fecha_Actualizacion">
		<td><span id="elh_reasignacion_equipo_Fecha_Actualizacion"><?php echo $reasignacion_equipo->Fecha_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Actualizacion"<?php echo $reasignacion_equipo->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Fecha_Actualizacion" data-page="1">
<span<?php echo $reasignacion_equipo->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Fecha_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($reasignacion_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#reasignacion_equipo_view" href="#tab_reasignacion_equipo2"><?php echo $reasignacion_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("2") ?>" id="tab_reasignacion_equipo2">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($reasignacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<tr id="r_NroSerie">
		<td><span id="elh_reasignacion_equipo_NroSerie"><?php echo $reasignacion_equipo->NroSerie->FldCaption() ?></span></td>
		<td data-name="NroSerie"<?php echo $reasignacion_equipo->NroSerie->CellAttributes() ?>>
<span id="el_reasignacion_equipo_NroSerie" data-page="2">
<span<?php echo $reasignacion_equipo->NroSerie->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->NroSerie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($reasignacion_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#reasignacion_equipo_view" href="#tab_reasignacion_equipo3"><?php echo $reasignacion_equipo->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("3") ?>" id="tab_reasignacion_equipo3">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($reasignacion_equipo->Nuevo_Titular->Visible) { // Nuevo_Titular ?>
	<tr id="r_Nuevo_Titular">
		<td><span id="elh_reasignacion_equipo_Nuevo_Titular"><?php echo $reasignacion_equipo->Nuevo_Titular->FldCaption() ?></span></td>
		<td data-name="Nuevo_Titular"<?php echo $reasignacion_equipo->Nuevo_Titular->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Nuevo_Titular" data-page="3">
<span<?php echo $reasignacion_equipo->Nuevo_Titular->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Nuevo_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Dni_Nuevo_Tit->Visible) { // Dni_Nuevo_Tit ?>
	<tr id="r_Dni_Nuevo_Tit">
		<td><span id="elh_reasignacion_equipo_Dni_Nuevo_Tit"><?php echo $reasignacion_equipo->Dni_Nuevo_Tit->FldCaption() ?></span></td>
		<td data-name="Dni_Nuevo_Tit"<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Dni_Nuevo_Tit" data-page="3">
<span<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($reasignacion_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
	<div class="panel panel-default<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("4") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#reasignacion_equipo_view" href="#tab_reasignacion_equipo4"><?php echo $reasignacion_equipo->PageCaption(4) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $reasignacion_equipo_view->MultiPages->PageStyle("4") ?>" id="tab_reasignacion_equipo4">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($reasignacion_equipo->Id_Motivo_Reasig->Visible) { // Id_Motivo_Reasig ?>
	<tr id="r_Id_Motivo_Reasig">
		<td><span id="elh_reasignacion_equipo_Id_Motivo_Reasig"><?php echo $reasignacion_equipo->Id_Motivo_Reasig->FldCaption() ?></span></td>
		<td data-name="Id_Motivo_Reasig"<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Id_Motivo_Reasig" data-page="4">
<span<?php echo $reasignacion_equipo->Id_Motivo_Reasig->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Id_Motivo_Reasig->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Observacion->Visible) { // Observacion ?>
	<tr id="r_Observacion">
		<td><span id="elh_reasignacion_equipo_Observacion"><?php echo $reasignacion_equipo->Observacion->FldCaption() ?></span></td>
		<td data-name="Observacion"<?php echo $reasignacion_equipo->Observacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Observacion" data-page="4">
<span<?php echo $reasignacion_equipo->Observacion->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Observacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Reasignacion->Visible) { // Fecha_Reasignacion ?>
	<tr id="r_Fecha_Reasignacion">
		<td><span id="elh_reasignacion_equipo_Fecha_Reasignacion"><?php echo $reasignacion_equipo->Fecha_Reasignacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Reasignacion"<?php echo $reasignacion_equipo->Fecha_Reasignacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Fecha_Reasignacion" data-page="4">
<span<?php echo $reasignacion_equipo->Fecha_Reasignacion->ViewAttributes() ?>>
<?php echo $reasignacion_equipo->Fecha_Reasignacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($reasignacion_equipo->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<?php if ($reasignacion_equipo->Export == "") { ?>
<script type="text/javascript">
freasignacion_equipoview.Init();
</script>
<?php } ?>
<?php
$reasignacion_equipo_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($reasignacion_equipo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$reasignacion_equipo_view->Page_Terminate();
?>
