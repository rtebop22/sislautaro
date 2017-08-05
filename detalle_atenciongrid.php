<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($detalle_atencion_grid)) $detalle_atencion_grid = new cdetalle_atencion_grid();

// Page init
$detalle_atencion_grid->Page_Init();

// Page main
$detalle_atencion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_atencion_grid->Page_Render();
?>
<?php if ($detalle_atencion->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdetalle_atenciongrid = new ew_Form("fdetalle_atenciongrid", "grid");
fdetalle_atenciongrid.FormKeyCountName = '<?php echo $detalle_atencion_grid->FormKeyCountName ?>';

// Validate form
fdetalle_atenciongrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Tipo_Falla");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Tipo_Falla->FldCaption(), $detalle_atencion->Id_Tipo_Falla->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Problema");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Problema->FldCaption(), $detalle_atencion->Id_Problema->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Descripcion_Problema");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Descripcion_Problema->FldCaption(), $detalle_atencion->Descripcion_Problema->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Sol_Problem");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption(), $detalle_atencion->Id_Tipo_Sol_Problem->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Estado_Atenc");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_atencion->Id_Estado_Atenc->FldCaption(), $detalle_atencion->Id_Estado_Atenc->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdetalle_atenciongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Id_Atencion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Falla", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Problema", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Descripcion_Problema", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Sol_Problem", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado_Atenc", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_atenciongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_atenciongrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_atenciongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_atenciongrid.Lists["x_Id_Tipo_Falla"] = {"LinkField":"x_Id_Tipo_Falla","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_falla"};
fdetalle_atenciongrid.Lists["x_Id_Problema"] = {"LinkField":"x_Id_Problema","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"problema"};
fdetalle_atenciongrid.Lists["x_Id_Tipo_Sol_Problem"] = {"LinkField":"x_Id_Tipo_Sol_Problem","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_solucion_problema"};
fdetalle_atenciongrid.Lists["x_Id_Estado_Atenc"] = {"LinkField":"x_Id_Estado_Atenc","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_actual_solucion_problema"};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_atencion->CurrentAction == "gridadd") {
	if ($detalle_atencion->CurrentMode == "copy") {
		$bSelectLimit = $detalle_atencion_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$detalle_atencion_grid->TotalRecs = $detalle_atencion->SelectRecordCount();
			$detalle_atencion_grid->Recordset = $detalle_atencion_grid->LoadRecordset($detalle_atencion_grid->StartRec-1, $detalle_atencion_grid->DisplayRecs);
		} else {
			if ($detalle_atencion_grid->Recordset = $detalle_atencion_grid->LoadRecordset())
				$detalle_atencion_grid->TotalRecs = $detalle_atencion_grid->Recordset->RecordCount();
		}
		$detalle_atencion_grid->StartRec = 1;
		$detalle_atencion_grid->DisplayRecs = $detalle_atencion_grid->TotalRecs;
	} else {
		$detalle_atencion->CurrentFilter = "0=1";
		$detalle_atencion_grid->StartRec = 1;
		$detalle_atencion_grid->DisplayRecs = $detalle_atencion->GridAddRowCount;
	}
	$detalle_atencion_grid->TotalRecs = $detalle_atencion_grid->DisplayRecs;
	$detalle_atencion_grid->StopRec = $detalle_atencion_grid->DisplayRecs;
} else {
	$bSelectLimit = $detalle_atencion_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($detalle_atencion_grid->TotalRecs <= 0)
			$detalle_atencion_grid->TotalRecs = $detalle_atencion->SelectRecordCount();
	} else {
		if (!$detalle_atencion_grid->Recordset && ($detalle_atencion_grid->Recordset = $detalle_atencion_grid->LoadRecordset()))
			$detalle_atencion_grid->TotalRecs = $detalle_atencion_grid->Recordset->RecordCount();
	}
	$detalle_atencion_grid->StartRec = 1;
	$detalle_atencion_grid->DisplayRecs = $detalle_atencion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_atencion_grid->Recordset = $detalle_atencion_grid->LoadRecordset($detalle_atencion_grid->StartRec-1, $detalle_atencion_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_atencion->CurrentAction == "" && $detalle_atencion_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$detalle_atencion_grid->setWarningMessage(ew_DeniedMsg());
		if ($detalle_atencion_grid->SearchWhere == "0=101")
			$detalle_atencion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_atencion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_atencion_grid->RenderOtherOptions();
?>
<?php $detalle_atencion_grid->ShowPageHeader(); ?>
<?php
$detalle_atencion_grid->ShowMessage();
?>
<?php if ($detalle_atencion_grid->TotalRecs > 0 || $detalle_atencion->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid detalle_atencion">
<div id="fdetalle_atenciongrid" class="ewForm form-inline">
<?php if ($detalle_atencion_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($detalle_atencion_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_detalle_atencion" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_atenciongrid" class="table ewTable">
<?php echo $detalle_atencion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$detalle_atencion_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$detalle_atencion_grid->RenderListOptions();

// Render list options (header, left)
$detalle_atencion_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_atencion->Id_Atencion->Visible) { // Id_Atencion ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Id_Atencion) == "") { ?>
		<th data-name="Id_Atencion"><div id="elh_detalle_atencion_Id_Atencion" class="detalle_atencion_Id_Atencion"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Atencion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Atencion"><div><div id="elh_detalle_atencion_Id_Atencion" class="detalle_atencion_Id_Atencion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Atencion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Id_Atencion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Id_Atencion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->NroSerie->Visible) { // NroSerie ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_detalle_atencion_NroSerie" class="detalle_atencion_NroSerie"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div><div id="elh_detalle_atencion_NroSerie" class="detalle_atencion_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->NroSerie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Id_Tipo_Falla) == "") { ?>
		<th data-name="Id_Tipo_Falla"><div id="elh_detalle_atencion_Id_Tipo_Falla" class="detalle_atencion_Id_Tipo_Falla"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Tipo_Falla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Falla"><div><div id="elh_detalle_atencion_Id_Tipo_Falla" class="detalle_atencion_Id_Tipo_Falla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Tipo_Falla->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Id_Tipo_Falla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Id_Tipo_Falla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Id_Problema) == "") { ?>
		<th data-name="Id_Problema"><div id="elh_detalle_atencion_Id_Problema" class="detalle_atencion_Id_Problema"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Problema->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Problema"><div><div id="elh_detalle_atencion_Id_Problema" class="detalle_atencion_Id_Problema">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Problema->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Id_Problema->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Id_Problema->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Descripcion_Problema) == "") { ?>
		<th data-name="Descripcion_Problema"><div id="elh_detalle_atencion_Descripcion_Problema" class="detalle_atencion_Descripcion_Problema"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Descripcion_Problema->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Descripcion_Problema"><div><div id="elh_detalle_atencion_Descripcion_Problema" class="detalle_atencion_Descripcion_Problema">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Descripcion_Problema->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Descripcion_Problema->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Descripcion_Problema->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Id_Tipo_Sol_Problem) == "") { ?>
		<th data-name="Id_Tipo_Sol_Problem"><div id="elh_detalle_atencion_Id_Tipo_Sol_Problem" class="detalle_atencion_Id_Tipo_Sol_Problem"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Sol_Problem"><div><div id="elh_detalle_atencion_Id_Tipo_Sol_Problem" class="detalle_atencion_Id_Tipo_Sol_Problem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Id_Tipo_Sol_Problem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Id_Tipo_Sol_Problem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Id_Estado_Atenc) == "") { ?>
		<th data-name="Id_Estado_Atenc"><div id="elh_detalle_atencion_Id_Estado_Atenc" class="detalle_atencion_Id_Estado_Atenc"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Estado_Atenc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Estado_Atenc"><div><div id="elh_detalle_atencion_Id_Estado_Atenc" class="detalle_atencion_Id_Estado_Atenc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Id_Estado_Atenc->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Id_Estado_Atenc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Id_Estado_Atenc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($detalle_atencion->SortUrl($detalle_atencion->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_detalle_atencion_Fecha_Actualizacion" class="detalle_atencion_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $detalle_atencion->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_detalle_atencion_Fecha_Actualizacion" class="detalle_atencion_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_atencion->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_atencion->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_atencion->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_atencion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_atencion_grid->StartRec = 1;
$detalle_atencion_grid->StopRec = $detalle_atencion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_atencion_grid->FormKeyCountName) && ($detalle_atencion->CurrentAction == "gridadd" || $detalle_atencion->CurrentAction == "gridedit" || $detalle_atencion->CurrentAction == "F")) {
		$detalle_atencion_grid->KeyCount = $objForm->GetValue($detalle_atencion_grid->FormKeyCountName);
		$detalle_atencion_grid->StopRec = $detalle_atencion_grid->StartRec + $detalle_atencion_grid->KeyCount - 1;
	}
}
$detalle_atencion_grid->RecCnt = $detalle_atencion_grid->StartRec - 1;
if ($detalle_atencion_grid->Recordset && !$detalle_atencion_grid->Recordset->EOF) {
	$detalle_atencion_grid->Recordset->MoveFirst();
	$bSelectLimit = $detalle_atencion_grid->UseSelectLimit;
	if (!$bSelectLimit && $detalle_atencion_grid->StartRec > 1)
		$detalle_atencion_grid->Recordset->Move($detalle_atencion_grid->StartRec - 1);
} elseif (!$detalle_atencion->AllowAddDeleteRow && $detalle_atencion_grid->StopRec == 0) {
	$detalle_atencion_grid->StopRec = $detalle_atencion->GridAddRowCount;
}

// Initialize aggregate
$detalle_atencion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_atencion->ResetAttrs();
$detalle_atencion_grid->RenderRow();
if ($detalle_atencion->CurrentAction == "gridadd")
	$detalle_atencion_grid->RowIndex = 0;
if ($detalle_atencion->CurrentAction == "gridedit")
	$detalle_atencion_grid->RowIndex = 0;
while ($detalle_atencion_grid->RecCnt < $detalle_atencion_grid->StopRec) {
	$detalle_atencion_grid->RecCnt++;
	if (intval($detalle_atencion_grid->RecCnt) >= intval($detalle_atencion_grid->StartRec)) {
		$detalle_atencion_grid->RowCnt++;
		if ($detalle_atencion->CurrentAction == "gridadd" || $detalle_atencion->CurrentAction == "gridedit" || $detalle_atencion->CurrentAction == "F") {
			$detalle_atencion_grid->RowIndex++;
			$objForm->Index = $detalle_atencion_grid->RowIndex;
			if ($objForm->HasValue($detalle_atencion_grid->FormActionName))
				$detalle_atencion_grid->RowAction = strval($objForm->GetValue($detalle_atencion_grid->FormActionName));
			elseif ($detalle_atencion->CurrentAction == "gridadd")
				$detalle_atencion_grid->RowAction = "insert";
			else
				$detalle_atencion_grid->RowAction = "";
		}

		// Set up key count
		$detalle_atencion_grid->KeyCount = $detalle_atencion_grid->RowIndex;

		// Init row class and style
		$detalle_atencion->ResetAttrs();
		$detalle_atencion->CssClass = "";
		if ($detalle_atencion->CurrentAction == "gridadd") {
			if ($detalle_atencion->CurrentMode == "copy") {
				$detalle_atencion_grid->LoadRowValues($detalle_atencion_grid->Recordset); // Load row values
				$detalle_atencion_grid->SetRecordKey($detalle_atencion_grid->RowOldKey, $detalle_atencion_grid->Recordset); // Set old record key
			} else {
				$detalle_atencion_grid->LoadDefaultValues(); // Load default values
				$detalle_atencion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_atencion_grid->LoadRowValues($detalle_atencion_grid->Recordset); // Load row values
		}
		$detalle_atencion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_atencion->CurrentAction == "gridadd") // Grid add
			$detalle_atencion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_atencion->CurrentAction == "gridadd" && $detalle_atencion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_atencion_grid->RestoreCurrentRowFormValues($detalle_atencion_grid->RowIndex); // Restore form values
		if ($detalle_atencion->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_atencion->EventCancelled) {
				$detalle_atencion_grid->RestoreCurrentRowFormValues($detalle_atencion_grid->RowIndex); // Restore form values
			}
			if ($detalle_atencion_grid->RowAction == "insert")
				$detalle_atencion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_atencion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_atencion->CurrentAction == "gridedit" && ($detalle_atencion->RowType == EW_ROWTYPE_EDIT || $detalle_atencion->RowType == EW_ROWTYPE_ADD) && $detalle_atencion->EventCancelled) // Update failed
			$detalle_atencion_grid->RestoreCurrentRowFormValues($detalle_atencion_grid->RowIndex); // Restore form values
		if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_atencion_grid->EditRowCnt++;
		if ($detalle_atencion->CurrentAction == "F") // Confirm row
			$detalle_atencion_grid->RestoreCurrentRowFormValues($detalle_atencion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_atencion->RowAttrs = array_merge($detalle_atencion->RowAttrs, array('data-rowindex'=>$detalle_atencion_grid->RowCnt, 'id'=>'r' . $detalle_atencion_grid->RowCnt . '_detalle_atencion', 'data-rowtype'=>$detalle_atencion->RowType));

		// Render row
		$detalle_atencion_grid->RenderRow();

		// Render list options
		$detalle_atencion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_atencion_grid->RowAction <> "delete" && $detalle_atencion_grid->RowAction <> "insertdelete" && !($detalle_atencion_grid->RowAction == "insert" && $detalle_atencion->CurrentAction == "F" && $detalle_atencion_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_atencion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_atencion_grid->ListOptions->Render("body", "left", $detalle_atencion_grid->RowCnt);
?>
	<?php if ($detalle_atencion->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion"<?php echo $detalle_atencion->Id_Atencion->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_atencion->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Atencion" class="form-group detalle_atencion_Id_Atencion">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_atencion->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Atencion" class="form-group detalle_atencion_Id_Atencion">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Atencion" class="detalle_atencion_Id_Atencion">
<span<?php echo $detalle_atencion->Id_Atencion->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Atencion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_atencion_grid->PageObjName . "_row_" . $detalle_atencion_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Detalle_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Detalle_Atencion->CurrentValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Detalle_Atencion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Detalle_Atencion->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT || $detalle_atencion->CurrentMode == "edit") { ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Detalle_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Detalle_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Detalle_Atencion->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_atencion->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $detalle_atencion->NroSerie->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_atencion->NroSerie->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_NroSerie" class="form-group detalle_atencion_NroSerie">
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_atencion->NroSerie->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_NroSerie" class="form-group detalle_atencion_NroSerie">
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_NroSerie" class="detalle_atencion_NroSerie">
<span<?php echo $detalle_atencion->NroSerie->ViewAttributes() ?>>
<?php echo $detalle_atencion->NroSerie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
		<td data-name="Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Falla" class="form-group detalle_atencion_Id_Tipo_Falla">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Falla->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo $detalle_atencion->Id_Tipo_Falla->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Falla->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Falla" class="form-group detalle_atencion_Id_Tipo_Falla">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Falla->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo $detalle_atencion->Id_Tipo_Falla->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Falla" class="detalle_atencion_Id_Tipo_Falla">
<span<?php echo $detalle_atencion->Id_Tipo_Falla->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Falla->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Falla->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
		<td data-name="Id_Problema"<?php echo $detalle_atencion->Id_Problema->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Problema" class="form-group detalle_atencion_Id_Problema">
<select data-table="detalle_atencion" data-field="x_Id_Problema" data-value-separator="<?php echo $detalle_atencion->Id_Problema->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema"<?php echo $detalle_atencion->Id_Problema->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo $detalle_atencion->Id_Problema->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Problema->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Problema" class="form-group detalle_atencion_Id_Problema">
<select data-table="detalle_atencion" data-field="x_Id_Problema" data-value-separator="<?php echo $detalle_atencion->Id_Problema->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema"<?php echo $detalle_atencion->Id_Problema->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo $detalle_atencion->Id_Problema->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Problema" class="detalle_atencion_Id_Problema">
<span<?php echo $detalle_atencion->Id_Problema->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Problema->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Problema->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
		<td data-name="Descripcion_Problema"<?php echo $detalle_atencion->Descripcion_Problema->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Descripcion_Problema" class="form-group detalle_atencion_Descripcion_Problema">
<input type="text" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" maxlength="400" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Descripcion_Problema->EditValue ?>"<?php echo $detalle_atencion->Descripcion_Problema->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Descripcion_Problema" class="form-group detalle_atencion_Descripcion_Problema">
<input type="text" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" maxlength="400" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Descripcion_Problema->EditValue ?>"<?php echo $detalle_atencion->Descripcion_Problema->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Descripcion_Problema" class="detalle_atencion_Descripcion_Problema">
<span<?php echo $detalle_atencion->Descripcion_Problema->ViewAttributes() ?>>
<?php echo $detalle_atencion->Descripcion_Problema->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
		<td data-name="Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Sol_Problem" class="form-group detalle_atencion_Id_Tipo_Sol_Problem">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Sol_Problem->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Sol_Problem" class="form-group detalle_atencion_Id_Tipo_Sol_Problem">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Tipo_Sol_Problem" class="detalle_atencion_Id_Tipo_Sol_Problem">
<span<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Sol_Problem->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Sol_Problem->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
		<td data-name="Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Estado_Atenc" class="form-group detalle_atencion_Id_Estado_Atenc">
<select data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" data-value-separator="<?php echo $detalle_atencion->Id_Estado_Atenc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo $detalle_atencion->Id_Estado_Atenc->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Estado_Atenc->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Estado_Atenc" class="form-group detalle_atencion_Id_Estado_Atenc">
<select data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" data-value-separator="<?php echo $detalle_atencion->Id_Estado_Atenc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo $detalle_atencion->Id_Estado_Atenc->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Id_Estado_Atenc" class="detalle_atencion_Id_Estado_Atenc">
<span<?php echo $detalle_atencion->Id_Estado_Atenc->ViewAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Estado_Atenc->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Estado_Atenc->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $detalle_atencion->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detalle_atencion_grid->RowCnt ?>_detalle_atencion_Fecha_Actualizacion" class="detalle_atencion_Fecha_Actualizacion">
<span<?php echo $detalle_atencion->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $detalle_atencion->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_atencion_grid->ListOptions->Render("body", "right", $detalle_atencion_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_atencion->RowType == EW_ROWTYPE_ADD || $detalle_atencion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_atenciongrid.UpdateOpts(<?php echo $detalle_atencion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_atencion->CurrentAction <> "gridadd" || $detalle_atencion->CurrentMode == "copy")
		if (!$detalle_atencion_grid->Recordset->EOF) $detalle_atencion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_atencion->CurrentMode == "add" || $detalle_atencion->CurrentMode == "copy" || $detalle_atencion->CurrentMode == "edit") {
		$detalle_atencion_grid->RowIndex = '$rowindex$';
		$detalle_atencion_grid->LoadDefaultValues();

		// Set row properties
		$detalle_atencion->ResetAttrs();
		$detalle_atencion->RowAttrs = array_merge($detalle_atencion->RowAttrs, array('data-rowindex'=>$detalle_atencion_grid->RowIndex, 'id'=>'r0_detalle_atencion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_atencion->RowAttrs["class"], "ewTemplate");
		$detalle_atencion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_atencion_grid->RenderRow();

		// Render list options
		$detalle_atencion_grid->RenderListOptions();
		$detalle_atencion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_atencion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_atencion_grid->ListOptions->Render("body", "left", $detalle_atencion_grid->RowIndex);
?>
	<?php if ($detalle_atencion->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<?php if ($detalle_atencion->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Id_Atencion" class="form-group detalle_atencion_Id_Atencion">
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<?php } else { ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Atencion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Atencion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<?php if ($detalle_atencion->NroSerie->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_NroSerie" class="form-group detalle_atencion_NroSerie">
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->CurrentValue) ?>">
</span>
<?php } ?>
<?php } else { ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_NroSerie" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($detalle_atencion->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Tipo_Falla->Visible) { // Id_Tipo_Falla ?>
		<td data-name="Id_Tipo_Falla">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_atencion_Id_Tipo_Falla" class="form-group detalle_atencion_Id_Tipo_Falla">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Falla->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla"<?php echo $detalle_atencion->Id_Tipo_Falla->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Falla->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo $detalle_atencion->Id_Tipo_Falla->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Id_Tipo_Falla" class="form-group detalle_atencion_Id_Tipo_Falla">
<span<?php echo $detalle_atencion->Id_Tipo_Falla->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Id_Tipo_Falla->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Falla->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Falla" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Falla" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Falla->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Problema->Visible) { // Id_Problema ?>
		<td data-name="Id_Problema">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_atencion_Id_Problema" class="form-group detalle_atencion_Id_Problema">
<select data-table="detalle_atencion" data-field="x_Id_Problema" data-value-separator="<?php echo $detalle_atencion->Id_Problema->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema"<?php echo $detalle_atencion->Id_Problema->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Problema->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo $detalle_atencion->Id_Problema->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Id_Problema" class="form-group detalle_atencion_Id_Problema">
<span<?php echo $detalle_atencion->Id_Problema->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Id_Problema->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Problema->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Problema->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Descripcion_Problema->Visible) { // Descripcion_Problema ?>
		<td data-name="Descripcion_Problema">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_atencion_Descripcion_Problema" class="form-group detalle_atencion_Descripcion_Problema">
<input type="text" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" maxlength="400" placeholder="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->getPlaceHolder()) ?>" value="<?php echo $detalle_atencion->Descripcion_Problema->EditValue ?>"<?php echo $detalle_atencion->Descripcion_Problema->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Descripcion_Problema" class="form-group detalle_atencion_Descripcion_Problema">
<span<?php echo $detalle_atencion->Descripcion_Problema->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Descripcion_Problema->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Descripcion_Problema" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Descripcion_Problema" value="<?php echo ew_HtmlEncode($detalle_atencion->Descripcion_Problema->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Tipo_Sol_Problem->Visible) { // Id_Tipo_Sol_Problem ?>
		<td data-name="Id_Tipo_Sol_Problem">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_atencion_Id_Tipo_Sol_Problem" class="form-group detalle_atencion_Id_Tipo_Sol_Problem">
<select data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" data-value-separator="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem"<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Id_Tipo_Sol_Problem" class="form-group detalle_atencion_Id_Tipo_Sol_Problem">
<span<?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Id_Tipo_Sol_Problem->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Sol_Problem->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Tipo_Sol_Problem" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Tipo_Sol_Problem" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Tipo_Sol_Problem->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Id_Estado_Atenc->Visible) { // Id_Estado_Atenc ?>
		<td data-name="Id_Estado_Atenc">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_atencion_Id_Estado_Atenc" class="form-group detalle_atencion_Id_Estado_Atenc">
<select data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" data-value-separator="<?php echo $detalle_atencion->Id_Estado_Atenc->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc"<?php echo $detalle_atencion->Id_Estado_Atenc->EditAttributes() ?>>
<?php echo $detalle_atencion->Id_Estado_Atenc->SelectOptionListHtml("x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc") ?>
</select>
<input type="hidden" name="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="s_x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo $detalle_atencion->Id_Estado_Atenc->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Id_Estado_Atenc" class="form-group detalle_atencion_Id_Estado_Atenc">
<span<?php echo $detalle_atencion->Id_Estado_Atenc->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Id_Estado_Atenc->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Estado_Atenc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Id_Estado_Atenc" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Id_Estado_Atenc" value="<?php echo ew_HtmlEncode($detalle_atencion->Id_Estado_Atenc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($detalle_atencion->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_atencion_Fecha_Actualizacion" class="form-group detalle_atencion_Fecha_Actualizacion">
<span<?php echo $detalle_atencion->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_atencion->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="x<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detalle_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $detalle_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($detalle_atencion->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_atencion_grid->ListOptions->Render("body", "right", $detalle_atencion_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_atenciongrid.UpdateOpts(<?php echo $detalle_atencion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_atencion->CurrentMode == "add" || $detalle_atencion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_atencion_grid->FormKeyCountName ?>" id="<?php echo $detalle_atencion_grid->FormKeyCountName ?>" value="<?php echo $detalle_atencion_grid->KeyCount ?>">
<?php echo $detalle_atencion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_atencion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_atencion_grid->FormKeyCountName ?>" id="<?php echo $detalle_atencion_grid->FormKeyCountName ?>" value="<?php echo $detalle_atencion_grid->KeyCount ?>">
<?php echo $detalle_atencion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_atencion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_atenciongrid">
</div>
<?php

// Close recordset
if ($detalle_atencion_grid->Recordset)
	$detalle_atencion_grid->Recordset->Close();
?>
<?php if ($detalle_atencion_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($detalle_atencion_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_atencion_grid->TotalRecs == 0 && $detalle_atencion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_atencion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_atencion->Export == "") { ?>
<script type="text/javascript">
fdetalle_atenciongrid.Init();
</script>
<?php } ?>
<?php
$detalle_atencion_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_atencion_grid->Page_Terminate();
?>
