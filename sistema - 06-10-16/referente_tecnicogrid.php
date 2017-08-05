<?php

// Create page object
if (!isset($referente_tecnico_grid)) $referente_tecnico_grid = new creferente_tecnico_grid();

// Page init
$referente_tecnico_grid->Page_Init();

// Page main
$referente_tecnico_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referente_tecnico_grid->Page_Render();
?>
<?php if ($referente_tecnico->Export == "") { ?>
<script type="text/javascript">

// Form object
var freferente_tecnicogrid = new ew_Form("freferente_tecnicogrid", "grid");
freferente_tecnicogrid.FormKeyCountName = '<?php echo $referente_tecnico_grid->FormKeyCountName ?>';

// Validate form
freferente_tecnicogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->DniRte->FldCaption(), $referente_tecnico->DniRte->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DniRte");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->DniRte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Telefono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Celular");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Celular->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Mail");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referente_tecnico->Mail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $referente_tecnico->Id_Turno->FldCaption(), $referente_tecnico->Id_Turno->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
freferente_tecnicogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "DniRte", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Apelldio_Nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Domicilio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Telefono", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Celular", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Mail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	return true;
}

// Form_CustomValidate event
freferente_tecnicogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freferente_tecnicogrid.ValidateRequired = true;
<?php } else { ?>
freferente_tecnicogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freferente_tecnicogrid.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno_rte"};

// Form object for search
</script>
<?php } ?>
<?php
if ($referente_tecnico->CurrentAction == "gridadd") {
	if ($referente_tecnico->CurrentMode == "copy") {
		$bSelectLimit = $referente_tecnico_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$referente_tecnico_grid->TotalRecs = $referente_tecnico->SelectRecordCount();
			$referente_tecnico_grid->Recordset = $referente_tecnico_grid->LoadRecordset($referente_tecnico_grid->StartRec-1, $referente_tecnico_grid->DisplayRecs);
		} else {
			if ($referente_tecnico_grid->Recordset = $referente_tecnico_grid->LoadRecordset())
				$referente_tecnico_grid->TotalRecs = $referente_tecnico_grid->Recordset->RecordCount();
		}
		$referente_tecnico_grid->StartRec = 1;
		$referente_tecnico_grid->DisplayRecs = $referente_tecnico_grid->TotalRecs;
	} else {
		$referente_tecnico->CurrentFilter = "0=1";
		$referente_tecnico_grid->StartRec = 1;
		$referente_tecnico_grid->DisplayRecs = $referente_tecnico->GridAddRowCount;
	}
	$referente_tecnico_grid->TotalRecs = $referente_tecnico_grid->DisplayRecs;
	$referente_tecnico_grid->StopRec = $referente_tecnico_grid->DisplayRecs;
} else {
	$bSelectLimit = $referente_tecnico_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($referente_tecnico_grid->TotalRecs <= 0)
			$referente_tecnico_grid->TotalRecs = $referente_tecnico->SelectRecordCount();
	} else {
		if (!$referente_tecnico_grid->Recordset && ($referente_tecnico_grid->Recordset = $referente_tecnico_grid->LoadRecordset()))
			$referente_tecnico_grid->TotalRecs = $referente_tecnico_grid->Recordset->RecordCount();
	}
	$referente_tecnico_grid->StartRec = 1;
	$referente_tecnico_grid->DisplayRecs = $referente_tecnico_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$referente_tecnico_grid->Recordset = $referente_tecnico_grid->LoadRecordset($referente_tecnico_grid->StartRec-1, $referente_tecnico_grid->DisplayRecs);

	// Set no record found message
	if ($referente_tecnico->CurrentAction == "" && $referente_tecnico_grid->TotalRecs == 0) {
		if ($referente_tecnico_grid->SearchWhere == "0=101")
			$referente_tecnico_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$referente_tecnico_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$referente_tecnico_grid->RenderOtherOptions();
?>
<?php $referente_tecnico_grid->ShowPageHeader(); ?>
<?php
$referente_tecnico_grid->ShowMessage();
?>
<?php if ($referente_tecnico_grid->TotalRecs > 0 || $referente_tecnico->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid referente_tecnico">
<div id="freferente_tecnicogrid" class="ewForm form-inline">
<div id="gmp_referente_tecnico" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_referente_tecnicogrid" class="table ewTable">
<?php echo $referente_tecnico->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$referente_tecnico_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$referente_tecnico_grid->RenderListOptions();

// Render list options (header, left)
$referente_tecnico_grid->ListOptions->Render("header", "left");
?>
<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->DniRte) == "") { ?>
		<th data-name="DniRte"><div id="elh_referente_tecnico_DniRte" class="referente_tecnico_DniRte"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->DniRte->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DniRte"><div><div id="elh_referente_tecnico_DniRte" class="referente_tecnico_DniRte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->DniRte->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->DniRte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->DniRte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Apelldio_Nombre->Visible) { // Apelldio_Nombre ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Apelldio_Nombre) == "") { ?>
		<th data-name="Apelldio_Nombre"><div id="elh_referente_tecnico_Apelldio_Nombre" class="referente_tecnico_Apelldio_Nombre"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Apelldio_Nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apelldio_Nombre"><div><div id="elh_referente_tecnico_Apelldio_Nombre" class="referente_tecnico_Apelldio_Nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Apelldio_Nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Apelldio_Nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Apelldio_Nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Domicilio) == "") { ?>
		<th data-name="Domicilio"><div id="elh_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Domicilio"><div><div id="elh_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Domicilio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Domicilio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Domicilio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_referente_tecnico_Telefono" class="referente_tecnico_Telefono"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div><div id="elh_referente_tecnico_Telefono" class="referente_tecnico_Telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Telefono->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Celular) == "") { ?>
		<th data-name="Celular"><div id="elh_referente_tecnico_Celular" class="referente_tecnico_Celular"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Celular->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Celular"><div><div id="elh_referente_tecnico_Celular" class="referente_tecnico_Celular">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Celular->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Celular->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Celular->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Mail) == "") { ?>
		<th data-name="Mail"><div id="elh_referente_tecnico_Mail" class="referente_tecnico_Mail"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Mail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Mail"><div><div id="elh_referente_tecnico_Mail" class="referente_tecnico_Mail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Mail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Mail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Mail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div><div id="elh_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
	<?php if ($referente_tecnico->SortUrl($referente_tecnico->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_referente_tecnico_Usuario" class="referente_tecnico_Usuario"><div class="ewTableHeaderCaption"><?php echo $referente_tecnico->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_referente_tecnico_Usuario" class="referente_tecnico_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $referente_tecnico->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($referente_tecnico->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($referente_tecnico->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$referente_tecnico_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$referente_tecnico_grid->StartRec = 1;
$referente_tecnico_grid->StopRec = $referente_tecnico_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($referente_tecnico_grid->FormKeyCountName) && ($referente_tecnico->CurrentAction == "gridadd" || $referente_tecnico->CurrentAction == "gridedit" || $referente_tecnico->CurrentAction == "F")) {
		$referente_tecnico_grid->KeyCount = $objForm->GetValue($referente_tecnico_grid->FormKeyCountName);
		$referente_tecnico_grid->StopRec = $referente_tecnico_grid->StartRec + $referente_tecnico_grid->KeyCount - 1;
	}
}
$referente_tecnico_grid->RecCnt = $referente_tecnico_grid->StartRec - 1;
if ($referente_tecnico_grid->Recordset && !$referente_tecnico_grid->Recordset->EOF) {
	$referente_tecnico_grid->Recordset->MoveFirst();
	$bSelectLimit = $referente_tecnico_grid->UseSelectLimit;
	if (!$bSelectLimit && $referente_tecnico_grid->StartRec > 1)
		$referente_tecnico_grid->Recordset->Move($referente_tecnico_grid->StartRec - 1);
} elseif (!$referente_tecnico->AllowAddDeleteRow && $referente_tecnico_grid->StopRec == 0) {
	$referente_tecnico_grid->StopRec = $referente_tecnico->GridAddRowCount;
}

// Initialize aggregate
$referente_tecnico->RowType = EW_ROWTYPE_AGGREGATEINIT;
$referente_tecnico->ResetAttrs();
$referente_tecnico_grid->RenderRow();
if ($referente_tecnico->CurrentAction == "gridadd")
	$referente_tecnico_grid->RowIndex = 0;
if ($referente_tecnico->CurrentAction == "gridedit")
	$referente_tecnico_grid->RowIndex = 0;
while ($referente_tecnico_grid->RecCnt < $referente_tecnico_grid->StopRec) {
	$referente_tecnico_grid->RecCnt++;
	if (intval($referente_tecnico_grid->RecCnt) >= intval($referente_tecnico_grid->StartRec)) {
		$referente_tecnico_grid->RowCnt++;
		if ($referente_tecnico->CurrentAction == "gridadd" || $referente_tecnico->CurrentAction == "gridedit" || $referente_tecnico->CurrentAction == "F") {
			$referente_tecnico_grid->RowIndex++;
			$objForm->Index = $referente_tecnico_grid->RowIndex;
			if ($objForm->HasValue($referente_tecnico_grid->FormActionName))
				$referente_tecnico_grid->RowAction = strval($objForm->GetValue($referente_tecnico_grid->FormActionName));
			elseif ($referente_tecnico->CurrentAction == "gridadd")
				$referente_tecnico_grid->RowAction = "insert";
			else
				$referente_tecnico_grid->RowAction = "";
		}

		// Set up key count
		$referente_tecnico_grid->KeyCount = $referente_tecnico_grid->RowIndex;

		// Init row class and style
		$referente_tecnico->ResetAttrs();
		$referente_tecnico->CssClass = "";
		if ($referente_tecnico->CurrentAction == "gridadd") {
			if ($referente_tecnico->CurrentMode == "copy") {
				$referente_tecnico_grid->LoadRowValues($referente_tecnico_grid->Recordset); // Load row values
				$referente_tecnico_grid->SetRecordKey($referente_tecnico_grid->RowOldKey, $referente_tecnico_grid->Recordset); // Set old record key
			} else {
				$referente_tecnico_grid->LoadDefaultValues(); // Load default values
				$referente_tecnico_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$referente_tecnico_grid->LoadRowValues($referente_tecnico_grid->Recordset); // Load row values
		}
		$referente_tecnico->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($referente_tecnico->CurrentAction == "gridadd") // Grid add
			$referente_tecnico->RowType = EW_ROWTYPE_ADD; // Render add
		if ($referente_tecnico->CurrentAction == "gridadd" && $referente_tecnico->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$referente_tecnico_grid->RestoreCurrentRowFormValues($referente_tecnico_grid->RowIndex); // Restore form values
		if ($referente_tecnico->CurrentAction == "gridedit") { // Grid edit
			if ($referente_tecnico->EventCancelled) {
				$referente_tecnico_grid->RestoreCurrentRowFormValues($referente_tecnico_grid->RowIndex); // Restore form values
			}
			if ($referente_tecnico_grid->RowAction == "insert")
				$referente_tecnico->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$referente_tecnico->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($referente_tecnico->CurrentAction == "gridedit" && ($referente_tecnico->RowType == EW_ROWTYPE_EDIT || $referente_tecnico->RowType == EW_ROWTYPE_ADD) && $referente_tecnico->EventCancelled) // Update failed
			$referente_tecnico_grid->RestoreCurrentRowFormValues($referente_tecnico_grid->RowIndex); // Restore form values
		if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) // Edit row
			$referente_tecnico_grid->EditRowCnt++;
		if ($referente_tecnico->CurrentAction == "F") // Confirm row
			$referente_tecnico_grid->RestoreCurrentRowFormValues($referente_tecnico_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$referente_tecnico->RowAttrs = array_merge($referente_tecnico->RowAttrs, array('data-rowindex'=>$referente_tecnico_grid->RowCnt, 'id'=>'r' . $referente_tecnico_grid->RowCnt . '_referente_tecnico', 'data-rowtype'=>$referente_tecnico->RowType));

		// Render row
		$referente_tecnico_grid->RenderRow();

		// Render list options
		$referente_tecnico_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($referente_tecnico_grid->RowAction <> "delete" && $referente_tecnico_grid->RowAction <> "insertdelete" && !($referente_tecnico_grid->RowAction == "insert" && $referente_tecnico->CurrentAction == "F" && $referente_tecnico_grid->EmptyRow())) {
?>
	<tr<?php echo $referente_tecnico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$referente_tecnico_grid->ListOptions->Render("body", "left", $referente_tecnico_grid->RowCnt);
?>
	<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
		<td data-name="DniRte"<?php echo $referente_tecnico->DniRte->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->DniRte->EditValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->CurrentValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_DniRte" class="referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<?php echo $referente_tecnico->DniRte->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
<?php } ?>
<a id="<?php echo $referente_tecnico_grid->PageObjName . "_row_" . $referente_tecnico_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($referente_tecnico->Apelldio_Nombre->Visible) { // Apelldio_Nombre ?>
		<td data-name="Apelldio_Nombre"<?php echo $referente_tecnico->Apelldio_Nombre->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Apelldio_Nombre" class="form-group referente_tecnico_Apelldio_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apelldio_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apelldio_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Apelldio_Nombre" class="form-group referente_tecnico_Apelldio_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apelldio_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apelldio_Nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Apelldio_Nombre" class="referente_tecnico_Apelldio_Nombre">
<span<?php echo $referente_tecnico->Apelldio_Nombre->ViewAttributes() ?>>
<?php echo $referente_tecnico->Apelldio_Nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio"<?php echo $referente_tecnico->Domicilio->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Domicilio" class="referente_tecnico_Domicilio">
<span<?php echo $referente_tecnico->Domicilio->ViewAttributes() ?>>
<?php echo $referente_tecnico->Domicilio->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $referente_tecnico->Telefono->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Telefono" class="referente_tecnico_Telefono">
<span<?php echo $referente_tecnico->Telefono->ViewAttributes() ?>>
<?php echo $referente_tecnico->Telefono->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
		<td data-name="Celular"<?php echo $referente_tecnico->Celular->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Celular" class="referente_tecnico_Celular">
<span<?php echo $referente_tecnico->Celular->ViewAttributes() ?>>
<?php echo $referente_tecnico->Celular->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
		<td data-name="Mail"<?php echo $referente_tecnico->Mail->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Mail" class="referente_tecnico_Mail">
<span<?php echo $referente_tecnico->Mail->ViewAttributes() ?>>
<?php echo $referente_tecnico->Mail->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $referente_tecnico->Id_Turno->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Id_Turno" class="referente_tecnico_Id_Turno">
<span<?php echo $referente_tecnico->Id_Turno->ViewAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $referente_tecnico->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Fecha_Actualizacion" class="referente_tecnico_Fecha_Actualizacion">
<span<?php echo $referente_tecnico->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $referente_tecnico->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $referente_tecnico->Usuario->CellAttributes() ?>>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $referente_tecnico_grid->RowCnt ?>_referente_tecnico_Usuario" class="referente_tecnico_Usuario">
<span<?php echo $referente_tecnico->Usuario->ViewAttributes() ?>>
<?php echo $referente_tecnico->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->FormValue) ?>">
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$referente_tecnico_grid->ListOptions->Render("body", "right", $referente_tecnico_grid->RowCnt);
?>
	</tr>
<?php if ($referente_tecnico->RowType == EW_ROWTYPE_ADD || $referente_tecnico->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
freferente_tecnicogrid.UpdateOpts(<?php echo $referente_tecnico_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($referente_tecnico->CurrentAction <> "gridadd" || $referente_tecnico->CurrentMode == "copy")
		if (!$referente_tecnico_grid->Recordset->EOF) $referente_tecnico_grid->Recordset->MoveNext();
}
?>
<?php
	if ($referente_tecnico->CurrentMode == "add" || $referente_tecnico->CurrentMode == "copy" || $referente_tecnico->CurrentMode == "edit") {
		$referente_tecnico_grid->RowIndex = '$rowindex$';
		$referente_tecnico_grid->LoadDefaultValues();

		// Set row properties
		$referente_tecnico->ResetAttrs();
		$referente_tecnico->RowAttrs = array_merge($referente_tecnico->RowAttrs, array('data-rowindex'=>$referente_tecnico_grid->RowIndex, 'id'=>'r0_referente_tecnico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($referente_tecnico->RowAttrs["class"], "ewTemplate");
		$referente_tecnico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$referente_tecnico_grid->RenderRow();

		// Render list options
		$referente_tecnico_grid->RenderListOptions();
		$referente_tecnico_grid->StartRowCnt = 0;
?>
	<tr<?php echo $referente_tecnico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$referente_tecnico_grid->ListOptions->Render("body", "left", $referente_tecnico_grid->RowIndex);
?>
	<?php if ($referente_tecnico->DniRte->Visible) { // DniRte ?>
		<td data-name="DniRte">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<input type="text" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->DniRte->EditValue ?>"<?php echo $referente_tecnico->DniRte->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_DniRte" class="form-group referente_tecnico_DniRte">
<span<?php echo $referente_tecnico->DniRte->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->DniRte->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_DniRte" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_DniRte" value="<?php echo ew_HtmlEncode($referente_tecnico->DniRte->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Apelldio_Nombre->Visible) { // Apelldio_Nombre ?>
		<td data-name="Apelldio_Nombre">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Apelldio_Nombre" class="form-group referente_tecnico_Apelldio_Nombre">
<input type="text" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Apelldio_Nombre->EditValue ?>"<?php echo $referente_tecnico->Apelldio_Nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Apelldio_Nombre" class="form-group referente_tecnico_Apelldio_Nombre">
<span<?php echo $referente_tecnico->Apelldio_Nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Apelldio_Nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Apelldio_Nombre" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Apelldio_Nombre" value="<?php echo ew_HtmlEncode($referente_tecnico->Apelldio_Nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Domicilio->Visible) { // Domicilio ?>
		<td data-name="Domicilio">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<input type="text" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Domicilio->EditValue ?>"<?php echo $referente_tecnico->Domicilio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Domicilio" class="form-group referente_tecnico_Domicilio">
<span<?php echo $referente_tecnico->Domicilio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Domicilio->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Domicilio" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Domicilio" value="<?php echo ew_HtmlEncode($referente_tecnico->Domicilio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<input type="text" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Telefono->EditValue ?>"<?php echo $referente_tecnico->Telefono->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Telefono" class="form-group referente_tecnico_Telefono">
<span<?php echo $referente_tecnico->Telefono->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Telefono->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Telefono" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($referente_tecnico->Telefono->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Celular->Visible) { // Celular ?>
		<td data-name="Celular">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<input type="text" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" size="30" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Celular->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Celular->EditValue ?>"<?php echo $referente_tecnico->Celular->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Celular" class="form-group referente_tecnico_Celular">
<span<?php echo $referente_tecnico->Celular->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Celular->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Celular" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Celular" value="<?php echo ew_HtmlEncode($referente_tecnico->Celular->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Mail->Visible) { // Mail ?>
		<td data-name="Mail">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<input type="text" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referente_tecnico->Mail->getPlaceHolder()) ?>" value="<?php echo $referente_tecnico->Mail->EditValue ?>"<?php echo $referente_tecnico->Mail->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Mail" class="form-group referente_tecnico_Mail">
<span<?php echo $referente_tecnico->Mail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Mail->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Mail" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Mail" value="<?php echo ew_HtmlEncode($referente_tecnico->Mail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<span id="el$rowindex$_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<select data-table="referente_tecnico" data-field="x_Id_Turno" data-value-separator="<?php echo $referente_tecnico->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno"<?php echo $referente_tecnico->Id_Turno->EditAttributes() ?>>
<?php echo $referente_tecnico->Id_Turno->SelectOptionListHtml("x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo $referente_tecnico->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_referente_tecnico_Id_Turno" class="form-group referente_tecnico_Id_Turno">
<span<?php echo $referente_tecnico->Id_Turno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $referente_tecnico->Id_Turno->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Id_Turno" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($referente_tecnico->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Fecha_Actualizacion" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($referente_tecnico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($referente_tecnico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($referente_tecnico->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="x<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" id="x<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="referente_tecnico" data-field="x_Usuario" name="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" id="o<?php echo $referente_tecnico_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($referente_tecnico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$referente_tecnico_grid->ListOptions->Render("body", "right", $referente_tecnico_grid->RowCnt);
?>
<script type="text/javascript">
freferente_tecnicogrid.UpdateOpts(<?php echo $referente_tecnico_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($referente_tecnico->CurrentMode == "add" || $referente_tecnico->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $referente_tecnico_grid->FormKeyCountName ?>" id="<?php echo $referente_tecnico_grid->FormKeyCountName ?>" value="<?php echo $referente_tecnico_grid->KeyCount ?>">
<?php echo $referente_tecnico_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($referente_tecnico->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $referente_tecnico_grid->FormKeyCountName ?>" id="<?php echo $referente_tecnico_grid->FormKeyCountName ?>" value="<?php echo $referente_tecnico_grid->KeyCount ?>">
<?php echo $referente_tecnico_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($referente_tecnico->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="freferente_tecnicogrid">
</div>
<?php

// Close recordset
if ($referente_tecnico_grid->Recordset)
	$referente_tecnico_grid->Recordset->Close();
?>
<?php if ($referente_tecnico_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($referente_tecnico_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($referente_tecnico_grid->TotalRecs == 0 && $referente_tecnico->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($referente_tecnico_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($referente_tecnico->Export == "") { ?>
<script type="text/javascript">
freferente_tecnicogrid.Init();
</script>
<?php } ?>
<?php
$referente_tecnico_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$referente_tecnico_grid->Page_Terminate();
?>
