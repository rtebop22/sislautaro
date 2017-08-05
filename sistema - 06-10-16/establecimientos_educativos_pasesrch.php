<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "establecimientos_educativos_paseinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$establecimientos_educativos_pase_search = NULL; // Initialize page object first

class cestablecimientos_educativos_pase_search extends cestablecimientos_educativos_pase {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'establecimientos_educativos_pase';

	// Page object name
	var $PageObjName = 'establecimientos_educativos_pase_search';

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

		// Table object (establecimientos_educativos_pase)
		if (!isset($GLOBALS["establecimientos_educativos_pase"]) || get_class($GLOBALS["establecimientos_educativos_pase"]) == "cestablecimientos_educativos_pase") {
			$GLOBALS["establecimientos_educativos_pase"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["establecimientos_educativos_pase"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'establecimientos_educativos_pase', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("establecimientos_educativos_paselist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Cue_Establecimiento->SetVisibility();
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Nombre_Director->SetVisibility();
		$this->Cuil_Director->SetVisibility();
		$this->Nombre_Rte->SetVisibility();
		$this->Contacto_Rte->SetVisibility();
		$this->Nro_Serie_Server_Escolar->SetVisibility();
		$this->Contacto_Establecimiento->SetVisibility();
		$this->Id_Provincia->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
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
		global $EW_EXPORT, $establecimientos_educativos_pase;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($establecimientos_educativos_pase);
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
						$sSrchStr = "establecimientos_educativos_paselist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Cue_Establecimiento); // Cue_Establecimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Establecimiento); // Nombre_Establecimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Director); // Nombre_Director
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil_Director); // Cuil_Director
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Rte); // Nombre_Rte
		$this->BuildSearchUrl($sSrchUrl, $this->Contacto_Rte); // Contacto_Rte
		$this->BuildSearchUrl($sSrchUrl, $this->Nro_Serie_Server_Escolar); // Nro_Serie_Server_Escolar
		$this->BuildSearchUrl($sSrchUrl, $this->Contacto_Establecimiento); // Contacto_Establecimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Provincia); // Id_Provincia
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Departamento); // Id_Departamento
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Localidad); // Id_Localidad
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
		// Cue_Establecimiento

		$this->Cue_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue_Establecimiento"));
		$this->Cue_Establecimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue_Establecimiento");

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Establecimiento"));
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Establecimiento");

		// Nombre_Director
		$this->Nombre_Director->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Director"));
		$this->Nombre_Director->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Director");

		// Cuil_Director
		$this->Cuil_Director->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil_Director"));
		$this->Cuil_Director->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil_Director");

		// Nombre_Rte
		$this->Nombre_Rte->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Rte"));
		$this->Nombre_Rte->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Rte");

		// Contacto_Rte
		$this->Contacto_Rte->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Contacto_Rte"));
		$this->Contacto_Rte->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Contacto_Rte");

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nro_Serie_Server_Escolar"));
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nro_Serie_Server_Escolar");

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Contacto_Establecimiento"));
		$this->Contacto_Establecimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Contacto_Establecimiento");

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
		// Cue_Establecimiento
		// Nombre_Establecimiento
		// Nombre_Director
		// Cuil_Director
		// Nombre_Rte
		// Contacto_Rte
		// Nro_Serie_Server_Escolar
		// Contacto_Establecimiento
		// Id_Provincia
		// Id_Departamento
		// Id_Localidad
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue_Establecimiento
		$this->Cue_Establecimiento->ViewValue = $this->Cue_Establecimiento->CurrentValue;
		$this->Cue_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Nombre_Director
		$this->Nombre_Director->ViewValue = $this->Nombre_Director->CurrentValue;
		$this->Nombre_Director->ViewCustomAttributes = "";

		// Cuil_Director
		$this->Cuil_Director->ViewValue = $this->Cuil_Director->CurrentValue;
		$this->Cuil_Director->ViewCustomAttributes = "";

		// Nombre_Rte
		$this->Nombre_Rte->ViewValue = $this->Nombre_Rte->CurrentValue;
		$this->Nombre_Rte->ViewCustomAttributes = "";

		// Contacto_Rte
		$this->Contacto_Rte->ViewValue = $this->Contacto_Rte->CurrentValue;
		$this->Contacto_Rte->ViewCustomAttributes = "";

		// Nro_Serie_Server_Escolar
		$this->Nro_Serie_Server_Escolar->ViewValue = $this->Nro_Serie_Server_Escolar->CurrentValue;
		$this->Nro_Serie_Server_Escolar->ViewCustomAttributes = "";

		// Contacto_Establecimiento
		$this->Contacto_Establecimiento->ViewValue = $this->Contacto_Establecimiento->CurrentValue;
		$this->Contacto_Establecimiento->ViewCustomAttributes = "";

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
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue_Establecimiento
			$this->Cue_Establecimiento->LinkCustomAttributes = "";
			$this->Cue_Establecimiento->HrefValue = "";
			$this->Cue_Establecimiento->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

			// Nombre_Director
			$this->Nombre_Director->LinkCustomAttributes = "";
			$this->Nombre_Director->HrefValue = "";
			$this->Nombre_Director->TooltipValue = "";

			// Cuil_Director
			$this->Cuil_Director->LinkCustomAttributes = "";
			$this->Cuil_Director->HrefValue = "";
			$this->Cuil_Director->TooltipValue = "";

			// Nombre_Rte
			$this->Nombre_Rte->LinkCustomAttributes = "";
			$this->Nombre_Rte->HrefValue = "";
			$this->Nombre_Rte->TooltipValue = "";

			// Contacto_Rte
			$this->Contacto_Rte->LinkCustomAttributes = "";
			$this->Contacto_Rte->HrefValue = "";
			$this->Contacto_Rte->TooltipValue = "";

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->LinkCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->HrefValue = "";
			$this->Nro_Serie_Server_Escolar->TooltipValue = "";

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->LinkCustomAttributes = "";
			$this->Contacto_Establecimiento->HrefValue = "";
			$this->Contacto_Establecimiento->TooltipValue = "";

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

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Cue_Establecimiento
			$this->Cue_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento->EditCustomAttributes = "";
			$this->Cue_Establecimiento->EditValue = ew_HtmlEncode($this->Cue_Establecimiento->AdvancedSearch->SearchValue);
			$this->Cue_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento->FldCaption());

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->AdvancedSearch->SearchValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Nombre_Director
			$this->Nombre_Director->EditAttrs["class"] = "form-control";
			$this->Nombre_Director->EditCustomAttributes = "";
			$this->Nombre_Director->EditValue = ew_HtmlEncode($this->Nombre_Director->AdvancedSearch->SearchValue);
			$this->Nombre_Director->PlaceHolder = ew_RemoveHtml($this->Nombre_Director->FldCaption());

			// Cuil_Director
			$this->Cuil_Director->EditAttrs["class"] = "form-control";
			$this->Cuil_Director->EditCustomAttributes = "";
			$this->Cuil_Director->EditValue = ew_HtmlEncode($this->Cuil_Director->AdvancedSearch->SearchValue);
			$this->Cuil_Director->PlaceHolder = ew_RemoveHtml($this->Cuil_Director->FldCaption());

			// Nombre_Rte
			$this->Nombre_Rte->EditAttrs["class"] = "form-control";
			$this->Nombre_Rte->EditCustomAttributes = "";
			$this->Nombre_Rte->EditValue = ew_HtmlEncode($this->Nombre_Rte->AdvancedSearch->SearchValue);
			$this->Nombre_Rte->PlaceHolder = ew_RemoveHtml($this->Nombre_Rte->FldCaption());

			// Contacto_Rte
			$this->Contacto_Rte->EditAttrs["class"] = "form-control";
			$this->Contacto_Rte->EditCustomAttributes = "";
			$this->Contacto_Rte->EditValue = ew_HtmlEncode($this->Contacto_Rte->AdvancedSearch->SearchValue);
			$this->Contacto_Rte->PlaceHolder = ew_RemoveHtml($this->Contacto_Rte->FldCaption());

			// Nro_Serie_Server_Escolar
			$this->Nro_Serie_Server_Escolar->EditAttrs["class"] = "form-control";
			$this->Nro_Serie_Server_Escolar->EditCustomAttributes = "";
			$this->Nro_Serie_Server_Escolar->EditValue = ew_HtmlEncode($this->Nro_Serie_Server_Escolar->AdvancedSearch->SearchValue);
			$this->Nro_Serie_Server_Escolar->PlaceHolder = ew_RemoveHtml($this->Nro_Serie_Server_Escolar->FldCaption());

			// Contacto_Establecimiento
			$this->Contacto_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Contacto_Establecimiento->EditCustomAttributes = "";
			$this->Contacto_Establecimiento->EditValue = ew_HtmlEncode($this->Contacto_Establecimiento->AdvancedSearch->SearchValue);
			$this->Contacto_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Contacto_Establecimiento->FldCaption());

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
		$this->Cue_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Nombre_Director->AdvancedSearch->Load();
		$this->Cuil_Director->AdvancedSearch->Load();
		$this->Nombre_Rte->AdvancedSearch->Load();
		$this->Contacto_Rte->AdvancedSearch->Load();
		$this->Nro_Serie_Server_Escolar->AdvancedSearch->Load();
		$this->Contacto_Establecimiento->AdvancedSearch->Load();
		$this->Id_Provincia->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("establecimientos_educativos_paselist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
if (!isset($establecimientos_educativos_pase_search)) $establecimientos_educativos_pase_search = new cestablecimientos_educativos_pase_search();

// Page init
$establecimientos_educativos_pase_search->Page_Init();

// Page main
$establecimientos_educativos_pase_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$establecimientos_educativos_pase_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($establecimientos_educativos_pase_search->IsModal) { ?>
var CurrentAdvancedSearchForm = festablecimientos_educativos_pasesearch = new ew_Form("festablecimientos_educativos_pasesearch", "search");
<?php } else { ?>
var CurrentForm = festablecimientos_educativos_pasesearch = new ew_Form("festablecimientos_educativos_pasesearch", "search");
<?php } ?>

// Form_CustomValidate event
festablecimientos_educativos_pasesearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festablecimientos_educativos_pasesearch.ValidateRequired = true;
<?php } else { ?>
festablecimientos_educativos_pasesearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festablecimientos_educativos_pasesearch.Lists["x_Id_Provincia"] = {"LinkField":"x_Id_Provincia","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Departamento"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provincias"};
festablecimientos_educativos_pasesearch.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Provincia"],"ChildFields":["x_Id_Localidad"],"FilterFields":["x_Id_Provincia"],"Options":[],"Template":"","LinkTable":"departamento"};
festablecimientos_educativos_pasesearch.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};

// Form object for search
// Validate function for search

festablecimientos_educativos_pasesearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$establecimientos_educativos_pase_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $establecimientos_educativos_pase_search->ShowPageHeader(); ?>
<?php
$establecimientos_educativos_pase_search->ShowMessage();
?>
<form name="festablecimientos_educativos_pasesearch" id="festablecimientos_educativos_pasesearch" class="<?php echo $establecimientos_educativos_pase_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($establecimientos_educativos_pase_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $establecimientos_educativos_pase_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="establecimientos_educativos_pase">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($establecimientos_educativos_pase_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($establecimientos_educativos_pase->Cue_Establecimiento->Visible) { // Cue_Establecimiento ?>
	<div id="r_Cue_Establecimiento" class="form-group">
		<label for="x_Cue_Establecimiento" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Cue_Establecimiento"><?php echo $establecimientos_educativos_pase->Cue_Establecimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue_Establecimiento" id="z_Cue_Establecimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Cue_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cue_Establecimiento" name="x_Cue_Establecimiento" id="x_Cue_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cue_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cue_Establecimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<div id="r_Nombre_Establecimiento" class="form-group">
		<label for="x_Nombre_Establecimiento" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Nombre_Establecimiento"><?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Establecimiento" id="z_Nombre_Establecimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Nombre_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Establecimiento" name="x_Nombre_Establecimiento" id="x_Nombre_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Establecimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nombre_Director->Visible) { // Nombre_Director ?>
	<div id="r_Nombre_Director" class="form-group">
		<label for="x_Nombre_Director" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Nombre_Director"><?php echo $establecimientos_educativos_pase->Nombre_Director->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Director" id="z_Nombre_Director" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Nombre_Director->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Nombre_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Director" name="x_Nombre_Director" id="x_Nombre_Director" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Director->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Cuil_Director->Visible) { // Cuil_Director ?>
	<div id="r_Cuil_Director" class="form-group">
		<label for="x_Cuil_Director" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Cuil_Director"><?php echo $establecimientos_educativos_pase->Cuil_Director->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil_Director" id="z_Cuil_Director" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Cuil_Director->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Cuil_Director">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Cuil_Director" name="x_Cuil_Director" id="x_Cuil_Director" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Cuil_Director->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Cuil_Director->EditValue ?>"<?php echo $establecimientos_educativos_pase->Cuil_Director->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nombre_Rte->Visible) { // Nombre_Rte ?>
	<div id="r_Nombre_Rte" class="form-group">
		<label for="x_Nombre_Rte" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Nombre_Rte"><?php echo $establecimientos_educativos_pase->Nombre_Rte->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Rte" id="z_Nombre_Rte" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Nombre_Rte->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Nombre_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nombre_Rte" name="x_Nombre_Rte" id="x_Nombre_Rte" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nombre_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nombre_Rte->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Contacto_Rte->Visible) { // Contacto_Rte ?>
	<div id="r_Contacto_Rte" class="form-group">
		<label for="x_Contacto_Rte" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Contacto_Rte"><?php echo $establecimientos_educativos_pase->Contacto_Rte->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Contacto_Rte" id="z_Contacto_Rte" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Contacto_Rte->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Contacto_Rte">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Rte" name="x_Contacto_Rte" id="x_Contacto_Rte" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Rte->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Rte->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->Visible) { // Nro_Serie_Server_Escolar ?>
	<div id="r_Nro_Serie_Server_Escolar" class="form-group">
		<label for="x_Nro_Serie_Server_Escolar" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Nro_Serie_Server_Escolar"><?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nro_Serie_Server_Escolar" id="z_Nro_Serie_Server_Escolar" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Nro_Serie_Server_Escolar">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Nro_Serie_Server_Escolar" name="x_Nro_Serie_Server_Escolar" id="x_Nro_Serie_Server_Escolar" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Nro_Serie_Server_Escolar->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditValue ?>"<?php echo $establecimientos_educativos_pase->Nro_Serie_Server_Escolar->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Contacto_Establecimiento->Visible) { // Contacto_Establecimiento ?>
	<div id="r_Contacto_Establecimiento" class="form-group">
		<label for="x_Contacto_Establecimiento" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Contacto_Establecimiento"><?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Contacto_Establecimiento" id="z_Contacto_Establecimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Contacto_Establecimiento">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Contacto_Establecimiento" name="x_Contacto_Establecimiento" id="x_Contacto_Establecimiento" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Contacto_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditValue ?>"<?php echo $establecimientos_educativos_pase->Contacto_Establecimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Provincia->Visible) { // Id_Provincia ?>
	<div id="r_Id_Provincia" class="form-group">
		<label for="x_Id_Provincia" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Id_Provincia"><?php echo $establecimientos_educativos_pase->Id_Provincia->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Provincia" id="z_Id_Provincia" value="="></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Id_Provincia->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Id_Provincia">
<?php $establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Provincia->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Provincia" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Provincia->DisplayValueSeparatorAttribute() ?>" id="x_Id_Provincia" name="x_Id_Provincia"<?php echo $establecimientos_educativos_pase->Id_Provincia->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Provincia->SelectOptionListHtml("x_Id_Provincia") ?>
</select>
<input type="hidden" name="s_x_Id_Provincia" id="s_x_Id_Provincia" value="<?php echo $establecimientos_educativos_pase->Id_Provincia->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Id_Departamento"><?php echo $establecimientos_educativos_pase->Id_Departamento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Departamento" id="z_Id_Departamento" value="="></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Id_Departamento->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Id_Departamento">
<?php $establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$establecimientos_educativos_pase->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Departamento" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $establecimientos_educativos_pase->Id_Departamento->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $establecimientos_educativos_pase->Id_Departamento->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Id_Localidad"><?php echo $establecimientos_educativos_pase->Id_Localidad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Localidad" id="z_Id_Localidad" value="="></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Id_Localidad->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Id_Localidad">
<select data-table="establecimientos_educativos_pase" data-field="x_Id_Localidad" data-value-separator="<?php echo $establecimientos_educativos_pase->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $establecimientos_educativos_pase->Id_Localidad->EditAttributes() ?>>
<?php echo $establecimientos_educativos_pase->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $establecimientos_educativos_pase->Id_Localidad->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Fecha_Actualizacion"><?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Fecha_Actualizacion">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->EditValue ?>"<?php echo $establecimientos_educativos_pase->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($establecimientos_educativos_pase->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $establecimientos_educativos_pase_search->SearchLabelClass ?>"><span id="elh_establecimientos_educativos_pase_Usuario"><?php echo $establecimientos_educativos_pase->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $establecimientos_educativos_pase_search->SearchRightColumnClass ?>"><div<?php echo $establecimientos_educativos_pase->Usuario->CellAttributes() ?>>
			<span id="el_establecimientos_educativos_pase_Usuario">
<input type="text" data-table="establecimientos_educativos_pase" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($establecimientos_educativos_pase->Usuario->getPlaceHolder()) ?>" value="<?php echo $establecimientos_educativos_pase->Usuario->EditValue ?>"<?php echo $establecimientos_educativos_pase->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$establecimientos_educativos_pase_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festablecimientos_educativos_pasesearch.Init();
</script>
<?php
$establecimientos_educativos_pase_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$establecimientos_educativos_pase_search->Page_Terminate();
?>
