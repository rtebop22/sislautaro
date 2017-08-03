<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "liberacion_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$liberacion_equipo_search = NULL; // Initialize page object first

class cliberacion_equipo_search extends cliberacion_equipo {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'liberacion_equipo';

	// Page object name
	var $PageObjName = 'liberacion_equipo_search';

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

		// Table object (liberacion_equipo)
		if (!isset($GLOBALS["liberacion_equipo"]) || get_class($GLOBALS["liberacion_equipo"]) == "cliberacion_equipo") {
			$GLOBALS["liberacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["liberacion_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'liberacion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("liberacion_equipolist.php"));
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
		$this->NroSerie->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Fecha_Finalizacion->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Id_Modalidad->SetVisibility();
		$this->Id_Nivel->SetVisibility();
		$this->Id_Autoridad->SetVisibility();
		$this->Fecha_Liberacion->SetVisibility();
		$this->Ruta_Archivo_Copia_Titulo->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $liberacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($liberacion_equipo);
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
	var $MultiPages; // Multi pages object

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
						$sSrchStr = "liberacion_equipolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NroSerie); // NroSerie
		$this->BuildSearchUrl($sSrchUrl, $this->Dni_Tutor); // Dni_Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Finalizacion); // Fecha_Finalizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Modalidad); // Id_Modalidad
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Nivel); // Id_Nivel
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Autoridad); // Id_Autoridad
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Liberacion); // Fecha_Liberacion
		$this->BuildSearchUrl($sSrchUrl, $this->Ruta_Archivo_Copia_Titulo); // Ruta_Archivo_Copia_Titulo
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

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroSerie"));
		$this->NroSerie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroSerie");

		// Dni_Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni_Tutor"));
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni_Tutor");

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Finalizacion"));
		$this->Fecha_Finalizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Finalizacion");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Id_Modalidad
		$this->Id_Modalidad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Modalidad"));
		$this->Id_Modalidad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Modalidad");

		// Id_Nivel
		$this->Id_Nivel->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Nivel"));
		$this->Id_Nivel->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Nivel");

		// Id_Autoridad
		$this->Id_Autoridad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Autoridad"));
		$this->Id_Autoridad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Autoridad");

		// Fecha_Liberacion
		$this->Fecha_Liberacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Liberacion"));
		$this->Fecha_Liberacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Liberacion");

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Ruta_Archivo_Copia_Titulo"));
		$this->Ruta_Archivo_Copia_Titulo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Ruta_Archivo_Copia_Titulo");

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
		// NroSerie
		// Dni_Tutor
		// Fecha_Finalizacion
		// Observacion
		// Id_Modalidad
		// Id_Nivel
		// Id_Autoridad
		// Fecha_Liberacion
		// Ruta_Archivo_Copia_Titulo
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		if (strval($this->Dni->CurrentValue) <> "") {
			$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni->ViewValue = $this->Dni->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni->ViewValue = $this->Dni->CurrentValue;
			}
		} else {
			$this->Dni->ViewValue = NULL;
		}
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
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

		// Dni_Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		if (strval($this->Dni_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
			}
		} else {
			$this->Dni_Tutor->ViewValue = NULL;
		}
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Fecha_Finalizacion
		$this->Fecha_Finalizacion->ViewValue = $this->Fecha_Finalizacion->CurrentValue;
		$this->Fecha_Finalizacion->ViewValue = ew_FormatDateTime($this->Fecha_Finalizacion->ViewValue, 7);
		$this->Fecha_Finalizacion->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Id_Modalidad
		if (strval($this->Id_Modalidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modalidad`" . ew_SearchString("=", $this->Id_Modalidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modalidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modalidad_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Modalidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modalidad->ViewValue = $this->Id_Modalidad->CurrentValue;
			}
		} else {
			$this->Id_Modalidad->ViewValue = NULL;
		}
		$this->Id_Modalidad->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Nivel`" . ew_SearchString("=", $this->Id_Nivel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Autoridad
		if (strval($this->Id_Autoridad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
		$sWhereWrk = "";
		$this->Id_Autoridad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
			}
		} else {
			$this->Id_Autoridad->ViewValue = NULL;
		}
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Fecha_Liberacion
		$this->Fecha_Liberacion->ViewValue = $this->Fecha_Liberacion->CurrentValue;
		$this->Fecha_Liberacion->ViewValue = ew_FormatDateTime($this->Fecha_Liberacion->ViewValue, 7);
		$this->Fecha_Liberacion->ViewCustomAttributes = "";

		// Ruta_Archivo_Copia_Titulo
		$this->Ruta_Archivo_Copia_Titulo->UploadPath = 'ArchivosLiberacion';
		if (!ew_Empty($this->Ruta_Archivo_Copia_Titulo->Upload->DbValue)) {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo_Copia_Titulo->ViewValue = "";
		}
		$this->Ruta_Archivo_Copia_Titulo->ViewCustomAttributes = "";

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

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Dni_Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->LinkCustomAttributes = "";
			$this->Fecha_Finalizacion->HrefValue = "";
			$this->Fecha_Finalizacion->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Id_Modalidad
			$this->Id_Modalidad->LinkCustomAttributes = "";
			$this->Id_Modalidad->HrefValue = "";
			$this->Id_Modalidad->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// Id_Autoridad
			$this->Id_Autoridad->LinkCustomAttributes = "";
			$this->Id_Autoridad->HrefValue = "";
			$this->Id_Autoridad->TooltipValue = "";

			// Fecha_Liberacion
			$this->Fecha_Liberacion->LinkCustomAttributes = "";
			$this->Fecha_Liberacion->HrefValue = "";
			$this->Fecha_Liberacion->TooltipValue = "";

			// Ruta_Archivo_Copia_Titulo
			$this->Ruta_Archivo_Copia_Titulo->LinkCustomAttributes = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue = "";
			$this->Ruta_Archivo_Copia_Titulo->HrefValue2 = $this->Ruta_Archivo_Copia_Titulo->UploadPath . $this->Ruta_Archivo_Copia_Titulo->Upload->DbValue;
			$this->Ruta_Archivo_Copia_Titulo->TooltipValue = "";

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
			if (strval($this->Dni->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Dni`" . ew_SearchString("=", $this->Dni->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni->EditValue = $this->Dni->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Dni->EditValue = NULL;
			}
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->AdvancedSearch->SearchValue);
			if (strval($this->NroSerie->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->AdvancedSearch->SearchValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Dni_Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->AdvancedSearch->SearchValue);
			if (strval($this->Dni_Tutor->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Dni_Tutor`" . ew_SearchString("=", $this->Dni_Tutor->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Dni_Tutor->EditValue = $this->Dni_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Dni_Tutor->EditValue = NULL;
			}
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// Fecha_Finalizacion
			$this->Fecha_Finalizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Finalizacion->EditCustomAttributes = "";
			$this->Fecha_Finalizacion->EditValue = ew_HtmlEncode($this->Fecha_Finalizacion->AdvancedSearch->SearchValue);
			$this->Fecha_Finalizacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Finalizacion->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Id_Modalidad
			$this->Id_Modalidad->EditAttrs["class"] = "form-control";
			$this->Id_Modalidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modalidad->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modalidad`" . ew_SearchString("=", $this->Id_Modalidad->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modalidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modalidad_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Modalidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modalidad->EditValue = $arwrk;

			// Id_Nivel
			$this->Id_Nivel->EditAttrs["class"] = "form-control";
			$this->Id_Nivel->EditCustomAttributes = "";
			if (trim(strval($this->Id_Nivel->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Nivel`" . ew_SearchString("=", $this->Id_Nivel->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Nivel->EditValue = $arwrk;

			// Id_Autoridad
			$this->Id_Autoridad->EditAttrs["class"] = "form-control";
			$this->Id_Autoridad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Autoridad->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Autoridad`" . ew_SearchString("=", $this->Id_Autoridad->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Autoridad`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Autoridad->EditValue = $arwrk;

			// Fecha_Liberacion
			$this->Fecha_Liberacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Liberacion->EditCustomAttributes = "";
			$this->Fecha_Liberacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Liberacion->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Liberacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Liberacion->FldCaption());

			// Ruta_Archivo_Copia_Titulo
			$this->Ruta_Archivo_Copia_Titulo->EditAttrs["class"] = "form-control";
			$this->Ruta_Archivo_Copia_Titulo->EditCustomAttributes = "";
			$this->Ruta_Archivo_Copia_Titulo->EditValue = ew_HtmlEncode($this->Ruta_Archivo_Copia_Titulo->AdvancedSearch->SearchValue);
			$this->Ruta_Archivo_Copia_Titulo->PlaceHolder = ew_RemoveHtml($this->Ruta_Archivo_Copia_Titulo->FldCaption());

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
		if (!ew_CheckEuroDate($this->Fecha_Finalizacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Finalizacion->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Liberacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Liberacion->FldErrMsg());
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
		$this->NroSerie->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Fecha_Finalizacion->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Id_Modalidad->AdvancedSearch->Load();
		$this->Id_Nivel->AdvancedSearch->Load();
		$this->Id_Autoridad->AdvancedSearch->Load();
		$this->Fecha_Liberacion->AdvancedSearch->Load();
		$this->Ruta_Archivo_Copia_Titulo->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("liberacion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$this->MultiPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Dni":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Dni_Tutor` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modalidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modalidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modalidad_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Modalidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modalidad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modalidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nombre` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Nivel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Nivel` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Nivel` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Autoridad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Autoridad` AS `LinkFld`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `autoridades_escolares`";
			$sWhereWrk = "";
			$this->Id_Autoridad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Autoridad` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Autoridad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Apellido_Nombre` ASC";
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
		case "x_Dni":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni`, `Apellidos_Nombres` AS `DispFld`, `Dni` AS `Disp2Fld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni) . "',`Dni`) LIKE '{query_value}%'";
			$this->Dni->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dni_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Dni_Tutor`, `Apellidos_Nombres` AS `DispFld`, `Dni_Tutor` AS `Disp2Fld` FROM `tutores`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%' OR CONCAT(`Apellidos_Nombres`,'" . ew_ValueSeparator(1, $this->Dni_Tutor) . "',`Dni_Tutor`) LIKE '{query_value}%'";
			$this->Dni_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`", "dx2" => "`Dni_Tutor`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dni_Tutor, $sWhereWrk); // Call Lookup selecting
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
if (!isset($liberacion_equipo_search)) $liberacion_equipo_search = new cliberacion_equipo_search();

// Page init
$liberacion_equipo_search->Page_Init();

// Page main
$liberacion_equipo_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$liberacion_equipo_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($liberacion_equipo_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fliberacion_equiposearch = new ew_Form("fliberacion_equiposearch", "search");
<?php } else { ?>
var CurrentForm = fliberacion_equiposearch = new ew_Form("fliberacion_equiposearch", "search");
<?php } ?>

// Form_CustomValidate event
fliberacion_equiposearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fliberacion_equiposearch.ValidateRequired = true;
<?php } else { ?>
fliberacion_equiposearch.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fliberacion_equiposearch.MultiPage = new ew_MultiPage("fliberacion_equiposearch");

// Dynamic selection lists
fliberacion_equiposearch.Lists["x_Dni"] = {"LinkField":"x_Dni","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fliberacion_equiposearch.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fliberacion_equiposearch.Lists["x_Dni_Tutor"] = {"LinkField":"x_Dni_Tutor","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","x_Dni_Tutor","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fliberacion_equiposearch.Lists["x_Id_Modalidad"] = {"LinkField":"x_Id_Modalidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modalidad_establecimiento"};
fliberacion_equiposearch.Lists["x_Id_Nivel"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fliberacion_equiposearch.Lists["x_Id_Autoridad"] = {"LinkField":"x_Id_Autoridad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"autoridades_escolares"};

// Form object for search
// Validate function for search

fliberacion_equiposearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Finalizacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Fecha_Finalizacion->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Liberacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Fecha_Liberacion->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($liberacion_equipo->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$liberacion_equipo_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $liberacion_equipo_search->ShowPageHeader(); ?>
<?php
$liberacion_equipo_search->ShowMessage();
?>
<form name="fliberacion_equiposearch" id="fliberacion_equiposearch" class="<?php echo $liberacion_equipo_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($liberacion_equipo_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $liberacion_equipo_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="liberacion_equipo">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($liberacion_equipo_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ewMultiPage">
<div class="panel-group" id="liberacion_equipo_search">
	<div class="panel panel-default<?php echo $liberacion_equipo_search->MultiPages->PageStyle("1") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_search" href="#tab_liberacion_equipo1"><?php echo $liberacion_equipo->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_search->MultiPages->PageStyle("1") ?>" id="tab_liberacion_equipo1">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Dni"><?php echo $liberacion_equipo->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Dni->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Dni">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni"><?php echo (strval($liberacion_equipo->Dni->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $liberacion_equipo->Dni->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($liberacion_equipo->Dni->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="liberacion_equipo" data-field="x_Dni" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $liberacion_equipo->Dni->DisplayValueSeparatorAttribute() ?>" name="x_Dni" id="x_Dni" value="<?php echo $liberacion_equipo->Dni->AdvancedSearch->SearchValue ?>"<?php echo $liberacion_equipo->Dni->EditAttributes() ?>>
<input type="hidden" name="s_x_Dni" id="s_x_Dni" value="<?php echo $liberacion_equipo->Dni->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_NroSerie"><?php echo $liberacion_equipo->NroSerie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroSerie" id="z_NroSerie" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->NroSerie->CellAttributes() ?>>
			<span id="el_liberacion_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($liberacion_equipo->NroSerie->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $liberacion_equipo->NroSerie->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($liberacion_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="liberacion_equipo" data-field="x_NroSerie" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $liberacion_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $liberacion_equipo->NroSerie->AdvancedSearch->SearchValue ?>"<?php echo $liberacion_equipo->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $liberacion_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Dni_Tutor"><?php echo $liberacion_equipo->Dni_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni_Tutor" id="z_Dni_Tutor" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Dni_Tutor->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Dni_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Dni_Tutor"><?php echo (strval($liberacion_equipo->Dni_Tutor->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $liberacion_equipo->Dni_Tutor->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($liberacion_equipo->Dni_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Dni_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="liberacion_equipo" data-field="x_Dni_Tutor" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $liberacion_equipo->Dni_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Dni_Tutor" id="x_Dni_Tutor" value="<?php echo $liberacion_equipo->Dni_Tutor->AdvancedSearch->SearchValue ?>"<?php echo $liberacion_equipo->Dni_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x_Dni_Tutor" id="s_x_Dni_Tutor" value="<?php echo $liberacion_equipo->Dni_Tutor->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Autoridad->Visible) { // Id_Autoridad ?>
	<div id="r_Id_Autoridad" class="form-group">
		<label for="x_Id_Autoridad" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Id_Autoridad"><?php echo $liberacion_equipo->Id_Autoridad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Autoridad" id="z_Id_Autoridad" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Id_Autoridad->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Id_Autoridad">
<select data-table="liberacion_equipo" data-field="x_Id_Autoridad" data-page="1" data-value-separator="<?php echo $liberacion_equipo->Id_Autoridad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Autoridad" name="x_Id_Autoridad"<?php echo $liberacion_equipo->Id_Autoridad->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Autoridad->SelectOptionListHtml("x_Id_Autoridad") ?>
</select>
<input type="hidden" name="s_x_Id_Autoridad" id="s_x_Id_Autoridad" value="<?php echo $liberacion_equipo->Id_Autoridad->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Fecha_Liberacion->Visible) { // Fecha_Liberacion ?>
	<div id="r_Fecha_Liberacion" class="form-group">
		<label for="x_Fecha_Liberacion" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Fecha_Liberacion"><?php echo $liberacion_equipo->Fecha_Liberacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Liberacion" id="z_Fecha_Liberacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Fecha_Liberacion->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Fecha_Liberacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Fecha_Liberacion" data-page="1" data-format="7" name="x_Fecha_Liberacion" id="x_Fecha_Liberacion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Fecha_Liberacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Fecha_Liberacion->EditValue ?>"<?php echo $liberacion_equipo->Fecha_Liberacion->EditAttributes() ?>>
<?php if (!$liberacion_equipo->Fecha_Liberacion->ReadOnly && !$liberacion_equipo->Fecha_Liberacion->Disabled && !isset($liberacion_equipo->Fecha_Liberacion->EditAttrs["readonly"]) && !isset($liberacion_equipo->Fecha_Liberacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fliberacion_equiposearch", "x_Fecha_Liberacion", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Fecha_Actualizacion"><?php echo $liberacion_equipo->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Fecha_Actualizacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Fecha_Actualizacion" data-page="1" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Fecha_Actualizacion->EditValue ?>"<?php echo $liberacion_equipo->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Usuario"><?php echo $liberacion_equipo->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Usuario->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Usuario">
<input type="text" data-table="liberacion_equipo" data-field="x_Usuario" data-page="1" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Usuario->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Usuario->EditValue ?>"<?php echo $liberacion_equipo->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $liberacion_equipo_search->MultiPages->PageStyle("2") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_search" href="#tab_liberacion_equipo2"><?php echo $liberacion_equipo->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_search->MultiPages->PageStyle("2") ?>" id="tab_liberacion_equipo2">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Fecha_Finalizacion->Visible) { // Fecha_Finalizacion ?>
	<div id="r_Fecha_Finalizacion" class="form-group">
		<label for="x_Fecha_Finalizacion" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Fecha_Finalizacion"><?php echo $liberacion_equipo->Fecha_Finalizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Finalizacion" id="z_Fecha_Finalizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Fecha_Finalizacion->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Fecha_Finalizacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Fecha_Finalizacion" data-page="2" name="x_Fecha_Finalizacion" id="x_Fecha_Finalizacion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Fecha_Finalizacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Fecha_Finalizacion->EditValue ?>"<?php echo $liberacion_equipo->Fecha_Finalizacion->EditAttributes() ?>>
<?php if (!$liberacion_equipo->Fecha_Finalizacion->ReadOnly && !$liberacion_equipo->Fecha_Finalizacion->Disabled && !isset($liberacion_equipo->Fecha_Finalizacion->EditAttrs["readonly"]) && !isset($liberacion_equipo->Fecha_Finalizacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fliberacion_equiposearch", "x_Fecha_Finalizacion", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Observacion"><?php echo $liberacion_equipo->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Observacion->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Observacion">
<input type="text" data-table="liberacion_equipo" data-field="x_Observacion" data-page="2" name="x_Observacion" id="x_Observacion" size="35" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Observacion->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Observacion->EditValue ?>"<?php echo $liberacion_equipo->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Modalidad->Visible) { // Id_Modalidad ?>
	<div id="r_Id_Modalidad" class="form-group">
		<label for="x_Id_Modalidad" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Id_Modalidad"><?php echo $liberacion_equipo->Id_Modalidad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Modalidad" id="z_Id_Modalidad" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Id_Modalidad->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Id_Modalidad">
<select data-table="liberacion_equipo" data-field="x_Id_Modalidad" data-page="2" data-value-separator="<?php echo $liberacion_equipo->Id_Modalidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modalidad" name="x_Id_Modalidad"<?php echo $liberacion_equipo->Id_Modalidad->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Modalidad->SelectOptionListHtml("x_Id_Modalidad") ?>
</select>
<input type="hidden" name="s_x_Id_Modalidad" id="s_x_Id_Modalidad" value="<?php echo $liberacion_equipo->Id_Modalidad->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($liberacion_equipo->Id_Nivel->Visible) { // Id_Nivel ?>
	<div id="r_Id_Nivel" class="form-group">
		<label for="x_Id_Nivel" class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Id_Nivel"><?php echo $liberacion_equipo->Id_Nivel->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Nivel" id="z_Id_Nivel" value="="></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Id_Nivel->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Id_Nivel">
<select data-table="liberacion_equipo" data-field="x_Id_Nivel" data-page="2" data-value-separator="<?php echo $liberacion_equipo->Id_Nivel->DisplayValueSeparatorAttribute() ?>" id="x_Id_Nivel" name="x_Id_Nivel"<?php echo $liberacion_equipo->Id_Nivel->EditAttributes() ?>>
<?php echo $liberacion_equipo->Id_Nivel->SelectOptionListHtml("x_Id_Nivel") ?>
</select>
<input type="hidden" name="s_x_Id_Nivel" id="s_x_Id_Nivel" value="<?php echo $liberacion_equipo->Id_Nivel->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default<?php echo $liberacion_equipo_search->MultiPages->PageStyle("3") ?>">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel-toggle" data-toggle="collapse" data-parent="#liberacion_equipo_search" href="#tab_liberacion_equipo3"><?php echo $liberacion_equipo->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $liberacion_equipo_search->MultiPages->PageStyle("3") ?>" id="tab_liberacion_equipo3">
			<div class="panel-body">
<div>
<?php if ($liberacion_equipo->Ruta_Archivo_Copia_Titulo->Visible) { // Ruta_Archivo_Copia_Titulo ?>
	<div id="r_Ruta_Archivo_Copia_Titulo" class="form-group">
		<label class="<?php echo $liberacion_equipo_search->SearchLabelClass ?>"><span id="elh_liberacion_equipo_Ruta_Archivo_Copia_Titulo"><?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Ruta_Archivo_Copia_Titulo" id="z_Ruta_Archivo_Copia_Titulo" value="LIKE"></p>
		</label>
		<div class="<?php echo $liberacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->CellAttributes() ?>>
			<span id="el_liberacion_equipo_Ruta_Archivo_Copia_Titulo">
<input type="text" data-table="liberacion_equipo" data-field="x_Ruta_Archivo_Copia_Titulo" data-page="3" name="x_Ruta_Archivo_Copia_Titulo" id="x_Ruta_Archivo_Copia_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($liberacion_equipo->Ruta_Archivo_Copia_Titulo->getPlaceHolder()) ?>" value="<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->EditValue ?>"<?php echo $liberacion_equipo->Ruta_Archivo_Copia_Titulo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if (!$liberacion_equipo_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fliberacion_equiposearch.Init();
</script>
<?php
$liberacion_equipo_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$liberacion_equipo_search->Page_Terminate();
?>
