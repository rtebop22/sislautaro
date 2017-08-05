<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "estado_documentacion_personasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$estado_documentacion_personas_search = NULL; // Initialize page object first

class cestado_documentacion_personas_search extends cestado_documentacion_personas {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'estado_documentacion_personas';

	// Page object name
	var $PageObjName = 'estado_documentacion_personas_search';

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

		// Table object (estado_documentacion_personas)
		if (!isset($GLOBALS["estado_documentacion_personas"]) || get_class($GLOBALS["estado_documentacion_personas"]) == "cestado_documentacion_personas") {
			$GLOBALS["estado_documentacion_personas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_documentacion_personas"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_documentacion_personas', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("estado_documentacion_personaslist.php"));
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
		$this->Apellidos_Nombres->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Id_Curso->SetVisibility();
		$this->Id_Division->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->Id_Cargo->SetVisibility();
		$this->Matricula->SetVisibility();
		$this->Certificado_Pase->SetVisibility();
		$this->Tiene_DNI->SetVisibility();
		$this->Certificado_Medico->SetVisibility();
		$this->Posee_Autorizacion->SetVisibility();
		$this->Cooperadora->SetVisibility();

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
		global $EW_EXPORT, $estado_documentacion_personas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_documentacion_personas);
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
						$sSrchStr = "estado_documentacion_personaslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Apellidos_Nombres); // Apellidos_Nombres
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Curso); // Id_Curso
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Division); // Id_Division
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Turno); // Id_Turno
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado); // Id_Estado
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Cargo); // Id_Cargo
		$this->BuildSearchUrl($sSrchUrl, $this->Matricula); // Matricula
		$this->BuildSearchUrl($sSrchUrl, $this->Certificado_Pase); // Certificado_Pase
		$this->BuildSearchUrl($sSrchUrl, $this->Tiene_DNI); // Tiene_DNI
		$this->BuildSearchUrl($sSrchUrl, $this->Certificado_Medico); // Certificado_Medico
		$this->BuildSearchUrl($sSrchUrl, $this->Posee_Autorizacion); // Posee_Autorizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Cooperadora); // Cooperadora
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
		// Apellidos_Nombres

		$this->Apellidos_Nombres->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellidos_Nombres"));
		$this->Apellidos_Nombres->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellidos_Nombres");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Id_Curso
		$this->Id_Curso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Curso"));
		$this->Id_Curso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Curso");

		// Id_Division
		$this->Id_Division->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Division"));
		$this->Id_Division->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Division");

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Turno"));
		$this->Id_Turno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Turno");

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado"));
		$this->Id_Estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado");

		// Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Cargo"));
		$this->Id_Cargo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Cargo");

		// Matricula
		$this->Matricula->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Matricula"));
		$this->Matricula->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Matricula");

		// Certificado_Pase
		$this->Certificado_Pase->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Certificado_Pase"));
		$this->Certificado_Pase->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Certificado_Pase");

		// Tiene_DNI
		$this->Tiene_DNI->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tiene_DNI"));
		$this->Tiene_DNI->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tiene_DNI");

		// Certificado_Medico
		$this->Certificado_Medico->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Certificado_Medico"));
		$this->Certificado_Medico->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Certificado_Medico");

		// Posee_Autorizacion
		$this->Posee_Autorizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Posee_Autorizacion"));
		$this->Posee_Autorizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Posee_Autorizacion");

		// Cooperadora
		$this->Cooperadora->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cooperadora"));
		$this->Cooperadora->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cooperadora");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Apellidos_Nombres
		// Dni
		// Id_Curso
		// Id_Division
		// Id_Turno
		// Id_Estado
		// Id_Cargo
		// Matricula
		// Certificado_Pase
		// Tiene_DNI
		// Certificado_Medico
		// Posee_Autorizacion
		// Cooperadora

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellidos_Nombres
		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Id_Curso
		if (strval($this->Id_Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Id_Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Curso->ViewValue = $this->Id_Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Curso->ViewValue = $this->Id_Curso->CurrentValue;
			}
		} else {
			$this->Id_Curso->ViewValue = NULL;
		}
		$this->Id_Curso->ViewCustomAttributes = "";

		// Id_Division
		if (strval($this->Id_Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Id_Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Division->ViewValue = $this->Id_Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Division->ViewValue = $this->Id_Division->CurrentValue;
			}
		} else {
			$this->Id_Division->ViewValue = NULL;
		}
		$this->Id_Division->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado->ViewValue = $this->Id_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
		$sWhereWrk = "";
		$this->Id_Cargo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->CurrentValue;
			}
		} else {
			$this->Id_Cargo->ViewValue = NULL;
		}
		$this->Id_Cargo->ViewCustomAttributes = "";

		// Matricula
		if (strval($this->Matricula->CurrentValue) <> "") {
			$this->Matricula->ViewValue = $this->Matricula->OptionCaption($this->Matricula->CurrentValue);
		} else {
			$this->Matricula->ViewValue = NULL;
		}
		$this->Matricula->ViewCustomAttributes = "";

		// Certificado_Pase
		if (strval($this->Certificado_Pase->CurrentValue) <> "") {
			$this->Certificado_Pase->ViewValue = $this->Certificado_Pase->OptionCaption($this->Certificado_Pase->CurrentValue);
		} else {
			$this->Certificado_Pase->ViewValue = NULL;
		}
		$this->Certificado_Pase->ViewCustomAttributes = "";

		// Tiene_DNI
		if (strval($this->Tiene_DNI->CurrentValue) <> "") {
			$this->Tiene_DNI->ViewValue = $this->Tiene_DNI->OptionCaption($this->Tiene_DNI->CurrentValue);
		} else {
			$this->Tiene_DNI->ViewValue = NULL;
		}
		$this->Tiene_DNI->ViewCustomAttributes = "";

		// Certificado_Medico
		if (strval($this->Certificado_Medico->CurrentValue) <> "") {
			$this->Certificado_Medico->ViewValue = $this->Certificado_Medico->OptionCaption($this->Certificado_Medico->CurrentValue);
		} else {
			$this->Certificado_Medico->ViewValue = NULL;
		}
		$this->Certificado_Medico->ViewCustomAttributes = "";

		// Posee_Autorizacion
		if (strval($this->Posee_Autorizacion->CurrentValue) <> "") {
			$this->Posee_Autorizacion->ViewValue = $this->Posee_Autorizacion->OptionCaption($this->Posee_Autorizacion->CurrentValue);
		} else {
			$this->Posee_Autorizacion->ViewValue = NULL;
		}
		$this->Posee_Autorizacion->ViewCustomAttributes = "";

		// Cooperadora
		if (strval($this->Cooperadora->CurrentValue) <> "") {
			$this->Cooperadora->ViewValue = $this->Cooperadora->OptionCaption($this->Cooperadora->CurrentValue);
		} else {
			$this->Cooperadora->ViewValue = NULL;
		}
		$this->Cooperadora->ViewCustomAttributes = "";

			// Apellidos_Nombres
			$this->Apellidos_Nombres->LinkCustomAttributes = "";
			$this->Apellidos_Nombres->HrefValue = "";
			$this->Apellidos_Nombres->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Id_Curso
			$this->Id_Curso->LinkCustomAttributes = "";
			$this->Id_Curso->HrefValue = "";
			$this->Id_Curso->TooltipValue = "";

			// Id_Division
			$this->Id_Division->LinkCustomAttributes = "";
			$this->Id_Division->HrefValue = "";
			$this->Id_Division->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";
			$this->Id_Cargo->TooltipValue = "";

			// Matricula
			$this->Matricula->LinkCustomAttributes = "";
			$this->Matricula->HrefValue = "";
			$this->Matricula->TooltipValue = "";

			// Certificado_Pase
			$this->Certificado_Pase->LinkCustomAttributes = "";
			$this->Certificado_Pase->HrefValue = "";
			$this->Certificado_Pase->TooltipValue = "";

			// Tiene_DNI
			$this->Tiene_DNI->LinkCustomAttributes = "";
			$this->Tiene_DNI->HrefValue = "";
			$this->Tiene_DNI->TooltipValue = "";

			// Certificado_Medico
			$this->Certificado_Medico->LinkCustomAttributes = "";
			$this->Certificado_Medico->HrefValue = "";
			$this->Certificado_Medico->TooltipValue = "";

			// Posee_Autorizacion
			$this->Posee_Autorizacion->LinkCustomAttributes = "";
			$this->Posee_Autorizacion->HrefValue = "";
			$this->Posee_Autorizacion->TooltipValue = "";

			// Cooperadora
			$this->Cooperadora->LinkCustomAttributes = "";
			$this->Cooperadora->HrefValue = "";
			$this->Cooperadora->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Apellidos_Nombres
			$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
			$this->Apellidos_Nombres->EditCustomAttributes = "";
			$this->Apellidos_Nombres->EditValue = ew_HtmlEncode($this->Apellidos_Nombres->AdvancedSearch->SearchValue);
			$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Id_Curso
			$this->Id_Curso->EditAttrs["class"] = "form-control";
			$this->Id_Curso->EditCustomAttributes = "";
			if (trim(strval($this->Id_Curso->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Curso->EditValue = $arwrk;

			// Id_Division
			$this->Id_Division->EditAttrs["class"] = "form-control";
			$this->Id_Division->EditCustomAttributes = "";
			if (trim(strval($this->Id_Division->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Division->EditValue = $arwrk;

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

			// Matricula
			$this->Matricula->EditCustomAttributes = "";
			$this->Matricula->EditValue = $this->Matricula->Options(FALSE);

			// Certificado_Pase
			$this->Certificado_Pase->EditCustomAttributes = "";
			$this->Certificado_Pase->EditValue = $this->Certificado_Pase->Options(FALSE);

			// Tiene_DNI
			$this->Tiene_DNI->EditCustomAttributes = "";
			$this->Tiene_DNI->EditValue = $this->Tiene_DNI->Options(FALSE);

			// Certificado_Medico
			$this->Certificado_Medico->EditCustomAttributes = "";
			$this->Certificado_Medico->EditValue = $this->Certificado_Medico->Options(FALSE);

			// Posee_Autorizacion
			$this->Posee_Autorizacion->EditCustomAttributes = "";
			$this->Posee_Autorizacion->EditValue = $this->Posee_Autorizacion->Options(FALSE);

			// Cooperadora
			$this->Cooperadora->EditCustomAttributes = "";
			$this->Cooperadora->EditValue = $this->Cooperadora->Options(FALSE);
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
		$this->Apellidos_Nombres->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Id_Curso->AdvancedSearch->Load();
		$this->Id_Division->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Matricula->AdvancedSearch->Load();
		$this->Certificado_Pase->AdvancedSearch->Load();
		$this->Tiene_DNI->AdvancedSearch->Load();
		$this->Certificado_Medico->AdvancedSearch->Load();
		$this->Posee_Autorizacion->AdvancedSearch->Load();
		$this->Cooperadora->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_documentacion_personaslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Curso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->Id_Curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Curso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Division` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->Id_Division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Division` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Cargo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Cargo` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Cargo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
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
if (!isset($estado_documentacion_personas_search)) $estado_documentacion_personas_search = new cestado_documentacion_personas_search();

// Page init
$estado_documentacion_personas_search->Page_Init();

// Page main
$estado_documentacion_personas_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_documentacion_personas_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($estado_documentacion_personas_search->IsModal) { ?>
var CurrentAdvancedSearchForm = festado_documentacion_personassearch = new ew_Form("festado_documentacion_personassearch", "search");
<?php } else { ?>
var CurrentForm = festado_documentacion_personassearch = new ew_Form("festado_documentacion_personassearch", "search");
<?php } ?>

// Form_CustomValidate event
festado_documentacion_personassearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_documentacion_personassearch.ValidateRequired = true;
<?php } else { ?>
festado_documentacion_personassearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_documentacion_personassearch.Lists["x_Id_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
festado_documentacion_personassearch.Lists["x_Id_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};
festado_documentacion_personassearch.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
festado_documentacion_personassearch.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_persona"};
festado_documentacion_personassearch.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_persona"};
festado_documentacion_personassearch.Lists["x_Matricula"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Matricula"].Options = <?php echo json_encode($estado_documentacion_personas->Matricula->Options()) ?>;
festado_documentacion_personassearch.Lists["x_Certificado_Pase"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Certificado_Pase"].Options = <?php echo json_encode($estado_documentacion_personas->Certificado_Pase->Options()) ?>;
festado_documentacion_personassearch.Lists["x_Tiene_DNI"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Tiene_DNI"].Options = <?php echo json_encode($estado_documentacion_personas->Tiene_DNI->Options()) ?>;
festado_documentacion_personassearch.Lists["x_Certificado_Medico"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Certificado_Medico"].Options = <?php echo json_encode($estado_documentacion_personas->Certificado_Medico->Options()) ?>;
festado_documentacion_personassearch.Lists["x_Posee_Autorizacion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Posee_Autorizacion"].Options = <?php echo json_encode($estado_documentacion_personas->Posee_Autorizacion->Options()) ?>;
festado_documentacion_personassearch.Lists["x_Cooperadora"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_documentacion_personassearch.Lists["x_Cooperadora"].Options = <?php echo json_encode($estado_documentacion_personas->Cooperadora->Options()) ?>;

// Form object for search
// Validate function for search

festado_documentacion_personassearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($estado_documentacion_personas->Dni->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$estado_documentacion_personas_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estado_documentacion_personas_search->ShowPageHeader(); ?>
<?php
$estado_documentacion_personas_search->ShowMessage();
?>
<form name="festado_documentacion_personassearch" id="festado_documentacion_personassearch" class="<?php echo $estado_documentacion_personas_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_documentacion_personas_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_documentacion_personas_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_documentacion_personas">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($estado_documentacion_personas_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($estado_documentacion_personas->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<div id="r_Apellidos_Nombres" class="form-group">
		<label for="x_Apellidos_Nombres" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Apellidos_Nombres"><?php echo $estado_documentacion_personas->Apellidos_Nombres->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellidos_Nombres" id="z_Apellidos_Nombres" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Apellidos_Nombres->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Apellidos_Nombres">
<input type="text" data-table="estado_documentacion_personas" data-field="x_Apellidos_Nombres" name="x_Apellidos_Nombres" id="x_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($estado_documentacion_personas->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $estado_documentacion_personas->Apellidos_Nombres->EditValue ?>"<?php echo $estado_documentacion_personas->Apellidos_Nombres->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Dni"><?php echo $estado_documentacion_personas->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Dni->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Dni">
<input type="text" data-table="estado_documentacion_personas" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($estado_documentacion_personas->Dni->getPlaceHolder()) ?>" value="<?php echo $estado_documentacion_personas->Dni->EditValue ?>"<?php echo $estado_documentacion_personas->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Id_Curso->Visible) { // Id_Curso ?>
	<div id="r_Id_Curso" class="form-group">
		<label for="x_Id_Curso" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Id_Curso"><?php echo $estado_documentacion_personas->Id_Curso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Curso" id="z_Id_Curso" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Id_Curso->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Id_Curso">
<select data-table="estado_documentacion_personas" data-field="x_Id_Curso" data-value-separator="<?php echo $estado_documentacion_personas->Id_Curso->DisplayValueSeparatorAttribute() ?>" id="x_Id_Curso" name="x_Id_Curso"<?php echo $estado_documentacion_personas->Id_Curso->EditAttributes() ?>>
<?php echo $estado_documentacion_personas->Id_Curso->SelectOptionListHtml("x_Id_Curso") ?>
</select>
<input type="hidden" name="s_x_Id_Curso" id="s_x_Id_Curso" value="<?php echo $estado_documentacion_personas->Id_Curso->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Id_Division->Visible) { // Id_Division ?>
	<div id="r_Id_Division" class="form-group">
		<label for="x_Id_Division" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Id_Division"><?php echo $estado_documentacion_personas->Id_Division->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Division" id="z_Id_Division" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Id_Division->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Id_Division">
<select data-table="estado_documentacion_personas" data-field="x_Id_Division" data-value-separator="<?php echo $estado_documentacion_personas->Id_Division->DisplayValueSeparatorAttribute() ?>" id="x_Id_Division" name="x_Id_Division"<?php echo $estado_documentacion_personas->Id_Division->EditAttributes() ?>>
<?php echo $estado_documentacion_personas->Id_Division->SelectOptionListHtml("x_Id_Division") ?>
</select>
<input type="hidden" name="s_x_Id_Division" id="s_x_Id_Division" value="<?php echo $estado_documentacion_personas->Id_Division->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label for="x_Id_Turno" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Id_Turno"><?php echo $estado_documentacion_personas->Id_Turno->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Turno" id="z_Id_Turno" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Id_Turno->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Id_Turno">
<select data-table="estado_documentacion_personas" data-field="x_Id_Turno" data-value-separator="<?php echo $estado_documentacion_personas->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $estado_documentacion_personas->Id_Turno->EditAttributes() ?>>
<?php echo $estado_documentacion_personas->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $estado_documentacion_personas->Id_Turno->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label for="x_Id_Estado" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Id_Estado"><?php echo $estado_documentacion_personas->Id_Estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado" id="z_Id_Estado" value="="></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Id_Estado->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Id_Estado">
<select data-table="estado_documentacion_personas" data-field="x_Id_Estado" data-value-separator="<?php echo $estado_documentacion_personas->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $estado_documentacion_personas->Id_Estado->EditAttributes() ?>>
<?php echo $estado_documentacion_personas->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $estado_documentacion_personas->Id_Estado->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Id_Cargo->Visible) { // Id_Cargo ?>
	<div id="r_Id_Cargo" class="form-group">
		<label for="x_Id_Cargo" class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Id_Cargo"><?php echo $estado_documentacion_personas->Id_Cargo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Cargo" id="z_Id_Cargo" value="="></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Id_Cargo->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Id_Cargo">
<select data-table="estado_documentacion_personas" data-field="x_Id_Cargo" data-value-separator="<?php echo $estado_documentacion_personas->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Cargo" name="x_Id_Cargo"<?php echo $estado_documentacion_personas->Id_Cargo->EditAttributes() ?>>
<?php echo $estado_documentacion_personas->Id_Cargo->SelectOptionListHtml("x_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x_Id_Cargo" id="s_x_Id_Cargo" value="<?php echo $estado_documentacion_personas->Id_Cargo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Matricula->Visible) { // Matricula ?>
	<div id="r_Matricula" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Matricula"><?php echo $estado_documentacion_personas->Matricula->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Matricula" id="z_Matricula" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Matricula->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Matricula">
<div id="tp_x_Matricula" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Matricula" data-value-separator="<?php echo $estado_documentacion_personas->Matricula->DisplayValueSeparatorAttribute() ?>" name="x_Matricula" id="x_Matricula" value="{value}"<?php echo $estado_documentacion_personas->Matricula->EditAttributes() ?>></div>
<div id="dsl_x_Matricula" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Matricula->RadioButtonListHtml(FALSE, "x_Matricula") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Certificado_Pase->Visible) { // Certificado_Pase ?>
	<div id="r_Certificado_Pase" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Certificado_Pase"><?php echo $estado_documentacion_personas->Certificado_Pase->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Certificado_Pase" id="z_Certificado_Pase" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Certificado_Pase->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Certificado_Pase">
<div id="tp_x_Certificado_Pase" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Certificado_Pase" data-value-separator="<?php echo $estado_documentacion_personas->Certificado_Pase->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Pase" id="x_Certificado_Pase" value="{value}"<?php echo $estado_documentacion_personas->Certificado_Pase->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Pase" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Certificado_Pase->RadioButtonListHtml(FALSE, "x_Certificado_Pase") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Tiene_DNI->Visible) { // Tiene_DNI ?>
	<div id="r_Tiene_DNI" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Tiene_DNI"><?php echo $estado_documentacion_personas->Tiene_DNI->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tiene_DNI" id="z_Tiene_DNI" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Tiene_DNI->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Tiene_DNI">
<div id="tp_x_Tiene_DNI" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Tiene_DNI" data-value-separator="<?php echo $estado_documentacion_personas->Tiene_DNI->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_DNI" id="x_Tiene_DNI" value="{value}"<?php echo $estado_documentacion_personas->Tiene_DNI->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_DNI" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Tiene_DNI->RadioButtonListHtml(FALSE, "x_Tiene_DNI") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Certificado_Medico->Visible) { // Certificado_Medico ?>
	<div id="r_Certificado_Medico" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Certificado_Medico"><?php echo $estado_documentacion_personas->Certificado_Medico->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Certificado_Medico" id="z_Certificado_Medico" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Certificado_Medico->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Certificado_Medico">
<div id="tp_x_Certificado_Medico" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Certificado_Medico" data-value-separator="<?php echo $estado_documentacion_personas->Certificado_Medico->DisplayValueSeparatorAttribute() ?>" name="x_Certificado_Medico" id="x_Certificado_Medico" value="{value}"<?php echo $estado_documentacion_personas->Certificado_Medico->EditAttributes() ?>></div>
<div id="dsl_x_Certificado_Medico" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Certificado_Medico->RadioButtonListHtml(FALSE, "x_Certificado_Medico") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Posee_Autorizacion->Visible) { // Posee_Autorizacion ?>
	<div id="r_Posee_Autorizacion" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Posee_Autorizacion"><?php echo $estado_documentacion_personas->Posee_Autorizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Posee_Autorizacion" id="z_Posee_Autorizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Posee_Autorizacion->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Posee_Autorizacion">
<div id="tp_x_Posee_Autorizacion" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Posee_Autorizacion" data-value-separator="<?php echo $estado_documentacion_personas->Posee_Autorizacion->DisplayValueSeparatorAttribute() ?>" name="x_Posee_Autorizacion" id="x_Posee_Autorizacion" value="{value}"<?php echo $estado_documentacion_personas->Posee_Autorizacion->EditAttributes() ?>></div>
<div id="dsl_x_Posee_Autorizacion" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Posee_Autorizacion->RadioButtonListHtml(FALSE, "x_Posee_Autorizacion") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($estado_documentacion_personas->Cooperadora->Visible) { // Cooperadora ?>
	<div id="r_Cooperadora" class="form-group">
		<label class="<?php echo $estado_documentacion_personas_search->SearchLabelClass ?>"><span id="elh_estado_documentacion_personas_Cooperadora"><?php echo $estado_documentacion_personas->Cooperadora->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cooperadora" id="z_Cooperadora" value="LIKE"></p>
		</label>
		<div class="<?php echo $estado_documentacion_personas_search->SearchRightColumnClass ?>"><div<?php echo $estado_documentacion_personas->Cooperadora->CellAttributes() ?>>
			<span id="el_estado_documentacion_personas_Cooperadora">
<div id="tp_x_Cooperadora" class="ewTemplate"><input type="radio" data-table="estado_documentacion_personas" data-field="x_Cooperadora" data-value-separator="<?php echo $estado_documentacion_personas->Cooperadora->DisplayValueSeparatorAttribute() ?>" name="x_Cooperadora" id="x_Cooperadora" value="{value}"<?php echo $estado_documentacion_personas->Cooperadora->EditAttributes() ?>></div>
<div id="dsl_x_Cooperadora" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $estado_documentacion_personas->Cooperadora->RadioButtonListHtml(FALSE, "x_Cooperadora") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$estado_documentacion_personas_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
festado_documentacion_personassearch.Init();
</script>
<?php
$estado_documentacion_personas_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_documentacion_personas_search->Page_Terminate();
?>
