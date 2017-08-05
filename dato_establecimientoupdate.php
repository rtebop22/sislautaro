<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "autoridades_escolaresgridcls.php" ?>
<?php include_once "referente_tecnicogridcls.php" ?>
<?php include_once "piso_tecnologicogridcls.php" ?>
<?php include_once "servidor_escolargridcls.php" ?>
<?php include_once "datos_extras_escuelagridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dato_establecimiento_update = NULL; // Initialize page object first

class cdato_establecimiento_update extends cdato_establecimiento {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'dato_establecimiento';

	// Page object name
	var $PageObjName = 'dato_establecimiento_update';

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
	var $AuditTrailOnEdit = TRUE;
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
			define("EW_PAGE_ID", 'update', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->Sigla->SetVisibility();
		$this->Nro_Cuise->SetVisibility();
		$this->Id_Departamento->SetVisibility();
		$this->Id_Localidad->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'autoridades_escolares'
			if (@$_POST["grid"] == "fautoridades_escolaresgrid") {
				if (!isset($GLOBALS["autoridades_escolares_grid"])) $GLOBALS["autoridades_escolares_grid"] = new cautoridades_escolares_grid;
				$GLOBALS["autoridades_escolares_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'referente_tecnico'
			if (@$_POST["grid"] == "freferente_tecnicogrid") {
				if (!isset($GLOBALS["referente_tecnico_grid"])) $GLOBALS["referente_tecnico_grid"] = new creferente_tecnico_grid;
				$GLOBALS["referente_tecnico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'piso_tecnologico'
			if (@$_POST["grid"] == "fpiso_tecnologicogrid") {
				if (!isset($GLOBALS["piso_tecnologico_grid"])) $GLOBALS["piso_tecnologico_grid"] = new cpiso_tecnologico_grid;
				$GLOBALS["piso_tecnologico_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'servidor_escolar'
			if (@$_POST["grid"] == "fservidor_escolargrid") {
				if (!isset($GLOBALS["servidor_escolar_grid"])) $GLOBALS["servidor_escolar_grid"] = new cservidor_escolar_grid;
				$GLOBALS["servidor_escolar_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'datos_extras_escuela'
			if (@$_POST["grid"] == "fdatos_extras_escuelagrid") {
				if (!isset($GLOBALS["datos_extras_escuela_grid"])) $GLOBALS["datos_extras_escuela_grid"] = new cdatos_extras_escuela_grid;
				$GLOBALS["datos_extras_escuela_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("dato_establecimientolist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Sigla->setDbValue($this->Recordset->fields('Sigla'));
					$this->Nro_Cuise->setDbValue($this->Recordset->fields('Nro_Cuise'));
					$this->Id_Departamento->setDbValue($this->Recordset->fields('Id_Departamento'));
					$this->Id_Localidad->setDbValue($this->Recordset->fields('Id_Localidad'));
					$this->Cantidad_Aulas->setDbValue($this->Recordset->fields('Cantidad_Aulas'));
					$this->Comparte_Edificio->setDbValue($this->Recordset->fields('Comparte_Edificio'));
					$this->Cantidad_Turnos->setDbValue($this->Recordset->fields('Cantidad_Turnos'));
					$this->Geolocalizacion->setDbValue($this->Recordset->fields('Geolocalizacion'));
					$this->Id_Tipo_Esc->setDbValue($this->Recordset->fields('Id_Tipo_Esc'));
					$this->Universo->setDbValue($this->Recordset->fields('Universo'));
					$this->Tiene_Programa->setDbValue($this->Recordset->fields('Tiene_Programa'));
					$this->Sector->setDbValue($this->Recordset->fields('Sector'));
					$this->Cantidad_Netbook_Conig->setDbValue($this->Recordset->fields('Cantidad_Netbook_Conig'));
					$this->Cantidad_Netbook_Actuales->setDbValue($this->Recordset->fields('Cantidad_Netbook_Actuales'));
					$this->Id_Nivel->setDbValue($this->Recordset->fields('Id_Nivel'));
					$this->Id_Jornada->setDbValue($this->Recordset->fields('Id_Jornada'));
					$this->Tipo_Zona->setDbValue($this->Recordset->fields('Tipo_Zona'));
					$this->Id_Estado_Esc->setDbValue($this->Recordset->fields('Id_Estado_Esc'));
					$this->Id_Zona->setDbValue($this->Recordset->fields('Id_Zona'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
				} else {
					if (!ew_CompareValue($this->Sigla->DbValue, $this->Recordset->fields('Sigla')))
						$this->Sigla->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nro_Cuise->DbValue, $this->Recordset->fields('Nro_Cuise')))
						$this->Nro_Cuise->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Departamento->DbValue, $this->Recordset->fields('Id_Departamento')))
						$this->Id_Departamento->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Localidad->DbValue, $this->Recordset->fields('Id_Localidad')))
						$this->Id_Localidad->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Aulas->DbValue, $this->Recordset->fields('Cantidad_Aulas')))
						$this->Cantidad_Aulas->CurrentValue = NULL;
					if (!ew_CompareValue($this->Comparte_Edificio->DbValue, $this->Recordset->fields('Comparte_Edificio')))
						$this->Comparte_Edificio->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Turnos->DbValue, $this->Recordset->fields('Cantidad_Turnos')))
						$this->Cantidad_Turnos->CurrentValue = NULL;
					if (!ew_CompareValue($this->Geolocalizacion->DbValue, $this->Recordset->fields('Geolocalizacion')))
						$this->Geolocalizacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Tipo_Esc->DbValue, $this->Recordset->fields('Id_Tipo_Esc')))
						$this->Id_Tipo_Esc->CurrentValue = NULL;
					if (!ew_CompareValue($this->Universo->DbValue, $this->Recordset->fields('Universo')))
						$this->Universo->CurrentValue = NULL;
					if (!ew_CompareValue($this->Tiene_Programa->DbValue, $this->Recordset->fields('Tiene_Programa')))
						$this->Tiene_Programa->CurrentValue = NULL;
					if (!ew_CompareValue($this->Sector->DbValue, $this->Recordset->fields('Sector')))
						$this->Sector->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Netbook_Conig->DbValue, $this->Recordset->fields('Cantidad_Netbook_Conig')))
						$this->Cantidad_Netbook_Conig->CurrentValue = NULL;
					if (!ew_CompareValue($this->Cantidad_Netbook_Actuales->DbValue, $this->Recordset->fields('Cantidad_Netbook_Actuales')))
						$this->Cantidad_Netbook_Actuales->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Nivel->DbValue, $this->Recordset->fields('Id_Nivel')))
						$this->Id_Nivel->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Jornada->DbValue, $this->Recordset->fields('Id_Jornada')))
						$this->Id_Jornada->CurrentValue = NULL;
					if (!ew_CompareValue($this->Tipo_Zona->DbValue, $this->Recordset->fields('Tipo_Zona')))
						$this->Tipo_Zona->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Estado_Esc->DbValue, $this->Recordset->fields('Id_Estado_Esc')))
						$this->Id_Estado_Esc->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Zona->DbValue, $this->Recordset->fields('Id_Zona')))
						$this->Id_Zona->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Actualizacion->DbValue, $this->Recordset->fields('Fecha_Actualizacion')))
						$this->Fecha_Actualizacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario->DbValue, $this->Recordset->fields('Usuario')))
						$this->Usuario->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		$this->Cue->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Sigla->FldIsDetailKey) {
			$this->Sigla->setFormValue($objForm->GetValue("x_Sigla"));
		}
		$this->Sigla->MultiUpdate = $objForm->GetValue("u_Sigla");
		if (!$this->Nro_Cuise->FldIsDetailKey) {
			$this->Nro_Cuise->setFormValue($objForm->GetValue("x_Nro_Cuise"));
		}
		$this->Nro_Cuise->MultiUpdate = $objForm->GetValue("u_Nro_Cuise");
		if (!$this->Id_Departamento->FldIsDetailKey) {
			$this->Id_Departamento->setFormValue($objForm->GetValue("x_Id_Departamento"));
		}
		$this->Id_Departamento->MultiUpdate = $objForm->GetValue("u_Id_Departamento");
		if (!$this->Id_Localidad->FldIsDetailKey) {
			$this->Id_Localidad->setFormValue($objForm->GetValue("x_Id_Localidad"));
		}
		$this->Id_Localidad->MultiUpdate = $objForm->GetValue("u_Id_Localidad");
		if (!$this->Cantidad_Aulas->FldIsDetailKey) {
			$this->Cantidad_Aulas->setFormValue($objForm->GetValue("x_Cantidad_Aulas"));
		}
		$this->Cantidad_Aulas->MultiUpdate = $objForm->GetValue("u_Cantidad_Aulas");
		if (!$this->Comparte_Edificio->FldIsDetailKey) {
			$this->Comparte_Edificio->setFormValue($objForm->GetValue("x_Comparte_Edificio"));
		}
		$this->Comparte_Edificio->MultiUpdate = $objForm->GetValue("u_Comparte_Edificio");
		if (!$this->Cantidad_Turnos->FldIsDetailKey) {
			$this->Cantidad_Turnos->setFormValue($objForm->GetValue("x_Cantidad_Turnos"));
		}
		$this->Cantidad_Turnos->MultiUpdate = $objForm->GetValue("u_Cantidad_Turnos");
		if (!$this->Geolocalizacion->FldIsDetailKey) {
			$this->Geolocalizacion->setFormValue($objForm->GetValue("x_Geolocalizacion"));
		}
		$this->Geolocalizacion->MultiUpdate = $objForm->GetValue("u_Geolocalizacion");
		if (!$this->Id_Tipo_Esc->FldIsDetailKey) {
			$this->Id_Tipo_Esc->setFormValue($objForm->GetValue("x_Id_Tipo_Esc"));
		}
		$this->Id_Tipo_Esc->MultiUpdate = $objForm->GetValue("u_Id_Tipo_Esc");
		if (!$this->Universo->FldIsDetailKey) {
			$this->Universo->setFormValue($objForm->GetValue("x_Universo"));
		}
		$this->Universo->MultiUpdate = $objForm->GetValue("u_Universo");
		if (!$this->Tiene_Programa->FldIsDetailKey) {
			$this->Tiene_Programa->setFormValue($objForm->GetValue("x_Tiene_Programa"));
		}
		$this->Tiene_Programa->MultiUpdate = $objForm->GetValue("u_Tiene_Programa");
		if (!$this->Sector->FldIsDetailKey) {
			$this->Sector->setFormValue($objForm->GetValue("x_Sector"));
		}
		$this->Sector->MultiUpdate = $objForm->GetValue("u_Sector");
		if (!$this->Cantidad_Netbook_Conig->FldIsDetailKey) {
			$this->Cantidad_Netbook_Conig->setFormValue($objForm->GetValue("x_Cantidad_Netbook_Conig"));
		}
		$this->Cantidad_Netbook_Conig->MultiUpdate = $objForm->GetValue("u_Cantidad_Netbook_Conig");
		if (!$this->Cantidad_Netbook_Actuales->FldIsDetailKey) {
			$this->Cantidad_Netbook_Actuales->setFormValue($objForm->GetValue("x_Cantidad_Netbook_Actuales"));
		}
		$this->Cantidad_Netbook_Actuales->MultiUpdate = $objForm->GetValue("u_Cantidad_Netbook_Actuales");
		if (!$this->Id_Nivel->FldIsDetailKey) {
			$this->Id_Nivel->setFormValue($objForm->GetValue("x_Id_Nivel"));
		}
		$this->Id_Nivel->MultiUpdate = $objForm->GetValue("u_Id_Nivel");
		if (!$this->Id_Jornada->FldIsDetailKey) {
			$this->Id_Jornada->setFormValue($objForm->GetValue("x_Id_Jornada"));
		}
		$this->Id_Jornada->MultiUpdate = $objForm->GetValue("u_Id_Jornada");
		if (!$this->Tipo_Zona->FldIsDetailKey) {
			$this->Tipo_Zona->setFormValue($objForm->GetValue("x_Tipo_Zona"));
		}
		$this->Tipo_Zona->MultiUpdate = $objForm->GetValue("u_Tipo_Zona");
		if (!$this->Id_Estado_Esc->FldIsDetailKey) {
			$this->Id_Estado_Esc->setFormValue($objForm->GetValue("x_Id_Estado_Esc"));
		}
		$this->Id_Estado_Esc->MultiUpdate = $objForm->GetValue("u_Id_Estado_Esc");
		if (!$this->Id_Zona->FldIsDetailKey) {
			$this->Id_Zona->setFormValue($objForm->GetValue("x_Id_Zona"));
		}
		$this->Id_Zona->MultiUpdate = $objForm->GetValue("u_Id_Zona");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
		if (!$this->Cue->FldIsDetailKey)
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Sigla->CurrentValue = $this->Sigla->FormValue;
		$this->Nro_Cuise->CurrentValue = $this->Nro_Cuise->FormValue;
		$this->Id_Departamento->CurrentValue = $this->Id_Departamento->FormValue;
		$this->Id_Localidad->CurrentValue = $this->Id_Localidad->FormValue;
		$this->Cantidad_Aulas->CurrentValue = $this->Cantidad_Aulas->FormValue;
		$this->Comparte_Edificio->CurrentValue = $this->Comparte_Edificio->FormValue;
		$this->Cantidad_Turnos->CurrentValue = $this->Cantidad_Turnos->FormValue;
		$this->Geolocalizacion->CurrentValue = $this->Geolocalizacion->FormValue;
		$this->Id_Tipo_Esc->CurrentValue = $this->Id_Tipo_Esc->FormValue;
		$this->Universo->CurrentValue = $this->Universo->FormValue;
		$this->Tiene_Programa->CurrentValue = $this->Tiene_Programa->FormValue;
		$this->Sector->CurrentValue = $this->Sector->FormValue;
		$this->Cantidad_Netbook_Conig->CurrentValue = $this->Cantidad_Netbook_Conig->FormValue;
		$this->Cantidad_Netbook_Actuales->CurrentValue = $this->Cantidad_Netbook_Actuales->FormValue;
		$this->Id_Nivel->CurrentValue = $this->Id_Nivel->FormValue;
		$this->Id_Jornada->CurrentValue = $this->Id_Jornada->FormValue;
		$this->Tipo_Zona->CurrentValue = $this->Tipo_Zona->FormValue;
		$this->Id_Estado_Esc->CurrentValue = $this->Id_Estado_Esc->FormValue;
		$this->Id_Zona->CurrentValue = $this->Id_Zona->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Cue->setDbValue($rs->fields('Cue'));
		$this->Nombre_Establecimiento->setDbValue($rs->fields('Nombre_Establecimiento'));
		$this->Sigla->setDbValue($rs->fields('Sigla'));
		$this->Nro_Cuise->setDbValue($rs->fields('Nro_Cuise'));
		$this->Id_Departamento->setDbValue($rs->fields('Id_Departamento'));
		$this->Id_Localidad->setDbValue($rs->fields('Id_Localidad'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Telefono_Escuela->setDbValue($rs->fields('Telefono_Escuela'));
		$this->Mail_Escuela->setDbValue($rs->fields('Mail_Escuela'));
		$this->Matricula_Actual->setDbValue($rs->fields('Matricula_Actual'));
		$this->Cantidad_Aulas->setDbValue($rs->fields('Cantidad_Aulas'));
		$this->Comparte_Edificio->setDbValue($rs->fields('Comparte_Edificio'));
		$this->Cantidad_Turnos->setDbValue($rs->fields('Cantidad_Turnos'));
		$this->Geolocalizacion->setDbValue($rs->fields('Geolocalizacion'));
		$this->Id_Tipo_Esc->setDbValue($rs->fields('Id_Tipo_Esc'));
		$this->Universo->setDbValue($rs->fields('Universo'));
		$this->Tiene_Programa->setDbValue($rs->fields('Tiene_Programa'));
		$this->Sector->setDbValue($rs->fields('Sector'));
		$this->Cantidad_Netbook_Conig->setDbValue($rs->fields('Cantidad_Netbook_Conig'));
		$this->Cantidad_Netbook_Actuales->setDbValue($rs->fields('Cantidad_Netbook_Actuales'));
		$this->Id_Nivel->setDbValue($rs->fields('Id_Nivel'));
		$this->Id_Jornada->setDbValue($rs->fields('Id_Jornada'));
		$this->Tipo_Zona->setDbValue($rs->fields('Tipo_Zona'));
		$this->Id_Estado_Esc->setDbValue($rs->fields('Id_Estado_Esc'));
		$this->Id_Zona->setDbValue($rs->fields('Id_Zona'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Cue->DbValue = $row['Cue'];
		$this->Nombre_Establecimiento->DbValue = $row['Nombre_Establecimiento'];
		$this->Sigla->DbValue = $row['Sigla'];
		$this->Nro_Cuise->DbValue = $row['Nro_Cuise'];
		$this->Id_Departamento->DbValue = $row['Id_Departamento'];
		$this->Id_Localidad->DbValue = $row['Id_Localidad'];
		$this->Domicilio->DbValue = $row['Domicilio'];
		$this->Telefono_Escuela->DbValue = $row['Telefono_Escuela'];
		$this->Mail_Escuela->DbValue = $row['Mail_Escuela'];
		$this->Matricula_Actual->DbValue = $row['Matricula_Actual'];
		$this->Cantidad_Aulas->DbValue = $row['Cantidad_Aulas'];
		$this->Comparte_Edificio->DbValue = $row['Comparte_Edificio'];
		$this->Cantidad_Turnos->DbValue = $row['Cantidad_Turnos'];
		$this->Geolocalizacion->DbValue = $row['Geolocalizacion'];
		$this->Id_Tipo_Esc->DbValue = $row['Id_Tipo_Esc'];
		$this->Universo->DbValue = $row['Universo'];
		$this->Tiene_Programa->DbValue = $row['Tiene_Programa'];
		$this->Sector->DbValue = $row['Sector'];
		$this->Cantidad_Netbook_Conig->DbValue = $row['Cantidad_Netbook_Conig'];
		$this->Cantidad_Netbook_Actuales->DbValue = $row['Cantidad_Netbook_Actuales'];
		$this->Id_Nivel->DbValue = $row['Id_Nivel'];
		$this->Id_Jornada->DbValue = $row['Id_Jornada'];
		$this->Tipo_Zona->DbValue = $row['Tipo_Zona'];
		$this->Id_Estado_Esc->DbValue = $row['Id_Estado_Esc'];
		$this->Id_Zona->DbValue = $row['Id_Zona'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Sigla
			$this->Sigla->EditAttrs["class"] = "form-control";
			$this->Sigla->EditCustomAttributes = "";
			$this->Sigla->EditValue = ew_HtmlEncode($this->Sigla->CurrentValue);
			$this->Sigla->PlaceHolder = ew_RemoveHtml($this->Sigla->FldCaption());

			// Nro_Cuise
			$this->Nro_Cuise->EditAttrs["class"] = "form-control";
			$this->Nro_Cuise->EditCustomAttributes = "";
			$this->Nro_Cuise->EditValue = ew_HtmlEncode($this->Nro_Cuise->CurrentValue);
			$this->Nro_Cuise->PlaceHolder = ew_RemoveHtml($this->Nro_Cuise->FldCaption());

			// Id_Departamento
			$this->Id_Departamento->EditAttrs["class"] = "form-control";
			$this->Id_Departamento->EditCustomAttributes = "";
			if (trim(strval($this->Id_Departamento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Departamento`" . ew_SearchString("=", $this->Id_Departamento->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			if (trim(strval($this->Id_Localidad->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Localidad`" . ew_SearchString("=", $this->Id_Localidad->CurrentValue, EW_DATATYPE_NUMBER, "");
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

			// Cantidad_Aulas
			$this->Cantidad_Aulas->EditAttrs["class"] = "form-control";
			$this->Cantidad_Aulas->EditCustomAttributes = "";
			$this->Cantidad_Aulas->EditValue = ew_HtmlEncode($this->Cantidad_Aulas->CurrentValue);
			$this->Cantidad_Aulas->PlaceHolder = ew_RemoveHtml($this->Cantidad_Aulas->FldCaption());

			// Comparte_Edificio
			$this->Comparte_Edificio->EditCustomAttributes = "";
			$this->Comparte_Edificio->EditValue = $this->Comparte_Edificio->Options(FALSE);

			// Cantidad_Turnos
			$this->Cantidad_Turnos->EditAttrs["class"] = "form-control";
			$this->Cantidad_Turnos->EditCustomAttributes = "";
			$this->Cantidad_Turnos->EditValue = ew_HtmlEncode($this->Cantidad_Turnos->CurrentValue);
			$this->Cantidad_Turnos->PlaceHolder = ew_RemoveHtml($this->Cantidad_Turnos->FldCaption());

			// Geolocalizacion
			$this->Geolocalizacion->EditAttrs["class"] = "form-control";
			$this->Geolocalizacion->EditCustomAttributes = "";
			$this->Geolocalizacion->EditValue = ew_HtmlEncode($this->Geolocalizacion->CurrentValue);
			$this->Geolocalizacion->PlaceHolder = ew_RemoveHtml($this->Geolocalizacion->FldCaption());

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Tipo_Esc->CurrentValue);
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
			$this->Cantidad_Netbook_Conig->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Conig->CurrentValue);
			$this->Cantidad_Netbook_Conig->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Conig->FldCaption());

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->EditAttrs["class"] = "form-control";
			$this->Cantidad_Netbook_Actuales->EditCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->EditValue = ew_HtmlEncode($this->Cantidad_Netbook_Actuales->CurrentValue);
			$this->Cantidad_Netbook_Actuales->PlaceHolder = ew_RemoveHtml($this->Cantidad_Netbook_Actuales->FldCaption());

			// Id_Nivel
			$this->Id_Nivel->EditCustomAttributes = "";
			if (trim(strval($this->Id_Nivel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Nivel->CurrentValue);
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
			if (trim(strval($this->Id_Jornada->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->Id_Jornada->CurrentValue);
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
			$this->Tipo_Zona->EditValue = ew_HtmlEncode($this->Tipo_Zona->CurrentValue);
			$this->Tipo_Zona->PlaceHolder = ew_RemoveHtml($this->Tipo_Zona->FldCaption());

			// Id_Estado_Esc
			$this->Id_Estado_Esc->EditAttrs["class"] = "form-control";
			$this->Id_Estado_Esc->EditCustomAttributes = "";
			if (trim(strval($this->Id_Estado_Esc->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Esc`" . ew_SearchString("=", $this->Id_Estado_Esc->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			if (trim(strval($this->Id_Zona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Zona`" . ew_SearchString("=", $this->Id_Zona->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			// Usuario
			// Edit refer script
			// Sigla

			$this->Sigla->LinkCustomAttributes = "";
			$this->Sigla->HrefValue = "";

			// Nro_Cuise
			$this->Nro_Cuise->LinkCustomAttributes = "";
			$this->Nro_Cuise->HrefValue = "";

			// Id_Departamento
			$this->Id_Departamento->LinkCustomAttributes = "";
			$this->Id_Departamento->HrefValue = "";

			// Id_Localidad
			$this->Id_Localidad->LinkCustomAttributes = "";
			$this->Id_Localidad->HrefValue = "";

			// Cantidad_Aulas
			$this->Cantidad_Aulas->LinkCustomAttributes = "";
			$this->Cantidad_Aulas->HrefValue = "";

			// Comparte_Edificio
			$this->Comparte_Edificio->LinkCustomAttributes = "";
			$this->Comparte_Edificio->HrefValue = "";

			// Cantidad_Turnos
			$this->Cantidad_Turnos->LinkCustomAttributes = "";
			$this->Cantidad_Turnos->HrefValue = "";

			// Geolocalizacion
			$this->Geolocalizacion->LinkCustomAttributes = "";
			$this->Geolocalizacion->HrefValue = "";

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->LinkCustomAttributes = "";
			$this->Id_Tipo_Esc->HrefValue = "";

			// Universo
			$this->Universo->LinkCustomAttributes = "";
			$this->Universo->HrefValue = "";

			// Tiene_Programa
			$this->Tiene_Programa->LinkCustomAttributes = "";
			$this->Tiene_Programa->HrefValue = "";

			// Sector
			$this->Sector->LinkCustomAttributes = "";
			$this->Sector->HrefValue = "";

			// Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Conig->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Conig->HrefValue = "";

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->LinkCustomAttributes = "";
			$this->Cantidad_Netbook_Actuales->HrefValue = "";

			// Id_Nivel
			$this->Id_Nivel->LinkCustomAttributes = "";
			$this->Id_Nivel->HrefValue = "";

			// Id_Jornada
			$this->Id_Jornada->LinkCustomAttributes = "";
			$this->Id_Jornada->HrefValue = "";

			// Tipo_Zona
			$this->Tipo_Zona->LinkCustomAttributes = "";
			$this->Tipo_Zona->HrefValue = "";

			// Id_Estado_Esc
			$this->Id_Estado_Esc->LinkCustomAttributes = "";
			$this->Id_Estado_Esc->HrefValue = "";

			// Id_Zona
			$this->Id_Zona->LinkCustomAttributes = "";
			$this->Id_Zona->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->Sigla->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nro_Cuise->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Departamento->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Localidad->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Aulas->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Comparte_Edificio->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Turnos->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Geolocalizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Tipo_Esc->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Universo->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Tiene_Programa->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Sector->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Netbook_Conig->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Cantidad_Netbook_Actuales->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Nivel->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Jornada->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Tipo_Zona->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Estado_Esc->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Zona->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Nro_Cuise->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Nro_Cuise->FormValue)) {
				ew_AddMessage($gsFormError, $this->Nro_Cuise->FldErrMsg());
			}
		}
		if ($this->Id_Departamento->MultiUpdate <> "" && !$this->Id_Departamento->FldIsDetailKey && !is_null($this->Id_Departamento->FormValue) && $this->Id_Departamento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Departamento->FldCaption(), $this->Id_Departamento->ReqErrMsg));
		}
		if ($this->Id_Localidad->MultiUpdate <> "" && !$this->Id_Localidad->FldIsDetailKey && !is_null($this->Id_Localidad->FormValue) && $this->Id_Localidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Localidad->FldCaption(), $this->Id_Localidad->ReqErrMsg));
		}
		if ($this->Cantidad_Aulas->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Aulas->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Aulas->FldErrMsg());
			}
		}
		if ($this->Cantidad_Turnos->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Turnos->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Turnos->FldErrMsg());
			}
		}
		if ($this->Id_Tipo_Esc->MultiUpdate <> "" && $this->Id_Tipo_Esc->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Esc->FldCaption(), $this->Id_Tipo_Esc->ReqErrMsg));
		}
		if ($this->Cantidad_Netbook_Conig->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Netbook_Conig->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Netbook_Conig->FldErrMsg());
			}
		}
		if ($this->Cantidad_Netbook_Actuales->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Cantidad_Netbook_Actuales->FormValue)) {
				ew_AddMessage($gsFormError, $this->Cantidad_Netbook_Actuales->FldErrMsg());
			}
		}
		if ($this->Id_Nivel->MultiUpdate <> "" && $this->Id_Nivel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Nivel->FldCaption(), $this->Id_Nivel->ReqErrMsg));
		}
		if ($this->Id_Jornada->MultiUpdate <> "" && $this->Id_Jornada->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Jornada->FldCaption(), $this->Id_Jornada->ReqErrMsg));
		}
		if ($this->Id_Estado_Esc->MultiUpdate <> "" && !$this->Id_Estado_Esc->FldIsDetailKey && !is_null($this->Id_Estado_Esc->FormValue) && $this->Id_Estado_Esc->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Estado_Esc->FldCaption(), $this->Id_Estado_Esc->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Sigla
			$this->Sigla->SetDbValueDef($rsnew, $this->Sigla->CurrentValue, NULL, $this->Sigla->ReadOnly || $this->Sigla->MultiUpdate <> "1");

			// Nro_Cuise
			$this->Nro_Cuise->SetDbValueDef($rsnew, $this->Nro_Cuise->CurrentValue, NULL, $this->Nro_Cuise->ReadOnly || $this->Nro_Cuise->MultiUpdate <> "1");

			// Id_Departamento
			$this->Id_Departamento->SetDbValueDef($rsnew, $this->Id_Departamento->CurrentValue, 0, $this->Id_Departamento->ReadOnly || $this->Id_Departamento->MultiUpdate <> "1");

			// Id_Localidad
			$this->Id_Localidad->SetDbValueDef($rsnew, $this->Id_Localidad->CurrentValue, 0, $this->Id_Localidad->ReadOnly || $this->Id_Localidad->MultiUpdate <> "1");

			// Cantidad_Aulas
			$this->Cantidad_Aulas->SetDbValueDef($rsnew, $this->Cantidad_Aulas->CurrentValue, NULL, $this->Cantidad_Aulas->ReadOnly || $this->Cantidad_Aulas->MultiUpdate <> "1");

			// Comparte_Edificio
			$this->Comparte_Edificio->SetDbValueDef($rsnew, $this->Comparte_Edificio->CurrentValue, NULL, $this->Comparte_Edificio->ReadOnly || $this->Comparte_Edificio->MultiUpdate <> "1");

			// Cantidad_Turnos
			$this->Cantidad_Turnos->SetDbValueDef($rsnew, $this->Cantidad_Turnos->CurrentValue, NULL, $this->Cantidad_Turnos->ReadOnly || $this->Cantidad_Turnos->MultiUpdate <> "1");

			// Geolocalizacion
			$this->Geolocalizacion->SetDbValueDef($rsnew, $this->Geolocalizacion->CurrentValue, NULL, $this->Geolocalizacion->ReadOnly || $this->Geolocalizacion->MultiUpdate <> "1");

			// Id_Tipo_Esc
			$this->Id_Tipo_Esc->SetDbValueDef($rsnew, $this->Id_Tipo_Esc->CurrentValue, "", $this->Id_Tipo_Esc->ReadOnly || $this->Id_Tipo_Esc->MultiUpdate <> "1");

			// Universo
			$this->Universo->SetDbValueDef($rsnew, $this->Universo->CurrentValue, NULL, $this->Universo->ReadOnly || $this->Universo->MultiUpdate <> "1");

			// Tiene_Programa
			$this->Tiene_Programa->SetDbValueDef($rsnew, $this->Tiene_Programa->CurrentValue, NULL, $this->Tiene_Programa->ReadOnly || $this->Tiene_Programa->MultiUpdate <> "1");

			// Sector
			$this->Sector->SetDbValueDef($rsnew, $this->Sector->CurrentValue, NULL, $this->Sector->ReadOnly || $this->Sector->MultiUpdate <> "1");

			// Cantidad_Netbook_Conig
			$this->Cantidad_Netbook_Conig->SetDbValueDef($rsnew, $this->Cantidad_Netbook_Conig->CurrentValue, NULL, $this->Cantidad_Netbook_Conig->ReadOnly || $this->Cantidad_Netbook_Conig->MultiUpdate <> "1");

			// Cantidad_Netbook_Actuales
			$this->Cantidad_Netbook_Actuales->SetDbValueDef($rsnew, $this->Cantidad_Netbook_Actuales->CurrentValue, NULL, $this->Cantidad_Netbook_Actuales->ReadOnly || $this->Cantidad_Netbook_Actuales->MultiUpdate <> "1");

			// Id_Nivel
			$this->Id_Nivel->SetDbValueDef($rsnew, $this->Id_Nivel->CurrentValue, "", $this->Id_Nivel->ReadOnly || $this->Id_Nivel->MultiUpdate <> "1");

			// Id_Jornada
			$this->Id_Jornada->SetDbValueDef($rsnew, $this->Id_Jornada->CurrentValue, "", $this->Id_Jornada->ReadOnly || $this->Id_Jornada->MultiUpdate <> "1");

			// Tipo_Zona
			$this->Tipo_Zona->SetDbValueDef($rsnew, $this->Tipo_Zona->CurrentValue, NULL, $this->Tipo_Zona->ReadOnly || $this->Tipo_Zona->MultiUpdate <> "1");

			// Id_Estado_Esc
			$this->Id_Estado_Esc->SetDbValueDef($rsnew, $this->Id_Estado_Esc->CurrentValue, 0, $this->Id_Estado_Esc->ReadOnly || $this->Id_Estado_Esc->MultiUpdate <> "1");

			// Id_Zona
			$this->Id_Zona->SetDbValueDef($rsnew, $this->Id_Zona->CurrentValue, NULL, $this->Id_Zona->ReadOnly || $this->Id_Zona->MultiUpdate <> "1");

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dato_establecimientolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'dato_establecimiento';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'dato_establecimiento';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
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
if (!isset($dato_establecimiento_update)) $dato_establecimiento_update = new cdato_establecimiento_update();

// Page init
$dato_establecimiento_update->Page_Init();

// Page main
$dato_establecimiento_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dato_establecimiento_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fdato_establecimientoupdate = new ew_Form("fdato_establecimientoupdate", "update");

// Validate form
fdato_establecimientoupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Nro_Cuise");
			uelm = this.GetElements("u" + infix + "_Nro_Cuise");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Nro_Cuise->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			uelm = this.GetElements("u" + infix + "_Id_Departamento");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Departamento->FldCaption(), $dato_establecimiento->Id_Departamento->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Localidad");
			uelm = this.GetElements("u" + infix + "_Id_Localidad");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Localidad->FldCaption(), $dato_establecimiento->Id_Localidad->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Cantidad_Aulas");
			uelm = this.GetElements("u" + infix + "_Cantidad_Aulas");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Aulas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Turnos");
			uelm = this.GetElements("u" + infix + "_Cantidad_Turnos");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Turnos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Esc[]");
			uelm = this.GetElements("u" + infix + "_Id_Tipo_Esc");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Tipo_Esc->FldCaption(), $dato_establecimiento->Id_Tipo_Esc->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Cantidad_Netbook_Conig");
			uelm = this.GetElements("u" + infix + "_Cantidad_Netbook_Conig");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Netbook_Conig->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Netbook_Actuales");
			uelm = this.GetElements("u" + infix + "_Cantidad_Netbook_Actuales");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dato_establecimiento->Cantidad_Netbook_Actuales->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Nivel[]");
			uelm = this.GetElements("u" + infix + "_Id_Nivel");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Nivel->FldCaption(), $dato_establecimiento->Id_Nivel->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Jornada[]");
			uelm = this.GetElements("u" + infix + "_Id_Jornada");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Jornada->FldCaption(), $dato_establecimiento->Id_Jornada->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Id_Estado_Esc");
			uelm = this.GetElements("u" + infix + "_Id_Estado_Esc");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dato_establecimiento->Id_Estado_Esc->FldCaption(), $dato_establecimiento->Id_Estado_Esc->ReqErrMsg)) ?>");
			}

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdato_establecimientoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdato_establecimientoupdate.ValidateRequired = true;
<?php } else { ?>
fdato_establecimientoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdato_establecimientoupdate.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};
fdato_establecimientoupdate.Lists["x_Id_Localidad"] = {"LinkField":"x_Id_Localidad","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":["x_Id_Departamento"],"ChildFields":[],"FilterFields":["x_Id_Departamento"],"Options":[],"Template":"","LinkTable":"localidades"};
fdato_establecimientoupdate.Lists["x_Comparte_Edificio"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoupdate.Lists["x_Comparte_Edificio"].Options = <?php echo json_encode($dato_establecimiento->Comparte_Edificio->Options()) ?>;
fdato_establecimientoupdate.Lists["x_Id_Tipo_Esc[]"] = {"LinkField":"x_Id_Tipo_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_escuela"};
fdato_establecimientoupdate.Lists["x_Universo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoupdate.Lists["x_Universo"].Options = <?php echo json_encode($dato_establecimiento->Universo->Options()) ?>;
fdato_establecimientoupdate.Lists["x_Tiene_Programa"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoupdate.Lists["x_Tiene_Programa"].Options = <?php echo json_encode($dato_establecimiento->Tiene_Programa->Options()) ?>;
fdato_establecimientoupdate.Lists["x_Sector"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdato_establecimientoupdate.Lists["x_Sector"].Options = <?php echo json_encode($dato_establecimiento->Sector->Options()) ?>;
fdato_establecimientoupdate.Lists["x_Id_Nivel[]"] = {"LinkField":"x_Id_Nivel","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"nivel_educativo"};
fdato_establecimientoupdate.Lists["x_Id_Jornada[]"] = {"LinkField":"x_Id_Jornada","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_jornada"};
fdato_establecimientoupdate.Lists["x_Id_Estado_Esc"] = {"LinkField":"x_Id_Estado_Esc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_establecimiento"};
fdato_establecimientoupdate.Lists["x_Id_Zona"] = {"LinkField":"x_Id_Zona","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"zonas"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$dato_establecimiento_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $dato_establecimiento_update->ShowPageHeader(); ?>
<?php
$dato_establecimiento_update->ShowMessage();
?>
<form name="fdato_establecimientoupdate" id="fdato_establecimientoupdate" class="<?php echo $dato_establecimiento_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dato_establecimiento_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dato_establecimiento_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dato_establecimiento">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($dato_establecimiento_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($dato_establecimiento_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_dato_establecimientoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($dato_establecimiento->Sigla->Visible) { // Sigla ?>
	<div id="r_Sigla" class="form-group">
		<label for="x_Sigla" class="col-sm-2 control-label">
<input type="checkbox" name="u_Sigla" id="u_Sigla" value="1"<?php echo ($dato_establecimiento->Sigla->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Sigla->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Sigla->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sigla">
<input type="text" data-table="dato_establecimiento" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Sigla->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Sigla->EditValue ?>"<?php echo $dato_establecimiento->Sigla->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Sigla->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Nro_Cuise->Visible) { // Nro_Cuise ?>
	<div id="r_Nro_Cuise" class="form-group">
		<label for="x_Nro_Cuise" class="col-sm-2 control-label">
<input type="checkbox" name="u_Nro_Cuise" id="u_Nro_Cuise" value="1"<?php echo ($dato_establecimiento->Nro_Cuise->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Nro_Cuise->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Nro_Cuise->CellAttributes() ?>>
<span id="el_dato_establecimiento_Nro_Cuise">
<input type="text" data-table="dato_establecimiento" data-field="x_Nro_Cuise" name="x_Nro_Cuise" id="x_Nro_Cuise" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Nro_Cuise->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Nro_Cuise->EditValue ?>"<?php echo $dato_establecimiento->Nro_Cuise->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Nro_Cuise->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Departamento->Visible) { // Id_Departamento ?>
	<div id="r_Id_Departamento" class="form-group">
		<label for="x_Id_Departamento" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Departamento" id="u_Id_Departamento" value="1"<?php echo ($dato_establecimiento->Id_Departamento->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Departamento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Departamento->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Departamento">
<?php $dato_establecimiento->Id_Departamento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$dato_establecimiento->Id_Departamento->EditAttrs["onchange"]; ?>
<select data-table="dato_establecimiento" data-field="x_Id_Departamento" data-value-separator="<?php echo $dato_establecimiento->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x_Id_Departamento" name="x_Id_Departamento"<?php echo $dato_establecimiento->Id_Departamento->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Departamento->SelectOptionListHtml("x_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x_Id_Departamento" id="s_x_Id_Departamento" value="<?php echo $dato_establecimiento->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Departamento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Localidad->Visible) { // Id_Localidad ?>
	<div id="r_Id_Localidad" class="form-group">
		<label for="x_Id_Localidad" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Localidad" id="u_Id_Localidad" value="1"<?php echo ($dato_establecimiento->Id_Localidad->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Localidad->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Localidad->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Localidad">
<select data-table="dato_establecimiento" data-field="x_Id_Localidad" data-value-separator="<?php echo $dato_establecimiento->Id_Localidad->DisplayValueSeparatorAttribute() ?>" id="x_Id_Localidad" name="x_Id_Localidad"<?php echo $dato_establecimiento->Id_Localidad->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Localidad->SelectOptionListHtml("x_Id_Localidad") ?>
</select>
<input type="hidden" name="s_x_Id_Localidad" id="s_x_Id_Localidad" value="<?php echo $dato_establecimiento->Id_Localidad->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Localidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Aulas->Visible) { // Cantidad_Aulas ?>
	<div id="r_Cantidad_Aulas" class="form-group">
		<label for="x_Cantidad_Aulas" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Aulas" id="u_Cantidad_Aulas" value="1"<?php echo ($dato_establecimiento->Cantidad_Aulas->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Cantidad_Aulas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Cantidad_Aulas->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Aulas">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Aulas" name="x_Cantidad_Aulas" id="x_Cantidad_Aulas" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Aulas->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Aulas->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Aulas->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Cantidad_Aulas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Comparte_Edificio->Visible) { // Comparte_Edificio ?>
	<div id="r_Comparte_Edificio" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Comparte_Edificio" id="u_Comparte_Edificio" value="1"<?php echo ($dato_establecimiento->Comparte_Edificio->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Comparte_Edificio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Comparte_Edificio->CellAttributes() ?>>
<span id="el_dato_establecimiento_Comparte_Edificio">
<div id="tp_x_Comparte_Edificio" class="ewTemplate"><input type="radio" data-table="dato_establecimiento" data-field="x_Comparte_Edificio" data-value-separator="<?php echo $dato_establecimiento->Comparte_Edificio->DisplayValueSeparatorAttribute() ?>" name="x_Comparte_Edificio" id="x_Comparte_Edificio" value="{value}"<?php echo $dato_establecimiento->Comparte_Edificio->EditAttributes() ?>></div>
<div id="dsl_x_Comparte_Edificio" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Comparte_Edificio->RadioButtonListHtml(FALSE, "x_Comparte_Edificio") ?>
</div></div>
</span>
<?php echo $dato_establecimiento->Comparte_Edificio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Turnos->Visible) { // Cantidad_Turnos ?>
	<div id="r_Cantidad_Turnos" class="form-group">
		<label for="x_Cantidad_Turnos" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Turnos" id="u_Cantidad_Turnos" value="1"<?php echo ($dato_establecimiento->Cantidad_Turnos->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Cantidad_Turnos->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Cantidad_Turnos->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Turnos">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Turnos" name="x_Cantidad_Turnos" id="x_Cantidad_Turnos" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Turnos->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Turnos->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Turnos->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Cantidad_Turnos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Geolocalizacion->Visible) { // Geolocalizacion ?>
	<div id="r_Geolocalizacion" class="form-group">
		<label for="x_Geolocalizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Geolocalizacion" id="u_Geolocalizacion" value="1"<?php echo ($dato_establecimiento->Geolocalizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Geolocalizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Geolocalizacion->CellAttributes() ?>>
<span id="el_dato_establecimiento_Geolocalizacion">
<input type="text" data-table="dato_establecimiento" data-field="x_Geolocalizacion" name="x_Geolocalizacion" id="x_Geolocalizacion" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Geolocalizacion->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Geolocalizacion->EditValue ?>"<?php echo $dato_establecimiento->Geolocalizacion->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Geolocalizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Tipo_Esc->Visible) { // Id_Tipo_Esc ?>
	<div id="r_Id_Tipo_Esc" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Tipo_Esc" id="u_Id_Tipo_Esc" value="1"<?php echo ($dato_establecimiento->Id_Tipo_Esc->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Tipo_Esc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Tipo_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Tipo_Esc">
<div id="tp_x_Id_Tipo_Esc" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Tipo_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Tipo_Esc->DisplayValueSeparatorAttribute() ?>" name="x_Id_Tipo_Esc[]" id="x_Id_Tipo_Esc[]" value="{value}"<?php echo $dato_establecimiento->Id_Tipo_Esc->EditAttributes() ?>></div>
<div id="dsl_x_Id_Tipo_Esc" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CheckBoxListHtml(FALSE, "x_Id_Tipo_Esc[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Tipo_Esc" id="s_x_Id_Tipo_Esc" value="<?php echo $dato_establecimiento->Id_Tipo_Esc->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Tipo_Esc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Universo->Visible) { // Universo ?>
	<div id="r_Universo" class="form-group">
		<label for="x_Universo" class="col-sm-2 control-label">
<input type="checkbox" name="u_Universo" id="u_Universo" value="1"<?php echo ($dato_establecimiento->Universo->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Universo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Universo->CellAttributes() ?>>
<span id="el_dato_establecimiento_Universo">
<select data-table="dato_establecimiento" data-field="x_Universo" data-value-separator="<?php echo $dato_establecimiento->Universo->DisplayValueSeparatorAttribute() ?>" id="x_Universo" name="x_Universo"<?php echo $dato_establecimiento->Universo->EditAttributes() ?>>
<?php echo $dato_establecimiento->Universo->SelectOptionListHtml("x_Universo") ?>
</select>
</span>
<?php echo $dato_establecimiento->Universo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Tiene_Programa->Visible) { // Tiene_Programa ?>
	<div id="r_Tiene_Programa" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Tiene_Programa" id="u_Tiene_Programa" value="1"<?php echo ($dato_establecimiento->Tiene_Programa->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Tiene_Programa->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Tiene_Programa->CellAttributes() ?>>
<span id="el_dato_establecimiento_Tiene_Programa">
<div id="tp_x_Tiene_Programa" class="ewTemplate"><input type="radio" data-table="dato_establecimiento" data-field="x_Tiene_Programa" data-value-separator="<?php echo $dato_establecimiento->Tiene_Programa->DisplayValueSeparatorAttribute() ?>" name="x_Tiene_Programa" id="x_Tiene_Programa" value="{value}"<?php echo $dato_establecimiento->Tiene_Programa->EditAttributes() ?>></div>
<div id="dsl_x_Tiene_Programa" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Tiene_Programa->RadioButtonListHtml(FALSE, "x_Tiene_Programa") ?>
</div></div>
</span>
<?php echo $dato_establecimiento->Tiene_Programa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Sector->Visible) { // Sector ?>
	<div id="r_Sector" class="form-group">
		<label for="x_Sector" class="col-sm-2 control-label">
<input type="checkbox" name="u_Sector" id="u_Sector" value="1"<?php echo ($dato_establecimiento->Sector->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Sector->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Sector->CellAttributes() ?>>
<span id="el_dato_establecimiento_Sector">
<select data-table="dato_establecimiento" data-field="x_Sector" data-value-separator="<?php echo $dato_establecimiento->Sector->DisplayValueSeparatorAttribute() ?>" id="x_Sector" name="x_Sector"<?php echo $dato_establecimiento->Sector->EditAttributes() ?>>
<?php echo $dato_establecimiento->Sector->SelectOptionListHtml("x_Sector") ?>
</select>
</span>
<?php echo $dato_establecimiento->Sector->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Conig->Visible) { // Cantidad_Netbook_Conig ?>
	<div id="r_Cantidad_Netbook_Conig" class="form-group">
		<label for="x_Cantidad_Netbook_Conig" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Netbook_Conig" id="u_Cantidad_Netbook_Conig" value="1"<?php echo ($dato_establecimiento->Cantidad_Netbook_Conig->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Cantidad_Netbook_Conig->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Netbook_Conig">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Conig" name="x_Cantidad_Netbook_Conig" id="x_Cantidad_Netbook_Conig" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Conig->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Cantidad_Netbook_Conig->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Cantidad_Netbook_Actuales->Visible) { // Cantidad_Netbook_Actuales ?>
	<div id="r_Cantidad_Netbook_Actuales" class="form-group">
		<label for="x_Cantidad_Netbook_Actuales" class="col-sm-2 control-label">
<input type="checkbox" name="u_Cantidad_Netbook_Actuales" id="u_Cantidad_Netbook_Actuales" value="1"<?php echo ($dato_establecimiento->Cantidad_Netbook_Actuales->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CellAttributes() ?>>
<span id="el_dato_establecimiento_Cantidad_Netbook_Actuales">
<input type="text" data-table="dato_establecimiento" data-field="x_Cantidad_Netbook_Actuales" name="x_Cantidad_Netbook_Actuales" id="x_Cantidad_Netbook_Actuales" size="30" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Cantidad_Netbook_Actuales->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditValue ?>"<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Cantidad_Netbook_Actuales->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Nivel->Visible) { // Id_Nivel ?>
	<div id="r_Id_Nivel" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Nivel" id="u_Id_Nivel" value="1"<?php echo ($dato_establecimiento->Id_Nivel->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Nivel->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Nivel->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Nivel">
<div id="tp_x_Id_Nivel" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Nivel" data-value-separator="<?php echo $dato_establecimiento->Id_Nivel->DisplayValueSeparatorAttribute() ?>" name="x_Id_Nivel[]" id="x_Id_Nivel[]" value="{value}"<?php echo $dato_establecimiento->Id_Nivel->EditAttributes() ?>></div>
<div id="dsl_x_Id_Nivel" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Nivel->CheckBoxListHtml(FALSE, "x_Id_Nivel[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Nivel" id="s_x_Id_Nivel" value="<?php echo $dato_establecimiento->Id_Nivel->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Nivel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Jornada->Visible) { // Id_Jornada ?>
	<div id="r_Id_Jornada" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Jornada" id="u_Id_Jornada" value="1"<?php echo ($dato_establecimiento->Id_Jornada->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Jornada->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Jornada->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Jornada">
<div id="tp_x_Id_Jornada" class="ewTemplate"><input type="checkbox" data-table="dato_establecimiento" data-field="x_Id_Jornada" data-value-separator="<?php echo $dato_establecimiento->Id_Jornada->DisplayValueSeparatorAttribute() ?>" name="x_Id_Jornada[]" id="x_Id_Jornada[]" value="{value}"<?php echo $dato_establecimiento->Id_Jornada->EditAttributes() ?>></div>
<div id="dsl_x_Id_Jornada" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $dato_establecimiento->Id_Jornada->CheckBoxListHtml(FALSE, "x_Id_Jornada[]") ?>
</div></div>
<input type="hidden" name="s_x_Id_Jornada" id="s_x_Id_Jornada" value="<?php echo $dato_establecimiento->Id_Jornada->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Jornada->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Tipo_Zona->Visible) { // Tipo_Zona ?>
	<div id="r_Tipo_Zona" class="form-group">
		<label for="x_Tipo_Zona" class="col-sm-2 control-label">
<input type="checkbox" name="u_Tipo_Zona" id="u_Tipo_Zona" value="1"<?php echo ($dato_establecimiento->Tipo_Zona->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Tipo_Zona->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Tipo_Zona->CellAttributes() ?>>
<span id="el_dato_establecimiento_Tipo_Zona">
<input type="text" data-table="dato_establecimiento" data-field="x_Tipo_Zona" name="x_Tipo_Zona" id="x_Tipo_Zona" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($dato_establecimiento->Tipo_Zona->getPlaceHolder()) ?>" value="<?php echo $dato_establecimiento->Tipo_Zona->EditValue ?>"<?php echo $dato_establecimiento->Tipo_Zona->EditAttributes() ?>>
</span>
<?php echo $dato_establecimiento->Tipo_Zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Estado_Esc->Visible) { // Id_Estado_Esc ?>
	<div id="r_Id_Estado_Esc" class="form-group">
		<label for="x_Id_Estado_Esc" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Estado_Esc" id="u_Id_Estado_Esc" value="1"<?php echo ($dato_establecimiento->Id_Estado_Esc->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Estado_Esc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Estado_Esc->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Estado_Esc">
<select data-table="dato_establecimiento" data-field="x_Id_Estado_Esc" data-value-separator="<?php echo $dato_establecimiento->Id_Estado_Esc->DisplayValueSeparatorAttribute() ?>" id="x_Id_Estado_Esc" name="x_Id_Estado_Esc"<?php echo $dato_establecimiento->Id_Estado_Esc->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Estado_Esc->SelectOptionListHtml("x_Id_Estado_Esc") ?>
</select>
<input type="hidden" name="s_x_Id_Estado_Esc" id="s_x_Id_Estado_Esc" value="<?php echo $dato_establecimiento->Id_Estado_Esc->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Estado_Esc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dato_establecimiento->Id_Zona->Visible) { // Id_Zona ?>
	<div id="r_Id_Zona" class="form-group">
		<label for="x_Id_Zona" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Zona" id="u_Id_Zona" value="1"<?php echo ($dato_establecimiento->Id_Zona->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $dato_establecimiento->Id_Zona->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dato_establecimiento->Id_Zona->CellAttributes() ?>>
<span id="el_dato_establecimiento_Id_Zona">
<select data-table="dato_establecimiento" data-field="x_Id_Zona" data-value-separator="<?php echo $dato_establecimiento->Id_Zona->DisplayValueSeparatorAttribute() ?>" id="x_Id_Zona" name="x_Id_Zona"<?php echo $dato_establecimiento->Id_Zona->EditAttributes() ?>>
<?php echo $dato_establecimiento->Id_Zona->SelectOptionListHtml("x_Id_Zona") ?>
</select>
<input type="hidden" name="s_x_Id_Zona" id="s_x_Id_Zona" value="<?php echo $dato_establecimiento->Id_Zona->LookupFilterQuery() ?>">
</span>
<?php echo $dato_establecimiento->Id_Zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$dato_establecimiento_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dato_establecimiento_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
fdato_establecimientoupdate.Init();
</script>
<?php
$dato_establecimiento_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dato_establecimiento_update->Page_Terminate();
?>
