<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tutoresinfo.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tutores_search = NULL; // Initialize page object first

class ctutores_search extends ctutores {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'tutores';

	// Page object name
	var $PageObjName = 'tutores_search';

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

		// Table object (tutores)
		if (!isset($GLOBALS["tutores"]) || get_class($GLOBALS["tutores"]) == "ctutores") {
			$GLOBALS["tutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tutores"];
		}

		// Table object (personas)
		if (!isset($GLOBALS['personas'])) $GLOBALS['personas'] = new cpersonas();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tutores', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tutoreslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Dni_Tutor->SetVisibility();
		$this->Apellidos_Nombres->SetVisibility();
		$this->Edad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Tel_Contacto->SetVisibility();
		$this->Fecha_Nac->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->MasHijos->SetVisibility();
		$this->Id_Estado_Civil->SetVisibility();
		$this->Id_Sexo->SetVisibility();
		$this->Id_Relacion->SetVisibility();
		$this->Id_Ocupacion->SetVisibility();
		$this->Lugar_Nacimiento->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->User_Actualiz->SetVisibility();

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
		global $EW_EXPORT, $tutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tutores);
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
						$sSrchStr = "tutoreslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Dni_Tutor); // Dni_Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->Apellidos_Nombres); // Apellidos_Nombres
		$this->BuildSearchUrl($sSrchUrl, $this->Edad); // Edad
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio); // Domicilio
		$this->BuildSearchUrl($sSrchUrl, $this->Tel_Contacto); // Tel_Contacto
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Nac); // Fecha_Nac
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil); // Cuil
		$this->BuildSearchUrl($sSrchUrl, $this->MasHijos); // MasHijos
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Civil); // Id_Estado_Civil
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Sexo); // Id_Sexo
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Relacion); // Id_Relacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Ocupacion); // Id_Ocupacion
		$this->BuildSearchUrl($sSrchUrl, $this->Lugar_Nacimiento); // Lugar_Nacimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Provincia); // Id_Provincia
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Departamento); // Id_Departamento
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Localidad); // Id_Localidad
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Actualizacion); // Fecha_Actualizacion
		$this->BuildSearchUrl($sSrchUrl, $this->User_Actualiz); // User_Actualiz
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
		// Dni_Tutor

		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni_Tutor"));
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni_Tutor");

		// Apellidos_Nombres
		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellidos_Nombres"));
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellidos_Nombres");

		// Edad
		$this->Edad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Edad"));
		$this->Edad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Edad");

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio"));
		$this->Domicilio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio");

		// Tel_Contacto
		$this->Tel_Contacto->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tel_Contacto"));
		$this->Tel_Contacto->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tel_Contacto");

		// Fecha_Nac
		$this->Fecha_Nac->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Nac"));
		$this->Fecha_Nac->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Nac");

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil"));
		$this->Cuil->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil");

		// MasHijos
		$this->MasHijos->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_MasHijos"));
		$this->MasHijos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_MasHijos");

		// Id_Estado_Civil
		$this->Id_Estado_Civil->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Civil"));
		$this->Id_Estado_Civil->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Civil");

		// Id_Sexo
		$this->Id_Sexo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Sexo"));
		$this->Id_Sexo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Sexo");

		// Id_Relacion
		$this->Id_Relacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Relacion"));
		$this->Id_Relacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Relacion");

		// Id_Ocupacion
		$this->Id_Ocupacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Ocupacion"));
		$this->Id_Ocupacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Ocupacion");

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Lugar_Nacimiento"));
		$this->Lugar_Nacimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Lugar_Nacimiento");

		// Id_Provincia
		$this->Id_Provincia->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Provincia"));
		$this->Id_Provincia->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Provincia");

		// Id_Departamento
		$this->Id_Departamento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Departamento"));
		$this->Id_Departamento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Departamento");

		// Id_Localidad
		$this->Id_Localidad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Localidad"));
		$this->Id_Localidad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Localidad");

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Actualizacion"));
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Actualizacion");

		// User_Actualiz
		$this->User_Actualiz->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_User_Actualiz"));
		$this->User_Actualiz->AdvancedSearch->SearchOperator = $objForm->GetValue("z_User_Actualiz");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Dni_Tutor
		// Apellidos_Nombres
		// Edad
		// Domicilio
		// Tel_Contacto
		// Fecha_Nac
		// Cuil
		// MasHijos
		// Id_Estado_Civil
		// Id_Sexo
		// Id_Relacion
		// Id_Ocupacion
		// Lugar_Nacimiento
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// User_Actualiz

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Edad
		$this->Edad->ViewValue = $this->Edad->CurrentValue;
		$this->Edad->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Contacto
		$this->Tel_Contacto->ViewValue = $this->Tel_Contacto->CurrentValue;
		$this->Tel_Contacto->ViewCustomAttributes = "";

		// Fecha_Nac
		$this->Fecha_Nac->ViewValue = $this->Fecha_Nac->CurrentValue;
		$this->Fecha_Nac->ViewValue = ew_FormatDateTime($this->Fecha_Nac->ViewValue, 7);
		$this->Fecha_Nac->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// MasHijos
		if (strval($this->MasHijos->CurrentValue) <> "") {
			$this->MasHijos->ViewValue = $this->MasHijos->OptionCaption($this->MasHijos->CurrentValue);
		} else {
			$this->MasHijos->ViewValue = NULL;
		}
		$this->MasHijos->ViewCustomAttributes = "";

		// Id_Estado_Civil
		if (strval($this->Id_Estado_Civil->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Civil`" . ew_SearchString("=", $this->Id_Estado_Civil->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Civil`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_civil`";
		$sWhereWrk = "";
		$this->Id_Estado_Civil->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Civil->ViewValue = $this->Id_Estado_Civil->CurrentValue;
			}
		} else {
			$this->Id_Estado_Civil->ViewValue = NULL;
		}
		$this->Id_Estado_Civil->ViewCustomAttributes = "";

		// Id_Sexo
		if (strval($this->Id_Sexo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Sexo`" . ew_SearchString("=", $this->Id_Sexo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Sexo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sexo_personas`";
		$sWhereWrk = "";
		$this->Id_Sexo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Sexo->ViewValue = $this->Id_Sexo->CurrentValue;
			}
		} else {
			$this->Id_Sexo->ViewValue = NULL;
		}
		$this->Id_Sexo->ViewCustomAttributes = "";

		// Id_Relacion
		if (strval($this->Id_Relacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
		$sWhereWrk = "";
		$this->Id_Relacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Relacion->ViewValue = $this->Id_Relacion->CurrentValue;
			}
		} else {
			$this->Id_Relacion->ViewValue = NULL;
		}
		$this->Id_Relacion->ViewCustomAttributes = "";

		// Id_Ocupacion
		$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->CurrentValue;
		if (strval($this->Id_Ocupacion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Ocupacion`" . ew_SearchString("=", $this->Id_Ocupacion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
		$sWhereWrk = "";
		$this->Id_Ocupacion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Ocupacion->ViewValue = $this->Id_Ocupacion->CurrentValue;
			}
		} else {
			$this->Id_Ocupacion->ViewValue = NULL;
		}
		$this->Id_Ocupacion->ViewCustomAttributes = "";

		// Lugar_Nacimiento
		$this->Lugar_Nacimiento->ViewValue = $this->Lugar_Nacimiento->CurrentValue;
		$this->Lugar_Nacimiento->ViewCustomAttributes = "";

		// Id_Provincia
		if (strval($this->Id_Provincia->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
		$sWhereWrk = "";
		$this->Id_Provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Provincia->ViewValue = $this->Id_Provincia->CurrentValue;
			}
		} else {
			$this->Id_Provincia->ViewValue = NULL;
		}
		$this->Id_Provincia->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->CurrentValue;
			}
		} else {
			$this->Id_Departamento->ViewValue = NULL;
		}
		$this->Id_Departamento->ViewCustomAttributes = "";

		// Id_Localidad
		if (strval($this->Id_Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Id_Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->CurrentValue;
			}
		} else {
			$this->Id_Localidad->ViewValue = NULL;
		}
		$this->Id_Localidad->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// User_Actualiz
		$this->User_Actualiz->ViewValue = $this->User_Actualiz->CurrentValue;
		$this->User_Actualiz->ViewCustomAttributes = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";
			$this->Apellidos_Nombres->TooltipValue = "";

			// Edad
			$this->Edad->LinkCustomAttributes = "";
			$this->Edad->HrefValue = "";
			$this->Edad->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Tel_Contacto
			$this->Tel_Contacto->LinkCustomAttributes = "";
			$this->Tel_Contacto->HrefValue = "";
			$this->Tel_Contacto->TooltipValue = "";

			// Fecha_Nac
			$this->Fecha_Nac->LinkCustomAttributes = "";
			$this->Fecha_Nac->HrefValue = "";
			$this->Fecha_Nac->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// MasHijos
			$this->MasHijos->LinkCustomAttributes = "";
			$this->MasHijos->HrefValue = "";
			$this->MasHijos->TooltipValue = "";

			// Id_Estado_Civil
			$this->Id_Estado_Civil->LinkCustomAttributes = "";
			$this->Id_Estado_Civil->HrefValue = "";
			$this->Id_Estado_Civil->TooltipValue = "";

			// Id_Sexo
			$this->Id_Sexo->LinkCustomAttributes = "";
			$this->Id_Sexo->HrefValue = "";
			$this->Id_Sexo->TooltipValue = "";

			// Id_Relacion
			$this->Id_Relacion->LinkCustomAttributes = "";
			$this->Id_Relacion->HrefValue = "";
			$this->Id_Relacion->TooltipValue = "";

			// Id_Ocupacion
			$this->Id_Ocupacion->LinkCustomAttributes = "";
			$this->Id_Ocupacion->HrefValue = "";
			$this->Id_Ocupacion->TooltipValue = "";

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->LinkCustomAttributes = "";
			$this->Lugar_Nacimiento->HrefValue = "";
			$this->Lugar_Nacimiento->TooltipValue = "";

			// Id_Provincia
			$this->Id_Provincia->LinkCustomAttributes = "";
			$this->Id_Provincia->HrefValue = "";
			$this->Id_Provincia->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// User_Actualiz
			$this->User_Actualiz->LinkCustomAttributes = "";
			$this->User_Actualiz->HrefValue = "";
			$this->User_Actualiz->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->AdvancedSearch->SearchValue);
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->AdvancedSearch->SearchValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Edad
			$this->Edad->EditAttrs["class"] = "form-control";
			$this->Edad->EditCustomAttributes = "";
			$this->Edad->EditValue = ew_HtmlEncode($this->Edad->AdvancedSearch->SearchValue);
			$this->Edad->PlaceHolder = ew_RemoveHtml($this->Edad->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Tel_Contacto
			$this->Tel_Contacto->EditAttrs["class"] = "form-control";
			$this->Tel_Contacto->EditCustomAttributes = "";
			$this->Tel_Contacto->EditValue = ew_HtmlEncode($this->Tel_Contacto->AdvancedSearch->SearchValue);
			$this->Tel_Contacto->PlaceHolder = ew_RemoveHtml($this->Tel_Contacto->FldCaption());

			// Fecha_Nac
			$this->Fecha_Nac->EditAttrs["class"] = "form-control";
			$this->Fecha_Nac->EditCustomAttributes = "";
			$this->Fecha_Nac->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Nac->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Nac->PlaceHolder = ew_RemoveHtml($this->Fecha_Nac->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->AdvancedSearch->SearchValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// MasHijos
			$this->MasHijos->EditCustomAttributes = "";
			$this->MasHijos->EditValue = $this->MasHijos->Options(FALSE);

			// Id_Estado_Civil
			$this->Id_Estado_Civil->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Civil->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Civil->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Civil`" . ew_SearchString("=", $this->Id_Estado_Civil->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Civil`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_civil`";
			$sWhereWrk = "";
			$this->Id_Estado_Civil->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Civil->EditValue = $arwrk;

			// Id_Sexo
			$this->Id_Sexo->EditAttrs["class"] = "form-control";
			$this->Id_Sexo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Sexo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Sexo`" . ew_SearchString("=", $this->Id_Sexo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Sexo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sexo_personas`";
			$sWhereWrk = "";
			$this->Id_Sexo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Sexo->EditValue = $arwrk;

			// Id_Relacion
			$this->Id_Relacion->EditAttrs["class"] = "form-control";
			$this->Id_Relacion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Relacion->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Relacion`" . ew_SearchString("=", $this->Id_Relacion->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Relacion`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Relacion->EditValue = $arwrk;

			// Id_Ocupacion
			$this->Id_Ocupacion->EditAttrs["class"] = "form-control";
			$this->Id_Ocupacion->EditCustomAttributes = "";
			$this->Id_Ocupacion->EditValue = ew_HtmlEncode($this->Id_Ocupacion->AdvancedSearch->SearchValue);
			if (strval($this->Id_Ocupacion->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Id_Ocupacion`" . ew_SearchString("=", $this->Id_Ocupacion->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
			$sWhereWrk = "";
			$this->Id_Ocupacion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Id_Ocupacion->EditValue = $this->Id_Ocupacion->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Ocupacion->EditValue = ew_HtmlEncode($this->Id_Ocupacion->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Id_Ocupacion->EditValue = NULL;
			}
			$this->Id_Ocupacion->PlaceHolder = ew_RemoveHtml($this->Id_Ocupacion->FldCaption());

			// Lugar_Nacimiento
			$this->Lugar_Nacimiento->EditAttrs["class"] = "form-control";
			$this->Lugar_Nacimiento->EditCustomAttributes = "";
			$this->Lugar_Nacimiento->EditValue = ew_HtmlEncode($this->Lugar_Nacimiento->AdvancedSearch->SearchValue);
			$this->Lugar_Nacimiento->PlaceHolder = ew_RemoveHtml($this->Lugar_Nacimiento->FldCaption());

			// Id_Provincia
			$this->Id_Provincia->EditAttrs["class"] = "form-control";
			$this->Id_Provincia->EditCustomAttributes = "";
			if (trim(strval($this->Id_Provincia->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Provincia`" . ew_SearchString("=", $this->Id_Provincia->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Provincia`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Provincia->EditValue = $arwrk;

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode($this->Fecha_Actualizacion->AdvancedSearch->SearchValue);
			$this->Fecha_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualizacion->FldCaption());

			// User_Actualiz
			$this->User_Actualiz->EditAttrs["class"] = "form-control";
			$this->User_Actualiz->EditCustomAttributes = "";
			$this->User_Actualiz->EditValue = ew_HtmlEncode($this->User_Actualiz->AdvancedSearch->SearchValue);
			$this->User_Actualiz->PlaceHolder = ew_RemoveHtml($this->User_Actualiz->FldCaption());
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
		if (!ew_CheckInteger($this->Dni_Tutor->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni_Tutor->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Nac->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Nac->FldErrMsg());
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
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Edad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Contacto->AdvancedSearch->Load();
		$this->Fecha_Nac->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->MasHijos->AdvancedSearch->Load();
		$this->Id_Estado_Civil->AdvancedSearch->Load();
		$this->Id_Sexo->AdvancedSearch->Load();
		$this->Id_Relacion->AdvancedSearch->Load();
		$this->Id_Ocupacion->AdvancedSearch->Load();
		$this->Lugar_Nacimiento->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->User_Actualiz->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tutoreslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Estado_Civil":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Civil` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_civil`";
			$sWhereWrk = "";
			$this->Id_Estado_Civil->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Civil` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Civil, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Sexo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Sexo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sexo_personas`";
			$sWhereWrk = "";
			$this->Id_Sexo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Sexo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Sexo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Relacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Relacion` AS `LinkFld`, `Desripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_relacion_alumno_tutor`";
			$sWhereWrk = "";
			$this->Id_Relacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Relacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Relacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Ocupacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ocupacion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ocupacion_tutor`";
			$sWhereWrk = "{filter}";
			$this->Id_Ocupacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Ocupacion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Provincia":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Provincia` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provincias`";
			$sWhereWrk = "";
			$this->Id_Provincia->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Provincia` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "{filter}";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Provincia` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Localidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Localidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->Id_Localidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Localidad` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Departamento` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
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
		case "x_Id_Ocupacion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Ocupacion`, `Descripcion` AS `DispFld` FROM `ocupacion_tutor`";
			$sWhereWrk = "`Descripcion` LIKE '{query_value}%'";
			$this->Id_Ocupacion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Ocupacion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($tutores_search)) $tutores_search = new ctutores_search();

// Page init
$tutores_search->Page_Init();

// Page main
$tutores_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tutores_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($tutores_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ftutoressearch = new ew_Form("ftutoressearch", "search");
<?php } else { ?>
var CurrentForm = ftutoressearch = new ew_Form("ftutoressearch", "search");
<?php } ?>

// Form_CustomValidate event
ftutoressearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftutoressearch.ValidateRequired = true;
<?php } else { ?>
ftutoressearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftutoressearch.Lists["x_MasHijos"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftutoressearch.Lists["x_MasHijos"].Options = <?php echo json_encode($tutores->MasHijos->Options()) ?>;
ftutoressearch.Lists["x_Id_Estado_Civil"] = {"LinkField":"x_Id_Estado_Civil","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_civil"};
ftutoressearch.Lists["x_Id_Sexo"] = {"LinkField":"x_Id_Sexo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sexo_personas"};
ftutoressearch.Lists["x_Id_Relacion"] = {"LinkField":"x_Id_Relacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Desripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_relacion_alumno_tutor"};
ftutoressearch.Lists["x_Id_Ocupacion"] = {"LinkField":"x_Id_Ocupacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ocupacion_tutor"};
ftutoressearch.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
ftutoressearch.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
ftutoressearch.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
// Validate function for search

ftutoressearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni_Tutor");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Dni_Tutor->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Nac");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Fecha_Nac->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tutores_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tutores_search->ShowPageHeader(); ?>
<?php
$tutores_search->ShowMessage();
?>
<form name="ftutoressearch" id="ftutoressearch" class="<?php echo $tutores_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tutores_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tutores_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tutores">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($tutores_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label for="x_Dni_Tutor" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Dni_Tutor"><?php echo $tutores->Dni_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni_Tutor" id="z_Dni_Tutor" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Dni_Tutor->CellAttributes() ?>>
			<span id="el_tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x_Dni_Tutor" id="x_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<div id="r_Apellidos_Nombres" class="form-group">
		<label for="x_Apellidos_Nombres" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Apellidos_Nombres"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellidos_Nombres" id="z_Apellidos_Nombres" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Apellidos_Nombres->CellAttributes() ?>>
			<span id="el_tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x_Apellidos_Nombres" id="x_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Edad->Visible) { // Edad ?>
	<div id="r_Edad" class="form-group">
		<label for="x_Edad" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Edad"><?php echo $tutores->Edad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Edad" id="z_Edad" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Edad->CellAttributes() ?>>
			<span id="el_tutores_Edad">
<input type="text" data-table="tutores" data-field="x_Edad" name="x_Edad" id="x_Edad" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($tutores->Edad->getPlaceHolder()) ?>" value="<?php echo $tutores->Edad->EditValue ?>"<?php echo $tutores->Edad->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Domicilio"><?php echo $tutores->Domicilio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio" id="z_Domicilio" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Domicilio->CellAttributes() ?>>
			<span id="el_tutores_Domicilio">
<input type="text" data-table="tutores" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Domicilio->getPlaceHolder()) ?>" value="<?php echo $tutores->Domicilio->EditValue ?>"<?php echo $tutores->Domicilio->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
	<div id="r_Tel_Contacto" class="form-group">
		<label for="x_Tel_Contacto" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Tel_Contacto"><?php echo $tutores->Tel_Contacto->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tel_Contacto" id="z_Tel_Contacto" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Tel_Contacto->CellAttributes() ?>>
			<span id="el_tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x_Tel_Contacto" id="x_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Fecha_Nac->Visible) { // Fecha_Nac ?>
	<div id="r_Fecha_Nac" class="form-group">
		<label for="x_Fecha_Nac" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Fecha_Nac"><?php echo $tutores->Fecha_Nac->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Nac" id="z_Fecha_Nac" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Fecha_Nac->CellAttributes() ?>>
			<span id="el_tutores_Fecha_Nac">
<input type="text" data-table="tutores" data-field="x_Fecha_Nac" data-format="7" name="x_Fecha_Nac" id="x_Fecha_Nac" placeholder="<?php echo ew_HtmlEncode($tutores->Fecha_Nac->getPlaceHolder()) ?>" value="<?php echo $tutores->Fecha_Nac->EditValue ?>"<?php echo $tutores->Fecha_Nac->EditAttributes() ?>>
<?php if (!$tutores->Fecha_Nac->ReadOnly && !$tutores->Fecha_Nac->Disabled && !isset($tutores->Fecha_Nac->EditAttrs["readonly"]) && !isset($tutores->Fecha_Nac->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftutoressearch", "x_Fecha_Nac", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Cuil->Visible) { // Cuil ?>
	<div id="r_Cuil" class="form-group">
		<label for="x_Cuil" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Cuil"><?php echo $tutores->Cuil->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil" id="z_Cuil" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Cuil->CellAttributes() ?>>
			<span id="el_tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x_Cuil" id="x_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->MasHijos->Visible) { // MasHijos ?>
	<div id="r_MasHijos" class="form-group">
		<label class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_MasHijos"><?php echo $tutores->MasHijos->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_MasHijos" id="z_MasHijos" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->MasHijos->CellAttributes() ?>>
			<span id="el_tutores_MasHijos">
<div id="tp_x_MasHijos" class="ewTemplate"><input type="radio" data-table="tutores" data-field="x_MasHijos" data-value-separator="<?php echo $tutores->MasHijos->DisplayValueSeparatorAttribute() ?>" name="x_MasHijos" id="x_MasHijos" value="{value}"<?php echo $tutores->MasHijos->EditAttributes() ?>></div>
<div id="dsl_x_MasHijos" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tutores->MasHijos->RadioButtonListHtml(FALSE, "x_MasHijos") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Estado_Civil->Visible) { // Id_Estado_Civil ?>
	<div id="r_Id_Estado_Civil" class="form-group">
		<label for="x_Id_Estado_Civil" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Estado_Civil"><?php echo $tutores->Id_Estado_Civil->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado_Civil" id="z_Id_Estado_Civil" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Estado_Civil->CellAttributes() ?>>
			<span id="el_tutores_Id_Estado_Civil">
<select data-table="tutores" data-field="x_Id_Estado_Civil" data-value-separator="<?php echo $tutores->Id_Estado_Civil->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Civil" name="x_Id_Estado_Civil"<?php echo $tutores->Id_Estado_Civil->EditAttributes() ?>>
<?php echo $tutores->Id_Estado_Civil->SelectOptionListHtml("x_Id_Estado_Civil") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Civil" id="s_x_Id_Estado_Civil" value="<?php echo $tutores->Id_Estado_Civil->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Sexo->Visible) { // Id_Sexo ?>
	<div id="r_Id_Sexo" class="form-group">
		<label for="x_Id_Sexo" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Sexo"><?php echo $tutores->Id_Sexo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Sexo" id="z_Id_Sexo" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Sexo->CellAttributes() ?>>
			<span id="el_tutores_Id_Sexo">
<select data-table="tutores" data-field="x_Id_Sexo" data-value-separator="<?php echo $tutores->Id_Sexo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Sexo" name="x_Id_Sexo"<?php echo $tutores->Id_Sexo->EditAttributes() ?>>
<?php echo $tutores->Id_Sexo->SelectOptionListHtml("x_Id_Sexo") ?>
</select>
<input type="hidden" name="s_x_Id_Sexo" id="s_x_Id_Sexo" value="<?php echo $tutores->Id_Sexo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
	<div id="r_Id_Relacion" class="form-group">
		<label for="x_Id_Relacion" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Relacion"><?php echo $tutores->Id_Relacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Relacion" id="z_Id_Relacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Relacion->CellAttributes() ?>>
			<span id="el_tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Relacion" name="x_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x_Id_Relacion" id="s_x_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Ocupacion->Visible) { // Id_Ocupacion ?>
	<div id="r_Id_Ocupacion" class="form-group">
		<label class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Ocupacion"><?php echo $tutores->Id_Ocupacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Ocupacion" id="z_Id_Ocupacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Ocupacion->CellAttributes() ?>>
			<span id="el_tutores_Id_Ocupacion">
<?php
$wrkonchange = trim(" " . @$tutores->Id_Ocupacion->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tutores->Id_Ocupacion->EditAttrs["onchange"] = "";
?>
<span id="as_x_Id_Ocupacion" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_Id_Ocupacion" id="sv_x_Id_Ocupacion" value="<?php echo $tutores->Id_Ocupacion->EditValue ?>" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Id_Ocupacion->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tutores->Id_Ocupacion->getPlaceHolder()) ?>"<?php echo $tutores->Id_Ocupacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Ocupacion" data-value-separator="<?php echo $tutores->Id_Ocupacion->DisplayValueSeparatorAttribute() ?>" name="x_Id_Ocupacion" id="x_Id_Ocupacion" value="<?php echo ew_HtmlEncode($tutores->Id_Ocupacion->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_Id_Ocupacion" id="q_x_Id_Ocupacion" value="<?php echo $tutores->Id_Ocupacion->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftutoressearch.CreateAutoSuggest({"id":"x_Id_Ocupacion","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Lugar_Nacimiento->Visible) { // Lugar_Nacimiento ?>
	<div id="r_Lugar_Nacimiento" class="form-group">
		<label for="x_Lugar_Nacimiento" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Lugar_Nacimiento"><?php echo $tutores->Lugar_Nacimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Lugar_Nacimiento" id="z_Lugar_Nacimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Lugar_Nacimiento->CellAttributes() ?>>
			<span id="el_tutores_Lugar_Nacimiento">
<input type="text" data-table="tutores" data-field="x_Lugar_Nacimiento" name="x_Lugar_Nacimiento" id="x_Lugar_Nacimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tutores->Lugar_Nacimiento->getPlaceHolder()) ?>" value="<?php echo $tutores->Lugar_Nacimiento->EditValue ?>"<?php echo $tutores->Lugar_Nacimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Provincia->Visible) { // Id_Provincia ?>
	<div id="r_Id_Provincia" class="form-group">
		<label for="x_Id_Provincia" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Provincia"><?php echo $tutores->Id_Provincia->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Provincia" id="z_Id_Provincia" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Provincia->CellAttributes() ?>>
			<span id="el_tutores_Id_Provincia">
<?php $tutores->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$tutores->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="tutores" data-field="x_Id_Provincia" data-value-separator="<?php echo $tutores->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x_Id_Provincia" name="x_Id_Provincia"<?php echo $tutores->Id_Provincia->EditAttributes() ?>>
<?php echo $tutores->Id_Provincia->SelectOptionListHtml("x_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x_Id_Provincia" id="s_x_Id_Provincia" value="<?php echo $tutores->Id_Provincia->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Departamento"><?php echo $tutores->Id_Departamento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Departamento" id="z_Id_Departamento" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Departamento->CellAttributes() ?>>
			<span id="el_tutores_Id_Departamento">
<?php $tutores->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$tutores->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="tutores" data-field="x_Id_Departamento" data-value-separator="<?php echo $tutores->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $tutores->Id_Departamento->EditAttributes() ?>>
<?php echo $tutores->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $tutores->Id_Departamento->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Id_Localidad"><?php echo $tutores->Id_Localidad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Localidad" id="z_Id_Localidad" value="="></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Id_Localidad->CellAttributes() ?>>
			<span id="el_tutores_Id_Localidad">
<select data-table="tutores" data-field="x_Id_Localidad" data-value-separator="<?php echo $tutores->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $tutores->Id_Localidad->EditAttributes() ?>>
<?php echo $tutores->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $tutores->Id_Localidad->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_Fecha_Actualizacion"><?php echo $tutores->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_tutores_Fecha_Actualizacion">
<input type="text" data-table="tutores" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($tutores->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $tutores->Fecha_Actualizacion->EditValue ?>"<?php echo $tutores->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($tutores->User_Actualiz->Visible) { // User_Actualiz ?>
	<div id="r_User_Actualiz" class="form-group">
		<label class="<?php echo $tutores_search->SearchLabelClass ?>"><span id="elh_tutores_User_Actualiz"><?php echo $tutores->User_Actualiz->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_User_Actualiz" id="z_User_Actualiz" value="LIKE"></p>
		</label>
		<div class="<?php echo $tutores_search->SearchRightColumnClass ?>"><div<?php echo $tutores->User_Actualiz->CellAttributes() ?>>
			<span id="el_tutores_User_Actualiz">
<input type="text" data-table="tutores" data-field="x_User_Actualiz" name="x_User_Actualiz" id="x_User_Actualiz" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($tutores->User_Actualiz->getPlaceHolder()) ?>" value="<?php echo $tutores->User_Actualiz->EditValue ?>"<?php echo $tutores->User_Actualiz->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$tutores_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftutoressearch.Init();
</script>
<?php
$tutores_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tutores_search->Page_Terminate();
?>
