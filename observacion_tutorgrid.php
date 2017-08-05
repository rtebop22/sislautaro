<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($observacion_tutor_grid)) $observacion_tutor_grid = new cobservacion_tutor_grid();

// Page init
$observacion_tutor_grid->Page_Init();

// Page main
$observacion_tutor_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$observacion_tutor_grid->Page_Render();
?>
<?php if ($observacion_tutor->Export == "") { ?>
<script type="text/javascript">

// Form object
var fobservacion_tutorgrid = new ew_Form("fobservacion_tutorgrid", "grid");
fobservacion_tutorgrid.FormKeyCountName = '<?php echo $observacion_tutor_grid->FormKeyCountName ?>';

// Validate form
fobservacion_tutorgrid.Validate = function() {
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
fobservacion_tutorgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Detalle", false)) return false;
	return true;
}

// Form_CustomValidate event
fobservacion_tutorgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fobservacion_tutorgrid.ValidateRequired = true;
<?php } else { ?>
fobservacion_tutorgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($observacion_tutor->CurrentAction == "gridadd") {
	if ($observacion_tutor->CurrentMode == "copy") {
		$bSelectLimit = $observacion_tutor_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$observacion_tutor_grid->TotalRecs = $observacion_tutor->SelectRecordCount();
			$observacion_tutor_grid->Recordset = $observacion_tutor_grid->LoadRecordset($observacion_tutor_grid->StartRec-1, $observacion_tutor_grid->DisplayRecs);
		} else {
			if ($observacion_tutor_grid->Recordset = $observacion_tutor_grid->LoadRecordset())
				$observacion_tutor_grid->TotalRecs = $observacion_tutor_grid->Recordset->RecordCount();
		}
		$observacion_tutor_grid->StartRec = 1;
		$observacion_tutor_grid->DisplayRecs = $observacion_tutor_grid->TotalRecs;
	} else {
		$observacion_tutor->CurrentFilter = "0=1";
		$observacion_tutor_grid->StartRec = 1;
		$observacion_tutor_grid->DisplayRecs = $observacion_tutor->GridAddRowCount;
	}
	$observacion_tutor_grid->TotalRecs = $observacion_tutor_grid->DisplayRecs;
	$observacion_tutor_grid->StopRec = $observacion_tutor_grid->DisplayRecs;
} else {
	$bSelectLimit = $observacion_tutor_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($observacion_tutor_grid->TotalRecs <= 0)
			$observacion_tutor_grid->TotalRecs = $observacion_tutor->SelectRecordCount();
	} else {
		if (!$observacion_tutor_grid->Recordset && ($observacion_tutor_grid->Recordset = $observacion_tutor_grid->LoadRecordset()))
			$observacion_tutor_grid->TotalRecs = $observacion_tutor_grid->Recordset->RecordCount();
	}
	$observacion_tutor_grid->StartRec = 1;
	$observacion_tutor_grid->DisplayRecs = $observacion_tutor_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$observacion_tutor_grid->Recordset = $observacion_tutor_grid->LoadRecordset($observacion_tutor_grid->StartRec-1, $observacion_tutor_grid->DisplayRecs);

	// Set no record found message
	if ($observacion_tutor->CurrentAction == "" && $observacion_tutor_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$observacion_tutor_grid->setWarningMessage(ew_DeniedMsg());
		if ($observacion_tutor_grid->SearchWhere == "0=101")
			$observacion_tutor_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$observacion_tutor_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$observacion_tutor_grid->RenderOtherOptions();
?>
<?php $observacion_tutor_grid->ShowPageHeader(); ?>
<?php
$observacion_tutor_grid->ShowMessage();
?>
<?php if ($observacion_tutor_grid->TotalRecs > 0 || $observacion_tutor->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid observacion_tutor">
<div id="fobservacion_tutorgrid" class="ewForm form-inline">
<?php if ($observacion_tutor_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($observacion_tutor_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_observacion_tutor" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_observacion_tutorgrid" class="table ewTable">
<?php echo $observacion_tutor->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$observacion_tutor_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$observacion_tutor_grid->RenderListOptions();

// Render list options (header, left)
$observacion_tutor_grid->ListOptions->Render("header", "left");
?>
<?php if ($observacion_tutor->Detalle->Visible) { // Detalle ?>
	<?php if ($observacion_tutor->SortUrl($observacion_tutor->Detalle) == "") { ?>
		<th data-name="Detalle"><div id="elh_observacion_tutor_Detalle" class="observacion_tutor_Detalle"><div class="ewTableHeaderCaption"><?php echo $observacion_tutor->Detalle->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Detalle"><div><div id="elh_observacion_tutor_Detalle" class="observacion_tutor_Detalle">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_tutor->Detalle->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_tutor->Detalle->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_tutor->Detalle->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($observacion_tutor->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($observacion_tutor->SortUrl($observacion_tutor->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_observacion_tutor_Fecha_Actualizacion" class="observacion_tutor_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $observacion_tutor->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_observacion_tutor_Fecha_Actualizacion" class="observacion_tutor_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_tutor->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_tutor->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_tutor->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$observacion_tutor_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$observacion_tutor_grid->StartRec = 1;
$observacion_tutor_grid->StopRec = $observacion_tutor_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($observacion_tutor_grid->FormKeyCountName) && ($observacion_tutor->CurrentAction == "gridadd" || $observacion_tutor->CurrentAction == "gridedit" || $observacion_tutor->CurrentAction == "F")) {
		$observacion_tutor_grid->KeyCount = $objForm->GetValue($observacion_tutor_grid->FormKeyCountName);
		$observacion_tutor_grid->StopRec = $observacion_tutor_grid->StartRec + $observacion_tutor_grid->KeyCount - 1;
	}
}
$observacion_tutor_grid->RecCnt = $observacion_tutor_grid->StartRec - 1;
if ($observacion_tutor_grid->Recordset && !$observacion_tutor_grid->Recordset->EOF) {
	$observacion_tutor_grid->Recordset->MoveFirst();
	$bSelectLimit = $observacion_tutor_grid->UseSelectLimit;
	if (!$bSelectLimit && $observacion_tutor_grid->StartRec > 1)
		$observacion_tutor_grid->Recordset->Move($observacion_tutor_grid->StartRec - 1);
} elseif (!$observacion_tutor->AllowAddDeleteRow && $observacion_tutor_grid->StopRec == 0) {
	$observacion_tutor_grid->StopRec = $observacion_tutor->GridAddRowCount;
}

// Initialize aggregate
$observacion_tutor->RowType = EW_ROWTYPE_AGGREGATEINIT;
$observacion_tutor->ResetAttrs();
$observacion_tutor_grid->RenderRow();
if ($observacion_tutor->CurrentAction == "gridadd")
	$observacion_tutor_grid->RowIndex = 0;
if ($observacion_tutor->CurrentAction == "gridedit")
	$observacion_tutor_grid->RowIndex = 0;
while ($observacion_tutor_grid->RecCnt < $observacion_tutor_grid->StopRec) {
	$observacion_tutor_grid->RecCnt++;
	if (intval($observacion_tutor_grid->RecCnt) >= intval($observacion_tutor_grid->StartRec)) {
		$observacion_tutor_grid->RowCnt++;
		if ($observacion_tutor->CurrentAction == "gridadd" || $observacion_tutor->CurrentAction == "gridedit" || $observacion_tutor->CurrentAction == "F") {
			$observacion_tutor_grid->RowIndex++;
			$objForm->Index = $observacion_tutor_grid->RowIndex;
			if ($objForm->HasValue($observacion_tutor_grid->FormActionName))
				$observacion_tutor_grid->RowAction = strval($objForm->GetValue($observacion_tutor_grid->FormActionName));
			elseif ($observacion_tutor->CurrentAction == "gridadd")
				$observacion_tutor_grid->RowAction = "insert";
			else
				$observacion_tutor_grid->RowAction = "";
		}

		// Set up key count
		$observacion_tutor_grid->KeyCount = $observacion_tutor_grid->RowIndex;

		// Init row class and style
		$observacion_tutor->ResetAttrs();
		$observacion_tutor->CssClass = "";
		if ($observacion_tutor->CurrentAction == "gridadd") {
			if ($observacion_tutor->CurrentMode == "copy") {
				$observacion_tutor_grid->LoadRowValues($observacion_tutor_grid->Recordset); // Load row values
				$observacion_tutor_grid->SetRecordKey($observacion_tutor_grid->RowOldKey, $observacion_tutor_grid->Recordset); // Set old record key
			} else {
				$observacion_tutor_grid->LoadDefaultValues(); // Load default values
				$observacion_tutor_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$observacion_tutor_grid->LoadRowValues($observacion_tutor_grid->Recordset); // Load row values
		}
		$observacion_tutor->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($observacion_tutor->CurrentAction == "gridadd") // Grid add
			$observacion_tutor->RowType = EW_ROWTYPE_ADD; // Render add
		if ($observacion_tutor->CurrentAction == "gridadd" && $observacion_tutor->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$observacion_tutor_grid->RestoreCurrentRowFormValues($observacion_tutor_grid->RowIndex); // Restore form values
		if ($observacion_tutor->CurrentAction == "gridedit") { // Grid edit
			if ($observacion_tutor->EventCancelled) {
				$observacion_tutor_grid->RestoreCurrentRowFormValues($observacion_tutor_grid->RowIndex); // Restore form values
			}
			if ($observacion_tutor_grid->RowAction == "insert")
				$observacion_tutor->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$observacion_tutor->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($observacion_tutor->CurrentAction == "gridedit" && ($observacion_tutor->RowType == EW_ROWTYPE_EDIT || $observacion_tutor->RowType == EW_ROWTYPE_ADD) && $observacion_tutor->EventCancelled) // Update failed
			$observacion_tutor_grid->RestoreCurrentRowFormValues($observacion_tutor_grid->RowIndex); // Restore form values
		if ($observacion_tutor->RowType == EW_ROWTYPE_EDIT) // Edit row
			$observacion_tutor_grid->EditRowCnt++;
		if ($observacion_tutor->CurrentAction == "F") // Confirm row
			$observacion_tutor_grid->RestoreCurrentRowFormValues($observacion_tutor_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$observacion_tutor->RowAttrs = array_merge($observacion_tutor->RowAttrs, array('data-rowindex'=>$observacion_tutor_grid->RowCnt, 'id'=>'r' . $observacion_tutor_grid->RowCnt . '_observacion_tutor', 'data-rowtype'=>$observacion_tutor->RowType));

		// Render row
		$observacion_tutor_grid->RenderRow();

		// Render list options
		$observacion_tutor_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($observacion_tutor_grid->RowAction <> "delete" && $observacion_tutor_grid->RowAction <> "insertdelete" && !($observacion_tutor_grid->RowAction == "insert" && $observacion_tutor->CurrentAction == "F" && $observacion_tutor_grid->EmptyRow())) {
?>
	<tr<?php echo $observacion_tutor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_tutor_grid->ListOptions->Render("body", "left", $observacion_tutor_grid->RowCnt);
?>
	<?php if ($observacion_tutor->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle"<?php echo $observacion_tutor->Detalle->CellAttributes() ?>>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $observacion_tutor_grid->RowCnt ?>_observacion_tutor_Detalle" class="form-group observacion_tutor_Detalle">
<input type="text" data-table="observacion_tutor" data-field="x_Detalle" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" size="30" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_tutor->Detalle->EditValue ?>"<?php echo $observacion_tutor->Detalle->EditAttributes() ?>>
</span>
<input type="hidden" data-table="observacion_tutor" data-field="x_Detalle" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->OldValue) ?>">
<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $observacion_tutor_grid->RowCnt ?>_observacion_tutor_Detalle" class="form-group observacion_tutor_Detalle">
<input type="text" data-table="observacion_tutor" data-field="x_Detalle" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" size="30" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_tutor->Detalle->EditValue ?>"<?php echo $observacion_tutor->Detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_tutor_grid->RowCnt ?>_observacion_tutor_Detalle" class="observacion_tutor_Detalle">
<span<?php echo $observacion_tutor->Detalle->ViewAttributes() ?>>
<?php echo $observacion_tutor->Detalle->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_tutor" data-field="x_Detalle" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->FormValue) ?>">
<input type="hidden" data-table="observacion_tutor" data-field="x_Detalle" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->OldValue) ?>">
<?php } ?>
<a id="<?php echo $observacion_tutor_grid->PageObjName . "_row_" . $observacion_tutor_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_tutor" data-field="x_Id_Observacion" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Id_Observacion->CurrentValue) ?>">
<input type="hidden" data-table="observacion_tutor" data-field="x_Id_Observacion" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Id_Observacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_EDIT || $observacion_tutor->CurrentMode == "edit") { ?>
<input type="hidden" data-table="observacion_tutor" data-field="x_Id_Observacion" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Id_Observacion->CurrentValue) ?>">
<?php } ?>
	<?php if ($observacion_tutor->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $observacion_tutor->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_tutor" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_tutor_grid->RowCnt ?>_observacion_tutor_Fecha_Actualizacion" class="observacion_tutor_Fecha_Actualizacion">
<span<?php echo $observacion_tutor->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $observacion_tutor->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_tutor" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="observacion_tutor" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_tutor_grid->ListOptions->Render("body", "right", $observacion_tutor_grid->RowCnt);
?>
	</tr>
<?php if ($observacion_tutor->RowType == EW_ROWTYPE_ADD || $observacion_tutor->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fobservacion_tutorgrid.UpdateOpts(<?php echo $observacion_tutor_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($observacion_tutor->CurrentAction <> "gridadd" || $observacion_tutor->CurrentMode == "copy")
		if (!$observacion_tutor_grid->Recordset->EOF) $observacion_tutor_grid->Recordset->MoveNext();
}
?>
<?php
	if ($observacion_tutor->CurrentMode == "add" || $observacion_tutor->CurrentMode == "copy" || $observacion_tutor->CurrentMode == "edit") {
		$observacion_tutor_grid->RowIndex = '$rowindex$';
		$observacion_tutor_grid->LoadDefaultValues();

		// Set row properties
		$observacion_tutor->ResetAttrs();
		$observacion_tutor->RowAttrs = array_merge($observacion_tutor->RowAttrs, array('data-rowindex'=>$observacion_tutor_grid->RowIndex, 'id'=>'r0_observacion_tutor', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($observacion_tutor->RowAttrs["class"], "ewTemplate");
		$observacion_tutor->RowType = EW_ROWTYPE_ADD;

		// Render row
		$observacion_tutor_grid->RenderRow();

		// Render list options
		$observacion_tutor_grid->RenderListOptions();
		$observacion_tutor_grid->StartRowCnt = 0;
?>
	<tr<?php echo $observacion_tutor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_tutor_grid->ListOptions->Render("body", "left", $observacion_tutor_grid->RowIndex);
?>
	<?php if ($observacion_tutor->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle">
<?php if ($observacion_tutor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_observacion_tutor_Detalle" class="form-group observacion_tutor_Detalle">
<input type="text" data-table="observacion_tutor" data-field="x_Detalle" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" size="30" maxlength="500" placeholder="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->getPlaceHolder()) ?>" value="<?php echo $observacion_tutor->Detalle->EditValue ?>"<?php echo $observacion_tutor->Detalle->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_observacion_tutor_Detalle" class="form-group observacion_tutor_Detalle">
<span<?php echo $observacion_tutor->Detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $observacion_tutor->Detalle->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="observacion_tutor" data-field="x_Detalle" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_tutor" data-field="x_Detalle" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_tutor->Detalle->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($observacion_tutor->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($observacion_tutor->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_observacion_tutor_Fecha_Actualizacion" class="form-group observacion_tutor_Fecha_Actualizacion">
<span<?php echo $observacion_tutor->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $observacion_tutor->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="observacion_tutor" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_tutor" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_tutor_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_tutor->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_tutor_grid->ListOptions->Render("body", "right", $observacion_tutor_grid->RowCnt);
?>
<script type="text/javascript">
fobservacion_tutorgrid.UpdateOpts(<?php echo $observacion_tutor_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($observacion_tutor->CurrentMode == "add" || $observacion_tutor->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $observacion_tutor_grid->FormKeyCountName ?>" id="<?php echo $observacion_tutor_grid->FormKeyCountName ?>" value="<?php echo $observacion_tutor_grid->KeyCount ?>">
<?php echo $observacion_tutor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_tutor->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $observacion_tutor_grid->FormKeyCountName ?>" id="<?php echo $observacion_tutor_grid->FormKeyCountName ?>" value="<?php echo $observacion_tutor_grid->KeyCount ?>">
<?php echo $observacion_tutor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_tutor->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fobservacion_tutorgrid">
</div>
<?php

// Close recordset
if ($observacion_tutor_grid->Recordset)
	$observacion_tutor_grid->Recordset->Close();
?>
<?php if ($observacion_tutor_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($observacion_tutor_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($observacion_tutor_grid->TotalRecs == 0 && $observacion_tutor->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($observacion_tutor_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($observacion_tutor->Export == "") { ?>
<script type="text/javascript">
fobservacion_tutorgrid.Init();
</script>
<?php } ?>
<?php
$observacion_tutor_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$observacion_tutor_grid->Page_Terminate();
?>
