<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "estado_equipos_porcursoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$estado_equipos_porcurso_search = NULL; // Initialize page object first

class cestado_equipos_porcurso_search extends cestado_equipos_porcurso {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'estado_equipos_porcurso';

	// Page object name
	var $PageObjName = 'estado_equipos_porcurso_search';

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

		// Table object (estado_equipos_porcurso)
		if (!isset($GLOBALS["estado_equipos_porcurso"]) || get_class($GLOBALS["estado_equipos_porcurso"]) == "cestado_equipos_porcurso") {
			$GLOBALS["estado_equipos_porcurso"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_equipos_porcurso"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_equipos_porcurso', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("estado_equipos_porcursolist.php"));
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
		$this->Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->curso->SetVisibility();
		$this->division->SetVisibility();
		$this->turno->SetVisibility();
		$this->Equipo->SetVisibility();
		$this->Estado->SetVisibility();
		$this->ultima_actualiz_->SetVisibility();

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
		global $EW_EXPORT, $estado_equipos_porcurso;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_equipos_porcurso);
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
						$sSrchStr = "estado_equipos_porcursolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Titular); // Nombre Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->curso); // curso
		$this->BuildSearchUrl($sSrchUrl, $this->division); // division
		$this->BuildSearchUrl($sSrchUrl, $this->turno); // turno
		$this->BuildSearchUrl($sSrchUrl, $this->Equipo); // Equipo
		$this->BuildSearchUrl($sSrchUrl, $this->Estado); // Estado
		$this->BuildSearchUrl($sSrchUrl, $this->ultima_actualiz_); // ultima actualiz.
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
		// Nombre Titular

		$this->Nombre_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Titular"));
		$this->Nombre_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Titular");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// curso
		$this->curso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_curso"));
		$this->curso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_curso");

		// division
		$this->division->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_division"));
		$this->division->AdvancedSearch->SearchOperator = $objForm->GetValue("z_division");

		// turno
		$this->turno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_turno"));
		$this->turno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_turno");

		// Equipo
		$this->Equipo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Equipo"));
		$this->Equipo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Equipo");

		// Estado
		$this->Estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Estado"));
		$this->Estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Estado");

		// ultima actualiz.
		$this->ultima_actualiz_->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_ultima_actualiz_"));
		$this->ultima_actualiz_->AdvancedSearch->SearchOperator = $objForm->GetValue("z_ultima_actualiz_");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Nombre Titular
		// Dni
		// curso
		// division
		// turno
		// Equipo
		// Estado
		// ultima actualiz.

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nombre Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// curso
		if (strval($this->curso->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->curso->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->curso->ViewValue = $this->curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->curso->ViewValue = $this->curso->CurrentValue;
			}
		} else {
			$this->curso->ViewValue = NULL;
		}
		$this->curso->ViewCustomAttributes = "";

		// division
		if (strval($this->division->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->division->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->division->ViewValue = $this->division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->division->ViewValue = $this->division->CurrentValue;
			}
		} else {
			$this->division->ViewValue = NULL;
		}
		$this->division->ViewCustomAttributes = "";

		// turno
		if (strval($this->turno->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->turno->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->turno->ViewValue = $this->turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->turno->ViewValue = $this->turno->CurrentValue;
			}
		} else {
			$this->turno->ViewValue = NULL;
		}
		$this->turno->ViewCustomAttributes = "";

		// Equipo
		$this->Equipo->ViewValue = $this->Equipo->CurrentValue;
		$this->Equipo->ViewCustomAttributes = "";

		// Estado
		if (strval($this->Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Estado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
		$sWhereWrk = "";
		$this->Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado->ViewValue = $this->Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado->ViewValue = $this->Estado->CurrentValue;
			}
		} else {
			$this->Estado->ViewValue = NULL;
		}
		$this->Estado->ViewCustomAttributes = "";

		// ultima actualiz.
		$this->ultima_actualiz_->ViewValue = $this->ultima_actualiz_->CurrentValue;
		$this->ultima_actualiz_->ViewCustomAttributes = "";

			// Nombre Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// curso
			$this->curso->LinkCustomAttributes = "";
			$this->curso->HrefValue = "";
			$this->curso->TooltipValue = "";

			// division
			$this->division->LinkCustomAttributes = "";
			$this->division->HrefValue = "";
			$this->division->TooltipValue = "";

			// turno
			$this->turno->LinkCustomAttributes = "";
			$this->turno->HrefValue = "";
			$this->turno->TooltipValue = "";

			// Equipo
			$this->Equipo->LinkCustomAttributes = "";
			$this->Equipo->HrefValue = "";
			$this->Equipo->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";

			// ultima actualiz.
			$this->ultima_actualiz_->LinkCustomAttributes = "";
			$this->ultima_actualiz_->HrefValue = "";
			$this->ultima_actualiz_->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Nombre Titular
			$this->Nombre_Titular->EditAttrs["class"] = "form-control";
			$this->Nombre_Titular->EditCustomAttributes = "";
			$this->Nombre_Titular->EditValue = ew_HtmlEncode($this->Nombre_Titular->AdvancedSearch->SearchValue);
			$this->Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Nombre_Titular->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// curso
			$this->curso->EditAttrs["class"] = "form-control";
			$this->curso->EditCustomAttributes = "";
			if (trim(strval($this->curso->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->curso->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->curso->EditValue = $arwrk;

			// division
			$this->division->EditAttrs["class"] = "form-control";
			$this->division->EditCustomAttributes = "";
			if (trim(strval($this->division->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->division->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->division->EditValue = $arwrk;

			// turno
			$this->turno->EditAttrs["class"] = "form-control";
			$this->turno->EditCustomAttributes = "";
			if (trim(strval($this->turno->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->turno->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->turno->EditValue = $arwrk;

			// Equipo
			$this->Equipo->EditAttrs["class"] = "form-control";
			$this->Equipo->EditCustomAttributes = "";
			$this->Equipo->EditValue = ew_HtmlEncode($this->Equipo->AdvancedSearch->SearchValue);
			$this->Equipo->PlaceHolder = ew_RemoveHtml($this->Equipo->FldCaption());

			// Estado
			$this->Estado->EditAttrs["class"] = "form-control";
			$this->Estado->EditCustomAttributes = "";
			if (trim(strval($this->Estado->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Estado->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado->EditValue = $arwrk;

			// ultima actualiz.
			$this->ultima_actualiz_->EditAttrs["class"] = "form-control";
			$this->ultima_actualiz_->EditCustomAttributes = "";
			$this->ultima_actualiz_->EditValue = ew_HtmlEncode($this->ultima_actualiz_->AdvancedSearch->SearchValue);
			$this->ultima_actualiz_->PlaceHolder = ew_RemoveHtml($this->ultima_actualiz_->FldCaption());
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
		$this->Nombre_Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->curso->AdvancedSearch->Load();
		$this->division->AdvancedSearch->Load();
		$this->turno->AdvancedSearch->Load();
		$this->Equipo->AdvancedSearch->Load();
		$this->Estado->AdvancedSearch->Load();
		$this->ultima_actualiz_->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_equipos_porcursolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
			$sWhereWrk = "";
			$this->turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `situacion_estado`";
			$sWhereWrk = "";
			$this->Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado, $sWhereWrk); // Call Lookup selecting
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
if (!isset($estado_equipos_porcurso_search)) $estado_equipos_porcurso_search = new cestado_equipos_porcurso_search();

// Page init
$estado_equipos_porcurso_search->Page_Init();

// Page main
$estado_equipos_porcurso_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_equipos_porcurso_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($estado_equipos_porcurso_search->IsModal) { ?>
var CurrentAdvancedSearchForm = festado_equipos_porcursosearch = new ew_Form("festado_equipos_porcursosearch", "search");
<?php } else { ?>
var CurrentForm = festado_equipos_porcursosearch = new ew_Form("festado_equipos_porcursosearch", "search");
<?php } ?>

// Form_CustomValidate event
festado_equipos_porcursosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_equipos_porcursosearch.ValidateRequired = true;
<?php } else { ?>
festado_equipos_porcursosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_equipos_porcursosearch.Lists["x_curso"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
festado_equipos_porcursosearch.Lists["x_division"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
festado_equipos_porcursosearch.Lists["x_turno"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
festado_equipos_porcursosearch.Lists["x_Estado"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};

// Form object for search
// Validate function for search

festado_equipos_porcursosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($estado_equipos_porcurso->Dni->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$estado_equipos_porcurso_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estado_equipos_porcurso_search->ShowPageHeader(); ?>
<?php
$estado_equipos_porcurso_search->ShowMessage();
?>
<form name="festado_equipos_porcursosearch" id="festado_equipos_porcursosearch" class="<?php echo $estado_equipos_porcurso_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_equipos_porcurso_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_equipos_porcurso_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_equipos_porcurso">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($estado_equipos_porcurso_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($estado_equipos_porcurso->Nombre_Titular->Visible) { // Nombre Titular ?>
	<div id="r_Nombre_Titular" class="form-group">
		<label for="x_Nombre_Titular" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_Nombre_Titular"><?php echo $estado_equipos_porcurso->Nombre_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Titular" id="z_Nombre_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->Nombre_Titular->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_Nombre_Titular">
<input type="text" data-table="estado_equipos_porcurso" data-field="x_Nombre_Titular" name="x_Nombre_Titular" id="x_Nombre_Titular" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($estado_equipos_porcurso->Nombre_Titular->getPlaceHolder()) ?>" value="<?php echo $estado_equipos_porcurso->Nombre_Titular->EditValue ?>"<?php echo $estado_equipos_porcurso->Nombre_Titular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_Dni"><?php echo $estado_equipos_porcurso->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->Dni->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_Dni">
<input type="text" data-table="estado_equipos_porcurso" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($estado_equipos_porcurso->Dni->getPlaceHolder()) ?>" value="<?php echo $estado_equipos_porcurso->Dni->EditValue ?>"<?php echo $estado_equipos_porcurso->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->curso->Visible) { // curso ?>
	<div id="r_curso" class="form-group">
		<label for="x_curso" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_curso"><?php echo $estado_equipos_porcurso->curso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_curso" id="z_curso" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->curso->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_curso">
<select data-table="estado_equipos_porcurso" data-field="x_curso" data-value-separator="<?php echo $estado_equipos_porcurso->curso->DisplayValueSeparatorAttribute() ?>" id="x_curso" name="x_curso"<?php echo $estado_equipos_porcurso->curso->EditAttributes() ?>>
<?php echo $estado_equipos_porcurso->curso->SelectOptionListHtml("x_curso") ?>
</select>
<input type="hidden" name="s_x_curso" id="s_x_curso" value="<?php echo $estado_equipos_porcurso->curso->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->division->Visible) { // division ?>
	<div id="r_division" class="form-group">
		<label for="x_division" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_division"><?php echo $estado_equipos_porcurso->division->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_division" id="z_division" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->division->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_division">
<select data-table="estado_equipos_porcurso" data-field="x_division" data-value-separator="<?php echo $estado_equipos_porcurso->division->DisplayValueSeparatorAttribute() ?>" id="x_division" name="x_division"<?php echo $estado_equipos_porcurso->division->EditAttributes() ?>>
<?php echo $estado_equipos_porcurso->division->SelectOptionListHtml("x_division") ?>
</select>
<input type="hidden" name="s_x_division" id="s_x_division" value="<?php echo $estado_equipos_porcurso->division->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->turno->Visible) { // turno ?>
	<div id="r_turno" class="form-group">
		<label for="x_turno" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_turno"><?php echo $estado_equipos_porcurso->turno->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_turno" id="z_turno" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->turno->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_turno">
<select data-table="estado_equipos_porcurso" data-field="x_turno" data-value-separator="<?php echo $estado_equipos_porcurso->turno->DisplayValueSeparatorAttribute() ?>" id="x_turno" name="x_turno"<?php echo $estado_equipos_porcurso->turno->EditAttributes() ?>>
<?php echo $estado_equipos_porcurso->turno->SelectOptionListHtml("x_turno") ?>
</select>
<input type="hidden" name="s_x_turno" id="s_x_turno" value="<?php echo $estado_equipos_porcurso->turno->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->Equipo->Visible) { // Equipo ?>
	<div id="r_Equipo" class="form-group">
		<label for="x_Equipo" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_Equipo"><?php echo $estado_equipos_porcurso->Equipo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Equipo" id="z_Equipo" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->Equipo->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_Equipo">
<input type="text" data-table="estado_equipos_porcurso" data-field="x_Equipo" name="x_Equipo" id="x_Equipo" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($estado_equipos_porcurso->Equipo->getPlaceHolder()) ?>" value="<?php echo $estado_equipos_porcurso->Equipo->EditValue ?>"<?php echo $estado_equipos_porcurso->Equipo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->Estado->Visible) { // Estado ?>
	<div id="r_Estado" class="form-group">
		<label for="x_Estado" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_Estado"><?php echo $estado_equipos_porcurso->Estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Estado" id="z_Estado" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->Estado->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_Estado">
<select data-table="estado_equipos_porcurso" data-field="x_Estado" data-value-separator="<?php echo $estado_equipos_porcurso->Estado->DisplayValueSeparatorAttribute() ?>" id="x_Estado" name="x_Estado"<?php echo $estado_equipos_porcurso->Estado->EditAttributes() ?>>
<?php echo $estado_equipos_porcurso->Estado->SelectOptionListHtml("x_Estado") ?>
</select>
<input type="hidden" name="s_x_Estado" id="s_x_Estado" value="<?php echo $estado_equipos_porcurso->Estado->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_equipos_porcurso->ultima_actualiz_->Visible) { // ultima actualiz. ?>
	<div id="r_ultima_actualiz_" class="form-group">
		<label for="x_ultima_actualiz_" class="<?php echo $estado_equipos_porcurso_search->SearchLabelClass ?>"><span id="elh_estado_equipos_porcurso_ultima_actualiz_"><?php echo $estado_equipos_porcurso->ultima_actualiz_->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_ultima_actualiz_" id="z_ultima_actualiz_" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_equipos_porcurso_search->SearchRightColumnClass ?>"><div<?php echo $estado_equipos_porcurso->ultima_actualiz_->CellAttributes() ?>>
			<span id="el_estado_equipos_porcurso_ultima_actualiz_">
<input type="text" data-table="estado_equipos_porcurso" data-field="x_ultima_actualiz_" name="x_ultima_actualiz_" id="x_ultima_actualiz_" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($estado_equipos_porcurso->ultima_actualiz_->getPlaceHolder()) ?>" value="<?php echo $estado_equipos_porcurso->ultima_actualiz_->EditValue ?>"<?php echo $estado_equipos_porcurso->ultima_actualiz_->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$estado_equipos_porcurso_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festado_equipos_porcursosearch.Init();
</script>
<?php
$estado_equipos_porcurso_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_equipos_porcurso_search->Page_Terminate();
?>
