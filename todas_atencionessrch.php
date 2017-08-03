<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "todas_atencionesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$todas_atenciones_search = NULL; // Initialize page object first

class ctodas_atenciones_search extends ctodas_atenciones {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'todas_atenciones';

	// Page object name
	var $PageObjName = 'todas_atenciones_search';

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

		// Table object (todas_atenciones)
		if (!isset($GLOBALS["todas_atenciones"]) || get_class($GLOBALS["todas_atenciones"]) == "ctodas_atenciones") {
			$GLOBALS["todas_atenciones"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["todas_atenciones"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'todas_atenciones', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("todas_atencioneslist.php"));
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
		$this->NB0_Atencion->SetVisibility();
		$this->NB0_Atencion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Equipo->SetVisibility();
		$this->Fecha_Entrada->SetVisibility();
		$this->Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Usuario_que_cargo->SetVisibility();
		$this->Descripcion_Problema->SetVisibility();
		$this->Id_Tipo_Falla->SetVisibility();
		$this->Id_Problema->SetVisibility();
		$this->Id_Tipo_Sol_Problem->SetVisibility();
		$this->Id_Estado_Atenc->SetVisibility();
		$this->Ultima_Actualizacion->SetVisibility();

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
		global $EW_EXPORT, $todas_atenciones;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($todas_atenciones);
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
						$sSrchStr = "todas_atencioneslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NB0_Atencion); // N° Atencion
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Equipo); // Serie Equipo
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Entrada); // Fecha Entrada
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Titular); // Nombre Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Usuario_que_cargo); // Usuario que cargo
		$this->BuildSearchUrl($sSrchUrl, $this->Descripcion_Problema); // Descripcion Problema
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Falla); // Id_Tipo_Falla
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Problema); // Id_Problema
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Sol_Problem); // Id_Tipo_Sol_Problem
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Atenc); // Id_Estado_Atenc
		$this->BuildSearchUrl($sSrchUrl, $this->Ultima_Actualizacion); // Ultima Actualizacion
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
		// N° Atencion

		$this->NB0_Atencion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NB0_Atencion"));
		$this->NB0_Atencion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NB0_Atencion");

		// Serie Equipo
		$this->Serie_Equipo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Equipo"));
		$this->Serie_Equipo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Equipo");

		// Fecha Entrada
		$this->Fecha_Entrada->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Entrada"));
		$this->Fecha_Entrada->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Entrada");

		// Nombre Titular
		$this->Nombre_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Titular"));
		$this->Nombre_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Titular");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Usuario que cargo
		$this->Usuario_que_cargo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Usuario_que_cargo"));
		$this->Usuario_que_cargo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Usuario_que_cargo");

		// Descripcion Problema
		$this->Descripcion_Problema->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Descripcion_Problema"));
		$this->Descripcion_Problema->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Descripcion_Problema");

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Falla"));
		$this->Id_Tipo_Falla->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Falla");

		// Id_Problema
		$this->Id_Problema->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Problema"));
		$this->Id_Problema->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Problema");

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Sol_Problem"));
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Sol_Problem");

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Atenc"));
		$this->Id_Estado_Atenc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Atenc");

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Ultima_Actualizacion"));
		$this->Ultima_Actualizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Ultima_Actualizacion");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// N° Atencion
		// Serie Equipo
		// Fecha Entrada
		// Nombre Titular
		// Dni
		// Usuario que cargo
		// Descripcion Problema
		// Id_Tipo_Falla
		// Id_Problema
		// Id_Tipo_Sol_Problem
		// Id_Estado_Atenc
		// Ultima Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// N° Atencion
		$this->NB0_Atencion->ViewValue = $this->NB0_Atencion->CurrentValue;
		$this->NB0_Atencion->ViewCustomAttributes = "";

		// Serie Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Fecha Entrada
		$this->Fecha_Entrada->ViewValue = $this->Fecha_Entrada->CurrentValue;
		$this->Fecha_Entrada->ViewValue = ew_FormatDateTime($this->Fecha_Entrada->ViewValue, 0);
		$this->Fecha_Entrada->ViewCustomAttributes = "";

		// Nombre Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Usuario que cargo
		$this->Usuario_que_cargo->ViewValue = $this->Usuario_que_cargo->CurrentValue;
		$this->Usuario_que_cargo->ViewCustomAttributes = "";

		// Descripcion Problema
		$this->Descripcion_Problema->ViewValue = $this->Descripcion_Problema->CurrentValue;
		$this->Descripcion_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Falla
		$this->Id_Tipo_Falla->ViewValue = $this->Id_Tipo_Falla->CurrentValue;
		$this->Id_Tipo_Falla->ViewCustomAttributes = "";

		// Id_Problema
		$this->Id_Problema->ViewValue = $this->Id_Problema->CurrentValue;
		$this->Id_Problema->ViewCustomAttributes = "";

		// Id_Tipo_Sol_Problem
		$this->Id_Tipo_Sol_Problem->ViewValue = $this->Id_Tipo_Sol_Problem->CurrentValue;
		$this->Id_Tipo_Sol_Problem->ViewCustomAttributes = "";

		// Id_Estado_Atenc
		$this->Id_Estado_Atenc->ViewValue = $this->Id_Estado_Atenc->CurrentValue;
		$this->Id_Estado_Atenc->ViewCustomAttributes = "";

		// Ultima Actualizacion
		$this->Ultima_Actualizacion->ViewValue = $this->Ultima_Actualizacion->CurrentValue;
		$this->Ultima_Actualizacion->ViewValue = ew_FormatDateTime($this->Ultima_Actualizacion->ViewValue, 0);
		$this->Ultima_Actualizacion->ViewCustomAttributes = "";

			// N° Atencion
			$this->NB0_Atencion->LinkCustomAttributes = "";
			$this->NB0_Atencion->HrefValue = "";
			$this->NB0_Atencion->TooltipValue = "";

			// Serie Equipo
			$this->Serie_Equipo->LinkCustomAttributes = "";
			$this->Serie_Equipo->HrefValue = "";
			$this->Serie_Equipo->TooltipValue = "";

			// Fecha Entrada
			$this->Fecha_Entrada->LinkCustomAttributes = "";
			$this->Fecha_Entrada->HrefValue = "";
			$this->Fecha_Entrada->TooltipValue = "";

			// Nombre Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Usuario que cargo
			$this->Usuario_que_cargo->LinkCustomAttributes = "";
			$this->Usuario_que_cargo->HrefValue = "";
			$this->Usuario_que_cargo->TooltipValue = "";

			// Descripcion Problema
			$this->Descripcion_Problema->LinkCustomAttributes = "";
			$this->Descripcion_Problema->HrefValue = "";
			$this->Descripcion_Problema->TooltipValue = "";

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->LinkCustomAttributes = "";
			$this->Id_Tipo_Falla->HrefValue = "";
			$this->Id_Tipo_Falla->TooltipValue = "";

			// Id_Problema
			$this->Id_Problema->LinkCustomAttributes = "";
			$this->Id_Problema->HrefValue = "";
			$this->Id_Problema->TooltipValue = "";

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->LinkCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->HrefValue = "";
			$this->Id_Tipo_Sol_Problem->TooltipValue = "";

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->LinkCustomAttributes = "";
			$this->Id_Estado_Atenc->HrefValue = "";
			$this->Id_Estado_Atenc->TooltipValue = "";

			// Ultima Actualizacion
			$this->Ultima_Actualizacion->LinkCustomAttributes = "";
			$this->Ultima_Actualizacion->HrefValue = "";
			$this->Ultima_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// N° Atencion
			$this->NB0_Atencion->EditAttrs["class"] = "form-control";
			$this->NB0_Atencion->EditCustomAttributes = "";
			$this->NB0_Atencion->EditValue = ew_HtmlEncode($this->NB0_Atencion->AdvancedSearch->SearchValue);
			$this->NB0_Atencion->PlaceHolder = ew_RemoveHtml($this->NB0_Atencion->FldCaption());

			// Serie Equipo
			$this->Serie_Equipo->EditAttrs["class"] = "form-control";
			$this->Serie_Equipo->EditCustomAttributes = "";
			$this->Serie_Equipo->EditValue = ew_HtmlEncode($this->Serie_Equipo->AdvancedSearch->SearchValue);
			$this->Serie_Equipo->PlaceHolder = ew_RemoveHtml($this->Serie_Equipo->FldCaption());

			// Fecha Entrada
			$this->Fecha_Entrada->EditAttrs["class"] = "form-control";
			$this->Fecha_Entrada->EditCustomAttributes = "";
			$this->Fecha_Entrada->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Entrada->AdvancedSearch->SearchValue, 0), 8));
			$this->Fecha_Entrada->PlaceHolder = ew_RemoveHtml($this->Fecha_Entrada->FldCaption());

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

			// Usuario que cargo
			$this->Usuario_que_cargo->EditAttrs["class"] = "form-control";
			$this->Usuario_que_cargo->EditCustomAttributes = "";
			$this->Usuario_que_cargo->EditValue = ew_HtmlEncode($this->Usuario_que_cargo->AdvancedSearch->SearchValue);
			$this->Usuario_que_cargo->PlaceHolder = ew_RemoveHtml($this->Usuario_que_cargo->FldCaption());

			// Descripcion Problema
			$this->Descripcion_Problema->EditAttrs["class"] = "form-control";
			$this->Descripcion_Problema->EditCustomAttributes = "";
			$this->Descripcion_Problema->EditValue = ew_HtmlEncode($this->Descripcion_Problema->AdvancedSearch->SearchValue);
			$this->Descripcion_Problema->PlaceHolder = ew_RemoveHtml($this->Descripcion_Problema->FldCaption());

			// Id_Tipo_Falla
			$this->Id_Tipo_Falla->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Falla->EditCustomAttributes = "";
			$this->Id_Tipo_Falla->EditValue = ew_HtmlEncode($this->Id_Tipo_Falla->AdvancedSearch->SearchValue);
			$this->Id_Tipo_Falla->PlaceHolder = ew_RemoveHtml($this->Id_Tipo_Falla->FldCaption());

			// Id_Problema
			$this->Id_Problema->EditAttrs["class"] = "form-control";
			$this->Id_Problema->EditCustomAttributes = "";
			$this->Id_Problema->EditValue = ew_HtmlEncode($this->Id_Problema->AdvancedSearch->SearchValue);
			$this->Id_Problema->PlaceHolder = ew_RemoveHtml($this->Id_Problema->FldCaption());

			// Id_Tipo_Sol_Problem
			$this->Id_Tipo_Sol_Problem->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Sol_Problem->EditCustomAttributes = "";
			$this->Id_Tipo_Sol_Problem->EditValue = ew_HtmlEncode($this->Id_Tipo_Sol_Problem->AdvancedSearch->SearchValue);
			$this->Id_Tipo_Sol_Problem->PlaceHolder = ew_RemoveHtml($this->Id_Tipo_Sol_Problem->FldCaption());

			// Id_Estado_Atenc
			$this->Id_Estado_Atenc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Atenc->EditCustomAttributes = "";
			$this->Id_Estado_Atenc->EditValue = ew_HtmlEncode($this->Id_Estado_Atenc->AdvancedSearch->SearchValue);
			$this->Id_Estado_Atenc->PlaceHolder = ew_RemoveHtml($this->Id_Estado_Atenc->FldCaption());

			// Ultima Actualizacion
			$this->Ultima_Actualizacion->EditAttrs["class"] = "form-control";
			$this->Ultima_Actualizacion->EditCustomAttributes = "";
			$this->Ultima_Actualizacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Ultima_Actualizacion->AdvancedSearch->SearchValue, 0), 8));
			$this->Ultima_Actualizacion->PlaceHolder = ew_RemoveHtml($this->Ultima_Actualizacion->FldCaption());
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
		if (!ew_CheckInteger($this->NB0_Atencion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->NB0_Atencion->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->Fecha_Entrada->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Entrada->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Dni->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->Ultima_Actualizacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Ultima_Actualizacion->FldErrMsg());
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
		$this->NB0_Atencion->AdvancedSearch->Load();
		$this->Serie_Equipo->AdvancedSearch->Load();
		$this->Fecha_Entrada->AdvancedSearch->Load();
		$this->Nombre_Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Usuario_que_cargo->AdvancedSearch->Load();
		$this->Descripcion_Problema->AdvancedSearch->Load();
		$this->Id_Tipo_Falla->AdvancedSearch->Load();
		$this->Id_Problema->AdvancedSearch->Load();
		$this->Id_Tipo_Sol_Problem->AdvancedSearch->Load();
		$this->Id_Estado_Atenc->AdvancedSearch->Load();
		$this->Ultima_Actualizacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("todas_atencioneslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
if (!isset($todas_atenciones_search)) $todas_atenciones_search = new ctodas_atenciones_search();

// Page init
$todas_atenciones_search->Page_Init();

// Page main
$todas_atenciones_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$todas_atenciones_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($todas_atenciones_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ftodas_atencionessearch = new ew_Form("ftodas_atencionessearch", "search");
<?php } else { ?>
var CurrentForm = ftodas_atencionessearch = new ew_Form("ftodas_atencionessearch", "search");
<?php } ?>

// Form_CustomValidate event
ftodas_atencionessearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftodas_atencionessearch.ValidateRequired = true;
<?php } else { ?>
ftodas_atencionessearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search
// Validate function for search

ftodas_atencionessearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_NB0_Atencion");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($todas_atenciones->NB0_Atencion->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Entrada");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($todas_atenciones->Fecha_Entrada->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($todas_atenciones->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Ultima_Actualizacion");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($todas_atenciones->Ultima_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$todas_atenciones_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $todas_atenciones_search->ShowPageHeader(); ?>
<?php
$todas_atenciones_search->ShowMessage();
?>
<form name="ftodas_atencionessearch" id="ftodas_atencionessearch" class="<?php echo $todas_atenciones_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($todas_atenciones_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $todas_atenciones_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="todas_atenciones">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($todas_atenciones_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($todas_atenciones->NB0_Atencion->Visible) { // N° Atencion ?>
	<div id="r_NB0_Atencion" class="form-group">
		<label for="x_NB0_Atencion" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_NB0_Atencion"><?php echo $todas_atenciones->NB0_Atencion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_NB0_Atencion" id="z_NB0_Atencion" value="="></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->NB0_Atencion->CellAttributes() ?>>
			<span id="el_todas_atenciones_NB0_Atencion">
<input type="text" data-table="todas_atenciones" data-field="x_NB0_Atencion" name="x_NB0_Atencion" id="x_NB0_Atencion" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->NB0_Atencion->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->NB0_Atencion->EditValue ?>"<?php echo $todas_atenciones->NB0_Atencion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Serie_Equipo->Visible) { // Serie Equipo ?>
	<div id="r_Serie_Equipo" class="form-group">
		<label for="x_Serie_Equipo" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Serie_Equipo"><?php echo $todas_atenciones->Serie_Equipo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Equipo" id="z_Serie_Equipo" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Serie_Equipo->CellAttributes() ?>>
			<span id="el_todas_atenciones_Serie_Equipo">
<input type="text" data-table="todas_atenciones" data-field="x_Serie_Equipo" name="x_Serie_Equipo" id="x_Serie_Equipo" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Serie_Equipo->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Serie_Equipo->EditValue ?>"<?php echo $todas_atenciones->Serie_Equipo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Fecha_Entrada->Visible) { // Fecha Entrada ?>
	<div id="r_Fecha_Entrada" class="form-group">
		<label for="x_Fecha_Entrada" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Fecha_Entrada"><?php echo $todas_atenciones->Fecha_Entrada->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Entrada" id="z_Fecha_Entrada" value="="></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Fecha_Entrada->CellAttributes() ?>>
			<span id="el_todas_atenciones_Fecha_Entrada">
<input type="text" data-table="todas_atenciones" data-field="x_Fecha_Entrada" name="x_Fecha_Entrada" id="x_Fecha_Entrada" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Fecha_Entrada->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Fecha_Entrada->EditValue ?>"<?php echo $todas_atenciones->Fecha_Entrada->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Nombre_Titular->Visible) { // Nombre Titular ?>
	<div id="r_Nombre_Titular" class="form-group">
		<label for="x_Nombre_Titular" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Nombre_Titular"><?php echo $todas_atenciones->Nombre_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Titular" id="z_Nombre_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Nombre_Titular->CellAttributes() ?>>
			<span id="el_todas_atenciones_Nombre_Titular">
<input type="text" data-table="todas_atenciones" data-field="x_Nombre_Titular" name="x_Nombre_Titular" id="x_Nombre_Titular" size="35" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Nombre_Titular->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Nombre_Titular->EditValue ?>"<?php echo $todas_atenciones->Nombre_Titular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Dni"><?php echo $todas_atenciones->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Dni->CellAttributes() ?>>
			<span id="el_todas_atenciones_Dni">
<input type="text" data-table="todas_atenciones" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Dni->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Dni->EditValue ?>"<?php echo $todas_atenciones->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Usuario_que_cargo->Visible) { // Usuario que cargo ?>
	<div id="r_Usuario_que_cargo" class="form-group">
		<label for="x_Usuario_que_cargo" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Usuario_que_cargo"><?php echo $todas_atenciones->Usuario_que_cargo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario_que_cargo" id="z_Usuario_que_cargo" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Usuario_que_cargo->CellAttributes() ?>>
			<span id="el_todas_atenciones_Usuario_que_cargo">
<input type="text" data-table="todas_atenciones" data-field="x_Usuario_que_cargo" name="x_Usuario_que_cargo" id="x_Usuario_que_cargo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Usuario_que_cargo->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Usuario_que_cargo->EditValue ?>"<?php echo $todas_atenciones->Usuario_que_cargo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Descripcion_Problema->Visible) { // Descripcion Problema ?>
	<div id="r_Descripcion_Problema" class="form-group">
		<label for="x_Descripcion_Problema" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Descripcion_Problema"><?php echo $todas_atenciones->Descripcion_Problema->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Descripcion_Problema" id="z_Descripcion_Problema" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Descripcion_Problema->CellAttributes() ?>>
			<span id="el_todas_atenciones_Descripcion_Problema">
<input type="text" data-table="todas_atenciones" data-field="x_Descripcion_Problema" name="x_Descripcion_Problema" id="x_Descripcion_Problema" size="35" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Descripcion_Problema->EditValue ?>"<?php echo $todas_atenciones->Descripcion_Problema->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
	<div id="r_Id_Tipo_Falla" class="form-group">
		<label for="x_Id_Tipo_Falla" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Id_Tipo_Falla"><?php echo $todas_atenciones->Id_Tipo_Falla->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Tipo_Falla" id="z_Id_Tipo_Falla" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Id_Tipo_Falla->CellAttributes() ?>>
			<span id="el_todas_atenciones_Id_Tipo_Falla">
<input type="text" data-table="todas_atenciones" data-field="x_Id_Tipo_Falla" name="x_Id_Tipo_Falla" id="x_Id_Tipo_Falla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Id_Tipo_Falla->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Id_Tipo_Falla->EditValue ?>"<?php echo $todas_atenciones->Id_Tipo_Falla->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Id_Problema->Visible) { // Id_Problema ?>
	<div id="r_Id_Problema" class="form-group">
		<label for="x_Id_Problema" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Id_Problema"><?php echo $todas_atenciones->Id_Problema->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Problema" id="z_Id_Problema" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Id_Problema->CellAttributes() ?>>
			<span id="el_todas_atenciones_Id_Problema">
<input type="text" data-table="todas_atenciones" data-field="x_Id_Problema" name="x_Id_Problema" id="x_Id_Problema" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Id_Problema->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Id_Problema->EditValue ?>"<?php echo $todas_atenciones->Id_Problema->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
	<div id="r_Id_Tipo_Sol_Problem" class="form-group">
		<label for="x_Id_Tipo_Sol_Problem" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Id_Tipo_Sol_Problem"><?php echo $todas_atenciones->Id_Tipo_Sol_Problem->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Tipo_Sol_Problem" id="z_Id_Tipo_Sol_Problem" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->CellAttributes() ?>>
			<span id="el_todas_atenciones_Id_Tipo_Sol_Problem">
<input type="text" data-table="todas_atenciones" data-field="x_Id_Tipo_Sol_Problem" name="x_Id_Tipo_Sol_Problem" id="x_Id_Tipo_Sol_Problem" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Id_Tipo_Sol_Problem->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->EditValue ?>"<?php echo $todas_atenciones->Id_Tipo_Sol_Problem->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
	<div id="r_Id_Estado_Atenc" class="form-group">
		<label for="x_Id_Estado_Atenc" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Id_Estado_Atenc"><?php echo $todas_atenciones->Id_Estado_Atenc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Estado_Atenc" id="z_Id_Estado_Atenc" value="LIKE"></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Id_Estado_Atenc->CellAttributes() ?>>
			<span id="el_todas_atenciones_Id_Estado_Atenc">
<input type="text" data-table="todas_atenciones" data-field="x_Id_Estado_Atenc" name="x_Id_Estado_Atenc" id="x_Id_Estado_Atenc" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Id_Estado_Atenc->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Id_Estado_Atenc->EditValue ?>"<?php echo $todas_atenciones->Id_Estado_Atenc->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($todas_atenciones->Ultima_Actualizacion->Visible) { // Ultima Actualizacion ?>
	<div id="r_Ultima_Actualizacion" class="form-group">
		<label for="x_Ultima_Actualizacion" class="<?php echo $todas_atenciones_search->SearchLabelClass ?>"><span id="elh_todas_atenciones_Ultima_Actualizacion"><?php echo $todas_atenciones->Ultima_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Ultima_Actualizacion" id="z_Ultima_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $todas_atenciones_search->SearchRightColumnClass ?>"><div<?php echo $todas_atenciones->Ultima_Actualizacion->CellAttributes() ?>>
			<span id="el_todas_atenciones_Ultima_Actualizacion">
<input type="text" data-table="todas_atenciones" data-field="x_Ultima_Actualizacion" name="x_Ultima_Actualizacion" id="x_Ultima_Actualizacion" placeholder="<?php echo ew_HtmlEncode($todas_atenciones->Ultima_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $todas_atenciones->Ultima_Actualizacion->EditValue ?>"<?php echo $todas_atenciones->Ultima_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$todas_atenciones_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftodas_atencionessearch.Init();
</script>
<?php
$todas_atenciones_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$todas_atenciones_search->Page_Terminate();
?>
