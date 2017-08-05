<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "referente_tecnicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$referente_tecnico_search = NULL; // Initialize page object first

class creferente_tecnico_search extends creferente_tecnico {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'referente_tecnico';

	// Page object name
	var $PageObjName = 'referente_tecnico_search';

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

		// Table object (referente_tecnico)
		if (!isset($GLOBALS["referente_tecnico"]) || get_class($GLOBALS["referente_tecnico"]) == "creferente_tecnico") {
			$GLOBALS["referente_tecnico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referente_tecnico"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'referente_tecnico', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("referente_tecnicolist.php"));
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
		$this->Apellido_Nombre->SetVisibility();
		$this->DniRte->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Mail->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Fecha_Ingreso->SetVisibility();
		$this->Titulo->SetVisibility();
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
		global $EW_EXPORT, $referente_tecnico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($referente_tecnico);
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
						$sSrchStr = "referente_tecnicolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Apellido_Nombre); // Apellido_Nombre
		$this->BuildSearchUrl($sSrchUrl, $this->DniRte); // DniRte
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio); // Domicilio
		$this->BuildSearchUrl($sSrchUrl, $this->Telefono); // Telefono
		$this->BuildSearchUrl($sSrchUrl, $this->Celular); // Celular
		$this->BuildSearchUrl($sSrchUrl, $this->Mail); // Mail
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Turno); // Id_Turno
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Ingreso); // Fecha_Ingreso
		$this->BuildSearchUrl($sSrchUrl, $this->Titulo); // Titulo
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
		// Apellido_Nombre

		$this->Apellido_Nombre->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellido_Nombre"));
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellido_Nombre");

		// DniRte
		$this->DniRte->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_DniRte"));
		$this->DniRte->AdvancedSearch->SearchOperator = $objForm->GetValue("z_DniRte");

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio"));
		$this->Domicilio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio");

		// Telefono
		$this->Telefono->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Telefono"));
		$this->Telefono->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Telefono");

		// Celular
		$this->Celular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Celular"));
		$this->Celular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Celular");

		// Mail
		$this->Mail->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Mail"));
		$this->Mail->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Mail");

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Turno"));
		$this->Id_Turno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Turno");

		// Fecha_Ingreso
		$this->Fecha_Ingreso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Ingreso"));
		$this->Fecha_Ingreso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Ingreso");

		// Titulo
		$this->Titulo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Titulo"));
		$this->Titulo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Titulo");

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
		// Apellido_Nombre
		// DniRte
		// Domicilio
		// Telefono
		// Celular
		// Mail
		// Id_Turno
		// Fecha_Ingreso
		// Titulo
		// Usuario
		// Fecha_Actualizacion
		// Cue

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// DniRte
		$this->DniRte->ViewValue = $this->DniRte->CurrentValue;
		$this->DniRte->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Mail
		$this->Mail->ViewValue = $this->Mail->CurrentValue;
		$this->Mail->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
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

		// Fecha_Ingreso
		$this->Fecha_Ingreso->ViewValue = $this->Fecha_Ingreso->CurrentValue;
		$this->Fecha_Ingreso->ViewValue = ew_FormatDateTime($this->Fecha_Ingreso->ViewValue, 2);
		$this->Fecha_Ingreso->ViewCustomAttributes = "";

		// Titulo
		$this->Titulo->ViewValue = $this->Titulo->CurrentValue;
		$this->Titulo->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// DniRte
			$this->DniRte->LinkCustomAttributes = "";
			$this->DniRte->HrefValue = "";
			$this->DniRte->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Mail
			$this->Mail->LinkCustomAttributes = "";
			$this->Mail->HrefValue = "";
			$this->Mail->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Fecha_Ingreso
			$this->Fecha_Ingreso->LinkCustomAttributes = "";
			$this->Fecha_Ingreso->HrefValue = "";
			$this->Fecha_Ingreso->TooltipValue = "";

			// Titulo
			$this->Titulo->LinkCustomAttributes = "";
			$this->Titulo->HrefValue = "";
			$this->Titulo->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->AdvancedSearch->SearchValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// DniRte
			$this->DniRte->EditAttrs["class"] = "form-control";
			$this->DniRte->EditCustomAttributes = "";
			$this->DniRte->EditValue = ew_HtmlEncode($this->DniRte->AdvancedSearch->SearchValue);
			$this->DniRte->PlaceHolder = ew_RemoveHtml($this->DniRte->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono
			$this->Telefono->EditAttrs["class"] = "form-control";
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->AdvancedSearch->SearchValue);
			$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

			// Celular
			$this->Celular->EditAttrs["class"] = "form-control";
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->AdvancedSearch->SearchValue);
			$this->Celular->PlaceHolder = ew_RemoveHtml($this->Celular->FldCaption());

			// Mail
			$this->Mail->EditAttrs["class"] = "form-control";
			$this->Mail->EditCustomAttributes = "";
			$this->Mail->EditValue = ew_HtmlEncode($this->Mail->AdvancedSearch->SearchValue);
			$this->Mail->PlaceHolder = ew_RemoveHtml($this->Mail->FldCaption());

			// Id_Turno
			$this->Id_Turno->EditAttrs["class"] = "form-control";
			$this->Id_Turno->EditCustomAttributes = "";
			if (trim(strval($this->Id_Turno->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Turno->EditValue = $arwrk;

			// Fecha_Ingreso
			$this->Fecha_Ingreso->EditAttrs["class"] = "form-control";
			$this->Fecha_Ingreso->EditCustomAttributes = "";
			$this->Fecha_Ingreso->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Ingreso->AdvancedSearch->SearchValue, 2), 2));
			$this->Fecha_Ingreso->PlaceHolder = ew_RemoveHtml($this->Fecha_Ingreso->FldCaption());

			// Titulo
			$this->Titulo->EditAttrs["class"] = "form-control";
			$this->Titulo->EditCustomAttributes = "";
			$this->Titulo->EditValue = ew_HtmlEncode($this->Titulo->AdvancedSearch->SearchValue);
			$this->Titulo->PlaceHolder = ew_RemoveHtml($this->Titulo->FldCaption());

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
		if (!ew_CheckInteger($this->DniRte->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->DniRte->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Telefono->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Telefono->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Celular->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Celular->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->Fecha_Ingreso->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Ingreso->FldErrMsg());
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
		$this->Apellido_Nombre->AdvancedSearch->Load();
		$this->DniRte->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Mail->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Fecha_Ingreso->AdvancedSearch->Load();
		$this->Titulo->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("referente_tecnicolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno_rte`";
			$sWhereWrk = "";
			$this->Id_Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
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
if (!isset($referente_tecnico_search)) $referente_tecnico_search = new creferente_tecnico_search();

// Page init
$referente_tecnico_search->Page_Init();

// Page main
$referente_tecnico_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($referente_tecnico_search->IsModal) { ?>
var CurrentAdvancedSearchForm = freferente_tecnicosearch = new ew_Form("freferente_tecnicosearch", "search");
<?php } else { ?>
var CurrentForm = freferente_tecnicosearch = new ew_Form("freferente_tecnicosearch", "search");
<?php } ?>

// Form_CustomValidate event
freferente_tecnicosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicosearch.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicosearch.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
// Validate function for search

freferente_tecnicosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_DniRte");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->DniRte->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Telefono");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Telefono->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Celular");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Celular->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Ingreso");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Fecha_Ingreso->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Actualizacion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Fecha_Actualizacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$referente_tecnico_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $referente_tecnico_search->ShowPageHeader(); ?>
<?php
$referente_tecnico_search->ShowMessage();
?>
<form name="freferente_tecnicosearch" id="freferente_tecnicosearch" class="<?php echo $referente_tecnico_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referente_tecnico_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referente_tecnico_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referente_tecnico">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($referente_tecnico_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($referente_tecnico->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<div id="r_Apellido_Nombre" class="form-group">
		<label for="x_Apellido_Nombre" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Apellido_Nombre"><?php echo $referente_tecnico->Apellido_Nombre->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellido_Nombre" id="z_Apellido_Nombre" value="LIKE"></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Apellido_Nombre->CellAttributes() ?>>
			<span id="el_referente_tecnico_Apellido_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apellido_Nombre" name="x_Apellido_Nombre" id="x_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apellido_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apellido_Nombre->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
	<div id="r_DniRte" class="form-group">
		<label for="x_DniRte" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_DniRte"><?php echo $referente_tecnico->DniRte->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_DniRte" id="z_DniRte" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->DniRte->CellAttributes() ?>>
			<span id="el_referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x_DniRte" id="x_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Domicilio"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio" id="z_Domicilio" value="LIKE"></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Domicilio->CellAttributes() ?>>
			<span id="el_referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
	<div id="r_Telefono" class="form-group">
		<label for="x_Telefono" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Telefono"><?php echo $referente_tecnico->Telefono->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Telefono" id="z_Telefono" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Telefono->CellAttributes() ?>>
			<span id="el_referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
	<div id="r_Celular" class="form-group">
		<label for="x_Celular" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Celular"><?php echo $referente_tecnico->Celular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Celular" id="z_Celular" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Celular->CellAttributes() ?>>
			<span id="el_referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x_Celular" id="x_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
	<div id="r_Mail" class="form-group">
		<label for="x_Mail" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Mail"><?php echo $referente_tecnico->Mail->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Mail" id="z_Mail" value="LIKE"></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Mail->CellAttributes() ?>>
			<span id="el_referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x_Mail" id="x_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label for="x_Id_Turno" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Id_Turno"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Turno" id="z_Id_Turno" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Id_Turno->CellAttributes() ?>>
			<span id="el_referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Fecha_Ingreso->Visible) { // Fecha_Ingreso ?>
	<div id="r_Fecha_Ingreso" class="form-group">
		<label for="x_Fecha_Ingreso" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Fecha_Ingreso"><?php echo $referente_tecnico->Fecha_Ingreso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Ingreso" id="z_Fecha_Ingreso" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Fecha_Ingreso->CellAttributes() ?>>
			<span id="el_referente_tecnico_Fecha_Ingreso">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Ingreso" data-format="2" name="x_Fecha_Ingreso" id="x_Fecha_Ingreso" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Ingreso->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Ingreso->EditValue ?>"<?php echo $referente_tecnico->Fecha_Ingreso->EditAttributes() ?>>
<?php if (!$referente_tecnico->Fecha_Ingreso->ReadOnly && !$referente_tecnico->Fecha_Ingreso->Disabled && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["readonly"]) && !isset($referente_tecnico->Fecha_Ingreso->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freferente_tecnicosearch", "x_Fecha_Ingreso", 2);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Titulo->Visible) { // Titulo ?>
	<div id="r_Titulo" class="form-group">
		<label for="x_Titulo" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Titulo"><?php echo $referente_tecnico->Titulo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Titulo" id="z_Titulo" value="LIKE"></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Titulo->CellAttributes() ?>>
			<span id="el_referente_tecnico_Titulo">
<input type="text" data-table="referente_tecnico" data-field="x_Titulo" name="x_Titulo" id="x_Titulo" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Titulo->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Titulo->EditValue ?>"<?php echo $referente_tecnico->Titulo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Usuario"><?php echo $referente_tecnico->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Usuario->CellAttributes() ?>>
			<span id="el_referente_tecnico_Usuario">
<input type="text" data-table="referente_tecnico" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Usuario->EditValue ?>"<?php echo $referente_tecnico->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="<?php echo $referente_tecnico_search->SearchLabelClass ?>"><span id="elh_referente_tecnico_Fecha_Actualizacion"><?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $referente_tecnico_search->SearchRightColumnClass ?>"><div<?php echo $referente_tecnico->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_referente_tecnico_Fecha_Actualizacion">
<input type="text" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Fecha_Actualizacion->EditValue ?>"<?php echo $referente_tecnico->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$referente_tecnico_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
freferente_tecnicosearch.Init();
</script>
<?php
$referente_tecnico_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$referente_tecnico_search->Page_Terminate();
?>
