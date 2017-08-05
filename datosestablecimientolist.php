<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "datosestablecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$datosestablecimiento_list = NULL; // Initialize page object first

class cdatosestablecimiento_list extends cdatosestablecimiento {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'datosestablecimiento';

	// Page object name
	var $PageObjName = 'datosestablecimiento_list';

	// Grid form hidden field names
	var $FormName = 'fdatosestablecimientolist';
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

		// Table object (datosestablecimiento)
		if (!isset($GLOBALS["datosestablecimiento"]) || get_class($GLOBALS["datosestablecimiento"]) == "cdatosestablecimiento") {
			$GLOBALS["datosestablecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["datosestablecimiento"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "datosestablecimientoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "datosestablecimientodelete.php";
		$this->MultiUpdateUrl = "datosestablecimientoupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'datosestablecimiento', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdatosestablecimientolistsrch";

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
		$this->CUE->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Establecimiento->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Nro_Matricula->SetVisibility();
		$this->Cantidad_Aulas->SetVisibility();
		$this->Comparte_Edificio->SetVisibility();
		$this->Cantidad_Turnos->SetVisibility();
		$this->Id_Tipo_Esc->SetVisibility();
		$this->Universo->SetVisibility();
		$this->Tiene_Programa->SetVisibility();
		$this->Sector->SetVisibility();
		$this->Cantidad_Netbook_Conig->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Tipo_Zona->SetVisibility();
		$this->Id_Estado_Esc->SetVisibility();
		$this->Id_Zona->SetVisibility();
		$this->Cantidad_Netbook_Actuales->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

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
		global $EW_EXPORT, $datosestablecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($datosestablecimiento);
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
			$this->CUE->setFormValue($arrKeyFlds[0]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdatosestablecimientolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->CUE->AdvancedSearch->ToJSON(), ","); // Field CUE
		$sFilterList = ew_Concat($sFilterList, $this->Sigla->AdvancedSearch->ToJSON(), ","); // Field Sigla
		$sFilterList = ew_Concat($sFilterList, $this->Establecimiento->AdvancedSearch->ToJSON(), ","); // Field Establecimiento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Departamento->AdvancedSearch->ToJSON(), ","); // Field Id_Departamento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Localidad->AdvancedSearch->ToJSON(), ","); // Field Id_Localidad
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Telefono->AdvancedSearch->ToJSON(), ","); // Field Telefono
		$sFilterList = ew_Concat($sFilterList, $this->Mail->AdvancedSearch->ToJSON(), ","); // Field Mail
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Matricula->AdvancedSearch->ToJSON(), ","); // Field Nro Matricula
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Aulas->AdvancedSearch->ToJSON(), ","); // Field Cantidad Aulas
		$sFilterList = ew_Concat($sFilterList, $this->Comparte_Edificio->AdvancedSearch->ToJSON(), ","); // Field Comparte Edificio
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Turnos->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Turnos
		$sFilterList = ew_Concat($sFilterList, $this->Geolocalizacion->AdvancedSearch->ToJSON(), ","); // Field Geolocalizacion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Esc->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Esc
		$sFilterList = ew_Concat($sFilterList, $this->Universo->AdvancedSearch->ToJSON(), ","); // Field Universo
		$sFilterList = ew_Concat($sFilterList, $this->Tiene_Programa->AdvancedSearch->ToJSON(), ","); // Field Tiene_Programa
		$sFilterList = ew_Concat($sFilterList, $this->Sector->AdvancedSearch->ToJSON(), ","); // Field Sector
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Netbook_Conig->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Netbook_Conig
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Cuise->AdvancedSearch->ToJSON(), ","); // Field Nro_Cuise
		$sFilterList = ew_Concat($sFilterList, $this->Id_Nivel->AdvancedSearch->ToJSON(), ","); // Field Id_Nivel
		$sFilterList = ew_Concat($sFilterList, $this->Id_Jornada->AdvancedSearch->ToJSON(), ","); // Field Id_Jornada
		$sFilterList = ew_Concat($sFilterList, $this->Tipo_Zona->AdvancedSearch->ToJSON(), ","); // Field Tipo_Zona
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Esc->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Esc
		$sFilterList = ew_Concat($sFilterList, $this->Id_Zona->AdvancedSearch->ToJSON(), ","); // Field Id_Zona
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Netbook_Actuales->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Netbook_Actuales
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdatosestablecimientolistsrch", $filters);
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

		// Field CUE
		$this->CUE->AdvancedSearch->SearchValue = @$filter["x_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator = @$filter["z_CUE"];
		$this->CUE->AdvancedSearch->SearchCondition = @$filter["v_CUE"];
		$this->CUE->AdvancedSearch->SearchValue2 = @$filter["y_CUE"];
		$this->CUE->AdvancedSearch->SearchOperator2 = @$filter["w_CUE"];
		$this->CUE->AdvancedSearch->Save();

		// Field Sigla
		$this->Sigla->AdvancedSearch->SearchValue = @$filter["x_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator = @$filter["z_Sigla"];
		$this->Sigla->AdvancedSearch->SearchCondition = @$filter["v_Sigla"];
		$this->Sigla->AdvancedSearch->SearchValue2 = @$filter["y_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator2 = @$filter["w_Sigla"];
		$this->Sigla->AdvancedSearch->Save();

		// Field Establecimiento
		$this->Establecimiento->AdvancedSearch->SearchValue = @$filter["x_Establecimiento"];
		$this->Establecimiento->AdvancedSearch->SearchOperator = @$filter["z_Establecimiento"];
		$this->Establecimiento->AdvancedSearch->SearchCondition = @$filter["v_Establecimiento"];
		$this->Establecimiento->AdvancedSearch->SearchValue2 = @$filter["y_Establecimiento"];
		$this->Establecimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Establecimiento"];
		$this->Establecimiento->AdvancedSearch->Save();

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

		// Field Mail
		$this->Mail->AdvancedSearch->SearchValue = @$filter["x_Mail"];
		$this->Mail->AdvancedSearch->SearchOperator = @$filter["z_Mail"];
		$this->Mail->AdvancedSearch->SearchCondition = @$filter["v_Mail"];
		$this->Mail->AdvancedSearch->SearchValue2 = @$filter["y_Mail"];
		$this->Mail->AdvancedSearch->SearchOperator2 = @$filter["w_Mail"];
		$this->Mail->AdvancedSearch->Save();

		// Field Nro Matricula
		$this->Nro_Matricula->AdvancedSearch->SearchValue = @$filter["x_Nro_Matricula"];
		$this->Nro_Matricula->AdvancedSearch->SearchOperator = @$filter["z_Nro_Matricula"];
		$this->Nro_Matricula->AdvancedSearch->SearchCondition = @$filter["v_Nro_Matricula"];
		$this->Nro_Matricula->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Matricula"];
		$this->Nro_Matricula->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Matricula"];
		$this->Nro_Matricula->AdvancedSearch->Save();

		// Field Cantidad Aulas
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->Save();

		// Field Comparte Edificio
		$this->Comparte_Edificio->AdvancedSearch->SearchValue = @$filter["x_Comparte_Edificio"];
		$this->Comparte_Edificio->AdvancedSearch->SearchOperator = @$filter["z_Comparte_Edificio"];
		$this->Comparte_Edificio->AdvancedSearch->SearchCondition = @$filter["v_Comparte_Edificio"];
		$this->Comparte_Edificio->AdvancedSearch->SearchValue2 = @$filter["y_Comparte_Edificio"];
		$this->Comparte_Edificio->AdvancedSearch->SearchOperator2 = @$filter["w_Comparte_Edificio"];
		$this->Comparte_Edificio->AdvancedSearch->Save();

		// Field Cantidad_Turnos
		$this->Cantidad_Turnos->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Turnos"];
		$this->Cantidad_Turnos->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Turnos"];
		$this->Cantidad_Turnos->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Turnos"];
		$this->Cantidad_Turnos->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Turnos"];
		$this->Cantidad_Turnos->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Turnos"];
		$this->Cantidad_Turnos->AdvancedSearch->Save();

		// Field Geolocalizacion
		$this->Geolocalizacion->AdvancedSearch->SearchValue = @$filter["x_Geolocalizacion"];
		$this->Geolocalizacion->AdvancedSearch->SearchOperator = @$filter["z_Geolocalizacion"];
		$this->Geolocalizacion->AdvancedSearch->SearchCondition = @$filter["v_Geolocalizacion"];
		$this->Geolocalizacion->AdvancedSearch->SearchValue2 = @$filter["y_Geolocalizacion"];
		$this->Geolocalizacion->AdvancedSearch->SearchOperator2 = @$filter["w_Geolocalizacion"];
		$this->Geolocalizacion->AdvancedSearch->Save();

		// Field Id_Tipo_Esc
		$this->Id_Tipo_Esc->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Esc"];
		$this->Id_Tipo_Esc->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Esc"];
		$this->Id_Tipo_Esc->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Esc"];
		$this->Id_Tipo_Esc->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Esc"];
		$this->Id_Tipo_Esc->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Esc"];
		$this->Id_Tipo_Esc->AdvancedSearch->Save();

		// Field Universo
		$this->Universo->AdvancedSearch->SearchValue = @$filter["x_Universo"];
		$this->Universo->AdvancedSearch->SearchOperator = @$filter["z_Universo"];
		$this->Universo->AdvancedSearch->SearchCondition = @$filter["v_Universo"];
		$this->Universo->AdvancedSearch->SearchValue2 = @$filter["y_Universo"];
		$this->Universo->AdvancedSearch->SearchOperator2 = @$filter["w_Universo"];
		$this->Universo->AdvancedSearch->Save();

		// Field Tiene_Programa
		$this->Tiene_Programa->AdvancedSearch->SearchValue = @$filter["x_Tiene_Programa"];
		$this->Tiene_Programa->AdvancedSearch->SearchOperator = @$filter["z_Tiene_Programa"];
		$this->Tiene_Programa->AdvancedSearch->SearchCondition = @$filter["v_Tiene_Programa"];
		$this->Tiene_Programa->AdvancedSearch->SearchValue2 = @$filter["y_Tiene_Programa"];
		$this->Tiene_Programa->AdvancedSearch->SearchOperator2 = @$filter["w_Tiene_Programa"];
		$this->Tiene_Programa->AdvancedSearch->Save();

		// Field Sector
		$this->Sector->AdvancedSearch->SearchValue = @$filter["x_Sector"];
		$this->Sector->AdvancedSearch->SearchOperator = @$filter["z_Sector"];
		$this->Sector->AdvancedSearch->SearchCondition = @$filter["v_Sector"];
		$this->Sector->AdvancedSearch->SearchValue2 = @$filter["y_Sector"];
		$this->Sector->AdvancedSearch->SearchOperator2 = @$filter["w_Sector"];
		$this->Sector->AdvancedSearch->Save();

		// Field Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Netbook_Conig"];
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Netbook_Conig"];
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Netbook_Conig"];
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Netbook_Conig"];
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Netbook_Conig"];
		$this->Cantidad_Netbook_Conig->AdvancedSearch->Save();

		// Field Nro_Cuise
		$this->Nro_Cuise->AdvancedSearch->SearchValue = @$filter["x_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchOperator = @$filter["z_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchCondition = @$filter["v_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->Save();

		// Field Id_Nivel
		$this->Id_Nivel->AdvancedSearch->SearchValue = @$filter["x_Id_Nivel"];
		$this->Id_Nivel->AdvancedSearch->SearchOperator = @$filter["z_Id_Nivel"];
		$this->Id_Nivel->AdvancedSearch->SearchCondition = @$filter["v_Id_Nivel"];
		$this->Id_Nivel->AdvancedSearch->SearchValue2 = @$filter["y_Id_Nivel"];
		$this->Id_Nivel->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Nivel"];
		$this->Id_Nivel->AdvancedSearch->Save();

		// Field Id_Jornada
		$this->Id_Jornada->AdvancedSearch->SearchValue = @$filter["x_Id_Jornada"];
		$this->Id_Jornada->AdvancedSearch->SearchOperator = @$filter["z_Id_Jornada"];
		$this->Id_Jornada->AdvancedSearch->SearchCondition = @$filter["v_Id_Jornada"];
		$this->Id_Jornada->AdvancedSearch->SearchValue2 = @$filter["y_Id_Jornada"];
		$this->Id_Jornada->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Jornada"];
		$this->Id_Jornada->AdvancedSearch->Save();

		// Field Tipo_Zona
		$this->Tipo_Zona->AdvancedSearch->SearchValue = @$filter["x_Tipo_Zona"];
		$this->Tipo_Zona->AdvancedSearch->SearchOperator = @$filter["z_Tipo_Zona"];
		$this->Tipo_Zona->AdvancedSearch->SearchCondition = @$filter["v_Tipo_Zona"];
		$this->Tipo_Zona->AdvancedSearch->SearchValue2 = @$filter["y_Tipo_Zona"];
		$this->Tipo_Zona->AdvancedSearch->SearchOperator2 = @$filter["w_Tipo_Zona"];
		$this->Tipo_Zona->AdvancedSearch->Save();

		// Field Id_Estado_Esc
		$this->Id_Estado_Esc->AdvancedSearch->SearchValue = @$filter["x_Id_Estado_Esc"];
		$this->Id_Estado_Esc->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado_Esc"];
		$this->Id_Estado_Esc->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado_Esc"];
		$this->Id_Estado_Esc->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado_Esc"];
		$this->Id_Estado_Esc->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado_Esc"];
		$this->Id_Estado_Esc->AdvancedSearch->Save();

		// Field Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = @$filter["x_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchOperator = @$filter["z_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchCondition = @$filter["v_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchValue2 = @$filter["y_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Zona"];
		$this->Id_Zona->AdvancedSearch->Save();

		// Field Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->CUE, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sigla, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Establecimiento, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Departamento, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Localidad, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Comparte_Edificio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Geolocalizacion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Tipo_Esc, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Universo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Tiene_Programa, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sector, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Nivel, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Jornada, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Tipo_Zona, $arKeywords, $type);
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
			$this->UpdateSort($this->CUE); // CUE
			$this->UpdateSort($this->Sigla); // Sigla
			$this->UpdateSort($this->Establecimiento); // Establecimiento
			$this->UpdateSort($this->Id_Departamento); // Id_Departamento
			$this->UpdateSort($this->Id_Localidad); // Id_Localidad
			$this->UpdateSort($this->Domicilio); // Domicilio
			$this->UpdateSort($this->Telefono); // Telefono
			$this->UpdateSort($this->Mail); // Mail
			$this->UpdateSort($this->Nro_Matricula); // Nro Matricula
			$this->UpdateSort($this->Cantidad_Aulas); // Cantidad Aulas
			$this->UpdateSort($this->Comparte_Edificio); // Comparte Edificio
			$this->UpdateSort($this->Cantidad_Turnos); // Cantidad_Turnos
			$this->UpdateSort($this->Id_Tipo_Esc); // Id_Tipo_Esc
			$this->UpdateSort($this->Universo); // Universo
			$this->UpdateSort($this->Tiene_Programa); // Tiene_Programa
			$this->UpdateSort($this->Sector); // Sector
			$this->UpdateSort($this->Cantidad_Netbook_Conig); // Cantidad_Netbook_Conig
			$this->UpdateSort($this->Nro_Cuise); // Nro_Cuise
			$this->UpdateSort($this->Tipo_Zona); // Tipo_Zona
			$this->UpdateSort($this->Id_Estado_Esc); // Id_Estado_Esc
			$this->UpdateSort($this->Id_Zona); // Id_Zona
			$this->UpdateSort($this->Cantidad_Netbook_Actuales); // Cantidad_Netbook_Actuales
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
				$this->CUE->setSort("");
				$this->Sigla->setSort("");
				$this->Establecimiento->setSort("");
				$this->Id_Departamento->setSort("");
				$this->Id_Localidad->setSort("");
				$this->Domicilio->setSort("");
				$this->Telefono->setSort("");
				$this->Mail->setSort("");
				$this->Nro_Matricula->setSort("");
				$this->Cantidad_Aulas->setSort("");
				$this->Comparte_Edificio->setSort("");
				$this->Cantidad_Turnos->setSort("");
				$this->Id_Tipo_Esc->setSort("");
				$this->Universo->setSort("");
				$this->Tiene_Programa->setSort("");
				$this->Sector->setSort("");
				$this->Cantidad_Netbook_Conig->setSort("");
				$this->Nro_Cuise->setSort("");
				$this->Tipo_Zona->setSort("");
				$this->Id_Estado_Esc->setSort("");
				$this->Id_Zona->setSort("");
				$this->Cantidad_Netbook_Actuales->setSort("");
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

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"datosestablecimiento\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->CUE->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdatosestablecimientolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdatosestablecimientolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdatosestablecimientolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdatosestablecimientolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->CUE->setDbValue($rs->fields('CUE'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Establecimiento->setDbValue($rs->fields('Establecimiento'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Nro_Matricula->setDbValue($rs->fields('Nro Matricula'));
		$this->Cantidad_Aulas->setDbValue($rs->fields('Cantidad Aulas'));
		$this->Comparte_Edificio->setDbValue($rs->fields('Comparte Edificio'));
		$this->Cantidad_Turnos->setDbValue($rs->fields('Cantidad_Turnos'));
		$this->Geolocalizacion->setDbValue($rs->fields('Geolocalizacion'));
		$this->Id_Tipo_Esc->setDbValue($rs->fields('Id_Tipo_Esc'));
		$this->Universo->setDbValue($rs->fields('Universo'));
		$this->Tiene_Programa->setDbValue($rs->fields('Tiene_Programa'));
		$this->Sector->setDbValue($rs->fields('Sector'));
		$this->Cantidad_Netbook_Conig->setDbValue($rs->fields('Cantidad_Netbook_Conig'));
		$this->Nro_Cuise->setDbValue($rs->fields('Nro_Cuise'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Jornada->setDbValue($rs->fields('Id_Jornada'));
		$this->Tipo_Zona->setDbValue($rs->fields('Tipo_Zona'));
		$this->Id_Estado_Esc->setDbValue($rs->fields('Id_Estado_Esc'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Cantidad_Netbook_Actuales->setDbValue($rs->fields('Cantidad_Netbook_Actuales'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CUE->DbValue = $row['CUE'];
		$this->Sigla->DbValue = $row['Sigla'];
		$this->Establecimiento->DbValue = $row['Establecimiento'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Mail->DbValue = $row['Mail'];
		$this->Nro_Matricula->DbValue = $row['Nro Matricula'];
		$this->Cantidad_Aulas->DbValue = $row['Cantidad Aulas'];
		$this->Comparte_Edificio->DbValue = $row['Comparte Edificio'];
		$this->Cantidad_Turnos->DbValue = $row['Cantidad_Turnos'];
		$this->Geolocalizacion->DbValue = $row['Geolocalizacion'];
		$this->Id_Tipo_Esc->DbValue = $row['Id_Tipo_Esc'];
		$this->Universo->DbValue = $row['Universo'];
		$this->Tiene_Programa->DbValue = $row['Tiene_Programa'];
		$this->Sector->DbValue = $row['Sector'];
		$this->Cantidad_Netbook_Conig->DbValue = $row['Cantidad_Netbook_Conig'];
		$this->Nro_Cuise->DbValue = $row['Nro_Cuise'];
		$this->Id_Nivel->DbValue = $row['Id_Nivel'];
		$this->Id_Jornada->DbValue = $row['Id_Jornada'];
		$this->Tipo_Zona->DbValue = $row['Tipo_Zona'];
		$this->Id_Estado_Esc->DbValue = $row['Id_Estado_Esc'];
		$this->Id_Zona->DbValue = $row['Id_Zona'];
		$this->Cantidad_Netbook_Actuales->DbValue = $row['Cantidad_Netbook_Actuales'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CUE")) <> "")
			$this->CUE->CurrentValue = $this->getKey("CUE"); // CUE
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
		// CUE
		// Sigla
		// Establecimiento
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono
		// Mail
		// Nro Matricula
		// Cantidad Aulas
		// Comparte Edificio
		// Cantidad_Turnos
		// Geolocalizacion
		// Id_Tipo_Esc
		// Universo
		// Tiene_Programa
		// Sector
		// Cantidad_Netbook_Conig
		// Nro_Cuise
		// Id_Nivel
		// Id_Jornada
		// Tipo_Zona
		// Id_Estado_Esc
		// Id_Zona
		// Cantidad_Netbook_Actuales
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->ViewValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
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
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
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

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Nro Matricula
		$this->Nro_Matricula->ViewValue = $this->Nro_Matricula->CurrentValue;
		$this->Nro_Matricula->ViewCustomAttributes = "";

		// Cantidad Aulas
		$this->Cantidad_Aulas->ViewValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Aulas->ViewCustomAttributes = "";

		// Comparte Edificio
		if (strval($this->Comparte_Edificio->CurrentValue) <> "") {
			$this->Comparte_Edificio->ViewValue = $this->Comparte_Edificio->OptionCaption($this->Comparte_Edificio->CurrentValue);
		} else {
			$this->Comparte_Edificio->ViewValue = NULL;
		}
		$this->Comparte_Edificio->ViewCustomAttributes = "";

		// Cantidad_Turnos
		$this->Cantidad_Turnos->ViewValue = $this->Cantidad_Turnos->CurrentValue;
		$this->Cantidad_Turnos->ViewCustomAttributes = "";

		// Id_Tipo_Esc
		if (strval($this->Id_Tipo_Esc->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_escuela`";
		$sWhereWrk = "";
		$this->Id_Tipo_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tipo_Esc->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Tipo_Esc->ViewValue .= $this->Id_Tipo_Esc->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Tipo_Esc->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Esc->ViewValue = $this->Id_Tipo_Esc->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Esc->ViewValue = NULL;
		}
		$this->Id_Tipo_Esc->ViewCustomAttributes = "";

		// Universo
		$this->Universo->ViewValue = $this->Universo->CurrentValue;
		$this->Universo->ViewCustomAttributes = "";

		// Tiene_Programa
		$this->Tiene_Programa->ViewValue = $this->Tiene_Programa->CurrentValue;
		$this->Tiene_Programa->ViewCustomAttributes = "";

		// Sector
		$this->Sector->ViewValue = $this->Sector->CurrentValue;
		$this->Sector->ViewCustomAttributes = "";

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->ViewValue = $this->Cantidad_Netbook_Conig->CurrentValue;
		$this->Cantidad_Netbook_Conig->ViewCustomAttributes = "";

		// Nro_Cuise
		$this->Nro_Cuise->ViewValue = $this->Nro_Cuise->CurrentValue;
		$this->Nro_Cuise->ViewCustomAttributes = "";

		// Tipo_Zona
		$this->Tipo_Zona->ViewValue = $this->Tipo_Zona->CurrentValue;
		$this->Tipo_Zona->ViewCustomAttributes = "";

		// Id_Estado_Esc
		if (strval($this->Id_Estado_Esc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Estado_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Esc->ViewValue = NULL;
		}
		$this->Id_Estado_Esc->ViewCustomAttributes = "";

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

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->ViewValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Cantidad_Netbook_Actuales->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// CUE
			$this->CUE->LinkCustomAttributes = "";
			$this->CUE->HrefValue = "";
			$this->CUE->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Establecimiento
			$this->Establecimiento->LinkCustomAttributes = "";
			$this->Establecimiento->HrefValue = "";
			$this->Establecimiento->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";
			$this->Mail->TooltipValue = "";

			// Nro Matricula
			$this->Nro_Matricula->LinkCustomAttributes = "";
			$this->Nro_Matricula->HrefValue = "";
			$this->Nro_Matricula->TooltipValue = "";

			// Cantidad Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";
			$this->Cantidad_Aulas->TooltipValue = "";

			// Comparte Edificio
			$this->Comparte_Edificio->LinkCustomAttributes = "";
			$this->Comparte_Edificio->HrefValue = "";
			$this->Comparte_Edificio->TooltipValue = "";

			// Cantidad_Turnos
			$this->Cantidad_Turnos->LinkCustomAttributes = "";
			$this->Cantidad_Turnos->HrefValue = "";
			$this->Cantidad_Turnos->TooltipValue = "";

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->LinkCustomAttributes = "";
			$this->Id_Tipo_Esc->HrefValue = "";
			$this->Id_Tipo_Esc->TooltipValue = "";

			// Universo
			$this->Universo->LinkCustomAttributes = "";
			$this->Universo->HrefValue = "";
			$this->Universo->TooltipValue = "";

			// Tiene_Programa
			$this->Tiene_Programa->LinkCustomAttributes = "";
			$this->Tiene_Programa->HrefValue = "";
			$this->Tiene_Programa->TooltipValue = "";

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";
			$this->Sector->TooltipValue = "";

			// Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Conig->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Conig->HrefValue = "";
			$this->Cantidad_Netbook_Conig->TooltipValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";
			$this->Nro_Cuise->TooltipValue = "";

			// Tipo_Zona
			$this->Tipo_Zona->LinkCustomAttributes = "";
			$this->Tipo_Zona->HrefValue = "";
			$this->Tipo_Zona->TooltipValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";
			$this->Id_Estado_Esc->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";
			$this->Cantidad_Netbook_Actuales->TooltipValue = "";

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
		$item->Body = "<button id=\"emf_datosestablecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_datosestablecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdatosestablecimientolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($datosestablecimiento_list)) $datosestablecimiento_list = new cdatosestablecimiento_list();

// Page init
$datosestablecimiento_list->Page_Init();

// Page main
$datosestablecimiento_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datosestablecimiento_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdatosestablecimientolist = new ew_Form("fdatosestablecimientolist", "list");
fdatosestablecimientolist.FormKeyCountName = '<?php echo $datosestablecimiento_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdatosestablecimientolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdatosestablecimientolist.ValidateRequired = true;
<?php } else { ?>
fdatosestablecimientolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdatosestablecimientolist.Lists["x_Id_Departamento"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdatosestablecimientolist.Lists["x_Id_Localidad"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fdatosestablecimientolist.Lists["x_Comparte_Edificio"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatosestablecimientolist.Lists["x_Comparte_Edificio"].Options = <?php echo json_encode($datosestablecimiento->Comparte_Edificio->Options()) ?>;
fdatosestablecimientolist.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdatosestablecimientolist.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdatosestablecimientolist.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

// Form object for search
var CurrentSearchForm = fdatosestablecimientolistsrch = new ew_Form("fdatosestablecimientolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if ($datosestablecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($datosestablecimiento_list->TotalRecs > 0 && $datosestablecimiento_list->ExportOptions->Visible()) { ?>
<?php $datosestablecimiento_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($datosestablecimiento_list->SearchOptions->Visible()) { ?>
<?php $datosestablecimiento_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($datosestablecimiento_list->FilterOptions->Visible()) { ?>
<?php $datosestablecimiento_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $datosestablecimiento_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($datosestablecimiento_list->TotalRecs <= 0)
			$datosestablecimiento_list->TotalRecs = $datosestablecimiento->SelectRecordCount();
	} else {
		if (!$datosestablecimiento_list->Recordset && ($datosestablecimiento_list->Recordset = $datosestablecimiento_list->LoadRecordset()))
			$datosestablecimiento_list->TotalRecs = $datosestablecimiento_list->Recordset->RecordCount();
	}
	$datosestablecimiento_list->StartRec = 1;
	if ($datosestablecimiento_list->DisplayRecs <= 0 || ($datosestablecimiento->Export <> "" && $datosestablecimiento->ExportAll)) // Display all records
		$datosestablecimiento_list->DisplayRecs = $datosestablecimiento_list->TotalRecs;
	if (!($datosestablecimiento->Export <> "" && $datosestablecimiento->ExportAll))
		$datosestablecimiento_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$datosestablecimiento_list->Recordset = $datosestablecimiento_list->LoadRecordset($datosestablecimiento_list->StartRec-1, $datosestablecimiento_list->DisplayRecs);

	// Set no record found message
	if ($datosestablecimiento->CurrentAction == "" && $datosestablecimiento_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$datosestablecimiento_list->setWarningMessage(ew_DeniedMsg());
		if ($datosestablecimiento_list->SearchWhere == "0=101")
			$datosestablecimiento_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$datosestablecimiento_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$datosestablecimiento_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($datosestablecimiento->Export == "" && $datosestablecimiento->CurrentAction == "") { ?>
<form name="fdatosestablecimientolistsrch" id="fdatosestablecimientolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($datosestablecimiento_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdatosestablecimientolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="datosestablecimiento">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($datosestablecimiento_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($datosestablecimiento_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $datosestablecimiento_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($datosestablecimiento_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($datosestablecimiento_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($datosestablecimiento_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($datosestablecimiento_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $datosestablecimiento_list->ShowPageHeader(); ?>
<?php
$datosestablecimiento_list->ShowMessage();
?>
<?php if ($datosestablecimiento_list->TotalRecs > 0 || $datosestablecimiento->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid datosestablecimiento">
<?php if ($datosestablecimiento->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($datosestablecimiento->CurrentAction <> "gridadd" && $datosestablecimiento->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($datosestablecimiento_list->Pager)) $datosestablecimiento_list->Pager = new cPrevNextPager($datosestablecimiento_list->StartRec, $datosestablecimiento_list->DisplayRecs, $datosestablecimiento_list->TotalRecs) ?>
<?php if ($datosestablecimiento_list->Pager->RecordCount > 0 && $datosestablecimiento_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($datosestablecimiento_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($datosestablecimiento_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $datosestablecimiento_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($datosestablecimiento_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($datosestablecimiento_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datosestablecimiento_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdatosestablecimientolist" id="fdatosestablecimientolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datosestablecimiento_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datosestablecimiento_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datosestablecimiento">
<div id="gmp_datosestablecimiento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($datosestablecimiento_list->TotalRecs > 0) { ?>
<table id="tbl_datosestablecimientolist" class="table ewTable">
<?php echo $datosestablecimiento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$datosestablecimiento_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$datosestablecimiento_list->RenderListOptions();

// Render list options (header, left)
$datosestablecimiento_list->ListOptions->Render("header", "left");
?>
<?php if ($datosestablecimiento->CUE->Visible) { // CUE ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->CUE) == "") { ?>
		<th data-name="CUE"><div id="elh_datosestablecimiento_CUE" class="datosestablecimiento_CUE"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->CUE->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CUE"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->CUE) ?>',1);"><div id="elh_datosestablecimiento_CUE" class="datosestablecimiento_CUE">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->CUE->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->CUE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->CUE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Sigla->Visible) { // Sigla ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Sigla) == "") { ?>
		<th data-name="Sigla"><div id="elh_datosestablecimiento_Sigla" class="datosestablecimiento_Sigla"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Sigla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sigla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Sigla) ?>',1);"><div id="elh_datosestablecimiento_Sigla" class="datosestablecimiento_Sigla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Sigla->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Sigla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Sigla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Establecimiento->Visible) { // Establecimiento ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Establecimiento) == "") { ?>
		<th data-name="Establecimiento"><div id="elh_datosestablecimiento_Establecimiento" class="datosestablecimiento_Establecimiento"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Establecimiento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Establecimiento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Establecimiento) ?>',1);"><div id="elh_datosestablecimiento_Establecimiento" class="datosestablecimiento_Establecimiento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Establecimiento->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Establecimiento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Establecimiento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Id_Departamento) == "") { ?>
		<th data-name="Id_Departamento"><div id="elh_datosestablecimiento_Id_Departamento" class="datosestablecimiento_Id_Departamento"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Departamento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Departamento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Id_Departamento) ?>',1);"><div id="elh_datosestablecimiento_Id_Departamento" class="datosestablecimiento_Id_Departamento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Departamento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Id_Departamento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Id_Departamento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Id_Localidad) == "") { ?>
		<th data-name="Id_Localidad"><div id="elh_datosestablecimiento_Id_Localidad" class="datosestablecimiento_Id_Localidad"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Localidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Localidad"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Id_Localidad) ?>',1);"><div id="elh_datosestablecimiento_Id_Localidad" class="datosestablecimiento_Id_Localidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Localidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Id_Localidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Id_Localidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Domicilio->Visible) { // Domicilio ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Domicilio) == "") { ?>
		<th data-name="Domicilio"><div id="elh_datosestablecimiento_Domicilio" class="datosestablecimiento_Domicilio"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Domicilio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Domicilio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Domicilio) ?>',1);"><div id="elh_datosestablecimiento_Domicilio" class="datosestablecimiento_Domicilio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Domicilio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Domicilio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Domicilio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Telefono->Visible) { // Telefono ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_datosestablecimiento_Telefono" class="datosestablecimiento_Telefono"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Telefono) ?>',1);"><div id="elh_datosestablecimiento_Telefono" class="datosestablecimiento_Telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Telefono->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Mail->Visible) { // Mail ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Mail) == "") { ?>
		<th data-name="Mail"><div id="elh_datosestablecimiento_Mail" class="datosestablecimiento_Mail"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Mail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Mail"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Mail) ?>',1);"><div id="elh_datosestablecimiento_Mail" class="datosestablecimiento_Mail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Mail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Mail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Mail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Nro_Matricula->Visible) { // Nro Matricula ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Nro_Matricula) == "") { ?>
		<th data-name="Nro_Matricula"><div id="elh_datosestablecimiento_Nro_Matricula" class="datosestablecimiento_Nro_Matricula"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Nro_Matricula->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Matricula"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Nro_Matricula) ?>',1);"><div id="elh_datosestablecimiento_Nro_Matricula" class="datosestablecimiento_Nro_Matricula">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Nro_Matricula->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Nro_Matricula->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Nro_Matricula->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Cantidad_Aulas->Visible) { // Cantidad Aulas ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Aulas) == "") { ?>
		<th data-name="Cantidad_Aulas"><div id="elh_datosestablecimiento_Cantidad_Aulas" class="datosestablecimiento_Cantidad_Aulas"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Aulas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Aulas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Aulas) ?>',1);"><div id="elh_datosestablecimiento_Cantidad_Aulas" class="datosestablecimiento_Cantidad_Aulas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Aulas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Cantidad_Aulas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Cantidad_Aulas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Comparte_Edificio->Visible) { // Comparte Edificio ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Comparte_Edificio) == "") { ?>
		<th data-name="Comparte_Edificio"><div id="elh_datosestablecimiento_Comparte_Edificio" class="datosestablecimiento_Comparte_Edificio"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Comparte_Edificio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Comparte_Edificio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Comparte_Edificio) ?>',1);"><div id="elh_datosestablecimiento_Comparte_Edificio" class="datosestablecimiento_Comparte_Edificio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Comparte_Edificio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Comparte_Edificio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Comparte_Edificio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Turnos) == "") { ?>
		<th data-name="Cantidad_Turnos"><div id="elh_datosestablecimiento_Cantidad_Turnos" class="datosestablecimiento_Cantidad_Turnos"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Turnos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Turnos"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Turnos) ?>',1);"><div id="elh_datosestablecimiento_Cantidad_Turnos" class="datosestablecimiento_Cantidad_Turnos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Turnos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Cantidad_Turnos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Cantidad_Turnos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Id_Tipo_Esc) == "") { ?>
		<th data-name="Id_Tipo_Esc"><div id="elh_datosestablecimiento_Id_Tipo_Esc" class="datosestablecimiento_Id_Tipo_Esc"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Tipo_Esc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Esc"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Id_Tipo_Esc) ?>',1);"><div id="elh_datosestablecimiento_Id_Tipo_Esc" class="datosestablecimiento_Id_Tipo_Esc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Tipo_Esc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Id_Tipo_Esc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Id_Tipo_Esc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Universo->Visible) { // Universo ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Universo) == "") { ?>
		<th data-name="Universo"><div id="elh_datosestablecimiento_Universo" class="datosestablecimiento_Universo"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Universo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Universo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Universo) ?>',1);"><div id="elh_datosestablecimiento_Universo" class="datosestablecimiento_Universo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Universo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Universo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Universo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Tiene_Programa) == "") { ?>
		<th data-name="Tiene_Programa"><div id="elh_datosestablecimiento_Tiene_Programa" class="datosestablecimiento_Tiene_Programa"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Tiene_Programa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tiene_Programa"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Tiene_Programa) ?>',1);"><div id="elh_datosestablecimiento_Tiene_Programa" class="datosestablecimiento_Tiene_Programa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Tiene_Programa->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Tiene_Programa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Tiene_Programa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Sector->Visible) { // Sector ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Sector) == "") { ?>
		<th data-name="Sector"><div id="elh_datosestablecimiento_Sector" class="datosestablecimiento_Sector"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Sector->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sector"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Sector) ?>',1);"><div id="elh_datosestablecimiento_Sector" class="datosestablecimiento_Sector">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Sector->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Sector->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Sector->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Netbook_Conig) == "") { ?>
		<th data-name="Cantidad_Netbook_Conig"><div id="elh_datosestablecimiento_Cantidad_Netbook_Conig" class="datosestablecimiento_Cantidad_Netbook_Conig"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Netbook_Conig->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Netbook_Conig"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Netbook_Conig) ?>',1);"><div id="elh_datosestablecimiento_Cantidad_Netbook_Conig" class="datosestablecimiento_Cantidad_Netbook_Conig">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Netbook_Conig->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Cantidad_Netbook_Conig->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Cantidad_Netbook_Conig->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Nro_Cuise) == "") { ?>
		<th data-name="Nro_Cuise"><div id="elh_datosestablecimiento_Nro_Cuise" class="datosestablecimiento_Nro_Cuise"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Nro_Cuise->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Cuise"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Nro_Cuise) ?>',1);"><div id="elh_datosestablecimiento_Nro_Cuise" class="datosestablecimiento_Nro_Cuise">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Nro_Cuise->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Nro_Cuise->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Nro_Cuise->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Tipo_Zona) == "") { ?>
		<th data-name="Tipo_Zona"><div id="elh_datosestablecimiento_Tipo_Zona" class="datosestablecimiento_Tipo_Zona"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Tipo_Zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tipo_Zona"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Tipo_Zona) ?>',1);"><div id="elh_datosestablecimiento_Tipo_Zona" class="datosestablecimiento_Tipo_Zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Tipo_Zona->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Tipo_Zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Tipo_Zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Id_Estado_Esc) == "") { ?>
		<th data-name="Id_Estado_Esc"><div id="elh_datosestablecimiento_Id_Estado_Esc" class="datosestablecimiento_Id_Estado_Esc"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Estado_Esc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Esc"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Id_Estado_Esc) ?>',1);"><div id="elh_datosestablecimiento_Id_Estado_Esc" class="datosestablecimiento_Id_Estado_Esc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Estado_Esc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Id_Estado_Esc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Id_Estado_Esc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Id_Zona) == "") { ?>
		<th data-name="Id_Zona"><div id="elh_datosestablecimiento_Id_Zona" class="datosestablecimiento_Id_Zona"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Zona"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Id_Zona) ?>',1);"><div id="elh_datosestablecimiento_Id_Zona" class="datosestablecimiento_Id_Zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Id_Zona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Id_Zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Id_Zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Netbook_Actuales) == "") { ?>
		<th data-name="Cantidad_Netbook_Actuales"><div id="elh_datosestablecimiento_Cantidad_Netbook_Actuales" class="datosestablecimiento_Cantidad_Netbook_Actuales"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Netbook_Actuales"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Cantidad_Netbook_Actuales) ?>',1);"><div id="elh_datosestablecimiento_Cantidad_Netbook_Actuales" class="datosestablecimiento_Cantidad_Netbook_Actuales">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Cantidad_Netbook_Actuales->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Cantidad_Netbook_Actuales->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_datosestablecimiento_Fecha_Actualizacion" class="datosestablecimiento_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Fecha_Actualizacion) ?>',1);"><div id="elh_datosestablecimiento_Fecha_Actualizacion" class="datosestablecimiento_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datosestablecimiento->Usuario->Visible) { // Usuario ?>
	<?php if ($datosestablecimiento->SortUrl($datosestablecimiento->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_datosestablecimiento_Usuario" class="datosestablecimiento_Usuario"><div class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datosestablecimiento->SortUrl($datosestablecimiento->Usuario) ?>',1);"><div id="elh_datosestablecimiento_Usuario" class="datosestablecimiento_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datosestablecimiento->Usuario->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datosestablecimiento->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datosestablecimiento->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$datosestablecimiento_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($datosestablecimiento->ExportAll && $datosestablecimiento->Export <> "") {
	$datosestablecimiento_list->StopRec = $datosestablecimiento_list->TotalRecs;
} else {

	// Set the last record to display
	if ($datosestablecimiento_list->TotalRecs > $datosestablecimiento_list->StartRec + $datosestablecimiento_list->DisplayRecs - 1)
		$datosestablecimiento_list->StopRec = $datosestablecimiento_list->StartRec + $datosestablecimiento_list->DisplayRecs - 1;
	else
		$datosestablecimiento_list->StopRec = $datosestablecimiento_list->TotalRecs;
}
$datosestablecimiento_list->RecCnt = $datosestablecimiento_list->StartRec - 1;
if ($datosestablecimiento_list->Recordset && !$datosestablecimiento_list->Recordset->EOF) {
	$datosestablecimiento_list->Recordset->MoveFirst();
	$bSelectLimit = $datosestablecimiento_list->UseSelectLimit;
	if (!$bSelectLimit && $datosestablecimiento_list->StartRec > 1)
		$datosestablecimiento_list->Recordset->Move($datosestablecimiento_list->StartRec - 1);
} elseif (!$datosestablecimiento->AllowAddDeleteRow && $datosestablecimiento_list->StopRec == 0) {
	$datosestablecimiento_list->StopRec = $datosestablecimiento->GridAddRowCount;
}

// Initialize aggregate
$datosestablecimiento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$datosestablecimiento->ResetAttrs();
$datosestablecimiento_list->RenderRow();
while ($datosestablecimiento_list->RecCnt < $datosestablecimiento_list->StopRec) {
	$datosestablecimiento_list->RecCnt++;
	if (intval($datosestablecimiento_list->RecCnt) >= intval($datosestablecimiento_list->StartRec)) {
		$datosestablecimiento_list->RowCnt++;

		// Set up key count
		$datosestablecimiento_list->KeyCount = $datosestablecimiento_list->RowIndex;

		// Init row class and style
		$datosestablecimiento->ResetAttrs();
		$datosestablecimiento->CssClass = "";
		if ($datosestablecimiento->CurrentAction == "gridadd") {
		} else {
			$datosestablecimiento_list->LoadRowValues($datosestablecimiento_list->Recordset); // Load row values
		}
		$datosestablecimiento->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$datosestablecimiento->RowAttrs = array_merge($datosestablecimiento->RowAttrs, array('data-rowindex'=>$datosestablecimiento_list->RowCnt, 'id'=>'r' . $datosestablecimiento_list->RowCnt . '_datosestablecimiento', 'data-rowtype'=>$datosestablecimiento->RowType));

		// Render row
		$datosestablecimiento_list->RenderRow();

		// Render list options
		$datosestablecimiento_list->RenderListOptions();
?>
	<tr<?php echo $datosestablecimiento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$datosestablecimiento_list->ListOptions->Render("body", "left", $datosestablecimiento_list->RowCnt);
?>
	<?php if ($datosestablecimiento->CUE->Visible) { // CUE ?>
		<td data-name="CUE"<?php echo $datosestablecimiento->CUE->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_CUE" class="datosestablecimiento_CUE">
<span<?php echo $datosestablecimiento->CUE->ViewAttributes() ?>>
<?php echo $datosestablecimiento->CUE->ListViewValue() ?></span>
</span>
<a id="<?php echo $datosestablecimiento_list->PageObjName . "_row_" . $datosestablecimiento_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($datosestablecimiento->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla"<?php echo $datosestablecimiento->Sigla->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Sigla" class="datosestablecimiento_Sigla">
<span<?php echo $datosestablecimiento->Sigla->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Sigla->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Establecimiento->Visible) { // Establecimiento ?>
		<td data-name="Establecimiento"<?php echo $datosestablecimiento->Establecimiento->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Establecimiento" class="datosestablecimiento_Establecimiento">
<span<?php echo $datosestablecimiento->Establecimiento->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Establecimiento->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento"<?php echo $datosestablecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Id_Departamento" class="datosestablecimiento_Id_Departamento">
<span<?php echo $datosestablecimiento->Id_Departamento->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Departamento->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
		<td data-name="Id_Localidad"<?php echo $datosestablecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Id_Localidad" class="datosestablecimiento_Id_Localidad">
<span<?php echo $datosestablecimiento->Id_Localidad->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Localidad->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio"<?php echo $datosestablecimiento->Domicilio->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Domicilio" class="datosestablecimiento_Domicilio">
<span<?php echo $datosestablecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Domicilio->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $datosestablecimiento->Telefono->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Telefono" class="datosestablecimiento_Telefono">
<span<?php echo $datosestablecimiento->Telefono->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Telefono->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Mail->Visible) { // Mail ?>
		<td data-name="Mail"<?php echo $datosestablecimiento->Mail->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Mail" class="datosestablecimiento_Mail">
<span<?php echo $datosestablecimiento->Mail->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Mail->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Nro_Matricula->Visible) { // Nro Matricula ?>
		<td data-name="Nro_Matricula"<?php echo $datosestablecimiento->Nro_Matricula->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Nro_Matricula" class="datosestablecimiento_Nro_Matricula">
<span<?php echo $datosestablecimiento->Nro_Matricula->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Nro_Matricula->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Cantidad_Aulas->Visible) { // Cantidad Aulas ?>
		<td data-name="Cantidad_Aulas"<?php echo $datosestablecimiento->Cantidad_Aulas->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Cantidad_Aulas" class="datosestablecimiento_Cantidad_Aulas">
<span<?php echo $datosestablecimiento->Cantidad_Aulas->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Aulas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Comparte_Edificio->Visible) { // Comparte Edificio ?>
		<td data-name="Comparte_Edificio"<?php echo $datosestablecimiento->Comparte_Edificio->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Comparte_Edificio" class="datosestablecimiento_Comparte_Edificio">
<span<?php echo $datosestablecimiento->Comparte_Edificio->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Comparte_Edificio->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
		<td data-name="Cantidad_Turnos"<?php echo $datosestablecimiento->Cantidad_Turnos->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Cantidad_Turnos" class="datosestablecimiento_Cantidad_Turnos">
<span<?php echo $datosestablecimiento->Cantidad_Turnos->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Turnos->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
		<td data-name="Id_Tipo_Esc"<?php echo $datosestablecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Id_Tipo_Esc" class="datosestablecimiento_Id_Tipo_Esc">
<span<?php echo $datosestablecimiento->Id_Tipo_Esc->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Tipo_Esc->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Universo->Visible) { // Universo ?>
		<td data-name="Universo"<?php echo $datosestablecimiento->Universo->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Universo" class="datosestablecimiento_Universo">
<span<?php echo $datosestablecimiento->Universo->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Universo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
		<td data-name="Tiene_Programa"<?php echo $datosestablecimiento->Tiene_Programa->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Tiene_Programa" class="datosestablecimiento_Tiene_Programa">
<span<?php echo $datosestablecimiento->Tiene_Programa->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Tiene_Programa->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Sector->Visible) { // Sector ?>
		<td data-name="Sector"<?php echo $datosestablecimiento->Sector->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Sector" class="datosestablecimiento_Sector">
<span<?php echo $datosestablecimiento->Sector->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Sector->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
		<td data-name="Cantidad_Netbook_Conig"<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Cantidad_Netbook_Conig" class="datosestablecimiento_Cantidad_Netbook_Conig">
<span<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
		<td data-name="Nro_Cuise"<?php echo $datosestablecimiento->Nro_Cuise->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Nro_Cuise" class="datosestablecimiento_Nro_Cuise">
<span<?php echo $datosestablecimiento->Nro_Cuise->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Nro_Cuise->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
		<td data-name="Tipo_Zona"<?php echo $datosestablecimiento->Tipo_Zona->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Tipo_Zona" class="datosestablecimiento_Tipo_Zona">
<span<?php echo $datosestablecimiento->Tipo_Zona->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Tipo_Zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
		<td data-name="Id_Estado_Esc"<?php echo $datosestablecimiento->Id_Estado_Esc->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Id_Estado_Esc" class="datosestablecimiento_Id_Estado_Esc">
<span<?php echo $datosestablecimiento->Id_Estado_Esc->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Estado_Esc->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona"<?php echo $datosestablecimiento->Id_Zona->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Id_Zona" class="datosestablecimiento_Id_Zona">
<span<?php echo $datosestablecimiento->Id_Zona->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
		<td data-name="Cantidad_Netbook_Actuales"<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Cantidad_Netbook_Actuales" class="datosestablecimiento_Cantidad_Netbook_Actuales">
<span<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $datosestablecimiento->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Fecha_Actualizacion" class="datosestablecimiento_Fecha_Actualizacion">
<span<?php echo $datosestablecimiento->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datosestablecimiento->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $datosestablecimiento->Usuario->CellAttributes() ?>>
<span id="el<?php echo $datosestablecimiento_list->RowCnt ?>_datosestablecimiento_Usuario" class="datosestablecimiento_Usuario">
<span<?php echo $datosestablecimiento->Usuario->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Usuario->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$datosestablecimiento_list->ListOptions->Render("body", "right", $datosestablecimiento_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($datosestablecimiento->CurrentAction <> "gridadd")
		$datosestablecimiento_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($datosestablecimiento->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($datosestablecimiento_list->Recordset)
	$datosestablecimiento_list->Recordset->Close();
?>
<?php if ($datosestablecimiento->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($datosestablecimiento->CurrentAction <> "gridadd" && $datosestablecimiento->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($datosestablecimiento_list->Pager)) $datosestablecimiento_list->Pager = new cPrevNextPager($datosestablecimiento_list->StartRec, $datosestablecimiento_list->DisplayRecs, $datosestablecimiento_list->TotalRecs) ?>
<?php if ($datosestablecimiento_list->Pager->RecordCount > 0 && $datosestablecimiento_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($datosestablecimiento_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($datosestablecimiento_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $datosestablecimiento_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($datosestablecimiento_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($datosestablecimiento_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $datosestablecimiento_list->PageUrl() ?>start=<?php echo $datosestablecimiento_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $datosestablecimiento_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datosestablecimiento_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($datosestablecimiento_list->TotalRecs == 0 && $datosestablecimiento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datosestablecimiento_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<script type="text/javascript">
fdatosestablecimientolistsrch.FilterList = <?php echo $datosestablecimiento_list->GetFilterList() ?>;
fdatosestablecimientolistsrch.Init();
fdatosestablecimientolist.Init();
</script>
<?php } ?>
<?php
$datosestablecimiento_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($datosestablecimiento->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$datosestablecimiento_list->Page_Terminate();
?>
