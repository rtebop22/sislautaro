<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tutoresinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "observacion_tutorgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tutores_list = NULL; // Initialize page object first

class ctutores_list extends ctutores {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'tutores';

	// Page object name
	var $PageObjName = 'tutores_list';

	// Grid form hidden field names
	var $FormName = 'ftutoreslist';
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

		// Table object (tutores)
		if (!isset($GLOBALS["tutores"]) || get_class($GLOBALS["tutores"]) == "ctutores") {
			$GLOBALS["tutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tutores"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tutoresadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tutoresdelete.php";
		$this->MultiUpdateUrl = "tutoresupdate.php";

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tutores', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftutoreslistsrch";

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
		$this->Dni_Tutor->SetVisibility();
		$this->Apellidos_Nombres->SetVisibility();
		$this->Tel_Contacto->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Id_Relacion->SetVisibility();
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

			// Process auto fill for detail table 'observacion_tutor'
			if (@$_POST["grid"] == "fobservacion_tutorgrid") {
				if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid;
				$GLOBALS["observacion_tutor_grid"]->Page_Init();
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
		global $EW_EXPORT, $tutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tutores);
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
	var $observacion_tutor_Count;
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
		$this->setKey("Dni_Tutor", ""); // Clear inline edit key
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
		if (@$_GET["Dni_Tutor"] <> "") {
			$this->Dni_Tutor->setQueryStringValue($_GET["Dni_Tutor"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Dni_Tutor", $this->Dni_Tutor->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Dni_Tutor")) <> strval($this->Dni_Tutor->CurrentValue))
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
			$this->Dni_Tutor->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Dni_Tutor->FormValue))
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
					$sKey .= $this->Dni_Tutor->CurrentValue;

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
		if ($objForm->HasValue("x_Dni_Tutor") && $objForm->HasValue("o_Dni_Tutor") && $this->Dni_Tutor->CurrentValue <> $this->Dni_Tutor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Apellidos_Nombres") && $objForm->HasValue("o_Apellidos_Nombres") && $this->Apellidos_Nombres->CurrentValue <> $this->Apellidos_Nombres->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Tel_Contacto") && $objForm->HasValue("o_Tel_Contacto") && $this->Tel_Contacto->CurrentValue <> $this->Tel_Contacto->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cuil") && $objForm->HasValue("o_Cuil") && $this->Cuil->CurrentValue <> $this->Cuil->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Relacion") && $objForm->HasValue("o_Id_Relacion") && $this->Id_Relacion->CurrentValue <> $this->Id_Relacion->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "ftutoreslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Dni_Tutor->AdvancedSearch->ToJSON(), ","); // Field Dni_Tutor
		$sFilterList = ew_Concat($sFilterList, $this->Apellidos_Nombres->AdvancedSearch->ToJSON(), ","); // Field Apellidos_Nombres
		$sFilterList = ew_Concat($sFilterList, $this->Edad->AdvancedSearch->ToJSON(), ","); // Field Edad
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Tel_Contacto->AdvancedSearch->ToJSON(), ","); // Field Tel_Contacto
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Nac->AdvancedSearch->ToJSON(), ","); // Field Fecha_Nac
		$sFilterList = ew_Concat($sFilterList, $this->Cuil->AdvancedSearch->ToJSON(), ","); // Field Cuil
		$sFilterList = ew_Concat($sFilterList, $this->MasHijos->AdvancedSearch->ToJSON(), ","); // Field MasHijos
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Civil->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Civil
		$sFilterList = ew_Concat($sFilterList, $this->Id_Sexo->AdvancedSearch->ToJSON(), ","); // Field Id_Sexo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Relacion->AdvancedSearch->ToJSON(), ","); // Field Id_Relacion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Ocupacion->AdvancedSearch->ToJSON(), ","); // Field Id_Ocupacion
		$sFilterList = ew_Concat($sFilterList, $this->Lugar_Nacimiento->AdvancedSearch->ToJSON(), ","); // Field Lugar_Nacimiento
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftutoreslistsrch", $filters);
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

		// Field Dni_Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = @$filter["x_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$filter["z_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchCondition = @$filter["v_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchValue2 = @$filter["y_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator2 = @$filter["w_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->Save();

		// Field Apellidos_Nombres
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = @$filter["x_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = @$filter["z_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchCondition = @$filter["v_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue2 = @$filter["y_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator2 = @$filter["w_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->Save();

		// Field Edad
		$this->Edad->AdvancedSearch->SearchValue = @$filter["x_Edad"];
		$this->Edad->AdvancedSearch->SearchOperator = @$filter["z_Edad"];
		$this->Edad->AdvancedSearch->SearchCondition = @$filter["v_Edad"];
		$this->Edad->AdvancedSearch->SearchValue2 = @$filter["y_Edad"];
		$this->Edad->AdvancedSearch->SearchOperator2 = @$filter["w_Edad"];
		$this->Edad->AdvancedSearch->Save();

		// Field Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = @$filter["x_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchOperator = @$filter["z_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchCondition = @$filter["v_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchValue2 = @$filter["y_Domicilio"];
		$this->Domicilio->AdvancedSearch->SearchOperator2 = @$filter["w_Domicilio"];
		$this->Domicilio->AdvancedSearch->Save();

		// Field Tel_Contacto
		$this->Tel_Contacto->AdvancedSearch->SearchValue = @$filter["x_Tel_Contacto"];
		$this->Tel_Contacto->AdvancedSearch->SearchOperator = @$filter["z_Tel_Contacto"];
		$this->Tel_Contacto->AdvancedSearch->SearchCondition = @$filter["v_Tel_Contacto"];
		$this->Tel_Contacto->AdvancedSearch->SearchValue2 = @$filter["y_Tel_Contacto"];
		$this->Tel_Contacto->AdvancedSearch->SearchOperator2 = @$filter["w_Tel_Contacto"];
		$this->Tel_Contacto->AdvancedSearch->Save();

		// Field Fecha_Nac
		$this->Fecha_Nac->AdvancedSearch->SearchValue = @$filter["x_Fecha_Nac"];
		$this->Fecha_Nac->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Nac"];
		$this->Fecha_Nac->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Nac"];
		$this->Fecha_Nac->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Nac"];
		$this->Fecha_Nac->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Nac"];
		$this->Fecha_Nac->AdvancedSearch->Save();

		// Field Cuil
		$this->Cuil->AdvancedSearch->SearchValue = @$filter["x_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator = @$filter["z_Cuil"];
		$this->Cuil->AdvancedSearch->SearchCondition = @$filter["v_Cuil"];
		$this->Cuil->AdvancedSearch->SearchValue2 = @$filter["y_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil"];
		$this->Cuil->AdvancedSearch->Save();

		// Field MasHijos
		$this->MasHijos->AdvancedSearch->SearchValue = @$filter["x_MasHijos"];
		$this->MasHijos->AdvancedSearch->SearchOperator = @$filter["z_MasHijos"];
		$this->MasHijos->AdvancedSearch->SearchCondition = @$filter["v_MasHijos"];
		$this->MasHijos->AdvancedSearch->SearchValue2 = @$filter["y_MasHijos"];
		$this->MasHijos->AdvancedSearch->SearchOperator2 = @$filter["w_MasHijos"];
		$this->MasHijos->AdvancedSearch->Save();

		// Field Id_Estado_Civil
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue = @$filter["x_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->Save();

		// Field Id_Sexo
		$this->Id_Sexo->AdvancedSearch->SearchValue = @$filter["x_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchOperator = @$filter["z_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchCondition = @$filter["v_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->Save();

		// Field Id_Relacion
		$this->Id_Relacion->AdvancedSearch->SearchValue = @$filter["x_Id_Relacion"];
		$this->Id_Relacion->AdvancedSearch->SearchOperator = @$filter["z_Id_Relacion"];
		$this->Id_Relacion->AdvancedSearch->SearchCondition = @$filter["v_Id_Relacion"];
		$this->Id_Relacion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Relacion"];
		$this->Id_Relacion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Relacion"];
		$this->Id_Relacion->AdvancedSearch->Save();

		// Field Id_Ocupacion
		$this->Id_Ocupacion->AdvancedSearch->SearchValue = @$filter["x_Id_Ocupacion"];
		$this->Id_Ocupacion->AdvancedSearch->SearchOperator = @$filter["z_Id_Ocupacion"];
		$this->Id_Ocupacion->AdvancedSearch->SearchCondition = @$filter["v_Id_Ocupacion"];
		$this->Id_Ocupacion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Ocupacion"];
		$this->Id_Ocupacion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Ocupacion"];
		$this->Id_Ocupacion->AdvancedSearch->Save();

		// Field Lugar_Nacimiento
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue = @$filter["x_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator = @$filter["z_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchCondition = @$filter["v_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue2 = @$filter["y_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->Save();

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
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Dni_Tutor, $Default, FALSE); // Dni_Tutor
		$this->BuildSearchSql($sWhere, $this->Apellidos_Nombres, $Default, FALSE); // Apellidos_Nombres
		$this->BuildSearchSql($sWhere, $this->Edad, $Default, FALSE); // Edad
		$this->BuildSearchSql($sWhere, $this->Domicilio, $Default, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Tel_Contacto, $Default, FALSE); // Tel_Contacto
		$this->BuildSearchSql($sWhere, $this->Fecha_Nac, $Default, FALSE); // Fecha_Nac
		$this->BuildSearchSql($sWhere, $this->Cuil, $Default, FALSE); // Cuil
		$this->BuildSearchSql($sWhere, $this->MasHijos, $Default, FALSE); // MasHijos
		$this->BuildSearchSql($sWhere, $this->Id_Estado_Civil, $Default, FALSE); // Id_Estado_Civil
		$this->BuildSearchSql($sWhere, $this->Id_Sexo, $Default, FALSE); // Id_Sexo
		$this->BuildSearchSql($sWhere, $this->Id_Relacion, $Default, FALSE); // Id_Relacion
		$this->BuildSearchSql($sWhere, $this->Id_Ocupacion, $Default, FALSE); // Id_Ocupacion
		$this->BuildSearchSql($sWhere, $this->Lugar_Nacimiento, $Default, FALSE); // Lugar_Nacimiento
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
			$this->Dni_Tutor->AdvancedSearch->Save(); // Dni_Tutor
			$this->Apellidos_Nombres->AdvancedSearch->Save(); // Apellidos_Nombres
			$this->Edad->AdvancedSearch->Save(); // Edad
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Tel_Contacto->AdvancedSearch->Save(); // Tel_Contacto
			$this->Fecha_Nac->AdvancedSearch->Save(); // Fecha_Nac
			$this->Cuil->AdvancedSearch->Save(); // Cuil
			$this->MasHijos->AdvancedSearch->Save(); // MasHijos
			$this->Id_Estado_Civil->AdvancedSearch->Save(); // Id_Estado_Civil
			$this->Id_Sexo->AdvancedSearch->Save(); // Id_Sexo
			$this->Id_Relacion->AdvancedSearch->Save(); // Id_Relacion
			$this->Id_Ocupacion->AdvancedSearch->Save(); // Id_Ocupacion
			$this->Lugar_Nacimiento->AdvancedSearch->Save(); // Lugar_Nacimiento
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
		$this->BuildBasicSearchSQL($sWhere, $this->Dni_Tutor, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Apellidos_Nombres, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MasHijos, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Relacion, $arKeywords, $type);
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
		if ($this->Dni_Tutor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Apellidos_Nombres->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Edad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Contacto->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Nac->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->MasHijos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado_Civil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Sexo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Relacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Ocupacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Lugar_Nacimiento->AdvancedSearch->IssetSession())
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
		$this->Dni_Tutor->AdvancedSearch->UnsetSession();
		$this->Apellidos_Nombres->AdvancedSearch->UnsetSession();
		$this->Edad->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Tel_Contacto->AdvancedSearch->UnsetSession();
		$this->Fecha_Nac->AdvancedSearch->UnsetSession();
		$this->Cuil->AdvancedSearch->UnsetSession();
		$this->MasHijos->AdvancedSearch->UnsetSession();
		$this->Id_Estado_Civil->AdvancedSearch->UnsetSession();
		$this->Id_Sexo->AdvancedSearch->UnsetSession();
		$this->Id_Relacion->AdvancedSearch->UnsetSession();
		$this->Id_Ocupacion->AdvancedSearch->UnsetSession();
		$this->Lugar_Nacimiento->AdvancedSearch->UnsetSession();
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
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Contacto->AdvancedSearch->Load();
		$this->Fecha_Nac->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->MasHijos->AdvancedSearch->Load();
		$this->Id_Estado_Civil->AdvancedSearch->Load();
		$this->Id_Sexo->AdvancedSearch->Load();
		$this->Id_Relacion->AdvancedSearch->Load();
		$this->Id_Ocupacion->AdvancedSearch->Load();
		$this->Lugar_Nacimiento->AdvancedSearch->Load();
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
			$this->UpdateSort($this->Dni_Tutor); // Dni_Tutor
			$this->UpdateSort($this->Apellidos_Nombres); // Apellidos_Nombres
			$this->UpdateSort($this->Tel_Contacto); // Tel_Contacto
			$this->UpdateSort($this->Cuil); // Cuil
			$this->UpdateSort($this->Id_Relacion); // Id_Relacion
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
				$this->Dni_Tutor->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Dni_Tutor->setSort("");
				$this->Apellidos_Nombres->setSort("");
				$this->Tel_Contacto->setSort("");
				$this->Cuil->setSort("");
				$this->Id_Relacion->setSort("");
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

		// "detail_observacion_tutor"
		$item = &$this->ListOptions->Add("detail_observacion_tutor");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'observacion_tutor') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid;

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
		$pages->Add("observacion_tutor");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Dni_Tutor->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"tutores\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"tutores\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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

		// "detail_observacion_tutor"
		$oListOpt = &$this->ListOptions->Items["detail_observacion_tutor"];
		if ($Security->AllowList(CurrentProjectID() . 'observacion_tutor')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("observacion_tutor", "TblCaption");
			$body .= str_replace("%c", $this->observacion_tutor_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("observacion_tutorlist.php?" . EW_TABLE_SHOW_MASTER . "=tutores&fk_Dni_Tutor=" . urlencode(strval($this->Dni_Tutor->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["observacion_tutor_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'observacion_tutor')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=observacion_tutor")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "observacion_tutor";
			}
			if ($GLOBALS["observacion_tutor_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'observacion_tutor')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=observacion_tutor")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "observacion_tutor";
			}
			if ($GLOBALS["observacion_tutor_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'observacion_tutor')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=observacion_tutor")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "observacion_tutor";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Dni_Tutor->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Dni_Tutor->CurrentValue . "\">";
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
		$item = &$option->Add("detailadd_observacion_tutor");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=observacion_tutor");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["observacion_tutor"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["observacion_tutor"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'observacion_tutor') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "observacion_tutor";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ftutoreslist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"tutores\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.ftutoreslist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftutoreslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftutoreslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftutoreslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftutoreslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"tutoressrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Dni_Tutor->CurrentValue = NULL;
		$this->Dni_Tutor->OldValue = $this->Dni_Tutor->CurrentValue;
		$this->Apellidos_Nombres->CurrentValue = NULL;
		$this->Apellidos_Nombres->OldValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Tel_Contacto->CurrentValue = NULL;
		$this->Tel_Contacto->OldValue = $this->Tel_Contacto->CurrentValue;
		$this->Cuil->CurrentValue = NULL;
		$this->Cuil->OldValue = $this->Cuil->CurrentValue;
		$this->Id_Relacion->CurrentValue = 1;
		$this->Id_Relacion->OldValue = $this->Id_Relacion->CurrentValue;
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
		// Dni_Tutor

		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni_Tutor"]);
		if ($this->Dni_Tutor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$_GET["z_Dni_Tutor"];

		// Apellidos_Nombres
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellidos_Nombres"]);
		if ($this->Apellidos_Nombres->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = @$_GET["z_Apellidos_Nombres"];

		// Edad
		$this->Edad->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Edad"]);
		if ($this->Edad->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Edad->AdvancedSearch->SearchOperator = @$_GET["z_Edad"];

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Domicilio"]);
		if ($this->Domicilio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Domicilio->AdvancedSearch->SearchOperator = @$_GET["z_Domicilio"];

		// Tel_Contacto
		$this->Tel_Contacto->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tel_Contacto"]);
		if ($this->Tel_Contacto->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tel_Contacto->AdvancedSearch->SearchOperator = @$_GET["z_Tel_Contacto"];

		// Fecha_Nac
		$this->Fecha_Nac->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Nac"]);
		if ($this->Fecha_Nac->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Nac->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Nac"];

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil"]);
		if ($this->Cuil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil->AdvancedSearch->SearchOperator = @$_GET["z_Cuil"];

		// MasHijos
		$this->MasHijos->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_MasHijos"]);
		if ($this->MasHijos->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->MasHijos->AdvancedSearch->SearchOperator = @$_GET["z_MasHijos"];

		// Id_Estado_Civil
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado_Civil"]);
		if ($this->Id_Estado_Civil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado_Civil"];

		// Id_Sexo
		$this->Id_Sexo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Sexo"]);
		if ($this->Id_Sexo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Sexo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Sexo"];

		// Id_Relacion
		$this->Id_Relacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Relacion"]);
		if ($this->Id_Relacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Relacion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Relacion"];

		// Id_Ocupacion
		$this->Id_Ocupacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Ocupacion"]);
		if ($this->Id_Ocupacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Ocupacion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Ocupacion"];

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Lugar_Nacimiento"]);
		if ($this->Lugar_Nacimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator = @$_GET["z_Lugar_Nacimiento"];

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
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		$this->Dni_Tutor->setOldValue($objForm->GetValue("o_Dni_Tutor"));
		if (!$this->Apellidos_Nombres->FldIsDetailKey) {
			$this->Apellidos_Nombres->setFormValue($objForm->GetValue("x_Apellidos_Nombres"));
		}
		$this->Apellidos_Nombres->setOldValue($objForm->GetValue("o_Apellidos_Nombres"));
		if (!$this->Tel_Contacto->FldIsDetailKey) {
			$this->Tel_Contacto->setFormValue($objForm->GetValue("x_Tel_Contacto"));
		}
		$this->Tel_Contacto->setOldValue($objForm->GetValue("o_Tel_Contacto"));
		if (!$this->Cuil->FldIsDetailKey) {
			$this->Cuil->setFormValue($objForm->GetValue("x_Cuil"));
		}
		$this->Cuil->setOldValue($objForm->GetValue("o_Cuil"));
		if (!$this->Id_Relacion->FldIsDetailKey) {
			$this->Id_Relacion->setFormValue($objForm->GetValue("x_Id_Relacion"));
		}
		$this->Id_Relacion->setOldValue($objForm->GetValue("o_Id_Relacion"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Apellidos_Nombres->CurrentValue = $this->Apellidos_Nombres->FormValue;
		$this->Tel_Contacto->CurrentValue = $this->Tel_Contacto->FormValue;
		$this->Cuil->CurrentValue = $this->Cuil->FormValue;
		$this->Id_Relacion->CurrentValue = $this->Id_Relacion->FormValue;
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
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Contacto->setDbValue($rs->fields('Tel_Contacto'));
		$this->Fecha_Nac->setDbValue($rs->fields('Fecha_Nac'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->MasHijos->setDbValue($rs->fields('MasHijos'));
		$this->Id_Estado_Civil->setDbValue($rs->fields('Id_Estado_Civil'));
		$this->Id_Sexo->setDbValue($rs->fields('Id_Sexo'));
		$this->Id_Relacion->setDbValue($rs->fields('Id_Relacion'));
		$this->Id_Ocupacion->setDbValue($rs->fields('Id_Ocupacion'));
		$this->Lugar_Nacimiento->setDbValue($rs->fields('Lugar_Nacimiento'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		if (!isset($GLOBALS["observacion_tutor_grid"])) $GLOBALS["observacion_tutor_grid"] = new cobservacion_tutor_grid;
		$sDetailFilter = $GLOBALS["observacion_tutor"]->SqlDetailFilter_tutores();
		$sDetailFilter = str_replace("@Dni_Tutor@", ew_AdjustSql($this->Dni_Tutor->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["observacion_tutor"]->setCurrentMasterTable("tutores");
		$sDetailFilter = $GLOBALS["observacion_tutor"]->ApplyUserIDFilters($sDetailFilter);
		$this->observacion_tutor_Count = $GLOBALS["observacion_tutor"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Apellidos_Nombres->DbValue = $row['Apellidos_Nombres'];
		$this->Edad->DbValue = $row['Edad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Tel_Contacto->DbValue = $row['Tel_Contacto'];
		$this->Fecha_Nac->DbValue = $row['Fecha_Nac'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->MasHijos->DbValue = $row['MasHijos'];
		$this->Id_Estado_Civil->DbValue = $row['Id_Estado_Civil'];
		$this->Id_Sexo->DbValue = $row['Id_Sexo'];
		$this->Id_Relacion->DbValue = $row['Id_Relacion'];
		$this->Id_Ocupacion->DbValue = $row['Id_Ocupacion'];
		$this->Lugar_Nacimiento->DbValue = $row['Lugar_Nacimiento'];
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
		if (strval($this->getKey("Dni_Tutor")) <> "")
			$this->Dni_Tutor->CurrentValue = $this->getKey("Dni_Tutor"); // Dni_Tutor
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
		// Dni_Tutor
		// Apellidos_Nombres
		// Edad
		// Domicilio
		// Tel_Contacto
		// Fecha_Nac
		// Cuil
		// MasHijos
		// Id_Estado_Civil
		// Id_Sexo
		// Id_Relacion
		// Id_Ocupacion
		// Lugar_Nacimiento
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Edad
		$this->Edad->ViewValue = $this->Edad->CurrentValue;
		$this->Edad->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Contacto
		$this->Tel_Contacto->ViewValue = $this->Tel_Contacto->CurrentValue;
		$this->Tel_Contacto->ViewCustomAttributes = "";

		// Fecha_Nac
		$this->Fecha_Nac->ViewValue = $this->Fecha_Nac->CurrentValue;
		$this->Fecha_Nac->ViewValue = ew_FormatDateTime($this->Fecha_Nac->ViewValue, 7);
		$this->Fecha_Nac->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// MasHijos
		if (strval($this->MasHijos->CurrentValue) <> "") {
			$this->MasHijos->ViewValue = $this->MasHijos->OptionCaption($this->MasHijos->CurrentValue);
		} else {
			$this->MasHijos->ViewValue = NULL;
		}
		$this->MasHijos->ViewCustomAttributes = "";

		// Id_Estado_Civil
		if (strval($this->Id_Estado_Civil->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Civil`" . ew_SearchString("=", $this->Id_Estado_Civil->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Civil`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_civil`";
		$sWhereWrk = "";
		$this->Id_Estado_Civil->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->CurrentValue;
			}
		} else {
			$this->Id_Estado_Civil->ViewValue = NULL;
		}
		$this->Id_Estado_Civil->ViewCustomAttributes = "";

		// Id_Sexo
		if (strval($this->Id_Sexo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sexo`" . ew_SearchString("=", $this->Id_Sexo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sexo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sexo_personas`";
		$sWhereWrk = "";
		$this->Id_Sexo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->CurrentValue;
			}
		} else {
			$this->Id_Sexo->ViewValue = NULL;
		}
		$this->Id_Sexo->ViewCustomAttributes = "";

		// Id_Relacion
		if (strval($this->Id_Relacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
		$sWhereWrk = "";
		$this->Id_Relacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Desripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->CurrentValue;
			}
		} else {
			$this->Id_Relacion->ViewValue = NULL;
		}
		$this->Id_Relacion->ViewCustomAttributes = "";

		// Id_Ocupacion
		if (strval($this->Id_Ocupacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ocupacion`" . ew_SearchString("=", $this->Id_Ocupacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
		$sWhereWrk = "";
		$this->Id_Ocupacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->CurrentValue;
			}
		} else {
			$this->Id_Ocupacion->ViewValue = NULL;
		}
		$this->Id_Ocupacion->ViewCustomAttributes = "";

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->ViewValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";
			$this->Apellidos_Nombres->TooltipValue = "";

			// Tel_Contacto
			$this->Tel_Contacto->LinkCustomAttributes = "";
			$this->Tel_Contacto->HrefValue = "";
			$this->Tel_Contacto->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Id_Relacion
			$this->Id_Relacion->LinkCustomAttributes = "";
			$this->Id_Relacion->HrefValue = "";
			$this->Id_Relacion->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			if ($this->Dni_Tutor->getSessionValue() <> "") {
				$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->getSessionValue();
				$this->Dni_Tutor->OldValue = $this->Dni_Tutor->CurrentValue;
			$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			$this->Dni_Tutor->ViewCustomAttributes = "";
			} else {
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());
			}

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Tel_Contacto
			$this->Tel_Contacto->EditAttrs["class"] = "form-control";
			$this->Tel_Contacto->EditCustomAttributes = "";
			$this->Tel_Contacto->EditValue = ew_HtmlEncode($this->Tel_Contacto->CurrentValue);
			$this->Tel_Contacto->PlaceHolder = ew_RemoveHtml($this->Tel_Contacto->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Id_Relacion
			$this->Id_Relacion->EditAttrs["class"] = "form-control";
			$this->Id_Relacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Relacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Desripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Relacion->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Dni_Tutor

			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Tel_Contacto
			$this->Tel_Contacto->LinkCustomAttributes = "";
			$this->Tel_Contacto->HrefValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// Id_Relacion
			$this->Id_Relacion->LinkCustomAttributes = "";
			$this->Id_Relacion->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = $this->Dni_Tutor->CurrentValue;
			$this->Dni_Tutor->ViewCustomAttributes = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Tel_Contacto
			$this->Tel_Contacto->EditAttrs["class"] = "form-control";
			$this->Tel_Contacto->EditCustomAttributes = "";
			$this->Tel_Contacto->EditValue = ew_HtmlEncode($this->Tel_Contacto->CurrentValue);
			$this->Tel_Contacto->PlaceHolder = ew_RemoveHtml($this->Tel_Contacto->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->CurrentValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Id_Relacion
			$this->Id_Relacion->EditAttrs["class"] = "form-control";
			$this->Id_Relacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Relacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Desripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Relacion->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Dni_Tutor

			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Tel_Contacto
			$this->Tel_Contacto->LinkCustomAttributes = "";
			$this->Tel_Contacto->HrefValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";

			// Id_Relacion
			$this->Id_Relacion->LinkCustomAttributes = "";
			$this->Id_Relacion->HrefValue = "";

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
		if (!$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni_Tutor->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni_Tutor->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Tel_Contacto->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tel_Contacto->FldErrMsg());
		}
		if (!$this->Id_Relacion->FldIsDetailKey && !is_null($this->Id_Relacion->FormValue) && $this->Id_Relacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Relacion->FldCaption(), $this->Id_Relacion->ReqErrMsg));
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
				$sThisKey .= $row['Dni_Tutor'];
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

			// Dni_Tutor
			// Apellidos_Nombres

			$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, $this->Apellidos_Nombres->ReadOnly);

			// Tel_Contacto
			$this->Tel_Contacto->SetDbValueDef($rsnew, $this->Tel_Contacto->CurrentValue, NULL, $this->Tel_Contacto->ReadOnly);

			// Cuil
			$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, $this->Cuil->ReadOnly);

			// Id_Relacion
			$this->Id_Relacion->SetDbValueDef($rsnew, $this->Id_Relacion->CurrentValue, 0, $this->Id_Relacion->ReadOnly);

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

		// Dni_Tutor
		$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, strval($this->Dni_Tutor->CurrentValue) == "");

		// Apellidos_Nombres
		$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, FALSE);

		// Tel_Contacto
		$this->Tel_Contacto->SetDbValueDef($rsnew, $this->Tel_Contacto->CurrentValue, NULL, FALSE);

		// Cuil
		$this->Cuil->SetDbValueDef($rsnew, $this->Cuil->CurrentValue, NULL, FALSE);

		// Id_Relacion
		$this->Id_Relacion->SetDbValueDef($rsnew, $this->Id_Relacion->CurrentValue, 0, FALSE);

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
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Dni_Tutor']) == "") {
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
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Contacto->AdvancedSearch->Load();
		$this->Fecha_Nac->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->MasHijos->AdvancedSearch->Load();
		$this->Id_Estado_Civil->AdvancedSearch->Load();
		$this->Id_Sexo->AdvancedSearch->Load();
		$this->Id_Relacion->AdvancedSearch->Load();
		$this->Id_Ocupacion->AdvancedSearch->Load();
		$this->Lugar_Nacimiento->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_tutores\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tutores',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftutoreslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
				if (@$_GET["fk_Dni_Tutor"] <> "") {
					$GLOBALS["personas"]->Dni_Tutor->setQueryStringValue($_GET["fk_Dni_Tutor"]);
					$this->Dni_Tutor->setQueryStringValue($GLOBALS["personas"]->Dni_Tutor->QueryStringValue);
					$this->Dni_Tutor->setSessionValue($this->Dni_Tutor->QueryStringValue);
					if (!is_numeric($GLOBALS["personas"]->Dni_Tutor->QueryStringValue)) $bValidMaster = FALSE;
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
				if (@$_POST["fk_Dni_Tutor"] <> "") {
					$GLOBALS["personas"]->Dni_Tutor->setFormValue($_POST["fk_Dni_Tutor"]);
					$this->Dni_Tutor->setFormValue($GLOBALS["personas"]->Dni_Tutor->FormValue);
					$this->Dni_Tutor->setSessionValue($this->Dni_Tutor->FormValue);
					if (!is_numeric($GLOBALS["personas"]->Dni_Tutor->FormValue)) $bValidMaster = FALSE;
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
				if ($this->Dni_Tutor->CurrentValue == "") $this->Dni_Tutor->setSessionValue("");
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
		case "x_Id_Relacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Relacion` AS `LinkFld`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Relacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Desripcion` ASC";
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
		$table = 'tutores';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tutores';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dni_Tutor'];

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
		$table = 'tutores';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni_Tutor'];

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
		$table = 'tutores';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dni_Tutor'];

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
if (!isset($tutores_list)) $tutores_list = new ctutores_list();

// Page init
$tutores_list->Page_Init();

// Page main
$tutores_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tutores_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($tutores->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftutoreslist = new ew_Form("ftutoreslist", "list");
ftutoreslist.FormKeyCountName = '<?php echo $tutores_list->FormKeyCountName ?>';

// Validate form
ftutoreslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Dni_Tutor->FldCaption(), $tutores->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tel_Contacto");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Tel_Contacto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Relacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Relacion->FldCaption(), $tutores->Id_Relacion->ReqErrMsg)) ?>");

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
ftutoreslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Dni_Tutor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Apellidos_Nombres", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tel_Contacto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Relacion", false)) return false;
	return true;
}

// Form_CustomValidate event
ftutoreslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftutoreslist.ValidateRequired = true;
<?php } else { ?>
ftutoreslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftutoreslist.Lists["x_Id_Relacion"] = {"LinkField":"x_Id_Relacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Desripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_relacion_alumno_tutor"};

// Form object for search
var CurrentSearchForm = ftutoreslistsrch = new ew_Form("ftutoreslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tutores->Export == "") { ?>
<div class="ewToolbar">
<?php if ($tutores->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($tutores_list->TotalRecs > 0 && $tutores_list->ExportOptions->Visible()) { ?>
<?php $tutores_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($tutores_list->SearchOptions->Visible()) { ?>
<?php $tutores_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($tutores_list->FilterOptions->Visible()) { ?>
<?php $tutores_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($tutores->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($tutores->Export == "") || (EW_EXPORT_MASTER_RECORD && $tutores->Export == "print")) { ?>
<?php
if ($tutores_list->DbMasterFilter <> "" && $tutores->getCurrentMasterTable() == "personas") {
	if ($tutores_list->MasterRecordExists) {
?>
<?php include_once "personasmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($tutores->CurrentAction == "gridadd") {
	$tutores->CurrentFilter = "0=1";
	$tutores_list->StartRec = 1;
	$tutores_list->DisplayRecs = $tutores->GridAddRowCount;
	$tutores_list->TotalRecs = $tutores_list->DisplayRecs;
	$tutores_list->StopRec = $tutores_list->DisplayRecs;
} else {
	$bSelectLimit = $tutores_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tutores_list->TotalRecs <= 0)
			$tutores_list->TotalRecs = $tutores->SelectRecordCount();
	} else {
		if (!$tutores_list->Recordset && ($tutores_list->Recordset = $tutores_list->LoadRecordset()))
			$tutores_list->TotalRecs = $tutores_list->Recordset->RecordCount();
	}
	$tutores_list->StartRec = 1;
	if ($tutores_list->DisplayRecs <= 0 || ($tutores->Export <> "" && $tutores->ExportAll)) // Display all records
		$tutores_list->DisplayRecs = $tutores_list->TotalRecs;
	if (!($tutores->Export <> "" && $tutores->ExportAll))
		$tutores_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tutores_list->Recordset = $tutores_list->LoadRecordset($tutores_list->StartRec-1, $tutores_list->DisplayRecs);

	// Set no record found message
	if ($tutores->CurrentAction == "" && $tutores_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$tutores_list->setWarningMessage(ew_DeniedMsg());
		if ($tutores_list->SearchWhere == "0=101")
			$tutores_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tutores_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($tutores_list->AuditTrailOnSearch && $tutores_list->Command == "search" && !$tutores_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $tutores_list->getSessionWhere();
		$tutores_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$tutores_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tutores->Export == "" && $tutores->CurrentAction == "") { ?>
<form name="ftutoreslistsrch" id="ftutoreslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($tutores_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftutoreslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tutores">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($tutores_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($tutores_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $tutores_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($tutores_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($tutores_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($tutores_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($tutores_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $tutores_list->ShowPageHeader(); ?>
<?php
$tutores_list->ShowMessage();
?>
<?php if ($tutores_list->TotalRecs > 0 || $tutores->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tutores">
<?php if ($tutores->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($tutores->CurrentAction <> "gridadd" && $tutores->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tutores_list->Pager)) $tutores_list->Pager = new cPrevNextPager($tutores_list->StartRec, $tutores_list->DisplayRecs, $tutores_list->TotalRecs) ?>
<?php if ($tutores_list->Pager->RecordCount > 0 && $tutores_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tutores_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tutores_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tutores_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tutores_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tutores_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tutores_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tutores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tutores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tutores_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tutores_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftutoreslist" id="ftutoreslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tutores_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tutores_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tutores">
<?php if ($tutores->getCurrentMasterTable() == "personas" && $tutores->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="personas">
<input type="hidden" name="fk_Dni_Tutor" value="<?php echo $tutores->Dni_Tutor->getSessionValue() ?>">
<?php } ?>
<div id="gmp_tutores" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($tutores_list->TotalRecs > 0 || $tutores->CurrentAction == "add" || $tutores->CurrentAction == "copy") { ?>
<table id="tbl_tutoreslist" class="table ewTable">
<?php echo $tutores->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tutores_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tutores_list->RenderListOptions();

// Render list options (header, left)
$tutores_list->ListOptions->Render("header", "left");
?>
<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<?php if ($tutores->SortUrl($tutores->Dni_Tutor) == "") { ?>
		<th data-name="Dni_Tutor"><div id="elh_tutores_Dni_Tutor" class="tutores_Dni_Tutor"><div class="ewTableHeaderCaption"><?php echo $tutores->Dni_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni_Tutor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Dni_Tutor) ?>',1);"><div id="elh_tutores_Dni_Tutor" class="tutores_Dni_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Dni_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Dni_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<?php if ($tutores->SortUrl($tutores->Apellidos_Nombres) == "") { ?>
		<th data-name="Apellidos_Nombres"><div id="elh_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres"><div class="ewTableHeaderCaption"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellidos_Nombres"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Apellidos_Nombres) ?>',1);"><div id="elh_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Apellidos_Nombres->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Apellidos_Nombres->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
	<?php if ($tutores->SortUrl($tutores->Tel_Contacto) == "") { ?>
		<th data-name="Tel_Contacto"><div id="elh_tutores_Tel_Contacto" class="tutores_Tel_Contacto"><div class="ewTableHeaderCaption"><?php echo $tutores->Tel_Contacto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tel_Contacto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Tel_Contacto) ?>',1);"><div id="elh_tutores_Tel_Contacto" class="tutores_Tel_Contacto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Tel_Contacto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Tel_Contacto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Tel_Contacto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Cuil->Visible) { // Cuil ?>
	<?php if ($tutores->SortUrl($tutores->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_tutores_Cuil" class="tutores_Cuil"><div class="ewTableHeaderCaption"><?php echo $tutores->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Cuil) ?>',1);"><div id="elh_tutores_Cuil" class="tutores_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Cuil->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
	<?php if ($tutores->SortUrl($tutores->Id_Relacion) == "") { ?>
		<th data-name="Id_Relacion"><div id="elh_tutores_Id_Relacion" class="tutores_Id_Relacion"><div class="ewTableHeaderCaption"><?php echo $tutores->Id_Relacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Relacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Id_Relacion) ?>',1);"><div id="elh_tutores_Id_Relacion" class="tutores_Id_Relacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Id_Relacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Id_Relacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Id_Relacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($tutores->SortUrl($tutores->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_tutores_Fecha_Actualizacion" class="tutores_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $tutores->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Fecha_Actualizacion) ?>',1);"><div id="elh_tutores_Fecha_Actualizacion" class="tutores_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Usuario->Visible) { // Usuario ?>
	<?php if ($tutores->SortUrl($tutores->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_tutores_Usuario" class="tutores_Usuario"><div class="ewTableHeaderCaption"><?php echo $tutores->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tutores->SortUrl($tutores->Usuario) ?>',1);"><div id="elh_tutores_Usuario" class="tutores_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tutores_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($tutores->CurrentAction == "add" || $tutores->CurrentAction == "copy") {
		$tutores_list->RowIndex = 0;
		$tutores_list->KeyCount = $tutores_list->RowIndex;
		if ($tutores->CurrentAction == "add")
			$tutores_list->LoadDefaultValues();
		if ($tutores->EventCancelled) // Insert failed
			$tutores_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$tutores->ResetAttrs();
		$tutores->RowAttrs = array_merge($tutores->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_tutores', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$tutores->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tutores_list->RenderRow();

		// Render list options
		$tutores_list->RenderListOptions();
		$tutores_list->StartRowCnt = 0;
?>
	<tr<?php echo $tutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tutores_list->ListOptions->Render("body", "left", $tutores_list->RowCnt);
?>
	<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<?php if ($tutores->Dni_Tutor->getSessionValue() <> "") { ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<td data-name="Tel_Contacto">
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_list->RowIndex ?>_Cuil" id="x<?php echo $tutores_list->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_list->RowIndex ?>_Cuil" id="o<?php echo $tutores_list->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<td data-name="Id_Relacion">
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_list->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="tutores" data-field="x_Fecha_Actualizacion" name="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($tutores->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="tutores" data-field="x_Usuario" name="o<?php echo $tutores_list->RowIndex ?>_Usuario" id="o<?php echo $tutores_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($tutores->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tutores_list->ListOptions->Render("body", "right", $tutores_list->RowCnt);
?>
<script type="text/javascript">
ftutoreslist.UpdateOpts(<?php echo $tutores_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($tutores->ExportAll && $tutores->Export <> "") {
	$tutores_list->StopRec = $tutores_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tutores_list->TotalRecs > $tutores_list->StartRec + $tutores_list->DisplayRecs - 1)
		$tutores_list->StopRec = $tutores_list->StartRec + $tutores_list->DisplayRecs - 1;
	else
		$tutores_list->StopRec = $tutores_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tutores_list->FormKeyCountName) && ($tutores->CurrentAction == "gridadd" || $tutores->CurrentAction == "gridedit" || $tutores->CurrentAction == "F")) {
		$tutores_list->KeyCount = $objForm->GetValue($tutores_list->FormKeyCountName);
		$tutores_list->StopRec = $tutores_list->StartRec + $tutores_list->KeyCount - 1;
	}
}
$tutores_list->RecCnt = $tutores_list->StartRec - 1;
if ($tutores_list->Recordset && !$tutores_list->Recordset->EOF) {
	$tutores_list->Recordset->MoveFirst();
	$bSelectLimit = $tutores_list->UseSelectLimit;
	if (!$bSelectLimit && $tutores_list->StartRec > 1)
		$tutores_list->Recordset->Move($tutores_list->StartRec - 1);
} elseif (!$tutores->AllowAddDeleteRow && $tutores_list->StopRec == 0) {
	$tutores_list->StopRec = $tutores->GridAddRowCount;
}

// Initialize aggregate
$tutores->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tutores->ResetAttrs();
$tutores_list->RenderRow();
$tutores_list->EditRowCnt = 0;
if ($tutores->CurrentAction == "edit")
	$tutores_list->RowIndex = 1;
if ($tutores->CurrentAction == "gridadd")
	$tutores_list->RowIndex = 0;
if ($tutores->CurrentAction == "gridedit")
	$tutores_list->RowIndex = 0;
while ($tutores_list->RecCnt < $tutores_list->StopRec) {
	$tutores_list->RecCnt++;
	if (intval($tutores_list->RecCnt) >= intval($tutores_list->StartRec)) {
		$tutores_list->RowCnt++;
		if ($tutores->CurrentAction == "gridadd" || $tutores->CurrentAction == "gridedit" || $tutores->CurrentAction == "F") {
			$tutores_list->RowIndex++;
			$objForm->Index = $tutores_list->RowIndex;
			if ($objForm->HasValue($tutores_list->FormActionName))
				$tutores_list->RowAction = strval($objForm->GetValue($tutores_list->FormActionName));
			elseif ($tutores->CurrentAction == "gridadd")
				$tutores_list->RowAction = "insert";
			else
				$tutores_list->RowAction = "";
		}

		// Set up key count
		$tutores_list->KeyCount = $tutores_list->RowIndex;

		// Init row class and style
		$tutores->ResetAttrs();
		$tutores->CssClass = "";
		if ($tutores->CurrentAction == "gridadd") {
			$tutores_list->LoadDefaultValues(); // Load default values
		} else {
			$tutores_list->LoadRowValues($tutores_list->Recordset); // Load row values
		}
		$tutores->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tutores->CurrentAction == "gridadd") // Grid add
			$tutores->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tutores->CurrentAction == "gridadd" && $tutores->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tutores_list->RestoreCurrentRowFormValues($tutores_list->RowIndex); // Restore form values
		if ($tutores->CurrentAction == "edit") {
			if ($tutores_list->CheckInlineEditKey() && $tutores_list->EditRowCnt == 0) { // Inline edit
				$tutores->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($tutores->CurrentAction == "gridedit") { // Grid edit
			if ($tutores->EventCancelled) {
				$tutores_list->RestoreCurrentRowFormValues($tutores_list->RowIndex); // Restore form values
			}
			if ($tutores_list->RowAction == "insert")
				$tutores->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tutores->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tutores->CurrentAction == "edit" && $tutores->RowType == EW_ROWTYPE_EDIT && $tutores->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$tutores_list->RestoreFormValues(); // Restore form values
		}
		if ($tutores->CurrentAction == "gridedit" && ($tutores->RowType == EW_ROWTYPE_EDIT || $tutores->RowType == EW_ROWTYPE_ADD) && $tutores->EventCancelled) // Update failed
			$tutores_list->RestoreCurrentRowFormValues($tutores_list->RowIndex); // Restore form values
		if ($tutores->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tutores_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$tutores->RowAttrs = array_merge($tutores->RowAttrs, array('data-rowindex'=>$tutores_list->RowCnt, 'id'=>'r' . $tutores_list->RowCnt . '_tutores', 'data-rowtype'=>$tutores->RowType));

		// Render row
		$tutores_list->RenderRow();

		// Render list options
		$tutores_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tutores_list->RowAction <> "delete" && $tutores_list->RowAction <> "insertdelete" && !($tutores_list->RowAction == "insert" && $tutores->CurrentAction == "F" && $tutores_list->EmptyRow())) {
?>
	<tr<?php echo $tutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tutores_list->ListOptions->Render("body", "left", $tutores_list->RowCnt);
?>
	<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor"<?php echo $tutores->Dni_Tutor->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tutores->Dni_Tutor->getSessionValue() <> "") { ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Dni_Tutor" class="tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<?php echo $tutores->Dni_Tutor->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $tutores_list->PageObjName . "_row_" . $tutores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres"<?php echo $tutores->Apellidos_Nombres->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres">
<span<?php echo $tutores->Apellidos_Nombres->ViewAttributes() ?>>
<?php echo $tutores->Apellidos_Nombres->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<td data-name="Tel_Contacto"<?php echo $tutores->Tel_Contacto->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Tel_Contacto" class="tutores_Tel_Contacto">
<span<?php echo $tutores->Tel_Contacto->ViewAttributes() ?>>
<?php echo $tutores->Tel_Contacto->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $tutores->Cuil->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_list->RowIndex ?>_Cuil" id="x<?php echo $tutores_list->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_list->RowIndex ?>_Cuil" id="o<?php echo $tutores_list->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_list->RowIndex ?>_Cuil" id="x<?php echo $tutores_list->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Cuil" class="tutores_Cuil">
<span<?php echo $tutores->Cuil->ViewAttributes() ?>>
<?php echo $tutores->Cuil->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<td data-name="Id_Relacion"<?php echo $tutores->Id_Relacion->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_list->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_list->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Id_Relacion" class="tutores_Id_Relacion">
<span<?php echo $tutores->Id_Relacion->ViewAttributes() ?>>
<?php echo $tutores->Id_Relacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $tutores->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tutores" data-field="x_Fecha_Actualizacion" name="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($tutores->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Fecha_Actualizacion" class="tutores_Fecha_Actualizacion">
<span<?php echo $tutores->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $tutores->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $tutores->Usuario->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tutores" data-field="x_Usuario" name="o<?php echo $tutores_list->RowIndex ?>_Usuario" id="o<?php echo $tutores_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($tutores->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_list->RowCnt ?>_tutores_Usuario" class="tutores_Usuario">
<span<?php echo $tutores->Usuario->ViewAttributes() ?>>
<?php echo $tutores->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tutores_list->ListOptions->Render("body", "right", $tutores_list->RowCnt);
?>
	</tr>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD || $tutores->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftutoreslist.UpdateOpts(<?php echo $tutores_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tutores->CurrentAction <> "gridadd")
		if (!$tutores_list->Recordset->EOF) $tutores_list->Recordset->MoveNext();
}
?>
<?php
	if ($tutores->CurrentAction == "gridadd" || $tutores->CurrentAction == "gridedit") {
		$tutores_list->RowIndex = '$rowindex$';
		$tutores_list->LoadDefaultValues();

		// Set row properties
		$tutores->ResetAttrs();
		$tutores->RowAttrs = array_merge($tutores->RowAttrs, array('data-rowindex'=>$tutores_list->RowIndex, 'id'=>'r0_tutores', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tutores->RowAttrs["class"], "ewTemplate");
		$tutores->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tutores_list->RenderRow();

		// Render list options
		$tutores_list->RenderListOptions();
		$tutores_list->StartRowCnt = 0;
?>
	<tr<?php echo $tutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tutores_list->ListOptions->Render("body", "left", $tutores_list->RowIndex);
?>
	<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<?php if ($tutores->Dni_Tutor->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<span id="el$rowindex$_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<td data-name="Tel_Contacto">
<span id="el$rowindex$_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_list->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<span id="el$rowindex$_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_list->RowIndex ?>_Cuil" id="x<?php echo $tutores_list->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_list->RowIndex ?>_Cuil" id="o<?php echo $tutores_list->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<td data-name="Id_Relacion">
<span id="el$rowindex$_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_list->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_list->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_list->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="tutores" data-field="x_Fecha_Actualizacion" name="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $tutores_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($tutores->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="tutores" data-field="x_Usuario" name="o<?php echo $tutores_list->RowIndex ?>_Usuario" id="o<?php echo $tutores_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($tutores->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tutores_list->ListOptions->Render("body", "right", $tutores_list->RowCnt);
?>
<script type="text/javascript">
ftutoreslist.UpdateOpts(<?php echo $tutores_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tutores->CurrentAction == "add" || $tutores->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $tutores_list->FormKeyCountName ?>" id="<?php echo $tutores_list->FormKeyCountName ?>" value="<?php echo $tutores_list->KeyCount ?>">
<?php } ?>
<?php if ($tutores->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tutores_list->FormKeyCountName ?>" id="<?php echo $tutores_list->FormKeyCountName ?>" value="<?php echo $tutores_list->KeyCount ?>">
<?php echo $tutores_list->MultiSelectKey ?>
<?php } ?>
<?php if ($tutores->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $tutores_list->FormKeyCountName ?>" id="<?php echo $tutores_list->FormKeyCountName ?>" value="<?php echo $tutores_list->KeyCount ?>">
<?php } ?>
<?php if ($tutores->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tutores_list->FormKeyCountName ?>" id="<?php echo $tutores_list->FormKeyCountName ?>" value="<?php echo $tutores_list->KeyCount ?>">
<?php echo $tutores_list->MultiSelectKey ?>
<?php } ?>
<?php if ($tutores->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tutores_list->Recordset)
	$tutores_list->Recordset->Close();
?>
<?php if ($tutores->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($tutores->CurrentAction <> "gridadd" && $tutores->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tutores_list->Pager)) $tutores_list->Pager = new cPrevNextPager($tutores_list->StartRec, $tutores_list->DisplayRecs, $tutores_list->TotalRecs) ?>
<?php if ($tutores_list->Pager->RecordCount > 0 && $tutores_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tutores_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tutores_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tutores_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tutores_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tutores_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tutores_list->PageUrl() ?>start=<?php echo $tutores_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tutores_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tutores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tutores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tutores_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tutores_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($tutores_list->TotalRecs == 0 && $tutores->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tutores_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tutores->Export == "") { ?>
<script type="text/javascript">
ftutoreslistsrch.FilterList = <?php echo $tutores_list->GetFilterList() ?>;
ftutoreslistsrch.Init();
ftutoreslist.Init();
</script>
<?php } ?>
<?php
$tutores_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tutores->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tutores_list->Page_Terminate();
?>
