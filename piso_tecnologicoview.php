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

$piso_tecnologico_view = NULL; // Initialize page object first

class cpiso_tecnologico_view extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_view';

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

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
		}
		$KeyUrl = "";
		if (@$_GET["Cue"] <> "") {
			$this->RecKey["Cue"] = $_GET["Cue"];
			$KeyUrl .= "&amp;Cue=" . urlencode($this->RecKey["Cue"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("piso_tecnologicolist.php"));
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
		if (@$_GET["Cue"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Cue"]);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["Cue"] <> "") {
				$this->Cue->setQueryStringValue($_GET["Cue"]);
				$this->RecKey["Cue"] = $this->Cue->QueryStringValue;
			} elseif (@$_POST["Cue"] <> "") {
				$this->Cue->setFormValue($_POST["Cue"]);
				$this->RecKey["Cue"] = $this->Cue->FormValue;
			} else {
				$sReturnUrl = "piso_tecnologicolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "piso_tecnologicolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "piso_tecnologicolist.php"; // Not page request, return to list
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
		$item->Body = "<button id=\"emf_piso_tecnologico\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_piso_tecnologico',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpiso_tecnologicoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("piso_tecnologicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
		$table = 'piso_tecnologico';
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
if (!isset($piso_tecnologico_view)) $piso_tecnologico_view = new cpiso_tecnologico_view();

// Page init
$piso_tecnologico_view->Page_Init();

// Page main
$piso_tecnologico_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpiso_tecnologicoview = new ew_Form("fpiso_tecnologicoview", "view");

// Form_CustomValidate event
fpiso_tecnologicoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicoview.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicoview.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoview.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicoview.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoview.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoview.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicoview.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoview.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoview.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicoview.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$piso_tecnologico_view->IsModal) { ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $piso_tecnologico_view->ExportOptions->Render("body") ?>
<?php
	foreach ($piso_tecnologico_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$piso_tecnologico_view->IsModal) { ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $piso_tecnologico_view->ShowPageHeader(); ?>
<?php
$piso_tecnologico_view->ShowMessage();
?>
<form name="fpiso_tecnologicoview" id="fpiso_tecnologicoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<?php if ($piso_tecnologico_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<tr id="r_Switch">
		<td><span id="elh_piso_tecnologico_Switch"><?php echo $piso_tecnologico->Switch->FldCaption() ?></span></td>
		<td data-name="Switch"<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Switch" data-page="1">
<span<?php echo $piso_tecnologico->Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Switch->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
	<tr id="r_Bocas_Switch">
		<td><span id="elh_piso_tecnologico_Bocas_Switch"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></span></td>
		<td data-name="Bocas_Switch"<?php echo $piso_tecnologico->Bocas_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Bocas_Switch" data-page="1">
<span<?php echo $piso_tecnologico->Bocas_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Bocas_Switch->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<tr id="r_Estado_Switch">
		<td><span id="elh_piso_tecnologico_Estado_Switch"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></span></td>
		<td data-name="Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Switch" data-page="1">
<span<?php echo $piso_tecnologico->Estado_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<tr id="r_Cantidad_Ap">
		<td><span id="elh_piso_tecnologico_Cantidad_Ap"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></span></td>
		<td data-name="Cantidad_Ap"<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap" data-page="1">
<span<?php echo $piso_tecnologico->Cantidad_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
	<tr id="r_Cantidad_Ap_Func">
		<td><span id="elh_piso_tecnologico_Cantidad_Ap_Func"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></span></td>
		<td data-name="Cantidad_Ap_Func"<?php echo $piso_tecnologico->Cantidad_Ap_Func->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap_Func" data-page="1">
<span<?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<tr id="r_Ups">
		<td><span id="elh_piso_tecnologico_Ups"><?php echo $piso_tecnologico->Ups->FldCaption() ?></span></td>
		<td data-name="Ups"<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Ups" data-page="1">
<span<?php echo $piso_tecnologico->Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Ups->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<tr id="r_Estado_Ups">
		<td><span id="elh_piso_tecnologico_Estado_Ups"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></span></td>
		<td data-name="Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Ups" data-page="1">
<span<?php echo $piso_tecnologico->Estado_Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Marca_Modelo_Serie_Ups->Visible) { // Marca_Modelo_Serie_Ups ?>
	<tr id="r_Marca_Modelo_Serie_Ups">
		<td><span id="elh_piso_tecnologico_Marca_Modelo_Serie_Ups"><?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->FldCaption() ?></span></td>
		<td data-name="Marca_Modelo_Serie_Ups"<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Marca_Modelo_Serie_Ups" data-page="1">
<span<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<tr id="r_Cableado">
		<td><span id="elh_piso_tecnologico_Cableado"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></span></td>
		<td data-name="Cableado"<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cableado" data-page="1">
<span<?php echo $piso_tecnologico->Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cableado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<tr id="r_Estado_Cableado">
		<td><span id="elh_piso_tecnologico_Estado_Cableado"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></span></td>
		<td data-name="Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Cableado" data-page="1">
<span<?php echo $piso_tecnologico->Estado_Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<tr id="r_Porcent_Estado_Cab">
		<td><span id="elh_piso_tecnologico_Porcent_Estado_Cab"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></span></td>
		<td data-name="Porcent_Estado_Cab"<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Estado_Cab" data-page="1">
<span<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<tr id="r_Porcent_Func_Piso">
		<td><span id="elh_piso_tecnologico_Porcent_Func_Piso"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></span></td>
		<td data-name="Porcent_Func_Piso"<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Func_Piso" data-page="1">
<span<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<tr id="r_Plano_Escuela">
		<td><span id="elh_piso_tecnologico_Plano_Escuela"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></span></td>
		<td data-name="Plano_Escuela"<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<span id="el_piso_tecnologico_Plano_Escuela" data-page="1">
<span<?php echo $piso_tecnologico->Plano_Escuela->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($piso_tecnologico->Plano_Escuela, $piso_tecnologico->Plano_Escuela->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<tr id="r_Fecha_Actualizacion">
		<td><span id="elh_piso_tecnologico_Fecha_Actualizacion"><?php echo $piso_tecnologico->Fecha_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Actualizacion"<?php echo $piso_tecnologico->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_piso_tecnologico_Fecha_Actualizacion" data-page="1">
<span<?php echo $piso_tecnologico->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Fecha_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
	<tr id="r_Usuario">
		<td><span id="elh_piso_tecnologico_Usuario"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></span></td>
		<td data-name="Usuario"<?php echo $piso_tecnologico->Usuario->CellAttributes() ?>>
<span id="el_piso_tecnologico_Usuario" data-page="1">
<span<?php echo $piso_tecnologico->Usuario->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">
fpiso_tecnologicoview.Init();
</script>
<?php } ?>
<?php
$piso_tecnologico_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_view->Page_Terminate();
?>
