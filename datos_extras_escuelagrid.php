<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($datos_extras_escuela_grid)) $datos_extras_escuela_grid = new cdatos_extras_escuela_grid();

// Page init
$datos_extras_escuela_grid->Page_Init();

// Page main
$datos_extras_escuela_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datos_extras_escuela_grid->Page_Render();
?>
<?php if ($datos_extras_escuela->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdatos_extras_escuelagrid = new ew_Form("fdatos_extras_escuelagrid", "grid");
fdatos_extras_escuelagrid.FormKeyCountName = '<?php echo $datos_extras_escuela_grid->FormKeyCountName ?>';

// Validate form
fdatos_extras_escuelagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Usuario_Conig");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Usuario_Conig->FldCaption(), $datos_extras_escuela->Usuario_Conig->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password_Conig");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Password_Conig->FldCaption(), $datos_extras_escuela->Password_Conig->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tiene_Internet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Tiene_Internet->FldCaption(), $datos_extras_escuela->Tiene_Internet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Internet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datos_extras_escuela->Estado_Internet->FldCaption(), $datos_extras_escuela->Estado_Internet->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdatos_extras_escuelagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Cue", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Usuario_Conig", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Password_Conig", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tiene_Internet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Servicio_Internet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Internet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Quien_Paga", false)) return false;
	return true;
}

// Form_CustomValidate event
fdatos_extras_escuelagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdatos_extras_escuelagrid.ValidateRequired = true;
<?php } else { ?>
fdatos_extras_escuelagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdatos_extras_escuelagrid.Lists["x_Tiene_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelagrid.Lists["x_Tiene_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Tiene_Internet->Options()) ?>;
fdatos_extras_escuelagrid.Lists["x_Estado_Internet"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdatos_extras_escuelagrid.Lists["x_Estado_Internet"].Options = <?php echo json_encode($datos_extras_escuela->Estado_Internet->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($datos_extras_escuela->CurrentAction == "gridadd") {
	if ($datos_extras_escuela->CurrentMode == "copy") {
		$bSelectLimit = $datos_extras_escuela_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$datos_extras_escuela_grid->TotalRecs = $datos_extras_escuela->SelectRecordCount();
			$datos_extras_escuela_grid->Recordset = $datos_extras_escuela_grid->LoadRecordset($datos_extras_escuela_grid->StartRec-1, $datos_extras_escuela_grid->DisplayRecs);
		} else {
			if ($datos_extras_escuela_grid->Recordset = $datos_extras_escuela_grid->LoadRecordset())
				$datos_extras_escuela_grid->TotalRecs = $datos_extras_escuela_grid->Recordset->RecordCount();
		}
		$datos_extras_escuela_grid->StartRec = 1;
		$datos_extras_escuela_grid->DisplayRecs = $datos_extras_escuela_grid->TotalRecs;
	} else {
		$datos_extras_escuela->CurrentFilter = "0=1";
		$datos_extras_escuela_grid->StartRec = 1;
		$datos_extras_escuela_grid->DisplayRecs = $datos_extras_escuela->GridAddRowCount;
	}
	$datos_extras_escuela_grid->TotalRecs = $datos_extras_escuela_grid->DisplayRecs;
	$datos_extras_escuela_grid->StopRec = $datos_extras_escuela_grid->DisplayRecs;
} else {
	$bSelectLimit = $datos_extras_escuela_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($datos_extras_escuela_grid->TotalRecs <= 0)
			$datos_extras_escuela_grid->TotalRecs = $datos_extras_escuela->SelectRecordCount();
	} else {
		if (!$datos_extras_escuela_grid->Recordset && ($datos_extras_escuela_grid->Recordset = $datos_extras_escuela_grid->LoadRecordset()))
			$datos_extras_escuela_grid->TotalRecs = $datos_extras_escuela_grid->Recordset->RecordCount();
	}
	$datos_extras_escuela_grid->StartRec = 1;
	$datos_extras_escuela_grid->DisplayRecs = $datos_extras_escuela_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$datos_extras_escuela_grid->Recordset = $datos_extras_escuela_grid->LoadRecordset($datos_extras_escuela_grid->StartRec-1, $datos_extras_escuela_grid->DisplayRecs);

	// Set no record found message
	if ($datos_extras_escuela->CurrentAction == "" && $datos_extras_escuela_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$datos_extras_escuela_grid->setWarningMessage(ew_DeniedMsg());
		if ($datos_extras_escuela_grid->SearchWhere == "0=101")
			$datos_extras_escuela_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$datos_extras_escuela_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$datos_extras_escuela_grid->RenderOtherOptions();
?>
<?php $datos_extras_escuela_grid->ShowPageHeader(); ?>
<?php
$datos_extras_escuela_grid->ShowMessage();
?>
<?php if ($datos_extras_escuela_grid->TotalRecs > 0 || $datos_extras_escuela->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid datos_extras_escuela">
<div id="fdatos_extras_escuelagrid" class="ewForm form-inline">
<?php if ($datos_extras_escuela_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($datos_extras_escuela_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_datos_extras_escuela" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_datos_extras_escuelagrid" class="table ewTable">
<?php echo $datos_extras_escuela->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$datos_extras_escuela_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$datos_extras_escuela_grid->RenderListOptions();

// Render list options (header, left)
$datos_extras_escuela_grid->ListOptions->Render("header", "left");
?>
<?php if ($datos_extras_escuela->Cue->Visible) { // Cue ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Cue) == "") { ?>
		<th data-name="Cue"><div id="elh_datos_extras_escuela_Cue" class="datos_extras_escuela_Cue"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Cue->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cue"><div><div id="elh_datos_extras_escuela_Cue" class="datos_extras_escuela_Cue">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Cue->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Cue->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Cue->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Usuario_Conig->Visible) { // Usuario_Conig ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Usuario_Conig) == "") { ?>
		<th data-name="Usuario_Conig"><div id="elh_datos_extras_escuela_Usuario_Conig" class="datos_extras_escuela_Usuario_Conig"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Usuario_Conig->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario_Conig"><div><div id="elh_datos_extras_escuela_Usuario_Conig" class="datos_extras_escuela_Usuario_Conig">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Usuario_Conig->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Usuario_Conig->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Usuario_Conig->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Password_Conig->Visible) { // Password_Conig ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Password_Conig) == "") { ?>
		<th data-name="Password_Conig"><div id="elh_datos_extras_escuela_Password_Conig" class="datos_extras_escuela_Password_Conig"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Password_Conig->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Password_Conig"><div><div id="elh_datos_extras_escuela_Password_Conig" class="datos_extras_escuela_Password_Conig">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Password_Conig->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Password_Conig->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Password_Conig->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Tiene_Internet->Visible) { // Tiene_Internet ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Tiene_Internet) == "") { ?>
		<th data-name="Tiene_Internet"><div id="elh_datos_extras_escuela_Tiene_Internet" class="datos_extras_escuela_Tiene_Internet"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Tiene_Internet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tiene_Internet"><div><div id="elh_datos_extras_escuela_Tiene_Internet" class="datos_extras_escuela_Tiene_Internet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Tiene_Internet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Tiene_Internet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Tiene_Internet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Servicio_Internet->Visible) { // Servicio_Internet ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Servicio_Internet) == "") { ?>
		<th data-name="Servicio_Internet"><div id="elh_datos_extras_escuela_Servicio_Internet" class="datos_extras_escuela_Servicio_Internet"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Servicio_Internet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Servicio_Internet"><div><div id="elh_datos_extras_escuela_Servicio_Internet" class="datos_extras_escuela_Servicio_Internet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Servicio_Internet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Servicio_Internet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Servicio_Internet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Estado_Internet->Visible) { // Estado_Internet ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Estado_Internet) == "") { ?>
		<th data-name="Estado_Internet"><div id="elh_datos_extras_escuela_Estado_Internet" class="datos_extras_escuela_Estado_Internet"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Estado_Internet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Internet"><div><div id="elh_datos_extras_escuela_Estado_Internet" class="datos_extras_escuela_Estado_Internet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Estado_Internet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Estado_Internet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Estado_Internet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Quien_Paga->Visible) { // Quien_Paga ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Quien_Paga) == "") { ?>
		<th data-name="Quien_Paga"><div id="elh_datos_extras_escuela_Quien_Paga" class="datos_extras_escuela_Quien_Paga"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Quien_Paga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Quien_Paga"><div><div id="elh_datos_extras_escuela_Quien_Paga" class="datos_extras_escuela_Quien_Paga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Quien_Paga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Quien_Paga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Quien_Paga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($datos_extras_escuela->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($datos_extras_escuela->SortUrl($datos_extras_escuela->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_datos_extras_escuela_Fecha_Actualizacion" class="datos_extras_escuela_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div><div id="elh_datos_extras_escuela_Fecha_Actualizacion" class="datos_extras_escuela_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datos_extras_escuela->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datos_extras_escuela->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datos_extras_escuela->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$datos_extras_escuela_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$datos_extras_escuela_grid->StartRec = 1;
$datos_extras_escuela_grid->StopRec = $datos_extras_escuela_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($datos_extras_escuela_grid->FormKeyCountName) && ($datos_extras_escuela->CurrentAction == "gridadd" || $datos_extras_escuela->CurrentAction == "gridedit" || $datos_extras_escuela->CurrentAction == "F")) {
		$datos_extras_escuela_grid->KeyCount = $objForm->GetValue($datos_extras_escuela_grid->FormKeyCountName);
		$datos_extras_escuela_grid->StopRec = $datos_extras_escuela_grid->StartRec + $datos_extras_escuela_grid->KeyCount - 1;
	}
}
$datos_extras_escuela_grid->RecCnt = $datos_extras_escuela_grid->StartRec - 1;
if ($datos_extras_escuela_grid->Recordset && !$datos_extras_escuela_grid->Recordset->EOF) {
	$datos_extras_escuela_grid->Recordset->MoveFirst();
	$bSelectLimit = $datos_extras_escuela_grid->UseSelectLimit;
	if (!$bSelectLimit && $datos_extras_escuela_grid->StartRec > 1)
		$datos_extras_escuela_grid->Recordset->Move($datos_extras_escuela_grid->StartRec - 1);
} elseif (!$datos_extras_escuela->AllowAddDeleteRow && $datos_extras_escuela_grid->StopRec == 0) {
	$datos_extras_escuela_grid->StopRec = $datos_extras_escuela->GridAddRowCount;
}

// Initialize aggregate
$datos_extras_escuela->RowType = EW_ROWTYPE_AGGREGATEINIT;
$datos_extras_escuela->ResetAttrs();
$datos_extras_escuela_grid->RenderRow();
if ($datos_extras_escuela->CurrentAction == "gridadd")
	$datos_extras_escuela_grid->RowIndex = 0;
if ($datos_extras_escuela->CurrentAction == "gridedit")
	$datos_extras_escuela_grid->RowIndex = 0;
while ($datos_extras_escuela_grid->RecCnt < $datos_extras_escuela_grid->StopRec) {
	$datos_extras_escuela_grid->RecCnt++;
	if (intval($datos_extras_escuela_grid->RecCnt) >= intval($datos_extras_escuela_grid->StartRec)) {
		$datos_extras_escuela_grid->RowCnt++;
		if ($datos_extras_escuela->CurrentAction == "gridadd" || $datos_extras_escuela->CurrentAction == "gridedit" || $datos_extras_escuela->CurrentAction == "F") {
			$datos_extras_escuela_grid->RowIndex++;
			$objForm->Index = $datos_extras_escuela_grid->RowIndex;
			if ($objForm->HasValue($datos_extras_escuela_grid->FormActionName))
				$datos_extras_escuela_grid->RowAction = strval($objForm->GetValue($datos_extras_escuela_grid->FormActionName));
			elseif ($datos_extras_escuela->CurrentAction == "gridadd")
				$datos_extras_escuela_grid->RowAction = "insert";
			else
				$datos_extras_escuela_grid->RowAction = "";
		}

		// Set up key count
		$datos_extras_escuela_grid->KeyCount = $datos_extras_escuela_grid->RowIndex;

		// Init row class and style
		$datos_extras_escuela->ResetAttrs();
		$datos_extras_escuela->CssClass = "";
		if ($datos_extras_escuela->CurrentAction == "gridadd") {
			if ($datos_extras_escuela->CurrentMode == "copy") {
				$datos_extras_escuela_grid->LoadRowValues($datos_extras_escuela_grid->Recordset); // Load row values
				$datos_extras_escuela_grid->SetRecordKey($datos_extras_escuela_grid->RowOldKey, $datos_extras_escuela_grid->Recordset); // Set old record key
			} else {
				$datos_extras_escuela_grid->LoadDefaultValues(); // Load default values
				$datos_extras_escuela_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$datos_extras_escuela_grid->LoadRowValues($datos_extras_escuela_grid->Recordset); // Load row values
		}
		$datos_extras_escuela->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($datos_extras_escuela->CurrentAction == "gridadd") // Grid add
			$datos_extras_escuela->RowType = EW_ROWTYPE_ADD; // Render add
		if ($datos_extras_escuela->CurrentAction == "gridadd" && $datos_extras_escuela->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$datos_extras_escuela_grid->RestoreCurrentRowFormValues($datos_extras_escuela_grid->RowIndex); // Restore form values
		if ($datos_extras_escuela->CurrentAction == "gridedit") { // Grid edit
			if ($datos_extras_escuela->EventCancelled) {
				$datos_extras_escuela_grid->RestoreCurrentRowFormValues($datos_extras_escuela_grid->RowIndex); // Restore form values
			}
			if ($datos_extras_escuela_grid->RowAction == "insert")
				$datos_extras_escuela->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$datos_extras_escuela->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($datos_extras_escuela->CurrentAction == "gridedit" && ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT || $datos_extras_escuela->RowType == EW_ROWTYPE_ADD) && $datos_extras_escuela->EventCancelled) // Update failed
			$datos_extras_escuela_grid->RestoreCurrentRowFormValues($datos_extras_escuela_grid->RowIndex); // Restore form values
		if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) // Edit row
			$datos_extras_escuela_grid->EditRowCnt++;
		if ($datos_extras_escuela->CurrentAction == "F") // Confirm row
			$datos_extras_escuela_grid->RestoreCurrentRowFormValues($datos_extras_escuela_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$datos_extras_escuela->RowAttrs = array_merge($datos_extras_escuela->RowAttrs, array('data-rowindex'=>$datos_extras_escuela_grid->RowCnt, 'id'=>'r' . $datos_extras_escuela_grid->RowCnt . '_datos_extras_escuela', 'data-rowtype'=>$datos_extras_escuela->RowType));

		// Render row
		$datos_extras_escuela_grid->RenderRow();

		// Render list options
		$datos_extras_escuela_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($datos_extras_escuela_grid->RowAction <> "delete" && $datos_extras_escuela_grid->RowAction <> "insertdelete" && !($datos_extras_escuela_grid->RowAction == "insert" && $datos_extras_escuela->CurrentAction == "F" && $datos_extras_escuela_grid->EmptyRow())) {
?>
	<tr<?php echo $datos_extras_escuela->RowAttributes() ?>>
<?php

// Render list options (body, left)
$datos_extras_escuela_grid->ListOptions->Render("body", "left", $datos_extras_escuela_grid->RowCnt);
?>
	<?php if ($datos_extras_escuela->Cue->Visible) { // Cue ?>
		<td data-name="Cue"<?php echo $datos_extras_escuela->Cue->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($datos_extras_escuela->Cue->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Cue" class="form-group datos_extras_escuela_Cue">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($datos_extras_escuela->Cue->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Cue" class="form-group datos_extras_escuela_Cue">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Cue" class="datos_extras_escuela_Cue">
<span<?php echo $datos_extras_escuela->Cue->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Cue->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->OldValue) ?>">
<?php } ?>
<a id="<?php echo $datos_extras_escuela_grid->PageObjName . "_row_" . $datos_extras_escuela_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Usuario_Conig->Visible) { // Usuario_Conig ?>
		<td data-name="Usuario_Conig"<?php echo $datos_extras_escuela->Usuario_Conig->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Usuario_Conig" class="form-group datos_extras_escuela_Usuario_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Usuario_Conig->EditAttributes() ?>>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Usuario_Conig" class="form-group datos_extras_escuela_Usuario_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Usuario_Conig->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Usuario_Conig" class="datos_extras_escuela_Usuario_Conig">
<span<?php echo $datos_extras_escuela->Usuario_Conig->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Usuario_Conig->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Password_Conig->Visible) { // Password_Conig ?>
		<td data-name="Password_Conig"<?php echo $datos_extras_escuela->Password_Conig->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Password_Conig" class="form-group datos_extras_escuela_Password_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Password_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Password_Conig->EditAttributes() ?>>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Password_Conig" class="form-group datos_extras_escuela_Password_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Password_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Password_Conig->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Password_Conig" class="datos_extras_escuela_Password_Conig">
<span<?php echo $datos_extras_escuela->Password_Conig->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Password_Conig->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Tiene_Internet->Visible) { // Tiene_Internet ?>
		<td data-name="Tiene_Internet"<?php echo $datos_extras_escuela->Tiene_Internet->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Tiene_Internet" class="form-group datos_extras_escuela_Tiene_Internet">
<div id="tp_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" class="ewTemplate"><input type="radio" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" data-value-separator="<?php echo $datos_extras_escuela->Tiene_Internet->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="{value}"<?php echo $datos_extras_escuela->Tiene_Internet->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $datos_extras_escuela->Tiene_Internet->RadioButtonListHtml(FALSE, "x{$datos_extras_escuela_grid->RowIndex}_Tiene_Internet") ?>
</div></div>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Tiene_Internet->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Tiene_Internet" class="form-group datos_extras_escuela_Tiene_Internet">
<div id="tp_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" class="ewTemplate"><input type="radio" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" data-value-separator="<?php echo $datos_extras_escuela->Tiene_Internet->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="{value}"<?php echo $datos_extras_escuela->Tiene_Internet->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $datos_extras_escuela->Tiene_Internet->RadioButtonListHtml(FALSE, "x{$datos_extras_escuela_grid->RowIndex}_Tiene_Internet") ?>
</div></div>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Tiene_Internet" class="datos_extras_escuela_Tiene_Internet">
<span<?php echo $datos_extras_escuela->Tiene_Internet->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Tiene_Internet->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Tiene_Internet->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Tiene_Internet->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Servicio_Internet->Visible) { // Servicio_Internet ?>
		<td data-name="Servicio_Internet"<?php echo $datos_extras_escuela->Servicio_Internet->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Servicio_Internet" class="form-group datos_extras_escuela_Servicio_Internet">
<input type="text" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Servicio_Internet->EditValue ?>"<?php echo $datos_extras_escuela->Servicio_Internet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Servicio_Internet" class="form-group datos_extras_escuela_Servicio_Internet">
<input type="text" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Servicio_Internet->EditValue ?>"<?php echo $datos_extras_escuela->Servicio_Internet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Servicio_Internet" class="datos_extras_escuela_Servicio_Internet">
<span<?php echo $datos_extras_escuela->Servicio_Internet->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Servicio_Internet->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Estado_Internet->Visible) { // Estado_Internet ?>
		<td data-name="Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Estado_Internet" class="form-group datos_extras_escuela_Estado_Internet">
<select data-table="datos_extras_escuela" data-field="x_Estado_Internet" data-value-separator="<?php echo $datos_extras_escuela->Estado_Internet->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->EditAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->SelectOptionListHtml("x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet") ?>
</select>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Estado_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Estado_Internet->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Estado_Internet" class="form-group datos_extras_escuela_Estado_Internet">
<select data-table="datos_extras_escuela" data-field="x_Estado_Internet" data-value-separator="<?php echo $datos_extras_escuela->Estado_Internet->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->EditAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->SelectOptionListHtml("x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet") ?>
</select>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Estado_Internet" class="datos_extras_escuela_Estado_Internet">
<span<?php echo $datos_extras_escuela->Estado_Internet->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Estado_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Estado_Internet->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Estado_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Estado_Internet->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Quien_Paga->Visible) { // Quien_Paga ?>
		<td data-name="Quien_Paga"<?php echo $datos_extras_escuela->Quien_Paga->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Quien_Paga" class="form-group datos_extras_escuela_Quien_Paga">
<input type="text" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Quien_Paga->EditValue ?>"<?php echo $datos_extras_escuela->Quien_Paga->EditAttributes() ?>>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Quien_Paga" class="form-group datos_extras_escuela_Quien_Paga">
<input type="text" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Quien_Paga->EditValue ?>"<?php echo $datos_extras_escuela->Quien_Paga->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Quien_Paga" class="datos_extras_escuela_Quien_Paga">
<span<?php echo $datos_extras_escuela->Quien_Paga->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Quien_Paga->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $datos_extras_escuela->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $datos_extras_escuela_grid->RowCnt ?>_datos_extras_escuela_Fecha_Actualizacion" class="datos_extras_escuela_Fecha_Actualizacion">
<span<?php echo $datos_extras_escuela->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $datos_extras_escuela->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->FormValue) ?>">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$datos_extras_escuela_grid->ListOptions->Render("body", "right", $datos_extras_escuela_grid->RowCnt);
?>
	</tr>
<?php if ($datos_extras_escuela->RowType == EW_ROWTYPE_ADD || $datos_extras_escuela->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdatos_extras_escuelagrid.UpdateOpts(<?php echo $datos_extras_escuela_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($datos_extras_escuela->CurrentAction <> "gridadd" || $datos_extras_escuela->CurrentMode == "copy")
		if (!$datos_extras_escuela_grid->Recordset->EOF) $datos_extras_escuela_grid->Recordset->MoveNext();
}
?>
<?php
	if ($datos_extras_escuela->CurrentMode == "add" || $datos_extras_escuela->CurrentMode == "copy" || $datos_extras_escuela->CurrentMode == "edit") {
		$datos_extras_escuela_grid->RowIndex = '$rowindex$';
		$datos_extras_escuela_grid->LoadDefaultValues();

		// Set row properties
		$datos_extras_escuela->ResetAttrs();
		$datos_extras_escuela->RowAttrs = array_merge($datos_extras_escuela->RowAttrs, array('data-rowindex'=>$datos_extras_escuela_grid->RowIndex, 'id'=>'r0_datos_extras_escuela', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($datos_extras_escuela->RowAttrs["class"], "ewTemplate");
		$datos_extras_escuela->RowType = EW_ROWTYPE_ADD;

		// Render row
		$datos_extras_escuela_grid->RenderRow();

		// Render list options
		$datos_extras_escuela_grid->RenderListOptions();
		$datos_extras_escuela_grid->StartRowCnt = 0;
?>
	<tr<?php echo $datos_extras_escuela->RowAttributes() ?>>
<?php

// Render list options (body, left)
$datos_extras_escuela_grid->ListOptions->Render("body", "left", $datos_extras_escuela_grid->RowIndex);
?>
	<?php if ($datos_extras_escuela->Cue->Visible) { // Cue ?>
		<td data-name="Cue">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<?php if ($datos_extras_escuela->Cue->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Cue" class="form-group datos_extras_escuela_Cue">
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->CurrentValue) ?>">
</span>
<?php } ?>
<?php } else { ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Cue" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Cue->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Usuario_Conig->Visible) { // Usuario_Conig ?>
		<td data-name="Usuario_Conig">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Usuario_Conig" class="form-group datos_extras_escuela_Usuario_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Usuario_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Usuario_Conig->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Usuario_Conig" class="form-group datos_extras_escuela_Usuario_Conig">
<span<?php echo $datos_extras_escuela->Usuario_Conig->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Usuario_Conig->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Usuario_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Usuario_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Usuario_Conig->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Password_Conig->Visible) { // Password_Conig ?>
		<td data-name="Password_Conig">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Password_Conig" class="form-group datos_extras_escuela_Password_Conig">
<input type="text" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Password_Conig->EditValue ?>"<?php echo $datos_extras_escuela->Password_Conig->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Password_Conig" class="form-group datos_extras_escuela_Password_Conig">
<span<?php echo $datos_extras_escuela->Password_Conig->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Password_Conig->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Password_Conig" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Password_Conig" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Password_Conig->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Tiene_Internet->Visible) { // Tiene_Internet ?>
		<td data-name="Tiene_Internet">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Tiene_Internet" class="form-group datos_extras_escuela_Tiene_Internet">
<div id="tp_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" class="ewTemplate"><input type="radio" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" data-value-separator="<?php echo $datos_extras_escuela->Tiene_Internet->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="{value}"<?php echo $datos_extras_escuela->Tiene_Internet->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $datos_extras_escuela->Tiene_Internet->RadioButtonListHtml(FALSE, "x{$datos_extras_escuela_grid->RowIndex}_Tiene_Internet") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Tiene_Internet" class="form-group datos_extras_escuela_Tiene_Internet">
<span<?php echo $datos_extras_escuela->Tiene_Internet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Tiene_Internet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Tiene_Internet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Tiene_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Tiene_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Tiene_Internet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Servicio_Internet->Visible) { // Servicio_Internet ?>
		<td data-name="Servicio_Internet">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Servicio_Internet" class="form-group datos_extras_escuela_Servicio_Internet">
<input type="text" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Servicio_Internet->EditValue ?>"<?php echo $datos_extras_escuela->Servicio_Internet->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Servicio_Internet" class="form-group datos_extras_escuela_Servicio_Internet">
<span<?php echo $datos_extras_escuela->Servicio_Internet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Servicio_Internet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Servicio_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Servicio_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Servicio_Internet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Estado_Internet->Visible) { // Estado_Internet ?>
		<td data-name="Estado_Internet">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Estado_Internet" class="form-group datos_extras_escuela_Estado_Internet">
<select data-table="datos_extras_escuela" data-field="x_Estado_Internet" data-value-separator="<?php echo $datos_extras_escuela->Estado_Internet->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet"<?php echo $datos_extras_escuela->Estado_Internet->EditAttributes() ?>>
<?php echo $datos_extras_escuela->Estado_Internet->SelectOptionListHtml("x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Estado_Internet" class="form-group datos_extras_escuela_Estado_Internet">
<span<?php echo $datos_extras_escuela->Estado_Internet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Estado_Internet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Estado_Internet" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Estado_Internet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Estado_Internet" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Estado_Internet" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Estado_Internet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Quien_Paga->Visible) { // Quien_Paga ?>
		<td data-name="Quien_Paga">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<span id="el$rowindex$_datos_extras_escuela_Quien_Paga" class="form-group datos_extras_escuela_Quien_Paga">
<input type="text" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->getPlaceHolder()) ?>" value="<?php echo $datos_extras_escuela->Quien_Paga->EditValue ?>"<?php echo $datos_extras_escuela->Quien_Paga->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Quien_Paga" class="form-group datos_extras_escuela_Quien_Paga">
<span<?php echo $datos_extras_escuela->Quien_Paga->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Quien_Paga->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Quien_Paga" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Quien_Paga" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Quien_Paga->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($datos_extras_escuela->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<?php if ($datos_extras_escuela->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_datos_extras_escuela_Fecha_Actualizacion" class="form-group datos_extras_escuela_Fecha_Actualizacion">
<span<?php echo $datos_extras_escuela->Fecha_Actualizacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datos_extras_escuela->Fecha_Actualizacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" id="x<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="datos_extras_escuela" data-field="x_Fecha_Actualizacion" name="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $datos_extras_escuela_grid->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($datos_extras_escuela->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$datos_extras_escuela_grid->ListOptions->Render("body", "right", $datos_extras_escuela_grid->RowCnt);
?>
<script type="text/javascript">
fdatos_extras_escuelagrid.UpdateOpts(<?php echo $datos_extras_escuela_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($datos_extras_escuela->CurrentMode == "add" || $datos_extras_escuela->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $datos_extras_escuela_grid->FormKeyCountName ?>" id="<?php echo $datos_extras_escuela_grid->FormKeyCountName ?>" value="<?php echo $datos_extras_escuela_grid->KeyCount ?>">
<?php echo $datos_extras_escuela_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($datos_extras_escuela->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $datos_extras_escuela_grid->FormKeyCountName ?>" id="<?php echo $datos_extras_escuela_grid->FormKeyCountName ?>" value="<?php echo $datos_extras_escuela_grid->KeyCount ?>">
<?php echo $datos_extras_escuela_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($datos_extras_escuela->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdatos_extras_escuelagrid">
</div>
<?php

// Close recordset
if ($datos_extras_escuela_grid->Recordset)
	$datos_extras_escuela_grid->Recordset->Close();
?>
<?php if ($datos_extras_escuela_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($datos_extras_escuela_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($datos_extras_escuela_grid->TotalRecs == 0 && $datos_extras_escuela->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datos_extras_escuela_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($datos_extras_escuela->Export == "") { ?>
<script type="text/javascript">
fdatos_extras_escuelagrid.Init();
</script>
<?php } ?>
<?php
$datos_extras_escuela_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$datos_extras_escuela_grid->Page_Terminate();
?>
