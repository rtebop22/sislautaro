<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pase_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pase_establecimiento_view = NULL; // Initialize page object first

class cpase_establecimiento_view extends cpase_establecimiento {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pase_establecimiento';

	// Page object name
	var $PageObjName = 'pase_establecimiento_view';

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

		// Table object (pase_establecimiento)
		if (!isset($GLOBALS["pase_establecimiento"]) || get_class($GLOBALS["pase_establecimiento"]) == "cpase_establecimiento") {
			$GLOBALS["pase_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pase_establecimiento"];
		}
		$KeyUrl = "";
		if (@$_GET["Id_Pase"] <> "") {
			$this->RecKey["Id_Pase"] = $_GET["Id_Pase"];
			$KeyUrl .= "&amp;Id_Pase=" . urlencode($this->RecKey["Id_Pase"]);
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
			define("EW_TABLE_NAME", 'pase_establecimiento', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pase_establecimientolist.php"));
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
		if (@$_GET["Id_Pase"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Id_Pase"]);
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
		$this->Id_Pase->SetVisibility();
		$this->Id_Pase->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Equipo->SetVisibility();
		$this->Fecha_Pase->SetVisibility();
		$this->Id_Estado_Pase->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Modelo_Net->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Nombre_Titular->SetVisibility();
		$this->Dni_Titular->SetVisibility();
		$this->Cuil_Titular->SetVisibility();
		$this->DniTutor->SetVisibility();
		$this->Nombre_Tutor->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Tel_Tutor->SetVisibility();
		$this->CelTutor->SetVisibility();
		$this->Cue_Establecimiento_Alta->SetVisibility();
		$this->Escuela_Alta->SetVisibility();
		$this->Directivo_Alta->SetVisibility();
		$this->Cuil_Directivo_Alta->SetVisibility();
		$this->Dpto_Esc_alta->SetVisibility();
		$this->Localidad_Esc_Alta->SetVisibility();
		$this->Domicilio_Esc_Alta->SetVisibility();
		$this->Rte_Alta->SetVisibility();
		$this->Tel_Rte_Acta->SetVisibility();
		$this->Email_Rte_Alta->SetVisibility();
		$this->Serie_Server_Alta->SetVisibility();
		$this->Cue_Establecimiento_Baja->SetVisibility();
		$this->Escuela_Baja->SetVisibility();
		$this->Directivo_Baja->SetVisibility();
		$this->Cuil_Directivo_Baja->SetVisibility();
		$this->Dpto_Esc_Baja->SetVisibility();
		$this->Localidad_Esc_Baja->SetVisibility();
		$this->Domicilio_Esc_Baja->SetVisibility();
		$this->Rte_Baja->SetVisibility();
		$this->Tel_Rte_Baja->SetVisibility();
		$this->Email_Rte_Baja->SetVisibility();
		$this->Serie_Server_Baja->SetVisibility();
		$this->Ruta_Archivo->SetVisibility();

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
		global $EW_EXPORT, $pase_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pase_establecimiento);
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
			if (@$_GET["Id_Pase"] <> "") {
				$this->Id_Pase->setQueryStringValue($_GET["Id_Pase"]);
				$this->RecKey["Id_Pase"] = $this->Id_Pase->QueryStringValue;
			} elseif (@$_POST["Id_Pase"] <> "") {
				$this->Id_Pase->setFormValue($_POST["Id_Pase"]);
				$this->RecKey["Id_Pase"] = $this->Id_Pase->FormValue;
			} else {
				$sReturnUrl = "pase_establecimientolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "pase_establecimientolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "pase_establecimientolist.php"; // Not page request, return to list
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

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
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
		$this->Id_Pase->setDbValue($rs->fields('Id_Pase'));
		$this->Serie_Equipo->setDbValue($rs->fields('Serie_Equipo'));
		$this->Fecha_Pase->setDbValue($rs->fields('Fecha_Pase'));
		$this->Id_Estado_Pase->setDbValue($rs->fields('Id_Estado_Pase'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Modelo_Net->setDbValue($rs->fields('Modelo_Net'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Nombre_Titular->setDbValue($rs->fields('Nombre_Titular'));
		$this->Dni_Titular->setDbValue($rs->fields('Dni_Titular'));
		$this->Cuil_Titular->setDbValue($rs->fields('Cuil_Titular'));
		$this->DniTutor->setDbValue($rs->fields('DniTutor'));
		$this->Nombre_Tutor->setDbValue($rs->fields('Nombre_Tutor'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Tel_Tutor->setDbValue($rs->fields('Tel_Tutor'));
		$this->CelTutor->setDbValue($rs->fields('CelTutor'));
		$this->Cue_Establecimiento_Alta->setDbValue($rs->fields('Cue_Establecimiento_Alta'));
		$this->Escuela_Alta->setDbValue($rs->fields('Escuela_Alta'));
		$this->Directivo_Alta->setDbValue($rs->fields('Directivo_Alta'));
		$this->Cuil_Directivo_Alta->setDbValue($rs->fields('Cuil_Directivo_Alta'));
		$this->Dpto_Esc_alta->setDbValue($rs->fields('Dpto_Esc_alta'));
		$this->Localidad_Esc_Alta->setDbValue($rs->fields('Localidad_Esc_Alta'));
		$this->Domicilio_Esc_Alta->setDbValue($rs->fields('Domicilio_Esc_Alta'));
		$this->Rte_Alta->setDbValue($rs->fields('Rte_Alta'));
		$this->Tel_Rte_Acta->setDbValue($rs->fields('Tel_Rte_Acta'));
		$this->Email_Rte_Alta->setDbValue($rs->fields('Email_Rte_Alta'));
		$this->Serie_Server_Alta->setDbValue($rs->fields('Serie_Server_Alta'));
		$this->Cue_Establecimiento_Baja->setDbValue($rs->fields('Cue_Establecimiento_Baja'));
		$this->Escuela_Baja->setDbValue($rs->fields('Escuela_Baja'));
		$this->Directivo_Baja->setDbValue($rs->fields('Directivo_Baja'));
		$this->Cuil_Directivo_Baja->setDbValue($rs->fields('Cuil_Directivo_Baja'));
		$this->Dpto_Esc_Baja->setDbValue($rs->fields('Dpto_Esc_Baja'));
		$this->Localidad_Esc_Baja->setDbValue($rs->fields('Localidad_Esc_Baja'));
		$this->Domicilio_Esc_Baja->setDbValue($rs->fields('Domicilio_Esc_Baja'));
		$this->Rte_Baja->setDbValue($rs->fields('Rte_Baja'));
		$this->Tel_Rte_Baja->setDbValue($rs->fields('Tel_Rte_Baja'));
		$this->Email_Rte_Baja->setDbValue($rs->fields('Email_Rte_Baja'));
		$this->Serie_Server_Baja->setDbValue($rs->fields('Serie_Server_Baja'));
		$this->Ruta_Archivo->Upload->DbValue = $rs->fields('Ruta_Archivo');
		$this->Ruta_Archivo->CurrentValue = $this->Ruta_Archivo->Upload->DbValue;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Pase->DbValue = $row['Id_Pase'];
		$this->Serie_Equipo->DbValue = $row['Serie_Equipo'];
		$this->Fecha_Pase->DbValue = $row['Fecha_Pase'];
		$this->Id_Estado_Pase->DbValue = $row['Id_Estado_Pase'];
		$this->Id_Hardware->DbValue = $row['Id_Hardware'];
		$this->SN->DbValue = $row['SN'];
		$this->Modelo_Net->DbValue = $row['Modelo_Net'];
		$this->Marca_Arranque->DbValue = $row['Marca_Arranque'];
		$this->Nombre_Titular->DbValue = $row['Nombre_Titular'];
		$this->Dni_Titular->DbValue = $row['Dni_Titular'];
		$this->Cuil_Titular->DbValue = $row['Cuil_Titular'];
		$this->DniTutor->DbValue = $row['DniTutor'];
		$this->Nombre_Tutor->DbValue = $row['Nombre_Tutor'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Tel_Tutor->DbValue = $row['Tel_Tutor'];
		$this->CelTutor->DbValue = $row['CelTutor'];
		$this->Cue_Establecimiento_Alta->DbValue = $row['Cue_Establecimiento_Alta'];
		$this->Escuela_Alta->DbValue = $row['Escuela_Alta'];
		$this->Directivo_Alta->DbValue = $row['Directivo_Alta'];
		$this->Cuil_Directivo_Alta->DbValue = $row['Cuil_Directivo_Alta'];
		$this->Dpto_Esc_alta->DbValue = $row['Dpto_Esc_alta'];
		$this->Localidad_Esc_Alta->DbValue = $row['Localidad_Esc_Alta'];
		$this->Domicilio_Esc_Alta->DbValue = $row['Domicilio_Esc_Alta'];
		$this->Rte_Alta->DbValue = $row['Rte_Alta'];
		$this->Tel_Rte_Acta->DbValue = $row['Tel_Rte_Acta'];
		$this->Email_Rte_Alta->DbValue = $row['Email_Rte_Alta'];
		$this->Serie_Server_Alta->DbValue = $row['Serie_Server_Alta'];
		$this->Cue_Establecimiento_Baja->DbValue = $row['Cue_Establecimiento_Baja'];
		$this->Escuela_Baja->DbValue = $row['Escuela_Baja'];
		$this->Directivo_Baja->DbValue = $row['Directivo_Baja'];
		$this->Cuil_Directivo_Baja->DbValue = $row['Cuil_Directivo_Baja'];
		$this->Dpto_Esc_Baja->DbValue = $row['Dpto_Esc_Baja'];
		$this->Localidad_Esc_Baja->DbValue = $row['Localidad_Esc_Baja'];
		$this->Domicilio_Esc_Baja->DbValue = $row['Domicilio_Esc_Baja'];
		$this->Rte_Baja->DbValue = $row['Rte_Baja'];
		$this->Tel_Rte_Baja->DbValue = $row['Tel_Rte_Baja'];
		$this->Email_Rte_Baja->DbValue = $row['Email_Rte_Baja'];
		$this->Serie_Server_Baja->DbValue = $row['Serie_Server_Baja'];
		$this->Ruta_Archivo->Upload->DbValue = $row['Ruta_Archivo'];
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
		// Id_Pase
		// Serie_Equipo
		// Fecha_Pase
		// Id_Estado_Pase
		// Id_Hardware
		// SN
		// Modelo_Net
		// Marca_Arranque
		// Nombre_Titular
		// Dni_Titular
		// Cuil_Titular
		// DniTutor
		// Nombre_Tutor
		// Domicilio
		// Tel_Tutor
		// CelTutor
		// Cue_Establecimiento_Alta
		// Escuela_Alta
		// Directivo_Alta
		// Cuil_Directivo_Alta
		// Dpto_Esc_alta
		// Localidad_Esc_Alta
		// Domicilio_Esc_Alta
		// Rte_Alta
		// Tel_Rte_Acta
		// Email_Rte_Alta
		// Serie_Server_Alta
		// Cue_Establecimiento_Baja
		// Escuela_Baja
		// Directivo_Baja
		// Cuil_Directivo_Baja
		// Dpto_Esc_Baja
		// Localidad_Esc_Baja
		// Domicilio_Esc_Baja
		// Rte_Baja
		// Tel_Rte_Baja
		// Email_Rte_Baja
		// Serie_Server_Baja
		// Ruta_Archivo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Pase
		$this->Id_Pase->ViewValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

		// Serie_Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		if (strval($this->Serie_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Equipo->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
			}
		} else {
			$this->Serie_Equipo->ViewValue = NULL;
		}
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Fecha_Pase
		$this->Fecha_Pase->ViewValue = $this->Fecha_Pase->CurrentValue;
		$this->Fecha_Pase->ViewValue = ew_FormatDateTime($this->Fecha_Pase->ViewValue, 7);
		$this->Fecha_Pase->ViewCustomAttributes = "";

		// Id_Estado_Pase
		if (strval($this->Id_Estado_Pase->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
		$sWhereWrk = "";
		$this->Id_Estado_Pase->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->CurrentValue;
			}
		} else {
			$this->Id_Estado_Pase->ViewValue = NULL;
		}
		$this->Id_Estado_Pase->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Modelo_Net
		if (strval($this->Modelo_Net->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Modelo_Net->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
		$sWhereWrk = "";
		$this->Modelo_Net->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Modelo_Net, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->CurrentValue;
			}
		} else {
			$this->Modelo_Net->ViewValue = NULL;
		}
		$this->Modelo_Net->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Nombre_Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		if (strval($this->Nombre_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
			}
		} else {
			$this->Nombre_Titular->ViewValue = NULL;
		}
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni_Titular
		$this->Dni_Titular->ViewValue = $this->Dni_Titular->CurrentValue;
		$this->Dni_Titular->ViewCustomAttributes = "";

		// Cuil_Titular
		$this->Cuil_Titular->ViewValue = $this->Cuil_Titular->CurrentValue;
		$this->Cuil_Titular->ViewCustomAttributes = "";

		// DniTutor
		$this->DniTutor->ViewValue = $this->DniTutor->CurrentValue;
		if (strval($this->DniTutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->DniTutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Dni_Tutor` AS `DispFld`, `Apellidos_Nombres` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->DniTutor->LookupFilters = array("dx1" => "`Dni_Tutor`", "dx2" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DniTutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->DniTutor->ViewValue = $this->DniTutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DniTutor->ViewValue = $this->DniTutor->CurrentValue;
			}
		} else {
			$this->DniTutor->ViewValue = NULL;
		}
		$this->DniTutor->ViewCustomAttributes = "";

		// Nombre_Tutor
		$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
		$this->Nombre_Tutor->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Tutor
		$this->Tel_Tutor->ViewValue = $this->Tel_Tutor->CurrentValue;
		$this->Tel_Tutor->ViewCustomAttributes = "";

		// CelTutor
		$this->CelTutor->ViewValue = $this->CelTutor->CurrentValue;
		$this->CelTutor->ViewCustomAttributes = "";

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
		if (strval($this->Cue_Establecimiento_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Alta->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Alta->ViewCustomAttributes = "";

		// Escuela_Alta
		$this->Escuela_Alta->ViewValue = $this->Escuela_Alta->CurrentValue;
		$this->Escuela_Alta->ViewCustomAttributes = "";

		// Directivo_Alta
		$this->Directivo_Alta->ViewValue = $this->Directivo_Alta->CurrentValue;
		$this->Directivo_Alta->ViewCustomAttributes = "";

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->ViewValue = $this->Cuil_Directivo_Alta->CurrentValue;
		$this->Cuil_Directivo_Alta->ViewCustomAttributes = "";

		// Dpto_Esc_alta
		if (strval($this->Dpto_Esc_alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_alta->ViewValue = NULL;
		}
		$this->Dpto_Esc_alta->ViewCustomAttributes = "";

		// Localidad_Esc_Alta
		if (strval($this->Localidad_Esc_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Alta->ViewValue = NULL;
		}
		$this->Localidad_Esc_Alta->ViewCustomAttributes = "";

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->ViewValue = $this->Domicilio_Esc_Alta->CurrentValue;
		$this->Domicilio_Esc_Alta->ViewCustomAttributes = "";

		// Rte_Alta
		$this->Rte_Alta->ViewValue = $this->Rte_Alta->CurrentValue;
		$this->Rte_Alta->ViewCustomAttributes = "";

		// Tel_Rte_Acta
		$this->Tel_Rte_Acta->ViewValue = $this->Tel_Rte_Acta->CurrentValue;
		$this->Tel_Rte_Acta->ViewCustomAttributes = "";

		// Email_Rte_Alta
		$this->Email_Rte_Alta->ViewValue = $this->Email_Rte_Alta->CurrentValue;
		$this->Email_Rte_Alta->ViewCustomAttributes = "";

		// Serie_Server_Alta
		$this->Serie_Server_Alta->ViewValue = $this->Serie_Server_Alta->CurrentValue;
		$this->Serie_Server_Alta->ViewCustomAttributes = "";

		// Cue_Establecimiento_Baja
		if (strval($this->Cue_Establecimiento_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Baja->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Baja->ViewCustomAttributes = "";

		// Escuela_Baja
		$this->Escuela_Baja->ViewValue = $this->Escuela_Baja->CurrentValue;
		$this->Escuela_Baja->ViewCustomAttributes = "";

		// Directivo_Baja
		$this->Directivo_Baja->ViewValue = $this->Directivo_Baja->CurrentValue;
		$this->Directivo_Baja->ViewCustomAttributes = "";

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->ViewValue = $this->Cuil_Directivo_Baja->CurrentValue;
		$this->Cuil_Directivo_Baja->ViewCustomAttributes = "";

		// Dpto_Esc_Baja
		if (strval($this->Dpto_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_Baja->ViewValue = NULL;
		}
		$this->Dpto_Esc_Baja->ViewCustomAttributes = "";

		// Localidad_Esc_Baja
		if (strval($this->Localidad_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Baja->ViewValue = NULL;
		}
		$this->Localidad_Esc_Baja->ViewCustomAttributes = "";

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->ViewValue = $this->Domicilio_Esc_Baja->CurrentValue;
		$this->Domicilio_Esc_Baja->ViewCustomAttributes = "";

		// Rte_Baja
		$this->Rte_Baja->ViewValue = $this->Rte_Baja->CurrentValue;
		$this->Rte_Baja->ViewCustomAttributes = "";

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->ViewValue = $this->Tel_Rte_Baja->CurrentValue;
		$this->Tel_Rte_Baja->ViewCustomAttributes = "";

		// Email_Rte_Baja
		$this->Email_Rte_Baja->ViewValue = $this->Email_Rte_Baja->CurrentValue;
		$this->Email_Rte_Baja->ViewCustomAttributes = "";

		// Serie_Server_Baja
		$this->Serie_Server_Baja->ViewValue = $this->Serie_Server_Baja->CurrentValue;
		$this->Serie_Server_Baja->ViewCustomAttributes = "";

		// Ruta_Archivo
		if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
			$this->Ruta_Archivo->ViewValue = $this->Ruta_Archivo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo->ViewValue = "";
		}
		$this->Ruta_Archivo->ViewCustomAttributes = "";

			// Id_Pase
			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";
			$this->Id_Pase->TooltipValue = "";

			// Serie_Equipo
			$this->Serie_Equipo->LinkCustomAttributes = "";
			$this->Serie_Equipo->HrefValue = "";
			$this->Serie_Equipo->TooltipValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";
			$this->Fecha_Pase->TooltipValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
			$this->Id_Estado_Pase->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Modelo_Net
			$this->Modelo_Net->LinkCustomAttributes = "";
			$this->Modelo_Net->HrefValue = "";
			$this->Modelo_Net->TooltipValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";
			$this->Marca_Arranque->TooltipValue = "";

			// Nombre_Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Dni_Titular
			$this->Dni_Titular->LinkCustomAttributes = "";
			$this->Dni_Titular->HrefValue = "";
			$this->Dni_Titular->TooltipValue = "";

			// Cuil_Titular
			$this->Cuil_Titular->LinkCustomAttributes = "";
			$this->Cuil_Titular->HrefValue = "";
			$this->Cuil_Titular->TooltipValue = "";

			// DniTutor
			$this->DniTutor->LinkCustomAttributes = "";
			$this->DniTutor->HrefValue = "";
			$this->DniTutor->TooltipValue = "";

			// Nombre_Tutor
			$this->Nombre_Tutor->LinkCustomAttributes = "";
			$this->Nombre_Tutor->HrefValue = "";
			$this->Nombre_Tutor->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Tel_Tutor
			$this->Tel_Tutor->LinkCustomAttributes = "";
			$this->Tel_Tutor->HrefValue = "";
			$this->Tel_Tutor->TooltipValue = "";

			// CelTutor
			$this->CelTutor->LinkCustomAttributes = "";
			$this->CelTutor->HrefValue = "";
			$this->CelTutor->TooltipValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";
			$this->Cue_Establecimiento_Alta->TooltipValue = "";

			// Escuela_Alta
			$this->Escuela_Alta->LinkCustomAttributes = "";
			$this->Escuela_Alta->HrefValue = "";
			$this->Escuela_Alta->TooltipValue = "";

			// Directivo_Alta
			$this->Directivo_Alta->LinkCustomAttributes = "";
			$this->Directivo_Alta->HrefValue = "";
			$this->Directivo_Alta->TooltipValue = "";

			// Cuil_Directivo_Alta
			$this->Cuil_Directivo_Alta->LinkCustomAttributes = "";
			$this->Cuil_Directivo_Alta->HrefValue = "";
			$this->Cuil_Directivo_Alta->TooltipValue = "";

			// Dpto_Esc_alta
			$this->Dpto_Esc_alta->LinkCustomAttributes = "";
			$this->Dpto_Esc_alta->HrefValue = "";
			$this->Dpto_Esc_alta->TooltipValue = "";

			// Localidad_Esc_Alta
			$this->Localidad_Esc_Alta->LinkCustomAttributes = "";
			$this->Localidad_Esc_Alta->HrefValue = "";
			$this->Localidad_Esc_Alta->TooltipValue = "";

			// Domicilio_Esc_Alta
			$this->Domicilio_Esc_Alta->LinkCustomAttributes = "";
			$this->Domicilio_Esc_Alta->HrefValue = "";
			$this->Domicilio_Esc_Alta->TooltipValue = "";

			// Rte_Alta
			$this->Rte_Alta->LinkCustomAttributes = "";
			$this->Rte_Alta->HrefValue = "";
			$this->Rte_Alta->TooltipValue = "";

			// Tel_Rte_Acta
			$this->Tel_Rte_Acta->LinkCustomAttributes = "";
			$this->Tel_Rte_Acta->HrefValue = "";
			$this->Tel_Rte_Acta->TooltipValue = "";

			// Email_Rte_Alta
			$this->Email_Rte_Alta->LinkCustomAttributes = "";
			$this->Email_Rte_Alta->HrefValue = "";
			$this->Email_Rte_Alta->TooltipValue = "";

			// Serie_Server_Alta
			$this->Serie_Server_Alta->LinkCustomAttributes = "";
			$this->Serie_Server_Alta->HrefValue = "";
			$this->Serie_Server_Alta->TooltipValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";
			$this->Cue_Establecimiento_Baja->TooltipValue = "";

			// Escuela_Baja
			$this->Escuela_Baja->LinkCustomAttributes = "";
			$this->Escuela_Baja->HrefValue = "";
			$this->Escuela_Baja->TooltipValue = "";

			// Directivo_Baja
			$this->Directivo_Baja->LinkCustomAttributes = "";
			$this->Directivo_Baja->HrefValue = "";
			$this->Directivo_Baja->TooltipValue = "";

			// Cuil_Directivo_Baja
			$this->Cuil_Directivo_Baja->LinkCustomAttributes = "";
			$this->Cuil_Directivo_Baja->HrefValue = "";
			$this->Cuil_Directivo_Baja->TooltipValue = "";

			// Dpto_Esc_Baja
			$this->Dpto_Esc_Baja->LinkCustomAttributes = "";
			$this->Dpto_Esc_Baja->HrefValue = "";
			$this->Dpto_Esc_Baja->TooltipValue = "";

			// Localidad_Esc_Baja
			$this->Localidad_Esc_Baja->LinkCustomAttributes = "";
			$this->Localidad_Esc_Baja->HrefValue = "";
			$this->Localidad_Esc_Baja->TooltipValue = "";

			// Domicilio_Esc_Baja
			$this->Domicilio_Esc_Baja->LinkCustomAttributes = "";
			$this->Domicilio_Esc_Baja->HrefValue = "";
			$this->Domicilio_Esc_Baja->TooltipValue = "";

			// Rte_Baja
			$this->Rte_Baja->LinkCustomAttributes = "";
			$this->Rte_Baja->HrefValue = "";
			$this->Rte_Baja->TooltipValue = "";

			// Tel_Rte_Baja
			$this->Tel_Rte_Baja->LinkCustomAttributes = "";
			$this->Tel_Rte_Baja->HrefValue = "";
			$this->Tel_Rte_Baja->TooltipValue = "";

			// Email_Rte_Baja
			$this->Email_Rte_Baja->LinkCustomAttributes = "";
			$this->Email_Rte_Baja->HrefValue = "";
			$this->Email_Rte_Baja->TooltipValue = "";

			// Serie_Server_Baja
			$this->Serie_Server_Baja->LinkCustomAttributes = "";
			$this->Serie_Server_Baja->HrefValue = "";
			$this->Serie_Server_Baja->TooltipValue = "";

			// Ruta_Archivo
			$this->Ruta_Archivo->LinkCustomAttributes = "";
			$this->Ruta_Archivo->HrefValue = "";
			$this->Ruta_Archivo->HrefValue2 = $this->Ruta_Archivo->UploadPath . $this->Ruta_Archivo->Upload->DbValue;
			$this->Ruta_Archivo->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_pase_establecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pase_establecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpase_establecimientoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pase_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$pages->Add(4);
		$pages->Add(5);
		$pages->Add(6);
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
if (!isset($pase_establecimiento_view)) $pase_establecimiento_view = new cpase_establecimiento_view();

// Page init
$pase_establecimiento_view->Page_Init();

// Page main
$pase_establecimiento_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pase_establecimiento_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpase_establecimientoview = new ew_Form("fpase_establecimientoview", "view");

// Form_CustomValidate event
fpase_establecimientoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpase_establecimientoview.ValidateRequired = true;
<?php } else { ?>
fpase_establecimientoview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fpase_establecimientoview.MultiPage = new ew_MultiPage("fpase_establecimientoview");

// Dynamic selection lists
fpase_establecimientoview.Lists["x_Serie_Equipo"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpase_establecimientoview.Lists["x_Id_Estado_Pase"] = {"LinkField":"x_Id_Estado_Pase","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_pase"};
fpase_establecimientoview.Lists["x_Modelo_Net"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo"};
fpase_establecimientoview.Lists["x_Nombre_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fpase_establecimientoview.Lists["x_DniTutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Dni_Tutor","x_Apellidos_Nombres","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fpase_establecimientoview.Lists["x_Cue_Establecimiento_Alta"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientoview.Lists["x_Dpto_Esc_alta"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpase_establecimientoview.Lists["x_Localidad_Esc_Alta"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fpase_establecimientoview.Lists["x_Cue_Establecimiento_Baja"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientoview.Lists["x_Dpto_Esc_Baja"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpase_establecimientoview.Lists["x_Localidad_Esc_Baja"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$pase_establecimiento_view->IsModal) { ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $pase_establecimiento_view->ExportOptions->Render("body") ?>
<?php
	foreach ($pase_establecimiento_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$pase_establecimiento_view->IsModal) { ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pase_establecimiento_view->ShowPageHeader(); ?>
<?php
$pase_establecimiento_view->ShowMessage();
?>
<form name="fpase_establecimientoview" id="fpase_establecimientoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pase_establecimiento_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pase_establecimiento_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pase_establecimiento">
<?php if ($pase_establecimiento_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
<div class="ewMultiPage">
<div class="panel-group" id="pase_establecimiento_view">
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento1"><?php echo $pase_establecimiento->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("1") ?>" id="tab_pase_establecimiento1">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
	<tr id="r_Id_Pase">
		<td><span id="elh_pase_establecimiento_Id_Pase"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?></span></td>
		<td data-name="Id_Pase"<?php echo $pase_establecimiento->Id_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Id_Pase" data-page="1">
<span<?php echo $pase_establecimiento->Id_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Pase->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Titular->Visible) { // Nombre_Titular ?>
	<tr id="r_Nombre_Titular">
		<td><span id="elh_pase_establecimiento_Nombre_Titular"><?php echo $pase_establecimiento->Nombre_Titular->FldCaption() ?></span></td>
		<td data-name="Nombre_Titular"<?php echo $pase_establecimiento->Nombre_Titular->CellAttributes() ?>>
<span id="el_pase_establecimiento_Nombre_Titular" data-page="1">
<span<?php echo $pase_establecimiento->Nombre_Titular->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Nombre_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Dni_Titular->Visible) { // Dni_Titular ?>
	<tr id="r_Dni_Titular">
		<td><span id="elh_pase_establecimiento_Dni_Titular"><?php echo $pase_establecimiento->Dni_Titular->FldCaption() ?></span></td>
		<td data-name="Dni_Titular"<?php echo $pase_establecimiento->Dni_Titular->CellAttributes() ?>>
<span id="el_pase_establecimiento_Dni_Titular" data-page="1">
<span<?php echo $pase_establecimiento->Dni_Titular->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Dni_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Titular->Visible) { // Cuil_Titular ?>
	<tr id="r_Cuil_Titular">
		<td><span id="elh_pase_establecimiento_Cuil_Titular"><?php echo $pase_establecimiento->Cuil_Titular->FldCaption() ?></span></td>
		<td data-name="Cuil_Titular"<?php echo $pase_establecimiento->Cuil_Titular->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cuil_Titular" data-page="1">
<span<?php echo $pase_establecimiento->Cuil_Titular->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cuil_Titular->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento2"><?php echo $pase_establecimiento->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("2") ?>" id="tab_pase_establecimiento2">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->DniTutor->Visible) { // DniTutor ?>
	<tr id="r_DniTutor">
		<td><span id="elh_pase_establecimiento_DniTutor"><?php echo $pase_establecimiento->DniTutor->FldCaption() ?></span></td>
		<td data-name="DniTutor"<?php echo $pase_establecimiento->DniTutor->CellAttributes() ?>>
<span id="el_pase_establecimiento_DniTutor" data-page="2">
<span<?php echo $pase_establecimiento->DniTutor->ViewAttributes() ?>>
<?php echo $pase_establecimiento->DniTutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Tutor->Visible) { // Nombre_Tutor ?>
	<tr id="r_Nombre_Tutor">
		<td><span id="elh_pase_establecimiento_Nombre_Tutor"><?php echo $pase_establecimiento->Nombre_Tutor->FldCaption() ?></span></td>
		<td data-name="Nombre_Tutor"<?php echo $pase_establecimiento->Nombre_Tutor->CellAttributes() ?>>
<span id="el_pase_establecimiento_Nombre_Tutor" data-page="2">
<span<?php echo $pase_establecimiento->Nombre_Tutor->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Nombre_Tutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio">
		<td><span id="elh_pase_establecimiento_Domicilio"><?php echo $pase_establecimiento->Domicilio->FldCaption() ?></span></td>
		<td data-name="Domicilio"<?php echo $pase_establecimiento->Domicilio->CellAttributes() ?>>
<span id="el_pase_establecimiento_Domicilio" data-page="2">
<span<?php echo $pase_establecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Domicilio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Tutor->Visible) { // Tel_Tutor ?>
	<tr id="r_Tel_Tutor">
		<td><span id="elh_pase_establecimiento_Tel_Tutor"><?php echo $pase_establecimiento->Tel_Tutor->FldCaption() ?></span></td>
		<td data-name="Tel_Tutor"<?php echo $pase_establecimiento->Tel_Tutor->CellAttributes() ?>>
<span id="el_pase_establecimiento_Tel_Tutor" data-page="2">
<span<?php echo $pase_establecimiento->Tel_Tutor->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Tel_Tutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->CelTutor->Visible) { // CelTutor ?>
	<tr id="r_CelTutor">
		<td><span id="elh_pase_establecimiento_CelTutor"><?php echo $pase_establecimiento->CelTutor->FldCaption() ?></span></td>
		<td data-name="CelTutor"<?php echo $pase_establecimiento->CelTutor->CellAttributes() ?>>
<span id="el_pase_establecimiento_CelTutor" data-page="2">
<span<?php echo $pase_establecimiento->CelTutor->ViewAttributes() ?>>
<?php echo $pase_establecimiento->CelTutor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento3"><?php echo $pase_establecimiento->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("3") ?>" id="tab_pase_establecimiento3">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->Serie_Equipo->Visible) { // Serie_Equipo ?>
	<tr id="r_Serie_Equipo">
		<td><span id="elh_pase_establecimiento_Serie_Equipo"><?php echo $pase_establecimiento->Serie_Equipo->FldCaption() ?></span></td>
		<td data-name="Serie_Equipo"<?php echo $pase_establecimiento->Serie_Equipo->CellAttributes() ?>>
<span id="el_pase_establecimiento_Serie_Equipo" data-page="3">
<span<?php echo $pase_establecimiento->Serie_Equipo->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Serie_Equipo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Id_Hardware->Visible) { // Id_Hardware ?>
	<tr id="r_Id_Hardware">
		<td><span id="elh_pase_establecimiento_Id_Hardware"><?php echo $pase_establecimiento->Id_Hardware->FldCaption() ?></span></td>
		<td data-name="Id_Hardware"<?php echo $pase_establecimiento->Id_Hardware->CellAttributes() ?>>
<span id="el_pase_establecimiento_Id_Hardware" data-page="3">
<span<?php echo $pase_establecimiento->Id_Hardware->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Hardware->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->SN->Visible) { // SN ?>
	<tr id="r_SN">
		<td><span id="elh_pase_establecimiento_SN"><?php echo $pase_establecimiento->SN->FldCaption() ?></span></td>
		<td data-name="SN"<?php echo $pase_establecimiento->SN->CellAttributes() ?>>
<span id="el_pase_establecimiento_SN" data-page="3">
<span<?php echo $pase_establecimiento->SN->ViewAttributes() ?>>
<?php echo $pase_establecimiento->SN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Modelo_Net->Visible) { // Modelo_Net ?>
	<tr id="r_Modelo_Net">
		<td><span id="elh_pase_establecimiento_Modelo_Net"><?php echo $pase_establecimiento->Modelo_Net->FldCaption() ?></span></td>
		<td data-name="Modelo_Net"<?php echo $pase_establecimiento->Modelo_Net->CellAttributes() ?>>
<span id="el_pase_establecimiento_Modelo_Net" data-page="3">
<span<?php echo $pase_establecimiento->Modelo_Net->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Modelo_Net->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<tr id="r_Marca_Arranque">
		<td><span id="elh_pase_establecimiento_Marca_Arranque"><?php echo $pase_establecimiento->Marca_Arranque->FldCaption() ?></span></td>
		<td data-name="Marca_Arranque"<?php echo $pase_establecimiento->Marca_Arranque->CellAttributes() ?>>
<span id="el_pase_establecimiento_Marca_Arranque" data-page="3">
<span<?php echo $pase_establecimiento->Marca_Arranque->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Marca_Arranque->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("4") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento4"><?php echo $pase_establecimiento->PageCaption(4) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("4") ?>" id="tab_pase_establecimiento4">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
	<tr id="r_Cue_Establecimiento_Baja">
		<td><span id="elh_pase_establecimiento_Cue_Establecimiento_Baja"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></span></td>
		<td data-name="Cue_Establecimiento_Baja"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cue_Establecimiento_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Baja->Visible) { // Escuela_Baja ?>
	<tr id="r_Escuela_Baja">
		<td><span id="elh_pase_establecimiento_Escuela_Baja"><?php echo $pase_establecimiento->Escuela_Baja->FldCaption() ?></span></td>
		<td data-name="Escuela_Baja"<?php echo $pase_establecimiento->Escuela_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Escuela_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Escuela_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Escuela_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Directivo_Baja->Visible) { // Directivo_Baja ?>
	<tr id="r_Directivo_Baja">
		<td><span id="elh_pase_establecimiento_Directivo_Baja"><?php echo $pase_establecimiento->Directivo_Baja->FldCaption() ?></span></td>
		<td data-name="Directivo_Baja"<?php echo $pase_establecimiento->Directivo_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Directivo_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Directivo_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Directivo_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Directivo_Baja->Visible) { // Cuil_Directivo_Baja ?>
	<tr id="r_Cuil_Directivo_Baja">
		<td><span id="elh_pase_establecimiento_Cuil_Directivo_Baja"><?php echo $pase_establecimiento->Cuil_Directivo_Baja->FldCaption() ?></span></td>
		<td data-name="Cuil_Directivo_Baja"<?php echo $pase_establecimiento->Cuil_Directivo_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cuil_Directivo_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Cuil_Directivo_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cuil_Directivo_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Dpto_Esc_Baja->Visible) { // Dpto_Esc_Baja ?>
	<tr id="r_Dpto_Esc_Baja">
		<td><span id="elh_pase_establecimiento_Dpto_Esc_Baja"><?php echo $pase_establecimiento->Dpto_Esc_Baja->FldCaption() ?></span></td>
		<td data-name="Dpto_Esc_Baja"<?php echo $pase_establecimiento->Dpto_Esc_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Dpto_Esc_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Dpto_Esc_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Dpto_Esc_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Localidad_Esc_Baja->Visible) { // Localidad_Esc_Baja ?>
	<tr id="r_Localidad_Esc_Baja">
		<td><span id="elh_pase_establecimiento_Localidad_Esc_Baja"><?php echo $pase_establecimiento->Localidad_Esc_Baja->FldCaption() ?></span></td>
		<td data-name="Localidad_Esc_Baja"<?php echo $pase_establecimiento->Localidad_Esc_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Localidad_Esc_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Localidad_Esc_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Localidad_Esc_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio_Esc_Baja->Visible) { // Domicilio_Esc_Baja ?>
	<tr id="r_Domicilio_Esc_Baja">
		<td><span id="elh_pase_establecimiento_Domicilio_Esc_Baja"><?php echo $pase_establecimiento->Domicilio_Esc_Baja->FldCaption() ?></span></td>
		<td data-name="Domicilio_Esc_Baja"<?php echo $pase_establecimiento->Domicilio_Esc_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Domicilio_Esc_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Domicilio_Esc_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Domicilio_Esc_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Rte_Baja->Visible) { // Rte_Baja ?>
	<tr id="r_Rte_Baja">
		<td><span id="elh_pase_establecimiento_Rte_Baja"><?php echo $pase_establecimiento->Rte_Baja->FldCaption() ?></span></td>
		<td data-name="Rte_Baja"<?php echo $pase_establecimiento->Rte_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Rte_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Rte_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Rte_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Rte_Baja->Visible) { // Tel_Rte_Baja ?>
	<tr id="r_Tel_Rte_Baja">
		<td><span id="elh_pase_establecimiento_Tel_Rte_Baja"><?php echo $pase_establecimiento->Tel_Rte_Baja->FldCaption() ?></span></td>
		<td data-name="Tel_Rte_Baja"<?php echo $pase_establecimiento->Tel_Rte_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Tel_Rte_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Tel_Rte_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Tel_Rte_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Email_Rte_Baja->Visible) { // Email_Rte_Baja ?>
	<tr id="r_Email_Rte_Baja">
		<td><span id="elh_pase_establecimiento_Email_Rte_Baja"><?php echo $pase_establecimiento->Email_Rte_Baja->FldCaption() ?></span></td>
		<td data-name="Email_Rte_Baja"<?php echo $pase_establecimiento->Email_Rte_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Email_Rte_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Email_Rte_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Email_Rte_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Server_Baja->Visible) { // Serie_Server_Baja ?>
	<tr id="r_Serie_Server_Baja">
		<td><span id="elh_pase_establecimiento_Serie_Server_Baja"><?php echo $pase_establecimiento->Serie_Server_Baja->FldCaption() ?></span></td>
		<td data-name="Serie_Server_Baja"<?php echo $pase_establecimiento->Serie_Server_Baja->CellAttributes() ?>>
<span id="el_pase_establecimiento_Serie_Server_Baja" data-page="4">
<span<?php echo $pase_establecimiento->Serie_Server_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Serie_Server_Baja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("5") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento5"><?php echo $pase_establecimiento->PageCaption(5) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("5") ?>" id="tab_pase_establecimiento5">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
	<tr id="r_Cue_Establecimiento_Alta">
		<td><span id="elh_pase_establecimiento_Cue_Establecimiento_Alta"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></span></td>
		<td data-name="Cue_Establecimiento_Alta"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cue_Establecimiento_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Alta->Visible) { // Escuela_Alta ?>
	<tr id="r_Escuela_Alta">
		<td><span id="elh_pase_establecimiento_Escuela_Alta"><?php echo $pase_establecimiento->Escuela_Alta->FldCaption() ?></span></td>
		<td data-name="Escuela_Alta"<?php echo $pase_establecimiento->Escuela_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Escuela_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Escuela_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Escuela_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Directivo_Alta->Visible) { // Directivo_Alta ?>
	<tr id="r_Directivo_Alta">
		<td><span id="elh_pase_establecimiento_Directivo_Alta"><?php echo $pase_establecimiento->Directivo_Alta->FldCaption() ?></span></td>
		<td data-name="Directivo_Alta"<?php echo $pase_establecimiento->Directivo_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Directivo_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Directivo_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Directivo_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Directivo_Alta->Visible) { // Cuil_Directivo_Alta ?>
	<tr id="r_Cuil_Directivo_Alta">
		<td><span id="elh_pase_establecimiento_Cuil_Directivo_Alta"><?php echo $pase_establecimiento->Cuil_Directivo_Alta->FldCaption() ?></span></td>
		<td data-name="Cuil_Directivo_Alta"<?php echo $pase_establecimiento->Cuil_Directivo_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Cuil_Directivo_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Cuil_Directivo_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cuil_Directivo_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Dpto_Esc_alta->Visible) { // Dpto_Esc_alta ?>
	<tr id="r_Dpto_Esc_alta">
		<td><span id="elh_pase_establecimiento_Dpto_Esc_alta"><?php echo $pase_establecimiento->Dpto_Esc_alta->FldCaption() ?></span></td>
		<td data-name="Dpto_Esc_alta"<?php echo $pase_establecimiento->Dpto_Esc_alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Dpto_Esc_alta" data-page="5">
<span<?php echo $pase_establecimiento->Dpto_Esc_alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Dpto_Esc_alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Localidad_Esc_Alta->Visible) { // Localidad_Esc_Alta ?>
	<tr id="r_Localidad_Esc_Alta">
		<td><span id="elh_pase_establecimiento_Localidad_Esc_Alta"><?php echo $pase_establecimiento->Localidad_Esc_Alta->FldCaption() ?></span></td>
		<td data-name="Localidad_Esc_Alta"<?php echo $pase_establecimiento->Localidad_Esc_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Localidad_Esc_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Localidad_Esc_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Localidad_Esc_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio_Esc_Alta->Visible) { // Domicilio_Esc_Alta ?>
	<tr id="r_Domicilio_Esc_Alta">
		<td><span id="elh_pase_establecimiento_Domicilio_Esc_Alta"><?php echo $pase_establecimiento->Domicilio_Esc_Alta->FldCaption() ?></span></td>
		<td data-name="Domicilio_Esc_Alta"<?php echo $pase_establecimiento->Domicilio_Esc_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Domicilio_Esc_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Domicilio_Esc_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Domicilio_Esc_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Rte_Alta->Visible) { // Rte_Alta ?>
	<tr id="r_Rte_Alta">
		<td><span id="elh_pase_establecimiento_Rte_Alta"><?php echo $pase_establecimiento->Rte_Alta->FldCaption() ?></span></td>
		<td data-name="Rte_Alta"<?php echo $pase_establecimiento->Rte_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Rte_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Rte_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Rte_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Rte_Acta->Visible) { // Tel_Rte_Acta ?>
	<tr id="r_Tel_Rte_Acta">
		<td><span id="elh_pase_establecimiento_Tel_Rte_Acta"><?php echo $pase_establecimiento->Tel_Rte_Acta->FldCaption() ?></span></td>
		<td data-name="Tel_Rte_Acta"<?php echo $pase_establecimiento->Tel_Rte_Acta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Tel_Rte_Acta" data-page="5">
<span<?php echo $pase_establecimiento->Tel_Rte_Acta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Tel_Rte_Acta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Email_Rte_Alta->Visible) { // Email_Rte_Alta ?>
	<tr id="r_Email_Rte_Alta">
		<td><span id="elh_pase_establecimiento_Email_Rte_Alta"><?php echo $pase_establecimiento->Email_Rte_Alta->FldCaption() ?></span></td>
		<td data-name="Email_Rte_Alta"<?php echo $pase_establecimiento->Email_Rte_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Email_Rte_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Email_Rte_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Email_Rte_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Server_Alta->Visible) { // Serie_Server_Alta ?>
	<tr id="r_Serie_Server_Alta">
		<td><span id="elh_pase_establecimiento_Serie_Server_Alta"><?php echo $pase_establecimiento->Serie_Server_Alta->FldCaption() ?></span></td>
		<td data-name="Serie_Server_Alta"<?php echo $pase_establecimiento->Serie_Server_Alta->CellAttributes() ?>>
<span id="el_pase_establecimiento_Serie_Server_Alta" data-page="5">
<span<?php echo $pase_establecimiento->Serie_Server_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Serie_Server_Alta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
	<div class="panel panel-default<?php echo $pase_establecimiento_view->MultiPages->PageStyle("6") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#pase_establecimiento_view" href="#tab_pase_establecimiento6"><?php echo $pase_establecimiento->PageCaption(6) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $pase_establecimiento_view->MultiPages->PageStyle("6") ?>" id="tab_pase_establecimiento6">
			<div class="panel-body">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
	<tr id="r_Fecha_Pase">
		<td><span id="elh_pase_establecimiento_Fecha_Pase"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></span></td>
		<td data-name="Fecha_Pase"<?php echo $pase_establecimiento->Fecha_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Fecha_Pase" data-page="6">
<span<?php echo $pase_establecimiento->Fecha_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Fecha_Pase->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
	<tr id="r_Id_Estado_Pase">
		<td><span id="elh_pase_establecimiento_Id_Estado_Pase"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->CellAttributes() ?>>
<span id="el_pase_establecimiento_Id_Estado_Pase" data-page="6">
<span<?php echo $pase_establecimiento->Id_Estado_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pase_establecimiento->Ruta_Archivo->Visible) { // Ruta_Archivo ?>
	<tr id="r_Ruta_Archivo">
		<td><span id="elh_pase_establecimiento_Ruta_Archivo"><?php echo $pase_establecimiento->Ruta_Archivo->FldCaption() ?></span></td>
		<td data-name="Ruta_Archivo"<?php echo $pase_establecimiento->Ruta_Archivo->CellAttributes() ?>>
<span id="el_pase_establecimiento_Ruta_Archivo" data-page="6">
<span<?php echo $pase_establecimiento->Ruta_Archivo->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($pase_establecimiento->Ruta_Archivo, $pase_establecimiento->Ruta_Archivo->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pase_establecimiento->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<div class="breadcrumb ewBreadcrumbs">
<a href="actas/Acta_Migracion.php?Id_Pase=<?php echo $pase_establecimiento->Id_Pase->ViewValue?>" class="Estilo1">Acta de Migraci&oacute;n </a></div>
<div class="breadcrumb ewBreadcrumbs">
<a href="actas/Constancia_Pase.php?Id_Pase=<?php echo $pase_establecimiento->Id_Pase->ViewValue?>" class="Estilo1">Constacia de Pase </a></div>

<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">
fpase_establecimientoview.Init();
</script>
<?php } ?>
<?php
$pase_establecimiento_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pase_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pase_establecimiento_view->Page_Terminate();
?>
