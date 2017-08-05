<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pedido_paquetesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pedido_paquetes_list = NULL; // Initialize page object first

class cpedido_paquetes_list extends cpedido_paquetes {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pedido_paquetes';

	// Page object name
	var $PageObjName = 'pedido_paquetes_list';

	// Grid form hidden field names
	var $FormName = 'fpedido_paqueteslist';
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

		// Table object (pedido_paquetes)
		if (!isset($GLOBALS["pedido_paquetes"]) || get_class($GLOBALS["pedido_paquetes"]) == "cpedido_paquetes") {
			$GLOBALS["pedido_paquetes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pedido_paquetes"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pedido_paquetesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pedido_paquetesdelete.php";
		$this->MultiUpdateUrl = "pedido_paquetesupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pedido_paquetes', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpedido_paqueteslistsrch";

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
		$this->Cue->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Id_Zona->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Id_Tipo_Extraccion->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->Id_Motivo->SetVisibility();
		$this->Serie_Server->SetVisibility();
		$this->Email_Solicitante->SetVisibility();
		$this->Id_Tipo_Paquete->SetVisibility();
		$this->Serie_Netbook->SetVisibility();
		$this->Apellido_Nombre_Solicitante->SetVisibility();
		$this->Dni->SetVisibility();
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
		global $EW_EXPORT, $pedido_paquetes;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pedido_paquetes);
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

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

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
		if (count($arrKeyFlds) >= 1) {
			$this->Cue->setFormValue($arrKeyFlds[0]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpedido_paqueteslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Cue->AdvancedSearch->ToJSON(), ","); // Field Cue
		$sFilterList = ew_Concat($sFilterList, $this->Sigla->AdvancedSearch->ToJSON(), ","); // Field Sigla
		$sFilterList = ew_Concat($sFilterList, $this->Id_Zona->AdvancedSearch->ToJSON(), ","); // Field Id_Zona
		$sFilterList = ew_Concat($sFilterList, $this->Id_Hardware->AdvancedSearch->ToJSON(), ","); // Field Id_Hardware
		$sFilterList = ew_Concat($sFilterList, $this->SN->AdvancedSearch->ToJSON(), ","); // Field SN
		$sFilterList = ew_Concat($sFilterList, $this->Marca_Arranque->AdvancedSearch->ToJSON(), ","); // Field Marca_Arranque
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Extraccion->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Extraccion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Paquete->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Paquete
		$sFilterList = ew_Concat($sFilterList, $this->Id_Motivo->AdvancedSearch->ToJSON(), ","); // Field Id_Motivo
		$sFilterList = ew_Concat($sFilterList, $this->Serie_Server->AdvancedSearch->ToJSON(), ","); // Field Serie_Server
		$sFilterList = ew_Concat($sFilterList, $this->Email_Solicitante->AdvancedSearch->ToJSON(), ","); // Field Email_Solicitante
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Paquete->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Paquete
		$sFilterList = ew_Concat($sFilterList, $this->Serie_Netbook->AdvancedSearch->ToJSON(), ","); // Field Serie_Netbook
		$sFilterList = ew_Concat($sFilterList, $this->Apellido_Nombre_Solicitante->AdvancedSearch->ToJSON(), ","); // Field Apellido_Nombre_Solicitante
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpedido_paqueteslistsrch", $filters);
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

		// Field Cue
		$this->Cue->AdvancedSearch->SearchValue = @$filter["x_Cue"];
		$this->Cue->AdvancedSearch->SearchOperator = @$filter["z_Cue"];
		$this->Cue->AdvancedSearch->SearchCondition = @$filter["v_Cue"];
		$this->Cue->AdvancedSearch->SearchValue2 = @$filter["y_Cue"];
		$this->Cue->AdvancedSearch->SearchOperator2 = @$filter["w_Cue"];
		$this->Cue->AdvancedSearch->Save();

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

		// Field Id_Motivo
		$this->Id_Motivo->AdvancedSearch->SearchValue = @$filter["x_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchOperator = @$filter["z_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchCondition = @$filter["v_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Motivo"];
		$this->Id_Motivo->AdvancedSearch->Save();

		// Field Serie_Server
		$this->Serie_Server->AdvancedSearch->SearchValue = @$filter["x_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchOperator = @$filter["z_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchCondition = @$filter["v_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchValue2 = @$filter["y_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->SearchOperator2 = @$filter["w_Serie_Server"];
		$this->Serie_Server->AdvancedSearch->Save();

		// Field Email_Solicitante
		$this->Email_Solicitante->AdvancedSearch->SearchValue = @$filter["x_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchOperator = @$filter["z_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchCondition = @$filter["v_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchValue2 = @$filter["y_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_Email_Solicitante"];
		$this->Email_Solicitante->AdvancedSearch->Save();

		// Field Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Paquete"];
		$this->Id_Tipo_Paquete->AdvancedSearch->Save();

		// Field Serie_Netbook
		$this->Serie_Netbook->AdvancedSearch->SearchValue = @$filter["x_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchOperator = @$filter["z_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchCondition = @$filter["v_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchValue2 = @$filter["y_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->SearchOperator2 = @$filter["w_Serie_Netbook"];
		$this->Serie_Netbook->AdvancedSearch->Save();

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

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Cue, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sigla, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Hardware, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Marca_Arranque, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Serie_Server, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Email_Solicitante, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Serie_Netbook, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Apellido_Nombre_Solicitante, $arKeywords, $type);
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
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Cue); // Cue
			$this->UpdateSort($this->Sigla); // Sigla
			$this->UpdateSort($this->Id_Zona); // Id_Zona
			$this->UpdateSort($this->Id_Hardware); // Id_Hardware
			$this->UpdateSort($this->SN); // SN
			$this->UpdateSort($this->Marca_Arranque); // Marca_Arranque
			$this->UpdateSort($this->Id_Tipo_Extraccion); // Id_Tipo_Extraccion
			$this->UpdateSort($this->Id_Estado_Paquete); // Id_Estado_Paquete
			$this->UpdateSort($this->Id_Motivo); // Id_Motivo
			$this->UpdateSort($this->Serie_Server); // Serie_Server
			$this->UpdateSort($this->Email_Solicitante); // Email_Solicitante
			$this->UpdateSort($this->Id_Tipo_Paquete); // Id_Tipo_Paquete
			$this->UpdateSort($this->Serie_Netbook); // Serie_Netbook
			$this->UpdateSort($this->Apellido_Nombre_Solicitante); // Apellido_Nombre_Solicitante
			$this->UpdateSort($this->Dni); // Dni
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
				$this->Cue->setSort("");
				$this->Sigla->setSort("");
				$this->Id_Zona->setSort("");
				$this->Id_Hardware->setSort("");
				$this->SN->setSort("");
				$this->Marca_Arranque->setSort("");
				$this->Id_Tipo_Extraccion->setSort("");
				$this->Id_Estado_Paquete->setSort("");
				$this->Id_Motivo->setSort("");
				$this->Serie_Server->setSort("");
				$this->Email_Solicitante->setSort("");
				$this->Id_Tipo_Paquete->setSort("");
				$this->Serie_Netbook->setSort("");
				$this->Apellido_Nombre_Solicitante->setSort("");
				$this->Dni->setSort("");
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

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Cue->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpedido_paqueteslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpedido_paqueteslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpedido_paqueteslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpedido_paqueteslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Id_Tipo_Extraccion->setDbValue($rs->fields('Id_Tipo_Extraccion'));
		$this->Id_Estado_Paquete->setDbValue($rs->fields('Id_Estado_Paquete'));
		$this->Id_Motivo->setDbValue($rs->fields('Id_Motivo'));
		$this->Serie_Server->setDbValue($rs->fields('Serie_Server'));
		$this->Email_Solicitante->setDbValue($rs->fields('Email_Solicitante'));
		$this->Id_Tipo_Paquete->setDbValue($rs->fields('Id_Tipo_Paquete'));
		$this->Serie_Netbook->setDbValue($rs->fields('Serie_Netbook'));
		$this->Apellido_Nombre_Solicitante->setDbValue($rs->fields('Apellido_Nombre_Solicitante'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Sigla->DbValue = $row['Sigla'];
		$this->Id_Zona->DbValue = $row['Id_Zona'];
		$this->Id_Hardware->DbValue = $row['Id_Hardware'];
		$this->SN->DbValue = $row['SN'];
		$this->Marca_Arranque->DbValue = $row['Marca_Arranque'];
		$this->Id_Tipo_Extraccion->DbValue = $row['Id_Tipo_Extraccion'];
		$this->Id_Estado_Paquete->DbValue = $row['Id_Estado_Paquete'];
		$this->Id_Motivo->DbValue = $row['Id_Motivo'];
		$this->Serie_Server->DbValue = $row['Serie_Server'];
		$this->Email_Solicitante->DbValue = $row['Email_Solicitante'];
		$this->Id_Tipo_Paquete->DbValue = $row['Id_Tipo_Paquete'];
		$this->Serie_Netbook->DbValue = $row['Serie_Netbook'];
		$this->Apellido_Nombre_Solicitante->DbValue = $row['Apellido_Nombre_Solicitante'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Cue")) <> "")
			$this->Cue->CurrentValue = $this->getKey("Cue"); // Cue
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
		// Cue
		// Sigla
		// Id_Zona
		// Id_Hardware
		// SN
		// Marca_Arranque
		// Id_Tipo_Extraccion
		// Id_Estado_Paquete
		// Id_Motivo
		// Serie_Server
		// Email_Solicitante
		// Id_Tipo_Paquete
		// Serie_Netbook
		// Apellido_Nombre_Solicitante
		// Dni
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

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

		// Serie_Server
		$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
		if (strval($this->Serie_Server->CurrentValue) <> "") {
			$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
		$sWhereWrk = "";
		$this->Serie_Server->LookupFilters = array();
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

		// Email_Solicitante
		$this->Email_Solicitante->ViewValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->ViewCustomAttributes = "";

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

		// Serie_Netbook
		$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
		if (strval($this->Serie_Netbook->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Netbook->LookupFilters = array();
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

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		$this->Apellido_Nombre_Solicitante->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

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

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";
			$this->Id_Tipo_Extraccion->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";
			$this->Id_Motivo->TooltipValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";
			$this->Serie_Server->TooltipValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";
			$this->Email_Solicitante->TooltipValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";
			$this->Id_Tipo_Paquete->TooltipValue = "";

			// Serie_Netbook
			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";
			$this->Serie_Netbook->TooltipValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";
			$this->Apellido_Nombre_Solicitante->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$item->Body = "<button id=\"emf_pedido_paquetes\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pedido_paquetes',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpedido_paqueteslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($pedido_paquetes_list)) $pedido_paquetes_list = new cpedido_paquetes_list();

// Page init
$pedido_paquetes_list->Page_Init();

// Page main
$pedido_paquetes_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pedido_paquetes_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpedido_paqueteslist = new ew_Form("fpedido_paqueteslist", "list");
fpedido_paqueteslist.FormKeyCountName = '<?php echo $pedido_paquetes_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpedido_paqueteslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpedido_paqueteslist.ValidateRequired = true;
<?php } else { ?>
fpedido_paqueteslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpedido_paqueteslist.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};
fpedido_paqueteslist.Lists["x_Id_Hardware"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpedido_paqueteslist.Lists["x_Id_Tipo_Extraccion"] = {"LinkField":"x_Id_Tipo_Extraccion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpedido_paqueteslist.Lists["x_Id_Estado_Paquete"] = {"LinkField":"x_Id_Estado_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_paquete"};
fpedido_paqueteslist.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpedido_paqueteslist.Lists["x_Serie_Server"] = {"LinkField":"x_Nro_Serie","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nro_Serie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"servidor_escolar"};
fpedido_paqueteslist.Lists["x_Id_Tipo_Paquete"] = {"LinkField":"x_Id_Tipo_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_paquete"};
fpedido_paqueteslist.Lists["x_Serie_Netbook"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
var CurrentSearchForm = fpedido_paqueteslistsrch = new ew_Form("fpedido_paqueteslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pedido_paquetes->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($pedido_paquetes_list->TotalRecs > 0 && $pedido_paquetes_list->ExportOptions->Visible()) { ?>
<?php $pedido_paquetes_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_paquetes_list->SearchOptions->Visible()) { ?>
<?php $pedido_paquetes_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_paquetes_list->FilterOptions->Visible()) { ?>
<?php $pedido_paquetes_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $pedido_paquetes_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pedido_paquetes_list->TotalRecs <= 0)
			$pedido_paquetes_list->TotalRecs = $pedido_paquetes->SelectRecordCount();
	} else {
		if (!$pedido_paquetes_list->Recordset && ($pedido_paquetes_list->Recordset = $pedido_paquetes_list->LoadRecordset()))
			$pedido_paquetes_list->TotalRecs = $pedido_paquetes_list->Recordset->RecordCount();
	}
	$pedido_paquetes_list->StartRec = 1;
	if ($pedido_paquetes_list->DisplayRecs <= 0 || ($pedido_paquetes->Export <> "" && $pedido_paquetes->ExportAll)) // Display all records
		$pedido_paquetes_list->DisplayRecs = $pedido_paquetes_list->TotalRecs;
	if (!($pedido_paquetes->Export <> "" && $pedido_paquetes->ExportAll))
		$pedido_paquetes_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pedido_paquetes_list->Recordset = $pedido_paquetes_list->LoadRecordset($pedido_paquetes_list->StartRec-1, $pedido_paquetes_list->DisplayRecs);

	// Set no record found message
	if ($pedido_paquetes->CurrentAction == "" && $pedido_paquetes_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pedido_paquetes_list->setWarningMessage(ew_DeniedMsg());
		if ($pedido_paquetes_list->SearchWhere == "0=101")
			$pedido_paquetes_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pedido_paquetes_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pedido_paquetes_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($pedido_paquetes->Export == "" && $pedido_paquetes->CurrentAction == "") { ?>
<form name="fpedido_paqueteslistsrch" id="fpedido_paqueteslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pedido_paquetes_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpedido_paqueteslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pedido_paquetes">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pedido_paquetes_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pedido_paquetes_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pedido_paquetes_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pedido_paquetes_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pedido_paquetes_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pedido_paquetes_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pedido_paquetes_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $pedido_paquetes_list->ShowPageHeader(); ?>
<?php
$pedido_paquetes_list->ShowMessage();
?>
<?php if ($pedido_paquetes_list->TotalRecs > 0 || $pedido_paquetes->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid pedido_paquetes">
<?php if ($pedido_paquetes->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($pedido_paquetes->CurrentAction <> "gridadd" && $pedido_paquetes->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pedido_paquetes_list->Pager)) $pedido_paquetes_list->Pager = new cPrevNextPager($pedido_paquetes_list->StartRec, $pedido_paquetes_list->DisplayRecs, $pedido_paquetes_list->TotalRecs) ?>
<?php if ($pedido_paquetes_list->Pager->RecordCount > 0 && $pedido_paquetes_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pedido_paquetes_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pedido_paquetes_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pedido_paquetes_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pedido_paquetes_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pedido_paquetes_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_paquetes_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpedido_paqueteslist" id="fpedido_paqueteslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pedido_paquetes_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pedido_paquetes_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pedido_paquetes">
<div id="gmp_pedido_paquetes" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($pedido_paquetes_list->TotalRecs > 0) { ?>
<table id="tbl_pedido_paqueteslist" class="table ewTable">
<?php echo $pedido_paquetes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$pedido_paquetes_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pedido_paquetes_list->RenderListOptions();

// Render list options (header, left)
$pedido_paquetes_list->ListOptions->Render("header", "left");
?>
<?php if ($pedido_paquetes->Cue->Visible) { // Cue ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Cue) == "") { ?>
		<th data-name="Cue"><div id="elh_pedido_paquetes_Cue" class="pedido_paquetes_Cue"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Cue->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Cue) ?>',1);"><div id="elh_pedido_paquetes_Cue" class="pedido_paquetes_Cue">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Cue->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Cue->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Cue->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Sigla->Visible) { // Sigla ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Sigla) == "") { ?>
		<th data-name="Sigla"><div id="elh_pedido_paquetes_Sigla" class="pedido_paquetes_Sigla"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Sigla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sigla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Sigla) ?>',1);"><div id="elh_pedido_paquetes_Sigla" class="pedido_paquetes_Sigla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Sigla->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Sigla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Sigla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Zona->Visible) { // Id_Zona ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Zona) == "") { ?>
		<th data-name="Id_Zona"><div id="elh_pedido_paquetes_Id_Zona" class="pedido_paquetes_Id_Zona"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Zona"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Zona) ?>',1);"><div id="elh_pedido_paquetes_Id_Zona" class="pedido_paquetes_Id_Zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Zona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Hardware->Visible) { // Id_Hardware ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Hardware) == "") { ?>
		<th data-name="Id_Hardware"><div id="elh_pedido_paquetes_Id_Hardware" class="pedido_paquetes_Id_Hardware"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Hardware->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Hardware"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Hardware) ?>',1);"><div id="elh_pedido_paquetes_Id_Hardware" class="pedido_paquetes_Id_Hardware">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Hardware->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Hardware->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Hardware->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->SN->Visible) { // SN ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->SN) == "") { ?>
		<th data-name="SN"><div id="elh_pedido_paquetes_SN" class="pedido_paquetes_SN"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->SN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SN"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->SN) ?>',1);"><div id="elh_pedido_paquetes_SN" class="pedido_paquetes_SN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->SN->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->SN->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->SN->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Marca_Arranque) == "") { ?>
		<th data-name="Marca_Arranque"><div id="elh_pedido_paquetes_Marca_Arranque" class="pedido_paquetes_Marca_Arranque"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Marca_Arranque->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Marca_Arranque"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Marca_Arranque) ?>',1);"><div id="elh_pedido_paquetes_Marca_Arranque" class="pedido_paquetes_Marca_Arranque">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Marca_Arranque->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Marca_Arranque->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Marca_Arranque->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Tipo_Extraccion) == "") { ?>
		<th data-name="Id_Tipo_Extraccion"><div id="elh_pedido_paquetes_Id_Tipo_Extraccion" class="pedido_paquetes_Id_Tipo_Extraccion"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Tipo_Extraccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Extraccion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Tipo_Extraccion) ?>',1);"><div id="elh_pedido_paquetes_Id_Tipo_Extraccion" class="pedido_paquetes_Id_Tipo_Extraccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Tipo_Extraccion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Tipo_Extraccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Tipo_Extraccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Estado_Paquete) == "") { ?>
		<th data-name="Id_Estado_Paquete"><div id="elh_pedido_paquetes_Id_Estado_Paquete" class="pedido_paquetes_Id_Estado_Paquete"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Estado_Paquete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Paquete"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Estado_Paquete) ?>',1);"><div id="elh_pedido_paquetes_Id_Estado_Paquete" class="pedido_paquetes_Id_Estado_Paquete">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Estado_Paquete->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Estado_Paquete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Estado_Paquete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Motivo->Visible) { // Id_Motivo ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Motivo) == "") { ?>
		<th data-name="Id_Motivo"><div id="elh_pedido_paquetes_Id_Motivo" class="pedido_paquetes_Id_Motivo"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Motivo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Motivo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Motivo) ?>',1);"><div id="elh_pedido_paquetes_Id_Motivo" class="pedido_paquetes_Id_Motivo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Motivo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Motivo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Motivo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Serie_Server->Visible) { // Serie_Server ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Serie_Server) == "") { ?>
		<th data-name="Serie_Server"><div id="elh_pedido_paquetes_Serie_Server" class="pedido_paquetes_Serie_Server"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Serie_Server->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Serie_Server"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Serie_Server) ?>',1);"><div id="elh_pedido_paquetes_Serie_Server" class="pedido_paquetes_Serie_Server">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Serie_Server->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Serie_Server->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Serie_Server->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Email_Solicitante->Visible) { // Email_Solicitante ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Email_Solicitante) == "") { ?>
		<th data-name="Email_Solicitante"><div id="elh_pedido_paquetes_Email_Solicitante" class="pedido_paquetes_Email_Solicitante"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Email_Solicitante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Email_Solicitante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Email_Solicitante) ?>',1);"><div id="elh_pedido_paquetes_Email_Solicitante" class="pedido_paquetes_Email_Solicitante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Email_Solicitante->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Email_Solicitante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Email_Solicitante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Id_Tipo_Paquete) == "") { ?>
		<th data-name="Id_Tipo_Paquete"><div id="elh_pedido_paquetes_Id_Tipo_Paquete" class="pedido_paquetes_Id_Tipo_Paquete"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Tipo_Paquete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Paquete"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Id_Tipo_Paquete) ?>',1);"><div id="elh_pedido_paquetes_Id_Tipo_Paquete" class="pedido_paquetes_Id_Tipo_Paquete">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Id_Tipo_Paquete->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Id_Tipo_Paquete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Id_Tipo_Paquete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Serie_Netbook->Visible) { // Serie_Netbook ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Serie_Netbook) == "") { ?>
		<th data-name="Serie_Netbook"><div id="elh_pedido_paquetes_Serie_Netbook" class="pedido_paquetes_Serie_Netbook"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Serie_Netbook->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Serie_Netbook"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Serie_Netbook) ?>',1);"><div id="elh_pedido_paquetes_Serie_Netbook" class="pedido_paquetes_Serie_Netbook">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Serie_Netbook->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Serie_Netbook->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Serie_Netbook->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Apellido_Nombre_Solicitante) == "") { ?>
		<th data-name="Apellido_Nombre_Solicitante"><div id="elh_pedido_paquetes_Apellido_Nombre_Solicitante" class="pedido_paquetes_Apellido_Nombre_Solicitante"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Apellido_Nombre_Solicitante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_Nombre_Solicitante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Apellido_Nombre_Solicitante) ?>',1);"><div id="elh_pedido_paquetes_Apellido_Nombre_Solicitante" class="pedido_paquetes_Apellido_Nombre_Solicitante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Apellido_Nombre_Solicitante->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Apellido_Nombre_Solicitante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Apellido_Nombre_Solicitante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Dni->Visible) { // Dni ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_pedido_paquetes_Dni" class="pedido_paquetes_Dni"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Dni) ?>',1);"><div id="elh_pedido_paquetes_Dni" class="pedido_paquetes_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Dni->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_pedido_paquetes_Fecha_Actualizacion" class="pedido_paquetes_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Fecha_Actualizacion) ?>',1);"><div id="elh_pedido_paquetes_Fecha_Actualizacion" class="pedido_paquetes_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pedido_paquetes->Usuario->Visible) { // Usuario ?>
	<?php if ($pedido_paquetes->SortUrl($pedido_paquetes->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_pedido_paquetes_Usuario" class="pedido_paquetes_Usuario"><div class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pedido_paquetes->SortUrl($pedido_paquetes->Usuario) ?>',1);"><div id="elh_pedido_paquetes_Usuario" class="pedido_paquetes_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pedido_paquetes->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pedido_paquetes->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pedido_paquetes->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pedido_paquetes_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pedido_paquetes->ExportAll && $pedido_paquetes->Export <> "") {
	$pedido_paquetes_list->StopRec = $pedido_paquetes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pedido_paquetes_list->TotalRecs > $pedido_paquetes_list->StartRec + $pedido_paquetes_list->DisplayRecs - 1)
		$pedido_paquetes_list->StopRec = $pedido_paquetes_list->StartRec + $pedido_paquetes_list->DisplayRecs - 1;
	else
		$pedido_paquetes_list->StopRec = $pedido_paquetes_list->TotalRecs;
}
$pedido_paquetes_list->RecCnt = $pedido_paquetes_list->StartRec - 1;
if ($pedido_paquetes_list->Recordset && !$pedido_paquetes_list->Recordset->EOF) {
	$pedido_paquetes_list->Recordset->MoveFirst();
	$bSelectLimit = $pedido_paquetes_list->UseSelectLimit;
	if (!$bSelectLimit && $pedido_paquetes_list->StartRec > 1)
		$pedido_paquetes_list->Recordset->Move($pedido_paquetes_list->StartRec - 1);
} elseif (!$pedido_paquetes->AllowAddDeleteRow && $pedido_paquetes_list->StopRec == 0) {
	$pedido_paquetes_list->StopRec = $pedido_paquetes->GridAddRowCount;
}

// Initialize aggregate
$pedido_paquetes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pedido_paquetes->ResetAttrs();
$pedido_paquetes_list->RenderRow();
while ($pedido_paquetes_list->RecCnt < $pedido_paquetes_list->StopRec) {
	$pedido_paquetes_list->RecCnt++;
	if (intval($pedido_paquetes_list->RecCnt) >= intval($pedido_paquetes_list->StartRec)) {
		$pedido_paquetes_list->RowCnt++;

		// Set up key count
		$pedido_paquetes_list->KeyCount = $pedido_paquetes_list->RowIndex;

		// Init row class and style
		$pedido_paquetes->ResetAttrs();
		$pedido_paquetes->CssClass = "";
		if ($pedido_paquetes->CurrentAction == "gridadd") {
		} else {
			$pedido_paquetes_list->LoadRowValues($pedido_paquetes_list->Recordset); // Load row values
		}
		$pedido_paquetes->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pedido_paquetes->RowAttrs = array_merge($pedido_paquetes->RowAttrs, array('data-rowindex'=>$pedido_paquetes_list->RowCnt, 'id'=>'r' . $pedido_paquetes_list->RowCnt . '_pedido_paquetes', 'data-rowtype'=>$pedido_paquetes->RowType));

		// Render row
		$pedido_paquetes_list->RenderRow();

		// Render list options
		$pedido_paquetes_list->RenderListOptions();
?>
	<tr<?php echo $pedido_paquetes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pedido_paquetes_list->ListOptions->Render("body", "left", $pedido_paquetes_list->RowCnt);
?>
	<?php if ($pedido_paquetes->Cue->Visible) { // Cue ?>
		<td data-name="Cue"<?php echo $pedido_paquetes->Cue->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Cue" class="pedido_paquetes_Cue">
<span<?php echo $pedido_paquetes->Cue->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Cue->ListViewValue() ?></span>
</span>
<a id="<?php echo $pedido_paquetes_list->PageObjName . "_row_" . $pedido_paquetes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pedido_paquetes->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla"<?php echo $pedido_paquetes->Sigla->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Sigla" class="pedido_paquetes_Sigla">
<span<?php echo $pedido_paquetes->Sigla->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Sigla->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona"<?php echo $pedido_paquetes->Id_Zona->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Zona" class="pedido_paquetes_Id_Zona">
<span<?php echo $pedido_paquetes->Id_Zona->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Hardware->Visible) { // Id_Hardware ?>
		<td data-name="Id_Hardware"<?php echo $pedido_paquetes->Id_Hardware->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Hardware" class="pedido_paquetes_Id_Hardware">
<span<?php echo $pedido_paquetes->Id_Hardware->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Hardware->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->SN->Visible) { // SN ?>
		<td data-name="SN"<?php echo $pedido_paquetes->SN->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_SN" class="pedido_paquetes_SN">
<span<?php echo $pedido_paquetes->SN->ViewAttributes() ?>>
<?php echo $pedido_paquetes->SN->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td data-name="Marca_Arranque"<?php echo $pedido_paquetes->Marca_Arranque->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Marca_Arranque" class="pedido_paquetes_Marca_Arranque">
<span<?php echo $pedido_paquetes->Marca_Arranque->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Marca_Arranque->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td data-name="Id_Tipo_Extraccion"<?php echo $pedido_paquetes->Id_Tipo_Extraccion->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Tipo_Extraccion" class="pedido_paquetes_Id_Tipo_Extraccion">
<span<?php echo $pedido_paquetes->Id_Tipo_Extraccion->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Tipo_Extraccion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td data-name="Id_Estado_Paquete"<?php echo $pedido_paquetes->Id_Estado_Paquete->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Estado_Paquete" class="pedido_paquetes_Id_Estado_Paquete">
<span<?php echo $pedido_paquetes->Id_Estado_Paquete->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Estado_Paquete->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Motivo->Visible) { // Id_Motivo ?>
		<td data-name="Id_Motivo"<?php echo $pedido_paquetes->Id_Motivo->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Motivo" class="pedido_paquetes_Id_Motivo">
<span<?php echo $pedido_paquetes->Id_Motivo->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Motivo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Serie_Server->Visible) { // Serie_Server ?>
		<td data-name="Serie_Server"<?php echo $pedido_paquetes->Serie_Server->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Serie_Server" class="pedido_paquetes_Serie_Server">
<span<?php echo $pedido_paquetes->Serie_Server->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Serie_Server->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<td data-name="Email_Solicitante"<?php echo $pedido_paquetes->Email_Solicitante->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Email_Solicitante" class="pedido_paquetes_Email_Solicitante">
<span<?php echo $pedido_paquetes->Email_Solicitante->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Email_Solicitante->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<td data-name="Id_Tipo_Paquete"<?php echo $pedido_paquetes->Id_Tipo_Paquete->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Id_Tipo_Paquete" class="pedido_paquetes_Id_Tipo_Paquete">
<span<?php echo $pedido_paquetes->Id_Tipo_Paquete->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Tipo_Paquete->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<td data-name="Serie_Netbook"<?php echo $pedido_paquetes->Serie_Netbook->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Serie_Netbook" class="pedido_paquetes_Serie_Netbook">
<span<?php echo $pedido_paquetes->Serie_Netbook->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Serie_Netbook->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<td data-name="Apellido_Nombre_Solicitante"<?php echo $pedido_paquetes->Apellido_Nombre_Solicitante->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Apellido_Nombre_Solicitante" class="pedido_paquetes_Apellido_Nombre_Solicitante">
<span<?php echo $pedido_paquetes->Apellido_Nombre_Solicitante->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Apellido_Nombre_Solicitante->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $pedido_paquetes->Dni->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Dni" class="pedido_paquetes_Dni">
<span<?php echo $pedido_paquetes->Dni->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Dni->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $pedido_paquetes->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Fecha_Actualizacion" class="pedido_paquetes_Fecha_Actualizacion">
<span<?php echo $pedido_paquetes->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pedido_paquetes->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $pedido_paquetes->Usuario->CellAttributes() ?>>
<span id="el<?php echo $pedido_paquetes_list->RowCnt ?>_pedido_paquetes_Usuario" class="pedido_paquetes_Usuario">
<span<?php echo $pedido_paquetes->Usuario->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Usuario->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pedido_paquetes_list->ListOptions->Render("body", "right", $pedido_paquetes_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pedido_paquetes->CurrentAction <> "gridadd")
		$pedido_paquetes_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pedido_paquetes->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pedido_paquetes_list->Recordset)
	$pedido_paquetes_list->Recordset->Close();
?>
<?php if ($pedido_paquetes->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($pedido_paquetes->CurrentAction <> "gridadd" && $pedido_paquetes->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pedido_paquetes_list->Pager)) $pedido_paquetes_list->Pager = new cPrevNextPager($pedido_paquetes_list->StartRec, $pedido_paquetes_list->DisplayRecs, $pedido_paquetes_list->TotalRecs) ?>
<?php if ($pedido_paquetes_list->Pager->RecordCount > 0 && $pedido_paquetes_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pedido_paquetes_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pedido_paquetes_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pedido_paquetes_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pedido_paquetes_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pedido_paquetes_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pedido_paquetes_list->PageUrl() ?>start=<?php echo $pedido_paquetes_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pedido_paquetes_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_paquetes_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pedido_paquetes_list->TotalRecs == 0 && $pedido_paquetes->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pedido_paquetes_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<script type="text/javascript">
fpedido_paqueteslistsrch.FilterList = <?php echo $pedido_paquetes_list->GetFilterList() ?>;
fpedido_paqueteslistsrch.Init();
fpedido_paqueteslist.Init();
</script>
<?php } ?>
<?php
$pedido_paquetes_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pedido_paquetes->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pedido_paquetes_list->Page_Terminate();
?>
