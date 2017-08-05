<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();

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
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;

		// If session expired, show session expired message
		if (@$_GET["expired"] == "1")
			$this->setFailureMessage($Language->Phrase("SessionExpired"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn())
		$this->Page_Terminate("personaslist.php"); // Exit and go to default page
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("autoridades_escolareslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("cargo_personalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("cursoslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("denuncia_robo_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("detalle_atencionlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("devolucion_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("divisionlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("equiposlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("establecimientos_educativos_paselist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_actual_legajo_personalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_actual_solucion_problemalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_personalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_civillist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_deuncialist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_paselist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_prestamo_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("liberacion_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("localidadeslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("marcalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("materias_adeudadaslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("materias_anualeslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("modalidad_establecimientolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("modelolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("motivo_prestamo_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("motivo_reasignacionlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("paiseslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("nivel_educativolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("observacion_personalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("observacion_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("ocupacion_tutorlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("pase_establecimientolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("prestamo_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("problemalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("provinciaslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("reasignacion_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("sexo_personaslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("situacion_estadolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tipo_prioridad_atencionlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tipo_relacion_alumno_tutorlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tipo_retiro_atencion_stlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tipo_solucion_problemalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("turnolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tutoreslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("ubicacion_equipolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_equipo_devuletolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("dato_establecimientolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("cargo_autoridadlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_serverlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("marca_serverlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("modelo_serverlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("piso_tecnologicolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("referente_tecnicolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("servidor_escolarlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("so_serverlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("turno_rtelist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("estado_equipos_pisolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("ano_entregalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("tipo_fallalist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("atencion_equiposlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("atencion_para_stlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("observacion_tutorlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("view1list.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("Report1report.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("departamentolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("motivo_devolucionlist.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage(ew_DeniedMsg() . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "footer.php" ?>
<?php
$default->Page_Terminate();
?>
