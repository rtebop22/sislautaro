<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "denuncia_robo_equipoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$denuncia_robo_equipo_update = NULL; // Initialize page object first

class cdenuncia_robo_equipo_update extends cdenuncia_robo_equipo {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'denuncia_robo_equipo';

	// Page object name
	var $PageObjName = 'denuncia_robo_equipo_update';

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

		// Table object (denuncia_robo_equipo)
		if (!isset($GLOBALS["denuncia_robo_equipo"]) || get_class($GLOBALS["denuncia_robo_equipo"]) == "cdenuncia_robo_equipo") {
			$GLOBALS["denuncia_robo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["denuncia_robo_equipo"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'denuncia_robo_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("denuncia_robo_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NroSerie->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Quien_Denuncia->SetVisibility();
		$this->DetalleDenuncia->SetVisibility();
		$this->Fecha_Denuncia->SetVisibility();
		$this->Id_Estado_Den->SetVisibility();

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
		global $EW_EXPORT, $denuncia_robo_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($denuncia_robo_equipo);
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
			$this->Page_Terminate("denuncia_robo_equipolist.php"); // No records selected, return to list
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
					$this->NroSerie->setDbValue($this->Recordset->fields('NroSerie'));
					$this->Dni->setDbValue($this->Recordset->fields('Dni'));
					$this->Dni_Tutor->setDbValue($this->Recordset->fields('Dni_Tutor'));
					$this->Quien_Denuncia->setDbValue($this->Recordset->fields('Quien_Denuncia'));
					$this->DetalleDenuncia->setDbValue($this->Recordset->fields('DetalleDenuncia'));
					$this->Fecha_Denuncia->setDbValue($this->Recordset->fields('Fecha_Denuncia'));
					$this->Id_Estado_Den->setDbValue($this->Recordset->fields('Id_Estado_Den'));
				} else {
					if (!ew_CompareValue($this->NroSerie->DbValue, $this->Recordset->fields('NroSerie')))
						$this->NroSerie->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni->DbValue, $this->Recordset->fields('Dni')))
						$this->Dni->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni_Tutor->DbValue, $this->Recordset->fields('Dni_Tutor')))
						$this->Dni_Tutor->CurrentValue = NULL;
					if (!ew_CompareValue($this->Quien_Denuncia->DbValue, $this->Recordset->fields('Quien_Denuncia')))
						$this->Quien_Denuncia->CurrentValue = NULL;
					if (!ew_CompareValue($this->DetalleDenuncia->DbValue, $this->Recordset->fields('DetalleDenuncia')))
						$this->DetalleDenuncia->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Denuncia->DbValue, $this->Recordset->fields('Fecha_Denuncia')))
						$this->Fecha_Denuncia->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado_Den->DbValue, $this->Recordset->fields('Id_Estado_Den')))
						$this->Id_Estado_Den->CurrentValue = NULL;
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
		$this->IdDenuncia->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();

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
		} else {
			$conn->RollbackTrans(); // Rollback transaction
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
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->MultiUpdate = $objForm->GetValue("u_NroSerie");
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->MultiUpdate = $objForm->GetValue("u_Dni");
		if (!$this->Dni_Tutor->FldIsDetailKey) {
			$this->Dni_Tutor->setFormValue($objForm->GetValue("x_Dni_Tutor"));
		}
		$this->Dni_Tutor->MultiUpdate = $objForm->GetValue("u_Dni_Tutor");
		if (!$this->Quien_Denuncia->FldIsDetailKey) {
			$this->Quien_Denuncia->setFormValue($objForm->GetValue("x_Quien_Denuncia"));
		}
		$this->Quien_Denuncia->MultiUpdate = $objForm->GetValue("u_Quien_Denuncia");
		if (!$this->DetalleDenuncia->FldIsDetailKey) {
			$this->DetalleDenuncia->setFormValue($objForm->GetValue("x_DetalleDenuncia"));
		}
		$this->DetalleDenuncia->MultiUpdate = $objForm->GetValue("u_DetalleDenuncia");
		if (!$this->Fecha_Denuncia->FldIsDetailKey) {
			$this->Fecha_Denuncia->setFormValue($objForm->GetValue("x_Fecha_Denuncia"));
			$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0);
		}
		$this->Fecha_Denuncia->MultiUpdate = $objForm->GetValue("u_Fecha_Denuncia");
		if (!$this->Id_Estado_Den->FldIsDetailKey) {
			$this->Id_Estado_Den->setFormValue($objForm->GetValue("x_Id_Estado_Den"));
		}
		$this->Id_Estado_Den->MultiUpdate = $objForm->GetValue("u_Id_Estado_Den");
		if (!$this->IdDenuncia->FldIsDetailKey)
			$this->IdDenuncia->setFormValue($objForm->GetValue("x_IdDenuncia"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->IdDenuncia->CurrentValue = $this->IdDenuncia->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->Dni_Tutor->CurrentValue = $this->Dni_Tutor->FormValue;
		$this->Quien_Denuncia->CurrentValue = $this->Quien_Denuncia->FormValue;
		$this->DetalleDenuncia->CurrentValue = $this->DetalleDenuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = $this->Fecha_Denuncia->FormValue;
		$this->Fecha_Denuncia->CurrentValue = ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0);
		$this->Id_Estado_Den->CurrentValue = $this->Id_Estado_Den->FormValue;
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
		$this->IdDenuncia->setDbValue($rs->fields('IdDenuncia'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni_Tutor'));
		$this->Quien_Denuncia->setDbValue($rs->fields('Quien_Denuncia'));
		$this->DetalleDenuncia->setDbValue($rs->fields('DetalleDenuncia'));
		$this->Fecha_Denuncia->setDbValue($rs->fields('Fecha_Denuncia'));
		$this->Id_Estado_Den->setDbValue($rs->fields('Id_Estado_Den'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IdDenuncia->DbValue = $row['IdDenuncia'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Dni_Tutor->DbValue = $row['Dni_Tutor'];
		$this->Quien_Denuncia->DbValue = $row['Quien_Denuncia'];
		$this->DetalleDenuncia->DbValue = $row['DetalleDenuncia'];
		$this->Fecha_Denuncia->DbValue = $row['Fecha_Denuncia'];
		$this->Id_Estado_Den->DbValue = $row['Id_Estado_Den'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IdDenuncia
		// NroSerie
		// Dni
		// Dni_Tutor
		// Quien_Denuncia
		// DetalleDenuncia
		// Fecha_Denuncia
		// Id_Estado_Den

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IdDenuncia
		$this->IdDenuncia->ViewValue = $this->IdDenuncia->CurrentValue;
		$this->IdDenuncia->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Quien_Denuncia
		$this->Quien_Denuncia->ViewValue = $this->Quien_Denuncia->CurrentValue;
		$this->Quien_Denuncia->ViewCustomAttributes = "";

		// DetalleDenuncia
		$this->DetalleDenuncia->ViewValue = $this->DetalleDenuncia->CurrentValue;
		$this->DetalleDenuncia->ViewCustomAttributes = "";

		// Fecha_Denuncia
		$this->Fecha_Denuncia->ViewValue = $this->Fecha_Denuncia->CurrentValue;
		$this->Fecha_Denuncia->ViewValue = ew_FormatDateTime($this->Fecha_Denuncia->ViewValue, 0);
		$this->Fecha_Denuncia->ViewCustomAttributes = "";

		// Id_Estado_Den
		$this->Id_Estado_Den->ViewValue = $this->Id_Estado_Den->CurrentValue;
		$this->Id_Estado_Den->ViewCustomAttributes = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Quien_Denuncia
			$this->Quien_Denuncia->LinkCustomAttributes = "";
			$this->Quien_Denuncia->HrefValue = "";
			$this->Quien_Denuncia->TooltipValue = "";

			// DetalleDenuncia
			$this->DetalleDenuncia->LinkCustomAttributes = "";
			$this->DetalleDenuncia->HrefValue = "";
			$this->DetalleDenuncia->TooltipValue = "";

			// Fecha_Denuncia
			$this->Fecha_Denuncia->LinkCustomAttributes = "";
			$this->Fecha_Denuncia->HrefValue = "";
			$this->Fecha_Denuncia->TooltipValue = "";

			// Id_Estado_Den
			$this->Id_Estado_Den->LinkCustomAttributes = "";
			$this->Id_Estado_Den->HrefValue = "";
			$this->Id_Estado_Den->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->CurrentValue);
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// Quien_Denuncia
			$this->Quien_Denuncia->EditAttrs["class"] = "form-control";
			$this->Quien_Denuncia->EditCustomAttributes = "";
			$this->Quien_Denuncia->EditValue = ew_HtmlEncode($this->Quien_Denuncia->CurrentValue);
			$this->Quien_Denuncia->PlaceHolder = ew_RemoveHtml($this->Quien_Denuncia->FldCaption());

			// DetalleDenuncia
			$this->DetalleDenuncia->EditAttrs["class"] = "form-control";
			$this->DetalleDenuncia->EditCustomAttributes = "";
			$this->DetalleDenuncia->EditValue = ew_HtmlEncode($this->DetalleDenuncia->CurrentValue);
			$this->DetalleDenuncia->PlaceHolder = ew_RemoveHtml($this->DetalleDenuncia->FldCaption());

			// Fecha_Denuncia
			$this->Fecha_Denuncia->EditAttrs["class"] = "form-control";
			$this->Fecha_Denuncia->EditCustomAttributes = "";
			$this->Fecha_Denuncia->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Denuncia->CurrentValue, 8));
			$this->Fecha_Denuncia->PlaceHolder = ew_RemoveHtml($this->Fecha_Denuncia->FldCaption());

			// Id_Estado_Den
			$this->Id_Estado_Den->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Den->EditCustomAttributes = "";
			$this->Id_Estado_Den->EditValue = ew_HtmlEncode($this->Id_Estado_Den->CurrentValue);
			$this->Id_Estado_Den->PlaceHolder = ew_RemoveHtml($this->Id_Estado_Den->FldCaption());

			// Edit refer script
			// NroSerie

			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";

			// Quien_Denuncia
			$this->Quien_Denuncia->LinkCustomAttributes = "";
			$this->Quien_Denuncia->HrefValue = "";

			// DetalleDenuncia
			$this->DetalleDenuncia->LinkCustomAttributes = "";
			$this->DetalleDenuncia->HrefValue = "";

			// Fecha_Denuncia
			$this->Fecha_Denuncia->LinkCustomAttributes = "";
			$this->Fecha_Denuncia->HrefValue = "";

			// Id_Estado_Den
			$this->Id_Estado_Den->LinkCustomAttributes = "";
			$this->Id_Estado_Den->HrefValue = "";
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
		if ($this->NroSerie->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni_Tutor->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Quien_Denuncia->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->DetalleDenuncia->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Denuncia->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado_Den->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->NroSerie->MultiUpdate <> "" && !$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if ($this->Dni->MultiUpdate <> "" && !$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if ($this->Dni->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
			}
		}
		if ($this->Dni_Tutor->MultiUpdate <> "" && !$this->Dni_Tutor->FldIsDetailKey && !is_null($this->Dni_Tutor->FormValue) && $this->Dni_Tutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Tutor->FldCaption(), $this->Dni_Tutor->ReqErrMsg));
		}
		if ($this->Dni_Tutor->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni_Tutor->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni_Tutor->FldErrMsg());
			}
		}
		if ($this->Fecha_Denuncia->MultiUpdate <> "") {
			if (!ew_CheckDateDef($this->Fecha_Denuncia->FormValue)) {
				ew_AddMessage($gsFormError, $this->Fecha_Denuncia->FldErrMsg());
			}
		}
		if ($this->Id_Estado_Den->MultiUpdate <> "" && !$this->Id_Estado_Den->FldIsDetailKey && !is_null($this->Id_Estado_Den->FormValue) && $this->Id_Estado_Den->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Den->FldCaption(), $this->Id_Estado_Den->ReqErrMsg));
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

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly || $this->NroSerie->MultiUpdate <> "1");

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, $this->Dni->ReadOnly || $this->Dni->MultiUpdate <> "1");

			// Dni_Tutor
			$this->Dni_Tutor->SetDbValueDef($rsnew, $this->Dni_Tutor->CurrentValue, 0, $this->Dni_Tutor->ReadOnly || $this->Dni_Tutor->MultiUpdate <> "1");

			// Quien_Denuncia
			$this->Quien_Denuncia->SetDbValueDef($rsnew, $this->Quien_Denuncia->CurrentValue, NULL, $this->Quien_Denuncia->ReadOnly || $this->Quien_Denuncia->MultiUpdate <> "1");

			// DetalleDenuncia
			$this->DetalleDenuncia->SetDbValueDef($rsnew, $this->DetalleDenuncia->CurrentValue, NULL, $this->DetalleDenuncia->ReadOnly || $this->DetalleDenuncia->MultiUpdate <> "1");

			// Fecha_Denuncia
			$this->Fecha_Denuncia->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Denuncia->CurrentValue, 0), NULL, $this->Fecha_Denuncia->ReadOnly || $this->Fecha_Denuncia->MultiUpdate <> "1");

			// Id_Estado_Den
			$this->Id_Estado_Den->SetDbValueDef($rsnew, $this->Id_Estado_Den->CurrentValue, 0, $this->Id_Estado_Den->ReadOnly || $this->Id_Estado_Den->MultiUpdate <> "1");

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
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("denuncia_robo_equipolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($denuncia_robo_equipo_update)) $denuncia_robo_equipo_update = new cdenuncia_robo_equipo_update();

// Page init
$denuncia_robo_equipo_update->Page_Init();

// Page main
$denuncia_robo_equipo_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$denuncia_robo_equipo_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fdenuncia_robo_equipoupdate = new ew_Form("fdenuncia_robo_equipoupdate", "update");

// Validate form
fdenuncia_robo_equipoupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NroSerie");
			uelm = this.GetElements("u" + infix + "_NroSerie");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->NroSerie->FldCaption(), $denuncia_robo_equipo->NroSerie->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni->FldCaption(), $denuncia_robo_equipo->Dni->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			uelm = this.GetElements("u" + infix + "_Dni_Tutor");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Dni_Tutor->FldCaption(), $denuncia_robo_equipo->Dni_Tutor->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			uelm = this.GetElements("u" + infix + "_Dni_Tutor");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Denuncia");
			uelm = this.GetElements("u" + infix + "_Fecha_Denuncia");
			if (uelm && uelm.checked && elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($denuncia_robo_equipo->Fecha_Denuncia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Den");
			uelm = this.GetElements("u" + infix + "_Id_Estado_Den");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $denuncia_robo_equipo->Id_Estado_Den->FldCaption(), $denuncia_robo_equipo->Id_Estado_Den->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdenuncia_robo_equipoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdenuncia_robo_equipoupdate.ValidateRequired = true;
<?php } else { ?>
fdenuncia_robo_equipoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$denuncia_robo_equipo_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $denuncia_robo_equipo_update->ShowPageHeader(); ?>
<?php
$denuncia_robo_equipo_update->ShowMessage();
?>
<form name="fdenuncia_robo_equipoupdate" id="fdenuncia_robo_equipoupdate" class="<?php echo $denuncia_robo_equipo_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($denuncia_robo_equipo_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $denuncia_robo_equipo_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="denuncia_robo_equipo">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($denuncia_robo_equipo_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($denuncia_robo_equipo_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_denuncia_robo_equipoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($denuncia_robo_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label for="x_NroSerie" class="col-sm-2 control-label">
<input type="checkbox" name="u_NroSerie" id="u_NroSerie" value="1"<?php echo ($denuncia_robo_equipo->NroSerie->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->NroSerie->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->NroSerie->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_NroSerie">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->NroSerie->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->NroSerie->EditValue ?>"<?php echo $denuncia_robo_equipo->NroSerie->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni" id="u_Dni" value="1"<?php echo ($denuncia_robo_equipo->Dni->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->Dni->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Dni->EditValue ?>"<?php echo $denuncia_robo_equipo->Dni->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label for="x_Dni_Tutor" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni_Tutor" id="u_Dni_Tutor" value="1"<?php echo ($denuncia_robo_equipo->Dni_Tutor->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Dni_Tutor">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Dni_Tutor" name="x_Dni_Tutor" id="x_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Dni_Tutor->EditValue ?>"<?php echo $denuncia_robo_equipo->Dni_Tutor->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Dni_Tutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Quien_Denuncia->Visible) { // Quien_Denuncia ?>
	<div id="r_Quien_Denuncia" class="form-group">
		<label for="x_Quien_Denuncia" class="col-sm-2 control-label">
<input type="checkbox" name="u_Quien_Denuncia" id="u_Quien_Denuncia" value="1"<?php echo ($denuncia_robo_equipo->Quien_Denuncia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->Quien_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Quien_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Quien_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Quien_Denuncia" name="x_Quien_Denuncia" id="x_Quien_Denuncia" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Quien_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Quien_Denuncia->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Quien_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->DetalleDenuncia->Visible) { // DetalleDenuncia ?>
	<div id="r_DetalleDenuncia" class="form-group">
		<label for="x_DetalleDenuncia" class="col-sm-2 control-label">
<input type="checkbox" name="u_DetalleDenuncia" id="u_DetalleDenuncia" value="1"<?php echo ($denuncia_robo_equipo->DetalleDenuncia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->DetalleDenuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->DetalleDenuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_DetalleDenuncia">
<textarea data-table="denuncia_robo_equipo" data-field="x_DetalleDenuncia" name="x_DetalleDenuncia" id="x_DetalleDenuncia" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->DetalleDenuncia->getPlaceHolder()) ?>"<?php echo $denuncia_robo_equipo->DetalleDenuncia->EditAttributes() ?>><?php echo $denuncia_robo_equipo->DetalleDenuncia->EditValue ?></textarea>
</span>
<?php echo $denuncia_robo_equipo->DetalleDenuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Fecha_Denuncia->Visible) { // Fecha_Denuncia ?>
	<div id="r_Fecha_Denuncia" class="form-group">
		<label for="x_Fecha_Denuncia" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Denuncia" id="u_Fecha_Denuncia" value="1"<?php echo ($denuncia_robo_equipo->Fecha_Denuncia->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->Fecha_Denuncia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Fecha_Denuncia">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Fecha_Denuncia" name="x_Fecha_Denuncia" id="x_Fecha_Denuncia" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Fecha_Denuncia->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditValue ?>"<?php echo $denuncia_robo_equipo->Fecha_Denuncia->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($denuncia_robo_equipo->Id_Estado_Den->Visible) { // Id_Estado_Den ?>
	<div id="r_Id_Estado_Den" class="form-group">
		<label for="x_Id_Estado_Den" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado_Den" id="u_Id_Estado_Den" value="1"<?php echo ($denuncia_robo_equipo->Id_Estado_Den->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $denuncia_robo_equipo->Id_Estado_Den->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $denuncia_robo_equipo->Id_Estado_Den->CellAttributes() ?>>
<span id="el_denuncia_robo_equipo_Id_Estado_Den">
<input type="text" data-table="denuncia_robo_equipo" data-field="x_Id_Estado_Den" name="x_Id_Estado_Den" id="x_Id_Estado_Den" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($denuncia_robo_equipo->Id_Estado_Den->getPlaceHolder()) ?>" value="<?php echo $denuncia_robo_equipo->Id_Estado_Den->EditValue ?>"<?php echo $denuncia_robo_equipo->Id_Estado_Den->EditAttributes() ?>>
</span>
<?php echo $denuncia_robo_equipo->Id_Estado_Den->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$denuncia_robo_equipo_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $denuncia_robo_equipo_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fdenuncia_robo_equipoupdate.Init();
</script>
<?php
$denuncia_robo_equipo_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$denuncia_robo_equipo_update->Page_Terminate();
?>
