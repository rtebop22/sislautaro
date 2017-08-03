<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "devolucion_equipoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$devolucion_equipo_update = NULL; // Initialize page object first

class cdevolucion_equipo_update extends cdevolucion_equipo {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'devolucion_equipo';

	// Page object name
	var $PageObjName = 'devolucion_equipo_update';

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

		// Table object (devolucion_equipo)
		if (!isset($GLOBALS["devolucion_equipo"]) || get_class($GLOBALS["devolucion_equipo"]) == "cdevolucion_equipo") {
			$GLOBALS["devolucion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["devolucion_equipo"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'devolucion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("devolucion_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Admin_Que_Recibe->SetVisibility();
		$this->Id_Autoridad->SetVisibility();
		$this->Fecha_Devolucion->SetVisibility();
		$this->Id_Motivo->SetVisibility();
		$this->Id_Estado_Devol->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Devuelve_Cargador->SetVisibility();

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
		global $EW_EXPORT, $devolucion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($devolucion_equipo);
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
			$this->Page_Terminate("devolucion_equipolist.php"); // No records selected, return to list
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
					$this->Dni->setDbValue($this->Recordset->fields('Dni'));
					$this->NroSerie->setDbValue($this->Recordset->fields('NroSerie'));
					$this->Dni_Tutor->setDbValue($this->Recordset->fields('Dni_Tutor'));
					$this->Admin_Que_Recibe->setDbValue($this->Recordset->fields('Admin_Que_Recibe'));
					$this->Id_Autoridad->setDbValue($this->Recordset->fields('Id_Autoridad'));
					$this->Fecha_Devolucion->setDbValue($this->Recordset->fields('Fecha_Devolucion'));
					$this->Id_Motivo->setDbValue($this->Recordset->fields('Id_Motivo'));
					$this->Id_Estado_Devol->setDbValue($this->Recordset->fields('Id_Estado_Devol'));
					$this->Observacion->setDbValue($this->Recordset->fields('Observacion'));
					$this->Devuelve_Cargador->setDbValue($this->Recordset->fields('Devuelve_Cargador'));
				} else {
					if (!ew_CompareValue($this->Dni->DbValue, $this->Recordset->fields('Dni')))
						$this->Dni->CurrentValue = NULL;
					if (!ew_CompareValue($this->NroSerie->DbValue, $this->Recordset->fields('NroSerie')))
						$this->NroSerie->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni_Tutor->DbValue, $this->Recordset->fields('Dni_Tutor')))
						$this->Dni_Tutor->CurrentValue = NULL;
					if (!ew_CompareValue($this->Admin_Que_Recibe->DbValue, $this->Recordset->fields('Admin_Que_Recibe')))
						$this->Admin_Que_Recibe->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Autoridad->DbValue, $this->Recordset->fields('Id_Autoridad')))
						$this->Id_Autoridad->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Devolucion->DbValue, $this->Recordset->fields('Fecha_Devolucion')))
						$this->Fecha_Devolucion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Motivo->DbValue, $this->Recordset->fields('Id_Motivo')))
						$this->Id_Motivo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado_Devol->DbValue, $this->Recordset->fields('Id_Estado_Devol')))
						$this->Id_Estado_Devol->CurrentValue = NULL;
					if (!ew_CompareValue($this->Observacion->DbValue, $this->Recordset->fields('Observacion')))
						$this->Observacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Devuelve_Cargador->DbValue, $this->Recordset->fields('Devuelve_Cargador')))
						$this->Devuelve_Cargador->CurrentValue = NULL;
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
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->MultiUpdate = $objForm->GetValue("u_Dni");
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->MultiUpdate = $objForm->GetValue("u_NroSerie");
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		$this->Dni_Tutor->MultiUpdate = $objForm->GetValue("u_Dni_Tutor");
		if (!$this->Admin_Que_Recibe->FldIsDetailKey) {
			$this->Admin_Que_Recibe->setFormValue($objForm->GetValue("x_Admin_Que_Recibe"));
		}
		$this->Admin_Que_Recibe->MultiUpdate = $objForm->GetValue("u_Admin_Que_Recibe");
		if (!$this->Id_Autoridad->FldIsDetailKey) {
			$this->Id_Autoridad->setFormValue($objForm->GetValue("x_Id_Autoridad"));
		}
		$this->Id_Autoridad->MultiUpdate = $objForm->GetValue("u_Id_Autoridad");
		if (!$this->Fecha_Devolucion->FldIsDetailKey) {
			$this->Fecha_Devolucion->setFormValue($objForm->GetValue("x_Fecha_Devolucion"));
		}
		$this->Fecha_Devolucion->MultiUpdate = $objForm->GetValue("u_Fecha_Devolucion");
		if (!$this->Id_Motivo->FldIsDetailKey) {
			$this->Id_Motivo->setFormValue($objForm->GetValue("x_Id_Motivo"));
		}
		$this->Id_Motivo->MultiUpdate = $objForm->GetValue("u_Id_Motivo");
		if (!$this->Id_Estado_Devol->FldIsDetailKey) {
			$this->Id_Estado_Devol->setFormValue($objForm->GetValue("x_Id_Estado_Devol"));
		}
		$this->Id_Estado_Devol->MultiUpdate = $objForm->GetValue("u_Id_Estado_Devol");
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->MultiUpdate = $objForm->GetValue("u_Observacion");
		if (!$this->Devuelve_Cargador->FldIsDetailKey) {
			$this->Devuelve_Cargador->setFormValue($objForm->GetValue("x_Devuelve_Cargador"));
		}
		$this->Devuelve_Cargador->MultiUpdate = $objForm->GetValue("u_Devuelve_Cargador");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Admin_Que_Recibe->CurrentValue = $this->Admin_Que_Recibe->FormValue;
		$this->Id_Autoridad->CurrentValue = $this->Id_Autoridad->FormValue;
		$this->Fecha_Devolucion->CurrentValue = $this->Fecha_Devolucion->FormValue;
		$this->Id_Motivo->CurrentValue = $this->Id_Motivo->FormValue;
		$this->Id_Estado_Devol->CurrentValue = $this->Id_Estado_Devol->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Devuelve_Cargador->CurrentValue = $this->Devuelve_Cargador->FormValue;
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
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Admin_Que_Recibe->setDbValue($rs->fields('Admin_Que_Recibe'));
		$this->Id_Autoridad->setDbValue($rs->fields('Id_Autoridad'));
		$this->Fecha_Devolucion->setDbValue($rs->fields('Fecha_Devolucion'));
		$this->Id_Motivo->setDbValue($rs->fields('Id_Motivo'));
		$this->Id_Estado_Devol->setDbValue($rs->fields('Id_Estado_Devol'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Devuelve_Cargador->setDbValue($rs->fields('Devuelve_Cargador'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Admin_Que_Recibe->DbValue = $row['Admin_Que_Recibe'];
		$this->Id_Autoridad->DbValue = $row['Id_Autoridad'];
		$this->Fecha_Devolucion->DbValue = $row['Fecha_Devolucion'];
		$this->Id_Motivo->DbValue = $row['Id_Motivo'];
		$this->Id_Estado_Devol->DbValue = $row['Id_Estado_Devol'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Devuelve_Cargador->DbValue = $row['Devuelve_Cargador'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Dni
		// NroSerie
		// Dni_Tutor
		// Admin_Que_Recibe
		// Id_Autoridad
		// Fecha_Devolucion
		// Id_Motivo
		// Id_Estado_Devol
		// Observacion
		// Devuelve_Cargador

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni
		if (strval($this->Dni->CurrentValue) <> "") {
			$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni->ViewValue = $this->Dni->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni->ViewValue = $this->Dni->CurrentValue;
			}
		} else {
			$this->Dni->ViewValue = NULL;
		}
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
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

		// Dni_Tutor
		if (strval($this->Dni_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			}
		} else {
			$this->Dni_Tutor->ViewValue = NULL;
		}
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Admin_Que_Recibe
		if (strval($this->Admin_Que_Recibe->CurrentValue) <> "") {
			$sFilterWrk = "`DniRte`" . ew_SearchString("=", $this->Admin_Que_Recibe->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `DniRte`, `Apelldio_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
		$sWhereWrk = "";
		$this->Admin_Que_Recibe->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Admin_Que_Recibe, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Admin_Que_Recibe->ViewValue = $this->Admin_Que_Recibe->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Admin_Que_Recibe->ViewValue = $this->Admin_Que_Recibe->CurrentValue;
			}
		} else {
			$this->Admin_Que_Recibe->ViewValue = NULL;
		}
		$this->Admin_Que_Recibe->ViewCustomAttributes = "";

		// Id_Autoridad
		if (strval($this->Id_Autoridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
		$sWhereWrk = "";
		$this->Id_Autoridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
			}
		} else {
			$this->Id_Autoridad->ViewValue = NULL;
		}
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->ViewValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->ViewValue = ew_FormatDateTime($this->Fecha_Devolucion->ViewValue, 7);
		$this->Fecha_Devolucion->ViewCustomAttributes = "";

		// Id_Motivo
		if (strval($this->Id_Motivo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_devolucion`";
		$sWhereWrk = "";
		$this->Id_Motivo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Id_Motivo` ASC";
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

		// Id_Estado_Devol
		if (strval($this->Id_Estado_Devol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo_devuleto`";
		$sWhereWrk = "";
		$this->Id_Estado_Devol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Devuelve_Cargador
		if (strval($this->Devuelve_Cargador->CurrentValue) <> "") {
			$this->Devuelve_Cargador->ViewValue = $this->Devuelve_Cargador->OptionCaption($this->Devuelve_Cargador->CurrentValue);
		} else {
			$this->Devuelve_Cargador->ViewValue = NULL;
		}
		$this->Devuelve_Cargador->ViewCustomAttributes = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Admin_Que_Recibe
			$this->Admin_Que_Recibe->LinkCustomAttributes = "";
			$this->Admin_Que_Recibe->HrefValue = "";
			$this->Admin_Que_Recibe->TooltipValue = "";

			// Id_Autoridad
			$this->Id_Autoridad->LinkCustomAttributes = "";
			$this->Id_Autoridad->HrefValue = "";
			$this->Id_Autoridad->TooltipValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
			$this->Fecha_Devolucion->TooltipValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";
			$this->Id_Motivo->TooltipValue = "";

			// Id_Estado_Devol
			$this->Id_Estado_Devol->LinkCustomAttributes = "";
			$this->Id_Estado_Devol->HrefValue = "";
			$this->Id_Estado_Devol->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Devuelve_Cargador
			$this->Devuelve_Cargador->LinkCustomAttributes = "";
			$this->Devuelve_Cargador->HrefValue = "";
			$this->Devuelve_Cargador->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dni
			$this->Dni->EditCustomAttributes = "";
			if (trim(strval($this->Dni->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `personas`";
			$sWhereWrk = "";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Dni->ViewValue = $this->Dni->DisplayValue($arwrk);
			} else {
				$this->Dni->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Dni->EditValue = $arwrk;

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->ViewCustomAttributes = "";

			// Dni_Tutor
			$this->Dni_Tutor->EditCustomAttributes = "";
			if (trim(strval($this->Dni_Tutor->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tutores`";
			$sWhereWrk = "";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
			} else {
				$this->Dni_Tutor->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Dni_Tutor->EditValue = $arwrk;

			// Admin_Que_Recibe
			$this->Admin_Que_Recibe->EditAttrs["class"] = "form-control";
			$this->Admin_Que_Recibe->EditCustomAttributes = "";
			if (trim(strval($this->Admin_Que_Recibe->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`DniRte`" . ew_SearchString("=", $this->Admin_Que_Recibe->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `DniRte`, `Apelldio_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `referente_tecnico`";
			$sWhereWrk = "";
			$this->Admin_Que_Recibe->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Admin_Que_Recibe, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Admin_Que_Recibe->EditValue = $arwrk;

			// Id_Autoridad
			$this->Id_Autoridad->EditAttrs["class"] = "form-control";
			$this->Id_Autoridad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Autoridad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Autoridad->EditValue = $arwrk;

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode($this->Fecha_Devolucion->CurrentValue);
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

			// Id_Motivo
			$this->Id_Motivo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_devolucion`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Motivo` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo->EditValue = $arwrk;

			// Id_Estado_Devol
			$this->Id_Estado_Devol->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Devol->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Devol->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipo_devuleto`";
			$sWhereWrk = "";
			$this->Id_Estado_Devol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Devol->EditValue = $arwrk;

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Devuelve_Cargador
			$this->Devuelve_Cargador->EditCustomAttributes = "";
			$this->Devuelve_Cargador->EditValue = $this->Devuelve_Cargador->Options(FALSE);

			// Edit refer script
			// Dni

			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Admin_Que_Recibe
			$this->Admin_Que_Recibe->LinkCustomAttributes = "";
			$this->Admin_Que_Recibe->HrefValue = "";

			// Id_Autoridad
			$this->Id_Autoridad->LinkCustomAttributes = "";
			$this->Id_Autoridad->HrefValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";

			// Id_Estado_Devol
			$this->Id_Estado_Devol->LinkCustomAttributes = "";
			$this->Id_Estado_Devol->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Devuelve_Cargador
			$this->Devuelve_Cargador->LinkCustomAttributes = "";
			$this->Devuelve_Cargador->HrefValue = "";
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
		if ($this->Dni->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->NroSerie->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni_Tutor->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Admin_Que_Recibe->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Autoridad->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Devolucion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Motivo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado_Devol->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Observacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Devuelve_Cargador->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Dni->MultiUpdate <> "" && !$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if ($this->Dni_Tutor->MultiUpdate <> "" && !$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if ($this->Id_Autoridad->MultiUpdate <> "" && !$this->Id_Autoridad->FldIsDetailKey && !is_null($this->Id_Autoridad->FormValue) && $this->Id_Autoridad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Autoridad->FldCaption(), $this->Id_Autoridad->ReqErrMsg));
		}
		if ($this->Fecha_Devolucion->MultiUpdate <> "") {
			if (!ew_CheckEuroDate($this->Fecha_Devolucion->FormValue)) {
				ew_AddMessage($gsFormError, $this->Fecha_Devolucion->FldErrMsg());
			}
		}
		if ($this->Id_Motivo->MultiUpdate <> "" && !$this->Id_Motivo->FldIsDetailKey && !is_null($this->Id_Motivo->FormValue) && $this->Id_Motivo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo->FldCaption(), $this->Id_Motivo->ReqErrMsg));
		}
		if ($this->Id_Estado_Devol->MultiUpdate <> "" && !$this->Id_Estado_Devol->FldIsDetailKey && !is_null($this->Id_Estado_Devol->FormValue) && $this->Id_Estado_Devol->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Devol->FldCaption(), $this->Id_Estado_Devol->ReqErrMsg));
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

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, $this->Dni->ReadOnly || $this->Dni->MultiUpdate <> "1");

			// NroSerie
			// Dni_Tutor

			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly || $this->Dni_Tutor->MultiUpdate <> "1");

			// Admin_Que_Recibe
			$this->Admin_Que_Recibe->SetDbValueDef($rsnew, $this->Admin_Que_Recibe->CurrentValue, NULL, $this->Admin_Que_Recibe->ReadOnly || $this->Admin_Que_Recibe->MultiUpdate <> "1");

			// Id_Autoridad
			$this->Id_Autoridad->SetDbValueDef($rsnew, $this->Id_Autoridad->CurrentValue, 0, $this->Id_Autoridad->ReadOnly || $this->Id_Autoridad->MultiUpdate <> "1");

			// Fecha_Devolucion
			$this->Fecha_Devolucion->SetDbValueDef($rsnew, $this->Fecha_Devolucion->CurrentValue, NULL, $this->Fecha_Devolucion->ReadOnly || $this->Fecha_Devolucion->MultiUpdate <> "1");

			// Id_Motivo
			$this->Id_Motivo->SetDbValueDef($rsnew, $this->Id_Motivo->CurrentValue, 0, $this->Id_Motivo->ReadOnly || $this->Id_Motivo->MultiUpdate <> "1");

			// Id_Estado_Devol
			$this->Id_Estado_Devol->SetDbValueDef($rsnew, $this->Id_Estado_Devol->CurrentValue, 0, $this->Id_Estado_Devol->ReadOnly || $this->Id_Estado_Devol->MultiUpdate <> "1");

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly || $this->Observacion->MultiUpdate <> "1");

			// Devuelve_Cargador
			$this->Devuelve_Cargador->SetDbValueDef($rsnew, $this->Devuelve_Cargador->CurrentValue, NULL, $this->Devuelve_Cargador->ReadOnly || $this->Devuelve_Cargador->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("devolucion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Dni":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni_Tutor` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Admin_Que_Recibe":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `DniRte` AS `LinkFld`, `Apelldio_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "";
			$this->Admin_Que_Recibe->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`DniRte` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Admin_Que_Recibe, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Autoridad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Autoridad` AS `LinkFld`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Autoridad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_devolucion`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Motivo` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Devol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Devol` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipo_devuleto`";
			$sWhereWrk = "";
			$this->Id_Estado_Devol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Devol` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
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
		$table = 'devolucion_equipo';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'devolucion_equipo';

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
if (!isset($devolucion_equipo_update)) $devolucion_equipo_update = new cdevolucion_equipo_update();

// Page init
$devolucion_equipo_update->Page_Init();

// Page main
$devolucion_equipo_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$devolucion_equipo_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fdevolucion_equipoupdate = new ew_Form("fdevolucion_equipoupdate", "update");

// Validate form
fdevolucion_equipoupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $devolucion_equipo->Dni->FldCaption(), $devolucion_equipo->Dni->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			uelm = this.GetElements("u" + infix + "_Dni_Tutor");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $devolucion_equipo->Dni_Tutor->FldCaption(), $devolucion_equipo->Dni_Tutor->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Autoridad");
			uelm = this.GetElements("u" + infix + "_Id_Autoridad");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $devolucion_equipo->Id_Autoridad->FldCaption(), $devolucion_equipo->Id_Autoridad->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Fecha_Devolucion");
			uelm = this.GetElements("u" + infix + "_Fecha_Devolucion");
			if (uelm && uelm.checked && elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($devolucion_equipo->Fecha_Devolucion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo");
			uelm = this.GetElements("u" + infix + "_Id_Motivo");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $devolucion_equipo->Id_Motivo->FldCaption(), $devolucion_equipo->Id_Motivo->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Estado_Devol");
			uelm = this.GetElements("u" + infix + "_Id_Estado_Devol");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $devolucion_equipo->Id_Estado_Devol->FldCaption(), $devolucion_equipo->Id_Estado_Devol->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdevolucion_equipoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdevolucion_equipoupdate.ValidateRequired = true;
<?php } else { ?>
fdevolucion_equipoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdevolucion_equipoupdate.Lists["x_Dni"] = {"LinkField":"x_Dni","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","x_Dni","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fdevolucion_equipoupdate.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fdevolucion_equipoupdate.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fdevolucion_equipoupdate.Lists["x_Admin_Que_Recibe"] = {"LinkField":"x_DniRte","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apelldio_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"referente_tecnico"};
fdevolucion_equipoupdate.Lists["x_Id_Autoridad"] = {"LinkField":"x_Id_Autoridad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"autoridades_escolares"};
fdevolucion_equipoupdate.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_devolucion"};
fdevolucion_equipoupdate.Lists["x_Id_Estado_Devol"] = {"LinkField":"x_Id_Estado_Devol","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo_devuleto"};
fdevolucion_equipoupdate.Lists["x_Devuelve_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdevolucion_equipoupdate.Lists["x_Devuelve_Cargador"].Options = <?php echo json_encode($devolucion_equipo->Devuelve_Cargador->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$devolucion_equipo_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $devolucion_equipo_update->ShowPageHeader(); ?>
<?php
$devolucion_equipo_update->ShowMessage();
?>
<form name="fdevolucion_equipoupdate" id="fdevolucion_equipoupdate" class="<?php echo $devolucion_equipo_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($devolucion_equipo_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $devolucion_equipo_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="devolucion_equipo">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($devolucion_equipo_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($devolucion_equipo_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_devolucion_equipoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($devolucion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni" id="u_Dni" value="1"<?php echo ($devolucion_equipo->Dni->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Dni->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Dni->CellAttributes() ?>>
<span id="el_devolucion_equipo_Dni">
<?php $devolucion_equipo->Dni->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$devolucion_equipo->Dni->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni"><?php echo (strval($devolucion_equipo->Dni->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $devolucion_equipo->Dni->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($devolucion_equipo->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="devolucion_equipo" data-field="x_Dni" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $devolucion_equipo->Dni->DisplayValueSeparatorAttribute() ?>" name="x_Dni" id="x_Dni" value="<?php echo $devolucion_equipo->Dni->CurrentValue ?>"<?php echo $devolucion_equipo->Dni->EditAttributes() ?>>
<input type="hidden" name="s_x_Dni" id="s_x_Dni" value="<?php echo $devolucion_equipo->Dni->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Dni" id="ln_x_Dni" value="x_Dni_Tutor">
</span>
<?php echo $devolucion_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label for="x_Dni_Tutor" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni_Tutor" id="u_Dni_Tutor" value="1"<?php echo ($devolucion_equipo->Dni_Tutor->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Dni_Tutor->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el_devolucion_equipo_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni_Tutor"><?php echo (strval($devolucion_equipo->Dni_Tutor->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $devolucion_equipo->Dni_Tutor->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($devolucion_equipo->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="devolucion_equipo" data-field="x_Dni_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $devolucion_equipo->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo $devolucion_equipo->Dni_Tutor->CurrentValue ?>"<?php echo $devolucion_equipo->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x_Dni_Tutor" id="s_x_Dni_Tutor" value="<?php echo $devolucion_equipo->Dni_Tutor->LookupFilterQuery() ?>">
</span>
<?php echo $devolucion_equipo->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Admin_Que_Recibe->Visible) { // Admin_Que_Recibe ?>
	<div id="r_Admin_Que_Recibe" class="form-group">
		<label for="x_Admin_Que_Recibe" class="col-sm-2 control-label">
<input type="checkbox" name="u_Admin_Que_Recibe" id="u_Admin_Que_Recibe" value="1"<?php echo ($devolucion_equipo->Admin_Que_Recibe->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Admin_Que_Recibe->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Admin_Que_Recibe->CellAttributes() ?>>
<span id="el_devolucion_equipo_Admin_Que_Recibe">
<select data-table="devolucion_equipo" data-field="x_Admin_Que_Recibe" data-value-separator="<?php echo $devolucion_equipo->Admin_Que_Recibe->DisplayValueSeparatorAttribute() ?>" id="x_Admin_Que_Recibe" name="x_Admin_Que_Recibe"<?php echo $devolucion_equipo->Admin_Que_Recibe->EditAttributes() ?>>
<?php echo $devolucion_equipo->Admin_Que_Recibe->SelectOptionListHtml("x_Admin_Que_Recibe") ?>
</select>
<input type="hidden" name="s_x_Admin_Que_Recibe" id="s_x_Admin_Que_Recibe" value="<?php echo $devolucion_equipo->Admin_Que_Recibe->LookupFilterQuery() ?>">
</span>
<?php echo $devolucion_equipo->Admin_Que_Recibe->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Id_Autoridad->Visible) { // Id_Autoridad ?>
	<div id="r_Id_Autoridad" class="form-group">
		<label for="x_Id_Autoridad" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Autoridad" id="u_Id_Autoridad" value="1"<?php echo ($devolucion_equipo->Id_Autoridad->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Id_Autoridad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Id_Autoridad->CellAttributes() ?>>
<span id="el_devolucion_equipo_Id_Autoridad">
<select data-table="devolucion_equipo" data-field="x_Id_Autoridad" data-value-separator="<?php echo $devolucion_equipo->Id_Autoridad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Autoridad" name="x_Id_Autoridad"<?php echo $devolucion_equipo->Id_Autoridad->EditAttributes() ?>>
<?php echo $devolucion_equipo->Id_Autoridad->SelectOptionListHtml("x_Id_Autoridad") ?>
</select>
<input type="hidden" name="s_x_Id_Autoridad" id="s_x_Id_Autoridad" value="<?php echo $devolucion_equipo->Id_Autoridad->LookupFilterQuery() ?>">
</span>
<?php echo $devolucion_equipo->Id_Autoridad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
	<div id="r_Fecha_Devolucion" class="form-group">
		<label for="x_Fecha_Devolucion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Devolucion" id="u_Fecha_Devolucion" value="1"<?php echo ($devolucion_equipo->Fecha_Devolucion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Fecha_Devolucion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Fecha_Devolucion->CellAttributes() ?>>
<span id="el_devolucion_equipo_Fecha_Devolucion">
<input type="text" data-table="devolucion_equipo" data-field="x_Fecha_Devolucion" name="x_Fecha_Devolucion" id="x_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($devolucion_equipo->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $devolucion_equipo->Fecha_Devolucion->EditValue ?>"<?php echo $devolucion_equipo->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$devolucion_equipo->Fecha_Devolucion->ReadOnly && !$devolucion_equipo->Fecha_Devolucion->Disabled && !isset($devolucion_equipo->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($devolucion_equipo->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdevolucion_equipoupdate", "x_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php echo $devolucion_equipo->Fecha_Devolucion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Id_Motivo->Visible) { // Id_Motivo ?>
	<div id="r_Id_Motivo" class="form-group">
		<label for="x_Id_Motivo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Motivo" id="u_Id_Motivo" value="1"<?php echo ($devolucion_equipo->Id_Motivo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Id_Motivo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Id_Motivo->CellAttributes() ?>>
<span id="el_devolucion_equipo_Id_Motivo">
<select data-table="devolucion_equipo" data-field="x_Id_Motivo" data-value-separator="<?php echo $devolucion_equipo->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo" name="x_Id_Motivo"<?php echo $devolucion_equipo->Id_Motivo->EditAttributes() ?>>
<?php echo $devolucion_equipo->Id_Motivo->SelectOptionListHtml("x_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo" id="s_x_Id_Motivo" value="<?php echo $devolucion_equipo->Id_Motivo->LookupFilterQuery() ?>">
</span>
<?php echo $devolucion_equipo->Id_Motivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Id_Estado_Devol->Visible) { // Id_Estado_Devol ?>
	<div id="r_Id_Estado_Devol" class="form-group">
		<label for="x_Id_Estado_Devol" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado_Devol" id="u_Id_Estado_Devol" value="1"<?php echo ($devolucion_equipo->Id_Estado_Devol->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Id_Estado_Devol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Id_Estado_Devol->CellAttributes() ?>>
<span id="el_devolucion_equipo_Id_Estado_Devol">
<select data-table="devolucion_equipo" data-field="x_Id_Estado_Devol" data-value-separator="<?php echo $devolucion_equipo->Id_Estado_Devol->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Devol" name="x_Id_Estado_Devol"<?php echo $devolucion_equipo->Id_Estado_Devol->EditAttributes() ?>>
<?php echo $devolucion_equipo->Id_Estado_Devol->SelectOptionListHtml("x_Id_Estado_Devol") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Devol" id="s_x_Id_Estado_Devol" value="<?php echo $devolucion_equipo->Id_Estado_Devol->LookupFilterQuery() ?>">
</span>
<?php echo $devolucion_equipo->Id_Estado_Devol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Observacion" id="u_Observacion" value="1"<?php echo ($devolucion_equipo->Observacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Observacion->CellAttributes() ?>>
<span id="el_devolucion_equipo_Observacion">
<textarea data-table="devolucion_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($devolucion_equipo->Observacion->getPlaceHolder()) ?>"<?php echo $devolucion_equipo->Observacion->EditAttributes() ?>><?php echo $devolucion_equipo->Observacion->EditValue ?></textarea>
</span>
<?php echo $devolucion_equipo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($devolucion_equipo->Devuelve_Cargador->Visible) { // Devuelve_Cargador ?>
	<div id="r_Devuelve_Cargador" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Devuelve_Cargador" id="u_Devuelve_Cargador" value="1"<?php echo ($devolucion_equipo->Devuelve_Cargador->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $devolucion_equipo->Devuelve_Cargador->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $devolucion_equipo->Devuelve_Cargador->CellAttributes() ?>>
<span id="el_devolucion_equipo_Devuelve_Cargador">
<div id="tp_x_Devuelve_Cargador" class="ewTemplate"><input type="radio" data-table="devolucion_equipo" data-field="x_Devuelve_Cargador" data-value-separator="<?php echo $devolucion_equipo->Devuelve_Cargador->DisplayValueSeparatorAttribute() ?>" name="x_Devuelve_Cargador" id="x_Devuelve_Cargador" value="{value}"<?php echo $devolucion_equipo->Devuelve_Cargador->EditAttributes() ?>></div>
<div id="dsl_x_Devuelve_Cargador" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $devolucion_equipo->Devuelve_Cargador->RadioButtonListHtml(FALSE, "x_Devuelve_Cargador") ?>
</div></div>
</span>
<?php echo $devolucion_equipo->Devuelve_Cargador->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$devolucion_equipo_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $devolucion_equipo_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fdevolucion_equipoupdate.Init();
</script>
<?php
$devolucion_equipo_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$devolucion_equipo_update->Page_Terminate();
?>
