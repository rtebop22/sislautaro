<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "estado_actual_legajo_personagridcls.php" ?>
<?php include_once "materias_adeudadasgridcls.php" ?>
<?php include_once "observacion_personagridcls.php" ?>
<?php include_once "equiposgridcls.php" ?>
<?php include_once "tutoresgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$personas_list = NULL; // Initialize page object first

class cpersonas_list extends cpersonas {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'personas';

	// Page object name
	var $PageObjName = 'personas_list';

	// Grid form hidden field names
	var $FormName = 'fpersonaslist';
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

		// Table object (personas)
		if (!isset($GLOBALS["personas"]) || get_class($GLOBALS["personas"]) == "cpersonas") {
			$GLOBALS["personas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personas"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "personasadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "personasdelete.php";
		$this->MultiUpdateUrl = "personasupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personas', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpersonaslistsrch";

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
		$this->Foto->SetVisibility();
		$this->Apellidos_Nombres->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Id_Cargo->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Curso->SetVisibility();
		$this->Id_Division->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->NroSerie->SetVisibility();
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

			// Process auto fill for detail table 'estado_actual_legajo_persona'
			if (@$_POST["grid"] == "festado_actual_legajo_personagrid") {
				if (!isset($GLOBALS["estado_actual_legajo_persona_grid"])) $GLOBALS["estado_actual_legajo_persona_grid"] = new cestado_actual_legajo_persona_grid;
				$GLOBALS["estado_actual_legajo_persona_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'materias_adeudadas'
			if (@$_POST["grid"] == "fmaterias_adeudadasgrid") {
				if (!isset($GLOBALS["materias_adeudadas_grid"])) $GLOBALS["materias_adeudadas_grid"] = new cmaterias_adeudadas_grid;
				$GLOBALS["materias_adeudadas_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'observacion_persona'
			if (@$_POST["grid"] == "fobservacion_personagrid") {
				if (!isset($GLOBALS["observacion_persona_grid"])) $GLOBALS["observacion_persona_grid"] = new cobservacion_persona_grid;
				$GLOBALS["observacion_persona_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'equipos'
			if (@$_POST["grid"] == "fequiposgrid") {
				if (!isset($GLOBALS["equipos_grid"])) $GLOBALS["equipos_grid"] = new cequipos_grid;
				$GLOBALS["equipos_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'tutores'
			if (@$_POST["grid"] == "ftutoresgrid") {
				if (!isset($GLOBALS["tutores_grid"])) $GLOBALS["tutores_grid"] = new ctutores_grid;
				$GLOBALS["tutores_grid"]->Page_Init();
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
		global $EW_EXPORT, $personas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($personas);
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
	var $estado_actual_legajo_persona_Count;
	var $materias_adeudadas_Count;
	var $observacion_persona_Count;
	var $equipos_Count;
	var $tutores_Count;
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
		$this->setKey("Dni", ""); // Clear inline edit key
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
		if (@$_GET["Dni"] <> "") {
			$this->Dni->setQueryStringValue($_GET["Dni"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Dni", $this->Dni->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Dni")) <> strval($this->Dni->CurrentValue))
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
			$this->Dni->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Dni->FormValue))
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
					$sKey .= $this->Dni->CurrentValue;

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
		if (!ew_Empty($this->Foto->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_Apellidos_Nombres") && $objForm->HasValue("o_Apellidos_Nombres") && $this->Apellidos_Nombres->CurrentValue <> $this->Apellidos_Nombres->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Dni") && $objForm->HasValue("o_Dni") && $this->Dni->CurrentValue <> $this->Dni->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Cargo") && $objForm->HasValue("o_Id_Cargo") && $this->Id_Cargo->CurrentValue <> $this->Id_Cargo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Estado") && $objForm->HasValue("o_Id_Estado") && $this->Id_Estado->CurrentValue <> $this->Id_Estado->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Curso") && $objForm->HasValue("o_Id_Curso") && $this->Id_Curso->CurrentValue <> $this->Id_Curso->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Division") && $objForm->HasValue("o_Id_Division") && $this->Id_Division->CurrentValue <> $this->Id_Division->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Turno") && $objForm->HasValue("o_Id_Turno") && $this->Id_Turno->CurrentValue <> $this->Id_Turno->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Dni_Tutor") && $objForm->HasValue("o_Dni_Tutor") && $this->Dni_Tutor->CurrentValue <> $this->Dni_Tutor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NroSerie") && $objForm->HasValue("o_NroSerie") && $this->NroSerie->CurrentValue <> $this->NroSerie->OldValue)
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpersonaslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Foto->AdvancedSearch->ToJSON(), ","); // Field Foto
		$sFilterList = ew_Concat($sFilterList, $this->Apellidos_Nombres->AdvancedSearch->ToJSON(), ","); // Field Apellidos_Nombres
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
		$sFilterList = ew_Concat($sFilterList, $this->Cuil->AdvancedSearch->ToJSON(), ","); // Field Cuil
		$sFilterList = ew_Concat($sFilterList, $this->Edad->AdvancedSearch->ToJSON(), ","); // Field Edad
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Tel_Contacto->AdvancedSearch->ToJSON(), ","); // Field Tel_Contacto
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Nac->AdvancedSearch->ToJSON(), ","); // Field Fecha_Nac
		$sFilterList = ew_Concat($sFilterList, $this->Lugar_Nacimiento->AdvancedSearch->ToJSON(), ","); // Field Lugar_Nacimiento
		$sFilterList = ew_Concat($sFilterList, $this->Cod_Postal->AdvancedSearch->ToJSON(), ","); // Field Cod_Postal
		$sFilterList = ew_Concat($sFilterList, $this->Repitente->AdvancedSearch->ToJSON(), ","); // Field Repitente
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Civil->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Civil
		$sFilterList = ew_Concat($sFilterList, $this->Id_Provincia->AdvancedSearch->ToJSON(), ","); // Field Id_Provincia
		$sFilterList = ew_Concat($sFilterList, $this->Id_Departamento->AdvancedSearch->ToJSON(), ","); // Field Id_Departamento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Localidad->AdvancedSearch->ToJSON(), ","); // Field Id_Localidad
		$sFilterList = ew_Concat($sFilterList, $this->Id_Sexo->AdvancedSearch->ToJSON(), ","); // Field Id_Sexo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Cargo->AdvancedSearch->ToJSON(), ","); // Field Id_Cargo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado->AdvancedSearch->ToJSON(), ","); // Field Id_Estado
		$sFilterList = ew_Concat($sFilterList, $this->Id_Curso->AdvancedSearch->ToJSON(), ","); // Field Id_Curso
		$sFilterList = ew_Concat($sFilterList, $this->Id_Division->AdvancedSearch->ToJSON(), ","); // Field Id_Division
		$sFilterList = ew_Concat($sFilterList, $this->Id_Turno->AdvancedSearch->ToJSON(), ","); // Field Id_Turno
		$sFilterList = ew_Concat($sFilterList, $this->Dni_Tutor->AdvancedSearch->ToJSON(), ","); // Field Dni_Tutor
		$sFilterList = ew_Concat($sFilterList, $this->NroSerie->AdvancedSearch->ToJSON(), ","); // Field NroSerie
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpersonaslistsrch", $filters);
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

		// Field Foto
		$this->Foto->AdvancedSearch->SearchValue = @$filter["x_Foto"];
		$this->Foto->AdvancedSearch->SearchOperator = @$filter["z_Foto"];
		$this->Foto->AdvancedSearch->SearchCondition = @$filter["v_Foto"];
		$this->Foto->AdvancedSearch->SearchValue2 = @$filter["y_Foto"];
		$this->Foto->AdvancedSearch->SearchOperator2 = @$filter["w_Foto"];
		$this->Foto->AdvancedSearch->Save();

		// Field Apellidos_Nombres
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = @$filter["x_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = @$filter["z_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchCondition = @$filter["v_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue2 = @$filter["y_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator2 = @$filter["w_Apellidos_Nombres"];
		$this->Apellidos_Nombres->AdvancedSearch->Save();

		// Field Dni
		$this->Dni->AdvancedSearch->SearchValue = @$filter["x_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator = @$filter["z_Dni"];
		$this->Dni->AdvancedSearch->SearchCondition = @$filter["v_Dni"];
		$this->Dni->AdvancedSearch->SearchValue2 = @$filter["y_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator2 = @$filter["w_Dni"];
		$this->Dni->AdvancedSearch->Save();

		// Field Cuil
		$this->Cuil->AdvancedSearch->SearchValue = @$filter["x_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator = @$filter["z_Cuil"];
		$this->Cuil->AdvancedSearch->SearchCondition = @$filter["v_Cuil"];
		$this->Cuil->AdvancedSearch->SearchValue2 = @$filter["y_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil"];
		$this->Cuil->AdvancedSearch->Save();

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

		// Field Lugar_Nacimiento
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue = @$filter["x_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator = @$filter["z_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchCondition = @$filter["v_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue2 = @$filter["y_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator2 = @$filter["w_Lugar_Nacimiento"];
		$this->Lugar_Nacimiento->AdvancedSearch->Save();

		// Field Cod_Postal
		$this->Cod_Postal->AdvancedSearch->SearchValue = @$filter["x_Cod_Postal"];
		$this->Cod_Postal->AdvancedSearch->SearchOperator = @$filter["z_Cod_Postal"];
		$this->Cod_Postal->AdvancedSearch->SearchCondition = @$filter["v_Cod_Postal"];
		$this->Cod_Postal->AdvancedSearch->SearchValue2 = @$filter["y_Cod_Postal"];
		$this->Cod_Postal->AdvancedSearch->SearchOperator2 = @$filter["w_Cod_Postal"];
		$this->Cod_Postal->AdvancedSearch->Save();

		// Field Repitente
		$this->Repitente->AdvancedSearch->SearchValue = @$filter["x_Repitente"];
		$this->Repitente->AdvancedSearch->SearchOperator = @$filter["z_Repitente"];
		$this->Repitente->AdvancedSearch->SearchCondition = @$filter["v_Repitente"];
		$this->Repitente->AdvancedSearch->SearchValue2 = @$filter["y_Repitente"];
		$this->Repitente->AdvancedSearch->SearchOperator2 = @$filter["w_Repitente"];
		$this->Repitente->AdvancedSearch->Save();

		// Field Id_Estado_Civil
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue = @$filter["x_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado_Civil"];
		$this->Id_Estado_Civil->AdvancedSearch->Save();

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

		// Field Id_Sexo
		$this->Id_Sexo->AdvancedSearch->SearchValue = @$filter["x_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchOperator = @$filter["z_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchCondition = @$filter["v_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Sexo"];
		$this->Id_Sexo->AdvancedSearch->Save();

		// Field Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = @$filter["x_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$filter["z_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchCondition = @$filter["v_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->Save();

		// Field Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = @$filter["x_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->Save();

		// Field Id_Curso
		$this->Id_Curso->AdvancedSearch->SearchValue = @$filter["x_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchOperator = @$filter["z_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchCondition = @$filter["v_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchValue2 = @$filter["y_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->Save();

		// Field Id_Division
		$this->Id_Division->AdvancedSearch->SearchValue = @$filter["x_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchOperator = @$filter["z_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchCondition = @$filter["v_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchValue2 = @$filter["y_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Division"];
		$this->Id_Division->AdvancedSearch->Save();

		// Field Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = @$filter["x_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$filter["z_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchCondition = @$filter["v_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchValue2 = @$filter["y_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->Save();

		// Field Dni_Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = @$filter["x_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$filter["z_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchCondition = @$filter["v_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchValue2 = @$filter["y_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator2 = @$filter["w_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->Save();

		// Field NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = @$filter["x_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator = @$filter["z_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchCondition = @$filter["v_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchValue2 = @$filter["y_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator2 = @$filter["w_NroSerie"];
		$this->NroSerie->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Foto, $Default, FALSE); // Foto
		$this->BuildSearchSql($sWhere, $this->Apellidos_Nombres, $Default, FALSE); // Apellidos_Nombres
		$this->BuildSearchSql($sWhere, $this->Dni, $Default, FALSE); // Dni
		$this->BuildSearchSql($sWhere, $this->Cuil, $Default, FALSE); // Cuil
		$this->BuildSearchSql($sWhere, $this->Edad, $Default, FALSE); // Edad
		$this->BuildSearchSql($sWhere, $this->Domicilio, $Default, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Tel_Contacto, $Default, FALSE); // Tel_Contacto
		$this->BuildSearchSql($sWhere, $this->Fecha_Nac, $Default, FALSE); // Fecha_Nac
		$this->BuildSearchSql($sWhere, $this->Lugar_Nacimiento, $Default, FALSE); // Lugar_Nacimiento
		$this->BuildSearchSql($sWhere, $this->Cod_Postal, $Default, FALSE); // Cod_Postal
		$this->BuildSearchSql($sWhere, $this->Repitente, $Default, FALSE); // Repitente
		$this->BuildSearchSql($sWhere, $this->Id_Estado_Civil, $Default, FALSE); // Id_Estado_Civil
		$this->BuildSearchSql($sWhere, $this->Id_Provincia, $Default, FALSE); // Id_Provincia
		$this->BuildSearchSql($sWhere, $this->Id_Departamento, $Default, FALSE); // Id_Departamento
		$this->BuildSearchSql($sWhere, $this->Id_Localidad, $Default, FALSE); // Id_Localidad
		$this->BuildSearchSql($sWhere, $this->Id_Sexo, $Default, FALSE); // Id_Sexo
		$this->BuildSearchSql($sWhere, $this->Id_Cargo, $Default, FALSE); // Id_Cargo
		$this->BuildSearchSql($sWhere, $this->Id_Estado, $Default, FALSE); // Id_Estado
		$this->BuildSearchSql($sWhere, $this->Id_Curso, $Default, FALSE); // Id_Curso
		$this->BuildSearchSql($sWhere, $this->Id_Division, $Default, FALSE); // Id_Division
		$this->BuildSearchSql($sWhere, $this->Id_Turno, $Default, FALSE); // Id_Turno
		$this->BuildSearchSql($sWhere, $this->Dni_Tutor, $Default, FALSE); // Dni_Tutor
		$this->BuildSearchSql($sWhere, $this->NroSerie, $Default, FALSE); // NroSerie
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Foto->AdvancedSearch->Save(); // Foto
			$this->Apellidos_Nombres->AdvancedSearch->Save(); // Apellidos_Nombres
			$this->Dni->AdvancedSearch->Save(); // Dni
			$this->Cuil->AdvancedSearch->Save(); // Cuil
			$this->Edad->AdvancedSearch->Save(); // Edad
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Tel_Contacto->AdvancedSearch->Save(); // Tel_Contacto
			$this->Fecha_Nac->AdvancedSearch->Save(); // Fecha_Nac
			$this->Lugar_Nacimiento->AdvancedSearch->Save(); // Lugar_Nacimiento
			$this->Cod_Postal->AdvancedSearch->Save(); // Cod_Postal
			$this->Repitente->AdvancedSearch->Save(); // Repitente
			$this->Id_Estado_Civil->AdvancedSearch->Save(); // Id_Estado_Civil
			$this->Id_Provincia->AdvancedSearch->Save(); // Id_Provincia
			$this->Id_Departamento->AdvancedSearch->Save(); // Id_Departamento
			$this->Id_Localidad->AdvancedSearch->Save(); // Id_Localidad
			$this->Id_Sexo->AdvancedSearch->Save(); // Id_Sexo
			$this->Id_Cargo->AdvancedSearch->Save(); // Id_Cargo
			$this->Id_Estado->AdvancedSearch->Save(); // Id_Estado
			$this->Id_Curso->AdvancedSearch->Save(); // Id_Curso
			$this->Id_Division->AdvancedSearch->Save(); // Id_Division
			$this->Id_Turno->AdvancedSearch->Save(); // Id_Turno
			$this->Dni_Tutor->AdvancedSearch->Save(); // Dni_Tutor
			$this->NroSerie->AdvancedSearch->Save(); // NroSerie
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
		$this->BuildBasicSearchSQL($sWhere, $this->Foto, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Apellidos_Nombres, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Repitente, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Localidad, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Sexo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Cargo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Estado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Curso, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Division, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Turno, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni_Tutor, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NroSerie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Usuario, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Fecha_Actualizacion, $arKeywords, $type);
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
		if ($this->Foto->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Apellidos_Nombres->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Edad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Domicilio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tel_Contacto->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Nac->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Lugar_Nacimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cod_Postal->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Repitente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado_Civil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Provincia->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Departamento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Localidad->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Sexo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Cargo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Curso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Division->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Turno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni_Tutor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NroSerie->AdvancedSearch->IssetSession())
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
		$this->Foto->AdvancedSearch->UnsetSession();
		$this->Apellidos_Nombres->AdvancedSearch->UnsetSession();
		$this->Dni->AdvancedSearch->UnsetSession();
		$this->Cuil->AdvancedSearch->UnsetSession();
		$this->Edad->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Tel_Contacto->AdvancedSearch->UnsetSession();
		$this->Fecha_Nac->AdvancedSearch->UnsetSession();
		$this->Lugar_Nacimiento->AdvancedSearch->UnsetSession();
		$this->Cod_Postal->AdvancedSearch->UnsetSession();
		$this->Repitente->AdvancedSearch->UnsetSession();
		$this->Id_Estado_Civil->AdvancedSearch->UnsetSession();
		$this->Id_Provincia->AdvancedSearch->UnsetSession();
		$this->Id_Departamento->AdvancedSearch->UnsetSession();
		$this->Id_Localidad->AdvancedSearch->UnsetSession();
		$this->Id_Sexo->AdvancedSearch->UnsetSession();
		$this->Id_Cargo->AdvancedSearch->UnsetSession();
		$this->Id_Estado->AdvancedSearch->UnsetSession();
		$this->Id_Curso->AdvancedSearch->UnsetSession();
		$this->Id_Division->AdvancedSearch->UnsetSession();
		$this->Id_Turno->AdvancedSearch->UnsetSession();
		$this->Dni_Tutor->AdvancedSearch->UnsetSession();
		$this->NroSerie->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Foto->AdvancedSearch->Load();
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Contacto->AdvancedSearch->Load();
		$this->Fecha_Nac->AdvancedSearch->Load();
		$this->Lugar_Nacimiento->AdvancedSearch->Load();
		$this->Cod_Postal->AdvancedSearch->Load();
		$this->Repitente->AdvancedSearch->Load();
		$this->Id_Estado_Civil->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Id_Sexo->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Id_Curso->AdvancedSearch->Load();
		$this->Id_Division->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Foto); // Foto
			$this->UpdateSort($this->Apellidos_Nombres); // Apellidos_Nombres
			$this->UpdateSort($this->Dni); // Dni
			$this->UpdateSort($this->Id_Cargo); // Id_Cargo
			$this->UpdateSort($this->Id_Estado); // Id_Estado
			$this->UpdateSort($this->Id_Curso); // Id_Curso
			$this->UpdateSort($this->Id_Division); // Id_Division
			$this->UpdateSort($this->Id_Turno); // Id_Turno
			$this->UpdateSort($this->Dni_Tutor); // Dni_Tutor
			$this->UpdateSort($this->NroSerie); // NroSerie
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
				$this->Id_Curso->setSort("ASC");
				$this->Id_Division->setSort("ASC");
				$this->Apellidos_Nombres->setSort("ASC");
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
				$this->Foto->setSort("");
				$this->Apellidos_Nombres->setSort("");
				$this->Dni->setSort("");
				$this->Id_Cargo->setSort("");
				$this->Id_Estado->setSort("");
				$this->Id_Curso->setSort("");
				$this->Id_Division->setSort("");
				$this->Id_Turno->setSort("");
				$this->Dni_Tutor->setSort("");
				$this->NroSerie->setSort("");
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

		// "detail_estado_actual_legajo_persona"
		$item = &$this->ListOptions->Add("detail_estado_actual_legajo_persona");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'estado_actual_legajo_persona') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["estado_actual_legajo_persona_grid"])) $GLOBALS["estado_actual_legajo_persona_grid"] = new cestado_actual_legajo_persona_grid;

		// "detail_materias_adeudadas"
		$item = &$this->ListOptions->Add("detail_materias_adeudadas");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'materias_adeudadas') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["materias_adeudadas_grid"])) $GLOBALS["materias_adeudadas_grid"] = new cmaterias_adeudadas_grid;

		// "detail_observacion_persona"
		$item = &$this->ListOptions->Add("detail_observacion_persona");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'observacion_persona') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["observacion_persona_grid"])) $GLOBALS["observacion_persona_grid"] = new cobservacion_persona_grid;

		// "detail_equipos"
		$item = &$this->ListOptions->Add("detail_equipos");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'equipos') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["equipos_grid"])) $GLOBALS["equipos_grid"] = new cequipos_grid;

		// "detail_tutores"
		$item = &$this->ListOptions->Add("detail_tutores");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tutores') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["tutores_grid"])) $GLOBALS["tutores_grid"] = new ctutores_grid;

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
		$pages->Add("estado_actual_legajo_persona");
		$pages->Add("materias_adeudadas");
		$pages->Add("observacion_persona");
		$pages->Add("equipos");
		$pages->Add("tutores");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Dni->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"personas\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"personas\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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

		// "detail_estado_actual_legajo_persona"
		$oListOpt = &$this->ListOptions->Items["detail_estado_actual_legajo_persona"];
		if ($Security->AllowList(CurrentProjectID() . 'estado_actual_legajo_persona')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("estado_actual_legajo_persona", "TblCaption");
			$body .= str_replace("%c", $this->estado_actual_legajo_persona_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("estado_actual_legajo_personalist.php?" . EW_TABLE_SHOW_MASTER . "=personas&fk_Dni=" . urlencode(strval($this->Dni->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["estado_actual_legajo_persona_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'estado_actual_legajo_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=estado_actual_legajo_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "estado_actual_legajo_persona";
			}
			if ($GLOBALS["estado_actual_legajo_persona_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'estado_actual_legajo_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=estado_actual_legajo_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "estado_actual_legajo_persona";
			}
			if ($GLOBALS["estado_actual_legajo_persona_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'estado_actual_legajo_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=estado_actual_legajo_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "estado_actual_legajo_persona";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_materias_adeudadas"
		$oListOpt = &$this->ListOptions->Items["detail_materias_adeudadas"];
		if ($Security->AllowList(CurrentProjectID() . 'materias_adeudadas')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("materias_adeudadas", "TblCaption");
			$body .= str_replace("%c", $this->materias_adeudadas_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("materias_adeudadaslist.php?" . EW_TABLE_SHOW_MASTER . "=personas&fk_Dni=" . urlencode(strval($this->Dni->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["materias_adeudadas_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'materias_adeudadas')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=materias_adeudadas")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "materias_adeudadas";
			}
			if ($GLOBALS["materias_adeudadas_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'materias_adeudadas')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=materias_adeudadas")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "materias_adeudadas";
			}
			if ($GLOBALS["materias_adeudadas_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'materias_adeudadas')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=materias_adeudadas")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "materias_adeudadas";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_observacion_persona"
		$oListOpt = &$this->ListOptions->Items["detail_observacion_persona"];
		if ($Security->AllowList(CurrentProjectID() . 'observacion_persona')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("observacion_persona", "TblCaption");
			$body .= str_replace("%c", $this->observacion_persona_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("observacion_personalist.php?" . EW_TABLE_SHOW_MASTER . "=personas&fk_Dni=" . urlencode(strval($this->Dni->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["observacion_persona_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'observacion_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=observacion_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "observacion_persona";
			}
			if ($GLOBALS["observacion_persona_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'observacion_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=observacion_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "observacion_persona";
			}
			if ($GLOBALS["observacion_persona_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'observacion_persona')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=observacion_persona")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "observacion_persona";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_equipos"
		$oListOpt = &$this->ListOptions->Items["detail_equipos"];
		if ($Security->AllowList(CurrentProjectID() . 'equipos')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("equipos", "TblCaption");
			$body .= str_replace("%c", $this->equipos_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("equiposlist.php?" . EW_TABLE_SHOW_MASTER . "=personas&fk_NroSerie=" . urlencode(strval($this->NroSerie->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["equipos_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'equipos')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=equipos")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "equipos";
			}
			if ($GLOBALS["equipos_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'equipos')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=equipos")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "equipos";
			}
			if ($GLOBALS["equipos_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'equipos')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=equipos")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "equipos";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_tutores"
		$oListOpt = &$this->ListOptions->Items["detail_tutores"];
		if ($Security->AllowList(CurrentProjectID() . 'tutores')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("tutores", "TblCaption");
			$body .= str_replace("%c", $this->tutores_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("tutoreslist.php?" . EW_TABLE_SHOW_MASTER . "=personas&fk_Dni_Tutor=" . urlencode(strval($this->Dni_Tutor->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["tutores_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'tutores')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tutores")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "tutores";
			}
			if ($GLOBALS["tutores_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'tutores')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tutores")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "tutores";
			}
			if ($GLOBALS["tutores_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'tutores')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=tutores")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "tutores";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Dni->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Dni->CurrentValue . "\">";
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
		$item = &$option->Add("detailadd_estado_actual_legajo_persona");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=estado_actual_legajo_persona");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["estado_actual_legajo_persona"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["estado_actual_legajo_persona"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'estado_actual_legajo_persona') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "estado_actual_legajo_persona";
		}
		$item = &$option->Add("detailadd_materias_adeudadas");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=materias_adeudadas");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["materias_adeudadas"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["materias_adeudadas"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'materias_adeudadas') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "materias_adeudadas";
		}
		$item = &$option->Add("detailadd_observacion_persona");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=observacion_persona");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["observacion_persona"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["observacion_persona"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'observacion_persona') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "observacion_persona";
		}
		$item = &$option->Add("detailadd_equipos");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=equipos");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["equipos"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["equipos"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'equipos') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "equipos";
		}
		$item = &$option->Add("detailadd_tutores");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=tutores");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["tutores"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["tutores"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'tutores') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tutores";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fpersonaslist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"personas\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fpersonaslist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpersonaslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpersonaslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpersonaslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpersonaslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"personassrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->Foto->Upload->Index = $objForm->Index;
		$this->Foto->Upload->UploadFile();
		$this->Foto->CurrentValue = $this->Foto->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Foto->Upload->DbValue = NULL;
		$this->Foto->OldValue = $this->Foto->Upload->DbValue;
		$this->Apellidos_Nombres->CurrentValue = NULL;
		$this->Apellidos_Nombres->OldValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Dni->CurrentValue = NULL;
		$this->Dni->OldValue = $this->Dni->CurrentValue;
		$this->Id_Cargo->CurrentValue = 1;
		$this->Id_Cargo->OldValue = $this->Id_Cargo->CurrentValue;
		$this->Id_Estado->CurrentValue = 1;
		$this->Id_Estado->OldValue = $this->Id_Estado->CurrentValue;
		$this->Id_Curso->CurrentValue = NULL;
		$this->Id_Curso->OldValue = $this->Id_Curso->CurrentValue;
		$this->Id_Division->CurrentValue = NULL;
		$this->Id_Division->OldValue = $this->Id_Division->CurrentValue;
		$this->Id_Turno->CurrentValue = NULL;
		$this->Id_Turno->OldValue = $this->Id_Turno->CurrentValue;
		$this->Dni_Tutor->CurrentValue = 0;
		$this->Dni_Tutor->OldValue = $this->Dni_Tutor->CurrentValue;
		$this->NroSerie->CurrentValue = 0;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
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
		// Foto

		$this->Foto->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Foto"]);
		if ($this->Foto->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Foto->AdvancedSearch->SearchOperator = @$_GET["z_Foto"];

		// Apellidos_Nombres
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellidos_Nombres"]);
		if ($this->Apellidos_Nombres->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = @$_GET["z_Apellidos_Nombres"];

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni"]);
		if ($this->Dni->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni->AdvancedSearch->SearchOperator = @$_GET["z_Dni"];

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil"]);
		if ($this->Cuil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil->AdvancedSearch->SearchOperator = @$_GET["z_Cuil"];

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

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Lugar_Nacimiento"]);
		if ($this->Lugar_Nacimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator = @$_GET["z_Lugar_Nacimiento"];

		// Cod_Postal
		$this->Cod_Postal->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cod_Postal"]);
		if ($this->Cod_Postal->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cod_Postal->AdvancedSearch->SearchOperator = @$_GET["z_Cod_Postal"];

		// Repitente
		$this->Repitente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Repitente"]);
		if ($this->Repitente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Repitente->AdvancedSearch->SearchOperator = @$_GET["z_Repitente"];

		// Id_Estado_Civil
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado_Civil"]);
		if ($this->Id_Estado_Civil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado_Civil"];

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

		// Id_Sexo
		$this->Id_Sexo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Sexo"]);
		if ($this->Id_Sexo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Sexo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Sexo"];

		// Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cargo"]);
		if ($this->Id_Cargo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cargo"];

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado"]);
		if ($this->Id_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado"];

		// Id_Curso
		$this->Id_Curso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Curso"]);
		if ($this->Id_Curso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Curso->AdvancedSearch->SearchOperator = @$_GET["z_Id_Curso"];

		// Id_Division
		$this->Id_Division->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Division"]);
		if ($this->Id_Division->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Division->AdvancedSearch->SearchOperator = @$_GET["z_Id_Division"];

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Turno"]);
		if ($this->Id_Turno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$_GET["z_Id_Turno"];

		// Dni_Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni_Tutor"]);
		if ($this->Dni_Tutor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$_GET["z_Dni_Tutor"];

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroSerie"]);
		if ($this->NroSerie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroSerie->AdvancedSearch->SearchOperator = @$_GET["z_NroSerie"];

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
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Apellidos_Nombres->FldIsDetailKey) {
			$this->Apellidos_Nombres->setFormValue($objForm->GetValue("x_Apellidos_Nombres"));
		}
		$this->Apellidos_Nombres->setOldValue($objForm->GetValue("o_Apellidos_Nombres"));
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->setOldValue($objForm->GetValue("o_Dni"));
		if (!$this->Id_Cargo->FldIsDetailKey) {
			$this->Id_Cargo->setFormValue($objForm->GetValue("x_Id_Cargo"));
		}
		$this->Id_Cargo->setOldValue($objForm->GetValue("o_Id_Cargo"));
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		$this->Id_Estado->setOldValue($objForm->GetValue("o_Id_Estado"));
		if (!$this->Id_Curso->FldIsDetailKey) {
			$this->Id_Curso->setFormValue($objForm->GetValue("x_Id_Curso"));
		}
		$this->Id_Curso->setOldValue($objForm->GetValue("o_Id_Curso"));
		if (!$this->Id_Division->FldIsDetailKey) {
			$this->Id_Division->setFormValue($objForm->GetValue("x_Id_Division"));
		}
		$this->Id_Division->setOldValue($objForm->GetValue("o_Id_Division"));
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
		}
		$this->Id_Turno->setOldValue($objForm->GetValue("o_Id_Turno"));
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		$this->Dni_Tutor->setOldValue($objForm->GetValue("o_Dni_Tutor"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->setOldValue($objForm->GetValue("o_NroSerie"));
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
		$this->Apellidos_Nombres->CurrentValue = $this->Apellidos_Nombres->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Id_Cargo->CurrentValue = $this->Id_Cargo->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Id_Curso->CurrentValue = $this->Id_Curso->FormValue;
		$this->Id_Division->CurrentValue = $this->Id_Division->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
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
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
		$this->Foto->CurrentValue = $this->Foto->Upload->DbValue;
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Edad->setDbValue($rs->fields('Edad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Contacto->setDbValue($rs->fields('Tel_Contacto'));
		$this->Fecha_Nac->setDbValue($rs->fields('Fecha_Nac'));
		$this->Lugar_Nacimiento->setDbValue($rs->fields('Lugar_Nacimiento'));
		$this->Cod_Postal->setDbValue($rs->fields('Cod_Postal'));
		$this->Repitente->setDbValue($rs->fields('Repitente'));
		$this->Id_Estado_Civil->setDbValue($rs->fields('Id_Estado_Civil'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Id_Sexo->setDbValue($rs->fields('Id_Sexo'));
		$this->Id_Cargo->setDbValue($rs->fields('Id_Cargo'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Curso->setDbValue($rs->fields('Id_Curso'));
		$this->Id_Division->setDbValue($rs->fields('Id_Division'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		if (!isset($GLOBALS["estado_actual_legajo_persona_grid"])) $GLOBALS["estado_actual_legajo_persona_grid"] = new cestado_actual_legajo_persona_grid;
		$sDetailFilter = $GLOBALS["estado_actual_legajo_persona"]->SqlDetailFilter_personas();
		$sDetailFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["estado_actual_legajo_persona"]->setCurrentMasterTable("personas");
		$sDetailFilter = $GLOBALS["estado_actual_legajo_persona"]->ApplyUserIDFilters($sDetailFilter);
		$this->estado_actual_legajo_persona_Count = $GLOBALS["estado_actual_legajo_persona"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["materias_adeudadas_grid"])) $GLOBALS["materias_adeudadas_grid"] = new cmaterias_adeudadas_grid;
		$sDetailFilter = $GLOBALS["materias_adeudadas"]->SqlDetailFilter_personas();
		$sDetailFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["materias_adeudadas"]->setCurrentMasterTable("personas");
		$sDetailFilter = $GLOBALS["materias_adeudadas"]->ApplyUserIDFilters($sDetailFilter);
		$this->materias_adeudadas_Count = $GLOBALS["materias_adeudadas"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["observacion_persona_grid"])) $GLOBALS["observacion_persona_grid"] = new cobservacion_persona_grid;
		$sDetailFilter = $GLOBALS["observacion_persona"]->SqlDetailFilter_personas();
		$sDetailFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["observacion_persona"]->setCurrentMasterTable("personas");
		$sDetailFilter = $GLOBALS["observacion_persona"]->ApplyUserIDFilters($sDetailFilter);
		$this->observacion_persona_Count = $GLOBALS["observacion_persona"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["equipos_grid"])) $GLOBALS["equipos_grid"] = new cequipos_grid;
		$sDetailFilter = $GLOBALS["equipos"]->SqlDetailFilter_personas();
		$sDetailFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["equipos"]->setCurrentMasterTable("personas");
		$sDetailFilter = $GLOBALS["equipos"]->ApplyUserIDFilters($sDetailFilter);
		$this->equipos_Count = $GLOBALS["equipos"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["tutores_grid"])) $GLOBALS["tutores_grid"] = new ctutores_grid;
		$sDetailFilter = $GLOBALS["tutores"]->SqlDetailFilter_personas();
		$sDetailFilter = str_replace("@Dni_Tutor@", ew_AdjustSql($this->Dni_Tutor->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["tutores"]->setCurrentMasterTable("personas");
		$sDetailFilter = $GLOBALS["tutores"]->ApplyUserIDFilters($sDetailFilter);
		$this->tutores_Count = $GLOBALS["tutores"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Foto->Upload->DbValue = $row['Foto'];
		$this->Apellidos_Nombres->DbValue = $row['Apellidos_Nombres'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->Edad->DbValue = $row['Edad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Tel_Contacto->DbValue = $row['Tel_Contacto'];
		$this->Fecha_Nac->DbValue = $row['Fecha_Nac'];
		$this->Lugar_Nacimiento->DbValue = $row['Lugar_Nacimiento'];
		$this->Cod_Postal->DbValue = $row['Cod_Postal'];
		$this->Repitente->DbValue = $row['Repitente'];
		$this->Id_Estado_Civil->DbValue = $row['Id_Estado_Civil'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Id_Sexo->DbValue = $row['Id_Sexo'];
		$this->Id_Cargo->DbValue = $row['Id_Cargo'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Curso->DbValue = $row['Id_Curso'];
		$this->Id_Division->DbValue = $row['Id_Division'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Dni")) <> "")
			$this->Dni->CurrentValue = $this->getKey("Dni"); // Dni
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
		// Foto
		// Apellidos_Nombres
		// Dni
		// Cuil
		// Edad
		// Domicilio
		// Tel_Contacto
		// Fecha_Nac
		// Lugar_Nacimiento
		// Cod_Postal
		// Repitente
		// Id_Estado_Civil
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Id_Sexo
		// Id_Cargo
		// Id_Estado
		// Id_Curso
		// Id_Division
		// Id_Turno
		// Dni_Tutor
		// NroSerie
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Foto
		$this->Foto->UploadPath = 'FotosPersonas';
		if (!ew_Empty($this->Foto->Upload->DbValue)) {
			$this->Foto->ImageWidth = 100;
			$this->Foto->ImageHeight = 100;
			$this->Foto->ImageAlt = $this->Foto->FldAlt();
			$this->Foto->ViewValue = $this->Foto->Upload->DbValue;
		} else {
			$this->Foto->ViewValue = "";
		}
		$this->Foto->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

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

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->ViewValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->ViewCustomAttributes = "";

		// Cod_Postal
		$this->Cod_Postal->ViewValue = $this->Cod_Postal->CurrentValue;
		$this->Cod_Postal->ViewCustomAttributes = "";

		// Repitente
		if (strval($this->Repitente->CurrentValue) <> "") {
			$this->Repitente->ViewValue = $this->Repitente->OptionCaption($this->Repitente->CurrentValue);
		} else {
			$this->Repitente->ViewValue = NULL;
		}
		$this->Repitente->ViewCustomAttributes = "";

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

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
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

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Id_Curso
		if (strval($this->Id_Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Id_Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Curso->ViewValue = $this->Id_Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Curso->ViewValue = $this->Id_Curso->CurrentValue;
			}
		} else {
			$this->Id_Curso->ViewValue = NULL;
		}
		$this->Id_Curso->ViewCustomAttributes = "";

		// Id_Division
		if (strval($this->Id_Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Id_Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Division->ViewValue = $this->Id_Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Division->ViewValue = $this->Id_Division->CurrentValue;
			}
		} else {
			$this->Id_Division->ViewValue = NULL;
		}
		$this->Id_Division->ViewCustomAttributes = "";

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

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		if (strval($this->Dni_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			}
		} else {
			$this->Dni_Tutor->ViewValue = NULL;
		}
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			}
		} else {
			$this->NroSerie->ViewValue = NULL;
		}
		$this->NroSerie->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Foto
			$this->Foto->LinkCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->HrefValue = ew_GetFileUploadUrl($this->Foto, $this->Foto->Upload->DbValue); // Add prefix/suffix
				$this->Foto->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
			} else {
				$this->Foto->HrefValue = "";
			}
			$this->Foto->HrefValue2 = $this->Foto->UploadPath . $this->Foto->Upload->DbValue;
			$this->Foto->TooltipValue = "";
			if ($this->Foto->UseColorbox) {
				if (ew_Empty($this->Foto->TooltipValue))
					$this->Foto->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Foto->LinkAttrs["data-rel"] = "personas_x" . $this->RowCnt . "_Foto";
				ew_AppendClass($this->Foto->LinkAttrs["class"], "ewLightbox");
			}

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";
			$this->Apellidos_Nombres->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";
			$this->Id_Cargo->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";
			$this->Id_Curso->TooltipValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";
			$this->Id_Division->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Foto
			$this->Foto->EditAttrs["class"] = "form-control";
			$this->Foto->EditCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->ImageWidth = 100;
				$this->Foto->ImageHeight = 100;
				$this->Foto->ImageAlt = $this->Foto->FldAlt();
				$this->Foto->EditValue = $this->Foto->Upload->DbValue;
			} else {
				$this->Foto->EditValue = "";
			}
			if (!ew_Empty($this->Foto->CurrentValue))
				$this->Foto->Upload->FileName = $this->Foto->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->Foto, $this->RowIndex);

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Curso
			$this->Id_Curso->EditAttrs["class"] = "form-control";
			$this->Id_Curso->EditCustomAttributes = "";
			if (trim(strval($this->Id_Curso->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Curso->EditValue = $arwrk;

			// Id_Division
			$this->Id_Division->EditAttrs["class"] = "form-control";
			$this->Id_Division->EditCustomAttributes = "";
			if (trim(strval($this->Id_Division->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Division->EditValue = $arwrk;

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

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			if (strval($this->Dni_Tutor->CurrentValue) <> "") {
				$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni_Tutor->EditValue = $this->Dni_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
				}
			} else {
				$this->Dni_Tutor->EditValue = NULL;
			}
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Add refer script
			// Foto

			$this->Foto->LinkCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->HrefValue = ew_GetFileUploadUrl($this->Foto, $this->Foto->Upload->DbValue); // Add prefix/suffix
				$this->Foto->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
			} else {
				$this->Foto->HrefValue = "";
			}
			$this->Foto->HrefValue2 = $this->Foto->UploadPath . $this->Foto->Upload->DbValue;

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Foto
			$this->Foto->EditAttrs["class"] = "form-control";
			$this->Foto->EditCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->ImageWidth = 100;
				$this->Foto->ImageHeight = 100;
				$this->Foto->ImageAlt = $this->Foto->FldAlt();
				$this->Foto->EditValue = $this->Foto->Upload->DbValue;
			} else {
				$this->Foto->EditValue = "";
			}
			if (!ew_Empty($this->Foto->CurrentValue))
				$this->Foto->Upload->FileName = $this->Foto->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->Foto, $this->RowIndex);

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = $this->Dni->CurrentValue;
			$this->Dni->ViewCustomAttributes = "";

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Curso
			$this->Id_Curso->EditAttrs["class"] = "form-control";
			$this->Id_Curso->EditCustomAttributes = "";
			if (trim(strval($this->Id_Curso->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Curso->EditValue = $arwrk;

			// Id_Division
			$this->Id_Division->EditAttrs["class"] = "form-control";
			$this->Id_Division->EditCustomAttributes = "";
			if (trim(strval($this->Id_Division->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Division->EditValue = $arwrk;

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

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			if (strval($this->Dni_Tutor->CurrentValue) <> "") {
				$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni_Tutor->EditValue = $this->Dni_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
				}
			} else {
				$this->Dni_Tutor->EditValue = NULL;
			}
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Foto

			$this->Foto->LinkCustomAttributes = "";
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->DbValue)) {
				$this->Foto->HrefValue = ew_GetFileUploadUrl($this->Foto, $this->Foto->Upload->DbValue); // Add prefix/suffix
				$this->Foto->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
			} else {
				$this->Foto->HrefValue = "";
			}
			$this->Foto->HrefValue2 = $this->Foto->UploadPath . $this->Foto->Upload->DbValue;

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

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
		if (!$this->Apellidos_Nombres->FldIsDetailKey && !is_null($this->Apellidos_Nombres->FormValue) && $this->Apellidos_Nombres->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellidos_Nombres->FldCaption(), $this->Apellidos_Nombres->ReqErrMsg));
		}
		if (!$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
		}
		if (!$this->Id_Cargo->FldIsDetailKey && !is_null($this->Id_Cargo->FormValue) && $this->Id_Cargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Cargo->FldCaption(), $this->Id_Cargo->ReqErrMsg));
		}
		if (!$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
		}
		if (!$this->Id_Curso->FldIsDetailKey && !is_null($this->Id_Curso->FormValue) && $this->Id_Curso->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Curso->FldCaption(), $this->Id_Curso->ReqErrMsg));
		}
		if (!$this->Id_Division->FldIsDetailKey && !is_null($this->Id_Division->FormValue) && $this->Id_Division->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Division->FldCaption(), $this->Id_Division->ReqErrMsg));
		}
		if (!$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if (!$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
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

		// Check if records exist for detail table 'estado_actual_legajo_persona'
		if (!isset($GLOBALS["estado_actual_legajo_persona"])) $GLOBALS["estado_actual_legajo_persona"] = new cestado_actual_legajo_persona();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["estado_actual_legajo_persona"]->LoadRs("`Dni` = " . ew_QuotedValue($row['Dni'], EW_DATATYPE_NUMBER, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "estado_actual_legajo_persona", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}

		// Check if records exist for detail table 'materias_adeudadas'
		if (!isset($GLOBALS["materias_adeudadas"])) $GLOBALS["materias_adeudadas"] = new cmaterias_adeudadas();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["materias_adeudadas"]->LoadRs("`Dni` = " . ew_QuotedValue($row['Dni'], EW_DATATYPE_NUMBER, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "materias_adeudadas", $Language->Phrase("RelatedRecordExists"));
				$this->setFailureMessage($sRelatedRecordMsg);
				return FALSE;
			}
		}

		// Check if records exist for detail table 'observacion_persona'
		if (!isset($GLOBALS["observacion_persona"])) $GLOBALS["observacion_persona"] = new cobservacion_persona();
		foreach ($rows as $row) {
			$rsdetail = $GLOBALS["observacion_persona"]->LoadRs("`Dni` = " . ew_QuotedValue($row['Dni'], EW_DATATYPE_NUMBER, 'DB'));
			if ($rsdetail && !$rsdetail->EOF) {
				$sRelatedRecordMsg = str_replace("%t", "observacion_persona", $Language->Phrase("RelatedRecordExists"));
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
				$sThisKey .= $row['Dni'];
				$this->LoadDbValues($row);
				$this->Foto->OldUploadPath = 'FotosPersonas';
				@unlink(ew_UploadPathEx(TRUE, $this->Foto->OldUploadPath) . $row['Foto']);
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
			$this->Foto->OldUploadPath = 'FotosPersonas';
			$this->Foto->UploadPath = $this->Foto->OldUploadPath;
			$rsnew = array();

			// Foto
			if ($this->Foto->Visible && !$this->Foto->ReadOnly && !$this->Foto->Upload->KeepFile) {
				$this->Foto->Upload->DbValue = $rsold['Foto']; // Get original value
				if ($this->Foto->Upload->FileName == "") {
					$rsnew['Foto'] = NULL;
				} else {
					$rsnew['Foto'] = $this->Foto->Upload->FileName;
				}
				$this->Foto->ImageWidth = 200; // Resize width
				$this->Foto->ImageHeight = 200; // Resize height
			}

			// Apellidos_Nombres
			$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, $this->Apellidos_Nombres->ReadOnly);

			// Dni
			// Id_Cargo

			$this->Id_Cargo->SetDbValueDef($rsnew, $this->Id_Cargo->CurrentValue, 0, $this->Id_Cargo->ReadOnly);

			// Id_Estado
			$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, $this->Id_Estado->ReadOnly);

			// Id_Curso
			$this->Id_Curso->SetDbValueDef($rsnew, $this->Id_Curso->CurrentValue, 0, $this->Id_Curso->ReadOnly);

			// Id_Division
			$this->Id_Division->SetDbValueDef($rsnew, $this->Id_Division->CurrentValue, 0, $this->Id_Division->ReadOnly);

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly);

			// Dni_Tutor
			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly);

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, NULL, $this->NroSerie->ReadOnly);

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;
			if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
				$this->Foto->UploadPath = 'FotosPersonas';
				if (!ew_Empty($this->Foto->Upload->Value)) {
					if ($this->Foto->Upload->FileName == $this->Foto->Upload->DbValue) { // Overwrite if same file name
						$this->Foto->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['Foto'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Foto->UploadPath), $rsnew['Foto']); // Get new file name
					}
				}
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
					if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
						if (!ew_Empty($this->Foto->Upload->Value)) {
							$this->Foto->Upload->Resize($this->Foto->ImageWidth, $this->Foto->ImageHeight);
							$this->Foto->Upload->SaveToFile($this->Foto->UploadPath, $rsnew['Foto'], TRUE);
						}
						if ($this->Foto->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->Foto->OldUploadPath) . $this->Foto->Upload->DbValue);
					}
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

		// Foto
		ew_CleanUploadTempPath($this->Foto, $this->Foto->Upload->Index);
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->Foto->OldUploadPath = 'FotosPersonas';
			$this->Foto->UploadPath = $this->Foto->OldUploadPath;
		}
		$rsnew = array();

		// Foto
		if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
			$this->Foto->Upload->DbValue = ""; // No need to delete old file
			if ($this->Foto->Upload->FileName == "") {
				$rsnew['Foto'] = NULL;
			} else {
				$rsnew['Foto'] = $this->Foto->Upload->FileName;
			}
			$this->Foto->ImageWidth = 200; // Resize width
			$this->Foto->ImageHeight = 200; // Resize height
		}

		// Apellidos_Nombres
		$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, FALSE);

		// Dni
		$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, FALSE);

		// Id_Cargo
		$this->Id_Cargo->SetDbValueDef($rsnew, $this->Id_Cargo->CurrentValue, 0, FALSE);

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, FALSE);

		// Id_Curso
		$this->Id_Curso->SetDbValueDef($rsnew, $this->Id_Curso->CurrentValue, 0, FALSE);

		// Id_Division
		$this->Id_Division->SetDbValueDef($rsnew, $this->Id_Division->CurrentValue, 0, FALSE);

		// Id_Turno
		$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, FALSE);

		// Dni_Tutor
		$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, NULL, FALSE);

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;
		if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
			$this->Foto->UploadPath = 'FotosPersonas';
			if (!ew_Empty($this->Foto->Upload->Value)) {
				if ($this->Foto->Upload->FileName == $this->Foto->Upload->DbValue) { // Overwrite if same file name
					$this->Foto->Upload->DbValue = ""; // No need to delete any more
				} else {
					$rsnew['Foto'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Foto->UploadPath), $rsnew['Foto']); // Get new file name
				}
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Dni']) == "") {
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
				if ($this->Foto->Visible && !$this->Foto->Upload->KeepFile) {
					if (!ew_Empty($this->Foto->Upload->Value)) {
						$this->Foto->Upload->Resize($this->Foto->ImageWidth, $this->Foto->ImageHeight);
						$this->Foto->Upload->SaveToFile($this->Foto->UploadPath, $rsnew['Foto'], TRUE);
					}
					if ($this->Foto->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->Foto->OldUploadPath) . $this->Foto->Upload->DbValue);
				}
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

		// Foto
		ew_CleanUploadTempPath($this->Foto, $this->Foto->Upload->Index);
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Foto->AdvancedSearch->Load();
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Contacto->AdvancedSearch->Load();
		$this->Fecha_Nac->AdvancedSearch->Load();
		$this->Lugar_Nacimiento->AdvancedSearch->Load();
		$this->Cod_Postal->AdvancedSearch->Load();
		$this->Repitente->AdvancedSearch->Load();
		$this->Id_Estado_Civil->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Id_Sexo->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Id_Curso->AdvancedSearch->Load();
		$this->Id_Division->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_personas\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_personas',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpersonaslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Id_Cargo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Cargo` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Cargo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Curso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Curso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Division` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Division` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
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
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni_Tutor` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
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
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld` FROM `tutores`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni_Tutor) . "',`Dni_Tutor`) LIKE '{query_value}%'";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'personas';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'personas';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dni'];

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
		$table = 'personas';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni'];

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
		$table = 'personas';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Dni'];

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
if (!isset($personas_list)) $personas_list = new cpersonas_list();

// Page init
$personas_list->Page_Init();

// Page main
$personas_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($personas->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpersonaslist = new ew_Form("fpersonaslist", "list");
fpersonaslist.FormKeyCountName = '<?php echo $personas_list->FormKeyCountName ?>';

// Validate form
fpersonaslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellidos_Nombres");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Apellidos_Nombres->FldCaption(), $personas->Apellidos_Nombres->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Dni->FldCaption(), $personas->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Cargo->FldCaption(), $personas->Id_Cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Estado->FldCaption(), $personas->Id_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Curso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Curso->FldCaption(), $personas->Id_Curso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Division");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Division->FldCaption(), $personas->Id_Division->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Id_Turno->FldCaption(), $personas->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->Dni_Tutor->FldCaption(), $personas->Dni_Tutor->ReqErrMsg)) ?>");

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
fpersonaslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Foto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Apellidos_Nombres", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Dni", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Cargo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Curso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Division", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Dni_Tutor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersonaslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonaslist.ValidateRequired = true;
<?php } else { ?>
fpersonaslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonaslist.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_persona"};
fpersonaslist.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_persona"};
fpersonaslist.Lists["x_Id_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
fpersonaslist.Lists["x_Id_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
fpersonaslist.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
fpersonaslist.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fpersonaslist.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
var CurrentSearchForm = fpersonaslistsrch = new ew_Form("fpersonaslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($personas->Export == "") { ?>
<div class="ewToolbar">
<?php if ($personas->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($personas_list->TotalRecs > 0 && $personas_list->ExportOptions->Visible()) { ?>
<?php $personas_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($personas_list->SearchOptions->Visible()) { ?>
<?php $personas_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($personas_list->FilterOptions->Visible()) { ?>
<?php $personas_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($personas->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($personas->CurrentAction == "gridadd") {
	$personas->CurrentFilter = "0=1";
	$personas_list->StartRec = 1;
	$personas_list->DisplayRecs = $personas->GridAddRowCount;
	$personas_list->TotalRecs = $personas_list->DisplayRecs;
	$personas_list->StopRec = $personas_list->DisplayRecs;
} else {
	$bSelectLimit = $personas_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($personas_list->TotalRecs <= 0)
			$personas_list->TotalRecs = $personas->SelectRecordCount();
	} else {
		if (!$personas_list->Recordset && ($personas_list->Recordset = $personas_list->LoadRecordset()))
			$personas_list->TotalRecs = $personas_list->Recordset->RecordCount();
	}
	$personas_list->StartRec = 1;
	if ($personas_list->DisplayRecs <= 0 || ($personas->Export <> "" && $personas->ExportAll)) // Display all records
		$personas_list->DisplayRecs = $personas_list->TotalRecs;
	if (!($personas->Export <> "" && $personas->ExportAll))
		$personas_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$personas_list->Recordset = $personas_list->LoadRecordset($personas_list->StartRec-1, $personas_list->DisplayRecs);

	// Set no record found message
	if ($personas->CurrentAction == "" && $personas_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$personas_list->setWarningMessage(ew_DeniedMsg());
		if ($personas_list->SearchWhere == "0=101")
			$personas_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$personas_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($personas_list->AuditTrailOnSearch && $personas_list->Command == "search" && !$personas_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $personas_list->getSessionWhere();
		$personas_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$personas_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($personas->Export == "" && $personas->CurrentAction == "") { ?>
<form name="fpersonaslistsrch" id="fpersonaslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($personas_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpersonaslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="personas">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($personas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($personas_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $personas_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($personas_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($personas_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($personas_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($personas_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $personas_list->ShowPageHeader(); ?>
<?php
$personas_list->ShowMessage();
?>
<?php if ($personas_list->TotalRecs > 0 || $personas->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid personas">
<?php if ($personas->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($personas->CurrentAction <> "gridadd" && $personas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($personas_list->Pager)) $personas_list->Pager = new cPrevNextPager($personas_list->StartRec, $personas_list->DisplayRecs, $personas_list->TotalRecs) ?>
<?php if ($personas_list->Pager->RecordCount > 0 && $personas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($personas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($personas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $personas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($personas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($personas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $personas_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $personas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $personas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $personas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personas_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpersonaslist" id="fpersonaslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personas">
<div id="gmp_personas" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($personas_list->TotalRecs > 0 || $personas->CurrentAction == "add" || $personas->CurrentAction == "copy") { ?>
<table id="tbl_personaslist" class="table ewTable">
<?php echo $personas->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$personas_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$personas_list->RenderListOptions();

// Render list options (header, left)
$personas_list->ListOptions->Render("header", "left");
?>
<?php if ($personas->Foto->Visible) { // Foto ?>
	<?php if ($personas->SortUrl($personas->Foto) == "") { ?>
		<th data-name="Foto"><div id="elh_personas_Foto" class="personas_Foto"><div class="ewTableHeaderCaption"><?php echo $personas->Foto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Foto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Foto) ?>',1);"><div id="elh_personas_Foto" class="personas_Foto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Foto->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Foto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Foto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<?php if ($personas->SortUrl($personas->Apellidos_Nombres) == "") { ?>
		<th data-name="Apellidos_Nombres"><div id="elh_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres"><div class="ewTableHeaderCaption"><?php echo $personas->Apellidos_Nombres->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellidos_Nombres"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Apellidos_Nombres) ?>',1);"><div id="elh_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Apellidos_Nombres->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Apellidos_Nombres->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Apellidos_Nombres->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Dni->Visible) { // Dni ?>
	<?php if ($personas->SortUrl($personas->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_personas_Dni" class="personas_Dni"><div class="ewTableHeaderCaption"><?php echo $personas->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Dni) ?>',1);"><div id="elh_personas_Dni" class="personas_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Dni->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
	<?php if ($personas->SortUrl($personas->Id_Cargo) == "") { ?>
		<th data-name="Id_Cargo"><div id="elh_personas_Id_Cargo" class="personas_Id_Cargo"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Cargo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Cargo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Id_Cargo) ?>',1);"><div id="elh_personas_Id_Cargo" class="personas_Id_Cargo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Cargo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Cargo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Cargo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($personas->SortUrl($personas->Id_Estado) == "") { ?>
		<th data-name="Id_Estado"><div id="elh_personas_Id_Estado" class="personas_Id_Estado"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Id_Estado) ?>',1);"><div id="elh_personas_Id_Estado" class="personas_Id_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
	<?php if ($personas->SortUrl($personas->Id_Curso) == "") { ?>
		<th data-name="Id_Curso"><div id="elh_personas_Id_Curso" class="personas_Id_Curso"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Curso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Curso"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Id_Curso) ?>',1);"><div id="elh_personas_Id_Curso" class="personas_Id_Curso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Curso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Curso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Curso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
	<?php if ($personas->SortUrl($personas->Id_Division) == "") { ?>
		<th data-name="Id_Division"><div id="elh_personas_Id_Division" class="personas_Id_Division"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Division->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Division"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Id_Division) ?>',1);"><div id="elh_personas_Id_Division" class="personas_Id_Division">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Division->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Division->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Division->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($personas->SortUrl($personas->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_personas_Id_Turno" class="personas_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $personas->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Id_Turno) ?>',1);"><div id="elh_personas_Id_Turno" class="personas_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personas->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<?php if ($personas->SortUrl($personas->Dni_Tutor) == "") { ?>
		<th data-name="Dni_Tutor"><div id="elh_personas_Dni_Tutor" class="personas_Dni_Tutor"><div class="ewTableHeaderCaption"><?php echo $personas->Dni_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni_Tutor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Dni_Tutor) ?>',1);"><div id="elh_personas_Dni_Tutor" class="personas_Dni_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Dni_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Dni_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
	<?php if ($personas->SortUrl($personas->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_personas_NroSerie" class="personas_NroSerie"><div class="ewTableHeaderCaption"><?php echo $personas->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->NroSerie) ?>',1);"><div id="elh_personas_NroSerie" class="personas_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->NroSerie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Usuario->Visible) { // Usuario ?>
	<?php if ($personas->SortUrl($personas->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_personas_Usuario" class="personas_Usuario"><div class="ewTableHeaderCaption"><?php echo $personas->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Usuario) ?>',1);"><div id="elh_personas_Usuario" class="personas_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Usuario->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($personas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($personas->SortUrl($personas->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_personas_Fecha_Actualizacion" class="personas_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $personas->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personas->SortUrl($personas->Fecha_Actualizacion) ?>',1);"><div id="elh_personas_Fecha_Actualizacion" class="personas_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personas->Fecha_Actualizacion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personas->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personas->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$personas_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($personas->CurrentAction == "add" || $personas->CurrentAction == "copy") {
		$personas_list->RowIndex = 0;
		$personas_list->KeyCount = $personas_list->RowIndex;
		if ($personas->CurrentAction == "add")
			$personas_list->LoadDefaultValues();
		if ($personas->EventCancelled) // Insert failed
			$personas_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$personas->ResetAttrs();
		$personas->RowAttrs = array_merge($personas->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_personas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$personas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$personas_list->RenderRow();

		// Render list options
		$personas_list->RenderListOptions();
		$personas_list->StartRowCnt = 0;
?>
	<tr<?php echo $personas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personas_list->ListOptions->Render("body", "left", $personas_list->RowCnt);
?>
	<?php if ($personas->Foto->Visible) { // Foto ?>
		<td data-name="Foto">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Foto" class="form-group personas_Foto">
<div id="fd_x<?php echo $personas_list->RowIndex ?>_Foto">
<span title="<?php echo $personas->Foto->FldTitle() ? $personas->Foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personas->Foto->ReadOnly || $personas->Foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personas" data-field="x_Foto" name="x<?php echo $personas_list->RowIndex ?>_Foto" id="x<?php echo $personas_list->RowIndex ?>_Foto"<?php echo $personas->Foto->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fn_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fa_x<?php echo $personas_list->RowIndex ?>_Foto" value="0">
<input type="hidden" name="fs_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fs_x<?php echo $personas_list->RowIndex ?>_Foto" value="65535">
<input type="hidden" name="fx_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fx_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fm_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $personas_list->RowIndex ?>_Foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="personas" data-field="x_Foto" name="o<?php echo $personas_list->RowIndex ?>_Foto" id="o<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo ew_HtmlEncode($personas->Foto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni" class="form-group personas_Dni">
<input type="text" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_list->RowIndex ?>_Dni" id="x<?php echo $personas_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->Dni->getPlaceHolder()) ?>" value="<?php echo $personas->Dni->EditValue ?>"<?php echo $personas->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_list->RowIndex ?>_Dni" id="o<?php echo $personas_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_list->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Estado" name="x<?php echo $personas_list->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_list->RowIndex ?>_Id_Estado" id="o<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
		<td data-name="Id_Curso">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Curso" name="x<?php echo $personas_list->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_list->RowIndex ?>_Id_Curso" id="o<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
		<td data-name="Id_Division">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Division" name="x<?php echo $personas_list->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_list->RowIndex ?>_Id_Division" id="o<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Turno" name="x<?php echo $personas_list->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_list->RowIndex ?>_Id_Turno" id="o<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<span id="el<?php echo $personas_list->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<?php
$wrkonchange = trim(" " . @$personas->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$personas->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $personas_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $personas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_NroSerie" id="x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpersonaslist.CreateAutoSuggest({"id":"x<?php echo $personas_list->RowIndex ?>_NroSerie","forceSelect":true});
</script>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_list->RowIndex ?>_NroSerie" id="o<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="personas" data-field="x_Usuario" name="o<?php echo $personas_list->RowIndex ?>_Usuario" id="o<?php echo $personas_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($personas->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="personas" data-field="x_Fecha_Actualizacion" name="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($personas->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personas_list->ListOptions->Render("body", "right", $personas_list->RowCnt);
?>
<script type="text/javascript">
fpersonaslist.UpdateOpts(<?php echo $personas_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($personas->ExportAll && $personas->Export <> "") {
	$personas_list->StopRec = $personas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($personas_list->TotalRecs > $personas_list->StartRec + $personas_list->DisplayRecs - 1)
		$personas_list->StopRec = $personas_list->StartRec + $personas_list->DisplayRecs - 1;
	else
		$personas_list->StopRec = $personas_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($personas_list->FormKeyCountName) && ($personas->CurrentAction == "gridadd" || $personas->CurrentAction == "gridedit" || $personas->CurrentAction == "F")) {
		$personas_list->KeyCount = $objForm->GetValue($personas_list->FormKeyCountName);
		$personas_list->StopRec = $personas_list->StartRec + $personas_list->KeyCount - 1;
	}
}
$personas_list->RecCnt = $personas_list->StartRec - 1;
if ($personas_list->Recordset && !$personas_list->Recordset->EOF) {
	$personas_list->Recordset->MoveFirst();
	$bSelectLimit = $personas_list->UseSelectLimit;
	if (!$bSelectLimit && $personas_list->StartRec > 1)
		$personas_list->Recordset->Move($personas_list->StartRec - 1);
} elseif (!$personas->AllowAddDeleteRow && $personas_list->StopRec == 0) {
	$personas_list->StopRec = $personas->GridAddRowCount;
}

// Initialize aggregate
$personas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$personas->ResetAttrs();
$personas_list->RenderRow();
$personas_list->EditRowCnt = 0;
if ($personas->CurrentAction == "edit")
	$personas_list->RowIndex = 1;
if ($personas->CurrentAction == "gridadd")
	$personas_list->RowIndex = 0;
if ($personas->CurrentAction == "gridedit")
	$personas_list->RowIndex = 0;
while ($personas_list->RecCnt < $personas_list->StopRec) {
	$personas_list->RecCnt++;
	if (intval($personas_list->RecCnt) >= intval($personas_list->StartRec)) {
		$personas_list->RowCnt++;
		if ($personas->CurrentAction == "gridadd" || $personas->CurrentAction == "gridedit" || $personas->CurrentAction == "F") {
			$personas_list->RowIndex++;
			$objForm->Index = $personas_list->RowIndex;
			if ($objForm->HasValue($personas_list->FormActionName))
				$personas_list->RowAction = strval($objForm->GetValue($personas_list->FormActionName));
			elseif ($personas->CurrentAction == "gridadd")
				$personas_list->RowAction = "insert";
			else
				$personas_list->RowAction = "";
		}

		// Set up key count
		$personas_list->KeyCount = $personas_list->RowIndex;

		// Init row class and style
		$personas->ResetAttrs();
		$personas->CssClass = "";
		if ($personas->CurrentAction == "gridadd") {
			$personas_list->LoadDefaultValues(); // Load default values
		} else {
			$personas_list->LoadRowValues($personas_list->Recordset); // Load row values
		}
		$personas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($personas->CurrentAction == "gridadd") // Grid add
			$personas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($personas->CurrentAction == "gridadd" && $personas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$personas_list->RestoreCurrentRowFormValues($personas_list->RowIndex); // Restore form values
		if ($personas->CurrentAction == "edit") {
			if ($personas_list->CheckInlineEditKey() && $personas_list->EditRowCnt == 0) { // Inline edit
				$personas->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($personas->CurrentAction == "gridedit") { // Grid edit
			if ($personas->EventCancelled) {
				$personas_list->RestoreCurrentRowFormValues($personas_list->RowIndex); // Restore form values
			}
			if ($personas_list->RowAction == "insert")
				$personas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$personas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($personas->CurrentAction == "edit" && $personas->RowType == EW_ROWTYPE_EDIT && $personas->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$personas_list->RestoreFormValues(); // Restore form values
		}
		if ($personas->CurrentAction == "gridedit" && ($personas->RowType == EW_ROWTYPE_EDIT || $personas->RowType == EW_ROWTYPE_ADD) && $personas->EventCancelled) // Update failed
			$personas_list->RestoreCurrentRowFormValues($personas_list->RowIndex); // Restore form values
		if ($personas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$personas_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$personas->RowAttrs = array_merge($personas->RowAttrs, array('data-rowindex'=>$personas_list->RowCnt, 'id'=>'r' . $personas_list->RowCnt . '_personas', 'data-rowtype'=>$personas->RowType));

		// Render row
		$personas_list->RenderRow();

		// Render list options
		$personas_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($personas_list->RowAction <> "delete" && $personas_list->RowAction <> "insertdelete" && !($personas_list->RowAction == "insert" && $personas->CurrentAction == "F" && $personas_list->EmptyRow())) {
?>
	<tr<?php echo $personas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personas_list->ListOptions->Render("body", "left", $personas_list->RowCnt);
?>
	<?php if ($personas->Foto->Visible) { // Foto ?>
		<td data-name="Foto"<?php echo $personas->Foto->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Foto" class="form-group personas_Foto">
<div id="fd_x<?php echo $personas_list->RowIndex ?>_Foto">
<span title="<?php echo $personas->Foto->FldTitle() ? $personas->Foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personas->Foto->ReadOnly || $personas->Foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personas" data-field="x_Foto" name="x<?php echo $personas_list->RowIndex ?>_Foto" id="x<?php echo $personas_list->RowIndex ?>_Foto"<?php echo $personas->Foto->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fn_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fa_x<?php echo $personas_list->RowIndex ?>_Foto" value="0">
<input type="hidden" name="fs_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fs_x<?php echo $personas_list->RowIndex ?>_Foto" value="65535">
<input type="hidden" name="fx_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fx_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fm_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $personas_list->RowIndex ?>_Foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="personas" data-field="x_Foto" name="o<?php echo $personas_list->RowIndex ?>_Foto" id="o<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo ew_HtmlEncode($personas->Foto->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Foto" class="form-group personas_Foto">
<div id="fd_x<?php echo $personas_list->RowIndex ?>_Foto">
<span title="<?php echo $personas->Foto->FldTitle() ? $personas->Foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personas->Foto->ReadOnly || $personas->Foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personas" data-field="x_Foto" name="x<?php echo $personas_list->RowIndex ?>_Foto" id="x<?php echo $personas_list->RowIndex ?>_Foto"<?php echo $personas->Foto->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fn_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $personas_list->RowIndex ?>_Foto"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fa_x<?php echo $personas_list->RowIndex ?>_Foto" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fa_x<?php echo $personas_list->RowIndex ?>_Foto" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fs_x<?php echo $personas_list->RowIndex ?>_Foto" value="65535">
<input type="hidden" name="fx_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fx_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fm_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $personas_list->RowIndex ?>_Foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Foto" class="personas_Foto">
<span>
<?php echo ew_GetFileViewTag($personas->Foto, $personas->Foto->ListViewValue()) ?>
</span>
</span>
<?php } ?>
<a id="<?php echo $personas_list->PageObjName . "_row_" . $personas_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres"<?php echo $personas->Apellidos_Nombres->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Apellidos_Nombres" class="personas_Apellidos_Nombres">
<span<?php echo $personas->Apellidos_Nombres->ViewAttributes() ?>>
<?php echo $personas->Apellidos_Nombres->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $personas->Dni->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni" class="form-group personas_Dni">
<input type="text" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_list->RowIndex ?>_Dni" id="x<?php echo $personas_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->Dni->getPlaceHolder()) ?>" value="<?php echo $personas->Dni->EditValue ?>"<?php echo $personas->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_list->RowIndex ?>_Dni" id="o<?php echo $personas_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni" class="form-group personas_Dni">
<span<?php echo $personas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->Dni->EditValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_list->RowIndex ?>_Dni" id="x<?php echo $personas_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->CurrentValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni" class="personas_Dni">
<span<?php echo $personas->Dni->ViewAttributes() ?>>
<?php echo $personas->Dni->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo"<?php echo $personas->Id_Cargo->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_list->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_list->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Cargo" class="personas_Id_Cargo">
<span<?php echo $personas->Id_Cargo->ViewAttributes() ?>>
<?php echo $personas->Id_Cargo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado"<?php echo $personas->Id_Estado->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Estado" name="x<?php echo $personas_list->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_list->RowIndex ?>_Id_Estado" id="o<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Estado" name="x<?php echo $personas_list->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Estado" class="personas_Id_Estado">
<span<?php echo $personas->Id_Estado->ViewAttributes() ?>>
<?php echo $personas->Id_Estado->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
		<td data-name="Id_Curso"<?php echo $personas->Id_Curso->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Curso" name="x<?php echo $personas_list->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_list->RowIndex ?>_Id_Curso" id="o<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Curso" name="x<?php echo $personas_list->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Curso" class="personas_Id_Curso">
<span<?php echo $personas->Id_Curso->ViewAttributes() ?>>
<?php echo $personas->Id_Curso->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
		<td data-name="Id_Division"<?php echo $personas->Id_Division->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Division" name="x<?php echo $personas_list->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_list->RowIndex ?>_Id_Division" id="o<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Division" name="x<?php echo $personas_list->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Division" class="personas_Id_Division">
<span<?php echo $personas->Id_Division->ViewAttributes() ?>>
<?php echo $personas->Id_Division->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $personas->Id_Turno->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Turno" name="x<?php echo $personas_list->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_list->RowIndex ?>_Id_Turno" id="o<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Turno" name="x<?php echo $personas_list->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Id_Turno" class="personas_Id_Turno">
<span<?php echo $personas->Id_Turno->ViewAttributes() ?>>
<?php echo $personas->Id_Turno->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor"<?php echo $personas->Dni_Tutor->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Dni_Tutor" class="personas_Dni_Tutor">
<span<?php echo $personas->Dni_Tutor->ViewAttributes() ?>>
<?php echo $personas->Dni_Tutor->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $personas->NroSerie->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<?php
$wrkonchange = trim(" " . @$personas->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$personas->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $personas_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $personas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_NroSerie" id="x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpersonaslist.CreateAutoSuggest({"id":"x<?php echo $personas_list->RowIndex ?>_NroSerie","forceSelect":true});
</script>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_list->RowIndex ?>_NroSerie" id="o<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_NroSerie" class="form-group personas_NroSerie">
<?php
$wrkonchange = trim(" " . @$personas->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$personas->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $personas_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $personas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_NroSerie" id="x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpersonaslist.CreateAutoSuggest({"id":"x<?php echo $personas_list->RowIndex ?>_NroSerie","forceSelect":true});
</script>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_NroSerie" class="personas_NroSerie">
<span<?php echo $personas->NroSerie->ViewAttributes() ?>>
<?php echo $personas->NroSerie->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $personas->Usuario->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="personas" data-field="x_Usuario" name="o<?php echo $personas_list->RowIndex ?>_Usuario" id="o<?php echo $personas_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($personas->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Usuario" class="personas_Usuario">
<span<?php echo $personas->Usuario->ViewAttributes() ?>>
<?php echo $personas->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($personas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $personas->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($personas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="personas" data-field="x_Fecha_Actualizacion" name="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($personas->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($personas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $personas_list->RowCnt ?>_personas_Fecha_Actualizacion" class="personas_Fecha_Actualizacion">
<span<?php echo $personas->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $personas->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personas_list->ListOptions->Render("body", "right", $personas_list->RowCnt);
?>
	</tr>
<?php if ($personas->RowType == EW_ROWTYPE_ADD || $personas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersonaslist.UpdateOpts(<?php echo $personas_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($personas->CurrentAction <> "gridadd")
		if (!$personas_list->Recordset->EOF) $personas_list->Recordset->MoveNext();
}
?>
<?php
	if ($personas->CurrentAction == "gridadd" || $personas->CurrentAction == "gridedit") {
		$personas_list->RowIndex = '$rowindex$';
		$personas_list->LoadDefaultValues();

		// Set row properties
		$personas->ResetAttrs();
		$personas->RowAttrs = array_merge($personas->RowAttrs, array('data-rowindex'=>$personas_list->RowIndex, 'id'=>'r0_personas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($personas->RowAttrs["class"], "ewTemplate");
		$personas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$personas_list->RenderRow();

		// Render list options
		$personas_list->RenderListOptions();
		$personas_list->StartRowCnt = 0;
?>
	<tr<?php echo $personas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personas_list->ListOptions->Render("body", "left", $personas_list->RowIndex);
?>
	<?php if ($personas->Foto->Visible) { // Foto ?>
		<td data-name="Foto">
<span id="el$rowindex$_personas_Foto" class="form-group personas_Foto">
<div id="fd_x<?php echo $personas_list->RowIndex ?>_Foto">
<span title="<?php echo $personas->Foto->FldTitle() ? $personas->Foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personas->Foto->ReadOnly || $personas->Foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personas" data-field="x_Foto" name="x<?php echo $personas_list->RowIndex ?>_Foto" id="x<?php echo $personas_list->RowIndex ?>_Foto"<?php echo $personas->Foto->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fn_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fa_x<?php echo $personas_list->RowIndex ?>_Foto" value="0">
<input type="hidden" name="fs_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fs_x<?php echo $personas_list->RowIndex ?>_Foto" value="65535">
<input type="hidden" name="fx_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fx_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $personas_list->RowIndex ?>_Foto" id= "fm_x<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo $personas->Foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $personas_list->RowIndex ?>_Foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="personas" data-field="x_Foto" name="o<?php echo $personas_list->RowIndex ?>_Foto" id="o<?php echo $personas_list->RowIndex ?>_Foto" value="<?php echo ew_HtmlEncode($personas->Foto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<span id="el$rowindex$_personas_Apellidos_Nombres" class="form-group personas_Apellidos_Nombres">
<input type="text" data-table="personas" data-field="x_Apellidos_Nombres" name="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $personas->Apellidos_Nombres->EditValue ?>"<?php echo $personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Apellidos_Nombres" name="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $personas_list->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($personas->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<span id="el$rowindex$_personas_Dni" class="form-group personas_Dni">
<input type="text" data-table="personas" data-field="x_Dni" name="x<?php echo $personas_list->RowIndex ?>_Dni" id="x<?php echo $personas_list->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->Dni->getPlaceHolder()) ?>" value="<?php echo $personas->Dni->EditValue ?>"<?php echo $personas->Dni->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_Dni" name="o<?php echo $personas_list->RowIndex ?>_Dni" id="o<?php echo $personas_list->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($personas->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo">
<span id="el$rowindex$_personas_Id_Cargo" class="form-group personas_Id_Cargo">
<select data-table="personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Cargo" name="x<?php echo $personas_list->RowIndex ?>_Id_Cargo"<?php echo $personas->Id_Cargo->EditAttributes() ?>>
<?php echo $personas->Id_Cargo->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo $personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Cargo" name="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" id="o<?php echo $personas_list->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($personas->Id_Cargo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<span id="el$rowindex$_personas_Id_Estado" class="form-group personas_Id_Estado">
<select data-table="personas" data-field="x_Id_Estado" data-value-separator="<?php echo $personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Estado" name="x<?php echo $personas_list->RowIndex ?>_Id_Estado"<?php echo $personas->Id_Estado->EditAttributes() ?>>
<?php echo $personas->Id_Estado->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo $personas->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Estado" name="o<?php echo $personas_list->RowIndex ?>_Id_Estado" id="o<?php echo $personas_list->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($personas->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Curso->Visible) { // Id_Curso ?>
		<td data-name="Id_Curso">
<span id="el$rowindex$_personas_Id_Curso" class="form-group personas_Id_Curso">
<select data-table="personas" data-field="x_Id_Curso" data-value-separator="<?php echo $personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Curso" name="x<?php echo $personas_list->RowIndex ?>_Id_Curso"<?php echo $personas->Id_Curso->EditAttributes() ?>>
<?php echo $personas->Id_Curso->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Curso") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo $personas->Id_Curso->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Curso" name="o<?php echo $personas_list->RowIndex ?>_Id_Curso" id="o<?php echo $personas_list->RowIndex ?>_Id_Curso" value="<?php echo ew_HtmlEncode($personas->Id_Curso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Division->Visible) { // Id_Division ?>
		<td data-name="Id_Division">
<span id="el$rowindex$_personas_Id_Division" class="form-group personas_Id_Division">
<select data-table="personas" data-field="x_Id_Division" data-value-separator="<?php echo $personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Division" name="x<?php echo $personas_list->RowIndex ?>_Id_Division"<?php echo $personas->Id_Division->EditAttributes() ?>>
<?php echo $personas->Id_Division->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Division") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo $personas->Id_Division->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Division" name="o<?php echo $personas_list->RowIndex ?>_Id_Division" id="o<?php echo $personas_list->RowIndex ?>_Id_Division" value="<?php echo ew_HtmlEncode($personas->Id_Division->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<span id="el$rowindex$_personas_Id_Turno" class="form-group personas_Id_Turno">
<select data-table="personas" data-field="x_Id_Turno" data-value-separator="<?php echo $personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $personas_list->RowIndex ?>_Id_Turno" name="x<?php echo $personas_list->RowIndex ?>_Id_Turno"<?php echo $personas->Id_Turno->EditAttributes() ?>>
<?php echo $personas->Id_Turno->SelectOptionListHtml("x<?php echo $personas_list->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" id="s_x<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo $personas->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Id_Turno" name="o<?php echo $personas_list->RowIndex ?>_Id_Turno" id="o<?php echo $personas_list->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($personas->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<span id="el$rowindex$_personas_Dni_Tutor" class="form-group personas_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><?php echo (strval($personas->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $personas->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($personas->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $personas->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->CurrentValue ?>"<?php echo $personas->Dni_Tutor->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "tutores")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->Dni_Tutor->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_Dni_Tutor',url:'tutoresaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->Dni_Tutor->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="s_x<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo $personas->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_Dni_Tutor" name="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" id="o<?php echo $personas_list->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($personas->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<span id="el$rowindex$_personas_NroSerie" class="form-group personas_NroSerie">
<?php
$wrkonchange = trim(" " . @$personas->NroSerie->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$personas->NroSerie->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $personas_list->RowIndex ?>_NroSerie" style="white-space: nowrap; z-index: <?php echo (9000 - $personas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="sv_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->EditValue ?>" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($personas->NroSerie->getPlaceHolder()) ?>"<?php echo $personas->NroSerie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" data-value-separator="<?php echo $personas->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $personas_list->RowIndex ?>_NroSerie" id="x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="q_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpersonaslist.CreateAutoSuggest({"id":"x<?php echo $personas_list->RowIndex ?>_NroSerie","forceSelect":true});
</script>
<?php if (AllowAdd(CurrentProjectID() . "equipos")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $personas->NroSerie->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $personas_list->RowIndex ?>_NroSerie',url:'equiposaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $personas_list->RowIndex ?>_NroSerie"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $personas->NroSerie->FldCaption() ?></span></button>
<?php } ?>
<input type="hidden" name="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" id="s_x<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo $personas->NroSerie->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="personas" data-field="x_NroSerie" name="o<?php echo $personas_list->RowIndex ?>_NroSerie" id="o<?php echo $personas_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($personas->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="personas" data-field="x_Usuario" name="o<?php echo $personas_list->RowIndex ?>_Usuario" id="o<?php echo $personas_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($personas->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="personas" data-field="x_Fecha_Actualizacion" name="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $personas_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($personas->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personas_list->ListOptions->Render("body", "right", $personas_list->RowCnt);
?>
<script type="text/javascript">
fpersonaslist.UpdateOpts(<?php echo $personas_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($personas->CurrentAction == "add" || $personas->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $personas_list->FormKeyCountName ?>" id="<?php echo $personas_list->FormKeyCountName ?>" value="<?php echo $personas_list->KeyCount ?>">
<?php } ?>
<?php if ($personas->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $personas_list->FormKeyCountName ?>" id="<?php echo $personas_list->FormKeyCountName ?>" value="<?php echo $personas_list->KeyCount ?>">
<?php echo $personas_list->MultiSelectKey ?>
<?php } ?>
<?php if ($personas->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $personas_list->FormKeyCountName ?>" id="<?php echo $personas_list->FormKeyCountName ?>" value="<?php echo $personas_list->KeyCount ?>">
<?php } ?>
<?php if ($personas->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $personas_list->FormKeyCountName ?>" id="<?php echo $personas_list->FormKeyCountName ?>" value="<?php echo $personas_list->KeyCount ?>">
<?php echo $personas_list->MultiSelectKey ?>
<?php } ?>
<?php if ($personas->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($personas_list->Recordset)
	$personas_list->Recordset->Close();
?>
<?php if ($personas->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($personas->CurrentAction <> "gridadd" && $personas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($personas_list->Pager)) $personas_list->Pager = new cPrevNextPager($personas_list->StartRec, $personas_list->DisplayRecs, $personas_list->TotalRecs) ?>
<?php if ($personas_list->Pager->RecordCount > 0 && $personas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($personas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($personas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $personas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($personas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($personas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $personas_list->PageUrl() ?>start=<?php echo $personas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $personas_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $personas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $personas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $personas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personas_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($personas_list->TotalRecs == 0 && $personas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personas_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($personas->Export == "") { ?>
<script type="text/javascript">
fpersonaslistsrch.FilterList = <?php echo $personas_list->GetFilterList() ?>;
fpersonaslistsrch.Init();
fpersonaslist.Init();
</script>
<?php } ?>
<?php
$personas_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($personas->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$personas_list->Page_Terminate();
?>
