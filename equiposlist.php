<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "equiposinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "observacion_equipogridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$equipos_list = NULL; // Initialize page object first

class cequipos_list extends cequipos {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'equipos';

	// Page object name
	var $PageObjName = 'equipos_list';

	// Grid form hidden field names
	var $FormName = 'fequiposlist';
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

		// Table object (equipos)
		if (!isset($GLOBALS["equipos"]) || get_class($GLOBALS["equipos"]) == "cequipos") {
			$GLOBALS["equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["equipos"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "equiposadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "equiposdelete.php";
		$this->MultiUpdateUrl = "equiposupdate.php";

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'equipos', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fequiposlistsrch";

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
		$this->NroSerie->SetVisibility();
		$this->NroMac->SetVisibility();
		$this->Id_Ubicacion->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Sit_Estado->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_Ano->SetVisibility();
		$this->Id_Tipo_Equipo->SetVisibility();
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

			// Process auto fill for detail table 'observacion_equipo'
			if (@$_POST["grid"] == "fobservacion_equipogrid") {
				if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;
				$GLOBALS["observacion_equipo_grid"]->Page_Init();
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
		global $EW_EXPORT, $equipos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($equipos);
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
	var $observacion_equipo_Count;
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "personas") {
			global $personas;
			$rsmaster = $personas->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("personaslist.php"); // Return to master page
			} else {
				$personas->LoadListRowValues($rsmaster);
				$personas->RowType = EW_ROWTYPE_MASTER; // Master row
				$personas->RenderListRow();
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
		$this->setKey("NroSerie", ""); // Clear inline edit key
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
		if (@$_GET["NroSerie"] <> "") {
			$this->NroSerie->setQueryStringValue($_GET["NroSerie"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("NroSerie", $this->NroSerie->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("NroSerie")) <> strval($this->NroSerie->CurrentValue))
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
			$this->NroSerie->setFormValue($arrKeyFlds[0]);
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
					$sKey .= $this->NroSerie->CurrentValue;

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
		if ($objForm->HasValue("x_NroSerie") && $objForm->HasValue("o_NroSerie") && $this->NroSerie->CurrentValue <> $this->NroSerie->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NroMac") && $objForm->HasValue("o_NroMac") && $this->NroMac->CurrentValue <> $this->NroMac->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Ubicacion") && $objForm->HasValue("o_Id_Ubicacion") && $this->Id_Ubicacion->CurrentValue <> $this->Id_Ubicacion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Estado") && $objForm->HasValue("o_Id_Estado") && $this->Id_Estado->CurrentValue <> $this->Id_Estado->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Sit_Estado") && $objForm->HasValue("o_Id_Sit_Estado") && $this->Id_Sit_Estado->CurrentValue <> $this->Id_Sit_Estado->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Marca") && $objForm->HasValue("o_Id_Marca") && $this->Id_Marca->CurrentValue <> $this->Id_Marca->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Modelo") && $objForm->HasValue("o_Id_Modelo") && $this->Id_Modelo->CurrentValue <> $this->Id_Modelo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Ano") && $objForm->HasValue("o_Id_Ano") && $this->Id_Ano->CurrentValue <> $this->Id_Ano->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Tipo_Equipo") && $objForm->HasValue("o_Id_Tipo_Equipo") && $this->Id_Tipo_Equipo->CurrentValue <> $this->Id_Tipo_Equipo->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fequiposlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->NroSerie->AdvancedSearch->ToJSON(), ","); // Field NroSerie
		$sFilterList = ew_Concat($sFilterList, $this->NroMac->AdvancedSearch->ToJSON(), ","); // Field NroMac
		$sFilterList = ew_Concat($sFilterList, $this->SpecialNumber->AdvancedSearch->ToJSON(), ","); // Field SpecialNumber
		$sFilterList = ew_Concat($sFilterList, $this->Id_Ubicacion->AdvancedSearch->ToJSON(), ","); // Field Id_Ubicacion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado->AdvancedSearch->ToJSON(), ","); // Field Id_Estado
		$sFilterList = ew_Concat($sFilterList, $this->Id_Sit_Estado->AdvancedSearch->ToJSON(), ","); // Field Id_Sit_Estado
		$sFilterList = ew_Concat($sFilterList, $this->Id_Marca->AdvancedSearch->ToJSON(), ","); // Field Id_Marca
		$sFilterList = ew_Concat($sFilterList, $this->Id_Modelo->AdvancedSearch->ToJSON(), ","); // Field Id_Modelo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Ano->AdvancedSearch->ToJSON(), ","); // Field Id_Ano
		$sFilterList = ew_Concat($sFilterList, $this->Tiene_Cargador->AdvancedSearch->ToJSON(), ","); // Field Tiene_Cargador
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Equipo->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Equipo
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fequiposlistsrch", $filters);
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

		// Field NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = @$filter["x_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator = @$filter["z_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchCondition = @$filter["v_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchValue2 = @$filter["y_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator2 = @$filter["w_NroSerie"];
		$this->NroSerie->AdvancedSearch->Save();

		// Field NroMac
		$this->NroMac->AdvancedSearch->SearchValue = @$filter["x_NroMac"];
		$this->NroMac->AdvancedSearch->SearchOperator = @$filter["z_NroMac"];
		$this->NroMac->AdvancedSearch->SearchCondition = @$filter["v_NroMac"];
		$this->NroMac->AdvancedSearch->SearchValue2 = @$filter["y_NroMac"];
		$this->NroMac->AdvancedSearch->SearchOperator2 = @$filter["w_NroMac"];
		$this->NroMac->AdvancedSearch->Save();

		// Field SpecialNumber
		$this->SpecialNumber->AdvancedSearch->SearchValue = @$filter["x_SpecialNumber"];
		$this->SpecialNumber->AdvancedSearch->SearchOperator = @$filter["z_SpecialNumber"];
		$this->SpecialNumber->AdvancedSearch->SearchCondition = @$filter["v_SpecialNumber"];
		$this->SpecialNumber->AdvancedSearch->SearchValue2 = @$filter["y_SpecialNumber"];
		$this->SpecialNumber->AdvancedSearch->SearchOperator2 = @$filter["w_SpecialNumber"];
		$this->SpecialNumber->AdvancedSearch->Save();

		// Field Id_Ubicacion
		$this->Id_Ubicacion->AdvancedSearch->SearchValue = @$filter["x_Id_Ubicacion"];
		$this->Id_Ubicacion->AdvancedSearch->SearchOperator = @$filter["z_Id_Ubicacion"];
		$this->Id_Ubicacion->AdvancedSearch->SearchCondition = @$filter["v_Id_Ubicacion"];
		$this->Id_Ubicacion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Ubicacion"];
		$this->Id_Ubicacion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Ubicacion"];
		$this->Id_Ubicacion->AdvancedSearch->Save();

		// Field Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = @$filter["x_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->Save();

		// Field Id_Sit_Estado
		$this->Id_Sit_Estado->AdvancedSearch->SearchValue = @$filter["x_Id_Sit_Estado"];
		$this->Id_Sit_Estado->AdvancedSearch->SearchOperator = @$filter["z_Id_Sit_Estado"];
		$this->Id_Sit_Estado->AdvancedSearch->SearchCondition = @$filter["v_Id_Sit_Estado"];
		$this->Id_Sit_Estado->AdvancedSearch->SearchValue2 = @$filter["y_Id_Sit_Estado"];
		$this->Id_Sit_Estado->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Sit_Estado"];
		$this->Id_Sit_Estado->AdvancedSearch->Save();

		// Field Id_Marca
		$this->Id_Marca->AdvancedSearch->SearchValue = @$filter["x_Id_Marca"];
		$this->Id_Marca->AdvancedSearch->SearchOperator = @$filter["z_Id_Marca"];
		$this->Id_Marca->AdvancedSearch->SearchCondition = @$filter["v_Id_Marca"];
		$this->Id_Marca->AdvancedSearch->SearchValue2 = @$filter["y_Id_Marca"];
		$this->Id_Marca->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Marca"];
		$this->Id_Marca->AdvancedSearch->Save();

		// Field Id_Modelo
		$this->Id_Modelo->AdvancedSearch->SearchValue = @$filter["x_Id_Modelo"];
		$this->Id_Modelo->AdvancedSearch->SearchOperator = @$filter["z_Id_Modelo"];
		$this->Id_Modelo->AdvancedSearch->SearchCondition = @$filter["v_Id_Modelo"];
		$this->Id_Modelo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Modelo"];
		$this->Id_Modelo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Modelo"];
		$this->Id_Modelo->AdvancedSearch->Save();

		// Field Id_Ano
		$this->Id_Ano->AdvancedSearch->SearchValue = @$filter["x_Id_Ano"];
		$this->Id_Ano->AdvancedSearch->SearchOperator = @$filter["z_Id_Ano"];
		$this->Id_Ano->AdvancedSearch->SearchCondition = @$filter["v_Id_Ano"];
		$this->Id_Ano->AdvancedSearch->SearchValue2 = @$filter["y_Id_Ano"];
		$this->Id_Ano->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Ano"];
		$this->Id_Ano->AdvancedSearch->Save();

		// Field Tiene_Cargador
		$this->Tiene_Cargador->AdvancedSearch->SearchValue = @$filter["x_Tiene_Cargador"];
		$this->Tiene_Cargador->AdvancedSearch->SearchOperator = @$filter["z_Tiene_Cargador"];
		$this->Tiene_Cargador->AdvancedSearch->SearchCondition = @$filter["v_Tiene_Cargador"];
		$this->Tiene_Cargador->AdvancedSearch->SearchValue2 = @$filter["y_Tiene_Cargador"];
		$this->Tiene_Cargador->AdvancedSearch->SearchOperator2 = @$filter["w_Tiene_Cargador"];
		$this->Tiene_Cargador->AdvancedSearch->Save();

		// Field Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Equipo"];
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Equipo"];
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Equipo"];
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Equipo"];
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Equipo"];
		$this->Id_Tipo_Equipo->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->NroSerie, $Default, FALSE); // NroSerie
		$this->BuildSearchSql($sWhere, $this->NroMac, $Default, FALSE); // NroMac
		$this->BuildSearchSql($sWhere, $this->SpecialNumber, $Default, FALSE); // SpecialNumber
		$this->BuildSearchSql($sWhere, $this->Id_Ubicacion, $Default, FALSE); // Id_Ubicacion
		$this->BuildSearchSql($sWhere, $this->Id_Estado, $Default, FALSE); // Id_Estado
		$this->BuildSearchSql($sWhere, $this->Id_Sit_Estado, $Default, FALSE); // Id_Sit_Estado
		$this->BuildSearchSql($sWhere, $this->Id_Marca, $Default, FALSE); // Id_Marca
		$this->BuildSearchSql($sWhere, $this->Id_Modelo, $Default, FALSE); // Id_Modelo
		$this->BuildSearchSql($sWhere, $this->Id_Ano, $Default, FALSE); // Id_Ano
		$this->BuildSearchSql($sWhere, $this->Tiene_Cargador, $Default, FALSE); // Tiene_Cargador
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Equipo, $Default, FALSE); // Id_Tipo_Equipo
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->NroSerie->AdvancedSearch->Save(); // NroSerie
			$this->NroMac->AdvancedSearch->Save(); // NroMac
			$this->SpecialNumber->AdvancedSearch->Save(); // SpecialNumber
			$this->Id_Ubicacion->AdvancedSearch->Save(); // Id_Ubicacion
			$this->Id_Estado->AdvancedSearch->Save(); // Id_Estado
			$this->Id_Sit_Estado->AdvancedSearch->Save(); // Id_Sit_Estado
			$this->Id_Marca->AdvancedSearch->Save(); // Id_Marca
			$this->Id_Modelo->AdvancedSearch->Save(); // Id_Modelo
			$this->Id_Ano->AdvancedSearch->Save(); // Id_Ano
			$this->Tiene_Cargador->AdvancedSearch->Save(); // Tiene_Cargador
			$this->Id_Tipo_Equipo->AdvancedSearch->Save(); // Id_Tipo_Equipo
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
		$this->BuildBasicSearchSQL($sWhere, $this->NroSerie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NroMac, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SpecialNumber, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Ubicacion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Estado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Sit_Estado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Marca, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Modelo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Ano, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Tiene_Cargador, $arKeywords, $type);
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
		if ($this->NroSerie->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NroMac->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->SpecialNumber->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Ubicacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Sit_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Marca->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Modelo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Ano->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tiene_Cargador->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Equipo->AdvancedSearch->IssetSession())
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
		$this->NroSerie->AdvancedSearch->UnsetSession();
		$this->NroMac->AdvancedSearch->UnsetSession();
		$this->SpecialNumber->AdvancedSearch->UnsetSession();
		$this->Id_Ubicacion->AdvancedSearch->UnsetSession();
		$this->Id_Estado->AdvancedSearch->UnsetSession();
		$this->Id_Sit_Estado->AdvancedSearch->UnsetSession();
		$this->Id_Marca->AdvancedSearch->UnsetSession();
		$this->Id_Modelo->AdvancedSearch->UnsetSession();
		$this->Id_Ano->AdvancedSearch->UnsetSession();
		$this->Tiene_Cargador->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Equipo->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->NroSerie->AdvancedSearch->Load();
		$this->NroMac->AdvancedSearch->Load();
		$this->SpecialNumber->AdvancedSearch->Load();
		$this->Id_Ubicacion->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Id_Sit_Estado->AdvancedSearch->Load();
		$this->Id_Marca->AdvancedSearch->Load();
		$this->Id_Modelo->AdvancedSearch->Load();
		$this->Id_Ano->AdvancedSearch->Load();
		$this->Tiene_Cargador->AdvancedSearch->Load();
		$this->Id_Tipo_Equipo->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->NroSerie); // NroSerie
			$this->UpdateSort($this->NroMac); // NroMac
			$this->UpdateSort($this->Id_Ubicacion); // Id_Ubicacion
			$this->UpdateSort($this->Id_Estado); // Id_Estado
			$this->UpdateSort($this->Id_Sit_Estado); // Id_Sit_Estado
			$this->UpdateSort($this->Id_Marca); // Id_Marca
			$this->UpdateSort($this->Id_Modelo); // Id_Modelo
			$this->UpdateSort($this->Id_Ano); // Id_Ano
			$this->UpdateSort($this->Id_Tipo_Equipo); // Id_Tipo_Equipo
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
				$this->NroSerie->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->NroSerie->setSort("");
				$this->NroMac->setSort("");
				$this->Id_Ubicacion->setSort("");
				$this->Id_Estado->setSort("");
				$this->Id_Sit_Estado->setSort("");
				$this->Id_Marca->setSort("");
				$this->Id_Modelo->setSort("");
				$this->Id_Ano->setSort("");
				$this->Id_Tipo_Equipo->setSort("");
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

		// "detail_observacion_equipo"
		$item = &$this->ListOptions->Add("detail_observacion_equipo");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'observacion_equipo') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("observacion_equipo");
		$this->DetailPages = $pages;

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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->NroSerie->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"equipos\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"equipos\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_observacion_equipo"
		$oListOpt = &$this->ListOptions->Items["detail_observacion_equipo"];
		if ($Security->AllowList(CurrentProjectID() . 'observacion_equipo')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("observacion_equipo", "TblCaption");
			$body .= str_replace("%c", $this->observacion_equipo_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("observacion_equipolist.php?" . EW_TABLE_SHOW_MASTER . "=equipos&fk_NroSerie=" . urlencode(strval($this->NroSerie->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["observacion_equipo_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'observacion_equipo')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=observacion_equipo")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "observacion_equipo";
			}
			if ($GLOBALS["observacion_equipo_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'observacion_equipo')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=observacion_equipo")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "observacion_equipo";
			}
			if ($GLOBALS["observacion_equipo_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'observacion_equipo')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=observacion_equipo")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "observacion_equipo";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->NroSerie->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->NroSerie->CurrentValue . "\">";
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
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_observacion_equipo");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=observacion_equipo");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["observacion_equipo"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["observacion_equipo"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'observacion_equipo') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "observacion_equipo";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

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
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fequiposlist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"equipos\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fequiposlist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fequiposlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fequiposlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fequiposlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fequiposlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"equipossrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->NroMac->CurrentValue = NULL;
		$this->NroMac->OldValue = $this->NroMac->CurrentValue;
		$this->Id_Ubicacion->CurrentValue = 1;
		$this->Id_Ubicacion->OldValue = $this->Id_Ubicacion->CurrentValue;
		$this->Id_Estado->CurrentValue = 1;
		$this->Id_Estado->OldValue = $this->Id_Estado->CurrentValue;
		$this->Id_Sit_Estado->CurrentValue = 1;
		$this->Id_Sit_Estado->OldValue = $this->Id_Sit_Estado->CurrentValue;
		$this->Id_Marca->CurrentValue = NULL;
		$this->Id_Marca->OldValue = $this->Id_Marca->CurrentValue;
		$this->Id_Modelo->CurrentValue = NULL;
		$this->Id_Modelo->OldValue = $this->Id_Modelo->CurrentValue;
		$this->Id_Ano->CurrentValue = NULL;
		$this->Id_Ano->OldValue = $this->Id_Ano->CurrentValue;
		$this->Id_Tipo_Equipo->CurrentValue = 1;
		$this->Id_Tipo_Equipo->OldValue = $this->Id_Tipo_Equipo->CurrentValue;
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
		// NroSerie

		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroSerie"]);
		if ($this->NroSerie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroSerie->AdvancedSearch->SearchOperator = @$_GET["z_NroSerie"];

		// NroMac
		$this->NroMac->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroMac"]);
		if ($this->NroMac->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroMac->AdvancedSearch->SearchOperator = @$_GET["z_NroMac"];

		// SpecialNumber
		$this->SpecialNumber->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_SpecialNumber"]);
		if ($this->SpecialNumber->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->SpecialNumber->AdvancedSearch->SearchOperator = @$_GET["z_SpecialNumber"];

		// Id_Ubicacion
		$this->Id_Ubicacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Ubicacion"]);
		if ($this->Id_Ubicacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Ubicacion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Ubicacion"];

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado"]);
		if ($this->Id_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado"];

		// Id_Sit_Estado
		$this->Id_Sit_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Sit_Estado"]);
		if ($this->Id_Sit_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Sit_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Sit_Estado"];

		// Id_Marca
		$this->Id_Marca->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Marca"]);
		if ($this->Id_Marca->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Marca->AdvancedSearch->SearchOperator = @$_GET["z_Id_Marca"];

		// Id_Modelo
		$this->Id_Modelo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Modelo"]);
		if ($this->Id_Modelo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Modelo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Modelo"];

		// Id_Ano
		$this->Id_Ano->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Ano"]);
		if ($this->Id_Ano->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Ano->AdvancedSearch->SearchOperator = @$_GET["z_Id_Ano"];

		// Tiene_Cargador
		$this->Tiene_Cargador->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tiene_Cargador"]);
		if ($this->Tiene_Cargador->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tiene_Cargador->AdvancedSearch->SearchOperator = @$_GET["z_Tiene_Cargador"];

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Equipo"]);
		if ($this->Id_Tipo_Equipo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Equipo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Equipo"];

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
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->setOldValue($objForm->GetValue("o_NroSerie"));
		if (!$this->NroMac->FldIsDetailKey) {
			$this->NroMac->setFormValue($objForm->GetValue("x_NroMac"));
		}
		$this->NroMac->setOldValue($objForm->GetValue("o_NroMac"));
		if (!$this->Id_Ubicacion->FldIsDetailKey) {
			$this->Id_Ubicacion->setFormValue($objForm->GetValue("x_Id_Ubicacion"));
		}
		$this->Id_Ubicacion->setOldValue($objForm->GetValue("o_Id_Ubicacion"));
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		$this->Id_Estado->setOldValue($objForm->GetValue("o_Id_Estado"));
		if (!$this->Id_Sit_Estado->FldIsDetailKey) {
			$this->Id_Sit_Estado->setFormValue($objForm->GetValue("x_Id_Sit_Estado"));
		}
		$this->Id_Sit_Estado->setOldValue($objForm->GetValue("o_Id_Sit_Estado"));
		if (!$this->Id_Marca->FldIsDetailKey) {
			$this->Id_Marca->setFormValue($objForm->GetValue("x_Id_Marca"));
		}
		$this->Id_Marca->setOldValue($objForm->GetValue("o_Id_Marca"));
		if (!$this->Id_Modelo->FldIsDetailKey) {
			$this->Id_Modelo->setFormValue($objForm->GetValue("x_Id_Modelo"));
		}
		$this->Id_Modelo->setOldValue($objForm->GetValue("o_Id_Modelo"));
		if (!$this->Id_Ano->FldIsDetailKey) {
			$this->Id_Ano->setFormValue($objForm->GetValue("x_Id_Ano"));
		}
		$this->Id_Ano->setOldValue($objForm->GetValue("o_Id_Ano"));
		if (!$this->Id_Tipo_Equipo->FldIsDetailKey) {
			$this->Id_Tipo_Equipo->setFormValue($objForm->GetValue("x_Id_Tipo_Equipo"));
		}
		$this->Id_Tipo_Equipo->setOldValue($objForm->GetValue("o_Id_Tipo_Equipo"));
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
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->NroMac->CurrentValue = $this->NroMac->FormValue;
		$this->Id_Ubicacion->CurrentValue = $this->Id_Ubicacion->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Id_Sit_Estado->CurrentValue = $this->Id_Sit_Estado->FormValue;
		$this->Id_Marca->CurrentValue = $this->Id_Marca->FormValue;
		$this->Id_Modelo->CurrentValue = $this->Id_Modelo->FormValue;
		$this->Id_Ano->CurrentValue = $this->Id_Ano->FormValue;
		$this->Id_Tipo_Equipo->CurrentValue = $this->Id_Tipo_Equipo->FormValue;
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
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->NroMac->setDbValue($rs->fields('NroMac'));
		$this->SpecialNumber->setDbValue($rs->fields('SpecialNumber'));
		$this->Id_Ubicacion->setDbValue($rs->fields('Id_Ubicacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Sit_Estado->setDbValue($rs->fields('Id_Sit_Estado'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_Ano->setDbValue($rs->fields('Id_Ano'));
		$this->Tiene_Cargador->setDbValue($rs->fields('Tiene_Cargador'));
		$this->Id_Tipo_Equipo->setDbValue($rs->fields('Id_Tipo_Equipo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;
		$sDetailFilter = $GLOBALS["observacion_equipo"]->SqlDetailFilter_equipos();
		$sDetailFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["observacion_equipo"]->setCurrentMasterTable("equipos");
		$sDetailFilter = $GLOBALS["observacion_equipo"]->ApplyUserIDFilters($sDetailFilter);
		$this->observacion_equipo_Count = $GLOBALS["observacion_equipo"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->NroMac->DbValue = $row['NroMac'];
		$this->SpecialNumber->DbValue = $row['SpecialNumber'];
		$this->Id_Ubicacion->DbValue = $row['Id_Ubicacion'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Sit_Estado->DbValue = $row['Id_Sit_Estado'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_Ano->DbValue = $row['Id_Ano'];
		$this->Tiene_Cargador->DbValue = $row['Tiene_Cargador'];
		$this->Id_Tipo_Equipo->DbValue = $row['Id_Tipo_Equipo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("NroSerie")) <> "")
			$this->NroSerie->CurrentValue = $this->getKey("NroSerie"); // NroSerie
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
		// NroSerie
		// NroMac
		// SpecialNumber
		// Id_Ubicacion
		// Id_Estado
		// Id_Sit_Estado
		// Id_Marca
		// Id_Modelo
		// Id_Ano
		// Tiene_Cargador
		// Id_Tipo_Equipo
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->ViewValue = $this->NroMac->CurrentValue;
		$this->NroMac->ViewCustomAttributes = "";

		// SpecialNumber
		$this->SpecialNumber->ViewValue = $this->SpecialNumber->CurrentValue;
		$this->SpecialNumber->ViewCustomAttributes = "";

		// Id_Ubicacion
		if (strval($this->Id_Ubicacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
		$sWhereWrk = "";
		$this->Id_Ubicacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->CurrentValue;
			}
		} else {
			$this->Id_Ubicacion->ViewValue = NULL;
		}
		$this->Id_Ubicacion->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado->ViewValue = $this->Id_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// Id_Sit_Estado
		if (strval($this->Id_Sit_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
		$sWhereWrk = "";
		$this->Id_Sit_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->CurrentValue;
			}
		} else {
			$this->Id_Sit_Estado->ViewValue = NULL;
		}
		$this->Id_Sit_Estado->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Marca->ViewValue = $this->Id_Marca->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Marca->ViewValue = $this->Id_Marca->CurrentValue;
			}
		} else {
			$this->Id_Marca->ViewValue = NULL;
		}
		$this->Id_Marca->ViewCustomAttributes = "";

		// Id_Modelo
		if (strval($this->Id_Modelo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
		$sWhereWrk = "";
		$this->Id_Modelo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->CurrentValue;
			}
		} else {
			$this->Id_Modelo->ViewValue = NULL;
		}
		$this->Id_Modelo->ViewCustomAttributes = "";

		// Id_Ano
		if (strval($this->Id_Ano->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
		$sWhereWrk = "";
		$this->Id_Ano->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ano->ViewValue = $this->Id_Ano->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ano->ViewValue = $this->Id_Ano->CurrentValue;
			}
		} else {
			$this->Id_Ano->ViewValue = NULL;
		}
		$this->Id_Ano->ViewCustomAttributes = "";

		// Tiene_Cargador
		if (strval($this->Tiene_Cargador->CurrentValue) <> "") {
			$this->Tiene_Cargador->ViewValue = $this->Tiene_Cargador->OptionCaption($this->Tiene_Cargador->CurrentValue);
		} else {
			$this->Tiene_Cargador->ViewValue = NULL;
		}
		$this->Tiene_Cargador->ViewCustomAttributes = "";

		// Id_Tipo_Equipo
		if (strval($this->Id_Tipo_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
		$sWhereWrk = "";
		$this->Id_Tipo_Equipo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Equipo->ViewValue = NULL;
		}
		$this->Id_Tipo_Equipo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewValue = ew_FormatDateTime($this->Usuario->ViewValue, 7);
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";
			$this->NroMac->TooltipValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";
			$this->Id_Ubicacion->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";
			$this->Id_Sit_Estado->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";
			$this->Id_Ano->TooltipValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";
			$this->Id_Tipo_Equipo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			if ($this->NroSerie->getSessionValue() <> "") {
				$this->NroSerie->CurrentValue = $this->NroSerie->getSessionValue();
				$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewCustomAttributes = "";
			} else {
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());
			}

			// NroMac
			$this->NroMac->EditAttrs["class"] = "form-control";
			$this->NroMac->EditCustomAttributes = "";
			$this->NroMac->EditValue = ew_HtmlEncode($this->NroMac->CurrentValue);
			$this->NroMac->PlaceHolder = ew_RemoveHtml($this->NroMac->FldCaption());

			// Id_Ubicacion
			$this->Id_Ubicacion->EditAttrs["class"] = "form-control";
			$this->Id_Ubicacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ubicacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ubicacion->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Sit_Estado
			$this->Id_Sit_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Sit_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sit_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sit_Estado->EditValue = $arwrk;

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Marca->EditValue = $arwrk;

			// Id_Modelo
			$this->Id_Modelo->EditAttrs["class"] = "form-control";
			$this->Id_Modelo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modelo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Marca` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_Ano
			$this->Id_Ano->EditAttrs["class"] = "form-control";
			$this->Id_Ano->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ano->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ano->EditValue = $arwrk;

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Equipo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Equipo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_equipo`";
			$sWhereWrk = "";
			$this->Id_Tipo_Equipo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Equipo->EditValue = $arwrk;

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// NroSerie

			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewCustomAttributes = "";

			// NroMac
			$this->NroMac->EditAttrs["class"] = "form-control";
			$this->NroMac->EditCustomAttributes = "";
			$this->NroMac->EditValue = ew_HtmlEncode($this->NroMac->CurrentValue);
			$this->NroMac->PlaceHolder = ew_RemoveHtml($this->NroMac->FldCaption());

			// Id_Ubicacion
			$this->Id_Ubicacion->EditAttrs["class"] = "form-control";
			$this->Id_Ubicacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ubicacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ubicacion->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Sit_Estado
			$this->Id_Sit_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Sit_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sit_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sit_Estado->EditValue = $arwrk;

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Marca->EditValue = $arwrk;

			// Id_Modelo
			$this->Id_Modelo->EditAttrs["class"] = "form-control";
			$this->Id_Modelo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modelo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Marca` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_Ano
			$this->Id_Ano->EditAttrs["class"] = "form-control";
			$this->Id_Ano->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ano->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ano->EditValue = $arwrk;

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Equipo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Equipo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_equipo`";
			$sWhereWrk = "";
			$this->Id_Tipo_Equipo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Equipo->EditValue = $arwrk;

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// NroSerie

			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";

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
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Id_Ubicacion->FldIsDetailKey && !is_null($this->Id_Ubicacion->FormValue) && $this->Id_Ubicacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ubicacion->FldCaption(), $this->Id_Ubicacion->ReqErrMsg));
		}
		if (!$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
		}
		if (!$this->Id_Sit_Estado->FldIsDetailKey && !is_null($this->Id_Sit_Estado->FormValue) && $this->Id_Sit_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Sit_Estado->FldCaption(), $this->Id_Sit_Estado->ReqErrMsg));
		}
		if (!$this->Id_Marca->FldIsDetailKey && !is_null($this->Id_Marca->FormValue) && $this->Id_Marca->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Marca->FldCaption(), $this->Id_Marca->ReqErrMsg));
		}
		if (!$this->Id_Modelo->FldIsDetailKey && !is_null($this->Id_Modelo->FormValue) && $this->Id_Modelo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Modelo->FldCaption(), $this->Id_Modelo->ReqErrMsg));
		}
		if (!$this->Id_Ano->FldIsDetailKey && !is_null($this->Id_Ano->FormValue) && $this->Id_Ano->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ano->FldCaption(), $this->Id_Ano->ReqErrMsg));
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
				$sThisKey .= $row['NroSerie'];
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

			// NroSerie
			// NroMac

			$this->NroMac->SetDbValueDef($rsnew, $this->NroMac->CurrentValue, NULL, $this->NroMac->ReadOnly);

			// Id_Ubicacion
			$this->Id_Ubicacion->SetDbValueDef($rsnew, $this->Id_Ubicacion->CurrentValue, 0, $this->Id_Ubicacion->ReadOnly);

			// Id_Estado
			$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, $this->Id_Estado->ReadOnly);

			// Id_Sit_Estado
			$this->Id_Sit_Estado->SetDbValueDef($rsnew, $this->Id_Sit_Estado->CurrentValue, 0, $this->Id_Sit_Estado->ReadOnly);

			// Id_Marca
			$this->Id_Marca->SetDbValueDef($rsnew, $this->Id_Marca->CurrentValue, 0, $this->Id_Marca->ReadOnly);

			// Id_Modelo
			$this->Id_Modelo->SetDbValueDef($rsnew, $this->Id_Modelo->CurrentValue, 0, $this->Id_Modelo->ReadOnly);

			// Id_Ano
			$this->Id_Ano->SetDbValueDef($rsnew, $this->Id_Ano->CurrentValue, 0, $this->Id_Ano->ReadOnly);

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->SetDbValueDef($rsnew, $this->Id_Tipo_Equipo->CurrentValue, NULL, $this->Id_Tipo_Equipo->ReadOnly);

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

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// NroMac
		$this->NroMac->SetDbValueDef($rsnew, $this->NroMac->CurrentValue, NULL, FALSE);

		// Id_Ubicacion
		$this->Id_Ubicacion->SetDbValueDef($rsnew, $this->Id_Ubicacion->CurrentValue, 0, strval($this->Id_Ubicacion->CurrentValue) == "");

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, strval($this->Id_Estado->CurrentValue) == "");

		// Id_Sit_Estado
		$this->Id_Sit_Estado->SetDbValueDef($rsnew, $this->Id_Sit_Estado->CurrentValue, 0, strval($this->Id_Sit_Estado->CurrentValue) == "");

		// Id_Marca
		$this->Id_Marca->SetDbValueDef($rsnew, $this->Id_Marca->CurrentValue, 0, strval($this->Id_Marca->CurrentValue) == "");

		// Id_Modelo
		$this->Id_Modelo->SetDbValueDef($rsnew, $this->Id_Modelo->CurrentValue, 0, strval($this->Id_Modelo->CurrentValue) == "");

		// Id_Ano
		$this->Id_Ano->SetDbValueDef($rsnew, $this->Id_Ano->CurrentValue, 0, FALSE);

		// Id_Tipo_Equipo
		$this->Id_Tipo_Equipo->SetDbValueDef($rsnew, $this->Id_Tipo_Equipo->CurrentValue, NULL, strval($this->Id_Tipo_Equipo->CurrentValue) == "");

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['NroSerie']) == "") {
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
		$this->NroSerie->AdvancedSearch->Load();
		$this->NroMac->AdvancedSearch->Load();
		$this->SpecialNumber->AdvancedSearch->Load();
		$this->Id_Ubicacion->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Id_Sit_Estado->AdvancedSearch->Load();
		$this->Id_Marca->AdvancedSearch->Load();
		$this->Id_Modelo->AdvancedSearch->Load();
		$this->Id_Ano->AdvancedSearch->Load();
		$this->Tiene_Cargador->AdvancedSearch->Load();
		$this->Id_Tipo_Equipo->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_equipos\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_equipos',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fequiposlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "personas") {
			global $personas;
			if (!isset($personas)) $personas = new cpersonas;
			$rsmaster = $personas->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$personas;
					$personas->ExportDocument($Doc, $rsmaster, 1, 1);
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
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setQueryStringValue($_GET["fk_NroSerie"]);
					$this->NroSerie->setQueryStringValue($GLOBALS["personas"]->NroSerie->QueryStringValue);
					$this->NroSerie->setSessionValue($this->NroSerie->QueryStringValue);
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
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setFormValue($_POST["fk_NroSerie"]);
					$this->NroSerie->setFormValue($GLOBALS["personas"]->NroSerie->FormValue);
					$this->NroSerie->setSessionValue($this->NroSerie->FormValue);
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
			if ($sMasterTblVar <> "personas") {
				if ($this->NroSerie->CurrentValue == "") $this->NroSerie->setSessionValue("");
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
		case "x_Id_Ubicacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ubicacion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ubicacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Sit_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Sit_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Sit_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Marca":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Marca` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Marca` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modelo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modelo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
			$sWhereWrk = "{filter}";
			$this->Id_Modelo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modelo` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Marca` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Ano":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ano` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ano` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Equipo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Equipo` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
			$sWhereWrk = "";
			$this->Id_Tipo_Equipo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Equipo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
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
		$table = 'equipos';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

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
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NroSerie'];

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
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

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
if (!isset($equipos_list)) $equipos_list = new cequipos_list();

// Page init
$equipos_list->Page_Init();

// Page main
$equipos_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equipos_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($equipos->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fequiposlist = new ew_Form("fequiposlist", "list");
fequiposlist.FormKeyCountName = '<?php echo $equipos_list->FormKeyCountName ?>';

// Validate form
fequiposlist.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->NroSerie->FldCaption(), $equipos->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ubicacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ubicacion->FldCaption(), $equipos->Id_Ubicacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Estado->FldCaption(), $equipos->Id_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Sit_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Sit_Estado->FldCaption(), $equipos->Id_Sit_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Marca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Marca->FldCaption(), $equipos->Id_Marca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Modelo->FldCaption(), $equipos->Id_Modelo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ano");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ano->FldCaption(), $equipos->Id_Ano->ReqErrMsg)) ?>");

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
fequiposlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroMac", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Ubicacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Sit_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Marca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Modelo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Ano", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Equipo", false)) return false;
	return true;
}

// Form_CustomValidate event
fequiposlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fequiposlist.ValidateRequired = true;
<?php } else { ?>
fequiposlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fequiposlist.Lists["x_Id_Ubicacion"] = {"LinkField":"x_Id_Ubicacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ubicacion_equipo"};
fequiposlist.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo"};
fequiposlist.Lists["x_Id_Sit_Estado"] = {"LinkField":"x_Id_Sit_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};
fequiposlist.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Modelo"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca"};
fequiposlist.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":["x_Id_Marca"],"ChildFields":[],"FilterFields":["x_Id_Marca"],"Options":[],"Template":"","LinkTable":"modelo"};
fequiposlist.Lists["x_Id_Ano"] = {"LinkField":"x_Id_Ano","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ano_entrega"};
fequiposlist.Lists["x_Id_Tipo_Equipo"] = {"LinkField":"x_Id_Tipo_Equipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_equipo"};

// Form object for search
var CurrentSearchForm = fequiposlistsrch = new ew_Form("fequiposlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($equipos->Export == "") { ?>
<div class="ewToolbar">
<?php if ($equipos->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($equipos_list->TotalRecs > 0 && $equipos_list->ExportOptions->Visible()) { ?>
<?php $equipos_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($equipos_list->SearchOptions->Visible()) { ?>
<?php $equipos_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($equipos_list->FilterOptions->Visible()) { ?>
<?php $equipos_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($equipos->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($equipos->Export == "") || (EW_EXPORT_MASTER_RECORD && $equipos->Export == "print")) { ?>
<?php
if ($equipos_list->DbMasterFilter <> "" && $equipos->getCurrentMasterTable() == "personas") {
	if ($equipos_list->MasterRecordExists) {
?>
<?php include_once "personasmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($equipos->CurrentAction == "gridadd") {
	$equipos->CurrentFilter = "0=1";
	$equipos_list->StartRec = 1;
	$equipos_list->DisplayRecs = $equipos->GridAddRowCount;
	$equipos_list->TotalRecs = $equipos_list->DisplayRecs;
	$equipos_list->StopRec = $equipos_list->DisplayRecs;
} else {
	$bSelectLimit = $equipos_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($equipos_list->TotalRecs <= 0)
			$equipos_list->TotalRecs = $equipos->SelectRecordCount();
	} else {
		if (!$equipos_list->Recordset && ($equipos_list->Recordset = $equipos_list->LoadRecordset()))
			$equipos_list->TotalRecs = $equipos_list->Recordset->RecordCount();
	}
	$equipos_list->StartRec = 1;
	if ($equipos_list->DisplayRecs <= 0 || ($equipos->Export <> "" && $equipos->ExportAll)) // Display all records
		$equipos_list->DisplayRecs = $equipos_list->TotalRecs;
	if (!($equipos->Export <> "" && $equipos->ExportAll))
		$equipos_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$equipos_list->Recordset = $equipos_list->LoadRecordset($equipos_list->StartRec-1, $equipos_list->DisplayRecs);

	// Set no record found message
	if ($equipos->CurrentAction == "" && $equipos_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$equipos_list->setWarningMessage(ew_DeniedMsg());
		if ($equipos_list->SearchWhere == "0=101")
			$equipos_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$equipos_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($equipos_list->AuditTrailOnSearch && $equipos_list->Command == "search" && !$equipos_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $equipos_list->getSessionWhere();
		$equipos_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$equipos_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($equipos->Export == "" && $equipos->CurrentAction == "") { ?>
<form name="fequiposlistsrch" id="fequiposlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($equipos_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fequiposlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="equipos">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($equipos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($equipos_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $equipos_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($equipos_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($equipos_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($equipos_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($equipos_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $equipos_list->ShowPageHeader(); ?>
<?php
$equipos_list->ShowMessage();
?>
<?php if ($equipos_list->TotalRecs > 0 || $equipos->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid equipos">
<?php if ($equipos->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($equipos->CurrentAction <> "gridadd" && $equipos->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($equipos_list->Pager)) $equipos_list->Pager = new cPrevNextPager($equipos_list->StartRec, $equipos_list->DisplayRecs, $equipos_list->TotalRecs) ?>
<?php if ($equipos_list->Pager->RecordCount > 0 && $equipos_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($equipos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($equipos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $equipos_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($equipos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($equipos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $equipos_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $equipos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $equipos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $equipos_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($equipos_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fequiposlist" id="fequiposlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($equipos_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $equipos_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="equipos">
<?php if ($equipos->getCurrentMasterTable() == "personas" && $equipos->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_NroSerie" value="<?php echo $equipos->NroSerie->getSessionValue() ?>">
<?php } ?>
<div id="gmp_equipos" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($equipos_list->TotalRecs > 0 || $equipos->CurrentAction == "add" || $equipos->CurrentAction == "copy") { ?>
<table id="tbl_equiposlist" class="table ewTable">
<?php echo $equipos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$equipos_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$equipos_list->RenderListOptions();

// Render list options (header, left)
$equipos_list->ListOptions->Render("header", "left");
?>
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
	<?php if ($equipos->SortUrl($equipos->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_equipos_NroSerie" class="equipos_NroSerie"><div class="ewTableHeaderCaption"><?php echo $equipos->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->NroSerie) ?>',1);"><div id="elh_equipos_NroSerie" class="equipos_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->NroSerie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($equipos->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
	<?php if ($equipos->SortUrl($equipos->NroMac) == "") { ?>
		<th data-name="NroMac"><div id="elh_equipos_NroMac" class="equipos_NroMac"><div class="ewTableHeaderCaption"><?php echo $equipos->NroMac->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroMac"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->NroMac) ?>',1);"><div id="elh_equipos_NroMac" class="equipos_NroMac">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->NroMac->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($equipos->NroMac->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->NroMac->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
	<?php if ($equipos->SortUrl($equipos->Id_Ubicacion) == "") { ?>
		<th data-name="Id_Ubicacion"><div id="elh_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Ubicacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Ubicacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Ubicacion) ?>',1);"><div id="elh_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Ubicacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Ubicacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Ubicacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($equipos->SortUrl($equipos->Id_Estado) == "") { ?>
		<th data-name="Id_Estado"><div id="elh_equipos_Id_Estado" class="equipos_Id_Estado"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Estado) ?>',1);"><div id="elh_equipos_Id_Estado" class="equipos_Id_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
	<?php if ($equipos->SortUrl($equipos->Id_Sit_Estado) == "") { ?>
		<th data-name="Id_Sit_Estado"><div id="elh_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Sit_Estado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Sit_Estado) ?>',1);"><div id="elh_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Sit_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Sit_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
	<?php if ($equipos->SortUrl($equipos->Id_Marca) == "") { ?>
		<th data-name="Id_Marca"><div id="elh_equipos_Id_Marca" class="equipos_Id_Marca"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Marca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Marca"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Marca) ?>',1);"><div id="elh_equipos_Id_Marca" class="equipos_Id_Marca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Marca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Marca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Marca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
	<?php if ($equipos->SortUrl($equipos->Id_Modelo) == "") { ?>
		<th data-name="Id_Modelo"><div id="elh_equipos_Id_Modelo" class="equipos_Id_Modelo"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Modelo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Modelo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Modelo) ?>',1);"><div id="elh_equipos_Id_Modelo" class="equipos_Id_Modelo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Modelo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Modelo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Modelo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
	<?php if ($equipos->SortUrl($equipos->Id_Ano) == "") { ?>
		<th data-name="Id_Ano"><div id="elh_equipos_Id_Ano" class="equipos_Id_Ano"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Ano->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Ano"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Ano) ?>',1);"><div id="elh_equipos_Id_Ano" class="equipos_Id_Ano">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Ano->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Ano->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Ano->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
	<?php if ($equipos->SortUrl($equipos->Id_Tipo_Equipo) == "") { ?>
		<th data-name="Id_Tipo_Equipo"><div id="elh_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Equipo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Id_Tipo_Equipo) ?>',1);"><div id="elh_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Tipo_Equipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Tipo_Equipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Usuario->Visible) { // Usuario ?>
	<?php if ($equipos->SortUrl($equipos->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_equipos_Usuario" class="equipos_Usuario"><div class="ewTableHeaderCaption"><?php echo $equipos->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Usuario) ?>',1);"><div id="elh_equipos_Usuario" class="equipos_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($equipos->SortUrl($equipos->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $equipos->SortUrl($equipos->Fecha_Actualizacion) ?>',1);"><div id="elh_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$equipos_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($equipos->CurrentAction == "add" || $equipos->CurrentAction == "copy") {
		$equipos_list->RowIndex = 0;
		$equipos_list->KeyCount = $equipos_list->RowIndex;
		if ($equipos->CurrentAction == "add")
			$equipos_list->LoadDefaultValues();
		if ($equipos->EventCancelled) // Insert failed
			$equipos_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$equipos->ResetAttrs();
		$equipos->RowAttrs = array_merge($equipos->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_equipos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$equipos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$equipos_list->RenderRow();

		// Render list options
		$equipos_list->RenderListOptions();
		$equipos_list->StartRowCnt = 0;
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$equipos_list->ListOptions->Render("body", "left", $equipos_list->RowCnt);
?>
	<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_list->RowIndex ?>_NroSerie" id="o<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td data-name="NroMac">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_list->RowIndex ?>_NroMac" id="x<?php echo $equipos_list->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_list->RowIndex ?>_NroMac" id="o<?php echo $equipos_list->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td data-name="Id_Ubicacion">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td data-name="Id_Sit_Estado">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_list->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td data-name="Id_Ano">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td data-name="Id_Tipo_Equipo">
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_list->RowIndex ?>_Usuario" id="o<?php echo $equipos_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$equipos_list->ListOptions->Render("body", "right", $equipos_list->RowCnt);
?>
<script type="text/javascript">
fequiposlist.UpdateOpts(<?php echo $equipos_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($equipos->ExportAll && $equipos->Export <> "") {
	$equipos_list->StopRec = $equipos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($equipos_list->TotalRecs > $equipos_list->StartRec + $equipos_list->DisplayRecs - 1)
		$equipos_list->StopRec = $equipos_list->StartRec + $equipos_list->DisplayRecs - 1;
	else
		$equipos_list->StopRec = $equipos_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($equipos_list->FormKeyCountName) && ($equipos->CurrentAction == "gridadd" || $equipos->CurrentAction == "gridedit" || $equipos->CurrentAction == "F")) {
		$equipos_list->KeyCount = $objForm->GetValue($equipos_list->FormKeyCountName);
		$equipos_list->StopRec = $equipos_list->StartRec + $equipos_list->KeyCount - 1;
	}
}
$equipos_list->RecCnt = $equipos_list->StartRec - 1;
if ($equipos_list->Recordset && !$equipos_list->Recordset->EOF) {
	$equipos_list->Recordset->MoveFirst();
	$bSelectLimit = $equipos_list->UseSelectLimit;
	if (!$bSelectLimit && $equipos_list->StartRec > 1)
		$equipos_list->Recordset->Move($equipos_list->StartRec - 1);
} elseif (!$equipos->AllowAddDeleteRow && $equipos_list->StopRec == 0) {
	$equipos_list->StopRec = $equipos->GridAddRowCount;
}

// Initialize aggregate
$equipos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$equipos->ResetAttrs();
$equipos_list->RenderRow();
$equipos_list->EditRowCnt = 0;
if ($equipos->CurrentAction == "edit")
	$equipos_list->RowIndex = 1;
if ($equipos->CurrentAction == "gridadd")
	$equipos_list->RowIndex = 0;
if ($equipos->CurrentAction == "gridedit")
	$equipos_list->RowIndex = 0;
while ($equipos_list->RecCnt < $equipos_list->StopRec) {
	$equipos_list->RecCnt++;
	if (intval($equipos_list->RecCnt) >= intval($equipos_list->StartRec)) {
		$equipos_list->RowCnt++;
		if ($equipos->CurrentAction == "gridadd" || $equipos->CurrentAction == "gridedit" || $equipos->CurrentAction == "F") {
			$equipos_list->RowIndex++;
			$objForm->Index = $equipos_list->RowIndex;
			if ($objForm->HasValue($equipos_list->FormActionName))
				$equipos_list->RowAction = strval($objForm->GetValue($equipos_list->FormActionName));
			elseif ($equipos->CurrentAction == "gridadd")
				$equipos_list->RowAction = "insert";
			else
				$equipos_list->RowAction = "";
		}

		// Set up key count
		$equipos_list->KeyCount = $equipos_list->RowIndex;

		// Init row class and style
		$equipos->ResetAttrs();
		$equipos->CssClass = "";
		if ($equipos->CurrentAction == "gridadd") {
			$equipos_list->LoadDefaultValues(); // Load default values
		} else {
			$equipos_list->LoadRowValues($equipos_list->Recordset); // Load row values
		}
		$equipos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($equipos->CurrentAction == "gridadd") // Grid add
			$equipos->RowType = EW_ROWTYPE_ADD; // Render add
		if ($equipos->CurrentAction == "gridadd" && $equipos->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$equipos_list->RestoreCurrentRowFormValues($equipos_list->RowIndex); // Restore form values
		if ($equipos->CurrentAction == "edit") {
			if ($equipos_list->CheckInlineEditKey() && $equipos_list->EditRowCnt == 0) { // Inline edit
				$equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($equipos->CurrentAction == "gridedit") { // Grid edit
			if ($equipos->EventCancelled) {
				$equipos_list->RestoreCurrentRowFormValues($equipos_list->RowIndex); // Restore form values
			}
			if ($equipos_list->RowAction == "insert")
				$equipos->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($equipos->CurrentAction == "edit" && $equipos->RowType == EW_ROWTYPE_EDIT && $equipos->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$equipos_list->RestoreFormValues(); // Restore form values
		}
		if ($equipos->CurrentAction == "gridedit" && ($equipos->RowType == EW_ROWTYPE_EDIT || $equipos->RowType == EW_ROWTYPE_ADD) && $equipos->EventCancelled) // Update failed
			$equipos_list->RestoreCurrentRowFormValues($equipos_list->RowIndex); // Restore form values
		if ($equipos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$equipos_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$equipos->RowAttrs = array_merge($equipos->RowAttrs, array('data-rowindex'=>$equipos_list->RowCnt, 'id'=>'r' . $equipos_list->RowCnt . '_equipos', 'data-rowtype'=>$equipos->RowType));

		// Render row
		$equipos_list->RenderRow();

		// Render list options
		$equipos_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($equipos_list->RowAction <> "delete" && $equipos_list->RowAction <> "insertdelete" && !($equipos_list->RowAction == "insert" && $equipos->CurrentAction == "F" && $equipos_list->EmptyRow())) {
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$equipos_list->ListOptions->Render("body", "left", $equipos_list->RowCnt);
?>
	<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $equipos->NroSerie->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_list->RowIndex ?>_NroSerie" id="o<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->EditValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroSerie" class="equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<?php echo $equipos->NroSerie->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $equipos_list->PageObjName . "_row_" . $equipos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td data-name="NroMac"<?php echo $equipos->NroMac->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_list->RowIndex ?>_NroMac" id="x<?php echo $equipos_list->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_list->RowIndex ?>_NroMac" id="o<?php echo $equipos_list->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_list->RowIndex ?>_NroMac" id="x<?php echo $equipos_list->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_NroMac" class="equipos_NroMac">
<span<?php echo $equipos->NroMac->ViewAttributes() ?>>
<?php echo $equipos->NroMac->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td data-name="Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion">
<span<?php echo $equipos->Id_Ubicacion->ViewAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado"<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Estado" class="equipos_Id_Estado">
<span<?php echo $equipos->Id_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Estado->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td data-name="Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado">
<span<?php echo $equipos->Id_Sit_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca"<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_list->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_list->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Marca" class="equipos_Id_Marca">
<span<?php echo $equipos->Id_Marca->ViewAttributes() ?>>
<?php echo $equipos->Id_Marca->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo"<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Modelo" class="equipos_Id_Modelo">
<span<?php echo $equipos->Id_Modelo->ViewAttributes() ?>>
<?php echo $equipos->Id_Modelo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td data-name="Id_Ano"<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Ano" class="equipos_Id_Ano">
<span<?php echo $equipos->Id_Ano->ViewAttributes() ?>>
<?php echo $equipos->Id_Ano->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td data-name="Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo">
<span<?php echo $equipos->Id_Tipo_Equipo->ViewAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $equipos->Usuario->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_list->RowIndex ?>_Usuario" id="o<?php echo $equipos_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Usuario" class="equipos_Usuario">
<span<?php echo $equipos->Usuario->ViewAttributes() ?>>
<?php echo $equipos->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $equipos->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_list->RowCnt ?>_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion">
<span<?php echo $equipos->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $equipos->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$equipos_list->ListOptions->Render("body", "right", $equipos_list->RowCnt);
?>
	</tr>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD || $equipos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fequiposlist.UpdateOpts(<?php echo $equipos_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($equipos->CurrentAction <> "gridadd")
		if (!$equipos_list->Recordset->EOF) $equipos_list->Recordset->MoveNext();
}
?>
<?php
	if ($equipos->CurrentAction == "gridadd" || $equipos->CurrentAction == "gridedit") {
		$equipos_list->RowIndex = '$rowindex$';
		$equipos_list->LoadDefaultValues();

		// Set row properties
		$equipos->ResetAttrs();
		$equipos->RowAttrs = array_merge($equipos->RowAttrs, array('data-rowindex'=>$equipos_list->RowIndex, 'id'=>'r0_equipos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($equipos->RowAttrs["class"], "ewTemplate");
		$equipos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$equipos_list->RenderRow();

		// Render list options
		$equipos_list->RenderListOptions();
		$equipos_list->StartRowCnt = 0;
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$equipos_list->ListOptions->Render("body", "left", $equipos_list->RowIndex);
?>
	<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el$rowindex$_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_equipos_NroSerie" class="form-group equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_list->RowIndex ?>_NroSerie" id="x<?php echo $equipos_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_list->RowIndex ?>_NroSerie" id="o<?php echo $equipos_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td data-name="NroMac">
<span id="el$rowindex$_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_list->RowIndex ?>_NroMac" id="x<?php echo $equipos_list->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_list->RowIndex ?>_NroMac" id="o<?php echo $equipos_list->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td data-name="Id_Ubicacion">
<span id="el$rowindex$_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<span id="el$rowindex$_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td data-name="Id_Sit_Estado">
<span id="el$rowindex$_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_list->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca">
<span id="el$rowindex$_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_list->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_list->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo">
<span id="el$rowindex$_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td data-name="Id_Ano">
<span id="el$rowindex$_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_list->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_list->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td data-name="Id_Tipo_Equipo">
<span id="el$rowindex$_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_list->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_list->RowIndex ?>_Usuario" id="o<?php echo $equipos_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$equipos_list->ListOptions->Render("body", "right", $equipos_list->RowCnt);
?>
<script type="text/javascript">
fequiposlist.UpdateOpts(<?php echo $equipos_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($equipos->CurrentAction == "add" || $equipos->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $equipos_list->FormKeyCountName ?>" id="<?php echo $equipos_list->FormKeyCountName ?>" value="<?php echo $equipos_list->KeyCount ?>">
<?php } ?>
<?php if ($equipos->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $equipos_list->FormKeyCountName ?>" id="<?php echo $equipos_list->FormKeyCountName ?>" value="<?php echo $equipos_list->KeyCount ?>">
<?php echo $equipos_list->MultiSelectKey ?>
<?php } ?>
<?php if ($equipos->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $equipos_list->FormKeyCountName ?>" id="<?php echo $equipos_list->FormKeyCountName ?>" value="<?php echo $equipos_list->KeyCount ?>">
<?php } ?>
<?php if ($equipos->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $equipos_list->FormKeyCountName ?>" id="<?php echo $equipos_list->FormKeyCountName ?>" value="<?php echo $equipos_list->KeyCount ?>">
<?php echo $equipos_list->MultiSelectKey ?>
<?php } ?>
<?php if ($equipos->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($equipos_list->Recordset)
	$equipos_list->Recordset->Close();
?>
<?php if ($equipos->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($equipos->CurrentAction <> "gridadd" && $equipos->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($equipos_list->Pager)) $equipos_list->Pager = new cPrevNextPager($equipos_list->StartRec, $equipos_list->DisplayRecs, $equipos_list->TotalRecs) ?>
<?php if ($equipos_list->Pager->RecordCount > 0 && $equipos_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($equipos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($equipos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $equipos_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($equipos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($equipos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $equipos_list->PageUrl() ?>start=<?php echo $equipos_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $equipos_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $equipos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $equipos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $equipos_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($equipos_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($equipos_list->TotalRecs == 0 && $equipos->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($equipos_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($equipos->Export == "") { ?>
<script type="text/javascript">
fequiposlistsrch.FilterList = <?php echo $equipos_list->GetFilterList() ?>;
fequiposlistsrch.Init();
fequiposlist.Init();
</script>
<?php } ?>
<?php
$equipos_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($equipos->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$equipos_list->Page_Terminate();
?>
