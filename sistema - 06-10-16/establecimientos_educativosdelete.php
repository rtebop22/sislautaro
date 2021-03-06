<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "establecimientos_educativosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$establecimientos_educativos_delete = NULL; // Initialize page object first

class cestablecimientos_educativos_delete extends cestablecimientos_educativos {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'establecimientos_educativos';

	// Page object name
	var $PageObjName = 'establecimientos_educativos_delete';

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

		// Table object (establecimientos_educativos)
		if (!isset($GLOBALS["establecimientos_educativos"]) || get_class($GLOBALS["establecimientos_educativos"]) == "cestablecimientos_educativos") {
			$GLOBALS["establecimientos_educativos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["establecimientos_educativos"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'establecimientos_educativos', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("establecimientos_educativoslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Cue_Establecimiento->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Nombre_Director->SetVisibility();
		$this->Cuil_Director->SetVisibility();
		$this->Nombre_Rte->SetVisibility();
		$this->Contacto_Rte->SetVisibility();
		$this->Nro_Serie_Server_Escolar->SetVisibility();
		$this->Contacto_Establecimiento->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Localidad->SetVisibility();
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
		global $EW_EXPORT, $establecimientos_educativos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($establecimientos_educativos);
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
			$this->Page_Terminate("establecimientos_educativoslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in establecimientos_educativos class, establecimientos_educativosinfo.php

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
				$this->Page_Terminate("establecimientos_educativoslist.php"); // Return to list
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
		$this->Cue_Establecimiento->setDbValue($rs->fields('Cue_Establecimiento'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Nombre_Director->setDbValue($rs->fields('Nombre_Director'));
		$this->Cuil_Director->setDbValue($rs->fields('Cuil_Director'));
		$this->Nombre_Rte->setDbValue($rs->fields('Nombre_Rte'));
		$this->Contacto_Rte->setDbValue($rs->fields('Contacto_Rte'));
		$this->Nro_Serie_Server_Escolar->setDbValue($rs->fields('Nro_Serie_Server_Escolar'));
		$this->Contacto_Establecimiento->setDbValue($rs->fields('Contacto_Establecimiento'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue_Establecimiento->DbValue = $row['Cue_Establecimiento'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Nombre_Director->DbValue = $row['Nombre_Director'];
		$this->Cuil_Director->DbValue = $row['Cuil_Director'];
		$this->Nombre_Rte->DbValue = $row['Nombre_Rte'];
		$this->Contacto_Rte->DbValue = $row['Contacto_Rte'];
		$this->Nro_Serie_Server_Escolar->DbValue = $row['Nro_Serie_Server_Escolar'];
		$this->Contacto_Establecimiento->DbValue = $row['Contacto_Establecimiento'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
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
		// Cue_Establecimiento
		// Nombre_Establecimiento
		// Nombre_Director
		// Cuil_Director
		// Nombre_Rte
		// Contacto_Rte
		// Nro_Serie_Server_Escolar
		// Contacto_Establecimiento
		// Id_Provincia
		// Id_Localidad
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue_Establecimiento
		$this->Cue_Establecimiento->ViewValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Cue_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Director
		$this->Nombre_Director->ViewValue = $this->Nombre_Director->CurrentValue;
		$this->Nombre_Director->ViewCustomAttributes = "";

		// Cuil_Director
		$this->Cuil_Director->ViewValue = $this->Cuil_Director->CurrentValue;
		$this->Cuil_Director->ViewCustomAttributes = "";

		// Nombre_Rte
		$this->Nombre_Rte->ViewValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->ViewCustomAttributes = "";

		// Contacto_Rte
		$this->Contacto_Rte->ViewValue = $this->Contacto_Rte->CurrentValue;
		$this->Contacto_Rte->ViewCustomAttributes = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->ViewValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->ViewCustomAttributes = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->ViewValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->CurrentValue;
			}
		} else {
			$this->Id_Provincia->ViewValue = NULL;
		}
		$this->Id_Provincia->ViewCustomAttributes = "";

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

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue_Establecimiento
			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";
			$this->Cue_Establecimiento->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

			// Nombre_Director
			$this->Nombre_Director->LinkCustomAttributes = "";
			$this->Nombre_Director->HrefValue = "";
			$this->Nombre_Director->TooltipValue = "";

			// Cuil_Director
			$this->Cuil_Director->LinkCustomAttributes = "";
			$this->Cuil_Director->HrefValue = "";
			$this->Cuil_Director->TooltipValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";
			$this->Nombre_Rte->TooltipValue = "";

			// Contacto_Rte
			$this->Contacto_Rte->LinkCustomAttributes = "";
			$this->Contacto_Rte->HrefValue = "";
			$this->Contacto_Rte->TooltipValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";
			$this->Nro_Serie_Server_Escolar->TooltipValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";
			$this->Contacto_Establecimiento->TooltipValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";
			$this->Id_Provincia->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

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
				$sThisKey .= $row['Cue_Establecimiento'];
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
		} else {
			$conn->RollbackTrans(); // Rollback changes
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("establecimientos_educativoslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($establecimientos_educativos_delete)) $establecimientos_educativos_delete = new cestablecimientos_educativos_delete();

// Page init
$establecimientos_educativos_delete->Page_Init();

// Page main
$establecimientos_educativos_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$establecimientos_educativos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = festablecimientos_educativosdelete = new ew_Form("festablecimientos_educativosdelete", "delete");

// Form_CustomValidate event
festablecimientos_educativosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festablecimientos_educativosdelete.ValidateRequired = true;
<?php } else { ?>
festablecimientos_educativosdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festablecimientos_educativosdelete.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
festablecimientos_educativosdelete.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};

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
<?php $establecimientos_educativos_delete->ShowPageHeader(); ?>
<?php
$establecimientos_educativos_delete->ShowMessage();
?>
<form name="festablecimientos_educativosdelete" id="festablecimientos_educativosdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($establecimientos_educativos_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $establecimientos_educativos_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="establecimientos_educativos">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($establecimientos_educativos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $establecimientos_educativos->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($establecimientos_educativos->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
		<th><span id="elh_establecimientos_educativos_Cue_Establecimiento" class="establecimientos_educativos_Cue_Establecimiento"><?php echo $establecimientos_educativos->Cue_Establecimiento->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<th><span id="elh_establecimientos_educativos_Nombre_Establecimiento" class="establecimientos_educativos_Nombre_Establecimiento"><?php echo $establecimientos_educativos->Nombre_Establecimiento->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Director->Visible) { // Nombre_Director ?>
		<th><span id="elh_establecimientos_educativos_Nombre_Director" class="establecimientos_educativos_Nombre_Director"><?php echo $establecimientos_educativos->Nombre_Director->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Cuil_Director->Visible) { // Cuil_Director ?>
		<th><span id="elh_establecimientos_educativos_Cuil_Director" class="establecimientos_educativos_Cuil_Director"><?php echo $establecimientos_educativos->Cuil_Director->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Rte->Visible) { // Nombre_Rte ?>
		<th><span id="elh_establecimientos_educativos_Nombre_Rte" class="establecimientos_educativos_Nombre_Rte"><?php echo $establecimientos_educativos->Nombre_Rte->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Contacto_Rte->Visible) { // Contacto_Rte ?>
		<th><span id="elh_establecimientos_educativos_Contacto_Rte" class="establecimientos_educativos_Contacto_Rte"><?php echo $establecimientos_educativos->Contacto_Rte->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
		<th><span id="elh_establecimientos_educativos_Nro_Serie_Server_Escolar" class="establecimientos_educativos_Nro_Serie_Server_Escolar"><?php echo $establecimientos_educativos->Nro_Serie_Server_Escolar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
		<th><span id="elh_establecimientos_educativos_Contacto_Establecimiento" class="establecimientos_educativos_Contacto_Establecimiento"><?php echo $establecimientos_educativos->Contacto_Establecimiento->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Id_Provincia->Visible) { // Id_Provincia ?>
		<th><span id="elh_establecimientos_educativos_Id_Provincia" class="establecimientos_educativos_Id_Provincia"><?php echo $establecimientos_educativos->Id_Provincia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Id_Localidad->Visible) { // Id_Localidad ?>
		<th><span id="elh_establecimientos_educativos_Id_Localidad" class="establecimientos_educativos_Id_Localidad"><?php echo $establecimientos_educativos->Id_Localidad->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<th><span id="elh_establecimientos_educativos_Fecha_Actualizacion" class="establecimientos_educativos_Fecha_Actualizacion"><?php echo $establecimientos_educativos->Fecha_Actualizacion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($establecimientos_educativos->Usuario->Visible) { // Usuario ?>
		<th><span id="elh_establecimientos_educativos_Usuario" class="establecimientos_educativos_Usuario"><?php echo $establecimientos_educativos->Usuario->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$establecimientos_educativos_delete->RecCnt = 0;
$i = 0;
while (!$establecimientos_educativos_delete->Recordset->EOF) {
	$establecimientos_educativos_delete->RecCnt++;
	$establecimientos_educativos_delete->RowCnt++;

	// Set row properties
	$establecimientos_educativos->ResetAttrs();
	$establecimientos_educativos->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$establecimientos_educativos_delete->LoadRowValues($establecimientos_educativos_delete->Recordset);

	// Render row
	$establecimientos_educativos_delete->RenderRow();
?>
	<tr<?php echo $establecimientos_educativos->RowAttributes() ?>>
<?php if ($establecimientos_educativos->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
		<td<?php echo $establecimientos_educativos->Cue_Establecimiento->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Cue_Establecimiento" class="establecimientos_educativos_Cue_Establecimiento">
<span<?php echo $establecimientos_educativos->Cue_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Cue_Establecimiento->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
		<td<?php echo $establecimientos_educativos->Nombre_Establecimiento->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Nombre_Establecimiento" class="establecimientos_educativos_Nombre_Establecimiento">
<span<?php echo $establecimientos_educativos->Nombre_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Nombre_Establecimiento->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Director->Visible) { // Nombre_Director ?>
		<td<?php echo $establecimientos_educativos->Nombre_Director->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Nombre_Director" class="establecimientos_educativos_Nombre_Director">
<span<?php echo $establecimientos_educativos->Nombre_Director->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Nombre_Director->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Cuil_Director->Visible) { // Cuil_Director ?>
		<td<?php echo $establecimientos_educativos->Cuil_Director->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Cuil_Director" class="establecimientos_educativos_Cuil_Director">
<span<?php echo $establecimientos_educativos->Cuil_Director->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Cuil_Director->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Nombre_Rte->Visible) { // Nombre_Rte ?>
		<td<?php echo $establecimientos_educativos->Nombre_Rte->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Nombre_Rte" class="establecimientos_educativos_Nombre_Rte">
<span<?php echo $establecimientos_educativos->Nombre_Rte->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Nombre_Rte->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Contacto_Rte->Visible) { // Contacto_Rte ?>
		<td<?php echo $establecimientos_educativos->Contacto_Rte->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Contacto_Rte" class="establecimientos_educativos_Contacto_Rte">
<span<?php echo $establecimientos_educativos->Contacto_Rte->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Contacto_Rte->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
		<td<?php echo $establecimientos_educativos->Nro_Serie_Server_Escolar->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Nro_Serie_Server_Escolar" class="establecimientos_educativos_Nro_Serie_Server_Escolar">
<span<?php echo $establecimientos_educativos->Nro_Serie_Server_Escolar->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Nro_Serie_Server_Escolar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
		<td<?php echo $establecimientos_educativos->Contacto_Establecimiento->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Contacto_Establecimiento" class="establecimientos_educativos_Contacto_Establecimiento">
<span<?php echo $establecimientos_educativos->Contacto_Establecimiento->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Contacto_Establecimiento->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Id_Provincia->Visible) { // Id_Provincia ?>
		<td<?php echo $establecimientos_educativos->Id_Provincia->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Id_Provincia" class="establecimientos_educativos_Id_Provincia">
<span<?php echo $establecimientos_educativos->Id_Provincia->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Id_Provincia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Id_Localidad->Visible) { // Id_Localidad ?>
		<td<?php echo $establecimientos_educativos->Id_Localidad->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Id_Localidad" class="establecimientos_educativos_Id_Localidad">
<span<?php echo $establecimientos_educativos->Id_Localidad->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Id_Localidad->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td<?php echo $establecimientos_educativos->Fecha_Actualizacion->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Fecha_Actualizacion" class="establecimientos_educativos_Fecha_Actualizacion">
<span<?php echo $establecimientos_educativos->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($establecimientos_educativos->Usuario->Visible) { // Usuario ?>
		<td<?php echo $establecimientos_educativos->Usuario->CellAttributes() ?>>
<span id="el<?php echo $establecimientos_educativos_delete->RowCnt ?>_establecimientos_educativos_Usuario" class="establecimientos_educativos_Usuario">
<span<?php echo $establecimientos_educativos->Usuario->ViewAttributes() ?>>
<?php echo $establecimientos_educativos->Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$establecimientos_educativos_delete->Recordset->MoveNext();
}
$establecimientos_educativos_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $establecimientos_educativos_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
festablecimientos_educativosdelete.Init();
</script>
<?php
$establecimientos_educativos_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$establecimientos_educativos_delete->Page_Terminate();
?>
