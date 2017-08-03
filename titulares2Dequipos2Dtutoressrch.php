<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "titulares2Dequipos2Dtutoresinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$titulares2Dequipos2Dtutores_search = NULL; // Initialize page object first

class ctitulares2Dequipos2Dtutores_search extends ctitulares2Dequipos2Dtutores {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'titulares-equipos-tutores';

	// Page object name
	var $PageObjName = 'titulares2Dequipos2Dtutores_search';

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

		// Table object (titulares2Dequipos2Dtutores)
		if (!isset($GLOBALS["titulares2Dequipos2Dtutores"]) || get_class($GLOBALS["titulares2Dequipos2Dtutores"]) == "ctitulares2Dequipos2Dtutores") {
			$GLOBALS["titulares2Dequipos2Dtutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["titulares2Dequipos2Dtutores"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'titulares-equipos-tutores', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("titulares2Dequipos2Dtutoreslist.php"));
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
		$this->Apelldio_y_Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Equipo_Asignado->SetVisibility();
		$this->Apellido_y_Nombre_Tutor->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Cuil_Tutor->SetVisibility();

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
		global $EW_EXPORT, $titulares2Dequipos2Dtutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($titulares2Dequipos2Dtutores);
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
						$sSrchStr = "titulares2Dequipos2Dtutoreslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Apelldio_y_Nombre_Titular); // Apelldio y Nombre Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil); // Cuil
		$this->BuildSearchUrl($sSrchUrl, $this->Equipo_Asignado); // Equipo Asignado
		$this->BuildSearchUrl($sSrchUrl, $this->Apellido_y_Nombre_Tutor); // Apellido y Nombre Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->Dni_Tutor); // Dni Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil_Tutor); // Cuil Tutor
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
		// Apelldio y Nombre Titular

		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apelldio_y_Nombre_Titular"));
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apelldio_y_Nombre_Titular");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil"));
		$this->Cuil->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil");

		// Equipo Asignado
		$this->Equipo_Asignado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Equipo_Asignado"));
		$this->Equipo_Asignado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Equipo_Asignado");

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellido_y_Nombre_Tutor"));
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellido_y_Nombre_Tutor");

		// Dni Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni_Tutor"));
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni_Tutor");

		// Cuil Tutor
		$this->Cuil_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil_Tutor"));
		$this->Cuil_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil_Tutor");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Apelldio y Nombre Titular
		// Dni
		// Cuil
		// Equipo Asignado
		// Apellido y Nombre Tutor
		// Dni Tutor
		// Cuil Tutor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->ViewValue = $this->Apelldio_y_Nombre_Titular->CurrentValue;
		$this->Apelldio_y_Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Equipo Asignado
		$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
		if (strval($this->Equipo_Asignado->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Equipo_Asignado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
			}
		} else {
			$this->Equipo_Asignado->ViewValue = NULL;
		}
		$this->Equipo_Asignado->ViewCustomAttributes = "";

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->ViewValue = $this->Apellido_y_Nombre_Tutor->CurrentValue;
		$this->Apellido_y_Nombre_Tutor->ViewCustomAttributes = "";

		// Dni Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Cuil Tutor
		$this->Cuil_Tutor->ViewValue = $this->Cuil_Tutor->CurrentValue;
		$this->Cuil_Tutor->ViewCustomAttributes = "";

			// Apelldio y Nombre Titular
			$this->Apelldio_y_Nombre_Titular->LinkCustomAttributes = "";
			$this->Apelldio_y_Nombre_Titular->HrefValue = "";
			$this->Apelldio_y_Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Equipo Asignado
			$this->Equipo_Asignado->LinkCustomAttributes = "";
			$this->Equipo_Asignado->HrefValue = "";
			$this->Equipo_Asignado->TooltipValue = "";

			// Apellido y Nombre Tutor
			$this->Apellido_y_Nombre_Tutor->LinkCustomAttributes = "";
			$this->Apellido_y_Nombre_Tutor->HrefValue = "";
			$this->Apellido_y_Nombre_Tutor->TooltipValue = "";

			// Dni Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Cuil Tutor
			$this->Cuil_Tutor->LinkCustomAttributes = "";
			$this->Cuil_Tutor->HrefValue = "";
			$this->Cuil_Tutor->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Apelldio y Nombre Titular
			$this->Apelldio_y_Nombre_Titular->EditAttrs["class"] = "form-control";
			$this->Apelldio_y_Nombre_Titular->EditCustomAttributes = "";
			$this->Apelldio_y_Nombre_Titular->EditValue = ew_HtmlEncode($this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue);
			$this->Apelldio_y_Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Apelldio_y_Nombre_Titular->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Cuil
			$this->Cuil->EditAttrs["class"] = "form-control";
			$this->Cuil->EditCustomAttributes = "";
			$this->Cuil->EditValue = ew_HtmlEncode($this->Cuil->AdvancedSearch->SearchValue);
			$this->Cuil->PlaceHolder = ew_RemoveHtml($this->Cuil->FldCaption());

			// Equipo Asignado
			$this->Equipo_Asignado->EditAttrs["class"] = "form-control";
			$this->Equipo_Asignado->EditCustomAttributes = "";
			$this->Equipo_Asignado->EditValue = ew_HtmlEncode($this->Equipo_Asignado->AdvancedSearch->SearchValue);
			if (strval($this->Equipo_Asignado->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Equipo_Asignado->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Equipo_Asignado->EditValue = $this->Equipo_Asignado->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Equipo_Asignado->EditValue = ew_HtmlEncode($this->Equipo_Asignado->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Equipo_Asignado->EditValue = NULL;
			}
			$this->Equipo_Asignado->PlaceHolder = ew_RemoveHtml($this->Equipo_Asignado->FldCaption());

			// Apellido y Nombre Tutor
			$this->Apellido_y_Nombre_Tutor->EditAttrs["class"] = "form-control";
			$this->Apellido_y_Nombre_Tutor->EditCustomAttributes = "";
			$this->Apellido_y_Nombre_Tutor->EditValue = ew_HtmlEncode($this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue);
			$this->Apellido_y_Nombre_Tutor->PlaceHolder = ew_RemoveHtml($this->Apellido_y_Nombre_Tutor->FldCaption());

			// Dni Tutor
			$this->Dni_Tutor->EditAttrs["class"] = "form-control";
			$this->Dni_Tutor->EditCustomAttributes = "";
			$this->Dni_Tutor->EditValue = ew_HtmlEncode($this->Dni_Tutor->AdvancedSearch->SearchValue);
			$this->Dni_Tutor->PlaceHolder = ew_RemoveHtml($this->Dni_Tutor->FldCaption());

			// Cuil Tutor
			$this->Cuil_Tutor->EditAttrs["class"] = "form-control";
			$this->Cuil_Tutor->EditCustomAttributes = "";
			$this->Cuil_Tutor->EditValue = ew_HtmlEncode($this->Cuil_Tutor->AdvancedSearch->SearchValue);
			$this->Cuil_Tutor->PlaceHolder = ew_RemoveHtml($this->Cuil_Tutor->FldCaption());
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
		if (!ew_CheckInteger($this->Dni_Tutor->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni_Tutor->FldErrMsg());
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
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Equipo_Asignado->AdvancedSearch->Load();
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Cuil_Tutor->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("titulares2Dequipos2Dtutoreslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Equipo_Asignado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
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
		case "x_Equipo_Asignado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
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
if (!isset($titulares2Dequipos2Dtutores_search)) $titulares2Dequipos2Dtutores_search = new ctitulares2Dequipos2Dtutores_search();

// Page init
$titulares2Dequipos2Dtutores_search->Page_Init();

// Page main
$titulares2Dequipos2Dtutores_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$titulares2Dequipos2Dtutores_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($titulares2Dequipos2Dtutores_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ftitulares2Dequipos2Dtutoressearch = new ew_Form("ftitulares2Dequipos2Dtutoressearch", "search");
<?php } else { ?>
var CurrentForm = ftitulares2Dequipos2Dtutoressearch = new ew_Form("ftitulares2Dequipos2Dtutoressearch", "search");
<?php } ?>

// Form_CustomValidate event
ftitulares2Dequipos2Dtutoressearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftitulares2Dequipos2Dtutoressearch.ValidateRequired = true;
<?php } else { ?>
ftitulares2Dequipos2Dtutoressearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftitulares2Dequipos2Dtutoressearch.Lists["x_Equipo_Asignado"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
// Validate function for search

ftitulares2Dequipos2Dtutoressearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($titulares2Dequipos2Dtutores->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Dni_Tutor");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($titulares2Dequipos2Dtutores->Dni_Tutor->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$titulares2Dequipos2Dtutores_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $titulares2Dequipos2Dtutores_search->ShowPageHeader(); ?>
<?php
$titulares2Dequipos2Dtutores_search->ShowMessage();
?>
<form name="ftitulares2Dequipos2Dtutoressearch" id="ftitulares2Dequipos2Dtutoressearch" class="<?php echo $titulares2Dequipos2Dtutores_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($titulares2Dequipos2Dtutores_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $titulares2Dequipos2Dtutores_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="titulares2Dequipos2Dtutores">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($titulares2Dequipos2Dtutores_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->Visible) { // Apelldio y Nombre Titular ?>
	<div id="r_Apelldio_y_Nombre_Titular" class="form-group">
		<label for="x_Apelldio_y_Nombre_Titular" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular"><?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apelldio_y_Nombre_Titular" id="z_Apelldio_y_Nombre_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Apelldio_y_Nombre_Titular" name="x_Apelldio_y_Nombre_Titular" id="x_Apelldio_y_Nombre_Titular" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Dni"><?php echo $titulares2Dequipos2Dtutores->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Dni->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Dni">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Dni->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Dni->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Cuil->Visible) { // Cuil ?>
	<div id="r_Cuil" class="form-group">
		<label for="x_Cuil" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Cuil"><?php echo $titulares2Dequipos2Dtutores->Cuil->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil" id="z_Cuil" value="LIKE"></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Cuil->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Cuil">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Cuil" name="x_Cuil" id="x_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Cuil->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Cuil->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Equipo_Asignado->Visible) { // Equipo Asignado ?>
	<div id="r_Equipo_Asignado" class="form-group">
		<label class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Equipo_Asignado"><?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Equipo_Asignado" id="z_Equipo_Asignado" value="LIKE"></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Equipo_Asignado">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Equipo_Asignado"><?php echo (strval($titulares2Dequipos2Dtutores->Equipo_Asignado->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $titulares2Dequipos2Dtutores->Equipo_Asignado->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($titulares2Dequipos2Dtutores->Equipo_Asignado->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Equipo_Asignado',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="titulares2Dequipos2Dtutores" data-field="x_Equipo_Asignado" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->DisplayValueSeparatorAttribute() ?>" name="x_Equipo_Asignado" id="x_Equipo_Asignado" value="<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->AdvancedSearch->SearchValue ?>"<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->EditAttributes() ?>>
<input type="hidden" name="s_x_Equipo_Asignado" id="s_x_Equipo_Asignado" value="<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->Visible) { // Apellido y Nombre Tutor ?>
	<div id="r_Apellido_y_Nombre_Tutor" class="form-group">
		<label for="x_Apellido_y_Nombre_Tutor" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor"><?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellido_y_Nombre_Tutor" id="z_Apellido_y_Nombre_Tutor" value="LIKE"></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Apellido_y_Nombre_Tutor" name="x_Apellido_y_Nombre_Tutor" id="x_Apellido_y_Nombre_Tutor" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Dni_Tutor->Visible) { // Dni Tutor ?>
	<div id="r_Dni_Tutor" class="form-group">
		<label for="x_Dni_Tutor" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Dni_Tutor"><?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni_Tutor" id="z_Dni_Tutor" value="="></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Dni_Tutor">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Dni_Tutor" name="x_Dni_Tutor" id="x_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Cuil_Tutor->Visible) { // Cuil Tutor ?>
	<div id="r_Cuil_Tutor" class="form-group">
		<label for="x_Cuil_Tutor" class="<?php echo $titulares2Dequipos2Dtutores_search->SearchLabelClass ?>"><span id="elh_titulares2Dequipos2Dtutores_Cuil_Tutor"><?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil_Tutor" id="z_Cuil_Tutor" value="LIKE"></p>
		</label>
		<div class="<?php echo $titulares2Dequipos2Dtutores_search->SearchRightColumnClass ?>"><div<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->CellAttributes() ?>>
			<span id="el_titulares2Dequipos2Dtutores_Cuil_Tutor">
<input type="text" data-table="titulares2Dequipos2Dtutores" data-field="x_Cuil_Tutor" name="x_Cuil_Tutor" id="x_Cuil_Tutor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores->Cuil_Tutor->getPlaceHolder()) ?>" value="<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->EditValue ?>"<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$titulares2Dequipos2Dtutores_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftitulares2Dequipos2Dtutoressearch.Init();
</script>
<?php
$titulares2Dequipos2Dtutores_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$titulares2Dequipos2Dtutores_search->Page_Terminate();
?>
