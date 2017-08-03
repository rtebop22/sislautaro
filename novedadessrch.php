<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "novedadesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$novedades_search = NULL; // Initialize page object first

class cnovedades_search extends cnovedades {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'novedades';

	// Page object name
	var $PageObjName = 'novedades_search';

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

		// Table object (novedades)
		if (!isset($GLOBALS["novedades"]) || get_class($GLOBALS["novedades"]) == "cnovedades") {
			$GLOBALS["novedades"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["novedades"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'novedades', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("novedadeslist.php"));
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
		$this->Id_Novedad->SetVisibility();
		$this->Id_Novedad->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Detalle->SetVisibility();
		$this->Archivos->SetVisibility();
		$this->Links->SetVisibility();
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
		global $EW_EXPORT, $novedades;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($novedades);
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
						$sSrchStr = "novedadeslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Novedad); // Id_Novedad
		$this->BuildSearchUrl($sSrchUrl, $this->Detalle); // Detalle
		$this->BuildSearchUrl($sSrchUrl, $this->Archivos); // Archivos
		$this->BuildSearchUrl($sSrchUrl, $this->Links); // Links
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
		// Id_Novedad

		$this->Id_Novedad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Novedad"));
		$this->Id_Novedad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Novedad");

		// Detalle
		$this->Detalle->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Detalle"));
		$this->Detalle->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Detalle");

		// Archivos
		$this->Archivos->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Archivos"));
		$this->Archivos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Archivos");

		// Links
		$this->Links->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Links"));
		$this->Links->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Links");

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
		// Id_Novedad
		// Detalle
		// Archivos
		// Links
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Novedad
		$this->Id_Novedad->ViewValue = $this->Id_Novedad->CurrentValue;
		$this->Id_Novedad->ViewCustomAttributes = "";

		// Detalle
		$this->Detalle->ViewValue = $this->Detalle->CurrentValue;
		$this->Detalle->ViewCustomAttributes = "";

		// Archivos
		$this->Archivos->UploadPath = 'ArchivosNovedades';
		if (!ew_Empty($this->Archivos->Upload->DbValue)) {
			$this->Archivos->ImageAlt = $this->Archivos->FldAlt();
			$this->Archivos->ViewValue = $this->Archivos->Upload->DbValue;
		} else {
			$this->Archivos->ViewValue = "";
		}
		$this->Archivos->ViewCustomAttributes = "";

		// Links
		$this->Links->ViewValue = $this->Links->CurrentValue;
		$this->Links->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Id_Novedad
			$this->Id_Novedad->LinkCustomAttributes = "";
			$this->Id_Novedad->HrefValue = "";
			$this->Id_Novedad->TooltipValue = "";

			// Detalle
			$this->Detalle->LinkCustomAttributes = "";
			$this->Detalle->HrefValue = "";
			$this->Detalle->TooltipValue = "";

			// Archivos
			$this->Archivos->LinkCustomAttributes = "";
			$this->Archivos->UploadPath = 'ArchivosNovedades';
			if (!ew_Empty($this->Archivos->Upload->DbValue)) {
				$this->Archivos->HrefValue = ew_GetFileUploadUrl($this->Archivos, $this->Archivos->Upload->DbValue); // Add prefix/suffix
				$this->Archivos->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos->HrefValue = ew_ConvertFullUrl($this->Archivos->HrefValue);
			} else {
				$this->Archivos->HrefValue = "";
			}
			$this->Archivos->HrefValue2 = $this->Archivos->UploadPath . $this->Archivos->Upload->DbValue;
			$this->Archivos->TooltipValue = "";
			if ($this->Archivos->UseColorbox) {
				if (ew_Empty($this->Archivos->TooltipValue))
					$this->Archivos->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Archivos->LinkAttrs["data-rel"] = "novedades_x_Archivos";
				ew_AppendClass($this->Archivos->LinkAttrs["class"], "ewLightbox");
			}

			// Links
			$this->Links->LinkCustomAttributes = "";
			if (!ew_Empty($this->Links->CurrentValue)) {
				$this->Links->HrefValue = "http://" . $this->Links->CurrentValue; // Add prefix/suffix
				$this->Links->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Links->HrefValue = ew_ConvertFullUrl($this->Links->HrefValue);
			} else {
				$this->Links->HrefValue = "";
			}
			$this->Links->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Novedad
			$this->Id_Novedad->EditAttrs["class"] = "form-control";
			$this->Id_Novedad->EditCustomAttributes = "";
			$this->Id_Novedad->EditValue = ew_HtmlEncode($this->Id_Novedad->AdvancedSearch->SearchValue);
			$this->Id_Novedad->PlaceHolder = ew_RemoveHtml($this->Id_Novedad->FldCaption());

			// Detalle
			$this->Detalle->EditAttrs["class"] = "form-control";
			$this->Detalle->EditCustomAttributes = "";
			$this->Detalle->EditValue = ew_HtmlEncode($this->Detalle->AdvancedSearch->SearchValue);
			$this->Detalle->PlaceHolder = ew_RemoveHtml($this->Detalle->FldCaption());

			// Archivos
			$this->Archivos->EditAttrs["class"] = "form-control";
			$this->Archivos->EditCustomAttributes = "";
			$this->Archivos->EditValue = ew_HtmlEncode($this->Archivos->AdvancedSearch->SearchValue);
			$this->Archivos->PlaceHolder = ew_RemoveHtml($this->Archivos->FldCaption());

			// Links
			$this->Links->EditAttrs["class"] = "form-control";
			$this->Links->EditCustomAttributes = "";
			$this->Links->EditValue = ew_HtmlEncode($this->Links->AdvancedSearch->SearchValue);
			$this->Links->PlaceHolder = ew_RemoveHtml($this->Links->FldCaption());

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
		if (!ew_CheckInteger($this->Id_Novedad->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Id_Novedad->FldErrMsg());
		}
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
		$this->Id_Novedad->AdvancedSearch->Load();
		$this->Detalle->AdvancedSearch->Load();
		$this->Archivos->AdvancedSearch->Load();
		$this->Links->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("novedadeslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($novedades_search)) $novedades_search = new cnovedades_search();

// Page init
$novedades_search->Page_Init();

// Page main
$novedades_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$novedades_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($novedades_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fnovedadessearch = new ew_Form("fnovedadessearch", "search");
<?php } else { ?>
var CurrentForm = fnovedadessearch = new ew_Form("fnovedadessearch", "search");
<?php } ?>

// Form_CustomValidate event
fnovedadessearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnovedadessearch.ValidateRequired = true;
<?php } else { ?>
fnovedadessearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search
// Validate function for search

fnovedadessearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Id_Novedad");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($novedades->Id_Novedad->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($novedades->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$novedades_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $novedades_search->ShowPageHeader(); ?>
<?php
$novedades_search->ShowMessage();
?>
<form name="fnovedadessearch" id="fnovedadessearch" class="<?php echo $novedades_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($novedades_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $novedades_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="novedades">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($novedades_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($novedades->Id_Novedad->Visible) { // Id_Novedad ?>
	<div id="r_Id_Novedad" class="form-group">
		<label for="x_Id_Novedad" class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Id_Novedad"><?php echo $novedades->Id_Novedad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Novedad" id="z_Id_Novedad" value="="></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Id_Novedad->CellAttributes() ?>>
			<span id="el_novedades_Id_Novedad">
<input type="text" data-table="novedades" data-field="x_Id_Novedad" name="x_Id_Novedad" id="x_Id_Novedad" placeholder="<?php echo ew_HtmlEncode($novedades->Id_Novedad->getPlaceHolder()) ?>" value="<?php echo $novedades->Id_Novedad->EditValue ?>"<?php echo $novedades->Id_Novedad->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($novedades->Detalle->Visible) { // Detalle ?>
	<div id="r_Detalle" class="form-group">
		<label for="x_Detalle" class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Detalle"><?php echo $novedades->Detalle->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Detalle" id="z_Detalle" value="LIKE"></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Detalle->CellAttributes() ?>>
			<span id="el_novedades_Detalle">
<input type="text" data-table="novedades" data-field="x_Detalle" name="x_Detalle" id="x_Detalle" size="35" placeholder="<?php echo ew_HtmlEncode($novedades->Detalle->getPlaceHolder()) ?>" value="<?php echo $novedades->Detalle->EditValue ?>"<?php echo $novedades->Detalle->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($novedades->Archivos->Visible) { // Archivos ?>
	<div id="r_Archivos" class="form-group">
		<label class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Archivos"><?php echo $novedades->Archivos->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Archivos" id="z_Archivos" value="LIKE"></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Archivos->CellAttributes() ?>>
			<span id="el_novedades_Archivos">
<input type="text" data-table="novedades" data-field="x_Archivos" name="x_Archivos" id="x_Archivos" placeholder="<?php echo ew_HtmlEncode($novedades->Archivos->getPlaceHolder()) ?>" value="<?php echo $novedades->Archivos->EditValue ?>"<?php echo $novedades->Archivos->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($novedades->Links->Visible) { // Links ?>
	<div id="r_Links" class="form-group">
		<label for="x_Links" class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Links"><?php echo $novedades->Links->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Links" id="z_Links" value="LIKE"></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Links->CellAttributes() ?>>
			<span id="el_novedades_Links">
<input type="text" data-table="novedades" data-field="x_Links" name="x_Links" id="x_Links" placeholder="<?php echo ew_HtmlEncode($novedades->Links->getPlaceHolder()) ?>" value="<?php echo $novedades->Links->EditValue ?>"<?php echo $novedades->Links->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($novedades->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Fecha_Actualizacion"><?php echo $novedades->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_novedades_Fecha_Actualizacion">
<input type="text" data-table="novedades" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($novedades->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $novedades->Fecha_Actualizacion->EditValue ?>"<?php echo $novedades->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($novedades->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $novedades_search->SearchLabelClass ?>"><span id="elh_novedades_Usuario"><?php echo $novedades->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $novedades_search->SearchRightColumnClass ?>"><div<?php echo $novedades->Usuario->CellAttributes() ?>>
			<span id="el_novedades_Usuario">
<input type="text" data-table="novedades" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($novedades->Usuario->getPlaceHolder()) ?>" value="<?php echo $novedades->Usuario->EditValue ?>"<?php echo $novedades->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$novedades_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fnovedadessearch.Init();
</script>
<?php
$novedades_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$novedades_search->Page_Terminate();
?>
