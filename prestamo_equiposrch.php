<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "prestamo_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$prestamo_equipo_search = NULL; // Initialize page object first

class cprestamo_equipo_search extends cprestamo_equipo {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'prestamo_equipo';

	// Page object name
	var $PageObjName = 'prestamo_equipo_search';

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

		// Table object (prestamo_equipo)
		if (!isset($GLOBALS["prestamo_equipo"]) || get_class($GLOBALS["prestamo_equipo"]) == "cprestamo_equipo") {
			$GLOBALS["prestamo_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["prestamo_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'prestamo_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("prestamo_equipolist.php"));
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
		$this->Id_Prestamo->SetVisibility();
		$this->Id_Prestamo->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Apellidos_Nombres_Beneficiario->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Id_Motivo_Prestamo->SetVisibility();
		$this->Fecha_Prestamo->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Prestamo_Cargador->SetVisibility();
		$this->Id_Estado_Prestamo->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Id_Estado_Devol->SetVisibility();
		$this->Devuelve_Cargador->SetVisibility();

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
		global $EW_EXPORT, $prestamo_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($prestamo_equipo);
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
						$sSrchStr = "prestamo_equipolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Prestamo); // Id_Prestamo
		$this->BuildSearchUrl($sSrchUrl, $this->Apellidos_Nombres_Beneficiario); // Apellidos_Nombres_Beneficiario
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->NroSerie); // NroSerie
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Motivo_Prestamo); // Id_Motivo_Prestamo
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Prestamo); // Fecha_Prestamo
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Prestamo_Cargador); // Prestamo_Cargador
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Prestamo); // Id_Estado_Prestamo
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario); // Usuario
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Actualizacion); // Fecha_Actualizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Devol); // Id_Estado_Devol
		$this->BuildSearchUrl($sSrchUrl, $this->Devuelve_Cargador); // Devuelve_Cargador
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
		// Id_Prestamo

		$this->Id_Prestamo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Prestamo"));
		$this->Id_Prestamo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Prestamo");

		// Apellidos_Nombres_Beneficiario
		$this->Apellidos_Nombres_Beneficiario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellidos_Nombres_Beneficiario"));
		$this->Apellidos_Nombres_Beneficiario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellidos_Nombres_Beneficiario");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroSerie"));
		$this->NroSerie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroSerie");

		// Id_Motivo_Prestamo
		$this->Id_Motivo_Prestamo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Motivo_Prestamo"));
		$this->Id_Motivo_Prestamo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Motivo_Prestamo");

		// Fecha_Prestamo
		$this->Fecha_Prestamo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Prestamo"));
		$this->Fecha_Prestamo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Prestamo");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Prestamo_Cargador
		$this->Prestamo_Cargador->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Prestamo_Cargador"));
		$this->Prestamo_Cargador->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Prestamo_Cargador");

		// Id_Estado_Prestamo
		$this->Id_Estado_Prestamo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Prestamo"));
		$this->Id_Estado_Prestamo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Prestamo");

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario"));
		$this->Usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario");

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Actualizacion"));
		$this->Fecha_Actualizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Actualizacion");

		// Id_Estado_Devol
		$this->Id_Estado_Devol->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Devol"));
		$this->Id_Estado_Devol->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Devol");

		// Devuelve_Cargador
		$this->Devuelve_Cargador->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Devuelve_Cargador"));
		$this->Devuelve_Cargador->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Devuelve_Cargador");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Prestamo
		// Apellidos_Nombres_Beneficiario
		// Dni
		// NroSerie
		// Id_Motivo_Prestamo
		// Fecha_Prestamo
		// Observacion
		// Prestamo_Cargador
		// Id_Estado_Prestamo
		// Usuario
		// Fecha_Actualizacion
		// Id_Estado_Devol
		// Devuelve_Cargador

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Prestamo
		$this->Id_Prestamo->ViewValue = $this->Id_Prestamo->CurrentValue;
		$this->Id_Prestamo->ViewCustomAttributes = "";

		// Apellidos_Nombres_Beneficiario
		if (strval($this->Apellidos_Nombres_Beneficiario->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
		$sWhereWrk = "";
		$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`Id_Estado_Espera`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellidos_Nombres_Beneficiario->ViewValue = $this->Apellidos_Nombres_Beneficiario->CurrentValue;
			}
		} else {
			$this->Apellidos_Nombres_Beneficiario->ViewValue = NULL;
		}
		$this->Apellidos_Nombres_Beneficiario->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		$lookuptblfilter = "`Id_Sit_Estado`='3'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			}
		} else {
			$this->NroSerie->ViewValue = NULL;
		}
		$this->NroSerie->ViewCustomAttributes = "";

		// Id_Motivo_Prestamo
		if (strval($this->Id_Motivo_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Motivo_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Prestamo->ViewValue = $this->Id_Motivo_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Prestamo->ViewValue = NULL;
		}
		$this->Id_Motivo_Prestamo->ViewCustomAttributes = "";

		// Fecha_Prestamo
		$this->Fecha_Prestamo->ViewValue = $this->Fecha_Prestamo->CurrentValue;
		$this->Fecha_Prestamo->ViewValue = ew_FormatDateTime($this->Fecha_Prestamo->ViewValue, 7);
		$this->Fecha_Prestamo->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Prestamo_Cargador
		if (strval($this->Prestamo_Cargador->CurrentValue) <> "") {
			$this->Prestamo_Cargador->ViewValue = $this->Prestamo_Cargador->OptionCaption($this->Prestamo_Cargador->CurrentValue);
		} else {
			$this->Prestamo_Cargador->ViewValue = NULL;
		}
		$this->Prestamo_Cargador->ViewCustomAttributes = "";

		// Id_Estado_Prestamo
		if (strval($this->Id_Estado_Prestamo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
		$sWhereWrk = "";
		$this->Id_Estado_Prestamo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Prestamo->ViewValue = $this->Id_Estado_Prestamo->CurrentValue;
			}
		} else {
			$this->Id_Estado_Prestamo->ViewValue = NULL;
		}
		$this->Id_Estado_Prestamo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Id_Estado_Devol
		if (strval($this->Id_Estado_Devol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_devolucion_prestamo`";
		$sWhereWrk = "";
		$this->Id_Estado_Devol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Devol->ViewValue = $this->Id_Estado_Devol->CurrentValue;
			}
		} else {
			$this->Id_Estado_Devol->ViewValue = NULL;
		}
		$this->Id_Estado_Devol->ViewCustomAttributes = "";

		// Devuelve_Cargador
		if (strval($this->Devuelve_Cargador->CurrentValue) <> "") {
			$this->Devuelve_Cargador->ViewValue = $this->Devuelve_Cargador->OptionCaption($this->Devuelve_Cargador->CurrentValue);
		} else {
			$this->Devuelve_Cargador->ViewValue = NULL;
		}
		$this->Devuelve_Cargador->ViewCustomAttributes = "";

			// Id_Prestamo
			$this->Id_Prestamo->LinkCustomAttributes = "";
			$this->Id_Prestamo->HrefValue = "";
			$this->Id_Prestamo->TooltipValue = "";

			// Apellidos_Nombres_Beneficiario
			$this->Apellidos_Nombres_Beneficiario->LinkCustomAttributes = "";
			$this->Apellidos_Nombres_Beneficiario->HrefValue = "";
			$this->Apellidos_Nombres_Beneficiario->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->LinkCustomAttributes = "";
			$this->Id_Motivo_Prestamo->HrefValue = "";
			$this->Id_Motivo_Prestamo->TooltipValue = "";

			// Fecha_Prestamo
			$this->Fecha_Prestamo->LinkCustomAttributes = "";
			$this->Fecha_Prestamo->HrefValue = "";
			$this->Fecha_Prestamo->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Prestamo_Cargador
			$this->Prestamo_Cargador->LinkCustomAttributes = "";
			$this->Prestamo_Cargador->HrefValue = "";
			$this->Prestamo_Cargador->TooltipValue = "";

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->LinkCustomAttributes = "";
			$this->Id_Estado_Prestamo->HrefValue = "";
			$this->Id_Estado_Prestamo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Id_Estado_Devol
			$this->Id_Estado_Devol->LinkCustomAttributes = "";
			$this->Id_Estado_Devol->HrefValue = "";
			$this->Id_Estado_Devol->TooltipValue = "";

			// Devuelve_Cargador
			$this->Devuelve_Cargador->LinkCustomAttributes = "";
			$this->Devuelve_Cargador->HrefValue = "";
			$this->Devuelve_Cargador->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Prestamo
			$this->Id_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Prestamo->EditCustomAttributes = "";
			$this->Id_Prestamo->EditValue = ew_HtmlEncode($this->Id_Prestamo->AdvancedSearch->SearchValue);
			$this->Id_Prestamo->PlaceHolder = ew_RemoveHtml($this->Id_Prestamo->FldCaption());

			// Apellidos_Nombres_Beneficiario
			$this->Apellidos_Nombres_Beneficiario->EditCustomAttributes = "";
			if (trim(strval($this->Apellidos_Nombres_Beneficiario->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Apellidos_Nombres_Beneficiario->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lista_espera_prestamo`";
			$sWhereWrk = "";
			$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado_Espera`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->Apellidos_Nombres_Beneficiario->AdvancedSearch->ViewValue = $this->Apellidos_Nombres_Beneficiario->DisplayValue($arwrk);
			} else {
				$this->Apellidos_Nombres_Beneficiario->AdvancedSearch->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Apellidos_Nombres_Beneficiario->EditValue = $arwrk;

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditCustomAttributes = "";
			if (trim(strval($this->NroSerie->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$lookuptblfilter = "`Id_Sit_Estado`='3'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->NroSerie->AdvancedSearch->ViewValue = $this->NroSerie->DisplayValue($arwrk);
			} else {
				$this->NroSerie->AdvancedSearch->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->NroSerie->EditValue = $arwrk;

			// Id_Motivo_Prestamo
			$this->Id_Motivo_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Prestamo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo_Prestamo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo_Prestamo`" . ew_SearchString("=", $this->Id_Motivo_Prestamo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo_Prestamo->EditValue = $arwrk;

			// Fecha_Prestamo
			$this->Fecha_Prestamo->EditAttrs["class"] = "form-control";
			$this->Fecha_Prestamo->EditCustomAttributes = "";
			$this->Fecha_Prestamo->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Prestamo->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Prestamo->PlaceHolder = ew_RemoveHtml($this->Fecha_Prestamo->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Prestamo_Cargador
			$this->Prestamo_Cargador->EditCustomAttributes = "";
			$this->Prestamo_Cargador->EditValue = $this->Prestamo_Cargador->Options(FALSE);

			// Id_Estado_Prestamo
			$this->Id_Estado_Prestamo->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Prestamo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Prestamo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Prestamo`" . ew_SearchString("=", $this->Id_Estado_Prestamo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Prestamo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado_Prestamo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Prestamo->EditValue = $arwrk;

			// Usuario
			$this->Usuario->EditAttrs["class"] = "form-control";
			$this->Usuario->EditCustomAttributes = "";
			$this->Usuario->EditValue = ew_HtmlEncode($this->Usuario->AdvancedSearch->SearchValue);
			$this->Usuario->PlaceHolder = ew_RemoveHtml($this->Usuario->FldCaption());

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Actualizacion->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Actualizacion->FldCaption());

			// Id_Estado_Devol
			$this->Id_Estado_Devol->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Devol->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Devol->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Devol`" . ew_SearchString("=", $this->Id_Estado_Devol->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Devol`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_devolucion_prestamo`";
			$sWhereWrk = "";
			$this->Id_Estado_Devol->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Devol->EditValue = $arwrk;

			// Devuelve_Cargador
			$this->Devuelve_Cargador->EditCustomAttributes = "";
			$this->Devuelve_Cargador->EditValue = $this->Devuelve_Cargador->Options(FALSE);
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
		if (!ew_CheckEuroDate($this->Fecha_Prestamo->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Prestamo->FldErrMsg());
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
		$this->Id_Prestamo->AdvancedSearch->Load();
		$this->Apellidos_Nombres_Beneficiario->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Id_Motivo_Prestamo->AdvancedSearch->Load();
		$this->Fecha_Prestamo->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Prestamo_Cargador->AdvancedSearch->Load();
		$this->Id_Estado_Prestamo->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Id_Estado_Devol->AdvancedSearch->Load();
		$this->Devuelve_Cargador->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("prestamo_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Apellidos_Nombres_Beneficiario":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lista_espera_prestamo`";
			$sWhereWrk = "{filter}";
			$this->Apellidos_Nombres_Beneficiario->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`Id_Estado_Espera`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellidos_Nombres_Beneficiario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Fecha_Actualizacion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$lookuptblfilter = "`Id_Sit_Estado`='3'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo_Prestamo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo_Prestamo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Motivo_Prestamo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo_Prestamo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Prestamo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Prestamo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_prestamo_equipo`";
			$sWhereWrk = "";
			$this->Id_Estado_Prestamo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Prestamo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Prestamo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Devol":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Devol` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_devolucion_prestamo`";
			$sWhereWrk = "";
			$this->Id_Estado_Devol->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Devol` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Devol, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
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
if (!isset($prestamo_equipo_search)) $prestamo_equipo_search = new cprestamo_equipo_search();

// Page init
$prestamo_equipo_search->Page_Init();

// Page main
$prestamo_equipo_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$prestamo_equipo_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($prestamo_equipo_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fprestamo_equiposearch = new ew_Form("fprestamo_equiposearch", "search");
<?php } else { ?>
var CurrentForm = fprestamo_equiposearch = new ew_Form("fprestamo_equiposearch", "search");
<?php } ?>

// Form_CustomValidate event
fprestamo_equiposearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprestamo_equiposearch.ValidateRequired = true;
<?php } else { ?>
fprestamo_equiposearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fprestamo_equiposearch.Lists["x_Apellidos_Nombres_Beneficiario"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"lista_espera_prestamo"};
fprestamo_equiposearch.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fprestamo_equiposearch.Lists["x_Id_Motivo_Prestamo"] = {"LinkField":"x_Id_Motivo_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_prestamo_equipo"};
fprestamo_equiposearch.Lists["x_Prestamo_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprestamo_equiposearch.Lists["x_Prestamo_Cargador"].Options = <?php echo json_encode($prestamo_equipo->Prestamo_Cargador->Options()) ?>;
fprestamo_equiposearch.Lists["x_Id_Estado_Prestamo"] = {"LinkField":"x_Id_Estado_Prestamo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_prestamo_equipo"};
fprestamo_equiposearch.Lists["x_Id_Estado_Devol"] = {"LinkField":"x_Id_Estado_Devol","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_devolucion_prestamo"};
fprestamo_equiposearch.Lists["x_Devuelve_Cargador"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprestamo_equiposearch.Lists["x_Devuelve_Cargador"].Options = <?php echo json_encode($prestamo_equipo->Devuelve_Cargador->Options()) ?>;

// Form object for search
// Validate function for search

fprestamo_equiposearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($prestamo_equipo->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Prestamo");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($prestamo_equipo->Fecha_Prestamo->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$prestamo_equipo_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $prestamo_equipo_search->ShowPageHeader(); ?>
<?php
$prestamo_equipo_search->ShowMessage();
?>
<form name="fprestamo_equiposearch" id="fprestamo_equiposearch" class="<?php echo $prestamo_equipo_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($prestamo_equipo_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $prestamo_equipo_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="prestamo_equipo">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($prestamo_equipo_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($prestamo_equipo->Id_Prestamo->Visible) { // Id_Prestamo ?>
	<div id="r_Id_Prestamo" class="form-group">
		<label class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Id_Prestamo"><?php echo $prestamo_equipo->Id_Prestamo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Prestamo" id="z_Id_Prestamo" value="="></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Id_Prestamo->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Id_Prestamo">
<input type="text" data-table="prestamo_equipo" data-field="x_Id_Prestamo" name="x_Id_Prestamo" id="x_Id_Prestamo" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Id_Prestamo->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Id_Prestamo->EditValue ?>"<?php echo $prestamo_equipo->Id_Prestamo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Apellidos_Nombres_Beneficiario->Visible) { // Apellidos_Nombres_Beneficiario ?>
	<div id="r_Apellidos_Nombres_Beneficiario" class="form-group">
		<label for="x_Apellidos_Nombres_Beneficiario" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Apellidos_Nombres_Beneficiario"><?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellidos_Nombres_Beneficiario" id="z_Apellidos_Nombres_Beneficiario" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Apellidos_Nombres_Beneficiario">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Apellidos_Nombres_Beneficiario"><?php echo (strval($prestamo_equipo->Apellidos_Nombres_Beneficiario->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $prestamo_equipo->Apellidos_Nombres_Beneficiario->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($prestamo_equipo->Apellidos_Nombres_Beneficiario->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Apellidos_Nombres_Beneficiario',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="prestamo_equipo" data-field="x_Apellidos_Nombres_Beneficiario" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->DisplayValueSeparatorAttribute() ?>" name="x_Apellidos_Nombres_Beneficiario" id="x_Apellidos_Nombres_Beneficiario" value="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->AdvancedSearch->SearchValue ?>"<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->EditAttributes() ?>>
<input type="hidden" name="s_x_Apellidos_Nombres_Beneficiario" id="s_x_Apellidos_Nombres_Beneficiario" value="<?php echo $prestamo_equipo->Apellidos_Nombres_Beneficiario->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Dni"><?php echo $prestamo_equipo->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Dni->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Dni">
<input type="text" data-table="prestamo_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Dni->EditValue ?>"<?php echo $prestamo_equipo->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label for="x_NroSerie" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_NroSerie"><?php echo $prestamo_equipo->NroSerie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroSerie" id="z_NroSerie" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->NroSerie->CellAttributes() ?>>
			<span id="el_prestamo_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($prestamo_equipo->NroSerie->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $prestamo_equipo->NroSerie->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($prestamo_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="prestamo_equipo" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $prestamo_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $prestamo_equipo->NroSerie->AdvancedSearch->SearchValue ?>"<?php echo $prestamo_equipo->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $prestamo_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Id_Motivo_Prestamo->Visible) { // Id_Motivo_Prestamo ?>
	<div id="r_Id_Motivo_Prestamo" class="form-group">
		<label for="x_Id_Motivo_Prestamo" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Id_Motivo_Prestamo"><?php echo $prestamo_equipo->Id_Motivo_Prestamo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Motivo_Prestamo" id="z_Id_Motivo_Prestamo" value="="></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Id_Motivo_Prestamo->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Id_Motivo_Prestamo">
<select data-table="prestamo_equipo" data-field="x_Id_Motivo_Prestamo" data-value-separator="<?php echo $prestamo_equipo->Id_Motivo_Prestamo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo_Prestamo" name="x_Id_Motivo_Prestamo"<?php echo $prestamo_equipo->Id_Motivo_Prestamo->EditAttributes() ?>>
<?php echo $prestamo_equipo->Id_Motivo_Prestamo->SelectOptionListHtml("x_Id_Motivo_Prestamo") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo_Prestamo" id="s_x_Id_Motivo_Prestamo" value="<?php echo $prestamo_equipo->Id_Motivo_Prestamo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Fecha_Prestamo->Visible) { // Fecha_Prestamo ?>
	<div id="r_Fecha_Prestamo" class="form-group">
		<label for="x_Fecha_Prestamo" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Fecha_Prestamo"><?php echo $prestamo_equipo->Fecha_Prestamo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Prestamo" id="z_Fecha_Prestamo" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Fecha_Prestamo->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Fecha_Prestamo">
<input type="text" data-table="prestamo_equipo" data-field="x_Fecha_Prestamo" data-format="7" name="x_Fecha_Prestamo" id="x_Fecha_Prestamo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Fecha_Prestamo->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Fecha_Prestamo->EditValue ?>"<?php echo $prestamo_equipo->Fecha_Prestamo->EditAttributes() ?>>
<?php if (!$prestamo_equipo->Fecha_Prestamo->ReadOnly && !$prestamo_equipo->Fecha_Prestamo->Disabled && !isset($prestamo_equipo->Fecha_Prestamo->EditAttrs["readonly"]) && !isset($prestamo_equipo->Fecha_Prestamo->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fprestamo_equiposearch", "x_Fecha_Prestamo", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Observacion"><?php echo $prestamo_equipo->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Observacion->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Observacion">
<input type="text" data-table="prestamo_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="35" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Observacion->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Observacion->EditValue ?>"<?php echo $prestamo_equipo->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Prestamo_Cargador->Visible) { // Prestamo_Cargador ?>
	<div id="r_Prestamo_Cargador" class="form-group">
		<label class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Prestamo_Cargador"><?php echo $prestamo_equipo->Prestamo_Cargador->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Prestamo_Cargador" id="z_Prestamo_Cargador" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Prestamo_Cargador->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Prestamo_Cargador">
<div id="tp_x_Prestamo_Cargador" class="ewTemplate"><input type="radio" data-table="prestamo_equipo" data-field="x_Prestamo_Cargador" data-value-separator="<?php echo $prestamo_equipo->Prestamo_Cargador->DisplayValueSeparatorAttribute() ?>" name="x_Prestamo_Cargador" id="x_Prestamo_Cargador" value="{value}"<?php echo $prestamo_equipo->Prestamo_Cargador->EditAttributes() ?>></div>
<div id="dsl_x_Prestamo_Cargador" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $prestamo_equipo->Prestamo_Cargador->RadioButtonListHtml(FALSE, "x_Prestamo_Cargador") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Prestamo->Visible) { // Id_Estado_Prestamo ?>
	<div id="r_Id_Estado_Prestamo" class="form-group">
		<label for="x_Id_Estado_Prestamo" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Id_Estado_Prestamo"><?php echo $prestamo_equipo->Id_Estado_Prestamo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Estado_Prestamo" id="z_Id_Estado_Prestamo" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Id_Estado_Prestamo->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Id_Estado_Prestamo">
<select data-table="prestamo_equipo" data-field="x_Id_Estado_Prestamo" data-value-separator="<?php echo $prestamo_equipo->Id_Estado_Prestamo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Prestamo" name="x_Id_Estado_Prestamo"<?php echo $prestamo_equipo->Id_Estado_Prestamo->EditAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Prestamo->SelectOptionListHtml("x_Id_Estado_Prestamo") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Prestamo" id="s_x_Id_Estado_Prestamo" value="<?php echo $prestamo_equipo->Id_Estado_Prestamo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Usuario"><?php echo $prestamo_equipo->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Usuario->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Usuario">
<input type="text" data-table="prestamo_equipo" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Usuario->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Usuario->EditValue ?>"<?php echo $prestamo_equipo->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Fecha_Actualizacion"><?php echo $prestamo_equipo->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Fecha_Actualizacion">
<input type="text" data-table="prestamo_equipo" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($prestamo_equipo->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $prestamo_equipo->Fecha_Actualizacion->EditValue ?>"<?php echo $prestamo_equipo->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Id_Estado_Devol->Visible) { // Id_Estado_Devol ?>
	<div id="r_Id_Estado_Devol" class="form-group">
		<label for="x_Id_Estado_Devol" class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Id_Estado_Devol"><?php echo $prestamo_equipo->Id_Estado_Devol->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Estado_Devol" id="z_Id_Estado_Devol" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Id_Estado_Devol->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Id_Estado_Devol">
<select data-table="prestamo_equipo" data-field="x_Id_Estado_Devol" data-value-separator="<?php echo $prestamo_equipo->Id_Estado_Devol->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Devol" name="x_Id_Estado_Devol"<?php echo $prestamo_equipo->Id_Estado_Devol->EditAttributes() ?>>
<?php echo $prestamo_equipo->Id_Estado_Devol->SelectOptionListHtml("x_Id_Estado_Devol") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Devol" id="s_x_Id_Estado_Devol" value="<?php echo $prestamo_equipo->Id_Estado_Devol->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($prestamo_equipo->Devuelve_Cargador->Visible) { // Devuelve_Cargador ?>
	<div id="r_Devuelve_Cargador" class="form-group">
		<label class="<?php echo $prestamo_equipo_search->SearchLabelClass ?>"><span id="elh_prestamo_equipo_Devuelve_Cargador"><?php echo $prestamo_equipo->Devuelve_Cargador->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Devuelve_Cargador" id="z_Devuelve_Cargador" value="LIKE"></p>
		</label>
		<div class="<?php echo $prestamo_equipo_search->SearchRightColumnClass ?>"><div<?php echo $prestamo_equipo->Devuelve_Cargador->CellAttributes() ?>>
			<span id="el_prestamo_equipo_Devuelve_Cargador">
<div id="tp_x_Devuelve_Cargador" class="ewTemplate"><input type="radio" data-table="prestamo_equipo" data-field="x_Devuelve_Cargador" data-value-separator="<?php echo $prestamo_equipo->Devuelve_Cargador->DisplayValueSeparatorAttribute() ?>" name="x_Devuelve_Cargador" id="x_Devuelve_Cargador" value="{value}"<?php echo $prestamo_equipo->Devuelve_Cargador->EditAttributes() ?>></div>
<div id="dsl_x_Devuelve_Cargador" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $prestamo_equipo->Devuelve_Cargador->RadioButtonListHtml(FALSE, "x_Devuelve_Cargador") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$prestamo_equipo_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fprestamo_equiposearch.Init();
</script>
<?php
$prestamo_equipo_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$prestamo_equipo_search->Page_Terminate();
?>
