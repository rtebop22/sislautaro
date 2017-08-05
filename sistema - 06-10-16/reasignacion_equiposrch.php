<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "reasignacion_equipoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$reasignacion_equipo_search = NULL; // Initialize page object first

class creasignacion_equipo_search extends creasignacion_equipo {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'reasignacion_equipo';

	// Page object name
	var $PageObjName = 'reasignacion_equipo_search';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (reasignacion_equipo)
		if (!isset($GLOBALS["reasignacion_equipo"]) || get_class($GLOBALS["reasignacion_equipo"]) == "creasignacion_equipo") {
			$GLOBALS["reasignacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reasignacion_equipo"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reasignacion_equipo', TRUE);

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("reasignacion_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Reasignacion->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Reasignacion->SetVisibility();
		$this->Id_Motivo_Reasig->SetVisibility();

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
		global $EW_EXPORT, $reasignacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($reasignacion_equipo);
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
						$sSrchStr = "reasignacion_equipolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Reasignacion); // Id_Reasignacion
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->NroSerie); // NroSerie
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Reasignacion); // Fecha_Reasignacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Motivo_Reasig); // Id_Motivo_Reasig
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
		// Id_Reasignacion

		$this->Id_Reasignacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Reasignacion"));
		$this->Id_Reasignacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Reasignacion");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroSerie"));
		$this->NroSerie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroSerie");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Reasignacion"));
		$this->Fecha_Reasignacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Reasignacion");

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Motivo_Reasig"));
		$this->Id_Motivo_Reasig->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Motivo_Reasig");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Reasignacion
		// Dni
		// NroSerie
		// Observacion
		// Fecha_Reasignacion
		// Id_Motivo_Reasig

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Reasignacion
		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

			// Id_Reasignacion
			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";
			$this->Id_Reasignacion->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";
			$this->Fecha_Reasignacion->TooltipValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
			$this->Id_Motivo_Reasig->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Reasignacion
			$this->Id_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Id_Reasignacion->EditCustomAttributes = "";
			$this->Id_Reasignacion->EditValue = ew_HtmlEncode($this->Id_Reasignacion->AdvancedSearch->SearchValue);
			$this->Id_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Id_Reasignacion->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->AdvancedSearch->SearchValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Reasignacion->EditCustomAttributes = "";
			$this->Fecha_Reasignacion->EditValue = ew_HtmlEncode($this->Fecha_Reasignacion->AdvancedSearch->SearchValue);
			$this->Fecha_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Reasignacion->FldCaption());

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Reasig->EditCustomAttributes = "";
			$this->Id_Motivo_Reasig->EditValue = ew_HtmlEncode($this->Id_Motivo_Reasig->AdvancedSearch->SearchValue);
			$this->Id_Motivo_Reasig->PlaceHolder = ew_RemoveHtml($this->Id_Motivo_Reasig->FldCaption());
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
		if (!ew_CheckInteger($this->Dni->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni->FldErrMsg());
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
		$this->Id_Reasignacion->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Fecha_Reasignacion->AdvancedSearch->Load();
		$this->Id_Motivo_Reasig->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reasignacion_equipolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($reasignacion_equipo_search)) $reasignacion_equipo_search = new creasignacion_equipo_search();

// Page init
$reasignacion_equipo_search->Page_Init();

// Page main
$reasignacion_equipo_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reasignacion_equipo_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($reasignacion_equipo_search->IsModal) { ?>
var CurrentAdvancedSearchForm = freasignacion_equiposearch = new ew_Form("freasignacion_equiposearch", "search");
<?php } else { ?>
var CurrentForm = freasignacion_equiposearch = new ew_Form("freasignacion_equiposearch", "search");
<?php } ?>

// Form_CustomValidate event
freasignacion_equiposearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freasignacion_equiposearch.ValidateRequired = true;
<?php } else { ?>
freasignacion_equiposearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search
// Validate function for search

freasignacion_equiposearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$reasignacion_equipo_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reasignacion_equipo_search->ShowPageHeader(); ?>
<?php
$reasignacion_equipo_search->ShowMessage();
?>
<form name="freasignacion_equiposearch" id="freasignacion_equiposearch" class="<?php echo $reasignacion_equipo_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($reasignacion_equipo_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $reasignacion_equipo_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reasignacion_equipo">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($reasignacion_equipo_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($reasignacion_equipo->Id_Reasignacion->Visible) { // Id_Reasignacion ?>
	<div id="r_Id_Reasignacion" class="form-group">
		<label for="x_Id_Reasignacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Id_Reasignacion"><?php echo $reasignacion_equipo->Id_Reasignacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Reasignacion" id="z_Id_Reasignacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Id_Reasignacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Id_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Id_Reasignacion" name="x_Id_Reasignacion" id="x_Id_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Id_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Id_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Id_Reasignacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Dni"><?php echo $reasignacion_equipo->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Dni->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Dni">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni->EditValue ?>"<?php echo $reasignacion_equipo->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label for="x_NroSerie" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_NroSerie"><?php echo $reasignacion_equipo->NroSerie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroSerie" id="z_NroSerie" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->NroSerie->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_NroSerie">
<input type="text" data-table="reasignacion_equipo" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->NroSerie->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->NroSerie->EditValue ?>"<?php echo $reasignacion_equipo->NroSerie->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Observacion"><?php echo $reasignacion_equipo->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Observacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Observacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="35" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Observacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Observacion->EditValue ?>"<?php echo $reasignacion_equipo->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Reasignacion->Visible) { // Fecha_Reasignacion ?>
	<div id="r_Fecha_Reasignacion" class="form-group">
		<label for="x_Fecha_Reasignacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Fecha_Reasignacion"><?php echo $reasignacion_equipo->Fecha_Reasignacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Reasignacion" id="z_Fecha_Reasignacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Fecha_Reasignacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Fecha_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Fecha_Reasignacion" name="x_Fecha_Reasignacion" id="x_Fecha_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Fecha_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Id_Motivo_Reasig->Visible) { // Id_Motivo_Reasig ?>
	<div id="r_Id_Motivo_Reasig" class="form-group">
		<label for="x_Id_Motivo_Reasig" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Id_Motivo_Reasig"><?php echo $reasignacion_equipo->Id_Motivo_Reasig->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Motivo_Reasig" id="z_Id_Motivo_Reasig" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Id_Motivo_Reasig">
<input type="text" data-table="reasignacion_equipo" data-field="x_Id_Motivo_Reasig" name="x_Id_Motivo_Reasig" id="x_Id_Motivo_Reasig" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Id_Motivo_Reasig->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditValue ?>"<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$reasignacion_equipo_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freasignacion_equiposearch.Init();
</script>
<?php
$reasignacion_equipo_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$reasignacion_equipo_search->Page_Terminate();
?>
