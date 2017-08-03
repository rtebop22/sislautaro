<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "paquetes_provisioninfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$paquetes_provision_delete = NULL; // Initialize page object first

class cpaquetes_provision_delete extends cpaquetes_provision {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'paquetes_provision';

	// Page object name
	var $PageObjName = 'paquetes_provision_delete';

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

		// Table object (paquetes_provision)
		if (!isset($GLOBALS["paquetes_provision"]) || get_class($GLOBALS["paquetes_provision"]) == "cpaquetes_provision") {
			$GLOBALS["paquetes_provision"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["paquetes_provision"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'paquetes_provision', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("paquetes_provisionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Serie_Netbook->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Serie_Server->SetVisibility();
		$this->Id_Motivo->SetVisibility();
		$this->Id_Tipo_Extraccion->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->Id_Tipo_Paquete->SetVisibility();
		$this->Apellido_Nombre_Solicitante->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Email_Solicitante->SetVisibility();
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
		global $EW_EXPORT, $paquetes_provision;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($paquetes_provision);
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
			$this->Page_Terminate("paquetes_provisionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in paquetes_provision class, paquetes_provisioninfo.php

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
				$this->Page_Terminate("paquetes_provisionlist.php"); // Return to list
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
		$this->NroPedido->setDbValue($rs->fields('NroPedido'));
		$this->Serie_Netbook->setDbValue($rs->fields('Serie_Netbook'));
		$this->Id_Hardware->setDbValue($rs->fields('Id_Hardware'));
		$this->SN->setDbValue($rs->fields('SN'));
		$this->Marca_Arranque->setDbValue($rs->fields('Marca_Arranque'));
		$this->Serie_Server->setDbValue($rs->fields('Serie_Server'));
		$this->Id_Motivo->setDbValue($rs->fields('Id_Motivo'));
		$this->Id_Tipo_Extraccion->setDbValue($rs->fields('Id_Tipo_Extraccion'));
		$this->Id_Estado_Paquete->setDbValue($rs->fields('Id_Estado_Paquete'));
		$this->Id_Tipo_Paquete->setDbValue($rs->fields('Id_Tipo_Paquete'));
		$this->Apellido_Nombre_Solicitante->setDbValue($rs->fields('Apellido_Nombre_Solicitante'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Email_Solicitante->setDbValue($rs->fields('Email_Solicitante'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroPedido->DbValue = $row['NroPedido'];
		$this->Serie_Netbook->DbValue = $row['Serie_Netbook'];
		$this->Id_Hardware->DbValue = $row['Id_Hardware'];
		$this->SN->DbValue = $row['SN'];
		$this->Marca_Arranque->DbValue = $row['Marca_Arranque'];
		$this->Serie_Server->DbValue = $row['Serie_Server'];
		$this->Id_Motivo->DbValue = $row['Id_Motivo'];
		$this->Id_Tipo_Extraccion->DbValue = $row['Id_Tipo_Extraccion'];
		$this->Id_Estado_Paquete->DbValue = $row['Id_Estado_Paquete'];
		$this->Id_Tipo_Paquete->DbValue = $row['Id_Tipo_Paquete'];
		$this->Apellido_Nombre_Solicitante->DbValue = $row['Apellido_Nombre_Solicitante'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Email_Solicitante->DbValue = $row['Email_Solicitante'];
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
		// NroPedido
		// Serie_Netbook
		// Id_Hardware
		// SN
		// Marca_Arranque
		// Serie_Server
		// Id_Motivo
		// Id_Tipo_Extraccion
		// Id_Estado_Paquete
		// Id_Tipo_Paquete
		// Apellido_Nombre_Solicitante
		// Dni
		// Email_Solicitante
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroPedido
		$this->NroPedido->ViewValue = $this->NroPedido->CurrentValue;
		$this->NroPedido->ViewCustomAttributes = "";

		// Serie_Netbook
		$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
		if (strval($this->Serie_Netbook->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
			}
		} else {
			$this->Serie_Netbook->ViewValue = NULL;
		}
		$this->Serie_Netbook->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		if (strval($this->Id_Hardware->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Id_Hardware->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
			}
		} else {
			$this->Id_Hardware->ViewValue = NULL;
		}
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Serie_Server
		$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
		if (strval($this->Serie_Server->CurrentValue) <> "") {
			$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
		$sWhereWrk = "";
		$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Server->ViewValue = $this->Serie_Server->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
			}
		} else {
			$this->Serie_Server->ViewValue = NULL;
		}
		$this->Serie_Server->ViewCustomAttributes = "";

		// Id_Motivo
		if (strval($this->Id_Motivo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Id_Motivo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->CurrentValue;
			}
		} else {
			$this->Id_Motivo->ViewValue = NULL;
		}
		$this->Id_Motivo->ViewCustomAttributes = "";

		// Id_Tipo_Extraccion
		if (strval($this->Id_Tipo_Extraccion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->Id_Tipo_Extraccion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Extraccion->ViewValue = NULL;
		}
		$this->Id_Tipo_Extraccion->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		if (strval($this->Id_Estado_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
		$sWhereWrk = "";
		$this->Id_Estado_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Estado_Paquete->ViewValue = NULL;
		}
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// Id_Tipo_Paquete
		if (strval($this->Id_Tipo_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
		$sWhereWrk = "";
		$this->Id_Tipo_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Paquete->ViewValue = NULL;
		}
		$this->Id_Tipo_Paquete->ViewCustomAttributes = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
			$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
		$sWhereWrk = "";
		$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
			}
		} else {
			$this->Apellido_Nombre_Solicitante->ViewValue = NULL;
		}
		$this->Apellido_Nombre_Solicitante->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Email_Solicitante
		$this->Email_Solicitante->ViewValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Serie_Netbook
			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";
			$this->Serie_Netbook->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";
			$this->Marca_Arranque->TooltipValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";
			$this->Serie_Server->TooltipValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";
			$this->Id_Motivo->TooltipValue = "";

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";
			$this->Id_Tipo_Extraccion->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";
			$this->Id_Tipo_Paquete->TooltipValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";
			$this->Apellido_Nombre_Solicitante->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";
			$this->Email_Solicitante->TooltipValue = "";

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
				$sThisKey .= $row['NroPedido'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("paquetes_provisionlist.php"), "", $this->TableVar, TRUE);
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
		$table = 'paquetes_provision';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'paquetes_provision';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroPedido'];

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
if (!isset($paquetes_provision_delete)) $paquetes_provision_delete = new cpaquetes_provision_delete();

// Page init
$paquetes_provision_delete->Page_Init();

// Page main
$paquetes_provision_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$paquetes_provision_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpaquetes_provisiondelete = new ew_Form("fpaquetes_provisiondelete", "delete");

// Form_CustomValidate event
fpaquetes_provisiondelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpaquetes_provisiondelete.ValidateRequired = true;
<?php } else { ?>
fpaquetes_provisiondelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpaquetes_provisiondelete.Lists["x_Serie_Netbook"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisiondelete.Lists["x_Id_Hardware"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisiondelete.Lists["x_Serie_Server"] = {"LinkField":"x_Nro_Serie","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nro_Serie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"servidor_escolar"};
fpaquetes_provisiondelete.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpaquetes_provisiondelete.Lists["x_Id_Tipo_Extraccion"] = {"LinkField":"x_Id_Tipo_Extraccion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpaquetes_provisiondelete.Lists["x_Id_Estado_Paquete"] = {"LinkField":"x_Id_Estado_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_paquete"};
fpaquetes_provisiondelete.Lists["x_Id_Tipo_Paquete"] = {"LinkField":"x_Id_Tipo_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_paquete"};
fpaquetes_provisiondelete.Lists["x_Apellido_Nombre_Solicitante"] = {"LinkField":"x_Apellido_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"referente_tecnico"};

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
<?php $paquetes_provision_delete->ShowPageHeader(); ?>
<?php
$paquetes_provision_delete->ShowMessage();
?>
<form name="fpaquetes_provisiondelete" id="fpaquetes_provisiondelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($paquetes_provision_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $paquetes_provision_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="paquetes_provision">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($paquetes_provision_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $paquetes_provision->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<th><span id="elh_paquetes_provision_Serie_Netbook" class="paquetes_provision_Serie_Netbook"><?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<th><span id="elh_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<th><span id="elh_paquetes_provision_SN" class="paquetes_provision_SN"><?php echo $paquetes_provision->SN->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<th><span id="elh_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
		<th><span id="elh_paquetes_provision_Serie_Server" class="paquetes_provision_Serie_Server"><?php echo $paquetes_provision->Serie_Server->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<th><span id="elh_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<th><span id="elh_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<th><span id="elh_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<th><span id="elh_paquetes_provision_Id_Tipo_Paquete" class="paquetes_provision_Id_Tipo_Paquete"><?php echo $paquetes_provision->Id_Tipo_Paquete->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<th><span id="elh_paquetes_provision_Apellido_Nombre_Solicitante" class="paquetes_provision_Apellido_Nombre_Solicitante"><?php echo $paquetes_provision->Apellido_Nombre_Solicitante->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
		<th><span id="elh_paquetes_provision_Dni" class="paquetes_provision_Dni"><?php echo $paquetes_provision->Dni->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<th><span id="elh_paquetes_provision_Email_Solicitante" class="paquetes_provision_Email_Solicitante"><?php echo $paquetes_provision->Email_Solicitante->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<th><span id="elh_paquetes_provision_Usuario" class="paquetes_provision_Usuario"><?php echo $paquetes_provision->Usuario->FldCaption() ?></span></th>
<?php } ?>
<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<th><span id="elh_paquetes_provision_Fecha_Actualizacion" class="paquetes_provision_Fecha_Actualizacion"><?php echo $paquetes_provision->Fecha_Actualizacion->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$paquetes_provision_delete->RecCnt = 0;
$i = 0;
while (!$paquetes_provision_delete->Recordset->EOF) {
	$paquetes_provision_delete->RecCnt++;
	$paquetes_provision_delete->RowCnt++;

	// Set row properties
	$paquetes_provision->ResetAttrs();
	$paquetes_provision->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$paquetes_provision_delete->LoadRowValues($paquetes_provision_delete->Recordset);

	// Render row
	$paquetes_provision_delete->RenderRow();
?>
	<tr<?php echo $paquetes_provision->RowAttributes() ?>>
<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
		<td<?php echo $paquetes_provision->Serie_Netbook->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Serie_Netbook" class="paquetes_provision_Serie_Netbook">
<span<?php echo $paquetes_provision->Serie_Netbook->ViewAttributes() ?>>
<?php echo $paquetes_provision->Serie_Netbook->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
		<td<?php echo $paquetes_provision->Id_Hardware->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Id_Hardware" class="paquetes_provision_Id_Hardware">
<span<?php echo $paquetes_provision->Id_Hardware->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Hardware->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->SN->Visible) { // SN ?>
		<td<?php echo $paquetes_provision->SN->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_SN" class="paquetes_provision_SN">
<span<?php echo $paquetes_provision->SN->ViewAttributes() ?>>
<?php echo $paquetes_provision->SN->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
		<td<?php echo $paquetes_provision->Marca_Arranque->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Marca_Arranque" class="paquetes_provision_Marca_Arranque">
<span<?php echo $paquetes_provision->Marca_Arranque->ViewAttributes() ?>>
<?php echo $paquetes_provision->Marca_Arranque->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
		<td<?php echo $paquetes_provision->Serie_Server->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Serie_Server" class="paquetes_provision_Serie_Server">
<span<?php echo $paquetes_provision->Serie_Server->ViewAttributes() ?>>
<?php echo $paquetes_provision->Serie_Server->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
		<td<?php echo $paquetes_provision->Id_Motivo->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Id_Motivo" class="paquetes_provision_Id_Motivo">
<span<?php echo $paquetes_provision->Id_Motivo->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
		<td<?php echo $paquetes_provision->Id_Tipo_Extraccion->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Id_Tipo_Extraccion" class="paquetes_provision_Id_Tipo_Extraccion">
<span<?php echo $paquetes_provision->Id_Tipo_Extraccion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
		<td<?php echo $paquetes_provision->Id_Estado_Paquete->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Id_Estado_Paquete" class="paquetes_provision_Id_Estado_Paquete">
<span<?php echo $paquetes_provision->Id_Estado_Paquete->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
		<td<?php echo $paquetes_provision->Id_Tipo_Paquete->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Id_Tipo_Paquete" class="paquetes_provision_Id_Tipo_Paquete">
<span<?php echo $paquetes_provision->Id_Tipo_Paquete->ViewAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
		<td<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Apellido_Nombre_Solicitante" class="paquetes_provision_Apellido_Nombre_Solicitante">
<span<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->ViewAttributes() ?>>
<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
		<td<?php echo $paquetes_provision->Dni->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Dni" class="paquetes_provision_Dni">
<span<?php echo $paquetes_provision->Dni->ViewAttributes() ?>>
<?php echo $paquetes_provision->Dni->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
		<td<?php echo $paquetes_provision->Email_Solicitante->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Email_Solicitante" class="paquetes_provision_Email_Solicitante">
<span<?php echo $paquetes_provision->Email_Solicitante->ViewAttributes() ?>>
<?php echo $paquetes_provision->Email_Solicitante->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
		<td<?php echo $paquetes_provision->Usuario->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Usuario" class="paquetes_provision_Usuario">
<span<?php echo $paquetes_provision->Usuario->ViewAttributes() ?>>
<?php echo $paquetes_provision->Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td<?php echo $paquetes_provision->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $paquetes_provision_delete->RowCnt ?>_paquetes_provision_Fecha_Actualizacion" class="paquetes_provision_Fecha_Actualizacion">
<span<?php echo $paquetes_provision->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $paquetes_provision->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$paquetes_provision_delete->Recordset->MoveNext();
}
$paquetes_provision_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $paquetes_provision_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpaquetes_provisiondelete.Init();
</script>
<?php
$paquetes_provision_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$paquetes_provision_delete->Page_Terminate();
?>
