<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "prestamo_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$prestamo_equipo_delete = NULL; // Initialize page object first

class cprestamo_equipo_delete extends cprestamo_equipo {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'prestamo_equipo';

	// Page object name
	var $PageObjName = 'prestamo_equipo_delete';

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
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = FALSE;
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

		// Table object (prestamo_equipo)
		if (!isset($GLOBALS["prestamo_equipo"]) || get_class($GLOBALS["prestamo_equipo"]) == "cprestamo_equipo") {
			$GLOBALS["prestamo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["prestamo_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'prestamo_equipo', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("prestamo_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Prestamo->SetVisibility();
		$this->Id_Prestamo->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Apellidos_Nombres_Beneficiario->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Id_Motivo_Prestamo->SetVisibility();
		$this->Id_Estado_Prestamo->SetVisibility();
		$this->Id_Estado_Devol->SetVisibility();

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
		global $EW_EXPORT, $prestamo_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($prestamo_equipo);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("prestamo_equipolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in prestamo_equipo class, prestamo_equipoinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("prestamo_equipolist.php"); // Return to list
			}
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
		$this->Id_Prestamo->setDbValue($rs->fields('Id_Prestamo'));
		$this->Apellidos_Nombres_Beneficiario->setDbValue($rs->fields('Apellidos_Nombres_Beneficiario'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Id_Motivo_Prestamo->setDbValue($rs->fields('Id_Motivo_Prestamo'));
		$this->Fecha_Prestamo->setDbValue($rs->fields('Fecha_Prestamo'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Prestamo_Cargador->setDbValue($rs->fields('Prestamo_Cargador'));
		$this->Id_Estado_Prestamo->setDbValue($rs->fields('Id_Estado_Prestamo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Id_Estado_Devol->setDbValue($rs->fields('Id_Estado_Devol'));
		$this->Devuelve_Cargador->setDbValue($rs->fields('Devuelve_Cargador'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Prestamo->DbValue = $row['Id_Prestamo'];
		$this->Apellidos_Nombres_Beneficiario->DbValue = $row['Apellidos_Nombres_Beneficiario'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Id_Motivo_Prestamo->DbValue = $row['Id_Motivo_Prestamo'];
		$this->Fecha_Prestamo->DbValue = $row['Fecha_Prestamo'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Prestamo_Cargador->DbValue = $row['Prestamo_Cargador'];
		$this->Id_Estado_Prestamo->DbValue = $row['Id_Estado_Prestamo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Id_Estado_Devol->DbValue = $row['Id_Estado_Devol'];
		$this->Devuelve_Cargador->DbValue = $row['Devuelve_Cargador'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Prestamo
		// Apellidos_Nombres_Beneficiario
		// Dni
		// NroSerie
		// Id_Motivo_Prestamo
		// Fecha_Prestamo
		// Observacion
		// Prestamo_Cargador
		// Id_Estado_Prestamo
		// Usuario
		// Fecha_Actualizacion
		// Id_Estado_Devol
		// Devuelve_Cargador

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Prestamo
		$this->Id_Prestamo->ViewValue = $this->Id_Prestamo->CurrentValue;
		$this->Id_Prestamo->ViewCustomAttributes = "";

		// Apellidos_Nombres_Beneficiario
		if (strval($this->Apellidos_Nombres_Beneficiario->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
		$sWhereWrk = "";
		$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`Id_Estado_Espera`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->CurrentValue;
			}
		} else {
			$this->Apellidos_Nombres_Beneficiario->ViewValue = NULL;
		}
		$this->Apellidos_Nombres_Beneficiario->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		$lookuptblfilter = "`Id_Sit_Estado`='3'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// Id_Motivo_Prestamo
		if (strval($this->Id_Motivo_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Motivo_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Prestamo->ViewValue = NULL;
		}
		$this->Id_Motivo_Prestamo->ViewCustomAttributes = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->ViewValue = $this->Fecha_Prestamo->CurrentValue;
		$this->Fecha_Prestamo->ViewValue = ew_FormatDateTime($this->Fecha_Prestamo->ViewValue, 7);
		$this->Fecha_Prestamo->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Prestamo_Cargador
		if (strval($this->Prestamo_Cargador->CurrentValue) <> "") {
			$this->Prestamo_Cargador->ViewValue = $this->Prestamo_Cargador->OptionCaption($this->Prestamo_Cargador->CurrentValue);
		} else {
			$this->Prestamo_Cargador->ViewValue = NULL;
		}
		$this->Prestamo_Cargador->ViewCustomAttributes = "";

		// Id_Estado_Prestamo
		if (strval($this->Id_Estado_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Estado_Prestamo->ViewValue = NULL;
		}
		$this->Id_Estado_Prestamo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Estado_Devol
		if (strval($this->Id_Estado_Devol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_devolucion_prestamo`";
		$sWhereWrk = "";
		$this->Id_Estado_Devol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->CurrentValue;
			}
		} else {
			$this->Id_Estado_Devol->ViewValue = NULL;
		}
		$this->Id_Estado_Devol->ViewCustomAttributes = "";

		// Devuelve_Cargador
		if (strval($this->Devuelve_Cargador->CurrentValue) <> "") {
			$this->Devuelve_Cargador->ViewValue = $this->Devuelve_Cargador->OptionCaption($this->Devuelve_Cargador->CurrentValue);
		} else {
			$this->Devuelve_Cargador->ViewValue = NULL;
		}
		$this->Devuelve_Cargador->ViewCustomAttributes = "";

			// Id_Prestamo
			$this->Id_Prestamo->LinkCustomAttributes = "";
			$this->Id_Prestamo->HrefValue = "";
			$this->Id_Prestamo->TooltipValue = "";

			// Apellidos_Nombres_Beneficiario
			$this->Apellidos_Nombres_Beneficiario->LinkCustomAttributes = "";
			$this->Apellidos_Nombres_Beneficiario->HrefValue = "";
			$this->Apellidos_Nombres_Beneficiario->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";
			$this->Id_Motivo_Prestamo->TooltipValue = "";

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->LinkCustomAttributes = "";
			$this->Id_Estado_Prestamo->HrefValue = "";
			$this->Id_Estado_Prestamo->TooltipValue = "";

			// Id_Estado_Devol
			$this->Id_Estado_Devol->LinkCustomAttributes = "";
			$this->Id_Estado_Devol->HrefValue = "";
			$this->Id_Estado_Devol->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->BeginTrans();
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
				$sThisKey .= $row['Id_Prestamo'];
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
			$conn->CommitTrans(); // Commit the changes
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("prestamo_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
		$table = 'prestamo_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'prestamo_equipo';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Prestamo'];

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
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($prestamo_equipo_delete)) $prestamo_equipo_delete = new cprestamo_equipo_delete();

// Page init
$prestamo_equipo_delete->Page_Init();

// Page main
$prestamo_equipo_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$prestamo_equipo_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fprestamo_equipodelete = new ew_Form("fprestamo_equipodelete", "delete");

// Form_CustomValidate event
fprestamo_equipodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprestamo_equipodelete.ValidateRequired = true;
<?php } else { ?>
fprestamo_equipodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fprestamo_equipodelete.Lists["x_Apellidos_Nombres_Beneficiario"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"lista_espera_prestamo"};
fprestamo_equipodelete.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fprestamo_equipodelete.Lists["x_Id_Motivo_Prestamo"] = {"LinkField":"x_Id_Motivo_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_prestamo_equipo"};
fprestamo_equipodelete.Lists["x_Id_Estado_Prestamo"] = {"LinkField":"x_Id_Estado_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_prestamo_equipo"};
fprestamo_equipodelete.Lists["x_Id_Estado_Devol"] = {"LinkField":"x_Id_Estado_Devol","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_devolucion_prestamo"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $prestamo_equipo_delete->ShowPageHeader(); ?>
<?php
$prestamo_equipo_delete->ShowMessage();
?>
<form name="fprestamo_equipodelete" id="fprestamo_equipodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($prestamo_equipo_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $prestamo_equipo_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="prestamo_equipo">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($prestamo_equipo_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $prestamo_equipo->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($prestamo_equipo->Id_Prestamo->Visible) { // Id_Prestamo ?>
		<th><span id="elh_prestamo_equipo_Id_Prestamo" class="prestamo_equipo_Id_Prestamo"><?php echo $prestamo_equipo->Id_Prestamo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->Apellidos_Nombres_Beneficiario->Visible) { // Apellidos_Nombres_Beneficiario ?>
		<th><span id="elh_prestamo_equipo_Apellidos_Nombres_Beneficiario" class="prestamo_equipo_Apellidos_Nombres_Beneficiario"><?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->Dni->Visible) { // Dni ?>
		<th><span id="elh_prestamo_equipo_Dni" class="prestamo_equipo_Dni"><?php echo $prestamo_equipo->Dni->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->NroSerie->Visible) { // NroSerie ?>
		<th><span id="elh_prestamo_equipo_NroSerie" class="prestamo_equipo_NroSerie"><?php echo $prestamo_equipo->NroSerie->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
		<th><span id="elh_prestamo_equipo_Id_Motivo_Prestamo" class="prestamo_equipo_Id_Motivo_Prestamo"><?php echo $prestamo_equipo->Id_Motivo_Prestamo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Prestamo->Visible) { // Id_Estado_Prestamo ?>
		<th><span id="elh_prestamo_equipo_Id_Estado_Prestamo" class="prestamo_equipo_Id_Estado_Prestamo"><?php echo $prestamo_equipo->Id_Estado_Prestamo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Devol->Visible) { // Id_Estado_Devol ?>
		<th><span id="elh_prestamo_equipo_Id_Estado_Devol" class="prestamo_equipo_Id_Estado_Devol"><?php echo $prestamo_equipo->Id_Estado_Devol->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$prestamo_equipo_delete->RecCnt = 0;
$i = 0;
while (!$prestamo_equipo_delete->Recordset->EOF) {
	$prestamo_equipo_delete->RecCnt++;
	$prestamo_equipo_delete->RowCnt++;

	// Set row properties
	$prestamo_equipo->ResetAttrs();
	$prestamo_equipo->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$prestamo_equipo_delete->LoadRowValues($prestamo_equipo_delete->Recordset);

	// Render row
	$prestamo_equipo_delete->RenderRow();
?>
	<tr<?php echo $prestamo_equipo->RowAttributes() ?>>
<?php if ($prestamo_equipo->Id_Prestamo->Visible) { // Id_Prestamo ?>
		<td<?php echo $prestamo_equipo->Id_Prestamo->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Id_Prestamo" class="prestamo_equipo_Id_Prestamo">
<span<?php echo $prestamo_equipo->Id_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Prestamo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->Apellidos_Nombres_Beneficiario->Visible) { // Apellidos_Nombres_Beneficiario ?>
		<td<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Apellidos_Nombres_Beneficiario" class="prestamo_equipo_Apellidos_Nombres_Beneficiario">
<span<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->Dni->Visible) { // Dni ?>
		<td<?php echo $prestamo_equipo->Dni->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Dni" class="prestamo_equipo_Dni">
<span<?php echo $prestamo_equipo->Dni->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Dni->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->NroSerie->Visible) { // NroSerie ?>
		<td<?php echo $prestamo_equipo->NroSerie->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_NroSerie" class="prestamo_equipo_NroSerie">
<span<?php echo $prestamo_equipo->NroSerie->ViewAttributes() ?>>
<?php echo $prestamo_equipo->NroSerie->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
		<td<?php echo $prestamo_equipo->Id_Motivo_Prestamo->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Id_Motivo_Prestamo" class="prestamo_equipo_Id_Motivo_Prestamo">
<span<?php echo $prestamo_equipo->Id_Motivo_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Motivo_Prestamo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Prestamo->Visible) { // Id_Estado_Prestamo ?>
		<td<?php echo $prestamo_equipo->Id_Estado_Prestamo->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Id_Estado_Prestamo" class="prestamo_equipo_Id_Estado_Prestamo">
<span<?php echo $prestamo_equipo->Id_Estado_Prestamo->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Prestamo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Devol->Visible) { // Id_Estado_Devol ?>
		<td<?php echo $prestamo_equipo->Id_Estado_Devol->CellAttributes() ?>>
<span id="el<?php echo $prestamo_equipo_delete->RowCnt ?>_prestamo_equipo_Id_Estado_Devol" class="prestamo_equipo_Id_Estado_Devol">
<span<?php echo $prestamo_equipo->Id_Estado_Devol->ViewAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Devol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$prestamo_equipo_delete->Recordset->MoveNext();
}
$prestamo_equipo_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $prestamo_equipo_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fprestamo_equipodelete.Init();
</script>
<?php
$prestamo_equipo_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$prestamo_equipo_delete->Page_Terminate();
?>
