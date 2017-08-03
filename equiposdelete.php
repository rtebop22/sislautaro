<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "equiposinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$equipos_delete = NULL; // Initialize page object first

class cequipos_delete extends cequipos {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'equipos';

	// Page object name
	var $PageObjName = 'equipos_delete';

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

		// Table object (equipos)
		if (!isset($GLOBALS["equipos"]) || get_class($GLOBALS["equipos"]) == "cequipos") {
			$GLOBALS["equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["equipos"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'equipos', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("equiposlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NroSerie->SetVisibility();
		$this->NroMac->SetVisibility();
		$this->Id_Ubicacion->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Sit_Estado->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_Ano->SetVisibility();
		$this->Id_Tipo_Equipo->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

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
		global $EW_EXPORT, $equipos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($equipos);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("equiposlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in equipos class, equiposinfo.php

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
				$this->Page_Terminate("equiposlist.php"); // Return to list
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
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->NroMac->setDbValue($rs->fields('NroMac'));
		$this->SpecialNumber->setDbValue($rs->fields('SpecialNumber'));
		$this->Id_Ubicacion->setDbValue($rs->fields('Id_Ubicacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Sit_Estado->setDbValue($rs->fields('Id_Sit_Estado'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_Ano->setDbValue($rs->fields('Id_Ano'));
		$this->Tiene_Cargador->setDbValue($rs->fields('Tiene_Cargador'));
		$this->Id_Tipo_Equipo->setDbValue($rs->fields('Id_Tipo_Equipo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->NroMac->DbValue = $row['NroMac'];
		$this->SpecialNumber->DbValue = $row['SpecialNumber'];
		$this->Id_Ubicacion->DbValue = $row['Id_Ubicacion'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Sit_Estado->DbValue = $row['Id_Sit_Estado'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_Ano->DbValue = $row['Id_Ano'];
		$this->Tiene_Cargador->DbValue = $row['Tiene_Cargador'];
		$this->Id_Tipo_Equipo->DbValue = $row['Id_Tipo_Equipo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// NroSerie
		// NroMac
		// SpecialNumber
		// Id_Ubicacion
		// Id_Estado
		// Id_Sit_Estado
		// Id_Marca
		// Id_Modelo
		// Id_Ano
		// Tiene_Cargador
		// Id_Tipo_Equipo
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->ViewValue = $this->NroMac->CurrentValue;
		$this->NroMac->ViewCustomAttributes = "";

		// SpecialNumber
		$this->SpecialNumber->ViewValue = $this->SpecialNumber->CurrentValue;
		$this->SpecialNumber->ViewCustomAttributes = "";

		// Id_Ubicacion
		if (strval($this->Id_Ubicacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
		$sWhereWrk = "";
		$this->Id_Ubicacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ubicacion->ViewValue = $this->Id_Ubicacion->CurrentValue;
			}
		} else {
			$this->Id_Ubicacion->ViewValue = NULL;
		}
		$this->Id_Ubicacion->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Id_Sit_Estado
		if (strval($this->Id_Sit_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
		$sWhereWrk = "";
		$this->Id_Sit_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sit_Estado->ViewValue = $this->Id_Sit_Estado->CurrentValue;
			}
		} else {
			$this->Id_Sit_Estado->ViewValue = NULL;
		}
		$this->Id_Sit_Estado->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Marca->ViewValue = $this->Id_Marca->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Marca->ViewValue = $this->Id_Marca->CurrentValue;
			}
		} else {
			$this->Id_Marca->ViewValue = NULL;
		}
		$this->Id_Marca->ViewCustomAttributes = "";

		// Id_Modelo
		if (strval($this->Id_Modelo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
		$sWhereWrk = "";
		$this->Id_Modelo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->CurrentValue;
			}
		} else {
			$this->Id_Modelo->ViewValue = NULL;
		}
		$this->Id_Modelo->ViewCustomAttributes = "";

		// Id_Ano
		if (strval($this->Id_Ano->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
		$sWhereWrk = "";
		$this->Id_Ano->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ano->ViewValue = $this->Id_Ano->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ano->ViewValue = $this->Id_Ano->CurrentValue;
			}
		} else {
			$this->Id_Ano->ViewValue = NULL;
		}
		$this->Id_Ano->ViewCustomAttributes = "";

		// Tiene_Cargador
		if (strval($this->Tiene_Cargador->CurrentValue) <> "") {
			$this->Tiene_Cargador->ViewValue = $this->Tiene_Cargador->OptionCaption($this->Tiene_Cargador->CurrentValue);
		} else {
			$this->Tiene_Cargador->ViewValue = NULL;
		}
		$this->Tiene_Cargador->ViewCustomAttributes = "";

		// Id_Tipo_Equipo
		if (strval($this->Id_Tipo_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Equipo`" . ew_SearchString("=", $this->Id_Tipo_Equipo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Equipo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_equipo`";
		$sWhereWrk = "";
		$this->Id_Tipo_Equipo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Equipo->ViewValue = $this->Id_Tipo_Equipo->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Equipo->ViewValue = NULL;
		}
		$this->Id_Tipo_Equipo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewValue = ew_FormatDateTime($this->Usuario->ViewValue, 7);
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// NroMac
			$this->NroMac->LinkCustomAttributes = "";
			$this->NroMac->HrefValue = "";
			$this->NroMac->TooltipValue = "";

			// Id_Ubicacion
			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";
			$this->Id_Ubicacion->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";
			$this->Id_Sit_Estado->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";
			$this->Id_Ano->TooltipValue = "";

			// Id_Tipo_Equipo
			$this->Id_Tipo_Equipo->LinkCustomAttributes = "";
			$this->Id_Tipo_Equipo->HrefValue = "";
			$this->Id_Tipo_Equipo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
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
				$sThisKey .= $row['NroSerie'];
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setQueryStringValue($_GET["fk_NroSerie"]);
					$this->NroSerie->setQueryStringValue($GLOBALS["personas"]->NroSerie->QueryStringValue);
					$this->NroSerie->setSessionValue($this->NroSerie->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "personas") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_NroSerie"] <> "") {
					$GLOBALS["personas"]->NroSerie->setFormValue($_POST["fk_NroSerie"]);
					$this->NroSerie->setFormValue($GLOBALS["personas"]->NroSerie->FormValue);
					$this->NroSerie->setSessionValue($this->NroSerie->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "personas") {
				if ($this->NroSerie->CurrentValue == "") $this->NroSerie->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("equiposlist.php"), "", $this->TableVar, TRUE);
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
		$table = 'equipos';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

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
if (!isset($equipos_delete)) $equipos_delete = new cequipos_delete();

// Page init
$equipos_delete->Page_Init();

// Page main
$equipos_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equipos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fequiposdelete = new ew_Form("fequiposdelete", "delete");

// Form_CustomValidate event
fequiposdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fequiposdelete.ValidateRequired = true;
<?php } else { ?>
fequiposdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fequiposdelete.Lists["x_Id_Ubicacion"] = {"LinkField":"x_Id_Ubicacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ubicacion_equipo"};
fequiposdelete.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo"};
fequiposdelete.Lists["x_Id_Sit_Estado"] = {"LinkField":"x_Id_Sit_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};
fequiposdelete.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Modelo"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca"};
fequiposdelete.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo"};
fequiposdelete.Lists["x_Id_Ano"] = {"LinkField":"x_Id_Ano","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ano_entrega"};
fequiposdelete.Lists["x_Id_Tipo_Equipo"] = {"LinkField":"x_Id_Tipo_Equipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_equipo"};

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
<?php $equipos_delete->ShowPageHeader(); ?>
<?php
$equipos_delete->ShowMessage();
?>
<form name="fequiposdelete" id="fequiposdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($equipos_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $equipos_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="equipos">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($equipos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $equipos->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<th><span id="elh_equipos_NroSerie" class="equipos_NroSerie"><?php echo $equipos->NroSerie->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<th><span id="elh_equipos_NroMac" class="equipos_NroMac"><?php echo $equipos->NroMac->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<th><span id="elh_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion"><?php echo $equipos->Id_Ubicacion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<th><span id="elh_equipos_Id_Estado" class="equipos_Id_Estado"><?php echo $equipos->Id_Estado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<th><span id="elh_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<th><span id="elh_equipos_Id_Marca" class="equipos_Id_Marca"><?php echo $equipos->Id_Marca->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<th><span id="elh_equipos_Id_Modelo" class="equipos_Id_Modelo"><?php echo $equipos->Id_Modelo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<th><span id="elh_equipos_Id_Ano" class="equipos_Id_Ano"><?php echo $equipos->Id_Ano->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<th><span id="elh_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<th><span id="elh_equipos_Usuario" class="equipos_Usuario"><?php echo $equipos->Usuario->FldCaption() ?></span></th>
<?php } ?>
<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<th><span id="elh_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion"><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$equipos_delete->RecCnt = 0;
$i = 0;
while (!$equipos_delete->Recordset->EOF) {
	$equipos_delete->RecCnt++;
	$equipos_delete->RowCnt++;

	// Set row properties
	$equipos->ResetAttrs();
	$equipos->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$equipos_delete->LoadRowValues($equipos_delete->Recordset);

	// Render row
	$equipos_delete->RenderRow();
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td<?php echo $equipos->NroSerie->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_NroSerie" class="equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<?php echo $equipos->NroSerie->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td<?php echo $equipos->NroMac->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_NroMac" class="equipos_NroMac">
<span<?php echo $equipos->NroMac->ViewAttributes() ?>>
<?php echo $equipos->NroMac->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion">
<span<?php echo $equipos->Id_Ubicacion->ViewAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Estado" class="equipos_Id_Estado">
<span<?php echo $equipos->Id_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado">
<span<?php echo $equipos->Id_Sit_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Marca" class="equipos_Id_Marca">
<span<?php echo $equipos->Id_Marca->ViewAttributes() ?>>
<?php echo $equipos->Id_Marca->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Modelo" class="equipos_Id_Modelo">
<span<?php echo $equipos->Id_Modelo->ViewAttributes() ?>>
<?php echo $equipos->Id_Modelo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Ano" class="equipos_Id_Ano">
<span<?php echo $equipos->Id_Ano->ViewAttributes() ?>>
<?php echo $equipos->Id_Ano->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td<?php echo $equipos->Id_Tipo_Equipo->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo">
<span<?php echo $equipos->Id_Tipo_Equipo->ViewAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td<?php echo $equipos->Usuario->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Usuario" class="equipos_Usuario">
<span<?php echo $equipos->Usuario->ViewAttributes() ?>>
<?php echo $equipos->Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td<?php echo $equipos->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $equipos_delete->RowCnt ?>_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion">
<span<?php echo $equipos->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $equipos->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$equipos_delete->Recordset->MoveNext();
}
$equipos_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $equipos_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fequiposdelete.Init();
</script>
<?php
$equipos_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$equipos_delete->Page_Terminate();
?>
