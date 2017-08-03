<?php

// Create page object
if (!isset($tutores_grid)) $tutores_grid = new ctutores_grid();

// Page init
$tutores_grid->Page_Init();

// Page main
$tutores_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tutores_grid->Page_Render();
?>
<?php if ($tutores->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftutoresgrid = new ew_Form("ftutoresgrid", "grid");
ftutoresgrid.FormKeyCountName = '<?php echo $tutores_grid->FormKeyCountName ?>';

// Validate form
ftutoresgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Dni_Tutor->FldCaption(), $tutores->Dni_Tutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dni_Tutor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tutores->Dni_Tutor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Relacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Relacion->FldCaption(), $tutores->Id_Relacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Departamento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tutores->Id_Departamento->FldCaption(), $tutores->Id_Departamento->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftutoresgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Dni_Tutor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Apellidos_Nombres", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Domicilio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tel_Contacto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil", false)) return false;
	if (ew_ValueChanged(fobj, infix, "MasHijos", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Relacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Departamento", false)) return false;
	return true;
}

// Form_CustomValidate event
ftutoresgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftutoresgrid.ValidateRequired = true;
<?php } else { ?>
ftutoresgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftutoresgrid.Lists["x_MasHijos"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftutoresgrid.Lists["x_MasHijos"].Options = <?php echo json_encode($tutores->MasHijos->Options()) ?>;
ftutoresgrid.Lists["x_Id_Relacion"] = {"LinkField":"x_Id_Relacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_Desripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_relacion_alumno_tutor"};
ftutoresgrid.Lists["x_Id_Departamento"] = {"LinkField":"x_Id_Departamento","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"ChildFields":["x_Id_Localidad"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departamento"};

// Form object for search
</script>
<?php } ?>
<?php
if ($tutores->CurrentAction == "gridadd") {
	if ($tutores->CurrentMode == "copy") {
		$bSelectLimit = $tutores_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tutores_grid->TotalRecs = $tutores->SelectRecordCount();
			$tutores_grid->Recordset = $tutores_grid->LoadRecordset($tutores_grid->StartRec-1, $tutores_grid->DisplayRecs);
		} else {
			if ($tutores_grid->Recordset = $tutores_grid->LoadRecordset())
				$tutores_grid->TotalRecs = $tutores_grid->Recordset->RecordCount();
		}
		$tutores_grid->StartRec = 1;
		$tutores_grid->DisplayRecs = $tutores_grid->TotalRecs;
	} else {
		$tutores->CurrentFilter = "0=1";
		$tutores_grid->StartRec = 1;
		$tutores_grid->DisplayRecs = $tutores->GridAddRowCount;
	}
	$tutores_grid->TotalRecs = $tutores_grid->DisplayRecs;
	$tutores_grid->StopRec = $tutores_grid->DisplayRecs;
} else {
	$bSelectLimit = $tutores_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tutores_grid->TotalRecs <= 0)
			$tutores_grid->TotalRecs = $tutores->SelectRecordCount();
	} else {
		if (!$tutores_grid->Recordset && ($tutores_grid->Recordset = $tutores_grid->LoadRecordset()))
			$tutores_grid->TotalRecs = $tutores_grid->Recordset->RecordCount();
	}
	$tutores_grid->StartRec = 1;
	$tutores_grid->DisplayRecs = $tutores_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tutores_grid->Recordset = $tutores_grid->LoadRecordset($tutores_grid->StartRec-1, $tutores_grid->DisplayRecs);

	// Set no record found message
	if ($tutores->CurrentAction == "" && $tutores_grid->TotalRecs == 0) {
		if ($tutores_grid->SearchWhere == "0=101")
			$tutores_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tutores_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tutores_grid->RenderOtherOptions();
?>
<?php $tutores_grid->ShowPageHeader(); ?>
<?php
$tutores_grid->ShowMessage();
?>
<?php if ($tutores_grid->TotalRecs > 0 || $tutores->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tutores">
<div id="ftutoresgrid" class="ewForm form-inline">
<div id="gmp_tutores" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tutoresgrid" class="table ewTable">
<?php echo $tutores->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tutores_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tutores_grid->RenderListOptions();

// Render list options (header, left)
$tutores_grid->ListOptions->Render("header", "left");
?>
<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
	<?php if ($tutores->SortUrl($tutores->Dni_Tutor) == "") { ?>
		<th data-name="Dni_Tutor"><div id="elh_tutores_Dni_Tutor" class="tutores_Dni_Tutor"><div class="ewTableHeaderCaption"><?php echo $tutores->Dni_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni_Tutor"><div><div id="elh_tutores_Dni_Tutor" class="tutores_Dni_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Dni_Tutor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Dni_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Dni_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
	<?php if ($tutores->SortUrl($tutores->Apellidos_Nombres) == "") { ?>
		<th data-name="Apellidos_Nombres"><div id="elh_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres"><div class="ewTableHeaderCaption"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellidos_Nombres"><div><div id="elh_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Apellidos_Nombres->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Apellidos_Nombres->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Apellidos_Nombres->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Domicilio->Visible) { // Domicilio ?>
	<?php if ($tutores->SortUrl($tutores->Domicilio) == "") { ?>
		<th data-name="Domicilio"><div id="elh_tutores_Domicilio" class="tutores_Domicilio"><div class="ewTableHeaderCaption"><?php echo $tutores->Domicilio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Domicilio"><div><div id="elh_tutores_Domicilio" class="tutores_Domicilio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Domicilio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Domicilio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Domicilio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
	<?php if ($tutores->SortUrl($tutores->Tel_Contacto) == "") { ?>
		<th data-name="Tel_Contacto"><div id="elh_tutores_Tel_Contacto" class="tutores_Tel_Contacto"><div class="ewTableHeaderCaption"><?php echo $tutores->Tel_Contacto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tel_Contacto"><div><div id="elh_tutores_Tel_Contacto" class="tutores_Tel_Contacto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Tel_Contacto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Tel_Contacto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Tel_Contacto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Cuil->Visible) { // Cuil ?>
	<?php if ($tutores->SortUrl($tutores->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_tutores_Cuil" class="tutores_Cuil"><div class="ewTableHeaderCaption"><?php echo $tutores->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div><div id="elh_tutores_Cuil" class="tutores_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Cuil->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->MasHijos->Visible) { // MasHijos ?>
	<?php if ($tutores->SortUrl($tutores->MasHijos) == "") { ?>
		<th data-name="MasHijos"><div id="elh_tutores_MasHijos" class="tutores_MasHijos"><div class="ewTableHeaderCaption"><?php echo $tutores->MasHijos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MasHijos"><div><div id="elh_tutores_MasHijos" class="tutores_MasHijos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->MasHijos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->MasHijos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->MasHijos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
	<?php if ($tutores->SortUrl($tutores->Id_Relacion) == "") { ?>
		<th data-name="Id_Relacion"><div id="elh_tutores_Id_Relacion" class="tutores_Id_Relacion"><div class="ewTableHeaderCaption"><?php echo $tutores->Id_Relacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Relacion"><div><div id="elh_tutores_Id_Relacion" class="tutores_Id_Relacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Id_Relacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Id_Relacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Id_Relacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tutores->Id_Departamento->Visible) { // Id_Departamento ?>
	<?php if ($tutores->SortUrl($tutores->Id_Departamento) == "") { ?>
		<th data-name="Id_Departamento"><div id="elh_tutores_Id_Departamento" class="tutores_Id_Departamento"><div class="ewTableHeaderCaption"><?php echo $tutores->Id_Departamento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Departamento"><div><div id="elh_tutores_Id_Departamento" class="tutores_Id_Departamento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tutores->Id_Departamento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tutores->Id_Departamento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tutores->Id_Departamento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tutores_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tutores_grid->StartRec = 1;
$tutores_grid->StopRec = $tutores_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tutores_grid->FormKeyCountName) && ($tutores->CurrentAction == "gridadd" || $tutores->CurrentAction == "gridedit" || $tutores->CurrentAction == "F")) {
		$tutores_grid->KeyCount = $objForm->GetValue($tutores_grid->FormKeyCountName);
		$tutores_grid->StopRec = $tutores_grid->StartRec + $tutores_grid->KeyCount - 1;
	}
}
$tutores_grid->RecCnt = $tutores_grid->StartRec - 1;
if ($tutores_grid->Recordset && !$tutores_grid->Recordset->EOF) {
	$tutores_grid->Recordset->MoveFirst();
	$bSelectLimit = $tutores_grid->UseSelectLimit;
	if (!$bSelectLimit && $tutores_grid->StartRec > 1)
		$tutores_grid->Recordset->Move($tutores_grid->StartRec - 1);
} elseif (!$tutores->AllowAddDeleteRow && $tutores_grid->StopRec == 0) {
	$tutores_grid->StopRec = $tutores->GridAddRowCount;
}

// Initialize aggregate
$tutores->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tutores->ResetAttrs();
$tutores_grid->RenderRow();
if ($tutores->CurrentAction == "gridadd")
	$tutores_grid->RowIndex = 0;
if ($tutores->CurrentAction == "gridedit")
	$tutores_grid->RowIndex = 0;
while ($tutores_grid->RecCnt < $tutores_grid->StopRec) {
	$tutores_grid->RecCnt++;
	if (intval($tutores_grid->RecCnt) >= intval($tutores_grid->StartRec)) {
		$tutores_grid->RowCnt++;
		if ($tutores->CurrentAction == "gridadd" || $tutores->CurrentAction == "gridedit" || $tutores->CurrentAction == "F") {
			$tutores_grid->RowIndex++;
			$objForm->Index = $tutores_grid->RowIndex;
			if ($objForm->HasValue($tutores_grid->FormActionName))
				$tutores_grid->RowAction = strval($objForm->GetValue($tutores_grid->FormActionName));
			elseif ($tutores->CurrentAction == "gridadd")
				$tutores_grid->RowAction = "insert";
			else
				$tutores_grid->RowAction = "";
		}

		// Set up key count
		$tutores_grid->KeyCount = $tutores_grid->RowIndex;

		// Init row class and style
		$tutores->ResetAttrs();
		$tutores->CssClass = "";
		if ($tutores->CurrentAction == "gridadd") {
			if ($tutores->CurrentMode == "copy") {
				$tutores_grid->LoadRowValues($tutores_grid->Recordset); // Load row values
				$tutores_grid->SetRecordKey($tutores_grid->RowOldKey, $tutores_grid->Recordset); // Set old record key
			} else {
				$tutores_grid->LoadDefaultValues(); // Load default values
				$tutores_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tutores_grid->LoadRowValues($tutores_grid->Recordset); // Load row values
		}
		$tutores->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tutores->CurrentAction == "gridadd") // Grid add
			$tutores->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tutores->CurrentAction == "gridadd" && $tutores->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tutores_grid->RestoreCurrentRowFormValues($tutores_grid->RowIndex); // Restore form values
		if ($tutores->CurrentAction == "gridedit") { // Grid edit
			if ($tutores->EventCancelled) {
				$tutores_grid->RestoreCurrentRowFormValues($tutores_grid->RowIndex); // Restore form values
			}
			if ($tutores_grid->RowAction == "insert")
				$tutores->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tutores->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tutores->CurrentAction == "gridedit" && ($tutores->RowType == EW_ROWTYPE_EDIT || $tutores->RowType == EW_ROWTYPE_ADD) && $tutores->EventCancelled) // Update failed
			$tutores_grid->RestoreCurrentRowFormValues($tutores_grid->RowIndex); // Restore form values
		if ($tutores->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tutores_grid->EditRowCnt++;
		if ($tutores->CurrentAction == "F") // Confirm row
			$tutores_grid->RestoreCurrentRowFormValues($tutores_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tutores->RowAttrs = array_merge($tutores->RowAttrs, array('data-rowindex'=>$tutores_grid->RowCnt, 'id'=>'r' . $tutores_grid->RowCnt . '_tutores', 'data-rowtype'=>$tutores->RowType));

		// Render row
		$tutores_grid->RenderRow();

		// Render list options
		$tutores_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tutores_grid->RowAction <> "delete" && $tutores_grid->RowAction <> "insertdelete" && !($tutores_grid->RowAction == "insert" && $tutores->CurrentAction == "F" && $tutores_grid->EmptyRow())) {
?>
	<tr<?php echo $tutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tutores_grid->ListOptions->Render("body", "left", $tutores_grid->RowCnt);
?>
	<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor"<?php echo $tutores->Dni_Tutor->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tutores->Dni_Tutor->getSessionValue() <> "") { ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Dni_Tutor" class="tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<?php echo $tutores->Dni_Tutor->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tutores_grid->PageObjName . "_row_" . $tutores_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres"<?php echo $tutores->Apellidos_Nombres->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Apellidos_Nombres" class="tutores_Apellidos_Nombres">
<span<?php echo $tutores->Apellidos_Nombres->ViewAttributes() ?>>
<?php echo $tutores->Apellidos_Nombres->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio"<?php echo $tutores->Domicilio->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Domicilio" class="form-group tutores_Domicilio">
<input type="text" data-table="tutores" data-field="x_Domicilio" name="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Domicilio->getPlaceHolder()) ?>" value="<?php echo $tutores->Domicilio->EditValue ?>"<?php echo $tutores->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Domicilio" name="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($tutores->Domicilio->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Domicilio" class="form-group tutores_Domicilio">
<input type="text" data-table="tutores" data-field="x_Domicilio" name="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Domicilio->getPlaceHolder()) ?>" value="<?php echo $tutores->Domicilio->EditValue ?>"<?php echo $tutores->Domicilio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Domicilio" class="tutores_Domicilio">
<span<?php echo $tutores->Domicilio->ViewAttributes() ?>>
<?php echo $tutores->Domicilio->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Domicilio" name="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($tutores->Domicilio->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Domicilio" name="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($tutores->Domicilio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<td data-name="Tel_Contacto"<?php echo $tutores->Tel_Contacto->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Tel_Contacto" class="tutores_Tel_Contacto">
<span<?php echo $tutores->Tel_Contacto->ViewAttributes() ?>>
<?php echo $tutores->Tel_Contacto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $tutores->Cuil->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_grid->RowIndex ?>_Cuil" id="x<?php echo $tutores_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_grid->RowIndex ?>_Cuil" id="o<?php echo $tutores_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_grid->RowIndex ?>_Cuil" id="x<?php echo $tutores_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Cuil" class="tutores_Cuil">
<span<?php echo $tutores->Cuil->ViewAttributes() ?>>
<?php echo $tutores->Cuil->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_grid->RowIndex ?>_Cuil" id="x<?php echo $tutores_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_grid->RowIndex ?>_Cuil" id="o<?php echo $tutores_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->MasHijos->Visible) { // MasHijos ?>
		<td data-name="MasHijos"<?php echo $tutores->MasHijos->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_MasHijos" class="form-group tutores_MasHijos">
<div id="tp_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" class="ewTemplate"><input type="radio" data-table="tutores" data-field="x_MasHijos" data-value-separator="<?php echo $tutores->MasHijos->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="{value}"<?php echo $tutores->MasHijos->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tutores->MasHijos->RadioButtonListHtml(FALSE, "x{$tutores_grid->RowIndex}_MasHijos") ?>
</div></div>
</span>
<input type="hidden" data-table="tutores" data-field="x_MasHijos" name="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="<?php echo ew_HtmlEncode($tutores->MasHijos->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_MasHijos" class="form-group tutores_MasHijos">
<div id="tp_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" class="ewTemplate"><input type="radio" data-table="tutores" data-field="x_MasHijos" data-value-separator="<?php echo $tutores->MasHijos->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="{value}"<?php echo $tutores->MasHijos->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tutores->MasHijos->RadioButtonListHtml(FALSE, "x{$tutores_grid->RowIndex}_MasHijos") ?>
</div></div>
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_MasHijos" class="tutores_MasHijos">
<span<?php echo $tutores->MasHijos->ViewAttributes() ?>>
<?php echo $tutores->MasHijos->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_MasHijos" name="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="<?php echo ew_HtmlEncode($tutores->MasHijos->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_MasHijos" name="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="<?php echo ew_HtmlEncode($tutores->MasHijos->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<td data-name="Id_Relacion"<?php echo $tutores->Id_Relacion->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Relacion" class="tutores_Id_Relacion">
<span<?php echo $tutores->Id_Relacion->ViewAttributes() ?>>
<?php echo $tutores->Id_Relacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tutores->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento"<?php echo $tutores->Id_Departamento->CellAttributes() ?>>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Departamento" class="form-group tutores_Id_Departamento">
<select data-table="tutores" data-field="x_Id_Departamento" data-value-separator="<?php echo $tutores->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento"<?php echo $tutores->Id_Departamento->EditAttributes() ?>>
<?php echo $tutores->Id_Departamento->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo $tutores->Id_Departamento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Departamento" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($tutores->Id_Departamento->OldValue) ?>">
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Departamento" class="form-group tutores_Id_Departamento">
<select data-table="tutores" data-field="x_Id_Departamento" data-value-separator="<?php echo $tutores->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento"<?php echo $tutores->Id_Departamento->EditAttributes() ?>>
<?php echo $tutores->Id_Departamento->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo $tutores->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tutores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tutores_grid->RowCnt ?>_tutores_Id_Departamento" class="tutores_Id_Departamento">
<span<?php echo $tutores->Id_Departamento->ViewAttributes() ?>>
<?php echo $tutores->Id_Departamento->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Departamento" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($tutores->Id_Departamento->FormValue) ?>">
<input type="hidden" data-table="tutores" data-field="x_Id_Departamento" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($tutores->Id_Departamento->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tutores_grid->ListOptions->Render("body", "right", $tutores_grid->RowCnt);
?>
	</tr>
<?php if ($tutores->RowType == EW_ROWTYPE_ADD || $tutores->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftutoresgrid.UpdateOpts(<?php echo $tutores_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tutores->CurrentAction <> "gridadd" || $tutores->CurrentMode == "copy")
		if (!$tutores_grid->Recordset->EOF) $tutores_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tutores->CurrentMode == "add" || $tutores->CurrentMode == "copy" || $tutores->CurrentMode == "edit") {
		$tutores_grid->RowIndex = '$rowindex$';
		$tutores_grid->LoadDefaultValues();

		// Set row properties
		$tutores->ResetAttrs();
		$tutores->RowAttrs = array_merge($tutores->RowAttrs, array('data-rowindex'=>$tutores_grid->RowIndex, 'id'=>'r0_tutores', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tutores->RowAttrs["class"], "ewTemplate");
		$tutores->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tutores_grid->RenderRow();

		// Render list options
		$tutores_grid->RenderListOptions();
		$tutores_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tutores_grid->ListOptions->Render("body", "left", $tutores_grid->RowIndex);
?>
	<?php if ($tutores->Dni_Tutor->Visible) { // Dni_Tutor ?>
		<td data-name="Dni_Tutor">
<?php if ($tutores->CurrentAction <> "F") { ?>
<?php if ($tutores->Dni_Tutor->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<input type="text" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" size="30" placeholder="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->getPlaceHolder()) ?>" value="<?php echo $tutores->Dni_Tutor->EditValue ?>"<?php echo $tutores->Dni_Tutor->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tutores_Dni_Tutor" class="form-group tutores_Dni_Tutor">
<span<?php echo $tutores->Dni_Tutor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Dni_Tutor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="x<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Dni_Tutor" name="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" id="o<?php echo $tutores_grid->RowIndex ?>_Dni_Tutor" value="<?php echo ew_HtmlEncode($tutores->Dni_Tutor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Apellidos_Nombres->Visible) { // Apellidos_Nombres ?>
		<td data-name="Apellidos_Nombres">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<input type="text" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->getPlaceHolder()) ?>" value="<?php echo $tutores->Apellidos_Nombres->EditValue ?>"<?php echo $tutores->Apellidos_Nombres->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Apellidos_Nombres" class="form-group tutores_Apellidos_Nombres">
<span<?php echo $tutores->Apellidos_Nombres->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Apellidos_Nombres->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="x<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Apellidos_Nombres" name="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" id="o<?php echo $tutores_grid->RowIndex ?>_Apellidos_Nombres" value="<?php echo ew_HtmlEncode($tutores->Apellidos_Nombres->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Domicilio" class="form-group tutores_Domicilio">
<input type="text" data-table="tutores" data-field="x_Domicilio" name="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($tutores->Domicilio->getPlaceHolder()) ?>" value="<?php echo $tutores->Domicilio->EditValue ?>"<?php echo $tutores->Domicilio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Domicilio" class="form-group tutores_Domicilio">
<span<?php echo $tutores->Domicilio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Domicilio->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Domicilio" name="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="x<?php echo $tutores_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($tutores->Domicilio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Domicilio" name="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" id="o<?php echo $tutores_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($tutores->Domicilio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Tel_Contacto->Visible) { // Tel_Contacto ?>
		<td data-name="Tel_Contacto">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<input type="text" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->getPlaceHolder()) ?>" value="<?php echo $tutores->Tel_Contacto->EditValue ?>"<?php echo $tutores->Tel_Contacto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Tel_Contacto" class="form-group tutores_Tel_Contacto">
<span<?php echo $tutores->Tel_Contacto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Tel_Contacto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="x<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Tel_Contacto" name="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" id="o<?php echo $tutores_grid->RowIndex ?>_Tel_Contacto" value="<?php echo ew_HtmlEncode($tutores->Tel_Contacto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Cuil" class="form-group tutores_Cuil">
<input type="text" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_grid->RowIndex ?>_Cuil" id="x<?php echo $tutores_grid->RowIndex ?>_Cuil" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tutores->Cuil->getPlaceHolder()) ?>" value="<?php echo $tutores->Cuil->EditValue ?>"<?php echo $tutores->Cuil->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Cuil" class="form-group tutores_Cuil">
<span<?php echo $tutores->Cuil->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Cuil->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="x<?php echo $tutores_grid->RowIndex ?>_Cuil" id="x<?php echo $tutores_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Cuil" name="o<?php echo $tutores_grid->RowIndex ?>_Cuil" id="o<?php echo $tutores_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($tutores->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->MasHijos->Visible) { // MasHijos ?>
		<td data-name="MasHijos">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_MasHijos" class="form-group tutores_MasHijos">
<div id="tp_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" class="ewTemplate"><input type="radio" data-table="tutores" data-field="x_MasHijos" data-value-separator="<?php echo $tutores->MasHijos->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="{value}"<?php echo $tutores->MasHijos->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $tutores_grid->RowIndex ?>_MasHijos" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tutores->MasHijos->RadioButtonListHtml(FALSE, "x{$tutores_grid->RowIndex}_MasHijos") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_MasHijos" class="form-group tutores_MasHijos">
<span<?php echo $tutores->MasHijos->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->MasHijos->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_MasHijos" name="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="x<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="<?php echo ew_HtmlEncode($tutores->MasHijos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_MasHijos" name="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" id="o<?php echo $tutores_grid->RowIndex ?>_MasHijos" value="<?php echo ew_HtmlEncode($tutores->MasHijos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Id_Relacion->Visible) { // Id_Relacion ?>
		<td data-name="Id_Relacion">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<select data-table="tutores" data-field="x_Id_Relacion" data-value-separator="<?php echo $tutores->Id_Relacion->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion"<?php echo $tutores->Id_Relacion->EditAttributes() ?>>
<?php echo $tutores->Id_Relacion->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo $tutores->Id_Relacion->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Id_Relacion" class="form-group tutores_Id_Relacion">
<span<?php echo $tutores->Id_Relacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Id_Relacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Id_Relacion" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Relacion" value="<?php echo ew_HtmlEncode($tutores->Id_Relacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tutores->Id_Departamento->Visible) { // Id_Departamento ?>
		<td data-name="Id_Departamento">
<?php if ($tutores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tutores_Id_Departamento" class="form-group tutores_Id_Departamento">
<select data-table="tutores" data-field="x_Id_Departamento" data-value-separator="<?php echo $tutores->Id_Departamento->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento"<?php echo $tutores->Id_Departamento->EditAttributes() ?>>
<?php echo $tutores->Id_Departamento->SelectOptionListHtml("x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento") ?>
</select>
<input type="hidden" name="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="s_x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo $tutores->Id_Departamento->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tutores_Id_Departamento" class="form-group tutores_Id_Departamento">
<span<?php echo $tutores->Id_Departamento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tutores->Id_Departamento->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tutores" data-field="x_Id_Departamento" name="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="x<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($tutores->Id_Departamento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tutores" data-field="x_Id_Departamento" name="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" id="o<?php echo $tutores_grid->RowIndex ?>_Id_Departamento" value="<?php echo ew_HtmlEncode($tutores->Id_Departamento->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tutores_grid->ListOptions->Render("body", "right", $tutores_grid->RowCnt);
?>
<script type="text/javascript">
ftutoresgrid.UpdateOpts(<?php echo $tutores_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tutores->CurrentMode == "add" || $tutores->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tutores_grid->FormKeyCountName ?>" id="<?php echo $tutores_grid->FormKeyCountName ?>" value="<?php echo $tutores_grid->KeyCount ?>">
<?php echo $tutores_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tutores->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tutores_grid->FormKeyCountName ?>" id="<?php echo $tutores_grid->FormKeyCountName ?>" value="<?php echo $tutores_grid->KeyCount ?>">
<?php echo $tutores_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tutores->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftutoresgrid">
</div>
<?php

// Close recordset
if ($tutores_grid->Recordset)
	$tutores_grid->Recordset->Close();
?>
<?php if ($tutores_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($tutores_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tutores_grid->TotalRecs == 0 && $tutores->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tutores_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tutores->Export == "") { ?>
<script type="text/javascript">
ftutoresgrid.Init();
</script>
<?php } ?>
<?php
$tutores_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tutores_grid->Page_Terminate();
?>
