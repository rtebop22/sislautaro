<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "datos_extras_escuelainfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$datos_extras_escuela_update = NULL; // Initialize page object first

class cdatos_extras_escuela_update extends cdatos_extras_escuela {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'datos_extras_escuela';

	// Page object name
	var $PageObjName = 'datos_extras_escuela_update';

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (datos_extras_escuela)
		if (!isset($GLOBALS["datos_extras_escuela"]) || get_class($GLOBALS["datos_extras_escuela"]) == "cdatos_extras_escuela") {
			$GLOBALS["datos_extras_escuela"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["datos_extras_escuela"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'datos_extras_escuela', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("datos_extras_escuelalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Cue->SetVisibility();
		$this->Usuario_Conig->SetVisibility();
		$this->Password_Conig->SetVisibility();
		$this->Tiene_Internet->SetVisibility();
		$this->Servicio_Internet->SetVisibility();
		$this->Estado_Internet->SetVisibility();
		$this->Quien_Paga->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
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
		global $EW_EXPORT, $datos_extras_escuela;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($datos_extras_escuela);
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
			$this->Page_Terminate("datos_extras_escuelalist.php"); // No records selected, return to list
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
					$this->Cue->setDbValue($this->Recordset->fields('Cue'));
					$this->Usuario_Conig->setDbValue($this->Recordset->fields('Usuario_Conig'));
					$this->Password_Conig->setDbValue($this->Recordset->fields('Password_Conig'));
					$this->Tiene_Internet->setDbValue($this->Recordset->fields('Tiene_Internet'));
					$this->Servicio_Internet->setDbValue($this->Recordset->fields('Servicio_Internet'));
					$this->Estado_Internet->setDbValue($this->Recordset->fields('Estado_Internet'));
					$this->Quien_Paga->setDbValue($this->Recordset->fields('Quien_Paga'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
				} else {
					if (!ew_CompareValue($this->Cue->DbValue, $this->Recordset->fields('Cue')))
						$this->Cue->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario_Conig->DbValue, $this->Recordset->fields('Usuario_Conig')))
						$this->Usuario_Conig->CurrentValue = NULL;
					if (!ew_CompareValue($this->Password_Conig->DbValue, $this->Recordset->fields('Password_Conig')))
						$this->Password_Conig->CurrentValue = NULL;
					if (!ew_CompareValue($this->Tiene_Internet->DbValue, $this->Recordset->fields('Tiene_Internet')))
						$this->Tiene_Internet->CurrentValue = NULL;
					if (!ew_CompareValue($this->Servicio_Internet->DbValue, $this->Recordset->fields('Servicio_Internet')))
						$this->Servicio_Internet->CurrentValue = NULL;
					if (!ew_CompareValue($this->Estado_Internet->DbValue, $this->Recordset->fields('Estado_Internet')))
						$this->Estado_Internet->CurrentValue = NULL;
					if (!ew_CompareValue($this->Quien_Paga->DbValue, $this->Recordset->fields('Quien_Paga')))
						$this->Quien_Paga->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Actualizacion->DbValue, $this->Recordset->fields('Fecha_Actualizacion')))
						$this->Fecha_Actualizacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario->DbValue, $this->Recordset->fields('Usuario')))
						$this->Usuario->CurrentValue = NULL;
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
		$this->Cue->CurrentValue = $sKeyFld;
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
		if (!$this->Cue->FldIsDetailKey) {
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
		}
		$this->Cue->MultiUpdate = $objForm->GetValue("u_Cue");
		if (!$this->Usuario_Conig->FldIsDetailKey) {
			$this->Usuario_Conig->setFormValue($objForm->GetValue("x_Usuario_Conig"));
		}
		$this->Usuario_Conig->MultiUpdate = $objForm->GetValue("u_Usuario_Conig");
		if (!$this->Password_Conig->FldIsDetailKey) {
			$this->Password_Conig->setFormValue($objForm->GetValue("x_Password_Conig"));
		}
		$this->Password_Conig->MultiUpdate = $objForm->GetValue("u_Password_Conig");
		if (!$this->Tiene_Internet->FldIsDetailKey) {
			$this->Tiene_Internet->setFormValue($objForm->GetValue("x_Tiene_Internet"));
		}
		$this->Tiene_Internet->MultiUpdate = $objForm->GetValue("u_Tiene_Internet");
		if (!$this->Servicio_Internet->FldIsDetailKey) {
			$this->Servicio_Internet->setFormValue($objForm->GetValue("x_Servicio_Internet"));
		}
		$this->Servicio_Internet->MultiUpdate = $objForm->GetValue("u_Servicio_Internet");
		if (!$this->Estado_Internet->FldIsDetailKey) {
			$this->Estado_Internet->setFormValue($objForm->GetValue("x_Estado_Internet"));
		}
		$this->Estado_Internet->MultiUpdate = $objForm->GetValue("u_Estado_Internet");
		if (!$this->Quien_Paga->FldIsDetailKey) {
			$this->Quien_Paga->setFormValue($objForm->GetValue("x_Quien_Paga"));
		}
		$this->Quien_Paga->MultiUpdate = $objForm->GetValue("u_Quien_Paga");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Usuario_Conig->CurrentValue = $this->Usuario_Conig->FormValue;
		$this->Password_Conig->CurrentValue = $this->Password_Conig->FormValue;
		$this->Tiene_Internet->CurrentValue = $this->Tiene_Internet->FormValue;
		$this->Servicio_Internet->CurrentValue = $this->Servicio_Internet->FormValue;
		$this->Estado_Internet->CurrentValue = $this->Estado_Internet->FormValue;
		$this->Quien_Paga->CurrentValue = $this->Quien_Paga->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
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
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Usuario_Conig->setDbValue($rs->fields('Usuario_Conig'));
		$this->Password_Conig->setDbValue($rs->fields('Password_Conig'));
		$this->Tiene_Internet->setDbValue($rs->fields('Tiene_Internet'));
		$this->Servicio_Internet->setDbValue($rs->fields('Servicio_Internet'));
		$this->Estado_Internet->setDbValue($rs->fields('Estado_Internet'));
		$this->Quien_Paga->setDbValue($rs->fields('Quien_Paga'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Usuario_Conig->DbValue = $row['Usuario_Conig'];
		$this->Password_Conig->DbValue = $row['Password_Conig'];
		$this->Tiene_Internet->DbValue = $row['Tiene_Internet'];
		$this->Servicio_Internet->DbValue = $row['Servicio_Internet'];
		$this->Estado_Internet->DbValue = $row['Estado_Internet'];
		$this->Quien_Paga->DbValue = $row['Quien_Paga'];
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
		// Cue
		// Usuario_Conig
		// Password_Conig
		// Tiene_Internet
		// Servicio_Internet
		// Estado_Internet
		// Quien_Paga
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Usuario_Conig
		$this->Usuario_Conig->ViewValue = $this->Usuario_Conig->CurrentValue;
		$this->Usuario_Conig->ViewCustomAttributes = "";

		// Password_Conig
		$this->Password_Conig->ViewValue = $this->Password_Conig->CurrentValue;
		$this->Password_Conig->ViewCustomAttributes = "";

		// Tiene_Internet
		if (strval($this->Tiene_Internet->CurrentValue) <> "") {
			$this->Tiene_Internet->ViewValue = $this->Tiene_Internet->OptionCaption($this->Tiene_Internet->CurrentValue);
		} else {
			$this->Tiene_Internet->ViewValue = NULL;
		}
		$this->Tiene_Internet->ViewCustomAttributes = "";

		// Servicio_Internet
		$this->Servicio_Internet->ViewValue = $this->Servicio_Internet->CurrentValue;
		$this->Servicio_Internet->ViewCustomAttributes = "";

		// Estado_Internet
		if (strval($this->Estado_Internet->CurrentValue) <> "") {
			$this->Estado_Internet->ViewValue = $this->Estado_Internet->OptionCaption($this->Estado_Internet->CurrentValue);
		} else {
			$this->Estado_Internet->ViewValue = NULL;
		}
		$this->Estado_Internet->ViewCustomAttributes = "";

		// Quien_Paga
		$this->Quien_Paga->ViewValue = $this->Quien_Paga->CurrentValue;
		$this->Quien_Paga->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Usuario_Conig
			$this->Usuario_Conig->LinkCustomAttributes = "";
			$this->Usuario_Conig->HrefValue = "";
			$this->Usuario_Conig->TooltipValue = "";

			// Password_Conig
			$this->Password_Conig->LinkCustomAttributes = "";
			$this->Password_Conig->HrefValue = "";
			$this->Password_Conig->TooltipValue = "";

			// Tiene_Internet
			$this->Tiene_Internet->LinkCustomAttributes = "";
			$this->Tiene_Internet->HrefValue = "";
			$this->Tiene_Internet->TooltipValue = "";

			// Servicio_Internet
			$this->Servicio_Internet->LinkCustomAttributes = "";
			$this->Servicio_Internet->HrefValue = "";
			$this->Servicio_Internet->TooltipValue = "";

			// Estado_Internet
			$this->Estado_Internet->LinkCustomAttributes = "";
			$this->Estado_Internet->HrefValue = "";
			$this->Estado_Internet->TooltipValue = "";

			// Quien_Paga
			$this->Quien_Paga->LinkCustomAttributes = "";
			$this->Quien_Paga->HrefValue = "";
			$this->Quien_Paga->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			if ($this->Cue->getSessionValue() <> "") {
				$this->Cue->CurrentValue = $this->Cue->getSessionValue();
			$this->Cue->ViewValue = $this->Cue->CurrentValue;
			$this->Cue->ViewCustomAttributes = "";
			} else {
			}

			// Usuario_Conig
			$this->Usuario_Conig->EditAttrs["class"] = "form-control";
			$this->Usuario_Conig->EditCustomAttributes = "";
			$this->Usuario_Conig->EditValue = ew_HtmlEncode($this->Usuario_Conig->CurrentValue);
			$this->Usuario_Conig->PlaceHolder = ew_RemoveHtml($this->Usuario_Conig->FldCaption());

			// Password_Conig
			$this->Password_Conig->EditAttrs["class"] = "form-control";
			$this->Password_Conig->EditCustomAttributes = "";
			$this->Password_Conig->EditValue = ew_HtmlEncode($this->Password_Conig->CurrentValue);
			$this->Password_Conig->PlaceHolder = ew_RemoveHtml($this->Password_Conig->FldCaption());

			// Tiene_Internet
			$this->Tiene_Internet->EditCustomAttributes = "";
			$this->Tiene_Internet->EditValue = $this->Tiene_Internet->Options(FALSE);

			// Servicio_Internet
			$this->Servicio_Internet->EditAttrs["class"] = "form-control";
			$this->Servicio_Internet->EditCustomAttributes = "";
			$this->Servicio_Internet->EditValue = ew_HtmlEncode($this->Servicio_Internet->CurrentValue);
			$this->Servicio_Internet->PlaceHolder = ew_RemoveHtml($this->Servicio_Internet->FldCaption());

			// Estado_Internet
			$this->Estado_Internet->EditAttrs["class"] = "form-control";
			$this->Estado_Internet->EditCustomAttributes = "";
			$this->Estado_Internet->EditValue = $this->Estado_Internet->Options(TRUE);

			// Quien_Paga
			$this->Quien_Paga->EditAttrs["class"] = "form-control";
			$this->Quien_Paga->EditCustomAttributes = "";
			$this->Quien_Paga->EditValue = ew_HtmlEncode($this->Quien_Paga->CurrentValue);
			$this->Quien_Paga->PlaceHolder = ew_RemoveHtml($this->Quien_Paga->FldCaption());

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Cue

			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";

			// Usuario_Conig
			$this->Usuario_Conig->LinkCustomAttributes = "";
			$this->Usuario_Conig->HrefValue = "";

			// Password_Conig
			$this->Password_Conig->LinkCustomAttributes = "";
			$this->Password_Conig->HrefValue = "";

			// Tiene_Internet
			$this->Tiene_Internet->LinkCustomAttributes = "";
			$this->Tiene_Internet->HrefValue = "";

			// Servicio_Internet
			$this->Servicio_Internet->LinkCustomAttributes = "";
			$this->Servicio_Internet->HrefValue = "";

			// Estado_Internet
			$this->Estado_Internet->LinkCustomAttributes = "";
			$this->Estado_Internet->HrefValue = "";

			// Quien_Paga
			$this->Quien_Paga->LinkCustomAttributes = "";
			$this->Quien_Paga->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
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
		if ($this->Cue->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario_Conig->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Password_Conig->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Tiene_Internet->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Servicio_Internet->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Estado_Internet->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Quien_Paga->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Usuario_Conig->MultiUpdate <> "" && !$this->Usuario_Conig->FldIsDetailKey && !is_null($this->Usuario_Conig->FormValue) && $this->Usuario_Conig->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Usuario_Conig->FldCaption(), $this->Usuario_Conig->ReqErrMsg));
		}
		if ($this->Password_Conig->MultiUpdate <> "" && !$this->Password_Conig->FldIsDetailKey && !is_null($this->Password_Conig->FormValue) && $this->Password_Conig->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Password_Conig->FldCaption(), $this->Password_Conig->ReqErrMsg));
		}
		if ($this->Tiene_Internet->MultiUpdate <> "" && $this->Tiene_Internet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tiene_Internet->FldCaption(), $this->Tiene_Internet->ReqErrMsg));
		}
		if ($this->Estado_Internet->MultiUpdate <> "" && !$this->Estado_Internet->FldIsDetailKey && !is_null($this->Estado_Internet->FormValue) && $this->Estado_Internet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Internet->FldCaption(), $this->Estado_Internet->ReqErrMsg));
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

			// Cue
			// Usuario_Conig

			$this->Usuario_Conig->SetDbValueDef($rsnew, $this->Usuario_Conig->CurrentValue, NULL, $this->Usuario_Conig->ReadOnly || $this->Usuario_Conig->MultiUpdate <> "1");

			// Password_Conig
			$this->Password_Conig->SetDbValueDef($rsnew, $this->Password_Conig->CurrentValue, NULL, $this->Password_Conig->ReadOnly || $this->Password_Conig->MultiUpdate <> "1");

			// Tiene_Internet
			$this->Tiene_Internet->SetDbValueDef($rsnew, $this->Tiene_Internet->CurrentValue, NULL, $this->Tiene_Internet->ReadOnly || $this->Tiene_Internet->MultiUpdate <> "1");

			// Servicio_Internet
			$this->Servicio_Internet->SetDbValueDef($rsnew, $this->Servicio_Internet->CurrentValue, NULL, $this->Servicio_Internet->ReadOnly || $this->Servicio_Internet->MultiUpdate <> "1");

			// Estado_Internet
			$this->Estado_Internet->SetDbValueDef($rsnew, $this->Estado_Internet->CurrentValue, NULL, $this->Estado_Internet->ReadOnly || $this->Estado_Internet->MultiUpdate <> "1");

			// Quien_Paga
			$this->Quien_Paga->SetDbValueDef($rsnew, $this->Quien_Paga->CurrentValue, NULL, $this->Quien_Paga->ReadOnly || $this->Quien_Paga->MultiUpdate <> "1");

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datos_extras_escuelalist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
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
		$table = 'datos_extras_escuela';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'datos_extras_escuela';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
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
if (!isset($datos_extras_escuela_update)) $datos_extras_escuela_update = new cdatos_extras_escuela_update();

// Page init
$datos_extras_escuela_update->Page_Init();

// Page main
$datos_extras_escuela_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datos_extras_escuela_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fdatos_extras_escuelaupdate = new ew_Form("fdatos_extras_escuelaupdate", "update");

// Validate form
fdatos_extras_escuelaupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Usuario_Conig");
			uelm = this.GetElements("u" + infix + "_Usuario_Conig");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Usuario_Conig->FldCaption(), $datos_extras_escuela->Usuario_Conig->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Password_Conig");
			uelm = this.GetElements("u" + infix + "_Password_Conig");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Password_Conig->FldCaption(), $datos_extras_escuela->Password_Conig->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Tiene_Internet");
			uelm = this.GetElements("u" + infix + "_Tiene_Internet");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Tiene_Internet->FldCaption(), $datos_extras_escuela->Tiene_Internet->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Estado_Internet");
			uelm = this.GetElements("u" + infix + "_Estado_Internet");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Estado_Internet->FldCaption(), $datos_extras_escuela->Estado_Internet->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdatos_extras_escuelaupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdatos_extras_escuelaupdate.ValidateRequired = true;
<?php } else { ?>
fdatos_extras_escuelaupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdatos_extras_escuelaupdate.Lists["x_Tiene_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelaupdate.Lists["x_Tiene_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Tiene_Internet->Options()) ?>;
fdatos_extras_escuelaupdate.Lists["x_Estado_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelaupdate.Lists["x_Estado_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Estado_Internet->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$datos_extras_escuela_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $datos_extras_escuela_update->ShowPageHeader(); ?>
<?php
$datos_extras_escuela_update->ShowMessage();
?>
<form name="fdatos_extras_escuelaupdate" id="fdatos_extras_escuelaupdate" class="<?php echo $datos_extras_escuela_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datos_extras_escuela_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datos_extras_escuela_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datos_extras_escuela">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($datos_extras_escuela_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($datos_extras_escuela_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_datos_extras_escuelaupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($datos_extras_escuela->Usuario_Conig->Visible) { // Usuario_Conig ?>
	<div id="r_Usuario_Conig" class="form-group">
		<label for="x_Usuario_Conig" class="col-sm-2 control-label">
<input type="checkbox" name="u_Usuario_Conig" id="u_Usuario_Conig" value="1"<?php echo ($datos_extras_escuela->Usuario_Conig->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Usuario_Conig->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Usuario_Conig->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Usuario_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x_Usuario_Conig" id="x_Usuario_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Usuario_Conig->EditAttributes() ?>>
</span>
<?php echo $datos_extras_escuela->Usuario_Conig->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Password_Conig->Visible) { // Password_Conig ?>
	<div id="r_Password_Conig" class="form-group">
		<label for="x_Password_Conig" class="col-sm-2 control-label">
<input type="checkbox" name="u_Password_Conig" id="u_Password_Conig" value="1"<?php echo ($datos_extras_escuela->Password_Conig->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Password_Conig->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Password_Conig->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Password_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x_Password_Conig" id="x_Password_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Password_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Password_Conig->EditAttributes() ?>>
</span>
<?php echo $datos_extras_escuela->Password_Conig->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Tiene_Internet->Visible) { // Tiene_Internet ?>
	<div id="r_Tiene_Internet" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Tiene_Internet" id="u_Tiene_Internet" value="1"<?php echo ($datos_extras_escuela->Tiene_Internet->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Tiene_Internet->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Tiene_Internet->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Tiene_Internet">
<div id="tp_x_Tiene_Internet" class="ewTemplate"><input type="radio" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" data-value-separator="<?php echo $datos_extras_escuela->Tiene_Internet->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_Internet" id="x_Tiene_Internet" value="{value}"<?php echo $datos_extras_escuela->Tiene_Internet->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_Internet" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $datos_extras_escuela->Tiene_Internet->RadioButtonListHtml(FALSE, "x_Tiene_Internet") ?>
</div></div>
</span>
<?php echo $datos_extras_escuela->Tiene_Internet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Servicio_Internet->Visible) { // Servicio_Internet ?>
	<div id="r_Servicio_Internet" class="form-group">
		<label for="x_Servicio_Internet" class="col-sm-2 control-label">
<input type="checkbox" name="u_Servicio_Internet" id="u_Servicio_Internet" value="1"<?php echo ($datos_extras_escuela->Servicio_Internet->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Servicio_Internet->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Servicio_Internet->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Servicio_Internet">
<input type="text" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x_Servicio_Internet" id="x_Servicio_Internet" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Servicio_Internet->EditValue ?>"<?php echo $datos_extras_escuela->Servicio_Internet->EditAttributes() ?>>
</span>
<?php echo $datos_extras_escuela->Servicio_Internet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Estado_Internet->Visible) { // Estado_Internet ?>
	<div id="r_Estado_Internet" class="form-group">
		<label for="x_Estado_Internet" class="col-sm-2 control-label">
<input type="checkbox" name="u_Estado_Internet" id="u_Estado_Internet" value="1"<?php echo ($datos_extras_escuela->Estado_Internet->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Estado_Internet->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Estado_Internet->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Estado_Internet">
<select data-table="datos_extras_escuela" data-field="x_Estado_Internet" data-value-separator="<?php echo $datos_extras_escuela->Estado_Internet->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Internet" name="x_Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->EditAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->SelectOptionListHtml("x_Estado_Internet") ?>
</select>
</span>
<?php echo $datos_extras_escuela->Estado_Internet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Quien_Paga->Visible) { // Quien_Paga ?>
	<div id="r_Quien_Paga" class="form-group">
		<label for="x_Quien_Paga" class="col-sm-2 control-label">
<input type="checkbox" name="u_Quien_Paga" id="u_Quien_Paga" value="1"<?php echo ($datos_extras_escuela->Quien_Paga->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Quien_Paga->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Quien_Paga->CellAttributes() ?>>
<span id="el_datos_extras_escuela_Quien_Paga">
<input type="text" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x_Quien_Paga" id="x_Quien_Paga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Quien_Paga->EditValue ?>"<?php echo $datos_extras_escuela->Quien_Paga->EditAttributes() ?>>
</span>
<?php echo $datos_extras_escuela->Quien_Paga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Actualizacion" id="u_Fecha_Actualizacion" value="1"<?php echo ($datos_extras_escuela->Fecha_Actualizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Fecha_Actualizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Fecha_Actualizacion->CellAttributes() ?>>
<?php echo $datos_extras_escuela->Fecha_Actualizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="col-sm-2 control-label">
<input type="checkbox" name="u_Usuario" id="u_Usuario" value="1"<?php echo ($datos_extras_escuela->Usuario->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $datos_extras_escuela->Usuario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $datos_extras_escuela->Usuario->CellAttributes() ?>>
<?php echo $datos_extras_escuela->Usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$datos_extras_escuela_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $datos_extras_escuela_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fdatos_extras_escuelaupdate.Init();
</script>
<?php
$datos_extras_escuela_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datos_extras_escuela_update->Page_Terminate();
?>
