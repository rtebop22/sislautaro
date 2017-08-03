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
		global $UserTable, $UserTableConn;
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
		$Security->LoadUserLevel(); // Load User Level
		if ($Security->AllowList(CurrentProjectID() . 'atencion_equipos'))
		$this->Page_Terminate("atencion_equiposlist.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . 'autoridades_escolares'))
			$this->Page_Terminate("autoridades_escolareslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cargo_persona'))
			$this->Page_Terminate("cargo_personalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cursos'))
			$this->Page_Terminate("cursoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'denuncia_robo_equipo'))
			$this->Page_Terminate("denuncia_robo_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detalle_atencion'))
			$this->Page_Terminate("detalle_atencionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'devolucion_equipo'))
			$this->Page_Terminate("devolucion_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'division'))
			$this->Page_Terminate("divisionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'equipos'))
			$this->Page_Terminate("equiposlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'establecimientos_educativos_pase'))
			$this->Page_Terminate("establecimientos_educativos_paselist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_actual_legajo_persona'))
			$this->Page_Terminate("estado_actual_legajo_personalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_actual_solucion_problema'))
			$this->Page_Terminate("estado_actual_solucion_problemalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_persona'))
			$this->Page_Terminate("estado_personalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_civil'))
			$this->Page_Terminate("estado_civillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_denuncia'))
			$this->Page_Terminate("estado_denuncialist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_equipo'))
			$this->Page_Terminate("estado_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_pase'))
			$this->Page_Terminate("estado_paselist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_prestamo_equipo'))
			$this->Page_Terminate("estado_prestamo_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'liberacion_equipo'))
			$this->Page_Terminate("liberacion_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'localidades'))
			$this->Page_Terminate("localidadeslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'marca'))
			$this->Page_Terminate("marcalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'materias_adeudadas'))
			$this->Page_Terminate("materias_adeudadaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'materias_anuales'))
			$this->Page_Terminate("materias_anualeslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'modalidad_establecimiento'))
			$this->Page_Terminate("modalidad_establecimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'modelo'))
			$this->Page_Terminate("modelolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'motivo_prestamo_equipo'))
			$this->Page_Terminate("motivo_prestamo_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'motivo_reasignacion'))
			$this->Page_Terminate("motivo_reasignacionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'paises'))
			$this->Page_Terminate("paiseslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'nivel_educativo'))
			$this->Page_Terminate("nivel_educativolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'observacion_persona'))
			$this->Page_Terminate("observacion_personalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'observacion_equipo'))
			$this->Page_Terminate("observacion_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'ocupacion_tutor'))
			$this->Page_Terminate("ocupacion_tutorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pase_establecimiento'))
			$this->Page_Terminate("pase_establecimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'prestamo_equipo'))
			$this->Page_Terminate("prestamo_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'problema'))
			$this->Page_Terminate("problemalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'provincias'))
			$this->Page_Terminate("provinciaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'reasignacion_equipo'))
			$this->Page_Terminate("reasignacion_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'sexo_personas'))
			$this->Page_Terminate("sexo_personaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'situacion_estado'))
			$this->Page_Terminate("situacion_estadolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_prioridad_atencion'))
			$this->Page_Terminate("tipo_prioridad_atencionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_relacion_alumno_tutor'))
			$this->Page_Terminate("tipo_relacion_alumno_tutorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_retiro_atencion_st'))
			$this->Page_Terminate("tipo_retiro_atencion_stlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_solucion_problema'))
			$this->Page_Terminate("tipo_solucion_problemalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'turno'))
			$this->Page_Terminate("turnolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tutores'))
			$this->Page_Terminate("tutoreslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'ubicacion_equipo'))
			$this->Page_Terminate("ubicacion_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_equipo_devuelto'))
			$this->Page_Terminate("estado_equipo_devueltolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'personas'))
			$this->Page_Terminate("personaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'dato_establecimiento'))
			$this->Page_Terminate("dato_establecimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cargo_autoridad'))
			$this->Page_Terminate("cargo_autoridadlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_server'))
			$this->Page_Terminate("estado_serverlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'marca_server'))
			$this->Page_Terminate("marca_serverlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'modelo_server'))
			$this->Page_Terminate("modelo_serverlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'piso_tecnologico'))
			$this->Page_Terminate("piso_tecnologicolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'referente_tecnico'))
			$this->Page_Terminate("referente_tecnicolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'servidor_escolar'))
			$this->Page_Terminate("servidor_escolarlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'so_server'))
			$this->Page_Terminate("so_serverlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'turno_rte'))
			$this->Page_Terminate("turno_rtelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_equipos_piso'))
			$this->Page_Terminate("estado_equipos_pisolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'ano_entrega'))
			$this->Page_Terminate("ano_entregalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_falla'))
			$this->Page_Terminate("tipo_fallalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'atencion_para_st'))
			$this->Page_Terminate("atencion_para_stlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'audittrail'))
			$this->Page_Terminate("audittraillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'observacion_tutor'))
			$this->Page_Terminate("observacion_tutorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'departamento'))
			$this->Page_Terminate("departamentolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'motivo_devolucion'))
			$this->Page_Terminate("motivo_devolucionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_devolucion_prestamo'))
			$this->Page_Terminate("estado_devolucion_prestamolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_paquete'))
			$this->Page_Terminate("estado_paquetelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'paquetes_provision'))
			$this->Page_Terminate("paquetes_provisionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_extraccion'))
			$this->Page_Terminate("tipo_extraccionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'motivo_pedido_paquetes'))
			$this->Page_Terminate("motivo_pedido_paqueteslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'usuarios'))
			$this->Page_Terminate("usuarioslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'userlevelpermissions'))
			$this->Page_Terminate("userlevelpermissionslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'userlevels'))
			$this->Page_Terminate("userlevelslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_espera_prestamo'))
			$this->Page_Terminate("estado_espera_prestamolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'lista_espera_prestamo'))
			$this->Page_Terminate("lista_espera_prestamolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'historial_atencion'))
			$this->Page_Terminate("historial_atencionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'titulares-equipos-tutores'))
			$this->Page_Terminate("titulares2Dequipos2Dtutoreslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'titularidad-equipos'))
			$this->Page_Terminate("titularidad2Dequiposlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_titulares_cursos'))
			$this->Page_Terminate("estado_titulares_cursoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_documentacion_personas'))
			$this->Page_Terminate("estado_documentacion_personaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'alumnos_porcurso'))
			$this->Page_Terminate("alumnos_porcursolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pedido_st'))
			$this->Page_Terminate("pedido_stlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'historial_atenciones'))
			$this->Page_Terminate("historial_atencioneslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'datosestablecimiento'))
			$this->Page_Terminate("datosestablecimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'datosdirectivos'))
			$this->Page_Terminate("datosdirectivoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'datos_extras_escuela'))
			$this->Page_Terminate("datos_extras_escuelalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'datosservidor'))
			$this->Page_Terminate("datosservidorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'datosextrasescuela'))
			$this->Page_Terminate("datosextrasescuelalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'chat'))
			$this->Page_Terminate("chatlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'conversaciones'))
			$this->Page_Terminate("conversacioneslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'todas_atenciones'))
			$this->Page_Terminate("todas_atencioneslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'asistencia_rte'))
			$this->Page_Terminate("asistencia_rtelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detalle_asistencia'))
			$this->Page_Terminate("detalle_asistencialist.php");
		if ($Security->AllowList(CurrentProjectID() . 'seguimientodeequipos'))
			$this->Page_Terminate("seguimientodeequiposlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'seguimientodepersonas'))
			$this->Page_Terminate("seguimientodepersonaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Estadistica de Atenciones'))
			$this->Page_Terminate("Estadistica_de_Atencionesreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Estadistica de las personas'))
			$this->Page_Terminate("Estadistica_de_las_personasreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Estadistica de Equipos'))
			$this->Page_Terminate("Estadistica_de_Equiposreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'MarcarRetiroSt'))
			$this->Page_Terminate("MarcarRetiroStreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'asistencia_alumnos'))
			$this->Page_Terminate("asistencia_alumnoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'zonas'))
			$this->Page_Terminate("zonaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_escuela'))
			$this->Page_Terminate("tipo_escuelalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_jornada'))
			$this->Page_Terminate("tipo_jornadalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_establecimiento'))
			$this->Page_Terminate("estado_establecimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'novedades'))
			$this->Page_Terminate("novedadeslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_equipo'))
			$this->Page_Terminate("tipo_equipolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'estado_equipo_porcurso'))
			$this->Page_Terminate("estado_equipo_porcursolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_paquete'))
			$this->Page_Terminate("tipo_paquetelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pedido_paquetes'))
			$this->Page_Terminate("pedido_paqueteslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'etiquetasequipos'))
			$this->Page_Terminate("etiquetasequiposlist.php");
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
