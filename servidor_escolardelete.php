<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "servidor_escolarinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$servidor_escolar_delete = NULL; // Initialize page object first

class cservidor_escolar_delete extends cservidor_escolar {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'servidor_escolar';

	// Page object name
	var $PageObjName = 'servidor_escolar_delete';

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

		// Table object (servidor_escolar)
		if (!isset($GLOBALS["servidor_escolar"]) || get_class($GLOBALS["servidor_escolar"]) == "cservidor_escolar") {
			$GLOBALS["servidor_escolar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["servidor_escolar"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'servidor_escolar', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("servidor_escolarlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Nro_Serie->SetVisibility();
		$this->SN->SetVisibility();
		$this->Cant_Net_Asoc->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_SO->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->User_Server->SetVisibility();
		$this->User_TdServer->SetVisibility();
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
		global $EW_EXPORT, $servidor_escolar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($servidor_escolar);
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
			$this->Page_Terminate("servidor_escolarlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in servidor_escolar class, servidor_escolarinfo.php

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
				$this->Page_Terminate("servidor_escolarlist.php"); // Return to list
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
		$this->Nro_Serie->setDbValue($rs->fields('Nro_Serie'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Cant_Net_Asoc->setDbValue($rs->fields('Cant_Net_Asoc'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_SO->setDbValue($rs->fields('Id_SO'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->User_Server->setDbValue($rs->fields('User_Server'));
		$this->Pass_Server->setDbValue($rs->fields('Pass_Server'));
		$this->User_TdServer->setDbValue($rs->fields('User_TdServer'));
		$this->Pass_TdServer->setDbValue($rs->fields('Pass_TdServer'));
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Nro_Serie->DbValue = $row['Nro_Serie'];
		$this->SN->DbValue = $row['SN'];
		$this->Cant_Net_Asoc->DbValue = $row['Cant_Net_Asoc'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_SO->DbValue = $row['Id_SO'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->User_Server->DbValue = $row['User_Server'];
		$this->Pass_Server->DbValue = $row['Pass_Server'];
		$this->User_TdServer->DbValue = $row['User_TdServer'];
		$this->Pass_TdServer->DbValue = $row['Pass_TdServer'];
		$this->Cue->DbValue = $row['Cue'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Nro_Serie
		// SN
		// Cant_Net_Asoc
		// Id_Marca
		// Id_Modelo
		// Id_SO
		// Id_Estado
		// User_Server
		// Pass_Server
		// User_TdServer
		// Pass_TdServer
		// Cue
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nro_Serie
		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->ViewValue = $this->Cant_Net_Asoc->CurrentValue;
		$this->Cant_Net_Asoc->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
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

		// Id_SO
		if (strval($this->Id_SO->CurrentValue) <> "") {
			$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
		$sWhereWrk = "";
		$this->Id_SO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_SO->ViewValue = $this->Id_SO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_SO->ViewValue = $this->Id_SO->CurrentValue;
			}
		} else {
			$this->Id_SO->ViewValue = NULL;
		}
		$this->Id_SO->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// User_Server
		$this->User_Server->ViewValue = $this->User_Server->CurrentValue;
		$this->User_Server->ViewCustomAttributes = "";

		// Pass_Server
		$this->Pass_Server->ViewValue = $this->Pass_Server->CurrentValue;
		$this->Pass_Server->ViewCustomAttributes = "";

		// User_TdServer
		$this->User_TdServer->ViewValue = $this->User_TdServer->CurrentValue;
		$this->User_TdServer->ViewCustomAttributes = "";

		// Pass_TdServer
		$this->Pass_TdServer->ViewValue = $this->Pass_TdServer->CurrentValue;
		$this->Pass_TdServer->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Nro_Serie
			$this->Nro_Serie->LinkCustomAttributes = "";
			$this->Nro_Serie->HrefValue = "";
			$this->Nro_Serie->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->LinkCustomAttributes = "";
			$this->Cant_Net_Asoc->HrefValue = "";
			$this->Cant_Net_Asoc->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_SO
			$this->Id_SO->LinkCustomAttributes = "";
			$this->Id_SO->HrefValue = "";
			$this->Id_SO->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// User_Server
			$this->User_Server->LinkCustomAttributes = "";
			$this->User_Server->HrefValue = "";
			$this->User_Server->TooltipValue = "";

			// User_TdServer
			$this->User_TdServer->LinkCustomAttributes = "";
			$this->User_TdServer->HrefValue = "";
			$this->User_TdServer->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("servidor_escolarlist.php"), "", $this->TableVar, TRUE);
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
		$table = 'servidor_escolar';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'servidor_escolar';

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
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($servidor_escolar_delete)) $servidor_escolar_delete = new cservidor_escolar_delete();

// Page init
$servidor_escolar_delete->Page_Init();

// Page main
$servidor_escolar_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$servidor_escolar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fservidor_escolardelete = new ew_Form("fservidor_escolardelete", "delete");

// Form_CustomValidate event
fservidor_escolardelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservidor_escolardelete.ValidateRequired = true;
<?php } else { ?>
fservidor_escolardelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fservidor_escolardelete.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca_server"};
fservidor_escolardelete.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo_server"};
fservidor_escolardelete.Lists["x_Id_SO"] = {"LinkField":"x_Id_SO","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"so_server"};
fservidor_escolardelete.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_server"};

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
<?php $servidor_escolar_delete->ShowPageHeader(); ?>
<?php
$servidor_escolar_delete->ShowMessage();
?>
<form name="fservidor_escolardelete" id="fservidor_escolardelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($servidor_escolar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $servidor_escolar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="servidor_escolar">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($servidor_escolar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $servidor_escolar->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
		<th><span id="elh_servidor_escolar_Nro_Serie" class="servidor_escolar_Nro_Serie"><?php echo $servidor_escolar->Nro_Serie->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->SN->Visible) { // SN ?>
		<th><span id="elh_servidor_escolar_SN" class="servidor_escolar_SN"><?php echo $servidor_escolar->SN->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
		<th><span id="elh_servidor_escolar_Cant_Net_Asoc" class="servidor_escolar_Cant_Net_Asoc"><?php echo $servidor_escolar->Cant_Net_Asoc->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
		<th><span id="elh_servidor_escolar_Id_Marca" class="servidor_escolar_Id_Marca"><?php echo $servidor_escolar->Id_Marca->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
		<th><span id="elh_servidor_escolar_Id_Modelo" class="servidor_escolar_Id_Modelo"><?php echo $servidor_escolar->Id_Modelo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
		<th><span id="elh_servidor_escolar_Id_SO" class="servidor_escolar_Id_SO"><?php echo $servidor_escolar->Id_SO->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
		<th><span id="elh_servidor_escolar_Id_Estado" class="servidor_escolar_Id_Estado"><?php echo $servidor_escolar->Id_Estado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
		<th><span id="elh_servidor_escolar_User_Server" class="servidor_escolar_User_Server"><?php echo $servidor_escolar->User_Server->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
		<th><span id="elh_servidor_escolar_User_TdServer" class="servidor_escolar_User_TdServer"><?php echo $servidor_escolar->User_TdServer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<th><span id="elh_servidor_escolar_Fecha_Actualizacion" class="servidor_escolar_Fecha_Actualizacion"><?php echo $servidor_escolar->Fecha_Actualizacion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
		<th><span id="elh_servidor_escolar_Usuario" class="servidor_escolar_Usuario"><?php echo $servidor_escolar->Usuario->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$servidor_escolar_delete->RecCnt = 0;
$i = 0;
while (!$servidor_escolar_delete->Recordset->EOF) {
	$servidor_escolar_delete->RecCnt++;
	$servidor_escolar_delete->RowCnt++;

	// Set row properties
	$servidor_escolar->ResetAttrs();
	$servidor_escolar->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$servidor_escolar_delete->LoadRowValues($servidor_escolar_delete->Recordset);

	// Render row
	$servidor_escolar_delete->RenderRow();
?>
	<tr<?php echo $servidor_escolar->RowAttributes() ?>>
<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
		<td<?php echo $servidor_escolar->Nro_Serie->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Nro_Serie" class="servidor_escolar_Nro_Serie">
<span<?php echo $servidor_escolar->Nro_Serie->ViewAttributes() ?>>
<?php echo $servidor_escolar->Nro_Serie->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->SN->Visible) { // SN ?>
		<td<?php echo $servidor_escolar->SN->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_SN" class="servidor_escolar_SN">
<span<?php echo $servidor_escolar->SN->ViewAttributes() ?>>
<?php echo $servidor_escolar->SN->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
		<td<?php echo $servidor_escolar->Cant_Net_Asoc->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Cant_Net_Asoc" class="servidor_escolar_Cant_Net_Asoc">
<span<?php echo $servidor_escolar->Cant_Net_Asoc->ViewAttributes() ?>>
<?php echo $servidor_escolar->Cant_Net_Asoc->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
		<td<?php echo $servidor_escolar->Id_Marca->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Id_Marca" class="servidor_escolar_Id_Marca">
<span<?php echo $servidor_escolar->Id_Marca->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
		<td<?php echo $servidor_escolar->Id_Modelo->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Id_Modelo" class="servidor_escolar_Id_Modelo">
<span<?php echo $servidor_escolar->Id_Modelo->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
		<td<?php echo $servidor_escolar->Id_SO->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Id_SO" class="servidor_escolar_Id_SO">
<span<?php echo $servidor_escolar->Id_SO->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
		<td<?php echo $servidor_escolar->Id_Estado->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Id_Estado" class="servidor_escolar_Id_Estado">
<span<?php echo $servidor_escolar->Id_Estado->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
		<td<?php echo $servidor_escolar->User_Server->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_User_Server" class="servidor_escolar_User_Server">
<span<?php echo $servidor_escolar->User_Server->ViewAttributes() ?>>
<?php echo $servidor_escolar->User_Server->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
		<td<?php echo $servidor_escolar->User_TdServer->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_User_TdServer" class="servidor_escolar_User_TdServer">
<span<?php echo $servidor_escolar->User_TdServer->ViewAttributes() ?>>
<?php echo $servidor_escolar->User_TdServer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td<?php echo $servidor_escolar->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Fecha_Actualizacion" class="servidor_escolar_Fecha_Actualizacion">
<span<?php echo $servidor_escolar->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $servidor_escolar->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
		<td<?php echo $servidor_escolar->Usuario->CellAttributes() ?>>
<span id="el<?php echo $servidor_escolar_delete->RowCnt ?>_servidor_escolar_Usuario" class="servidor_escolar_Usuario">
<span<?php echo $servidor_escolar->Usuario->ViewAttributes() ?>>
<?php echo $servidor_escolar->Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$servidor_escolar_delete->Recordset->MoveNext();
}
$servidor_escolar_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $servidor_escolar_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fservidor_escolardelete.Init();
</script>
<?php
$servidor_escolar_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$servidor_escolar_delete->Page_Terminate();
?>
