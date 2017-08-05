<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($historial_atencion_grid)) $historial_atencion_grid = new chistorial_atencion_grid();

// Page init
$historial_atencion_grid->Page_Init();

// Page main
$historial_atencion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$historial_atencion_grid->Page_Render();
?>
<?php if ($historial_atencion->Export == "") { ?>
<script type="text/javascript">

// Form object
var fhistorial_atenciongrid = new ew_Form("fhistorial_atenciongrid", "grid");
fhistorial_atenciongrid.FormKeyCountName = '<?php echo $historial_atencion_grid->FormKeyCountName ?>';

// Validate form
fhistorial_atenciongrid.Validate = function() {
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
fhistorial_atenciongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Detalle", false)) return false;
	return true;
}

// Form_CustomValidate event
fhistorial_atenciongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhistorial_atenciongrid.ValidateRequired = true;
<?php } else { ?>
fhistorial_atenciongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($historial_atencion->CurrentAction == "gridadd") {
	if ($historial_atencion->CurrentMode == "copy") {
		$bSelectLimit = $historial_atencion_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$historial_atencion_grid->TotalRecs = $historial_atencion->SelectRecordCount();
			$historial_atencion_grid->Recordset = $historial_atencion_grid->LoadRecordset($historial_atencion_grid->StartRec-1, $historial_atencion_grid->DisplayRecs);
		} else {
			if ($historial_atencion_grid->Recordset = $historial_atencion_grid->LoadRecordset())
				$historial_atencion_grid->TotalRecs = $historial_atencion_grid->Recordset->RecordCount();
		}
		$historial_atencion_grid->StartRec = 1;
		$historial_atencion_grid->DisplayRecs = $historial_atencion_grid->TotalRecs;
	} else {
		$historial_atencion->CurrentFilter = "0=1";
		$historial_atencion_grid->StartRec = 1;
		$historial_atencion_grid->DisplayRecs = $historial_atencion->GridAddRowCount;
	}
	$historial_atencion_grid->TotalRecs = $historial_atencion_grid->DisplayRecs;
	$historial_atencion_grid->StopRec = $historial_atencion_grid->DisplayRecs;
} else {
	$bSelectLimit = $historial_atencion_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($historial_atencion_grid->TotalRecs <= 0)
			$historial_atencion_grid->TotalRecs = $historial_atencion->SelectRecordCount();
	} else {
		if (!$historial_atencion_grid->Recordset && ($historial_atencion_grid->Recordset = $historial_atencion_grid->LoadRecordset()))
			$historial_atencion_grid->TotalRecs = $historial_atencion_grid->Recordset->RecordCount();
	}
	$historial_atencion_grid->StartRec = 1;
	$historial_atencion_grid->DisplayRecs = $historial_atencion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$historial_atencion_grid->Recordset = $historial_atencion_grid->LoadRecordset($historial_atencion_grid->StartRec-1, $historial_atencion_grid->DisplayRecs);

	// Set no record found message
	if ($historial_atencion->CurrentAction == "" && $historial_atencion_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$historial_atencion_grid->setWarningMessage(ew_DeniedMsg());
		if ($historial_atencion_grid->SearchWhere == "0=101")
			$historial_atencion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$historial_atencion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$historial_atencion_grid->RenderOtherOptions();
?>
<?php $historial_atencion_grid->ShowPageHeader(); ?>
<?php
$historial_atencion_grid->ShowMessage();
?>
<?php if ($historial_atencion_grid->TotalRecs > 0 || $historial_atencion->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid historial_atencion">
<div id="fhistorial_atenciongrid" class="ewForm form-inline">
<?php if ($historial_atencion_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($historial_atencion_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_historial_atencion" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_historial_atenciongrid" class="table ewTable">
<?php echo $historial_atencion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$historial_atencion_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$historial_atencion_grid->RenderListOptions();

// Render list options (header, left)
$historial_atencion_grid->ListOptions->Render("header", "left");
?>
<?php if ($historial_atencion->Detalle->Visible) { // Detalle ?>
	<?php if ($historial_atencion->SortUrl($historial_atencion->Detalle) == "") { ?>
		<th data-name="Detalle"><div id="elh_historial_atencion_Detalle" class="historial_atencion_Detalle"><div class="ewTableHeaderCaption"><?php echo $historial_atencion->Detalle->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Detalle"><div><div id="elh_historial_atencion_Detalle" class="historial_atencion_Detalle">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $historial_atencion->Detalle->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($historial_atencion->Detalle->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($historial_atencion->Detalle->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($historial_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($historial_atencion->SortUrl($historial_atencion->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_historial_atencion_Fecha_Actualizacion" class="historial_atencion_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $historial_atencion->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_historial_atencion_Fecha_Actualizacion" class="historial_atencion_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $historial_atencion->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($historial_atencion->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($historial_atencion->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($historial_atencion->Usuario->Visible) { // Usuario ?>
	<?php if ($historial_atencion->SortUrl($historial_atencion->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_historial_atencion_Usuario" class="historial_atencion_Usuario"><div class="ewTableHeaderCaption"><?php echo $historial_atencion->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_historial_atencion_Usuario" class="historial_atencion_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $historial_atencion->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($historial_atencion->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($historial_atencion->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$historial_atencion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$historial_atencion_grid->StartRec = 1;
$historial_atencion_grid->StopRec = $historial_atencion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($historial_atencion_grid->FormKeyCountName) && ($historial_atencion->CurrentAction == "gridadd" || $historial_atencion->CurrentAction == "gridedit" || $historial_atencion->CurrentAction == "F")) {
		$historial_atencion_grid->KeyCount = $objForm->GetValue($historial_atencion_grid->FormKeyCountName);
		$historial_atencion_grid->StopRec = $historial_atencion_grid->StartRec + $historial_atencion_grid->KeyCount - 1;
	}
}
$historial_atencion_grid->RecCnt = $historial_atencion_grid->StartRec - 1;
if ($historial_atencion_grid->Recordset && !$historial_atencion_grid->Recordset->EOF) {
	$historial_atencion_grid->Recordset->MoveFirst();
	$bSelectLimit = $historial_atencion_grid->UseSelectLimit;
	if (!$bSelectLimit && $historial_atencion_grid->StartRec > 1)
		$historial_atencion_grid->Recordset->Move($historial_atencion_grid->StartRec - 1);
} elseif (!$historial_atencion->AllowAddDeleteRow && $historial_atencion_grid->StopRec == 0) {
	$historial_atencion_grid->StopRec = $historial_atencion->GridAddRowCount;
}

// Initialize aggregate
$historial_atencion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$historial_atencion->ResetAttrs();
$historial_atencion_grid->RenderRow();
if ($historial_atencion->CurrentAction == "gridadd")
	$historial_atencion_grid->RowIndex = 0;
if ($historial_atencion->CurrentAction == "gridedit")
	$historial_atencion_grid->RowIndex = 0;
while ($historial_atencion_grid->RecCnt < $historial_atencion_grid->StopRec) {
	$historial_atencion_grid->RecCnt++;
	if (intval($historial_atencion_grid->RecCnt) >= intval($historial_atencion_grid->StartRec)) {
		$historial_atencion_grid->RowCnt++;
		if ($historial_atencion->CurrentAction == "gridadd" || $historial_atencion->CurrentAction == "gridedit" || $historial_atencion->CurrentAction == "F") {
			$historial_atencion_grid->RowIndex++;
			$objForm->Index = $historial_atencion_grid->RowIndex;
			if ($objForm->HasValue($historial_atencion_grid->FormActionName))
				$historial_atencion_grid->RowAction = strval($objForm->GetValue($historial_atencion_grid->FormActionName));
			elseif ($historial_atencion->CurrentAction == "gridadd")
				$historial_atencion_grid->RowAction = "insert";
			else
				$historial_atencion_grid->RowAction = "";
		}

		// Set up key count
		$historial_atencion_grid->KeyCount = $historial_atencion_grid->RowIndex;

		// Init row class and style
		$historial_atencion->ResetAttrs();
		$historial_atencion->CssClass = "";
		if ($historial_atencion->CurrentAction == "gridadd") {
			if ($historial_atencion->CurrentMode == "copy") {
				$historial_atencion_grid->LoadRowValues($historial_atencion_grid->Recordset); // Load row values
				$historial_atencion_grid->SetRecordKey($historial_atencion_grid->RowOldKey, $historial_atencion_grid->Recordset); // Set old record key
			} else {
				$historial_atencion_grid->LoadDefaultValues(); // Load default values
				$historial_atencion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$historial_atencion_grid->LoadRowValues($historial_atencion_grid->Recordset); // Load row values
		}
		$historial_atencion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($historial_atencion->CurrentAction == "gridadd") // Grid add
			$historial_atencion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($historial_atencion->CurrentAction == "gridadd" && $historial_atencion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$historial_atencion_grid->RestoreCurrentRowFormValues($historial_atencion_grid->RowIndex); // Restore form values
		if ($historial_atencion->CurrentAction == "gridedit") { // Grid edit
			if ($historial_atencion->EventCancelled) {
				$historial_atencion_grid->RestoreCurrentRowFormValues($historial_atencion_grid->RowIndex); // Restore form values
			}
			if ($historial_atencion_grid->RowAction == "insert")
				$historial_atencion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$historial_atencion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($historial_atencion->CurrentAction == "gridedit" && ($historial_atencion->RowType == EW_ROWTYPE_EDIT || $historial_atencion->RowType == EW_ROWTYPE_ADD) && $historial_atencion->EventCancelled) // Update failed
			$historial_atencion_grid->RestoreCurrentRowFormValues($historial_atencion_grid->RowIndex); // Restore form values
		if ($historial_atencion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$historial_atencion_grid->EditRowCnt++;
		if ($historial_atencion->CurrentAction == "F") // Confirm row
			$historial_atencion_grid->RestoreCurrentRowFormValues($historial_atencion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$historial_atencion->RowAttrs = array_merge($historial_atencion->RowAttrs, array('data-rowindex'=>$historial_atencion_grid->RowCnt, 'id'=>'r' . $historial_atencion_grid->RowCnt . '_historial_atencion', 'data-rowtype'=>$historial_atencion->RowType));

		// Render row
		$historial_atencion_grid->RenderRow();

		// Render list options
		$historial_atencion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($historial_atencion_grid->RowAction <> "delete" && $historial_atencion_grid->RowAction <> "insertdelete" && !($historial_atencion_grid->RowAction == "insert" && $historial_atencion->CurrentAction == "F" && $historial_atencion_grid->EmptyRow())) {
?>
	<tr<?php echo $historial_atencion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$historial_atencion_grid->ListOptions->Render("body", "left", $historial_atencion_grid->RowCnt);
?>
	<?php if ($historial_atencion->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle"<?php echo $historial_atencion->Detalle->CellAttributes() ?>>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $historial_atencion_grid->RowCnt ?>_historial_atencion_Detalle" class="form-group historial_atencion_Detalle">
<input type="text" data-table="historial_atencion" data-field="x_Detalle" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" placeholder="<?php echo ew_HtmlEncode($historial_atencion->Detalle->getPlaceHolder()) ?>" value="<?php echo $historial_atencion->Detalle->EditValue ?>"<?php echo $historial_atencion->Detalle->EditAttributes() ?>>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Detalle" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($historial_atencion->Detalle->OldValue) ?>">
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $historial_atencion_grid->RowCnt ?>_historial_atencion_Detalle" class="form-group historial_atencion_Detalle">
<input type="text" data-table="historial_atencion" data-field="x_Detalle" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" placeholder="<?php echo ew_HtmlEncode($historial_atencion->Detalle->getPlaceHolder()) ?>" value="<?php echo $historial_atencion->Detalle->EditValue ?>"<?php echo $historial_atencion->Detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $historial_atencion_grid->RowCnt ?>_historial_atencion_Detalle" class="historial_atencion_Detalle">
<span<?php echo $historial_atencion->Detalle->ViewAttributes() ?>>
<?php echo $historial_atencion->Detalle->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Detalle" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($historial_atencion->Detalle->FormValue) ?>">
<input type="hidden" data-table="historial_atencion" data-field="x_Detalle" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($historial_atencion->Detalle->OldValue) ?>">
<?php } ?>
<a id="<?php echo $historial_atencion_grid->PageObjName . "_row_" . $historial_atencion_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Id_Historial" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" value="<?php echo ew_HtmlEncode($historial_atencion->Id_Historial->CurrentValue) ?>">
<input type="hidden" data-table="historial_atencion" data-field="x_Id_Historial" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" value="<?php echo ew_HtmlEncode($historial_atencion->Id_Historial->OldValue) ?>">
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_EDIT || $historial_atencion->CurrentMode == "edit") { ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Id_Historial" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Id_Historial" value="<?php echo ew_HtmlEncode($historial_atencion->Id_Historial->CurrentValue) ?>">
<?php } ?>
	<?php if ($historial_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $historial_atencion->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($historial_atencion->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $historial_atencion_grid->RowCnt ?>_historial_atencion_Fecha_Actualizacion" class="historial_atencion_Fecha_Actualizacion">
<span<?php echo $historial_atencion->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $historial_atencion->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Fecha_Actualizacion" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($historial_atencion->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="historial_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($historial_atencion->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($historial_atencion->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $historial_atencion->Usuario->CellAttributes() ?>>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Usuario" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($historial_atencion->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $historial_atencion_grid->RowCnt ?>_historial_atencion_Usuario" class="historial_atencion_Usuario">
<span<?php echo $historial_atencion->Usuario->ViewAttributes() ?>>
<?php echo $historial_atencion->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Usuario" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($historial_atencion->Usuario->FormValue) ?>">
<input type="hidden" data-table="historial_atencion" data-field="x_Usuario" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($historial_atencion->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$historial_atencion_grid->ListOptions->Render("body", "right", $historial_atencion_grid->RowCnt);
?>
	</tr>
<?php if ($historial_atencion->RowType == EW_ROWTYPE_ADD || $historial_atencion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fhistorial_atenciongrid.UpdateOpts(<?php echo $historial_atencion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($historial_atencion->CurrentAction <> "gridadd" || $historial_atencion->CurrentMode == "copy")
		if (!$historial_atencion_grid->Recordset->EOF) $historial_atencion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($historial_atencion->CurrentMode == "add" || $historial_atencion->CurrentMode == "copy" || $historial_atencion->CurrentMode == "edit") {
		$historial_atencion_grid->RowIndex = '$rowindex$';
		$historial_atencion_grid->LoadDefaultValues();

		// Set row properties
		$historial_atencion->ResetAttrs();
		$historial_atencion->RowAttrs = array_merge($historial_atencion->RowAttrs, array('data-rowindex'=>$historial_atencion_grid->RowIndex, 'id'=>'r0_historial_atencion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($historial_atencion->RowAttrs["class"], "ewTemplate");
		$historial_atencion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$historial_atencion_grid->RenderRow();

		// Render list options
		$historial_atencion_grid->RenderListOptions();
		$historial_atencion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $historial_atencion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$historial_atencion_grid->ListOptions->Render("body", "left", $historial_atencion_grid->RowIndex);
?>
	<?php if ($historial_atencion->Detalle->Visible) { // Detalle ?>
		<td data-name="Detalle">
<?php if ($historial_atencion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_historial_atencion_Detalle" class="form-group historial_atencion_Detalle">
<input type="text" data-table="historial_atencion" data-field="x_Detalle" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" placeholder="<?php echo ew_HtmlEncode($historial_atencion->Detalle->getPlaceHolder()) ?>" value="<?php echo $historial_atencion->Detalle->EditValue ?>"<?php echo $historial_atencion->Detalle->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_historial_atencion_Detalle" class="form-group historial_atencion_Detalle">
<span<?php echo $historial_atencion->Detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $historial_atencion->Detalle->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Detalle" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($historial_atencion->Detalle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Detalle" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Detalle" value="<?php echo ew_HtmlEncode($historial_atencion->Detalle->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($historial_atencion->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($historial_atencion->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_historial_atencion_Fecha_Actualizacion" class="form-group historial_atencion_Fecha_Actualizacion">
<span<?php echo $historial_atencion->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $historial_atencion->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Fecha_Actualizacion" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($historial_atencion->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Fecha_Actualizacion" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($historial_atencion->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($historial_atencion->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($historial_atencion->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_historial_atencion_Usuario" class="form-group historial_atencion_Usuario">
<span<?php echo $historial_atencion->Usuario->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $historial_atencion->Usuario->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="historial_atencion" data-field="x_Usuario" name="x<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" id="x<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($historial_atencion->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="historial_atencion" data-field="x_Usuario" name="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" id="o<?php echo $historial_atencion_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($historial_atencion->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$historial_atencion_grid->ListOptions->Render("body", "right", $historial_atencion_grid->RowCnt);
?>
<script type="text/javascript">
fhistorial_atenciongrid.UpdateOpts(<?php echo $historial_atencion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($historial_atencion->CurrentMode == "add" || $historial_atencion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $historial_atencion_grid->FormKeyCountName ?>" id="<?php echo $historial_atencion_grid->FormKeyCountName ?>" value="<?php echo $historial_atencion_grid->KeyCount ?>">
<?php echo $historial_atencion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($historial_atencion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $historial_atencion_grid->FormKeyCountName ?>" id="<?php echo $historial_atencion_grid->FormKeyCountName ?>" value="<?php echo $historial_atencion_grid->KeyCount ?>">
<?php echo $historial_atencion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($historial_atencion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fhistorial_atenciongrid">
</div>
<?php

// Close recordset
if ($historial_atencion_grid->Recordset)
	$historial_atencion_grid->Recordset->Close();
?>
<?php if ($historial_atencion_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($historial_atencion_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($historial_atencion_grid->TotalRecs == 0 && $historial_atencion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($historial_atencion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($historial_atencion->Export == "") { ?>
<script type="text/javascript">
fhistorial_atenciongrid.Init();
</script>
<?php } ?>
<?php
$historial_atencion_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$historial_atencion_grid->Page_Terminate();
?>
