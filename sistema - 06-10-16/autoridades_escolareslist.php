<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "autoridades_escolaresinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$autoridades_escolares_list = NULL; // Initialize page object first

class cautoridades_escolares_list extends cautoridades_escolares {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'autoridades_escolares';

	// Page object name
	var $PageObjName = 'autoridades_escolares_list';

	// Grid form hidden field names
	var $FormName = 'fautoridades_escolareslist';
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

		// Table object (autoridades_escolares)
		if (!isset($GLOBALS["autoridades_escolares"]) || get_class($GLOBALS["autoridades_escolares"]) == "cautoridades_escolares") {
			$GLOBALS["autoridades_escolares"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["autoridades_escolares"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "autoridades_escolaresadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "autoridades_escolaresdelete.php";
		$this->MultiUpdateUrl = "autoridades_escolaresupdate.php";

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'autoridades_escolares', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fautoridades_escolareslistsrch";

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
		$this->Apellido_Nombre->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Id_Cargo->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Maill->SetVisibility();
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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		global $EW_EXPORT, $autoridades_escolares;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($autoridades_escolares);
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "dato_establecimiento") {
			global $dato_establecimiento;
			$rsmaster = $dato_establecimiento->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("dato_establecimientolist.php"); // Return to master page
			} else {
				$dato_establecimiento->LoadListRowValues($rsmaster);
				$dato_establecimiento->RowType = EW_ROWTYPE_MASTER; // Master row
				$dato_establecimiento->RenderListRow();
				$rsmaster->Close();
			}
		}

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
			$this->Id_Autoridad->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Autoridad->FormValue))
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
					$sKey .= $this->Id_Autoridad->CurrentValue;

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
		if ($objForm->HasValue("x_Apellido_Nombre") && $objForm->HasValue("o_Apellido_Nombre") && $this->Apellido_Nombre->CurrentValue <> $this->Apellido_Nombre->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cuil") && $objForm->HasValue("o_Cuil") && $this->Cuil->CurrentValue <> $this->Cuil->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Cargo") && $objForm->HasValue("o_Id_Cargo") && $this->Id_Cargo->CurrentValue <> $this->Id_Cargo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Turno") && $objForm->HasValue("o_Id_Turno") && $this->Id_Turno->CurrentValue <> $this->Id_Turno->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Telefono") && $objForm->HasValue("o_Telefono") && $this->Telefono->CurrentValue <> $this->Telefono->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Celular") && $objForm->HasValue("o_Celular") && $this->Celular->CurrentValue <> $this->Celular->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Maill") && $objForm->HasValue("o_Maill") && $this->Maill->CurrentValue <> $this->Maill->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fautoridades_escolareslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Apellido_Nombre->AdvancedSearch->ToJSON(), ","); // Field Apellido_Nombre
		$sFilterList = ew_Concat($sFilterList, $this->Cuil->AdvancedSearch->ToJSON(), ","); // Field Cuil
		$sFilterList = ew_Concat($sFilterList, $this->Id_Cargo->AdvancedSearch->ToJSON(), ","); // Field Id_Cargo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Turno->AdvancedSearch->ToJSON(), ","); // Field Id_Turno
		$sFilterList = ew_Concat($sFilterList, $this->Telefono->AdvancedSearch->ToJSON(), ","); // Field Telefono
		$sFilterList = ew_Concat($sFilterList, $this->Celular->AdvancedSearch->ToJSON(), ","); // Field Celular
		$sFilterList = ew_Concat($sFilterList, $this->Maill->AdvancedSearch->ToJSON(), ","); // Field Maill
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fautoridades_escolareslistsrch", $filters);
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

		// Field Apellido_Nombre
		$this->Apellido_Nombre->AdvancedSearch->SearchValue = @$filter["x_Apellido_Nombre"];
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator = @$filter["z_Apellido_Nombre"];
		$this->Apellido_Nombre->AdvancedSearch->SearchCondition = @$filter["v_Apellido_Nombre"];
		$this->Apellido_Nombre->AdvancedSearch->SearchValue2 = @$filter["y_Apellido_Nombre"];
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator2 = @$filter["w_Apellido_Nombre"];
		$this->Apellido_Nombre->AdvancedSearch->Save();

		// Field Cuil
		$this->Cuil->AdvancedSearch->SearchValue = @$filter["x_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator = @$filter["z_Cuil"];
		$this->Cuil->AdvancedSearch->SearchCondition = @$filter["v_Cuil"];
		$this->Cuil->AdvancedSearch->SearchValue2 = @$filter["y_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil"];
		$this->Cuil->AdvancedSearch->Save();

		// Field Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = @$filter["x_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$filter["z_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchCondition = @$filter["v_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->Save();

		// Field Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = @$filter["x_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$filter["z_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchCondition = @$filter["v_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchValue2 = @$filter["y_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->Save();

		// Field Telefono
		$this->Telefono->AdvancedSearch->SearchValue = @$filter["x_Telefono"];
		$this->Telefono->AdvancedSearch->SearchOperator = @$filter["z_Telefono"];
		$this->Telefono->AdvancedSearch->SearchCondition = @$filter["v_Telefono"];
		$this->Telefono->AdvancedSearch->SearchValue2 = @$filter["y_Telefono"];
		$this->Telefono->AdvancedSearch->SearchOperator2 = @$filter["w_Telefono"];
		$this->Telefono->AdvancedSearch->Save();

		// Field Celular
		$this->Celular->AdvancedSearch->SearchValue = @$filter["x_Celular"];
		$this->Celular->AdvancedSearch->SearchOperator = @$filter["z_Celular"];
		$this->Celular->AdvancedSearch->SearchCondition = @$filter["v_Celular"];
		$this->Celular->AdvancedSearch->SearchValue2 = @$filter["y_Celular"];
		$this->Celular->AdvancedSearch->SearchOperator2 = @$filter["w_Celular"];
		$this->Celular->AdvancedSearch->Save();

		// Field Maill
		$this->Maill->AdvancedSearch->SearchValue = @$filter["x_Maill"];
		$this->Maill->AdvancedSearch->SearchOperator = @$filter["z_Maill"];
		$this->Maill->AdvancedSearch->SearchCondition = @$filter["v_Maill"];
		$this->Maill->AdvancedSearch->SearchValue2 = @$filter["y_Maill"];
		$this->Maill->AdvancedSearch->SearchOperator2 = @$filter["w_Maill"];
		$this->Maill->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Apellido_Nombre, $Default, FALSE); // Apellido_Nombre
		$this->BuildSearchSql($sWhere, $this->Cuil, $Default, FALSE); // Cuil
		$this->BuildSearchSql($sWhere, $this->Id_Cargo, $Default, FALSE); // Id_Cargo
		$this->BuildSearchSql($sWhere, $this->Id_Turno, $Default, FALSE); // Id_Turno
		$this->BuildSearchSql($sWhere, $this->Telefono, $Default, FALSE); // Telefono
		$this->BuildSearchSql($sWhere, $this->Celular, $Default, FALSE); // Celular
		$this->BuildSearchSql($sWhere, $this->Maill, $Default, FALSE); // Maill
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Apellido_Nombre->AdvancedSearch->Save(); // Apellido_Nombre
			$this->Cuil->AdvancedSearch->Save(); // Cuil
			$this->Id_Cargo->AdvancedSearch->Save(); // Id_Cargo
			$this->Id_Turno->AdvancedSearch->Save(); // Id_Turno
			$this->Telefono->AdvancedSearch->Save(); // Telefono
			$this->Celular->AdvancedSearch->Save(); // Celular
			$this->Maill->AdvancedSearch->Save(); // Maill
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
		$this->BuildBasicSearchSQL($sWhere, $this->Apellido_Nombre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Cargo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Turno, $arKeywords, $type);
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
		if ($this->Apellido_Nombre->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Cargo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Turno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Telefono->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Celular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Maill->AdvancedSearch->IssetSession())
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
		$this->Apellido_Nombre->AdvancedSearch->UnsetSession();
		$this->Cuil->AdvancedSearch->UnsetSession();
		$this->Id_Cargo->AdvancedSearch->UnsetSession();
		$this->Id_Turno->AdvancedSearch->UnsetSession();
		$this->Telefono->AdvancedSearch->UnsetSession();
		$this->Celular->AdvancedSearch->UnsetSession();
		$this->Maill->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Apellido_Nombre->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Maill->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Apellido_Nombre); // Apellido_Nombre
			$this->UpdateSort($this->Cuil); // Cuil
			$this->UpdateSort($this->Id_Cargo); // Id_Cargo
			$this->UpdateSort($this->Id_Turno); // Id_Turno
			$this->UpdateSort($this->Telefono); // Telefono
			$this->UpdateSort($this->Celular); // Celular
			$this->UpdateSort($this->Maill); // Maill
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Cue->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Apellido_Nombre->setSort("");
				$this->Cuil->setSort("");
				$this->Id_Cargo->setSort("");
				$this->Id_Turno->setSort("");
				$this->Telefono->setSort("");
				$this->Celular->setSort("");
				$this->Maill->setSort("");
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
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"autoridades_escolares\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"autoridades_escolares\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-table=\"autoridades_escolares\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Autoridad->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Id_Autoridad->CurrentValue . "\">";
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
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-table=\"autoridades_escolares\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("AddLink") . "</a>";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fautoridades_escolareslist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fautoridades_escolareslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fautoridades_escolareslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fautoridades_escolareslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fautoridades_escolareslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"autoridades_escolaressrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Apellido_Nombre->CurrentValue = NULL;
		$this->Apellido_Nombre->OldValue = $this->Apellido_Nombre->CurrentValue;
		$this->Cuil->CurrentValue = NULL;
		$this->Cuil->OldValue = $this->Cuil->CurrentValue;
		$this->Id_Cargo->CurrentValue = NULL;
		$this->Id_Cargo->OldValue = $this->Id_Cargo->CurrentValue;
		$this->Id_Turno->CurrentValue = NULL;
		$this->Id_Turno->OldValue = $this->Id_Turno->CurrentValue;
		$this->Telefono->CurrentValue = NULL;
		$this->Telefono->OldValue = $this->Telefono->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Maill->CurrentValue = NULL;
		$this->Maill->OldValue = $this->Maill->CurrentValue;
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
		// Apellido_Nombre

		$this->Apellido_Nombre->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellido_Nombre"]);
		if ($this->Apellido_Nombre->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator = @$_GET["z_Apellido_Nombre"];

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil"]);
		if ($this->Cuil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil->AdvancedSearch->SearchOperator = @$_GET["z_Cuil"];

		// Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cargo"]);
		if ($this->Id_Cargo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cargo"];

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Turno"]);
		if ($this->Id_Turno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$_GET["z_Id_Turno"];

		// Telefono
		$this->Telefono->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Telefono"]);
		if ($this->Telefono->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Telefono->AdvancedSearch->SearchOperator = @$_GET["z_Telefono"];

		// Celular
		$this->Celular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Celular"]);
		if ($this->Celular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Celular->AdvancedSearch->SearchOperator = @$_GET["z_Celular"];

		// Maill
		$this->Maill->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Maill"]);
		if ($this->Maill->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Maill->AdvancedSearch->SearchOperator = @$_GET["z_Maill"];

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
		if (!$this->Apellido_Nombre->FldIsDetailKey) {
			$this->Apellido_Nombre->setFormValue($objForm->GetValue("x_Apellido_Nombre"));
		}
		$this->Apellido_Nombre->setOldValue($objForm->GetValue("o_Apellido_Nombre"));
		if (!$this->Cuil->FldIsDetailKey) {
			$this->Cuil->setFormValue($objForm->GetValue("x_Cuil"));
		}
		$this->Cuil->setOldValue($objForm->GetValue("o_Cuil"));
		if (!$this->Id_Cargo->FldIsDetailKey) {
			$this->Id_Cargo->setFormValue($objForm->GetValue("x_Id_Cargo"));
		}
		$this->Id_Cargo->setOldValue($objForm->GetValue("o_Id_Cargo"));
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
		}
		$this->Id_Turno->setOldValue($objForm->GetValue("o_Id_Turno"));
		if (!$this->Telefono->FldIsDetailKey) {
			$this->Telefono->setFormValue($objForm->GetValue("x_Telefono"));
		}
		$this->Telefono->setOldValue($objForm->GetValue("o_Telefono"));
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		$this->Celular->setOldValue($objForm->GetValue("o_Celular"));
		if (!$this->Maill->FldIsDetailKey) {
			$this->Maill->setFormValue($objForm->GetValue("x_Maill"));
		}
		$this->Maill->setOldValue($objForm->GetValue("o_Maill"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->setOldValue($objForm->GetValue("o_Fecha_Actualizacion"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
		if (!$this->Id_Autoridad->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Autoridad->setFormValue($objForm->GetValue("x_Id_Autoridad"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Id_Autoridad->CurrentValue = $this->Id_Autoridad->FormValue;
		$this->Apellido_Nombre->CurrentValue = $this->Apellido_Nombre->FormValue;
		$this->Cuil->CurrentValue = $this->Cuil->FormValue;
		$this->Id_Cargo->CurrentValue = $this->Id_Cargo->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Telefono->CurrentValue = $this->Telefono->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Maill->CurrentValue = $this->Maill->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Id_Autoridad->setDbValue($rs->fields('Id_Autoridad'));
		$this->Apellido_Nombre->setDbValue($rs->fields('Apellido_Nombre'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Id_Cargo->setDbValue($rs->fields('Id_Cargo'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Maill->setDbValue($rs->fields('Maill'));
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Autoridad->DbValue = $row['Id_Autoridad'];
		$this->Apellido_Nombre->DbValue = $row['Apellido_Nombre'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->Id_Cargo->DbValue = $row['Id_Cargo'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Celular->DbValue = $row['Celular'];
		$this->Maill->DbValue = $row['Maill'];
		$this->Cue->DbValue = $row['Cue'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Autoridad")) <> "")
			$this->Id_Autoridad->CurrentValue = $this->getKey("Id_Autoridad"); // Id_Autoridad
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
		// Id_Autoridad
		// Apellido_Nombre
		// Cuil
		// Id_Cargo
		// Id_Turno
		// Telefono
		// Celular
		// Maill
		// Cue
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Autoridad
		$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_autoridad`";
		$sWhereWrk = "";
		$this->Id_Cargo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->CurrentValue;
			}
		} else {
			$this->Id_Cargo->ViewValue = NULL;
		}
		$this->Id_Cargo->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Maill
		$this->Maill->ViewValue = $this->Maill->CurrentValue;
		$this->Maill->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";
			$this->Id_Cargo->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Maill
			$this->Maill->LinkCustomAttributes = "";
			$this->Maill->HrefValue = "";
			$this->Maill->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_autoridad`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Telefono
			$this->Telefono->EditAttrs["class"] = "form-control";
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->CurrentValue);
			$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

			// Celular
			$this->Celular->EditAttrs["class"] = "form-control";
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);
			$this->Celular->PlaceHolder = ew_RemoveHtml($this->Celular->FldCaption());

			// Maill
			$this->Maill->EditAttrs["class"] = "form-control";
			$this->Maill->EditCustomAttributes = "";
			$this->Maill->EditValue = ew_HtmlEncode($this->Maill->CurrentValue);
			$this->Maill->PlaceHolder = ew_RemoveHtml($this->Maill->FldCaption());

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Maill
			$this->Maill->LinkCustomAttributes = "";
			$this->Maill->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_autoridad`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Telefono
			$this->Telefono->EditAttrs["class"] = "form-control";
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->CurrentValue);
			$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

			// Celular
			$this->Celular->EditAttrs["class"] = "form-control";
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);
			$this->Celular->PlaceHolder = ew_RemoveHtml($this->Celular->FldCaption());

			// Maill
			$this->Maill->EditAttrs["class"] = "form-control";
			$this->Maill->EditCustomAttributes = "";
			$this->Maill->EditValue = ew_HtmlEncode($this->Maill->CurrentValue);
			$this->Maill->PlaceHolder = ew_RemoveHtml($this->Maill->FldCaption());

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Maill
			$this->Maill->LinkCustomAttributes = "";
			$this->Maill->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
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
		if (!$this->Id_Cargo->FldIsDetailKey && !is_null($this->Id_Cargo->FormValue) && $this->Id_Cargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Cargo->FldCaption(), $this->Id_Cargo->ReqErrMsg));
		}
		if (!$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Telefono->FormValue)) {
			ew_AddMessage($gsFormError, $this->Telefono->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Celular->FormValue)) {
			ew_AddMessage($gsFormError, $this->Celular->FldErrMsg());
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
				$sThisKey .= $row['Id_Autoridad'];
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

			// Apellido_Nombre
			$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, $this->Apellido_Nombre->ReadOnly);

			// Cuil
			$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, $this->Cuil->ReadOnly);

			// Id_Cargo
			$this->Id_Cargo->SetDbValueDef($rsnew, $this->Id_Cargo->CurrentValue, 0, $this->Id_Cargo->ReadOnly);

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly);

			// Telefono
			$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, $this->Telefono->ReadOnly);

			// Celular
			$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, $this->Celular->ReadOnly);

			// Maill
			$this->Maill->SetDbValueDef($rsnew, $this->Maill->CurrentValue, NULL, $this->Maill->ReadOnly);

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Check referential integrity for master table 'dato_establecimiento'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_dato_establecimiento();
			$KeyValue = isset($rsnew['Cue']) ? $rsnew['Cue'] : $rsold['Cue'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@Cue@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["dato_establecimiento"])) $GLOBALS["dato_establecimiento"] = new cdato_establecimiento();
				$rsmaster = $GLOBALS["dato_establecimiento"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "dato_establecimiento", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

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

		// Check referential integrity for master table 'dato_establecimiento'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_dato_establecimiento();
		if ($this->Cue->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["dato_establecimiento"])) $GLOBALS["dato_establecimiento"] = new cdato_establecimiento();
			$rsmaster = $GLOBALS["dato_establecimiento"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "dato_establecimiento", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Apellido_Nombre
		$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, FALSE);

		// Cuil
		$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, FALSE);

		// Id_Cargo
		$this->Id_Cargo->SetDbValueDef($rsnew, $this->Id_Cargo->CurrentValue, 0, FALSE);

		// Id_Turno
		$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, FALSE);

		// Telefono
		$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Maill
		$this->Maill->SetDbValueDef($rsnew, $this->Maill->CurrentValue, NULL, FALSE);

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Cue
		if ($this->Cue->getSessionValue() <> "") {
			$rsnew['Cue'] = $this->Cue->getSessionValue();
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
				$this->Id_Autoridad->setDbValue($conn->Insert_ID());
				$rsnew['Id_Autoridad'] = $this->Id_Autoridad->DbValue;
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
		$this->Apellido_Nombre->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Maill->AdvancedSearch->Load();
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fautoridades_escolareslist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_autoridades_escolares\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_autoridades_escolares',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fautoridades_escolareslist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "dato_establecimiento") {
			global $dato_establecimiento;
			if (!isset($dato_establecimiento)) $dato_establecimiento = new cdato_establecimiento;
			$rsmaster = $dato_establecimiento->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$dato_establecimiento;
					$dato_establecimiento->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Cargo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Cargo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_autoridad`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Cargo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
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
if (!isset($autoridades_escolares_list)) $autoridades_escolares_list = new cautoridades_escolares_list();

// Page init
$autoridades_escolares_list->Page_Init();

// Page main
$autoridades_escolares_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$autoridades_escolares_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($autoridades_escolares->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fautoridades_escolareslist = new ew_Form("fautoridades_escolareslist", "list");
fautoridades_escolareslist.FormKeyCountName = '<?php echo $autoridades_escolares_list->FormKeyCountName ?>';

// Validate form
fautoridades_escolareslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $autoridades_escolares->Id_Cargo->FldCaption(), $autoridades_escolares->Id_Cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $autoridades_escolares->Id_Turno->FldCaption(), $autoridades_escolares->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($autoridades_escolares->Telefono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Celular");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($autoridades_escolares->Celular->FldErrMsg()) ?>");

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
fautoridades_escolareslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Apellido_Nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Cargo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Telefono", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Celular", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Maill", false)) return false;
	return true;
}

// Form_CustomValidate event
fautoridades_escolareslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fautoridades_escolareslist.ValidateRequired = true;
<?php } else { ?>
fautoridades_escolareslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fautoridades_escolareslist.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_autoridad"};
fautoridades_escolareslist.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};

// Form object for search
var CurrentSearchForm = fautoridades_escolareslistsrch = new ew_Form("fautoridades_escolareslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($autoridades_escolares->Export == "") { ?>
<div class="ewToolbar">
<?php if ($autoridades_escolares->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($autoridades_escolares_list->TotalRecs > 0 && $autoridades_escolares_list->ExportOptions->Visible()) { ?>
<?php $autoridades_escolares_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($autoridades_escolares_list->SearchOptions->Visible()) { ?>
<?php $autoridades_escolares_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($autoridades_escolares_list->FilterOptions->Visible()) { ?>
<?php $autoridades_escolares_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($autoridades_escolares->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($autoridades_escolares->Export == "") || (EW_EXPORT_MASTER_RECORD && $autoridades_escolares->Export == "print")) { ?>
<?php
if ($autoridades_escolares_list->DbMasterFilter <> "" && $autoridades_escolares->getCurrentMasterTable() == "dato_establecimiento") {
	if ($autoridades_escolares_list->MasterRecordExists) {
?>
<?php include_once "dato_establecimientomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($autoridades_escolares->CurrentAction == "gridadd") {
	$autoridades_escolares->CurrentFilter = "0=1";
	$autoridades_escolares_list->StartRec = 1;
	$autoridades_escolares_list->DisplayRecs = $autoridades_escolares->GridAddRowCount;
	$autoridades_escolares_list->TotalRecs = $autoridades_escolares_list->DisplayRecs;
	$autoridades_escolares_list->StopRec = $autoridades_escolares_list->DisplayRecs;
} else {
	$bSelectLimit = $autoridades_escolares_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($autoridades_escolares_list->TotalRecs <= 0)
			$autoridades_escolares_list->TotalRecs = $autoridades_escolares->SelectRecordCount();
	} else {
		if (!$autoridades_escolares_list->Recordset && ($autoridades_escolares_list->Recordset = $autoridades_escolares_list->LoadRecordset()))
			$autoridades_escolares_list->TotalRecs = $autoridades_escolares_list->Recordset->RecordCount();
	}
	$autoridades_escolares_list->StartRec = 1;
	if ($autoridades_escolares_list->DisplayRecs <= 0 || ($autoridades_escolares->Export <> "" && $autoridades_escolares->ExportAll)) // Display all records
		$autoridades_escolares_list->DisplayRecs = $autoridades_escolares_list->TotalRecs;
	if (!($autoridades_escolares->Export <> "" && $autoridades_escolares->ExportAll))
		$autoridades_escolares_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$autoridades_escolares_list->Recordset = $autoridades_escolares_list->LoadRecordset($autoridades_escolares_list->StartRec-1, $autoridades_escolares_list->DisplayRecs);

	// Set no record found message
	if ($autoridades_escolares->CurrentAction == "" && $autoridades_escolares_list->TotalRecs == 0) {
		if ($autoridades_escolares_list->SearchWhere == "0=101")
			$autoridades_escolares_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$autoridades_escolares_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$autoridades_escolares_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($autoridades_escolares->Export == "" && $autoridades_escolares->CurrentAction == "") { ?>
<form name="fautoridades_escolareslistsrch" id="fautoridades_escolareslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($autoridades_escolares_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fautoridades_escolareslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="autoridades_escolares">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($autoridades_escolares_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($autoridades_escolares_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $autoridades_escolares_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($autoridades_escolares_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($autoridades_escolares_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($autoridades_escolares_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($autoridades_escolares_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $autoridades_escolares_list->ShowPageHeader(); ?>
<?php
$autoridades_escolares_list->ShowMessage();
?>
<?php if ($autoridades_escolares_list->TotalRecs > 0 || $autoridades_escolares->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid autoridades_escolares">
<form name="fautoridades_escolareslist" id="fautoridades_escolareslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($autoridades_escolares_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $autoridades_escolares_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="autoridades_escolares">
<input type="hidden" name="exporttype" id="exporttype" value="">
<?php if ($autoridades_escolares->getCurrentMasterTable() == "dato_establecimiento" && $autoridades_escolares->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $autoridades_escolares->Cue->getSessionValue() ?>">
<?php } ?>
<div id="gmp_autoridades_escolares" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($autoridades_escolares_list->TotalRecs > 0) { ?>
<table id="tbl_autoridades_escolareslist" class="table ewTable">
<?php echo $autoridades_escolares->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$autoridades_escolares_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$autoridades_escolares_list->RenderListOptions();

// Render list options (header, left)
$autoridades_escolares_list->ListOptions->Render("header", "left");
?>
<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Apellido_Nombre) == "") { ?>
		<th data-name="Apellido_Nombre"><div id="elh_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Apellido_Nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_Nombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Apellido_Nombre) ?>',1);"><div id="elh_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Apellido_Nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Apellido_Nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Apellido_Nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Cuil) ?>',1);"><div id="elh_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Cuil->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Id_Cargo) == "") { ?>
		<th data-name="Id_Cargo"><div id="elh_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Cargo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Cargo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Id_Cargo) ?>',1);"><div id="elh_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Cargo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Id_Cargo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Id_Cargo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Id_Turno) ?>',1);"><div id="elh_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Telefono) ?>',1);"><div id="elh_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Telefono->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Celular->Visible) { // Celular ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Celular) == "") { ?>
		<th data-name="Celular"><div id="elh_autoridades_escolares_Celular" class="autoridades_escolares_Celular"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Celular->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Celular"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Celular) ?>',1);"><div id="elh_autoridades_escolares_Celular" class="autoridades_escolares_Celular">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Celular->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Celular->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Celular->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Maill->Visible) { // Maill ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Maill) == "") { ?>
		<th data-name="Maill"><div id="elh_autoridades_escolares_Maill" class="autoridades_escolares_Maill"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Maill->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Maill"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Maill) ?>',1);"><div id="elh_autoridades_escolares_Maill" class="autoridades_escolares_Maill">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Maill->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Maill->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Maill->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Fecha_Actualizacion) ?>',1);"><div id="elh_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $autoridades_escolares->SortUrl($autoridades_escolares->Usuario) ?>',1);"><div id="elh_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$autoridades_escolares_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($autoridades_escolares->ExportAll && $autoridades_escolares->Export <> "") {
	$autoridades_escolares_list->StopRec = $autoridades_escolares_list->TotalRecs;
} else {

	// Set the last record to display
	if ($autoridades_escolares_list->TotalRecs > $autoridades_escolares_list->StartRec + $autoridades_escolares_list->DisplayRecs - 1)
		$autoridades_escolares_list->StopRec = $autoridades_escolares_list->StartRec + $autoridades_escolares_list->DisplayRecs - 1;
	else
		$autoridades_escolares_list->StopRec = $autoridades_escolares_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($autoridades_escolares_list->FormKeyCountName) && ($autoridades_escolares->CurrentAction == "gridadd" || $autoridades_escolares->CurrentAction == "gridedit" || $autoridades_escolares->CurrentAction == "F")) {
		$autoridades_escolares_list->KeyCount = $objForm->GetValue($autoridades_escolares_list->FormKeyCountName);
		$autoridades_escolares_list->StopRec = $autoridades_escolares_list->StartRec + $autoridades_escolares_list->KeyCount - 1;
	}
}
$autoridades_escolares_list->RecCnt = $autoridades_escolares_list->StartRec - 1;
if ($autoridades_escolares_list->Recordset && !$autoridades_escolares_list->Recordset->EOF) {
	$autoridades_escolares_list->Recordset->MoveFirst();
	$bSelectLimit = $autoridades_escolares_list->UseSelectLimit;
	if (!$bSelectLimit && $autoridades_escolares_list->StartRec > 1)
		$autoridades_escolares_list->Recordset->Move($autoridades_escolares_list->StartRec - 1);
} elseif (!$autoridades_escolares->AllowAddDeleteRow && $autoridades_escolares_list->StopRec == 0) {
	$autoridades_escolares_list->StopRec = $autoridades_escolares->GridAddRowCount;
}

// Initialize aggregate
$autoridades_escolares->RowType = EW_ROWTYPE_AGGREGATEINIT;
$autoridades_escolares->ResetAttrs();
$autoridades_escolares_list->RenderRow();
if ($autoridades_escolares->CurrentAction == "gridadd")
	$autoridades_escolares_list->RowIndex = 0;
if ($autoridades_escolares->CurrentAction == "gridedit")
	$autoridades_escolares_list->RowIndex = 0;
while ($autoridades_escolares_list->RecCnt < $autoridades_escolares_list->StopRec) {
	$autoridades_escolares_list->RecCnt++;
	if (intval($autoridades_escolares_list->RecCnt) >= intval($autoridades_escolares_list->StartRec)) {
		$autoridades_escolares_list->RowCnt++;
		if ($autoridades_escolares->CurrentAction == "gridadd" || $autoridades_escolares->CurrentAction == "gridedit" || $autoridades_escolares->CurrentAction == "F") {
			$autoridades_escolares_list->RowIndex++;
			$objForm->Index = $autoridades_escolares_list->RowIndex;
			if ($objForm->HasValue($autoridades_escolares_list->FormActionName))
				$autoridades_escolares_list->RowAction = strval($objForm->GetValue($autoridades_escolares_list->FormActionName));
			elseif ($autoridades_escolares->CurrentAction == "gridadd")
				$autoridades_escolares_list->RowAction = "insert";
			else
				$autoridades_escolares_list->RowAction = "";
		}

		// Set up key count
		$autoridades_escolares_list->KeyCount = $autoridades_escolares_list->RowIndex;

		// Init row class and style
		$autoridades_escolares->ResetAttrs();
		$autoridades_escolares->CssClass = "";
		if ($autoridades_escolares->CurrentAction == "gridadd") {
			$autoridades_escolares_list->LoadDefaultValues(); // Load default values
		} else {
			$autoridades_escolares_list->LoadRowValues($autoridades_escolares_list->Recordset); // Load row values
		}
		$autoridades_escolares->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($autoridades_escolares->CurrentAction == "gridadd") // Grid add
			$autoridades_escolares->RowType = EW_ROWTYPE_ADD; // Render add
		if ($autoridades_escolares->CurrentAction == "gridadd" && $autoridades_escolares->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$autoridades_escolares_list->RestoreCurrentRowFormValues($autoridades_escolares_list->RowIndex); // Restore form values
		if ($autoridades_escolares->CurrentAction == "gridedit") { // Grid edit
			if ($autoridades_escolares->EventCancelled) {
				$autoridades_escolares_list->RestoreCurrentRowFormValues($autoridades_escolares_list->RowIndex); // Restore form values
			}
			if ($autoridades_escolares_list->RowAction == "insert")
				$autoridades_escolares->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$autoridades_escolares->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($autoridades_escolares->CurrentAction == "gridedit" && ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT || $autoridades_escolares->RowType == EW_ROWTYPE_ADD) && $autoridades_escolares->EventCancelled) // Update failed
			$autoridades_escolares_list->RestoreCurrentRowFormValues($autoridades_escolares_list->RowIndex); // Restore form values
		if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) // Edit row
			$autoridades_escolares_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$autoridades_escolares->RowAttrs = array_merge($autoridades_escolares->RowAttrs, array('data-rowindex'=>$autoridades_escolares_list->RowCnt, 'id'=>'r' . $autoridades_escolares_list->RowCnt . '_autoridades_escolares', 'data-rowtype'=>$autoridades_escolares->RowType));

		// Render row
		$autoridades_escolares_list->RenderRow();

		// Render list options
		$autoridades_escolares_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($autoridades_escolares_list->RowAction <> "delete" && $autoridades_escolares_list->RowAction <> "insertdelete" && !($autoridades_escolares_list->RowAction == "insert" && $autoridades_escolares->CurrentAction == "F" && $autoridades_escolares_list->EmptyRow())) {
?>
	<tr<?php echo $autoridades_escolares->RowAttributes() ?>>
<?php

// Render list options (body, left)
$autoridades_escolares_list->ListOptions->Render("body", "left", $autoridades_escolares_list->RowCnt);
?>
	<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre"<?php echo $autoridades_escolares->Apellido_Nombre->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre">
<span<?php echo $autoridades_escolares->Apellido_Nombre->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Apellido_Nombre->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $autoridades_escolares_list->PageObjName . "_row_" . $autoridades_escolares_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->CurrentValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT || $autoridades_escolares->CurrentMode == "edit") { ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->CurrentValue) ?>">
<?php } ?>
	<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $autoridades_escolares->Cuil->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil">
<span<?php echo $autoridades_escolares->Cuil->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Cuil->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo">
<span<?php echo $autoridades_escolares->Id_Cargo->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $autoridades_escolares->Id_Turno->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno">
<span<?php echo $autoridades_escolares->Id_Turno->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $autoridades_escolares->Telefono->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono">
<span<?php echo $autoridades_escolares->Telefono->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Telefono->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Celular->Visible) { // Celular ?>
		<td data-name="Celular"<?php echo $autoridades_escolares->Celular->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Celular" class="form-group autoridades_escolares_Celular">
<input type="text" data-table="autoridades_escolares" data-field="x_Celular" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Celular->EditValue ?>"<?php echo $autoridades_escolares->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Celular" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Celular" class="form-group autoridades_escolares_Celular">
<input type="text" data-table="autoridades_escolares" data-field="x_Celular" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Celular->EditValue ?>"<?php echo $autoridades_escolares->Celular->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Celular" class="autoridades_escolares_Celular">
<span<?php echo $autoridades_escolares->Celular->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Celular->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Maill->Visible) { // Maill ?>
		<td data-name="Maill"<?php echo $autoridades_escolares->Maill->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Maill" class="form-group autoridades_escolares_Maill">
<input type="text" data-table="autoridades_escolares" data-field="x_Maill" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Maill->EditValue ?>"<?php echo $autoridades_escolares->Maill->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Maill" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" value="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Maill" class="form-group autoridades_escolares_Maill">
<input type="text" data-table="autoridades_escolares" data-field="x_Maill" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Maill->EditValue ?>"<?php echo $autoridades_escolares->Maill->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Maill" class="autoridades_escolares_Maill">
<span<?php echo $autoridades_escolares->Maill->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Maill->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $autoridades_escolares->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion">
<span<?php echo $autoridades_escolares->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $autoridades_escolares->Usuario->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Usuario" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_list->RowCnt ?>_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario">
<span<?php echo $autoridades_escolares->Usuario->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$autoridades_escolares_list->ListOptions->Render("body", "right", $autoridades_escolares_list->RowCnt);
?>
	</tr>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD || $autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fautoridades_escolareslist.UpdateOpts(<?php echo $autoridades_escolares_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($autoridades_escolares->CurrentAction <> "gridadd")
		if (!$autoridades_escolares_list->Recordset->EOF) $autoridades_escolares_list->Recordset->MoveNext();
}
?>
<?php
	if ($autoridades_escolares->CurrentAction == "gridadd" || $autoridades_escolares->CurrentAction == "gridedit") {
		$autoridades_escolares_list->RowIndex = '$rowindex$';
		$autoridades_escolares_list->LoadDefaultValues();

		// Set row properties
		$autoridades_escolares->ResetAttrs();
		$autoridades_escolares->RowAttrs = array_merge($autoridades_escolares->RowAttrs, array('data-rowindex'=>$autoridades_escolares_list->RowIndex, 'id'=>'r0_autoridades_escolares', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($autoridades_escolares->RowAttrs["class"], "ewTemplate");
		$autoridades_escolares->RowType = EW_ROWTYPE_ADD;

		// Render row
		$autoridades_escolares_list->RenderRow();

		// Render list options
		$autoridades_escolares_list->RenderListOptions();
		$autoridades_escolares_list->StartRowCnt = 0;
?>
	<tr<?php echo $autoridades_escolares->RowAttributes() ?>>
<?php

// Render list options (body, left)
$autoridades_escolares_list->ListOptions->Render("body", "left", $autoridades_escolares_list->RowIndex);
?>
	<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre">
<span id="el$rowindex$_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<span id="el$rowindex$_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo">
<span id="el$rowindex$_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<span id="el$rowindex$_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono">
<span id="el$rowindex$_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Celular->Visible) { // Celular ?>
		<td data-name="Celular">
<span id="el$rowindex$_autoridades_escolares_Celular" class="form-group autoridades_escolares_Celular">
<input type="text" data-table="autoridades_escolares" data-field="x_Celular" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Celular->EditValue ?>"<?php echo $autoridades_escolares->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Celular" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Maill->Visible) { // Maill ?>
		<td data-name="Maill">
<span id="el$rowindex$_autoridades_escolares_Maill" class="form-group autoridades_escolares_Maill">
<input type="text" data-table="autoridades_escolares" data-field="x_Maill" name="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" id="x<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Maill->EditValue ?>"<?php echo $autoridades_escolares->Maill->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Maill" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Maill" value="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="o<?php echo $autoridades_escolares_list->RowIndex ?>_Usuario" id="o<?php echo $autoridades_escolares_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$autoridades_escolares_list->ListOptions->Render("body", "right", $autoridades_escolares_list->RowCnt);
?>
<script type="text/javascript">
fautoridades_escolareslist.UpdateOpts(<?php echo $autoridades_escolares_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($autoridades_escolares->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $autoridades_escolares_list->FormKeyCountName ?>" id="<?php echo $autoridades_escolares_list->FormKeyCountName ?>" value="<?php echo $autoridades_escolares_list->KeyCount ?>">
<?php echo $autoridades_escolares_list->MultiSelectKey ?>
<?php } ?>
<?php if ($autoridades_escolares->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $autoridades_escolares_list->FormKeyCountName ?>" id="<?php echo $autoridades_escolares_list->FormKeyCountName ?>" value="<?php echo $autoridades_escolares_list->KeyCount ?>">
<?php echo $autoridades_escolares_list->MultiSelectKey ?>
<?php } ?>
<?php if ($autoridades_escolares->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($autoridades_escolares_list->Recordset)
	$autoridades_escolares_list->Recordset->Close();
?>
<?php if ($autoridades_escolares->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($autoridades_escolares->CurrentAction <> "gridadd" && $autoridades_escolares->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($autoridades_escolares_list->Pager)) $autoridades_escolares_list->Pager = new cPrevNextPager($autoridades_escolares_list->StartRec, $autoridades_escolares_list->DisplayRecs, $autoridades_escolares_list->TotalRecs) ?>
<?php if ($autoridades_escolares_list->Pager->RecordCount > 0 && $autoridades_escolares_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($autoridades_escolares_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $autoridades_escolares_list->PageUrl() ?>start=<?php echo $autoridades_escolares_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($autoridades_escolares_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $autoridades_escolares_list->PageUrl() ?>start=<?php echo $autoridades_escolares_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $autoridades_escolares_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($autoridades_escolares_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $autoridades_escolares_list->PageUrl() ?>start=<?php echo $autoridades_escolares_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($autoridades_escolares_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $autoridades_escolares_list->PageUrl() ?>start=<?php echo $autoridades_escolares_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $autoridades_escolares_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $autoridades_escolares_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $autoridades_escolares_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $autoridades_escolares_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($autoridades_escolares_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($autoridades_escolares_list->TotalRecs == 0 && $autoridades_escolares->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($autoridades_escolares_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($autoridades_escolares->Export == "") { ?>
<script type="text/javascript">
fautoridades_escolareslistsrch.FilterList = <?php echo $autoridades_escolares_list->GetFilterList() ?>;
fautoridades_escolareslistsrch.Init();
fautoridades_escolareslist.Init();
</script>
<?php } ?>
<?php
$autoridades_escolares_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($autoridades_escolares->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$autoridades_escolares_list->Page_Terminate();
?>
