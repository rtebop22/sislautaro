<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$register = NULL; // Initialize page object first

class cregister extends cusuarios {

	// Page ID
	var $PageID = 'register';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Page object name
	var $PageObjName = 'register';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
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

		// Table object (usuarios)
		if (!isset($GLOBALS["usuarios"]) || get_class($GLOBALS["usuarios"]) == "cusuarios") {
			$GLOBALS["usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuarios"];
		}
		if (!isset($GLOBALS["usuarios"])) $GLOBALS["usuarios"] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'register', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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
	var $FormClassName = "form-horizontal ewForm ewRegisterForm";

	//
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Security, $Language, $gsLanguage, $gsFormError, $objForm;
		global $Breadcrumb;

		// Set up Breadcrumb
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("register", "RegisterPage", $url, "", "", TRUE);
		$bUserExists = FALSE;
		if (@$_POST["a_register"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_register"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add

				// Check for duplicate User ID
				$sFilter = str_replace("%u", ew_AdjustSql($this->User->CurrentValue, EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);

				// Set up filter (SQL WHERE clause) and get return SQL
				// SQL constructor in usuarios class, usuariosinfo.php

				$this->CurrentFilter = $sFilter;
				$sUserSql = $this->SQL();
				if ($rs = $UserTableConn->Execute($sUserSql)) {
					if (!$rs->EOF) {
						$bUserExists = TRUE;
						$this->RestoreFormValues(); // Restore form values
						$this->setFailureMessage($Language->Phrase("UserExists")); // Set user exist message
					}
					$rs->Close();
				}
				if (!$bUserExists) {
					$this->SendEmail = TRUE; // Send email on add success
					if ($this->AddRow()) { // Add record
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("RegisterSuccess")); // Register success
						$this->Page_Terminate("login.php"); // Return
					} else {
						$this->RestoreFormValues(); // Restore form values
					}
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->User->CurrentValue = NULL;
		$this->User->OldValue = $this->User->CurrentValue;
		$this->Pass->CurrentValue = NULL;
		$this->Pass->OldValue = $this->Pass->CurrentValue;
		$this->Id_Grupo->CurrentValue = NULL;
		$this->Id_Grupo->OldValue = $this->Id_Grupo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->User->FldIsDetailKey) {
			$this->User->setFormValue($objForm->GetValue("x_User"));
		}
		if (!$this->Pass->FldIsDetailKey) {
			$this->Pass->setFormValue($objForm->GetValue("x_Pass"));
		}
		$this->Pass->ConfirmValue = $objForm->GetValue("c_Pass");
		if (!$this->Id_Grupo->FldIsDetailKey) {
			$this->Id_Grupo->setFormValue($objForm->GetValue("x_Id_Grupo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->User->CurrentValue = $this->User->FormValue;
		$this->Pass->CurrentValue = $this->Pass->FormValue;
		$this->Id_Grupo->CurrentValue = $this->Id_Grupo->FormValue;
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
		$this->User->setDbValue($rs->fields('User'));
		$this->Pass->setDbValue($rs->fields('Pass'));
		$this->Id_Grupo->setDbValue($rs->fields('Id_Grupo'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->User->DbValue = $row['User'];
		$this->Pass->DbValue = $row['Pass'];
		$this->Id_Grupo->DbValue = $row['Id_Grupo'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// User
		// Pass
		// Id_Grupo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// User
		$this->User->ViewValue = $this->User->CurrentValue;
		$this->User->ViewCustomAttributes = "";

		// Pass
		$this->Pass->ViewValue = $Language->Phrase("PasswordMask");
		$this->Pass->ViewCustomAttributes = "";

		// Id_Grupo
		if (strval($this->Id_Grupo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Grupo`" . ew_SearchString("=", $this->Id_Grupo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Grupo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_user`";
		$sWhereWrk = "";
		$this->Id_Grupo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Grupo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Grupo->ViewValue = $this->Id_Grupo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Grupo->ViewValue = $this->Id_Grupo->CurrentValue;
			}
		} else {
			$this->Id_Grupo->ViewValue = NULL;
		}
		$this->Id_Grupo->ViewCustomAttributes = "";

			// User
			$this->User->LinkCustomAttributes = "";
			$this->User->HrefValue = "";
			$this->User->TooltipValue = "";

			// Pass
			$this->Pass->LinkCustomAttributes = "";
			$this->Pass->HrefValue = "";
			$this->Pass->TooltipValue = "";

			// Id_Grupo
			$this->Id_Grupo->LinkCustomAttributes = "";
			$this->Id_Grupo->HrefValue = "";
			$this->Id_Grupo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// User
			$this->User->EditAttrs["class"] = "form-control";
			$this->User->EditCustomAttributes = "";
			$this->User->EditValue = ew_HtmlEncode($this->User->CurrentValue);
			$this->User->PlaceHolder = ew_RemoveHtml($this->User->FldCaption());

			// Pass
			$this->Pass->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Pass->EditCustomAttributes = "";
			$this->Pass->EditValue = ew_HtmlEncode($this->Pass->CurrentValue);
			$this->Pass->PlaceHolder = ew_RemoveHtml($this->Pass->FldCaption());

			// Id_Grupo
			$this->Id_Grupo->EditAttrs["class"] = "form-control";
			$this->Id_Grupo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Grupo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Grupo`" . ew_SearchString("=", $this->Id_Grupo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Grupo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_user`";
			$sWhereWrk = "";
			$this->Id_Grupo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Grupo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Grupo->EditValue = $arwrk;

			// Add refer script
			// User

			$this->User->LinkCustomAttributes = "";
			$this->User->HrefValue = "";

			// Pass
			$this->Pass->LinkCustomAttributes = "";
			$this->Pass->HrefValue = "";

			// Id_Grupo
			$this->Id_Grupo->LinkCustomAttributes = "";
			$this->Id_Grupo->HrefValue = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->User->FldIsDetailKey && !is_null($this->User->FormValue) && $this->User->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterUserName"));
		}
		if (!$this->Pass->FldIsDetailKey && !is_null($this->Pass->FormValue) && $this->Pass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterPassword"));
		}
		if (!$this->Id_Grupo->FldIsDetailKey && !is_null($this->Id_Grupo->FormValue) && $this->Id_Grupo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Grupo->FldCaption(), $this->Id_Grupo->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->User->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->User->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->User->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}

		// Check if valid parent user id
		$bValidParentUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->User->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidParentUser = $Security->IsValidUserID($this->User->CurrentValue);
			if (!$bValidParentUser) {
				$sParentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedParentUserID"));
				$sParentUserIdMsg = str_replace("%p", $this->User->CurrentValue, $sParentUserIdMsg);
				$this->setFailureMessage($sParentUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// User
		$this->User->SetDbValueDef($rsnew, $this->User->CurrentValue, "", FALSE);

		// Pass
		$this->Pass->SetDbValueDef($rsnew, $this->Pass->CurrentValue, NULL, FALSE);

		// Id_Grupo
		$this->Id_Grupo->SetDbValueDef($rsnew, $this->Id_Grupo->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['User']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);

			// Call User Registered event
			$this->User_Registered($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Grupo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Grupo` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_user`";
			$sWhereWrk = "";
			$this->Id_Grupo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Grupo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Grupo, $sWhereWrk); // Call Lookup selecting
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

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

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User Registered event
	function User_Registered(&$rs) {

	  //echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

	  //echo "User_Activated";
	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($register)) $register = new cregister();

// Page init
$register->Page_Init();

// Page main
$register->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "register";
var CurrentForm = fregister = new ew_Form("fregister", "register");

// Validate form
fregister.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_User");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterUserName"));
			elm = this.GetElements("x" + infix + "_Pass");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterPassword"));
			elm = this.GetElements("x" + infix + "_Pass");
			if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
				return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));
			if (fobj.c_Pass.value != fobj.x_Pass.value)
				return this.OnError(fobj.c_Pass, ewLanguage.Phrase("MismatchPassword"));
			elm = this.GetElements("x" + infix + "_Id_Grupo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $usuarios->Id_Grupo->FldCaption(), $usuarios->Id_Grupo->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fregister.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fregister.ValidateRequired = true;
<?php } else { ?>
fregister.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fregister.Lists["x_Id_Grupo"] = {"LinkField":"x_Id_Grupo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"grupo_user"};

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
<?php $register->ShowPageHeader(); ?>
<?php
$register->ShowMessage();
?>
<form name="fregister" id="fregister" class="<?php echo $register->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($register->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $register->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="a_register" id="a_register" value="A">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($usuarios->User->Visible) { // User ?>
	<div id="r_User" class="form-group">
		<label id="elh_usuarios_User" for="x_User" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->User->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->User->CellAttributes() ?>>
<span id="el_usuarios_User">
<input type="text" data-table="usuarios" data-field="x_User" name="x_User" id="x_User" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($usuarios->User->getPlaceHolder()) ?>" value="<?php echo $usuarios->User->EditValue ?>"<?php echo $usuarios->User->EditAttributes() ?>>
</span>
<?php echo $usuarios->User->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Pass->Visible) { // Pass ?>
	<div id="r_Pass" class="form-group">
		<label id="elh_usuarios_Pass" for="x_Pass" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->Pass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->Pass->CellAttributes() ?>>
<span id="el_usuarios_Pass">
<div class="input-group" id="ig_Pass">
<input type="password" data-password-strength="pst_Pass" data-password-generated="pgt_Pass" data-table="usuarios" data-field="x_Pass" name="x_Pass" id="x_Pass" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($usuarios->Pass->getPlaceHolder()) ?>"<?php echo $usuarios->Pass->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_Pass" data-password-confirm="c_Pass" data-password-strength="pst_Pass" data-password-generated="pgt_Pass"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_Pass" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_Pass" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $usuarios->Pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Pass->Visible) { // Pass ?>
	<div id="r_c_Pass" class="form-group">
		<label id="elh_c_usuarios_Pass" for="c_Pass" class="col-sm-2 control-label ewLabel"><?php echo $Language->Phrase("Confirm") ?> <?php echo $usuarios->Pass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->Pass->CellAttributes() ?>>
<span id="el_c_usuarios_Pass">
<input type="password" data-field="c_Pass" name="c_Pass" id="c_Pass" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($usuarios->Pass->getPlaceHolder()) ?>"<?php echo $usuarios->Pass->EditAttributes() ?>>
</span>
</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Id_Grupo->Visible) { // Id_Grupo ?>
	<div id="r_Id_Grupo" class="form-group">
		<label id="elh_usuarios_Id_Grupo" for="x_Id_Grupo" class="col-sm-2 control-label ewLabel"><?php echo $usuarios->Id_Grupo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $usuarios->Id_Grupo->CellAttributes() ?>>
<span id="el_usuarios_Id_Grupo">
<select data-table="usuarios" data-field="x_Id_Grupo" data-value-separator="<?php echo $usuarios->Id_Grupo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Grupo" name="x_Id_Grupo"<?php echo $usuarios->Id_Grupo->EditAttributes() ?>>
<?php echo $usuarios->Id_Grupo->SelectOptionListHtml("x_Id_Grupo") ?>
</select>
<input type="hidden" name="s_x_Id_Grupo" id="s_x_Id_Grupo" value="<?php echo $usuarios->Id_Grupo->LookupFilterQuery() ?>">
</span>
<?php echo $usuarios->Id_Grupo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("RegisterBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fregister.Init();
</script>
<?php
$register->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$register->Page_Terminate();
?>
