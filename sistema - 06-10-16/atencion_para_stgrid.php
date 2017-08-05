<?php

// Create page object
if (!isset($atencion_para_st_grid)) $atencion_para_st_grid = new catencion_para_st_grid();

// Page init
$atencion_para_st_grid->Page_Init();

// Page main
$atencion_para_st_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_para_st_grid->Page_Render();
?>
<?php if ($atencion_para_st->Export == "") { ?>
<script type="text/javascript">

// Form object
var fatencion_para_stgrid = new ew_Form("fatencion_para_stgrid", "grid");
fatencion_para_stgrid.FormKeyCountName = '<?php echo $atencion_para_st_grid->FormKeyCountName ?>';

// Validate form
fatencion_para_stgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nro_Tiket");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Nro_Tiket->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Retiro");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->Id_Tipo_Retiro->FldCaption(), $atencion_para_st->Id_Tipo_Retiro->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Retiro");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Retiro->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Devolucion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Devolucion->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fatencion_para_stgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Nro_Tiket", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Retiro", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Retiro", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Observacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Devolucion", false)) return false;
	return true;
}

// Form_CustomValidate event
fatencion_para_stgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_para_stgrid.ValidateRequired = true;
<?php } else { ?>
fatencion_para_stgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_para_stgrid.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
</script>
<?php } ?>
<?php
if ($atencion_para_st->CurrentAction == "gridadd") {
	if ($atencion_para_st->CurrentMode == "copy") {
		$bSelectLimit = $atencion_para_st_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$atencion_para_st_grid->TotalRecs = $atencion_para_st->SelectRecordCount();
			$atencion_para_st_grid->Recordset = $atencion_para_st_grid->LoadRecordset($atencion_para_st_grid->StartRec-1, $atencion_para_st_grid->DisplayRecs);
		} else {
			if ($atencion_para_st_grid->Recordset = $atencion_para_st_grid->LoadRecordset())
				$atencion_para_st_grid->TotalRecs = $atencion_para_st_grid->Recordset->RecordCount();
		}
		$atencion_para_st_grid->StartRec = 1;
		$atencion_para_st_grid->DisplayRecs = $atencion_para_st_grid->TotalRecs;
	} else {
		$atencion_para_st->CurrentFilter = "0=1";
		$atencion_para_st_grid->StartRec = 1;
		$atencion_para_st_grid->DisplayRecs = $atencion_para_st->GridAddRowCount;
	}
	$atencion_para_st_grid->TotalRecs = $atencion_para_st_grid->DisplayRecs;
	$atencion_para_st_grid->StopRec = $atencion_para_st_grid->DisplayRecs;
} else {
	$bSelectLimit = $atencion_para_st_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($atencion_para_st_grid->TotalRecs <= 0)
			$atencion_para_st_grid->TotalRecs = $atencion_para_st->SelectRecordCount();
	} else {
		if (!$atencion_para_st_grid->Recordset && ($atencion_para_st_grid->Recordset = $atencion_para_st_grid->LoadRecordset()))
			$atencion_para_st_grid->TotalRecs = $atencion_para_st_grid->Recordset->RecordCount();
	}
	$atencion_para_st_grid->StartRec = 1;
	$atencion_para_st_grid->DisplayRecs = $atencion_para_st_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$atencion_para_st_grid->Recordset = $atencion_para_st_grid->LoadRecordset($atencion_para_st_grid->StartRec-1, $atencion_para_st_grid->DisplayRecs);

	// Set no record found message
	if ($atencion_para_st->CurrentAction == "" && $atencion_para_st_grid->TotalRecs == 0) {
		if ($atencion_para_st_grid->SearchWhere == "0=101")
			$atencion_para_st_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$atencion_para_st_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$atencion_para_st_grid->RenderOtherOptions();
?>
<?php $atencion_para_st_grid->ShowPageHeader(); ?>
<?php
$atencion_para_st_grid->ShowMessage();
?>
<?php if ($atencion_para_st_grid->TotalRecs > 0 || $atencion_para_st->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid atencion_para_st">
<div id="fatencion_para_stgrid" class="ewForm form-inline">
<div id="gmp_atencion_para_st" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_atencion_para_stgrid" class="table ewTable">
<?php echo $atencion_para_st->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$atencion_para_st_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$atencion_para_st_grid->RenderListOptions();

// Render list options (header, left)
$atencion_para_st_grid->ListOptions->Render("header", "left");
?>
<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Nro_Tiket) == "") { ?>
		<th data-name="Nro_Tiket"><div id="elh_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Tiket"><div><div id="elh_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Nro_Tiket->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Nro_Tiket->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Id_Tipo_Retiro) == "") { ?>
		<th data-name="Id_Tipo_Retiro"><div id="elh_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Retiro"><div><div id="elh_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Id_Tipo_Retiro->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Id_Tipo_Retiro->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Fecha_Retiro) == "") { ?>
		<th data-name="Fecha_Retiro"><div id="elh_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Retiro"><div><div id="elh_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Fecha_Retiro->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Fecha_Retiro->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Observacion) == "") { ?>
		<th data-name="Observacion"><div id="elh_atencion_para_st_Observacion" class="atencion_para_st_Observacion"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Observacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Observacion"><div><div id="elh_atencion_para_st_Observacion" class="atencion_para_st_Observacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Observacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Observacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Observacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Fecha_Devolucion) == "") { ?>
		<th data-name="Fecha_Devolucion"><div id="elh_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Devolucion"><div><div id="elh_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Fecha_Devolucion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Fecha_Devolucion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$atencion_para_st_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$atencion_para_st_grid->StartRec = 1;
$atencion_para_st_grid->StopRec = $atencion_para_st_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($atencion_para_st_grid->FormKeyCountName) && ($atencion_para_st->CurrentAction == "gridadd" || $atencion_para_st->CurrentAction == "gridedit" || $atencion_para_st->CurrentAction == "F")) {
		$atencion_para_st_grid->KeyCount = $objForm->GetValue($atencion_para_st_grid->FormKeyCountName);
		$atencion_para_st_grid->StopRec = $atencion_para_st_grid->StartRec + $atencion_para_st_grid->KeyCount - 1;
	}
}
$atencion_para_st_grid->RecCnt = $atencion_para_st_grid->StartRec - 1;
if ($atencion_para_st_grid->Recordset && !$atencion_para_st_grid->Recordset->EOF) {
	$atencion_para_st_grid->Recordset->MoveFirst();
	$bSelectLimit = $atencion_para_st_grid->UseSelectLimit;
	if (!$bSelectLimit && $atencion_para_st_grid->StartRec > 1)
		$atencion_para_st_grid->Recordset->Move($atencion_para_st_grid->StartRec - 1);
} elseif (!$atencion_para_st->AllowAddDeleteRow && $atencion_para_st_grid->StopRec == 0) {
	$atencion_para_st_grid->StopRec = $atencion_para_st->GridAddRowCount;
}

// Initialize aggregate
$atencion_para_st->RowType = EW_ROWTYPE_AGGREGATEINIT;
$atencion_para_st->ResetAttrs();
$atencion_para_st_grid->RenderRow();
if ($atencion_para_st->CurrentAction == "gridadd")
	$atencion_para_st_grid->RowIndex = 0;
if ($atencion_para_st->CurrentAction == "gridedit")
	$atencion_para_st_grid->RowIndex = 0;
while ($atencion_para_st_grid->RecCnt < $atencion_para_st_grid->StopRec) {
	$atencion_para_st_grid->RecCnt++;
	if (intval($atencion_para_st_grid->RecCnt) >= intval($atencion_para_st_grid->StartRec)) {
		$atencion_para_st_grid->RowCnt++;
		if ($atencion_para_st->CurrentAction == "gridadd" || $atencion_para_st->CurrentAction == "gridedit" || $atencion_para_st->CurrentAction == "F") {
			$atencion_para_st_grid->RowIndex++;
			$objForm->Index = $atencion_para_st_grid->RowIndex;
			if ($objForm->HasValue($atencion_para_st_grid->FormActionName))
				$atencion_para_st_grid->RowAction = strval($objForm->GetValue($atencion_para_st_grid->FormActionName));
			elseif ($atencion_para_st->CurrentAction == "gridadd")
				$atencion_para_st_grid->RowAction = "insert";
			else
				$atencion_para_st_grid->RowAction = "";
		}

		// Set up key count
		$atencion_para_st_grid->KeyCount = $atencion_para_st_grid->RowIndex;

		// Init row class and style
		$atencion_para_st->ResetAttrs();
		$atencion_para_st->CssClass = "";
		if ($atencion_para_st->CurrentAction == "gridadd") {
			if ($atencion_para_st->CurrentMode == "copy") {
				$atencion_para_st_grid->LoadRowValues($atencion_para_st_grid->Recordset); // Load row values
				$atencion_para_st_grid->SetRecordKey($atencion_para_st_grid->RowOldKey, $atencion_para_st_grid->Recordset); // Set old record key
			} else {
				$atencion_para_st_grid->LoadDefaultValues(); // Load default values
				$atencion_para_st_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$atencion_para_st_grid->LoadRowValues($atencion_para_st_grid->Recordset); // Load row values
		}
		$atencion_para_st->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($atencion_para_st->CurrentAction == "gridadd") // Grid add
			$atencion_para_st->RowType = EW_ROWTYPE_ADD; // Render add
		if ($atencion_para_st->CurrentAction == "gridadd" && $atencion_para_st->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$atencion_para_st_grid->RestoreCurrentRowFormValues($atencion_para_st_grid->RowIndex); // Restore form values
		if ($atencion_para_st->CurrentAction == "gridedit") { // Grid edit
			if ($atencion_para_st->EventCancelled) {
				$atencion_para_st_grid->RestoreCurrentRowFormValues($atencion_para_st_grid->RowIndex); // Restore form values
			}
			if ($atencion_para_st_grid->RowAction == "insert")
				$atencion_para_st->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$atencion_para_st->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($atencion_para_st->CurrentAction == "gridedit" && ($atencion_para_st->RowType == EW_ROWTYPE_EDIT || $atencion_para_st->RowType == EW_ROWTYPE_ADD) && $atencion_para_st->EventCancelled) // Update failed
			$atencion_para_st_grid->RestoreCurrentRowFormValues($atencion_para_st_grid->RowIndex); // Restore form values
		if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) // Edit row
			$atencion_para_st_grid->EditRowCnt++;
		if ($atencion_para_st->CurrentAction == "F") // Confirm row
			$atencion_para_st_grid->RestoreCurrentRowFormValues($atencion_para_st_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$atencion_para_st->RowAttrs = array_merge($atencion_para_st->RowAttrs, array('data-rowindex'=>$atencion_para_st_grid->RowCnt, 'id'=>'r' . $atencion_para_st_grid->RowCnt . '_atencion_para_st', 'data-rowtype'=>$atencion_para_st->RowType));

		// Render row
		$atencion_para_st_grid->RenderRow();

		// Render list options
		$atencion_para_st_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($atencion_para_st_grid->RowAction <> "delete" && $atencion_para_st_grid->RowAction <> "insertdelete" && !($atencion_para_st_grid->RowAction == "insert" && $atencion_para_st->CurrentAction == "F" && $atencion_para_st_grid->EmptyRow())) {
?>
	<tr<?php echo $atencion_para_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_para_st_grid->ListOptions->Render("body", "left", $atencion_para_st_grid->RowCnt);
?>
	<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
		<td data-name="Nro_Tiket"<?php echo $atencion_para_st->Nro_Tiket->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket">
<span<?php echo $atencion_para_st->Nro_Tiket->ViewAttributes() ?>>
<?php echo $atencion_para_st->Nro_Tiket->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->FormValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
<?php } ?>
<a id="<?php echo $atencion_para_st_grid->PageObjName . "_row_" . $atencion_para_st_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT || $atencion_para_st->CurrentMode == "edit") { ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<?php } ?>
	<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
		<td data-name="Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro">
<span<?php echo $atencion_para_st->Id_Tipo_Retiro->ViewAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->FormValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
		<td data-name="Fecha_Retiro"<?php echo $atencion_para_st->Fecha_Retiro->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro">
<span<?php echo $atencion_para_st->Fecha_Retiro->ViewAttributes() ?>>
<?php echo $atencion_para_st->Fecha_Retiro->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->FormValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion"<?php echo $atencion_para_st->Observacion->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Observacion" class="atencion_para_st_Observacion">
<span<?php echo $atencion_para_st->Observacion->ViewAttributes() ?>>
<?php echo $atencion_para_st->Observacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->FormValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
		<td data-name="Fecha_Devolucion"<?php echo $atencion_para_st->Fecha_Devolucion->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_grid->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion">
<span<?php echo $atencion_para_st->Fecha_Devolucion->ViewAttributes() ?>>
<?php echo $atencion_para_st->Fecha_Devolucion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->FormValue) ?>">
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_para_st_grid->ListOptions->Render("body", "right", $atencion_para_st_grid->RowCnt);
?>
	</tr>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD || $atencion_para_st->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fatencion_para_stgrid.UpdateOpts(<?php echo $atencion_para_st_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($atencion_para_st->CurrentAction <> "gridadd" || $atencion_para_st->CurrentMode == "copy")
		if (!$atencion_para_st_grid->Recordset->EOF) $atencion_para_st_grid->Recordset->MoveNext();
}
?>
<?php
	if ($atencion_para_st->CurrentMode == "add" || $atencion_para_st->CurrentMode == "copy" || $atencion_para_st->CurrentMode == "edit") {
		$atencion_para_st_grid->RowIndex = '$rowindex$';
		$atencion_para_st_grid->LoadDefaultValues();

		// Set row properties
		$atencion_para_st->ResetAttrs();
		$atencion_para_st->RowAttrs = array_merge($atencion_para_st->RowAttrs, array('data-rowindex'=>$atencion_para_st_grid->RowIndex, 'id'=>'r0_atencion_para_st', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($atencion_para_st->RowAttrs["class"], "ewTemplate");
		$atencion_para_st->RowType = EW_ROWTYPE_ADD;

		// Render row
		$atencion_para_st_grid->RenderRow();

		// Render list options
		$atencion_para_st_grid->RenderListOptions();
		$atencion_para_st_grid->StartRowCnt = 0;
?>
	<tr<?php echo $atencion_para_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_para_st_grid->ListOptions->Render("body", "left", $atencion_para_st_grid->RowIndex);
?>
	<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
		<td data-name="Nro_Tiket">
<?php if ($atencion_para_st->CurrentAction <> "F") { ?>
<span id="el$rowindex$_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<span<?php echo $atencion_para_st->Nro_Tiket->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->Nro_Tiket->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
		<td data-name="Id_Tipo_Retiro">
<?php if ($atencion_para_st->CurrentAction <> "F") { ?>
<span id="el$rowindex$_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<span<?php echo $atencion_para_st->Id_Tipo_Retiro->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->Id_Tipo_Retiro->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
		<td data-name="Fecha_Retiro">
<?php if ($atencion_para_st->CurrentAction <> "F") { ?>
<span id="el$rowindex$_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<span<?php echo $atencion_para_st->Fecha_Retiro->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->Fecha_Retiro->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<?php if ($atencion_para_st->CurrentAction <> "F") { ?>
<span id="el$rowindex$_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<span<?php echo $atencion_para_st->Observacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->Observacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
		<td data-name="Fecha_Devolucion">
<?php if ($atencion_para_st->CurrentAction <> "F") { ?>
<span id="el$rowindex$_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stgrid", "x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<span<?php echo $atencion_para_st->Fecha_Devolucion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->Fecha_Devolucion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_grid->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_para_st_grid->ListOptions->Render("body", "right", $atencion_para_st_grid->RowCnt);
?>
<script type="text/javascript">
fatencion_para_stgrid.UpdateOpts(<?php echo $atencion_para_st_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($atencion_para_st->CurrentMode == "add" || $atencion_para_st->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $atencion_para_st_grid->FormKeyCountName ?>" id="<?php echo $atencion_para_st_grid->FormKeyCountName ?>" value="<?php echo $atencion_para_st_grid->KeyCount ?>">
<?php echo $atencion_para_st_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_para_st->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $atencion_para_st_grid->FormKeyCountName ?>" id="<?php echo $atencion_para_st_grid->FormKeyCountName ?>" value="<?php echo $atencion_para_st_grid->KeyCount ?>">
<?php echo $atencion_para_st_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_para_st->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fatencion_para_stgrid">
</div>
<?php

// Close recordset
if ($atencion_para_st_grid->Recordset)
	$atencion_para_st_grid->Recordset->Close();
?>
<?php if ($atencion_para_st_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($atencion_para_st_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($atencion_para_st_grid->TotalRecs == 0 && $atencion_para_st->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_para_st_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($atencion_para_st->Export == "") { ?>
<script type="text/javascript">
fatencion_para_stgrid.Init();
</script>
<?php } ?>
<?php
$atencion_para_st_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$atencion_para_st_grid->Page_Terminate();
?>
