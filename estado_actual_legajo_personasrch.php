<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "estado_actual_legajo_personainfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$estado_actual_legajo_persona_search = NULL; // Initialize page object first

class cestado_actual_legajo_persona_search extends cestado_actual_legajo_persona {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'estado_actual_legajo_persona';

	// Page object name
	var $PageObjName = 'estado_actual_legajo_persona_search';

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

		// Table object (estado_actual_legajo_persona)
		if (!isset($GLOBALS["estado_actual_legajo_persona"]) || get_class($GLOBALS["estado_actual_legajo_persona"]) == "cestado_actual_legajo_persona") {
			$GLOBALS["estado_actual_legajo_persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_actual_legajo_persona"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_actual_legajo_persona', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("estado_actual_legajo_personalist.php"));
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
		$this->Dni->SetVisibility();
		$this->Matricula->SetVisibility();
		$this->Certificado_Pase->SetVisibility();
		$this->Tiene_DNI->SetVisibility();
		$this->Certificado_Medico->SetVisibility();
		$this->Posee_Autorizacion->SetVisibility();
		$this->Cooperadora->SetVisibility();
		$this->Archivos_Varios->SetVisibility();
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
		global $EW_EXPORT, $estado_actual_legajo_persona;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_actual_legajo_persona);
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
						$sSrchStr = "estado_actual_legajo_personalist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Matricula); // Matricula
		$this->BuildSearchUrl($sSrchUrl, $this->Certificado_Pase); // Certificado_Pase
		$this->BuildSearchUrl($sSrchUrl, $this->Tiene_DNI); // Tiene_DNI
		$this->BuildSearchUrl($sSrchUrl, $this->Certificado_Medico); // Certificado_Medico
		$this->BuildSearchUrl($sSrchUrl, $this->Posee_Autorizacion); // Posee_Autorizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Cooperadora); // Cooperadora
		$this->BuildSearchUrl($sSrchUrl, $this->Archivos_Varios); // Archivos Varios
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
		// Dni

		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Matricula
		$this->Matricula->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Matricula"));
		$this->Matricula->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Matricula");

		// Certificado_Pase
		$this->Certificado_Pase->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Certificado_Pase"));
		$this->Certificado_Pase->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Certificado_Pase");

		// Tiene_DNI
		$this->Tiene_DNI->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tiene_DNI"));
		$this->Tiene_DNI->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tiene_DNI");

		// Certificado_Medico
		$this->Certificado_Medico->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Certificado_Medico"));
		$this->Certificado_Medico->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Certificado_Medico");

		// Posee_Autorizacion
		$this->Posee_Autorizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Posee_Autorizacion"));
		$this->Posee_Autorizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Posee_Autorizacion");

		// Cooperadora
		$this->Cooperadora->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cooperadora"));
		$this->Cooperadora->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cooperadora");

		// Archivos Varios
		$this->Archivos_Varios->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Archivos_Varios"));
		$this->Archivos_Varios->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Archivos_Varios");

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
		// Dni
		// Matricula
		// Certificado_Pase
		// Tiene_DNI
		// Certificado_Medico
		// Posee_Autorizacion
		// Cooperadora
		// Archivos Varios
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Matricula
		if (strval($this->Matricula->CurrentValue) <> "") {
			$this->Matricula->ViewValue = $this->Matricula->OptionCaption($this->Matricula->CurrentValue);
		} else {
			$this->Matricula->ViewValue = NULL;
		}
		$this->Matricula->ViewCustomAttributes = "";

		// Certificado_Pase
		if (strval($this->Certificado_Pase->CurrentValue) <> "") {
			$this->Certificado_Pase->ViewValue = $this->Certificado_Pase->OptionCaption($this->Certificado_Pase->CurrentValue);
		} else {
			$this->Certificado_Pase->ViewValue = NULL;
		}
		$this->Certificado_Pase->ViewCustomAttributes = "";

		// Tiene_DNI
		if (strval($this->Tiene_DNI->CurrentValue) <> "") {
			$this->Tiene_DNI->ViewValue = $this->Tiene_DNI->OptionCaption($this->Tiene_DNI->CurrentValue);
		} else {
			$this->Tiene_DNI->ViewValue = NULL;
		}
		$this->Tiene_DNI->ViewCustomAttributes = "";

		// Certificado_Medico
		if (strval($this->Certificado_Medico->CurrentValue) <> "") {
			$this->Certificado_Medico->ViewValue = $this->Certificado_Medico->OptionCaption($this->Certificado_Medico->CurrentValue);
		} else {
			$this->Certificado_Medico->ViewValue = NULL;
		}
		$this->Certificado_Medico->ViewCustomAttributes = "";

		// Posee_Autorizacion
		if (strval($this->Posee_Autorizacion->CurrentValue) <> "") {
			$this->Posee_Autorizacion->ViewValue = $this->Posee_Autorizacion->OptionCaption($this->Posee_Autorizacion->CurrentValue);
		} else {
			$this->Posee_Autorizacion->ViewValue = NULL;
		}
		$this->Posee_Autorizacion->ViewCustomAttributes = "";

		// Cooperadora
		if (strval($this->Cooperadora->CurrentValue) <> "") {
			$this->Cooperadora->ViewValue = $this->Cooperadora->OptionCaption($this->Cooperadora->CurrentValue);
		} else {
			$this->Cooperadora->ViewValue = NULL;
		}
		$this->Cooperadora->ViewCustomAttributes = "";

		// Archivos Varios
		$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
		if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
			$this->Archivos_Varios->ImageAlt = $this->Archivos_Varios->FldAlt();
			$this->Archivos_Varios->ViewValue = $this->Archivos_Varios->Upload->DbValue;
		} else {
			$this->Archivos_Varios->ViewValue = "";
		}
		$this->Archivos_Varios->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Matricula
			$this->Matricula->LinkCustomAttributes = "";
			$this->Matricula->HrefValue = "";
			$this->Matricula->TooltipValue = "";

			// Certificado_Pase
			$this->Certificado_Pase->LinkCustomAttributes = "";
			$this->Certificado_Pase->HrefValue = "";
			$this->Certificado_Pase->TooltipValue = "";

			// Tiene_DNI
			$this->Tiene_DNI->LinkCustomAttributes = "";
			$this->Tiene_DNI->HrefValue = "";
			$this->Tiene_DNI->TooltipValue = "";

			// Certificado_Medico
			$this->Certificado_Medico->LinkCustomAttributes = "";
			$this->Certificado_Medico->HrefValue = "";
			$this->Certificado_Medico->TooltipValue = "";

			// Posee_Autorizacion
			$this->Posee_Autorizacion->LinkCustomAttributes = "";
			$this->Posee_Autorizacion->HrefValue = "";
			$this->Posee_Autorizacion->TooltipValue = "";

			// Cooperadora
			$this->Cooperadora->LinkCustomAttributes = "";
			$this->Cooperadora->HrefValue = "";
			$this->Cooperadora->TooltipValue = "";

			// Archivos Varios
			$this->Archivos_Varios->LinkCustomAttributes = "";
			$this->Archivos_Varios->UploadPath = 'ArchivosLegajoPersonas';
			if (!ew_Empty($this->Archivos_Varios->Upload->DbValue)) {
				$this->Archivos_Varios->HrefValue = "%u"; // Add prefix/suffix
				$this->Archivos_Varios->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Archivos_Varios->HrefValue = ew_ConvertFullUrl($this->Archivos_Varios->HrefValue);
			} else {
				$this->Archivos_Varios->HrefValue = "";
			}
			$this->Archivos_Varios->HrefValue2 = $this->Archivos_Varios->UploadPath . $this->Archivos_Varios->Upload->DbValue;
			$this->Archivos_Varios->TooltipValue = "";
			if ($this->Archivos_Varios->UseColorbox) {
				if (ew_Empty($this->Archivos_Varios->TooltipValue))
					$this->Archivos_Varios->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Archivos_Varios->LinkAttrs["data-rel"] = "estado_actual_legajo_persona_x_Archivos_Varios";
				ew_AppendClass($this->Archivos_Varios->LinkAttrs["class"], "ewLightbox");
			}

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Matricula
			$this->Matricula->EditCustomAttributes = "";
			$this->Matricula->EditValue = $this->Matricula->Options(FALSE);

			// Certificado_Pase
			$this->Certificado_Pase->EditCustomAttributes = "";
			$this->Certificado_Pase->EditValue = $this->Certificado_Pase->Options(FALSE);

			// Tiene_DNI
			$this->Tiene_DNI->EditCustomAttributes = "";
			$this->Tiene_DNI->EditValue = $this->Tiene_DNI->Options(FALSE);

			// Certificado_Medico
			$this->Certificado_Medico->EditCustomAttributes = "";
			$this->Certificado_Medico->EditValue = $this->Certificado_Medico->Options(FALSE);

			// Posee_Autorizacion
			$this->Posee_Autorizacion->EditCustomAttributes = "";
			$this->Posee_Autorizacion->EditValue = $this->Posee_Autorizacion->Options(FALSE);

			// Cooperadora
			$this->Cooperadora->EditCustomAttributes = "";
			$this->Cooperadora->EditValue = $this->Cooperadora->Options(FALSE);

			// Archivos Varios
			$this->Archivos_Varios->EditAttrs["class"] = "form-control";
			$this->Archivos_Varios->EditCustomAttributes = "";
			$this->Archivos_Varios->EditValue = ew_HtmlEncode($this->Archivos_Varios->AdvancedSearch->SearchValue);
			$this->Archivos_Varios->PlaceHolder = ew_RemoveHtml($this->Archivos_Varios->FldCaption());

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Actualizacion->AdvancedSearch->SearchValue, 7), 7));
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
		if (!ew_CheckInteger($this->Dni->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Actualizacion->AdvancedSearch->SearchValue)) {
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
		$this->Dni->AdvancedSearch->Load();
		$this->Matricula->AdvancedSearch->Load();
		$this->Certificado_Pase->AdvancedSearch->Load();
		$this->Tiene_DNI->AdvancedSearch->Load();
		$this->Certificado_Medico->AdvancedSearch->Load();
		$this->Posee_Autorizacion->AdvancedSearch->Load();
		$this->Cooperadora->AdvancedSearch->Load();
		$this->Archivos_Varios->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_actual_legajo_personalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($estado_actual_legajo_persona_search)) $estado_actual_legajo_persona_search = new cestado_actual_legajo_persona_search();

// Page init
$estado_actual_legajo_persona_search->Page_Init();

// Page main
$estado_actual_legajo_persona_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_actual_legajo_persona_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($estado_actual_legajo_persona_search->IsModal) { ?>
var CurrentAdvancedSearchForm = festado_actual_legajo_personasearch = new ew_Form("festado_actual_legajo_personasearch", "search");
<?php } else { ?>
var CurrentForm = festado_actual_legajo_personasearch = new ew_Form("festado_actual_legajo_personasearch", "search");
<?php } ?>

// Form_CustomValidate event
festado_actual_legajo_personasearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_actual_legajo_personasearch.ValidateRequired = true;
<?php } else { ?>
festado_actual_legajo_personasearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_actual_legajo_personasearch.Lists["x_Matricula"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Matricula"].Options = <?php echo json_encode($estado_actual_legajo_persona->Matricula->Options()) ?>;
festado_actual_legajo_personasearch.Lists["x_Certificado_Pase"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Certificado_Pase"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Pase->Options()) ?>;
festado_actual_legajo_personasearch.Lists["x_Tiene_DNI"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Tiene_DNI"].Options = <?php echo json_encode($estado_actual_legajo_persona->Tiene_DNI->Options()) ?>;
festado_actual_legajo_personasearch.Lists["x_Certificado_Medico"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Certificado_Medico"].Options = <?php echo json_encode($estado_actual_legajo_persona->Certificado_Medico->Options()) ?>;
festado_actual_legajo_personasearch.Lists["x_Posee_Autorizacion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Posee_Autorizacion"].Options = <?php echo json_encode($estado_actual_legajo_persona->Posee_Autorizacion->Options()) ?>;
festado_actual_legajo_personasearch.Lists["x_Cooperadora"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_actual_legajo_personasearch.Lists["x_Cooperadora"].Options = <?php echo json_encode($estado_actual_legajo_persona->Cooperadora->Options()) ?>;

// Form object for search
// Validate function for search

festado_actual_legajo_personasearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($estado_actual_legajo_persona->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($estado_actual_legajo_persona->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$estado_actual_legajo_persona_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estado_actual_legajo_persona_search->ShowPageHeader(); ?>
<?php
$estado_actual_legajo_persona_search->ShowMessage();
?>
<form name="festado_actual_legajo_personasearch" id="festado_actual_legajo_personasearch" class="<?php echo $estado_actual_legajo_persona_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_actual_legajo_persona_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_actual_legajo_persona_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_actual_legajo_persona">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($estado_actual_legajo_persona_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($estado_actual_legajo_persona->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Dni"><?php echo $estado_actual_legajo_persona->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Dni->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Dni">
<input type="text" data-table="estado_actual_legajo_persona" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Dni->getPlaceHolder()) ?>" value="<?php echo $estado_actual_legajo_persona->Dni->EditValue ?>"<?php echo $estado_actual_legajo_persona->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Matricula->Visible) { // Matricula ?>
	<div id="r_Matricula" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Matricula"><?php echo $estado_actual_legajo_persona->Matricula->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Matricula" id="z_Matricula" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Matricula->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Matricula">
<div id="tp_x_Matricula" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Matricula" data-value-separator="<?php echo $estado_actual_legajo_persona->Matricula->DisplayValueSeparatorAttribute() ?>" name="x_Matricula" id="x_Matricula" value="{value}"<?php echo $estado_actual_legajo_persona->Matricula->EditAttributes() ?>></div>
<div id="dsl_x_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Matricula->RadioButtonListHtml(FALSE, "x_Matricula") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Pase->Visible) { // Certificado_Pase ?>
	<div id="r_Certificado_Pase" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Certificado_Pase"><?php echo $estado_actual_legajo_persona->Certificado_Pase->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Certificado_Pase" id="z_Certificado_Pase" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Certificado_Pase->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Certificado_Pase">
<div id="tp_x_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Pase" id="x_Certificado_Pase" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Pase->RadioButtonListHtml(FALSE, "x_Certificado_Pase") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Tiene_DNI->Visible) { // Tiene_DNI ?>
	<div id="r_Tiene_DNI" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Tiene_DNI"><?php echo $estado_actual_legajo_persona->Tiene_DNI->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tiene_DNI" id="z_Tiene_DNI" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Tiene_DNI->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Tiene_DNI">
<div id="tp_x_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_actual_legajo_persona->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_DNI" id="x_Tiene_DNI" value="{value}"<?php echo $estado_actual_legajo_persona->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Tiene_DNI->RadioButtonListHtml(FALSE, "x_Tiene_DNI") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Certificado_Medico->Visible) { // Certificado_Medico ?>
	<div id="r_Certificado_Medico" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Certificado_Medico"><?php echo $estado_actual_legajo_persona->Certificado_Medico->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Certificado_Medico" id="z_Certificado_Medico" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Certificado_Medico->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Certificado_Medico">
<div id="tp_x_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_actual_legajo_persona->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Medico" id="x_Certificado_Medico" value="{value}"<?php echo $estado_actual_legajo_persona->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Certificado_Medico->RadioButtonListHtml(FALSE, "x_Certificado_Medico") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
	<div id="r_Posee_Autorizacion" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Posee_Autorizacion"><?php echo $estado_actual_legajo_persona->Posee_Autorizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Posee_Autorizacion" id="z_Posee_Autorizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Posee_Autorizacion">
<div id="tp_x_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x_Posee_Autorizacion" id="x_Posee_Autorizacion" value="{value}"<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x_Posee_Autorizacion") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Cooperadora->Visible) { // Cooperadora ?>
	<div id="r_Cooperadora" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Cooperadora"><?php echo $estado_actual_legajo_persona->Cooperadora->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cooperadora" id="z_Cooperadora" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Cooperadora->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Cooperadora">
<div id="tp_x_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_actual_legajo_persona" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_actual_legajo_persona->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x_Cooperadora" id="x_Cooperadora" value="{value}"<?php echo $estado_actual_legajo_persona->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_actual_legajo_persona->Cooperadora->RadioButtonListHtml(FALSE, "x_Cooperadora") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Archivos_Varios->Visible) { // Archivos Varios ?>
	<div id="r_Archivos_Varios" class="form-group">
		<label class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Archivos_Varios"><?php echo $estado_actual_legajo_persona->Archivos_Varios->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Archivos_Varios" id="z_Archivos_Varios" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Archivos_Varios->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Archivos_Varios">
<input type="text" data-table="estado_actual_legajo_persona" data-field="x_Archivos_Varios" name="x_Archivos_Varios" id="x_Archivos_Varios" placeholder="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Archivos_Varios->getPlaceHolder()) ?>" value="<?php echo $estado_actual_legajo_persona->Archivos_Varios->EditValue ?>"<?php echo $estado_actual_legajo_persona->Archivos_Varios->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Fecha_Actualizacion"><?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Fecha_Actualizacion">
<input type="text" data-table="estado_actual_legajo_persona" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->EditValue ?>"<?php echo $estado_actual_legajo_persona->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_actual_legajo_persona->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $estado_actual_legajo_persona_search->SearchLabelClass ?>"><span id="elh_estado_actual_legajo_persona_Usuario"><?php echo $estado_actual_legajo_persona->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_actual_legajo_persona_search->SearchRightColumnClass ?>"><div<?php echo $estado_actual_legajo_persona->Usuario->CellAttributes() ?>>
			<span id="el_estado_actual_legajo_persona_Usuario">
<input type="text" data-table="estado_actual_legajo_persona" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($estado_actual_legajo_persona->Usuario->getPlaceHolder()) ?>" value="<?php echo $estado_actual_legajo_persona->Usuario->EditValue ?>"<?php echo $estado_actual_legajo_persona->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$estado_actual_legajo_persona_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festado_actual_legajo_personasearch.Init();
</script>
<?php
$estado_actual_legajo_persona_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_actual_legajo_persona_search->Page_Terminate();
?>
