<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pedido_stinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pedido_st_list = NULL; // Initialize page object first

class cpedido_st_list extends cpedido_st {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pedido_st';

	// Page object name
	var $PageObjName = 'pedido_st_list';

	// Grid form hidden field names
	var $FormName = 'fpedido_stlist';
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

		// Table object (pedido_st)
		if (!isset($GLOBALS["pedido_st"]) || get_class($GLOBALS["pedido_st"]) == "cpedido_st") {
			$GLOBALS["pedido_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pedido_st"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pedido_stadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pedido_stdelete.php";
		$this->MultiUpdateUrl = "pedido_stupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pedido_st', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpedido_stlistsrch";

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
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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
		$this->CUE->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Id_Zona->SetVisibility();
		$this->DEPARTAMENTO->SetVisibility();
		$this->LOCALIDAD->SetVisibility();
		$this->SERIE_NETBOOK->SetVisibility();
		$this->NB0_TIKET->SetVisibility();
		$this->PROBLEMA->SetVisibility();

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
		global $EW_EXPORT, $pedido_st;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pedido_st);
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
	var $DisplayRecs = 25;
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
			$this->DisplayRecs = 25; // Load default
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
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

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
		if (count($arrKeyFlds) >= 2) {
			$this->CUE->setFormValue($arrKeyFlds[0]);
			$this->SERIE_NETBOOK->setFormValue($arrKeyFlds[1]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpedido_stlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->CUE->AdvancedSearch->ToJSON(), ","); // Field CUE
		$sFilterList = ew_Concat($sFilterList, $this->Sigla->AdvancedSearch->ToJSON(), ","); // Field Sigla
		$sFilterList = ew_Concat($sFilterList, $this->Id_Zona->AdvancedSearch->ToJSON(), ","); // Field Id_Zona
		$sFilterList = ew_Concat($sFilterList, $this->DEPARTAMENTO->AdvancedSearch->ToJSON(), ","); // Field DEPARTAMENTO
		$sFilterList = ew_Concat($sFilterList, $this->LOCALIDAD->AdvancedSearch->ToJSON(), ","); // Field LOCALIDAD
		$sFilterList = ew_Concat($sFilterList, $this->SERIE_NETBOOK->AdvancedSearch->ToJSON(), ","); // Field SERIE NETBOOK
		$sFilterList = ew_Concat($sFilterList, $this->NB0_TIKET->AdvancedSearch->ToJSON(), ","); // Field N° TIKET
		$sFilterList = ew_Concat($sFilterList, $this->PROBLEMA->AdvancedSearch->ToJSON(), ","); // Field PROBLEMA
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Retiro->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Retiro
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpedido_stlistsrch", $filters);
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

		// Field CUE
		$this->CUE->AdvancedSearch->SearchValue = @$filter["x_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator = @$filter["z_CUE"];
		$this->CUE->AdvancedSearch->SearchCondition = @$filter["v_CUE"];
		$this->CUE->AdvancedSearch->SearchValue2 = @$filter["y_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator2 = @$filter["w_CUE"];
		$this->CUE->AdvancedSearch->Save();

		// Field Sigla
		$this->Sigla->AdvancedSearch->SearchValue = @$filter["x_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator = @$filter["z_Sigla"];
		$this->Sigla->AdvancedSearch->SearchCondition = @$filter["v_Sigla"];
		$this->Sigla->AdvancedSearch->SearchValue2 = @$filter["y_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator2 = @$filter["w_Sigla"];
		$this->Sigla->AdvancedSearch->Save();

		// Field Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = @$filter["x_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchOperator = @$filter["z_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchCondition = @$filter["v_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchValue2 = @$filter["y_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->Save();

		// Field DEPARTAMENTO
		$this->DEPARTAMENTO->AdvancedSearch->SearchValue = @$filter["x_DEPARTAMENTO"];
		$this->DEPARTAMENTO->AdvancedSearch->SearchOperator = @$filter["z_DEPARTAMENTO"];
		$this->DEPARTAMENTO->AdvancedSearch->SearchCondition = @$filter["v_DEPARTAMENTO"];
		$this->DEPARTAMENTO->AdvancedSearch->SearchValue2 = @$filter["y_DEPARTAMENTO"];
		$this->DEPARTAMENTO->AdvancedSearch->SearchOperator2 = @$filter["w_DEPARTAMENTO"];
		$this->DEPARTAMENTO->AdvancedSearch->Save();

		// Field LOCALIDAD
		$this->LOCALIDAD->AdvancedSearch->SearchValue = @$filter["x_LOCALIDAD"];
		$this->LOCALIDAD->AdvancedSearch->SearchOperator = @$filter["z_LOCALIDAD"];
		$this->LOCALIDAD->AdvancedSearch->SearchCondition = @$filter["v_LOCALIDAD"];
		$this->LOCALIDAD->AdvancedSearch->SearchValue2 = @$filter["y_LOCALIDAD"];
		$this->LOCALIDAD->AdvancedSearch->SearchOperator2 = @$filter["w_LOCALIDAD"];
		$this->LOCALIDAD->AdvancedSearch->Save();

		// Field SERIE NETBOOK
		$this->SERIE_NETBOOK->AdvancedSearch->SearchValue = @$filter["x_SERIE_NETBOOK"];
		$this->SERIE_NETBOOK->AdvancedSearch->SearchOperator = @$filter["z_SERIE_NETBOOK"];
		$this->SERIE_NETBOOK->AdvancedSearch->SearchCondition = @$filter["v_SERIE_NETBOOK"];
		$this->SERIE_NETBOOK->AdvancedSearch->SearchValue2 = @$filter["y_SERIE_NETBOOK"];
		$this->SERIE_NETBOOK->AdvancedSearch->SearchOperator2 = @$filter["w_SERIE_NETBOOK"];
		$this->SERIE_NETBOOK->AdvancedSearch->Save();

		// Field N° TIKET
		$this->NB0_TIKET->AdvancedSearch->SearchValue = @$filter["x_NB0_TIKET"];
		$this->NB0_TIKET->AdvancedSearch->SearchOperator = @$filter["z_NB0_TIKET"];
		$this->NB0_TIKET->AdvancedSearch->SearchCondition = @$filter["v_NB0_TIKET"];
		$this->NB0_TIKET->AdvancedSearch->SearchValue2 = @$filter["y_NB0_TIKET"];
		$this->NB0_TIKET->AdvancedSearch->SearchOperator2 = @$filter["w_NB0_TIKET"];
		$this->NB0_TIKET->AdvancedSearch->Save();

		// Field PROBLEMA
		$this->PROBLEMA->AdvancedSearch->SearchValue = @$filter["x_PROBLEMA"];
		$this->PROBLEMA->AdvancedSearch->SearchOperator = @$filter["z_PROBLEMA"];
		$this->PROBLEMA->AdvancedSearch->SearchCondition = @$filter["v_PROBLEMA"];
		$this->PROBLEMA->AdvancedSearch->SearchValue2 = @$filter["y_PROBLEMA"];
		$this->PROBLEMA->AdvancedSearch->SearchOperator2 = @$filter["w_PROBLEMA"];
		$this->PROBLEMA->AdvancedSearch->Save();

		// Field Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->CUE, $Default, FALSE); // CUE
		$this->BuildSearchSql($sWhere, $this->Sigla, $Default, FALSE); // Sigla
		$this->BuildSearchSql($sWhere, $this->Id_Zona, $Default, FALSE); // Id_Zona
		$this->BuildSearchSql($sWhere, $this->DEPARTAMENTO, $Default, FALSE); // DEPARTAMENTO
		$this->BuildSearchSql($sWhere, $this->LOCALIDAD, $Default, FALSE); // LOCALIDAD
		$this->BuildSearchSql($sWhere, $this->SERIE_NETBOOK, $Default, FALSE); // SERIE NETBOOK
		$this->BuildSearchSql($sWhere, $this->NB0_TIKET, $Default, FALSE); // N° TIKET
		$this->BuildSearchSql($sWhere, $this->PROBLEMA, $Default, FALSE); // PROBLEMA
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Retiro, $Default, FALSE); // Id_Tipo_Retiro

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->CUE->AdvancedSearch->Save(); // CUE
			$this->Sigla->AdvancedSearch->Save(); // Sigla
			$this->Id_Zona->AdvancedSearch->Save(); // Id_Zona
			$this->DEPARTAMENTO->AdvancedSearch->Save(); // DEPARTAMENTO
			$this->LOCALIDAD->AdvancedSearch->Save(); // LOCALIDAD
			$this->SERIE_NETBOOK->AdvancedSearch->Save(); // SERIE NETBOOK
			$this->NB0_TIKET->AdvancedSearch->Save(); // N° TIKET
			$this->PROBLEMA->AdvancedSearch->Save(); // PROBLEMA
			$this->Id_Tipo_Retiro->AdvancedSearch->Save(); // Id_Tipo_Retiro
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
		$this->BuildBasicSearchSQL($sWhere, $this->CUE, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sigla, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DEPARTAMENTO, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->LOCALIDAD, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SERIE_NETBOOK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NB0_TIKET, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PROBLEMA, $arKeywords, $type);
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
		if (!$Security->CanSearch()) return "";
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
		if ($this->CUE->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sigla->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Zona->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->DEPARTAMENTO->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->LOCALIDAD->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->SERIE_NETBOOK->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NB0_TIKET->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->PROBLEMA->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Retiro->AdvancedSearch->IssetSession())
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
		$this->CUE->AdvancedSearch->UnsetSession();
		$this->Sigla->AdvancedSearch->UnsetSession();
		$this->Id_Zona->AdvancedSearch->UnsetSession();
		$this->DEPARTAMENTO->AdvancedSearch->UnsetSession();
		$this->LOCALIDAD->AdvancedSearch->UnsetSession();
		$this->SERIE_NETBOOK->AdvancedSearch->UnsetSession();
		$this->NB0_TIKET->AdvancedSearch->UnsetSession();
		$this->PROBLEMA->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Retiro->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->CUE->AdvancedSearch->Load();
		$this->Sigla->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
		$this->DEPARTAMENTO->AdvancedSearch->Load();
		$this->LOCALIDAD->AdvancedSearch->Load();
		$this->SERIE_NETBOOK->AdvancedSearch->Load();
		$this->NB0_TIKET->AdvancedSearch->Load();
		$this->PROBLEMA->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->CUE); // CUE
			$this->UpdateSort($this->Sigla); // Sigla
			$this->UpdateSort($this->Id_Zona); // Id_Zona
			$this->UpdateSort($this->DEPARTAMENTO); // DEPARTAMENTO
			$this->UpdateSort($this->LOCALIDAD); // LOCALIDAD
			$this->UpdateSort($this->SERIE_NETBOOK); // SERIE NETBOOK
			$this->UpdateSort($this->NB0_TIKET); // N° TIKET
			$this->UpdateSort($this->PROBLEMA); // PROBLEMA
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
				$this->CUE->setSort("");
				$this->Sigla->setSort("");
				$this->Id_Zona->setSort("");
				$this->DEPARTAMENTO->setSort("");
				$this->LOCALIDAD->setSort("");
				$this->SERIE_NETBOOK->setSort("");
				$this->NB0_TIKET->setSort("");
				$this->PROBLEMA->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"pedido_st\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->CUE->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->SERIE_NETBOOK->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpedido_stlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpedido_stlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpedido_stlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpedido_stlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"pedido_stsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
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
		// CUE

		$this->CUE->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_CUE"]);
		if ($this->CUE->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->CUE->AdvancedSearch->SearchOperator = @$_GET["z_CUE"];

		// Sigla
		$this->Sigla->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sigla"]);
		if ($this->Sigla->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sigla->AdvancedSearch->SearchOperator = @$_GET["z_Sigla"];

		// Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Zona"]);
		if ($this->Id_Zona->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Zona->AdvancedSearch->SearchOperator = @$_GET["z_Id_Zona"];

		// DEPARTAMENTO
		$this->DEPARTAMENTO->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_DEPARTAMENTO"]);
		if ($this->DEPARTAMENTO->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->DEPARTAMENTO->AdvancedSearch->SearchOperator = @$_GET["z_DEPARTAMENTO"];

		// LOCALIDAD
		$this->LOCALIDAD->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_LOCALIDAD"]);
		if ($this->LOCALIDAD->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->LOCALIDAD->AdvancedSearch->SearchOperator = @$_GET["z_LOCALIDAD"];

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_SERIE_NETBOOK"]);
		if ($this->SERIE_NETBOOK->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->SERIE_NETBOOK->AdvancedSearch->SearchOperator = @$_GET["z_SERIE_NETBOOK"];

		// N° TIKET
		$this->NB0_TIKET->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NB0_TIKET"]);
		if ($this->NB0_TIKET->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NB0_TIKET->AdvancedSearch->SearchOperator = @$_GET["z_NB0_TIKET"];

		// PROBLEMA
		$this->PROBLEMA->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_PROBLEMA"]);
		if ($this->PROBLEMA->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->PROBLEMA->AdvancedSearch->SearchOperator = @$_GET["z_PROBLEMA"];

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Retiro"]);
		if ($this->Id_Tipo_Retiro->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Retiro"];
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
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->DEPARTAMENTO->setDbValue($rs->fields('DEPARTAMENTO'));
		$this->LOCALIDAD->setDbValue($rs->fields('LOCALIDAD'));
		$this->SERIE_NETBOOK->setDbValue($rs->fields('SERIE NETBOOK'));
		$this->NB0_TIKET->setDbValue($rs->fields('N° TIKET'));
		$this->PROBLEMA->setDbValue($rs->fields('PROBLEMA'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CUE->DbValue = $row['CUE'];
		$this->Sigla->DbValue = $row['Sigla'];
		$this->Id_Zona->DbValue = $row['Id_Zona'];
		$this->DEPARTAMENTO->DbValue = $row['DEPARTAMENTO'];
		$this->LOCALIDAD->DbValue = $row['LOCALIDAD'];
		$this->SERIE_NETBOOK->DbValue = $row['SERIE NETBOOK'];
		$this->NB0_TIKET->DbValue = $row['N° TIKET'];
		$this->PROBLEMA->DbValue = $row['PROBLEMA'];
		$this->Id_Tipo_Retiro->DbValue = $row['Id_Tipo_Retiro'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CUE")) <> "")
			$this->CUE->CurrentValue = $this->getKey("CUE"); // CUE
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("SERIE_NETBOOK")) <> "")
			$this->SERIE_NETBOOK->CurrentValue = $this->getKey("SERIE_NETBOOK"); // SERIE NETBOOK
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
		// CUE
		// Sigla
		// Id_Zona
		// DEPARTAMENTO
		// LOCALIDAD
		// SERIE NETBOOK
		// N° TIKET
		// PROBLEMA
		// Id_Tipo_Retiro

		$this->Id_Tipo_Retiro->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Id_Zona
		if (strval($this->Id_Zona->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
		$sWhereWrk = "";
		$this->Id_Zona->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Zona->ViewValue = $this->Id_Zona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Zona->ViewValue = $this->Id_Zona->CurrentValue;
			}
		} else {
			$this->Id_Zona->ViewValue = NULL;
		}
		$this->Id_Zona->ViewCustomAttributes = "";

		// DEPARTAMENTO
		if (strval($this->DEPARTAMENTO->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->DEPARTAMENTO->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->DEPARTAMENTO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DEPARTAMENTO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->CurrentValue;
			}
		} else {
			$this->DEPARTAMENTO->ViewValue = NULL;
		}
		$this->DEPARTAMENTO->ViewCustomAttributes = "";

		// LOCALIDAD
		$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
		if (strval($this->LOCALIDAD->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->LOCALIDAD->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->LOCALIDAD->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
			}
		} else {
			$this->LOCALIDAD->ViewValue = NULL;
		}
		$this->LOCALIDAD->ViewCustomAttributes = "";

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->CurrentValue;
		$this->SERIE_NETBOOK->ImageAlt = $this->SERIE_NETBOOK->FldAlt();
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// N° TIKET
		$this->NB0_TIKET->ViewValue = $this->NB0_TIKET->CurrentValue;
		$this->NB0_TIKET->ImageAlt = $this->NB0_TIKET->FldAlt();
		$this->NB0_TIKET->ViewCustomAttributes = "";

		// PROBLEMA
		$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
		if (strval($this->PROBLEMA->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->PROBLEMA->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->PROBLEMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
			}
		} else {
			$this->PROBLEMA->ViewValue = NULL;
		}
		$this->PROBLEMA->ViewCustomAttributes = "";

			// CUE
			$this->CUE->LinkCustomAttributes = "";
			$this->CUE->HrefValue = "";
			$this->CUE->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

			// DEPARTAMENTO
			$this->DEPARTAMENTO->LinkCustomAttributes = "";
			$this->DEPARTAMENTO->HrefValue = "";
			$this->DEPARTAMENTO->TooltipValue = "";

			// LOCALIDAD
			$this->LOCALIDAD->LinkCustomAttributes = "";
			$this->LOCALIDAD->HrefValue = "";
			$this->LOCALIDAD->TooltipValue = "";

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->LinkCustomAttributes = "";
			$this->SERIE_NETBOOK->HrefValue = "";
			$this->SERIE_NETBOOK->TooltipValue = "";

			// N° TIKET
			$this->NB0_TIKET->LinkCustomAttributes = "";
			$this->NB0_TIKET->HrefValue = "";
			$this->NB0_TIKET->TooltipValue = "";

			// PROBLEMA
			$this->PROBLEMA->LinkCustomAttributes = "";
			$this->PROBLEMA->HrefValue = "";
			$this->PROBLEMA->TooltipValue = "";
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->CUE->AdvancedSearch->Load();
		$this->Sigla->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
		$this->DEPARTAMENTO->AdvancedSearch->Load();
		$this->LOCALIDAD->AdvancedSearch->Load();
		$this->SERIE_NETBOOK->AdvancedSearch->Load();
		$this->NB0_TIKET->AdvancedSearch->Load();
		$this->PROBLEMA->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
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
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_pedido_st\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pedido_st',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpedido_stlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Doc->Export();
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
if (!isset($pedido_st_list)) $pedido_st_list = new cpedido_st_list();

// Page init
$pedido_st_list->Page_Init();

// Page main
$pedido_st_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pedido_st_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pedido_st->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpedido_stlist = new ew_Form("fpedido_stlist", "list");
fpedido_stlist.FormKeyCountName = '<?php echo $pedido_st_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpedido_stlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpedido_stlist.ValidateRequired = true;
<?php } else { ?>
fpedido_stlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpedido_stlist.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};
fpedido_stlist.Lists["x_DEPARTAMENTO"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpedido_stlist.Lists["x_LOCALIDAD"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fpedido_stlist.Lists["x_PROBLEMA"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};

// Form object for search
var CurrentSearchForm = fpedido_stlistsrch = new ew_Form("fpedido_stlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pedido_st->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pedido_st->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($pedido_st_list->TotalRecs > 0 && $pedido_st_list->ExportOptions->Visible()) { ?>
<?php $pedido_st_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_st_list->SearchOptions->Visible()) { ?>
<?php $pedido_st_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_st_list->FilterOptions->Visible()) { ?>
<?php $pedido_st_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_st->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $pedido_st_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pedido_st_list->TotalRecs <= 0)
			$pedido_st_list->TotalRecs = $pedido_st->SelectRecordCount();
	} else {
		if (!$pedido_st_list->Recordset && ($pedido_st_list->Recordset = $pedido_st_list->LoadRecordset()))
			$pedido_st_list->TotalRecs = $pedido_st_list->Recordset->RecordCount();
	}
	$pedido_st_list->StartRec = 1;
	if ($pedido_st_list->DisplayRecs <= 0 || ($pedido_st->Export <> "" && $pedido_st->ExportAll)) // Display all records
		$pedido_st_list->DisplayRecs = $pedido_st_list->TotalRecs;
	if (!($pedido_st->Export <> "" && $pedido_st->ExportAll))
		$pedido_st_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pedido_st_list->Recordset = $pedido_st_list->LoadRecordset($pedido_st_list->StartRec-1, $pedido_st_list->DisplayRecs);

	// Set no record found message
	if ($pedido_st->CurrentAction == "" && $pedido_st_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pedido_st_list->setWarningMessage(ew_DeniedMsg());
		if ($pedido_st_list->SearchWhere == "0=101")
			$pedido_st_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pedido_st_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pedido_st_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($pedido_st->Export == "" && $pedido_st->CurrentAction == "") { ?>
<form name="fpedido_stlistsrch" id="fpedido_stlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pedido_st_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpedido_stlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pedido_st">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pedido_st_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pedido_st_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pedido_st_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pedido_st_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pedido_st_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pedido_st_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pedido_st_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $pedido_st_list->ShowPageHeader(); ?>
<?php
$pedido_st_list->ShowMessage();
?>
<?php if ($pedido_st_list->TotalRecs > 0 || $pedido_st->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid pedido_st">
<?php if ($pedido_st->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($pedido_st->CurrentAction <> "gridadd" && $pedido_st->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pedido_st_list->Pager)) $pedido_st_list->Pager = new cPrevNextPager($pedido_st_list->StartRec, $pedido_st_list->DisplayRecs, $pedido_st_list->TotalRecs) ?>
<?php if ($pedido_st_list->Pager->RecordCount > 0 && $pedido_st_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pedido_st_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pedido_st_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pedido_st_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pedido_st_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pedido_st_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pedido_st_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pedido_st_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pedido_st_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pedido_st_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_st_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpedido_stlist" id="fpedido_stlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pedido_st_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pedido_st_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pedido_st">
<div id="gmp_pedido_st" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($pedido_st_list->TotalRecs > 0) { ?>
<table id="tbl_pedido_stlist" class="table ewTable">
<?php echo $pedido_st->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$pedido_st_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pedido_st_list->RenderListOptions();

// Render list options (header, left)
$pedido_st_list->ListOptions->Render("header", "left");
?>
<?php if ($pedido_st->CUE->Visible) { // CUE ?>
	<?php if ($pedido_st->SortUrl($pedido_st->CUE) == "") { ?>
		<th data-name="CUE"><div id="elh_pedido_st_CUE" class="pedido_st_CUE"><div class="ewTableHeaderCaption"><?php echo $pedido_st->CUE->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CUE"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->CUE) ?>',1);"><div id="elh_pedido_st_CUE" class="pedido_st_CUE">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->CUE->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->CUE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->CUE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->Sigla->Visible) { // Sigla ?>
	<?php if ($pedido_st->SortUrl($pedido_st->Sigla) == "") { ?>
		<th data-name="Sigla"><div id="elh_pedido_st_Sigla" class="pedido_st_Sigla"><div class="ewTableHeaderCaption"><?php echo $pedido_st->Sigla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sigla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->Sigla) ?>',1);"><div id="elh_pedido_st_Sigla" class="pedido_st_Sigla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->Sigla->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->Sigla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->Sigla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->Id_Zona->Visible) { // Id_Zona ?>
	<?php if ($pedido_st->SortUrl($pedido_st->Id_Zona) == "") { ?>
		<th data-name="Id_Zona"><div id="elh_pedido_st_Id_Zona" class="pedido_st_Id_Zona"><div class="ewTableHeaderCaption"><?php echo $pedido_st->Id_Zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Zona"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->Id_Zona) ?>',1);"><div id="elh_pedido_st_Id_Zona" class="pedido_st_Id_Zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->Id_Zona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->Id_Zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->Id_Zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->DEPARTAMENTO->Visible) { // DEPARTAMENTO ?>
	<?php if ($pedido_st->SortUrl($pedido_st->DEPARTAMENTO) == "") { ?>
		<th data-name="DEPARTAMENTO"><div id="elh_pedido_st_DEPARTAMENTO" class="pedido_st_DEPARTAMENTO"><div class="ewTableHeaderCaption"><?php echo $pedido_st->DEPARTAMENTO->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DEPARTAMENTO"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->DEPARTAMENTO) ?>',1);"><div id="elh_pedido_st_DEPARTAMENTO" class="pedido_st_DEPARTAMENTO">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->DEPARTAMENTO->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->DEPARTAMENTO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->DEPARTAMENTO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->LOCALIDAD->Visible) { // LOCALIDAD ?>
	<?php if ($pedido_st->SortUrl($pedido_st->LOCALIDAD) == "") { ?>
		<th data-name="LOCALIDAD"><div id="elh_pedido_st_LOCALIDAD" class="pedido_st_LOCALIDAD"><div class="ewTableHeaderCaption"><?php echo $pedido_st->LOCALIDAD->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LOCALIDAD"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->LOCALIDAD) ?>',1);"><div id="elh_pedido_st_LOCALIDAD" class="pedido_st_LOCALIDAD">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->LOCALIDAD->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->LOCALIDAD->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->LOCALIDAD->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->SERIE_NETBOOK->Visible) { // SERIE NETBOOK ?>
	<?php if ($pedido_st->SortUrl($pedido_st->SERIE_NETBOOK) == "") { ?>
		<th data-name="SERIE_NETBOOK"><div id="elh_pedido_st_SERIE_NETBOOK" class="pedido_st_SERIE_NETBOOK"><div class="ewTableHeaderCaption"><?php echo $pedido_st->SERIE_NETBOOK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SERIE_NETBOOK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->SERIE_NETBOOK) ?>',1);"><div id="elh_pedido_st_SERIE_NETBOOK" class="pedido_st_SERIE_NETBOOK">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->SERIE_NETBOOK->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->SERIE_NETBOOK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->SERIE_NETBOOK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->NB0_TIKET->Visible) { // N° TIKET ?>
	<?php if ($pedido_st->SortUrl($pedido_st->NB0_TIKET) == "") { ?>
		<th data-name="NB0_TIKET"><div id="elh_pedido_st_NB0_TIKET" class="pedido_st_NB0_TIKET"><div class="ewTableHeaderCaption"><?php echo $pedido_st->NB0_TIKET->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NB0_TIKET"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->NB0_TIKET) ?>',1);"><div id="elh_pedido_st_NB0_TIKET" class="pedido_st_NB0_TIKET">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->NB0_TIKET->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->NB0_TIKET->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->NB0_TIKET->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_st->PROBLEMA->Visible) { // PROBLEMA ?>
	<?php if ($pedido_st->SortUrl($pedido_st->PROBLEMA) == "") { ?>
		<th data-name="PROBLEMA"><div id="elh_pedido_st_PROBLEMA" class="pedido_st_PROBLEMA"><div class="ewTableHeaderCaption"><?php echo $pedido_st->PROBLEMA->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PROBLEMA"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_st->SortUrl($pedido_st->PROBLEMA) ?>',1);"><div id="elh_pedido_st_PROBLEMA" class="pedido_st_PROBLEMA">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_st->PROBLEMA->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_st->PROBLEMA->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_st->PROBLEMA->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pedido_st_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pedido_st->ExportAll && $pedido_st->Export <> "") {
	$pedido_st_list->StopRec = $pedido_st_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pedido_st_list->TotalRecs > $pedido_st_list->StartRec + $pedido_st_list->DisplayRecs - 1)
		$pedido_st_list->StopRec = $pedido_st_list->StartRec + $pedido_st_list->DisplayRecs - 1;
	else
		$pedido_st_list->StopRec = $pedido_st_list->TotalRecs;
}
$pedido_st_list->RecCnt = $pedido_st_list->StartRec - 1;
if ($pedido_st_list->Recordset && !$pedido_st_list->Recordset->EOF) {
	$pedido_st_list->Recordset->MoveFirst();
	$bSelectLimit = $pedido_st_list->UseSelectLimit;
	if (!$bSelectLimit && $pedido_st_list->StartRec > 1)
		$pedido_st_list->Recordset->Move($pedido_st_list->StartRec - 1);
} elseif (!$pedido_st->AllowAddDeleteRow && $pedido_st_list->StopRec == 0) {
	$pedido_st_list->StopRec = $pedido_st->GridAddRowCount;
}

// Initialize aggregate
$pedido_st->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pedido_st->ResetAttrs();
$pedido_st_list->RenderRow();
while ($pedido_st_list->RecCnt < $pedido_st_list->StopRec) {
	$pedido_st_list->RecCnt++;
	if (intval($pedido_st_list->RecCnt) >= intval($pedido_st_list->StartRec)) {
		$pedido_st_list->RowCnt++;

		// Set up key count
		$pedido_st_list->KeyCount = $pedido_st_list->RowIndex;

		// Init row class and style
		$pedido_st->ResetAttrs();
		$pedido_st->CssClass = "";
		if ($pedido_st->CurrentAction == "gridadd") {
		} else {
			$pedido_st_list->LoadRowValues($pedido_st_list->Recordset); // Load row values
		}
		$pedido_st->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pedido_st->RowAttrs = array_merge($pedido_st->RowAttrs, array('data-rowindex'=>$pedido_st_list->RowCnt, 'id'=>'r' . $pedido_st_list->RowCnt . '_pedido_st', 'data-rowtype'=>$pedido_st->RowType));

		// Render row
		$pedido_st_list->RenderRow();

		// Render list options
		$pedido_st_list->RenderListOptions();
?>
	<tr<?php echo $pedido_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pedido_st_list->ListOptions->Render("body", "left", $pedido_st_list->RowCnt);
?>
	<?php if ($pedido_st->CUE->Visible) { // CUE ?>
		<td data-name="CUE"<?php echo $pedido_st->CUE->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_CUE" class="pedido_st_CUE">
<span<?php echo $pedido_st->CUE->ViewAttributes() ?>>
<?php echo $pedido_st->CUE->ListViewValue() ?></span>
</span>
<a id="<?php echo $pedido_st_list->PageObjName . "_row_" . $pedido_st_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pedido_st->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla"<?php echo $pedido_st->Sigla->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_Sigla" class="pedido_st_Sigla">
<span<?php echo $pedido_st->Sigla->ViewAttributes() ?>>
<?php echo $pedido_st->Sigla->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_st->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona"<?php echo $pedido_st->Id_Zona->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_Id_Zona" class="pedido_st_Id_Zona">
<span<?php echo $pedido_st->Id_Zona->ViewAttributes() ?>>
<?php echo $pedido_st->Id_Zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_st->DEPARTAMENTO->Visible) { // DEPARTAMENTO ?>
		<td data-name="DEPARTAMENTO"<?php echo $pedido_st->DEPARTAMENTO->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_DEPARTAMENTO" class="pedido_st_DEPARTAMENTO">
<span<?php echo $pedido_st->DEPARTAMENTO->ViewAttributes() ?>>
<?php echo $pedido_st->DEPARTAMENTO->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_st->LOCALIDAD->Visible) { // LOCALIDAD ?>
		<td data-name="LOCALIDAD"<?php echo $pedido_st->LOCALIDAD->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_LOCALIDAD" class="pedido_st_LOCALIDAD">
<span<?php echo $pedido_st->LOCALIDAD->ViewAttributes() ?>>
<?php echo $pedido_st->LOCALIDAD->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_st->SERIE_NETBOOK->Visible) { // SERIE NETBOOK ?>
		<td data-name="SERIE_NETBOOK"<?php echo $pedido_st->SERIE_NETBOOK->CellAttributes() ?>>
<div id="orig<?php echo $pedido_st_list->RowCnt ?>_pedido_st_SERIE_NETBOOK" class="hide">
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_SERIE_NETBOOK" class="pedido_st_SERIE_NETBOOK">
<span>
<?php echo ew_GetImgViewTag($pedido_st->SERIE_NETBOOK, $pedido_st->SERIE_NETBOOK->ListViewValue()) ?></span>
</span>
</div>
<?php echo ew_ShowBarCode($pedido_st->SERIE_NETBOOK->CurrentValue, 'CODE128', 70) ?>
</td>
	<?php } ?>
	<?php if ($pedido_st->NB0_TIKET->Visible) { // N° TIKET ?>
		<td data-name="NB0_TIKET"<?php echo $pedido_st->NB0_TIKET->CellAttributes() ?>>
<div id="orig<?php echo $pedido_st_list->RowCnt ?>_pedido_st_NB0_TIKET" class="hide">
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_NB0_TIKET" class="pedido_st_NB0_TIKET">
<span>
<?php echo ew_GetImgViewTag($pedido_st->NB0_TIKET, $pedido_st->NB0_TIKET->ListViewValue()) ?></span>
</span>
</div>
<?php echo ew_ShowBarCode($pedido_st->NB0_TIKET->CurrentValue, 'CODE128', 70) ?>
</td>
	<?php } ?>
	<?php if ($pedido_st->PROBLEMA->Visible) { // PROBLEMA ?>
		<td data-name="PROBLEMA"<?php echo $pedido_st->PROBLEMA->CellAttributes() ?>>
<span id="el<?php echo $pedido_st_list->RowCnt ?>_pedido_st_PROBLEMA" class="pedido_st_PROBLEMA">
<span<?php echo $pedido_st->PROBLEMA->ViewAttributes() ?>>
<?php echo $pedido_st->PROBLEMA->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pedido_st_list->ListOptions->Render("body", "right", $pedido_st_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pedido_st->CurrentAction <> "gridadd")
		$pedido_st_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pedido_st->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pedido_st_list->Recordset)
	$pedido_st_list->Recordset->Close();
?>
<?php if ($pedido_st->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($pedido_st->CurrentAction <> "gridadd" && $pedido_st->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pedido_st_list->Pager)) $pedido_st_list->Pager = new cPrevNextPager($pedido_st_list->StartRec, $pedido_st_list->DisplayRecs, $pedido_st_list->TotalRecs) ?>
<?php if ($pedido_st_list->Pager->RecordCount > 0 && $pedido_st_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pedido_st_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pedido_st_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pedido_st_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pedido_st_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pedido_st_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pedido_st_list->PageUrl() ?>start=<?php echo $pedido_st_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pedido_st_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pedido_st_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pedido_st_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pedido_st_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_st_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pedido_st_list->TotalRecs == 0 && $pedido_st->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_st_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pedido_st->Export == "") { ?>
<script type="text/javascript">
fpedido_stlistsrch.FilterList = <?php echo $pedido_st_list->GetFilterList() ?>;
fpedido_stlistsrch.Init();
fpedido_stlist.Init();
</script>
<?php } ?>
<?php
$pedido_st_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pedido_st->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pedido_st_list->Page_Terminate();
?>
