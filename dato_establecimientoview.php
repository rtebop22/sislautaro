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

$dato_establecimiento_view = NULL; // Initialize page object first

class cdato_establecimiento_view extends cdato_establecimiento {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'dato_establecimiento';

	// Page object name
	var $PageObjName = 'dato_establecimiento_view';

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
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = FALSE;
	var $AuditTrailOnDelete = FALSE;
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
		$KeyUrl = "";
		if (@$_GET["Cue"] <> "") {
			$this->RecKey["Cue"] = $_GET["Cue"];
			$KeyUrl .= "&amp;Cue=" . urlencode($this->RecKey["Cue"]);
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
				$this->Page_Terminate(ew_GetUrl("dato_establecimientolist.php"));
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
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono_Escuela->SetVisibility();
		$this->Mail_Escuela->SetVisibility();
		$this->Matricula_Actual->SetVisibility();
		$this->Cantidad_Aulas->SetVisibility();
		$this->Comparte_Edificio->SetVisibility();
		$this->Cantidad_Turnos->SetVisibility();
		$this->Geolocalizacion->SetVisibility();
		$this->Id_Tipo_Esc->SetVisibility();
		$this->Universo->SetVisibility();
		$this->Tiene_Programa->SetVisibility();
		$this->Sector->SetVisibility();
		$this->Cantidad_Netbook_Conig->SetVisibility();
		$this->Cantidad_Netbook_Actuales->SetVisibility();
		$this->Id_Nivel->SetVisibility();
		$this->Id_Jornada->SetVisibility();
		$this->Tipo_Zona->SetVisibility();
		$this->Id_Estado_Esc->SetVisibility();
		$this->Id_Zona->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

		// Set up detail page object
		$this->SetupDetailPages();

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
	var $autoridades_escolares_Count;
	var $referente_tecnico_Count;
	var $piso_tecnologico_Count;
	var $servidor_escolar_Count;
	var $datos_extras_escuela_Count;
	var $Recordset;
	var $DetailPages; // Detail pages object

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
				$sReturnUrl = "dato_establecimientolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "dato_establecimientolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "dato_establecimientolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_autoridades_escolares"
		$item = &$option->Add("detail_autoridades_escolares");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("autoridades_escolares", "TblCaption");
		$body .= str_replace("%c", $this->autoridades_escolares_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("autoridades_escolareslist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["autoridades_escolares_grid"] && $GLOBALS["autoridades_escolares_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'autoridades_escolares')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "autoridades_escolares";
		}
		if ($GLOBALS["autoridades_escolares_grid"] && $GLOBALS["autoridades_escolares_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'autoridades_escolares')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "autoridades_escolares";
		}
		if ($GLOBALS["autoridades_escolares_grid"] && $GLOBALS["autoridades_escolares_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'autoridades_escolares')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=autoridades_escolares")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "autoridades_escolares";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'autoridades_escolares');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "autoridades_escolares";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_referente_tecnico"
		$item = &$option->Add("detail_referente_tecnico");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("referente_tecnico", "TblCaption");
		$body .= str_replace("%c", $this->referente_tecnico_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("referente_tecnicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["referente_tecnico_grid"] && $GLOBALS["referente_tecnico_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'referente_tecnico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "referente_tecnico";
		}
		if ($GLOBALS["referente_tecnico_grid"] && $GLOBALS["referente_tecnico_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'referente_tecnico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "referente_tecnico";
		}
		if ($GLOBALS["referente_tecnico_grid"] && $GLOBALS["referente_tecnico_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'referente_tecnico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=referente_tecnico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "referente_tecnico";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'referente_tecnico');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "referente_tecnico";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_piso_tecnologico"
		$item = &$option->Add("detail_piso_tecnologico");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("piso_tecnologico", "TblCaption");
		$body .= str_replace("%c", $this->piso_tecnologico_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("piso_tecnologicolist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["piso_tecnologico_grid"] && $GLOBALS["piso_tecnologico_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'piso_tecnologico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "piso_tecnologico";
		}
		if ($GLOBALS["piso_tecnologico_grid"] && $GLOBALS["piso_tecnologico_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'piso_tecnologico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "piso_tecnologico";
		}
		if ($GLOBALS["piso_tecnologico_grid"] && $GLOBALS["piso_tecnologico_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'piso_tecnologico')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=piso_tecnologico")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "piso_tecnologico";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'piso_tecnologico');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "piso_tecnologico";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_servidor_escolar"
		$item = &$option->Add("detail_servidor_escolar");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("servidor_escolar", "TblCaption");
		$body .= str_replace("%c", $this->servidor_escolar_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("servidor_escolarlist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["servidor_escolar_grid"] && $GLOBALS["servidor_escolar_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'servidor_escolar')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "servidor_escolar";
		}
		if ($GLOBALS["servidor_escolar_grid"] && $GLOBALS["servidor_escolar_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'servidor_escolar')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "servidor_escolar";
		}
		if ($GLOBALS["servidor_escolar_grid"] && $GLOBALS["servidor_escolar_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'servidor_escolar')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=servidor_escolar")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "servidor_escolar";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'servidor_escolar');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "servidor_escolar";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_datos_extras_escuela"
		$item = &$option->Add("detail_datos_extras_escuela");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("datos_extras_escuela", "TblCaption");
		$body .= str_replace("%c", $this->datos_extras_escuela_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("datos_extras_escuelalist.php?" . EW_TABLE_SHOW_MASTER . "=dato_establecimiento&fk_Cue=" . urlencode(strval($this->Cue->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["datos_extras_escuela_grid"] && $GLOBALS["datos_extras_escuela_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'datos_extras_escuela')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "datos_extras_escuela";
		}
		if ($GLOBALS["datos_extras_escuela_grid"] && $GLOBALS["datos_extras_escuela_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'datos_extras_escuela')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "datos_extras_escuela";
		}
		if ($GLOBALS["datos_extras_escuela_grid"] && $GLOBALS["datos_extras_escuela_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'datos_extras_escuela')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=datos_extras_escuela")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "datos_extras_escuela";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'datos_extras_escuela');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "datos_extras_escuela";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
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
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";
			$this->Cantidad_Aulas->TooltipValue = "";

			// Comparte_Edificio
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

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";
			$this->Cantidad_Netbook_Actuales->TooltipValue = "";

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
		$item->Body = "<button id=\"emf_dato_establecimiento\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dato_establecimiento',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdato_establecimientoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export detail records (autoridades_escolares)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("autoridades_escolares", explode(",", $this->getCurrentDetailTable()))) {
			global $autoridades_escolares;
			if (!isset($autoridades_escolares)) $autoridades_escolares = new cautoridades_escolares;
			$rsdetail = $autoridades_escolares->LoadRs($autoridades_escolares->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$autoridades_escolares->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (referente_tecnico)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("referente_tecnico", explode(",", $this->getCurrentDetailTable()))) {
			global $referente_tecnico;
			if (!isset($referente_tecnico)) $referente_tecnico = new creferente_tecnico;
			$rsdetail = $referente_tecnico->LoadRs($referente_tecnico->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$referente_tecnico->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (piso_tecnologico)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("piso_tecnologico", explode(",", $this->getCurrentDetailTable()))) {
			global $piso_tecnologico;
			if (!isset($piso_tecnologico)) $piso_tecnologico = new cpiso_tecnologico;
			$rsdetail = $piso_tecnologico->LoadRs($piso_tecnologico->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$piso_tecnologico->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (servidor_escolar)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("servidor_escolar", explode(",", $this->getCurrentDetailTable()))) {
			global $servidor_escolar;
			if (!isset($servidor_escolar)) $servidor_escolar = new cservidor_escolar;
			$rsdetail = $servidor_escolar->LoadRs($servidor_escolar->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$servidor_escolar->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (datos_extras_escuela)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("datos_extras_escuela", explode(",", $this->getCurrentDetailTable()))) {
			global $datos_extras_escuela;
			if (!isset($datos_extras_escuela)) $datos_extras_escuela = new cdatos_extras_escuela;
			$rsdetail = $datos_extras_escuela->LoadRs($datos_extras_escuela->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$datos_extras_escuela->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("autoridades_escolares", $DetailTblVar)) {
				if (!isset($GLOBALS["autoridades_escolares_grid"]))
					$GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
				if ($GLOBALS["autoridades_escolares_grid"]->DetailView) {
					$GLOBALS["autoridades_escolares_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["autoridades_escolares_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["autoridades_escolares_grid"]->setStartRecordNumber(1);
					$GLOBALS["autoridades_escolares_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["autoridades_escolares_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["autoridades_escolares_grid"]->Cue->setSessionValue($GLOBALS["autoridades_escolares_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("referente_tecnico", $DetailTblVar)) {
				if (!isset($GLOBALS["referente_tecnico_grid"]))
					$GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
				if ($GLOBALS["referente_tecnico_grid"]->DetailView) {
					$GLOBALS["referente_tecnico_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["referente_tecnico_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["referente_tecnico_grid"]->setStartRecordNumber(1);
					$GLOBALS["referente_tecnico_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["referente_tecnico_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["referente_tecnico_grid"]->Cue->setSessionValue($GLOBALS["referente_tecnico_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("piso_tecnologico", $DetailTblVar)) {
				if (!isset($GLOBALS["piso_tecnologico_grid"]))
					$GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
				if ($GLOBALS["piso_tecnologico_grid"]->DetailView) {
					$GLOBALS["piso_tecnologico_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["piso_tecnologico_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["piso_tecnologico_grid"]->setStartRecordNumber(1);
					$GLOBALS["piso_tecnologico_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["piso_tecnologico_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["piso_tecnologico_grid"]->Cue->setSessionValue($GLOBALS["piso_tecnologico_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("servidor_escolar", $DetailTblVar)) {
				if (!isset($GLOBALS["servidor_escolar_grid"]))
					$GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
				if ($GLOBALS["servidor_escolar_grid"]->DetailView) {
					$GLOBALS["servidor_escolar_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["servidor_escolar_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["servidor_escolar_grid"]->setStartRecordNumber(1);
					$GLOBALS["servidor_escolar_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["servidor_escolar_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["servidor_escolar_grid"]->Cue->setSessionValue($GLOBALS["servidor_escolar_grid"]->Cue->CurrentValue);
				}
			}
			if (in_array("datos_extras_escuela", $DetailTblVar)) {
				if (!isset($GLOBALS["datos_extras_escuela_grid"]))
					$GLOBALS["datos_extras_escuela_grid"] = new cdatos_extras_escuela_grid;
				if ($GLOBALS["datos_extras_escuela_grid"]->DetailView) {
					$GLOBALS["datos_extras_escuela_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["datos_extras_escuela_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["datos_extras_escuela_grid"]->setStartRecordNumber(1);
					$GLOBALS["datos_extras_escuela_grid"]->Cue->FldIsDetailKey = TRUE;
					$GLOBALS["datos_extras_escuela_grid"]->Cue->CurrentValue = $this->Cue->CurrentValue;
					$GLOBALS["datos_extras_escuela_grid"]->Cue->setSessionValue($GLOBALS["datos_extras_escuela_grid"]->Cue->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dato_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Set up detail pages
	function SetupDetailPages() {
		$pages = new cSubPages();
		$pages->Add('autoridades_escolares');
		$pages->Add('referente_tecnico');
		$pages->Add('piso_tecnologico');
		$pages->Add('servidor_escolar');
		$pages->Add('datos_extras_escuela');
		$this->DetailPages = $pages;
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'dato_establecimiento';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
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
if (!isset($dato_establecimiento_view)) $dato_establecimiento_view = new cdato_establecimiento_view();

// Page init
$dato_establecimiento_view->Page_Init();

// Page main
$dato_establecimiento_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dato_establecimiento_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdato_establecimientoview = new ew_Form("fdato_establecimientoview", "view");

// Form_CustomValidate event
fdato_establecimientoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdato_establecimientoview.ValidateRequired = true;
<?php } else { ?>
fdato_establecimientoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdato_establecimientoview.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdato_establecimientoview.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fdato_establecimientoview.Lists["x_Comparte_Edificio"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoview.Lists["x_Comparte_Edificio"].Options = <?php echo json_encode($dato_establecimiento->Comparte_Edificio->Options()) ?>;
fdato_establecimientoview.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdato_establecimientoview.Lists["x_Universo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoview.Lists["x_Universo"].Options = <?php echo json_encode($dato_establecimiento->Universo->Options()) ?>;
fdato_establecimientoview.Lists["x_Tiene_Programa"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoview.Lists["x_Tiene_Programa"].Options = <?php echo json_encode($dato_establecimiento->Tiene_Programa->Options()) ?>;
fdato_establecimientoview.Lists["x_Sector"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoview.Lists["x_Sector"].Options = <?php echo json_encode($dato_establecimiento->Sector->Options()) ?>;
fdato_establecimientoview.Lists["x_Id_Nivel[]"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fdato_establecimientoview.Lists["x_Id_Jornada[]"] = {"LinkField":"x_Id_Jornada","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_jornada"};
fdato_establecimientoview.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdato_establecimientoview.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$dato_establecimiento_view->IsModal) { ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $dato_establecimiento_view->ExportOptions->Render("body") ?>
<?php
	foreach ($dato_establecimiento_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$dato_establecimiento_view->IsModal) { ?>
<?php if ($dato_establecimiento->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $dato_establecimiento_view->ShowPageHeader(); ?>
<?php
$dato_establecimiento_view->ShowMessage();
?>
<form name="fdato_establecimientoview" id="fdato_establecimientoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<?php if ($dato_establecimiento_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
	<tr id="r_Cue">
		<td><span id="elh_dato_establecimiento_Cue"><?php echo $dato_establecimiento->Cue->FldCaption() ?></span></td>
		<td data-name="Cue"<?php echo $dato_establecimiento->Cue->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cue" data-page="1">
<span<?php echo $dato_establecimiento->Cue->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cue->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<tr id="r_Nombre_Establecimiento">
		<td><span id="elh_dato_establecimiento_Nombre_Establecimiento"><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?></span></td>
		<td data-name="Nombre_Establecimiento"<?php echo $dato_establecimiento->Nombre_Establecimiento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nombre_Establecimiento" data-page="1">
<span<?php echo $dato_establecimiento->Nombre_Establecimiento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nombre_Establecimiento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
	<tr id="r_Sigla">
		<td><span id="elh_dato_establecimiento_Sigla"><?php echo $dato_establecimiento->Sigla->FldCaption() ?></span></td>
		<td data-name="Sigla"<?php echo $dato_establecimiento->Sigla->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sigla" data-page="1">
<span<?php echo $dato_establecimiento->Sigla->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sigla->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<tr id="r_Nro_Cuise">
		<td><span id="elh_dato_establecimiento_Nro_Cuise"><?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?></span></td>
		<td data-name="Nro_Cuise"<?php echo $dato_establecimiento->Nro_Cuise->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nro_Cuise" data-page="1">
<span<?php echo $dato_establecimiento->Nro_Cuise->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Nro_Cuise->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<tr id="r_Id_Departamento">
		<td><span id="elh_dato_establecimiento_Id_Departamento"><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></span></td>
		<td data-name="Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Departamento" data-page="1">
<span<?php echo $dato_establecimiento->Id_Departamento->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<tr id="r_Id_Localidad">
		<td><span id="elh_dato_establecimiento_Id_Localidad"><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></span></td>
		<td data-name="Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Localidad" data-page="1">
<span<?php echo $dato_establecimiento->Id_Localidad->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio">
		<td><span id="elh_dato_establecimiento_Domicilio"><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></span></td>
		<td data-name="Domicilio"<?php echo $dato_establecimiento->Domicilio->CellAttributes() ?>>
<span id="el_dato_establecimiento_Domicilio" data-page="1">
<span<?php echo $dato_establecimiento->Domicilio->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Domicilio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
	<tr id="r_Telefono_Escuela">
		<td><span id="elh_dato_establecimiento_Telefono_Escuela"><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></span></td>
		<td data-name="Telefono_Escuela"<?php echo $dato_establecimiento->Telefono_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Telefono_Escuela" data-page="1">
<span<?php echo $dato_establecimiento->Telefono_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Telefono_Escuela->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
	<tr id="r_Mail_Escuela">
		<td><span id="elh_dato_establecimiento_Mail_Escuela"><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></span></td>
		<td data-name="Mail_Escuela"<?php echo $dato_establecimiento->Mail_Escuela->CellAttributes() ?>>
<span id="el_dato_establecimiento_Mail_Escuela" data-page="1">
<span<?php echo $dato_establecimiento->Mail_Escuela->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Mail_Escuela->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
	<tr id="r_Matricula_Actual">
		<td><span id="elh_dato_establecimiento_Matricula_Actual"><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></span></td>
		<td data-name="Matricula_Actual"<?php echo $dato_establecimiento->Matricula_Actual->CellAttributes() ?>>
<span id="el_dato_establecimiento_Matricula_Actual" data-page="1">
<span<?php echo $dato_establecimiento->Matricula_Actual->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Matricula_Actual->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
	<tr id="r_Cantidad_Aulas">
		<td><span id="elh_dato_establecimiento_Cantidad_Aulas"><?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></span></td>
		<td data-name="Cantidad_Aulas"<?php echo $dato_establecimiento->Cantidad_Aulas->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Aulas" data-page="1">
<span<?php echo $dato_establecimiento->Cantidad_Aulas->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Aulas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Comparte_Edificio->Visible) { // Comparte_Edificio ?>
	<tr id="r_Comparte_Edificio">
		<td><span id="elh_dato_establecimiento_Comparte_Edificio"><?php echo $dato_establecimiento->Comparte_Edificio->FldCaption() ?></span></td>
		<td data-name="Comparte_Edificio"<?php echo $dato_establecimiento->Comparte_Edificio->CellAttributes() ?>>
<span id="el_dato_establecimiento_Comparte_Edificio" data-page="1">
<span<?php echo $dato_establecimiento->Comparte_Edificio->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Comparte_Edificio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<tr id="r_Cantidad_Turnos">
		<td><span id="elh_dato_establecimiento_Cantidad_Turnos"><?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?></span></td>
		<td data-name="Cantidad_Turnos"<?php echo $dato_establecimiento->Cantidad_Turnos->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Turnos" data-page="1">
<span<?php echo $dato_establecimiento->Cantidad_Turnos->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Turnos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Geolocalizacion->Visible) { // Geolocalizacion ?>
	<tr id="r_Geolocalizacion">
		<td><span id="elh_dato_establecimiento_Geolocalizacion"><?php echo $dato_establecimiento->Geolocalizacion->FldCaption() ?></span></td>
		<td data-name="Geolocalizacion"<?php echo $dato_establecimiento->Geolocalizacion->CellAttributes() ?>>
<span id="el_dato_establecimiento_Geolocalizacion" data-page="1">
<span<?php echo $dato_establecimiento->Geolocalizacion->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Geolocalizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<tr id="r_Id_Tipo_Esc">
		<td><span id="elh_dato_establecimiento_Id_Tipo_Esc"><?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></span></td>
		<td data-name="Id_Tipo_Esc"<?php echo $dato_establecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Tipo_Esc" data-page="1">
<span<?php echo $dato_establecimiento->Id_Tipo_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Tipo_Esc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
	<tr id="r_Universo">
		<td><span id="elh_dato_establecimiento_Universo"><?php echo $dato_establecimiento->Universo->FldCaption() ?></span></td>
		<td data-name="Universo"<?php echo $dato_establecimiento->Universo->CellAttributes() ?>>
<span id="el_dato_establecimiento_Universo" data-page="1">
<span<?php echo $dato_establecimiento->Universo->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Universo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
	<tr id="r_Tiene_Programa">
		<td><span id="elh_dato_establecimiento_Tiene_Programa"><?php echo $dato_establecimiento->Tiene_Programa->FldCaption() ?></span></td>
		<td data-name="Tiene_Programa"<?php echo $dato_establecimiento->Tiene_Programa->CellAttributes() ?>>
<span id="el_dato_establecimiento_Tiene_Programa" data-page="1">
<span<?php echo $dato_establecimiento->Tiene_Programa->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Tiene_Programa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
	<tr id="r_Sector">
		<td><span id="elh_dato_establecimiento_Sector"><?php echo $dato_establecimiento->Sector->FldCaption() ?></span></td>
		<td data-name="Sector"<?php echo $dato_establecimiento->Sector->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sector" data-page="1">
<span<?php echo $dato_establecimiento->Sector->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Sector->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
	<tr id="r_Cantidad_Netbook_Conig">
		<td><span id="elh_dato_establecimiento_Cantidad_Netbook_Conig"><?php echo $dato_establecimiento->Cantidad_Netbook_Conig->FldCaption() ?></span></td>
		<td data-name="Cantidad_Netbook_Conig"<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Netbook_Conig" data-page="1">
<span<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<tr id="r_Cantidad_Netbook_Actuales">
		<td><span id="elh_dato_establecimiento_Cantidad_Netbook_Actuales"><?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></span></td>
		<td data-name="Cantidad_Netbook_Actuales"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Netbook_Actuales" data-page="1">
<span<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Nivel->Visible) { // Id_Nivel ?>
	<tr id="r_Id_Nivel">
		<td><span id="elh_dato_establecimiento_Id_Nivel"><?php echo $dato_establecimiento->Id_Nivel->FldCaption() ?></span></td>
		<td data-name="Id_Nivel"<?php echo $dato_establecimiento->Id_Nivel->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Nivel" data-page="1">
<span<?php echo $dato_establecimiento->Id_Nivel->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Nivel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Jornada->Visible) { // Id_Jornada ?>
	<tr id="r_Id_Jornada">
		<td><span id="elh_dato_establecimiento_Id_Jornada"><?php echo $dato_establecimiento->Id_Jornada->FldCaption() ?></span></td>
		<td data-name="Id_Jornada"<?php echo $dato_establecimiento->Id_Jornada->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Jornada" data-page="1">
<span<?php echo $dato_establecimiento->Id_Jornada->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Jornada->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
	<tr id="r_Tipo_Zona">
		<td><span id="elh_dato_establecimiento_Tipo_Zona"><?php echo $dato_establecimiento->Tipo_Zona->FldCaption() ?></span></td>
		<td data-name="Tipo_Zona"<?php echo $dato_establecimiento->Tipo_Zona->CellAttributes() ?>>
<span id="el_dato_establecimiento_Tipo_Zona" data-page="1">
<span<?php echo $dato_establecimiento->Tipo_Zona->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Tipo_Zona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<tr id="r_Id_Estado_Esc">
		<td><span id="elh_dato_establecimiento_Id_Estado_Esc"><?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></span></td>
		<td data-name="Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Estado_Esc" data-page="1">
<span<?php echo $dato_establecimiento->Id_Estado_Esc->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<tr id="r_Id_Zona">
		<td><span id="elh_dato_establecimiento_Id_Zona"><?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></span></td>
		<td data-name="Id_Zona"<?php echo $dato_establecimiento->Id_Zona->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Zona" data-page="1">
<span<?php echo $dato_establecimiento->Id_Zona->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<tr id="r_Fecha_Actualizacion">
		<td><span id="elh_dato_establecimiento_Fecha_Actualizacion"><?php echo $dato_establecimiento->Fecha_Actualizacion->FldCaption() ?></span></td>
		<td data-name="Fecha_Actualizacion"<?php echo $dato_establecimiento->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el_dato_establecimiento_Fecha_Actualizacion" data-page="1">
<span<?php echo $dato_establecimiento->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Fecha_Actualizacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
	<tr id="r_Usuario">
		<td><span id="elh_dato_establecimiento_Usuario"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></span></td>
		<td data-name="Usuario"<?php echo $dato_establecimiento->Usuario->CellAttributes() ?>>
<span id="el_dato_establecimiento_Usuario" data-page="1">
<span<?php echo $dato_establecimiento->Usuario->ViewAttributes() ?>>
<?php echo $dato_establecimiento->Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($dato_establecimiento->getCurrentDetailTable() <> "") { ?>
<?php
	$FirstActiveDetailTable = $dato_establecimiento_view->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages">
<div class="panel-group" id="dato_establecimiento_view_details">
<?php
	if (in_array("autoridades_escolares", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $autoridades_escolares->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "autoridades_escolares") {
			$FirstActiveDetailTable = "autoridades_escolares";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_view->DetailPages->PageStyle("autoridades_escolares") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_view_details" href="#tab_autoridades_escolares"><?php echo $Language->TablePhrase("autoridades_escolares", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_view->DetailPages->PageStyle("autoridades_escolares") ?>" id="tab_autoridades_escolares">
			<div class="panel-body">
<?php include_once "autoridades_escolaresgrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("referente_tecnico", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $referente_tecnico->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "referente_tecnico") {
			$FirstActiveDetailTable = "referente_tecnico";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_view->DetailPages->PageStyle("referente_tecnico") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_view_details" href="#tab_referente_tecnico"><?php echo $Language->TablePhrase("referente_tecnico", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_view->DetailPages->PageStyle("referente_tecnico") ?>" id="tab_referente_tecnico">
			<div class="panel-body">
<?php include_once "referente_tecnicogrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("piso_tecnologico", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $piso_tecnologico->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "piso_tecnologico") {
			$FirstActiveDetailTable = "piso_tecnologico";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_view->DetailPages->PageStyle("piso_tecnologico") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_view_details" href="#tab_piso_tecnologico"><?php echo $Language->TablePhrase("piso_tecnologico", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_view->DetailPages->PageStyle("piso_tecnologico") ?>" id="tab_piso_tecnologico">
			<div class="panel-body">
<?php include_once "piso_tecnologicogrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("servidor_escolar", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $servidor_escolar->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "servidor_escolar") {
			$FirstActiveDetailTable = "servidor_escolar";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_view->DetailPages->PageStyle("servidor_escolar") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_view_details" href="#tab_servidor_escolar"><?php echo $Language->TablePhrase("servidor_escolar", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_view->DetailPages->PageStyle("servidor_escolar") ?>" id="tab_servidor_escolar">
			<div class="panel-body">
<?php include_once "servidor_escolargrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if (in_array("datos_extras_escuela", explode(",", $dato_establecimiento->getCurrentDetailTable())) && $datos_extras_escuela->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "datos_extras_escuela") {
			$FirstActiveDetailTable = "datos_extras_escuela";
		}
?>
	<div class="panel panel-default<?php echo $dato_establecimiento_view->DetailPages->PageStyle("datos_extras_escuela") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#dato_establecimiento_view_details" href="#tab_datos_extras_escuela"><?php echo $Language->TablePhrase("datos_extras_escuela", "TblCaption") ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $dato_establecimiento_view->DetailPages->PageStyle("datos_extras_escuela") ?>" id="tab_datos_extras_escuela">
			<div class="panel-body">
<?php include_once "datos_extras_escuelagrid.php" ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
</div>
<?php } ?>
</form>
<?php if ($dato_establecimiento->Export == "") { ?>
<script type="text/javascript">
fdato_establecimientoview.Init();
</script>
<?php } ?>
<?php
$dato_establecimiento_view->ShowPageFooter();
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
$dato_establecimiento_view->Page_Terminate();
?>
