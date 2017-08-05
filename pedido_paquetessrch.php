<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pedido_paquetesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pedido_paquetes_search = NULL; // Initialize page object first

class cpedido_paquetes_search extends cpedido_paquetes {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pedido_paquetes';

	// Page object name
	var $PageObjName = 'pedido_paquetes_search';

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

		// Table object (pedido_paquetes)
		if (!isset($GLOBALS["pedido_paquetes"]) || get_class($GLOBALS["pedido_paquetes"]) == "cpedido_paquetes") {
			$GLOBALS["pedido_paquetes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pedido_paquetes"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pedido_paquetes', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pedido_paqueteslist.php"));
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
		$this->Cue->SetVisibility();
		$this->Establecimiento->SetVisibility();
		$this->Departamento->SetVisibility();
		$this->Localidad->SetVisibility();
		$this->Motivo_Pedido->SetVisibility();
		$this->NB0_de_Serie->SetVisibility();
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->SetVisibility();
		$this->ID_HARDWARE->SetVisibility();
		$this->EXTRACCID3N_DE_DATOS->SetVisibility();
		$this->MARCA_DE_ARRANQUE->SetVisibility();
		$this->TITULAR->SetVisibility();
		$this->SERIE_NETBOOK->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->CORREO_ELECTRONICO2FEMAIL->SetVisibility();

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
		global $EW_EXPORT, $pedido_paquetes;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pedido_paquetes);
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
						$sSrchStr = "pedido_paqueteslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Cue); // Cue
		$this->BuildSearchUrl($sSrchUrl, $this->Establecimiento); // Establecimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Departamento); // Departamento
		$this->BuildSearchUrl($sSrchUrl, $this->Localidad); // Localidad
		$this->BuildSearchUrl($sSrchUrl, $this->Motivo_Pedido); // Motivo Pedido
		$this->BuildSearchUrl($sSrchUrl, $this->NB0_de_Serie); // N° de Serie
		$this->BuildSearchUrl($sSrchUrl, $this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL); // SPECIAL NUMBER o NUMERO ESPECIAL
		$this->BuildSearchUrl($sSrchUrl, $this->ID_HARDWARE); // ID HARDWARE
		$this->BuildSearchUrl($sSrchUrl, $this->EXTRACCID3N_DE_DATOS); // EXTRACCIÓN DE DATOS
		$this->BuildSearchUrl($sSrchUrl, $this->MARCA_DE_ARRANQUE); // MARCA DE ARRANQUE
		$this->BuildSearchUrl($sSrchUrl, $this->TITULAR); // TITULAR
		$this->BuildSearchUrl($sSrchUrl, $this->SERIE_NETBOOK); // SERIE NETBOOK
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Paquete); // Id_Estado_Paquete
		$this->BuildSearchUrl($sSrchUrl, $this->CORREO_ELECTRONICO2FEMAIL); // CORREO ELECTRONICO/EMAIL
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
		// Cue

		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue"));
		$this->Cue->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue");

		// Establecimiento
		$this->Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Establecimiento"));
		$this->Establecimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Establecimiento");

		// Departamento
		$this->Departamento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Departamento"));
		$this->Departamento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Departamento");

		// Localidad
		$this->Localidad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Localidad"));
		$this->Localidad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Localidad");

		// Motivo Pedido
		$this->Motivo_Pedido->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Motivo_Pedido"));
		$this->Motivo_Pedido->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Motivo_Pedido");

		// N° de Serie
		$this->NB0_de_Serie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NB0_de_Serie"));
		$this->NB0_de_Serie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NB0_de_Serie");

		// SPECIAL NUMBER o NUMERO ESPECIAL
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SPECIAL_NUMBER_o_NUMERO_ESPECIAL"));
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SPECIAL_NUMBER_o_NUMERO_ESPECIAL");

		// ID HARDWARE
		$this->ID_HARDWARE->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_ID_HARDWARE"));
		$this->ID_HARDWARE->AdvancedSearch->SearchOperator = $objForm->GetValue("z_ID_HARDWARE");

		// EXTRACCIÓN DE DATOS
		$this->EXTRACCID3N_DE_DATOS->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_EXTRACCID3N_DE_DATOS"));
		$this->EXTRACCID3N_DE_DATOS->AdvancedSearch->SearchOperator = $objForm->GetValue("z_EXTRACCID3N_DE_DATOS");

		// MARCA DE ARRANQUE
		$this->MARCA_DE_ARRANQUE->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_MARCA_DE_ARRANQUE"));
		$this->MARCA_DE_ARRANQUE->AdvancedSearch->SearchOperator = $objForm->GetValue("z_MARCA_DE_ARRANQUE");

		// TITULAR
		$this->TITULAR->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_TITULAR"));
		$this->TITULAR->AdvancedSearch->SearchOperator = $objForm->GetValue("z_TITULAR");

		// SERIE NETBOOK
		$this->SERIE_NETBOOK->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SERIE_NETBOOK"));
		$this->SERIE_NETBOOK->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SERIE_NETBOOK");

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Paquete"));
		$this->Id_Estado_Paquete->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Paquete");

		// CORREO ELECTRONICO/EMAIL
		$this->CORREO_ELECTRONICO2FEMAIL->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_CORREO_ELECTRONICO2FEMAIL"));
		$this->CORREO_ELECTRONICO2FEMAIL->AdvancedSearch->SearchOperator = $objForm->GetValue("z_CORREO_ELECTRONICO2FEMAIL");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Cue
		// Establecimiento
		// Departamento
		// Localidad
		// Motivo Pedido
		// N° de Serie
		// SPECIAL NUMBER o NUMERO ESPECIAL
		// ID HARDWARE
		// EXTRACCIÓN DE DATOS
		// MARCA DE ARRANQUE
		// TITULAR
		// SERIE NETBOOK
		// Id_Estado_Paquete
		// CORREO ELECTRONICO/EMAIL

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Establecimiento
		$this->Establecimiento->ViewValue = $this->Establecimiento->CurrentValue;
		$this->Establecimiento->ViewCustomAttributes = "";

		// Departamento
		$this->Departamento->ViewValue = $this->Departamento->CurrentValue;
		$this->Departamento->ViewCustomAttributes = "";

		// Localidad
		$this->Localidad->ViewValue = $this->Localidad->CurrentValue;
		$this->Localidad->ViewCustomAttributes = "";

		// Motivo Pedido
		if (strval($this->Motivo_Pedido->CurrentValue) <> "") {
			$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->Motivo_Pedido->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Motivo_Pedido->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Motivo_Pedido, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Motivo_Pedido->ViewValue = $this->Motivo_Pedido->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Motivo_Pedido->ViewValue = $this->Motivo_Pedido->CurrentValue;
			}
		} else {
			$this->Motivo_Pedido->ViewValue = NULL;
		}
		$this->Motivo_Pedido->ViewCustomAttributes = "";

		// N° de Serie
		$this->NB0_de_Serie->ViewValue = $this->NB0_de_Serie->CurrentValue;
		$this->NB0_de_Serie->ViewCustomAttributes = "";

		// SPECIAL NUMBER o NUMERO ESPECIAL
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewValue = $this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->CurrentValue;
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->ViewCustomAttributes = "";

		// ID HARDWARE
		$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->CurrentValue;
		if (strval($this->ID_HARDWARE->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->ID_HARDWARE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->ID_HARDWARE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->ID_HARDWARE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->ID_HARDWARE->ViewValue = $this->ID_HARDWARE->CurrentValue;
			}
		} else {
			$this->ID_HARDWARE->ViewValue = NULL;
		}
		$this->ID_HARDWARE->ViewCustomAttributes = "";

		// EXTRACCIÓN DE DATOS
		if (strval($this->EXTRACCID3N_DE_DATOS->CurrentValue) <> "") {
			$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->EXTRACCID3N_DE_DATOS->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->EXTRACCID3N_DE_DATOS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->EXTRACCID3N_DE_DATOS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->EXTRACCID3N_DE_DATOS->ViewValue = $this->EXTRACCID3N_DE_DATOS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->EXTRACCID3N_DE_DATOS->ViewValue = $this->EXTRACCID3N_DE_DATOS->CurrentValue;
			}
		} else {
			$this->EXTRACCID3N_DE_DATOS->ViewValue = NULL;
		}
		$this->EXTRACCID3N_DE_DATOS->ViewCustomAttributes = "";

		// MARCA DE ARRANQUE
		$this->MARCA_DE_ARRANQUE->ViewValue = $this->MARCA_DE_ARRANQUE->CurrentValue;
		$this->MARCA_DE_ARRANQUE->ViewCustomAttributes = "";

		// TITULAR
		$this->TITULAR->ViewValue = $this->TITULAR->CurrentValue;
		$this->TITULAR->ViewCustomAttributes = "";

		// SERIE NETBOOK
		if (strval($this->SERIE_NETBOOK->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->SERIE_NETBOOK->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->SERIE_NETBOOK->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SERIE_NETBOOK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SERIE_NETBOOK->ViewValue = $this->SERIE_NETBOOK->CurrentValue;
			}
		} else {
			$this->SERIE_NETBOOK->ViewValue = NULL;
		}
		$this->SERIE_NETBOOK->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// CORREO ELECTRONICO/EMAIL
		$this->CORREO_ELECTRONICO2FEMAIL->ViewValue = $this->CORREO_ELECTRONICO2FEMAIL->CurrentValue;
		$this->CORREO_ELECTRONICO2FEMAIL->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Establecimiento
			$this->Establecimiento->LinkCustomAttributes = "";
			$this->Establecimiento->HrefValue = "";
			$this->Establecimiento->TooltipValue = "";

			// Departamento
			$this->Departamento->LinkCustomAttributes = "";
			$this->Departamento->HrefValue = "";
			$this->Departamento->TooltipValue = "";

			// Localidad
			$this->Localidad->LinkCustomAttributes = "";
			$this->Localidad->HrefValue = "";
			$this->Localidad->TooltipValue = "";

			// Motivo Pedido
			$this->Motivo_Pedido->LinkCustomAttributes = "";
			$this->Motivo_Pedido->HrefValue = "";
			$this->Motivo_Pedido->TooltipValue = "";

			// N° de Serie
			$this->NB0_de_Serie->LinkCustomAttributes = "";
			$this->NB0_de_Serie->HrefValue = "";
			$this->NB0_de_Serie->TooltipValue = "";

			// SPECIAL NUMBER o NUMERO ESPECIAL
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->LinkCustomAttributes = "";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->HrefValue = "";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->TooltipValue = "";

			// ID HARDWARE
			$this->ID_HARDWARE->LinkCustomAttributes = "";
			$this->ID_HARDWARE->HrefValue = "";
			$this->ID_HARDWARE->TooltipValue = "";

			// EXTRACCIÓN DE DATOS
			$this->EXTRACCID3N_DE_DATOS->LinkCustomAttributes = "";
			$this->EXTRACCID3N_DE_DATOS->HrefValue = "";
			$this->EXTRACCID3N_DE_DATOS->TooltipValue = "";

			// MARCA DE ARRANQUE
			$this->MARCA_DE_ARRANQUE->LinkCustomAttributes = "";
			$this->MARCA_DE_ARRANQUE->HrefValue = "";
			$this->MARCA_DE_ARRANQUE->TooltipValue = "";

			// TITULAR
			$this->TITULAR->LinkCustomAttributes = "";
			$this->TITULAR->HrefValue = "";
			$this->TITULAR->TooltipValue = "";

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->LinkCustomAttributes = "";
			$this->SERIE_NETBOOK->HrefValue = "";
			$this->SERIE_NETBOOK->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// CORREO ELECTRONICO/EMAIL
			$this->CORREO_ELECTRONICO2FEMAIL->LinkCustomAttributes = "";
			$this->CORREO_ELECTRONICO2FEMAIL->HrefValue = "";
			$this->CORREO_ELECTRONICO2FEMAIL->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->AdvancedSearch->SearchValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

			// Establecimiento
			$this->Establecimiento->EditAttrs["class"] = "form-control";
			$this->Establecimiento->EditCustomAttributes = "";
			$this->Establecimiento->EditValue = ew_HtmlEncode($this->Establecimiento->AdvancedSearch->SearchValue);
			$this->Establecimiento->PlaceHolder = ew_RemoveHtml($this->Establecimiento->FldCaption());

			// Departamento
			$this->Departamento->EditAttrs["class"] = "form-control";
			$this->Departamento->EditCustomAttributes = "";
			$this->Departamento->EditValue = ew_HtmlEncode($this->Departamento->AdvancedSearch->SearchValue);
			$this->Departamento->PlaceHolder = ew_RemoveHtml($this->Departamento->FldCaption());

			// Localidad
			$this->Localidad->EditAttrs["class"] = "form-control";
			$this->Localidad->EditCustomAttributes = "";
			$this->Localidad->EditValue = ew_HtmlEncode($this->Localidad->AdvancedSearch->SearchValue);
			$this->Localidad->PlaceHolder = ew_RemoveHtml($this->Localidad->FldCaption());

			// Motivo Pedido
			$this->Motivo_Pedido->EditAttrs["class"] = "form-control";
			$this->Motivo_Pedido->EditCustomAttributes = "";
			if (trim(strval($this->Motivo_Pedido->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->Motivo_Pedido->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Motivo_Pedido->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Motivo_Pedido, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Motivo_Pedido->EditValue = $arwrk;

			// N° de Serie
			$this->NB0_de_Serie->EditAttrs["class"] = "form-control";
			$this->NB0_de_Serie->EditCustomAttributes = "";
			$this->NB0_de_Serie->EditValue = ew_HtmlEncode($this->NB0_de_Serie->AdvancedSearch->SearchValue);
			$this->NB0_de_Serie->PlaceHolder = ew_RemoveHtml($this->NB0_de_Serie->FldCaption());

			// SPECIAL NUMBER o NUMERO ESPECIAL
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->EditAttrs["class"] = "form-control";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->EditCustomAttributes = "";
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->EditValue = ew_HtmlEncode($this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->AdvancedSearch->SearchValue);
			$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->PlaceHolder = ew_RemoveHtml($this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->FldCaption());

			// ID HARDWARE
			$this->ID_HARDWARE->EditAttrs["class"] = "form-control";
			$this->ID_HARDWARE->EditCustomAttributes = "";
			$this->ID_HARDWARE->EditValue = ew_HtmlEncode($this->ID_HARDWARE->AdvancedSearch->SearchValue);
			if (strval($this->ID_HARDWARE->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->ID_HARDWARE->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->ID_HARDWARE->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->ID_HARDWARE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->ID_HARDWARE->EditValue = $this->ID_HARDWARE->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->ID_HARDWARE->EditValue = ew_HtmlEncode($this->ID_HARDWARE->AdvancedSearch->SearchValue);
				}
			} else {
				$this->ID_HARDWARE->EditValue = NULL;
			}
			$this->ID_HARDWARE->PlaceHolder = ew_RemoveHtml($this->ID_HARDWARE->FldCaption());

			// EXTRACCIÓN DE DATOS
			$this->EXTRACCID3N_DE_DATOS->EditAttrs["class"] = "form-control";
			$this->EXTRACCID3N_DE_DATOS->EditCustomAttributes = "";
			if (trim(strval($this->EXTRACCID3N_DE_DATOS->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Detalle`" . ew_SearchString("=", $this->EXTRACCID3N_DE_DATOS->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Detalle`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->EXTRACCID3N_DE_DATOS->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->EXTRACCID3N_DE_DATOS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->EXTRACCID3N_DE_DATOS->EditValue = $arwrk;

			// MARCA DE ARRANQUE
			$this->MARCA_DE_ARRANQUE->EditAttrs["class"] = "form-control";
			$this->MARCA_DE_ARRANQUE->EditCustomAttributes = "";
			$this->MARCA_DE_ARRANQUE->EditValue = ew_HtmlEncode($this->MARCA_DE_ARRANQUE->AdvancedSearch->SearchValue);
			$this->MARCA_DE_ARRANQUE->PlaceHolder = ew_RemoveHtml($this->MARCA_DE_ARRANQUE->FldCaption());

			// TITULAR
			$this->TITULAR->EditAttrs["class"] = "form-control";
			$this->TITULAR->EditCustomAttributes = "";
			$this->TITULAR->EditValue = ew_HtmlEncode($this->TITULAR->AdvancedSearch->SearchValue);
			$this->TITULAR->PlaceHolder = ew_RemoveHtml($this->TITULAR->FldCaption());

			// SERIE NETBOOK
			$this->SERIE_NETBOOK->EditCustomAttributes = "";
			if (trim(strval($this->SERIE_NETBOOK->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->SERIE_NETBOOK->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `equipos`";
			$sWhereWrk = "";
			$this->SERIE_NETBOOK->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->SERIE_NETBOOK, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->SERIE_NETBOOK->AdvancedSearch->ViewValue = $this->SERIE_NETBOOK->DisplayValue($arwrk);
			} else {
				$this->SERIE_NETBOOK->AdvancedSearch->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->SERIE_NETBOOK->EditValue = $arwrk;

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Paquete->EditCustomAttributes = "";
			$this->Id_Estado_Paquete->EditValue = ew_HtmlEncode($this->Id_Estado_Paquete->AdvancedSearch->SearchValue);
			if (strval($this->Id_Estado_Paquete->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Id_Estado_Paquete->EditValue = $this->Id_Estado_Paquete->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Estado_Paquete->EditValue = ew_HtmlEncode($this->Id_Estado_Paquete->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Id_Estado_Paquete->EditValue = NULL;
			}
			$this->Id_Estado_Paquete->PlaceHolder = ew_RemoveHtml($this->Id_Estado_Paquete->FldCaption());

			// CORREO ELECTRONICO/EMAIL
			$this->CORREO_ELECTRONICO2FEMAIL->EditAttrs["class"] = "form-control";
			$this->CORREO_ELECTRONICO2FEMAIL->EditCustomAttributes = "";
			$this->CORREO_ELECTRONICO2FEMAIL->EditValue = ew_HtmlEncode($this->CORREO_ELECTRONICO2FEMAIL->AdvancedSearch->SearchValue);
			$this->CORREO_ELECTRONICO2FEMAIL->PlaceHolder = ew_RemoveHtml($this->CORREO_ELECTRONICO2FEMAIL->FldCaption());
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
		$this->Cue->AdvancedSearch->Load();
		$this->Establecimiento->AdvancedSearch->Load();
		$this->Departamento->AdvancedSearch->Load();
		$this->Localidad->AdvancedSearch->Load();
		$this->Motivo_Pedido->AdvancedSearch->Load();
		$this->NB0_de_Serie->AdvancedSearch->Load();
		$this->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->AdvancedSearch->Load();
		$this->ID_HARDWARE->AdvancedSearch->Load();
		$this->EXTRACCID3N_DE_DATOS->AdvancedSearch->Load();
		$this->MARCA_DE_ARRANQUE->AdvancedSearch->Load();
		$this->TITULAR->AdvancedSearch->Load();
		$this->SERIE_NETBOOK->AdvancedSearch->Load();
		$this->Id_Estado_Paquete->AdvancedSearch->Load();
		$this->CORREO_ELECTRONICO2FEMAIL->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pedido_paqueteslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Motivo_Pedido":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Detalle` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Motivo_Pedido->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Detalle` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Motivo_Pedido, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_ID_HARDWARE":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac` AS `LinkFld`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->ID_HARDWARE->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroMac` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->ID_HARDWARE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_EXTRACCID3N_DE_DATOS":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Detalle` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->EXTRACCID3N_DE_DATOS->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Detalle` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->EXTRACCID3N_DE_DATOS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_SERIE_NETBOOK":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->SERIE_NETBOOK->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->SERIE_NETBOOK, $sWhereWrk); // Call Lookup selecting
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
		case "x_ID_HARDWARE":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroMac` LIKE '{query_value}%'";
			$this->ID_HARDWARE->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->ID_HARDWARE, $sWhereWrk); // Call Lookup selecting
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
if (!isset($pedido_paquetes_search)) $pedido_paquetes_search = new cpedido_paquetes_search();

// Page init
$pedido_paquetes_search->Page_Init();

// Page main
$pedido_paquetes_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pedido_paquetes_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($pedido_paquetes_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fpedido_paquetessearch = new ew_Form("fpedido_paquetessearch", "search");
<?php } else { ?>
var CurrentForm = fpedido_paquetessearch = new ew_Form("fpedido_paquetessearch", "search");
<?php } ?>

// Form_CustomValidate event
fpedido_paquetessearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpedido_paquetessearch.ValidateRequired = true;
<?php } else { ?>
fpedido_paquetessearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpedido_paquetessearch.Lists["x_Motivo_Pedido"] = {"LinkField":"x_Detalle","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpedido_paquetessearch.Lists["x_ID_HARDWARE"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpedido_paquetessearch.Lists["x_EXTRACCID3N_DE_DATOS"] = {"LinkField":"x_Detalle","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpedido_paquetessearch.Lists["x_SERIE_NETBOOK"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
// Validate function for search

fpedido_paquetessearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pedido_paquetes_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pedido_paquetes_search->ShowPageHeader(); ?>
<?php
$pedido_paquetes_search->ShowMessage();
?>
<form name="fpedido_paquetessearch" id="fpedido_paquetessearch" class="<?php echo $pedido_paquetes_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pedido_paquetes_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pedido_paquetes_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pedido_paquetes">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($pedido_paquetes_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pedido_paquetes->Cue->Visible) { // Cue ?>
	<div id="r_Cue" class="form-group">
		<label for="x_Cue" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Cue"><?php echo $pedido_paquetes->Cue->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue" id="z_Cue" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Cue->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Cue">
<input type="text" data-table="pedido_paquetes" data-field="x_Cue" name="x_Cue" id="x_Cue" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->Cue->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->Cue->EditValue ?>"<?php echo $pedido_paquetes->Cue->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Establecimiento->Visible) { // Establecimiento ?>
	<div id="r_Establecimiento" class="form-group">
		<label for="x_Establecimiento" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Establecimiento"><?php echo $pedido_paquetes->Establecimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Establecimiento" id="z_Establecimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Establecimiento->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Establecimiento">
<input type="text" data-table="pedido_paquetes" data-field="x_Establecimiento" name="x_Establecimiento" id="x_Establecimiento" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->Establecimiento->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->Establecimiento->EditValue ?>"<?php echo $pedido_paquetes->Establecimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Departamento->Visible) { // Departamento ?>
	<div id="r_Departamento" class="form-group">
		<label for="x_Departamento" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Departamento"><?php echo $pedido_paquetes->Departamento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Departamento" id="z_Departamento" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Departamento->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Departamento">
<input type="text" data-table="pedido_paquetes" data-field="x_Departamento" name="x_Departamento" id="x_Departamento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->Departamento->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->Departamento->EditValue ?>"<?php echo $pedido_paquetes->Departamento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Localidad->Visible) { // Localidad ?>
	<div id="r_Localidad" class="form-group">
		<label for="x_Localidad" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Localidad"><?php echo $pedido_paquetes->Localidad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Localidad" id="z_Localidad" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Localidad->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Localidad">
<input type="text" data-table="pedido_paquetes" data-field="x_Localidad" name="x_Localidad" id="x_Localidad" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->Localidad->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->Localidad->EditValue ?>"<?php echo $pedido_paquetes->Localidad->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Motivo_Pedido->Visible) { // Motivo Pedido ?>
	<div id="r_Motivo_Pedido" class="form-group">
		<label for="x_Motivo_Pedido" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Motivo_Pedido"><?php echo $pedido_paquetes->Motivo_Pedido->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Motivo_Pedido" id="z_Motivo_Pedido" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Motivo_Pedido->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Motivo_Pedido">
<select data-table="pedido_paquetes" data-field="x_Motivo_Pedido" data-value-separator="<?php echo $pedido_paquetes->Motivo_Pedido->DisplayValueSeparatorAttribute() ?>" id="x_Motivo_Pedido" name="x_Motivo_Pedido"<?php echo $pedido_paquetes->Motivo_Pedido->EditAttributes() ?>>
<?php echo $pedido_paquetes->Motivo_Pedido->SelectOptionListHtml("x_Motivo_Pedido") ?>
</select>
<input type="hidden" name="s_x_Motivo_Pedido" id="s_x_Motivo_Pedido" value="<?php echo $pedido_paquetes->Motivo_Pedido->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->NB0_de_Serie->Visible) { // N° de Serie ?>
	<div id="r_NB0_de_Serie" class="form-group">
		<label for="x_NB0_de_Serie" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_NB0_de_Serie"><?php echo $pedido_paquetes->NB0_de_Serie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NB0_de_Serie" id="z_NB0_de_Serie" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->NB0_de_Serie->CellAttributes() ?>>
			<span id="el_pedido_paquetes_NB0_de_Serie">
<input type="text" data-table="pedido_paquetes" data-field="x_NB0_de_Serie" name="x_NB0_de_Serie" id="x_NB0_de_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->NB0_de_Serie->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->NB0_de_Serie->EditValue ?>"<?php echo $pedido_paquetes->NB0_de_Serie->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->Visible) { // SPECIAL NUMBER o NUMERO ESPECIAL ?>
	<div id="r_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" class="form-group">
		<label for="x_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_SPECIAL_NUMBER_o_NUMERO_ESPECIAL"><?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" id="z_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->CellAttributes() ?>>
			<span id="el_pedido_paquetes_SPECIAL_NUMBER_o_NUMERO_ESPECIAL">
<input type="text" data-table="pedido_paquetes" data-field="x_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" name="x_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" id="x_SPECIAL_NUMBER_o_NUMERO_ESPECIAL" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->EditValue ?>"<?php echo $pedido_paquetes->SPECIAL_NUMBER_o_NUMERO_ESPECIAL->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->ID_HARDWARE->Visible) { // ID HARDWARE ?>
	<div id="r_ID_HARDWARE" class="form-group">
		<label class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_ID_HARDWARE"><?php echo $pedido_paquetes->ID_HARDWARE->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_ID_HARDWARE" id="z_ID_HARDWARE" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->ID_HARDWARE->CellAttributes() ?>>
			<span id="el_pedido_paquetes_ID_HARDWARE">
<?php
$wrkonchange = trim(" " . @$pedido_paquetes->ID_HARDWARE->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pedido_paquetes->ID_HARDWARE->EditAttrs["onchange"] = "";
?>
<span id="as_x_ID_HARDWARE" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_ID_HARDWARE" id="sv_x_ID_HARDWARE" value="<?php echo $pedido_paquetes->ID_HARDWARE->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->ID_HARDWARE->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->ID_HARDWARE->getPlaceHolder()) ?>"<?php echo $pedido_paquetes->ID_HARDWARE->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pedido_paquetes" data-field="x_ID_HARDWARE" data-value-separator="<?php echo $pedido_paquetes->ID_HARDWARE->DisplayValueSeparatorAttribute() ?>" name="x_ID_HARDWARE" id="x_ID_HARDWARE" value="<?php echo ew_HtmlEncode($pedido_paquetes->ID_HARDWARE->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_ID_HARDWARE" id="q_x_ID_HARDWARE" value="<?php echo $pedido_paquetes->ID_HARDWARE->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpedido_paquetessearch.CreateAutoSuggest({"id":"x_ID_HARDWARE","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->EXTRACCID3N_DE_DATOS->Visible) { // EXTRACCIÓN DE DATOS ?>
	<div id="r_EXTRACCID3N_DE_DATOS" class="form-group">
		<label for="x_EXTRACCID3N_DE_DATOS" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_EXTRACCID3N_DE_DATOS"><?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_EXTRACCID3N_DE_DATOS" id="z_EXTRACCID3N_DE_DATOS" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->CellAttributes() ?>>
			<span id="el_pedido_paquetes_EXTRACCID3N_DE_DATOS">
<select data-table="pedido_paquetes" data-field="x_EXTRACCID3N_DE_DATOS" data-value-separator="<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->DisplayValueSeparatorAttribute() ?>" id="x_EXTRACCID3N_DE_DATOS" name="x_EXTRACCID3N_DE_DATOS"<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->EditAttributes() ?>>
<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->SelectOptionListHtml("x_EXTRACCID3N_DE_DATOS") ?>
</select>
<input type="hidden" name="s_x_EXTRACCID3N_DE_DATOS" id="s_x_EXTRACCID3N_DE_DATOS" value="<?php echo $pedido_paquetes->EXTRACCID3N_DE_DATOS->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->MARCA_DE_ARRANQUE->Visible) { // MARCA DE ARRANQUE ?>
	<div id="r_MARCA_DE_ARRANQUE" class="form-group">
		<label for="x_MARCA_DE_ARRANQUE" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_MARCA_DE_ARRANQUE"><?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_MARCA_DE_ARRANQUE" id="z_MARCA_DE_ARRANQUE" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->CellAttributes() ?>>
			<span id="el_pedido_paquetes_MARCA_DE_ARRANQUE">
<input type="text" data-table="pedido_paquetes" data-field="x_MARCA_DE_ARRANQUE" name="x_MARCA_DE_ARRANQUE" id="x_MARCA_DE_ARRANQUE" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->MARCA_DE_ARRANQUE->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->EditValue ?>"<?php echo $pedido_paquetes->MARCA_DE_ARRANQUE->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->TITULAR->Visible) { // TITULAR ?>
	<div id="r_TITULAR" class="form-group">
		<label for="x_TITULAR" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_TITULAR"><?php echo $pedido_paquetes->TITULAR->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_TITULAR" id="z_TITULAR" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->TITULAR->CellAttributes() ?>>
			<span id="el_pedido_paquetes_TITULAR">
<input type="text" data-table="pedido_paquetes" data-field="x_TITULAR" name="x_TITULAR" id="x_TITULAR" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->TITULAR->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->TITULAR->EditValue ?>"<?php echo $pedido_paquetes->TITULAR->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->SERIE_NETBOOK->Visible) { // SERIE NETBOOK ?>
	<div id="r_SERIE_NETBOOK" class="form-group">
		<label for="x_SERIE_NETBOOK" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_SERIE_NETBOOK"><?php echo $pedido_paquetes->SERIE_NETBOOK->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SERIE_NETBOOK" id="z_SERIE_NETBOOK" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->SERIE_NETBOOK->CellAttributes() ?>>
			<span id="el_pedido_paquetes_SERIE_NETBOOK">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_SERIE_NETBOOK"><?php echo (strval($pedido_paquetes->SERIE_NETBOOK->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pedido_paquetes->SERIE_NETBOOK->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pedido_paquetes->SERIE_NETBOOK->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_SERIE_NETBOOK',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pedido_paquetes" data-field="x_SERIE_NETBOOK" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pedido_paquetes->SERIE_NETBOOK->DisplayValueSeparatorAttribute() ?>" name="x_SERIE_NETBOOK" id="x_SERIE_NETBOOK" value="<?php echo $pedido_paquetes->SERIE_NETBOOK->AdvancedSearch->SearchValue ?>"<?php echo $pedido_paquetes->SERIE_NETBOOK->EditAttributes() ?>>
<input type="hidden" name="s_x_SERIE_NETBOOK" id="s_x_SERIE_NETBOOK" value="<?php echo $pedido_paquetes->SERIE_NETBOOK->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<div id="r_Id_Estado_Paquete" class="form-group">
		<label class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_Id_Estado_Paquete"><?php echo $pedido_paquetes->Id_Estado_Paquete->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado_Paquete" id="z_Id_Estado_Paquete" value="="></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->Id_Estado_Paquete->CellAttributes() ?>>
			<span id="el_pedido_paquetes_Id_Estado_Paquete">
<input type="text" data-table="pedido_paquetes" data-field="x_Id_Estado_Paquete" name="x_Id_Estado_Paquete" id="x_Id_Estado_Paquete" size="30" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->Id_Estado_Paquete->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->Id_Estado_Paquete->EditValue ?>"<?php echo $pedido_paquetes->Id_Estado_Paquete->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->Visible) { // CORREO ELECTRONICO/EMAIL ?>
	<div id="r_CORREO_ELECTRONICO2FEMAIL" class="form-group">
		<label for="x_CORREO_ELECTRONICO2FEMAIL" class="<?php echo $pedido_paquetes_search->SearchLabelClass ?>"><span id="elh_pedido_paquetes_CORREO_ELECTRONICO2FEMAIL"><?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_CORREO_ELECTRONICO2FEMAIL" id="z_CORREO_ELECTRONICO2FEMAIL" value="LIKE"></p>
		</label>
		<div class="<?php echo $pedido_paquetes_search->SearchRightColumnClass ?>"><div<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->CellAttributes() ?>>
			<span id="el_pedido_paquetes_CORREO_ELECTRONICO2FEMAIL">
<input type="text" data-table="pedido_paquetes" data-field="x_CORREO_ELECTRONICO2FEMAIL" name="x_CORREO_ELECTRONICO2FEMAIL" id="x_CORREO_ELECTRONICO2FEMAIL" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->getPlaceHolder()) ?>" value="<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->EditValue ?>"<?php echo $pedido_paquetes->CORREO_ELECTRONICO2FEMAIL->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pedido_paquetes_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpedido_paquetessearch.Init();
</script>
<?php
$pedido_paquetes_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pedido_paquetes_search->Page_Terminate();
?>
