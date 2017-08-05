<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($autoridades_escolares_grid)) $autoridades_escolares_grid = new cautoridades_escolares_grid();

// Page init
$autoridades_escolares_grid->Page_Init();

// Page main
$autoridades_escolares_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$autoridades_escolares_grid->Page_Render();
?>
<?php if ($autoridades_escolares->Export == "") { ?>
<script type="text/javascript">

// Form object
var fautoridades_escolaresgrid = new ew_Form("fautoridades_escolaresgrid", "grid");
fautoridades_escolaresgrid.FormKeyCountName = '<?php echo $autoridades_escolares_grid->FormKeyCountName ?>';

// Validate form
fautoridades_escolaresgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_Cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $autoridades_escolares->Id_Cargo->FldCaption(), $autoridades_escolares->Id_Cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Turno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $autoridades_escolares->Id_Turno->FldCaption(), $autoridades_escolares->Id_Turno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($autoridades_escolares->Telefono->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fautoridades_escolaresgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Apellido_Nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cuil", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Cargo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Turno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Telefono", false)) return false;
	return true;
}

// Form_CustomValidate event
fautoridades_escolaresgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fautoridades_escolaresgrid.ValidateRequired = true;
<?php } else { ?>
fautoridades_escolaresgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fautoridades_escolaresgrid.Lists["x_Id_Cargo"] = {"LinkField":"x_Id_Cargo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cargo_autoridad"};
fautoridades_escolaresgrid.Lists["x_Id_Turno"] = {"LinkField":"x_Id_Turno","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"turno"};

// Form object for search
</script>
<?php } ?>
<?php
if ($autoridades_escolares->CurrentAction == "gridadd") {
	if ($autoridades_escolares->CurrentMode == "copy") {
		$bSelectLimit = $autoridades_escolares_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$autoridades_escolares_grid->TotalRecs = $autoridades_escolares->SelectRecordCount();
			$autoridades_escolares_grid->Recordset = $autoridades_escolares_grid->LoadRecordset($autoridades_escolares_grid->StartRec-1, $autoridades_escolares_grid->DisplayRecs);
		} else {
			if ($autoridades_escolares_grid->Recordset = $autoridades_escolares_grid->LoadRecordset())
				$autoridades_escolares_grid->TotalRecs = $autoridades_escolares_grid->Recordset->RecordCount();
		}
		$autoridades_escolares_grid->StartRec = 1;
		$autoridades_escolares_grid->DisplayRecs = $autoridades_escolares_grid->TotalRecs;
	} else {
		$autoridades_escolares->CurrentFilter = "0=1";
		$autoridades_escolares_grid->StartRec = 1;
		$autoridades_escolares_grid->DisplayRecs = $autoridades_escolares->GridAddRowCount;
	}
	$autoridades_escolares_grid->TotalRecs = $autoridades_escolares_grid->DisplayRecs;
	$autoridades_escolares_grid->StopRec = $autoridades_escolares_grid->DisplayRecs;
} else {
	$bSelectLimit = $autoridades_escolares_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($autoridades_escolares_grid->TotalRecs <= 0)
			$autoridades_escolares_grid->TotalRecs = $autoridades_escolares->SelectRecordCount();
	} else {
		if (!$autoridades_escolares_grid->Recordset && ($autoridades_escolares_grid->Recordset = $autoridades_escolares_grid->LoadRecordset()))
			$autoridades_escolares_grid->TotalRecs = $autoridades_escolares_grid->Recordset->RecordCount();
	}
	$autoridades_escolares_grid->StartRec = 1;
	$autoridades_escolares_grid->DisplayRecs = $autoridades_escolares_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$autoridades_escolares_grid->Recordset = $autoridades_escolares_grid->LoadRecordset($autoridades_escolares_grid->StartRec-1, $autoridades_escolares_grid->DisplayRecs);

	// Set no record found message
	if ($autoridades_escolares->CurrentAction == "" && $autoridades_escolares_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$autoridades_escolares_grid->setWarningMessage(ew_DeniedMsg());
		if ($autoridades_escolares_grid->SearchWhere == "0=101")
			$autoridades_escolares_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$autoridades_escolares_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$autoridades_escolares_grid->RenderOtherOptions();
?>
<?php $autoridades_escolares_grid->ShowPageHeader(); ?>
<?php
$autoridades_escolares_grid->ShowMessage();
?>
<?php if ($autoridades_escolares_grid->TotalRecs > 0 || $autoridades_escolares->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid autoridades_escolares">
<div id="fautoridades_escolaresgrid" class="ewForm form-inline">
<?php if ($autoridades_escolares_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($autoridades_escolares_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_autoridades_escolares" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_autoridades_escolaresgrid" class="table ewTable">
<?php echo $autoridades_escolares->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$autoridades_escolares_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$autoridades_escolares_grid->RenderListOptions();

// Render list options (header, left)
$autoridades_escolares_grid->ListOptions->Render("header", "left");
?>
<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Apellido_Nombre) == "") { ?>
		<th data-name="Apellido_Nombre"><div id="elh_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Apellido_Nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_Nombre"><div><div id="elh_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Apellido_Nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Apellido_Nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Apellido_Nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div><div id="elh_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Cuil->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Id_Cargo) == "") { ?>
		<th data-name="Id_Cargo"><div id="elh_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Cargo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Cargo"><div><div id="elh_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Cargo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Id_Cargo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Id_Cargo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Id_Turno) == "") { ?>
		<th data-name="Id_Turno"><div id="elh_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Turno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Turno"><div><div id="elh_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Id_Turno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Id_Turno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Id_Turno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div><div id="elh_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Telefono->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
	<?php if ($autoridades_escolares->SortUrl($autoridades_escolares->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario"><div class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div><div id="elh_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $autoridades_escolares->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($autoridades_escolares->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($autoridades_escolares->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$autoridades_escolares_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$autoridades_escolares_grid->StartRec = 1;
$autoridades_escolares_grid->StopRec = $autoridades_escolares_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($autoridades_escolares_grid->FormKeyCountName) && ($autoridades_escolares->CurrentAction == "gridadd" || $autoridades_escolares->CurrentAction == "gridedit" || $autoridades_escolares->CurrentAction == "F")) {
		$autoridades_escolares_grid->KeyCount = $objForm->GetValue($autoridades_escolares_grid->FormKeyCountName);
		$autoridades_escolares_grid->StopRec = $autoridades_escolares_grid->StartRec + $autoridades_escolares_grid->KeyCount - 1;
	}
}
$autoridades_escolares_grid->RecCnt = $autoridades_escolares_grid->StartRec - 1;
if ($autoridades_escolares_grid->Recordset && !$autoridades_escolares_grid->Recordset->EOF) {
	$autoridades_escolares_grid->Recordset->MoveFirst();
	$bSelectLimit = $autoridades_escolares_grid->UseSelectLimit;
	if (!$bSelectLimit && $autoridades_escolares_grid->StartRec > 1)
		$autoridades_escolares_grid->Recordset->Move($autoridades_escolares_grid->StartRec - 1);
} elseif (!$autoridades_escolares->AllowAddDeleteRow && $autoridades_escolares_grid->StopRec == 0) {
	$autoridades_escolares_grid->StopRec = $autoridades_escolares->GridAddRowCount;
}

// Initialize aggregate
$autoridades_escolares->RowType = EW_ROWTYPE_AGGREGATEINIT;
$autoridades_escolares->ResetAttrs();
$autoridades_escolares_grid->RenderRow();
if ($autoridades_escolares->CurrentAction == "gridadd")
	$autoridades_escolares_grid->RowIndex = 0;
if ($autoridades_escolares->CurrentAction == "gridedit")
	$autoridades_escolares_grid->RowIndex = 0;
while ($autoridades_escolares_grid->RecCnt < $autoridades_escolares_grid->StopRec) {
	$autoridades_escolares_grid->RecCnt++;
	if (intval($autoridades_escolares_grid->RecCnt) >= intval($autoridades_escolares_grid->StartRec)) {
		$autoridades_escolares_grid->RowCnt++;
		if ($autoridades_escolares->CurrentAction == "gridadd" || $autoridades_escolares->CurrentAction == "gridedit" || $autoridades_escolares->CurrentAction == "F") {
			$autoridades_escolares_grid->RowIndex++;
			$objForm->Index = $autoridades_escolares_grid->RowIndex;
			if ($objForm->HasValue($autoridades_escolares_grid->FormActionName))
				$autoridades_escolares_grid->RowAction = strval($objForm->GetValue($autoridades_escolares_grid->FormActionName));
			elseif ($autoridades_escolares->CurrentAction == "gridadd")
				$autoridades_escolares_grid->RowAction = "insert";
			else
				$autoridades_escolares_grid->RowAction = "";
		}

		// Set up key count
		$autoridades_escolares_grid->KeyCount = $autoridades_escolares_grid->RowIndex;

		// Init row class and style
		$autoridades_escolares->ResetAttrs();
		$autoridades_escolares->CssClass = "";
		if ($autoridades_escolares->CurrentAction == "gridadd") {
			if ($autoridades_escolares->CurrentMode == "copy") {
				$autoridades_escolares_grid->LoadRowValues($autoridades_escolares_grid->Recordset); // Load row values
				$autoridades_escolares_grid->SetRecordKey($autoridades_escolares_grid->RowOldKey, $autoridades_escolares_grid->Recordset); // Set old record key
			} else {
				$autoridades_escolares_grid->LoadDefaultValues(); // Load default values
				$autoridades_escolares_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$autoridades_escolares_grid->LoadRowValues($autoridades_escolares_grid->Recordset); // Load row values
		}
		$autoridades_escolares->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($autoridades_escolares->CurrentAction == "gridadd") // Grid add
			$autoridades_escolares->RowType = EW_ROWTYPE_ADD; // Render add
		if ($autoridades_escolares->CurrentAction == "gridadd" && $autoridades_escolares->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$autoridades_escolares_grid->RestoreCurrentRowFormValues($autoridades_escolares_grid->RowIndex); // Restore form values
		if ($autoridades_escolares->CurrentAction == "gridedit") { // Grid edit
			if ($autoridades_escolares->EventCancelled) {
				$autoridades_escolares_grid->RestoreCurrentRowFormValues($autoridades_escolares_grid->RowIndex); // Restore form values
			}
			if ($autoridades_escolares_grid->RowAction == "insert")
				$autoridades_escolares->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$autoridades_escolares->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($autoridades_escolares->CurrentAction == "gridedit" && ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT || $autoridades_escolares->RowType == EW_ROWTYPE_ADD) && $autoridades_escolares->EventCancelled) // Update failed
			$autoridades_escolares_grid->RestoreCurrentRowFormValues($autoridades_escolares_grid->RowIndex); // Restore form values
		if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) // Edit row
			$autoridades_escolares_grid->EditRowCnt++;
		if ($autoridades_escolares->CurrentAction == "F") // Confirm row
			$autoridades_escolares_grid->RestoreCurrentRowFormValues($autoridades_escolares_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$autoridades_escolares->RowAttrs = array_merge($autoridades_escolares->RowAttrs, array('data-rowindex'=>$autoridades_escolares_grid->RowCnt, 'id'=>'r' . $autoridades_escolares_grid->RowCnt . '_autoridades_escolares', 'data-rowtype'=>$autoridades_escolares->RowType));

		// Render row
		$autoridades_escolares_grid->RenderRow();

		// Render list options
		$autoridades_escolares_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($autoridades_escolares_grid->RowAction <> "delete" && $autoridades_escolares_grid->RowAction <> "insertdelete" && !($autoridades_escolares_grid->RowAction == "insert" && $autoridades_escolares->CurrentAction == "F" && $autoridades_escolares_grid->EmptyRow())) {
?>
	<tr<?php echo $autoridades_escolares->RowAttributes() ?>>
<?php

// Render list options (body, left)
$autoridades_escolares_grid->ListOptions->Render("body", "left", $autoridades_escolares_grid->RowCnt);
?>
	<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre"<?php echo $autoridades_escolares->Apellido_Nombre->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Apellido_Nombre" class="autoridades_escolares_Apellido_Nombre">
<span<?php echo $autoridades_escolares->Apellido_Nombre->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Apellido_Nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $autoridades_escolares_grid->PageObjName . "_row_" . $autoridades_escolares_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->CurrentValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT || $autoridades_escolares->CurrentMode == "edit") { ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Autoridad" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Autoridad" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Autoridad->CurrentValue) ?>">
<?php } ?>
	<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $autoridades_escolares->Cuil->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Cuil" class="autoridades_escolares_Cuil">
<span<?php echo $autoridades_escolares->Cuil->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Cuil->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Cargo" class="autoridades_escolares_Id_Cargo">
<span<?php echo $autoridades_escolares->Id_Cargo->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno"<?php echo $autoridades_escolares->Id_Turno->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Id_Turno" class="autoridades_escolares_Id_Turno">
<span<?php echo $autoridades_escolares->Id_Turno->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $autoridades_escolares->Telefono->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Telefono" class="autoridades_escolares_Telefono">
<span<?php echo $autoridades_escolares->Telefono->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Telefono->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $autoridades_escolares->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Fecha_Actualizacion" class="autoridades_escolares_Fecha_Actualizacion">
<span<?php echo $autoridades_escolares->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $autoridades_escolares->Usuario->CellAttributes() ?>>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $autoridades_escolares_grid->RowCnt ?>_autoridades_escolares_Usuario" class="autoridades_escolares_Usuario">
<span<?php echo $autoridades_escolares->Usuario->ViewAttributes() ?>>
<?php echo $autoridades_escolares->Usuario->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->FormValue) ?>">
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$autoridades_escolares_grid->ListOptions->Render("body", "right", $autoridades_escolares_grid->RowCnt);
?>
	</tr>
<?php if ($autoridades_escolares->RowType == EW_ROWTYPE_ADD || $autoridades_escolares->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fautoridades_escolaresgrid.UpdateOpts(<?php echo $autoridades_escolares_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($autoridades_escolares->CurrentAction <> "gridadd" || $autoridades_escolares->CurrentMode == "copy")
		if (!$autoridades_escolares_grid->Recordset->EOF) $autoridades_escolares_grid->Recordset->MoveNext();
}
?>
<?php
	if ($autoridades_escolares->CurrentMode == "add" || $autoridades_escolares->CurrentMode == "copy" || $autoridades_escolares->CurrentMode == "edit") {
		$autoridades_escolares_grid->RowIndex = '$rowindex$';
		$autoridades_escolares_grid->LoadDefaultValues();

		// Set row properties
		$autoridades_escolares->ResetAttrs();
		$autoridades_escolares->RowAttrs = array_merge($autoridades_escolares->RowAttrs, array('data-rowindex'=>$autoridades_escolares_grid->RowIndex, 'id'=>'r0_autoridades_escolares', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($autoridades_escolares->RowAttrs["class"], "ewTemplate");
		$autoridades_escolares->RowType = EW_ROWTYPE_ADD;

		// Render row
		$autoridades_escolares_grid->RenderRow();

		// Render list options
		$autoridades_escolares_grid->RenderListOptions();
		$autoridades_escolares_grid->StartRowCnt = 0;
?>
	<tr<?php echo $autoridades_escolares->RowAttributes() ?>>
<?php

// Render list options (body, left)
$autoridades_escolares_grid->ListOptions->Render("body", "left", $autoridades_escolares_grid->RowIndex);
?>
	<?php if ($autoridades_escolares->Apellido_Nombre->Visible) { // Apellido_Nombre ?>
		<td data-name="Apellido_Nombre">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<span id="el$rowindex$_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<input type="text" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Apellido_Nombre->EditValue ?>"<?php echo $autoridades_escolares->Apellido_Nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_autoridades_escolares_Apellido_Nombre" class="form-group autoridades_escolares_Apellido_Nombre">
<span<?php echo $autoridades_escolares->Apellido_Nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $autoridades_escolares->Apellido_Nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Apellido_Nombre" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Apellido_Nombre" value="<?php echo ew_HtmlEncode($autoridades_escolares->Apellido_Nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<span id="el$rowindex$_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<input type="text" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Cuil->EditValue ?>"<?php echo $autoridades_escolares->Cuil->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_autoridades_escolares_Cuil" class="form-group autoridades_escolares_Cuil">
<span<?php echo $autoridades_escolares->Cuil->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $autoridades_escolares->Cuil->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Cuil" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Cuil" value="<?php echo ew_HtmlEncode($autoridades_escolares->Cuil->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Cargo->Visible) { // Id_Cargo ?>
		<td data-name="Id_Cargo">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<span id="el$rowindex$_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<select data-table="autoridades_escolares" data-field="x_Id_Cargo" data-value-separator="<?php echo $autoridades_escolares->Id_Cargo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo"<?php echo $autoridades_escolares->Id_Cargo->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Cargo->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo $autoridades_escolares->Id_Cargo->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_autoridades_escolares_Id_Cargo" class="form-group autoridades_escolares_Id_Cargo">
<span<?php echo $autoridades_escolares->Id_Cargo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $autoridades_escolares->Id_Cargo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Cargo" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Cargo" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Cargo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Id_Turno->Visible) { // Id_Turno ?>
		<td data-name="Id_Turno">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<span id="el$rowindex$_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<select data-table="autoridades_escolares" data-field="x_Id_Turno" data-value-separator="<?php echo $autoridades_escolares->Id_Turno->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno"<?php echo $autoridades_escolares->Id_Turno->EditAttributes() ?>>
<?php echo $autoridades_escolares->Id_Turno->SelectOptionListHtml("x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno") ?>
</select>
<input type="hidden" name="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="s_x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo $autoridades_escolares->Id_Turno->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_autoridades_escolares_Id_Turno" class="form-group autoridades_escolares_Id_Turno">
<span<?php echo $autoridades_escolares->Id_Turno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $autoridades_escolares->Id_Turno->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Id_Turno" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Id_Turno" value="<?php echo ew_HtmlEncode($autoridades_escolares->Id_Turno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<span id="el$rowindex$_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<input type="text" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" size="30" placeholder="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->getPlaceHolder()) ?>" value="<?php echo $autoridades_escolares->Telefono->EditValue ?>"<?php echo $autoridades_escolares->Telefono->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_autoridades_escolares_Telefono" class="form-group autoridades_escolares_Telefono">
<span<?php echo $autoridades_escolares->Telefono->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $autoridades_escolares->Telefono->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Telefono" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Telefono" value="<?php echo ew_HtmlEncode($autoridades_escolares->Telefono->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Fecha_Actualizacion" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($autoridades_escolares->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($autoridades_escolares->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<?php if ($autoridades_escolares->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" id="x<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="autoridades_escolares" data-field="x_Usuario" name="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" id="o<?php echo $autoridades_escolares_grid->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($autoridades_escolares->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$autoridades_escolares_grid->ListOptions->Render("body", "right", $autoridades_escolares_grid->RowCnt);
?>
<script type="text/javascript">
fautoridades_escolaresgrid.UpdateOpts(<?php echo $autoridades_escolares_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($autoridades_escolares->CurrentMode == "add" || $autoridades_escolares->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $autoridades_escolares_grid->FormKeyCountName ?>" id="<?php echo $autoridades_escolares_grid->FormKeyCountName ?>" value="<?php echo $autoridades_escolares_grid->KeyCount ?>">
<?php echo $autoridades_escolares_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($autoridades_escolares->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $autoridades_escolares_grid->FormKeyCountName ?>" id="<?php echo $autoridades_escolares_grid->FormKeyCountName ?>" value="<?php echo $autoridades_escolares_grid->KeyCount ?>">
<?php echo $autoridades_escolares_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($autoridades_escolares->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fautoridades_escolaresgrid">
</div>
<?php

// Close recordset
if ($autoridades_escolares_grid->Recordset)
	$autoridades_escolares_grid->Recordset->Close();
?>
<?php if ($autoridades_escolares_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($autoridades_escolares_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($autoridades_escolares_grid->TotalRecs == 0 && $autoridades_escolares->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($autoridades_escolares_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($autoridades_escolares->Export == "") { ?>
<script type="text/javascript">
fautoridades_escolaresgrid.Init();
</script>
<?php } ?>
<?php
$autoridades_escolares_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$autoridades_escolares_grid->Page_Terminate();
?>
