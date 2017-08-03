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

$datosestablecimiento_view = NULL; // Initialize page object first

class cdatosestablecimiento_view extends cdatosestablecimiento {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'datosestablecimiento';

	// Page object name
	var $PageObjName = 'datosestablecimiento_view';

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
		$KeyUrl = "";
		if (@$_GET["CUE"] <> "") {
			$this->RecKey["CUE"] = $_GET["CUE"];
			$KeyUrl .= "&amp;CUE=" . urlencode($this->RecKey["CUE"]);
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
				$this->Page_Terminate(ew_GetUrl("datosestablecimientolist.php"));
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
		if (@$_GET["CUE"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["CUE"]);
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
		$this->Geolocalizacion->SetVisibility();
		$this->Id_Tipo_Esc->SetVisibility();
		$this->Universo->SetVisibility();
		$this->Tiene_Programa->SetVisibility();
		$this->Sector->SetVisibility();
		$this->Cantidad_Netbook_Conig->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Id_Nivel->SetVisibility();
		$this->Id_Jornada->SetVisibility();
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
			if (@$_GET["CUE"] <> "") {
				$this->CUE->setQueryStringValue($_GET["CUE"]);
				$this->RecKey["CUE"] = $this->CUE->QueryStringValue;
			} elseif (@$_POST["CUE"] <> "") {
				$this->CUE->setFormValue($_POST["CUE"]);
				$this->RecKey["CUE"] = $this->CUE->FormValue;
			} else {
				$sReturnUrl = "datosestablecimientolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "datosestablecimientolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "datosestablecimientolist.php"; // Not page request, return to list
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

		// Geolocalizacion
		$this->Geolocalizacion->ViewValue = $this->Geolocalizacion->CurrentValue;
		$this->Geolocalizacion->ViewCustomAttributes = "";

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

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Nivel->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Nivel`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Nivel->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Nivel->ViewValue .= $this->Id_Nivel->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Nivel->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Jornada
		if (strval($this->Id_Jornada->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Jornada->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Jornada`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Jornada`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_jornada`";
		$sWhereWrk = "";
		$this->Id_Jornada->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Jornada, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Jornada->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Jornada->ViewValue .= $this->Id_Jornada->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Jornada->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Jornada->ViewValue = $this->Id_Jornada->CurrentValue;
			}
		} else {
			$this->Id_Jornada->ViewValue = NULL;
		}
		$this->Id_Jornada->ViewCustomAttributes = "";

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

			// Geolocalizacion
			$this->Geolocalizacion->LinkCustomAttributes = "";
			$this->Geolocalizacion->HrefValue = "";
			$this->Geolocalizacion->TooltipValue = "";

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

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// Id_Jornada
			$this->Id_Jornada->LinkCustomAttributes = "";
			$this->Id_Jornada->HrefValue = "";
			$this->Id_Jornada->TooltipValue = "";

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
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_datosestablecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_datosestablecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdatosestablecimientoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datosestablecimientolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($datosestablecimiento_view)) $datosestablecimiento_view = new cdatosestablecimiento_view();

// Page init
$datosestablecimiento_view->Page_Init();

// Page main
$datosestablecimiento_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datosestablecimiento_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdatosestablecimientoview = new ew_Form("fdatosestablecimientoview", "view");

// Form_CustomValidate event
fdatosestablecimientoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdatosestablecimientoview.ValidateRequired = true;
<?php } else { ?>
fdatosestablecimientoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdatosestablecimientoview.Lists["x_Id_Departamento"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdatosestablecimientoview.Lists["x_Id_Localidad"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fdatosestablecimientoview.Lists["x_Comparte_Edificio"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatosestablecimientoview.Lists["x_Comparte_Edificio"].Options = <?php echo json_encode($datosestablecimiento->Comparte_Edificio->Options()) ?>;
fdatosestablecimientoview.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdatosestablecimientoview.Lists["x_Id_Nivel[]"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fdatosestablecimientoview.Lists["x_Id_Jornada[]"] = {"LinkField":"x_Id_Jornada","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_jornada"};
fdatosestablecimientoview.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdatosestablecimientoview.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$datosestablecimiento_view->IsModal) { ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $datosestablecimiento_view->ExportOptions->Render("body") ?>
<?php
	foreach ($datosestablecimiento_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$datosestablecimiento_view->IsModal) { ?>
<?php if ($datosestablecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $datosestablecimiento_view->ShowPageHeader(); ?>
<?php
$datosestablecimiento_view->ShowMessage();
?>
<form name="fdatosestablecimientoview" id="fdatosestablecimientoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datosestablecimiento_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datosestablecimiento_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datosestablecimiento">
<?php if ($datosestablecimiento_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($datosestablecimiento->CUE->Visible) { // CUE ?>
	<tr id="r_CUE">
		<td><span id="elh_datosestablecimiento_CUE"><?php echo $datosestablecimiento->CUE->FldCaption() ?></span></td>
		<td data-name="CUE"<?php echo $datosestablecimiento->CUE->CellAttributes() ?>>
<span id="el_datosestablecimiento_CUE">
<span<?php echo $datosestablecimiento->CUE->ViewAttributes() ?>>
<?php echo $datosestablecimiento->CUE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Sigla->Visible) { // Sigla ?>
	<tr id="r_Sigla">
		<td><span id="elh_datosestablecimiento_Sigla"><?php echo $datosestablecimiento->Sigla->FldCaption() ?></span></td>
		<td data-name="Sigla"<?php echo $datosestablecimiento->Sigla->CellAttributes() ?>>
<span id="el_datosestablecimiento_Sigla">
<span<?php echo $datosestablecimiento->Sigla->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Sigla->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Establecimiento->Visible) { // Establecimiento ?>
	<tr id="r_Establecimiento">
		<td><span id="elh_datosestablecimiento_Establecimiento"><?php echo $datosestablecimiento->Establecimiento->FldCaption() ?></span></td>
		<td data-name="Establecimiento"<?php echo $datosestablecimiento->Establecimiento->CellAttributes() ?>>
<span id="el_datosestablecimiento_Establecimiento">
<span<?php echo $datosestablecimiento->Establecimiento->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Establecimiento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<tr id="r_Id_Departamento">
		<td><span id="elh_datosestablecimiento_Id_Departamento"><?php echo $datosestablecimiento->Id_Departamento->FldCaption() ?></span></td>
		<td data-name="Id_Departamento"<?php echo $datosestablecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Departamento">
<span<?php echo $datosestablecimiento->Id_Departamento->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Departamento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<tr id="r_Id_Localidad">
		<td><span id="elh_datosestablecimiento_Id_Localidad"><?php echo $datosestablecimiento->Id_Localidad->FldCaption() ?></span></td>
		<td data-name="Id_Localidad"<?php echo $datosestablecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Localidad">
<span<?php echo $datosestablecimiento->Id_Localidad->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Localidad->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio">
		<td><span id="elh_datosestablecimiento_Domicilio"><?php echo $datosestablecimiento->Domicilio->FldCaption() ?></span></td>
		<td data-name="Domicilio"<?php echo $datosestablecimiento->Domicilio->CellAttributes() ?>>
<span id="el_datosestablecimiento_Domicilio">
<span<?php echo $datosestablecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Domicilio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Telefono->Visible) { // Telefono ?>
	<tr id="r_Telefono">
		<td><span id="elh_datosestablecimiento_Telefono"><?php echo $datosestablecimiento->Telefono->FldCaption() ?></span></td>
		<td data-name="Telefono"<?php echo $datosestablecimiento->Telefono->CellAttributes() ?>>
<span id="el_datosestablecimiento_Telefono">
<span<?php echo $datosestablecimiento->Telefono->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Telefono->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Mail->Visible) { // Mail ?>
	<tr id="r_Mail">
		<td><span id="elh_datosestablecimiento_Mail"><?php echo $datosestablecimiento->Mail->FldCaption() ?></span></td>
		<td data-name="Mail"<?php echo $datosestablecimiento->Mail->CellAttributes() ?>>
<span id="el_datosestablecimiento_Mail">
<span<?php echo $datosestablecimiento->Mail->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Mail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Nro_Matricula->Visible) { // Nro Matricula ?>
	<tr id="r_Nro_Matricula">
		<td><span id="elh_datosestablecimiento_Nro_Matricula"><?php echo $datosestablecimiento->Nro_Matricula->FldCaption() ?></span></td>
		<td data-name="Nro_Matricula"<?php echo $datosestablecimiento->Nro_Matricula->CellAttributes() ?>>
<span id="el_datosestablecimiento_Nro_Matricula">
<span<?php echo $datosestablecimiento->Nro_Matricula->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Nro_Matricula->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Cantidad_Aulas->Visible) { // Cantidad Aulas ?>
	<tr id="r_Cantidad_Aulas">
		<td><span id="elh_datosestablecimiento_Cantidad_Aulas"><?php echo $datosestablecimiento->Cantidad_Aulas->FldCaption() ?></span></td>
		<td data-name="Cantidad_Aulas"<?php echo $datosestablecimiento->Cantidad_Aulas->CellAttributes() ?>>
<span id="el_datosestablecimiento_Cantidad_Aulas">
<span<?php echo $datosestablecimiento->Cantidad_Aulas->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Aulas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Comparte_Edificio->Visible) { // Comparte Edificio ?>
	<tr id="r_Comparte_Edificio">
		<td><span id="elh_datosestablecimiento_Comparte_Edificio"><?php echo $datosestablecimiento->Comparte_Edificio->FldCaption() ?></span></td>
		<td data-name="Comparte_Edificio"<?php echo $datosestablecimiento->Comparte_Edificio->CellAttributes() ?>>
<span id="el_datosestablecimiento_Comparte_Edificio">
<span<?php echo $datosestablecimiento->Comparte_Edificio->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Comparte_Edificio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<tr id="r_Cantidad_Turnos">
		<td><span id="elh_datosestablecimiento_Cantidad_Turnos"><?php echo $datosestablecimiento->Cantidad_Turnos->FldCaption() ?></span></td>
		<td data-name="Cantidad_Turnos"<?php echo $datosestablecimiento->Cantidad_Turnos->CellAttributes() ?>>
<span id="el_datosestablecimiento_Cantidad_Turnos">
<span<?php echo $datosestablecimiento->Cantidad_Turnos->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Turnos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Geolocalizacion->Visible) { // Geolocalizacion ?>
	<tr id="r_Geolocalizacion">
		<td><span id="elh_datosestablecimiento_Geolocalizacion"><?php echo $datosestablecimiento->Geolocalizacion->FldCaption() ?></span></td>
		<td data-name="Geolocalizacion"<?php echo $datosestablecimiento->Geolocalizacion->CellAttributes() ?>>
<span id="el_datosestablecimiento_Geolocalizacion">
<span<?php echo $datosestablecimiento->Geolocalizacion->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Geolocalizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<tr id="r_Id_Tipo_Esc">
		<td><span id="elh_datosestablecimiento_Id_Tipo_Esc"><?php echo $datosestablecimiento->Id_Tipo_Esc->FldCaption() ?></span></td>
		<td data-name="Id_Tipo_Esc"<?php echo $datosestablecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Tipo_Esc">
<span<?php echo $datosestablecimiento->Id_Tipo_Esc->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Tipo_Esc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Universo->Visible) { // Universo ?>
	<tr id="r_Universo">
		<td><span id="elh_datosestablecimiento_Universo"><?php echo $datosestablecimiento->Universo->FldCaption() ?></span></td>
		<td data-name="Universo"<?php echo $datosestablecimiento->Universo->CellAttributes() ?>>
<span id="el_datosestablecimiento_Universo">
<span<?php echo $datosestablecimiento->Universo->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Universo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
	<tr id="r_Tiene_Programa">
		<td><span id="elh_datosestablecimiento_Tiene_Programa"><?php echo $datosestablecimiento->Tiene_Programa->FldCaption() ?></span></td>
		<td data-name="Tiene_Programa"<?php echo $datosestablecimiento->Tiene_Programa->CellAttributes() ?>>
<span id="el_datosestablecimiento_Tiene_Programa">
<span<?php echo $datosestablecimiento->Tiene_Programa->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Tiene_Programa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Sector->Visible) { // Sector ?>
	<tr id="r_Sector">
		<td><span id="elh_datosestablecimiento_Sector"><?php echo $datosestablecimiento->Sector->FldCaption() ?></span></td>
		<td data-name="Sector"<?php echo $datosestablecimiento->Sector->CellAttributes() ?>>
<span id="el_datosestablecimiento_Sector">
<span<?php echo $datosestablecimiento->Sector->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Sector->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
	<tr id="r_Cantidad_Netbook_Conig">
		<td><span id="elh_datosestablecimiento_Cantidad_Netbook_Conig"><?php echo $datosestablecimiento->Cantidad_Netbook_Conig->FldCaption() ?></span></td>
		<td data-name="Cantidad_Netbook_Conig"<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->CellAttributes() ?>>
<span id="el_datosestablecimiento_Cantidad_Netbook_Conig">
<span<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Netbook_Conig->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<tr id="r_Nro_Cuise">
		<td><span id="elh_datosestablecimiento_Nro_Cuise"><?php echo $datosestablecimiento->Nro_Cuise->FldCaption() ?></span></td>
		<td data-name="Nro_Cuise"<?php echo $datosestablecimiento->Nro_Cuise->CellAttributes() ?>>
<span id="el_datosestablecimiento_Nro_Cuise">
<span<?php echo $datosestablecimiento->Nro_Cuise->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Nro_Cuise->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Nivel->Visible) { // Id_Nivel ?>
	<tr id="r_Id_Nivel">
		<td><span id="elh_datosestablecimiento_Id_Nivel"><?php echo $datosestablecimiento->Id_Nivel->FldCaption() ?></span></td>
		<td data-name="Id_Nivel"<?php echo $datosestablecimiento->Id_Nivel->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Nivel">
<span<?php echo $datosestablecimiento->Id_Nivel->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Nivel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Jornada->Visible) { // Id_Jornada ?>
	<tr id="r_Id_Jornada">
		<td><span id="elh_datosestablecimiento_Id_Jornada"><?php echo $datosestablecimiento->Id_Jornada->FldCaption() ?></span></td>
		<td data-name="Id_Jornada"<?php echo $datosestablecimiento->Id_Jornada->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Jornada">
<span<?php echo $datosestablecimiento->Id_Jornada->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Jornada->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
	<tr id="r_Tipo_Zona">
		<td><span id="elh_datosestablecimiento_Tipo_Zona"><?php echo $datosestablecimiento->Tipo_Zona->FldCaption() ?></span></td>
		<td data-name="Tipo_Zona"<?php echo $datosestablecimiento->Tipo_Zona->CellAttributes() ?>>
<span id="el_datosestablecimiento_Tipo_Zona">
<span<?php echo $datosestablecimiento->Tipo_Zona->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Tipo_Zona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<tr id="r_Id_Estado_Esc">
		<td><span id="elh_datosestablecimiento_Id_Estado_Esc"><?php echo $datosestablecimiento->Id_Estado_Esc->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Esc"<?php echo $datosestablecimiento->Id_Estado_Esc->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Estado_Esc">
<span<?php echo $datosestablecimiento->Id_Estado_Esc->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Estado_Esc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<tr id="r_Id_Zona">
		<td><span id="elh_datosestablecimiento_Id_Zona"><?php echo $datosestablecimiento->Id_Zona->FldCaption() ?></span></td>
		<td data-name="Id_Zona"<?php echo $datosestablecimiento->Id_Zona->CellAttributes() ?>>
<span id="el_datosestablecimiento_Id_Zona">
<span<?php echo $datosestablecimiento->Id_Zona->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Id_Zona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<tr id="r_Cantidad_Netbook_Actuales">
		<td><span id="elh_datosestablecimiento_Cantidad_Netbook_Actuales"><?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></span></td>
		<td data-name="Cantidad_Netbook_Actuales"<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<span id="el_datosestablecimiento_Cantidad_Netbook_Actuales">
<span<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Cantidad_Netbook_Actuales->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<tr id="r_Fecha_Actualizacion">
		<td><span id="elh_datosestablecimiento_Fecha_Actualizacion"><?php echo $datosestablecimiento->Fecha_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Actualizacion"<?php echo $datosestablecimiento->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_datosestablecimiento_Fecha_Actualizacion">
<span<?php echo $datosestablecimiento->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Fecha_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datosestablecimiento->Usuario->Visible) { // Usuario ?>
	<tr id="r_Usuario">
		<td><span id="elh_datosestablecimiento_Usuario"><?php echo $datosestablecimiento->Usuario->FldCaption() ?></span></td>
		<td data-name="Usuario"<?php echo $datosestablecimiento->Usuario->CellAttributes() ?>>
<span id="el_datosestablecimiento_Usuario">
<span<?php echo $datosestablecimiento->Usuario->ViewAttributes() ?>>
<?php echo $datosestablecimiento->Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($datosestablecimiento->Export == "") { ?>
<script type="text/javascript">
fdatosestablecimientoview.Init();
</script>
<?php } ?>
<?php
$datosestablecimiento_view->ShowPageFooter();
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
$datosestablecimiento_view->Page_Terminate();
?>
