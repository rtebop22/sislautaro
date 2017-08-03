<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($servidor_escolar_grid)) $servidor_escolar_grid = new cservidor_escolar_grid();

// Page init
$servidor_escolar_grid->Page_Init();

// Page main
$servidor_escolar_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$servidor_escolar_grid->Page_Render();
?>
<?php if ($servidor_escolar->Export == "") { ?>
<script type="text/javascript">

// Form object
var fservidor_escolargrid = new ew_Form("fservidor_escolargrid", "grid");
fservidor_escolargrid.FormKeyCountName = '<?php echo $servidor_escolar_grid->FormKeyCountName ?>';

// Validate form
fservidor_escolargrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Nro_Serie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Nro_Serie->FldCaption(), $servidor_escolar->Nro_Serie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cant_Net_Asoc");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($servidor_escolar->Cant_Net_Asoc->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Marca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Marca->FldCaption(), $servidor_escolar->Id_Marca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Modelo->FldCaption(), $servidor_escolar->Id_Modelo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_SO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_SO->FldCaption(), $servidor_escolar->Id_SO->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $servidor_escolar->Id_Estado->FldCaption(), $servidor_escolar->Id_Estado->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fservidor_escolargrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Nro_Serie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SN", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cant_Net_Asoc", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Marca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Modelo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_SO", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "User_Server", false)) return false;
	if (ew_ValueChanged(fobj, infix, "User_TdServer", false)) return false;
	return true;
}

// Form_CustomValidate event
fservidor_escolargrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservidor_escolargrid.ValidateRequired = true;
<?php } else { ?>
fservidor_escolargrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fservidor_escolargrid.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca_server"};
fservidor_escolargrid.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"modelo_server"};
fservidor_escolargrid.Lists["x_Id_SO"] = {"LinkField":"x_Id_SO","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"so_server"};
fservidor_escolargrid.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_server"};

// Form object for search
</script>
<?php } ?>
<?php
if ($servidor_escolar->CurrentAction == "gridadd") {
	if ($servidor_escolar->CurrentMode == "copy") {
		$bSelectLimit = $servidor_escolar_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$servidor_escolar_grid->TotalRecs = $servidor_escolar->SelectRecordCount();
			$servidor_escolar_grid->Recordset = $servidor_escolar_grid->LoadRecordset($servidor_escolar_grid->StartRec-1, $servidor_escolar_grid->DisplayRecs);
		} else {
			if ($servidor_escolar_grid->Recordset = $servidor_escolar_grid->LoadRecordset())
				$servidor_escolar_grid->TotalRecs = $servidor_escolar_grid->Recordset->RecordCount();
		}
		$servidor_escolar_grid->StartRec = 1;
		$servidor_escolar_grid->DisplayRecs = $servidor_escolar_grid->TotalRecs;
	} else {
		$servidor_escolar->CurrentFilter = "0=1";
		$servidor_escolar_grid->StartRec = 1;
		$servidor_escolar_grid->DisplayRecs = $servidor_escolar->GridAddRowCount;
	}
	$servidor_escolar_grid->TotalRecs = $servidor_escolar_grid->DisplayRecs;
	$servidor_escolar_grid->StopRec = $servidor_escolar_grid->DisplayRecs;
} else {
	$bSelectLimit = $servidor_escolar_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($servidor_escolar_grid->TotalRecs <= 0)
			$servidor_escolar_grid->TotalRecs = $servidor_escolar->SelectRecordCount();
	} else {
		if (!$servidor_escolar_grid->Recordset && ($servidor_escolar_grid->Recordset = $servidor_escolar_grid->LoadRecordset()))
			$servidor_escolar_grid->TotalRecs = $servidor_escolar_grid->Recordset->RecordCount();
	}
	$servidor_escolar_grid->StartRec = 1;
	$servidor_escolar_grid->DisplayRecs = $servidor_escolar_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$servidor_escolar_grid->Recordset = $servidor_escolar_grid->LoadRecordset($servidor_escolar_grid->StartRec-1, $servidor_escolar_grid->DisplayRecs);

	// Set no record found message
	if ($servidor_escolar->CurrentAction == "" && $servidor_escolar_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$servidor_escolar_grid->setWarningMessage(ew_DeniedMsg());
		if ($servidor_escolar_grid->SearchWhere == "0=101")
			$servidor_escolar_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$servidor_escolar_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$servidor_escolar_grid->RenderOtherOptions();
?>
<?php $servidor_escolar_grid->ShowPageHeader(); ?>
<?php
$servidor_escolar_grid->ShowMessage();
?>
<?php if ($servidor_escolar_grid->TotalRecs > 0 || $servidor_escolar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid servidor_escolar">
<div id="fservidor_escolargrid" class="ewForm form-inline">
<?php if ($servidor_escolar_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($servidor_escolar_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_servidor_escolar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_servidor_escolargrid" class="table ewTable">
<?php echo $servidor_escolar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$servidor_escolar_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$servidor_escolar_grid->RenderListOptions();

// Render list options (header, left)
$servidor_escolar_grid->ListOptions->Render("header", "left");
?>
<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Nro_Serie) == "") { ?>
		<th data-name="Nro_Serie"><div id="elh_servidor_escolar_Nro_Serie" class="servidor_escolar_Nro_Serie"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Nro_Serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Serie"><div><div id="elh_servidor_escolar_Nro_Serie" class="servidor_escolar_Nro_Serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Nro_Serie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Nro_Serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Nro_Serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->SN->Visible) { // SN ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->SN) == "") { ?>
		<th data-name="SN"><div id="elh_servidor_escolar_SN" class="servidor_escolar_SN"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->SN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SN"><div><div id="elh_servidor_escolar_SN" class="servidor_escolar_SN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->SN->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->SN->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->SN->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Cant_Net_Asoc) == "") { ?>
		<th data-name="Cant_Net_Asoc"><div id="elh_servidor_escolar_Cant_Net_Asoc" class="servidor_escolar_Cant_Net_Asoc"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Cant_Net_Asoc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cant_Net_Asoc"><div><div id="elh_servidor_escolar_Cant_Net_Asoc" class="servidor_escolar_Cant_Net_Asoc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Cant_Net_Asoc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Cant_Net_Asoc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Cant_Net_Asoc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Id_Marca) == "") { ?>
		<th data-name="Id_Marca"><div id="elh_servidor_escolar_Id_Marca" class="servidor_escolar_Id_Marca"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Marca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Marca"><div><div id="elh_servidor_escolar_Id_Marca" class="servidor_escolar_Id_Marca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Marca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Id_Marca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Id_Marca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Id_Modelo) == "") { ?>
		<th data-name="Id_Modelo"><div id="elh_servidor_escolar_Id_Modelo" class="servidor_escolar_Id_Modelo"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Modelo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Modelo"><div><div id="elh_servidor_escolar_Id_Modelo" class="servidor_escolar_Id_Modelo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Modelo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Id_Modelo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Id_Modelo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Id_SO) == "") { ?>
		<th data-name="Id_SO"><div id="elh_servidor_escolar_Id_SO" class="servidor_escolar_Id_SO"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_SO->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_SO"><div><div id="elh_servidor_escolar_Id_SO" class="servidor_escolar_Id_SO">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_SO->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Id_SO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Id_SO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Id_Estado) == "") { ?>
		<th data-name="Id_Estado"><div id="elh_servidor_escolar_Id_Estado" class="servidor_escolar_Id_Estado"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado"><div><div id="elh_servidor_escolar_Id_Estado" class="servidor_escolar_Id_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Id_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Id_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Id_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->User_Server) == "") { ?>
		<th data-name="User_Server"><div id="elh_servidor_escolar_User_Server" class="servidor_escolar_User_Server"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->User_Server->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="User_Server"><div><div id="elh_servidor_escolar_User_Server" class="servidor_escolar_User_Server">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->User_Server->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->User_Server->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->User_Server->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->User_TdServer) == "") { ?>
		<th data-name="User_TdServer"><div id="elh_servidor_escolar_User_TdServer" class="servidor_escolar_User_TdServer"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->User_TdServer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="User_TdServer"><div><div id="elh_servidor_escolar_User_TdServer" class="servidor_escolar_User_TdServer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->User_TdServer->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->User_TdServer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->User_TdServer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_servidor_escolar_Fecha_Actualizacion" class="servidor_escolar_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_servidor_escolar_Fecha_Actualizacion" class="servidor_escolar_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
	<?php if ($servidor_escolar->SortUrl($servidor_escolar->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_servidor_escolar_Usuario" class="servidor_escolar_Usuario"><div class="ewTableHeaderCaption"><?php echo $servidor_escolar->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_servidor_escolar_Usuario" class="servidor_escolar_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $servidor_escolar->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($servidor_escolar->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($servidor_escolar->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$servidor_escolar_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$servidor_escolar_grid->StartRec = 1;
$servidor_escolar_grid->StopRec = $servidor_escolar_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($servidor_escolar_grid->FormKeyCountName) && ($servidor_escolar->CurrentAction == "gridadd" || $servidor_escolar->CurrentAction == "gridedit" || $servidor_escolar->CurrentAction == "F")) {
		$servidor_escolar_grid->KeyCount = $objForm->GetValue($servidor_escolar_grid->FormKeyCountName);
		$servidor_escolar_grid->StopRec = $servidor_escolar_grid->StartRec + $servidor_escolar_grid->KeyCount - 1;
	}
}
$servidor_escolar_grid->RecCnt = $servidor_escolar_grid->StartRec - 1;
if ($servidor_escolar_grid->Recordset && !$servidor_escolar_grid->Recordset->EOF) {
	$servidor_escolar_grid->Recordset->MoveFirst();
	$bSelectLimit = $servidor_escolar_grid->UseSelectLimit;
	if (!$bSelectLimit && $servidor_escolar_grid->StartRec > 1)
		$servidor_escolar_grid->Recordset->Move($servidor_escolar_grid->StartRec - 1);
} elseif (!$servidor_escolar->AllowAddDeleteRow && $servidor_escolar_grid->StopRec == 0) {
	$servidor_escolar_grid->StopRec = $servidor_escolar->GridAddRowCount;
}

// Initialize aggregate
$servidor_escolar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$servidor_escolar->ResetAttrs();
$servidor_escolar_grid->RenderRow();
if ($servidor_escolar->CurrentAction == "gridadd")
	$servidor_escolar_grid->RowIndex = 0;
if ($servidor_escolar->CurrentAction == "gridedit")
	$servidor_escolar_grid->RowIndex = 0;
while ($servidor_escolar_grid->RecCnt < $servidor_escolar_grid->StopRec) {
	$servidor_escolar_grid->RecCnt++;
	if (intval($servidor_escolar_grid->RecCnt) >= intval($servidor_escolar_grid->StartRec)) {
		$servidor_escolar_grid->RowCnt++;
		if ($servidor_escolar->CurrentAction == "gridadd" || $servidor_escolar->CurrentAction == "gridedit" || $servidor_escolar->CurrentAction == "F") {
			$servidor_escolar_grid->RowIndex++;
			$objForm->Index = $servidor_escolar_grid->RowIndex;
			if ($objForm->HasValue($servidor_escolar_grid->FormActionName))
				$servidor_escolar_grid->RowAction = strval($objForm->GetValue($servidor_escolar_grid->FormActionName));
			elseif ($servidor_escolar->CurrentAction == "gridadd")
				$servidor_escolar_grid->RowAction = "insert";
			else
				$servidor_escolar_grid->RowAction = "";
		}

		// Set up key count
		$servidor_escolar_grid->KeyCount = $servidor_escolar_grid->RowIndex;

		// Init row class and style
		$servidor_escolar->ResetAttrs();
		$servidor_escolar->CssClass = "";
		if ($servidor_escolar->CurrentAction == "gridadd") {
			if ($servidor_escolar->CurrentMode == "copy") {
				$servidor_escolar_grid->LoadRowValues($servidor_escolar_grid->Recordset); // Load row values
				$servidor_escolar_grid->SetRecordKey($servidor_escolar_grid->RowOldKey, $servidor_escolar_grid->Recordset); // Set old record key
			} else {
				$servidor_escolar_grid->LoadDefaultValues(); // Load default values
				$servidor_escolar_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$servidor_escolar_grid->LoadRowValues($servidor_escolar_grid->Recordset); // Load row values
		}
		$servidor_escolar->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($servidor_escolar->CurrentAction == "gridadd") // Grid add
			$servidor_escolar->RowType = EW_ROWTYPE_ADD; // Render add
		if ($servidor_escolar->CurrentAction == "gridadd" && $servidor_escolar->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$servidor_escolar_grid->RestoreCurrentRowFormValues($servidor_escolar_grid->RowIndex); // Restore form values
		if ($servidor_escolar->CurrentAction == "gridedit") { // Grid edit
			if ($servidor_escolar->EventCancelled) {
				$servidor_escolar_grid->RestoreCurrentRowFormValues($servidor_escolar_grid->RowIndex); // Restore form values
			}
			if ($servidor_escolar_grid->RowAction == "insert")
				$servidor_escolar->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$servidor_escolar->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($servidor_escolar->CurrentAction == "gridedit" && ($servidor_escolar->RowType == EW_ROWTYPE_EDIT || $servidor_escolar->RowType == EW_ROWTYPE_ADD) && $servidor_escolar->EventCancelled) // Update failed
			$servidor_escolar_grid->RestoreCurrentRowFormValues($servidor_escolar_grid->RowIndex); // Restore form values
		if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) // Edit row
			$servidor_escolar_grid->EditRowCnt++;
		if ($servidor_escolar->CurrentAction == "F") // Confirm row
			$servidor_escolar_grid->RestoreCurrentRowFormValues($servidor_escolar_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$servidor_escolar->RowAttrs = array_merge($servidor_escolar->RowAttrs, array('data-rowindex'=>$servidor_escolar_grid->RowCnt, 'id'=>'r' . $servidor_escolar_grid->RowCnt . '_servidor_escolar', 'data-rowtype'=>$servidor_escolar->RowType));

		// Render row
		$servidor_escolar_grid->RenderRow();

		// Render list options
		$servidor_escolar_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($servidor_escolar_grid->RowAction <> "delete" && $servidor_escolar_grid->RowAction <> "insertdelete" && !($servidor_escolar_grid->RowAction == "insert" && $servidor_escolar->CurrentAction == "F" && $servidor_escolar_grid->EmptyRow())) {
?>
	<tr<?php echo $servidor_escolar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$servidor_escolar_grid->ListOptions->Render("body", "left", $servidor_escolar_grid->RowCnt);
?>
	<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
		<td data-name="Nro_Serie"<?php echo $servidor_escolar->Nro_Serie->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Nro_Serie" class="form-group servidor_escolar_Nro_Serie">
<input type="text" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Nro_Serie->EditValue ?>"<?php echo $servidor_escolar->Nro_Serie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Nro_Serie" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" value="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Nro_Serie" class="form-group servidor_escolar_Nro_Serie">
<input type="text" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Nro_Serie->EditValue ?>"<?php echo $servidor_escolar->Nro_Serie->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Nro_Serie" class="servidor_escolar_Nro_Serie">
<span<?php echo $servidor_escolar->Nro_Serie->ViewAttributes() ?>>
<?php echo $servidor_escolar->Nro_Serie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" value="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Nro_Serie" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" value="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->OldValue) ?>">
<?php } ?>
<a id="<?php echo $servidor_escolar_grid->PageObjName . "_row_" . $servidor_escolar_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cue" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($servidor_escolar->Cue->CurrentValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Cue" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($servidor_escolar->Cue->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT || $servidor_escolar->CurrentMode == "edit") { ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cue" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($servidor_escolar->Cue->CurrentValue) ?>">
<?php } ?>
	<?php if ($servidor_escolar->SN->Visible) { // SN ?>
		<td data-name="SN"<?php echo $servidor_escolar->SN->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_SN" class="form-group servidor_escolar_SN">
<input type="text" data-table="servidor_escolar" data-field="x_SN" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->SN->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->SN->EditValue ?>"<?php echo $servidor_escolar->SN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_SN" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($servidor_escolar->SN->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_SN" class="form-group servidor_escolar_SN">
<input type="text" data-table="servidor_escolar" data-field="x_SN" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->SN->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->SN->EditValue ?>"<?php echo $servidor_escolar->SN->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_SN" class="servidor_escolar_SN">
<span<?php echo $servidor_escolar->SN->ViewAttributes() ?>>
<?php echo $servidor_escolar->SN->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_SN" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($servidor_escolar->SN->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_SN" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($servidor_escolar->SN->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
		<td data-name="Cant_Net_Asoc"<?php echo $servidor_escolar->Cant_Net_Asoc->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Cant_Net_Asoc" class="form-group servidor_escolar_Cant_Net_Asoc">
<input type="text" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cant_Net_Asoc->EditValue ?>"<?php echo $servidor_escolar->Cant_Net_Asoc->EditAttributes() ?>>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" value="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Cant_Net_Asoc" class="form-group servidor_escolar_Cant_Net_Asoc">
<input type="text" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cant_Net_Asoc->EditValue ?>"<?php echo $servidor_escolar->Cant_Net_Asoc->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Cant_Net_Asoc" class="servidor_escolar_Cant_Net_Asoc">
<span<?php echo $servidor_escolar->Cant_Net_Asoc->ViewAttributes() ?>>
<?php echo $servidor_escolar->Cant_Net_Asoc->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" value="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" value="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca"<?php echo $servidor_escolar->Id_Marca->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Marca" class="form-group servidor_escolar_Id_Marca">
<select data-table="servidor_escolar" data-field="x_Id_Marca" data-value-separator="<?php echo $servidor_escolar->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca"<?php echo $servidor_escolar->Id_Marca->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo $servidor_escolar->Id_Marca->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Marca" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Marca->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Marca" class="form-group servidor_escolar_Id_Marca">
<select data-table="servidor_escolar" data-field="x_Id_Marca" data-value-separator="<?php echo $servidor_escolar->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca"<?php echo $servidor_escolar->Id_Marca->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo $servidor_escolar->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Marca" class="servidor_escolar_Id_Marca">
<span<?php echo $servidor_escolar->Id_Marca->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Marca" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Marca->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Marca" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Marca->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Modelo" class="form-group servidor_escolar_Id_Modelo">
<select data-table="servidor_escolar" data-field="x_Id_Modelo" data-value-separator="<?php echo $servidor_escolar->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo $servidor_escolar->Id_Modelo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Modelo" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Modelo->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Modelo" class="form-group servidor_escolar_Id_Modelo">
<select data-table="servidor_escolar" data-field="x_Id_Modelo" data-value-separator="<?php echo $servidor_escolar->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo $servidor_escolar->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Modelo" class="servidor_escolar_Id_Modelo">
<span<?php echo $servidor_escolar->Id_Modelo->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Modelo" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Modelo->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Modelo" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Modelo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
		<td data-name="Id_SO"<?php echo $servidor_escolar->Id_SO->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_SO" class="form-group servidor_escolar_Id_SO">
<select data-table="servidor_escolar" data-field="x_Id_SO" data-value-separator="<?php echo $servidor_escolar->Id_SO->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO"<?php echo $servidor_escolar->Id_SO->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo $servidor_escolar->Id_SO->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_SO" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_SO->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_SO" class="form-group servidor_escolar_Id_SO">
<select data-table="servidor_escolar" data-field="x_Id_SO" data-value-separator="<?php echo $servidor_escolar->Id_SO->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO"<?php echo $servidor_escolar->Id_SO->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo $servidor_escolar->Id_SO->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_SO" class="servidor_escolar_Id_SO">
<span<?php echo $servidor_escolar->Id_SO->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_SO" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_SO->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_SO" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_SO->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado"<?php echo $servidor_escolar->Id_Estado->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Estado" class="form-group servidor_escolar_Id_Estado">
<select data-table="servidor_escolar" data-field="x_Id_Estado" data-value-separator="<?php echo $servidor_escolar->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado"<?php echo $servidor_escolar->Id_Estado->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo $servidor_escolar->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Estado" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Estado->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Estado" class="form-group servidor_escolar_Id_Estado">
<select data-table="servidor_escolar" data-field="x_Id_Estado" data-value-separator="<?php echo $servidor_escolar->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado"<?php echo $servidor_escolar->Id_Estado->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo $servidor_escolar->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Id_Estado" class="servidor_escolar_Id_Estado">
<span<?php echo $servidor_escolar->Id_Estado->ViewAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Estado" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Estado->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Estado" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
		<td data-name="User_Server"<?php echo $servidor_escolar->User_Server->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_Server" class="form-group servidor_escolar_User_Server">
<input type="text" data-table="servidor_escolar" data-field="x_User_Server" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_Server->EditValue ?>"<?php echo $servidor_escolar->User_Server->EditAttributes() ?>>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_Server" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" value="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_Server" class="form-group servidor_escolar_User_Server">
<input type="text" data-table="servidor_escolar" data-field="x_User_Server" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_Server->EditValue ?>"<?php echo $servidor_escolar->User_Server->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_Server" class="servidor_escolar_User_Server">
<span<?php echo $servidor_escolar->User_Server->ViewAttributes() ?>>
<?php echo $servidor_escolar->User_Server->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_Server" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" value="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_User_Server" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" value="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
		<td data-name="User_TdServer"<?php echo $servidor_escolar->User_TdServer->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_TdServer" class="form-group servidor_escolar_User_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_User_TdServer" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_TdServer->EditValue ?>"<?php echo $servidor_escolar->User_TdServer->EditAttributes() ?>>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_TdServer" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" value="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_TdServer" class="form-group servidor_escolar_User_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_User_TdServer" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_TdServer->EditValue ?>"<?php echo $servidor_escolar->User_TdServer->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_User_TdServer" class="servidor_escolar_User_TdServer">
<span<?php echo $servidor_escolar->User_TdServer->ViewAttributes() ?>>
<?php echo $servidor_escolar->User_TdServer->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_TdServer" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" value="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_User_TdServer" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" value="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $servidor_escolar->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Fecha_Actualizacion" class="servidor_escolar_Fecha_Actualizacion">
<span<?php echo $servidor_escolar->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $servidor_escolar->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $servidor_escolar->Usuario->CellAttributes() ?>>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Usuario" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $servidor_escolar_grid->RowCnt ?>_servidor_escolar_Usuario" class="servidor_escolar_Usuario">
<span<?php echo $servidor_escolar->Usuario->ViewAttributes() ?>>
<?php echo $servidor_escolar->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Usuario" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->FormValue) ?>">
<input type="hidden" data-table="servidor_escolar" data-field="x_Usuario" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$servidor_escolar_grid->ListOptions->Render("body", "right", $servidor_escolar_grid->RowCnt);
?>
	</tr>
<?php if ($servidor_escolar->RowType == EW_ROWTYPE_ADD || $servidor_escolar->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fservidor_escolargrid.UpdateOpts(<?php echo $servidor_escolar_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($servidor_escolar->CurrentAction <> "gridadd" || $servidor_escolar->CurrentMode == "copy")
		if (!$servidor_escolar_grid->Recordset->EOF) $servidor_escolar_grid->Recordset->MoveNext();
}
?>
<?php
	if ($servidor_escolar->CurrentMode == "add" || $servidor_escolar->CurrentMode == "copy" || $servidor_escolar->CurrentMode == "edit") {
		$servidor_escolar_grid->RowIndex = '$rowindex$';
		$servidor_escolar_grid->LoadDefaultValues();

		// Set row properties
		$servidor_escolar->ResetAttrs();
		$servidor_escolar->RowAttrs = array_merge($servidor_escolar->RowAttrs, array('data-rowindex'=>$servidor_escolar_grid->RowIndex, 'id'=>'r0_servidor_escolar', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($servidor_escolar->RowAttrs["class"], "ewTemplate");
		$servidor_escolar->RowType = EW_ROWTYPE_ADD;

		// Render row
		$servidor_escolar_grid->RenderRow();

		// Render list options
		$servidor_escolar_grid->RenderListOptions();
		$servidor_escolar_grid->StartRowCnt = 0;
?>
	<tr<?php echo $servidor_escolar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$servidor_escolar_grid->ListOptions->Render("body", "left", $servidor_escolar_grid->RowIndex);
?>
	<?php if ($servidor_escolar->Nro_Serie->Visible) { // Nro_Serie ?>
		<td data-name="Nro_Serie">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Nro_Serie" class="form-group servidor_escolar_Nro_Serie">
<input type="text" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Nro_Serie->EditValue ?>"<?php echo $servidor_escolar->Nro_Serie->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Nro_Serie" class="form-group servidor_escolar_Nro_Serie">
<span<?php echo $servidor_escolar->Nro_Serie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Nro_Serie->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Nro_Serie" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" value="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Nro_Serie" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Nro_Serie" value="<?php echo ew_HtmlEncode($servidor_escolar->Nro_Serie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->SN->Visible) { // SN ?>
		<td data-name="SN">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_SN" class="form-group servidor_escolar_SN">
<input type="text" data-table="servidor_escolar" data-field="x_SN" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->SN->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->SN->EditValue ?>"<?php echo $servidor_escolar->SN->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_SN" class="form-group servidor_escolar_SN">
<span<?php echo $servidor_escolar->SN->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->SN->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_SN" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($servidor_escolar->SN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_SN" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_SN" value="<?php echo ew_HtmlEncode($servidor_escolar->SN->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Cant_Net_Asoc->Visible) { // Cant_Net_Asoc ?>
		<td data-name="Cant_Net_Asoc">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Cant_Net_Asoc" class="form-group servidor_escolar_Cant_Net_Asoc">
<input type="text" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" size="30" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->Cant_Net_Asoc->EditValue ?>"<?php echo $servidor_escolar->Cant_Net_Asoc->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Cant_Net_Asoc" class="form-group servidor_escolar_Cant_Net_Asoc">
<span<?php echo $servidor_escolar->Cant_Net_Asoc->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Cant_Net_Asoc->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" value="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Cant_Net_Asoc" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Cant_Net_Asoc" value="<?php echo ew_HtmlEncode($servidor_escolar->Cant_Net_Asoc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Id_Marca" class="form-group servidor_escolar_Id_Marca">
<select data-table="servidor_escolar" data-field="x_Id_Marca" data-value-separator="<?php echo $servidor_escolar->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca"<?php echo $servidor_escolar->Id_Marca->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Marca->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo $servidor_escolar->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Id_Marca" class="form-group servidor_escolar_Id_Marca">
<span<?php echo $servidor_escolar->Id_Marca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Id_Marca->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Marca" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Marca->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Marca" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Marca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Id_Modelo" class="form-group servidor_escolar_Id_Modelo">
<select data-table="servidor_escolar" data-field="x_Id_Modelo" data-value-separator="<?php echo $servidor_escolar->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo"<?php echo $servidor_escolar->Id_Modelo->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Modelo->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo $servidor_escolar->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Id_Modelo" class="form-group servidor_escolar_Id_Modelo">
<span<?php echo $servidor_escolar->Id_Modelo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Id_Modelo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Modelo" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Modelo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Modelo" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Modelo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_SO->Visible) { // Id_SO ?>
		<td data-name="Id_SO">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Id_SO" class="form-group servidor_escolar_Id_SO">
<select data-table="servidor_escolar" data-field="x_Id_SO" data-value-separator="<?php echo $servidor_escolar->Id_SO->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO"<?php echo $servidor_escolar->Id_SO->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_SO->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo $servidor_escolar->Id_SO->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Id_SO" class="form-group servidor_escolar_Id_SO">
<span<?php echo $servidor_escolar->Id_SO->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Id_SO->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_SO" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_SO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_SO" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_SO" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_SO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_Id_Estado" class="form-group servidor_escolar_Id_Estado">
<select data-table="servidor_escolar" data-field="x_Id_Estado" data-value-separator="<?php echo $servidor_escolar->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado"<?php echo $servidor_escolar->Id_Estado->EditAttributes() ?>>
<?php echo $servidor_escolar->Id_Estado->SelectOptionListHtml("x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo $servidor_escolar->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_Id_Estado" class="form-group servidor_escolar_Id_Estado">
<span<?php echo $servidor_escolar->Id_Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->Id_Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Estado" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Id_Estado" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($servidor_escolar->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->User_Server->Visible) { // User_Server ?>
		<td data-name="User_Server">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_User_Server" class="form-group servidor_escolar_User_Server">
<input type="text" data-table="servidor_escolar" data-field="x_User_Server" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_Server->EditValue ?>"<?php echo $servidor_escolar->User_Server->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_User_Server" class="form-group servidor_escolar_User_Server">
<span<?php echo $servidor_escolar->User_Server->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->User_Server->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_Server" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" value="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_Server" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_Server" value="<?php echo ew_HtmlEncode($servidor_escolar->User_Server->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->User_TdServer->Visible) { // User_TdServer ?>
		<td data-name="User_TdServer">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_servidor_escolar_User_TdServer" class="form-group servidor_escolar_User_TdServer">
<input type="text" data-table="servidor_escolar" data-field="x_User_TdServer" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->getPlaceHolder()) ?>" value="<?php echo $servidor_escolar->User_TdServer->EditValue ?>"<?php echo $servidor_escolar->User_TdServer->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_servidor_escolar_User_TdServer" class="form-group servidor_escolar_User_TdServer">
<span<?php echo $servidor_escolar->User_TdServer->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $servidor_escolar->User_TdServer->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_TdServer" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" value="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_User_TdServer" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_User_TdServer" value="<?php echo ew_HtmlEncode($servidor_escolar->User_TdServer->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Fecha_Actualizacion" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($servidor_escolar->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($servidor_escolar->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($servidor_escolar->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Usuario" name="x<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" id="x<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="servidor_escolar" data-field="x_Usuario" name="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" id="o<?php echo $servidor_escolar_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($servidor_escolar->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$servidor_escolar_grid->ListOptions->Render("body", "right", $servidor_escolar_grid->RowCnt);
?>
<script type="text/javascript">
fservidor_escolargrid.UpdateOpts(<?php echo $servidor_escolar_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($servidor_escolar->CurrentMode == "add" || $servidor_escolar->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $servidor_escolar_grid->FormKeyCountName ?>" id="<?php echo $servidor_escolar_grid->FormKeyCountName ?>" value="<?php echo $servidor_escolar_grid->KeyCount ?>">
<?php echo $servidor_escolar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($servidor_escolar->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $servidor_escolar_grid->FormKeyCountName ?>" id="<?php echo $servidor_escolar_grid->FormKeyCountName ?>" value="<?php echo $servidor_escolar_grid->KeyCount ?>">
<?php echo $servidor_escolar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($servidor_escolar->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fservidor_escolargrid">
</div>
<?php

// Close recordset
if ($servidor_escolar_grid->Recordset)
	$servidor_escolar_grid->Recordset->Close();
?>
<?php if ($servidor_escolar_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($servidor_escolar_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($servidor_escolar_grid->TotalRecs == 0 && $servidor_escolar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($servidor_escolar_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($servidor_escolar->Export == "") { ?>
<script type="text/javascript">
fservidor_escolargrid.Init();
</script>
<?php } ?>
<?php
$servidor_escolar_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$servidor_escolar_grid->Page_Terminate();
?>
