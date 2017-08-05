<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detalle_asistenciainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detalle_asistencia_list = NULL; // Initialize page object first

class cdetalle_asistencia_list extends cdetalle_asistencia {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'detalle_asistencia';

	// Page object name
	var $PageObjName = 'detalle_asistencia_list';

	// Grid form hidden field names
	var $FormName = 'fdetalle_asistencialist';
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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (detalle_asistencia)
		if (!isset($GLOBALS["detalle_asistencia"]) || get_class($GLOBALS["detalle_asistencia"]) == "cdetalle_asistencia") {
			$GLOBALS["detalle_asistencia"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_asistencia"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "detalle_asistenciaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "detalle_asistenciadelete.php";
		$this->MultiUpdateUrl = "detalle_asistenciaupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_asistencia', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdetalle_asistencialistsrch";

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
		$this->Dia->SetVisibility();
		$this->Dia->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Dias->SetVisibility();
		$this->Horario->SetVisibility();
		$this->Rol->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Id_Asistencia->SetVisibility();

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
		global $EW_EXPORT, $detalle_asistencia;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detalle_asistencia);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

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

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("Dia", ""); // Clear inline edit key
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

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["Dia"] <> "") {
			$this->Dia->setQueryStringValue($_GET["Dia"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Dia", $this->Dia->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("Dia")) <> strval($this->Dia->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
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
			$this->Dia->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Dia->FormValue))
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
					$sKey .= $this->Dia->CurrentValue;

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
		if ($objForm->HasValue("x_Dias") && $objForm->HasValue("o_Dias") && $this->Dias->CurrentValue <> $this->Dias->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Horario") && $objForm->HasValue("o_Horario") && $this->Horario->CurrentValue <> $this->Horario->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Rol") && $objForm->HasValue("o_Rol") && $this->Rol->CurrentValue <> $this->Rol->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Observacion") && $objForm->HasValue("o_Observacion") && $this->Observacion->CurrentValue <> $this->Observacion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Asistencia") && $objForm->HasValue("o_Id_Asistencia") && $this->Id_Asistencia->CurrentValue <> $this->Id_Asistencia->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdetalle_asistencialistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Dia->AdvancedSearch->ToJSON(), ","); // Field Dia
		$sFilterList = ew_Concat($sFilterList, $this->Dias->AdvancedSearch->ToJSON(), ","); // Field Dias
		$sFilterList = ew_Concat($sFilterList, $this->Horario->AdvancedSearch->ToJSON(), ","); // Field Horario
		$sFilterList = ew_Concat($sFilterList, $this->Rol->AdvancedSearch->ToJSON(), ","); // Field Rol
		$sFilterList = ew_Concat($sFilterList, $this->Observacion->AdvancedSearch->ToJSON(), ","); // Field Observacion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Asistencia->AdvancedSearch->ToJSON(), ","); // Field Id_Asistencia
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdetalle_asistencialistsrch", $filters);
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

		// Field Dia
		$this->Dia->AdvancedSearch->SearchValue = @$filter["x_Dia"];
		$this->Dia->AdvancedSearch->SearchOperator = @$filter["z_Dia"];
		$this->Dia->AdvancedSearch->SearchCondition = @$filter["v_Dia"];
		$this->Dia->AdvancedSearch->SearchValue2 = @$filter["y_Dia"];
		$this->Dia->AdvancedSearch->SearchOperator2 = @$filter["w_Dia"];
		$this->Dia->AdvancedSearch->Save();

		// Field Dias
		$this->Dias->AdvancedSearch->SearchValue = @$filter["x_Dias"];
		$this->Dias->AdvancedSearch->SearchOperator = @$filter["z_Dias"];
		$this->Dias->AdvancedSearch->SearchCondition = @$filter["v_Dias"];
		$this->Dias->AdvancedSearch->SearchValue2 = @$filter["y_Dias"];
		$this->Dias->AdvancedSearch->SearchOperator2 = @$filter["w_Dias"];
		$this->Dias->AdvancedSearch->Save();

		// Field Horario
		$this->Horario->AdvancedSearch->SearchValue = @$filter["x_Horario"];
		$this->Horario->AdvancedSearch->SearchOperator = @$filter["z_Horario"];
		$this->Horario->AdvancedSearch->SearchCondition = @$filter["v_Horario"];
		$this->Horario->AdvancedSearch->SearchValue2 = @$filter["y_Horario"];
		$this->Horario->AdvancedSearch->SearchOperator2 = @$filter["w_Horario"];
		$this->Horario->AdvancedSearch->Save();

		// Field Rol
		$this->Rol->AdvancedSearch->SearchValue = @$filter["x_Rol"];
		$this->Rol->AdvancedSearch->SearchOperator = @$filter["z_Rol"];
		$this->Rol->AdvancedSearch->SearchCondition = @$filter["v_Rol"];
		$this->Rol->AdvancedSearch->SearchValue2 = @$filter["y_Rol"];
		$this->Rol->AdvancedSearch->SearchOperator2 = @$filter["w_Rol"];
		$this->Rol->AdvancedSearch->Save();

		// Field Observacion
		$this->Observacion->AdvancedSearch->SearchValue = @$filter["x_Observacion"];
		$this->Observacion->AdvancedSearch->SearchOperator = @$filter["z_Observacion"];
		$this->Observacion->AdvancedSearch->SearchCondition = @$filter["v_Observacion"];
		$this->Observacion->AdvancedSearch->SearchValue2 = @$filter["y_Observacion"];
		$this->Observacion->AdvancedSearch->SearchOperator2 = @$filter["w_Observacion"];
		$this->Observacion->AdvancedSearch->Save();

		// Field Id_Asistencia
		$this->Id_Asistencia->AdvancedSearch->SearchValue = @$filter["x_Id_Asistencia"];
		$this->Id_Asistencia->AdvancedSearch->SearchOperator = @$filter["z_Id_Asistencia"];
		$this->Id_Asistencia->AdvancedSearch->SearchCondition = @$filter["v_Id_Asistencia"];
		$this->Id_Asistencia->AdvancedSearch->SearchValue2 = @$filter["y_Id_Asistencia"];
		$this->Id_Asistencia->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Asistencia"];
		$this->Id_Asistencia->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Dia, $Default, FALSE); // Dia
		$this->BuildSearchSql($sWhere, $this->Dias, $Default, FALSE); // Dias
		$this->BuildSearchSql($sWhere, $this->Horario, $Default, FALSE); // Horario
		$this->BuildSearchSql($sWhere, $this->Rol, $Default, FALSE); // Rol
		$this->BuildSearchSql($sWhere, $this->Observacion, $Default, FALSE); // Observacion
		$this->BuildSearchSql($sWhere, $this->Id_Asistencia, $Default, FALSE); // Id_Asistencia

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Dia->AdvancedSearch->Save(); // Dia
			$this->Dias->AdvancedSearch->Save(); // Dias
			$this->Horario->AdvancedSearch->Save(); // Horario
			$this->Rol->AdvancedSearch->Save(); // Rol
			$this->Observacion->AdvancedSearch->Save(); // Observacion
			$this->Id_Asistencia->AdvancedSearch->Save(); // Id_Asistencia
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
		$this->BuildBasicSearchSQL($sWhere, $this->Dias, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Horario, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Rol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Observacion, $arKeywords, $type);
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
		if ($this->Dia->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dias->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Horario->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Rol->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Observacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Asistencia->AdvancedSearch->IssetSession())
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
		$this->Dia->AdvancedSearch->UnsetSession();
		$this->Dias->AdvancedSearch->UnsetSession();
		$this->Horario->AdvancedSearch->UnsetSession();
		$this->Rol->AdvancedSearch->UnsetSession();
		$this->Observacion->AdvancedSearch->UnsetSession();
		$this->Id_Asistencia->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Dia->AdvancedSearch->Load();
		$this->Dias->AdvancedSearch->Load();
		$this->Horario->AdvancedSearch->Load();
		$this->Rol->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Id_Asistencia->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Dia); // Dia
			$this->UpdateSort($this->Dias); // Dias
			$this->UpdateSort($this->Horario); // Horario
			$this->UpdateSort($this->Rol); // Rol
			$this->UpdateSort($this->Observacion); // Observacion
			$this->UpdateSort($this->Id_Asistencia); // Id_Asistencia
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
				$this->Dia->setSort("");
				$this->Dias->setSort("");
				$this->Horario->setSort("");
				$this->Rol->setSort("");
				$this->Observacion->setSort("");
				$this->Id_Asistencia->setSort("");
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
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
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
		$item->Visible = ($Security->CanDelete() || $Security->CanEdit());
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
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Dia->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"detalle_asistencia\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"detalle_asistencia\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Dia->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Dia->CurrentValue . "\">";
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
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fdetalle_asistencialist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"detalle_asistencia\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fdetalle_asistencialist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
		$item->Visible = ($Security->CanEdit());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdetalle_asistencialistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdetalle_asistencialistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdetalle_asistencialist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$item->Visible = $Security->CanAdd();
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
					$item->Visible = $Security->CanAdd();
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdetalle_asistencialistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"detalle_asistenciasrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->Dia->CurrentValue = NULL;
		$this->Dia->OldValue = $this->Dia->CurrentValue;
		$this->Dias->CurrentValue = NULL;
		$this->Dias->OldValue = $this->Dias->CurrentValue;
		$this->Horario->CurrentValue = NULL;
		$this->Horario->OldValue = $this->Horario->CurrentValue;
		$this->Rol->CurrentValue = NULL;
		$this->Rol->OldValue = $this->Rol->CurrentValue;
		$this->Observacion->CurrentValue = NULL;
		$this->Observacion->OldValue = $this->Observacion->CurrentValue;
		$this->Id_Asistencia->CurrentValue = NULL;
		$this->Id_Asistencia->OldValue = $this->Id_Asistencia->CurrentValue;
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
		// Dia

		$this->Dia->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dia"]);
		if ($this->Dia->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dia->AdvancedSearch->SearchOperator = @$_GET["z_Dia"];

		// Dias
		$this->Dias->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dias"]);
		if ($this->Dias->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dias->AdvancedSearch->SearchOperator = @$_GET["z_Dias"];

		// Horario
		$this->Horario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Horario"]);
		if ($this->Horario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Horario->AdvancedSearch->SearchOperator = @$_GET["z_Horario"];

		// Rol
		$this->Rol->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Rol"]);
		if ($this->Rol->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Rol->AdvancedSearch->SearchOperator = @$_GET["z_Rol"];

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Observacion"]);
		if ($this->Observacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Observacion->AdvancedSearch->SearchOperator = @$_GET["z_Observacion"];

		// Id_Asistencia
		$this->Id_Asistencia->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Asistencia"]);
		if ($this->Id_Asistencia->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Asistencia->AdvancedSearch->SearchOperator = @$_GET["z_Id_Asistencia"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Dia->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Dia->setFormValue($objForm->GetValue("x_Dia"));
		if (!$this->Dias->FldIsDetailKey) {
			$this->Dias->setFormValue($objForm->GetValue("x_Dias"));
		}
		$this->Dias->setOldValue($objForm->GetValue("o_Dias"));
		if (!$this->Horario->FldIsDetailKey) {
			$this->Horario->setFormValue($objForm->GetValue("x_Horario"));
		}
		$this->Horario->setOldValue($objForm->GetValue("o_Horario"));
		if (!$this->Rol->FldIsDetailKey) {
			$this->Rol->setFormValue($objForm->GetValue("x_Rol"));
		}
		$this->Rol->setOldValue($objForm->GetValue("o_Rol"));
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->setOldValue($objForm->GetValue("o_Observacion"));
		if (!$this->Id_Asistencia->FldIsDetailKey) {
			$this->Id_Asistencia->setFormValue($objForm->GetValue("x_Id_Asistencia"));
		}
		$this->Id_Asistencia->setOldValue($objForm->GetValue("o_Id_Asistencia"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->Dia->CurrentValue = $this->Dia->FormValue;
		$this->Dias->CurrentValue = $this->Dias->FormValue;
		$this->Horario->CurrentValue = $this->Horario->FormValue;
		$this->Rol->CurrentValue = $this->Rol->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Id_Asistencia->CurrentValue = $this->Id_Asistencia->FormValue;
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
		$this->Dia->setDbValue($rs->fields('Dia'));
		$this->Dias->setDbValue($rs->fields('Dias'));
		$this->Horario->setDbValue($rs->fields('Horario'));
		$this->Rol->setDbValue($rs->fields('Rol'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Id_Asistencia->setDbValue($rs->fields('Id_Asistencia'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dia->DbValue = $row['Dia'];
		$this->Dias->DbValue = $row['Dias'];
		$this->Horario->DbValue = $row['Horario'];
		$this->Rol->DbValue = $row['Rol'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Id_Asistencia->DbValue = $row['Id_Asistencia'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Dia")) <> "")
			$this->Dia->CurrentValue = $this->getKey("Dia"); // Dia
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
		// Dia
		// Dias
		// Horario
		// Rol
		// Observacion
		// Id_Asistencia

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dia
		if (strval($this->Dia->CurrentValue) <> "") {
			$this->Dia->ViewValue = $this->Dia->OptionCaption($this->Dia->CurrentValue);
		} else {
			$this->Dia->ViewValue = NULL;
		}
		$this->Dia->ViewCustomAttributes = "";

		// Dias
		$this->Dias->ViewValue = $this->Dias->CurrentValue;
		$this->Dias->ViewCustomAttributes = "";

		// Horario
		$this->Horario->ViewValue = $this->Horario->CurrentValue;
		$this->Horario->ViewCustomAttributes = "";

		// Rol
		$this->Rol->ViewValue = $this->Rol->CurrentValue;
		$this->Rol->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Asistencia
		$this->Id_Asistencia->ViewValue = $this->Id_Asistencia->CurrentValue;
		$this->Id_Asistencia->ViewCustomAttributes = "";

			// Dia
			$this->Dia->LinkCustomAttributes = "";
			$this->Dia->HrefValue = "";
			$this->Dia->TooltipValue = "";

			// Dias
			$this->Dias->LinkCustomAttributes = "";
			$this->Dias->HrefValue = "";
			$this->Dias->TooltipValue = "";

			// Horario
			$this->Horario->LinkCustomAttributes = "";
			$this->Horario->HrefValue = "";
			$this->Horario->TooltipValue = "";

			// Rol
			$this->Rol->LinkCustomAttributes = "";
			$this->Rol->HrefValue = "";
			$this->Rol->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Id_Asistencia
			$this->Id_Asistencia->LinkCustomAttributes = "";
			$this->Id_Asistencia->HrefValue = "";
			$this->Id_Asistencia->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Dia
			// Dias

			$this->Dias->EditAttrs["class"] = "form-control";
			$this->Dias->EditCustomAttributes = "";
			$this->Dias->EditValue = ew_HtmlEncode($this->Dias->CurrentValue);
			$this->Dias->PlaceHolder = ew_RemoveHtml($this->Dias->FldCaption());

			// Horario
			$this->Horario->EditAttrs["class"] = "form-control";
			$this->Horario->EditCustomAttributes = "";
			$this->Horario->EditValue = ew_HtmlEncode($this->Horario->CurrentValue);
			$this->Horario->PlaceHolder = ew_RemoveHtml($this->Horario->FldCaption());

			// Rol
			$this->Rol->EditAttrs["class"] = "form-control";
			$this->Rol->EditCustomAttributes = "";
			$this->Rol->EditValue = ew_HtmlEncode($this->Rol->CurrentValue);
			$this->Rol->PlaceHolder = ew_RemoveHtml($this->Rol->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Asistencia
			$this->Id_Asistencia->EditAttrs["class"] = "form-control";
			$this->Id_Asistencia->EditCustomAttributes = "";
			$this->Id_Asistencia->EditValue = ew_HtmlEncode($this->Id_Asistencia->CurrentValue);
			$this->Id_Asistencia->PlaceHolder = ew_RemoveHtml($this->Id_Asistencia->FldCaption());

			// Add refer script
			// Dia

			$this->Dia->LinkCustomAttributes = "";
			$this->Dia->HrefValue = "";

			// Dias
			$this->Dias->LinkCustomAttributes = "";
			$this->Dias->HrefValue = "";

			// Horario
			$this->Horario->LinkCustomAttributes = "";
			$this->Horario->HrefValue = "";

			// Rol
			$this->Rol->LinkCustomAttributes = "";
			$this->Rol->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Id_Asistencia
			$this->Id_Asistencia->LinkCustomAttributes = "";
			$this->Id_Asistencia->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dia
			$this->Dia->EditAttrs["class"] = "form-control";
			$this->Dia->EditCustomAttributes = "";
			if (strval($this->Dia->CurrentValue) <> "") {
				$this->Dia->EditValue = $this->Dia->OptionCaption($this->Dia->CurrentValue);
			} else {
				$this->Dia->EditValue = NULL;
			}
			$this->Dia->ViewCustomAttributes = "";

			// Dias
			$this->Dias->EditAttrs["class"] = "form-control";
			$this->Dias->EditCustomAttributes = "";
			$this->Dias->EditValue = ew_HtmlEncode($this->Dias->CurrentValue);
			$this->Dias->PlaceHolder = ew_RemoveHtml($this->Dias->FldCaption());

			// Horario
			$this->Horario->EditAttrs["class"] = "form-control";
			$this->Horario->EditCustomAttributes = "";
			$this->Horario->EditValue = ew_HtmlEncode($this->Horario->CurrentValue);
			$this->Horario->PlaceHolder = ew_RemoveHtml($this->Horario->FldCaption());

			// Rol
			$this->Rol->EditAttrs["class"] = "form-control";
			$this->Rol->EditCustomAttributes = "";
			$this->Rol->EditValue = ew_HtmlEncode($this->Rol->CurrentValue);
			$this->Rol->PlaceHolder = ew_RemoveHtml($this->Rol->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Asistencia
			$this->Id_Asistencia->EditAttrs["class"] = "form-control";
			$this->Id_Asistencia->EditCustomAttributes = "";
			$this->Id_Asistencia->EditValue = ew_HtmlEncode($this->Id_Asistencia->CurrentValue);
			$this->Id_Asistencia->PlaceHolder = ew_RemoveHtml($this->Id_Asistencia->FldCaption());

			// Edit refer script
			// Dia

			$this->Dia->LinkCustomAttributes = "";
			$this->Dia->HrefValue = "";

			// Dias
			$this->Dias->LinkCustomAttributes = "";
			$this->Dias->HrefValue = "";

			// Horario
			$this->Horario->LinkCustomAttributes = "";
			$this->Horario->HrefValue = "";

			// Rol
			$this->Rol->LinkCustomAttributes = "";
			$this->Rol->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Id_Asistencia
			$this->Id_Asistencia->LinkCustomAttributes = "";
			$this->Id_Asistencia->HrefValue = "";
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
		if (!$this->Id_Asistencia->FldIsDetailKey && !is_null($this->Id_Asistencia->FormValue) && $this->Id_Asistencia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Asistencia->FldCaption(), $this->Id_Asistencia->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Id_Asistencia->FormValue)) {
			ew_AddMessage($gsFormError, $this->Id_Asistencia->FldErrMsg());
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
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
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
				$sThisKey .= $row['Dia'];
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

			// Dias
			$this->Dias->SetDbValueDef($rsnew, $this->Dias->CurrentValue, NULL, $this->Dias->ReadOnly);

			// Horario
			$this->Horario->SetDbValueDef($rsnew, $this->Horario->CurrentValue, NULL, $this->Horario->ReadOnly);

			// Rol
			$this->Rol->SetDbValueDef($rsnew, $this->Rol->CurrentValue, NULL, $this->Rol->ReadOnly);

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly);

			// Id_Asistencia
			$this->Id_Asistencia->SetDbValueDef($rsnew, $this->Id_Asistencia->CurrentValue, 0, $this->Id_Asistencia->ReadOnly);

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

		// Dias
		$this->Dias->SetDbValueDef($rsnew, $this->Dias->CurrentValue, NULL, FALSE);

		// Horario
		$this->Horario->SetDbValueDef($rsnew, $this->Horario->CurrentValue, NULL, FALSE);

		// Rol
		$this->Rol->SetDbValueDef($rsnew, $this->Rol->CurrentValue, NULL, FALSE);

		// Observacion
		$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, FALSE);

		// Id_Asistencia
		$this->Id_Asistencia->SetDbValueDef($rsnew, $this->Id_Asistencia->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Dia->setDbValue($conn->Insert_ID());
				$rsnew['Dia'] = $this->Dia->DbValue;
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
		$this->Dia->AdvancedSearch->Load();
		$this->Dias->AdvancedSearch->Load();
		$this->Horario->AdvancedSearch->Load();
		$this->Rol->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Id_Asistencia->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_detalle_asistencia\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_detalle_asistencia',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdetalle_asistencialist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'detalle_asistencia';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'detalle_asistencia';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dia'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
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
		$table = 'detalle_asistencia';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dia'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
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
		$table = 'detalle_asistencia';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dia'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
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
if (!isset($detalle_asistencia_list)) $detalle_asistencia_list = new cdetalle_asistencia_list();

// Page init
$detalle_asistencia_list->Page_Init();

// Page main
$detalle_asistencia_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_asistencia_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($detalle_asistencia->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdetalle_asistencialist = new ew_Form("fdetalle_asistencialist", "list");
fdetalle_asistencialist.FormKeyCountName = '<?php echo $detalle_asistencia_list->FormKeyCountName ?>';

// Validate form
fdetalle_asistencialist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Asistencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_asistencia->Id_Asistencia->FldCaption(), $detalle_asistencia->Id_Asistencia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Asistencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_asistencia->Id_Asistencia->FldErrMsg()) ?>");

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
fdetalle_asistencialist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Dias", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Horario", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Rol", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Observacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Asistencia", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_asistencialist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_asistencialist.ValidateRequired = true;
<?php } else { ?>
fdetalle_asistencialist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_asistencialist.Lists["x_Dia"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdetalle_asistencialist.Lists["x_Dia"].Options = <?php echo json_encode($detalle_asistencia->Dia->Options()) ?>;

// Form object for search
var CurrentSearchForm = fdetalle_asistencialistsrch = new ew_Form("fdetalle_asistencialistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($detalle_asistencia->Export == "") { ?>
<div class="ewToolbar">
<?php if ($detalle_asistencia->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($detalle_asistencia_list->TotalRecs > 0 && $detalle_asistencia_list->ExportOptions->Visible()) { ?>
<?php $detalle_asistencia_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($detalle_asistencia_list->SearchOptions->Visible()) { ?>
<?php $detalle_asistencia_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($detalle_asistencia_list->FilterOptions->Visible()) { ?>
<?php $detalle_asistencia_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($detalle_asistencia->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($detalle_asistencia->CurrentAction == "gridadd") {
	$detalle_asistencia->CurrentFilter = "0=1";
	$detalle_asistencia_list->StartRec = 1;
	$detalle_asistencia_list->DisplayRecs = $detalle_asistencia->GridAddRowCount;
	$detalle_asistencia_list->TotalRecs = $detalle_asistencia_list->DisplayRecs;
	$detalle_asistencia_list->StopRec = $detalle_asistencia_list->DisplayRecs;
} else {
	$bSelectLimit = $detalle_asistencia_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($detalle_asistencia_list->TotalRecs <= 0)
			$detalle_asistencia_list->TotalRecs = $detalle_asistencia->SelectRecordCount();
	} else {
		if (!$detalle_asistencia_list->Recordset && ($detalle_asistencia_list->Recordset = $detalle_asistencia_list->LoadRecordset()))
			$detalle_asistencia_list->TotalRecs = $detalle_asistencia_list->Recordset->RecordCount();
	}
	$detalle_asistencia_list->StartRec = 1;
	if ($detalle_asistencia_list->DisplayRecs <= 0 || ($detalle_asistencia->Export <> "" && $detalle_asistencia->ExportAll)) // Display all records
		$detalle_asistencia_list->DisplayRecs = $detalle_asistencia_list->TotalRecs;
	if (!($detalle_asistencia->Export <> "" && $detalle_asistencia->ExportAll))
		$detalle_asistencia_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$detalle_asistencia_list->Recordset = $detalle_asistencia_list->LoadRecordset($detalle_asistencia_list->StartRec-1, $detalle_asistencia_list->DisplayRecs);

	// Set no record found message
	if ($detalle_asistencia->CurrentAction == "" && $detalle_asistencia_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$detalle_asistencia_list->setWarningMessage(ew_DeniedMsg());
		if ($detalle_asistencia_list->SearchWhere == "0=101")
			$detalle_asistencia_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_asistencia_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($detalle_asistencia_list->AuditTrailOnSearch && $detalle_asistencia_list->Command == "search" && !$detalle_asistencia_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $detalle_asistencia_list->getSessionWhere();
		$detalle_asistencia_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$detalle_asistencia_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($detalle_asistencia->Export == "" && $detalle_asistencia->CurrentAction == "") { ?>
<form name="fdetalle_asistencialistsrch" id="fdetalle_asistencialistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($detalle_asistencia_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdetalle_asistencialistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="detalle_asistencia">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($detalle_asistencia_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($detalle_asistencia_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $detalle_asistencia_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($detalle_asistencia_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($detalle_asistencia_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($detalle_asistencia_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($detalle_asistencia_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $detalle_asistencia_list->ShowPageHeader(); ?>
<?php
$detalle_asistencia_list->ShowMessage();
?>
<?php if ($detalle_asistencia_list->TotalRecs > 0 || $detalle_asistencia->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid detalle_asistencia">
<form name="fdetalle_asistencialist" id="fdetalle_asistencialist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_asistencia_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_asistencia_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_asistencia">
<div id="gmp_detalle_asistencia" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($detalle_asistencia_list->TotalRecs > 0 || $detalle_asistencia->CurrentAction == "add" || $detalle_asistencia->CurrentAction == "copy") { ?>
<table id="tbl_detalle_asistencialist" class="table ewTable">
<?php echo $detalle_asistencia->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$detalle_asistencia_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$detalle_asistencia_list->RenderListOptions();

// Render list options (header, left)
$detalle_asistencia_list->ListOptions->Render("header", "left");
?>
<?php if ($detalle_asistencia->Dia->Visible) { // Dia ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Dia) == "") { ?>
		<th data-name="Dia"><div id="elh_detalle_asistencia_Dia" class="detalle_asistencia_Dia"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Dia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Dia) ?>',1);"><div id="elh_detalle_asistencia_Dia" class="detalle_asistencia_Dia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Dia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Dia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Dia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Dias) == "") { ?>
		<th data-name="Dias"><div id="elh_detalle_asistencia_Dias" class="detalle_asistencia_Dias"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Dias->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dias"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Dias) ?>',1);"><div id="elh_detalle_asistencia_Dias" class="detalle_asistencia_Dias">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Dias->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Dias->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Dias->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Horario) == "") { ?>
		<th data-name="Horario"><div id="elh_detalle_asistencia_Horario" class="detalle_asistencia_Horario"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Horario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Horario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Horario) ?>',1);"><div id="elh_detalle_asistencia_Horario" class="detalle_asistencia_Horario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Horario->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Horario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Horario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Rol) == "") { ?>
		<th data-name="Rol"><div id="elh_detalle_asistencia_Rol" class="detalle_asistencia_Rol"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Rol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rol"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Rol) ?>',1);"><div id="elh_detalle_asistencia_Rol" class="detalle_asistencia_Rol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Rol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Rol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Rol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Observacion) == "") { ?>
		<th data-name="Observacion"><div id="elh_detalle_asistencia_Observacion" class="detalle_asistencia_Observacion"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Observacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Observacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Observacion) ?>',1);"><div id="elh_detalle_asistencia_Observacion" class="detalle_asistencia_Observacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Observacion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Observacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Observacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
	<?php if ($detalle_asistencia->SortUrl($detalle_asistencia->Id_Asistencia) == "") { ?>
		<th data-name="Id_Asistencia"><div id="elh_detalle_asistencia_Id_Asistencia" class="detalle_asistencia_Id_Asistencia"><div class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Id_Asistencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Asistencia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_asistencia->SortUrl($detalle_asistencia->Id_Asistencia) ?>',1);"><div id="elh_detalle_asistencia_Id_Asistencia" class="detalle_asistencia_Id_Asistencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_asistencia->Id_Asistencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_asistencia->Id_Asistencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_asistencia->Id_Asistencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_asistencia_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($detalle_asistencia->CurrentAction == "add" || $detalle_asistencia->CurrentAction == "copy") {
		$detalle_asistencia_list->RowIndex = 0;
		$detalle_asistencia_list->KeyCount = $detalle_asistencia_list->RowIndex;
		if ($detalle_asistencia->CurrentAction == "add")
			$detalle_asistencia_list->LoadDefaultValues();
		if ($detalle_asistencia->EventCancelled) // Insert failed
			$detalle_asistencia_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$detalle_asistencia->ResetAttrs();
		$detalle_asistencia->RowAttrs = array_merge($detalle_asistencia->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_detalle_asistencia', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$detalle_asistencia->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_asistencia_list->RenderRow();

		// Render list options
		$detalle_asistencia_list->RenderListOptions();
		$detalle_asistencia_list->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_asistencia->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_asistencia_list->ListOptions->Render("body", "left", $detalle_asistencia_list->RowCnt);
?>
	<?php if ($detalle_asistencia->Dia->Visible) { // Dia ?>
		<td data-name="Dia">
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
		<td data-name="Dias">
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dias" class="form-group detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dias" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
		<td data-name="Horario">
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Horario" class="form-group detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Horario" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" value="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
		<td data-name="Rol">
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Rol" class="form-group detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Rol" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" value="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Observacion" class="form-group detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Observacion" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
		<td data-name="Id_Asistencia">
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Id_Asistencia" class="form-group detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_asistencia_list->ListOptions->Render("body", "right", $detalle_asistencia_list->RowCnt);
?>
<script type="text/javascript">
fdetalle_asistencialist.UpdateOpts(<?php echo $detalle_asistencia_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($detalle_asistencia->ExportAll && $detalle_asistencia->Export <> "") {
	$detalle_asistencia_list->StopRec = $detalle_asistencia_list->TotalRecs;
} else {

	// Set the last record to display
	if ($detalle_asistencia_list->TotalRecs > $detalle_asistencia_list->StartRec + $detalle_asistencia_list->DisplayRecs - 1)
		$detalle_asistencia_list->StopRec = $detalle_asistencia_list->StartRec + $detalle_asistencia_list->DisplayRecs - 1;
	else
		$detalle_asistencia_list->StopRec = $detalle_asistencia_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_asistencia_list->FormKeyCountName) && ($detalle_asistencia->CurrentAction == "gridadd" || $detalle_asistencia->CurrentAction == "gridedit" || $detalle_asistencia->CurrentAction == "F")) {
		$detalle_asistencia_list->KeyCount = $objForm->GetValue($detalle_asistencia_list->FormKeyCountName);
		$detalle_asistencia_list->StopRec = $detalle_asistencia_list->StartRec + $detalle_asistencia_list->KeyCount - 1;
	}
}
$detalle_asistencia_list->RecCnt = $detalle_asistencia_list->StartRec - 1;
if ($detalle_asistencia_list->Recordset && !$detalle_asistencia_list->Recordset->EOF) {
	$detalle_asistencia_list->Recordset->MoveFirst();
	$bSelectLimit = $detalle_asistencia_list->UseSelectLimit;
	if (!$bSelectLimit && $detalle_asistencia_list->StartRec > 1)
		$detalle_asistencia_list->Recordset->Move($detalle_asistencia_list->StartRec - 1);
} elseif (!$detalle_asistencia->AllowAddDeleteRow && $detalle_asistencia_list->StopRec == 0) {
	$detalle_asistencia_list->StopRec = $detalle_asistencia->GridAddRowCount;
}

// Initialize aggregate
$detalle_asistencia->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_asistencia->ResetAttrs();
$detalle_asistencia_list->RenderRow();
$detalle_asistencia_list->EditRowCnt = 0;
if ($detalle_asistencia->CurrentAction == "edit")
	$detalle_asistencia_list->RowIndex = 1;
if ($detalle_asistencia->CurrentAction == "gridadd")
	$detalle_asistencia_list->RowIndex = 0;
if ($detalle_asistencia->CurrentAction == "gridedit")
	$detalle_asistencia_list->RowIndex = 0;
while ($detalle_asistencia_list->RecCnt < $detalle_asistencia_list->StopRec) {
	$detalle_asistencia_list->RecCnt++;
	if (intval($detalle_asistencia_list->RecCnt) >= intval($detalle_asistencia_list->StartRec)) {
		$detalle_asistencia_list->RowCnt++;
		if ($detalle_asistencia->CurrentAction == "gridadd" || $detalle_asistencia->CurrentAction == "gridedit" || $detalle_asistencia->CurrentAction == "F") {
			$detalle_asistencia_list->RowIndex++;
			$objForm->Index = $detalle_asistencia_list->RowIndex;
			if ($objForm->HasValue($detalle_asistencia_list->FormActionName))
				$detalle_asistencia_list->RowAction = strval($objForm->GetValue($detalle_asistencia_list->FormActionName));
			elseif ($detalle_asistencia->CurrentAction == "gridadd")
				$detalle_asistencia_list->RowAction = "insert";
			else
				$detalle_asistencia_list->RowAction = "";
		}

		// Set up key count
		$detalle_asistencia_list->KeyCount = $detalle_asistencia_list->RowIndex;

		// Init row class and style
		$detalle_asistencia->ResetAttrs();
		$detalle_asistencia->CssClass = "";
		if ($detalle_asistencia->CurrentAction == "gridadd") {
			$detalle_asistencia_list->LoadDefaultValues(); // Load default values
		} else {
			$detalle_asistencia_list->LoadRowValues($detalle_asistencia_list->Recordset); // Load row values
		}
		$detalle_asistencia->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_asistencia->CurrentAction == "gridadd") // Grid add
			$detalle_asistencia->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_asistencia->CurrentAction == "gridadd" && $detalle_asistencia->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_asistencia_list->RestoreCurrentRowFormValues($detalle_asistencia_list->RowIndex); // Restore form values
		if ($detalle_asistencia->CurrentAction == "edit") {
			if ($detalle_asistencia_list->CheckInlineEditKey() && $detalle_asistencia_list->EditRowCnt == 0) { // Inline edit
				$detalle_asistencia->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($detalle_asistencia->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_asistencia->EventCancelled) {
				$detalle_asistencia_list->RestoreCurrentRowFormValues($detalle_asistencia_list->RowIndex); // Restore form values
			}
			if ($detalle_asistencia_list->RowAction == "insert")
				$detalle_asistencia->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_asistencia->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_asistencia->CurrentAction == "edit" && $detalle_asistencia->RowType == EW_ROWTYPE_EDIT && $detalle_asistencia->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$detalle_asistencia_list->RestoreFormValues(); // Restore form values
		}
		if ($detalle_asistencia->CurrentAction == "gridedit" && ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT || $detalle_asistencia->RowType == EW_ROWTYPE_ADD) && $detalle_asistencia->EventCancelled) // Update failed
			$detalle_asistencia_list->RestoreCurrentRowFormValues($detalle_asistencia_list->RowIndex); // Restore form values
		if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_asistencia_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$detalle_asistencia->RowAttrs = array_merge($detalle_asistencia->RowAttrs, array('data-rowindex'=>$detalle_asistencia_list->RowCnt, 'id'=>'r' . $detalle_asistencia_list->RowCnt . '_detalle_asistencia', 'data-rowtype'=>$detalle_asistencia->RowType));

		// Render row
		$detalle_asistencia_list->RenderRow();

		// Render list options
		$detalle_asistencia_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_asistencia_list->RowAction <> "delete" && $detalle_asistencia_list->RowAction <> "insertdelete" && !($detalle_asistencia_list->RowAction == "insert" && $detalle_asistencia->CurrentAction == "F" && $detalle_asistencia_list->EmptyRow())) {
?>
	<tr<?php echo $detalle_asistencia->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_asistencia_list->ListOptions->Render("body", "left", $detalle_asistencia_list->RowCnt);
?>
	<?php if ($detalle_asistencia->Dia->Visible) { // Dia ?>
		<td data-name="Dia"<?php echo $detalle_asistencia->Dia->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dia->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dia" class="form-group detalle_asistencia_Dia">
<span<?php echo $detalle_asistencia->Dia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_asistencia->Dia->EditValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dia" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dia->CurrentValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dia" class="detalle_asistencia_Dia">
<span<?php echo $detalle_asistencia->Dia->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Dia->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $detalle_asistencia_list->PageObjName . "_row_" . $detalle_asistencia_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
		<td data-name="Dias"<?php echo $detalle_asistencia->Dias->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dias" class="form-group detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dias" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dias" class="form-group detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Dias" class="detalle_asistencia_Dias">
<span<?php echo $detalle_asistencia->Dias->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Dias->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
		<td data-name="Horario"<?php echo $detalle_asistencia->Horario->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Horario" class="form-group detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Horario" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" value="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Horario" class="form-group detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Horario" class="detalle_asistencia_Horario">
<span<?php echo $detalle_asistencia->Horario->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Horario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
		<td data-name="Rol"<?php echo $detalle_asistencia->Rol->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Rol" class="form-group detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Rol" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" value="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Rol" class="form-group detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Rol" class="detalle_asistencia_Rol">
<span<?php echo $detalle_asistencia->Rol->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Rol->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion"<?php echo $detalle_asistencia->Observacion->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Observacion" class="form-group detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Observacion" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Observacion" class="form-group detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Observacion" class="detalle_asistencia_Observacion">
<span<?php echo $detalle_asistencia->Observacion->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Observacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
		<td data-name="Id_Asistencia"<?php echo $detalle_asistencia->Id_Asistencia->CellAttributes() ?>>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Id_Asistencia" class="form-group detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->OldValue) ?>">
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Id_Asistencia" class="form-group detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_asistencia_list->RowCnt ?>_detalle_asistencia_Id_Asistencia" class="detalle_asistencia_Id_Asistencia">
<span<?php echo $detalle_asistencia->Id_Asistencia->ViewAttributes() ?>>
<?php echo $detalle_asistencia->Id_Asistencia->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_asistencia_list->ListOptions->Render("body", "right", $detalle_asistencia_list->RowCnt);
?>
	</tr>
<?php if ($detalle_asistencia->RowType == EW_ROWTYPE_ADD || $detalle_asistencia->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_asistencialist.UpdateOpts(<?php echo $detalle_asistencia_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_asistencia->CurrentAction <> "gridadd")
		if (!$detalle_asistencia_list->Recordset->EOF) $detalle_asistencia_list->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_asistencia->CurrentAction == "gridadd" || $detalle_asistencia->CurrentAction == "gridedit") {
		$detalle_asistencia_list->RowIndex = '$rowindex$';
		$detalle_asistencia_list->LoadDefaultValues();

		// Set row properties
		$detalle_asistencia->ResetAttrs();
		$detalle_asistencia->RowAttrs = array_merge($detalle_asistencia->RowAttrs, array('data-rowindex'=>$detalle_asistencia_list->RowIndex, 'id'=>'r0_detalle_asistencia', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_asistencia->RowAttrs["class"], "ewTemplate");
		$detalle_asistencia->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_asistencia_list->RenderRow();

		// Render list options
		$detalle_asistencia_list->RenderListOptions();
		$detalle_asistencia_list->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_asistencia->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_asistencia_list->ListOptions->Render("body", "left", $detalle_asistencia_list->RowIndex);
?>
	<?php if ($detalle_asistencia->Dia->Visible) { // Dia ?>
		<td data-name="Dia">
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
		<td data-name="Dias">
<span id="el$rowindex$_detalle_asistencia_Dias" class="form-group detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Dias" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Dias" value="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
		<td data-name="Horario">
<span id="el$rowindex$_detalle_asistencia_Horario" class="form-group detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Horario" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Horario" value="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
		<td data-name="Rol">
<span id="el$rowindex$_detalle_asistencia_Rol" class="form-group detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Rol" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Rol" value="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<span id="el$rowindex$_detalle_asistencia_Observacion" class="form-group detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Observacion" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
		<td data-name="Id_Asistencia">
<span id="el$rowindex$_detalle_asistencia_Id_Asistencia" class="form-group detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="x<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" id="o<?php echo $detalle_asistencia_list->RowIndex ?>_Id_Asistencia" value="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_asistencia_list->ListOptions->Render("body", "right", $detalle_asistencia_list->RowCnt);
?>
<script type="text/javascript">
fdetalle_asistencialist.UpdateOpts(<?php echo $detalle_asistencia_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($detalle_asistencia->CurrentAction == "add" || $detalle_asistencia->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" id="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" value="<?php echo $detalle_asistencia_list->KeyCount ?>">
<?php } ?>
<?php if ($detalle_asistencia->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" id="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" value="<?php echo $detalle_asistencia_list->KeyCount ?>">
<?php echo $detalle_asistencia_list->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_asistencia->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" id="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" value="<?php echo $detalle_asistencia_list->KeyCount ?>">
<?php } ?>
<?php if ($detalle_asistencia->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" id="<?php echo $detalle_asistencia_list->FormKeyCountName ?>" value="<?php echo $detalle_asistencia_list->KeyCount ?>">
<?php echo $detalle_asistencia_list->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_asistencia->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($detalle_asistencia_list->Recordset)
	$detalle_asistencia_list->Recordset->Close();
?>
<?php if ($detalle_asistencia->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($detalle_asistencia->CurrentAction <> "gridadd" && $detalle_asistencia->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($detalle_asistencia_list->Pager)) $detalle_asistencia_list->Pager = new cPrevNextPager($detalle_asistencia_list->StartRec, $detalle_asistencia_list->DisplayRecs, $detalle_asistencia_list->TotalRecs) ?>
<?php if ($detalle_asistencia_list->Pager->RecordCount > 0 && $detalle_asistencia_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($detalle_asistencia_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $detalle_asistencia_list->PageUrl() ?>start=<?php echo $detalle_asistencia_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($detalle_asistencia_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $detalle_asistencia_list->PageUrl() ?>start=<?php echo $detalle_asistencia_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $detalle_asistencia_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($detalle_asistencia_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $detalle_asistencia_list->PageUrl() ?>start=<?php echo $detalle_asistencia_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($detalle_asistencia_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $detalle_asistencia_list->PageUrl() ?>start=<?php echo $detalle_asistencia_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $detalle_asistencia_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $detalle_asistencia_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $detalle_asistencia_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $detalle_asistencia_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_asistencia_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($detalle_asistencia_list->TotalRecs == 0 && $detalle_asistencia->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_asistencia_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_asistencia->Export == "") { ?>
<script type="text/javascript">
fdetalle_asistencialistsrch.FilterList = <?php echo $detalle_asistencia_list->GetFilterList() ?>;
fdetalle_asistencialistsrch.Init();
fdetalle_asistencialist.Init();
</script>
<?php } ?>
<?php
$detalle_asistencia_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($detalle_asistencia->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$detalle_asistencia_list->Page_Terminate();
?>
