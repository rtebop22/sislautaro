<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "detalle_atenciongridcls.php" ?>
<?php include_once "atencion_para_stgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$atencion_equipos_list = NULL; // Initialize page object first

class catencion_equipos_list extends catencion_equipos {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'atencion_equipos';

	// Page object name
	var $PageObjName = 'atencion_equipos_list';

	// Grid form hidden field names
	var $FormName = 'fatencion_equiposlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (atencion_equipos)
		if (!isset($GLOBALS["atencion_equipos"]) || get_class($GLOBALS["atencion_equipos"]) == "catencion_equipos") {
			$GLOBALS["atencion_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["atencion_equipos"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "atencion_equiposadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "atencion_equiposdelete.php";
		$this->MultiUpdateUrl = "atencion_equiposupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'atencion_equipos', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fatencion_equiposlistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Create form object
		$objForm = new cFormObj();

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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->Id_Atencion->SetVisibility();
		$this->Id_Atencion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Fecha_Entrada->SetVisibility();
		$this->Id_Prioridad->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Usuario->Visible = !$this->IsAddOrEdit();

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

			// Process auto fill for detail table 'detalle_atencion'
			if (@$_POST["grid"] == "fdetalle_atenciongrid") {
				if (!isset($GLOBALS["detalle_atencion_grid"])) $GLOBALS["detalle_atencion_grid"] = new cdetalle_atencion_grid;
				$GLOBALS["detalle_atencion_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'atencion_para_st'
			if (@$_POST["grid"] == "fatencion_para_stgrid") {
				if (!isset($GLOBALS["atencion_para_st_grid"])) $GLOBALS["atencion_para_st_grid"] = new catencion_para_st_grid;
				$GLOBALS["atencion_para_st_grid"]->Page_Init();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $atencion_equipos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($atencion_equipos);
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
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $detalle_atencion_Count;
	var $atencion_para_st_Count;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export selected records
		if ($this->Export <> "")
			$this->CurrentFilter = $this->BuildExportSelectedFilter();

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->Id_Atencion->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Atencion->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->Id_Atencion->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Dni") && $objForm->HasValue("o_Dni") && $this->Dni->CurrentValue <> $this->Dni->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NroSerie") && $objForm->HasValue("o_NroSerie") && $this->NroSerie->CurrentValue <> $this->NroSerie->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Fecha_Entrada") && $objForm->HasValue("o_Fecha_Entrada") && $this->Fecha_Entrada->CurrentValue <> $this->Fecha_Entrada->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Prioridad") && $objForm->HasValue("o_Id_Prioridad") && $this->Id_Prioridad->CurrentValue <> $this->Id_Prioridad->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fatencion_equiposlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Id_Atencion->AdvancedSearch->ToJSON(), ","); // Field Id_Atencion
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
		$sFilterList = ew_Concat($sFilterList, $this->NroSerie->AdvancedSearch->ToJSON(), ","); // Field NroSerie
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Entrada->AdvancedSearch->ToJSON(), ","); // Field Fecha_Entrada
		$sFilterList = ew_Concat($sFilterList, $this->Id_Prioridad->AdvancedSearch->ToJSON(), ","); // Field Id_Prioridad
		$sFilterList = ew_Concat($sFilterList, $this->Usuario->AdvancedSearch->ToJSON(), ","); // Field Usuario
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["cmd"] == "savefilters") {
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fatencion_equiposlistsrch", $filters);
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field Id_Atencion
		$this->Id_Atencion->AdvancedSearch->SearchValue = @$filter["x_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchOperator = @$filter["z_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchCondition = @$filter["v_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->Save();

		// Field Dni
		$this->Dni->AdvancedSearch->SearchValue = @$filter["x_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator = @$filter["z_Dni"];
		$this->Dni->AdvancedSearch->SearchCondition = @$filter["v_Dni"];
		$this->Dni->AdvancedSearch->SearchValue2 = @$filter["y_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator2 = @$filter["w_Dni"];
		$this->Dni->AdvancedSearch->Save();

		// Field NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = @$filter["x_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator = @$filter["z_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchCondition = @$filter["v_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchValue2 = @$filter["y_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator2 = @$filter["w_NroSerie"];
		$this->NroSerie->AdvancedSearch->Save();

		// Field Fecha_Entrada
		$this->Fecha_Entrada->AdvancedSearch->SearchValue = @$filter["x_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->Save();

		// Field Id_Prioridad
		$this->Id_Prioridad->AdvancedSearch->SearchValue = @$filter["x_Id_Prioridad"];
		$this->Id_Prioridad->AdvancedSearch->SearchOperator = @$filter["z_Id_Prioridad"];
		$this->Id_Prioridad->AdvancedSearch->SearchCondition = @$filter["v_Id_Prioridad"];
		$this->Id_Prioridad->AdvancedSearch->SearchValue2 = @$filter["y_Id_Prioridad"];
		$this->Id_Prioridad->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Prioridad"];
		$this->Id_Prioridad->AdvancedSearch->Save();

		// Field Usuario
		$this->Usuario->AdvancedSearch->SearchValue = @$filter["x_Usuario"];
		$this->Usuario->AdvancedSearch->SearchOperator = @$filter["z_Usuario"];
		$this->Usuario->AdvancedSearch->SearchCondition = @$filter["v_Usuario"];
		$this->Usuario->AdvancedSearch->SearchValue2 = @$filter["y_Usuario"];
		$this->Usuario->AdvancedSearch->SearchOperator2 = @$filter["w_Usuario"];
		$this->Usuario->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->Id_Atencion, $Default, FALSE); // Id_Atencion
		$this->BuildSearchSql($sWhere, $this->Dni, $Default, FALSE); // Dni
		$this->BuildSearchSql($sWhere, $this->NroSerie, $Default, FALSE); // NroSerie
		$this->BuildSearchSql($sWhere, $this->Fecha_Entrada, $Default, FALSE); // Fecha_Entrada
		$this->BuildSearchSql($sWhere, $this->Id_Prioridad, $Default, FALSE); // Id_Prioridad
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Id_Atencion->AdvancedSearch->Save(); // Id_Atencion
			$this->Dni->AdvancedSearch->Save(); // Dni
			$this->NroSerie->AdvancedSearch->Save(); // NroSerie
			$this->Fecha_Entrada->AdvancedSearch->Save(); // Fecha_Entrada
			$this->Id_Prioridad->AdvancedSearch->Save(); // Id_Prioridad
			$this->Usuario->AdvancedSearch->Save(); // Usuario
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Atencion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NroSerie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Prioridad, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->Id_Atencion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NroSerie->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Entrada->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Prioridad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Usuario->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Id_Atencion->AdvancedSearch->UnsetSession();
		$this->Dni->AdvancedSearch->UnsetSession();
		$this->NroSerie->AdvancedSearch->UnsetSession();
		$this->Fecha_Entrada->AdvancedSearch->UnsetSession();
		$this->Id_Prioridad->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Atencion->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Fecha_Entrada->AdvancedSearch->Load();
		$this->Id_Prioridad->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Atencion); // Id_Atencion
			$this->UpdateSort($this->Dni); // Dni
			$this->UpdateSort($this->NroSerie); // NroSerie
			$this->UpdateSort($this->Fecha_Entrada); // Fecha_Entrada
			$this->UpdateSort($this->Id_Prioridad); // Id_Prioridad
			$this->UpdateSort($this->Usuario); // Usuario
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Id_Atencion->setSort("");
				$this->Dni->setSort("");
				$this->NroSerie->setSort("");
				$this->Fecha_Entrada->setSort("");
				$this->Id_Prioridad->setSort("");
				$this->Usuario->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "detail_detalle_atencion"
		$item = &$this->ListOptions->Add("detail_detalle_atencion");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["detalle_atencion_grid"])) $GLOBALS["detalle_atencion_grid"] = new cdetalle_atencion_grid;

		// "detail_atencion_para_st"
		$item = &$this->ListOptions->Add("detail_atencion_para_st");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["atencion_para_st_grid"])) $GLOBALS["atencion_para_st_grid"] = new catencion_para_st_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("detalle_atencion");
		$pages->Add("atencion_para_st");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->IsLoggedIn()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"atencion_equipos\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->IsLoggedIn()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-table=\"atencion_equipos\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_detalle_atencion"
		$oListOpt = &$this->ListOptions->Items["detail_detalle_atencion"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("detalle_atencion", "TblCaption");
			$body .= str_replace("%c", $this->detalle_atencion_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("detalle_atencionlist.php?" . EW_TABLE_SHOW_MASTER . "=atencion_equipos&fk_Id_Atencion=" . urlencode(strval($this->Id_Atencion->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["detalle_atencion_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=detalle_atencion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "detalle_atencion";
			}
			if ($GLOBALS["detalle_atencion_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=detalle_atencion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "detalle_atencion";
			}
			if ($GLOBALS["detalle_atencion_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=detalle_atencion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "detalle_atencion";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_atencion_para_st"
		$oListOpt = &$this->ListOptions->Items["detail_atencion_para_st"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("atencion_para_st", "TblCaption");
			$body .= str_replace("%c", $this->atencion_para_st_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("atencion_para_stlist.php?" . EW_TABLE_SHOW_MASTER . "=atencion_equipos&fk_Id_Atencion=" . urlencode(strval($this->Id_Atencion->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["atencion_para_st_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=atencion_para_st")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "atencion_para_st";
			}
			if ($GLOBALS["atencion_para_st_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=atencion_para_st")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "atencion_para_st";
			}
			if ($GLOBALS["atencion_para_st_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=atencion_para_st")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "atencion_para_st";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Atencion->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Id_Atencion->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		if (ew_IsMobile())
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-table=\"atencion_equipos\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->IsLoggedIn());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_detalle_atencion");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=detalle_atencion");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["detalle_atencion"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["detalle_atencion"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "detalle_atencion";
		}
		$item = &$option->Add("detailadd_atencion_para_st");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=atencion_para_st");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["atencion_para_st"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["atencion_para_st"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "atencion_para_st";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->IsLoggedIn());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fatencion_equiposlist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"atencion_equipos\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fatencion_equiposlist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fatencion_equiposlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fatencion_equiposlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fatencion_equiposlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fatencion_equiposlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"atencion_equipossrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Atencion->CurrentValue = NULL;
		$this->Id_Atencion->OldValue = $this->Id_Atencion->CurrentValue;
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Fecha_Entrada->CurrentValue = NULL;
		$this->Fecha_Entrada->OldValue = $this->Fecha_Entrada->CurrentValue;
		$this->Id_Prioridad->CurrentValue = NULL;
		$this->Id_Prioridad->OldValue = $this->Id_Prioridad->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Id_Atencion

		$this->Id_Atencion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Atencion"]);
		if ($this->Id_Atencion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Atencion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Atencion"];

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni"]);
		if ($this->Dni->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni->AdvancedSearch->SearchOperator = @$_GET["z_Dni"];

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroSerie"]);
		if ($this->NroSerie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroSerie->AdvancedSearch->SearchOperator = @$_GET["z_NroSerie"];

		// Fecha_Entrada
		$this->Fecha_Entrada->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Entrada"]);
		if ($this->Fecha_Entrada->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Entrada"];

		// Id_Prioridad
		$this->Id_Prioridad->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Prioridad"]);
		if ($this->Id_Prioridad->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Prioridad->AdvancedSearch->SearchOperator = @$_GET["z_Id_Prioridad"];

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Usuario"]);
		if ($this->Usuario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Usuario->AdvancedSearch->SearchOperator = @$_GET["z_Usuario"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Atencion->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Atencion->setFormValue($objForm->GetValue("x_Id_Atencion"));
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->setOldValue($objForm->GetValue("o_Dni"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->setOldValue($objForm->GetValue("o_NroSerie"));
		if (!$this->Fecha_Entrada->FldIsDetailKey) {
			$this->Fecha_Entrada->setFormValue($objForm->GetValue("x_Fecha_Entrada"));
			$this->Fecha_Entrada->CurrentValue = ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7);
		}
		$this->Fecha_Entrada->setOldValue($objForm->GetValue("o_Fecha_Entrada"));
		if (!$this->Id_Prioridad->FldIsDetailKey) {
			$this->Id_Prioridad->setFormValue($objForm->GetValue("x_Id_Prioridad"));
		}
		$this->Id_Prioridad->setOldValue($objForm->GetValue("o_Id_Prioridad"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Atencion->CurrentValue = $this->Id_Atencion->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Fecha_Entrada->CurrentValue = $this->Fecha_Entrada->FormValue;
		$this->Fecha_Entrada->CurrentValue = ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7);
		$this->Id_Prioridad->CurrentValue = $this->Id_Prioridad->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
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
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha_Entrada'));
		$this->Id_Prioridad->setDbValue($rs->fields('Id_Prioridad'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		if (!isset($GLOBALS["detalle_atencion_grid"])) $GLOBALS["detalle_atencion_grid"] = new cdetalle_atencion_grid;
		$sDetailFilter = $GLOBALS["detalle_atencion"]->SqlDetailFilter_atencion_equipos();
		$sDetailFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["detalle_atencion"]->setCurrentMasterTable("atencion_equipos");
		$sDetailFilter = $GLOBALS["detalle_atencion"]->ApplyUserIDFilters($sDetailFilter);
		$this->detalle_atencion_Count = $GLOBALS["detalle_atencion"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["atencion_para_st_grid"])) $GLOBALS["atencion_para_st_grid"] = new catencion_para_st_grid;
		$sDetailFilter = $GLOBALS["atencion_para_st"]->SqlDetailFilter_atencion_equipos();
		$sDetailFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["atencion_para_st"]->setCurrentMasterTable("atencion_equipos");
		$sDetailFilter = $GLOBALS["atencion_para_st"]->ApplyUserIDFilters($sDetailFilter);
		$this->atencion_para_st_Count = $GLOBALS["atencion_para_st"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Atencion->DbValue = $row['Id_Atencion'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Fecha_Entrada->DbValue = $row['Fecha_Entrada'];
		$this->Id_Prioridad->DbValue = $row['Id_Prioridad'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Atencion")) <> "")
			$this->Id_Atencion->CurrentValue = $this->getKey("Id_Atencion"); // Id_Atencion
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Atencion
		// Dni
		// NroSerie
		// Fecha_Entrada
		// Id_Prioridad
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

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

		// Fecha_Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 7);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Id_Prioridad
		if (strval($this->Id_Prioridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Prioridad`" . ew_SearchString("=", $this->Id_Prioridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Prioridad`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_prioridad_atencion`";
		$sWhereWrk = "";
		$this->Id_Prioridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Prioridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Prioridad->ViewValue = $this->Id_Prioridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Prioridad->ViewValue = $this->Id_Prioridad->CurrentValue;
			}
		} else {
			$this->Id_Prioridad->ViewValue = NULL;
		}
		$this->Id_Prioridad->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Id_Atencion
			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";
			$this->Id_Atencion->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Id_Prioridad
			$this->Id_Prioridad->LinkCustomAttributes = "";
			$this->Id_Prioridad->HrefValue = "";
			$this->Id_Prioridad->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Atencion
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
			$this->NroSerie->EditCustomAttributes = "";
			if (trim(strval($this->NroSerie->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
			} else {
				$this->NroSerie->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->NroSerie->EditValue = $arwrk;

			// Fecha_Entrada
			$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
			$this->Fecha_Entrada->EditCustomAttributes = "";
			$this->Fecha_Entrada->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 7));
			$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

			// Id_Prioridad
			$this->Id_Prioridad->EditAttrs["class"] = "form-control";
			$this->Id_Prioridad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Prioridad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Prioridad`" . ew_SearchString("=", $this->Id_Prioridad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Prioridad`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_prioridad_atencion`";
			$sWhereWrk = "";
			$this->Id_Prioridad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Prioridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Prioridad->EditValue = $arwrk;

			// Usuario
			// Add refer script
			// Id_Atencion

			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";

			// Id_Prioridad
			$this->Id_Prioridad->LinkCustomAttributes = "";
			$this->Id_Prioridad->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Atencion
			$this->Id_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Atencion->EditCustomAttributes = "";
			$this->Id_Atencion->EditValue = $this->Id_Atencion->CurrentValue;
			$this->Id_Atencion->ViewCustomAttributes = "";

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
			$this->NroSerie->EditCustomAttributes = "";
			if (trim(strval($this->NroSerie->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
			} else {
				$this->NroSerie->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->NroSerie->EditValue = $arwrk;

			// Fecha_Entrada
			$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
			$this->Fecha_Entrada->EditCustomAttributes = "";
			$this->Fecha_Entrada->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Entrada->CurrentValue, 7));
			$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

			// Id_Prioridad
			$this->Id_Prioridad->EditAttrs["class"] = "form-control";
			$this->Id_Prioridad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Prioridad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Prioridad`" . ew_SearchString("=", $this->Id_Prioridad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Prioridad`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_prioridad_atencion`";
			$sWhereWrk = "";
			$this->Id_Prioridad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Prioridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Prioridad->EditValue = $arwrk;

			// Usuario
			// Edit refer script
			// Id_Atencion

			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Fecha_Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";

			// Id_Prioridad
			$this->Id_Prioridad->LinkCustomAttributes = "";
			$this->Id_Prioridad->HrefValue = "";

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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
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
		if (!ew_CheckEuroDate($this->Fecha_Entrada->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Entrada->FldErrMsg());
		}
		if (!$this->Id_Prioridad->FldIsDetailKey && !is_null($this->Id_Prioridad->FormValue) && $this->Id_Prioridad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Prioridad->FldCaption(), $this->Id_Prioridad->ReqErrMsg));
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Atencion'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, $this->Dni->ReadOnly);

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly);

			// Fecha_Entrada
			$this->Fecha_Entrada->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7), NULL, $this->Fecha_Entrada->ReadOnly);

			// Id_Prioridad
			$this->Id_Prioridad->SetDbValueDef($rsnew, $this->Id_Prioridad->CurrentValue, 0, $this->Id_Prioridad->ReadOnly);

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Fecha_Entrada
		$this->Fecha_Entrada->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Entrada->CurrentValue, 7), NULL, FALSE);

		// Id_Prioridad
		$this->Id_Prioridad->SetDbValueDef($rsnew, $this->Id_Prioridad->CurrentValue, 0, FALSE);

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Id_Atencion->setDbValue($conn->Insert_ID());
				$rsnew['Id_Atencion'] = $this->Id_Atencion->DbValue;
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
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Atencion->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Fecha_Entrada->AdvancedSearch->Load();
		$this->Id_Prioridad->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Build export filter for selected records
	function BuildExportSelectedFilter() {
		global $Language;
		$sWrkFilter = "";
		if ($this->Export <> "") {
			$sWrkFilter = $this->GetKeyFilter();
		}
		return $sWrkFilter;
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fatencion_equiposlist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_atencion_equipos\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_atencion_equipos',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fatencion_equiposlist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

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
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

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

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
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
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";
		if (isset($_GET["key_m"])) {
			$nKeys = count($_GET["key_m"]);
			foreach ($_GET["key_m"] as $key)
				$sQry .= "&key_m[]=" . $key;
		}
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
		case "x_Id_Prioridad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Prioridad` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_prioridad_atencion`";
			$sWhereWrk = "";
			$this->Id_Prioridad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Prioridad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Prioridad, $sWhereWrk); // Call Lookup selecting
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
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'atencion_equipos';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'atencion_equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
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

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'atencion_equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Id_Atencion'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
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

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'atencion_equipos';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($atencion_equipos_list)) $atencion_equipos_list = new catencion_equipos_list();

// Page init
$atencion_equipos_list->Page_Init();

// Page main
$atencion_equipos_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_equipos_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($atencion_equipos->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fatencion_equiposlist = new ew_Form("fatencion_equiposlist", "list");
fatencion_equiposlist.FormKeyCountName = '<?php echo $atencion_equipos_list->FormKeyCountName ?>';

// Validate form
fatencion_equiposlist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_equipos->Dni->FldCaption(), $atencion_equipos->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_equipos->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_equipos->NroSerie->FldCaption(), $atencion_equipos->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Entrada");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_equipos->Fecha_Entrada->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Prioridad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_equipos->Id_Prioridad->FldCaption(), $atencion_equipos->Id_Prioridad->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fatencion_equiposlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Dni", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Entrada", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Prioridad", false)) return false;
	return true;
}

// Form_CustomValidate event
fatencion_equiposlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_equiposlist.ValidateRequired = true;
<?php } else { ?>
fatencion_equiposlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_equiposlist.Lists["x_Dni"] = {"LinkField":"x_Dni","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","x_Dni","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fatencion_equiposlist.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fatencion_equiposlist.Lists["x_Id_Prioridad"] = {"LinkField":"x_Id_Prioridad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_prioridad_atencion"};

// Form object for search
var CurrentSearchForm = fatencion_equiposlistsrch = new ew_Form("fatencion_equiposlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($atencion_equipos->Export == "") { ?>
<div class="ewToolbar">
<?php if ($atencion_equipos->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($atencion_equipos_list->TotalRecs > 0 && $atencion_equipos_list->ExportOptions->Visible()) { ?>
<?php $atencion_equipos_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_equipos_list->SearchOptions->Visible()) { ?>
<?php $atencion_equipos_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_equipos_list->FilterOptions->Visible()) { ?>
<?php $atencion_equipos_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_equipos->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($atencion_equipos->CurrentAction == "gridadd") {
	$atencion_equipos->CurrentFilter = "0=1";
	$atencion_equipos_list->StartRec = 1;
	$atencion_equipos_list->DisplayRecs = $atencion_equipos->GridAddRowCount;
	$atencion_equipos_list->TotalRecs = $atencion_equipos_list->DisplayRecs;
	$atencion_equipos_list->StopRec = $atencion_equipos_list->DisplayRecs;
} else {
	$bSelectLimit = $atencion_equipos_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($atencion_equipos_list->TotalRecs <= 0)
			$atencion_equipos_list->TotalRecs = $atencion_equipos->SelectRecordCount();
	} else {
		if (!$atencion_equipos_list->Recordset && ($atencion_equipos_list->Recordset = $atencion_equipos_list->LoadRecordset()))
			$atencion_equipos_list->TotalRecs = $atencion_equipos_list->Recordset->RecordCount();
	}
	$atencion_equipos_list->StartRec = 1;
	if ($atencion_equipos_list->DisplayRecs <= 0 || ($atencion_equipos->Export <> "" && $atencion_equipos->ExportAll)) // Display all records
		$atencion_equipos_list->DisplayRecs = $atencion_equipos_list->TotalRecs;
	if (!($atencion_equipos->Export <> "" && $atencion_equipos->ExportAll))
		$atencion_equipos_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$atencion_equipos_list->Recordset = $atencion_equipos_list->LoadRecordset($atencion_equipos_list->StartRec-1, $atencion_equipos_list->DisplayRecs);

	// Set no record found message
	if ($atencion_equipos->CurrentAction == "" && $atencion_equipos_list->TotalRecs == 0) {
		if ($atencion_equipos_list->SearchWhere == "0=101")
			$atencion_equipos_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$atencion_equipos_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($atencion_equipos_list->AuditTrailOnSearch && $atencion_equipos_list->Command == "search" && !$atencion_equipos_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $atencion_equipos_list->getSessionWhere();
		$atencion_equipos_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$atencion_equipos_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($atencion_equipos->Export == "" && $atencion_equipos->CurrentAction == "") { ?>
<form name="fatencion_equiposlistsrch" id="fatencion_equiposlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($atencion_equipos_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fatencion_equiposlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="atencion_equipos">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($atencion_equipos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($atencion_equipos_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $atencion_equipos_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($atencion_equipos_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($atencion_equipos_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($atencion_equipos_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($atencion_equipos_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $atencion_equipos_list->ShowPageHeader(); ?>
<?php
$atencion_equipos_list->ShowMessage();
?>
<?php if ($atencion_equipos_list->TotalRecs > 0 || $atencion_equipos->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid atencion_equipos">
<form name="fatencion_equiposlist" id="fatencion_equiposlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($atencion_equipos_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $atencion_equipos_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="atencion_equipos">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_atencion_equipos" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($atencion_equipos_list->TotalRecs > 0) { ?>
<table id="tbl_atencion_equiposlist" class="table ewTable">
<?php echo $atencion_equipos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$atencion_equipos_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$atencion_equipos_list->RenderListOptions();

// Render list options (header, left)
$atencion_equipos_list->ListOptions->Render("header", "left");
?>
<?php if ($atencion_equipos->Id_Atencion->Visible) { // Id_Atencion ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->Id_Atencion) == "") { ?>
		<th data-name="Id_Atencion"><div id="elh_atencion_equipos_Id_Atencion" class="atencion_equipos_Id_Atencion"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->Id_Atencion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Atencion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->Id_Atencion) ?>',1);"><div id="elh_atencion_equipos_Id_Atencion" class="atencion_equipos_Id_Atencion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->Id_Atencion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->Id_Atencion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->Id_Atencion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_equipos->Dni->Visible) { // Dni ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_atencion_equipos_Dni" class="atencion_equipos_Dni"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->Dni) ?>',1);"><div id="elh_atencion_equipos_Dni" class="atencion_equipos_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->Dni->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_equipos->NroSerie->Visible) { // NroSerie ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_atencion_equipos_NroSerie" class="atencion_equipos_NroSerie"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->NroSerie) ?>',1);"><div id="elh_atencion_equipos_NroSerie" class="atencion_equipos_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->NroSerie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_equipos->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->Fecha_Entrada) == "") { ?>
		<th data-name="Fecha_Entrada"><div id="elh_atencion_equipos_Fecha_Entrada" class="atencion_equipos_Fecha_Entrada"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->Fecha_Entrada->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Entrada"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->Fecha_Entrada) ?>',1);"><div id="elh_atencion_equipos_Fecha_Entrada" class="atencion_equipos_Fecha_Entrada">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->Fecha_Entrada->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->Fecha_Entrada->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->Fecha_Entrada->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_equipos->Id_Prioridad->Visible) { // Id_Prioridad ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->Id_Prioridad) == "") { ?>
		<th data-name="Id_Prioridad"><div id="elh_atencion_equipos_Id_Prioridad" class="atencion_equipos_Id_Prioridad"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->Id_Prioridad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Prioridad"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->Id_Prioridad) ?>',1);"><div id="elh_atencion_equipos_Id_Prioridad" class="atencion_equipos_Id_Prioridad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->Id_Prioridad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->Id_Prioridad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->Id_Prioridad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_equipos->Usuario->Visible) { // Usuario ?>
	<?php if ($atencion_equipos->SortUrl($atencion_equipos->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_atencion_equipos_Usuario" class="atencion_equipos_Usuario"><div class="ewTableHeaderCaption"><?php echo $atencion_equipos->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_equipos->SortUrl($atencion_equipos->Usuario) ?>',1);"><div id="elh_atencion_equipos_Usuario" class="atencion_equipos_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_equipos->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_equipos->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_equipos->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$atencion_equipos_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($atencion_equipos->ExportAll && $atencion_equipos->Export <> "") {
	$atencion_equipos_list->StopRec = $atencion_equipos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($atencion_equipos_list->TotalRecs > $atencion_equipos_list->StartRec + $atencion_equipos_list->DisplayRecs - 1)
		$atencion_equipos_list->StopRec = $atencion_equipos_list->StartRec + $atencion_equipos_list->DisplayRecs - 1;
	else
		$atencion_equipos_list->StopRec = $atencion_equipos_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($atencion_equipos_list->FormKeyCountName) && ($atencion_equipos->CurrentAction == "gridadd" || $atencion_equipos->CurrentAction == "gridedit" || $atencion_equipos->CurrentAction == "F")) {
		$atencion_equipos_list->KeyCount = $objForm->GetValue($atencion_equipos_list->FormKeyCountName);
		$atencion_equipos_list->StopRec = $atencion_equipos_list->StartRec + $atencion_equipos_list->KeyCount - 1;
	}
}
$atencion_equipos_list->RecCnt = $atencion_equipos_list->StartRec - 1;
if ($atencion_equipos_list->Recordset && !$atencion_equipos_list->Recordset->EOF) {
	$atencion_equipos_list->Recordset->MoveFirst();
	$bSelectLimit = $atencion_equipos_list->UseSelectLimit;
	if (!$bSelectLimit && $atencion_equipos_list->StartRec > 1)
		$atencion_equipos_list->Recordset->Move($atencion_equipos_list->StartRec - 1);
} elseif (!$atencion_equipos->AllowAddDeleteRow && $atencion_equipos_list->StopRec == 0) {
	$atencion_equipos_list->StopRec = $atencion_equipos->GridAddRowCount;
}

// Initialize aggregate
$atencion_equipos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$atencion_equipos->ResetAttrs();
$atencion_equipos_list->RenderRow();
if ($atencion_equipos->CurrentAction == "gridadd")
	$atencion_equipos_list->RowIndex = 0;
if ($atencion_equipos->CurrentAction == "gridedit")
	$atencion_equipos_list->RowIndex = 0;
while ($atencion_equipos_list->RecCnt < $atencion_equipos_list->StopRec) {
	$atencion_equipos_list->RecCnt++;
	if (intval($atencion_equipos_list->RecCnt) >= intval($atencion_equipos_list->StartRec)) {
		$atencion_equipos_list->RowCnt++;
		if ($atencion_equipos->CurrentAction == "gridadd" || $atencion_equipos->CurrentAction == "gridedit" || $atencion_equipos->CurrentAction == "F") {
			$atencion_equipos_list->RowIndex++;
			$objForm->Index = $atencion_equipos_list->RowIndex;
			if ($objForm->HasValue($atencion_equipos_list->FormActionName))
				$atencion_equipos_list->RowAction = strval($objForm->GetValue($atencion_equipos_list->FormActionName));
			elseif ($atencion_equipos->CurrentAction == "gridadd")
				$atencion_equipos_list->RowAction = "insert";
			else
				$atencion_equipos_list->RowAction = "";
		}

		// Set up key count
		$atencion_equipos_list->KeyCount = $atencion_equipos_list->RowIndex;

		// Init row class and style
		$atencion_equipos->ResetAttrs();
		$atencion_equipos->CssClass = "";
		if ($atencion_equipos->CurrentAction == "gridadd") {
			$atencion_equipos_list->LoadDefaultValues(); // Load default values
		} else {
			$atencion_equipos_list->LoadRowValues($atencion_equipos_list->Recordset); // Load row values
		}
		$atencion_equipos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($atencion_equipos->CurrentAction == "gridadd") // Grid add
			$atencion_equipos->RowType = EW_ROWTYPE_ADD; // Render add
		if ($atencion_equipos->CurrentAction == "gridadd" && $atencion_equipos->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$atencion_equipos_list->RestoreCurrentRowFormValues($atencion_equipos_list->RowIndex); // Restore form values
		if ($atencion_equipos->CurrentAction == "gridedit") { // Grid edit
			if ($atencion_equipos->EventCancelled) {
				$atencion_equipos_list->RestoreCurrentRowFormValues($atencion_equipos_list->RowIndex); // Restore form values
			}
			if ($atencion_equipos_list->RowAction == "insert")
				$atencion_equipos->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$atencion_equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($atencion_equipos->CurrentAction == "gridedit" && ($atencion_equipos->RowType == EW_ROWTYPE_EDIT || $atencion_equipos->RowType == EW_ROWTYPE_ADD) && $atencion_equipos->EventCancelled) // Update failed
			$atencion_equipos_list->RestoreCurrentRowFormValues($atencion_equipos_list->RowIndex); // Restore form values
		if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$atencion_equipos_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$atencion_equipos->RowAttrs = array_merge($atencion_equipos->RowAttrs, array('data-rowindex'=>$atencion_equipos_list->RowCnt, 'id'=>'r' . $atencion_equipos_list->RowCnt . '_atencion_equipos', 'data-rowtype'=>$atencion_equipos->RowType));

		// Render row
		$atencion_equipos_list->RenderRow();

		// Render list options
		$atencion_equipos_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($atencion_equipos_list->RowAction <> "delete" && $atencion_equipos_list->RowAction <> "insertdelete" && !($atencion_equipos_list->RowAction == "insert" && $atencion_equipos->CurrentAction == "F" && $atencion_equipos_list->EmptyRow())) {
?>
	<tr<?php echo $atencion_equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_equipos_list->ListOptions->Render("body", "left", $atencion_equipos_list->RowCnt);
?>
	<?php if ($atencion_equipos->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion"<?php echo $atencion_equipos->Id_Atencion->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="atencion_equipos" data-field="x_Id_Atencion" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_equipos->Id_Atencion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Id_Atencion" class="form-group atencion_equipos_Id_Atencion">
<span<?php echo $atencion_equipos->Id_Atencion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_equipos->Id_Atencion->EditValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Id_Atencion" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_equipos->Id_Atencion->CurrentValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Id_Atencion" class="atencion_equipos_Id_Atencion">
<span<?php echo $atencion_equipos->Id_Atencion->ViewAttributes() ?>>
<?php echo $atencion_equipos->Id_Atencion->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $atencion_equipos_list->PageObjName . "_row_" . $atencion_equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($atencion_equipos->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $atencion_equipos->Dni->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Dni" class="form-group atencion_equipos_Dni">
<?php $atencion_equipos->Dni->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$atencion_equipos->Dni->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni"><?php echo (strval($atencion_equipos->Dni->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->Dni->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_Dni" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->Dni->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->CurrentValue ?>"<?php echo $atencion_equipos->Dni->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Dni" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($atencion_equipos->Dni->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Dni" class="form-group atencion_equipos_Dni">
<?php $atencion_equipos->Dni->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$atencion_equipos->Dni->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni"><?php echo (strval($atencion_equipos->Dni->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->Dni->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_Dni" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->Dni->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->CurrentValue ?>"<?php echo $atencion_equipos->Dni->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie">
</span>
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Dni" class="atencion_equipos_Dni">
<span<?php echo $atencion_equipos->Dni->ViewAttributes() ?>>
<?php echo $atencion_equipos->Dni->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $atencion_equipos->NroSerie->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_NroSerie" class="form-group atencion_equipos_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie"><?php echo (strval($atencion_equipos->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->CurrentValue ?>"<?php echo $atencion_equipos->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_NroSerie" name="o<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="o<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_equipos->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_NroSerie" class="form-group atencion_equipos_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie"><?php echo (strval($atencion_equipos->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->CurrentValue ?>"<?php echo $atencion_equipos->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_NroSerie" class="atencion_equipos_NroSerie">
<span<?php echo $atencion_equipos->NroSerie->ViewAttributes() ?>>
<?php echo $atencion_equipos->NroSerie->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
		<td data-name="Fecha_Entrada"<?php echo $atencion_equipos->Fecha_Entrada->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Fecha_Entrada" class="form-group atencion_equipos_Fecha_Entrada">
<input type="text" data-table="atencion_equipos" data-field="x_Fecha_Entrada" data-format="7" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" placeholder="<?php echo ew_HtmlEncode($atencion_equipos->Fecha_Entrada->getPlaceHolder()) ?>" value="<?php echo $atencion_equipos->Fecha_Entrada->EditValue ?>"<?php echo $atencion_equipos->Fecha_Entrada->EditAttributes() ?>>
<?php if (!$atencion_equipos->Fecha_Entrada->ReadOnly && !$atencion_equipos->Fecha_Entrada->Disabled && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["readonly"]) && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_equiposlist", "x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Fecha_Entrada" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" value="<?php echo ew_HtmlEncode($atencion_equipos->Fecha_Entrada->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Fecha_Entrada" class="form-group atencion_equipos_Fecha_Entrada">
<input type="text" data-table="atencion_equipos" data-field="x_Fecha_Entrada" data-format="7" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" placeholder="<?php echo ew_HtmlEncode($atencion_equipos->Fecha_Entrada->getPlaceHolder()) ?>" value="<?php echo $atencion_equipos->Fecha_Entrada->EditValue ?>"<?php echo $atencion_equipos->Fecha_Entrada->EditAttributes() ?>>
<?php if (!$atencion_equipos->Fecha_Entrada->ReadOnly && !$atencion_equipos->Fecha_Entrada->Disabled && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["readonly"]) && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_equiposlist", "x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Fecha_Entrada" class="atencion_equipos_Fecha_Entrada">
<span<?php echo $atencion_equipos->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $atencion_equipos->Fecha_Entrada->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Id_Prioridad->Visible) { // Id_Prioridad ?>
		<td data-name="Id_Prioridad"<?php echo $atencion_equipos->Id_Prioridad->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Id_Prioridad" class="form-group atencion_equipos_Id_Prioridad">
<select data-table="atencion_equipos" data-field="x_Id_Prioridad" data-value-separator="<?php echo $atencion_equipos->Id_Prioridad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad"<?php echo $atencion_equipos->Id_Prioridad->EditAttributes() ?>>
<?php echo $atencion_equipos->Id_Prioridad->SelectOptionListHtml("x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" value="<?php echo $atencion_equipos->Id_Prioridad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Id_Prioridad" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" value="<?php echo ew_HtmlEncode($atencion_equipos->Id_Prioridad->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Id_Prioridad" class="form-group atencion_equipos_Id_Prioridad">
<select data-table="atencion_equipos" data-field="x_Id_Prioridad" data-value-separator="<?php echo $atencion_equipos->Id_Prioridad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad"<?php echo $atencion_equipos->Id_Prioridad->EditAttributes() ?>>
<?php echo $atencion_equipos->Id_Prioridad->SelectOptionListHtml("x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" value="<?php echo $atencion_equipos->Id_Prioridad->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Id_Prioridad" class="atencion_equipos_Id_Prioridad">
<span<?php echo $atencion_equipos->Id_Prioridad->ViewAttributes() ?>>
<?php echo $atencion_equipos->Id_Prioridad->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $atencion_equipos->Usuario->CellAttributes() ?>>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="atencion_equipos" data-field="x_Usuario" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Usuario" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($atencion_equipos->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_equipos_list->RowCnt ?>_atencion_equipos_Usuario" class="atencion_equipos_Usuario">
<span<?php echo $atencion_equipos->Usuario->ViewAttributes() ?>>
<?php echo $atencion_equipos->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_equipos_list->ListOptions->Render("body", "right", $atencion_equipos_list->RowCnt);
?>
	</tr>
<?php if ($atencion_equipos->RowType == EW_ROWTYPE_ADD || $atencion_equipos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fatencion_equiposlist.UpdateOpts(<?php echo $atencion_equipos_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($atencion_equipos->CurrentAction <> "gridadd")
		if (!$atencion_equipos_list->Recordset->EOF) $atencion_equipos_list->Recordset->MoveNext();
}
?>
<?php
	if ($atencion_equipos->CurrentAction == "gridadd" || $atencion_equipos->CurrentAction == "gridedit") {
		$atencion_equipos_list->RowIndex = '$rowindex$';
		$atencion_equipos_list->LoadDefaultValues();

		// Set row properties
		$atencion_equipos->ResetAttrs();
		$atencion_equipos->RowAttrs = array_merge($atencion_equipos->RowAttrs, array('data-rowindex'=>$atencion_equipos_list->RowIndex, 'id'=>'r0_atencion_equipos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($atencion_equipos->RowAttrs["class"], "ewTemplate");
		$atencion_equipos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$atencion_equipos_list->RenderRow();

		// Render list options
		$atencion_equipos_list->RenderListOptions();
		$atencion_equipos_list->StartRowCnt = 0;
?>
	<tr<?php echo $atencion_equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_equipos_list->ListOptions->Render("body", "left", $atencion_equipos_list->RowIndex);
?>
	<?php if ($atencion_equipos->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion">
<input type="hidden" data-table="atencion_equipos" data-field="x_Id_Atencion" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_equipos->Id_Atencion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<span id="el$rowindex$_atencion_equipos_Dni" class="form-group atencion_equipos_Dni">
<?php $atencion_equipos->Dni->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$atencion_equipos->Dni->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni"><?php echo (strval($atencion_equipos->Dni->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->Dni->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_Dni" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->Dni->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->CurrentValue ?>"<?php echo $atencion_equipos->Dni->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo $atencion_equipos->Dni->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="ln_x<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Dni" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Dni" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($atencion_equipos->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<span id="el$rowindex$_atencion_equipos_NroSerie" class="form-group atencion_equipos_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie"><?php echo (strval($atencion_equipos->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $atencion_equipos->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($atencion_equipos->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="atencion_equipos" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $atencion_equipos->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->CurrentValue ?>"<?php echo $atencion_equipos->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo $atencion_equipos->NroSerie->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_NroSerie" name="o<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" id="o<?php echo $atencion_equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_equipos->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Fecha_Entrada->Visible) { // Fecha_Entrada ?>
		<td data-name="Fecha_Entrada">
<span id="el$rowindex$_atencion_equipos_Fecha_Entrada" class="form-group atencion_equipos_Fecha_Entrada">
<input type="text" data-table="atencion_equipos" data-field="x_Fecha_Entrada" data-format="7" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" placeholder="<?php echo ew_HtmlEncode($atencion_equipos->Fecha_Entrada->getPlaceHolder()) ?>" value="<?php echo $atencion_equipos->Fecha_Entrada->EditValue ?>"<?php echo $atencion_equipos->Fecha_Entrada->EditAttributes() ?>>
<?php if (!$atencion_equipos->Fecha_Entrada->ReadOnly && !$atencion_equipos->Fecha_Entrada->Disabled && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["readonly"]) && !isset($atencion_equipos->Fecha_Entrada->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_equiposlist", "x<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Fecha_Entrada" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Fecha_Entrada" value="<?php echo ew_HtmlEncode($atencion_equipos->Fecha_Entrada->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Id_Prioridad->Visible) { // Id_Prioridad ?>
		<td data-name="Id_Prioridad">
<span id="el$rowindex$_atencion_equipos_Id_Prioridad" class="form-group atencion_equipos_Id_Prioridad">
<select data-table="atencion_equipos" data-field="x_Id_Prioridad" data-value-separator="<?php echo $atencion_equipos->Id_Prioridad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" name="x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad"<?php echo $atencion_equipos->Id_Prioridad->EditAttributes() ?>>
<?php echo $atencion_equipos->Id_Prioridad->SelectOptionListHtml("x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" id="s_x<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" value="<?php echo $atencion_equipos->Id_Prioridad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_equipos" data-field="x_Id_Prioridad" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Id_Prioridad" value="<?php echo ew_HtmlEncode($atencion_equipos->Id_Prioridad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="atencion_equipos" data-field="x_Usuario" name="o<?php echo $atencion_equipos_list->RowIndex ?>_Usuario" id="o<?php echo $atencion_equipos_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($atencion_equipos->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_equipos_list->ListOptions->Render("body", "right", $atencion_equipos_list->RowCnt);
?>
<script type="text/javascript">
fatencion_equiposlist.UpdateOpts(<?php echo $atencion_equipos_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($atencion_equipos->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $atencion_equipos_list->FormKeyCountName ?>" id="<?php echo $atencion_equipos_list->FormKeyCountName ?>" value="<?php echo $atencion_equipos_list->KeyCount ?>">
<?php echo $atencion_equipos_list->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_equipos->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $atencion_equipos_list->FormKeyCountName ?>" id="<?php echo $atencion_equipos_list->FormKeyCountName ?>" value="<?php echo $atencion_equipos_list->KeyCount ?>">
<?php echo $atencion_equipos_list->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_equipos->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($atencion_equipos_list->Recordset)
	$atencion_equipos_list->Recordset->Close();
?>
<?php if ($atencion_equipos->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($atencion_equipos->CurrentAction <> "gridadd" && $atencion_equipos->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($atencion_equipos_list->Pager)) $atencion_equipos_list->Pager = new cPrevNextPager($atencion_equipos_list->StartRec, $atencion_equipos_list->DisplayRecs, $atencion_equipos_list->TotalRecs) ?>
<?php if ($atencion_equipos_list->Pager->RecordCount > 0 && $atencion_equipos_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($atencion_equipos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $atencion_equipos_list->PageUrl() ?>start=<?php echo $atencion_equipos_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($atencion_equipos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $atencion_equipos_list->PageUrl() ?>start=<?php echo $atencion_equipos_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $atencion_equipos_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($atencion_equipos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $atencion_equipos_list->PageUrl() ?>start=<?php echo $atencion_equipos_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($atencion_equipos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $atencion_equipos_list->PageUrl() ?>start=<?php echo $atencion_equipos_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $atencion_equipos_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $atencion_equipos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $atencion_equipos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $atencion_equipos_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_equipos_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($atencion_equipos_list->TotalRecs == 0 && $atencion_equipos->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_equipos_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($atencion_equipos->Export == "") { ?>
<script type="text/javascript">
fatencion_equiposlistsrch.FilterList = <?php echo $atencion_equipos_list->GetFilterList() ?>;
fatencion_equiposlistsrch.Init();
fatencion_equiposlist.Init();
</script>
<?php } ?>
<?php
$atencion_equipos_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($atencion_equipos->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$atencion_equipos_list->Page_Terminate();
?>
