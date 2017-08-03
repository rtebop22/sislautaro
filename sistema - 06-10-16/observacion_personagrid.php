<?php

// Create page object
if (!isset($observacion_persona_grid)) $observacion_persona_grid = new cobservacion_persona_grid();

// Page init
$observacion_persona_grid->Page_Init();

// Page main
$observacion_persona_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$observacion_persona_grid->Page_Render();
?>
<?php if ($observacion_persona->Export == "") { ?>
<script type="text/javascript">

// Form object
var fobservacion_personagrid = new ew_Form("fobservacion_personagrid", "grid");
fobservacion_personagrid.FormKeyCountName = '<?php echo $observacion_persona_grid->FormKeyCountName ?>';

// Validate form
fobservacion_personagrid.Validate = function() {
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
fobservacion_personagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Detalle", false)) return false;
	return true;
}

// Form_CustomValidate event
fobservacion_personagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fobservacion_personagrid.ValidateRequired = true;
<?php } else { ?>
fobservacion_personagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($observacion_persona->CurrentAction == "gridadd") {
	if ($observacion_persona->CurrentMode == "copy") {
		$bSelectLimit = $observacion_persona_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$observacion_persona_grid->TotalRecs = $observacion_persona->SelectRecordCount();
			$observacion_persona_grid->Recordset = $observacion_persona_grid->LoadRecordset($observacion_persona_grid->StartRec-1, $observacion_persona_grid->DisplayRecs);
		} else {
			if ($observacion_persona_grid->Recordset = $observacion_persona_grid->LoadRecordset())
				$observacion_persona_grid->TotalRecs = $observacion_persona_grid->Recordset->RecordCount();
		}
		$observacion_persona_grid->StartRec = 1;
		$observacion_persona_grid->DisplayRecs = $observacion_persona_grid->TotalRecs;
	} else {
		$observacion_persona->CurrentFilter = "0=1";
		$observacion_persona_grid->StartRec = 1;
		$observacion_persona_grid->DisplayRecs = $observacion_persona->GridAddRowCount;
	}
	$observacion_persona_grid->TotalRecs = $observacion_persona_grid->DisplayRecs;
	$observacion_persona_grid->StopRec = $observacion_persona_grid->DisplayRecs;
} else {
	$bSelectLimit = $observacion_persona_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($observacion_persona_grid->TotalRecs <= 0)
			$observacion_persona_grid->TotalRecs = $observacion_persona->SelectRecordCount();
	} else {
		if (!$observacion_persona_grid->Recordset && ($observacion_persona_grid->Recordset = $observacion_persona_grid->LoadRecordset()))
			$observacion_persona_grid->TotalRecs = $observacion_persona_grid->Recordset->RecordCount();
	}
	$observacion_persona_grid->StartRec = 1;
	$observacion_persona_grid->DisplayRecs = $observacion_persona_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$observacion_persona_grid->Recordset = $observacion_persona_grid->LoadRecordset($observacion_persona_grid->StartRec-1, $observacion_persona_grid->DisplayRecs);

	// Set no record found message
	if ($observacion_persona->CurrentAction == "" && $observacion_persona_grid->TotalRecs == 0) {
		if ($observacion_persona_grid->SearchWhere == "0=101")
			$observacion_persona_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$observacion_persona_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$observacion_persona_grid->RenderOtherOptions();
?>
<?php $observacion_persona_grid->ShowPageHeader(); ?>
<?php
$observacion_persona_grid->ShowMessage();
?>
<?php if ($observacion_persona_grid->TotalRecs > 0 || $observacion_persona->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid observacion_persona">
<div id="fobservacion_personagrid" class="ewForm form-inline">
<div id="gmp_observacion_persona" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_observacion_personagrid" class="table ewTable">
<?php echo $observacion_persona->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$observacion_persona_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$observacion_persona_grid->RenderListOptions();

// Render list options (header, left)
$observacion_persona_grid->ListOptions->Render("header", "left");
?>
<?php if ($observacion_persona->Detalle->Visible) { // Detalle ?>
	<?php if ($observacion_persona->SortUrl($observacion_persona->Detalle) == "") { ?>
		<th data-name="Detalle"><div id="elh_observacion_persona_Detalle" class="observacion_persona_Detalle"><div class="ewTableHeaderCaption"><?php echo $observacion_persona->Detalle->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Detalle"><div><div id="elh_observacion_persona_Detalle" class="observacion_persona_Detalle">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_persona->Detalle->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_persona->Detalle->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_persona->Detalle->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($observacion_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($observacion_persona->SortUrl($observacion_persona->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_observacion_persona_Fecha_Actualizacion" class="observacion_persona_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $observacion_persona->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_observacion_persona_Fecha_Actualizacion" class="observacion_persona_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $observacion_persona->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($observacion_persona->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($observacion_persona->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$observacion_persona_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$observacion_persona_grid->StartRec = 1;
$observacion_persona_grid->StopRec = $observacion_persona_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($observacion_persona_grid->FormKeyCountName) && ($observacion_persona->CurrentAction == "gridadd" || $observacion_persona->CurrentAction == "gridedit" || $observacion_persona->CurrentAction == "F")) {
		$observacion_persona_grid->KeyCount = $objForm->GetValue($observacion_persona_grid->FormKeyCountName);
		$observacion_persona_grid->StopRec = $observacion_persona_grid->StartRec + $observacion_persona_grid->KeyCount - 1;
	}
}
$observacion_persona_grid->RecCnt = $observacion_persona_grid->StartRec - 1;
if ($observacion_persona_grid->Recordset && !$observacion_persona_grid->Recordset->EOF) {
	$observacion_persona_grid->Recordset->MoveFirst();
	$bSelectLimit = $observacion_persona_grid->UseSelectLimit;
	if (!$bSelectLimit && $observacion_persona_grid->StartRec > 1)
		$observacion_persona_grid->Recordset->Move($observacion_persona_grid->StartRec - 1);
} elseif (!$observacion_persona->AllowAddDeleteRow && $observacion_persona_grid->StopRec == 0) {
	$observacion_persona_grid->StopRec = $observacion_persona->GridAddRowCount;
}

// Initialize aggregate
$observacion_persona->RowType = EW_ROWTYPE_AGGREGATEINIT;
$observacion_persona->ResetAttrs();
$observacion_persona_grid->RenderRow();
if ($observacion_persona->CurrentAction == "gridadd")
	$observacion_persona_grid->RowIndex = 0;
if ($observacion_persona->CurrentAction == "gridedit")
	$observacion_persona_grid->RowIndex = 0;
while ($observacion_persona_grid->RecCnt < $observacion_persona_grid->StopRec) {
	$observacion_persona_grid->RecCnt++;
	if (intval($observacion_persona_grid->RecCnt) >= intval($observacion_persona_grid->StartRec)) {
		$observacion_persona_grid->RowCnt++;
		if ($observacion_persona->CurrentAction == "gridadd" || $observacion_persona->CurrentAction == "gridedit" || $observacion_persona->CurrentAction == "F") {
			$observacion_persona_grid->RowIndex++;
			$objForm->Index = $observacion_persona_grid->RowIndex;
			if ($objForm->HasValue($observacion_persona_grid->FormActionName))
				$observacion_persona_grid->RowAction = strval($objForm->GetValue($observacion_persona_grid->FormActionName));
			elseif ($observacion_persona->CurrentAction == "gridadd")
				$observacion_persona_grid->RowAction = "insert";
			else
				$observacion_persona_grid->RowAction = "";
		}

		// Set up key count
		$observacion_persona_grid->KeyCount = $observacion_persona_grid->RowIndex;

		// Init row class and style
		$observacion_persona->ResetAttrs();
		$observacion_persona->CssClass = "";
		if ($observacion_persona->CurrentAction == "gridadd") {
			if ($observacion_persona->CurrentMode == "copy") {
				$observacion_persona_grid->LoadRowValues($observacion_persona_grid->Recordset); // Load row values
				$observacion_persona_grid->SetRecordKey($observacion_persona_grid->RowOldKey, $observacion_persona_grid->Recordset); // Set old record key
			} else {
				$observacion_persona_grid->LoadDefaultValues(); // Load default values
				$observacion_persona_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$observacion_persona_grid->LoadRowValues($observacion_persona_grid->Recordset); // Load row values
		}
		$observacion_persona->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($observacion_persona->CurrentAction == "gridadd") // Grid add
			$observacion_persona->RowType = EW_ROWTYPE_ADD; // Render add
		if ($observacion_persona->CurrentAction == "gridadd" && $observacion_persona->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$observacion_persona_grid->RestoreCurrentRowFormValues($observacion_persona_grid->RowIndex); // Restore form values
		if ($observacion_persona->CurrentAction == "gridedit") { // Grid edit
			if ($observacion_persona->EventCancelled) {
				$observacion_persona_grid->RestoreCurrentRowFormValues($observacion_persona_grid->RowIndex); // Restore form values
			}
			if ($observacion_persona_grid->RowAction == "insert")
				$observacion_persona->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$observacion_persona->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($observacion_persona->CurrentAction == "gridedit" && ($observacion_persona->RowType == EW_ROWTYPE_EDIT || $observacion_persona->RowType == EW_ROWTYPE_ADD) && $observacion_persona->EventCancelled) // Update failed
			$observacion_persona_grid->RestoreCurrentRowFormValues($observacion_persona_grid->RowIndex); // Restore form values
		if ($observacion_persona->RowType == EW_ROWTYPE_EDIT) // Edit row
			$observacion_persona_grid->EditRowCnt++;
		if ($observacion_persona->CurrentAction == "F") // Confirm row
			$observacion_persona_grid->RestoreCurrentRowFormValues($observacion_persona_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$observacion_persona->RowAttrs = array_merge($observacion_persona->RowAttrs, array('data-rowindex'=>$observacion_persona_grid->RowCnt, 'id'=>'r' . $observacion_persona_grid->RowCnt . '_observacion_persona', 'data-rowtype'=>$observacion_persona->RowType));

		// Render row
		$observacion_persona_grid->RenderRow();

		// Render list options
		$observacion_persona_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($observacion_persona_grid->RowAction <> "delete" && $observacion_persona_grid->RowAction <> "insertdelete" && !($observacion_persona_grid->RowAction == "insert" && $observacion_persona->CurrentAction == "F" && $observacion_persona_grid->EmptyRow())) {
?>
	<tr<?php echo $observacion_persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_persona_grid->ListOptions->Render("body", "left", $observacion_persona_grid->RowCnt);
?>
	<?php if ($observacion_persona->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle"<?php echo $observacion_persona->Detalle->CellAttributes() ?>>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $observacion_persona_grid->RowCnt ?>_observacion_persona_Detalle" class="form-group observacion_persona_Detalle">
<textarea data-table="observacion_persona" data-field="x_Detalle" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" cols="35" rows="1" placeholder="<?php echo ew_HtmlEncode($observacion_persona->Detalle->getPlaceHolder()) ?>"<?php echo $observacion_persona->Detalle->EditAttributes() ?>><?php echo $observacion_persona->Detalle->EditValue ?></textarea>
</span>
<input type="hidden" data-table="observacion_persona" data-field="x_Detalle" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_persona->Detalle->OldValue) ?>">
<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $observacion_persona_grid->RowCnt ?>_observacion_persona_Detalle" class="form-group observacion_persona_Detalle">
<textarea data-table="observacion_persona" data-field="x_Detalle" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" cols="35" rows="1" placeholder="<?php echo ew_HtmlEncode($observacion_persona->Detalle->getPlaceHolder()) ?>"<?php echo $observacion_persona->Detalle->EditAttributes() ?>><?php echo $observacion_persona->Detalle->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_persona_grid->RowCnt ?>_observacion_persona_Detalle" class="observacion_persona_Detalle">
<span<?php echo $observacion_persona->Detalle->ViewAttributes() ?>>
<?php echo $observacion_persona->Detalle->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_persona" data-field="x_Detalle" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_persona->Detalle->FormValue) ?>">
<input type="hidden" data-table="observacion_persona" data-field="x_Detalle" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_persona->Detalle->OldValue) ?>">
<?php } ?>
<a id="<?php echo $observacion_persona_grid->PageObjName . "_row_" . $observacion_persona_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Id_Observacion" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_persona->Id_Observacion->CurrentValue) ?>">
<input type="hidden" data-table="observacion_persona" data-field="x_Id_Observacion" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_persona->Id_Observacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_EDIT || $observacion_persona->CurrentMode == "edit") { ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Id_Observacion" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Id_Observacion" value="<?php echo ew_HtmlEncode($observacion_persona->Id_Observacion->CurrentValue) ?>">
<?php } ?>
	<?php if ($observacion_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $observacion_persona->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_persona->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $observacion_persona_grid->RowCnt ?>_observacion_persona_Fecha_Actualizacion" class="observacion_persona_Fecha_Actualizacion">
<span<?php echo $observacion_persona->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $observacion_persona->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="observacion_persona" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_persona->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="observacion_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_persona->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_persona_grid->ListOptions->Render("body", "right", $observacion_persona_grid->RowCnt);
?>
	</tr>
<?php if ($observacion_persona->RowType == EW_ROWTYPE_ADD || $observacion_persona->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fobservacion_personagrid.UpdateOpts(<?php echo $observacion_persona_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($observacion_persona->CurrentAction <> "gridadd" || $observacion_persona->CurrentMode == "copy")
		if (!$observacion_persona_grid->Recordset->EOF) $observacion_persona_grid->Recordset->MoveNext();
}
?>
<?php
	if ($observacion_persona->CurrentMode == "add" || $observacion_persona->CurrentMode == "copy" || $observacion_persona->CurrentMode == "edit") {
		$observacion_persona_grid->RowIndex = '$rowindex$';
		$observacion_persona_grid->LoadDefaultValues();

		// Set row properties
		$observacion_persona->ResetAttrs();
		$observacion_persona->RowAttrs = array_merge($observacion_persona->RowAttrs, array('data-rowindex'=>$observacion_persona_grid->RowIndex, 'id'=>'r0_observacion_persona', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($observacion_persona->RowAttrs["class"], "ewTemplate");
		$observacion_persona->RowType = EW_ROWTYPE_ADD;

		// Render row
		$observacion_persona_grid->RenderRow();

		// Render list options
		$observacion_persona_grid->RenderListOptions();
		$observacion_persona_grid->StartRowCnt = 0;
?>
	<tr<?php echo $observacion_persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$observacion_persona_grid->ListOptions->Render("body", "left", $observacion_persona_grid->RowIndex);
?>
	<?php if ($observacion_persona->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle">
<?php if ($observacion_persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_observacion_persona_Detalle" class="form-group observacion_persona_Detalle">
<textarea data-table="observacion_persona" data-field="x_Detalle" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" cols="35" rows="1" placeholder="<?php echo ew_HtmlEncode($observacion_persona->Detalle->getPlaceHolder()) ?>"<?php echo $observacion_persona->Detalle->EditAttributes() ?>><?php echo $observacion_persona->Detalle->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_observacion_persona_Detalle" class="form-group observacion_persona_Detalle">
<span<?php echo $observacion_persona->Detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $observacion_persona->Detalle->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="observacion_persona" data-field="x_Detalle" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_persona->Detalle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Detalle" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($observacion_persona->Detalle->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($observacion_persona->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($observacion_persona->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Fecha_Actualizacion" name="x<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_persona->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="observacion_persona" data-field="x_Fecha_Actualizacion" name="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $observacion_persona_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($observacion_persona->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$observacion_persona_grid->ListOptions->Render("body", "right", $observacion_persona_grid->RowCnt);
?>
<script type="text/javascript">
fobservacion_personagrid.UpdateOpts(<?php echo $observacion_persona_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($observacion_persona->CurrentMode == "add" || $observacion_persona->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $observacion_persona_grid->FormKeyCountName ?>" id="<?php echo $observacion_persona_grid->FormKeyCountName ?>" value="<?php echo $observacion_persona_grid->KeyCount ?>">
<?php echo $observacion_persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_persona->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $observacion_persona_grid->FormKeyCountName ?>" id="<?php echo $observacion_persona_grid->FormKeyCountName ?>" value="<?php echo $observacion_persona_grid->KeyCount ?>">
<?php echo $observacion_persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($observacion_persona->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fobservacion_personagrid">
</div>
<?php

// Close recordset
if ($observacion_persona_grid->Recordset)
	$observacion_persona_grid->Recordset->Close();
?>
<?php if ($observacion_persona_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($observacion_persona_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($observacion_persona_grid->TotalRecs == 0 && $observacion_persona->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($observacion_persona_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($observacion_persona->Export == "") { ?>
<script type="text/javascript">
fobservacion_personagrid.Init();
</script>
<?php } ?>
<?php
$observacion_persona_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$observacion_persona_grid->Page_Terminate();
?>
