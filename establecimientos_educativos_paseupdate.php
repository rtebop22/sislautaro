<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "establecimientos_educativos_paseinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$establecimientos_educativos_pase_update = NULL; // Initialize page object first

class cestablecimientos_educativos_pase_update extends cestablecimientos_educativos_pase {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'establecimientos_educativos_pase';

	// Page object name
	var $PageObjName = 'establecimientos_educativos_pase_update';

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

		// Table object (establecimientos_educativos_pase)
		if (!isset($GLOBALS["establecimientos_educativos_pase"]) || get_class($GLOBALS["establecimientos_educativos_pase"]) == "cestablecimientos_educativos_pase") {
			$GLOBALS["establecimientos_educativos_pase"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["establecimientos_educativos_pase"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'establecimientos_educativos_pase', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("establecimientos_educativos_paselist.php"));
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
		$this->Cue_Establecimiento->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Nombre_Directivo->SetVisibility();
		$this->Cuil_Directivo->SetVisibility();
		$this->Nombre_Rte->SetVisibility();
		$this->Tel_Rte->SetVisibility();
		$this->Email_Rte->SetVisibility();
		$this->Nro_Serie_Server_Escolar->SetVisibility();
		$this->Contacto_Establecimiento->SetVisibility();
		$this->Domicilio_Escuela->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
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
		global $EW_EXPORT, $establecimientos_educativos_pase;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($establecimientos_educativos_pase);
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
			$this->Page_Terminate("establecimientos_educativos_paselist.php"); // No records selected, return to list
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
					$this->Cue_Establecimiento->setDbValue($this->Recordset->fields('Cue_Establecimiento'));
					$this->Nombre_Establecimiento->setDbValue($this->Recordset->fields('Nombre_Establecimiento'));
					$this->Nombre_Directivo->setDbValue($this->Recordset->fields('Nombre_Directivo'));
					$this->Cuil_Directivo->setDbValue($this->Recordset->fields('Cuil_Directivo'));
					$this->Nombre_Rte->setDbValue($this->Recordset->fields('Nombre_Rte'));
					$this->Tel_Rte->setDbValue($this->Recordset->fields('Tel_Rte'));
					$this->Email_Rte->setDbValue($this->Recordset->fields('Email_Rte'));
					$this->Nro_Serie_Server_Escolar->setDbValue($this->Recordset->fields('Nro_Serie_Server_Escolar'));
					$this->Contacto_Establecimiento->setDbValue($this->Recordset->fields('Contacto_Establecimiento'));
					$this->Domicilio_Escuela->setDbValue($this->Recordset->fields('Domicilio_Escuela'));
					$this->Id_Provincia->setDbValue($this->Recordset->fields('Id_Provincia'));
					$this->Id_Departamento->setDbValue($this->Recordset->fields('Id_Departamento'));
					$this->Id_Localidad->setDbValue($this->Recordset->fields('Id_Localidad'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
				} else {
					if (!ew_CompareValue($this->Cue_Establecimiento->DbValue, $this->Recordset->fields('Cue_Establecimiento')))
						$this->Cue_Establecimiento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nombre_Establecimiento->DbValue, $this->Recordset->fields('Nombre_Establecimiento')))
						$this->Nombre_Establecimiento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nombre_Directivo->DbValue, $this->Recordset->fields('Nombre_Directivo')))
						$this->Nombre_Directivo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cuil_Directivo->DbValue, $this->Recordset->fields('Cuil_Directivo')))
						$this->Cuil_Directivo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nombre_Rte->DbValue, $this->Recordset->fields('Nombre_Rte')))
						$this->Nombre_Rte->CurrentValue = NULL;
					if (!ew_CompareValue($this->Tel_Rte->DbValue, $this->Recordset->fields('Tel_Rte')))
						$this->Tel_Rte->CurrentValue = NULL;
					if (!ew_CompareValue($this->Email_Rte->DbValue, $this->Recordset->fields('Email_Rte')))
						$this->Email_Rte->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nro_Serie_Server_Escolar->DbValue, $this->Recordset->fields('Nro_Serie_Server_Escolar')))
						$this->Nro_Serie_Server_Escolar->CurrentValue = NULL;
					if (!ew_CompareValue($this->Contacto_Establecimiento->DbValue, $this->Recordset->fields('Contacto_Establecimiento')))
						$this->Contacto_Establecimiento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Domicilio_Escuela->DbValue, $this->Recordset->fields('Domicilio_Escuela')))
						$this->Domicilio_Escuela->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Provincia->DbValue, $this->Recordset->fields('Id_Provincia')))
						$this->Id_Provincia->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Departamento->DbValue, $this->Recordset->fields('Id_Departamento')))
						$this->Id_Departamento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Localidad->DbValue, $this->Recordset->fields('Id_Localidad')))
						$this->Id_Localidad->CurrentValue = NULL;
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
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Cue_Establecimiento->CurrentValue = $sKeyFld;
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
		if (!$this->Cue_Establecimiento->FldIsDetailKey) {
			$this->Cue_Establecimiento->setFormValue($objForm->GetValue("x_Cue_Establecimiento"));
		}
		$this->Cue_Establecimiento->MultiUpdate = $objForm->GetValue("u_Cue_Establecimiento");
		if (!$this->Nombre_Establecimiento->FldIsDetailKey) {
			$this->Nombre_Establecimiento->setFormValue($objForm->GetValue("x_Nombre_Establecimiento"));
		}
		$this->Nombre_Establecimiento->MultiUpdate = $objForm->GetValue("u_Nombre_Establecimiento");
		if (!$this->Nombre_Directivo->FldIsDetailKey) {
			$this->Nombre_Directivo->setFormValue($objForm->GetValue("x_Nombre_Directivo"));
		}
		$this->Nombre_Directivo->MultiUpdate = $objForm->GetValue("u_Nombre_Directivo");
		if (!$this->Cuil_Directivo->FldIsDetailKey) {
			$this->Cuil_Directivo->setFormValue($objForm->GetValue("x_Cuil_Directivo"));
		}
		$this->Cuil_Directivo->MultiUpdate = $objForm->GetValue("u_Cuil_Directivo");
		if (!$this->Nombre_Rte->FldIsDetailKey) {
			$this->Nombre_Rte->setFormValue($objForm->GetValue("x_Nombre_Rte"));
		}
		$this->Nombre_Rte->MultiUpdate = $objForm->GetValue("u_Nombre_Rte");
		if (!$this->Tel_Rte->FldIsDetailKey) {
			$this->Tel_Rte->setFormValue($objForm->GetValue("x_Tel_Rte"));
		}
		$this->Tel_Rte->MultiUpdate = $objForm->GetValue("u_Tel_Rte");
		if (!$this->Email_Rte->FldIsDetailKey) {
			$this->Email_Rte->setFormValue($objForm->GetValue("x_Email_Rte"));
		}
		$this->Email_Rte->MultiUpdate = $objForm->GetValue("u_Email_Rte");
		if (!$this->Nro_Serie_Server_Escolar->FldIsDetailKey) {
			$this->Nro_Serie_Server_Escolar->setFormValue($objForm->GetValue("x_Nro_Serie_Server_Escolar"));
		}
		$this->Nro_Serie_Server_Escolar->MultiUpdate = $objForm->GetValue("u_Nro_Serie_Server_Escolar");
		if (!$this->Contacto_Establecimiento->FldIsDetailKey) {
			$this->Contacto_Establecimiento->setFormValue($objForm->GetValue("x_Contacto_Establecimiento"));
		}
		$this->Contacto_Establecimiento->MultiUpdate = $objForm->GetValue("u_Contacto_Establecimiento");
		if (!$this->Domicilio_Escuela->FldIsDetailKey) {
			$this->Domicilio_Escuela->setFormValue($objForm->GetValue("x_Domicilio_Escuela"));
		}
		$this->Domicilio_Escuela->MultiUpdate = $objForm->GetValue("u_Domicilio_Escuela");
		if (!$this->Id_Provincia->FldIsDetailKey) {
			$this->Id_Provincia->setFormValue($objForm->GetValue("x_Id_Provincia"));
		}
		$this->Id_Provincia->MultiUpdate = $objForm->GetValue("u_Id_Provincia");
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->MultiUpdate = $objForm->GetValue("u_Id_Departamento");
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->MultiUpdate = $objForm->GetValue("u_Id_Localidad");
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
		$this->Cue_Establecimiento->CurrentValue = $this->Cue_Establecimiento->FormValue;
		$this->Nombre_Establecimiento->CurrentValue = $this->Nombre_Establecimiento->FormValue;
		$this->Nombre_Directivo->CurrentValue = $this->Nombre_Directivo->FormValue;
		$this->Cuil_Directivo->CurrentValue = $this->Cuil_Directivo->FormValue;
		$this->Nombre_Rte->CurrentValue = $this->Nombre_Rte->FormValue;
		$this->Tel_Rte->CurrentValue = $this->Tel_Rte->FormValue;
		$this->Email_Rte->CurrentValue = $this->Email_Rte->FormValue;
		$this->Nro_Serie_Server_Escolar->CurrentValue = $this->Nro_Serie_Server_Escolar->FormValue;
		$this->Contacto_Establecimiento->CurrentValue = $this->Contacto_Establecimiento->FormValue;
		$this->Domicilio_Escuela->CurrentValue = $this->Domicilio_Escuela->FormValue;
		$this->Id_Provincia->CurrentValue = $this->Id_Provincia->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
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
		$this->Cue_Establecimiento->setDbValue($rs->fields('Cue_Establecimiento'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Nombre_Directivo->setDbValue($rs->fields('Nombre_Directivo'));
		$this->Cuil_Directivo->setDbValue($rs->fields('Cuil_Directivo'));
		$this->Nombre_Rte->setDbValue($rs->fields('Nombre_Rte'));
		$this->Tel_Rte->setDbValue($rs->fields('Tel_Rte'));
		$this->Email_Rte->setDbValue($rs->fields('Email_Rte'));
		$this->Nro_Serie_Server_Escolar->setDbValue($rs->fields('Nro_Serie_Server_Escolar'));
		$this->Contacto_Establecimiento->setDbValue($rs->fields('Contacto_Establecimiento'));
		$this->Domicilio_Escuela->setDbValue($rs->fields('Domicilio_Escuela'));
		$this->Id_Provincia->setDbValue($rs->fields('Id_Provincia'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
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
		$this->Nombre_Directivo->DbValue = $row['Nombre_Directivo'];
		$this->Cuil_Directivo->DbValue = $row['Cuil_Directivo'];
		$this->Nombre_Rte->DbValue = $row['Nombre_Rte'];
		$this->Tel_Rte->DbValue = $row['Tel_Rte'];
		$this->Email_Rte->DbValue = $row['Email_Rte'];
		$this->Nro_Serie_Server_Escolar->DbValue = $row['Nro_Serie_Server_Escolar'];
		$this->Contacto_Establecimiento->DbValue = $row['Contacto_Establecimiento'];
		$this->Domicilio_Escuela->DbValue = $row['Domicilio_Escuela'];
		$this->Id_Provincia->DbValue = $row['Id_Provincia'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
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
		// Nombre_Directivo
		// Cuil_Directivo
		// Nombre_Rte
		// Tel_Rte
		// Email_Rte
		// Nro_Serie_Server_Escolar
		// Contacto_Establecimiento
		// Domicilio_Escuela
		// Id_Provincia
		// Id_Departamento
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

		// Nombre_Directivo
		$this->Nombre_Directivo->ViewValue = $this->Nombre_Directivo->CurrentValue;
		$this->Nombre_Directivo->ViewCustomAttributes = "";

		// Cuil_Directivo
		$this->Cuil_Directivo->ViewValue = $this->Cuil_Directivo->CurrentValue;
		$this->Cuil_Directivo->ViewCustomAttributes = "";

		// Nombre_Rte
		$this->Nombre_Rte->ViewValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->ViewCustomAttributes = "";

		// Tel_Rte
		$this->Tel_Rte->ViewValue = $this->Tel_Rte->CurrentValue;
		$this->Tel_Rte->ViewCustomAttributes = "";

		// Email_Rte
		$this->Email_Rte->ViewValue = $this->Email_Rte->CurrentValue;
		$this->Email_Rte->ViewCustomAttributes = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->ViewValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->ViewCustomAttributes = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->ViewValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->ViewCustomAttributes = "";

		// Domicilio_Escuela
		$this->Domicilio_Escuela->ViewValue = $this->Domicilio_Escuela->CurrentValue;
		$this->Domicilio_Escuela->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->CurrentValue;
			}
		} else {
			$this->Id_Departamento->ViewValue = NULL;
		}
		$this->Id_Departamento->ViewCustomAttributes = "";

		// Id_Localidad
		if (strval($this->Id_Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Id_Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
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

			// Nombre_Directivo
			$this->Nombre_Directivo->LinkCustomAttributes = "";
			$this->Nombre_Directivo->HrefValue = "";
			$this->Nombre_Directivo->TooltipValue = "";

			// Cuil_Directivo
			$this->Cuil_Directivo->LinkCustomAttributes = "";
			$this->Cuil_Directivo->HrefValue = "";
			$this->Cuil_Directivo->TooltipValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";
			$this->Nombre_Rte->TooltipValue = "";

			// Tel_Rte
			$this->Tel_Rte->LinkCustomAttributes = "";
			$this->Tel_Rte->HrefValue = "";
			$this->Tel_Rte->TooltipValue = "";

			// Email_Rte
			$this->Email_Rte->LinkCustomAttributes = "";
			$this->Email_Rte->HrefValue = "";
			$this->Email_Rte->TooltipValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";
			$this->Nro_Serie_Server_Escolar->TooltipValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";
			$this->Contacto_Establecimiento->TooltipValue = "";

			// Domicilio_Escuela
			$this->Domicilio_Escuela->LinkCustomAttributes = "";
			$this->Domicilio_Escuela->HrefValue = "";
			$this->Domicilio_Escuela->TooltipValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";
			$this->Id_Provincia->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Cue_Establecimiento
			$this->Cue_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento->EditCustomAttributes = "";
			$this->Cue_Establecimiento->EditValue = $this->Cue_Establecimiento->CurrentValue;
			$this->Cue_Establecimiento->ViewCustomAttributes = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->CurrentValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Nombre_Directivo
			$this->Nombre_Directivo->EditAttrs["class"] = "form-control";
			$this->Nombre_Directivo->EditCustomAttributes = "";
			$this->Nombre_Directivo->EditValue = ew_HtmlEncode($this->Nombre_Directivo->CurrentValue);
			$this->Nombre_Directivo->PlaceHolder = ew_RemoveHtml($this->Nombre_Directivo->FldCaption());

			// Cuil_Directivo
			$this->Cuil_Directivo->EditAttrs["class"] = "form-control";
			$this->Cuil_Directivo->EditCustomAttributes = "";
			$this->Cuil_Directivo->EditValue = ew_HtmlEncode($this->Cuil_Directivo->CurrentValue);
			$this->Cuil_Directivo->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo->FldCaption());

			// Nombre_Rte
			$this->Nombre_Rte->EditAttrs["class"] = "form-control";
			$this->Nombre_Rte->EditCustomAttributes = "";
			$this->Nombre_Rte->EditValue = ew_HtmlEncode($this->Nombre_Rte->CurrentValue);
			$this->Nombre_Rte->PlaceHolder = ew_RemoveHtml($this->Nombre_Rte->FldCaption());

			// Tel_Rte
			$this->Tel_Rte->EditAttrs["class"] = "form-control";
			$this->Tel_Rte->EditCustomAttributes = "";
			$this->Tel_Rte->EditValue = ew_HtmlEncode($this->Tel_Rte->CurrentValue);
			$this->Tel_Rte->PlaceHolder = ew_RemoveHtml($this->Tel_Rte->FldCaption());

			// Email_Rte
			$this->Email_Rte->EditAttrs["class"] = "form-control";
			$this->Email_Rte->EditCustomAttributes = "";
			$this->Email_Rte->EditValue = ew_HtmlEncode($this->Email_Rte->CurrentValue);
			$this->Email_Rte->PlaceHolder = ew_RemoveHtml($this->Email_Rte->FldCaption());

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->EditAttrs["class"] = "form-control";
			$this->Nro_Serie_Server_Escolar->EditCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->EditValue = ew_HtmlEncode($this->Nro_Serie_Server_Escolar->CurrentValue);
			$this->Nro_Serie_Server_Escolar->PlaceHolder = ew_RemoveHtml($this->Nro_Serie_Server_Escolar->FldCaption());

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Contacto_Establecimiento->EditCustomAttributes = "";
			$this->Contacto_Establecimiento->EditValue = ew_HtmlEncode($this->Contacto_Establecimiento->CurrentValue);
			$this->Contacto_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Contacto_Establecimiento->FldCaption());

			// Domicilio_Escuela
			$this->Domicilio_Escuela->EditAttrs["class"] = "form-control";
			$this->Domicilio_Escuela->EditCustomAttributes = "";
			$this->Domicilio_Escuela->EditValue = ew_HtmlEncode($this->Domicilio_Escuela->CurrentValue);
			$this->Domicilio_Escuela->PlaceHolder = ew_RemoveHtml($this->Domicilio_Escuela->FldCaption());

			// Id_Provincia
			$this->Id_Provincia->EditAttrs["class"] = "form-control";
			$this->Id_Provincia->EditCustomAttributes = "";
			if (trim(strval($this->Id_Provincia->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Provincia->EditValue = $arwrk;

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Cue_Establecimiento

			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";

			// Nombre_Directivo
			$this->Nombre_Directivo->LinkCustomAttributes = "";
			$this->Nombre_Directivo->HrefValue = "";

			// Cuil_Directivo
			$this->Cuil_Directivo->LinkCustomAttributes = "";
			$this->Cuil_Directivo->HrefValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";

			// Tel_Rte
			$this->Tel_Rte->LinkCustomAttributes = "";
			$this->Tel_Rte->HrefValue = "";

			// Email_Rte
			$this->Email_Rte->LinkCustomAttributes = "";
			$this->Email_Rte->HrefValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";

			// Domicilio_Escuela
			$this->Domicilio_Escuela->LinkCustomAttributes = "";
			$this->Domicilio_Escuela->HrefValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

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
		if ($this->Cue_Establecimiento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nombre_Establecimiento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nombre_Directivo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cuil_Directivo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nombre_Rte->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Tel_Rte->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Email_Rte->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nro_Serie_Server_Escolar->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Contacto_Establecimiento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Domicilio_Escuela->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Provincia->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Departamento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Localidad->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Email_Rte->MultiUpdate <> "") {
			if (!ew_CheckEmail($this->Email_Rte->FormValue)) {
				ew_AddMessage($gsFormError, $this->Email_Rte->FldErrMsg());
			}
		}
		if ($this->Nro_Serie_Server_Escolar->MultiUpdate <> "" && !$this->Nro_Serie_Server_Escolar->FldIsDetailKey && !is_null($this->Nro_Serie_Server_Escolar->FormValue) && $this->Nro_Serie_Server_Escolar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nro_Serie_Server_Escolar->FldCaption(), $this->Nro_Serie_Server_Escolar->ReqErrMsg));
		}
		if ($this->Domicilio_Escuela->MultiUpdate <> "" && !$this->Domicilio_Escuela->FldIsDetailKey && !is_null($this->Domicilio_Escuela->FormValue) && $this->Domicilio_Escuela->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Domicilio_Escuela->FldCaption(), $this->Domicilio_Escuela->ReqErrMsg));
		}
		if ($this->Id_Provincia->MultiUpdate <> "" && !$this->Id_Provincia->FldIsDetailKey && !is_null($this->Id_Provincia->FormValue) && $this->Id_Provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Provincia->FldCaption(), $this->Id_Provincia->ReqErrMsg));
		}
		if ($this->Id_Departamento->MultiUpdate <> "" && !$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if ($this->Id_Localidad->MultiUpdate <> "" && !$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
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

			// Cue_Establecimiento
			// Nombre_Establecimiento

			$this->Nombre_Establecimiento->SetDbValueDef($rsnew, $this->Nombre_Establecimiento->CurrentValue, NULL, $this->Nombre_Establecimiento->ReadOnly || $this->Nombre_Establecimiento->MultiUpdate <> "1");

			// Nombre_Directivo
			$this->Nombre_Directivo->SetDbValueDef($rsnew, $this->Nombre_Directivo->CurrentValue, NULL, $this->Nombre_Directivo->ReadOnly || $this->Nombre_Directivo->MultiUpdate <> "1");

			// Cuil_Directivo
			$this->Cuil_Directivo->SetDbValueDef($rsnew, $this->Cuil_Directivo->CurrentValue, NULL, $this->Cuil_Directivo->ReadOnly || $this->Cuil_Directivo->MultiUpdate <> "1");

			// Nombre_Rte
			$this->Nombre_Rte->SetDbValueDef($rsnew, $this->Nombre_Rte->CurrentValue, NULL, $this->Nombre_Rte->ReadOnly || $this->Nombre_Rte->MultiUpdate <> "1");

			// Tel_Rte
			$this->Tel_Rte->SetDbValueDef($rsnew, $this->Tel_Rte->CurrentValue, NULL, $this->Tel_Rte->ReadOnly || $this->Tel_Rte->MultiUpdate <> "1");

			// Email_Rte
			$this->Email_Rte->SetDbValueDef($rsnew, $this->Email_Rte->CurrentValue, NULL, $this->Email_Rte->ReadOnly || $this->Email_Rte->MultiUpdate <> "1");

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->SetDbValueDef($rsnew, $this->Nro_Serie_Server_Escolar->CurrentValue, NULL, $this->Nro_Serie_Server_Escolar->ReadOnly || $this->Nro_Serie_Server_Escolar->MultiUpdate <> "1");

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->SetDbValueDef($rsnew, $this->Contacto_Establecimiento->CurrentValue, NULL, $this->Contacto_Establecimiento->ReadOnly || $this->Contacto_Establecimiento->MultiUpdate <> "1");

			// Domicilio_Escuela
			$this->Domicilio_Escuela->SetDbValueDef($rsnew, $this->Domicilio_Escuela->CurrentValue, NULL, $this->Domicilio_Escuela->ReadOnly || $this->Domicilio_Escuela->MultiUpdate <> "1");

			// Id_Provincia
			$this->Id_Provincia->SetDbValueDef($rsnew, $this->Id_Provincia->CurrentValue, 0, $this->Id_Provincia->ReadOnly || $this->Id_Provincia->MultiUpdate <> "1");

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly || $this->Id_Departamento->MultiUpdate <> "1");

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly || $this->Id_Localidad->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("establecimientos_educativos_paselist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Provincia":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Provincia` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Provincia` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "{filter}";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Provincia` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Localidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Localidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->Id_Localidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Localidad` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Departamento` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
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
		$table = 'establecimientos_educativos_pase';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'establecimientos_educativos_pase';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue_Establecimiento'];

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
if (!isset($establecimientos_educativos_pase_update)) $establecimientos_educativos_pase_update = new cestablecimientos_educativos_pase_update();

// Page init
$establecimientos_educativos_pase_update->Page_Init();

// Page main
$establecimientos_educativos_pase_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$establecimientos_educativos_pase_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = festablecimientos_educativos_paseupdate = new ew_Form("festablecimientos_educativos_paseupdate", "update");

// Validate form
festablecimientos_educativos_paseupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Email_Rte");
			uelm = this.GetElements("u" + infix + "_Email_Rte");
			if (uelm && uelm.checked && elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($establecimientos_educativos_pase->Email_Rte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nro_Serie_Server_Escolar");
			uelm = this.GetElements("u" + infix + "_Nro_Serie_Server_Escolar");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->FldCaption(), $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Domicilio_Escuela");
			uelm = this.GetElements("u" + infix + "_Domicilio_Escuela");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Domicilio_Escuela->FldCaption(), $establecimientos_educativos_pase->Domicilio_Escuela->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Provincia");
			uelm = this.GetElements("u" + infix + "_Id_Provincia");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Provincia->FldCaption(), $establecimientos_educativos_pase->Id_Provincia->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			uelm = this.GetElements("u" + infix + "_Id_Departamento");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Departamento->FldCaption(), $establecimientos_educativos_pase->Id_Departamento->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			uelm = this.GetElements("u" + infix + "_Id_Localidad");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $establecimientos_educativos_pase->Id_Localidad->FldCaption(), $establecimientos_educativos_pase->Id_Localidad->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
festablecimientos_educativos_paseupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festablecimientos_educativos_paseupdate.ValidateRequired = true;
<?php } else { ?>
festablecimientos_educativos_paseupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festablecimientos_educativos_paseupdate.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
festablecimientos_educativos_paseupdate.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
festablecimientos_educativos_paseupdate.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$establecimientos_educativos_pase_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $establecimientos_educativos_pase_update->ShowPageHeader(); ?>
<?php
$establecimientos_educativos_pase_update->ShowMessage();
?>
<form name="festablecimientos_educativos_paseupdate" id="festablecimientos_educativos_paseupdate" class="<?php echo $establecimientos_educativos_pase_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($establecimientos_educativos_pase_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $establecimientos_educativos_pase_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="establecimientos_educativos_pase">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($establecimientos_educativos_pase_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($establecimientos_educativos_pase_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_establecimientos_educativos_paseupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<div id="r_Nombre_Establecimiento" class="form-group">
		<label for="x_Nombre_Establecimiento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Nombre_Establecimiento" id="u_Nombre_Establecimiento" value="1"<?php echo ($establecimientos_educativos_pase->Nombre_Establecimiento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Nombre_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="x_Nombre_Establecimiento" id="x_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nombre_Directivo->Visible) { // Nombre_Directivo ?>
	<div id="r_Nombre_Directivo" class="form-group">
		<label for="x_Nombre_Directivo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Nombre_Directivo" id="u_Nombre_Directivo" value="1"<?php echo ($establecimientos_educativos_pase->Nombre_Directivo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Nombre_Directivo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Nombre_Directivo->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Nombre_Directivo">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Directivo" name="x_Nombre_Directivo" id="x_Nombre_Directivo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Directivo->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Directivo->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Directivo->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Nombre_Directivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Cuil_Directivo->Visible) { // Cuil_Directivo ?>
	<div id="r_Cuil_Directivo" class="form-group">
		<label for="x_Cuil_Directivo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cuil_Directivo" id="u_Cuil_Directivo" value="1"<?php echo ($establecimientos_educativos_pase->Cuil_Directivo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Cuil_Directivo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Cuil_Directivo->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Cuil_Directivo">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Directivo" name="x_Cuil_Directivo" id="x_Cuil_Directivo" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Directivo->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cuil_Directivo->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cuil_Directivo->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Cuil_Directivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nombre_Rte->Visible) { // Nombre_Rte ?>
	<div id="r_Nombre_Rte" class="form-group">
		<label for="x_Nombre_Rte" class="col-sm-2 control-label">
<input type="checkbox" name="u_Nombre_Rte" id="u_Nombre_Rte" value="1"<?php echo ($establecimientos_educativos_pase->Nombre_Rte->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Nombre_Rte->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Nombre_Rte->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Nombre_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="x_Nombre_Rte" id="x_Nombre_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Nombre_Rte->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Tel_Rte->Visible) { // Tel_Rte ?>
	<div id="r_Tel_Rte" class="form-group">
		<label for="x_Tel_Rte" class="col-sm-2 control-label">
<input type="checkbox" name="u_Tel_Rte" id="u_Tel_Rte" value="1"<?php echo ($establecimientos_educativos_pase->Tel_Rte->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Tel_Rte->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Tel_Rte->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Tel_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Tel_Rte" name="x_Tel_Rte" id="x_Tel_Rte" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Tel_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Tel_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Tel_Rte->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Tel_Rte->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Email_Rte->Visible) { // Email_Rte ?>
	<div id="r_Email_Rte" class="form-group">
		<label for="x_Email_Rte" class="col-sm-2 control-label">
<input type="checkbox" name="u_Email_Rte" id="u_Email_Rte" value="1"<?php echo ($establecimientos_educativos_pase->Email_Rte->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Email_Rte->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Email_Rte->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Email_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Email_Rte" name="x_Email_Rte" id="x_Email_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Email_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Email_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Email_Rte->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Email_Rte->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
	<div id="r_Nro_Serie_Server_Escolar" class="form-group">
		<label for="x_Nro_Serie_Server_Escolar" class="col-sm-2 control-label">
<input type="checkbox" name="u_Nro_Serie_Server_Escolar" id="u_Nro_Serie_Server_Escolar" value="1"<?php echo ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="x_Nro_Serie_Server_Escolar" id="x_Nro_Serie_Server_Escolar" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
	<div id="r_Contacto_Establecimiento" class="form-group">
		<label for="x_Contacto_Establecimiento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Contacto_Establecimiento" id="u_Contacto_Establecimiento" value="1"<?php echo ($establecimientos_educativos_pase->Contacto_Establecimiento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Contacto_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="x_Contacto_Establecimiento" id="x_Contacto_Establecimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Domicilio_Escuela->Visible) { // Domicilio_Escuela ?>
	<div id="r_Domicilio_Escuela" class="form-group">
		<label for="x_Domicilio_Escuela" class="col-sm-2 control-label">
<input type="checkbox" name="u_Domicilio_Escuela" id="u_Domicilio_Escuela" value="1"<?php echo ($establecimientos_educativos_pase->Domicilio_Escuela->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Domicilio_Escuela->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Domicilio_Escuela->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Domicilio_Escuela">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Domicilio_Escuela" name="x_Domicilio_Escuela" id="x_Domicilio_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Domicilio_Escuela->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Domicilio_Escuela->EditValue ?>"<?php echo $establecimientos_educativos_pase->Domicilio_Escuela->EditAttributes() ?>>
</span>
<?php echo $establecimientos_educativos_pase->Domicilio_Escuela->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Provincia->Visible) { // Id_Provincia ?>
	<div id="r_Id_Provincia" class="form-group">
		<label for="x_Id_Provincia" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Provincia" id="u_Id_Provincia" value="1"<?php echo ($establecimientos_educativos_pase->Id_Provincia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Id_Provincia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Id_Provincia->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Id_Provincia">
<?php $establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x_Id_Provincia" name="x_Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->SelectOptionListHtml("x_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x_Id_Provincia" id="s_x_Id_Provincia" value="<?php echo $establecimientos_educativos_pase->Id_Provincia->LookupFilterQuery() ?>">
</span>
<?php echo $establecimientos_educativos_pase->Id_Provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Departamento" id="u_Id_Departamento" value="1"<?php echo ($establecimientos_educativos_pase->Id_Departamento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Id_Departamento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Id_Departamento->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Id_Departamento">
<?php $establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $establecimientos_educativos_pase->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php echo $establecimientos_educativos_pase->Id_Departamento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Localidad" id="u_Id_Localidad" value="1"<?php echo ($establecimientos_educativos_pase->Id_Localidad->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $establecimientos_educativos_pase->Id_Localidad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $establecimientos_educativos_pase->Id_Localidad->CellAttributes() ?>>
<span id="el_establecimientos_educativos_pase_Id_Localidad">
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $establecimientos_educativos_pase->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php echo $establecimientos_educativos_pase->Id_Localidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$establecimientos_educativos_pase_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $establecimientos_educativos_pase_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
festablecimientos_educativos_paseupdate.Init();
</script>
<?php
$establecimientos_educativos_pase_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$establecimientos_educativos_pase_update->Page_Terminate();
?>
