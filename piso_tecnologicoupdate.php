<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "piso_tecnologicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$piso_tecnologico_update = NULL; // Initialize page object first

class cpiso_tecnologico_update extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_update';

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

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
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
			define("EW_TABLE_NAME", 'piso_tecnologico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("piso_tecnologicolist.php"));
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
		$this->Switch->SetVisibility();
		$this->Bocas_Switch->SetVisibility();
		$this->Estado_Switch->SetVisibility();
		$this->Cantidad_Ap->SetVisibility();
		$this->Cantidad_Ap_Func->SetVisibility();
		$this->Ups->SetVisibility();
		$this->Estado_Ups->SetVisibility();
		$this->Marca_Modelo_Serie_Ups->SetVisibility();
		$this->Cableado->SetVisibility();
		$this->Estado_Cableado->SetVisibility();
		$this->Porcent_Estado_Cab->SetVisibility();
		$this->Porcent_Func_Piso->SetVisibility();
		$this->Plano_Escuela->SetVisibility();
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
			$this->Page_Terminate("piso_tecnologicolist.php"); // No records selected, return to list
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
					$this->Switch->setDbValue($this->Recordset->fields('Switch'));
					$this->Bocas_Switch->setDbValue($this->Recordset->fields('Bocas_Switch'));
					$this->Estado_Switch->setDbValue($this->Recordset->fields('Estado_Switch'));
					$this->Cantidad_Ap->setDbValue($this->Recordset->fields('Cantidad_Ap'));
					$this->Cantidad_Ap_Func->setDbValue($this->Recordset->fields('Cantidad_Ap_Func'));
					$this->Ups->setDbValue($this->Recordset->fields('Ups'));
					$this->Estado_Ups->setDbValue($this->Recordset->fields('Estado_Ups'));
					$this->Marca_Modelo_Serie_Ups->setDbValue($this->Recordset->fields('Marca_Modelo_Serie_Ups'));
					$this->Cableado->setDbValue($this->Recordset->fields('Cableado'));
					$this->Estado_Cableado->setDbValue($this->Recordset->fields('Estado_Cableado'));
					$this->Porcent_Estado_Cab->setDbValue($this->Recordset->fields('Porcent_Estado_Cab'));
					$this->Porcent_Func_Piso->setDbValue($this->Recordset->fields('Porcent_Func_Piso'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
				} else {
					if (!ew_CompareValue($this->Switch->DbValue, $this->Recordset->fields('Switch')))
						$this->Switch->CurrentValue = NULL;
					if (!ew_CompareValue($this->Bocas_Switch->DbValue, $this->Recordset->fields('Bocas_Switch')))
						$this->Bocas_Switch->CurrentValue = NULL;
					if (!ew_CompareValue($this->Estado_Switch->DbValue, $this->Recordset->fields('Estado_Switch')))
						$this->Estado_Switch->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Ap->DbValue, $this->Recordset->fields('Cantidad_Ap')))
						$this->Cantidad_Ap->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Ap_Func->DbValue, $this->Recordset->fields('Cantidad_Ap_Func')))
						$this->Cantidad_Ap_Func->CurrentValue = NULL;
					if (!ew_CompareValue($this->Ups->DbValue, $this->Recordset->fields('Ups')))
						$this->Ups->CurrentValue = NULL;
					if (!ew_CompareValue($this->Estado_Ups->DbValue, $this->Recordset->fields('Estado_Ups')))
						$this->Estado_Ups->CurrentValue = NULL;
					if (!ew_CompareValue($this->Marca_Modelo_Serie_Ups->DbValue, $this->Recordset->fields('Marca_Modelo_Serie_Ups')))
						$this->Marca_Modelo_Serie_Ups->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cableado->DbValue, $this->Recordset->fields('Cableado')))
						$this->Cableado->CurrentValue = NULL;
					if (!ew_CompareValue($this->Estado_Cableado->DbValue, $this->Recordset->fields('Estado_Cableado')))
						$this->Estado_Cableado->CurrentValue = NULL;
					if (!ew_CompareValue($this->Porcent_Estado_Cab->DbValue, $this->Recordset->fields('Porcent_Estado_Cab')))
						$this->Porcent_Estado_Cab->CurrentValue = NULL;
					if (!ew_CompareValue($this->Porcent_Func_Piso->DbValue, $this->Recordset->fields('Porcent_Func_Piso')))
						$this->Porcent_Func_Piso->CurrentValue = NULL;
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
		$this->Plano_Escuela->Upload->Index = $objForm->Index;
		$this->Plano_Escuela->Upload->UploadFile();
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->FileName;
		$this->Plano_Escuela->MultiUpdate = $objForm->GetValue("u_Plano_Escuela");
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Switch->FldIsDetailKey) {
			$this->Switch->setFormValue($objForm->GetValue("x_Switch"));
		}
		$this->Switch->MultiUpdate = $objForm->GetValue("u_Switch");
		if (!$this->Bocas_Switch->FldIsDetailKey) {
			$this->Bocas_Switch->setFormValue($objForm->GetValue("x_Bocas_Switch"));
		}
		$this->Bocas_Switch->MultiUpdate = $objForm->GetValue("u_Bocas_Switch");
		if (!$this->Estado_Switch->FldIsDetailKey) {
			$this->Estado_Switch->setFormValue($objForm->GetValue("x_Estado_Switch"));
		}
		$this->Estado_Switch->MultiUpdate = $objForm->GetValue("u_Estado_Switch");
		if (!$this->Cantidad_Ap->FldIsDetailKey) {
			$this->Cantidad_Ap->setFormValue($objForm->GetValue("x_Cantidad_Ap"));
		}
		$this->Cantidad_Ap->MultiUpdate = $objForm->GetValue("u_Cantidad_Ap");
		if (!$this->Cantidad_Ap_Func->FldIsDetailKey) {
			$this->Cantidad_Ap_Func->setFormValue($objForm->GetValue("x_Cantidad_Ap_Func"));
		}
		$this->Cantidad_Ap_Func->MultiUpdate = $objForm->GetValue("u_Cantidad_Ap_Func");
		if (!$this->Ups->FldIsDetailKey) {
			$this->Ups->setFormValue($objForm->GetValue("x_Ups"));
		}
		$this->Ups->MultiUpdate = $objForm->GetValue("u_Ups");
		if (!$this->Estado_Ups->FldIsDetailKey) {
			$this->Estado_Ups->setFormValue($objForm->GetValue("x_Estado_Ups"));
		}
		$this->Estado_Ups->MultiUpdate = $objForm->GetValue("u_Estado_Ups");
		if (!$this->Marca_Modelo_Serie_Ups->FldIsDetailKey) {
			$this->Marca_Modelo_Serie_Ups->setFormValue($objForm->GetValue("x_Marca_Modelo_Serie_Ups"));
		}
		$this->Marca_Modelo_Serie_Ups->MultiUpdate = $objForm->GetValue("u_Marca_Modelo_Serie_Ups");
		if (!$this->Cableado->FldIsDetailKey) {
			$this->Cableado->setFormValue($objForm->GetValue("x_Cableado"));
		}
		$this->Cableado->MultiUpdate = $objForm->GetValue("u_Cableado");
		if (!$this->Estado_Cableado->FldIsDetailKey) {
			$this->Estado_Cableado->setFormValue($objForm->GetValue("x_Estado_Cableado"));
		}
		$this->Estado_Cableado->MultiUpdate = $objForm->GetValue("u_Estado_Cableado");
		if (!$this->Porcent_Estado_Cab->FldIsDetailKey) {
			$this->Porcent_Estado_Cab->setFormValue($objForm->GetValue("x_Porcent_Estado_Cab"));
		}
		$this->Porcent_Estado_Cab->MultiUpdate = $objForm->GetValue("u_Porcent_Estado_Cab");
		if (!$this->Porcent_Func_Piso->FldIsDetailKey) {
			$this->Porcent_Func_Piso->setFormValue($objForm->GetValue("x_Porcent_Func_Piso"));
		}
		$this->Porcent_Func_Piso->MultiUpdate = $objForm->GetValue("u_Porcent_Func_Piso");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
		if (!$this->Cue->FldIsDetailKey)
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Switch->CurrentValue = $this->Switch->FormValue;
		$this->Bocas_Switch->CurrentValue = $this->Bocas_Switch->FormValue;
		$this->Estado_Switch->CurrentValue = $this->Estado_Switch->FormValue;
		$this->Cantidad_Ap->CurrentValue = $this->Cantidad_Ap->FormValue;
		$this->Cantidad_Ap_Func->CurrentValue = $this->Cantidad_Ap_Func->FormValue;
		$this->Ups->CurrentValue = $this->Ups->FormValue;
		$this->Estado_Ups->CurrentValue = $this->Estado_Ups->FormValue;
		$this->Marca_Modelo_Serie_Ups->CurrentValue = $this->Marca_Modelo_Serie_Ups->FormValue;
		$this->Cableado->CurrentValue = $this->Cableado->FormValue;
		$this->Estado_Cableado->CurrentValue = $this->Estado_Cableado->FormValue;
		$this->Porcent_Estado_Cab->CurrentValue = $this->Porcent_Estado_Cab->FormValue;
		$this->Porcent_Func_Piso->CurrentValue = $this->Porcent_Func_Piso->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Switch->setDbValue($rs->fields('Switch'));
		$this->Bocas_Switch->setDbValue($rs->fields('Bocas_Switch'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado_Switch'));
		$this->Cantidad_Ap->setDbValue($rs->fields('Cantidad_Ap'));
		$this->Cantidad_Ap_Func->setDbValue($rs->fields('Cantidad_Ap_Func'));
		$this->Ups->setDbValue($rs->fields('Ups'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado_Ups'));
		$this->Marca_Modelo_Serie_Ups->setDbValue($rs->fields('Marca_Modelo_Serie_Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado_Cableado'));
		$this->Porcent_Estado_Cab->setDbValue($rs->fields('Porcent_Estado_Cab'));
		$this->Porcent_Func_Piso->setDbValue($rs->fields('Porcent_Func_Piso'));
		$this->Plano_Escuela->Upload->DbValue = $rs->fields('Plano_Escuela');
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Switch->DbValue = $row['Switch'];
		$this->Bocas_Switch->DbValue = $row['Bocas_Switch'];
		$this->Estado_Switch->DbValue = $row['Estado_Switch'];
		$this->Cantidad_Ap->DbValue = $row['Cantidad_Ap'];
		$this->Cantidad_Ap_Func->DbValue = $row['Cantidad_Ap_Func'];
		$this->Ups->DbValue = $row['Ups'];
		$this->Estado_Ups->DbValue = $row['Estado_Ups'];
		$this->Marca_Modelo_Serie_Ups->DbValue = $row['Marca_Modelo_Serie_Ups'];
		$this->Cableado->DbValue = $row['Cableado'];
		$this->Estado_Cableado->DbValue = $row['Estado_Cableado'];
		$this->Porcent_Estado_Cab->DbValue = $row['Porcent_Estado_Cab'];
		$this->Porcent_Func_Piso->DbValue = $row['Porcent_Func_Piso'];
		$this->Plano_Escuela->Upload->DbValue = $row['Plano_Escuela'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
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
		// Switch
		// Bocas_Switch
		// Estado_Switch
		// Cantidad_Ap
		// Cantidad_Ap_Func
		// Ups
		// Estado_Ups
		// Marca_Modelo_Serie_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Porcent_Func_Piso
		// Plano_Escuela
		// Fecha_Actualizacion
		// Usuario
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Bocas_Switch
		$this->Bocas_Switch->ViewValue = $this->Bocas_Switch->CurrentValue;
		$this->Bocas_Switch->ViewCustomAttributes = "";

		// Estado_Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->ViewValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Cantidad_Ap_Func->ViewCustomAttributes = "";

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

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->ViewValue = $this->Marca_Modelo_Serie_Ups->CurrentValue;
		$this->Marca_Modelo_Serie_Ups->ViewCustomAttributes = "";

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

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Plano_Escuela
		if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
			$this->Plano_Escuela->ViewValue = $this->Plano_Escuela->Upload->DbValue;
		} else {
			$this->Plano_Escuela->ViewValue = "";
		}
		$this->Plano_Escuela->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Switch
			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";
			$this->Switch->TooltipValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";
			$this->Bocas_Switch->TooltipValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";
			$this->Estado_Switch->TooltipValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";
			$this->Cantidad_Ap->TooltipValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";
			$this->Cantidad_Ap_Func->TooltipValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";
			$this->Ups->TooltipValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";
			$this->Estado_Ups->TooltipValue = "";

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->HrefValue = "";
			$this->Marca_Modelo_Serie_Ups->TooltipValue = "";

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

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";
			$this->Porcent_Func_Piso->TooltipValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;
			$this->Plano_Escuela->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Switch
			$this->Switch->EditCustomAttributes = "";
			$this->Switch->EditValue = $this->Switch->Options(FALSE);

			// Bocas_Switch
			$this->Bocas_Switch->EditAttrs["class"] = "form-control";
			$this->Bocas_Switch->EditCustomAttributes = "";
			$this->Bocas_Switch->EditValue = ew_HtmlEncode($this->Bocas_Switch->CurrentValue);
			$this->Bocas_Switch->PlaceHolder = ew_RemoveHtml($this->Bocas_Switch->FldCaption());

			// Estado_Switch
			$this->Estado_Switch->EditAttrs["class"] = "form-control";
			$this->Estado_Switch->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Switch->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Switch->EditValue = $arwrk;

			// Cantidad_Ap
			$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap->EditCustomAttributes = "";
			$this->Cantidad_Ap->EditValue = ew_HtmlEncode($this->Cantidad_Ap->CurrentValue);
			$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap_Func->EditCustomAttributes = "";
			$this->Cantidad_Ap_Func->EditValue = ew_HtmlEncode($this->Cantidad_Ap_Func->CurrentValue);
			$this->Cantidad_Ap_Func->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap_Func->FldCaption());

			// Ups
			$this->Ups->EditCustomAttributes = "";
			$this->Ups->EditValue = $this->Ups->Options(FALSE);

			// Estado_Ups
			$this->Estado_Ups->EditAttrs["class"] = "form-control";
			$this->Estado_Ups->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ups->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ups->EditValue = $arwrk;

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->EditAttrs["class"] = "form-control";
			$this->Marca_Modelo_Serie_Ups->EditCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->EditValue = ew_HtmlEncode($this->Marca_Modelo_Serie_Ups->CurrentValue);
			$this->Marca_Modelo_Serie_Ups->PlaceHolder = ew_RemoveHtml($this->Marca_Modelo_Serie_Ups->FldCaption());

			// Cableado
			$this->Cableado->EditCustomAttributes = "";
			$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

			// Estado_Cableado
			$this->Estado_Cableado->EditAttrs["class"] = "form-control";
			$this->Estado_Cableado->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Cableado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Cableado->EditValue = $arwrk;

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Cab->EditCustomAttributes = "";
			$this->Porcent_Estado_Cab->EditValue = ew_HtmlEncode($this->Porcent_Estado_Cab->CurrentValue);
			$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
			$this->Porcent_Func_Piso->EditCustomAttributes = "";
			$this->Porcent_Func_Piso->EditValue = ew_HtmlEncode($this->Porcent_Func_Piso->CurrentValue);
			$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());

			// Plano_Escuela
			$this->Plano_Escuela->EditAttrs["class"] = "form-control";
			$this->Plano_Escuela->EditCustomAttributes = "";
			if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
				$this->Plano_Escuela->EditValue = $this->Plano_Escuela->Upload->DbValue;
			} else {
				$this->Plano_Escuela->EditValue = "";
			}
			if (!ew_Empty($this->Plano_Escuela->CurrentValue))
				$this->Plano_Escuela->Upload->FileName = $this->Plano_Escuela->CurrentValue;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Switch

			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->LinkCustomAttributes = "";
			$this->Marca_Modelo_Serie_Ups->HrefValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;

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
		if ($this->Switch->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Bocas_Switch->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Estado_Switch->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Ap->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Ap_Func->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Ups->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Estado_Ups->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Marca_Modelo_Serie_Ups->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cableado->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Estado_Cableado->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Porcent_Estado_Cab->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Porcent_Func_Piso->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Plano_Escuela->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Switch->MultiUpdate <> "" && $this->Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Switch->FldCaption(), $this->Switch->ReqErrMsg));
		}
		if ($this->Bocas_Switch->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Bocas_Switch->FormValue)) {
				ew_AddMessage($gsFormError, $this->Bocas_Switch->FldErrMsg());
			}
		}
		if ($this->Estado_Switch->MultiUpdate <> "" && !$this->Estado_Switch->FldIsDetailKey && !is_null($this->Estado_Switch->FormValue) && $this->Estado_Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Switch->FldCaption(), $this->Estado_Switch->ReqErrMsg));
		}
		if ($this->Cantidad_Ap->MultiUpdate <> "" && !$this->Cantidad_Ap->FldIsDetailKey && !is_null($this->Cantidad_Ap->FormValue) && $this->Cantidad_Ap->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cantidad_Ap->FldCaption(), $this->Cantidad_Ap->ReqErrMsg));
		}
		if ($this->Cantidad_Ap->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Ap->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Ap->FldErrMsg());
			}
		}
		if ($this->Cantidad_Ap_Func->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Ap_Func->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Ap_Func->FldErrMsg());
			}
		}
		if ($this->Ups->MultiUpdate <> "" && $this->Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Ups->FldCaption(), $this->Ups->ReqErrMsg));
		}
		if ($this->Estado_Ups->MultiUpdate <> "" && !$this->Estado_Ups->FldIsDetailKey && !is_null($this->Estado_Ups->FormValue) && $this->Estado_Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Ups->FldCaption(), $this->Estado_Ups->ReqErrMsg));
		}
		if ($this->Cableado->MultiUpdate <> "" && $this->Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cableado->FldCaption(), $this->Cableado->ReqErrMsg));
		}
		if ($this->Estado_Cableado->MultiUpdate <> "" && !$this->Estado_Cableado->FldIsDetailKey && !is_null($this->Estado_Cableado->FormValue) && $this->Estado_Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Cableado->FldCaption(), $this->Estado_Cableado->ReqErrMsg));
		}
		if ($this->Porcent_Estado_Cab->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Porcent_Estado_Cab->FormValue)) {
				ew_AddMessage($gsFormError, $this->Porcent_Estado_Cab->FldErrMsg());
			}
		}
		if ($this->Porcent_Func_Piso->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Porcent_Func_Piso->FormValue)) {
				ew_AddMessage($gsFormError, $this->Porcent_Func_Piso->FldErrMsg());
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

			// Switch
			$this->Switch->SetDbValueDef($rsnew, $this->Switch->CurrentValue, NULL, $this->Switch->ReadOnly || $this->Switch->MultiUpdate <> "1");

			// Bocas_Switch
			$this->Bocas_Switch->SetDbValueDef($rsnew, $this->Bocas_Switch->CurrentValue, NULL, $this->Bocas_Switch->ReadOnly || $this->Bocas_Switch->MultiUpdate <> "1");

			// Estado_Switch
			$this->Estado_Switch->SetDbValueDef($rsnew, $this->Estado_Switch->CurrentValue, NULL, $this->Estado_Switch->ReadOnly || $this->Estado_Switch->MultiUpdate <> "1");

			// Cantidad_Ap
			$this->Cantidad_Ap->SetDbValueDef($rsnew, $this->Cantidad_Ap->CurrentValue, NULL, $this->Cantidad_Ap->ReadOnly || $this->Cantidad_Ap->MultiUpdate <> "1");

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->SetDbValueDef($rsnew, $this->Cantidad_Ap_Func->CurrentValue, NULL, $this->Cantidad_Ap_Func->ReadOnly || $this->Cantidad_Ap_Func->MultiUpdate <> "1");

			// Ups
			$this->Ups->SetDbValueDef($rsnew, $this->Ups->CurrentValue, NULL, $this->Ups->ReadOnly || $this->Ups->MultiUpdate <> "1");

			// Estado_Ups
			$this->Estado_Ups->SetDbValueDef($rsnew, $this->Estado_Ups->CurrentValue, NULL, $this->Estado_Ups->ReadOnly || $this->Estado_Ups->MultiUpdate <> "1");

			// Marca_Modelo_Serie_Ups
			$this->Marca_Modelo_Serie_Ups->SetDbValueDef($rsnew, $this->Marca_Modelo_Serie_Ups->CurrentValue, NULL, $this->Marca_Modelo_Serie_Ups->ReadOnly || $this->Marca_Modelo_Serie_Ups->MultiUpdate <> "1");

			// Cableado
			$this->Cableado->SetDbValueDef($rsnew, $this->Cableado->CurrentValue, NULL, $this->Cableado->ReadOnly || $this->Cableado->MultiUpdate <> "1");

			// Estado_Cableado
			$this->Estado_Cableado->SetDbValueDef($rsnew, $this->Estado_Cableado->CurrentValue, NULL, $this->Estado_Cableado->ReadOnly || $this->Estado_Cableado->MultiUpdate <> "1");

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->SetDbValueDef($rsnew, $this->Porcent_Estado_Cab->CurrentValue, NULL, $this->Porcent_Estado_Cab->ReadOnly || $this->Porcent_Estado_Cab->MultiUpdate <> "1");

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->SetDbValueDef($rsnew, $this->Porcent_Func_Piso->CurrentValue, NULL, $this->Porcent_Func_Piso->ReadOnly || $this->Porcent_Func_Piso->MultiUpdate <> "1");

			// Plano_Escuela
			if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->ReadOnly && strval($this->Plano_Escuela->MultiUpdate) == "1" && !$this->Plano_Escuela->Upload->KeepFile) {
				$this->Plano_Escuela->Upload->DbValue = $rsold['Plano_Escuela']; // Get original value
				if ($this->Plano_Escuela->Upload->FileName == "") {
					$rsnew['Plano_Escuela'] = NULL;
				} else {
					$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
				}
			}

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;
			if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
				if (!ew_Empty($this->Plano_Escuela->Upload->FileName) && $this->UpdateCount == 1) {
					$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
					$FileCount = count($NewFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file)) {
								if (!in_array($file, $OldFiles)) {
									$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file); // Get new file name
									if ($file1 <> $file) { // Rename temp file
										while (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
											$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file1, TRUE); // Use indexed name
										rename(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1);
										$NewFiles[$i] = $file1;
									}
								}
							}
						}
					}
					$this->Plano_Escuela->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
				} else {
					$NewFiles = array();
				}
			}

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
					if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
						$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
						if (!ew_Empty($this->Plano_Escuela->Upload->FileName) && $this->UpdateCount == 1) {
							$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
							$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Plano_Escuela']);
							$FileCount = count($NewFiles);
							for ($i = 0; $i < $FileCount; $i++) {
								$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
									if (file_exists($file)) {
										$this->Plano_Escuela->Upload->SaveToFile($this->Plano_Escuela->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$FileCount = count($OldFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
						}
					}
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

		// Plano_Escuela
		ew_CleanUploadTempPath($this->Plano_Escuela, $this->Plano_Escuela->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("piso_tecnologicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Estado_Switch":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Ups":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Cableado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
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
		$table = 'piso_tecnologico';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'piso_tecnologico';

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
if (!isset($piso_tecnologico_update)) $piso_tecnologico_update = new cpiso_tecnologico_update();

// Page init
$piso_tecnologico_update->Page_Init();

// Page main
$piso_tecnologico_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fpiso_tecnologicoupdate = new ew_Form("fpiso_tecnologicoupdate", "update");

// Validate form
fpiso_tecnologicoupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Switch");
			uelm = this.GetElements("u" + infix + "_Switch");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Switch->FldCaption(), $piso_tecnologico->Switch->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Bocas_Switch");
			uelm = this.GetElements("u" + infix + "_Bocas_Switch");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Bocas_Switch->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Switch");
			uelm = this.GetElements("u" + infix + "_Estado_Switch");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Switch->FldCaption(), $piso_tecnologico->Estado_Switch->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			uelm = this.GetElements("u" + infix + "_Cantidad_Ap");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cantidad_Ap->FldCaption(), $piso_tecnologico->Cantidad_Ap->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			uelm = this.GetElements("u" + infix + "_Cantidad_Ap");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap_Func");
			uelm = this.GetElements("u" + infix + "_Cantidad_Ap_Func");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap_Func->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Ups");
			uelm = this.GetElements("u" + infix + "_Ups");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Ups->FldCaption(), $piso_tecnologico->Ups->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Estado_Ups");
			uelm = this.GetElements("u" + infix + "_Estado_Ups");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Ups->FldCaption(), $piso_tecnologico->Estado_Ups->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Cableado");
			uelm = this.GetElements("u" + infix + "_Cableado");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cableado->FldCaption(), $piso_tecnologico->Cableado->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Estado_Cableado");
			uelm = this.GetElements("u" + infix + "_Estado_Cableado");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Cableado->FldCaption(), $piso_tecnologico->Estado_Cableado->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Porcent_Estado_Cab");
			uelm = this.GetElements("u" + infix + "_Porcent_Estado_Cab");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Cab->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Func_Piso");
			uelm = this.GetElements("u" + infix + "_Porcent_Func_Piso");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Func_Piso->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpiso_tecnologicoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicoupdate.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicoupdate.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoupdate.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicoupdate.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoupdate.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoupdate.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicoupdate.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicoupdate.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicoupdate.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicoupdate.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$piso_tecnologico_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $piso_tecnologico_update->ShowPageHeader(); ?>
<?php
$piso_tecnologico_update->ShowMessage();
?>
<form name="fpiso_tecnologicoupdate" id="fpiso_tecnologicoupdate" class="<?php echo $piso_tecnologico_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($piso_tecnologico_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($piso_tecnologico_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_piso_tecnologicoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<div id="r_Switch" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Switch" id="u_Switch" value="1"<?php echo ($piso_tecnologico->Switch->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Switch->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Switch">
<div id="tp_x_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x_Switch" id="x_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x_Switch") ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
	<div id="r_Bocas_Switch" class="form-group">
		<label for="x_Bocas_Switch" class="col-sm-2 control-label">
<input type="checkbox" name="u_Bocas_Switch" id="u_Bocas_Switch" value="1"<?php echo ($piso_tecnologico->Bocas_Switch->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Bocas_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x_Bocas_Switch" id="x_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Bocas_Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<div id="r_Estado_Switch" class="form-group">
		<label for="x_Estado_Switch" class="col-sm-2 control-label">
<input type="checkbox" name="u_Estado_Switch" id="u_Estado_Switch" value="1"<?php echo ($piso_tecnologico->Estado_Switch->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Switch" name="x_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x_Estado_Switch" id="s_x_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Switch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<div id="r_Cantidad_Ap" class="form-group">
		<label for="x_Cantidad_Ap" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Ap" id="u_Cantidad_Ap" value="1"<?php echo ($piso_tecnologico->Cantidad_Ap->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x_Cantidad_Ap" id="x_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Cantidad_Ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
	<div id="r_Cantidad_Ap_Func" class="form-group">
		<label for="x_Cantidad_Ap_Func" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Ap_Func" id="u_Cantidad_Ap_Func" value="1"<?php echo ($piso_tecnologico->Cantidad_Ap_Func->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cantidad_Ap_Func->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x_Cantidad_Ap_Func" id="x_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Cantidad_Ap_Func->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<div id="r_Ups" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Ups" id="u_Ups" value="1"<?php echo ($piso_tecnologico->Ups->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Ups->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Ups">
<div id="tp_x_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x_Ups" id="x_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x_Ups") ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<div id="r_Estado_Ups" class="form-group">
		<label for="x_Estado_Ups" class="col-sm-2 control-label">
<input type="checkbox" name="u_Estado_Ups" id="u_Estado_Ups" value="1"<?php echo ($piso_tecnologico->Estado_Ups->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Ups" name="x_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x_Estado_Ups" id="s_x_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Marca_Modelo_Serie_Ups->Visible) { // Marca_Modelo_Serie_Ups ?>
	<div id="r_Marca_Modelo_Serie_Ups" class="form-group">
		<label for="x_Marca_Modelo_Serie_Ups" class="col-sm-2 control-label">
<input type="checkbox" name="u_Marca_Modelo_Serie_Ups" id="u_Marca_Modelo_Serie_Ups" value="1"<?php echo ($piso_tecnologico->Marca_Modelo_Serie_Ups->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->CellAttributes() ?>>
<span id="el_piso_tecnologico_Marca_Modelo_Serie_Ups">
<input type="text" data-table="piso_tecnologico" data-field="x_Marca_Modelo_Serie_Ups" name="x_Marca_Modelo_Serie_Ups" id="x_Marca_Modelo_Serie_Ups" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Marca_Modelo_Serie_Ups->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->EditValue ?>"<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Marca_Modelo_Serie_Ups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<div id="r_Cableado" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Cableado" id="u_Cableado" value="1"<?php echo ($piso_tecnologico->Cableado->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Cableado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Cableado">
<div id="tp_x_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x_Cableado" id="x_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x_Cableado") ?>
</div></div>
</span>
<?php echo $piso_tecnologico->Cableado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<div id="r_Estado_Cableado" class="form-group">
		<label for="x_Estado_Cableado" class="col-sm-2 control-label">
<input type="checkbox" name="u_Estado_Cableado" id="u_Estado_Cableado" value="1"<?php echo ($piso_tecnologico->Estado_Cableado->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<span id="el_piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Cableado" name="x_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x_Estado_Cableado" id="s_x_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<?php echo $piso_tecnologico->Estado_Cableado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<div id="r_Porcent_Estado_Cab" class="form-group">
		<label for="x_Porcent_Estado_Cab" class="col-sm-2 control-label">
<input type="checkbox" name="u_Porcent_Estado_Cab" id="u_Porcent_Estado_Cab" value="1"<?php echo ($piso_tecnologico->Porcent_Estado_Cab->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x_Porcent_Estado_Cab" id="x_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<div id="r_Porcent_Func_Piso" class="form-group">
		<label for="x_Porcent_Func_Piso" class="col-sm-2 control-label">
<input type="checkbox" name="u_Porcent_Func_Piso" id="u_Porcent_Func_Piso" value="1"<?php echo ($piso_tecnologico->Porcent_Func_Piso->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<span id="el_piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x_Porcent_Func_Piso" id="x_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<?php echo $piso_tecnologico->Porcent_Func_Piso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<div id="r_Plano_Escuela" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Plano_Escuela" id="u_Plano_Escuela" value="1"<?php echo ($piso_tecnologico->Plano_Escuela->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<span id="el_piso_tecnologico_Plano_Escuela">
<div id="fd_x_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x_Plano_Escuela" id="x_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Plano_Escuela" id= "fn_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<?php if (@$_POST["fa_x_Plano_Escuela"] == "0") { ?>
<input type="hidden" name="fa_x_Plano_Escuela" id= "fa_x_Plano_Escuela" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_Plano_Escuela" id= "fa_x_Plano_Escuela" value="1">
<?php } ?>
<input type="hidden" name="fs_x_Plano_Escuela" id= "fs_x_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x_Plano_Escuela" id= "fx_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Plano_Escuela" id= "fm_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Plano_Escuela" id= "fc_x_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $piso_tecnologico->Plano_Escuela->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$piso_tecnologico_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $piso_tecnologico_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fpiso_tecnologicoupdate.Init();
</script>
<?php
$piso_tecnologico_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_update->Page_Terminate();
?>
