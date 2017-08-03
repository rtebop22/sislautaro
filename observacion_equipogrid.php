<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($observacion_equipo_grid)) $observacion_equipo_grid = new cobservacion_equipo_grid();

// Page init
$observacion_equipo_grid->Page_Init();

// Page main
$observacion_equipo_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$observacion_equipo_grid->Page_Render();
?>
<?php if ($observacion_equipo->Export == "") { ?>
<script type="text/javascript">

// Form object
var fobservacion_equipogrid = new ew_Form("fobservacion_equipogrid", "grid");
fobservacion_equipogrid.FormKeyCountName = '<?php echo $observacion_equipo_grid->FormKeyCountName ?>';

// Validate form
fobservacion_equipogrid.Validate = function() {
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

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fobservacion_equipogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Detalle", false)) return false;
	return true;
}

// Form_CustomValidate event
fobservacion_equipogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fobservacion_equipogrid.ValidateRequired = true;
<?php } else { ?>
fobservacion_equipogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($observacion_equipo->CurrentAction == "gridadd") {
	if ($observacion_equipo->CurrentMode == "copy") {
		$bSelectLimit = $observacion_equipo_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$observacion_equipo_grid->TotalRecs = $observacion_equipo->SelectRecordCount();
			$observacion_equipo_grid->Recordset = $observacion_equipo_grid->LoadRecordset($observacion_equipo_grid->StartRec-1, $observacion_equipo_grid->DisplayRecs);
		} else {
			if ($observacion_equipo_grid->Recordset = $observacion_equipo_grid->LoadRecordset())
				$observacion_equipo_grid->TotalRecs = $observacion_equipo_grid->Recordset->RecordCount();
		}
		$observacion_equipo_grid->StartRec = 1;
		$observacion_equipo_grid->DisplayRecs = $observacion_equipo_grid->TotalRecs;
	} else {
		$observacion_equipo->CurrentFilter = "0=1";
		$observacion_equipo_grid->StartRec = 1;
		$observacion_equipo_grid->DisplayRecs = $observacion_equipo->GridAddRowCount;
	}
	$observacion_equipo_grid->TotalRecs = $observacion_equipo_grid->DisplayRecs;
	$observacion_equipo_grid->StopRec = $observacion_equipo_grid->DisplayRecs;
} else {
	$bSelectLimit = $observacion_equipo_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($observacion_equipo_grid->TotalRecs <= 0)
			$observacion_equipo_grid->TotalRecs = $observacion_equipo->SelectRecordCount();
	} else {
		if (!$observacion_equipo_grid->Recordset && ($observacion_equipo_grid->Recordset = $observacion_equipo_grid->LoadRecordset()))
			$observacion_equipo_grid->TotalRecs = $observacion_equipo_grid->Recordset->RecordCount();
	}
	$observacion_equipo_grid->StartRec = 1;
	$observacion_equipo_grid->DisplayRecs = $observacion_equipo_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$observacion_equipo_grid->Recordset = $observacion_equipo_grid->LoadRecordset($observacion_equipo_grid->StartRec-1, $observacion_equipo_grid->DisplayRecs);

	// Set no record found message
	if ($observacion_equipo->CurrentAction == "" && $observacion_equipo_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$observacion_equipo_grid->setWarningMessage(ew_DeniedMsg());
		if ($observacion_equipo_grid->SearchWhere == "0=101")
			$observacion_equipo_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$observacion_equipo_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$observacion_equipo_grid->RenderOtherOptions();
?>
<?php $observacion_equipo_grid->ShowPageHeader(); ?>
<?php
$observacion_equipo_grid->ShowMessage();
?>
<?php if ($observacion_equipo_grid->TotalRecs > 0 || $observacion_equipo->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid observacion_equipo">
<div id="fobservacion_equipogrid" class="ewForm form-inline">
<?php if ($observacion_equipo_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($observacion_equipo_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_observacion_equipo" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_observacion_equipogrid" class="table ewTable">
<?php echo $observacion_equipo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$observacion_equipo_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$observacion_equipo_grid->RenderListOptions();

// Render list options (header, left)
$observacion_equipo_grid->ListOptions->Render("header", "left");
?>
<?php if ($observacion_equipo->Detalle->Visible) { // Detalle ?>
	<?php if ($observacion_equipo->SortUrl($observacion_equipo->Detalle) == "") { ?>
		<th data-name="Detalle"><div id="elh_observacion_equipo_Detalle" class="observacion_equipo_Detalle"><div class="ewTableHeaderCaption"><?php echo $observacion_equipo->Detalle->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Detalle"><div><div id="elh_observacion_equipo_Detalle" class="observacion_equipo_Detalle">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_equipo->Detalle->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_equipo->Detalle->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_equipo->Detalle->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($observacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($observacion_equipo->SortUrl($observacion_equipo->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_observacion_equipo_Fecha_Actualizacion" class="observacion_equipo_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $observacion_equipo->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_observacion_equipo_Fecha_Actualizacion" class="observacion_equipo_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_equipo->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_equipo->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_equipo->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$observacion_equipo_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$observacion_equipo_grid->StartRec = 1;
$observacion_equipo_grid->StopRec = $observacion_equipo_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($observacion_equipo_grid->FormKeyCountName) && ($observacion_equipo->CurrentAction == "gridadd" || $observacion_equipo->CurrentAction == "gridedit" || $observacion_equipo->CurrentAction == "F")) {
		$observacion_equipo_grid->KeyCount = $objForm->GetValue($observacion_equipo_grid->FormKeyCountName);
		$observacion_equipo_grid->StopRec = $observacion_equipo_grid->StartRec + $observacion_equipo_grid->KeyCount - 1;
	}
}
$observacion_equipo_grid->RecCnt = $observacion_equipo_grid->StartRec - 1;
if ($observacion_equipo_grid->Recordset && !$observacion_equipo_grid->Recordset->EOF) {
	$observacion_equipo_grid->Recordset->MoveFirst();
	$bSelectLimit = $observacion_equipo_grid->UseSelectLimit;
	if (!$bSelectLimit && $observacion_equipo_grid->StartRec > 1)
		$observacion_equipo_grid->Recordset->Move($observacion_equipo_grid->StartRec - 1);
} elseif (!$observacion_equipo->AllowAddDeleteRow && $observacion_equipo_grid->StopRec == 0) {
	$observacion_equipo_grid->StopRec = $observacion_equipo->GridAddRowCount;
}

// Initialize aggregate
$observacion_equipo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$observacion_equipo->ResetAttrs();
$observacion_equipo_grid->RenderRow();
if ($observacion_equipo->CurrentAction == "gridadd")
	$observacion_equipo_grid->RowIndex = 0;
if ($observacion_equipo->CurrentAction == "gridedit")
	$observacion_equipo_grid->RowIndex = 0;
while ($observacion_equipo_grid->RecCnt < $observacion_equipo_grid->StopRec) {
	$observacion_equipo_grid->RecCnt++;
	if (intval($observacion_equipo_grid->RecCnt) >= intval($observacion_equipo_grid->StartRec)) {
		$observacion_equipo_grid->RowCnt++;
		if ($observacion_equipo->CurrentAction == "gridadd" || $observacion_equipo->CurrentAction == "gridedit" || $observacion_equipo->CurrentAction == "F") {
			$observacion_equipo_grid->RowIndex++;
			$objForm->Index = $observacion_equipo_grid->RowIndex;
			if ($objForm->HasValue($observacion_equipo_grid->FormActionName))
				$observacion_equipo_grid->RowAction = strval($objForm->GetValue($observacion_equipo_grid->FormActionName));
			elseif ($observacion_equipo->CurrentAction == "gridadd")
				$observacion_equipo_grid->RowAction = "insert";
			else
				$observacion_equipo_grid->RowAction = "";
		}

		// Set up key count
		$observacion_equipo_grid->KeyCount = $observacion_equipo_grid->RowIndex;

		// Init row class and style
		$observacion_equipo->ResetAttrs();
		$observacion_equipo->CssClass = "";
		if ($observacion_equipo->CurrentAction == "gridadd") {
			if ($observacion_equipo->CurrentMode == "copy") {
				$observacion_equipo_grid->LoadRowValues($observacion_equipo_grid->Recordset); // Load row values
				$observacion_equipo_grid->SetRecordKey($observacion_equipo_grid->RowOldKey, $observacion_equipo_grid->Recordset); // Set old record key
			} else {
				$observacion_equipo_grid->LoadDefaultValues(); // Load default values
				$observacion_equipo_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$observacion_equipo_grid->LoadRowValues($observacion_equipo_grid->Recordset); // Load row values
		}
		$observacion_equipo->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($observacion_equipo->CurrentAction == "gridadd") // Grid add
			$observacion_equipo->RowType = EW_ROWTYPE_ADD; // Render add
		if ($observacion_equipo->CurrentAction == "gridadd" && $observacion_equipo->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$observacion_equipo_grid->RestoreCurrentRowFormValues($observacion_equipo_grid->RowIndex); // Restore form values
		if ($observacion_equipo->CurrentAction == "gridedit") { // Grid edit
			if ($observacion_equipo->EventCancelled) {
				$observacion_equipo_grid->RestoreCurrentRowFormValues($observacion_equipo_grid->RowIndex); // Restore form values
			}
			if ($observacion_equipo_grid->RowAction == "insert")
				$observacion_equipo->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$observacion_equipo->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($observacion_equipo->CurrentAction == "gridedit" && ($observacion_equipo->RowType == EW_ROWTYPE_EDIT || $observacion_equipo->RowType == EW_ROWTYPE_ADD) && $observacion_equipo->EventCancelled) // Update failed
			$observacion_equipo_grid->RestoreCurrentRowFormValues($observacion_equipo_grid->RowIndex); // Restore form values
		if ($observacion_equipo->RowType == EW_ROWTYPE_EDIT) // Edit row
			$observacion_equipo_grid->EditRowCnt++;
		if ($observacion_equipo->CurrentAction == "F") // Confirm row
			$observacion_equipo_grid->RestoreCurrentRowFormValues($observacion_equipo_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$observacion_equipo->RowAttrs = array_merge($observacion_equipo->RowAttrs, array('data-rowindex'=>$observacion_equipo_grid->RowCnt, 'id'=>'r' . $observacion_equipo_grid->RowCnt . '_observacion_equipo', 'data-rowtype'=>$observacion_equipo->RowType));

		// Render row
		$observacion_equipo_grid->RenderRow();

		// Render list options
		$observacion_equipo_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($observacion_equipo_grid->RowAction <> "delete" && $observacion_equipo_grid->RowAction <> "insertdelete" && !($observacion_equipo_grid->RowAction == "insert" && $observacion_equipo->CurrentAction == "F" && $observacion_equipo_grid->EmptyRow())) {
?>
	<tr<?php echo $observacion_equipo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_equipo_grid->ListOptions->Render("body", "left", $observacion_equipo_grid->RowCnt);
?>
	<?php if ($observacion_equipo->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle"<?php echo $observacion_equipo->Detalle->CellAttributes() ?>>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $observacion_equipo_grid->RowCnt ?>_observacion_equipo_Detalle" class="form-group observacion_equipo_Detalle">
<input type="text" data-table="observacion_equipo" data-field="x_Detalle" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_equipo->Detalle->EditValue ?>"<?php echo $observacion_equipo->Detalle->EditAttributes() ?>>
</span>
<input type="hidden" data-table="observacion_equipo" data-field="x_Detalle" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->OldValue) ?>">
<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $observacion_equipo_grid->RowCnt ?>_observacion_equipo_Detalle" class="form-group observacion_equipo_Detalle">
<input type="text" data-table="observacion_equipo" data-field="x_Detalle" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_equipo->Detalle->EditValue ?>"<?php echo $observacion_equipo->Detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_equipo_grid->RowCnt ?>_observacion_equipo_Detalle" class="observacion_equipo_Detalle">
<span<?php echo $observacion_equipo->Detalle->ViewAttributes() ?>>
<?php echo $observacion_equipo->Detalle->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_equipo" data-field="x_Detalle" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->FormValue) ?>">
<input type="hidden" data-table="observacion_equipo" data-field="x_Detalle" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->OldValue) ?>">
<?php } ?>
<a id="<?php echo $observacion_equipo_grid->PageObjName . "_row_" . $observacion_equipo_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Id_Observacion" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Id_Observacion->CurrentValue) ?>">
<input type="hidden" data-table="observacion_equipo" data-field="x_Id_Observacion" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Id_Observacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_EDIT || $observacion_equipo->CurrentMode == "edit") { ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Id_Observacion" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Id_Observacion->CurrentValue) ?>">
<?php } ?>
	<?php if ($observacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $observacion_equipo->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_equipo_grid->RowCnt ?>_observacion_equipo_Fecha_Actualizacion" class="observacion_equipo_Fecha_Actualizacion">
<span<?php echo $observacion_equipo->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $observacion_equipo->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_equipo" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="observacion_equipo" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_equipo_grid->ListOptions->Render("body", "right", $observacion_equipo_grid->RowCnt);
?>
	</tr>
<?php if ($observacion_equipo->RowType == EW_ROWTYPE_ADD || $observacion_equipo->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fobservacion_equipogrid.UpdateOpts(<?php echo $observacion_equipo_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($observacion_equipo->CurrentAction <> "gridadd" || $observacion_equipo->CurrentMode == "copy")
		if (!$observacion_equipo_grid->Recordset->EOF) $observacion_equipo_grid->Recordset->MoveNext();
}
?>
<?php
	if ($observacion_equipo->CurrentMode == "add" || $observacion_equipo->CurrentMode == "copy" || $observacion_equipo->CurrentMode == "edit") {
		$observacion_equipo_grid->RowIndex = '$rowindex$';
		$observacion_equipo_grid->LoadDefaultValues();

		// Set row properties
		$observacion_equipo->ResetAttrs();
		$observacion_equipo->RowAttrs = array_merge($observacion_equipo->RowAttrs, array('data-rowindex'=>$observacion_equipo_grid->RowIndex, 'id'=>'r0_observacion_equipo', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($observacion_equipo->RowAttrs["class"], "ewTemplate");
		$observacion_equipo->RowType = EW_ROWTYPE_ADD;

		// Render row
		$observacion_equipo_grid->RenderRow();

		// Render list options
		$observacion_equipo_grid->RenderListOptions();
		$observacion_equipo_grid->StartRowCnt = 0;
?>
	<tr<?php echo $observacion_equipo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_equipo_grid->ListOptions->Render("body", "left", $observacion_equipo_grid->RowIndex);
?>
	<?php if ($observacion_equipo->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle">
<?php if ($observacion_equipo->CurrentAction <> "F") { ?>
<span id="el$rowindex$_observacion_equipo_Detalle" class="form-group observacion_equipo_Detalle">
<input type="text" data-table="observacion_equipo" data-field="x_Detalle" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_equipo->Detalle->EditValue ?>"<?php echo $observacion_equipo->Detalle->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_observacion_equipo_Detalle" class="form-group observacion_equipo_Detalle">
<span<?php echo $observacion_equipo->Detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $observacion_equipo->Detalle->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="observacion_equipo" data-field="x_Detalle" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Detalle" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_equipo->Detalle->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($observacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($observacion_equipo->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_equipo" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_equipo_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_equipo->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_equipo_grid->ListOptions->Render("body", "right", $observacion_equipo_grid->RowCnt);
?>
<script type="text/javascript">
fobservacion_equipogrid.UpdateOpts(<?php echo $observacion_equipo_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($observacion_equipo->CurrentMode == "add" || $observacion_equipo->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $observacion_equipo_grid->FormKeyCountName ?>" id="<?php echo $observacion_equipo_grid->FormKeyCountName ?>" value="<?php echo $observacion_equipo_grid->KeyCount ?>">
<?php echo $observacion_equipo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_equipo->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $observacion_equipo_grid->FormKeyCountName ?>" id="<?php echo $observacion_equipo_grid->FormKeyCountName ?>" value="<?php echo $observacion_equipo_grid->KeyCount ?>">
<?php echo $observacion_equipo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_equipo->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fobservacion_equipogrid">
</div>
<?php

// Close recordset
if ($observacion_equipo_grid->Recordset)
	$observacion_equipo_grid->Recordset->Close();
?>
<?php if ($observacion_equipo_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($observacion_equipo_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($observacion_equipo_grid->TotalRecs == 0 && $observacion_equipo->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($observacion_equipo_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($observacion_equipo->Export == "") { ?>
<script type="text/javascript">
fobservacion_equipogrid.Init();
</script>
<?php } ?>
<?php
$observacion_equipo_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$observacion_equipo_grid->Page_Terminate();
?>
