<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "todas_atencionesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$todas_atenciones_view = NULL; // Initialize page object first

class ctodas_atenciones_view extends ctodas_atenciones {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'todas_atenciones';

	// Page object name
	var $PageObjName = 'todas_atenciones_view';

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

		// Table object (todas_atenciones)
		if (!isset($GLOBALS["todas_atenciones"]) || get_class($GLOBALS["todas_atenciones"]) == "ctodas_atenciones") {
			$GLOBALS["todas_atenciones"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["todas_atenciones"];
		}
		$KeyUrl = "";
		if (@$_GET["NB0_Atencion"] <> "") {
			$this->RecKey["NB0_Atencion"] = $_GET["NB0_Atencion"];
			$KeyUrl .= "&amp;NB0_Atencion=" . urlencode($this->RecKey["NB0_Atencion"]);
		}
		if (@$_GET["Serie_Equipo"] <> "") {
			$this->RecKey["Serie_Equipo"] = $_GET["Serie_Equipo"];
			$KeyUrl .= "&amp;Serie_Equipo=" . urlencode($this->RecKey["Serie_Equipo"]);
		}
		if (@$_GET["Dni"] <> "") {
			$this->RecKey["Dni"] = $_GET["Dni"];
			$KeyUrl .= "&amp;Dni=" . urlencode($this->RecKey["Dni"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'todas_atenciones', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("todas_atencioneslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
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
		if (@$_GET["NB0_Atencion"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["NB0_Atencion"]);
		}
		if (@$_GET["Serie_Equipo"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Serie_Equipo"]);
		}
		if (@$_GET["Dni"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Dni"]);
		}

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

		// Setup export options
		$this->SetupExportOptions();
		$this->NB0_Atencion->SetVisibility();
		$this->NB0_Atencion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Equipo->SetVisibility();
		$this->Fecha_Entrada->SetVisibility();
		$this->Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Usuario_que_cargo->SetVisibility();
		$this->Descripcion_Problema->SetVisibility();
		$this->Id_Tipo_Falla->SetVisibility();
		$this->Id_Problema->SetVisibility();
		$this->Id_Tipo_Sol_Problem->SetVisibility();
		$this->Id_Estado_Atenc->SetVisibility();
		$this->Ultima_Actualizacion->SetVisibility();

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

		// Create Token
		$this->CreateToken();
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
		global $EW_EXPORT, $todas_atenciones;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($todas_atenciones);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["NB0_Atencion"] <> "") {
				$this->NB0_Atencion->setQueryStringValue($_GET["NB0_Atencion"]);
				$this->RecKey["NB0_Atencion"] = $this->NB0_Atencion->QueryStringValue;
			} elseif (@$_POST["NB0_Atencion"] <> "") {
				$this->NB0_Atencion->setFormValue($_POST["NB0_Atencion"]);
				$this->RecKey["NB0_Atencion"] = $this->NB0_Atencion->FormValue;
			} else {
				$sReturnUrl = "todas_atencioneslist.php"; // Return to list
			}
			if (@$_GET["Serie_Equipo"] <> "") {
				$this->Serie_Equipo->setQueryStringValue($_GET["Serie_Equipo"]);
				$this->RecKey["Serie_Equipo"] = $this->Serie_Equipo->QueryStringValue;
			} elseif (@$_POST["Serie_Equipo"] <> "") {
				$this->Serie_Equipo->setFormValue($_POST["Serie_Equipo"]);
				$this->RecKey["Serie_Equipo"] = $this->Serie_Equipo->FormValue;
			} else {
				$sReturnUrl = "todas_atencioneslist.php"; // Return to list
			}
			if (@$_GET["Dni"] <> "") {
				$this->Dni->setQueryStringValue($_GET["Dni"]);
				$this->RecKey["Dni"] = $this->Dni->QueryStringValue;
			} elseif (@$_POST["Dni"] <> "") {
				$this->Dni->setFormValue($_POST["Dni"]);
				$this->RecKey["Dni"] = $this->Dni->FormValue;
			} else {
				$sReturnUrl = "todas_atencioneslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "todas_atencioneslist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "todas_atencioneslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->NB0_Atencion->setDbValue($rs->fields('N° Atencion'));
		$this->Serie_Equipo->setDbValue($rs->fields('Serie Equipo'));
		$this->Fecha_Entrada->setDbValue($rs->fields('Fecha Entrada'));
		$this->Nombre_Titular->setDbValue($rs->fields('Nombre Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Usuario_que_cargo->setDbValue($rs->fields('Usuario que cargo'));
		$this->Descripcion_Problema->setDbValue($rs->fields('Descripcion Problema'));
		$this->Id_Tipo_Falla->setDbValue($rs->fields('Id_Tipo_Falla'));
		$this->Id_Problema->setDbValue($rs->fields('Id_Problema'));
		$this->Id_Tipo_Sol_Problem->setDbValue($rs->fields('Id_Tipo_Sol_Problem'));
		$this->Id_Estado_Atenc->setDbValue($rs->fields('Id_Estado_Atenc'));
		$this->Ultima_Actualizacion->setDbValue($rs->fields('Ultima Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NB0_Atencion->DbValue = $row['N° Atencion'];
		$this->Serie_Equipo->DbValue = $row['Serie Equipo'];
		$this->Fecha_Entrada->DbValue = $row['Fecha Entrada'];
		$this->Nombre_Titular->DbValue = $row['Nombre Titular'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Usuario_que_cargo->DbValue = $row['Usuario que cargo'];
		$this->Descripcion_Problema->DbValue = $row['Descripcion Problema'];
		$this->Id_Tipo_Falla->DbValue = $row['Id_Tipo_Falla'];
		$this->Id_Problema->DbValue = $row['Id_Problema'];
		$this->Id_Tipo_Sol_Problem->DbValue = $row['Id_Tipo_Sol_Problem'];
		$this->Id_Estado_Atenc->DbValue = $row['Id_Estado_Atenc'];
		$this->Ultima_Actualizacion->DbValue = $row['Ultima Actualizacion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// N° Atencion
		// Serie Equipo
		// Fecha Entrada
		// Nombre Titular
		// Dni
		// Usuario que cargo
		// Descripcion Problema
		// Id_Tipo_Falla
		// Id_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Ultima Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// N° Atencion
		$this->NB0_Atencion->ViewValue = $this->NB0_Atencion->CurrentValue;
		$this->NB0_Atencion->ViewCustomAttributes = "";

		// Serie Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 0);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Nombre Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Usuario que cargo
		$this->Usuario_que_cargo->ViewValue = $this->Usuario_que_cargo->CurrentValue;
		$this->Usuario_que_cargo->ViewCustomAttributes = "";

		// Descripcion Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
		$this->Id_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 0);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

			// N° Atencion
			$this->NB0_Atencion->LinkCustomAttributes = "";
			$this->NB0_Atencion->HrefValue = "";
			$this->NB0_Atencion->TooltipValue = "";

			// Serie Equipo
			$this->Serie_Equipo->LinkCustomAttributes = "";
			$this->Serie_Equipo->HrefValue = "";
			$this->Serie_Equipo->TooltipValue = "";

			// Fecha Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Nombre Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Usuario que cargo
			$this->Usuario_que_cargo->LinkCustomAttributes = "";
			$this->Usuario_que_cargo->HrefValue = "";
			$this->Usuario_que_cargo->TooltipValue = "";

			// Descripcion Problema
			$this->Descripcion_Problema->LinkCustomAttributes = "";
			$this->Descripcion_Problema->HrefValue = "";
			$this->Descripcion_Problema->TooltipValue = "";

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->LinkCustomAttributes = "";
			$this->Id_Tipo_Falla->HrefValue = "";
			$this->Id_Tipo_Falla->TooltipValue = "";

			// Id_Problema
			$this->Id_Problema->LinkCustomAttributes = "";
			$this->Id_Problema->HrefValue = "";
			$this->Id_Problema->TooltipValue = "";

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->HrefValue = "";
			$this->Id_Tipo_Sol_Problem->TooltipValue = "";

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->LinkCustomAttributes = "";
			$this->Id_Estado_Atenc->HrefValue = "";
			$this->Id_Estado_Atenc->TooltipValue = "";

			// Ultima Actualizacion
			$this->Ultima_Actualizacion->LinkCustomAttributes = "";
			$this->Ultima_Actualizacion->HrefValue = "";
			$this->Ultima_Actualizacion->TooltipValue = "";
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
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_todas_atenciones\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_todas_atenciones',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftodas_atencionesview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

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
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("todas_atencioneslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($todas_atenciones_view)) $todas_atenciones_view = new ctodas_atenciones_view();

// Page init
$todas_atenciones_view->Page_Init();

// Page main
$todas_atenciones_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$todas_atenciones_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ftodas_atencionesview = new ew_Form("ftodas_atencionesview", "view");

// Form_CustomValidate event
ftodas_atencionesview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftodas_atencionesview.ValidateRequired = true;
<?php } else { ?>
ftodas_atencionesview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($todas_atenciones->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$todas_atenciones_view->IsModal) { ?>
<?php if ($todas_atenciones->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $todas_atenciones_view->ExportOptions->Render("body") ?>
<?php
	foreach ($todas_atenciones_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$todas_atenciones_view->IsModal) { ?>
<?php if ($todas_atenciones->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $todas_atenciones_view->ShowPageHeader(); ?>
<?php
$todas_atenciones_view->ShowMessage();
?>
<form name="ftodas_atencionesview" id="ftodas_atencionesview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($todas_atenciones_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $todas_atenciones_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="todas_atenciones">
<?php if ($todas_atenciones_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($todas_atenciones->NB0_Atencion->Visible) { // N° Atencion ?>
	<tr id="r_NB0_Atencion">
		<td><span id="elh_todas_atenciones_NB0_Atencion"><?php echo $todas_atenciones->NB0_Atencion->FldCaption() ?></span></td>
		<td data-name="NB0_Atencion"<?php echo $todas_atenciones->NB0_Atencion->CellAttributes() ?>>
<span id="el_todas_atenciones_NB0_Atencion">
<span<?php echo $todas_atenciones->NB0_Atencion->ViewAttributes() ?>>
<?php echo $todas_atenciones->NB0_Atencion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Serie_Equipo->Visible) { // Serie Equipo ?>
	<tr id="r_Serie_Equipo">
		<td><span id="elh_todas_atenciones_Serie_Equipo"><?php echo $todas_atenciones->Serie_Equipo->FldCaption() ?></span></td>
		<td data-name="Serie_Equipo"<?php echo $todas_atenciones->Serie_Equipo->CellAttributes() ?>>
<span id="el_todas_atenciones_Serie_Equipo">
<span<?php echo $todas_atenciones->Serie_Equipo->ViewAttributes() ?>>
<?php echo $todas_atenciones->Serie_Equipo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Fecha_Entrada->Visible) { // Fecha Entrada ?>
	<tr id="r_Fecha_Entrada">
		<td><span id="elh_todas_atenciones_Fecha_Entrada"><?php echo $todas_atenciones->Fecha_Entrada->FldCaption() ?></span></td>
		<td data-name="Fecha_Entrada"<?php echo $todas_atenciones->Fecha_Entrada->CellAttributes() ?>>
<span id="el_todas_atenciones_Fecha_Entrada">
<span<?php echo $todas_atenciones->Fecha_Entrada->ViewAttributes() ?>>
<?php echo $todas_atenciones->Fecha_Entrada->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Nombre_Titular->Visible) { // Nombre Titular ?>
	<tr id="r_Nombre_Titular">
		<td><span id="elh_todas_atenciones_Nombre_Titular"><?php echo $todas_atenciones->Nombre_Titular->FldCaption() ?></span></td>
		<td data-name="Nombre_Titular"<?php echo $todas_atenciones->Nombre_Titular->CellAttributes() ?>>
<span id="el_todas_atenciones_Nombre_Titular">
<span<?php echo $todas_atenciones->Nombre_Titular->ViewAttributes() ?>>
<?php echo $todas_atenciones->Nombre_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Dni->Visible) { // Dni ?>
	<tr id="r_Dni">
		<td><span id="elh_todas_atenciones_Dni"><?php echo $todas_atenciones->Dni->FldCaption() ?></span></td>
		<td data-name="Dni"<?php echo $todas_atenciones->Dni->CellAttributes() ?>>
<span id="el_todas_atenciones_Dni">
<span<?php echo $todas_atenciones->Dni->ViewAttributes() ?>>
<?php echo $todas_atenciones->Dni->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Usuario_que_cargo->Visible) { // Usuario que cargo ?>
	<tr id="r_Usuario_que_cargo">
		<td><span id="elh_todas_atenciones_Usuario_que_cargo"><?php echo $todas_atenciones->Usuario_que_cargo->FldCaption() ?></span></td>
		<td data-name="Usuario_que_cargo"<?php echo $todas_atenciones->Usuario_que_cargo->CellAttributes() ?>>
<span id="el_todas_atenciones_Usuario_que_cargo">
<span<?php echo $todas_atenciones->Usuario_que_cargo->ViewAttributes() ?>>
<?php echo $todas_atenciones->Usuario_que_cargo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Descripcion_Problema->Visible) { // Descripcion Problema ?>
	<tr id="r_Descripcion_Problema">
		<td><span id="elh_todas_atenciones_Descripcion_Problema"><?php echo $todas_atenciones->Descripcion_Problema->FldCaption() ?></span></td>
		<td data-name="Descripcion_Problema"<?php echo $todas_atenciones->Descripcion_Problema->CellAttributes() ?>>
<span id="el_todas_atenciones_Descripcion_Problema">
<span<?php echo $todas_atenciones->Descripcion_Problema->ViewAttributes() ?>>
<?php echo $todas_atenciones->Descripcion_Problema->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
	<tr id="r_Id_Tipo_Falla">
		<td><span id="elh_todas_atenciones_Id_Tipo_Falla"><?php echo $todas_atenciones->Id_Tipo_Falla->FldCaption() ?></span></td>
		<td data-name="Id_Tipo_Falla"<?php echo $todas_atenciones->Id_Tipo_Falla->CellAttributes() ?>>
<span id="el_todas_atenciones_Id_Tipo_Falla">
<span<?php echo $todas_atenciones->Id_Tipo_Falla->ViewAttributes() ?>>
<?php echo $todas_atenciones->Id_Tipo_Falla->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Id_Problema->Visible) { // Id_Problema ?>
	<tr id="r_Id_Problema">
		<td><span id="elh_todas_atenciones_Id_Problema"><?php echo $todas_atenciones->Id_Problema->FldCaption() ?></span></td>
		<td data-name="Id_Problema"<?php echo $todas_atenciones->Id_Problema->CellAttributes() ?>>
<span id="el_todas_atenciones_Id_Problema">
<span<?php echo $todas_atenciones->Id_Problema->ViewAttributes() ?>>
<?php echo $todas_atenciones->Id_Problema->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
	<tr id="r_Id_Tipo_Sol_Problem">
		<td><span id="elh_todas_atenciones_Id_Tipo_Sol_Problem"><?php echo $todas_atenciones->Id_Tipo_Sol_Problem->FldCaption() ?></span></td>
		<td data-name="Id_Tipo_Sol_Problem"<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->CellAttributes() ?>>
<span id="el_todas_atenciones_Id_Tipo_Sol_Problem">
<span<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->ViewAttributes() ?>>
<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
	<tr id="r_Id_Estado_Atenc">
		<td><span id="elh_todas_atenciones_Id_Estado_Atenc"><?php echo $todas_atenciones->Id_Estado_Atenc->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Atenc"<?php echo $todas_atenciones->Id_Estado_Atenc->CellAttributes() ?>>
<span id="el_todas_atenciones_Id_Estado_Atenc">
<span<?php echo $todas_atenciones->Id_Estado_Atenc->ViewAttributes() ?>>
<?php echo $todas_atenciones->Id_Estado_Atenc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($todas_atenciones->Ultima_Actualizacion->Visible) { // Ultima Actualizacion ?>
	<tr id="r_Ultima_Actualizacion">
		<td><span id="elh_todas_atenciones_Ultima_Actualizacion"><?php echo $todas_atenciones->Ultima_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Ultima_Actualizacion"<?php echo $todas_atenciones->Ultima_Actualizacion->CellAttributes() ?>>
<span id="el_todas_atenciones_Ultima_Actualizacion">
<span<?php echo $todas_atenciones->Ultima_Actualizacion->ViewAttributes() ?>>
<?php echo $todas_atenciones->Ultima_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">
ftodas_atencionesview.Init();
</script>
<?php } ?>
<?php
$todas_atenciones_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($todas_atenciones->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$todas_atenciones_view->Page_Terminate();
?>
