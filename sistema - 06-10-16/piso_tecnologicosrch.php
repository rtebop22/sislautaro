<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "piso_tecnologicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$piso_tecnologico_search = NULL; // Initialize page object first

class cpiso_tecnologico_search extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_search';

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

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'piso_tecnologico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("piso_tecnologicolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Switch->SetVisibility();
		$this->Estado_Switch->SetVisibility();
		$this->Cantidad_Ap->SetVisibility();
		$this->Estado_Ap->SetVisibility();
		$this->Porcent_Estado_Ap->SetVisibility();
		$this->Ups->SetVisibility();
		$this->Estado_Ups->SetVisibility();
		$this->Cableado->SetVisibility();
		$this->Estado_Cableado->SetVisibility();
		$this->Porcent_Estado_Cab->SetVisibility();
		$this->Plano_Escuela->SetVisibility();
		$this->Porcent_Func_Piso->SetVisibility();

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
		global $EW_EXPORT, $piso_tecnologico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($piso_tecnologico);
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
						$sSrchStr = "piso_tecnologicolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Switch); // Switch
		$this->BuildSearchUrl($sSrchUrl, $this->Estado_Switch); // Estado_Switch
		$this->BuildSearchUrl($sSrchUrl, $this->Cantidad_Ap); // Cantidad_Ap
		$this->BuildSearchUrl($sSrchUrl, $this->Estado_Ap); // Estado_Ap
		$this->BuildSearchUrl($sSrchUrl, $this->Porcent_Estado_Ap); // Porcent_Estado_Ap
		$this->BuildSearchUrl($sSrchUrl, $this->Ups); // Ups
		$this->BuildSearchUrl($sSrchUrl, $this->Estado_Ups); // Estado_Ups
		$this->BuildSearchUrl($sSrchUrl, $this->Cableado); // Cableado
		$this->BuildSearchUrl($sSrchUrl, $this->Estado_Cableado); // Estado_Cableado
		$this->BuildSearchUrl($sSrchUrl, $this->Porcent_Estado_Cab); // Porcent_Estado_Cab
		$this->BuildSearchUrl($sSrchUrl, $this->Plano_Escuela); // Plano_Escuela
		$this->BuildSearchUrl($sSrchUrl, $this->Porcent_Func_Piso); // Porcent_Func_Piso
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
		// Switch

		$this->Switch->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Switch"));
		$this->Switch->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Switch");

		// Estado_Switch
		$this->Estado_Switch->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado_Switch"));
		$this->Estado_Switch->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado_Switch");

		// Cantidad_Ap
		$this->Cantidad_Ap->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cantidad_Ap"));
		$this->Cantidad_Ap->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cantidad_Ap");

		// Estado_Ap
		$this->Estado_Ap->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado_Ap"));
		$this->Estado_Ap->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado_Ap");

		// Porcent_Estado_Ap
		$this->Porcent_Estado_Ap->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Porcent_Estado_Ap"));
		$this->Porcent_Estado_Ap->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Porcent_Estado_Ap");

		// Ups
		$this->Ups->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Ups"));
		$this->Ups->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Ups");

		// Estado_Ups
		$this->Estado_Ups->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado_Ups"));
		$this->Estado_Ups->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado_Ups");

		// Cableado
		$this->Cableado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cableado"));
		$this->Cableado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cableado");

		// Estado_Cableado
		$this->Estado_Cableado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado_Cableado"));
		$this->Estado_Cableado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado_Cableado");

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Porcent_Estado_Cab"));
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Porcent_Estado_Cab");

		// Plano_Escuela
		$this->Plano_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Plano_Escuela"));
		$this->Plano_Escuela->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Plano_Escuela");

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Porcent_Func_Piso"));
		$this->Porcent_Func_Piso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Porcent_Func_Piso");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Piso
		// Switch
		// Estado_Switch
		// Cantidad_Ap
		// Estado_Ap
		// Porcent_Estado_Ap
		// Ups
		// Estado_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Plano_Escuela
		// Porcent_Func_Piso
		// Ultima_Actualizacion
		// Usuario
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Estado_Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->CurrentValue;
			}
		} else {
			$this->Estado_Switch->ViewValue = NULL;
		}
		$this->Estado_Switch->ViewCustomAttributes = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->ViewValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->ViewCustomAttributes = "";

		// Estado_Ap
		if (strval($this->Estado_Ap->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ap->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ap->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ap, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ap->ViewValue = $this->Estado_Ap->CurrentValue;
			}
		} else {
			$this->Estado_Ap->ViewValue = NULL;
		}
		$this->Estado_Ap->ViewCustomAttributes = "";

		// Porcent_Estado_Ap
		$this->Porcent_Estado_Ap->ViewValue = $this->Porcent_Estado_Ap->CurrentValue;
		$this->Porcent_Estado_Ap->ViewCustomAttributes = "";

		// Ups
		if (strval($this->Ups->CurrentValue) <> "") {
			$this->Ups->ViewValue = $this->Ups->OptionCaption($this->Ups->CurrentValue);
		} else {
			$this->Ups->ViewValue = NULL;
		}
		$this->Ups->ViewCustomAttributes = "";

		// Estado_Ups
		if (strval($this->Estado_Ups->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ups->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->CurrentValue;
			}
		} else {
			$this->Estado_Ups->ViewValue = NULL;
		}
		$this->Estado_Ups->ViewCustomAttributes = "";

		// Cableado
		if (strval($this->Cableado->CurrentValue) <> "") {
			$this->Cableado->ViewValue = $this->Cableado->OptionCaption($this->Cableado->CurrentValue);
		} else {
			$this->Cableado->ViewValue = NULL;
		}
		$this->Cableado->ViewCustomAttributes = "";

		// Estado_Cableado
		if (strval($this->Estado_Cableado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Cableado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->CurrentValue;
			}
		} else {
			$this->Estado_Cableado->ViewValue = NULL;
		}
		$this->Estado_Cableado->ViewCustomAttributes = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->ViewValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->ViewCustomAttributes = "";

		// Plano_Escuela
		if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
			$this->Plano_Escuela->ViewValue = $this->Plano_Escuela->Upload->DbValue;
		} else {
			$this->Plano_Escuela->ViewValue = "";
		}
		$this->Plano_Escuela->ViewCustomAttributes = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Ultima_Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 7);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Switch
			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";
			$this->Switch->TooltipValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";
			$this->Estado_Switch->TooltipValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";
			$this->Cantidad_Ap->TooltipValue = "";

			// Estado_Ap
			$this->Estado_Ap->LinkCustomAttributes = "";
			$this->Estado_Ap->HrefValue = "";
			$this->Estado_Ap->TooltipValue = "";

			// Porcent_Estado_Ap
			$this->Porcent_Estado_Ap->LinkCustomAttributes = "";
			$this->Porcent_Estado_Ap->HrefValue = "";
			$this->Porcent_Estado_Ap->TooltipValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";
			$this->Ups->TooltipValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";
			$this->Estado_Ups->TooltipValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";
			$this->Cableado->TooltipValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";
			$this->Estado_Cableado->TooltipValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";
			$this->Porcent_Estado_Cab->TooltipValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;
			$this->Plano_Escuela->TooltipValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";
			$this->Porcent_Func_Piso->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Switch
			$this->Switch->EditCustomAttributes = "";
			$this->Switch->EditValue = $this->Switch->Options(FALSE);

			// Estado_Switch
			$this->Estado_Switch->EditAttrs["class"] = "form-control";
			$this->Estado_Switch->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Switch->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Switch->EditValue = $arwrk;

			// Cantidad_Ap
			$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap->EditCustomAttributes = "";
			$this->Cantidad_Ap->EditValue = ew_HtmlEncode($this->Cantidad_Ap->AdvancedSearch->SearchValue);
			$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

			// Estado_Ap
			$this->Estado_Ap->EditAttrs["class"] = "form-control";
			$this->Estado_Ap->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ap->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ap->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ap->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ap, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ap->EditValue = $arwrk;

			// Porcent_Estado_Ap
			$this->Porcent_Estado_Ap->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Ap->EditCustomAttributes = "";
			$this->Porcent_Estado_Ap->EditValue = ew_HtmlEncode($this->Porcent_Estado_Ap->AdvancedSearch->SearchValue);
			$this->Porcent_Estado_Ap->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Ap->FldCaption());

			// Ups
			$this->Ups->EditCustomAttributes = "";
			$this->Ups->EditValue = $this->Ups->Options(FALSE);

			// Estado_Ups
			$this->Estado_Ups->EditAttrs["class"] = "form-control";
			$this->Estado_Ups->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ups->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ups->EditValue = $arwrk;

			// Cableado
			$this->Cableado->EditCustomAttributes = "";
			$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

			// Estado_Cableado
			$this->Estado_Cableado->EditAttrs["class"] = "form-control";
			$this->Estado_Cableado->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Cableado->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Cableado->EditValue = $arwrk;

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Cab->EditCustomAttributes = "";
			$this->Porcent_Estado_Cab->EditValue = ew_HtmlEncode($this->Porcent_Estado_Cab->AdvancedSearch->SearchValue);
			$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

			// Plano_Escuela
			$this->Plano_Escuela->EditAttrs["class"] = "form-control";
			$this->Plano_Escuela->EditCustomAttributes = "";
			$this->Plano_Escuela->EditValue = ew_HtmlEncode($this->Plano_Escuela->AdvancedSearch->SearchValue);
			$this->Plano_Escuela->PlaceHolder = ew_RemoveHtml($this->Plano_Escuela->FldCaption());

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
			$this->Porcent_Func_Piso->EditCustomAttributes = "";
			$this->Porcent_Func_Piso->EditValue = ew_HtmlEncode($this->Porcent_Func_Piso->AdvancedSearch->SearchValue);
			$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());
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
		if (!ew_CheckInteger($this->Cantidad_Ap->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cantidad_Ap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Porcent_Estado_Ap->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Porcent_Estado_Ap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Porcent_Estado_Cab->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Porcent_Estado_Cab->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Porcent_Func_Piso->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Porcent_Func_Piso->FldErrMsg());
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
		$this->Switch->AdvancedSearch->Load();
		$this->Estado_Switch->AdvancedSearch->Load();
		$this->Cantidad_Ap->AdvancedSearch->Load();
		$this->Estado_Ap->AdvancedSearch->Load();
		$this->Porcent_Estado_Ap->AdvancedSearch->Load();
		$this->Ups->AdvancedSearch->Load();
		$this->Estado_Ups->AdvancedSearch->Load();
		$this->Cableado->AdvancedSearch->Load();
		$this->Estado_Cableado->AdvancedSearch->Load();
		$this->Porcent_Estado_Cab->AdvancedSearch->Load();
		$this->Plano_Escuela->AdvancedSearch->Load();
		$this->Porcent_Func_Piso->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("piso_tecnologicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Estado_Switch":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Ap":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ap->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Ap, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Ups":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Cableado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
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
if (!isset($piso_tecnologico_search)) $piso_tecnologico_search = new cpiso_tecnologico_search();

// Page init
$piso_tecnologico_search->Page_Init();

// Page main
$piso_tecnologico_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($piso_tecnologico_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fpiso_tecnologicosearch = new ew_Form("fpiso_tecnologicosearch", "search");
<?php } else { ?>
var CurrentForm = fpiso_tecnologicosearch = new ew_Form("fpiso_tecnologicosearch", "search");
<?php } ?>

// Form_CustomValidate event
fpiso_tecnologicosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicosearch.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicosearch.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicosearch.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicosearch.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicosearch.Lists["x_Estado_Ap"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicosearch.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicosearch.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicosearch.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicosearch.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicosearch.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicosearch.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
// Validate function for search

fpiso_tecnologicosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Cantidad_Ap");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Porcent_Estado_Ap");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Ap->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Porcent_Estado_Cab");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Cab->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Porcent_Func_Piso");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Func_Piso->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$piso_tecnologico_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $piso_tecnologico_search->ShowPageHeader(); ?>
<?php
$piso_tecnologico_search->ShowMessage();
?>
<form name="fpiso_tecnologicosearch" id="fpiso_tecnologicosearch" class="<?php echo $piso_tecnologico_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($piso_tecnologico_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<div id="r_Switch" class="form-group">
		<label class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Switch"><?php echo $piso_tecnologico->Switch->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Switch" id="z_Switch" value="LIKE"></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Switch">
<div id="tp_x_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x_Switch" id="x_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x_Switch") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<div id="r_Estado_Switch" class="form-group">
		<label for="x_Estado_Switch" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Estado_Switch"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Estado_Switch" id="z_Estado_Switch" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Switch" name="x_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x_Estado_Switch" id="s_x_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<div id="r_Cantidad_Ap" class="form-group">
		<label for="x_Cantidad_Ap" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Cantidad_Ap"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cantidad_Ap" id="z_Cantidad_Ap" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x_Cantidad_Ap" id="x_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ap->Visible) { // Estado_Ap ?>
	<div id="r_Estado_Ap" class="form-group">
		<label for="x_Estado_Ap" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Estado_Ap"><?php echo $piso_tecnologico->Estado_Ap->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Estado_Ap" id="z_Estado_Ap" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Estado_Ap->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Estado_Ap">
<select data-table="piso_tecnologico" data-field="x_Estado_Ap" data-value-separator="<?php echo $piso_tecnologico->Estado_Ap->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Ap" name="x_Estado_Ap"<?php echo $piso_tecnologico->Estado_Ap->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ap->SelectOptionListHtml("x_Estado_Ap") ?>
</select>
<input type="hidden" name="s_x_Estado_Ap" id="s_x_Estado_Ap" value="<?php echo $piso_tecnologico->Estado_Ap->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Ap->Visible) { // Porcent_Estado_Ap ?>
	<div id="r_Porcent_Estado_Ap" class="form-group">
		<label for="x_Porcent_Estado_Ap" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Porcent_Estado_Ap"><?php echo $piso_tecnologico->Porcent_Estado_Ap->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Porcent_Estado_Ap" id="z_Porcent_Estado_Ap" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Porcent_Estado_Ap->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Porcent_Estado_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Ap" name="x_Porcent_Estado_Ap" id="x_Porcent_Estado_Ap" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Ap->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Ap->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<div id="r_Ups" class="form-group">
		<label class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Ups"><?php echo $piso_tecnologico->Ups->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Ups" id="z_Ups" value="LIKE"></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Ups">
<div id="tp_x_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x_Ups" id="x_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x_Ups") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<div id="r_Estado_Ups" class="form-group">
		<label for="x_Estado_Ups" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Estado_Ups"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Estado_Ups" id="z_Estado_Ups" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Ups" name="x_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x_Estado_Ups" id="s_x_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<div id="r_Cableado" class="form-group">
		<label class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Cableado"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cableado" id="z_Cableado" value="LIKE"></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Cableado">
<div id="tp_x_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x_Cableado" id="x_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x_Cableado") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<div id="r_Estado_Cableado" class="form-group">
		<label for="x_Estado_Cableado" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Estado_Cableado"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Estado_Cableado" id="z_Estado_Cableado" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x_Estado_Cableado" name="x_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x_Estado_Cableado" id="s_x_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<div id="r_Porcent_Estado_Cab" class="form-group">
		<label for="x_Porcent_Estado_Cab" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Porcent_Estado_Cab"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Porcent_Estado_Cab" id="z_Porcent_Estado_Cab" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x_Porcent_Estado_Cab" id="x_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<div id="r_Plano_Escuela" class="form-group">
		<label class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Plano_Escuela"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Plano_Escuela" id="z_Plano_Escuela" value="LIKE"></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Plano_Escuela">
<input type="text" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x_Plano_Escuela" id="x_Plano_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Plano_Escuela->EditValue ?>"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<div id="r_Porcent_Func_Piso" class="form-group">
		<label for="x_Porcent_Func_Piso" class="<?php echo $piso_tecnologico_search->SearchLabelClass ?>"><span id="elh_piso_tecnologico_Porcent_Func_Piso"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Porcent_Func_Piso" id="z_Porcent_Func_Piso" value="="></p>
		</label>
		<div class="<?php echo $piso_tecnologico_search->SearchRightColumnClass ?>"><div<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
			<span id="el_piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x_Porcent_Func_Piso" id="x_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$piso_tecnologico_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpiso_tecnologicosearch.Init();
</script>
<?php
$piso_tecnologico_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_search->Page_Terminate();
?>
