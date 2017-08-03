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
	if (ew_ValueChanged(fobj, infix, "Id_Ubicacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Sit_Estado", false)) return false;
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
