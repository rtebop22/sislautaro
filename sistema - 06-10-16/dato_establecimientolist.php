<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "autoridades_escolaresgridcls.php" ?>
<?php include_once "referente_tecnicogridcls.php" ?>
<?php include_once "piso_tecnologicogridcls.php" ?>
<?php include_once "servidor_escolargridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dato_establecimiento_list = NULL; // Initialize page object first

class cdato_establecimiento_list extends cdato_establecimiento {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'dato_establecimiento';

	// Page object name
	var $PageObjName = 'dato_establecimiento_list';

	// Grid form hidden field names
	var $FormName = 'fdato_establecimientolist';
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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS["dato_establecimiento"]) || get_class($GLOBALS["dato_establecimiento"]) == "cdato_establecimiento") {
			$GLOBALS["dato_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dato_establecimiento"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "dato_establecimientoadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "dato_establecimientodelete.php";
		$this->MultiUpdateUrl = "dato_establecimientoupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dato_establecimiento', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdato_establecimientolistsrch";

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
		$this->Cue->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono_Escuela->SetVisibility();
		$this->Mail_Escuela->SetVisibility();
		$this->Matricula_Actual->SetVisibility();
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

			// Process auto fill for detail table 'autoridades_escolares'
			if (@$_POST["grid"] == "fautoridades_escolaresgrid") {
				if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
				$GLOBALS["autoridades_escolares_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'referente_tecnico'
			if (@$_POST["grid"] == "freferente_tecnicogrid") {
				if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
				$GLOBALS["referente_tecnico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'piso_tecnologico'
			if (@$_POST["grid"] == "fpiso_tecnologicogrid") {
				if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
				$GLOBALS["piso_tecnologico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'servidor_escolar'
			if (@$_POST["grid"] == "fservidor_escolargrid") {
				if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
				$GLOBALS["servidor_escolar_grid"]->Page_Init();
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
		global $EW_EXPORT, $dato_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dato_establecimiento);
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
	var $autoridades_escolares_Count;
	var $referente_tecnico_Count;
	var $piso_tecnologico_Count;
	var $servidor_escolar_Count;
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
			$this->Cue->setFormValue($arrKeyFlds[0]);
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
					$sKey .= $this->Cue->CurrentValue;

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
		if ($objForm->HasValue("x_Cue") && $objForm->HasValue("o_Cue") && $this->Cue->CurrentValue <> $this->Cue->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nombre_Establecimiento") && $objForm->HasValue("o_Nombre_Establecimiento") && $this->Nombre_Establecimiento->CurrentValue <> $this->Nombre_Establecimiento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Departamento") && $objForm->HasValue("o_Id_Departamento") && $this->Id_Departamento->CurrentValue <> $this->Id_Departamento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Localidad") && $objForm->HasValue("o_Id_Localidad") && $this->Id_Localidad->CurrentValue <> $this->Id_Localidad->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Domicilio") && $objForm->HasValue("o_Domicilio") && $this->Domicilio->CurrentValue <> $this->Domicilio->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Telefono_Escuela") && $objForm->HasValue("o_Telefono_Escuela") && $this->Telefono_Escuela->CurrentValue <> $this->Telefono_Escuela->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Mail_Escuela") && $objForm->HasValue("o_Mail_Escuela") && $this->Mail_Escuela->CurrentValue <> $this->Mail_Escuela->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Matricula_Actual") && $objForm->HasValue("o_Matricula_Actual") && $this->Matricula_Actual->CurrentValue <> $this->Matricula_Actual->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdato_establecimientolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Cue->AdvancedSearch->ToJSON(), ","); // Field Cue
		$sFilterList = ew_Concat($sFilterList, $this->Nombre_Establecimiento->AdvancedSearch->ToJSON(), ","); // Field Nombre_Establecimiento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Departamento->AdvancedSearch->ToJSON(), ","); // Field Id_Departamento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Localidad->AdvancedSearch->ToJSON(), ","); // Field Id_Localidad
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Telefono_Escuela->AdvancedSearch->ToJSON(), ","); // Field Telefono_Escuela
		$sFilterList = ew_Concat($sFilterList, $this->Mail_Escuela->AdvancedSearch->ToJSON(), ","); // Field Mail_Escuela
		$sFilterList = ew_Concat($sFilterList, $this->Matricula_Actual->AdvancedSearch->ToJSON(), ","); // Field Matricula_Actual
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdato_establecimientolistsrch", $filters);
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

		// Field Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = @$filter["x_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = @$filter["z_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchCondition = @$filter["v_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue2 = @$filter["y_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Nombre_Establecimiento"];
		$this->Nombre_Establecimiento->AdvancedSearch->Save();

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

		// Field Telefono_Escuela
		$this->Telefono_Escuela->AdvancedSearch->SearchValue = @$filter["x_Telefono_Escuela"];
		$this->Telefono_Escuela->AdvancedSearch->SearchOperator = @$filter["z_Telefono_Escuela"];
		$this->Telefono_Escuela->AdvancedSearch->SearchCondition = @$filter["v_Telefono_Escuela"];
		$this->Telefono_Escuela->AdvancedSearch->SearchValue2 = @$filter["y_Telefono_Escuela"];
		$this->Telefono_Escuela->AdvancedSearch->SearchOperator2 = @$filter["w_Telefono_Escuela"];
		$this->Telefono_Escuela->AdvancedSearch->Save();

		// Field Mail_Escuela
		$this->Mail_Escuela->AdvancedSearch->SearchValue = @$filter["x_Mail_Escuela"];
		$this->Mail_Escuela->AdvancedSearch->SearchOperator = @$filter["z_Mail_Escuela"];
		$this->Mail_Escuela->AdvancedSearch->SearchCondition = @$filter["v_Mail_Escuela"];
		$this->Mail_Escuela->AdvancedSearch->SearchValue2 = @$filter["y_Mail_Escuela"];
		$this->Mail_Escuela->AdvancedSearch->SearchOperator2 = @$filter["w_Mail_Escuela"];
		$this->Mail_Escuela->AdvancedSearch->Save();

		// Field Matricula_Actual
		$this->Matricula_Actual->AdvancedSearch->SearchValue = @$filter["x_Matricula_Actual"];
		$this->Matricula_Actual->AdvancedSearch->SearchOperator = @$filter["z_Matricula_Actual"];
		$this->Matricula_Actual->AdvancedSearch->SearchCondition = @$filter["v_Matricula_Actual"];
		$this->Matricula_Actual->AdvancedSearch->SearchValue2 = @$filter["y_Matricula_Actual"];
		$this->Matricula_Actual->AdvancedSearch->SearchOperator2 = @$filter["w_Matricula_Actual"];
		$this->Matricula_Actual->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Cue, $Default, FALSE); // Cue
		$this->BuildSearchSql($sWhere, $this->Nombre_Establecimiento, $Default, FALSE); // Nombre_Establecimiento
		$this->BuildSearchSql($sWhere, $this->Id_Departamento, $Default, FALSE); // Id_Departamento
		$this->BuildSearchSql($sWhere, $this->Id_Localidad, $Default, FALSE); // Id_Localidad
		$this->BuildSearchSql($sWhere, $this->Domicilio, $Default, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Telefono_Escuela, $Default, FALSE); // Telefono_Escuela
		$this->BuildSearchSql($sWhere, $this->Mail_Escuela, $Default, FALSE); // Mail_Escuela
		$this->BuildSearchSql($sWhere, $this->Matricula_Actual, $Default, FALSE); // Matricula_Actual
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Cue->AdvancedSearch->Save(); // Cue
			$this->Nombre_Establecimiento->AdvancedSearch->Save(); // Nombre_Establecimiento
			$this->Id_Departamento->AdvancedSearch->Save(); // Id_Departamento
			$this->Id_Localidad->AdvancedSearch->Save(); // Id_Localidad
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Telefono_Escuela->AdvancedSearch->Save(); // Telefono_Escuela
			$this->Mail_Escuela->AdvancedSearch->Save(); // Mail_Escuela
			$this->Matricula_Actual->AdvancedSearch->Save(); // Matricula_Actual
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
		$this->BuildBasicSearchSQL($sWhere, $this->Cue, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Establecimiento, $arKeywords, $type);
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
		if ($this->Cue->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Establecimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Departamento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Localidad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Telefono_Escuela->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Mail_Escuela->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Matricula_Actual->AdvancedSearch->IssetSession())
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
		$this->Cue->AdvancedSearch->UnsetSession();
		$this->Nombre_Establecimiento->AdvancedSearch->UnsetSession();
		$this->Id_Departamento->AdvancedSearch->UnsetSession();
		$this->Id_Localidad->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Telefono_Escuela->AdvancedSearch->UnsetSession();
		$this->Mail_Escuela->AdvancedSearch->UnsetSession();
		$this->Matricula_Actual->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Cue->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono_Escuela->AdvancedSearch->Load();
		$this->Mail_Escuela->AdvancedSearch->Load();
		$this->Matricula_Actual->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Cue); // Cue
			$this->UpdateSort($this->Nombre_Establecimiento); // Nombre_Establecimiento
			$this->UpdateSort($this->Id_Departamento); // Id_Departamento
			$this->UpdateSort($this->Id_Localidad); // Id_Localidad
			$this->UpdateSort($this->Domicilio); // Domicilio
			$this->UpdateSort($this->Telefono_Escuela); // Telefono_Escuela
			$this->UpdateSort($this->Mail_Escuela); // Mail_Escuela
			$this->UpdateSort($this->Matricula_Actual); // Matricula_Actual
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
				$this->Cue->setSort("");
				$this->Nombre_Establecimiento->setSort("");
				$this->Id_Departamento->setSort("");
				$this->Id_Localidad->setSort("");
				$this->Domicilio->setSort("");
				$this->Telefono_Escuela->setSort("");
				$this->Mail_Escuela->setSort("");
				$this->Matricula_Actual->setSort("");
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

		// "detail_autoridades_escolares"
		$item = &$this->ListOptions->Add("detail_autoridades_escolares");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;

		// "detail_referente_tecnico"
		$item = &$this->ListOptions->Add("detail_referente_tecnico");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;

		// "detail_piso_tecnologico"
		$item = &$this->ListOptions->Add("detail_piso_tecnologico");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;

		// "detail_servidor_escolar"
		$item = &$this->ListOptions->Add("detail_servidor_escolar");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("autoridades_escolares");
		$pages->Add("referente_tecnico");
		$pages->Add("piso_tecnologico");
		$pages->Add("servidor_escolar");
		$this->DetailPages = $pages;

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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_autoridades_escolares"
		$oListOpt = &$this->ListOptions->Items["detail_autoridades_escolares"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("autoridades_escolares", "TblCaption");
			$body .= str_replace("%c", $this->autoridades_escolares_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("autoridades_escolareslist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["autoridades_escolares_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "autoridades_escolares";
			}
			if ($GLOBALS["autoridades_escolares_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "autoridades_escolares";
			}
			if ($GLOBALS["autoridades_escolares_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "autoridades_escolares";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_referente_tecnico"
		$oListOpt = &$this->ListOptions->Items["detail_referente_tecnico"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("referente_tecnico", "TblCaption");
			$body .= str_replace("%c", $this->referente_tecnico_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("referente_tecnicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["referente_tecnico_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "referente_tecnico";
			}
			if ($GLOBALS["referente_tecnico_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "referente_tecnico";
			}
			if ($GLOBALS["referente_tecnico_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "referente_tecnico";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_piso_tecnologico"
		$oListOpt = &$this->ListOptions->Items["detail_piso_tecnologico"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("piso_tecnologico", "TblCaption");
			$body .= str_replace("%c", $this->piso_tecnologico_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("piso_tecnologicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["piso_tecnologico_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "piso_tecnologico";
			}
			if ($GLOBALS["piso_tecnologico_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "piso_tecnologico";
			}
			if ($GLOBALS["piso_tecnologico_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "piso_tecnologico";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_servidor_escolar"
		$oListOpt = &$this->ListOptions->Items["detail_servidor_escolar"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("servidor_escolar", "TblCaption");
			$body .= str_replace("%c", $this->servidor_escolar_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("servidor_escolarlist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["servidor_escolar_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "servidor_escolar";
			}
			if ($GLOBALS["servidor_escolar_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "servidor_escolar";
			}
			if ($GLOBALS["servidor_escolar_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "servidor_escolar";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Cue->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Cue->CurrentValue . "\">";
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
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_autoridades_escolares");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["autoridades_escolares"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["autoridades_escolares"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "autoridades_escolares";
		}
		$item = &$option->Add("detailadd_referente_tecnico");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["referente_tecnico"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["referente_tecnico"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "referente_tecnico";
		}
		$item = &$option->Add("detailadd_piso_tecnologico");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["piso_tecnologico"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["piso_tecnologico"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "piso_tecnologico";
		}
		$item = &$option->Add("detailadd_servidor_escolar");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["servidor_escolar"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["servidor_escolar"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "servidor_escolar";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->IsLoggedIn());

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
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fdato_establecimientolist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdato_establecimientolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdato_establecimientolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdato_establecimientolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdato_establecimientolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"dato_establecimientosrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		$this->Cue->CurrentValue = NULL;
		$this->Cue->OldValue = $this->Cue->CurrentValue;
		$this->Nombre_Establecimiento->CurrentValue = NULL;
		$this->Nombre_Establecimiento->OldValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Id_Departamento->CurrentValue = NULL;
		$this->Id_Departamento->OldValue = $this->Id_Departamento->CurrentValue;
		$this->Id_Localidad->CurrentValue = NULL;
		$this->Id_Localidad->OldValue = $this->Id_Localidad->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Telefono_Escuela->CurrentValue = NULL;
		$this->Telefono_Escuela->OldValue = $this->Telefono_Escuela->CurrentValue;
		$this->Mail_Escuela->CurrentValue = NULL;
		$this->Mail_Escuela->OldValue = $this->Mail_Escuela->CurrentValue;
		$this->Matricula_Actual->CurrentValue = NULL;
		$this->Matricula_Actual->OldValue = $this->Matricula_Actual->CurrentValue;
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
		// Cue

		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cue"]);
		if ($this->Cue->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cue->AdvancedSearch->SearchOperator = @$_GET["z_Cue"];

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Establecimiento"]);
		if ($this->Nombre_Establecimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Establecimiento"];

		// Id_Departamento
		$this->Id_Departamento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Departamento"]);
		if ($this->Id_Departamento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Departamento->AdvancedSearch->SearchOperator = @$_GET["z_Id_Departamento"];

		// Id_Localidad
		$this->Id_Localidad->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Localidad"]);
		if ($this->Id_Localidad->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Localidad->AdvancedSearch->SearchOperator = @$_GET["z_Id_Localidad"];

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Domicilio"]);
		if ($this->Domicilio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Domicilio->AdvancedSearch->SearchOperator = @$_GET["z_Domicilio"];

		// Telefono_Escuela
		$this->Telefono_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Telefono_Escuela"]);
		if ($this->Telefono_Escuela->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Telefono_Escuela->AdvancedSearch->SearchOperator = @$_GET["z_Telefono_Escuela"];

		// Mail_Escuela
		$this->Mail_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Mail_Escuela"]);
		if ($this->Mail_Escuela->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Mail_Escuela->AdvancedSearch->SearchOperator = @$_GET["z_Mail_Escuela"];

		// Matricula_Actual
		$this->Matricula_Actual->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Matricula_Actual"]);
		if ($this->Matricula_Actual->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Matricula_Actual->AdvancedSearch->SearchOperator = @$_GET["z_Matricula_Actual"];

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
		if (!$this->Cue->FldIsDetailKey) {
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
		}
		$this->Cue->setOldValue($objForm->GetValue("o_Cue"));
		if (!$this->Nombre_Establecimiento->FldIsDetailKey) {
			$this->Nombre_Establecimiento->setFormValue($objForm->GetValue("x_Nombre_Establecimiento"));
		}
		$this->Nombre_Establecimiento->setOldValue($objForm->GetValue("o_Nombre_Establecimiento"));
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->setOldValue($objForm->GetValue("o_Id_Departamento"));
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->setOldValue($objForm->GetValue("o_Id_Localidad"));
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		$this->Domicilio->setOldValue($objForm->GetValue("o_Domicilio"));
		if (!$this->Telefono_Escuela->FldIsDetailKey) {
			$this->Telefono_Escuela->setFormValue($objForm->GetValue("x_Telefono_Escuela"));
		}
		$this->Telefono_Escuela->setOldValue($objForm->GetValue("o_Telefono_Escuela"));
		if (!$this->Mail_Escuela->FldIsDetailKey) {
			$this->Mail_Escuela->setFormValue($objForm->GetValue("x_Mail_Escuela"));
		}
		$this->Mail_Escuela->setOldValue($objForm->GetValue("o_Mail_Escuela"));
		if (!$this->Matricula_Actual->FldIsDetailKey) {
			$this->Matricula_Actual->setFormValue($objForm->GetValue("x_Matricula_Actual"));
		}
		$this->Matricula_Actual->setOldValue($objForm->GetValue("o_Matricula_Actual"));
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
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Nombre_Establecimiento->CurrentValue = $this->Nombre_Establecimiento->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono_Escuela->CurrentValue = $this->Telefono_Escuela->FormValue;
		$this->Mail_Escuela->CurrentValue = $this->Mail_Escuela->FormValue;
		$this->Matricula_Actual->CurrentValue = $this->Matricula_Actual->FormValue;
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono_Escuela->setDbValue($rs->fields('Telefono_Escuela'));
		$this->Mail_Escuela->setDbValue($rs->fields('Mail_Escuela'));
		$this->Matricula_Actual->setDbValue($rs->fields('Matricula_Actual'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
		$sDetailFilter = $GLOBALS["autoridades_escolares"]->SqlDetailFilter_dato_establecimiento();
		$sDetailFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["autoridades_escolares"]->setCurrentMasterTable("dato_establecimiento");
		$sDetailFilter = $GLOBALS["autoridades_escolares"]->ApplyUserIDFilters($sDetailFilter);
		$this->autoridades_escolares_Count = $GLOBALS["autoridades_escolares"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
		$sDetailFilter = $GLOBALS["referente_tecnico"]->SqlDetailFilter_dato_establecimiento();
		$sDetailFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["referente_tecnico"]->setCurrentMasterTable("dato_establecimiento");
		$sDetailFilter = $GLOBALS["referente_tecnico"]->ApplyUserIDFilters($sDetailFilter);
		$this->referente_tecnico_Count = $GLOBALS["referente_tecnico"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
		$sDetailFilter = $GLOBALS["piso_tecnologico"]->SqlDetailFilter_dato_establecimiento();
		$sDetailFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["piso_tecnologico"]->setCurrentMasterTable("dato_establecimiento");
		$sDetailFilter = $GLOBALS["piso_tecnologico"]->ApplyUserIDFilters($sDetailFilter);
		$this->piso_tecnologico_Count = $GLOBALS["piso_tecnologico"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
		$sDetailFilter = $GLOBALS["servidor_escolar"]->SqlDetailFilter_dato_establecimiento();
		$sDetailFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["servidor_escolar"]->setCurrentMasterTable("dato_establecimiento");
		$sDetailFilter = $GLOBALS["servidor_escolar"]->ApplyUserIDFilters($sDetailFilter);
		$this->servidor_escolar_Count = $GLOBALS["servidor_escolar"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono_Escuela->DbValue = $row['Telefono_Escuela'];
		$this->Mail_Escuela->DbValue = $row['Mail_Escuela'];
		$this->Matricula_Actual->DbValue = $row['Matricula_Actual'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
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
		// Nombre_Establecimiento
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono_Escuela
		// Mail_Escuela
		// Matricula_Actual
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

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

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono_Escuela
		$this->Telefono_Escuela->ViewValue = $this->Telefono_Escuela->CurrentValue;
		$this->Telefono_Escuela->ViewCustomAttributes = "";

		// Mail_Escuela
		$this->Mail_Escuela->ViewValue = $this->Mail_Escuela->CurrentValue;
		$this->Mail_Escuela->ViewCustomAttributes = "";

		// Matricula_Actual
		$this->Matricula_Actual->ViewValue = $this->Matricula_Actual->CurrentValue;
		$this->Matricula_Actual->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

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

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";
			$this->Telefono_Escuela->TooltipValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";
			$this->Mail_Escuela->TooltipValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";
			$this->Matricula_Actual->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->CurrentValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
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

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono_Escuela
			$this->Telefono_Escuela->EditAttrs["class"] = "form-control";
			$this->Telefono_Escuela->EditCustomAttributes = "";
			$this->Telefono_Escuela->EditValue = ew_HtmlEncode($this->Telefono_Escuela->CurrentValue);
			$this->Telefono_Escuela->PlaceHolder = ew_RemoveHtml($this->Telefono_Escuela->FldCaption());

			// Mail_Escuela
			$this->Mail_Escuela->EditAttrs["class"] = "form-control";
			$this->Mail_Escuela->EditCustomAttributes = "";
			$this->Mail_Escuela->EditValue = ew_HtmlEncode($this->Mail_Escuela->CurrentValue);
			$this->Mail_Escuela->PlaceHolder = ew_RemoveHtml($this->Mail_Escuela->FldCaption());

			// Matricula_Actual
			$this->Matricula_Actual->EditAttrs["class"] = "form-control";
			$this->Matricula_Actual->EditCustomAttributes = "";
			$this->Matricula_Actual->EditValue = ew_HtmlEncode($this->Matricula_Actual->CurrentValue);
			$this->Matricula_Actual->PlaceHolder = ew_RemoveHtml($this->Matricula_Actual->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = $this->Cue->CurrentValue;
			$this->Cue->ViewCustomAttributes = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
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

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono_Escuela
			$this->Telefono_Escuela->EditAttrs["class"] = "form-control";
			$this->Telefono_Escuela->EditCustomAttributes = "";
			$this->Telefono_Escuela->EditValue = ew_HtmlEncode($this->Telefono_Escuela->CurrentValue);
			$this->Telefono_Escuela->PlaceHolder = ew_RemoveHtml($this->Telefono_Escuela->FldCaption());

			// Mail_Escuela
			$this->Mail_Escuela->EditAttrs["class"] = "form-control";
			$this->Mail_Escuela->EditCustomAttributes = "";
			$this->Mail_Escuela->EditValue = ew_HtmlEncode($this->Mail_Escuela->CurrentValue);
			$this->Mail_Escuela->PlaceHolder = ew_RemoveHtml($this->Mail_Escuela->FldCaption());

			// Matricula_Actual
			$this->Matricula_Actual->EditAttrs["class"] = "form-control";
			$this->Matricula_Actual->EditCustomAttributes = "";
			$this->Matricula_Actual->EditValue = ew_HtmlEncode($this->Matricula_Actual->CurrentValue);
			$this->Matricula_Actual->PlaceHolder = ew_RemoveHtml($this->Matricula_Actual->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";

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
		if (!$this->Cue->FldIsDetailKey && !is_null($this->Cue->FormValue) && $this->Cue->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cue->FldCaption(), $this->Cue->ReqErrMsg));
		}
		if (!$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if (!$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Matricula_Actual->FormValue)) {
			ew_AddMessage($gsFormError, $this->Matricula_Actual->FldErrMsg());
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

		// Check if records exist for detail table 'autoridades_escolares'
		if (!isset($GLOBALS["autoridades_escolares"])) $GLOBALS["autoridades_escolares"] = new cautoridades_escolares();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["autoridades_escolares"]->LoadRs("`Cue` = " . ew_QuotedValue($row['Cue'], EW_DATATYPE_STRING, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "autoridades_escolares", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}

		// Check if records exist for detail table 'referente_tecnico'
		if (!isset($GLOBALS["referente_tecnico"])) $GLOBALS["referente_tecnico"] = new creferente_tecnico();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["referente_tecnico"]->LoadRs("`Cue` = " . ew_QuotedValue($row['Cue'], EW_DATATYPE_STRING, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "referente_tecnico", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}

		// Check if records exist for detail table 'piso_tecnologico'
		if (!isset($GLOBALS["piso_tecnologico"])) $GLOBALS["piso_tecnologico"] = new cpiso_tecnologico();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["piso_tecnologico"]->LoadRs("`Cue` = " . ew_QuotedValue($row['Cue'], EW_DATATYPE_STRING, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "piso_tecnologico", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}

		// Check if records exist for detail table 'servidor_escolar'
		if (!isset($GLOBALS["servidor_escolar"])) $GLOBALS["servidor_escolar"] = new cservidor_escolar();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["servidor_escolar"]->LoadRs("`Cue` = " . ew_QuotedValue($row['Cue'], EW_DATATYPE_STRING, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "servidor_escolar", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}
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
				$sThisKey .= $row['Cue'];
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

			// Cue
			// Nombre_Establecimiento

			$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, $this->Nombre_Establecimiento->ReadOnly);

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly);

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly);

			// Domicilio
			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly);

			// Telefono_Escuela
			$this->Telefono_Escuela->SetDbValueDef($rsnew, $this->Telefono_Escuela->CurrentValue, NULL, $this->Telefono_Escuela->ReadOnly);

			// Mail_Escuela
			$this->Mail_Escuela->SetDbValueDef($rsnew, $this->Mail_Escuela->CurrentValue, NULL, $this->Mail_Escuela->ReadOnly);

			// Matricula_Actual
			$this->Matricula_Actual->SetDbValueDef($rsnew, $this->Matricula_Actual->CurrentValue, NULL, $this->Matricula_Actual->ReadOnly);

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

		// Cue
		$this->Cue->SetDbValueDef($rsnew, $this->Cue->CurrentValue, "", FALSE);

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, FALSE);

		// Id_Departamento
		$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, FALSE);

		// Id_Localidad
		$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Telefono_Escuela
		$this->Telefono_Escuela->SetDbValueDef($rsnew, $this->Telefono_Escuela->CurrentValue, NULL, FALSE);

		// Mail_Escuela
		$this->Mail_Escuela->SetDbValueDef($rsnew, $this->Mail_Escuela->CurrentValue, NULL, FALSE);

		// Matricula_Actual
		$this->Matricula_Actual->SetDbValueDef($rsnew, $this->Matricula_Actual->CurrentValue, NULL, FALSE);

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
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Cue']) == "") {
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
		$this->Cue->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono_Escuela->AdvancedSearch->Load();
		$this->Mail_Escuela->AdvancedSearch->Load();
		$this->Matricula_Actual->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fdato_establecimientolist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_dato_establecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dato_establecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdato_establecimientolist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "");
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'dato_establecimiento';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
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
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
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
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
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
if (!isset($dato_establecimiento_list)) $dato_establecimiento_list = new cdato_establecimiento_list();

// Page init
$dato_establecimiento_list->Page_Init();

// Page main
$dato_establecimiento_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dato_establecimiento_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdato_establecimientolist = new ew_Form("fdato_establecimientolist", "list");
fdato_establecimientolist.FormKeyCountName = '<?php echo $dato_establecimiento_list->FormKeyCountName ?>';

// Validate form
fdato_establecimientolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Cue");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Cue->FldCaption(), $dato_establecimiento->Cue->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Departamento->FldCaption(), $dato_establecimiento->Id_Departamento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Localidad->FldCaption(), $dato_establecimiento->Id_Localidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Matricula_Actual");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Matricula_Actual->FldErrMsg()) ?>");

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
fdato_establecimientolist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Cue", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nombre_Establecimiento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Departamento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Localidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Domicilio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Telefono_Escuela", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Mail_Escuela", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Matricula_Actual", false)) return false;
	return true;
}

// Form_CustomValidate event
fdato_establecimientolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdato_establecimientolist.ValidateRequired = true;
<?php } else { ?>
fdato_establecimientolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdato_establecimientolist.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdato_establecimientolist.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
var CurrentSearchForm = fdato_establecimientolistsrch = new ew_Form("fdato_establecimientolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if ($dato_establecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($dato_establecimiento_list->TotalRecs > 0 && $dato_establecimiento_list->ExportOptions->Visible()) { ?>
<?php $dato_establecimiento_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($dato_establecimiento_list->SearchOptions->Visible()) { ?>
<?php $dato_establecimiento_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($dato_establecimiento_list->FilterOptions->Visible()) { ?>
<?php $dato_establecimiento_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($dato_establecimiento->CurrentAction == "gridadd") {
	$dato_establecimiento->CurrentFilter = "0=1";
	$dato_establecimiento_list->StartRec = 1;
	$dato_establecimiento_list->DisplayRecs = $dato_establecimiento->GridAddRowCount;
	$dato_establecimiento_list->TotalRecs = $dato_establecimiento_list->DisplayRecs;
	$dato_establecimiento_list->StopRec = $dato_establecimiento_list->DisplayRecs;
} else {
	$bSelectLimit = $dato_establecimiento_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($dato_establecimiento_list->TotalRecs <= 0)
			$dato_establecimiento_list->TotalRecs = $dato_establecimiento->SelectRecordCount();
	} else {
		if (!$dato_establecimiento_list->Recordset && ($dato_establecimiento_list->Recordset = $dato_establecimiento_list->LoadRecordset()))
			$dato_establecimiento_list->TotalRecs = $dato_establecimiento_list->Recordset->RecordCount();
	}
	$dato_establecimiento_list->StartRec = 1;
	if ($dato_establecimiento_list->DisplayRecs <= 0 || ($dato_establecimiento->Export <> "" && $dato_establecimiento->ExportAll)) // Display all records
		$dato_establecimiento_list->DisplayRecs = $dato_establecimiento_list->TotalRecs;
	if (!($dato_establecimiento->Export <> "" && $dato_establecimiento->ExportAll))
		$dato_establecimiento_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$dato_establecimiento_list->Recordset = $dato_establecimiento_list->LoadRecordset($dato_establecimiento_list->StartRec-1, $dato_establecimiento_list->DisplayRecs);

	// Set no record found message
	if ($dato_establecimiento->CurrentAction == "" && $dato_establecimiento_list->TotalRecs == 0) {
		if ($dato_establecimiento_list->SearchWhere == "0=101")
			$dato_establecimiento_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$dato_establecimiento_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($dato_establecimiento_list->AuditTrailOnSearch && $dato_establecimiento_list->Command == "search" && !$dato_establecimiento_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $dato_establecimiento_list->getSessionWhere();
		$dato_establecimiento_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$dato_establecimiento_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($dato_establecimiento->Export == "" && $dato_establecimiento->CurrentAction == "") { ?>
<form name="fdato_establecimientolistsrch" id="fdato_establecimientolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($dato_establecimiento_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdato_establecimientolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="dato_establecimiento">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($dato_establecimiento_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($dato_establecimiento_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $dato_establecimiento_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($dato_establecimiento_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($dato_establecimiento_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($dato_establecimiento_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($dato_establecimiento_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $dato_establecimiento_list->ShowPageHeader(); ?>
<?php
$dato_establecimiento_list->ShowMessage();
?>
<?php if ($dato_establecimiento_list->TotalRecs > 0 || $dato_establecimiento->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid dato_establecimiento">
<form name="fdato_establecimientolist" id="fdato_establecimientolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_dato_establecimiento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($dato_establecimiento_list->TotalRecs > 0) { ?>
<table id="tbl_dato_establecimientolist" class="table ewTable">
<?php echo $dato_establecimiento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$dato_establecimiento_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$dato_establecimiento_list->RenderListOptions();

// Render list options (header, left)
$dato_establecimiento_list->ListOptions->Render("header", "left");
?>
<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Cue) == "") { ?>
		<th data-name="Cue"><div id="elh_dato_establecimiento_Cue" class="dato_establecimiento_Cue"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cue->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Cue) ?>',1);"><div id="elh_dato_establecimiento_Cue" class="dato_establecimiento_Cue">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cue->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Cue->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Cue->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Nombre_Establecimiento) == "") { ?>
		<th data-name="Nombre_Establecimiento"><div id="elh_dato_establecimiento_Nombre_Establecimiento" class="dato_establecimiento_Nombre_Establecimiento"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nombre_Establecimiento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Nombre_Establecimiento) ?>',1);"><div id="elh_dato_establecimiento_Nombre_Establecimiento" class="dato_establecimiento_Nombre_Establecimiento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Nombre_Establecimiento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Nombre_Establecimiento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Id_Departamento) == "") { ?>
		<th data-name="Id_Departamento"><div id="elh_dato_establecimiento_Id_Departamento" class="dato_establecimiento_Id_Departamento"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Departamento"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Id_Departamento) ?>',1);"><div id="elh_dato_establecimiento_Id_Departamento" class="dato_establecimiento_Id_Departamento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Id_Departamento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Id_Departamento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Id_Localidad) == "") { ?>
		<th data-name="Id_Localidad"><div id="elh_dato_establecimiento_Id_Localidad" class="dato_establecimiento_Id_Localidad"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Localidad"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Id_Localidad) ?>',1);"><div id="elh_dato_establecimiento_Id_Localidad" class="dato_establecimiento_Id_Localidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Id_Localidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Id_Localidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Domicilio) == "") { ?>
		<th data-name="Domicilio"><div id="elh_dato_establecimiento_Domicilio" class="dato_establecimiento_Domicilio"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Domicilio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Domicilio) ?>',1);"><div id="elh_dato_establecimiento_Domicilio" class="dato_establecimiento_Domicilio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Domicilio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Domicilio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Telefono_Escuela) == "") { ?>
		<th data-name="Telefono_Escuela"><div id="elh_dato_establecimiento_Telefono_Escuela" class="dato_establecimiento_Telefono_Escuela"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono_Escuela"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Telefono_Escuela) ?>',1);"><div id="elh_dato_establecimiento_Telefono_Escuela" class="dato_establecimiento_Telefono_Escuela">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Telefono_Escuela->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Telefono_Escuela->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Mail_Escuela) == "") { ?>
		<th data-name="Mail_Escuela"><div id="elh_dato_establecimiento_Mail_Escuela" class="dato_establecimiento_Mail_Escuela"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Mail_Escuela"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Mail_Escuela) ?>',1);"><div id="elh_dato_establecimiento_Mail_Escuela" class="dato_establecimiento_Mail_Escuela">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Mail_Escuela->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Mail_Escuela->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Matricula_Actual) == "") { ?>
		<th data-name="Matricula_Actual"><div id="elh_dato_establecimiento_Matricula_Actual" class="dato_establecimiento_Matricula_Actual"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Matricula_Actual"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Matricula_Actual) ?>',1);"><div id="elh_dato_establecimiento_Matricula_Actual" class="dato_establecimiento_Matricula_Actual">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Matricula_Actual->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Matricula_Actual->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_dato_establecimiento_Usuario" class="dato_establecimiento_Usuario"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Usuario) ?>',1);"><div id="elh_dato_establecimiento_Usuario" class="dato_establecimiento_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_dato_establecimiento_Fecha_Actualizacion" class="dato_establecimiento_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Fecha_Actualizacion) ?>',1);"><div id="elh_dato_establecimiento_Fecha_Actualizacion" class="dato_establecimiento_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$dato_establecimiento_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($dato_establecimiento->ExportAll && $dato_establecimiento->Export <> "") {
	$dato_establecimiento_list->StopRec = $dato_establecimiento_list->TotalRecs;
} else {

	// Set the last record to display
	if ($dato_establecimiento_list->TotalRecs > $dato_establecimiento_list->StartRec + $dato_establecimiento_list->DisplayRecs - 1)
		$dato_establecimiento_list->StopRec = $dato_establecimiento_list->StartRec + $dato_establecimiento_list->DisplayRecs - 1;
	else
		$dato_establecimiento_list->StopRec = $dato_establecimiento_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($dato_establecimiento_list->FormKeyCountName) && ($dato_establecimiento->CurrentAction == "gridadd" || $dato_establecimiento->CurrentAction == "gridedit" || $dato_establecimiento->CurrentAction == "F")) {
		$dato_establecimiento_list->KeyCount = $objForm->GetValue($dato_establecimiento_list->FormKeyCountName);
		$dato_establecimiento_list->StopRec = $dato_establecimiento_list->StartRec + $dato_establecimiento_list->KeyCount - 1;
	}
}
$dato_establecimiento_list->RecCnt = $dato_establecimiento_list->StartRec - 1;
if ($dato_establecimiento_list->Recordset && !$dato_establecimiento_list->Recordset->EOF) {
	$dato_establecimiento_list->Recordset->MoveFirst();
	$bSelectLimit = $dato_establecimiento_list->UseSelectLimit;
	if (!$bSelectLimit && $dato_establecimiento_list->StartRec > 1)
		$dato_establecimiento_list->Recordset->Move($dato_establecimiento_list->StartRec - 1);
} elseif (!$dato_establecimiento->AllowAddDeleteRow && $dato_establecimiento_list->StopRec == 0) {
	$dato_establecimiento_list->StopRec = $dato_establecimiento->GridAddRowCount;
}

// Initialize aggregate
$dato_establecimiento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$dato_establecimiento->ResetAttrs();
$dato_establecimiento_list->RenderRow();
if ($dato_establecimiento->CurrentAction == "gridadd")
	$dato_establecimiento_list->RowIndex = 0;
if ($dato_establecimiento->CurrentAction == "gridedit")
	$dato_establecimiento_list->RowIndex = 0;
while ($dato_establecimiento_list->RecCnt < $dato_establecimiento_list->StopRec) {
	$dato_establecimiento_list->RecCnt++;
	if (intval($dato_establecimiento_list->RecCnt) >= intval($dato_establecimiento_list->StartRec)) {
		$dato_establecimiento_list->RowCnt++;
		if ($dato_establecimiento->CurrentAction == "gridadd" || $dato_establecimiento->CurrentAction == "gridedit" || $dato_establecimiento->CurrentAction == "F") {
			$dato_establecimiento_list->RowIndex++;
			$objForm->Index = $dato_establecimiento_list->RowIndex;
			if ($objForm->HasValue($dato_establecimiento_list->FormActionName))
				$dato_establecimiento_list->RowAction = strval($objForm->GetValue($dato_establecimiento_list->FormActionName));
			elseif ($dato_establecimiento->CurrentAction == "gridadd")
				$dato_establecimiento_list->RowAction = "insert";
			else
				$dato_establecimiento_list->RowAction = "";
		}

		// Set up key count
		$dato_establecimiento_list->KeyCount = $dato_establecimiento_list->RowIndex;

		// Init row class and style
		$dato_establecimiento->ResetAttrs();
		$dato_establecimiento->CssClass = "";
		if ($dato_establecimiento->CurrentAction == "gridadd") {
			$dato_establecimiento_list->LoadDefaultValues(); // Load default values
		} else {
			$dato_establecimiento_list->LoadRowValues($dato_establecimiento_list->Recordset); // Load row values
		}
		$dato_establecimiento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($dato_establecimiento->CurrentAction == "gridadd") // Grid add
			$dato_establecimiento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($dato_establecimiento->CurrentAction == "gridadd" && $dato_establecimiento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$dato_establecimiento_list->RestoreCurrentRowFormValues($dato_establecimiento_list->RowIndex); // Restore form values
		if ($dato_establecimiento->CurrentAction == "gridedit") { // Grid edit
			if ($dato_establecimiento->EventCancelled) {
				$dato_establecimiento_list->RestoreCurrentRowFormValues($dato_establecimiento_list->RowIndex); // Restore form values
			}
			if ($dato_establecimiento_list->RowAction == "insert")
				$dato_establecimiento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$dato_establecimiento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($dato_establecimiento->CurrentAction == "gridedit" && ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT || $dato_establecimiento->RowType == EW_ROWTYPE_ADD) && $dato_establecimiento->EventCancelled) // Update failed
			$dato_establecimiento_list->RestoreCurrentRowFormValues($dato_establecimiento_list->RowIndex); // Restore form values
		if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$dato_establecimiento_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$dato_establecimiento->RowAttrs = array_merge($dato_establecimiento->RowAttrs, array('data-rowindex'=>$dato_establecimiento_list->RowCnt, 'id'=>'r' . $dato_establecimiento_list->RowCnt . '_dato_establecimiento', 'data-rowtype'=>$dato_establecimiento->RowType));

		// Render row
		$dato_establecimiento_list->RenderRow();

		// Render list options
		$dato_establecimiento_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($dato_establecimiento_list->RowAction <> "delete" && $dato_establecimiento_list->RowAction <> "insertdelete" && !($dato_establecimiento_list->RowAction == "insert" && $dato_establecimiento->CurrentAction == "F" && $dato_establecimiento_list->EmptyRow())) {
?>
	<tr<?php echo $dato_establecimiento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$dato_establecimiento_list->ListOptions->Render("body", "left", $dato_establecimiento_list->RowCnt);
?>
	<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
		<td data-name="Cue"<?php echo $dato_establecimiento->Cue->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cue" class="form-group dato_establecimiento_Cue">
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cue" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cue" class="form-group dato_establecimiento_Cue">
<span<?php echo $dato_establecimiento->Cue->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $dato_establecimiento->Cue->EditValue ?></p></span>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->CurrentValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cue" class="dato_establecimiento_Cue">
<span<?php echo $dato_establecimiento->Cue->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cue->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $dato_establecimiento_list->PageObjName . "_row_" . $dato_establecimiento_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento"<?php echo $dato_establecimiento->Nombre_Establecimiento->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nombre_Establecimiento" class="dato_establecimiento_Nombre_Establecimiento">
<span<?php echo $dato_establecimiento->Nombre_Establecimiento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nombre_Establecimiento->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Departamento" class="form-group dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Departamento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Departamento->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Departamento" class="form-group dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Departamento" class="dato_establecimiento_Id_Departamento">
<span<?php echo $dato_establecimiento->Id_Departamento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
		<td data-name="Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Localidad" class="form-group dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Localidad" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Localidad->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Localidad" class="form-group dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Localidad" class="dato_establecimiento_Id_Localidad">
<span<?php echo $dato_establecimiento->Id_Localidad->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio"<?php echo $dato_establecimiento->Domicilio->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Domicilio" class="form-group dato_establecimiento_Domicilio">
<input type="text" data-table="dato_establecimiento" data-field="x_Domicilio" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Domicilio->EditValue ?>"<?php echo $dato_establecimiento->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Domicilio" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Domicilio" class="form-group dato_establecimiento_Domicilio">
<input type="text" data-table="dato_establecimiento" data-field="x_Domicilio" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Domicilio->EditValue ?>"<?php echo $dato_establecimiento->Domicilio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Domicilio" class="dato_establecimiento_Domicilio">
<span<?php echo $dato_establecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Domicilio->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
		<td data-name="Telefono_Escuela"<?php echo $dato_establecimiento->Telefono_Escuela->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Telefono_Escuela" class="form-group dato_establecimiento_Telefono_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Telefono_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Telefono_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" value="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Telefono_Escuela" class="form-group dato_establecimiento_Telefono_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Telefono_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Telefono_Escuela->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Telefono_Escuela" class="dato_establecimiento_Telefono_Escuela">
<span<?php echo $dato_establecimiento->Telefono_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Telefono_Escuela->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
		<td data-name="Mail_Escuela"<?php echo $dato_establecimiento->Mail_Escuela->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Mail_Escuela" class="form-group dato_establecimiento_Mail_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Mail_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Mail_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" value="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Mail_Escuela" class="form-group dato_establecimiento_Mail_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Mail_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Mail_Escuela->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Mail_Escuela" class="dato_establecimiento_Mail_Escuela">
<span<?php echo $dato_establecimiento->Mail_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Mail_Escuela->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
		<td data-name="Matricula_Actual"<?php echo $dato_establecimiento->Matricula_Actual->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Matricula_Actual" class="form-group dato_establecimiento_Matricula_Actual">
<input type="text" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Matricula_Actual->EditValue ?>"<?php echo $dato_establecimiento->Matricula_Actual->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" value="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Matricula_Actual" class="form-group dato_establecimiento_Matricula_Actual">
<input type="text" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Matricula_Actual->EditValue ?>"<?php echo $dato_establecimiento->Matricula_Actual->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Matricula_Actual" class="dato_establecimiento_Matricula_Actual">
<span<?php echo $dato_establecimiento->Matricula_Actual->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Matricula_Actual->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $dato_establecimiento->Usuario->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Usuario" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($dato_establecimiento->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Usuario" class="dato_establecimiento_Usuario">
<span<?php echo $dato_establecimiento->Usuario->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $dato_establecimiento->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Fecha_Actualizacion" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($dato_establecimiento->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Fecha_Actualizacion" class="dato_establecimiento_Fecha_Actualizacion">
<span<?php echo $dato_establecimiento->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$dato_establecimiento_list->ListOptions->Render("body", "right", $dato_establecimiento_list->RowCnt);
?>
	</tr>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD || $dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdato_establecimientolist.UpdateOpts(<?php echo $dato_establecimiento_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($dato_establecimiento->CurrentAction <> "gridadd")
		if (!$dato_establecimiento_list->Recordset->EOF) $dato_establecimiento_list->Recordset->MoveNext();
}
?>
<?php
	if ($dato_establecimiento->CurrentAction == "gridadd" || $dato_establecimiento->CurrentAction == "gridedit") {
		$dato_establecimiento_list->RowIndex = '$rowindex$';
		$dato_establecimiento_list->LoadDefaultValues();

		// Set row properties
		$dato_establecimiento->ResetAttrs();
		$dato_establecimiento->RowAttrs = array_merge($dato_establecimiento->RowAttrs, array('data-rowindex'=>$dato_establecimiento_list->RowIndex, 'id'=>'r0_dato_establecimiento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($dato_establecimiento->RowAttrs["class"], "ewTemplate");
		$dato_establecimiento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$dato_establecimiento_list->RenderRow();

		// Render list options
		$dato_establecimiento_list->RenderListOptions();
		$dato_establecimiento_list->StartRowCnt = 0;
?>
	<tr<?php echo $dato_establecimiento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$dato_establecimiento_list->ListOptions->Render("body", "left", $dato_establecimiento_list->RowIndex);
?>
	<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
		<td data-name="Cue">
<span id="el$rowindex$_dato_establecimiento_Cue" class="form-group dato_establecimiento_Cue">
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cue" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento">
<span id="el$rowindex$_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento">
<span id="el$rowindex$_dato_establecimiento_Id_Departamento" class="form-group dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Departamento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Departamento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
		<td data-name="Id_Localidad">
<span id="el$rowindex$_dato_establecimiento_Id_Localidad" class="form-group dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Localidad" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Localidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio">
<span id="el$rowindex$_dato_establecimiento_Domicilio" class="form-group dato_establecimiento_Domicilio">
<input type="text" data-table="dato_establecimiento" data-field="x_Domicilio" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Domicilio->EditValue ?>"<?php echo $dato_establecimiento->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Domicilio" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
		<td data-name="Telefono_Escuela">
<span id="el$rowindex$_dato_establecimiento_Telefono_Escuela" class="form-group dato_establecimiento_Telefono_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Telefono_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Telefono_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Telefono_Escuela" value="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
		<td data-name="Mail_Escuela">
<span id="el$rowindex$_dato_establecimiento_Mail_Escuela" class="form-group dato_establecimiento_Mail_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Mail_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Mail_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Mail_Escuela" value="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
		<td data-name="Matricula_Actual">
<span id="el$rowindex$_dato_establecimiento_Matricula_Actual" class="form-group dato_establecimiento_Matricula_Actual">
<input type="text" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Matricula_Actual->EditValue ?>"<?php echo $dato_establecimiento->Matricula_Actual->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Matricula_Actual" value="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Usuario" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($dato_establecimiento->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Fecha_Actualizacion" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($dato_establecimiento->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$dato_establecimiento_list->ListOptions->Render("body", "right", $dato_establecimiento_list->RowCnt);
?>
<script type="text/javascript">
fdato_establecimientolist.UpdateOpts(<?php echo $dato_establecimiento_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($dato_establecimiento->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" id="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" value="<?php echo $dato_establecimiento_list->KeyCount ?>">
<?php echo $dato_establecimiento_list->MultiSelectKey ?>
<?php } ?>
<?php if ($dato_establecimiento->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" id="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" value="<?php echo $dato_establecimiento_list->KeyCount ?>">
<?php echo $dato_establecimiento_list->MultiSelectKey ?>
<?php } ?>
<?php if ($dato_establecimiento->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($dato_establecimiento_list->Recordset)
	$dato_establecimiento_list->Recordset->Close();
?>
<?php if ($dato_establecimiento->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($dato_establecimiento->CurrentAction <> "gridadd" && $dato_establecimiento->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($dato_establecimiento_list->Pager)) $dato_establecimiento_list->Pager = new cPrevNextPager($dato_establecimiento_list->StartRec, $dato_establecimiento_list->DisplayRecs, $dato_establecimiento_list->TotalRecs) ?>
<?php if ($dato_establecimiento_list->Pager->RecordCount > 0 && $dato_establecimiento_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($dato_establecimiento_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $dato_establecimiento_list->PageUrl() ?>start=<?php echo $dato_establecimiento_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($dato_establecimiento_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $dato_establecimiento_list->PageUrl() ?>start=<?php echo $dato_establecimiento_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dato_establecimiento_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($dato_establecimiento_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $dato_establecimiento_list->PageUrl() ?>start=<?php echo $dato_establecimiento_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($dato_establecimiento_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $dato_establecimiento_list->PageUrl() ?>start=<?php echo $dato_establecimiento_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $dato_establecimiento_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $dato_establecimiento_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $dato_establecimiento_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $dato_establecimiento_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dato_establecimiento_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($dato_establecimiento_list->TotalRecs == 0 && $dato_establecimiento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dato_establecimiento_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<script type="text/javascript">
fdato_establecimientolistsrch.FilterList = <?php echo $dato_establecimiento_list->GetFilterList() ?>;
fdato_establecimientolistsrch.Init();
fdato_establecimientolist.Init();
</script>
<?php } ?>
<?php
$dato_establecimiento_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($dato_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$dato_establecimiento_list->Page_Terminate();
?>
