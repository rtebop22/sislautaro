<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "todas_atencionesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$todas_atenciones_list = NULL; // Initialize page object first

class ctodas_atenciones_list extends ctodas_atenciones {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'todas atenciones';

	// Page object name
	var $PageObjName = 'todas_atenciones_list';

	// Grid form hidden field names
	var $FormName = 'ftodas_atencioneslist';
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

		// Table object (todas_atenciones)
		if (!isset($GLOBALS["todas_atenciones"]) || get_class($GLOBALS["todas_atenciones"]) == "ctodas_atenciones") {
			$GLOBALS["todas_atenciones"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["todas_atenciones"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "todas_atencionesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "todas_atencionesdelete.php";
		$this->MultiUpdateUrl = "todas_atencionesupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'todas atenciones', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftodas_atencioneslistsrch";

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
		$this->Nro_Atenc_->SetVisibility();
		$this->Nro_Atenc_->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->CUE->SetVisibility();
		$this->Escuela->SetVisibility();
		$this->Nro_Serie->SetVisibility();
		$this->Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Curso->SetVisibility();
		$this->Division->SetVisibility();
		$this->Fecha_Entrada->SetVisibility();
		$this->Falla->SetVisibility();
		$this->Problema->SetVisibility();
		$this->Solucion->SetVisibility();
		$this->Estado->SetVisibility();
		$this->Fecha_Actualiz_->SetVisibility();
		$this->Fecha_Actualiz_->Visible = !$this->IsAddOrEdit();

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
		global $EW_EXPORT, $todas_atenciones;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($todas_atenciones);
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
	var $DisplayRecs = 30;
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
			$this->DisplayRecs = 30; // Load default
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
		if (count($arrKeyFlds) >= 4) {
			$this->Nro_Atenc_->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Nro_Atenc_->FormValue))
				return FALSE;
			$this->Item->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->Item->FormValue))
				return FALSE;
			$this->CUE->setFormValue($arrKeyFlds[2]);
			$this->Dni->setFormValue($arrKeyFlds[3]);
			if (!is_numeric($this->Dni->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "ftodas_atencioneslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Atenc_->AdvancedSearch->ToJSON(), ","); // Field Nro Atenc.
		$sFilterList = ew_Concat($sFilterList, $this->Item->AdvancedSearch->ToJSON(), ","); // Field Item
		$sFilterList = ew_Concat($sFilterList, $this->CUE->AdvancedSearch->ToJSON(), ","); // Field CUE
		$sFilterList = ew_Concat($sFilterList, $this->Escuela->AdvancedSearch->ToJSON(), ","); // Field Escuela
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Serie->AdvancedSearch->ToJSON(), ","); // Field Nro Serie
		$sFilterList = ew_Concat($sFilterList, $this->Titular->AdvancedSearch->ToJSON(), ","); // Field Titular
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
		$sFilterList = ew_Concat($sFilterList, $this->Curso->AdvancedSearch->ToJSON(), ","); // Field Curso
		$sFilterList = ew_Concat($sFilterList, $this->Division->AdvancedSearch->ToJSON(), ","); // Field Division
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Entrada->AdvancedSearch->ToJSON(), ","); // Field Fecha Entrada
		$sFilterList = ew_Concat($sFilterList, $this->Falla->AdvancedSearch->ToJSON(), ","); // Field Falla
		$sFilterList = ew_Concat($sFilterList, $this->Problema->AdvancedSearch->ToJSON(), ","); // Field Problema
		$sFilterList = ew_Concat($sFilterList, $this->Solucion->AdvancedSearch->ToJSON(), ","); // Field Solucion
		$sFilterList = ew_Concat($sFilterList, $this->Estado->AdvancedSearch->ToJSON(), ","); // Field Estado
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Actualiz_->AdvancedSearch->ToJSON(), ","); // Field Fecha Actualiz.
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftodas_atencioneslistsrch", $filters);
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

		// Field Nro Atenc.
		$this->Nro_Atenc_->AdvancedSearch->SearchValue = @$filter["x_Nro_Atenc_"];
		$this->Nro_Atenc_->AdvancedSearch->SearchOperator = @$filter["z_Nro_Atenc_"];
		$this->Nro_Atenc_->AdvancedSearch->SearchCondition = @$filter["v_Nro_Atenc_"];
		$this->Nro_Atenc_->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Atenc_"];
		$this->Nro_Atenc_->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Atenc_"];
		$this->Nro_Atenc_->AdvancedSearch->Save();

		// Field Item
		$this->Item->AdvancedSearch->SearchValue = @$filter["x_Item"];
		$this->Item->AdvancedSearch->SearchOperator = @$filter["z_Item"];
		$this->Item->AdvancedSearch->SearchCondition = @$filter["v_Item"];
		$this->Item->AdvancedSearch->SearchValue2 = @$filter["y_Item"];
		$this->Item->AdvancedSearch->SearchOperator2 = @$filter["w_Item"];
		$this->Item->AdvancedSearch->Save();

		// Field CUE
		$this->CUE->AdvancedSearch->SearchValue = @$filter["x_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator = @$filter["z_CUE"];
		$this->CUE->AdvancedSearch->SearchCondition = @$filter["v_CUE"];
		$this->CUE->AdvancedSearch->SearchValue2 = @$filter["y_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator2 = @$filter["w_CUE"];
		$this->CUE->AdvancedSearch->Save();

		// Field Escuela
		$this->Escuela->AdvancedSearch->SearchValue = @$filter["x_Escuela"];
		$this->Escuela->AdvancedSearch->SearchOperator = @$filter["z_Escuela"];
		$this->Escuela->AdvancedSearch->SearchCondition = @$filter["v_Escuela"];
		$this->Escuela->AdvancedSearch->SearchValue2 = @$filter["y_Escuela"];
		$this->Escuela->AdvancedSearch->SearchOperator2 = @$filter["w_Escuela"];
		$this->Escuela->AdvancedSearch->Save();

		// Field Nro Serie
		$this->Nro_Serie->AdvancedSearch->SearchValue = @$filter["x_Nro_Serie"];
		$this->Nro_Serie->AdvancedSearch->SearchOperator = @$filter["z_Nro_Serie"];
		$this->Nro_Serie->AdvancedSearch->SearchCondition = @$filter["v_Nro_Serie"];
		$this->Nro_Serie->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Serie"];
		$this->Nro_Serie->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Serie"];
		$this->Nro_Serie->AdvancedSearch->Save();

		// Field Titular
		$this->Titular->AdvancedSearch->SearchValue = @$filter["x_Titular"];
		$this->Titular->AdvancedSearch->SearchOperator = @$filter["z_Titular"];
		$this->Titular->AdvancedSearch->SearchCondition = @$filter["v_Titular"];
		$this->Titular->AdvancedSearch->SearchValue2 = @$filter["y_Titular"];
		$this->Titular->AdvancedSearch->SearchOperator2 = @$filter["w_Titular"];
		$this->Titular->AdvancedSearch->Save();

		// Field Dni
		$this->Dni->AdvancedSearch->SearchValue = @$filter["x_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator = @$filter["z_Dni"];
		$this->Dni->AdvancedSearch->SearchCondition = @$filter["v_Dni"];
		$this->Dni->AdvancedSearch->SearchValue2 = @$filter["y_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator2 = @$filter["w_Dni"];
		$this->Dni->AdvancedSearch->Save();

		// Field Curso
		$this->Curso->AdvancedSearch->SearchValue = @$filter["x_Curso"];
		$this->Curso->AdvancedSearch->SearchOperator = @$filter["z_Curso"];
		$this->Curso->AdvancedSearch->SearchCondition = @$filter["v_Curso"];
		$this->Curso->AdvancedSearch->SearchValue2 = @$filter["y_Curso"];
		$this->Curso->AdvancedSearch->SearchOperator2 = @$filter["w_Curso"];
		$this->Curso->AdvancedSearch->Save();

		// Field Division
		$this->Division->AdvancedSearch->SearchValue = @$filter["x_Division"];
		$this->Division->AdvancedSearch->SearchOperator = @$filter["z_Division"];
		$this->Division->AdvancedSearch->SearchCondition = @$filter["v_Division"];
		$this->Division->AdvancedSearch->SearchValue2 = @$filter["y_Division"];
		$this->Division->AdvancedSearch->SearchOperator2 = @$filter["w_Division"];
		$this->Division->AdvancedSearch->Save();

		// Field Fecha Entrada
		$this->Fecha_Entrada->AdvancedSearch->SearchValue = @$filter["x_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Entrada"];
		$this->Fecha_Entrada->AdvancedSearch->Save();

		// Field Falla
		$this->Falla->AdvancedSearch->SearchValue = @$filter["x_Falla"];
		$this->Falla->AdvancedSearch->SearchOperator = @$filter["z_Falla"];
		$this->Falla->AdvancedSearch->SearchCondition = @$filter["v_Falla"];
		$this->Falla->AdvancedSearch->SearchValue2 = @$filter["y_Falla"];
		$this->Falla->AdvancedSearch->SearchOperator2 = @$filter["w_Falla"];
		$this->Falla->AdvancedSearch->Save();

		// Field Problema
		$this->Problema->AdvancedSearch->SearchValue = @$filter["x_Problema"];
		$this->Problema->AdvancedSearch->SearchOperator = @$filter["z_Problema"];
		$this->Problema->AdvancedSearch->SearchCondition = @$filter["v_Problema"];
		$this->Problema->AdvancedSearch->SearchValue2 = @$filter["y_Problema"];
		$this->Problema->AdvancedSearch->SearchOperator2 = @$filter["w_Problema"];
		$this->Problema->AdvancedSearch->Save();

		// Field Solucion
		$this->Solucion->AdvancedSearch->SearchValue = @$filter["x_Solucion"];
		$this->Solucion->AdvancedSearch->SearchOperator = @$filter["z_Solucion"];
		$this->Solucion->AdvancedSearch->SearchCondition = @$filter["v_Solucion"];
		$this->Solucion->AdvancedSearch->SearchValue2 = @$filter["y_Solucion"];
		$this->Solucion->AdvancedSearch->SearchOperator2 = @$filter["w_Solucion"];
		$this->Solucion->AdvancedSearch->Save();

		// Field Estado
		$this->Estado->AdvancedSearch->SearchValue = @$filter["x_Estado"];
		$this->Estado->AdvancedSearch->SearchOperator = @$filter["z_Estado"];
		$this->Estado->AdvancedSearch->SearchCondition = @$filter["v_Estado"];
		$this->Estado->AdvancedSearch->SearchValue2 = @$filter["y_Estado"];
		$this->Estado->AdvancedSearch->SearchOperator2 = @$filter["w_Estado"];
		$this->Estado->AdvancedSearch->Save();

		// Field Fecha Actualiz.
		$this->Fecha_Actualiz_->AdvancedSearch->SearchValue = @$filter["x_Fecha_Actualiz_"];
		$this->Fecha_Actualiz_->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Actualiz_"];
		$this->Fecha_Actualiz_->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Actualiz_"];
		$this->Fecha_Actualiz_->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Actualiz_"];
		$this->Fecha_Actualiz_->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Actualiz_"];
		$this->Fecha_Actualiz_->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Nro_Atenc_, $Default, FALSE); // Nro Atenc.
		$this->BuildSearchSql($sWhere, $this->Item, $Default, FALSE); // Item
		$this->BuildSearchSql($sWhere, $this->CUE, $Default, FALSE); // CUE
		$this->BuildSearchSql($sWhere, $this->Escuela, $Default, FALSE); // Escuela
		$this->BuildSearchSql($sWhere, $this->Nro_Serie, $Default, FALSE); // Nro Serie
		$this->BuildSearchSql($sWhere, $this->Titular, $Default, FALSE); // Titular
		$this->BuildSearchSql($sWhere, $this->Dni, $Default, FALSE); // Dni
		$this->BuildSearchSql($sWhere, $this->Curso, $Default, FALSE); // Curso
		$this->BuildSearchSql($sWhere, $this->Division, $Default, FALSE); // Division
		$this->BuildSearchSql($sWhere, $this->Fecha_Entrada, $Default, FALSE); // Fecha Entrada
		$this->BuildSearchSql($sWhere, $this->Falla, $Default, FALSE); // Falla
		$this->BuildSearchSql($sWhere, $this->Problema, $Default, FALSE); // Problema
		$this->BuildSearchSql($sWhere, $this->Solucion, $Default, FALSE); // Solucion
		$this->BuildSearchSql($sWhere, $this->Estado, $Default, FALSE); // Estado
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualiz_, $Default, FALSE); // Fecha Actualiz.

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Nro_Atenc_->AdvancedSearch->Save(); // Nro Atenc.
			$this->Item->AdvancedSearch->Save(); // Item
			$this->CUE->AdvancedSearch->Save(); // CUE
			$this->Escuela->AdvancedSearch->Save(); // Escuela
			$this->Nro_Serie->AdvancedSearch->Save(); // Nro Serie
			$this->Titular->AdvancedSearch->Save(); // Titular
			$this->Dni->AdvancedSearch->Save(); // Dni
			$this->Curso->AdvancedSearch->Save(); // Curso
			$this->Division->AdvancedSearch->Save(); // Division
			$this->Fecha_Entrada->AdvancedSearch->Save(); // Fecha Entrada
			$this->Falla->AdvancedSearch->Save(); // Falla
			$this->Problema->AdvancedSearch->Save(); // Problema
			$this->Solucion->AdvancedSearch->Save(); // Solucion
			$this->Estado->AdvancedSearch->Save(); // Estado
			$this->Fecha_Actualiz_->AdvancedSearch->Save(); // Fecha Actualiz.
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
		$this->BuildBasicSearchSQL($sWhere, $this->Nro_Atenc_, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CUE, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Escuela, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nro_Serie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Titular, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Curso, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Division, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Falla, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Problema, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Solucion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Estado, $arKeywords, $type);
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
		if ($this->Nro_Atenc_->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Item->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->CUE->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Escuela->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nro_Serie->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Titular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Curso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Division->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Entrada->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Falla->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Problema->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Solucion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Actualiz_->AdvancedSearch->IssetSession())
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
		$this->Nro_Atenc_->AdvancedSearch->UnsetSession();
		$this->Item->AdvancedSearch->UnsetSession();
		$this->CUE->AdvancedSearch->UnsetSession();
		$this->Escuela->AdvancedSearch->UnsetSession();
		$this->Nro_Serie->AdvancedSearch->UnsetSession();
		$this->Titular->AdvancedSearch->UnsetSession();
		$this->Dni->AdvancedSearch->UnsetSession();
		$this->Curso->AdvancedSearch->UnsetSession();
		$this->Division->AdvancedSearch->UnsetSession();
		$this->Fecha_Entrada->AdvancedSearch->UnsetSession();
		$this->Falla->AdvancedSearch->UnsetSession();
		$this->Problema->AdvancedSearch->UnsetSession();
		$this->Solucion->AdvancedSearch->UnsetSession();
		$this->Estado->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualiz_->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Nro_Atenc_->AdvancedSearch->Load();
		$this->Item->AdvancedSearch->Load();
		$this->CUE->AdvancedSearch->Load();
		$this->Escuela->AdvancedSearch->Load();
		$this->Nro_Serie->AdvancedSearch->Load();
		$this->Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Curso->AdvancedSearch->Load();
		$this->Division->AdvancedSearch->Load();
		$this->Fecha_Entrada->AdvancedSearch->Load();
		$this->Falla->AdvancedSearch->Load();
		$this->Problema->AdvancedSearch->Load();
		$this->Solucion->AdvancedSearch->Load();
		$this->Estado->AdvancedSearch->Load();
		$this->Fecha_Actualiz_->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Nro_Atenc_); // Nro Atenc.
			$this->UpdateSort($this->CUE); // CUE
			$this->UpdateSort($this->Escuela); // Escuela
			$this->UpdateSort($this->Nro_Serie); // Nro Serie
			$this->UpdateSort($this->Titular); // Titular
			$this->UpdateSort($this->Dni); // Dni
			$this->UpdateSort($this->Curso); // Curso
			$this->UpdateSort($this->Division); // Division
			$this->UpdateSort($this->Fecha_Entrada); // Fecha Entrada
			$this->UpdateSort($this->Falla); // Falla
			$this->UpdateSort($this->Problema); // Problema
			$this->UpdateSort($this->Solucion); // Solucion
			$this->UpdateSort($this->Estado); // Estado
			$this->UpdateSort($this->Fecha_Actualiz_); // Fecha Actualiz.
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
				$this->Nro_Atenc_->setSort("");
				$this->CUE->setSort("");
				$this->Escuela->setSort("");
				$this->Nro_Serie->setSort("");
				$this->Titular->setSort("");
				$this->Dni->setSort("");
				$this->Curso->setSort("");
				$this->Division->setSort("");
				$this->Fecha_Entrada->setSort("");
				$this->Falla->setSort("");
				$this->Problema->setSort("");
				$this->Solucion->setSort("");
				$this->Estado->setSort("");
				$this->Fecha_Actualiz_->setSort("");
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
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Nro_Atenc_->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Item->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->CUE->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Dni->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftodas_atencioneslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftodas_atencioneslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftodas_atencioneslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftodas_atencioneslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

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
		// Nro Atenc.

		$this->Nro_Atenc_->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nro_Atenc_"]);
		if ($this->Nro_Atenc_->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nro_Atenc_->AdvancedSearch->SearchOperator = @$_GET["z_Nro_Atenc_"];

		// Item
		$this->Item->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Item"]);
		if ($this->Item->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Item->AdvancedSearch->SearchOperator = @$_GET["z_Item"];

		// CUE
		$this->CUE->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_CUE"]);
		if ($this->CUE->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->CUE->AdvancedSearch->SearchOperator = @$_GET["z_CUE"];

		// Escuela
		$this->Escuela->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Escuela"]);
		if ($this->Escuela->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Escuela->AdvancedSearch->SearchOperator = @$_GET["z_Escuela"];

		// Nro Serie
		$this->Nro_Serie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nro_Serie"]);
		if ($this->Nro_Serie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nro_Serie->AdvancedSearch->SearchOperator = @$_GET["z_Nro_Serie"];

		// Titular
		$this->Titular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Titular"]);
		if ($this->Titular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Titular->AdvancedSearch->SearchOperator = @$_GET["z_Titular"];

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni"]);
		if ($this->Dni->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni->AdvancedSearch->SearchOperator = @$_GET["z_Dni"];

		// Curso
		$this->Curso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Curso"]);
		if ($this->Curso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Curso->AdvancedSearch->SearchOperator = @$_GET["z_Curso"];

		// Division
		$this->Division->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Division"]);
		if ($this->Division->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Division->AdvancedSearch->SearchOperator = @$_GET["z_Division"];

		// Fecha Entrada
		$this->Fecha_Entrada->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Entrada"]);
		if ($this->Fecha_Entrada->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Entrada"];

		// Falla
		$this->Falla->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Falla"]);
		if ($this->Falla->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Falla->AdvancedSearch->SearchOperator = @$_GET["z_Falla"];

		// Problema
		$this->Problema->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Problema"]);
		if ($this->Problema->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Problema->AdvancedSearch->SearchOperator = @$_GET["z_Problema"];

		// Solucion
		$this->Solucion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Solucion"]);
		if ($this->Solucion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Solucion->AdvancedSearch->SearchOperator = @$_GET["z_Solucion"];

		// Estado
		$this->Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Estado"]);
		if ($this->Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Estado->AdvancedSearch->SearchOperator = @$_GET["z_Estado"];

		// Fecha Actualiz.
		$this->Fecha_Actualiz_->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Actualiz_"]);
		if ($this->Fecha_Actualiz_->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Actualiz_->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Actualiz_"];
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
		$this->Nro_Atenc_->setDbValue($rs->fields('Nro Atenc.'));
		$this->Item->setDbValue($rs->fields('Item'));
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Escuela->setDbValue($rs->fields('Escuela'));
		$this->Nro_Serie->setDbValue($rs->fields('Nro Serie'));
		$this->Titular->setDbValue($rs->fields('Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Curso->setDbValue($rs->fields('Curso'));
		$this->Division->setDbValue($rs->fields('Division'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha Entrada'));
		$this->Falla->setDbValue($rs->fields('Falla'));
		$this->Problema->setDbValue($rs->fields('Problema'));
		$this->Solucion->setDbValue($rs->fields('Solucion'));
		$this->Estado->setDbValue($rs->fields('Estado'));
		$this->Fecha_Actualiz_->setDbValue($rs->fields('Fecha Actualiz.'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Nro_Atenc_->DbValue = $row['Nro Atenc.'];
		$this->Item->DbValue = $row['Item'];
		$this->CUE->DbValue = $row['CUE'];
		$this->Escuela->DbValue = $row['Escuela'];
		$this->Nro_Serie->DbValue = $row['Nro Serie'];
		$this->Titular->DbValue = $row['Titular'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Curso->DbValue = $row['Curso'];
		$this->Division->DbValue = $row['Division'];
		$this->Fecha_Entrada->DbValue = $row['Fecha Entrada'];
		$this->Falla->DbValue = $row['Falla'];
		$this->Problema->DbValue = $row['Problema'];
		$this->Solucion->DbValue = $row['Solucion'];
		$this->Estado->DbValue = $row['Estado'];
		$this->Fecha_Actualiz_->DbValue = $row['Fecha Actualiz.'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Nro_Atenc_")) <> "")
			$this->Nro_Atenc_->CurrentValue = $this->getKey("Nro_Atenc_"); // Nro Atenc.
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("Item")) <> "")
			$this->Item->CurrentValue = $this->getKey("Item"); // Item
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("CUE")) <> "")
			$this->CUE->CurrentValue = $this->getKey("CUE"); // CUE
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("Dni")) <> "")
			$this->Dni->CurrentValue = $this->getKey("Dni"); // Dni
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
		// Nro Atenc.
		// Item
		// CUE
		// Escuela
		// Nro Serie
		// Titular
		// Dni
		// Curso
		// Division
		// Fecha Entrada
		// Falla
		// Problema
		// Solucion
		// Estado
		// Fecha Actualiz.

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nro Atenc.
		$this->Nro_Atenc_->ViewValue = $this->Nro_Atenc_->CurrentValue;
		$this->Nro_Atenc_->ViewCustomAttributes = "";

		// Item
		$this->Item->ViewValue = $this->Item->CurrentValue;
		$this->Item->ViewCustomAttributes = "";

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Escuela
		$this->Escuela->ViewValue = $this->Escuela->CurrentValue;
		$this->Escuela->ViewCustomAttributes = "";

		// Nro Serie
		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		if (strval($this->Nro_Serie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Nro_Serie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nro_Serie->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nro_Serie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nro_Serie->ViewValue = $this->Nro_Serie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
			}
		} else {
			$this->Nro_Serie->ViewValue = NULL;
		}
		$this->Nro_Serie->ViewCustomAttributes = "";

		// Titular
		$this->Titular->ViewValue = $this->Titular->CurrentValue;
		$this->Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Curso
		$this->Curso->ViewValue = $this->Curso->CurrentValue;
		$this->Curso->ViewCustomAttributes = "";

		// Division
		$this->Division->ViewValue = $this->Division->CurrentValue;
		$this->Division->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 0);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Falla
		if (strval($this->Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Falla->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Falla->ViewValue = $this->Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Falla->ViewValue = $this->Falla->CurrentValue;
			}
		} else {
			$this->Falla->ViewValue = NULL;
		}
		$this->Falla->ViewCustomAttributes = "";

		// Problema
		if (strval($this->Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Problema->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Problema->ViewValue = $this->Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Problema->ViewValue = $this->Problema->CurrentValue;
			}
		} else {
			$this->Problema->ViewValue = NULL;
		}
		$this->Problema->ViewCustomAttributes = "";

		// Solucion
		if (strval($this->Solucion->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Solucion->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Solucion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Solucion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Solucion->ViewValue = $this->Solucion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Solucion->ViewValue = $this->Solucion->CurrentValue;
			}
		} else {
			$this->Solucion->ViewValue = NULL;
		}
		$this->Solucion->ViewCustomAttributes = "";

		// Estado
		if (strval($this->Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Estado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado->ViewValue = $this->Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado->ViewValue = $this->Estado->CurrentValue;
			}
		} else {
			$this->Estado->ViewValue = NULL;
		}
		$this->Estado->ViewCustomAttributes = "";

		// Fecha Actualiz.
		$this->Fecha_Actualiz_->ViewValue = $this->Fecha_Actualiz_->CurrentValue;
		$this->Fecha_Actualiz_->ViewCustomAttributes = "";

			// Nro Atenc.
			$this->Nro_Atenc_->LinkCustomAttributes = "";
			$this->Nro_Atenc_->HrefValue = "";
			$this->Nro_Atenc_->TooltipValue = "";

			// CUE
			$this->CUE->LinkCustomAttributes = "";
			$this->CUE->HrefValue = "";
			$this->CUE->TooltipValue = "";

			// Escuela
			$this->Escuela->LinkCustomAttributes = "";
			$this->Escuela->HrefValue = "";
			$this->Escuela->TooltipValue = "";

			// Nro Serie
			$this->Nro_Serie->LinkCustomAttributes = "";
			$this->Nro_Serie->HrefValue = "";
			$this->Nro_Serie->TooltipValue = "";

			// Titular
			$this->Titular->LinkCustomAttributes = "";
			$this->Titular->HrefValue = "";
			$this->Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Curso
			$this->Curso->LinkCustomAttributes = "";
			$this->Curso->HrefValue = "";
			$this->Curso->TooltipValue = "";

			// Division
			$this->Division->LinkCustomAttributes = "";
			$this->Division->HrefValue = "";
			$this->Division->TooltipValue = "";

			// Fecha Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Falla
			$this->Falla->LinkCustomAttributes = "";
			$this->Falla->HrefValue = "";
			$this->Falla->TooltipValue = "";

			// Problema
			$this->Problema->LinkCustomAttributes = "";
			$this->Problema->HrefValue = "";
			$this->Problema->TooltipValue = "";

			// Solucion
			$this->Solucion->LinkCustomAttributes = "";
			$this->Solucion->HrefValue = "";
			$this->Solucion->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";

			// Fecha Actualiz.
			$this->Fecha_Actualiz_->LinkCustomAttributes = "";
			$this->Fecha_Actualiz_->HrefValue = "";
			$this->Fecha_Actualiz_->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Nro Atenc.
			$this->Nro_Atenc_->EditAttrs["class"] = "form-control";
			$this->Nro_Atenc_->EditCustomAttributes = "";
			$this->Nro_Atenc_->EditValue = ew_HtmlEncode($this->Nro_Atenc_->AdvancedSearch->SearchValue);
			$this->Nro_Atenc_->PlaceHolder = ew_RemoveHtml($this->Nro_Atenc_->FldCaption());

			// CUE
			$this->CUE->EditAttrs["class"] = "form-control";
			$this->CUE->EditCustomAttributes = "";
			$this->CUE->EditValue = ew_HtmlEncode($this->CUE->AdvancedSearch->SearchValue);
			$this->CUE->PlaceHolder = ew_RemoveHtml($this->CUE->FldCaption());

			// Escuela
			$this->Escuela->EditAttrs["class"] = "form-control";
			$this->Escuela->EditCustomAttributes = "";
			$this->Escuela->EditValue = ew_HtmlEncode($this->Escuela->AdvancedSearch->SearchValue);
			$this->Escuela->PlaceHolder = ew_RemoveHtml($this->Escuela->FldCaption());

			// Nro Serie
			$this->Nro_Serie->EditAttrs["class"] = "form-control";
			$this->Nro_Serie->EditCustomAttributes = "";
			$this->Nro_Serie->EditValue = ew_HtmlEncode($this->Nro_Serie->AdvancedSearch->SearchValue);
			$this->Nro_Serie->PlaceHolder = ew_RemoveHtml($this->Nro_Serie->FldCaption());

			// Titular
			$this->Titular->EditAttrs["class"] = "form-control";
			$this->Titular->EditCustomAttributes = "";
			$this->Titular->EditValue = ew_HtmlEncode($this->Titular->AdvancedSearch->SearchValue);
			$this->Titular->PlaceHolder = ew_RemoveHtml($this->Titular->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Curso
			$this->Curso->EditAttrs["class"] = "form-control";
			$this->Curso->EditCustomAttributes = "";
			$this->Curso->EditValue = ew_HtmlEncode($this->Curso->AdvancedSearch->SearchValue);
			$this->Curso->PlaceHolder = ew_RemoveHtml($this->Curso->FldCaption());

			// Division
			$this->Division->EditAttrs["class"] = "form-control";
			$this->Division->EditCustomAttributes = "";
			$this->Division->EditValue = ew_HtmlEncode($this->Division->AdvancedSearch->SearchValue);
			$this->Division->PlaceHolder = ew_RemoveHtml($this->Division->FldCaption());

			// Fecha Entrada
			$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
			$this->Fecha_Entrada->EditCustomAttributes = "";
			$this->Fecha_Entrada->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Entrada->AdvancedSearch->SearchValue, 0), 8));
			$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

			// Falla
			$this->Falla->EditAttrs["class"] = "form-control";
			$this->Falla->EditCustomAttributes = "";
			if (trim(strval($this->Falla->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Falla->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Falla->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Falla->EditValue = $arwrk;

			// Problema
			$this->Problema->EditAttrs["class"] = "form-control";
			$this->Problema->EditCustomAttributes = "";
			if (trim(strval($this->Problema->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Problema->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `problema`";
			$sWhereWrk = "";
			$this->Problema->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Problema->EditValue = $arwrk;

			// Solucion
			$this->Solucion->EditAttrs["class"] = "form-control";
			$this->Solucion->EditCustomAttributes = "";
			if (trim(strval($this->Solucion->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Solucion->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Solucion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Solucion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Solucion->EditValue = $arwrk;

			// Estado
			$this->Estado->EditAttrs["class"] = "form-control";
			$this->Estado->EditCustomAttributes = "";
			if (trim(strval($this->Estado->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Estado->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado->EditValue = $arwrk;

			// Fecha Actualiz.
			$this->Fecha_Actualiz_->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualiz_->EditCustomAttributes = "";
			$this->Fecha_Actualiz_->EditValue = ew_HtmlEncode(ew_UnFormatDateTime($this->Fecha_Actualiz_->AdvancedSearch->SearchValue, 0));
			$this->Fecha_Actualiz_->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualiz_->FldCaption());
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Nro_Atenc_->AdvancedSearch->Load();
		$this->Item->AdvancedSearch->Load();
		$this->CUE->AdvancedSearch->Load();
		$this->Escuela->AdvancedSearch->Load();
		$this->Nro_Serie->AdvancedSearch->Load();
		$this->Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Curso->AdvancedSearch->Load();
		$this->Division->AdvancedSearch->Load();
		$this->Fecha_Entrada->AdvancedSearch->Load();
		$this->Falla->AdvancedSearch->Load();
		$this->Problema->AdvancedSearch->Load();
		$this->Solucion->AdvancedSearch->Load();
		$this->Estado->AdvancedSearch->Load();
		$this->Fecha_Actualiz_->AdvancedSearch->Load();
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.ftodas_atencioneslist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_todas_atenciones\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_todas_atenciones',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftodas_atencioneslist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
		case "x_Falla":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Falla->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Problema":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
			$sWhereWrk = "";
			$this->Problema->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Solucion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Solucion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Solucion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
		} 
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
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
if (!isset($todas_atenciones_list)) $todas_atenciones_list = new ctodas_atenciones_list();

// Page init
$todas_atenciones_list->Page_Init();

// Page main
$todas_atenciones_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$todas_atenciones_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftodas_atencioneslist = new ew_Form("ftodas_atencioneslist", "list");
ftodas_atencioneslist.FormKeyCountName = '<?php echo $todas_atenciones_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftodas_atencioneslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftodas_atencioneslist.ValidateRequired = true;
<?php } else { ?>
ftodas_atencioneslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftodas_atencioneslist.Lists["x_Nro_Serie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
ftodas_atencioneslist.Lists["x_Falla"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_falla"};
ftodas_atencioneslist.Lists["x_Problema"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
ftodas_atencioneslist.Lists["x_Solucion"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_solucion_problema"};
ftodas_atencioneslist.Lists["x_Estado"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_actual_solucion_problema"};

// Form object for search
var CurrentSearchForm = ftodas_atencioneslistsrch = new ew_Form("ftodas_atencioneslistsrch");

// Validate function for search
ftodas_atencioneslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
ftodas_atencioneslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftodas_atencioneslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ftodas_atencioneslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
ftodas_atencioneslistsrch.Lists["x_Falla"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_falla"};
ftodas_atencioneslistsrch.Lists["x_Problema"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
ftodas_atencioneslistsrch.Lists["x_Solucion"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_solucion_problema"};
ftodas_atencioneslistsrch.Lists["x_Estado"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_actual_solucion_problema"};
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($todas_atenciones->Export == "") { ?>
<div class="ewToolbar">
<?php if ($todas_atenciones->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($todas_atenciones_list->TotalRecs > 0 && $todas_atenciones_list->ExportOptions->Visible()) { ?>
<?php $todas_atenciones_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($todas_atenciones_list->SearchOptions->Visible()) { ?>
<?php $todas_atenciones_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($todas_atenciones_list->FilterOptions->Visible()) { ?>
<?php $todas_atenciones_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($todas_atenciones->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $todas_atenciones_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($todas_atenciones_list->TotalRecs <= 0)
			$todas_atenciones_list->TotalRecs = $todas_atenciones->SelectRecordCount();
	} else {
		if (!$todas_atenciones_list->Recordset && ($todas_atenciones_list->Recordset = $todas_atenciones_list->LoadRecordset()))
			$todas_atenciones_list->TotalRecs = $todas_atenciones_list->Recordset->RecordCount();
	}
	$todas_atenciones_list->StartRec = 1;
	if ($todas_atenciones_list->DisplayRecs <= 0 || ($todas_atenciones->Export <> "" && $todas_atenciones->ExportAll)) // Display all records
		$todas_atenciones_list->DisplayRecs = $todas_atenciones_list->TotalRecs;
	if (!($todas_atenciones->Export <> "" && $todas_atenciones->ExportAll))
		$todas_atenciones_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$todas_atenciones_list->Recordset = $todas_atenciones_list->LoadRecordset($todas_atenciones_list->StartRec-1, $todas_atenciones_list->DisplayRecs);

	// Set no record found message
	if ($todas_atenciones->CurrentAction == "" && $todas_atenciones_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$todas_atenciones_list->setWarningMessage(ew_DeniedMsg());
		if ($todas_atenciones_list->SearchWhere == "0=101")
			$todas_atenciones_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$todas_atenciones_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$todas_atenciones_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($todas_atenciones->Export == "" && $todas_atenciones->CurrentAction == "") { ?>
<form name="ftodas_atencioneslistsrch" id="ftodas_atencioneslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($todas_atenciones_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftodas_atencioneslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="todas_atenciones">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$todas_atenciones_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$todas_atenciones->RowType = EW_ROWTYPE_SEARCH;

// Render row
$todas_atenciones->ResetAttrs();
$todas_atenciones_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($todas_atenciones->Falla->Visible) { // Falla ?>
	<div id="xsc_Falla" class="ewCell form-group">
		<label for="x_Falla" class="ewSearchCaption ewLabel"><?php echo $todas_atenciones->Falla->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Falla" id="z_Falla" value="LIKE"></span>
		<span class="ewSearchField">
<select data-table="todas_atenciones" data-field="x_Falla" data-value-separator="<?php echo $todas_atenciones->Falla->DisplayValueSeparatorAttribute() ?>" id="x_Falla" name="x_Falla"<?php echo $todas_atenciones->Falla->EditAttributes() ?>>
<?php echo $todas_atenciones->Falla->SelectOptionListHtml("x_Falla") ?>
</select>
<input type="hidden" name="s_x_Falla" id="s_x_Falla" value="<?php echo $todas_atenciones->Falla->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($todas_atenciones->Problema->Visible) { // Problema ?>
	<div id="xsc_Problema" class="ewCell form-group">
		<label for="x_Problema" class="ewSearchCaption ewLabel"><?php echo $todas_atenciones->Problema->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Problema" id="z_Problema" value="LIKE"></span>
		<span class="ewSearchField">
<select data-table="todas_atenciones" data-field="x_Problema" data-value-separator="<?php echo $todas_atenciones->Problema->DisplayValueSeparatorAttribute() ?>" id="x_Problema" name="x_Problema"<?php echo $todas_atenciones->Problema->EditAttributes() ?>>
<?php echo $todas_atenciones->Problema->SelectOptionListHtml("x_Problema") ?>
</select>
<input type="hidden" name="s_x_Problema" id="s_x_Problema" value="<?php echo $todas_atenciones->Problema->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($todas_atenciones->Solucion->Visible) { // Solucion ?>
	<div id="xsc_Solucion" class="ewCell form-group">
		<label for="x_Solucion" class="ewSearchCaption ewLabel"><?php echo $todas_atenciones->Solucion->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Solucion" id="z_Solucion" value="LIKE"></span>
		<span class="ewSearchField">
<select data-table="todas_atenciones" data-field="x_Solucion" data-value-separator="<?php echo $todas_atenciones->Solucion->DisplayValueSeparatorAttribute() ?>" id="x_Solucion" name="x_Solucion"<?php echo $todas_atenciones->Solucion->EditAttributes() ?>>
<?php echo $todas_atenciones->Solucion->SelectOptionListHtml("x_Solucion") ?>
</select>
<input type="hidden" name="s_x_Solucion" id="s_x_Solucion" value="<?php echo $todas_atenciones->Solucion->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
<?php if ($todas_atenciones->Estado->Visible) { // Estado ?>
	<div id="xsc_Estado" class="ewCell form-group">
		<label for="x_Estado" class="ewSearchCaption ewLabel"><?php echo $todas_atenciones->Estado->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Estado" id="z_Estado" value="LIKE"></span>
		<span class="ewSearchField">
<select data-table="todas_atenciones" data-field="x_Estado" data-value-separator="<?php echo $todas_atenciones->Estado->DisplayValueSeparatorAttribute() ?>" id="x_Estado" name="x_Estado"<?php echo $todas_atenciones->Estado->EditAttributes() ?>>
<?php echo $todas_atenciones->Estado->SelectOptionListHtml("x_Estado") ?>
</select>
<input type="hidden" name="s_x_Estado" id="s_x_Estado" value="<?php echo $todas_atenciones->Estado->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_5" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($todas_atenciones_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($todas_atenciones_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $todas_atenciones_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($todas_atenciones_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($todas_atenciones_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($todas_atenciones_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($todas_atenciones_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $todas_atenciones_list->ShowPageHeader(); ?>
<?php
$todas_atenciones_list->ShowMessage();
?>
<?php if ($todas_atenciones_list->TotalRecs > 0 || $todas_atenciones->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid todas_atenciones">
<form name="ftodas_atencioneslist" id="ftodas_atencioneslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($todas_atenciones_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $todas_atenciones_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="todas_atenciones">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_todas_atenciones" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($todas_atenciones_list->TotalRecs > 0) { ?>
<table id="tbl_todas_atencioneslist" class="table ewTable">
<?php echo $todas_atenciones->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$todas_atenciones_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$todas_atenciones_list->RenderListOptions();

// Render list options (header, left)
$todas_atenciones_list->ListOptions->Render("header", "left");
?>
<?php if ($todas_atenciones->Nro_Atenc_->Visible) { // Nro Atenc. ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Nro_Atenc_) == "") { ?>
		<th data-name="Nro_Atenc_"><div id="elh_todas_atenciones_Nro_Atenc_" class="todas_atenciones_Nro_Atenc_"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Nro_Atenc_->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Atenc_"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Nro_Atenc_) ?>',1);"><div id="elh_todas_atenciones_Nro_Atenc_" class="todas_atenciones_Nro_Atenc_">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Nro_Atenc_->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Nro_Atenc_->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Nro_Atenc_->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->CUE->Visible) { // CUE ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->CUE) == "") { ?>
		<th data-name="CUE"><div id="elh_todas_atenciones_CUE" class="todas_atenciones_CUE"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->CUE->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CUE"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->CUE) ?>',1);"><div id="elh_todas_atenciones_CUE" class="todas_atenciones_CUE">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->CUE->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->CUE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->CUE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Escuela->Visible) { // Escuela ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Escuela) == "") { ?>
		<th data-name="Escuela"><div id="elh_todas_atenciones_Escuela" class="todas_atenciones_Escuela"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Escuela->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Escuela"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Escuela) ?>',1);"><div id="elh_todas_atenciones_Escuela" class="todas_atenciones_Escuela">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Escuela->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Escuela->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Escuela->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Nro_Serie->Visible) { // Nro Serie ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Nro_Serie) == "") { ?>
		<th data-name="Nro_Serie"><div id="elh_todas_atenciones_Nro_Serie" class="todas_atenciones_Nro_Serie"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Nro_Serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Serie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Nro_Serie) ?>',1);"><div id="elh_todas_atenciones_Nro_Serie" class="todas_atenciones_Nro_Serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Nro_Serie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Nro_Serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Nro_Serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Titular->Visible) { // Titular ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Titular) == "") { ?>
		<th data-name="Titular"><div id="elh_todas_atenciones_Titular" class="todas_atenciones_Titular"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Titular->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Titular"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Titular) ?>',1);"><div id="elh_todas_atenciones_Titular" class="todas_atenciones_Titular">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Titular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Titular->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Titular->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Dni->Visible) { // Dni ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_todas_atenciones_Dni" class="todas_atenciones_Dni"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Dni) ?>',1);"><div id="elh_todas_atenciones_Dni" class="todas_atenciones_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Dni->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Curso->Visible) { // Curso ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Curso) == "") { ?>
		<th data-name="Curso"><div id="elh_todas_atenciones_Curso" class="todas_atenciones_Curso"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Curso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Curso"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Curso) ?>',1);"><div id="elh_todas_atenciones_Curso" class="todas_atenciones_Curso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Curso->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Curso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Curso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Division->Visible) { // Division ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Division) == "") { ?>
		<th data-name="Division"><div id="elh_todas_atenciones_Division" class="todas_atenciones_Division"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Division->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Division"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Division) ?>',1);"><div id="elh_todas_atenciones_Division" class="todas_atenciones_Division">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Division->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Division->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Division->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Fecha_Entrada->Visible) { // Fecha Entrada ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Fecha_Entrada) == "") { ?>
		<th data-name="Fecha_Entrada"><div id="elh_todas_atenciones_Fecha_Entrada" class="todas_atenciones_Fecha_Entrada"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Fecha_Entrada->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Entrada"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Fecha_Entrada) ?>',1);"><div id="elh_todas_atenciones_Fecha_Entrada" class="todas_atenciones_Fecha_Entrada">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Fecha_Entrada->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Fecha_Entrada->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Fecha_Entrada->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Falla->Visible) { // Falla ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Falla) == "") { ?>
		<th data-name="Falla"><div id="elh_todas_atenciones_Falla" class="todas_atenciones_Falla"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Falla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Falla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Falla) ?>',1);"><div id="elh_todas_atenciones_Falla" class="todas_atenciones_Falla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Falla->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Falla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Falla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Problema->Visible) { // Problema ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Problema) == "") { ?>
		<th data-name="Problema"><div id="elh_todas_atenciones_Problema" class="todas_atenciones_Problema"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Problema->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Problema"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Problema) ?>',1);"><div id="elh_todas_atenciones_Problema" class="todas_atenciones_Problema">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Problema->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Problema->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Problema->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Solucion->Visible) { // Solucion ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Solucion) == "") { ?>
		<th data-name="Solucion"><div id="elh_todas_atenciones_Solucion" class="todas_atenciones_Solucion"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Solucion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Solucion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Solucion) ?>',1);"><div id="elh_todas_atenciones_Solucion" class="todas_atenciones_Solucion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Solucion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Solucion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Solucion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Estado->Visible) { // Estado ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Estado) == "") { ?>
		<th data-name="Estado"><div id="elh_todas_atenciones_Estado" class="todas_atenciones_Estado"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Estado) ?>',1);"><div id="elh_todas_atenciones_Estado" class="todas_atenciones_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($todas_atenciones->Fecha_Actualiz_->Visible) { // Fecha Actualiz. ?>
	<?php if ($todas_atenciones->SortUrl($todas_atenciones->Fecha_Actualiz_) == "") { ?>
		<th data-name="Fecha_Actualiz_"><div id="elh_todas_atenciones_Fecha_Actualiz_" class="todas_atenciones_Fecha_Actualiz_"><div class="ewTableHeaderCaption"><?php echo $todas_atenciones->Fecha_Actualiz_->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualiz_"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $todas_atenciones->SortUrl($todas_atenciones->Fecha_Actualiz_) ?>',1);"><div id="elh_todas_atenciones_Fecha_Actualiz_" class="todas_atenciones_Fecha_Actualiz_">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $todas_atenciones->Fecha_Actualiz_->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($todas_atenciones->Fecha_Actualiz_->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($todas_atenciones->Fecha_Actualiz_->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$todas_atenciones_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($todas_atenciones->ExportAll && $todas_atenciones->Export <> "") {
	$todas_atenciones_list->StopRec = $todas_atenciones_list->TotalRecs;
} else {

	// Set the last record to display
	if ($todas_atenciones_list->TotalRecs > $todas_atenciones_list->StartRec + $todas_atenciones_list->DisplayRecs - 1)
		$todas_atenciones_list->StopRec = $todas_atenciones_list->StartRec + $todas_atenciones_list->DisplayRecs - 1;
	else
		$todas_atenciones_list->StopRec = $todas_atenciones_list->TotalRecs;
}
$todas_atenciones_list->RecCnt = $todas_atenciones_list->StartRec - 1;
if ($todas_atenciones_list->Recordset && !$todas_atenciones_list->Recordset->EOF) {
	$todas_atenciones_list->Recordset->MoveFirst();
	$bSelectLimit = $todas_atenciones_list->UseSelectLimit;
	if (!$bSelectLimit && $todas_atenciones_list->StartRec > 1)
		$todas_atenciones_list->Recordset->Move($todas_atenciones_list->StartRec - 1);
} elseif (!$todas_atenciones->AllowAddDeleteRow && $todas_atenciones_list->StopRec == 0) {
	$todas_atenciones_list->StopRec = $todas_atenciones->GridAddRowCount;
}

// Initialize aggregate
$todas_atenciones->RowType = EW_ROWTYPE_AGGREGATEINIT;
$todas_atenciones->ResetAttrs();
$todas_atenciones_list->RenderRow();
while ($todas_atenciones_list->RecCnt < $todas_atenciones_list->StopRec) {
	$todas_atenciones_list->RecCnt++;
	if (intval($todas_atenciones_list->RecCnt) >= intval($todas_atenciones_list->StartRec)) {
		$todas_atenciones_list->RowCnt++;

		// Set up key count
		$todas_atenciones_list->KeyCount = $todas_atenciones_list->RowIndex;

		// Init row class and style
		$todas_atenciones->ResetAttrs();
		$todas_atenciones->CssClass = "";
		if ($todas_atenciones->CurrentAction == "gridadd") {
		} else {
			$todas_atenciones_list->LoadRowValues($todas_atenciones_list->Recordset); // Load row values
		}
		$todas_atenciones->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$todas_atenciones->RowAttrs = array_merge($todas_atenciones->RowAttrs, array('data-rowindex'=>$todas_atenciones_list->RowCnt, 'id'=>'r' . $todas_atenciones_list->RowCnt . '_todas_atenciones', 'data-rowtype'=>$todas_atenciones->RowType));

		// Render row
		$todas_atenciones_list->RenderRow();

		// Render list options
		$todas_atenciones_list->RenderListOptions();
?>
	<tr<?php echo $todas_atenciones->RowAttributes() ?>>
<?php

// Render list options (body, left)
$todas_atenciones_list->ListOptions->Render("body", "left", $todas_atenciones_list->RowCnt);
?>
	<?php if ($todas_atenciones->Nro_Atenc_->Visible) { // Nro Atenc. ?>
		<td data-name="Nro_Atenc_"<?php echo $todas_atenciones->Nro_Atenc_->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Nro_Atenc_" class="todas_atenciones_Nro_Atenc_">
<span<?php echo $todas_atenciones->Nro_Atenc_->ViewAttributes() ?>>
<?php echo $todas_atenciones->Nro_Atenc_->ListViewValue() ?></span>
</span>
<a id="<?php echo $todas_atenciones_list->PageObjName . "_row_" . $todas_atenciones_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($todas_atenciones->CUE->Visible) { // CUE ?>
		<td data-name="CUE"<?php echo $todas_atenciones->CUE->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_CUE" class="todas_atenciones_CUE">
<span<?php echo $todas_atenciones->CUE->ViewAttributes() ?>>
<?php echo $todas_atenciones->CUE->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Escuela->Visible) { // Escuela ?>
		<td data-name="Escuela"<?php echo $todas_atenciones->Escuela->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Escuela" class="todas_atenciones_Escuela">
<span<?php echo $todas_atenciones->Escuela->ViewAttributes() ?>>
<?php echo $todas_atenciones->Escuela->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Nro_Serie->Visible) { // Nro Serie ?>
		<td data-name="Nro_Serie"<?php echo $todas_atenciones->Nro_Serie->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Nro_Serie" class="todas_atenciones_Nro_Serie">
<span<?php echo $todas_atenciones->Nro_Serie->ViewAttributes() ?>>
<?php echo $todas_atenciones->Nro_Serie->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Titular->Visible) { // Titular ?>
		<td data-name="Titular"<?php echo $todas_atenciones->Titular->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Titular" class="todas_atenciones_Titular">
<span<?php echo $todas_atenciones->Titular->ViewAttributes() ?>>
<?php echo $todas_atenciones->Titular->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $todas_atenciones->Dni->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Dni" class="todas_atenciones_Dni">
<span<?php echo $todas_atenciones->Dni->ViewAttributes() ?>>
<?php echo $todas_atenciones->Dni->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Curso->Visible) { // Curso ?>
		<td data-name="Curso"<?php echo $todas_atenciones->Curso->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Curso" class="todas_atenciones_Curso">
<span<?php echo $todas_atenciones->Curso->ViewAttributes() ?>>
<?php echo $todas_atenciones->Curso->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Division->Visible) { // Division ?>
		<td data-name="Division"<?php echo $todas_atenciones->Division->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Division" class="todas_atenciones_Division">
<span<?php echo $todas_atenciones->Division->ViewAttributes() ?>>
<?php echo $todas_atenciones->Division->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Fecha_Entrada->Visible) { // Fecha Entrada ?>
		<td data-name="Fecha_Entrada"<?php echo $todas_atenciones->Fecha_Entrada->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Fecha_Entrada" class="todas_atenciones_Fecha_Entrada">
<span<?php echo $todas_atenciones->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $todas_atenciones->Fecha_Entrada->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Falla->Visible) { // Falla ?>
		<td data-name="Falla"<?php echo $todas_atenciones->Falla->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Falla" class="todas_atenciones_Falla">
<span<?php echo $todas_atenciones->Falla->ViewAttributes() ?>>
<?php echo $todas_atenciones->Falla->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Problema->Visible) { // Problema ?>
		<td data-name="Problema"<?php echo $todas_atenciones->Problema->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Problema" class="todas_atenciones_Problema">
<span<?php echo $todas_atenciones->Problema->ViewAttributes() ?>>
<?php echo $todas_atenciones->Problema->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Solucion->Visible) { // Solucion ?>
		<td data-name="Solucion"<?php echo $todas_atenciones->Solucion->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Solucion" class="todas_atenciones_Solucion">
<span<?php echo $todas_atenciones->Solucion->ViewAttributes() ?>>
<?php echo $todas_atenciones->Solucion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Estado->Visible) { // Estado ?>
		<td data-name="Estado"<?php echo $todas_atenciones->Estado->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Estado" class="todas_atenciones_Estado">
<span<?php echo $todas_atenciones->Estado->ViewAttributes() ?>>
<?php echo $todas_atenciones->Estado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($todas_atenciones->Fecha_Actualiz_->Visible) { // Fecha Actualiz. ?>
		<td data-name="Fecha_Actualiz_"<?php echo $todas_atenciones->Fecha_Actualiz_->CellAttributes() ?>>
<span id="el<?php echo $todas_atenciones_list->RowCnt ?>_todas_atenciones_Fecha_Actualiz_" class="todas_atenciones_Fecha_Actualiz_">
<span<?php echo $todas_atenciones->Fecha_Actualiz_->ViewAttributes() ?>>
<?php echo $todas_atenciones->Fecha_Actualiz_->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$todas_atenciones_list->ListOptions->Render("body", "right", $todas_atenciones_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($todas_atenciones->CurrentAction <> "gridadd")
		$todas_atenciones_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($todas_atenciones->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($todas_atenciones_list->Recordset)
	$todas_atenciones_list->Recordset->Close();
?>
<?php if ($todas_atenciones->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($todas_atenciones->CurrentAction <> "gridadd" && $todas_atenciones->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($todas_atenciones_list->Pager)) $todas_atenciones_list->Pager = new cPrevNextPager($todas_atenciones_list->StartRec, $todas_atenciones_list->DisplayRecs, $todas_atenciones_list->TotalRecs) ?>
<?php if ($todas_atenciones_list->Pager->RecordCount > 0 && $todas_atenciones_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($todas_atenciones_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $todas_atenciones_list->PageUrl() ?>start=<?php echo $todas_atenciones_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($todas_atenciones_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $todas_atenciones_list->PageUrl() ?>start=<?php echo $todas_atenciones_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $todas_atenciones_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($todas_atenciones_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $todas_atenciones_list->PageUrl() ?>start=<?php echo $todas_atenciones_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($todas_atenciones_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $todas_atenciones_list->PageUrl() ?>start=<?php echo $todas_atenciones_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $todas_atenciones_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $todas_atenciones_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $todas_atenciones_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $todas_atenciones_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($todas_atenciones_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($todas_atenciones_list->TotalRecs == 0 && $todas_atenciones->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($todas_atenciones_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">
ftodas_atencioneslistsrch.FilterList = <?php echo $todas_atenciones_list->GetFilterList() ?>;
ftodas_atencioneslistsrch.Init();
ftodas_atencioneslist.Init();
</script>
<?php } ?>
<?php
$todas_atenciones_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$todas_atenciones_list->Page_Terminate();
?>
