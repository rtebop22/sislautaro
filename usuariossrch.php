<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$usuarios_search = NULL; // Initialize page object first

class cusuarios_search extends cusuarios {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'usuarios';

	// Page object name
	var $PageObjName = 'usuarios_search';

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

		// Table object (usuarios)
		if (!isset($GLOBALS["usuarios"]) || get_class($GLOBALS["usuarios"]) == "cusuarios") {
			$GLOBALS["usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuarios"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuarios', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("usuarioslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("usuarioslist.php"));
			}
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NombreTitular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Nombre->SetVisibility();
		$this->Password->SetVisibility();
		$this->Nivel_Usuario->SetVisibility();
		$this->Curso->SetVisibility();
		$this->Turno->SetVisibility();
		$this->Division->SetVisibility();

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
		global $EW_EXPORT, $usuarios;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($usuarios);
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
						$sSrchStr = "usuarioslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NombreTitular); // NombreTitular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni); // Dni
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre); // Nombre
		$this->BuildSearchUrl($sSrchUrl, $this->Password); // Password
		$this->BuildSearchUrl($sSrchUrl, $this->Nivel_Usuario); // Nivel_Usuario
		$this->BuildSearchUrl($sSrchUrl, $this->Curso); // Curso
		$this->BuildSearchUrl($sSrchUrl, $this->Turno); // Turno
		$this->BuildSearchUrl($sSrchUrl, $this->Division); // Division
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
		// NombreTitular

		$this->NombreTitular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NombreTitular"));
		$this->NombreTitular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NombreTitular");

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni"));
		$this->Dni->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni");

		// Nombre
		$this->Nombre->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre"));
		$this->Nombre->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre");

		// Password
		$this->Password->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Password"));
		$this->Password->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Password");

		// Nivel_Usuario
		$this->Nivel_Usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nivel_Usuario"));
		$this->Nivel_Usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nivel_Usuario");

		// Curso
		$this->Curso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Curso"));
		$this->Curso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Curso");

		// Turno
		$this->Turno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Turno"));
		$this->Turno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Turno");

		// Division
		$this->Division->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Division"));
		$this->Division->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Division");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// NombreTitular
		// Dni
		// Nombre
		// Password
		// Nivel_Usuario
		// Curso
		// Turno
		// Division

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NombreTitular
		$this->NombreTitular->ViewValue = $this->NombreTitular->CurrentValue;
		if (strval($this->NombreTitular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->NombreTitular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NombreTitular->ViewValue = $this->NombreTitular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NombreTitular->ViewValue = $this->NombreTitular->CurrentValue;
			}
		} else {
			$this->NombreTitular->ViewValue = NULL;
		}
		$this->NombreTitular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Nombre
		$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
		$this->Nombre->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

		// Nivel_Usuario
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->Nivel_Usuario->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Nivel_Usuario->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->Nivel_Usuario->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nivel_Usuario, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nivel_Usuario->ViewValue = $this->Nivel_Usuario->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nivel_Usuario->ViewValue = $this->Nivel_Usuario->CurrentValue;
			}
		} else {
			$this->Nivel_Usuario->ViewValue = NULL;
		}
		} else {
			$this->Nivel_Usuario->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->Nivel_Usuario->ViewCustomAttributes = "";

		// Curso
		if (strval($this->Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Curso->ViewValue = $this->Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Curso->ViewValue = $this->Curso->CurrentValue;
			}
		} else {
			$this->Curso->ViewValue = NULL;
		}
		$this->Curso->ViewCustomAttributes = "";

		// Turno
		if (strval($this->Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Turno->ViewValue = $this->Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Turno->ViewValue = $this->Turno->CurrentValue;
			}
		} else {
			$this->Turno->ViewValue = NULL;
		}
		$this->Turno->ViewCustomAttributes = "";

		// Division
		if (strval($this->Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Division->ViewValue = $this->Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Division->ViewValue = $this->Division->CurrentValue;
			}
		} else {
			$this->Division->ViewValue = NULL;
		}
		$this->Division->ViewCustomAttributes = "";

			// NombreTitular
			$this->NombreTitular->LinkCustomAttributes = "";
			$this->NombreTitular->HrefValue = "";
			$this->NombreTitular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// Nivel_Usuario
			$this->Nivel_Usuario->LinkCustomAttributes = "";
			$this->Nivel_Usuario->HrefValue = "";
			$this->Nivel_Usuario->TooltipValue = "";

			// Curso
			$this->Curso->LinkCustomAttributes = "";
			$this->Curso->HrefValue = "";
			$this->Curso->TooltipValue = "";

			// Turno
			$this->Turno->LinkCustomAttributes = "";
			$this->Turno->HrefValue = "";
			$this->Turno->TooltipValue = "";

			// Division
			$this->Division->LinkCustomAttributes = "";
			$this->Division->HrefValue = "";
			$this->Division->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// NombreTitular
			$this->NombreTitular->EditAttrs["class"] = "form-control";
			$this->NombreTitular->EditCustomAttributes = "";
			$this->NombreTitular->EditValue = ew_HtmlEncode($this->NombreTitular->AdvancedSearch->SearchValue);
			if (strval($this->NombreTitular->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->NombreTitular->AdvancedSearch->SearchValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NombreTitular->EditValue = $this->NombreTitular->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NombreTitular->EditValue = ew_HtmlEncode($this->NombreTitular->AdvancedSearch->SearchValue);
				}
			} else {
				$this->NombreTitular->EditValue = NULL;
			}
			$this->NombreTitular->PlaceHolder = ew_RemoveHtml($this->NombreTitular->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->AdvancedSearch->SearchValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// Nombre
			$this->Nombre->EditAttrs["class"] = "form-control";
			$this->Nombre->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("search")) { // Non system admin
				$this->Nombre->AdvancedSearch->SearchValue = CurrentUserID();
			$this->Nombre->EditValue = $this->Nombre->AdvancedSearch->SearchValue;
			$this->Nombre->ViewCustomAttributes = "";
			} else {
			$this->Nombre->EditValue = ew_HtmlEncode($this->Nombre->AdvancedSearch->SearchValue);
			$this->Nombre->PlaceHolder = ew_RemoveHtml($this->Nombre->FldCaption());
			}

			// Password
			$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->AdvancedSearch->SearchValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// Nivel_Usuario
			$this->Nivel_Usuario->EditAttrs["class"] = "form-control";
			$this->Nivel_Usuario->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->Nivel_Usuario->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->Nivel_Usuario->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Nivel_Usuario->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->Nivel_Usuario->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Nivel_Usuario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Nivel_Usuario->EditValue = $arwrk;
			}

			// Curso
			$this->Curso->EditAttrs["class"] = "form-control";
			$this->Curso->EditCustomAttributes = "";
			if (trim(strval($this->Curso->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Curso->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cursos`";
			$sWhereWrk = "";
			$this->Curso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Curso->EditValue = $arwrk;

			// Turno
			$this->Turno->EditAttrs["class"] = "form-control";
			$this->Turno->EditCustomAttributes = "";
			if (trim(strval($this->Turno->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Turno->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `turno`";
			$sWhereWrk = "";
			$this->Turno->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Turno->EditValue = $arwrk;

			// Division
			$this->Division->EditAttrs["class"] = "form-control";
			$this->Division->EditCustomAttributes = "";
			if (trim(strval($this->Division->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Division->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `division`";
			$sWhereWrk = "";
			$this->Division->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Division, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Division->EditValue = $arwrk;
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
		$this->NombreTitular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Nombre->AdvancedSearch->Load();
		$this->Password->AdvancedSearch->Load();
		$this->Nivel_Usuario->AdvancedSearch->Load();
		$this->Curso->AdvancedSearch->Load();
		$this->Turno->AdvancedSearch->Load();
		$this->Division->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("usuarioslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_NombreTitular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nivel_Usuario":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$this->Nivel_Usuario->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`userlevelid` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nivel_Usuario, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Curso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Curso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
			$sWhereWrk = "";
			$this->Curso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Curso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Curso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Turno":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Turno` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
			$sWhereWrk = "";
			$this->Turno->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Turno` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Turno, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Division":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Division` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
			$sWhereWrk = "";
			$this->Division->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Division` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Division, $sWhereWrk); // Call Lookup selecting
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
		case "x_NombreTitular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->NombreTitular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NombreTitular, $sWhereWrk); // Call Lookup selecting
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
if (!isset($usuarios_search)) $usuarios_search = new cusuarios_search();

// Page init
$usuarios_search->Page_Init();

// Page main
$usuarios_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($usuarios_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fusuariossearch = new ew_Form("fusuariossearch", "search");
<?php } else { ?>
var CurrentForm = fusuariossearch = new ew_Form("fusuariossearch", "search");
<?php } ?>

// Form_CustomValidate event
fusuariossearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusuariossearch.ValidateRequired = true;
<?php } else { ?>
fusuariossearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fusuariossearch.Lists["x_NombreTitular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fusuariossearch.Lists["x_Nivel_Usuario"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
fusuariossearch.Lists["x_Curso"] = {"LinkField":"x_Id_Curso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cursos"};
fusuariossearch.Lists["x_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};
fusuariossearch.Lists["x_Division"] = {"LinkField":"x_Id_Division","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"division"};

// Form object for search
// Validate function for search

fusuariossearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Dni");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($usuarios->Dni->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Password");
	if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
		return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$usuarios_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $usuarios_search->ShowPageHeader(); ?>
<?php
$usuarios_search->ShowMessage();
?>
<form name="fusuariossearch" id="fusuariossearch" class="<?php echo $usuarios_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($usuarios_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $usuarios_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($usuarios_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($usuarios->NombreTitular->Visible) { // NombreTitular ?>
	<div id="r_NombreTitular" class="form-group">
		<label class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_NombreTitular"><?php echo $usuarios->NombreTitular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NombreTitular" id="z_NombreTitular" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->NombreTitular->CellAttributes() ?>>
			<span id="el_usuarios_NombreTitular">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NombreTitular"><?php echo (strval($usuarios->NombreTitular->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $usuarios->NombreTitular->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($usuarios->NombreTitular->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NombreTitular',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="usuarios" data-field="x_NombreTitular" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $usuarios->NombreTitular->DisplayValueSeparatorAttribute() ?>" name="x_NombreTitular" id="x_NombreTitular" value="<?php echo $usuarios->NombreTitular->AdvancedSearch->SearchValue ?>"<?php echo $usuarios->NombreTitular->EditAttributes() ?>>
<input type="hidden" name="s_x_NombreTitular" id="s_x_NombreTitular" value="<?php echo $usuarios->NombreTitular->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Dni"><?php echo $usuarios->Dni->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni" id="z_Dni" value="="></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Dni->CellAttributes() ?>>
			<span id="el_usuarios_Dni">
<input type="text" data-table="usuarios" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($usuarios->Dni->getPlaceHolder()) ?>" value="<?php echo $usuarios->Dni->EditValue ?>"<?php echo $usuarios->Dni->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Nombre->Visible) { // Nombre ?>
	<div id="r_Nombre" class="form-group">
		<label for="x_Nombre" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Nombre"><?php echo $usuarios->Nombre->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre" id="z_Nombre" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Nombre->CellAttributes() ?>>
			<span id="el_usuarios_Nombre">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$usuarios->UserIDAllow("search")) { // Non system admin ?>
<span<?php echo $usuarios->Nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $usuarios->Nombre->EditValue ?></p></span>
<input type="hidden" data-table="usuarios" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" value="<?php echo ew_HtmlEncode($usuarios->Nombre->AdvancedSearch->SearchValue) ?>">
<?php } else { ?>
<input type="text" data-table="usuarios" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($usuarios->Nombre->getPlaceHolder()) ?>" value="<?php echo $usuarios->Nombre->EditValue ?>"<?php echo $usuarios->Nombre->EditAttributes() ?>>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Password->Visible) { // Password ?>
	<div id="r_Password" class="form-group">
		<label for="x_Password" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Password"><?php echo $usuarios->Password->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Password" id="z_Password" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Password->CellAttributes() ?>>
			<span id="el_usuarios_Password">
<input type="text" data-table="usuarios" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($usuarios->Password->getPlaceHolder()) ?>" value="<?php echo $usuarios->Password->EditValue ?>"<?php echo $usuarios->Password->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Nivel_Usuario->Visible) { // Nivel_Usuario ?>
	<div id="r_Nivel_Usuario" class="form-group">
		<label for="x_Nivel_Usuario" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Nivel_Usuario"><?php echo $usuarios->Nivel_Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Nivel_Usuario" id="z_Nivel_Usuario" value="="></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Nivel_Usuario->CellAttributes() ?>>
			<span id="el_usuarios_Nivel_Usuario">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<p class="form-control-static"><?php echo $usuarios->Nivel_Usuario->EditValue ?></p>
<?php } else { ?>
<select data-table="usuarios" data-field="x_Nivel_Usuario" data-value-separator="<?php echo $usuarios->Nivel_Usuario->DisplayValueSeparatorAttribute() ?>" id="x_Nivel_Usuario" name="x_Nivel_Usuario"<?php echo $usuarios->Nivel_Usuario->EditAttributes() ?>>
<?php echo $usuarios->Nivel_Usuario->SelectOptionListHtml("x_Nivel_Usuario") ?>
</select>
<input type="hidden" name="s_x_Nivel_Usuario" id="s_x_Nivel_Usuario" value="<?php echo $usuarios->Nivel_Usuario->LookupFilterQuery() ?>">
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Curso->Visible) { // Curso ?>
	<div id="r_Curso" class="form-group">
		<label for="x_Curso" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Curso"><?php echo $usuarios->Curso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Curso" id="z_Curso" value="="></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Curso->CellAttributes() ?>>
			<span id="el_usuarios_Curso">
<select data-table="usuarios" data-field="x_Curso" data-value-separator="<?php echo $usuarios->Curso->DisplayValueSeparatorAttribute() ?>" id="x_Curso" name="x_Curso"<?php echo $usuarios->Curso->EditAttributes() ?>>
<?php echo $usuarios->Curso->SelectOptionListHtml("x_Curso") ?>
</select>
<input type="hidden" name="s_x_Curso" id="s_x_Curso" value="<?php echo $usuarios->Curso->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Turno->Visible) { // Turno ?>
	<div id="r_Turno" class="form-group">
		<label for="x_Turno" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Turno"><?php echo $usuarios->Turno->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Turno" id="z_Turno" value="="></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Turno->CellAttributes() ?>>
			<span id="el_usuarios_Turno">
<select data-table="usuarios" data-field="x_Turno" data-value-separator="<?php echo $usuarios->Turno->DisplayValueSeparatorAttribute() ?>" id="x_Turno" name="x_Turno"<?php echo $usuarios->Turno->EditAttributes() ?>>
<?php echo $usuarios->Turno->SelectOptionListHtml("x_Turno") ?>
</select>
<input type="hidden" name="s_x_Turno" id="s_x_Turno" value="<?php echo $usuarios->Turno->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuarios->Division->Visible) { // Division ?>
	<div id="r_Division" class="form-group">
		<label for="x_Division" class="<?php echo $usuarios_search->SearchLabelClass ?>"><span id="elh_usuarios_Division"><?php echo $usuarios->Division->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Division" id="z_Division" value="="></p>
		</label>
		<div class="<?php echo $usuarios_search->SearchRightColumnClass ?>"><div<?php echo $usuarios->Division->CellAttributes() ?>>
			<span id="el_usuarios_Division">
<select data-table="usuarios" data-field="x_Division" data-value-separator="<?php echo $usuarios->Division->DisplayValueSeparatorAttribute() ?>" id="x_Division" name="x_Division"<?php echo $usuarios->Division->EditAttributes() ?>>
<?php echo $usuarios->Division->SelectOptionListHtml("x_Division") ?>
</select>
<input type="hidden" name="s_x_Division" id="s_x_Division" value="<?php echo $usuarios->Division->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$usuarios_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fusuariossearch.Init();
</script>
<?php
$usuarios_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$usuarios_search->Page_Terminate();
?>
