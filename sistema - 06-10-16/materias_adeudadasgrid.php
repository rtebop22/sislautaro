<?php

// Create page object
if (!isset($materias_adeudadas_grid)) $materias_adeudadas_grid = new cmaterias_adeudadas_grid();

// Page init
$materias_adeudadas_grid->Page_Init();

// Page main
$materias_adeudadas_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$materias_adeudadas_grid->Page_Render();
?>
<?php if ($materias_adeudadas->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmaterias_adeudadasgrid = new ew_Form("fmaterias_adeudadasgrid", "grid");
fmaterias_adeudadasgrid.FormKeyCountName = '<?php echo $materias_adeudadas_grid->FormKeyCountName ?>';

// Validate form
fmaterias_adeudadasgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $materias_adeudadas->Dni->FldCaption(), $materias_adeudadas->Dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($materias_adeudadas->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Materia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $materias_adeudadas->Id_Materia->FldCaption(), $materias_adeudadas->Id_Materia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Materia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($materias_adeudadas->Id_Materia->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmaterias_adeudadasgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Dni", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Materia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Observacion", false)) return false;
	return true;
}

// Form_CustomValidate event
fmaterias_adeudadasgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmaterias_adeudadasgrid.ValidateRequired = true;
<?php } else { ?>
fmaterias_adeudadasgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($materias_adeudadas->CurrentAction == "gridadd") {
	if ($materias_adeudadas->CurrentMode == "copy") {
		$bSelectLimit = $materias_adeudadas_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$materias_adeudadas_grid->TotalRecs = $materias_adeudadas->SelectRecordCount();
			$materias_adeudadas_grid->Recordset = $materias_adeudadas_grid->LoadRecordset($materias_adeudadas_grid->StartRec-1, $materias_adeudadas_grid->DisplayRecs);
		} else {
			if ($materias_adeudadas_grid->Recordset = $materias_adeudadas_grid->LoadRecordset())
				$materias_adeudadas_grid->TotalRecs = $materias_adeudadas_grid->Recordset->RecordCount();
		}
		$materias_adeudadas_grid->StartRec = 1;
		$materias_adeudadas_grid->DisplayRecs = $materias_adeudadas_grid->TotalRecs;
	} else {
		$materias_adeudadas->CurrentFilter = "0=1";
		$materias_adeudadas_grid->StartRec = 1;
		$materias_adeudadas_grid->DisplayRecs = $materias_adeudadas->GridAddRowCount;
	}
	$materias_adeudadas_grid->TotalRecs = $materias_adeudadas_grid->DisplayRecs;
	$materias_adeudadas_grid->StopRec = $materias_adeudadas_grid->DisplayRecs;
} else {
	$bSelectLimit = $materias_adeudadas_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($materias_adeudadas_grid->TotalRecs <= 0)
			$materias_adeudadas_grid->TotalRecs = $materias_adeudadas->SelectRecordCount();
	} else {
		if (!$materias_adeudadas_grid->Recordset && ($materias_adeudadas_grid->Recordset = $materias_adeudadas_grid->LoadRecordset()))
			$materias_adeudadas_grid->TotalRecs = $materias_adeudadas_grid->Recordset->RecordCount();
	}
	$materias_adeudadas_grid->StartRec = 1;
	$materias_adeudadas_grid->DisplayRecs = $materias_adeudadas_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$materias_adeudadas_grid->Recordset = $materias_adeudadas_grid->LoadRecordset($materias_adeudadas_grid->StartRec-1, $materias_adeudadas_grid->DisplayRecs);

	// Set no record found message
	if ($materias_adeudadas->CurrentAction == "" && $materias_adeudadas_grid->TotalRecs == 0) {
		if ($materias_adeudadas_grid->SearchWhere == "0=101")
			$materias_adeudadas_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$materias_adeudadas_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$materias_adeudadas_grid->RenderOtherOptions();
?>
<?php $materias_adeudadas_grid->ShowPageHeader(); ?>
<?php
$materias_adeudadas_grid->ShowMessage();
?>
<?php if ($materias_adeudadas_grid->TotalRecs > 0 || $materias_adeudadas->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid materias_adeudadas">
<div id="fmaterias_adeudadasgrid" class="ewForm form-inline">
<div id="gmp_materias_adeudadas" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_materias_adeudadasgrid" class="table ewTable">
<?php echo $materias_adeudadas->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$materias_adeudadas_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$materias_adeudadas_grid->RenderListOptions();

// Render list options (header, left)
$materias_adeudadas_grid->ListOptions->Render("header", "left");
?>
<?php if ($materias_adeudadas->Dni->Visible) { // Dni ?>
	<?php if ($materias_adeudadas->SortUrl($materias_adeudadas->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_materias_adeudadas_Dni" class="materias_adeudadas_Dni"><div class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div><div id="elh_materias_adeudadas_Dni" class="materias_adeudadas_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Dni->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($materias_adeudadas->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($materias_adeudadas->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($materias_adeudadas->Id_Materia->Visible) { // Id_Materia ?>
	<?php if ($materias_adeudadas->SortUrl($materias_adeudadas->Id_Materia) == "") { ?>
		<th data-name="Id_Materia"><div id="elh_materias_adeudadas_Id_Materia" class="materias_adeudadas_Id_Materia"><div class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Id_Materia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Materia"><div><div id="elh_materias_adeudadas_Id_Materia" class="materias_adeudadas_Id_Materia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Id_Materia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($materias_adeudadas->Id_Materia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($materias_adeudadas->Id_Materia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($materias_adeudadas->Observacion->Visible) { // Observacion ?>
	<?php if ($materias_adeudadas->SortUrl($materias_adeudadas->Observacion) == "") { ?>
		<th data-name="Observacion"><div id="elh_materias_adeudadas_Observacion" class="materias_adeudadas_Observacion"><div class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Observacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Observacion"><div><div id="elh_materias_adeudadas_Observacion" class="materias_adeudadas_Observacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Observacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($materias_adeudadas->Observacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($materias_adeudadas->Observacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($materias_adeudadas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($materias_adeudadas->SortUrl($materias_adeudadas->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_materias_adeudadas_Fecha_Actualizacion" class="materias_adeudadas_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_materias_adeudadas_Fecha_Actualizacion" class="materias_adeudadas_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $materias_adeudadas->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($materias_adeudadas->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($materias_adeudadas->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($materias_adeudadas->User_Actualiz->Visible) { // User_Actualiz ?>
	<?php if ($materias_adeudadas->SortUrl($materias_adeudadas->User_Actualiz) == "") { ?>
		<th data-name="User_Actualiz"><div id="elh_materias_adeudadas_User_Actualiz" class="materias_adeudadas_User_Actualiz"><div class="ewTableHeaderCaption"><?php echo $materias_adeudadas->User_Actualiz->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="User_Actualiz"><div><div id="elh_materias_adeudadas_User_Actualiz" class="materias_adeudadas_User_Actualiz">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $materias_adeudadas->User_Actualiz->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($materias_adeudadas->User_Actualiz->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($materias_adeudadas->User_Actualiz->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$materias_adeudadas_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$materias_adeudadas_grid->StartRec = 1;
$materias_adeudadas_grid->StopRec = $materias_adeudadas_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($materias_adeudadas_grid->FormKeyCountName) && ($materias_adeudadas->CurrentAction == "gridadd" || $materias_adeudadas->CurrentAction == "gridedit" || $materias_adeudadas->CurrentAction == "F")) {
		$materias_adeudadas_grid->KeyCount = $objForm->GetValue($materias_adeudadas_grid->FormKeyCountName);
		$materias_adeudadas_grid->StopRec = $materias_adeudadas_grid->StartRec + $materias_adeudadas_grid->KeyCount - 1;
	}
}
$materias_adeudadas_grid->RecCnt = $materias_adeudadas_grid->StartRec - 1;
if ($materias_adeudadas_grid->Recordset && !$materias_adeudadas_grid->Recordset->EOF) {
	$materias_adeudadas_grid->Recordset->MoveFirst();
	$bSelectLimit = $materias_adeudadas_grid->UseSelectLimit;
	if (!$bSelectLimit && $materias_adeudadas_grid->StartRec > 1)
		$materias_adeudadas_grid->Recordset->Move($materias_adeudadas_grid->StartRec - 1);
} elseif (!$materias_adeudadas->AllowAddDeleteRow && $materias_adeudadas_grid->StopRec == 0) {
	$materias_adeudadas_grid->StopRec = $materias_adeudadas->GridAddRowCount;
}

// Initialize aggregate
$materias_adeudadas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$materias_adeudadas->ResetAttrs();
$materias_adeudadas_grid->RenderRow();
if ($materias_adeudadas->CurrentAction == "gridadd")
	$materias_adeudadas_grid->RowIndex = 0;
if ($materias_adeudadas->CurrentAction == "gridedit")
	$materias_adeudadas_grid->RowIndex = 0;
while ($materias_adeudadas_grid->RecCnt < $materias_adeudadas_grid->StopRec) {
	$materias_adeudadas_grid->RecCnt++;
	if (intval($materias_adeudadas_grid->RecCnt) >= intval($materias_adeudadas_grid->StartRec)) {
		$materias_adeudadas_grid->RowCnt++;
		if ($materias_adeudadas->CurrentAction == "gridadd" || $materias_adeudadas->CurrentAction == "gridedit" || $materias_adeudadas->CurrentAction == "F") {
			$materias_adeudadas_grid->RowIndex++;
			$objForm->Index = $materias_adeudadas_grid->RowIndex;
			if ($objForm->HasValue($materias_adeudadas_grid->FormActionName))
				$materias_adeudadas_grid->RowAction = strval($objForm->GetValue($materias_adeudadas_grid->FormActionName));
			elseif ($materias_adeudadas->CurrentAction == "gridadd")
				$materias_adeudadas_grid->RowAction = "insert";
			else
				$materias_adeudadas_grid->RowAction = "";
		}

		// Set up key count
		$materias_adeudadas_grid->KeyCount = $materias_adeudadas_grid->RowIndex;

		// Init row class and style
		$materias_adeudadas->ResetAttrs();
		$materias_adeudadas->CssClass = "";
		if ($materias_adeudadas->CurrentAction == "gridadd") {
			if ($materias_adeudadas->CurrentMode == "copy") {
				$materias_adeudadas_grid->LoadRowValues($materias_adeudadas_grid->Recordset); // Load row values
				$materias_adeudadas_grid->SetRecordKey($materias_adeudadas_grid->RowOldKey, $materias_adeudadas_grid->Recordset); // Set old record key
			} else {
				$materias_adeudadas_grid->LoadDefaultValues(); // Load default values
				$materias_adeudadas_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$materias_adeudadas_grid->LoadRowValues($materias_adeudadas_grid->Recordset); // Load row values
		}
		$materias_adeudadas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($materias_adeudadas->CurrentAction == "gridadd") // Grid add
			$materias_adeudadas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($materias_adeudadas->CurrentAction == "gridadd" && $materias_adeudadas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$materias_adeudadas_grid->RestoreCurrentRowFormValues($materias_adeudadas_grid->RowIndex); // Restore form values
		if ($materias_adeudadas->CurrentAction == "gridedit") { // Grid edit
			if ($materias_adeudadas->EventCancelled) {
				$materias_adeudadas_grid->RestoreCurrentRowFormValues($materias_adeudadas_grid->RowIndex); // Restore form values
			}
			if ($materias_adeudadas_grid->RowAction == "insert")
				$materias_adeudadas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$materias_adeudadas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($materias_adeudadas->CurrentAction == "gridedit" && ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT || $materias_adeudadas->RowType == EW_ROWTYPE_ADD) && $materias_adeudadas->EventCancelled) // Update failed
			$materias_adeudadas_grid->RestoreCurrentRowFormValues($materias_adeudadas_grid->RowIndex); // Restore form values
		if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$materias_adeudadas_grid->EditRowCnt++;
		if ($materias_adeudadas->CurrentAction == "F") // Confirm row
			$materias_adeudadas_grid->RestoreCurrentRowFormValues($materias_adeudadas_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$materias_adeudadas->RowAttrs = array_merge($materias_adeudadas->RowAttrs, array('data-rowindex'=>$materias_adeudadas_grid->RowCnt, 'id'=>'r' . $materias_adeudadas_grid->RowCnt . '_materias_adeudadas', 'data-rowtype'=>$materias_adeudadas->RowType));

		// Render row
		$materias_adeudadas_grid->RenderRow();

		// Render list options
		$materias_adeudadas_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($materias_adeudadas_grid->RowAction <> "delete" && $materias_adeudadas_grid->RowAction <> "insertdelete" && !($materias_adeudadas_grid->RowAction == "insert" && $materias_adeudadas->CurrentAction == "F" && $materias_adeudadas_grid->EmptyRow())) {
?>
	<tr<?php echo $materias_adeudadas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$materias_adeudadas_grid->ListOptions->Render("body", "left", $materias_adeudadas_grid->RowCnt);
?>
	<?php if ($materias_adeudadas->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $materias_adeudadas->Dni->CellAttributes() ?>>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($materias_adeudadas->Dni->getSessionValue() <> "") { ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<span<?php echo $materias_adeudadas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Dni->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<input type="text" data-table="materias_adeudadas" data-field="x_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Dni->EditValue ?>"<?php echo $materias_adeudadas->Dni->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Dni" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($materias_adeudadas->Dni->getSessionValue() <> "") { ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<span<?php echo $materias_adeudadas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Dni->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<input type="text" data-table="materias_adeudadas" data-field="x_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Dni->EditValue ?>"<?php echo $materias_adeudadas->Dni->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Dni" class="materias_adeudadas_Dni">
<span<?php echo $materias_adeudadas->Dni->ViewAttributes() ?>>
<?php echo $materias_adeudadas->Dni->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->FormValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_Dni" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->OldValue) ?>">
<?php } ?>
<a id="<?php echo $materias_adeudadas_grid->PageObjName . "_row_" . $materias_adeudadas_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Mat_Adeuda" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Mat_Adeuda->CurrentValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Mat_Adeuda" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Mat_Adeuda->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT || $materias_adeudadas->CurrentMode == "edit") { ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Mat_Adeuda" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Mat_Adeuda" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Mat_Adeuda->CurrentValue) ?>">
<?php } ?>
	<?php if ($materias_adeudadas->Id_Materia->Visible) { // Id_Materia ?>
		<td data-name="Id_Materia"<?php echo $materias_adeudadas->Id_Materia->CellAttributes() ?>>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Id_Materia" class="form-group materias_adeudadas_Id_Materia">
<input type="text" data-table="materias_adeudadas" data-field="x_Id_Materia" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Id_Materia->EditValue ?>"<?php echo $materias_adeudadas->Id_Materia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Materia" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Id_Materia" class="form-group materias_adeudadas_Id_Materia">
<input type="text" data-table="materias_adeudadas" data-field="x_Id_Materia" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Id_Materia->EditValue ?>"<?php echo $materias_adeudadas->Id_Materia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Id_Materia" class="materias_adeudadas_Id_Materia">
<span<?php echo $materias_adeudadas->Id_Materia->ViewAttributes() ?>>
<?php echo $materias_adeudadas->Id_Materia->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Materia" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->FormValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Materia" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion"<?php echo $materias_adeudadas->Observacion->CellAttributes() ?>>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Observacion" class="form-group materias_adeudadas_Observacion">
<textarea data-table="materias_adeudadas" data-field="x_Observacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->getPlaceHolder()) ?>"<?php echo $materias_adeudadas->Observacion->EditAttributes() ?>><?php echo $materias_adeudadas->Observacion->EditValue ?></textarea>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Observacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Observacion" class="form-group materias_adeudadas_Observacion">
<textarea data-table="materias_adeudadas" data-field="x_Observacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->getPlaceHolder()) ?>"<?php echo $materias_adeudadas->Observacion->EditAttributes() ?>><?php echo $materias_adeudadas->Observacion->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Observacion" class="materias_adeudadas_Observacion">
<span<?php echo $materias_adeudadas->Observacion->ViewAttributes() ?>>
<?php echo $materias_adeudadas->Observacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Observacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->FormValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_Observacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $materias_adeudadas->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Fecha_Actualizacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_Fecha_Actualizacion" class="materias_adeudadas_Fecha_Actualizacion">
<span<?php echo $materias_adeudadas->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $materias_adeudadas->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Fecha_Actualizacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_Fecha_Actualizacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->User_Actualiz->Visible) { // User_Actualiz ?>
		<td data-name="User_Actualiz"<?php echo $materias_adeudadas->User_Actualiz->CellAttributes() ?>>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_User_Actualiz" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" value="<?php echo ew_HtmlEncode($materias_adeudadas->User_Actualiz->OldValue) ?>">
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $materias_adeudadas_grid->RowCnt ?>_materias_adeudadas_User_Actualiz" class="materias_adeudadas_User_Actualiz">
<span<?php echo $materias_adeudadas->User_Actualiz->ViewAttributes() ?>>
<?php echo $materias_adeudadas->User_Actualiz->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_User_Actualiz" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" value="<?php echo ew_HtmlEncode($materias_adeudadas->User_Actualiz->FormValue) ?>">
<input type="hidden" data-table="materias_adeudadas" data-field="x_User_Actualiz" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" value="<?php echo ew_HtmlEncode($materias_adeudadas->User_Actualiz->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$materias_adeudadas_grid->ListOptions->Render("body", "right", $materias_adeudadas_grid->RowCnt);
?>
	</tr>
<?php if ($materias_adeudadas->RowType == EW_ROWTYPE_ADD || $materias_adeudadas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmaterias_adeudadasgrid.UpdateOpts(<?php echo $materias_adeudadas_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($materias_adeudadas->CurrentAction <> "gridadd" || $materias_adeudadas->CurrentMode == "copy")
		if (!$materias_adeudadas_grid->Recordset->EOF) $materias_adeudadas_grid->Recordset->MoveNext();
}
?>
<?php
	if ($materias_adeudadas->CurrentMode == "add" || $materias_adeudadas->CurrentMode == "copy" || $materias_adeudadas->CurrentMode == "edit") {
		$materias_adeudadas_grid->RowIndex = '$rowindex$';
		$materias_adeudadas_grid->LoadDefaultValues();

		// Set row properties
		$materias_adeudadas->ResetAttrs();
		$materias_adeudadas->RowAttrs = array_merge($materias_adeudadas->RowAttrs, array('data-rowindex'=>$materias_adeudadas_grid->RowIndex, 'id'=>'r0_materias_adeudadas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($materias_adeudadas->RowAttrs["class"], "ewTemplate");
		$materias_adeudadas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$materias_adeudadas_grid->RenderRow();

		// Render list options
		$materias_adeudadas_grid->RenderListOptions();
		$materias_adeudadas_grid->StartRowCnt = 0;
?>
	<tr<?php echo $materias_adeudadas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$materias_adeudadas_grid->ListOptions->Render("body", "left", $materias_adeudadas_grid->RowIndex);
?>
	<?php if ($materias_adeudadas->Dni->Visible) { // Dni ?>
		<td data-name="Dni">
<?php if ($materias_adeudadas->CurrentAction <> "F") { ?>
<?php if ($materias_adeudadas->Dni->getSessionValue() <> "") { ?>
<span id="el$rowindex$_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<span<?php echo $materias_adeudadas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Dni->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<input type="text" data-table="materias_adeudadas" data-field="x_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Dni->EditValue ?>"<?php echo $materias_adeudadas->Dni->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_materias_adeudadas_Dni" class="form-group materias_adeudadas_Dni">
<span<?php echo $materias_adeudadas->Dni->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Dni->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Dni" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Dni" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Dni" value="<?php echo ew_HtmlEncode($materias_adeudadas->Dni->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->Id_Materia->Visible) { // Id_Materia ?>
		<td data-name="Id_Materia">
<?php if ($materias_adeudadas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_materias_adeudadas_Id_Materia" class="form-group materias_adeudadas_Id_Materia">
<input type="text" data-table="materias_adeudadas" data-field="x_Id_Materia" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" size="30" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->getPlaceHolder()) ?>" value="<?php echo $materias_adeudadas->Id_Materia->EditValue ?>"<?php echo $materias_adeudadas->Id_Materia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_materias_adeudadas_Id_Materia" class="form-group materias_adeudadas_Id_Materia">
<span<?php echo $materias_adeudadas->Id_Materia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Id_Materia->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Materia" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Id_Materia" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Id_Materia" value="<?php echo ew_HtmlEncode($materias_adeudadas->Id_Materia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<?php if ($materias_adeudadas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_materias_adeudadas_Observacion" class="form-group materias_adeudadas_Observacion">
<textarea data-table="materias_adeudadas" data-field="x_Observacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->getPlaceHolder()) ?>"<?php echo $materias_adeudadas->Observacion->EditAttributes() ?>><?php echo $materias_adeudadas->Observacion->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_materias_adeudadas_Observacion" class="form-group materias_adeudadas_Observacion">
<span<?php echo $materias_adeudadas->Observacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $materias_adeudadas->Observacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Observacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Observacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($materias_adeudadas->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Fecha_Actualizacion" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_Fecha_Actualizacion" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($materias_adeudadas->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($materias_adeudadas->User_Actualiz->Visible) { // User_Actualiz ?>
		<td data-name="User_Actualiz">
<?php if ($materias_adeudadas->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_User_Actualiz" name="x<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" id="x<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" value="<?php echo ew_HtmlEncode($materias_adeudadas->User_Actualiz->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="materias_adeudadas" data-field="x_User_Actualiz" name="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" id="o<?php echo $materias_adeudadas_grid->RowIndex ?>_User_Actualiz" value="<?php echo ew_HtmlEncode($materias_adeudadas->User_Actualiz->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$materias_adeudadas_grid->ListOptions->Render("body", "right", $materias_adeudadas_grid->RowCnt);
?>
<script type="text/javascript">
fmaterias_adeudadasgrid.UpdateOpts(<?php echo $materias_adeudadas_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($materias_adeudadas->CurrentMode == "add" || $materias_adeudadas->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $materias_adeudadas_grid->FormKeyCountName ?>" id="<?php echo $materias_adeudadas_grid->FormKeyCountName ?>" value="<?php echo $materias_adeudadas_grid->KeyCount ?>">
<?php echo $materias_adeudadas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($materias_adeudadas->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $materias_adeudadas_grid->FormKeyCountName ?>" id="<?php echo $materias_adeudadas_grid->FormKeyCountName ?>" value="<?php echo $materias_adeudadas_grid->KeyCount ?>">
<?php echo $materias_adeudadas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($materias_adeudadas->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmaterias_adeudadasgrid">
</div>
<?php

// Close recordset
if ($materias_adeudadas_grid->Recordset)
	$materias_adeudadas_grid->Recordset->Close();
?>
<?php if ($materias_adeudadas_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($materias_adeudadas_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($materias_adeudadas_grid->TotalRecs == 0 && $materias_adeudadas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($materias_adeudadas_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($materias_adeudadas->Export == "") { ?>
<script type="text/javascript">
fmaterias_adeudadasgrid.Init();
</script>
<?php } ?>
<?php
$materias_adeudadas_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$materias_adeudadas_grid->Page_Terminate();
?>
