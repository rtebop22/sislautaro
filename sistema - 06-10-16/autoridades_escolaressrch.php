<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "autoridades_escolaresinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$autoridades_escolares_search = NULL; // Initialize page object first

class cautoridades_escolares_search extends cautoridades_escolares {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'autoridades_escolares';

	// Page object name
	var $PageObjName = 'autoridades_escolares_search';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (autoridades_escolares)
		if (!isset($GLOBALS["autoridades_escolares"]) || get_class($GLOBALS["autoridades_escolares"]) == "cautoridades_escolares") {
			$GLOBALS["autoridades_escolares"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["autoridades_escolares"];
		}

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'autoridades_escolares', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("autoridades_escolareslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Apellido_Nombre->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Id_Cargo->SetVisibility();
		$this->Id_Turno->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->Celular->SetVisibility();
		$this->Maill->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Usuario->SetVisibility();

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
		global $EW_EXPORT, $autoridades_escolares;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($autoridades_escolares);
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
						$sSrchStr = "autoridades_escolareslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil); // Cuil
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Cargo); // Id_Cargo
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Turno); // Id_Turno
		$this->BuildSearchUrl($sSrchUrl, $this->Telefono); // Telefono
		$this->BuildSearchUrl($sSrchUrl, $this->Celular); // Celular
		$this->BuildSearchUrl($sSrchUrl, $this->Maill); // Maill
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
		// Apellido_Nombre

		$this->Apellido_Nombre->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellido_Nombre"));
		$this->Apellido_Nombre->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellido_Nombre");

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil"));
		$this->Cuil->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil");

		// Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Cargo"));
		$this->Id_Cargo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Cargo");

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Turno"));
		$this->Id_Turno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Turno");

		// Telefono
		$this->Telefono->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Telefono"));
		$this->Telefono->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Telefono");

		// Celular
		$this->Celular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Celular"));
		$this->Celular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Celular");

		// Maill
		$this->Maill->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Maill"));
		$this->Maill->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Maill");

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
		// Id_Autoridad
		// Apellido_Nombre
		// Cuil
		// Id_Cargo
		// Id_Turno
		// Telefono
		// Celular
		// Maill
		// Cue
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Autoridad
		$this->Id_Autoridad->ViewValue = $this->Id_Autoridad->CurrentValue;
		$this->Id_Autoridad->ViewCustomAttributes = "";

		// Apellido_Nombre
		$this->Apellido_Nombre->ViewValue = $this->Apellido_Nombre->CurrentValue;
		$this->Apellido_Nombre->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_autoridad`";
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

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// Celular
		$this->Celular->ViewValue = $this->Celular->CurrentValue;
		$this->Celular->ViewCustomAttributes = "";

		// Maill
		$this->Maill->ViewValue = $this->Maill->CurrentValue;
		$this->Maill->ViewCustomAttributes = "";

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Apellido_Nombre
			$this->Apellido_Nombre->LinkCustomAttributes = "";
			$this->Apellido_Nombre->HrefValue = "";
			$this->Apellido_Nombre->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Id_Cargo
			$this->Id_Cargo->LinkCustomAttributes = "";
			$this->Id_Cargo->HrefValue = "";
			$this->Id_Cargo->TooltipValue = "";

			// Id_Turno
			$this->Id_Turno->LinkCustomAttributes = "";
			$this->Id_Turno->HrefValue = "";
			$this->Id_Turno->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Maill
			$this->Maill->LinkCustomAttributes = "";
			$this->Maill->HrefValue = "";
			$this->Maill->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Apellido_Nombre
			$this->Apellido_Nombre->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre->EditCustomAttributes = "";
			$this->Apellido_Nombre->EditValue = ew_HtmlEncode($this->Apellido_Nombre->AdvancedSearch->SearchValue);
			$this->Apellido_Nombre->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->AdvancedSearch->SearchValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Id_Cargo
			$this->Id_Cargo->EditAttrs["class"] = "form-control";
			$this->Id_Cargo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Cargo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Cargo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cargo_autoridad`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Cargo->EditValue = $arwrk;

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

			// Maill
			$this->Maill->EditAttrs["class"] = "form-control";
			$this->Maill->EditCustomAttributes = "";
			$this->Maill->EditValue = ew_HtmlEncode($this->Maill->AdvancedSearch->SearchValue);
			$this->Maill->PlaceHolder = ew_RemoveHtml($this->Maill->FldCaption());

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
		if (!ew_CheckInteger($this->Telefono->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Telefono->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Celular->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Celular->FldErrMsg());
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
		$this->Cuil->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Telefono->AdvancedSearch->Load();
		$this->Celular->AdvancedSearch->Load();
		$this->Maill->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("autoridades_escolareslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Cargo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Cargo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_autoridad`";
			$sWhereWrk = "";
			$this->Id_Cargo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Cargo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
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
if (!isset($autoridades_escolares_search)) $autoridades_escolares_search = new cautoridades_escolares_search();

// Page init
$autoridades_escolares_search->Page_Init();

// Page main
$autoridades_escolares_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$autoridades_escolares_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($autoridades_escolares_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fautoridades_escolaressearch = new ew_Form("fautoridades_escolaressearch", "search");
<?php } else { ?>
var CurrentForm = fautoridades_escolaressearch = new ew_Form("fautoridades_escolaressearch", "search");
<?php } ?>

// Form_CustomValidate event
fautoridades_escolaressearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fautoridades_escolaressearch.ValidateRequired = true;
<?php } else { ?>
fautoridades_escolaressearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fautoridades_escolaressearch.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_autoridad"};
fautoridades_escolaressearch.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};

// Form object for search
// Validate function for search

fautoridades_escolaressearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Telefono");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($autoridades_escolares->Telefono->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Celular");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($autoridades_escolares->Celular->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$autoridades_escolares_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $autoridades_escolares_search->ShowPageHeader(); ?>
<?php
$autoridades_escolares_search->ShowMessage();
?>
<form name="fautoridades_escolaressearch" id="fautoridades_escolaressearch" class="<?php echo $autoridades_escolares_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($autoridades_escolares_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $autoridades_escolares_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="autoridades_escolares">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($autoridades_escolares_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<div id="r_Apellido_Nombre" class="form-group">
		<label for="x_Apellido_Nombre" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Apellido_Nombre"><?php echo $autoridades_escolares->Apellido_Nombre->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellido_Nombre" id="z_Apellido_Nombre" value="LIKE"></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Apellido_Nombre->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x_Apellido_Nombre" id="x_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
	<div id="r_Cuil" class="form-group">
		<label for="x_Cuil" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Cuil"><?php echo $autoridades_escolares->Cuil->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil" id="z_Cuil" value="LIKE"></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Cuil->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x_Cuil" id="x_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
	<div id="r_Id_Cargo" class="form-group">
		<label for="x_Id_Cargo" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Id_Cargo"><?php echo $autoridades_escolares->Id_Cargo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Cargo" id="z_Id_Cargo" value="="></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Id_Cargo->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Cargo" name="x_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x_Id_Cargo" id="s_x_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
	<div id="r_Id_Turno" class="form-group">
		<label for="x_Id_Turno" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Id_Turno"><?php echo $autoridades_escolares->Id_Turno->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Turno" id="z_Id_Turno" value="="></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Id_Turno->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x_Id_Turno" name="x_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x_Id_Turno") ?>
</select>
<input type="hidden" name="s_x_Id_Turno" id="s_x_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
	<div id="r_Telefono" class="form-group">
		<label for="x_Telefono" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Telefono"><?php echo $autoridades_escolares->Telefono->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Telefono" id="z_Telefono" value="="></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Telefono->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Celular->Visible) { // Celular ?>
	<div id="r_Celular" class="form-group">
		<label for="x_Celular" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Celular"><?php echo $autoridades_escolares->Celular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Celular" id="z_Celular" value="="></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Celular->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Celular">
<input type="text" data-table="autoridades_escolares" data-field="x_Celular" name="x_Celular" id="x_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Celular->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Celular->EditValue ?>"<?php echo $autoridades_escolares->Celular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Maill->Visible) { // Maill ?>
	<div id="r_Maill" class="form-group">
		<label for="x_Maill" class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Maill"><?php echo $autoridades_escolares->Maill->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Maill" id="z_Maill" value="LIKE"></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Maill->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Maill">
<input type="text" data-table="autoridades_escolares" data-field="x_Maill" name="x_Maill" id="x_Maill" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Maill->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Maill->EditValue ?>"<?php echo $autoridades_escolares->Maill->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Fecha_Actualizacion"><?php echo $autoridades_escolares->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Fecha_Actualizacion">
<input type="text" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Fecha_Actualizacion->EditValue ?>"<?php echo $autoridades_escolares->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $autoridades_escolares_search->SearchLabelClass ?>"><span id="elh_autoridades_escolares_Usuario"><?php echo $autoridades_escolares->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $autoridades_escolares_search->SearchRightColumnClass ?>"><div<?php echo $autoridades_escolares->Usuario->CellAttributes() ?>>
			<span id="el_autoridades_escolares_Usuario">
<input type="text" data-table="autoridades_escolares" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Usuario->EditValue ?>"<?php echo $autoridades_escolares->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$autoridades_escolares_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fautoridades_escolaressearch.Init();
</script>
<?php
$autoridades_escolares_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$autoridades_escolares_search->Page_Terminate();
?>
