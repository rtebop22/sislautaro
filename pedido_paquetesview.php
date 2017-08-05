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

$pedido_paquetes_view = NULL; // Initialize page object first

class cpedido_paquetes_view extends cpedido_paquetes {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pedido_paquetes';

	// Page object name
	var $PageObjName = 'pedido_paquetes_view';

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
		$KeyUrl = "";
		if (@$_GET["Cue"] <> "") {
			$this->RecKey["Cue"] = $_GET["Cue"];
			$KeyUrl .= "&amp;Cue=" . urlencode($this->RecKey["Cue"]);
		}
		if (@$_GET["NB0_de_Serie"] <> "") {
			$this->RecKey["NB0_de_Serie"] = $_GET["NB0_de_Serie"];
			$KeyUrl .= "&amp;NB0_de_Serie=" . urlencode($this->RecKey["NB0_de_Serie"]);
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
				$this->Page_Terminate(ew_GetUrl("pedido_paqueteslist.php"));
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
		if (@$_GET["Cue"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Cue"]);
		}
		if (@$_GET["NB0_de_Serie"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["NB0_de_Serie"]);
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
		$this->Cue->SetVisibility();
		$this->Establecimiento->SetVisibility();
		$this->Departamento->SetVisibility();
		$this->Localidad->SetVisibility();
		$this->Motivo_Pedido->SetVisibility();
		$this->NB0_de_Serie->SetVisibility();
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->SetVisibility();
		$this->ID_HARDWARE->SetVisibility();
		$this->EXTRACCID3N_DE_DATOS->SetVisibility();
		$this->MARCA_DE_ARRANQUE->SetVisibility();
		$this->TITULAR->SetVisibility();
		$this->SERIE_NETBOOK->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->CORREO_ELECTRONICO2FEMAIL->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
	var $MultiPages; // Multi pages object

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
			if (@$_GET["Cue"] <> "") {
				$this->Cue->setQueryStringValue($_GET["Cue"]);
				$this->RecKey["Cue"] = $this->Cue->QueryStringValue;
			} elseif (@$_POST["Cue"] <> "") {
				$this->Cue->setFormValue($_POST["Cue"]);
				$this->RecKey["Cue"] = $this->Cue->FormValue;
			} else {
				$sReturnUrl = "pedido_paqueteslist.php"; // Return to list
			}
			if (@$_GET["NB0_de_Serie"] <> "") {
				$this->NB0_de_Serie->setQueryStringValue($_GET["NB0_de_Serie"]);
				$this->RecKey["NB0_de_Serie"] = $this->NB0_de_Serie->QueryStringValue;
			} elseif (@$_POST["NB0_de_Serie"] <> "") {
				$this->NB0_de_Serie->setFormValue($_POST["NB0_de_Serie"]);
				$this->RecKey["NB0_de_Serie"] = $this->NB0_de_Serie->FormValue;
			} else {
				$sReturnUrl = "pedido_paqueteslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "pedido_paqueteslist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "pedido_paqueteslist.php"; // Not page request, return to list
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Establecimiento->setDbValue($rs->fields('Establecimiento'));
		$this->Departamento->setDbValue($rs->fields('Departamento'));
		$this->Localidad->setDbValue($rs->fields('Localidad'));
		$this->Motivo_Pedido->setDbValue($rs->fields('Motivo Pedido'));
		$this->NB0_de_Serie->setDbValue($rs->fields('N° de Serie'));
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->setDbValue($rs->fields('SPECIAL NUMBER o NUMERO ESPECIAL'));
		$this->ID_HARDWARE->setDbValue($rs->fields('ID HARDWARE'));
		$this->EXTRACCID3N_DE_DATOS->setDbValue($rs->fields('EXTRACCIÓN DE DATOS'));
		$this->MARCA_DE_ARRANQUE->setDbValue($rs->fields('MARCA DE ARRANQUE'));
		$this->TITULAR->setDbValue($rs->fields('TITULAR'));
		$this->SERIE_NETBOOK->setDbValue($rs->fields('SERIE NETBOOK'));
		$this->Id_Estado_Paquete->setDbValue($rs->fields('Id_Estado_Paquete'));
		$this->CORREO_ELECTRONICO2FEMAIL->setDbValue($rs->fields('CORREO ELECTRONICO/EMAIL'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Establecimiento->DbValue = $row['Establecimiento'];
		$this->Departamento->DbValue = $row['Departamento'];
		$this->Localidad->DbValue = $row['Localidad'];
		$this->Motivo_Pedido->DbValue = $row['Motivo Pedido'];
		$this->NB0_de_Serie->DbValue = $row['N° de Serie'];
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->DbValue = $row['SPECIAL NUMBER o NUMERO ESPECIAL'];
		$this->ID_HARDWARE->DbValue = $row['ID HARDWARE'];
		$this->EXTRACCID3N_DE_DATOS->DbValue = $row['EXTRACCIÓN DE DATOS'];
		$this->MARCA_DE_ARRANQUE->DbValue = $row['MARCA DE ARRANQUE'];
		$this->TITULAR->DbValue = $row['TITULAR'];
		$this->SERIE_NETBOOK->DbValue = $row['SERIE NETBOOK'];
		$this->Id_Estado_Paquete->DbValue = $row['Id_Estado_Paquete'];
		$this->CORREO_ELECTRONICO2FEMAIL->DbValue = $row['CORREO ELECTRONICO/EMAIL'];
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
		// Cue
		// Establecimiento
		// Departamento
		// Localidad
		// Motivo Pedido
		// N° de Serie
		// SPECIAL NUMBER o NUMERO ESPECIAL
		// ID HARDWARE
		// EXTRACCIÓN DE DATOS
		// MARCA DE ARRANQUE
		// TITULAR
		// SERIE NETBOOK
		// Id_Estado_Paquete
		// CORREO ELECTRONICO/EMAIL

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->ViewValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->ViewCustomAttributes = "";

		// Departamento
		$this->Departamento->ViewValue = $this->Departamento->CurrentValue;
		$this->Departamento->ViewCustomAttributes = "";

		// Localidad
		$this->Localidad->ViewValue = $this->Localidad->CurrentValue;
		$this->Localidad->ViewCustomAttributes = "";

		// Motivo Pedido
		if (strval($this->Motivo_Pedido->CurrentValue) <> "") {
			$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->Motivo_Pedido->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Motivo_Pedido->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Motivo_Pedido, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Motivo_Pedido->ViewValue = $this->Motivo_Pedido->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Motivo_Pedido->ViewValue = $this->Motivo_Pedido->CurrentValue;
			}
		} else {
			$this->Motivo_Pedido->ViewValue = NULL;
		}
		$this->Motivo_Pedido->ViewCustomAttributes = "";

		// N° de Serie
		$this->NB0_de_Serie->ViewValue = $this->NB0_de_Serie->CurrentValue;
		$this->NB0_de_Serie->ViewCustomAttributes = "";

		// SPECIAL NUMBER o NUMERO ESPECIAL
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewValue = $this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->CurrentValue;
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewCustomAttributes = "";

		// ID HARDWARE
		$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->CurrentValue;
		if (strval($this->ID_HARDWARE->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->ID_HARDWARE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->ID_HARDWARE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->ID_HARDWARE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->CurrentValue;
			}
		} else {
			$this->ID_HARDWARE->ViewValue = NULL;
		}
		$this->ID_HARDWARE->ViewCustomAttributes = "";

		// EXTRACCIÓN DE DATOS
		if (strval($this->EXTRACCID3N_DE_DATOS->CurrentValue) <> "") {
			$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->EXTRACCID3N_DE_DATOS->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->EXTRACCID3N_DE_DATOS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->EXTRACCID3N_DE_DATOS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->EXTRACCID3N_DE_DATOS->ViewValue = $this->EXTRACCID3N_DE_DATOS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->EXTRACCID3N_DE_DATOS->ViewValue = $this->EXTRACCID3N_DE_DATOS->CurrentValue;
			}
		} else {
			$this->EXTRACCID3N_DE_DATOS->ViewValue = NULL;
		}
		$this->EXTRACCID3N_DE_DATOS->ViewCustomAttributes = "";

		// MARCA DE ARRANQUE
		$this->MARCA_DE_ARRANQUE->ViewValue = $this->MARCA_DE_ARRANQUE->CurrentValue;
		$this->MARCA_DE_ARRANQUE->ViewCustomAttributes = "";

		// TITULAR
		$this->TITULAR->ViewValue = $this->TITULAR->CurrentValue;
		$this->TITULAR->ViewCustomAttributes = "";

		// SERIE NETBOOK
		if (strval($this->SERIE_NETBOOK->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->SERIE_NETBOOK->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->SERIE_NETBOOK->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SERIE_NETBOOK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->CurrentValue;
			}
		} else {
			$this->SERIE_NETBOOK->ViewValue = NULL;
		}
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// CORREO ELECTRONICO/EMAIL
		$this->CORREO_ELECTRONICO2FEMAIL->ViewValue = $this->CORREO_ELECTRONICO2FEMAIL->CurrentValue;
		$this->CORREO_ELECTRONICO2FEMAIL->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Establecimiento
			$this->Establecimiento->LinkCustomAttributes = "";
			$this->Establecimiento->HrefValue = "";
			$this->Establecimiento->TooltipValue = "";

			// Departamento
			$this->Departamento->LinkCustomAttributes = "";
			$this->Departamento->HrefValue = "";
			$this->Departamento->TooltipValue = "";

			// Localidad
			$this->Localidad->LinkCustomAttributes = "";
			$this->Localidad->HrefValue = "";
			$this->Localidad->TooltipValue = "";

			// Motivo Pedido
			$this->Motivo_Pedido->LinkCustomAttributes = "";
			$this->Motivo_Pedido->HrefValue = "";
			$this->Motivo_Pedido->TooltipValue = "";

			// N° de Serie
			$this->NB0_de_Serie->LinkCustomAttributes = "";
			$this->NB0_de_Serie->HrefValue = "";
			$this->NB0_de_Serie->TooltipValue = "";

			// SPECIAL NUMBER o NUMERO ESPECIAL
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->LinkCustomAttributes = "";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->HrefValue = "";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->TooltipValue = "";

			// ID HARDWARE
			$this->ID_HARDWARE->LinkCustomAttributes = "";
			$this->ID_HARDWARE->HrefValue = "";
			$this->ID_HARDWARE->TooltipValue = "";

			// EXTRACCIÓN DE DATOS
			$this->EXTRACCID3N_DE_DATOS->LinkCustomAttributes = "";
			$this->EXTRACCID3N_DE_DATOS->HrefValue = "";
			$this->EXTRACCID3N_DE_DATOS->TooltipValue = "";

			// MARCA DE ARRANQUE
			$this->MARCA_DE_ARRANQUE->LinkCustomAttributes = "";
			$this->MARCA_DE_ARRANQUE->HrefValue = "";
			$this->MARCA_DE_ARRANQUE->TooltipValue = "";

			// TITULAR
			$this->TITULAR->LinkCustomAttributes = "";
			$this->TITULAR->HrefValue = "";
			$this->TITULAR->TooltipValue = "";

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->LinkCustomAttributes = "";
			$this->SERIE_NETBOOK->HrefValue = "";
			$this->SERIE_NETBOOK->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// CORREO ELECTRONICO/EMAIL
			$this->CORREO_ELECTRONICO2FEMAIL->LinkCustomAttributes = "";
			$this->CORREO_ELECTRONICO2FEMAIL->HrefValue = "";
			$this->CORREO_ELECTRONICO2FEMAIL->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_pedido_paquetes\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pedido_paquetes',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpedido_paquetesview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pedido_paqueteslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$this->MultiPages = $pages;
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
if (!isset($pedido_paquetes_view)) $pedido_paquetes_view = new cpedido_paquetes_view();

// Page init
$pedido_paquetes_view->Page_Init();

// Page main
$pedido_paquetes_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pedido_paquetes_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpedido_paquetesview = new ew_Form("fpedido_paquetesview", "view");

// Form_CustomValidate event
fpedido_paquetesview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpedido_paquetesview.ValidateRequired = true;
<?php } else { ?>
fpedido_paquetesview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fpedido_paquetesview.MultiPage = new ew_MultiPage("fpedido_paquetesview");

// Dynamic selection lists
fpedido_paquetesview.Lists["x_Motivo_Pedido"] = {"LinkField":"x_Detalle","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpedido_paquetesview.Lists["x_ID_HARDWARE"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpedido_paquetesview.Lists["x_EXTRACCID3N_DE_DATOS"] = {"LinkField":"x_Detalle","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpedido_paquetesview.Lists["x_SERIE_NETBOOK"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$pedido_paquetes_view->IsModal) { ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $pedido_paquetes_view->ExportOptions->Render("body") ?>
<?php
	foreach ($pedido_paquetes_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$pedido_paquetes_view->IsModal) { ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pedido_paquetes_view->ShowPageHeader(); ?>
<?php
$pedido_paquetes_view->ShowMessage();
?>
<form name="fpedido_paquetesview" id="fpedido_paquetesview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pedido_paquetes_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pedido_paquetes_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pedido_paquetes">
<?php if ($pedido_paquetes_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
<div class="ewMultiPage">
<div class="panel-group" id="pedido_paquetes_view">
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
	<div class="panel panel-default<?php echo $pedido_paquetes_view->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pedido_paquetes_view" href="#tab_pedido_paquetes1"><?php echo $pedido_paquetes->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pedido_paquetes_view->MultiPages->PageStyle("1") ?>" id="tab_pedido_paquetes1">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pedido_paquetes->Cue->Visible) { // Cue ?>
	<tr id="r_Cue">
		<td><span id="elh_pedido_paquetes_Cue"><?php echo $pedido_paquetes->Cue->FldCaption() ?></span></td>
		<td data-name="Cue"<?php echo $pedido_paquetes->Cue->CellAttributes() ?>>
<span id="el_pedido_paquetes_Cue" data-page="1">
<span<?php echo $pedido_paquetes->Cue->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Cue->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->Establecimiento->Visible) { // Establecimiento ?>
	<tr id="r_Establecimiento">
		<td><span id="elh_pedido_paquetes_Establecimiento"><?php echo $pedido_paquetes->Establecimiento->FldCaption() ?></span></td>
		<td data-name="Establecimiento"<?php echo $pedido_paquetes->Establecimiento->CellAttributes() ?>>
<span id="el_pedido_paquetes_Establecimiento" data-page="1">
<span<?php echo $pedido_paquetes->Establecimiento->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Establecimiento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->Departamento->Visible) { // Departamento ?>
	<tr id="r_Departamento">
		<td><span id="elh_pedido_paquetes_Departamento"><?php echo $pedido_paquetes->Departamento->FldCaption() ?></span></td>
		<td data-name="Departamento"<?php echo $pedido_paquetes->Departamento->CellAttributes() ?>>
<span id="el_pedido_paquetes_Departamento" data-page="1">
<span<?php echo $pedido_paquetes->Departamento->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Departamento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->Localidad->Visible) { // Localidad ?>
	<tr id="r_Localidad">
		<td><span id="elh_pedido_paquetes_Localidad"><?php echo $pedido_paquetes->Localidad->FldCaption() ?></span></td>
		<td data-name="Localidad"<?php echo $pedido_paquetes->Localidad->CellAttributes() ?>>
<span id="el_pedido_paquetes_Localidad" data-page="1">
<span<?php echo $pedido_paquetes->Localidad->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Localidad->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pedido_paquetes->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
	<div class="panel panel-default<?php echo $pedido_paquetes_view->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pedido_paquetes_view" href="#tab_pedido_paquetes2"><?php echo $pedido_paquetes->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pedido_paquetes_view->MultiPages->PageStyle("2") ?>" id="tab_pedido_paquetes2">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pedido_paquetes->Motivo_Pedido->Visible) { // Motivo Pedido ?>
	<tr id="r_Motivo_Pedido">
		<td><span id="elh_pedido_paquetes_Motivo_Pedido"><?php echo $pedido_paquetes->Motivo_Pedido->FldCaption() ?></span></td>
		<td data-name="Motivo_Pedido"<?php echo $pedido_paquetes->Motivo_Pedido->CellAttributes() ?>>
<span id="el_pedido_paquetes_Motivo_Pedido" data-page="2">
<span<?php echo $pedido_paquetes->Motivo_Pedido->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Motivo_Pedido->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->NB0_de_Serie->Visible) { // N° de Serie ?>
	<tr id="r_NB0_de_Serie">
		<td><span id="elh_pedido_paquetes_NB0_de_Serie"><?php echo $pedido_paquetes->NB0_de_Serie->FldCaption() ?></span></td>
		<td data-name="NB0_de_Serie"<?php echo $pedido_paquetes->NB0_de_Serie->CellAttributes() ?>>
<span id="el_pedido_paquetes_NB0_de_Serie" data-page="2">
<span<?php echo $pedido_paquetes->NB0_de_Serie->ViewAttributes() ?>>
<?php echo $pedido_paquetes->NB0_de_Serie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->Visible) { // SPECIAL NUMBER o NUMERO ESPECIAL ?>
	<tr id="r_SPECIAL_NUMBER_o_NUMERO_ESPECIAL">
		<td><span id="elh_pedido_paquetes_SPECIAL_NUMBER_o_NUMERO_ESPECIAL"><?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->FldCaption() ?></span></td>
		<td data-name="SPECIAL_NUMBER_o_NUMERO_ESPECIAL"<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->CellAttributes() ?>>
<span id="el_pedido_paquetes_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" data-page="2">
<span<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewAttributes() ?>>
<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->ID_HARDWARE->Visible) { // ID HARDWARE ?>
	<tr id="r_ID_HARDWARE">
		<td><span id="elh_pedido_paquetes_ID_HARDWARE"><?php echo $pedido_paquetes->ID_HARDWARE->FldCaption() ?></span></td>
		<td data-name="ID_HARDWARE"<?php echo $pedido_paquetes->ID_HARDWARE->CellAttributes() ?>>
<span id="el_pedido_paquetes_ID_HARDWARE" data-page="2">
<span<?php echo $pedido_paquetes->ID_HARDWARE->ViewAttributes() ?>>
<?php echo $pedido_paquetes->ID_HARDWARE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->EXTRACCID3N_DE_DATOS->Visible) { // EXTRACCIÓN DE DATOS ?>
	<tr id="r_EXTRACCID3N_DE_DATOS">
		<td><span id="elh_pedido_paquetes_EXTRACCID3N_DE_DATOS"><?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->FldCaption() ?></span></td>
		<td data-name="EXTRACCID3N_DE_DATOS"<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->CellAttributes() ?>>
<span id="el_pedido_paquetes_EXTRACCID3N_DE_DATOS" data-page="2">
<span<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->ViewAttributes() ?>>
<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->MARCA_DE_ARRANQUE->Visible) { // MARCA DE ARRANQUE ?>
	<tr id="r_MARCA_DE_ARRANQUE">
		<td><span id="elh_pedido_paquetes_MARCA_DE_ARRANQUE"><?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->FldCaption() ?></span></td>
		<td data-name="MARCA_DE_ARRANQUE"<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->CellAttributes() ?>>
<span id="el_pedido_paquetes_MARCA_DE_ARRANQUE" data-page="2">
<span<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->ViewAttributes() ?>>
<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->TITULAR->Visible) { // TITULAR ?>
	<tr id="r_TITULAR">
		<td><span id="elh_pedido_paquetes_TITULAR"><?php echo $pedido_paquetes->TITULAR->FldCaption() ?></span></td>
		<td data-name="TITULAR"<?php echo $pedido_paquetes->TITULAR->CellAttributes() ?>>
<span id="el_pedido_paquetes_TITULAR" data-page="2">
<span<?php echo $pedido_paquetes->TITULAR->ViewAttributes() ?>>
<?php echo $pedido_paquetes->TITULAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->SERIE_NETBOOK->Visible) { // SERIE NETBOOK ?>
	<tr id="r_SERIE_NETBOOK">
		<td><span id="elh_pedido_paquetes_SERIE_NETBOOK"><?php echo $pedido_paquetes->SERIE_NETBOOK->FldCaption() ?></span></td>
		<td data-name="SERIE_NETBOOK"<?php echo $pedido_paquetes->SERIE_NETBOOK->CellAttributes() ?>>
<span id="el_pedido_paquetes_SERIE_NETBOOK" data-page="2">
<span<?php echo $pedido_paquetes->SERIE_NETBOOK->ViewAttributes() ?>>
<?php echo $pedido_paquetes->SERIE_NETBOOK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<tr id="r_Id_Estado_Paquete">
		<td><span id="elh_pedido_paquetes_Id_Estado_Paquete"><?php echo $pedido_paquetes->Id_Estado_Paquete->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Paquete"<?php echo $pedido_paquetes->Id_Estado_Paquete->CellAttributes() ?>>
<span id="el_pedido_paquetes_Id_Estado_Paquete" data-page="2">
<span<?php echo $pedido_paquetes->Id_Estado_Paquete->ViewAttributes() ?>>
<?php echo $pedido_paquetes->Id_Estado_Paquete->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->Visible) { // CORREO ELECTRONICO/EMAIL ?>
	<tr id="r_CORREO_ELECTRONICO2FEMAIL">
		<td><span id="elh_pedido_paquetes_CORREO_ELECTRONICO2FEMAIL"><?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->FldCaption() ?></span></td>
		<td data-name="CORREO_ELECTRONICO2FEMAIL"<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->CellAttributes() ?>>
<span id="el_pedido_paquetes_CORREO_ELECTRONICO2FEMAIL" data-page="2">
<span<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->ViewAttributes() ?>>
<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pedido_paquetes->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<?php if ($pedido_paquetes->Export == "") { ?>
<script type="text/javascript">
fpedido_paquetesview.Init();
</script>
<?php } ?>
<?php
$pedido_paquetes_view->ShowPageFooter();
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
$pedido_paquetes_view->Page_Terminate();
?>
