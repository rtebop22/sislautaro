<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "establecimientos_educativos_paseinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$establecimientos_educativos_pase_list = NULL; // Initialize page object first

class cestablecimientos_educativos_pase_list extends cestablecimientos_educativos_pase {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'establecimientos_educativos_pase';

	// Page object name
	var $PageObjName = 'establecimientos_educativos_pase_list';

	// Grid form hidden field names
	var $FormName = 'festablecimientos_educativos_paselist';
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

		// Table object (establecimientos_educativos_pase)
		if (!isset($GLOBALS["establecimientos_educativos_pase"]) || get_class($GLOBALS["establecimientos_educativos_pase"]) == "cestablecimientos_educativos_pase") {
			$GLOBALS["establecimientos_educativos_pase"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["establecimientos_educativos_pase"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "establecimientos_educativos_paseadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "establecimientos_educativos_pasedelete.php";
		$this->MultiUpdateUrl = "establecimientos_educativos_paseupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'establecimientos_educativos_pase', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption festablecimientos_educativos_paselistsrch";

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
		$this->Cue_Establecimiento->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Nombre_Director->SetVisibility();
		$this->Cuil_Director->SetVisibility();
		$this->Nombre_Rte->SetVisibility();
		$this->Contacto_Rte->SetVisibility();
		$this->Nro_Serie_Server_Escolar->SetVisibility();
		$this->Contacto_Establecimiento->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Fecha_Actualizacion->Visible = !$this->IsAddOrEdit();
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
		global $EW_EXPORT, $establecimientos_educativos_pase;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($establecimientos_educativos_pase);
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
			$this->Cue_Establecimiento->setFormValue($arrKeyFlds[0]);
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
					$sKey .= $this->Cue_Establecimiento->CurrentValue;

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
		if ($objForm->HasValue("x_Cue_Establecimiento") && $objForm->HasValue("o_Cue_Establecimiento") && $this->Cue_Establecimiento->CurrentValue <> $this->Cue_Establecimiento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nombre_Establecimiento") && $objForm->HasValue("o_Nombre_Establecimiento") && $this->Nombre_Establecimiento->CurrentValue <> $this->Nombre_Establecimiento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nombre_Director") && $objForm->HasValue("o_Nombre_Director") && $this->Nombre_Director->CurrentValue <> $this->Nombre_Director->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cuil_Director") && $objForm->HasValue("o_Cuil_Director") && $this->Cuil_Director->CurrentValue <> $this->Cuil_Director->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nombre_Rte") && $objForm->HasValue("o_Nombre_Rte") && $this->Nombre_Rte->CurrentValue <> $this->Nombre_Rte->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Contacto_Rte") && $objForm->HasValue("o_Contacto_Rte") && $this->Contacto_Rte->CurrentValue <> $this->Contacto_Rte->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nro_Serie_Server_Escolar") && $objForm->HasValue("o_Nro_Serie_Server_Escolar") && $this->Nro_Serie_Server_Escolar->CurrentValue <> $this->Nro_Serie_Server_Escolar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Contacto_Establecimiento") && $objForm->HasValue("o_Contacto_Establecimiento") && $this->Contacto_Establecimiento->CurrentValue <> $this->Contacto_Establecimiento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Provincia") && $objForm->HasValue("o_Id_Provincia") && $this->Id_Provincia->CurrentValue <> $this->Id_Provincia->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Departamento") && $objForm->HasValue("o_Id_Departamento") && $this->Id_Departamento->CurrentValue <> $this->Id_Departamento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Localidad") && $objForm->HasValue("o_Id_Localidad") && $this->Id_Localidad->CurrentValue <> $this->Id_Localidad->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "festablecimientos_educativos_paselistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Cue_Establecimiento->AdvancedSearch->ToJSON(), ","); // Field Cue_Establecimiento
		$sFilterList = ew_Concat($sFilterList, $this->Nombre_Establecimiento->AdvancedSearch->ToJSON(), ","); // Field Nombre_Establecimiento
		$sFilterList = ew_Concat($sFilterList, $this->Nombre_Director->AdvancedSearch->ToJSON(), ","); // Field Nombre_Director
		$sFilterList = ew_Concat($sFilterList, $this->Cuil_Director->AdvancedSearch->ToJSON(), ","); // Field Cuil_Director
		$sFilterList = ew_Concat($sFilterList, $this->Nombre_Rte->AdvancedSearch->ToJSON(), ","); // Field Nombre_Rte
		$sFilterList = ew_Concat($sFilterList, $this->Contacto_Rte->AdvancedSearch->ToJSON(), ","); // Field Contacto_Rte
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Serie_Server_Escolar->AdvancedSearch->ToJSON(), ","); // Field Nro_Serie_Server_Escolar
		$sFilterList = ew_Concat($sFilterList, $this->Contacto_Establecimiento->AdvancedSearch->ToJSON(), ","); // Field Contacto_Establecimiento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Provincia->AdvancedSearch->ToJSON(), ","); // Field Id_Provincia
		$sFilterList = ew_Concat($sFilterList, $this->Id_Departamento->AdvancedSearch->ToJSON(), ","); // Field Id_Departamento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Localidad->AdvancedSearch->ToJSON(), ","); // Field Id_Localidad
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Actualizacion->AdvancedSearch->ToJSON(), ","); // Field Fecha_Actualizacion
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "festablecimientos_educativos_paselistsrch", $filters);
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

		// Field Cue_Establecimiento
		$this->Cue_Establecimiento->AdvancedSearch->SearchValue = @$filter["x_Cue_Establecimiento"];
		$this->Cue_Establecimiento->AdvancedSearch->SearchOperator = @$filter["z_Cue_Establecimiento"];
		$this->Cue_Establecimiento->AdvancedSearch->SearchCondition = @$filter["v_Cue_Establecimiento"];
		$this->Cue_Establecimiento->AdvancedSearch->SearchValue2 = @$filter["y_Cue_Establecimiento"];
		$this->Cue_Establecimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Cue_Establecimiento"];
		$this->Cue_Establecimiento->AdvancedSearch->Save();

		// Field Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = @$filter["x_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = @$filter["z_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchCondition = @$filter["v_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue2 = @$filter["y_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->Save();

		// Field Nombre_Director
		$this->Nombre_Director->AdvancedSearch->SearchValue = @$filter["x_Nombre_Director"];
		$this->Nombre_Director->AdvancedSearch->SearchOperator = @$filter["z_Nombre_Director"];
		$this->Nombre_Director->AdvancedSearch->SearchCondition = @$filter["v_Nombre_Director"];
		$this->Nombre_Director->AdvancedSearch->SearchValue2 = @$filter["y_Nombre_Director"];
		$this->Nombre_Director->AdvancedSearch->SearchOperator2 = @$filter["w_Nombre_Director"];
		$this->Nombre_Director->AdvancedSearch->Save();

		// Field Cuil_Director
		$this->Cuil_Director->AdvancedSearch->SearchValue = @$filter["x_Cuil_Director"];
		$this->Cuil_Director->AdvancedSearch->SearchOperator = @$filter["z_Cuil_Director"];
		$this->Cuil_Director->AdvancedSearch->SearchCondition = @$filter["v_Cuil_Director"];
		$this->Cuil_Director->AdvancedSearch->SearchValue2 = @$filter["y_Cuil_Director"];
		$this->Cuil_Director->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil_Director"];
		$this->Cuil_Director->AdvancedSearch->Save();

		// Field Nombre_Rte
		$this->Nombre_Rte->AdvancedSearch->SearchValue = @$filter["x_Nombre_Rte"];
		$this->Nombre_Rte->AdvancedSearch->SearchOperator = @$filter["z_Nombre_Rte"];
		$this->Nombre_Rte->AdvancedSearch->SearchCondition = @$filter["v_Nombre_Rte"];
		$this->Nombre_Rte->AdvancedSearch->SearchValue2 = @$filter["y_Nombre_Rte"];
		$this->Nombre_Rte->AdvancedSearch->SearchOperator2 = @$filter["w_Nombre_Rte"];
		$this->Nombre_Rte->AdvancedSearch->Save();

		// Field Contacto_Rte
		$this->Contacto_Rte->AdvancedSearch->SearchValue = @$filter["x_Contacto_Rte"];
		$this->Contacto_Rte->AdvancedSearch->SearchOperator = @$filter["z_Contacto_Rte"];
		$this->Contacto_Rte->AdvancedSearch->SearchCondition = @$filter["v_Contacto_Rte"];
		$this->Contacto_Rte->AdvancedSearch->SearchValue2 = @$filter["y_Contacto_Rte"];
		$this->Contacto_Rte->AdvancedSearch->SearchOperator2 = @$filter["w_Contacto_Rte"];
		$this->Contacto_Rte->AdvancedSearch->Save();

		// Field Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue = @$filter["x_Nro_Serie_Server_Escolar"];
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchOperator = @$filter["z_Nro_Serie_Server_Escolar"];
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchCondition = @$filter["v_Nro_Serie_Server_Escolar"];
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Serie_Server_Escolar"];
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Serie_Server_Escolar"];
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->Save();

		// Field Contacto_Establecimiento
		$this->Contacto_Establecimiento->AdvancedSearch->SearchValue = @$filter["x_Contacto_Establecimiento"];
		$this->Contacto_Establecimiento->AdvancedSearch->SearchOperator = @$filter["z_Contacto_Establecimiento"];
		$this->Contacto_Establecimiento->AdvancedSearch->SearchCondition = @$filter["v_Contacto_Establecimiento"];
		$this->Contacto_Establecimiento->AdvancedSearch->SearchValue2 = @$filter["y_Contacto_Establecimiento"];
		$this->Contacto_Establecimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Contacto_Establecimiento"];
		$this->Contacto_Establecimiento->AdvancedSearch->Save();

		// Field Id_Provincia
		$this->Id_Provincia->AdvancedSearch->SearchValue = @$filter["x_Id_Provincia"];
		$this->Id_Provincia->AdvancedSearch->SearchOperator = @$filter["z_Id_Provincia"];
		$this->Id_Provincia->AdvancedSearch->SearchCondition = @$filter["v_Id_Provincia"];
		$this->Id_Provincia->AdvancedSearch->SearchValue2 = @$filter["y_Id_Provincia"];
		$this->Id_Provincia->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Provincia"];
		$this->Id_Provincia->AdvancedSearch->Save();

		// Field Id_Departamento
		$this->Id_Departamento->AdvancedSearch->SearchValue = @$filter["x_Id_Departamento"];
		$this->Id_Departamento->AdvancedSearch->SearchOperator = @$filter["z_Id_Departamento"];
		$this->Id_Departamento->AdvancedSearch->SearchCondition = @$filter["v_Id_Departamento"];
		$this->Id_Departamento->AdvancedSearch->SearchValue2 = @$filter["y_Id_Departamento"];
		$this->Id_Departamento->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Departamento"];
		$this->Id_Departamento->AdvancedSearch->Save();

		// Field Id_Localidad
		$this->Id_Localidad->AdvancedSearch->SearchValue = @$filter["x_Id_Localidad"];
		$this->Id_Localidad->AdvancedSearch->SearchOperator = @$filter["z_Id_Localidad"];
		$this->Id_Localidad->AdvancedSearch->SearchCondition = @$filter["v_Id_Localidad"];
		$this->Id_Localidad->AdvancedSearch->SearchValue2 = @$filter["y_Id_Localidad"];
		$this->Id_Localidad->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Localidad"];
		$this->Id_Localidad->AdvancedSearch->Save();

		// Field Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = @$filter["x_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Cue_Establecimiento, $Default, FALSE); // Cue_Establecimiento
		$this->BuildSearchSql($sWhere, $this->Nombre_Establecimiento, $Default, FALSE); // Nombre_Establecimiento
		$this->BuildSearchSql($sWhere, $this->Nombre_Director, $Default, FALSE); // Nombre_Director
		$this->BuildSearchSql($sWhere, $this->Cuil_Director, $Default, FALSE); // Cuil_Director
		$this->BuildSearchSql($sWhere, $this->Nombre_Rte, $Default, FALSE); // Nombre_Rte
		$this->BuildSearchSql($sWhere, $this->Contacto_Rte, $Default, FALSE); // Contacto_Rte
		$this->BuildSearchSql($sWhere, $this->Nro_Serie_Server_Escolar, $Default, FALSE); // Nro_Serie_Server_Escolar
		$this->BuildSearchSql($sWhere, $this->Contacto_Establecimiento, $Default, FALSE); // Contacto_Establecimiento
		$this->BuildSearchSql($sWhere, $this->Id_Provincia, $Default, FALSE); // Id_Provincia
		$this->BuildSearchSql($sWhere, $this->Id_Departamento, $Default, FALSE); // Id_Departamento
		$this->BuildSearchSql($sWhere, $this->Id_Localidad, $Default, FALSE); // Id_Localidad
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Cue_Establecimiento->AdvancedSearch->Save(); // Cue_Establecimiento
			$this->Nombre_Establecimiento->AdvancedSearch->Save(); // Nombre_Establecimiento
			$this->Nombre_Director->AdvancedSearch->Save(); // Nombre_Director
			$this->Cuil_Director->AdvancedSearch->Save(); // Cuil_Director
			$this->Nombre_Rte->AdvancedSearch->Save(); // Nombre_Rte
			$this->Contacto_Rte->AdvancedSearch->Save(); // Contacto_Rte
			$this->Nro_Serie_Server_Escolar->AdvancedSearch->Save(); // Nro_Serie_Server_Escolar
			$this->Contacto_Establecimiento->AdvancedSearch->Save(); // Contacto_Establecimiento
			$this->Id_Provincia->AdvancedSearch->Save(); // Id_Provincia
			$this->Id_Departamento->AdvancedSearch->Save(); // Id_Departamento
			$this->Id_Localidad->AdvancedSearch->Save(); // Id_Localidad
			$this->Fecha_Actualizacion->AdvancedSearch->Save(); // Fecha_Actualizacion
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
		$this->BuildBasicSearchSQL($sWhere, $this->Cue_Establecimiento, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Establecimiento, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil_Director, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Rte, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Localidad, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Usuario, $arKeywords, $type);
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
		if ($this->Cue_Establecimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Establecimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Director->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil_Director->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Rte->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Contacto_Rte->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nro_Serie_Server_Escolar->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Contacto_Establecimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Provincia->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Departamento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Localidad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Actualizacion->AdvancedSearch->IssetSession())
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
		$this->Cue_Establecimiento->AdvancedSearch->UnsetSession();
		$this->Nombre_Establecimiento->AdvancedSearch->UnsetSession();
		$this->Nombre_Director->AdvancedSearch->UnsetSession();
		$this->Cuil_Director->AdvancedSearch->UnsetSession();
		$this->Nombre_Rte->AdvancedSearch->UnsetSession();
		$this->Contacto_Rte->AdvancedSearch->UnsetSession();
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->UnsetSession();
		$this->Contacto_Establecimiento->AdvancedSearch->UnsetSession();
		$this->Id_Provincia->AdvancedSearch->UnsetSession();
		$this->Id_Departamento->AdvancedSearch->UnsetSession();
		$this->Id_Localidad->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Cue_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Director->AdvancedSearch->Load();
		$this->Cuil_Director->AdvancedSearch->Load();
		$this->Nombre_Rte->AdvancedSearch->Load();
		$this->Contacto_Rte->AdvancedSearch->Load();
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->Load();
		$this->Contacto_Establecimiento->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Cue_Establecimiento); // Cue_Establecimiento
			$this->UpdateSort($this->Nombre_Establecimiento); // Nombre_Establecimiento
			$this->UpdateSort($this->Nombre_Director); // Nombre_Director
			$this->UpdateSort($this->Cuil_Director); // Cuil_Director
			$this->UpdateSort($this->Nombre_Rte); // Nombre_Rte
			$this->UpdateSort($this->Contacto_Rte); // Contacto_Rte
			$this->UpdateSort($this->Nro_Serie_Server_Escolar); // Nro_Serie_Server_Escolar
			$this->UpdateSort($this->Contacto_Establecimiento); // Contacto_Establecimiento
			$this->UpdateSort($this->Id_Provincia); // Id_Provincia
			$this->UpdateSort($this->Id_Departamento); // Id_Departamento
			$this->UpdateSort($this->Id_Localidad); // Id_Localidad
			$this->UpdateSort($this->Fecha_Actualizacion); // Fecha_Actualizacion
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
				$this->Cue_Establecimiento->setSort("");
				$this->Nombre_Establecimiento->setSort("");
				$this->Nombre_Director->setSort("");
				$this->Cuil_Director->setSort("");
				$this->Nombre_Rte->setSort("");
				$this->Contacto_Rte->setSort("");
				$this->Nro_Serie_Server_Escolar->setSort("");
				$this->Contacto_Establecimiento->setSort("");
				$this->Id_Provincia->setSort("");
				$this->Id_Departamento->setSort("");
				$this->Id_Localidad->setSort("");
				$this->Fecha_Actualizacion->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Cue_Establecimiento->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Cue_Establecimiento->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.festablecimientos_educativos_paselist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"festablecimientos_educativos_paselistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"festablecimientos_educativos_paselistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.festablecimientos_educativos_paselist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"festablecimientos_educativos_paselistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"establecimientos_educativos_pasesrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Cue_Establecimiento->CurrentValue = NULL;
		$this->Cue_Establecimiento->OldValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->CurrentValue = NULL;
		$this->Nombre_Establecimiento->OldValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Director->CurrentValue = NULL;
		$this->Nombre_Director->OldValue = $this->Nombre_Director->CurrentValue;
		$this->Cuil_Director->CurrentValue = NULL;
		$this->Cuil_Director->OldValue = $this->Cuil_Director->CurrentValue;
		$this->Nombre_Rte->CurrentValue = NULL;
		$this->Nombre_Rte->OldValue = $this->Nombre_Rte->CurrentValue;
		$this->Contacto_Rte->CurrentValue = NULL;
		$this->Contacto_Rte->OldValue = $this->Contacto_Rte->CurrentValue;
		$this->Nro_Serie_Server_Escolar->CurrentValue = NULL;
		$this->Nro_Serie_Server_Escolar->OldValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Contacto_Establecimiento->CurrentValue = NULL;
		$this->Contacto_Establecimiento->OldValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Id_Provincia->CurrentValue = NULL;
		$this->Id_Provincia->OldValue = $this->Id_Provincia->CurrentValue;
		$this->Id_Departamento->CurrentValue = NULL;
		$this->Id_Departamento->OldValue = $this->Id_Departamento->CurrentValue;
		$this->Id_Localidad->CurrentValue = NULL;
		$this->Id_Localidad->OldValue = $this->Id_Localidad->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
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
		// Cue_Establecimiento

		$this->Cue_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cue_Establecimiento"]);
		if ($this->Cue_Establecimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cue_Establecimiento->AdvancedSearch->SearchOperator = @$_GET["z_Cue_Establecimiento"];

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Establecimiento"]);
		if ($this->Nombre_Establecimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Establecimiento"];

		// Nombre_Director
		$this->Nombre_Director->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Director"]);
		if ($this->Nombre_Director->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Director->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Director"];

		// Cuil_Director
		$this->Cuil_Director->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil_Director"]);
		if ($this->Cuil_Director->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil_Director->AdvancedSearch->SearchOperator = @$_GET["z_Cuil_Director"];

		// Nombre_Rte
		$this->Nombre_Rte->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Rte"]);
		if ($this->Nombre_Rte->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Rte->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Rte"];

		// Contacto_Rte
		$this->Contacto_Rte->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Contacto_Rte"]);
		if ($this->Contacto_Rte->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Contacto_Rte->AdvancedSearch->SearchOperator = @$_GET["z_Contacto_Rte"];

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nro_Serie_Server_Escolar"]);
		if ($this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchOperator = @$_GET["z_Nro_Serie_Server_Escolar"];

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Contacto_Establecimiento"]);
		if ($this->Contacto_Establecimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Contacto_Establecimiento->AdvancedSearch->SearchOperator = @$_GET["z_Contacto_Establecimiento"];

		// Id_Provincia
		$this->Id_Provincia->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Provincia"]);
		if ($this->Id_Provincia->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Provincia->AdvancedSearch->SearchOperator = @$_GET["z_Id_Provincia"];

		// Id_Departamento
		$this->Id_Departamento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Departamento"]);
		if ($this->Id_Departamento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Departamento->AdvancedSearch->SearchOperator = @$_GET["z_Id_Departamento"];

		// Id_Localidad
		$this->Id_Localidad->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Localidad"]);
		if ($this->Id_Localidad->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Localidad->AdvancedSearch->SearchOperator = @$_GET["z_Id_Localidad"];

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Actualizacion"]);
		if ($this->Fecha_Actualizacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Actualizacion"];

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Usuario"]);
		if ($this->Usuario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Usuario->AdvancedSearch->SearchOperator = @$_GET["z_Usuario"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Cue_Establecimiento->FldIsDetailKey) {
			$this->Cue_Establecimiento->setFormValue($objForm->GetValue("x_Cue_Establecimiento"));
		}
		$this->Cue_Establecimiento->setOldValue($objForm->GetValue("o_Cue_Establecimiento"));
		if (!$this->Nombre_Establecimiento->FldIsDetailKey) {
			$this->Nombre_Establecimiento->setFormValue($objForm->GetValue("x_Nombre_Establecimiento"));
		}
		$this->Nombre_Establecimiento->setOldValue($objForm->GetValue("o_Nombre_Establecimiento"));
		if (!$this->Nombre_Director->FldIsDetailKey) {
			$this->Nombre_Director->setFormValue($objForm->GetValue("x_Nombre_Director"));
		}
		$this->Nombre_Director->setOldValue($objForm->GetValue("o_Nombre_Director"));
		if (!$this->Cuil_Director->FldIsDetailKey) {
			$this->Cuil_Director->setFormValue($objForm->GetValue("x_Cuil_Director"));
		}
		$this->Cuil_Director->setOldValue($objForm->GetValue("o_Cuil_Director"));
		if (!$this->Nombre_Rte->FldIsDetailKey) {
			$this->Nombre_Rte->setFormValue($objForm->GetValue("x_Nombre_Rte"));
		}
		$this->Nombre_Rte->setOldValue($objForm->GetValue("o_Nombre_Rte"));
		if (!$this->Contacto_Rte->FldIsDetailKey) {
			$this->Contacto_Rte->setFormValue($objForm->GetValue("x_Contacto_Rte"));
		}
		$this->Contacto_Rte->setOldValue($objForm->GetValue("o_Contacto_Rte"));
		if (!$this->Nro_Serie_Server_Escolar->FldIsDetailKey) {
			$this->Nro_Serie_Server_Escolar->setFormValue($objForm->GetValue("x_Nro_Serie_Server_Escolar"));
		}
		$this->Nro_Serie_Server_Escolar->setOldValue($objForm->GetValue("o_Nro_Serie_Server_Escolar"));
		if (!$this->Contacto_Establecimiento->FldIsDetailKey) {
			$this->Contacto_Establecimiento->setFormValue($objForm->GetValue("x_Contacto_Establecimiento"));
		}
		$this->Contacto_Establecimiento->setOldValue($objForm->GetValue("o_Contacto_Establecimiento"));
		if (!$this->Id_Provincia->FldIsDetailKey) {
			$this->Id_Provincia->setFormValue($objForm->GetValue("x_Id_Provincia"));
		}
		$this->Id_Provincia->setOldValue($objForm->GetValue("o_Id_Provincia"));
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->setOldValue($objForm->GetValue("o_Id_Departamento"));
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->setOldValue($objForm->GetValue("o_Id_Localidad"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		}
		$this->Fecha_Actualizacion->setOldValue($objForm->GetValue("o_Fecha_Actualizacion"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Cue_Establecimiento->CurrentValue = $this->Cue_Establecimiento->FormValue;
		$this->Nombre_Establecimiento->CurrentValue = $this->Nombre_Establecimiento->FormValue;
		$this->Nombre_Director->CurrentValue = $this->Nombre_Director->FormValue;
		$this->Cuil_Director->CurrentValue = $this->Cuil_Director->FormValue;
		$this->Nombre_Rte->CurrentValue = $this->Nombre_Rte->FormValue;
		$this->Contacto_Rte->CurrentValue = $this->Contacto_Rte->FormValue;
		$this->Nro_Serie_Server_Escolar->CurrentValue = $this->Nro_Serie_Server_Escolar->FormValue;
		$this->Contacto_Establecimiento->CurrentValue = $this->Contacto_Establecimiento->FormValue;
		$this->Id_Provincia->CurrentValue = $this->Id_Provincia->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
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
		$this->Cue_Establecimiento->setDbValue($rs->fields('Cue_Establecimiento'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Nombre_Director->setDbValue($rs->fields('Nombre_Director'));
		$this->Cuil_Director->setDbValue($rs->fields('Cuil_Director'));
		$this->Nombre_Rte->setDbValue($rs->fields('Nombre_Rte'));
		$this->Contacto_Rte->setDbValue($rs->fields('Contacto_Rte'));
		$this->Nro_Serie_Server_Escolar->setDbValue($rs->fields('Nro_Serie_Server_Escolar'));
		$this->Contacto_Establecimiento->setDbValue($rs->fields('Contacto_Establecimiento'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue_Establecimiento->DbValue = $row['Cue_Establecimiento'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Nombre_Director->DbValue = $row['Nombre_Director'];
		$this->Cuil_Director->DbValue = $row['Cuil_Director'];
		$this->Nombre_Rte->DbValue = $row['Nombre_Rte'];
		$this->Contacto_Rte->DbValue = $row['Contacto_Rte'];
		$this->Nro_Serie_Server_Escolar->DbValue = $row['Nro_Serie_Server_Escolar'];
		$this->Contacto_Establecimiento->DbValue = $row['Contacto_Establecimiento'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Cue_Establecimiento")) <> "")
			$this->Cue_Establecimiento->CurrentValue = $this->getKey("Cue_Establecimiento"); // Cue_Establecimiento
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
		// Cue_Establecimiento
		// Nombre_Establecimiento
		// Nombre_Director

		$this->Nombre_Director->CellCssStyle = "white-space: nowrap;";

		// Cuil_Director
		$this->Cuil_Director->CellCssStyle = "white-space: nowrap;";

		// Nombre_Rte
		// Contacto_Rte
		// Nro_Serie_Server_Escolar
		// Contacto_Establecimiento
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue_Establecimiento
		$this->Cue_Establecimiento->ViewValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Cue_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Director
		$this->Nombre_Director->ViewValue = $this->Nombre_Director->CurrentValue;
		$this->Nombre_Director->ViewCustomAttributes = "";

		// Cuil_Director
		$this->Cuil_Director->ViewValue = $this->Cuil_Director->CurrentValue;
		$this->Cuil_Director->ViewCustomAttributes = "";

		// Nombre_Rte
		$this->Nombre_Rte->ViewValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->ViewCustomAttributes = "";

		// Contacto_Rte
		$this->Contacto_Rte->ViewValue = $this->Contacto_Rte->CurrentValue;
		$this->Contacto_Rte->ViewCustomAttributes = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->ViewValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->ViewCustomAttributes = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->ViewValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->CurrentValue;
			}
		} else {
			$this->Id_Provincia->ViewValue = NULL;
		}
		$this->Id_Provincia->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->CurrentValue;
			}
		} else {
			$this->Id_Departamento->ViewValue = NULL;
		}
		$this->Id_Departamento->ViewCustomAttributes = "";

		// Id_Localidad
		if (strval($this->Id_Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Id_Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->CurrentValue;
			}
		} else {
			$this->Id_Localidad->ViewValue = NULL;
		}
		$this->Id_Localidad->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue_Establecimiento
			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";
			$this->Cue_Establecimiento->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

			// Nombre_Director
			$this->Nombre_Director->LinkCustomAttributes = "";
			$this->Nombre_Director->HrefValue = "";
			$this->Nombre_Director->TooltipValue = "";

			// Cuil_Director
			$this->Cuil_Director->LinkCustomAttributes = "";
			$this->Cuil_Director->HrefValue = "";
			$this->Cuil_Director->TooltipValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";
			$this->Nombre_Rte->TooltipValue = "";

			// Contacto_Rte
			$this->Contacto_Rte->LinkCustomAttributes = "";
			$this->Contacto_Rte->HrefValue = "";
			$this->Contacto_Rte->TooltipValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";
			$this->Nro_Serie_Server_Escolar->TooltipValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";
			$this->Contacto_Establecimiento->TooltipValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";
			$this->Id_Provincia->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Cue_Establecimiento
			$this->Cue_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento->EditCustomAttributes = "";
			$this->Cue_Establecimiento->EditValue = ew_HtmlEncode($this->Cue_Establecimiento->CurrentValue);
			$this->Cue_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento->FldCaption());

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Nombre_Director
			$this->Nombre_Director->EditAttrs["class"] = "form-control";
			$this->Nombre_Director->EditCustomAttributes = "";
			$this->Nombre_Director->EditValue = ew_HtmlEncode($this->Nombre_Director->CurrentValue);
			$this->Nombre_Director->PlaceHolder = ew_RemoveHtml($this->Nombre_Director->FldCaption());

			// Cuil_Director
			$this->Cuil_Director->EditAttrs["class"] = "form-control";
			$this->Cuil_Director->EditCustomAttributes = "";
			$this->Cuil_Director->EditValue = ew_HtmlEncode($this->Cuil_Director->CurrentValue);
			$this->Cuil_Director->PlaceHolder = ew_RemoveHtml($this->Cuil_Director->FldCaption());

			// Nombre_Rte
			$this->Nombre_Rte->EditAttrs["class"] = "form-control";
			$this->Nombre_Rte->EditCustomAttributes = "";
			$this->Nombre_Rte->EditValue = ew_HtmlEncode($this->Nombre_Rte->CurrentValue);
			$this->Nombre_Rte->PlaceHolder = ew_RemoveHtml($this->Nombre_Rte->FldCaption());

			// Contacto_Rte
			$this->Contacto_Rte->EditAttrs["class"] = "form-control";
			$this->Contacto_Rte->EditCustomAttributes = "";
			$this->Contacto_Rte->EditValue = ew_HtmlEncode($this->Contacto_Rte->CurrentValue);
			$this->Contacto_Rte->PlaceHolder = ew_RemoveHtml($this->Contacto_Rte->FldCaption());

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->EditAttrs["class"] = "form-control";
			$this->Nro_Serie_Server_Escolar->EditCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->EditValue = ew_HtmlEncode($this->Nro_Serie_Server_Escolar->CurrentValue);
			$this->Nro_Serie_Server_Escolar->PlaceHolder = ew_RemoveHtml($this->Nro_Serie_Server_Escolar->FldCaption());

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Contacto_Establecimiento->EditCustomAttributes = "";
			$this->Contacto_Establecimiento->EditValue = ew_HtmlEncode($this->Contacto_Establecimiento->CurrentValue);
			$this->Contacto_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Contacto_Establecimiento->FldCaption());

			// Id_Provincia
			$this->Id_Provincia->EditAttrs["class"] = "form-control";
			$this->Id_Provincia->EditCustomAttributes = "";
			if (trim(strval($this->Id_Provincia->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Provincia->EditValue = $arwrk;

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Cue_Establecimiento

			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Nombre_Director
			$this->Nombre_Director->LinkCustomAttributes = "";
			$this->Nombre_Director->HrefValue = "";

			// Cuil_Director
			$this->Cuil_Director->LinkCustomAttributes = "";
			$this->Cuil_Director->HrefValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";

			// Contacto_Rte
			$this->Contacto_Rte->LinkCustomAttributes = "";
			$this->Contacto_Rte->HrefValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Cue_Establecimiento
			$this->Cue_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento->EditCustomAttributes = "";
			$this->Cue_Establecimiento->EditValue = $this->Cue_Establecimiento->CurrentValue;
			$this->Cue_Establecimiento->ViewCustomAttributes = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Nombre_Director
			$this->Nombre_Director->EditAttrs["class"] = "form-control";
			$this->Nombre_Director->EditCustomAttributes = "";
			$this->Nombre_Director->EditValue = ew_HtmlEncode($this->Nombre_Director->CurrentValue);
			$this->Nombre_Director->PlaceHolder = ew_RemoveHtml($this->Nombre_Director->FldCaption());

			// Cuil_Director
			$this->Cuil_Director->EditAttrs["class"] = "form-control";
			$this->Cuil_Director->EditCustomAttributes = "";
			$this->Cuil_Director->EditValue = ew_HtmlEncode($this->Cuil_Director->CurrentValue);
			$this->Cuil_Director->PlaceHolder = ew_RemoveHtml($this->Cuil_Director->FldCaption());

			// Nombre_Rte
			$this->Nombre_Rte->EditAttrs["class"] = "form-control";
			$this->Nombre_Rte->EditCustomAttributes = "";
			$this->Nombre_Rte->EditValue = ew_HtmlEncode($this->Nombre_Rte->CurrentValue);
			$this->Nombre_Rte->PlaceHolder = ew_RemoveHtml($this->Nombre_Rte->FldCaption());

			// Contacto_Rte
			$this->Contacto_Rte->EditAttrs["class"] = "form-control";
			$this->Contacto_Rte->EditCustomAttributes = "";
			$this->Contacto_Rte->EditValue = ew_HtmlEncode($this->Contacto_Rte->CurrentValue);
			$this->Contacto_Rte->PlaceHolder = ew_RemoveHtml($this->Contacto_Rte->FldCaption());

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->EditAttrs["class"] = "form-control";
			$this->Nro_Serie_Server_Escolar->EditCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->EditValue = ew_HtmlEncode($this->Nro_Serie_Server_Escolar->CurrentValue);
			$this->Nro_Serie_Server_Escolar->PlaceHolder = ew_RemoveHtml($this->Nro_Serie_Server_Escolar->FldCaption());

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Contacto_Establecimiento->EditCustomAttributes = "";
			$this->Contacto_Establecimiento->EditValue = ew_HtmlEncode($this->Contacto_Establecimiento->CurrentValue);
			$this->Contacto_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Contacto_Establecimiento->FldCaption());

			// Id_Provincia
			$this->Id_Provincia->EditAttrs["class"] = "form-control";
			$this->Id_Provincia->EditCustomAttributes = "";
			if (trim(strval($this->Id_Provincia->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Provincia->EditValue = $arwrk;

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Cue_Establecimiento

			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Nombre_Director
			$this->Nombre_Director->LinkCustomAttributes = "";
			$this->Nombre_Director->HrefValue = "";

			// Cuil_Director
			$this->Cuil_Director->LinkCustomAttributes = "";
			$this->Cuil_Director->HrefValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";

			// Contacto_Rte
			$this->Contacto_Rte->LinkCustomAttributes = "";
			$this->Contacto_Rte->HrefValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

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
		if (!$this->Cue_Establecimiento->FldIsDetailKey && !is_null($this->Cue_Establecimiento->FormValue) && $this->Cue_Establecimiento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cue_Establecimiento->FldCaption(), $this->Cue_Establecimiento->ReqErrMsg));
		}
		if (!$this->Id_Provincia->FldIsDetailKey && !is_null($this->Id_Provincia->FormValue) && $this->Id_Provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Provincia->FldCaption(), $this->Id_Provincia->ReqErrMsg));
		}
		if (!$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if (!$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
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
				$sThisKey .= $row['Cue_Establecimiento'];
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

			// Cue_Establecimiento
			// Nombre_Establecimiento

			$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, $this->Nombre_Establecimiento->ReadOnly);

			// Nombre_Director
			$this->Nombre_Director->SetDbValueDef($rsnew, $this->Nombre_Director->CurrentValue, NULL, $this->Nombre_Director->ReadOnly);

			// Cuil_Director
			$this->Cuil_Director->SetDbValueDef($rsnew, $this->Cuil_Director->CurrentValue, NULL, $this->Cuil_Director->ReadOnly);

			// Nombre_Rte
			$this->Nombre_Rte->SetDbValueDef($rsnew, $this->Nombre_Rte->CurrentValue, NULL, $this->Nombre_Rte->ReadOnly);

			// Contacto_Rte
			$this->Contacto_Rte->SetDbValueDef($rsnew, $this->Contacto_Rte->CurrentValue, NULL, $this->Contacto_Rte->ReadOnly);

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->SetDbValueDef($rsnew, $this->Nro_Serie_Server_Escolar->CurrentValue, NULL, $this->Nro_Serie_Server_Escolar->ReadOnly);

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->SetDbValueDef($rsnew, $this->Contacto_Establecimiento->CurrentValue, NULL, $this->Contacto_Establecimiento->ReadOnly);

			// Id_Provincia
			$this->Id_Provincia->SetDbValueDef($rsnew, $this->Id_Provincia->CurrentValue, 0, $this->Id_Provincia->ReadOnly);

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly);

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly);

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

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

		// Cue_Establecimiento
		$this->Cue_Establecimiento->SetDbValueDef($rsnew, $this->Cue_Establecimiento->CurrentValue, "", FALSE);

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, FALSE);

		// Nombre_Director
		$this->Nombre_Director->SetDbValueDef($rsnew, $this->Nombre_Director->CurrentValue, NULL, FALSE);

		// Cuil_Director
		$this->Cuil_Director->SetDbValueDef($rsnew, $this->Cuil_Director->CurrentValue, NULL, FALSE);

		// Nombre_Rte
		$this->Nombre_Rte->SetDbValueDef($rsnew, $this->Nombre_Rte->CurrentValue, NULL, FALSE);

		// Contacto_Rte
		$this->Contacto_Rte->SetDbValueDef($rsnew, $this->Contacto_Rte->CurrentValue, NULL, FALSE);

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->SetDbValueDef($rsnew, $this->Nro_Serie_Server_Escolar->CurrentValue, NULL, FALSE);

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->SetDbValueDef($rsnew, $this->Contacto_Establecimiento->CurrentValue, NULL, FALSE);

		// Id_Provincia
		$this->Id_Provincia->SetDbValueDef($rsnew, $this->Id_Provincia->CurrentValue, 0, FALSE);

		// Id_Departamento
		$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, FALSE);

		// Id_Localidad
		$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, FALSE);

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Cue_Establecimiento']) == "") {
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
		$this->Cue_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Director->AdvancedSearch->Load();
		$this->Cuil_Director->AdvancedSearch->Load();
		$this->Nombre_Rte->AdvancedSearch->Load();
		$this->Contacto_Rte->AdvancedSearch->Load();
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->Load();
		$this->Contacto_Establecimiento->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.festablecimientos_educativos_paselist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_establecimientos_educativos_pase\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_establecimientos_educativos_pase',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.festablecimientos_educativos_paselist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Id_Provincia":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Provincia` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Provincia` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "{filter}";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Provincia` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Localidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Localidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->Id_Localidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Localidad` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Departamento` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
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
if (!isset($establecimientos_educativos_pase_list)) $establecimientos_educativos_pase_list = new cestablecimientos_educativos_pase_list();

// Page init
$establecimientos_educativos_pase_list->Page_Init();

// Page main
$establecimientos_educativos_pase_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$establecimientos_educativos_pase_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = festablecimientos_educativos_paselist = new ew_Form("festablecimientos_educativos_paselist", "list");
festablecimientos_educativos_paselist.FormKeyCountName = '<?php echo $establecimientos_educativos_pase_list->FormKeyCountName ?>';

// Validate form
festablecimientos_educativos_paselist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Cue_Establecimiento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Cue_Establecimiento->FldCaption(), $establecimientos_educativos_pase->Cue_Establecimiento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Provincia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Provincia->FldCaption(), $establecimientos_educativos_pase->Id_Provincia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Departamento->FldCaption(), $establecimientos_educativos_pase->Id_Departamento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Localidad->FldCaption(), $establecimientos_educativos_pase->Id_Localidad->ReqErrMsg)) ?>");

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
festablecimientos_educativos_paselist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Cue_Establecimiento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nombre_Establecimiento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nombre_Director", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil_Director", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nombre_Rte", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Contacto_Rte", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nro_Serie_Server_Escolar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Contacto_Establecimiento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Provincia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Departamento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Localidad", false)) return false;
	return true;
}

// Form_CustomValidate event
festablecimientos_educativos_paselist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festablecimientos_educativos_paselist.ValidateRequired = true;
<?php } else { ?>
festablecimientos_educativos_paselist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festablecimientos_educativos_paselist.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
festablecimientos_educativos_paselist.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
festablecimientos_educativos_paselist.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
var CurrentSearchForm = festablecimientos_educativos_paselistsrch = new ew_Form("festablecimientos_educativos_paselistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<div class="ewToolbar">
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase_list->TotalRecs > 0 && $establecimientos_educativos_pase_list->ExportOptions->Visible()) { ?>
<?php $establecimientos_educativos_pase_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase_list->SearchOptions->Visible()) { ?>
<?php $establecimientos_educativos_pase_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase_list->FilterOptions->Visible()) { ?>
<?php $establecimientos_educativos_pase_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($establecimientos_educativos_pase->CurrentAction == "gridadd") {
	$establecimientos_educativos_pase->CurrentFilter = "0=1";
	$establecimientos_educativos_pase_list->StartRec = 1;
	$establecimientos_educativos_pase_list->DisplayRecs = $establecimientos_educativos_pase->GridAddRowCount;
	$establecimientos_educativos_pase_list->TotalRecs = $establecimientos_educativos_pase_list->DisplayRecs;
	$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase_list->DisplayRecs;
} else {
	$bSelectLimit = $establecimientos_educativos_pase_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($establecimientos_educativos_pase_list->TotalRecs <= 0)
			$establecimientos_educativos_pase_list->TotalRecs = $establecimientos_educativos_pase->SelectRecordCount();
	} else {
		if (!$establecimientos_educativos_pase_list->Recordset && ($establecimientos_educativos_pase_list->Recordset = $establecimientos_educativos_pase_list->LoadRecordset()))
			$establecimientos_educativos_pase_list->TotalRecs = $establecimientos_educativos_pase_list->Recordset->RecordCount();
	}
	$establecimientos_educativos_pase_list->StartRec = 1;
	if ($establecimientos_educativos_pase_list->DisplayRecs <= 0 || ($establecimientos_educativos_pase->Export <> "" && $establecimientos_educativos_pase->ExportAll)) // Display all records
		$establecimientos_educativos_pase_list->DisplayRecs = $establecimientos_educativos_pase_list->TotalRecs;
	if (!($establecimientos_educativos_pase->Export <> "" && $establecimientos_educativos_pase->ExportAll))
		$establecimientos_educativos_pase_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$establecimientos_educativos_pase_list->Recordset = $establecimientos_educativos_pase_list->LoadRecordset($establecimientos_educativos_pase_list->StartRec-1, $establecimientos_educativos_pase_list->DisplayRecs);

	// Set no record found message
	if ($establecimientos_educativos_pase->CurrentAction == "" && $establecimientos_educativos_pase_list->TotalRecs == 0) {
		if ($establecimientos_educativos_pase_list->SearchWhere == "0=101")
			$establecimientos_educativos_pase_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$establecimientos_educativos_pase_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$establecimientos_educativos_pase_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($establecimientos_educativos_pase->Export == "" && $establecimientos_educativos_pase->CurrentAction == "") { ?>
<form name="festablecimientos_educativos_paselistsrch" id="festablecimientos_educativos_paselistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($establecimientos_educativos_pase_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="festablecimientos_educativos_paselistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="establecimientos_educativos_pase">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $establecimientos_educativos_pase_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($establecimientos_educativos_pase_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($establecimientos_educativos_pase_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($establecimientos_educativos_pase_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($establecimientos_educativos_pase_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $establecimientos_educativos_pase_list->ShowPageHeader(); ?>
<?php
$establecimientos_educativos_pase_list->ShowMessage();
?>
<?php if ($establecimientos_educativos_pase_list->TotalRecs > 0 || $establecimientos_educativos_pase->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid establecimientos_educativos_pase">
<form name="festablecimientos_educativos_paselist" id="festablecimientos_educativos_paselist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($establecimientos_educativos_pase_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $establecimientos_educativos_pase_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="establecimientos_educativos_pase">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_establecimientos_educativos_pase" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($establecimientos_educativos_pase_list->TotalRecs > 0) { ?>
<table id="tbl_establecimientos_educativos_paselist" class="table ewTable">
<?php echo $establecimientos_educativos_pase->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$establecimientos_educativos_pase_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$establecimientos_educativos_pase_list->RenderListOptions();

// Render list options (header, left)
$establecimientos_educativos_pase_list->ListOptions->Render("header", "left");
?>
<?php if ($establecimientos_educativos_pase->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Cue_Establecimiento) == "") { ?>
		<th data-name="Cue_Establecimiento"><div id="elh_establecimientos_educativos_pase_Cue_Establecimiento" class="establecimientos_educativos_pase_Cue_Establecimiento"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Cue_Establecimiento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue_Establecimiento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Cue_Establecimiento) ?>',1);"><div id="elh_establecimientos_educativos_pase_Cue_Establecimiento" class="establecimientos_educativos_pase_Cue_Establecimiento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Cue_Establecimiento->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Cue_Establecimiento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Cue_Establecimiento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Establecimiento) == "") { ?>
		<th data-name="Nombre_Establecimiento"><div id="elh_establecimientos_educativos_pase_Nombre_Establecimiento" class="establecimientos_educativos_pase_Nombre_Establecimiento"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nombre_Establecimiento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Establecimiento) ?>',1);"><div id="elh_establecimientos_educativos_pase_Nombre_Establecimiento" class="establecimientos_educativos_pase_Nombre_Establecimiento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Nombre_Establecimiento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Nombre_Director->Visible) { // Nombre_Director ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Director) == "") { ?>
		<th data-name="Nombre_Director"><div id="elh_establecimientos_educativos_pase_Nombre_Director" class="establecimientos_educativos_pase_Nombre_Director"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $establecimientos_educativos_pase->Nombre_Director->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nombre_Director"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Director) ?>',1);"><div id="elh_establecimientos_educativos_pase_Nombre_Director" class="establecimientos_educativos_pase_Nombre_Director">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nombre_Director->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Nombre_Director->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Nombre_Director->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Cuil_Director->Visible) { // Cuil_Director ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Cuil_Director) == "") { ?>
		<th data-name="Cuil_Director"><div id="elh_establecimientos_educativos_pase_Cuil_Director" class="establecimientos_educativos_pase_Cuil_Director"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $establecimientos_educativos_pase->Cuil_Director->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil_Director"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Cuil_Director) ?>',1);"><div id="elh_establecimientos_educativos_pase_Cuil_Director" class="establecimientos_educativos_pase_Cuil_Director">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Cuil_Director->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Cuil_Director->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Cuil_Director->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Nombre_Rte->Visible) { // Nombre_Rte ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Rte) == "") { ?>
		<th data-name="Nombre_Rte"><div id="elh_establecimientos_educativos_pase_Nombre_Rte" class="establecimientos_educativos_pase_Nombre_Rte"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nombre_Rte->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nombre_Rte"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nombre_Rte) ?>',1);"><div id="elh_establecimientos_educativos_pase_Nombre_Rte" class="establecimientos_educativos_pase_Nombre_Rte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nombre_Rte->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Nombre_Rte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Nombre_Rte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Contacto_Rte->Visible) { // Contacto_Rte ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Contacto_Rte) == "") { ?>
		<th data-name="Contacto_Rte"><div id="elh_establecimientos_educativos_pase_Contacto_Rte" class="establecimientos_educativos_pase_Contacto_Rte"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Contacto_Rte->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Contacto_Rte"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Contacto_Rte) ?>',1);"><div id="elh_establecimientos_educativos_pase_Contacto_Rte" class="establecimientos_educativos_pase_Contacto_Rte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Contacto_Rte->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Contacto_Rte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Contacto_Rte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nro_Serie_Server_Escolar) == "") { ?>
		<th data-name="Nro_Serie_Server_Escolar"><div id="elh_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="establecimientos_educativos_pase_Nro_Serie_Server_Escolar"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Serie_Server_Escolar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Nro_Serie_Server_Escolar) ?>',1);"><div id="elh_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Contacto_Establecimiento) == "") { ?>
		<th data-name="Contacto_Establecimiento"><div id="elh_establecimientos_educativos_pase_Contacto_Establecimiento" class="establecimientos_educativos_pase_Contacto_Establecimiento"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Contacto_Establecimiento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Contacto_Establecimiento) ?>',1);"><div id="elh_establecimientos_educativos_pase_Contacto_Establecimiento" class="establecimientos_educativos_pase_Contacto_Establecimiento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Contacto_Establecimiento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Id_Provincia->Visible) { // Id_Provincia ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Provincia) == "") { ?>
		<th data-name="Id_Provincia"><div id="elh_establecimientos_educativos_pase_Id_Provincia" class="establecimientos_educativos_pase_Id_Provincia"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Provincia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Provincia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Provincia) ?>',1);"><div id="elh_establecimientos_educativos_pase_Id_Provincia" class="establecimientos_educativos_pase_Id_Provincia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Provincia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Id_Provincia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Id_Provincia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Id_Departamento->Visible) { // Id_Departamento ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Departamento) == "") { ?>
		<th data-name="Id_Departamento"><div id="elh_establecimientos_educativos_pase_Id_Departamento" class="establecimientos_educativos_pase_Id_Departamento"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Departamento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Departamento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Departamento) ?>',1);"><div id="elh_establecimientos_educativos_pase_Id_Departamento" class="establecimientos_educativos_pase_Id_Departamento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Departamento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Id_Departamento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Id_Departamento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Id_Localidad->Visible) { // Id_Localidad ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Localidad) == "") { ?>
		<th data-name="Id_Localidad"><div id="elh_establecimientos_educativos_pase_Id_Localidad" class="establecimientos_educativos_pase_Id_Localidad"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Localidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Localidad"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Id_Localidad) ?>',1);"><div id="elh_establecimientos_educativos_pase_Id_Localidad" class="establecimientos_educativos_pase_Id_Localidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Id_Localidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Id_Localidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Id_Localidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_establecimientos_educativos_pase_Fecha_Actualizacion" class="establecimientos_educativos_pase_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Fecha_Actualizacion) ?>',1);"><div id="elh_establecimientos_educativos_pase_Fecha_Actualizacion" class="establecimientos_educativos_pase_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($establecimientos_educativos_pase->Usuario->Visible) { // Usuario ?>
	<?php if ($establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_establecimientos_educativos_pase_Usuario" class="establecimientos_educativos_pase_Usuario"><div class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $establecimientos_educativos_pase->SortUrl($establecimientos_educativos_pase->Usuario) ?>',1);"><div id="elh_establecimientos_educativos_pase_Usuario" class="establecimientos_educativos_pase_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $establecimientos_educativos_pase->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($establecimientos_educativos_pase->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($establecimientos_educativos_pase->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$establecimientos_educativos_pase_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($establecimientos_educativos_pase->ExportAll && $establecimientos_educativos_pase->Export <> "") {
	$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase_list->TotalRecs;
} else {

	// Set the last record to display
	if ($establecimientos_educativos_pase_list->TotalRecs > $establecimientos_educativos_pase_list->StartRec + $establecimientos_educativos_pase_list->DisplayRecs - 1)
		$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase_list->StartRec + $establecimientos_educativos_pase_list->DisplayRecs - 1;
	else
		$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($establecimientos_educativos_pase_list->FormKeyCountName) && ($establecimientos_educativos_pase->CurrentAction == "gridadd" || $establecimientos_educativos_pase->CurrentAction == "gridedit" || $establecimientos_educativos_pase->CurrentAction == "F")) {
		$establecimientos_educativos_pase_list->KeyCount = $objForm->GetValue($establecimientos_educativos_pase_list->FormKeyCountName);
		$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase_list->StartRec + $establecimientos_educativos_pase_list->KeyCount - 1;
	}
}
$establecimientos_educativos_pase_list->RecCnt = $establecimientos_educativos_pase_list->StartRec - 1;
if ($establecimientos_educativos_pase_list->Recordset && !$establecimientos_educativos_pase_list->Recordset->EOF) {
	$establecimientos_educativos_pase_list->Recordset->MoveFirst();
	$bSelectLimit = $establecimientos_educativos_pase_list->UseSelectLimit;
	if (!$bSelectLimit && $establecimientos_educativos_pase_list->StartRec > 1)
		$establecimientos_educativos_pase_list->Recordset->Move($establecimientos_educativos_pase_list->StartRec - 1);
} elseif (!$establecimientos_educativos_pase->AllowAddDeleteRow && $establecimientos_educativos_pase_list->StopRec == 0) {
	$establecimientos_educativos_pase_list->StopRec = $establecimientos_educativos_pase->GridAddRowCount;
}

// Initialize aggregate
$establecimientos_educativos_pase->RowType = EW_ROWTYPE_AGGREGATEINIT;
$establecimientos_educativos_pase->ResetAttrs();
$establecimientos_educativos_pase_list->RenderRow();
if ($establecimientos_educativos_pase->CurrentAction == "gridadd")
	$establecimientos_educativos_pase_list->RowIndex = 0;
if ($establecimientos_educativos_pase->CurrentAction == "gridedit")
	$establecimientos_educativos_pase_list->RowIndex = 0;
while ($establecimientos_educativos_pase_list->RecCnt < $establecimientos_educativos_pase_list->StopRec) {
	$establecimientos_educativos_pase_list->RecCnt++;
	if (intval($establecimientos_educativos_pase_list->RecCnt) >= intval($establecimientos_educativos_pase_list->StartRec)) {
		$establecimientos_educativos_pase_list->RowCnt++;
		if ($establecimientos_educativos_pase->CurrentAction == "gridadd" || $establecimientos_educativos_pase->CurrentAction == "gridedit" || $establecimientos_educativos_pase->CurrentAction == "F") {
			$establecimientos_educativos_pase_list->RowIndex++;
			$objForm->Index = $establecimientos_educativos_pase_list->RowIndex;
			if ($objForm->HasValue($establecimientos_educativos_pase_list->FormActionName))
				$establecimientos_educativos_pase_list->RowAction = strval($objForm->GetValue($establecimientos_educativos_pase_list->FormActionName));
			elseif ($establecimientos_educativos_pase->CurrentAction == "gridadd")
				$establecimientos_educativos_pase_list->RowAction = "insert";
			else
				$establecimientos_educativos_pase_list->RowAction = "";
		}

		// Set up key count
		$establecimientos_educativos_pase_list->KeyCount = $establecimientos_educativos_pase_list->RowIndex;

		// Init row class and style
		$establecimientos_educativos_pase->ResetAttrs();
		$establecimientos_educativos_pase->CssClass = "";
		if ($establecimientos_educativos_pase->CurrentAction == "gridadd") {
			$establecimientos_educativos_pase_list->LoadDefaultValues(); // Load default values
		} else {
			$establecimientos_educativos_pase_list->LoadRowValues($establecimientos_educativos_pase_list->Recordset); // Load row values
		}
		$establecimientos_educativos_pase->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($establecimientos_educativos_pase->CurrentAction == "gridadd") // Grid add
			$establecimientos_educativos_pase->RowType = EW_ROWTYPE_ADD; // Render add
		if ($establecimientos_educativos_pase->CurrentAction == "gridadd" && $establecimientos_educativos_pase->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$establecimientos_educativos_pase_list->RestoreCurrentRowFormValues($establecimientos_educativos_pase_list->RowIndex); // Restore form values
		if ($establecimientos_educativos_pase->CurrentAction == "gridedit") { // Grid edit
			if ($establecimientos_educativos_pase->EventCancelled) {
				$establecimientos_educativos_pase_list->RestoreCurrentRowFormValues($establecimientos_educativos_pase_list->RowIndex); // Restore form values
			}
			if ($establecimientos_educativos_pase_list->RowAction == "insert")
				$establecimientos_educativos_pase->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$establecimientos_educativos_pase->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($establecimientos_educativos_pase->CurrentAction == "gridedit" && ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT || $establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) && $establecimientos_educativos_pase->EventCancelled) // Update failed
			$establecimientos_educativos_pase_list->RestoreCurrentRowFormValues($establecimientos_educativos_pase_list->RowIndex); // Restore form values
		if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) // Edit row
			$establecimientos_educativos_pase_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$establecimientos_educativos_pase->RowAttrs = array_merge($establecimientos_educativos_pase->RowAttrs, array('data-rowindex'=>$establecimientos_educativos_pase_list->RowCnt, 'id'=>'r' . $establecimientos_educativos_pase_list->RowCnt . '_establecimientos_educativos_pase', 'data-rowtype'=>$establecimientos_educativos_pase->RowType));

		// Render row
		$establecimientos_educativos_pase_list->RenderRow();

		// Render list options
		$establecimientos_educativos_pase_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($establecimientos_educativos_pase_list->RowAction <> "delete" && $establecimientos_educativos_pase_list->RowAction <> "insertdelete" && !($establecimientos_educativos_pase_list->RowAction == "insert" && $establecimientos_educativos_pase->CurrentAction == "F" && $establecimientos_educativos_pase_list->EmptyRow())) {
?>
	<tr<?php echo $establecimientos_educativos_pase->RowAttributes() ?>>
<?php

// Render list options (body, left)
$establecimientos_educativos_pase_list->ListOptions->Render("body", "left", $establecimientos_educativos_pase_list->RowCnt);
?>
	<?php if ($establecimientos_educativos_pase->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
		<td data-name="Cue_Establecimiento"<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cue_Establecimiento" class="form-group establecimientos_educativos_pase_Cue_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cue_Establecimiento" class="form-group establecimientos_educativos_pase_Cue_Establecimiento">
<span<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditValue ?></p></span>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->CurrentValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cue_Establecimiento" class="establecimientos_educativos_pase_Cue_Establecimiento">
<span<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $establecimientos_educativos_pase_list->PageObjName . "_row_" . $establecimientos_educativos_pase_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Establecimiento" class="form-group establecimientos_educativos_pase_Nombre_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Establecimiento" class="form-group establecimientos_educativos_pase_Nombre_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Establecimiento" class="establecimientos_educativos_pase_Nombre_Establecimiento">
<span<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Director->Visible) { // Nombre_Director ?>
		<td data-name="Nombre_Director"<?php echo $establecimientos_educativos_pase->Nombre_Director->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Director" class="form-group establecimientos_educativos_pase_Nombre_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Director->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Director" class="form-group establecimientos_educativos_pase_Nombre_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Director->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Director" class="establecimientos_educativos_pase_Nombre_Director">
<span<?php echo $establecimientos_educativos_pase->Nombre_Director->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Nombre_Director->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Cuil_Director->Visible) { // Cuil_Director ?>
		<td data-name="Cuil_Director"<?php echo $establecimientos_educativos_pase->Cuil_Director->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cuil_Director" class="form-group establecimientos_educativos_pase_Cuil_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cuil_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cuil_Director->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cuil_Director" class="form-group establecimientos_educativos_pase_Cuil_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cuil_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cuil_Director->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Cuil_Director" class="establecimientos_educativos_pase_Cuil_Director">
<span<?php echo $establecimientos_educativos_pase->Cuil_Director->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Cuil_Director->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Rte->Visible) { // Nombre_Rte ?>
		<td data-name="Nombre_Rte"<?php echo $establecimientos_educativos_pase->Nombre_Rte->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Rte" class="form-group establecimientos_educativos_pase_Nombre_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Rte" class="form-group establecimientos_educativos_pase_Nombre_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nombre_Rte" class="establecimientos_educativos_pase_Nombre_Rte">
<span<?php echo $establecimientos_educativos_pase->Nombre_Rte->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Nombre_Rte->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Contacto_Rte->Visible) { // Contacto_Rte ?>
		<td data-name="Contacto_Rte"<?php echo $establecimientos_educativos_pase->Contacto_Rte->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Rte" class="form-group establecimientos_educativos_pase_Contacto_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Rte" class="form-group establecimientos_educativos_pase_Contacto_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Rte" class="establecimientos_educativos_pase_Contacto_Rte">
<span<?php echo $establecimientos_educativos_pase->Contacto_Rte->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Contacto_Rte->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
		<td data-name="Nro_Serie_Server_Escolar"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="form-group establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="form-group establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<span<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
		<td data-name="Contacto_Establecimiento"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Establecimiento" class="form-group establecimientos_educativos_pase_Contacto_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Establecimiento" class="form-group establecimientos_educativos_pase_Contacto_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Contacto_Establecimiento" class="establecimientos_educativos_pase_Contacto_Establecimiento">
<span<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Provincia->Visible) { // Id_Provincia ?>
		<td data-name="Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Provincia" class="form-group establecimientos_educativos_pase_Id_Provincia">
<?php $establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" value="<?php echo $establecimientos_educativos_pase->Id_Provincia->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Provincia->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Provincia" class="form-group establecimientos_educativos_pase_Id_Provincia">
<?php $establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" value="<?php echo $establecimientos_educativos_pase->Id_Provincia->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Provincia" class="establecimientos_educativos_pase_Id_Provincia">
<span<?php echo $establecimientos_educativos_pase->Id_Provincia->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Departamento" class="form-group establecimientos_educativos_pase_Id_Departamento">
<?php $establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" value="<?php echo $establecimientos_educativos_pase->Id_Departamento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Departamento->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Departamento" class="form-group establecimientos_educativos_pase_Id_Departamento">
<?php $establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" value="<?php echo $establecimientos_educativos_pase->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Departamento" class="establecimientos_educativos_pase_Id_Departamento">
<span<?php echo $establecimientos_educativos_pase->Id_Departamento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Localidad->Visible) { // Id_Localidad ?>
		<td data-name="Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Localidad" class="form-group establecimientos_educativos_pase_Id_Localidad">
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" value="<?php echo $establecimientos_educativos_pase->Id_Localidad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Localidad->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Localidad" class="form-group establecimientos_educativos_pase_Id_Localidad">
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" value="<?php echo $establecimientos_educativos_pase->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Id_Localidad" class="establecimientos_educativos_pase_Id_Localidad">
<span<?php echo $establecimientos_educativos_pase->Id_Localidad->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Fecha_Actualizacion" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Fecha_Actualizacion" class="establecimientos_educativos_pase_Fecha_Actualizacion">
<span<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $establecimientos_educativos_pase->Usuario->CellAttributes() ?>>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Usuario" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Usuario" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $establecimientos_educativos_pase_list->RowCnt ?>_establecimientos_educativos_pase_Usuario" class="establecimientos_educativos_pase_Usuario">
<span<?php echo $establecimientos_educativos_pase->Usuario->ViewAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$establecimientos_educativos_pase_list->ListOptions->Render("body", "right", $establecimientos_educativos_pase_list->RowCnt);
?>
	</tr>
<?php if ($establecimientos_educativos_pase->RowType == EW_ROWTYPE_ADD || $establecimientos_educativos_pase->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
festablecimientos_educativos_paselist.UpdateOpts(<?php echo $establecimientos_educativos_pase_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($establecimientos_educativos_pase->CurrentAction <> "gridadd")
		if (!$establecimientos_educativos_pase_list->Recordset->EOF) $establecimientos_educativos_pase_list->Recordset->MoveNext();
}
?>
<?php
	if ($establecimientos_educativos_pase->CurrentAction == "gridadd" || $establecimientos_educativos_pase->CurrentAction == "gridedit") {
		$establecimientos_educativos_pase_list->RowIndex = '$rowindex$';
		$establecimientos_educativos_pase_list->LoadDefaultValues();

		// Set row properties
		$establecimientos_educativos_pase->ResetAttrs();
		$establecimientos_educativos_pase->RowAttrs = array_merge($establecimientos_educativos_pase->RowAttrs, array('data-rowindex'=>$establecimientos_educativos_pase_list->RowIndex, 'id'=>'r0_establecimientos_educativos_pase', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($establecimientos_educativos_pase->RowAttrs["class"], "ewTemplate");
		$establecimientos_educativos_pase->RowType = EW_ROWTYPE_ADD;

		// Render row
		$establecimientos_educativos_pase_list->RenderRow();

		// Render list options
		$establecimientos_educativos_pase_list->RenderListOptions();
		$establecimientos_educativos_pase_list->StartRowCnt = 0;
?>
	<tr<?php echo $establecimientos_educativos_pase->RowAttributes() ?>>
<?php

// Render list options (body, left)
$establecimientos_educativos_pase_list->ListOptions->Render("body", "left", $establecimientos_educativos_pase_list->RowIndex);
?>
	<?php if ($establecimientos_educativos_pase->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
		<td data-name="Cue_Establecimiento">
<span id="el$rowindex$_establecimientos_educativos_pase_Cue_Establecimiento" class="form-group establecimientos_educativos_pase_Cue_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cue_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento">
<span id="el$rowindex$_establecimientos_educativos_pase_Nombre_Establecimiento" class="form-group establecimientos_educativos_pase_Nombre_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Director->Visible) { // Nombre_Director ?>
		<td data-name="Nombre_Director">
<span id="el$rowindex$_establecimientos_educativos_pase_Nombre_Director" class="form-group establecimientos_educativos_pase_Nombre_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Director->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Director" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Cuil_Director->Visible) { // Cuil_Director ?>
		<td data-name="Cuil_Director">
<span id="el$rowindex$_establecimientos_educativos_pase_Cuil_Director" class="form-group establecimientos_educativos_pase_Cuil_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cuil_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cuil_Director->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Cuil_Director" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nombre_Rte->Visible) { // Nombre_Rte ?>
		<td data-name="Nombre_Rte">
<span id="el$rowindex$_establecimientos_educativos_pase_Nombre_Rte" class="form-group establecimientos_educativos_pase_Nombre_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nombre_Rte" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Contacto_Rte->Visible) { // Contacto_Rte ?>
		<td data-name="Contacto_Rte">
<span id="el$rowindex$_establecimientos_educativos_pase_Contacto_Rte" class="form-group establecimientos_educativos_pase_Contacto_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Rte" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
		<td data-name="Nro_Serie_Server_Escolar">
<span id="el$rowindex$_establecimientos_educativos_pase_Nro_Serie_Server_Escolar" class="form-group establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Nro_Serie_Server_Escolar" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
		<td data-name="Contacto_Establecimiento">
<span id="el$rowindex$_establecimientos_educativos_pase_Contacto_Establecimiento" class="form-group establecimientos_educativos_pase_Contacto_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Contacto_Establecimiento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Provincia->Visible) { // Id_Provincia ?>
		<td data-name="Id_Provincia">
<span id="el$rowindex$_establecimientos_educativos_pase_Id_Provincia" class="form-group establecimientos_educativos_pase_Id_Provincia">
<?php $establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" value="<?php echo $establecimientos_educativos_pase->Id_Provincia->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Provincia" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Provincia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento">
<span id="el$rowindex$_establecimientos_educativos_pase_Id_Departamento" class="form-group establecimientos_educativos_pase_Id_Departamento">
<?php $establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" value="<?php echo $establecimientos_educativos_pase->Id_Departamento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Departamento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Id_Localidad->Visible) { // Id_Localidad ?>
		<td data-name="Id_Localidad">
<span id="el$rowindex$_establecimientos_educativos_pase_Id_Localidad" class="form-group establecimientos_educativos_pase_Id_Localidad">
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" name="x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->SelectOptionListHtml("x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" value="<?php echo $establecimientos_educativos_pase->Id_Localidad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Id_Localidad" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Id_Localidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Fecha_Actualizacion" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($establecimientos_educativos_pase->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="establecimientos_educativos_pase" data-field="x_Usuario" name="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Usuario" id="o<?php echo $establecimientos_educativos_pase_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$establecimientos_educativos_pase_list->ListOptions->Render("body", "right", $establecimientos_educativos_pase_list->RowCnt);
?>
<script type="text/javascript">
festablecimientos_educativos_paselist.UpdateOpts(<?php echo $establecimientos_educativos_pase_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($establecimientos_educativos_pase->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $establecimientos_educativos_pase_list->FormKeyCountName ?>" id="<?php echo $establecimientos_educativos_pase_list->FormKeyCountName ?>" value="<?php echo $establecimientos_educativos_pase_list->KeyCount ?>">
<?php echo $establecimientos_educativos_pase_list->MultiSelectKey ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $establecimientos_educativos_pase_list->FormKeyCountName ?>" id="<?php echo $establecimientos_educativos_pase_list->FormKeyCountName ?>" value="<?php echo $establecimientos_educativos_pase_list->KeyCount ?>">
<?php echo $establecimientos_educativos_pase_list->MultiSelectKey ?>
<?php } ?>
<?php if ($establecimientos_educativos_pase->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($establecimientos_educativos_pase_list->Recordset)
	$establecimientos_educativos_pase_list->Recordset->Close();
?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($establecimientos_educativos_pase->CurrentAction <> "gridadd" && $establecimientos_educativos_pase->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($establecimientos_educativos_pase_list->Pager)) $establecimientos_educativos_pase_list->Pager = new cPrevNextPager($establecimientos_educativos_pase_list->StartRec, $establecimientos_educativos_pase_list->DisplayRecs, $establecimientos_educativos_pase_list->TotalRecs) ?>
<?php if ($establecimientos_educativos_pase_list->Pager->RecordCount > 0 && $establecimientos_educativos_pase_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($establecimientos_educativos_pase_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $establecimientos_educativos_pase_list->PageUrl() ?>start=<?php echo $establecimientos_educativos_pase_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($establecimientos_educativos_pase_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $establecimientos_educativos_pase_list->PageUrl() ?>start=<?php echo $establecimientos_educativos_pase_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $establecimientos_educativos_pase_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($establecimientos_educativos_pase_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $establecimientos_educativos_pase_list->PageUrl() ?>start=<?php echo $establecimientos_educativos_pase_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($establecimientos_educativos_pase_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $establecimientos_educativos_pase_list->PageUrl() ?>start=<?php echo $establecimientos_educativos_pase_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $establecimientos_educativos_pase_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $establecimientos_educativos_pase_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $establecimientos_educativos_pase_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $establecimientos_educativos_pase_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($establecimientos_educativos_pase_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase_list->TotalRecs == 0 && $establecimientos_educativos_pase->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($establecimientos_educativos_pase_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<script type="text/javascript">
festablecimientos_educativos_paselistsrch.FilterList = <?php echo $establecimientos_educativos_pase_list->GetFilterList() ?>;
festablecimientos_educativos_paselistsrch.Init();
festablecimientos_educativos_paselist.Init();
</script>
<?php } ?>
<?php
$establecimientos_educativos_pase_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($establecimientos_educativos_pase->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$establecimientos_educativos_pase_list->Page_Terminate();
?>
