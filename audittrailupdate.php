<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "audittrailinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$audittrail_update = NULL; // Initialize page object first

class caudittrail_update extends caudittrail {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'audittrail';

	// Page object name
	var $PageObjName = 'audittrail_update';

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

		// Table object (audittrail)
		if (!isset($GLOBALS["audittrail"]) || get_class($GLOBALS["audittrail"]) == "caudittrail") {
			$GLOBALS["audittrail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["audittrail"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'audittrail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("audittraillist.php"));
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
		$this->datetime->SetVisibility();
		$this->script->SetVisibility();
		$this->user->SetVisibility();
		$this->action->SetVisibility();
		$this->_table->SetVisibility();
		$this->_field->SetVisibility();
		$this->keyvalue->SetVisibility();
		$this->oldvalue->SetVisibility();
		$this->newvalue->SetVisibility();

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
		global $EW_EXPORT, $audittrail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($audittrail);
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
			$this->Page_Terminate("audittraillist.php"); // No records selected, return to list
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
					$this->datetime->setDbValue($this->Recordset->fields('datetime'));
					$this->script->setDbValue($this->Recordset->fields('script'));
					$this->user->setDbValue($this->Recordset->fields('user'));
					$this->action->setDbValue($this->Recordset->fields('action'));
					$this->_table->setDbValue($this->Recordset->fields('table'));
					$this->_field->setDbValue($this->Recordset->fields('field'));
					$this->keyvalue->setDbValue($this->Recordset->fields('keyvalue'));
					$this->oldvalue->setDbValue($this->Recordset->fields('oldvalue'));
					$this->newvalue->setDbValue($this->Recordset->fields('newvalue'));
				} else {
					if (!ew_CompareValue($this->datetime->DbValue, $this->Recordset->fields('datetime')))
						$this->datetime->CurrentValue = NULL;
					if (!ew_CompareValue($this->script->DbValue, $this->Recordset->fields('script')))
						$this->script->CurrentValue = NULL;
					if (!ew_CompareValue($this->user->DbValue, $this->Recordset->fields('user')))
						$this->user->CurrentValue = NULL;
					if (!ew_CompareValue($this->action->DbValue, $this->Recordset->fields('action')))
						$this->action->CurrentValue = NULL;
					if (!ew_CompareValue($this->_table->DbValue, $this->Recordset->fields('table')))
						$this->_table->CurrentValue = NULL;
					if (!ew_CompareValue($this->_field->DbValue, $this->Recordset->fields('field')))
						$this->_field->CurrentValue = NULL;
					if (!ew_CompareValue($this->keyvalue->DbValue, $this->Recordset->fields('keyvalue')))
						$this->keyvalue->CurrentValue = NULL;
					if (!ew_CompareValue($this->oldvalue->DbValue, $this->Recordset->fields('oldvalue')))
						$this->oldvalue->CurrentValue = NULL;
					if (!ew_CompareValue($this->newvalue->DbValue, $this->Recordset->fields('newvalue')))
						$this->newvalue->CurrentValue = NULL;
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
		$this->id->CurrentValue = $sKeyFld;
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
		if (!$this->datetime->FldIsDetailKey) {
			$this->datetime->setFormValue($objForm->GetValue("x_datetime"));
			$this->datetime->CurrentValue = ew_UnFormatDateTime($this->datetime->CurrentValue, 0);
		}
		$this->datetime->MultiUpdate = $objForm->GetValue("u_datetime");
		if (!$this->script->FldIsDetailKey) {
			$this->script->setFormValue($objForm->GetValue("x_script"));
		}
		$this->script->MultiUpdate = $objForm->GetValue("u_script");
		if (!$this->user->FldIsDetailKey) {
			$this->user->setFormValue($objForm->GetValue("x_user"));
		}
		$this->user->MultiUpdate = $objForm->GetValue("u_user");
		if (!$this->action->FldIsDetailKey) {
			$this->action->setFormValue($objForm->GetValue("x_action"));
		}
		$this->action->MultiUpdate = $objForm->GetValue("u_action");
		if (!$this->_table->FldIsDetailKey) {
			$this->_table->setFormValue($objForm->GetValue("x__table"));
		}
		$this->_table->MultiUpdate = $objForm->GetValue("u__table");
		if (!$this->_field->FldIsDetailKey) {
			$this->_field->setFormValue($objForm->GetValue("x__field"));
		}
		$this->_field->MultiUpdate = $objForm->GetValue("u__field");
		if (!$this->keyvalue->FldIsDetailKey) {
			$this->keyvalue->setFormValue($objForm->GetValue("x_keyvalue"));
		}
		$this->keyvalue->MultiUpdate = $objForm->GetValue("u_keyvalue");
		if (!$this->oldvalue->FldIsDetailKey) {
			$this->oldvalue->setFormValue($objForm->GetValue("x_oldvalue"));
		}
		$this->oldvalue->MultiUpdate = $objForm->GetValue("u_oldvalue");
		if (!$this->newvalue->FldIsDetailKey) {
			$this->newvalue->setFormValue($objForm->GetValue("x_newvalue"));
		}
		$this->newvalue->MultiUpdate = $objForm->GetValue("u_newvalue");
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->datetime->CurrentValue = $this->datetime->FormValue;
		$this->datetime->CurrentValue = ew_UnFormatDateTime($this->datetime->CurrentValue, 0);
		$this->script->CurrentValue = $this->script->FormValue;
		$this->user->CurrentValue = $this->user->FormValue;
		$this->action->CurrentValue = $this->action->FormValue;
		$this->_table->CurrentValue = $this->_table->FormValue;
		$this->_field->CurrentValue = $this->_field->FormValue;
		$this->keyvalue->CurrentValue = $this->keyvalue->FormValue;
		$this->oldvalue->CurrentValue = $this->oldvalue->FormValue;
		$this->newvalue->CurrentValue = $this->newvalue->FormValue;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->datetime->setDbValue($rs->fields('datetime'));
		$this->script->setDbValue($rs->fields('script'));
		$this->user->setDbValue($rs->fields('user'));
		$this->action->setDbValue($rs->fields('action'));
		$this->_table->setDbValue($rs->fields('table'));
		$this->_field->setDbValue($rs->fields('field'));
		$this->keyvalue->setDbValue($rs->fields('keyvalue'));
		$this->oldvalue->setDbValue($rs->fields('oldvalue'));
		$this->newvalue->setDbValue($rs->fields('newvalue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->datetime->DbValue = $row['datetime'];
		$this->script->DbValue = $row['script'];
		$this->user->DbValue = $row['user'];
		$this->action->DbValue = $row['action'];
		$this->_table->DbValue = $row['table'];
		$this->_field->DbValue = $row['field'];
		$this->keyvalue->DbValue = $row['keyvalue'];
		$this->oldvalue->DbValue = $row['oldvalue'];
		$this->newvalue->DbValue = $row['newvalue'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// datetime
		// script
		// user
		// action
		// table
		// field
		// keyvalue
		// oldvalue
		// newvalue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// datetime
		$this->datetime->ViewValue = $this->datetime->CurrentValue;
		$this->datetime->ViewValue = ew_FormatDateTime($this->datetime->ViewValue, 0);
		$this->datetime->ViewCustomAttributes = "";

		// script
		$this->script->ViewValue = $this->script->CurrentValue;
		$this->script->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// action
		$this->action->ViewValue = $this->action->CurrentValue;
		$this->action->ViewCustomAttributes = "";

		// table
		$this->_table->ViewValue = $this->_table->CurrentValue;
		$this->_table->ViewCustomAttributes = "";

		// field
		$this->_field->ViewValue = $this->_field->CurrentValue;
		$this->_field->ViewCustomAttributes = "";

		// keyvalue
		$this->keyvalue->ViewValue = $this->keyvalue->CurrentValue;
		$this->keyvalue->ViewCustomAttributes = "";

		// oldvalue
		$this->oldvalue->ViewValue = $this->oldvalue->CurrentValue;
		$this->oldvalue->ViewCustomAttributes = "";

		// newvalue
		$this->newvalue->ViewValue = $this->newvalue->CurrentValue;
		$this->newvalue->ViewCustomAttributes = "";

			// datetime
			$this->datetime->LinkCustomAttributes = "";
			$this->datetime->HrefValue = "";
			$this->datetime->TooltipValue = "";

			// script
			$this->script->LinkCustomAttributes = "";
			$this->script->HrefValue = "";
			$this->script->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// action
			$this->action->LinkCustomAttributes = "";
			$this->action->HrefValue = "";
			$this->action->TooltipValue = "";

			// table
			$this->_table->LinkCustomAttributes = "";
			$this->_table->HrefValue = "";
			$this->_table->TooltipValue = "";

			// field
			$this->_field->LinkCustomAttributes = "";
			$this->_field->HrefValue = "";
			$this->_field->TooltipValue = "";

			// keyvalue
			$this->keyvalue->LinkCustomAttributes = "";
			$this->keyvalue->HrefValue = "";
			$this->keyvalue->TooltipValue = "";

			// oldvalue
			$this->oldvalue->LinkCustomAttributes = "";
			$this->oldvalue->HrefValue = "";
			$this->oldvalue->TooltipValue = "";

			// newvalue
			$this->newvalue->LinkCustomAttributes = "";
			$this->newvalue->HrefValue = "";
			$this->newvalue->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// datetime
			$this->datetime->EditAttrs["class"] = "form-control";
			$this->datetime->EditCustomAttributes = "";
			$this->datetime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->datetime->CurrentValue, 8));
			$this->datetime->PlaceHolder = ew_RemoveHtml($this->datetime->FldCaption());

			// script
			$this->script->EditAttrs["class"] = "form-control";
			$this->script->EditCustomAttributes = "";
			$this->script->EditValue = ew_HtmlEncode($this->script->CurrentValue);
			$this->script->PlaceHolder = ew_RemoveHtml($this->script->FldCaption());

			// user
			$this->user->EditAttrs["class"] = "form-control";
			$this->user->EditCustomAttributes = "";
			$this->user->EditValue = ew_HtmlEncode($this->user->CurrentValue);
			$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

			// action
			$this->action->EditAttrs["class"] = "form-control";
			$this->action->EditCustomAttributes = "";
			$this->action->EditValue = ew_HtmlEncode($this->action->CurrentValue);
			$this->action->PlaceHolder = ew_RemoveHtml($this->action->FldCaption());

			// table
			$this->_table->EditAttrs["class"] = "form-control";
			$this->_table->EditCustomAttributes = "";
			$this->_table->EditValue = ew_HtmlEncode($this->_table->CurrentValue);
			$this->_table->PlaceHolder = ew_RemoveHtml($this->_table->FldCaption());

			// field
			$this->_field->EditAttrs["class"] = "form-control";
			$this->_field->EditCustomAttributes = "";
			$this->_field->EditValue = ew_HtmlEncode($this->_field->CurrentValue);
			$this->_field->PlaceHolder = ew_RemoveHtml($this->_field->FldCaption());

			// keyvalue
			$this->keyvalue->EditAttrs["class"] = "form-control";
			$this->keyvalue->EditCustomAttributes = "";
			$this->keyvalue->EditValue = ew_HtmlEncode($this->keyvalue->CurrentValue);
			$this->keyvalue->PlaceHolder = ew_RemoveHtml($this->keyvalue->FldCaption());

			// oldvalue
			$this->oldvalue->EditAttrs["class"] = "form-control";
			$this->oldvalue->EditCustomAttributes = "";
			$this->oldvalue->EditValue = ew_HtmlEncode($this->oldvalue->CurrentValue);
			$this->oldvalue->PlaceHolder = ew_RemoveHtml($this->oldvalue->FldCaption());

			// newvalue
			$this->newvalue->EditAttrs["class"] = "form-control";
			$this->newvalue->EditCustomAttributes = "";
			$this->newvalue->EditValue = ew_HtmlEncode($this->newvalue->CurrentValue);
			$this->newvalue->PlaceHolder = ew_RemoveHtml($this->newvalue->FldCaption());

			// Edit refer script
			// datetime

			$this->datetime->LinkCustomAttributes = "";
			$this->datetime->HrefValue = "";

			// script
			$this->script->LinkCustomAttributes = "";
			$this->script->HrefValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";

			// action
			$this->action->LinkCustomAttributes = "";
			$this->action->HrefValue = "";

			// table
			$this->_table->LinkCustomAttributes = "";
			$this->_table->HrefValue = "";

			// field
			$this->_field->LinkCustomAttributes = "";
			$this->_field->HrefValue = "";

			// keyvalue
			$this->keyvalue->LinkCustomAttributes = "";
			$this->keyvalue->HrefValue = "";

			// oldvalue
			$this->oldvalue->LinkCustomAttributes = "";
			$this->oldvalue->HrefValue = "";

			// newvalue
			$this->newvalue->LinkCustomAttributes = "";
			$this->newvalue->HrefValue = "";
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
		if ($this->datetime->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->script->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->user->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->action->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->_table->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->_field->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->keyvalue->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->oldvalue->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->newvalue->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->datetime->MultiUpdate <> "" && !$this->datetime->FldIsDetailKey && !is_null($this->datetime->FormValue) && $this->datetime->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->datetime->FldCaption(), $this->datetime->ReqErrMsg));
		}
		if ($this->datetime->MultiUpdate <> "") {
			if (!ew_CheckDateDef($this->datetime->FormValue)) {
				ew_AddMessage($gsFormError, $this->datetime->FldErrMsg());
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

			// datetime
			$this->datetime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->datetime->CurrentValue, 0), ew_CurrentDate(), $this->datetime->ReadOnly || $this->datetime->MultiUpdate <> "1");

			// script
			$this->script->SetDbValueDef($rsnew, $this->script->CurrentValue, NULL, $this->script->ReadOnly || $this->script->MultiUpdate <> "1");

			// user
			$this->user->SetDbValueDef($rsnew, $this->user->CurrentValue, NULL, $this->user->ReadOnly || $this->user->MultiUpdate <> "1");

			// action
			$this->action->SetDbValueDef($rsnew, $this->action->CurrentValue, NULL, $this->action->ReadOnly || $this->action->MultiUpdate <> "1");

			// table
			$this->_table->SetDbValueDef($rsnew, $this->_table->CurrentValue, NULL, $this->_table->ReadOnly || $this->_table->MultiUpdate <> "1");

			// field
			$this->_field->SetDbValueDef($rsnew, $this->_field->CurrentValue, NULL, $this->_field->ReadOnly || $this->_field->MultiUpdate <> "1");

			// keyvalue
			$this->keyvalue->SetDbValueDef($rsnew, $this->keyvalue->CurrentValue, NULL, $this->keyvalue->ReadOnly || $this->keyvalue->MultiUpdate <> "1");

			// oldvalue
			$this->oldvalue->SetDbValueDef($rsnew, $this->oldvalue->CurrentValue, NULL, $this->oldvalue->ReadOnly || $this->oldvalue->MultiUpdate <> "1");

			// newvalue
			$this->newvalue->SetDbValueDef($rsnew, $this->newvalue->CurrentValue, NULL, $this->newvalue->ReadOnly || $this->newvalue->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("audittraillist.php"), "", $this->TableVar, TRUE);
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
		$table = 'audittrail';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'audittrail';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

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
if (!isset($audittrail_update)) $audittrail_update = new caudittrail_update();

// Page init
$audittrail_update->Page_Init();

// Page main
$audittrail_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$audittrail_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = faudittrailupdate = new ew_Form("faudittrailupdate", "update");

// Validate form
faudittrailupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_datetime");
			uelm = this.GetElements("u" + infix + "_datetime");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $audittrail->datetime->FldCaption(), $audittrail->datetime->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_datetime");
			uelm = this.GetElements("u" + infix + "_datetime");
			if (uelm && uelm.checked && elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($audittrail->datetime->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
faudittrailupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faudittrailupdate.ValidateRequired = true;
<?php } else { ?>
faudittrailupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$audittrail_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $audittrail_update->ShowPageHeader(); ?>
<?php
$audittrail_update->ShowMessage();
?>
<form name="faudittrailupdate" id="faudittrailupdate" class="<?php echo $audittrail_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($audittrail_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $audittrail_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="audittrail">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($audittrail_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($audittrail_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_audittrailupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($audittrail->datetime->Visible) { // datetime ?>
	<div id="r_datetime" class="form-group">
		<label for="x_datetime" class="col-sm-2 control-label">
<input type="checkbox" name="u_datetime" id="u_datetime" value="1"<?php echo ($audittrail->datetime->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->datetime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->datetime->CellAttributes() ?>>
<span id="el_audittrail_datetime">
<input type="text" data-table="audittrail" data-field="x_datetime" name="x_datetime" id="x_datetime" placeholder="<?php echo ew_HtmlEncode($audittrail->datetime->getPlaceHolder()) ?>" value="<?php echo $audittrail->datetime->EditValue ?>"<?php echo $audittrail->datetime->EditAttributes() ?>>
</span>
<?php echo $audittrail->datetime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->script->Visible) { // script ?>
	<div id="r_script" class="form-group">
		<label for="x_script" class="col-sm-2 control-label">
<input type="checkbox" name="u_script" id="u_script" value="1"<?php echo ($audittrail->script->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->script->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->script->CellAttributes() ?>>
<span id="el_audittrail_script">
<input type="text" data-table="audittrail" data-field="x_script" name="x_script" id="x_script" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($audittrail->script->getPlaceHolder()) ?>" value="<?php echo $audittrail->script->EditValue ?>"<?php echo $audittrail->script->EditAttributes() ?>>
</span>
<?php echo $audittrail->script->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->user->Visible) { // user ?>
	<div id="r_user" class="form-group">
		<label for="x_user" class="col-sm-2 control-label">
<input type="checkbox" name="u_user" id="u_user" value="1"<?php echo ($audittrail->user->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->user->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->user->CellAttributes() ?>>
<span id="el_audittrail_user">
<input type="text" data-table="audittrail" data-field="x_user" name="x_user" id="x_user" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($audittrail->user->getPlaceHolder()) ?>" value="<?php echo $audittrail->user->EditValue ?>"<?php echo $audittrail->user->EditAttributes() ?>>
</span>
<?php echo $audittrail->user->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->action->Visible) { // action ?>
	<div id="r_action" class="form-group">
		<label for="x_action" class="col-sm-2 control-label">
<input type="checkbox" name="u_action" id="u_action" value="1"<?php echo ($audittrail->action->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->action->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->action->CellAttributes() ?>>
<span id="el_audittrail_action">
<input type="text" data-table="audittrail" data-field="x_action" name="x_action" id="x_action" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($audittrail->action->getPlaceHolder()) ?>" value="<?php echo $audittrail->action->EditValue ?>"<?php echo $audittrail->action->EditAttributes() ?>>
</span>
<?php echo $audittrail->action->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->_table->Visible) { // table ?>
	<div id="r__table" class="form-group">
		<label for="x__table" class="col-sm-2 control-label">
<input type="checkbox" name="u__table" id="u__table" value="1"<?php echo ($audittrail->_table->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->_table->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->_table->CellAttributes() ?>>
<span id="el_audittrail__table">
<input type="text" data-table="audittrail" data-field="x__table" name="x__table" id="x__table" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($audittrail->_table->getPlaceHolder()) ?>" value="<?php echo $audittrail->_table->EditValue ?>"<?php echo $audittrail->_table->EditAttributes() ?>>
</span>
<?php echo $audittrail->_table->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->_field->Visible) { // field ?>
	<div id="r__field" class="form-group">
		<label for="x__field" class="col-sm-2 control-label">
<input type="checkbox" name="u__field" id="u__field" value="1"<?php echo ($audittrail->_field->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->_field->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->_field->CellAttributes() ?>>
<span id="el_audittrail__field">
<input type="text" data-table="audittrail" data-field="x__field" name="x__field" id="x__field" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($audittrail->_field->getPlaceHolder()) ?>" value="<?php echo $audittrail->_field->EditValue ?>"<?php echo $audittrail->_field->EditAttributes() ?>>
</span>
<?php echo $audittrail->_field->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->keyvalue->Visible) { // keyvalue ?>
	<div id="r_keyvalue" class="form-group">
		<label for="x_keyvalue" class="col-sm-2 control-label">
<input type="checkbox" name="u_keyvalue" id="u_keyvalue" value="1"<?php echo ($audittrail->keyvalue->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->keyvalue->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->keyvalue->CellAttributes() ?>>
<span id="el_audittrail_keyvalue">
<textarea data-table="audittrail" data-field="x_keyvalue" name="x_keyvalue" id="x_keyvalue" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($audittrail->keyvalue->getPlaceHolder()) ?>"<?php echo $audittrail->keyvalue->EditAttributes() ?>><?php echo $audittrail->keyvalue->EditValue ?></textarea>
</span>
<?php echo $audittrail->keyvalue->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->oldvalue->Visible) { // oldvalue ?>
	<div id="r_oldvalue" class="form-group">
		<label for="x_oldvalue" class="col-sm-2 control-label">
<input type="checkbox" name="u_oldvalue" id="u_oldvalue" value="1"<?php echo ($audittrail->oldvalue->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->oldvalue->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->oldvalue->CellAttributes() ?>>
<span id="el_audittrail_oldvalue">
<textarea data-table="audittrail" data-field="x_oldvalue" name="x_oldvalue" id="x_oldvalue" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($audittrail->oldvalue->getPlaceHolder()) ?>"<?php echo $audittrail->oldvalue->EditAttributes() ?>><?php echo $audittrail->oldvalue->EditValue ?></textarea>
</span>
<?php echo $audittrail->oldvalue->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($audittrail->newvalue->Visible) { // newvalue ?>
	<div id="r_newvalue" class="form-group">
		<label for="x_newvalue" class="col-sm-2 control-label">
<input type="checkbox" name="u_newvalue" id="u_newvalue" value="1"<?php echo ($audittrail->newvalue->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $audittrail->newvalue->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $audittrail->newvalue->CellAttributes() ?>>
<span id="el_audittrail_newvalue">
<textarea data-table="audittrail" data-field="x_newvalue" name="x_newvalue" id="x_newvalue" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($audittrail->newvalue->getPlaceHolder()) ?>"<?php echo $audittrail->newvalue->EditAttributes() ?>><?php echo $audittrail->newvalue->EditValue ?></textarea>
</span>
<?php echo $audittrail->newvalue->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$audittrail_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $audittrail_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
faudittrailupdate.Init();
</script>
<?php
$audittrail_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$audittrail_update->Page_Terminate();
?>
