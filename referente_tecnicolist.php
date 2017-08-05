<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "referente_tecnicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$referente_tecnico_list = NULL; // Initialize page object first

class creferente_tecnico_list extends creferente_tecnico {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'referente_tecnico';

	// Page object name
	var $PageObjName = 'referente_tecnico_list';

	// Grid form hidden field names
	var $FormName = 'freferente_tecnicolist';
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

		// Table object (referente_tecnico)
		if (!isset($GLOBALS["referente_tecnico"]) || get_class($GLOBALS["referente_tecnico"]) == "creferente_tecnico") {
			$GLOBALS["referente_tecnico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referente_tecnico"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "referente_tecnicoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "referente_tecnicodelete.php";
		$this->MultiUpdateUrl = "referente_tecnicoupdate.php";

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'referente_tecnico', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption freferente_tecnicolistsrch";

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
		$this->Apellido_Nombre->SetVisibility();
		$this->DniRte->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Fecha_Ingreso->SetVisibility();
		$this->Titulo->SetVisibility();
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
		global $EW_EXPORT, $referente_tecnico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($referente_tecnico);
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
		$this->setKey("DniRte", ""); // Clear inline edit key
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
		if (@$_GET["DniRte"] <> "") {
			$this->DniRte->setQueryStringValue($_GET["DniRte"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("DniRte", $this->DniRte->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("DniRte")) <> strval($this->DniRte->CurrentValue))
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
			$this->DniRte->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->DniRte->FormValue))
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
					$sKey .= $this->DniRte->CurrentValue;

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
		if ($objForm->HasValue("x_Apellido_Nombre") && $objForm->HasValue("o_Apellido_Nombre") && $this->Apellido_Nombre->CurrentValue <> $this->Apellido_Nombre->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_DniRte") && $objForm->HasValue("o_DniRte") && $this->DniRte->CurrentValue <> $this->DniRte->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Domicilio") && $objForm->HasValue("o_Domicilio") && $this->Domicilio->CurrentValue <> $this->Domicilio->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Telefono") && $objForm->HasValue("o_Telefono") && $this->Telefono->CurrentValue <> $this->Telefono->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Celular") && $objForm->HasValue("o_Celular") && $this->Celular->CurrentValue <> $this->Celular->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Mail") && $objForm->HasValue("o_Mail") && $this->Mail->CurrentValue <> $this->Mail->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Turno") && $objForm->HasValue("o_Id_Turno") && $this->Id_Turno->CurrentValue <> $this->Id_Turno->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Fecha_Ingreso") && $objForm->HasValue("o_Fecha_Ingreso") && $this->Fecha_Ingreso->CurrentValue <> $this->Fecha_Ingreso->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Titulo") && $objForm->HasValue("o_Titulo") && $this->Titulo->CurrentValue <> $this->Titulo->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "freferente_tecnicolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Apellido_Nombre->AdvancedSearch->ToJSON(), ","); // Field Apellido_Nombre
		$sFilterList = ew_Concat($sFilterList, $this->DniRte->AdvancedSearch->ToJSON(), ","); // Field DniRte
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Telefono->AdvancedSearch->ToJSON(), ","); // Field Telefono
		$sFilterList = ew_Concat($sFilterList, $this->Celular->AdvancedSearch->ToJSON(), ","); // Field Celular
		$sFilterList = ew_Concat($sFilterList, $this->Mail->AdvancedSearch->ToJSON(), ","); // Field Mail
		$sFilterList = ew_Concat($sFilterList, $this->Id_Turno->AdvancedSearch->ToJSON(), ","); // Field Id_Turno
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Ingreso->AdvancedSearch->ToJSON(), ","); // Field Fecha_Ingreso
		$sFilterList = ew_Concat($sFilterList, $this->Titulo->AdvancedSearch->ToJSON(), ","); // Field Titulo
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "freferente_tecnicolistsrch", $filters);
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

		// Field DniRte
		$this->DniRte->AdvancedSearch->SearchValue = @$filter["x_DniRte"];
		$this->DniRte->AdvancedSearch->SearchOperator = @$filter["z_DniRte"];
		$this->DniRte->AdvancedSearch->SearchCondition = @$filter["v_DniRte"];
		$this->DniRte->AdvancedSearch->SearchValue2 = @$filter["y_DniRte"];
		$this->DniRte->AdvancedSearch->SearchOperator2 = @$filter["w_DniRte"];
		$this->DniRte->AdvancedSearch->Save();

		// Field Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = @$filter["x_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchOperator = @$filter["z_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchCondition = @$filter["v_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchValue2 = @$filter["y_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchOperator2 = @$filter["w_Domicilio"];
		$this->Domicilio->AdvancedSearch->Save();

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

		// Field Mail
		$this->Mail->AdvancedSearch->SearchValue = @$filter["x_Mail"];
		$this->Mail->AdvancedSearch->SearchOperator = @$filter["z_Mail"];
		$this->Mail->AdvancedSearch->SearchCondition = @$filter["v_Mail"];
		$this->Mail->AdvancedSearch->SearchValue2 = @$filter["y_Mail"];
		$this->Mail->AdvancedSearch->SearchOperator2 = @$filter["w_Mail"];
		$this->Mail->AdvancedSearch->Save();

		// Field Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = @$filter["x_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$filter["z_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchCondition = @$filter["v_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchValue2 = @$filter["y_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->Save();

		// Field Fecha_Ingreso
		$this->Fecha_Ingreso->AdvancedSearch->SearchValue = @$filter["x_Fecha_Ingreso"];
		$this->Fecha_Ingreso->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Ingreso"];
		$this->Fecha_Ingreso->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Ingreso"];
		$this->Fecha_Ingreso->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Ingreso"];
		$this->Fecha_Ingreso->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Ingreso"];
		$this->Fecha_Ingreso->AdvancedSearch->Save();

		// Field Titulo
		$this->Titulo->AdvancedSearch->SearchValue = @$filter["x_Titulo"];
		$this->Titulo->AdvancedSearch->SearchOperator = @$filter["z_Titulo"];
		$this->Titulo->AdvancedSearch->SearchCondition = @$filter["v_Titulo"];
		$this->Titulo->AdvancedSearch->SearchValue2 = @$filter["y_Titulo"];
		$this->Titulo->AdvancedSearch->SearchOperator2 = @$filter["w_Titulo"];
		$this->Titulo->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Apellido_Nombre, $Default, FALSE); // Apellido_Nombre
		$this->BuildSearchSql($sWhere, $this->DniRte, $Default, FALSE); // DniRte
		$this->BuildSearchSql($sWhere, $this->Domicilio, $Default, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Telefono, $Default, FALSE); // Telefono
		$this->BuildSearchSql($sWhere, $this->Celular, $Default, FALSE); // Celular
		$this->BuildSearchSql($sWhere, $this->Mail, $Default, FALSE); // Mail
		$this->BuildSearchSql($sWhere, $this->Id_Turno, $Default, FALSE); // Id_Turno
		$this->BuildSearchSql($sWhere, $this->Fecha_Ingreso, $Default, FALSE); // Fecha_Ingreso
		$this->BuildSearchSql($sWhere, $this->Titulo, $Default, FALSE); // Titulo
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Apellido_Nombre->AdvancedSearch->Save(); // Apellido_Nombre
			$this->DniRte->AdvancedSearch->Save(); // DniRte
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Telefono->AdvancedSearch->Save(); // Telefono
			$this->Celular->AdvancedSearch->Save(); // Celular
			$this->Mail->AdvancedSearch->Save(); // Mail
			$this->Id_Turno->AdvancedSearch->Save(); // Id_Turno
			$this->Fecha_Ingreso->AdvancedSearch->Save(); // Fecha_Ingreso
			$this->Titulo->AdvancedSearch->Save(); // Titulo
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
		$this->BuildBasicSearchSQL($sWhere, $this->Apellido_Nombre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DniRte, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Turno, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Titulo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cue, $arKeywords, $type);
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
		if ($this->Apellido_Nombre->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->DniRte->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Telefono->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Celular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Mail->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Turno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Ingreso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Titulo->AdvancedSearch->IssetSession())
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
		$this->Apellido_Nombre->AdvancedSearch->UnsetSession();
		$this->DniRte->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Telefono->AdvancedSearch->UnsetSession();
		$this->Celular->AdvancedSearch->UnsetSession();
		$this->Mail->AdvancedSearch->UnsetSession();
		$this->Id_Turno->AdvancedSearch->UnsetSession();
		$this->Fecha_Ingreso->AdvancedSearch->UnsetSession();
		$this->Titulo->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Apellido_Nombre->AdvancedSearch->Load();
		$this->DniRte->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Mail->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Fecha_Ingreso->AdvancedSearch->Load();
		$this->Titulo->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Apellido_Nombre); // Apellido_Nombre
			$this->UpdateSort($this->DniRte); // DniRte
			$this->UpdateSort($this->Domicilio); // Domicilio
			$this->UpdateSort($this->Telefono); // Telefono
			$this->UpdateSort($this->Celular); // Celular
			$this->UpdateSort($this->Mail); // Mail
			$this->UpdateSort($this->Id_Turno); // Id_Turno
			$this->UpdateSort($this->Fecha_Ingreso); // Fecha_Ingreso
			$this->UpdateSort($this->Titulo); // Titulo
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
				$this->DniRte->setSort("");
				$this->Domicilio->setSort("");
				$this->Telefono->setSort("");
				$this->Celular->setSort("");
				$this->Mail->setSort("");
				$this->Id_Turno->setSort("");
				$this->Fecha_Ingreso->setSort("");
				$this->Titulo->setSort("");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->DniRte->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"referente_tecnico\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"referente_tecnico\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->DniRte->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->DniRte->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.freferente_tecnicolist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"referente_tecnico\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.freferente_tecnicolist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"freferente_tecnicolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"freferente_tecnicolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.freferente_tecnicolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"freferente_tecnicolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"referente_tecnicosrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Apellido_Nombre->CurrentValue = NULL;
		$this->Apellido_Nombre->OldValue = $this->Apellido_Nombre->CurrentValue;
		$this->DniRte->CurrentValue = NULL;
		$this->DniRte->OldValue = $this->DniRte->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Telefono->CurrentValue = NULL;
		$this->Telefono->OldValue = $this->Telefono->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Mail->CurrentValue = NULL;
		$this->Mail->OldValue = $this->Mail->CurrentValue;
		$this->Id_Turno->CurrentValue = NULL;
		$this->Id_Turno->OldValue = $this->Id_Turno->CurrentValue;
		$this->Fecha_Ingreso->CurrentValue = NULL;
		$this->Fecha_Ingreso->OldValue = $this->Fecha_Ingreso->CurrentValue;
		$this->Titulo->CurrentValue = NULL;
		$this->Titulo->OldValue = $this->Titulo->CurrentValue;
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
		// Apellido_Nombre

		$this->Apellido_Nombre->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellido_Nombre"]);
		if ($this->Apellido_Nombre->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator = @$_GET["z_Apellido_Nombre"];

		// DniRte
		$this->DniRte->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_DniRte"]);
		if ($this->DniRte->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->DniRte->AdvancedSearch->SearchOperator = @$_GET["z_DniRte"];

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Domicilio"]);
		if ($this->Domicilio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Domicilio->AdvancedSearch->SearchOperator = @$_GET["z_Domicilio"];

		// Telefono
		$this->Telefono->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Telefono"]);
		if ($this->Telefono->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Telefono->AdvancedSearch->SearchOperator = @$_GET["z_Telefono"];

		// Celular
		$this->Celular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Celular"]);
		if ($this->Celular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Celular->AdvancedSearch->SearchOperator = @$_GET["z_Celular"];

		// Mail
		$this->Mail->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Mail"]);
		if ($this->Mail->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Mail->AdvancedSearch->SearchOperator = @$_GET["z_Mail"];

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Turno"]);
		if ($this->Id_Turno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$_GET["z_Id_Turno"];

		// Fecha_Ingreso
		$this->Fecha_Ingreso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Ingreso"]);
		if ($this->Fecha_Ingreso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Ingreso->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Ingreso"];

		// Titulo
		$this->Titulo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Titulo"]);
		if ($this->Titulo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Titulo->AdvancedSearch->SearchOperator = @$_GET["z_Titulo"];

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
		if (!$this->Apellido_Nombre->FldIsDetailKey) {
			$this->Apellido_Nombre->setFormValue($objForm->GetValue("x_Apellido_Nombre"));
		}
		$this->Apellido_Nombre->setOldValue($objForm->GetValue("o_Apellido_Nombre"));
		if (!$this->DniRte->FldIsDetailKey) {
			$this->DniRte->setFormValue($objForm->GetValue("x_DniRte"));
		}
		$this->DniRte->setOldValue($objForm->GetValue("o_DniRte"));
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		$this->Domicilio->setOldValue($objForm->GetValue("o_Domicilio"));
		if (!$this->Telefono->FldIsDetailKey) {
			$this->Telefono->setFormValue($objForm->GetValue("x_Telefono"));
		}
		$this->Telefono->setOldValue($objForm->GetValue("o_Telefono"));
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		$this->Celular->setOldValue($objForm->GetValue("o_Celular"));
		if (!$this->Mail->FldIsDetailKey) {
			$this->Mail->setFormValue($objForm->GetValue("x_Mail"));
		}
		$this->Mail->setOldValue($objForm->GetValue("o_Mail"));
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
		}
		$this->Id_Turno->setOldValue($objForm->GetValue("o_Id_Turno"));
		if (!$this->Fecha_Ingreso->FldIsDetailKey) {
			$this->Fecha_Ingreso->setFormValue($objForm->GetValue("x_Fecha_Ingreso"));
			$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		}
		$this->Fecha_Ingreso->setOldValue($objForm->GetValue("o_Fecha_Ingreso"));
		if (!$this->Titulo->FldIsDetailKey) {
			$this->Titulo->setFormValue($objForm->GetValue("x_Titulo"));
		}
		$this->Titulo->setOldValue($objForm->GetValue("o_Titulo"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->setOldValue($objForm->GetValue("o_Fecha_Actualizacion"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Apellido_Nombre->CurrentValue = $this->Apellido_Nombre->FormValue;
		$this->DniRte->CurrentValue = $this->DniRte->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono->CurrentValue = $this->Telefono->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Mail->CurrentValue = $this->Mail->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Fecha_Ingreso->CurrentValue = $this->Fecha_Ingreso->FormValue;
		$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		$this->Titulo->CurrentValue = $this->Titulo->FormValue;
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
		$this->Apellido_Nombre->setDbValue($rs->fields('Apellido_Nombre'));
		$this->DniRte->setDbValue($rs->fields('DniRte'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Fecha_Ingreso->setDbValue($rs->fields('Fecha_Ingreso'));
		$this->Titulo->setDbValue($rs->fields('Titulo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apellido_Nombre->DbValue = $row['Apellido_Nombre'];
		$this->DniRte->DbValue = $row['DniRte'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Celular->DbValue = $row['Celular'];
		$this->Mail->DbValue = $row['Mail'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Fecha_Ingreso->DbValue = $row['Fecha_Ingreso'];
		$this->Titulo->DbValue = $row['Titulo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("DniRte")) <> "")
			$this->DniRte->CurrentValue = $this->getKey("DniRte"); // DniRte
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
		// Apellido_Nombre
		// DniRte
		// Domicilio
		// Telefono
		// Celular
		// Mail
		// Id_Turno
		// Fecha_Ingreso
		// Titulo
		// Usuario
		// Fecha_Actualizacion
		// Cue

		$this->Cue->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// DniRte
		$this->DniRte->ViewValue = $this->DniRte->CurrentValue;
		$this->DniRte->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
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

		// Fecha_Ingreso
		$this->Fecha_Ingreso->ViewValue = $this->Fecha_Ingreso->CurrentValue;
		$this->Fecha_Ingreso->ViewValue = ew_FormatDateTime($this->Fecha_Ingreso->ViewValue, 2);
		$this->Fecha_Ingreso->ViewCustomAttributes = "";

		// Titulo
		$this->Titulo->ViewValue = $this->Titulo->CurrentValue;
		$this->Titulo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";
			$this->DniRte->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";
			$this->Mail->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";
			$this->Fecha_Ingreso->TooltipValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";
			$this->Titulo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = ew_HtmlEncode($this->DniRte->CurrentValue);
			$this->DniRte->PlaceHolder = ew_RemoveHtml($this->DniRte->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

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

			// Mail
			$this->Mail->EditAttrs["class"] = "form-control";
			$this->Mail->EditCustomAttributes = "";
			$this->Mail->EditValue = ew_HtmlEncode($this->Mail->CurrentValue);
			$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Fecha_Ingreso
			$this->Fecha_Ingreso->EditAttrs["class"] = "form-control";
			$this->Fecha_Ingreso->EditCustomAttributes = "";
			$this->Fecha_Ingreso->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Ingreso->CurrentValue, 2));
			$this->Fecha_Ingreso->PlaceHolder = ew_RemoveHtml($this->Fecha_Ingreso->FldCaption());

			// Titulo
			$this->Titulo->EditAttrs["class"] = "form-control";
			$this->Titulo->EditCustomAttributes = "";
			$this->Titulo->EditValue = ew_HtmlEncode($this->Titulo->CurrentValue);
			$this->Titulo->PlaceHolder = ew_RemoveHtml($this->Titulo->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = $this->DniRte->CurrentValue;
			$this->DniRte->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

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

			// Mail
			$this->Mail->EditAttrs["class"] = "form-control";
			$this->Mail->EditCustomAttributes = "";
			$this->Mail->EditValue = ew_HtmlEncode($this->Mail->CurrentValue);
			$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Fecha_Ingreso
			$this->Fecha_Ingreso->EditAttrs["class"] = "form-control";
			$this->Fecha_Ingreso->EditCustomAttributes = "";
			$this->Fecha_Ingreso->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Ingreso->CurrentValue, 2));
			$this->Fecha_Ingreso->PlaceHolder = ew_RemoveHtml($this->Fecha_Ingreso->FldCaption());

			// Titulo
			$this->Titulo->EditAttrs["class"] = "form-control";
			$this->Titulo->EditCustomAttributes = "";
			$this->Titulo->EditValue = ew_HtmlEncode($this->Titulo->CurrentValue);
			$this->Titulo->PlaceHolder = ew_RemoveHtml($this->Titulo->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";

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
		if (!$this->Apellido_Nombre->FldIsDetailKey && !is_null($this->Apellido_Nombre->FormValue) && $this->Apellido_Nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellido_Nombre->FldCaption(), $this->Apellido_Nombre->ReqErrMsg));
		}
		if (!$this->DniRte->FldIsDetailKey && !is_null($this->DniRte->FormValue) && $this->DniRte->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DniRte->FldCaption(), $this->DniRte->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->DniRte->FormValue)) {
			ew_AddMessage($gsFormError, $this->DniRte->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Telefono->FormValue)) {
			ew_AddMessage($gsFormError, $this->Telefono->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Celular->FormValue)) {
			ew_AddMessage($gsFormError, $this->Celular->FldErrMsg());
		}
		if (!$this->Mail->FldIsDetailKey && !is_null($this->Mail->FormValue) && $this->Mail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Mail->FldCaption(), $this->Mail->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->Mail->FormValue)) {
			ew_AddMessage($gsFormError, $this->Mail->FldErrMsg());
		}
		if (!$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Fecha_Ingreso->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Ingreso->FldErrMsg());
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
				$sThisKey .= $row['DniRte'];
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

			// Apellido_Nombre
			$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, $this->Apellido_Nombre->ReadOnly);

			// DniRte
			// Domicilio

			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly);

			// Telefono
			$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, $this->Telefono->ReadOnly);

			// Celular
			$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, $this->Celular->ReadOnly);

			// Mail
			$this->Mail->SetDbValueDef($rsnew, $this->Mail->CurrentValue, NULL, $this->Mail->ReadOnly);

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly);

			// Fecha_Ingreso
			$this->Fecha_Ingreso->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2), NULL, $this->Fecha_Ingreso->ReadOnly);

			// Titulo
			$this->Titulo->SetDbValueDef($rsnew, $this->Titulo->CurrentValue, NULL, $this->Titulo->ReadOnly);

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

		// Apellido_Nombre
		$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, FALSE);

		// DniRte
		$this->DniRte->SetDbValueDef($rsnew, $this->DniRte->CurrentValue, 0, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Telefono
		$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Mail
		$this->Mail->SetDbValueDef($rsnew, $this->Mail->CurrentValue, NULL, FALSE);

		// Id_Turno
		$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, FALSE);

		// Fecha_Ingreso
		$this->Fecha_Ingreso->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2), NULL, FALSE);

		// Titulo
		$this->Titulo->SetDbValueDef($rsnew, $this->Titulo->CurrentValue, NULL, FALSE);

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Cue
		if ($this->Cue->getSessionValue() <> "") {
			$rsnew['Cue'] = $this->Cue->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['DniRte']) == "") {
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
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Apellido_Nombre->AdvancedSearch->Load();
		$this->DniRte->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Mail->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Fecha_Ingreso->AdvancedSearch->Load();
		$this->Titulo->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_referente_tecnico\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_referente_tecnico',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.freferente_tecnicolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'referente_tecnico';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['DniRte'];

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
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['DniRte'];

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
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['DniRte'];

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
if (!isset($referente_tecnico_list)) $referente_tecnico_list = new creferente_tecnico_list();

// Page init
$referente_tecnico_list->Page_Init();

// Page main
$referente_tecnico_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($referente_tecnico->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = freferente_tecnicolist = new ew_Form("freferente_tecnicolist", "list");
freferente_tecnicolist.FormKeyCountName = '<?php echo $referente_tecnico_list->FormKeyCountName ?>';

// Validate form
freferente_tecnicolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellido_Nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Apellido_Nombre->FldCaption(), $referente_tecnico->Apellido_Nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->DniRte->FldCaption(), $referente_tecnico->DniRte->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->DniRte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Telefono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Celular");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Celular->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Mail->FldCaption(), $referente_tecnico->Mail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Mail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Id_Turno->FldCaption(), $referente_tecnico->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Ingreso");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Fecha_Ingreso->FldErrMsg()) ?>");

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
freferente_tecnicolist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Apellido_Nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "DniRte", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Domicilio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Telefono", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Celular", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Mail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Ingreso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Titulo", false)) return false;
	return true;
}

// Form_CustomValidate event
freferente_tecnicolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicolist.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicolist.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
var CurrentSearchForm = freferente_tecnicolistsrch = new ew_Form("freferente_tecnicolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($referente_tecnico->Export == "") { ?>
<div class="ewToolbar">
<?php if ($referente_tecnico->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($referente_tecnico_list->TotalRecs > 0 && $referente_tecnico_list->ExportOptions->Visible()) { ?>
<?php $referente_tecnico_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($referente_tecnico_list->SearchOptions->Visible()) { ?>
<?php $referente_tecnico_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($referente_tecnico_list->FilterOptions->Visible()) { ?>
<?php $referente_tecnico_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($referente_tecnico->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($referente_tecnico->Export == "") || (EW_EXPORT_MASTER_RECORD && $referente_tecnico->Export == "print")) { ?>
<?php
if ($referente_tecnico_list->DbMasterFilter <> "" && $referente_tecnico->getCurrentMasterTable() == "dato_establecimiento") {
	if ($referente_tecnico_list->MasterRecordExists) {
?>
<?php include_once "dato_establecimientomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($referente_tecnico->CurrentAction == "gridadd") {
	$referente_tecnico->CurrentFilter = "0=1";
	$referente_tecnico_list->StartRec = 1;
	$referente_tecnico_list->DisplayRecs = $referente_tecnico->GridAddRowCount;
	$referente_tecnico_list->TotalRecs = $referente_tecnico_list->DisplayRecs;
	$referente_tecnico_list->StopRec = $referente_tecnico_list->DisplayRecs;
} else {
	$bSelectLimit = $referente_tecnico_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($referente_tecnico_list->TotalRecs <= 0)
			$referente_tecnico_list->TotalRecs = $referente_tecnico->SelectRecordCount();
	} else {
		if (!$referente_tecnico_list->Recordset && ($referente_tecnico_list->Recordset = $referente_tecnico_list->LoadRecordset()))
			$referente_tecnico_list->TotalRecs = $referente_tecnico_list->Recordset->RecordCount();
	}
	$referente_tecnico_list->StartRec = 1;
	if ($referente_tecnico_list->DisplayRecs <= 0 || ($referente_tecnico->Export <> "" && $referente_tecnico->ExportAll)) // Display all records
		$referente_tecnico_list->DisplayRecs = $referente_tecnico_list->TotalRecs;
	if (!($referente_tecnico->Export <> "" && $referente_tecnico->ExportAll))
		$referente_tecnico_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$referente_tecnico_list->Recordset = $referente_tecnico_list->LoadRecordset($referente_tecnico_list->StartRec-1, $referente_tecnico_list->DisplayRecs);

	// Set no record found message
	if ($referente_tecnico->CurrentAction == "" && $referente_tecnico_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$referente_tecnico_list->setWarningMessage(ew_DeniedMsg());
		if ($referente_tecnico_list->SearchWhere == "0=101")
			$referente_tecnico_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$referente_tecnico_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($referente_tecnico_list->AuditTrailOnSearch && $referente_tecnico_list->Command == "search" && !$referente_tecnico_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $referente_tecnico_list->getSessionWhere();
		$referente_tecnico_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$referente_tecnico_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($referente_tecnico->Export == "" && $referente_tecnico->CurrentAction == "") { ?>
<form name="freferente_tecnicolistsrch" id="freferente_tecnicolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($referente_tecnico_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="freferente_tecnicolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="referente_tecnico">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($referente_tecnico_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($referente_tecnico_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $referente_tecnico_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($referente_tecnico_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($referente_tecnico_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($referente_tecnico_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($referente_tecnico_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $referente_tecnico_list->ShowPageHeader(); ?>
<?php
$referente_tecnico_list->ShowMessage();
?>
<?php if ($referente_tecnico_list->TotalRecs > 0 || $referente_tecnico->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid referente_tecnico">
<?php if ($referente_tecnico->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($referente_tecnico->CurrentAction <> "gridadd" && $referente_tecnico->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($referente_tecnico_list->Pager)) $referente_tecnico_list->Pager = new cPrevNextPager($referente_tecnico_list->StartRec, $referente_tecnico_list->DisplayRecs, $referente_tecnico_list->TotalRecs) ?>
<?php if ($referente_tecnico_list->Pager->RecordCount > 0 && $referente_tecnico_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($referente_tecnico_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($referente_tecnico_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $referente_tecnico_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($referente_tecnico_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($referente_tecnico_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($referente_tecnico_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="freferente_tecnicolist" id="freferente_tecnicolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referente_tecnico_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referente_tecnico_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referente_tecnico">
<?php if ($referente_tecnico->getCurrentMasterTable() == "dato_establecimiento" && $referente_tecnico->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $referente_tecnico->Cue->getSessionValue() ?>">
<?php } ?>
<div id="gmp_referente_tecnico" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($referente_tecnico_list->TotalRecs > 0 || $referente_tecnico->CurrentAction == "add" || $referente_tecnico->CurrentAction == "copy") { ?>
<table id="tbl_referente_tecnicolist" class="table ewTable">
<?php echo $referente_tecnico->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$referente_tecnico_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$referente_tecnico_list->RenderListOptions();

// Render list options (header, left)
$referente_tecnico_list->ListOptions->Render("header", "left");
?>
<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Apellido_Nombre) == "") { ?>
		<th data-name="Apellido_Nombre"><div id="elh_referente_tecnico_Apellido_Nombre" class="referente_tecnico_Apellido_Nombre"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Apellido_Nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_Nombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Apellido_Nombre) ?>',1);"><div id="elh_referente_tecnico_Apellido_Nombre" class="referente_tecnico_Apellido_Nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Apellido_Nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Apellido_Nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Apellido_Nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->DniRte) == "") { ?>
		<th data-name="DniRte"><div id="elh_referente_tecnico_DniRte" class="referente_tecnico_DniRte"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->DniRte->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DniRte"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->DniRte) ?>',1);"><div id="elh_referente_tecnico_DniRte" class="referente_tecnico_DniRte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->DniRte->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->DniRte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->DniRte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Domicilio) == "") { ?>
		<th data-name="Domicilio"><div id="elh_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Domicilio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Domicilio) ?>',1);"><div id="elh_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Domicilio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Domicilio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_referente_tecnico_Telefono" class="referente_tecnico_Telefono"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Telefono) ?>',1);"><div id="elh_referente_tecnico_Telefono" class="referente_tecnico_Telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Telefono->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Celular) == "") { ?>
		<th data-name="Celular"><div id="elh_referente_tecnico_Celular" class="referente_tecnico_Celular"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Celular->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Celular"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Celular) ?>',1);"><div id="elh_referente_tecnico_Celular" class="referente_tecnico_Celular">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Celular->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Celular->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Celular->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Mail) == "") { ?>
		<th data-name="Mail"><div id="elh_referente_tecnico_Mail" class="referente_tecnico_Mail"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Mail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Mail"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Mail) ?>',1);"><div id="elh_referente_tecnico_Mail" class="referente_tecnico_Mail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Mail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Mail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Mail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Id_Turno) ?>',1);"><div id="elh_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Fecha_Ingreso) == "") { ?>
		<th data-name="Fecha_Ingreso"><div id="elh_referente_tecnico_Fecha_Ingreso" class="referente_tecnico_Fecha_Ingreso"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Ingreso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Ingreso"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Fecha_Ingreso) ?>',1);"><div id="elh_referente_tecnico_Fecha_Ingreso" class="referente_tecnico_Fecha_Ingreso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Ingreso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Fecha_Ingreso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Fecha_Ingreso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Titulo) == "") { ?>
		<th data-name="Titulo"><div id="elh_referente_tecnico_Titulo" class="referente_tecnico_Titulo"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Titulo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Titulo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Titulo) ?>',1);"><div id="elh_referente_tecnico_Titulo" class="referente_tecnico_Titulo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Titulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Titulo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Titulo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_referente_tecnico_Usuario" class="referente_tecnico_Usuario"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Usuario) ?>',1);"><div id="elh_referente_tecnico_Usuario" class="referente_tecnico_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $referente_tecnico->SortUrl($referente_tecnico->Fecha_Actualizacion) ?>',1);"><div id="elh_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$referente_tecnico_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($referente_tecnico->CurrentAction == "add" || $referente_tecnico->CurrentAction == "copy") {
		$referente_tecnico_list->RowIndex = 0;
		$referente_tecnico_list->KeyCount = $referente_tecnico_list->RowIndex;
		if ($referente_tecnico->CurrentAction == "add")
			$referente_tecnico_list->LoadDefaultValues();
		if ($referente_tecnico->EventCancelled) // Insert failed
			$referente_tecnico_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$referente_tecnico->ResetAttrs();
		$referente_tecnico->RowAttrs = array_merge($referente_tecnico->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_referente_tecnico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$referente_tecnico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$referente_tecnico_list->RenderRow();

		// Render list options
		$referente_tecnico_list->RenderListOptions();
		$referente_tecnico_list->StartRowCnt = 0;
?>
	<tr<?php echo $referente_tecnico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$referente_tecnico_list->ListOptions->Render("body", "left", $referente_tecnico_list->RowCnt);
?>
	<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Apellido_Nombre" class="form-group referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
		<td data-name="DniRte">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
		<td data-name="Celular">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
		<td data-name="Mail">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
		<td data-name="Fecha_Ingreso">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Fecha_Ingreso" class="form-group referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicolist", "x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
		<td data-name="Titulo">
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Titulo" class="form-group referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Titulo" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" value="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$referente_tecnico_list->ListOptions->Render("body", "right", $referente_tecnico_list->RowCnt);
?>
<script type="text/javascript">
freferente_tecnicolist.UpdateOpts(<?php echo $referente_tecnico_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($referente_tecnico->ExportAll && $referente_tecnico->Export <> "") {
	$referente_tecnico_list->StopRec = $referente_tecnico_list->TotalRecs;
} else {

	// Set the last record to display
	if ($referente_tecnico_list->TotalRecs > $referente_tecnico_list->StartRec + $referente_tecnico_list->DisplayRecs - 1)
		$referente_tecnico_list->StopRec = $referente_tecnico_list->StartRec + $referente_tecnico_list->DisplayRecs - 1;
	else
		$referente_tecnico_list->StopRec = $referente_tecnico_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($referente_tecnico_list->FormKeyCountName) && ($referente_tecnico->CurrentAction == "gridadd" || $referente_tecnico->CurrentAction == "gridedit" || $referente_tecnico->CurrentAction == "F")) {
		$referente_tecnico_list->KeyCount = $objForm->GetValue($referente_tecnico_list->FormKeyCountName);
		$referente_tecnico_list->StopRec = $referente_tecnico_list->StartRec + $referente_tecnico_list->KeyCount - 1;
	}
}
$referente_tecnico_list->RecCnt = $referente_tecnico_list->StartRec - 1;
if ($referente_tecnico_list->Recordset && !$referente_tecnico_list->Recordset->EOF) {
	$referente_tecnico_list->Recordset->MoveFirst();
	$bSelectLimit = $referente_tecnico_list->UseSelectLimit;
	if (!$bSelectLimit && $referente_tecnico_list->StartRec > 1)
		$referente_tecnico_list->Recordset->Move($referente_tecnico_list->StartRec - 1);
} elseif (!$referente_tecnico->AllowAddDeleteRow && $referente_tecnico_list->StopRec == 0) {
	$referente_tecnico_list->StopRec = $referente_tecnico->GridAddRowCount;
}

// Initialize aggregate
$referente_tecnico->RowType = EW_ROWTYPE_AGGREGATEINIT;
$referente_tecnico->ResetAttrs();
$referente_tecnico_list->RenderRow();
$referente_tecnico_list->EditRowCnt = 0;
if ($referente_tecnico->CurrentAction == "edit")
	$referente_tecnico_list->RowIndex = 1;
if ($referente_tecnico->CurrentAction == "gridadd")
	$referente_tecnico_list->RowIndex = 0;
if ($referente_tecnico->CurrentAction == "gridedit")
	$referente_tecnico_list->RowIndex = 0;
while ($referente_tecnico_list->RecCnt < $referente_tecnico_list->StopRec) {
	$referente_tecnico_list->RecCnt++;
	if (intval($referente_tecnico_list->RecCnt) >= intval($referente_tecnico_list->StartRec)) {
		$referente_tecnico_list->RowCnt++;
		if ($referente_tecnico->CurrentAction == "gridadd" || $referente_tecnico->CurrentAction == "gridedit" || $referente_tecnico->CurrentAction == "F") {
			$referente_tecnico_list->RowIndex++;
			$objForm->Index = $referente_tecnico_list->RowIndex;
			if ($objForm->HasValue($referente_tecnico_list->FormActionName))
				$referente_tecnico_list->RowAction = strval($objForm->GetValue($referente_tecnico_list->FormActionName));
			elseif ($referente_tecnico->CurrentAction == "gridadd")
				$referente_tecnico_list->RowAction = "insert";
			else
				$referente_tecnico_list->RowAction = "";
		}

		// Set up key count
		$referente_tecnico_list->KeyCount = $referente_tecnico_list->RowIndex;

		// Init row class and style
		$referente_tecnico->ResetAttrs();
		$referente_tecnico->CssClass = "";
		if ($referente_tecnico->CurrentAction == "gridadd") {
			$referente_tecnico_list->LoadDefaultValues(); // Load default values
		} else {
			$referente_tecnico_list->LoadRowValues($referente_tecnico_list->Recordset); // Load row values
		}
		$referente_tecnico->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($referente_tecnico->CurrentAction == "gridadd") // Grid add
			$referente_tecnico->RowType = EW_ROWTYPE_ADD; // Render add
		if ($referente_tecnico->CurrentAction == "gridadd" && $referente_tecnico->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$referente_tecnico_list->RestoreCurrentRowFormValues($referente_tecnico_list->RowIndex); // Restore form values
		if ($referente_tecnico->CurrentAction == "edit") {
			if ($referente_tecnico_list->CheckInlineEditKey() && $referente_tecnico_list->EditRowCnt == 0) { // Inline edit
				$referente_tecnico->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($referente_tecnico->CurrentAction == "gridedit") { // Grid edit
			if ($referente_tecnico->EventCancelled) {
				$referente_tecnico_list->RestoreCurrentRowFormValues($referente_tecnico_list->RowIndex); // Restore form values
			}
			if ($referente_tecnico_list->RowAction == "insert")
				$referente_tecnico->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$referente_tecnico->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($referente_tecnico->CurrentAction == "edit" && $referente_tecnico->RowType == EW_ROWTYPE_EDIT && $referente_tecnico->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$referente_tecnico_list->RestoreFormValues(); // Restore form values
		}
		if ($referente_tecnico->CurrentAction == "gridedit" && ($referente_tecnico->RowType == EW_ROWTYPE_EDIT || $referente_tecnico->RowType == EW_ROWTYPE_ADD) && $referente_tecnico->EventCancelled) // Update failed
			$referente_tecnico_list->RestoreCurrentRowFormValues($referente_tecnico_list->RowIndex); // Restore form values
		if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) // Edit row
			$referente_tecnico_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$referente_tecnico->RowAttrs = array_merge($referente_tecnico->RowAttrs, array('data-rowindex'=>$referente_tecnico_list->RowCnt, 'id'=>'r' . $referente_tecnico_list->RowCnt . '_referente_tecnico', 'data-rowtype'=>$referente_tecnico->RowType));

		// Render row
		$referente_tecnico_list->RenderRow();

		// Render list options
		$referente_tecnico_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($referente_tecnico_list->RowAction <> "delete" && $referente_tecnico_list->RowAction <> "insertdelete" && !($referente_tecnico_list->RowAction == "insert" && $referente_tecnico->CurrentAction == "F" && $referente_tecnico_list->EmptyRow())) {
?>
	<tr<?php echo $referente_tecnico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$referente_tecnico_list->ListOptions->Render("body", "left", $referente_tecnico_list->RowCnt);
?>
	<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre"<?php echo $referente_tecnico->Apellido_Nombre->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Apellido_Nombre" class="form-group referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Apellido_Nombre" class="form-group referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Apellido_Nombre" class="referente_tecnico_Apellido_Nombre">
<span<?php echo $referente_tecnico->Apellido_Nombre->ViewAttributes() ?>>
<?php echo $referente_tecnico->Apellido_Nombre->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $referente_tecnico_list->PageObjName . "_row_" . $referente_tecnico_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
		<td data-name="DniRte"<?php echo $referente_tecnico->DniRte->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->DniRte->EditValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->CurrentValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_DniRte" class="referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<?php echo $referente_tecnico->DniRte->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio"<?php echo $referente_tecnico->Domicilio->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio">
<span<?php echo $referente_tecnico->Domicilio->ViewAttributes() ?>>
<?php echo $referente_tecnico->Domicilio->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $referente_tecnico->Telefono->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Telefono" class="referente_tecnico_Telefono">
<span<?php echo $referente_tecnico->Telefono->ViewAttributes() ?>>
<?php echo $referente_tecnico->Telefono->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
		<td data-name="Celular"<?php echo $referente_tecnico->Celular->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Celular" class="referente_tecnico_Celular">
<span<?php echo $referente_tecnico->Celular->ViewAttributes() ?>>
<?php echo $referente_tecnico->Celular->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
		<td data-name="Mail"<?php echo $referente_tecnico->Mail->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Mail" class="referente_tecnico_Mail">
<span<?php echo $referente_tecnico->Mail->ViewAttributes() ?>>
<?php echo $referente_tecnico->Mail->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $referente_tecnico->Id_Turno->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno">
<span<?php echo $referente_tecnico->Id_Turno->ViewAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
		<td data-name="Fecha_Ingreso"<?php echo $referente_tecnico->Fecha_Ingreso->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Fecha_Ingreso" class="form-group referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicolist", "x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Fecha_Ingreso" class="form-group referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicolist", "x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Fecha_Ingreso" class="referente_tecnico_Fecha_Ingreso">
<span<?php echo $referente_tecnico->Fecha_Ingreso->ViewAttributes() ?>>
<?php echo $referente_tecnico->Fecha_Ingreso->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
		<td data-name="Titulo"<?php echo $referente_tecnico->Titulo->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Titulo" class="form-group referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Titulo" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" value="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Titulo" class="form-group referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Titulo" class="referente_tecnico_Titulo">
<span<?php echo $referente_tecnico->Titulo->ViewAttributes() ?>>
<?php echo $referente_tecnico->Titulo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $referente_tecnico->Usuario->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Usuario" class="referente_tecnico_Usuario">
<span<?php echo $referente_tecnico->Usuario->ViewAttributes() ?>>
<?php echo $referente_tecnico->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $referente_tecnico->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_list->RowCnt ?>_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion">
<span<?php echo $referente_tecnico->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $referente_tecnico->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$referente_tecnico_list->ListOptions->Render("body", "right", $referente_tecnico_list->RowCnt);
?>
	</tr>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD || $referente_tecnico->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
freferente_tecnicolist.UpdateOpts(<?php echo $referente_tecnico_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($referente_tecnico->CurrentAction <> "gridadd")
		if (!$referente_tecnico_list->Recordset->EOF) $referente_tecnico_list->Recordset->MoveNext();
}
?>
<?php
	if ($referente_tecnico->CurrentAction == "gridadd" || $referente_tecnico->CurrentAction == "gridedit") {
		$referente_tecnico_list->RowIndex = '$rowindex$';
		$referente_tecnico_list->LoadDefaultValues();

		// Set row properties
		$referente_tecnico->ResetAttrs();
		$referente_tecnico->RowAttrs = array_merge($referente_tecnico->RowAttrs, array('data-rowindex'=>$referente_tecnico_list->RowIndex, 'id'=>'r0_referente_tecnico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($referente_tecnico->RowAttrs["class"], "ewTemplate");
		$referente_tecnico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$referente_tecnico_list->RenderRow();

		// Render list options
		$referente_tecnico_list->RenderListOptions();
		$referente_tecnico_list->StartRowCnt = 0;
?>
	<tr<?php echo $referente_tecnico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$referente_tecnico_list->ListOptions->Render("body", "left", $referente_tecnico_list->RowIndex);
?>
	<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre">
<span id="el$rowindex$_referente_tecnico_Apellido_Nombre" class="form-group referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
		<td data-name="DniRte">
<span id="el$rowindex$_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_list->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio">
<span id="el$rowindex$_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono">
<span id="el$rowindex$_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
		<td data-name="Celular">
<span id="el$rowindex$_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
		<td data-name="Mail">
<span id="el$rowindex$_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<span id="el$rowindex$_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
		<td data-name="Fecha_Ingreso">
<span id="el$rowindex$_referente_tecnico_Fecha_Ingreso" class="form-group referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicolist", "x<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Ingreso" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
		<td data-name="Titulo">
<span id="el$rowindex$_referente_tecnico_Titulo" class="form-group referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="x<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Titulo" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Titulo" value="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$referente_tecnico_list->ListOptions->Render("body", "right", $referente_tecnico_list->RowCnt);
?>
<script type="text/javascript">
freferente_tecnicolist.UpdateOpts(<?php echo $referente_tecnico_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($referente_tecnico->CurrentAction == "add" || $referente_tecnico->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $referente_tecnico_list->FormKeyCountName ?>" id="<?php echo $referente_tecnico_list->FormKeyCountName ?>" value="<?php echo $referente_tecnico_list->KeyCount ?>">
<?php } ?>
<?php if ($referente_tecnico->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $referente_tecnico_list->FormKeyCountName ?>" id="<?php echo $referente_tecnico_list->FormKeyCountName ?>" value="<?php echo $referente_tecnico_list->KeyCount ?>">
<?php echo $referente_tecnico_list->MultiSelectKey ?>
<?php } ?>
<?php if ($referente_tecnico->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $referente_tecnico_list->FormKeyCountName ?>" id="<?php echo $referente_tecnico_list->FormKeyCountName ?>" value="<?php echo $referente_tecnico_list->KeyCount ?>">
<?php } ?>
<?php if ($referente_tecnico->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $referente_tecnico_list->FormKeyCountName ?>" id="<?php echo $referente_tecnico_list->FormKeyCountName ?>" value="<?php echo $referente_tecnico_list->KeyCount ?>">
<?php echo $referente_tecnico_list->MultiSelectKey ?>
<?php } ?>
<?php if ($referente_tecnico->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($referente_tecnico_list->Recordset)
	$referente_tecnico_list->Recordset->Close();
?>
<?php if ($referente_tecnico->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($referente_tecnico->CurrentAction <> "gridadd" && $referente_tecnico->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($referente_tecnico_list->Pager)) $referente_tecnico_list->Pager = new cPrevNextPager($referente_tecnico_list->StartRec, $referente_tecnico_list->DisplayRecs, $referente_tecnico_list->TotalRecs) ?>
<?php if ($referente_tecnico_list->Pager->RecordCount > 0 && $referente_tecnico_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($referente_tecnico_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($referente_tecnico_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $referente_tecnico_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($referente_tecnico_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($referente_tecnico_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $referente_tecnico_list->PageUrl() ?>start=<?php echo $referente_tecnico_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $referente_tecnico_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($referente_tecnico_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($referente_tecnico_list->TotalRecs == 0 && $referente_tecnico->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($referente_tecnico_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($referente_tecnico->Export == "") { ?>
<script type="text/javascript">
freferente_tecnicolistsrch.FilterList = <?php echo $referente_tecnico_list->GetFilterList() ?>;
freferente_tecnicolistsrch.Init();
freferente_tecnicolist.Init();
</script>
<?php } ?>
<?php
$referente_tecnico_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($referente_tecnico->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$referente_tecnico_list->Page_Terminate();
?>
