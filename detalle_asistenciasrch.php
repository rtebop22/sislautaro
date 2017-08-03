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

$detalle_asistencia_search = NULL; // Initialize page object first

class cdetalle_asistencia_search extends cdetalle_asistencia {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'detalle_asistencia';

	// Page object name
	var $PageObjName = 'detalle_asistencia_search';

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

		// Table object (detalle_asistencia)
		if (!isset($GLOBALS["detalle_asistencia"]) || get_class($GLOBALS["detalle_asistencia"]) == "cdetalle_asistencia") {
			$GLOBALS["detalle_asistencia"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_asistencia"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
		$this->Dia->SetVisibility();
		$this->Dia->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
						$sSrchStr = "detalle_asistencialist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Dia); // Dia
		$this->BuildSearchUrl($sSrchUrl, $this->Dias); // Dias
		$this->BuildSearchUrl($sSrchUrl, $this->Horario); // Horario
		$this->BuildSearchUrl($sSrchUrl, $this->Rol); // Rol
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Asistencia); // Id_Asistencia
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
		// Dia

		$this->Dia->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dia"));
		$this->Dia->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dia");

		// Dias
		$this->Dias->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dias"));
		$this->Dias->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dias");

		// Horario
		$this->Horario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Horario"));
		$this->Horario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Horario");

		// Rol
		$this->Rol->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Rol"));
		$this->Rol->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Rol");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Id_Asistencia
		$this->Id_Asistencia->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Asistencia"));
		$this->Id_Asistencia->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Asistencia");
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

			// Dia
			$this->Dia->LinkCustomAttributes = "";
			$this->Dia->HrefValue = "";
			$this->Dia->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Dia
			$this->Dia->EditAttrs["class"] = "form-control";
			$this->Dia->EditCustomAttributes = "";
			$this->Dia->EditValue = $this->Dia->Options(TRUE);

			// Dias
			$this->Dias->EditAttrs["class"] = "form-control";
			$this->Dias->EditCustomAttributes = "";
			$this->Dias->EditValue = ew_HtmlEncode($this->Dias->AdvancedSearch->SearchValue);
			$this->Dias->PlaceHolder = ew_RemoveHtml($this->Dias->FldCaption());

			// Horario
			$this->Horario->EditAttrs["class"] = "form-control";
			$this->Horario->EditCustomAttributes = "";
			$this->Horario->EditValue = ew_HtmlEncode($this->Horario->AdvancedSearch->SearchValue);
			$this->Horario->PlaceHolder = ew_RemoveHtml($this->Horario->FldCaption());

			// Rol
			$this->Rol->EditAttrs["class"] = "form-control";
			$this->Rol->EditCustomAttributes = "";
			$this->Rol->EditValue = ew_HtmlEncode($this->Rol->AdvancedSearch->SearchValue);
			$this->Rol->PlaceHolder = ew_RemoveHtml($this->Rol->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Asistencia
			$this->Id_Asistencia->EditAttrs["class"] = "form-control";
			$this->Id_Asistencia->EditCustomAttributes = "";
			$this->Id_Asistencia->EditValue = ew_HtmlEncode($this->Id_Asistencia->AdvancedSearch->SearchValue);
			$this->Id_Asistencia->PlaceHolder = ew_RemoveHtml($this->Id_Asistencia->FldCaption());
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
		if (!ew_CheckInteger($this->Id_Asistencia->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Id_Asistencia->FldErrMsg());
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
		$this->Dia->AdvancedSearch->Load();
		$this->Dias->AdvancedSearch->Load();
		$this->Horario->AdvancedSearch->Load();
		$this->Rol->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Id_Asistencia->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detalle_asistencialist.php"), "", $this->TableVar, TRUE);
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
if (!isset($detalle_asistencia_search)) $detalle_asistencia_search = new cdetalle_asistencia_search();

// Page init
$detalle_asistencia_search->Page_Init();

// Page main
$detalle_asistencia_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_asistencia_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($detalle_asistencia_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fdetalle_asistenciasearch = new ew_Form("fdetalle_asistenciasearch", "search");
<?php } else { ?>
var CurrentForm = fdetalle_asistenciasearch = new ew_Form("fdetalle_asistenciasearch", "search");
<?php } ?>

// Form_CustomValidate event
fdetalle_asistenciasearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_asistenciasearch.ValidateRequired = true;
<?php } else { ?>
fdetalle_asistenciasearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_asistenciasearch.Lists["x_Dia"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdetalle_asistenciasearch.Lists["x_Dia"].Options = <?php echo json_encode($detalle_asistencia->Dia->Options()) ?>;

// Form object for search
// Validate function for search

fdetalle_asistenciasearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Id_Asistencia");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_asistencia->Id_Asistencia->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detalle_asistencia_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detalle_asistencia_search->ShowPageHeader(); ?>
<?php
$detalle_asistencia_search->ShowMessage();
?>
<form name="fdetalle_asistenciasearch" id="fdetalle_asistenciasearch" class="<?php echo $detalle_asistencia_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_asistencia_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_asistencia_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_asistencia">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($detalle_asistencia_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($detalle_asistencia->Dia->Visible) { // Dia ?>
	<div id="r_Dia" class="form-group">
		<label for="x_Dia" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Dia"><?php echo $detalle_asistencia->Dia->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dia" id="z_Dia" value="="></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Dia->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Dia">
<select data-table="detalle_asistencia" data-field="x_Dia" data-value-separator="<?php echo $detalle_asistencia->Dia->DisplayValueSeparatorAttribute() ?>" id="x_Dia" name="x_Dia"<?php echo $detalle_asistencia->Dia->EditAttributes() ?>>
<?php echo $detalle_asistencia->Dia->SelectOptionListHtml("x_Dia") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Dias->Visible) { // Dias ?>
	<div id="r_Dias" class="form-group">
		<label for="x_Dias" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Dias"><?php echo $detalle_asistencia->Dias->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Dias" id="z_Dias" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Dias->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Dias">
<input type="text" data-table="detalle_asistencia" data-field="x_Dias" name="x_Dias" id="x_Dias" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Dias->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Dias->EditValue ?>"<?php echo $detalle_asistencia->Dias->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Horario->Visible) { // Horario ?>
	<div id="r_Horario" class="form-group">
		<label for="x_Horario" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Horario"><?php echo $detalle_asistencia->Horario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Horario" id="z_Horario" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Horario->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Horario">
<input type="text" data-table="detalle_asistencia" data-field="x_Horario" name="x_Horario" id="x_Horario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Horario->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Horario->EditValue ?>"<?php echo $detalle_asistencia->Horario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Rol->Visible) { // Rol ?>
	<div id="r_Rol" class="form-group">
		<label for="x_Rol" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Rol"><?php echo $detalle_asistencia->Rol->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Rol" id="z_Rol" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Rol->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Rol">
<input type="text" data-table="detalle_asistencia" data-field="x_Rol" name="x_Rol" id="x_Rol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Rol->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Rol->EditValue ?>"<?php echo $detalle_asistencia->Rol->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Observacion"><?php echo $detalle_asistencia->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Observacion->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Observacion">
<input type="text" data-table="detalle_asistencia" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Observacion->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Observacion->EditValue ?>"<?php echo $detalle_asistencia->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_asistencia->Id_Asistencia->Visible) { // Id_Asistencia ?>
	<div id="r_Id_Asistencia" class="form-group">
		<label for="x_Id_Asistencia" class="<?php echo $detalle_asistencia_search->SearchLabelClass ?>"><span id="elh_detalle_asistencia_Id_Asistencia"><?php echo $detalle_asistencia->Id_Asistencia->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Asistencia" id="z_Id_Asistencia" value="="></p>
		</label>
		<div class="<?php echo $detalle_asistencia_search->SearchRightColumnClass ?>"><div<?php echo $detalle_asistencia->Id_Asistencia->CellAttributes() ?>>
			<span id="el_detalle_asistencia_Id_Asistencia">
<input type="text" data-table="detalle_asistencia" data-field="x_Id_Asistencia" name="x_Id_Asistencia" id="x_Id_Asistencia" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_asistencia->Id_Asistencia->getPlaceHolder()) ?>" value="<?php echo $detalle_asistencia->Id_Asistencia->EditValue ?>"<?php echo $detalle_asistencia->Id_Asistencia->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$detalle_asistencia_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdetalle_asistenciasearch.Init();
</script>
<?php
$detalle_asistencia_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detalle_asistencia_search->Page_Terminate();
?>
