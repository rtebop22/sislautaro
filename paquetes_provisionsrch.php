<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "paquetes_provisioninfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$paquetes_provision_search = NULL; // Initialize page object first

class cpaquetes_provision_search extends cpaquetes_provision {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'paquetes_provision';

	// Page object name
	var $PageObjName = 'paquetes_provision_search';

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

		// Table object (paquetes_provision)
		if (!isset($GLOBALS["paquetes_provision"]) || get_class($GLOBALS["paquetes_provision"]) == "cpaquetes_provision") {
			$GLOBALS["paquetes_provision"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["paquetes_provision"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'paquetes_provision', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("paquetes_provisionlist.php"));
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
		$this->NroPedido->SetVisibility();
		$this->NroPedido->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Netbook->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Serie_Server->SetVisibility();
		$this->Id_Motivo->SetVisibility();
		$this->Id_Tipo_Extraccion->SetVisibility();
		$this->Id_Estado_Paquete->SetVisibility();
		$this->Id_Tipo_Paquete->SetVisibility();
		$this->Apellido_Nombre_Solicitante->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Email_Solicitante->SetVisibility();
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
		global $EW_EXPORT, $paquetes_provision;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($paquetes_provision);
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
						$sSrchStr = "paquetes_provisionlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NroPedido); // NroPedido
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Netbook); // Serie_Netbook
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Hardware); // Id_Hardware
		$this->BuildSearchUrl($sSrchUrl, $this->SN); // SN
		$this->BuildSearchUrl($sSrchUrl, $this->Marca_Arranque); // Marca_Arranque
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Server); // Serie_Server
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Motivo); // Id_Motivo
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Extraccion); // Id_Tipo_Extraccion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Paquete); // Id_Estado_Paquete
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Paquete); // Id_Tipo_Paquete
		$this->BuildSearchUrl($sSrchUrl, $this->Apellido_Nombre_Solicitante); // Apellido_Nombre_Solicitante
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Email_Solicitante); // Email_Solicitante
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
		// NroPedido

		$this->NroPedido->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NroPedido"));
		$this->NroPedido->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NroPedido");

		// Serie_Netbook
		$this->Serie_Netbook->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Netbook"));
		$this->Serie_Netbook->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Netbook");

		// Id_Hardware
		$this->Id_Hardware->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Hardware"));
		$this->Id_Hardware->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Hardware");

		// SN
		$this->SN->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SN"));
		$this->SN->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SN");

		// Marca_Arranque
		$this->Marca_Arranque->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Marca_Arranque"));
		$this->Marca_Arranque->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Marca_Arranque");

		// Serie_Server
		$this->Serie_Server->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Server"));
		$this->Serie_Server->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Server");

		// Id_Motivo
		$this->Id_Motivo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Motivo"));
		$this->Id_Motivo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Motivo");

		// Id_Tipo_Extraccion
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Extraccion"));
		$this->Id_Tipo_Extraccion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Extraccion");

		// Id_Estado_Paquete
		$this->Id_Estado_Paquete->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Paquete"));
		$this->Id_Estado_Paquete->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Paquete");

		// Id_Tipo_Paquete
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Paquete"));
		$this->Id_Tipo_Paquete->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Paquete");

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Apellido_Nombre_Solicitante"));
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Apellido_Nombre_Solicitante");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Email_Solicitante
		$this->Email_Solicitante->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Email_Solicitante"));
		$this->Email_Solicitante->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Email_Solicitante");

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
		// NroPedido
		// Serie_Netbook
		// Id_Hardware
		// SN
		// Marca_Arranque
		// Serie_Server
		// Id_Motivo
		// Id_Tipo_Extraccion
		// Id_Estado_Paquete
		// Id_Tipo_Paquete
		// Apellido_Nombre_Solicitante
		// Dni
		// Email_Solicitante
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NroPedido
		$this->NroPedido->ViewValue = $this->NroPedido->CurrentValue;
		$this->NroPedido->ViewCustomAttributes = "";

		// Serie_Netbook
		$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
		if (strval($this->Serie_Netbook->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Netbook->ViewValue = $this->Serie_Netbook->CurrentValue;
			}
		} else {
			$this->Serie_Netbook->ViewValue = NULL;
		}
		$this->Serie_Netbook->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		if (strval($this->Id_Hardware->CurrentValue) <> "") {
			$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Id_Hardware->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
			}
		} else {
			$this->Id_Hardware->ViewValue = NULL;
		}
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Serie_Server
		$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
		if (strval($this->Serie_Server->CurrentValue) <> "") {
			$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
		$sWhereWrk = "";
		$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Server->ViewValue = $this->Serie_Server->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Server->ViewValue = $this->Serie_Server->CurrentValue;
			}
		} else {
			$this->Serie_Server->ViewValue = NULL;
		}
		$this->Serie_Server->ViewCustomAttributes = "";

		// Id_Motivo
		if (strval($this->Id_Motivo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
		$sWhereWrk = "";
		$this->Id_Motivo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo->ViewValue = $this->Id_Motivo->CurrentValue;
			}
		} else {
			$this->Id_Motivo->ViewValue = NULL;
		}
		$this->Id_Motivo->ViewCustomAttributes = "";

		// Id_Tipo_Extraccion
		if (strval($this->Id_Tipo_Extraccion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
		$sWhereWrk = "";
		$this->Id_Tipo_Extraccion->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Extraccion->ViewValue = $this->Id_Tipo_Extraccion->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Extraccion->ViewValue = NULL;
		}
		$this->Id_Tipo_Extraccion->ViewCustomAttributes = "";

		// Id_Estado_Paquete
		if (strval($this->Id_Estado_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
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
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Paquete->ViewValue = $this->Id_Estado_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Estado_Paquete->ViewValue = NULL;
		}
		$this->Id_Estado_Paquete->ViewCustomAttributes = "";

		// Id_Tipo_Paquete
		if (strval($this->Id_Tipo_Paquete->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
		$sWhereWrk = "";
		$this->Id_Tipo_Paquete->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Paquete->ViewValue = $this->Id_Tipo_Paquete->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Paquete->ViewValue = NULL;
		}
		$this->Id_Tipo_Paquete->ViewCustomAttributes = "";

		// Apellido_Nombre_Solicitante
		$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
		if (strval($this->Apellido_Nombre_Solicitante->CurrentValue) <> "") {
			$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
		$sWhereWrk = "";
		$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Apellido_Nombre_Solicitante->ViewValue = $this->Apellido_Nombre_Solicitante->CurrentValue;
			}
		} else {
			$this->Apellido_Nombre_Solicitante->ViewValue = NULL;
		}
		$this->Apellido_Nombre_Solicitante->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Email_Solicitante
		$this->Email_Solicitante->ViewValue = $this->Email_Solicitante->CurrentValue;
		$this->Email_Solicitante->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// NroPedido
			$this->NroPedido->LinkCustomAttributes = "";
			$this->NroPedido->HrefValue = "";
			$this->NroPedido->TooltipValue = "";

			// Serie_Netbook
			$this->Serie_Netbook->LinkCustomAttributes = "";
			$this->Serie_Netbook->HrefValue = "";
			$this->Serie_Netbook->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";
			$this->Marca_Arranque->TooltipValue = "";

			// Serie_Server
			$this->Serie_Server->LinkCustomAttributes = "";
			$this->Serie_Server->HrefValue = "";
			$this->Serie_Server->TooltipValue = "";

			// Id_Motivo
			$this->Id_Motivo->LinkCustomAttributes = "";
			$this->Id_Motivo->HrefValue = "";
			$this->Id_Motivo->TooltipValue = "";

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->LinkCustomAttributes = "";
			$this->Id_Tipo_Extraccion->HrefValue = "";
			$this->Id_Tipo_Extraccion->TooltipValue = "";

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->LinkCustomAttributes = "";
			$this->Id_Estado_Paquete->HrefValue = "";
			$this->Id_Estado_Paquete->TooltipValue = "";

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->LinkCustomAttributes = "";
			$this->Id_Tipo_Paquete->HrefValue = "";
			$this->Id_Tipo_Paquete->TooltipValue = "";

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->LinkCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->HrefValue = "";
			$this->Apellido_Nombre_Solicitante->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Email_Solicitante
			$this->Email_Solicitante->LinkCustomAttributes = "";
			$this->Email_Solicitante->HrefValue = "";
			$this->Email_Solicitante->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// NroPedido
			$this->NroPedido->EditAttrs["class"] = "form-control";
			$this->NroPedido->EditCustomAttributes = "";
			$this->NroPedido->EditValue = ew_HtmlEncode($this->NroPedido->AdvancedSearch->SearchValue);
			$this->NroPedido->PlaceHolder = ew_RemoveHtml($this->NroPedido->FldCaption());

			// Serie_Netbook
			$this->Serie_Netbook->EditAttrs["class"] = "form-control";
			$this->Serie_Netbook->EditCustomAttributes = "";
			$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->AdvancedSearch->SearchValue);
			if (strval($this->Serie_Netbook->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Netbook->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Netbook->EditValue = $this->Serie_Netbook->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Netbook->EditValue = ew_HtmlEncode($this->Serie_Netbook->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Serie_Netbook->EditValue = NULL;
			}
			$this->Serie_Netbook->PlaceHolder = ew_RemoveHtml($this->Serie_Netbook->FldCaption());

			// Id_Hardware
			$this->Id_Hardware->EditAttrs["class"] = "form-control";
			$this->Id_Hardware->EditCustomAttributes = "";
			$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->AdvancedSearch->SearchValue);
			if (strval($this->Id_Hardware->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroMac`" . ew_SearchString("=", $this->Id_Hardware->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Id_Hardware->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Id_Hardware->EditValue = $this->Id_Hardware->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Id_Hardware->EditValue = NULL;
			}
			$this->Id_Hardware->PlaceHolder = ew_RemoveHtml($this->Id_Hardware->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->AdvancedSearch->SearchValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Marca_Arranque
			$this->Marca_Arranque->EditAttrs["class"] = "form-control";
			$this->Marca_Arranque->EditCustomAttributes = "";
			$this->Marca_Arranque->EditValue = ew_HtmlEncode($this->Marca_Arranque->AdvancedSearch->SearchValue);
			$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

			// Serie_Server
			$this->Serie_Server->EditAttrs["class"] = "form-control";
			$this->Serie_Server->EditCustomAttributes = "";
			$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->AdvancedSearch->SearchValue);
			if (strval($this->Serie_Server->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Nro_Serie`" . ew_SearchString("=", $this->Serie_Server->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
			$sWhereWrk = "";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Server->EditValue = $this->Serie_Server->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Server->EditValue = ew_HtmlEncode($this->Serie_Server->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Serie_Server->EditValue = NULL;
			}
			$this->Serie_Server->PlaceHolder = ew_RemoveHtml($this->Serie_Server->FldCaption());

			// Id_Motivo
			$this->Id_Motivo->EditAttrs["class"] = "form-control";
			$this->Id_Motivo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo`" . ew_SearchString("=", $this->Id_Motivo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo->EditValue = $arwrk;

			// Id_Tipo_Extraccion
			$this->Id_Tipo_Extraccion->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Extraccion->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Extraccion`" . ew_SearchString("=", $this->Id_Tipo_Extraccion->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Extraccion`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->Id_Tipo_Extraccion->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Extraccion->EditValue = $arwrk;

			// Id_Estado_Paquete
			$this->Id_Estado_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Paquete->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Paquete`" . ew_SearchString("=", $this->Id_Estado_Paquete->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Paquete->EditValue = $arwrk;

			// Id_Tipo_Paquete
			$this->Id_Tipo_Paquete->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Paquete->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Paquete->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Paquete`" . ew_SearchString("=", $this->Id_Tipo_Paquete->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Paquete`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_paquete`";
			$sWhereWrk = "";
			$this->Id_Tipo_Paquete->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Paquete->EditValue = $arwrk;

			// Apellido_Nombre_Solicitante
			$this->Apellido_Nombre_Solicitante->EditAttrs["class"] = "form-control";
			$this->Apellido_Nombre_Solicitante->EditCustomAttributes = "";
			$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue);
			if (strval($this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellido_Nombre`" . ew_SearchString("=", $this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Apellido_Nombre_Solicitante->EditValue = $this->Apellido_Nombre_Solicitante->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Apellido_Nombre_Solicitante->EditValue = ew_HtmlEncode($this->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Apellido_Nombre_Solicitante->EditValue = NULL;
			}
			$this->Apellido_Nombre_Solicitante->PlaceHolder = ew_RemoveHtml($this->Apellido_Nombre_Solicitante->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Email_Solicitante
			$this->Email_Solicitante->EditAttrs["class"] = "form-control";
			$this->Email_Solicitante->EditCustomAttributes = "";
			$this->Email_Solicitante->EditValue = ew_HtmlEncode($this->Email_Solicitante->AdvancedSearch->SearchValue);
			$this->Email_Solicitante->PlaceHolder = ew_RemoveHtml($this->Email_Solicitante->FldCaption());

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
		$this->NroPedido->AdvancedSearch->Load();
		$this->Serie_Netbook->AdvancedSearch->Load();
		$this->Id_Hardware->AdvancedSearch->Load();
		$this->SN->AdvancedSearch->Load();
		$this->Marca_Arranque->AdvancedSearch->Load();
		$this->Serie_Server->AdvancedSearch->Load();
		$this->Id_Motivo->AdvancedSearch->Load();
		$this->Id_Tipo_Extraccion->AdvancedSearch->Load();
		$this->Id_Estado_Paquete->AdvancedSearch->Load();
		$this->Id_Tipo_Paquete->AdvancedSearch->Load();
		$this->Apellido_Nombre_Solicitante->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Email_Solicitante->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("paquetes_provisionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Serie_Netbook":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Hardware":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac` AS `LinkFld`, `NroMac` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Id_Hardware->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroMac` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Serie_Server":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nro_Serie` AS `LinkFld`, `Nro_Serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `servidor_escolar`";
			$sWhereWrk = "{filter}";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nro_Serie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_pedido_paquetes`";
			$sWhereWrk = "";
			$this->Id_Motivo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Extraccion":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Extraccion` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_extraccion`";
			$sWhereWrk = "";
			$this->Id_Tipo_Extraccion->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Extraccion` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Extraccion, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Paquete":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Paquete` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_paquete`";
			$sWhereWrk = "";
			$this->Id_Estado_Paquete->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Paquete` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Detalle` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Paquete":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Paquete` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_paquete`";
			$sWhereWrk = "";
			$this->Id_Tipo_Paquete->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Paquete` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Paquete, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Apellido_Nombre_Solicitante":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellido_Nombre` AS `LinkFld`, `Apellido_Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `referente_tecnico`";
			$sWhereWrk = "{filter}";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellido_Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
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
		case "x_Serie_Netbook":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->Serie_Netbook->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Netbook, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Hardware":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroMac`, `NroMac` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroMac` LIKE '{query_value}%'";
			$this->Id_Hardware->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Hardware, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Serie_Server":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nro_Serie`, `Nro_Serie` AS `DispFld` FROM `servidor_escolar`";
			$sWhereWrk = "`Nro_Serie` LIKE '{query_value}%'";
			$this->Serie_Server->LookupFilters = array("dx1" => "`Nro_Serie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Server, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Apellido_Nombre_Solicitante":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellido_Nombre`, `Apellido_Nombre` AS `DispFld` FROM `referente_tecnico`";
			$sWhereWrk = "`Apellido_Nombre` LIKE '{query_value}%'";
			$this->Apellido_Nombre_Solicitante->LookupFilters = array("dx1" => "`Apellido_Nombre`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Apellido_Nombre_Solicitante, $sWhereWrk); // Call Lookup selecting
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
if (!isset($paquetes_provision_search)) $paquetes_provision_search = new cpaquetes_provision_search();

// Page init
$paquetes_provision_search->Page_Init();

// Page main
$paquetes_provision_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$paquetes_provision_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($paquetes_provision_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fpaquetes_provisionsearch = new ew_Form("fpaquetes_provisionsearch", "search");
<?php } else { ?>
var CurrentForm = fpaquetes_provisionsearch = new ew_Form("fpaquetes_provisionsearch", "search");
<?php } ?>

// Form_CustomValidate event
fpaquetes_provisionsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpaquetes_provisionsearch.ValidateRequired = true;
<?php } else { ?>
fpaquetes_provisionsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpaquetes_provisionsearch.Lists["x_Serie_Netbook"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisionsearch.Lists["x_Id_Hardware"] = {"LinkField":"x_NroMac","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroMac","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpaquetes_provisionsearch.Lists["x_Serie_Server"] = {"LinkField":"x_Nro_Serie","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nro_Serie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"servidor_escolar"};
fpaquetes_provisionsearch.Lists["x_Id_Motivo"] = {"LinkField":"x_Id_Motivo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_pedido_paquetes"};
fpaquetes_provisionsearch.Lists["x_Id_Tipo_Extraccion"] = {"LinkField":"x_Id_Tipo_Extraccion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_extraccion"};
fpaquetes_provisionsearch.Lists["x_Id_Estado_Paquete"] = {"LinkField":"x_Id_Estado_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_paquete"};
fpaquetes_provisionsearch.Lists["x_Id_Tipo_Paquete"] = {"LinkField":"x_Id_Tipo_Paquete","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_paquete"};
fpaquetes_provisionsearch.Lists["x_Apellido_Nombre_Solicitante"] = {"LinkField":"x_Apellido_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellido_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"referente_tecnico"};

// Form object for search
// Validate function for search

fpaquetes_provisionsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($paquetes_provision->Dni->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$paquetes_provision_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $paquetes_provision_search->ShowPageHeader(); ?>
<?php
$paquetes_provision_search->ShowMessage();
?>
<form name="fpaquetes_provisionsearch" id="fpaquetes_provisionsearch" class="<?php echo $paquetes_provision_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($paquetes_provision_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $paquetes_provision_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="paquetes_provision">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($paquetes_provision_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($paquetes_provision->NroPedido->Visible) { // NroPedido ?>
	<div id="r_NroPedido" class="form-group">
		<label for="x_NroPedido" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_NroPedido"><?php echo $paquetes_provision->NroPedido->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NroPedido" id="z_NroPedido" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->NroPedido->CellAttributes() ?>>
			<span id="el_paquetes_provision_NroPedido">
<input type="text" data-table="paquetes_provision" data-field="x_NroPedido" name="x_NroPedido" id="x_NroPedido" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->NroPedido->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->NroPedido->EditValue ?>"<?php echo $paquetes_provision->NroPedido->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Serie_Netbook->Visible) { // Serie_Netbook ?>
	<div id="r_Serie_Netbook" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Serie_Netbook"><?php echo $paquetes_provision->Serie_Netbook->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Netbook" id="z_Serie_Netbook" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Serie_Netbook->CellAttributes() ?>>
			<span id="el_paquetes_provision_Serie_Netbook">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Serie_Netbook"><?php echo (strval($paquetes_provision->Serie_Netbook->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Netbook->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Netbook->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Serie_Netbook',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Netbook" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Netbook->DisplayValueSeparatorAttribute() ?>" name="x_Serie_Netbook" id="x_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->AdvancedSearch->SearchValue ?>"<?php echo $paquetes_provision->Serie_Netbook->EditAttributes() ?>>
<input type="hidden" name="s_x_Serie_Netbook" id="s_x_Serie_Netbook" value="<?php echo $paquetes_provision->Serie_Netbook->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Id_Hardware->Visible) { // Id_Hardware ?>
	<div id="r_Id_Hardware" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Id_Hardware"><?php echo $paquetes_provision->Id_Hardware->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Hardware" id="z_Id_Hardware" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Id_Hardware->CellAttributes() ?>>
			<span id="el_paquetes_provision_Id_Hardware">
<?php
$wrkonchange = trim(" " . @$paquetes_provision->Id_Hardware->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$paquetes_provision->Id_Hardware->EditAttrs["onchange"] = "";
?>
<span id="as_x_Id_Hardware" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_Id_Hardware" id="sv_x_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->getPlaceHolder()) ?>"<?php echo $paquetes_provision->Id_Hardware->EditAttributes() ?>>
</span>
<input type="hidden" data-table="paquetes_provision" data-field="x_Id_Hardware" data-value-separator="<?php echo $paquetes_provision->Id_Hardware->DisplayValueSeparatorAttribute() ?>" name="x_Id_Hardware" id="x_Id_Hardware" value="<?php echo ew_HtmlEncode($paquetes_provision->Id_Hardware->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_Id_Hardware" id="q_x_Id_Hardware" value="<?php echo $paquetes_provision->Id_Hardware->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fpaquetes_provisionsearch.CreateAutoSuggest({"id":"x_Id_Hardware","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->SN->Visible) { // SN ?>
	<div id="r_SN" class="form-group">
		<label for="x_SN" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_SN"><?php echo $paquetes_provision->SN->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SN" id="z_SN" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->SN->CellAttributes() ?>>
			<span id="el_paquetes_provision_SN">
<input type="text" data-table="paquetes_provision" data-field="x_SN" name="x_SN" id="x_SN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->SN->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->SN->EditValue ?>"<?php echo $paquetes_provision->SN->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<div id="r_Marca_Arranque" class="form-group">
		<label for="x_Marca_Arranque" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Marca_Arranque"><?php echo $paquetes_provision->Marca_Arranque->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Marca_Arranque" id="z_Marca_Arranque" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Marca_Arranque->CellAttributes() ?>>
			<span id="el_paquetes_provision_Marca_Arranque">
<input type="text" data-table="paquetes_provision" data-field="x_Marca_Arranque" name="x_Marca_Arranque" id="x_Marca_Arranque" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Marca_Arranque->EditValue ?>"<?php echo $paquetes_provision->Marca_Arranque->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Serie_Server->Visible) { // Serie_Server ?>
	<div id="r_Serie_Server" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Serie_Server"><?php echo $paquetes_provision->Serie_Server->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Server" id="z_Serie_Server" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Serie_Server->CellAttributes() ?>>
			<span id="el_paquetes_provision_Serie_Server">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Serie_Server"><?php echo (strval($paquetes_provision->Serie_Server->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Serie_Server->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Serie_Server->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Serie_Server',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Serie_Server" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Serie_Server->DisplayValueSeparatorAttribute() ?>" name="x_Serie_Server" id="x_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->AdvancedSearch->SearchValue ?>"<?php echo $paquetes_provision->Serie_Server->EditAttributes() ?>>
<input type="hidden" name="s_x_Serie_Server" id="s_x_Serie_Server" value="<?php echo $paquetes_provision->Serie_Server->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Id_Motivo->Visible) { // Id_Motivo ?>
	<div id="r_Id_Motivo" class="form-group">
		<label for="x_Id_Motivo" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Id_Motivo"><?php echo $paquetes_provision->Id_Motivo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Motivo" id="z_Id_Motivo" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Id_Motivo->CellAttributes() ?>>
			<span id="el_paquetes_provision_Id_Motivo">
<select data-table="paquetes_provision" data-field="x_Id_Motivo" data-value-separator="<?php echo $paquetes_provision->Id_Motivo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo" name="x_Id_Motivo"<?php echo $paquetes_provision->Id_Motivo->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Motivo->SelectOptionListHtml("x_Id_Motivo") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo" id="s_x_Id_Motivo" value="<?php echo $paquetes_provision->Id_Motivo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Extraccion->Visible) { // Id_Tipo_Extraccion ?>
	<div id="r_Id_Tipo_Extraccion" class="form-group">
		<label for="x_Id_Tipo_Extraccion" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Id_Tipo_Extraccion"><?php echo $paquetes_provision->Id_Tipo_Extraccion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Tipo_Extraccion" id="z_Id_Tipo_Extraccion" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Id_Tipo_Extraccion->CellAttributes() ?>>
			<span id="el_paquetes_provision_Id_Tipo_Extraccion">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Extraccion" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Extraccion->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Extraccion" name="x_Id_Tipo_Extraccion"<?php echo $paquetes_provision->Id_Tipo_Extraccion->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Extraccion->SelectOptionListHtml("x_Id_Tipo_Extraccion") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Extraccion" id="s_x_Id_Tipo_Extraccion" value="<?php echo $paquetes_provision->Id_Tipo_Extraccion->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Id_Estado_Paquete->Visible) { // Id_Estado_Paquete ?>
	<div id="r_Id_Estado_Paquete" class="form-group">
		<label for="x_Id_Estado_Paquete" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Id_Estado_Paquete"><?php echo $paquetes_provision->Id_Estado_Paquete->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado_Paquete" id="z_Id_Estado_Paquete" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Id_Estado_Paquete->CellAttributes() ?>>
			<span id="el_paquetes_provision_Id_Estado_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Estado_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Estado_Paquete->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Paquete" name="x_Id_Estado_Paquete"<?php echo $paquetes_provision->Id_Estado_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Estado_Paquete->SelectOptionListHtml("x_Id_Estado_Paquete") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Paquete" id="s_x_Id_Estado_Paquete" value="<?php echo $paquetes_provision->Id_Estado_Paquete->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Id_Tipo_Paquete->Visible) { // Id_Tipo_Paquete ?>
	<div id="r_Id_Tipo_Paquete" class="form-group">
		<label for="x_Id_Tipo_Paquete" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Id_Tipo_Paquete"><?php echo $paquetes_provision->Id_Tipo_Paquete->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Tipo_Paquete" id="z_Id_Tipo_Paquete" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Id_Tipo_Paquete->CellAttributes() ?>>
			<span id="el_paquetes_provision_Id_Tipo_Paquete">
<select data-table="paquetes_provision" data-field="x_Id_Tipo_Paquete" data-value-separator="<?php echo $paquetes_provision->Id_Tipo_Paquete->DisplayValueSeparatorAttribute() ?>" id="x_Id_Tipo_Paquete" name="x_Id_Tipo_Paquete"<?php echo $paquetes_provision->Id_Tipo_Paquete->EditAttributes() ?>>
<?php echo $paquetes_provision->Id_Tipo_Paquete->SelectOptionListHtml("x_Id_Tipo_Paquete") ?>
</select>
<input type="hidden" name="s_x_Id_Tipo_Paquete" id="s_x_Id_Tipo_Paquete" value="<?php echo $paquetes_provision->Id_Tipo_Paquete->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Apellido_Nombre_Solicitante->Visible) { // Apellido_Nombre_Solicitante ?>
	<div id="r_Apellido_Nombre_Solicitante" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Apellido_Nombre_Solicitante"><?php echo $paquetes_provision->Apellido_Nombre_Solicitante->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Apellido_Nombre_Solicitante" id="z_Apellido_Nombre_Solicitante" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->CellAttributes() ?>>
			<span id="el_paquetes_provision_Apellido_Nombre_Solicitante">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Apellido_Nombre_Solicitante"><?php echo (strval($paquetes_provision->Apellido_Nombre_Solicitante->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $paquetes_provision->Apellido_Nombre_Solicitante->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($paquetes_provision->Apellido_Nombre_Solicitante->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Apellido_Nombre_Solicitante',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="paquetes_provision" data-field="x_Apellido_Nombre_Solicitante" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->DisplayValueSeparatorAttribute() ?>" name="x_Apellido_Nombre_Solicitante" id="x_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->AdvancedSearch->SearchValue ?>"<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->EditAttributes() ?>>
<input type="hidden" name="s_x_Apellido_Nombre_Solicitante" id="s_x_Apellido_Nombre_Solicitante" value="<?php echo $paquetes_provision->Apellido_Nombre_Solicitante->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Dni"><?php echo $paquetes_provision->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Dni->CellAttributes() ?>>
			<span id="el_paquetes_provision_Dni">
<input type="text" data-table="paquetes_provision" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Dni->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Dni->EditValue ?>"<?php echo $paquetes_provision->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Email_Solicitante->Visible) { // Email_Solicitante ?>
	<div id="r_Email_Solicitante" class="form-group">
		<label for="x_Email_Solicitante" class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Email_Solicitante"><?php echo $paquetes_provision->Email_Solicitante->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Email_Solicitante" id="z_Email_Solicitante" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Email_Solicitante->CellAttributes() ?>>
			<span id="el_paquetes_provision_Email_Solicitante">
<input type="text" data-table="paquetes_provision" data-field="x_Email_Solicitante" name="x_Email_Solicitante" id="x_Email_Solicitante" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Email_Solicitante->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Email_Solicitante->EditValue ?>"<?php echo $paquetes_provision->Email_Solicitante->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Usuario"><?php echo $paquetes_provision->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Usuario->CellAttributes() ?>>
			<span id="el_paquetes_provision_Usuario">
<input type="text" data-table="paquetes_provision" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Usuario->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Usuario->EditValue ?>"<?php echo $paquetes_provision->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($paquetes_provision->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $paquetes_provision_search->SearchLabelClass ?>"><span id="elh_paquetes_provision_Fecha_Actualizacion"><?php echo $paquetes_provision->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $paquetes_provision_search->SearchRightColumnClass ?>"><div<?php echo $paquetes_provision->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_paquetes_provision_Fecha_Actualizacion">
<input type="text" data-table="paquetes_provision" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($paquetes_provision->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $paquetes_provision->Fecha_Actualizacion->EditValue ?>"<?php echo $paquetes_provision->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$paquetes_provision_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpaquetes_provisionsearch.Init();
</script>
<?php
$paquetes_provision_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$paquetes_provision_search->Page_Terminate();
?>
