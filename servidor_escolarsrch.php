<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "servidor_escolarinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$servidor_escolar_search = NULL; // Initialize page object first

class cservidor_escolar_search extends cservidor_escolar {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'servidor_escolar';

	// Page object name
	var $PageObjName = 'servidor_escolar_search';

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

		// Table object (servidor_escolar)
		if (!isset($GLOBALS["servidor_escolar"]) || get_class($GLOBALS["servidor_escolar"]) == "cservidor_escolar") {
			$GLOBALS["servidor_escolar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["servidor_escolar"];
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
			define("EW_TABLE_NAME", 'servidor_escolar', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("servidor_escolarlist.php"));
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
		$this->Nro_Serie->SetVisibility();
		$this->SN->SetVisibility();
		$this->Cant_Net_Asoc->SetVisibility();
		$this->Id_Marca->SetVisibility();
		$this->Id_Modelo->SetVisibility();
		$this->Id_SO->SetVisibility();
		$this->Id_Estado->SetVisibility();
		$this->User_Server->SetVisibility();
		$this->Pass_Server->SetVisibility();
		$this->User_TdServer->SetVisibility();
		$this->Pass_TdServer->SetVisibility();
		$this->Cue->SetVisibility();
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
		global $EW_EXPORT, $servidor_escolar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($servidor_escolar);
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
						$sSrchStr = "servidor_escolarlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Nro_Serie); // Nro_Serie
		$this->BuildSearchUrl($sSrchUrl, $this->SN); // SN
		$this->BuildSearchUrl($sSrchUrl, $this->Cant_Net_Asoc); // Cant_Net_Asoc
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Marca); // Id_Marca
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Modelo); // Id_Modelo
		$this->BuildSearchUrl($sSrchUrl, $this->Id_SO); // Id_SO
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado); // Id_Estado
		$this->BuildSearchUrl($sSrchUrl, $this->User_Server); // User_Server
		$this->BuildSearchUrl($sSrchUrl, $this->Pass_Server); // Pass_Server
		$this->BuildSearchUrl($sSrchUrl, $this->User_TdServer); // User_TdServer
		$this->BuildSearchUrl($sSrchUrl, $this->Pass_TdServer); // Pass_TdServer
		$this->BuildSearchUrl($sSrchUrl, $this->Cue); // Cue
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
		// Nro_Serie

		$this->Nro_Serie->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nro_Serie"));
		$this->Nro_Serie->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nro_Serie");

		// SN
		$this->SN->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SN"));
		$this->SN->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SN");

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cant_Net_Asoc"));
		$this->Cant_Net_Asoc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cant_Net_Asoc");

		// Id_Marca
		$this->Id_Marca->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Marca"));
		$this->Id_Marca->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Marca");

		// Id_Modelo
		$this->Id_Modelo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Modelo"));
		$this->Id_Modelo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Modelo");

		// Id_SO
		$this->Id_SO->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_SO"));
		$this->Id_SO->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_SO");

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado"));
		$this->Id_Estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado");

		// User_Server
		$this->User_Server->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_User_Server"));
		$this->User_Server->AdvancedSearch->SearchOperator = $objForm->GetValue("z_User_Server");

		// Pass_Server
		$this->Pass_Server->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Pass_Server"));
		$this->Pass_Server->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Pass_Server");

		// User_TdServer
		$this->User_TdServer->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_User_TdServer"));
		$this->User_TdServer->AdvancedSearch->SearchOperator = $objForm->GetValue("z_User_TdServer");

		// Pass_TdServer
		$this->Pass_TdServer->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Pass_TdServer"));
		$this->Pass_TdServer->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Pass_TdServer");

		// Cue
		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue"));
		$this->Cue->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue");

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
		// Nro_Serie
		// SN
		// Cant_Net_Asoc
		// Id_Marca
		// Id_Modelo
		// Id_SO
		// Id_Estado
		// User_Server
		// Pass_Server
		// User_TdServer
		// Pass_TdServer
		// Cue
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Nro_Serie
		$this->Nro_Serie->ViewValue = $this->Nro_Serie->CurrentValue;
		$this->Nro_Serie->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Cant_Net_Asoc
		$this->Cant_Net_Asoc->ViewValue = $this->Cant_Net_Asoc->CurrentValue;
		$this->Cant_Net_Asoc->ViewCustomAttributes = "";

		// Id_Marca
		if (strval($this->Id_Marca->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
		$sWhereWrk = "";
		$this->Id_Marca->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Marca->ViewValue = $this->Id_Marca->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Marca->ViewValue = $this->Id_Marca->CurrentValue;
			}
		} else {
			$this->Id_Marca->ViewValue = NULL;
		}
		$this->Id_Marca->ViewCustomAttributes = "";

		// Id_Modelo
		if (strval($this->Id_Modelo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
		$sWhereWrk = "";
		$this->Id_Modelo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Modelo->ViewValue = $this->Id_Modelo->CurrentValue;
			}
		} else {
			$this->Id_Modelo->ViewValue = NULL;
		}
		$this->Id_Modelo->ViewCustomAttributes = "";

		// Id_SO
		if (strval($this->Id_SO->CurrentValue) <> "") {
			$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
		$sWhereWrk = "";
		$this->Id_SO->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_SO->ViewValue = $this->Id_SO->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_SO->ViewValue = $this->Id_SO->CurrentValue;
			}
		} else {
			$this->Id_SO->ViewValue = NULL;
		}
		$this->Id_SO->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
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

		// User_Server
		$this->User_Server->ViewValue = $this->User_Server->CurrentValue;
		$this->User_Server->ViewCustomAttributes = "";

		// Pass_Server
		$this->Pass_Server->ViewValue = $this->Pass_Server->CurrentValue;
		$this->Pass_Server->ViewCustomAttributes = "";

		// User_TdServer
		$this->User_TdServer->ViewValue = $this->User_TdServer->CurrentValue;
		$this->User_TdServer->ViewCustomAttributes = "";

		// Pass_TdServer
		$this->Pass_TdServer->ViewValue = $this->Pass_TdServer->CurrentValue;
		$this->Pass_TdServer->ViewCustomAttributes = "";

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

			// Nro_Serie
			$this->Nro_Serie->LinkCustomAttributes = "";
			$this->Nro_Serie->HrefValue = "";
			$this->Nro_Serie->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->LinkCustomAttributes = "";
			$this->Cant_Net_Asoc->HrefValue = "";
			$this->Cant_Net_Asoc->TooltipValue = "";

			// Id_Marca
			$this->Id_Marca->LinkCustomAttributes = "";
			$this->Id_Marca->HrefValue = "";
			$this->Id_Marca->TooltipValue = "";

			// Id_Modelo
			$this->Id_Modelo->LinkCustomAttributes = "";
			$this->Id_Modelo->HrefValue = "";
			$this->Id_Modelo->TooltipValue = "";

			// Id_SO
			$this->Id_SO->LinkCustomAttributes = "";
			$this->Id_SO->HrefValue = "";
			$this->Id_SO->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

			// User_Server
			$this->User_Server->LinkCustomAttributes = "";
			$this->User_Server->HrefValue = "";
			$this->User_Server->TooltipValue = "";

			// Pass_Server
			$this->Pass_Server->LinkCustomAttributes = "";
			$this->Pass_Server->HrefValue = "";
			$this->Pass_Server->TooltipValue = "";

			// User_TdServer
			$this->User_TdServer->LinkCustomAttributes = "";
			$this->User_TdServer->HrefValue = "";
			$this->User_TdServer->TooltipValue = "";

			// Pass_TdServer
			$this->Pass_TdServer->LinkCustomAttributes = "";
			$this->Pass_TdServer->HrefValue = "";
			$this->Pass_TdServer->TooltipValue = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Nro_Serie
			$this->Nro_Serie->EditAttrs["class"] = "form-control";
			$this->Nro_Serie->EditCustomAttributes = "";
			$this->Nro_Serie->EditValue = ew_HtmlEncode($this->Nro_Serie->AdvancedSearch->SearchValue);
			$this->Nro_Serie->PlaceHolder = ew_RemoveHtml($this->Nro_Serie->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->AdvancedSearch->SearchValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Cant_Net_Asoc
			$this->Cant_Net_Asoc->EditAttrs["class"] = "form-control";
			$this->Cant_Net_Asoc->EditCustomAttributes = "";
			$this->Cant_Net_Asoc->EditValue = ew_HtmlEncode($this->Cant_Net_Asoc->AdvancedSearch->SearchValue);
			$this->Cant_Net_Asoc->PlaceHolder = ew_RemoveHtml($this->Cant_Net_Asoc->FldCaption());

			// Id_Marca
			$this->Id_Marca->EditAttrs["class"] = "form-control";
			$this->Id_Marca->EditCustomAttributes = "";
			if (trim(strval($this->Id_Marca->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Marca`" . ew_SearchString("=", $this->Id_Marca->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Marca`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca_server`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Marca->EditValue = $arwrk;

			// Id_Modelo
			$this->Id_Modelo->EditAttrs["class"] = "form-control";
			$this->Id_Modelo->EditCustomAttributes = "";
			if (trim(strval($this->Id_Modelo->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Modelo`" . ew_SearchString("=", $this->Id_Modelo->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Modelo`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo_server`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Modelo->EditValue = $arwrk;

			// Id_SO
			$this->Id_SO->EditAttrs["class"] = "form-control";
			$this->Id_SO->EditCustomAttributes = "";
			if (trim(strval($this->Id_SO->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_SO`" . ew_SearchString("=", $this->Id_SO->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_SO`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `so_server`";
			$sWhereWrk = "";
			$this->Id_SO->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_SO->EditValue = $arwrk;

			// Id_Estado
			$this->Id_Estado->EditAttrs["class"] = "form-control";
			$this->Id_Estado->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_server`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado->EditValue = $arwrk;

			// User_Server
			$this->User_Server->EditAttrs["class"] = "form-control";
			$this->User_Server->EditCustomAttributes = "";
			$this->User_Server->EditValue = ew_HtmlEncode($this->User_Server->AdvancedSearch->SearchValue);
			$this->User_Server->PlaceHolder = ew_RemoveHtml($this->User_Server->FldCaption());

			// Pass_Server
			$this->Pass_Server->EditAttrs["class"] = "form-control";
			$this->Pass_Server->EditCustomAttributes = "";
			$this->Pass_Server->EditValue = ew_HtmlEncode($this->Pass_Server->AdvancedSearch->SearchValue);
			$this->Pass_Server->PlaceHolder = ew_RemoveHtml($this->Pass_Server->FldCaption());

			// User_TdServer
			$this->User_TdServer->EditAttrs["class"] = "form-control";
			$this->User_TdServer->EditCustomAttributes = "";
			$this->User_TdServer->EditValue = ew_HtmlEncode($this->User_TdServer->AdvancedSearch->SearchValue);
			$this->User_TdServer->PlaceHolder = ew_RemoveHtml($this->User_TdServer->FldCaption());

			// Pass_TdServer
			$this->Pass_TdServer->EditAttrs["class"] = "form-control";
			$this->Pass_TdServer->EditCustomAttributes = "";
			$this->Pass_TdServer->EditValue = ew_HtmlEncode($this->Pass_TdServer->AdvancedSearch->SearchValue);
			$this->Pass_TdServer->PlaceHolder = ew_RemoveHtml($this->Pass_TdServer->FldCaption());

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->AdvancedSearch->SearchValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

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
		if (!ew_CheckInteger($this->Cant_Net_Asoc->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cant_Net_Asoc->FldErrMsg());
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
		$this->Nro_Serie->AdvancedSearch->Load();
		$this->SN->AdvancedSearch->Load();
		$this->Cant_Net_Asoc->AdvancedSearch->Load();
		$this->Id_Marca->AdvancedSearch->Load();
		$this->Id_Modelo->AdvancedSearch->Load();
		$this->Id_SO->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->User_Server->AdvancedSearch->Load();
		$this->Pass_Server->AdvancedSearch->Load();
		$this->User_TdServer->AdvancedSearch->Load();
		$this->Pass_TdServer->AdvancedSearch->Load();
		$this->Cue->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("servidor_escolarlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Marca":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Marca` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca_server`";
			$sWhereWrk = "";
			$this->Id_Marca->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Marca` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Marca, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Modelo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Modelo` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo_server`";
			$sWhereWrk = "";
			$this->Id_Modelo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Modelo` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Modelo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_SO":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_SO` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `so_server`";
			$sWhereWrk = "";
			$this->Id_SO->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_SO` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_SO, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_server`";
			$sWhereWrk = "";
			$this->Id_Estado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
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
if (!isset($servidor_escolar_search)) $servidor_escolar_search = new cservidor_escolar_search();

// Page init
$servidor_escolar_search->Page_Init();

// Page main
$servidor_escolar_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$servidor_escolar_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($servidor_escolar_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fservidor_escolarsearch = new ew_Form("fservidor_escolarsearch", "search");
<?php } else { ?>
var CurrentForm = fservidor_escolarsearch = new ew_Form("fservidor_escolarsearch", "search");
<?php } ?>

// Form_CustomValidate event
fservidor_escolarsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservidor_escolarsearch.ValidateRequired = true;
<?php } else { ?>
fservidor_escolarsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fservidor_escolarsearch.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca_server"};
fservidor_escolarsearch.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo_server"};
fservidor_escolarsearch.Lists["x_Id_SO"] = {"LinkField":"x_Id_SO","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"so_server"};
fservidor_escolarsearch.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_server"};

// Form object for search
// Validate function for search

fservidor_escolarsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Cant_Net_Asoc");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($servidor_escolar->Cant_Net_Asoc->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$servidor_escolar_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $servidor_escolar_search->ShowPageHeader(); ?>
<?php
$servidor_escolar_search->ShowMessage();
?>
<form name="fservidor_escolarsearch" id="fservidor_escolarsearch" class="<?php echo $servidor_escolar_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($servidor_escolar_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $servidor_escolar_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="servidor_escolar">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($servidor_escolar_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
	<div id="r_Nro_Serie" class="form-group">
		<label for="x_Nro_Serie" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Nro_Serie"><?php echo $servidor_escolar->Nro_Serie->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nro_Serie" id="z_Nro_Serie" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Nro_Serie->CellAttributes() ?>>
			<span id="el_servidor_escolar_Nro_Serie">
<input type="text" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x_Nro_Serie" id="x_Nro_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Nro_Serie->EditValue ?>"<?php echo $servidor_escolar->Nro_Serie->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->SN->Visible) { // SN ?>
	<div id="r_SN" class="form-group">
		<label for="x_SN" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_SN"><?php echo $servidor_escolar->SN->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SN" id="z_SN" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->SN->CellAttributes() ?>>
			<span id="el_servidor_escolar_SN">
<input type="text" data-table="servidor_escolar" data-field="x_SN" name="x_SN" id="x_SN" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->SN->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->SN->EditValue ?>"<?php echo $servidor_escolar->SN->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
	<div id="r_Cant_Net_Asoc" class="form-group">
		<label for="x_Cant_Net_Asoc" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Cant_Net_Asoc"><?php echo $servidor_escolar->Cant_Net_Asoc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cant_Net_Asoc" id="z_Cant_Net_Asoc" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Cant_Net_Asoc->CellAttributes() ?>>
			<span id="el_servidor_escolar_Cant_Net_Asoc">
<input type="text" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x_Cant_Net_Asoc" id="x_Cant_Net_Asoc" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cant_Net_Asoc->EditValue ?>"<?php echo $servidor_escolar->Cant_Net_Asoc->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
	<div id="r_Id_Marca" class="form-group">
		<label for="x_Id_Marca" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Id_Marca"><?php echo $servidor_escolar->Id_Marca->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Marca" id="z_Id_Marca" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Id_Marca->CellAttributes() ?>>
			<span id="el_servidor_escolar_Id_Marca">
<select data-table="servidor_escolar" data-field="x_Id_Marca" data-value-separator="<?php echo $servidor_escolar->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x_Id_Marca" name="x_Id_Marca"<?php echo $servidor_escolar->Id_Marca->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->SelectOptionListHtml("x_Id_Marca") ?>
</select>
<input type="hidden" name="s_x_Id_Marca" id="s_x_Id_Marca" value="<?php echo $servidor_escolar->Id_Marca->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
	<div id="r_Id_Modelo" class="form-group">
		<label for="x_Id_Modelo" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Id_Modelo"><?php echo $servidor_escolar->Id_Modelo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Modelo" id="z_Id_Modelo" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Id_Modelo->CellAttributes() ?>>
			<span id="el_servidor_escolar_Id_Modelo">
<select data-table="servidor_escolar" data-field="x_Id_Modelo" data-value-separator="<?php echo $servidor_escolar->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x_Id_Modelo" name="x_Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->SelectOptionListHtml("x_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x_Id_Modelo" id="s_x_Id_Modelo" value="<?php echo $servidor_escolar->Id_Modelo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
	<div id="r_Id_SO" class="form-group">
		<label for="x_Id_SO" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Id_SO"><?php echo $servidor_escolar->Id_SO->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_SO" id="z_Id_SO" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Id_SO->CellAttributes() ?>>
			<span id="el_servidor_escolar_Id_SO">
<select data-table="servidor_escolar" data-field="x_Id_SO" data-value-separator="<?php echo $servidor_escolar->Id_SO->DisplayValueSeparatorAttribute() ?>" id="x_Id_SO" name="x_Id_SO"<?php echo $servidor_escolar->Id_SO->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->SelectOptionListHtml("x_Id_SO") ?>
</select>
<input type="hidden" name="s_x_Id_SO" id="s_x_Id_SO" value="<?php echo $servidor_escolar->Id_SO->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
	<div id="r_Id_Estado" class="form-group">
		<label for="x_Id_Estado" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Id_Estado"><?php echo $servidor_escolar->Id_Estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado" id="z_Id_Estado" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Id_Estado->CellAttributes() ?>>
			<span id="el_servidor_escolar_Id_Estado">
<select data-table="servidor_escolar" data-field="x_Id_Estado" data-value-separator="<?php echo $servidor_escolar->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado" name="x_Id_Estado"<?php echo $servidor_escolar->Id_Estado->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->SelectOptionListHtml("x_Id_Estado") ?>
</select>
<input type="hidden" name="s_x_Id_Estado" id="s_x_Id_Estado" value="<?php echo $servidor_escolar->Id_Estado->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
	<div id="r_User_Server" class="form-group">
		<label for="x_User_Server" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_User_Server"><?php echo $servidor_escolar->User_Server->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_User_Server" id="z_User_Server" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->User_Server->CellAttributes() ?>>
			<span id="el_servidor_escolar_User_Server">
<input type="text" data-table="servidor_escolar" data-field="x_User_Server" name="x_User_Server" id="x_User_Server" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_Server->EditValue ?>"<?php echo $servidor_escolar->User_Server->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Pass_Server->Visible) { // Pass_Server ?>
	<div id="r_Pass_Server" class="form-group">
		<label for="x_Pass_Server" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Pass_Server"><?php echo $servidor_escolar->Pass_Server->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Pass_Server" id="z_Pass_Server" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Pass_Server->CellAttributes() ?>>
			<span id="el_servidor_escolar_Pass_Server">
<input type="text" data-table="servidor_escolar" data-field="x_Pass_Server" name="x_Pass_Server" id="x_Pass_Server" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Pass_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Pass_Server->EditValue ?>"<?php echo $servidor_escolar->Pass_Server->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
	<div id="r_User_TdServer" class="form-group">
		<label for="x_User_TdServer" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_User_TdServer"><?php echo $servidor_escolar->User_TdServer->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_User_TdServer" id="z_User_TdServer" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->User_TdServer->CellAttributes() ?>>
			<span id="el_servidor_escolar_User_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_User_TdServer" name="x_User_TdServer" id="x_User_TdServer" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_TdServer->EditValue ?>"<?php echo $servidor_escolar->User_TdServer->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Pass_TdServer->Visible) { // Pass_TdServer ?>
	<div id="r_Pass_TdServer" class="form-group">
		<label for="x_Pass_TdServer" class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Pass_TdServer"><?php echo $servidor_escolar->Pass_TdServer->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Pass_TdServer" id="z_Pass_TdServer" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Pass_TdServer->CellAttributes() ?>>
			<span id="el_servidor_escolar_Pass_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_Pass_TdServer" name="x_Pass_TdServer" id="x_Pass_TdServer" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Pass_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Pass_TdServer->EditValue ?>"<?php echo $servidor_escolar->Pass_TdServer->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Cue->Visible) { // Cue ?>
	<div id="r_Cue" class="form-group">
		<label class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Cue"><?php echo $servidor_escolar->Cue->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue" id="z_Cue" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Cue->CellAttributes() ?>>
			<span id="el_servidor_escolar_Cue">
<input type="text" data-table="servidor_escolar" data-field="x_Cue" name="x_Cue" id="x_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cue->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cue->EditValue ?>"<?php echo $servidor_escolar->Cue->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Fecha_Actualizacion"><?php echo $servidor_escolar->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_servidor_escolar_Fecha_Actualizacion">
<input type="text" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Fecha_Actualizacion->EditValue ?>"<?php echo $servidor_escolar->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $servidor_escolar_search->SearchLabelClass ?>"><span id="elh_servidor_escolar_Usuario"><?php echo $servidor_escolar->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $servidor_escolar_search->SearchRightColumnClass ?>"><div<?php echo $servidor_escolar->Usuario->CellAttributes() ?>>
			<span id="el_servidor_escolar_Usuario">
<input type="text" data-table="servidor_escolar" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Usuario->EditValue ?>"<?php echo $servidor_escolar->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$servidor_escolar_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fservidor_escolarsearch.Init();
</script>
<?php
$servidor_escolar_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$servidor_escolar_search->Page_Terminate();
?>
