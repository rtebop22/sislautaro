<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "piso_tecnologicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$piso_tecnologico_delete = NULL; // Initialize page object first

class cpiso_tecnologico_delete extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_delete';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'piso_tecnologico', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("piso_tecnologicolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Switch->SetVisibility();
		$this->Estado_Switch->SetVisibility();
		$this->Cantidad_Ap->SetVisibility();
		$this->Estado_Ap->SetVisibility();
		$this->Porcent_Estado_Ap->SetVisibility();
		$this->Ups->SetVisibility();
		$this->Estado_Ups->SetVisibility();
		$this->Cableado->SetVisibility();
		$this->Estado_Cableado->SetVisibility();
		$this->Porcent_Estado_Cab->SetVisibility();
		$this->Plano_Escuela->SetVisibility();
		$this->Porcent_Func_Piso->SetVisibility();
		$this->Ultima_Actualizacion->SetVisibility();
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
		global $EW_EXPORT, $piso_tecnologico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($piso_tecnologico);
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
			$this->Page_Terminate("piso_tecnologicolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in piso_tecnologico class, piso_tecnologicoinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("piso_tecnologicolist.php"); // Return to list
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
		$this->Id_Piso->setDbValue($rs->fields('Id_Piso'));
		$this->Switch->setDbValue($rs->fields('Switch'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado_Switch'));
		$this->Cantidad_Ap->setDbValue($rs->fields('Cantidad_Ap'));
		$this->Estado_Ap->setDbValue($rs->fields('Estado_Ap'));
		$this->Porcent_Estado_Ap->setDbValue($rs->fields('Porcent_Estado_Ap'));
		$this->Ups->setDbValue($rs->fields('Ups'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado_Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado_Cableado'));
		$this->Porcent_Estado_Cab->setDbValue($rs->fields('Porcent_Estado_Cab'));
		$this->Plano_Escuela->Upload->DbValue = $rs->fields('Plano_Escuela');
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Porcent_Func_Piso->setDbValue($rs->fields('Porcent_Func_Piso'));
		$this->Ultima_Actualizacion->setDbValue($rs->fields('Ultima_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Piso->DbValue = $row['Id_Piso'];
		$this->Switch->DbValue = $row['Switch'];
		$this->Estado_Switch->DbValue = $row['Estado_Switch'];
		$this->Cantidad_Ap->DbValue = $row['Cantidad_Ap'];
		$this->Estado_Ap->DbValue = $row['Estado_Ap'];
		$this->Porcent_Estado_Ap->DbValue = $row['Porcent_Estado_Ap'];
		$this->Ups->DbValue = $row['Ups'];
		$this->Estado_Ups->DbValue = $row['Estado_Ups'];
		$this->Cableado->DbValue = $row['Cableado'];
		$this->Estado_Cableado->DbValue = $row['Estado_Cableado'];
		$this->Porcent_Estado_Cab->DbValue = $row['Porcent_Estado_Cab'];
		$this->Plano_Escuela->Upload->DbValue = $row['Plano_Escuela'];
		$this->Porcent_Func_Piso->DbValue = $row['Porcent_Func_Piso'];
		$this->Ultima_Actualizacion->DbValue = $row['Ultima_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Piso

		$this->Id_Piso->CellCssStyle = "white-space: nowrap;";

		// Switch
		// Estado_Switch
		// Cantidad_Ap
		// Estado_Ap
		// Porcent_Estado_Ap
		// Ups
		// Estado_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Plano_Escuela
		// Porcent_Func_Piso
		// Ultima_Actualizacion
		// Usuario
		// Cue

		$this->Cue->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Estado_Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->CurrentValue;
			}
		} else {
			$this->Estado_Switch->ViewValue = NULL;
		}
		$this->Estado_Switch->ViewCustomAttributes = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->ViewValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->ViewCustomAttributes = "";

		// Estado_Ap
		if (strval($this->Estado_Ap->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ap->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ap->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ap, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->CurrentValue;
			}
		} else {
			$this->Estado_Ap->ViewValue = NULL;
		}
		$this->Estado_Ap->ViewCustomAttributes = "";

		// Porcent_Estado_Ap
		$this->Porcent_Estado_Ap->ViewValue = $this->Porcent_Estado_Ap->CurrentValue;
		$this->Porcent_Estado_Ap->ViewCustomAttributes = "";

		// Ups
		if (strval($this->Ups->CurrentValue) <> "") {
			$this->Ups->ViewValue = $this->Ups->OptionCaption($this->Ups->CurrentValue);
		} else {
			$this->Ups->ViewValue = NULL;
		}
		$this->Ups->ViewCustomAttributes = "";

		// Estado_Ups
		if (strval($this->Estado_Ups->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ups->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->CurrentValue;
			}
		} else {
			$this->Estado_Ups->ViewValue = NULL;
		}
		$this->Estado_Ups->ViewCustomAttributes = "";

		// Cableado
		if (strval($this->Cableado->CurrentValue) <> "") {
			$this->Cableado->ViewValue = $this->Cableado->OptionCaption($this->Cableado->CurrentValue);
		} else {
			$this->Cableado->ViewValue = NULL;
		}
		$this->Cableado->ViewCustomAttributes = "";

		// Estado_Cableado
		if (strval($this->Estado_Cableado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Cableado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->CurrentValue;
			}
		} else {
			$this->Estado_Cableado->ViewValue = NULL;
		}
		$this->Estado_Cableado->ViewCustomAttributes = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->ViewValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->ViewCustomAttributes = "";

		// Plano_Escuela
		if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
			$this->Plano_Escuela->ViewValue = $this->Plano_Escuela->Upload->DbValue;
		} else {
			$this->Plano_Escuela->ViewValue = "";
		}
		$this->Plano_Escuela->ViewCustomAttributes = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 7);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Switch
			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";
			$this->Switch->TooltipValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";
			$this->Estado_Switch->TooltipValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";
			$this->Cantidad_Ap->TooltipValue = "";

			// Estado_Ap
			$this->Estado_Ap->LinkCustomAttributes = "";
			$this->Estado_Ap->HrefValue = "";
			$this->Estado_Ap->TooltipValue = "";

			// Porcent_Estado_Ap
			$this->Porcent_Estado_Ap->LinkCustomAttributes = "";
			$this->Porcent_Estado_Ap->HrefValue = "";
			$this->Porcent_Estado_Ap->TooltipValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";
			$this->Ups->TooltipValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";
			$this->Estado_Ups->TooltipValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";
			$this->Cableado->TooltipValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";
			$this->Estado_Cableado->TooltipValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";
			$this->Porcent_Estado_Cab->TooltipValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;
			$this->Plano_Escuela->TooltipValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";
			$this->Porcent_Func_Piso->TooltipValue = "";

			// Ultima_Actualizacion
			$this->Ultima_Actualizacion->LinkCustomAttributes = "";
			$this->Ultima_Actualizacion->HrefValue = "";
			$this->Ultima_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
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
				$sThisKey .= $row['Id_Piso'];
				$this->LoadDbValues($row);
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $row['Plano_Escuela']);
				$FileCount = count($OldFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setQueryStringValue($_GET["fk_Cue"]);
					$this->Cue->setQueryStringValue($GLOBALS["dato_establecimiento"]->Cue->QueryStringValue);
					$this->Cue->setSessionValue($this->Cue->QueryStringValue);
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setFormValue($_POST["fk_Cue"]);
					$this->Cue->setFormValue($GLOBALS["dato_establecimiento"]->Cue->FormValue);
					$this->Cue->setSessionValue($this->Cue->FormValue);
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
			if ($sMasterTblVar <> "dato_establecimiento") {
				if ($this->Cue->CurrentValue == "") $this->Cue->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("piso_tecnologicolist.php"), "", $this->TableVar, TRUE);
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
		$table = 'piso_tecnologico';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'piso_tecnologico';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Piso'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
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
if (!isset($piso_tecnologico_delete)) $piso_tecnologico_delete = new cpiso_tecnologico_delete();

// Page init
$piso_tecnologico_delete->Page_Init();

// Page main
$piso_tecnologico_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpiso_tecnologicodelete = new ew_Form("fpiso_tecnologicodelete", "delete");

// Form_CustomValidate event
fpiso_tecnologicodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicodelete.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicodelete.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicodelete.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicodelete.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicodelete.Lists["x_Estado_Ap"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicodelete.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicodelete.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicodelete.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicodelete.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicodelete.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicodelete.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

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
<?php $piso_tecnologico_delete->ShowPageHeader(); ?>
<?php
$piso_tecnologico_delete->ShowMessage();
?>
<form name="fpiso_tecnologicodelete" id="fpiso_tecnologicodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($piso_tecnologico_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $piso_tecnologico->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<th><span id="elh_piso_tecnologico_Switch" class="piso_tecnologico_Switch"><?php echo $piso_tecnologico->Switch->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<th><span id="elh_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<th><span id="elh_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ap->Visible) { // Estado_Ap ?>
		<th><span id="elh_piso_tecnologico_Estado_Ap" class="piso_tecnologico_Estado_Ap"><?php echo $piso_tecnologico->Estado_Ap->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Ap->Visible) { // Porcent_Estado_Ap ?>
		<th><span id="elh_piso_tecnologico_Porcent_Estado_Ap" class="piso_tecnologico_Porcent_Estado_Ap"><?php echo $piso_tecnologico->Porcent_Estado_Ap->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<th><span id="elh_piso_tecnologico_Ups" class="piso_tecnologico_Ups"><?php echo $piso_tecnologico->Ups->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<th><span id="elh_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<th><span id="elh_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<th><span id="elh_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<th><span id="elh_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<th><span id="elh_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<th><span id="elh_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Ultima_Actualizacion->Visible) { // Ultima_Actualizacion ?>
		<th><span id="elh_piso_tecnologico_Ultima_Actualizacion" class="piso_tecnologico_Ultima_Actualizacion"><?php echo $piso_tecnologico->Ultima_Actualizacion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<th><span id="elh_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$piso_tecnologico_delete->RecCnt = 0;
$i = 0;
while (!$piso_tecnologico_delete->Recordset->EOF) {
	$piso_tecnologico_delete->RecCnt++;
	$piso_tecnologico_delete->RowCnt++;

	// Set row properties
	$piso_tecnologico->ResetAttrs();
	$piso_tecnologico->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$piso_tecnologico_delete->LoadRowValues($piso_tecnologico_delete->Recordset);

	// Render row
	$piso_tecnologico_delete->RenderRow();
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Switch" class="piso_tecnologico_Switch">
<span<?php echo $piso_tecnologico->Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Switch->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch">
<span<?php echo $piso_tecnologico->Estado_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap">
<span<?php echo $piso_tecnologico->Cantidad_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ap->Visible) { // Estado_Ap ?>
		<td<?php echo $piso_tecnologico->Estado_Ap->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Estado_Ap" class="piso_tecnologico_Estado_Ap">
<span<?php echo $piso_tecnologico->Estado_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ap->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Ap->Visible) { // Porcent_Estado_Ap ?>
		<td<?php echo $piso_tecnologico->Porcent_Estado_Ap->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Porcent_Estado_Ap" class="piso_tecnologico_Porcent_Estado_Ap">
<span<?php echo $piso_tecnologico->Porcent_Estado_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Estado_Ap->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Ups" class="piso_tecnologico_Ups">
<span<?php echo $piso_tecnologico->Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Ups->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups">
<span<?php echo $piso_tecnologico->Estado_Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado">
<span<?php echo $piso_tecnologico->Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cableado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado">
<span<?php echo $piso_tecnologico->Estado_Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab">
<span<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela">
<span<?php echo $piso_tecnologico->Plano_Escuela->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($piso_tecnologico->Plano_Escuela, $piso_tecnologico->Plano_Escuela->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso">
<span<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Func_Piso->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Ultima_Actualizacion->Visible) { // Ultima_Actualizacion ?>
		<td<?php echo $piso_tecnologico->Ultima_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Ultima_Actualizacion" class="piso_tecnologico_Ultima_Actualizacion">
<span<?php echo $piso_tecnologico->Ultima_Actualizacion->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Ultima_Actualizacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td<?php echo $piso_tecnologico->Usuario->CellAttributes() ?>>
<span id="el<?php echo $piso_tecnologico_delete->RowCnt ?>_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario">
<span<?php echo $piso_tecnologico->Usuario->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$piso_tecnologico_delete->Recordset->MoveNext();
}
$piso_tecnologico_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $piso_tecnologico_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpiso_tecnologicodelete.Init();
</script>
<?php
$piso_tecnologico_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_delete->Page_Terminate();
?>
