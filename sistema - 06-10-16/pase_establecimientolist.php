<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pase_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pase_establecimiento_list = NULL; // Initialize page object first

class cpase_establecimiento_list extends cpase_establecimiento {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pase_establecimiento';

	// Page object name
	var $PageObjName = 'pase_establecimiento_list';

	// Grid form hidden field names
	var $FormName = 'fpase_establecimientolist';
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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (pase_establecimiento)
		if (!isset($GLOBALS["pase_establecimiento"]) || get_class($GLOBALS["pase_establecimiento"]) == "cpase_establecimiento") {
			$GLOBALS["pase_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pase_establecimiento"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pase_establecimientoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pase_establecimientodelete.php";
		$this->MultiUpdateUrl = "pase_establecimientoupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pase_establecimiento', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpase_establecimientolistsrch";

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
		$this->Id_Pase->SetVisibility();
		$this->Id_Pase->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->NroSerie->SetVisibility();
		$this->Cue_Establecimiento_Alta->SetVisibility();
		$this->Cue_Establecimiento_Baja->SetVisibility();
		$this->Fecha_Pase->SetVisibility();
		$this->Id_Estado_Pase->SetVisibility();

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
		global $EW_EXPORT, $pase_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pase_establecimiento);
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
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
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
			$this->Id_Pase->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Pase->FormValue))
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
					$sKey .= $this->Id_Pase->CurrentValue;

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
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_NroSerie") && $objForm->HasValue("o_NroSerie") && $this->NroSerie->CurrentValue <> $this->NroSerie->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cue_Establecimiento_Alta") && $objForm->HasValue("o_Cue_Establecimiento_Alta") && $this->Cue_Establecimiento_Alta->CurrentValue <> $this->Cue_Establecimiento_Alta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cue_Establecimiento_Baja") && $objForm->HasValue("o_Cue_Establecimiento_Baja") && $this->Cue_Establecimiento_Baja->CurrentValue <> $this->Cue_Establecimiento_Baja->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Fecha_Pase") && $objForm->HasValue("o_Fecha_Pase") && $this->Fecha_Pase->CurrentValue <> $this->Fecha_Pase->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Estado_Pase") && $objForm->HasValue("o_Id_Estado_Pase") && $this->Id_Estado_Pase->CurrentValue <> $this->Id_Estado_Pase->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpase_establecimientolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Id_Pase->AdvancedSearch->ToJSON(), ","); // Field Id_Pase
		$sFilterList = ew_Concat($sFilterList, $this->NroSerie->AdvancedSearch->ToJSON(), ","); // Field NroSerie
		$sFilterList = ew_Concat($sFilterList, $this->Cue_Establecimiento_Alta->AdvancedSearch->ToJSON(), ","); // Field Cue_Establecimiento_Alta
		$sFilterList = ew_Concat($sFilterList, $this->Cue_Establecimiento_Baja->AdvancedSearch->ToJSON(), ","); // Field Cue_Establecimiento_Baja
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Pase->AdvancedSearch->ToJSON(), ","); // Field Fecha_Pase
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Pase->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Pase
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpase_establecimientolistsrch", $filters);
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

		// Field Id_Pase
		$this->Id_Pase->AdvancedSearch->SearchValue = @$filter["x_Id_Pase"];
		$this->Id_Pase->AdvancedSearch->SearchOperator = @$filter["z_Id_Pase"];
		$this->Id_Pase->AdvancedSearch->SearchCondition = @$filter["v_Id_Pase"];
		$this->Id_Pase->AdvancedSearch->SearchValue2 = @$filter["y_Id_Pase"];
		$this->Id_Pase->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Pase"];
		$this->Id_Pase->AdvancedSearch->Save();

		// Field NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = @$filter["x_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator = @$filter["z_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchCondition = @$filter["v_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchValue2 = @$filter["y_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator2 = @$filter["w_NroSerie"];
		$this->NroSerie->AdvancedSearch->Save();

		// Field Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue = @$filter["x_Cue_Establecimiento_Alta"];
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchOperator = @$filter["z_Cue_Establecimiento_Alta"];
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchCondition = @$filter["v_Cue_Establecimiento_Alta"];
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue2 = @$filter["y_Cue_Establecimiento_Alta"];
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchOperator2 = @$filter["w_Cue_Establecimiento_Alta"];
		$this->Cue_Establecimiento_Alta->AdvancedSearch->Save();

		// Field Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue = @$filter["x_Cue_Establecimiento_Baja"];
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchOperator = @$filter["z_Cue_Establecimiento_Baja"];
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchCondition = @$filter["v_Cue_Establecimiento_Baja"];
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue2 = @$filter["y_Cue_Establecimiento_Baja"];
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchOperator2 = @$filter["w_Cue_Establecimiento_Baja"];
		$this->Cue_Establecimiento_Baja->AdvancedSearch->Save();

		// Field Fecha_Pase
		$this->Fecha_Pase->AdvancedSearch->SearchValue = @$filter["x_Fecha_Pase"];
		$this->Fecha_Pase->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Pase"];
		$this->Fecha_Pase->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Pase"];
		$this->Fecha_Pase->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Pase"];
		$this->Fecha_Pase->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Pase"];
		$this->Fecha_Pase->AdvancedSearch->Save();

		// Field Id_Estado_Pase
		$this->Id_Estado_Pase->AdvancedSearch->SearchValue = @$filter["x_Id_Estado_Pase"];
		$this->Id_Estado_Pase->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado_Pase"];
		$this->Id_Estado_Pase->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado_Pase"];
		$this->Id_Estado_Pase->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado_Pase"];
		$this->Id_Estado_Pase->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado_Pase"];
		$this->Id_Estado_Pase->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->Id_Pase, $Default, FALSE); // Id_Pase
		$this->BuildSearchSql($sWhere, $this->NroSerie, $Default, FALSE); // NroSerie
		$this->BuildSearchSql($sWhere, $this->Cue_Establecimiento_Alta, $Default, FALSE); // Cue_Establecimiento_Alta
		$this->BuildSearchSql($sWhere, $this->Cue_Establecimiento_Baja, $Default, FALSE); // Cue_Establecimiento_Baja
		$this->BuildSearchSql($sWhere, $this->Fecha_Pase, $Default, FALSE); // Fecha_Pase
		$this->BuildSearchSql($sWhere, $this->Id_Estado_Pase, $Default, FALSE); // Id_Estado_Pase

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Id_Pase->AdvancedSearch->Save(); // Id_Pase
			$this->NroSerie->AdvancedSearch->Save(); // NroSerie
			$this->Cue_Establecimiento_Alta->AdvancedSearch->Save(); // Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Baja->AdvancedSearch->Save(); // Cue_Establecimiento_Baja
			$this->Fecha_Pase->AdvancedSearch->Save(); // Fecha_Pase
			$this->Id_Estado_Pase->AdvancedSearch->Save(); // Id_Estado_Pase
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
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Pase, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NroSerie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cue_Establecimiento_Alta, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cue_Establecimiento_Baja, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Estado_Pase, $arKeywords, $type);
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
		if ($this->Id_Pase->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NroSerie->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cue_Establecimiento_Alta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cue_Establecimiento_Baja->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Pase->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado_Pase->AdvancedSearch->IssetSession())
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
		$this->Id_Pase->AdvancedSearch->UnsetSession();
		$this->NroSerie->AdvancedSearch->UnsetSession();
		$this->Cue_Establecimiento_Alta->AdvancedSearch->UnsetSession();
		$this->Cue_Establecimiento_Baja->AdvancedSearch->UnsetSession();
		$this->Fecha_Pase->AdvancedSearch->UnsetSession();
		$this->Id_Estado_Pase->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Pase->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Alta->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Baja->AdvancedSearch->Load();
		$this->Fecha_Pase->AdvancedSearch->Load();
		$this->Id_Estado_Pase->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Pase); // Id_Pase
			$this->UpdateSort($this->NroSerie); // NroSerie
			$this->UpdateSort($this->Cue_Establecimiento_Alta); // Cue_Establecimiento_Alta
			$this->UpdateSort($this->Cue_Establecimiento_Baja); // Cue_Establecimiento_Baja
			$this->UpdateSort($this->Fecha_Pase); // Fecha_Pase
			$this->UpdateSort($this->Id_Estado_Pase); // Id_Estado_Pase
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
				$this->Id_Pase->setSort("");
				$this->NroSerie->setSort("");
				$this->Cue_Establecimiento_Alta->setSort("");
				$this->Cue_Establecimiento_Baja->setSort("");
				$this->Fecha_Pase->setSort("");
				$this->Id_Estado_Pase->setSort("");
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
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Pase->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Id_Pase->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->IsLoggedIn());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fpase_establecimientolist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"pase_establecimiento\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fpase_establecimientolist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpase_establecimientolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpase_establecimientolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpase_establecimientolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpase_establecimientolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"pase_establecimientosrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Id_Pase->CurrentValue = NULL;
		$this->Id_Pase->OldValue = $this->Id_Pase->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Cue_Establecimiento_Alta->CurrentValue = NULL;
		$this->Cue_Establecimiento_Alta->OldValue = $this->Cue_Establecimiento_Alta->CurrentValue;
		$this->Cue_Establecimiento_Baja->CurrentValue = NULL;
		$this->Cue_Establecimiento_Baja->OldValue = $this->Cue_Establecimiento_Baja->CurrentValue;
		$this->Fecha_Pase->CurrentValue = NULL;
		$this->Fecha_Pase->OldValue = $this->Fecha_Pase->CurrentValue;
		$this->Id_Estado_Pase->CurrentValue = NULL;
		$this->Id_Estado_Pase->OldValue = $this->Id_Estado_Pase->CurrentValue;
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
		// Id_Pase

		$this->Id_Pase->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Pase"]);
		if ($this->Id_Pase->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Pase->AdvancedSearch->SearchOperator = @$_GET["z_Id_Pase"];

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroSerie"]);
		if ($this->NroSerie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroSerie->AdvancedSearch->SearchOperator = @$_GET["z_NroSerie"];

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cue_Establecimiento_Alta"]);
		if ($this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchOperator = @$_GET["z_Cue_Establecimiento_Alta"];

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cue_Establecimiento_Baja"]);
		if ($this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchOperator = @$_GET["z_Cue_Establecimiento_Baja"];

		// Fecha_Pase
		$this->Fecha_Pase->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Pase"]);
		if ($this->Fecha_Pase->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Pase->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Pase"];

		// Id_Estado_Pase
		$this->Id_Estado_Pase->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado_Pase"]);
		if ($this->Id_Estado_Pase->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado_Pase->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado_Pase"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Pase->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Pase->setFormValue($objForm->GetValue("x_Id_Pase"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->setOldValue($objForm->GetValue("o_NroSerie"));
		if (!$this->Cue_Establecimiento_Alta->FldIsDetailKey) {
			$this->Cue_Establecimiento_Alta->setFormValue($objForm->GetValue("x_Cue_Establecimiento_Alta"));
		}
		$this->Cue_Establecimiento_Alta->setOldValue($objForm->GetValue("o_Cue_Establecimiento_Alta"));
		if (!$this->Cue_Establecimiento_Baja->FldIsDetailKey) {
			$this->Cue_Establecimiento_Baja->setFormValue($objForm->GetValue("x_Cue_Establecimiento_Baja"));
		}
		$this->Cue_Establecimiento_Baja->setOldValue($objForm->GetValue("o_Cue_Establecimiento_Baja"));
		if (!$this->Fecha_Pase->FldIsDetailKey) {
			$this->Fecha_Pase->setFormValue($objForm->GetValue("x_Fecha_Pase"));
			$this->Fecha_Pase->CurrentValue = ew_UnFormatDateTime($this->Fecha_Pase->CurrentValue, 0);
		}
		$this->Fecha_Pase->setOldValue($objForm->GetValue("o_Fecha_Pase"));
		if (!$this->Id_Estado_Pase->FldIsDetailKey) {
			$this->Id_Estado_Pase->setFormValue($objForm->GetValue("x_Id_Estado_Pase"));
		}
		$this->Id_Estado_Pase->setOldValue($objForm->GetValue("o_Id_Estado_Pase"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Pase->CurrentValue = $this->Id_Pase->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Cue_Establecimiento_Alta->CurrentValue = $this->Cue_Establecimiento_Alta->FormValue;
		$this->Cue_Establecimiento_Baja->CurrentValue = $this->Cue_Establecimiento_Baja->FormValue;
		$this->Fecha_Pase->CurrentValue = $this->Fecha_Pase->FormValue;
		$this->Fecha_Pase->CurrentValue = ew_UnFormatDateTime($this->Fecha_Pase->CurrentValue, 0);
		$this->Id_Estado_Pase->CurrentValue = $this->Id_Estado_Pase->FormValue;
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
		$this->Id_Pase->setDbValue($rs->fields('Id_Pase'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Cue_Establecimiento_Alta->setDbValue($rs->fields('Cue_Establecimiento_Alta'));
		$this->Cue_Establecimiento_Baja->setDbValue($rs->fields('Cue_Establecimiento_Baja'));
		$this->Fecha_Pase->setDbValue($rs->fields('Fecha_Pase'));
		$this->Id_Estado_Pase->setDbValue($rs->fields('Id_Estado_Pase'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Pase->DbValue = $row['Id_Pase'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Cue_Establecimiento_Alta->DbValue = $row['Cue_Establecimiento_Alta'];
		$this->Cue_Establecimiento_Baja->DbValue = $row['Cue_Establecimiento_Baja'];
		$this->Fecha_Pase->DbValue = $row['Fecha_Pase'];
		$this->Id_Estado_Pase->DbValue = $row['Id_Estado_Pase'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Pase")) <> "")
			$this->Id_Pase->CurrentValue = $this->getKey("Id_Pase"); // Id_Pase
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
		// Id_Pase
		// NroSerie
		// Cue_Establecimiento_Alta
		// Cue_Establecimiento_Baja
		// Fecha_Pase
		// Id_Estado_Pase

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Pase
		$this->Id_Pase->ViewValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array();
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

		// Cue_Establecimiento_Alta
		if (strval($this->Cue_Establecimiento_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Alta->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Alta->ViewCustomAttributes = "";

		// Cue_Establecimiento_Baja
		if (strval($this->Cue_Establecimiento_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Baja->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Baja->ViewCustomAttributes = "";

		// Fecha_Pase
		$this->Fecha_Pase->ViewValue = $this->Fecha_Pase->CurrentValue;
		$this->Fecha_Pase->ViewCustomAttributes = "";

		// Id_Estado_Pase
		if (strval($this->Id_Estado_Pase->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
		$sWhereWrk = "";
		$this->Id_Estado_Pase->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->CurrentValue;
			}
		} else {
			$this->Id_Estado_Pase->ViewValue = NULL;
		}
		$this->Id_Estado_Pase->ViewCustomAttributes = "";

			// Id_Pase
			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";
			$this->Id_Pase->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";
			$this->Cue_Establecimiento_Alta->TooltipValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";
			$this->Cue_Establecimiento_Baja->TooltipValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";
			$this->Fecha_Pase->TooltipValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
			$this->Id_Estado_Pase->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Pase
			// NroSerie

			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Alta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Alta->EditValue = $arwrk;

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Baja->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Baja->EditValue = $arwrk;

			// Fecha_Pase
			$this->Fecha_Pase->EditAttrs["class"] = "form-control";
			$this->Fecha_Pase->EditCustomAttributes = "";
			$this->Fecha_Pase->EditValue = ew_HtmlEncode($this->Fecha_Pase->CurrentValue);
			$this->Fecha_Pase->PlaceHolder = ew_RemoveHtml($this->Fecha_Pase->FldCaption());

			// Id_Estado_Pase
			$this->Id_Estado_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Pase->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Pase->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Pase->EditValue = $arwrk;

			// Add refer script
			// Id_Pase

			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Pase
			$this->Id_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Pase->EditCustomAttributes = "";
			$this->Id_Pase->EditValue = $this->Id_Pase->CurrentValue;
			$this->Id_Pase->ViewCustomAttributes = "";

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Alta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Alta->EditValue = $arwrk;

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->EditCustomAttributes = "";
			if (trim(strval($this->Cue_Establecimiento_Baja->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Cue_Establecimiento_Baja->EditValue = $arwrk;

			// Fecha_Pase
			$this->Fecha_Pase->EditAttrs["class"] = "form-control";
			$this->Fecha_Pase->EditCustomAttributes = "";
			$this->Fecha_Pase->EditValue = ew_HtmlEncode($this->Fecha_Pase->CurrentValue);
			$this->Fecha_Pase->PlaceHolder = ew_RemoveHtml($this->Fecha_Pase->FldCaption());

			// Id_Estado_Pase
			$this->Id_Estado_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Pase->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Pase->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Pase->EditValue = $arwrk;

			// Edit refer script
			// Id_Pase

			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
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
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Fecha_Pase->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Pase->FldErrMsg());
		}
		if (!$this->Id_Estado_Pase->FldIsDetailKey && !is_null($this->Id_Estado_Pase->FormValue) && $this->Id_Estado_Pase->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Pase->FldCaption(), $this->Id_Estado_Pase->ReqErrMsg));
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
				$sThisKey .= $row['Id_Pase'];
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

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly);

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Alta->CurrentValue, NULL, $this->Cue_Establecimiento_Alta->ReadOnly);

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Baja->CurrentValue, NULL, $this->Cue_Establecimiento_Baja->ReadOnly);

			// Fecha_Pase
			$this->Fecha_Pase->SetDbValueDef($rsnew, $this->Fecha_Pase->CurrentValue, NULL, $this->Fecha_Pase->ReadOnly);

			// Id_Estado_Pase
			$this->Id_Estado_Pase->SetDbValueDef($rsnew, $this->Id_Estado_Pase->CurrentValue, 0, $this->Id_Estado_Pase->ReadOnly);

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

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Alta->CurrentValue, NULL, FALSE);

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->SetDbValueDef($rsnew, $this->Cue_Establecimiento_Baja->CurrentValue, NULL, FALSE);

		// Fecha_Pase
		$this->Fecha_Pase->SetDbValueDef($rsnew, $this->Fecha_Pase->CurrentValue, NULL, FALSE);

		// Id_Estado_Pase
		$this->Id_Estado_Pase->SetDbValueDef($rsnew, $this->Id_Estado_Pase->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Id_Pase->setDbValue($conn->Insert_ID());
				$rsnew['Id_Pase'] = $this->Id_Pase->DbValue;
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
		}
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Pase->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Alta->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Baja->AdvancedSearch->Load();
		$this->Fecha_Pase->AdvancedSearch->Load();
		$this->Id_Estado_Pase->AdvancedSearch->Load();
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fpase_establecimientolist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_pase_establecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pase_establecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpase_establecimientolist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Pase":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Pase` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Pase` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
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
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($pase_establecimiento_list)) $pase_establecimiento_list = new cpase_establecimiento_list();

// Page init
$pase_establecimiento_list->Page_Init();

// Page main
$pase_establecimiento_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pase_establecimiento_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpase_establecimientolist = new ew_Form("fpase_establecimientolist", "list");
fpase_establecimientolist.FormKeyCountName = '<?php echo $pase_establecimiento_list->FormKeyCountName ?>';

// Validate form
fpase_establecimientolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pase_establecimiento->NroSerie->FldCaption(), $pase_establecimiento->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Pase");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->Fecha_Pase->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Pase");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pase_establecimiento->Id_Estado_Pase->FldCaption(), $pase_establecimiento->Id_Estado_Pase->ReqErrMsg)) ?>");

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
fpase_establecimientolist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cue_Establecimiento_Alta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cue_Establecimiento_Baja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Pase", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado_Pase", false)) return false;
	return true;
}

// Form_CustomValidate event
fpase_establecimientolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpase_establecimientolist.ValidateRequired = true;
<?php } else { ?>
fpase_establecimientolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpase_establecimientolist.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpase_establecimientolist.Lists["x_Cue_Establecimiento_Alta"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientolist.Lists["x_Cue_Establecimiento_Baja"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientolist.Lists["x_Id_Estado_Pase"] = {"LinkField":"x_Id_Estado_Pase","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_pase"};

// Form object for search
var CurrentSearchForm = fpase_establecimientolistsrch = new ew_Form("fpase_establecimientolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pase_establecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($pase_establecimiento_list->TotalRecs > 0 && $pase_establecimiento_list->ExportOptions->Visible()) { ?>
<?php $pase_establecimiento_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pase_establecimiento_list->SearchOptions->Visible()) { ?>
<?php $pase_establecimiento_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pase_establecimiento_list->FilterOptions->Visible()) { ?>
<?php $pase_establecimiento_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($pase_establecimiento->CurrentAction == "gridadd") {
	$pase_establecimiento->CurrentFilter = "0=1";
	$pase_establecimiento_list->StartRec = 1;
	$pase_establecimiento_list->DisplayRecs = $pase_establecimiento->GridAddRowCount;
	$pase_establecimiento_list->TotalRecs = $pase_establecimiento_list->DisplayRecs;
	$pase_establecimiento_list->StopRec = $pase_establecimiento_list->DisplayRecs;
} else {
	$bSelectLimit = $pase_establecimiento_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pase_establecimiento_list->TotalRecs <= 0)
			$pase_establecimiento_list->TotalRecs = $pase_establecimiento->SelectRecordCount();
	} else {
		if (!$pase_establecimiento_list->Recordset && ($pase_establecimiento_list->Recordset = $pase_establecimiento_list->LoadRecordset()))
			$pase_establecimiento_list->TotalRecs = $pase_establecimiento_list->Recordset->RecordCount();
	}
	$pase_establecimiento_list->StartRec = 1;
	if ($pase_establecimiento_list->DisplayRecs <= 0 || ($pase_establecimiento->Export <> "" && $pase_establecimiento->ExportAll)) // Display all records
		$pase_establecimiento_list->DisplayRecs = $pase_establecimiento_list->TotalRecs;
	if (!($pase_establecimiento->Export <> "" && $pase_establecimiento->ExportAll))
		$pase_establecimiento_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pase_establecimiento_list->Recordset = $pase_establecimiento_list->LoadRecordset($pase_establecimiento_list->StartRec-1, $pase_establecimiento_list->DisplayRecs);

	// Set no record found message
	if ($pase_establecimiento->CurrentAction == "" && $pase_establecimiento_list->TotalRecs == 0) {
		if ($pase_establecimiento_list->SearchWhere == "0=101")
			$pase_establecimiento_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pase_establecimiento_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$pase_establecimiento_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($pase_establecimiento->Export == "" && $pase_establecimiento->CurrentAction == "") { ?>
<form name="fpase_establecimientolistsrch" id="fpase_establecimientolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pase_establecimiento_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpase_establecimientolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pase_establecimiento">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pase_establecimiento_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pase_establecimiento_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pase_establecimiento_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pase_establecimiento_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pase_establecimiento_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pase_establecimiento_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pase_establecimiento_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $pase_establecimiento_list->ShowPageHeader(); ?>
<?php
$pase_establecimiento_list->ShowMessage();
?>
<?php if ($pase_establecimiento_list->TotalRecs > 0 || $pase_establecimiento->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid pase_establecimiento">
<form name="fpase_establecimientolist" id="fpase_establecimientolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pase_establecimiento_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pase_establecimiento_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pase_establecimiento">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_pase_establecimiento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($pase_establecimiento_list->TotalRecs > 0) { ?>
<table id="tbl_pase_establecimientolist" class="table ewTable">
<?php echo $pase_establecimiento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$pase_establecimiento_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pase_establecimiento_list->RenderListOptions();

// Render list options (header, left)
$pase_establecimiento_list->ListOptions->Render("header", "left");
?>
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->Id_Pase) == "") { ?>
		<th data-name="Id_Pase"><div id="elh_pase_establecimiento_Id_Pase" class="pase_establecimiento_Id_Pase"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Pase"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->Id_Pase) ?>',1);"><div id="elh_pase_establecimiento_Id_Pase" class="pase_establecimiento_Id_Pase">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->Id_Pase->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->Id_Pase->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pase_establecimiento->NroSerie->Visible) { // NroSerie ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_pase_establecimiento_NroSerie" class="pase_establecimiento_NroSerie"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->NroSerie) ?>',1);"><div id="elh_pase_establecimiento_NroSerie" class="pase_establecimiento_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->NroSerie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->Cue_Establecimiento_Alta) == "") { ?>
		<th data-name="Cue_Establecimiento_Alta"><div id="elh_pase_establecimiento_Cue_Establecimiento_Alta" class="pase_establecimiento_Cue_Establecimiento_Alta"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue_Establecimiento_Alta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->Cue_Establecimiento_Alta) ?>',1);"><div id="elh_pase_establecimiento_Cue_Establecimiento_Alta" class="pase_establecimiento_Cue_Establecimiento_Alta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->Cue_Establecimiento_Alta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->Cue_Establecimiento_Alta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->Cue_Establecimiento_Baja) == "") { ?>
		<th data-name="Cue_Establecimiento_Baja"><div id="elh_pase_establecimiento_Cue_Establecimiento_Baja" class="pase_establecimiento_Cue_Establecimiento_Baja"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue_Establecimiento_Baja"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->Cue_Establecimiento_Baja) ?>',1);"><div id="elh_pase_establecimiento_Cue_Establecimiento_Baja" class="pase_establecimiento_Cue_Establecimiento_Baja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->Cue_Establecimiento_Baja->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->Cue_Establecimiento_Baja->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->Fecha_Pase) == "") { ?>
		<th data-name="Fecha_Pase"><div id="elh_pase_establecimiento_Fecha_Pase" class="pase_establecimiento_Fecha_Pase"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Pase"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->Fecha_Pase) ?>',1);"><div id="elh_pase_establecimiento_Fecha_Pase" class="pase_establecimiento_Fecha_Pase">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->Fecha_Pase->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->Fecha_Pase->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
	<?php if ($pase_establecimiento->SortUrl($pase_establecimiento->Id_Estado_Pase) == "") { ?>
		<th data-name="Id_Estado_Pase"><div id="elh_pase_establecimiento_Id_Estado_Pase" class="pase_establecimiento_Id_Estado_Pase"><div class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Pase"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pase_establecimiento->SortUrl($pase_establecimiento->Id_Estado_Pase) ?>',1);"><div id="elh_pase_establecimiento_Id_Estado_Pase" class="pase_establecimiento_Id_Estado_Pase">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pase_establecimiento->Id_Estado_Pase->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pase_establecimiento->Id_Estado_Pase->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pase_establecimiento_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pase_establecimiento->ExportAll && $pase_establecimiento->Export <> "") {
	$pase_establecimiento_list->StopRec = $pase_establecimiento_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pase_establecimiento_list->TotalRecs > $pase_establecimiento_list->StartRec + $pase_establecimiento_list->DisplayRecs - 1)
		$pase_establecimiento_list->StopRec = $pase_establecimiento_list->StartRec + $pase_establecimiento_list->DisplayRecs - 1;
	else
		$pase_establecimiento_list->StopRec = $pase_establecimiento_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($pase_establecimiento_list->FormKeyCountName) && ($pase_establecimiento->CurrentAction == "gridadd" || $pase_establecimiento->CurrentAction == "gridedit" || $pase_establecimiento->CurrentAction == "F")) {
		$pase_establecimiento_list->KeyCount = $objForm->GetValue($pase_establecimiento_list->FormKeyCountName);
		$pase_establecimiento_list->StopRec = $pase_establecimiento_list->StartRec + $pase_establecimiento_list->KeyCount - 1;
	}
}
$pase_establecimiento_list->RecCnt = $pase_establecimiento_list->StartRec - 1;
if ($pase_establecimiento_list->Recordset && !$pase_establecimiento_list->Recordset->EOF) {
	$pase_establecimiento_list->Recordset->MoveFirst();
	$bSelectLimit = $pase_establecimiento_list->UseSelectLimit;
	if (!$bSelectLimit && $pase_establecimiento_list->StartRec > 1)
		$pase_establecimiento_list->Recordset->Move($pase_establecimiento_list->StartRec - 1);
} elseif (!$pase_establecimiento->AllowAddDeleteRow && $pase_establecimiento_list->StopRec == 0) {
	$pase_establecimiento_list->StopRec = $pase_establecimiento->GridAddRowCount;
}

// Initialize aggregate
$pase_establecimiento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pase_establecimiento->ResetAttrs();
$pase_establecimiento_list->RenderRow();
if ($pase_establecimiento->CurrentAction == "gridadd")
	$pase_establecimiento_list->RowIndex = 0;
if ($pase_establecimiento->CurrentAction == "gridedit")
	$pase_establecimiento_list->RowIndex = 0;
while ($pase_establecimiento_list->RecCnt < $pase_establecimiento_list->StopRec) {
	$pase_establecimiento_list->RecCnt++;
	if (intval($pase_establecimiento_list->RecCnt) >= intval($pase_establecimiento_list->StartRec)) {
		$pase_establecimiento_list->RowCnt++;
		if ($pase_establecimiento->CurrentAction == "gridadd" || $pase_establecimiento->CurrentAction == "gridedit" || $pase_establecimiento->CurrentAction == "F") {
			$pase_establecimiento_list->RowIndex++;
			$objForm->Index = $pase_establecimiento_list->RowIndex;
			if ($objForm->HasValue($pase_establecimiento_list->FormActionName))
				$pase_establecimiento_list->RowAction = strval($objForm->GetValue($pase_establecimiento_list->FormActionName));
			elseif ($pase_establecimiento->CurrentAction == "gridadd")
				$pase_establecimiento_list->RowAction = "insert";
			else
				$pase_establecimiento_list->RowAction = "";
		}

		// Set up key count
		$pase_establecimiento_list->KeyCount = $pase_establecimiento_list->RowIndex;

		// Init row class and style
		$pase_establecimiento->ResetAttrs();
		$pase_establecimiento->CssClass = "";
		if ($pase_establecimiento->CurrentAction == "gridadd") {
			$pase_establecimiento_list->LoadDefaultValues(); // Load default values
		} else {
			$pase_establecimiento_list->LoadRowValues($pase_establecimiento_list->Recordset); // Load row values
		}
		$pase_establecimiento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($pase_establecimiento->CurrentAction == "gridadd") // Grid add
			$pase_establecimiento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($pase_establecimiento->CurrentAction == "gridadd" && $pase_establecimiento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$pase_establecimiento_list->RestoreCurrentRowFormValues($pase_establecimiento_list->RowIndex); // Restore form values
		if ($pase_establecimiento->CurrentAction == "gridedit") { // Grid edit
			if ($pase_establecimiento->EventCancelled) {
				$pase_establecimiento_list->RestoreCurrentRowFormValues($pase_establecimiento_list->RowIndex); // Restore form values
			}
			if ($pase_establecimiento_list->RowAction == "insert")
				$pase_establecimiento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$pase_establecimiento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($pase_establecimiento->CurrentAction == "gridedit" && ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT || $pase_establecimiento->RowType == EW_ROWTYPE_ADD) && $pase_establecimiento->EventCancelled) // Update failed
			$pase_establecimiento_list->RestoreCurrentRowFormValues($pase_establecimiento_list->RowIndex); // Restore form values
		if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$pase_establecimiento_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pase_establecimiento->RowAttrs = array_merge($pase_establecimiento->RowAttrs, array('data-rowindex'=>$pase_establecimiento_list->RowCnt, 'id'=>'r' . $pase_establecimiento_list->RowCnt . '_pase_establecimiento', 'data-rowtype'=>$pase_establecimiento->RowType));

		// Render row
		$pase_establecimiento_list->RenderRow();

		// Render list options
		$pase_establecimiento_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pase_establecimiento_list->RowAction <> "delete" && $pase_establecimiento_list->RowAction <> "insertdelete" && !($pase_establecimiento_list->RowAction == "insert" && $pase_establecimiento->CurrentAction == "F" && $pase_establecimiento_list->EmptyRow())) {
?>
	<tr<?php echo $pase_establecimiento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pase_establecimiento_list->ListOptions->Render("body", "left", $pase_establecimiento_list->RowCnt);
?>
	<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
		<td data-name="Id_Pase"<?php echo $pase_establecimiento->Id_Pase->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Pase->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Id_Pase" class="form-group pase_establecimiento_Id_Pase">
<span<?php echo $pase_establecimiento->Id_Pase->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pase_establecimiento->Id_Pase->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Pase->CurrentValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Id_Pase" class="pase_establecimiento_Id_Pase">
<span<?php echo $pase_establecimiento->Id_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Pase->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $pase_establecimiento_list->PageObjName . "_row_" . $pase_establecimiento_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pase_establecimiento->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $pase_establecimiento->NroSerie->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_NroSerie" class="form-group pase_establecimiento_NroSerie">
<?php
$wrkonchange = trim(" " . @$pase_establecimiento->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pase_establecimiento->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $pase_establecimiento_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>"<?php echo $pase_establecimiento->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" data-value-separator="<?php echo $pase_establecimiento->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpase_establecimientolist.CreateAutoSuggest({"id":"x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_NroSerie" class="form-group pase_establecimiento_NroSerie">
<?php
$wrkonchange = trim(" " . @$pase_establecimiento->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pase_establecimiento->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $pase_establecimiento_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>"<?php echo $pase_establecimiento->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" data-value-separator="<?php echo $pase_establecimiento->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpase_establecimientolist.CreateAutoSuggest({"id":"x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie","forceSelect":false});
</script>
</span>
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_NroSerie" class="pase_establecimiento_NroSerie">
<span<?php echo $pase_establecimiento->NroSerie->ViewAttributes() ?>>
<?php echo $pase_establecimiento->NroSerie->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
		<td data-name="Cue_Establecimiento_Alta"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Alta" class="form-group pase_establecimiento_Cue_Establecimiento_Alta">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Alta->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Alta->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Alta->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo ew_HtmlEncode($pase_establecimiento->Cue_Establecimiento_Alta->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Alta" class="form-group pase_establecimiento_Cue_Establecimiento_Alta">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Alta->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Alta->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Alta->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Alta" class="pase_establecimiento_Cue_Establecimiento_Alta">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
		<td data-name="Cue_Establecimiento_Baja"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Baja" class="form-group pase_establecimiento_Cue_Establecimiento_Baja">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Baja->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Baja->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Baja->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo ew_HtmlEncode($pase_establecimiento->Cue_Establecimiento_Baja->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Baja" class="form-group pase_establecimiento_Cue_Establecimiento_Baja">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Baja->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Baja->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Baja->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Baja" class="pase_establecimiento_Cue_Establecimiento_Baja">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
		<td data-name="Fecha_Pase"<?php echo $pase_establecimiento->Fecha_Pase->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Fecha_Pase" class="form-group pase_establecimiento_Fecha_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Fecha_Pase->EditValue ?>"<?php echo $pase_establecimiento->Fecha_Pase->EditAttributes() ?>>
<?php if (!$pase_establecimiento->Fecha_Pase->ReadOnly && !$pase_establecimiento->Fecha_Pase->Disabled && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["readonly"]) && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpase_establecimientolist", "x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Fecha_Pase" class="form-group pase_establecimiento_Fecha_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Fecha_Pase->EditValue ?>"<?php echo $pase_establecimiento->Fecha_Pase->EditAttributes() ?>>
<?php if (!$pase_establecimiento->Fecha_Pase->ReadOnly && !$pase_establecimiento->Fecha_Pase->Disabled && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["readonly"]) && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpase_establecimientolist", "x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase", 0);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Fecha_Pase" class="pase_establecimiento_Fecha_Pase">
<span<?php echo $pase_establecimiento->Fecha_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Fecha_Pase->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
		<td data-name="Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->CellAttributes() ?>>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Id_Estado_Pase" class="form-group pase_establecimiento_Id_Estado_Pase">
<select data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" data-value-separator="<?php echo $pase_establecimiento->Id_Estado_Pase->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->EditAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->SelectOptionListHtml("x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase") ?>
</select>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" value="<?php echo $pase_establecimiento->Id_Estado_Pase->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Estado_Pase->OldValue) ?>">
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Id_Estado_Pase" class="form-group pase_establecimiento_Id_Estado_Pase">
<select data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" data-value-separator="<?php echo $pase_establecimiento->Id_Estado_Pase->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->EditAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->SelectOptionListHtml("x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase") ?>
</select>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" value="<?php echo $pase_establecimiento->Id_Estado_Pase->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pase_establecimiento_list->RowCnt ?>_pase_establecimiento_Id_Estado_Pase" class="pase_establecimiento_Id_Estado_Pase">
<span<?php echo $pase_establecimiento->Id_Estado_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pase_establecimiento_list->ListOptions->Render("body", "right", $pase_establecimiento_list->RowCnt);
?>
	</tr>
<?php if ($pase_establecimiento->RowType == EW_ROWTYPE_ADD || $pase_establecimiento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpase_establecimientolist.UpdateOpts(<?php echo $pase_establecimiento_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($pase_establecimiento->CurrentAction <> "gridadd")
		if (!$pase_establecimiento_list->Recordset->EOF) $pase_establecimiento_list->Recordset->MoveNext();
}
?>
<?php
	if ($pase_establecimiento->CurrentAction == "gridadd" || $pase_establecimiento->CurrentAction == "gridedit") {
		$pase_establecimiento_list->RowIndex = '$rowindex$';
		$pase_establecimiento_list->LoadDefaultValues();

		// Set row properties
		$pase_establecimiento->ResetAttrs();
		$pase_establecimiento->RowAttrs = array_merge($pase_establecimiento->RowAttrs, array('data-rowindex'=>$pase_establecimiento_list->RowIndex, 'id'=>'r0_pase_establecimiento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($pase_establecimiento->RowAttrs["class"], "ewTemplate");
		$pase_establecimiento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$pase_establecimiento_list->RenderRow();

		// Render list options
		$pase_establecimiento_list->RenderListOptions();
		$pase_establecimiento_list->StartRowCnt = 0;
?>
	<tr<?php echo $pase_establecimiento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pase_establecimiento_list->ListOptions->Render("body", "left", $pase_establecimiento_list->RowIndex);
?>
	<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
		<td data-name="Id_Pase">
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Pase->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<span id="el$rowindex$_pase_establecimiento_NroSerie" class="form-group pase_establecimiento_NroSerie">
<?php
$wrkonchange = trim(" " . @$pase_establecimiento->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pase_establecimiento->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $pase_establecimiento_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->getPlaceHolder()) ?>"<?php echo $pase_establecimiento->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" data-value-separator="<?php echo $pase_establecimiento->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="q_x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo $pase_establecimiento->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpase_establecimientolist.CreateAutoSuggest({"id":"x<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_NroSerie" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($pase_establecimiento->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
		<td data-name="Cue_Establecimiento_Alta">
<span id="el$rowindex$_pase_establecimiento_Cue_Establecimiento_Alta" class="form-group pase_establecimiento_Cue_Establecimiento_Alta">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Alta->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Alta->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Alta->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Alta" value="<?php echo ew_HtmlEncode($pase_establecimiento->Cue_Establecimiento_Alta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
		<td data-name="Cue_Establecimiento_Baja">
<span id="el$rowindex$_pase_establecimiento_Cue_Establecimiento_Baja" class="form-group pase_establecimiento_Cue_Establecimiento_Baja">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Baja->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Baja->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Baja->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CurrentValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Cue_Establecimiento_Baja" value="<?php echo ew_HtmlEncode($pase_establecimiento->Cue_Establecimiento_Baja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
		<td data-name="Fecha_Pase">
<span id="el$rowindex$_pase_establecimiento_Fecha_Pase" class="form-group pase_establecimiento_Fecha_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Fecha_Pase->EditValue ?>"<?php echo $pase_establecimiento->Fecha_Pase->EditAttributes() ?>>
<?php if (!$pase_establecimiento->Fecha_Pase->ReadOnly && !$pase_establecimiento->Fecha_Pase->Disabled && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["readonly"]) && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpase_establecimientolist", "x<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Fecha_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Fecha_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
		<td data-name="Id_Estado_Pase">
<span id="el$rowindex$_pase_establecimiento_Id_Estado_Pase" class="form-group pase_establecimiento_Id_Estado_Pase">
<select data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" data-value-separator="<?php echo $pase_establecimiento->Id_Estado_Pase->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" name="x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->EditAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->SelectOptionListHtml("x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase") ?>
</select>
<input type="hidden" name="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" id="s_x<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" value="<?php echo $pase_establecimiento->Id_Estado_Pase->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" name="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" id="o<?php echo $pase_establecimiento_list->RowIndex ?>_Id_Estado_Pase" value="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Estado_Pase->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pase_establecimiento_list->ListOptions->Render("body", "right", $pase_establecimiento_list->RowCnt);
?>
<script type="text/javascript">
fpase_establecimientolist.UpdateOpts(<?php echo $pase_establecimiento_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pase_establecimiento->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $pase_establecimiento_list->FormKeyCountName ?>" id="<?php echo $pase_establecimiento_list->FormKeyCountName ?>" value="<?php echo $pase_establecimiento_list->KeyCount ?>">
<?php echo $pase_establecimiento_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pase_establecimiento->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $pase_establecimiento_list->FormKeyCountName ?>" id="<?php echo $pase_establecimiento_list->FormKeyCountName ?>" value="<?php echo $pase_establecimiento_list->KeyCount ?>">
<?php echo $pase_establecimiento_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pase_establecimiento->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pase_establecimiento_list->Recordset)
	$pase_establecimiento_list->Recordset->Close();
?>
<?php if ($pase_establecimiento->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($pase_establecimiento->CurrentAction <> "gridadd" && $pase_establecimiento->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pase_establecimiento_list->Pager)) $pase_establecimiento_list->Pager = new cPrevNextPager($pase_establecimiento_list->StartRec, $pase_establecimiento_list->DisplayRecs, $pase_establecimiento_list->TotalRecs) ?>
<?php if ($pase_establecimiento_list->Pager->RecordCount > 0 && $pase_establecimiento_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pase_establecimiento_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pase_establecimiento_list->PageUrl() ?>start=<?php echo $pase_establecimiento_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pase_establecimiento_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pase_establecimiento_list->PageUrl() ?>start=<?php echo $pase_establecimiento_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pase_establecimiento_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pase_establecimiento_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pase_establecimiento_list->PageUrl() ?>start=<?php echo $pase_establecimiento_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pase_establecimiento_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pase_establecimiento_list->PageUrl() ?>start=<?php echo $pase_establecimiento_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pase_establecimiento_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pase_establecimiento_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pase_establecimiento_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pase_establecimiento_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pase_establecimiento_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pase_establecimiento_list->TotalRecs == 0 && $pase_establecimiento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pase_establecimiento_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">
fpase_establecimientolistsrch.FilterList = <?php echo $pase_establecimiento_list->GetFilterList() ?>;
fpase_establecimientolistsrch.Init();
fpase_establecimientolist.Init();
</script>
<?php } ?>
<?php
$pase_establecimiento_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pase_establecimiento_list->Page_Terminate();
?>
