<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "chatinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "conversacionesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$chat_search = NULL; // Initialize page object first

class cchat_search extends cchat {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'chat';

	// Page object name
	var $PageObjName = 'chat_search';

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
	var $AuditTrailOnEdit = FALSE;
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

		// Table object (chat)
		if (!isset($GLOBALS["chat"]) || get_class($GLOBALS["chat"]) == "cchat") {
			$GLOBALS["chat"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["chat"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Table object (conversaciones)
		if (!isset($GLOBALS['conversaciones'])) $GLOBALS['conversaciones'] = new cconversaciones();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'chat', TRUE);

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("chatlist.php"));
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
		$this->Orden->SetVisibility();
		$this->Orden->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Texto_Chat->SetVisibility();
		$this->Hora->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Estado->SetVisibility();
		$this->Nro_Conversacion->SetVisibility();

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
		global $EW_EXPORT, $chat;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($chat);
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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "chatlist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->Orden); // Orden
		$this->BuildSearchUrl($sSrchUrl, $this->Texto_Chat); // Texto_Chat
		$this->BuildSearchUrl($sSrchUrl, $this->Hora); // Hora
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario); // Usuario
		$this->BuildSearchUrl($sSrchUrl, $this->Estado); // Estado
		$this->BuildSearchUrl($sSrchUrl, $this->Nro_Conversacion); // Nro_Conversacion
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Orden

		$this->Orden->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Orden"));
		$this->Orden->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Orden");

		// Texto_Chat
		$this->Texto_Chat->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Texto_Chat"));
		$this->Texto_Chat->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Texto_Chat");

		// Hora
		$this->Hora->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Hora"));
		$this->Hora->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Hora");

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario"));
		$this->Usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario");

		// Estado
		$this->Estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado"));
		$this->Estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado");

		// Nro_Conversacion
		$this->Nro_Conversacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nro_Conversacion"));
		$this->Nro_Conversacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nro_Conversacion");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Orden
		// Texto_Chat
		// Hora
		// Usuario
		// Estado
		// Nro_Conversacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Orden
		$this->Orden->ViewValue = $this->Orden->CurrentValue;
		$this->Orden->ViewCustomAttributes = "";

		// Texto_Chat
		$this->Texto_Chat->ViewValue = $this->Texto_Chat->CurrentValue;
		$this->Texto_Chat->ViewCustomAttributes = "";

		// Hora
		$this->Hora->ViewValue = $this->Hora->CurrentValue;
		$this->Hora->ViewValue = ew_FormatDateTime($this->Hora->ViewValue, 3);
		$this->Hora->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Estado
		$this->Estado->ViewValue = $this->Estado->CurrentValue;
		$this->Estado->ViewCustomAttributes = "";

		// Nro_Conversacion
		$this->Nro_Conversacion->ViewValue = $this->Nro_Conversacion->CurrentValue;
		$this->Nro_Conversacion->ViewCustomAttributes = "";

			// Orden
			$this->Orden->LinkCustomAttributes = "";
			$this->Orden->HrefValue = "";
			$this->Orden->TooltipValue = "";

			// Texto_Chat
			$this->Texto_Chat->LinkCustomAttributes = "";
			$this->Texto_Chat->HrefValue = "";
			$this->Texto_Chat->TooltipValue = "";

			// Hora
			$this->Hora->LinkCustomAttributes = "";
			$this->Hora->HrefValue = "";
			$this->Hora->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";

			// Nro_Conversacion
			$this->Nro_Conversacion->LinkCustomAttributes = "";
			$this->Nro_Conversacion->HrefValue = "";
			$this->Nro_Conversacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Orden
			$this->Orden->EditAttrs["class"] = "form-control";
			$this->Orden->EditCustomAttributes = "";
			$this->Orden->EditValue = ew_HtmlEncode($this->Orden->AdvancedSearch->SearchValue);
			$this->Orden->PlaceHolder = ew_RemoveHtml($this->Orden->FldCaption());

			// Texto_Chat
			$this->Texto_Chat->EditAttrs["class"] = "form-control";
			$this->Texto_Chat->EditCustomAttributes = "";
			$this->Texto_Chat->EditValue = ew_HtmlEncode($this->Texto_Chat->AdvancedSearch->SearchValue);
			$this->Texto_Chat->PlaceHolder = ew_RemoveHtml($this->Texto_Chat->FldCaption());

			// Hora
			$this->Hora->EditAttrs["class"] = "form-control";
			$this->Hora->EditCustomAttributes = "";
			$this->Hora->EditValue = ew_HtmlEncode(ew_UnFormatDateTime($this->Hora->AdvancedSearch->SearchValue, 3));
			$this->Hora->PlaceHolder = ew_RemoveHtml($this->Hora->FldCaption());

			// Usuario
			$this->Usuario->EditAttrs["class"] = "form-control";
			$this->Usuario->EditCustomAttributes = "";
			$this->Usuario->EditValue = ew_HtmlEncode($this->Usuario->AdvancedSearch->SearchValue);
			$this->Usuario->PlaceHolder = ew_RemoveHtml($this->Usuario->FldCaption());

			// Estado
			$this->Estado->EditAttrs["class"] = "form-control";
			$this->Estado->EditCustomAttributes = "";
			$this->Estado->EditValue = ew_HtmlEncode($this->Estado->AdvancedSearch->SearchValue);
			$this->Estado->PlaceHolder = ew_RemoveHtml($this->Estado->FldCaption());

			// Nro_Conversacion
			$this->Nro_Conversacion->EditAttrs["class"] = "form-control";
			$this->Nro_Conversacion->EditCustomAttributes = "";
			$this->Nro_Conversacion->EditValue = ew_HtmlEncode($this->Nro_Conversacion->AdvancedSearch->SearchValue);
			$this->Nro_Conversacion->PlaceHolder = ew_RemoveHtml($this->Nro_Conversacion->FldCaption());
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($this->Orden->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Orden->FldErrMsg());
		}
		if (!ew_CheckTime($this->Hora->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Hora->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Orden->AdvancedSearch->Load();
		$this->Texto_Chat->AdvancedSearch->Load();
		$this->Hora->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Estado->AdvancedSearch->Load();
		$this->Nro_Conversacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("chatlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($chat_search)) $chat_search = new cchat_search();

// Page init
$chat_search->Page_Init();

// Page main
$chat_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$chat_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($chat_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fchatsearch = new ew_Form("fchatsearch", "search");
<?php } else { ?>
var CurrentForm = fchatsearch = new ew_Form("fchatsearch", "search");
<?php } ?>

// Form_CustomValidate event
fchatsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fchatsearch.ValidateRequired = true;
<?php } else { ?>
fchatsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search
// Validate function for search

fchatsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Orden");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($chat->Orden->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Hora");
	if (elm && !ew_CheckTime(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($chat->Hora->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$chat_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $chat_search->ShowPageHeader(); ?>
<?php
$chat_search->ShowMessage();
?>
<form name="fchatsearch" id="fchatsearch" class="<?php echo $chat_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($chat_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $chat_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="chat">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($chat_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($chat->Orden->Visible) { // Orden ?>
	<div id="r_Orden" class="form-group">
		<label for="x_Orden" class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Orden"><?php echo $chat->Orden->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Orden" id="z_Orden" value="="></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Orden->CellAttributes() ?>>
			<span id="el_chat_Orden">
<input type="text" data-table="chat" data-field="x_Orden" name="x_Orden" id="x_Orden" placeholder="<?php echo ew_HtmlEncode($chat->Orden->getPlaceHolder()) ?>" value="<?php echo $chat->Orden->EditValue ?>"<?php echo $chat->Orden->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($chat->Texto_Chat->Visible) { // Texto_Chat ?>
	<div id="r_Texto_Chat" class="form-group">
		<label for="x_Texto_Chat" class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Texto_Chat"><?php echo $chat->Texto_Chat->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Texto_Chat" id="z_Texto_Chat" value="LIKE"></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Texto_Chat->CellAttributes() ?>>
			<span id="el_chat_Texto_Chat">
<input type="text" data-table="chat" data-field="x_Texto_Chat" name="x_Texto_Chat" id="x_Texto_Chat" size="35" placeholder="<?php echo ew_HtmlEncode($chat->Texto_Chat->getPlaceHolder()) ?>" value="<?php echo $chat->Texto_Chat->EditValue ?>"<?php echo $chat->Texto_Chat->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($chat->Hora->Visible) { // Hora ?>
	<div id="r_Hora" class="form-group">
		<label for="x_Hora" class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Hora"><?php echo $chat->Hora->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Hora" id="z_Hora" value="="></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Hora->CellAttributes() ?>>
			<span id="el_chat_Hora">
<input type="text" data-table="chat" data-field="x_Hora" name="x_Hora" id="x_Hora" size="30" placeholder="<?php echo ew_HtmlEncode($chat->Hora->getPlaceHolder()) ?>" value="<?php echo $chat->Hora->EditValue ?>"<?php echo $chat->Hora->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($chat->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Usuario"><?php echo $chat->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Usuario->CellAttributes() ?>>
			<span id="el_chat_Usuario">
<input type="text" data-table="chat" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="160" placeholder="<?php echo ew_HtmlEncode($chat->Usuario->getPlaceHolder()) ?>" value="<?php echo $chat->Usuario->EditValue ?>"<?php echo $chat->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($chat->Estado->Visible) { // Estado ?>
	<div id="r_Estado" class="form-group">
		<label class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Estado"><?php echo $chat->Estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Estado" id="z_Estado" value="LIKE"></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Estado->CellAttributes() ?>>
			<span id="el_chat_Estado">
<input type="text" data-table="chat" data-field="x_Estado" name="x_Estado" id="x_Estado" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($chat->Estado->getPlaceHolder()) ?>" value="<?php echo $chat->Estado->EditValue ?>"<?php echo $chat->Estado->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($chat->Nro_Conversacion->Visible) { // Nro_Conversacion ?>
	<div id="r_Nro_Conversacion" class="form-group">
		<label class="<?php echo $chat_search->SearchLabelClass ?>"><span id="elh_chat_Nro_Conversacion"><?php echo $chat->Nro_Conversacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Nro_Conversacion" id="z_Nro_Conversacion" value="="></p>
		</label>
		<div class="<?php echo $chat_search->SearchRightColumnClass ?>"><div<?php echo $chat->Nro_Conversacion->CellAttributes() ?>>
			<span id="el_chat_Nro_Conversacion">
<input type="text" data-table="chat" data-field="x_Nro_Conversacion" name="x_Nro_Conversacion" id="x_Nro_Conversacion" size="30" placeholder="<?php echo ew_HtmlEncode($chat->Nro_Conversacion->getPlaceHolder()) ?>" value="<?php echo $chat->Nro_Conversacion->EditValue ?>"<?php echo $chat->Nro_Conversacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$chat_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fchatsearch.Init();
</script>
<?php
$chat_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$chat_search->Page_Terminate();
?>
