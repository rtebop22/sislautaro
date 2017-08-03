<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dato_establecimiento_search = NULL; // Initialize page object first

class cdato_establecimiento_search extends cdato_establecimiento {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'dato_establecimiento';

	// Page object name
	var $PageObjName = 'dato_establecimiento_search';

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

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS["dato_establecimiento"]) || get_class($GLOBALS["dato_establecimiento"]) == "cdato_establecimiento") {
			$GLOBALS["dato_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dato_establecimiento"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dato_establecimiento', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("dato_establecimientolist.php"));
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
		$this->Nombre_Establecimiento->SetVisibility();
		$this->Sigla->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Telefono_Escuela->SetVisibility();
		$this->Mail_Escuela->SetVisibility();
		$this->Matricula_Actual->SetVisibility();
		$this->Cantidad_Aulas->SetVisibility();
		$this->Comparte_Edificio->SetVisibility();
		$this->Cantidad_Turnos->SetVisibility();
		$this->Geolocalizacion->SetVisibility();
		$this->Id_Tipo_Esc->SetVisibility();
		$this->Universo->SetVisibility();
		$this->Tiene_Programa->SetVisibility();
		$this->Sector->SetVisibility();
		$this->Cantidad_Netbook_Conig->SetVisibility();
		$this->Cantidad_Netbook_Actuales->SetVisibility();
		$this->Id_Nivel->SetVisibility();
		$this->Id_Jornada->SetVisibility();
		$this->Tipo_Zona->SetVisibility();
		$this->Id_Estado_Esc->SetVisibility();
		$this->Id_Zona->SetVisibility();
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
		global $EW_EXPORT, $dato_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dato_establecimiento);
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
						$sSrchStr = "dato_establecimientolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Establecimiento); // Nombre_Establecimiento
		$this->BuildSearchUrl($sSrchUrl, $this->Sigla); // Sigla
		$this->BuildSearchUrl($sSrchUrl, $this->Nro_Cuise); // Nro_Cuise
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Departamento); // Id_Departamento
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Localidad); // Id_Localidad
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio); // Domicilio
		$this->BuildSearchUrl($sSrchUrl, $this->Telefono_Escuela); // Telefono_Escuela
		$this->BuildSearchUrl($sSrchUrl, $this->Mail_Escuela); // Mail_Escuela
		$this->BuildSearchUrl($sSrchUrl, $this->Matricula_Actual); // Matricula_Actual
		$this->BuildSearchUrl($sSrchUrl, $this->Cantidad_Aulas); // Cantidad_Aulas
		$this->BuildSearchUrl($sSrchUrl, $this->Comparte_Edificio); // Comparte_Edificio
		$this->BuildSearchUrl($sSrchUrl, $this->Cantidad_Turnos); // Cantidad_Turnos
		$this->BuildSearchUrl($sSrchUrl, $this->Geolocalizacion); // Geolocalizacion
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Tipo_Esc); // Id_Tipo_Esc
		$this->BuildSearchUrl($sSrchUrl, $this->Universo); // Universo
		$this->BuildSearchUrl($sSrchUrl, $this->Tiene_Programa); // Tiene_Programa
		$this->BuildSearchUrl($sSrchUrl, $this->Sector); // Sector
		$this->BuildSearchUrl($sSrchUrl, $this->Cantidad_Netbook_Conig); // Cantidad_Netbook_Conig
		$this->BuildSearchUrl($sSrchUrl, $this->Cantidad_Netbook_Actuales); // Cantidad_Netbook_Actuales
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Nivel); // Id_Nivel
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Jornada); // Id_Jornada
		$this->BuildSearchUrl($sSrchUrl, $this->Tipo_Zona); // Tipo_Zona
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Esc); // Id_Estado_Esc
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Zona); // Id_Zona
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
		// Cue

		$this->Cue->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue"));
		$this->Cue->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue");

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Establecimiento"));
		$this->Nombre_Establecimiento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Establecimiento");

		// Sigla
		$this->Sigla->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sigla"));
		$this->Sigla->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sigla");

		// Nro_Cuise
		$this->Nro_Cuise->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nro_Cuise"));
		$this->Nro_Cuise->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nro_Cuise");

		// Id_Departamento
		$this->Id_Departamento->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Departamento"));
		$this->Id_Departamento->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Departamento");

		// Id_Localidad
		$this->Id_Localidad->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Localidad"));
		$this->Id_Localidad->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Localidad");

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio"));
		$this->Domicilio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio");

		// Telefono_Escuela
		$this->Telefono_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Telefono_Escuela"));
		$this->Telefono_Escuela->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Telefono_Escuela");

		// Mail_Escuela
		$this->Mail_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Mail_Escuela"));
		$this->Mail_Escuela->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Mail_Escuela");

		// Matricula_Actual
		$this->Matricula_Actual->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Matricula_Actual"));
		$this->Matricula_Actual->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Matricula_Actual");

		// Cantidad_Aulas
		$this->Cantidad_Aulas->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cantidad_Aulas"));
		$this->Cantidad_Aulas->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cantidad_Aulas");

		// Comparte_Edificio
		$this->Comparte_Edificio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Comparte_Edificio"));
		$this->Comparte_Edificio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Comparte_Edificio");

		// Cantidad_Turnos
		$this->Cantidad_Turnos->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cantidad_Turnos"));
		$this->Cantidad_Turnos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cantidad_Turnos");

		// Geolocalizacion
		$this->Geolocalizacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Geolocalizacion"));
		$this->Geolocalizacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Geolocalizacion");

		// Id_Tipo_Esc
		$this->Id_Tipo_Esc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Tipo_Esc"));
		$this->Id_Tipo_Esc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Tipo_Esc");
		if (is_array($this->Id_Tipo_Esc->AdvancedSearch->SearchValue)) $this->Id_Tipo_Esc->AdvancedSearch->SearchValue = implode(",", $this->Id_Tipo_Esc->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Tipo_Esc->AdvancedSearch->SearchValue2)) $this->Id_Tipo_Esc->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Tipo_Esc->AdvancedSearch->SearchValue2);

		// Universo
		$this->Universo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Universo"));
		$this->Universo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Universo");

		// Tiene_Programa
		$this->Tiene_Programa->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tiene_Programa"));
		$this->Tiene_Programa->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tiene_Programa");

		// Sector
		$this->Sector->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sector"));
		$this->Sector->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sector");

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cantidad_Netbook_Conig"));
		$this->Cantidad_Netbook_Conig->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cantidad_Netbook_Conig");

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cantidad_Netbook_Actuales"));
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cantidad_Netbook_Actuales");

		// Id_Nivel
		$this->Id_Nivel->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Nivel"));
		$this->Id_Nivel->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Nivel");
		if (is_array($this->Id_Nivel->AdvancedSearch->SearchValue)) $this->Id_Nivel->AdvancedSearch->SearchValue = implode(",", $this->Id_Nivel->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Nivel->AdvancedSearch->SearchValue2)) $this->Id_Nivel->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Nivel->AdvancedSearch->SearchValue2);

		// Id_Jornada
		$this->Id_Jornada->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Jornada"));
		$this->Id_Jornada->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Jornada");
		if (is_array($this->Id_Jornada->AdvancedSearch->SearchValue)) $this->Id_Jornada->AdvancedSearch->SearchValue = implode(",", $this->Id_Jornada->AdvancedSearch->SearchValue);
		if (is_array($this->Id_Jornada->AdvancedSearch->SearchValue2)) $this->Id_Jornada->AdvancedSearch->SearchValue2 = implode(",", $this->Id_Jornada->AdvancedSearch->SearchValue2);

		// Tipo_Zona
		$this->Tipo_Zona->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tipo_Zona"));
		$this->Tipo_Zona->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tipo_Zona");

		// Id_Estado_Esc
		$this->Id_Estado_Esc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Esc"));
		$this->Id_Estado_Esc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Esc");

		// Id_Zona
		$this->Id_Zona->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Zona"));
		$this->Id_Zona->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Zona");

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
		// Cue
		// Nombre_Establecimiento
		// Sigla
		// Nro_Cuise
		// Id_Departamento
		// Id_Localidad
		// Domicilio
		// Telefono_Escuela
		// Mail_Escuela
		// Matricula_Actual
		// Cantidad_Aulas
		// Comparte_Edificio
		// Cantidad_Turnos
		// Geolocalizacion
		// Id_Tipo_Esc
		// Universo
		// Tiene_Programa
		// Sector
		// Cantidad_Netbook_Conig
		// Cantidad_Netbook_Actuales
		// Id_Nivel
		// Id_Jornada
		// Tipo_Zona
		// Id_Estado_Esc
		// Id_Zona
		// Fecha_Actualizacion
		// Usuario

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Cue
		$this->Cue->ViewValue = $this->Cue->CurrentValue;
		$this->Cue->ViewCustomAttributes = "";

		// Nombre_Establecimiento
		$this->Nombre_Establecimiento->ViewValue = $this->Nombre_Establecimiento->CurrentValue;
		$this->Nombre_Establecimiento->ViewCustomAttributes = "";

		// Sigla
		$this->Sigla->ViewValue = $this->Sigla->CurrentValue;
		$this->Sigla->ViewCustomAttributes = "";

		// Nro_Cuise
		$this->Nro_Cuise->ViewValue = $this->Nro_Cuise->CurrentValue;
		$this->Nro_Cuise->ViewCustomAttributes = "";

		// Id_Departamento
		if (strval($this->Id_Departamento->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Id_Departamento->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Departamento->ViewValue = $this->Id_Departamento->CurrentValue;
			}
		} else {
			$this->Id_Departamento->ViewValue = NULL;
		}
		$this->Id_Departamento->ViewCustomAttributes = "";

		// Id_Localidad
		if (strval($this->Id_Localidad->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Id_Localidad->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Localidad->ViewValue = $this->Id_Localidad->CurrentValue;
			}
		} else {
			$this->Id_Localidad->ViewValue = NULL;
		}
		$this->Id_Localidad->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Telefono_Escuela
		$this->Telefono_Escuela->ViewValue = $this->Telefono_Escuela->CurrentValue;
		$this->Telefono_Escuela->ViewCustomAttributes = "";

		// Mail_Escuela
		$this->Mail_Escuela->ViewValue = $this->Mail_Escuela->CurrentValue;
		$this->Mail_Escuela->ViewCustomAttributes = "";

		// Matricula_Actual
		$this->Matricula_Actual->ViewValue = $this->Matricula_Actual->CurrentValue;
		$this->Matricula_Actual->ViewCustomAttributes = "";

		// Cantidad_Aulas
		$this->Cantidad_Aulas->ViewValue = $this->Cantidad_Aulas->CurrentValue;
		$this->Cantidad_Aulas->ViewCustomAttributes = "";

		// Comparte_Edificio
		if (strval($this->Comparte_Edificio->CurrentValue) <> "") {
			$this->Comparte_Edificio->ViewValue = $this->Comparte_Edificio->OptionCaption($this->Comparte_Edificio->CurrentValue);
		} else {
			$this->Comparte_Edificio->ViewValue = NULL;
		}
		$this->Comparte_Edificio->ViewCustomAttributes = "";

		// Cantidad_Turnos
		$this->Cantidad_Turnos->ViewValue = $this->Cantidad_Turnos->CurrentValue;
		$this->Cantidad_Turnos->ViewCustomAttributes = "";

		// Geolocalizacion
		$this->Geolocalizacion->ViewValue = $this->Geolocalizacion->CurrentValue;
		$this->Geolocalizacion->ViewCustomAttributes = "";

		// Id_Tipo_Esc
		if (strval($this->Id_Tipo_Esc->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_escuela`";
		$sWhereWrk = "";
		$this->Id_Tipo_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Tipo_Esc->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Tipo_Esc->ViewValue .= $this->Id_Tipo_Esc->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Tipo_Esc->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Esc->ViewValue = $this->Id_Tipo_Esc->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Esc->ViewValue = NULL;
		}
		$this->Id_Tipo_Esc->ViewCustomAttributes = "";

		// Universo
		if (strval($this->Universo->CurrentValue) <> "") {
			$this->Universo->ViewValue = $this->Universo->OptionCaption($this->Universo->CurrentValue);
		} else {
			$this->Universo->ViewValue = NULL;
		}
		$this->Universo->ViewCustomAttributes = "";

		// Tiene_Programa
		if (strval($this->Tiene_Programa->CurrentValue) <> "") {
			$this->Tiene_Programa->ViewValue = $this->Tiene_Programa->OptionCaption($this->Tiene_Programa->CurrentValue);
		} else {
			$this->Tiene_Programa->ViewValue = NULL;
		}
		$this->Tiene_Programa->ViewCustomAttributes = "";

		// Sector
		if (strval($this->Sector->CurrentValue) <> "") {
			$this->Sector->ViewValue = $this->Sector->OptionCaption($this->Sector->CurrentValue);
		} else {
			$this->Sector->ViewValue = NULL;
		}
		$this->Sector->ViewCustomAttributes = "";

		// Cantidad_Netbook_Conig
		$this->Cantidad_Netbook_Conig->ViewValue = $this->Cantidad_Netbook_Conig->CurrentValue;
		$this->Cantidad_Netbook_Conig->ViewCustomAttributes = "";

		// Cantidad_Netbook_Actuales
		$this->Cantidad_Netbook_Actuales->ViewValue = $this->Cantidad_Netbook_Actuales->CurrentValue;
		$this->Cantidad_Netbook_Actuales->ViewCustomAttributes = "";

		// Id_Nivel
		if (strval($this->Id_Nivel->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Nivel->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Nivel`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
		$sWhereWrk = "";
		$this->Id_Nivel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Nivel->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Nivel->ViewValue .= $this->Id_Nivel->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Nivel->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Nivel->ViewValue = $this->Id_Nivel->CurrentValue;
			}
		} else {
			$this->Id_Nivel->ViewValue = NULL;
		}
		$this->Id_Nivel->ViewCustomAttributes = "";

		// Id_Jornada
		if (strval($this->Id_Jornada->CurrentValue) <> "") {
			$arwrk = explode(",", $this->Id_Jornada->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`Id_Jornada`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `Id_Jornada`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_jornada`";
		$sWhereWrk = "";
		$this->Id_Jornada->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Jornada, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Id_Jornada->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Id_Jornada->ViewValue .= $this->Id_Jornada->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->Id_Jornada->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->Id_Jornada->ViewValue = $this->Id_Jornada->CurrentValue;
			}
		} else {
			$this->Id_Jornada->ViewValue = NULL;
		}
		$this->Id_Jornada->ViewCustomAttributes = "";

		// Tipo_Zona
		$this->Tipo_Zona->ViewValue = $this->Tipo_Zona->CurrentValue;
		$this->Tipo_Zona->ViewCustomAttributes = "";

		// Id_Estado_Esc
		if (strval($this->Id_Estado_Esc->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_establecimiento`";
		$sWhereWrk = "";
		$this->Id_Estado_Esc->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Esc->ViewValue = $this->Id_Estado_Esc->CurrentValue;
			}
		} else {
			$this->Id_Estado_Esc->ViewValue = NULL;
		}
		$this->Id_Estado_Esc->ViewCustomAttributes = "";

		// Id_Zona
		if (strval($this->Id_Zona->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
		$sWhereWrk = "";
		$this->Id_Zona->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Zona->ViewValue = $this->Id_Zona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Zona->ViewValue = $this->Id_Zona->CurrentValue;
			}
		} else {
			$this->Id_Zona->ViewValue = NULL;
		}
		$this->Id_Zona->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Cue
			$this->Cue->LinkCustomAttributes = "";
			$this->Cue->HrefValue = "";
			$this->Cue->TooltipValue = "";

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->LinkCustomAttributes = "";
			$this->Nombre_Establecimiento->HrefValue = "";
			$this->Nombre_Establecimiento->TooltipValue = "";

			// Sigla
			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";
			$this->Sigla->TooltipValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";
			$this->Nro_Cuise->TooltipValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";
			$this->Id_Departamento->TooltipValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";
			$this->Id_Localidad->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Telefono_Escuela
			$this->Telefono_Escuela->LinkCustomAttributes = "";
			$this->Telefono_Escuela->HrefValue = "";
			$this->Telefono_Escuela->TooltipValue = "";

			// Mail_Escuela
			$this->Mail_Escuela->LinkCustomAttributes = "";
			$this->Mail_Escuela->HrefValue = "";
			$this->Mail_Escuela->TooltipValue = "";

			// Matricula_Actual
			$this->Matricula_Actual->LinkCustomAttributes = "";
			$this->Matricula_Actual->HrefValue = "";
			$this->Matricula_Actual->TooltipValue = "";

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";
			$this->Cantidad_Aulas->TooltipValue = "";

			// Comparte_Edificio
			$this->Comparte_Edificio->LinkCustomAttributes = "";
			$this->Comparte_Edificio->HrefValue = "";
			$this->Comparte_Edificio->TooltipValue = "";

			// Cantidad_Turnos
			$this->Cantidad_Turnos->LinkCustomAttributes = "";
			$this->Cantidad_Turnos->HrefValue = "";
			$this->Cantidad_Turnos->TooltipValue = "";

			// Geolocalizacion
			$this->Geolocalizacion->LinkCustomAttributes = "";
			$this->Geolocalizacion->HrefValue = "";
			$this->Geolocalizacion->TooltipValue = "";

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->LinkCustomAttributes = "";
			$this->Id_Tipo_Esc->HrefValue = "";
			$this->Id_Tipo_Esc->TooltipValue = "";

			// Universo
			$this->Universo->LinkCustomAttributes = "";
			$this->Universo->HrefValue = "";
			$this->Universo->TooltipValue = "";

			// Tiene_Programa
			$this->Tiene_Programa->LinkCustomAttributes = "";
			$this->Tiene_Programa->HrefValue = "";
			$this->Tiene_Programa->TooltipValue = "";

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";
			$this->Sector->TooltipValue = "";

			// Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Conig->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Conig->HrefValue = "";
			$this->Cantidad_Netbook_Conig->TooltipValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";
			$this->Cantidad_Netbook_Actuales->TooltipValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";
			$this->Id_Nivel->TooltipValue = "";

			// Id_Jornada
			$this->Id_Jornada->LinkCustomAttributes = "";
			$this->Id_Jornada->HrefValue = "";
			$this->Id_Jornada->TooltipValue = "";

			// Tipo_Zona
			$this->Tipo_Zona->LinkCustomAttributes = "";
			$this->Tipo_Zona->HrefValue = "";
			$this->Tipo_Zona->TooltipValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";
			$this->Id_Estado_Esc->TooltipValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";
			$this->Id_Zona->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Cue
			$this->Cue->EditAttrs["class"] = "form-control";
			$this->Cue->EditCustomAttributes = "";
			$this->Cue->EditValue = ew_HtmlEncode($this->Cue->AdvancedSearch->SearchValue);
			$this->Cue->PlaceHolder = ew_RemoveHtml($this->Cue->FldCaption());

			// Nombre_Establecimiento
			$this->Nombre_Establecimiento->EditAttrs["class"] = "form-control";
			$this->Nombre_Establecimiento->EditCustomAttributes = "";
			$this->Nombre_Establecimiento->EditValue = ew_HtmlEncode($this->Nombre_Establecimiento->AdvancedSearch->SearchValue);
			$this->Nombre_Establecimiento->PlaceHolder = ew_RemoveHtml($this->Nombre_Establecimiento->FldCaption());

			// Sigla
			$this->Sigla->EditAttrs["class"] = "form-control";
			$this->Sigla->EditCustomAttributes = "";
			$this->Sigla->EditValue = ew_HtmlEncode($this->Sigla->AdvancedSearch->SearchValue);
			$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

			// Nro_Cuise
			$this->Nro_Cuise->EditAttrs["class"] = "form-control";
			$this->Nro_Cuise->EditCustomAttributes = "";
			$this->Nro_Cuise->EditValue = ew_HtmlEncode($this->Nro_Cuise->AdvancedSearch->SearchValue);
			$this->Nro_Cuise->PlaceHolder = ew_RemoveHtml($this->Nro_Cuise->FldCaption());

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Departamento`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Departamento->EditValue = $arwrk;

			// Id_Localidad
			$this->Id_Localidad->EditAttrs["class"] = "form-control";
			$this->Id_Localidad->EditCustomAttributes = "";
			if (trim(strval($this->Id_Localidad->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Localidad`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Id_Departamento` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Id_Localidad->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Localidad->EditValue = $arwrk;

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Telefono_Escuela
			$this->Telefono_Escuela->EditAttrs["class"] = "form-control";
			$this->Telefono_Escuela->EditCustomAttributes = "";
			$this->Telefono_Escuela->EditValue = ew_HtmlEncode($this->Telefono_Escuela->AdvancedSearch->SearchValue);
			$this->Telefono_Escuela->PlaceHolder = ew_RemoveHtml($this->Telefono_Escuela->FldCaption());

			// Mail_Escuela
			$this->Mail_Escuela->EditAttrs["class"] = "form-control";
			$this->Mail_Escuela->EditCustomAttributes = "";
			$this->Mail_Escuela->EditValue = ew_HtmlEncode($this->Mail_Escuela->AdvancedSearch->SearchValue);
			$this->Mail_Escuela->PlaceHolder = ew_RemoveHtml($this->Mail_Escuela->FldCaption());

			// Matricula_Actual
			$this->Matricula_Actual->EditAttrs["class"] = "form-control";
			$this->Matricula_Actual->EditCustomAttributes = "";
			$this->Matricula_Actual->EditValue = ew_HtmlEncode($this->Matricula_Actual->AdvancedSearch->SearchValue);
			$this->Matricula_Actual->PlaceHolder = ew_RemoveHtml($this->Matricula_Actual->FldCaption());

			// Cantidad_Aulas
			$this->Cantidad_Aulas->EditAttrs["class"] = "form-control";
			$this->Cantidad_Aulas->EditCustomAttributes = "";
			$this->Cantidad_Aulas->EditValue = ew_HtmlEncode($this->Cantidad_Aulas->AdvancedSearch->SearchValue);
			$this->Cantidad_Aulas->PlaceHolder = ew_RemoveHtml($this->Cantidad_Aulas->FldCaption());

			// Comparte_Edificio
			$this->Comparte_Edificio->EditCustomAttributes = "";
			$this->Comparte_Edificio->EditValue = $this->Comparte_Edificio->Options(FALSE);

			// Cantidad_Turnos
			$this->Cantidad_Turnos->EditAttrs["class"] = "form-control";
			$this->Cantidad_Turnos->EditCustomAttributes = "";
			$this->Cantidad_Turnos->EditValue = ew_HtmlEncode($this->Cantidad_Turnos->AdvancedSearch->SearchValue);
			$this->Cantidad_Turnos->PlaceHolder = ew_RemoveHtml($this->Cantidad_Turnos->FldCaption());

			// Geolocalizacion
			$this->Geolocalizacion->EditAttrs["class"] = "form-control";
			$this->Geolocalizacion->EditCustomAttributes = "";
			$this->Geolocalizacion->EditValue = ew_HtmlEncode($this->Geolocalizacion->AdvancedSearch->SearchValue);
			$this->Geolocalizacion->PlaceHolder = ew_RemoveHtml($this->Geolocalizacion->FldCaption());

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Esc->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Tipo_Esc->AdvancedSearch->SearchValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`Id_Tipo_Esc`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `Id_Tipo_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_escuela`";
			$sWhereWrk = "";
			$this->Id_Tipo_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Esc->EditValue = $arwrk;

			// Universo
			$this->Universo->EditAttrs["class"] = "form-control";
			$this->Universo->EditCustomAttributes = "";
			$this->Universo->EditValue = $this->Universo->Options(TRUE);

			// Tiene_Programa
			$this->Tiene_Programa->EditCustomAttributes = "";
			$this->Tiene_Programa->EditValue = $this->Tiene_Programa->Options(FALSE);

			// Sector
			$this->Sector->EditAttrs["class"] = "form-control";
			$this->Sector->EditCustomAttributes = "";
			$this->Sector->EditValue = $this->Sector->Options(TRUE);

			// Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Conig->EditAttrs["class"] = "form-control";
			$this->Cantidad_Netbook_Conig->EditCustomAttributes = "";
			$this->Cantidad_Netbook_Conig->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue);
			$this->Cantidad_Netbook_Conig->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Conig->FldCaption());

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->EditAttrs["class"] = "form-control";
			$this->Cantidad_Netbook_Actuales->EditCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue);
			$this->Cantidad_Netbook_Actuales->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Actuales->FldCaption());

			// Id_Nivel
			$this->Id_Nivel->EditCustomAttributes = "";
			if (trim(strval($this->Id_Nivel->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Nivel->AdvancedSearch->SearchValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`Id_Nivel`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `Id_Nivel`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Nivel->EditValue = $arwrk;

			// Id_Jornada
			$this->Id_Jornada->EditCustomAttributes = "";
			if (trim(strval($this->Id_Jornada->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Jornada->AdvancedSearch->SearchValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`Id_Jornada`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `Id_Jornada`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_jornada`";
			$sWhereWrk = "";
			$this->Id_Jornada->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Jornada, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Jornada->EditValue = $arwrk;

			// Tipo_Zona
			$this->Tipo_Zona->EditAttrs["class"] = "form-control";
			$this->Tipo_Zona->EditCustomAttributes = "";
			$this->Tipo_Zona->EditValue = ew_HtmlEncode($this->Tipo_Zona->AdvancedSearch->SearchValue);
			$this->Tipo_Zona->PlaceHolder = ew_RemoveHtml($this->Tipo_Zona->FldCaption());

			// Id_Estado_Esc
			$this->Id_Estado_Esc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Esc->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Esc`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Estado_Esc->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Esc->EditValue = $arwrk;

			// Id_Zona
			$this->Id_Zona->EditAttrs["class"] = "form-control";
			$this->Id_Zona->EditCustomAttributes = "";
			if (trim(strval($this->Id_Zona->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Zona`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Zona->EditValue = $arwrk;

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
		if (!ew_CheckInteger($this->Nro_Cuise->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Nro_Cuise->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Telefono_Escuela->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Telefono_Escuela->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Matricula_Actual->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Matricula_Actual->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Aulas->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cantidad_Aulas->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Turnos->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cantidad_Turnos->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Netbook_Conig->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cantidad_Netbook_Conig->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Netbook_Actuales->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Cantidad_Netbook_Actuales->FldErrMsg());
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
		$this->Cue->AdvancedSearch->Load();
		$this->Nombre_Establecimiento->AdvancedSearch->Load();
		$this->Sigla->AdvancedSearch->Load();
		$this->Nro_Cuise->AdvancedSearch->Load();
		$this->Id_Departamento->AdvancedSearch->Load();
		$this->Id_Localidad->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Telefono_Escuela->AdvancedSearch->Load();
		$this->Mail_Escuela->AdvancedSearch->Load();
		$this->Matricula_Actual->AdvancedSearch->Load();
		$this->Cantidad_Aulas->AdvancedSearch->Load();
		$this->Comparte_Edificio->AdvancedSearch->Load();
		$this->Cantidad_Turnos->AdvancedSearch->Load();
		$this->Geolocalizacion->AdvancedSearch->Load();
		$this->Id_Tipo_Esc->AdvancedSearch->Load();
		$this->Universo->AdvancedSearch->Load();
		$this->Tiene_Programa->AdvancedSearch->Load();
		$this->Sector->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Conig->AdvancedSearch->Load();
		$this->Cantidad_Netbook_Actuales->AdvancedSearch->Load();
		$this->Id_Nivel->AdvancedSearch->Load();
		$this->Id_Jornada->AdvancedSearch->Load();
		$this->Tipo_Zona->AdvancedSearch->Load();
		$this->Id_Estado_Esc->AdvancedSearch->Load();
		$this->Id_Zona->AdvancedSearch->Load();
		$this->Fecha_Actualizacion->AdvancedSearch->Load();
		$this->Usuario->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dato_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Id_Departamento":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Departamento` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->Id_Departamento->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Departamento` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Departamento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Localidad":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Localidad` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "{filter}";
			$this->Id_Localidad->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Localidad` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`Id_Departamento` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Localidad, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Tipo_Esc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Esc` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_escuela`";
			$sWhereWrk = "";
			$this->Id_Tipo_Esc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Esc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Nivel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Nivel` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `nivel_educativo`";
			$sWhereWrk = "";
			$this->Id_Nivel->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Nivel` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Nivel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Jornada":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Jornada` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_jornada`";
			$sWhereWrk = "";
			$this->Id_Jornada->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Jornada` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Jornada, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Esc":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Esc` AS `LinkFld`, `Detalle` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_establecimiento`";
			$sWhereWrk = "";
			$this->Id_Estado_Esc->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Esc` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Esc, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Zona":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Zona` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `zonas`";
			$sWhereWrk = "";
			$this->Id_Zona->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Zona` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Zona, $sWhereWrk); // Call Lookup selecting
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
if (!isset($dato_establecimiento_search)) $dato_establecimiento_search = new cdato_establecimiento_search();

// Page init
$dato_establecimiento_search->Page_Init();

// Page main
$dato_establecimiento_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dato_establecimiento_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($dato_establecimiento_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fdato_establecimientosearch = new ew_Form("fdato_establecimientosearch", "search");
<?php } else { ?>
var CurrentForm = fdato_establecimientosearch = new ew_Form("fdato_establecimientosearch", "search");
<?php } ?>

// Form_CustomValidate event
fdato_establecimientosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdato_establecimientosearch.ValidateRequired = true;
<?php } else { ?>
fdato_establecimientosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdato_establecimientosearch.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdato_establecimientosearch.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};
fdato_establecimientosearch.Lists["x_Comparte_Edificio"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientosearch.Lists["x_Comparte_Edificio"].Options = <?php echo json_encode($dato_establecimiento->Comparte_Edificio->Options()) ?>;
fdato_establecimientosearch.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdato_establecimientosearch.Lists["x_Universo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientosearch.Lists["x_Universo"].Options = <?php echo json_encode($dato_establecimiento->Universo->Options()) ?>;
fdato_establecimientosearch.Lists["x_Tiene_Programa"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientosearch.Lists["x_Tiene_Programa"].Options = <?php echo json_encode($dato_establecimiento->Tiene_Programa->Options()) ?>;
fdato_establecimientosearch.Lists["x_Sector"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientosearch.Lists["x_Sector"].Options = <?php echo json_encode($dato_establecimiento->Sector->Options()) ?>;
fdato_establecimientosearch.Lists["x_Id_Nivel[]"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fdato_establecimientosearch.Lists["x_Id_Jornada[]"] = {"LinkField":"x_Id_Jornada","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_jornada"};
fdato_establecimientosearch.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdato_establecimientosearch.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

// Form object for search
// Validate function for search

fdato_establecimientosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Nro_Cuise");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Nro_Cuise->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Telefono_Escuela");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Telefono_Escuela->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Matricula_Actual");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Matricula_Actual->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Cantidad_Aulas");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Aulas->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Cantidad_Turnos");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Turnos->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Cantidad_Netbook_Conig");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Netbook_Conig->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Cantidad_Netbook_Actuales");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Netbook_Actuales->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$dato_establecimiento_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $dato_establecimiento_search->ShowPageHeader(); ?>
<?php
$dato_establecimiento_search->ShowMessage();
?>
<form name="fdato_establecimientosearch" id="fdato_establecimientosearch" class="<?php echo $dato_establecimiento_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($dato_establecimiento_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($dato_establecimiento->Cue->Visible) { // Cue ?>
	<div id="r_Cue" class="form-group">
		<label for="x_Cue" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Cue"><?php echo $dato_establecimiento->Cue->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue" id="z_Cue" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Cue->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Cue">
<input type="text" data-table="dato_establecimiento" data-field="x_Cue" name="x_Cue" id="x_Cue" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cue->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cue->EditValue ?>"<?php echo $dato_establecimiento->Cue->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Nombre_Establecimiento->Visible) { // Nombre_Establecimiento ?>
	<div id="r_Nombre_Establecimiento" class="form-group">
		<label for="x_Nombre_Establecimiento" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Nombre_Establecimiento"><?php echo $dato_establecimiento->Nombre_Establecimiento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Establecimiento" id="z_Nombre_Establecimiento" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Nombre_Establecimiento->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Nombre_Establecimiento">
<input type="text" data-table="dato_establecimiento" data-field="x_Nombre_Establecimiento" name="x_Nombre_Establecimiento" id="x_Nombre_Establecimiento" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nombre_Establecimiento->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nombre_Establecimiento->EditValue ?>"<?php echo $dato_establecimiento->Nombre_Establecimiento->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
	<div id="r_Sigla" class="form-group">
		<label for="x_Sigla" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Sigla"><?php echo $dato_establecimiento->Sigla->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Sigla" id="z_Sigla" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Sigla->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<div id="r_Nro_Cuise" class="form-group">
		<label for="x_Nro_Cuise" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Nro_Cuise"><?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Nro_Cuise" id="z_Nro_Cuise" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Nro_Cuise->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x_Nro_Cuise" id="x_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Departamento"><?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Departamento" id="z_Id_Departamento" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Localidad"><?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Localidad" id="z_Id_Localidad" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Domicilio"><?php echo $dato_establecimiento->Domicilio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio" id="z_Domicilio" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Domicilio->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Domicilio">
<input type="text" data-table="dato_establecimiento" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Domicilio->EditValue ?>"<?php echo $dato_establecimiento->Domicilio->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Telefono_Escuela->Visible) { // Telefono_Escuela ?>
	<div id="r_Telefono_Escuela" class="form-group">
		<label for="x_Telefono_Escuela" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Telefono_Escuela"><?php echo $dato_establecimiento->Telefono_Escuela->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Telefono_Escuela" id="z_Telefono_Escuela" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Telefono_Escuela->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Telefono_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Telefono_Escuela" name="x_Telefono_Escuela" id="x_Telefono_Escuela" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Telefono_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Telefono_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Telefono_Escuela->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Mail_Escuela->Visible) { // Mail_Escuela ?>
	<div id="r_Mail_Escuela" class="form-group">
		<label for="x_Mail_Escuela" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Mail_Escuela"><?php echo $dato_establecimiento->Mail_Escuela->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Mail_Escuela" id="z_Mail_Escuela" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Mail_Escuela->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Mail_Escuela">
<input type="text" data-table="dato_establecimiento" data-field="x_Mail_Escuela" name="x_Mail_Escuela" id="x_Mail_Escuela" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Mail_Escuela->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Mail_Escuela->EditValue ?>"<?php echo $dato_establecimiento->Mail_Escuela->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Matricula_Actual->Visible) { // Matricula_Actual ?>
	<div id="r_Matricula_Actual" class="form-group">
		<label for="x_Matricula_Actual" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Matricula_Actual"><?php echo $dato_establecimiento->Matricula_Actual->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Matricula_Actual" id="z_Matricula_Actual" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Matricula_Actual->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Matricula_Actual">
<input type="text" data-table="dato_establecimiento" data-field="x_Matricula_Actual" name="x_Matricula_Actual" id="x_Matricula_Actual" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Matricula_Actual->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Matricula_Actual->EditValue ?>"<?php echo $dato_establecimiento->Matricula_Actual->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
	<div id="r_Cantidad_Aulas" class="form-group">
		<label for="x_Cantidad_Aulas" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Cantidad_Aulas"><?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cantidad_Aulas" id="z_Cantidad_Aulas" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Cantidad_Aulas->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x_Cantidad_Aulas" id="x_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Comparte_Edificio->Visible) { // Comparte_Edificio ?>
	<div id="r_Comparte_Edificio" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Comparte_Edificio"><?php echo $dato_establecimiento->Comparte_Edificio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Comparte_Edificio" id="z_Comparte_Edificio" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Comparte_Edificio->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Comparte_Edificio">
<div id="tp_x_Comparte_Edificio" class="ewTemplate"><input type="radio" data-table="dato_establecimiento" data-field="x_Comparte_Edificio" data-value-separator="<?php echo $dato_establecimiento->Comparte_Edificio->DisplayValueSeparatorAttribute() ?>" name="x_Comparte_Edificio" id="x_Comparte_Edificio" value="{value}"<?php echo $dato_establecimiento->Comparte_Edificio->EditAttributes() ?>></div>
<div id="dsl_x_Comparte_Edificio" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Comparte_Edificio->RadioButtonListHtml(FALSE, "x_Comparte_Edificio") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<div id="r_Cantidad_Turnos" class="form-group">
		<label for="x_Cantidad_Turnos" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Cantidad_Turnos"><?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cantidad_Turnos" id="z_Cantidad_Turnos" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Cantidad_Turnos->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x_Cantidad_Turnos" id="x_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Geolocalizacion->Visible) { // Geolocalizacion ?>
	<div id="r_Geolocalizacion" class="form-group">
		<label for="x_Geolocalizacion" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Geolocalizacion"><?php echo $dato_establecimiento->Geolocalizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Geolocalizacion" id="z_Geolocalizacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Geolocalizacion->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Geolocalizacion">
<input type="text" data-table="dato_establecimiento" data-field="x_Geolocalizacion" name="x_Geolocalizacion" id="x_Geolocalizacion" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Geolocalizacion->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Geolocalizacion->EditValue ?>"<?php echo $dato_establecimiento->Geolocalizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<div id="r_Id_Tipo_Esc" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Tipo_Esc"><?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Tipo_Esc" id="z_Id_Tipo_Esc" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Tipo_Esc->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x_Id_Tipo_Esc[]" id="x_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Tipo_Esc" id="s_x_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
	<div id="r_Universo" class="form-group">
		<label for="x_Universo" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Universo"><?php echo $dato_establecimiento->Universo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Universo" id="z_Universo" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Universo->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x_Universo" name="x_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x_Universo") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
	<div id="r_Tiene_Programa" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Tiene_Programa"><?php echo $dato_establecimiento->Tiene_Programa->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tiene_Programa" id="z_Tiene_Programa" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Tiene_Programa->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Tiene_Programa">
<div id="tp_x_Tiene_Programa" class="ewTemplate"><input type="radio" data-table="dato_establecimiento" data-field="x_Tiene_Programa" data-value-separator="<?php echo $dato_establecimiento->Tiene_Programa->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_Programa" id="x_Tiene_Programa" value="{value}"<?php echo $dato_establecimiento->Tiene_Programa->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_Programa" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Tiene_Programa->RadioButtonListHtml(FALSE, "x_Tiene_Programa") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
	<div id="r_Sector" class="form-group">
		<label for="x_Sector" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Sector"><?php echo $dato_establecimiento->Sector->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Sector" id="z_Sector" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Sector->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x_Sector" name="x_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x_Sector") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
	<div id="r_Cantidad_Netbook_Conig" class="form-group">
		<label for="x_Cantidad_Netbook_Conig" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Cantidad_Netbook_Conig"><?php echo $dato_establecimiento->Cantidad_Netbook_Conig->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cantidad_Netbook_Conig" id="z_Cantidad_Netbook_Conig" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Cantidad_Netbook_Conig">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Conig" name="x_Cantidad_Netbook_Conig" id="x_Cantidad_Netbook_Conig" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Conig->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<div id="r_Cantidad_Netbook_Actuales" class="form-group">
		<label for="x_Cantidad_Netbook_Actuales" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Cantidad_Netbook_Actuales"><?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Cantidad_Netbook_Actuales" id="z_Cantidad_Netbook_Actuales" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x_Cantidad_Netbook_Actuales" id="x_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Nivel->Visible) { // Id_Nivel ?>
	<div id="r_Id_Nivel" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Nivel"><?php echo $dato_establecimiento->Id_Nivel->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Nivel" id="z_Id_Nivel" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Nivel->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Nivel">
<div id="tp_x_Id_Nivel" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Nivel" data-value-separator="<?php echo $dato_establecimiento->Id_Nivel->DisplayValueSeparatorAttribute() ?>" name="x_Id_Nivel[]" id="x_Id_Nivel[]" value="{value}"<?php echo $dato_establecimiento->Id_Nivel->EditAttributes() ?>></div>
<div id="dsl_x_Id_Nivel" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Nivel->CheckBoxListHtml(FALSE, "x_Id_Nivel[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Nivel" id="s_x_Id_Nivel" value="<?php echo $dato_establecimiento->Id_Nivel->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Jornada->Visible) { // Id_Jornada ?>
	<div id="r_Id_Jornada" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Jornada"><?php echo $dato_establecimiento->Id_Jornada->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Jornada" id="z_Id_Jornada" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Jornada->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Jornada">
<div id="tp_x_Id_Jornada" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Jornada" data-value-separator="<?php echo $dato_establecimiento->Id_Jornada->DisplayValueSeparatorAttribute() ?>" name="x_Id_Jornada[]" id="x_Id_Jornada[]" value="{value}"<?php echo $dato_establecimiento->Id_Jornada->EditAttributes() ?>></div>
<div id="dsl_x_Id_Jornada" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Jornada->CheckBoxListHtml(FALSE, "x_Id_Jornada[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Jornada" id="s_x_Id_Jornada" value="<?php echo $dato_establecimiento->Id_Jornada->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
	<div id="r_Tipo_Zona" class="form-group">
		<label for="x_Tipo_Zona" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Tipo_Zona"><?php echo $dato_establecimiento->Tipo_Zona->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tipo_Zona" id="z_Tipo_Zona" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Tipo_Zona->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Tipo_Zona">
<input type="text" data-table="dato_establecimiento" data-field="x_Tipo_Zona" name="x_Tipo_Zona" id="x_Tipo_Zona" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Tipo_Zona->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Tipo_Zona->EditValue ?>"<?php echo $dato_establecimiento->Tipo_Zona->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<div id="r_Id_Estado_Esc" class="form-group">
		<label for="x_Id_Estado_Esc" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Estado_Esc"><?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Estado_Esc" id="z_Id_Estado_Esc" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Estado_Esc->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Esc" name="x_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Esc" id="s_x_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<div id="r_Id_Zona" class="form-group">
		<label for="x_Id_Zona" class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Id_Zona"><?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Zona" id="z_Id_Zona" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Id_Zona->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x_Id_Zona" name="x_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x_Id_Zona") ?>
</select>
<input type="hidden" name="s_x_Id_Zona" id="s_x_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Fecha_Actualizacion"><?php echo $dato_establecimiento->Fecha_Actualizacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha_Actualizacion" id="z_Fecha_Actualizacion" value="="></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Fecha_Actualizacion->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Fecha_Actualizacion">
<input type="text" data-table="dato_establecimiento" data-field="x_Fecha_Actualizacion" data-format="7" name="x_Fecha_Actualizacion" id="x_Fecha_Actualizacion" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Fecha_Actualizacion->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Fecha_Actualizacion->EditValue ?>"<?php echo $dato_establecimiento->Fecha_Actualizacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label class="<?php echo $dato_establecimiento_search->SearchLabelClass ?>"><span id="elh_dato_establecimiento_Usuario"><?php echo $dato_establecimiento->Usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Usuario" id="z_Usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $dato_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $dato_establecimiento->Usuario->CellAttributes() ?>>
			<span id="el_dato_establecimiento_Usuario">
<input type="text" data-table="dato_establecimiento" data-field="x_Usuario" name="x_Usuario" id="x_Usuario" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Usuario->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Usuario->EditValue ?>"<?php echo $dato_establecimiento->Usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$dato_establecimiento_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdato_establecimientosearch.Init();
</script>
<?php
$dato_establecimiento_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dato_establecimiento_search->Page_Terminate();
?>
