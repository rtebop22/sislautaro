<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "autoridades_escolaresgridcls.php" ?>
<?php include_once "referente_tecnicogridcls.php" ?>
<?php include_once "piso_tecnologicogridcls.php" ?>
<?php include_once "servidor_escolargridcls.php" ?>
<?php include_once "datos_extras_escuelagridcls.php" ?>
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
		global $UserTable, $UserTableConn;
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

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

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
		$this->Cue->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Cantidad_Aulas->SetVisibility();
		$this->Cantidad_Turnos->SetVisibility();
		$this->Id_Tipo_Esc->SetVisibility();
		$this->Universo->SetVisibility();
		$this->Sector->SetVisibility();
		$this->Cantidad_Netbook_Actuales->SetVisibility();
		$this->Id_Estado_Esc->SetVisibility();
		$this->Id_Zona->SetVisibility();
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

			// Process auto fill for detail table 'datos_extras_escuela'
			if (@$_POST["grid"] == "fdatos_extras_escuelagrid") {
				if (!isset($GLOBALS["datos_extras_escuela_grid"])) $GLOBALS["datos_extras_escuela_grid"] = new cdatos_extras_escuela_grid;
				$GLOBALS["datos_extras_escuela_grid"]->Page_Init();
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
	var $autoridades_escolares_Count;
	var $referente_tecnico_Count;
	var $piso_tecnologico_Count;
	var $servidor_escolar_Count;
	var $datos_extras_escuela_Count;
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
		$this->setKey("Cue", ""); // Clear inline edit key
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
		if (@$_GET["Cue"] <> "") {
			$this->Cue->setQueryStringValue($_GET["Cue"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Cue", $this->Cue->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Cue")) <> strval($this->Cue->CurrentValue))
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
		if ($objForm->HasValue("x_Sigla") && $objForm->HasValue("o_Sigla") && $this->Sigla->CurrentValue <> $this->Sigla->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nro_Cuise") && $objForm->HasValue("o_Nro_Cuise") && $this->Nro_Cuise->CurrentValue <> $this->Nro_Cuise->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Departamento") && $objForm->HasValue("o_Id_Departamento") && $this->Id_Departamento->CurrentValue <> $this->Id_Departamento->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Localidad") && $objForm->HasValue("o_Id_Localidad") && $this->Id_Localidad->CurrentValue <> $this->Id_Localidad->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Aulas") && $objForm->HasValue("o_Cantidad_Aulas") && $this->Cantidad_Aulas->CurrentValue <> $this->Cantidad_Aulas->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Turnos") && $objForm->HasValue("o_Cantidad_Turnos") && $this->Cantidad_Turnos->CurrentValue <> $this->Cantidad_Turnos->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Tipo_Esc") && $objForm->HasValue("o_Id_Tipo_Esc") && $this->Id_Tipo_Esc->CurrentValue <> $this->Id_Tipo_Esc->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Universo") && $objForm->HasValue("o_Universo") && $this->Universo->CurrentValue <> $this->Universo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Sector") && $objForm->HasValue("o_Sector") && $this->Sector->CurrentValue <> $this->Sector->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Netbook_Actuales") && $objForm->HasValue("o_Cantidad_Netbook_Actuales") && $this->Cantidad_Netbook_Actuales->CurrentValue <> $this->Cantidad_Netbook_Actuales->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Estado_Esc") && $objForm->HasValue("o_Id_Estado_Esc") && $this->Id_Estado_Esc->CurrentValue <> $this->Id_Estado_Esc->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Zona") && $objForm->HasValue("o_Id_Zona") && $this->Id_Zona->CurrentValue <> $this->Id_Zona->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->Sigla->AdvancedSearch->ToJSON(), ","); // Field Sigla
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Cuise->AdvancedSearch->ToJSON(), ","); // Field Nro_Cuise
		$sFilterList = ew_Concat($sFilterList, $this->Id_Departamento->AdvancedSearch->ToJSON(), ","); // Field Id_Departamento
		$sFilterList = ew_Concat($sFilterList, $this->Id_Localidad->AdvancedSearch->ToJSON(), ","); // Field Id_Localidad
		$sFilterList = ew_Concat($sFilterList, $this->Domicilio->AdvancedSearch->ToJSON(), ","); // Field Domicilio
		$sFilterList = ew_Concat($sFilterList, $this->Telefono_Escuela->AdvancedSearch->ToJSON(), ","); // Field Telefono_Escuela
		$sFilterList = ew_Concat($sFilterList, $this->Mail_Escuela->AdvancedSearch->ToJSON(), ","); // Field Mail_Escuela
		$sFilterList = ew_Concat($sFilterList, $this->Matricula_Actual->AdvancedSearch->ToJSON(), ","); // Field Matricula_Actual
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Aulas->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Aulas
		$sFilterList = ew_Concat($sFilterList, $this->Comparte_Edificio->AdvancedSearch->ToJSON(), ","); // Field Comparte_Edificio
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Turnos->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Turnos
		$sFilterList = ew_Concat($sFilterList, $this->Geolocalizacion->AdvancedSearch->ToJSON(), ","); // Field Geolocalizacion
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Esc->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Esc
		$sFilterList = ew_Concat($sFilterList, $this->Universo->AdvancedSearch->ToJSON(), ","); // Field Universo
		$sFilterList = ew_Concat($sFilterList, $this->Tiene_Programa->AdvancedSearch->ToJSON(), ","); // Field Tiene_Programa
		$sFilterList = ew_Concat($sFilterList, $this->Sector->AdvancedSearch->ToJSON(), ","); // Field Sector
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Netbook_Conig->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Netbook_Conig
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Netbook_Actuales->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Netbook_Actuales
		$sFilterList = ew_Concat($sFilterList, $this->Id_Nivel->AdvancedSearch->ToJSON(), ","); // Field Id_Nivel
		$sFilterList = ew_Concat($sFilterList, $this->Id_Jornada->AdvancedSearch->ToJSON(), ","); // Field Id_Jornada
		$sFilterList = ew_Concat($sFilterList, $this->Tipo_Zona->AdvancedSearch->ToJSON(), ","); // Field Tipo_Zona
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado_Esc->AdvancedSearch->ToJSON(), ","); // Field Id_Estado_Esc
		$sFilterList = ew_Concat($sFilterList, $this->Id_Zona->AdvancedSearch->ToJSON(), ","); // Field Id_Zona
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

		// Field Sigla
		$this->Sigla->AdvancedSearch->SearchValue = @$filter["x_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator = @$filter["z_Sigla"];
		$this->Sigla->AdvancedSearch->SearchCondition = @$filter["v_Sigla"];
		$this->Sigla->AdvancedSearch->SearchValue2 = @$filter["y_Sigla"];
		$this->Sigla->AdvancedSearch->SearchOperator2 = @$filter["w_Sigla"];
		$this->Sigla->AdvancedSearch->Save();

		// Field Nro_Cuise
		$this->Nro_Cuise->AdvancedSearch->SearchValue = @$filter["x_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchOperator = @$filter["z_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchCondition = @$filter["v_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Cuise"];
		$this->Nro_Cuise->AdvancedSearch->Save();

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

		// Field Cantidad_Aulas
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Aulas"];
		$this->Cantidad_Aulas->AdvancedSearch->Save();

		// Field Comparte_Edificio
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

		// Field Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Netbook_Actuales"];
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->Cue, $Default, FALSE); // Cue
		$this->BuildSearchSql($sWhere, $this->Nombre_Establecimiento, $Default, FALSE); // Nombre_Establecimiento
		$this->BuildSearchSql($sWhere, $this->Sigla, $Default, FALSE); // Sigla
		$this->BuildSearchSql($sWhere, $this->Nro_Cuise, $Default, FALSE); // Nro_Cuise
		$this->BuildSearchSql($sWhere, $this->Id_Departamento, $Default, FALSE); // Id_Departamento
		$this->BuildSearchSql($sWhere, $this->Id_Localidad, $Default, FALSE); // Id_Localidad
		$this->BuildSearchSql($sWhere, $this->Domicilio, $Default, FALSE); // Domicilio
		$this->BuildSearchSql($sWhere, $this->Telefono_Escuela, $Default, FALSE); // Telefono_Escuela
		$this->BuildSearchSql($sWhere, $this->Mail_Escuela, $Default, FALSE); // Mail_Escuela
		$this->BuildSearchSql($sWhere, $this->Matricula_Actual, $Default, FALSE); // Matricula_Actual
		$this->BuildSearchSql($sWhere, $this->Cantidad_Aulas, $Default, FALSE); // Cantidad_Aulas
		$this->BuildSearchSql($sWhere, $this->Comparte_Edificio, $Default, FALSE); // Comparte_Edificio
		$this->BuildSearchSql($sWhere, $this->Cantidad_Turnos, $Default, FALSE); // Cantidad_Turnos
		$this->BuildSearchSql($sWhere, $this->Geolocalizacion, $Default, FALSE); // Geolocalizacion
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Esc, $Default, TRUE); // Id_Tipo_Esc
		$this->BuildSearchSql($sWhere, $this->Universo, $Default, FALSE); // Universo
		$this->BuildSearchSql($sWhere, $this->Tiene_Programa, $Default, FALSE); // Tiene_Programa
		$this->BuildSearchSql($sWhere, $this->Sector, $Default, FALSE); // Sector
		$this->BuildSearchSql($sWhere, $this->Cantidad_Netbook_Conig, $Default, FALSE); // Cantidad_Netbook_Conig
		$this->BuildSearchSql($sWhere, $this->Cantidad_Netbook_Actuales, $Default, FALSE); // Cantidad_Netbook_Actuales
		$this->BuildSearchSql($sWhere, $this->Id_Nivel, $Default, TRUE); // Id_Nivel
		$this->BuildSearchSql($sWhere, $this->Id_Jornada, $Default, TRUE); // Id_Jornada
		$this->BuildSearchSql($sWhere, $this->Tipo_Zona, $Default, FALSE); // Tipo_Zona
		$this->BuildSearchSql($sWhere, $this->Id_Estado_Esc, $Default, FALSE); // Id_Estado_Esc
		$this->BuildSearchSql($sWhere, $this->Id_Zona, $Default, FALSE); // Id_Zona
		$this->BuildSearchSql($sWhere, $this->Fecha_Actualizacion, $Default, FALSE); // Fecha_Actualizacion
		$this->BuildSearchSql($sWhere, $this->Usuario, $Default, FALSE); // Usuario

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Cue->AdvancedSearch->Save(); // Cue
			$this->Nombre_Establecimiento->AdvancedSearch->Save(); // Nombre_Establecimiento
			$this->Sigla->AdvancedSearch->Save(); // Sigla
			$this->Nro_Cuise->AdvancedSearch->Save(); // Nro_Cuise
			$this->Id_Departamento->AdvancedSearch->Save(); // Id_Departamento
			$this->Id_Localidad->AdvancedSearch->Save(); // Id_Localidad
			$this->Domicilio->AdvancedSearch->Save(); // Domicilio
			$this->Telefono_Escuela->AdvancedSearch->Save(); // Telefono_Escuela
			$this->Mail_Escuela->AdvancedSearch->Save(); // Mail_Escuela
			$this->Matricula_Actual->AdvancedSearch->Save(); // Matricula_Actual
			$this->Cantidad_Aulas->AdvancedSearch->Save(); // Cantidad_Aulas
			$this->Comparte_Edificio->AdvancedSearch->Save(); // Comparte_Edificio
			$this->Cantidad_Turnos->AdvancedSearch->Save(); // Cantidad_Turnos
			$this->Geolocalizacion->AdvancedSearch->Save(); // Geolocalizacion
			$this->Id_Tipo_Esc->AdvancedSearch->Save(); // Id_Tipo_Esc
			$this->Universo->AdvancedSearch->Save(); // Universo
			$this->Tiene_Programa->AdvancedSearch->Save(); // Tiene_Programa
			$this->Sector->AdvancedSearch->Save(); // Sector
			$this->Cantidad_Netbook_Conig->AdvancedSearch->Save(); // Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Actuales->AdvancedSearch->Save(); // Cantidad_Netbook_Actuales
			$this->Id_Nivel->AdvancedSearch->Save(); // Id_Nivel
			$this->Id_Jornada->AdvancedSearch->Save(); // Id_Jornada
			$this->Tipo_Zona->AdvancedSearch->Save(); // Tipo_Zona
			$this->Id_Estado_Esc->AdvancedSearch->Save(); // Id_Estado_Esc
			$this->Id_Zona->AdvancedSearch->Save(); // Id_Zona
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
		$this->BuildBasicSearchSQL($sWhere, $this->Cue, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nombre_Establecimiento, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sigla, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nro_Cuise, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Domicilio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cantidad_Turnos, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Geolocalizacion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Tipo_Esc, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Universo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Tiene_Programa, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sector, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cantidad_Netbook_Conig, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cantidad_Netbook_Actuales, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Nivel, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Jornada, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Tipo_Zona, $arKeywords, $type);
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
		if ($this->Cue->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nombre_Establecimiento->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sigla->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nro_Cuise->AdvancedSearch->IssetSession())
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
		if ($this->Cantidad_Aulas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Comparte_Edificio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Turnos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Geolocalizacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Esc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Universo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tiene_Programa->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sector->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Netbook_Conig->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Netbook_Actuales->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Nivel->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Jornada->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tipo_Zona->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado_Esc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Zona->AdvancedSearch->IssetSession())
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
		$this->Cue->AdvancedSearch->UnsetSession();
		$this->Nombre_Establecimiento->AdvancedSearch->UnsetSession();
		$this->Sigla->AdvancedSearch->UnsetSession();
		$this->Nro_Cuise->AdvancedSearch->UnsetSession();
		$this->Id_Departamento->AdvancedSearch->UnsetSession();
		$this->Id_Localidad->AdvancedSearch->UnsetSession();
		$this->Domicilio->AdvancedSearch->UnsetSession();
		$this->Telefono_Escuela->AdvancedSearch->UnsetSession();
		$this->Mail_Escuela->AdvancedSearch->UnsetSession();
		$this->Matricula_Actual->AdvancedSearch->UnsetSession();
		$this->Cantidad_Aulas->AdvancedSearch->UnsetSession();
		$this->Comparte_Edificio->AdvancedSearch->UnsetSession();
		$this->Cantidad_Turnos->AdvancedSearch->UnsetSession();
		$this->Geolocalizacion->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Esc->AdvancedSearch->UnsetSession();
		$this->Universo->AdvancedSearch->UnsetSession();
		$this->Tiene_Programa->AdvancedSearch->UnsetSession();
		$this->Sector->AdvancedSearch->UnsetSession();
		$this->Cantidad_Netbook_Conig->AdvancedSearch->UnsetSession();
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->UnsetSession();
		$this->Id_Nivel->AdvancedSearch->UnsetSession();
		$this->Id_Jornada->AdvancedSearch->UnsetSession();
		$this->Tipo_Zona->AdvancedSearch->UnsetSession();
		$this->Id_Estado_Esc->AdvancedSearch->UnsetSession();
		$this->Id_Zona->AdvancedSearch->UnsetSession();
		$this->Fecha_Actualizacion->AdvancedSearch->UnsetSession();
		$this->Usuario->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Cue->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Sigla->AdvancedSearch->Load();
		$this->Nro_Cuise->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono_Escuela->AdvancedSearch->Load();
		$this->Mail_Escuela->AdvancedSearch->Load();
		$this->Matricula_Actual->AdvancedSearch->Load();
		$this->Cantidad_Aulas->AdvancedSearch->Load();
		$this->Comparte_Edificio->AdvancedSearch->Load();
		$this->Cantidad_Turnos->AdvancedSearch->Load();
		$this->Geolocalizacion->AdvancedSearch->Load();
		$this->Id_Tipo_Esc->AdvancedSearch->Load();
		$this->Universo->AdvancedSearch->Load();
		$this->Tiene_Programa->AdvancedSearch->Load();
		$this->Sector->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Conig->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->Load();
		$this->Id_Nivel->AdvancedSearch->Load();
		$this->Id_Jornada->AdvancedSearch->Load();
		$this->Tipo_Zona->AdvancedSearch->Load();
		$this->Id_Estado_Esc->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Cue); // Cue
			$this->UpdateSort($this->Nombre_Establecimiento); // Nombre_Establecimiento
			$this->UpdateSort($this->Sigla); // Sigla
			$this->UpdateSort($this->Nro_Cuise); // Nro_Cuise
			$this->UpdateSort($this->Id_Departamento); // Id_Departamento
			$this->UpdateSort($this->Id_Localidad); // Id_Localidad
			$this->UpdateSort($this->Cantidad_Aulas); // Cantidad_Aulas
			$this->UpdateSort($this->Cantidad_Turnos); // Cantidad_Turnos
			$this->UpdateSort($this->Id_Tipo_Esc); // Id_Tipo_Esc
			$this->UpdateSort($this->Universo); // Universo
			$this->UpdateSort($this->Sector); // Sector
			$this->UpdateSort($this->Cantidad_Netbook_Actuales); // Cantidad_Netbook_Actuales
			$this->UpdateSort($this->Id_Estado_Esc); // Id_Estado_Esc
			$this->UpdateSort($this->Id_Zona); // Id_Zona
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
				$this->Nombre_Establecimiento->setSort("");
				$this->Sigla->setSort("");
				$this->Nro_Cuise->setSort("");
				$this->Id_Departamento->setSort("");
				$this->Id_Localidad->setSort("");
				$this->Cantidad_Aulas->setSort("");
				$this->Cantidad_Turnos->setSort("");
				$this->Id_Tipo_Esc->setSort("");
				$this->Universo->setSort("");
				$this->Sector->setSort("");
				$this->Cantidad_Netbook_Actuales->setSort("");
				$this->Id_Estado_Esc->setSort("");
				$this->Id_Zona->setSort("");
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

		// "detail_autoridades_escolares"
		$item = &$this->ListOptions->Add("detail_autoridades_escolares");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'autoridades_escolares') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;

		// "detail_referente_tecnico"
		$item = &$this->ListOptions->Add("detail_referente_tecnico");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'referente_tecnico') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;

		// "detail_piso_tecnologico"
		$item = &$this->ListOptions->Add("detail_piso_tecnologico");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'piso_tecnologico') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;

		// "detail_servidor_escolar"
		$item = &$this->ListOptions->Add("detail_servidor_escolar");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'servidor_escolar') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;

		// "detail_datos_extras_escuela"
		$item = &$this->ListOptions->Add("detail_datos_extras_escuela");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'datos_extras_escuela') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["datos_extras_escuela_grid"])) $GLOBALS["datos_extras_escuela_grid"] = new cdatos_extras_escuela_grid;

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
		$pages->Add("autoridades_escolares");
		$pages->Add("referente_tecnico");
		$pages->Add("piso_tecnologico");
		$pages->Add("servidor_escolar");
		$pages->Add("datos_extras_escuela");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Cue->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"dato_establecimiento\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"dato_establecimiento\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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

		// "detail_autoridades_escolares"
		$oListOpt = &$this->ListOptions->Items["detail_autoridades_escolares"];
		if ($Security->AllowList(CurrentProjectID() . 'autoridades_escolares')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("autoridades_escolares", "TblCaption");
			$body .= str_replace("%c", $this->autoridades_escolares_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("autoridades_escolareslist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["autoridades_escolares_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'autoridades_escolares')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "autoridades_escolares";
			}
			if ($GLOBALS["autoridades_escolares_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'autoridades_escolares')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "autoridades_escolares";
			}
			if ($GLOBALS["autoridades_escolares_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'autoridades_escolares')) {
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
		if ($Security->AllowList(CurrentProjectID() . 'referente_tecnico')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("referente_tecnico", "TblCaption");
			$body .= str_replace("%c", $this->referente_tecnico_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("referente_tecnicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["referente_tecnico_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'referente_tecnico')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "referente_tecnico";
			}
			if ($GLOBALS["referente_tecnico_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'referente_tecnico')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "referente_tecnico";
			}
			if ($GLOBALS["referente_tecnico_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'referente_tecnico')) {
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
		if ($Security->AllowList(CurrentProjectID() . 'piso_tecnologico')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("piso_tecnologico", "TblCaption");
			$body .= str_replace("%c", $this->piso_tecnologico_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("piso_tecnologicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["piso_tecnologico_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'piso_tecnologico')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "piso_tecnologico";
			}
			if ($GLOBALS["piso_tecnologico_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'piso_tecnologico')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "piso_tecnologico";
			}
			if ($GLOBALS["piso_tecnologico_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'piso_tecnologico')) {
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
		if ($Security->AllowList(CurrentProjectID() . 'servidor_escolar')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("servidor_escolar", "TblCaption");
			$body .= str_replace("%c", $this->servidor_escolar_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("servidor_escolarlist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["servidor_escolar_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'servidor_escolar')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "servidor_escolar";
			}
			if ($GLOBALS["servidor_escolar_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'servidor_escolar')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "servidor_escolar";
			}
			if ($GLOBALS["servidor_escolar_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'servidor_escolar')) {
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

		// "detail_datos_extras_escuela"
		$oListOpt = &$this->ListOptions->Items["detail_datos_extras_escuela"];
		if ($Security->AllowList(CurrentProjectID() . 'datos_extras_escuela')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("datos_extras_escuela", "TblCaption");
			$body .= str_replace("%c", $this->datos_extras_escuela_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("datos_extras_escuelalist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["datos_extras_escuela_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'datos_extras_escuela')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "datos_extras_escuela";
			}
			if ($GLOBALS["datos_extras_escuela_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'datos_extras_escuela')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "datos_extras_escuela";
			}
			if ($GLOBALS["datos_extras_escuela_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'datos_extras_escuela')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "datos_extras_escuela";
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
		$item = &$option->Add("detailadd_autoridades_escolares");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["autoridades_escolares"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["autoridades_escolares"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'autoridades_escolares') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "autoridades_escolares";
		}
		$item = &$option->Add("detailadd_referente_tecnico");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["referente_tecnico"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["referente_tecnico"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'referente_tecnico') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "referente_tecnico";
		}
		$item = &$option->Add("detailadd_piso_tecnologico");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["piso_tecnologico"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["piso_tecnologico"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'piso_tecnologico') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "piso_tecnologico";
		}
		$item = &$option->Add("detailadd_servidor_escolar");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["servidor_escolar"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["servidor_escolar"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'servidor_escolar') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "servidor_escolar";
		}
		$item = &$option->Add("detailadd_datos_extras_escuela");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["datos_extras_escuela"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["datos_extras_escuela"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'datos_extras_escuela') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "datos_extras_escuela";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fdato_establecimientolist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"dato_establecimiento\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fdato_establecimientolist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$this->Cue->CurrentValue = NULL;
		$this->Cue->OldValue = $this->Cue->CurrentValue;
		$this->Nombre_Establecimiento->CurrentValue = NULL;
		$this->Nombre_Establecimiento->OldValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Sigla->CurrentValue = NULL;
		$this->Sigla->OldValue = $this->Sigla->CurrentValue;
		$this->Nro_Cuise->CurrentValue = NULL;
		$this->Nro_Cuise->OldValue = $this->Nro_Cuise->CurrentValue;
		$this->Id_Departamento->CurrentValue = NULL;
		$this->Id_Departamento->OldValue = $this->Id_Departamento->CurrentValue;
		$this->Id_Localidad->CurrentValue = NULL;
		$this->Id_Localidad->OldValue = $this->Id_Localidad->CurrentValue;
		$this->Cantidad_Aulas->CurrentValue = NULL;
		$this->Cantidad_Aulas->OldValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Turnos->CurrentValue = NULL;
		$this->Cantidad_Turnos->OldValue = $this->Cantidad_Turnos->CurrentValue;
		$this->Id_Tipo_Esc->CurrentValue = NULL;
		$this->Id_Tipo_Esc->OldValue = $this->Id_Tipo_Esc->CurrentValue;
		$this->Universo->CurrentValue = NULL;
		$this->Universo->OldValue = $this->Universo->CurrentValue;
		$this->Sector->CurrentValue = NULL;
		$this->Sector->OldValue = $this->Sector->CurrentValue;
		$this->Cantidad_Netbook_Actuales->CurrentValue = NULL;
		$this->Cantidad_Netbook_Actuales->OldValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Id_Estado_Esc->CurrentValue = NULL;
		$this->Id_Estado_Esc->OldValue = $this->Id_Estado_Esc->CurrentValue;
		$this->Id_Zona->CurrentValue = NULL;
		$this->Id_Zona->OldValue = $this->Id_Zona->CurrentValue;
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
		// Cue

		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cue"]);
		if ($this->Cue->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cue->AdvancedSearch->SearchOperator = @$_GET["z_Cue"];

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nombre_Establecimiento"]);
		if ($this->Nombre_Establecimiento->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = @$_GET["z_Nombre_Establecimiento"];

		// Sigla
		$this->Sigla->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sigla"]);
		if ($this->Sigla->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sigla->AdvancedSearch->SearchOperator = @$_GET["z_Sigla"];

		// Nro_Cuise
		$this->Nro_Cuise->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nro_Cuise"]);
		if ($this->Nro_Cuise->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nro_Cuise->AdvancedSearch->SearchOperator = @$_GET["z_Nro_Cuise"];

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

		// Cantidad_Aulas
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Aulas"]);
		if ($this->Cantidad_Aulas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Aulas"];

		// Comparte_Edificio
		$this->Comparte_Edificio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Comparte_Edificio"]);
		if ($this->Comparte_Edificio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Comparte_Edificio->AdvancedSearch->SearchOperator = @$_GET["z_Comparte_Edificio"];

		// Cantidad_Turnos
		$this->Cantidad_Turnos->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Turnos"]);
		if ($this->Cantidad_Turnos->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Turnos->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Turnos"];

		// Geolocalizacion
		$this->Geolocalizacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Geolocalizacion"]);
		if ($this->Geolocalizacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Geolocalizacion->AdvancedSearch->SearchOperator = @$_GET["z_Geolocalizacion"];

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Esc"]);
		if ($this->Id_Tipo_Esc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Esc->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Esc"];
		if (is_array($this->Id_Tipo_Esc->AdvancedSearch->SearchValue)) $this->Id_Tipo_Esc->AdvancedSearch->SearchValue = implode(",", $this->Id_Tipo_Esc->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Tipo_Esc->AdvancedSearch->SearchValue2)) $this->Id_Tipo_Esc->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Tipo_Esc->AdvancedSearch->SearchValue2);

		// Universo
		$this->Universo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Universo"]);
		if ($this->Universo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Universo->AdvancedSearch->SearchOperator = @$_GET["z_Universo"];

		// Tiene_Programa
		$this->Tiene_Programa->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tiene_Programa"]);
		if ($this->Tiene_Programa->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tiene_Programa->AdvancedSearch->SearchOperator = @$_GET["z_Tiene_Programa"];

		// Sector
		$this->Sector->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sector"]);
		if ($this->Sector->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sector->AdvancedSearch->SearchOperator = @$_GET["z_Sector"];

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Netbook_Conig"]);
		if ($this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Netbook_Conig"];

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Netbook_Actuales"]);
		if ($this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Netbook_Actuales"];

		// Id_Nivel
		$this->Id_Nivel->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Nivel"]);
		if ($this->Id_Nivel->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Nivel->AdvancedSearch->SearchOperator = @$_GET["z_Id_Nivel"];
		if (is_array($this->Id_Nivel->AdvancedSearch->SearchValue)) $this->Id_Nivel->AdvancedSearch->SearchValue = implode(",", $this->Id_Nivel->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Nivel->AdvancedSearch->SearchValue2)) $this->Id_Nivel->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Nivel->AdvancedSearch->SearchValue2);

		// Id_Jornada
		$this->Id_Jornada->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Jornada"]);
		if ($this->Id_Jornada->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Jornada->AdvancedSearch->SearchOperator = @$_GET["z_Id_Jornada"];
		if (is_array($this->Id_Jornada->AdvancedSearch->SearchValue)) $this->Id_Jornada->AdvancedSearch->SearchValue = implode(",", $this->Id_Jornada->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Jornada->AdvancedSearch->SearchValue2)) $this->Id_Jornada->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Jornada->AdvancedSearch->SearchValue2);

		// Tipo_Zona
		$this->Tipo_Zona->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tipo_Zona"]);
		if ($this->Tipo_Zona->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tipo_Zona->AdvancedSearch->SearchOperator = @$_GET["z_Tipo_Zona"];

		// Id_Estado_Esc
		$this->Id_Estado_Esc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado_Esc"]);
		if ($this->Id_Estado_Esc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado_Esc->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado_Esc"];

		// Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Zona"]);
		if ($this->Id_Zona->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Zona->AdvancedSearch->SearchOperator = @$_GET["z_Id_Zona"];

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
		if (!$this->Cue->FldIsDetailKey) {
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
		}
		$this->Cue->setOldValue($objForm->GetValue("o_Cue"));
		if (!$this->Nombre_Establecimiento->FldIsDetailKey) {
			$this->Nombre_Establecimiento->setFormValue($objForm->GetValue("x_Nombre_Establecimiento"));
		}
		$this->Nombre_Establecimiento->setOldValue($objForm->GetValue("o_Nombre_Establecimiento"));
		if (!$this->Sigla->FldIsDetailKey) {
			$this->Sigla->setFormValue($objForm->GetValue("x_Sigla"));
		}
		$this->Sigla->setOldValue($objForm->GetValue("o_Sigla"));
		if (!$this->Nro_Cuise->FldIsDetailKey) {
			$this->Nro_Cuise->setFormValue($objForm->GetValue("x_Nro_Cuise"));
		}
		$this->Nro_Cuise->setOldValue($objForm->GetValue("o_Nro_Cuise"));
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->setOldValue($objForm->GetValue("o_Id_Departamento"));
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->setOldValue($objForm->GetValue("o_Id_Localidad"));
		if (!$this->Cantidad_Aulas->FldIsDetailKey) {
			$this->Cantidad_Aulas->setFormValue($objForm->GetValue("x_Cantidad_Aulas"));
		}
		$this->Cantidad_Aulas->setOldValue($objForm->GetValue("o_Cantidad_Aulas"));
		if (!$this->Cantidad_Turnos->FldIsDetailKey) {
			$this->Cantidad_Turnos->setFormValue($objForm->GetValue("x_Cantidad_Turnos"));
		}
		$this->Cantidad_Turnos->setOldValue($objForm->GetValue("o_Cantidad_Turnos"));
		if (!$this->Id_Tipo_Esc->FldIsDetailKey) {
			$this->Id_Tipo_Esc->setFormValue($objForm->GetValue("x_Id_Tipo_Esc"));
		}
		$this->Id_Tipo_Esc->setOldValue($objForm->GetValue("o_Id_Tipo_Esc"));
		if (!$this->Universo->FldIsDetailKey) {
			$this->Universo->setFormValue($objForm->GetValue("x_Universo"));
		}
		$this->Universo->setOldValue($objForm->GetValue("o_Universo"));
		if (!$this->Sector->FldIsDetailKey) {
			$this->Sector->setFormValue($objForm->GetValue("x_Sector"));
		}
		$this->Sector->setOldValue($objForm->GetValue("o_Sector"));
		if (!$this->Cantidad_Netbook_Actuales->FldIsDetailKey) {
			$this->Cantidad_Netbook_Actuales->setFormValue($objForm->GetValue("x_Cantidad_Netbook_Actuales"));
		}
		$this->Cantidad_Netbook_Actuales->setOldValue($objForm->GetValue("o_Cantidad_Netbook_Actuales"));
		if (!$this->Id_Estado_Esc->FldIsDetailKey) {
			$this->Id_Estado_Esc->setFormValue($objForm->GetValue("x_Id_Estado_Esc"));
		}
		$this->Id_Estado_Esc->setOldValue($objForm->GetValue("o_Id_Estado_Esc"));
		if (!$this->Id_Zona->FldIsDetailKey) {
			$this->Id_Zona->setFormValue($objForm->GetValue("x_Id_Zona"));
		}
		$this->Id_Zona->setOldValue($objForm->GetValue("o_Id_Zona"));
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
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Nombre_Establecimiento->CurrentValue = $this->Nombre_Establecimiento->FormValue;
		$this->Sigla->CurrentValue = $this->Sigla->FormValue;
		$this->Nro_Cuise->CurrentValue = $this->Nro_Cuise->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Cantidad_Aulas->CurrentValue = $this->Cantidad_Aulas->FormValue;
		$this->Cantidad_Turnos->CurrentValue = $this->Cantidad_Turnos->FormValue;
		$this->Id_Tipo_Esc->CurrentValue = $this->Id_Tipo_Esc->FormValue;
		$this->Universo->CurrentValue = $this->Universo->FormValue;
		$this->Sector->CurrentValue = $this->Sector->FormValue;
		$this->Cantidad_Netbook_Actuales->CurrentValue = $this->Cantidad_Netbook_Actuales->FormValue;
		$this->Id_Estado_Esc->CurrentValue = $this->Id_Estado_Esc->FormValue;
		$this->Id_Zona->CurrentValue = $this->Id_Zona->FormValue;
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Nro_Cuise->setDbValue($rs->fields('Nro_Cuise'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono_Escuela->setDbValue($rs->fields('Telefono_Escuela'));
		$this->Mail_Escuela->setDbValue($rs->fields('Mail_Escuela'));
		$this->Matricula_Actual->setDbValue($rs->fields('Matricula_Actual'));
		$this->Cantidad_Aulas->setDbValue($rs->fields('Cantidad_Aulas'));
		$this->Comparte_Edificio->setDbValue($rs->fields('Comparte_Edificio'));
		$this->Cantidad_Turnos->setDbValue($rs->fields('Cantidad_Turnos'));
		$this->Geolocalizacion->setDbValue($rs->fields('Geolocalizacion'));
		$this->Id_Tipo_Esc->setDbValue($rs->fields('Id_Tipo_Esc'));
		$this->Universo->setDbValue($rs->fields('Universo'));
		$this->Tiene_Programa->setDbValue($rs->fields('Tiene_Programa'));
		$this->Sector->setDbValue($rs->fields('Sector'));
		$this->Cantidad_Netbook_Conig->setDbValue($rs->fields('Cantidad_Netbook_Conig'));
		$this->Cantidad_Netbook_Actuales->setDbValue($rs->fields('Cantidad_Netbook_Actuales'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Jornada->setDbValue($rs->fields('Id_Jornada'));
		$this->Tipo_Zona->setDbValue($rs->fields('Tipo_Zona'));
		$this->Id_Estado_Esc->setDbValue($rs->fields('Id_Estado_Esc'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
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
		if (!isset($GLOBALS["datos_extras_escuela_grid"])) $GLOBALS["datos_extras_escuela_grid"] = new cdatos_extras_escuela_grid;
		$sDetailFilter = $GLOBALS["datos_extras_escuela"]->SqlDetailFilter_dato_establecimiento();
		$sDetailFilter = str_replace("@Cue@", ew_AdjustSql($this->Cue->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["datos_extras_escuela"]->setCurrentMasterTable("dato_establecimiento");
		$sDetailFilter = $GLOBALS["datos_extras_escuela"]->ApplyUserIDFilters($sDetailFilter);
		$this->datos_extras_escuela_Count = $GLOBALS["datos_extras_escuela"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Sigla->DbValue = $row['Sigla'];
		$this->Nro_Cuise->DbValue = $row['Nro_Cuise'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono_Escuela->DbValue = $row['Telefono_Escuela'];
		$this->Mail_Escuela->DbValue = $row['Mail_Escuela'];
		$this->Matricula_Actual->DbValue = $row['Matricula_Actual'];
		$this->Cantidad_Aulas->DbValue = $row['Cantidad_Aulas'];
		$this->Comparte_Edificio->DbValue = $row['Comparte_Edificio'];
		$this->Cantidad_Turnos->DbValue = $row['Cantidad_Turnos'];
		$this->Geolocalizacion->DbValue = $row['Geolocalizacion'];
		$this->Id_Tipo_Esc->DbValue = $row['Id_Tipo_Esc'];
		$this->Universo->DbValue = $row['Universo'];
		$this->Tiene_Programa->DbValue = $row['Tiene_Programa'];
		$this->Sector->DbValue = $row['Sector'];
		$this->Cantidad_Netbook_Conig->DbValue = $row['Cantidad_Netbook_Conig'];
		$this->Cantidad_Netbook_Actuales->DbValue = $row['Cantidad_Netbook_Actuales'];
		$this->Id_Nivel->DbValue = $row['Id_Nivel'];
		$this->Id_Jornada->DbValue = $row['Id_Jornada'];
		$this->Tipo_Zona->DbValue = $row['Tipo_Zona'];
		$this->Id_Estado_Esc->DbValue = $row['Id_Estado_Esc'];
		$this->Id_Zona->DbValue = $row['Id_Zona'];
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
		// Nombre_Establecimiento
		// Sigla
		// Nro_Cuise
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono_Escuela
		// Mail_Escuela
		// Matricula_Actual
		// Cantidad_Aulas
		// Comparte_Edificio
		// Cantidad_Turnos
		// Geolocalizacion
		// Id_Tipo_Esc
		// Universo
		// Tiene_Programa
		// Sector
		// Cantidad_Netbook_Conig
		// Cantidad_Netbook_Actuales
		// Id_Nivel
		// Id_Jornada
		// Tipo_Zona
		// Id_Estado_Esc
		// Id_Zona
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Nro_Cuise
		$this->Nro_Cuise->ViewValue = $this->Nro_Cuise->CurrentValue;
		$this->Nro_Cuise->ViewCustomAttributes = "";

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

		// Cantidad_Aulas
		$this->Cantidad_Aulas->ViewValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Aulas->ViewCustomAttributes = "";

		// Comparte_Edificio
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
		if (strval($this->Universo->CurrentValue) <> "") {
			$this->Universo->ViewValue = $this->Universo->OptionCaption($this->Universo->CurrentValue);
		} else {
			$this->Universo->ViewValue = NULL;
		}
		$this->Universo->ViewCustomAttributes = "";

		// Tiene_Programa
		if (strval($this->Tiene_Programa->CurrentValue) <> "") {
			$this->Tiene_Programa->ViewValue = $this->Tiene_Programa->OptionCaption($this->Tiene_Programa->CurrentValue);
		} else {
			$this->Tiene_Programa->ViewValue = NULL;
		}
		$this->Tiene_Programa->ViewCustomAttributes = "";

		// Sector
		if (strval($this->Sector->CurrentValue) <> "") {
			$this->Sector->ViewValue = $this->Sector->OptionCaption($this->Sector->CurrentValue);
		} else {
			$this->Sector->ViewValue = NULL;
		}
		$this->Sector->ViewCustomAttributes = "";

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->ViewValue = $this->Cantidad_Netbook_Conig->CurrentValue;
		$this->Cantidad_Netbook_Conig->ViewCustomAttributes = "";

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->ViewValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Cantidad_Netbook_Actuales->ViewCustomAttributes = "";

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

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";
			$this->Nro_Cuise->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";
			$this->Cantidad_Aulas->TooltipValue = "";

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

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";
			$this->Sector->TooltipValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";
			$this->Cantidad_Netbook_Actuales->TooltipValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";
			$this->Id_Estado_Esc->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
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

			// Sigla
			$this->Sigla->EditAttrs["class"] = "form-control";
			$this->Sigla->EditCustomAttributes = "";
			$this->Sigla->EditValue = ew_HtmlEncode($this->Sigla->CurrentValue);
			$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

			// Nro_Cuise
			$this->Nro_Cuise->EditAttrs["class"] = "form-control";
			$this->Nro_Cuise->EditCustomAttributes = "";
			$this->Nro_Cuise->EditValue = ew_HtmlEncode($this->Nro_Cuise->CurrentValue);
			$this->Nro_Cuise->PlaceHolder = ew_RemoveHtml($this->Nro_Cuise->FldCaption());

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

			// Cantidad_Aulas
			$this->Cantidad_Aulas->EditAttrs["class"] = "form-control";
			$this->Cantidad_Aulas->EditCustomAttributes = "";
			$this->Cantidad_Aulas->EditValue = ew_HtmlEncode($this->Cantidad_Aulas->CurrentValue);
			$this->Cantidad_Aulas->PlaceHolder = ew_RemoveHtml($this->Cantidad_Aulas->FldCaption());

			// Cantidad_Turnos
			$this->Cantidad_Turnos->EditAttrs["class"] = "form-control";
			$this->Cantidad_Turnos->EditCustomAttributes = "";
			$this->Cantidad_Turnos->EditValue = ew_HtmlEncode($this->Cantidad_Turnos->CurrentValue);
			$this->Cantidad_Turnos->PlaceHolder = ew_RemoveHtml($this->Cantidad_Turnos->FldCaption());

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_escuela`";
			$sWhereWrk = "";
			$this->Id_Tipo_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Esc->EditValue = $arwrk;

			// Universo
			$this->Universo->EditAttrs["class"] = "form-control";
			$this->Universo->EditCustomAttributes = "";
			$this->Universo->EditValue = $this->Universo->Options(TRUE);

			// Sector
			$this->Sector->EditAttrs["class"] = "form-control";
			$this->Sector->EditCustomAttributes = "";
			$this->Sector->EditValue = $this->Sector->Options(TRUE);

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->EditAttrs["class"] = "form-control";
			$this->Cantidad_Netbook_Actuales->EditCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Actuales->CurrentValue);
			$this->Cantidad_Netbook_Actuales->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Actuales->FldCaption());

			// Id_Estado_Esc
			$this->Id_Estado_Esc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Estado_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Esc->EditValue = $arwrk;

			// Id_Zona
			$this->Id_Zona->EditAttrs["class"] = "form-control";
			$this->Id_Zona->EditCustomAttributes = "";
			if (trim(strval($this->Id_Zona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Zona->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";

			// Cantidad_Turnos
			$this->Cantidad_Turnos->LinkCustomAttributes = "";
			$this->Cantidad_Turnos->HrefValue = "";

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->LinkCustomAttributes = "";
			$this->Id_Tipo_Esc->HrefValue = "";

			// Universo
			$this->Universo->LinkCustomAttributes = "";
			$this->Universo->HrefValue = "";

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
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

			// Sigla
			$this->Sigla->EditAttrs["class"] = "form-control";
			$this->Sigla->EditCustomAttributes = "";
			$this->Sigla->EditValue = ew_HtmlEncode($this->Sigla->CurrentValue);
			$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

			// Nro_Cuise
			$this->Nro_Cuise->EditAttrs["class"] = "form-control";
			$this->Nro_Cuise->EditCustomAttributes = "";
			$this->Nro_Cuise->EditValue = ew_HtmlEncode($this->Nro_Cuise->CurrentValue);
			$this->Nro_Cuise->PlaceHolder = ew_RemoveHtml($this->Nro_Cuise->FldCaption());

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

			// Cantidad_Aulas
			$this->Cantidad_Aulas->EditAttrs["class"] = "form-control";
			$this->Cantidad_Aulas->EditCustomAttributes = "";
			$this->Cantidad_Aulas->EditValue = ew_HtmlEncode($this->Cantidad_Aulas->CurrentValue);
			$this->Cantidad_Aulas->PlaceHolder = ew_RemoveHtml($this->Cantidad_Aulas->FldCaption());

			// Cantidad_Turnos
			$this->Cantidad_Turnos->EditAttrs["class"] = "form-control";
			$this->Cantidad_Turnos->EditCustomAttributes = "";
			$this->Cantidad_Turnos->EditValue = ew_HtmlEncode($this->Cantidad_Turnos->CurrentValue);
			$this->Cantidad_Turnos->PlaceHolder = ew_RemoveHtml($this->Cantidad_Turnos->FldCaption());

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_escuela`";
			$sWhereWrk = "";
			$this->Id_Tipo_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Esc->EditValue = $arwrk;

			// Universo
			$this->Universo->EditAttrs["class"] = "form-control";
			$this->Universo->EditCustomAttributes = "";
			$this->Universo->EditValue = $this->Universo->Options(TRUE);

			// Sector
			$this->Sector->EditAttrs["class"] = "form-control";
			$this->Sector->EditCustomAttributes = "";
			$this->Sector->EditValue = $this->Sector->Options(TRUE);

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->EditAttrs["class"] = "form-control";
			$this->Cantidad_Netbook_Actuales->EditCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Actuales->CurrentValue);
			$this->Cantidad_Netbook_Actuales->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Actuales->FldCaption());

			// Id_Estado_Esc
			$this->Id_Estado_Esc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Estado_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Esc->EditValue = $arwrk;

			// Id_Zona
			$this->Id_Zona->EditAttrs["class"] = "form-control";
			$this->Id_Zona->EditCustomAttributes = "";
			if (trim(strval($this->Id_Zona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Zona->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";

			// Cantidad_Turnos
			$this->Cantidad_Turnos->LinkCustomAttributes = "";
			$this->Cantidad_Turnos->HrefValue = "";

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->LinkCustomAttributes = "";
			$this->Id_Tipo_Esc->HrefValue = "";

			// Universo
			$this->Universo->LinkCustomAttributes = "";
			$this->Universo->HrefValue = "";

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";

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
		if (!$this->Cue->FldIsDetailKey && !is_null($this->Cue->FormValue) && $this->Cue->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cue->FldCaption(), $this->Cue->ReqErrMsg));
		}
		if (!$this->Nombre_Establecimiento->FldIsDetailKey && !is_null($this->Nombre_Establecimiento->FormValue) && $this->Nombre_Establecimiento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nombre_Establecimiento->FldCaption(), $this->Nombre_Establecimiento->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Nro_Cuise->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nro_Cuise->FldErrMsg());
		}
		if (!$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if (!$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Cantidad_Aulas->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Aulas->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Turnos->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Turnos->FldErrMsg());
		}
		if ($this->Id_Tipo_Esc->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Esc->FldCaption(), $this->Id_Tipo_Esc->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Cantidad_Netbook_Actuales->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Netbook_Actuales->FldErrMsg());
		}
		if (!$this->Id_Estado_Esc->FldIsDetailKey && !is_null($this->Id_Estado_Esc->FormValue) && $this->Id_Estado_Esc->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Esc->FldCaption(), $this->Id_Estado_Esc->ReqErrMsg));
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

			// Sigla
			$this->Sigla->SetDbValueDef($rsnew, $this->Sigla->CurrentValue, NULL, $this->Sigla->ReadOnly);

			// Nro_Cuise
			$this->Nro_Cuise->SetDbValueDef($rsnew, $this->Nro_Cuise->CurrentValue, NULL, $this->Nro_Cuise->ReadOnly);

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly);

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly);

			// Cantidad_Aulas
			$this->Cantidad_Aulas->SetDbValueDef($rsnew, $this->Cantidad_Aulas->CurrentValue, NULL, $this->Cantidad_Aulas->ReadOnly);

			// Cantidad_Turnos
			$this->Cantidad_Turnos->SetDbValueDef($rsnew, $this->Cantidad_Turnos->CurrentValue, NULL, $this->Cantidad_Turnos->ReadOnly);

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->SetDbValueDef($rsnew, $this->Id_Tipo_Esc->CurrentValue, "", $this->Id_Tipo_Esc->ReadOnly);

			// Universo
			$this->Universo->SetDbValueDef($rsnew, $this->Universo->CurrentValue, NULL, $this->Universo->ReadOnly);

			// Sector
			$this->Sector->SetDbValueDef($rsnew, $this->Sector->CurrentValue, NULL, $this->Sector->ReadOnly);

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->SetDbValueDef($rsnew, $this->Cantidad_Netbook_Actuales->CurrentValue, NULL, $this->Cantidad_Netbook_Actuales->ReadOnly);

			// Id_Estado_Esc
			$this->Id_Estado_Esc->SetDbValueDef($rsnew, $this->Id_Estado_Esc->CurrentValue, 0, $this->Id_Estado_Esc->ReadOnly);

			// Id_Zona
			$this->Id_Zona->SetDbValueDef($rsnew, $this->Id_Zona->CurrentValue, NULL, $this->Id_Zona->ReadOnly);

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

		// Cue
		$this->Cue->SetDbValueDef($rsnew, $this->Cue->CurrentValue, "", FALSE);

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, FALSE);

		// Sigla
		$this->Sigla->SetDbValueDef($rsnew, $this->Sigla->CurrentValue, NULL, FALSE);

		// Nro_Cuise
		$this->Nro_Cuise->SetDbValueDef($rsnew, $this->Nro_Cuise->CurrentValue, NULL, FALSE);

		// Id_Departamento
		$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, FALSE);

		// Id_Localidad
		$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, FALSE);

		// Cantidad_Aulas
		$this->Cantidad_Aulas->SetDbValueDef($rsnew, $this->Cantidad_Aulas->CurrentValue, NULL, FALSE);

		// Cantidad_Turnos
		$this->Cantidad_Turnos->SetDbValueDef($rsnew, $this->Cantidad_Turnos->CurrentValue, NULL, FALSE);

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc->SetDbValueDef($rsnew, $this->Id_Tipo_Esc->CurrentValue, "", FALSE);

		// Universo
		$this->Universo->SetDbValueDef($rsnew, $this->Universo->CurrentValue, NULL, FALSE);

		// Sector
		$this->Sector->SetDbValueDef($rsnew, $this->Sector->CurrentValue, NULL, FALSE);

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->SetDbValueDef($rsnew, $this->Cantidad_Netbook_Actuales->CurrentValue, NULL, FALSE);

		// Id_Estado_Esc
		$this->Id_Estado_Esc->SetDbValueDef($rsnew, $this->Id_Estado_Esc->CurrentValue, 0, FALSE);

		// Id_Zona
		$this->Id_Zona->SetDbValueDef($rsnew, $this->Id_Zona->CurrentValue, NULL, FALSE);

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
		$this->Sigla->AdvancedSearch->Load();
		$this->Nro_Cuise->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono_Escuela->AdvancedSearch->Load();
		$this->Mail_Escuela->AdvancedSearch->Load();
		$this->Matricula_Actual->AdvancedSearch->Load();
		$this->Cantidad_Aulas->AdvancedSearch->Load();
		$this->Comparte_Edificio->AdvancedSearch->Load();
		$this->Cantidad_Turnos->AdvancedSearch->Load();
		$this->Geolocalizacion->AdvancedSearch->Load();
		$this->Id_Tipo_Esc->AdvancedSearch->Load();
		$this->Universo->AdvancedSearch->Load();
		$this->Tiene_Programa->AdvancedSearch->Load();
		$this->Sector->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Conig->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->Load();
		$this->Id_Nivel->AdvancedSearch->Load();
		$this->Id_Jornada->AdvancedSearch->Load();
		$this->Tipo_Zona->AdvancedSearch->Load();
		$this->Id_Estado_Esc->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_dato_establecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dato_establecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdato_establecimientolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_Id_Tipo_Esc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Esc` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_escuela`";
			$sWhereWrk = "";
			$this->Id_Tipo_Esc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Esc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Esc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Esc` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Estado_Esc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Esc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Zona":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Zona` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Zona` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
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
		$usr = CurrentUserID();
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
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

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
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

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
			elm = this.GetElements("x" + infix + "_Nombre_Establecimiento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Nombre_Establecimiento->FldCaption(), $dato_establecimiento->Nombre_Establecimiento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nro_Cuise");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Nro_Cuise->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Departamento->FldCaption(), $dato_establecimiento->Id_Departamento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Localidad->FldCaption(), $dato_establecimiento->Id_Localidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Aulas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Aulas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Turnos");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Turnos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Esc[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Tipo_Esc->FldCaption(), $dato_establecimiento->Id_Tipo_Esc->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Netbook_Actuales");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Netbook_Actuales->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Esc");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Estado_Esc->FldCaption(), $dato_establecimiento->Id_Estado_Esc->ReqErrMsg)) ?>");

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
	if (ew_ValueChanged(fobj, infix, "Sigla", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nro_Cuise", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Departamento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Localidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Aulas", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Turnos", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Esc[]", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Universo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sector", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Netbook_Actuales", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado_Esc", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Zona", false)) return false;
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
fdato_establecimientolist.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdato_establecimientolist.Lists["x_Universo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientolist.Lists["x_Universo"].Options = <?php echo json_encode($dato_establecimiento->Universo->Options()) ?>;
fdato_establecimientolist.Lists["x_Sector"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientolist.Lists["x_Sector"].Options = <?php echo json_encode($dato_establecimiento->Sector->Options()) ?>;
fdato_establecimientolist.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdato_establecimientolist.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

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
		if (!$Security->CanList())
			$dato_establecimiento_list->setWarningMessage(ew_DeniedMsg());
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
<?php if ($Security->CanSearch()) { ?>
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
<?php if ($dato_establecimiento->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($dato_establecimiento->CurrentAction <> "gridadd" && $dato_establecimiento->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
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
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdato_establecimientolist" id="fdato_establecimientolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<div id="gmp_dato_establecimiento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($dato_establecimiento_list->TotalRecs > 0 || $dato_establecimiento->CurrentAction == "add" || $dato_establecimiento->CurrentAction == "copy") { ?>
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
<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Sigla) == "") { ?>
		<th data-name="Sigla"><div id="elh_dato_establecimiento_Sigla" class="dato_establecimiento_Sigla"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Sigla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sigla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Sigla) ?>',1);"><div id="elh_dato_establecimiento_Sigla" class="dato_establecimiento_Sigla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Sigla->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Sigla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Sigla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Nro_Cuise) == "") { ?>
		<th data-name="Nro_Cuise"><div id="elh_dato_establecimiento_Nro_Cuise" class="dato_establecimiento_Nro_Cuise"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Cuise"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Nro_Cuise) ?>',1);"><div id="elh_dato_establecimiento_Nro_Cuise" class="dato_establecimiento_Nro_Cuise">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Nro_Cuise->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Nro_Cuise->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Aulas) == "") { ?>
		<th data-name="Cantidad_Aulas"><div id="elh_dato_establecimiento_Cantidad_Aulas" class="dato_establecimiento_Cantidad_Aulas"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Aulas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Aulas) ?>',1);"><div id="elh_dato_establecimiento_Cantidad_Aulas" class="dato_establecimiento_Cantidad_Aulas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Cantidad_Aulas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Cantidad_Aulas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Turnos) == "") { ?>
		<th data-name="Cantidad_Turnos"><div id="elh_dato_establecimiento_Cantidad_Turnos" class="dato_establecimiento_Cantidad_Turnos"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Turnos"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Turnos) ?>',1);"><div id="elh_dato_establecimiento_Cantidad_Turnos" class="dato_establecimiento_Cantidad_Turnos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Cantidad_Turnos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Cantidad_Turnos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Id_Tipo_Esc) == "") { ?>
		<th data-name="Id_Tipo_Esc"><div id="elh_dato_establecimiento_Id_Tipo_Esc" class="dato_establecimiento_Id_Tipo_Esc"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Esc"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Id_Tipo_Esc) ?>',1);"><div id="elh_dato_establecimiento_Id_Tipo_Esc" class="dato_establecimiento_Id_Tipo_Esc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Id_Tipo_Esc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Id_Tipo_Esc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Universo) == "") { ?>
		<th data-name="Universo"><div id="elh_dato_establecimiento_Universo" class="dato_establecimiento_Universo"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Universo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Universo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Universo) ?>',1);"><div id="elh_dato_establecimiento_Universo" class="dato_establecimiento_Universo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Universo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Universo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Universo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Sector) == "") { ?>
		<th data-name="Sector"><div id="elh_dato_establecimiento_Sector" class="dato_establecimiento_Sector"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Sector->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sector"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Sector) ?>',1);"><div id="elh_dato_establecimiento_Sector" class="dato_establecimiento_Sector">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Sector->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Sector->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Sector->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Netbook_Actuales) == "") { ?>
		<th data-name="Cantidad_Netbook_Actuales"><div id="elh_dato_establecimiento_Cantidad_Netbook_Actuales" class="dato_establecimiento_Cantidad_Netbook_Actuales"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Netbook_Actuales"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Cantidad_Netbook_Actuales) ?>',1);"><div id="elh_dato_establecimiento_Cantidad_Netbook_Actuales" class="dato_establecimiento_Cantidad_Netbook_Actuales">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Cantidad_Netbook_Actuales->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Id_Estado_Esc) == "") { ?>
		<th data-name="Id_Estado_Esc"><div id="elh_dato_establecimiento_Id_Estado_Esc" class="dato_establecimiento_Id_Estado_Esc"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Esc"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Id_Estado_Esc) ?>',1);"><div id="elh_dato_establecimiento_Id_Estado_Esc" class="dato_establecimiento_Id_Estado_Esc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Id_Estado_Esc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Id_Estado_Esc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Id_Zona) == "") { ?>
		<th data-name="Id_Zona"><div id="elh_dato_establecimiento_Id_Zona" class="dato_establecimiento_Id_Zona"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Zona"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Id_Zona) ?>',1);"><div id="elh_dato_establecimiento_Id_Zona" class="dato_establecimiento_Id_Zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Id_Zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Id_Zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
	<?php if ($dato_establecimiento->SortUrl($dato_establecimiento->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_dato_establecimiento_Usuario" class="dato_establecimiento_Usuario"><div class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dato_establecimiento->SortUrl($dato_establecimiento->Usuario) ?>',1);"><div id="elh_dato_establecimiento_Usuario" class="dato_establecimiento_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dato_establecimiento->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dato_establecimiento->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	if ($dato_establecimiento->CurrentAction == "add" || $dato_establecimiento->CurrentAction == "copy") {
		$dato_establecimiento_list->RowIndex = 0;
		$dato_establecimiento_list->KeyCount = $dato_establecimiento_list->RowIndex;
		if ($dato_establecimiento->CurrentAction == "add")
			$dato_establecimiento_list->LoadDefaultValues();
		if ($dato_establecimiento->EventCancelled) // Insert failed
			$dato_establecimiento_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$dato_establecimiento->ResetAttrs();
		$dato_establecimiento->RowAttrs = array_merge($dato_establecimiento->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_dato_establecimiento', 'data-rowtype'=>EW_ROWTYPE_ADD));
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
$dato_establecimiento_list->ListOptions->Render("body", "left", $dato_establecimiento_list->RowCnt);
?>
	<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
		<td data-name="Cue">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cue" class="form-group dato_establecimiento_Cue">
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cue" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sigla" class="form-group dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sigla" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
		<td data-name="Nro_Cuise">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nro_Cuise" class="form-group dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Departamento" class="form-group dato_establecimiento_Id_Departamento">
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
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Localidad" class="form-group dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Localidad" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Localidad" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Localidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
		<td data-name="Cantidad_Aulas">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Aulas" class="form-group dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
		<td data-name="Cantidad_Turnos">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Turnos" class="form-group dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
		<td data-name="Id_Tipo_Esc">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Tipo_Esc" class="form-group dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x{$dato_establecimiento_list->RowIndex}_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Tipo_Esc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
		<td data-name="Universo">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Universo" class="form-group dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Universo" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" value="<?php echo ew_HtmlEncode($dato_establecimiento->Universo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
		<td data-name="Sector">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sector" class="form-group dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sector" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sector->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
		<td data-name="Cantidad_Netbook_Actuales">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Netbook_Actuales" class="form-group dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
		<td data-name="Id_Estado_Esc">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Estado_Esc" class="form-group dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Estado_Esc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona">
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Zona" class="form-group dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Zona" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Zona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Fecha_Actualizacion" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($dato_establecimiento->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Usuario" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($dato_establecimiento->Usuario->OldValue) ?>">
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
$dato_establecimiento_list->EditRowCnt = 0;
if ($dato_establecimiento->CurrentAction == "edit")
	$dato_establecimiento_list->RowIndex = 1;
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
		if ($dato_establecimiento->CurrentAction == "edit") {
			if ($dato_establecimiento_list->CheckInlineEditKey() && $dato_establecimiento_list->EditRowCnt == 0) { // Inline edit
				$dato_establecimiento->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($dato_establecimiento->CurrentAction == "gridedit") { // Grid edit
			if ($dato_establecimiento->EventCancelled) {
				$dato_establecimiento_list->RestoreCurrentRowFormValues($dato_establecimiento_list->RowIndex); // Restore form values
			}
			if ($dato_establecimiento_list->RowAction == "insert")
				$dato_establecimiento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$dato_establecimiento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($dato_establecimiento->CurrentAction == "edit" && $dato_establecimiento->RowType == EW_ROWTYPE_EDIT && $dato_establecimiento->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$dato_establecimiento_list->RestoreFormValues(); // Restore form values
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
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
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
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
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
	<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla"<?php echo $dato_establecimiento->Sigla->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sigla" class="form-group dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sigla" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sigla" class="form-group dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sigla" class="dato_establecimiento_Sigla">
<span<?php echo $dato_establecimiento->Sigla->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sigla->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
		<td data-name="Nro_Cuise"<?php echo $dato_establecimiento->Nro_Cuise->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nro_Cuise" class="form-group dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nro_Cuise" class="form-group dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Nro_Cuise" class="dato_establecimiento_Nro_Cuise">
<span<?php echo $dato_establecimiento->Nro_Cuise->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nro_Cuise->ListViewValue() ?></span>
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
	<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
		<td data-name="Cantidad_Aulas"<?php echo $dato_establecimiento->Cantidad_Aulas->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Aulas" class="form-group dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Aulas" class="form-group dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Aulas" class="dato_establecimiento_Cantidad_Aulas">
<span<?php echo $dato_establecimiento->Cantidad_Aulas->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Aulas->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
		<td data-name="Cantidad_Turnos"<?php echo $dato_establecimiento->Cantidad_Turnos->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Turnos" class="form-group dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Turnos" class="form-group dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Turnos" class="dato_establecimiento_Cantidad_Turnos">
<span<?php echo $dato_establecimiento->Cantidad_Turnos->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Turnos->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
		<td data-name="Id_Tipo_Esc"<?php echo $dato_establecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Tipo_Esc" class="form-group dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x{$dato_establecimiento_list->RowIndex}_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Tipo_Esc->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Tipo_Esc" class="form-group dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x{$dato_establecimiento_list->RowIndex}_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Tipo_Esc" class="dato_establecimiento_Id_Tipo_Esc">
<span<?php echo $dato_establecimiento->Id_Tipo_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Tipo_Esc->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
		<td data-name="Universo"<?php echo $dato_establecimiento->Universo->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Universo" class="form-group dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Universo" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" value="<?php echo ew_HtmlEncode($dato_establecimiento->Universo->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Universo" class="form-group dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo") ?>
</select>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Universo" class="dato_establecimiento_Universo">
<span<?php echo $dato_establecimiento->Universo->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Universo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
		<td data-name="Sector"<?php echo $dato_establecimiento->Sector->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sector" class="form-group dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sector" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sector->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sector" class="form-group dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector") ?>
</select>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Sector" class="dato_establecimiento_Sector">
<span<?php echo $dato_establecimiento->Sector->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sector->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
		<td data-name="Cantidad_Netbook_Actuales"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Netbook_Actuales" class="form-group dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Netbook_Actuales" class="form-group dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Cantidad_Netbook_Actuales" class="dato_establecimiento_Cantidad_Netbook_Actuales">
<span<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
		<td data-name="Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Estado_Esc" class="form-group dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Estado_Esc->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Estado_Esc" class="form-group dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Estado_Esc" class="dato_establecimiento_Id_Estado_Esc">
<span<?php echo $dato_establecimiento->Id_Estado_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona"<?php echo $dato_establecimiento->Id_Zona->CellAttributes() ?>>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Zona" class="form-group dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Zona" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Zona->OldValue) ?>">
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Zona" class="form-group dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($dato_establecimiento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $dato_establecimiento_list->RowCnt ?>_dato_establecimiento_Id_Zona" class="dato_establecimiento_Id_Zona">
<span<?php echo $dato_establecimiento->Id_Zona->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->ListViewValue() ?></span>
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
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cue" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td data-name="Nombre_Establecimiento">
<span id="el$rowindex$_dato_establecimiento_Nombre_Establecimiento" class="form-group dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nombre_Establecimiento" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
		<td data-name="Sigla">
<span id="el$rowindex$_dato_establecimiento_Sigla" class="form-group dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sigla" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sigla" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
		<td data-name="Nro_Cuise">
<span id="el$rowindex$_dato_establecimiento_Nro_Cuise" class="form-group dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Nro_Cuise" value="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->OldValue) ?>">
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
	<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
		<td data-name="Cantidad_Aulas">
<span id="el$rowindex$_dato_establecimiento_Cantidad_Aulas" class="form-group dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Aulas" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
		<td data-name="Cantidad_Turnos">
<span id="el$rowindex$_dato_establecimiento_Cantidad_Turnos" class="form-group dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Turnos" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
		<td data-name="Id_Tipo_Esc">
<span id="el$rowindex$_dato_establecimiento_Id_Tipo_Esc" class="form-group dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x{$dato_establecimiento_list->RowIndex}_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Tipo_Esc[]" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Tipo_Esc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
		<td data-name="Universo">
<span id="el$rowindex$_dato_establecimiento_Universo" class="form-group dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Universo") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Universo" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Universo" value="<?php echo ew_HtmlEncode($dato_establecimiento->Universo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
		<td data-name="Sector">
<span id="el$rowindex$_dato_establecimiento_Sector" class="form-group dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Sector") ?>
</select>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Sector" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Sector" value="<?php echo ew_HtmlEncode($dato_establecimiento->Sector->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
		<td data-name="Cantidad_Netbook_Actuales">
<span id="el$rowindex$_dato_establecimiento_Cantidad_Netbook_Actuales" class="form-group dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Cantidad_Netbook_Actuales" value="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
		<td data-name="Id_Estado_Esc">
<span id="el$rowindex$_dato_establecimiento_Id_Estado_Esc" class="form-group dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Estado_Esc" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Estado_Esc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
		<td data-name="Id_Zona">
<span id="el$rowindex$_dato_establecimiento_Id_Zona" class="form-group dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" name="x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona") ?>
</select>
<input type="hidden" name="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="s_x<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="dato_establecimiento" data-field="x_Id_Zona" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Id_Zona" value="<?php echo ew_HtmlEncode($dato_establecimiento->Id_Zona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Fecha_Actualizacion" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($dato_establecimiento->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="dato_establecimiento" data-field="x_Usuario" name="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" id="o<?php echo $dato_establecimiento_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($dato_establecimiento->Usuario->OldValue) ?>">
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
<?php if ($dato_establecimiento->CurrentAction == "add" || $dato_establecimiento->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" id="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" value="<?php echo $dato_establecimiento_list->KeyCount ?>">
<?php } ?>
<?php if ($dato_establecimiento->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" id="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" value="<?php echo $dato_establecimiento_list->KeyCount ?>">
<?php echo $dato_establecimiento_list->MultiSelectKey ?>
<?php } ?>
<?php if ($dato_establecimiento->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" id="<?php echo $dato_establecimiento_list->FormKeyCountName ?>" value="<?php echo $dato_establecimiento_list->KeyCount ?>">
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
