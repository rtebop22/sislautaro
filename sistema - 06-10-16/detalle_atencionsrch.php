<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detalle_atencioninfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detalle_atencion_search = NULL; // Initialize page object first

class cdetalle_atencion_search extends cdetalle_atencion {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'detalle_atencion';

	// Page object name
	var $PageObjName = 'detalle_atencion_search';

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

		// Table object (detalle_atencion)
		if (!isset($GLOBALS["detalle_atencion"]) || get_class($GLOBALS["detalle_atencion"]) == "cdetalle_atencion") {
			$GLOBALS["detalle_atencion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_atencion"];
		}

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_atencion', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("detalle_atencionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Atencion->SetVisibility();
		$this->Id_Detalle_Atencion->SetVisibility();
		$this->Id_Detalle_Atencion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Id_Tipo_Falla->SetVisibility();
		$this->Id_Problema->SetVisibility();
		$this->Descripcion_Problema->SetVisibility();
		$this->Id_Tipo_Sol_Problem->SetVisibility();
		$this->Id_Estado_Atenc->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

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
		global $EW_EXPORT, $detalle_atencion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detalle_atencion);
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
						$sSrchStr = "detalle_atencionlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Atencion); // Id_Atencion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Detalle_Atencion); // Id_Detalle_Atencion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Falla); // Id_Tipo_Falla
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Problema); // Id_Problema
		$this->BuildSearchUrl($sSrchUrl, $this->Descripcion_Problema); // Descripcion_Problema
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Sol_Problem); // Id_Tipo_Sol_Problem
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Atenc); // Id_Estado_Atenc
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Actualizacion); // Fecha_Actualizacion
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
		// Id_Atencion

		$this->Id_Atencion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Atencion"));
		$this->Id_Atencion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Atencion");

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Detalle_Atencion"));
		$this->Id_Detalle_Atencion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Detalle_Atencion");

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Falla"));
		$this->Id_Tipo_Falla->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Falla");

		// Id_Problema
		$this->Id_Problema->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Problema"));
		$this->Id_Problema->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Problema");

		// Descripcion_Problema
		$this->Descripcion_Problema->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Descripcion_Problema"));
		$this->Descripcion_Problema->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Descripcion_Problema");

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Sol_Problem"));
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Sol_Problem");

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Atenc"));
		$this->Id_Estado_Atenc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Atenc");

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Actualizacion"));
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Actualizacion");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Atencion
		// Id_Detalle_Atencion
		// Id_Tipo_Falla
		// Id_Problema
		// Descripcion_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// Id_Detalle_Atencion
		$this->Id_Detalle_Atencion->ViewValue = $this->Id_Detalle_Atencion->CurrentValue;
		$this->Id_Detalle_Atencion->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		if (strval($this->Id_Tipo_Falla->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
		$sWhereWrk = "";
		$this->Id_Tipo_Falla->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Falla->ViewValue = NULL;
		}
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		if (strval($this->Id_Problema->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->Id_Problema->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Problema->ViewValue = $this->Id_Problema->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
			}
		} else {
			$this->Id_Problema->ViewValue = NULL;
		}
		$this->Id_Problema->ViewCustomAttributes = "";

		// Descripcion_Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		if (strval($this->Id_Tipo_Sol_Problem->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Tipo_Sol_Problem->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Sol_Problem->ViewValue = NULL;
		}
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		if (strval($this->Id_Estado_Atenc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
		$sWhereWrk = "";
		$this->Id_Estado_Atenc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Atenc->ViewValue = NULL;
		}
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Id_Atencion
			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";
			$this->Id_Atencion->TooltipValue = "";

			// Id_Detalle_Atencion
			$this->Id_Detalle_Atencion->LinkCustomAttributes = "";
			$this->Id_Detalle_Atencion->HrefValue = "";
			$this->Id_Detalle_Atencion->TooltipValue = "";

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->LinkCustomAttributes = "";
			$this->Id_Tipo_Falla->HrefValue = "";
			$this->Id_Tipo_Falla->TooltipValue = "";

			// Id_Problema
			$this->Id_Problema->LinkCustomAttributes = "";
			$this->Id_Problema->HrefValue = "";
			$this->Id_Problema->TooltipValue = "";

			// Descripcion_Problema
			$this->Descripcion_Problema->LinkCustomAttributes = "";
			$this->Descripcion_Problema->HrefValue = "";
			$this->Descripcion_Problema->TooltipValue = "";

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->HrefValue = "";
			$this->Id_Tipo_Sol_Problem->TooltipValue = "";

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->LinkCustomAttributes = "";
			$this->Id_Estado_Atenc->HrefValue = "";
			$this->Id_Estado_Atenc->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Atencion
			$this->Id_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Atencion->EditCustomAttributes = "";
			$this->Id_Atencion->EditValue = ew_HtmlEncode($this->Id_Atencion->AdvancedSearch->SearchValue);
			$this->Id_Atencion->PlaceHolder = ew_RemoveHtml($this->Id_Atencion->FldCaption());

			// Id_Detalle_Atencion
			$this->Id_Detalle_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Detalle_Atencion->EditCustomAttributes = "";
			$this->Id_Detalle_Atencion->EditValue = ew_HtmlEncode($this->Id_Detalle_Atencion->AdvancedSearch->SearchValue);
			$this->Id_Detalle_Atencion->PlaceHolder = ew_RemoveHtml($this->Id_Detalle_Atencion->FldCaption());

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Falla->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Falla->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Falla`" . ew_SearchString("=", $this->Id_Tipo_Falla->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Falla`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Id_Tipo_Falla->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Falla->EditValue = $arwrk;

			// Id_Problema
			$this->Id_Problema->EditAttrs["class"] = "form-control";
			$this->Id_Problema->EditCustomAttributes = "";
			if (trim(strval($this->Id_Problema->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Problema`" . ew_SearchString("=", $this->Id_Problema->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Problema`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `problema`";
			$sWhereWrk = "";
			$this->Id_Problema->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Problema->EditValue = $arwrk;

			// Descripcion_Problema
			$this->Descripcion_Problema->EditAttrs["class"] = "form-control";
			$this->Descripcion_Problema->EditCustomAttributes = "";
			$this->Descripcion_Problema->EditValue = ew_HtmlEncode($this->Descripcion_Problema->AdvancedSearch->SearchValue);
			$this->Descripcion_Problema->PlaceHolder = ew_RemoveHtml($this->Descripcion_Problema->FldCaption());

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Sol_Problem->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Sol_Problem`" . ew_SearchString("=", $this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Tipo_Sol_Problem->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Sol_Problem->EditValue = $arwrk;

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Atenc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Atenc->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Atenc`" . ew_SearchString("=", $this->Id_Estado_Atenc->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Atenc`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Estado_Atenc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Atenc->EditValue = $arwrk;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode($this->Fecha_Actualizacion->AdvancedSearch->SearchValue);
			$this->Fecha_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualizacion->FldCaption());
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
		$this->Id_Atencion->AdvancedSearch->Load();
		$this->Id_Detalle_Atencion->AdvancedSearch->Load();
		$this->Id_Tipo_Falla->AdvancedSearch->Load();
		$this->Id_Problema->AdvancedSearch->Load();
		$this->Descripcion_Problema->AdvancedSearch->Load();
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->Load();
		$this->Id_Estado_Atenc->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detalle_atencionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Tipo_Falla":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Falla` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_falla`";
			$sWhereWrk = "";
			$this->Id_Tipo_Falla->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Falla` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Falla, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Problema":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Problema` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
			$sWhereWrk = "";
			$this->Id_Problema->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Problema` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Problema, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Sol_Problem":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Sol_Problem` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Tipo_Sol_Problem->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Sol_Problem` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Sol_Problem, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Atenc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Atenc` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_actual_solucion_problema`";
			$sWhereWrk = "";
			$this->Id_Estado_Atenc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Atenc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Atenc, $sWhereWrk); // Call Lookup selecting
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
if (!isset($detalle_atencion_search)) $detalle_atencion_search = new cdetalle_atencion_search();

// Page init
$detalle_atencion_search->Page_Init();

// Page main
$detalle_atencion_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_atencion_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($detalle_atencion_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fdetalle_atencionsearch = new ew_Form("fdetalle_atencionsearch", "search");
<?php } else { ?>
var CurrentForm = fdetalle_atencionsearch = new ew_Form("fdetalle_atencionsearch", "search");
<?php } ?>

// Form_CustomValidate event
fdetalle_atencionsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_atencionsearch.ValidateRequired = true;
<?php } else { ?>
fdetalle_atencionsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_atencionsearch.Lists["x_Id_Tipo_Falla"] = {"LinkField":"x_Id_Tipo_Falla","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_falla"};
fdetalle_atencionsearch.Lists["x_Id_Problema"] = {"LinkField":"x_Id_Problema","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
fdetalle_atencionsearch.Lists["x_Id_Tipo_Sol_Problem"] = {"LinkField":"x_Id_Tipo_Sol_Problem","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_solucion_problema"};
fdetalle_atencionsearch.Lists["x_Id_Estado_Atenc"] = {"LinkField":"x_Id_Estado_Atenc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_actual_solucion_problema"};

// Form object for search
// Validate function for search

fdetalle_atencionsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_atencion->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detalle_atencion_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detalle_atencion_search->ShowPageHeader(); ?>
<?php
$detalle_atencion_search->ShowMessage();
?>
<form name="fdetalle_atencionsearch" id="fdetalle_atencionsearch" class="<?php echo $detalle_atencion_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_atencion_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_atencion_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_atencion">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($detalle_atencion_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($detalle_atencion->Id_Atencion->Visible) { // Id_Atencion ?>
	<div id="r_Id_Atencion" class="form-group">
		<label class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Atencion"><?php echo $detalle_atencion->Id_Atencion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Atencion" id="z_Id_Atencion" value="="></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Atencion->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Atencion">
<input type="text" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x_Id_Atencion" id="x_Id_Atencion" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Id_Atencion->EditValue ?>"<?php echo $detalle_atencion->Id_Atencion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Detalle_Atencion->Visible) { // Id_Detalle_Atencion ?>
	<div id="r_Id_Detalle_Atencion" class="form-group">
		<label class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Detalle_Atencion"><?php echo $detalle_atencion->Id_Detalle_Atencion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Detalle_Atencion" id="z_Id_Detalle_Atencion" value="="></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Detalle_Atencion->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Detalle_Atencion">
<input type="text" data-table="detalle_atencion" data-field="x_Id_Detalle_Atencion" name="x_Id_Detalle_Atencion" id="x_Id_Detalle_Atencion" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Id_Detalle_Atencion->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Id_Detalle_Atencion->EditValue ?>"<?php echo $detalle_atencion->Id_Detalle_Atencion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
	<div id="r_Id_Tipo_Falla" class="form-group">
		<label for="x_Id_Tipo_Falla" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Tipo_Falla"><?php echo $detalle_atencion->Id_Tipo_Falla->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Tipo_Falla" id="z_Id_Tipo_Falla" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Tipo_Falla->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Tipo_Falla">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Falla->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Falla" name="x_Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->SelectOptionListHtml("x_Id_Tipo_Falla") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Falla" id="s_x_Id_Tipo_Falla" value="<?php echo $detalle_atencion->Id_Tipo_Falla->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
	<div id="r_Id_Problema" class="form-group">
		<label for="x_Id_Problema" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Problema"><?php echo $detalle_atencion->Id_Problema->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Problema" id="z_Id_Problema" value="="></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Problema->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Problema">
<select data-table="detalle_atencion" data-field="x_Id_Problema" data-value-separator="<?php echo $detalle_atencion->Id_Problema->DisplayValueSeparatorAttribute() ?>" id="x_Id_Problema" name="x_Id_Problema"<?php echo $detalle_atencion->Id_Problema->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->SelectOptionListHtml("x_Id_Problema") ?>
</select>
<input type="hidden" name="s_x_Id_Problema" id="s_x_Id_Problema" value="<?php echo $detalle_atencion->Id_Problema->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
	<div id="r_Descripcion_Problema" class="form-group">
		<label for="x_Descripcion_Problema" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Descripcion_Problema"><?php echo $detalle_atencion->Descripcion_Problema->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Descripcion_Problema" id="z_Descripcion_Problema" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Descripcion_Problema->CellAttributes() ?>>
			<span id="el_detalle_atencion_Descripcion_Problema">
<input type="text" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x_Descripcion_Problema" id="x_Descripcion_Problema" maxlength="400" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Descripcion_Problema->EditValue ?>"<?php echo $detalle_atencion->Descripcion_Problema->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
	<div id="r_Id_Tipo_Sol_Problem" class="form-group">
		<label for="x_Id_Tipo_Sol_Problem" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Tipo_Sol_Problem"><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Tipo_Sol_Problem" id="z_Id_Tipo_Sol_Problem" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Tipo_Sol_Problem">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Sol_Problem" name="x_Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->SelectOptionListHtml("x_Id_Tipo_Sol_Problem") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Sol_Problem" id="s_x_Id_Tipo_Sol_Problem" value="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
	<div id="r_Id_Estado_Atenc" class="form-group">
		<label for="x_Id_Estado_Atenc" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Id_Estado_Atenc"><?php echo $detalle_atencion->Id_Estado_Atenc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Estado_Atenc" id="z_Id_Estado_Atenc" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Id_Estado_Atenc->CellAttributes() ?>>
			<span id="el_detalle_atencion_Id_Estado_Atenc">
<select data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" data-value-separator="<?php echo $detalle_atencion->Id_Estado_Atenc->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Atenc" name="x_Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->SelectOptionListHtml("x_Id_Estado_Atenc") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Atenc" id="s_x_Id_Estado_Atenc" value="<?php echo $detalle_atencion->Id_Estado_Atenc->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detalle_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $detalle_atencion_search->SearchLabelClass ?>"><span id="elh_detalle_atencion_Fecha_Actualizacion"><?php echo $detalle_atencion->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $detalle_atencion_search->SearchRightColumnClass ?>"><div<?php echo $detalle_atencion->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_detalle_atencion_Fecha_Actualizacion">
<input type="text" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Fecha_Actualizacion->EditValue ?>"<?php echo $detalle_atencion->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$detalle_atencion_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdetalle_atencionsearch.Init();
</script>
<?php
$detalle_atencion_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detalle_atencion_search->Page_Terminate();
?>
