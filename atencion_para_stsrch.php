<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "atencion_para_stinfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$atencion_para_st_search = NULL; // Initialize page object first

class catencion_para_st_search extends catencion_para_st {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'atencion_para_st';

	// Page object name
	var $PageObjName = 'atencion_para_st_search';

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

		// Table object (atencion_para_st)
		if (!isset($GLOBALS["atencion_para_st"]) || get_class($GLOBALS["atencion_para_st"]) == "catencion_para_st") {
			$GLOBALS["atencion_para_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["atencion_para_st"];
		}

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'atencion_para_st', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("atencion_para_stlist.php"));
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
		$this->Id_Atencion->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Nro_Tiket->SetVisibility();
		$this->Id_Tipo_Retiro->SetVisibility();
		$this->Referencia_Tipo_Retiro->SetVisibility();
		$this->Fecha_Retiro->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Devolucion->SetVisibility();

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
		global $EW_EXPORT, $atencion_para_st;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($atencion_para_st);
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
						$sSrchStr = "atencion_para_stlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NroSerie); // NroSerie
		$this->BuildSearchUrl($sSrchUrl, $this->Nro_Tiket); // Nro_Tiket
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Retiro); // Id_Tipo_Retiro
		$this->BuildSearchUrl($sSrchUrl, $this->Referencia_Tipo_Retiro); // Referencia_Tipo_Retiro
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Retiro); // Fecha_Retiro
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Devolucion); // Fecha_Devolucion
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

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroSerie"));
		$this->NroSerie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroSerie");

		// Nro_Tiket
		$this->Nro_Tiket->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nro_Tiket"));
		$this->Nro_Tiket->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nro_Tiket");

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Retiro"));
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Retiro");

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Referencia_Tipo_Retiro"));
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Referencia_Tipo_Retiro");

		// Fecha_Retiro
		$this->Fecha_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Retiro"));
		$this->Fecha_Retiro->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Retiro");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Fecha_Devolucion
		$this->Fecha_Devolucion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Devolucion"));
		$this->Fecha_Devolucion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Devolucion");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Atencion
		// NroSerie
		// Nro_Tiket
		// Id_Tipo_Retiro
		// Referencia_Tipo_Retiro
		// Fecha_Retiro
		// Observacion
		// Fecha_Devolucion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Nro_Tiket
		$this->Nro_Tiket->ViewValue = $this->Nro_Tiket->CurrentValue;
		$this->Nro_Tiket->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->ViewValue = $this->Referencia_Tipo_Retiro->CurrentValue;
		$this->Referencia_Tipo_Retiro->ViewCustomAttributes = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->ViewValue = $this->Fecha_Retiro->CurrentValue;
		$this->Fecha_Retiro->ViewValue = ew_FormatDateTime($this->Fecha_Retiro->ViewValue, 7);
		$this->Fecha_Retiro->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->ViewValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->ViewValue = ew_FormatDateTime($this->Fecha_Devolucion->ViewValue, 7);
		$this->Fecha_Devolucion->ViewCustomAttributes = "";

			// Id_Atencion
			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";
			$this->Id_Atencion->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";
			$this->Nro_Tiket->TooltipValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";
			$this->Id_Tipo_Retiro->TooltipValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";
			$this->Referencia_Tipo_Retiro->TooltipValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";
			$this->Fecha_Retiro->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
			$this->Fecha_Devolucion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Atencion
			$this->Id_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Atencion->EditCustomAttributes = "";
			$this->Id_Atencion->EditValue = ew_HtmlEncode($this->Id_Atencion->AdvancedSearch->SearchValue);
			$this->Id_Atencion->PlaceHolder = ew_RemoveHtml($this->Id_Atencion->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->AdvancedSearch->SearchValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Nro_Tiket
			$this->Nro_Tiket->EditAttrs["class"] = "form-control";
			$this->Nro_Tiket->EditCustomAttributes = "";
			$this->Nro_Tiket->EditValue = ew_HtmlEncode($this->Nro_Tiket->AdvancedSearch->SearchValue);
			$this->Nro_Tiket->PlaceHolder = ew_RemoveHtml($this->Nro_Tiket->FldCaption());

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
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Referencia_Tipo_Retiro->EditCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->EditValue = ew_HtmlEncode($this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue);
			$this->Referencia_Tipo_Retiro->PlaceHolder = ew_RemoveHtml($this->Referencia_Tipo_Retiro->FldCaption());

			// Fecha_Retiro
			$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
			$this->Fecha_Retiro->EditCustomAttributes = "";
			$this->Fecha_Retiro->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Retiro->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Devolucion->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());
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
		if (!ew_CheckEuroDate($this->Fecha_Retiro->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Retiro->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Devolucion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Devolucion->FldErrMsg());
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
		$this->NroSerie->AdvancedSearch->Load();
		$this->Nro_Tiket->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
		$this->Referencia_Tipo_Retiro->AdvancedSearch->Load();
		$this->Fecha_Retiro->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Fecha_Devolucion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("atencion_para_stlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Tipo_Retiro":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Retiro` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Retiro` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
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
if (!isset($atencion_para_st_search)) $atencion_para_st_search = new catencion_para_st_search();

// Page init
$atencion_para_st_search->Page_Init();

// Page main
$atencion_para_st_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_para_st_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($atencion_para_st_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fatencion_para_stsearch = new ew_Form("fatencion_para_stsearch", "search");
<?php } else { ?>
var CurrentForm = fatencion_para_stsearch = new ew_Form("fatencion_para_stsearch", "search");
<?php } ?>

// Form_CustomValidate event
fatencion_para_stsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_para_stsearch.ValidateRequired = true;
<?php } else { ?>
fatencion_para_stsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_para_stsearch.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
// Validate function for search

fatencion_para_stsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Fecha_Retiro");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Retiro->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Devolucion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Devolucion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$atencion_para_st_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $atencion_para_st_search->ShowPageHeader(); ?>
<?php
$atencion_para_st_search->ShowMessage();
?>
<form name="fatencion_para_stsearch" id="fatencion_para_stsearch" class="<?php echo $atencion_para_st_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($atencion_para_st_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $atencion_para_st_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="atencion_para_st">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($atencion_para_st_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($atencion_para_st->Id_Atencion->Visible) { // Id_Atencion ?>
	<div id="r_Id_Atencion" class="form-group">
		<label class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Id_Atencion"><?php echo $atencion_para_st->Id_Atencion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Atencion" id="z_Id_Atencion" value="="></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Id_Atencion->CellAttributes() ?>>
			<span id="el_atencion_para_st_Id_Atencion">
<input type="text" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x_Id_Atencion" id="x_Id_Atencion" size="30" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Id_Atencion->EditValue ?>"<?php echo $atencion_para_st->Id_Atencion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label for="x_NroSerie" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_NroSerie"><?php echo $atencion_para_st->NroSerie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroSerie" id="z_NroSerie" value="LIKE"></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->NroSerie->CellAttributes() ?>>
			<span id="el_atencion_para_st_NroSerie">
<input type="text" data-table="atencion_para_st" data-field="x_NroSerie" name="x_NroSerie" id="x_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->NroSerie->EditValue ?>"<?php echo $atencion_para_st->NroSerie->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
	<div id="r_Nro_Tiket" class="form-group">
		<label for="x_Nro_Tiket" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Nro_Tiket"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Nro_Tiket" id="z_Nro_Tiket" value="="></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Nro_Tiket->CellAttributes() ?>>
			<span id="el_atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x_Nro_Tiket" id="x_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
	<div id="r_Id_Tipo_Retiro" class="form-group">
		<label for="x_Id_Tipo_Retiro" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Id_Tipo_Retiro"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Tipo_Retiro" id="z_Id_Tipo_Retiro" value="="></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Id_Tipo_Retiro->CellAttributes() ?>>
			<span id="el_atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Retiro" name="x_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Retiro" id="s_x_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
	<div id="r_Referencia_Tipo_Retiro" class="form-group">
		<label for="x_Referencia_Tipo_Retiro" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Referencia_Tipo_Retiro"><?php echo $atencion_para_st->Referencia_Tipo_Retiro->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Referencia_Tipo_Retiro" id="z_Referencia_Tipo_Retiro" value="LIKE"></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Referencia_Tipo_Retiro->CellAttributes() ?>>
			<span id="el_atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="x_Referencia_Tipo_Retiro" id="x_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
	<div id="r_Fecha_Retiro" class="form-group">
		<label for="x_Fecha_Retiro" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Fecha_Retiro"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Retiro" id="z_Fecha_Retiro" value="LIKE"></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Fecha_Retiro->CellAttributes() ?>>
			<span id="el_atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-format="7" name="x_Fecha_Retiro" id="x_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stsearch", "x_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Observacion"><?php echo $atencion_para_st->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Observacion->CellAttributes() ?>>
			<span id="el_atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
	<div id="r_Fecha_Devolucion" class="form-group">
		<label for="x_Fecha_Devolucion" class="<?php echo $atencion_para_st_search->SearchLabelClass ?>"><span id="elh_atencion_para_st_Fecha_Devolucion"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Devolucion" id="z_Fecha_Devolucion" value="LIKE"></p>
		</label>
		<div class="<?php echo $atencion_para_st_search->SearchRightColumnClass ?>"><div<?php echo $atencion_para_st->Fecha_Devolucion->CellAttributes() ?>>
			<span id="el_atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-format="7" name="x_Fecha_Devolucion" id="x_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stsearch", "x_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$atencion_para_st_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fatencion_para_stsearch.Init();
</script>
<?php
$atencion_para_st_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$atencion_para_st_search->Page_Terminate();
?>
