<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pase_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pase_establecimiento_search = NULL; // Initialize page object first

class cpase_establecimiento_search extends cpase_establecimiento {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'pase_establecimiento';

	// Page object name
	var $PageObjName = 'pase_establecimiento_search';

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

		// Table object (pase_establecimiento)
		if (!isset($GLOBALS["pase_establecimiento"]) || get_class($GLOBALS["pase_establecimiento"]) == "cpase_establecimiento") {
			$GLOBALS["pase_establecimiento"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pase_establecimiento"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pase_establecimiento', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pase_establecimientolist.php"));
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
		$this->Id_Pase->SetVisibility();
		$this->Id_Pase->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Serie_Equipo->SetVisibility();
		$this->Id_Hardware->SetVisibility();
		$this->SN->SetVisibility();
		$this->Modelo_Net->SetVisibility();
		$this->Marca_Arranque->SetVisibility();
		$this->Nombre_Titular->SetVisibility();
		$this->Dni_Titular->SetVisibility();
		$this->Cuil_Titular->SetVisibility();
		$this->Nombre_Tutor->SetVisibility();
		$this->DniTutor->SetVisibility();
		$this->Domicilio->SetVisibility();
		$this->Tel_Tutor->SetVisibility();
		$this->CelTutor->SetVisibility();
		$this->Cue_Establecimiento_Alta->SetVisibility();
		$this->Escuela_Alta->SetVisibility();
		$this->Directivo_Alta->SetVisibility();
		$this->Cuil_Directivo_Alta->SetVisibility();
		$this->Dpto_Esc_alta->SetVisibility();
		$this->Localidad_Esc_Alta->SetVisibility();
		$this->Domicilio_Esc_Alta->SetVisibility();
		$this->Rte_Alta->SetVisibility();
		$this->Tel_Rte_Alta->SetVisibility();
		$this->Email_Rte_Alta->SetVisibility();
		$this->Serie_Server_Alta->SetVisibility();
		$this->Cue_Establecimiento_Baja->SetVisibility();
		$this->Escuela_Baja->SetVisibility();
		$this->Directivo_Baja->SetVisibility();
		$this->Cuil_Directivo_Baja->SetVisibility();
		$this->Dpto_Esc_Baja->SetVisibility();
		$this->Localidad_Esc_Baja->SetVisibility();
		$this->Domicilio_Esc_Baja->SetVisibility();
		$this->Rte_Baja->SetVisibility();
		$this->Tel_Rte_Baja->SetVisibility();
		$this->Email_Rte_Baja->SetVisibility();
		$this->Serie_Server_Baja->SetVisibility();
		$this->Fecha_Pase->SetVisibility();
		$this->Id_Estado_Pase->SetVisibility();
		$this->Ruta_Archivo->SetVisibility();

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
		global $EW_EXPORT, $pase_establecimiento;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pase_establecimiento);
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
						$sSrchStr = "pase_establecimientolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Pase); // Id_Pase
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Equipo); // Serie_Equipo
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Hardware); // Id_Hardware
		$this->BuildSearchUrl($sSrchUrl, $this->SN); // SN
		$this->BuildSearchUrl($sSrchUrl, $this->Modelo_Net); // Modelo_Net
		$this->BuildSearchUrl($sSrchUrl, $this->Marca_Arranque); // Marca_Arranque
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Titular); // Nombre_Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Dni_Titular); // Dni_Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil_Titular); // Cuil_Titular
		$this->BuildSearchUrl($sSrchUrl, $this->Nombre_Tutor); // Nombre_Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->DniTutor); // DniTutor
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio); // Domicilio
		$this->BuildSearchUrl($sSrchUrl, $this->Tel_Tutor); // Tel_Tutor
		$this->BuildSearchUrl($sSrchUrl, $this->CelTutor); // CelTutor
		$this->BuildSearchUrl($sSrchUrl, $this->Cue_Establecimiento_Alta); // Cue_Establecimiento_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Escuela_Alta); // Escuela_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Directivo_Alta); // Directivo_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil_Directivo_Alta); // Cuil_Directivo_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Dpto_Esc_alta); // Dpto_Esc_alta
		$this->BuildSearchUrl($sSrchUrl, $this->Localidad_Esc_Alta); // Localidad_Esc_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio_Esc_Alta); // Domicilio_Esc_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Rte_Alta); // Rte_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Tel_Rte_Alta); // Tel_Rte_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Email_Rte_Alta); // Email_Rte_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Server_Alta); // Serie_Server_Alta
		$this->BuildSearchUrl($sSrchUrl, $this->Cue_Establecimiento_Baja); // Cue_Establecimiento_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Escuela_Baja); // Escuela_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Directivo_Baja); // Directivo_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Cuil_Directivo_Baja); // Cuil_Directivo_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Dpto_Esc_Baja); // Dpto_Esc_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Localidad_Esc_Baja); // Localidad_Esc_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Domicilio_Esc_Baja); // Domicilio_Esc_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Rte_Baja); // Rte_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Tel_Rte_Baja); // Tel_Rte_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Email_Rte_Baja); // Email_Rte_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Serie_Server_Baja); // Serie_Server_Baja
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha_Pase); // Fecha_Pase
		$this->BuildSearchUrl($sSrchUrl, $this->Id_Estado_Pase); // Id_Estado_Pase
		$this->BuildSearchUrl($sSrchUrl, $this->Ruta_Archivo); // Ruta_Archivo
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
		// Id_Pase

		$this->Id_Pase->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Pase"));
		$this->Id_Pase->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Pase");

		// Serie_Equipo
		$this->Serie_Equipo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Equipo"));
		$this->Serie_Equipo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Equipo");

		// Id_Hardware
		$this->Id_Hardware->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Hardware"));
		$this->Id_Hardware->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Hardware");

		// SN
		$this->SN->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_SN"));
		$this->SN->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SN");

		// Modelo_Net
		$this->Modelo_Net->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Modelo_Net"));
		$this->Modelo_Net->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Modelo_Net");

		// Marca_Arranque
		$this->Marca_Arranque->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Marca_Arranque"));
		$this->Marca_Arranque->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Marca_Arranque");

		// Nombre_Titular
		$this->Nombre_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Titular"));
		$this->Nombre_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Titular");

		// Dni_Titular
		$this->Dni_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dni_Titular"));
		$this->Dni_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dni_Titular");

		// Cuil_Titular
		$this->Cuil_Titular->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil_Titular"));
		$this->Cuil_Titular->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil_Titular");

		// Nombre_Tutor
		$this->Nombre_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Nombre_Tutor"));
		$this->Nombre_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nombre_Tutor");

		// DniTutor
		$this->DniTutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_DniTutor"));
		$this->DniTutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_DniTutor");

		// Domicilio
		$this->Domicilio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio"));
		$this->Domicilio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio");

		// Tel_Tutor
		$this->Tel_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tel_Tutor"));
		$this->Tel_Tutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tel_Tutor");

		// CelTutor
		$this->CelTutor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_CelTutor"));
		$this->CelTutor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_CelTutor");

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue_Establecimiento_Alta"));
		$this->Cue_Establecimiento_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue_Establecimiento_Alta");

		// Escuela_Alta
		$this->Escuela_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Escuela_Alta"));
		$this->Escuela_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Escuela_Alta");

		// Directivo_Alta
		$this->Directivo_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Directivo_Alta"));
		$this->Directivo_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Directivo_Alta");

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil_Directivo_Alta"));
		$this->Cuil_Directivo_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil_Directivo_Alta");

		// Dpto_Esc_alta
		$this->Dpto_Esc_alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dpto_Esc_alta"));
		$this->Dpto_Esc_alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dpto_Esc_alta");

		// Localidad_Esc_Alta
		$this->Localidad_Esc_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Localidad_Esc_Alta"));
		$this->Localidad_Esc_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Localidad_Esc_Alta");

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio_Esc_Alta"));
		$this->Domicilio_Esc_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio_Esc_Alta");

		// Rte_Alta
		$this->Rte_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Rte_Alta"));
		$this->Rte_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Rte_Alta");

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tel_Rte_Alta"));
		$this->Tel_Rte_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tel_Rte_Alta");

		// Email_Rte_Alta
		$this->Email_Rte_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Email_Rte_Alta"));
		$this->Email_Rte_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Email_Rte_Alta");

		// Serie_Server_Alta
		$this->Serie_Server_Alta->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Server_Alta"));
		$this->Serie_Server_Alta->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Server_Alta");

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cue_Establecimiento_Baja"));
		$this->Cue_Establecimiento_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cue_Establecimiento_Baja");

		// Escuela_Baja
		$this->Escuela_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Escuela_Baja"));
		$this->Escuela_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Escuela_Baja");

		// Directivo_Baja
		$this->Directivo_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Directivo_Baja"));
		$this->Directivo_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Directivo_Baja");

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cuil_Directivo_Baja"));
		$this->Cuil_Directivo_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cuil_Directivo_Baja");

		// Dpto_Esc_Baja
		$this->Dpto_Esc_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Dpto_Esc_Baja"));
		$this->Dpto_Esc_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Dpto_Esc_Baja");

		// Localidad_Esc_Baja
		$this->Localidad_Esc_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Localidad_Esc_Baja"));
		$this->Localidad_Esc_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Localidad_Esc_Baja");

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Domicilio_Esc_Baja"));
		$this->Domicilio_Esc_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Domicilio_Esc_Baja");

		// Rte_Baja
		$this->Rte_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Rte_Baja"));
		$this->Rte_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Rte_Baja");

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tel_Rte_Baja"));
		$this->Tel_Rte_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tel_Rte_Baja");

		// Email_Rte_Baja
		$this->Email_Rte_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Email_Rte_Baja"));
		$this->Email_Rte_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Email_Rte_Baja");

		// Serie_Server_Baja
		$this->Serie_Server_Baja->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Serie_Server_Baja"));
		$this->Serie_Server_Baja->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Serie_Server_Baja");

		// Fecha_Pase
		$this->Fecha_Pase->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha_Pase"));
		$this->Fecha_Pase->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha_Pase");

		// Id_Estado_Pase
		$this->Id_Estado_Pase->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Id_Estado_Pase"));
		$this->Id_Estado_Pase->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Id_Estado_Pase");

		// Ruta_Archivo
		$this->Ruta_Archivo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Ruta_Archivo"));
		$this->Ruta_Archivo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Ruta_Archivo");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Pase
		// Serie_Equipo
		// Id_Hardware
		// SN
		// Modelo_Net
		// Marca_Arranque
		// Nombre_Titular
		// Dni_Titular
		// Cuil_Titular
		// Nombre_Tutor
		// DniTutor
		// Domicilio
		// Tel_Tutor
		// CelTutor
		// Cue_Establecimiento_Alta
		// Escuela_Alta
		// Directivo_Alta
		// Cuil_Directivo_Alta
		// Dpto_Esc_alta
		// Localidad_Esc_Alta
		// Domicilio_Esc_Alta
		// Rte_Alta
		// Tel_Rte_Alta
		// Email_Rte_Alta
		// Serie_Server_Alta
		// Cue_Establecimiento_Baja
		// Escuela_Baja
		// Directivo_Baja
		// Cuil_Directivo_Baja
		// Dpto_Esc_Baja
		// Localidad_Esc_Baja
		// Domicilio_Esc_Baja
		// Rte_Baja
		// Tel_Rte_Baja
		// Email_Rte_Baja
		// Serie_Server_Baja
		// Fecha_Pase
		// Id_Estado_Pase
		// Ruta_Archivo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Pase
		$this->Id_Pase->ViewValue = $this->Id_Pase->CurrentValue;
		$this->Id_Pase->ViewCustomAttributes = "";

		// Serie_Equipo
		$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
		if (strval($this->Serie_Equipo->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Equipo->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Serie_Equipo->ViewValue = $this->Serie_Equipo->CurrentValue;
			}
		} else {
			$this->Serie_Equipo->ViewValue = NULL;
		}
		$this->Serie_Equipo->ViewCustomAttributes = "";

		// Id_Hardware
		$this->Id_Hardware->ViewValue = $this->Id_Hardware->CurrentValue;
		$this->Id_Hardware->ViewCustomAttributes = "";

		// SN
		$this->SN->ViewValue = $this->SN->CurrentValue;
		$this->SN->ViewCustomAttributes = "";

		// Modelo_Net
		if (strval($this->Modelo_Net->CurrentValue) <> "") {
			$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Modelo_Net->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
		$sWhereWrk = "";
		$this->Modelo_Net->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Modelo_Net, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Modelo_Net->ViewValue = $this->Modelo_Net->CurrentValue;
			}
		} else {
			$this->Modelo_Net->ViewValue = NULL;
		}
		$this->Modelo_Net->ViewCustomAttributes = "";

		// Marca_Arranque
		$this->Marca_Arranque->ViewValue = $this->Marca_Arranque->CurrentValue;
		$this->Marca_Arranque->ViewCustomAttributes = "";

		// Nombre_Titular
		$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
		if (strval($this->Nombre_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Titular->ViewValue = $this->Nombre_Titular->CurrentValue;
			}
		} else {
			$this->Nombre_Titular->ViewValue = NULL;
		}
		$this->Nombre_Titular->ViewCustomAttributes = "";

		// Dni_Titular
		$this->Dni_Titular->ViewValue = $this->Dni_Titular->CurrentValue;
		$this->Dni_Titular->ViewCustomAttributes = "";

		// Cuil_Titular
		$this->Cuil_Titular->ViewValue = $this->Cuil_Titular->CurrentValue;
		$this->Cuil_Titular->ViewCustomAttributes = "";

		// Nombre_Tutor
		$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
		if (strval($this->Nombre_Tutor->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Tutor->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
		$sWhereWrk = "";
		$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nombre_Tutor->ViewValue = $this->Nombre_Tutor->CurrentValue;
			}
		} else {
			$this->Nombre_Tutor->ViewValue = NULL;
		}
		$this->Nombre_Tutor->ViewCustomAttributes = "";

		// DniTutor
		$this->DniTutor->ViewValue = $this->DniTutor->CurrentValue;
		$this->DniTutor->ViewCustomAttributes = "";

		// Domicilio
		$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
		$this->Domicilio->ViewCustomAttributes = "";

		// Tel_Tutor
		$this->Tel_Tutor->ViewValue = $this->Tel_Tutor->CurrentValue;
		$this->Tel_Tutor->ViewCustomAttributes = "";

		// CelTutor
		$this->CelTutor->ViewValue = $this->CelTutor->CurrentValue;
		$this->CelTutor->ViewCustomAttributes = "";

		// Cue_Establecimiento_Alta
		$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
		if (strval($this->Cue_Establecimiento_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Alta->ViewValue = $this->Cue_Establecimiento_Alta->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Alta->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Alta->ViewCustomAttributes = "";

		// Escuela_Alta
		$this->Escuela_Alta->ViewValue = $this->Escuela_Alta->CurrentValue;
		$this->Escuela_Alta->ViewCustomAttributes = "";

		// Directivo_Alta
		$this->Directivo_Alta->ViewValue = $this->Directivo_Alta->CurrentValue;
		$this->Directivo_Alta->ViewCustomAttributes = "";

		// Cuil_Directivo_Alta
		$this->Cuil_Directivo_Alta->ViewValue = $this->Cuil_Directivo_Alta->CurrentValue;
		$this->Cuil_Directivo_Alta->ViewCustomAttributes = "";

		// Dpto_Esc_alta
		if (strval($this->Dpto_Esc_alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_alta->ViewValue = $this->Dpto_Esc_alta->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_alta->ViewValue = NULL;
		}
		$this->Dpto_Esc_alta->ViewCustomAttributes = "";

		// Localidad_Esc_Alta
		if (strval($this->Localidad_Esc_Alta->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Alta->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Alta->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Alta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Alta->ViewValue = $this->Localidad_Esc_Alta->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Alta->ViewValue = NULL;
		}
		$this->Localidad_Esc_Alta->ViewCustomAttributes = "";

		// Domicilio_Esc_Alta
		$this->Domicilio_Esc_Alta->ViewValue = $this->Domicilio_Esc_Alta->CurrentValue;
		$this->Domicilio_Esc_Alta->ViewCustomAttributes = "";

		// Rte_Alta
		$this->Rte_Alta->ViewValue = $this->Rte_Alta->CurrentValue;
		$this->Rte_Alta->ViewCustomAttributes = "";

		// Tel_Rte_Alta
		$this->Tel_Rte_Alta->ViewValue = $this->Tel_Rte_Alta->CurrentValue;
		$this->Tel_Rte_Alta->ViewCustomAttributes = "";

		// Email_Rte_Alta
		$this->Email_Rte_Alta->ViewValue = $this->Email_Rte_Alta->CurrentValue;
		$this->Email_Rte_Alta->ViewCustomAttributes = "";

		// Serie_Server_Alta
		$this->Serie_Server_Alta->ViewValue = $this->Serie_Server_Alta->CurrentValue;
		$this->Serie_Server_Alta->ViewCustomAttributes = "";

		// Cue_Establecimiento_Baja
		$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
		if (strval($this->Cue_Establecimiento_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
		$sWhereWrk = "";
		$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Cue_Establecimiento_Baja->ViewValue = $this->Cue_Establecimiento_Baja->CurrentValue;
			}
		} else {
			$this->Cue_Establecimiento_Baja->ViewValue = NULL;
		}
		$this->Cue_Establecimiento_Baja->ViewCustomAttributes = "";

		// Escuela_Baja
		$this->Escuela_Baja->ViewValue = $this->Escuela_Baja->CurrentValue;
		$this->Escuela_Baja->ViewCustomAttributes = "";

		// Directivo_Baja
		$this->Directivo_Baja->ViewValue = $this->Directivo_Baja->CurrentValue;
		$this->Directivo_Baja->ViewCustomAttributes = "";

		// Cuil_Directivo_Baja
		$this->Cuil_Directivo_Baja->ViewValue = $this->Cuil_Directivo_Baja->CurrentValue;
		$this->Cuil_Directivo_Baja->ViewCustomAttributes = "";

		// Dpto_Esc_Baja
		if (strval($this->Dpto_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
		$sWhereWrk = "";
		$this->Dpto_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Dpto_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Dpto_Esc_Baja->ViewValue = $this->Dpto_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Dpto_Esc_Baja->ViewValue = NULL;
		}
		$this->Dpto_Esc_Baja->ViewCustomAttributes = "";

		// Localidad_Esc_Baja
		if (strval($this->Localidad_Esc_Baja->CurrentValue) <> "") {
			$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Baja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
		$sWhereWrk = "";
		$this->Localidad_Esc_Baja->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Localidad_Esc_Baja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Localidad_Esc_Baja->ViewValue = $this->Localidad_Esc_Baja->CurrentValue;
			}
		} else {
			$this->Localidad_Esc_Baja->ViewValue = NULL;
		}
		$this->Localidad_Esc_Baja->ViewCustomAttributes = "";

		// Domicilio_Esc_Baja
		$this->Domicilio_Esc_Baja->ViewValue = $this->Domicilio_Esc_Baja->CurrentValue;
		$this->Domicilio_Esc_Baja->ViewCustomAttributes = "";

		// Rte_Baja
		$this->Rte_Baja->ViewValue = $this->Rte_Baja->CurrentValue;
		$this->Rte_Baja->ViewCustomAttributes = "";

		// Tel_Rte_Baja
		$this->Tel_Rte_Baja->ViewValue = $this->Tel_Rte_Baja->CurrentValue;
		$this->Tel_Rte_Baja->ViewCustomAttributes = "";

		// Email_Rte_Baja
		$this->Email_Rte_Baja->ViewValue = $this->Email_Rte_Baja->CurrentValue;
		$this->Email_Rte_Baja->ViewCustomAttributes = "";

		// Serie_Server_Baja
		$this->Serie_Server_Baja->ViewValue = $this->Serie_Server_Baja->CurrentValue;
		$this->Serie_Server_Baja->ViewCustomAttributes = "";

		// Fecha_Pase
		$this->Fecha_Pase->ViewValue = $this->Fecha_Pase->CurrentValue;
		$this->Fecha_Pase->ViewValue = ew_FormatDateTime($this->Fecha_Pase->ViewValue, 7);
		$this->Fecha_Pase->ViewCustomAttributes = "";

		// Id_Estado_Pase
		if (strval($this->Id_Estado_Pase->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
		$sWhereWrk = "";
		$this->Id_Estado_Pase->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado_Pase->ViewValue = $this->Id_Estado_Pase->CurrentValue;
			}
		} else {
			$this->Id_Estado_Pase->ViewValue = NULL;
		}
		$this->Id_Estado_Pase->ViewCustomAttributes = "";

		// Ruta_Archivo
		$this->Ruta_Archivo->UploadPath = 'ArchivosPase';
		if (!ew_Empty($this->Ruta_Archivo->Upload->DbValue)) {
			$this->Ruta_Archivo->ViewValue = $this->Ruta_Archivo->Upload->DbValue;
		} else {
			$this->Ruta_Archivo->ViewValue = "";
		}
		$this->Ruta_Archivo->ViewCustomAttributes = "";

			// Id_Pase
			$this->Id_Pase->LinkCustomAttributes = "";
			$this->Id_Pase->HrefValue = "";
			$this->Id_Pase->TooltipValue = "";

			// Serie_Equipo
			$this->Serie_Equipo->LinkCustomAttributes = "";
			$this->Serie_Equipo->HrefValue = "";
			$this->Serie_Equipo->TooltipValue = "";

			// Id_Hardware
			$this->Id_Hardware->LinkCustomAttributes = "";
			$this->Id_Hardware->HrefValue = "";
			$this->Id_Hardware->TooltipValue = "";

			// SN
			$this->SN->LinkCustomAttributes = "";
			$this->SN->HrefValue = "";
			$this->SN->TooltipValue = "";

			// Modelo_Net
			$this->Modelo_Net->LinkCustomAttributes = "";
			$this->Modelo_Net->HrefValue = "";
			$this->Modelo_Net->TooltipValue = "";

			// Marca_Arranque
			$this->Marca_Arranque->LinkCustomAttributes = "";
			$this->Marca_Arranque->HrefValue = "";
			$this->Marca_Arranque->TooltipValue = "";

			// Nombre_Titular
			$this->Nombre_Titular->LinkCustomAttributes = "";
			$this->Nombre_Titular->HrefValue = "";
			$this->Nombre_Titular->TooltipValue = "";

			// Dni_Titular
			$this->Dni_Titular->LinkCustomAttributes = "";
			$this->Dni_Titular->HrefValue = "";
			$this->Dni_Titular->TooltipValue = "";

			// Cuil_Titular
			$this->Cuil_Titular->LinkCustomAttributes = "";
			$this->Cuil_Titular->HrefValue = "";
			$this->Cuil_Titular->TooltipValue = "";

			// Nombre_Tutor
			$this->Nombre_Tutor->LinkCustomAttributes = "";
			$this->Nombre_Tutor->HrefValue = "";
			$this->Nombre_Tutor->TooltipValue = "";

			// DniTutor
			$this->DniTutor->LinkCustomAttributes = "";
			$this->DniTutor->HrefValue = "";
			$this->DniTutor->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Tel_Tutor
			$this->Tel_Tutor->LinkCustomAttributes = "";
			$this->Tel_Tutor->HrefValue = "";
			$this->Tel_Tutor->TooltipValue = "";

			// CelTutor
			$this->CelTutor->LinkCustomAttributes = "";
			$this->CelTutor->HrefValue = "";
			$this->CelTutor->TooltipValue = "";

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->HrefValue = "";
			$this->Cue_Establecimiento_Alta->TooltipValue = "";

			// Escuela_Alta
			$this->Escuela_Alta->LinkCustomAttributes = "";
			$this->Escuela_Alta->HrefValue = "";
			$this->Escuela_Alta->TooltipValue = "";

			// Directivo_Alta
			$this->Directivo_Alta->LinkCustomAttributes = "";
			$this->Directivo_Alta->HrefValue = "";
			$this->Directivo_Alta->TooltipValue = "";

			// Cuil_Directivo_Alta
			$this->Cuil_Directivo_Alta->LinkCustomAttributes = "";
			$this->Cuil_Directivo_Alta->HrefValue = "";
			$this->Cuil_Directivo_Alta->TooltipValue = "";

			// Dpto_Esc_alta
			$this->Dpto_Esc_alta->LinkCustomAttributes = "";
			$this->Dpto_Esc_alta->HrefValue = "";
			$this->Dpto_Esc_alta->TooltipValue = "";

			// Localidad_Esc_Alta
			$this->Localidad_Esc_Alta->LinkCustomAttributes = "";
			$this->Localidad_Esc_Alta->HrefValue = "";
			$this->Localidad_Esc_Alta->TooltipValue = "";

			// Domicilio_Esc_Alta
			$this->Domicilio_Esc_Alta->LinkCustomAttributes = "";
			$this->Domicilio_Esc_Alta->HrefValue = "";
			$this->Domicilio_Esc_Alta->TooltipValue = "";

			// Rte_Alta
			$this->Rte_Alta->LinkCustomAttributes = "";
			$this->Rte_Alta->HrefValue = "";
			$this->Rte_Alta->TooltipValue = "";

			// Tel_Rte_Alta
			$this->Tel_Rte_Alta->LinkCustomAttributes = "";
			$this->Tel_Rte_Alta->HrefValue = "";
			$this->Tel_Rte_Alta->TooltipValue = "";

			// Email_Rte_Alta
			$this->Email_Rte_Alta->LinkCustomAttributes = "";
			$this->Email_Rte_Alta->HrefValue = "";
			$this->Email_Rte_Alta->TooltipValue = "";

			// Serie_Server_Alta
			$this->Serie_Server_Alta->LinkCustomAttributes = "";
			$this->Serie_Server_Alta->HrefValue = "";
			$this->Serie_Server_Alta->TooltipValue = "";

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->LinkCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->HrefValue = "";
			$this->Cue_Establecimiento_Baja->TooltipValue = "";

			// Escuela_Baja
			$this->Escuela_Baja->LinkCustomAttributes = "";
			$this->Escuela_Baja->HrefValue = "";
			$this->Escuela_Baja->TooltipValue = "";

			// Directivo_Baja
			$this->Directivo_Baja->LinkCustomAttributes = "";
			$this->Directivo_Baja->HrefValue = "";
			$this->Directivo_Baja->TooltipValue = "";

			// Cuil_Directivo_Baja
			$this->Cuil_Directivo_Baja->LinkCustomAttributes = "";
			$this->Cuil_Directivo_Baja->HrefValue = "";
			$this->Cuil_Directivo_Baja->TooltipValue = "";

			// Dpto_Esc_Baja
			$this->Dpto_Esc_Baja->LinkCustomAttributes = "";
			$this->Dpto_Esc_Baja->HrefValue = "";
			$this->Dpto_Esc_Baja->TooltipValue = "";

			// Localidad_Esc_Baja
			$this->Localidad_Esc_Baja->LinkCustomAttributes = "";
			$this->Localidad_Esc_Baja->HrefValue = "";
			$this->Localidad_Esc_Baja->TooltipValue = "";

			// Domicilio_Esc_Baja
			$this->Domicilio_Esc_Baja->LinkCustomAttributes = "";
			$this->Domicilio_Esc_Baja->HrefValue = "";
			$this->Domicilio_Esc_Baja->TooltipValue = "";

			// Rte_Baja
			$this->Rte_Baja->LinkCustomAttributes = "";
			$this->Rte_Baja->HrefValue = "";
			$this->Rte_Baja->TooltipValue = "";

			// Tel_Rte_Baja
			$this->Tel_Rte_Baja->LinkCustomAttributes = "";
			$this->Tel_Rte_Baja->HrefValue = "";
			$this->Tel_Rte_Baja->TooltipValue = "";

			// Email_Rte_Baja
			$this->Email_Rte_Baja->LinkCustomAttributes = "";
			$this->Email_Rte_Baja->HrefValue = "";
			$this->Email_Rte_Baja->TooltipValue = "";

			// Serie_Server_Baja
			$this->Serie_Server_Baja->LinkCustomAttributes = "";
			$this->Serie_Server_Baja->HrefValue = "";
			$this->Serie_Server_Baja->TooltipValue = "";

			// Fecha_Pase
			$this->Fecha_Pase->LinkCustomAttributes = "";
			$this->Fecha_Pase->HrefValue = "";
			$this->Fecha_Pase->TooltipValue = "";

			// Id_Estado_Pase
			$this->Id_Estado_Pase->LinkCustomAttributes = "";
			$this->Id_Estado_Pase->HrefValue = "";
			$this->Id_Estado_Pase->TooltipValue = "";

			// Ruta_Archivo
			$this->Ruta_Archivo->LinkCustomAttributes = "";
			$this->Ruta_Archivo->HrefValue = "";
			$this->Ruta_Archivo->HrefValue2 = $this->Ruta_Archivo->UploadPath . $this->Ruta_Archivo->Upload->DbValue;
			$this->Ruta_Archivo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Pase
			$this->Id_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Pase->EditCustomAttributes = "";
			$this->Id_Pase->EditValue = ew_HtmlEncode($this->Id_Pase->AdvancedSearch->SearchValue);
			$this->Id_Pase->PlaceHolder = ew_RemoveHtml($this->Id_Pase->FldCaption());

			// Serie_Equipo
			$this->Serie_Equipo->EditAttrs["class"] = "form-control";
			$this->Serie_Equipo->EditCustomAttributes = "";
			$this->Serie_Equipo->EditValue = ew_HtmlEncode($this->Serie_Equipo->AdvancedSearch->SearchValue);
			if (strval($this->Serie_Equipo->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Serie_Equipo->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Serie_Equipo->EditValue = $this->Serie_Equipo->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Serie_Equipo->EditValue = ew_HtmlEncode($this->Serie_Equipo->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Serie_Equipo->EditValue = NULL;
			}
			$this->Serie_Equipo->PlaceHolder = ew_RemoveHtml($this->Serie_Equipo->FldCaption());

			// Id_Hardware
			$this->Id_Hardware->EditAttrs["class"] = "form-control";
			$this->Id_Hardware->EditCustomAttributes = "";
			$this->Id_Hardware->EditValue = ew_HtmlEncode($this->Id_Hardware->AdvancedSearch->SearchValue);
			$this->Id_Hardware->PlaceHolder = ew_RemoveHtml($this->Id_Hardware->FldCaption());

			// SN
			$this->SN->EditAttrs["class"] = "form-control";
			$this->SN->EditCustomAttributes = "";
			$this->SN->EditValue = ew_HtmlEncode($this->SN->AdvancedSearch->SearchValue);
			$this->SN->PlaceHolder = ew_RemoveHtml($this->SN->FldCaption());

			// Modelo_Net
			$this->Modelo_Net->EditAttrs["class"] = "form-control";
			$this->Modelo_Net->EditCustomAttributes = "";
			if (trim(strval($this->Modelo_Net->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Descripcion`" . ew_SearchString("=", $this->Modelo_Net->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Descripcion`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modelo`";
			$sWhereWrk = "";
			$this->Modelo_Net->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Modelo_Net, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Modelo_Net->EditValue = $arwrk;

			// Marca_Arranque
			$this->Marca_Arranque->EditAttrs["class"] = "form-control";
			$this->Marca_Arranque->EditCustomAttributes = "";
			$this->Marca_Arranque->EditValue = ew_HtmlEncode($this->Marca_Arranque->AdvancedSearch->SearchValue);
			$this->Marca_Arranque->PlaceHolder = ew_RemoveHtml($this->Marca_Arranque->FldCaption());

			// Nombre_Titular
			$this->Nombre_Titular->EditAttrs["class"] = "form-control";
			$this->Nombre_Titular->EditCustomAttributes = "";
			$this->Nombre_Titular->EditValue = ew_HtmlEncode($this->Nombre_Titular->AdvancedSearch->SearchValue);
			if (strval($this->Nombre_Titular->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Titular->AdvancedSearch->SearchValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Nombre_Titular->EditValue = $this->Nombre_Titular->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Nombre_Titular->EditValue = ew_HtmlEncode($this->Nombre_Titular->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Nombre_Titular->EditValue = NULL;
			}
			$this->Nombre_Titular->PlaceHolder = ew_RemoveHtml($this->Nombre_Titular->FldCaption());

			// Dni_Titular
			$this->Dni_Titular->EditAttrs["class"] = "form-control";
			$this->Dni_Titular->EditCustomAttributes = "";
			$this->Dni_Titular->EditValue = ew_HtmlEncode($this->Dni_Titular->AdvancedSearch->SearchValue);
			$this->Dni_Titular->PlaceHolder = ew_RemoveHtml($this->Dni_Titular->FldCaption());

			// Cuil_Titular
			$this->Cuil_Titular->EditAttrs["class"] = "form-control";
			$this->Cuil_Titular->EditCustomAttributes = "";
			$this->Cuil_Titular->EditValue = ew_HtmlEncode($this->Cuil_Titular->AdvancedSearch->SearchValue);
			$this->Cuil_Titular->PlaceHolder = ew_RemoveHtml($this->Cuil_Titular->FldCaption());

			// Nombre_Tutor
			$this->Nombre_Tutor->EditAttrs["class"] = "form-control";
			$this->Nombre_Tutor->EditCustomAttributes = "";
			$this->Nombre_Tutor->EditValue = ew_HtmlEncode($this->Nombre_Tutor->AdvancedSearch->SearchValue);
			if (strval($this->Nombre_Tutor->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nombre_Tutor->AdvancedSearch->SearchValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "";
			$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Nombre_Tutor->EditValue = $this->Nombre_Tutor->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Nombre_Tutor->EditValue = ew_HtmlEncode($this->Nombre_Tutor->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Nombre_Tutor->EditValue = NULL;
			}
			$this->Nombre_Tutor->PlaceHolder = ew_RemoveHtml($this->Nombre_Tutor->FldCaption());

			// DniTutor
			$this->DniTutor->EditAttrs["class"] = "form-control";
			$this->DniTutor->EditCustomAttributes = "";
			$this->DniTutor->EditValue = ew_HtmlEncode($this->DniTutor->AdvancedSearch->SearchValue);
			$this->DniTutor->PlaceHolder = ew_RemoveHtml($this->DniTutor->FldCaption());

			// Domicilio
			$this->Domicilio->EditAttrs["class"] = "form-control";
			$this->Domicilio->EditCustomAttributes = "";
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->AdvancedSearch->SearchValue);
			$this->Domicilio->PlaceHolder = ew_RemoveHtml($this->Domicilio->FldCaption());

			// Tel_Tutor
			$this->Tel_Tutor->EditAttrs["class"] = "form-control";
			$this->Tel_Tutor->EditCustomAttributes = "";
			$this->Tel_Tutor->EditValue = ew_HtmlEncode($this->Tel_Tutor->AdvancedSearch->SearchValue);
			$this->Tel_Tutor->PlaceHolder = ew_RemoveHtml($this->Tel_Tutor->FldCaption());

			// CelTutor
			$this->CelTutor->EditAttrs["class"] = "form-control";
			$this->CelTutor->EditCustomAttributes = "";
			$this->CelTutor->EditValue = ew_HtmlEncode($this->CelTutor->AdvancedSearch->SearchValue);
			$this->CelTutor->PlaceHolder = ew_RemoveHtml($this->CelTutor->FldCaption());

			// Cue_Establecimiento_Alta
			$this->Cue_Establecimiento_Alta->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento_Alta->EditCustomAttributes = "";
			$this->Cue_Establecimiento_Alta->EditValue = ew_HtmlEncode($this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue);
			if (strval($this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Cue_Establecimiento_Alta->EditValue = $this->Cue_Establecimiento_Alta->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Cue_Establecimiento_Alta->EditValue = ew_HtmlEncode($this->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Cue_Establecimiento_Alta->EditValue = NULL;
			}
			$this->Cue_Establecimiento_Alta->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento_Alta->FldCaption());

			// Escuela_Alta
			$this->Escuela_Alta->EditAttrs["class"] = "form-control";
			$this->Escuela_Alta->EditCustomAttributes = "";
			$this->Escuela_Alta->EditValue = ew_HtmlEncode($this->Escuela_Alta->AdvancedSearch->SearchValue);
			$this->Escuela_Alta->PlaceHolder = ew_RemoveHtml($this->Escuela_Alta->FldCaption());

			// Directivo_Alta
			$this->Directivo_Alta->EditAttrs["class"] = "form-control";
			$this->Directivo_Alta->EditCustomAttributes = "";
			$this->Directivo_Alta->EditValue = ew_HtmlEncode($this->Directivo_Alta->AdvancedSearch->SearchValue);
			$this->Directivo_Alta->PlaceHolder = ew_RemoveHtml($this->Directivo_Alta->FldCaption());

			// Cuil_Directivo_Alta
			$this->Cuil_Directivo_Alta->EditAttrs["class"] = "form-control";
			$this->Cuil_Directivo_Alta->EditCustomAttributes = "";
			$this->Cuil_Directivo_Alta->EditValue = ew_HtmlEncode($this->Cuil_Directivo_Alta->AdvancedSearch->SearchValue);
			$this->Cuil_Directivo_Alta->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo_Alta->FldCaption());

			// Dpto_Esc_alta
			$this->Dpto_Esc_alta->EditAttrs["class"] = "form-control";
			$this->Dpto_Esc_alta->EditCustomAttributes = "";
			if (trim(strval($this->Dpto_Esc_alta->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_alta->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Dpto_Esc_alta->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dpto_Esc_alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Dpto_Esc_alta->EditValue = $arwrk;

			// Localidad_Esc_Alta
			$this->Localidad_Esc_Alta->EditAttrs["class"] = "form-control";
			$this->Localidad_Esc_Alta->EditCustomAttributes = "";
			if (trim(strval($this->Localidad_Esc_Alta->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Alta->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Localidad_Esc_Alta->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Localidad_Esc_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Localidad_Esc_Alta->EditValue = $arwrk;

			// Domicilio_Esc_Alta
			$this->Domicilio_Esc_Alta->EditAttrs["class"] = "form-control";
			$this->Domicilio_Esc_Alta->EditCustomAttributes = "";
			$this->Domicilio_Esc_Alta->EditValue = ew_HtmlEncode($this->Domicilio_Esc_Alta->AdvancedSearch->SearchValue);
			$this->Domicilio_Esc_Alta->PlaceHolder = ew_RemoveHtml($this->Domicilio_Esc_Alta->FldCaption());

			// Rte_Alta
			$this->Rte_Alta->EditAttrs["class"] = "form-control";
			$this->Rte_Alta->EditCustomAttributes = "";
			$this->Rte_Alta->EditValue = ew_HtmlEncode($this->Rte_Alta->AdvancedSearch->SearchValue);
			$this->Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Rte_Alta->FldCaption());

			// Tel_Rte_Alta
			$this->Tel_Rte_Alta->EditAttrs["class"] = "form-control";
			$this->Tel_Rte_Alta->EditCustomAttributes = "";
			$this->Tel_Rte_Alta->EditValue = ew_HtmlEncode($this->Tel_Rte_Alta->AdvancedSearch->SearchValue);
			$this->Tel_Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Tel_Rte_Alta->FldCaption());

			// Email_Rte_Alta
			$this->Email_Rte_Alta->EditAttrs["class"] = "form-control";
			$this->Email_Rte_Alta->EditCustomAttributes = "";
			$this->Email_Rte_Alta->EditValue = ew_HtmlEncode($this->Email_Rte_Alta->AdvancedSearch->SearchValue);
			$this->Email_Rte_Alta->PlaceHolder = ew_RemoveHtml($this->Email_Rte_Alta->FldCaption());

			// Serie_Server_Alta
			$this->Serie_Server_Alta->EditAttrs["class"] = "form-control";
			$this->Serie_Server_Alta->EditCustomAttributes = "";
			$this->Serie_Server_Alta->EditValue = ew_HtmlEncode($this->Serie_Server_Alta->AdvancedSearch->SearchValue);
			$this->Serie_Server_Alta->PlaceHolder = ew_RemoveHtml($this->Serie_Server_Alta->FldCaption());

			// Cue_Establecimiento_Baja
			$this->Cue_Establecimiento_Baja->EditAttrs["class"] = "form-control";
			$this->Cue_Establecimiento_Baja->EditCustomAttributes = "";
			$this->Cue_Establecimiento_Baja->EditValue = ew_HtmlEncode($this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue);
			if (strval($this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Cue_Establecimiento`" . ew_SearchString("=", $this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->Cue_Establecimiento_Baja->EditValue = $this->Cue_Establecimiento_Baja->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Cue_Establecimiento_Baja->EditValue = ew_HtmlEncode($this->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue);
				}
			} else {
				$this->Cue_Establecimiento_Baja->EditValue = NULL;
			}
			$this->Cue_Establecimiento_Baja->PlaceHolder = ew_RemoveHtml($this->Cue_Establecimiento_Baja->FldCaption());

			// Escuela_Baja
			$this->Escuela_Baja->EditAttrs["class"] = "form-control";
			$this->Escuela_Baja->EditCustomAttributes = "";
			$this->Escuela_Baja->EditValue = ew_HtmlEncode($this->Escuela_Baja->AdvancedSearch->SearchValue);
			$this->Escuela_Baja->PlaceHolder = ew_RemoveHtml($this->Escuela_Baja->FldCaption());

			// Directivo_Baja
			$this->Directivo_Baja->EditAttrs["class"] = "form-control";
			$this->Directivo_Baja->EditCustomAttributes = "";
			$this->Directivo_Baja->EditValue = ew_HtmlEncode($this->Directivo_Baja->AdvancedSearch->SearchValue);
			$this->Directivo_Baja->PlaceHolder = ew_RemoveHtml($this->Directivo_Baja->FldCaption());

			// Cuil_Directivo_Baja
			$this->Cuil_Directivo_Baja->EditAttrs["class"] = "form-control";
			$this->Cuil_Directivo_Baja->EditCustomAttributes = "";
			$this->Cuil_Directivo_Baja->EditValue = ew_HtmlEncode($this->Cuil_Directivo_Baja->AdvancedSearch->SearchValue);
			$this->Cuil_Directivo_Baja->PlaceHolder = ew_RemoveHtml($this->Cuil_Directivo_Baja->FldCaption());

			// Dpto_Esc_Baja
			$this->Dpto_Esc_Baja->EditAttrs["class"] = "form-control";
			$this->Dpto_Esc_Baja->EditCustomAttributes = "";
			if (trim(strval($this->Dpto_Esc_Baja->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Dpto_Esc_Baja->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departamento`";
			$sWhereWrk = "";
			$this->Dpto_Esc_Baja->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Dpto_Esc_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Dpto_Esc_Baja->EditValue = $arwrk;

			// Localidad_Esc_Baja
			$this->Localidad_Esc_Baja->EditAttrs["class"] = "form-control";
			$this->Localidad_Esc_Baja->EditCustomAttributes = "";
			if (trim(strval($this->Localidad_Esc_Baja->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Nombre`" . ew_SearchString("=", $this->Localidad_Esc_Baja->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `Nombre`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `localidades`";
			$sWhereWrk = "";
			$this->Localidad_Esc_Baja->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Localidad_Esc_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Localidad_Esc_Baja->EditValue = $arwrk;

			// Domicilio_Esc_Baja
			$this->Domicilio_Esc_Baja->EditAttrs["class"] = "form-control";
			$this->Domicilio_Esc_Baja->EditCustomAttributes = "";
			$this->Domicilio_Esc_Baja->EditValue = ew_HtmlEncode($this->Domicilio_Esc_Baja->AdvancedSearch->SearchValue);
			$this->Domicilio_Esc_Baja->PlaceHolder = ew_RemoveHtml($this->Domicilio_Esc_Baja->FldCaption());

			// Rte_Baja
			$this->Rte_Baja->EditAttrs["class"] = "form-control";
			$this->Rte_Baja->EditCustomAttributes = "";
			$this->Rte_Baja->EditValue = ew_HtmlEncode($this->Rte_Baja->AdvancedSearch->SearchValue);
			$this->Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Rte_Baja->FldCaption());

			// Tel_Rte_Baja
			$this->Tel_Rte_Baja->EditAttrs["class"] = "form-control";
			$this->Tel_Rte_Baja->EditCustomAttributes = "";
			$this->Tel_Rte_Baja->EditValue = ew_HtmlEncode($this->Tel_Rte_Baja->AdvancedSearch->SearchValue);
			$this->Tel_Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Tel_Rte_Baja->FldCaption());

			// Email_Rte_Baja
			$this->Email_Rte_Baja->EditAttrs["class"] = "form-control";
			$this->Email_Rte_Baja->EditCustomAttributes = "";
			$this->Email_Rte_Baja->EditValue = ew_HtmlEncode($this->Email_Rte_Baja->AdvancedSearch->SearchValue);
			$this->Email_Rte_Baja->PlaceHolder = ew_RemoveHtml($this->Email_Rte_Baja->FldCaption());

			// Serie_Server_Baja
			$this->Serie_Server_Baja->EditAttrs["class"] = "form-control";
			$this->Serie_Server_Baja->EditCustomAttributes = "";
			$this->Serie_Server_Baja->EditValue = ew_HtmlEncode($this->Serie_Server_Baja->AdvancedSearch->SearchValue);
			$this->Serie_Server_Baja->PlaceHolder = ew_RemoveHtml($this->Serie_Server_Baja->FldCaption());

			// Fecha_Pase
			$this->Fecha_Pase->EditAttrs["class"] = "form-control";
			$this->Fecha_Pase->EditCustomAttributes = "";
			$this->Fecha_Pase->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha_Pase->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha_Pase->PlaceHolder = ew_RemoveHtml($this->Fecha_Pase->FldCaption());

			// Id_Estado_Pase
			$this->Id_Estado_Pase->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Pase->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Pase->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Pase`" . ew_SearchString("=", $this->Id_Estado_Pase->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Pase`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Estado_Pase->EditValue = $arwrk;

			// Ruta_Archivo
			$this->Ruta_Archivo->EditAttrs["class"] = "form-control";
			$this->Ruta_Archivo->EditCustomAttributes = "";
			$this->Ruta_Archivo->EditValue = ew_HtmlEncode($this->Ruta_Archivo->AdvancedSearch->SearchValue);
			$this->Ruta_Archivo->PlaceHolder = ew_RemoveHtml($this->Ruta_Archivo->FldCaption());
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
		if (!ew_CheckInteger($this->Id_Pase->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Id_Pase->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Dni_Titular->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Dni_Titular->FldErrMsg());
		}
		if (!ew_CheckInteger($this->DniTutor->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->DniTutor->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Pase->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha_Pase->FldErrMsg());
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
		$this->Id_Pase->AdvancedSearch->Load();
		$this->Serie_Equipo->AdvancedSearch->Load();
		$this->Id_Hardware->AdvancedSearch->Load();
		$this->SN->AdvancedSearch->Load();
		$this->Modelo_Net->AdvancedSearch->Load();
		$this->Marca_Arranque->AdvancedSearch->Load();
		$this->Nombre_Titular->AdvancedSearch->Load();
		$this->Dni_Titular->AdvancedSearch->Load();
		$this->Cuil_Titular->AdvancedSearch->Load();
		$this->Nombre_Tutor->AdvancedSearch->Load();
		$this->DniTutor->AdvancedSearch->Load();
		$this->Domicilio->AdvancedSearch->Load();
		$this->Tel_Tutor->AdvancedSearch->Load();
		$this->CelTutor->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Alta->AdvancedSearch->Load();
		$this->Escuela_Alta->AdvancedSearch->Load();
		$this->Directivo_Alta->AdvancedSearch->Load();
		$this->Cuil_Directivo_Alta->AdvancedSearch->Load();
		$this->Dpto_Esc_alta->AdvancedSearch->Load();
		$this->Localidad_Esc_Alta->AdvancedSearch->Load();
		$this->Domicilio_Esc_Alta->AdvancedSearch->Load();
		$this->Rte_Alta->AdvancedSearch->Load();
		$this->Tel_Rte_Alta->AdvancedSearch->Load();
		$this->Email_Rte_Alta->AdvancedSearch->Load();
		$this->Serie_Server_Alta->AdvancedSearch->Load();
		$this->Cue_Establecimiento_Baja->AdvancedSearch->Load();
		$this->Escuela_Baja->AdvancedSearch->Load();
		$this->Directivo_Baja->AdvancedSearch->Load();
		$this->Cuil_Directivo_Baja->AdvancedSearch->Load();
		$this->Dpto_Esc_Baja->AdvancedSearch->Load();
		$this->Localidad_Esc_Baja->AdvancedSearch->Load();
		$this->Domicilio_Esc_Baja->AdvancedSearch->Load();
		$this->Rte_Baja->AdvancedSearch->Load();
		$this->Tel_Rte_Baja->AdvancedSearch->Load();
		$this->Email_Rte_Baja->AdvancedSearch->Load();
		$this->Serie_Server_Baja->AdvancedSearch->Load();
		$this->Fecha_Pase->AdvancedSearch->Load();
		$this->Id_Estado_Pase->AdvancedSearch->Load();
		$this->Ruta_Archivo->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pase_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Serie_Equipo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Modelo_Net":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Descripcion` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modelo`";
			$sWhereWrk = "";
			$this->Modelo_Net->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Descripcion` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Modelo_Net, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nombre_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nombre_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tutores`";
			$sWhereWrk = "{filter}";
			$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dpto_Esc_alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->Dpto_Esc_alta->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dpto_Esc_alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Localidad_Esc_Alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "";
			$this->Localidad_Esc_Alta->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Localidad_Esc_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento` AS `LinkFld`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "{filter}";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Cue_Establecimiento` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Dpto_Esc_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departamento`";
			$sWhereWrk = "";
			$this->Dpto_Esc_Baja->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Dpto_Esc_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Localidad_Esc_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Nombre` AS `LinkFld`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `localidades`";
			$sWhereWrk = "";
			$this->Localidad_Esc_Baja->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Nombre` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Localidad_Esc_Baja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Estado_Pase":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Pase` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_pase`";
			$sWhereWrk = "";
			$this->Id_Estado_Pase->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Pase` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Estado_Pase, $sWhereWrk); // Call Lookup selecting
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
		case "x_Serie_Equipo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->Serie_Equipo->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Serie_Equipo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nombre_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Nombre_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nombre_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nombre_Tutor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `tutores`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Nombre_Tutor->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nombre_Tutor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Alta":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "`Cue_Establecimiento` LIKE '{query_value}%' OR CONCAT(`Cue_Establecimiento`,'" . ew_ValueSeparator(1, $this->Cue_Establecimiento_Alta) . "',`Nombre_Establecimiento`) LIKE '{query_value}%'";
			$this->Cue_Establecimiento_Alta->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Alta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Cue_Establecimiento_Baja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Cue_Establecimiento`, `Cue_Establecimiento` AS `DispFld`, `Nombre_Establecimiento` AS `Disp2Fld` FROM `establecimientos_educativos_pase`";
			$sWhereWrk = "`Cue_Establecimiento` LIKE '{query_value}%' OR CONCAT(`Cue_Establecimiento`,'" . ew_ValueSeparator(1, $this->Cue_Establecimiento_Baja) . "',`Nombre_Establecimiento`) LIKE '{query_value}%'";
			$this->Cue_Establecimiento_Baja->LookupFilters = array("dx1" => "`Cue_Establecimiento`", "dx2" => "`Nombre_Establecimiento`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Cue_Establecimiento_Baja, $sWhereWrk); // Call Lookup selecting
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
if (!isset($pase_establecimiento_search)) $pase_establecimiento_search = new cpase_establecimiento_search();

// Page init
$pase_establecimiento_search->Page_Init();

// Page main
$pase_establecimiento_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pase_establecimiento_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($pase_establecimiento_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fpase_establecimientosearch = new ew_Form("fpase_establecimientosearch", "search");
<?php } else { ?>
var CurrentForm = fpase_establecimientosearch = new ew_Form("fpase_establecimientosearch", "search");
<?php } ?>

// Form_CustomValidate event
fpase_establecimientosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpase_establecimientosearch.ValidateRequired = true;
<?php } else { ?>
fpase_establecimientosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpase_establecimientosearch.Lists["x_Serie_Equipo"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
fpase_establecimientosearch.Lists["x_Modelo_Net"] = {"LinkField":"x_Descripcion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo"};
fpase_establecimientosearch.Lists["x_Nombre_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
fpase_establecimientosearch.Lists["x_Nombre_Tutor"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":false,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tutores"};
fpase_establecimientosearch.Lists["x_Cue_Establecimiento_Alta"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientosearch.Lists["x_Dpto_Esc_alta"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpase_establecimientosearch.Lists["x_Localidad_Esc_Alta"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fpase_establecimientosearch.Lists["x_Cue_Establecimiento_Baja"] = {"LinkField":"x_Cue_Establecimiento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Cue_Establecimiento","x_Nombre_Establecimiento","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"establecimientos_educativos_pase"};
fpase_establecimientosearch.Lists["x_Dpto_Esc_Baja"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fpase_establecimientosearch.Lists["x_Localidad_Esc_Baja"] = {"LinkField":"x_Nombre","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"localidades"};
fpase_establecimientosearch.Lists["x_Id_Estado_Pase"] = {"LinkField":"x_Id_Estado_Pase","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_pase"};

// Form object for search
// Validate function for search

fpase_establecimientosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Id_Pase");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->Id_Pase->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Dni_Titular");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->Dni_Titular->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_DniTutor");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->DniTutor->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Fecha_Pase");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($pase_establecimiento->Fecha_Pase->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pase_establecimiento_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pase_establecimiento_search->ShowPageHeader(); ?>
<?php
$pase_establecimiento_search->ShowMessage();
?>
<form name="fpase_establecimientosearch" id="fpase_establecimientosearch" class="<?php echo $pase_establecimiento_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pase_establecimiento_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pase_establecimiento_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pase_establecimiento">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($pase_establecimiento_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pase_establecimiento->Id_Pase->Visible) { // Id_Pase ?>
	<div id="r_Id_Pase" class="form-group">
		<label for="x_Id_Pase" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Id_Pase"><?php echo $pase_establecimiento->Id_Pase->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Id_Pase" id="z_Id_Pase" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Id_Pase->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Id_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Id_Pase" name="x_Id_Pase" id="x_Id_Pase" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Id_Pase->EditValue ?>"<?php echo $pase_establecimiento->Id_Pase->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Equipo->Visible) { // Serie_Equipo ?>
	<div id="r_Serie_Equipo" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Serie_Equipo"><?php echo $pase_establecimiento->Serie_Equipo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Equipo" id="z_Serie_Equipo" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Serie_Equipo->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Serie_Equipo">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Serie_Equipo"><?php echo (strval($pase_establecimiento->Serie_Equipo->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Serie_Equipo->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Serie_Equipo->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Serie_Equipo',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Serie_Equipo" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Serie_Equipo->DisplayValueSeparatorAttribute() ?>" name="x_Serie_Equipo" id="x_Serie_Equipo" value="<?php echo $pase_establecimiento->Serie_Equipo->AdvancedSearch->SearchValue ?>"<?php echo $pase_establecimiento->Serie_Equipo->EditAttributes() ?>>
<input type="hidden" name="s_x_Serie_Equipo" id="s_x_Serie_Equipo" value="<?php echo $pase_establecimiento->Serie_Equipo->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Id_Hardware->Visible) { // Id_Hardware ?>
	<div id="r_Id_Hardware" class="form-group">
		<label for="x_Id_Hardware" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Id_Hardware"><?php echo $pase_establecimiento->Id_Hardware->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Hardware" id="z_Id_Hardware" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Id_Hardware->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Id_Hardware">
<input type="text" data-table="pase_establecimiento" data-field="x_Id_Hardware" name="x_Id_Hardware" id="x_Id_Hardware" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Id_Hardware->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Id_Hardware->EditValue ?>"<?php echo $pase_establecimiento->Id_Hardware->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->SN->Visible) { // SN ?>
	<div id="r_SN" class="form-group">
		<label for="x_SN" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_SN"><?php echo $pase_establecimiento->SN->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SN" id="z_SN" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->SN->CellAttributes() ?>>
			<span id="el_pase_establecimiento_SN">
<input type="text" data-table="pase_establecimiento" data-field="x_SN" name="x_SN" id="x_SN" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->SN->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->SN->EditValue ?>"<?php echo $pase_establecimiento->SN->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Modelo_Net->Visible) { // Modelo_Net ?>
	<div id="r_Modelo_Net" class="form-group">
		<label for="x_Modelo_Net" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Modelo_Net"><?php echo $pase_establecimiento->Modelo_Net->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Modelo_Net" id="z_Modelo_Net" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Modelo_Net->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Modelo_Net">
<select data-table="pase_establecimiento" data-field="x_Modelo_Net" data-value-separator="<?php echo $pase_establecimiento->Modelo_Net->DisplayValueSeparatorAttribute() ?>" id="x_Modelo_Net" name="x_Modelo_Net"<?php echo $pase_establecimiento->Modelo_Net->EditAttributes() ?>>
<?php echo $pase_establecimiento->Modelo_Net->SelectOptionListHtml("x_Modelo_Net") ?>
</select>
<input type="hidden" name="s_x_Modelo_Net" id="s_x_Modelo_Net" value="<?php echo $pase_establecimiento->Modelo_Net->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Marca_Arranque->Visible) { // Marca_Arranque ?>
	<div id="r_Marca_Arranque" class="form-group">
		<label for="x_Marca_Arranque" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Marca_Arranque"><?php echo $pase_establecimiento->Marca_Arranque->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Marca_Arranque" id="z_Marca_Arranque" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Marca_Arranque->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Marca_Arranque">
<input type="text" data-table="pase_establecimiento" data-field="x_Marca_Arranque" name="x_Marca_Arranque" id="x_Marca_Arranque" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Marca_Arranque->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Marca_Arranque->EditValue ?>"<?php echo $pase_establecimiento->Marca_Arranque->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Titular->Visible) { // Nombre_Titular ?>
	<div id="r_Nombre_Titular" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Nombre_Titular"><?php echo $pase_establecimiento->Nombre_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Titular" id="z_Nombre_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Nombre_Titular->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Nombre_Titular">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Nombre_Titular"><?php echo (strval($pase_establecimiento->Nombre_Titular->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Nombre_Titular->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Nombre_Titular->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Nombre_Titular',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Nombre_Titular" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Nombre_Titular->DisplayValueSeparatorAttribute() ?>" name="x_Nombre_Titular" id="x_Nombre_Titular" value="<?php echo $pase_establecimiento->Nombre_Titular->AdvancedSearch->SearchValue ?>"<?php echo $pase_establecimiento->Nombre_Titular->EditAttributes() ?>>
<input type="hidden" name="s_x_Nombre_Titular" id="s_x_Nombre_Titular" value="<?php echo $pase_establecimiento->Nombre_Titular->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Dni_Titular->Visible) { // Dni_Titular ?>
	<div id="r_Dni_Titular" class="form-group">
		<label for="x_Dni_Titular" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Dni_Titular"><?php echo $pase_establecimiento->Dni_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dni_Titular" id="z_Dni_Titular" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Dni_Titular->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Dni_Titular">
<input type="text" data-table="pase_establecimiento" data-field="x_Dni_Titular" name="x_Dni_Titular" id="x_Dni_Titular" size="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Dni_Titular->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Dni_Titular->EditValue ?>"<?php echo $pase_establecimiento->Dni_Titular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Titular->Visible) { // Cuil_Titular ?>
	<div id="r_Cuil_Titular" class="form-group">
		<label for="x_Cuil_Titular" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Cuil_Titular"><?php echo $pase_establecimiento->Cuil_Titular->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil_Titular" id="z_Cuil_Titular" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Cuil_Titular->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Cuil_Titular">
<input type="text" data-table="pase_establecimiento" data-field="x_Cuil_Titular" name="x_Cuil_Titular" id="x_Cuil_Titular" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Cuil_Titular->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Cuil_Titular->EditValue ?>"<?php echo $pase_establecimiento->Cuil_Titular->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Nombre_Tutor->Visible) { // Nombre_Tutor ?>
	<div id="r_Nombre_Tutor" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Nombre_Tutor"><?php echo $pase_establecimiento->Nombre_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nombre_Tutor" id="z_Nombre_Tutor" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Nombre_Tutor->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Nombre_Tutor">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Nombre_Tutor"><?php echo (strval($pase_establecimiento->Nombre_Tutor->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Nombre_Tutor->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Nombre_Tutor->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Nombre_Tutor',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Nombre_Tutor" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Nombre_Tutor->DisplayValueSeparatorAttribute() ?>" name="x_Nombre_Tutor" id="x_Nombre_Tutor" value="<?php echo $pase_establecimiento->Nombre_Tutor->AdvancedSearch->SearchValue ?>"<?php echo $pase_establecimiento->Nombre_Tutor->EditAttributes() ?>>
<input type="hidden" name="s_x_Nombre_Tutor" id="s_x_Nombre_Tutor" value="<?php echo $pase_establecimiento->Nombre_Tutor->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->DniTutor->Visible) { // DniTutor ?>
	<div id="r_DniTutor" class="form-group">
		<label for="x_DniTutor" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_DniTutor"><?php echo $pase_establecimiento->DniTutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_DniTutor" id="z_DniTutor" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->DniTutor->CellAttributes() ?>>
			<span id="el_pase_establecimiento_DniTutor">
<input type="text" data-table="pase_establecimiento" data-field="x_DniTutor" name="x_DniTutor" id="x_DniTutor" size="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->DniTutor->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->DniTutor->EditValue ?>"<?php echo $pase_establecimiento->DniTutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio->Visible) { // Domicilio ?>
	<div id="r_Domicilio" class="form-group">
		<label for="x_Domicilio" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Domicilio"><?php echo $pase_establecimiento->Domicilio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio" id="z_Domicilio" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Domicilio->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Domicilio">
<input type="text" data-table="pase_establecimiento" data-field="x_Domicilio" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Domicilio->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Domicilio->EditValue ?>"<?php echo $pase_establecimiento->Domicilio->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Tutor->Visible) { // Tel_Tutor ?>
	<div id="r_Tel_Tutor" class="form-group">
		<label for="x_Tel_Tutor" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Tel_Tutor"><?php echo $pase_establecimiento->Tel_Tutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tel_Tutor" id="z_Tel_Tutor" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Tel_Tutor->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Tel_Tutor">
<input type="text" data-table="pase_establecimiento" data-field="x_Tel_Tutor" name="x_Tel_Tutor" id="x_Tel_Tutor" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Tel_Tutor->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Tel_Tutor->EditValue ?>"<?php echo $pase_establecimiento->Tel_Tutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->CelTutor->Visible) { // CelTutor ?>
	<div id="r_CelTutor" class="form-group">
		<label for="x_CelTutor" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_CelTutor"><?php echo $pase_establecimiento->CelTutor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_CelTutor" id="z_CelTutor" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->CelTutor->CellAttributes() ?>>
			<span id="el_pase_establecimiento_CelTutor">
<input type="text" data-table="pase_establecimiento" data-field="x_CelTutor" name="x_CelTutor" id="x_CelTutor" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->CelTutor->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->CelTutor->EditValue ?>"<?php echo $pase_establecimiento->CelTutor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Alta->Visible) { // Cue_Establecimiento_Alta ?>
	<div id="r_Cue_Establecimiento_Alta" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Cue_Establecimiento_Alta"><?php echo $pase_establecimiento->Cue_Establecimiento_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue_Establecimiento_Alta" id="z_Cue_Establecimiento_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Cue_Establecimiento_Alta">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Cue_Establecimiento_Alta"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Alta->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Alta->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Alta->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Cue_Establecimiento_Alta',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Alta" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->DisplayValueSeparatorAttribute() ?>" name="x_Cue_Establecimiento_Alta" id="x_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->AdvancedSearch->SearchValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->EditAttributes() ?>>
<input type="hidden" name="s_x_Cue_Establecimiento_Alta" id="s_x_Cue_Establecimiento_Alta" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Alta->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Alta->Visible) { // Escuela_Alta ?>
	<div id="r_Escuela_Alta" class="form-group">
		<label for="x_Escuela_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Escuela_Alta"><?php echo $pase_establecimiento->Escuela_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Escuela_Alta" id="z_Escuela_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Escuela_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Escuela_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Escuela_Alta" name="x_Escuela_Alta" id="x_Escuela_Alta" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Escuela_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Escuela_Alta->EditValue ?>"<?php echo $pase_establecimiento->Escuela_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Directivo_Alta->Visible) { // Directivo_Alta ?>
	<div id="r_Directivo_Alta" class="form-group">
		<label for="x_Directivo_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Directivo_Alta"><?php echo $pase_establecimiento->Directivo_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Directivo_Alta" id="z_Directivo_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Directivo_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Directivo_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Directivo_Alta" name="x_Directivo_Alta" id="x_Directivo_Alta" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Directivo_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Directivo_Alta->EditValue ?>"<?php echo $pase_establecimiento->Directivo_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Directivo_Alta->Visible) { // Cuil_Directivo_Alta ?>
	<div id="r_Cuil_Directivo_Alta" class="form-group">
		<label for="x_Cuil_Directivo_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Cuil_Directivo_Alta"><?php echo $pase_establecimiento->Cuil_Directivo_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil_Directivo_Alta" id="z_Cuil_Directivo_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Cuil_Directivo_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Cuil_Directivo_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Cuil_Directivo_Alta" name="x_Cuil_Directivo_Alta" id="x_Cuil_Directivo_Alta" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Cuil_Directivo_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Cuil_Directivo_Alta->EditValue ?>"<?php echo $pase_establecimiento->Cuil_Directivo_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Dpto_Esc_alta->Visible) { // Dpto_Esc_alta ?>
	<div id="r_Dpto_Esc_alta" class="form-group">
		<label for="x_Dpto_Esc_alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Dpto_Esc_alta"><?php echo $pase_establecimiento->Dpto_Esc_alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dpto_Esc_alta" id="z_Dpto_Esc_alta" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Dpto_Esc_alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Dpto_Esc_alta">
<select data-table="pase_establecimiento" data-field="x_Dpto_Esc_alta" data-value-separator="<?php echo $pase_establecimiento->Dpto_Esc_alta->DisplayValueSeparatorAttribute() ?>" id="x_Dpto_Esc_alta" name="x_Dpto_Esc_alta"<?php echo $pase_establecimiento->Dpto_Esc_alta->EditAttributes() ?>>
<?php echo $pase_establecimiento->Dpto_Esc_alta->SelectOptionListHtml("x_Dpto_Esc_alta") ?>
</select>
<input type="hidden" name="s_x_Dpto_Esc_alta" id="s_x_Dpto_Esc_alta" value="<?php echo $pase_establecimiento->Dpto_Esc_alta->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Localidad_Esc_Alta->Visible) { // Localidad_Esc_Alta ?>
	<div id="r_Localidad_Esc_Alta" class="form-group">
		<label for="x_Localidad_Esc_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Localidad_Esc_Alta"><?php echo $pase_establecimiento->Localidad_Esc_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Localidad_Esc_Alta" id="z_Localidad_Esc_Alta" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Localidad_Esc_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Localidad_Esc_Alta">
<select data-table="pase_establecimiento" data-field="x_Localidad_Esc_Alta" data-value-separator="<?php echo $pase_establecimiento->Localidad_Esc_Alta->DisplayValueSeparatorAttribute() ?>" id="x_Localidad_Esc_Alta" name="x_Localidad_Esc_Alta"<?php echo $pase_establecimiento->Localidad_Esc_Alta->EditAttributes() ?>>
<?php echo $pase_establecimiento->Localidad_Esc_Alta->SelectOptionListHtml("x_Localidad_Esc_Alta") ?>
</select>
<input type="hidden" name="s_x_Localidad_Esc_Alta" id="s_x_Localidad_Esc_Alta" value="<?php echo $pase_establecimiento->Localidad_Esc_Alta->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio_Esc_Alta->Visible) { // Domicilio_Esc_Alta ?>
	<div id="r_Domicilio_Esc_Alta" class="form-group">
		<label for="x_Domicilio_Esc_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Domicilio_Esc_Alta"><?php echo $pase_establecimiento->Domicilio_Esc_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio_Esc_Alta" id="z_Domicilio_Esc_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Domicilio_Esc_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Domicilio_Esc_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Domicilio_Esc_Alta" name="x_Domicilio_Esc_Alta" id="x_Domicilio_Esc_Alta" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Domicilio_Esc_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Domicilio_Esc_Alta->EditValue ?>"<?php echo $pase_establecimiento->Domicilio_Esc_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Rte_Alta->Visible) { // Rte_Alta ?>
	<div id="r_Rte_Alta" class="form-group">
		<label for="x_Rte_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Rte_Alta"><?php echo $pase_establecimiento->Rte_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Rte_Alta" id="z_Rte_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Rte_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Rte_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Rte_Alta" name="x_Rte_Alta" id="x_Rte_Alta" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Rte_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Rte_Alta->EditValue ?>"<?php echo $pase_establecimiento->Rte_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Rte_Alta->Visible) { // Tel_Rte_Alta ?>
	<div id="r_Tel_Rte_Alta" class="form-group">
		<label for="x_Tel_Rte_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Tel_Rte_Alta"><?php echo $pase_establecimiento->Tel_Rte_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tel_Rte_Alta" id="z_Tel_Rte_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Tel_Rte_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Tel_Rte_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Tel_Rte_Alta" name="x_Tel_Rte_Alta" id="x_Tel_Rte_Alta" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Tel_Rte_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Tel_Rte_Alta->EditValue ?>"<?php echo $pase_establecimiento->Tel_Rte_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Email_Rte_Alta->Visible) { // Email_Rte_Alta ?>
	<div id="r_Email_Rte_Alta" class="form-group">
		<label for="x_Email_Rte_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Email_Rte_Alta"><?php echo $pase_establecimiento->Email_Rte_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Email_Rte_Alta" id="z_Email_Rte_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Email_Rte_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Email_Rte_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Email_Rte_Alta" name="x_Email_Rte_Alta" id="x_Email_Rte_Alta" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Email_Rte_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Email_Rte_Alta->EditValue ?>"<?php echo $pase_establecimiento->Email_Rte_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Server_Alta->Visible) { // Serie_Server_Alta ?>
	<div id="r_Serie_Server_Alta" class="form-group">
		<label for="x_Serie_Server_Alta" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Serie_Server_Alta"><?php echo $pase_establecimiento->Serie_Server_Alta->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Server_Alta" id="z_Serie_Server_Alta" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Serie_Server_Alta->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Serie_Server_Alta">
<input type="text" data-table="pase_establecimiento" data-field="x_Serie_Server_Alta" name="x_Serie_Server_Alta" id="x_Serie_Server_Alta" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Serie_Server_Alta->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Serie_Server_Alta->EditValue ?>"<?php echo $pase_establecimiento->Serie_Server_Alta->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cue_Establecimiento_Baja->Visible) { // Cue_Establecimiento_Baja ?>
	<div id="r_Cue_Establecimiento_Baja" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Cue_Establecimiento_Baja"><?php echo $pase_establecimiento->Cue_Establecimiento_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cue_Establecimiento_Baja" id="z_Cue_Establecimiento_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Cue_Establecimiento_Baja">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Cue_Establecimiento_Baja"><?php echo (strval($pase_establecimiento->Cue_Establecimiento_Baja->AdvancedSearch->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pase_establecimiento->Cue_Establecimiento_Baja->AdvancedSearch->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pase_establecimiento->Cue_Establecimiento_Baja->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Cue_Establecimiento_Baja',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pase_establecimiento" data-field="x_Cue_Establecimiento_Baja" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->DisplayValueSeparatorAttribute() ?>" name="x_Cue_Establecimiento_Baja" id="x_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->AdvancedSearch->SearchValue ?>"<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->EditAttributes() ?>>
<input type="hidden" name="s_x_Cue_Establecimiento_Baja" id="s_x_Cue_Establecimiento_Baja" value="<?php echo $pase_establecimiento->Cue_Establecimiento_Baja->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Escuela_Baja->Visible) { // Escuela_Baja ?>
	<div id="r_Escuela_Baja" class="form-group">
		<label for="x_Escuela_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Escuela_Baja"><?php echo $pase_establecimiento->Escuela_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Escuela_Baja" id="z_Escuela_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Escuela_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Escuela_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Escuela_Baja" name="x_Escuela_Baja" id="x_Escuela_Baja" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Escuela_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Escuela_Baja->EditValue ?>"<?php echo $pase_establecimiento->Escuela_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Directivo_Baja->Visible) { // Directivo_Baja ?>
	<div id="r_Directivo_Baja" class="form-group">
		<label for="x_Directivo_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Directivo_Baja"><?php echo $pase_establecimiento->Directivo_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Directivo_Baja" id="z_Directivo_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Directivo_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Directivo_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Directivo_Baja" name="x_Directivo_Baja" id="x_Directivo_Baja" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Directivo_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Directivo_Baja->EditValue ?>"<?php echo $pase_establecimiento->Directivo_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Cuil_Directivo_Baja->Visible) { // Cuil_Directivo_Baja ?>
	<div id="r_Cuil_Directivo_Baja" class="form-group">
		<label for="x_Cuil_Directivo_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Cuil_Directivo_Baja"><?php echo $pase_establecimiento->Cuil_Directivo_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cuil_Directivo_Baja" id="z_Cuil_Directivo_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Cuil_Directivo_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Cuil_Directivo_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Cuil_Directivo_Baja" name="x_Cuil_Directivo_Baja" id="x_Cuil_Directivo_Baja" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Cuil_Directivo_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Cuil_Directivo_Baja->EditValue ?>"<?php echo $pase_establecimiento->Cuil_Directivo_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Dpto_Esc_Baja->Visible) { // Dpto_Esc_Baja ?>
	<div id="r_Dpto_Esc_Baja" class="form-group">
		<label for="x_Dpto_Esc_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Dpto_Esc_Baja"><?php echo $pase_establecimiento->Dpto_Esc_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Dpto_Esc_Baja" id="z_Dpto_Esc_Baja" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Dpto_Esc_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Dpto_Esc_Baja">
<select data-table="pase_establecimiento" data-field="x_Dpto_Esc_Baja" data-value-separator="<?php echo $pase_establecimiento->Dpto_Esc_Baja->DisplayValueSeparatorAttribute() ?>" id="x_Dpto_Esc_Baja" name="x_Dpto_Esc_Baja"<?php echo $pase_establecimiento->Dpto_Esc_Baja->EditAttributes() ?>>
<?php echo $pase_establecimiento->Dpto_Esc_Baja->SelectOptionListHtml("x_Dpto_Esc_Baja") ?>
</select>
<input type="hidden" name="s_x_Dpto_Esc_Baja" id="s_x_Dpto_Esc_Baja" value="<?php echo $pase_establecimiento->Dpto_Esc_Baja->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Localidad_Esc_Baja->Visible) { // Localidad_Esc_Baja ?>
	<div id="r_Localidad_Esc_Baja" class="form-group">
		<label for="x_Localidad_Esc_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Localidad_Esc_Baja"><?php echo $pase_establecimiento->Localidad_Esc_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Localidad_Esc_Baja" id="z_Localidad_Esc_Baja" value="="></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Localidad_Esc_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Localidad_Esc_Baja">
<select data-table="pase_establecimiento" data-field="x_Localidad_Esc_Baja" data-value-separator="<?php echo $pase_establecimiento->Localidad_Esc_Baja->DisplayValueSeparatorAttribute() ?>" id="x_Localidad_Esc_Baja" name="x_Localidad_Esc_Baja"<?php echo $pase_establecimiento->Localidad_Esc_Baja->EditAttributes() ?>>
<?php echo $pase_establecimiento->Localidad_Esc_Baja->SelectOptionListHtml("x_Localidad_Esc_Baja") ?>
</select>
<input type="hidden" name="s_x_Localidad_Esc_Baja" id="s_x_Localidad_Esc_Baja" value="<?php echo $pase_establecimiento->Localidad_Esc_Baja->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Domicilio_Esc_Baja->Visible) { // Domicilio_Esc_Baja ?>
	<div id="r_Domicilio_Esc_Baja" class="form-group">
		<label for="x_Domicilio_Esc_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Domicilio_Esc_Baja"><?php echo $pase_establecimiento->Domicilio_Esc_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Domicilio_Esc_Baja" id="z_Domicilio_Esc_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Domicilio_Esc_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Domicilio_Esc_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Domicilio_Esc_Baja" name="x_Domicilio_Esc_Baja" id="x_Domicilio_Esc_Baja" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Domicilio_Esc_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Domicilio_Esc_Baja->EditValue ?>"<?php echo $pase_establecimiento->Domicilio_Esc_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Rte_Baja->Visible) { // Rte_Baja ?>
	<div id="r_Rte_Baja" class="form-group">
		<label for="x_Rte_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Rte_Baja"><?php echo $pase_establecimiento->Rte_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Rte_Baja" id="z_Rte_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Rte_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Rte_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Rte_Baja" name="x_Rte_Baja" id="x_Rte_Baja" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Rte_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Rte_Baja->EditValue ?>"<?php echo $pase_establecimiento->Rte_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Tel_Rte_Baja->Visible) { // Tel_Rte_Baja ?>
	<div id="r_Tel_Rte_Baja" class="form-group">
		<label for="x_Tel_Rte_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Tel_Rte_Baja"><?php echo $pase_establecimiento->Tel_Rte_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Tel_Rte_Baja" id="z_Tel_Rte_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Tel_Rte_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Tel_Rte_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Tel_Rte_Baja" name="x_Tel_Rte_Baja" id="x_Tel_Rte_Baja" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Tel_Rte_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Tel_Rte_Baja->EditValue ?>"<?php echo $pase_establecimiento->Tel_Rte_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Email_Rte_Baja->Visible) { // Email_Rte_Baja ?>
	<div id="r_Email_Rte_Baja" class="form-group">
		<label for="x_Email_Rte_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Email_Rte_Baja"><?php echo $pase_establecimiento->Email_Rte_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Email_Rte_Baja" id="z_Email_Rte_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Email_Rte_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Email_Rte_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Email_Rte_Baja" name="x_Email_Rte_Baja" id="x_Email_Rte_Baja" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Email_Rte_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Email_Rte_Baja->EditValue ?>"<?php echo $pase_establecimiento->Email_Rte_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Serie_Server_Baja->Visible) { // Serie_Server_Baja ?>
	<div id="r_Serie_Server_Baja" class="form-group">
		<label for="x_Serie_Server_Baja" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Serie_Server_Baja"><?php echo $pase_establecimiento->Serie_Server_Baja->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Serie_Server_Baja" id="z_Serie_Server_Baja" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Serie_Server_Baja->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Serie_Server_Baja">
<input type="text" data-table="pase_establecimiento" data-field="x_Serie_Server_Baja" name="x_Serie_Server_Baja" id="x_Serie_Server_Baja" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Serie_Server_Baja->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Serie_Server_Baja->EditValue ?>"<?php echo $pase_establecimiento->Serie_Server_Baja->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Fecha_Pase->Visible) { // Fecha_Pase ?>
	<div id="r_Fecha_Pase" class="form-group">
		<label for="x_Fecha_Pase" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Fecha_Pase"><?php echo $pase_establecimiento->Fecha_Pase->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Fecha_Pase" id="z_Fecha_Pase" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Fecha_Pase->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Fecha_Pase">
<input type="text" data-table="pase_establecimiento" data-field="x_Fecha_Pase" data-format="7" name="x_Fecha_Pase" id="x_Fecha_Pase" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Fecha_Pase->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Fecha_Pase->EditValue ?>"<?php echo $pase_establecimiento->Fecha_Pase->EditAttributes() ?>>
<?php if (!$pase_establecimiento->Fecha_Pase->ReadOnly && !$pase_establecimiento->Fecha_Pase->Disabled && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["readonly"]) && !isset($pase_establecimiento->Fecha_Pase->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpase_establecimientosearch", "x_Fecha_Pase", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Id_Estado_Pase->Visible) { // Id_Estado_Pase ?>
	<div id="r_Id_Estado_Pase" class="form-group">
		<label for="x_Id_Estado_Pase" class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Id_Estado_Pase"><?php echo $pase_establecimiento->Id_Estado_Pase->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Id_Estado_Pase" id="z_Id_Estado_Pase" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Id_Estado_Pase->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Id_Estado_Pase">
<select data-table="pase_establecimiento" data-field="x_Id_Estado_Pase" data-value-separator="<?php echo $pase_establecimiento->Id_Estado_Pase->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Pase" name="x_Id_Estado_Pase"<?php echo $pase_establecimiento->Id_Estado_Pase->EditAttributes() ?>>
<?php echo $pase_establecimiento->Id_Estado_Pase->SelectOptionListHtml("x_Id_Estado_Pase") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Pase" id="s_x_Id_Estado_Pase" value="<?php echo $pase_establecimiento->Id_Estado_Pase->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pase_establecimiento->Ruta_Archivo->Visible) { // Ruta_Archivo ?>
	<div id="r_Ruta_Archivo" class="form-group">
		<label class="<?php echo $pase_establecimiento_search->SearchLabelClass ?>"><span id="elh_pase_establecimiento_Ruta_Archivo"><?php echo $pase_establecimiento->Ruta_Archivo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Ruta_Archivo" id="z_Ruta_Archivo" value="LIKE"></p>
		</label>
		<div class="<?php echo $pase_establecimiento_search->SearchRightColumnClass ?>"><div<?php echo $pase_establecimiento->Ruta_Archivo->CellAttributes() ?>>
			<span id="el_pase_establecimiento_Ruta_Archivo">
<input type="text" data-table="pase_establecimiento" data-field="x_Ruta_Archivo" name="x_Ruta_Archivo" id="x_Ruta_Archivo" placeholder="<?php echo ew_HtmlEncode($pase_establecimiento->Ruta_Archivo->getPlaceHolder()) ?>" value="<?php echo $pase_establecimiento->Ruta_Archivo->EditValue ?>"<?php echo $pase_establecimiento->Ruta_Archivo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pase_establecimiento_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpase_establecimientosearch.Init();
</script>
<?php
$pase_establecimiento_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pase_establecimiento_search->Page_Terminate();
?>
