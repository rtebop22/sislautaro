<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "equiposinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "observacion_equipogridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$equipos_update = NULL; // Initialize page object first

class cequipos_update extends cequipos {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'equipos';

	// Page object name
	var $PageObjName = 'equipos_update';

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
	var $AuditTrailOnEdit = TRUE;
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'equipos', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("equiposlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Ubicacion->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Sit_Estado->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_Ano->SetVisibility();
		$this->User_Actualiz->SetVisibility();
		$this->Ultima_Actualiz->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'observacion_equipo'
			if (@$_POST["grid"] == "fobservacion_equipogrid") {
				if (!isset($GLOBALS["observacion_equipo_grid"])) $GLOBALS["observacion_equipo_grid"] = new cobservacion_equipo_grid;
				$GLOBALS["observacion_equipo_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("equiposlist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Id_Ubicacion->setDbValue($this->Recordset->fields('Id_Ubicacion'));
					$this->Id_Estado->setDbValue($this->Recordset->fields('Id_Estado'));
					$this->Id_Sit_Estado->setDbValue($this->Recordset->fields('Id_Sit_Estado'));
					$this->Id_Marca->setDbValue($this->Recordset->fields('Id_Marca'));
					$this->Id_Modelo->setDbValue($this->Recordset->fields('Id_Modelo'));
					$this->Id_Ano->setDbValue($this->Recordset->fields('Id_Ano'));
					$this->User_Actualiz->setDbValue($this->Recordset->fields('User_Actualiz'));
					$this->Ultima_Actualiz->setDbValue($this->Recordset->fields('Ultima_Actualiz'));
				} else {
					if (!ew_CompareValue($this->Id_Ubicacion->DbValue, $this->Recordset->fields('Id_Ubicacion')))
						$this->Id_Ubicacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado->DbValue, $this->Recordset->fields('Id_Estado')))
						$this->Id_Estado->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Sit_Estado->DbValue, $this->Recordset->fields('Id_Sit_Estado')))
						$this->Id_Sit_Estado->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Marca->DbValue, $this->Recordset->fields('Id_Marca')))
						$this->Id_Marca->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Modelo->DbValue, $this->Recordset->fields('Id_Modelo')))
						$this->Id_Modelo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Ano->DbValue, $this->Recordset->fields('Id_Ano')))
						$this->Id_Ano->CurrentValue = NULL;
					if (!ew_CompareValue($this->User_Actualiz->DbValue, $this->Recordset->fields('User_Actualiz')))
						$this->User_Actualiz->CurrentValue = NULL;
					if (!ew_CompareValue($this->Ultima_Actualiz->DbValue, $this->Recordset->fields('Ultima_Actualiz')))
						$this->Ultima_Actualiz->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		$this->NroSerie->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Ubicacion->FldIsDetailKey) {
			$this->Id_Ubicacion->setFormValue($objForm->GetValue("x_Id_Ubicacion"));
		}
		$this->Id_Ubicacion->MultiUpdate = $objForm->GetValue("u_Id_Ubicacion");
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
		}
		$this->Id_Estado->MultiUpdate = $objForm->GetValue("u_Id_Estado");
		if (!$this->Id_Sit_Estado->FldIsDetailKey) {
			$this->Id_Sit_Estado->setFormValue($objForm->GetValue("x_Id_Sit_Estado"));
		}
		$this->Id_Sit_Estado->MultiUpdate = $objForm->GetValue("u_Id_Sit_Estado");
		if (!$this->Id_Marca->FldIsDetailKey) {
			$this->Id_Marca->setFormValue($objForm->GetValue("x_Id_Marca"));
		}
		$this->Id_Marca->MultiUpdate = $objForm->GetValue("u_Id_Marca");
		if (!$this->Id_Modelo->FldIsDetailKey) {
			$this->Id_Modelo->setFormValue($objForm->GetValue("x_Id_Modelo"));
		}
		$this->Id_Modelo->MultiUpdate = $objForm->GetValue("u_Id_Modelo");
		if (!$this->Id_Ano->FldIsDetailKey) {
			$this->Id_Ano->setFormValue($objForm->GetValue("x_Id_Ano"));
		}
		$this->Id_Ano->MultiUpdate = $objForm->GetValue("u_Id_Ano");
		if (!$this->User_Actualiz->FldIsDetailKey) {
			$this->User_Actualiz->setFormValue($objForm->GetValue("x_User_Actualiz"));
		}
		$this->User_Actualiz->MultiUpdate = $objForm->GetValue("u_User_Actualiz");
		if (!$this->Ultima_Actualiz->FldIsDetailKey) {
			$this->Ultima_Actualiz->setFormValue($objForm->GetValue("x_Ultima_Actualiz"));
		}
		$this->Ultima_Actualiz->MultiUpdate = $objForm->GetValue("u_Ultima_Actualiz");
		if (!$this->NroSerie->FldIsDetailKey)
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Id_Ubicacion->CurrentValue = $this->Id_Ubicacion->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->Id_Sit_Estado->CurrentValue = $this->Id_Sit_Estado->FormValue;
		$this->Id_Marca->CurrentValue = $this->Id_Marca->FormValue;
		$this->Id_Modelo->CurrentValue = $this->Id_Modelo->FormValue;
		$this->Id_Ano->CurrentValue = $this->Id_Ano->FormValue;
		$this->User_Actualiz->CurrentValue = $this->User_Actualiz->FormValue;
		$this->Ultima_Actualiz->CurrentValue = $this->Ultima_Actualiz->FormValue;
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
		$this->Id_Ubicacion->setDbValue($rs->fields('Id_Ubicacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Sit_Estado->setDbValue($rs->fields('Id_Sit_Estado'));
		$this->Id_Marca->setDbValue($rs->fields('Id_Marca'));
		$this->Id_Modelo->setDbValue($rs->fields('Id_Modelo'));
		$this->Id_Ano->setDbValue($rs->fields('Id_Ano'));
		$this->User_Actualiz->setDbValue($rs->fields('User_Actualiz'));
		$this->Ultima_Actualiz->setDbValue($rs->fields('Ultima_Actualiz'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->NroMac->DbValue = $row['NroMac'];
		$this->Id_Ubicacion->DbValue = $row['Id_Ubicacion'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Id_Sit_Estado->DbValue = $row['Id_Sit_Estado'];
		$this->Id_Marca->DbValue = $row['Id_Marca'];
		$this->Id_Modelo->DbValue = $row['Id_Modelo'];
		$this->Id_Ano->DbValue = $row['Id_Ano'];
		$this->User_Actualiz->DbValue = $row['User_Actualiz'];
		$this->Ultima_Actualiz->DbValue = $row['Ultima_Actualiz'];
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
		// Id_Ubicacion
		// Id_Estado
		// Id_Sit_Estado
		// Id_Marca
		// Id_Modelo
		// Id_Ano
		// User_Actualiz
		// Ultima_Actualiz

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// NroMac
		$this->NroMac->ViewValue = $this->NroMac->CurrentValue;
		$this->NroMac->ViewCustomAttributes = "";

		// Id_Ubicacion
		if (strval($this->Id_Ubicacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
		$sWhereWrk = "";
		$this->Id_Ubicacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// User_Actualiz
		$this->User_Actualiz->ViewValue = $this->User_Actualiz->CurrentValue;
		$this->User_Actualiz->ViewValue = ew_FormatDateTime($this->User_Actualiz->ViewValue, 7);
		$this->User_Actualiz->ViewCustomAttributes = "";

		// Ultima_Actualiz
		$this->Ultima_Actualiz->ViewValue = $this->Ultima_Actualiz->CurrentValue;
		$this->Ultima_Actualiz->ViewCustomAttributes = "";

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

			// User_Actualiz
			$this->User_Actualiz->LinkCustomAttributes = "";
			$this->User_Actualiz->HrefValue = "";
			$this->User_Actualiz->TooltipValue = "";

			// Ultima_Actualiz
			$this->Ultima_Actualiz->LinkCustomAttributes = "";
			$this->Ultima_Actualiz->HrefValue = "";
			$this->Ultima_Actualiz->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Ubicacion
			$this->Id_Ubicacion->EditAttrs["class"] = "form-control";
			$this->Id_Ubicacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ubicacion->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ubicacion`" . ew_SearchString("=", $this->Id_Ubicacion->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ubicacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ubicacion->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Sit_Estado
			$this->Id_Sit_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Sit_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sit_Estado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sit_Estado`" . ew_SearchString("=", $this->Id_Sit_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sit_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sit_Estado->EditValue = $arwrk;

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Marca->EditValue = $arwrk;

			// Id_Modelo
			$this->Id_Modelo->EditAttrs["class"] = "form-control";
			$this->Id_Modelo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modelo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Marca` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_Ano
			$this->Id_Ano->EditAttrs["class"] = "form-control";
			$this->Id_Ano->EditCustomAttributes = "";
			if (trim(strval($this->Id_Ano->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Ano`" . ew_SearchString("=", $this->Id_Ano->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Ano`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Ano->EditValue = $arwrk;

			// User_Actualiz
			// Ultima_Actualiz
			// Edit refer script
			// Id_Ubicacion

			$this->Id_Ubicacion->LinkCustomAttributes = "";
			$this->Id_Ubicacion->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";

			// Id_Sit_Estado
			$this->Id_Sit_Estado->LinkCustomAttributes = "";
			$this->Id_Sit_Estado->HrefValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";

			// Id_Ano
			$this->Id_Ano->LinkCustomAttributes = "";
			$this->Id_Ano->HrefValue = "";

			// User_Actualiz
			$this->User_Actualiz->LinkCustomAttributes = "";
			$this->User_Actualiz->HrefValue = "";

			// Ultima_Actualiz
			$this->Ultima_Actualiz->LinkCustomAttributes = "";
			$this->Ultima_Actualiz->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->Id_Ubicacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Sit_Estado->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Marca->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Modelo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Ano->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->User_Actualiz->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Ultima_Actualiz->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Id_Ubicacion->MultiUpdate <> "" && !$this->Id_Ubicacion->FldIsDetailKey && !is_null($this->Id_Ubicacion->FormValue) && $this->Id_Ubicacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ubicacion->FldCaption(), $this->Id_Ubicacion->ReqErrMsg));
		}
		if ($this->Id_Estado->MultiUpdate <> "" && !$this->Id_Estado->FldIsDetailKey && !is_null($this->Id_Estado->FormValue) && $this->Id_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado->FldCaption(), $this->Id_Estado->ReqErrMsg));
		}
		if ($this->Id_Sit_Estado->MultiUpdate <> "" && !$this->Id_Sit_Estado->FldIsDetailKey && !is_null($this->Id_Sit_Estado->FormValue) && $this->Id_Sit_Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Sit_Estado->FldCaption(), $this->Id_Sit_Estado->ReqErrMsg));
		}
		if ($this->Id_Marca->MultiUpdate <> "" && !$this->Id_Marca->FldIsDetailKey && !is_null($this->Id_Marca->FormValue) && $this->Id_Marca->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Marca->FldCaption(), $this->Id_Marca->ReqErrMsg));
		}
		if ($this->Id_Modelo->MultiUpdate <> "" && !$this->Id_Modelo->FldIsDetailKey && !is_null($this->Id_Modelo->FormValue) && $this->Id_Modelo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Modelo->FldCaption(), $this->Id_Modelo->ReqErrMsg));
		}
		if ($this->Id_Ano->MultiUpdate <> "" && !$this->Id_Ano->FldIsDetailKey && !is_null($this->Id_Ano->FormValue) && $this->Id_Ano->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Ano->FldCaption(), $this->Id_Ano->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Id_Ubicacion
			$this->Id_Ubicacion->SetDbValueDef($rsnew, $this->Id_Ubicacion->CurrentValue, 0, $this->Id_Ubicacion->ReadOnly || $this->Id_Ubicacion->MultiUpdate <> "1");

			// Id_Estado
			$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, 0, $this->Id_Estado->ReadOnly || $this->Id_Estado->MultiUpdate <> "1");

			// Id_Sit_Estado
			$this->Id_Sit_Estado->SetDbValueDef($rsnew, $this->Id_Sit_Estado->CurrentValue, 0, $this->Id_Sit_Estado->ReadOnly || $this->Id_Sit_Estado->MultiUpdate <> "1");

			// Id_Marca
			$this->Id_Marca->SetDbValueDef($rsnew, $this->Id_Marca->CurrentValue, 0, $this->Id_Marca->ReadOnly || $this->Id_Marca->MultiUpdate <> "1");

			// Id_Modelo
			$this->Id_Modelo->SetDbValueDef($rsnew, $this->Id_Modelo->CurrentValue, 0, $this->Id_Modelo->ReadOnly || $this->Id_Modelo->MultiUpdate <> "1");

			// Id_Ano
			$this->Id_Ano->SetDbValueDef($rsnew, $this->Id_Ano->CurrentValue, 0, $this->Id_Ano->ReadOnly || $this->Id_Ano->MultiUpdate <> "1");

			// User_Actualiz
			$this->User_Actualiz->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['User_Actualiz'] = &$this->User_Actualiz->DbValue;

			// Ultima_Actualiz
			$this->Ultima_Actualiz->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Ultima_Actualiz'] = &$this->Ultima_Actualiz->DbValue;

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("equiposlist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Ubicacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ubicacion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ubicacion_equipo`";
			$sWhereWrk = "";
			$this->Id_Ubicacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ubicacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ubicacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Sit_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Sit_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Id_Sit_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Sit_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Sit_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Marca":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Marca` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Marca` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modelo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modelo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
			$sWhereWrk = "{filter}";
			$this->Id_Modelo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modelo` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Marca` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Ano":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ano` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ano_entrega`";
			$sWhereWrk = "";
			$this->Id_Ano->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ano` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ano, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'equipos';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NroSerie'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($equipos_update)) $equipos_update = new cequipos_update();

// Page init
$equipos_update->Page_Init();

// Page main
$equipos_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equipos_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fequiposupdate = new ew_Form("fequiposupdate", "update");

// Validate form
fequiposupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Id_Ubicacion");
			uelm = this.GetElements("u" + infix + "_Id_Ubicacion");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ubicacion->FldCaption(), $equipos->Id_Ubicacion->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Estado");
			uelm = this.GetElements("u" + infix + "_Id_Estado");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Estado->FldCaption(), $equipos->Id_Estado->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Sit_Estado");
			uelm = this.GetElements("u" + infix + "_Id_Sit_Estado");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Sit_Estado->FldCaption(), $equipos->Id_Sit_Estado->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Marca");
			uelm = this.GetElements("u" + infix + "_Id_Marca");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Marca->FldCaption(), $equipos->Id_Marca->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			uelm = this.GetElements("u" + infix + "_Id_Modelo");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Modelo->FldCaption(), $equipos->Id_Modelo->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Ano");
			uelm = this.GetElements("u" + infix + "_Id_Ano");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ano->FldCaption(), $equipos->Id_Ano->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fequiposupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fequiposupdate.ValidateRequired = true;
<?php } else { ?>
fequiposupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fequiposupdate.Lists["x_Id_Ubicacion"] = {"LinkField":"x_Id_Ubicacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ubicacion_equipo"};
fequiposupdate.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo"};
fequiposupdate.Lists["x_Id_Sit_Estado"] = {"LinkField":"x_Id_Sit_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};
fequiposupdate.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Modelo"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca"};
fequiposupdate.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":["x_Id_Marca"],"ChildFields":[],"FilterFields":["x_Id_Marca"],"Options":[],"Template":"","LinkTable":"modelo"};
fequiposupdate.Lists["x_Id_Ano"] = {"LinkField":"x_Id_Ano","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ano_entrega"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$equipos_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $equipos_update->ShowPageHeader(); ?>
<?php
$equipos_update->ShowMessage();
?>
<form name="fequiposupdate" id="fequiposupdate" class="<?php echo $equipos_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($equipos_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $equipos_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="equipos">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($equipos_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($equipos_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_equiposupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
	<div id="r_Id_Ubicacion" class="form-group">
		<label for="x_Id_Ubicacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Ubicacion" id="u_Id_Ubicacion" value="1"<?php echo ($equipos->Id_Ubicacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Ubicacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<span id="el_equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Ubicacion" name="x_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x_Id_Ubicacion" id="s_x_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Ubicacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label for="x_Id_Estado" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado" id="u_Id_Estado" value="1"<?php echo ($equipos->Id_Estado->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Estado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
	<div id="r_Id_Sit_Estado" class="form-group">
		<label for="x_Id_Sit_Estado" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Sit_Estado" id="u_Id_Sit_Estado" value="1"<?php echo ($equipos->Id_Sit_Estado->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Sit_Estado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<span id="el_equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Sit_Estado" name="x_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Sit_Estado" id="s_x_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Sit_Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
	<div id="r_Id_Marca" class="form-group">
		<label for="x_Id_Marca" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Marca" id="u_Id_Marca" value="1"<?php echo ($equipos->Id_Marca->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Marca->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<span id="el_equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x_Id_Marca" name="x_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x_Id_Marca") ?>
</select>
<input type="hidden" name="s_x_Id_Marca" id="s_x_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Marca->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
	<div id="r_Id_Modelo" class="form-group">
		<label for="x_Id_Modelo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Modelo" id="u_Id_Modelo" value="1"<?php echo ($equipos->Id_Modelo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Modelo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<span id="el_equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modelo" name="x_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x_Id_Modelo" id="s_x_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Modelo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
	<div id="r_Id_Ano" class="form-group">
		<label for="x_Id_Ano" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Ano" id="u_Id_Ano" value="1"<?php echo ($equipos->Id_Ano->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Id_Ano->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<span id="el_equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x_Id_Ano" name="x_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x_Id_Ano") ?>
</select>
<input type="hidden" name="s_x_Id_Ano" id="s_x_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<?php echo $equipos->Id_Ano->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->User_Actualiz->Visible) { // User_Actualiz ?>
	<div id="r_User_Actualiz" class="form-group">
		<label for="x_User_Actualiz" class="col-sm-2 control-label">
<input type="checkbox" name="u_User_Actualiz" id="u_User_Actualiz" value="1"<?php echo ($equipos->User_Actualiz->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->User_Actualiz->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->User_Actualiz->CellAttributes() ?>>
<?php echo $equipos->User_Actualiz->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equipos->Ultima_Actualiz->Visible) { // Ultima_Actualiz ?>
	<div id="r_Ultima_Actualiz" class="form-group">
		<label for="x_Ultima_Actualiz" class="col-sm-2 control-label">
<input type="checkbox" name="u_Ultima_Actualiz" id="u_Ultima_Actualiz" value="1"<?php echo ($equipos->Ultima_Actualiz->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $equipos->Ultima_Actualiz->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $equipos->Ultima_Actualiz->CellAttributes() ?>>
<?php echo $equipos->Ultima_Actualiz->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$equipos_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $equipos_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fequiposupdate.Init();
</script>
<?php
$equipos_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$equipos_update->Page_Terminate();
?>
