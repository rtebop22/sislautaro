<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "lista_espera_prestamoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$lista_espera_prestamo_update = NULL; // Initialize page object first

class clista_espera_prestamo_update extends clista_espera_prestamo {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'lista_espera_prestamo';

	// Page object name
	var $PageObjName = 'lista_espera_prestamo_update';

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

		// Table object (lista_espera_prestamo)
		if (!isset($GLOBALS["lista_espera_prestamo"]) || get_class($GLOBALS["lista_espera_prestamo"]) == "clista_espera_prestamo") {
			$GLOBALS["lista_espera_prestamo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lista_espera_prestamo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lista_espera_prestamo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("lista_espera_prestamolist.php"));
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
		$this->Apellidos_Nombres->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Id_Motivo_Prestamo->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Id_Curso->SetVisibility();
		$this->Id_Division->SetVisibility();
		$this->Id_Estado_Espera->SetVisibility();
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
		global $EW_EXPORT, $lista_espera_prestamo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lista_espera_prestamo);
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
			$this->Page_Terminate("lista_espera_prestamolist.php"); // No records selected, return to list
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
					$this->Apellidos_Nombres->setDbValue($this->Recordset->fields('Apellidos_Nombres'));
					$this->Dni->setDbValue($this->Recordset->fields('Dni'));
					$this->Id_Motivo_Prestamo->setDbValue($this->Recordset->fields('Id_Motivo_Prestamo'));
					$this->Observacion->setDbValue($this->Recordset->fields('Observacion'));
					$this->Id_Curso->setDbValue($this->Recordset->fields('Id_Curso'));
					$this->Id_Division->setDbValue($this->Recordset->fields('Id_Division'));
					$this->Id_Estado_Espera->setDbValue($this->Recordset->fields('Id_Estado_Espera'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
				} else {
					if (!ew_CompareValue($this->Apellidos_Nombres->DbValue, $this->Recordset->fields('Apellidos_Nombres')))
						$this->Apellidos_Nombres->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni->DbValue, $this->Recordset->fields('Dni')))
						$this->Dni->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Motivo_Prestamo->DbValue, $this->Recordset->fields('Id_Motivo_Prestamo')))
						$this->Id_Motivo_Prestamo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Observacion->DbValue, $this->Recordset->fields('Observacion')))
						$this->Observacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Curso->DbValue, $this->Recordset->fields('Id_Curso')))
						$this->Id_Curso->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Division->DbValue, $this->Recordset->fields('Id_Division')))
						$this->Id_Division->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado_Espera->DbValue, $this->Recordset->fields('Id_Estado_Espera')))
						$this->Id_Estado_Espera->CurrentValue = NULL;
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
		$this->Dni->CurrentValue = $sKeyFld;
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
		if (!$this->Apellidos_Nombres->FldIsDetailKey) {
			$this->Apellidos_Nombres->setFormValue($objForm->GetValue("x_Apellidos_Nombres"));
		}
		$this->Apellidos_Nombres->MultiUpdate = $objForm->GetValue("u_Apellidos_Nombres");
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->MultiUpdate = $objForm->GetValue("u_Dni");
		if (!$this->Id_Motivo_Prestamo->FldIsDetailKey) {
			$this->Id_Motivo_Prestamo->setFormValue($objForm->GetValue("x_Id_Motivo_Prestamo"));
		}
		$this->Id_Motivo_Prestamo->MultiUpdate = $objForm->GetValue("u_Id_Motivo_Prestamo");
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->MultiUpdate = $objForm->GetValue("u_Observacion");
		if (!$this->Id_Curso->FldIsDetailKey) {
			$this->Id_Curso->setFormValue($objForm->GetValue("x_Id_Curso"));
		}
		$this->Id_Curso->MultiUpdate = $objForm->GetValue("u_Id_Curso");
		if (!$this->Id_Division->FldIsDetailKey) {
			$this->Id_Division->setFormValue($objForm->GetValue("x_Id_Division"));
		}
		$this->Id_Division->MultiUpdate = $objForm->GetValue("u_Id_Division");
		if (!$this->Id_Estado_Espera->FldIsDetailKey) {
			$this->Id_Estado_Espera->setFormValue($objForm->GetValue("x_Id_Estado_Espera"));
		}
		$this->Id_Estado_Espera->MultiUpdate = $objForm->GetValue("u_Id_Estado_Espera");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
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
		$this->Apellidos_Nombres->CurrentValue = $this->Apellidos_Nombres->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Id_Motivo_Prestamo->CurrentValue = $this->Id_Motivo_Prestamo->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Id_Curso->CurrentValue = $this->Id_Curso->FormValue;
		$this->Id_Division->CurrentValue = $this->Id_Division->FormValue;
		$this->Id_Estado_Espera->CurrentValue = $this->Id_Estado_Espera->FormValue;
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
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Id_Motivo_Prestamo->setDbValue($rs->fields('Id_Motivo_Prestamo'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Id_Curso->setDbValue($rs->fields('Id_Curso'));
		$this->Id_Division->setDbValue($rs->fields('Id_Division'));
		$this->Id_Estado_Espera->setDbValue($rs->fields('Id_Estado_Espera'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apellidos_Nombres->DbValue = $row['Apellidos_Nombres'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Id_Motivo_Prestamo->DbValue = $row['Id_Motivo_Prestamo'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Id_Curso->DbValue = $row['Id_Curso'];
		$this->Id_Division->DbValue = $row['Id_Division'];
		$this->Id_Estado_Espera->DbValue = $row['Id_Estado_Espera'];
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
		// Apellidos_Nombres
		// Dni
		// Id_Motivo_Prestamo
		// Observacion
		// Id_Curso
		// Id_Division
		// Id_Estado_Espera
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		if (strval($this->Apellidos_Nombres->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Apellidos_Nombres->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`Id_Estado`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellidos_Nombres, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
			}
		} else {
			$this->Apellidos_Nombres->ViewValue = NULL;
		}
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Id_Motivo_Prestamo
		if (strval($this->Id_Motivo_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Motivo_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Prestamo->ViewValue = NULL;
		}
		$this->Id_Motivo_Prestamo->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Curso
		if (strval($this->Id_Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Id_Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Curso->ViewValue = $this->Id_Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Curso->ViewValue = $this->Id_Curso->CurrentValue;
			}
		} else {
			$this->Id_Curso->ViewValue = NULL;
		}
		$this->Id_Curso->ViewCustomAttributes = "";

		// Id_Division
		if (strval($this->Id_Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Id_Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Division->ViewValue = $this->Id_Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Division->ViewValue = $this->Id_Division->CurrentValue;
			}
		} else {
			$this->Id_Division->ViewValue = NULL;
		}
		$this->Id_Division->ViewCustomAttributes = "";

		// Id_Estado_Espera
		if (strval($this->Id_Estado_Espera->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Espera`" . ew_SearchString("=", $this->Id_Estado_Espera->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Espera`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_espera_prestamo`";
		$sWhereWrk = "";
		$this->Id_Estado_Espera->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Espera, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Espera->ViewValue = $this->Id_Estado_Espera->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Espera->ViewValue = $this->Id_Estado_Espera->CurrentValue;
			}
		} else {
			$this->Id_Estado_Espera->ViewValue = NULL;
		}
		$this->Id_Estado_Espera->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";
			$this->Apellidos_Nombres->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";
			$this->Id_Motivo_Prestamo->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";
			$this->Id_Curso->TooltipValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";
			$this->Id_Division->TooltipValue = "";

			// Id_Estado_Espera
			$this->Id_Estado_Espera->LinkCustomAttributes = "";
			$this->Id_Estado_Espera->HrefValue = "";
			$this->Id_Estado_Espera->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
			if (strval($this->Apellidos_Nombres->CurrentValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres->CurrentValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Apellidos_Nombres->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellidos_Nombres, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Apellidos_Nombres->EditValue = $this->Apellidos_Nombres->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->CurrentValue);
				}
			} else {
				$this->Apellidos_Nombres->EditValue = NULL;
			}
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = $this->Dni->CurrentValue;
			$this->Dni->ViewCustomAttributes = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Prestamo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo_Prestamo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo_Prestamo->EditValue = $arwrk;

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Curso
			$this->Id_Curso->EditAttrs["class"] = "form-control";
			$this->Id_Curso->EditCustomAttributes = "";
			if (trim(strval($this->Id_Curso->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Curso->EditValue = $arwrk;

			// Id_Division
			$this->Id_Division->EditAttrs["class"] = "form-control";
			$this->Id_Division->EditCustomAttributes = "";
			if (trim(strval($this->Id_Division->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Division->EditValue = $arwrk;

			// Id_Estado_Espera
			$this->Id_Estado_Espera->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Espera->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Espera->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Espera`" . ew_SearchString("=", $this->Id_Estado_Espera->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Espera`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_espera_prestamo`";
			$sWhereWrk = "";
			$this->Id_Estado_Espera->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Espera, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Espera->EditValue = $arwrk;

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Apellidos_Nombres

			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";

			// Id_Estado_Espera
			$this->Id_Estado_Espera->LinkCustomAttributes = "";
			$this->Id_Estado_Espera->HrefValue = "";

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
		if ($this->Apellidos_Nombres->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Motivo_Prestamo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Observacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Curso->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Division->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado_Espera->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Dni->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
			}
		}
		if ($this->Id_Motivo_Prestamo->MultiUpdate <> "" && !$this->Id_Motivo_Prestamo->FldIsDetailKey && !is_null($this->Id_Motivo_Prestamo->FormValue) && $this->Id_Motivo_Prestamo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo_Prestamo->FldCaption(), $this->Id_Motivo_Prestamo->ReqErrMsg));
		}
		if ($this->Id_Curso->MultiUpdate <> "" && !$this->Id_Curso->FldIsDetailKey && !is_null($this->Id_Curso->FormValue) && $this->Id_Curso->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Curso->FldCaption(), $this->Id_Curso->ReqErrMsg));
		}
		if ($this->Id_Division->MultiUpdate <> "" && !$this->Id_Division->FldIsDetailKey && !is_null($this->Id_Division->FormValue) && $this->Id_Division->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Division->FldCaption(), $this->Id_Division->ReqErrMsg));
		}
		if ($this->Id_Estado_Espera->MultiUpdate <> "" && !$this->Id_Estado_Espera->FldIsDetailKey && !is_null($this->Id_Estado_Espera->FormValue) && $this->Id_Estado_Espera->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Espera->FldCaption(), $this->Id_Estado_Espera->ReqErrMsg));
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

			// Apellidos_Nombres
			$this->Apellidos_Nombres->SetDbValueDef($rsnew, $this->Apellidos_Nombres->CurrentValue, NULL, $this->Apellidos_Nombres->ReadOnly || $this->Apellidos_Nombres->MultiUpdate <> "1");

			// Dni
			// Id_Motivo_Prestamo

			$this->Id_Motivo_Prestamo->SetDbValueDef($rsnew, $this->Id_Motivo_Prestamo->CurrentValue, 0, $this->Id_Motivo_Prestamo->ReadOnly || $this->Id_Motivo_Prestamo->MultiUpdate <> "1");

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly || $this->Observacion->MultiUpdate <> "1");

			// Id_Curso
			$this->Id_Curso->SetDbValueDef($rsnew, $this->Id_Curso->CurrentValue, 0, $this->Id_Curso->ReadOnly || $this->Id_Curso->MultiUpdate <> "1");

			// Id_Division
			$this->Id_Division->SetDbValueDef($rsnew, $this->Id_Division->CurrentValue, 0, $this->Id_Division->ReadOnly || $this->Id_Division->MultiUpdate <> "1");

			// Id_Estado_Espera
			$this->Id_Estado_Espera->SetDbValueDef($rsnew, $this->Id_Estado_Espera->CurrentValue, 0, $this->Id_Estado_Espera->ReadOnly || $this->Id_Estado_Espera->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lista_espera_prestamolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Apellidos_Nombres":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Apellidos_Nombres->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellidos_Nombres, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo_Prestamo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo_Prestamo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Curso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Curso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Division` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Division` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Espera":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Espera` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_espera_prestamo`";
			$sWhereWrk = "";
			$this->Id_Estado_Espera->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Espera` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Espera, $sWhereWrk); // Call Lookup selecting
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
		case "x_Apellidos_Nombres":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Apellidos_Nombres->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellidos_Nombres, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'lista_espera_prestamo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'lista_espera_prestamo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dni'];

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
if (!isset($lista_espera_prestamo_update)) $lista_espera_prestamo_update = new clista_espera_prestamo_update();

// Page init
$lista_espera_prestamo_update->Page_Init();

// Page main
$lista_espera_prestamo_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lista_espera_prestamo_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = flista_espera_prestamoupdate = new ew_Form("flista_espera_prestamoupdate", "update");

// Validate form
flista_espera_prestamoupdate.Validate = function() {
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
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lista_espera_prestamo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo_Prestamo");
			uelm = this.GetElements("u" + infix + "_Id_Motivo_Prestamo");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lista_espera_prestamo->Id_Motivo_Prestamo->FldCaption(), $lista_espera_prestamo->Id_Motivo_Prestamo->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Curso");
			uelm = this.GetElements("u" + infix + "_Id_Curso");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lista_espera_prestamo->Id_Curso->FldCaption(), $lista_espera_prestamo->Id_Curso->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Division");
			uelm = this.GetElements("u" + infix + "_Id_Division");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lista_espera_prestamo->Id_Division->FldCaption(), $lista_espera_prestamo->Id_Division->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Estado_Espera");
			uelm = this.GetElements("u" + infix + "_Id_Estado_Espera");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lista_espera_prestamo->Id_Estado_Espera->FldCaption(), $lista_espera_prestamo->Id_Estado_Espera->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flista_espera_prestamoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flista_espera_prestamoupdate.ValidateRequired = true;
<?php } else { ?>
flista_espera_prestamoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flista_espera_prestamoupdate.Lists["x_Apellidos_Nombres"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
flista_espera_prestamoupdate.Lists["x_Id_Motivo_Prestamo"] = {"LinkField":"x_Id_Motivo_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_prestamo_equipo"};
flista_espera_prestamoupdate.Lists["x_Id_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
flista_espera_prestamoupdate.Lists["x_Id_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
flista_espera_prestamoupdate.Lists["x_Id_Estado_Espera"] = {"LinkField":"x_Id_Estado_Espera","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_espera_prestamo"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$lista_espera_prestamo_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $lista_espera_prestamo_update->ShowPageHeader(); ?>
<?php
$lista_espera_prestamo_update->ShowMessage();
?>
<form name="flista_espera_prestamoupdate" id="flista_espera_prestamoupdate" class="<?php echo $lista_espera_prestamo_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lista_espera_prestamo_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lista_espera_prestamo_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lista_espera_prestamo">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($lista_espera_prestamo_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($lista_espera_prestamo_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_lista_espera_prestamoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($lista_espera_prestamo->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<div id="r_Apellidos_Nombres" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Apellidos_Nombres" id="u_Apellidos_Nombres" value="1"<?php echo ($lista_espera_prestamo->Apellidos_Nombres->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Apellidos_Nombres->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Apellidos_Nombres->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Apellidos_Nombres">
<?php $lista_espera_prestamo->Apellidos_Nombres->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$lista_espera_prestamo->Apellidos_Nombres->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Apellidos_Nombres"><?php echo (strval($lista_espera_prestamo->Apellidos_Nombres->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $lista_espera_prestamo->Apellidos_Nombres->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($lista_espera_prestamo->Apellidos_Nombres->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Apellidos_Nombres',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="lista_espera_prestamo" data-field="x_Apellidos_Nombres" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $lista_espera_prestamo->Apellidos_Nombres->DisplayValueSeparatorAttribute() ?>" name="x_Apellidos_Nombres" id="x_Apellidos_Nombres" value="<?php echo $lista_espera_prestamo->Apellidos_Nombres->CurrentValue ?>"<?php echo $lista_espera_prestamo->Apellidos_Nombres->EditAttributes() ?>>
<input type="hidden" name="s_x_Apellidos_Nombres" id="s_x_Apellidos_Nombres" value="<?php echo $lista_espera_prestamo->Apellidos_Nombres->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Apellidos_Nombres" id="ln_x_Apellidos_Nombres" value="x_Id_Curso,x_Id_Division">
</span>
<?php echo $lista_espera_prestamo->Apellidos_Nombres->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
	<div id="r_Id_Motivo_Prestamo" class="form-group">
		<label for="x_Id_Motivo_Prestamo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Motivo_Prestamo" id="u_Id_Motivo_Prestamo" value="1"<?php echo ($lista_espera_prestamo->Id_Motivo_Prestamo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Id_Motivo_Prestamo">
<select data-table="lista_espera_prestamo" data-field="x_Id_Motivo_Prestamo" data-value-separator="<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo_Prestamo" name="x_Id_Motivo_Prestamo"<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->EditAttributes() ?>>
<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->SelectOptionListHtml("x_Id_Motivo_Prestamo") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo_Prestamo" id="s_x_Id_Motivo_Prestamo" value="<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->LookupFilterQuery() ?>">
</span>
<?php echo $lista_espera_prestamo->Id_Motivo_Prestamo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Observacion" id="u_Observacion" value="1"<?php echo ($lista_espera_prestamo->Observacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Observacion->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Observacion">
<textarea data-table="lista_espera_prestamo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($lista_espera_prestamo->Observacion->getPlaceHolder()) ?>"<?php echo $lista_espera_prestamo->Observacion->EditAttributes() ?>><?php echo $lista_espera_prestamo->Observacion->EditValue ?></textarea>
</span>
<?php echo $lista_espera_prestamo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Id_Curso->Visible) { // Id_Curso ?>
	<div id="r_Id_Curso" class="form-group">
		<label for="x_Id_Curso" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Curso" id="u_Id_Curso" value="1"<?php echo ($lista_espera_prestamo->Id_Curso->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Id_Curso->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Id_Curso->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Id_Curso">
<select data-table="lista_espera_prestamo" data-field="x_Id_Curso" data-value-separator="<?php echo $lista_espera_prestamo->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x_Id_Curso" name="x_Id_Curso"<?php echo $lista_espera_prestamo->Id_Curso->EditAttributes() ?>>
<?php echo $lista_espera_prestamo->Id_Curso->SelectOptionListHtml("x_Id_Curso") ?>
</select>
<input type="hidden" name="s_x_Id_Curso" id="s_x_Id_Curso" value="<?php echo $lista_espera_prestamo->Id_Curso->LookupFilterQuery() ?>">
</span>
<?php echo $lista_espera_prestamo->Id_Curso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Id_Division->Visible) { // Id_Division ?>
	<div id="r_Id_Division" class="form-group">
		<label for="x_Id_Division" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Division" id="u_Id_Division" value="1"<?php echo ($lista_espera_prestamo->Id_Division->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Id_Division->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Id_Division->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Id_Division">
<select data-table="lista_espera_prestamo" data-field="x_Id_Division" data-value-separator="<?php echo $lista_espera_prestamo->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x_Id_Division" name="x_Id_Division"<?php echo $lista_espera_prestamo->Id_Division->EditAttributes() ?>>
<?php echo $lista_espera_prestamo->Id_Division->SelectOptionListHtml("x_Id_Division") ?>
</select>
<input type="hidden" name="s_x_Id_Division" id="s_x_Id_Division" value="<?php echo $lista_espera_prestamo->Id_Division->LookupFilterQuery() ?>">
</span>
<?php echo $lista_espera_prestamo->Id_Division->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Id_Estado_Espera->Visible) { // Id_Estado_Espera ?>
	<div id="r_Id_Estado_Espera" class="form-group">
		<label for="x_Id_Estado_Espera" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado_Espera" id="u_Id_Estado_Espera" value="1"<?php echo ($lista_espera_prestamo->Id_Estado_Espera->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Id_Estado_Espera->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Id_Estado_Espera->CellAttributes() ?>>
<span id="el_lista_espera_prestamo_Id_Estado_Espera">
<select data-table="lista_espera_prestamo" data-field="x_Id_Estado_Espera" data-value-separator="<?php echo $lista_espera_prestamo->Id_Estado_Espera->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Espera" name="x_Id_Estado_Espera"<?php echo $lista_espera_prestamo->Id_Estado_Espera->EditAttributes() ?>>
<?php echo $lista_espera_prestamo->Id_Estado_Espera->SelectOptionListHtml("x_Id_Estado_Espera") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Espera" id="s_x_Id_Estado_Espera" value="<?php echo $lista_espera_prestamo->Id_Estado_Espera->LookupFilterQuery() ?>">
</span>
<?php echo $lista_espera_prestamo->Id_Estado_Espera->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Actualizacion" id="u_Fecha_Actualizacion" value="1"<?php echo ($lista_espera_prestamo->Fecha_Actualizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Fecha_Actualizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Fecha_Actualizacion->CellAttributes() ?>>
<?php echo $lista_espera_prestamo->Fecha_Actualizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lista_espera_prestamo->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="col-sm-2 control-label">
<input type="checkbox" name="u_Usuario" id="u_Usuario" value="1"<?php echo ($lista_espera_prestamo->Usuario->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $lista_espera_prestamo->Usuario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lista_espera_prestamo->Usuario->CellAttributes() ?>>
<?php echo $lista_espera_prestamo->Usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$lista_espera_prestamo_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lista_espera_prestamo_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
flista_espera_prestamoupdate.Init();
</script>
<?php
$lista_espera_prestamo_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lista_espera_prestamo_update->Page_Terminate();
?>
