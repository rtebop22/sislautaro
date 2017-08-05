<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "referente_tecnicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$referente_tecnico_update = NULL; // Initialize page object first

class creferente_tecnico_update extends creferente_tecnico {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'referente_tecnico';

	// Page object name
	var $PageObjName = 'referente_tecnico_update';

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

		// Table object (referente_tecnico)
		if (!isset($GLOBALS["referente_tecnico"]) || get_class($GLOBALS["referente_tecnico"]) == "creferente_tecnico") {
			$GLOBALS["referente_tecnico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referente_tecnico"];
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
			define("EW_TABLE_NAME", 'referente_tecnico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("referente_tecnicolist.php"));
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
		$this->Apellido_Nombre->SetVisibility();
		$this->DniRte->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Fecha_Ingreso->SetVisibility();
		$this->Titulo->SetVisibility();
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
		global $EW_EXPORT, $referente_tecnico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($referente_tecnico);
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
			$this->Page_Terminate("referente_tecnicolist.php"); // No records selected, return to list
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
					$this->Apellido_Nombre->setDbValue($this->Recordset->fields('Apellido_Nombre'));
					$this->DniRte->setDbValue($this->Recordset->fields('DniRte'));
					$this->Domicilio->setDbValue($this->Recordset->fields('Domicilio'));
					$this->Telefono->setDbValue($this->Recordset->fields('Telefono'));
					$this->Celular->setDbValue($this->Recordset->fields('Celular'));
					$this->Mail->setDbValue($this->Recordset->fields('Mail'));
					$this->Id_Turno->setDbValue($this->Recordset->fields('Id_Turno'));
					$this->Fecha_Ingreso->setDbValue($this->Recordset->fields('Fecha_Ingreso'));
					$this->Titulo->setDbValue($this->Recordset->fields('Titulo'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
				} else {
					if (!ew_CompareValue($this->Apellido_Nombre->DbValue, $this->Recordset->fields('Apellido_Nombre')))
						$this->Apellido_Nombre->CurrentValue = NULL;
					if (!ew_CompareValue($this->DniRte->DbValue, $this->Recordset->fields('DniRte')))
						$this->DniRte->CurrentValue = NULL;
					if (!ew_CompareValue($this->Domicilio->DbValue, $this->Recordset->fields('Domicilio')))
						$this->Domicilio->CurrentValue = NULL;
					if (!ew_CompareValue($this->Telefono->DbValue, $this->Recordset->fields('Telefono')))
						$this->Telefono->CurrentValue = NULL;
					if (!ew_CompareValue($this->Celular->DbValue, $this->Recordset->fields('Celular')))
						$this->Celular->CurrentValue = NULL;
					if (!ew_CompareValue($this->Mail->DbValue, $this->Recordset->fields('Mail')))
						$this->Mail->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Turno->DbValue, $this->Recordset->fields('Id_Turno')))
						$this->Id_Turno->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Ingreso->DbValue, $this->Recordset->fields('Fecha_Ingreso')))
						$this->Fecha_Ingreso->CurrentValue = NULL;
					if (!ew_CompareValue($this->Titulo->DbValue, $this->Recordset->fields('Titulo')))
						$this->Titulo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario->DbValue, $this->Recordset->fields('Usuario')))
						$this->Usuario->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Actualizacion->DbValue, $this->Recordset->fields('Fecha_Actualizacion')))
						$this->Fecha_Actualizacion->CurrentValue = NULL;
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
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->DniRte->CurrentValue = $sKeyFld;
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
		if (!$this->Apellido_Nombre->FldIsDetailKey) {
			$this->Apellido_Nombre->setFormValue($objForm->GetValue("x_Apellido_Nombre"));
		}
		$this->Apellido_Nombre->MultiUpdate = $objForm->GetValue("u_Apellido_Nombre");
		if (!$this->DniRte->FldIsDetailKey) {
			$this->DniRte->setFormValue($objForm->GetValue("x_DniRte"));
		}
		$this->DniRte->MultiUpdate = $objForm->GetValue("u_DniRte");
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		$this->Domicilio->MultiUpdate = $objForm->GetValue("u_Domicilio");
		if (!$this->Telefono->FldIsDetailKey) {
			$this->Telefono->setFormValue($objForm->GetValue("x_Telefono"));
		}
		$this->Telefono->MultiUpdate = $objForm->GetValue("u_Telefono");
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		$this->Celular->MultiUpdate = $objForm->GetValue("u_Celular");
		if (!$this->Mail->FldIsDetailKey) {
			$this->Mail->setFormValue($objForm->GetValue("x_Mail"));
		}
		$this->Mail->MultiUpdate = $objForm->GetValue("u_Mail");
		if (!$this->Id_Turno->FldIsDetailKey) {
			$this->Id_Turno->setFormValue($objForm->GetValue("x_Id_Turno"));
		}
		$this->Id_Turno->MultiUpdate = $objForm->GetValue("u_Id_Turno");
		if (!$this->Fecha_Ingreso->FldIsDetailKey) {
			$this->Fecha_Ingreso->setFormValue($objForm->GetValue("x_Fecha_Ingreso"));
			$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		}
		$this->Fecha_Ingreso->MultiUpdate = $objForm->GetValue("u_Fecha_Ingreso");
		if (!$this->Titulo->FldIsDetailKey) {
			$this->Titulo->setFormValue($objForm->GetValue("x_Titulo"));
		}
		$this->Titulo->MultiUpdate = $objForm->GetValue("u_Titulo");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Apellido_Nombre->CurrentValue = $this->Apellido_Nombre->FormValue;
		$this->DniRte->CurrentValue = $this->DniRte->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Telefono->CurrentValue = $this->Telefono->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Mail->CurrentValue = $this->Mail->FormValue;
		$this->Id_Turno->CurrentValue = $this->Id_Turno->FormValue;
		$this->Fecha_Ingreso->CurrentValue = $this->Fecha_Ingreso->FormValue;
		$this->Fecha_Ingreso->CurrentValue = ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2);
		$this->Titulo->CurrentValue = $this->Titulo->FormValue;
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Apellido_Nombre->setDbValue($rs->fields('Apellido_Nombre'));
		$this->DniRte->setDbValue($rs->fields('DniRte'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Mail->setDbValue($rs->fields('Mail'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Fecha_Ingreso->setDbValue($rs->fields('Fecha_Ingreso'));
		$this->Titulo->setDbValue($rs->fields('Titulo'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apellido_Nombre->DbValue = $row['Apellido_Nombre'];
		$this->DniRte->DbValue = $row['DniRte'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->Celular->DbValue = $row['Celular'];
		$this->Mail->DbValue = $row['Mail'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Fecha_Ingreso->DbValue = $row['Fecha_Ingreso'];
		$this->Titulo->DbValue = $row['Titulo'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Apellido_Nombre
		// DniRte
		// Domicilio
		// Telefono
		// Celular
		// Mail
		// Id_Turno
		// Fecha_Ingreso
		// Titulo
		// Usuario
		// Fecha_Actualizacion
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// DniRte
		$this->DniRte->ViewValue = $this->DniRte->CurrentValue;
		$this->DniRte->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

		// Fecha_Ingreso
		$this->Fecha_Ingreso->ViewValue = $this->Fecha_Ingreso->CurrentValue;
		$this->Fecha_Ingreso->ViewValue = ew_FormatDateTime($this->Fecha_Ingreso->ViewValue, 2);
		$this->Fecha_Ingreso->ViewCustomAttributes = "";

		// Titulo
		$this->Titulo->ViewValue = $this->Titulo->CurrentValue;
		$this->Titulo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";
			$this->DniRte->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";
			$this->Mail->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";
			$this->Fecha_Ingreso->TooltipValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";
			$this->Titulo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->CurrentValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = $this->DniRte->CurrentValue;
			$this->DniRte->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono
			$this->Telefono->EditAttrs["class"] = "form-control";
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->CurrentValue);
			$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

			// Celular
			$this->Celular->EditAttrs["class"] = "form-control";
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);
			$this->Celular->PlaceHolder = ew_RemoveHtml($this->Celular->FldCaption());

			// Mail
			$this->Mail->EditAttrs["class"] = "form-control";
			$this->Mail->EditCustomAttributes = "";
			$this->Mail->EditValue = ew_HtmlEncode($this->Mail->CurrentValue);
			$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Fecha_Ingreso
			$this->Fecha_Ingreso->EditAttrs["class"] = "form-control";
			$this->Fecha_Ingreso->EditCustomAttributes = "";
			$this->Fecha_Ingreso->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Ingreso->CurrentValue, 2));
			$this->Fecha_Ingreso->PlaceHolder = ew_RemoveHtml($this->Fecha_Ingreso->FldCaption());

			// Titulo
			$this->Titulo->EditAttrs["class"] = "form-control";
			$this->Titulo->EditCustomAttributes = "";
			$this->Titulo->EditValue = ew_HtmlEncode($this->Titulo->CurrentValue);
			$this->Titulo->PlaceHolder = ew_RemoveHtml($this->Titulo->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Apellido_Nombre

			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
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
		if ($this->Apellido_Nombre->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->DniRte->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Domicilio->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Telefono->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Celular->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Mail->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Turno->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Ingreso->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Titulo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Apellido_Nombre->MultiUpdate <> "" && !$this->Apellido_Nombre->FldIsDetailKey && !is_null($this->Apellido_Nombre->FormValue) && $this->Apellido_Nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Apellido_Nombre->FldCaption(), $this->Apellido_Nombre->ReqErrMsg));
		}
		if ($this->DniRte->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->DniRte->FormValue)) {
				ew_AddMessage($gsFormError, $this->DniRte->FldErrMsg());
			}
		}
		if ($this->Telefono->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Telefono->FormValue)) {
				ew_AddMessage($gsFormError, $this->Telefono->FldErrMsg());
			}
		}
		if ($this->Celular->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Celular->FormValue)) {
				ew_AddMessage($gsFormError, $this->Celular->FldErrMsg());
			}
		}
		if ($this->Mail->MultiUpdate <> "" && !$this->Mail->FldIsDetailKey && !is_null($this->Mail->FormValue) && $this->Mail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Mail->FldCaption(), $this->Mail->ReqErrMsg));
		}
		if ($this->Mail->MultiUpdate <> "") {
			if (!ew_CheckEmail($this->Mail->FormValue)) {
				ew_AddMessage($gsFormError, $this->Mail->FldErrMsg());
			}
		}
		if ($this->Id_Turno->MultiUpdate <> "" && !$this->Id_Turno->FldIsDetailKey && !is_null($this->Id_Turno->FormValue) && $this->Id_Turno->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Turno->FldCaption(), $this->Id_Turno->ReqErrMsg));
		}
		if ($this->Fecha_Ingreso->MultiUpdate <> "") {
			if (!ew_CheckDateDef($this->Fecha_Ingreso->FormValue)) {
				ew_AddMessage($gsFormError, $this->Fecha_Ingreso->FldErrMsg());
			}
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

			// Apellido_Nombre
			$this->Apellido_Nombre->SetDbValueDef($rsnew, $this->Apellido_Nombre->CurrentValue, NULL, $this->Apellido_Nombre->ReadOnly || $this->Apellido_Nombre->MultiUpdate <> "1");

			// DniRte
			// Domicilio

			$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, $this->Domicilio->ReadOnly || $this->Domicilio->MultiUpdate <> "1");

			// Telefono
			$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, NULL, $this->Telefono->ReadOnly || $this->Telefono->MultiUpdate <> "1");

			// Celular
			$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, $this->Celular->ReadOnly || $this->Celular->MultiUpdate <> "1");

			// Mail
			$this->Mail->SetDbValueDef($rsnew, $this->Mail->CurrentValue, NULL, $this->Mail->ReadOnly || $this->Mail->MultiUpdate <> "1");

			// Id_Turno
			$this->Id_Turno->SetDbValueDef($rsnew, $this->Id_Turno->CurrentValue, 0, $this->Id_Turno->ReadOnly || $this->Id_Turno->MultiUpdate <> "1");

			// Fecha_Ingreso
			$this->Fecha_Ingreso->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Ingreso->CurrentValue, 2), NULL, $this->Fecha_Ingreso->ReadOnly || $this->Fecha_Ingreso->MultiUpdate <> "1");

			// Titulo
			$this->Titulo->SetDbValueDef($rsnew, $this->Titulo->CurrentValue, NULL, $this->Titulo->ReadOnly || $this->Titulo->MultiUpdate <> "1");

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("referente_tecnicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
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
		$table = 'referente_tecnico';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'referente_tecnico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['DniRte'];

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
if (!isset($referente_tecnico_update)) $referente_tecnico_update = new creferente_tecnico_update();

// Page init
$referente_tecnico_update->Page_Init();

// Page main
$referente_tecnico_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = freferente_tecnicoupdate = new ew_Form("freferente_tecnicoupdate", "update");

// Validate form
freferente_tecnicoupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Apellido_Nombre");
			uelm = this.GetElements("u" + infix + "_Apellido_Nombre");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Apellido_Nombre->FldCaption(), $referente_tecnico->Apellido_Nombre->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_DniRte");
			uelm = this.GetElements("u" + infix + "_DniRte");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->DniRte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			uelm = this.GetElements("u" + infix + "_Telefono");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Telefono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Celular");
			uelm = this.GetElements("u" + infix + "_Celular");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Celular->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			uelm = this.GetElements("u" + infix + "_Mail");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Mail->FldCaption(), $referente_tecnico->Mail->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Mail");
			uelm = this.GetElements("u" + infix + "_Mail");
			if (uelm && uelm.checked && elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Mail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			uelm = this.GetElements("u" + infix + "_Id_Turno");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Id_Turno->FldCaption(), $referente_tecnico->Id_Turno->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Fecha_Ingreso");
			uelm = this.GetElements("u" + infix + "_Fecha_Ingreso");
			if (uelm && uelm.checked && elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Fecha_Ingreso->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
freferente_tecnicoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicoupdate.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicoupdate.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$referente_tecnico_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $referente_tecnico_update->ShowPageHeader(); ?>
<?php
$referente_tecnico_update->ShowMessage();
?>
<form name="freferente_tecnicoupdate" id="freferente_tecnicoupdate" class="<?php echo $referente_tecnico_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referente_tecnico_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referente_tecnico_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referente_tecnico">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($referente_tecnico_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($referente_tecnico_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_referente_tecnicoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<div id="r_Apellido_Nombre" class="form-group">
		<label for="x_Apellido_Nombre" class="col-sm-2 control-label">
<input type="checkbox" name="u_Apellido_Nombre" id="u_Apellido_Nombre" value="1"<?php echo ($referente_tecnico->Apellido_Nombre->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Apellido_Nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Apellido_Nombre->CellAttributes() ?>>
<span id="el_referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x_Apellido_Nombre" id="x_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Apellido_Nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="col-sm-2 control-label">
<input type="checkbox" name="u_Domicilio" id="u_Domicilio" value="1"<?php echo ($referente_tecnico->Domicilio->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Domicilio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Domicilio->CellAttributes() ?>>
<span id="el_referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Domicilio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
	<div id="r_Telefono" class="form-group">
		<label for="x_Telefono" class="col-sm-2 control-label">
<input type="checkbox" name="u_Telefono" id="u_Telefono" value="1"<?php echo ($referente_tecnico->Telefono->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Telefono->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Telefono->CellAttributes() ?>>
<span id="el_referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Telefono->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
	<div id="r_Celular" class="form-group">
		<label for="x_Celular" class="col-sm-2 control-label">
<input type="checkbox" name="u_Celular" id="u_Celular" value="1"<?php echo ($referente_tecnico->Celular->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Celular->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Celular->CellAttributes() ?>>
<span id="el_referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x_Celular" id="x_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Celular->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
	<div id="r_Mail" class="form-group">
		<label for="x_Mail" class="col-sm-2 control-label">
<input type="checkbox" name="u_Mail" id="u_Mail" value="1"<?php echo ($referente_tecnico->Mail->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Mail->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Mail->CellAttributes() ?>>
<span id="el_referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x_Mail" id="x_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Mail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label for="x_Id_Turno" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Turno" id="u_Id_Turno" value="1"<?php echo ($referente_tecnico->Id_Turno->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Id_Turno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Id_Turno->CellAttributes() ?>>
<span id="el_referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php echo $referente_tecnico->Id_Turno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
	<div id="r_Fecha_Ingreso" class="form-group">
		<label for="x_Fecha_Ingreso" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Ingreso" id="u_Fecha_Ingreso" value="1"<?php echo ($referente_tecnico->Fecha_Ingreso->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Fecha_Ingreso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Fecha_Ingreso->CellAttributes() ?>>
<span id="el_referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x_Fecha_Ingreso" id="x_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicoupdate", "x_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
<?php echo $referente_tecnico->Fecha_Ingreso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
	<div id="r_Titulo" class="form-group">
		<label for="x_Titulo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Titulo" id="u_Titulo" value="1"<?php echo ($referente_tecnico->Titulo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Titulo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Titulo->CellAttributes() ?>>
<span id="el_referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x_Titulo" id="x_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
<?php echo $referente_tecnico->Titulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Actualizacion" id="u_Fecha_Actualizacion" value="1"<?php echo ($referente_tecnico->Fecha_Actualizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $referente_tecnico->Fecha_Actualizacion->CellAttributes() ?>>
<?php echo $referente_tecnico->Fecha_Actualizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$referente_tecnico_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $referente_tecnico_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
freferente_tecnicoupdate.Init();
</script>
<?php
$referente_tecnico_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$referente_tecnico_update->Page_Terminate();
?>
