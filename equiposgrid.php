<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($equipos_grid)) $equipos_grid = new cequipos_grid();

// Page init
$equipos_grid->Page_Init();

// Page main
$equipos_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equipos_grid->Page_Render();
?>
<?php if ($equipos->Export == "") { ?>
<script type="text/javascript">

// Form object
var fequiposgrid = new ew_Form("fequiposgrid", "grid");
fequiposgrid.FormKeyCountName = '<?php echo $equipos_grid->FormKeyCountName ?>';

// Validate form
fequiposgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->NroSerie->FldCaption(), $equipos->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ubicacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ubicacion->FldCaption(), $equipos->Id_Ubicacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Estado->FldCaption(), $equipos->Id_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Sit_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Sit_Estado->FldCaption(), $equipos->Id_Sit_Estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Marca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Marca->FldCaption(), $equipos->Id_Marca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Modelo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Modelo->FldCaption(), $equipos->Id_Modelo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Ano");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equipos->Id_Ano->FldCaption(), $equipos->Id_Ano->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fequiposgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroMac", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Ubicacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Sit_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Marca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Modelo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Ano", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Equipo", false)) return false;
	return true;
}

// Form_CustomValidate event
fequiposgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fequiposgrid.ValidateRequired = true;
<?php } else { ?>
fequiposgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fequiposgrid.Lists["x_Id_Ubicacion"] = {"LinkField":"x_Id_Ubicacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ubicacion_equipo"};
fequiposgrid.Lists["x_Id_Estado"] = {"LinkField":"x_Id_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipo"};
fequiposgrid.Lists["x_Id_Sit_Estado"] = {"LinkField":"x_Id_Sit_Estado","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"situacion_estado"};
fequiposgrid.Lists["x_Id_Marca"] = {"LinkField":"x_Id_Marca","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Modelo"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"marca"};
fequiposgrid.Lists["x_Id_Modelo"] = {"LinkField":"x_Id_Modelo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":["x_Id_Marca"],"ChildFields":[],"FilterFields":["x_Id_Marca"],"Options":[],"Template":"","LinkTable":"modelo"};
fequiposgrid.Lists["x_Id_Ano"] = {"LinkField":"x_Id_Ano","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ano_entrega"};
fequiposgrid.Lists["x_Id_Tipo_Equipo"] = {"LinkField":"x_Id_Tipo_Equipo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Detalle","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_equipo"};

// Form object for search
</script>
<?php } ?>
<?php
if ($equipos->CurrentAction == "gridadd") {
	if ($equipos->CurrentMode == "copy") {
		$bSelectLimit = $equipos_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$equipos_grid->TotalRecs = $equipos->SelectRecordCount();
			$equipos_grid->Recordset = $equipos_grid->LoadRecordset($equipos_grid->StartRec-1, $equipos_grid->DisplayRecs);
		} else {
			if ($equipos_grid->Recordset = $equipos_grid->LoadRecordset())
				$equipos_grid->TotalRecs = $equipos_grid->Recordset->RecordCount();
		}
		$equipos_grid->StartRec = 1;
		$equipos_grid->DisplayRecs = $equipos_grid->TotalRecs;
	} else {
		$equipos->CurrentFilter = "0=1";
		$equipos_grid->StartRec = 1;
		$equipos_grid->DisplayRecs = $equipos->GridAddRowCount;
	}
	$equipos_grid->TotalRecs = $equipos_grid->DisplayRecs;
	$equipos_grid->StopRec = $equipos_grid->DisplayRecs;
} else {
	$bSelectLimit = $equipos_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($equipos_grid->TotalRecs <= 0)
			$equipos_grid->TotalRecs = $equipos->SelectRecordCount();
	} else {
		if (!$equipos_grid->Recordset && ($equipos_grid->Recordset = $equipos_grid->LoadRecordset()))
			$equipos_grid->TotalRecs = $equipos_grid->Recordset->RecordCount();
	}
	$equipos_grid->StartRec = 1;
	$equipos_grid->DisplayRecs = $equipos_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$equipos_grid->Recordset = $equipos_grid->LoadRecordset($equipos_grid->StartRec-1, $equipos_grid->DisplayRecs);

	// Set no record found message
	if ($equipos->CurrentAction == "" && $equipos_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$equipos_grid->setWarningMessage(ew_DeniedMsg());
		if ($equipos_grid->SearchWhere == "0=101")
			$equipos_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$equipos_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$equipos_grid->RenderOtherOptions();
?>
<?php $equipos_grid->ShowPageHeader(); ?>
<?php
$equipos_grid->ShowMessage();
?>
<?php if ($equipos_grid->TotalRecs > 0 || $equipos->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid equipos">
<div id="fequiposgrid" class="ewForm form-inline">
<?php if ($equipos_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($equipos_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_equipos" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_equiposgrid" class="table ewTable">
<?php echo $equipos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$equipos_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$equipos_grid->RenderListOptions();

// Render list options (header, left)
$equipos_grid->ListOptions->Render("header", "left");
?>
<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
	<?php if ($equipos->SortUrl($equipos->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_equipos_NroSerie" class="equipos_NroSerie"><div class="ewTableHeaderCaption"><?php echo $equipos->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div><div id="elh_equipos_NroSerie" class="equipos_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->NroSerie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->NroMac->Visible) { // NroMac ?>
	<?php if ($equipos->SortUrl($equipos->NroMac) == "") { ?>
		<th data-name="NroMac"><div id="elh_equipos_NroMac" class="equipos_NroMac"><div class="ewTableHeaderCaption"><?php echo $equipos->NroMac->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroMac"><div><div id="elh_equipos_NroMac" class="equipos_NroMac">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->NroMac->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->NroMac->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->NroMac->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
	<?php if ($equipos->SortUrl($equipos->Id_Ubicacion) == "") { ?>
		<th data-name="Id_Ubicacion"><div id="elh_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Ubicacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Ubicacion"><div><div id="elh_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Ubicacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Ubicacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Ubicacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
	<?php if ($equipos->SortUrl($equipos->Id_Estado) == "") { ?>
		<th data-name="Id_Estado"><div id="elh_equipos_Id_Estado" class="equipos_Id_Estado"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado"><div><div id="elh_equipos_Id_Estado" class="equipos_Id_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
	<?php if ($equipos->SortUrl($equipos->Id_Sit_Estado) == "") { ?>
		<th data-name="Id_Sit_Estado"><div id="elh_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Sit_Estado"><div><div id="elh_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Sit_Estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Sit_Estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Sit_Estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
	<?php if ($equipos->SortUrl($equipos->Id_Marca) == "") { ?>
		<th data-name="Id_Marca"><div id="elh_equipos_Id_Marca" class="equipos_Id_Marca"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Marca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Marca"><div><div id="elh_equipos_Id_Marca" class="equipos_Id_Marca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Marca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Marca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Marca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
	<?php if ($equipos->SortUrl($equipos->Id_Modelo) == "") { ?>
		<th data-name="Id_Modelo"><div id="elh_equipos_Id_Modelo" class="equipos_Id_Modelo"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Modelo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Modelo"><div><div id="elh_equipos_Id_Modelo" class="equipos_Id_Modelo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Modelo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Modelo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Modelo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
	<?php if ($equipos->SortUrl($equipos->Id_Ano) == "") { ?>
		<th data-name="Id_Ano"><div id="elh_equipos_Id_Ano" class="equipos_Id_Ano"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Ano->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Ano"><div><div id="elh_equipos_Id_Ano" class="equipos_Id_Ano">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Ano->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Ano->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Ano->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
	<?php if ($equipos->SortUrl($equipos->Id_Tipo_Equipo) == "") { ?>
		<th data-name="Id_Tipo_Equipo"><div id="elh_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo"><div class="ewTableHeaderCaption"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Equipo"><div><div id="elh_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Id_Tipo_Equipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Id_Tipo_Equipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Id_Tipo_Equipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Usuario->Visible) { // Usuario ?>
	<?php if ($equipos->SortUrl($equipos->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_equipos_Usuario" class="equipos_Usuario"><div class="ewTableHeaderCaption"><?php echo $equipos->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_equipos_Usuario" class="equipos_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($equipos->SortUrl($equipos->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $equipos->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($equipos->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($equipos->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$equipos_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$equipos_grid->StartRec = 1;
$equipos_grid->StopRec = $equipos_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($equipos_grid->FormKeyCountName) && ($equipos->CurrentAction == "gridadd" || $equipos->CurrentAction == "gridedit" || $equipos->CurrentAction == "F")) {
		$equipos_grid->KeyCount = $objForm->GetValue($equipos_grid->FormKeyCountName);
		$equipos_grid->StopRec = $equipos_grid->StartRec + $equipos_grid->KeyCount - 1;
	}
}
$equipos_grid->RecCnt = $equipos_grid->StartRec - 1;
if ($equipos_grid->Recordset && !$equipos_grid->Recordset->EOF) {
	$equipos_grid->Recordset->MoveFirst();
	$bSelectLimit = $equipos_grid->UseSelectLimit;
	if (!$bSelectLimit && $equipos_grid->StartRec > 1)
		$equipos_grid->Recordset->Move($equipos_grid->StartRec - 1);
} elseif (!$equipos->AllowAddDeleteRow && $equipos_grid->StopRec == 0) {
	$equipos_grid->StopRec = $equipos->GridAddRowCount;
}

// Initialize aggregate
$equipos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$equipos->ResetAttrs();
$equipos_grid->RenderRow();
if ($equipos->CurrentAction == "gridadd")
	$equipos_grid->RowIndex = 0;
if ($equipos->CurrentAction == "gridedit")
	$equipos_grid->RowIndex = 0;
while ($equipos_grid->RecCnt < $equipos_grid->StopRec) {
	$equipos_grid->RecCnt++;
	if (intval($equipos_grid->RecCnt) >= intval($equipos_grid->StartRec)) {
		$equipos_grid->RowCnt++;
		if ($equipos->CurrentAction == "gridadd" || $equipos->CurrentAction == "gridedit" || $equipos->CurrentAction == "F") {
			$equipos_grid->RowIndex++;
			$objForm->Index = $equipos_grid->RowIndex;
			if ($objForm->HasValue($equipos_grid->FormActionName))
				$equipos_grid->RowAction = strval($objForm->GetValue($equipos_grid->FormActionName));
			elseif ($equipos->CurrentAction == "gridadd")
				$equipos_grid->RowAction = "insert";
			else
				$equipos_grid->RowAction = "";
		}

		// Set up key count
		$equipos_grid->KeyCount = $equipos_grid->RowIndex;

		// Init row class and style
		$equipos->ResetAttrs();
		$equipos->CssClass = "";
		if ($equipos->CurrentAction == "gridadd") {
			if ($equipos->CurrentMode == "copy") {
				$equipos_grid->LoadRowValues($equipos_grid->Recordset); // Load row values
				$equipos_grid->SetRecordKey($equipos_grid->RowOldKey, $equipos_grid->Recordset); // Set old record key
			} else {
				$equipos_grid->LoadDefaultValues(); // Load default values
				$equipos_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$equipos_grid->LoadRowValues($equipos_grid->Recordset); // Load row values
		}
		$equipos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($equipos->CurrentAction == "gridadd") // Grid add
			$equipos->RowType = EW_ROWTYPE_ADD; // Render add
		if ($equipos->CurrentAction == "gridadd" && $equipos->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$equipos_grid->RestoreCurrentRowFormValues($equipos_grid->RowIndex); // Restore form values
		if ($equipos->CurrentAction == "gridedit") { // Grid edit
			if ($equipos->EventCancelled) {
				$equipos_grid->RestoreCurrentRowFormValues($equipos_grid->RowIndex); // Restore form values
			}
			if ($equipos_grid->RowAction == "insert")
				$equipos->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$equipos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($equipos->CurrentAction == "gridedit" && ($equipos->RowType == EW_ROWTYPE_EDIT || $equipos->RowType == EW_ROWTYPE_ADD) && $equipos->EventCancelled) // Update failed
			$equipos_grid->RestoreCurrentRowFormValues($equipos_grid->RowIndex); // Restore form values
		if ($equipos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$equipos_grid->EditRowCnt++;
		if ($equipos->CurrentAction == "F") // Confirm row
			$equipos_grid->RestoreCurrentRowFormValues($equipos_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$equipos->RowAttrs = array_merge($equipos->RowAttrs, array('data-rowindex'=>$equipos_grid->RowCnt, 'id'=>'r' . $equipos_grid->RowCnt . '_equipos', 'data-rowtype'=>$equipos->RowType));

		// Render row
		$equipos_grid->RenderRow();

		// Render list options
		$equipos_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($equipos_grid->RowAction <> "delete" && $equipos_grid->RowAction <> "insertdelete" && !($equipos_grid->RowAction == "insert" && $equipos->CurrentAction == "F" && $equipos_grid->EmptyRow())) {
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$equipos_grid->ListOptions->Render("body", "left", $equipos_grid->RowCnt);
?>
	<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $equipos->NroSerie->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->EditValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroSerie" class="equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<?php echo $equipos->NroSerie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
<?php } ?>
<a id="<?php echo $equipos_grid->PageObjName . "_row_" . $equipos_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td data-name="NroMac"<?php echo $equipos->NroMac->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_grid->RowIndex ?>_NroMac" id="x<?php echo $equipos_grid->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_grid->RowIndex ?>_NroMac" id="o<?php echo $equipos_grid->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_grid->RowIndex ?>_NroMac" id="x<?php echo $equipos_grid->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_NroMac" class="equipos_NroMac">
<span<?php echo $equipos->NroMac->ViewAttributes() ?>>
<?php echo $equipos->NroMac->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_grid->RowIndex ?>_NroMac" id="x<?php echo $equipos_grid->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_grid->RowIndex ?>_NroMac" id="o<?php echo $equipos_grid->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td data-name="Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ubicacion" class="equipos_Id_Ubicacion">
<span<?php echo $equipos->Id_Ubicacion->ViewAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado"<?php echo $equipos->Id_Estado->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Estado" class="equipos_Id_Estado">
<span<?php echo $equipos->Id_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td data-name="Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Sit_Estado" class="equipos_Id_Sit_Estado">
<span<?php echo $equipos->Id_Sit_Estado->ViewAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca"<?php echo $equipos->Id_Marca->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Marca" class="equipos_Id_Marca">
<span<?php echo $equipos->Id_Marca->ViewAttributes() ?>>
<?php echo $equipos->Id_Marca->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo"<?php echo $equipos->Id_Modelo->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Modelo" class="equipos_Id_Modelo">
<span<?php echo $equipos->Id_Modelo->ViewAttributes() ?>>
<?php echo $equipos->Id_Modelo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td data-name="Id_Ano"<?php echo $equipos->Id_Ano->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Ano" class="equipos_Id_Ano">
<span<?php echo $equipos->Id_Ano->ViewAttributes() ?>>
<?php echo $equipos->Id_Ano->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td data-name="Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Id_Tipo_Equipo" class="equipos_Id_Tipo_Equipo">
<span<?php echo $equipos->Id_Tipo_Equipo->ViewAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $equipos->Usuario->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_grid->RowIndex ?>_Usuario" id="o<?php echo $equipos_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Usuario" class="equipos_Usuario">
<span<?php echo $equipos->Usuario->ViewAttributes() ?>>
<?php echo $equipos->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="x<?php echo $equipos_grid->RowIndex ?>_Usuario" id="x<?php echo $equipos_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_grid->RowIndex ?>_Usuario" id="o<?php echo $equipos_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $equipos->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($equipos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $equipos_grid->RowCnt ?>_equipos_Fecha_Actualizacion" class="equipos_Fecha_Actualizacion">
<span<?php echo $equipos->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $equipos->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="x<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$equipos_grid->ListOptions->Render("body", "right", $equipos_grid->RowCnt);
?>
	</tr>
<?php if ($equipos->RowType == EW_ROWTYPE_ADD || $equipos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fequiposgrid.UpdateOpts(<?php echo $equipos_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($equipos->CurrentAction <> "gridadd" || $equipos->CurrentMode == "copy")
		if (!$equipos_grid->Recordset->EOF) $equipos_grid->Recordset->MoveNext();
}
?>
<?php
	if ($equipos->CurrentMode == "add" || $equipos->CurrentMode == "copy" || $equipos->CurrentMode == "edit") {
		$equipos_grid->RowIndex = '$rowindex$';
		$equipos_grid->LoadDefaultValues();

		// Set row properties
		$equipos->ResetAttrs();
		$equipos->RowAttrs = array_merge($equipos->RowAttrs, array('data-rowindex'=>$equipos_grid->RowIndex, 'id'=>'r0_equipos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($equipos->RowAttrs["class"], "ewTemplate");
		$equipos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$equipos_grid->RenderRow();

		// Render list options
		$equipos_grid->RenderListOptions();
		$equipos_grid->StartRowCnt = 0;
?>
	<tr<?php echo $equipos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$equipos_grid->ListOptions->Render("body", "left", $equipos_grid->RowIndex);
?>
	<?php if ($equipos->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($equipos->CurrentAction <> "F") { ?>
<?php if ($equipos->NroSerie->getSessionValue() <> "") { ?>
<span id="el$rowindex$_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_equipos_NroSerie" class="form-group equipos_NroSerie">
<input type="text" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroSerie->getPlaceHolder()) ?>" value="<?php echo $equipos->NroSerie->EditValue ?>"<?php echo $equipos->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_equipos_NroSerie" class="form-group equipos_NroSerie">
<span<?php echo $equipos->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="x<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroSerie" name="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" id="o<?php echo $equipos_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($equipos->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->NroMac->Visible) { // NroMac ?>
		<td data-name="NroMac">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_NroMac" class="form-group equipos_NroMac">
<input type="text" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_grid->RowIndex ?>_NroMac" id="x<?php echo $equipos_grid->RowIndex ?>_NroMac" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($equipos->NroMac->getPlaceHolder()) ?>" value="<?php echo $equipos->NroMac->EditValue ?>"<?php echo $equipos->NroMac->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_NroMac" class="form-group equipos_NroMac">
<span<?php echo $equipos->NroMac->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->NroMac->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="x<?php echo $equipos_grid->RowIndex ?>_NroMac" id="x<?php echo $equipos_grid->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_NroMac" name="o<?php echo $equipos_grid->RowIndex ?>_NroMac" id="o<?php echo $equipos_grid->RowIndex ?>_NroMac" value="<?php echo ew_HtmlEncode($equipos->NroMac->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ubicacion->Visible) { // Id_Ubicacion ?>
		<td data-name="Id_Ubicacion">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<select data-table="equipos" data-field="x_Id_Ubicacion" data-value-separator="<?php echo $equipos->Id_Ubicacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion"<?php echo $equipos->Id_Ubicacion->EditAttributes() ?>>
<?php echo $equipos->Id_Ubicacion->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo $equipos->Id_Ubicacion->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Ubicacion" class="form-group equipos_Id_Ubicacion">
<span<?php echo $equipos->Id_Ubicacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Ubicacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Ubicacion" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ubicacion" value="<?php echo ew_HtmlEncode($equipos->Id_Ubicacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Estado->Visible) { // Id_Estado ?>
		<td data-name="Id_Estado">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<select data-table="equipos" data-field="x_Id_Estado" data-value-separator="<?php echo $equipos->Id_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado"<?php echo $equipos->Id_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo $equipos->Id_Estado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Estado" class="form-group equipos_Id_Estado">
<span<?php echo $equipos->Id_Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Sit_Estado->Visible) { // Id_Sit_Estado ?>
		<td data-name="Id_Sit_Estado">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<select data-table="equipos" data-field="x_Id_Sit_Estado" data-value-separator="<?php echo $equipos->Id_Sit_Estado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado"<?php echo $equipos->Id_Sit_Estado->EditAttributes() ?>>
<?php echo $equipos->Id_Sit_Estado->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo $equipos->Id_Sit_Estado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Sit_Estado" class="form-group equipos_Id_Sit_Estado">
<span<?php echo $equipos->Id_Sit_Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Sit_Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Sit_Estado" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Sit_Estado" value="<?php echo ew_HtmlEncode($equipos->Id_Sit_Estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Marca->Visible) { // Id_Marca ?>
		<td data-name="Id_Marca">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<?php $equipos->Id_Marca->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$equipos->Id_Marca->EditAttrs["onchange"]; ?>
<select data-table="equipos" data-field="x_Id_Marca" data-value-separator="<?php echo $equipos->Id_Marca->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca"<?php echo $equipos->Id_Marca->EditAttributes() ?>>
<?php echo $equipos->Id_Marca->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Marca") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo $equipos->Id_Marca->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Marca" class="form-group equipos_Id_Marca">
<span<?php echo $equipos->Id_Marca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Marca->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Marca" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Marca" value="<?php echo ew_HtmlEncode($equipos->Id_Marca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Modelo->Visible) { // Id_Modelo ?>
		<td data-name="Id_Modelo">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<select data-table="equipos" data-field="x_Id_Modelo" data-value-separator="<?php echo $equipos->Id_Modelo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo"<?php echo $equipos->Id_Modelo->EditAttributes() ?>>
<?php echo $equipos->Id_Modelo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo $equipos->Id_Modelo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Modelo" class="form-group equipos_Id_Modelo">
<span<?php echo $equipos->Id_Modelo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Modelo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Modelo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Modelo" value="<?php echo ew_HtmlEncode($equipos->Id_Modelo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Ano->Visible) { // Id_Ano ?>
		<td data-name="Id_Ano">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<select data-table="equipos" data-field="x_Id_Ano" data-value-separator="<?php echo $equipos->Id_Ano->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano"<?php echo $equipos->Id_Ano->EditAttributes() ?>>
<?php echo $equipos->Id_Ano->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Ano") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo $equipos->Id_Ano->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Ano" class="form-group equipos_Id_Ano">
<span<?php echo $equipos->Id_Ano->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Ano->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Ano" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Ano" value="<?php echo ew_HtmlEncode($equipos->Id_Ano->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Id_Tipo_Equipo->Visible) { // Id_Tipo_Equipo ?>
		<td data-name="Id_Tipo_Equipo">
<?php if ($equipos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<select data-table="equipos" data-field="x_Id_Tipo_Equipo" data-value-separator="<?php echo $equipos->Id_Tipo_Equipo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo"<?php echo $equipos->Id_Tipo_Equipo->EditAttributes() ?>>
<?php echo $equipos->Id_Tipo_Equipo->SelectOptionListHtml("x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo") ?>
</select>
<input type="hidden" name="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="s_x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo $equipos->Id_Tipo_Equipo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_equipos_Id_Tipo_Equipo" class="form-group equipos_Id_Tipo_Equipo">
<span<?php echo $equipos->Id_Tipo_Equipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Id_Tipo_Equipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="x<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Id_Tipo_Equipo" name="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" id="o<?php echo $equipos_grid->RowIndex ?>_Id_Tipo_Equipo" value="<?php echo ew_HtmlEncode($equipos->Id_Tipo_Equipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($equipos->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_equipos_Usuario" class="form-group equipos_Usuario">
<span<?php echo $equipos->Usuario->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Usuario->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="x<?php echo $equipos_grid->RowIndex ?>_Usuario" id="x<?php echo $equipos_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Usuario" name="o<?php echo $equipos_grid->RowIndex ?>_Usuario" id="o<?php echo $equipos_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($equipos->Usuario->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($equipos->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($equipos->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_equipos_Fecha_Actualizacion" class="form-group equipos_Fecha_Actualizacion">
<span<?php echo $equipos->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $equipos->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="x<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="equipos" data-field="x_Fecha_Actualizacion" name="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $equipos_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($equipos->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$equipos_grid->ListOptions->Render("body", "right", $equipos_grid->RowCnt);
?>
<script type="text/javascript">
fequiposgrid.UpdateOpts(<?php echo $equipos_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($equipos->CurrentMode == "add" || $equipos->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $equipos_grid->FormKeyCountName ?>" id="<?php echo $equipos_grid->FormKeyCountName ?>" value="<?php echo $equipos_grid->KeyCount ?>">
<?php echo $equipos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($equipos->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $equipos_grid->FormKeyCountName ?>" id="<?php echo $equipos_grid->FormKeyCountName ?>" value="<?php echo $equipos_grid->KeyCount ?>">
<?php echo $equipos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($equipos->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fequiposgrid">
</div>
<?php

// Close recordset
if ($equipos_grid->Recordset)
	$equipos_grid->Recordset->Close();
?>
<?php if ($equipos_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($equipos_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($equipos_grid->TotalRecs == 0 && $equipos->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($equipos_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($equipos->Export == "") { ?>
<script type="text/javascript">
fequiposgrid.Init();
</script>
<?php } ?>
<?php
$equipos_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$equipos_grid->Page_Terminate();
?>
