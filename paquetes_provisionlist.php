<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "paquetes_provisioninfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$paquetes_provision_list = NULL; // Initialize page object first

class cpaquetes_provision_list extends cpaquetes_provision {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'paquetes_provision';

	// Page object name
	var $PageObjName = 'paquetes_provision_list';

	// Grid form hidden field names
	var $FormName = 'fpaquetes_provisionlist';
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

		// Table object (paquetes_provision)
		if (!isset($GLOBALS["paquetes_provision"]) || get_class($GLOBALS["paquetes_provision"]) == "cpaquetes_provision") {
			$GLOBALS["paquetes_provision"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["paquetes_provision"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "paquetes_provisionadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "paquetes_provisiondelete.php";
		$this->MultiUpdateUrl = "paquetes_provisionupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'paquetes_provision', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpaquetes_provisionlistsrch";

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
		$this->Serie_Netbook->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Serie_Server->SetVisibility();
		$this->Id_Motivo->SetVisibility();
		$this->Id_Tipo_Extraccion->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->Id_Tipo_Paquete->SetVisibility();
		$this->Apellido_Nombre_Solicitante->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Email_Solicitante->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Usuario->Visible = !$this->IsAddOrEdit();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Fecha_Actualizacion->Visible = !$this->IsAddOrEdit();

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
		global $EW_EXPORT, $paquetes_provision;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($paquetes_provision);
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
		$this->setKey("NroPedido", ""); // Clear inline edit key
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
		if (@$_GET["NroPedido"] <> "") {
			$this->NroPedido->setQueryStringValue($_GET["NroPedido"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("NroPedido", $this->NroPedido->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("NroPedido")) <> strval($this->NroPedido->CurrentValue))
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
			$this->NroPedido->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->NroPedido->FormValue))
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
					$sKey .= $this->NroPedido->CurrentValue;

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
		if ($objForm->HasValue("x_Serie_Netbook") && $objForm->HasValue("o_Serie_Netbook") && $this->Serie_Netbook->CurrentValue <> $this->Serie_Netbook->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Hardware") && $objForm->HasValue("o_Id_Hardware") && $this->Id_Hardware->CurrentValue <> $this->Id_Hardware->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_SN") && $objForm->HasValue("o_SN") && $this->SN->CurrentValue <> $this->SN->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Marca_Arranque") && $objForm->HasValue("o_Marca_Arranque") && $this->Marca_Arranque->CurrentValue <> $this->Marca_Arranque->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Serie_Server") && $objForm->HasValue("o_Serie_Server") && $this->Serie_Server->CurrentValue <> $this->Serie_Server->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Motivo") && $objForm->HasValue("o_Id_Motivo") && $this->Id_Motivo->CurrentValue <> $this->Id_Motivo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Tipo_Extraccion") && $objForm->HasValue("o_Id_Tipo_Extraccion") && $this->Id_Tipo_Extraccion->CurrentValue <> $this->Id_Tipo_Extraccion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Estado_Paquete") && $objForm->HasValue("o_Id_Estado_Paquete") && $this->Id_Estado_Paquete->CurrentValue <> $this->Id_Estado_Paquete->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Tipo_Paquete") && $objForm->HasValue("o_Id_Tipo_Paquete") && $this->Id_Tipo_Paquete->CurrentValue <> $this->Id_Tipo_Paquete->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Apellido_Nombre_Solicitante") && $objForm->HasValue("o_Apellido_Nombre_Solicitante") && $this->Apellido_Nombre_Solicitante->CurrentValue <> $this->Apellido_Nombre_Solicitante->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Dni") && $objForm->HasValue("o_Dni") && $this->Dni->CurrentValue <> $this->Dni->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Email_Solicitante") && $objForm->HasValue("o_Email_Solicitante") && $this->Email_Solicitante->CurrentValue <> $this->Email_Solicitante->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpaquetes_provisionlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->NroPedido->AdvancedSearch->ToJSON(), ","); // Field NroPedido
		$sFilterList = ew_Concat($sFilterList, $this->Serie_Netbook->AdvancedSearch->ToJSON(), ","); // Field Serie_Netbook
		$sFilterList = ew_Concat($sFilterList, $this->Id_Hardware->AdvancedSearch->ToJSON(), ","); // Field Id_Hardware
		$sFilterList = ew_Concat($sFilterList, $this->SN->AdvancedSearch->ToJSON(), ","); // Field SN
		$sFilterList = ew_Concat($sFilterList, $this->Marca_Arranque->AdvancedSearch->ToJSON(), ","); // Field Marca_Arranque
		$sFilterList = ew_Concat($sFilterList, $this->Serie_Server->AdvancedSearch->ToJSON(), ","); // Field Serie_Server
		$sFilterList = ew_Concat($sFilterList, $this->Id_Motivo->AdvancedSearch->ToJSON(), ","); // Field Id_Motivo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Extraccion->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Extraccion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Paquete->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Paquete
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Paquete->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Paquete
		$sFilterList = ew_Concat($sFilterList, $this->Apellido_Nombre_Solicitante->AdvancedSearch->ToJSON(), ","); // Field Apellido_Nombre_Solicitante
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
		$sFilterList = ew_Concat($sFilterList, $this->Email_Solicitante->AdvancedSearch->ToJSON(), ","); // Field Email_Solicitante
		$sFilterList = ew_Concat($sFilterList, $this->Usuario->AdvancedSearch->ToJSON(), ","); // Field Usuario
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Actualizacion->AdvancedSearch->ToJSON(), ","); // Field Fecha_Actualizacion
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpaquetes_provisionlistsrch", $filters);
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

		// Field NroPedido
		$this->NroPedido->AdvancedSearch->SearchValue = @$filter["x_NroPedido"];
		$this->NroPedido->AdvancedSearch->SearchOperator = @$filter["z_NroPedido"];
		$this->NroPedido->AdvancedSearch->SearchCondition = @$filter["v_NroPedido"];
		$this->NroPedido->AdvancedSearch->SearchValue2 = @$filter["y_NroPedido"];
		$this->NroPedido->AdvancedSearch->SearchOperator2 = @$filter["w_NroPedido"];
		$this->NroPedido->AdvancedSearch->Save();

		// Field Serie_Netbook
		$this->Serie_Netbook->AdvancedSearch->SearchValue = @$filter["x_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchOperator = @$filter["z_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchCondition = @$filter["v_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchValue2 = @$filter["y_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchOperator2 = @$filter["w_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->Save();

		// Field Id_Hardware
		$this->Id_Hardware->AdvancedSearch->SearchValue = @$filter["x_Id_Hardware"];
		$this->Id_Hardware->AdvancedSearch->SearchOperator = @$filter["z_Id_Hardware"];
		$this->Id_Hardware->AdvancedSearch->SearchCondition = @$filter["v_Id_Hardware"];
		$this->Id_Hardware->AdvancedSearch->SearchValue2 = @$filter["y_Id_Hardware"];
		$this->Id_Hardware->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Hardware"];
		$this->Id_Hardware->AdvancedSearch->Save();

		// Field SN
		$this->SN->AdvancedSearch->SearchValue = @$filter["x_SN"];
		$this->SN->AdvancedSearch->SearchOperator = @$filter["z_SN"];
		$this->SN->AdvancedSearch->SearchCondition = @$filter["v_SN"];
		$this->SN->AdvancedSearch->SearchValue2 = @$filter["y_SN"];
		$this->SN->AdvancedSearch->SearchOperator2 = @$filter["w_SN"];
		$this->SN->AdvancedSearch->Save();

		// Field Marca_Arranque
		$this->Marca_Arranque->AdvancedSearch->SearchValue = @$filter["x_Marca_Arranque"];
		$this->Marca_Arranque->AdvancedSearch->SearchOperator = @$filter["z_Marca_Arranque"];
		$this->Marca_Arranque->AdvancedSearch->SearchCondition = @$filter["v_Marca_Arranque"];
		$this->Marca_Arranque->AdvancedSearch->SearchValue2 = @$filter["y_Marca_Arranque"];
		$this->Marca_Arranque->AdvancedSearch->SearchOperator2 = @$filter["w_Marca_Arranque"];
		$this->Marca_Arranque->AdvancedSearch->Save();

		// Field Serie_Server
		$this->Serie_Server->AdvancedSearch->SearchValue = @$filter["x_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchOperator = @$filter["z_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchCondition = @$filter["v_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchValue2 = @$filter["y_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchOperator2 = @$filter["w_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->Save();

		// Field Id_Motivo
		$this->Id_Motivo->AdvancedSearch->SearchValue = @$filter["x_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchOperator = @$filter["z_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchCondition = @$filter["v_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->Save();

		// Field Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Extraccion"];
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Extraccion"];
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Extraccion"];
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Extraccion"];
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Extraccion"];
		$this->Id_Tipo_Extraccion->AdvancedSearch->Save();

		// Field Id_Estado_Paquete
		$this->Id_Estado_Paquete->AdvancedSearch->SearchValue = @$filter["x_Id_Estado_Paquete"];
		$this->Id_Estado_Paquete->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado_Paquete"];
		$this->Id_Estado_Paquete->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado_Paquete"];
		$this->Id_Estado_Paquete->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado_Paquete"];
		$this->Id_Estado_Paquete->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado_Paquete"];
		$this->Id_Estado_Paquete->AdvancedSearch->Save();

		// Field Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->Save();

		// Field Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue = @$filter["x_Apellido_Nombre_Solicitante"];
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchOperator = @$filter["z_Apellido_Nombre_Solicitante"];
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchCondition = @$filter["v_Apellido_Nombre_Solicitante"];
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue2 = @$filter["y_Apellido_Nombre_Solicitante"];
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_Apellido_Nombre_Solicitante"];
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->Save();

		// Field Dni
		$this->Dni->AdvancedSearch->SearchValue = @$filter["x_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator = @$filter["z_Dni"];
		$this->Dni->AdvancedSearch->SearchCondition = @$filter["v_Dni"];
		$this->Dni->AdvancedSearch->SearchValue2 = @$filter["y_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator2 = @$filter["w_Dni"];
		$this->Dni->AdvancedSearch->Save();

		// Field Email_Solicitante
		$this->Email_Solicitante->AdvancedSearch->SearchValue = @$filter["x_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchOperator = @$filter["z_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchCondition = @$filter["v_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchValue2 = @$filter["y_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->Save();

		// Field Usuario
		$this->Usuario->AdvancedSearch->SearchValue = @$filter["x_Usuario"];
		$this->Usuario->AdvancedSearch->SearchOperator = @$filter["z_Usuario"];
		$this->Usuario->AdvancedSearch->SearchCondition = @$filter["v_Usuario"];
		$this->Usuario->AdvancedSearch->SearchValue2 = @$filter["y_Usuario"];
		$this->Usuario->AdvancedSearch->SearchOperator2 = @$filter["w_Usuario"];
		$this->Usuario->AdvancedSearch->Save();

		// Field Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = @$filter["x_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Actualizacion"];
		$this->Fecha_Actualizacion->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->NroPedido, $Default, FALSE); // NroPedido
		$this->BuildSearchSql($sWhere, $this->Serie_Netbook, $Default, FALSE); // Serie_Netbook
		$this->BuildSearchSql($sWhere, $this->Id_Hardware, $Default, FALSE); // Id_Hardware
		$this->BuildSearchSql($sWhere, $this->SN, $Default, FALSE); // SN
		$this->BuildSearchSql($sWhere, $this->Marca_Arranque, $Default, FALSE); // Marca_Arranque
		$this->BuildSearchSql($sWhere, $this->Serie_Server, $Default, FALSE); // Serie_Server
		$this->BuildSearchSql($sWhere, $this->Id_Motivo, $Default, FALSE); // Id_Motivo
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Extraccion, $Default, FALSE); // Id_Tipo_Extraccion
		$this->BuildSearchSql($sWhere, $this->Id_Estado_Paquete, $Default, FALSE); // Id_Estado_Paquete
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Paquete, $Default, FALSE); // Id_Tipo_Paquete
		$this->BuildSearchSql($sWhere, $this->Apellido_Nombre_Solicitante, $Default, FALSE); // Apellido_Nombre_Solicitante
		$this->BuildSearchSql($sWhere, $this->Dni, $Default, FALSE); // Dni
		$this->BuildSearchSql($sWhere, $this->Email_Solicitante, $Default, FALSE); // Email_Solicitante
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->NroPedido->AdvancedSearch->Save(); // NroPedido
			$this->Serie_Netbook->AdvancedSearch->Save(); // Serie_Netbook
			$this->Id_Hardware->AdvancedSearch->Save(); // Id_Hardware
			$this->SN->AdvancedSearch->Save(); // SN
			$this->Marca_Arranque->AdvancedSearch->Save(); // Marca_Arranque
			$this->Serie_Server->AdvancedSearch->Save(); // Serie_Server
			$this->Id_Motivo->AdvancedSearch->Save(); // Id_Motivo
			$this->Id_Tipo_Extraccion->AdvancedSearch->Save(); // Id_Tipo_Extraccion
			$this->Id_Estado_Paquete->AdvancedSearch->Save(); // Id_Estado_Paquete
			$this->Id_Tipo_Paquete->AdvancedSearch->Save(); // Id_Tipo_Paquete
			$this->Apellido_Nombre_Solicitante->AdvancedSearch->Save(); // Apellido_Nombre_Solicitante
			$this->Dni->AdvancedSearch->Save(); // Dni
			$this->Email_Solicitante->AdvancedSearch->Save(); // Email_Solicitante
			$this->Usuario->AdvancedSearch->Save(); // Usuario
			$this->Fecha_Actualizacion->AdvancedSearch->Save(); // Fecha_Actualizacion
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
		$this->BuildBasicSearchSQL($sWhere, $this->NroPedido, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Serie_Netbook, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Hardware, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Marca_Arranque, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Serie_Server, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Apellido_Nombre_Solicitante, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Email_Solicitante, $arKeywords, $type);
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
		if ($this->NroPedido->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Serie_Netbook->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Hardware->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->SN->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Marca_Arranque->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Serie_Server->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Motivo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Extraccion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado_Paquete->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Paquete->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Apellido_Nombre_Solicitante->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Email_Solicitante->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Usuario->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Actualizacion->AdvancedSearch->IssetSession())
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
		$this->NroPedido->AdvancedSearch->UnsetSession();
		$this->Serie_Netbook->AdvancedSearch->UnsetSession();
		$this->Id_Hardware->AdvancedSearch->UnsetSession();
		$this->SN->AdvancedSearch->UnsetSession();
		$this->Marca_Arranque->AdvancedSearch->UnsetSession();
		$this->Serie_Server->AdvancedSearch->UnsetSession();
		$this->Id_Motivo->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Extraccion->AdvancedSearch->UnsetSession();
		$this->Id_Estado_Paquete->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Paquete->AdvancedSearch->UnsetSession();
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->UnsetSession();
		$this->Dni->AdvancedSearch->UnsetSession();
		$this->Email_Solicitante->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->NroPedido->AdvancedSearch->Load();
		$this->Serie_Netbook->AdvancedSearch->Load();
		$this->Id_Hardware->AdvancedSearch->Load();
		$this->SN->AdvancedSearch->Load();
		$this->Marca_Arranque->AdvancedSearch->Load();
		$this->Serie_Server->AdvancedSearch->Load();
		$this->Id_Motivo->AdvancedSearch->Load();
		$this->Id_Tipo_Extraccion->AdvancedSearch->Load();
		$this->Id_Estado_Paquete->AdvancedSearch->Load();
		$this->Id_Tipo_Paquete->AdvancedSearch->Load();
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Email_Solicitante->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Serie_Netbook); // Serie_Netbook
			$this->UpdateSort($this->Id_Hardware); // Id_Hardware
			$this->UpdateSort($this->SN); // SN
			$this->UpdateSort($this->Marca_Arranque); // Marca_Arranque
			$this->UpdateSort($this->Serie_Server); // Serie_Server
			$this->UpdateSort($this->Id_Motivo); // Id_Motivo
			$this->UpdateSort($this->Id_Tipo_Extraccion); // Id_Tipo_Extraccion
			$this->UpdateSort($this->Id_Estado_Paquete); // Id_Estado_Paquete
			$this->UpdateSort($this->Id_Tipo_Paquete); // Id_Tipo_Paquete
			$this->UpdateSort($this->Apellido_Nombre_Solicitante); // Apellido_Nombre_Solicitante
			$this->UpdateSort($this->Dni); // Dni
			$this->UpdateSort($this->Email_Solicitante); // Email_Solicitante
			$this->UpdateSort($this->Usuario); // Usuario
			$this->UpdateSort($this->Fecha_Actualizacion); // Fecha_Actualizacion
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
				$this->Serie_Netbook->setSort("");
				$this->Id_Hardware->setSort("");
				$this->SN->setSort("");
				$this->Marca_Arranque->setSort("");
				$this->Serie_Server->setSort("");
				$this->Id_Motivo->setSort("");
				$this->Id_Tipo_Extraccion->setSort("");
				$this->Id_Estado_Paquete->setSort("");
				$this->Id_Tipo_Paquete->setSort("");
				$this->Apellido_Nombre_Solicitante->setSort("");
				$this->Dni->setSort("");
				$this->Email_Solicitante->setSort("");
				$this->Usuario->setSort("");
				$this->Fecha_Actualizacion->setSort("");
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
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
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
		$item->Visible = ($Security->CanDelete() || $Security->CanEdit());
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->NroPedido->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"paquetes_provision\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"paquetes_provision\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->NroPedido->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->NroPedido->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fpaquetes_provisionlist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"paquetes_provision\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fpaquetes_provisionlist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpaquetes_provisionlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpaquetes_provisionlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpaquetes_provisionlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpaquetes_provisionlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"paquetes_provisionsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Serie_Netbook->CurrentValue = NULL;
		$this->Serie_Netbook->OldValue = $this->Serie_Netbook->CurrentValue;
		$this->Id_Hardware->CurrentValue = NULL;
		$this->Id_Hardware->OldValue = $this->Id_Hardware->CurrentValue;
		$this->SN->CurrentValue = 'EE183CE07CFBD86BF819';
		$this->SN->OldValue = $this->SN->CurrentValue;
		$this->Marca_Arranque->CurrentValue = NULL;
		$this->Marca_Arranque->OldValue = $this->Marca_Arranque->CurrentValue;
		$this->Serie_Server->CurrentValue = NULL;
		$this->Serie_Server->OldValue = $this->Serie_Server->CurrentValue;
		$this->Id_Motivo->CurrentValue = 1;
		$this->Id_Motivo->OldValue = $this->Id_Motivo->CurrentValue;
		$this->Id_Tipo_Extraccion->CurrentValue = 1;
		$this->Id_Tipo_Extraccion->OldValue = $this->Id_Tipo_Extraccion->CurrentValue;
		$this->Id_Estado_Paquete->CurrentValue = 1;
		$this->Id_Estado_Paquete->OldValue = $this->Id_Estado_Paquete->CurrentValue;
		$this->Id_Tipo_Paquete->CurrentValue = 1;
		$this->Id_Tipo_Paquete->OldValue = $this->Id_Tipo_Paquete->CurrentValue;
		$this->Apellido_Nombre_Solicitante->CurrentValue = NULL;
		$this->Apellido_Nombre_Solicitante->OldValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->Email_Solicitante->CurrentValue = "PENDIENTE";
		$this->Email_Solicitante->OldValue = $this->Email_Solicitante->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
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
		// NroPedido

		$this->NroPedido->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroPedido"]);
		if ($this->NroPedido->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroPedido->AdvancedSearch->SearchOperator = @$_GET["z_NroPedido"];

		// Serie_Netbook
		$this->Serie_Netbook->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Serie_Netbook"]);
		if ($this->Serie_Netbook->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Serie_Netbook->AdvancedSearch->SearchOperator = @$_GET["z_Serie_Netbook"];

		// Id_Hardware
		$this->Id_Hardware->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Hardware"]);
		if ($this->Id_Hardware->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Hardware->AdvancedSearch->SearchOperator = @$_GET["z_Id_Hardware"];

		// SN
		$this->SN->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_SN"]);
		if ($this->SN->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->SN->AdvancedSearch->SearchOperator = @$_GET["z_SN"];

		// Marca_Arranque
		$this->Marca_Arranque->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Marca_Arranque"]);
		if ($this->Marca_Arranque->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Marca_Arranque->AdvancedSearch->SearchOperator = @$_GET["z_Marca_Arranque"];

		// Serie_Server
		$this->Serie_Server->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Serie_Server"]);
		if ($this->Serie_Server->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Serie_Server->AdvancedSearch->SearchOperator = @$_GET["z_Serie_Server"];

		// Id_Motivo
		$this->Id_Motivo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Motivo"]);
		if ($this->Id_Motivo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Motivo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Motivo"];

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Extraccion"]);
		if ($this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Extraccion"];

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado_Paquete"]);
		if ($this->Id_Estado_Paquete->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado_Paquete->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado_Paquete"];

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Paquete"]);
		if ($this->Id_Tipo_Paquete->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Paquete"];

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellido_Nombre_Solicitante"]);
		if ($this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchOperator = @$_GET["z_Apellido_Nombre_Solicitante"];

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni"]);
		if ($this->Dni->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni->AdvancedSearch->SearchOperator = @$_GET["z_Dni"];

		// Email_Solicitante
		$this->Email_Solicitante->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Email_Solicitante"]);
		if ($this->Email_Solicitante->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Email_Solicitante->AdvancedSearch->SearchOperator = @$_GET["z_Email_Solicitante"];

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Usuario"]);
		if ($this->Usuario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Usuario->AdvancedSearch->SearchOperator = @$_GET["z_Usuario"];

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Actualizacion"]);
		if ($this->Fecha_Actualizacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Actualizacion"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Serie_Netbook->FldIsDetailKey) {
			$this->Serie_Netbook->setFormValue($objForm->GetValue("x_Serie_Netbook"));
		}
		$this->Serie_Netbook->setOldValue($objForm->GetValue("o_Serie_Netbook"));
		if (!$this->Id_Hardware->FldIsDetailKey) {
			$this->Id_Hardware->setFormValue($objForm->GetValue("x_Id_Hardware"));
		}
		$this->Id_Hardware->setOldValue($objForm->GetValue("o_Id_Hardware"));
		if (!$this->SN->FldIsDetailKey) {
			$this->SN->setFormValue($objForm->GetValue("x_SN"));
		}
		$this->SN->setOldValue($objForm->GetValue("o_SN"));
		if (!$this->Marca_Arranque->FldIsDetailKey) {
			$this->Marca_Arranque->setFormValue($objForm->GetValue("x_Marca_Arranque"));
		}
		$this->Marca_Arranque->setOldValue($objForm->GetValue("o_Marca_Arranque"));
		if (!$this->Serie_Server->FldIsDetailKey) {
			$this->Serie_Server->setFormValue($objForm->GetValue("x_Serie_Server"));
		}
		$this->Serie_Server->setOldValue($objForm->GetValue("o_Serie_Server"));
		if (!$this->Id_Motivo->FldIsDetailKey) {
			$this->Id_Motivo->setFormValue($objForm->GetValue("x_Id_Motivo"));
		}
		$this->Id_Motivo->setOldValue($objForm->GetValue("o_Id_Motivo"));
		if (!$this->Id_Tipo_Extraccion->FldIsDetailKey) {
			$this->Id_Tipo_Extraccion->setFormValue($objForm->GetValue("x_Id_Tipo_Extraccion"));
		}
		$this->Id_Tipo_Extraccion->setOldValue($objForm->GetValue("o_Id_Tipo_Extraccion"));
		if (!$this->Id_Estado_Paquete->FldIsDetailKey) {
			$this->Id_Estado_Paquete->setFormValue($objForm->GetValue("x_Id_Estado_Paquete"));
		}
		$this->Id_Estado_Paquete->setOldValue($objForm->GetValue("o_Id_Estado_Paquete"));
		if (!$this->Id_Tipo_Paquete->FldIsDetailKey) {
			$this->Id_Tipo_Paquete->setFormValue($objForm->GetValue("x_Id_Tipo_Paquete"));
		}
		$this->Id_Tipo_Paquete->setOldValue($objForm->GetValue("o_Id_Tipo_Paquete"));
		if (!$this->Apellido_Nombre_Solicitante->FldIsDetailKey) {
			$this->Apellido_Nombre_Solicitante->setFormValue($objForm->GetValue("x_Apellido_Nombre_Solicitante"));
		}
		$this->Apellido_Nombre_Solicitante->setOldValue($objForm->GetValue("o_Apellido_Nombre_Solicitante"));
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->setOldValue($objForm->GetValue("o_Dni"));
		if (!$this->Email_Solicitante->FldIsDetailKey) {
			$this->Email_Solicitante->setFormValue($objForm->GetValue("x_Email_Solicitante"));
		}
		$this->Email_Solicitante->setOldValue($objForm->GetValue("o_Email_Solicitante"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->setOldValue($objForm->GetValue("o_Fecha_Actualizacion"));
		if (!$this->NroPedido->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->NroPedido->setFormValue($objForm->GetValue("x_NroPedido"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->NroPedido->CurrentValue = $this->NroPedido->FormValue;
		$this->Serie_Netbook->CurrentValue = $this->Serie_Netbook->FormValue;
		$this->Id_Hardware->CurrentValue = $this->Id_Hardware->FormValue;
		$this->SN->CurrentValue = $this->SN->FormValue;
		$this->Marca_Arranque->CurrentValue = $this->Marca_Arranque->FormValue;
		$this->Serie_Server->CurrentValue = $this->Serie_Server->FormValue;
		$this->Id_Motivo->CurrentValue = $this->Id_Motivo->FormValue;
		$this->Id_Tipo_Extraccion->CurrentValue = $this->Id_Tipo_Extraccion->FormValue;
		$this->Id_Estado_Paquete->CurrentValue = $this->Id_Estado_Paquete->FormValue;
		$this->Id_Tipo_Paquete->CurrentValue = $this->Id_Tipo_Paquete->FormValue;
		$this->Apellido_Nombre_Solicitante->CurrentValue = $this->Apellido_Nombre_Solicitante->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Email_Solicitante->CurrentValue = $this->Email_Solicitante->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->NroPedido->setDbValue($rs->fields('NroPedido'));
		$this->Serie_Netbook->setDbValue($rs->fields('Serie_Netbook'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Serie_Server->setDbValue($rs->fields('Serie_Server'));
		$this->Id_Motivo->setDbValue($rs->fields('Id_Motivo'));
		$this->Id_Tipo_Extraccion->setDbValue($rs->fields('Id_Tipo_Extraccion'));
		$this->Id_Estado_Paquete->setDbValue($rs->fields('Id_Estado_Paquete'));
		$this->Id_Tipo_Paquete->setDbValue($rs->fields('Id_Tipo_Paquete'));
		$this->Apellido_Nombre_Solicitante->setDbValue($rs->fields('Apellido_Nombre_Solicitante'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Email_Solicitante->setDbValue($rs->fields('Email_Solicitante'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroPedido->DbValue = $row['NroPedido'];
		$this->Serie_Netbook->DbValue = $row['Serie_Netbook'];
		$this->Id_Hardware->DbValue = $row['Id_Hardware'];
		$this->SN->DbValue = $row['SN'];
		$this->Marca_Arranque->DbValue = $row['Marca_Arranque'];
		$this->Serie_Server->DbValue = $row['Serie_Server'];
		$this->Id_Motivo->DbValue = $row['Id_Motivo'];
		$this->Id_Tipo_Extraccion->DbValue = $row['Id_Tipo_Extraccion'];
		$this->Id_Estado_Paquete->DbValue = $row['Id_Estado_Paquete'];
		$this->Id_Tipo_Paquete->DbValue = $row['Id_Tipo_Paquete'];
		$this->Apellido_Nombre_Solicitante->DbValue = $row['Apellido_Nombre_Solicitante'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Email_Solicitante->DbValue = $row['Email_Solicitante'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("NroPedido")) <> "")
			$this->NroPedido->CurrentValue = $this->getKey("NroPedido"); // NroPedido
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
		// NroPedido
		// Serie_Netbook
		// Id_Hardware
		// SN
		// Marca_Arranque
		// Serie_Server
		// Id_Motivo
		// Id_Tipo_Extraccion
		// Id_Estado_Paquete
		// Id_Tipo_Paquete
		// Apellido_Nombre_Solicitante
		// Dni
		// Email_Solicitante
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroPedido
		$this->NroPedido->ViewValue = $this->NroPedido->CurrentValue;
		$this->NroPedido->ViewCustomAttributes = "";

		// Serie_Netbook
		$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
		if (strval($this->Serie_Netbook->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
			}
		} else {
			$this->Serie_Netbook->ViewValue = NULL;
		}
		$this->Serie_Netbook->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		if (strval($this->Id_Hardware->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Id_Hardware->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
			}
		} else {
			$this->Id_Hardware->ViewValue = NULL;
		}
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Serie_Server
		$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
		if (strval($this->Serie_Server->CurrentValue) <> "") {
			$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
		$sWhereWrk = "";
		$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Server->ViewValue = $this->Serie_Server->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
			}
		} else {
			$this->Serie_Server->ViewValue = NULL;
		}
		$this->Serie_Server->ViewCustomAttributes = "";

		// Id_Motivo
		if (strval($this->Id_Motivo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Id_Motivo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->CurrentValue;
			}
		} else {
			$this->Id_Motivo->ViewValue = NULL;
		}
		$this->Id_Motivo->ViewCustomAttributes = "";

		// Id_Tipo_Extraccion
		if (strval($this->Id_Tipo_Extraccion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->Id_Tipo_Extraccion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Extraccion->ViewValue = NULL;
		}
		$this->Id_Tipo_Extraccion->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		if (strval($this->Id_Estado_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
		$sWhereWrk = "";
		$this->Id_Estado_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Estado_Paquete->ViewValue = NULL;
		}
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// Id_Tipo_Paquete
		if (strval($this->Id_Tipo_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
		$sWhereWrk = "";
		$this->Id_Tipo_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Paquete->ViewValue = NULL;
		}
		$this->Id_Tipo_Paquete->ViewCustomAttributes = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
			$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
		$sWhereWrk = "";
		$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
			}
		} else {
			$this->Apellido_Nombre_Solicitante->ViewValue = NULL;
		}
		$this->Apellido_Nombre_Solicitante->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Email_Solicitante
		$this->Email_Solicitante->ViewValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Serie_Netbook
			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";
			$this->Serie_Netbook->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";
			$this->Marca_Arranque->TooltipValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";
			$this->Serie_Server->TooltipValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";
			$this->Id_Motivo->TooltipValue = "";

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";
			$this->Id_Tipo_Extraccion->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";
			$this->Id_Tipo_Paquete->TooltipValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";
			$this->Apellido_Nombre_Solicitante->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";
			$this->Email_Solicitante->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Serie_Netbook
			$this->Serie_Netbook->EditAttrs["class"] = "form-control";
			$this->Serie_Netbook->EditCustomAttributes = "";
			$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->CurrentValue);
			if (strval($this->Serie_Netbook->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Netbook->EditValue = $this->Serie_Netbook->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->CurrentValue);
				}
			} else {
				$this->Serie_Netbook->EditValue = NULL;
			}
			$this->Serie_Netbook->PlaceHolder = ew_RemoveHtml($this->Serie_Netbook->FldCaption());

			// Id_Hardware
			$this->Id_Hardware->EditAttrs["class"] = "form-control";
			$this->Id_Hardware->EditCustomAttributes = "";
			$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->CurrentValue);
			if (strval($this->Id_Hardware->CurrentValue) <> "") {
				$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Id_Hardware->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Id_Hardware->EditValue = $this->Id_Hardware->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->CurrentValue);
				}
			} else {
				$this->Id_Hardware->EditValue = NULL;
			}
			$this->Id_Hardware->PlaceHolder = ew_RemoveHtml($this->Id_Hardware->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->CurrentValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Marca_Arranque
			$this->Marca_Arranque->EditAttrs["class"] = "form-control";
			$this->Marca_Arranque->EditCustomAttributes = "";
			$this->Marca_Arranque->EditValue = ew_HtmlEncode($this->Marca_Arranque->CurrentValue);
			$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

			// Serie_Server
			$this->Serie_Server->EditAttrs["class"] = "form-control";
			$this->Serie_Server->EditCustomAttributes = "";
			$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->CurrentValue);
			if (strval($this->Serie_Server->CurrentValue) <> "") {
				$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
			$sWhereWrk = "";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Server->EditValue = $this->Serie_Server->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->CurrentValue);
				}
			} else {
				$this->Serie_Server->EditValue = NULL;
			}
			$this->Serie_Server->PlaceHolder = ew_RemoveHtml($this->Serie_Server->FldCaption());

			// Id_Motivo
			$this->Id_Motivo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo->EditValue = $arwrk;

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Extraccion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Extraccion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->Id_Tipo_Extraccion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Extraccion->EditValue = $arwrk;

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Paquete->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Paquete->EditValue = $arwrk;

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Paquete->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_paquete`";
			$sWhereWrk = "";
			$this->Id_Tipo_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Paquete->EditValue = $arwrk;

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre_Solicitante->EditCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->CurrentValue);
			if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
				$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Apellido_Nombre_Solicitante->EditValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->CurrentValue);
				}
			} else {
				$this->Apellido_Nombre_Solicitante->EditValue = NULL;
			}
			$this->Apellido_Nombre_Solicitante->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre_Solicitante->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Email_Solicitante
			$this->Email_Solicitante->EditAttrs["class"] = "form-control";
			$this->Email_Solicitante->EditCustomAttributes = "";
			$this->Email_Solicitante->EditValue = ew_HtmlEncode($this->Email_Solicitante->CurrentValue);
			$this->Email_Solicitante->PlaceHolder = ew_RemoveHtml($this->Email_Solicitante->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Serie_Netbook

			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Serie_Netbook
			$this->Serie_Netbook->EditAttrs["class"] = "form-control";
			$this->Serie_Netbook->EditCustomAttributes = "";
			$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->CurrentValue);
			if (strval($this->Serie_Netbook->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Netbook->EditValue = $this->Serie_Netbook->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->CurrentValue);
				}
			} else {
				$this->Serie_Netbook->EditValue = NULL;
			}
			$this->Serie_Netbook->PlaceHolder = ew_RemoveHtml($this->Serie_Netbook->FldCaption());

			// Id_Hardware
			$this->Id_Hardware->EditAttrs["class"] = "form-control";
			$this->Id_Hardware->EditCustomAttributes = "";
			$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->CurrentValue);
			if (strval($this->Id_Hardware->CurrentValue) <> "") {
				$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Id_Hardware->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Id_Hardware->EditValue = $this->Id_Hardware->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->CurrentValue);
				}
			} else {
				$this->Id_Hardware->EditValue = NULL;
			}
			$this->Id_Hardware->PlaceHolder = ew_RemoveHtml($this->Id_Hardware->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->CurrentValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Marca_Arranque
			$this->Marca_Arranque->EditAttrs["class"] = "form-control";
			$this->Marca_Arranque->EditCustomAttributes = "";
			$this->Marca_Arranque->EditValue = ew_HtmlEncode($this->Marca_Arranque->CurrentValue);
			$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

			// Serie_Server
			$this->Serie_Server->EditAttrs["class"] = "form-control";
			$this->Serie_Server->EditCustomAttributes = "";
			$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->CurrentValue);
			if (strval($this->Serie_Server->CurrentValue) <> "") {
				$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
			$sWhereWrk = "";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Server->EditValue = $this->Serie_Server->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->CurrentValue);
				}
			} else {
				$this->Serie_Server->EditValue = NULL;
			}
			$this->Serie_Server->PlaceHolder = ew_RemoveHtml($this->Serie_Server->FldCaption());

			// Id_Motivo
			$this->Id_Motivo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo->EditValue = $arwrk;

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Extraccion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Extraccion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->Id_Tipo_Extraccion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Extraccion->EditValue = $arwrk;

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Paquete->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Paquete->EditValue = $arwrk;

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Paquete->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_paquete`";
			$sWhereWrk = "";
			$this->Id_Tipo_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Paquete->EditValue = $arwrk;

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre_Solicitante->EditCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->CurrentValue);
			if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
				$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Apellido_Nombre_Solicitante->EditValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->CurrentValue);
				}
			} else {
				$this->Apellido_Nombre_Solicitante->EditValue = NULL;
			}
			$this->Apellido_Nombre_Solicitante->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre_Solicitante->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Email_Solicitante
			$this->Email_Solicitante->EditAttrs["class"] = "form-control";
			$this->Email_Solicitante->EditCustomAttributes = "";
			$this->Email_Solicitante->EditValue = ew_HtmlEncode($this->Email_Solicitante->CurrentValue);
			$this->Email_Solicitante->PlaceHolder = ew_RemoveHtml($this->Email_Solicitante->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Serie_Netbook

			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
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
		if (!$this->Serie_Netbook->FldIsDetailKey && !is_null($this->Serie_Netbook->FormValue) && $this->Serie_Netbook->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Serie_Netbook->FldCaption(), $this->Serie_Netbook->ReqErrMsg));
		}
		if (!$this->Id_Hardware->FldIsDetailKey && !is_null($this->Id_Hardware->FormValue) && $this->Id_Hardware->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Hardware->FldCaption(), $this->Id_Hardware->ReqErrMsg));
		}
		if (!$this->SN->FldIsDetailKey && !is_null($this->SN->FormValue) && $this->SN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SN->FldCaption(), $this->SN->ReqErrMsg));
		}
		if (!$this->Marca_Arranque->FldIsDetailKey && !is_null($this->Marca_Arranque->FormValue) && $this->Marca_Arranque->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Marca_Arranque->FldCaption(), $this->Marca_Arranque->ReqErrMsg));
		}
		if (!$this->Serie_Server->FldIsDetailKey && !is_null($this->Serie_Server->FormValue) && $this->Serie_Server->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Serie_Server->FldCaption(), $this->Serie_Server->ReqErrMsg));
		}
		if (!$this->Id_Motivo->FldIsDetailKey && !is_null($this->Id_Motivo->FormValue) && $this->Id_Motivo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo->FldCaption(), $this->Id_Motivo->ReqErrMsg));
		}
		if (!$this->Id_Tipo_Extraccion->FldIsDetailKey && !is_null($this->Id_Tipo_Extraccion->FormValue) && $this->Id_Tipo_Extraccion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Extraccion->FldCaption(), $this->Id_Tipo_Extraccion->ReqErrMsg));
		}
		if (!$this->Id_Estado_Paquete->FldIsDetailKey && !is_null($this->Id_Estado_Paquete->FormValue) && $this->Id_Estado_Paquete->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Paquete->FldCaption(), $this->Id_Estado_Paquete->ReqErrMsg));
		}
		if (!$this->Id_Tipo_Paquete->FldIsDetailKey && !is_null($this->Id_Tipo_Paquete->FormValue) && $this->Id_Tipo_Paquete->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Paquete->FldCaption(), $this->Id_Tipo_Paquete->ReqErrMsg));
		}
		if (!$this->Apellido_Nombre_Solicitante->FldIsDetailKey && !is_null($this->Apellido_Nombre_Solicitante->FormValue) && $this->Apellido_Nombre_Solicitante->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellido_Nombre_Solicitante->FldCaption(), $this->Apellido_Nombre_Solicitante->ReqErrMsg));
		}
		if (!$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
		}
		if (!$this->Email_Solicitante->FldIsDetailKey && !is_null($this->Email_Solicitante->FormValue) && $this->Email_Solicitante->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Email_Solicitante->FldCaption(), $this->Email_Solicitante->ReqErrMsg));
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
				$sThisKey .= $row['NroPedido'];
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

			// Serie_Netbook
			$this->Serie_Netbook->SetDbValueDef($rsnew, $this->Serie_Netbook->CurrentValue, NULL, $this->Serie_Netbook->ReadOnly);

			// Id_Hardware
			$this->Id_Hardware->SetDbValueDef($rsnew, $this->Id_Hardware->CurrentValue, NULL, $this->Id_Hardware->ReadOnly);

			// SN
			$this->SN->SetDbValueDef($rsnew, $this->SN->CurrentValue, NULL, $this->SN->ReadOnly);

			// Marca_Arranque
			$this->Marca_Arranque->SetDbValueDef($rsnew, $this->Marca_Arranque->CurrentValue, NULL, $this->Marca_Arranque->ReadOnly);

			// Serie_Server
			$this->Serie_Server->SetDbValueDef($rsnew, $this->Serie_Server->CurrentValue, "", $this->Serie_Server->ReadOnly);

			// Id_Motivo
			$this->Id_Motivo->SetDbValueDef($rsnew, $this->Id_Motivo->CurrentValue, 0, $this->Id_Motivo->ReadOnly);

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->SetDbValueDef($rsnew, $this->Id_Tipo_Extraccion->CurrentValue, 0, $this->Id_Tipo_Extraccion->ReadOnly);

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->SetDbValueDef($rsnew, $this->Id_Estado_Paquete->CurrentValue, 0, $this->Id_Estado_Paquete->ReadOnly);

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->SetDbValueDef($rsnew, $this->Id_Tipo_Paquete->CurrentValue, NULL, $this->Id_Tipo_Paquete->ReadOnly);

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->SetDbValueDef($rsnew, $this->Apellido_Nombre_Solicitante->CurrentValue, NULL, $this->Apellido_Nombre_Solicitante->ReadOnly);

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, NULL, $this->Dni->ReadOnly);

			// Email_Solicitante
			$this->Email_Solicitante->SetDbValueDef($rsnew, $this->Email_Solicitante->CurrentValue, NULL, $this->Email_Solicitante->ReadOnly);

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

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

		// Serie_Netbook
		$this->Serie_Netbook->SetDbValueDef($rsnew, $this->Serie_Netbook->CurrentValue, NULL, FALSE);

		// Id_Hardware
		$this->Id_Hardware->SetDbValueDef($rsnew, $this->Id_Hardware->CurrentValue, NULL, FALSE);

		// SN
		$this->SN->SetDbValueDef($rsnew, $this->SN->CurrentValue, NULL, FALSE);

		// Marca_Arranque
		$this->Marca_Arranque->SetDbValueDef($rsnew, $this->Marca_Arranque->CurrentValue, NULL, FALSE);

		// Serie_Server
		$this->Serie_Server->SetDbValueDef($rsnew, $this->Serie_Server->CurrentValue, "", FALSE);

		// Id_Motivo
		$this->Id_Motivo->SetDbValueDef($rsnew, $this->Id_Motivo->CurrentValue, 0, FALSE);

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->SetDbValueDef($rsnew, $this->Id_Tipo_Extraccion->CurrentValue, 0, FALSE);

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->SetDbValueDef($rsnew, $this->Id_Estado_Paquete->CurrentValue, 0, FALSE);

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->SetDbValueDef($rsnew, $this->Id_Tipo_Paquete->CurrentValue, NULL, FALSE);

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->SetDbValueDef($rsnew, $this->Apellido_Nombre_Solicitante->CurrentValue, NULL, FALSE);

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, NULL, FALSE);

		// Email_Solicitante
		$this->Email_Solicitante->SetDbValueDef($rsnew, $this->Email_Solicitante->CurrentValue, NULL, strval($this->Email_Solicitante->CurrentValue) == "");

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->NroPedido->setDbValue($conn->Insert_ID());
				$rsnew['NroPedido'] = $this->NroPedido->DbValue;
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
		$this->NroPedido->AdvancedSearch->Load();
		$this->Serie_Netbook->AdvancedSearch->Load();
		$this->Id_Hardware->AdvancedSearch->Load();
		$this->SN->AdvancedSearch->Load();
		$this->Marca_Arranque->AdvancedSearch->Load();
		$this->Serie_Server->AdvancedSearch->Load();
		$this->Id_Motivo->AdvancedSearch->Load();
		$this->Id_Tipo_Extraccion->AdvancedSearch->Load();
		$this->Id_Estado_Paquete->AdvancedSearch->Load();
		$this->Id_Tipo_Paquete->AdvancedSearch->Load();
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Email_Solicitante->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_paquetes_provision\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_paquetes_provision',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpaquetes_provisionlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Serie_Netbook":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Hardware":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac` AS `LinkFld`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Id_Hardware->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroMac` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Serie_Server":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nro_Serie` AS `LinkFld`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
			$sWhereWrk = "{filter}";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nro_Serie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Extraccion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Extraccion` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->Id_Tipo_Extraccion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Extraccion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Paquete":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Paquete` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Paquete` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Paquete":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Paquete` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
			$sWhereWrk = "";
			$this->Id_Tipo_Paquete->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Paquete` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Apellido_Nombre_Solicitante":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellido_Nombre` AS `LinkFld`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "{filter}";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellido_Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
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
		case "x_Serie_Netbook":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Hardware":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroMac` LIKE '{query_value}%'";
			$this->Id_Hardware->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Serie_Server":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld` FROM `servidor_escolar`";
			$sWhereWrk = "`Nro_Serie` LIKE '{query_value}%'";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Apellido_Nombre_Solicitante":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld` FROM `referente_tecnico`";
			$sWhereWrk = "`Apellido_Nombre` LIKE '{query_value}%'";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'paquetes_provision';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'paquetes_provision';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroPedido'];

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
		$table = 'paquetes_provision';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NroPedido'];

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
		$table = 'paquetes_provision';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroPedido'];

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
if (!isset($paquetes_provision_list)) $paquetes_provision_list = new cpaquetes_provision_list();

// Page init
$paquetes_provision_list->Page_Init();

// Page main
$paquetes_provision_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$paquetes_provision_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($paquetes_provision->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpaquetes_provisionlist = new ew_Form("fpaquetes_provisionlist", "list");
fpaquetes_provisionlist.FormKeyCountName = '<?php echo $paquetes_provision_list->FormKeyCountName ?>';

// Validate form
fpaquetes_provisionlist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Serie_Netbook");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Serie_Netbook->FldCaption(), $paquetes_provision->Serie_Netbook->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Hardware");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Hardware->FldCaption(), $paquetes_provision->Id_Hardware->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->SN->FldCaption(), $paquetes_provision->SN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Marca_Arranque");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Marca_Arranque->FldCaption(), $paquetes_provision->Marca_Arranque->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Serie_Server");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Serie_Server->FldCaption(), $paquetes_provision->Serie_Server->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Motivo->FldCaption(), $paquetes_provision->Id_Motivo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Extraccion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Tipo_Extraccion->FldCaption(), $paquetes_provision->Id_Tipo_Extraccion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Paquete");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Estado_Paquete->FldCaption(), $paquetes_provision->Id_Estado_Paquete->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Paquete");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Id_Tipo_Paquete->FldCaption(), $paquetes_provision->Id_Tipo_Paquete->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Apellido_Nombre_Solicitante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Apellido_Nombre_Solicitante->FldCaption(), $paquetes_provision->Apellido_Nombre_Solicitante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Dni->FldCaption(), $paquetes_provision->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($paquetes_provision->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Email_Solicitante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $paquetes_provision->Email_Solicitante->FldCaption(), $paquetes_provision->Email_Solicitante->ReqErrMsg)) ?>");

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
fpaquetes_provisionlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Serie_Netbook", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Hardware", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SN", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Marca_Arranque", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Serie_Server", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Motivo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Extraccion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado_Paquete", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Paquete", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Apellido_Nombre_Solicitante", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Dni", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Email_Solicitante", false)) return false;
	return true;
}

// Form_CustomValidate event
fpaquetes_provisionlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpaquetes_provisionlist.ValidateRequired = true;
<?php } else { ?>
fpaquetes_provisionlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpaquetes_provisionlist.Lists["x_Serie_Netbook"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":true,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisionlist.Lists["x_Id_Hardware"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisionlist.Lists["x_Serie_Server"] = {"LinkField":"x_Nro_Serie","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nro_Serie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"servidor_escolar"};
fpaquetes_provisionlist.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpaquetes_provisionlist.Lists["x_Id_Tipo_Extraccion"] = {"LinkField":"x_Id_Tipo_Extraccion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpaquetes_provisionlist.Lists["x_Id_Estado_Paquete"] = {"LinkField":"x_Id_Estado_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_paquete"};
fpaquetes_provisionlist.Lists["x_Id_Tipo_Paquete"] = {"LinkField":"x_Id_Tipo_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_paquete"};
fpaquetes_provisionlist.Lists["x_Apellido_Nombre_Solicitante"] = {"LinkField":"x_Apellido_Nombre","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"referente_tecnico"};

// Form object for search
var CurrentSearchForm = fpaquetes_provisionlistsrch = new ew_Form("fpaquetes_provisionlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($paquetes_provision->Export == "") { ?>
<div class="ewToolbar">
<?php if ($paquetes_provision->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($paquetes_provision_list->TotalRecs > 0 && $paquetes_provision_list->ExportOptions->Visible()) { ?>
<?php $paquetes_provision_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($paquetes_provision_list->SearchOptions->Visible()) { ?>
<?php $paquetes_provision_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($paquetes_provision_list->FilterOptions->Visible()) { ?>
<?php $paquetes_provision_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($paquetes_provision->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($paquetes_provision->CurrentAction == "gridadd") {
	$paquetes_provision->CurrentFilter = "0=1";
	$paquetes_provision_list->StartRec = 1;
	$paquetes_provision_list->DisplayRecs = $paquetes_provision->GridAddRowCount;
	$paquetes_provision_list->TotalRecs = $paquetes_provision_list->DisplayRecs;
	$paquetes_provision_list->StopRec = $paquetes_provision_list->DisplayRecs;
} else {
	$bSelectLimit = $paquetes_provision_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($paquetes_provision_list->TotalRecs <= 0)
			$paquetes_provision_list->TotalRecs = $paquetes_provision->SelectRecordCount();
	} else {
		if (!$paquetes_provision_list->Recordset && ($paquetes_provision_list->Recordset = $paquetes_provision_list->LoadRecordset()))
			$paquetes_provision_list->TotalRecs = $paquetes_provision_list->Recordset->RecordCount();
	}
	$paquetes_provision_list->StartRec = 1;
	if ($paquetes_provision_list->DisplayRecs <= 0 || ($paquetes_provision->Export <> "" && $paquetes_provision->ExportAll)) // Display all records
		$paquetes_provision_list->DisplayRecs = $paquetes_provision_list->TotalRecs;
	if (!($paquetes_provision->Export <> "" && $paquetes_provision->ExportAll))
		$paquetes_provision_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$paquetes_provision_list->Recordset = $paquetes_provision_list->LoadRecordset($paquetes_provision_list->StartRec-1, $paquetes_provision_list->DisplayRecs);

	// Set no record found message
	if ($paquetes_provision->CurrentAction == "" && $paquetes_provision_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$paquetes_provision_list->setWarningMessage(ew_DeniedMsg());
		if ($paquetes_provision_list->SearchWhere == "0=101")
			$paquetes_provision_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$paquetes_provision_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($paquetes_provision_list->AuditTrailOnSearch && $paquetes_provision_list->Command == "search" && !$paquetes_provision_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $paquetes_provision_list->getSessionWhere();
		$paquetes_provision_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$paquetes_provision_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($paquetes_provision->Export == "" && $paquetes_provision->CurrentAction == "") { ?>
<form name="fpaquetes_provisionlistsrch" id="fpaquetes_provisionlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($paquetes_provision_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpaquetes_provisionlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="paquetes_provision">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($paquetes_provision_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($paquetes_provision_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $paquetes_provision_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($paquetes_provision_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($paquetes_provision_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($paquetes_provision_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($paquetes_provision_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $paquetes_provision_list->ShowPageHeader(); ?>
<?php
$paquetes_provision_list->ShowMessage();
?>
<?php if ($paquetes_provision_list->TotalRecs > 0 || $paquetes_provision->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid paquetes_provision">
<?php if ($paquetes_provision->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($paquetes_provision->CurrentAction <> "gridadd" && $paquetes_provision->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($paquetes_provision_list->Pager)) $paquetes_provision_list->Pager = new cPrevNextPager($paquetes_provision_list->StartRec, $paquetes_provision_list->DisplayRecs, $paquetes_provision_list->TotalRecs) ?>
<?php if ($paquetes_provision_list->Pager->RecordCount > 0 && $paquetes_provision_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($paquetes_provision_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($paquetes_provision_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $paquetes_provision_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($paquetes_provision_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($paquetes_provision_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($paquetes_provision_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpaquetes_provisionlist" id="fpaquetes_provisionlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($paquetes_provision_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $paquetes_provision_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="paquetes_provision">
<div id="gmp_paquetes_provision" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($paquetes_provision_list->TotalRecs > 0 || $paquetes_provision->CurrentAction == "add" || $paquetes_provision->CurrentAction == "copy") { ?>
<table id="tbl_paquetes_provisionlist" class="table ewTable">
<?php echo $paquetes_provision->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$paquetes_provision_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$paquetes_provision_list->RenderListOptions();

// Render list options (header, left)
$paquetes_provision_list->ListOptions->Render("header", "left");
?>
<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Serie_Netbook) == "") { ?>
		<th data-name="Serie_Netbook"><div id="elh_paquetes_provision_Serie_Netbook" class="paquetes_provision_Serie_Netbook"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Serie_Netbook"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Serie_Netbook) ?>',1);"><div id="elh_paquetes_provision_Serie_Netbook" class="paquetes_provision_Serie_Netbook">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Serie_Netbook->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Serie_Netbook->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Hardware) == "") { ?>
		<th data-name="Id_Hardware"><div id="elh_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Hardware"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Id_Hardware) ?>',1);"><div id="elh_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Hardware->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Hardware->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->SN->Visible) { // SN ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->SN) == "") { ?>
		<th data-name="SN"><div id="elh_paquetes_provision_SN" class="paquetes_provision_SN"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->SN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SN"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->SN) ?>',1);"><div id="elh_paquetes_provision_SN" class="paquetes_provision_SN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->SN->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->SN->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->SN->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Marca_Arranque) == "") { ?>
		<th data-name="Marca_Arranque"><div id="elh_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Marca_Arranque"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Marca_Arranque) ?>',1);"><div id="elh_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Marca_Arranque->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Marca_Arranque->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Serie_Server) == "") { ?>
		<th data-name="Serie_Server"><div id="elh_paquetes_provision_Serie_Server" class="paquetes_provision_Serie_Server"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Serie_Server->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Serie_Server"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Serie_Server) ?>',1);"><div id="elh_paquetes_provision_Serie_Server" class="paquetes_provision_Serie_Server">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Serie_Server->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Serie_Server->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Serie_Server->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Motivo) == "") { ?>
		<th data-name="Id_Motivo"><div id="elh_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Motivo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Id_Motivo) ?>',1);"><div id="elh_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Motivo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Motivo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Tipo_Extraccion) == "") { ?>
		<th data-name="Id_Tipo_Extraccion"><div id="elh_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Extraccion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Id_Tipo_Extraccion) ?>',1);"><div id="elh_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Tipo_Extraccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Tipo_Extraccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Estado_Paquete) == "") { ?>
		<th data-name="Id_Estado_Paquete"><div id="elh_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Paquete"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Id_Estado_Paquete) ?>',1);"><div id="elh_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Estado_Paquete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Estado_Paquete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Id_Tipo_Paquete) == "") { ?>
		<th data-name="Id_Tipo_Paquete"><div id="elh_paquetes_provision_Id_Tipo_Paquete" class="paquetes_provision_Id_Tipo_Paquete"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Paquete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Paquete"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Id_Tipo_Paquete) ?>',1);"><div id="elh_paquetes_provision_Id_Tipo_Paquete" class="paquetes_provision_Id_Tipo_Paquete">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Id_Tipo_Paquete->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Id_Tipo_Paquete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Id_Tipo_Paquete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Apellido_Nombre_Solicitante) == "") { ?>
		<th data-name="Apellido_Nombre_Solicitante"><div id="elh_paquetes_provision_Apellido_Nombre_Solicitante" class="paquetes_provision_Apellido_Nombre_Solicitante"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Apellido_Nombre_Solicitante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_Nombre_Solicitante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Apellido_Nombre_Solicitante) ?>',1);"><div id="elh_paquetes_provision_Apellido_Nombre_Solicitante" class="paquetes_provision_Apellido_Nombre_Solicitante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Apellido_Nombre_Solicitante->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Apellido_Nombre_Solicitante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Apellido_Nombre_Solicitante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_paquetes_provision_Dni" class="paquetes_provision_Dni"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Dni) ?>',1);"><div id="elh_paquetes_provision_Dni" class="paquetes_provision_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Dni->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Email_Solicitante) == "") { ?>
		<th data-name="Email_Solicitante"><div id="elh_paquetes_provision_Email_Solicitante" class="paquetes_provision_Email_Solicitante"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Email_Solicitante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Email_Solicitante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Email_Solicitante) ?>',1);"><div id="elh_paquetes_provision_Email_Solicitante" class="paquetes_provision_Email_Solicitante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Email_Solicitante->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Email_Solicitante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Email_Solicitante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_paquetes_provision_Usuario" class="paquetes_provision_Usuario"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Usuario) ?>',1);"><div id="elh_paquetes_provision_Usuario" class="paquetes_provision_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($paquetes_provision->SortUrl($paquetes_provision->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_paquetes_provision_Fecha_Actualizacion" class="paquetes_provision_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $paquetes_provision->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $paquetes_provision->SortUrl($paquetes_provision->Fecha_Actualizacion) ?>',1);"><div id="elh_paquetes_provision_Fecha_Actualizacion" class="paquetes_provision_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $paquetes_provision->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($paquetes_provision->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($paquetes_provision->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$paquetes_provision_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($paquetes_provision->CurrentAction == "add" || $paquetes_provision->CurrentAction == "copy") {
		$paquetes_provision_list->RowIndex = 0;
		$paquetes_provision_list->KeyCount = $paquetes_provision_list->RowIndex;
		if ($paquetes_provision->CurrentAction == "add")
			$paquetes_provision_list->LoadDefaultValues();
		if ($paquetes_provision->EventCancelled) // Insert failed
			$paquetes_provision_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$paquetes_provision->ResetAttrs();
		$paquetes_provision->RowAttrs = array_merge($paquetes_provision->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_paquetes_provision', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$paquetes_provision->RowType = EW_ROWTYPE_ADD;

		// Render row
		$paquetes_provision_list->RenderRow();

		// Render list options
		$paquetes_provision_list->RenderListOptions();
		$paquetes_provision_list->StartRowCnt = 0;
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php

// Render list options (body, left)
$paquetes_provision_list->ListOptions->Render("body", "left", $paquetes_provision_list->RowCnt);
?>
	<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<td data-name="Serie_Netbook">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Netbook" class="form-group paquetes_provision_Serie_Netbook">
<?php $paquetes_provision->Serie_Netbook->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Serie_Netbook->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><?php echo (strval($paquetes_provision->Serie_Netbook->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Netbook->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Netbook->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Netbook->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Netbook->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->Serie_Netbook->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_list->RowIndex ?>_SN">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Netbook->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisionlist.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td data-name="SN">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
		<td data-name="Serie_Server">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Server" class="form-group paquetes_provision_Serie_Server">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server"><?php echo (strval($paquetes_provision->Serie_Server->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Server->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Server->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Server->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Server->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Server->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<td data-name="Id_Tipo_Paquete">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Paquete" class="form-group paquetes_provision_Id_Tipo_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo $paquetes_provision->Id_Tipo_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Paquete->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<td data-name="Apellido_Nombre_Solicitante">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Apellido_Nombre_Solicitante" class="form-group paquetes_provision_Apellido_Nombre_Solicitante">
<?php $paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante"><?php echo (strval($paquetes_provision->Apellido_Nombre_Solicitante->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Apellido_Nombre_Solicitante->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Apellido_Nombre_Solicitante->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CurrentValue ?>"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante,x<?php echo $paquetes_provision_list->RowIndex ?>_Dni">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Apellido_Nombre_Solicitante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Dni" class="form-group paquetes_provision_Dni">
<input type="text" data-table="paquetes_provision" data-field="x_Dni" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Dni->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Dni->EditValue ?>"<?php echo $paquetes_provision->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Dni" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($paquetes_provision->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<td data-name="Email_Solicitante">
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Email_Solicitante" class="form-group paquetes_provision_Email_Solicitante">
<input type="text" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Email_Solicitante->EditValue ?>"<?php echo $paquetes_provision->Email_Solicitante->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actualizacion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$paquetes_provision_list->ListOptions->Render("body", "right", $paquetes_provision_list->RowCnt);
?>
<script type="text/javascript">
fpaquetes_provisionlist.UpdateOpts(<?php echo $paquetes_provision_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($paquetes_provision->ExportAll && $paquetes_provision->Export <> "") {
	$paquetes_provision_list->StopRec = $paquetes_provision_list->TotalRecs;
} else {

	// Set the last record to display
	if ($paquetes_provision_list->TotalRecs > $paquetes_provision_list->StartRec + $paquetes_provision_list->DisplayRecs - 1)
		$paquetes_provision_list->StopRec = $paquetes_provision_list->StartRec + $paquetes_provision_list->DisplayRecs - 1;
	else
		$paquetes_provision_list->StopRec = $paquetes_provision_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($paquetes_provision_list->FormKeyCountName) && ($paquetes_provision->CurrentAction == "gridadd" || $paquetes_provision->CurrentAction == "gridedit" || $paquetes_provision->CurrentAction == "F")) {
		$paquetes_provision_list->KeyCount = $objForm->GetValue($paquetes_provision_list->FormKeyCountName);
		$paquetes_provision_list->StopRec = $paquetes_provision_list->StartRec + $paquetes_provision_list->KeyCount - 1;
	}
}
$paquetes_provision_list->RecCnt = $paquetes_provision_list->StartRec - 1;
if ($paquetes_provision_list->Recordset && !$paquetes_provision_list->Recordset->EOF) {
	$paquetes_provision_list->Recordset->MoveFirst();
	$bSelectLimit = $paquetes_provision_list->UseSelectLimit;
	if (!$bSelectLimit && $paquetes_provision_list->StartRec > 1)
		$paquetes_provision_list->Recordset->Move($paquetes_provision_list->StartRec - 1);
} elseif (!$paquetes_provision->AllowAddDeleteRow && $paquetes_provision_list->StopRec == 0) {
	$paquetes_provision_list->StopRec = $paquetes_provision->GridAddRowCount;
}

// Initialize aggregate
$paquetes_provision->RowType = EW_ROWTYPE_AGGREGATEINIT;
$paquetes_provision->ResetAttrs();
$paquetes_provision_list->RenderRow();
$paquetes_provision_list->EditRowCnt = 0;
if ($paquetes_provision->CurrentAction == "edit")
	$paquetes_provision_list->RowIndex = 1;
if ($paquetes_provision->CurrentAction == "gridadd")
	$paquetes_provision_list->RowIndex = 0;
if ($paquetes_provision->CurrentAction == "gridedit")
	$paquetes_provision_list->RowIndex = 0;
while ($paquetes_provision_list->RecCnt < $paquetes_provision_list->StopRec) {
	$paquetes_provision_list->RecCnt++;
	if (intval($paquetes_provision_list->RecCnt) >= intval($paquetes_provision_list->StartRec)) {
		$paquetes_provision_list->RowCnt++;
		if ($paquetes_provision->CurrentAction == "gridadd" || $paquetes_provision->CurrentAction == "gridedit" || $paquetes_provision->CurrentAction == "F") {
			$paquetes_provision_list->RowIndex++;
			$objForm->Index = $paquetes_provision_list->RowIndex;
			if ($objForm->HasValue($paquetes_provision_list->FormActionName))
				$paquetes_provision_list->RowAction = strval($objForm->GetValue($paquetes_provision_list->FormActionName));
			elseif ($paquetes_provision->CurrentAction == "gridadd")
				$paquetes_provision_list->RowAction = "insert";
			else
				$paquetes_provision_list->RowAction = "";
		}

		// Set up key count
		$paquetes_provision_list->KeyCount = $paquetes_provision_list->RowIndex;

		// Init row class and style
		$paquetes_provision->ResetAttrs();
		$paquetes_provision->CssClass = "";
		if ($paquetes_provision->CurrentAction == "gridadd") {
			$paquetes_provision_list->LoadDefaultValues(); // Load default values
		} else {
			$paquetes_provision_list->LoadRowValues($paquetes_provision_list->Recordset); // Load row values
		}
		$paquetes_provision->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($paquetes_provision->CurrentAction == "gridadd") // Grid add
			$paquetes_provision->RowType = EW_ROWTYPE_ADD; // Render add
		if ($paquetes_provision->CurrentAction == "gridadd" && $paquetes_provision->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$paquetes_provision_list->RestoreCurrentRowFormValues($paquetes_provision_list->RowIndex); // Restore form values
		if ($paquetes_provision->CurrentAction == "edit") {
			if ($paquetes_provision_list->CheckInlineEditKey() && $paquetes_provision_list->EditRowCnt == 0) { // Inline edit
				$paquetes_provision->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($paquetes_provision->CurrentAction == "gridedit") { // Grid edit
			if ($paquetes_provision->EventCancelled) {
				$paquetes_provision_list->RestoreCurrentRowFormValues($paquetes_provision_list->RowIndex); // Restore form values
			}
			if ($paquetes_provision_list->RowAction == "insert")
				$paquetes_provision->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$paquetes_provision->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($paquetes_provision->CurrentAction == "edit" && $paquetes_provision->RowType == EW_ROWTYPE_EDIT && $paquetes_provision->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$paquetes_provision_list->RestoreFormValues(); // Restore form values
		}
		if ($paquetes_provision->CurrentAction == "gridedit" && ($paquetes_provision->RowType == EW_ROWTYPE_EDIT || $paquetes_provision->RowType == EW_ROWTYPE_ADD) && $paquetes_provision->EventCancelled) // Update failed
			$paquetes_provision_list->RestoreCurrentRowFormValues($paquetes_provision_list->RowIndex); // Restore form values
		if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) // Edit row
			$paquetes_provision_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$paquetes_provision->RowAttrs = array_merge($paquetes_provision->RowAttrs, array('data-rowindex'=>$paquetes_provision_list->RowCnt, 'id'=>'r' . $paquetes_provision_list->RowCnt . '_paquetes_provision', 'data-rowtype'=>$paquetes_provision->RowType));

		// Render row
		$paquetes_provision_list->RenderRow();

		// Render list options
		$paquetes_provision_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($paquetes_provision_list->RowAction <> "delete" && $paquetes_provision_list->RowAction <> "insertdelete" && !($paquetes_provision_list->RowAction == "insert" && $paquetes_provision->CurrentAction == "F" && $paquetes_provision_list->EmptyRow())) {
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php

// Render list options (body, left)
$paquetes_provision_list->ListOptions->Render("body", "left", $paquetes_provision_list->RowCnt);
?>
	<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<td data-name="Serie_Netbook"<?php echo $paquetes_provision->Serie_Netbook->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Netbook" class="form-group paquetes_provision_Serie_Netbook">
<?php $paquetes_provision->Serie_Netbook->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Serie_Netbook->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><?php echo (strval($paquetes_provision->Serie_Netbook->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Netbook->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Netbook->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Netbook->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Netbook->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->Serie_Netbook->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_list->RowIndex ?>_SN">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Netbook->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Netbook" class="form-group paquetes_provision_Serie_Netbook">
<?php $paquetes_provision->Serie_Netbook->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Serie_Netbook->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><?php echo (strval($paquetes_provision->Serie_Netbook->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Netbook->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Netbook->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Netbook->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Netbook->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->Serie_Netbook->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_list->RowIndex ?>_SN">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Netbook" class="paquetes_provision_Serie_Netbook">
<span<?php echo $paquetes_provision->Serie_Netbook->ViewAttributes() ?>>
<?php echo $paquetes_provision->Serie_Netbook->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $paquetes_provision_list->PageObjName . "_row_" . $paquetes_provision_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="x<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" id="x<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->CurrentValue) ?>">
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="o<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" id="o<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT || $paquetes_provision->CurrentMode == "edit") { ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_NroPedido" name="x<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" id="x<?php echo $paquetes_provision_list->RowIndex ?>_NroPedido" value="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->CurrentValue) ?>">
<?php } ?>
	<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware"<?php echo $paquetes_provision->Id_Hardware->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisionlist.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisionlist.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware">
<span<?php echo $paquetes_provision->Id_Hardware->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Hardware->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td data-name="SN"<?php echo $paquetes_provision->SN->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_SN" class="paquetes_provision_SN">
<span<?php echo $paquetes_provision->SN->ViewAttributes() ?>>
<?php echo $paquetes_provision->SN->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque"<?php echo $paquetes_provision->Marca_Arranque->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque">
<span<?php echo $paquetes_provision->Marca_Arranque->ViewAttributes() ?>>
<?php echo $paquetes_provision->Marca_Arranque->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
		<td data-name="Serie_Server"<?php echo $paquetes_provision->Serie_Server->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Server" class="form-group paquetes_provision_Serie_Server">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server"><?php echo (strval($paquetes_provision->Serie_Server->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Server->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Server->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Server->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Server->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Server->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Server" class="form-group paquetes_provision_Serie_Server">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server"><?php echo (strval($paquetes_provision->Serie_Server->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Server->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Server->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Server->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Server->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Serie_Server" class="paquetes_provision_Serie_Server">
<span<?php echo $paquetes_provision->Serie_Server->ViewAttributes() ?>>
<?php echo $paquetes_provision->Serie_Server->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo">
<span<?php echo $paquetes_provision->Id_Motivo->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion">
<span<?php echo $paquetes_provision->Id_Tipo_Extraccion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete">
<span<?php echo $paquetes_provision->Id_Estado_Paquete->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<td data-name="Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Paquete" class="form-group paquetes_provision_Id_Tipo_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo $paquetes_provision->Id_Tipo_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Paquete->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Paquete" class="form-group paquetes_provision_Id_Tipo_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo $paquetes_provision->Id_Tipo_Paquete->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Id_Tipo_Paquete" class="paquetes_provision_Id_Tipo_Paquete">
<span<?php echo $paquetes_provision->Id_Tipo_Paquete->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<td data-name="Apellido_Nombre_Solicitante"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Apellido_Nombre_Solicitante" class="form-group paquetes_provision_Apellido_Nombre_Solicitante">
<?php $paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante"><?php echo (strval($paquetes_provision->Apellido_Nombre_Solicitante->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Apellido_Nombre_Solicitante->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Apellido_Nombre_Solicitante->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CurrentValue ?>"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante,x<?php echo $paquetes_provision_list->RowIndex ?>_Dni">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Apellido_Nombre_Solicitante->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Apellido_Nombre_Solicitante" class="form-group paquetes_provision_Apellido_Nombre_Solicitante">
<?php $paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante"><?php echo (strval($paquetes_provision->Apellido_Nombre_Solicitante->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Apellido_Nombre_Solicitante->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Apellido_Nombre_Solicitante->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CurrentValue ?>"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante,x<?php echo $paquetes_provision_list->RowIndex ?>_Dni">
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Apellido_Nombre_Solicitante" class="paquetes_provision_Apellido_Nombre_Solicitante">
<span<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->ViewAttributes() ?>>
<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $paquetes_provision->Dni->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Dni" class="form-group paquetes_provision_Dni">
<input type="text" data-table="paquetes_provision" data-field="x_Dni" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Dni->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Dni->EditValue ?>"<?php echo $paquetes_provision->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Dni" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($paquetes_provision->Dni->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Dni" class="form-group paquetes_provision_Dni">
<input type="text" data-table="paquetes_provision" data-field="x_Dni" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Dni->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Dni->EditValue ?>"<?php echo $paquetes_provision->Dni->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Dni" class="paquetes_provision_Dni">
<span<?php echo $paquetes_provision->Dni->ViewAttributes() ?>>
<?php echo $paquetes_provision->Dni->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<td data-name="Email_Solicitante"<?php echo $paquetes_provision->Email_Solicitante->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Email_Solicitante" class="form-group paquetes_provision_Email_Solicitante">
<input type="text" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Email_Solicitante->EditValue ?>"<?php echo $paquetes_provision->Email_Solicitante->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Email_Solicitante" class="form-group paquetes_provision_Email_Solicitante">
<input type="text" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Email_Solicitante->EditValue ?>"<?php echo $paquetes_provision->Email_Solicitante->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Email_Solicitante" class="paquetes_provision_Email_Solicitante">
<span<?php echo $paquetes_provision->Email_Solicitante->ViewAttributes() ?>>
<?php echo $paquetes_provision->Email_Solicitante->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $paquetes_provision->Usuario->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Usuario" class="paquetes_provision_Usuario">
<span<?php echo $paquetes_provision->Usuario->ViewAttributes() ?>>
<?php echo $paquetes_provision->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $paquetes_provision->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actualizacion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $paquetes_provision_list->RowCnt ?>_paquetes_provision_Fecha_Actualizacion" class="paquetes_provision_Fecha_Actualizacion">
<span<?php echo $paquetes_provision->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$paquetes_provision_list->ListOptions->Render("body", "right", $paquetes_provision_list->RowCnt);
?>
	</tr>
<?php if ($paquetes_provision->RowType == EW_ROWTYPE_ADD || $paquetes_provision->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpaquetes_provisionlist.UpdateOpts(<?php echo $paquetes_provision_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($paquetes_provision->CurrentAction <> "gridadd")
		if (!$paquetes_provision_list->Recordset->EOF) $paquetes_provision_list->Recordset->MoveNext();
}
?>
<?php
	if ($paquetes_provision->CurrentAction == "gridadd" || $paquetes_provision->CurrentAction == "gridedit") {
		$paquetes_provision_list->RowIndex = '$rowindex$';
		$paquetes_provision_list->LoadDefaultValues();

		// Set row properties
		$paquetes_provision->ResetAttrs();
		$paquetes_provision->RowAttrs = array_merge($paquetes_provision->RowAttrs, array('data-rowindex'=>$paquetes_provision_list->RowIndex, 'id'=>'r0_paquetes_provision', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($paquetes_provision->RowAttrs["class"], "ewTemplate");
		$paquetes_provision->RowType = EW_ROWTYPE_ADD;

		// Render row
		$paquetes_provision_list->RenderRow();

		// Render list options
		$paquetes_provision_list->RenderListOptions();
		$paquetes_provision_list->StartRowCnt = 0;
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php

// Render list options (body, left)
$paquetes_provision_list->ListOptions->Render("body", "left", $paquetes_provision_list->RowIndex);
?>
	<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<td data-name="Serie_Netbook">
<span id="el$rowindex$_paquetes_provision_Serie_Netbook" class="form-group paquetes_provision_Serie_Netbook">
<?php $paquetes_provision->Serie_Netbook->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Serie_Netbook->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><?php echo (strval($paquetes_provision->Serie_Netbook->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Netbook->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Netbook->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Netbook->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Netbook->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $paquetes_provision->Serie_Netbook->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware,x<?php echo $paquetes_provision_list->RowIndex ?>_SN">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Netbook" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Netbook->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware">
<span id="el$rowindex$_paquetes_provision_Id_Hardware" class="form-group paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" style="white-space: nowrap; z-index: <?php echo (9000 - $paquetes_provision_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="sv_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="q_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisionlist.CreateAutoSuggest({"id":"x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td data-name="SN">
<span id="el$rowindex$_paquetes_provision_SN" class="form-group paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="x<?php echo $paquetes_provision_list->RowIndex ?>_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_SN" name="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" id="o<?php echo $paquetes_provision_list->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($paquetes_provision->SN->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque">
<span id="el$rowindex$_paquetes_provision_Marca_Arranque" class="form-group paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Marca_Arranque" value="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
		<td data-name="Serie_Server">
<span id="el$rowindex$_paquetes_provision_Serie_Server" class="form-group paquetes_provision_Serie_Server">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server"><?php echo (strval($paquetes_provision->Serie_Server->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Server->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Server->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Server->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->CurrentValue ?>"<?php echo $paquetes_provision->Serie_Server->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Serie_Server" value="<?php echo ew_HtmlEncode($paquetes_provision->Serie_Server->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo">
<span id="el$rowindex$_paquetes_provision_Id_Motivo" class="form-group paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Motivo" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Motivo" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Motivo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion">
<span id="el$rowindex$_paquetes_provision_Id_Tipo_Extraccion" class="form-group paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Extraccion" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Extraccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete">
<span id="el$rowindex$_paquetes_provision_Id_Estado_Paquete" class="form-group paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Estado_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Estado_Paquete->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<td data-name="Id_Tipo_Paquete">
<span id="el$rowindex$_paquetes_provision_Id_Tipo_Paquete" class="form-group paquetes_provision_Id_Tipo_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Paquete->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->SelectOptionListHtml("x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete") ?>
</select>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo $paquetes_provision->Id_Tipo_Paquete->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Id_Tipo_Paquete" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Tipo_Paquete->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<td data-name="Apellido_Nombre_Solicitante">
<span id="el$rowindex$_paquetes_provision_Apellido_Nombre_Solicitante" class="form-group paquetes_provision_Apellido_Nombre_Solicitante">
<?php $paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$paquetes_provision->Apellido_Nombre_Solicitante->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante"><?php echo (strval($paquetes_provision->Apellido_Nombre_Solicitante->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Apellido_Nombre_Solicitante->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Apellido_Nombre_Solicitante->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CurrentValue ?>"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="s_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="ln_x<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante,x<?php echo $paquetes_provision_list->RowIndex ?>_Dni">
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Apellido_Nombre_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Apellido_Nombre_Solicitante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<span id="el$rowindex$_paquetes_provision_Dni" class="form-group paquetes_provision_Dni">
<input type="text" data-table="paquetes_provision" data-field="x_Dni" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Dni->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Dni->EditValue ?>"<?php echo $paquetes_provision->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Dni" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($paquetes_provision->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<td data-name="Email_Solicitante">
<span id="el$rowindex$_paquetes_provision_Email_Solicitante" class="form-group paquetes_provision_Email_Solicitante">
<input type="text" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="x<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Email_Solicitante->EditValue ?>"<?php echo $paquetes_provision->Email_Solicitante->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Email_Solicitante" value="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="paquetes_provision" data-field="x_Usuario" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="paquetes_provision" data-field="x_Fecha_Actualizacion" name="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $paquetes_provision_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$paquetes_provision_list->ListOptions->Render("body", "right", $paquetes_provision_list->RowCnt);
?>
<script type="text/javascript">
fpaquetes_provisionlist.UpdateOpts(<?php echo $paquetes_provision_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($paquetes_provision->CurrentAction == "add" || $paquetes_provision->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $paquetes_provision_list->FormKeyCountName ?>" id="<?php echo $paquetes_provision_list->FormKeyCountName ?>" value="<?php echo $paquetes_provision_list->KeyCount ?>">
<?php } ?>
<?php if ($paquetes_provision->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $paquetes_provision_list->FormKeyCountName ?>" id="<?php echo $paquetes_provision_list->FormKeyCountName ?>" value="<?php echo $paquetes_provision_list->KeyCount ?>">
<?php echo $paquetes_provision_list->MultiSelectKey ?>
<?php } ?>
<?php if ($paquetes_provision->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $paquetes_provision_list->FormKeyCountName ?>" id="<?php echo $paquetes_provision_list->FormKeyCountName ?>" value="<?php echo $paquetes_provision_list->KeyCount ?>">
<?php } ?>
<?php if ($paquetes_provision->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $paquetes_provision_list->FormKeyCountName ?>" id="<?php echo $paquetes_provision_list->FormKeyCountName ?>" value="<?php echo $paquetes_provision_list->KeyCount ?>">
<?php echo $paquetes_provision_list->MultiSelectKey ?>
<?php } ?>
<?php if ($paquetes_provision->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($paquetes_provision_list->Recordset)
	$paquetes_provision_list->Recordset->Close();
?>
<?php if ($paquetes_provision->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($paquetes_provision->CurrentAction <> "gridadd" && $paquetes_provision->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($paquetes_provision_list->Pager)) $paquetes_provision_list->Pager = new cPrevNextPager($paquetes_provision_list->StartRec, $paquetes_provision_list->DisplayRecs, $paquetes_provision_list->TotalRecs) ?>
<?php if ($paquetes_provision_list->Pager->RecordCount > 0 && $paquetes_provision_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($paquetes_provision_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($paquetes_provision_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $paquetes_provision_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($paquetes_provision_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($paquetes_provision_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $paquetes_provision_list->PageUrl() ?>start=<?php echo $paquetes_provision_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $paquetes_provision_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($paquetes_provision_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($paquetes_provision_list->TotalRecs == 0 && $paquetes_provision->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($paquetes_provision_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($paquetes_provision->Export == "") { ?>
<script type="text/javascript">
fpaquetes_provisionlistsrch.FilterList = <?php echo $paquetes_provision_list->GetFilterList() ?>;
fpaquetes_provisionlistsrch.Init();
fpaquetes_provisionlist.Init();
</script>
<?php } ?>
<?php
$paquetes_provision_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($paquetes_provision->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$paquetes_provision_list->Page_Terminate();
?>
