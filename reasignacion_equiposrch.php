<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "reasignacion_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$reasignacion_equipo_search = NULL; // Initialize page object first

class creasignacion_equipo_search extends creasignacion_equipo {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'reasignacion_equipo';

	// Page object name
	var $PageObjName = 'reasignacion_equipo_search';

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

		// Table object (reasignacion_equipo)
		if (!isset($GLOBALS["reasignacion_equipo"]) || get_class($GLOBALS["reasignacion_equipo"]) == "creasignacion_equipo") {
			$GLOBALS["reasignacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reasignacion_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reasignacion_equipo', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("reasignacion_equipolist.php"));
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
		$this->Id_Reasignacion->SetVisibility();
		$this->Id_Reasignacion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Titular_Original->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Nuevo_Titular->SetVisibility();
		$this->Dni_Nuevo_Tit->SetVisibility();
		$this->Id_Motivo_Reasig->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Reasignacion->SetVisibility();
		$this->Usuario->SetVisibility();
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
		global $EW_EXPORT, $reasignacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($reasignacion_equipo);
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
						$sSrchStr = "reasignacion_equipolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Reasignacion); // Id_Reasignacion
		$this->BuildSearchUrl($sSrchUrl, $this->Titular_Original); // Titular_Original
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->NroSerie); // NroSerie
		$this->BuildSearchUrl($sSrchUrl, $this->Nuevo_Titular); // Nuevo_Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni_Nuevo_Tit); // Dni_Nuevo_Tit
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Motivo_Reasig); // Id_Motivo_Reasig
		$this->BuildSearchUrl($sSrchUrl, $this->Observacion); // Observacion
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Reasignacion); // Fecha_Reasignacion
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario); // Usuario
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
		// Id_Reasignacion

		$this->Id_Reasignacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Reasignacion"));
		$this->Id_Reasignacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Reasignacion");

		// Titular_Original
		$this->Titular_Original->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Titular_Original"));
		$this->Titular_Original->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Titular_Original");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroSerie"));
		$this->NroSerie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroSerie");

		// Nuevo_Titular
		$this->Nuevo_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nuevo_Titular"));
		$this->Nuevo_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nuevo_Titular");

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni_Nuevo_Tit"));
		$this->Dni_Nuevo_Tit->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni_Nuevo_Tit");

		// Id_Motivo_Reasig
		$this->Id_Motivo_Reasig->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Motivo_Reasig"));
		$this->Id_Motivo_Reasig->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Motivo_Reasig");

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observacion"));
		$this->Observacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observacion");

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Reasignacion"));
		$this->Fecha_Reasignacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Reasignacion");

		// Usuario
		$this->Usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario"));
		$this->Usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario");

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
		// Id_Reasignacion
		// Titular_Original
		// Dni
		// NroSerie
		// Nuevo_Titular
		// Dni_Nuevo_Tit
		// Id_Motivo_Reasig
		// Observacion
		// Fecha_Reasignacion
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Reasignacion
		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Titular_Original
		$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
		if (strval($this->Titular_Original->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Titular_Original->ViewValue = $this->Titular_Original->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
			}
		} else {
			$this->Titular_Original->ViewValue = NULL;
		}
		$this->Titular_Original->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
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

		// Nuevo_Titular
		$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
		if (strval($this->Nuevo_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`NroSerie`='0'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
			}
		} else {
			$this->Nuevo_Titular->ViewValue = NULL;
		}
		$this->Nuevo_Titular->ViewCustomAttributes = "";

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->ViewValue = $this->Dni_Nuevo_Tit->CurrentValue;
		$this->Dni_Nuevo_Tit->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		if (strval($this->Id_Motivo_Reasig->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
		$sWhereWrk = "";
		$this->Id_Motivo_Reasig->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Reasig->ViewValue = NULL;
		}
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewValue = ew_FormatDateTime($this->Fecha_Reasignacion->ViewValue, 7);
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Id_Reasignacion
			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";
			$this->Id_Reasignacion->TooltipValue = "";

			// Titular_Original
			$this->Titular_Original->LinkCustomAttributes = "";
			$this->Titular_Original->HrefValue = "";
			$this->Titular_Original->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Nuevo_Titular
			$this->Nuevo_Titular->LinkCustomAttributes = "";
			$this->Nuevo_Titular->HrefValue = "";
			$this->Nuevo_Titular->TooltipValue = "";

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->LinkCustomAttributes = "";
			$this->Dni_Nuevo_Tit->HrefValue = "";
			$this->Dni_Nuevo_Tit->TooltipValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
			$this->Id_Motivo_Reasig->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";
			$this->Fecha_Reasignacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Reasignacion
			$this->Id_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Id_Reasignacion->EditCustomAttributes = "";
			$this->Id_Reasignacion->EditValue = ew_HtmlEncode($this->Id_Reasignacion->AdvancedSearch->SearchValue);
			$this->Id_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Id_Reasignacion->FldCaption());

			// Titular_Original
			$this->Titular_Original->EditAttrs["class"] = "form-control";
			$this->Titular_Original->EditCustomAttributes = "";
			$this->Titular_Original->EditValue = ew_HtmlEncode($this->Titular_Original->AdvancedSearch->SearchValue);
			if (strval($this->Titular_Original->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->AdvancedSearch->SearchValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Titular_Original->EditValue = $this->Titular_Original->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Titular_Original->EditValue = ew_HtmlEncode($this->Titular_Original->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Titular_Original->EditValue = NULL;
			}
			$this->Titular_Original->PlaceHolder = ew_RemoveHtml($this->Titular_Original->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
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

			// Nuevo_Titular
			$this->Nuevo_Titular->EditAttrs["class"] = "form-control";
			$this->Nuevo_Titular->EditCustomAttributes = "";
			$this->Nuevo_Titular->EditValue = ew_HtmlEncode($this->Nuevo_Titular->AdvancedSearch->SearchValue);
			if (strval($this->Nuevo_Titular->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->AdvancedSearch->SearchValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Nuevo_Titular->EditValue = $this->Nuevo_Titular->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Nuevo_Titular->EditValue = ew_HtmlEncode($this->Nuevo_Titular->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Nuevo_Titular->EditValue = NULL;
			}
			$this->Nuevo_Titular->PlaceHolder = ew_RemoveHtml($this->Nuevo_Titular->FldCaption());

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->EditAttrs["class"] = "form-control";
			$this->Dni_Nuevo_Tit->EditCustomAttributes = "";
			$this->Dni_Nuevo_Tit->EditValue = ew_HtmlEncode($this->Dni_Nuevo_Tit->AdvancedSearch->SearchValue);
			$this->Dni_Nuevo_Tit->PlaceHolder = ew_RemoveHtml($this->Dni_Nuevo_Tit->FldCaption());

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Reasig->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo_Reasig->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_reasignacion`";
			$sWhereWrk = "";
			$this->Id_Motivo_Reasig->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo_Reasig->EditValue = $arwrk;

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->AdvancedSearch->SearchValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Reasignacion->EditCustomAttributes = "";
			$this->Fecha_Reasignacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Reasignacion->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Reasignacion->FldCaption());

			// Usuario
			$this->Usuario->EditAttrs["class"] = "form-control";
			$this->Usuario->EditCustomAttributes = "";
			$this->Usuario->EditValue = ew_HtmlEncode($this->Usuario->AdvancedSearch->SearchValue);
			$this->Usuario->PlaceHolder = ew_RemoveHtml($this->Usuario->FldCaption());

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Actualizacion->EditCustomAttributes = "";
			$this->Fecha_Actualizacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Actualizacion->AdvancedSearch->SearchValue, 0), 8));
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
		if (!ew_CheckInteger($this->Dni->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Dni_Nuevo_Tit->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni_Nuevo_Tit->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Reasignacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Reasignacion->FldErrMsg());
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
		$this->Id_Reasignacion->AdvancedSearch->Load();
		$this->Titular_Original->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Nuevo_Titular->AdvancedSearch->Load();
		$this->Dni_Nuevo_Tit->AdvancedSearch->Load();
		$this->Id_Motivo_Reasig->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Fecha_Reasignacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reasignacion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Titular_Original":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
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
		case "x_Nuevo_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo_Reasig":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo_Reasig` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
			$sWhereWrk = "";
			$this->Id_Motivo_Reasig->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo_Reasig` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
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
		case "x_Titular_Original":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
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
		case "x_Nuevo_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
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
if (!isset($reasignacion_equipo_search)) $reasignacion_equipo_search = new creasignacion_equipo_search();

// Page init
$reasignacion_equipo_search->Page_Init();

// Page main
$reasignacion_equipo_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reasignacion_equipo_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($reasignacion_equipo_search->IsModal) { ?>
var CurrentAdvancedSearchForm = freasignacion_equiposearch = new ew_Form("freasignacion_equiposearch", "search");
<?php } else { ?>
var CurrentForm = freasignacion_equiposearch = new ew_Form("freasignacion_equiposearch", "search");
<?php } ?>

// Form_CustomValidate event
freasignacion_equiposearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freasignacion_equiposearch.ValidateRequired = true;
<?php } else { ?>
freasignacion_equiposearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freasignacion_equiposearch.Lists["x_Titular_Original"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equiposearch.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
freasignacion_equiposearch.Lists["x_Nuevo_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equiposearch.Lists["x_Id_Motivo_Reasig"] = {"LinkField":"x_Id_Motivo_Reasig","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_reasignacion"};

// Form object for search
// Validate function for search

freasignacion_equiposearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Dni_Nuevo_Tit");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni_Nuevo_Tit->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Reasignacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Fecha_Reasignacion->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$reasignacion_equipo_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reasignacion_equipo_search->ShowPageHeader(); ?>
<?php
$reasignacion_equipo_search->ShowMessage();
?>
<form name="freasignacion_equiposearch" id="freasignacion_equiposearch" class="<?php echo $reasignacion_equipo_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($reasignacion_equipo_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $reasignacion_equipo_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reasignacion_equipo">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($reasignacion_equipo_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($reasignacion_equipo->Id_Reasignacion->Visible) { // Id_Reasignacion ?>
	<div id="r_Id_Reasignacion" class="form-group">
		<label for="x_Id_Reasignacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Id_Reasignacion"><?php echo $reasignacion_equipo->Id_Reasignacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Reasignacion" id="z_Id_Reasignacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Id_Reasignacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Id_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Id_Reasignacion" name="x_Id_Reasignacion" id="x_Id_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Id_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Id_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Id_Reasignacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Titular_Original->Visible) { // Titular_Original ?>
	<div id="r_Titular_Original" class="form-group">
		<label class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Titular_Original"><?php echo $reasignacion_equipo->Titular_Original->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Titular_Original" id="z_Titular_Original" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Titular_Original->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Titular_Original">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Titular_Original"><?php echo (strval($reasignacion_equipo->Titular_Original->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->Titular_Original->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->Titular_Original->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Titular_Original',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_Titular_Original" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->Titular_Original->DisplayValueSeparatorAttribute() ?>" name="x_Titular_Original" id="x_Titular_Original" value="<?php echo $reasignacion_equipo->Titular_Original->AdvancedSearch->SearchValue ?>"<?php echo $reasignacion_equipo->Titular_Original->EditAttributes() ?>>
<input type="hidden" name="s_x_Titular_Original" id="s_x_Titular_Original" value="<?php echo $reasignacion_equipo->Titular_Original->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Dni"><?php echo $reasignacion_equipo->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Dni->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Dni">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni->EditValue ?>"<?php echo $reasignacion_equipo->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_NroSerie"><?php echo $reasignacion_equipo->NroSerie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroSerie" id="z_NroSerie" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->NroSerie->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($reasignacion_equipo->NroSerie->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->NroSerie->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $reasignacion_equipo->NroSerie->AdvancedSearch->SearchValue ?>"<?php echo $reasignacion_equipo->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $reasignacion_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Nuevo_Titular->Visible) { // Nuevo_Titular ?>
	<div id="r_Nuevo_Titular" class="form-group">
		<label class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Nuevo_Titular"><?php echo $reasignacion_equipo->Nuevo_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nuevo_Titular" id="z_Nuevo_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Nuevo_Titular->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Nuevo_Titular">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Nuevo_Titular"><?php echo (strval($reasignacion_equipo->Nuevo_Titular->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->Nuevo_Titular->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->Nuevo_Titular->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Nuevo_Titular',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_Nuevo_Titular" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->Nuevo_Titular->DisplayValueSeparatorAttribute() ?>" name="x_Nuevo_Titular" id="x_Nuevo_Titular" value="<?php echo $reasignacion_equipo->Nuevo_Titular->AdvancedSearch->SearchValue ?>"<?php echo $reasignacion_equipo->Nuevo_Titular->EditAttributes() ?>>
<input type="hidden" name="s_x_Nuevo_Titular" id="s_x_Nuevo_Titular" value="<?php echo $reasignacion_equipo->Nuevo_Titular->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni_Nuevo_Tit->Visible) { // Dni_Nuevo_Tit ?>
	<div id="r_Dni_Nuevo_Tit" class="form-group">
		<label for="x_Dni_Nuevo_Tit" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Dni_Nuevo_Tit"><?php echo $reasignacion_equipo->Dni_Nuevo_Tit->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni_Nuevo_Tit" id="z_Dni_Nuevo_Tit" value="="></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Dni_Nuevo_Tit">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni_Nuevo_Tit" name="x_Dni_Nuevo_Tit" id="x_Dni_Nuevo_Tit" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni_Nuevo_Tit->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->EditValue ?>"<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Id_Motivo_Reasig->Visible) { // Id_Motivo_Reasig ?>
	<div id="r_Id_Motivo_Reasig" class="form-group">
		<label for="x_Id_Motivo_Reasig" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Id_Motivo_Reasig"><?php echo $reasignacion_equipo->Id_Motivo_Reasig->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Motivo_Reasig" id="z_Id_Motivo_Reasig" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Id_Motivo_Reasig">
<select data-table="reasignacion_equipo" data-field="x_Id_Motivo_Reasig" data-value-separator="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo_Reasig" name="x_Id_Motivo_Reasig"<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditAttributes() ?>>
<?php echo $reasignacion_equipo->Id_Motivo_Reasig->SelectOptionListHtml("x_Id_Motivo_Reasig") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo_Reasig" id="s_x_Id_Motivo_Reasig" value="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Observacion"><?php echo $reasignacion_equipo->Observacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observacion" id="z_Observacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Observacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Observacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" size="35" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Observacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Observacion->EditValue ?>"<?php echo $reasignacion_equipo->Observacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Reasignacion->Visible) { // Fecha_Reasignacion ?>
	<div id="r_Fecha_Reasignacion" class="form-group">
		<label for="x_Fecha_Reasignacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Fecha_Reasignacion"><?php echo $reasignacion_equipo->Fecha_Reasignacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Reasignacion" id="z_Fecha_Reasignacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Fecha_Reasignacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Fecha_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Fecha_Reasignacion" data-format="7" name="x_Fecha_Reasignacion" id="x_Fecha_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Fecha_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditAttributes() ?>>
<?php if (!$reasignacion_equipo->Fecha_Reasignacion->ReadOnly && !$reasignacion_equipo->Fecha_Reasignacion->Disabled && !isset($reasignacion_equipo->Fecha_Reasignacion->EditAttrs["readonly"]) && !isset($reasignacion_equipo->Fecha_Reasignacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freasignacion_equiposearch", "x_Fecha_Reasignacion", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Usuario"><?php echo $reasignacion_equipo->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Usuario->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Usuario">
<input type="text" data-table="reasignacion_equipo" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Usuario->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Usuario->EditValue ?>"<?php echo $reasignacion_equipo->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $reasignacion_equipo_search->SearchLabelClass ?>"><span id="elh_reasignacion_equipo_Fecha_Actualizacion"><?php echo $reasignacion_equipo->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $reasignacion_equipo_search->SearchRightColumnClass ?>"><div<?php echo $reasignacion_equipo->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_reasignacion_equipo_Fecha_Actualizacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Fecha_Actualizacion" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Fecha_Actualizacion->EditValue ?>"<?php echo $reasignacion_equipo->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$reasignacion_equipo_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freasignacion_equiposearch.Init();
</script>
<?php
$reasignacion_equipo_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$reasignacion_equipo_search->Page_Terminate();
?>
