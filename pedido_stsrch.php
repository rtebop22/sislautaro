<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pedido_stinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pedido_st_search = NULL; // Initialize page object first

class cpedido_st_search extends cpedido_st {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pedido_st';

	// Page object name
	var $PageObjName = 'pedido_st_search';

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (pedido_st)
		if (!isset($GLOBALS["pedido_st"]) || get_class($GLOBALS["pedido_st"]) == "cpedido_st") {
			$GLOBALS["pedido_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pedido_st"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pedido_st', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pedido_stlist.php"));
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
		$this->CUE->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Id_Zona->SetVisibility();
		$this->DEPARTAMENTO->SetVisibility();
		$this->LOCALIDAD->SetVisibility();
		$this->SERIE_NETBOOK->SetVisibility();
		$this->NB0_TIKET->SetVisibility();
		$this->PROBLEMA->SetVisibility();
		$this->Id_Tipo_Retiro->SetVisibility();

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
		global $EW_EXPORT, $pedido_st;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pedido_st);
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
						$sSrchStr = "pedido_stlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->CUE); // CUE
		$this->BuildSearchUrl($sSrchUrl, $this->Sigla); // Sigla
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Zona); // Id_Zona
		$this->BuildSearchUrl($sSrchUrl, $this->DEPARTAMENTO); // DEPARTAMENTO
		$this->BuildSearchUrl($sSrchUrl, $this->LOCALIDAD); // LOCALIDAD
		$this->BuildSearchUrl($sSrchUrl, $this->SERIE_NETBOOK); // SERIE NETBOOK
		$this->BuildSearchUrl($sSrchUrl, $this->NB0_TIKET); // N° TIKET
		$this->BuildSearchUrl($sSrchUrl, $this->PROBLEMA); // PROBLEMA
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Retiro); // Id_Tipo_Retiro
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
		// CUE

		$this->CUE->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_CUE"));
		$this->CUE->AdvancedSearch->SearchOperator = $objForm->GetValue("z_CUE");

		// Sigla
		$this->Sigla->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sigla"));
		$this->Sigla->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sigla");

		// Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Zona"));
		$this->Id_Zona->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Zona");

		// DEPARTAMENTO
		$this->DEPARTAMENTO->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_DEPARTAMENTO"));
		$this->DEPARTAMENTO->AdvancedSearch->SearchOperator = $objForm->GetValue("z_DEPARTAMENTO");

		// LOCALIDAD
		$this->LOCALIDAD->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_LOCALIDAD"));
		$this->LOCALIDAD->AdvancedSearch->SearchOperator = $objForm->GetValue("z_LOCALIDAD");

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SERIE_NETBOOK"));
		$this->SERIE_NETBOOK->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SERIE_NETBOOK");

		// N° TIKET
		$this->NB0_TIKET->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NB0_TIKET"));
		$this->NB0_TIKET->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NB0_TIKET");

		// PROBLEMA
		$this->PROBLEMA->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_PROBLEMA"));
		$this->PROBLEMA->AdvancedSearch->SearchOperator = $objForm->GetValue("z_PROBLEMA");

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Retiro"));
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Retiro");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// CUE
		// Sigla
		// Id_Zona
		// DEPARTAMENTO
		// LOCALIDAD
		// SERIE NETBOOK
		// N° TIKET
		// PROBLEMA
		// Id_Tipo_Retiro

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CUE
		$this->CUE->ViewValue = $this->CUE->CurrentValue;
		$this->CUE->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Id_Zona
		if (strval($this->Id_Zona->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
		$sWhereWrk = "";
		$this->Id_Zona->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Zona->ViewValue = $this->Id_Zona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Zona->ViewValue = $this->Id_Zona->CurrentValue;
			}
		} else {
			$this->Id_Zona->ViewValue = NULL;
		}
		$this->Id_Zona->ViewCustomAttributes = "";

		// DEPARTAMENTO
		if (strval($this->DEPARTAMENTO->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->DEPARTAMENTO->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->DEPARTAMENTO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DEPARTAMENTO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DEPARTAMENTO->ViewValue = $this->DEPARTAMENTO->CurrentValue;
			}
		} else {
			$this->DEPARTAMENTO->ViewValue = NULL;
		}
		$this->DEPARTAMENTO->ViewCustomAttributes = "";

		// LOCALIDAD
		$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
		if (strval($this->LOCALIDAD->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->LOCALIDAD->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->LOCALIDAD->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LOCALIDAD->ViewValue = $this->LOCALIDAD->CurrentValue;
			}
		} else {
			$this->LOCALIDAD->ViewValue = NULL;
		}
		$this->LOCALIDAD->ViewCustomAttributes = "";

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->CurrentValue;
		$this->SERIE_NETBOOK->ImageAlt = $this->SERIE_NETBOOK->FldAlt();
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// N° TIKET
		$this->NB0_TIKET->ViewValue = $this->NB0_TIKET->CurrentValue;
		$this->NB0_TIKET->ImageAlt = $this->NB0_TIKET->FldAlt();
		$this->NB0_TIKET->ViewCustomAttributes = "";

		// PROBLEMA
		$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
		if (strval($this->PROBLEMA->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->PROBLEMA->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
		$sWhereWrk = "";
		$this->PROBLEMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROBLEMA->ViewValue = $this->PROBLEMA->CurrentValue;
			}
		} else {
			$this->PROBLEMA->ViewValue = NULL;
		}
		$this->PROBLEMA->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Retiro->ViewValue = NULL;
		}
		$this->Id_Tipo_Retiro->ViewCustomAttributes = "";

			// CUE
			$this->CUE->LinkCustomAttributes = "";
			$this->CUE->HrefValue = "";
			$this->CUE->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

			// DEPARTAMENTO
			$this->DEPARTAMENTO->LinkCustomAttributes = "";
			$this->DEPARTAMENTO->HrefValue = "";
			$this->DEPARTAMENTO->TooltipValue = "";

			// LOCALIDAD
			$this->LOCALIDAD->LinkCustomAttributes = "";
			$this->LOCALIDAD->HrefValue = "";
			$this->LOCALIDAD->TooltipValue = "";

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->LinkCustomAttributes = "";
			$this->SERIE_NETBOOK->HrefValue = "";
			$this->SERIE_NETBOOK->TooltipValue = "";

			// N° TIKET
			$this->NB0_TIKET->LinkCustomAttributes = "";
			$this->NB0_TIKET->HrefValue = "";
			$this->NB0_TIKET->TooltipValue = "";

			// PROBLEMA
			$this->PROBLEMA->LinkCustomAttributes = "";
			$this->PROBLEMA->HrefValue = "";
			$this->PROBLEMA->TooltipValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";
			$this->Id_Tipo_Retiro->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// CUE
			$this->CUE->EditAttrs["class"] = "form-control";
			$this->CUE->EditCustomAttributes = "";
			$this->CUE->EditValue = ew_HtmlEncode($this->CUE->AdvancedSearch->SearchValue);
			$this->CUE->PlaceHolder = ew_RemoveHtml($this->CUE->FldCaption());

			// Sigla
			$this->Sigla->EditAttrs["class"] = "form-control";
			$this->Sigla->EditCustomAttributes = "";
			$this->Sigla->EditValue = ew_HtmlEncode($this->Sigla->AdvancedSearch->SearchValue);
			$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

			// Id_Zona
			$this->Id_Zona->EditAttrs["class"] = "form-control";
			$this->Id_Zona->EditCustomAttributes = "";
			if (trim(strval($this->Id_Zona->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Zona->EditValue = $arwrk;

			// DEPARTAMENTO
			$this->DEPARTAMENTO->EditAttrs["class"] = "form-control";
			$this->DEPARTAMENTO->EditCustomAttributes = "";
			if (trim(strval($this->DEPARTAMENTO->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->DEPARTAMENTO->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->DEPARTAMENTO->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->DEPARTAMENTO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->DEPARTAMENTO->EditValue = $arwrk;

			// LOCALIDAD
			$this->LOCALIDAD->EditAttrs["class"] = "form-control";
			$this->LOCALIDAD->EditCustomAttributes = "";
			$this->LOCALIDAD->EditValue = ew_HtmlEncode($this->LOCALIDAD->AdvancedSearch->SearchValue);
			if (strval($this->LOCALIDAD->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->LOCALIDAD->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "";
			$this->LOCALIDAD->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->LOCALIDAD->EditValue = $this->LOCALIDAD->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->LOCALIDAD->EditValue = ew_HtmlEncode($this->LOCALIDAD->AdvancedSearch->SearchValue);
				}
			} else {
				$this->LOCALIDAD->EditValue = NULL;
			}
			$this->LOCALIDAD->PlaceHolder = ew_RemoveHtml($this->LOCALIDAD->FldCaption());

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->EditAttrs["class"] = "form-control";
			$this->SERIE_NETBOOK->EditCustomAttributes = "";
			$this->SERIE_NETBOOK->EditValue = ew_HtmlEncode($this->SERIE_NETBOOK->AdvancedSearch->SearchValue);
			$this->SERIE_NETBOOK->PlaceHolder = ew_RemoveHtml($this->SERIE_NETBOOK->FldCaption());

			// N° TIKET
			$this->NB0_TIKET->EditAttrs["class"] = "form-control";
			$this->NB0_TIKET->EditCustomAttributes = "";
			$this->NB0_TIKET->EditValue = ew_HtmlEncode($this->NB0_TIKET->AdvancedSearch->SearchValue);
			$this->NB0_TIKET->PlaceHolder = ew_RemoveHtml($this->NB0_TIKET->FldCaption());

			// PROBLEMA
			$this->PROBLEMA->EditAttrs["class"] = "form-control";
			$this->PROBLEMA->EditCustomAttributes = "";
			$this->PROBLEMA->EditValue = ew_HtmlEncode($this->PROBLEMA->AdvancedSearch->SearchValue);
			if (strval($this->PROBLEMA->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->PROBLEMA->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
			$sWhereWrk = "";
			$this->PROBLEMA->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->PROBLEMA->EditValue = $this->PROBLEMA->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->PROBLEMA->EditValue = ew_HtmlEncode($this->PROBLEMA->AdvancedSearch->SearchValue);
				}
			} else {
				$this->PROBLEMA->EditValue = NULL;
			}
			$this->PROBLEMA->PlaceHolder = ew_RemoveHtml($this->PROBLEMA->FldCaption());

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Retiro->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Retiro->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;
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
		$this->CUE->AdvancedSearch->Load();
		$this->Sigla->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
		$this->DEPARTAMENTO->AdvancedSearch->Load();
		$this->LOCALIDAD->AdvancedSearch->Load();
		$this->SERIE_NETBOOK->AdvancedSearch->Load();
		$this->NB0_TIKET->AdvancedSearch->Load();
		$this->PROBLEMA->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pedido_stlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Zona":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Zona` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Zona` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_DEPARTAMENTO":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->DEPARTAMENTO->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->DEPARTAMENTO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_LOCALIDAD":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->LOCALIDAD->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_PROBLEMA":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `problema`";
			$sWhereWrk = "{filter}";
			$this->PROBLEMA->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Retiro":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Retiro` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Retiro` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
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
		case "x_LOCALIDAD":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld` FROM `localidades`";
			$sWhereWrk = "`Nombre` LIKE '{query_value}%'";
			$this->LOCALIDAD->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->LOCALIDAD, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_PROBLEMA":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld` FROM `problema`";
			$sWhereWrk = "`Descripcion` LIKE '{query_value}%'";
			$this->PROBLEMA->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->PROBLEMA, $sWhereWrk); // Call Lookup selecting
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
if (!isset($pedido_st_search)) $pedido_st_search = new cpedido_st_search();

// Page init
$pedido_st_search->Page_Init();

// Page main
$pedido_st_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pedido_st_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($pedido_st_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fpedido_stsearch = new ew_Form("fpedido_stsearch", "search");
<?php } else { ?>
var CurrentForm = fpedido_stsearch = new ew_Form("fpedido_stsearch", "search");
<?php } ?>

// Form_CustomValidate event
fpedido_stsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpedido_stsearch.ValidateRequired = true;
<?php } else { ?>
fpedido_stsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpedido_stsearch.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};
fpedido_stsearch.Lists["x_DEPARTAMENTO"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpedido_stsearch.Lists["x_LOCALIDAD"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fpedido_stsearch.Lists["x_PROBLEMA"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
fpedido_stsearch.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
// Validate function for search

fpedido_stsearch.Validate = function(fobj) {
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
<?php if (!$pedido_st_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pedido_st_search->ShowPageHeader(); ?>
<?php
$pedido_st_search->ShowMessage();
?>
<form name="fpedido_stsearch" id="fpedido_stsearch" class="<?php echo $pedido_st_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pedido_st_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pedido_st_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pedido_st">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($pedido_st_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pedido_st->CUE->Visible) { // CUE ?>
	<div id="r_CUE" class="form-group">
		<label for="x_CUE" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_CUE"><?php echo $pedido_st->CUE->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_CUE" id="z_CUE" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->CUE->CellAttributes() ?>>
			<span id="el_pedido_st_CUE">
<input type="text" data-table="pedido_st" data-field="x_CUE" name="x_CUE" id="x_CUE" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pedido_st->CUE->getPlaceHolder()) ?>" value="<?php echo $pedido_st->CUE->EditValue ?>"<?php echo $pedido_st->CUE->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->Sigla->Visible) { // Sigla ?>
	<div id="r_Sigla" class="form-group">
		<label for="x_Sigla" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_Sigla"><?php echo $pedido_st->Sigla->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Sigla" id="z_Sigla" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->Sigla->CellAttributes() ?>>
			<span id="el_pedido_st_Sigla">
<input type="text" data-table="pedido_st" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pedido_st->Sigla->getPlaceHolder()) ?>" value="<?php echo $pedido_st->Sigla->EditValue ?>"<?php echo $pedido_st->Sigla->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->Id_Zona->Visible) { // Id_Zona ?>
	<div id="r_Id_Zona" class="form-group">
		<label for="x_Id_Zona" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_Id_Zona"><?php echo $pedido_st->Id_Zona->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Zona" id="z_Id_Zona" value="="></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->Id_Zona->CellAttributes() ?>>
			<span id="el_pedido_st_Id_Zona">
<select data-table="pedido_st" data-field="x_Id_Zona" data-value-separator="<?php echo $pedido_st->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x_Id_Zona" name="x_Id_Zona"<?php echo $pedido_st->Id_Zona->EditAttributes() ?>>
<?php echo $pedido_st->Id_Zona->SelectOptionListHtml("x_Id_Zona") ?>
</select>
<input type="hidden" name="s_x_Id_Zona" id="s_x_Id_Zona" value="<?php echo $pedido_st->Id_Zona->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->DEPARTAMENTO->Visible) { // DEPARTAMENTO ?>
	<div id="r_DEPARTAMENTO" class="form-group">
		<label for="x_DEPARTAMENTO" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_DEPARTAMENTO"><?php echo $pedido_st->DEPARTAMENTO->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_DEPARTAMENTO" id="z_DEPARTAMENTO" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->DEPARTAMENTO->CellAttributes() ?>>
			<span id="el_pedido_st_DEPARTAMENTO">
<select data-table="pedido_st" data-field="x_DEPARTAMENTO" data-value-separator="<?php echo $pedido_st->DEPARTAMENTO->DisplayValueSeparatorAttribute() ?>" id="x_DEPARTAMENTO" name="x_DEPARTAMENTO"<?php echo $pedido_st->DEPARTAMENTO->EditAttributes() ?>>
<?php echo $pedido_st->DEPARTAMENTO->SelectOptionListHtml("x_DEPARTAMENTO") ?>
</select>
<input type="hidden" name="s_x_DEPARTAMENTO" id="s_x_DEPARTAMENTO" value="<?php echo $pedido_st->DEPARTAMENTO->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->LOCALIDAD->Visible) { // LOCALIDAD ?>
	<div id="r_LOCALIDAD" class="form-group">
		<label class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_LOCALIDAD"><?php echo $pedido_st->LOCALIDAD->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_LOCALIDAD" id="z_LOCALIDAD" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->LOCALIDAD->CellAttributes() ?>>
			<span id="el_pedido_st_LOCALIDAD">
<?php
$wrkonchange = trim(" " . @$pedido_st->LOCALIDAD->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pedido_st->LOCALIDAD->EditAttrs["onchange"] = "";
?>
<span id="as_x_LOCALIDAD" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_LOCALIDAD" id="sv_x_LOCALIDAD" value="<?php echo $pedido_st->LOCALIDAD->EditValue ?>" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pedido_st->LOCALIDAD->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pedido_st->LOCALIDAD->getPlaceHolder()) ?>"<?php echo $pedido_st->LOCALIDAD->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pedido_st" data-field="x_LOCALIDAD" data-value-separator="<?php echo $pedido_st->LOCALIDAD->DisplayValueSeparatorAttribute() ?>" name="x_LOCALIDAD" id="x_LOCALIDAD" value="<?php echo ew_HtmlEncode($pedido_st->LOCALIDAD->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_LOCALIDAD" id="q_x_LOCALIDAD" value="<?php echo $pedido_st->LOCALIDAD->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpedido_stsearch.CreateAutoSuggest({"id":"x_LOCALIDAD","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->SERIE_NETBOOK->Visible) { // SERIE NETBOOK ?>
	<div id="r_SERIE_NETBOOK" class="form-group">
		<label for="x_SERIE_NETBOOK" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_SERIE_NETBOOK"><?php echo $pedido_st->SERIE_NETBOOK->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SERIE_NETBOOK" id="z_SERIE_NETBOOK" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->SERIE_NETBOOK->CellAttributes() ?>>
			<span id="el_pedido_st_SERIE_NETBOOK">
<input type="text" data-table="pedido_st" data-field="x_SERIE_NETBOOK" name="x_SERIE_NETBOOK" id="x_SERIE_NETBOOK" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pedido_st->SERIE_NETBOOK->getPlaceHolder()) ?>" value="<?php echo $pedido_st->SERIE_NETBOOK->EditValue ?>"<?php echo $pedido_st->SERIE_NETBOOK->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->NB0_TIKET->Visible) { // N° TIKET ?>
	<div id="r_NB0_TIKET" class="form-group">
		<label for="x_NB0_TIKET" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_NB0_TIKET"><?php echo $pedido_st->NB0_TIKET->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_NB0_TIKET" id="z_NB0_TIKET" value="="></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->NB0_TIKET->CellAttributes() ?>>
			<span id="el_pedido_st_NB0_TIKET">
<input type="text" data-table="pedido_st" data-field="x_NB0_TIKET" name="x_NB0_TIKET" id="x_NB0_TIKET" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pedido_st->NB0_TIKET->getPlaceHolder()) ?>" value="<?php echo $pedido_st->NB0_TIKET->EditValue ?>"<?php echo $pedido_st->NB0_TIKET->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->PROBLEMA->Visible) { // PROBLEMA ?>
	<div id="r_PROBLEMA" class="form-group">
		<label class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_PROBLEMA"><?php echo $pedido_st->PROBLEMA->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_PROBLEMA" id="z_PROBLEMA" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->PROBLEMA->CellAttributes() ?>>
			<span id="el_pedido_st_PROBLEMA">
<?php
$wrkonchange = trim(" " . @$pedido_st->PROBLEMA->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pedido_st->PROBLEMA->EditAttrs["onchange"] = "";
?>
<span id="as_x_PROBLEMA" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_PROBLEMA" id="sv_x_PROBLEMA" value="<?php echo $pedido_st->PROBLEMA->EditValue ?>" size="30" maxlength="400" placeholder="<?php echo ew_HtmlEncode($pedido_st->PROBLEMA->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pedido_st->PROBLEMA->getPlaceHolder()) ?>"<?php echo $pedido_st->PROBLEMA->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pedido_st" data-field="x_PROBLEMA" data-value-separator="<?php echo $pedido_st->PROBLEMA->DisplayValueSeparatorAttribute() ?>" name="x_PROBLEMA" id="x_PROBLEMA" value="<?php echo ew_HtmlEncode($pedido_st->PROBLEMA->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_PROBLEMA" id="q_x_PROBLEMA" value="<?php echo $pedido_st->PROBLEMA->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpedido_stsearch.CreateAutoSuggest({"id":"x_PROBLEMA","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
	<div id="r_Id_Tipo_Retiro" class="form-group">
		<label for="x_Id_Tipo_Retiro" class="<?php echo $pedido_st_search->SearchLabelClass ?>"><span id="elh_pedido_st_Id_Tipo_Retiro"><?php echo $pedido_st->Id_Tipo_Retiro->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Tipo_Retiro" id="z_Id_Tipo_Retiro" value="="></p>
		</label>
		<div class="<?php echo $pedido_st_search->SearchRightColumnClass ?>"><div<?php echo $pedido_st->Id_Tipo_Retiro->CellAttributes() ?>>
			<span id="el_pedido_st_Id_Tipo_Retiro">
<select data-table="pedido_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $pedido_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Retiro" name="x_Id_Tipo_Retiro"<?php echo $pedido_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $pedido_st->Id_Tipo_Retiro->SelectOptionListHtml("x_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Retiro" id="s_x_Id_Tipo_Retiro" value="<?php echo $pedido_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pedido_st_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpedido_stsearch.Init();
</script>
<?php
$pedido_st_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pedido_st_search->Page_Terminate();
?>
