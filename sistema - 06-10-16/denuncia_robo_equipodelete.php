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

$denuncia_robo_equipo_delete = NULL; // Initialize page object first

class cdenuncia_robo_equipo_delete extends cdenuncia_robo_equipo {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'denuncia_robo_equipo';

	// Page object name
	var $PageObjName = 'denuncia_robo_equipo_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("denuncia_robo_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IdDenuncia->SetVisibility();
		$this->IdDenuncia->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->NroSerie->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Quien_Denuncia->SetVisibility();
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("denuncia_robo_equipolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in denuncia_robo_equipo class, denuncia_robo_equipoinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("denuncia_robo_equipolist.php"); // Return to list
			}
		}
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

		// Fecha_Denuncia
		$this->Fecha_Denuncia->ViewValue = $this->Fecha_Denuncia->CurrentValue;
		$this->Fecha_Denuncia->ViewValue = ew_FormatDateTime($this->Fecha_Denuncia->ViewValue, 0);
		$this->Fecha_Denuncia->ViewCustomAttributes = "";

		// Id_Estado_Den
		$this->Id_Estado_Den->ViewValue = $this->Id_Estado_Den->CurrentValue;
		$this->Id_Estado_Den->ViewCustomAttributes = "";

			// IdDenuncia
			$this->IdDenuncia->LinkCustomAttributes = "";
			$this->IdDenuncia->HrefValue = "";
			$this->IdDenuncia->TooltipValue = "";

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

			// Fecha_Denuncia
			$this->Fecha_Denuncia->LinkCustomAttributes = "";
			$this->Fecha_Denuncia->HrefValue = "";
			$this->Fecha_Denuncia->TooltipValue = "";

			// Id_Estado_Den
			$this->Id_Estado_Den->LinkCustomAttributes = "";
			$this->Id_Estado_Den->HrefValue = "";
			$this->Id_Estado_Den->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['IdDenuncia'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("denuncia_robo_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($denuncia_robo_equipo_delete)) $denuncia_robo_equipo_delete = new cdenuncia_robo_equipo_delete();

// Page init
$denuncia_robo_equipo_delete->Page_Init();

// Page main
$denuncia_robo_equipo_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$denuncia_robo_equipo_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdenuncia_robo_equipodelete = new ew_Form("fdenuncia_robo_equipodelete", "delete");

// Form_CustomValidate event
fdenuncia_robo_equipodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdenuncia_robo_equipodelete.ValidateRequired = true;
<?php } else { ?>
fdenuncia_robo_equipodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $denuncia_robo_equipo_delete->ShowPageHeader(); ?>
<?php
$denuncia_robo_equipo_delete->ShowMessage();
?>
<form name="fdenuncia_robo_equipodelete" id="fdenuncia_robo_equipodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($denuncia_robo_equipo_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $denuncia_robo_equipo_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="denuncia_robo_equipo">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($denuncia_robo_equipo_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $denuncia_robo_equipo->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($denuncia_robo_equipo->IdDenuncia->Visible) { // IdDenuncia ?>
		<th><span id="elh_denuncia_robo_equipo_IdDenuncia" class="denuncia_robo_equipo_IdDenuncia"><?php echo $denuncia_robo_equipo->IdDenuncia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->NroSerie->Visible) { // NroSerie ?>
		<th><span id="elh_denuncia_robo_equipo_NroSerie" class="denuncia_robo_equipo_NroSerie"><?php echo $denuncia_robo_equipo->NroSerie->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni->Visible) { // Dni ?>
		<th><span id="elh_denuncia_robo_equipo_Dni" class="denuncia_robo_equipo_Dni"><?php echo $denuncia_robo_equipo->Dni->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<th><span id="elh_denuncia_robo_equipo_Dni_Tutor" class="denuncia_robo_equipo_Dni_Tutor"><?php echo $denuncia_robo_equipo->Dni_Tutor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->Quien_Denuncia->Visible) { // Quien_Denuncia ?>
		<th><span id="elh_denuncia_robo_equipo_Quien_Denuncia" class="denuncia_robo_equipo_Quien_Denuncia"><?php echo $denuncia_robo_equipo->Quien_Denuncia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->Fecha_Denuncia->Visible) { // Fecha_Denuncia ?>
		<th><span id="elh_denuncia_robo_equipo_Fecha_Denuncia" class="denuncia_robo_equipo_Fecha_Denuncia"><?php echo $denuncia_robo_equipo->Fecha_Denuncia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($denuncia_robo_equipo->Id_Estado_Den->Visible) { // Id_Estado_Den ?>
		<th><span id="elh_denuncia_robo_equipo_Id_Estado_Den" class="denuncia_robo_equipo_Id_Estado_Den"><?php echo $denuncia_robo_equipo->Id_Estado_Den->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$denuncia_robo_equipo_delete->RecCnt = 0;
$i = 0;
while (!$denuncia_robo_equipo_delete->Recordset->EOF) {
	$denuncia_robo_equipo_delete->RecCnt++;
	$denuncia_robo_equipo_delete->RowCnt++;

	// Set row properties
	$denuncia_robo_equipo->ResetAttrs();
	$denuncia_robo_equipo->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$denuncia_robo_equipo_delete->LoadRowValues($denuncia_robo_equipo_delete->Recordset);

	// Render row
	$denuncia_robo_equipo_delete->RenderRow();
?>
	<tr<?php echo $denuncia_robo_equipo->RowAttributes() ?>>
<?php if ($denuncia_robo_equipo->IdDenuncia->Visible) { // IdDenuncia ?>
		<td<?php echo $denuncia_robo_equipo->IdDenuncia->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_IdDenuncia" class="denuncia_robo_equipo_IdDenuncia">
<span<?php echo $denuncia_robo_equipo->IdDenuncia->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->IdDenuncia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->NroSerie->Visible) { // NroSerie ?>
		<td<?php echo $denuncia_robo_equipo->NroSerie->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_NroSerie" class="denuncia_robo_equipo_NroSerie">
<span<?php echo $denuncia_robo_equipo->NroSerie->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->NroSerie->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni->Visible) { // Dni ?>
		<td<?php echo $denuncia_robo_equipo->Dni->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_Dni" class="denuncia_robo_equipo_Dni">
<span<?php echo $denuncia_robo_equipo->Dni->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->Dni->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td<?php echo $denuncia_robo_equipo->Dni_Tutor->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_Dni_Tutor" class="denuncia_robo_equipo_Dni_Tutor">
<span<?php echo $denuncia_robo_equipo->Dni_Tutor->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->Dni_Tutor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->Quien_Denuncia->Visible) { // Quien_Denuncia ?>
		<td<?php echo $denuncia_robo_equipo->Quien_Denuncia->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_Quien_Denuncia" class="denuncia_robo_equipo_Quien_Denuncia">
<span<?php echo $denuncia_robo_equipo->Quien_Denuncia->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->Quien_Denuncia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->Fecha_Denuncia->Visible) { // Fecha_Denuncia ?>
		<td<?php echo $denuncia_robo_equipo->Fecha_Denuncia->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_Fecha_Denuncia" class="denuncia_robo_equipo_Fecha_Denuncia">
<span<?php echo $denuncia_robo_equipo->Fecha_Denuncia->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->Fecha_Denuncia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($denuncia_robo_equipo->Id_Estado_Den->Visible) { // Id_Estado_Den ?>
		<td<?php echo $denuncia_robo_equipo->Id_Estado_Den->CellAttributes() ?>>
<span id="el<?php echo $denuncia_robo_equipo_delete->RowCnt ?>_denuncia_robo_equipo_Id_Estado_Den" class="denuncia_robo_equipo_Id_Estado_Den">
<span<?php echo $denuncia_robo_equipo->Id_Estado_Den->ViewAttributes() ?>>
<?php echo $denuncia_robo_equipo->Id_Estado_Den->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$denuncia_robo_equipo_delete->Recordset->MoveNext();
}
$denuncia_robo_equipo_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $denuncia_robo_equipo_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdenuncia_robo_equipodelete.Init();
</script>
<?php
$denuncia_robo_equipo_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$denuncia_robo_equipo_delete->Page_Terminate();
?>
