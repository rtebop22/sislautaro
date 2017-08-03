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

$pase_establecimiento_delete = NULL; // Initialize page object first

class cpase_establecimiento_delete extends cpase_establecimiento {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pase_establecimiento';

	// Page object name
	var $PageObjName = 'pase_establecimiento_delete';

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

		// Table object (pase_establecimiento)
		if (!isset($GLOBALS["pase_establecimiento"]) || get_class($GLOBALS["pase_establecimiento"]) == "cpase_establecimiento") {
			$GLOBALS["pase_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pase_establecimiento"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pase_establecimientolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Pase->SetVisibility();
		$this->Id_Pase->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Equipo->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->Nombre_Titular->SetVisibility();
		$this->Cuil_Titular->SetVisibility();
		$this->Cue_Establecimiento_Alta->SetVisibility();
		$this->Escuela_Alta->SetVisibility();
		$this->Cue_Establecimiento_Baja->SetVisibility();
		$this->Escuela_Baja->SetVisibility();
		$this->Fecha_Pase->SetVisibility();
		$this->Id_Estado_Pase->SetVisibility();

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
			$this->Page_Terminate("pase_establecimientolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in pase_establecimiento class, pase_establecimientoinfo.php

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
				$this->Page_Terminate("pase_establecimientolist.php"); // Return to list
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
		$this->Id_Pase->setDbValue($rs->fields('Id_Pase'));
		$this->Serie_Equipo->setDbValue($rs->fields('Serie_Equipo'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Modelo_Net->setDbValue($rs->fields('Modelo_Net'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Nombre_Titular->setDbValue($rs->fields('Nombre_Titular'));
		$this->Dni_Titular->setDbValue($rs->fields('Dni_Titular'));
		$this->Cuil_Titular->setDbValue($rs->fields('Cuil_Titular'));
		$this->Nombre_Tutor->setDbValue($rs->fields('Nombre_Tutor'));
		$this->DniTutor->setDbValue($rs->fields('DniTutor'));
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
		$this->Tel_Rte_Alta->setDbValue($rs->fields('Tel_Rte_Alta'));
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
		$this->Fecha_Pase->setDbValue($rs->fields('Fecha_Pase'));
		$this->Id_Estado_Pase->setDbValue($rs->fields('Id_Estado_Pase'));
		$this->Ruta_Archivo->Upload->DbValue = $rs->fields('Ruta_Archivo');
		$this->Ruta_Archivo->CurrentValue = $this->Ruta_Archivo->Upload->DbValue;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Pase->DbValue = $row['Id_Pase'];
		$this->Serie_Equipo->DbValue = $row['Serie_Equipo'];
		$this->Id_Hardware->DbValue = $row['Id_Hardware'];
		$this->SN->DbValue = $row['SN'];
		$this->Modelo_Net->DbValue = $row['Modelo_Net'];
		$this->Marca_Arranque->DbValue = $row['Marca_Arranque'];
		$this->Nombre_Titular->DbValue = $row['Nombre_Titular'];
		$this->Dni_Titular->DbValue = $row['Dni_Titular'];
		$this->Cuil_Titular->DbValue = $row['Cuil_Titular'];
		$this->Nombre_Tutor->DbValue = $row['Nombre_Tutor'];
		$this->DniTutor->DbValue = $row['DniTutor'];
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
		$this->Tel_Rte_Alta->DbValue = $row['Tel_Rte_Alta'];
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
		$this->Fecha_Pase->DbValue = $row['Fecha_Pase'];
		$this->Id_Estado_Pase->DbValue = $row['Id_Estado_Pase'];
		$this->Ruta_Archivo->Upload->DbValue = $row['Ruta_Archivo'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Pase
		// Serie_Equipo
		// Id_Hardware
		// SN
		// Modelo_Net
		// Marca_Arranque
		// Nombre_Titular
		// Dni_Titular
		// Cuil_Titular
		// Nombre_Tutor
		// DniTutor
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
		// Tel_Rte_Alta
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
		// Fecha_Pase
		// Id_Estado_Pase
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

		// Nombre_Tutor
		$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
		if (strval($this->Nombre_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Tutor->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
			}
		} else {
			$this->Nombre_Tutor->ViewValue = NULL;
		}
		$this->Nombre_Tutor->ViewCustomAttributes = "";

		// DniTutor
		$this->DniTutor->ViewValue = $this->DniTutor->CurrentValue;
		$this->DniTutor->ViewCustomAttributes = "";

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

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->ViewValue = $this->Tel_Rte_Alta->CurrentValue;
		$this->Tel_Rte_Alta->ViewCustomAttributes = "";

		// Email_Rte_Alta
		$this->Email_Rte_Alta->ViewValue = $this->Email_Rte_Alta->CurrentValue;
		$this->Email_Rte_Alta->ViewCustomAttributes = "";

		// Serie_Server_Alta
		$this->Serie_Server_Alta->ViewValue = $this->Serie_Server_Alta->CurrentValue;
		$this->Serie_Server_Alta->ViewCustomAttributes = "";

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
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

			// Id_Pase
			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";
			$this->Id_Pase->TooltipValue = "";

			// Serie_Equipo
			$this->Serie_Equipo->LinkCustomAttributes = "";
			$this->Serie_Equipo->HrefValue = "";
			$this->Serie_Equipo->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// Nombre_Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Cuil_Titular
			$this->Cuil_Titular->LinkCustomAttributes = "";
			$this->Cuil_Titular->HrefValue = "";
			$this->Cuil_Titular->TooltipValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";
			$this->Cue_Establecimiento_Alta->TooltipValue = "";

			// Escuela_Alta
			$this->Escuela_Alta->LinkCustomAttributes = "";
			$this->Escuela_Alta->HrefValue = "";
			$this->Escuela_Alta->TooltipValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";
			$this->Cue_Establecimiento_Baja->TooltipValue = "";

			// Escuela_Baja
			$this->Escuela_Baja->LinkCustomAttributes = "";
			$this->Escuela_Baja->HrefValue = "";
			$this->Escuela_Baja->TooltipValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";
			$this->Fecha_Pase->TooltipValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
			$this->Id_Estado_Pase->TooltipValue = "";
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
				$sThisKey .= $row['Id_Pase'];
				$this->LoadDbValues($row);
				$this->Ruta_Archivo->OldUploadPath = 'ArchivosPase';
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $row['Ruta_Archivo']);
				$FileCount = count($OldFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					@unlink(ew_UploadPathEx(TRUE, $this->Ruta_Archivo->OldUploadPath) . $OldFiles[$i]);
				}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pase_establecimientolist.php"), "", $this->TableVar, TRUE);
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
		$table = 'pase_establecimiento';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'pase_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Pase'];

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
if (!isset($pase_establecimiento_delete)) $pase_establecimiento_delete = new cpase_establecimiento_delete();

// Page init
$pase_establecimiento_delete->Page_Init();

// Page main
$pase_establecimiento_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pase_establecimiento_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpase_establecimientodelete = new ew_Form("fpase_establecimientodelete", "delete");

// Form_CustomValidate event
fpase_establecimientodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpase_establecimientodelete.ValidateRequired = true;
<?php } else { ?>
fpase_establecimientodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpase_establecimientodelete.Lists["x_Serie_Equipo"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpase_establecimientodelete.Lists["x_Nombre_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fpase_establecimientodelete.Lists["x_Cue_Establecimiento_Alta"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientodelete.Lists["x_Cue_Establecimiento_Baja"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientodelete.Lists["x_Id_Estado_Pase"] = {"LinkField":"x_Id_Estado_Pase","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_pase"};

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
<?php $pase_establecimiento_delete->ShowPageHeader(); ?>
<?php
$pase_establecimiento_delete->ShowMessage();
?>
<form name="fpase_establecimientodelete" id="fpase_establecimientodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pase_establecimiento_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pase_establecimiento_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pase_establecimiento">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($pase_establecimiento_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $pase_establecimiento->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
		<th><span id="elh_pase_establecimiento_Id_Pase" class="pase_establecimiento_Id_Pase"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Equipo->Visible) { // Serie_Equipo ?>
		<th><span id="elh_pase_establecimiento_Serie_Equipo" class="pase_establecimiento_Serie_Equipo"><?php echo $pase_establecimiento->Serie_Equipo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Id_Hardware->Visible) { // Id_Hardware ?>
		<th><span id="elh_pase_establecimiento_Id_Hardware" class="pase_establecimiento_Id_Hardware"><?php echo $pase_establecimiento->Id_Hardware->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Titular->Visible) { // Nombre_Titular ?>
		<th><span id="elh_pase_establecimiento_Nombre_Titular" class="pase_establecimiento_Nombre_Titular"><?php echo $pase_establecimiento->Nombre_Titular->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Titular->Visible) { // Cuil_Titular ?>
		<th><span id="elh_pase_establecimiento_Cuil_Titular" class="pase_establecimiento_Cuil_Titular"><?php echo $pase_establecimiento->Cuil_Titular->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
		<th><span id="elh_pase_establecimiento_Cue_Establecimiento_Alta" class="pase_establecimiento_Cue_Establecimiento_Alta"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Alta->Visible) { // Escuela_Alta ?>
		<th><span id="elh_pase_establecimiento_Escuela_Alta" class="pase_establecimiento_Escuela_Alta"><?php echo $pase_establecimiento->Escuela_Alta->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
		<th><span id="elh_pase_establecimiento_Cue_Establecimiento_Baja" class="pase_establecimiento_Cue_Establecimiento_Baja"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Baja->Visible) { // Escuela_Baja ?>
		<th><span id="elh_pase_establecimiento_Escuela_Baja" class="pase_establecimiento_Escuela_Baja"><?php echo $pase_establecimiento->Escuela_Baja->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
		<th><span id="elh_pase_establecimiento_Fecha_Pase" class="pase_establecimiento_Fecha_Pase"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
		<th><span id="elh_pase_establecimiento_Id_Estado_Pase" class="pase_establecimiento_Id_Estado_Pase"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pase_establecimiento_delete->RecCnt = 0;
$i = 0;
while (!$pase_establecimiento_delete->Recordset->EOF) {
	$pase_establecimiento_delete->RecCnt++;
	$pase_establecimiento_delete->RowCnt++;

	// Set row properties
	$pase_establecimiento->ResetAttrs();
	$pase_establecimiento->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$pase_establecimiento_delete->LoadRowValues($pase_establecimiento_delete->Recordset);

	// Render row
	$pase_establecimiento_delete->RenderRow();
?>
	<tr<?php echo $pase_establecimiento->RowAttributes() ?>>
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
		<td<?php echo $pase_establecimiento->Id_Pase->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Id_Pase" class="pase_establecimiento_Id_Pase">
<span<?php echo $pase_establecimiento->Id_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Pase->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Equipo->Visible) { // Serie_Equipo ?>
		<td<?php echo $pase_establecimiento->Serie_Equipo->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Serie_Equipo" class="pase_establecimiento_Serie_Equipo">
<span<?php echo $pase_establecimiento->Serie_Equipo->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Serie_Equipo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Id_Hardware->Visible) { // Id_Hardware ?>
		<td<?php echo $pase_establecimiento->Id_Hardware->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Id_Hardware" class="pase_establecimiento_Id_Hardware">
<span<?php echo $pase_establecimiento->Id_Hardware->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Hardware->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Titular->Visible) { // Nombre_Titular ?>
		<td<?php echo $pase_establecimiento->Nombre_Titular->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Nombre_Titular" class="pase_establecimiento_Nombre_Titular">
<span<?php echo $pase_establecimiento->Nombre_Titular->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Nombre_Titular->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Titular->Visible) { // Cuil_Titular ?>
		<td<?php echo $pase_establecimiento->Cuil_Titular->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Cuil_Titular" class="pase_establecimiento_Cuil_Titular">
<span<?php echo $pase_establecimiento->Cuil_Titular->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cuil_Titular->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
		<td<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Alta" class="pase_establecimiento_Cue_Establecimiento_Alta">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Alta->Visible) { // Escuela_Alta ?>
		<td<?php echo $pase_establecimiento->Escuela_Alta->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Escuela_Alta" class="pase_establecimiento_Escuela_Alta">
<span<?php echo $pase_establecimiento->Escuela_Alta->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Escuela_Alta->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
		<td<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Cue_Establecimiento_Baja" class="pase_establecimiento_Cue_Establecimiento_Baja">
<span<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Baja->Visible) { // Escuela_Baja ?>
		<td<?php echo $pase_establecimiento->Escuela_Baja->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Escuela_Baja" class="pase_establecimiento_Escuela_Baja">
<span<?php echo $pase_establecimiento->Escuela_Baja->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Escuela_Baja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
		<td<?php echo $pase_establecimiento->Fecha_Pase->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Fecha_Pase" class="pase_establecimiento_Fecha_Pase">
<span<?php echo $pase_establecimiento->Fecha_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Fecha_Pase->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
		<td<?php echo $pase_establecimiento->Id_Estado_Pase->CellAttributes() ?>>
<span id="el<?php echo $pase_establecimiento_delete->RowCnt ?>_pase_establecimiento_Id_Estado_Pase" class="pase_establecimiento_Id_Estado_Pase">
<span<?php echo $pase_establecimiento->Id_Estado_Pase->ViewAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pase_establecimiento_delete->Recordset->MoveNext();
}
$pase_establecimiento_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pase_establecimiento_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpase_establecimientodelete.Init();
</script>
<?php
$pase_establecimiento_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pase_establecimiento_delete->Page_Terminate();
?>
