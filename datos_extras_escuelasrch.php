<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "datos_extras_escuelainfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$datos_extras_escuela_search = NULL; // Initialize page object first

class cdatos_extras_escuela_search extends cdatos_extras_escuela {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'datos_extras_escuela';

	// Page object name
	var $PageObjName = 'datos_extras_escuela_search';

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

		// Table object (datos_extras_escuela)
		if (!isset($GLOBALS["datos_extras_escuela"]) || get_class($GLOBALS["datos_extras_escuela"]) == "cdatos_extras_escuela") {
			$GLOBALS["datos_extras_escuela"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["datos_extras_escuela"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'datos_extras_escuela', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("datos_extras_escuelalist.php"));
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
		$this->Cue->SetVisibility();
		$this->Usuario_Conig->SetVisibility();
		$this->Password_Conig->SetVisibility();
		$this->Tiene_Internet->SetVisibility();
		$this->Servicio_Internet->SetVisibility();
		$this->Estado_Internet->SetVisibility();
		$this->Quien_Paga->SetVisibility();
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
		global $EW_EXPORT, $datos_extras_escuela;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($datos_extras_escuela);
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
						$sSrchStr = "datos_extras_escuelalist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Cue); // Cue
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario_Conig); // Usuario_Conig
		$this->BuildSearchUrl($sSrchUrl, $this->Password_Conig); // Password_Conig
		$this->BuildSearchUrl($sSrchUrl, $this->Tiene_Internet); // Tiene_Internet
		$this->BuildSearchUrl($sSrchUrl, $this->Servicio_Internet); // Servicio_Internet
		$this->BuildSearchUrl($sSrchUrl, $this->Estado_Internet); // Estado_Internet
		$this->BuildSearchUrl($sSrchUrl, $this->Quien_Paga); // Quien_Paga
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Actualizacion); // Fecha_Actualizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario); // Usuario
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
		// Cue

		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue"));
		$this->Cue->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue");

		// Usuario_Conig
		$this->Usuario_Conig->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario_Conig"));
		$this->Usuario_Conig->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario_Conig");

		// Password_Conig
		$this->Password_Conig->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Password_Conig"));
		$this->Password_Conig->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Password_Conig");

		// Tiene_Internet
		$this->Tiene_Internet->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tiene_Internet"));
		$this->Tiene_Internet->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tiene_Internet");

		// Servicio_Internet
		$this->Servicio_Internet->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Servicio_Internet"));
		$this->Servicio_Internet->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Servicio_Internet");

		// Estado_Internet
		$this->Estado_Internet->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado_Internet"));
		$this->Estado_Internet->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado_Internet");

		// Quien_Paga
		$this->Quien_Paga->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Quien_Paga"));
		$this->Quien_Paga->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Quien_Paga");

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Actualizacion"));
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Actualizacion");

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario"));
		$this->Usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Cue
		// Usuario_Conig
		// Password_Conig
		// Tiene_Internet
		// Servicio_Internet
		// Estado_Internet
		// Quien_Paga
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Usuario_Conig
		$this->Usuario_Conig->ViewValue = $this->Usuario_Conig->CurrentValue;
		$this->Usuario_Conig->ViewCustomAttributes = "";

		// Password_Conig
		$this->Password_Conig->ViewValue = $this->Password_Conig->CurrentValue;
		$this->Password_Conig->ViewCustomAttributes = "";

		// Tiene_Internet
		if (strval($this->Tiene_Internet->CurrentValue) <> "") {
			$this->Tiene_Internet->ViewValue = $this->Tiene_Internet->OptionCaption($this->Tiene_Internet->CurrentValue);
		} else {
			$this->Tiene_Internet->ViewValue = NULL;
		}
		$this->Tiene_Internet->ViewCustomAttributes = "";

		// Servicio_Internet
		$this->Servicio_Internet->ViewValue = $this->Servicio_Internet->CurrentValue;
		$this->Servicio_Internet->ViewCustomAttributes = "";

		// Estado_Internet
		if (strval($this->Estado_Internet->CurrentValue) <> "") {
			$this->Estado_Internet->ViewValue = $this->Estado_Internet->OptionCaption($this->Estado_Internet->CurrentValue);
		} else {
			$this->Estado_Internet->ViewValue = NULL;
		}
		$this->Estado_Internet->ViewCustomAttributes = "";

		// Quien_Paga
		$this->Quien_Paga->ViewValue = $this->Quien_Paga->CurrentValue;
		$this->Quien_Paga->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Usuario_Conig
			$this->Usuario_Conig->LinkCustomAttributes = "";
			$this->Usuario_Conig->HrefValue = "";
			$this->Usuario_Conig->TooltipValue = "";

			// Password_Conig
			$this->Password_Conig->LinkCustomAttributes = "";
			$this->Password_Conig->HrefValue = "";
			$this->Password_Conig->TooltipValue = "";

			// Tiene_Internet
			$this->Tiene_Internet->LinkCustomAttributes = "";
			$this->Tiene_Internet->HrefValue = "";
			$this->Tiene_Internet->TooltipValue = "";

			// Servicio_Internet
			$this->Servicio_Internet->LinkCustomAttributes = "";
			$this->Servicio_Internet->HrefValue = "";
			$this->Servicio_Internet->TooltipValue = "";

			// Estado_Internet
			$this->Estado_Internet->LinkCustomAttributes = "";
			$this->Estado_Internet->HrefValue = "";
			$this->Estado_Internet->TooltipValue = "";

			// Quien_Paga
			$this->Quien_Paga->LinkCustomAttributes = "";
			$this->Quien_Paga->HrefValue = "";
			$this->Quien_Paga->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->AdvancedSearch->SearchValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

			// Usuario_Conig
			$this->Usuario_Conig->EditAttrs["class"] = "form-control";
			$this->Usuario_Conig->EditCustomAttributes = "";
			$this->Usuario_Conig->EditValue = ew_HtmlEncode($this->Usuario_Conig->AdvancedSearch->SearchValue);
			$this->Usuario_Conig->PlaceHolder = ew_RemoveHtml($this->Usuario_Conig->FldCaption());

			// Password_Conig
			$this->Password_Conig->EditAttrs["class"] = "form-control";
			$this->Password_Conig->EditCustomAttributes = "";
			$this->Password_Conig->EditValue = ew_HtmlEncode($this->Password_Conig->AdvancedSearch->SearchValue);
			$this->Password_Conig->PlaceHolder = ew_RemoveHtml($this->Password_Conig->FldCaption());

			// Tiene_Internet
			$this->Tiene_Internet->EditCustomAttributes = "";
			$this->Tiene_Internet->EditValue = $this->Tiene_Internet->Options(FALSE);

			// Servicio_Internet
			$this->Servicio_Internet->EditAttrs["class"] = "form-control";
			$this->Servicio_Internet->EditCustomAttributes = "";
			$this->Servicio_Internet->EditValue = ew_HtmlEncode($this->Servicio_Internet->AdvancedSearch->SearchValue);
			$this->Servicio_Internet->PlaceHolder = ew_RemoveHtml($this->Servicio_Internet->FldCaption());

			// Estado_Internet
			$this->Estado_Internet->EditAttrs["class"] = "form-control";
			$this->Estado_Internet->EditCustomAttributes = "";
			$this->Estado_Internet->EditValue = $this->Estado_Internet->Options(TRUE);

			// Quien_Paga
			$this->Quien_Paga->EditAttrs["class"] = "form-control";
			$this->Quien_Paga->EditCustomAttributes = "";
			$this->Quien_Paga->EditValue = ew_HtmlEncode($this->Quien_Paga->AdvancedSearch->SearchValue);
			$this->Quien_Paga->PlaceHolder = ew_RemoveHtml($this->Quien_Paga->FldCaption());

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Actualizacion->AdvancedSearch->SearchValue, 0), 8));
			$this->Fecha_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualizacion->FldCaption());

			// Usuario
			$this->Usuario->EditAttrs["class"] = "form-control";
			$this->Usuario->EditCustomAttributes = "";
			$this->Usuario->EditValue = ew_HtmlEncode($this->Usuario->AdvancedSearch->SearchValue);
			$this->Usuario->PlaceHolder = ew_RemoveHtml($this->Usuario->FldCaption());
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
		if (!ew_CheckDateDef($this->Fecha_Actualizacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Actualizacion->FldErrMsg());
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
		$this->Cue->AdvancedSearch->Load();
		$this->Usuario_Conig->AdvancedSearch->Load();
		$this->Password_Conig->AdvancedSearch->Load();
		$this->Tiene_Internet->AdvancedSearch->Load();
		$this->Servicio_Internet->AdvancedSearch->Load();
		$this->Estado_Internet->AdvancedSearch->Load();
		$this->Quien_Paga->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datos_extras_escuelalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($datos_extras_escuela_search)) $datos_extras_escuela_search = new cdatos_extras_escuela_search();

// Page init
$datos_extras_escuela_search->Page_Init();

// Page main
$datos_extras_escuela_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datos_extras_escuela_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($datos_extras_escuela_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fdatos_extras_escuelasearch = new ew_Form("fdatos_extras_escuelasearch", "search");
<?php } else { ?>
var CurrentForm = fdatos_extras_escuelasearch = new ew_Form("fdatos_extras_escuelasearch", "search");
<?php } ?>

// Form_CustomValidate event
fdatos_extras_escuelasearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdatos_extras_escuelasearch.ValidateRequired = true;
<?php } else { ?>
fdatos_extras_escuelasearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdatos_extras_escuelasearch.Lists["x_Tiene_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelasearch.Lists["x_Tiene_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Tiene_Internet->Options()) ?>;
fdatos_extras_escuelasearch.Lists["x_Estado_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelasearch.Lists["x_Estado_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Estado_Internet->Options()) ?>;

// Form object for search
// Validate function for search

fdatos_extras_escuelasearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($datos_extras_escuela->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$datos_extras_escuela_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $datos_extras_escuela_search->ShowPageHeader(); ?>
<?php
$datos_extras_escuela_search->ShowMessage();
?>
<form name="fdatos_extras_escuelasearch" id="fdatos_extras_escuelasearch" class="<?php echo $datos_extras_escuela_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datos_extras_escuela_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datos_extras_escuela_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datos_extras_escuela">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($datos_extras_escuela_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($datos_extras_escuela->Cue->Visible) { // Cue ?>
	<div id="r_Cue" class="form-group">
		<label class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Cue"><?php echo $datos_extras_escuela->Cue->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue" id="z_Cue" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Cue->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Cue">
<input type="text" data-table="datos_extras_escuela" data-field="x_Cue" name="x_Cue" id="x_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Cue->EditValue ?>"<?php echo $datos_extras_escuela->Cue->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Usuario_Conig->Visible) { // Usuario_Conig ?>
	<div id="r_Usuario_Conig" class="form-group">
		<label for="x_Usuario_Conig" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Usuario_Conig"><?php echo $datos_extras_escuela->Usuario_Conig->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario_Conig" id="z_Usuario_Conig" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Usuario_Conig->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Usuario_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x_Usuario_Conig" id="x_Usuario_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Usuario_Conig->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Password_Conig->Visible) { // Password_Conig ?>
	<div id="r_Password_Conig" class="form-group">
		<label for="x_Password_Conig" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Password_Conig"><?php echo $datos_extras_escuela->Password_Conig->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Password_Conig" id="z_Password_Conig" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Password_Conig->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Password_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x_Password_Conig" id="x_Password_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Password_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Password_Conig->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Tiene_Internet->Visible) { // Tiene_Internet ?>
	<div id="r_Tiene_Internet" class="form-group">
		<label class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Tiene_Internet"><?php echo $datos_extras_escuela->Tiene_Internet->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tiene_Internet" id="z_Tiene_Internet" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Tiene_Internet->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Tiene_Internet">
<div id="tp_x_Tiene_Internet" class="ewTemplate"><input type="radio" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" data-value-separator="<?php echo $datos_extras_escuela->Tiene_Internet->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_Internet" id="x_Tiene_Internet" value="{value}"<?php echo $datos_extras_escuela->Tiene_Internet->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_Internet" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $datos_extras_escuela->Tiene_Internet->RadioButtonListHtml(FALSE, "x_Tiene_Internet") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Servicio_Internet->Visible) { // Servicio_Internet ?>
	<div id="r_Servicio_Internet" class="form-group">
		<label for="x_Servicio_Internet" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Servicio_Internet"><?php echo $datos_extras_escuela->Servicio_Internet->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Servicio_Internet" id="z_Servicio_Internet" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Servicio_Internet->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Servicio_Internet">
<input type="text" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x_Servicio_Internet" id="x_Servicio_Internet" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Servicio_Internet->EditValue ?>"<?php echo $datos_extras_escuela->Servicio_Internet->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Estado_Internet->Visible) { // Estado_Internet ?>
	<div id="r_Estado_Internet" class="form-group">
		<label for="x_Estado_Internet" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Estado_Internet"><?php echo $datos_extras_escuela->Estado_Internet->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Estado_Internet" id="z_Estado_Internet" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Estado_Internet->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Estado_Internet">
<select data-table="datos_extras_escuela" data-field="x_Estado_Internet" data-value-separator="<?php echo $datos_extras_escuela->Estado_Internet->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Internet" name="x_Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->EditAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->SelectOptionListHtml("x_Estado_Internet") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Quien_Paga->Visible) { // Quien_Paga ?>
	<div id="r_Quien_Paga" class="form-group">
		<label for="x_Quien_Paga" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Quien_Paga"><?php echo $datos_extras_escuela->Quien_Paga->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Quien_Paga" id="z_Quien_Paga" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Quien_Paga->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Quien_Paga">
<input type="text" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x_Quien_Paga" id="x_Quien_Paga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Quien_Paga->EditValue ?>"<?php echo $datos_extras_escuela->Quien_Paga->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Fecha_Actualizacion"><?php echo $datos_extras_escuela->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Fecha_Actualizacion">
<input type="text" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Fecha_Actualizacion->EditValue ?>"<?php echo $datos_extras_escuela->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($datos_extras_escuela->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $datos_extras_escuela_search->SearchLabelClass ?>"><span id="elh_datos_extras_escuela_Usuario"><?php echo $datos_extras_escuela->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $datos_extras_escuela_search->SearchRightColumnClass ?>"><div<?php echo $datos_extras_escuela->Usuario->CellAttributes() ?>>
			<span id="el_datos_extras_escuela_Usuario">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="35" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario->EditValue ?>"<?php echo $datos_extras_escuela->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$datos_extras_escuela_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdatos_extras_escuelasearch.Init();
</script>
<?php
$datos_extras_escuela_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datos_extras_escuela_search->Page_Terminate();
?>
