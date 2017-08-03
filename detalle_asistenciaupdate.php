<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detalle_asistenciainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detalle_asistencia_update = NULL; // Initialize page object first

class cdetalle_asistencia_update extends cdetalle_asistencia {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'detalle_asistencia';

	// Page object name
	var $PageObjName = 'detalle_asistencia_update';

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

		// Table object (detalle_asistencia)
		if (!isset($GLOBALS["detalle_asistencia"]) || get_class($GLOBALS["detalle_asistencia"]) == "cdetalle_asistencia") {
			$GLOBALS["detalle_asistencia"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_asistencia"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_asistencia', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("detalle_asistencialist.php"));
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
		$this->Dias->SetVisibility();
		$this->Horario->SetVisibility();
		$this->Rol->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Id_Asistencia->SetVisibility();

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
		global $EW_EXPORT, $detalle_asistencia;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detalle_asistencia);
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
			$this->Page_Terminate("detalle_asistencialist.php"); // No records selected, return to list
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
					$this->Dias->setDbValue($this->Recordset->fields('Dias'));
					$this->Horario->setDbValue($this->Recordset->fields('Horario'));
					$this->Rol->setDbValue($this->Recordset->fields('Rol'));
					$this->Observacion->setDbValue($this->Recordset->fields('Observacion'));
					$this->Id_Asistencia->setDbValue($this->Recordset->fields('Id_Asistencia'));
				} else {
					if (!ew_CompareValue($this->Dias->DbValue, $this->Recordset->fields('Dias')))
						$this->Dias->CurrentValue = NULL;
					if (!ew_CompareValue($this->Horario->DbValue, $this->Recordset->fields('Horario')))
						$this->Horario->CurrentValue = NULL;
					if (!ew_CompareValue($this->Rol->DbValue, $this->Recordset->fields('Rol')))
						$this->Rol->CurrentValue = NULL;
					if (!ew_CompareValue($this->Observacion->DbValue, $this->Recordset->fields('Observacion')))
						$this->Observacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Asistencia->DbValue, $this->Recordset->fields('Id_Asistencia')))
						$this->Id_Asistencia->CurrentValue = NULL;
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
		$this->Dia->CurrentValue = $sKeyFld;
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
		if (!$this->Dias->FldIsDetailKey) {
			$this->Dias->setFormValue($objForm->GetValue("x_Dias"));
		}
		$this->Dias->MultiUpdate = $objForm->GetValue("u_Dias");
		if (!$this->Horario->FldIsDetailKey) {
			$this->Horario->setFormValue($objForm->GetValue("x_Horario"));
		}
		$this->Horario->MultiUpdate = $objForm->GetValue("u_Horario");
		if (!$this->Rol->FldIsDetailKey) {
			$this->Rol->setFormValue($objForm->GetValue("x_Rol"));
		}
		$this->Rol->MultiUpdate = $objForm->GetValue("u_Rol");
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->MultiUpdate = $objForm->GetValue("u_Observacion");
		if (!$this->Id_Asistencia->FldIsDetailKey) {
			$this->Id_Asistencia->setFormValue($objForm->GetValue("x_Id_Asistencia"));
		}
		$this->Id_Asistencia->MultiUpdate = $objForm->GetValue("u_Id_Asistencia");
		if (!$this->Dia->FldIsDetailKey)
			$this->Dia->setFormValue($objForm->GetValue("x_Dia"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Dia->CurrentValue = $this->Dia->FormValue;
		$this->Dias->CurrentValue = $this->Dias->FormValue;
		$this->Horario->CurrentValue = $this->Horario->FormValue;
		$this->Rol->CurrentValue = $this->Rol->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Id_Asistencia->CurrentValue = $this->Id_Asistencia->FormValue;
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
		$this->Dia->setDbValue($rs->fields('Dia'));
		$this->Dias->setDbValue($rs->fields('Dias'));
		$this->Horario->setDbValue($rs->fields('Horario'));
		$this->Rol->setDbValue($rs->fields('Rol'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Id_Asistencia->setDbValue($rs->fields('Id_Asistencia'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Dia->DbValue = $row['Dia'];
		$this->Dias->DbValue = $row['Dias'];
		$this->Horario->DbValue = $row['Horario'];
		$this->Rol->DbValue = $row['Rol'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Id_Asistencia->DbValue = $row['Id_Asistencia'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Dia
		// Dias
		// Horario
		// Rol
		// Observacion
		// Id_Asistencia

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dia
		if (strval($this->Dia->CurrentValue) <> "") {
			$this->Dia->ViewValue = $this->Dia->OptionCaption($this->Dia->CurrentValue);
		} else {
			$this->Dia->ViewValue = NULL;
		}
		$this->Dia->ViewCustomAttributes = "";

		// Dias
		$this->Dias->ViewValue = $this->Dias->CurrentValue;
		$this->Dias->ViewCustomAttributes = "";

		// Horario
		$this->Horario->ViewValue = $this->Horario->CurrentValue;
		$this->Horario->ViewCustomAttributes = "";

		// Rol
		$this->Rol->ViewValue = $this->Rol->CurrentValue;
		$this->Rol->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Asistencia
		$this->Id_Asistencia->ViewValue = $this->Id_Asistencia->CurrentValue;
		$this->Id_Asistencia->ViewCustomAttributes = "";

			// Dias
			$this->Dias->LinkCustomAttributes = "";
			$this->Dias->HrefValue = "";
			$this->Dias->TooltipValue = "";

			// Horario
			$this->Horario->LinkCustomAttributes = "";
			$this->Horario->HrefValue = "";
			$this->Horario->TooltipValue = "";

			// Rol
			$this->Rol->LinkCustomAttributes = "";
			$this->Rol->HrefValue = "";
			$this->Rol->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Id_Asistencia
			$this->Id_Asistencia->LinkCustomAttributes = "";
			$this->Id_Asistencia->HrefValue = "";
			$this->Id_Asistencia->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Dias
			$this->Dias->EditAttrs["class"] = "form-control";
			$this->Dias->EditCustomAttributes = "";
			$this->Dias->EditValue = ew_HtmlEncode($this->Dias->CurrentValue);
			$this->Dias->PlaceHolder = ew_RemoveHtml($this->Dias->FldCaption());

			// Horario
			$this->Horario->EditAttrs["class"] = "form-control";
			$this->Horario->EditCustomAttributes = "";
			$this->Horario->EditValue = ew_HtmlEncode($this->Horario->CurrentValue);
			$this->Horario->PlaceHolder = ew_RemoveHtml($this->Horario->FldCaption());

			// Rol
			$this->Rol->EditAttrs["class"] = "form-control";
			$this->Rol->EditCustomAttributes = "";
			$this->Rol->EditValue = ew_HtmlEncode($this->Rol->CurrentValue);
			$this->Rol->PlaceHolder = ew_RemoveHtml($this->Rol->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Asistencia
			$this->Id_Asistencia->EditAttrs["class"] = "form-control";
			$this->Id_Asistencia->EditCustomAttributes = "";
			$this->Id_Asistencia->EditValue = ew_HtmlEncode($this->Id_Asistencia->CurrentValue);
			$this->Id_Asistencia->PlaceHolder = ew_RemoveHtml($this->Id_Asistencia->FldCaption());

			// Edit refer script
			// Dias

			$this->Dias->LinkCustomAttributes = "";
			$this->Dias->HrefValue = "";

			// Horario
			$this->Horario->LinkCustomAttributes = "";
			$this->Horario->HrefValue = "";

			// Rol
			$this->Rol->LinkCustomAttributes = "";
			$this->Rol->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Id_Asistencia
			$this->Id_Asistencia->LinkCustomAttributes = "";
			$this->Id_Asistencia->HrefValue = "";
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
		if ($this->Dias->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Horario->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Rol->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Observacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Asistencia->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Id_Asistencia->MultiUpdate <> "" && !$this->Id_Asistencia->FldIsDetailKey && !is_null($this->Id_Asistencia->FormValue) && $this->Id_Asistencia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Asistencia->FldCaption(), $this->Id_Asistencia->ReqErrMsg));
		}
		if ($this->Id_Asistencia->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Id_Asistencia->FormValue)) {
				ew_AddMessage($gsFormError, $this->Id_Asistencia->FldErrMsg());
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

			// Dias
			$this->Dias->SetDbValueDef($rsnew, $this->Dias->CurrentValue, NULL, $this->Dias->ReadOnly || $this->Dias->MultiUpdate <> "1");

			// Horario
			$this->Horario->SetDbValueDef($rsnew, $this->Horario->CurrentValue, NULL, $this->Horario->ReadOnly || $this->Horario->MultiUpdate <> "1");

			// Rol
			$this->Rol->SetDbValueDef($rsnew, $this->Rol->CurrentValue, NULL, $this->Rol->ReadOnly || $this->Rol->MultiUpdate <> "1");

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly || $this->Observacion->MultiUpdate <> "1");

			// Id_Asistencia
			$this->Id_Asistencia->SetDbValueDef($rsnew, $this->Id_Asistencia->CurrentValue, 0, $this->Id_Asistencia->ReadOnly || $this->Id_Asistencia->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detalle_asistencialist.php"), "", $this->TableVar, TRUE);
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
		$table = 'detalle_asistencia';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'detalle_asistencia';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Dia'];

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
if (!isset($detalle_asistencia_update)) $detalle_asistencia_update = new cdetalle_asistencia_update();

// Page init
$detalle_asistencia_update->Page_Init();

// Page main
$detalle_asistencia_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_asistencia_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fdetalle_asistenciaupdate = new ew_Form("fdetalle_asistenciaupdate", "update");

// Validate form
fdetalle_asistenciaupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Asistencia");
			uelm = this.GetElements("u" + infix + "_Id_Asistencia");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_asistencia->Id_Asistencia->FldCaption(), $detalle_asistencia->Id_Asistencia->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Asistencia");
			uelm = this.GetElements("u" + infix + "_Id_Asistencia");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_asistencia->Id_Asistencia->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdetalle_asistenciaupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_asistenciaupdate.ValidateRequired = true;
<?php } else { ?>
fdetalle_asistenciaupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detalle_asistencia_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detalle_asistencia_update->ShowPageHeader(); ?>
<?php
$detalle_asistencia_update->ShowMessage();
?>
<form name="fdetalle_asistenciaupdate" id="fdetalle_asistenciaupdate" class="<?php echo $detalle_asistencia_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_asistencia_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_asistencia_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_asistencia">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($detalle_asistencia_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($detalle_asistencia_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_detalle_asistenciaupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
	<div id="r_Dias" class="form-group">
		<label for="x_Dias" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dias" id="u_Dias" value="1"<?php echo ($detalle_asistencia->Dias->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $detalle_asistencia->Dias->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_asistencia->Dias->CellAttributes() ?>>
<span id="el_detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x_Dias" id="x_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
<?php echo $detalle_asistencia->Dias->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
	<div id="r_Horario" class="form-group">
		<label for="x_Horario" class="col-sm-2 control-label">
<input type="checkbox" name="u_Horario" id="u_Horario" value="1"<?php echo ($detalle_asistencia->Horario->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $detalle_asistencia->Horario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_asistencia->Horario->CellAttributes() ?>>
<span id="el_detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x_Horario" id="x_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
<?php echo $detalle_asistencia->Horario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
	<div id="r_Rol" class="form-group">
		<label for="x_Rol" class="col-sm-2 control-label">
<input type="checkbox" name="u_Rol" id="u_Rol" value="1"<?php echo ($detalle_asistencia->Rol->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $detalle_asistencia->Rol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_asistencia->Rol->CellAttributes() ?>>
<span id="el_detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x_Rol" id="x_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
<?php echo $detalle_asistencia->Rol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Observacion" id="u_Observacion" value="1"<?php echo ($detalle_asistencia->Observacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $detalle_asistencia->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_asistencia->Observacion->CellAttributes() ?>>
<span id="el_detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
<?php echo $detalle_asistencia->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
	<div id="r_Id_Asistencia" class="form-group">
		<label for="x_Id_Asistencia" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Asistencia" id="u_Id_Asistencia" value="1"<?php echo ($detalle_asistencia->Id_Asistencia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $detalle_asistencia->Id_Asistencia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detalle_asistencia->Id_Asistencia->CellAttributes() ?>>
<span id="el_detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x_Id_Asistencia" id="x_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
<?php echo $detalle_asistencia->Id_Asistencia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$detalle_asistencia_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $detalle_asistencia_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fdetalle_asistenciaupdate.Init();
</script>
<?php
$detalle_asistencia_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detalle_asistencia_update->Page_Terminate();
?>
